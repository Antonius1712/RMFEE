<?php

namespace App\Helpers;

use App\Enums\BudgetStatus;
use App\Enums\Database;
use App\Pipeline\Budget\PrepareData;
use App\Pipeline\Budget\UpdateData;
use App\Pipeline\Pipes;
use Exception;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// ! Only Put Function that used only in Budgets. (usuallly method to Select, Insert, Update, Delete, and some customization).
class Budget {
    // !For DataTable Purposes only.
    public static function GetBudgetDataTable($broker_name, $branch, $status_pembayaran_premi, $start_date, $no_policy, $aging_rmf, $booking_date_from, $booking_date_to, $nb_rn, $holder_name, $class_business, $status_realisasi, $status_budget = '', $ProposedTo){
        $status_budget = strtoupper($status_budget);
        $archive = $status_budget == BudgetStatus::ARCHIVED ? 1 : 0;
        // dd($ProposedTo, $status_budget);
        try {
            // ! Parameters : '@BrokerName', '@Branch', '@Type', '@StartDate', '@StatusPremium','@AgingRealization', '@StatusRealization', '@Voucher';
            return DB::connection(Database::REPORT_GENERATOR)
            ->select("
                EXECUTE [dbo].[SP_Get_Data_Engineering_Fee] 
                '$broker_name', '$branch', '$nb_rn', '$start_date', '$no_policy', '$holder_name', '$status_pembayaran_premi', '$aging_rmf', '$status_realisasi', '', '$status_budget', $archive, '$booking_date_from', '$booking_date_to', '$class_business', '$ProposedTo'
            ");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function GetBudget($voucher = '', $archive = 0){
        $voucher = $voucher != "" ? str_replace("-", "/", $voucher) : "";
        try {
            // ! Parameters : '@BrokerName', '@Branch', '@Type', '@StartDate', '@StatusPremium','@AgingRealization', '@StatusRealization', '@Voucher';
            $Datas =  DB::connection(Database::REPORT_GENERATOR)
            ->select("
                EXECUTE [dbo].[SP_Get_Data_Engineering_Fee] 
                '', '', '', '', '', '', '', '', '', '".$voucher."', '', $archive, '', '', '', ''
            ");

            return $voucher != '' ? $Datas[0] : $Datas;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function UpdateBudget($request, $voucher){
        // dd($request->all());
        // $Data = ['voucher' => $voucher, 'request' => $request];
        // try {
        //     //? Using Pipeline, Send $Data to Pipeline on App\Pipeline\Pipes.php and do the process there.
        //     app(Pipeline::class)->send($Data)->through(Pipes::BUDGET_PIPELINE)->then(function($Response){
        //         if( $Response != 200 ){
        //             Log::info($Response);
        //         }
        //     });
        // } catch (Exception $e) {
        //     Log::error('Error Updating Budget Voucher = ' . $voucher . ' Exception = ' . $e->getMessage());
        // }
        $voucher = str_replace('~', '/', $voucher);
        $LastEditedBy = auth()->user()->UserId;
        $LastEdited = now()->format('Y-m-d');
        $LastEditedTime = now()->format('H:i:s');
        $DocumentPath = null;
        if( $request->hasFile('document') ){
            $document = $request->file('document');
            $destination_path = env('PUBLIC_PATH').'Document/Budget/';
            $filename = preg_replace("/[^a-z0-9\_\-\.]/i", '-', time() . '-' . $document->getClientOriginalName());
            $document->move($destination_path, $filename);
            $DocumentPath = 'Document/Budget/'.$filename;
        }
        $Budget = static::RemoveThousandSeparator($request->budget_in_amount);
        $Percentage = $request->budget;
        $ProposedTo = $request->proposed_to;
        $action = $request->action;
        
        switch ( $action ) {
            case 'save':
                $statusBudget = BudgetStatus::DRAFT;
                break;
            case 'propose':
                $statusBudget = BudgetStatus::WAITING_APPROVAL;
                break;
            default:
                return Log::error('Error Updating Budget Voucher = ' . $voucher . 'Missing Action.');
                break;
            break;
        }

        try {
            DB::connection("ReportGenerator181")->statement("EXECUTE [dbo].[SP_Update_Data_Engineering_Fee] '$Budget', '$Percentage', '$statusBudget', '$voucher', '$LastEditedBy', '$LastEdited', '$LastEditedTime', '$ProposedTo', '$DocumentPath', '$Budget' ");
        } catch (Exception $e) {
            Log::error('Error Updating Budget Voucher = ' . $voucher . ' Exception = ' . $e->getMessage());
        }
    }

    public static function UpdateBudgetOnlyStatus($action, $voucher){
        $voucher = str_replace('~', '/', $voucher);
        $LastEditedBy = auth()->user()->UserId;
        $LastEdited = now()->format('Y-m-d');
        $LastEditedTime = now()->format('H:i:s');
        
        switch ( $action ) {
            case 'archive':
                $statusBudget = BudgetStatus::ARCHIVED;
                break;
            case 'approve':
                $statusBudget = BudgetStatus::APPROVED;
                break;
            case 'undo_approve':
                $statusBudget = BudgetStatus::DRAFT;
                break;
            case 'reject':
                $statusBudget = BudgetStatus::REJECTED;
                break;
            case 'draft':
                $statusBudget = BudgetStatus::DRAFT;
                break;
            default:
                return Log::error('Error Updating Budget Only Status Voucher = ' . $voucher . 'Missing Action.');
                break;
            break;
        }

        try {
            DB::connection("ReportGenerator181")->statement("EXECUTE [dbo].[SP_Update_Status_Data_Engineering_Fee] '$statusBudget', '$voucher', '$LastEditedBy', '$LastEdited', '$LastEditedTime'");

            // dd('zzz', $voucher);
        } catch (Exception $e) {
            Log::error('Error Updating Budget Only Status Voucher = ' . $voucher . ' Exception = ' . $e->getMessage());
        }
    }

    public static function ShowHideButtonBudget($status, $role){
        $BtnEdit = false;
        $BtnDownloadDocument = false;
        $BtnArchive = false;
        $BtnApprove = false;
        $BtnUndoApproval = false;
        $BtnReject = false;
        $BtnUnArchive = false;
        
        switch ($status) {
            case BudgetStatus::DRAFT:
                switch ($role) {
                    case "USER_RMFEE":
                        $BtnEdit = true;
                        $BtnDownloadDocument = true;
                        $BtnArchive = true;
                        return [
                            'BtnEdit' => $BtnEdit,
                            'BtnDownloadDocument' => $BtnDownloadDocument,
                            'BtnArchive' => $BtnArchive,
                            'BtnApprove' => $BtnApprove,
                            'BtnUndoApproval' => $BtnUndoApproval,
                            'BtnReject' => $BtnReject,
                            'BtnUnArchive' => $BtnUnArchive,
                        ];
                        break;
                    case "HEAD_BU_RMFEE":
                        $BtnDownloadDocument = true;
                        return [
                            'BtnEdit' => $BtnEdit,
                            'BtnDownloadDocument' => $BtnDownloadDocument,
                            'BtnArchive' => $BtnArchive,
                            'BtnApprove' => $BtnApprove,
                            'BtnUndoApproval' => $BtnUndoApproval,
                            'BtnReject' => $BtnReject,
                            'BtnUnArchive' => $BtnUnArchive,
                        ];
                        break;
                    default:
                        return [
                            'BtnEdit' => $BtnEdit,
                            'BtnDownloadDocument' => $BtnDownloadDocument,
                            'BtnArchive' => $BtnArchive,
                            'BtnApprove' => $BtnApprove,
                            'BtnUndoApproval' => $BtnUndoApproval,
                            'BtnReject' => $BtnReject,
                            'BtnUnArchive' => $BtnUnArchive,
                        ];
                        break;
                }
            case BudgetStatus::WAITING_APPROVAL:
                switch ($role) {
                    case "USER_RMFEE":
                        $BtnDownloadDocument = true;
                        return [
                            'BtnEdit' => $BtnEdit,
                            'BtnDownloadDocument' => $BtnDownloadDocument,
                            'BtnArchive' => $BtnArchive,
                            'BtnApprove' => $BtnApprove,
                            'BtnUndoApproval' => $BtnUndoApproval,
                            'BtnReject' => $BtnReject,
                            'BtnUnArchive' => $BtnUnArchive,
                        ];
                        break;
                    case "HEAD_BU_RMFEE":
                        $BtnDownloadDocument = true;
                        $BtnApprove = true;
                        $BtnReject = true;
                        return [
                            'BtnEdit' => $BtnEdit,
                            'BtnDownloadDocument' => $BtnDownloadDocument,
                            'BtnArchive' => $BtnArchive,
                            'BtnApprove' => $BtnApprove,
                            'BtnUndoApproval' => $BtnUndoApproval,
                            'BtnReject' => $BtnReject,
                            'BtnUnArchive' => $BtnUnArchive,
                        ];
                        break;
                    default:
                        return [
                            'BtnEdit' => $BtnEdit,
                            'BtnDownloadDocument' => $BtnDownloadDocument,
                            'BtnArchive' => $BtnArchive,
                            'BtnApprove' => $BtnApprove,
                            'BtnUndoApproval' => $BtnUndoApproval,
                            'BtnReject' => $BtnReject,
                            'BtnUnArchive' => $BtnUnArchive,
                        ];
                        break;
                }
            case BudgetStatus::APPROVED:
                switch ($role) {
                    case "USER_RMFEE":
                        $BtnDownloadDocument = true;
                        $BtnEdit = true;
                        return [
                            'BtnEdit' => $BtnEdit,
                            'BtnDownloadDocument' => $BtnDownloadDocument,
                            'BtnArchive' => $BtnArchive,
                            'BtnApprove' => $BtnApprove,
                            'BtnUndoApproval' => $BtnUndoApproval,
                            'BtnReject' => $BtnReject,
                            'BtnUnArchive' => $BtnUnArchive,
                        ];
                        break;
                    case "HEAD_BU_RMFEE":
                        $BtnUndoApproval = true;
                        $BtnDownloadDocument = true;
                        return [
                            'BtnEdit' => $BtnEdit,
                            'BtnDownloadDocument' => $BtnDownloadDocument,
                            'BtnArchive' => $BtnArchive,
                            'BtnApprove' => $BtnApprove,
                            'BtnUndoApproval' => $BtnUndoApproval,
                            'BtnReject' => $BtnReject,
                            'BtnUnArchive' => $BtnUnArchive,
                        ];
                        break;
                    default:
                        return [
                            'BtnEdit' => $BtnEdit,
                            'BtnDownloadDocument' => $BtnDownloadDocument,
                            'BtnArchive' => $BtnArchive,
                            'BtnApprove' => $BtnApprove,
                            'BtnUndoApproval' => $BtnUndoApproval,
                            'BtnReject' => $BtnReject,
                            'BtnUnArchive' => $BtnUnArchive,
                        ];
                        break;
                }
            case BudgetStatus::REJECTED:
                switch ($role) {
                    case "USER_RMFEE":
                        $BtnEdit = true;
                        $BtnDownloadDocument = true;
                        $BtnArchive = true;
                        return [
                            'BtnEdit' => $BtnEdit,
                            'BtnDownloadDocument' => $BtnDownloadDocument,
                            'BtnArchive' => $BtnArchive,
                            'BtnApprove' => $BtnApprove,
                            'BtnUndoApproval' => $BtnUndoApproval,
                            'BtnReject' => $BtnReject,
                            'BtnUnArchive' => $BtnUnArchive,
                        ];
                        break;
                    case "HEAD_BU_RMFEE":
                        $BtnDownloadDocument = true;
                        return [
                            'BtnEdit' => $BtnEdit,
                            'BtnDownloadDocument' => $BtnDownloadDocument,
                            'BtnArchive' => $BtnArchive,
                            'BtnApprove' => $BtnApprove,
                            'BtnUndoApproval' => $BtnUndoApproval,
                            'BtnReject' => $BtnReject,
                            'BtnUnArchive' => $BtnUnArchive,
                        ];
                        break;
                    default:
                        return [
                            'BtnEdit' => $BtnEdit,
                            'BtnDownloadDocument' => $BtnDownloadDocument,
                            'BtnArchive' => $BtnArchive,
                            'BtnApprove' => $BtnApprove,
                            'BtnUndoApproval' => $BtnUndoApproval,
                            'BtnReject' => $BtnReject,
                            'BtnUnArchive' => $BtnUnArchive,
                        ];
                        break;
                }
            case BudgetStatus::ARCHIVED:
                // $BtnEdit = true;
                // $BtnDownloadDocument = true;
                $BtnUnArchive = true;
                return [
                    'BtnEdit' => $BtnEdit,
                    'BtnDownloadDocument' => $BtnDownloadDocument,
                    'BtnArchive' => $BtnArchive,
                    'BtnApprove' => $BtnApprove,
                    'BtnUndoApproval' => $BtnUndoApproval,
                    'BtnReject' => $BtnReject,
                    'BtnUnArchive' => $BtnUnArchive,
                ];
                break;
            default :
                switch ($role) {
                    case "USER_RMFEE":
                        $BtnEdit = true;
                        $BtnDownloadDocument = true;
                        $BtnArchive = true;
                        return [
                            'BtnEdit' => $BtnEdit,
                            'BtnDownloadDocument' => $BtnDownloadDocument,
                            'BtnArchive' => $BtnArchive,
                            'BtnApprove' => $BtnApprove,
                            'BtnUndoApproval' => $BtnUndoApproval,
                            'BtnReject' => $BtnReject,
                            'BtnUnArchive' => $BtnUnArchive,
                        ];
                    case "HEAD_BU_RMFEE":
                        $BtnDownloadDocument = true;
                        return [
                            'BtnEdit' => $BtnEdit,
                            'BtnDownloadDocument' => $BtnDownloadDocument,
                            'BtnArchive' => $BtnArchive,
                            'BtnApprove' => $BtnApprove,
                            'BtnUndoApproval' => $BtnUndoApproval,
                            'BtnReject' => $BtnReject,
                            'BtnUnArchive' => $BtnUnArchive,
                        ];
                        break;
                    default:
                    return [
                        'BtnEdit' => $BtnEdit,
                        'BtnDownloadDocument' => $BtnDownloadDocument,
                        'BtnArchive' => $BtnArchive,
                        'BtnApprove' => $BtnApprove,
                        'BtnUndoApproval' => $BtnUndoApproval,
                        'BtnReject' => $BtnReject,
                        'BtnUnArchive' => $BtnUnArchive,
                    ];
                    break;
                }
        }

        // if( $status == 'WAITING_APPROVAL' ){
        //     dd($BtnEdit, $BtnDownloadDocument, $BtnArchive, $BtnApprove, $BtnUndoApproval, $BtnReject);
        // }
    }

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

    //? Private static function, only used here. not outside the class.
    private static function RemoveThousandSeparator($amount){
        return str_replace(',', '', $amount);
    }
}

?>