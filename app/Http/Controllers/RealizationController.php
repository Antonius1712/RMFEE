<?php

namespace App\Http\Controllers;

use App\Enums\BudgetStatus;
use App\Enums\GroupCodeApplication;
use App\Enums\HardCoded;
use App\Enums\LogStatus;
use App\Enums\RealizationStatus;
use App\Helpers\DetailRealization;
use App\Helpers\Logger;
use App\Helpers\Realization;
use App\Helpers\Utils;
use App\Model\Epo_PO_Header;
use App\Model\ReportGenerator_LogEmailEpo;
use App\Model\ReportGenerator_Realization_Group;
use App\Model\ReportGenerator_UserSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\Datatables\Datatables;

class RealizationController extends Controller
{
    public $TypeOfInvoice, $TypeOfPayment;
    public $RealizationStatus, $COB;

    public function __construct(){
        $this->TypeOfInvoice = [
            'RMF',
            'Sponsorship'
        ];

        $this->TypeOfPayment = [
            'Reimbursement',
            'Offset Payment'
        ];

        $this->RealizationStatus = RealizationStatus::LIST;
        $this->COB = HardCoded::COB;
    }

    public function index(Request $request){
        $FilterStatusRealization = isset($request->status_realization) ? $request->status_realization : null;
        $FilterBrokerName = isset($request->broker_name) ? $request->broker_name : null;
        $FilterLastUpdate = isset($request->last_update) ? $request->last_update : null;
        $FilterInvoiceNo = isset($request->invoice_no) ? $request->invoice_no : null;
        $FilterCOB = isset($request->cob) ? $request->cob : null;

        $FilterLastUpdate = $FilterLastUpdate != '' ? date('m/d/Y', strtotime($FilterLastUpdate)) : null;

        
        $RealizationStatus = $this->RealizationStatus;
        $COB = $this->COB;

        // dd($FilterStatusRealization,   $FilterBrokerName, $FilterLastUpdate, $FilterInvoiceNo, $FilterCOB);

        $RealizationData = Realization::GetRealization($FilterInvoiceNo, $FilterStatusRealization, $FilterBrokerName, $FilterLastUpdate, $FilterCOB);

        // dd($RealizationData);

        // dd($RealizationData, $FilterInvoiceNo, $FilterStatusRealization, $FilterBrokerName, $FilterLastUpdate, $FilterCOB);


        // dd($RealizationData);

        $AuthUserGroup = Auth()->user()->getUserGroup->GroupCode;
        
        $Action = [];
        if( $RealizationData != null ){
            foreach( $RealizationData as $key => $val ) {
                $invoice_no = str_replace('/', '~', $val->Invoice_No);
                switch ($AuthUserGroup) {
                    case GroupCodeApplication::USER_RMFEE:
                        switch ( $val->Status_Realization ) {
                            case RealizationStatus::DRAFT:
                                $Action[$key] = "
                                    <a name='propose' class='dropdown-item success' href='".route('realization.propose', $invoice_no)."'>
                                        <i class='feather icon-check'></i>
                                        Propose
                                    </a>
                                    <a name='propose' class='dropdown-item success' href='".route('realization.edit', $invoice_no)."'>
                                        <i class='feather icon-edit-2'></i>
                                        Edit
                                    </a>
                                ";
                                $string = trim(preg_replace('/\s+/', ' ', $Action[$key]));

                                $val->Action = $string;
                                break;
                            case RealizationStatus::REJECTED:
                                $Action[$key] = "
                                    <a name='propose' class='dropdown-item success' href='".route('realization.propose', $invoice_no)."'>
                                        <i class='feather icon-check'></i>
                                        Propose
                                    </a>
                                    <a name='propose' class='dropdown-item success' href='".route('realization.edit', $invoice_no)."'>
                                        <i class='feather icon-edit-2'></i>
                                        Edit
                                    </a>
                                ";
                                $string = trim(preg_replace('/\s+/', ' ', $Action[$key]));

                                $val->Action = $string;
                                break;
                            default:
                                $Action[$key] = "
                                    <a class='dropdown-item success' href='".route('realization.show', $invoice_no)."'>
                                        <i class='feather icon-eye'></i>
                                        View
                                    </a>
                                ";

                                $string = trim(preg_replace('/\s+/', ' ', $Action[$key]));

                                $val->Action = $string;
                            break;
                        }
                        break;
                    case GroupCodeApplication::HEAD_BU_RMFEE:
                        switch ($val->Status_Realization) {
                            case RealizationStatus::WAITING_APPROVAL_BU:
                                $Action[] = "
                                    <a name='approve' class='dropdown-item success' href='".route('realization.approve', $invoice_no)."'>
                                        <i class='feather icon-check'></i>
                                        Approve
                                    </a>
                                    <a class='dropdown-item success' href='".route('realization.show', $invoice_no)."'>
                                        <i class='feather icon-eye'></i>
                                        View
                                    </a>
                                    <div class='dropdown-divider'></div>
                                    <a class='dropdown-item danger' href='".route('realization.reject', $invoice_no)."'>
                                        <i class='feather icon-trash'></i>
                                        Reject
                                    </a>
                                ";
                                $string = trim(preg_replace('/\s+/', ' ', $Action[$key]));

                                $val->Action = $string;
                                break;
                            default:
                                $Action[] = "";
                                $string = trim(preg_replace('/\s+/', ' ', $Action[$key]));

                                $val->Action = $string;
                                break;
                            break;
                        }
                        break;
                    case GroupCodeApplication::HEAD_FINANCE_RMFEE:
                        switch ($val->Status_Realization) {
                            case RealizationStatus::WAITING_APPROVAL_FINANCE:
                                $Action[$key] = "
                                    <a name='approve' class='dropdown-item success' href='".route('realization.approve', $invoice_no)."'>
                                        <i class='feather icon-check'></i>
                                        Approve
                                    </a>
                                    <a class='dropdown-item success' href='".route('realization.show', $invoice_no)."'>
                                        <i class='feather icon-eye'></i>
                                        View
                                    </a>
                                    <div class='dropdown-divider'></div>
                                    <a class='dropdown-item danger' href='".route('realization.reject', $invoice_no)."'>
                                        <i class='feather icon-trash'></i>
                                        Reject
                                    </a>
                                ";
                                $string = trim(preg_replace('/\s+/', ' ', $Action[$key]));

                                $val->Action = $string;
                                break;
                            default:
                                $Action[] = "";
                                $string = trim(preg_replace('/\s+/', ' ', $Action[$key]));

                                $val->Action = $string;
                                break;
                            break;
                        }
                    default:
                    break;
                }
            }
        }

        // dd($RealizationData);

        $RealizationData = collect($RealizationData)->paginate(10);

        

        return view('pages.realization.index', compact('RealizationData', 'Action', 'RealizationStatus', 'COB', 'FilterStatusRealization', 'FilterBrokerName', 'FilterLastUpdate', 'FilterInvoiceNo', 'FilterCOB'));
    }

