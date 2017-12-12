<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Client;
use App\Chairman;
use App\ServiceProvider;
use App\Incharge;
use App\Department;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/home';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if($data['role']=='client'){ //checked
          return Validator::make($data, [
            'username' => 'required|string|unique:users',
            'name' => 'required|string|max:255',
            'gender' =>'required|in:male,female',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'position' => 'required|string',
            'location' => 'required|string|max:255',
          ]);
        }
        if($data['role']=='serviceProvider'){//checked
          return Validator::make($data, [
            'username' => 'required|string|unique:users',
            'name' => 'required|string|max:255',
            'gender' =>'required|in:male,female',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'position' => 'required|string',
            'location' => 'required|string|max:255',
            'services' => 'required|string|max:1000',

          ]);
        }
        if($data['role']=='chairman'){ //checked
          return Validator::make($data, [
            'username' => 'required|string|unique:users',
            'name' => 'required|string|max:255',
            'gender' =>'required|in:male,female',
            'department' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
          ]);
        }
        if($data['role']=='incharge'){
          return Validator::make($data, [
            'username' => 'required|string|unique:users',
            'name' => 'required|string|max:255',
            'gender' =>'required|in:male,female',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
          ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
      if($data['role']!='client'){
        $departmentID = $data['department'];
      }
      if($data['role']=='chairman'){
        $department = Department::create([
          'name' => $data['department'],
        ]);
        $departmentID = $department->ID;
      }
      $user =  User::create([
        'username' => $data['username'],
        'fullName' => $data['name'],
        'gender' => $data['gender'],
        'role' => $data['role'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
      ]);

      if($data['role']=='client'){
        Client::create([
          'userID' => $user->userID,
          'location' => $data['location'],
          'position' => $data['position'],
        ]);
      }
      if($data['role']=='chairman'){
        Chairman::create([
          'userID' => $user->userID,
          'departmentID' => $departmentID,
        ]);
      }
      if($data['role']=='serviceProvider'){
        ServiceProvider::create([
          'userID' => $user->userID,
          'position' => $data['position'],
          'location' => $data['location'],
          'services' => $data['services'],
          'inchargeID' => $data['inchargeID'],
        ]);
      }if($data['role']=='incharge'){
        Incharge::create([
          'userID' => $user->userID,
          'departmentID' => $departmentID,
        ]);
      }
      return $user;
    }

}
