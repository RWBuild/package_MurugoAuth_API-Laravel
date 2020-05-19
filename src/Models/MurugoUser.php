<?php

namespace RwandaBuild\MurugoAuth\Models;

use Illuminate\Database\Eloquent\Model;

class MurugoUser extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(\App\User::class);
    }
}
