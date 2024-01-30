<?php

namespace App\Helpers;

use App\Enums\Database;
use App\Model\ReportGenerator_Budget_Group;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// ! Only Put Function that used only in Budgets. (usuallly method to Select, Insert, Update, Delete, and some customization).
class BudgetGroup {
    public static function GetBudgetGroup($GroupID = ''){
        try {
            return DB::connection(Database::REPORT_GENERATOR)
            ->select("EXECUTE [dbo].[SP_Get_Budget_Group_Engineering_Fee] '$GroupID'");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function InsertBudgetGroup($request){
        try {
            $GroupID = $request->group_id;
            $Name = $request->broker_id;
            $COB = $request->class;
            $Occupation = $request->occupation;
            $Persentage = $request->percentage;
            $Create_Date = now()->format('Y-m-d H:i:s');
            $Create_Date_By = auth()->id();
            $Last_Update = now()->format('Y-m-d H:i:s');
            $Last_Update_By = auth()->id();
            // dd($GroupID, $Name, $COB, $Occupation, $Persentage, $Create_Date, $Create_Date_By, $Last_Update, $Last_Update_By);
            return DB::connection(Database::REPORT_GENERATOR)
            ->statement("EXECUTE [dbo].[SP_Insert_Budget_Group_Engineering_Fee] '$GroupID', '$Name', '$COB', '$Occupation', '$Persentage', '$Create_Date', '$Create_Date_By', '$Last_Update', '$Last_Update_By'");
        } catch (Exception $e) {
            // dd('zz', $e->getMessage());
            Log::error("Error while Insert data Budget Group on Group ID = " . $GroupID . " Exception = " . $e->getMessage());
            return $e->getMessage();
        }
    }

    public static function UpdateBudgetGroup($GroupID, $request){
        try {
            $GroupID = $GroupID;
            $Name = $request->broker_id;
            $COB = $request->class;
            $Occupation = $request->occupation;
            $Persentage = $request->percentage;
            $Last_Update = now()->format('Y-m-d H:i:s');
            $Last_Update_By = auth()->id();
            return DB::connection(Database::REPORT_GENERATOR)
            ->statement("EXECUTE [dbo].[SP_Update_Budget_Group_Engineering_Fee] '$GroupID', '$Name', '$COB', '$Occupation', '$Persentage', '$Last_Update', '$Last_Update_By'");
        } catch (Exception $e) {
            // dd('zz', $e->getMessage());
            Log::error("Error while Update data Budget Group on Group ID = " . $GroupID . " Exception = " . $e->getMessage());
            return $e->getMessage();
        }
    }
}
?>