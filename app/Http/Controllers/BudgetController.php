<?php

namespace App\Http\Controllers;

use App\Enums\BudgetButtons;
use App\Enums\BudgetStatus;
use App\Enums\HardCoded;
use App\Enums\LogStatus;
use App\Helpers\Budget;
use App\Helpers\Logger;
use App\Helpers\GetData;
use App\Helpers\Utils;
use App\Model\ReportGenerator_Data_Engineering_Fee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\Datatables\Datatables;
use Yajra\Datatables\Services\DataTable;

class BudgetController extends Controller
{
    public $brokerName, $startDate, $endDate, $class, $branch, $noPolicy, $agingRmf, $nBrn, $theInsured, $statusPremi, $statusRealisasi, $toDoList, $statusBudget;

    public $NBRN;

    public function __construct(){
        
    }

    public function index(Request $request){
        // dd($request->all());
        $this->toDoList = isset( request()->to_do_list ) ? request()->to_do_list : '';
        $this->branch = Utils::GetBranch();

        $NBRN = HardCoded::NBRN;
        $statusPremi = HardCoded::statusPremi;
        $statusRealisasi = HardCoded::statusRealisasiOnBudget;
        $statusBudget = HardCoded::statusBudget;

        $branchList = $this->branch;

        // --------------------------------------------------------------------------------

        $perPage = $request->get('per_page', 10); // Default to 10 if not set

        $broker_name = $request->broker_name;
        $branch = $request->branch;
        $status_pembayaran_premi = $request->status_pembayaran_premi;
        $start_date = $request->start_date;
        $no_policy = $request->no_policy;
        $aging_rmf = $request->aging_rmf;
        $booking_date_from = $request->booking_date_from;
        $booking_date_to = $request->booking_date_to;
        $nb_rn = $request->nb_rn;
        $holder_name = $request->holder_name;
        $class_business = $request->ClassBusiness;
        $status_realisasi = $request->status_realisasi;
        $status_budget = $request->status_budget;
        $ProposedTo = $request->to_do_list_filter == 'true' ? auth()->user()->NIK : '';

        $Budgets = ReportGenerator_Data_Engineering_Fee::when($broker_name != '', function($q) use ($broker_name){
            return $q->where('BROKERNAME', $broker_name);
        })->when($branch != '', function($q) use ($branch) {
            return $q->where('BRANCH', $branch);
        })->when($nb_rn != '', function($q) use ($nb_rn) {
            return $q->where('TYPE', $nb_rn);
        })->when($start_date != '', function($q) use ($start_date) {
            return $q->where('START_DATE', $start_date);
        })->when($no_policy != '', function($q) use ($no_policy) {
            return $q->where('POLICYNO', $no_policy);
        })->when($holder_name != '', function($q) use ($holder_name) {
            return $q->where('Holder_Name', $holder_name);
        })->when($status_pembayaran_premi != '', function($q) use ($status_pembayaran_premi) {
            return $q->where('Status_Premium', $status_pembayaran_premi);
        })->when($aging_rmf != '', function($q) use ($aging_rmf) {
            return $q->where('Aging_Realization', $aging_rmf);
        })->when($status_realisasi != '', function($q) use ($status_realisasi) {
            return $q->where('Status_Realization', $status_realisasi);
        })/*->when($branch != '', function($q) use ($branch) {
            return $q->where('Voucher', $branch);
        })*/->when($status_budget != '', function($q) use ($status_budget) {
            return $q->where('STATUS_BUDGET', $status_budget);
        })->when($booking_date_from != '' && $booking_date_to != '', function($q) use ($booking_date_from, $booking_date_to) {
            return $q->whereBetween('ADATE', [$booking_date_from, $booking_date_to]);
        })->when($class_business != '', function($q) use ($class_business) {
            return $q->where('CLASS', $class_business);
        })->when($ProposedTo != '', function($q) use ($ProposedTo) {
            return $q->where('ProposedTo', $ProposedTo);
        })->paginate($perPage);

        $Budgets->getCollection()->transform(function($data){
            $BtnApprove = '';
            $BtnUndoApproval = '';
            $BtnEdit = '';
            $BtnDownloadDocument = '';
            $BtnReject = '';
            $BtnArchive = '';
            $BtnUnArchive = '';
            $Divider = '';

            $Voucher = str_replace('/','~',$data->VOUCHER);

            $BtnShowHide[BudgetButtons::BTN_APPROVE] = null;
            $BtnShowHide[BudgetButtons::BTN_UNDO_APPROVE] = null;
            $BtnShowHide[BudgetButtons::BTN_EDIT] = null;
            $BtnShowHide[BudgetButtons::BTN_DOWNLOAD_DOCUMENT] = null;
            $BtnShowHide[BudgetButtons::BTN_REJECT] = null;
            $BtnShowHide[BudgetButtons::BTN_ARCHIVE] = null;
            $BtnShowHide[BudgetButtons::BTN_UNARCHIVE] = null;

            $BtnShowHide = Budget::ShowHideButtonBudget($data->STATUS_BUDGET, auth()->user()->getUserGroup->GroupCode);
            $UrlParameter = http_build_query(request()->query());
            if( $BtnShowHide[BudgetButtons::BTN_APPROVE] ){
                $BtnApprove = "<a class='dropdown-item success approve' href='".route('budget.approve', $Voucher)."?".$UrlParameter."' data-url='".route('budget.approve', $Voucher)."'><i class='feather icon-check-circle'></i>Approve</a>";
            }

            if( $BtnShowHide[BudgetButtons::BTN_UNDO_APPROVE] ){
                $BtnUndoApproval = "<a class='dropdown-item danger undo_approve' href='".route('budget.undo_approve', [$Voucher])."?".$UrlParameter."' data-url='".route('budget.undo_approve', [$Voucher])."'><i class='feather icon-delete'></i>Undo Approval</a>";
            }

            if( $BtnShowHide[BudgetButtons::BTN_EDIT] ){
                $BtnEdit = "<a class='dropdown-item success edit' href='".route('budget.edit', [$Voucher, 0])."?".$UrlParameter."'><i class='feather icon-edit-2'></i>Edit</a>";
            }

            if( $BtnShowHide[BudgetButtons::BTN_DOWNLOAD_DOCUMENT] ){
                if( $data->Document_Path != '' ){
                        $BtnDownloadDocument = "<a class='dropdown-item success' href='".asset($data->Document_Path)."' class='col-lg-2' target='_blank' download=''>
                        <i class='feather icon-download'></i>
                        Download
                    </a>";
                }
            }

            if( $BtnShowHide[BudgetButtons::BTN_REJECT] || $BtnShowHide[BudgetButtons::BTN_ARCHIVE] ){
                $Divider = "<div class='dropdown-divider'></div>";
            }

            if( $BtnShowHide[BudgetButtons::BTN_REJECT] ){
                $BtnReject = "<a class='dropdown-item danger' id='RejectModal' data-voucher='$Voucher'><i class='feather icon-x-circle'></i>Reject</a>";
            }

            if( $BtnShowHide[BudgetButtons::BTN_ARCHIVE] ){
                $BtnArchive = "<a class='dropdown-item danger' href=".route('budget.archive', $Voucher)."><i class='feather icon-archive'></i>Archive</a>";
            }

            if( $BtnShowHide[BudgetButtons::BTN_UNARCHIVE] ){
                $BtnUnArchive = "<a class='dropdown-item success' href=".route('budget.unarchive', $Voucher)."><i class='feather icon-archive'></i>Unarchive</a>";
            }

            $BtnAction = "<div class='btn-group' role='group' aria-label='Button group with nested dropdown'><div class='btn-group' role='group'><a href='#' id='BtnActionGroup' data-toggle='dropdown' aria-haspopup='true'aria-expanded='false' style=''><i class='feather icon-plus-circle icon-btn-group'></i></a><div class='dropdown-menu' aria-labelledby='BtnActionGroup'>".$BtnApprove.$BtnUndoApproval.$BtnEdit.$BtnDownloadDocument.$Divider.$BtnReject.$BtnArchive.$BtnUnArchive."</div></div></div>";
            
            $data->Action = $BtnAction;
            $data->Start_Date = date('d M Y', strtotime($data->Start_Date));
            $data->End_Date = date('d M Y', strtotime($data->End_Date));
            $data->PAYMENT_DATE = date('d M Y', strtotime($data->PAYMENT_DATE));
            $data->ADATE = date('d M Y', strtotime($data->ADATE));
            $data->LGI_PREMIUM = number_format($data->LGI_PREMIUM, 0);
            $data->PREMIUM = number_format($data->PREMIUM, 0);
            $data->ADMIN = number_format($data->ADMIN, 0);
            $data->DISCOUNT = number_format($data->DISCOUNT, 0);
            $data->OTHERINCOME = number_format($data->OTHERINCOME, 0);
            $data->PAYMENT = number_format($data->PAYMENT, 0);
            $data->Budget = number_format($data->Budget, 2);
            $data->REALIZATION_RMF = number_format($data->REALIZATION_RMF, 2);
            $data->REALIZATION_SPONSORSHIP = number_format($data->REALIZATION_SPONSORSHIP, 2);
            $data->REMAIN_BUDGET = number_format($data->REMAIN_BUDGET, 2);

            if( $data->STATUS_BUDGET == 'NEW' ){
                $data->STATUS_BUDGET_DISPLAY =  '<div class="badge badge-pill badge-info" style="font-size: 16px;">
                    <li>'.$data->STATUS_BUDGET.'</li>
                </div>';
            } else if ( $data->STATUS_BUDGET == BudgetStatus::DRAFT ){
                $data->STATUS_BUDGET_DISPLAY =  '<div class="badge badge-pill badge-info" style="font-size: 16px;">
                    <li>'.$data->STATUS_BUDGET.'</li>
                </div>'; 
            } else if ( $data->STATUS_BUDGET == BudgetStatus::WAITING_APPROVAL ){
                $data->STATUS_BUDGET_DISPLAY =  '<div class="badge badge-pill badge-warning" style="font-size: 16px;">
                    <li>'.$data->STATUS_BUDGET.'</li>
                </div>'; 
            } else if ( $data->STATUS_BUDGET == BudgetStatus::ARCHIVED ){
                $data->STATUS_BUDGET_DISPLAY =  '<div class="badge badge-pill badge-danger" style="font-size: 16px;">
                    <li>'.$data->STATUS_BUDGET.'</li>
                </div>'; 
            } else if ( $data->STATUS_BUDGET == BudgetStatus::APPROVED ){
                $data->STATUS_BUDGET_DISPLAY =  '<div class="badge badge-pill badge-success" style="font-size: 16px;">
                    <li>'.$data->STATUS_BUDGET.'</li>
                </div>'; 
            } else if ( $data->STATUS_BUDGET == BudgetStatus::REJECTED ){
                $data->STATUS_BUDGET_DISPLAY =  '<div class="badge badge-pill badge-danger" style="font-size: 16px;">
                    <li>'.$data->STATUS_BUDGET.'</li>
                </div>'; 
            }

            return $data;
        });

        return view('pages.budget.list', compact('NBRN', 'branchList', 'statusPremi', 'statusRealisasi', 'statusBudget', 'Budgets'));
    }

