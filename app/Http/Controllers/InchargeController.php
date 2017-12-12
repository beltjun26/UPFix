<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobRequest;
use App\Service;
use App\ServiceProvider;
use App\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InchargeController extends Controller
{
  public function showRequest($requestID){
    $jobRequest = JobRequest::where('requestID',$requestID)->first();
    if($jobRequest->accomplished()){
      return view('incharge.accomplishedRequest', compact('jobRequest'));
    }else{
      return view('incharge.request', compact('jobRequest'));
    }
    // return view('incharge.request', compact('jobRequest'));
  }

  public function addService(Request $request){
    Service::create([
      'name' => $request->name,
      'inchargeID' => Auth::user()->getRole->ID,
    ]);
    return redirect('incharge/services');
  }

  public function removeService($serviceID){
    DB::table('services')->where('ID', $serviceID);
  }

  public function allRequests(Request $request){
    $sort = $request->query('sort');
    $jobRequests = JobRequest::whereIn('serviceID', function($d){
      $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('inchargeID', Auth::user()->getRole->ID);
    })->paginate(10);
    if($sort=='all'){
      $jobRequests = JobRequest::whereIn('serviceID', function($d){
        $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('inchargeID', Auth::user()->getRole->ID);
      })->paginate(10);
    }else if($sort=='unrecommended'){
      $jobRequests = JobRequest::whereIn('serviceID', function($d){
        $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('inchargeID', Auth::user()->getRole->ID);
      })
      ->whereNotIn('requestID', function($d){
        $d->select('jobRequestID')->from('recommends');
      })->paginate(10);
    }else if($sort=='unaccomplished'){
      $jobRequests = JobRequest::whereIn('serviceID', function($d){
        $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('inchargeID', Auth::user()->getRole->ID);
      })
      ->whereNotIn('requestID', function($d){
        $d->select('jobRequestID')->from('accomplish');
      })->paginate(10);
    }else if($sort=='unassigned'){
      $jobRequests = JobRequest::whereIn('serviceID', function($d){
        $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('inchargeID', Auth::user()->getRole->ID);
      })
      ->whereNotIn('requestID', function($d){
        $d->select('jobRequestID')->from('assign');
      })->paginate(10);
    }else if($sort=='for_confirmation'){
      $jobRequests = JobRequest::whereIn('serviceID', function($d){
        $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('inchargeID', Auth::user()->getRole->ID);
      })
        ->whereIn('requestID', function($d){
          $d->select('jobRequestID')->from('accomplish')->whereNull('confirm');
        })->paginate(10);
    }else if($sort=='finished'){
      $jobRequests = JobRequest::whereIn('serviceID', function($d){
        $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('inchargeID', Auth::user()->getRole->ID);
      })
        ->whereIn('requestID', function($d){
          $d->select('jobRequestID')->from('accomplish')->where('confirm', '1');
        })->paginate(10);
    }

    return view('incharge.allRequests', compact('jobRequests', 'sort'));
  }

  public function showServices(){
    $services = Service::where('inchargeID', Auth::user()->getRole->ID)->paginate(10);
    return view('incharge.services', compact('services'));
  }

  public function assignRequests(){
    $jobRequests = JobRequest::whereIn('requestID', function($q){
      $q->select('jobRequestID')->from('approves');
    })->whereNotIn('requestID', function($d){
      $d->select('jobRequestID')->from('assign');
    })->paginate(10);
    return view('incharge.assignRequests', compact('jobRequests'));
  }

  public function assignTo($requestID){
    $serviceProviders = ServiceProvider::where('inchargeID', Auth::user()->getRole->ID)->get();
    if(!count($serviceProviders)){
      return redirect('/home');
    }
    $jobRequest = JobRequest::where('requestID', $requestID)->first();
    return view('incharge.assignTo', compact('jobRequest', 'serviceProviders'));
  }

  public function reports(Request $request){
    $sort = $request->query('sort');
    $category = $request->query('category');
    $serviceProviders = ServiceProvider::where('inchargeID', Auth::user()->getRole->ID)->paginate(10);
    return view('incharge.reports', compact('serviceProviders', 'sort', 'category'));
  }

  public function SPReport($serviceProviderID){
    $jobRequests = JobRequest::join('assign', 'assign.jobRequestID', '=', 'requestID')
      ->where('assign.serviceProviderID', $serviceProviderID)
      ->join('accomplish', 'accomplish.jobRequestID', '=', 'job_requests.requestID')
      ->orderBy('job_requests.created_at')->paginate(10);
    $serviceProvider = ServiceProvider::where('ID', $serviceProviderID)->first();
    return view('chairman.jobReport', compact('jobRequests', 'serviceProvider'));
  }



  public function recommend(Request $request){
    DB::table('recommends')->insert([
      'inchargeID' => Auth::user()->getRole->ID,
      'jobRequestID' => $request->requestID,
      'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);
    return redirect('/incharge/request/'.$request->requestID);
  }

  public function unrecommend(Request $request){
    DB::table('recommends')->where([
      ['inchargeID', '=', Auth::user()->getRole->ID],
      ['jobRequestID', '=', $request->requestID]
      ])->delete();
    return redirect('/incharge/request/'.$request->requestID);
  }

  public function assign(Request $request){
    DB::table('assign')->insert([
      'inchargeID' => Auth::user()->getRole->ID,
      'jobRequestID' => $request->requestID,
      'serviceProviderID' => $request->serviceProviderID,
      'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);
    return redirect('/incharge/assignRequests');
  }

  public function serviceProviders(){
    $serviceProviders = ServiceProvider::where('inchargeID', Auth::user()->getRole->ID)->paginate(10);
    return view('incharge.serviceProviders', compact('serviceProviders'));
  }

  public function addServiceProvider(Request $request){
    $this->validateSP($request->all())->validate();
    $data = $request->all();
    $user =  User::create([
      'username' => $data['username'],
      'fullName' => $data['name'],
      'gender' => $data['gender'],
      'role' => $data['role'],
      'email' => $data['email'],
      'password' => bcrypt($data['password']),
    ]);
    ServiceProvider::create([
      'userID' => $user->userID,
      'position' => $data['position'],
      'location' => $data['location'],
      'services' => $data['services'],
      'inchargeID' => Auth::user()->getRole->ID,
    ]);

    return redirect('/incharge/serviceProviders');
  }

  protected function validateSP(array $data){
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
}
