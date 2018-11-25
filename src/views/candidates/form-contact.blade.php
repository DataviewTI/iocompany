@php
  use Dataview\IOCompany\Profile;
  use Dataview\IOCompany\Feature;
  use Dataview\IOCompany\Degree;
  use Dataview\IOCompany\Salary;
  use Carbon\Carbon;

  $profiles = Profile::select('id','profile')->orderBy('profile')->get();
  $degrees = Degree::select('id','degree')->orderBy('order')->get();
  $salaries = Salary::select('id','salary')->orderBy('order')->get();

  $feats = Profile::find(1)->features()->get();

@endphp

{{-- <div class = 'row'>
  <div class="col-sm-4 col-xs-12 pl-0">
    <div class="form-group">
      <label for = 'filterCompany' class="bmd-label-floating __required">Selecione a empresa que ofertará a vaga</label>
      <input type="text" class="form-control form-control-lg" id="filterCompany" fv-value = "" name = 'filterCompany'>
    </div>
  </div>
  <div class="col-sm-8 col-xs-12">
    <div class = 'row'>
      <div class="col-sm-3 col-xs-12">
        <div class="form-group">
          <label for = 'profile_id' class="bmd-label-floating __required">Perfil da Vaga</label>
          <select name = 'profile_id' id = 'profile_id' class = 'form-control form-control-lg custom-select'>
            <option value = ''></option>
            @foreach($profiles as $p)
              <option value = '{{$p->id}}'>{{$p->profile}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-sm-9 col-xs-12 pr-0">
        <div class="form-group">
          <label for = 'cbo' class="bmd-label-floating __required">Buscar CBO por palavra chave</label>
          <input type="text" class="form-control form-control-lg mr-2" fv-value = "" id="cbo" name = 'cbo'>
        </div>
      </div>
    </div>
  </div>
</div>


<div class = 'row' style = 'height:100px;'>
  <div class="col-sm-4 col-xs-12">
    <div class = 'row'>
      <div class="col-sm-4 col-xs-12 pl-0">
        <div class="form-group">
          <label for = 'date_start' class="bmd-label-floating __required">Data inicial</label>
          <input type="text" class="form-control form-control-lg" id="date_start" name = 'date_start'>
        </div>
      </div>
      <div class="col-sm-4 col-xs-12 pl-0">
        <div class="form-group">
          <label for = 'interval' class="bmd-label-floating __required">Duração da Vaga</label>
          <select name = 'interval' id = 'interval' class = 'form-control form-control-lg custom-select'>
            <option value = '7'>7 dias</option>
            <option value = '15'>15 dias</option>
            <option value = '30' selected>30 dias</option>
            <option value = '45'>45 dias</option>
            <option value = '60'>60 dias</option>
            <option value = '120'>120 dias</option>
          </select>
        </div>
      </div>
      <div class="col-sm-4 col-xs-12 pl-0">
        <div class="form-group">
          <label for = 'date_end' class="bmd-label-floating __required">Data Final</label>
          <input type="text" class="form-control form-control-lg" id="date_end" name = 'date_end' disabled>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4 col-xs-12">
    <div class = 'row'>
      <div class="col-sm-9 col-xs-9">
        <div class="form-group">
          <label for = 'cboa' class="bmd-label-floating __required">Escolaridade Mínima</label>
          <select name = 'degree_id' id = 'degree_id' class = 'form-control form-control-lg custom-select pr-0'>
            <option value = ''>&nbsp;</option>
            @foreach($degrees as $d)
              <option value = '{{$d->id}}'>{{$d->degree}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-sm-3 col-xs-3">
        <div class="form-group">
          <label for = 'cboa' class="bmd-label-floating __required">Sexo</label>
          <select name = 'sex' id = 'sex' class = 'form-control form-control-lg custom-select'>
            <option value = 'I'>&nbsp;</option>
            <option value = 'M'>M</option>
            <option value = 'F'>F</option>
          </select>
        </div>
      </div>
    </div>
  </div>  
  <div class="col-sm-4 col-xs-12">
    <div class = 'row'>
      <div class="col-sm-3 col-xs-12 pl-0">
        <div class="form-group">
          <label for = 'cboa' class="bmd-label-floating __required">Aprendiz</label>
          <select name = 'sexo' id = 'sexo' class = 'form-control form-control-lg custom-select'>
            <option value = 'S'>Sim</option>
            <option value = 'N' selected>Não</option>
          </select>
        </div>
      </div>
      <div class="col-sm-3 col-xs-12 pl-0">
        <div class="form-group">
          <label for = 'pcd' class="bmd-label-floating __required">PCD</label>
          <select name = 'pcd' id = 'pcd' class = 'form-control form-control-lg custom-select'>
            <option value = 'Não'>Não</option>
            <optgroup label = 'Sim'>
              <option value = 'Visual'>Visual</option>
              <option value = 'Auditivo'>Auditivo</option>
              <option value = 'Físico'>Físico</option>
              <option value = 'Mental'>Mental</option>
              <option value = 'Multipla'>Multipla</option>
            </optgroup>
          </select>
        </div>
      </div>
      <div class="col-sm-6 col-xs-12 pr-0">
        <div class="form-group">
          <label for = 'pcd' class="bmd-label-floating __required">Valor do salário</label>
          <select name = 'pcd' id = 'pcd' class = 'form-control form-control-lg custom-select'>
            @foreach($salaries as $s)
              <option value = '{{$s->id}}'>{{$s->salary}}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
  </div>
</div>


<div class = 'row' style = 'min-height:100px;'>
  <div class="col-12 pl-0">
    <div class="form-group">
      <label for = 'company' class="bmd-label-floating __required mb-3">Selecione as características desejadas para esta vaga</label>
      <div class = 'd-flex justify-content-between flex-wrap' id = 'features'>
        @foreach($feats as $f)
          <button type="button" value = '{{$f->id}}' class="btn btn-outline-danger feature" data-toggle="button" aria-pressed="false" autocomplete="off">
            {{$f->feature}}
          </button>
        @endforeach
      </div>
      <input type = 'hidden' name = '__features' id = '__features' value = ''/>
    </div>
  </div>
</div>


<div class = 'row' style = 'min-height:100px;'>
  <div class="col-12 px-0">
    <div class="form-group">
      <label for = 'observations' class="bmd-label-floating __required">Especifique outras características/detalhamento necessários para esta vaga</label>
      <textarea class="form-control form-control-lg" id="observation" name = 'observations' style = 'height:60px'></textarea>
    </div>
  </div>
</div> --}}

@section('before_body_close')
  @include('Job::cbo-modal')
@endsection

