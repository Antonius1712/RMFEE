<?php

namespace App\Http\Controllers;

use App\Enums\BudgetStatus;
use App\Enums\HardCoded;
use App\Enums\LogStatus;
use App\Helpers\Budget;
use App\Helpers\Logger;
use App\Helpers\GetData;
use App\Helpers\Utils;
use Exception;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Yajra\Datatables\Services\DataTable;

class BudgetController extends Controller
{
    public $brokerName, $startDate, $endDate, $class, $branch, $noPolicy, $agingRmf, $nBrn, $theInsured, $statusPremi, $statusRealisasi, $toDoList, $statusBudget;

    public $NBRN;

    public function __construct(){
        
    }

    public function index(){
        $this->toDoList = isset( request()->to_do_list ) ? request()->to_do_list : '';
        $this->branch = Utils::GetBranch();

        $NBRN = HardCoded::NBRN;
        $statusPremi = HardCoded::statusPremi;
        $statusRealisasi = HardCoded::statusRealisasi;
        $statusBudget = HardCoded::statusBudget;

        $branch = $this->branch;

        return view('pages.budget.list', compact('NBRN', 'branch', 'statusPremi', 'statusRealisasi', 'statusBudget'));
    }

    public function edit($voucher, $archived = 0){
        $voucher = str_replace('~', '/', $voucher);
        $Budget = Budget::GetBudget($voucher, $archived);
        $Logs = Logger::GetLog(LogStatus::BUDGET, $voucher);
        $BudgetInAmount = ($Budget->Budget/100) * $Budget->LGI_PREMIUM;
        $VoucherId = str_replace("/", "~", $Budget->VOUCHER);
        $BrokerId = explode('-', $Budget->BROKERNAME, 2)[0];
        $BrokerName = explode('-', $Budget->BROKERNAME, 2)[1];
        return view('pages.budget.edit', compact('Budget', 'BudgetInAmount', 'VoucherId', 'BrokerName', 'BrokerId', 'Logs'));
    }

    public function update(Request $request, $voucher){
        $action = $request->action;
        if( $action == 'save' ) {
            $desc = 'Saved';
        } else if( $action == 'propose' ) {
            $desc = 'Proposed';
        }
        $RedirectVoucher = str_replace('~', '/', $voucher);
        Budget::UpdateBudget($request, $voucher);
        Logger::SaveLog(LogStatus::BUDGET, $RedirectVoucher, $desc);
        return redirect()->route('budget.list')->with('noticication', 'Voucher <b>'.$RedirectVoucher.'</b> Successfully '. $desc);
    }

