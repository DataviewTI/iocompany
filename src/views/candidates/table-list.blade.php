@php
    use Dataview\IOCompany\Profile;
    use Dataview\IOCompany\Feature;
    use Dataview\IOCompany\Degree;
    use Dataview\IOCompany\Salary;
    use Dataview\IOCompany\PcdType;
    use Dataview\IOCompany\MaritalStatusType;
    use Dataview\IOCompany\ChildrenAmount;
    use Carbon\Carbon;

    $profiles = Profile::select('id','profile')->orderBy('profile')->get();
    $degrees = Degree::select('id','degree')->orderBy('order')->get();
    $salaries = Salary::select('id','salary')->orderBy('order')->get();
    $pcdTypes = PcdType::select('id','title')->orderBy('order')->get();
    $maritalStatus = MaritalStatusType::select('id','title')->orderBy('order')->get();
    $childrenAmounts = ChildrenAmount::select('id','title')->orderBy('order')->get();
@endphp

    <div class = 'row dt-filters-container'>
		<div class="col-3">
			<div class="form-group">
                <label for = 'subtitulo' class = 'bmd-label-static'><i class = 'ico ico-filter'></i>Nome</label>
                <input type = 'text' class = 'form-control form-control-lg' name ='name_search' id = 'name_search' />
			</div>
		</div>
		<div class="col-3">
			<div class="form-group">
                <label for = 'subtitulo' class = 'bmd-label-static'><i class = 'ico ico-filter'></i>Sexo</label>
                <select name = 'gender_search' id = 'gender_search' class = 'form-control form-control-lg custom-select'>
                    <option value = ''>&nbsp;</option>
                    <option value = 'M'>Masculino</option>
                    <option value = 'F'>Feminino</option>
                </select>
			</div>
        </div>
		<div class="col-3">
			<div class="form-group">
                <label for = 'subtitulo' class = 'bmd-label-static'><i class = 'ico ico-filter'></i>Dt Nascimento</label>
                <input type = 'text' name = 'birthday_search' id = 'birthday_search' class = 'form-control form-control-lg'>
			</div>
		</div>
		<div class="col-3">
			<div class="form-group">
                <label for = 'subtitulo' class = 'bmd-label-static'><i class = 'ico ico-filter'></i>CPF</label>
                <input type = 'text' class = 'form-control form-control-lg' name ='cpf_search' id = 'cpf_search' />
			</div>
		</div>
  </div>
	@component('IntranetOne::io.components.datatable',[
	"_id" => "candidates-table",
	"_columns"=> [
			["title" => "Id"],
			["title" => "Nome"],
			["title" => "Sexo"],
			["title" => "Dt Nascimento"],
			["title" => "Cpf"],
			// ["title" => "Aprendiz"],
			// ["title" => "PcD"],
			["title" => "Ações"],
		]
	])
@endcomponent
