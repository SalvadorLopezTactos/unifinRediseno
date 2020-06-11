({

    initialize: function (options) {
        //Inicializa campo custom
        options = options || {};
        options.def = options.def || {};
        cont_tel = this;
        this._super('initialize', [options]);
        this.model.on('sync', this.pipelineopp, this);
    },

    pipelineopp: function (){
        //Obtiene Etapa y SubEtapa de la solicitud
        var etapa= this.model.get('tct_etapa_ddw_c');
        var subetapa=this.model.get('estatus_c');

      //Validaciones para asignar etapas de la solicitud en formado Pipeline SOLICITUD INICIAL
        if (etapa=="SI"){
            //Agrega clase current para sombrear en color actual al pipeline
            $('#SI').addClass('current');
            //Valida si tiene subetapa "cancelada"
            if (subetapa=="K"){
                $("#SE1").removeClass('ocult');
                $('#SE1').addClass('error');
                $("#SE1").html("Cancelada");
            }
        }
        if (etapa=="P"){
            //Agrega clase current para sombrear en color actual al pipeline Int de Expediente
            $('#IE').addClass('current');
            $('#SI').addClass('done');
            //Valida las subetapas 'En Espera', 'int de Exp','Devuelta por Credito' y 'Cancelada'
            if(subetapa=="PE"){
                $("#SE2").removeClass('ocult');
                $('#SE2').addClass('success');
                $("#SE2").html("En Espera");
            }
            if(subetapa=="P"){
                $("#SE2").removeClass('ocult');
                $('#SE2').addClass('success');
                $("#SE2").html("Integración de Expediente");
            }
            if(subetapa=="DP"){
                $("#SE2").removeClass('ocult');
                $('#SE2').addClass('alerta');
                $("#SE2").html("Devuelta por Crédito");
            }
            if(subetapa=="K"){
                $("#SE2").removeClass('ocult');
                $('#SE2').addClass('error');
                $("#SE2").html("Cancelada");
            }
        }
        if (etapa=="C"){
            //Agrega clase current para sombrear en color actual al pipeline CREDITO
            $('#C').addClass('current');
            $('#SI').addClass('done');
            $('#P').addClass('done');
            //Validaciones subetapas
            if(subetapa=="BC"){
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('success');
                $("#SE3").html("Buró de Crédito");
            }
            if(subetapa=="CC"){
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('success');
                $("#SE3").html("Cualitativo y Cuantitativo");
            }
            if(subetapa=="RF"){
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('success');
                $("#SE3").html("Referencias");
            }
            if(subetapa=="EF"){
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('success');
                $("#SE3").html("Estados Financieros");
            }
            if(subetapa=="E"){
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('success');
                $("#SE3").html("Análisis de Crédito");
            }
            if(subetapa=="RM"){
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('success');
                $("#SE3").html("Análisis de Crédito RM");
            }
            if(subetapa=="SC"){
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('success');
                $("#SE3").html("Scoring");
            }
            if(subetapa=="D"){
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('success');
                $("#SE3").html("Comité");
            }
            if(subetapa=="CN"){
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('success');
                $("#SE3").html("Condicionada");
            }
            if(subetapa=="SG"){
                $("#SE3").removeClass('ocult');
                $('#SE3').addClass('success');
                $("#SE3").html("Sugerencias de Crédito");
            }
        }
        if (etapa=="CL"){
            //Agrega clase current para sombrear en color actual al pipeline CLIENTE CON LINEA
            $('#CL').addClass('current');
            $('#SI').addClass('done');
            $('#P').addClass('done');
            $('#C').addClass('done');
            //Valida subetapa
            if (subetapa="N") {
                $("#SE4").removeClass('ocult');
                $('#SE4').addClass('success');
                $("#SE4").html("Autorizada");
            }
        }
        if (etapa=="R"){
            //Agrega clase current para sombrear en color actual al pipeline
            $('#CL').addClass('current');
            $('#SI').addClass('done');
            $('#P').addClass('done');
            $('#C').addClass('done');
            //Cambia texto a Rechazado
            $("#CL").html("Rechazado");
            //Valida subetapas
            if(subetapa="CM"){
                $("#SE4").removeClass('ocult');
                $('#SE4').addClass('error');
                $("#SE4").html("Rechazada Comité");
            }
            if(subetapa="R"){
                $("#SE4").removeClass('ocult');
                $('#SE4').addClass('error');
                $("#SE4").html("Rechazada Crédito");
            }

        }
    },
})