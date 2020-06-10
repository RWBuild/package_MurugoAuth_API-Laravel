<?php

namespace RwandaBuild\MurugoAuth\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use RwandaBuild\MurugoAuth\Exceptions\MurugoAuthException;
use RwandaBuild\MurugoAuth\Models\MurugoOneTimeToken;
use RwandaBuild\MurugoAuth\Models\MurugoUser;
use RwandaBuild\MurugoAuth\Http\Resources\MurugoUserResource;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use App\Http\Controllers\Controller;

class AuthenticationController extends Controller
{

    /**
     * Function than receive response object of murugo server
     * Check if user exist and save it if it does not
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getMurugoResponse(Request $request)
    {
        if (!isset($request->murugo_user_id)) {
            return response(['error' => 'Oops, murugo_user_id is required'], 400);
        } elseif (!isset($request->murugo_user_account_name)) {
            return response(['error' => 'Oops, murugo_user_account_name is required'], 400);
        } elseif (!isset($request->murugo_access_token)) {
            return response(['error' => 'Oops, murugo_access_token is required'], 400);
        } else {

            //Grab object
            $userObject = MurugoUser::where('murugo_user_id', '=', $request->murugo_user_id)->first();
            if (!$userObject) {
                //Save user in database
                $murugoUser = $this->saveUser($request);
                //Create MurugoOneTimeToken
                $murugoOneTimeTokenObject = $this->createMurugoOneTimeToken($murugoUser);
                $murugoOneTimeToken = $murugoOneTimeTokenObject->token;

                return response(['response' => $murugoOneTimeToken], 200);
            }

            $userId = $userObject->id;

            //Update the user with new access_token
            MurugoUser::where('id', $userId)
                ->update([
                    'token' => $request->murugo_access_token,
                    'murugo_user_public_name' => $request->murugo_user_public_name,
                    'murugo_user_avatar' => $request->murugo_user_avatar,
                    'token_expires_at' => $request->expires_at
                ]);

            //Create MurugoOneTimeToken
            $murugoOneTimeTokenObject = $this->createMurugoOneTimeToken($userObject);
            $murugoOneTimeToken = $murugoOneTimeTokenObject->token;

            return response(['response' => $murugoOneTimeToken], 200);
        }
    }


    /**
     * This helper function which will create onetimeToken of the user
     * @param MurugoUser $murugoUser
     * @return \Illuminate\Database\Eloquent\Model
     * @internal param Request $request
     */
    private function createMurugoOneTimeToken(MurugoUser $murugoUser)
    {
        $this->deleteMurugoOneTimeToken($murugoUser);
        $expires_at = Carbon::now()->addMinutes(5);
        $token = bin2hex(openssl_random_pseudo_bytes(20));
        return $murugoUser->murugo_one_time_tokens()->create(['expires_at' => $expires_at, 'one_time_token' => $token]);
    }

    /**
     * This helper function which will delete onetimeToken of the user
     * @param MurugoUser $murugoUser
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @internal param Request $request
     */
    private function deleteMurugoOneTimeToken(MurugoUser $murugoUser)
    {
        return $murugoUser->murugo_one_time_tokens()->delete();
    }

    /**
     * This helper function that saves user in database
     * @param Request $request
     * @return MurugoUser
     */
    public function saveUser(Request $request)
    {
        $user = new MurugoUser();
        $user->name = $request->murugo_user_account_name;
        $user->murugo_user_id = $request->murugo_user_id;
        $user->token = $request->murugo_access_token;
        $user->token_expires_at = $request->expires_at;
        $user->murugo_user_avatar = $request->murugo_user_avatar;
        $user->murugo_user_public_name = $request->murugo_user_public_name;
        $user->save();
        return $user;
    }

    /**
     * Function than gets the token of current logging in user
     * Check if that token exist and get user belongs to that token
     * If token is not exist, mostly for new user, create new user and set token as well
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function authenticateUser(Request $request)
    {
        $otToken = $request->ottoken;

        $murugoOneTimeToken = self::checkOneTimeToken($otToken);

        if (!$murugoOneTimeToken) {
            return response(['response' => 'Token not found'], 404);
        }

        $murugoUser = $murugoOneTimeToken->murugo_user;

        return response(['response' => new MurugoUserResource($murugoUser)], 200);
    }

    /**
     * Function than check if OneTimeToken is valid, if it exists, and if it never been used
     * @param $otToken
     * @return
     */
    private static function checkOneTimeToken($otToken)
    {
        return MurugoOneTimeToken::where('one_time_token', $otToken)
            ->where('expires_at', '>=', Carbon::now())
            ->where('is_used', false)->first();

    }

