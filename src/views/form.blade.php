@php
    use Dataview\IntranetOne\IntranetOneController;
@endphp
<form action = 'company/create' id='default-form' method = 'post' class = 'form-fit'>
    @component('IntranetOne::io.components.wizard',[
      "_id" => "default-wizard",
      "_min_height"=>"435px",
      "_steps"=> [
          ["name" => "Dados Gerais", "view"=> "Company::form-general"],
        ]
    ])
    @endcomponent
  </form>