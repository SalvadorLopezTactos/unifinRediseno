({
    visible: false,
    initialize: function (options) {
        //Inicializa campo custom
        options = options || {};
        options.def = options.def || {};
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

                $("#SE1").removeClass('ocult');
                $('#SE1').addClass('success');
                $("#SE1").html("En Calificación");
            }
            if (subtipoCuenta == 6) {
                $("#SE1").removeClass('ocult');
                $('#SE1').addClass('alerta');
                $("#SE1").html("No Viable");
            }

        }

        if (tipoCuenta == 2) {
            $("#cell1").html("Lead");
            $("#cell2").html("Prospecto");
            $("#cell3").html("Cliente");
            $('#cell2').addClass('current');
            $('#cell1').addClass('done');

            if (subtipoCuenta == 2) {

                $("#SE2").removeClass('ocult');
                $('#SE2').addClass('success');
                $("#SE2").html("Contactado");
            }
            if (subtipoCuenta == 7) {
                $("#SE2").removeClass('ocult');
                $('#SE2').addClass('success');
                $("#SE2").html("Interesado");
            }
            if (subtipoCuenta == 8) {
                $("#SE2").removeClass('ocult');
                $('#SE2').addClass('success');
                $("#SE2").html("Integración de Expediente");
            }
            if (subtipoCuenta == 9) {
                $("#SE2").removeClass('ocult');
                $('#SE2').addClass('success');
                $("#SE2").html("En Crédito");
            }
            if (subtipoCuenta == 10) {
                $("#SE2").removeClass('ocult');
                $('#SE2').addClass('error');
                $("#SE2").html("Rechazado");
            }

        }

        if (tipoCuenta == 3) {
            $("#cell1").html("Lead");
            $("#cell2").html("Prospecto");
            $("#cell3").html("Cliente");

            $('#cell3').addClass('current');
            $('#cell2').addClass('done');

            if (subtipoCuenta == 11) {
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('success');
                $("#SE3").html("Venta Activo");
            }
            if (subtipoCuenta == 12) {
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('success');
                $("#SE3").html("Con Linea");
            }
            if (subtipoCuenta == 13) {
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('success');
                $("#SE3").html("Nuevo");
            }
            if (subtipoCuenta == 14) {
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('success');
                $("#SE3").html("Unifin");
            }
            if (subtipoCuenta == 15) {
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('alerta');
                $("#SE3").html("Inactivo");
            }
            if (subtipoCuenta == 16) {
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('alerta');
                $("#SE3").html("Dormido");
            }
            if (subtipoCuenta == 17) {
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('error');
                $("#SE3").html("Perdido");
            }
            if (subtipoCuenta == 18) {
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('success');
                $("#SE3").html("Con Línea Vigente");
            }
            if (subtipoCuenta == 19) {
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('error');
                $("#SE3").html("Con Línea Vencida");
            }
            if (subtipoCuenta == 20) {
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('error');
                $("#SE3").html("Con Más de un Año sin Operar");
            }
        }

        if (tipoCuenta == 4) {

            $("#cell1").html("Persona");
            $("#cell2").addClass('ocult');
            $("#cell3").addClass('ocult');
            $('#cell1').addClass('current');
            $('#cell1').addClass('done');
            $(".container2").hide();

        }
        if (tipoCuenta == 5) {

            $("#cell1").html("Proveedor");
            $("#cell2").addClass('ocult');
            $("#cell3").addClass('ocult');
            $('#cell1').addClass('current');
            $('#cell1').addClass('done');
            $(".container2").hide();

        }

    },

    _render: function () {
        this._super("_render");


    }
})