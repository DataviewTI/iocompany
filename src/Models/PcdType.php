<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class PcdType extends Model
{
  protected $fillable = ['title', 'order'];

  public function candidates()
  {
    return $this->hasMany('Dataview\IOCompany\Candidate');
  }

  public function jobs()
  {
    return $this->hasMany('Dataview\IOCompany\Job');
  }
  
}
