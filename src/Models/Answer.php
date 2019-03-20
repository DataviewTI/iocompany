<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'value',
        'attribute_id',
        'candidate_cpf',
        'character_set_id',
    ];

    public function candidate() {
        return $this->belongsTo('Dataview\IOCompany\Candidate');
    }

    public function attribute() {
        return $this->belongsTo('Dataview\IOCompany\Attribute');
    }
}
