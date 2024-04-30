<?php

namespace App\Model;

use App\Enums\Database;
use Illuminate\Database\Eloquent\Model;

class LGIGlobal_Group extends Model
{
    protected $connection = Database::LGI_GLOBAL;
    protected $table = 'Groups';

    public function getApp(){
        return $this->hasMany(LGIGlobal_App::class, 'AppCode', 'AppCode');
    }
}
