<?php

use Illuminate\Support\Facades\DB;

class Budget {
    public static function GetBudget($param = []){
        if( count($param) > 0 ){
            return DB::connection('sqlsrv_8')->select("EXEC usp_getMember @email ='".$param['email']."'");
        }

        return DB::connection('sqlsrv_8')->select("EXEC usp_getMember");
    }
}

?>