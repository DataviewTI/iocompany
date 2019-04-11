@php
  use Dataview\IOCompany\Attribute;

  $attributes = Attribute::all();
@endphp

<div class = 'row'>
  <div class="col-md col-sm-12 pl-1" id = 'answers_container' style = 'border-right:1px #e1f0ee solid'>
    <h4>
      Pondere as palavras Abaixo de Acordo com a seguinte pergunta: o que tem a ver com você?
    </h4>
    <h6>1. Não tem a ver</h6>
    <h6>2. Tem pouco a ver</h6>
    <h6>3. Tem a ver</h6>
    <h6>4. Totalmente a ver</h6>
    <hr />
    <div class = 'row'>
      @foreach($attributes as $attribute)
        <div class="col-2">
          <div class="form-group d-flex justify-content-around align-items-center">
            <label for = '{{$attribute->id}}' class="bmd-label-floating __required">{{$attribute->title}}</label>
            <select name = '{{$attribute->id}}' id = '{{$attribute->id}}' style="max-width: 32px!important;" class = 'form-control form-control-lg custom-select pr-0'>
              <option value = '1'>1</option>
              <option value = '2'>2</option>
              <option value = '3'>3</option>
              <option value = '4'>4</option>
            </select>
          </div>
        </div>
      @endforeach
      
    </div>
  </div>
  
</div>

