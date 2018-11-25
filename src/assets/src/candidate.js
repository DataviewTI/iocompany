new IOService({
    name: 'candidate',
  },
  function(self){
    //Datatables initialization
    self.dt = $("#candidates-table").DataTable({
      aaSorting:[ [0,"desc" ]],
      ajax: self.path+'/list',
      initComplete:function(){
        let api = this.api();
        $.fn.dataTable.defaults.initComplete(this);
      },
      footerCallback:function(row, data, start, end, display){
      },
      columns: [
        { data: 'id', name: 'id'},
        { data: 'name', name: 'name'},
        { data: 'gender', name: 'gender'},
        { data: 'birthday', name: 'birthday'},
        { data: 'cpf', name: 'cpf'},
        { data: 'apprentice', name: 'apprentice'},
        { data: 'pcd_type', name: 'pcd'},
        { data: 'address_city', name: 'address_city'},
        { data: 'actions', name: 'actions'},
      ],
      columnDefs: [
        {targets:'__dt_id',width: "3%",class:"text-center",searchable: true,orderable:true},
        {targets:'__dt_cpf',width:"10%",searchable: true,orderable:true},
        {targets:'__dt_idade',width:"7%",className:"text-center",orderable:true,
          render:function(data,type,row,y){
            var today = moment();
            var birthday = moment(data);
            return today.diff(birthday, 'years');
          }
        },
        {targets:'__dt_sexo',width:"7%",className:"text-center",orderable:true,
          render:function(data,type,row,y){
            if(data == 'M' || data == 'm')
              return 'Masculino';
            else if (data == 'F' || data == 'f')
              return 'Feminino';
            else 
              return data;
          }
        },
        {targets:'__dt_pcd',width:"7%",className:"text-center",orderable:true,
          render:function(data,type,row,y){
            if(data == null)
              return 'Nenhuma';
            else 
              return data.title;
          }
        },
        {targets:'__dt_aprendiz',width:"7%",className:"text-center",orderable:true,
          render:function(data,type,row,y){
            if(data == 'N' || data == 'n')
              return 'Não';
            else if (data == 'S' || data == 's')
              return 'Sim';
          }
        },
        {targets:'__dt_acoes',width:"7%",className:"text-center",orderable:true,
          render:function(data,type,row,y){
            return self.dt.addDTButtons({
              buttons:[ 
                {ico:'ico-eye',_class:'text-primary',title:'preview'},
                {ico:'ico-edit',_class:'text-info',title:'editar'},
                {ico:'ico-trash',_class:'text-danger',title:'excluir'},
              ]
            });
          }
        }
      ]	
    }).on('click',".btn-dt-button[data-original-title=editar]",function(){
      var data = self.dt.row($(this).parents('tr')).data();
      self.view(data.cnpj);
    }).on('click','.ico-trash',function(){
      var data = self.dt.row($(this).parents('tr')).data();
      self.delete(data.cnpj);
    }).on('click','.ico-eye',function(){
      var data = self.dt.row($(this).parents('tr')).data();
      preview({id:data.cnpj});
    }).on('draw.dt',function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
    
    let form = document.getElementById(self.dfId);
    let fv1 = FormValidation.formValidation(
      form.querySelector('.step-pane[data-step="1"]'),
      {
        fields: {
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

    let fv2 = FormValidation.formValidation(
      form.querySelector('.step-pane[data-step="2"]'),
      {
        fields: {
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

    self.fv = [fv1, fv2];

      
    self.wizardActions(function(){ 
    });    

    self.callbacks.view = view(self);
    self.callbacks.update.onSuccess = ()=>{
    }

    self.callbacks.create.onSuccess = ()=>{
    }

    self.callbacks.unload = self=>{
      $('#xxx').val('');
    }    

    self.tabs.cadastrar.tab.on('show.bs.tab',()=>{
    });
});


function view(self){
  return{
      onSuccess:function(data){
        
        data.id = data.cnpj;

        $('#cnpj').val(data.cnpj);
        document.getElementById('cnpj').setAttribute('disabled','true');

        //self.fv[0].revalidateField('cnpj');
        $('#razaoSocial').val(data.razaoSocial);
        $('#nomeFantasia').val(data.nomeFantasia);
        $('#phone').val(data.phone);
        $('#mobile').val(data.mobile);
        $('#email').val(data.email);
        $('#zipCode').val(data.zipCode);
        $('#numberApto').val(data.numberApto);

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
  $('#features .feature.active').each((i,obj)=>{
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