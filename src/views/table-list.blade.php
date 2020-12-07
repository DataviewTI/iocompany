<div class = 'row dt-filters-container'>
	<div class="col-12">
		<div class="form-group">
	<label for = 'subtitulo' class = 'bmd-label-static'><i class = 'ico ico-filter'></i> Palavra Chave</label>
	<input type = 'text' class = 'form-control form-control-lg' name ='ft_search' id = 'ft_search' />
		</div>
	</div>
</div>
  @php
	$pkg = json_decode(file_get_contents(base_path('composer.json')),true);
	$hasSpatie = array_has($pkg, 'require.spatie/laravel-permission');
@endphp
@if ($hasSpatie)
	@component('IntranetOne::io.components.datatable',[
		"_id" => "default-table",
		"_columns"=> [
				["title" => "CNPJ"],
				["title" => "Razão Social"],
				["title" => "Nome Fantasia"],
				["title" => "Email"],
				["title" => "Ativo?"],
				["title" => "Ativo até"],
				["title" => "Recrutador?"],
				["title" => "Ações"],
			]
		])
	@endcomponent
@else
	@component('IntranetOne::io.components.datatable',[
		"_id" => "default-table",
		"_columns"=> [
				["title" => "CNPJ"],
				["title" => "Razão Social"],
				["title" => "Nome Fantasia"],
				["title" => "Email"],
				["title" => "Ativo?"],
				["title" => "Ativo até"],
				["title" => "Ações"],
			]
		])
	@endcomponent
@endif
