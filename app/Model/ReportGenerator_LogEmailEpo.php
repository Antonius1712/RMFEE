<?php

namespace App\Model;

use App\Enums\Database;
use Illuminate\Database\Eloquent\Model;

class ReportGenerator_LogEmailEpo extends Model
{
    protected $connection = Database::REPORT_GENERATOR;
    protected $table = 'Log_Email_ePO_Engineering_Fee';
    protected $fillable = [
        'PID',
        'Realisasi_ID',
        'Email_To',
        'Date',
        'Time',
    ];
    public $timestamps = false;
}