    // public function show($voucher, $archived = 0){
    //     $voucher = str_replace('~', '/', $voucher);
    //     $Budget = Budget::GetBudget($voucher, $archived);
    //     $Logs = Logger::GetLog(LogStatus::BUDGET, $voucher);
    //     $BudgetInAmount = ($Budget->Budget/100) * $Budget->LGI_PREMIUM;
    //     $VoucherId = str_replace("/", "~", $Budget->VOUCHER);
    //     $BrokerId = explode('-', $Budget->BROKERNAME, 2)[0];
    //     $BrokerName = explode('-', $Budget->BROKERNAME, 2)[1];
    //     $StatusBudgetWhenEditBudgetAfterApprovalShouldBe = BudgetStatus::APPROVED;
    //     return view('pages.budget.show', compact('Budget', 'BudgetInAmount', 'VoucherId', 'BrokerName', 'BrokerId', 'Logs', 'StatusBudgetWhenEditBudgetAfterApprovalShouldBe'));
    // }

    public function edit($voucher, $archived = 0){
        $voucher = str_replace('~', '/', $voucher);
        $Budget = Budget::GetBudget($voucher, $archived);
        $Logs = Logger::GetLog(LogStatus::BUDGET, $voucher);
        $BudgetInAmount = ($Budget->Budget/100) * $Budget->LGI_PREMIUM;
        $VoucherId = str_replace("/", "~", $Budget->VOUCHER);
        $BrokerId = explode('-', $Budget->BROKERNAME, 2)[0];
        $BrokerName = explode('-', $Budget->BROKERNAME, 2)[1];
        $StatusBudgetWhenEditBudgetAfterApprovalShouldBe = BudgetStatus::APPROVED;
        return view('pages.budget.edit', compact('Budget', 'BudgetInAmount', 'VoucherId', 'BrokerName', 'BrokerId', 'Logs', 'StatusBudgetWhenEditBudgetAfterApprovalShouldBe'));
    }

