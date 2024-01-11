<?php

namespace App\Helpers;

use App\Enums\Database;
use App\Model\ReportGenerator_Log_Engineering_Fee;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class Logger {
    public static function SaveLog($voucher = null, $action = '', $desc = null){
        $user = auth()->id();
        $date = Carbon::createFromFormat('Y-m-d H:i:s', now())->setTimezone('Asia/Phnom_Penh')->format('Y-m-d');
        $time = Carbon::createFromFormat('Y-m-d H:i:s', now())->setTimezone('Asia/Phnom_Penh')->format('H:i:s');

        try {
            // voucher, nik, status, date, time
            $Datas =  DB::connection(Database::REPORT_GENERATOR)
            ->statement("
                EXECUTE [dbo].[SP_Insert_Log_Engineering_Fee] '$voucher', '$user', '$action', '$desc', '$date', '$time'");
            return $Datas;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
        // dd($user, $time, $action);
    }

    public static function GetLog($voucher = null){
        try {
            return ReportGenerator_Log_Engineering_Fee::where('Voucher', $voucher)->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}

?>