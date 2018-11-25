	<div class = 'row dt-filters-container'>
		<div class="col-12">
			<div class="form-group">
        <label for = 'subtitulo' class = 'bmd-label-static'><i class = 'ico ico-filter'></i> Palavra Chave</label>
        <input type = 'text' class = 'form-control form-control-lg' name ='cbo-ft_search' id = 'cbo-ft_search' />
			</div>
		</div>
  </div>
	@component('IntranetOne::io.components.datatable',[
	"_id" => "jobs-table",
	"_columns"=> [
			["title" => "Id"],
			["title" => "CNPJ"],
			["title" => "Razão Social"],
			["title" => "Dt Início"],
			["title" => "Intervalo"],
			["title" => "Dt Final"],
			["title" => "Escolaridade"],
			["title" => "Perfil"],
			["title" => "Gênero"],
			["title" => "Aprendiz"],
			["title" => "Ações"],
		]
	])
@endcomponent