    public function update(Request $request, $voucher){
        // dd($request->all());
        $action = $request->action;
        if( $action == 'save' ) {
            $save_action = 'Saved';
        } else if( $action == 'propose' ) {
            $save_action = 'Proposed';
        }

        $budgetInAmount = $request->budget_in_amount;
        $remarks = isset($request->remarks) ? $request->remarks. ' / ' .$budgetInAmount : $budgetInAmount;

        // dd($remarks);

        $RedirectVoucher = str_replace('~', '/', $voucher);
        Budget::UpdateBudget($request, $voucher);
        Logger::SaveLog(LogStatus::BUDGET, $RedirectVoucher, $save_action, $remarks);
        return redirect()->route('budget.list')->with('noticication', 'Voucher <b>'.$RedirectVoucher.'</b> Successfully '. $save_action);
    }

    public function archiveList(Request $request){
        $BudgetStatus = BudgetStatus::ARCHIVED;

        $broker_name = $request->broker_name;
        $branch = $request->branch;
        $status_pembayaran_premi = $request->status_pembayaran_premi;
        $start_date = $request->start_date;
        $no_policy = $request->no_policy;
        $aging_rmf = $request->aging_rmf;
        $booking_date_from = $request->booking_date_from;
        $booking_date_to = $request->booking_date_to;
        $nb_rn = $request->nb_rn;
        $holder_name = $request->holder_name;
        $class_business = $request->ClassBusiness;
        $status_realisasi = $request->status_realisasi;
        $status_budget = BudgetStatus::ARCHIVED;
        $ProposedTo = $request->to_do_list_filter == 'true' ? auth()->user()->NIK : '';

        $Budgets = Budget::GetBudgetDataTable(
            $broker_name, $branch, $status_pembayaran_premi, $start_date, $no_policy, $aging_rmf, $booking_date_from, $booking_date_to, $nb_rn, $holder_name, $class_business, $status_realisasi, $status_budget, $ProposedTo
        );

        $Budgets = collect($Budgets)->map(function($data){
            $BtnApprove = '';
            $BtnUndoApproval = '';
            $BtnEdit = '';
            $BtnDownloadDocument = '';
            $BtnReject = '';
            $BtnArchive = '';
            $BtnUnArchive = '';
            $Divider = '';

            $Voucher = str_replace('/','~',$data->VOUCHER);

            $BtnShowHide['BtnApprove'] = null;
            $BtnShowHide['BtnUndoApproval'] = null;
            $BtnShowHide['BtnEdit'] = null;
            $BtnShowHide['BtnDownloadDocument'] = null;
            $BtnShowHide['BtnReject'] = null;
            $BtnShowHide['BtnArchive'] = null;
            $BtnShowHide['BtnUnArchive'] = null;

            $BtnShowHide = Budget::ShowHideButtonBudget($data->STATUS_BUDGET, auth()->user()->getUserGroup->GroupCode);
            $UrlParameter = http_build_query(request()->query());
            if( $BtnShowHide['BtnApprove'] ){
                $BtnApprove = "<a class='dropdown-item success approve' href='".route('budget.approve', $Voucher)."?".$UrlParameter."' data-url='".route('budget.approve', $Voucher)."'><i class='feather icon-check-circle'></i>Approve</a>";
            }

            if( $BtnShowHide['BtnUndoApproval'] ){
                $BtnUndoApproval = "<a class='dropdown-item danger undo_approve' href='".route('budget.undo_approve', [$Voucher])."?".$UrlParameter."' data-url='".route('budget.undo_approve', [$Voucher])."'><i class='feather icon-delete'></i>Undo Approval</a>";
            }

            if( $BtnShowHide['BtnEdit'] ){
                $BtnEdit = "<a class='dropdown-item success edit' href='".route('budget.edit', [$Voucher, 0])."?".$UrlParameter."'><i class='feather icon-edit-2'></i>Edit</a>";
            }

            if( $BtnShowHide['BtnDownloadDocument'] ){
                if( $data->Document_Path != '' ){
                        $BtnDownloadDocument = "<a class='dropdown-item success' href='".asset($data->Document_Path)."' class='col-lg-2' target='_blank' download=''>
                        <i class='feather icon-download'></i>
                        Download
                    </a>";
                }
            }

            if( $BtnShowHide['BtnReject'] || $BtnShowHide['BtnArchive'] ){
                $Divider = "<div class='dropdown-divider'></div>";
            }

            if( $BtnShowHide['BtnReject'] ){
                $BtnReject = "<a class='dropdown-item danger' id='RejectModal' data-voucher='$Voucher'><i class='feather icon-x-circle'></i>Reject</a>";
            }

            if( $BtnShowHide['BtnArchive'] ){
                $BtnArchive = "<a class='dropdown-item danger' href=".route('budget.archive', $Voucher)."><i class='feather icon-archive'></i>Archive</a>";
            }

            if( $BtnShowHide['BtnUnArchive'] ){
                $BtnUnArchive = "<a class='dropdown-item success' href=".route('budget.unarchive', $Voucher)."><i class='feather icon-archive'></i>Unarchive</a>";
            }

            $BtnAction = "<div class='btn-group' role='group' aria-label='Button group with nested dropdown'><div class='btn-group' role='group'><a href='#' id='BtnActionGroup' data-toggle='dropdown' aria-haspopup='true'aria-expanded='false' style=''><i class='feather icon-plus-circle icon-btn-group'></i></a><div class='dropdown-menu' aria-labelledby='BtnActionGroup'>".$BtnApprove.$BtnUndoApproval.$BtnEdit.$BtnDownloadDocument.$Divider.$BtnReject.$BtnArchive.$BtnUnArchive."</div></div></div>";
            
            $data->Action = $BtnAction;
            $data->Start_Date = date('d M Y', strtotime($data->Start_Date));
            $data->End_Date = date('d M Y', strtotime($data->End_Date));
            $data->PAYMENT_DATE = date('d M Y', strtotime($data->PAYMENT_DATE));
            $data->ADATE = date('d M Y', strtotime($data->ADATE));
            $data->LGI_PREMIUM = number_format($data->LGI_PREMIUM, 0);
            $data->PREMIUM = number_format($data->PREMIUM, 0);
            $data->ADMIN = number_format($data->ADMIN, 0);
            $data->DISCOUNT = number_format($data->DISCOUNT, 0);
            $data->OTHERINCOME = number_format($data->OTHERINCOME, 0);
            $data->PAYMENT = number_format($data->PAYMENT, 0);
            $data->Budget = number_format($data->Budget, 0);

            if( $data->STATUS_BUDGET == 'NEW' ){
                $data->STATUS_BUDGET =  '<div class="badge badge-pill badge-info" style="font-size: 16px;">
                    <li>'.$data->STATUS_BUDGET.'</li>
                </div>';
            } else if ( $data->STATUS_BUDGET == BudgetStatus::DRAFT ){
                $data->STATUS_BUDGET =  '<div class="badge badge-pill badge-info" style="font-size: 16px;">
                    <li>'.$data->STATUS_BUDGET.'</li>
                </div>'; 
            } else if ( $data->STATUS_BUDGET == BudgetStatus::WAITING_APPROVAL ){
                $data->STATUS_BUDGET =  '<div class="badge badge-pill badge-warning" style="font-size: 16px;">
                    <li>'.$data->STATUS_BUDGET.'</li>
                </div>'; 
            } else if ( $data->STATUS_BUDGET == BudgetStatus::ARCHIVED ){
                $data->STATUS_BUDGET =  '<div class="badge badge-pill badge-danger" style="font-size: 16px;">
                    <li>'.$data->STATUS_BUDGET.'</li>
                </div>'; 
            } else if ( $data->STATUS_BUDGET == BudgetStatus::APPROVED ){
                $data->STATUS_BUDGET =  '<div class="badge badge-pill badge-success" style="font-size: 16px;">
                    <li>'.$data->STATUS_BUDGET.'</li>
                </div>'; 
            } else if ( $data->STATUS_BUDGET == BudgetStatus::REJECTED ){
                $data->STATUS_BUDGET =  '<div class="badge badge-pill badge-danger" style="font-size: 16px;">
                    <li>'.$data->STATUS_BUDGET.'</li>
                </div>'; 
            }

            return $data;
        })->paginate(10);

        return view('pages.budget.archive', compact('Budgets'));
    }

