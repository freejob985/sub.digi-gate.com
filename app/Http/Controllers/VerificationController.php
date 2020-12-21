<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Verification;
use App\Models\UserRole;
use App\User;
use Auth;
use Session;
use Gate;

class VerificationController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::allows('verification_index')) {
            $sort_search = null;
            $verification_requests = UserRole::orderBy('created_at', 'desc');
            if ($request->has('search')){
                $sort_search = $request->search;
                $user_ids = User::where(function($user) use ($sort_search){
                    $user->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%');
                })->pluck('id')->toArray();
                $verification_requests = $verification_requests->where(function($verification_request) use ($user_ids){
                    $verification_request->whereIn('user_id', $user_ids);
                });
                $verification_requests = $verification_requests->paginate(10);
            }
            else {
                $verification_requests = $verification_requests->where('role_id', '2')->orWhere('role_id', '3')->paginate(10);
            }
            return view('admin.default.verification_request.index', compact('verification_requests', 'sort_search'));
        }
        else {
            flash('You do not have access permission')->error();
            return back();
        }
    }

    //Verification Info sent to admin
    public function verification_store(Request $request)
    {
        $verification = new Verification;
        $verification->type = $request->verification_type;
        $verification->user_id = Auth::user()->id;
        $verification->role_id = Session::get('role_id');
        $verification->attachment = $request->verification_file;
        if ($verification->save()) {
            flash(__('Your verification file has been sent successfully'))->success();
            return back();
        }
        else {
            flash(__('Sorry! Something went wrong.'))->error();
            return back();
        }
    }

    public function show($username)
    {
        if (Gate::allows('verification_index')) {
            $user = User::where('user_name', $username)->first();
            return view('admin.default.verification_request.show', compact('user'));
        }
        else {
            flash('You do not have access permission')->error();
            return back();
        }
    }

    public function destroy($id)
    {
        $verification = Verification::findOrFail($id);
        if (Verification::destroy($id)) {
            flash('Verification info has been deleted successfully')->error();
            return redirect()->route('verification_requests');
        }
        else {
            flash('Something went wrong')->error();
            return back();
        }
    }

    public function verification_accept(Request $request)
    {
        $verification = Verification::findOrFail($request->id);
        $verification->verified = 1;
        if ($verification->save()) {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function verification_reject(Request $request)
    {
        $verification = Verification::findOrFail($request->id);
        if (Verification::destroy($verification->id)) {
            return 1;
        }
        else {
            return 0;
        }
    }
}
