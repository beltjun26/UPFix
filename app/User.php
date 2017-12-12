<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullName', 'email', 'password', 'username', 'gender', 'role', 'departmentID',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $primaryKey = 'userID';

    public function getRole(){
      if($this->role == 'client'){
        return $this->hasOne('App\Client', 'userID', 'userID');
      }
      if($this->role == 'incharge'){
        return $this->hasOne('App\Incharge', 'userID', 'userID');
      }
      if($this->role == 'serviceProvider'){
        return $this->hasOne('App\ServiceProvider', 'userID', 'userID');
      }
      if($this->role == 'chairman'){
        return $this->hasOne('App\Chairman', 'userID', 'userID');
      }
    }

    public function department(){
      return $this->hasOne('App\Department', 'ID', 'departmentID');
    }
}
