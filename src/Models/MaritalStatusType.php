<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class MaritalStatusType extends Model
{
  protected $fillable = ['title', 'order'];

  public function candidates()
  {
    return $this->hasMany('Dataview\IOCompany\Candidate');
  }

}
