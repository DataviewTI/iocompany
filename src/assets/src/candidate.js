new IOService({
	name: 'candidate',
  },
  function (self) {
	$('#cpf').mask('###.###.###-##');

	$('#zipCode').mask('00000-000');

	$('#birthday').pickadate({
	  formatSubmit: 'yyyy-mm-dd 00:00:00',
	}).pickadate('picker').on('set', function (t) {
	  self.fv[0].revalidateField('birthday');
	});

	$('#other_gender').attr('disabled', true);
	$('input[name=gender]').change(function () {
	  if ($(this).val() == "Outros") {
		$('#other_gender').removeAttr('disabled');
		self.fv[0].enableValidator('other_gender', 'notEmpty');
	  } else {
		$('#other_gender').attr('disabled', true);
		self.fv[0].disableValidator('other_gender', 'notEmpty');
	  }
	});

	$('#add_graduation').on("click", function (e) {
	  e.preventDefault();
	  self.graduationsFv.validate().then(function (status) {
		if (status === 'Valid')
		  addGraduation({
			self: self,
			graduation_id: $('#graduation_id').val(),
			graduation_type_id: $('#graduation_type').val(),
			graduation_type_title: $('#graduation_type option:selected').text(),
			institution: $('#institution').val(),
			school: $('#school').val(),
			ending: $('#ending').val(),
		  })
	  });
	});

	$('#add_job').on("click", function (e) {
	  console.log('teste');

	  e.preventDefault();
	  self.jobsFv.validate().then(function (status) {
		if (status === 'Valid')
		  addJob({
			self: self,
			job_id: $('#job_id').val(),
			job_type: $('#job_type').val(),
			job_type_title: $('#job_type option:selected').text(),
			job_duration_id: $('#job_duration').val(),
			job_duration_title: $('#job_duration option:selected').text(),
			resignation_reason_id: $('#resignation_reason').val(),
			resignation_reason_title: $('#resignation_reason option:selected').text(),
			company: $('#company').val(),
			role: $('#role').val(),
		  })
	  });
	});

	$('#graduation_form').css("opacity", "0.5");
	$("#graduation_form input").each(function (index) {
	  $(this).attr('disabled', true);
	});

	$('#degree').change(function () {
	  if ($(this).find('option:selected').text() == "Ensino superior Completo" ||
		$(this).find('option:selected').text() == "Ensino Superior Completo"
	  ) {
		$('#graduation_form').css("opacity", "1");
		$("#graduation_form input").each(function (index) {
		  $(this).removeAttr('disabled');
		});
	  } else {
		$('#graduation_form').css("opacity", "0.5");
		$("#graduation_form input").each(function (index) {
		  $(this).attr('disabled', true);
		});
	  }

	});

	$("#jobs_form select#resignation_reason, #jobs_form label[for=resignation_reason]").each(function (index) {
	  $(this).css("opacity", "0.5");
	  $(this).attr('disabled', true);
	});

	$('#job_type').change(function () {

	  if ($(this).val() == "J") {
		$("#jobs_form select#resignation_reason, #jobs_form label[for=resignation_reason]").each(function (index) {
		  $(this).css("opacity", "1");
		  $(this).removeAttr('disabled');
		});
		self.jobsFv.enableValidator('resignation_reason', 'notEmpty');
	  } else {
		$("#jobs_form select#resignation_reason, #jobs_form label[for=resignation_reason]").each(function (index) {
		  $(this).css("opacity", "0.5");
		  $(this).attr('disabled', true);
		});
		self.jobsFv.disableValidator('resignation_reason', 'notEmpty');
	  }

	});

	//Datatables initialization
	self.dt = $("#candidates-table").DataTable({
        serverSide: true,
	  aaSorting: [
		[0, "desc"]
	  ],
	  ajax: self.path + '/list',
	  initComplete: function () {
		let api = this.api();
		$.fn.dataTable.defaults.initComplete(this);
	  },
	  footerCallback: function (row, data, start, end, display) {},
	  columns: [{
		  data: 'id',
		  name: 'id'
		},
		{
		  data: 'name',
		  name: 'name'
		},
		{
		  data: 'gender',
		  name: 'gender'
		},
		{
		  data: 'birthday',
		  name: 'birthday'
		},
		{
		  data: 'cpf',
		  name: 'cpf'
		},
		{
		  data: 'apprentice',
		  name: 'apprentice'
		},
		{
		  data: 'pcd_type',
		  name: 'pcd'
		},
		{
		  data: 'actions',
		  name: 'actions'
		},
	  ],
	  columnDefs: [{
		  targets: '__dt_id',
		  width: "3%",
		  class: "text-center",
		  searchable: true,
		  orderable: true
		},
		{
		  targets: '__dt_cpf',
		  width: "10%",
		  searchable: true,
		  orderable: true
		},
		{
		  targets: '__dt_idade',
		  width: "7%",
		  className: "text-center",
		  orderable: true,
		  render: function (data, type, row, y) {
			if(data) {
				var today = moment();
				var birthday = moment(data);
				return today.diff(birthday, 'years');
			} else {
				return '';
			}
		  }
		},
		{
		  targets: '__dt_sexo',
		  width: "7%",
		  className: "text-center",
		  orderable: true,
		  render: function (data, type, row, y) {
			if (data == 'M' || data == 'm')
			  return 'Masculino';
			else if (data == 'F' || data == 'f')
			  return 'Feminino';
			else
			  return data;
		  }
		},
		{
		  targets: '__dt_pcd',
		  width: "7%",
		  className: "text-center",
		  orderable: true,
		  render: function (data, type, row, y) {
			if (data == null)
			  return 'Nenhuma';
			else
			  return data.title;
		  }
		},
		{
		  targets: '__dt_aprendiz',
		  width: "7%",
		  className: "text-center",
		  orderable: true,
		  render: function (data, type, row, y) {
			if (data == 'N' || data == 'n')
			  return 'Não';
			else if (data == 'S' || data == 's')
			  return 'Sim';
		  }
		},
		{
		  targets: '__dt_acoes',
		  width: "7%",
		  className: "text-center",
		  orderable: true,
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
	  ]
	}).on('click', ".btn-dt-button[data-original-title=editar]", function () {
	  var data = self.dt.row($(this).parents('tr')).data();
	  self.view(data.id);
	}).on('click', '.ico-trash', function () {
	  var data = self.dt.row($(this).parents('tr')).data();
	  self.delete(data.id);
	}).on('click', '.ico-eye', function () {
	  var data = self.dt.row($(this).parents('tr')).data();
	  preview(data);
	}).on('draw.dt', function () {
	  $('[data-toggle="tooltip"]').tooltip();
    })
    .on('processing.dt', function ( e, settings, processing ) {
        if(processing) {
            HoldOn.open({message:"Carregando dados, aguarde...",theme:'sk-bounce'});
        } else {
            HoldOn.close();
        }
    });

	let form = document.getElementById(self.dfId);
	let fv1 = FormValidation.formValidation(
		form.querySelector('.step-pane[data-step="1"]'), {
		  fields: {
			'name': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe o seu nome!'
				}
			  }
			},
			'birthday': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe a sua data de nascimento!'
				}
			  }
			},
			'cpf': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe o CPF!'
				},
				id: {
				  country: 'BR',
				  message: 'CPF inválido',
				}
			  }
			},
			'rg': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe o RG!'
				}
			  }
			},
			'cnh': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe o CNH!'
				}
			  }
			},
			'marital_status': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe o estado civil!'
				}
			  }
			},
			'children_amount': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe o número de filhos!'
				}
			  }
			},
			'phone': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe o telefone!'
				}
			  }
			},
			'mobile': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe o celular!'
				}
			  }
			},
			'email': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe o email!'
				}
			  }
			},
			'address_street': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe o endereço completo!'
				}
			  }
			},
			'address_district': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe o endereço completo!'
				}
			  }
			},
			'address_number': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe o endereço completo!'
				}
			  }
			},
			'address_city': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe o endereço completo!'
				}
			  }
			},
			'address_state': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe o endereço completo!'
				}
			  }
			},
			'gender': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe o sexo!'
				}
			  }
			},
			'other_gender': {
			  validators: {
				notEmpty: {
				  enabled: false,
				  message: 'Informe o sexo!'
				}
			  }
			},
			'salary': {
			  validators: {
				notEmpty: {
				  enabled: true,
				  message: 'Informe a pretensão salarial!'
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
							} else {
							  resolve({
								valid: true,
								meta: {
								  data
								}
							  });
							}
						  },
						  error: (data) => {
							console.log('erro');
						  }
						});
					  }
					});
				  }
				}
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

	let fv2 = FormValidation.formValidation(
	  form.querySelector('.step-pane[data-step="2"]'), {
		fields: {
		  'degree': {
			validators: {
			  notEmpty: {
				enabled: true,
				message: 'Informe sua escolaridade!'
			  }
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
	  }).setLocale('pt_BR', FormValidation.locales.pt_BR);

	  let fv3 = FormValidation.formValidation(
		form.querySelector('.step-pane[data-step="3"]'), {
		  fields: {
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
		}).setLocale('pt_BR', FormValidation.locales.pt_BR);


	self.fv = [fv1, fv2, fv3];

	self.graduations_dt = $('#__graduations_dt').DataTable({
		"paging": false,
		"info": false,
		"ordering": false,
		"initComplete": function () {},
		columnDefs: [{
			targets: '__dt_id',
			visible: false,
		  },
		  {
			targets: '__dt_graduation-type-id',
			visible: false,
		  },
		  {
			targets: '__dt_acoes',
			width: "10%",
			className: "text-center",
			searchable: false,
			orderable: false,
			render: function (data, type, row, y) {
			  return self.graduations_dt.addDTButtons({
				buttons: [{
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
		]
	  })
	  .on('click', '.ico-trash', function () {
		self.graduations_dt.row($(this).parents('tr')).remove().draw();
	  })
	  .on('click', '.ico-edit', function () {
		var data = self.graduations_dt.row($(this).parents('tr')).data();
		$('#graduation_id').val(data[0]);
		$('#graduation_type').val(data[1]);
		$('#institution').val(data[3]);
		$('#school').val(data[4]);
		$('#ending').val(data[5]);
	  });

	self.graduationsFv = FormValidation.formValidation(
	  form.querySelector('#graduation_form'), {
		fields: {
		  graduation_type: {
			validators: {
			  notEmpty: {
				enabled: true,
				message: 'Informe o tipo de graduação!'
			  }
			}
		  },
		  institution: {
			validators: {
			  notEmpty: {
				enabled: true,
				message: 'Informe a instituição de ensino!'
			  }
			}
		  },
		  school: {
			validators: {
			  notEmpty: {
				enabled: true,
				message: 'Informe o curso!'
			  }
			}
		  },
		  ending: {
			validators: {
			  digits: {
				enabled: true,
				message: 'Informe apenas números!'
			  },
			  stringLength: {
				enabled: true,
				min: 4,
				max: 4,
				message: 'Informe um ano válido!'
			  },
			  between: {
				min: 1901,
				max: 2155,
				message: 'Informe um ano válido!',
			  },
			  notEmpty: {
				enabled: true,
				message: 'Informe a data de conclusão! '
			  }
			}
		  },
		},
		plugins: {
		  trigger: new FormValidation.plugins.Trigger(),
		  submitButton: new FormValidation.plugins.SubmitButton(),
		  // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
		  bootstrap: new FormValidation.plugins.Bootstrap(),
		  icon: new FormValidation.plugins.Icon({
			valid: 'fv-ico ico-check',
			invalid: 'fv-ico ico-close',
			validating: 'fv-ico ico-gear ico-spin'
		  }),
		},
	  }).setLocale('pt_BR', FormValidation.locales.pt_BR);

	self.jobs_dt = $('#__jobs_dt').DataTable({
		"paging": false,
		"info": false,
		"ordering": false,
		"initComplete": function () {},
		columnDefs: [{
			targets: '__dt_id',
			visible: false,
		  },
		  {
			targets: '__dt_job-type',
			visible: false,
		  },
		  {
			targets: '__dt_job-duration-id',
			visible: false,
		  },
		  {
			targets: '__dt_resignation-reason-id',
			visible: false,
		  },
		  {
			targets: '__dt_acoes',
			width: "10%",
			className: "text-center",
			searchable: false,
			orderable: false,
			render: function (data, type, row, y) {
			  return self.graduations_dt.addDTButtons({
				buttons: [{
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
		]
	  })
	  .on('click', '.ico-trash', function () {
		self.jobs_dt.row($(this).parents('tr')).remove().draw();
	  })
	  .on('click', '.ico-edit', function () {
		var data = self.jobs_dt.row($(this).parents('tr')).data();
		$('#job_id').val(data[0]);
		$('#role').val(data[2]);
		$('#company').val(data[3]);
		$('#job_type').val(data[5]);
		$('#job_type').change();
		$('#job_duration').val(data[6]);
		$('#resignation_reason').val(data[7]);

	  });

	self.jobsFv = FormValidation.formValidation(
	  form.querySelector('#jobs_form'), {
		fields: {
		  job_type: {
			validators: {
			  notEmpty: {
				enabled: true,
				message: 'Informe o tipo de trabalho!'
			  }
			}
		  },
		  job_duration: {
			validators: {
			  notEmpty: {
				enabled: true,
				message: 'Informe a duração do trabalho!'
			  }
			}
		  },
		  resignation_reason: {
			validators: {
			  notEmpty: {
				enabled: true,
				message: 'Informe o motivo do desligamento!'
			  }
			}
		  },
		  company: {
			validators: {
			  notEmpty: {
				enabled: true,
				message: 'Informe o nome da empresa!'
			  }
			}
		  },
		  role: {
			validators: {
			  notEmpty: {
				enabled: true,
				message: 'Informe o cargo ocupado!'
			  }
			}
		  },
		},
		plugins: {
		  trigger: new FormValidation.plugins.Trigger(),
		  submitButton: new FormValidation.plugins.SubmitButton(),
		  // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
		  bootstrap: new FormValidation.plugins.Bootstrap(),
		  icon: new FormValidation.plugins.Icon({
			valid: 'fv-ico ico-check',
			invalid: 'fv-ico ico-close',
			validating: 'fv-ico ico-gear ico-spin'
		  }),
		},
	  }).setLocale('pt_BR', FormValidation.locales.pt_BR);

	self.wizardActions(function (graduations_dt = self.graduations_dt, jobs_dt = self.jobs_dt) {
	  $('#__graduations').val(JSON.stringify(getGraduations(graduations_dt)))
	  $('#__jobs').val(JSON.stringify(getJobs(jobs_dt)))

	  $('#__state').val($('#address_state').val());
	});

	self.callbacks.view = view(self);
	self.callbacks.update.onSuccess = () => {}

	self.callbacks.create.onSuccess = () => {}

	self.callbacks.unload = self => {
	  $('#graduation_id').val('');
	  $('#graduation_type').val('');
	  $('#institution').val('');
	  $('#school').val('');
	  $('#ending').val('');

	  $('#job_id').val('');
	  $('#job_type').val('');
	  $('#job_duration').val('');
	  $('#resignation_reason').val('');
	  $('#company').val('');
	  $('#role').val('');
	}

	self.tabs.cadastrar.tab.on('show.bs.tab', () => {});
  });

function addGraduation(p) {
  if (p.graduation_id == '') {
	p.self.graduations_dt.row.add([
	  null,
	  p.graduation_type_id,
	  p.graduation_type_title,
	  p.institution,
	  p.school,
	  p.ending,
	  null
	]).draw(true);
  } else {
	var data = [
	  p.graduation_id,
	  p.graduation_type_id,
	  p.graduation_type_title,
	  p.institution,
	  p.school,
	  p.ending,
	  null
	];
	// check if there's any row in the table with the same graduation_id
	var row = null;
	p.self.graduations_dt.rows().data().toArray().forEach((element, index, array) => {
	  if (element[0] == p.graduation_id)
		row = p.self.graduations_dt.row(index);
	})

	if (row != null) {
	  row.data(data).draw(true);
	} else {
	  p.self.graduations_dt.row.add(data).draw(true);
	}
  }

  $('#graduation_id').val('');
  $('#graduation_type').val('');
  $('#institution').val('');
  $('#school').val('');
  $('#ending').val('');
  p.self.graduationsFv.updateFieldStatus('graduation_type', 'NotValidated');
  p.self.graduationsFv.updateFieldStatus('institution', 'NotValidated');
  p.self.graduationsFv.updateFieldStatus('school', 'NotValidated');
  p.self.graduationsFv.updateFieldStatus('ending', 'NotValidated');
}

function getGraduations(dt) {
  let graduations = [];
  dt.data().each(function (row) {
	graduations.push({
	  id: row[0],
	  graduation_type_id: row[1],
	  graduation_type_title: row[2],
	  institution: row[3],
	  school: row[4],
	  ending: row[5],
	})
  });

  return graduations;
}

function addJob(p) {
  if (p.job_id == '') {
	p.self.jobs_dt.row.add([
	  null,
	  p.job_type_title,
	  p.role,
	  p.company,
	  p.job_duration_title,

	  p.job_type,
	  p.job_duration_id,
	  p.resignation_reason_id,
	  null
	]).draw(true);
  } else {
	var data = [
	  p.job_id,
	  p.job_type_title,
	  p.role,
	  p.company,
	  p.job_duration_title,

	  p.job_type,
	  p.job_duration_id,
	  p.resignation_reason_id,
	  null
	];
	// check if there's any row in the table with the same job_id
	var row = null;
	p.self.jobs_dt.rows().data().toArray().forEach((element, index, array) => {
	  if (element[0] == p.job_id)
		row = p.self.jobs_dt.row(index);
	})

	if (row != null) {
	  row.data(data).draw(true);
	} else {
	  p.self.jobs_dt.row.add(data).draw(true);
	}

  }

  $('#job_id').val('');
  $('#job_type').val('');
  $('#job_duration').val('');
  $('#resignation_reason').val('');
  $('#company').val('');
  $('#role').val('');
  p.self.jobsFv.updateFieldStatus('job_type', 'NotValidated');
  p.self.jobsFv.updateFieldStatus('job_duration', 'NotValidated');
  p.self.jobsFv.updateFieldStatus('resignation_reason', 'NotValidated');
  p.self.jobsFv.updateFieldStatus('company', 'NotValidated');
  p.self.jobsFv.updateFieldStatus('role', 'NotValidated');
}

function getJobs(dt) {
  let jobs = [];
  dt.data().each(function (row) {
	console.log(row);
	jobs.push({
	  id: row[0],
	  job_type_title: row[1],
	  role: row[2],
	  company: row[3],
	  job_duration_title: row[4],
	  job_type: row[5],
	  job_duration_id: row[6],
	  resignation_reason_id: row[7],
	})
  });

  return jobs;
}

function view(self) {
  return {
	onSuccess: function (data) {
	  console.log(data);

	  $('#name').val(data.name);
	  $('#social_name').val(data.social_name);
	  $('#cpf').val(data.cpf);
	  $('#cnh').val(data.cnh);
	  $('#rg').val(data.rg);
	  $('#email').val(data.email);
	  $('#phone').val(data.phone);
	  $('#mobile').val(data.mobile);

	  if (data.gender == 'Masculino' || data.gender == 'Feminino')
		$('input[name="gender"][value="' + data.gender + '"]').prop("checked", true);
	  else {
		$('input[name="gender"][value="Outros"]').prop("checked", true);
		$('#other_gender').val(data.gender);
		$('#other_gender').removeAttr('disabled');
	  }

	  $('#zipCode').val(data.zipCode);
	  // load city name and uf
	  self.fv[0].revalidateField('zipCode').then((status) => {
		$('#address_street').val(data.address_street);
		$('#address_number').val(data.address_number);
		self.fv[0].revalidateField('address_number')
		$('#address_district').val(data.address_district);
	  });

		if(data.children_amount)
				$('#children_amount').val(data.children_amount.id);

			if(data.degree) {
				$('#degree').val(data.degree.id);
				$('#degree').change();
			}

		if(data.salary)
				$('#salary').val(data.salary.id);

		if(data.marital_status)
				$('#marital_status').val(data.marital_status.id);

	  $("#birthday").pickadate('picker').set('select', new Date(data.birthday));

	  data.job_experiences.forEach((item) => {
		addJob({
		  self: self,
		  job_id: item.id,
		  job_type_title: item.type == 'J' ? 'Profissional' : 'Voluntario',
		  role: item.role,
		  company: item.company,
		  job_duration_title: item.job_duration.title,

		  job_type: item.type,
		  job_duration_id: item.job_duration.id,
		  resignation_reason_id: item.resignation_reason_id != null ? item.resignation_reason.id : null,
		})
	  })

	  data.graduations.forEach((item) => {
		addGraduation({
		  self: self,
		  graduation_id: item.id,
		  graduation_type_id: item.graduation_type.id,
		  graduation_type_title: item.graduation_type.title,
		  institution: item.institution,
		  school: item.school,
		  ending: item.ending,
		})
	  })

	  var answers = JSON.parse(data.answers)
	  console.log(answers);

	  answers.forEach(function (item) {
		$('#answers_container select#'+item.attribute_id).val(item.value)
	  })


	},
	onError: function (self) {
	  console.error(self);
	}
  }
}

function checkFeatures() {
  let feats = [];
  $('#features .feature.active').each((i, obj) => {
	feats.push(obj.getAttribute('value'));
  })

  return feats;
}

function setCEP(data, self) {

  const _conf = self.toView;

  if (self.toView !== null && $('zipCode').val() == _conf.zipCode) {

	if ($('address_street').val() == "" && _conf.address_street !== "") {
	  $('address_street').val(_conf.address_street);
	}

	if ($('address_district').val() == "" && _conf.address_district !== "")
	  $('address_district').val(_conf.address_district);

	$('address_city').val(data.localidade);
	$('address_state').val(data.uf);
	$('address_street').focus();
  } else {
	if (data !== null) {
	  if (data.logradouro !== '') {
		$('#address_street').val(`${data.logradouro}${data.complemento!=''? ', '+data.complemento : ''}`);
		$('#address_district').val(data.bairro);
		$('#address_number').focus();
	  } else
		$('#address_street').focus();

	  $('#address_city').val(data.localidade);
	  $('#address_state').val(data.uf);

	  document.getElementById('address_city').setAttribute('data-ibge', data.ibge);
	  document.getElementById('__city').value = data.ibge;
	} else {
	  $('#address_street, #address_district, #address_city, #address_state').val('');
	  document.getElementById('address_city').setAttribute('data-ibge', '');
	}
  }

  self.fv[0].revalidateField('address_street');
  self.fv[0].revalidateField('address_district');
  self.fv[0].revalidateField('address_city');
  self.fv[0].revalidateField('address_number');
  self.fv[0].revalidateField('address_state');
}

function preview(data) {
	console.log(data);

	$('.modal #candidate-name').html(data.name ? data.name : '');
	$('.modal #candidate-email').html(data.email ? data.email : '');
	$('.modal #candidate-phone').html(data.phone ? data.phone : '');
	$('.modal #candidate-mobile').html(data.mobile ? data.mobile : '');
	$('.modal #candidate-address-street').html(data.address_street ? data.address_street : '');
	$('.modal #candidate-address-number').html(data.address_number ? data.address_number : '');
	$('.modal #candidate-zipcode').html(data.zipCode ? data.zipCode : '');
	$('.modal #candidate-address-district').html(data.address_district ? data.address_district : '');
	$('.modal #candidate-city').html(data.city ? data.city.city : '');
    $('.modal #candidate-address_state').html(data.address_state ? data.address_state : '');

    if(data.characterSetPercentages) {
        $('.modal #profile #evaluation').html(`
            ${Object.entries(data.characterSetPercentages).map((value, index) => {
                return `<p>
                <span style="color: #FC062D; font-weight: bold">${value[1].toFixed(2)} % </span>
                ${Array.from(data.characterSets).filter((val, id) => {
                    return id == index
                })[0].title}
                </p>`
            }).toString().replace(/,/g, '')}
        `);
    }

    $('.modal #profile #answers').html(`
        ${data.answers.map((answer, index) => {
            return `<div class="col-3">
                <span>${data.attributes.filter(attribute => attribute.id == answer.attribute_id)[0].title}: ${answer.value}</span>
            </div>`
        }).toString().replace(/,/g, '')}
    `);

	//   $('.modal-details').html(html);
	$('.modal-details').modal('show');

	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		let tab = $(e.target)[0];

		if(tab.id == 'jobs-tab') {
			$.ajax({
				url: '/admin/candidate/jobs/'+data.id,
				method: 'get',
				beforeSend: function(){
					HoldOn.open({message:"Carregando dados, aguarde...",theme:'sk-bounce'});
				},
				success: function(data){
					console.log('data', data);

					let html = '';

					data.data.jobs.forEach(item => {
						html += `<th scope="row">${item.id}</th>
								<td>${item.company.cnpj} - ${item.company.nomeFantasia}</td>
								<td>${item.cbo_occupation.occupation}</td>`
					});

					$('.modal #jobs-list').html(html);

					HoldOn.close();
				},
				error:function(ret){
					self.defaults.ajax.onError(ret,self.callbacks.create.onError);
				}
			});

		}


	})

}
