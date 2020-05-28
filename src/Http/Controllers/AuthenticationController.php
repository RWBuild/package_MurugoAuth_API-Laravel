<?php

namespace RwandaBuild\MurugoAuth\Http\Controllers;

use Illuminate\Http\Request;
use RwandaBuild\MurugoAuth\Exceptions\MurugoAuthException;
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
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getMurugoResponse(Request $request)
    {
        if (!isset($request->murugo_user_id)) {
            return response(['error' => 'Oops, murugo_user_id is required'], 400);
        } elseif (!isset($request->murugo_user_account_name)) {
            return response(['error' => 'Oops, murugo_user_account_name is required'], 400);
        } elseif (!isset($request->murugo_access_token)) {
            return response(['error' => 'Oops, murugo_access_token is required'], 400);
        } elseif (!isset($request->murugo_user_account_email)) {
            return response(['error' => 'Oops, murugo_user_account_email is required'], 400);
        } else {

            //Grab object
            $userObject = MurugoUser::where('murugo_user_id', '=', $request->murugo_user_id)->first();
            if (!$userObject) {
                //Save user in database
                return $this->saveUser($request);
            }
            $userId = $userObject->id;
            $token = $userObject->token;

            $checkUser = $this->checkUserToken($request->murugo_user_id, $token);

            if (!$checkUser) {
                //Save user in database
                return $this->saveUser($request);
            }

            //Update the user with new access_token
            MurugoUser::where('id', $userId)
                ->update(['token' => $request->murugo_access_token,
                    'murugo_user_public_name' => $request->murugo_user_public_name,
                    'murugo_user_avatar' => $request->murugo_user_avatar,
                    'token_expires_at' => $request->expires_at]);

            return response(['response' => 'Successfully updated'], 200);
        }
    }

    /**
     * This helper function that saves user in database
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function saveUser(Request $request)
    {
        $user = new MurugoUser();
        $user->name = $request->murugo_user_account_name;
        $user->email = $request->murugo_user_account_email;
        $user->murugo_user_id = $request->murugo_user_id;
        $user->token = $request->murugo_access_token;
        $user->token_expires_at = $request->expires_at;
        $user->murugo_user_avatar = $request->murugo_user_avatar;
        $user->murugo_user_public_name = $request->murugo_user_public_name;
        $user->save();
        return response(['response' => new MurugoUserResource($user)], 200);
    }

    /**
     * This helper function check if user is exist by using murugo_user_id
     * @param $murugo_user_id
     * @param $murugo_access_token
     * @return
     */
    private function checkUserToken($murugo_user_id, $murugo_access_token)
    {
        return MurugoUser::where('murugo_user_id', '=', $murugo_user_id)->where('token', '=', $murugo_access_token)->count();
    }

    /**
     * Function than gets the token of current logging in user
     * Check if that token exist and get user belongs to that token
     * If token is not exist, mostly for new user, create new user and set token as well
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function authenticateUser(Request $request)
    {
        $uuid = $request->uuid;

        $user = MurugoUser::where('murugo_user_id', '=', $uuid)->first();
        $token = $user->token;

        if (!$user) {
            return response(['response' => 'User not found'], 404);
        }

        //check if access token is valid every time before authenticate user, do the request from murugo
        try {
            $client = new Client();
            $response = $client->request('GET', env('MURUGO_URL') . 'api/thirdparty-me', [
                'headers' => [
                    'Authorization' => "Bearer $token",
                    'Accept' => 'application/json'
                ]
            ]);
            json_decode($response->getBody()->getContents());
            return response(['response' => new MurugoUserResource($user)], 200);
        } catch (ClientException $exception) {
            $this->catchError($exception);
            return response(['error' => 'Failed to authenticate user'], 400);
        }
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
                $user->email = $murugoUser->email;
                $user->murugo_user_id = $murugoUser->hashed_murugo_user_id;
                $user->token = $token;
                $user->token_expires_at = $expires_at;
                $user->murugo_user_avatar = $murugoUser->avatar;
                $user->murugo_user_public_name = $murugoUser->public_name;
                $user->save();
                return $user;
            }

            MurugoUser::where('murugo_user_id', $murugoUser->hashed_murugo_user_id)
                ->update(['token' => $token,
                    'murugo_user_public_name' => $murugoUser->public_name,
                    'murugo_user_avatar' => $murugoUser->avatar,
                    'token_expires_at' => $expires_at]);

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
     * @param Request $request
     * @return mixed
     * @throws MurugoAuthException
     */
    public static function userFromUUID(Request $request)
    {
        $uuid = $request->uuid;

        $user = MurugoUser::where('murugo_user_id', '=', $uuid)->first();

        if (!$user) {
            throw new MurugoAuthException("Unauthenticated", 401);
        }

        //check if access token is valid every time before authenticate user, do the request from murugo
        try {
            $client = new Client();
            $response = $client->request('GET', env('MURUGO_URL') . 'api/thirdparty-me', [
                'headers' => [
                    'Authorization' => "Bearer $user->token",
                    'Accept' => 'application/json'
                ]
            ]);
            $murugoUser = json_decode($response->getBody()->getContents());

            MurugoUser::where('murugo_user_id', $murugoUser->hashed_murugo_user_id)
                ->update(['murugo_user_public_name' => $murugoUser->public_name,
                    'murugo_user_avatar' => $murugoUser->avatar]);

            //This is new for me Hint from Promesse
            return $user->fresh();
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
            $statusCode = $response->getStatusCode();
            throw new MurugoAuthException($exception->getMessage(), $statusCode);
        }
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
