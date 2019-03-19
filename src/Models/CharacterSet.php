<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class CharacterSet extends Model
{
    protected $fillable = [
        'title',
        'description',
        'slug',
    ];
}
