<?php

namespace RwandaBuild\MurugoAuth\Traits;


trait MurugoAuthHelper
{
    public function murugoUser()
    {
        return $this->hasOne(\App\User::class);
    }
}