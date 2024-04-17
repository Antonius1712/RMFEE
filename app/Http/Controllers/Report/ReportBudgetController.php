<?php

namespace App\Http\Controllers\Report;

use App\Enums\BudgetStatus;
use App\Enums\HardCoded;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use PHPExcel_Style_NumberFormat;
use App\Helpers\Budget;

class ReportBudgetController extends Controller
{
    public function index(){
        // return $this->ExportBudgetSumarry();
        $StatusBudget = HardCoded::statusBudget;
        return view('pages.report.budget.index', compact('StatusBudget'));
    }

    public function GenerateReport(Request $request){
        
        //? start date null.
        if(empty($request->input('start_date'))) {
            $start_date = date('Y-m-01');
        }else{
            $start_date = date('Y-m-d', strtotime($request->input('start_date')));
        }
        
        //? enddate null.
        if(empty($request->input('end_date'))) {
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
        $Budgets = Budget::GetReportBudgetSummary($start_date, $end_date, $status_budget);
        
        if (!empty($Budgets)) {
            //? loop rows.
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

            // dd($data);
            $formatedStartDate = date('d M Y', strtotime($start_date));
            $formatedEndDate = date('d M Y', strtotime($end_date));
            Excel::create('Budget Summary ('.$formatedStartDate.' - '.$formatedEndDate.')', function($excel) use($data){
                $excel->sheet('Budget Summary', function($sheet) use ($data) {
                    $sheet->freezeFirstRow();
                    $sheet->setAllBorders('thin');

                    // Styling Cell A1 - AJ1.
                    $sheet->getStyle('A1:F1')->applyFromArray([
                        'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  15,
                            'bold'      =>  true,
                            'align'     =>  'center'
                        ],
                        'fill' => [
                            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FFF200')
                        ],
                        'alignment' => [
                            'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                        ]
                    ]);
                    
                    // Set the size for cells.
                    $sheet->setSize('A1:F1', '', 50);
                    
                    // Set the data.
                    $sheet->fromArray($data);

                    // Apply number format for columns declare below start from 2 to end.
                    $lastRow = count($data) + 1;
                    for ($row = 2; $row <= $lastRow; $row++) {
                        $sheet->getStyle('E' . $row . ':F' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    }

                    // Auto-size columns.
                    foreach(range('A','F') as $column) {
                        $sheet->getColumnDimension($column)->setAutoSize(true);
                    }
                });
            })->export('xls')->download('xls');
        }else{
            return redirect()->back()->with(['status' => 404, 'notification' => 'Empty Data.']);
        }
    }

    public function ExportBudgetDetail($start_date, $end_date, $status_budget = ''){
        $data = [];
        $Budgets = Budget::GetReportBudgetDetail($start_date, $end_date, $status_budget);

        if (!empty($Budgets)) {
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

            Excel::create('Budget Detail ('.$formatedStartDate.' - '.$formatedEndDate.')', function($excel) use($data){
                $excel->sheet('Budget Detail', function($sheet) use ($data) {
                    $sheet->freezeFirstRow();
                    $sheet->setAllBorders('thin');

                    // Styling Cell A1 - AJ1.
                    $sheet->getStyle('A1:K1')->applyFromArray([
                        'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  15,
                            'bold'      =>  true,
                            'align'     =>  'center'
                        ],
                        'fill' => [
                            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FFF200')
                        ],
                        'alignment' => [
                            'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                        ]
                    ]);
                    
                    // Set the size for cells.
                    $sheet->setSize('A1:K1', '', 50);
                    
                    // Set the data.
                    $sheet->fromArray($data);

                    // Apply number format for columns declare below start from 2 to end.
                    $lastRow = count($data) + 1;
                    for ($row = 2; $row <= $lastRow; $row++) {
                        $sheet->getStyle('H' . $row . ':K' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    }

                    // Auto-size columns.
                    foreach(range('A','K') as $column) {
                        $sheet->getColumnDimension($column)->setAutoSize(true);
                    }
                });
            })->export('xls')->download('xls');
        }else{
            return redirect()->back()->with(['status' => 404, 'notification' => 'Empty Data.']);
        }
    }
}