    public function archiveList(){
        $BudgetStatus = BudgetStatus::ARCHIVED;
        return view('pages.budget.archive', compact('BudgetStatus'));
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
        $query_url_filter = $request->query();
        // dd($request->all(), $request->query(), $voucher);
        foreach(  $query_url_filter as $key => $val){
            ${"filter_".$key} = $val;
        }

        $broker_name = isset($filter_broker_name) ? $filter_broker_name : '';
        $branch = isset($filter_branch) ? $filter_branch : '';
        $status_pembayaran_premi = isset($filter_status_pembayaran_premi) ? $filter_status_pembayaran_premi : '';
        $start_date = isset($filter_start_date) ? $filter_start_date : '';
        $no_policy = isset($filter_no_policy) ? $filter_no_policy : '';
        $aging_rmf = isset($filter_aging_rmf) ? $filter_aging_rmf : '';
        $nb_rn = isset($filter_nb_rn) ? $filter_nb_rn : '';
        $holder_name = isset($filter_holder_name) ? $filter_holder_name : '';
        $status_realisasi = isset($filter_status_realisasi) ? $filter_status_realisasi : '';
        $ClassBusiness = isset($filter_ClassBusiness) ? $filter_ClassBusiness : '';
        $status_budget = isset($filter_status_budget) ? $filter_status_budget : '';
        $to_do_list = isset($filter_to_do_list) ? $filter_to_do_list : '';
        $booking_date_from = isset($filter_booking_date_from) ? $filter_booking_date_from : '';
        $booking_date_to = isset($filter_booking_date_to) ? $filter_booking_date_to : '';

        $message = $request->comment;
        $RedirectVoucher = str_replace('~', '/', $voucher);
        Budget::UpdateBudgetOnlyStatus('reject', $voucher, null);
        $message = $message != null ? ' | '.$message : null;
        Logger::SaveLog(LogStatus::BUDGET, $RedirectVoucher, 'Rejected', $message);
        return redirect()->route('budget.list')->with('noticication', 'Voucher <b>'.$RedirectVoucher.'</b> Successfully Rejected')
        ->with('broker_name', $broker_name)
        ->with('branch', $branch)
        ->with('status_pembayaran_premi', $status_pembayaran_premi)
        ->with('start_date', $start_date)
        ->with('no_policy', $no_policy)
        ->with('aging_rmf', $aging_rmf)
        ->with('nb_rn', $nb_rn)
        ->with('holder_name', $holder_name)
        ->with('status_realisasi', $status_realisasi)
        ->with('ClassBusiness', $ClassBusiness)
        ->with('status_budget', $status_budget)
        ->with('to_do_list', $to_do_list)
        ->with('booking_date_from', $booking_date_from)
        ->with('booking_date_to', $booking_date_to);
    }

    public function approve($voucher, Request $request){
        $query_url_filter = $request->query();
        foreach(  $query_url_filter as $key => $val){
            ${"filter_".$key} = $val;
        }

        $broker_name = isset($filter_broker_name) ? $filter_broker_name : '';
        $branch = isset($filter_branch) ? $filter_branch : '';
        $status_pembayaran_premi = isset($filter_status_pembayaran_premi) ? $filter_status_pembayaran_premi : '';
        $start_date = isset($filter_start_date) ? $filter_start_date : '';
        $no_policy = isset($filter_no_policy) ? $filter_no_policy : '';
        $aging_rmf = isset($filter_aging_rmf) ? $filter_aging_rmf : '';
        $nb_rn = isset($filter_nb_rn) ? $filter_nb_rn : '';
        $holder_name = isset($filter_holder_name) ? $filter_holder_name : '';
        $status_realisasi = isset($filter_status_realisasi) ? $filter_status_realisasi : '';
        $ClassBusiness = isset($filter_ClassBusiness) ? $filter_ClassBusiness : '';
        $status_budget = isset($filter_status_budget) ? $filter_status_budget : '';
        $to_do_list = isset($filter_to_do_list) ? $filter_to_do_list : '';
        $booking_date_from = isset($filter_booking_date_from) ? $filter_booking_date_from : '';
        $booking_date_to = isset($filter_booking_date_to) ? $filter_booking_date_to : '';

        // dd($to_do_list);

        $RedirectVoucher = str_replace('~', '/', $voucher);
        Budget::UpdateBudgetOnlyStatus('approve', $voucher, null);
        Logger::SaveLog(LogStatus::BUDGET, $RedirectVoucher, 'Approved');
        return redirect()->route('budget.list')->with('noticication', 'Voucher <b>'.$RedirectVoucher.'</b> Successfully Approved')
        ->with('broker_name', $broker_name)
        ->with('branch', $branch)
        ->with('status_pembayaran_premi', $status_pembayaran_premi)
        ->with('start_date', $start_date)
        ->with('no_policy', $no_policy)
        ->with('aging_rmf', $aging_rmf)
        ->with('nb_rn', $nb_rn)
        ->with('holder_name', $holder_name)
        ->with('status_realisasi', $status_realisasi)
        ->with('ClassBusiness', $ClassBusiness)
        ->with('status_budget', $status_budget)
        ->with('to_do_list', $to_do_list)
        ->with('booking_date_from', $booking_date_from)
        ->with('booking_date_to', $booking_date_to);
    }

