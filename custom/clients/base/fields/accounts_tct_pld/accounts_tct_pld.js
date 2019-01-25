({
    lista_1ap: null,
    lista_2ap: null,
    lista_3ap: null,

    lista_1cs: null,
    lista_2cs: null,
    lista_3cs: null,

    lista_1ca: null,
    lista_2ca: null,
    lista_3ca: null,

    lista_1ff: null,
    lista_2ff: null,
    lista_3ff: null,
    lista_4ff: null,
    lista_5ff: null,
    lista_6ff: null,

    lista_4: null,
    lista_5: null,
    lista_6: null,
    lista_7: null,
    lista_8: null,
    lista_9: null,
    lista_10:null,
    //lista_11:null,
    lista_12: null,


    initialize: function (options) {
        //Inicializa campo custom
        pld = this;
        options = options || {};
        options.def = options.def || {};
        this._super('initialize', [options]);

        console.log(this.model.get('id'));

        //Validación para activar las listas desplegables
        pld.GeneraListas();

        //Funcion oculta los panels de productos
        //pld.ocultapanels;



        //this.model.on('change:.campo2ddw', this.MuestraCampo1, this);

    },


    /**
     * When data changes, re-render the field only if it is not on edit (see MAR-1617).
     * @inheritdoc
     */
    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                this.render();
            }
        }, this);
    },

    _render: function () {
        var direccionsHtml = '';
        this._super("_render");

        //Validaciones para activar campos ocultos/dependientes de respuestas a listas desplegables
        //Desplegables para Arrendamiento Puro

        //Muestra campo Propietario Real al seleccionar la opcion Tercero, pregunta 1
        $('.campo2ddw').change(function(evt) {
            pld.Muestracampo1();
        });
        //Muestra campo Proveedor de Recursos al seleccionar la opcion Tercero, pregunta 2
        $('.campo4ddw').change(function(evt) {
           pld.Muestracampo2();
        });
        //Muestra el campo Número de Registro ante la CNBV o Condusef PERSONA MORAL 1
        $('.campo7ddw').change(function(evt) {
            pld.Muestracampo3();
        });

        //Muestra el campo Clave de Pizarra PERSONA MORAL 2
        $('.campo9ddw').change(function(evt) {
            pld.Muestracampo4();
        });

        //Muestra el campo Especifique cuando el Check esta marcado (Continua campos Persona Fisica)
        $('.campo14chk').change(function(evt) {
            pld.checkpagosmonetarioAP();
        });

        $('#multi11').change(function(evt)  {
            pld.InsMonetarioAP();

        });

        //Desplegables para Factoraje Financiero
        //Muestra campo Propietario Real al seleccionar la opcion Tercero, pregunta 1
        $('.campo2ddwff').change(function(evt) {
            pld.Muestracampo1FF();
        });
        //Muestra campo Proveedor de Recursos al seleccionar la opcion Tercero, pregunta 2
        $('.campo4ddwff').change(function(evt) {
            pld.Muestracampo2FF();
        });

        //Muestra
        $('#multi12').change(function(evt)  {
            pld.InsMonetarioFF();

        });

        $('.campo14chkff').change(function(evt)  {
            pld.checkpagosmonetarioFF();

        });

        //Desplegables para Credito Automotriz
        //Muestra campo Propietario Real al seleccionar la opcion Tercero, pregunta 1
        $('.campo2ddwca').change(function(evt)  {
            pld.Muestracampo1CA();

        });
        //Muestra campo Proveedor de Recursos al seleccionar la opcion Tercero, pregunta 2
        $('.campo4ddwca').change(function(evt)  {
            pld.Muestracampo2CA();

        });



        //Desplegables para Credito Simple
        //Muestra campo Propietario Real al seleccionar la opcion Tercero, pregunta 1
        $('.campo2ddwcs').change(function(evt)  {
            pld.Muestracampo1CS();

        });
        //Muestra campo Proveedor de Recursos al seleccionar la opcion Tercero, pregunta 2
        $('.campo4ddwcs').change(function(evt)  {
            pld.Muestracampo2CS();

        });

        $('#multi13').change(function(evt)  {
            pld.InsMonetarioCS();

        });

        $('.campo14chkcs').change(function(evt)  {
            pld.checkpagosmonetarioCS();

        });



        //Campos nacen ocultos Arrendamiento Puro

        $('.campo1ap').hide();
        $('.campo2ap').hide();
        $('.campo4ap').hide();
        $('.campo6ap').hide();
        $('.campo16pm').hide();
        $('.campo14pm').hide();

        //Campos Ocultos Arrendamiento Puro (Desplegables)

        $('.campo3ap').hide();
        $('.campo5ap').hide();
        $('.campo17ap').hide();
        $('.campo15ap').hide();
        $('.campo18pm').hide();



        //Campos Persona Moral Arrendamiento Puro
        $('.campo7ap-pm').hide(); //Pregunta1
        $('.campo9ap-pm').hide(); //Pregunta2
        $('.campo8ap-pm').hide();
        $('.campo10ap-pm').hide();

        //Campos Factoraje Financiero
        $('.campo3ff').hide();
        $('.campo5ff').hide();
        $('.campo17ff').hide();
        $('.campo18ff').hide();


        //Campos Credito Automotriz
        $('.campo3ca').hide();
        $('.campo5ca').hide();

        //Campos Credito Simple
        $('.campo3cs').hide();
        $('.campo5cs').hide();
        $('.campo15cs').hide();
        $('.campo19cs').hide();


        //Se establece formato de multiselect a campo select con id "multi1 pregunta 1"
        $('#multi11').select2({
            width: '100%',
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });
        //Se establece formato de multiselect a campo select con id "multil2 pregunta 2"
        $('#multi12').select2({
            width: '100%',
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });

        //Se establece formato de multiselect a campo select con id "multil2 pregunta 3"
        $('#multi13').select2({
            width: '100%',
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });

        //Validacion para mostrar los campos de Arrendamiento Puro dependiendo el regimen fiscal (Persona Moral)
        pld.validaregimen();

    },


    GeneraListas: function () {

        //Carga de listas de Producto Arrendamiento Puro
        //Carga de lista 1: ¿Usted actúa a nombre y por cuenta propia o a nombre y por cuenta de un tercero?

        var lista1apID = app.lang.getAppListStrings('ctpldidproveedorrecursosclie_list');
        var lista_1ap = '';
        Object.keys(lista1apID).forEach(function (id) {
            //console.log(id, lista1apID[id]);
            lista_1ap += '<option value="' + id + '">' + lista1apID[id] + '</option>'
        });
        this.tct_pld_campo2_ddw_ap_list = lista_1ap;

        //Carga de lista 2 ¿Los recursos son propios o los recursos son de un tercero?

        var lista2apID = app.lang.getAppListStrings('ctpldidproveedorrecursosson_list');
        var lista_2ap = '';
        Object.keys(lista2apID).forEach(function (id) {
            //console.log(id, lista2apID[id]);
            lista_2ap += '<option value="' + id + '">' + lista2apID[id] + '</option>'
        });
        this.tct_pld_campo4_ddw_ap_list = lista_2ap;

        //Carga de lista 3 ¿Espera realizar pagos anticipados a su crédito?

        var lista3apID = app.lang.getAppListStrings('tct_pagoanticipado_list');
        var lista_3ap = '';
        Object.keys(lista3apID).forEach(function (id) {
            //console.log(id, lista2apID[id]);
            lista_3ap += '<option value="' + id + '">' + lista3apID[id] + '</option>'
        });
        this.tct_pld_campo6_ddw_ap_list = lista_3ap;

        //Carga de lista 4 ¿Instrumento monetario con el que espera realizar los pagos? (multiselect)

        var lista4ID = app.lang.getAppListStrings('tct_inst_monetario_ddw_list');
        var lista_4 = '';
        Object.keys(lista4ID).forEach(function (id) {
            //console.log(id, lista4ID[id]);
            lista_4 += '<option value="' + id + '">' + lista4ID[id] + '</option>'
        });
        this.tct_pld_campo16_ddw_ap_list = lista_4;

        //Carga de lista 5 Persona Moral La persona moral es: Sofom, Transmisor de Dinero, Centro Cambiario?

        var lista5ID = app.lang.getAppListStrings('tct_cpld_pregunta_u1_ddw_list');
        var lista_5 = '';
        Object.keys(lista5ID).forEach(function (id) {
            //console.log(id, lista5ID[id]);
            lista_5 += '<option value="' + id + '">' + lista5ID[id] + '</option>'
        });
        this.tct_pld_campo7_ddw_aplist = lista_5;

        //Carga de lista 6 Persona Moral ¿Cotiza en Bolsa?

        var lista6ID = app.lang.getAppListStrings('tct_cpld_pregunta_u3_ddw_list');
        var lista_6 = '';
        Object.keys(lista6ID).forEach(function (id) {
            //console.log(id, lista6ID[id]);
            lista_6 += '<option value="' + id + '">' + lista6ID[id] + '</option>'
        });
        this.tct_pld_campo9_ddw_ap_list = lista_6;

        //Carga de lista 7 Persona Moral 3 Los recursos con los que va a celebrar su operación tiene su origen en su actividad mercantil, actividad u objeto social?

        var lista7ID = app.lang.getAppListStrings('tct_cpld_pregunta9_desp_c');
        var lista_7 = '';
        Object.keys(lista7ID).forEach(function (id) {
            //console.log(id, lista7ID[id]);
            lista_7 += '<option value="' + id + '">' + lista7ID[id] + '</option>'
        });
        this.tct_pld_campo11_ddw = lista_7;

        // Carga Listas de Factoraje Financiero

        //Carga de lista 1: ¿Usted actúa a nombre y por cuenta propia o a nombre y por cuenta de un tercero?

        var lista1ffID = app.lang.getAppListStrings('ctpldidproveedorrecursosclie_list');
        var lista_1ff = '';
        Object.keys(lista1ffID).forEach(function (id) {
            //console.log(id, lista1ffID[id]);
            lista_1ff += '<option value="' + id + '">' + lista1ffID[id] + '</option>'
        });
        this.tct_pld_campo2_ddw_ff_list = lista_1ff;

        //Carga de lista 2 ¿Los recursos son propios o los recursos son de un tercero?

        var lista2ffID = app.lang.getAppListStrings('ctpldidproveedorrecursosson_list');
        var lista_2ff = '';
        Object.keys(lista2ffID).forEach(function (id) {
            //console.log(id, lista2ffID[id]);
            lista_2ff += '<option value="' + id + '">' + lista2ffID[id] + '</option>'
        });
        this.tct_pld_campo4_ddw_ff_list = lista_2ff;

        //Carga de lista 3 ¿Espera realizar pagos anticipados a su crédito?

        var lista3ffID = app.lang.getAppListStrings('tct_pagoanticipado_list');
        var lista_3ff = '';
        Object.keys(lista3ffID).forEach(function (id) {
            //console.log(id, lista3ffID[id]);
            lista_3ff += '<option value="' + id + '">' + lista3ffID[id] + '</option>'
        });
        this.tct_pld_campo6_ddw_ff_list = lista_3ff;

        //Carga de lista 4 ¿Instrumento monetario con el que espera realizar los pagos? (multiselect)

        var lista4ffID = app.lang.getAppListStrings('tct_inst_monetario_ddw_list');
        var lista_4ff = '';
        Object.keys(lista4ffID).forEach(function (id) {
            //console.log(id, lista4ffID[id]);
            lista_4ff += '<option value="' + id + '">' + lista4ffID[id] + '</option>'
        });

        this.tct_pld_campo16_ddw_ff_list = lista_4ff;


        //Carga de lista 5 ¿Con qué frecuencia o periodo realizará pagos a Unifin?
        var lista5ffID = app.lang.getAppListStrings('tct_pldcampo1_ff_ddw_list');
        var lista_5ff = '';
        Object.keys(lista5ffID).forEach(function (id) {
            //console.log(id, lista5ffID[id]);
            lista_5ff += '<option value="' + id + '">' + lista5ffID[id] + '</option>'
        });

        this.tct_pld_campo21_ddw_ff_list = lista_5ff;

        //Carga de lista 6 ¿Cuál es el destino de los recursos que obtendrá de la celebración de esta operación?

        var lista6ffID = app.lang.getAppListStrings('tct_plddestinorecursos_ff_ddw_list');
        var lista_6ff = '';
        Object.keys(lista6ffID).forEach(function (id) {
            //console.log(id, lista5ffID[id]);
            lista_6ff += '<option value="' + id + '">' + lista6ffID[id] + '</option>'
        });
        this.tct_pld_campo24_ddw_ff_list = lista_6ff;

        //Carga Listas de Credito Automotriz

        //Carga de lista 1: ¿Usted actúa a nombre y por cuenta propia o a nombre y por cuenta de un tercero?

        var lista1caID = app.lang.getAppListStrings('ctpldidproveedorrecursosclie_list');
        var lista_1ca = '';
        Object.keys(lista1caID).forEach(function (id) {
            //console.log(id, lista1caID[id]);
            lista_1ca += '<option value="' + id + '">' + lista1caID[id] + '</option>'
        });
        this.tct_pld_campo2_ddw_ca_list = lista_1ca;

        //Carga de lista 2 ¿Los recursos son propios o los recursos son de un tercero?

        var lista2csID = app.lang.getAppListStrings('ctpldidproveedorrecursosson_list');
        var lista_2cs = '';
        Object.keys(lista2csID).forEach(function (id) {
            //console.log(id, lista2csID[id]);
            lista_2cs += '<option value="' + id + '">' + lista2csID[id] + '</option>'
        });
        this.tct_pld_campo4_ddw_ca_list = lista_2cs;

        //Carga de lista 3 ¿Espera realizar pagos anticipados a su crédito?

        var lista3csID = app.lang.getAppListStrings('tct_pagoanticipado_list');
        var lista_3cs = '';
        Object.keys(lista3csID).forEach(function (id) {
            //console.log(id, lista3csID[id]);
            lista_3cs += '<option value="' + id + '">' + lista3csID[id] + '</option>'
        });
        this.tct_pld_campo6_ddw_ca_list = lista_3cs;


        //Carga Listas de Credito Simple

        //Carga de lista 1: ¿Usted actúa a nombre y por cuenta propia o a nombre y por cuenta de un tercero?

        var lista1csID = app.lang.getAppListStrings('ctpldidproveedorrecursosclie_list');
        var lista_1cs = '';
        Object.keys(lista1csID).forEach(function (id) {
            //console.log(id, lista1csID[id]);
            lista_1cs += '<option value="' + id + '">' + lista1csID[id] + '</option>'
        });
        this.tct_pld_campo2_ddw_cs_list = lista_1cs;

        //Carga de lista 2 ¿Los recursos son propios o los recursos son de un tercero?

        var lista2csID = app.lang.getAppListStrings('ctpldidproveedorrecursosson_list');
        var lista_2cs = '';
        Object.keys(lista2csID).forEach(function (id) {
            //console.log(id, lista2csID[id]);
            lista_2cs += '<option value="' + id + '">' + lista2csID[id] + '</option>'
        });
        this.tct_pld_campo4_ddw_cs_list = lista_2cs;

        //Carga de lista 3 ¿Espera realizar pagos anticipados a su crédito?

        var lista3csID = app.lang.getAppListStrings('tct_pagoanticipado_list');
        var lista_3cs = '';
        Object.keys(lista3csID).forEach(function (id) {
            //console.log(id, lista3csID[id]);
            lista_3cs += '<option value="' + id + '">' + lista3csID[id] + '</option>'
        });
        this.tct_pld_campo6_ddw_ca_list = lista_3cs;

        //Carga de lista 8 ¿Instrumento monetario con el que espera realizar los pagos? (*Es posible elegir más de una opción)

        var lista8ID = app.lang.getAppListStrings('tct_instmonetario_csddw_list');
        var lista_8 = '';
        Object.keys(lista8ID).forEach(function (id) {
            //console.log(id, lista8ID[id]);
            lista_8 += '<option value="' + id + '">' + lista8ID[id] + '</option>'
        });
        this.tct_pld_campo18_ddw_cs_list = lista_8;

        //Carga de lista 9 ¿Cuál es el destino de los recursos que va a obtener de la celebración de la operación?

        var lista9ID = app.lang.getAppListStrings('tct_destinorecursos_csddw_list');
        var lista_9 = '';
        Object.keys(lista9ID).forEach(function (id) {
            //console.log(id, lista9ID[id]);
            lista_9 += '<option value="' + id + '">' + lista9ID[id] + '</option>'
        });
        this.tct_pld_campo20_ddw_cs_list = lista_9;

        var lista10ID = app.lang.getAppListStrings('tct_pagoanticipado_list');
        var lista_10 = '';
        Object.keys(lista10ID).forEach(function (id) {
            //console.log(id, lista10ID[id]);
            lista_10 += '<option value="' + id + '">' + lista10ID[id] + '</option>'
        });
        this.tct_pld_campo6_ddw_cs_list = lista_10;




        //Carga de lista 12 Los recursos con los que va a celebrar su operación están destinados a: (Cuando la cuenta es CLIENTE)
        var lista12 = app.lang.getAppListStrings('tct_cpld_pregunta10_desp_list');
        var lista12ID = app.lang.getAppListKeys('tct_cpld_pregunta10_desp_list');
        var lista_12 = '';
        for (lista12ID in lista12) {
            lista_12 += '<option value="' + lista12ID + '">' + lista12[lista12] + '</option>'
        }
        this.tct_pld_campo25_ddw = lista_12;
    },




    ocultapanels: function () {
        //$(".panel-ap").hide();
        $(".cont-FF").hide();
        $(".panel-ca").hide();

    },

    //Validaciones para mostrar campos de Arrendamiento Puro
    Muestracampo1: function () {
        console.log("Propietario Real AP");
        if ($('.campo2ddw').val() == "2") {
            $('.campo3ap').show();
        } else {
            $('.campo3ap').hide();
        }
    },

    Muestracampo2: function () {
        console.log("Proveedor de Recursos AP");
        if ($('.campo4ddw').val() == "2") {
            $('.campo5ap').show();
        } else {
            $('.campo5ap').hide();
        }
    },

    //Validaciones para campos vistos en Persona Moral
        //pregunta La persona moral es: Sofom, Transmisor de Dinero, Centro Cambiario?
    Muestracampo3: function () {
        console.log("La persona moral es: Sofom, Transmisor de Dinero, Centro Cambiario?");
        if ($('.campo7ddw').val() == "Si") {
            $('.campo8ap-pm').show();
        } else {
            $('.campo8ap-pm').hide();
        }
    },

    //pregunta La persona moral es: Sofom, Transmisor de Dinero, Centro Cambiario?
    Muestracampo4: function () {
        console.log("¿Cotiza en Bolsa?");
        if ($('.campo9ddw').val() == "Si") {
            $('.campo10ap-pm').show();
        } else {
            $('.campo10ap-pm').hide();
        }
    },

    checkpagosmonetarioAP: function () {
        console.log("Esta check");
        if( $('.campo14chk').is(':checked') ) {
            $('.campo17ap').show();
        } else {
            $('.campo17ap').hide();
        }
    },

    InsMonetarioAP: function () {
        console.log("Cambio de Instrumento monetario AP");
        if ($('#multi11').val("Otro")) {
            $('.campo14chk').attr("checked", true);
            $('.campo17ap').show();
        } else {
            $('.campo17ap').hide();
        }
    },

    //Validaciones para mostrar campos en Factoraje Financiero
    //Eventos Change (mostrar campos)
    Muestracampo1FF: function () {
        console.log("Propietario Real FF");
        if ($('.campo2ddwff').val() == "2") {
            $('.campo14chk').attr("checked", true);
            $('.campo3ff').show();
        } else {
            $('.campo3ff').hide();
        }
    },

    Muestracampo2FF: function () {
        console.log("Proveedor de Recursos FF");
        if ($('.campo4ddwff').val() == "2") {
            $('.campo5ff').show();
        } else {
            $('.campo5ff').hide();
        }
    },


    checkpagosmonetarioFF: function (){
        if( $('.campo14chkff').is(':checked') ) {
            $('.campo17ff').show();
        } else {
            $('.campo17ff').hide();
        }
    },

    InsMonetarioFF: function () {
        console.log("Cambio de Instrumento monetario FF");
        if ($('#multi12').val("Otro")) {
            $('.campo14chkff').attr("checked", true);
            $('.campo17ff').show();
        } else {
            $('.campo17ff').hide();
        }
    },


    //Validaciones para mostrar campos en Credito Automotriz
    Muestracampo1CA: function () {
        console.log("Propietario Real CA");
        if ($('.campo2ddwca').val() == "2") {
            $('.campo3ca').show();
        } else {
            $('.campo3ca').hide();
        }
    },

    Muestracampo2CA: function () {
        console.log("Proveedor de Recursos CA");
        if ($('.campo4ddwca').val() == "2") {
            $('.campo5ca').show();
        } else {
            $('.campo5ca').hide();
        }
    },

    //Validaciones para mostrar campos en Credito Simple
    //Eventos Change (mostrar campos)

    Muestracampo1CS: function () {
        console.log("Propietario Real CS");
        if ($('.campo2ddwcs').val() == "2") {
            $('.campo3cs').show();
        } else {
            $('.campo3cs').hide();
        }
    },

    Muestracampo2CS: function () {
        console.log("Proveedor de Recursos CS");
        if ($('.campo4ddwcs').val() == "2") {
            $('.campo5cs').show();
        } else {
            $('.campo5cs').hide();
        }
    },

    InsMonetarioCS: function () {
        console.log("Cambio de Instrumento monetario CS");
        if ($('#multi13').val("Otro")) {
            $('.campo14chkcs').attr("checked", true);
            $('.campo19cs').show();
        } else {
            $('.campo19cs').hide();
        }
    },

    checkpagosmonetarioCS: function (){
        if( $('.campo14chkcs').is(':checked') ) {
            $('.campo19cs').show();
        } else {
            $('.campo19cs').hide();
        }
    },

    validaregimen: function (){
        if(this.model.get('tipodepersona_c') == 'Persona Moral'){
            //Muestra campos de vista de Persona Moral en panel de Arrendamiento puro
            $('.campo1ap').show();
            $('.campo4ap').show();
            $('.campo6ap').show();
            $('.campo7ap-pm').show();
            $('.campo9ap-pm').show();
            $('.campo16ap').show();
            $('.campo14ap').show();
            $('.campo18pm').show();

            //Oculta campos de vista de persona fisica en panel de Arrendamiento Puro
            $('.campo2ap').hide();
            $('.campo3ap').hide();

        }else{
            $('.campo1ap').show();
            $('.campo2ap').show();
            $('.campo4ap').show();
            $('.campo6ap').show();
            $('.campo16ap').show();
            $('.campo14ap').show();
        }

    },

})
