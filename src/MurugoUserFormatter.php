<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/25/2020
 * Time: 4:10 PM
 */

namespace RwandaBuild\MurugoAuth;

use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use RwandaBuild\MurugoAuth\Models\MurugoUser;

class MurugoUserFormatter
{
    // declared: dynamic properties are deprecated since PHP 8.2
    private $user;
    private $userTokens;

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
        $murugoUser->original_murugo_uuid = $murugoUserId;
        return $murugoUser;
    }

    /**
     * Create or update an existing murugo user
     * @return MurugoUser
     */
    public function setUser()
    {
        $hashedId = $this->user['hashed_murugo_user_id'];

        // S-13: two logins of the same person at the same time (double click, retry) could both
        // find no row and both insert one. The lock makes them run one after the other.
        return self::withUserLock($hashedId, function () use ($hashedId) {
            $murugoUser = self::findMurugoUser($hashedId);

            if (!$murugoUser) {
                return $this->createUser();
            }

            return $this->updateMurugoUser($murugoUser);
        });
    }

    /**
     * S-13: run $callback while holding a cache lock for this Murugo user.
     * Works across servers with redis / memcached / database cache, on one server with the
     * file cache. If the lock can't be used (cache without lock support, database cache
     * without the `cache_locks` table, cache down) or isn't free within 5 seconds, the callback
     * runs without it (as before) rather than failing the login. Errors from the callback
     * itself are not caught.
     */
    private static function withUserLock($hashedId, callable $callback)
    {
        $lock = null;

        try {
            $lock = Cache::lock('murugo-auth:user:' . sha1((string) $hashedId), 10);
            $lock->block(5);
        } catch (LockTimeoutException $e) {
            return $callback();
        } catch (\Throwable $e) {
            Log::warning('Murugo Auth: login lock unavailable, continuing without it', ['error' => $e->getMessage()]);

            return $callback();
        }

        try {
            return $callback();
        } finally {
            try {
                $lock->release();
            } catch (\Throwable $e) {
                // the lock expires by itself after 10 seconds
            }
        }
    }

    /**
     * S-13: find the MurugoUser for a Murugo user id. When older duplicate rows exist, always
     * pick the same one: the row a local user is linked to (MurugoUser::user()), otherwise the
     * newest. Extra rows are logged, not deleted, since a local user may still point at one.
     * @return MurugoUser|null
     */
    public static function findMurugoUser($hashedId)
    {
        $matches = MurugoUser::where('murugo_user_id', $hashedId)->orderByDesc('id')->get();

        if ($matches->count() <= 1) {
            return $matches->first();
        }

        $chosen = $matches->first(function (MurugoUser $murugoUser) {
            try {
                return $murugoUser->user()->exists();
            } catch (\Throwable $e) {
                return false; // host app has no link column
            }
        }) ?: $matches->first();

        Log::warning('Murugo Auth: duplicate murugo_users rows for one Murugo user', [
            'murugo_users_ids' => $matches->pluck('id')->all(),
            'used_id' => $chosen->id,
        ]);

        return $chosen;
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
