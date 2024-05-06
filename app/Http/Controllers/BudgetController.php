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
        $statusRealisasi = HardCoded::statusRealisasi;
        $statusBudget = HardCoded::statusBudget;

        $branchList = $this->branch;

        // --------------------------------------------------------------------------------

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

        // dd($request->all());

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

            // dd($data);

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

        // dd($booking_date_from, $booking_date_to);

        return view('pages.budget.list', compact('NBRN', 'branchList', 'statusPremi', 'statusRealisasi', 'statusBudget', 'Budgets'));
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
        $message = $message != null ? ' | '.$message : null;
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

    public function undo_approve($voucher, Request $request){
        $UrlParameter = http_build_query($request->query());
        $RedirectVoucher = str_replace('~', '/', $voucher);
        Budget::UpdateBudgetOnlyStatus('undo_approve', $voucher, null);
        Logger::SaveLog(LogStatus::BUDGET, $voucher, 'Undo Approved');

        $route = route('budget.list') . '?' . $UrlParameter;
        return redirect()->to($route)->with('notification', 'Voucher <b>' . $RedirectVoucher . '</b> Successfully Undo Approved');
    }

    public function BudgetDataTable(Request $request){
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
        $class_business = $request->class_business;
        $status_realisasi = $request->status_realisasi;
        $status_budget = $request->status_budget;

        $type = isset($request->type) && $request->type != '' ? $request->type : '';

        $CacheBudget = Cache::remember('BudgetDataTable', 1440, function() use ($broker_name, $branch, $status_pembayaran_premi, $start_date, $no_policy, $aging_rmf, $booking_date_from, $booking_date_to, $nb_rn, $holder_name, $class_business, $status_realisasi, $status_budget, $type){
            return Budget::GetBudgetDataTable($broker_name, $branch, $status_pembayaran_premi, $start_date, $no_policy, $aging_rmf, $booking_date_from, $booking_date_to, $nb_rn, $holder_name, $class_business, $status_realisasi, $status_budget, $type);
        });

        // dd($CacheBudget);

        $Budgets = collect($CacheBudget);

        // dd($Budgets);

        $time_start = microtime(true);
        $Budgets = Datatables::of($Budgets)
            ->addColumn('ACTION', function($row){
                // return 'OK';
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

                if( $BtnShowHide['BtnApprove'] ){
                    $BtnApprove = "<a class='dropdown-item success approve' href='javascript:;' data-url='".route('budget.approve', $Voucher)."'><i class='feather icon-check-circle'></i>Approve</a>";
                }

                if( $BtnShowHide['BtnUndoApproval'] ){
                    $BtnUndoApproval = "<a class='dropdown-item danger undo_approve' href='javascript:;' data-url='".route('budget.undo_approve', [$Voucher])."'><i class='feather icon-delete'></i>Undo Approval</a>";
                }

                if( $BtnShowHide['BtnEdit'] ){
                    $BtnEdit = "<a class='dropdown-item success edit' href='".route('budget.edit', [$Voucher, 0])."'><i class='feather icon-edit-2'></i>Edit</a>";
                }

                if( $BtnShowHide['BtnDownloadDocument'] ){
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
                    $BtnReject = "<a class='dropdown-item danger' id='RejectModal' data-voucher='$Voucher'><i class='feather icon-x-circle'></i>Reject</a>";
                }

                if( $BtnShowHide['BtnArchive'] ){
                    $BtnArchive = "<a class='dropdown-item danger' href=".route('budget.archive', $Voucher)."><i class='feather icon-archive'></i>Archive</a>";
                }

                if( $BtnShowHide['BtnUnArchive'] ){
                    $BtnUnArchive = "<a class='dropdown-item success' href=".route('budget.unarchive', $Voucher)."><i class='feather icon-archive'></i>Unarchive</a>";
                }

                $BtnAction = "<div class='btn-group' role='group' aria-label='Button group with nested dropdown'><div class='btn-group' role='group'><a href='#' id='BtnActionGroup' data-toggle='dropdown' aria-haspopup='true'aria-expanded='false' style=''><i class='feather icon-plus-circle icon-btn-group'></i></a><div class='dropdown-menu' aria-labelledby='BtnActionGroup'>".$BtnApprove.$BtnUndoApproval.$BtnEdit.$BtnDownloadDocument.$Divider.$BtnReject.$BtnArchive.$BtnUnArchive."</div></div></div>";
                
                return $BtnAction;
            })
            // ->addColumn('ACTION', function($row){
            //     return 'ok';
            // })
            ->editColumn('ADATE', function($row){
                return date('d-M-Y', strtotime($row->ADATE));
            })
            ->editColumn('Start_Date', function($row){
                return date('d-M-Y', strtotime($row->Start_Date));
            })
            ->editColumn('End_Date', function($row){
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
        $time_end = microtime(true);
        $time_diff = $time_end - $time_start;
        // dd($Budgets,$time_start, $time_end, $time_diff);
        return $Budgets;
    }
}

