<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/25/2020
 * Time: 3:59 PM
 */

namespace RwandaBuild\MurugoAuth;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use RwandaBuild\MurugoAuth\Exceptions\MurugoAuthDenied;
use RwandaBuild\MurugoAuth\Exceptions\MurugoAuthException;
use RwandaBuild\MurugoAuth\Exceptions\MurugoInvalidSateRequest;
use RwandaBuild\MurugoAuth\Models\MurugoUser;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class MurugoAuthHandler
{
    /**
     * This variable will be used to set dynamic foreign key on user model
     */
    public static $foreignKey = 'murugo_user_id';

    /**
     * S-03: the request that stateless() was called for. The state check is skipped only for the
     * next user() call on that same request, then this is cleared, so in a long-running process
     * (Octane, queue workers) one stateless login can't switch the check off for later logins.
     * @var \Illuminate\Http\Request|null
     */
    protected static $statelessRequest = null;

    /**
     * authentication info of this application to murugo
     */
    public $appInfo;

    /**
     * current request
     */
    public $request;

    /**
     * @var \GuzzleHttp\Client
     */
    public $httpClient;

    /**
     * token fetched from murugo
     * @var array
     */
    public $userTokens;


    /** Using password token grant */
    public $disableUserSession = false;

    /**
     * Dynamic redirect url
     */
    public static $redirectUrl;

    /**
     * HTTP client used instead of a new one (tests only), see useHttpClient()
     * @var \GuzzleHttp\Client|null
     */
    protected static $httpClientOverride = null;

    /**
     * initialize the class
     */
    public function __construct()
    {
        $this->appInfo = config('services.murugo');
        $this->request = request();
        $this->httpClient = static::$httpClientOverride ?: new Client([
            // S-11: never wait forever for Murugo (Guzzle's default is no timeout)
            'connect_timeout' => (float) ($this->appInfo['connect_timeout'] ?? 5),
            'timeout' => (float) ($this->appInfo['timeout'] ?? 15),
        ]);

        $this->disableUserSession = config('services.murugo.disable_user_session') ?? false;
    }

    /**
     * Build instance of the class, to allow to access on none static function
     */
    public static function init()
    {
        return new self;
    }

    /**
     * redirect user to murugo auth
     */
    public static function redirect()
    {
        $auth = static::init();
        $auth->request->session()
            ->put('murugo_auth_state', $state = Str::random(40));

        $query = http_build_query(
            $auth->formatAuthorizationQuery($state)
        );

        $authorizeURL = $auth->disableUserSession
            ? '/oauth/authorize-first-party?'
            : '/oauth/authorize?';

        return redirect()->away($auth->murugoUrl($authorizeURL) . $query);
    }

    /**
     * define weather the class can user request session
     */
    public static function stateless()
    {
        self::$statelessRequest = request();

        return new static;
    }

    /**
     * get user from a provided his authorized code
     * @param $userCallback the callback function to be called when the request is successful
     */
    public static function user($userCallback = null)
    {
        //return instance of current class in this case MurugoAuthHandler
        $auth = self::init();
        //check the status of the request
        $auth->checkRequestState();
        //request user tokens
        $userTokens = $auth->requestUserToken();
        //Return user object with those tokens
        return $auth->userFromToken($userTokens, $userCallback);
    }

    /**
     * Check request state if is valid
     */
    private function checkRequestState()
    {
        // S-03: stateless() applies once, and only to the request it was called in
        $stateless = self::$statelessRequest !== null && self::$statelessRequest === $this->request;
        self::$statelessRequest = null;

        if ($stateless) return;

        $state = $this->request->session()->pull('murugo_auth_state');

        // when error occurred, redirect to welcome page
        if ($this->request->error) {
            $message = "Murugo Access denied";
            $view = view('murugo::error', compact('message'))->render();

            throw new HttpResponseException(response($view, Response::HTTP_INTERNAL_SERVER_ERROR));
        }

        // when request state doesn't match, redirect to auth server
        if (!$state) {
            $message = "Invalid request state , Please try again!";
            $view = view('murugo::error', compact('message'))->render();

            throw new HttpResponseException(response($view, Response::HTTP_INTERNAL_SERVER_ERROR));
        }

        if ($state != $this->request->state) {
            $message = "Wrong request state , Please try again!";
            $view = view('murugo::error', compact('message'))->render();

            throw new HttpResponseException(response($view, Response::HTTP_INTERNAL_SERVER_ERROR));
        }

        return;
    }

    /**
     * Request for the user access token on murugo using user's
     * authorized code
     */
    public function requestUserToken()
    {
        $url = $this->murugoUrl('/oauth/token');

        try {
            $response = $this->httpClient->post($url, [
                'headers' => [
                    'accept' => 'application/json',
                    'APPKEY' => $this->appInfo['murugo_app_key'],
                    'AUTHVERSION' => 2
                ],
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => $this->appInfo['client_id'],
                    'client_secret' => $this->appInfo['client_secret'],
                    'redirect_uri' => $this->getRedirectUrl(),
                    'code' => $this->request->code,
                ],
            ]);

            return json_decode((string)$response->getBody(), true);
        } catch (ClientException $exception) {
            self::fireError($exception);
        } catch (ConnectException $exception) {
            self::fireConnectError($exception);
        }
    }

    /**
     * get user info from a provided token
     *
     * @param array $userTokens
     * @return object
     * @throws \Exception
     * @internal param $accessToken
     */
    public static function userFromToken(array $userTokens, $userCallback = null)
    {
        $auth = self::init();
        $url = $auth->murugoUrl('/api/thirdparty-me');

        try {
            $response = $auth->httpClient->get($url, [
                'headers' => [
                    'accept' => 'application/json',
                    'APPKEY' => $auth->appInfo['murugo_app_key'],
                    'Authorization' => 'Bearer ' . $userTokens['access_token']
                ]
            ]);

            $userBundle = json_decode((string)$response->getBody(), true);
            $murugoUser = MurugoUserFormatter::get($userBundle, $userTokens);

            if (!is_callable($userCallback)) return $murugoUser;

            $userDetails = MurugoUserFormatter::getUserDetails(
                $userBundle
            );

            return $userCallback($murugoUser, $userDetails);
        } catch (ClientException $exception) {
            self::fireError($exception);
        } catch (ConnectException $exception) {
            self::fireConnectError($exception);
        }
    }

    /**
     * Throw guzzle request error that occurs in a friendly way
     * @param $exception
     * @throws MurugoAuthException
     */
    private static function fireError($exception)
    {
        $response = $exception->getResponse();
        $statusCode = $response->getStatusCode();

        // S-12: Guzzle's message holds the Murugo URL and the start of its response body.
        // Show a generic message; the details go to the log through the previous exception.
        $message = in_array($statusCode, [401, 403])
            ? 'Murugo login failed. Please sign in again.'
            : 'Murugo login could not be completed. Please try again.';

        throw new MurugoAuthException($message, $statusCode, $exception);
    }

    /**
     * S-12: Murugo could not be reached (DNS, timeout, refused). Generic message for the user,
     * cURL details in the log.
     * @throws MurugoAuthException
     */
    private static function fireConnectError($exception)
    {
        throw new MurugoAuthException('Murugo is unreachable right now. Please try again later.', 503, $exception);
    }

    /**
     * This function is used to get refreshToken of certain user
     * @param MurugoUser $murugoUser
     * @return MurugoUser
     * @throws \Exception
     */
    public static function refreshToken(MurugoUser $murugoUser)
    {
        try {
            $auth = self::init();
            $url = $auth->murugoUrl('/oauth/token');

            $response = $auth->httpClient->post($url, [
                'headers' => [
                    'accept' => 'application/json',
                    'APPKEY' => $auth->appInfo['murugo_app_key'],
                ],
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $murugoUser->refresh_token,
                    'client_id' => $auth->appInfo['client_id'],
                    'client_secret' => $auth->appInfo['client_secret'],
                    'scope' => '',
                ],
            ]);

            $tokens = json_decode((string)$response->getBody(), true);

            return MurugoUserFormatter::updateAccessToken($murugoUser, $tokens);
        } catch (ClientException $exception) {
            self::fireError($exception);
        } catch (ConnectException $exception) {
            self::fireConnectError($exception);
        }
    }

    /**
     * Log the user out of Murugo for this app (SSO logout):
     *  - Murugo revokes this app's token for the user and ends the Murugo browser session
     *    the user logged in from; other apps and other browsers are not affected
     *  - the tokens stored on $murugoUser are cleared
     * Call it from your logout route, then log the user out of your own app as usual.
     * If the token has expired it is refreshed once first.
     *
     * @return bool true when Murugo confirmed the logout; false when it couldn't be reached or
     *              refused (the local tokens are cleared anyway; the reason is logged)
     */
    public static function logout(MurugoUser $murugoUser): bool
    {
        $auth = self::init();

        try {
            try {
                $auth->requestSsoLogout($murugoUser->token);
            } catch (ClientException $exception) {
                if ($exception->getResponse()->getStatusCode() !== 401 || !$murugoUser->refresh_token) {
                    throw $exception;
                }

                // access token expired: refresh once and retry
                $murugoUser = self::refreshToken($murugoUser);
                $auth->requestSsoLogout($murugoUser->token);
            }

            $done = true;
        } catch (\Throwable $exception) {
            $previous = $exception->getPrevious() ?: $exception;
            Log::warning('Murugo Auth: SSO logout failed', ['murugo_user_id' => $murugoUser->id, 'murugo_error' => $previous->getMessage()]);
            $done = false;
        }

        $murugoUser->forceFill(['token' => '', 'refresh_token' => null, 'token_expires_at' => null])->save();

        return $done;
    }

    /**
     * POST /api/thirdparty-sso-logout on Murugo with the user's access token
     */
    private function requestSsoLogout($accessToken)
    {
        return $this->httpClient->post($this->murugoUrl('/api/thirdparty-sso-logout'), [
            'headers' => [
                'accept' => 'application/json',
                'APPKEY' => $this->appInfo['murugo_app_key'],
                'Authorization' => 'Bearer ' . $accessToken,
            ],
        ]);
    }

    /**
     * S-11: full Murugo URL for $path, joined the same way everywhere (a trailing slash on
     * MURUGO_URL or a missing one on $path gives one slash). Fails clearly when MURUGO_URL is
     * not set to an http(s) URL, instead of sending requests to a relative or made-up address.
     * @throws MurugoAuthException
     */
    public function murugoUrl(string $path = ''): string
    {
        $base = rtrim(trim((string) ($this->appInfo['murugo_url'] ?? '')), '/');

        if (!preg_match('#^https?://[^/?\#\s]+#i', $base)) {
            Log::error('Murugo Auth: services.murugo.murugo_url (MURUGO_URL) is missing or is not an http(s) URL');

            throw new MurugoAuthException('Murugo login is not available right now. Please try again later.', 500);
        }

        return $path === '' ? $base : $base . '/' . ltrim($path, '/');
    }

    /**
     * Use this HTTP client instead of a new one (tests: a Guzzle MockHandler). null = default.
     */
    public static function useHttpClient(?Client $client = null)
    {
        static::$httpClientOverride = $client;
    }

    /**
     * Function that sets the foreign key
     * @param $value
     * @return mixed
     */
    public static function setForeignKey($value)
    {
        return self::$foreignKey = $value;
    }

    /**
     * Function that get the value of the foreign key
     */
    public static function getForeignKey()
    {
        return self::$foreignKey;
    }

    /**
     * Format thirdparty authorization query
     * @param string $state
     */
    protected function formatAuthorizationQuery(string $state)
    {
        return [
            'response_type' => 'code',
            'client_id' => $this->appInfo['client_id'],
            'redirect_uri' => $this->getRedirectUrl(),
            'app_key' => $this->appInfo['murugo_app_key'],
            'scope' => '',
            'state' => $state,
        ];
    }

    /**
     * Set the redirect url in a more dynamic way
     * The authentication will work only when the provided redirect url is accepted by the OAUTH Server
     * @param string $redirectUrl
     * @return static
     */
    public static function setRedirectUrl(string $redirectUrl = null)
    {
        if (!$redirectUrl) return new static;

        self::$redirectUrl = $redirectUrl;

        return new static;
    }

    /**
     * Get the redirect url
     * This will return a dynamic url or fallback to the default configuration
     * @return string
     */
    public function getRedirectUrl()
    {
        return self::$redirectUrl ?? $this->appInfo['redirect'];
    }
}
