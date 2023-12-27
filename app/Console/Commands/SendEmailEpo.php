<?php

namespace App\Console\Commands;

use App\Enums\Database;
use App\Enums\RealizationStatus;
use App\Model\ReportGenerator_LogEmailEpo;
use App\Model\ReportGenerator_Realization_Group;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendEmailEpo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email-epo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending e-mail of EPO from RMFEE engineering-fee.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $test = $this->call('generate:attachment-epo');
        $LogEmailEpo = ReportGenerator_LogEmailEpo::where('Email_Sent', null)->get();
        $Files = [];
        foreach( $LogEmailEpo as $val ){

            $RealizationData = ReportGenerator_Realization_Group::where('id', $val->Realisasi_ID)->first();

            //TODO BUAT PENGIRIMAN EMAIL DARI DATA INI.
            $emailTemplate = 'email.sent-email-epo';
            $Files['PDF_EPO'] = env('PUBLIC_PATH').'Attachment/'.date('Y', strtotime($val->Date)).'/'.date('M', strtotime($val->Date)).'/PO_'.$val->PID.'.pdf';

            $Files['Realization_Invoice'] = env('PUBLIC_PATH').$RealizationData->upload_invoice_path;

            $Files['Realization_Survey_Report'] = env('PUBLIC_PATH').$RealizationData->upload_survey_report_path;

            $LINK = DB::connection(Database::EPO)->select("EXECUTE [dbo].[SP_Email_ePO_Engineering_Fee] '$val->PID'")[0]->CheckerLink;

            $PARAM = [
                'PID' => $val->PID,
                'LINK' => $LINK
            ];

            // dd($Files);

            if( file_exists($Files['PDF_EPO']) === true ){
                \Mail::send($emailTemplate, $PARAM,
                function ($mail) use ($val, $Files) {
                        $mail->from(config('app.NO_REPLY_EMAIL'), config('app.name'));
                        foreach( $Files as $key => $file ){
                            $mail->attach($file);
                        }
                        $mail->to('it-dba07@lippoinsurance.com');
                        // $mail->to($val->Email_To);
                        $mail->bcc(['it-dba01@lippoinsurance.com', 'it-dba07@lippoinsurance.com']);
                        $mail->subject('Purchase Order #'.$val->PID.'# for you to check');
                    }
                ); 

                $val->Email_Sent = 'yes';
                $val->save();

                echo "Sukses";
            } else {
                echo "Fail";
            }
        }
    }
}
