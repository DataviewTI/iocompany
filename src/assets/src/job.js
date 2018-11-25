new IOService({
    name: 'job',
  },
  function(self){

      $( "select[name='profile']" ).change(function() {
        if($( this ).val() != ""){
          $( '.features-group' ).css('display', 'none');
          $( '.features-group' ).removeClass('active');

          $( '.features-group[data-profile-id='+$( this ).val()+']' ).css('display', 'block');
          $( '.features-group[data-profile-id='+$( this ).val()+']' ).addClass('active');
        } else {
          $( '.features-group' ).css('display', 'none');
          $( '.features-group' ).removeClass('active');
        }
      });

      //colocar o serviceurl do autocomplete para funcionar instead ajax

      console.log('asasa');

      $.ajax({
        url:"company/simplified-list",
        success: function(ret){
          $("#filterCompany").autocomplete({
            maxheight:100,
            minChars:3,
            preserveInput:true,
            lookup: $.map(ret, function(item){
              return { value: item.razaoSocial, data: item.cnpj, nomef:item.nomeFantasia};
            }),
            lookupFilter: function (suggestion, query, queryLowerCase) {
                return suggestion.value.toLowerCase().indexOf(queryLowerCase) > -1 || suggestion.data.indexOf(queryLowerCase) > -1 || suggestion.nomef.toLowerCase().indexOf(queryLowerCase) > -1;
            },
            onSelect:function(sugg,a){
                $(this).val(sugg.value); 
                $(this).attr('fv-value',sugg.data);
                self.fv[0].revalidateField('filterCompany');
            },
            onInvalidateSelection(){
              $(this).attr('fv-value','');
              self.fv[0].revalidateField('filterCompany');
            }
          });
        }
      });

     $("#cbo").autocomplete({
        maxheight:100,
        minChars:3,
        preserveInput:true,
        lookup: $.map($CBO, function(item){
          return { value: item.o, data: item.i};
        }),
        lookupFilter: function (suggestion, query, queryLowerCase) {
            return suggestion.value.toLowerCase().indexOf(queryLowerCase) > -1 || suggestion.data.indexOf(queryLowerCase) > -1;
        },
        onSelect:function(sugg,a){
          $(this).val(sugg.value); 
          $(this).attr('fv-value',sugg.data);
          self.fv[0].revalidateField('cbo');
        },
        onInvalidateSelection(){
          $(this).attr('fv-value','');
          self.fv[0].revalidateField('cbo');
        }
      });
      
      
      $('#cbo-modal').modal({
      show:false,
      keyboard:false,
      backdrop:'static',
    })
    .on('show.bs.modal', function (){
        console.log('há')
    });

    $('#btn-cbo-search').on('click',(e)=>{
      $('#cbo-modal').modal('show');
      e.originalEvent.preventDefault();
    });

    $('#features .feature').attrchange(function(attrName) {
      if(attrName == 'aria-pressed')
        self.fv[0].revalidateField('__features')
    });

    //Datatables initialization
    self.dt = $("#jobs-table").DataTable({
      aaSorting:[[0,"desc" ]],
      ajax: self.path+'/list',
      initComplete:function(){
        let api = this.api();
        $.fn.dataTable.defaults.initComplete(this);
      },
      footerCallback:function(row, data, start, end, display){
      },
      columns: [
        { data: 'id', name: 'id'},
        { data: 'company', name: 'cnpj'},
        { data: 'company', name: 'razaoSocial'},
        { data: 'date_start', name: 'date_start'},
        { data: 'interval', name: 'interval'},
        { data: 'date_end', name: 'date_end'},
        { data: 'degree', name: 'degree'},
        { data: 'profile', name: 'profile'},
        { data: 'gender', name: 'gender'},
        { data: 'apprentice', name: 'apprentice'},
        { data: 'actions', name: 'actions'},
      ],
      columnDefs: [
        {targets:'__dt_id', width: '1%',searchable:true,orderable:true,},
        {targets:'__dt_cnpj',width: '5%', class: 'text-center', searchable:true,orderable:true,
          render:function(data,type,row,y){
            return data.cnpj
          }
        },
        {targets:'__dt_razao-social',searchable:true,orderable:true,
          render:function(data,type,row,y){
            return data.razaoSocial
          }
        },
        {targets:'__dt_dt-inicio', width: '8%', class: 'text-center', searchable:true,orderable:true,},
        {targets:'__dt_intervalo', width: '5%', class: 'text-center', searchable:true,orderable:true,},
        {targets:'__dt_dt-final', width: '8%', class: 'text-center', searchable:true,orderable:true,},
        {targets:'__dt_escolaridade', width: '20%', searchable:true,orderable:true,
          render:function(data,type,row,y){
            return data.degree
          }
        },
        {targets:'__dt_perfil', width: '8%', searchable:true,orderable:true,
          render:function(data,type,row,y){
            return data.profile
          }
        },
        {targets:'__dt_genero', width: '5%', searchable:true,orderable:true,
          render:function(data,type,row,y){
            if(data == 'I'){
              return 'Indiferente'
            } else if (data == 'M'){
              return 'Masculino'
            } else if (data == 'F'){
              return 'Feminino'
            }
          }
        },
        {targets:'__dt_aprendiz', width: '5%', searchable:true,orderable:true,
          render:function(data,type,row,y){
            if(data == 'S'){
              return 'Sim'
            } else if (data == 'N'){
              return 'Não'
            }
          }
        },
        {targets:'__dt_acoes',width:"7%",className:"text-center",searchable:false,orderable:false,
          render:function(data,type,row,y){
            return self.dt.addDTButtons({
              buttons:[
                {ico:'ico-eye',_class:'text-primary',title:'preview'},
                {ico:'ico-edit',_class:'text-info',title:'editar'},
                {ico:'ico-trash',_class:'text-danger',title:'excluir'},
            ]});
          }
        }
      ]	
    }).on('click',".btn-dt-button[data-original-title=editar]",function(){
      var data = self.dt.row($(this).parents('tr')).data();
      self.view(data.id);
    }).on('click','.ico-trash',function(){
      var data = self.dt.row($(this).parents('tr')).data();
      self.delete(data.id);
    }).on('click','.ico-eye',function(){
      var data = self.dt.row($(this).parents('tr')).data();
      preview({id:data.cnpj});
    }).on('draw.dt',function(){
      $('[data-toggle="tooltip"]').tooltip();
    });


      self.fv = [];
      self.fv[0] = FormValidation.formValidation(
        document.getElementById('default-form'),
        {
          fields: {
            filterCompany:{
              validators:{
                callback:{
                  callback:function(obj){
                    let el = $(obj.element);
                      if(!el.val().length)
                        return {
                          valid:false,
                          message:'A empresa demandante é obrigatória'
                        }
                      if(el.attr('fv-value') == '')
                        return {
                          valid:false,
                          message:'Empresa inválida!'
                        }
                        
                      return true;
                    }                    
                }
              }
            },
            'profile':{
              validators:{
                notEmpty: {
                  message: 'Informe o perfil!'
                },
              }
            },
          cbo:{
            validators:{
              callback:{
                callback:function(obj){
                  let el = $(obj.element);
                    if(!el.val().length)
                      return {
                        valid:false,
                        message:'A descrição da vaga (CBO) é obrigatória'
                      }
                    if(el.attr('fv-value') == '')
                      return {
                        valid:false,
                        message:'CBO Inválido!'
                    }
                    return true;
                  }                    
                }
              }
            },
          __features:{
            validators:{
              callback:{
                callback:function(obj){
                  const feats = checkFeatures();

                    if(feats.length < 3){
                      if(feats.length == 0)
                        toastr["error"]("Selecione no mínimo 3 características!");
  
                      return {
                        valid:false,
                        message:'Selecione no mínimo 3 características'
                      }
                    }

                    return true;
                  }                    
                }
              }
            },
            date_start:{
              validators:{
                notEmpty:{
                  message: 'O data inicial é obrigatória'
                },
                date:{
                  format: 'DD/MM/YYYY',
                  message: 'Informe uma data válida!'
                }
              }
            },
            date_end:{
              validators:{
                notEmpty:{
                  message: 'O data final é obrigatória'
                },
                date:{
                  format: 'DD/MM/YYYY',
                  message: 'Informe uma data válida!'
                }
              }
            },
            'degree':{
              validators:{
                notEmpty: {
                  message: 'Informe a escolaridade'
                },
              }
            },
          },
          plugins:{
            trigger: new FormValidation.plugins.Trigger(),
            submitButton: new FormValidation.plugins.SubmitButton(),
            bootstrap: new FormValidation.plugins.Bootstrap(),
            icon: new FormValidation.plugins.Icon({
              valid: 'fv-ico ico-check',
              invalid: 'fv-ico ico-close',
              validating: 'fv-ico ico-gear ico-spin'
            }),
          },
      }).setLocale('pt_BR', FormValidation.locales.pt_BR);

    $('#date_start').pickadate({
      formatSubmit: 'yyyy-mm-dd 00:00:00',
      min: new Date(),
      onClose:function(){
        //$("[name='date_end']").focus();
      }
    }).pickadate('picker').on('set', function(t){

      calcFinalDate();
      self.fv[0].revalidateField('date_start');
    });

    $('#interval').change(()=>{
      console.log(checkFeatures());
      calcFinalDate();
      self.fv[0].revalidateField('date_start');
    })
  
    $('#date_end').pickadate({
      formatSubmit: 'yyyy-mm-dd 00:00:00',
      onClose:function(){
        $("[name='description']").focus();
      }
    }).pickadate('picker').on('render', function(){
      self.fv[0].revalidateField('date_end');
    })    
      
    self.wizardActions(function(){ 
      var feats = checkFeatures();
      $('#__features').val(feats);
    });    

    self.callbacks.view = view(self);
    self.callbacks.update.onSuccess = ()=>{
    }

    self.callbacks.create.onSuccess = ()=>{
    }

    self.callbacks.unload = self=>{
      $('#xxx').val('');
      $( '.features-group' ).css('display', 'none');
      $( '.features-group' ).removeClass('active');

    }    

    self.tabs.cadastrar.tab.on('show.bs.tab',()=>{
    });
});



