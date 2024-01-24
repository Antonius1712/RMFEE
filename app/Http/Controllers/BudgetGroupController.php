<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BudgetGroupController extends Controller
{
    public function index(){
        dd('zzz');
        return view('pages.setting.budget-group.index');
    }
}
