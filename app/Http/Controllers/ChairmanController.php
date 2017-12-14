<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobRequest;
use App\Incharge;
use App\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChairmanController extends Controller
{
  public function showRequest($requestID){
    $jobRequest = JobRequest::where('requestID',$requestID)->first();
    return view('chairman.request', compact('jobRequest'));
  }

  public function approve(Request $request){
    DB::table('approves')->insert([
      'chairmanID' => Auth::user()->getRole->ID,
      'jobRequestID' => $request->requestID,
      'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);
    return redirect('/chairman/request/'.$request->requestID);
  }

  public function allRequests(Request $request){
    $sort = $request->query('sort');
    $jobRequests = jobRequest::whereIn('serviceID', function($d){
      $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('departmentID', Auth::user()->getRole->departmentID);
    })
    ->orderBy('created_at', 'desc')
    ->paginate(10);
    if($sort=='all'){
      $jobRequests = jobRequest::whereIn('serviceID', function($d){
        $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('departmentID', Auth::user()->getRole->departmentID);
      })
      ->orderBy('created_at', 'desc')
      ->paginate(10);
    }else if($sort=='unrecommended'){
      $jobRequests = jobRequest::whereIn('serviceID', function($d){
        $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('departmentID', Auth::user()->getRole->departmentID);
      })
      ->whereNotIn('requestID', function($d){
        $d->select('jobRequestID')->from('recommends');
      })
      ->orderBy('created_at', 'desc')
      ->paginate(10);
    }else if($sort=='unaccomplished'){
      $jobRequests = jobRequest::whereIn('serviceID', function($d){
        $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('departmentID', Auth::user()->getRole->departmentID);
      })
      ->whereNotIn('requestID', function($d){
        $d->select('jobRequestID')->from('accomplish');
      })
      ->orderBy('created_at', 'desc')
      ->paginate(10);
    }else if($sort=='unassigned'){
      $jobRequests = JobRequest::whereIn('serviceID', function($d){
        $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('departmentID', Auth::user()->getRole->departmentID);
      })
      ->whereNotIn('requestID', function($d){
        $d->select('jobRequestID')->from('assign');
      })
      ->orderBy('created_at', 'desc')
      ->paginate(10);
    }else if($sort=='for_confirmation'){
      $jobRequests = JobRequest::whereIn('serviceID', function($d){
        $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('departmentID', Auth::user()->getRole->departmentID);
      })
        ->whereIn('requestID', function($d){
          $d->select('jobRequestID')->from('accomplish')->whereNull('confirm');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    }else if($sort=='finished'){
      $jobRequests = JobRequest::whereIn('serviceID', function($d){
        $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('departmentID', Auth::user()->getRole->departmentID);
      })
        ->whereIn('requestID', function($d){
          $d->select('jobRequestID')->from('accomplish')->where('confirm', '1');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    }
    return view('chairman.allRequests', compact('jobRequests', 'sort'));
  }

  public function disapprove(Request $request){
    DB::table('approves')->where([
      ['chairmanID', '=', Auth::user()->getRole->ID],
      ['jobRequestID', '=', $request->requestID]
      ])->delete();
    return redirect('/chairman/request/'.$request->requestID);
  }

  public function serviceProviders(){
    $serviceProviders = DB::table('service_providers')
      ->select('fullName', 'service_providers.ID')
      ->join('incharges', 'service_providers.inchargeID', '=', 'incharges.ID')
      ->join('users', 'users.userID', '=', 'service_providers.userID')
      ->where('incharges.departmentID' ,Auth::user()->getRole->departmentID)
      ->get();
    // $serviceProviders = ServiceProvider::join('incharges', 'service_providers.inchargeID', '=', 'incharges.ID')->where('incharges.departmentID', Auth::user()->getRole->departmentID)->get();
    return view('chairman.serviceProviders', compact('serviceProviders'));
  }

  public function SPReport($serviceProviderID){
    $jobRequests = JobRequest::join('assign', 'assign.jobRequestID', '=', 'requestID')
      ->where('assign.serviceProviderID', $serviceProviderID)
      ->join('accomplish', 'accomplish.jobRequestID', '=', 'job_requests.requestID')
      ->orderBy('job_requests.created_at')->paginate(10);
    $serviceProvider = ServiceProvider::where('ID', $serviceProviderID)->first();
    return view('chairman.jobReport', compact('jobRequests', 'serviceProvider'));
  }

  public function reports(Request $request){
    $sort = $request->query('sort');
    $category = $request->query('category');
    $year = $request->query('year');
    $serviceProviders = ServiceProvider::whereIn('inchargeID', function($d){
      $d->select('ID')->from('incharges')->where('departmentID', Auth::user()->getRole->departmentID);
    })->paginate(10);

    return view('chairman.reports', compact('serviceProviders', 'sort', 'category', 'year'));
  }
}
