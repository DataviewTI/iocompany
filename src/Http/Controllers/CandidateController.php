<?php
namespace Dataview\IOCompany;
  
use Dataview\IntranetOne\IOController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Response;

use App\Http\Requests;
use Illuminate\Http\Request;
use Dataview\IntranetOne\Group;
use Dataview\IOCompany\CandidateRequest;
use Dataview\IOCompany\Candidate;
use Dataview\IOCompany\Graduation;
use Dataview\IOCompany\GraduationType;
use Dataview\IOCompany\Job;
use Dataview\IOCompany\JobDuration;
use Dataview\IOCompany\MaritalStatusType;
use Validator;
use DataTables;
use Session;
use Sentinel;

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
    $check = $this->__create($request);
    if(!$check['status'])
      return response()->json(['errors' => $check['errors'] ], $check['code']);	

    $obj = new Candidate($request->all());
    $obj->save();

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
          'type' => $job->job_type_id,
          'company' => $job->company,
          'role' => $job->role,
        ]);
        $j->jobDuration()->associate(JobDuration::where('id', $job->job_duration_id)->first());
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
    $obj->save();

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
      $query->with('jobDuration');
    }])
    ->get();
				
    return response()->json(['success'=>true,'data'=>$query]);
	}
	
	public function update($id,CandidateRequest $request){
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
