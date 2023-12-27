<?php

namespace App\Http\Controllers;

use App\Enums\Database;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenerateAttachmentEpoController extends Controller
{
    public function index($PID){
        $PDF_Epo = DB::connection(Database::EPO)->select("EXECUTE [dbo].[SP_Email_PDF_ePO_Engineering_Fee] '$PID'")[0];
        return view('attachment.epo')->with('PDF_Epo', $PDF_Epo);
    }
}
