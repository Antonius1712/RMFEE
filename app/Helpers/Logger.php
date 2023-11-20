<?php

namespace App\Helpers;

use Carbon\Carbon;

class Logger {
    public static function SaveLog($action = ''){
        $user = auth()->id();
        $time = Carbon::createFromFormat('Y-m-d H:i:s', now())->setTimezone('Asia/Phnom_Penh')->format('Y-m-d H:i:s');

        // dd($user, $time, $action);
    }
}

?>