<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Order extends Model implements AuditableContract
{
    use Auditable;
	use SoftDeletes;
    protected $auditTimestamps = true;

    protected $fillable = [
        'company_cnpj',
        'plan_id',
        'max_portions',
        'wirecard_data',
        'payment_method',
    ];

    protected $casts = [
        'wirecard_data' => 'json',
    ];

    public $timestamps = true;

    public function plan() {
        return $this->belongsTo('Dataview\IOCompany\Plan');
    }

    public function company() {
        return $this->belongsTo('Dataview\IOCompany\Company', 'company_cnpj', 'cnpj');
    }
}
