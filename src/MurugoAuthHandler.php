<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/25/2020
 * Time: 3:59 PM
 */

namespace RwandaBuild\MurugoAuth;

use GuzzleHttp\Client;
use Illuminate\Support\Str;
use RwandaBuild\MurugoAuth\Exceptions\MurugoAuthDenied;
use RwandaBuild\MurugoAuth\Exceptions\MurugoInvalidSateRequest;

class MurugoAuthHandler
{
    /**
     * define weather request session will don't be used
     */
    protected static $stateLess = false;

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

    /**
     * initialize the class
     */
    public function __construct()
    {
        $this->appInfo = config('services.murugo');
        $this->request = request();
        $this->httpClient = new Client;
    }

    /**
     * build instance of the class
     */
    public static function init()
    {
        return new MurugoAuthHandler();;
    }

    /**
     * redirect user to murugo auth
     */
    public static function redirect()
    {
        $auth = self::init();
        $auth->request->session()
            ->put('murugo_auth_state', $state = Str::random(40));

        $query = http_build_query([
            'client_id' => $auth->appInfo['client_id'],
            'redirect_uri' => $auth->appInfo['redirect'],
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
        ]);

        return redirect()->away($auth->appInfo['murugo_url'] . '/oauth/authorize?' . $query);
    }

    /**
     * define weather the class can user request session
     */
    public static function stateless()
    {
        static::$stateLess = true;

        return new static;
    }

    /**
     * get user from a provided his authorized code
     */
    public static function user()
    {
        $auth = self::init();
        $userTokens = $auth->checkRequestState()
            ->requestUserToken();

        return $auth->userFromToken($userTokens['access_token']);
    }

    /**
     * Check request state if is valid
     */
    private function checkRequestState()
    {
        if (static::$stateLess) return new static;

        $state = $this->request->session()->pull('murgo_auth_state');

        // when error occured, redirect to welcome page
        if ($this->request->error) {
            throw new MurugoAuthDenied('Murugo Access denied');
        }

        // when request state doesn't match, redirect to auth server
        if (strlen($state) > 0 && $state === $this->request->state) {
            throw new MurugoInvalidSateRequest('Wrong request state');
        }

        return new static;
    }

    /**
     * Request for the user access token on murugo using user's
     * authorized code
     */
    public function requestUserToken()
    {
        $url = $this->appInfo['murugo_url'] . '/oauth/token';

        $response = $this->httpClient->post($url, [
            'headers' => ['accept' => 'application/json'],
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $this->appInfo['client_id'],
                'client_secret' => $this->appInfo['client_secret'],
                'redirect_uri' => $this->appInfo['redirect'],
                'code' => $this->request->code,
            ],
        ]);

        return json_decode((string)$response->getBody(), true);
    }

    /**
     * get user info from a provided token
     *
     * @param $accessToken
     * @return object
     */
    public static function userFromToken($accessToken)
    {
        $url = self::init()->appInfo['murugo_url'] . '/api/third-party/user';

        $response = self::init()->httpClient->get($url, [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken
            ]
        ]);

        $userBundle = json_decode((string)$response->getBody(), true);

        return MurugoUserFormatter::get($userBundle, $accessToken);
    }
}




