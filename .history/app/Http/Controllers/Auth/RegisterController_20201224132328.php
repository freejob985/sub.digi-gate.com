<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\Role;
use App\Models\Address;
use App\Models\UserRole;
use App\Models\UserProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('frontend.default.user_sign_up');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // dd($data);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_name' =>Str::slug($data['name'], '-').date('Ymd-his'),
            'password' => Hash::make($data['password']),
        ]);

        if (in_array('freelancer', $data['user_types'])) {
            $role = Role::where('name', 'Freelancer')->first();
            $user_role = new UserRole;
            $user_role->user_id = $user->id;
            $user_role->role_id = $role->id;
            $user_role->save();
        }
        if(in_array('client', $data['user_types'])) {
            $role = Role::where('name', 'Client')->first();
            $user_role = new UserRole;
            $user_role->user_id = $user->id;
            $user_role->role_id = $role->id;
            $user_role->save();
        }
        if(in_array('comprehensive', $data['user_types'])) {
         


            
        }
        $address = new Address;
        $user->address()->save($address);
        Session::put('role_id', $role->id);

        $user_profile = new UserProfile;
        $user_profile->user_id = $user->id;
        $user_profile->user_role_id = Session::get('role_id');
        $user_profile->save();

        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */

}