function view(self){
  return{
    onSuccess:function(data){
      console.log(data);
      
      $('#filterCompany').val(data.company.razaoSocial);

      //self.fv[0].revalidateField('cnpj');
      $('#profile').val(data.profile.id);
      $( '.features-group' ).css('display', 'none');
      $( '.features-group' ).removeClass('active');
      $( '.features-group[data-profile-id='+data.profile.id+']' ).css('display', 'block');
      $( '.features-group[data-profile-id='+data.profile.id+']' ).addClass('active');

      data.features.forEach(function (item) {
        $( '.features-group[data-profile-id='+data.profile.id+'] .feature[value='+item.id+']' ).addClass('active');
        $( '.features-group[data-profile-id='+data.profile.id+'] .feature[value='+item.id+']' ).addClass('focus');
        console.log(item);
      })

      $('#cbo').val(data.cbo_occupation.occupation);
      $("#date_start").pickadate('picker').set('select',new Date(data.date_start));
      $('#interval').val(data.interval);
      $("#date_end").pickadate('picker').set('select',new Date(data.date_end));
      $('#degree').val(data.degree.id);
      $('#gender').val(data.gender);
      $('#apprentice').val(data.apprentice);

      if(data.pcd_type != null){
        $('#pcd').val(data.pcd_type.id);
      }

      $('#salary').val(data.salary.id);
      $('#observations').val(data.observations);

      self.fv[0].validate();

      //não disparar o preenchimento quando for update logo após o view
    }, //sasas
    onError:function(self){
      console.error(self);
    }
  }
}


