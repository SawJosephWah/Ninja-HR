<?php

namespace App\Http\Controllers;

use App\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateCompanySetting;

class CompanySettingController extends Controller
{

    public function show($id)
    {
        if(!Auth::user()->hasDirectPermission('view_company_setting')){
            abort(403, 'Unauthorized action.');
        };
        $company_setting = CompanySetting::findOrFail($id);
        return view('company_setting.show',compact('company_setting'));
    }


    public function edit($id)
    {
        if(!Auth::user()->hasDirectPermission('edit_company_setting')){
            abort(403, 'Unauthorized action.');
        };
        $company_setting = CompanySetting::findOrFail($id);
        return view('company_setting.edit',compact('company_setting'));
    }


    public function update(UpdateCompanySetting $request, $id)
    {
        if(!Auth::user()->hasDirectPermission('update_company_setting')){
            abort(403, 'Unauthorized action.');
        };
        $company_setting = CompanySetting::findOrFail($id);
        $company_setting->company_name = $request->company_name;
        $company_setting->company_email = $request->company_email ;
        $company_setting->company_phone = $request->company_phone;
        $company_setting->company_address = $request->company_address;
        $company_setting->company_start_time = $request->company_start_time;
        $company_setting->company_end_time = $request->company_end_time;
        $company_setting->company_break_start = $request->company_break_start;
        $company_setting->company_break_end = $request->company_break_end;
        $company_setting->update();

        return redirect()->route('company_setting.show',$id)->with('success','Successfully Updated Company Setting');

    }

}
