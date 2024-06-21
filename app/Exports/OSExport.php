<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class OSExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $data;
    protected $adate;
    protected $underwriting_year_start;
    protected $underwriting_year_end;
    protected $broker_name;

    public function __construct($data, $adate, $underwriting_year_start, $underwriting_year_end, $broker_name)
    {
        $this->data = $data;
        $this->adate = $adate;
        $this->underwriting_year_start = $underwriting_year_start;
        $this->underwriting_year_end = $underwriting_year_end;
        $this->broker_name = $broker_name;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        if (empty($this->data)) {
            return [];
        }
    
        // Get the keys of the first row
        $firstRowKeys = array_keys($this->data[0]);
    
        // Use the keys of the first row as column headings
        return $firstRowKeys;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:K1')->applyFromArray([
                    'font' => [
                        'name'      =>  'Calibri',
                        'size'      =>  15,
                        'bold'      =>  true,
                    ],
                    'fill' => [
                        'fillType'  => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFF200'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ]
                ]);

                $event->sheet->getDelegate()->getStyle('I2:J999')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                // Auto-size columns.
                foreach(range('A','K') as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
