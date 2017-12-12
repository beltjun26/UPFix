<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\JobRequest;
use App\Service;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'client'){
          $jobRequests = JobRequest::where('clientID', Auth::user()->getRole->ID)->whereNotIn('requestID', function($d){
            $d->select('jobRequestID')->from('accomplish');
          })->paginate(10);
          return view('client.home', compact('jobRequests'));
        }
        if(Auth::user()->role == 'serviceProvider'){
          $jobRequests = JobRequest::whereNotIn('requestID', function($d){
            $d->select('jobRequestID')->from('accomplish')->where('serviceProviderID', Auth::user()->getRole->ID);
          })->whereIn('requestID', function($q){
            $q->select('jobRequestID')->from('assign')->where('serviceProviderID', Auth::user()->getROle->ID);
          })->paginate(10);
          return view('serviceProvider.home',compact('jobRequests'));
        }
        if(Auth::user()->role == 'incharge'){
          $jobRequests = JobRequest::whereNotIn('requestID', function($q){
            $q->select('jobRequestID')->from('recommends');
          })->whereIn('serviceID', function($d){
            $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('departmentID', Auth::user()->getRole->departmentID);
          })->paginate(10);

          return view('incharge.home', compact('jobRequests'));
        }
        if(Auth::user()->role == 'chairman'){
          $jobRequests = JobRequest::whereNotIn('requestID', function($q){
            $q->select('jobRequestID')->from('approves');
          })->whereIn('serviceID', function($d){
            $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('departmentID', Auth::user()->getRole->departmentID);
          })->whereIn('requestID', function($e){
            $e->select('jobRequestID')->from('recommends');
          })->paginate(10);
          return view('chairman.home', compact('jobRequests'));
        }
    }


}
