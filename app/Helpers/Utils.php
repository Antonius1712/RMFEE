<?php
namespace App\Helpers;

use App\Enums\Database;
use Exception;
use Illuminate\Support\Facades\DB;


// ! Only Put Global Function (Function that used in many places.) Here.
class Utils {
    // ! Function GET.
    public static function GetProfile($idProfile = null, $Currency = null){
        try {
            $Profile = DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Get_Profile_Engineering_Fee] '$idProfile', '$Currency'");

            $Count = count($Profile);
            switch ($Count) {
                //! if Empty Data.
                case 0:
                    return null;
                    break;
                //! if Only 1 Data.
                case 1:
                    return $Profile[0];
                    break;
                //! if More than 1 Data.
                default:
                    return $Profile;
                    break;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function GetCurrencies(){
        try {
            return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Get_Currency_Engineering_Fee]");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function GetBranch(){
        try {
            return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Get_Branch_Engineering_Fee]");
        } catch (Exception $e) {
            return [];
        }
    }

    public static function GetClass(){
        try {
            return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Get_Class_Engineering_Fee]");
        } catch (Exception $e) {
            return [];
        }
    }

    // ! Function Search.
    public static function SearchProfile($keywords, $currency = null){
        try {
            return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Get_Profile_Engineering_Fee] '$keywords', '$currency'");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function SearchProfileOnSettingBudget($keywords){
        try {
            return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Get_Profile_Setting_Engineering_Fee] '$keywords'");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function SearchOccupation($keywords){
        try {
            return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Get_GendTab_Engineering_Fee] '$keywords'");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public static function SearchBudgetByPolicyNoAndBrokerName($policy_no, $broker_name, $RealizationDataId){
        try {
            // ! Parameters : '@BrokerName', '@Branch', '@Type', '@StartDate', '@StatusPremium','@AgingRealization', '@StatusRealization', '@Voucher';
            $Datas =  DB::connection(Database::REPORT_GENERATOR)
            ->select("
                EXECUTE [dbo].[SP_Get_Data_Budget_Engineering_Fee] 
                '".$broker_name."', '', '', '', '".$policy_no."', '', '', '', '', '', 'APPROVED', 0, '".$RealizationDataId."'
            ");

            return $Datas;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
        
    // ! Other Function
    public static function RemoveThousandSeparator($amount){
        return str_replace(',', '', $amount);
    }

    public static function PublicPath(){
        return config('app.PUBLIC_PATH');
    }

    public static function getRandomString($n, $type) {

        switch ($type) {
            case 'lower-string':
                $characters = 'abcdefghijklmnopqrstuvwxyz';
                break;
            case 'upper-string':
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'lower-upper-string':
                $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'numbers':
                $characters = '0123456789';
                break;
            case 'number-string':
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            default:
                $characters = 'abcdefghijklmnopqrstuvwxyz';
                break;
            break;
        }

        $randomString = '';
    
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
    
        return $randomString;
    }

    public static function GetEmailEpo(){
        return config('app.EMAIL_EPO');
    }

    public static function numberPrecision($number, $decimals = 0)
    {
        $negation = ($number < 0) ? (-1) : 1;
        $coefficient = 10 ** $decimals;
        return $negation * floor((string)(abs($number) * $coefficient)) / $coefficient;
    }
}
?>