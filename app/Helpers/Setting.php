<?php
namespace App\Helpers;

use App\Enums\Database;
use App\Model\LgiGlobal_User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

    class Setting {
        public static function GetUserList(){
            $userList = LgiGlobal_User::whereHas('getUserGroup', function($query1){
                $query1->where('GroupCode', 'USER_RMFEE')
                ->whereHas('getGroup', function($query2){
                    $query2->whereHas('getApp', function($query3){
                        $query3->where('AppCode', 'RMFEE');
                    });
                });
            })
            ->with('getDept')
            ->with('getBranch')
            ->with('getUserGroup')
            ->with('getUserGroup.getGroup')
            ->with('getUserGroup.getGroup.getApp')
            ->get();

            return $userList;
        }

        public static function GetTypeOfPaymentList(){
            return [
                "Reimbursement",
                "Offset Payment"
            ];
        }

        public static function GetApprovalListBU(){
            $approvalList = LgiGlobal_User::whereHas('getUserGroup', function($query1){
                $query1->where('GroupCode', '=', 'HEAD_BU_RMFEE')
                ->whereHas('getGroup', function($query2){
                    $query2->whereHas('getApp', function($query3){
                        $query3->where('AppCode', 'RMFEE');
                    });
                });
            })
            ->with('getDept')
            ->with('getBranch')
            ->with('getUserGroup')
            ->with('getUserGroup.getGroup')
            ->with('getUserGroup.getGroup.getApp')
            ->get();

            return $approvalList;
        }

        public static function GetApprovalListFinance(){
            $approvalList = LgiGlobal_User::whereHas('getUserGroup', function($query1){
                $query1->where('GroupCode', '=', 'HEAD_FINANCE_RMFEE')
                ->whereHas('getGroup', function($query2){
                    $query2->whereHas('getApp', function($query3){
                        $query3->where('AppCode', 'RMFEE');
                    });
                });
            })
            ->with('getDept')
            ->with('getBranch')
            ->with('getUserGroup')
            ->with('getUserGroup.getGroup')
            ->with('getUserGroup.getGroup.getApp')
            ->get();

            return $approvalList;
        }

        public static function GetUserSetting($UserId = null){
            try {
                return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Get_User_Setting_Engineering_Fee] '$UserId'");
            } catch (Exception $e) {
                Log::error('Error while get user setting. Exception = '.$e->getMessage());
            }
        }

        public static function SaveUserSetting($request){
            // dd($request->all());
            try {
                $UserId = $request->nik;
                $Type_Of_Payment = $request->type_of_payment;
                $Approval_BU_UserID = $request->approval_bu;
                $Approval_Finance_UserID = $request->approval_finance;
                $UserID_ePO = $request->user_id_epo;
                $CheckerID_ePO = $request->checker_id_epo;
                $ApprovalID_ePO = $request->approval_id_epo;

                return DB::connection(Database::REPORT_GENERATOR)->statement("EXECUTE [dbo].[SP_Insert_User_Setting_Engineering_Fee] '$UserId', '$Type_Of_Payment', '$Approval_BU_UserID', '$Approval_Finance_UserID', '$UserID_ePO', '$CheckerID_ePO', '$ApprovalID_ePO'");
            } catch (Exception $e) {
                Log::error('Error while save user setting. Exception = '.$e->getMessage());
            }
        }

        public static function UpdateUserSetting($UserId, $request){
            try {
                // $UserId = $request->nik;
                $Type_Of_Payment = $request->type_of_payment;
                $Approval_BU_UserID = $request->approval_bu;
                $Approval_Finance_UserID = $request->approval_finance;
                $UserID_ePO = $request->user_id_epo;
                $CheckerID_ePO = $request->checker_id_epo;
                $ApprovalID_ePO = $request->approval_id_epo;

                return DB::connection(Database::REPORT_GENERATOR)->statement("EXECUTE [dbo].[SP_Update_User_Setting_Engineering_Fee] '$UserId', '$Type_Of_Payment', '$Approval_BU_UserID', '$Approval_Finance_UserID', '$UserID_ePO', '$CheckerID_ePO', '$ApprovalID_ePO'");
            } catch (Exception $e) {
                Log::error('Error while save user setting. Exception = '.$e->getMessage());
            }
        }
    }
?>