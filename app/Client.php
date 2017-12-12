<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
  protected $primaryKey = 'ID';
  protected $fillable = [
      'userID', 'location', 'position',
  ];

  public function hasJobRequests(){
    return $this->hasMany('App\JobRequest', 'clientID');
  }

  public function getUser(){
    return $this->hasOne('App\User', 'userID', 'userID');
  }

  public function getNotifNumber($category){
    $count = -1;
    if($category == 'job_request'){
      $count = JobRequest::where('clientID', $this->ID)->whereNotIn('requestID', function($d){
        $d->select('jobRequestID')->from('accomplish');
      })->count();
    }
    if($category == 'accomplished_requests'){
      $count = JobRequest::where('clientID', $this->ID)->whereIn('requestID', function($d){
        $d->select('jobRequestID')->from('accomplish')->whereNull('confirm');
      })->count();
    }
    if($category == 'all_requests'){
      $count = jobRequest::where('clientID', $this->ID)->count();
    }
    if($count == 0){
      return '';
    }else{
      return $count;
    }
  }
}
