<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class GraduationType extends Model
{
  protected $fillable = ['title', 'order'];

  public function graduations()
  {
    return $this->hasMany('Dataview\IOCompany\Graduation');
  }

}
