<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class CBOSubgroup extends Model
{
  public $incrementing = false;
  protected $table = 'cbo_subgroups';
  protected $fillable = ['subgroup'];
}
