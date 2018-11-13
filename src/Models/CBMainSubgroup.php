<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class CBOMainSubgroup extends Model
{
  public $incrementing = false;
  protected $table = 'cbo_main_subgroups';
  protected $fillable = ['subgroup'];
}