    public function create(){
        $Currencies = Utils::GetCurrencies();
        $TypeOfInvoice = $this->TypeOfInvoice;
        $TypeOfPayment = $this->TypeOfPayment;
        return view('pages.realization.create', compact('Currencies', 'TypeOfInvoice', 'TypeOfPayment'));
    }

    public function store(Request $request){
        $invoice_no = str_replace('/', '~', $request->invoice_no);
        $action = $request->action;
        $LogAction = '';
        switch ($action) {
            case 'add_detail':
                $redirect = redirect()->route('realization.detail-realization.index', $invoice_no);
                $request['StatusRealization'] = RealizationStatus::DRAFT;
                $LogAction = 'ADD DETAIL';
                break;
            case 'save':
                $redirect = redirect()->route('realization.index');
                $request['StatusRealization'] = RealizationStatus::DRAFT;
                $LogAction = 'SAVE';
                break;
            case 'propose':
                $redirect = redirect()->route('realization.index');
                $request['StatusRealization'] = RealizationStatus::WAITING_APPROVAL_BU;
                $LogAction = 'PROPOSE';
                break;
            default:
                $redirect = redirect()->route('realization.index');
                break;
        }

        try {
            $ValidateRealization = ReportGenerator_Realization_Group::where('invoice_no', $request->invoice_no)->count();
            if( $ValidateRealization > 0 ){
                return redirect()->back()->withErrors("There's an existing Realization with this Invoice No.");
            }
            Realization::InsertRealizationGroup($request);
        } catch (Exception $e) {
            Log::error('Error Insert Realization Group on ' . $action . ' Exception = ' . $e->getMessage());
        }

        $Realization_id = ReportGenerator_Realization_Group::where('invoice_no', $request->invoice_no)->value('id');
        Logger::SaveLog(LogStatus::REALIZATION, $Realization_id, $LogAction);

        return $redirect;
    }

