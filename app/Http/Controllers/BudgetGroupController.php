<?php

namespace App\Http\Controllers;

use App\Helpers\BudgetGroup;
use App\Model\ReportGenerator_Budget_Group;
use App\Model\SeaReport_COB;
use App\Model\SeaReport_Profile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BudgetGroupController extends Controller
{
    public $COB;

    public function __construct()
    {
        $this->COB = [
            '01' => '01',
            '02' => '02'
        ];
    }
    public function index(){
        $BudgetGroupData = ReportGenerator_Budget_Group::all();
        return view('pages.setting.budget-group.index', compact('BudgetGroupData'));
    }

    public function create(){
        $COB = $this->COB;
        return view('pages.setting.budget-group.create', compact('COB'));
    }

    public function store(Request $request){
        // dd($request->all());
        try {
            $ValidateBudgetGroup = ReportGenerator_Budget_Group::where('GroupID', $request->group_id)->count();
            if( $ValidateBudgetGroup > 0 ){
                return redirect()->back()->withErrors("There's an existing Budget Group with this Group ID.");
            }
            BudgetGroup::InsertBudgetGroup($request);
        } catch (Exception $e) {
            Log::error('Error Insert Budget Group, Exception = ' . $e->getMessage());
        }
        return redirect()->route('setting.budget-group.index')->with('noticication', 'Budget Group <b>'.$request->group_id.'</b> Successfully Stored');
    }

    public function edit($GroupID){
        // $BudgetGroupData = BudgetGroup::GetBudgetGroup($GroupID)[0];
        $BudgetGroupData = ReportGenerator_Budget_Group::where('GroupID', $GroupID)->first();
        $COB = $this->COB;
        // dd($BudgetGroupData);
        return view('pages.setting.budget-group.edit', compact('BudgetGroupData', 'COB'));
    }

    public function update($GroupID, Request $request){
        try {
            $ValidateBudgetGroup = ReportGenerator_Budget_Group::where('GroupID', $GroupID)->count();
            if( $ValidateBudgetGroup == 0 ){
                return redirect()->back()->withErrors("There's no existing Budget Group with this Group ID.");
            }
            BudgetGroup::UpdateBudgetGroup($GroupID, $request);
        } catch (Exception $e) {
            Log::error('Error Insert Budget Group, Exception = ' . $e->getMessage());
        }
        return redirect()->route('setting.budget-group.index')->with('noticication', 'Budget Group <b>'.$request->group_id.'</b> Successfully Stored');
    }

    public function delete($GroupID){

    }
}
