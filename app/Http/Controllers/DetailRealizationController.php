<?php

namespace App\Http\Controllers;

use App\Enums\BudgetStatus;
use App\Helpers\Budget;
use App\Helpers\DetailRealization;
use App\Helpers\Realization;
use App\Helpers\Utils;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DetailRealizationController extends Controller
{
    public function index($invoice_no){
        $RealizationData = Realization::GetRealization($invoice_no)[0];
        $DetailRealization = DetailRealization::GetDetailRealization($RealizationData->ID);
        return view('pages.realization.detail-realization.index', compact('invoice_no', 'RealizationData', 'DetailRealization'));
    }

    public function create($invoice_no){
        $Currencies = Utils::GetCurrencies();
        $RealizationData = Realization::GetRealization($invoice_no)[0];
        $BrokerName = Utils::GetProfile($RealizationData->Broker_ID, $RealizationData->Currency);
        $BrokerName = $BrokerName != null ? $BrokerName->Name : "";
        return view('pages.realization.detail-realization.create', compact('RealizationData', 'BrokerName', 'Currencies'));
    }

    public function store(Request $request){        
        $RealizationData = Realization::GetRealization($request->invoice_no)[0];
        try {
            // $Budget = DetailRealization::UpdateBudgetRealization($request, $RealizationData->type_of_invoice);
            // if( $Budget == BudgetStatus::OVERLIMIT ) {
            //     return redirect()->back()->withErrors('Realization Overlimit Remaining Budget');
            // }else if( $Budget == BudgetStatus::NOTOVERLIMIT ) {
            //     DetailRealization::SaveDetailRealization($request, $RealizationData->ID);
            // }

            DetailRealization::SaveDetailRealization($request, $RealizationData->ID);
        } catch (Exception $e) {
            Log::error('Error While on Store Function of DetailRealizationController invoice = ' . $request->invoice_no. ' Exception = '.$e->getMessage());
        }
        return redirect()->route('realization.detail-realization.index', $request->invoice_no);
    }

    public function edit($invoice_no, $id){
        $Currencies = Utils::GetCurrencies();
        $RealizationData = Realization::GetRealization($invoice_no);
        $DetailRealization = DetailRealization::GetDetailRealizationById($id);
        $BrokerName = Utils::GetProfile($RealizationData->Broker_ID, $RealizationData->Currency);
        $BrokerName = $BrokerName != null ? $BrokerName->Name : "";
        return view('pages.realization.detail-realization.edit', compact('DetailRealization', 'RealizationData', 'BrokerName', 'Currencies', 'invoice_no'));
    }

    public function update(Request $request, $invoice_no, $id){
        $RealizationData = Realization::GetRealization($invoice_no);
        try {
            DetailRealization::UpdateDetailRealization($request, $RealizationData->ID, $id);
        } catch (Exception $e) {
            Log::error('Error While on Store Function of DetailRealizationController invoice = ' . $request->invoice_no);
        }
        return redirect()->route('realization.detail-realization.index', $request->invoice_no);
    }

    public function show($invoice_no, $id){
        $Currencies = Utils::GetCurrencies();
        $RealizationData = Realization::GetRealization($invoice_no);
        $DetailRealization = DetailRealization::GetDetailRealizationById($id);
        $BrokerName = Utils::GetProfile($RealizationData->broker_id, $RealizationData->currency);
        $BrokerName = $BrokerName != null ? $BrokerName->Name : "";
        return view('pages.realization.detail-realization.show', compact('DetailRealization', 'RealizationData', 'BrokerName', 'Currencies', 'invoice_no'));
    }
}