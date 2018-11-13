<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class City extends Model
{
    use SoftDeletes;
    protected $fillable = ['id','city','state'];
}
