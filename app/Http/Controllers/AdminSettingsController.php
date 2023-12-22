<?php

namespace App\Http\Controllers;

use App\Models\AdminSetting;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    function index()
    {
        $settings = getAdminSettings();
        return view('admin.settings.index',compact(['settings']));
    }

    function update(Request $request)
    {
        try{
            $settings = $request->settings;
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
            return redirect()->route('settings')->with('success', 'Settings has been Updated.');
        }catch (\Throwable $th){
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }
}
