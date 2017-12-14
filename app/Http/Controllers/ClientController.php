<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobRequest;
use App\User;
use App\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{

    public function requestForm(){
      $service = Service::first();
      if($service){
        $services = Service::all();
        return view('client.requestForm', compact('services'));
      }else{
        return view('error.requestForm');
      }
    }

    public function allRequests(Request $request){
      $sort = $request->query('sort');
      $jobRequests = JobRequest::where('clientID', Auth::user()->getRole->ID)->paginate(10);
      if($sort=='all'){
        $jobRequests = JobRequest::where('clientID', Auth::user()->getRole->ID)->paginate(10);
      }else if($sort=='unrecommended'){
        $jobRequests = JobRequest::where('clientID', Auth::user()->getRole->ID)
          ->whereNotIn('requestID', function($d){
            $d->select('jobRequestID')->from('recommends');
          })->paginate(10);
      }else if($sort=='unaccomplished'){
        $jobRequests = JobRequest::where('clientID', Auth::user()->getRole->ID)
          ->whereNotIn('requestID', function($d){
            $d->select('jobRequestID')->from('accomplish');
          })->paginate(10);
      }else if($sort=='unassigned'){
        $jobRequests = JobRequest::where('clientID', Auth::user()->getRole->ID)
          ->whereNotIn('requestID', function($d){
            $d->select('jobRequestID')->from('assign');
          })->paginate(10);
      }else if($sort=='for_confirmation'){
        $jobRequests = JobRequest::where('clientID', Auth::user()->getRole->ID)
          ->whereIn('requestID', function($d){
            $d->select('jobRequestID')->from('accomplish')->whereNull('confirm');
          })->paginate(10);
      }else if($sort=='finished'){
        $jobRequests = JobRequest::where('clientID', Auth::user()->getRole->ID)
          ->whereIn('requestID', function($d){
            $d->select('jobRequestID')->from('accomplish')->where('confirm', '1');
          })->paginate(10);
      }else if($sort=='conflict'){
        $jobRequests = JobRequest::where('clientID', Auth::user()->getRole->ID)
          ->where('conflict', '1')->paginate(10);
      }
      return view('client.allRequests', compact('jobRequests', 'sort'));
    }

    public function showRequest($requestID){
      $jobRequest = JobRequest::where('requestID', $requestID)->first();
      if($jobRequest->accomplished()){
        return view('client.accomplishedRequest', compact('jobRequest'));
      }else{
        return view('client.request', compact('jobRequest'));
      }

    }

    public function profile($username){
      $user = User::where('username', $username)->first();
      return view('profile', compact('user'));
    }

    public function deleteRequest(Request $request){
      JobRequest::destroy($request->requestID);
      return redirect('/home');
    }

    public function processRequest(Request $request){
      $validatedData = $request->validate([
        'requisitioningUnit' => 'required|max:255',
        'location' => 'required|max:255',
        'description' =>'required|max:255',
        'dateNeeded' => 'required|date',
        'alternativeDate' => 'required|date',
        'contactNo' => 'required|max:15',
      ]);
      $data = $request->all();
      JobRequest::create([
        'requisitioningUnit' => $data['requisitioningUnit'],
        'location' => $data['location'],
        'description' => $data['description'],
        'dateNeeded' => $data['dateNeeded'],
        'serviceID' => $data['service'],
        'alternativeDate' => $data['alternativeDate'],
        'contactNo' => $data['contactNo'],
        'clientID' => Auth::user()->getRole->ID,
      ]);

      return redirect('/home');
    }

    public function showAccomplishedRequests(){
      $jobRequests = JobRequest::where('clientID', Auth::user()->getRole->ID)->whereIn('requestID', function($d){
        $d->select('jobRequestID')->from('accomplish')->whereNull('confirm');
      })->paginate(10);
      return view('client.accomplishedRequests', compact('jobRequests'));
    }

    public function conflictRequest($requestID){
      $jobRequest = JobRequest::where('requestID', $requestID)->first();
      return view('client.conflictRequest', compact('jobRequest'));
    }

    public function confirm(Request $request){
      DB::table('accomplish')->where('jobRequestID', $request->requestID)->update([
        'confirm' => '1',
        'rating' => $request->rating,
        'comment' => $request->comment,
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
      ]);

      return redirect('/client/accomplishedRequests');
    }

    public function conflicts(){
      $jobRequests = JobRequest::where('conflict', '1')
      ->where('clientID', Auth::user()->getRole->ID)
      ->paginate(10);

      return view('client/conflicts', compact('jobRequests'));
    }

    public function changeDate(Request $request){
      JobRequest::where('requestID', $request->requestID)
      ->update([
        'dateNeeded' => $request->dateNeeded,
        'alternativeDate' => $request->alternativeDate,
        'conflict' => 0,
      ]);
      return redirect('/client/conflicts');
    }
}
