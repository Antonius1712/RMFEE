<?php

namespace App\Helpers;

use App\Enums\Database;
use App\Enums\LogStatus;
use App\Model\ReportGenerator_Log_Engineering_Fee;
use App\Model\ReportGenerator_Log_Realization_Engineering_Fee;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class Logger {
    public static function SaveLog($type = null, $voucherOrRealizationId = null, $action = '', $desc = null){
        $user = auth()->id();
        $date = Carbon::createFromFormat('Y-m-d H:i:s', now())->setTimezone('Asia/Phnom_Penh')->format('Y-m-d');
        $time = Carbon::createFromFormat('Y-m-d H:i:s', now())->setTimezone('Asia/Phnom_Penh')->format('H:i:s');

        switch($type){
            case LogStatus::BUDGET:
                try {
                    // voucherOrRealizationId, nik, status, date, time
                    $Datas =  DB::connection(Database::REPORT_GENERATOR)
                    ->statement("
                        EXECUTE [dbo].[SP_Insert_Log_Engineering_Fee] '$voucherOrRealizationId', '$user', '$action', '$desc', '$date', '$time'");
                    return $Datas;
                } catch (Exception $e) {
                    return $e->getMessage();
                }
                break;
            case LogStatus::REALIZATION:
                try {
                    // voucherOrRealizationId, nik, status, date, time
                    $Datas =  DB::connection(Database::REPORT_GENERATOR)
                    ->statement("
                        EXECUTE [dbo].[SP_Insert_Log_Realization_Engineering_Fee] '$voucherOrRealizationId', '$user', '$action', '$desc', '$date', '$time'");
                    return $Datas;
                } catch (Exception $e) {
                    return $e->getMessage();
                }
                break;
            default:
            break;
        }
    }

    public static function GetLog($type = null, $voucherOrRealizationId = null){
        switch($type){
            case LogStatus::BUDGET:
                try {
                    return ReportGenerator_Log_Engineering_Fee::where('Voucher', $voucherOrRealizationId)->orderBy('Date', 'asc')->orderby('Time', 'asc')->get();
                } catch (Exception $e) {
                    return $e->getMessage();
                }
                break;
            case LogStatus::REALIZATION:
                try {
                    return ReportGenerator_Log_Realization_Engineering_Fee::where('ID', $voucherOrRealizationId)->orderBy('Date', 'asc')->orderby('Time', 'asc')->get();
                } catch (Exception $e) {
                    return $e->getMessage();
                }
                break;
            default:
            break;
        }
    }
}

?>