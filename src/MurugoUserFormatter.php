<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/25/2020
 * Time: 4:10 PM
 */

namespace RwandaBuild\MurugoAuth;

use RwandaBuild\MurugoAuth\Models\MurugoUser;

class MurugoUserFormatter
{
    /**
     * MurugoUserFormatter constructor.
     * @param array $user
     * @param array $userTokens
     */
    public function __construct(array $user, array $userTokens)
    {
        $this->user = $user;
        $this->userTokens = $userTokens;
    }

    /**
     * Init the class construct
     * @param array $user
     * @param array $userTokens
     * @return MurugoUser
     */
    public static function get(array $user, array $userTokens)
    {
        //Instantiating class object and call none static function setUser()
        //Return model of created or updated one
        $murugoUser = (new self($user, $userTokens))->setUser();
        //sets murugo_user_id attribute of the model
        $murugoUserId = !empty($user['murugo_user_id']) ? $user['murugo_user_id'] : $user['hashed_murugo_user_id'];
        $murugoUser->setOriginalMurugoUuidAttribute($murugoUserId);
        return $murugoUser;
    }

    /**
     * Create or update an existing murugo user
     * @return MurugoUser
     */
    public function setUser()
    {
        $murugoUser = MurugoUser::where('murugo_user_id', $this->user['hashed_murugo_user_id'])->first();

        if (!$murugoUser) {
            return $this->createUser();
        }

        return $this->updateMurugoUser($murugoUser);
    }

    /**
     * Create a new murugo user
     * @return Model/MurugoUser
     */
    private function createUser()
    {
        $murugoUser = MurugoUser::create([
            'murugo_user_id' => $this->user['hashed_murugo_user_id'],
            'name' => $this->user['name'],
            'token' => $this->userTokens['access_token'],
            'refresh_token' => $this->userTokens['refresh_token'],
            'token_expires_at' => now()->addSeconds($this->userTokens['expires_in']),
            'murugo_user_avatar' => $this->user['avatar'],
            'murugo_user_public_name' => $this->user['public_name'],
        ]);

        return $murugoUser;
    }

    /**
     * Update murugo user info
     * @param MurugoUser $murugoUser
     * @return MurugoUser
     */
    private function updateMurugoUser(MurugoUser $murugoUser)
    {
        $murugoUser->update([
            'name' => $this->user['name'],
            'token' => $this->userTokens['access_token'],
            'refresh_token' => $this->userTokens['refresh_token'],
            'token_expires_at' => now()->addSeconds($this->userTokens['expires_in']),
            'murugo_user_avatar' => $this->user['avatar'],
            'murugo_user_public_name' => $this->user['public_name'],
        ]);

        return $murugoUser->fresh();
    }

    /**
     * Update tokens and token info of the user
     * @param MurugoUser $murugoUser
     * @param $tokens
     * @return MurugoUser
     */
    public static function updateAccessToken(MurugoUser $murugoUser, $tokens)
    {
        $murugoUser->update([
            'token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
            'token_expires_at' => now()->addSeconds($tokens['expires_in']),
        ]);

        return $murugoUser->fresh();

    }

    /**
     * Get user additional details to support the user invite service
     * @param $user user bundle
     */
    public static function getUserDetails($user)
    {
        return [
            'is_invited' => $user['is_invited'] ?? false,
            'invite_token' => $user['invite_token'] ?? null
        ];
    }
    
}
