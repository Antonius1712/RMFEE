<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LGIGlobal_Group extends Model
{
    protected $connection = 'LGIGlobal';
    protected $table = 'Groups';

    public function getApp(){
        return $this->hasMany(LGIGlobal_App::class, 'AppCode', 'AppCode');
    }
}
