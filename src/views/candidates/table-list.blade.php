	<div class = 'row dt-filters-container'>
		<div class="col-12">
			<div class="form-group">
        <label for = 'subtitulo' class = 'bmd-label-static'><i class = 'ico ico-filter'></i> Palavra Chave</label>
        <input type = 'text' class = 'form-control form-control-lg' name ='cbo-ft_search' id = 'cbo-ft_search' />
			</div>
		</div>
  </div>
	@component('IntranetOne::io.components.datatable',[
	"_id" => "candidates-table",
	"_columns"=> [
			["title" => "Id"],
			["title" => "Nome"],
			["title" => "Sexo"],
			["title" => "Idade"],
			["title" => "Cpf"],
			["title" => "Aprendiz"],
			["title" => "PcD"],
			["title" => "Ações"],
		]
	])
@endcomponent