    public function undo_approve($voucher, Request $request){
        $query_url_filter = $request->query();
        foreach(  $query_url_filter as $key => $val){
            ${"filter_".$key} = $val;
        }

        $broker_name = isset($filter_broker_name) ? $filter_broker_name : '';
        $branch = isset($filter_branch) ? $filter_branch : '';
        $status_pembayaran_premi = isset($filter_status_pembayaran_premi) ? $filter_status_pembayaran_premi : '';
        $start_date = isset($filter_start_date) ? $filter_start_date : '';
        $no_policy = isset($filter_no_policy) ? $filter_no_policy : '';
        $aging_rmf = isset($filter_aging_rmf) ? $filter_aging_rmf : '';
        $nb_rn = isset($filter_nb_rn) ? $filter_nb_rn : '';
        $holder_name = isset($filter_holder_name) ? $filter_holder_name : '';
        $status_realisasi = isset($filter_status_realisasi) ? $filter_status_realisasi : '';
        $ClassBusiness = isset($filter_ClassBusiness) ? $filter_ClassBusiness : '';
        $status_budget = isset($filter_status_budget) ? $filter_status_budget : '';
        $to_do_list = isset($filter_to_do_list) ? $filter_to_do_list : '';
        $booking_date_from = isset($filter_booking_date_from) ? $filter_booking_date_from : '';
        $booking_date_to = isset($filter_booking_date_to) ? $filter_booking_date_to : '';

        $RedirectVoucher = str_replace('~', '/', $voucher);
        Budget::UpdateBudgetOnlyStatus('undo_approve', $voucher, null);
        Logger::SaveLog(LogStatus::BUDGET, $voucher, 'Undo Approved');
        return redirect()
        ->route('budget.list')
        ->with('noticication', 'Voucher <b>'.$RedirectVoucher.'</b> Successfully Undo Approved')
        ->with('broker_name', $broker_name)
        ->with('branch', $branch)
        ->with('status_pembayaran_premi', $status_pembayaran_premi)
        ->with('start_date', $start_date)
        ->with('no_policy', $no_policy)
        ->with('aging_rmf', $aging_rmf)
        ->with('nb_rn', $nb_rn)
        ->with('holder_name', $holder_name)
        ->with('status_realisasi', $status_realisasi)
        ->with('ClassBusiness', $ClassBusiness)
        ->with('status_budget', $status_budget)
        ->with('to_do_list', $to_do_list)
        ->with('booking_date_from', $booking_date_from)
        ->with('booking_date_to', $booking_date_to);
    }

