new IOService({
    name: 'Company',
},
function (self) {
    $('#open-orders-modal').click(function (e) {
       $('#order-modal').modal('show')
    });

    $('#create-order').click(function (e) {
        e.preventDefault();
        createOrder();
    });

    $('#active').attrchange(function (attrName) {
        if (attrName == 'aria-pressed') {
            $('#__active').val($(this).attr('aria-pressed'));
        }
    });

	$('#due_date').pickadate({
        formatSubmit: 'yyyy-mm-dd 00:00:00',
      }).pickadate('picker').on('set', function (t) {
        self.fv[0].revalidateField('due_date');
    });

    if ($('#recruiter').length) {
        $('#recruiter').attrchange(function (attrName) {
            if (attrName == 'aria-pressed') {
                $('#__recruiter').val($(this).attr('aria-pressed'));
            }
        });
    }

    $('#cnpj').mask('##.###.###/####-##', {
        onComplete: function (val, e, field) {
            $(field).parent().parent().next().find('input').first().focus();
        }
    });

    $('#zipCode').mask('00000-000');

    $('#phone, #mobile').mask($.jMaskGlobals.SPMaskBehavior, {
        onKeyPress: function (val, e, field, options) {
            self.fv[0].revalidateField($(field).attr('id'));
            field.mask($.jMaskGlobals.SPMaskBehavior.apply({}, arguments), options);
        },
        onComplete: function (val, e, field) {
            $(field).parent().parent().next().find('input').first().focus();
        }
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        e.target // newly activated tab
        e.relatedTarget // previous active tab

        if(e.target.attributes.__name.nodeValue == 'pagamentos') {
            loadOrders();
        }
    });

    //Datatables initialization
    let columns = [{
            data: 'cnpj',
            name: 'cnpj'
        },
        {
            data: 'razaoSocial',
            name: 'razaoSocial'
        },
        {
            data: 'nomeFantasia',
            name: 'nomeFantasia'
        },
        {
            data: 'email',
            name: 'email'
        },
        {
            data: 'active',
            name: 'active'
        },
		{
		  data: 'due_date',
		  name: 'due_date'
		},
        {
            data: 'actions',
            name: 'actions'
        },
    ];

    let columnDefs = [{
            targets: '__dt_cnpj',
            width: "3%",
            class: "text-center",
            searchable: true,
            orderable: true
        },
        {
            targets: '__dt_razaosocial',
            searchable: true,
            orderable: true
        },
        {
            targets: '__dt_nomefantasia',
            width: "30%",
            searchable: true,
            orderable: true
        },
        {
            targets: '__dt_ativo',
            width: "7%",
            className: "text-center",
            render: function (data, type, row, y) {
                if (data)
                    return self.dt.addDTIcon({
                        ico: 'ico-check',
                        value: 1,
                        title: 'usuario ativado',
                        pos: 'left',
                        _class: 'text-success'
                    });
                else
                    return self.dt.addDTIcon({
                        value: 0,
                        _class: 'invisible'
                    });
            }

        },
		{
		  targets: '__dt_ativo-ate',
		  width: "7%",
		  className: "text-center",
		  orderable: true,
		  render: function (data, type, row, y) {
			if(data) {
				return moment(data).format('DD/MM/YYYY');
			} else {
				return '';
			}
		  }
		},
        {
            targets: '__dt_acoes',
            width: "7%",
            className: "text-center",
            searchable: false,
            orderable: false,
            render: function (data, type, row, y) {
                return self.dt.addDTButtons({
                    buttons: [{
                            ico: 'ico-eye',
                            _class: 'text-primary',
                            title: 'preview'
                        },
                        {
                            ico: 'ico-edit',
                            _class: 'text-info',
                            title: 'editar'
                        },
                        {
                            ico: 'ico-trash',
                            _class: 'text-danger',
                            title: 'excluir'
                        },
                    ]
                });
            }
        }
    ];

    if ($('th.__dt_recrutador').length > 0) {
        columns.push({
            data: 'recruiter',
            name: 'recruiter'
        });

        columnDefs.push({
            targets: '__dt_recrutador',
            width: "7%",
            className: "text-center",
            render: function (data, type, row, y) {
                var recruiter = null;
                if (row.roles.length > 0)
                    row.roles.forEach(function (item, index) {

                        if (item.name == "recruiter") {
                            recruiter = true;
                        }

                    })
                else
                    return self.dt.addDTIcon({
                        value: 0,
                        _class: 'invisible'
                    });

                if (recruiter)
                    return self.dt.addDTIcon({
                        ico: 'ico-check',
                        value: 1,
                        title: 'usuario ativado',
                        pos: 'left',
                        _class: 'text-success'
                    });
            }

        });
    }

    self.dt = $("#default-table").DataTable({
        aaSorting: [
            [0, "desc"]
        ],
        ajax: self.path + '/list',
        initComplete: function () {
            let api = this.api();
            $.fn.dataTable.defaults.initComplete(this);
        },
        footerCallback: function (row, data, start, end, display) {},
        columns: columns,
        columnDefs: columnDefs
    }).on('click', ".btn-dt-button[data-original-title=editar]", function () {
        var data = self.dt.row($(this).parents('tr')).data();
        self.view(data.cnpj);
    }).on('click', '.ico-trash', function () {
        var data = self.dt.row($(this).parents('tr')).data();
        self.delete(data.cnpj);
    }).on('click', '.ico-eye', function () {
        var data = self.dt.row($(this).parents('tr')).data();
        preview({
            id: data.cnpj
        });
    }).on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    let form = document.getElementById(self.dfId);
    let fv1 = FormValidation.formValidation(
            form.querySelector('.step-pane[data-step="1"]'), {
                fields: {
                    'nomeFantasia': {
                        validators: {
                            notEmpty: {
                                message: 'O Nome Fantasia é obrigatório!'
                            }
                        }
                    },
                    'razaoSocial': {
                        validators: {
                            notEmpty: {
                                message: 'A Razão Social é obrigatória!'
                            }
                        }
                    },
                    'cnpj': {
                        validators: {
                            notEmpty: {
                                message: 'O CNPJ é obrigatório',
                            },
                            vat: {
                                country: 'BR',
                                message: 'cnpj inválido',
                            }
                        }
                    },
                    'due_date': {
                      validators: {
                        notEmpty: {
                          enabled: false,
                          message: 'Informe a data limite!'
                        }
                      }
                    },
                    'phone': {
                        validators: {
                            phone: {
                                country: 'BR',
                                message: 'Telefone Inválido',
                            }
                        }
                    },
                    'mobile': {
                        validators: {
                            phone: {
                                country: 'BR',
                                message: 'Celular Inválido',
                            }
                        }
                    },
                    'email': {
                        validators: {
                            notEmpty: {
                                message: 'O email principal é obrigatório',
                            },
                            emailAddress: {
                                message: 'email Inválido',
                            }
                        }
                    },
                    'zipCode': {
                        validators: {
                            promise: {
                                notEmpty: {
                                    message: 'O Cep é obrigatório'
                                },
                                enabled: true,
                                promise: function (input) {
                                    return new Promise(function (resolve, reject) {
                                        if (input.value.replace(/\D/g, '').length < 8)
                                            resolve({
                                                valid: false,
                                                message: 'Cep Inválido!',
                                                meta: {
                                                    data: null
                                                }
                                            })
                                        else {
                                            delete $.ajaxSettings.headers["X-CSRF-Token"];

                                            $.ajax({
                                                url: `https://viacep.com.br/ws/${$('#zipCode').cleanVal()}/json`,
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    // 'X-CSRF-Token': laravel_token,
                                                },
                                                complete: (jqXHR) => {
                                                    $.ajaxSettings.headers["X-CSRF-Token"] = laravel_token;
                                                },
                                                success: (data) => {
                                                    if (data.erro == true) {
                                                        resolve({
                                                            valid: false,
                                                            message: 'Cep não encontrado!',
                                                            meta: {
                                                                data: null
                                                            }
                                                        });
                                                    } else
                                                        resolve({
                                                            valid: true,
                                                            meta: {
                                                                data
                                                            }
                                                        });
                                                }
                                            });
                                        }
                                    });
                                }
                            }
                        }
                    },
                    'address': {
                        validators: {
                            notEmpty: {
                                message: 'O endereço é obrigatório'
                            },
                        }
                    },
                    'address2': {
                        validators: {
                            notEmpty: {
                                message: 'O bairro é obrigatório'
                            },
                        }
                    },
                    'numberApto': {
                        validators: {
                            notEmpty: {
                                message: 'campo obrigatório'
                            },
                        }
                    },
                    'city': {
                        validators: {
                            notEmpty: {
                                message: 'O bairro é obrigatório'
                            },
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap: new FormValidation.plugins.Bootstrap(),
                    icon: new FormValidation.plugins.Icon({
                        valid: 'fv-ico ico-check',
                        invalid: 'fv-ico ico-close',
                        validating: 'fv-ico ico-gear ico-spin'
                    }),
                },
            }).setLocale('pt_BR', FormValidation.locales.pt_BR)
        .on('core.validator.validated', function (e) {
            if (e.field === 'zipCode' && e.validator === 'promise') {
                setCEP(e.result.meta.data, self);
            }
        });

    self.fv = [fv1];

    self.wizardActions(function () {
        document.getElementById('cnpj').removeAttribute('disabled');
    });

    self.callbacks.view = view(self);
    self.callbacks.update.onSuccess = () => {
        document.getElementById('cnpj').setAttribute('disabled', 'true');
        swal({
            title: "Sucesso",
            text: "Configurações atualizadas com sucesso!",
            type: "success",
            confirmButtonText: 'OK',
            onClose: function () {
                self.unload(self);
                location.reload();
            }
        });
    }
    self.callbacks.update.onError = () => {
        document.getElementById('cnpj').setAttribute('disabled', 'true');
    }

    self.callbacks.create.onSuccess = (data) => {}

    self.callbacks.unload = self => {
        $(".aanjulena-btn-toggle").aaDefaultState();
        $('#cnpj, #nomeFantasia, #razaoSocial, #phone1, #mobile1, #email,#odin-address, #address2, #city, #state', '#numberApto').val('');
    }

    self.tabs.cadastrar.tab.on('show.bs.tab', () => {
        document.getElementById('cnpj').focus();
    });

});

function loadOrders() {
    $.ajax({
        url: '/admin/orders/sync-payments',
        method: 'GET',
        beforeSend: function(){
            HoldOn.open({message:"Carregando pagamentos, aguarde...",theme:'sk-bounce'});
        },
        complete: (data) => {
        },
        success: (data) => {
            self.ordersDt = $('#orders-table').DataTable({
                aaSorting:[[0,"desc"]],
                ajax: '/admin/orders/list',
                initComplete:function(settings, json){
                    HoldOn.close();
                },
                footerCallback:function(row, data, start, end, display){
                },
                columns: [
                    { data: 'id', name: 'id'},
                    { data: 'company', name: 'company'},
                    { data: 'company', name: 'company'},
                    { data: 'company', name: 'company'},
                    { data: 'plan', name: 'plan'},
                    { data: 'wirecard_data', name: 'wirecard_data'},
                    { data: 'wirecard_data', name: 'wirecard_data'},
                    { data: 'wirecard_data', name: 'wirecard_data'},
                    { data: "actions",  name: "actions" }
                ],
                columnDefs:
                [
                    {
                        targets: "__dt_cnpj",
                        render: function (data, type, row, y) {
                            return data.cnpj
                        }
                    },
                    {
                        targets: "__dt_razao-social",
                        render: function (data, type, row, y) {
                            return data.razaoSocial
                        }
                    },
                    {
                        targets: "__dt_email",
                        render: function (data, type, row, y) {
                            return data.email
                        }
                    },
                    {
                        targets: "__dt_plano",
                        render: function (data, type, row, y) {
                            return data.name
                        }
                    },
                    {
                        targets: "__dt_valor",
                        render: function (data, type, row, y) {
                            if(data) {
                                var size = data.amount.total.length
                                return [data.amount.total.slice(0, size-2), '.', data.amount.total.slice(size-2)].join('')
                            }

                            return '';
                        }
                    },
                    {
                        targets: "__dt_status",
                        render: function (data, type, row, y) {
                            if(data) {
                                if(data.status == 'PAID')
                                    return 'Pago'

                                if(data.status == 'REVERTED')
                                    return 'Devolvido'

                                return 'Aguardando pagamento'
                            }

                            return '';
                        }
                    },
                    {
                        targets: "__dt_dt-pagamento",
                        render: function (data, type, row, y) {
                            if(data) {
                                if(data.status == 'PAID'){
                                    let date;
                                    data.events.forEach(event => {
                                        if(event.type == 'PAYMENT.AUTHORIZED') {
                                            date = event.createdAt
                                        }
                                    });

                                    date = new Date(date)
                                    return (date.getDate() < 10 ? ('0'+date.getDate()) : date.getDate())  + '/'
                                        + (date.getMonth() < 9 ? ('0'+(date.getMonth()+1)) : (date.getMonth()+1))  + '/'
                                        + date.getFullYear()
                                }

                                return ''
                            }

                            return '';
                        }
                    },
                    {
                        targets:'__dt_acoes',width:"7%",className:"text-center",searchable:false,orderable:false,render:function(data,type,row,y){
                            if(row.wirecard_data) {
                                if(row.wirecard_data.status != 'PAID') {
                                    return self.ordersDt.addDTButtons({
                                        buttons:[
                                            {ico:'ico-mail',_class: 'text-success',title:'Reenviar email para pagamento'},
                                            {ico:'ico-trash',_class:'text-danger',title:'Excluir'},
                                        ]});
                                }

                                return ''
                            }

                            return '';
                        }
                    },
                ]
            }).on('click','.ico-mail',function(){
                var data = self.ordersDt.row($(this).parents('tr')).data();

                $.ajax({
                    url: '/admin/orders/send-email/'+data.id,
                    method: 'GET',
                    beforeSend: function(){
                        // HoldOn.open({message:"Enviando email, aguarde...",theme:'sk-bounce'});
                    },
                    success: function(data){
                    HoldOn.close();
                    if(data.success)
                    {
                        swal({
                        title:"Um email para pagamento foi enviado para "+data.order.company.email,
                        confirmButtonText:'OK',
                        type:"success",
                        });
                    }else{
                        swal({
                        title:"Não foi possível enviar o email para pagamento. Verifique se o email cadastrado está correto",
                        confirmButtonText:'OK',
                        type:"error",
                        });
                    }
                    },
                    error:function(ret){
                    self.defaults.ajax.onError(ret,self.callbacks.create.onError);
                    }
                });//end ajax

            }).on('click','.ico-trash',function(){
                // var data = self.ordersDt.row($(this).parents('tr')).data();
                // self.delete(data.id);
            });

        },
        error: (err) => {
            swal({
                title:"Não foi possível completar a operação",
                confirmButtonText:'OK',
                type:"error",
            });

            console.log('err', err);
        }
    });
}

function createOrder() {
    let formData = $('#order-form').serializeArray()

    console.log(formData);

    let company;
    let plan;
    let maxPortions = 1
    let creditCard = false
    let boleto = false

    formData.forEach(element => {
        if(element.name == 'company')
            company = JSON.parse(element.value)

        if(element.name == 'plan')
            plan = JSON.parse(element.value)

        if(element.name == 'max_portions')
            maxPortions = element.value

        if(element.name == 'credit_card')
            creditCard = true

        if(element.name == 'boleto')
            boleto = true
    });

    console.log(company);
    console.log(plan);

    let data = {
        company: company,
        plan: plan,
        max_portions: maxPortions,
        plan: plan,
        credit_card: creditCard,
        boleto: boleto,
    }

    $.ajax({
        url: '/admin/orders/store',
        method: 'POST',
        data: data,
        beforeSend: function() {
          HoldOn.open({message:"Criando pagamento, aguarde...",theme:'sk-bounce'});
        },
        complete: (data) => {
        },
        success: (data) => {
            $('#order-modal').modal('hide');
            HoldOn.close();
            swal({
                title:"Pagamento criado com sucesso!",
                title:"O cliente receberá um email com o link para prosseguir com o pagamento",
                confirmButtonText:'OK',
                type:"success",
              });
        },
        error: (err) => {
            $('#order-modal').modal('hide');
            HoldOn.close();
            swal({
                title:"Não foi possível completar a operação",
                confirmButtonText:'OK',
                type:"error",
            });

            console.log('err', err);
        },
    });
}

function view(self) {
    return {
        onSuccess: function (data) {
            data.id = data.cnpj;

            $('#cnpj').val(data.cnpj);
            document.getElementById('cnpj').setAttribute('disabled', 'true');

            $('#razaoSocial').val(data.razaoSocial);
            $('#nomeFantasia').val(data.nomeFantasia);
            $('#phone').val(data.phone);
            $('#mobile').val(data.mobile);
            $('#email').val(data.email);
            $('#zipCode').val(data.zipCode);
            $('#numberApto').val(data.numberApto);

	        $("#due_date").pickadate('picker').set('select', new Date(data.due_date));

            $("#active").aaToggle(data.active == 0 ? false : true);
            $("#recruiter").aaToggle(function (data) {
                let ret = false;
                data.roles.forEach(function (item, index, array) {
                    if (item.name == 'recruiter')
                        ret = true;
                });

                return ret;
            }(data));

            self.fv[0].validate();

            //não disparar o preenchimento quando for update logo após o view
        }, //sasas
        onError: function (self) {
            console.error(self);
        }
    }
}



function setCEP(data, self) {

const _conf = self.toView;

if (self.toView !== null && $('zipCode').val() == _conf.zipCode) {

    if ($('address').val() == "" && _conf.address !== "") {
        $('address').val(_conf.address);
    }

    if ($('address2').val() == "" && _conf.address2 !== "")
        $('address').val(_conf.address2);

    $('city').val(data.localidade);
    $('state').val(data.uf);
    $('address1').focus();
} else {
    if (data !== null) {
        if (data.logradouro !== '') {
            $('#address').val(`${data.logradouro}${data.complemento!=''? ', '+data.complemento : ''}`);
            $('#address2').val(data.bairro);
            $('#numberApto').focus();
        } else
            $('#address').focus();

        $('#city').val(data.localidade);
        $('#state').val(data.uf);

        document.getElementById('city').setAttribute('data-ibge', data.ibge);
        document.getElementById('__city').value = data.ibge;
    } else {
        $('#address, #address2, #city, #state').val('');
        document.getElementById('city').setAttribute('data-ibge', '');
    }
}

self.fv[0].revalidateField('address');
self.fv[0].revalidateField('address2');
self.fv[0].revalidateField('city');
self.fv[0].revalidateField('numberApto');
}
