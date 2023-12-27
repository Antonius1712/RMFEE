<?php

namespace App\Http\Controllers;

use App\Helpers\Setting;
use App\Http\Requests\SettingUserRequest;
use App\Model\ReportGenerator_UserSetting;
use Exception;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function userIndex(){
        // dd( auth()->user()->getUserSetting );
        try {
            $UserSettings = Setting::GetUserSetting();
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Error while get user setting. please contact administrator.');
        }

        return view('pages.setting.user.index', compact('UserSettings'));
    }

    public function userCreate(){
        $userList = Setting::GetUserList();
        $typeOfPaymentList = Setting::GetTypeOfPaymentList();
        $approvalListBu = Setting::GetApprovalListBU();
        $approvalListFinance = Setting::GetApprovalListFinance();
        return view('pages.setting.user.create', compact('userList', 'typeOfPaymentList', 'approvalListBu', 'approvalListFinance'));
    }

    public function userStore(SettingUserRequest $request){
        try {
            $CountUserSetting = ReportGenerator_UserSetting::where('UserID', $request->nik)->count();
            if( $CountUserSetting > 0 ){
                return redirect()->back()->withErrors("There's an existing setting for this user.");
            }
            Setting::SaveUserSetting($request);
            return redirect()->route('setting.user.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Error while save user setting. please contact administrator.');
        }
    }

    public function userEdit($UserId){
        try {
            $userList = Setting::GetUserList();
            $typeOfPaymentList = Setting::GetTypeOfPaymentList();
            $approvalListBu = Setting::GetApprovalListBU();
            $approvalListFinance = Setting::GetApprovalListFinance();

            $UserSetting = Setting::GetUserSetting($UserId)[0];
            // dd($UserSetting);
            return view('pages.setting.user.edit', compact('userList', 'typeOfPaymentList', 'approvalListBu', 'approvalListFinance', 'UserSetting'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Error while edit user setting. please contact administrator.');
        }
    }

    public function userUpdate($UserId, Request $request){
        try {
            Setting::UpdateUserSetting($UserId, $request);
            return redirect()->route('setting.user.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Error while update user setting on UserID = '.$UserId.'. please contact administrator.');
        }
    }
}
