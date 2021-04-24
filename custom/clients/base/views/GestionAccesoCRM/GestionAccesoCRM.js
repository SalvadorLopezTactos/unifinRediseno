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
        'change #filtroNombre': 'checkTextOnly',
        'change #filtroApellido': 'checkTextOnly',

        /* Lunes */
        'click #bloqueadoL': 'bloquea_HLunes',
        'click #libreL': 'libre_HLunes',
        'click #definirL': 'definir_HLunes',
        /* Martes */
        'click #bloqueadoM': 'bloquea_HMartes',
        'click #libreM': 'libre_HMartes',
        'click #definirM': 'definir_HMartes',
        /* Miercoles */
        'click #bloqueadoMi': 'bloquea_HMiercoles',
        'click #libreMi': 'libre_HMiercoles',
        'click #definirMi': 'definir_HMiercoles',
        /* Jueves */
        'click #bloqueadoJ': 'bloquea_HJueves',
        'click #libreJ': 'libre_HJueves',
        'click #definirJ': 'definir_HJueves',
        /* Viernes */
        'click #bloqueadoV': 'bloquea_HViernes',
        'click #libreV': 'libre_HViernes',
        'click #definirV': 'definir_HViernes',
        /* Sabado */
        'click #bloqueadoS': 'bloquea_HSabado',
        'click #libreS': 'libre_HSabado',
        'click #definirS': 'definir_HSabado',
        /* Domingo */
        'click #bloqueadoD': 'bloquea_HDomingo',
        'click #libreD': 'libre_HDomingo',
        'click #definirD': 'definir_HDomingo',

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
    /* variables Lunes */
    bloqL: "",
    libL: "",
    defL: "",
    lhin: "",
    lhout: "",
    /* variables Martes */
    bloqM: "",
    libM: "",
    defM: "",
    mhin: "",
    mhout: "",
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

                Object.keys(agentesTel).forEach(function (key) {
                    //console.log("id agente tele " + agentesTel[key].id);
                    if (parametros[0] == agentesTel[key].id) {
                        if (agentesTel[key].access_hours_c != "") {
                            //console.log("id agente tele " + agentesTel[key].id);
                            var lin = agentesTel[key].access_hours_c.Monday.entrada;
                            var lcomida = agentesTel[key].access_hours_c.Monday.comida;
                            var lregreso = agentesTel[key].access_hours_c.Monday.regreso;
                            var lout = agentesTel[key].access_hours_c.Monday.salida;
                            var min = agentesTel[key].access_hours_c.Tuesday.entrada;
                            var mcomida = agentesTel[key].access_hours_c.Tuesday.comida;
                            var mregreso = agentesTel[key].access_hours_c.Tuesday.regreso;
                            var mout = agentesTel[key].access_hours_c.Tuesday.salida;
                            var miin = agentesTel[key].access_hours_c.Wednesday.entrada;
                            var micomida = agentesTel[key].access_hours_c.Wednesday.comida;
                            var miregreso = agentesTel[key].access_hours_c.Wednesday.regreso;
                            var miout = agentesTel[key].access_hours_c.Wednesday.salida;
                            var jin = agentesTel[key].access_hours_c.Thursday.entrada;
                            var jcomida = agentesTel[key].access_hours_c.Thursday.comida;
                            var jregreso = agentesTel[key].access_hours_c.Thursday.regreso;
                            var jout = agentesTel[key].access_hours_c.Thursday.salida;
                            var vin = agentesTel[key].access_hours_c.Friday.entrada;
                            var vcomida = agentesTel[key].access_hours_c.Friday.comida;
                            var vregreso = agentesTel[key].access_hours_c.Friday.regreso;
                            var vout = agentesTel[key].access_hours_c.Friday.salida;
                            var sin = agentesTel[key].access_hours_c.Saturday.entrada;
                            var scomida = agentesTel[key].access_hours_c.Saturday.comida;
                            var sregreso = agentesTel[key].access_hours_c.Saturday.regreso;
                            var sout = agentesTel[key].access_hours_c.Saturday.salida;
                            var din = agentesTel[key].access_hours_c.Sunday.entrada;
                            var dcomida = agentesTel[key].access_hours_c.Sunday.comida;
                            var dregreso = agentesTel[key].access_hours_c.Sunday.regreso;
                            var dout = agentesTel[key].access_hours_c.Sunday.salida;
                            context.cargaDatos(lin, lcomida, lregreso, lout, min, mcomida, mregreso, mout, miin, micomida, miregreso, miout, jin, jcomida, jregreso, jout, vin, vcomida, vregreso, vout, sin, scomida, sregreso, sout, din, dcomida, dregreso, dout);
                        }
                        else {
                            context.naceBloqueado();
                        }
                    }
                });
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

    naceBloqueado: function () {

        /* Nace como bloqueado */
        $("#bloqueadoL").prop("checked", true);
        $("#LHin").attr("disabled", true);
        $("#LHcomida").attr("disabled", true);
        $("#LHregreso").attr("disabled", true);
        $("#LHout").attr("disabled", true);
        $("#bloqueadoM").prop("checked", true);
        $("#MHin").attr("disabled", true);
        $("#MHcomida").attr("disabled", true);
        $("#MHregreso").attr("disabled", true);
        $("#MHout").attr("disabled", true);
        $("#bloqueadoMi").prop("checked", true);
        $("#MiHin").attr("disabled", true);
        $("#MiHcomida").attr("disabled", true);
        $("#MiHregreso").attr("disabled", true);
        $("#MiHout").attr("disabled", true);
        $("#bloqueadoJ").prop("checked", true);
        $("#JHin").attr("disabled", true);
        $("#JHcomida").attr("disabled", true);
        $("#JHregreso").attr("disabled", true);
        $("#JHout").attr("disabled", true);
        $("#bloqueadoV").prop("checked", true);
        $("#VHin").attr("disabled", true);
        $("#VHcomida").attr("disabled", true);
        $("#VHregreso").attr("disabled", true);
        $("#VHout").attr("disabled", true);
        $("#bloqueadoS").prop("checked", true);
        $("#SHin").attr("disabled", true);
        $("#SHcomida").attr("disabled", true);
        $("#SHregreso").attr("disabled", true);
        $("#SHout").attr("disabled", true);
        $("#bloqueadoD").prop("checked", true);
        $("#DHin").attr("disabled", true);
        $("#DHcomida").attr("disabled", true);
        $("#DHregreso").attr("disabled", true);
        $("#DHout").attr("disabled", true);
    },
    closeModal: function () {
        //      console.log("closeModal - clic");
        var modal = $('#myModal');
        if (modal) {
            modal.hide();
        }
        this.seleccionados = [];
        $("#crossSeleccionados").val("");

    },

    updateHorarios: function () {
        context = this;
        if ($('#updateL').is(":checked") || $('#updateM').is(":checked") || $('#updateMi').is(":checked")
            || $('#updateJ').is(":checked") || $('#updateV').is(":checked") || $('#updateS').is(":checked")
            || $('#updateD').is(":checked")) {
            var respuesta = this.validaSetHorario();
            if (respuesta == "") {
                var parametros = context.seleccionados;
                var horario = '{"Monday":{"entrada":"' + ($('#bloqueadoL').is(":checked") ? "Bloqueado" : ($('#libreL').is(":checked") ? "Libre" : $("#LHin").val())) +
                    '","comida":"' + ($('#bloqueadoL').is(":checked") ? "Bloqueado" : ($('#libreL').is(":checked") ? "Libre" : $("#LHcomida").val())) +
                    '","regreso":"' + ($('#bloqueadoL').is(":checked") ? "Bloqueado" : ($('#libreL').is(":checked") ? "Libre" : $("#LHregreso").val())) +
                    '","salida":"' + ($('#bloqueadoL').is(":checked") ? "Bloqueado" : ($('#libreL').is(":checked") ? "Libre" : $("#LHout").val())) + '","update":"' + $('#updateL').is(":checked") + '"},' +
                    '"Tuesday":{"entrada":"' + ($('#bloqueadoM').is(":checked") ? "Bloqueado" : ($('#libreM').is(":checked") ? "Libre" : $("#MHin").val())) +
                    '","comida":"' + ($('#bloqueadoM').is(":checked") ? "Bloqueado" : ($('#libreM').is(":checked") ? "Libre" : $("#MHcomida").val())) +
                    '","regreso":"' + ($('#bloqueadoM').is(":checked") ? "Bloqueado" : ($('#libreM').is(":checked") ? "Libre" : $("#MHregreso").val())) +
                    '","salida":"' + ($('#bloqueadoM').is(":checked") ? "Bloqueado" : ($('#libreM').is(":checked") ? "Libre" : $("#MHout").val())) + '","update":"' + $('#updateM').is(":checked") + '"},' +
                    '"Wednesday":{"entrada":"' + ($('#bloqueadoMi').is(":checked") ? "Bloqueado" : ($('#libreMi').is(":checked") ? "Libre" : $("#MiHin").val())) +
                    '","comida":"' + ($('#bloqueadoMi').is(":checked") ? "Bloqueado" : ($('#libreMi').is(":checked") ? "Libre" : $("#MiHcomida").val())) +
                    '","regreso":"' + ($('#bloqueadoMi').is(":checked") ? "Bloqueado" : ($('#libreMi').is(":checked") ? "Libre" : $("#MiHregreso").val())) +
                    '","salida":"' + ($('#bloqueadoMi').is(":checked") ? "Bloqueado" : ($('#libreMi').is(":checked") ? "Libre" : $("#MiHout").val())) + '","update":"' + $('#updateMi').is(":checked") + '"},' +
                    '"Thursday":{"entrada":"' + ($('#bloqueadoJ').is(":checked") ? "Bloqueado" : ($('#libreJ').is(":checked") ? "Libre" : $("#JHin").val())) +
                    '","comida":"' + ($('#bloqueadoJ').is(":checked") ? "Bloqueado" : ($('#libreJ').is(":checked") ? "Libre" : $("#JHcomida").val())) +
                    '","regreso":"' + ($('#bloqueadoJ').is(":checked") ? "Bloqueado" : ($('#libreJ').is(":checked") ? "Libre" : $("#JHregreso").val())) +
                    '","salida":"' + ($('#bloqueadoJ').is(":checked") ? "Bloqueado" : ($('#libreJ').is(":checked") ? "Libre" : $("#JHout").val())) + '","update":"' + $('#updateJ').is(":checked") + '"},' +
                    '"Friday":{"entrada":"' + ($('#bloqueadoV').is(":checked") ? "Bloqueado" : ($('#libreV').is(":checked") ? "Libre" : $("#VHin").val())) +
                    '","comida":"' + ($('#bloqueadoV').is(":checked") ? "Bloqueado" : ($('#libreV').is(":checked") ? "Libre" : $("#VHcomida").val())) +
                    '","regreso":"' + ($('#bloqueadoV').is(":checked") ? "Bloqueado" : ($('#libreV').is(":checked") ? "Libre" : $("#VHregreso").val())) +
                    '","salida":"' + ($('#bloqueadoV').is(":checked") ? "Bloqueado" : ($('#libreV').is(":checked") ? "Libre" : $("#VHout").val())) + '","update":"' + $('#updateV').is(":checked") + '"},' +
                    '"Saturday":{"entrada":"' + ($('#bloqueadoS').is(":checked") ? "Bloqueado" : ($('#libreS').is(":checked") ? "Libre" : $("#SHin").val())) +
                    '","comida":"' + ($('#bloqueadoS').is(":checked") ? "Bloqueado" : ($('#libreS').is(":checked") ? "Libre" : $("#SHcomida").val())) +
                    '","regreso":"' + ($('#bloqueadoS').is(":checked") ? "Bloqueado" : ($('#libreS').is(":checked") ? "Libre" : $("#SHregreso").val())) +
                    '","salida":"' + ($('#bloqueadoS').is(":checked") ? "Bloqueado" : ($('#libreS').is(":checked") ? "Libre" : $("#SHout").val())) + '","update":"' + $('#updateS').is(":checked") + '"},' +
                    '"Sunday":{"entrada":"' + ($('#bloqueadoD').is(":checked") ? "Bloqueado" : ($('#libreD').is(":checked") ? "Libre" : $("#DHin").val())) +
                    '","comida":"' + ($('#bloqueadoD').is(":checked") ? "Bloqueado" : ($('#libreD').is(":checked") ? "Libre" : $("#DHcomida").val())) +
                    '","regreso":"' + ($('#bloqueadoD').is(":checked") ? "Bloqueado" : ($('#libreD').is(":checked") ? "Libre" : $("#DHregreso").val())) +
                    '","salida":"' + ($('#bloqueadoD').is(":checked") ? "Bloqueado" : ($('#libreD').is(":checked") ? "Libre" : $("#DHout").val())) + '","update":"' + $('#updateD').is(":checked") + '"}}';

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

    excluirHorarios: function () {
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
        var Params = {
            'seleccionados': parametros,
            'horario': "",
            'excluir': true
        };
        app.alert.show('Actualizando', {
            level: 'process',
            title: 'Actualizando...'
        });
        var dnbProfileUrl = app.api.buildURL("updateAsesores", '', {}, {});
        app.api.call("create", dnbProfileUrl, {data: Params}, {
            success: _.bind(function (data) {
                app.alert.dismiss('Actualizando');
                //console.log(data);
                if (data) {
                    this.closeModal();
                    this.record_getAgente();
                }

            }, this)
        });

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

        var FLin = "2021/01/01 " + $("#LHin").val();
        var FLcomida = "2021/01/01 " +  (($("#LHcomida").val() == "") ? "00:00" : $("#LHcomida").val());
        var FLregreso = "2021/01/01 " + (($("#LHregreso").val() == "") ? "00:00" : $("#LHregreso").val());
        var FLout = "2021/01/01 " + $("#LHout").val();
        var FMin = "2021/01/01 " + $("#MHin").val();
        var FMcomida = "2021/01/01 " + (($("#MHcomida").val() == "") ? "00:00" : $("#MHcomida").val());
        var FMregreso = "2021/01/01 " + (($("#MHregreso").val() == "") ? "00:00" : $("#MHregreso").val());
        var FMout = "2021/01/01 " + $("#MHout").val();
        var FMiin = "2021/01/01 " + $("#MiHin").val();
        var FMicomida = "2021/01/01 " + (($("#MiHcomida").val() == "") ? "00:00" : $("#MiHcomida").val());
        var FMiregreso = "2021/01/01 " + (($("#MiHregreso").val() == "") ? "00:00" : $("#MiHregreso").val());
        var FMiout = "2021/01/01 " + $("#MiHout").val();
        var FJin = "2021/01/01 " + $("#JHin").val();
        var FJcomida = "2021/01/01 " + (($("#JHcomida").val() == "") ? "00:00" : $("#JHcomida").val());
        var FJregreso = "2021/01/01 " + (($("#JHregreso").val() == "") ? "00:00" : $("#JHregreso").val());
        var FJout = "2021/01/01 " + $("#JHout").val();
        var FVin = "2021/01/01 " + $("#VHin").val();
        var FVcomida = "2021/01/01 " + (($("#VHcomida").val() == "") ? "00:00" : $("#VHcomida").val());
        var FVregreso = "2021/01/01 " + (($("#VHregreso").val() == "") ? "00:00" : $("#VHregreso").val());
        var FVout = "2021/01/01 " + $("#VHout").val();
        var FSin = "2021/01/01 " + $("#SHin").val();
        var FScomida = "2021/01/01 " + (($("#SHcomida").val() == "") ? "00:00" : $("#SHcomida").val());
        var FSregreso = "2021/01/01 " + (($("#SHregreso").val() == "") ? "00:00" : $("#SHregreso").val());
        var FSout = "2021/01/01 " + $("#SHout").val();
        var FDin = "2021/01/01 " + $("#DHin").val();
        var FDcomida = "2021/01/01 " + (($("#DHcomida").val() == "") ? "00:00" : $("#DHcomida").val());
        var FDregreso = "2021/01/01 " + (($("#DHregreso").val() == "") ? "00:00" : $("#DHregreso").val());
        var FDout = "2021/01/01 " + $("#DHout").val();

        var errores = "";
        var val = 0;
        if (!$('#bloqueadoL').is(":checked") && !$('#libreL').is(":checked") && $('#definirL').is(":checked")) {
            var Lin = (new Date(FLin).getTime() / 1000);
            var Lout = (new Date(FLout).getTime() / 1000);
            var Lcomida = (new Date(FLcomida).getTime() / 1000);
            var Lregreso = (new Date(FLregreso).getTime() / 1000);
            if (Lin > Lout) {
                errores = errores + 'Hora de Inicio es mayor a la Salida<br>';
                val = 1;
            }
            if($("#LHcomida").val() != "" && $("#LHregreso").val() != ""){
                if (Lin > Lcomida || Lin > Lregreso ) {
                    errores = errores + 'Hora de inicio es mayor a las horas de comida<br>';
                    val = 1;
                }
                if (Lcomida > Lout || Lregreso > Lout) {
                    errores = errores + 'Hora de salida es menor a las horas de comida<br>';
                    val = 1;
                }
                if (Lcomida > Lregreso ) {
                    errores = errores + 'Hora de comida es mayor a la de regreso<br>';
                    val = 1;
                }
            }else if($("#LHcomida").val() != "" && $("#LHregreso").val() == ""){
                errores = errores + 'Hora de regreso es necesario cuando se tiene hora de comida<br>';
                val = 1;
            }else if($("#LHcomida").val() == "" && $("#LHregreso").val() != ""){
                errores = errores + 'Hora de comida es necesario cuando se tiene hora de regreso<br>';
                val = 1;
            }
            if (val == 1) {
                errores = errores + '<b>- Lunes<br></b>';
            }
        }

        val=0;
        if (!$('#bloqueadoM').is(":checked") && !$('#libreM').is(":checked") && $('#definirM').is(":checked")) {
            var Min = (new Date(FMin).getTime() / 1000);
            var Mout = (new Date(FMout).getTime() / 1000);
            var Mcomida = (new Date(FMcomida).getTime() / 1000);
            var Mregreso = (new Date(FMregreso).getTime() / 1000);
            if (Min > Mout) {
                errores = errores + 'Hora de Inicio es mayor a la Salida<br>';
                val = 1;
            }
            if($("#MHcomida").val() != "" && $("#MHregreso").val() != ""){
                if (Min > Mcomida || Min > Mregreso ) {
                    errores = errores + 'Hora de inicio es mayor a las horas de comida<br>';
                    val = 1;
                }
                if (Mcomida > Mout || Mregreso > Mout) {
                    errores = errores + 'Hora de salida es menor a las horas de comida<br>';
                    val = 1;
                }
                if (Mcomida > Mregreso ) {
                    errores = errores + 'Hora de comida es mayor a la de regreso<br>';
                    val = 1;
                }
            }else if($("#MHcomida").val() != "" && $("#MHregreso").val() == ""){
                errores = errores + 'Hora de regreso es necesario cuando se tiene hora de comida<br>';
                val = 1;
            }else if($("#MHcomida").val() == "" && $("#MHregreso").val() != ""){
                errores = errores + 'Hora de comida es necesario cuando se tiene hora de regreso<br>';
                val = 1;
            }
            if (val == 1) {
                errores = errores + '<b>- Martes<br></b>';
            }
        }

        val = 0;
        if (!$('#bloqueadoMi').is(":checked") && !$('#libreMi').is(":checked") && $('#definirMi').is(":checked")) {
            var Miin = (new Date(FMiin).getTime() / 1000);
            var Miout = (new Date(FMiout).getTime() / 1000);
            var Micomida = (new Date(FMicomida).getTime() / 1000);
            var Miregreso = (new Date(FMiregreso).getTime() / 1000);
            
            if (Miin > Miout) {
                errores = errores + 'Hora de Inicio es mayor a la Salida<br>';
                val = 1;
            }
            if($("#MiHcomida").val() != "" && $("#MiHregreso").val() != ""){
                if (Miin > Micomida || Miin > Miregreso ) {
                    errores = errores + 'Hora de inicio es mayor a las horas de comida<br>';
                    val = 1;
                }
                if (Micomida > Miout || Miregreso > Miout) {
                    errores = errores + 'Hora de salida es menor a las horas de comida<br>';
                    val = 1;
                }
                if (Micomida > Miregreso ) {
                    errores = errores + 'Hora de comida es mayor a la de regreso<br>';
                    val = 1;
                }
            }else if($("#MiHcomida").val() != "" && $("#MiHregreso").val() == ""){
                errores = errores + 'Hora de regreso es necesario cuando se tiene hora de comida<br>';
                val = 1;
            }else if($("#MiHcomida").val() == "" && $("#MiHregreso").val() != ""){
                errores = errores + 'Hora de comida es necesario cuando se tiene hora de regreso<br>';
                val = 1;
            }
            if (val == 1) {
                errores = errores + '<b>- Míercoles<br></b>';
            }
        }
        val=0;
        if (!$('#bloqueadoJ').is(":checked") && !$('#libreJ').is(":checked") && $('#definirJ').is(":checked")) {
            var Jin = (new Date(FJin).getTime() / 1000);
            var Jout = (new Date(FJout).getTime() / 1000);
            var Jcomida = (new Date(FJcomida).getTime() / 1000);
            var Jregreso = (new Date(FJregreso).getTime() / 1000);
            if (Jin > Jout) {
                errores = errores + 'Hora de Inicio es mayor a la Salida<br>';
                val = 1;
            }
            if($("#JHcomida").val() != "" && $("#JHregreso").val() != ""){
                if (Jin > Jcomida || Jin > Jregreso ) {
                    errores = errores + 'Hora de inicio es mayor a las horas de comida<br>';
                    val = 1;
                }
                if (Jcomida > Jout || Jregreso > Jout) {
                    errores = errores + 'Hora de salida es menor a las horas de comida<br>';
                    val = 1;
                }
                if (Jcomida > Jregreso ) {
                    errores = errores + 'Hora de comida es mayor a la de regreso<br>';
                    val = 1;
                }
            }else if($("#JHcomida").val() != "" && $("#JHregreso").val() == ""){
                errores = errores + 'Hora de regreso es necesario cuando se tiene hora de comida<br>';
                val = 1;
            }else if($("#JHcomida").val() == "" && $("#JHregreso").val() != ""){
                errores = errores + 'Hora de comida es necesario cuando se tiene hora de regreso<br>';
                val = 1;
            }
            if (val == 1) {
                errores = errores + '<b>- Jueves<br></b>';
            }
        }

        val = 0;
        if (!$('#bloqueadoV').is(":checked") && !$('#libreV').is(":checked") && $('#definirV').is(":checked")) {
            var Vin = (new Date(FVin).getTime() / 1000);
            var Vout = (new Date(FVout).getTime() / 1000);
            var Vcomida = (new Date(FVcomida).getTime() / 1000);
            var Vregreso = (new Date(FVregreso).getTime() / 1000);
            
            if (Vin > Vout) {
                errores = errores + 'Hora de Inicio es mayor a la Salida<br>';
                val = 1;
            }
            if($("#VHcomida").val() != "" && $("#VHregreso").val() != ""){
                if (Vin > Vcomida || Vin > Vregreso ) {
                    errores = errores + 'Hora de inicio es mayor a las horas de comida<br>';
                    val = 1;
                }
                if (Vcomida > Vout || Vregreso > Vout) {
                    errores = errores + 'Hora de salida es menor a las horas de comida<br>';
                    val = 1;
                }
                if (Vcomida > Vregreso ) {
                    errores = errores + 'Hora de comida es mayor a la de regreso<br>';
                    val = 1;
                }
            }else if($("#VHcomida").val() != "" && $("#VHregreso").val() == ""){
                errores = errores + 'Hora de regreso es necesario cuando se tiene hora de comida<br>';
                val = 1;
            }else if($("#VHcomida").val() == "" && $("#VHregreso").val() != ""){
                errores = errores + 'Hora de comida es necesario cuando se tiene hora de regreso<br>';
                val = 1;
            }
            if (val == 1) {
                errores = errores + '<b>- Viernes<br></b>';
            }
        }

        val =0;
        if (!$('#bloqueadoS').is(":checked") && !$('#libreS').is(":checked") && $('#definirS').is(":checked")) {
            var Sin = (new Date(FSin).getTime() / 1000);
            var Sout = (new Date(FSout).getTime() / 1000);
            var Scomida = (new Date(FScomida).getTime() / 1000);
            var Sregreso = (new Date(FSregreso).getTime() / 1000);
            
            if (Sin > Sout) {
                errores = errores + 'Hora de Inicio es mayor a la Salida<br>';
                val = 1;
            }
            if($("#SHcomida").val() != "" && $("#SHregreso").val() != ""){
                if (Sin > Scomida || Sin > Sregreso ) {
                    errores = errores + 'Hora de inicio es mayor a las horas de comida<br>';
                    val = 1;
                }
                if (Scomida > Sout || Sregreso > Sout) {
                    errores = errores + 'Hora de salida es menor a las horas de comida<br>';
                    val = 1;
                }
                if (Scomida > Sregreso ) {
                    errores = errores + 'Hora de comida es mayor a la de regreso<br>';
                    val = 1;
                }
            }else if($("#SHcomida").val() != "" && $("#SHregreso").val() == ""){
                errores = errores + 'Hora de regreso es necesario cuando se tiene hora de comida<br>';
                val = 1;
            }else if($("#SHcomida").val() == "" && $("#SHregreso").val() != ""){
                errores = errores + 'Hora de comida es necesario cuando se tiene hora de regreso<br>';
                val = 1;
            }
            if (val == 1) {
                errores = errores + '<b>- Sábado<br></b>';
            }
        }

        val = 0;
        if (!$('#bloqueadoD').is(":checked") && !$('#libreD').is(":checked") && $('#definirD').is(":checked")) {
            var Din = (new Date(FDin).getTime() / 1000);
            var Dout = (new Date(FDout).getTime() / 1000);
            var Dcomida = (new Date(FDcomida).getTime() / 1000);
            var Dregreso = (new Date(FDregreso).getTime() / 1000);
            if (Din > Dout) {
                errores = errores + 'Hora de Inicio es mayor a la Salida<br>';
                val = 1;
            }
            if($("#DHcomida").val() != "" && $("#DHregreso").val() != ""){
                if (Din > Dcomida || Din > Dregreso ) {
                    errores = errores + 'Hora de inicio es mayor a las horas de comida<br>';
                    val = 1;
                }
                if (Dcomida > Dout || Dregreso > Dout) {
                    errores = errores + 'Hora de salida es menor a las horas de comida<br>';
                    val = 1;
                }
                if (Dcomida > Dregreso ) {
                    errores = errores + 'Hora de comida es mayor a la de regreso<br>';
                    val = 1;
                }
            }else if($("#DHcomida").val() != "" && $("#DHregreso").val() == ""){
                errores = errores + 'Hora de regreso es necesario cuando se tiene hora de comida<br>';
                val = 1;
            }else if($("#DHcomida").val() == "" && $("#DHregreso").val() != ""){
                errores = errores + 'Hora de comida es necesario cuando se tiene hora de regreso<br>';
                val = 1;
            }
            if (val == 1) {
                errores = errores + '<b>- Domingo<br></b>';
            }
        }
        return errores;
    },

    cargaDatos: function (Lin, Lcomida, Lregreso, Lout, Min, Mcomida, Mregreso, Mout, Miin, Micomida, Miregreso, Miout, Jin, Jcomida, Jregreso, Jout, Vin, Vcomida, Vregreso, Vout, Sin, Scomida, Sregreso, Sout, Din, Dcomida, Dregreso, Dout) {
        if (Lin == "Bloqueado") {
            $("#bloqueadoL").prop("checked", true);
            $("#LHin").attr("disabled", true);
            $("#LHout").attr("disabled", true);
            $("#LHcomida").attr("disabled", true);
            $("#LHregreso").attr("disabled", true);
        } else if (Lin == "Libre") {
            $("#libreL").prop("checked", true);
            $("#LHin").attr("disabled", true);
            $("#LHout").attr("disabled", true);
            $("#LHcomida").attr("disabled", true);
            $("#LHregreso").attr("disabled", true);
        }
        else {
            $("#definirL").prop("checked", true);
            $("#LHin").val(Lin);
            $("#LHout").val(Lout);
            $("#LHcomida").val(Lcomida);
            $("#LHregreso").val(Lregreso);
        }

        if (Min == "Bloqueado") {
            $("#bloqueadoM").prop("checked", true);
            $("#MHin").attr("disabled", true);
            $("#MHout").attr("disabled", true);
            $("#MHcomida").attr("disabled", true);
            $("#MHregreso").attr("disabled", true);
        } else if (Min == "Libre") {
            $("#libreM").prop("checked", true);
            $("#MHin").attr("disabled", true);
            $("#MHout").attr("disabled", true);
            $("#MHcomida").attr("disabled", true);
            $("#MHregreso").attr("disabled", true);
        }
        else {
            $("#definirM").prop("checked", true);
            $("#MHin").val(Min);
            $("#MHout").val(Mout);
            $("#MHcomida").val(Mcomida);
            $("#MHregreso").val(Mregreso);
        }

        if (Miin == "Bloqueado") {
            $("#bloqueadoMi").prop("checked", true);
            $("#MiHin").attr("disabled", true);
            $("#MiHout").attr("disabled", true);
            $("#MiHcomida").attr("disabled", true);
            $("#MiHregreso").attr("disabled", true);
        } else if (Miin == "Libre") {
            $("#libreMi").prop("checked", true);
            $("#MiHin").attr("disabled", true);
            $("#MiHout").attr("disabled", true);
            $("#MiHcomida").attr("disabled", true);
            $("#MiHregreso").attr("disabled", true);
        }
        else {
            $("#definirMi").prop("checked", true);
            $("#MiHin").val(Miin);
            $("#MiHout").val(Miout);
            $("#MiHcomida").val(Micomida);
            $("#MiHregreso").val(Miregreso);
        }

        if (Jin == "Bloqueado") {
            $("#bloqueadoJ").prop("checked", true);
            $("#JHin").attr("disabled", true);
            $("#JHout").attr("disabled", true);
            $("#JHcomida").attr("disabled", true);
            $("#JHregreso").attr("disabled", true);
        } else if (Jin == "Libre") {
            $("#libreJ").prop("checked", true);
            $("#JHin").attr("disabled", true);
            $("#JHout").attr("disabled", true);
            $("#JHcomida").attr("disabled", true);
            $("#JHregreso").attr("disabled", true);
        }
        else {
            $("#definirJ").prop("checked", true);
            $("#JHin").val(Jin);
            $("#JHout").val(Jout);
            $("#JHcomida").val(Jcomida);
            $("#JHregreso").val(Jregreso);
        }

        if (Vin == "Bloqueado") {
            $("#bloqueadoV").prop("checked", true);
            $("#VHin").attr("disabled", true);
            $("#VHout").attr("disabled", true);
            $("#VHcomida").attr("disabled", true);
            $("#VHregreso").attr("disabled", true);
        } else if (Vin == "Libre") {
            $("#libreV").prop("checked", true);
            $("#VHin").attr("disabled", true);
            $("#VHout").attr("disabled", true);
            $("#VHcomida").attr("disabled", true);
            $("#VHregreso").attr("disabled", true);
        }
        else {
            $("#definirV").prop("checked", true);
            $("#VHin").val(Vin);
            $("#VHout").val(Vout);
            $("#VHcomida").val(Vcomida);
            $("#VHregreso").val(Vregreso);
        }

        if (Sin == "Bloqueado") {
            $("#bloqueadoS").prop("checked", true);
            $("#SHin").attr("disabled", true);
            $("#SHout").attr("disabled", true);
            $("#SHcomida").attr("disabled", true);
            $("#SHregreso").attr("disabled", true);
        } else if (Sin == "Libre") {
            $("#libreS").prop("checked", true);
            $("#SHin").attr("disabled", true);
            $("#SHout").attr("disabled", true);
            $("#SHcomida").attr("disabled", true);
            $("#SHregreso").attr("disabled", true);
        }
        else {
            $("#definirS").prop("checked", true);
            $("#SHin").val(Sin);
            $("#SHout").val(Sout);
            $("#SHcomida").val(Scomida);
            $("#SHregreso").val(Sregreso);
        }

        if (Din == "Bloqueado") {
            $("#bloqueadoD").prop("checked", true);
            $("#DHin").attr("disabled", true);
            $("#DHout").attr("disabled", true);
            $("#DHcomida").attr("disabled", true);
            $("#DHregreso").attr("disabled", true);
        } else if (Din == "Libre") {
            $("#libreD").prop("checked", true);
            $("#DHin").attr("disabled", true);
            $("#DHout").attr("disabled", true);
            $("#DHcomida").attr("disabled", true);
            $("#DHregreso").attr("disabled", true);
        }
        else {
            $("#definirD").prop("checked", true);
            $("#DHin").val(Din);
            $("#DHout").val(Dout);
            $("#DHcomida").val(Dcomida);
            $("#DHregreso").val(Dregreso);
        }
    },

    bloquea_HLunes: function () {
        if ($('#bloqueadoL').is(":checked")) {
            $("#LHin").attr("disabled", true);
            $("#LHout").attr("disabled", true);
            $("#LHcomida").attr("disabled", true);
            $("#LHregreso").attr("disabled", true);
            $("#libreL").prop('checked', false);
            $("#definirL").prop('checked', false);
        }
        if (!$('#bloqueadoL').is(":checked") && !$('#libreL').is(":checked") && !$('#definirL').is(":checked")) {
            $("#bloqueadoL").prop('checked', true);
        }
    },
    libre_HLunes: function () {
        if ($('#libreL').is(":checked")) {
            $("#LHin").attr("disabled", true);
            $("#LHout").attr("disabled", true);
            $("#LHcomida").attr("disabled", true);
            $("#LHregreso").attr("disabled", true);
            $("#bloqueadoL").prop('checked', false);
            $("#definirL").prop('checked', false);
        }
        if (!$('#bloqueadoL').is(":checked") && !$('#libreL').is(":checked") && !$('#definirL').is(":checked")) {
            $("#libreL").prop('checked', true);
        }
    },
    definir_HLunes: function () {
        if ($('#definirL').is(":checked")) {
            $("#LHin").attr("disabled", false);
            $("#LHout").attr("disabled", false);
            $("#LHcomida").attr("disabled", false);
            $("#LHregreso").attr("disabled", false);
            $("#bloqueadoL").prop('checked', false);
            $("#libreL").prop('checked', false);
        }
        if (!$('#bloqueadoL').is(":checked") && !$('#libreL').is(":checked") && !$('#definirL').is(":checked")) {
            $("#definirL").prop('checked', true);
        }
    },

    bloquea_HMartes: function () {
        if ($('#bloqueadoM').is(":checked")) {
            $("#MHin").attr("disabled", true);
            $("#MHout").attr("disabled", true);
            $("#MHcomida").attr("disabled", true);
            $("#MHregreso").attr("disabled", true);
            $("#libreM").prop('checked', false);
            $("#definirM").prop('checked', false);
        }
        if (!$('#bloqueadoM').is(":checked") && !$('#libreM').is(":checked") && !$('#definirM').is(":checked")) {
            $("#bloqueadoM").prop('checked', true);
        }
    },
    libre_HMartes: function () {
        if ($('#libreM').is(":checked")) {
            $("#MHin").attr("disabled", true);
            $("#MHout").attr("disabled", true);
            $("#MHcomida").attr("disabled", true);
            $("#MHregreso").attr("disabled", true);
            $("#bloqueadoM").prop('checked', false);
            $("#definirM").prop('checked', false);
        }
        if (!$('#bloqueadoM').is(":checked") && !$('#libreM').is(":checked") && !$('#definirM').is(":checked")) {
            $("#libreM").prop('checked', true);
        }
    },
    definir_HMartes: function () {
        if ($('#definirM').is(":checked")) {
            $("#MHin").attr("disabled", false);
            $("#MHout").attr("disabled", false);
            $("#MHcomida").attr("disabled", false);
            $("#MHregreso").attr("disabled", false);
            $("#bloqueadoM").prop('checked', false);
            $("#libreM").prop('checked', false);
        }
        if (!$('#bloqueadoM').is(":checked") && !$('#libreM').is(":checked") && !$('#definirM').is(":checked")) {
            $("#definirM").prop('checked', true);
        }
    },

    bloquea_HMiercoles: function () {
        if ($('#bloqueadoMi').is(":checked")) {
            $("#MiHin").attr("disabled", true);
            $("#MiHout").attr("disabled", true);
            $("#MiHcomida").attr("disabled", true);
            $("#MiHregreso").attr("disabled", true);
            $("#libreMi").prop('checked', false);
            $("#definirMi").prop('checked', false);
        }
        if (!$('#bloqueadoMi').is(":checked") && !$('#libreMi').is(":checked") && !$('#definirMi').is(":checked")) {
            $("#bloqueadoMi").prop('checked', true);
        }
    },
    libre_HMiercoles: function () {
        if ($('#libreMi').is(":checked")) {
            $("#MiHin").attr("disabled", true);
            $("#MiHout").attr("disabled", true);
            $("#MiHcomida").attr("disabled", true);
            $("#MiHregreso").attr("disabled", true);
            $("#bloqueadoMi").prop('checked', false);
            $("#definirMi").prop('checked', false);
        }
        if (!$('#bloqueadoMi').is(":checked") && !$('#libreMi').is(":checked") && !$('#definirMi').is(":checked")) {
            $("#libreMi").prop('checked', true);
        }
    },
    definir_HMiercoles: function () {
        if ($('#definirMi').is(":checked")) {
            $("#MiHin").attr("disabled", false);
            $("#MiHout").attr("disabled", false);
            $("#MiHcomida").attr("disabled", false);
            $("#MiHregreso").attr("disabled", false);
            $("#bloqueadoMi").prop('checked', false);
            $("#libreMi").prop('checked', false);
        }
        if (!$('#bloqueadoMi').is(":checked") && !$('#libreMi').is(":checked") && !$('#definirMi').is(":checked")) {
            $("#definirMi").prop('checked', true);
        }
    },

    bloquea_HJueves: function () {
        if ($('#bloqueadoJ').is(":checked")) {
            $("#JHin").attr("disabled", true);
            $("#JHout").attr("disabled", true);
            $("#JHcomida").attr("disabled", true);
            $("#JHregreso").attr("disabled", true);
            $("#libreJ").prop('checked', false);
            $("#definirJ").prop('checked', false);
        }
        if (!$('#bloqueadoJ').is(":checked") && !$('#libreJ').is(":checked") && !$('#definirJ').is(":checked")) {
            $("#bloqueadoJ").prop('checked', true);
        }
    },
    libre_HJueves: function () {
        if ($('#libreJ').is(":checked")) {
            $("#JHin").attr("disabled", true);
            $("#JHout").attr("disabled", true);
            $("#JHcomida").attr("disabled", true);
            $("#JHregreso").attr("disabled", true);
            $("#bloqueadoJ").prop('checked', false);
            $("#definirJ").prop('checked', false);
        }
        if (!$('#bloqueadoJ').is(":checked") && !$('#libreJ').is(":checked") && !$('#definirJ').is(":checked")) {
            $("#libreJ").prop('checked', true);
        }
    },
    definir_HJueves: function () {
        if ($('#definirJ').is(":checked")) {
            $("#JHin").attr("disabled", false);
            $("#JHout").attr("disabled", false);
            $("#JHcomida").attr("disabled", false);
            $("#JHregreso").attr("disabled", false);
            $("#bloqueadoJ").prop('checked', false);
            $("#libreJ").prop('checked', false);
        }
        if (!$('#bloqueadoJ').is(":checked") && !$('#libreJ').is(":checked") && !$('#definirJ').is(":checked")) {
            $("#definirJ").prop('checked', true);
        }
    },

    bloquea_HViernes: function () {
        if ($('#bloqueadoV').is(":checked")) {
            $("#VHin").attr("disabled", true);
            $("#VHout").attr("disabled", true);
            $("#VHcomida").attr("disabled", true);
            $("#VHregreso").attr("disabled", true);
            $("#libreV").prop('checked', false);
            $("#definirV").prop('checked', false);
        }
        if (!$('#bloqueadoV').is(":checked") && !$('#libreV').is(":checked") && !$('#definirV').is(":checked")) {
            $("#bloqueadoV").prop('checked', true);
        }
    },
    libre_HViernes: function () {
        if ($('#libreV').is(":checked")) {
            $("#VHin").attr("disabled", true);
            $("#VHout").attr("disabled", true);
            $("#VHcomida").attr("disabled", true);
            $("#VHregreso").attr("disabled", true);
            $("#bloqueadoV").prop('checked', false);
            $("#definirV").prop('checked', false);
        }
        if (!$('#bloqueadoV').is(":checked") && !$('#libreV').is(":checked") && !$('#definirV').is(":checked")) {
            $("#libreV").prop('checked', true);
        }
    },
    definir_HViernes: function () {
        if ($('#definirV').is(":checked")) {
            $("#VHin").attr("disabled", false);
            $("#VHout").attr("disabled", false);
            $("#VHcomida").attr("disabled", false);
            $("#VHregreso").attr("disabled", false);
            $("#bloqueadoV").prop('checked', false);
            $("#libreV").prop('checked', false);
        }
        if (!$('#bloqueadoV').is(":checked") && !$('#libreV').is(":checked") && !$('#definirV').is(":checked")) {
            $("#definirV").prop('checked', true);
        }
    },

    bloquea_HSabado: function () {
        if ($('#bloqueadoS').is(":checked")) {
            $("#SHin").attr("disabled", true);
            $("#SHout").attr("disabled", true);
            $("#SHcomida").attr("disabled", true);
            $("#SHregreso").attr("disabled", true);
            $("#libreS").prop('checked', false);
            $("#definirS").prop('checked', false);
        }
        if (!$('#bloqueadoS').is(":checked") && !$('#libreS').is(":checked") && !$('#definirS').is(":checked")) {
            $("#bloqueadoS").prop('checked', true);
        }
    },
    libre_HSabado: function () {
        if ($('#libreS').is(":checked")) {
            $("#SHin").attr("disabled", true);
            $("#SHout").attr("disabled", true);
            $("#SHcomida").attr("disabled", true);
            $("#SHregreso").attr("disabled", true);
            $("#bloqueadoS").prop('checked', false);
            $("#definirS").prop('checked', false);
        }
        if (!$('#bloqueadoS').is(":checked") && !$('#libreS').is(":checked") && !$('#definirS').is(":checked")) {
            $("#libreS").prop('checked', true);
        }
    },
    definir_HSabado: function () {
        if ($('#definirS').is(":checked")) {
            $("#SHin").attr("disabled", false);
            $("#SHout").attr("disabled", false);
            $("#SHcomida").attr("disabled", false);
            $("#SHregreso").attr("disabled", false);
            $("#bloqueadoS").prop('checked', false);
            $("#libreS").prop('checked', false);
        }
        if (!$('#bloqueadoS').is(":checked") && !$('#libreS').is(":checked") && !$('#definirS').is(":checked")) {
            $("#definirS").prop('checked', true);
        }
    },

    bloquea_HDomingo: function () {
        if ($('#bloqueadoD').is(":checked")) {
            $("#DHin").attr("disabled", true);
            $("#DHout").attr("disabled", true);
            $("#DHcomida").attr("disabled", true);
            $("#DHregreso").attr("disabled", true);
            $("#libreD").prop('checked', false);
            $("#definirD").prop('checked', false);
        }
        if (!$('#bloqueadoD').is(":checked") && !$('#libreD').is(":checked") && !$('#definirD').is(":checked")) {
            $("#bloqueadoD").prop('checked', true);
        }
    },
    libre_HDomingo: function () {
        if ($('#libreD').is(":checked")) {
            $("#DHin").attr("disabled", true);
            $("#DHout").attr("disabled", true);
            $("#DHcomida").attr("disabled", true);
            $("#DHregreso").attr("disabled", true);
            $("#bloqueadoD").prop('checked', false);
            $("#definirD").prop('checked', false);
        }
        if (!$('#bloqueadoD').is(":checked") && !$('#libreD').is(":checked") && !$('#definirD').is(":checked")) {
            $("#libreD").prop('checked', true);
        }
    },
    definir_HDomingo: function () {
        if ($('#definirD').is(":checked")) {
            $("#DHin").attr("disabled", false);
            $("#DHout").attr("disabled", false);
            $("#DHcomida").attr("disabled", false);
            $("#DHregreso").attr("disabled", false);
            $("#bloqueadoD").prop('checked', false);
            $("#libreD").prop('checked', false);
        }
        if (!$('#bloqueadoD').is(":checked") && !$('#libreD').is(":checked") && !$('#definirD').is(":checked")) {
            $("#definirD").prop('checked', true);
        }
    },

})