<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'title',
        'description',
        'slug',
    ];
}
