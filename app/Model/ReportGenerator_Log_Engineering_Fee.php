<?php

namespace App\Model;

use App\Enums\Database;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ReportGenerator_Log_Engineering_Fee extends Model
{
    protected $connection = Database::REPORT_GENERATOR;
    protected $table = 'Log_Engineering_Fee';

    public function getUser(){
        return $this->hasOne(LGIGlobal_User::class, 'UserId', 'NIK');
    }
}
