<?php

namespace App\Http\Controllers;

use App\Enums\BudgetStatus;
use App\Enums\GroupCodeApplication;
use App\Enums\RealizationStatus;
use App\Helpers\DetailRealization;
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

    public function __construct(){
        $this->TypeOfInvoice = [
            'RMF',
            'Sponsorship'
        ];

        $this->TypeOfPayment = [
            'Reimbursement',
            'Offset Payment'
        ];
    }

    public function index(){
        $RealizationData = Realization::GetRealization();
        $AuthUserGroup = Auth()->user()->getUserGroup->GroupCode;
        
        $Action = [];
        if( $RealizationData != null ){
            foreach( $RealizationData as $key => $val ) {
                $invoice_no = str_replace('/', '-', $val->Invoice_No);
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
                                break;
                            case RealizationStatus::REJECTED:
                                $Action[$key] = "
                                    <a name='propose' class='dropdown-item success' href='".route('realization.edit', $val->Invoice_No)."'>
                                        <i class='feather icon-edit-2'></i>
                                        Edit
                                    </a>
                                ";
                            default:
                                $Action[$key] = "
                                    <a class='dropdown-item success' href='".route('realization.show', $val->Invoice_No)."'>
                                        <i class='feather icon-eye'></i>
                                        View
                                    </a>
                                ";
                            break;
                        }
                        break;
                    case GroupCodeApplication::HEAD_BU_RMFEE:
                        switch ($val->Status_Realization) {
                            case RealizationStatus::WAITING_APPROVAL_BU:
                                $Action[] = "
                                    <a name='approve' class='dropdown-item success' href='".route('realization.approve', $val->Invoice_No)."'>
                                        <i class='feather icon-check'></i>
                                        Approve
                                    </a>
                                    <a class='dropdown-item success' href='".route('realization.show', $val->Invoice_No)."'>
                                        <i class='feather icon-eye'></i>
                                        View
                                    </a>
                                    <div class='dropdown-divider'></div>
                                    <a class='dropdown-item danger' href='".route('realization.reject', $val->Invoice_No)."'>
                                        <i class='feather icon-trash'></i>
                                        Reject
                                    </a>
                                ";
                                break;
                            default:
                                $Action[] = "";
                                break;
                            break;
                        }
                        break;
                    case GroupCodeApplication::HEAD_FINANCE_RMFEE:
                        switch ($val->Status_Realization) {
                            case RealizationStatus::WAITING_APPROVAL_FINANCE:
                                $Action[$key] = "
                                    <a name='approve' class='dropdown-item success' href='".route('realization.approve', $val->Invoice_No)."'>
                                        <i class='feather icon-check'></i>
                                        Approve
                                    </a>
                                    <a class='dropdown-item success' href='".route('realization.show', $val->Invoice_No)."'>
                                        <i class='feather icon-eye'></i>
                                        View
                                    </a>
                                    <div class='dropdown-divider'></div>
                                    <a class='dropdown-item danger' href='".route('realization.reject', $val->Invoice_No)."'>
                                        <i class='feather icon-trash'></i>
                                        Reject
                                    </a>
                                ";
                                break;
                            default:
                                $Action[] = "";
                                break;
                            break;
                        }
                    default:
                    break;
                }
            }
        }

        // dd($Action, $RealizationData);

        return view('pages.realization.index', compact('RealizationData', 'Action'));
    }

    public function create(){
        $Currencies = Utils::GetCurrencies();
        $TypeOfInvoice = $this->TypeOfInvoice;
        $TypeOfPayment = $this->TypeOfPayment;
        return view('pages.realization.create', compact('Currencies', 'TypeOfInvoice', 'TypeOfPayment'));
    }

    public function store(Request $request){
        $action = $request->action;
        switch ($action) {
            case 'add_detail':
                $redirect = redirect()->route('realization.detail-realization.index', $request->invoice_no);
                $request['StatusRealization'] = RealizationStatus::DRAFT;
                break;
            case 'save':
                $redirect = redirect()->route('realization.index');
                $request['StatusRealization'] = RealizationStatus::DRAFT;
                break;
            case 'propose':
                $redirect = redirect()->route('realization.index');
                $request['StatusRealization'] = RealizationStatus::WAITING_APPROVAL_BU;
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

        return $redirect;
    }

    public function edit($invoice_no ){
        $invoice_no_real = str_replace('-', '/', $invoice_no);
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

        // dd($RealizationData);   

        return view('pages.realization.edit', compact('RealizationData', 'Currencies', 'TypeOfInvoice', 'TypeOfPayment', 'BrokerData', 'PaymentToData', 'TotalAmountRealized', 'TotalAmountRealization', 'invoice_no'));
    }

    public function update(Request $request, $InvoiceNumber){
        $action = $request->action;
        switch ($action) {
            case 'add_detail':
                Realization::UpdateRealizationGroup($request, $InvoiceNumber, RealizationStatus::DRAFT);
                $redirect = redirect()->route('realization.detail-realization.index', $InvoiceNumber);
                break;
            case 'save':
                Realization::UpdateRealizationGroup($request, $InvoiceNumber, RealizationStatus::DRAFT);
                $redirect = redirect()->route('realization.index');
                break;
            case 'propose':
                Realization::UpdateRealizationGroup($request, $InvoiceNumber, RealizationStatus::WAITING_APPROVAL_BU);
                $redirect = redirect()->route('realization.index');
                break;
            default:
                $redirect = redirect()->route('realization.index');
                break;
        }

        return $redirect;
    }

    public function show($invoice_no){
        $RealizationData = Realization::GetRealization($invoice_no)[0];
        $Currencies = Utils::GetCurrencies();
        $BrokerData = null;
        $PaymentToData = null;
        if( isset($RealizationData->Broker_ID) && $RealizationData->Broker_ID != null ){
            $BrokerData = Utils::GetProfile($RealizationData->Broker_ID, $RealizationData->Currency);
        }

        if( isset($RealizationData->Payment_To_ID) && $RealizationData->Payment_To_ID != null ){
            $PaymentToData = Utils::GetProfile($RealizationData->Payment_To_ID, $RealizationData->Currency);
        }

        // dd($BrokerData, $RealizationData, $RealizationData);

        $UserSetting = ReportGenerator_UserSetting::where('UserID', $RealizationData->CreatedBy)->first();

        // dd($RealizationData->CreatedBy, $UserSetting);
        $TypeOfInvoice = $this->TypeOfInvoice;
        $TypeOfPayment = $UserSetting->Type_Of_Payment;
        $ApprovalBU = $UserSetting->Approval_BU_UserID;
        $ApprovalFinance = $UserSetting->Approval_Finance_UserID;
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

        return view('pages.realization.show', compact('RealizationData', 'Currencies', 'TypeOfInvoice', 'TypeOfPayment', 'BrokerData', 'PaymentToData', 'TotalAmountRealization', 'TotalRealizationRMF', 'TotalRealizationSponsorship', 'ApprovalBU', 'ApprovalFinance', 'EpoChecker', 'EpoApproval'));
    }

    public function approve($invoice_no){
        $AuthUserGroup = Auth()->user()->getUserGroup->GroupCode;
        $RealizationData = Realization::GetRealization($invoice_no)[0];
        try {
            switch ($AuthUserGroup) {
                case GroupCodeApplication::HEAD_BU_RMFEE:
                    $StatusRealisasi = RealizationStatus::WAITING_APPROVAL_FINANCE;
                    break;
                case GroupCodeApplication::HEAD_FINANCE_RMFEE:
                    try {
                        $Budget = Realization::UpdateBudgetRealization($RealizationData);
                        if( $Budget == BudgetStatus::OVERLIMIT ) {
                            return redirect()->back()->withErrors('You Have an Overlimit Budget inside this Invoice. <strong>'.$invoice_no.'</strong>');
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
                        Realization::UpdateRealizationGroupEpo($invoice_no, $PID);

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
                        return redirect()->back()->withErrors('Error on Approve Finance. Invoice. <strong>'.$invoice_no.'</strong>');
                    }

                    // TODO buat table log untuk send email, isinya id, pid, realisasi_id, email_sent. hanya setelah sukses insert epo. untuk dapetin pid.
                    // TODO save email bu jessy / yang lainnya di log email? kata rahmat ada di [SP_Email_PDF_ePO_Engineering_Fee].

                    // id, pid, realisasi_id, email_sent, email_to, created_at, created_time, updated_at, updated_time.

                    break;
                default:
                break;
            }
            Realization::UpdateRealizationGroupStatus($StatusRealisasi, $invoice_no);
        } catch (Exception $e) {
            Log::error('Error Update Realization Group on Approve Exception = ' . $e->getMessage());
        }
        return redirect()->back()->with('noticication', 'Invoice <b>'.$invoice_no.'</b> Successfully Approved');
    }

    public function propose($invoice_no){
        try {
            Realization::UpdateRealizationGroupStatus(RealizationStatus::WAITING_APPROVAL_BU, $invoice_no);
        } catch (Exception $e) {
            Log::error('Error Update Realization Group on Approve Exception = ' . $e->getMessage());
        }
        return redirect()->back()->with('noticication', 'Invoice <b>'.$invoice_no.'</b> Successfully Proposed');
    }

    public function reject($invoice_no){
        try {
            Realization::UpdateRealizationGroupStatus(RealizationStatus::REJECTED, $invoice_no);
        } catch (Exception $e) {
            Log::error('Error Update Realization Group on Approve Exception = ' . $e->getMessage());
        }
        return redirect()->back()->with('noticication', 'Invoice <b>'.$invoice_no.'</b> Successfully Rejected');
    }
}
