<?php

namespace App\Http\Controllers;

use App\Helpers\Realization;
use App\Helpers\Utils;
use App\Model\SeaReport_Profile;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UtilsController extends Controller
{
    public function SearchProfile(Request $request){
        $Profile = Utils::SearchProfile($request->keywords, $request->currency);
        return $Profile;
    }

    public function SearchProfileOnSettingBudget(Request $request){
        $Profile = Utils::SearchProfileOnSettingBudget($request->keywords);
        return $Profile;
    }

    public function SearchOccupation(Request $request){
        $Profile = Utils::SearchOccupation($request->keywords);
        return $Profile;
    }
    
    public function SearchBudgetByPolicyNoAndBrokerName(Request $request){
        $Budgets = Utils::SearchBudgetByPolicyNoAndBrokerName($request->keywords, $request->broker_name, $request->RealizationDataId);

        // Add Date Formatting and Thousand Seperator.
        foreach( $Budgets as $Budget ){
            $Budget->Start_Date = Carbon::CreateFromFormat('Y-m-d H:i:s.000', $Budget->Start_Date)->format('d M Y');
            $Budget->End_Date = Carbon::CreateFromFormat('Y-m-d H:i:s.000', $Budget->End_Date)->format('d M Y');
            $Budget->PAYMENT_DATE = Carbon::CreateFromFormat('Y-m-d H:i:s.000', $Budget->PAYMENT_DATE)->format('d M Y');
            $Budget->LAST_EDITED = Carbon::CreateFromFormat('Y-m-d H:i:s.000', $Budget->LAST_EDITED)->format('d M Y');
            $Budget->LGI_PREMIUM = number_format($Budget->LGI_PREMIUM);
            $Budget->PREMIUM = number_format($Budget->PREMIUM);
            $Budget->ADMIN = number_format($Budget->ADMIN);
            $Budget->DISCOUNT = number_format($Budget->DISCOUNT);
            $Budget->PAYMENT = number_format($Budget->PAYMENT);
        }
        
        return $Budgets;
    }

    public function SearchProfileOnReportOs(Request $request){
        $keywords = $request->input('keywords');
        $Profile = SeaReport_Profile::select('ID', 'Name')
            ->where('ID', 'LIKE', '%'.$keywords.'%')
            ->orWhere('Name', 'LIKE', '%'.$keywords.'%')
            ->limit(100)
        ->get();

        return response()->json($Profile);
    }
}
