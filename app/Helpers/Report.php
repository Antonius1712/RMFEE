<?php

namespace App\Helpers;

use App\Enums\Database;
use Illuminate\Support\Facades\DB;

class Report {
    public static function GetReportBudgetSummary($start_date, $end_date, $status_budget){
        $start_date = str_replace('/', '-', $start_date);
        $end_date = str_replace('/', '-', $end_date);
        return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Report_Budget_Summary_Engineering_Fee] '$start_date', '$end_date', '$status_budget'");
    }

    public static function GetReportBudgetDetail($start_date, $end_date, $status_budget){
        $start_date = str_replace('/', '-', $start_date);
        $end_date = str_replace('/', '-', $end_date);
        return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Report_Budget_Detail_Engineering_Fee] '$start_date', '$end_date', '$status_budget'");
    }

    public static function GetReportRealizationSummary($start_date, $end_date, $status_realization){
        $start_date = str_replace('/', '-', $start_date);
        $end_date = str_replace('/', '-', $end_date);
        return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Report_Realization_Summary_Engineering_Fee] '$start_date', '$end_date', '$status_realization'");
    }

    public static function GetReportRealizationDetail($start_date, $end_date, $status_realization){
        $start_date = str_replace('/', '-', $start_date);
        $end_date = str_replace('/', '-', $end_date);
        return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Report_Realization_Detail_Engineering_Fee] '$start_date', '$end_date', '$status_realization'");
    }

    public static function GetReportOS($updated_at, $underwriting_year_start, $underwriting_year_end, $broker_name){
        $updated_at = str_replace('/', '-', $updated_at);
        return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Report_OS_Engineering_Fee] '$updated_at', '$underwriting_year_start', '$underwriting_year_end', '$broker_name'");
    }
}