    public function BudgetDataTable(Request $request){
        $type = isset($request->type) && $request->type != '' ? $request->type : '';
        $Budgets = collect(Budget::GetBudgetDataTable($type));
        // $Budgets = DataTables::of($Budgets)->make();
        // dd($Budgets);
        $Budgets = Datatables::of($Budgets)
            ->addColumn('ACTION', function($row){
                $BtnApprove = '';
                $BtnUndoApproval = '';
                $BtnEdit = '';
                $BtnDownloadDocument = '';
                $BtnReject = '';
                $BtnArchive = '';
                $BtnUnArchive = '';
                $Divider = '';
                $Voucher = str_replace('/','~',$row->VOUCHER);

                $BtnShowHide['BtnApprove'] = null;
                $BtnShowHide['BtnUndoApproval'] = null;
                $BtnShowHide['BtnEdit'] = null;
                $BtnShowHide['BtnDownloadDocument'] = null;
                $BtnShowHide['BtnReject'] = null;
                $BtnShowHide['BtnArchive'] = null;
                $BtnShowHide['BtnUnArchive'] = null;

                $BtnShowHide = Budget::ShowHideButtonBudget($row->STATUS_BUDGET, auth()->user()->getUserGroup->GroupCode);

                // dd($BtnShowHide);

                if( $BtnShowHide['BtnApprove'] ){
                    $BtnApprove = "<a class='dropdown-item success approve' href='".route('budget.approve', $Voucher)."'><i class='feather icon-check-circle'></i>Approve</a>";
                }

                if( $BtnShowHide['BtnUndoApproval'] ){
                    $BtnUndoApproval = "<a class='dropdown-item danger undo_approve' href='".route('budget.undo_approve', [$Voucher])."'><i class='feather icon-delete'></i>Undo Approval</a>";
                }

                if( $BtnShowHide['BtnEdit'] ){
                    $BtnEdit = "<a class='dropdown-item success edit' href='".route('budget.edit', [$Voucher, 0])."'><i class='feather icon-edit-2'></i>Edit</a>";
                }

                if( $BtnShowHide['BtnDownloadDocument'] ){
                    // $BtnDownloadDocument = "<a class='dropdown-item success btnViewDocumentBudget' href='#' data-toggle='modal' data-path='$row->Document_Path'><i class='feather icon-eye'></i>View Document</a>";

                    if( $row->Document_Path != '' ){
                            $BtnDownloadDocument = "<a class='dropdown-item success' href='".asset($row->Document_Path)."' class='col-lg-2' target='_blank' download=''>
                            <i class='feather icon-download'></i>
                            Download
                        </a>";
                    }
                }

                if( $BtnShowHide['BtnReject'] || $BtnShowHide['BtnArchive'] ){
                    $Divider = "<div class='dropdown-divider'></div>";
                }

                if( $BtnShowHide['BtnReject'] ){
                    // $BtnReject = "<a class='dropdown-item danger' id='RejectModal' href=".route('budget.reject', $Voucher)." data-toggle='modal'data-target='#ModalReject' data-voucher='$Voucher'><i class='feather icon-x-circle'></i>Reject</a>";
                    $BtnReject = "<a class='dropdown-item danger' id='RejectModal' data-voucher='$Voucher'><i class='feather icon-x-circle'></i>Reject</a>";
                }

                if( $BtnShowHide['BtnArchive'] ){
                    $BtnArchive = "<a class='dropdown-item danger' href=".route('budget.archive', $Voucher)."><i class='feather icon-archive'></i>Archive</a>";
                }

                if( $BtnShowHide['BtnUnArchive'] ){
                    $BtnUnArchive = "<a class='dropdown-item success' href=".route('budget.unarchive', $Voucher)."><i class='feather icon-archive'></i>Unarchive</a>";
                }

                $BtnAction = "<div class='btn-group' role='group' aria-label='Button group with nested dropdown'><div class='btn-group' role='group'><a href='#' id='BtnActionGroup' data-toggle='dropdown' aria-haspopup='true'aria-expanded='false' style=''><i class='feather icon-plus-circle icon-btn-group'></i></a><div class='dropdown-menu' aria-labelledby='BtnActionGroup'>".$BtnApprove.$BtnUndoApproval.$BtnEdit.$BtnDownloadDocument.$Divider.$BtnReject.$BtnArchive.$BtnUnArchive."</div></div></div>";

                // dd($BtnAction);
                return $BtnAction;
            })
            // ->editColumn('Start_Date', function($row){
            //     // return date('Y-m-d', strtotime($row->Start_Date));
            //     return date('d-M-Y', strtotime($row->Start_Date));
            // })
            ->editColumn('ADATE', function($row){
                // return date('Y-m-d', strtotime($row->Start_Date));
                // dd('zz', $row);
                return date('d-M-Y', strtotime($row->ADATE));
            })
            ->editColumn('Start_Date', function($row){
                // return date('Y-m-d', strtotime($row->Start_Date));
                return date('d-M-Y', strtotime($row->Start_Date));
            })
            ->editColumn('End_Date', function($row){
                // return date('Y-m-d', strtotime($row->End_Date));
                return date('d-M-Y', strtotime($row->End_Date));
            })
            ->editColumn('LGI_PREMIUM', function($row){
                return number_format($row->LGI_PREMIUM);
            })
            
            ->editColumn('PREMIUM', function($row){
                return number_format($row->PREMIUM);
            })
            ->editColumn('ADMIN', function($row){
                return number_format($row->ADMIN);
            })
            ->editColumn('DISCOUNT', function($row){
                return number_format($row->DISCOUNT);
            })
            ->editColumn('OTHERINCOME', function($row){
                return number_format($row->OTHERINCOME);
            })
            ->editColumn('PAYMENT', function($row){
                return number_format($row->PAYMENT);
            })
            ->editColumn('PAYMENT_DATE', function($row){
                // return date('Y-m-d', strtotime($row->PAYMENT_DATE));
                return date('d-M-Y', strtotime($row->PAYMENT_DATE));
            })
            ->editColumn('Budget', function($row){
                return number_format($row->Budget);
            })
            ->editColumn('REALIZATION_RMF', function($row){
                return number_format($row->REALIZATION_RMF);
            })
            ->editColumn('REALIZATION_SPONSORSHIP', function($row){
                return number_format($row->REALIZATION_SPONSORSHIP);
            })
            ->editColumn('REMAIN_BUDGET', function($row){
                return number_format($row->REMAIN_BUDGET);
            })
            ->editColumn('COMMENT', function($row){
                $arrayOfWord = explode(' ', $row->COMMENT);
                $displayText = '';

                if( count($arrayOfWord) >= 15 ){
                    foreach( $arrayOfWord as $key => $val ){
                        if( $key <= 10 ){
                            $displayText .= $val." ";
                        }
                    }
                    $displayText = rtrim($displayText, ' ');
                    $displayText.="...";
                }else{
                    $displayText = $row->COMMENT;
                }
                
                return $displayText;
            })
            ->editColumn('STATUS_BUDGET', function($row){
                if( $row->STATUS_BUDGET == 'NEW' ){
                    return '<div class="badge badge-pill badge-info" style="font-size: 16px;">
                        <li>'.$row->STATUS_BUDGET.'</li>
                    </div>';
                } else if ( $row->STATUS_BUDGET == BudgetStatus::DRAFT ){
                    return '<div class="badge badge-pill badge-info" style="font-size: 16px;">
                        <li>'.$row->STATUS_BUDGET.'</li>
                    </div>'; 
                } else if ( $row->STATUS_BUDGET == BudgetStatus::WAITING_APPROVAL ){
                    return '<div class="badge badge-pill badge-warning" style="font-size: 16px;">
                        <li>'.$row->STATUS_BUDGET.'</li>
                    </div>'; 
                } else if ( $row->STATUS_BUDGET == BudgetStatus::ARCHIVED ){
                    return '<div class="badge badge-pill badge-danger" style="font-size: 16px;">
                        <li>'.$row->STATUS_BUDGET.'</li>
                    </div>'; 
                } else if ( $row->STATUS_BUDGET == BudgetStatus::APPROVED ){
                    return '<div class="badge badge-pill badge-success" style="font-size: 16px;">
                        <li>'.$row->STATUS_BUDGET.'</li>
                    </div>'; 
                } else if ( $row->STATUS_BUDGET == BudgetStatus::REJECTED ){
                    return '<div class="badge badge-pill badge-danger" style="font-size: 16px;">
                        <li>'.$row->STATUS_BUDGET.'</li>
                    </div>'; 
                }
            })
            ->rawColumns(['ACTION', 'STATUS_BUDGET'])
            ->setRowAttr([
                'data-comment' => function($row){
                    return $row->COMMENT;
                }
            ])
        ->make(true);
        
        // dd($Budgets);
        return $Budgets;
    }
}

