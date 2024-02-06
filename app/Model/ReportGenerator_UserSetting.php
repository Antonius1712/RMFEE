<?php

namespace App\Model;

use App\Enums\Database;
use Illuminate\Database\Eloquent\Model;

class ReportGenerator_UserSetting extends Model
{
    protected $connection = Database::REPORT_GENERATOR;
    protected $table = 'User_Setting_Engineering_Fee';

    public function getApprovalBUName(){
        // return $this->hasOne(LGIGlobal_User::class, 'UserId', 'Approval_BU_UserID');
        return LGIGlobal_User::where('UserId', $this->Approval_BU_UserID)->value('Name');
    }

    public function getApprovalFinanceName(){
        // return $this->hasOne(LGIGlobal_User::class, 'UserId', 'Approval_Finance_UserID');
        return LGIGlobal_User::where('UserId', $this->Approval_Finance_UserID)->value('Name');
    }
}
