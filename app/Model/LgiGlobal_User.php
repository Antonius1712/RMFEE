<?php

namespace App\Model;

use App\Model\LGIGlobal_Branch;
use App\Model\LGIGlobal_Dept;
use App\Model\LGIGlobal_UserGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PgSql\Lob;

class LgiGlobal_User extends Authenticatable
{
    protected $connection = 'LGIGlobal';
    protected $table = 'Users';
    protected $primaryKey = 'UserId';
    public $incrementing = false;

    // DISABLE REMEMBER TOKEN.
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute){
            parent::setAttribute($key, $value);
        }
    }

    protected $hidden = [
        'Password',
    ];

    public function getDept(){
        return $this->hasOne(LGIGlobal_Dept::class, 'DeptCode', 'DeptCode');
    }

    public function getBranch(){
        return $this->hasOne(LGIGlobal_Branch::class, 'BranchCode', 'BranchCode');
    }
    
    public function getUserGroup(){
        return $this->hasOne(LGIGlobal_UserGroup::class, 'UserId', 'UserId')->where('GroupCode', 'like', '%RMFEE%');
    }

    public function getUserSetting(){
        return $this->hasOne(ReportGenerator_UserSetting::class, 'UserID', 'UserId');
    }
}
