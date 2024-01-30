<?php

namespace App\Model;

use App\Enums\Database;
use Illuminate\Database\Eloquent\Model;

class ReportGenerator_Realization_Group extends Model
{
    protected $connection = Database::REPORT_GENERATOR;
    protected $table = 'Realization_Group_Engineering_Fee';

    public function GetUserSetting(){
        return $this->hasOne(ReportGenerator_UserSetting::class, 'UserID', 'CreatedBy');
    }
}
