<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utility\SettingsUtility;
use Gate;

class GeneralConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('system_configuration')) {
            return view('admin.default.system_configurations.general_config.index');
        }
        else {
            flash(__('You do not have access permission!'))->warning();
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {
                SettingsUtility::save_settings($type,trim($value));
                if($type == 'site_name'){
                    $system_config = new SystemConfigurationController;
                    $system_config->overWriteEnvFile("APP_NAME",trim($value));
                }
                if($type == 'timezone'){
                    $system_config = new SystemConfigurationController;
                    $system_config->overWriteEnvFile('APP_TIMEZONE',trim($value));
                }
            }
        }


        flash("Settings updated successfully")->success();
        return back();
    }
}
