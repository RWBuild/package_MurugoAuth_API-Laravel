<?php

namespace RwandaBuild\MurugoAuth\Models;

use Illuminate\Database\Eloquent\Model;

class MurugoOneTimeToken extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function murugo_user()
    {
        return $this->belongsTo(MurugoUser::class);
    }
}
