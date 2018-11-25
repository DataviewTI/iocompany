<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;
use Dataview\IOCompany\Candidate;

class Degree extends Model
{
  protected $fillable = ['degree','order'];

  public function candidates()
  {
    return $this->hasMany('Dataview\IOCompany\Candidate');
  }

  public function jobs()
  {
    return $this->hasMany('Dataview\IOCompany\Job');
  }

}
