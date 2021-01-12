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
            var horas = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23];
            var minutos = [00, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55];
            var list_horas = '<option value="Bloqueado" selected >Bloqueado</option>';
            list_horas += '<option value="Libre" >Libre</option>';

            //var list_horas = '';

            for (var i = 0; i < horas.length; i++) {
                list_horas += '<option value=' + horas[i] + '>' + horas[i] + '</option>';
            }
            this.Horas = list_horas;

            var list_minutos = '<option value="00"  selected hidden>Min</option>';
            //var list_minutos = '';
            for (var j = 0; j < minutos.length; j++) {
                list_minutos += '<option value=' + minutos[j] + '>' + minutos[j] + '</option>';
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

        var respuesta = this.validaSetHorario();
        if (respuesta == "") {
            var parametros = context.seleccionados;
            var horario = '{"Monday":{"entrada":"' + $("#LHin").val() + ($("#LHin").val()!="Bloqueado" && $("#LHin").val()!="Libre" ? (":" + $("#LMin").val()) : "" ) +
                '","salida":"' + $("#LHout").val() + ($("#LHout").val()!="Bloqueado" && $("#LHout").val()!="Libre"?(":" + $("#LMout").val()) : "" ) + '"},' +
                '"Tuesday":{"entrada":"' + $("#MHin").val() + ($("#MHin").val()!="Bloqueado" && $("#MHin").val()!="Libre" ? (":" + $("#MMin").val()) : "" ) +
                '","salida":"' + $("#MHout").val() + ($("#MHout").val()!="Bloqueado" && $("#MHout").val()!="Libre"?(":" + $("#MMout").val()) : "" ) + '"},' +
                '"Wednesday":{"entrada":"' + $("#MiHin").val() + ($("#MiHin").val()!="Bloqueado" && $("#MiHin").val()!="Libre" ? (":" + $("#MiMin").val()) : "" )+
                '","salida":"' + $("#MiHout").val() + ($("#MiHout").val()!="Bloqueado" && $("#MiHout").val()!="Libre"?(":" + $("#MiMout").val()) : "" ) + '"},' +
                '"Thursday":{"entrada":"' + $("#JHin").val() + ($("#JHin").val()!="Bloqueado" && $("#JHin").val()!="Libre" ? (":" + $("#JMin").val()) : "" ) +
                '","salida":"' + $("#JHout").val() + ($("#JHout").val()!="Bloqueado" && $("#JHout").val()!="Libre"?(":" + $("#JMout").val()) : "" ) + '"},' +
                '"Friday":{"entrada":"' + $("#VHin").val() + ($("#VHin").val()!="Bloqueado" && $("#VHin").val()!="Libre" ? (":" + $("#VMin").val()) : "" ) +
                '","salida":"' + $("#VHout").val() + ($("#VHout").val()!="Bloqueado" && $("#VHout").val()!="Libre"?(":" + $("#VMout").val()) : "" ) + '"},' +
                '"Saturday":{"entrada":"' + $("#SHin").val() + ($("#SHin").val()!="Bloqueado" && $("#SHin").val()!="Libre" ? (":" + $("#SMin").val()) : "" ) +
                '","salida":"' + $("#SHout").val() + ($("#SHout").val()!="Bloqueado" && $("#SHout").val()!="Libre"?(":" + $("#SMout").val()) : "" ) + '"},' +
                '"Sunday":{"entrada":"' + $("#DHin").val() + ($("#DHin").val()!="Bloqueado" && $("#DHin").val()!="Libre" ? (":" + $("#DMin").val()) : "" ) +
                '","salida":"' + $("#DHout").val() + ($("#DHout").val()!="Bloqueado" && $("#DHout").val()!="Libre"?(":" + $("#DMout").val()) : "" ) + '"}}';

            console.log("Parametros " + parametros)
            if (parametros != "") {
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
                    level: 'error',
                    title: 'Selecciona un Asesor...'
                });
            }
        } else {
            app.alert.show("Error en Horario", {
                level: "error",
                title: "La hora de Salida no puede ser menor  que la hora de entrada: <br>" + respuesta,
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
        if (parametros != "") {
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

        var FLin = "2021/01/01 " + $("#LHin").val() + ":" + ($("#LMin").val() == "" ? '00' : $("#LMin").val()) + ":00";
        var FLout = "2021/01/01 " + $("#LHout").val() + ":" + ($("#LMout").val() == "" ? '00' : $("#LMout").val()) + ":00";
        var FMin = "2021/01/01 " + $("#MHin").val() + ":" + ($("#MMin").val() == "" ? '00' : $("#MMin").val()) + ":00";
        var FMout = "2021/01/01 " + $("#MHout").val() + ":" + ($("#MMout").val() == "" ? '00' : $("#MMout").val()) + ":00";
        var FMiin = "2021/01/01 " + $("#MiHin").val() + ":" + ($("#MiMin").val() == "" ? '00' : $("#MiMin").val()) + ":00";
        var FMiout = "2021/01/01 " + $("#MiHout").val() + ":" + ($("#MiMout").val() == "" ? '00' : $("#MiMout").val()) + ":00";
        var FJin = "2021/01/01 " + $("#JHin").val() + ":" + ($("#JMin").val() == "" ? '00' : $("#JMin").val()) + ":00";
        var FJout = "2021/01/01 " + $("#JHout").val() + ":" + ($("#JMout").val() == "" ? '00' : $("#JMout").val()) + ":00";
        var FVin = "2021/01/01 " + $("#VHin").val() + ":" + ($("#VMin").val() == "" ? '00' : $("#VMin").val()) + ":00";
        var FVout = "2021/01/01 " + $("#VHout").val() + ":" + ($("#VMout").val() == "" ? '00' : $("#VMout").val()) + ":00";
        var FSin = "2021/01/01 " + $("#SHin").val() + ":" + ($("#SMin").val() == "" ? '00' : $("#SMin").val()) + ":00";
        var FSout = "2021/01/01 " + $("#SHout").val() + ":" + ($("#SMout").val() == "" ? '00' : $("#SMout").val()) + ":00";
        var FDin = "2021/01/01 " + $("#DHin").val() + ":" + ($("#DMin").val() == "" ? '00' : $("#DMin").val()) + ":00";
        var FDout = "2021/01/01 " + $("#DHout").val() + ":" + ($("#DMout").val() == "" ? '00' : $("#DMout").val()) + ":00";


        var errores = "";
        if (($("#LHin").val() != "Bloqueado" && $("#LHout").val() != "Bloqueado") && ($("#LHin").val() != "Libre" && $("#LHout").val() != "Libre")) {
            var Lin = (new Date(FLin).getTime() / 1000);
            var Lout = (new Date(FLout).getTime() / 1000);
            if (Lin > Lout) {
                errores = errores + '<b>- Lunes<br></b>';
            }
        }
        if (($("#MHin").val() != "Bloqueado" && $("#MHout").val() != "Bloqueado") && ($("#MHin").val() != "Libre" && $("#MHout").val() != "Libre")) {
            var Min = (new Date(FMin).getTime() / 1000);
            var Mout = (new Date(FMout).getTime() / 1000);
            if (Min > Mout) {
                errores = errores + '<b>- Martes<br></b>';
            }
        }
        if (($("#MiHin").val() != "Bloqueado" && $("#MiHout").val() != "Bloqueado") && ($("#MiHin").val() != "Libre" && $("#MiHout").val() != "Libre")) {
            var Miin = (new Date(FMiin).getTime() / 1000);
            var Miout = (new Date(FMiout).getTime() / 1000);
            if (Miin > Miout) {
                errores = errores + '<b>- Miércoles<br></b>';
            }
        }
        if (($("#JHin").val() != "Bloqueado" && $("#JHout").val() != "Bloqueado") && ($("#JHin").val() != "Libre" && $("#JHout").val() != "Libre")) {
            var Jin = (new Date(FJin).getTime() / 1000);
            var Jout = (new Date(FJout).getTime() / 1000);
            if (Jin > Jout) {
                errores = errores + '<b>- Jueves<br></b>';
            }
        }
        if (($("#VHin").val() != "Bloqueado" && $("#VHout").val() != "Bloqueado") && ($("#VHin").val() != "Libre" && $("#VHout").val() != "Libre")) {
            var Vin = (new Date(FVin).getTime() / 1000);
            var Vout = (new Date(FVout).getTime() / 1000);
            if (Vin > Vout) {
                errores = errores + '<b>- Viernes<br></b>';
            }
        }
        if (($("#SHin").val() != "Bloqueado" && $("#SHout").val() != "Bloqueado") && ($("#SHin").val() != "Libre" && $("#SHout").val() != "Libre")) {
            var Sin = (new Date(FSin).getTime() / 1000);
            var Sout = (new Date(FSout).getTime() / 1000);
            if (Sin > Sout) {
                errores = errores + '<b>- Sábado<br></b>';
            }
        }
        if (($("#DHin").val() != "Bloqueado" && $("#DHout").val() != "Bloqueado") && ($("#DHin").val() != "Libre" && $("#DHout").val() != "Libre")) {
            var Din = (new Date(FDin).getTime() / 1000);
            var Dout = (new Date(FDout).getTime() / 1000);
            if (Din > Dout) {
                errores = errores + '<b>- Domingo<br></b>';
            }
        }
        return errores;
    }

})