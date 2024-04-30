<?php
    namespace App\Pipeline\Budget;

use App\Enums\BudgetStatus;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

    class UpdateDataBudget {
        public function handle($Data, $next) {
            $action = $Data['action'];
            $voucher = $Data['voucher'];
            $request = $Data['request'];

            if( $request != null ) {
                $LastEditedBy = $request['LastEditedBy'];
                $LastEdited = $request['LastEdited'];
                $LastEditedTime = $request['LastEditedTime'];
                $proposedTo = $request['proposed_to'];
                $budget = $request['budget_in_amount'];
                $percentage = $request['budget'];
                $documentPath = $request['document_path'];
                $action = $request['action'];
            } else {
                
            }

            dd($request);
            

            switch ( $action ) {
                case 'save':
                    $statusBudget = BudgetStatus::DRAFT;
                    break;
                case 'propose':
                    $statusBudget = BudgetStatus::WAITING_APPROVAL;
                    break;
                case 'approve':
                    $statusBudget = BudgetStatus::APPROVED;
                    if( $request == null ) {
                        try {
                            DB::connection("ReportGenerator181")->statement("EXECUTE [dbo].[SP_Update_Status_Data_Engineering_Fee] '$statusBudget', '$voucher', '$LastEditedBy', '$LastEdited', '$LastEditedTime', '$proposedTo', '$documentPath' ");
                        } catch (Exception $e) {
    
                        }
                    }
                    break;
                case 'reject':
                    $statusBudget = BudgetStatus::REJECTED;
                    break;
                case 'archive':
                    $statusBudget = BudgetStatus::ARCHIVED;
                    // IF Status = Archive, execute update status.
                    try {
                        DB::connection("ReportGenerator181")->statement("EXECUTE [dbo].[SP_Update_Status_Data_Engineering_Fee] '$statusBudget', '$voucher', '$LastEditedBy', '$LastEdited', '$LastEditedTime', '$proposedTo', '$documentPath' ");
                    } catch (Exception $e) {
                        Log::info("error archive", $e->getMessage());
                        return $next($e->getMessage());
                    }
                    break;
                default :
                    $statusBudget = BudgetStatus::DRAFT;
                    break;
            }
    
            try {
                DB::connection("ReportGenerator181")->statement("EXECUTE [dbo].[SP_Update_Data_Engineering_Fee] '$budget', '$percentage', '$statusBudget', '$voucher', '$LastEditedBy', '$LastEdited', '$LastEditedTime', '$proposedTo', '$documentPath' ");
            } catch (Exception $e) {
                return $next($e->getMessage());
                // return $e->getMessage();
            }

            return $next(Response::HTTP_OK);
        }
    }
?>