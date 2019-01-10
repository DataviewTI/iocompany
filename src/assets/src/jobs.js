new IOService({
        name: "job"
    },
    function (self) {

        $("select[name='profile']").change(function () {
            if ($(this).val() != "") {
                $(".features-group").css("display", "none");
                $(".features-group").removeClass("active");

                $(".features-group[data-profile-id=" + $(this).val() + "]").css(
                    "display",
                    "block"
                );
                $(".features-group[data-profile-id=" + $(this).val() + "]").addClass(
                    "active"
                );
            } else {
                $(".features-group").css("display", "none");
                $(".features-group").removeClass("active");
            }
        });

        //colocar o serviceurl do autocomplete para funcionar instead ajax

        console.log("asasa");

        $.ajax({
            url: "company/simplified-list",
            success: function (ret) {
                $("#filterCompany").autocomplete({
                    maxheight: 100,
                    minChars: 3,
                    preserveInput: true,
                    lookup: $.map(ret, function (item) {
                        return {
                            value: item.razaoSocial,
                            data: item.cnpj,
                            nomef: item.nomeFantasia,
                            item: item
                        };
                    }),
                    lookupFilter: function (suggestion, query, queryLowerCase) {
                        return (
                            suggestion.value.toLowerCase().indexOf(queryLowerCase) > -1 ||
                            suggestion.data.indexOf(queryLowerCase) > -1 ||
                            suggestion.nomef.toLowerCase().indexOf(queryLowerCase) > -1
                        );
                    },
                    onSelect: function (sugg, a) {
                        $(this).val(sugg.value);
                        $(this).attr("fv-value", sugg.data);
                        self.fv[0].revalidateField("filterCompany");
                        toggleHirerForm(self, sugg.item);
                    },
                    onInvalidateSelection() {
                        $(this).attr("fv-value", "");
                        self.fv[0].revalidateField("filterCompany");
                    }
                });
            }
        });

        $("#cbo").autocomplete({
            maxheight: 100,
            minChars: 3,
            preserveInput: true,
            lookup: $.map($CBO, function (item) {
                return {
                    value: item.o,
                    data: item.i
                };
            }),
            lookupFilter: function (suggestion, query, queryLowerCase) {
                return (
                    suggestion.value.toLowerCase().indexOf(queryLowerCase) > -1 ||
                    suggestion.data.indexOf(queryLowerCase) > -1
                );
            },
            onSelect: function (sugg, a) {
                $(this).val(sugg.value);
                $(this).attr("fv-value", sugg.data);
                self.fv[0].revalidateField("cbo");
            },
            onInvalidateSelection() {
                $(this).attr("fv-value", "");
                self.fv[0].revalidateField("cbo");
            }
        });

        $("#cbo-modal")
            .modal({
                show: false,
                keyboard: false,
                backdrop: "static"
            })
            .on("show.bs.modal", function () {
                console.log("há");
            });

        $("#btn-cbo-search").on("click", e => {
            $("#cbo-modal").modal("show");
            e.originalEvent.preventDefault();
        });

        $("#features .feature").attrchange(function (attrName) {
            if (attrName == "aria-pressed") self.fv[0].revalidateField("__features");
        });

        //Datatables initialization
        self.dt = $("#jobs-table")
            .DataTable({
                aaSorting: [
                    [0, "desc"]
                ],
                ajax: self.path + "/list",
                initComplete: function () {
                    let api = this.api();
                    $.fn.dataTable.defaults.initComplete(this);
                },
                footerCallback: function (row, data, start, end, display) {},
                columns: [{
                        data: "id",
                        name: "id"
                    },
                    {
                        data: "company",
                        name: "cnpj"
                    },
                    {
                        data: "company",
                        name: "razaoSocial"
                    },
                    {
                        data: "date_start",
                        name: "date_start"
                    },
                    {
                        data: "interval",
                        name: "interval"
                    },
                    {
                        data: "date_end",
                        name: "date_end"
                    },
                    {
                        data: "degree",
                        name: "degree"
                    },
                    {
                        data: "profile",
                        name: "profile"
                    },
                    {
                        data: "gender",
                        name: "gender"
                    },
                    {
                        data: "apprentice",
                        name: "apprentice"
                    },
                    {
                        data: "actions",
                        name: "actions"
                    }
                ],
                columnDefs: [{
                        targets: "__dt_id",
                        width: "1%",
                        searchable: true,
                        orderable: true
                    },
                    {
                        targets: "__dt_cnpj",
                        width: "5%",
                        class: "text-center",
                        searchable: true,
                        orderable: true,
                        render: function (data, type, row, y) {
                            return data.cnpj;
                        }
                    },
                    {
                        targets: "__dt_razao-social",
                        searchable: true,
                        orderable: true,
                        render: function (data, type, row, y) {
                            return data.razaoSocial;
                        }
                    },
                    {
                        targets: "__dt_dt-inicio",
                        width: "8%",
                        class: "text-center",
                        searchable: true,
                        orderable: true
                    },
                    {
                        targets: "__dt_intervalo",
                        width: "5%",
                        class: "text-center",
                        searchable: true,
                        orderable: true
                    },
                    {
                        targets: "__dt_dt-final",
                        width: "8%",
                        class: "text-center",
                        searchable: true,
                        orderable: true
                    },
                    {
                        targets: "__dt_escolaridade",
                        width: "20%",
                        searchable: true,
                        orderable: true,
                        render: function (data, type, row, y) {
                            return data.degree;
                        }
                    },
                    {
                        targets: "__dt_perfil",
                        width: "8%",
                        searchable: true,
                        orderable: true,
                        render: function (data, type, row, y) {
                            return data.profile;
                        }
                    },
                    {
                        targets: "__dt_genero",
                        width: "5%",
                        searchable: true,
                        orderable: true,
                        render: function (data, type, row, y) {
                            if (data == "I") {
                                return "Indiferente";
                            } else if (data == "M") {
                                return "Masculino";
                            } else if (data == "F") {
                                return "Feminino";
                            }
                        }
                    },
                    {
                        targets: "__dt_aprendiz",
                        width: "5%",
                        searchable: true,
                        orderable: true,
                        render: function (data, type, row, y) {
                            if (data == "S") {
                                return "Sim";
                            } else if (data == "N") {
                                return "Não";
                            }
                        }
                    },
                    {
                        targets: "__dt_acoes",
                        width: "7%",
                        className: "text-center",
                        searchable: false,
                        orderable: false,
                        render: function (data, type, row, y) {
                            return self.dt.addDTButtons({
                                buttons: [{
                                        ico: "ico-eye",
                                        _class: "text-primary",
                                        title: "preview"
                                    },
                                    {
                                        ico: "ico-edit",
                                        _class: "text-info",
                                        title: "editar"
                                    },
                                    {
                                        ico: "ico-trash",
                                        _class: "text-danger",
                                        title: "excluir"
                                    }
                                ]
                            });
                        }
                    }
                ]
            })
            .on("click", ".btn-dt-button[data-original-title=editar]", function () {
                var data = self.dt.row($(this).parents("tr")).data();
                self.view(data.id);
            })
            .on("click", ".ico-trash", function () {
                var data = self.dt.row($(this).parents("tr")).data();
                self.delete(data.id);
            })
            .on("click", ".ico-eye", function () {
                var data = self.dt.row($(this).parents("tr")).data();
                preview({
                    id: data.cnpj
                });
            })
            .on("draw.dt", function () {
                $('[data-toggle="tooltip"]').tooltip();
            });

        self.fv = [];

        self.fv[0] = FormValidation.formValidation(
                document.querySelector('.step-pane[data-step="1"]'), {
                    fields: {
                        filterCompany: {
                            validators: {
                                callback: {
                                    callback: function (obj) {
                                        let el = $(obj.element);
                                        if (!el.val().length)
                                            return {
                                                valid: false,
                                                message: "A empresa demandante é obrigatória"
                                            };
                                        if (el.attr("fv-value") == "")
                                            return {
                                                valid: false,
                                                message: "Empresa inválida!"
                                            };

                                        // toggleHirerForm(self, el.attr("fv-value"));
                                        return true;
                                    }
                                }
                            }
                        },
                        profile: {
                            validators: {
                                notEmpty: {
                                    message: "Informe o perfil!"
                                }
                            }
                        },
                        cbo: {
                            validators: {
                                callback: {
                                    callback: function (obj) {
                                        let el = $(obj.element);
                                        if (!el.val().length)
                                            return {
                                                valid: false,
                                                message: "A descrição da vaga (CBO) é obrigatória"
                                            };
                                        if (el.attr("fv-value") == "")
                                            return {
                                                valid: false,
                                                message: "CBO Inválido!"
                                            };
                                        return true;
                                    }
                                }
                            }
                        },
                        __features: {
                            validators: {
                                callback: {
                                    callback: function (obj) {
                                        const feats = checkFeatures();

                                        if (feats.length < 3) {
                                            if (feats.length == 0)
                                                toastr["error"]("Selecione no mínimo 3 características!");

                                            return {
                                                valid: false,
                                                message: "Selecione no mínimo 3 características"
                                            };
                                        }

                                        return true;
                                    }
                                }
                            }
                        },
                        date_start: {
                            validators: {
                                notEmpty: {
                                    message: "O data inicial é obrigatória"
                                },
                                date: {
                                    format: "DD/MM/YYYY",
                                    message: "Informe uma data válida!"
                                }
                            }
                        },
                        date_end: {
                            validators: {
                                notEmpty: {
                                    message: "O data final é obrigatória"
                                },
                                date: {
                                    format: "DD/MM/YYYY",
                                    message: "Informe uma data válida!"
                                }
                            }
                        },
                        degree: {
                            validators: {
                                notEmpty: {
                                    message: "Informe a escolaridade"
                                }
                            }
                        },
                        nomeFantasia: {
                            enabled: false,
                            validators: {
                                notEmpty: {
                                    message: "O Nome Fantasia é obrigatório!"
                                }
                            }
                        },
                        razaoSocial: {
                            enabled: false,
                            validators: {
                                notEmpty: {
                                    message: "A Razão Social é obrigatória!"
                                }
                            }
                        },
                        cnpj: {
                            enabled: false,
                            validators: {
                                notEmpty: {
                                    message: "O CNPJ é obrigatório"
                                },
                                vat: {
                                    country: "BR",
                                    message: "cnpj inválido"
                                }
                            }
                        },
                        phone: {
                            enabled: false,
                            validators: {
                                notEmpty: {
                                    message: "O Telefone é obrigatório"
                                },
                                phone: {
                                    country: "BR",
                                    message: "Telefone Inválido"
                                }
                            }
                        },
                        mobile: {
                            enabled: false,
                            validators: {
                                phone: {
                                    country: "BR",
                                    message: "Celular Inválido"
                                }
                            }
                        },
                        email: {
                            enabled: false,
                            validators: {
                                notEmpty: {
                                    message: "O email principal é obrigatório"
                                },
                                emailAddress: {
                                    message: "email Inválido"
                                }
                            }
                        },
                        zipCode: {
                            enabled: false,
                            validators: {
                                promise: {
                                    notEmpty: {
                                        message: "O Cep é obrigatório"
                                    },
                                    enabled: true,
                                    promise: function (input) {

                                        return new Promise(function (resolve, reject) {
                                            if (input.value.replace(/\D/g, "").length < 8) {
                                                resolve({
                                                    valid: false,
                                                    message: "Cep Inválido!",
                                                    meta: {
                                                        data: null
                                                    }
                                                });
                                            } else {

                                                delete $.ajaxSettings.headers["X-CSRF-Token"];

                                                $.ajax({
                                                    url: `https://viacep.com.br/ws/${$("#zipCode").val().replace(/[^0-9]/g, '')}/json`,
                                                    headers: {
                                                        "Content-Type": "application/json"
                                                        // 'X-CSRF-Token': laravel_token,
                                                    },
                                                    complete: jqXHR => {
                                                        $.ajaxSettings.headers["X-CSRF-Token"] = laravel_token;
                                                    },
                                                    success: data => {
                                                        if (data.erro == true) {
                                                            resolve({
                                                                valid: false,
                                                                message: "Cep não encontrado!",
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
                                                    },
                                                    error: data => {}
                                                });
                                            }
                                        });
                                    }
                                }
                            }
                        },
                        address: {
                            enabled: false,
                            validators: {
                                notEmpty: {
                                    message: "O endereço é obrigatório"
                                }
                            }
                        },
                        address2: {
                            enabled: false,
                            validators: {
                                notEmpty: {
                                    message: "O bairro é obrigatório"
                                }
                            }
                        },
                        numberApto: {
                            enabled: false,
                            validators: {
                                notEmpty: {
                                    message: "campo obrigatório"
                                }
                            }
                        },
                        city: {
                            enabled: false,
                            validators: {
                                notEmpty: {
                                    message: "O bairro é obrigatório"
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        bootstrap: new FormValidation.plugins.Bootstrap(),
                        icon: new FormValidation.plugins.Icon({
                            valid: "fv-ico ico-check",
                            invalid: "fv-ico ico-close",
                            validating: "fv-ico ico-gear ico-spin"
                        })
                    }
                }
            ).setLocale("pt_BR", FormValidation.locales.pt_BR)
            .on('core.validator.validated', function (e) {
                if (e.field === 'zipCode' && e.validator === 'promise') {
                    setCEP(e.result.meta.data, self);
                }
            });

        $("#date_start")
            .pickadate({
                formatSubmit: "yyyy-mm-dd 00:00:00",
                min: new Date(),
                onClose: function () {
                    //$("[name='date_end']").focus();
                }
            })
            .pickadate("picker")
            .on("set", function (t) {
                calcFinalDate();
                self.fv[0].revalidateField("date_start");
            });

        $("#interval").change(() => {
            console.log(checkFeatures());
            calcFinalDate();
            self.fv[0].revalidateField("date_start");
        });

        $("#date_end")
            .pickadate({
                formatSubmit: "yyyy-mm-dd 00:00:00",
                onClose: function () {
                    $("[name='description']").focus();
                }
            })
            .pickadate("picker")
            .on("render", function () {
                self.fv[0].revalidateField("date_end");
            });

        self.wizardActions(function () {
            var feats = checkFeatures();
            $("#__features").val(feats);
        });

        self.callbacks.view = view(self);
        self.callbacks.update.onSuccess = () => {};

        self.callbacks.create.onSuccess = () => {};

        self.callbacks.unload = self => {
            $("#xxx").val("");
            $(".features-group").css("display", "none");
            $(".features-group").removeClass("active");
        };

        self.tabs.cadastrar.tab.on("show.bs.tab", () => {});
    }
);

function view(self) {
    return {
        onSuccess: function (data) {
            console.log(data);

            $("#filterCompany").val(data.company.razaoSocial);

            //self.fv[0].revalidateField('cnpj');
            $("#profile").val(data.profile.id);
            $(".features-group").css("display", "none");
            $(".features-group").removeClass("active");
            $(".features-group[data-profile-id=" + data.profile.id + "]").css(
                "display",
                "block"
            );
            $(".features-group[data-profile-id=" + data.profile.id + "]").addClass(
                "active"
            );

            data.features.forEach(function (item) {
                $(
                    ".features-group[data-profile-id=" +
                    data.profile.id +
                    "] .feature[value=" +
                    item.id +
                    "]"
                ).addClass("active");
                $(
                    ".features-group[data-profile-id=" +
                    data.profile.id +
                    "] .feature[value=" +
                    item.id +
                    "]"
                ).addClass("focus");
                console.log(item);
            });

            $("#cbo").val(data.cbo_occupation.occupation);
            $("#date_start")
                .pickadate("picker")
                .set("select", new Date(data.date_start));
            $("#interval").val(data.interval);
            $("#date_end")
                .pickadate("picker")
                .set("select", new Date(data.date_end));
            $("#degree").val(data.degree.id);
            $("#gender").val(data.gender);
            $("#apprentice").val(data.apprentice);

            if (data.pcd_type != null) {
                $("#pcd").val(data.pcd_type.id);
            }

            $("#salary").val(data.salary.id);
            $("#observations").val(data.observations);

            console.log(data.company.roles.length);

            if (data.company.roles.length > 0) {
                console.log(data.company.roles.length);

                $('#cnpj').val(data.company.cnpj);
                $('#razaoSocial').val(data.company.razaoSocial);
                $('#nomeFantasia').val(data.company.nomeFantasia);
                $('#phone').val(data.company.phone);
                $('#mobile').val(data.company.mobile);
                $('#email').val(data.company.email);
                $('#zipCode').val(data.company.zipCode);
                $('#numberApto').val(data.company.numberApto);

                self.fv[0].revalidateField('zipCode');

            }

            self.fv[0].validate();

            //não disparar o preenchimento quando for update logo após o view
        }, //sasas
        onError: function (self) {
            console.error(self);
        }
    };
}

function checkFeatures() {
    let feats = [];
    $("#features .features-group.active .feature.active").each((i, obj) => {
        feats.push(obj.getAttribute("value"));
    });

    return feats;
}

function setCEP(data, self) {
    const _conf = self.toView;

    if (self.toView !== null && $("zipCode").val() == _conf.company.zipCode) {
        if ($("address").val() == "" && _conf.company.address !== "") {
            $("address").val(_conf.company.address);
        }

        if ($("address2").val() == "" && _conf.company.address2 !== "")
            $("address").val(_conf.company.address2);

        $("city").val(data.localidade);
        $("state").val(data.uf);
        $("address1").focus();
    } else {
        if (data !== null) {
            if (data.logradouro !== "") {
                $("#address").val(
                    `${data.logradouro}${
      data.complemento != "" ? ", " + data.complemento : ""
     }`
                );
                $("#address2").val(data.bairro);
                $("#numberApto").focus();
            } else $("#address").focus();

            $("#city").val(data.localidade);
            $("#state").val(data.uf);

            document.getElementById("city").setAttribute("data-ibge", data.ibge);
            document.getElementById("__city").value = data.ibge;
        } else {
            $("#address, #address2, #city, #state").val("");
            document.getElementById("city").setAttribute("data-ibge", "");
        }
    }

    self.fv[0].revalidateField("address");
    self.fv[0].revalidateField("address2");
    self.fv[0].revalidateField("city");
    self.fv[0].revalidateField("numberApto");
}

function calcFinalDate() {
    const ini = $("#date_start").pickadate("picker");
    const end = $("#date_end").pickadate("picker");

    end.set("clear");

    if (ini.get("select") !== null) {
        const new_date = moment(ini.get("select", "yyyy-mm-dd")).add(
            $("#interval").val(),
            "days"
        );
        end.set("select", new_date.format("YYYY-MM-DD"), {
            format: "yyyy-mm-dd"
        });
    }
}

function toggleHirerForm(self, data) {

    if (data.roles.length > 0) {
        $('#has_hirer_info').val('true');
        $('#hirer_form').slideDown();
        self.fv[0].enableValidator('nomeFantasia')
            .enableValidator('razaoSocial')
            .enableValidator('cnpj')
            .enableValidator('phone')
            .enableValidator('mobile')
            .enableValidator('email')
            .enableValidator('zipCode')
            .enableValidator('address')
            .enableValidator('address2')
            .enableValidator('numberApto')
            .enableValidator('city');

        self.fv[0].revalidateField('nomeFantasia');
        self.fv[0].revalidateField('razaoSocial');
        self.fv[0].revalidateField('cnpj');
        self.fv[0].revalidateField('phone');
        self.fv[0].revalidateField('mobile');
        self.fv[0].revalidateField('email');
        self.fv[0].revalidateField('zipCode');
        self.fv[0].revalidateField('address');
        self.fv[0].revalidateField('address2');
        self.fv[0].revalidateField('numberApto');
        self.fv[0].revalidateField('city');

    } else {
        $('#has_hirer_info').val('false');
        $('#hirer_form').slideUp();
        self.fv[0].disableValidator('nomeFantasia');
        self.fv[0].disableValidator('razaoSocial');
        self.fv[0].disableValidator('cnpj');
        self.fv[0].disableValidator('phone');
        self.fv[0].disableValidator('mobile');
        self.fv[0].disableValidator('email');
        self.fv[0].disableValidator('zipCode');
        self.fv[0].disableValidator('address');
        self.fv[0].disableValidator('address2');
        self.fv[0].disableValidator('numberApto');
        self.fv[0].disableValidator('city');
    }
    // $.ajax({
    //     url: "/admin/company/view/" + cnpj,
    //     beforeSend: function () {},
    //     success: function (ret) {
    //         if (ret.success) {
    //             var requestData = ret.data[0];

    //             if (requestData.roles.length > 0) {
    //                 console.log('enable');

    //                 // $('#hirer_form').slideDown();
    //                 self.fv[0].enableValidator('nomeFantasia')
    //                     .enableValidator('razaoSocial')
    //                     .enableValidator('cnpj')
    //                     .enableValidator('phone')
    //                     .enableValidator('mobile')
    //                     .enableValidator('email')
    //                     .enableValidator('zipCode')
    //                     .enableValidator('address')
    //                     .enableValidator('address2')
    //                     .enableValidator('numberApto')
    //                     .enableValidator('city');

    //                 self.fv[0].revalidateField('nomeFantasia');
    //                 self.fv[0].revalidateField('razaoSocial');
    //                 self.fv[0].revalidateField('cnpj');
    //                 self.fv[0].revalidateField('phone');
    //                 self.fv[0].revalidateField('mobile');
    //                 self.fv[0].revalidateField('email');
    //                 self.fv[0].revalidateField('zipCode');
    //                 self.fv[0].revalidateField('address');
    //                 self.fv[0].revalidateField('address2');
    //                 self.fv[0].revalidateField('numberApto');
    //                 self.fv[0].revalidateField('city');

    //             } else {
    //                 console.log('disable');

    //                 // $('#hirer_form').slideUp();
    //                 self.fv[0].disableValidator('nomeFantasia');
    //                 self.fv[0].disableValidator('razaoSocial');
    //                 self.fv[0].disableValidator('cnpj');
    //                 self.fv[0].disableValidator('phone');
    //                 self.fv[0].disableValidator('mobile');
    //                 self.fv[0].disableValidator('email');
    //                 self.fv[0].disableValidator('zipCode');
    //                 self.fv[0].disableValidator('address');
    //                 self.fv[0].disableValidator('address2');
    //                 self.fv[0].disableValidator('numberApto');
    //                 self.fv[0].disableValidator('city');
    //             }

    //         }
    //     },
    //     error: function (ret) {
    //         HoldOn.close();
    //     }
    // });
}
