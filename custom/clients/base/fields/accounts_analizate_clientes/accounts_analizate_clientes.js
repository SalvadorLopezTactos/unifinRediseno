({
    visible: false,
    initialize: function (options) {
        //Inicializa campo custom
        options = options || {};
        options.def = options.def || {};
        analizate_cl=this;
        this._super('initialize', [options]);
        //Carga lista de valores para la creacion de la url portal
        cont_nlzt.lista_url = App.lang.getAppListStrings('analizate_url_list');
        this.model.on('sync', this.cargapipelineCliente, this);
    },

    cargapipelineCliente: function () {
        // tipo_registro_cuenta_c
        //Y subtipo_registro_cuenta_c
       //var estado =analizate_cl.Financiera.estado;       
       //var fecha = analizate_cl.Financiera.fecha;
        //var estado = Analizate.Credit.estado;
        //var fecha = Analizate.Credit.fecha;
        console.log("Inicia campo cstm analizate clientes.");
        if (estado == 1) {
            $("#estado1").removeClass('ocult');
            $('#estado1').addClass('current');
            $("#estado1").html(estado);
            if (fecha !="") {
                $("#fecha1").removeClass('ocult');
                $('#fecha1').addClass('success');
                $("#fecha1").html(fecha);
            }
        }

        if (estado == 2) {
            $("#estado2").removeClass('ocult');
            $('#estado2').addClass('current');
            $("#estado2").html(estado);
            $('#estado1').addClass('done');
            if (fecha != "") {
                $("#fecha2").removeClass('ocult');
                $('#fecha2').addClass('success');
                $("#fecha2").html(fecha);
            }
        }

        if (estado == 3) {
            $("#estado3").removeClass('ocult');
            $('#estado3').addClass('current');
            $("#estado3").html(estado);
            $('#estado2').addClass('done');
            $('#estado1').addClass('done');
            if (fecha != "") {
                $("#fecha3").removeClass('ocult');
                $('#fecha3').addClass('success');
                $("#fecha3").html(fecha);
            }
        }

        if (estado == 4) {
            $("#estado4").removeClass('ocult');
            $('#estado4').addClass('current');
            $("#estado4").html(estado);
            $('#estado3').addClass('done');
            $('#estado3').addClass('done');
            $('#estado1').addClass('done');
            if (fecha != "") {
                $("#fecha4").removeClass('ocult');
                $('#fecha4').addClass('success');
                $("#fecha4").html(fecha);
            }
            
        }
        $('[data-name="tipo_registro_cuenta_c"]').hide();
        $('[data-name="subtipo_registro_cuenta_c"]').hide();
    },

    _render: function () {
        this._super("_render");
    }
})