    public function edit($invoice_no){
        $invoice_no_real = str_replace('~', '/', $invoice_no);
        $RealizationData = Realization::GetRealization($invoice_no_real)[0];
        $Currencies = Utils::GetCurrencies();
        $BrokerData = null;
        $PaymentToData = null;
        if( isset($RealizationData->Broker_ID) && $RealizationData->Broker_ID != null ){
            $BrokerData = Utils::GetProfile($RealizationData->Broker_ID, $RealizationData->Currency);
        }

        if( isset($RealizationData->Payment_To_ID) && $RealizationData->Payment_To_ID != null ){
            $PaymentToData = Utils::GetProfile($RealizationData->Payment_To_ID, $RealizationData->Currency);
        }
        $TypeOfInvoice = $this->TypeOfInvoice;
        $TypeOfPayment = $this->TypeOfPayment;
        // dd($RealizationData, $Currencies, $TypeOfInvoice, $TypeOfPayment, $BrokerData, $PaymentToData);

        $UserSetting = ReportGenerator_UserSetting::where('UserID', $RealizationData->CreatedBy)->first();
        $ApprovalBU = $UserSetting->Approval_BU_UserID;
        $ApprovalBUName = $UserSetting->getApprovalBUName();

        $ApprovalFinance = $UserSetting->Approval_Finance_UserID;
        $ApprovalFinanceName = $UserSetting->getApprovalFinanceName();

        $TotalAmountRealization = 0;
        $TotalRealizationRMF = 0;
        $TotalRealizationSponsorship = 0;
        $TotalAmountRealized = 0;

        // dd($RealizationData);

        $DetailRealizationData = Realization::GetDetailRealization($RealizationData->ID);
        foreach($DetailRealizationData as $val){
            $TotalAmountRealization += $val->total_amount_realization;
            $TotalAmountRealized += ($val->REALIZATION_RMF + $val->REALIZATION_SPONSORSHIP);
            // if( $RealizationData->Type_Of_Invoice == 'RMF' ){
            //     $TotalRealizationRMF += $val->REALIZATION_RMF;
            // } else if ( $RealizationData->Type_Of_Invoice == 'Sponsorship' ) {
            //     $TotalRealizationSponsorship += $val->REALIZATION_SPONSORSHIP;
            // }
        }

        $Logs = Logger::GetLog(LogStatus::REALIZATION, $RealizationData->ID);

        // dd($RealizationData, $Logs);   

        return view('pages.realization.edit', compact('RealizationData', 'Currencies', 'TypeOfInvoice', 'TypeOfPayment', 'BrokerData', 'PaymentToData', 'TotalAmountRealized', 'TotalAmountRealization', 'invoice_no', 'ApprovalBU', 'ApprovalBUName', 'ApprovalFinance', 'ApprovalFinanceName', 'Logs'));
    }

    public function update(Request $request, $InvoiceNumber){
        $invoice_no_real = str_replace('~', '/', $InvoiceNumber);
        $action = $request->action;
        $LogAction = '';
        switch ($action) {
            case 'add_detail':
                Realization::UpdateRealizationGroup($request, $InvoiceNumber, RealizationStatus::DRAFT);
                $redirect = redirect()->route('realization.detail-realization.index', $InvoiceNumber);
                $LogAction = 'ADD DETAIL';
                break;
            case 'save':
                Realization::UpdateRealizationGroup($request, $InvoiceNumber, RealizationStatus::DRAFT);
                $redirect = redirect()->route('realization.index');
                $LogAction = 'UPDATE';
                break;
            case 'propose':
                Realization::UpdateRealizationGroupStatus(RealizationStatus::WAITING_APPROVAL_BU, $invoice_no_real);
                Realization::UpdateRealizationGroup($request, $InvoiceNumber, RealizationStatus::WAITING_APPROVAL_BU);
                $redirect = redirect()->route('realization.index');
                $LogAction = 'PROPOSE';
                break;
            default:
                $redirect = redirect()->route('realization.index');
                break;
        }

        $Realization_id = ReportGenerator_Realization_Group::where('invoice_no', $invoice_no_real)->value('id');

        Logger::SaveLog(LogStatus::REALIZATION, $Realization_id, $LogAction);

        return $redirect;
    }

