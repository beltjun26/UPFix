<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class RegisterUserTypeController extends Controller
{
  public function registerAsServiceProvider(){
    return view('auth.registerServiceProvider');
  }

  public function registerAsChairman(){
    return view('auth.registerChairman');
  }

  public function registerAsClient(){
    return view('auth.registerClient');
  }

  public function registerAsDepartment(){
    return view('auth.registerDepartment');
  }

}
