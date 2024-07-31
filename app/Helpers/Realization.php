<?php

namespace App\Helpers;

use App\Enums\BudgetStatus;
use App\Enums\Database;
use App\Enums\RealizationStatus;
use App\Pipeline\Pipes;
use Exception;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// ! Only Put Function that used only in Realization. (usuallly method to Select, Insert, Update, Delete, and some customization).
class Realization {
    // !For DataTable Purposes only.
    public static function GetRealizationDataTable(){
        try {
            // ! Parameters : '@BrokerName', '@Branch', '@Type', '@StartDate', '@StatusPremium','@AgingRealization', '@StatusRealization', '@Voucher';
            return DB::connection(Database::REPORT_GENERATOR)
            ->select("
                EXECUTE [dbo].[SP_Get_Data_Engineering_Fee] 
                '', '', '', '', '', '', '', '', '', '', 'APPROVED', 0
            ");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function GetRealization($invoice_no = null, $FilterStatusRealization = null, $FilterBrokerName = null, $FilterLastUpdate = null, $FilterCOB = null, $FilterTypeOfPayment = null){
        // dd($invoice_no, $FilterStatusRealization, $FilterBrokerName, $FilterLastUpdate, $FilterCOB, $FilterTypeOfPayment);
        $UserGroup = auth()->user()->getUserGroup->GroupCode;
        try {
            $RealizationData = DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Get_Group_Realization_Engineering_Fee] '$invoice_no', '$FilterStatusRealization', '$FilterBrokerName', '$FilterLastUpdate', '$FilterCOB', '$FilterTypeOfPayment'");

            // dd($RealizationData);
            
            $CountRealization = count($RealizationData);

            switch ($CountRealization) {
                case 0:
                    $RealizationData = null;
                    return $RealizationData;
                    break;
                // case 1:
                //     $RealizationData = $RealizationData[0];
                //     return $RealizationData;
                //     break;
                default:
                    return $RealizationData;
                    break;
            }
        } catch (Exception $e) {
            // dd($e->getMessage());
            return $e->getMessage();
        }
    }

    public static function GetDetailRealization($realization_id){
        try {
            return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Get_Detail_Realization_Engineering_Fee] '$realization_id'");
        } catch (Exception $e) {
            Log::error('Error while getting Detail Realization Data on Realization_id = ' . $realization_id . ' Exception = ' . $e->getMessage());
        }
    }

    // ! Realization Group Function
    public static function InsertRealizationGroup($param){
        try {
            $invoice_no = $param->invoice_no;
            $type_of_invoice = $param->type_of_invoice;
            $type_of_payment = $param->type_of_payment;
            $currency = $param->currency;
            $invoice_date = date('Y-m-d H:i:s.000', strtotime($param->invoice_date));
            $broker_id = $param->broker_id;
            $payment_to = $param->payment_to;
            $approval_bu = explode(' - ', $param->approval_bu)[0];
            $approval_finance = explode(' - ', $param->approval_finance)[0];
            $epo_checker = $param->epo_checker;
            $epo_approval = $param->epo_approval;
            $status_realization = $param->StatusRealization;
            $remarks = $param->remarks;
            $CreatedBy = auth()->user()->UserId;
            $CreatedDate = now()->format('Y-m-d');
            $lastUpdateBy = auth()->user()->UserId;
            $lastUpdate = now()->format('Y-m-d');
            $date_of_request = $param->date_of_request;

            // $upload_invoice = $param->upload_invoice;
            // $upload_survey_report = $param->upload_survey_report;

            $DocumentPath_upload_invoice = null;
            if( $param->hasFile('upload_invoice') ){
                $upload_invoice = $param->file('upload_invoice');
                $destination_path = env('PUBLIC_PATH').'images/Realization/Invoice/';
                $filename = preg_replace("/[^a-z0-9\_\-\.]/i", '-', time() . '-' . $upload_invoice->getClientOriginalName());
                $upload_invoice->move($destination_path, $filename);
                $DocumentPath_upload_invoice = 'images/Realization/Invoice/'.$filename;
            }

            $DocumentPath_upload_survey_report = null;
            if( $param->hasFile('upload_survey_report') ){
                $upload_survey_report = $param->file('upload_survey_report');
                $destination_path = env('PUBLIC_PATH').'images/Realization/Survey_Report/';
                $filename = preg_replace("/[^a-z0-9\_\-\.]/i", '-', time() . '-' . $upload_survey_report->getClientOriginalName());
                $upload_survey_report->move($destination_path, $filename);
                $DocumentPath_upload_survey_report = 'images/Realization/Survey_Report/'.$filename;
            }

            DB::connection(Database::REPORT_GENERATOR)->statement("EXECUTE [dbo].[SP_Insert_Group_Realization_Engineering_Fee] '$invoice_no', '$type_of_invoice', '$type_of_payment', '$currency', '$invoice_date', '$broker_id', '$payment_to', '$DocumentPath_upload_invoice', '$DocumentPath_upload_survey_report', '$approval_bu', '$approval_finance', '$epo_checker', '$epo_approval', '$status_realization', '$remarks', '$CreatedBy', '$CreatedDate', '$lastUpdateBy', '$lastUpdate', '$date_of_request'");

            // dd($lastUpdateBy, $lastUpdate);

        } catch (Exception $e) {
            Log::error('Error while inserting New Realization Exception = '.$e->getMessage());
        }
    }

