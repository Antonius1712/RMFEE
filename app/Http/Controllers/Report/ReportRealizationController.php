<?php

namespace App\Http\Controllers\Report;

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
        return view('pages.report.realization.index');
    }

    public function ExportRealizationSumarry(){
        $data = [];
        $Realizations = Realization::GetRealization();
        //? loop rows.
        foreach( $Realizations as $row => $result ){
            //? loop columns and value for each column.
            foreach( collect($result)->toArray() as $header => $value ){
                $data[$row][$header] = $value;
            }
        }

        Excel::create('Realization Summary ('.now()->format('d M Y').')', function($excel) use($data){
            $excel->sheet('Realization Sumarry', function($sheet) use ($data) {
                $sheet->freezeFirstRow();
                $sheet->setAllBorders('thin');
                $sheet->getStyle('A1:Z1')->applyFromArray([
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
                // $sheet->setColumnFormat([
                //     'K:L' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
                // ]);
                $sheet->setSize('A1:AJ1', '', 50);
                $sheet->fromArray($data);
            });
        })->export('xls');
    }
}
