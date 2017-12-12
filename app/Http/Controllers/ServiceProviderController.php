<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceProviderController extends Controller
{

  public function allRequests(Request $request){
    $sort = $request->query('sort');
    $jobRequests = JobRequest::whereIn('requestID', function($d){
      $d->select('jobRequestID')->from('assign')->where('serviceProviderID', Auth::user()->getRole->ID);
    })
    ->orderBy('created_at', 'desc')
    ->paginate(10);
    return view('serviceProvider.allRequests', compact('jobRequests', 'sort'));
  }

  public function showRequest($requestID){
    $jobRequest = JobRequest::where('requestID', $requestID)->first();
    if($jobRequest->accomplished()){
      return view('serviceProvider.accomplishedRequest', compact('jobRequest'));
    }else{
      return view('serviceProvider.request', compact('jobRequest'));
    }
  }

  public function accomplish(Request $request){
    DB::table('accomplish')->insert([
      'serviceProviderID' => Auth::user()->getRole->ID,
      'jobRequestID' => $request->requestID,
      'remarks' => $request->remarks,
    ]);
    return redirect('/home');
  }

  public function unavailability(){
    return view('serviceProvider.unavailability');
  }
  public function addUnavailability(Request $request){
    DB::table('')
  }
}
