<?php

namespace App;
use App\Chairman;
use App\Incharge;
use App\ServiceProvider;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class jobRequest extends Model
{
    protected $primaryKey = "requestID";
    protected $table = 'job_requests';

    protected $fillable = [
      'requisitioningUnit', 'location', 'description', 'dateNeeded', 'alternativeDate', 'contactNo', 'clientID','serviceID',
    ];

    protected $dates = [
      'alternativeDate', 'dateNeeded',
    ];

    public function approved(){
      $data = DB::table('approves')->where('jobRequestID', $this->requestID)->first();
      if($data){
        return True;
      }else{
        return False;
      }
    }

    public function getClient(){
      return $this->belongsTo('App\Client', 'clientID');
    }

    public function approvedBy(){
      $data = DB::table('approves')->where('jobRequestID', $this->requestID)->first();
      return Chairman::find($data->chairmanID)->first();
    }


    public function recommended(){
      $data = DB::table('recommends')->where('jobRequestID', $this->requestID)->first();
      if($data){
        return True;
      }else{
        return False;
      }
    }

    public function recommendedBy(){
        $data = DB::table('recommends')->where('jobRequestID', $this->requestID)->first();
        return Incharge::find($data->inchargeID)->first();
    }
    public function assignedTo(){
        $data = DB::table('assign')->where('jobRequestID', $this->requestID)->first();
        if($data){
          return ServiceProvider::find($data->serviceProviderID)->first();
        }
    }

    public function assigned(){
      $data = DB::table('assign')->where('jobRequestID', $this->requestID)->first();
      if($data){
        return True;
      }else{
        return False;
      }
    }

    public function indication(){
      if($this->assignedTo()){
        return 'success';
      }else if($this->approved() && $this->recommended()) {
        return 'info';
      }else{
        return 'warning';
      }
    }

    public function approvedDate(){
      $data = DB::table('approves')->where('jobRequestID', $this->requestID)->first();
      if($data){
        return $data->created_at;
      }
    }

    public function accomplished(){
      $data = DB::table('accomplish')->where('jobRequestID', $this->requestID)->first();
      if($data){
        return True;
      }else{
        return False;
      }
    }

    public function accomplishedDate(){
      $data = DB::table('accomplish')->where('jobRequestID', $this->requestID)->first();
      if($data){
        return $data->created_at;
      }
    }

    public function accomplish(){
      return DB::table('accomplish')->where('jobRequestID', $this->requestID)->first();
    }

    public function confirmed(){
      $data = DB::table('accomplish')->where('jobRequestID', $this->requestID)->first();
      if($data){
        if($data->confirm){
          return True;
        }else{
          return False;
        }
      }else{
        return False;
      }
    }

    public function getComment(){
      $data = DB::table('accomplish')
        ->where('jobRequestID', $this->requestID)
        ->first();
      return $data->comment;
    }


}
