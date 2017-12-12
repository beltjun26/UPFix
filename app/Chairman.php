<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chairman extends Model
{
    protected $primaryKey = 'ID';
    protected $fillable = [
      'ID', 'userID', 'departmentID',
    ];

    public function getUser(){
      return $this->hasOne('App\User', 'userID', 'userID');
    }

    public function getNotifNumber($category){
      $count = -1;
      if($category == 'unappoved_requests'){
        $count = jobRequest::whereNotIn('requestID', function($q){
          $q->select('jobRequestID')->from('approves');
        })->whereIn('serviceID', function($d){
          $d->select('services.ID')->from('services')->join('incharges', 'incharges.ID', '=', 'inchargeID')->where('departmentID', $this->departmentID);
        })->whereIn('requestID', function($e){
          $e->select('jobRequestID')->from('recommends');
        })->count();
      }
      if($category == 'all_requests'){
        $count = jobRequest::whereIn('serviceID', function($d){
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
