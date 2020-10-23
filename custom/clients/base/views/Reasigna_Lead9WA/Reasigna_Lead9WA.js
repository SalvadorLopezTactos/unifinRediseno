({
    events: {

        'click #previous_offset': '_previousOffset',
        'click #next_offset': '_nextOffset',
        'click #btn_STodo': 'seleccionarTodo',
        'click #btn_ReAsignar': 'reAsignarLeads',
        'click #btn_search': 'record_get9Wa',

    },

    leads: null,
    back_page: 0,
    next_page: 20,
    total_page_all: null,
    total_page: null,
    seleccionados: [],
    persistNoSeleccionados: [],
    flagSeleccionados: 0,


    initialize: function (options) {
        this._super("initialize", [options]);
        this.loadView = false;
        var puesto = app.user.attributes.puestousuario_c;
        // puestousuario_c
        if (puesto == 27 || puesto == 31) {

            var from_set = 0;
            var to_set = 20;
            var current_set = $("#offset_value").html();
            var from_set_num = parseInt(from_set);

            if (isNaN(from_set_num)) {
                from_set_num = 0;
            }
            var filter_arguments =
                {
                    "offset": from_set_num,
                };

            app.api.call("read", app.api.buildURL("GetLeads9WA", null, null, filter_arguments), null, {
                success: _.bind(function (data) {
                    this.leads = data.leads;
                    self.total_page = data.total_leads;
                    self.total_page_all = data.Leads_all;
                    this.loadView = true;
                    this.render();
                    app.alert.dismiss('upload');

                    if (to_set > self.total_page_all) {
                        to_set = self.total_page_all;
                    } else {
                        to_set = from_set_num + self.total_page;
                    }

                    current_set = (parseInt(from_set) + 1) + " a " + to_set + " de " + self.total_page_all;
                    if (_.isEmpty(from_set)) {
                        from_set = 0;
                        to_set = 20;

                        if (to_set > self.total_page_all) {
                            to_set = self.total_page_all;
                        }

                        current_set = (parseInt(from_set) + 1) + " a " + to_set + " de " + self.total_page_all;
                    }
                    $("#offset_value").html(current_set);
                    $("#offset_value").attr("from_set", from_set);
                    $("#offset_value").attr("to_set", to_set);

                    if (to_set == self.total_page_all) {
                        $("#next_offset").attr('style', 'pointer-events:none')
                    }

                }, this)
            });

        } else {
            var route = app.router.buildRoute(this.module, null, '');
            app.router.navigate(route, {trigger: true});
        }
    },

    _render: function () {
        this._super("_render");


    },

    record_get9Wa: function (aux) {
        app.alert.show('upload', {level: 'process', title: 'LBL_LOADING', autoclose: false});

        if (aux != "ok") {
            var from_set = 0;
            var to_set = 20;
            var current_set = $("#offset_value").html();
            var from_set_num = parseInt(from_set);
        }
        else {
            var from_set = $("#offset_value").attr("from_set");
            var to_set = $("#offset_value").attr("to_set");
            var current_set = $("#offset_value").html();
            var from_set_num = parseInt(from_set);
        }
        if (isNaN(from_set_num)) {
            from_set_num = 0;
        }

        valorB = $("#filtroLead").val();
        var filter_arguments =
            {
                "offset": from_set_num,
                "busqueda": valorB

            };
        app.api.call("read", app.api.buildURL("GetLeads9WA", null, null, filter_arguments), null, {
            success: _.bind(function (data) {
                this.leads = data.leads;
                self.total_page = data.total_leads;
                self.total_page_all = data.Leads_all;
                this.loadView = true;
                this.render();
                app.alert.dismiss('upload');

                if (to_set > self.total_page_all) {
                    to_set = self.total_page_all;
                } else {
                    to_set = from_set_num + self.total_page;
                }

                current_set = (parseInt(from_set) + 1) + " a " + to_set + " de " + self.total_page_all;
                if (_.isEmpty(from_set)) {
                    from_set = 0;
                    to_set = 20;

                    if (to_set > self.total_page_all) {
                        to_set = self.total_page_all;
                    }

                    current_set = (parseInt(from_set) + 1) + " a " + to_set + " de " + self.total_page_all;
                }
                $("#offset_value").html(current_set);
                $("#offset_value").attr("from_set", from_set);
                $("#offset_value").attr("to_set", to_set);

                if (to_set == self.total_page_all) {
                    $("#next_offset").attr('style', 'pointer-events:none')
                }

                $("#filtroLead").val(valorB);

            }, this)
        });

    },

    reAsignarLeads: function () {
        var crossSeleccionados = $("#crossSeleccionados").val();
        context = this;

        if (this.flagSeleccionados == 1 && $('#btn_STodo').is(":checked")) {
            $('#btn_STodo').attr('btnstate', 'On');
            var context = this;
            $('.selected').each(function (index, value) {
                //Validación para persistir valores de los checks en caso de que se haya "Seleccionado Todo"
                //y se hayan deseleccionado registros individualmente
                if (context.persistNoSeleccionados != undefined && context.persistNoSeleccionados.length > 0) {

                    if (context.persistNoSeleccionados.includes($(this).attr('value'))) {
                        $(value).prop("checked", false)
                    } else {
                        $(value).prop("checked", true);
                    }
                } else {

                    $(value).prop("checked", true);

                }
            });
        }

        if (crossSeleccionados!="" && crossSeleccionados!='[]') {

            this.seleccionados = JSON.parse(crossSeleccionados);
            //Validar que los nuevos checks seleccionados no existen en crossSeleccionados
            $('.selected').each(function (index, value) {
                if ($(value).is(":checked") && context.flagSeleccionados == 1) {
                    if (!context.seleccionados.includes(value.value) && value.value != 0) {
                        context.seleccionados.push(value.value)
                    }

                }
            });
            $("#crossSeleccionados").val(JSON.stringify(this.seleccionados));

            $(this.seleccionados).each(function (index, selected) {
                $('.selected').each(function (index, value) {

                    if (selected == value.value) {
                        $(value).prop("checked", true);
                    }

                });

            });
        }
        else {
            $('.selected').each(function (index, value) {
                if ($(value).is(":checked")) {
                    context.seleccionados.push(value.value);
                }
            });
        }

        var parametros = context.seleccionados;

        if (parametros != "") {
            var Params = {
                'seleccionados': parametros,
            };
            app.alert.show('reasignando', {
                level: 'process',
                title: 'Cargando...'
            });
            var dnbProfileUrl = app.api.buildURL("reAsignarLeads", '', {}, {});
            app.api.call("create", dnbProfileUrl, {data: Params}, {
                success: _.bind(function (data) {
                    app.alert.dismiss('reasignando');
console.log(data);
                    if (data == "" || data==null) {
                        app.alert.show('Reasignado', {
                            level: 'success',
                            messages: '¡Reasignación Completa!',
                        });
                    }
                    else {
                        app.alert.show('medioReasignado', {
                            level: 'warning',
                            messages: 'Algunos Leads no se pudieron reasignar',
                        });
                    }
                    this.record_get9Wa();


                }, this)
            });
        } else {
            app.alert.show('Selecciona Lead', {
                level: 'warning',
                title: 'Selecciona un Lead...'
            });
        }

    },

    seleccionarTodo: function (e) {

        var seleccionarTodo = [];

        if (this.persistNoSeleccionados != undefined && this.persistNoSeleccionados.length > 0) {

            for (var i = 0; i < this.persistNoSeleccionados.length; i++) {

                //Añadir el elemento solo si no existe en arreglo full_cuentas
                if (!this.full_cuentas.includes(this.persistNoSeleccionados[i])) {
                    this.full_cuentas.push(this.persistNoSeleccionados[i])
                }
            }

            this.persistNoSeleccionados = [];

        } else {

            this.persistNoSeleccionados = [];
        }

        if (this.flagSeleccionados == 0) {
            this.flagSeleccionados = 1;
        } else {
            this.flagSeleccionados = 0;
        }
        var btnState = $(e.target).attr("btnState");
        if (btnState == "Off") {
            $(e.target).attr("btnState", "On");
            btnState = 'On';
        } else {
            $(e.target).attr("btnState", "Off");
            btnState = 'Off';
        }

        $('.selected').each(function (index, value) {
            if (btnState == "On") {
                $(value).prop('checked', true);
            } else {
                $(value).prop('checked', false);
            }
        });

        var crossSeleccionados = $("#crossSeleccionados").val();
        if (!_.isEmpty(crossSeleccionados)) {
            seleccionarTodo = JSON.parse(crossSeleccionados);
        }

        if ($('.selected').prop("checked")) {
            $(this.leads).each(function (index, value) {
                seleccionarTodo.push(value.id);
            });
        } else {
            seleccionarTodo = [];
        }

        this.seleccionados = seleccionarTodo;

        $("#crossSeleccionados").val(JSON.stringify(this.seleccionados));
    },

    _nextOffset: function () {
        var current_set = $("#offset_value").html();
        var from_set = $("#offset_value").attr("from_set");
        var next_from_set = parseInt(from_set) + 20;
        var to_set = $("#offset_value").attr("to_set");
        var next_to_set = parseInt(to_set) + 20;

        if (next_to_set > this.total_page_all) {
            next_to_set = this.total_page_all;
            next_from_set = next_from_set;


        }

        $("#offset_value").html(current_set);
        $("#offset_value").attr("from_set", next_from_set);
        $("#offset_value").attr("to_set", next_to_set);
        this.record_get9Wa("ok");
    },

    _previousOffset: function () {
        var current_set = $("#offset_value").html();
        var from_set = $("#offset_value").attr("from_set");
        var next_from_set = parseInt(from_set) - 20;
        var to_set = $("#offset_value").attr("to_set");
        var next_to_set = parseInt(to_set) - 20;

        if (next_from_set < 0) {
            next_from_set = 0;
            next_to_set = 20;
        }

        $("#offset_value").html(current_set);
        $("#offset_value").attr("from_set", next_from_set);
        $("#offset_value").attr("to_set", next_to_set);
        this.record_get9Wa("ok");
    },

})