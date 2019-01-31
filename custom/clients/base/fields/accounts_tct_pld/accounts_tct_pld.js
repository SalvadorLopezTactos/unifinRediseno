({

    // J.A Solar
    ProductosPLD: null,
    // Listas PLD
    campo2_list: null,
    campo4_list: null,
    campo6_list: null,
    campo16_list: null,
    campo7_list: null,
    campo9_list: null,
    campo11_list: null,
    campo25_list: null,
    campo21_list: null,
    campo24_list: null,
    campo18_list: null,
    campo20_list: null,



    initialize: function (options) {
        //Inicializa campo custom
        pld = this;
        options = options || {};
        options.def = options.def || {};
        this._super('initialize', [options]);
        this.ListasDetail();
        console.log(this.model.get('id'));

        //Validación para activar las listas desplegables
      //  pld.GeneraListas();

        //Funcion oculta los panels de productos
        pld.ocultapanels;
        this.model.on('sync', this.loadData, this);

    },

    loadData: function (options) {
        //Recupera data existente
       // if (pld.action == 'detail') {
            //Recupera datos para vista de detalle
            var idCuenta = pld.model.get('id');
            app.api.call('GET', app.api.buildURL('GetProductosPLD/' + idCuenta), null, {
                success: function (data) {

                    pld.ProductosPLD = pld.formatDetailPLD(data);
                    _.extend(this, pld.ProductosPLD);
                    pld.render();
                },
                error: function (e) {
                    throw e;
                }
            });
       // }

        this.render();
    },
    formatDetailPLD: function (dataPLD) {
        // Listas AP
        dataPLD['arrendamientoPuro']['campo2_label'] = pld.campo2_list[dataPLD['arrendamientoPuro']['campo2']];
        dataPLD['arrendamientoPuro']['campo4_label'] = pld.campo4_list[dataPLD['arrendamientoPuro']['campo4']];
        dataPLD['arrendamientoPuro']['campo7_label'] = pld.campo7_list[dataPLD['arrendamientoPuro']['campo7']];
        dataPLD['arrendamientoPuro']['campo9_label'] = pld.campo9_list[dataPLD['arrendamientoPuro']['campo9']];
        dataPLD['arrendamientoPuro']['campo6_label'] = pld.campo6_list[dataPLD['arrendamientoPuro']['campo6']];
        dataPLD['arrendamientoPuro']['campo16_label'] = pld.campo16_list[dataPLD['arrendamientoPuro']['campo16']];
        dataPLD['arrendamientoPuro']['campo25_label'] = pld.campo25_list[dataPLD['arrendamientoPuro']['campo25']];
        dataPLD['arrendamientoPuro']['campo11_label'] = pld.campo11_list[dataPLD['arrendamientoPuro']['campo11']];

        dataPLD['factorajeFinanciero']['campo2_label'] = pld.campo2_list[dataPLD['factorajeFinanciero']['campo2']];
        dataPLD['factorajeFinanciero']['campo4_label'] = pld.campo4_list[dataPLD['factorajeFinanciero']['campo4']];
        dataPLD['factorajeFinanciero']['campo21_label'] = pld.campo21_list[dataPLD['factorajeFinanciero']['campo21']];
        dataPLD['factorajeFinanciero']['campo16_label'] = pld.campo16_list[dataPLD['factorajeFinanciero']['campo16']];
        dataPLD['factorajeFinanciero']['campo24_label'] = pld.campo24_list[dataPLD['factorajeFinanciero']['campo24']];
        dataPLD['factorajeFinanciero']['campo6_label'] = pld.campo6_list[dataPLD['factorajeFinanciero']['campo6']];

        dataPLD['creditoAutomotriz']['campo2_label'] = pld.campo2_list[dataPLD['creditoAutomotriz']['campo2']];
        dataPLD['creditoAutomotriz']['campo4_label'] = pld.campo4_list[dataPLD['creditoAutomotriz']['campo4']];
        dataPLD['creditoAutomotriz']['campo6_label'] = pld.campo6_list[dataPLD['creditoAutomotriz']['campo6']];

        dataPLD['creditoSimple']['campo2_label'] = pld.campo2_list[dataPLD['creditoSimple']['campo2']];
        dataPLD['creditoSimple']['campo4_label'] = pld.campo4_list[dataPLD['creditoSimple']['campo4']];
        dataPLD['creditoSimple']['campo18_label'] = pld.campo18_list[dataPLD['creditoSimple']['campo18']];
        dataPLD['creditoSimple']['campo20_label'] = pld.campo20_list[dataPLD['creditoSimple']['campo20']];
        dataPLD['creditoSimple']['campo6_label'] = pld.campo6_list[dataPLD['creditoSimple']['campo6']];


        return dataPLD;
    },

    ListasDetail: function () {
        pld.campo2_list = app.lang.getAppListStrings('ctpldidproveedorrecursosclie_list');
        pld.campo4_list = app.lang.getAppListStrings('ctpldidproveedorrecursosson_list');
        pld.campo6_list = app.lang.getAppListStrings('tct_pagoanticipado_list');
        pld.campo16_list = app.lang.getAppListStrings('tct_inst_monetario_ddw_list');
        pld.campo7_list = app.lang.getAppListStrings('tct_cpld_pregunta_u1_ddw_list');
        pld.campo9_list = app.lang.getAppListStrings('tct_cpld_pregunta_u3_ddw_list');
        pld.campo11_list = app.lang.getAppListStrings('tct_cpld_pregunta9_desp_list');
        pld.campo25_list = app.lang.getAppListStrings('tct_cpld_pregunta10_desp_list');
        pld.campo21_list = app.lang.getAppListStrings('tct_pldcampo1_ff_ddw_list');
        pld.campo24_list = app.lang.getAppListStrings('tct_plddestinorecursos_ff_ddw_list');
        pld.campo18_list = app.lang.getAppListStrings('tct_instmonetario_csddw_list');
        pld.campo20_list = app.lang.getAppListStrings('tct_destinorecursos_csddw_list');

    },


    /**
     * When data changes, re-render the field only if it is not on edit (see MAR-1617).
     * @inheritdoc
     */
    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
               // this.render();
            }
        }, this);
    },

    _render: function () {
        var direccionsHtml = '';
        this._super("_render");

        //Validaciones para activar campos ocultos/dependientes de respuestas a listas desplegables
        //Desplegables para Arrendamiento Puro

        //Muestra campo Propietario Real al seleccionar la opcion Tercero, pregunta 1
        $('.campo2ddw-ap').change(function(evt) {
            pld.Muestracampo1();
        });
        //Muestra campo Proveedor de Recursos al seleccionar la opcion Tercero, pregunta 2
        $('.campo4ddw-ap').change(function(evt) {
            pld.Muestracampo2();
        });
        //Muestra el campo Número de Registro ante la CNBV o Condusef PERSONA MORAL 1
        $('.campo7ddw-pm').change(function(evt) {
            pld.Muestracampo3();
        });

        //Muestra el campo Clave de Pizarra PERSONA MORAL 2
        $('.campo9ddw-pm').change(function(evt) {
            pld.Muestracampo4();
        });

        //Muestra el campo Especifique cuando el Check esta marcado (Continua campos Persona Fisica)
        $('.campo14chk-ap').change(function(evt) {
            pld.checkpagosmonetarioAP();
        });

        $('#multi11').change(function(evt)  {
            pld.InsMonetarioAP();

        });

        //Desplegables para Factoraje Financiero
        //Muestra campo Propietario Real al seleccionar la opcion Tercero, pregunta 1
        $('.campo2ddw-ff').change(function(evt) {
            pld.Muestracampo1FF();
        });
        //Muestra campo Proveedor de Recursos al seleccionar la opcion Tercero, pregunta 2
        $('.campo4ddw-ff').change(function(evt) {
            pld.Muestracampo2FF();
        });

        //Muestra
        $('#multi12').change(function(evt)  {
            pld.InsMonetarioFF();

        });

        $('.campo14chk-ff').change(function(evt)  {
            pld.checkpagosmonetarioFF();

        });

        //Desplegables para Credito Automotriz
        //Muestra campo Propietario Real al seleccionar la opcion Tercero, pregunta 1
        $('.campo2ddw-ca').change(function(evt)  {
            pld.Muestracampo1CA();

        });
        //Muestra campo Proveedor de Recursos al seleccionar la opcion Tercero, pregunta 2
        $('.campo4ddw-ca').change(function(evt)  {
            pld.Muestracampo2CA();

        });

        //Desplegables para Credito Simple
        //Muestra campo Propietario Real al seleccionar la opcion Tercero, pregunta 1
        $('.campo2ddw-cs').change(function(evt)  {
            pld.Muestracampo1CS();

        });
        //Muestra campo Proveedor de Recursos al seleccionar la opcion Tercero, pregunta 2
        $('.campo4ddw-cs').change(function(evt)  {
            pld.Muestracampo2CS();

        });

        $('#multi13').change(function(evt)  {
            pld.InsMonetarioCS();

        });

        $('.campo14chk-cs').change(function(evt)  {
            pld.checkpagosmonetarioCS();

        });


        $('.campo25ddw-ap').change(function(evt)  {
            pld.cuentaclient();

        });



        //Campos nacen ocultos Arrendamiento Puro
        $('.campo1-ap').hide();
        $('.campo2-ap').hide();
        $('.campo4-ap').hide();
        $('.campo6-ap').hide();
        $('.campo16-ap').hide();
        $('.campo14-ap').hide();
        $('.campo11-ap').hide();
        //Campos Ocultos Arrendamiento Puro (Desplegables)
        $('.campo3-ap').hide();
        $('.campo5-ap').hide();
        $('.campo17-ap').hide();
        $('.campo15-ap').hide();
        $('.campo18-ap').hide();
        //Campos Persona Moral Arrendamiento Puro
        $('.campo7-pm').hide(); //Pregunta1
        $('.campo9-pm').hide(); //Pregunta2
        $('.campo8-PM').hide();
        $('.campo10-PM').hide();

        $('.campo25-ap').hide(); //Cuenta Cliente
        $('.campo26-ap').hide(); //Especifique cuenta Cliente
        //Campos Factoraje Financiero
        $('.campo3-ff').hide();
        $('.campo5-ff').hide();
        $('.campo17-ff').hide();

        //Campos Credito Automotriz
        $('.campo3-ca').hide();
        $('.campo5-ca').hide();
        //Campos Credito Simple
        $('.campo3-cs').hide();
        $('.campo5-cs').hide();
        $('.campo15-cs').hide();
        $('.campo19-cs').hide();

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
        pld.cuentacliente();

    },

    GeneraListas: function () {

        //Carga de lista 1: ¿Usted actúa a nombre y por cuenta propia o a nombre y por cuenta de un tercero?

        var lista1apID = app.lang.getAppListStrings('ctpldidproveedorrecursosclie_list');
        var lista_campo2 = '';
        Object.keys(lista1apID).forEach(function (id) {
            //console.log(id, lista1apID[id]);
            lista_campo2 += '<option value="' + id + '">' + lista1apID[id] + '</option>'
        });
        this.lista_campo2 = lista_campo2;

        //Carga de lista 2 ¿Los recursos son propios o los recursos son de un tercero?

        var lista2apID = app.lang.getAppListStrings('ctpldidproveedorrecursosson_list');
        var lista_campo4 = '';
        Object.keys(lista2apID).forEach(function (id) {
            //console.log(id, lista2apID[id]);
            lista_campo4 += '<option value="' + id + '">' + lista2apID[id] + '</option>'
        });
        this.lista_campo4 = lista_campo4;

        //Carga de lista 3 ¿Espera realizar pagos anticipados a su crédito?

        var lista3apID = app.lang.getAppListStrings('tct_pagoanticipado_list');
        var lista_campo6 = '';
        Object.keys(lista3apID).forEach(function (id) {
            //console.log(id, lista2apID[id]);
            lista_campo6 += '<option value="' + id + '">' + lista3apID[id] + '</option>'
        });
        this.lista_campo6 = lista_campo6;

        //Carga de lista 4 ¿Instrumento monetario con el que espera realizar los pagos? (multiselect)

        var lista4ID = app.lang.getAppListStrings('tct_inst_monetario_ddw_list');
        var lista_campo16 = '';
        Object.keys(lista4ID).forEach(function (id) {
            //console.log(id, lista4ID[id]);
            lista_campo16 += '<option value="' + id + '">' + lista4ID[id] + '</option>'
        });
        this.lista_campo16 = lista_campo16;

        //Carga de lista 5 Persona Moral La persona moral es: Sofom, Transmisor de Dinero, Centro Cambiario?

        var lista5ID = app.lang.getAppListStrings('tct_cpld_pregunta_u1_ddw_list');
        var lista_campo7 = '';
        Object.keys(lista5ID).forEach(function (id) {
            //console.log(id, lista5ID[id]);
            lista_campo7 += '<option value="' + id + '">' + lista5ID[id] + '</option>'
        });
        this.lista_campo7 = lista_campo7;

        //Carga de lista 6 Persona Moral ¿Cotiza en Bolsa?

        var lista6ID = app.lang.getAppListStrings('tct_cpld_pregunta_u3_ddw_list');
        var lista_campo9 = '';
        Object.keys(lista6ID).forEach(function (id) {
            //console.log(id, lista6ID[id]);
            lista_campo9 += '<option value="' + id + '">' + lista6ID[id] + '</option>'
        });
        this.lista_campo9 = lista_campo9;

        //Carga de lista 7 Persona Moral 3 Los recursos con los que va a celebrar su operación tiene su origen en su actividad mercantil, actividad u objeto social?

        var lista11ID = app.lang.getAppListStrings('tct_cpld_pregunta9_desp_list');
        var lista_campo11 = '';
        Object.keys(lista11ID).forEach(function (id) {
            //console.log(id, lista7ID[id]);
            lista_campo11 += '<option value="' + id + '">' + lista11ID[id] + '</option>'
        });
        this.lista_campo11 = lista_campo11;

        //Carga lista 11, cuando la cuenta es cliente: Los recursos con los que va a celebrar su operación están destinados a
        var lista11ID = app.lang.getAppListStrings('tct_cpld_pregunta10_desp_list');
        var lista_campo25 = '';
        Object.keys(lista11ID).forEach(function (id) {
            //console.log(id, lista11ID[id]);
            lista_campo25 += '<option value="' + id + '">' + lista11ID[id] + '</option>'
        });
        this.lista_campo25 = lista_campo25;

        //listas FF
        //Carga de lista 5 ¿Con qué frecuencia o periodo realizará pagos a Unifin?
        var lista5ffID = app.lang.getAppListStrings('tct_pldcampo1_ff_ddw_list');
        var lista_campo21 = '';
        Object.keys(lista5ffID).forEach(function (id) {
            //console.log(id, lista5ffID[id]);
            lista_campo21 += '<option value="' + id + '">' + lista5ffID[id] + '</option>'
        });

        this.lista_campo21 = lista_campo21;

        //Carga de lista 6 ¿Cuál es el destino de los recursos que obtendrá de la celebración de esta operación?

        var lista6ffID = app.lang.getAppListStrings('tct_plddestinorecursos_ff_ddw_list');
        var lista_campo24 = '';
        Object.keys(lista6ffID).forEach(function (id) {
            //console.log(id, lista5ffID[id]);
            lista_campo24 += '<option value="' + id + '">' + lista6ffID[id] + '</option>'
        });
        this.lista_campo24 = lista_campo24;

        //Carga Listas de Credito Simple
        //Carga de lista 8 ¿Instrumento monetario con el que espera realizar los pagos? (*Es posible elegir más de una opción)

        var lista8ID = app.lang.getAppListStrings('tct_instmonetario_csddw_list');
        var lista_campo18 = '';
        Object.keys(lista8ID).forEach(function (id) {
            //console.log(id, lista8ID[id]);
            lista_campo18 += '<option value="' + id + '">' + lista8ID[id] + '</option>'
        });
        this.lista_campo18 = lista_campo18;

        //Carga de lista 9 ¿Cuál es el destino de los recursos que va a obtener de la celebración de la operación?

        var lista9ID = app.lang.getAppListStrings('tct_destinorecursos_csddw_list');
        var lista_campo20 = '';
        Object.keys(lista9ID).forEach(function (id) {
            //console.log(id, lista9ID[id]);
            lista_campo20 += '<option value="' + id + '">' + lista9ID[id] + '</option>'
        });
        this.lista_campo20 = lista_campo20;

    },

    ocultapanels: function () {
        //$(".content_ap").hide();
        $(".content_ff").hide();
        //$(".content_ca").hide();
        //$(".content_cs").hide();
    },

    //Validaciones para mostrar campos de Arrendamiento Puro
    Muestracampo1: function () {
        console.log("Propietario Real AP");
        if ($('.campo2ddw-ap').val() == "2") {
            $('.campo3-ap').show();
        } else {
            $('.campo3-ap').hide();
        }
    },

    Muestracampo2: function () {
        console.log("Proveedor de Recursos AP");
        if ($('.campo4ddw-ap').val() == "2") {
            $('.campo5-ap').show();
        } else {
            $('.campo5-ap').hide();
        }
    },

    //Validaciones para campos vistos en Persona Moral
    //pregunta La persona moral es: Sofom, Transmisor de Dinero, Centro Cambiario?
    Muestracampo3: function () {
        console.log("La persona moral es: Sofom, Transmisor de Dinero, Centro Cambiario?");
        if ($('.campo7ddw-pm').val() == "Si") {
            $('.campo8-PM').show();
        } else {
            $('.campo8-PM').hide();
        }
    },

    //pregunta La persona moral es: Sofom, Transmisor de Dinero, Centro Cambiario?
    Muestracampo4: function () {
        console.log("¿Cotiza en Bolsa?");
        if ($('.campo9ddw-pm').val() == "Si") {
            $('.campo10-PM').show();
        } else {
            $('.campo10-PM').hide();
        }
    },

    checkpagosmonetarioAP: function () {
        console.log("Esta check");
        if( $('.campo14chk-ap').is(':checked') ) {
            $('.campo17-ap').show();
        } else {
            $('.campo17-ap').hide();
        }
    },

    InsMonetarioAP: function () {
        console.log("Cambio de Instrumento monetario AP");
        if ($('#multi11').val("Otro")) {
            $('.campo14chk-ap').attr("checked", true);
            $('.campo17-ap').show();
        } else {
            $('.campo17-ap').hide();
        }
    },

    cuentaclient: function (){
        if ($('.campo25ddw-ap').val()=="Otro" ){
            $('.campo26-ap').show();
        }else{
            $('.campo26-ap').hide();
        }
    },

    //Validaciones para mostrar campos en Factoraje Financiero
    //Eventos Change (mostrar campos)
    Muestracampo1FF: function () {
        console.log("Propietario Real FF");
        if ($('.campo2ddw-ff').val() == "2") {

            $('.campo3-ff').show();
        } else {
            $('.campo3-ff').hide();
        }
    },

    Muestracampo2FF: function () {
        console.log("Proveedor de Recursos FF");
        if ($('.campo4ddw-ff').val() == "2") {
            $('.campo5-ff').show();
        } else {
            $('.campo5-ff').hide();
        }
    },


    checkpagosmonetarioFF: function (){
        if( $('.campo14chk-ff').is(':checked') ) {
            $('.campo17-ff').show();
        } else {
            $('.campo17-ff').hide();
        }
    },

    InsMonetarioFF: function () {
        console.log("Cambio de Instrumento monetario FF");
        if ($('#multi12').val("Otro")) {
            $('.campo14chk-ff').attr("checked", true);
            $('.campo17-ff').show();
        } else {
            $('.campo17-ff').hide();
        }
    },


    //Validaciones para mostrar campos en Credito Automotriz
    Muestracampo1CA: function () {
        console.log("Propietario Real CA");
        if ($('.campo2ddw-ca').val() == "2") {
            $('.campo3-ca').show();
        } else {
            $('.campo3-ca').hide();
        }
    },

    Muestracampo2CA: function () {
        console.log("Proveedor de Recursos CA");
        if ($('.campo4ddw-ca').val() == "2") {
            $('.campo5-ca').show();
        } else {
            $('.campo5-ca').hide();
        }
    },

    //Validaciones para mostrar campos en Credito Simple
    //Eventos Change (mostrar campos)

    Muestracampo1CS: function () {
        console.log("Propietario Real CS");
        if ($('.campo2ddw-cs').val() == "2") {
            $('.campo3-cs').show();
        } else {
            $('.campo3-cs').hide();
        }
    },

    Muestracampo2CS: function () {
        console.log("Proveedor de Recursos CS");
        if ($('.campo4ddw-cs').val() == "2") {
            $('.campo5-cs').show();
        } else {
            $('.campo5-cs').hide();
        }
    },

    InsMonetarioCS: function () {
        console.log("Cambio de Instrumento monetario CS");
        if ($('#multi13').val("Otro")) {
            $('.campo14chk-cs').attr("checked", true);
            $('.campo19-cs').show();
        } else {
            $('.campo19-cs').hide();
        }
    },

    checkpagosmonetarioCS: function (){
        if( $('.campo14chk-cs').is(':checked') ) {
            $('.campo19-cs').show();
        } else {
            $('.campo19-cs').hide();
        }
    },

    validaregimen: function (){
        if(this.model.get('tipodepersona_c') == 'Persona Moral'){
            //Muestra campos de vista de Persona Moral en panel de Arrendamiento puro
            $('.campo1-ap').show();
            $('.campo4-ap').show();
            $('.campo6-ap').show();
            $('.campo7-pm').show();
            $('.campo9-pm').show();
            $('.campo16-ap').show();
            $('.campo14-ap').show();
            $('.campo18-ap').show();
            $('.campo18-ap').show();
            $('.campo11-ap').show();
            //Oculta campos de vista de persona fisica en panel de Arrendamiento Puro
            $('.campo2-ap').hide();
            $('.campo3-ap').hide();
        }else{
            $('.campo1-ap').show();
            $('.campo2-ap').show();
            $('.campo4-ap').show();
            $('.campo6-ap').show();
            $('.campo16-ap').show();
            $('.campo14-ap').show();
        }

    },

    cuentacliente: function (){
        if(this.model.get('tipo_registro_c')=='Cliente'){
            $('.campo25-ap').show();
        }else{
            $('.campo25-ap').hide();
        }
    },

})