    public function archive($voucher){
        $RedirectVoucher = str_replace('~', '/', $voucher);
        Budget::UpdateBudgetOnlyStatus('archive', $voucher, null);
        Logger::SaveLog(LogStatus::BUDGET, $RedirectVoucher, 'Archived');
        return redirect()->route('budget.archive-list')->with('noticication', 'Voucher <b>'.$RedirectVoucher.'</b> Successfully Archived');
    }

    public function unarchive($voucher){
        $RedirectVoucher = str_replace('~', '/', $voucher);
        Budget::UpdateBudgetOnlyStatus('draft', $voucher, null);
        Logger::SaveLog(LogStatus::BUDGET, $RedirectVoucher, 'Unarchived');
        return redirect()->route('budget.archive-list')->with('noticication', 'Voucher <b>'.$RedirectVoucher.'</b> Successfully UnArchived');
    }

    public function reject($voucher, Request $request){
        $UrlParameter = http_build_query($request->query());
        $message = $request->comment;
        $RedirectVoucher = str_replace('~', '/', $voucher);
        Budget::UpdateBudgetOnlyStatus('reject', $voucher, null);
        $message = $message != null && $message != '' ? $message : null;
        Logger::SaveLog(LogStatus::BUDGET, $RedirectVoucher, 'Rejected', $message);

        $route = route('budget.list') . '?' . $UrlParameter;
        return redirect()->to($route)->with('noticication', 'Voucher <b>'.$RedirectVoucher.'</b> Successfully Rejected');
    }

