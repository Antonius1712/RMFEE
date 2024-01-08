<?php

namespace App\Helpers;

use Carbon\Carbon;

class Logger {
    public static function SaveLog($voucher = null, $action = ''){
        $user = auth()->id();
        $date = Carbon::createFromFormat('Y-m-d H:i:s', now())->setTimezone('Asia/Phnom_Penh')->format('Y-m-d');
        $time = Carbon::createFromFormat('Y-m-d H:i:s', now())->setTimezone('Asia/Phnom_Penh')->format('H:i:s');

        
        // dd($user, $time, $action);
    }
}

?>