    public static function UpdateRealizationGroup($param = null, $InvoiceNumber = null, $status_realization = RealizationStatus::DRAFT){
        try {
            $invoice_no = isset($param->invoice_no) ? $param->invoice_no : (isset($InvoiceNumber) ? $InvoiceNumber : null);
            $invoice_no_real = str_replace('~', '/', $invoice_no);
            $type_of_invoice = isset($param->type_of_invoice) ? $param->type_of_invoice : null;
            $type_of_payment = isset($param->type_of_payment) ? $param->type_of_payment : null;
            $currency = isset($param->currency) ? $param->currency : null;
            $invoice_date = isset($param->invoice_date) ? $param->invoice_date : null;
            $broker_id = isset($param->broker_id) ? $param->broker_id : null;
            $payment_to = isset($param->payment_to) ? $param->payment_to : null;
            $approval_bu = isset($param->approval_bu) ? explode(' - ', $param->approval_bu)[0] : null;
            $approval_finance = isset($param->approval_finance) ? explode(' - ', $param->approval_finance)[0] : null;
            $epo_checker = isset($param->epo_checker) ? $param->epo_checker : null;
            $epo_approval = isset($param->epo_approval) ? $param->epo_approval : null;
            // $status_realization = RealizationStatus::DRAFT;
            $remarks = $param->remarks;
            $lastUpdateBy = auth()->user()->UserId;
            $lastUpdate = now()->format('Y-m-d');
            $date_of_request = $param->date_of_request;


            $DocumentPath_upload_invoice = null;
            if( $param->hasFile('upload_invoice') ){
                $upload_invoice = $param->file('upload_invoice');
                $destination_path = env('PUBLIC_PATH').'images/Realization/Invoice/';
                $filename = preg_replace("/[^a-z0-9\_\-\.]/i", '-', time() . '-' . $upload_invoice->getClientOriginalName());
                $upload_invoice->move($destination_path, $filename);
                $DocumentPath_upload_invoice = 'images/Realization/Invoice/'.$filename;
            }

            $DocumentPath_upload_survey_report = null;
            if( $param->hasFile('upload_survey_report') ){
                $upload_survey_report = $param->file('upload_survey_report');
                $destination_path = env('PUBLIC_PATH').'images/Realization/Survey_Report/';
                $filename = preg_replace("/[^a-z0-9\_\-\.]/i", '-', time() . '-' . $upload_survey_report->getClientOriginalName());
                $upload_survey_report->move($destination_path, $filename);
                $DocumentPath_upload_survey_report = 'images/Realization/Survey_Report/'.$filename;
            }

            // TODO kalo upload_invoice / upload_survey dari request kosong, cek db. ambil value path dari db save variable.
            // TODO lalu masukan variable ke dalam SP_Update dibawah.

            // dd('xx');

            if( $DocumentPath_upload_invoice == null || $DocumentPath_upload_survey_report == null ) {
                $RealizationFileData = DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Get_Group_Realization_Engineering_Fee] '$invoice_no_real', '', '', '', '', ''")[0];

                if( $DocumentPath_upload_invoice == null ) {
                    $DocumentPath_upload_invoice = $RealizationFileData->Upload_Invoice_Path;
                }

                if( $DocumentPath_upload_survey_report == null ) {
                    $DocumentPath_upload_survey_report = $RealizationFileData->Upload_Survey_Report_Path;
                }
            }

            
            //! INI UNTUK SAVE PATH UPLOAD_INVOICE
            try {
                DB::connection(Database::REPORT_GENERATOR)->statement("EXECUTE [dbo].[SP_Update_Invoice_Group_Realization_Engineering_Fee] '$invoice_no', '$DocumentPath_upload_invoice'");
            } catch(Exception $e) {
                Log::error('Error Update Realization Invoice Exception = ' . $e->getMessage());
            }
            
            //! INI UNTUK SAVE PATH UPLOAD_SURBEY_REPORT 
            try {
                DB::connection(Database::REPORT_GENERATOR)->statement("EXECUTE [dbo].[SP_Update_Survey_Group_Realization_Engineering_Fee] '$invoice_no', '$DocumentPath_upload_survey_report'");   
            } catch(Exception $e) {
                Log::error('Error Update Realization Survey Exception = ' . $e->getMessage());
            }
            
            // dd('zz', $DocumentPath_upload_invoice, $DocumentPath_upload_survey_report);
            //! INI UNTUK UPDATE REALISASI TANPA UPDATE KOLOM UPLOAD_INVOICE DAN UPLOAD_SURVEY.
            //? KOLOM UPLOAD _INVOICE DAN _SURVEY DI UPDATE DI ATAS.
            $test = DB::connection(Database::REPORT_GENERATOR)->statement("EXECUTE [dbo].[SP_Update_Group_Realization_Engineering_Fee] '$InvoiceNumber', '$type_of_invoice', '$type_of_payment', '$currency', '$invoice_date', '$broker_id', '$payment_to', '$approval_bu', '$approval_finance', '$epo_checker', '$epo_approval', '$status_realization', '$remarks', '$lastUpdateBy', '$lastUpdate', '$date_of_request'");

            // dd('xc');

            return 'ok';
        } catch (Exception $e) {
            Log::error('Error Update Realization Group on Realization Helper Update Exception = ' . $e->getMessage());
        }
    }

    public static function UpdateRealizationGroupStatus($status, $InvoiceNumber = null){
        try {
            $lastUpdateBy = auth()->user()->UserId;
            $lastUpdate = now()->format('Y-m-d');

            DB::connection(Database::REPORT_GENERATOR)->statement("EXECUTE [dbo].[SP_Update_Group_Status_Realization_Engineering_Fee] '$InvoiceNumber', '$status', '$lastUpdateBy', '$lastUpdate'");
        } catch (Exception $e) {
            Log::error('Error Update Realization Group on Realization Helper Update Exception = ' . $e->getMessage());
        }
    }

    public static function UpdateBudgetRealization($RealizationData){
        $TypeOfInvoice = $RealizationData->Type_Of_Invoice;
        $DetailRealizationData = DetailRealization::GetDetailRealization($RealizationData->ID);

        $IsOverLimit = false;
        foreach( $DetailRealizationData as $val ){
            if( ($val->total_amount_realization  / $val->exchange_rate_realization) > $val->REMAIN_BUDGET ) {
                $IsOverLimit = true;
                break;
            }
        }
        
        if( $IsOverLimit ) {
            return BudgetStatus::OVERLIMIT;
        }
        
        foreach( $DetailRealizationData as $val ){
            $IsOverLimit = false;
            switch ($TypeOfInvoice) {
                case 'RMF':
                    $OriginalAmountRealization = ($val->total_amount_realization  / $val->exchange_rate_realization);
                    $IsOverLimit = $OriginalAmountRealization > $val->REMAIN_BUDGET ? true : false;
                    try {
                        $RemainBudget = ($val->REMAIN_BUDGET - $OriginalAmountRealization);

                        DB::connection(Database::REPORT_GENERATOR)->statement("EXECUTE [dbo].[SP_Update_Budget_Realization_RMF_Engineering_Fee] $OriginalAmountRealization, '$val->VOUCHER', '' ");

                        DB::connection(Database::REPORT_GENERATOR)->statement("EXECUTE [dbo].[SP_Update_Budget_Realization_Remain_Budget_Engineering_Fee] $RemainBudget, '$val->VOUCHER', '' ");
                    } catch (Exception $e) {
                        Log::error('Error While Updating Budget on Realization Type ' . $TypeOfInvoice . ' Exception = ' . $e->getMessage());
                    }
                    
                    break;
                case 'Sponsorship':
                    $OriginalAmountRealization = ($val->total_amount_realization  / $val->exchange_rate_realization);
                    $IsOverLimit = $OriginalAmountRealization > $val->REMAIN_BUDGET ? true : false;
                    try {
                        $RemainBudget = ($val->REMAIN_BUDGET - $OriginalAmountRealization);

                        DB::connection(Database::REPORT_GENERATOR)->statement("EXECUTE [dbo].[SP_Update_Budget_Realization_Sponsorship_Engineering_Fee] $OriginalAmountRealization, '$val->VOUCHER', '' ");

                        DB::connection(Database::REPORT_GENERATOR)->statement("EXECUTE [dbo].[SP_Update_Budget_Realization_Remain_Budget_Engineering_Fee] $RemainBudget, '$val->VOUCHER', '' ");
                    } catch (Exception $e) {
                        Log::error('Error While Updating Budget on Realization Type ' . $TypeOfInvoice . ' Exception = ' . $e->getMessage());
                    }
                    break;
                default:
                break;
            }
        }

        return BudgetStatus::NOTOVERLIMIT;
    }

    public static function UpdateRealizationGroupEpo($invoice_no, $PID) {
        try {
            DB::connection(Database::REPORT_GENERATOR)->statement("EXECUTE [dbo].[SP_Update_Group_ePO_Realization_Engineering_Fee] '$invoice_no', '$PID'");
        } catch(Exception $e) {
            Log::error('Error Update Realization Group on Realization Helper Update Epo_No Exception = ' . $e->getMessage());
        }
    }


    // // ! Report
    // public static function GetReportRealizationSummary($start_date, $end_date, $status_realization){
    //     $start_date = str_replace('/', '-', $start_date);
    //     $end_date = str_replace('/', '-', $end_date);
    //     return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Report_Realization_Summary_Engineering_Fee] '$start_date', '$end_date', '$status_realization'");
    // }

    // public static function GetReportRealizationDetail($start_date, $end_date, $status_realization){
    //     $start_date = str_replace('/', '-', $start_date);
    //     $end_date = str_replace('/', '-', $end_date);
    //     return DB::connection(Database::REPORT_GENERATOR)->select("EXECUTE [dbo].[SP_Report_Realization_Detail_Engineering_Fee] '$start_date', '$end_date', '$status_realization'");
    // }


    // ! Untuk EPO
    public static function InsertEpo($RealizationData){
        $LinkApproval = Utils::getRandomString(50, 'lower-string');
        $LinkChecker = Utils::getRandomString(50, 'lower-string');

        $DetailRealizationData = DetailRealization::GetDetailRealization($RealizationData->ID);
        $TotalRealization = 0;
        foreach( $DetailRealizationData as $val ) {
            $TotalRealization += $val->total_amount_realization;
        }
        $InvoiceNo = $RealizationData->Invoice_No;
        $FileSizeInvoice = $RealizationData->Upload_Invoice_Path != '' ? filesize($RealizationData->Upload_Invoice_Path) : 0;
        $FileSizeSurvey_Report = $RealizationData->Upload_Survey_Report_Path != '' ? filesize($RealizationData->Upload_Survey_Report_Path) : 0;

        //! to save the image using SP, on the SP ImgFile will be converted to VARBINARY().
        $filePathInvoice = $RealizationData->Upload_Invoice_Path;
        $filePathSurvey_Report = $RealizationData->Upload_Survey_Report_Path;
        
        if( $filePathInvoice != '' ){
            $fileContent = file_get_contents(config('app.PUBLIC_PATH').'/'.$filePathInvoice);
            $Invoice = unpack("H*hex", $fileContent);
            $Invoice = '0x'.$Invoice['hex'];
        }else{
            $Invoice = 0;
        }

        if( $filePathSurvey_Report != '' ){
            $fileContent = file_get_contents(config('app.PUBLIC_PATH').'/'.$filePathSurvey_Report);
            $Survey_Report = unpack("H*hex", $fileContent);
            $Survey_Report = '0x'.$Survey_Report['hex'];
        }else{
            $Survey_Report = 0;
        }

        // dd($InvoiceNo, $TotalRealization, $FileSizeInvoice, $Invoice, $LinkApproval, $LinkChecker, $FileSizeSurvey_Report, $Survey_Report);
        
        try {
            $results  = DB::connection("EPO114")->select("EXECUTE [dbo].[SP_Insert_ePO_Engineering_Fee] '$InvoiceNo', $TotalRealization, $FileSizeInvoice, $Invoice, '$LinkApproval', '$LinkChecker', $FileSizeSurvey_Report, $Survey_Report");

            if( !empty($results ) ){
                return ['status' => true, 'message' => 'ok', 'pid' => $results[0]->pid];
            }
            return ['status' => true, 'message' => 'ok', 'pid' => 0];
        } catch (Exception $e) {
            Log::error('Error While Inserting EPO When Finance Approve Invoice ' .$InvoiceNo . ' Exception = ' . $e->getMessage());
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}

?>