<?php

namespace App\Http\Controllers;

use App\Model\LGIGlobal_User;
use Illuminate\Http\Request;

class SpecialMenuController extends Controller
{
    public function index(){

    }

    public function user(){
        // Retrieve users with the specified GroupCode
        $users = LGIGlobal_User::with('getUserGroup', 'getDept', 'getBranch')->whereHas('getUserGroup', function ($query) {
            $query->where('GroupCode', 'like', '%RMFEE%');
        })
        ->get();

        // Return the users to the view or do something else with them
        return view('special-menu.users.index', compact('users'));
    }

    public function user_search(Request $request){
        $search_user = $request->search_user;

        if( isset($request->btn_clear) ){
            $search_user = '';
        }

        $users = LGIGlobal_User::with('getUserGroup', 'getDept', 'getBranch')
        ->whereHas('getUserGroup', function ($query) use($search_user) {
            $query->where('GroupCode', 'like', '%RMFEE%');
        })
        ->where(function($query2) use($search_user){
            $query2->where('Name', 'like', '%'.$search_user.'%')
            ->orWhere('NIK', 'like', '%'.$search_user.'%');
        })
        ->get();

        return view('special-menu.users.index', compact('users', 'search_user'));
    }
}
