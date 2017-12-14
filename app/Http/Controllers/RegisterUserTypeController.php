<?php

namespace App\Http\Controllers;
use App\Department;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class RegisterUserTypeController extends Controller
{
  public function registerAsServiceProvider(){
    $department = Department::first();
    if($department){
      $departments = Department::all();
      return view('auth.registerServiceProvider', compact('departments'));
    }else{
      return view ('error.departmentMissing');
    }
  }

  public function registerAsChairman(){
    return view('auth.registerChairman');
  }

  public function registerAsClient(){
    $department = Department::first();
    if($department){
      $departments = Department::all();
      return view('auth.registerClient', compact('departments'));
    }else{
      return view ('error.departmentMissing');
    }
  }

  public function registerAsIncharge(){
    $department = Department::first();
    if($department){
      $departments = Department::all();
      return view('auth.registerIncharge', compact('departments'));
    }else{
      return view ('error.departmentMissing');
    }
  }

}
