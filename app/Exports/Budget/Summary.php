<?php

namespace App\Exports\Budget;

use App\Helpers\Budget;
use PHPExcel_Cell_DefaultValueBinder;

class Summary extends PHPExcel_Cell_DefaultValueBinder
{
    protected $data;

    public function __construct(){
        $this->data = Budget::GetBudget();
    }

    public function colletion(){
        return $this->data;
    }

    public function headings(){
        return array_keys($this->data[0]);
    }
}
