<div class = 'row'>
    <div class="col-md col-sm-12 pl-1" style = 'border-right:1px #e1f0ee solid'>
      <div class = 'row'>
        <div class="col-6">
          <div class="form-group">
            <label for = 'first_name' class="bmd-label-floating __required">Nome</label>
            <input name = 'first_name' type = 'text' class = 'form-control form-control-lg' />
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label for = 'last_name' class="bmd-label-floating __required">Sobrenome</label>
            <input name = 'last_name' type = 'text' class = 'form-control form-control-lg' />
          </div>
        </div>
      </div>

      <div class = 'row'>
        <div class="col-8">
          <div class="form-group">
            <label for = 'email' class="bmd-label-floating __required">Email</label>
            <input name = 'email' type = 'text' class = 'form-control form-control-lg' />
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label for = 'admin' class="bmd-label-floating __required">Administrador?</label>
            <br>
            <button type="button" class="btn btn-lg aanjulena-btn-toggle btn-lg active"
                    data-toggle="button" aria-pressed="true" 
                    data-default-state='true' autocomplete="off" name = 'admin' id = 'admin'
                    style="margin: 0; margin-left: 40px; margin-top: 10px;">
                <div class="handle"></div>
            </button>
            <input type = 'hidden' name = '__admin' id = '__admin' />
          </div>
        </div>
      </div>

      <div class = 'row'>
        <div class="col-6">
          <div class="form-group">
            <label for = 'password' class="bmd-label-floating __required">Senha</label>
            <input name = 'password' type = 'password' class = 'form-control form-control-lg' />
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label for = 'confirm_password' class="bmd-label-floating __required">Confirme a senha</label>
            <input name = 'confirm_password' type = 'password' class = 'form-control form-control-lg' />
          </div>
        </div>
      </div>
      
    </div>
    <!-- coluna B-->
    @if(Sentinel::inRole('admin'))
      <div class="col-md col-sm-12 pr-1">
    @else
      <div class="col-md col-sm-12 pr-1 d-none">
    @endif
      <h4><i class = ''></i> 
        <span class = 'text-default'><small>Permissões</small></span></h4>
      <hr />
      <div class = 'row'>
        <!--tabela-->
        <div class="col-12">
          @component('IntranetOne::io.components.datatable',[
          "_id" => "permissions_table",
          "_columns"=> [
              ["title" => "Serviço"],
              ["title" => "Criar"],
              ["title" => "Alterar"],
              ["title" => "Excluir"],
              ["title" => "Visualizar"],
            ]
          ])
          @endcomponent
        </div>
      </div>
    </div>
  </div>