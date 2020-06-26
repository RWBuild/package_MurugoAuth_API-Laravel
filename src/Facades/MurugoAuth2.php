<?php
namespace RwandaBuild\MurugoAuth\Facades;

use Illuminate\Support\Facades\Facade;

class MurugoAuth2 extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MurugoAuth2';
    }
}