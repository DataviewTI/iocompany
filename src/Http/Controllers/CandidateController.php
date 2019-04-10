<?php
namespace Dataview\IOCompany;
  
use Dataview\IntranetOne\IOController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Response;

use App\Http\Requests;
use Illuminate\Http\Request;
use Dataview\IntranetOne\Group;
use Dataview\IOCompany\Attribute;
use Dataview\IOCompany\CandidateRequest;
use Dataview\IOCompany\Candidate;
use Dataview\IOCompany\Graduation;
use Dataview\IOCompany\GraduationType;
use Dataview\IOCompany\Job;
use Dataview\IOCompany\ResignationReason;
use Dataview\IOCompany\JobDuration;
use Dataview\IOCompany\MaritalStatusType;
use Validator;
use DataTables;
use Session;
use Sentinel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use \App\Mail\NewCandidateCreated;

class CandidateController extends IOController{

	public function __construct(){
    $this->service = 'company';
	}

  public function index(){
		return view('Candidate::index');
	}
	
  public function list(){
		$query = Candidate::select('id','name', 'gender','birthday','cpf','apprentice','address_city')
    ->with('pcdType')
    ->with('maritalStatus')
    ->with('salary')
    ->with('childrenAmount')
    ->get();

    return Datatables::of(collect($query))->make(true);
  }

	public function create(CandidateRequest $request){
    // dump($request->all());
    if(Candidate::where('cpf', $request->cpf)->first())
      return response()->json(['message' => 'Este CPF já está cadastrado!'], 500);
      
    $check = $this->__create($request);
    if(!$check['status'])
      return response()->json(['errors' => $check['errors'] ], $check['code']);	

    $obj = new Candidate($request->all());
    $password = str_random(8);
    $obj->password = Hash::make($password);
    $obj->save();
    // Mail::to($obj->email)->send(new NewCandidateCreated(['cpf' => $request->cpf, 'password' => $password]));

    if($request->__graduations != null){
      $graduations = json_decode($request->__graduations);

      foreach ($graduations as $graduation) {
        $g = new Graduation([
          'institution' => $graduation->institution,
          'ending' => $graduation->ending,
          'school' => $graduation->school,
        ]);
        $g->graduationType()->associate(GraduationType::where('id', $graduation->graduation_type_id)->first());
        $obj->graduations()->save($g);
      }
    }

    if($request->__jobs != null){
      $jobs = json_decode($request->__jobs);
  
      foreach ($jobs as $job) {
        $j = new JobExperience([
          'type' => $job->job_type,
          'company' => $job->company,
          'role' => $job->role,
        ]);
        $j->jobDuration()->associate(JobDuration::where('id', $job->job_duration_id)->first());
        if($job->job_type == 'J')
          $j->resignationReason()->associate(ResignationReason::where('id', $job->resignation_reason_id)->first());
        $obj->jobExperiences()->save($j);
      }
    }

    $obj->maritalStatus()->associate(
      MaritalStatusType::where('id',$request->marital_status)->first()
    );

    $obj->childrenAmount()->associate(
      ChildrenAmount::where('id',$request->children_amount)->first()
    );

    $obj->degree()->associate(
      Degree::find($request->degree)
    );

    $obj->salary()->associate(
      Salary::find($request->salary)
    );

    if($request->pcd != "" && $request->pcd != null){
      $obj->pcdType()->associate(
        PcdType::find($request->pcd)
      );
    } 

    $attributes = Attribute::with('characterSet')->get();

    $attrs = [];
    foreach ($attributes as $attribute) {
      array_push($attrs, [
        'attribute_id' => $attribute->id,
        'character_set_id' => $attribute->characterSet->id,
        'value' => $request->{$attribute->id},
      ]);
    }

    $obj->save();

    // dump($obj);
    // dump($obj->answers);

    return response()->json(['success'=>true,'data'=>null]);
	}

  public function view($id){
    $check = $this->__view();
    if(!$check['status'])
      return response()->json(['errors' => $check['errors'] ], $check['code']);	

    $query = $query = Candidate::where('id', $id)
    ->with([
      'maritalStatus',
      'degree',
      'pcdType',
      'salary',
      'childrenAmount',
    ])
    ->with([ 'graduations' => function ($query) {
      $query->with('graduationType');
    }])
    ->with([ 'jobExperiences' => function ($query) {
      $query->with(['jobDuration', 'resignationReason']);
    }])
    ->get();
				
    return response()->json(['success'=>true,'data'=>$query]);
	}
	
	public function update($id,CandidateRequest $request){
    $check = $this->__update($request);
    if(!$check['status'])
      return response()->json(['errors' => $check['errors']], $check['code']);	

    $_old = Candidate::find($id);
    $_old->update([
      'name' => $request->name,
      'social_name' => $request->social_name,
      'birthday' => $request->birthday,
      'gender' => $request->gender,
      'cpf' => $request->cpf,
      'rg' => $request->rg,
      'cnh' => $request->cnh,
      'apprentice' => $request->apprentice,
      'phone' => $request->phone,
      'mobile' => $request->mobile,
      'email' => $request->email,
      'zipCode' => $request->zipCode,
      'address_street' => $request->address_street,
      'address_number' => $request->address_number,
      'address_district' => $request->address_district,
      'address_city' => $request->address_city,
      'address_state' => $request->address_state,
    ]);

    $_old->maritalStatus()->dissociate();
    $_old->maritalStatus()->associate(
      MaritalStatusType::where('id',$request->marital_status)->first()
    );

    $_old->childrenAmount()->dissociate();
    $_old->childrenAmount()->associate(
      ChildrenAmount::where('id',$request->children_amount)->first()
    );

    $_old->degree()->dissociate();
    $_old->degree()->associate(
      Degree::find($request->degree)
    );

    $_old->salary()->dissociate();
    $_old->salary()->associate(
      Salary::find($request->salary)
    );
    
    $_old->manageGraduations(json_decode($request->__graduations));
    $_old->manageJobExperiences(json_decode($request->__jobs));

    if($request->pcd != "" && $request->pcd != null){
      $_old->pcdType()->associate(
        PcdType::find($request->pcd)
      );
    } else {
      $_old->pcd_type_id = null;
    }
    
    return response()->json(['success'=>$_old->save()]);
	}

  public function delete($id){
    $check = $this->__delete();
    if(!$check['status'])
      return response()->json(['errors' => $check['errors'] ], $check['code']);	

    $obj = Candidate::find($id);
    $obj = $obj->delete();
    return  json_encode(['sts'=>$obj]);
  }

}