function checkFeatures(){
  let feats = [];
  $('#features .features-group.active .feature.active').each((i,obj)=>{
    feats.push(obj.getAttribute('value'));
  })

  return feats;
}


function setCEP(data,self){

  const _conf = self.toView;
  
  if(self.toView !== null && $('zipCode').val() == _conf.zipCode){

    if($('address').val() == "" && _conf.address !== ""){
      $('address').val(_conf.address);
    }

    if($('address2').val() == "" && _conf.address2 !== "")
      $('address').val(_conf.address2);
  
    $('city').val(data.localidade);
    $('state').val(data.uf);
    $('address1').focus();
  }
  else{
    if(data!==null){
      if(data.logradouro !==''){
         $('#address').val(`${data.logradouro}${data.complemento!=''? ', '+data.complemento : ''}`);
         $('#address2').val(data.bairro);
         $('#numberApto').focus();
      }
      else
        $('#address').focus();
   
      $('#city').val(data.localidade);
      $('#state').val(data.uf);

      document.getElementById('city').setAttribute('data-ibge',data.ibge);
      document.getElementById('__city').value = data.ibge;
     }
     else{
       $('#address, #address2, #city, #state').val('');
       document.getElementById('city').setAttribute('data-ibge','');
     }
  }

  self.fv[0].revalidateField('address');
  self.fv[0].revalidateField('address2'); 
  self.fv[0].revalidateField('city');
  self.fv[0].revalidateField('numberApto'); 
}

function calcFinalDate(){
  const ini = $('#date_start').pickadate('picker');
  const end = $('#date_end').pickadate('picker');

  end.set('clear');

  if(ini.get('select')!==null){
    const new_date = moment(ini.get('select','yyyy-mm-dd')).add($('#interval').val(),'days');
    end.set('select',new_date.format('YYYY-MM-DD'),{format: 'yyyy-mm-dd'});
  }
}