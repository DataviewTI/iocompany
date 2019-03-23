<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'candidate_cpf',
        'job_id',
        'type',
        'data',
    ];

    public function candidate(){
        return $this->belongsTo('Dataview\IOCompany\Candidate', 'candidate_cpf');
    }

    public function job(){
        return $this->belongsTo('Dataview\IOCompany\Job', 'job_id');
    }

}
