<?php

namespace App\Console\Commands;

use App\Enums\Database;
use App\Model\ReportGenerator_LogEmailEpo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class GenerateAttachmentPO extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:attachment-epo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generating PDF of EPO for email attachment.';

    protected $baseUrl, $publicPath, $pageTitle, $pageOfTitle, $date;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseUrl = env('APP_PDF_URL');
        $this->publicPath = env('PUBLIC_PATH');
        $this->pageTitle = 'Page';
        $this->pageOfTitle = 'Of';
        $this->date = date('d-M-Y', strtotime(now()));

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $LogEmailEpo = ReportGenerator_LogEmailEpo::where('Email_Sent', null)->get();
        if( count($LogEmailEpo) > 0 ){
            foreach( $LogEmailEpo as $val ) {
                // $url = route('generate-pdf-attachment-epo', $val->PID);
                $url = $this->baseUrl.'/generate-pdf-attachment-epo/'.$val->PID;
                
                if ($this->isReportError($url, $data=[])) continue;

                $destination = $this->publicPath . 'Attachment/'.date('Y', strtotime($val->Date)).'/'.date('M', strtotime($val->Date));
    
                if( !File::isDirectory($destination) ) {
                    File::makeDirectory($destination, 0777, true);
                }
    
                $filename = 'PO_'.$val->PID;
                $destinationPath = $destination .'/'.$filename.'.pdf';
    
                if( file_exists($destinationPath) === false ) {
                    $cmd = env('WKHTMLTOPDF')." -q --margin-top 10 --margin-left 5 --margin-right 5 --footer-font-size 6 --footer-right \"{$this->pageTitle} [page] {$this->pageOfTitle} [topage]\" {$url} {$destinationPath}";
                    exec($cmd);
                }
    
                echo "SUKSES";
                echo "\n";
                echo $url;
                echo "\n";
                // return true;
            }
        }else{
            echo "ERROR";
        }
    }

    public function isReportError($url=false, $data=[])
    {
        if (!$url) return true;

        $content = $this->curl_get_contents($url);

        if (strpos($content, '<h1>Whoops, looks like something went wrong.</h1>') !== false) {
            return true;
        }
        return false;
    }

    public function curl_get_contents($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