    public function show($invoice_no){
        $invoice_no_real = str_replace('~', '/', $invoice_no);
        $RealizationData = Realization::GetRealization($invoice_no_real)[0];

        $Currencies = Utils::GetCurrencies();
        $BrokerData = null;
        $PaymentToData = null;
        if( isset($RealizationData->Broker_ID) && $RealizationData->Broker_ID != null ){
            // $BrokerData = Utils::GetProfile($RealizationData->Broker_ID, $RealizationData->Currency);
            $BrokerData = Utils::GetProfile($RealizationData->Broker_ID, $RealizationData->Currency);
        }

        // dd($BrokerData, $RealizationData);

        if( isset($RealizationData->Payment_To_ID) && $RealizationData->Payment_To_ID != null ){
            $PaymentToData = Utils::GetProfile($RealizationData->Payment_To_ID, $RealizationData->Currency);
        }

        $UserSetting = ReportGenerator_UserSetting::where('UserID', $RealizationData->CreatedBy)->first();
        

        // dd($RealizationData->CreatedBy, $UserSetting);
        $TypeOfInvoice = $this->TypeOfInvoice;
        $TypeOfPayment = $UserSetting->Type_Of_Payment;
        $ApprovalBU = $UserSetting->Approval_BU_UserID;
        $ApprovalBUName = $UserSetting->getApprovalBUName();

        $ApprovalFinance = $UserSetting->Approval_Finance_UserID;
        $ApprovalFinanceName = $UserSetting->getApprovalFinanceName();

        $EpoChecker = $UserSetting->CheckerID_ePO;
        $EpoApproval = $UserSetting->ApprovalID_ePO;

        $TotalAmountRealization = 0;
        $TotalRealizationRMF = 0;
        $TotalRealizationSponsorship = 0;

        $DetailRealizationData = Realization::GetDetailRealization($RealizationData->ID);
        foreach($DetailRealizationData as $val){
            $TotalAmountRealization += $val->total_amount_realization;
            if( $RealizationData->Type_Of_Invoice == 'RMF' ){
                $TotalRealizationRMF += $val->REALIZATION_RMF;
            } else if ( $RealizationData->Type_Of_Invoice == 'Sponsorship' ) {
                $TotalRealizationSponsorship += $val->REALIZATION_SPONSORSHIP;
            }
        }

        $Logs = Logger::GetLog(LogStatus::REALIZATION, $RealizationData->ID);

        return view('pages.realization.show', compact('RealizationData', 'Currencies', 'TypeOfInvoice', 'TypeOfPayment', 'BrokerData', 'PaymentToData', 'TotalAmountRealization', 'TotalRealizationRMF', 'TotalRealizationSponsorship', 'ApprovalBU', 'ApprovalBUName', 'ApprovalFinance', 'ApprovalFinanceName', 'EpoChecker', 'EpoApproval', 'Logs'));
    }

