<?php

namespace App\Http\Controllers;

use App\Helpers\Realization;
use Illuminate\Http\Request;

class RealizationController extends Controller
{
    public $brokerName, $startDate, $endDate, $branch, $noPolicy, $agingRmf, $nBrn, $theInsured, $statusRealisasi, $toDoList;

    public function __construct(){
        
    }

    public function index(){
        $this->brokerName = isset( request()->broker_name ) ? request()->broker_name : '';
        $this->startDate = isset( request()->start_date ) ? request()->start_date : '';
        $this->endDate = isset( request()->end_date ) ? request()->end_date : '';
        $this->branch = isset( request()->branch ) ? request()->branch : '';
        $this->noPolicy = isset( request()->no_policy ) ? request()->no_policy : '';
        $this->agingRmf = isset( request()->aging_rmf ) ? request()->aging_rmf : '';
        $this->nBrn = isset( request()->nb_rm ) ? request()->nb_rm : '';
        $this->theInsured = isset( request()->the_insured ) ? request()->the_insured : '';
        $this->statusRealisasi = isset( request()->status_realisasi ) ? request()->status_realisasi : '';
        $this->toDoList = isset( request()->to_do_list ) ? request()->to_do_list : '';

        $Realizations = Realization::GetRealization();

        return view('pages.realization.index', compact('Realizations'));
    }
}
