<?php

namespace App\Model;

use App\Enums\Database;
use Illuminate\Database\Eloquent\Model;

class ReportGenerator_Detail_Realization_Group_Engineering_Fee extends Model
{
    protected $connection = Database::REPORT_GENERATOR;
    protected $table = 'Detail_Realization_Group_Engineering_Fee';

    public function DataEngineeringFee(){
        return $this->hasOne(ReportGenerator_Data_Engineering_Fee::class, 'VOUCHER', 'budget_voucher');
    }
}
