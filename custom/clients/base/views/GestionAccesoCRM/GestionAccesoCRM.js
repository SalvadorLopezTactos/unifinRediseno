/**
 * Created by JG 12/11/2020.
 * Gestion de Accesos CRM
 */
({
    plugins: ['Dashlet'],
    events: {

        'click #previous_offset': '_previousOffset',
        'click #next_offset': '_nextOffset',
        'click #btn_STodo': 'seleccionarTodo',
        'click #btn_search': 'record_getAgente',
        'click .openModalHorarios': 'showModal',
        'click .closeModalHorarios': 'closeModal',
        'click .UpdateHorario': 'updateHorarios',
        'click .ExcluirHorario': 'excluirHorarios',



    },
    agentes: [],
    back_page: 0,
    next_page: 20,
    total_page_all: null,
    total_page: null,
    seleccionados: [],
    persistNoSeleccionados: [],
    flagSeleccionados: 0,
    Horas: null,
    Minutos: null,

    initialize: function (options) {
        this._super("initialize", [options]);
        self = this;
        this.loadView = false;
        if (app.user.attributes.agente_telefonico_c == 1) {
            this.loadView = true;
            var horas = ['Libre', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23];
            var minutos = [00, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55];
            var list_horas = '<option value="Bloqueado" selected >Bloqueado</option>';
            //var list_horas = '';

            for (var i = 0; i < horas.length; i++) {
                list_horas += '<option value="' + horas[i] + '">' + horas[i] + '</option>';
            }
            this.Horas = list_horas;

            var list_minutos = '<option value=""  selected hidden>Min</option>';
            //var list_minutos = '';
            for (var j = 0; j < minutos.length; j++) {
                list_minutos += '<option value="' + minutos[j] + '">' + minutos[j] + '</option>';
            }
            this.Minutos = list_minutos;
        }
        else {
            var route = app.router.buildRoute(this.module, null, '');
            app.router.navigate(route, {trigger: true});
        }
    },
    _render: function () {
        this._super("_render");
    },

    showModal: function () {
        var modal = $('#myModal');
        if (modal) {
            modal.show();
        }
    },

    closeModal: function () {
        console.log("closeModal - clic");
        var modal = $('#myModal');
        if (modal) {
            modal.hide();
        }
    },

    updateHorarios: function () {

        console.log("Seleccionados");
        var crossSeleccionados = $("#crossSeleccionados").val();
        context = this;
        if (this.flagSeleccionados == 1 && $('#btn_STodo').is(":checked")) {
            $('#btn_STodo').attr('btnstate', 'On');
            var context = this;
            $('.selected').each(function (index, value) {
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

        if (crossSeleccionados != "" && crossSeleccionados != '[]') {
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
        var horario = '{"Monday":{"entrada":"' + $("#LHin").val() + ($("#LMin").val() != "" ? (":" + $("#LMin").val()) : "") +
            '","salida":"' + $("#LHout").val() + ($("#LMout").val() != "" ? (":" + $("#LMout").val()) : "") + '"},' +
            '"Tuesday":{"entrada":"' + $("#MHin").val() + ($("#MMin").val() != "" ? (":" + $("#MMin").val()) : "") +
            '","salida":"' + $("#MHout").val() + ($("#MMout").val() != "" ? (":" + $("#MMout").val()) : "") + '"},' +
            '"Wednesday":{"entrada":"' + $("#MiHin").val() + ($("#MiMin").val() != "" ? (":" + $("#MiMin").val()) : "")
            + '","salida":"' + $("#MiHout").val() + ($("#MiMout").val() != "" ? (":" + $("#MiMout").val()) : "") + '"},' +
            '"Thursday":{"entrada":"' + $("#JHin").val() + ($("#JMin").val() != "" ? (":" + $("#JMin").val()) : "") +
            '","salida":"' + $("#JHout").val() + ($("#JMout").val() != "" ? (":" + $("#JMout").val()) : "") + '"},' +
            '"Friday":{"entrada":"' + $("#VHin").val() + ($("#VMin").val() != "" ? (":" + $("#VMin").val()) : "") +
            '","salida":"' + $("#VHout").val() + ($("#VMout").val() != "" ? (":" + $("#VMout").val()) : "") + '"},' +
            '"Saturday":{"entrada":"' + $("#SHin").val() + ($("#SMin").val() != "" ? (":" + $("#SMin").val()) : "") +
            '","salida":"' + $("#SHout").val() + ($("#SMout").val() != "" ? (":" + $("#SMout").val()) : "") + '"},' +
            '"Sunday":{"entrada":"' + $("#DHin").val() + ($("#DMin").val() != "" ? (":" + $("#DMin").val()) : "") +
            '","salida":"' + $("#DHout").val() + ($("#DMout").val() != "" ? (":" + $("#DMout").val()) : "") + '"}}';

        console.log("Parametros " + parametros)
        if (parametros != "") {
            var Params = {
                'seleccionados': parametros,
                'horario': horario,
                'excluir':false
            };
            app.alert.show('Actualizando', {
                level: 'process',
                title: 'Actualizando...'
            });
            var dnbProfileUrl = app.api.buildURL("updateAsesores", '', {}, {});
            app.api.call("create", dnbProfileUrl, {data: Params}, {
                success: _.bind(function (data) {
                    app.alert.dismiss('Actualizando');
                    console.log(data);
                    if (data) {
                        this.closeModal();
                        this.record_getAgente();
                    }

                }, this)
            });

        }
        else {
            app.alert.show('Selecciona Asesor', {
                level: 'warning',
                title: 'Selecciona un Asesor...'
            });
        }

    },
    excluirHorarios:function () {
        var crossSeleccionados = $("#crossSeleccionados").val();
        context = this;
        if (this.flagSeleccionados == 1 && $('#btn_STodo').is(":checked")) {
            $('#btn_STodo').attr('btnstate', 'On');
            var context = this;
            $('.selected').each(function (index, value) {
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

        if (crossSeleccionados != "" && crossSeleccionados != '[]') {
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
                'horario': "",
                'excluir':true
            };
            app.alert.show('Actualizando', {
                level: 'process',
                title: 'Actualizando...'
            });
            var dnbProfileUrl = app.api.buildURL("updateAsesores", '', {}, {});
            app.api.call("create", dnbProfileUrl, {data: Params}, {
                success: _.bind(function (data) {
                    app.alert.dismiss('Actualizando');
                    console.log(data);
                    if (data) {
                        this.closeModal();
                        this.record_getAgente();
                    }

                }, this)
            });

        }
        else {
            app.alert.show('Selecciona Asesor', {
                level: 'warning',
                title: 'Selecciona un Asesor...'
            });
        }
    },
    record_getAgente: function (aux) {
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

        var nombres = $("#filtroNombre").val();
        var apellidos = $("#filtroApellido").val();

        var filter_arguments =
            {
                "fields": [
                    "nombre_completo_c",
                    "puestousuario_c",
                    "access_hours_c"
                ],
                "next_offset": -1,
                "max_num": -1,
                "offset": from_set_num,
                "filter": [
                    {
                        "nombre_completo_c": {
                            "$contains": nombres + " " + apellidos
                        },
                        "puestousuario_c": 27
                    }
                ]
            };
        this.agentes = [];
        app.api.call("read", app.api.buildURL("Users", null, null, filter_arguments), null, {
            success: _.bind(function (data) {
                var count = Object.keys(data.records).length;
                if (count > 20) {
                    for (var i = 0; i < 20; i++) {
                        data.records[i].access_hours_c = data.records[i].access_hours_c != "" ? JSON.parse(data.records[i].access_hours_c) : "00:00";
                        this.agentes.push(data.records[i]);
                    }
                }
                else {
                    for (var i = 0; i < count; i++) {
                        data.records[i].access_hours_c = data.records[i].access_hours_c != "" ? JSON.parse(data.records[i].access_hours_c) : "00:00";
                        this.agentes.push(data.records[i]);
                    }
                    //this.agentes = data.records;
                }

                console.log(this.agentes);
                console.log("existen registros" + count);
                self.total_page = 20;
                self.total_page_all = count;
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

                $("#filtroNombre").val(nombres);
                $("#filtroApellido").val(apellidos);

            }, this)
        });

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
            $(this.agentes).each(function (index, value) {
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
        this.record_getAgente("ok");
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
        this.record_getAgente("ok");
    },
})