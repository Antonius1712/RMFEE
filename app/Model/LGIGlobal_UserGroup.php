<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LGIGlobal_UserGroup extends Model
{
    protected $connection = 'LGIGlobal';
    protected $table = 'UserGroup';

    public function getGroup(){
        return $this->hasOne(LGIGlobal_Group::class, 'GroupCode', 'GroupCode');
    }
}
