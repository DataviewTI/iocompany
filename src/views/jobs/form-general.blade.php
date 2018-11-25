@php
  use Dataview\IOCompany\Profile;
  use Dataview\IOCompany\Feature;
  use Dataview\IOCompany\Degree;
  use Dataview\IOCompany\Salary;
  use Dataview\IOCompany\PcdType;
  use Carbon\Carbon;

  $profiles = Profile::select('id','profile')->orderBy('profile')->get();
  $degrees = Degree::select('id','degree')->orderBy('order')->get();
  $salaries = Salary::select('id','salary')->orderBy('order')->get();
  $pcdTypes = PcdType::select('id','title')->orderBy('order')->get();

  $feats = array();
  foreach ($profiles as $profile) {
    array_push($feats, ['profile' => $profile->id, 'features' => Profile::find($profile->id)->features()->get()]);
  }
@endphp

<div class = 'row'>
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
          <label for = 'profile' class="bmd-label-floating __required">Perfil da Vaga</label>
          <select name = 'profile' id = 'profile' class = 'form-control form-control-lg custom-select'>
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
          <select name = 'degree' id = 'degree' class = 'form-control form-control-lg custom-select pr-0'>
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
          <select name = 'gender' id = 'gender' class = 'form-control form-control-lg custom-select'>
            <option value = 'I'>Indiferente</option>
            <option value = 'M'>Masculino</option>
            <option value = 'F'>Feminino</option>
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
          <select name = 'apprentice' id = 'apprentice' class = 'form-control form-control-lg custom-select'>
            <option value = 'S'>Sim</option>
            <option value = 'N' selected>Não</option>
          </select>
        </div>
      </div>
      <div class="col-sm-3 col-xs-12 pl-0">
        <div class="form-group">
          <label for = 'pcd' class="bmd-label-floating __required">PcD</label>
          <select name = 'pcd' id = 'pcd' class = 'form-control form-control-lg custom-select'>
            <option value = ''>Não</option>
            <optgroup label = 'Sim'>
              @foreach ($pcdTypes as $pcdType)
                <option value = '{{ $pcdType->id }}'>{{ $pcdType->title }}</option>
              @endforeach
            </optgroup>
          </select>
        </div>
      </div>
      <div class="col-sm-6 col-xs-12 pr-0">
        <div class="form-group">
          <label for = 'salary' class="bmd-label-floating __required">Valor do salário</label>
          <select name = 'salary' id = 'salary' class = 'form-control form-control-lg custom-select'>
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
        @foreach($feats as $feat)
          <div class="features-group" data-profile-id={{ $feat['profile'] }}>
            @foreach($feat['features'] as $f)
              <button type="button" value = '{{$f->id}}' class="btn btn-outline-danger feature" data-toggle="button" aria-pressed="false" autocomplete="off">
                {{$f->feature}}
              </button>
            @endforeach
          </div>
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
      <textarea class="form-control form-control-lg" id="observations" name = 'observations' style = 'height:60px'></textarea>
    </div>
  </div>
</div>

@section('before_body_close')
  @include('Job::cbo-modal')
@endsection

