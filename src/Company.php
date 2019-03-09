<?php
namespace Dataview\IOCompany;

use Dataview\IntranetOne\IOModel;
use Dataview\IntranetOne\Group;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable implements AuditableContract
{
  // IOModel -------------------------------
  use Auditable;
	use SoftDeletes;
  protected $auditTimestamps = true;

  protected $dates = ['deleted_at'];

  public function setAppend($index,$value){
		$this->appends[$index] = $value;
  }

  public function getAppend($index){
		return $this->appends[$index];
  }
  
  public static function pkgAddr($addr){
    return __DIR__.'/'.$addr;
  } 
  // ---------------------------------------

  protected  $primaryKey = 'cnpj';
  public $incrementing = false;

  protected $fillable = [
    'cnpj',
    'razaoSocial',
    'nomeFantasia',
    'phone1',
    'phone',
    'mobile',
    'mobile2',
    'email',
    'zipCode',
    'address',
    'address2',
    'numberApto',
    'city_id',
    'group_id',
    'description',
    'data',
    'password',
    'last_login',
    'remember_token',
    'active', 
  ];

  protected $appends = [
    'group' => false,
  ];

  protected $casts = [
    'data' => 'array',
    'cnpj' => 'string'
  ];

  public function group(){
    return $this->belongsTo('Dataview\IntranetOne\Group');
  }

  public function jobs()
  {
    return $this->hasMany('Dataview\IOCompany\Job');
  }

  public function city(){
    return $this->belongsTo('Dataview\IOCompany\City');
  }

  public static function boot(){
    parent::boot(); 
    static::created(function (Company $obj) {
        if($obj->getAppend("group") !== false){
          $group = new Group([
            'group' => $obj->getAppend("group"),
            'sizes' => $obj->getAppend("sizes")
          ]);
          $group->save();
          $obj->group()->associate($group)->save();
      }
    });
    
  }
}
