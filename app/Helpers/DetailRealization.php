<?php
namespace App\Helpers;

use App\Enums\BudgetStatus;
use App\Enums\Database;
use App\Enums\RealizationStatus;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DetailRealization {
    public static function GetDetailRealization($RealizationId){
        try {
            return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Get_Detail_Realization_Engineering_Fee] '$RealizationId'");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function GetDetailRealizationById($id){
        try {
            return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Get_Detail_Realization_ID_Engineering_Fee] '$id'")[0];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function SaveDetailRealization($request, $RealizationId){
        try {
            $BudgetVoucher = $request->voucher;
            $AmountRealization = static::RemoveThousandSeparator($request->amount_realization);
            $CurrencyRealization = $request->currency_realization;
            $ExchangeRateRealization = static::RemoveThousandSeparator($request->exchange_rate);
            $TotalAmountRealization = static::RemoveThousandSeparator($request->total_amount_realization);

            return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Insert_Realization_Engineering_Fee] '$RealizationId', '$BudgetVoucher', '$AmountRealization', '$CurrencyRealization', '$ExchangeRateRealization', '$TotalAmountRealization'");
        } catch (Exception $e) {
            return Log::error("Error while saving data Detail Realization on RealizationId = " . $RealizationId . " Exception = " . $e->getMessage());
        }
    }

    public static function UpdateDetailRealization($request, $RealizationId, $DetailRealizationId){
        try {
            // dd($request->all(), $RealizationId, $DetailRealizationId);
            $BudgetVoucher = $request->voucher;
            $AmountRealization = static::RemoveThousandSeparator($request->amount_realization);
            $CurrencyRealization = $request->currency_realization;
            $ExchangeRateRealization = static::RemoveThousandSeparator($request->exchange_rate);
            $TotalAmountRealization = static::RemoveThousandSeparator($request->total_amount_realization);

            return DB::connection(Database::REPORT_GENERATOR)->statement("EXECUTE [dbo].[SP_Update_Detail_Realization_Engineering_Fee] $DetailRealizationId, $RealizationId, '$BudgetVoucher', '$AmountRealization', '$CurrencyRealization', '$ExchangeRateRealization', '$TotalAmountRealization'");
        } catch (Exception $e) {
            return Log::error("Error while saving data Detail Realization on DetailRealizationId = " . $DetailRealizationId . " Exception = " . $e->getMessage());
        }
    }

    public static function UpdateBudgetRealization($param, $TypeOfInvoice){
        //? GetPastRealizationOnBudget ini untuk mengambil amount sebelumnya. karna budget ini dapat dipakai pada beberapa invoice dengan type yang sama / berbeda.
        $GetPastRealizationOnBudget = Budget::GetBudget($param->voucher);
        $StoredProcedure = '';
        $RealizationRMF = 0;
        $RealizationSponsorship = 0;
        $TotalAmountRealization = 0;
        $IsOverLimit = false;
        switch ($TypeOfInvoice) {
            case 'RMF':
                $StoredProcedure = 'SP_Update_Budget_Realization_RMF_Engineering_Fee';
                $RealizationRMF = $GetPastRealizationOnBudget->REALIZATION_RMF;
                $TotalAmountRealization = $RealizationRMF + static::RemoveThousandSeparator($param->total_amount_realization);
                break;
            case 'Sponsorship':
                $StoredProcedure = 'SP_Update_Budget_Realization_Sponsorship_Engineering_Fee';
                $RealizationSponsorship = $GetPastRealizationOnBudget->REALIZATION_SPONSORSHIP;
                $TotalAmountRealization = $RealizationSponsorship + static::RemoveThousandSeparator($param->total_amount_realization);
                break;
            default:
            break;
        }

        $TotalAmountRealization = (float) $TotalAmountRealization;
        $RemainBudget = (float) $GetPastRealizationOnBudget->REMAIN_BUDGET;

        $IsOverLimit = $TotalAmountRealization > $RemainBudget ? true : false;

        // dd( $IsOverLimit );

        try {
            if( $IsOverLimit ) {
                return BudgetStatus::OVERLIMIT;
            }

            DB::connection(Database::REPORT_GENERATOR)->statement("EXECUTE [dbo].[".$StoredProcedure."] $TotalAmountRealization, '$param->voucher', '".RealizationStatus::APPROVED_BY_FINANCE."' ");

            return BudgetStatus::NOTOVERLIMIT;
        } catch (Exception $e) {
            Log::error('Error While Updating Budget on Realization Type ' . $TypeOfInvoice . ' Exception = ' . $e->getMessage());
        }
    }

    //? Private static function, only used here. not outside the class.
    private static function RemoveThousandSeparator($amount){
        return str_replace(',', '', $amount);
    }
}