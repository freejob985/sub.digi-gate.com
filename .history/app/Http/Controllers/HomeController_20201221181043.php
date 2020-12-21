<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use Hash;
use App\User;
use App\Models\Role;
use App\Models\Package;
use App\Models\Project;
use App\Models\ChatThread;
use App\Models\UserProfile;
use App\Models\SystemConfiguration;
use Carbon;
use Illuminate\Support\Str;
use App\Models\Service;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
if(Session::get('locale')==""){
    
   // dd("Catch errors for script and full tracking ( 2 )");
    Session::put('locale', "sa");

    
}
     $freelancer_services = Service::orderBy('id', 'DESC')->paginate(8);
//$services = Auth::user()->services()->paginate(12);

   //  @dd($freelancer_services);
        return view('frontend.default.index', compact('freelancer_services'));
    }

    //Admin login
    public function admin_login()
    {
        if(Auth::check() && (auth()->user()->userRoles->first()->role->name == "Admin" || auth()->user()->userRoles->first()->role->role_type == "employee")){
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    //User login
    public function login()
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('frontend.default.user_login');
    }

    public function admin_dashboard()
    {
        return view('admin.default.dashboard');
    }


    //Redirect user-based dashboard
    public function dashboard()
    {
        $role_id = Auth::user()->userRoles->first()->role_id;
        $user_profile = UserProfile::where('user_id', Auth::user()->id)->where('user_role_id', $role_id)->first();
        Session::put('role_id', $role_id);

        if(isFreelancer()){
            return view('frontend.default.user.freelancer.dashboard');
        }
        elseif(isClient()){
            return view('frontend.default.user.client.dashboard');
        }
        elseif(comprehensive()){
            return view('frontend.default.user.client.comprehensive');
        }
        else {
            abort(404);
        }
    }

    //Show details info of specific project
    public function project_details($slug)
    {
        $project = Project::where('slug', $slug)->first();
        return view('frontend.default.project-single', compact('project'));
    }

    //Show details info of specific project
    public function private_project_details($slug)
    {
        $project = Project::where('slug', $slug)->first();
        if ($project != null) {
            $id = $project->id;
            $user = Auth::user()->id;
            $chat_thread = ChatThread::where(function ($query) use ($id){
                                $query->where('project_id', '=', $id);
                            })->where(function ($query) use ($user){
                                $query->where('sender_user_id', '=', $user)
                                      ->orWhere('receiver_user_id', '=', $user);
                            })->first();
        }
        return view('frontend.default.private_project_single', compact('project', 'chat_thread'));
    }

    //Show all project list to user
    // public function all_projects(Request $request)
    // {
    //     $projects = Project::biddable()->notcancel()->where('private', '0')->latest();
    //
    //     $keyword = null;
    //     if($request->has('keyword')){
    //         $keyword = $request->keyword;
    //         $projects = $projects->where('name', 'like', '%'.$keyword.'%');
    //     }
    //     $total = count($projects->get());
    //     $projects = $projects->paginate(8);
    //     return view('frontend.default.projects-listing', compact('projects', 'keyword', 'total'));
    // }

    //Show specific client details to user
    public function client_details($username)
    {
        $client = User::where('user_name', $username)->first();
        $open_projects = Project::where('client_user_id', $client->id)->biddable()->open()->notcancel()->latest()->get();
        return view('frontend.default.client-single', compact('client', 'open_projects'));
    }

    //Show all client's list to user
    public function client_list()
    {
        $clients = UserProfile::where('user_role_id', '3')->paginate(8);
        $total_clients = UserProfile::where('user_role_id', '3')->get();
        return view('frontend.default.clients-listing', compact('clients', 'total_clients'));
    }

    //Show all freelancer's list to user
    public function freelancer_list()
    {
        $freelancers = UserProfile::where('user_role_id', '2')->paginate(8);
        $total_freelancers = UserProfile::where('user_role_id', '2')->get();
        return view('frontend.default.freelancers-listing', compact('freelancers', 'total_freelancers'));
    }

    //Show specific freelancer details to user
    public function freelancer_details($username)
    {
        $freelancer = User::where('user_name', $username)->first();
        return view('frontend.default.freelancer-single', compact('freelancer'));
    }

    //check if username exists
    public function user_name_check(Request $request)
    {
        $user_name = User::where('user_name', '=', Str::slug($request->username, '-'))->first();
        if ($user_name != null) {
            $response = "<span style='color: red; font-size: 8pt'>User name already Exist.</span>";
            return $response;
        }
        else {
            $response = "<span style='color: green; font-size: 8pt'>Available.</span>";
            return $response;
        }
    }

    public function send_email_verification_request(Request $request){
        return send_email_verification_email();
    }

    public function verification_confirmation($code){
        $user = User::where('verification_code', $code)->first();
        if($user != null){
            $user->email_verified_at = Carbon::now();
            $user->save();

            flash('Your email has been verified successfully')->success();
        }
        else {
            flash('Sorry, we could not verifiy you. Please try again')->danger();
        }

        return redirect()->route('dashboard');
    }
}
