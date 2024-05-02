<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ISSURANCE_User_Otp extends Model
{
    protected $connection = 'ISSURANCE_LIVE';
    protected $table = 'Users_otps';
}
