<?php

namespace RwandaBuild\MurugoAuth\Traits;


use RwandaBuild\MurugoAuth\Models\MurugoUser;

trait MurugoAuthHelper
{
    public function murugoUser()
    {
        return $this->belongsTo(MurugoUser::class);
    }
}