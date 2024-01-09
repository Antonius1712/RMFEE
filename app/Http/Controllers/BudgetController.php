<?php

namespace App\Http\Controllers;

use App\Enums\BudgetStatus;
use App\Enums\HardCoded;
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
        $Budget = Budget::GetBudget($voucher, $archived);
        $Logs = Logger::GetLog($voucher);
        $BudgetInAmount = ($Budget->Budget/100) * $Budget->LGI_PREMIUM;
        $VoucherId = str_replace("/", "-", $Budget->VOUCHER);
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
        $RedirectVoucher = str_replace('-', '/', $voucher);
        Budget::UpdateBudget($request, $voucher);
        Logger::SaveLog($voucher, $desc);
        return redirect()->route('budget.list')->with('noticication', 'Voucher <b>'.$RedirectVoucher.'</b> Successfully '. $desc);
    }

    public function archiveList(){
        $BudgetStatus = BudgetStatus::ARCHIVED;
        return view('pages.budget.archive', compact('BudgetStatus'));
    }

    public function archive($voucher){
        $RedirectVoucher = str_replace('-', '/', $voucher);
        Budget::UpdateBudgetOnlyStatus('archive', $voucher, null);
        Logger::SaveLog($voucher, 'Archived');
        return redirect()->route('budget.archive-list')->with('noticication', 'Voucher <b>'.$RedirectVoucher.'</b> Successfully Archived');
    }

    public function unarchive($voucher){
        $RedirectVoucher = str_replace('-', '/', $voucher);
        Budget::UpdateBudgetOnlyStatus('draft', $voucher, null);
        Logger::SaveLog($voucher, 'Unarchived');
        return redirect()->route('budget.archive-list')->with('noticication', 'Voucher <b>'.$RedirectVoucher.'</b> Successfully UnArchived');
    }

    public function reject($voucher){
        $RedirectVoucher = str_replace('-', '/', $voucher);
        Budget::UpdateBudgetOnlyStatus('reject', $voucher, null);
        Logger::SaveLog($voucher, 'Rejected');
        return redirect()->route('budget.list')->with('noticication', 'Voucher <b>'.$RedirectVoucher.'</b> Successfully Rejected');
    }

    public function approve($voucher){
        $RedirectVoucher = str_replace('-', '/', $voucher);
        Budget::UpdateBudgetOnlyStatus('approve', $voucher, null);
        Logger::SaveLog($voucher, 'Approved');
        return redirect()->route('budget.list')->with('noticication', 'Voucher <b>'.$RedirectVoucher.'</b> Successfully Approved');
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
                $Voucher = str_replace('/','-',$row->VOUCHER);

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
                    $BtnApprove = "<a class='dropdown-item success' href='".route('budget.approve', $Voucher)."'><i class='feather icon-check-circle'></i>Approve</a>";
                }

                if( $BtnShowHide['BtnUndoApproval'] ){
                    $BtnUndoApproval = "<a class='dropdown-item success' href='#'><i class='feather icon-delete'></i>Undro Approval</a>";
                }

                if( $BtnShowHide['BtnEdit'] ){
                    $BtnEdit = "<a class='dropdown-item success' href='".route('budget.edit', [$Voucher, 0])."'><i class='feather icon-edit-2'></i>Edit</a>";
                }

                if( $BtnShowHide['BtnDownloadDocument'] ){
                    $BtnDownloadDocument = "<a class='dropdown-item success btnViewDocumentBudget' href='#' data-toggle='modal' data-path='$row->Document_Path'><i class='feather icon-eye'></i>View Document</a>";

                    $BtnDownloadDocument = "<a href='$Budget->Document_Path' class='col-lg-2' target='_blank' download='>
                        Download
                    </a>";
                }

                if( $BtnShowHide['BtnReject'] || $BtnShowHide['BtnArchive'] ){
                    $Divider = "<div class='dropdown-divider'></div>";
                }

                if( $BtnShowHide['BtnReject'] ){
                    $BtnReject = "<a class='dropdown-item danger' href=".route('budget.reject', $Voucher)." data-toggle='modal'data-target='#ModalReject'><i class='feather icon-x-circle'></i>Reject</a>";
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
            ->editColumn('Start_Date', function($row){
                return date('Y-m-d', strtotime($row->Start_Date));
            })
            ->editColumn('End_Date', function($row){
                return date('Y-m-d', strtotime($row->End_Date));
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
                return date('Y-m-d', strtotime($row->PAYMENT_DATE));
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
                }
            })
            ->rawColumns(['ACTION', 'STATUS_BUDGET'])
        ->make(true);
        
        // dd($Budgets);
        return $Budgets;
    }
}

