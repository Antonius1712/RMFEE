<?php

namespace App\Http\Controllers\Report;

use App\Exports\OSExport;
use App\Helpers\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReportOsController extends Controller
{
    public function index(){
        // Get the current year
        $currentYear = date('Y');

        // Create an array of the last 10 years
        $years = range($currentYear, $currentYear - 9);

        // Pass the array of years to the view
        return view('pages.report.os.index', compact('years'));
    }

    public function GenerateReport(Request $request){
        $updated_at = $request->updated_at;
        $underwriting_year_start = $request->underwriting_year_start;
        $underwriting_year_end = $request->underwriting_year_end;
        $broker_name = $request->broker_name;
        $Reports = Report::GetReportOS($updated_at, $underwriting_year_start, $underwriting_year_end, $broker_name);
        
        // dd($Reports, $updated_at, $underwriting_year_start, $underwriting_year_end, $broker_name);
        if (!empty($Reports)) {
            foreach( $Reports as $row => $result ){
                //? loop columns and value for each column.
                foreach( collect($result)->toArray() as $header => $value ){
                    if($header == 'Budget' || $header == 'RemainingBudget') {
                        // Set cell value explicitly as a number
                        $data[$row][$header] = (float) $value;
                    } elseif($header == 'Start_Date' || $header == 'End_Date' || $header == 'ADATE') {
                        $data[$row][$header] = date('d M Y', strtotime($value));
                    } else {
                        $data[$row][$header] = $value;
                    }
                }
            }
            return Excel::download(new OSExport($data, $updated_at, $underwriting_year_start, $underwriting_year_end, $broker_name), 'OSReport.xlsx');
        }else{
            return redirect()->back()->with(['status' => 404, 'notification' => 'Empty Data.']);
        }
    }
}
