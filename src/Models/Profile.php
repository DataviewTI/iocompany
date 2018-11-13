<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
  protected $fillable = ['profile'];

  public function features(){
      return $this->belongsToMany('Dataview\IOCompany\Feature');
  }
}
