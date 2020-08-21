({

    initialize: function (options) {
        //Inicializa campo custom
        options = options || {};
        options.def = options.def || {};
        pipe_s=this;

        this._super('initialize', [options]);
        this.model.on('sync', this.pipelineseguro, this);
    },

    _render: function () {
        this._super("_render");

    },

    pipelineseguro: function (){
        //Obtiene Etapa y SubEtapa de la solicitud
        var etapa= this.model.get('etapa');

        //Validaciones para asignar etapas del Seguro formado Pipeline Prospección
        if (etapa=="1"){
            //Agrega clase current para sombrear en color actual al pipeline
            $('#E1').addClass('current');
            //Agrega segunda linea con texto
            $("#SE1").removeClass('ocult');
            $('#SE1').addClass('success');
            $("#SE1").html("Prospecto");
        }
        if (etapa=="2"){
            //Agrega clase current para sombrear en color actual al pipeline Cotización
            $('#E2').addClass('current');
            $('#E1').addClass('done');
            //Valida la etapa Cotizacion
                $("#SE2").removeClass('ocult');
                $('#SE2').addClass('success');
                $("#SE2").html("Cotizando");
        }
        if (etapa=="3"){
            //Agrega clase current para sombrear en color actual al pipeline En revision
            $('#E2').addClass('current');
            $('#E1').addClass('done');
            //Valida la etapa En Revisión
            $("#SE2").removeClass('ocult');
            $('#SE2').addClass('success');
            $("#SE2").html("En Revisión");
        }
        if (etapa=="4"){
            //Agrega clase current para sombrear en color actual al pipeline Cotizado
            $('#E2').addClass('current');
            $('#E1').addClass('done');
            //Valida la etapa Cotizado
            $("#SE2").removeClass('ocult');
            $('#SE2').addClass('success');
            $("#SE2").html("Cotizado");
        }
        if (etapa=="5"){
            //Agrega clase current para sombrear en color actual al pipeline No Cotizado
            $('#E2').addClass('current');
            $('#E1').addClass('done');
            //Valida la etapa No Cotizado
            $("#SE2").removeClass('ocult');
            $('#SE2').addClass('error');
            $("#SE2").html("No Cotizado");
        }
        if (etapa=="6"){
            //Agrega clase current para sombrear en color actual al pipeline Presentado al Cliente
            $('#E3').addClass('current');
            $('#E2').addClass('done');
            $('#E1').addClass('done');
            //Valida la etapa No Cotizado
            $("#SE3").removeClass('ocult');
            $('#SE3').addClass('success');
            $("#SE3").html("Presentado al Cliente");
        }
        if (etapa=="7"){
            //Agrega clase current para sombrear en color actual al pipeline Re-Negociación
            $('#E3').addClass('current');
            $('#E2').addClass('done');
            $('#E1').addClass('done');
            //Valida la etapa No Cotizado
            $("#SE3").removeClass('ocult');
            $('#SE3').addClass('alerta');
            $("#SE3").html("Re-Negociación");
        }
        if (etapa=="8"){
            //Agrega clase current para sombrear en color actual al pipeline Re-Cotizada
            $('#E3').addClass('current');
            $('#E2').addClass('done');
            $('#E1').addClass('done');
            //Valida la etapa No Cotizado
            $("#SE3").removeClass('ocult');
            $('#SE3').addClass('alerta');
            $("#SE3").html("Re-Cotizada");
        }
        if (etapa=="9"){
            //Agrega clase current para sombrear en color actual al pipeline Ganada
            $('#E4').addClass('current');
            $('#E3').addClass('done');
            $('#E2').addClass('done');
            $('#E1').addClass('done');
            //Valida la etapa No Cotizado
            $("#SE4").removeClass('ocult');
            $('#SE4').addClass('success');
            $("#SE4").html("Ganada");
        }
        if (etapa=="10"){
            //Agrega clase current para sombrear en color actual al pipeline No Ganada
            $('#E4').addClass('current');
            $('#E3').addClass('done');
            $('#E2').addClass('done');
            $('#E1').addClass('done');
            //Valida la etapa No Cotizado
            $("#SE4").removeClass('ocult');
            $('#SE4').addClass('error');
            $("#SE4").html("No Ganada");
        }
    },
})