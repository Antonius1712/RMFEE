<?php

namespace App\Http\Controllers;

use App\Helpers\Budget;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class BudgetController extends Controller
{
    public $brokerName, $startDate, $endDate, $class, $branch, $noPolicy, $agingRmf, $nBrn, $theInsured, $statusPremi, $statusRealisasi, $toDoList;

    public $NBRN;

    public function __construct(){
        $this->NBRN = [
            'NB' => 'NB',
            'RN' => 'RN'
        ];

        $this->statusPremi = [
            'PAID',
            'UNPAID'
        ];

        $this->statusRealisasi = [
            'PAID',
            'UNPAID'
        ];
    }

    public function index(){
        $this->toDoList = isset( request()->to_do_list ) ? request()->to_do_list : '';
        $this->branch = Budget::GetBranch();
        $this->class = Budget::GetClass();

        $NBRN = $this->NBRN;
        $branch = $this->branch;
        $statusPremi = $this->statusPremi;
        $statusRealisasi = $this->statusRealisasi;

        return view('pages.budget.list', compact('NBRN', 'branch', 'statusPremi', 'statusRealisasi'));
    }

    public function edit($id){
        $Budgets = collect(Budget::GetBudget($id));
        // dd($Budgets);
        return view('pages.budget.edit', $Budgets);
    }

    public function archiveList(){
        
        return view('pages.budget.archive');
    }

    public function reject(Request $request){
        // dd($request->all(), Logger::SaveLog());
        return redirect()->route('budget.list');
        
    }

    public function BudgetDataTable(){
        $Budgets = collect(Budget::GetBudget());
        $Budgets = Datatables::of($Budgets)->addColumn('ACTION', function($row){
            $BtnAction = "<div class='btn-group' role='group' aria-label='Button group with nested dropdown'><div class='btn-group' role='group'><a href='#' id='BtnActionGroup' data-toggle='dropdown' aria-haspopup='true'aria-expanded='false' style=''><i class='feather icon-plus-circle icon-btn-group'></i></a><div class='dropdown-menu' aria-labelledby='BtnActionGroup'><a class='dropdown-item success' href='#'><i class='feather icon-check-circle'></i>Approve</a><a class='dropdown-item success' href='#'><i class='feather icon-delete'></i>Undro Approval</a><a class='dropdown-item success' href='".route('budget.edit', $row->BROKERNAME)."'><i class='feather icon-edit-2'></i>Edit</a><a class='dropdown-item success' href='#'><i class='feather icon-eye'></i>View Document</a><div class='dropdown-divider'></div><a class='dropdown-item danger' href='#' data-toggle='modal'data-target='#ModalReject'><i class='feather icon-x-circle'></i>Reject</a><a class='dropdown-item danger' href='#'><i class='feather icon-archive'></i>Archive</a></div></div></div>";
            return $BtnAction;
        })->make(true);
        // dd($Budgets);
        return $Budgets;
    }
}

