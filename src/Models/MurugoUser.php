<?php

namespace RwandaBuild\MurugoAuth\Models;

use Illuminate\Database\Eloquent\Model;
use RwandaBuild\MurugoAuth\MurugoAuthHandler;

class MurugoUser extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $appends = ['original_murugo_uuid'];

    public function user()
    {
        $userModel = '\App\User';
        if (!class_exists($userModel)) $userModel = '\App\Models\User';
        return $this->hasOne($userModel, MurugoAuthHandler::getForeignKey());
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

    public function getMurugoUUID()
    {
        return $this->original_murugo_uuid;
    }

    public function setOriginalMurugoUuidAttribute($value)
    {
        return $this->attributes['original_murugo_uuid'] = $value;
    }

    public function getOriginalMurugoUuidAttribute()
    {
        return $this->original_murugo_uuid ?? null;
    }
}
