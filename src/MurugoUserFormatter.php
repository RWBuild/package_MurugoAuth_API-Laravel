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
        return (new MurugoUserFormatter(
            $user, $userTokens
        ))->setUser();
    }

    /**
     * Create or update an existing murugo user
     * @return MurugoUser
     */
    public function setUser()
    {
        $murugoUser = MurugoUser::where('murugo_user_id', $this->user['murugo_user_id'])->first();

        if (! $murugoUser) return  $this->createUser();

        return $this->updateUserTokens($murugoUser);

    }

    /**
     * Create a new murugo user
     * @return Model/MurugoUser
     */
    private function createUser()
    {
        $murugoUser = MurugoUser::create([
            'name' => $this->user['name'],
            'murugo_user_id' => $this->user['murugo_user_id'],
            'token' => $this->user['access_token'],
            'refresh_token' => $this->user['refresh_token'],
            'token_expires_at' => now()->addSeconds($this->user['expires_in']),
            'murugo_user_avatar' => $this->user['murugo_user_avatar'],
            'murugo_user_public_name' => $this->user['murugo_user_public_name'],
        ]);

        return $murugoUser;
    }

    /**
     * Update murugo user info
     * @param MurugoUser $murugoUser
     * @return MurugoUser
     */
    private function updateUserTokens(MurugoUser $murugoUser)
    {
        $murugoUser->update([
            'name' => $this->user['name'],
            'token' => $this->user['access_token'],
            'refresh_token' => $this->user['refresh_token'],
            'token_expires_at' => now()->addSeconds($this->user['expires_in']),
            'murugo_user_avatar' => $this->user['murugo_user_avatar'],
            'murugo_user_public_name' => $this->user['murugo_user_public_name'],
        ]);

        return $murugoUser->fresh();
    }
}