<?php
namespace App\Pipeline\Realization;

use Illuminate\Support\Facades\DB;

class ProcessDataRealization {
    public function handle($request, $next) {
        $action = $request->action;
        $from = $request->from;

        switch ($from) {
            case 'create':
                static::Table('Insert', $request);
                break;
            case 'edit':
                static::Table('Update', $request);
                break;
            default:
                break;
        }

        switch ($action) {
            case 'add_detail':
                return $next(route('realization.detail-realization.index', $request->invoice_no));
                break;
            case 'save':
                return $next(route('realization.index'));
                break;
            case 'propose':
                return $next(route('realization.index'));
                break;
            default:
                return $next(route('realization.index'));
                break;
        }

        // return $next($Data);
    }

    public static function Table($ActionSP, $param){
        $invoice_no = $param->invoice_no;
        $type_of_invoice = $param->type_of_invoice;
        $currency = $param->currency;
        $invoice_date = $param->invoice_date;
        $broker_id = $param->broker_id;
        $payment_to = $param->payment_to;
        $upload_invoice = $param->upload_invoice;
        $upload_survey_report = $param->upload_survey_report;
        $approval_bu = $param->approval_bu;
        $approval_finance = $param->approval_finance;
        $epo_checker = $param->epo_checker;
        $epo_approval = $param->epo_approval;
        $status_realization = '';
        $ActionSP = ucfirst($ActionSP);

        return DB::connection('ReportGenerator181')->statement("EXECUTE [dbo].[SP_".$ActionSP."_Group_Realization_Engineering_Fee] '$invoice_no', '$type_of_invoice', '$currency', '$invoice_date', '$broker_id', '$payment_to', '$upload_invoice', '$upload_survey_report', '$approval_bu', '$approval_finance', '$epo_checker', '$epo_approval', '$status_realization'");
    }
}
?>