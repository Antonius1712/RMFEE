<?php

namespace App\Model;

use App\Enums\Database;
use Illuminate\Database\Eloquent\Model;

class ReportGenerator_Data_Engineering_Fee extends Model
{
    protected $connection = Database::REPORT_GENERATOR;
    protected $table = 'Data_Engineering_Fee';
}