    /**
     * This function logout user on MurugoCloudCore by destroying token for API structure
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function logoutUser(Request $request)
    {
        $token = $request->token;
        try {
            //Logout on murugo by sending request to murugo to destroy the token
            $client = new Client();
            $response = $client->request('GET', env('MURUGO_URL') . 'api/thirdparty-logout', [
                'headers' => [
                    'Authorization' => "Bearer $token",
                    'Accept' => 'application/json'
                ]
            ]);
            json_decode($response->getBody()->getContents());
            return response(['response' => 'Successfully logged out on murugo'], 200);
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
            $statusCode = $response->getStatusCode();
            $error = json_decode($response->getBody());
            throw new MurugoAuthException($error->message, $statusCode);
        }
    }

    /**
     * This is private custom function that catches error of guzzle for every http request on murugo server
     * @param $exception
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function catchError($exception)
    {
        $response = $exception->getResponse();
        if (!$response) return response('Check your internet connection');
        $statusCode = $response->getStatusCode();
        //$error = json_decode($response->getBody());
        return response($statusCode);
    }

    /**
     * This function will be accessed as facade for getting user object from murugo by help of token
     * @param $token
     * @param null $expires_at
     * @return mixed
     * @throws \Exception
     */
    public static function userFromToken($token, $expires_at = null)
    {

        try {

            $client = new Client();
            $response = $client->request('GET', env('MURUGO_URL') . 'api/thirdparty-me', [
                'headers' => [
                    'Authorization' => "Bearer $token",
                    'Accept' => 'application/json'
                ]
            ]);
            $murugoUser = json_decode($response->getBody()->getContents());

            $userObject = MurugoUser::where('murugo_user_id', '=', $murugoUser->hashed_murugo_user_id)->first();
            if (!$userObject) {
                //Save user in database
                $user = new MurugoUser();
                $user->name = $murugoUser->name;
                $user->murugo_user_id = $murugoUser->hashed_murugo_user_id;
                $user->token = $token;
                $user->token_expires_at = $expires_at;
                $user->murugo_user_avatar = $murugoUser->avatar;
                $user->murugo_user_public_name = $murugoUser->public_name;
                $user->save();
                return $user;
            }

            $userObject->murugo_user_public_name = $murugoUser->public_name;
            $userObject->murugo_user_avatar = $murugoUser->avatar;
            $userObject->save();

            (new AuthenticationController())->createMurugoOneTimeToken($userObject);

            return $userObject->fresh();
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
            $statusCode = $response->getStatusCode();
            $error = json_decode($response->getBody());
            throw new MurugoAuthException($error->message, $statusCode);
        } catch (ConnectException $exception) {
            throw new \Exception($exception->getMessage(), 400);
        }
    }

    /**
     * This function will be accessed as facade for getting user object from murugo by help of UUID
     * @return mixed
     * @throws MurugoAuthException
     * @internal param Request $request
     */
    public static function murugoUser()
    {
        $otToken = request()->ottoken;

        $murugoOneTimeToken = self::checkOneTimeToken($otToken);

        if (!$murugoOneTimeToken) {
            throw new MurugoAuthException("Unauthenticated", 401);
        }

        //delete one time token
        $murugoOneTimeToken->delete();

        return $murugoOneTimeToken->murugo_user;
    }

    /**
     * This function will be accessed as facade for getting user object from murugo by help of token
     * @param $token
     * @return mixed
     * @throws \Exception
     */
    public static function logout($token)
    {
        try {
            //Logout on murugo by sending request to murugo to destroy the token
            $client = new Client();
            $response = $client->request('GET', env('MURUGO_URL') . 'api/thirdparty-logout', [
                'headers' => [
                    'Authorization' => "Bearer $token",
                    'Accept' => 'application/json'
                ]
            ]);
            json_decode($response->getBody()->getContents());
            return response(['response' => 'Successfully logged out on murugo'], 200);
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
            $statusCode = $response->getStatusCode();
            throw new MurugoAuthException($exception->getMessage(), $statusCode);
        }
    }
}
