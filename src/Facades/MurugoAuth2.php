<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/25/2020
 * Time: 3:53 PM
 */

namespace RwandaBuild\MurugoAuth\Facades;

use Illuminate\Support\Facades\Facade;


class MurugoAuth2 extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MurugoAuth2';
    }
}