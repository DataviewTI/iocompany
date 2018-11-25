<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class ResignationReason extends Model
{
  protected $fillable = ['title', 'order'];

  public function jobExperiences()
  {
    return $this->hasMany('Dataview\IOCompany\JobExperience');
  }

}
