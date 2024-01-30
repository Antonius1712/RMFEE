<?php

namespace App\Model;

use App\Enums\Database;
use Illuminate\Database\Eloquent\Model;

class ReportGenerator_Budget_Group extends Model
{
    protected $connection = Database::REPORT_GENERATOR;
    protected $table = 'Engineering_Fee_Group';

    public function SeaReport_COB(){
        return $this->hasOne(SeaReport_COB::class, 'COB', 'COB');
    }

    public function SeaReport_Profile(){
        return $this->hasOne(SeaReport_Profile::class, 'ID', 'ID');
    }

    public function getIdAttribute($value){
        return $value.' - '.SeaReport_Profile::where('ID', $value)->value('Name'); 
    }

    public function getCobAttribute($value){
        return $value.' - '.SeaReport_COB::where('COB', $value)->value('DESCRIPTION');
    }

    public function getCreateDateByAttribute($value){
        return $value.' - '.LGIGlobal_User::where('UserId', $value)->value('Name');
    }

    public function getLastUpdateByAttribute($value){
        return $value.' - '.LGIGlobal_User::where('UserId', $value)->value('Name');
    }

    public function getCreateDateAttribute($value){
        return date('d M Y H:i:s', strtotime($value));
    }
    
    public function getLastUpdateAttribute($value){
        return date('d M Y H:i:s', strtotime($value));
    }
}
