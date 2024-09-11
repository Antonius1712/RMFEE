<?php

namespace App\Model;

use App\Enums\Database;
use App\Enums\GroupCodeApplication;
use App\Enums\Nik;
use App\Helpers\Utils;
use App\Model\LGIGlobal_Branch;
use App\Model\LGIGlobal_Dept;
use App\Model\LGIGlobal_UserGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PgSql\Lob;

class LGIGlobal_User extends Authenticatable
{
    protected $connection = Database::LGI_GLOBAL;
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

    public function getIssuranceData(){
        return $this->hasOne(ISSURANCE_User::class, 'UserId', 'UserId');
    }

    public function getPasswordAttribute($value){
        return Utils::Decrypt($value);
    }

    public function isHeadFinance(){
        return $this->getUserGroup->GroupCode == GroupCodeApplication::HEAD_FINANCE_RMFEE;
    }

    public function isHeadBu(){
        return $this->getUserGroup->GroupCode == GroupCodeApplication::HEAD_BU_RMFEE;
    }

    public function isUser(){
        return $this->getUserGroup->GroupCode == GroupCodeApplication::USER_RMFEE;
    }

    public function isThisTimmie(){
        return $this->NIK == Nik::TIMMIE;
    }
}
