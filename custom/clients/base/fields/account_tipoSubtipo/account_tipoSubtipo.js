({
    visible: false,
    initialize: function (options) {
        //Inicializa campo custom
        options = options || {};
        options.def = options.def || {};
        pipeacc=this;
        this._super('initialize', [options]);
        this.model.on('sync', this.tipoSubtipo_vista, this);
    },

    tipoSubtipo_vista: function () {
        // tipo_registro_cuenta_c
        //Y subtipo_registro_cuenta_c
        var tipoCuenta = this.model.get('tipo_registro_cuenta_c')
        var subtipoCuenta = this.model.get('subtipo_registro_cuenta_c')
        console.log(tipoCuenta);
        console.log(subtipoCuenta);
        if (tipoCuenta == 1) {
            $("#cell1").html("Lead");
            $("#cell2").html("Prospecto");
            $("#cell3").html("Cliente");
            $('#cell1').addClass('current');
            if (subtipoCuenta == 5) {
                $("#ST1").removeClass('ocult');
                $('#ST1').addClass('success');
                $("#ST1").html("En Calificación");
            }
            if (subtipoCuenta == 6) {
                $("#ST1").removeClass('ocult');
                $('#ST1').addClass('alerta');
                $("#ST1").html("No Viable");
            }
        }

        if (tipoCuenta == 2) {
            $("#cell1").html("Lead");
            $("#cell2").html("Prospecto");
            $("#cell3").html("Cliente");
            $('#cell2').addClass('current');
            $('#cell1').addClass('done');
            if (subtipoCuenta == 1) {
                $("#ST2").removeClass('ocult');
                $('#ST2').addClass('success');
                $("#ST2").html("Sin Contactar");
            }
            if (subtipoCuenta == 2) {
                $("#ST2").removeClass('ocult');
                $('#ST2').addClass('success');
                $("#ST2").html("Contactado");
            }
            if (subtipoCuenta == 7) {
                $("#ST2").removeClass('ocult');
                $('#ST2').addClass('success');
                $("#ST2").html("Interesado");
            }
            if (subtipoCuenta == 8) {
                $("#ST2").removeClass('ocult');
                $('#ST2').addClass('success');
                $("#ST2").html("Integración de Expediente");
            }
            if (subtipoCuenta == 9) {
                $("#ST2").removeClass('ocult');
                $('#ST2').addClass('success');
                $("#ST2").html("En Crédito");
            }
            if (subtipoCuenta == 10) {
                $("#ST2").removeClass('ocult');
                $('#ST2').addClass('error');
                $("#ST2").html("Rechazado");
            }
            if (subtipoCuenta == 12) {
                $("#ST2").removeClass('ocult');
                $('#ST2').addClass('success');
                $("#ST2").html("Con Línea");
            }
        }

        if (tipoCuenta == 3) {
            $("#cell1").html("Lead");
            $("#cell2").html("Prospecto");
            $("#cell3").html("Cliente");
            $('#cell3').addClass('current');
            $('#cell2').addClass('done');
            if (subtipoCuenta == 11) {
                $("#ST3").removeClass('ocult');
                $('#ST3').addClass('success');
                $("#ST3").html("Venta Activo");
            }
            if (subtipoCuenta == 12) {
                $("#ST3").removeClass('ocult');
                $('#ST3').addClass('success');
                $("#ST3").html("Con Linea");
            }
            if (subtipoCuenta == 13) {
                $("#ST3").removeClass('ocult');
                $('#ST3').addClass('success');
                $("#ST3").html("Nuevo");
            }
            if (subtipoCuenta == 14) {
                $("#ST3").removeClass('ocult');
                $('#ST3').addClass('success');
                $("#ST3").html("Unifin");
            }
            if (subtipoCuenta == 15) {
                $("#ST3").removeClass('ocult');
                $('#ST3').addClass('alerta');
                $("#ST3").html("Inactivo");
            }
            if (subtipoCuenta == 16) {
                $("#ST3").removeClass('ocult');
                $('#ST3').addClass('alerta');
                $("#ST3").html("Dormido");
            }
            if (subtipoCuenta == 17) {
                $("#ST3").removeClass('ocult');
                $('#ST3').addClass('error');
                $("#ST3").html("Perdido");
            }
            if (subtipoCuenta == 18) {
                $("#ST3").removeClass('ocult');
                $('#ST3').addClass('success');
                $("#ST3").html("Con Línea Vigente");
            }
            if (subtipoCuenta == 19) {
                $("#ST3").removeClass('ocult');
                $('#ST3').addClass('error');
                $("#ST3").html("Con Línea Vencida");
            }
            if (subtipoCuenta == 20) {
                $("#ST3").removeClass('ocult');
                $('#ST3').addClass('error');
                $("#ST3").html("Con Más de un Año sin Operar");
            }
        }

        if (tipoCuenta == 4) {
            $("#cell2").html("Persona");
            $("#cell1").addClass('ocult');
            $("#cell3").addClass('ocult');
            $('#cell2').addClass('current');
            $('#cell2').addClass('done');
            $(".container2").hide();
        }

        if (tipoCuenta == 5) {
            $("#cell2").html("Proveedor");
            $("#cell1").addClass('ocult');
            $("#cell3").addClass('ocult');
            $('#cell2').addClass('current');
            $('#cell2').addClass('done');
            $(".container2").hide();
        }
        $('[data-name="tipo_registro_cuenta_c"]').hide();
        $('[data-name="subtipo_registro_cuenta_c"]').hide();
    },

    _render: function () {
        this._super("_render");
    }
})