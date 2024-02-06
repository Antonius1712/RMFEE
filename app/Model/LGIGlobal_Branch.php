<?php

namespace App\Model;

use App\Enums\Database;
use Illuminate\Database\Eloquent\Model;

class LGIGlobal_Branch extends Model
{
    protected $connection = Database::LGI_GLOBAL;

    protected $table = 'Branch';
}