    public function approve($invoice_no){
        $invoice_no_real = str_replace('~', '/', $invoice_no);
        $AuthUserGroup = Auth()->user()->getUserGroup->GroupCode;
        $RealizationData = Realization::GetRealization($invoice_no_real)[0];
        try {
            switch ($AuthUserGroup) {
                case GroupCodeApplication::HEAD_BU_RMFEE:
                    $StatusRealisasi = RealizationStatus::WAITING_APPROVAL_FINANCE;
                    break;
                case GroupCodeApplication::HEAD_FINANCE_RMFEE:
                    try {
                        $Budget = Realization::UpdateBudgetRealization($RealizationData);
                        if( $Budget == BudgetStatus::OVERLIMIT ) {
                            return redirect()->back()->withErrors('You Have an Overlimit Budget inside this Invoice. <strong>'.$invoice_no_real.'</strong>');
                        }
                        $StatusRealisasi = RealizationStatus::APPROVED_BY_FINANCE;

                        // TODO IF OFFSET TIDAK PERLU INSERT EPO. HANYA REIMBURSE.
                        $UserSetting = ReportGenerator_UserSetting::where('UserID', $RealizationData->CreatedBy)->first();
                        if( $UserSetting->Type_Of_Payment == 'Reimbursement' ){
                            $InsertEpo = Realization::InsertEpo($RealizationData);
                            if( !$InsertEpo['status'] ){
                                return redirect()->back()->withErrors($InsertEpo['message']);
                            }
                        }

                        $PID = Epo_PO_Header::orderBy('PID', 'Desc')->value('PID');
                        Realization::UpdateRealizationGroupEpo($invoice_no_real, $PID);

                        $LogEmailEpo = ReportGenerator_LogEmailEpo::where('PID', $PID)->count();
                        if( $LogEmailEpo == 0 ){
                            ReportGenerator_LogEmailEpo::create([
                                'PID' => $PID,
                                'Realisasi_ID' => $RealizationData->ID,
                                'Email_To' => Utils::GetEmailEpo(),
                                'Date' => date('Y-m-d', strtotime(now())),
                                'Time' => date('H:i:s', strtotime(now()))
                            ]);
                        }
                        
                    } catch (Exception $e) {
                        Log::error('Error while saving log email epo. Exception = ' . $e->getMessage());
                        return redirect()->back()->withErrors('Error on Approve Finance. Invoice. <strong>'.$invoice_no_real.'</strong>');
                    }

                    // TODO buat table log untuk send email, isinya id, pid, realisasi_id, email_sent. hanya setelah sukses insert epo. untuk dapetin pid.
                    // TODO save email bu jessy / yang lainnya di log email? kata rahmat ada di [SP_Email_PDF_ePO_Engineering_Fee].

                    // id, pid, realisasi_id, email_sent, email_to, created_at, created_time, updated_at, updated_time.

                    break;
                default:
                break;
            }
            Realization::UpdateRealizationGroupStatus($StatusRealisasi, $invoice_no_real);
        } catch (Exception $e) {
            Log::error('Error Update Realization Group on Approve Exception = ' . $e->getMessage());
        }

        $Realization_id = ReportGenerator_Realization_Group::where('invoice_no', $invoice_no_real)->value('id');
        Logger::SaveLog(LogStatus::REALIZATION, $Realization_id, 'APPROVE');

        return redirect()->back()->with('noticication', 'Invoice <b>'.$invoice_no_real.'</b> Successfully Approved');
    }

    public function propose($invoice_no){
        $invoice_no_real = str_replace('~', '/', $invoice_no);
        try {
            Realization::UpdateRealizationGroupStatus(RealizationStatus::WAITING_APPROVAL_BU, $invoice_no_real);
        } catch (Exception $e) {
            Log::error('Error Update Realization Group on Approve Exception = ' . $e->getMessage());
        }

        $Realization_id = ReportGenerator_Realization_Group::where('invoice_no', $invoice_no_real)->value('id');
        Logger::SaveLog(LogStatus::REALIZATION, $Realization_id, 'PROPOSE');

        return redirect()->back()->with('noticication', 'Invoice <b>'.$invoice_no_real.'</b> Successfully Proposed');
    }

    public function reject($invoice_no){
        $invoice_no_real = str_replace('~', '/', $invoice_no);
        try {
            Realization::UpdateRealizationGroupStatus(RealizationStatus::REJECTED, $invoice_no_real);
        } catch (Exception $e) {
            Log::error('Error Update Realization Group on Approve Exception = ' . $e->getMessage());
        }

        $Realization_id = ReportGenerator_Realization_Group::where('invoice_no', $invoice_no_real)->value('id');
        Logger::SaveLog(LogStatus::REALIZATION, $Realization_id, 'REJECT');

        return redirect()->back()->with('noticication', 'Invoice <b>'.$invoice_no_real.'</b> Successfully Rejected');
    }
}
