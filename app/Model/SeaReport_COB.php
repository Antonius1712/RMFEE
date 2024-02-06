<?php

namespace App\Model;

use App\Enums\Database;
use Illuminate\Database\Eloquent\Model;

class SeaReport_COB extends Model
{
    protected $connection = Database::SEA_REPORT;
    protected $table = 'COB';
}
