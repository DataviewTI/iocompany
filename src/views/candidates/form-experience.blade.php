@php
  use Dataview\IOCompany\Profile;
  use Dataview\IOCompany\Degree;
  use Dataview\IOCompany\GraduationType;
  use Dataview\IOCompany\ResignationReason;
  use Dataview\IOCompany\JobDuration;
  use Carbon\Carbon;

  $profiles = Profile::select('id','profile')->orderBy('profile')->get();
  $degrees = Degree::select('id','degree')->orderBy('order')->get();
  $graduationTypes = GraduationType::select('id','title')->orderBy('order')->get();
  $resignationReasons = ResignationReason::select('id','title')->orderBy('order')->get();
  $jobDurations = JobDuration::select('id','title')->orderBy('order')->get();

@endphp

<div class = 'row'>
  <div class="col-md col-sm-12 pl-1" id = 'graduation_container' style = 'border-right:1px #e1f0ee solid'>
    <h4><i class = 'ico ico-graduation text-danger'></i> 
      <span class = 'text-default'><small>Formação acadêmica</small></span></h4>
    <hr />
    <div class = 'row'>
      <div class="col-12">
        <div class="form-group">
          <label for = 'degree' class="bmd-label-floating __required">Escolaridade</label>
          <select name = 'degree' id = 'degree' class = 'form-control form-control-lg custom-select pr-0'>
            <option value = ''>&nbsp;</option>
            @foreach($degrees as $d)
              <option value = '{{$d->id}}'>{{$d->degree}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-12" id='graduation_form'>
        <input type="hidden" id='graduation_id' name='graduation_id' value=''>
        <div class = 'row'>
          <div class="col-md-6 col-12">
            <div class="form-group">
              <label for = 'graduation_type' class="bmd-label-static">Tipo</label>
              <select name = 'graduation_type' id = 'graduation_type' class = 'form-control form-control-lg custom-select'>
                <option value = ''>&nbsp;</option>
                @foreach($graduationTypes as $graduationType)
                  <option value = '{{$graduationType->id}}'>{{$graduationType->title}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6 col-12">
            <div class="form-group">
              <label for = 'institution' class="bmd-label-static">Instituição</label>
              <input name = 'institution' id = 'institution' type = 'text' class = 'form-control form-control-lg ' />
            </div>
          </div>
        </div>
        <div class = 'row'>
          <div class="col-md-6 col-12">
            <div class="form-group">
              <label for = 'school' class="bmd-label-static">Curso</label>
              <input name = 'school' id = 'school' type = 'text' class = 'form-control form-control-lg ' />
            </div>
          </div>
          <div class="col-md-6 col-12">
            <div class="form-group">
              <label for = 'ending' class="bmd-label-static">Conclusão</label>
              <input name = 'ending' id = 'ending' type = 'text' class = 'form-control form-control-lg ' />
            </div>
          </div>
        </div>
        <div class = 'row'>
          <div class="col-md-12 col-sm-12">
              <button type = 'button' id = 'cancel_thumb_edit' class = 'd-none mt-4 btn btn-danger float-left btn-sm'><i class = 'ico ico-close-2'> </i>Cancelar Edição</button>
              <button type = 'button' id = 'add_graduation' class = 'btn btn-success float-right btn-sm'><i class = 'ico ico-plus'> </i>Inserir</button>
              <button type = 'button' id = 'thumb_edit' class = 'd-none mt-4 btn btn-info float-right btn-sm'><i class = 'ico ico-check'> </i>Atualizar</button>
          </div>
        </div>
        <input type="hidden" name='__graduations' id='__graduations' value=''>
      </div>
      <!--tabela-->
      <div class="col-12">
        @component('IntranetOne::io.components.datatable',[
        "_id" => "__graduations_dt",
        "_class" => "mt-2",
        "_columns"=> [
            ["title" => "Id"],
            ["title" => "graduation type id"],
            ["title" => "Tipo"],
            ["title" => "Instituição"],
            ["title" => "Curso"],
            ["title" => "Conclusão"],
            ["title" => "Ações"],
          ]
        ])
        @endcomponent
      </div>
    </div>
  </div>
  <!-- coluna B-->
  <div class="col-md col-sm-12" id = 'jobs_container' style = 'border-right:1px #e1f0ee solid'>
    <h4><i class = 'ico ico-portfolio text-danger'></i> 
      <span class = 'text-default'><small>Experiência profissional</small></span></h4>
    <hr />
    <div class = 'row'>
      <div class="col-12" id='jobs_form'>
        <input type="hidden" id='job_id' name='job_id' value=''>
        <div class = 'row'>
          <div class="col-md-6 col-12">
            <div class="form-group">
              <label for = 'job_type' class="bmd-label-static">Tipo</label>
              <select name = 'job_type' id = 'job_type' class = 'form-control form-control-lg custom-select'>
                <option value = ''>&nbsp;</option>
                <option value = 'J'>Profissional</option>
                <option value = 'V'>Voluntario</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 col-12">
            <div class="form-group">
              <label for = 'job_duration' class="bmd-label-static">Duração</label>
              <select name = 'job_duration' id = 'job_duration' class = 'form-control form-control-lg custom-select'>
                <option value = ''>&nbsp;</option>
                @foreach($jobDurations as $jobDuration)
                  <option value = '{{ $jobDuration->id }}'>{{$jobDuration->title}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class = 'row'>
          <div class="col-md-6 col-12">
            <div class="form-group">
              <label for = 'company' class="bmd-label-static">Empresa</label>
              <input name = 'company' id = 'company' type = 'text' class = 'form-control form-control-lg ' />
            </div>
          </div>
          <div class="col-md-6 col-12">
            <div class="form-group">
              <label for = 'role' class="bmd-label-static">Cargo</label>
              <input name = 'role' id = 'role' type = 'text' class = 'form-control form-control-lg ' />
            </div>
          </div>
        </div>
        <div class = 'row'>
          <div class="col-12">
            <div class="form-group">
              <label for = 'resignation_reason' class="bmd-label-static">Motivo do desligamento</label>
              <select name = 'resignation_reason' id = 'resignation_reason' class = 'form-control form-control-lg custom-select'>
                <option value = ''>&nbsp;</option>
                <option value = 'N'>Não houve desligamento</option>
                @foreach($resignationReasons as $resignationReason)
                  <option value = '{{ $resignationReason->id }}'>{{$resignationReason->title}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class = 'row'>
          <div class="col-md-12 col-sm-12">
              <button type = 'button' id = 'cancel_thumb_edit' class = 'd-none mt-4 btn btn-danger float-left btn-sm'><i class = 'ico ico-close-2'> </i>Cancelar Edição</button>
              <button type = 'button' id = 'add_job' class = 'btn btn-success float-right btn-sm'><i class = 'ico ico-plus'> </i>Inserir</button>
              <button type = 'button' id = 'thumb_edit' class = 'd-none mt-4 btn btn-info float-right btn-sm'><i class = 'ico ico-check'> </i>Atualizar</button>
          </div>
        </div>
        <input type="hidden" name='__jobs' id='__jobs' value=''>
      </div>
      <!--tabela-->
      <div class="col-12">
        @component('IntranetOne::io.components.datatable',[
        "_id" => "__jobs_dt",
        "_class" => "mt-2",
        "_columns"=> [
            ["title" => "Id"],
            ["title" => "Tipo"],
            ["title" => "Cargo"],
            ["title" => "Empresa"],
            ["title" => "Duração"],
            ["title" => "job type id"],
            ["title" => "job duration id"],
            ["title" => "resignation reason id"],
            ["title" => "Ações"],
          ]
        ])
        @endcomponent
      </div>
    </div>
  </div>
</div>

@section('before_body_close')
  @include('Job::cbo-modal')
@endsection

