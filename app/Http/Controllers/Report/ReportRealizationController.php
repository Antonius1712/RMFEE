<?php

namespace App\Http\Controllers\Report;

use App\Enums\HardCoded;
use App\Exports\RealizationDetailExport;
use App\Exports\RealizationSummaryExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\Realization;
use App\Helpers\Report;

class ReportRealizationController extends Controller
{
    public function index(){
        // return $this->ExportRealizationSumarry();
        $StatusRealization = HardCoded::statusRealisasi;
        return view('pages.report.realization.index', compact('StatusRealization'));
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
            case $request->has('btn-generate-summary-realization'):
                return $this->ExportRealizationSumarry($start_date, $end_date, $request->input('status_realization'));
                break;
            case $request->has('btn-generate-detail-realization'):
                return $this->ExportRealizationDetail($start_date, $end_date, $request->input('status_realization'));
                break;
            default:
                return abort(404);
        }
    }

    public function ExportRealizationSumarry($start_date, $end_date, $status_realization = ''){
        $data = [];
        $Budgets = Report::GetReportRealizationSummary($start_date, $end_date, $status_realization);
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

            return Excel::download(new RealizationSummaryExport($data), 'Budget Summary ('.$formatedStartDate.' - '.$formatedEndDate.').xlsx');
        }else{
            return redirect()->back()->with(['status' => 404, 'notification' => 'Empty Data.']);
        }
    }

    public function ExportRealizationDetail($start_date, $end_date, $status_realization = ''){
        $data = [];

        set_time_limit(-1);
        ini_set('memory_limit', '-1');
        $Budgets = Report::GetReportRealizationDetail($start_date, $end_date, $status_realization);

        if( !empty($Budgets) ){
            //? loop rows.
            foreach( $Budgets as $row => $result ){
                // dd($result);
                //? loop columns and value for each column.
                foreach( collect($result)->toArray() as $header => $value ){
                    if($header == 'Realization_Amount') {
                        // Set cell value explicitly as a number
                        $data[$row][$header] = (float) $value;
                    } elseif($header == 'Policy_Start_Date' || $header == 'Policy_End_Date' || $header == 'Booking_Date' || $header == 'Invoice_Date' || $header == 'Date_Of_Request') {
                        $data[$row][$header] = $value != '' ? date('d M Y', strtotime($value)) : null;
                    } else {
                        $data[$row][$header] = $value;
                    }
                }
            }

            $formatedStartDate = date('d M Y', strtotime($start_date));
            $formatedEndDate = date('d M Y', strtotime($end_date));

            return Excel::download(new RealizationDetailExport($data, $formatedStartDate, $formatedEndDate), 'Realization Detail ('.$formatedStartDate.' - '.$formatedEndDate.').xlsx');
        }else{
            return redirect()->back()->with(['status' => 404, 'notification' => 'Empty Data.']);
        }
    }
}
