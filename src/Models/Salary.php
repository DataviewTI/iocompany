<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
  protected $fillable = ['salary','order'];

  public function candidates()
  {
    return $this->hasMany('Dataview\IOCompany\Candidate');
  }

  public function jobs()
  {
    return $this->hasMany('Dataview\IOCompany\Job');
  }
  
}
