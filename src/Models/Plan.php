<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Plan extends Model implements AuditableContract
{
    use Auditable;
	use SoftDeletes;
    protected $auditTimestamps = true;

    protected $fillable = [
        'name',
        'code',
        'description',
        'setup_fee',
        'interval_unit',
        'interval_length',
        'billing_cycles',
        'trial_days',
        'trial_enabled',
        'trial_hold_setup_fee',
        'status',
        'max_qty',
        'payment_method',
    ];

    public $timestamps = true;

    public function orders() {
        return $this->hasMany('Dataview\IOCompany\Order');
    }
}
