<?php

namespace RwandaBuild\MurugoAuth\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\DB;
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
        if (!empty($request->all())) {

            //Grab object
            $userObject = User::where('murugo_user_id', '=', $request->murugo_user_id)->first();
            if (!$userObject) {
                //Save user in database
                $this->saveUser($request);
            }
            $userId = $userObject->id;
            $token = $userObject->token;

            $checkUser = $this->checkUserExisting($request->murugo_user_id, $token);

            if (!$checkUser) {
                //Save user in database
                $this->saveUser($request);
            }
            //Update the user with new access_token
            DB::table('users')->where('id', $userId)
                ->update(['token' => $request->murugo_access_token, 'token_expires_at' => $request->expires_at]);

            return response(['response' => 'SUCCESS'], 200);
        }
    }

    /**
     * This helper function that saves user in database
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function saveUser(Request $request)
    {
        $user = new User();
        $user->name = $request->murugo_user_account_name;
        $user->email = $request->murugo_user_account_email;
        $user->murugo_user_id = $request->murugo_user_id;
        $user->token = $request->murugo_access_token;
        $user->token_expires_at = $request->expires_at;
        $user->save();
        return response(['response' => $user], 200);
    }

    /**
     * This helper function check if user is exist by using murugo_user_id
     * @param $murugo_user_id
     * @param $murugo_access_token
     * @return
     */
    private function checkUserExisting($murugo_user_id, $murugo_access_token)
    {
        return User::where('murugo_user_id', '=', $murugo_user_id)->where('token', '=', $murugo_access_token)->count();
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

        $user = User::where('murugo_user_id', '=', $uuid)->first();
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
            return response(['response' => $user], 200);
        } catch (ClientException $exception) {
            $this->catchError($exception);
            return response(['error' => 'Failed to authenticate user'], 400);
        }
    }

    /**
     * This function logout user on MurugoCloudCore by destroying token
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
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
            $this->catchError($exception);
            return response(['response' => 'Failed to logout on murugo'], 400);
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
}
