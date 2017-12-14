<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServiceProviderController extends Controller
{

  public function allRequests(Request $request){
    $sort = $request->query('sort');
    $jobRequests = JobRequest::whereIn('requestID', function($d){
      $d->select('jobRequestID')->from('assign')->where('serviceProviderID', Auth::user()->getRole->ID);
    });
    if($sort=='unaccomplished'){
      $jobRequests = JobRequest::whereIn('requestID', function($d){
        $d->select('jobRequestID')->from('assign')->where('serviceProviderID', Auth::user()->getRole->ID);
      })->whereNotIn('requestID', function($q){
        $q->select('jobRequestID')->from('accomplish')->where('serviceProviderID', Auth::user()->getRole->ID);
      });
    }else if($sort=='for_confirmation'){
      $jobRequests = JobRequest::whereIn('requestID', function($d){
        $d->select('jobRequestID')->from('accomplish')->whereNull('confirm');
      })->whereIn('requestID', function($q){
        $q->select('jobRequestID')->from('assign')->where('serviceProviderID', Auth::user()->getRole->ID);
      });
    }else if($sort=='finished'){
      $jobRequests = JobRequest::whereIn('requestID', function($d){
        $d->select('jobRequestID')->from('accomplish')->where('confirm', '1 ');
      })->whereIn('requestID', function($q){
        $q->select('jobRequestID')->from('assign')->where('serviceProviderID', Auth::user()->getRole->ID);
      });
    }
    $jobRequests = $jobRequests->orderBy('created_at', 'desc')->paginate(10);
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
    $start = Carbon::parse($request->startDate);
    $end = Carbon::parse($request->endDate);
    $data = [];
    for($date = $start; $date->lte($end);$date->addDay()){
      $data[] = array('serviceProviderID' =>Auth::user()->getRole->ID,'date'=>$date->format('Y-m-d'),'created_at' => \Carbon\Carbon::now()->toDateTimeString(),'updated_at' => \Carbon\Carbon::now()->toDateTimeString());
    }
    // DB::table('unavailability')->insert([
    //   'serviceProviderID' => Auth::user()->getRole->ID,
    //   'date' => $request->
    // ]);
    DB::table('unavailability')->insert($data);
    return redirect('/serviceProvider/unavailability');
  }

  public function unavailabilityList($ID){
    $dates = DB::table('unavailability')
      ->where('serviceProviderID',$ID)
      ->whereDate('date', '>=', Carbon::today()->toDateString())
      ->orderBy('date', 'asc')
      ->paginate(10);
    return view('serviceProvider.unavailabilityList', compact('dates'));
  }
}
