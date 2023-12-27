<?php
namespace App\Helpers;

use App\Enums\Database;
use Exception;
use Illuminate\Support\Facades\DB;


// ! Only Put Global Function (Function that used in many places.) Here.
class Epo {
    public static function GetBodyEmail($PID_Header){
        try {
            return DB::connection(Database::EPO)->select("EXECUTE [dbo].[SP_Email_PDF_ePO_Engineering_Fee] '$PID_Header'");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
?>