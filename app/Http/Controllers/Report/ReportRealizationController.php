<?php

namespace App\Http\Controllers\Report;

use App\Enums\HardCoded;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use PHPExcel_Style_NumberFormat;
use App\Helpers\Realization;

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
        $Budgets = Realization::GetReportRealizationSummary($start_date, $end_date, $status_realization);
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

    public function ExportRealizationDetail($start_date, $end_date, $status_realization = ''){
        $data = [];
        $Budgets = Realization::GetReportRealizationDetail($start_date, $end_date, $status_realization);

        if( !empty($Budgets) ){
            //? loop rows.
            foreach( $Budgets as $row => $result ){
                // dd($result);
                //? loop columns and value for each column.
                foreach( collect($result)->toArray() as $header => $value ){
                    if($header == 'Realization_Amount') {
                        // Set cell value explicitly as a number
                        $data[$row][$header] = (float) $value;
                    } elseif($header == 'Policy_Start_Date' || $header == 'Policy_End_Date' || $header == 'Booking_Date') {
                        $data[$row][$header] = date('d M Y', strtotime($value));
                    } else {
                        $data[$row][$header] = $value;
                    }
                }
            }

            // dd($data);
            $formatedStartDate = date('d M Y', strtotime($start_date));
            $formatedEndDate = date('d M Y', strtotime($end_date));

            Excel::create('Realization Detail ('.$formatedStartDate.' - '.$formatedEndDate.')', function($excel) use($data){
                $excel->sheet('Realization Detail', function($sheet) use ($data) {
                    $sheet->freezeFirstRow();
                    $sheet->setAllBorders('thin');

                    // Styling Cell A1 - AJ1.
                    $sheet->getStyle('A1:P1')->applyFromArray([
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
                    $sheet->setSize('A1:P1', '', 50);
                    
                    // Set the data.
                    $sheet->fromArray($data);

                    // Apply number format for columns declare below start from 2 to end.
                    $lastRow = count($data) + 1;
                    for ($row = 2; $row <= $lastRow; $row++) {
                        $sheet->getStyle('H' . $row . ':K' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    }

                    // Auto-size columns.
                    foreach(range('A','P') as $column) {
                        $sheet->getColumnDimension($column)->setAutoSize(true);
                    }
                });
            })->export('xls')->download('xls');
        }else{
            return redirect()->back()->with(['status' => 404, 'notification' => 'Empty Data.']);
        }
    }
}
