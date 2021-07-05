/**
 * Created by EJC 07/05/2021.
 * Gestion de Leads CRM
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
        'change #filtroNombre': 'checkTextOnly',
        'change #filtroApellido': 'checkTextOnly',
    },

    agentes: [],
    back_page: 0,
    next_page: 20,
    total_page_all: null,
    total_page: null,
    seleccionados: [],
    persistNoSeleccionados: [],
    flagSeleccionados: 0,
    data: [],
    subpuesto_list: null,

    initialize: function (options) {
        this._super("initialize", [options]);
        self = this;
        this.loadView = false;
        if (app.user.attributes.agente_telefonico_c == 1) {
            this.loadView = true;
            this.subpuesto_list = app.lang.getAppListStrings('subpuesto_list');
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
        context = this;
        //console.log("Seleccionados");
        var crossSeleccionados = $("#crossSeleccionados").val();
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
        var agentesTel = context.agentes;
        //console.log("Parametros " + parametros);
        if (parametros != "") {
            var modal = $('#myModal');
            if (modal) {
                modal.show();
            }
            if (parametros.length == 1) {

                
            }
            else {
                context.naceBloqueado();
            }
        }
        else {
            app.alert.show('Selecciona un Asesor', {
                level: 'error',
                title: 'Selecciona al menos un Asesor...'
            });
        }
    },


    updateHorarios: function () {
        context = this;
        if ($('#updateL').is(":checked") || $('#updateM').is(":checked") || $('#updateMi').is(":checked")
            || $('#updateJ').is(":checked") || $('#updateV').is(":checked") || $('#updateS').is(":checked")
            || $('#updateD').is(":checked")) {
            var respuesta = this.validaSetHorario();
            if (respuesta == "") {
                var parametros = context.seleccionados;
                var horario = null;
                //  console.log("Parametros " + parametros);
                //  console.log("Horario " + horario)
                var Params = {
                    'seleccionados': parametros,
                    'horario': horario,
                    'excluir': false
                };
                app.alert.show('Actualizando', {
                    level: 'process',
                    title: 'Actualizando...'
                });
                var dnbProfileUrl = app.api.buildURL("updateAsesores", '', {}, {});
                app.api.call("create", dnbProfileUrl, {data: Params}, {
                    success: _.bind(function (data) {
                        app.alert.dismiss('Actualizando');
                        // console.log(data);
                        if (data) {
                            this.closeModal();
                            this.record_getAgente();
                        }

                    }, this)
                });

            } else {
                /*app.alert.show("Error en Horario", {
                    level: "error",
                    title: "La hora de Salida no puede ser menor  que la hora de entrada: <br>" + respuesta,
                    autoClose: false
                });*/
                app.alert.show("Error en Horario", {
                    level: "error",
                    title: "Se tiene un configuración de horas errónea.<br> " + respuesta,
                    autoClose: false
                });
            }
        }
        else {
            app.alert.show("Nada para Actualizar", {
                level: "info",
                title: "Nada por Actualizar ",
                autoClose: false
            });
        }
    },

    record_getAgente: function (aux) {
        var nombres = $("#filtroNombre").val();
        var apellidos = $("#filtroApellido").val();
        var subpuesto = $("#filtroSubPuesto").val();

        var fullname = nombres + apellidos;
        if (!/^\s+$/.test(nombres) && !/^\s+$/.test(apellidos)) {
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
                };

            if (subpuesto != "") {
                filter_arguments["filter"] = [
                    {
                        "nombre_completo_c": {
                            "$contains": nombres + " " + apellidos
                        },
                        "status": "Active",
                        "puestousuario_c": 27,
                        "subpuesto_c": subpuesto
                    }
                ];
            }
            else {
                filter_arguments["filter"] = [
                    {
                        "nombre_completo_c": {
                            "$contains": nombres + " " + apellidos
                        },
                        "status": "Active",
                        "puestousuario_c": 27,
                    }
                ];
            }

            this.agentes = [];
            app.api.call("read", app.api.buildURL("Users", null, null, filter_arguments), null, {
                success: _.bind(function (data) {
                    var count = Object.keys(data.records).length;
                    if (count > 20) {
                        for (var i = 0; i < 20; i++) {
                            data.records[i].access_hours_c = data.records[i].access_hours_c != "" ? JSON.parse(data.records[i].access_hours_c) : "";
                            this.agentes.push(data.records[i]);
                        }
                    }
                    else {
                        for (var i = 0; i < count; i++) {
                            data.records[i].access_hours_c = data.records[i].access_hours_c != "" ? JSON.parse(data.records[i].access_hours_c) : "";
                            this.agentes.push(data.records[i]);
                        }
                        //this.agentes = data.records;
                    }

                    //console.log(this.agentes);
                    //console.log("existen registros" + count);
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
                    $("#filtroSubPuesto").val(subpuesto);

                    //console.log("despues de rende" + this.agentes);
                }, this)
            });
        }
        else {
            app.alert.show('Sin valor', {
                level: 'info',
                title: 'Existen valores de búsqueda no validos',
                autoClose: true
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

    checkTextOnly: function () {
        app.alert.dismiss('Error_validacion_Campos');
        var nombre = $("#filtroNombre").val();
        var apaterno = $("#filtroApellido").val();

        var camponame = "";
        var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
        if (nombre != "" && nombre != undefined) {
            var comprueba = expresion.test(nombre);
            if (comprueba != true) {
                camponame = camponame + '<b>-Nombre<br></b>';
                ;
            }
        }
        if (apaterno != "" && apaterno != undefined) {
            var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
            var validaap = expresion.test(apaterno);
            if (validaap != true) {
                camponame = camponame + '<b>-Apellido Paterno<br></b>';
                ;
            }
        }
        if (camponame) {
            app.alert.show("Error_validacion_Campos", {
                level: "error",
                messages: 'Los siguientes campos no permiten caracteres especiales:<br>' + camponame,
                autoClose: false
            });
        }
    },

    validaSetHorario: function () {

        
        
        var errores = "";
        var val = 0;
    return errores;
    },

    
})