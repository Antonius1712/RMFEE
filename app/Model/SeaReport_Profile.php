<?php

namespace App\Model;

use App\Enums\Database;
use Illuminate\Database\Eloquent\Model;

class SeaReport_Profile extends Model
{
    protected $connection = Database::SEA_REPORT;
    protected $table = 'Profile';
}
