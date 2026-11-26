<?php

namespace RwandaBuild\MurugoAuth\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

/**
 * F-9 / S-08: Murugo tokens are encrypted in the database with the app's APP_KEY.
 *
 *  - New values are stored as "enc:" + Crypt::encryptString($token).
 *  - Old rows saved before this (plain text) are read as they are, so they keep working; they are
 *    encrypted the next time the token is saved (login, refresh). Nothing has to be migrated.
 *  - Empty values ('' / null, e.g. after logout) are stored as they are.
 *  - If a value can't be decrypted (APP_KEY changed), it reads as null: Murugo calls then fail
 *    and the user logs in again, which stores a new, encrypted token.
 *  - config('services.murugo.encrypt_tokens') = false stores new tokens in plain text (for an app
 *    whose murugo_users table is read directly by another service); encrypted ones still read.
 */
class EncryptedToken implements CastsAttributes
{
    public const PREFIX = 'enc:';

    public function get($model, $key, $value, $attributes)
    {
        if (!is_string($value) || strpos($value, self::PREFIX) !== 0) {
            return $value; // plain text (saved before encryption) or empty
        }

        try {
            return Crypt::decryptString(substr($value, strlen(self::PREFIX)));
        } catch (DecryptException $e) {
            Log::warning('Murugo Auth: a stored Murugo token could not be decrypted (APP_KEY changed?); the user will need to log in again', [
                'murugo_user' => $model->getKey(), 'column' => $key,
            ]);

            return null;
        }
    }

    public function set($model, $key, $value, $attributes)
    {
        if ($value === null || $value === '' || config('services.murugo.encrypt_tokens', true) === false) {
            return $value;
        }

        if (is_string($value) && strpos($value, self::PREFIX) === 0) {
            return $value; // already encrypted
        }

        return self::PREFIX . Crypt::encryptString((string) $value);
    }
}
