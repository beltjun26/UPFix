<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incharge extends Model
{
    protected $table = 'incharges';
    protected $primaryKey = 'ID';

    protected $fillable = [
      'userID', 'ID', 'departmentID',
    ];

    public function getUser(){
      return $this->hasOne('App\User', 'userID', 'userID');
    }

    public function getNotifNumber($category){
      $count = -1;
      if($category == 'unrecommend_requests'){
        $count = jobRequest::whereNotIn('requestID', function($q){
          $q->select('jobRequestID')->from('recommends');
        })->whereIn('serviceID', function($d){
          $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('departmentID', $this->departmentID);
        })->count();
      }
      if($category == 'assign_requests'){
        $count = JobRequest::whereIn('requestID', function($q){
          $q->select('jobRequestID')->from('approves');
        })->whereNotIn('requestID', function($d){
          $d->select('jobRequestID')->from('assign');
        })->count();
      }
      if($category == 'all_requests'){
        $count = JobRequest::whereIn('serviceID', function($d){
          $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('departmentID', $this->departmentID);
        })->count();
      }
      if($count == 0){
        return '';
      }else{
        return $count;
      }
    }
}
