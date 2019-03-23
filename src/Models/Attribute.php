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

    public function characterSet() {
        return $this->belongsTo('Dataview\IOCompany\CharacterSet', 'character_set_id');
    }
}
