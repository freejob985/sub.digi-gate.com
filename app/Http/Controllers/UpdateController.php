<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL;
use DB;
use Artisan;
use Schema;
use App\Models\SystemConfiguration;

class UpdateController extends Controller
{
    public function step0() {
        return view('update.step0');
    }

    public function step1() {
        if(SystemConfiguration::where('type', 'current_version')->first() != null && SystemConfiguration::where('type', 'current_version')->first()->value == '1.2'){
            $sql_path = base_path('sqlupdates/v13.sql');
            DB::unprepared(file_get_contents($sql_path));
        }
        elseif(SystemConfiguration::where('type', 'current_version')->first() != null && SystemConfiguration::where('type', 'current_version')->first()->value == '1.1'){
            $sql_path = base_path('sqlupdates/v12.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v13.sql');
            DB::unprepared(file_get_contents($sql_path));
        }
        elseif(SystemConfiguration::where('type', 'current_version')->first() == null){
            $sql_path = base_path('sqlupdates/v11.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v12.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v13.sql');
            DB::unprepared(file_get_contents($sql_path));
        }

        return redirect('step2');
    }

    public function step2() {
        Artisan::call('view:clear');
        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier      = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);

        return view('update.done');
    }
}
