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
        //! Generating Attachment EPO.
        $test = $this->call('generate:attachment-epo');

        //! Preparing Email.
        $this->info("Preparing Email.");
        $LogEmailEpo = ReportGenerator_LogEmailEpo::where('Email_Sent', null)->get();
        $Files = [];
        foreach( $LogEmailEpo as $val ){

            $RealizationData = ReportGenerator_Realization_Group::where('id', $val->Realisasi_ID)->first();

            //TODO BUAT PENGIRIMAN EMAIL DARI DATA INI.
            $emailTemplate = 'email.sent-email-epo';
            $Files['PDF_EPO'] = env('PUBLIC_PATH').'Attachment/'.date('Y', strtotime($val->Date)).'/'.date('M', strtotime($val->Date)).'/PO_'.$val->PID.'.pdf';

            if( $RealizationData->upload_invoice_path != '' ){
                $Files['Realization_Invoice'] = env('PUBLIC_PATH').$RealizationData->upload_invoice_path;
            }

            if( $RealizationData->upload_survey_report_path != '' ){
                $Files['Realization_Survey_Report'] = env('PUBLIC_PATH').$RealizationData->upload_survey_report_path;
            }

            $EMAIL_EPO = DB::connection(Database::EPO)->select("EXECUTE [dbo].[SP_Email_ePO_Engineering_Fee] '$val->PID'")[0];

            // $PARAM3 = 'APRILIAFIN';
            $PARAM3 = $EMAIL_EPO->UserId;
            $PARAM4 = $EMAIL_EPO->CheckerLink;

            // LIVE
            // $LINK = "https://epo.lippoinsurance.com/post.Default2.wgx?param1=1&param2=JESSY&param3=".$PARAM3."&param4=".$PARAM4."&param5=1";

            // DEMO
            // $LINK = "http://172.16.0.57/ePO/post.Default2.wgx?param1=1&param2=JESSY&param3=".$PARAM3."&param4=".$PARAM4."&param5=1";
            $LINK = "http://172.16.0.57/ePO/post.Default2.wgx?param1=1&param2=TIMMIE%20M&param3=".$PARAM3."&param4=".$PARAM4."&param5=1";
            
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
                        $mail->to('timmie@lgi.co.id');
                        // $mail->to('shintawati@lgi.co.id');
                        // $mail->to($val->Email_To);
                        $mail->bcc(['it-dba01@lgi.co.id', 'it-dba07@lgi.co.id', 'it-dba18@lgi.co.id']);
                        $mail->subject('Purchase Order #'.$val->PID.'# for you to check');
                        
                        //? Testing Only.
                        // $mail->to('it-dba07@lippoinsurance.com');
                        // $mail->subject('Purchase Order #'.$val->PID.'# for you to check');
                    }
                ); 

                DB::connection(Database::REPORT_GENERATOR)->statement("exec [SP_Update_Log_Email_Engineering_Fee] '$val->ID', 1, '".date('Y-m-d', strtotime(now()))."', '".date('H:i:s', strtotime(now()))."'");

                // $val->Email_Sent = 'yes';
                // $val->save();

                echo "Sukses";
            } else {
                echo "Fail";
            }
        }
    }
}
