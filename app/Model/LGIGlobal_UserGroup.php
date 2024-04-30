<?php

namespace App\Model;

use App\Enums\Database;
use Illuminate\Database\Eloquent\Model;

class LGIGlobal_UserGroup extends Model
{
    protected $connection = Database::LGI_GLOBAL;
    protected $table = 'UserGroup';

    public function getGroup(){
        return $this->hasOne(LGIGlobal_Group::class, 'GroupCode', 'GroupCode');
    }
}
