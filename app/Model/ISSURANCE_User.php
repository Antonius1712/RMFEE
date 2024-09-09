<?php

namespace App\Model;

use App\Helpers\Utils;
use Illuminate\Database\Eloquent\Model;

class ISSURANCE_User extends Model
{
    protected $connection = 'ISSURANCE_LIVE';
    protected $table = 'Users';
    protected $primaryKey = 'UserId';
    public $incrementing = false;

    public function getPasswordAttribute($value){
        return Utils::Decrypt($value);
    }

    public function getOtps(){
        return ISSURANCE_User_Otp::where('user_email', $this->Email)->where('is_valid', 1)->latest('id')->value('otp');
    }
}
