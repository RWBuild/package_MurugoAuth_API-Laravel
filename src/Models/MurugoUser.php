<?php

namespace RwandaBuild\MurugoAuth\Models;

use Illuminate\Database\Eloquent\Model;

class MurugoUser extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(\App\User::class);
    }

    public function murugo_one_time_tokens()
    {
        return $this->hasMany(MurugoOneTimeToken::class);
    }

    public function getAtName()
    {
        return $this->name;
    }

    public function getUserId()
    {
        return $this->murugo_user_id;
    }

    public function getAvatar()
    {
        return $this->murugo_user_avatar;
    }

    public function getPublicName()
    {
        return $this->murugo_user_public_name;
    }
}
