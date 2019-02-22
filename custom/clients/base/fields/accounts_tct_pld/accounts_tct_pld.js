({

    // J.A Solar
    ProductosPLD: null,
    // Listas PLD
    campo2_list: null,
    campo4_list: null,
    campo6_list: null,
    campo16_list: null,
    // campo7_list: null,
    // campo9_list: null,
    campo11_list: null,
    campo25_list: null,
    campo21_list: null,
    campo24_list: null,
    campo18_list: null,
    campo20_list: null,


    events :{
        'keydown .campo23dec-ff': 'keyDownNewExtension',
        'keydown .campo22int-ff':'keyDownNewExtension',
        'keydown .campo23dec-ff': 'checkInVentas',
        'keydown .campo22int-ff':'checkInVentas',

    },

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
        this.model.on("change:tipodepersona_c", _.bind(function () {
            pld.validaregimen();
        }, this));

    },

    loadData: function (options) {
        //Recupera data existente
        // if (pld.action == 'detail') {
        //Recupera datos para vista de detalle
        var idCuenta = pld.model.get('id');
        if (idCuenta=="" || idCuenta == undefined) {
            idCuenta = '1';
        }
        app.api.call('GET', app.api.buildURL('GetProductosPLD/' + idCuenta), null, {
            success: function (data) {
                //Recupera resultado
                pld.ProductosPLD = pld.formatDetailPLD(data);
                //Establece visibilidad por tipo de productos
                //AP
                if (App.user.attributes.tipodeproducto_c == '1') {
                    pld.ProductosPLD.arrendamientoPuro.visible = 'block';
                }
                //FF
                if (App.user.attributes.tipodeproducto_c == '4') {
                    pld.ProductosPLD.factorajeFinanciero.visible = 'block';
                }
                //CA
                if (App.user.attributes.tipodeproducto_c == '3') {
                    pld.ProductosPLD.creditoAutomotriz.visible = 'block';
                }
                //Agrega data a vardef
                self.model.set('accounts_tct_pld_1',pld.ProductosPLD);
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
        // dataPLD['arrendamientoPuro']['campo7_label'] = pld.campo7_list[dataPLD['arrendamientoPuro']['campo7']];
        // dataPLD['arrendamientoPuro']['campo9_label'] = pld.campo9_list[dataPLD['arrendamientoPuro']['campo9']];
        dataPLD['arrendamientoPuro']['campo6_label'] = pld.campo6_list[dataPLD['arrendamientoPuro']['campo6']];
        var auxCampo16=dataPLD['arrendamientoPuro']['campo16'].replace(/\^/g,"");
        var arrayCampo16=auxCampo16.split(",");
        var arrTemp=[];
        for(var i=0;i<arrayCampo16.length;i++)
        {
            arrTemp.push(pld.campo16_list[arrayCampo16[i]]);
        }
        dataPLD['arrendamientoPuro']['campo16_label'] =arrTemp.join();

        dataPLD['arrendamientoPuro']['campo25_label'] = pld.campo25_list[dataPLD['arrendamientoPuro']['campo25']];
        dataPLD['arrendamientoPuro']['campo11_label'] = pld.campo11_list[dataPLD['arrendamientoPuro']['campo11']];

        dataPLD['factorajeFinanciero']['campo2_label'] = pld.campo2_list[dataPLD['factorajeFinanciero']['campo2']];
        dataPLD['factorajeFinanciero']['campo4_label'] = pld.campo4_list[dataPLD['factorajeFinanciero']['campo4']];
        dataPLD['factorajeFinanciero']['campo21_label'] = pld.campo21_list[dataPLD['factorajeFinanciero']['campo21']];

        var auxCampo16=dataPLD['factorajeFinanciero']['campo16'].replace(/\^/g,"");
        var arrayCampo16=auxCampo16.split(",");
        var arrTemp=[];
        for(var i=0;i<arrayCampo16.length;i++)
        {
            arrTemp.push(pld.campo16_list[arrayCampo16[i]]);
        }
        dataPLD['factorajeFinanciero']['campo16_label'] =arrTemp.join();

        //dataPLD['factorajeFinanciero']['campo16_label'] = pld.campo16_list[dataPLD['factorajeFinanciero']['campo16']];
        dataPLD['factorajeFinanciero']['campo24_label'] = pld.campo24_list[dataPLD['factorajeFinanciero']['campo24']];
        dataPLD['factorajeFinanciero']['campo6_label'] = pld.campo6_list[dataPLD['factorajeFinanciero']['campo6']];

        dataPLD['creditoAutomotriz']['campo2_label'] = pld.campo2_list[dataPLD['creditoAutomotriz']['campo2']];
        dataPLD['creditoAutomotriz']['campo4_label'] = pld.campo4_list[dataPLD['creditoAutomotriz']['campo4']];
        dataPLD['creditoAutomotriz']['campo6_label'] = pld.campo6_list[dataPLD['creditoAutomotriz']['campo6']];

        dataPLD['creditoSimple']['campo2_label'] = pld.campo2_list[dataPLD['creditoSimple']['campo2']];
        dataPLD['creditoSimple']['campo4_label'] = pld.campo4_list[dataPLD['creditoSimple']['campo4']];

        var auxCampo18=dataPLD['creditoSimple']['campo18'].replace(/\^/g,"");
        var arrayCampo18=auxCampo18.split(",");
        var arrTemp=[];
        for(var i=0;i<arrayCampo18.length;i++)
        {
            arrTemp.push(pld.campo18_list[arrayCampo18[i]]);
        }
        dataPLD['creditoSimple']['campo18_label'] =arrTemp.join();

        // dataPLD['creditoSimple']['campo18_label'] = pld.campo18_list[dataPLD['creditoSimple']['campo18']];
        dataPLD['creditoSimple']['campo20_label'] = pld.campo20_list[dataPLD['creditoSimple']['campo20']];
        dataPLD['creditoSimple']['campo6_label'] = pld.campo6_list[dataPLD['creditoSimple']['campo6']];


        return dataPLD;
    },

    ListasDetail: function () {
        pld.campo2_list = app.lang.getAppListStrings('ctpldidproveedorrecursosclie_list');
        pld.campo4_list = app.lang.getAppListStrings('ctpldidproveedorrecursosson_list');
        pld.campo6_list = app.lang.getAppListStrings('tct_pagoanticipado_list');
        pld.campo16_list = app.lang.getAppListStrings('tct_inst_monetario_ddw_list');
        // pld.campo7_list = app.lang.getAppListStrings('tct_cpld_pregunta_u1_ddw_list'); campo SOFOM
        // pld.campo9_list = app.lang.getAppListStrings('tct_cpld_pregunta_u3_ddw_list'); cotiza en bolsa
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
        var selfPLD = this;
        $("div.record-label[data-name='accounts_tct_pld']").attr('style', 'display:none;');
        $('div[data-name=tct_nuevo_pld_c]').parent().attr('style', 'display:none;'); //Oculta campo tct_nuevo_pld_c

        $('select.campo16ddw-ap').change(function(evt) {
            var valorEx=evt.val;
            console.log('change16dd');
        });

        //Función related
        $('.bigdrop').each(function( index, value ) {
            $('#'+this.id).select2({
                placeholder: "Seleccionar Cuenta...",
                minimumInputLength: 1,
                allowClear: true,
                ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                    url: window.location.origin + window.location.pathname+"rest/v11_1/searchaccount",
                    dataType: 'json',
                    data: function (term, page) {
                        return {q:term};
                    },
                    results: function (data, page) { // parse the results into the format expected by Select2.
                        // since we are using custom formatting functions we do not need to alter remote JSON data
                        return {results: data.records};
                    }
                },
                formatResult: function(m) { return m.text; },
                formatSelection: function(m) { return m.text; }
            }).on('select2-open', _.bind(selfPLD._onSelect2Open, selfPLD))
                .on('searchmore', function() {
                    $(this).select2('close');//<------------
                    selfPLD.openSelectDrawer('#'+this.id);
                })
            //.on('change', _.bind(self._onSelect2Change, self));
        });

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
        /*//Muestra el campo Número de Registro ante la CNBV o Condusef PERSONA MORAL 1
        $('.campo7ddw-ap').change(function(evt) {
            pld.Muestracampo3();
        });

        //Muestra el campo Clave de Pizarra PERSONA MORAL 2
        $('.campo9ddw-ap').change(function(evt) {
            pld.Muestracampo4();
        });*/

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


        /*$('.campo25ddw-ap').change(function(evt)  {
            pld.cuentaclient();

        }); */

        /*$('.campo11ddw-ap').change(function(evt)  {
            pld.preguntamoral();

        });*/



        //Validacion para mostrar los campos de Arrendamiento Puro dependiendo el regimen fiscal (Persona Moral)
        pld.validaregimen();
        // pld.cuentacliente();

        //Set Related fields
        if (pld.ProductosPLD != null) {
            //AF
            $('.campo3rel-ap').select2('data', {id: selfPLD.ProductosPLD.arrendamientoPuro.campo3_id, text:  selfPLD.ProductosPLD.arrendamientoPuro.campo3});
            $('.campo5rel-ap').select2('data', {id: selfPLD.ProductosPLD.arrendamientoPuro.campo5_id, text:  selfPLD.ProductosPLD.arrendamientoPuro.campo5});
            //FF
            $('.campo3rel-ff').select2('data', {id: selfPLD.ProductosPLD.factorajeFinanciero.campo3_id, text:  selfPLD.ProductosPLD.factorajeFinanciero.campo3});
            $('.campo5rel-ff').select2('data', {id: selfPLD.ProductosPLD.factorajeFinanciero.campo5_id, text:  selfPLD.ProductosPLD.factorajeFinanciero.campo5});
            //CA
            $('.campo3rel-ca').select2('data', {id: selfPLD.ProductosPLD.creditoAutomotriz.campo3_id, text:  selfPLD.ProductosPLD.creditoAutomotriz.campo3});
            $('.campo5rel-ca').select2('data', {id: selfPLD.ProductosPLD.creditoAutomotriz.campo5_id, text:  selfPLD.ProductosPLD.creditoAutomotriz.campo5});
            //CS
            $('.campo3rel-cs').select2('data', {id: selfPLD.ProductosPLD.creditoSimple.campo3_id, text:  selfPLD.ProductosPLD.creditoSimple.campo3});
            $('.campo5rel-cs').select2('data', {id: selfPLD.ProductosPLD.creditoSimple.campo5_id, text:  selfPLD.ProductosPLD.creditoSimple.campo5});
        }

        //Set class to select2
        $('select.select2').select2();
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
        //Se añade este formato del multiselect del campo de direcciones
        $('#multi1').select2({
            width:'100%',
            //minimumResultsForSearch:7,
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });
        //Formato para cuenta existente
        $('#existingMulti1').select2({
            width:'100%',
            //minimumResultsForSearch:7,
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });

    },

    _onSelect2Open:function(e){
        var plugin = this.$(e.currentTarget).data('select2');
        if (plugin.searchmore) {
            return;
        }
        var label = app.lang.get('LBL_SEARCH_AND_SELECT_ELLIPSIS', this.module);
        var $tpl = $('<div/>').addClass('select2-result-label').html(label);
        var onMouseDown = function() {
            plugin.opts.element.trigger($.Event('searchmore'));
            plugin.close();
        };
        var $content = $('<li class="select2-result">').append($tpl).mousedown(onMouseDown);
        plugin.searchmore = $('<ul class="select2-results">').append($content);
        plugin.dropdown.append(plugin.searchmore);
    },

    openSelectDrawer: function (id) {
        app.drawer.open({
            layout: 'selection-list',
            context: {
                module: "Accounts",
                fields: ["id", "name"],
                filterOptions: undefined
            }
        },function(context, model) {
            $(id).select2("data",{id: context.id,text: context.value}).trigger("change");
        })
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

        /*  var lista5ID = app.lang.getAppListStrings('tct_cpld_pregunta_u1_ddw_list');
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
          this.lista_campo9 = lista_campo9; */

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
        if ($('.campo2ddw-ap').select2('val') == "2") {
            $('.campo3-ap').show();
        } else {
            $('.campo3-ap').hide();
        }
    },

    Muestracampo2: function () {
        console.log("Proveedor de Recursos AP");
        if ($('.campo4ddw-ap').select2('val') == "2") {
            $('.campo5-ap').show();
        } else {
            $('.campo5-ap').hide();
        }
    },

    //Validaciones para campos vistos en Persona Moral
    //pregunta La persona moral es: Sofom, Transmisor de Dinero, Centro Cambiario?
    /* Muestracampo3: function () {
         console.log("La persona moral es: Sofom, Transmisor de Dinero, Centro Cambiario?");
         if ($('.campo7ddw-ap').select2('val') == "Si") {
             $('.campo8-ap').show();
         } else {
             $('.campo8-ap').hide();
         }
     },

     //pregunta La persona moral es: Sofom, Transmisor de Dinero, Centro Cambiario?
     Muestracampo4: function () {
         console.log("¿Cotiza en Bolsa?");
         if ($('.campo9ddw-ap').select2('val') == "Si") {
             $('.campo10-ap').show();
         } else {
             $('.campo10-ap').hide();
         }
     },*/

    checkpagosmonetarioAP: function () {
        console.log("Esta check");
        if( $('.campo14chk-ap')[0].checked) {
            $('.campo17-ap').show();
        } else {
            $('.campo17-ap').hide();
        }
    },

    InsMonetarioAP: function () {
        console.log("Cambio de Instrumento monetario AP");
        if ($('.campo16ddw-ap').select2('val').toString().includes("Otro")) {
            $('.campo14chk-ap').attr("checked", true);
            $('.campo17-ap').show();
        } else {
            $('.campo17-ap').hide();
            $('.campo14chk-ap').attr("checked", false);
        }
    },

    /*cuentaclient: function (){
        if ($('.campo25ddw-ap').val()=="Otro" ){
            $('.campo26-ap').show();
        }else{
            $('.campo26-ap').hide();
        }
    }, */

    /*preguntamoral: function (){
        if ($('.campo11ddw-ap').select2('val') == "No") {
            $('.campo26-ap').show();
        } else {
            $('.campo26-ap').hide();
        }
    },*/

    //Validaciones para mostrar campos en Factoraje Financiero
    //Eventos Change (mostrar campos)
    Muestracampo1FF: function () {
        console.log("Propietario Real FF");
        if ($('.campo2ddw-ff').select2('val') == "2") {

            $('.campo3-ff').show();
        } else {
            $('.campo3-ff').hide();
        }
    },

    Muestracampo2FF: function () {
        console.log("Proveedor de Recursos FF");
        if ($('.campo4ddw-ff').select2('val') == "2") {
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
        if ($('#multi12').select2('val').toString().includes("Otro")) {
            $('.campo14chk-ff').attr("checked", true);
            $('.campo17-ff').show();
        } else {
            $('.campo17-ff').hide();
            $('.campo14chk-ff').attr("checked", false);
        }
    },


    //Validaciones para mostrar campos en Credito Automotriz
    Muestracampo1CA: function () {
        console.log("Propietario Real CA");
        if ($('.campo2ddw-ca').select2('val') == "2") {
            $('.campo3-ca').show();
        } else {
            $('.campo3-ca').hide();
        }
    },

    Muestracampo2CA: function () {
        console.log("Proveedor de Recursos CA");
        if ($('.campo4ddw-ca').select2('val') == "2") {
            $('.campo5-ca').show();
        } else {
            $('.campo5-ca').hide();
        }
    },

    //Validaciones para mostrar campos en Credito Simple
    //Eventos Change (mostrar campos)

    Muestracampo1CS: function () {
        console.log("Propietario Real CS");
        if ($('.campo2ddw-cs').select2('val') == "2") {
            $('.campo3-cs').show();
        } else {
            $('.campo3-cs').hide();
        }
    },

    Muestracampo2CS: function () {
        console.log("Proveedor de Recursos CS");
        if ($('.campo4ddw-cs').select2('val') == "2") {
            $('.campo5-cs').show();
        } else {
            $('.campo5-cs').hide();
        }
    },

    InsMonetarioCS: function () {
        console.log("Cambio de Instrumento monetario CS");
        if ($('#multi13').select2('val').toString().includes("otro")) {
            $('.campo14chk-cs').attr("checked", true);
            $('.campo19-cs').show();
        } else {
            $('.campo19-cs').hide();
            $('.campo14chk-cs').attr("checked", false);
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
        //Muestra campos por regimen fiscal
        //Campos nacen ocultos Arrendamiento Puro
        try {

            $('.campo2-ap').show();
            $('.campo4-ap').show();
            $('.campo6-ap').show();
            $('.campo16-ap').show();
            $('.campo14-ap').show();
            //$('.campo11-ap').show();
            //Campos Ocultos Arrendamiento Puro (Desplegables)
            //$('.campo3-ap').show();
            $('.campo5-ap').show();
            $('.campo17-ap').show();
            $('.campo15-ap').show();
            $('.campo18-ap').show();
            //Campos Persona Moral Arrendamiento Puro
            $('.campo7-ap').show(); //Pregunta1
            $('.campo9-ap').show(); //Pregunta2
            $('.campo8-ap').show();
            $('.campo10-ap').show();

            //$('.campo25-ap').show(); //Cuenta Cliente
            //$('.campo26-ap').show(); //Especifique cuenta Cliente
            //Campos Factoraje Financiero
            $('.campo3-ff').show();
            $('.campo5-ff').show();
            $('.campo17-ff').show();

            //Campos Credito Automotriz
            $('.campo3-ca').show();
            $('.campo5-ca').show();
            //Campos Credito Simple
            $('.campo3-cs').show();
            $('.campo5-cs').show();
            $('.campo15-cs').show();
            $('.campo19-cs').show();
            //Oculta panels
            $('.content_ap').hide();
            $('.content_ff').hide();
            $('.content_ca').hide();

            var puestousuario = App.user.attributes.puestousuario_c;
            var puestosvisibles = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "20", "33", "36", "44"];

            if (puestosvisibles.indexOf(puestousuario) >= 0) {

                //Establece visibilidad por tipo de productos
                //AP
                if (App.user.attributes.tipodeproducto_c == '1') {
                    $('.content_ap').show();
                }
                //FF
                if (App.user.attributes.tipodeproducto_c == '4') {
                    $('.content_ff').show();
                }
                //CA
                if (App.user.attributes.tipodeproducto_c == '3') {
                    $('.content_ca').show();
                }
            } else {
                $('.content_ap').show();
                $('.content_ff').show();
                $('.content_ca').show();
            }

            /*
            **  AP
            */
            // //Oculta campos de vista de persona fisica en panel de Arrendamiento Puro
            if (this.model.get('tipodepersona_c') == 'Persona Moral') {
                $('.campo2-ap').hide();
                $('.campo3-ap').hide();
            } else {
                $('.campo7-ap').hide();
                $('.campo8-ap').hide();
                $('.campo9-ap').hide();
                $('.campo10-ap').hide();
                //$('.campo11-ap').hide();
                $('.campo13-ap').hide();
                //$('.campo25-ap').hide();
                //$('.campo26-ap').hide();
            }
            //Muestra/oculta Propietario real
            if (this.model.get('tipodepersona_c') != 'Persona Moral' && $('.campo2ddw-ap').select2('val') == '2' || $('.campo2ddw-ap').attr('data-id') == '2') {
                $('.campo3-ap').show();
            } else {
                $('.campo3-ap').hide();
            }
            //Muestra/oculta Proveedor recursos
            if ($('.campo4ddw-ap').select2('val') == '2' || $('.campo4ddw-ap').attr('data-id') == '2') {
                $('.campo5-ap').show();
            } else {
                $('.campo5-ap').hide();
            }
            if ($('.campo7ddw-ap').select2('val') == "Si") {
                $('.campo8-ap').show();
            } else {
                $('.campo8-ap').hide();
            }
            if ($('.campo9ddw-ap').select2('val') == "Si") {
                $('.campo10-ap').show();
            } else {
                $('.campo10-ap').hide();
            }
            if ($('.campo16ddw-ap').select2('val').toString().includes("Otro") || $('.campo14chk-ap')[0].checked) {
                $('.campo17-ap').show();
            } else {
                $('.campo17-ap').hide();
            }
            /*if ($('.campo11ddw-ap').select2('val') == "No") {
                $('.campo26-ap').show();
            } else {
                $('.campo26-ap').hide();
            }*/

            /*
            **  FF
            */
            // //Oculta campos de vista de persona fisica en panel de Factoraje Financiero
            if (this.model.get('tipodepersona_c') == 'Persona Moral') {
                $('.campo2-ff').hide();
                $('.campo3-ff').hide();
            } else {
            }
            //Muestra/oculta Propietario real
            if (this.model.get('tipodepersona_c') != 'Persona Moral' && $('.campo2ddw-ff').select2('val') == '2' || $('.campo2ddw-ff').attr('data-id') == '2') {
                $('.campo3-ff').show();
            } else {
                $('.campo3-ff').hide();
            }
            //Muestra/oculta Proveedor recursos
            if ($('.campo4ddw-ff').select2('val') == '2' || $('.campo4ddw-ff').attr('data-id') == '2') {
                $('.campo5-ff').show();
            } else {
                $('.campo5-ff').hide();
            }
            if ($('#multi12').select2('val').toString().includes("Otro") || $('.campo14chk-ff')[0].checked) {
                $('.campo17-ff').show();
            } else {
                $('.campo17-ff').hide();
            }


            /*
            **  CA
            */
            // //Oculta campos de vista de persona fisica en panel de Crédito automotriz
            if (this.model.get('tipodepersona_c') == 'Persona Moral') {
                $('.campo2-ca').hide();
                $('.campo3-ca').hide();
            } else {
            }
            //Muestra/oculta Propietario real
            if (this.model.get('tipodepersona_c') != 'Persona Moral' && $('.campo2ddw-ca').select2('val') == '2' || $('.campo2ddw-ca').attr('data-id') == '2') {
                $('.campo3-ca').show();
            } else {
                $('.campo3-ca').hide();
            }
            //Muestra/oculta Proveedor recursos
            if ($('.campo4ddw-ca').select2('val') == '2' || $('.campo4ddw-ca').attr('data-id') == '2') {
                $('.campo5-ca').show();
            } else {
                $('.campo5-ca').hide();
            }

            /*
            **  CS
            */
            // //Oculta campos de vista de persona fisica en panel de Crédito simple
            //Muestra/oculta Propietario real
            if (this.model.get('tipodepersona_c') != 'Persona Moral' && $('.campo2ddw-cs').select2('val') == '2' || $('.campo2ddw-cs').attr('data-id') == '2') {
                $('.campo3-cs').show();
            } else {
                $('.campo3-cs').hide();
            }
            //Muestra/oculta Proveedor recursos
            if ($('.campo4ddw-cs').select2('val') == '2' || $('.campo4ddw-cs').attr('data-id') == '2') {
                $('.campo5-cs').show();
            } else {
                $('.campo5-cs').hide();
            }
            if ($('#multi13').select2('val').toString().includes("otro") || $('.campo14chk-cs')[0].checked) {
                $('.campo19-cs').show();
            } else {
                $('.campo19-cs').hide();
            }

            $('.campo11-ap').hide();
            $('.campo25-ap').hide();
            $('.campo26-ap').hide();
        }catch (err){
            console.log(err.message);
        }

        $('.campo11-ap').hide();
        $('.campo25-ap').hide();
        $('.campo26-ap').hide();
    },

    /*cuentacliente: function (){
        if(this.model.get('tipo_registro_c')=='Cliente'){
            $('.campo25-ap').show();
        }else{
            $('.campo25-ap').hide();
        }
    },*/

    keyDownNewExtension: function (evt) {
        if (!evt) return;
        if(!this.validamonto(evt)){
            return false;
        }
    },
    validamonto:function(evt){
        if($.inArray(evt.keyCode,[110,188,190,45,33,36,46,35,34,8,9,20,16,17,37,40,39,38,16,49,50,51,52,53,54,55,56,57,48,96,97,98,99,100,101,102,103,104,105]) < 0) {
            app.alert.show("Caracter Invalido", {
                level: "error",
                title: "Solo n\u00FAmeros son permitidos en este campo.",
                autoClose: true
            });
            return false;

        }else{
            return true;
        }
    },

    checkInVentas:function (evt) {
        var enteros=this.checkmoneyint(evt);
        var decimales=this.checkmoneydec(evt);
        $.fn.selectRange = function(start, end) {
            if(!end) end = start;
            return this.each(function() {
                if (this.setSelectionRange) {
                    this.focus();
                    this.setSelectionRange(start, end);
                } else if (this.createTextRange) {
                    var range = this.createTextRange();
                    range.collapse(true);
                    range.moveEnd('character', end);
                    range.moveStart('character', start);
                    range.select();
                }
            });
        };
        (function ($, undefined) {
            $.fn.getCursorPosition = function() {
                var el = $(this).get(0);
                var pos = [];
                if('selectionStart' in el) {
                    pos = [el.selectionStart,el.selectionEnd];
                } else if('selection' in document) {
                    el.focus();
                    var Sel = document.selection.createRange();
                    var SelLength = document.selection.createRange().text.length;
                    Sel.moveStart('character', -el.value.length);
                    pos = Sel.text.length - SelLength;
                }
                return pos;
            }
        })(jQuery); //funcion para obtener cursor
        var cursor=$(evt.handleObj.selector).getCursorPosition();//setear cursor


        if (enteros == "false" && decimales == "false") {
            if(cursor[0]==cursor[1]) {
                return false;
            }
        }else if (typeof enteros == "number" && decimales == "false") {
            if (cursor[0] < enteros) {
                $(evt.handleObj.selector).selectRange(cursor[0], cursor[1]);
            } else {
                $(evt.handleObj.selector).selectRange(enteros);
            }
        }

    },

    checkmoneyint: function (evt) {
        if (!evt) return;
        var $input = this.$(evt.currentTarget);
        var digitos = $input.val().split('.');
        if($input.val().includes('.')) {
            var justnum = /[\d]+/;
        }else{
            var justnum = /[\d.]+/;
        }
        var justint = /^[\d]{0,14}$/;

        if((justnum.test(evt.key))==false && evt.key!="Backspace" && evt.key!="Tab" && evt.key!="ArrowLeft" && evt.key!="ArrowRight"){
            app.alert.show('error_dinero', {
                level: 'error',
                autoClose: true,
                messages: 'El campo no acepta caracteres especiales.'
            });
            return "false";
        }

        if(typeof digitos[0]!="undefined") {
            if (justint.test(digitos[0]) == false && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
                //console.log('no se cumplen enteros')
                if(!$input.val().includes('.')) {
                    $input.val($input.val()+'.')
                }
                return "false";

            } else {
                return digitos[0].length;
            }
        }
    },

    checkmoneydec: function (evt) {
        if (!evt) return;
        var $input = this.$(evt.currentTarget);
        var digitos = $input.val().split('.');
        if($input.val().includes('.')) {
            var justnum = /[\d]+/;
        }else{
            var justnum = /[\d.]+/;
        }
        var justdec = /^[\d]{0,1}$/;

        if((justnum.test(evt.key))==false && evt.key!="Backspace" && evt.key!="Tab" && evt.key!="ArrowLeft" && evt.key!="ArrowRight"){
            app.alert.show('error_dinero', {
                level: 'error',
                autoClose: true,
                messages: 'El campo no acepta caracteres especiales.'
            });
            return "false";
        }
        if(typeof digitos[1]!="undefined") {
            if (justdec.test(digitos[1]) == false && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
                //console.log('no se cumplen dec')
                return "false";
            } else {
                return "true";
            }
        }
    },

})
