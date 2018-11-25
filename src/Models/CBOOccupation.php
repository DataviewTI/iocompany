<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class CBOOccupation extends Model
{
  public $incrementing = false;
  protected $table = 'cbo_occupations';
  protected $fillable = ['occupation'];

  public function jobs()
  {
    return $this->hasMany('Dataview\IOCompany\Job');
  }
}