    public function approve($voucher, Request $request){
        $UrlParameter = http_build_query($request->query());
        $RedirectVoucher = str_replace('~', '/', $voucher);
        Budget::UpdateBudgetOnlyStatus('approve', $voucher, null);
        Logger::SaveLog(LogStatus::BUDGET, $RedirectVoucher, 'Approved');

        $route = route('budget.list') . '?' . $UrlParameter;
        return redirect()->to($route)->with('notification', 'Voucher <b>' . $RedirectVoucher . '</b> Successfully Approved');
    }

    public function multipleApprove(Request $request){
        $UrlParameter = http_build_query($request->query());
        $Vouchers = json_decode($request->vouchers);
        if( count($Vouchers) == 0 ){
            return redirect()->back()->with("notification", "There's no Vouchers Selected.");
        }
        foreach($Vouchers as $voucher){
            Budget::UpdateBudgetOnlyStatus('approve', $voucher, null);
            Logger::SaveLog(LogStatus::BUDGET, $voucher, 'Approved');
        }
        $route = route('budget.list') . '?' . $UrlParameter;
        return redirect()->to($route)->with('notification', 'Voucher <b>' . implode(', ', $Vouchers) . '</b> Successfully Approved');
    }

    public function undo_approve($voucher, Request $request){
        $UrlParameter = http_build_query($request->query());
        $RedirectVoucher = str_replace('~', '/', $voucher);
        Budget::UpdateBudgetOnlyStatus('undo_approve', $voucher, null);
        Logger::SaveLog(LogStatus::BUDGET, $voucher, 'Undo Approved');

        $route = route('budget.list') . '?' . $UrlParameter;
        return redirect()->to($route)->with('notification', 'Voucher <b>' . $RedirectVoucher . '</b> Successfully Undo Approved');
    }
}

