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

    /**
     * S-09: the Murugo user id this login came with. Not a database column, so it is kept in a
     * plain property: storing it in $attributes made save() fail (unknown column), and reading
     * $this->original_murugo_uuid inside its own accessor called the accessor again forever.
     */
    protected $originalMurugoUuid = null;

    public function setOriginalMurugoUuidAttribute($value)
    {
        $this->originalMurugoUuid = $value;
    }

    public function getOriginalMurugoUuidAttribute()
    {
        return $this->originalMurugoUuid;
    }
}
