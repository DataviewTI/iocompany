<?php
namespace Dataview\IOCompany;
  
use Dataview\IntranetOne\IOController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Response;

use App\Http\Requests;
use Illuminate\Http\Request;
use Dataview\IOCompany\JobRequest;
use Dataview\IOCompany\Company;
use Dataview\IOCompany\PcdType;
use Dataview\IOCompany\Job;
use Dataview\IOCompany\Candidate;
use Dataview\IOCompany\Salary;
use Dataview\IOCompany\Degree;
use Dataview\IOCompany\CBOOccupation;
use Dataview\IntranetOne\Group;
use Validator;
use DataTables;
use Session;
use Sentinel;
use Illuminate\Support\Arr;

class JobController extends IOController{

	public function __construct(){
    $this->service = 'job';
	}

  public function index(){
		return view('Job::index');
	}
 
  public function list(){
    $query = Job::where('id', '!=', 'null')->with([
      'profile',
      'degree',
      'company',
      'cboOccupation',
      'salary',
      'pcdType',
    ])->get();

    return Datatables::of(collect($query))->make(true);
  }


	public function cboList($kw=null){
    $query = CBOOccupation::select('id as i','occupation as o');
    return Datatables::of(collect($query->get()))->make(true);
  }

	public function create(JobRequest $request){
    $check = $this->__create($request);
    if(!$check['status'])
      return response()->json(['errors' => $check['errors'] ], $check['code']);	

    $obj = new Job($request->all());

    $obj->cboOccupation()->associate(
      CBOOccupation::where('occupation',$request->cbo)->first()
    );

    $obj->profile()->associate(
      Profile::find($request->profile)
    );

    $obj->company()->associate(
      Company::where('razaoSocial',$request->filterCompany)->first()
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

    foreach(explode(",", $request->__features) as $featureId){
      $obj->features()->attach(Feature::find($featureId));
    }

    $obj->save();
    return response()->json(['success'=>true,'data'=>null]);
	}

  public function view($id){
    $check = $this->__view();
    if(!$check['status'])
      return response()->json(['errors' => $check['errors'] ], $check['code']);	

    $query = $query = Job::where('id', $id)->with([
      'profile',
      'degree',
      'company',
      'company'=>function($query){
        $pkg = json_decode(file_get_contents(base_path('composer.json')),true);
        $hasSpatie = array_has($pkg, 'require.spatie/laravel-permission');  
        if($hasSpatie) {
          $query->select('*')
          ->with('roles');
        }else{
          $query->select('*');
        }
      },
      'cboOccupation',
      'salary',
      'pcdType',
      'features',
    ])->get();
				
    return response()->json(['success'=>true,'data'=>$query]);
	}
	
	public function update($id, JobRequest $request){
    $check = $this->__update($request);
    if(!$check['status'])
      return response()->json(['errors' => $check['errors']], $check['code']);	

    $_old = Job::find($id);
    $_old->date_start = $request->date_start;
    $_old->date_end = $request->date_end;
    $_old->interval = $request->interval;
    $_old->gender = $request->gender;
    $_old->apprentice = $request->apprentice;
    $_old->observations = $request->observations;
    $_old->hirer_info = $request->hirer_info;
    
    $_old->cboOccupation()->associate(
      CBOOccupation::where('occupation',$request->cbo)->first()
    );

    $_old->profile()->associate(
      Profile::find($request->profile)
    );

    $_old->company()->associate(
      Company::where('razaoSocial',$request->filterCompany)->first()
    );

    $_old->degree()->associate(
      Degree::find($request->degree)
    );

    $_old->salary()->associate(
      Salary::find($request->salary)
    );

    if($request->pcd != "" && $request->pcd != null){
      $_old->pcdType()->associate(
        PcdType::find($request->pcd)
      );
    } else {
      $_old->pcd_type_id = null;
    }
    foreach ($_old->features as $feature) {
      $_old->features()->detach($feature);
    }

    foreach(explode(",", $request->__features) as $featureId){
      $_old->features()->attach(Feature::find($featureId));
    }

    $_old->save();
    
    return response()->json(['success'=>$_old->save()]);
	}

  public function delete($id){
    $check = $this->__delete();
    if(!$check['status'])
      return response()->json(['errors' => $check['errors'] ], $check['code']);	

    $obj = Job::find($id);
    $obj = $obj->delete();
    return  json_encode(['sts'=>$obj]);
  }

  public function getCompatibleCandidates($jobId){
    $job = Job::where('id', $jobId)->with('features')->first();
    $job->characterSetPoints = $job->getCharacterSetsPoints();
    // dump($job);
    $candidates = Candidate::whereHas('answers')->get();
    foreach ($candidates as $candidate) {
      $candidate->characterSetPoints = $candidate->getCharacterSetsPoints();
    }

    $res = [];

    // dump($this->calculatePercentage($job->characterSetPoints));
    // dump($this->calculatePercentage($candidates[0]->characterSetPoints));
    // dump($this->sameOrder($job->characterSetPoints, $candidates[0]->characterSetPoints));
    foreach ($candidates as $candidate) {
      if($this->sameOrder($job->characterSetPoints, $candidate->characterSetPoints))
        array_push($res, $candidate);
    }

    dump($res);
    // return view('company.candidates', ['candidates' => $candidates]);
  }

  public function calculatePercentage($points) {
    $total = 0;
    foreach ($points as $point) {
      $total += $point;
    }

    $res = [];
    foreach ($points as $key => $value) {
      $res[$key] = (($value / $total) * 100);
    }

    return $res;
  }

  public function sameOrder($a, $b) {
    $keysA = [];
    $keysB = [];
    foreach ($a as $key => $value) {
      array_push($keysA, $key);
    }

    foreach ($b as $key => $value) {
      array_push($keysB, $key);
    }

    for ($i=0; $i < count($keysA); $i++) { 
      if($keysA[$i] != $keysB[$i])
        return false;
    }

    return true;
  }

  // public function orderByPoints($results) {
  //   $bigger = 0;
  //   $res
  //   foreach ($results as $result) {
  //     $sorted = array_values(Arr::sort($array, function ($value) {
  //       return $value['name'];
  //     }));
  //   }
  // }

}
