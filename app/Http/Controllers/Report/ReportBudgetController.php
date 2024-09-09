<?php

namespace App\Http\Controllers\Report;

use App\Enums\BudgetStatus;
use App\Enums\HardCoded;
use App\Exports\BudgetDetailExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use PHPExcel_Style_NumberFormat;
use App\Exports\BudgetSummaryExport;
use App\Helpers\Report;

class ReportBudgetController extends Controller
{
    public function index(){
        // return $this->ExportBudgetSumarry();
        $StatusBudget = HardCoded::statusBudget;
        return view('pages.report.budget.index', compact('StatusBudget'));
    }

    public function GenerateReport(Request $request){
        
        //? start date null.
        if($request->input('start_date') == null) {
            $start_date = date('Y-m-01');
        }else{
            $start_date = date('Y-m-d', strtotime($request->input('start_date')));
        }
        
        //? enddate null.
        if($request->input('end_date') == null) {
            $end_date = date('Y-m-t');
        }else{
            $end_date = date('Y-m-d', strtotime($request->input('end_date')));
        }

        switch(true) {
            case $request->has('btn-generate-summary-budget'):
                return $this->ExportBudgetSumarry($start_date, $end_date, $request->input('status_budget'));
                break;
            case $request->has('btn-generate-detail-budget'):
                return $this->ExportBudgetDetail($start_date, $end_date, $request->input('status_budget'));
                break;
            default:
                return abort(404);
        }
    }

    public function ExportBudgetSumarry($start_date, $end_date, $status_budget = ''){
        $data = [];
        $Budgets = Report::GetReportBudgetSummary($start_date, $end_date, $status_budget);
        //? loop rows.
        if (!empty($Budgets)) {
            foreach( $Budgets as $row => $result ){
                //? loop columns and value for each column.
                foreach( collect($result)->toArray() as $header => $value ){
                    if($header == 'LGI_PREMIUM' || $header == 'PREMIUM' || $header == 'ADMIN' || $header == 'DISCOUNT' || $header == 'OTHERINCOME' || $header == 'PAYMENT' || $header == 'OS' || $header == 'BUDGET' || $header == 'REALIZATION_RMF' || $header == 'REALIZATION_SPONSORSHIP' || $header == 'REMAIN_BUDGET') {
                        // Set cell value explicitly as a number
                        $data[$row][$header] = (float) $value;
                    } elseif($header == 'START_DATE' || $header == 'END_DATE' || $header == 'BOOKING_DATE') {
                        $data[$row][$header] = date('d M Y', strtotime($value));
                    } else {
                        $data[$row][$header] = $value;
                    }
                }
            }

            $formatedStartDate = date('d M Y', strtotime($start_date));
            $formatedEndDate = date('d M Y', strtotime($end_date));

            return Excel::download(new BudgetSummaryExport($data, $formatedStartDate, $formatedEndDate), 'BudgetSummary.xlsx');
        }else{
            return redirect()->back()->with(['status' => 404, 'notification' => 'Empty Data.']);
        }
    }

    public function ExportBudgetDetail($start_date, $end_date, $status_budget = ''){
        $data = [];
        $Budgets = Report::GetReportBudgetDetail($start_date, $end_date, $status_budget);

        if( !empty($Budgets) ){
            //? loop rows.
            foreach( $Budgets as $row => $result ){
                // dd($result);
                //? loop columns and value for each column.
                foreach( collect($result)->toArray() as $header => $value ){
                    if($header == 'LGI_PREMIUM' || $header == 'PREMIUM' || $header == 'ADMIN' || $header == 'DISCOUNT' || $header == 'OTHERINCOME' || $header == 'PAYMENT' || $header == 'OS' || $header == 'BUDGET' || $header == 'REALIZATION_RMF' || $header == 'REALIZATION_SPONSORSHIP' || $header == 'REMAIN_BUDGET') {
                        // Set cell value explicitly as a number
                        $data[$row][$header] = (float) $value;
                    } elseif($header == 'START_DATE' || $header == 'END_DATE' || $header == 'BOOKING_DATE') {
                        $data[$row][$header] = date('d M Y', strtotime($value));
                    } else {
                        $data[$row][$header] = $value;
                    }
                }
            }

            // dd($data);
            $formatedStartDate = date('d M Y', strtotime($start_date));
            $formatedEndDate = date('d M Y', strtotime($end_date));

            return Excel::download(new BudgetDetailExport($data, $formatedStartDate, $formatedEndDate), 'BudgetDetail.xlsx');
        }else{
            return redirect()->back()->with(['status' => 404, 'notification' => 'Empty Data.']);
        }
    }
}
