<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class CBOBigGroup extends Model
{
  public $incrementing = false;
  protected $table = 'cbo_big_groups';
  protected $fillable = ['group'];
}
