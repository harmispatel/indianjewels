<?php

namespace App\Http\Controllers;

use App\Models\AdminSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSettingsController extends Controller
{
    function index()
    {
        if(Auth::guard('admin')->user()->can('settings.index')){
            $settings = getAdminSettings();
            return view('admin.settings.index',compact(['settings']));
        }else{
            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        }
    }

    function update(Request $request)
    {
        try{
            $settings = $request->settings;
            if(Auth::guard('admin')->user()->can('settings.update')){
                if(count($settings) > 0){
                    foreach ($settings as $key => $setting){
                        $is_exists = AdminSetting::where('setting_key',$key)->first();
                        $setting_id = (isset($is_exists['id']) && !empty($is_exists['id'])) ? $is_exists['id'] : '';

                        if(!empty($setting_id) || $setting_id != ''){
                            $update_settings = AdminSetting::find($setting_id);
                            $update_settings->value = $setting;
                            $update_settings->update();
                        }else{
                            $new_settings = new AdminSetting();
                            $new_settings->setting_key = $key;
                            $new_settings->value = $setting;
                            $new_settings->save();
                        }
                    }
                }
                return redirect()->route('settings.index')->with('success', 'Settings has been Updated.');
            }else{
                return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
            }
        }catch (\Throwable $th){
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }
}
