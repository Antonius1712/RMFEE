<?php

namespace App\Http\Controllers;

use App\Exports\Budget\Summary;
use App\Helpers\Budget;
use Illuminate\Http\Request;

use Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use PHPExcel_Style_NumberFormat;

class ReportBudgetController extends Controller
{
    public function index(){
        return $this->ExportBudgetSumarry();
        return view('pages.report.budget.index');
    }

    public function ExportBudgetSumarry(){
        $data = [];
        $Budgets = Budget::GetBudgetDataTable();
        //? loop rows.
        foreach( $Budgets as $row => $result ){
            //? loop columns and value for each column.
            foreach( collect($result)->toArray() as $header => $value ){
                $data[$row][$header] = $value;
            }
        }

        FacadesExcel::create('Budget Summary ('.now()->format('d M Y').')', function($excel) use($data){
            $excel->sheet('Budget Sumarry', function($sheet) use ($data) {
                $sheet->freezeFirstRow();
                $sheet->setAllBorders('thin');

                // $sheet->row(1, function($row) {
                //     // call cell manipulation methods
                //     $row->setBackground('#FFF200');
                //     $row->setFont([
                //         'family'     => 'Calibri',
                //         'size'       => '15',
                //         'bold'       => true,
                //         'align'      => 'center'
                //     ]);
                // });

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
                $sheet->setColumnFormat([
                    'K:L' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
                ]);

                $sheet->setSize('A1:AJ1', '', 50);

                $sheet->fromArray($data);
            });
        })->export('xls');

        // $data = Excel::store(new Summary, 'Summary.xls');
        // return $data;
    }
}
