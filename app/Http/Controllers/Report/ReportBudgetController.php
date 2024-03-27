<?php

namespace App\Http\Controllers\Report;

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
        return view('pages.report.budget.index');
    }

    public function ExportBudgetSumarry(){
        $data = [];
        $Budgets = Budget::GetBudgetDataTable();
        //? loop rows.
        foreach( $Budgets as $row => $result ){
            //? loop columns and value for each column.
            foreach( collect($result)->toArray() as $header => $value ){
                if($header == 'LGI_PREMIUM' || $header == 'PREMIUM' || $header == 'ADMIN' || $header == 'DISCOUNT' || $header == 'OTHERINCOME' || $header == 'PAYMENT' || $header == 'OS' || $header == 'Budget' || $header == 'REALIZATION_RMF' || $header == 'REALIZATION_SPONSORSHIP' || $header == 'REMAIN_BUDGET') {
                    // Set cell value explicitly as a number
                    $data[$row][$header] = (float) $value;
                } elseif($header == 'Start_Date' || $header == 'End_Date' || $header == 'PAYMENT_DATE' || $header == 'LAST_EDITED' || $header == 'ADATE') {
                    $data[$row][$header] = date('d M Y', strtotime($value));
                } else {
                    $data[$row][$header] = $value;
                }
            }
        }

        // dd($data);

        Excel::create('Budget Summary ('.now()->format('d M Y').')', function($excel) use($data){
            $excel->sheet('Budget Sumarry', function($sheet) use ($data) {
                $sheet->freezeFirstRow();
                $sheet->setAllBorders('thin');

                //? Styling Cell A1 - AJ1.
                $sheet->getStyle('A1:AJ1')->applyFromArray([
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
                
                //? Set the size for cells.
                $sheet->setSize('A1:AJ1', '', 50);
                
                //? Set the data.
                $sheet->fromArray($data);

                //? Apply number format for columns declare below start from 2 to end.
                //? Example: J2:O2 then loop, J3:O3, and so on and so on.
                $lastRow = count($data) + 1;
                for ($row = 2; $row <= $lastRow; $row++) {
                    $sheet->getStyle('J' . $row . ':O' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    
                    $sheet->getStyle('Q' . $row . ':Q' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    
                    $sheet->getStyle('Y' . $row . ':AB' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                }
                
                // $sheet->setColumnFormat([
                //     'J' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
                //     'K' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
                //     'L' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
                //     'M' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
                //     'N' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
                //     'O' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
                //     'Q' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
                //     'Y' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
                //     'Z' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
                //     'AA' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
                //     'AB' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
                // ]);



                //? Auto-size columns.
                foreach(range('A','Z') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            });
        })->export('xls');
    }
}
