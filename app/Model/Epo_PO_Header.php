<?php

namespace App\Model;

use App\Enums\Database;
use Illuminate\Database\Eloquent\Model;

class Epo_PO_Header extends Model
{
    public $timestamps = false;
    protected $connection = Database::EPO;
    protected $table = 'PO_Header';
}
