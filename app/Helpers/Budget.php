<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Budget {
    public static function GetBudget($id = ''){
        return DB::connection('ReportGenerator181')->select("EXECUTE [dbo].[SP_Get_Data_Engineering_Fee] '".$id."','','','','','','','',''");
    }

    public static function GetBranch(){
        return DB::connection('ReportGenerator181')->select("EXECUTE [dbo].[SP_Get_Branch_Engineering_Fee]");
    }

    public static function GetClass(){
        return DB::connection('ReportGenerator181')->select("EXECUTE [dbo].[SP_Get_Class_Engineering_Fee]");
    }
}

?>