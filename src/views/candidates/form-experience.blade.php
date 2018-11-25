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

<div class = 'row'>
  <div class="col-md col-sm-12 pl-1" style = 'border-right:1px #e1f0ee solid'>
    <h4><i class = 'ico ico-image text-danger'></i> 
      <span class = 'text-default'><small>Redimensionamento de Imagens</small></span></h4>
    <hr />
    <div class = 'row'>
      <div class="col-md-5 col-sm-12" id = 'dimension_container'>
        <div class = 'row'>
          <div class="col-md-12 col-sm-12">
            <div class="form-group">
              <label for = 'img_prefix' class="bmd-label-static">Prefixo da Imagem</label>
              <input name = 'img_prefix' id = 'img_prefix' type = 'text' maxlength="5" class = 'form-control form-control-lg text-lowercase' />
            </div>
          </div>
        </div>
        <div class = 'row'>
          <div class="col-md-6 col-sm-12">
            <div class="form-group" style = 'position:relative'>
              <label for = 'img_largura' class="bmd-label-static">Largura px</label>
              <input name = 'img_largura' id = 'img_largura' maxlength="4" min='1' max='4000' onkeypress='return event.charCode >= 48 && event.charCode <= 57' type = 'text' class = 'form-control form-control-lg' />
            </div>
          </div>
          <div class="col-md-6 col-sm-12">
            <div class="form-group" style = 'position:relative!important'>
              <label for = 'img_altura' class="bmd-label-static">Altura px</label>
              <input name = 'img_altura' id = 'img_altura' maxlength="4" min='1' max = '4000' onkeypress='return event.charCode >= 48 && event.charCode <= 57' type = 'text' class = 'form-control form-control-lg' />
            </div>
          </div>
        </div>
        <div class = 'row'>
          <div class="col-md-12 col-sm-12 mt-4">
            <div class="form-group">
              <label for = 'img_original' class = 'bmd-label-static'
              style = 'font-size:14px'>Manter Imagem Original?</label>
              <button type="button" class="float-right btn btn-lg aanjulena-btn-toggle btn-sm active"
              data-toggle="button" aria-pressed="true" 
              data-default-state='true' autocomplete="off" name = 'img_original' id = 'img_original'>
                <div class="handle"></div>
              </button>
              <input type = 'hidden' name = '__img_original' id = '__img_original' value='true'/>
            </div>
          </div>
        </div>
        <div class = 'row'>
          <div class="col-md-12 col-sm-12">
              <button type = 'button' id = 'cancel_thumb_edit' class = 'd-none mt-4 btn btn-danger float-left btn-sm'><i class = 'ico ico-close-2'> </i>Cancelar Edição</button>
              <button type = 'button' id = 'add_dimension' class = 'mt-4 btn btn-success float-right btn-sm'><i class = 'ico ico-plus'> </i>Inserir</button>
              <button type = 'button' id = 'thumb_edit' class = 'd-none mt-4 btn btn-info float-right btn-sm'><i class = 'ico ico-check'> </i>Atualizar</button>
          </div>
        </div>
      </div>
      <!--tabela-->
      <div class="col-md-7 col-sm-12">
        @component('IntranetOne::io.components.datatable',[
        "_id" => "__dimensions",
        "_columns"=> [
            ["title" => "Prefixo"],
            ["title" => "Largura"],
            ["title" => "Altura"],
            ["title" => "Ações"],
          ]
        ])
        @endcomponent
      </div>
    </div>
  </div>
  <!-- coluna B-->
  <div class="col-md col-sm-12 pr-1">
    <h4><i class = 'ico ico-image text-danger'></i> 
      <span class = 'text-default'><small>Redimensionamento de Imagens</small></span></h4>
    <hr />
    <div class = 'row'>
      <div class="col-md-5 col-sm-12" id = 'dimension_container'>
        <div class = 'row'>
          <div class="col-md-12 col-sm-12">
            <div class="form-group">
              <label for = 'img_prefix' class="bmd-label-static">Prefixo da Imagem</label>
              <input name = 'img_prefix' id = 'img_prefix' type = 'text' maxlength="5" class = 'form-control form-control-lg text-lowercase' />
            </div>
          </div>
        </div>
        <div class = 'row'>
          <div class="col-md-6 col-sm-12">
            <div class="form-group" style = 'position:relative'>
              <label for = 'img_largura' class="bmd-label-static">Largura px</label>
              <input name = 'img_largura' id = 'img_largura' maxlength="4" min='1' max='4000' onkeypress='return event.charCode >= 48 && event.charCode <= 57' type = 'text' class = 'form-control form-control-lg' />
            </div>
          </div>
          <div class="col-md-6 col-sm-12">
            <div class="form-group" style = 'position:relative!important'>
              <label for = 'img_altura' class="bmd-label-static">Altura px</label>
              <input name = 'img_altura' id = 'img_altura' maxlength="4" min='1' max = '4000' onkeypress='return event.charCode >= 48 && event.charCode <= 57' type = 'text' class = 'form-control form-control-lg' />
            </div>
          </div>
        </div>
        <div class = 'row'>
          <div class="col-md-12 col-sm-12 mt-4">
            <div class="form-group">
              <label for = 'img_original' class = 'bmd-label-static'
              style = 'font-size:14px'>Manter Imagem Original?</label>
              <button type="button" class="float-right btn btn-lg aanjulena-btn-toggle btn-sm active"
              data-toggle="button" aria-pressed="true" 
              data-default-state='true' autocomplete="off" name = 'img_original' id = 'img_original'>
                <div class="handle"></div>
              </button>
              <input type = 'hidden' name = '__img_original' id = '__img_original' value='true'/>
            </div>
          </div>
        </div>
        <div class = 'row'>
          <div class="col-md-12 col-sm-12">
              <button type = 'button' id = 'cancel_thumb_edit' class = 'd-none mt-4 btn btn-danger float-left btn-sm'><i class = 'ico ico-close-2'> </i>Cancelar Edição</button>
              <button type = 'button' id = 'add_dimension' class = 'mt-4 btn btn-success float-right btn-sm'><i class = 'ico ico-plus'> </i>Inserir</button>
              <button type = 'button' id = 'thumb_edit' class = 'd-none mt-4 btn btn-info float-right btn-sm'><i class = 'ico ico-check'> </i>Atualizar</button>
          </div>
        </div>
      </div>
      <!--tabela-->
      <div class="col-md-7 col-sm-12">
        @component('IntranetOne::io.components.datatable',[
        "_id" => "__dimensions",
        "_columns"=> [
            ["title" => "Prefixo"],
            ["title" => "Largura"],
            ["title" => "Altura"],
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

