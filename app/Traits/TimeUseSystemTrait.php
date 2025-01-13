<?php

namespace App\Traits;

use Illuminate\Support\Facades\Session;

trait TimeUseSystemTrait
{
    public static function saveTime()
    {
        $time = Session::get('time_use_system', time());
        Session::put('time_use_system', time());

        return time() - $time;
    }
}
