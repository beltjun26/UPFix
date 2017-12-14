<?php

namespace App;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ServiceProvider extends Model
{
    protected $table = 'service_providers';
    protected $primaryKey = 'ID';
    protected $fillable = [
      'userID', 'position', 'location', 'services', 'inchargeID',
    ];

    public function getUser(){
      return $this->hasOne('App\User', 'userID', 'userID');
    }

    public function getAccomplished($sort, $year){
      $month = '00';
      if(!$year){
        $year = date('Y');
      }
      if($sort=='jan'){
        $month = '01';
      }
      if($sort=='feb'){
        $month = '02';
      }
      if($sort=='mar'){
        $month = '03';
      }
      if($sort=='apr'){
        $month = '04';
      }
      if($sort=='may'){
        $month = '05';
      }
      if($sort=='jun'){
        $month = '06';
      }
      if($sort=='jul'){
        $month = '07';
      }
      if($sort=='aug'){
        $month = '08';
      }
      if($sort=='sep'){
        $month = '09';
      }
      if($sort=='oct'){
        $month = '10';
      }
      if($sort=='nov'){
        $month = '11';
      }
      if($sort=='dec'){
        $month = '12';
      }

      $accomplish = DB::table('accomplish')
        ->join('job_requests', 'job_requests.requestID', '=', 'accomplish.jobRequestID')
        ->where('serviceProviderID', $this->ID)
        ->whereYear('job_requests.created_at', '=', $year)
        ->get();
      if($sort && $sort!='all'){
        if($sort=='jan-jun'){
          $accomplish = DB::table('accomplish')
            ->join('job_requests', 'job_requests.requestID', '=', 'accomplish.jobRequestID')
            ->where('serviceProviderID', $this->ID)
            ->whereMonth('job_requests.created_at', '>=' , '01')
            ->whereMonth('job_requests.created_at', '<=' , '06')
            ->whereYear('job_requests.created_at', '=', $year)
            ->get();
        }
        else if($sort=='jul-dec'){
          $accomplish = DB::table('accomplish')
            ->join('job_requests', 'job_requests.requestID', '=', 'accomplish.jobRequestID')
            ->where('serviceProviderID', $this->ID)
            ->whereMonth('job_requests.created_at', '>=' , '07')
            ->whereMonth('job_requests.created_at', '<=' , '12')
            ->whereYear('job_requests.created_at', '=', $year)
            ->get();
        }else{
          $accomplish = DB::table('accomplish')
          ->join('job_requests', 'job_requests.requestID', '=', 'accomplish.jobRequestID')
          ->where('serviceProviderID', $this->ID)
          ->whereMonth('job_requests.created_at', '=' , $month)
          ->whereYear('job_requests.created_at', '=', $year)
          ->get();
        }
      }

        return $accomplish;
    }

    public function getAssigned($sort, $year){
      if(!$year){
        $year = date('Y');
      }
      $month = '00';
      if($sort=='jan'){
        $month = '01';
      }
      if($sort=='feb'){
        $month = '02';
      }
      if($sort=='mar'){
        $month = '03';
      }
      if($sort=='apr'){
        $month = '04';
      }
      if($sort=='may'){
        $month = '05';
      }
      if($sort=='jun'){
        $month = '06';
      }
      if($sort=='jul'){
        $month = '07';
      }
      if($sort=='aug'){
        $month = '08';
      }
      if($sort=='sep'){
        $month = '09';
      }
      if($sort=='oct'){
        $month = '10';
      }
      if($sort=='nov'){
        $month = '11';
      }
      if($sort=='dec'){
        $month = '12';
      }
      $assigned = DB::table('assign')
      ->join('job_requests', 'job_requests.requestID', '=', 'assign.jobRequestID')
      ->where('serviceProviderID', $this->ID)
      ->whereYear('job_requests.created_at', '=',$year)
      ->get();
      if($sort && $sort!='all'){
        if($sort=='jan-jun'){
          $assigned = DB::table('assign')
          ->join('job_requests', 'job_requests.requestID', '=', 'assign.jobRequestID')
          ->where('serviceProviderID', $this->ID)
          ->whereMonth('job_requests.created_at', '>=' , '01')
          ->whereMonth('job_requests.created_at', '<=' , '06')
          ->whereYear('job_requests.created_at', '=', $year)
          ->get();
        }
        else if($sort=='jul-dec'){
          $assigned = DB::table('assign')
          ->join('job_requests', 'job_requests.requestID', '=', 'assign.jobRequestID')
          ->where('serviceProviderID', $this->ID)
          ->whereMonth('job_requests.created_at', '>=' , '07')
          ->whereMonth('job_requests.created_at', '<=' , '12')
          ->whereYear('job_requests.created_at', '=', $year)
          ->get();
        }else{
          $assigned = DB::table('assign')
          ->join('job_requests', 'job_requests.requestID', '=', 'assign.jobRequestID')
          ->where('serviceProviderID', $this->ID)
          ->whereMonth('job_requests.created_at', '=' , $month)
          ->whereYear('job_requests.created_at', '=', $year)
          ->get();
        }
      }
      return $assigned;
    }

    public function getNotifNumber($category){
      $count = -1;
      if($category == 'job_requests'){
        $count = JobRequest::whereNotIn('requestID', function($d){
          $d->select('jobRequestID')->from('accomplish')->where('serviceProviderID', Auth::user()->getRole->ID);
        })->whereIn('requestID', function($q){
          $q->select('jobRequestID')->from('assign')->where('serviceProviderID', Auth::user()->getROle->ID);
        })->count();
      }
      if($category == 'all_requests'){
        $count = JobRequest::whereIn('requestID', function($d){
          $d->select('jobRequestID')->from('assign')->where('serviceProviderID', Auth::user()->getRole->ID);
        })->count();
      }
      if($count == 0){
        return '';
      }else{
        return $count;
      }
    }

    public function isAvailable($date){
      $unavailability = DB::table('unavailability')
        ->where('serviceProviderID', $this->ID)
        ->where('date', $date)
        ->count();
      if($unavailability){
        return False;
      }else{
        return True;
      }
    }


}
