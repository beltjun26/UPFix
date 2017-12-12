<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  protected $primaryKey = "ID";
  protected $fillable = [
    'inchargeID', 'name',
  ];

}
