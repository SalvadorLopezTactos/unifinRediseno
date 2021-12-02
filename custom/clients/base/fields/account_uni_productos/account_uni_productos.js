({
    //Carga de Listas de valores
    razones_ddw_list: null,
    fuera_de_perfil_ddw_list: null,
    no_producto_requiere_list: null,
    razones_cf_list: null,
    tct_razon_ni_l_ddw_c_list: null,
    motivo_bloqueo_list_general:null,
    razon_list_general:null,
    motivo_bloqueo_list:null,
    razon_list:null,

    //Evento para la funcionalidad de que solo admita texto en los siguientes campos
    events: {
        'keydown .txt_l_nv_quien': 'PuroTexto', //Quien Leasing
        'keydown .txt_l_nv_porque': 'PuroTexto', //Porque Leasing
        'keydown .txt_l_nv_otro': 'PuroTexto', //¿Qué producto? Leasing
        'keydown .txt_f_nv_quien': 'PuroTexto', //Quien Factoraje
        'keydown .txt_f_nv_porque': 'PuroTexto', //Porque Factoraje
        'keydown .txt_f_nv_otro': 'PuroTexto', //¿Qué producto? Factoraje
        'keydown .txt_ca_nv_quien': 'PuroTexto', //Quien Credito Automotriz
        'keydown .txt_ca_nv_porque': 'PuroTexto', //Porque Credito Automotriz
        'keydown .txt_ca_nv_otro': 'PuroTexto', //¿Qué producto? Credito Automotriz
        'keydown .txt_fl_nv_quien': 'PuroTexto', //Quien Fleet
        'keydown .txt_fl_nv_porque': 'PuroTexto', //Porque Fleet
        'keydown .txt_fl_nv_otro': 'PuroTexto', //¿Qué producto? Fleet
        'keydown .txt_u_nv_quien': 'PuroTexto', //Quien Uniclick
        'keydown .txt_u_nv_porque': 'PuroTexto', //Porque Uniclick
        'keydown .txt_u_nv_otro': 'PuroTexto', //¿Qué producto? Uniclick
    },

    initialize: function (options) {
        //Inicializa campo custom
        this._super('initialize', [options]);
        options = options || {};
        options.def = options.def || {};
        cont_uni_p = this;

        cont_uni_p.carga_condiciones();
        cont_uni_p.carga_usuarios_resp_validacion();
        cont_uni_p.carga_usuarios_DirectorRegional();
        cont_uni_p.carga_usuarios_Cartera();
        //Guarda los valores hacia el modulo UNI PRODUCTOS
        this.model.addValidationTask('GuardaUniProductos', _.bind(this.SaveUniProductos, this));

        this.tipoProducto = {
            'leasing': {
                'producto': '1',
                'id': '',
                'no_viable': '',
                'no_viable_razon': '',
                'no_viable_razon_fp': '',
                'no_viable_quien': '',
                'no_viable_porque': '',
                'no_viable_producto': '',
                'no_viable_razon_cf': '',
                'no_viable_otro_c': '',
                'no_viable_razon_ni': '',
                'assigned_user_id': '',
                'status_management_c':'',
                'razon_c':'',
                'motivo_c':'',
                'detalle_c':'',
                'user_id1_c':'',
                'user_id2_c':''
            },
            'factoring': {
                'producto': '4',
                'id': '',
                'no_viable': '',
                'no_viable_razon': '',
                'no_viable_razon_fp': '',
                'no_viable_quien': '',
                'no_viable_porque': '',
                'no_viable_producto': '',
                'no_viable_razon_cf': '',
                'no_viable_otro_c': '',
                'no_viable_razon_ni': '',
                'assigned_user_id': '',
                'status_management_c':'',
                'razon_c':'',
                'motivo_c':'',
                'detalle_c':'',
                'user_id1_c':'',
                'user_id2_c':''
            },
            'credito_auto': {
                'producto': '3',
                'id': '',
                'no_viable': '',
                'no_viable_razon': '',
                'no_viable_razon_fp': '',
                'no_viable_quien': '',
                'no_viable_porque': '',
                'no_viable_producto': '',
                'no_viable_razon_cf': '',
                'no_viable_otro_c': '',
                'no_viable_razon_ni': '',
                'assigned_user_id': '',
                'status_management_c':'',
                'razon_c':'',
                'motivo_c':'',
                'detalle_c':'',
                'user_id1_c':'',
                'user_id2_c':''
            },
            'fleet': {
                'producto': '6',
                'id': '',
                'no_viable': '',
                'no_viable_razon': '',
                'no_viable_razon_fp': '',
                'no_viable_quien': '',
                'no_viable_porque': '',
                'no_viable_producto': '',
                'no_viable_razon_cf': '',
                'no_viable_otro_c': '',
                'no_viable_razon_ni': '',
                'assigned_user_id': '',
                'status_management_c':'',
                'razon_c':'',
                'motivo_c':'',
                'detalle_c':'',
                'user_id1_c':'',
                'user_id2_c':''
            },
            'uniclick': {
                'producto': '8',
                'id': '',
                'no_viable': '',
                'no_viable_razon': '',
                'no_viable_razon_fp': '',
                'no_viable_quien': '',
                'no_viable_porque': '',
                'no_viable_producto': '',
                'no_viable_razon_cf': '',
                'no_viable_otro_c': '',
                'no_viable_razon_ni': '',
                'assigned_user_id': '',
                'status_management_c':'',
                'razon_c':'',
                'motivo_c':'',
                'detalle_c':'',
                'user_id1_c':'',
                'user_id2_c':''
            }
        };


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
        this._super("_render");

        this.$("div.record-label[data-name='accounts_uni_productos']").attr('style', 'display:none;');

        $("span.normal[data-fieldname='account_uni_productos']").find('.row-fluid > .record-label').attr('style', 'display:none;');
        //campo custom account_uni_productos
        this.cargalistas(); //funcion de cargar listas

        /*********************Funciones de visibilidad para campos conforme al check en cada producto*************************/
        /*************Producto Leasing*************/
        $('.chk_l_nv').change(function (evt) {  //check - No Viable Leasing
            cont_uni_p.MuestraCamposLeasing();
        });
        $('.list_l_nv_razon').change(function (evt) { //LISTA - Razón de Lead no viable LEASING
            cont_uni_p.dependenciasLeasing();
        });
        $('.list_l_nv_producto').change(function (evt) { //LISTA - ¿Qué producto? LEASING
            cont_uni_p.dependenciasLeasing();
        });
        $('.list_l_estatus_lm').change(function (evt) {
            cont_uni_p.MuestraCamposLeasing_EstatusLM();
        });
        $('.list_l_estatus_lm').change(function (evt) {
            cont_uni_p.buscaRazon('1');
        });
        $('.list_l_so_razon').change(function (evt) {
            cont_uni_p.buscaMotivo('1');
        });
        $('.list_l_so_motivo').change(function (evt) {
            cont_uni_p.buscaMotivoFinal('1');
        });


        //$('#list_l_estatus_lm').change(function (evt) { //LISTA - Cambio de Estatus Lead Management Leasing
        //    cont_uni_p.MuestraCamposLeasing();
        //});
        /*************Producto Factoraje*************/
        $('.chk_f_nv').change(function (evt) {  //check - No Viable Factoraje
            cont_uni_p.MuestraCamposFactoraje();
        });
        $('.list_f_nv_razon').change(function (evt) { //LISTA - Razón de Lead no viable Factoraje
            cont_uni_p.dependenciasFactoraje();
        });
        $('.list_f_nv_producto').change(function (evt) { //LISTA - ¿Qué producto? Factoraje
            cont_uni_p.dependenciasFactoraje();
        });
        $('.list_fac_estatus_lm').change(function (evt) { //LISTA - Cambio de Estatus Lead Management Factoraje
            cont_uni_p.MuestraCamposFactoraje_EstatusLM();
        });
        $('.list_fac_estatus_lm').change(function (evt) { //LISTA - Cambio de Estatus Lead Management Factoraje
            cont_uni_p.buscaRazon('4');
        });
        $('.list_f_razon_lm').change(function (evt) { //LISTA - Cambio de Estatus Lead Management Factoraje
            cont_uni_p.buscaMotivo('4');
        });
        $('.list_f_so_motivo').change(function (evt) {
            cont_uni_p.buscaMotivoFinal('4');
        });

        /*************Producto Credito Automotriz*************/
        $('.chk_ca_nv').change(function (evt) {  //check - No Viable Credito Automotriz
            cont_uni_p.MuestraCamposCA();
        });
        $('.list_ca_nv_razon').change(function (evt) { //LISTA - Razón de Lead no viable Credito Automotriz
            cont_uni_p.dependenciasCA();
        });
        $('.list_ca_nv_producto').change(function (evt) { //LISTA - ¿Qué producto? Credito Automotriz
            cont_uni_p.dependenciasCA();
        });
        $('.list_ca_estatus_lm').change(function (evt) { //LISTA - Cambio de Estatus Lead Management Factoraje
            cont_uni_p.MuestraCamposCA_EstatusLM();
        });
        $('.list_ca_estatus_lm').change(function (evt) { //LISTA - ¿Qué producto? LEASING
            cont_uni_p.buscaRazon('3');
        });
        $('.list_ca_so_razon').change(function (evt) { //LISTA - ¿Qué producto? LEASING
            cont_uni_p.buscaMotivo('3');
        });
        $('.list_ca_so_motivo').change(function (evt) { //LISTA - ¿Qué producto? LEASING
            cont_uni_p.buscaMotivoFinal('3');
        });
        /*************Producto Fleet*************/
        $('.chk_fl_nv').change(function (evt) {  //check - No Viable Fleet
            cont_uni_p.MuestraCamposFleet();
        });
        $('.list_fl_nv_razon').change(function (evt) { //LISTA - Razón de Lead no viable Fleet
            cont_uni_p.dependenciasFleet();
        });
        $('.list_fl_nv_producto').change(function (evt) { //LISTA - ¿Qué producto? Fleet
            cont_uni_p.dependenciasFleet();
        });
        $('.list_fl_estatus_lm').change(function (evt) { //LISTA - Cambio de Estatus Lead Management Factoraje
            cont_uni_p.MuestraCamposFleet_EstatusLM();
        });
        $('.list_fl_estatus_lm').change(function (evt) { //LISTA
            cont_uni_p.buscaRazon('6');
        });
        $('.list_fl_so_razon').change(function (evt) { //LISTA - ¿Qué producto? LEASING
            cont_uni_p.buscaMotivo('6');
        });
        $('.list_fl_so_motivo').change(function (evt) { //LISTA - ¿Qué producto? LEASING
            cont_uni_p.buscaMotivoFinal('6');
        });
        /*************Producto Uniclick*************/
        $('.chk_u_nv').change(function (evt) {  //check - No Viable Uniclick
            cont_uni_p.MuestraCamposUniclick();
        });
        $('.list_u_nv_razon').change(function (evt) { //LISTA - Razón de Lead no viable Uniclick
            cont_uni_p.dependenciasUniclick();
        });
        $('.list_u_nv_producto').change(function (evt) { //LISTA - ¿Qué producto? Uniclick
            cont_uni_p.dependenciasUniclick();
        });
        $('.list_u_estatus_lm').change(function (evt) { //LISTA - Cambio de Estatus Lead Management Factoraje
            cont_uni_p.MuestraCamposUniclick_EstatusLM();
        });
        $('.list_u_estatus_lm').change(function (evt) { //LISTA - ¿Qué producto? LEASING
            cont_uni_p.buscaRazon('8');
        });
        $('.list_u_so_razon').change(function (evt) { //LISTA - ¿Qué producto? LEASING
            cont_uni_p.buscaMotivo('8');
        });
        $('.list_u_so_motivo').change(function (evt) { //LISTA - ¿Qué producto? LEASING
            cont_uni_p.buscaMotivoFinal('8');
        });

        //Pregunta el tipo de producto del usuario para poder editar campo de Lead no Viable
        $('[data-field="chk_l_nv"]').attr('style', 'pointer-events:none;'); //Check Leasing
        $('[data-field="chk_f_nv"]').attr('style', 'pointer-events:none;'); //Check Factoraje
        $('[data-field="chk_ca_nv"]').attr('style', 'pointer-events:none;'); //Check Credito-Auto
        $('[data-field="chk_fl_nv"]').attr('style', 'pointer-events:none;'); //Check Fleet
        $('[data-field="chk_u_nv"]').attr('style', 'pointer-events:none;'); //Check Uniclick

        $('[data-field="chk_ls_multi"]').attr('style', 'pointer-events:none;'); //Check Leasing
        $('[data-field="chk_fac_multi"]').attr('style', 'pointer-events:none;'); //Check Factoraje
        $('[data-field="chk_ca_multi"]').attr('style', 'pointer-events:none;'); //Check Credito-Auto
        $('[data-field="chk_fe_multi"]').attr('style', 'pointer-events:none;'); //Check Fleet
        $('[data-field="chk_uniclick_multi"]').attr('style', 'pointer-events:none;'); //Check Uniclick

        //inabilita campo check excluye_precalifiacion
        $('[data-field="chk_ls_excluir"]').attr('style','pointer-events:none');

        try {

            cont_uni_p.nvproductos(); //HABILITA LOS CHECK DEPENDIENDO LOS PRODUCTOS QUE TIENE EL USUARIO
            
            cont_uni_p.MuestraCamposLeasing(); //FUNCION PARA LOS CAMPOS LEASING
            cont_uni_p.MuestraCamposFactoraje(); //FUNCION PARA LOS CAMPOS FACTORAJE
            cont_uni_p.MuestraCamposCA(); //FUNCION PARA LOS CAMPOS CA
            cont_uni_p.MuestraCamposFleet(); //FUNCION PARA LOS CAMPOS FLEET
            cont_uni_p.MuestraCamposUniclick(); //FUNCION PARA LOS CAMPOS UNICLICK

            cont_uni_p.dependenciasLeasing(); //FUNCION DE DEPENDENCIA DE CAMPOS LEASING
            cont_uni_p.dependenciasFactoraje(); //FUNCION DE DEPENDENCIA DE CAMPOS FACTORAJE
            cont_uni_p.dependenciasCA(); //FUNCION DE DEPENDENCIA DE CAMPOS CA
            cont_uni_p.dependenciasFleet(); //FUNCION DE DEPENDENCIA DE CAMPOS FLEET
            cont_uni_p.dependenciasUniclick(); //FUNCION DE DEPENDENCIA DE CAMPOS UNICLICK

            cont_uni_p.noeditables();  //FUNCION PARA CAMPOS NO EDITABLES
            cont_uni_p.estatuslmCambio();

            //cont_uni_p.buscaRazon();

        } catch (err) {
            console.log(err.message);
        }
        //$('.list_u_canal').select2('val',cont_uni_p.ResumenProductos.uniclick.canal_c ); //lista Canal uniclcick

        //Funcion para dar estilo select2 a las listas deplegables.
        var $select = $('select.select2');
        $select.select2();

        //Validacion para campo exluir precalificacion
        if(App.user.attributes.excluir_precalifica_c== 1){
            $('[data-field="chk_ls_excluir"]').attr('style','pointer-events:block');
        }
    },

    /*************************************PRODUCTO LEASING*********************************************/
    MuestraCamposLeasing: function () {
        var productos = App.user.attributes.productos_c;

        $('.l_nv_razon').hide(); //CLASE Razón de Lead no viable LEASING
        $('.l_nv_razon_fp').hide(); //CLASE Fuera de Perfil (Razón) LEASING
        $('.l_nv_quien').hide(); //CLASE ¿Quién? LEASING
        $('.l_nv_porque').hide(); //CLASE ¿Por qué? LEASING
        $('.l_nv_producto').hide(); //CLASE ¿Qué producto? LEASING
        $('.l_nv_razon_cf').hide(); //CLASE Condiciones Financieras LEASING
        $('.l_nv_otro').hide(); //CLASE ¿Qué producto? LEASING
        $('.l_nv_razon_ni').hide(); //CLASE Razón No se encuentra interesado LEASING
         //$('.ls_estatus_lm_edit').hide();
         /************************************ */
        $('.l_so_razon').hide();
        $('.l_so_motivo').hide();
        $('.l_so_detalle').hide();
        $('.l_so_resp_ingesta').hide();
        $('.l_so_raspval1').hide();
        $('.l_so_raspval2').hide();
        $('.ls_estatus_lm').hide();
        $('.ls_estatus_lm_edit').hide();
        $('.l_so_raspval1_edit').hide();
        $('.l_so_raspval1').hide();
        $('.l_so_raspval2_edit').hide();
        $('.l_so_raspval2').hide();
        //$('.ls_estatus_lm_edit').hide();
        /************************************/

        if ($('.chk_l_nv')[0] != undefined) {
            if ($('.chk_l_nv')[0].checked) { //CHECK - CLASE No Viable Leasing
                $('.l_nv_razon').show(); //MUESTRA - CLASE Razón de Lead no viable LEASING
            }
        }

        if(cont_uni_p.action != "edit"){
            $('.ls_estatus_lm').show();
        }
        if(cont_uni_p.ResumenProductos!=undefined){
            if( cont_uni_p.ResumenProductos.leasing.status_management_c == '5' || cont_uni_p.ResumenProductos.leasing.status_management_c == '4'){
                if(cont_uni_p.action == "edit" ){
                    $('.ls_estatus_lm_edit').show();
                }else{
                    $('.ls_estatus_lm').show();
                }
                $('.l_so_raspval1').show();
                //$('.l_so_raspval2').show();
                $('.l_so_razon').show();
                $('.l_so_motivo').show();
                $('.l_so_detalle').show();
                $('.l_so_resp_ingesta').show();
                if (cont_uni_p.ResumenProductos.leasing.razon_c == '7' && cont_uni_p.ResumenProductos.leasing.motivo_c == '' ) { //PRODUCTO LEASING
                    $('.l_so_raspval2').show();
                }
                if (cont_uni_p.ResumenProductos.leasing.razon_c == '10' && cont_uni_p.ResumenProductos.leasing.motivo_c == '7' ) { //PRODUCTO LEASING
                    $('.l_so_raspval2').show();
                }
                /*if(this.busca_bloquea(cont_uni_p.ResumenProductos.leasing.status_management_c  , cont_uni_p.ResumenProductos.leasing.razon_c , cont_uni_p.ResumenProductos.leasing.motivo_c )){
                    $('.l_so_raspval2').show();
                } */
            }
            if(cont_uni_p.ResumenProductos.leasing.status_management_c == '1' ){
                if(cont_uni_p.ResumenProductos.leasing.deshabilitar_lmedit){
                    $('.ls_estatus_lm').show();
                }else{
                    $('.ls_estatus_lm_edit').show();
                }
            }
        }else if(cont_uni_p.action == "edit" && cont_uni_p.ResumenProductos==undefined){
            $('.ls_estatus_lm_edit').show();
        }

    },

    /*************************************PRODUCTO LEASING*********************************************/
    MuestraCamposLeasing_EstatusLM: function () {

        $('.l_so_razon').hide();
        $('.l_so_motivo').hide();
        $('.l_so_detalle').hide();
        $('.l_so_resp_ingesta').hide();
        $('.l_so_raspval1').hide();
        $('.l_so_raspval2').hide();
        $('.l_so_raspval1_edit').hide();
        $('.l_so_raspval2_edit').hide();
        //$('.ls_estatus_lm_edit').hide(); 
        /************************************/
        if (($('.list_l_estatus_lm').select2('val') == "4" || $('.list_l_estatus_lm').select2('val') == "5" ) ) { //PRODUCTO LEASING
            //$('.ls_estatus_lm').show();
            $('.l_so_razon').show();
            $('.l_so_motivo').show();
            $('.l_so_detalle').show();
            $('.l_so_resp_ingesta').show();
            $('.l_so_raspval1_edit').show();
            //$('.l_so_raspval2_edit').show();
            /****************************************/
            $('.list_l_so_razon').select2('val', "");
            $('.list_l_so_motivo').select2('val', "");
            $('.txt_l_so_detalle').val("");
            $('.list_l_respval_1').select2('val', "");
            $('.list_l_respval_2').select2('val', "");
            
        }

    },
    //FUNCION DE PRODUCTO LEASING PARA LAS DEPENDENCIAS DE LOS CAMPOS
    dependenciasLeasing: function () {
        // CLASE DE list_l_nv_razon -LISTA - Razón de Lead no viable LEASING
        if ($('.chk_l_nv')[0] != undefined) {
            if (($('.list_l_nv_razon').select2('val') == "Fuera de Perfil" || $('.list_l_nv_razon option:selected').text() == "Fuera de Perfil" || $('.list_l_nv_razon')[0].innerText.trim() == "Fuera de Perfil") && $('.chk_l_nv')[0].checked) {
                $('.l_nv_razon_fp').show(); //CLASE DIV Fuera de Perfil (Razón)
            } else {
                $('.l_nv_razon_fp').hide(); //CLASE DIV Fuera de Perfil (Razón)
                $('.list_l_nv_razon_fp').select2('val', ""); //CLASE LISTA Fuera de Perfil (Razón)
            }
            // CLASE DE list_l_nv_razon -LISTA - Razón de Lead no viable LEASING
            if (($('.list_l_nv_razon').select2('val') == "Ya está con la competencia" || $('.list_l_nv_razon option:selected').text() == "Ya está con la competencia" || $('.list_l_nv_razon')[0].innerText.trim() == "Ya está con la competencia" || $('.list_l_nv_razon option:selected').text() == "Ya está con la competencia") && $('.chk_l_nv')[0].checked) {
                $('.l_nv_quien').show(); //CLASE DIV ¿Quién? TEXTO
                $('.l_nv_porque').show(); //CLASE DIV ¿Por qué? TEXTO
            } else {
                $('.l_nv_quien').hide(); //CLASE DIV ¿Quién? TEXTO
                $('.l_nv_porque').hide(); //CLASE DIV ¿Por qué? TEXTO
                $('.txt_l_nv_quien').val(""); //CLASE DIV ¿Quién? TEXTO
                $('.txt_l_nv_porque').val(""); //CLASE DIV ¿Por qué? TEXTO
            }
            // CLASE DE list_l_nv_razon -LISTA - Razón de Lead no viable LEASING
            if (($('.list_l_nv_razon').select2('val') == "No tenemos el producto que requiere" || $('.list_l_nv_razon option:selected').text() == "No tenemos el producto que requiere" || $('.list_l_nv_razon')[0].innerText.trim() == "No tenemos el producto que requiere") && $('.chk_l_nv')[0].checked) {
                $('.l_nv_producto').show(); //clase lista - ¿Qué producto?
            } else {
                $('.l_nv_producto').hide(); //clase lista - ¿Qué producto?
                $('.list_l_nv_producto').select2('val', ""); //clase lista - ¿Qué producto?
            }
            // CLASE DE list_l_nv_razon -LISTA - Razón de Lead no viable LEASING
            if (($('.list_l_nv_razon').select2('val') == "Condiciones Financieras" || $('.list_l_nv_razon option:selected').text() == "Condiciones Financieras" || $('.list_l_nv_razon')[0].innerText.trim() == "Condiciones Financieras") && $('.chk_l_nv')[0].checked) {
                $('.l_nv_razon_cf').show(); //clase lista Condiciones Financieras
            } else {
                $('.l_nv_razon_cf').hide(); //clase lista Condiciones Financieras
                $('.list_l_nv_razon_cf').select2('val', ""); //clase lista Condiciones Financieras
            }
            // CLASE DE list_l_nv_razon -LISTA - Razón de Lead no viable LEASING
            if (($('.list_l_nv_razon').select2('val') == "No tenemos el producto que requiere" || $('.list_l_nv_razon option:selected').text() == "No tenemos el producto que requiere" || $('.list_l_nv_razon')[0].innerText.trim() == "No tenemos el producto que requiere") && ($('.list_l_nv_producto').select2('val') == "Otro" || $('.list_l_nv_producto option:selected').text() == "Otro" || $('.list_l_nv_producto')[0].innerText.trim() == "Otro") && $('.chk_l_nv')[0].checked) {
                $('.l_nv_otro').show(); //TEXTO CLASE ¿Qué producto?
            } else {
                $('.l_nv_otro').hide(); //TEXTO CLASE ¿Qué producto?
                $('.txt_l_nv_otro').val(""); //TEXTO CLASE ¿Qué producto?
            }
            // CLASE DE list_l_nv_razon -LISTA - Razón de Lead no viable LEASING
            if (($('.list_l_nv_razon').select2('val') == "No se encuentra interesado" || $('.list_l_nv_razon option:selected').text() == "No se encuentra interesado" || $('.list_l_nv_razon')[0].innerText.trim() == "No se encuentra interesado") && $('.chk_l_nv')[0].checked) {
                $('.l_nv_razon_ni').show(); //LISTA Razón No se encuentra interesado
            } else {
                $('.l_nv_razon_ni').hide(); //LISTA Razón No se encuentra interesado
                $('.list_l_nv_razon_ni').select2('val', ""); //LISTA Razón No se encuentra interesado
            }
        }
    },

    /*************************************PRODUCTO FACTORAJE*********************************************/
    MuestraCamposFactoraje: function () {
        var productos = App.user.attributes.productos_c;
        $('.f_nv_razon').hide(); //CLASE Razón de Lead no viable FACTORAJE
        $('.f_nv_razon_fp').hide(); //CLASE Fuera de Perfil (Razón) FACTORAJE
        $('.f_nv_quien').hide(); //CLASE ¿Quién? FACTORAJE
        $('.f_nv_porque').hide(); //CLASE ¿Por qué? FACTORAJE
        $('.f_nv_producto').hide(); //CLASE ¿Qué producto? FACTORAJE
        $('.f_nv_razon_cf').hide(); //CLASE Condiciones Financieras FACTORAJE
        $('.f_nv_otro').hide(); //CLASE ¿Qué producto? FACTORAJE
        $('.f_nv_razon_ni').hide(); //CLASE Razón No se encuentra interesado FACTORAJE
         /************************************/
         $('.f_so_razon').hide();
         $('.f_so_motivo').hide();
         $('.f_so_detalle').hide();
         $('.f_so_resp_ingesta').hide();
         $('.f_so_raspval1').hide();
         $('.f_so_raspval2').hide();
         $('.fac_estatus_lm').hide();
         $('.fac_estatus_lm_edit').hide();
         $('.f_so_raspval1_edit').hide();
         $('.f_so_raspval2_edit').hide();
         /************************************/
        if ($('.chk_f_nv')[0] != undefined) {
            if ($('.chk_f_nv')[0].checked) { //CHECK - CLASE No Viable FACTORAJE
                $('.f_nv_razon').show(); //MUESTRA - CLASE Razón de Lead no viable FACTORAJE
            }
        }

        if(cont_uni_p.action != "edit"){
            $('.fac_estatus_lm').show();
        }

        if(cont_uni_p.ResumenProductos!=undefined){
            if( cont_uni_p.ResumenProductos.factoring.status_management_c == '5' || cont_uni_p.ResumenProductos.factoring.status_management_c == '4'){
                if(cont_uni_p.action == "edit" ){
                    $('.fac_estatus_lm_edit').show();
                }else{
                    $('.fac_estatus_lm').show();
                }
                $('.f_so_razon').show();
                $('.f_so_motivo').show();
                $('.f_so_detalle').show();
                $('.f_so_resp_ingesta').show();
                $('.f_so_raspval1').show();
                //$('.f_so_raspval2').show();
                /*if(this.busca_bloquea(cont_uni_p.ResumenProductos.factoring.status_management_c  , cont_uni_p.ResumenProductos.factoring.razon_c , cont_uni_p.ResumenProductos.factoring.motivo_c )){
                    $('.f_so_raspval2').show();
                }*/
                if (cont_uni_p.ResumenProductos.factoring.razon_c == '7' && cont_uni_p.ResumenProductos.factoring.motivo_c == '' ) { //PRODUCTO LEASING
                    $('.l_so_raspval2').show();
                }
                if (cont_uni_p.ResumenProductos.factoring.razon_c == '10' && cont_uni_p.ResumenProductos.factoring.motivo_c == '7' ) { //PRODUCTO LEASING
                    $('.l_so_raspval2').show();
                }
            }
            if(cont_uni_p.ResumenProductos.factoring.status_management_c == '1' ){
                if(cont_uni_p.ResumenProductos.factoring.deshabilitar_lmedit){
                    $('.fac_estatus_lm').show();
                }else{
                    $('.fac_estatus_lm_edit').show();
                }
            }
        }else if(cont_uni_p.action == "edit" && cont_uni_p.ResumenProductos==undefined){
            $('.fac_estatus_lm_edit').show();
        }
    },
    /*************************************PRODUCTO FACTORAJE*********************************************/
    MuestraCamposFactoraje_EstatusLM: function () {

        $('.f_so_razon').hide();
        $('.f_so_motivo').hide();
        $('.f_so_detalle').hide();
        $('.f_so_resp_ingesta').hide();
        $('.f_so_raspval1').hide();
        $('.f_so_raspval2').hide();
        $('.f_so_raspval1_edit').hide();
        $('.f_so_raspval2_edit').hide();
        //$('.ls_estatus_lm_edit').hide();
        /************************************/
        if (($('.list_fac_estatus_lm').select2('val') == "4" || $('.list_fac_estatus_lm').select2('val') == "5" ) ) { //PRODUCTO LEASING
            //$('.ls_estatus_lm').show();
            $('.f_so_razon').show();
            $('.f_so_motivo').show();
            $('.f_so_detalle').show();
            $('.f_so_resp_ingesta').show();
            $('.f_so_raspval1_edit').show();
            //$('.f_so_raspval2_edit').show();
            /****************************************/
            $('.list_f_razon_lm').select2('val', "");
            $('.list_f_so_motivo').select2('val', "");
            $('.txt_f_so_detalle').val("");
            $('.list_f_respval_1').select2('val', "");
            $('.list_f_respval_2').select2('val', "");
        }

    },
    //FUNCION DE PRODUCTO FACTORAJE PARA LAS DEPENDENCIAS DE LOS CAMPOS
    dependenciasFactoraje: function () {
        if ($('.chk_f_nv')[0] != undefined) {
            // CLASE DE list_f_nv_razon -LISTA - Razón de Lead no viable FACTORAJE
            if (($('.list_f_nv_razon').select2('val') == "Fuera de Perfil" || $('.list_f_nv_razon option:selected').text() == "Fuera de Perfil" || $('.list_f_nv_razon')[0].innerText.trim() == "Fuera de Perfil") && $('.chk_f_nv')[0].checked) {
                $('.f_nv_razon_fp').show(); //CLASE DIV Fuera de Perfil (Razón)
            } else {
                $('.f_nv_razon_fp').hide(); //CLASE DIV Fuera de Perfil (Razón)
                $('.list_f_nv_razon_fp').select2('val', ""); //CLASE LISTA Fuera de Perfil (Razón)
            }
            // CLASE DE list_f_nv_razon -LISTA - Razón de Lead no viable FACTORAJE
            if (($('.list_f_nv_razon').select2('val') == "Ya está con la competencia" || $('.list_f_nv_razon option:selected').text() == "Ya está con la competencia" || $('.list_f_nv_razon')[0].innerText.trim() == "Ya está con la competencia" || $('.list_f_nv_razon option:selected').text() == "Ya está con la competencia") && $('.chk_f_nv')[0].checked) {
                $('.f_nv_quien').show(); //CLASE DIV ¿Quién? TEXTO
                $('.f_nv_porque').show(); //CLASE DIV ¿Por qué? TEXTO
            } else {
                $('.f_nv_quien').hide(); //CLASE DIV ¿Quién? TEXTO
                $('.f_nv_porque').hide(); //CLASE DIV ¿Por qué? TEXTO
                $('.txt_f_nv_quien').val(""); //CLASE DIV ¿Quién? TEXTO
                $('.txt_f_nv_porque').val(""); //CLASE DIV ¿Por qué? TEXTO
            }
            // CLASE DE list_f_nv_razon -LISTA - Razón de Lead no viable LEASING
            if (($('.list_f_nv_razon').select2('val') == "No tenemos el producto que requiere" || $('.list_f_nv_razon option:selected').text() == "No tenemos el producto que requiere" || $('.list_f_nv_razon')[0].innerText.trim() == "No tenemos el producto que requiere") && $('.chk_f_nv')[0].checked) {
                $('.f_nv_producto').show(); //clase lista - ¿Qué producto?
            } else {
                $('.f_nv_producto').hide(); //clase lista - ¿Qué producto?
                $('.list_f_nv_producto').select2('val', ""); //clase lista - ¿Qué producto?
            }
            // CLASE DE list_f_nv_razon -LISTA - Razón de Lead no viable LEASING
            if (($('.list_f_nv_razon').select2('val') == "Condiciones Financieras" || $('.list_f_nv_razon option:selected').text() == "Condiciones Financieras" || $('.list_f_nv_razon')[0].innerText.trim() == "Condiciones Financieras") && $('.chk_f_nv')[0].checked) {
                $('.f_nv_razon_cf').show(); //clase lista Condiciones Financieras
            } else {
                $('.f_nv_razon_cf').hide(); //clase lista Condiciones Financieras
                $('.list_f_nv_razon_cf').select2('val', ""); //clase lista Condiciones Financieras
            }
            // CLASE DE list_f_nv_razon -LISTA - Razón de Lead no viable LEASING
            if (($('.list_f_nv_razon').select2('val') == "No tenemos el producto que requiere" || $('.list_f_nv_razon option:selected').text() == "No tenemos el producto que requiere" || $('.list_f_nv_razon')[0].innerText.trim() == "No tenemos el producto que requiere") && ($('.list_f_nv_producto').select2('val') == "Otro" || $('.list_f_nv_producto option:selected').text() == "Otro" || $('.list_f_nv_producto')[0].innerText.trim() == "Otro") && $('.chk_f_nv')[0].checked) {
                $('.f_nv_otro').show(); //TEXTO CLASE ¿Qué producto?
            } else {
                $('.f_nv_otro').hide(); //TEXTO CLASE ¿Qué producto?
                $('.txt_f_nv_otro').val(""); //TEXTO CLASE ¿Qué producto?
            }
            // CLASE DE list_f_nv_razon -LISTA - Razón de Lead no viable LEASING
            if (($('.list_f_nv_razon').select2('val') == "No se encuentra interesado" || $('.list_f_nv_razon option:selected').text() == "No se encuentra interesado" || $('.list_f_nv_razon')[0].innerText.trim() == "No se encuentra interesado") && $('.chk_f_nv')[0].checked) {
                $('.f_nv_razon_ni').show(); //LISTA Razón No se encuentra interesado
            } else {
                $('.f_nv_razon_ni').hide(); //LISTA Razón No se encuentra interesado
                $('.list_f_nv_razon_ni').select2('val', ""); //LISTA Razón No se encuentra interesado
            }
        }
    },

    /*************************************PRODUCTO CREDITO AUTOMOTRIZ*********************************************/
    MuestraCamposCA: function () {
        var productos = App.user.attributes.productos_c;
        $('.ca_nv_razon').hide(); //CLASE Razón de Lead no viable CA
        $('.ca_nv_razon_fp').hide(); //CLASE Fuera de Perfil (Razón) CA
        $('.ca_nv_quien').hide(); //CLASE ¿Quién? CA
        $('.ca_nv_porque').hide(); //CLASE ¿Por qué? CA
        $('.ca_nv_producto').hide(); //CLASE ¿Qué producto? CA
        $('.ca_nv_razon_cf').hide(); //CLASE Condiciones Financieras CA
        $('.ca_nv_otro').hide(); //CLASE ¿Qué producto? CA
        $('.ca_nv_razon_ni').hide(); //CLASE Razón No se encuentra interesado CA
        /************************************/
        $('.ca_so_razon').hide();
        $('.ca_so_motivo').hide();
        $('.ca_so_detalle').hide();
        $('.ca_so_resp_ingesta').hide();
        $('.ca_so_raspval1').hide();
        $('.ca_so_raspval2').hide();
        $('.ca_estatus_lm_edit').hide();
        $('.ca_estatus_lm').hide();
        $('.ca_so_raspval1_edit').hide();
        $('.ca_so_raspval2_edit').hide();
        /************************************/
        if ($('.chk_ca_nv')[0] != undefined) {
            if ($('.chk_ca_nv')[0].checked) { //CHECK - CLASE No Viable CA
                $('.ca_nv_razon').show(); //MUESTRA - CLASE Razón de Lead no viable CA
            }
        }
        if(cont_uni_p.action != "edit"){
            $('.ca_estatus_lm').show();
        }
        if(cont_uni_p.ResumenProductos!=undefined){
            if( cont_uni_p.ResumenProductos.credito_auto.status_management_c == '5' || cont_uni_p.ResumenProductos.credito_auto.status_management_c == '4'){
                if(cont_uni_p.action == "edit" ){
                    $('.ca_estatus_lm_edit').show();
                }else{
                    $('.ca_estatus_lm').show();
                }
                $('.ca_so_razon').show();
                $('.ca_so_motivo').show();
                $('.ca_so_detalle').show();
                $('.ca_so_resp_ingesta').show();
                $('.ca_so_raspval1').show();
                //$('.ca_so_raspval2').show();
                /*if(this.busca_bloquea(cont_uni_p.ResumenProductos.credito_auto.status_management_c  , cont_uni_p.ResumenProductos.credito_auto.razon_c , cont_uni_p.ResumenProductos.credito_auto.motivo_c )){
                    $('.ca_so_raspval2').show();
                }*/
                if (cont_uni_p.ResumenProductos.credito_auto.razon_c == '7' && cont_uni_p.ResumenProductos.credito_auto.motivo_c == '' ) { //PRODUCTO LEASING
                    $('.l_so_raspval2').show();
                }
                if (cont_uni_p.ResumenProductos.credito_auto.razon_c == '10' && cont_uni_p.ResumenProductos.credito_auto.motivo_c == '7' ) { //PRODUCTO LEASING
                    $('.l_so_raspval2').show();
                }
            }
            if(cont_uni_p.ResumenProductos.credito_auto.status_management_c == '1' ){
                if(cont_uni_p.ResumenProductos.credito_auto.deshabilitar_lmedit){
                    $('.ca_estatus_lm').show();
                }else{
                    $('.ca_estatus_lm_edit').show();
                }
            }
        }else if(cont_uni_p.action == "edit" && cont_uni_p.ResumenProductos==undefined){
            $('.ca_estatus_lm_edit').show();
        }
    },
    /*************************************PRODUCTO CREDITO AUTOMOTRIZ*********************************************/
    MuestraCamposCA_EstatusLM: function () {

        $('.ca_so_razon').hide();
        $('.ca_so_motivo').hide();
        $('.ca_so_detalle').hide();
        $('.ca_so_resp_ingesta').hide();
        $('.ca_so_raspval1').hide();
        $('.ca_so_raspval2').hide();
        $('.ca_so_raspval1_edit').hide();
        $('.ca_so_raspval2_edit').hide();
        //$('.ls_estatus_lm_edit').hide();
        /************************************/
        if (($('.list_ca_estatus_lm').select2('val') == "4" || $('.list_ca_estatus_lm').select2('val') == "5" ) ) { //PRODUCTO LEASING
            //$('.ls_estatus_lm').show();
            $('.ca_so_razon').show();
            $('.ca_so_motivo').show();
            $('.ca_so_detalle').show();
            $('.ca_so_resp_ingesta').show();
            $('.ca_so_raspval1_edit').show();
            //$('.ca_so_raspval2_edit').show();
            /****************************************/
            $('.list_ca_so_razon').select2('val', "");
            $('.list_ca_so_motivo').select2('val', "");
            $('.txt_ca_so_detalle').val("");
            $('.list_ca_respval_1').select2('val', "");
            $('.list_ca_respval_2').select2('val', "");
        }

    },
    //FUNCION DE PRODUCTO CREDITO AUTOMOTRIZ PARA LAS DEPENDENCIAS DE LOS CAMPOS
    dependenciasCA: function () {

        if ($('.chk_ca_nv')[0] != undefined) {
            // CLASE DE list_ca_nv_razon -LISTA - Razón de Lead no viable CA
            if (($('.list_ca_nv_razon').select2('val') == "Fuera de Perfil" || $('.list_ca_nv_razon option:selected').text() == "Fuera de Perfil" || $('.list_ca_nv_razon')[0].innerText.trim() == "Fuera de Perfil") && $('.chk_ca_nv')[0].checked) {
                $('.ca_nv_razon_fp').show(); //CLASE DIV Fuera de Perfil (Razón)
            } else {
                $('.ca_nv_razon_fp').hide(); //CLASE DIV Fuera de Perfil (Razón)
                $('.list_ca_nv_razon_fp').select2('val', ""); //CLASE LISTA Fuera de Perfil (Razón)
            }
            // CLASE DE list_ca_nv_razon -LISTA - Razón de Lead no viable CA
            if (($('.list_ca_nv_razon').select2('val') == "Ya está con la competencia" || $('.list_ca_nv_razon option:selected').text() == "Ya está con la competencia" || $('.list_ca_nv_razon')[0].innerText.trim() == "Ya está con la competencia" || $('.list_ca_nv_razon option:selected').text() == "Ya está con la competencia") && $('.chk_ca_nv')[0].checked) {
                $('.ca_nv_quien').show(); //CLASE DIV ¿Quién? TEXTO
                $('.ca_nv_porque').show(); //CLASE DIV ¿Por qué? TEXTO
            } else {
                $('.ca_nv_quien').hide(); //CLASE DIV ¿Quién? TEXTO
                $('.ca_nv_porque').hide(); //CLASE DIV ¿Por qué? TEXTO
                $('.txt_ca_nv_quien').val(""); //CLASE DIV ¿Quién? TEXTO
                $('.txt_ca_nv_porque').val(""); //CLASE DIV ¿Por qué? TEXTO
            }
            // CLASE DE list_ca_nv_razon -LISTA - Razón de Lead no viable CA
            if (($('.list_ca_nv_razon').select2('val') == "No tenemos el producto que requiere" || $('.list_ca_nv_razon option:selected').text() == "No tenemos el producto que requiere" || $('.list_ca_nv_razon')[0].innerText.trim() == "No tenemos el producto que requiere") && $('.chk_ca_nv')[0].checked) {
                $('.ca_nv_producto').show(); //clase lista - ¿Qué producto?
            } else {
                $('.ca_nv_producto').hide(); //clase lista - ¿Qué producto?
                $('.list_ca_nv_producto').select2('val', ""); //clase lista - ¿Qué producto?
            }
            // CLASE DE list_ca_nv_razon -LISTA - Razón de Lead no viable CA
            if (($('.list_ca_nv_razon').select2('val') == "Condiciones Financieras" || $('.list_ca_nv_razon option:selected').text() == "Condiciones Financieras" || $('.list_ca_nv_razon')[0].innerText.trim() == "Condiciones Financieras") && $('.chk_ca_nv')[0].checked) {
                $('.ca_nv_razon_cf').show(); //clase lista Condiciones Financieras
            } else {
                $('.ca_nv_razon_cf').hide(); //clase lista Condiciones Financieras
                $('.list_ca_nv_razon_cf').select2('val', ""); //clase lista Condiciones Financieras
            }
            // CLASE DE list_ca_nv_razon -LISTA - Razón de Lead no viable CA
            if (($('.list_ca_nv_razon').select2('val') == "No tenemos el producto que requiere" || $('.list_ca_nv_razon option:selected').text() == "No tenemos el producto que requiere" || $('.list_ca_nv_razon')[0].innerText.trim() == "No tenemos el producto que requiere") && ($('.list_ca_nv_producto').select2('val') == "Otro" || $('.list_ca_nv_producto option:selected').text() == "Otro" || $('.list_ca_nv_producto')[0].innerText.trim() == "Otro") && $('.chk_ca_nv')[0].checked) {
                $('.ca_nv_otro').show(); //TEXTO CLASE ¿Qué producto?
            } else {
                $('.ca_nv_otro').hide(); //TEXTO CLASE ¿Qué producto?
                $('.txt_ca_nv_otro').val(""); //TEXTO CLASE ¿Qué producto?
            }
            // CLASE DE list_ca_nv_razon -LISTA - Razón de Lead no viable CA
            if (($('.list_ca_nv_razon').select2('val') == "No se encuentra interesado" || $('.list_ca_nv_razon option:selected').text() == "No se encuentra interesado" || $('.list_ca_nv_razon')[0].innerText.trim() == "No se encuentra interesado") && $('.chk_ca_nv')[0].checked) {
                $('.ca_nv_razon_ni').show(); //LISTA Razón No se encuentra interesado
            } else {
                $('.ca_nv_razon_ni').hide(); //LISTA Razón No se encuentra interesado
                $('.list_ca_nv_razon_ni').select2('val', ""); //LISTA Razón No se encuentra interesado
            }
        }
    },

    /*************************************PRODUCTO FLEET*********************************************/
    MuestraCamposFleet: function () {
        var productos = App.user.attributes.productos_c;
        $('.fl_nv_razon').hide(); //CLASE Razón de Lead no viable FLEET
        $('.fl_nv_razon_fp').hide(); //CLASE Fuera de Perfil (Razón) FLEET
        $('.fl_nv_quien').hide(); //CLASE ¿Quién? FLEET
        $('.fl_nv_porque').hide(); //CLASE ¿Por qué? FLEET
        $('.fl_nv_producto').hide(); //CLASE ¿Qué producto? FLEET
        $('.fl_nv_razon_cf').hide(); //CLASE Condiciones Financieras FLEET
        $('.fl_nv_otro').hide(); //CLASE ¿Qué producto? FLEET
        $('.fl_nv_razon_ni').hide(); //CLASE Razón No se encuentra interesado FLEET
        /*********************************************/
        $('.fl_so_razon').hide();
        $('.fl_so_motivo').hide();
        $('.fl_so_detalle').hide();
        $('.fl_so_resp_ingesta').hide();
        $('.fe_estatus_lm').hide();
        $('.fe_estatus_lm_edit').hide();
        $('.fl_so_raspval1_edit').hide();
        $('.fl_so_raspval1').hide();
        $('.fl_so_raspval2_edit').hide();
        $('.fl_so_raspval2').hide();
        /************************************/
        if ($('.chk_fl_nv')[0] != undefined) {
            if ($('.chk_fl_nv')[0].checked) { //CHECK - CLASE No Viable FLEET
                $('.fl_nv_razon').show(); //MUESTRA - CLASE Razón de Lead no viable FLEET
            }
        }

        if(cont_uni_p.action != "edit"){
            $('.fe_estatus_lm').show();
        }
        if(cont_uni_p.ResumenProductos!=undefined){
            if( cont_uni_p.ResumenProductos.fleet.status_management_c == '5' || cont_uni_p.ResumenProductos.fleet.status_management_c == '4'){
                if(cont_uni_p.action == "edit" ){
                    $('.fe_estatus_lm_edit').show();
                }else{
                    $('.fe_estatus_lm').show();
                }
                $('.fl_so_razon').show();
                $('.fl_so_motivo').show();
                $('.fl_so_detalle').show();
                $('.fl_so_resp_ingesta').show();
                $('.fl_so_raspval1').show();
                //$('.fl_so_raspval2').show();
                /*if(this.busca_bloquea(cont_uni_p.ResumenProductos.fleet.status_management_c  , cont_uni_p.ResumenProductos.fleet.razon_c , cont_uni_p.ResumenProductos.fleet.motivo_c )){
                    $('.fl_so_raspval2').show();
                }*/
                if (cont_uni_p.ResumenProductos.fleet.razon_c == '7' && cont_uni_p.ResumenProductos.fleet.motivo_c == '' ) { //PRODUCTO LEASING
                    $('.l_so_raspval2').show();
                }
                if (cont_uni_p.ResumenProductos.fleet.razon_c == '10' && cont_uni_p.ResumenProductos.fleet.motivo_c == '7' ) { //PRODUCTO LEASING
                    $('.l_so_raspval2').show();
                }
            }
            if(cont_uni_p.ResumenProductos.fleet.status_management_c == '1' ){
                if(cont_uni_p.ResumenProductos.fleet.deshabilitar_lmedit){
                    $('.fe_estatus_lm').show();
                }else{
                    $('.fe_estatus_lm_edit').show();
                }
            }
        }else if(cont_uni_p.action == "edit" && cont_uni_p.ResumenProductos==undefined){
            $('.fe_estatus_lm_edit').show();
        }
    },

    /*************************************PRODUCTO FLEET*********************************************/
    MuestraCamposFleet_EstatusLM: function () {

        $('.fl_so_razon').hide();
        $('.fl_so_motivo').hide();
        $('.fl_so_detalle').hide();
        $('.fl_so_resp_ingesta').hide();
        $('.fl_so_raspval1').hide();
        $('.fl_so_raspval2').hide();
        $('.fl_so_raspval1_edit').hide();
        $('.fl_so_raspval2_edit').hide();
        //$('.ls_estatus_lm_edit').hide();
        /*******************************************/
        if (($('.list_fl_estatus_lm').select2('val') == "4" || $('.list_fl_estatus_lm').select2('val') == "5" ) ) { //PRODUCTO LEASING
            //$('.ls_estatus_lm').show();
            $('.fl_so_razon').show();
            $('.fl_so_motivo').show();
            $('.fl_so_detalle').show();
            $('.fl_so_resp_ingesta').show();
            $('.fl_so_raspval1_edit').show();
            //$('.fl_so_raspval2_edit').show();
            /****************************************/
            $('.list_fl_so_razon').select2('val', "");
            $('.list_fl_so_motivo').select2('val', "");
            $('.txt_fl_so_detalle').val("");
            $('.list_fl_respval_1').select2('val', "");
            $('.list_fl_respval_2').select2('val', "");
        }
    },
    //FUNCION DE PRODUCTO FLEET PARA LAS DEPENDENCIAS DE LOS CAMPOS
    dependenciasFleet: function () {

        if ($('.chk_fl_nv')[0] != undefined) {
            // CLASE DE list_fl_nv_razon -LISTA - Razón de Lead no viable FLEET
            if (($('.list_fl_nv_razon').select2('val') == "Fuera de Perfil" || $('.list_fl_nv_razon option:selected').text() == "Fuera de Perfil" || $('.list_fl_nv_razon')[0].innerText.trim() == "Fuera de Perfil") && $('.chk_fl_nv')[0].checked) {
                $('.fl_nv_razon_fp').show(); //CLASE DIV Fuera de Perfil (Razón)
            } else {
                $('.fl_nv_razon_fp').hide(); //CLASE DIV Fuera de Perfil (Razón)
                $('.list_fl_nv_razon_fp').select2('val', ""); //CLASE LISTA Fuera de Perfil (Razón)
            }
            // CLASE DE list_fl_nv_razon -LISTA - Razón de Lead no viable FLEET
            if (($('.list_fl_nv_razon').select2('val') == "Ya está con la competencia" || $('.list_fl_nv_razon option:selected').text() == "Ya está con la competencia" || $('.list_fl_nv_razon')[0].innerText.trim() == "Ya está con la competencia" || $('.list_fl_nv_razon option:selected').text() == "Ya está con la competencia") && $('.chk_fl_nv')[0].checked) {
                $('.fl_nv_quien').show(); //CLASE DIV ¿Quién? TEXTO
                $('.fl_nv_porque').show(); //CLASE DIV ¿Por qué? TEXTO
            } else {
                $('.fl_nv_quien').hide(); //CLASE DIV ¿Quién? TEXTO
                $('.fl_nv_porque').hide(); //CLASE DIV ¿Por qué? TEXTO
                $('.txt_fl_nv_quien').val(""); //CLASE DIV ¿Quién? TEXTO
                $('.txt_fl_nv_porque').val(""); //CLASE DIV ¿Por qué? TEXTO
            }
            // CLASE DE list_fl_nv_razon -LISTA - Razón de Lead no viable FLEET
            if (($('.list_fl_nv_razon').select2('val') == "No tenemos el producto que requiere" || $('.list_fl_nv_razon option:selected').text() == "No tenemos el producto que requiere" || $('.list_fl_nv_razon')[0].innerText.trim() == "No tenemos el producto que requiere") && $('.chk_fl_nv')[0].checked) {
                $('.fl_nv_producto').show(); //clase lista - ¿Qué producto?
            } else {
                $('.fl_nv_producto').hide(); //clase lista - ¿Qué producto?
                $('.list_fl_nv_producto').select2('val', ""); //clase lista - ¿Qué producto?
            }
            // CLASE DE list_fl_nv_razon -LISTA - Razón de Lead no viable FLEET
            if (($('.list_fl_nv_razon').select2('val') == "Condiciones Financieras" || $('.list_fl_nv_razon option:selected').text() == "Condiciones Financieras" || $('.list_fl_nv_razon')[0].innerText.trim() == "Condiciones Financieras") && $('.chk_fl_nv')[0].checked) {
                $('.fl_nv_razon_cf').show(); //clase lista Condiciones Financieras
            } else {
                $('.fl_nv_razon_cf').hide(); //clase lista Condiciones Financieras
                $('.list_fl_nv_razon_cf').select2('val', ""); //clase lista Condiciones Financieras
            }
            // CLASE DE list_l_nv_razon -LISTA - Razón de Lead no viable FLEET
            if (($('.list_fl_nv_razon').select2('val') == "No tenemos el producto que requiere" || $('.list_fl_nv_razon option:selected').text() == "No tenemos el producto que requiere" || $('.list_fl_nv_razon')[0].innerText.trim() == "No tenemos el producto que requiere") && ($('.list_fl_nv_producto').select2('val') == "Otro" || $('.list_fl_nv_producto option:selected').text() == "Otro" || $('.list_fl_nv_producto')[0].innerText.trim() == "Otro") && $('.chk_fl_nv')[0].checked) {
                $('.fl_nv_otro').show(); //TEXTO CLASE ¿Qué producto?
            } else {
                $('.fl_nv_otro').hide(); //TEXTO CLASE ¿Qué producto?
                $('.txt_fl_nv_otro').val(""); //TEXTO CLASE ¿Qué producto?
            }
            // CLASE DE list_fl_nv_razon -LISTA - Razón de Lead no viable FLEET
            if (($('.list_fl_nv_razon').select2('val') == "No se encuentra interesado" || $('.list_fl_nv_razon option:selected').text() == "No se encuentra interesado" || $('.list_fl_nv_razon')[0].innerText.trim() == "No se encuentra interesado") && $('.chk_fl_nv')[0].checked) {
                $('.fl_nv_razon_ni').show(); //LISTA Razón No se encuentra interesado
            } else {
                $('.fl_nv_razon_ni').hide(); //LISTA Razón No se encuentra interesado
                $('.list_fl_nv_razon_ni').select2('val', ""); //LISTA Razón No se encuentra interesado
            }
        }
    },

    /*************************************PRODUCTO UNICLICK*********************************************/
    MuestraCamposUniclick: function () {
        var productos = App.user.attributes.productos_c;
        $('.u_nv_razon').hide(); //CLASE Razón de Lead no viable UNICLICK
        $('.u_nv_razon_fp').hide(); //CLASE Fuera de Perfil (Razón) UNICLICK
        $('.u_nv_quien').hide(); //CLASE ¿Quién? UNICLICK
        $('.u_nv_porque').hide(); //CLASE ¿Por qué? UNICLICK
        $('.u_nv_producto').hide(); //CLASE ¿Qué producto? UNICLICK
        $('.u_nv_razon_cf').hide(); //CLASE Condiciones Financieras UNICLICK
        $('.u_nv_otro').hide(); //CLASE ¿Qué producto? UNICLICK
        $('.u_nv_razon_ni').hide(); //CLASE Razón No se encuentra interesado UNICLICK
        /************************************/
        $('.u_so_razon').hide();
        $('.u_so_motivo').hide();
        $('.u_so_detalle').hide();
        $('.u_so_resp_ingesta').hide();
        $('.u_so_raspval1').hide();
        $('.u_so_raspval2').hide();
        $('.u_so_raspval1_edit').hide();
        $('.u_so_raspval2_edit').hide();
        $('.uniclick_estatus_lm').hide();
        $('.uniclick_estatus_lm_edit').hide();
        /************************************/
        if ($('.chk_u_nv')[0] != undefined) {
            if ($('.chk_u_nv')[0].checked) { //CHECK - CLASE No Viable UNICLICK
                $('.u_nv_razon').show(); //MUESTRA - CLASE Razón de Lead no viable UNICLICK
            }
        }

        if(cont_uni_p.action != "edit"){
            $('.uniclick_estatus_lm').show();
        }
        if(cont_uni_p.ResumenProductos!=undefined){
            if( cont_uni_p.ResumenProductos.uniclick.status_management_c == '5' || cont_uni_p.ResumenProductos.uniclick.status_management_c == '4'){
                if(cont_uni_p.action == "edit" ){
                    $('.uniclick_estatus_lm_edit').show();
                }else{
                    $('.uniclick_estatus_lm').show();
                }
                $('.u_so_razon').show();
                $('.u_so_motivo').show();
                $('.u_so_detalle').show();
                $('.u_so_resp_ingesta').show();
                $('.u_so_raspval1').show();
                //$('.u_so_raspval2').show();
                /*if(this.busca_bloquea(cont_uni_p.ResumenProductos.uniclick.status_management_c  , cont_uni_p.ResumenProductos.uniclick.razon_c , cont_uni_p.ResumenProductos.uniclick.motivo_c )){
                    $('.u_so_raspval2').show();
                }*/
                
                if (cont_uni_p.ResumenProductos.uniclick.razon_c == '7' && cont_uni_p.ResumenProductos.uniclick.motivo_c == '' ) { //PRODUCTO LEASING
                    $('.l_so_raspval2').show();
                }
                if (cont_uni_p.ResumenProductos.uniclick.razon_c == '10' && cont_uni_p.ResumenProductos.uniclick.motivo_c == '7' ) { //PRODUCTO LEASING
                    $('.l_so_raspval2').show();
                }
            }
            if(cont_uni_p.ResumenProductos.uniclick.status_management_c == '1' ){
                if(cont_uni_p.ResumenProductos.uniclick.deshabilitar_lmedit){
                    $('.uniclick_estatus_lm').show();
                }else{
                    $('.uniclick_estatus_lm_edit').show();
                }
            }
        }else if(cont_uni_p.action == "edit" && cont_uni_p.ResumenProductos==undefined){
            $('.uniclick_estatus_lm_edit').show();
        }
    },
    /*************************************PRODUCTO UNICLICK*********************************************/
    MuestraCamposUniclick_EstatusLM: function () {

        $('.u_so_razon').hide();
        $('.u_so_motivo').hide();
        $('.u_so_detalle').hide();
        $('.u_so_resp_ingesta').hide();
        $('.u_so_raspval1').hide();
        $('.u_so_raspval2').hide();
        $('.u_so_raspval1_edit').hide();
        $('.u_so_raspval2_edit').hide();
        //$('.ls_estatus_lm_edit').hide();
        /****************************************/
        if (($('.list_u_estatus_lm').select2('val') == "4" || $('.list_u_estatus_lm').select2('val') == "5" ) ) { //PRODUCTO LEASING
            //$('.ls_estatus_lm').show();
            $('.u_so_razon').show();
            $('.u_so_motivo').show();
            $('.u_so_detalle').show();
            $('.u_so_resp_ingesta').show();
            $('.u_so_raspval1_edit').show();
            //$('.u_so_raspval2_edit').show();
            /****************************************/
            $('.list_u_so_razon').select2('val', "");
            $('.list_u_so_motivo').select2('val', "");
            $('.txt_u_so_detalle').val("");
            $('.list_u_respval_1').select2('val', "");
            $('.list_u_respval_2').select2('val', "");
        }
    },
    //FUNCION DE PRODUCTO UNICLICK PARA LAS DEPENDENCIAS DE LOS CAMPOS
    dependenciasUniclick: function () {

        if ($('.chk_u_nv')[0] != undefined) {
            // CLASE DE list_u_nv_razon -LISTA - Razón de Lead no viable UNICLICK
            if (($('.list_u_nv_razon').select2('val') == "Fuera de Perfil" || $('.list_u_nv_razon option:selected').text() == "Fuera de Perfil" || $('.list_u_nv_razon')[0].innerText.trim() == "Fuera de Perfil") && $('.chk_u_nv')[0].checked) {
                $('.u_nv_razon_fp').show(); //CLASE DIV Fuera de Perfil (Razón)
            } else {
                $('.u_nv_razon_fp').hide(); //CLASE DIV Fuera de Perfil (Razón)
                $('.list_u_nv_razon_fp').select2('val', ""); //CLASE LISTA Fuera de Perfil (Razón)
            }
            // CLASE DE list_u_nv_razon -LISTA - Razón de Lead no viable UNICLICK
            if (($('.list_u_nv_razon').select2('val') == "Ya está con la competencia" || $('.list_u_nv_razon option:selected').text() == "Ya está con la competencia" || $('.list_u_nv_razon')[0].innerText.trim() == "Ya está con la competencia" || $('.list_u_nv_razon option:selected').text() == "Ya está con la competencia") && $('.chk_u_nv')[0].checked) {
                $('.u_nv_quien').show(); //CLASE DIV ¿Quién? TEXTO
                $('.u_nv_porque').show(); //CLASE DIV ¿Por qué? TEXTO
            } else {
                $('.u_nv_quien').hide(); //CLASE DIV ¿Quién? TEXTO
                $('.u_nv_porque').hide(); //CLASE DIV ¿Por qué? TEXTO
                $('.txt_u_nv_quien').val(""); //CLASE DIV ¿Quién? TEXTO
                $('.txt_u_nv_porque').val(""); //CLASE DIV ¿Por qué? TEXTO
            }
            // CLASE DE list_u_nv_razon -LISTA - Razón de Lead no viable UNICLICK
            if (($('.list_u_nv_razon').select2('val') == "No tenemos el producto que requiere" || $('.list_u_nv_razon option:selected').text() == "No tenemos el producto que requiere" || $('.list_u_nv_razon')[0].innerText.trim() == "No tenemos el producto que requiere") && $('.chk_u_nv')[0].checked) {
                $('.u_nv_producto').show(); //clase lista - ¿Qué producto?
            } else {
                $('.u_nv_producto').hide(); //clase lista - ¿Qué producto?
                $('.list_u_nv_producto').select2('val', ""); //clase lista - ¿Qué producto?
            }
            // CLASE DE list_u_nv_razon -LISTA - Razón de Lead no viable UNICLICK
            if (($('.list_u_nv_razon').select2('val') == "Condiciones Financieras" || $('.list_u_nv_razon option:selected').text() == "Condiciones Financieras" || $('.list_u_nv_razon')[0].innerText.trim() == "Condiciones Financieras") && $('.chk_u_nv')[0].checked) {
                $('.u_nv_razon_cf').show(); //clase lista Condiciones Financieras
            } else {
                $('.u_nv_razon_cf').hide(); //clase lista Condiciones Financieras
                $('.list_u_nv_razon_cf').select2('val', ""); //clase lista Condiciones Financieras
            }
            // CLASE DE list_u_nv_razon -LISTA - Razón de Lead no viable UNICLICK
            if (($('.list_u_nv_razon').select2('val') == "No tenemos el producto que requiere" || $('.list_u_nv_razon option:selected').text() == "No tenemos el producto que requiere" || $('.list_u_nv_razon')[0].innerText.trim() == "No tenemos el producto que requiere") && ($('.list_u_nv_producto').select2('val') == "Otro" || $('.list_u_nv_producto option:selected').text() == "Otro" || $('.list_u_nv_producto')[0].innerText.trim() == "Otro") && $('.chk_u_nv')[0].checked) {
                $('.u_nv_otro').show(); //TEXTO CLASE ¿Qué producto?
            } else {
                $('.u_nv_otro').hide(); //TEXTO CLASE ¿Qué producto?
                $('.txt_u_nv_otro').val(""); //TEXTO CLASE ¿Qué producto?
            }
            // CLASE DE list_u_nv_razon -LISTA - Razón de Lead no viable UNICLICK
            if (($('.list_u_nv_razon').select2('val') == "No se encuentra interesado" || $('.list_u_nv_razon option:selected').text() == "No se encuentra interesado" || $('.list_u_nv_razon')[0].innerText.trim() == "No se encuentra interesado") && $('.chk_u_nv')[0].checked) {
                $('.u_nv_razon_ni').show(); //LISTA Razón No se encuentra interesado
            } else {
                $('.u_nv_razon_ni').hide(); //LISTA Razón No se encuentra interesado
                $('.list_u_nv_razon_ni').select2('val', ""); //LISTA Razón No se encuentra interesado
            }
        }
    },

    //Funcion para habilitar la funcionalidad de los checks de cada producto dependiendo del producto que tenga el usuario logueado.
    nvproductos: function () {
        var productos = App.user.attributes.productos_c; //USUARIOS CON LOS SIGUIENTES PRODUCTOS
        if (productos.includes("1") && cont_uni_p.action == "edit") { //PRODUCTO LEASING
            $('[data-field="chk_l_nv"]').attr('style', 'pointer-events:block;');
            if (app.user.attributes.multilinea_c == 1 ) {
                $('[data-field="chk_ls_multi"]').attr('style', 'pointer-events:block;');
            }
        }
        if (productos.includes("4") && cont_uni_p.action == "edit") {  //PRODUCTO FACTORAJE
            $('[data-field="chk_f_nv"]').attr('style', 'pointer-events:block;');
            if (app.user.attributes.multilinea_c == 1 ) {
                $('[data-field="chk_fac_multi"]').attr('style', 'pointer-events:block;');
            }
        }
        if (productos.includes("3") && cont_uni_p.action == "edit") { //PRODUCTO CREDITO AUTOMOTRIZ
            $('[data-field="chk_ca_nv"]').attr('style', 'pointer-events:block;');
            if (app.user.attributes.multilinea_c == 1) {
                $('[data-field="chk_ca_multi"]').attr('style', 'pointer-events:block;');
            }
        }
        if (productos.includes("6") && cont_uni_p.action == "edit") { //PRODUCTO FLEET
            $('[data-field="chk_fl_nv"]').attr('style', 'pointer-events:block;');
            if (app.user.attributes.multilinea_c == 1 ) {
                $('[data-field="chk_fe_multi"]').attr('style', 'pointer-events:block;');
            }
        }
        if (productos.includes("8") && cont_uni_p.action == "edit") { //PRODUCTO UNICLICK
            $('[data-field="chk_u_nv"]').attr('style', 'pointer-events:block;');
            if (app.user.attributes.multilinea_c == 1 ) {
                $('[data-field="chk_uniclick_multi"]').attr('style', 'pointer-events:block;');
            }
        }
    },


    //Funcion para habilitar la funcionalidad del cambio de estatus lead management
    estatuslmCambio: function () {
        var productos = App.user.attributes.productos_c; //USUARIOS CON LOS SIGUIENTES PRODUCTOS

        if ((productos.includes("1")  && cont_uni_p.action == "edit" && 
            ((App.user.attributes.id != cont_uni_p.ResumenProductos.leasing.assigned_user_id ) && App.user.attributes.bloqueo_cuentas_c != 1 )) 
            || cont_uni_p.ResumenProductos.leasing.no_viable || cont_uni_p.ResumenProductos.leasing.tipo_cuenta != '3'){ //PRODUCTO LEASING
            //$('[data-field="list_l_estatus_lm"]').prop("disabled", true);
            $('.list_l_estatus_lm').prop("disabled", true);
            cont_uni_p.ResumenProductos.leasing.deshabilitar_lmedit = true;
        }

        if ((productos.includes("4")  && cont_uni_p.action == "edit" && 
            ((App.user.attributes.id != cont_uni_p.ResumenProductos.factoring.assigned_user_id ) && App.user.attributes.bloqueo_cuentas_c != 1 ))
            || cont_uni_p.ResumenProductos.factoring.no_viable || cont_uni_p.ResumenProductos.factoring.tipo_cuenta != '3') { //PRODUCTO LEASING
            //$('[data-field="list_l_estatus_lm"]').prop("disabled", true);
            $('.list_fac_estatus_lm').prop("disabled", true);
            cont_uni_p.ResumenProductos.factoring.deshabilitar_lmedit = true;
        }
        if ((productos.includes("3")  && cont_uni_p.action == "edit" && 
            ((App.user.attributes.id != cont_uni_p.ResumenProductos.credito_auto.assigned_user_id ) && App.user.attributes.bloqueo_cuentas_c != 1 ))
            || cont_uni_p.ResumenProductos.credito_auto.no_viable || cont_uni_p.ResumenProductos.credito_auto.tipo_cuenta != '3') { //PRODUCTO LEASING
            //$('[data-field="list_l_estatus_lm"]').prop("disabled", true);
            $('.list_ca_estatus_lm').prop("disabled", true);
            cont_uni_p.ResumenProductos.credito_auto.deshabilitar_lmedit = true;
        }
        if ((productos.includes("6")  && cont_uni_p.action == "edit" && 
            ((App.user.attributes.id != cont_uni_p.ResumenProductos.fleet.assigned_user_id ) && App.user.attributes.bloqueo_cuentas_c != 1 ))
            || cont_uni_p.ResumenProductos.fleet.no_viable || cont_uni_p.ResumenProductos.fleet.tipo_cuenta != '3') { //PRODUCTO LEASING
            //$('[data-field="list_l_estatus_lm"]').prop("disabled", true);
            $('.list_fl_estatus_lm').prop("disabled", true);
            cont_uni_p.ResumenProductos.fleet.deshabilitar_lmedit = true;
        }
        if ((productos.includes("8")  && cont_uni_p.action == "edit" && 
            ((App.user.attributes.id != cont_uni_p.ResumenProductos.uniclick.assigned_user_id ) && App.user.attributes.bloqueo_cuentas_c != 1 ))
            || cont_uni_p.ResumenProductos.uniclick.no_viable || cont_uni_p.ResumenProductos.uniclick.tipo_cuenta != '3') { //PRODUCTO LEASING
            //$('[data-field="list_l_estatus_lm"]').prop("disabled", true);
            $('.list_u_estatus_lm').prop("disabled", true);
            cont_uni_p.ResumenProductos.uniclick.deshabilitar_lmedit = true;
        }
    },

    SaveUniProductos: function (fields, errors, callback) {
        if (cont_uni_p.ResumenProductos == undefined) {
            cont_uni_p.ResumenProductos = contexto_cuenta.ResumenProductos;
        }
        if (cont_uni_p.ResumenProductos != undefined && cont_uni_p.ResumenProductos.leasing != undefined) {
            //Valida tipo de cuenta
            var guardaL = false;
            var guardaF = false;
            var guardaCA = false;
            var guardaFL = false;
            var guardaU = false;
            /********************/
            var guardaL_SM = false;
            var guardaF_SM = false;
            var guardaCA_SM = false;
            var guardaFL_SM = false;
            var guardaU_SM = false;
            /****************/
            var bloqueacuentaf = false;
            var bloqueorazon = "";
            var bloqueomotivo = "";
            var bloqueodescr = "";
            var user_id_c = "";
            var user_id1_c = "";
            var status_management_c = "";
            /****************/
            //Valida Leasing TIPO CUENTA 1-LEAD - SUBTIPO CUENTA 2-CONTACTADO - SUBTIPO CUENTA 7-INTERESADO
            if (cont_uni_p.ResumenProductos.leasing.tipo_cuenta == 1 || cont_uni_p.ResumenProductos.leasing.subtipo_cuenta == 2 || cont_uni_p.ResumenProductos.leasing.subtipo_cuenta == 7) {
                guardaL = true;
            }
            //Valida Factoraje TIPO CUENTA 1-LEAD - SUBTIPO CUENTA 2-CONTACTADO - SUBTIPO CUENTA 7-INTERESADO
            if (cont_uni_p.ResumenProductos.factoring.tipo_cuenta == 1 || cont_uni_p.ResumenProductos.factoring.subtipo_cuenta == 2 || cont_uni_p.ResumenProductos.factoring.subtipo_cuenta == 7) {
                guardaF = true;
            }
            //Valida CA TIPO CUENTA 1-LEAD - SUBTIPO CUENTA 2-CONTACTADO - SUBTIPO CUENTA 7-INTERESADO
            if (cont_uni_p.ResumenProductos.credito_auto.tipo_cuenta == 1 || cont_uni_p.ResumenProductos.credito_auto.subtipo_cuenta == 2 || cont_uni_p.ResumenProductos.credito_auto.subtipo_cuenta == 7) {
                guardaCA = true;
            }
            //Valida FLEET TIPO CUENTA 1-LEAD - SUBTIPO CUENTA 2-CONTACTADO - SUBTIPO CUENTA 7-INTERESADO
            if (cont_uni_p.ResumenProductos.fleet.tipo_cuenta == 1 || cont_uni_p.ResumenProductos.fleet.subtipo_cuenta == 2 || cont_uni_p.ResumenProductos.fleet.subtipo_cuenta == 7) {
                guardaFL = true;
            }
            //Valida UNICLICK TIPO CUENTA 1-LEAD - SUBTIPO CUENTA 2-CONTACTADO - SUBTIPO CUENTA 7-INTERESADO
            if (cont_uni_p.ResumenProductos.uniclick.tipo_cuenta == 1 || cont_uni_p.ResumenProductos.uniclick.subtipo_cuenta == 2 || cont_uni_p.ResumenProductos.uniclick.subtipo_cuenta == 7) {
                guardaU = true;
            }

            //Evalua guardado de No viable
            if ((guardaL || guardaF || guardaCA || guardaFL || guardaU) && this.model.get('id') != "" && this.model.get('id') != undefined && Object.entries(errors).length == 0) {
                //Mapea los campos del modulo UNI PRODUCTOS con producto LEASING en el objeto cont_uni_p.leadNoViable
                if ($('.chk_l_nv')[0] != undefined) {
                    if ($('.chk_l_nv')[0].checked == true && typeof $('.list_l_nv_razon').select2('val') == "string") {
                        cont_uni_p.ResumenProductos.leasing.no_viable = $('.chk_l_nv')[0].checked; //check No Viable Leasing
                        cont_uni_p.ResumenProductos.leasing.no_viable_razon = $('.list_l_nv_razon').select2('val'); //lista Razón de Lead no viable Leasing
                        cont_uni_p.ResumenProductos.leasing.no_viable_razon_fp = $('.list_l_nv_razon_fp').select2('val'); //lista Fuera de Perfil (Razón) Leasing
                        cont_uni_p.ResumenProductos.leasing.no_viable_quien = $('.txt_l_nv_quien').val().trim(); //texto ¿Quién? Leasing
                        cont_uni_p.ResumenProductos.leasing.no_viable_porque = $('.txt_l_nv_porque').val().trim(); //texto ¿Por qué? Leasing
                        cont_uni_p.ResumenProductos.leasing.no_viable_producto = $('.list_l_nv_producto').select2('val'); //lista ¿Qué producto? Leasing
                        cont_uni_p.ResumenProductos.leasing.no_viable_razon_cf = $('.list_l_nv_razon_cf').select2('val'); //lista Condiciones Financieras Leasing
                        cont_uni_p.ResumenProductos.leasing.no_viable_otro_c = $('.txt_l_nv_otro').val().trim(); //texto ¿Qué producto? Leasing
                        cont_uni_p.ResumenProductos.leasing.no_viable_razon_ni = $('.list_l_nv_razon_ni').select2('val'); //lista Razón No se encuentra interesado Leasing

                        //this.tipoProducto.leasing = cont_uni_p.ResumenProductos.leasing;
                    }
                }

                //Mapea los campos del modulo UNI PRODUCTOS con producto FACTORAJE en el objeto cont_uni_p.leadNoViable
                if ($('.chk_f_nv')[0] != undefined) {
                    if ($('.chk_f_nv')[0].checked == true && typeof $('.list_f_nv_razon').select2('val') == "string") {
                        cont_uni_p.ResumenProductos.factoring.no_viable = $('.chk_f_nv')[0].checked; //check No Viable Factoraje
                        cont_uni_p.ResumenProductos.factoring.no_viable_razon = $('.list_f_nv_razon').select2('val'); //Razón de Lead no viable factoraje
                        cont_uni_p.ResumenProductos.factoring.no_viable_razon_fp = $('.list_f_nv_razon_fp').select2('val'); //lista Fuera de Perfil (Razón) factoraje
                        cont_uni_p.ResumenProductos.factoring.no_viable_quien = $('.txt_f_nv_quien').val().trim(); //texto ¿Quién? factoraje
                        cont_uni_p.ResumenProductos.factoring.no_viable_porque = $('.txt_f_nv_porque').val().trim(); //texto ¿Por qué? factoraje
                        cont_uni_p.ResumenProductos.factoring.no_viable_producto = $('.list_f_nv_producto').select2('val'); //lista ¿Qué producto? factoraje
                        cont_uni_p.ResumenProductos.factoring.no_viable_razon_cf = $('.list_f_nv_razon_cf').select2('val'); //lista Condiciones Financieras factoraje
                        cont_uni_p.ResumenProductos.factoring.no_viable_otro_c = $('.txt_f_nv_otro').val().trim(); //texto ¿Qué producto? factoraje
                        cont_uni_p.ResumenProductos.factoring.no_viable_razon_ni = $('.list_f_nv_razon_ni').select2('val'); //lista Razón No se encuentra interesado factoraje

                        //this.tipoProducto.factoring = cont_uni_p.ResumenProductos.factoring;
                    }
                }

                //Mapea los campos del modulo UNI PRODUCTOS con producto CREDITO AUTOMOTRIZ en el objeto cont_uni_p.leadNoViable
                if ($('.chk_ca_nv')[0] != undefined) {
                    if ($('.chk_ca_nv')[0].checked == true && typeof $('.list_ca_nv_razon').select2('val') == "string") {
                        cont_uni_p.ResumenProductos.credito_auto.no_viable = $('.chk_ca_nv')[0].checked; //check No Viable Crédito Automotriz
                        cont_uni_p.ResumenProductos.credito_auto.no_viable_razon = $('.list_ca_nv_razon').select2('val'); //Razón de Lead no viable CA
                        cont_uni_p.ResumenProductos.credito_auto.no_viable_razon_fp = $('.list_ca_nv_razon_fp').select2('val');  //lista Fuera de Perfil (Razón) CA
                        cont_uni_p.ResumenProductos.credito_auto.no_viable_quien = $('.txt_ca_nv_quien').val().trim(); //texto ¿Quién? CA
                        cont_uni_p.ResumenProductos.credito_auto.no_viable_porque = $('.txt_ca_nv_porque').val().trim(); //texto ¿Por qué? CA
                        cont_uni_p.ResumenProductos.credito_auto.no_viable_producto = $('.list_ca_nv_producto').select2('val'); //lista ¿Qué producto?  CA
                        cont_uni_p.ResumenProductos.credito_auto.no_viable_razon_cf = $('.list_ca_nv_razon_cf').select2('val');  //lista Condiciones Financieras CA
                        cont_uni_p.ResumenProductos.credito_auto.no_viable_otro_c = $('.txt_ca_nv_otro').val().trim(); //texto ¿Qué producto? CA
                        cont_uni_p.ResumenProductos.credito_auto.no_viable_razon_ni = $('.list_ca_nv_razon_ni').select2('val'); //lista Razón No se encuentra interesado CA

                        //this.tipoProducto.credito_auto = cont_uni_p.ResumenProductos.credito_auto;
                    }
                }
                //Mapea los campos del modulo UNI PRODUCTOS con producto FLEET en el objeto cont_uni_p.leadNoViable
                if ($('.chk_fl_nv')[0] != undefined) {
                    if ($('.chk_fl_nv')[0].checked == true && typeof $('.list_fl_nv_razon').select2('val') == "string") {
                        cont_uni_p.ResumenProductos.fleet.no_viable = $('.chk_fl_nv')[0].checked; //check No Viable Crédito Automotriz
                        cont_uni_p.ResumenProductos.fleet.no_viable_razon = $('.list_fl_nv_razon').select2('val'); //Razón de Lead no viable CA
                        cont_uni_p.ResumenProductos.fleet.no_viable_razon_fp = $('.list_fl_nv_razon_fp').select2('val');  //lista Fuera de Perfil (Razón) CA
                        cont_uni_p.ResumenProductos.fleet.no_viable_quien = $('.txt_fl_nv_quien').val().trim(); //texto ¿Quién? CA
                        cont_uni_p.ResumenProductos.fleet.no_viable_porque = $('.txt_fl_nv_porque').val().trim(); //texto ¿Por qué? CA
                        cont_uni_p.ResumenProductos.fleet.no_viable_producto = $('.list_fl_nv_producto').select2('val'); //lista ¿Qué producto?  CA
                        cont_uni_p.ResumenProductos.fleet.no_viable_razon_cf = $('.list_fl_nv_razon_cf').select2('val');  //lista Condiciones Financieras CA
                        cont_uni_p.ResumenProductos.fleet.no_viable_otro_c = $('.txt_fl_nv_otro').val().trim();  //texto ¿Qué producto? CA
                        cont_uni_p.ResumenProductos.fleet.no_viable_razon_ni = $('.list_fl_nv_razon_ni').select2('val'); //lista Razón No se encuentra interesado CA

                        //this.tipoProducto.fleet = cont_uni_p.ResumenProductos.fleet;
                    }

                }
                //Mapea los campos del modulo UNI PRODUCTOS con producto UNICLICK en el objeto cont_uni_p.leadNoViable
                if ($('.chk_u_nv')[0] != undefined) {
                    if ($('.chk_u_nv')[0].checked == true && typeof $('.list_u_nv_razon').select2('val') == "string") {
                        cont_uni_p.ResumenProductos.uniclick.no_viable = $('.chk_u_nv')[0].checked; //check No Viable Crédito Automotriz
                        cont_uni_p.ResumenProductos.uniclick.no_viable_razon = $('.list_u_nv_razon').select2('val'); //Razón de Lead no viable CA
                        cont_uni_p.ResumenProductos.uniclick.no_viable_razon_fp = $('.list_u_nv_razon_fp').select2('val');  //lista Fuera de Perfil (Razón) CA
                        cont_uni_p.ResumenProductos.uniclick.no_viable_quien = $('.txt_u_nv_quien').val().trim(); //texto ¿Quién? CA
                        cont_uni_p.ResumenProductos.uniclick.no_viable_porque = $('.txt_u_nv_porque').val().trim(); //texto ¿Por qué? CA
                        cont_uni_p.ResumenProductos.uniclick.no_viable_producto = $('.list_u_nv_producto').select2('val'); //lista ¿Qué producto?  CA
                        cont_uni_p.ResumenProductos.uniclick.no_viable_razon_cf = $('.list_u_nv_razon_cf').select2('val');  //lista Condiciones Financieras CA
                        cont_uni_p.ResumenProductos.uniclick.no_viable_otro_c = $('.txt_u_nv_otro').val().trim();  //texto ¿Qué producto? CA
                        cont_uni_p.ResumenProductos.uniclick.no_viable_razon_ni = $('.list_u_nv_razon_ni').select2('val'); //lista Razón No se encuentra interesado CA

                        //this.tipoProducto.uniclick = cont_uni_p.ResumenProductos.uniclick;
                    }
                }

                this.model.set('account_uni_productos', this.tipoProducto);
            }

            if (!cont_uni_p.ResumenProductos.leasing.no_viable && cont_uni_p.ResumenProductos.leasing.tipo_cuenta == 3 && (cont_uni_p.ResumenProductos.leasing.status_management_c == '1' && $('.list_l_estatus_lm').select2('val') == '4' || $('.list_l_estatus_lm').select2('val') == '5')) {
                guardaL_SM = true;
            }

            if (!cont_uni_p.ResumenProductos.factoring.no_viable && cont_uni_p.ResumenProductos.factoring.tipo_cuenta == 3 && (cont_uni_p.ResumenProductos.factoring.status_management_c == '1' && $('.list_fac_estatus_lm').select2('val') == '4' || $('.list_fac_estatus_lm').select2('val') == '5')) {
                guardaF_SM = true;
            }

            if (!cont_uni_p.ResumenProductos.credito_auto.no_viable && cont_uni_p.ResumenProductos.credito_auto.tipo_cuenta == 3 && (cont_uni_p.ResumenProductos.credito_auto.status_management_c == '1' && $('.list_ca_estatus_lm').select2('val') == '4' || $('.list_ca_estatus_lm').select2('val') == '5')) {
                guardaCA_SM = true;
            }

            if (!cont_uni_p.ResumenProductos.fleet.no_viable && cont_uni_p.ResumenProductos.fleet.tipo_cuenta == 3 && (cont_uni_p.ResumenProductos.fleet.status_management_c == '1' && $('.list_fl_estatus_lm').select2('val') == '4' || $('.list_fl_estatus_lm').select2('val') == '5')) {
                guardaFL_SM = true;
            }

            if (!cont_uni_p.ResumenProductos.uniclick.no_viable && cont_uni_p.ResumenProductos.uniclick.tipo_cuenta == 3 && (cont_uni_p.ResumenProductos.uniclick.status_management_c == '1' && $('.list_u_estatus_lm').select2('val') == '4' || $('.list_u_estatus_lm').select2('val') == '5')) {
                guardaU_SM = true;
            }

            if ((guardaL_SM || guardaF_SM || guardaCA_SM || guardaFL_SM || guardaU_SM) && this.model.get('id') != "" && this.model.get('id') != undefined && Object.entries(errors).length == 0) {
                //Mapea los campos del modulo UNI PRODUCTOS con producto LEASING en el objeto cont_uni_p.leadNoViable
                if(cont_uni_p.ResumenProductos.leasing.no_viable != true  && guardaL_SM){
                    cont_uni_p.ResumenProductos.leasing.status_management_c = $('.list_l_estatus_lm').select2('val'); //estatus management
                    cont_uni_p.ResumenProductos.leasing.razon_c = $('.list_l_so_razon').select2('val'); //razon lm
                    cont_uni_p.ResumenProductos.leasing.motivo_c = $('.list_l_so_motivo').select2('val'); //motivo lm
                    cont_uni_p.ResumenProductos.leasing.detalle_c = $('.txt_l_so_detalle').val().trim(); //detalle lm
                    if(App.user.attributes.bloqueo_cuentas_c == 1){
                        cont_uni_p.ResumenProductos.leasing.user_id_c = App.user.attributes.id;  //user id
                        cont_uni_p.ResumenProductos.leasing.aprueba1_c = true; 
                        cont_uni_p.ResumenProductos.leasing.aprueba2_c = true;
                        cont_uni_p.ResumenProductos.leasing.estatus_atencion = '3';
                        /*****************************************************/
                        bloqueacuentaf = true;
                        bloqueorazon = $('.list_l_so_razon').select2('val'); //razon lm
                        bloqueomotivo = $('.list_l_so_motivo').select2('val'); //motivo lm
                        bloqueodescr = $('.txt_l_so_detalle').val().trim(); //detalle lm
                        user_id_c = App.user.attributes.id;
                        user_id1_c = $('.list_l_respval_1').select2('val');  //user id1
                        status_management_c = $('.list_l_estatus_lm').select2('val'); //estatus management
                    }else{
                        cont_uni_p.ResumenProductos.leasing.user_id_c = ResumenProductos.leasing.assigned_user_id;  //user id
                        cont_uni_p.ResumenProductos.leasing.notificacion_noviable_c = true;  //user id
                    }
                    cont_uni_p.ResumenProductos.leasing.user_id1_c = $('.list_l_respval_1').select2('val');  //user id1
                    cont_uni_p.ResumenProductos.leasing.user_id2_c = $('.list_l_respval_2').select2('val');  //user id2
                    /*for(var i = 0; i < cont_uni_p.datacondiciones.records.length; i++) {
                        if((cont_uni_p.datacondiciones.records[i].razon == cont_uni_p.ResumenProductos.leasing.razon_c) && (cont_uni_p.datacondiciones.records[i].motivo == cont_uni_p.ResumenProductos.leasing.motivo_c)){
                            cont_uni_p.ResumenProductos.leasing.status_management_c = cont_uni_p.datacondiciones.records[i].condicion;
                        }
                    }*/
                    //this.tipoProducto.leasing = cont_uni_p.ResumenProductos.leasing;
                }
                
                if (cont_uni_p.ResumenProductos.factoring.no_viable != true && guardaF_SM) {
                    cont_uni_p.ResumenProductos.factoring.status_management_c = $('.list_fac_estatus_lm').select2('val'); //estatus management
                    cont_uni_p.ResumenProductos.factoring.razon_c = $('.list_f_razon_lm').select2('val'); //razon lm
                    cont_uni_p.ResumenProductos.factoring.motivo_c = $('.list_f_so_motivo').select2('val'); //motivo lm
                    cont_uni_p.ResumenProductos.factoring.detalle_c = $('.txt_f_so_detalle').val().trim(); //detalle lm
                    cont_uni_p.ResumenProductos.factoring.user_id1_c = $('.list_f_respval_1').select2('val');  //user id1
                    cont_uni_p.ResumenProductos.factoring.user_id2_c = $('.list_f_respval_2').select2('val');  //user id2
                    if(App.user.attributes.bloqueo_cuentas_c == 1){
                        cont_uni_p.ResumenProductos.factoring.user_id_c = App.user.attributes.id;  //user id
                        cont_uni_p.ResumenProductos.factoring.aprueba1_c = true; 
                        cont_uni_p.ResumenProductos.factoring.aprueba2_c = true;
                        cont_uni_p.ResumenProductos.factoring.estatus_atencion = '3';
                        /*****************************************************/
                        bloqueacuentaf = true;
                        bloqueorazon = $('.list_f_razon_lm').select2('val'); //razon lm
                        bloqueomotivo = $('.list_f_so_motivo').select2('val'); //motivo lm
                        bloqueodescr = $('.txt_f_so_detalle').val().trim(); //detalle lm
                        user_id_c = App.user.attributes.id;
                        user_id1_c = $('.list_f_respval_1').select2('val');  //user id1
                        status_management_c = $('.list_fac_estatus_lm').select2('val'); //estatus management
                    }else{
                        cont_uni_p.ResumenProductos.factoring.user_id_c = ResumenProductos.factoring.assigned_user_id;  //user id
                        cont_uni_p.ResumenProductos.factoring.notificacion_noviable_c = true;  //user id
                    }
                    /*for(var i = 0; i < cont_uni_p.datacondiciones.records.length; i++) {
                        if((cont_uni_p.datacondiciones.records[i].razon == cont_uni_p.ResumenProductos.factoring.razon_c) && (cont_uni_p.datacondiciones.records[i].motivo == cont_uni_p.ResumenProductos.factoring.motivo_c)){
                            cont_uni_p.ResumenProductos.factoring.status_management_c = cont_uni_p.datacondiciones.records[i].condicion;
                        }
                    }*/
                    //this.tipoProducto.factoring = cont_uni_p.ResumenProductos.factoring;
                }
                if (cont_uni_p.ResumenProductos.credito_auto.no_viable != true && guardaCA_SM) {
                    cont_uni_p.ResumenProductos.credito_auto.status_management_c = $('.list_ca_estatus_lm').select2('val'); //estatus management
                    cont_uni_p.ResumenProductos.credito_auto.razon_c = $('.list_ca_so_razon').select2('val'); //razon lm
                    cont_uni_p.ResumenProductos.credito_auto.motivo_c = $('.list_ca_so_motivo').select2('val'); //motivo lm
                    cont_uni_p.ResumenProductos.credito_auto.detalle_c = $('.txt_ca_so_detalle').val().trim(); //detalle lm
                    cont_uni_p.ResumenProductos.credito_auto.user_id1_c = $('.list_ca_respval_1').select2('val');  //user id1
                    cont_uni_p.ResumenProductos.credito_auto.user_id2_c = $('.list_ca_respval_2').select2('val');  //user id2
                    if(App.user.attributes.bloqueo_cuentas_c == 1){
                        cont_uni_p.ResumenProductos.credito_auto.user_id_c = App.user.attributes.id;  //user id
                        cont_uni_p.ResumenProductos.credito_auto.aprueba1_c = true;
                        cont_uni_p.ResumenProductos.credito_auto.aprueba2_c = true;
                        cont_uni_p.ResumenProductos.credito_auto.estatus_atencion = '3';
                        /*****************************************************/
                        bloqueacuentaf = true;
                        bloqueorazon = $('.list_ca_so_razon').select2('val'); //razon lm
                        bloqueomotivo = $('.list_ca_so_motivo').select2('val'); //motivo lm
                        bloqueodescr = $('.txt_ca_so_detalle').val().trim(); //detalle lm
                        user_id_c = App.user.attributes.id;
                        user_id1_c = $('.list_ca_respval_1').select2('val');  //user id1
                        status_management_c = $('.list_ca_estatus_lm').select2('val'); //estatus management
                    }else{
                        cont_uni_p.ResumenProductos.credito_auto.user_id_c = ResumenProductos.credito_auto.assigned_user_id;  //user id
                        cont_uni_p.ResumenProductos.credito_auto.notificacion_noviable_c = true;  //user id
                    }
                    /*for(var i = 0; i < cont_uni_p.datacondiciones.records.length; i++) {
                        if((cont_uni_p.datacondiciones.records[i].razon == cont_uni_p.ResumenProductos.credito_auto.razon_c) && (cont_uni_p.datacondiciones.records[i].motivo == cont_uni_p.ResumenProductos.credito_auto.motivo_c)){
                            cont_uni_p.ResumenProductos.credito_auto.status_management_c = cont_uni_p.datacondiciones.records[i].condicion;
                        }
                    }*/
                    //this.tipoProducto.credito_auto = cont_uni_p.ResumenProductos.credito_auto;
                }
                if (cont_uni_p.ResumenProductos.fleet.no_viable != true && guardaFL_SM) {
                    cont_uni_p.ResumenProductos.fleet.status_management_c = $('.list_fl_estatus_lm').select2('val'); //estatus management
                    cont_uni_p.ResumenProductos.fleet.razon_c = $('.list_fl_so_razon').select2('val'); //razon lm
                    cont_uni_p.ResumenProductos.fleet.motivo_c = $('.list_fl_so_motivo').select2('val'); //motivo lm
                    cont_uni_p.ResumenProductos.fleet.detalle_c = $('.txt_fl_so_detalle').val().trim(); //detalle lm
                    cont_uni_p.ResumenProductos.fleet.user_id1_c = $('.list_fl_respval_1').select2('val');  //user id1
                    cont_uni_p.ResumenProductos.fleet.user_id2_c = $('.list_fl_respval_2').select2('val');  //user id2
                    if(App.user.attributes.bloqueo_cuentas_c == 1){
                        cont_uni_p.ResumenProductos.fleet.user_id_c = App.user.attributes.id;  //user id
                        cont_uni_p.ResumenProductos.fleet.aprueba1_c = true; 
                        cont_uni_p.ResumenProductos.fleet.aprueba2_c = true;
                        cont_uni_p.ResumenProductos.fleet.estatus_atencion = '3';
                        /*****************************************************/
                        bloqueacuentaf = true;
                        bloqueorazon = $('.list_fl_so_razon').select2('val'); //razon lm
                        bloqueomotivo = $('.list_fl_so_motivo').select2('val'); //motivo lm
                        bloqueodescr = $('.txt_fl_so_detalle').val().trim(); //detalle lm
                        user_id_c = App.user.attributes.id;
                        user_id1_c = $('.list_fl_respval_1').select2('val');  //user id1
                        status_management_c = $('.list_fl_estatus_lm').select2('val'); //estatus management
                    }else{
                        cont_uni_p.ResumenProductos.fleet.user_id_c = ResumenProductos.fleet.assigned_user_id;  //user id
                        cont_uni_p.ResumenProductos.fleet.notificacion_noviable_c = true;  //user id
                    }
                    /*for(var i = 0; i < cont_uni_p.datacondiciones.records.length; i++) {
                        if((cont_uni_p.datacondiciones.records[i].razon == cont_uni_p.ResumenProductos.fleet.razon_c) && (cont_uni_p.datacondiciones.records[i].motivo == cont_uni_p.ResumenProductos.fleet.motivo_c)){
                            cont_uni_p.ResumenProductos.fleet.status_management_c = cont_uni_p.datacondiciones.records[i].condicion;
                        }
                    }*/
                    //this.tipoProducto.fleet = cont_uni_p.ResumenProductos.fleet;
                }
                if (cont_uni_p.ResumenProductos.uniclick.no_viable != true && guardaU_SM) {
                    cont_uni_p.ResumenProductos.uniclick.status_management_c = $('.list_u_estatus_lm').select2('val'); //estatus management
                    cont_uni_p.ResumenProductos.uniclick.razon_c = $('.list_u_so_razon').select2('val'); //razon lm
                    cont_uni_p.ResumenProductos.uniclick.motivo_c = $('.list_u_so_motivo').select2('val'); //motivo lm
                    cont_uni_p.ResumenProductos.uniclick.detalle_c = $('.txt_u_so_detalle').val().trim(); //detalle lm
                    cont_uni_p.ResumenProductos.uniclick.user_id1_c = $('.list_u_respval_1').select2('val');  //user id1
                    cont_uni_p.ResumenProductos.uniclick.user_id2_c = $('.list_u_respval_2').select2('val');  //user id2
                    if(App.user.attributes.bloqueo_cuentas_c == 1){
                        cont_uni_p.ResumenProductos.uniclick.user_id_c = App.user.attributes.id;  //user id
                        cont_uni_p.ResumenProductos.uniclick.aprueba1_c = true; 
                        cont_uni_p.ResumenProductos.uniclick.aprueba2_c = true;
                        cont_uni_p.ResumenProductos.uniclick.estatus_atencion = '3';
                        /*****************************************************/
                        bloqueacuentaf = true;
                        bloqueorazon = $('.list_u_so_razon').select2('val'); //razon lm
                        bloqueomotivo = $('.list_u_so_motivo').select2('val'); //motivo lm
                        bloqueodescr = $('.txt_u_so_detalle').val().trim(); //detalle lm
                        user_id_c = App.user.attributes.id;
                        user_id1_c = $('.list_u_respval_1').select2('val');  //user id1
                        status_management_c = $('.list_u_estatus_lm').select2('val'); //estatus management
                    }else{
                        cont_uni_p.ResumenProductos.uniclick.user_id_c = ResumenProductos.fleet.assigned_user_id;  //user id
                        cont_uni_p.ResumenProductos.uniclick.notificacion_noviable_c = true;  //user id
                    }
                    /*for(var i = 0; i < cont_uni_p.datacondiciones.records.length; i++) {
                        if((cont_uni_p.datacondiciones.records[i].razon == cont_uni_p.ResumenProductos.uniclick.razon_c) && (cont_uni_p.datacondiciones.records[i].motivo == cont_uni_p.ResumenProductos.uniclick.motivo_c)){
                            cont_uni_p.ResumenProductos.uniclick.status_management_c = cont_uni_p.datacondiciones.records[i].condicion;
                        }
                    }*/
                    //this.tipoProducto.uniclick = cont_uni_p.ResumenProductos.uniclick;
                }
            }
        }

        if(bloqueacuentaf){
            var bloqueo_completo = false;
            for(var i=0; i< cont_uni_p.datacondiciones.records.length ; i++) {

                if((cont_uni_p.datacondiciones.records[i].condicion == status_management_c) &&
                   (cont_uni_p.datacondiciones.records[i].razon == bloqueorazon) && 
                   (cont_uni_p.datacondiciones.records[i].motivo == bloqueomotivo) && 
                   (cont_uni_p.datacondiciones.records[i].bloquea )){
                        bloqueo_completo = true;
                }
            }

            if(bloqueo_completo){
                cont_uni_p.ResumenProductos.leasing.status_management_c = status_management_c; //estatus management
                cont_uni_p.ResumenProductos.leasing.razon_c = bloqueorazon; //razon lm
                cont_uni_p.ResumenProductos.leasing.motivo_c = bloqueomotivo; //motivo lm
                cont_uni_p.ResumenProductos.leasing.detalle_c = bloqueodescr; //detalle lm
                cont_uni_p.ResumenProductos.leasing.user_id_c = user_id_c;  //user id
                cont_uni_p.ResumenProductos.leasing.user_id1_c = user_id1_c;  //user id1
                cont_uni_p.ResumenProductos.leasing.user_id2_c = null;  //user id1
                cont_uni_p.ResumenProductos.leasing.estatus_atencion = '3';
                /******************************************************/
                cont_uni_p.ResumenProductos.factoring.status_management_c = status_management_c; //estatus management
                cont_uni_p.ResumenProductos.factoring.razon_c = bloqueorazon; //razon lm
                cont_uni_p.ResumenProductos.factoring.motivo_c = bloqueomotivo; //motivo lm
                cont_uni_p.ResumenProductos.factoring.detalle_c = bloqueodescr; //detalle lm
                cont_uni_p.ResumenProductos.factoring.user_id_c = user_id_c;  //user id
                cont_uni_p.ResumenProductos.factoring.user_id1_c = user_id1_c;  //user id1
                cont_uni_p.ResumenProductos.factoring.user_id2_c = null;  //user id1
                cont_uni_p.ResumenProductos.factoring.estatus_atencion = '3';
                /******************************************************/
                cont_uni_p.ResumenProductos.credito_auto.status_management_c = status_management_c; //estatus management
                cont_uni_p.ResumenProductos.credito_auto.razon_c = bloqueorazon; //razon lm
                cont_uni_p.ResumenProductos.credito_auto.motivo_c = bloqueomotivo; //motivo lm
                cont_uni_p.ResumenProductos.credito_auto.detalle_c = bloqueodescr; //detalle lm
                cont_uni_p.ResumenProductos.credito_auto.user_id_c = user_id_c;  //user id
                cont_uni_p.ResumenProductos.credito_auto.user_id1_c = user_id1_c;  //user id1
                cont_uni_p.ResumenProductos.credito_auto.user_id2_c = null;  //user id1
                cont_uni_p.ResumenProductos.credito_auto.estatus_atencion = '3';
                /******************************************************/
                cont_uni_p.ResumenProductos.fleet.status_management_c = status_management_c; //estatus management
                cont_uni_p.ResumenProductos.fleet.razon_c = bloqueorazon; //razon lm
                cont_uni_p.ResumenProductos.fleet.motivo_c = bloqueomotivo; //motivo lm
                cont_uni_p.ResumenProductos.fleet.detalle_c = bloqueodescr; //detalle lm
                cont_uni_p.ResumenProductos.fleet.user_id_c = user_id_c;  //user id
                cont_uni_p.ResumenProductos.fleet.user_id1_c = user_id1_c;  //user id1
                cont_uni_p.ResumenProductos.fleet.user_id2_c = null;  //user id1
                cont_uni_p.ResumenProductos.fleet.estatus_atencion = '3';
                /******************************************************/
                cont_uni_p.ResumenProductos.uniclick.status_management_c = status_management_c; //estatus management
                cont_uni_p.ResumenProductos.uniclick.razon_c = bloqueorazon; //razon lm
                cont_uni_p.ResumenProductos.uniclick.motivo_c = bloqueomotivo; //motivo lm
                cont_uni_p.ResumenProductos.uniclick.detalle_c = bloqueodescr; //detalle lm
                cont_uni_p.ResumenProductos.uniclick.user_id_c = user_id_c;  //user id
                cont_uni_p.ResumenProductos.uniclick.user_id1_c = user_id1_c;  //user id1
                cont_uni_p.ResumenProductos.uniclick.user_id2_c = null;  //user id1
                cont_uni_p.ResumenProductos.uniclick.estatus_atencion = '3';
                /****************************************************/
                //this.tipoProducto.leasing = cont_uni_p.ResumenProductos.leasing;
                //this.tipoProducto.factoring = cont_uni_p.ResumenProductos.factoring;
                //this.tipoProducto.credito_auto = cont_uni_p.ResumenProductos.credito_auto;
                //this.tipoProducto.fleet = cont_uni_p.ResumenProductos.fleet;
                //this.tipoProducto.uniclick = cont_uni_p.ResumenProductos.uniclick;

            }
        }

        try{
            if( cont_uni_p.ResumenProductos != undefined ){
                if (cont_uni_p.ResumenProductos.leasing != undefined ) {
                    this.tipoProducto.leasing = cont_uni_p.ResumenProductos.leasing;
                }
                if (cont_uni_p.ResumenProductos.factoring != undefined ) {
                    this.tipoProducto.factoring = cont_uni_p.ResumenProductos.factoring;
                }
                if (cont_uni_p.ResumenProductos.credito_auto != undefined ) {
                    this.tipoProducto.credito_auto = cont_uni_p.ResumenProductos.credito_auto;
                }
                if (cont_uni_p.ResumenProductos.fleet != undefined ) {
                    this.tipoProducto.fleet = cont_uni_p.ResumenProductos.fleet;
                }
                if (cont_uni_p.ResumenProductos.uniclick != undefined ) {
                    this.tipoProducto.uniclick = cont_uni_p.ResumenProductos.uniclick;
                }
            }
        } catch (err) {
            console.log(err.message);
        }

        if (contexto_cuenta.createMode) {
            //this.tipoProducto.uniclick = cont_uni_p.ResumenProductos.uniclick;
            if (this.tipoProducto.uniclick != null && typeof (this.$('.list_u_canal').select2('val')) == "string") {
                this.tipoProducto.uniclick.canal_c = $('.list_u_canal').select2('val'); //lista Canal uniclcick
                //Establece el objeto para guardar
                this.model.set('account_uni_productos', this.tipoProducto);
            }
            // Asigna multilinea_c value
            if (this.tipoProducto.leasing != null) {
                this.tipoProducto.leasing.multilinea_c = $('.chk_ls_multi')[0].checked;
                this.model.set('account_uni_productos', this.tipoProducto);

            }
            if (this.tipoProducto.factoring != null) {
                //    this.tipoProducto.factoring = cont_uni_p.ResumenProductos.factoring
                this.tipoProducto.factoring.multilinea_c = $('.chk_fac_multi')[0].checked;
                this.model.set('account_uni_productos', this.tipoProducto);
            }
            if (this.tipoProducto.credito_auto != null) {
                //    this.tipoProducto.credito_auto = cont_uni_p.ResumenProductos.credito_auto
                this.tipoProducto.credito_auto.multilinea_c = $('.chk_ca_multi')[0].checked;
                this.model.set('account_uni_productos', this.tipoProducto);
            }
            if (this.tipoProducto.fleet != null) {
                //    this.tipoProducto.fleet = cont_uni_p.ResumenProductos.fleet
                this.tipoProducto.fleet.multilinea_c = $('.chk_fe_multi')[0].checked;
                this.model.set('account_uni_productos', this.tipoProducto);
            }
            if (this.tipoProducto.uniclick != null) {
                //this.tipoProducto.uniclick = cont_uni_p.ResumenProductos.leasing
                this.tipoProducto.uniclick.multilinea_c = $('.chk_uniclick_multi')[0].checked;
                this.model.set('account_uni_productos', this.tipoProducto);
            }
        }
        else {
            if (this.tipoProducto.uniclick != null && typeof (this.$('.list_u_canal').select2('val')) == "string") {
                //this.tipoProducto.uniclick = cont_uni_p.ResumenProductos.uniclick;
                this.tipoProducto.uniclick.canal_c = $('.list_u_canal').select2('val');
                this.model.set('account_uni_productos', this.tipoProducto);
            }
            // Asigna multilinea_c value
            if ($('.chk_ls_multi')[0] != undefined && cont_uni_p.ResumenProductos.leasing != undefined) {
                //this.tipoProducto.leasing = cont_uni_p.ResumenProductos.leasing
                this.tipoProducto.leasing.multilinea_c = $('.chk_ls_multi')[0].checked;
                this.model.set('account_uni_productos', this.tipoProducto);
            }
            if ($('.chk_fac_multi')[0] != undefined && cont_uni_p.ResumenProductos.factoring != undefined) {
                //this.tipoProducto.factoring = cont_uni_p.ResumenProductos.factoring
                this.tipoProducto.factoring.multilinea_c = $('.chk_fac_multi')[0].checked;
                this.model.set('account_uni_productos', this.tipoProducto);
            }
            if ($('.chk_ca_multi')[0] != undefined && cont_uni_p.ResumenProductos.credito_auto != undefined) {
                //this.tipoProducto.credito_auto = cont_uni_p.ResumenProductos.credito_auto
                this.tipoProducto.credito_auto.multilinea_c = $('.chk_ca_multi')[0].checked;
                this.model.set('account_uni_productos', this.tipoProducto);
            }
            if ($('.chk_fe_multi')[0] != undefined && cont_uni_p.ResumenProductos.fleet != undefined) {
                //this.tipoProducto.fleet = cont_uni_p.ResumenProductos.fleet
                this.tipoProducto.fleet.multilinea_c = $('.chk_fe_multi')[0].checked;
                this.model.set('account_uni_productos', this.tipoProducto);
            }
            if ($('.chk_uniclick_multi')[0] != undefined && cont_uni_p.ResumenProductos.uniclick != undefined) {
                //this.tipoProducto.uniclick = cont_uni_p.ResumenProductos.leasing
                this.tipoProducto.uniclick.multilinea_c = $('.chk_uniclick_multi')[0].checked;
                this.model.set('account_uni_productos', this.tipoProducto);
            }
            if($('.chk_ls_excluir')[0]!=undefined && cont_uni_p.ResumenProductos.leasing != undefined){
               //Check Excluir Pre-Calificación
                this.tipoProducto.leasing.exclu_precalif_c = $('.chk_ls_excluir')[0].checked;
                cont_uni_p.ResumenProductos.leasing.exclu_precalif_c=$('.chk_ls_excluir')[0].checked;
                this.model.set('account_uni_productos', this.tipoProducto);
            }
        }
        //cont_uni_p.render();
        callback(null, fields, errors);
        //cont_uni_p.render();
    },

    //Validación para dejar sin editar los campos de producto después de haberlos editado por primera y única vez.
    noeditables: function () {
        // Declara variables para permitir edición
        var editaL = true;
        var editaF = true;
        var editaCA = true;
        var editaFL = true;
        var editaU = true;

        var editaL_LM = true;
        var editaF_LM = true;
        var editaCA_LM = true;
        var editaFL_LM = true;
        var editaU_LM = true;
        // Valida tipo de cuenta por producto
        if (cont_uni_p.ResumenProductos != undefined) {
            //Valida Leasing TIPO CUENTA 1-LEAD - SUBTIPO CUENTA 2-CONTACTADO - SUBTIPO CUENTA 7-INTERESADO
            if (cont_uni_p.ResumenProductos.leasing.tipo_cuenta != 1 && cont_uni_p.ResumenProductos.leasing.subtipo_cuenta != 2 && cont_uni_p.ResumenProductos.leasing.subtipo_cuenta != 7 && this.model.get('user_id_c') != App.user.id) {
                editaL = false;
            }
            //Valida Factoraje TIPO CUENTA 1-LEAD - SUBTIPO CUENTA 2-CONTACTADO - SUBTIPO CUENTA 7-INTERESADO
            if (cont_uni_p.ResumenProductos.factoring.tipo_cuenta != 1 && cont_uni_p.ResumenProductos.factoring.subtipo_cuenta != 2 && cont_uni_p.ResumenProductos.factoring.subtipo_cuenta != 7 && this.model.get('user_id1_c') != App.user.id) {
                editaF = false;
            }
            //Valida CA TIPO CUENTA 1-LEAD - SUBTIPO CUENTA 2-CONTACTADO - SUBTIPO CUENTA 7-INTERESADO
            if (cont_uni_p.ResumenProductos.credito_auto.tipo_cuenta != 1 && cont_uni_p.ResumenProductos.credito_auto.subtipo_cuenta != 2 && cont_uni_p.ResumenProductos.credito_auto.subtipo_cuenta != 7 && this.model.get('user_id2_c') != App.user.id) {
                editaCA = false;
            }
                           //Valida FLEET TIPO CUENTA 1-LEAD - SUBTIPO CUENTA 2-CONTACTADO - SUBTIPO CUENTA 7-INTERESADO
            if (cont_uni_p.ResumenProductos.fleet.tipo_cuenta != 1 && cont_uni_p.ResumenProductos.fleet.subtipo_cuenta != 2 && cont_uni_p.ResumenProductos.fleet.subtipo_cuenta != 7 && this.model.get('user_id6_c') != App.user.id) {
                editaFL = false;
            }
            //Valida UNICLICK TIPO CUENTA 1-LEAD - SUBTIPO CUENTA 2-CONTACTADO - SUBTIPO CUENTA 7-INTERESADO
            if (cont_uni_p.ResumenProductos.uniclick.tipo_cuenta != 1 && cont_uni_p.ResumenProductos.uniclick.subtipo_cuenta != 2 && cont_uni_p.ResumenProductos.uniclick.subtipo_cuenta != 7 && this.model.get('user_id7_c') != App.user.id) {
                editaU = false;
            }
            /***********************************************************/
            if (cont_uni_p.ResumenProductos.leasing.tipo_cuenta == '3' && (cont_uni_p.ResumenProductos.leasing.status_management_c == '4' || cont_uni_p.ResumenProductos.leasing.status_management_c == '5')) {
                editaL_LM = false;
            }

            if (cont_uni_p.ResumenProductos.factoring.tipo_cuenta == '3' && (cont_uni_p.ResumenProductos.factoring.status_management_c == '4' || cont_uni_p.ResumenProductos.factoring.status_management_c == '5')) {
                editaF_LM = false;
            }

            if (cont_uni_p.ResumenProductos.credito_auto.tipo_cuenta == '3' && (cont_uni_p.ResumenProductos.credito_auto.status_management_c == '4' || cont_uni_p.ResumenProductos.credito_auto.status_management_c == '5')) {
                editaCA_LM = false;
            }

            if (cont_uni_p.ResumenProductos.fleet.tipo_cuenta == '3' && (cont_uni_p.ResumenProductos.fleet.status_management_c == '4' || cont_uni_p.ResumenProductos.fleet.status_management_c == '5')) {
                editaFL_LM = false;
            }

            if (cont_uni_p.ResumenProductos.uniclick.tipo_cuenta == '3' && (cont_uni_p.ResumenProductos.uniclick.status_management_c == '4' || cont_uni_p.ResumenProductos.uniclick.status_management_c == '5')) {
                editaU_LM = false;
            }
        }
        // Evalua condiciones para bloquear edición
        if ($('.chk_l_nv')[0] != undefined) {
            if ($('.chk_l_nv')[0].checked || !editaL) {
                //Campos sin editar Leasing
                $('.chk_l_nv').prop("disabled", true);  //No Viable Leasing LEASING
                $('.list_l_nv_razon').prop("disabled", true); //Razón de Lead no viable LEASING
                $('.list_l_nv_razon_fp').prop("disabled", true); //Fuera de Perfil (Razón) LEASING
                $('.txt_l_nv_quien').prop("disabled", true); //¿Quién? LEASING
                $('.txt_l_nv_porque').prop("disabled", true);  //¿Por qué? LEASING
                $('.list_l_nv_producto').prop("disabled", true); // ¿Qué producto? LEASING
                $('.list_l_nv_razon_cf').prop("disabled", true); //Condiciones Financieras LEASING
                $('.txt_l_nv_otro').prop("disabled", true);   // TXT ¿Qué producto? LEASING
                $('.list_l_nv_razon_ni').prop("disabled", true);  // Razón No se encuentra interesado LEASING
            }
        }
        if ($('.chk_f_nv')[0] != undefined) {
            if ($('.chk_f_nv')[0].checked || !editaF) {
                //Campos sin editar Factoraje
                $('.chk_f_nv').prop("disabled", true); //No Viable Leasing FACTORAJE
                $('.list_f_nv_razon').prop("disabled", true); //Razón de Lead no viable FACTORAJE
                $('.list_f_nv_razon_fp').prop("disabled", true); //Fuera de Perfil (Razón) FACTORAJE
                $('.txt_f_nv_quien').prop("disabled", true); //¿Quién? FACTORAJE
                $('.txt_f_nv_porque').prop("disabled", true); //¿Por qué? FACTORAJE
                $('.list_f_nv_producto').prop("disabled", true); // ¿Qué producto? FACTORAJE
                $('.list_f_nv_razon_cf').prop("disabled", true); //Condiciones Financieras FACTORAJE
                $('.txt_f_nv_otro').prop("disabled", true); // TXT ¿Qué producto? FACTORAJE
                $('.list_f_nv_razon_ni').prop("disabled", true); // Razón No se encuentra interesado FACTORAJE
            }
        }
        if ($('.chk_ca_nv')[0] != undefined) {
            if ($('.chk_ca_nv')[0].checked || !editaCA) {
                //Campos sin editar Credito Automotriz
                $('.chk_ca_nv').prop("disabled", true); //No Viable Leasing CA
                $('.list_ca_nv_razon').prop("disabled", true); //Razón de Lead no viable CA
                $('.list_ca_nv_razon_fp').prop("disabled", true); //Fuera de Perfil (Razón) CA
                $('.txt_ca_nv_quien').prop("disabled", true); //¿Quién? CA
                $('.txt_ca_nv_porque').prop("disabled", true); //¿Por qué? CA
                $('.list_ca_nv_producto').prop("disabled", true); // ¿Qué producto? CA
                $('.list_ca_nv_razon_cf').prop("disabled", true); //Condiciones Financieras CA
                $('.txt_ca_nv_otro').prop("disabled", true); // TXT ¿Qué producto? CA
                $('.list_ca_nv_razon_ni').prop("disabled", true); // Razón No se encuentra interesado CA
            }
        }
        if ($('.chk_fl_nv')[0] != undefined) {
            if ($('.chk_fl_nv')[0].checked || !editaFL) {
                //Campos sin editar Fleet
                $('.chk_fl_nv').prop("disabled", true); //No Viable Leasing FLEET
                $('.list_fl_nv_razon').prop("disabled", true); //Razón de Lead no viable FLEET
                $('.list_fl_nv_razon_fp').prop("disabled", true); //Fuera de Perfil (Razón) FLEET
                $('.txt_fl_nv_quien').prop("disabled", true); //¿Quién? FLEET
                $('.txt_fl_nv_porque').prop("disabled", true); //¿Por qué? FLEET
                $('.list_fl_nv_producto').prop("disabled", true); // ¿Qué producto? FLEET
                $('.list_fl_nv_razon_cf').prop("disabled", true); //Condiciones Financieras FLEET
                $('.txt_fl_nv_otro').prop("disabled", true); // TXT ¿Qué producto? FLEET
                $('.list_fl_nv_razon_ni').prop("disabled", true); // Razón No se encuentra interesado FLEET
            }
        }
        if ($('.chk_u_nv')[0] != undefined) {
            if ($('.chk_u_nv')[0].checked || !editaU) {
                //Campos sin editar Uniclick
                $('.chk_u_nv').prop("disabled", true); //No Viable Leasing Uniclick
                $('.list_u_nv_razon').prop("disabled", true); //Razón de Lead no viable Uniclick
                $('.list_u_nv_razon_fp').prop("disabled", true); //Fuera de Perfil (Razón) Uniclick
                $('.txt_u_nv_quien').prop("disabled", true); //¿Quién? Uniclick
                $('.txt_u_nv_porque').prop("disabled", true); //¿Por qué? Uniclick
                $('.list_u_nv_producto').prop("disabled", true); // ¿Qué producto? Uniclick
                $('.list_u_nv_razon_cf').prop("disabled", true); //Condiciones Financieras Uniclick
                $('.txt_u_nv_otro').prop("disabled", true); // TXT ¿Qué producto? Uniclick
                $('.list_u_nv_razon_ni').prop("disabled", true); // Razón No se encuentra interesado Uniclick
            }
        }
        /*************************************************************/
        // Evalua condiciones para bloquear edición
        if (!editaL_LM) {
            //Campos sin editar Leasing
            $('.list_l_so_razon').prop("disabled", true);
            $('.list_l_so_motivo').prop("disabled", true);
            $('.txt_l_so_detalle').prop("disabled", true);
            $('.list_l_respval_1').prop("disabled", true);
            $('.list_l_respval_2').prop("disabled", true);
            $('.list_l_estatus_lm').prop("disabled", true);
        }
        if (!editaF_LM)  {
            //Campos sin editar Factoraje
            $('.list_f_razon_lm').prop("disabled", true);
            $('.list_f_so_motivo').prop("disabled", true);
            $('.txt_f_so_detalle').prop("disabled", true);
            $('.list_f_respval_1').prop("disabled", true);
            $('.list_f_respval_2').prop("disabled", true);
        }
        if (!editaCA_LM) {
            $('.list_ca_so_razon').prop("disabled", true);
            $('.list_ca_so_motivo').prop("disabled", true);
            $('.txt_ca_so_detalle').prop("disabled", true);
            $('.list_ca_respval_1').prop("disabled", true);
            $('.list_ca_respval_2').prop("disabled", true);
        }
        if (!editaFL_LM) {
            //Campos sin editar Fleet
            $('.list_fl_so_razon').prop("disabled", true);
            $('.list_fl_so_motivo').prop("disabled", true);
            $('.txt_fl_so_detalle').prop("disabled", true);
            $('.list_fl_respval_1').prop("disabled", true);
            $('.list_fl_respval_2').prop("disabled", true);
        }
        if (!editaU_LM) {
            //Campos sin editar Uniclick
            $('.list_u_so_razon').prop("disabled", true);
            $('.list_u_so_motivo').prop("disabled", true);
            $('.txt_u_so_detalle').prop("disabled", true);
            $('.list_u_respval_1').prop("disabled", true);
            $('.list_u_respval_2').prop("disabled", true);
        }
    },

    //Carga las listas desplegables para los campos.
    cargalistas: function () {
        cont_uni_p.razones_ddw_list = app.lang.getAppListStrings('razones_ddw_list');
        cont_uni_p.fuera_de_perfil_ddw_list = app.lang.getAppListStrings('fuera_de_perfil_ddw_list');
        cont_uni_p.no_producto_requiere_list = app.lang.getAppListStrings('no_producto_requiere_list');
        cont_uni_p.razones_cf_list = app.lang.getAppListStrings('razones_cf_list');
        cont_uni_p.tct_razon_ni_l_ddw_c_list = app.lang.getAppListStrings('tct_razon_ni_l_ddw_c_list');
        cont_uni_p.canales_ddw_list = app.lang.getAppListStrings('canal_list');
        cont_uni_p.status_management_list = app.lang.getAppListStrings('status_management_list');
        cont_uni_p.status_management_list_edit = app.lang.getAppListStrings('status_management_list');

        cont_uni_p.motivo_bloqueo_list_general = app.lang.getAppListStrings('motivo_bloqueo_list');
        cont_uni_p.razon_list_general = app.lang.getAppListStrings('razon_list');

        cont_uni_p.motivo_bloqueo_list = app.lang.getAppListStrings('motivo_bloqueo_list');
        cont_uni_p.razon_list = app.lang.getAppListStrings('razon_list');

        delete cont_uni_p.status_management_list_edit[2];
        delete cont_uni_p.status_management_list_edit[3];
        delete cont_uni_p.status_management_list_edit[""];
    },

    //Funcion que acepta solo letras (a-z), puntos(.) y comas(,)
    PuroTexto: function (evt) {
        //console.log(evt.keyCode);
        if ($.inArray(evt.keyCode, [9, 16, 17, 110, 190, 45, 33, 36, 46, 35, 34, 8, 9, 20, 16, 17, 37, 40, 39, 38, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 16, 32, 192]) < 0) {
            if (evt.keyCode != 186) {
                app.alert.show("Caracter Invalido", {
                    level: "error",
                    title: "Solo texto es permitido en este campo.",
                    autoClose: true
                });
                return false;
            }
        }
    },

    //Carga Condiciones
    carga_condiciones: function () {
        cont_uni_p.datacondiciones = {};
        var filter_arguments =
        {
            max_num:-1,
            "fields": [
                "id",
                "condicion",
                "razon",
                "motivo",
                "detalle",
                "responsable1",
                "responsable2",
                "bloquea",
            ],
        };
        filter_arguments["filter"] = [
            {
                "$or":[
                    {
                       "condicion":"4"
                    },
                    {
                       "condicion":"5"
                    }
                ]
            }
        ];
        var j= 0;
        var url = app.api.buildURL('tct4_Condiciones/');
        //app.api.call('GET',url, null, {
        app.api.call("read", app.api.buildURL("tct4_Condiciones", null, null, filter_arguments), null, {
            success: _.bind(function (data) {
                cont_uni_p.datacondiciones = data;
                if (cont_uni_p.ResumenProductos != '' && cont_uni_p.ResumenProductos != undefined) {
                    if(this.busca_bloquea(cont_uni_p.ResumenProductos.leasing.status_management_c  , cont_uni_p.ResumenProductos.leasing.razon_c , cont_uni_p.ResumenProductos.leasing.motivo_c )){
                        $('.l_so_raspval2').show();
                    }
                    if(this.busca_bloquea(cont_uni_p.ResumenProductos.factoring.status_management_c  , cont_uni_p.ResumenProductos.factoring.razon_c , cont_uni_p.ResumenProductos.factoring.motivo_c )){
                        $('.f_so_raspval2').show();
                    }
                    if(this.busca_bloquea(cont_uni_p.ResumenProductos.credito_auto.status_management_c  , cont_uni_p.ResumenProductos.credito_auto.razon_c , cont_uni_p.ResumenProductos.credito_auto.motivo_c )){
                        $('.ca_so_raspval2').show();
                    }
                    if(this.busca_bloquea(cont_uni_p.ResumenProductos.fleet.status_management_c  , cont_uni_p.ResumenProductos.fleet.razon_c , cont_uni_p.ResumenProductos.fleet.motivo_c )){
                        $('.fl_so_raspval2').show();
                    }
                    if(this.busca_bloquea(cont_uni_p.ResumenProductos.uniclick.status_management_c  , cont_uni_p.ResumenProductos.uniclick.razon_c , cont_uni_p.ResumenProductos.uniclick.motivo_c )){
                        $('.u_so_raspval2').show();
                    }
                }else{
                  cont_uni_p.ResumenProductos = contexto_cuenta.ResumenProductos;
                }
                cont_uni_p.render();
            }, cont_uni_p),
            error: function (e) {
                throw e;
            }
        });
    },

    buscaRazon:function (tipoProducto) {

        cont_uni_p.datarazones = {};

        switch (tipoProducto) {
            case "1": //Leasing
                document.getElementById("list_l_so_razon").options.length=0;
                document.getElementById("list_l_so_razon").innerHTML = "";
                document.getElementById("list_l_so_razon").selectedIndex = "-1"
                break;
            case "4": //Factoraje
                document.getElementById("list_f_razon_lm").options.length=0;
                document.getElementById("list_f_razon_lm").innerHTML = "";
                document.getElementById("list_f_razon_lm").selectedIndex = "-1"
                break;
            case "3": //Credito-auto
                document.getElementById("list_ca_so_razon").options.length=0;
                document.getElementById("list_ca_so_razon").innerHTML = "";
                document.getElementById("list_ca_so_razon").selectedIndex = "-1"
                break;
            case "6": //Fleet
                document.getElementById("list_fl_so_razon").options.length=0;
                document.getElementById("list_fl_so_razon").innerHTML = "";
                document.getElementById("list_fl_so_razon").selectedIndex = "-1"
                break;
            case "8": //Uniclick
                document.getElementById("list_u_so_razon").options.length=0;
                document.getElementById("list_u_so_razon").innerHTML = "";
                document.getElementById("list_u_so_razon").selectedIndex = "-1"
                break;
        }
        var seleccionado = -1;

        for(var i = 0; i < cont_uni_p.datacondiciones.records.length; i++) {
            switch (tipoProducto) {
                case "1": //Leasing
                    if($("#list_l_estatus_lm")[0].value == cont_uni_p.datacondiciones.records[i].condicion ) {
                        cont_uni_p.datarazones[cont_uni_p.datacondiciones.records[i].razon] = app.lang.getAppListStrings('razon_list')[cont_uni_p.datacondiciones.records[i].razon];
                    }
                    break;
                case "4": //Factoraje
                    if($("#list_fac_estatus_lm")[0].value == cont_uni_p.datacondiciones.records[i].condicion ) {
                        cont_uni_p.datarazones[cont_uni_p.datacondiciones.records[i].razon] = app.lang.getAppListStrings('razon_list')[cont_uni_p.datacondiciones.records[i].razon];
                    }
                    break;
                case "3": //Credito-auto
                    if($("#list_ca_estatus_lm")[0].value == cont_uni_p.datacondiciones.records[i].condicion) {
                        cont_uni_p.datarazones[cont_uni_p.datacondiciones.records[i].razon] = app.lang.getAppListStrings('razon_list')[cont_uni_p.datacondiciones.records[i].razon];
                    }
                    break;
                case "6": //Fleet
                    if($("#list_fl_estatus_lm")[0].value == cont_uni_p.datacondiciones.records[i].condicion ) {
                        cont_uni_p.datarazones[cont_uni_p.datacondiciones.records[i].razon] = app.lang.getAppListStrings('razon_list')[cont_uni_p.datacondiciones.records[i].razon];
                    }
                    break;
                case "8": //Uniclick
                    if($("#list_u_estatus_lm")[0].value == cont_uni_p.datacondiciones.records[i].condicion) {
                        cont_uni_p.datarazones[cont_uni_p.datacondiciones.records[i].razon] = app.lang.getAppListStrings('razon_list')[cont_uni_p.datacondiciones.records[i].razon];
                    }
                    break;
            }
        }

        var i =0;
        _.each(cont_uni_p.datarazones, function (value, key) {
            switch (tipoProducto) {
                case "1": //Leasing Object.keys(obj)
                    document.getElementById("list_l_so_razon").options[i]=new Option(value,key);
                    if(i == 0){seleccionado = key}
                    i++;
                    break;
                case "4": //Factoraje
                    document.getElementById("list_f_razon_lm").options[i]=new Option(value,key);
                    if(i == 0){seleccionado = key}
                    i++;
                    break;
                case "3": //Credito-auto
                    document.getElementById("list_ca_so_razon").options[i]=new Option(value,key);
                    if(i == 0){seleccionado = key}
                    i++;
                    break;
                case "6": //Fleet
                    document.getElementById("list_fl_so_razon").options[i]=new Option(value,key);
                    if(i == 0){seleccionado = key}
                    i++;
                    break;
                case "8": //Uniclick
                    document.getElementById("list_u_so_razon").options[i]=new Option(value,key);
                    if(i == 0){seleccionado = key}
                    i++;
                    break;
            }
        });

        switch (tipoProducto) {
            case "1": //Leasing
                document.getElementById("list_l_so_razon").value = "";
                document.getElementById("list_l_so_motivo").value = "";
                break;
            case "4": //Factoraje
                document.getElementById("list_f_razon_lm").value = "";
                document.getElementById("list_f_so_motivo").value = "";
                break;
            case "3": //Credito-auto
                document.getElementById("list_ca_so_razon").value = "";
                document.getElementById("list_ca_so_motivo").value = "";
                break;
            case "6": //Fleet
                document.getElementById("list_fl_so_razon").value = "";
                document.getElementById("list_fl_so_motivo").value = "";
                break;
            case "8": //Uniclick
                document.getElementById("list_u_so_razon").value = "";
                document.getElementById("list_u_so_motivo").value = "";
                break;
        }
        //console.log(cont_uni_p.datarazones);
    },

    buscaMotivo:function (tipoProducto) {

        switch (tipoProducto) {
            case "1": //Leasing
                document.getElementById("list_l_so_motivo").options.length=0;
                document.getElementById("list_l_so_motivo").innerHTML = "";
                document.getElementById("list_l_so_motivo").selectedIndex = "-1"
                /****************************************/
                $('.list_l_so_motivo').select2('val', "");
                $('.list_l_respval_1').select2('val', "");
                $('.list_l_respval_2').select2('val', "");
                break;
            case "4": //Factoraje
                document.getElementById("list_f_so_motivo").options.length=0;
                document.getElementById("list_f_so_motivo").innerHTML = "";
                document.getElementById("list_f_so_motivo").selectedIndex = "-1"
                /****************************************/
                $('.list_f_so_motivo').select2('val', "");
                $('.list_f_respval_1').select2('val', "");
                $('.list_f_respval_2').select2('val', "");
                break;
            case "3": //Credito-auto
                document.getElementById("list_ca_so_motivo").options.length=0;
                document.getElementById("list_ca_so_motivo").innerHTML = "";
                document.getElementById("list_ca_so_motivo").selectedIndex = "-1"
                /****************************************/
                $('.list_ca_so_motivo').select2('val', "");
                $('.list_ca_respval_1').select2('val', "");
                $('.list_ca_respval_2').select2('val', "");
                break;
            case "6": //Fleet
                document.getElementById("list_fl_so_motivo").options.length=0;
                document.getElementById("list_fl_so_motivo").innerHTML = "";
                document.getElementById("list_fl_so_motivo").selectedIndex = "-1"
                /****************************************/
                $('.list_fl_so_motivo').select2('val', "");
                $('.list_fl_respval_1').select2('val', "");
                $('.list_fl_respval_2').select2('val', "");
                break;
            case "8": //Uniclick
                document.getElementById("list_u_so_motivo").options.length=0;
                document.getElementById("list_u_so_motivo").innerHTML = "";
                document.getElementById("list_u_so_motivo").selectedIndex = "-1"
                /****************************************/
                $('.list_u_so_motivo').select2('val', "");
                $('.list_u_respval_1').select2('val', "");
                $('.list_u_respval_2').select2('val', "");
                break;
        }
        cont_uni_p.datamotivos = {};

        var j =0;
        for(var i = 0; i < cont_uni_p.datacondiciones.records.length; i++) {
            switch (tipoProducto) {
                case "1": //Leasing
                    if($("#list_l_so_razon")[0].value == cont_uni_p.datacondiciones.records[i].razon) {
                        document.getElementById("list_l_so_motivo").options[j]=new Option(app.lang.getAppListStrings('motivo_bloqueo_list')[cont_uni_p.datacondiciones.records[i].motivo],cont_uni_p.datacondiciones.records[i].motivo);
                        cont_uni_p.datamotivos[cont_uni_p.datacondiciones.records[i].motivo] = app.lang.getAppListStrings('motivo_bloqueo_list')[cont_uni_p.datacondiciones.records[i].motivo];
                        j++;
                    }
                    break;
                case "4": //Factoraje
                    if($("#list_f_razon_lm")[0].value == cont_uni_p.datacondiciones.records[i].razon) {
                        document.getElementById("list_f_so_motivo").options[j]=new Option(app.lang.getAppListStrings('motivo_bloqueo_list')[cont_uni_p.datacondiciones.records[i].motivo],cont_uni_p.datacondiciones.records[i].motivo);
                        cont_uni_p.datamotivos[cont_uni_p.datacondiciones.records[i].motivo] = app.lang.getAppListStrings('motivo_bloqueo_list')[cont_uni_p.datacondiciones.records[i].motivo];
                        j++;
                    }
                    break;
                case "3": //Credito-auto
                    if($("#list_ca_so_razon")[0].value == cont_uni_p.datacondiciones.records[i].razon ) {
                        document.getElementById("list_ca_so_motivo").options[j]=new Option(app.lang.getAppListStrings('motivo_bloqueo_list')[cont_uni_p.datacondiciones.records[i].motivo],cont_uni_p.datacondiciones.records[i].motivo);
                        cont_uni_p.datamotivos[cont_uni_p.datacondiciones.records[i].motivo] = app.lang.getAppListStrings('motivo_bloqueo_list')[cont_uni_p.datacondiciones.records[i].motivo];
                        j++;
                    }
                    break;
                case "6": //Fleet
                    if($("#list_fl_so_razon")[0].value == cont_uni_p.datacondiciones.records[i].razon) {
                        document.getElementById("list_fl_so_motivo").options[j]=new Option(app.lang.getAppListStrings('motivo_bloqueo_list')[cont_uni_p.datacondiciones.records[i].motivo],cont_uni_p.datacondiciones.records[i].motivo);
                        cont_uni_p.datamotivos[cont_uni_p.datacondiciones.records[i].motivo] = app.lang.getAppListStrings('motivo_bloqueo_list')[cont_uni_p.datacondiciones.records[i].motivo];
                        j++;
                    }
                    break;
                case "8": //Uniclick
                    if($("#list_u_so_razon")[0].value == cont_uni_p.datacondiciones.records[i].razon ) {
                        document.getElementById("list_u_so_motivo").options[j]=new Option(app.lang.getAppListStrings('motivo_bloqueo_list')[cont_uni_p.datacondiciones.records[i].motivo],cont_uni_p.datacondiciones.records[i].motivo);
                        cont_uni_p.datamotivos[cont_uni_p.datacondiciones.records[i].motivo] = app.lang.getAppListStrings('motivo_bloqueo_list')[cont_uni_p.datacondiciones.records[i].motivo];
                        j++;
                    }
                    break;
            }
        }

        switch (tipoProducto) {
            case "1": //Leasing
                document.getElementById("list_l_so_motivo").value = "";
                break;
            case "4": //Factoraje
                document.getElementById("list_f_so_motivo").value = "";
                break;
            case "3": //Credito-auto
                document.getElementById("list_ca_so_motivo").value = "";
                break;
            case "6": //Fleet
                document.getElementById("list_fl_so_motivo").value = "";
                break;
            case "8": //Uniclick
                document.getElementById("list_u_so_motivo").value = "";
                break;
        }

        if(App.user.attributes.bloqueo_cuentas_c == 1){
            cont_uni_p.usuarioUnico(tipoProducto);
        }else{
            if($("#list_l_so_razon")[0].value == '7' || $("#list_f_razon_lm")[0].value == '7' || $("#list_ca_so_razon")[0].value == '7'
            || $("#list_fl_so_razon")[0].value == '7' || $("#list_u_so_razon")[0].value == '7'){

                if($("#list_l_so_razon")[0].value == '7' &&  tipoProducto == '1'){
                    cont_uni_p.carga_usuarios_resp_validacion2(tipoProducto);
                    $('.l_so_raspval2_edit').show();
                    //$('.l_so_raspval2').show();
                }else if(tipoProducto == '1'){
                    $('.l_so_raspval2_edit').hide();
                }
    
                if($("#list_f_razon_lm")[0].value == '7' && tipoProducto == '4'){
                    cont_uni_p.carga_usuarios_resp_validacion2(tipoProducto);
                    $('.f_so_raspval2_edit').show();
                }else if(tipoProducto == '4'){
                    $('.f_so_raspval2_edit').hide();
                }
    
                if( $("#list_ca_so_razon")[0].value == '7' && tipoProducto == '3'){
                    cont_uni_p.carga_usuarios_resp_validacion2(tipoProducto);
                    $('.ca_so_raspval2_edit').show();
                }else if(tipoProducto == '3'){
                    $('.ca_so_raspval2_edit').hide();
                }
    
                if($("#list_fl_so_razon")[0].value == '7'&& tipoProducto == '6'){
                    cont_uni_p.carga_usuarios_resp_validacion2(tipoProducto);
                    $('.fl_so_raspval2_edit').show();
                }else if(tipoProducto == '6'){
                    $('.fl_so_raspval2_edit').hide();
                }
    
                if( $("#list_u_so_razon")[0].value == '7' && tipoProducto == '8'){
                    cont_uni_p.carga_usuarios_resp_validacion2(tipoProducto);
                    $('.u_so_raspval2_edit').show();
                }else if(tipoProducto == '8'){
                    $('.u_so_raspval2_edit').hide();
                }
            }else{
                cont_uni_p.carga_usuarios_resp_validacion_reload(tipoProducto);
                $('.l_so_raspval2_edit').hide();
                $('.f_so_raspval2_edit').hide();
                $('.ca_so_raspval2_edit').hide();
                $('.fl_so_raspval2_edit').hide();
                $('.u_so_raspval2_edit').hide();
            }
        }
    },

    usuarioUnico:function (tipoProducto) {
        switch (tipoProducto) {
            case "1": //Leasing
                $('.list_l_respval_1').select2('val', "");
                $('.list_l_respval_2').select2('val', "");
                document.getElementById("list_l_respval_1").options[0]=new Option( App.user.attributes.full_name , App.user.attributes.id );
                $('.list_l_respval_1').select2('val', App.user.attributes.id);
                break;
            case "4": //Factoraje
                $('.list_f_respval_1').select2('val', "");
                $('.list_f_respval_2').select2('val', "");
                document.getElementById("list_f_respval_1").options[0]=new Option( App.user.attributes.full_name , App.user.attributes.id );
                $('.list_f_respval_1').select2('val', App.user.attributes.id);
                break;
            case "3": //Credito-auto
                $('.list_ca_respval_1').select2('val', "");
                $('.list_ca_respval_2').select2('val', "");
                document.getElementById("list_ca_respval_1").options[0]=new Option( App.user.attributes.full_name , App.user.attributes.id );
                $('.list_ca_respval_1').select2('val', App.user.attributes.id);
                break;
            case "6": //Fleet
                $('.list_fl_respval_1').select2('val', "");
                $('.list_fl_respval_2').select2('val', "");
                document.getElementById("list_fl_respval_1").options[0]=new Option( App.user.attributes.full_name , App.user.attributes.id );
                $('.list_fl_respval_1').select2('val', App.user.attributes.id);
                break;
            case "8": //Uniclick
                $('.list_u_respval_1').select2('val', "");
                $('.list_u_respval_2').select2('val', "");
                document.getElementById("list_u_respval_1").options[1]=new Option( App.user.attributes.full_name , App.user.attributes.id );
                $('.list_u_respval_1').select2('val', App.user.attributes.id);
                break;
        }
    },

    buscaMotivoFinal:function (tipoProducto) {

        if(App.user.attributes.bloqueo_cuentas_c == 1){
            cont_uni_p.usuarioUnico(tipoProducto);
        }else{

        if(($("#list_l_so_razon")[0].value == '10' && $("#list_l_so_motivo")[0].value == '7')
        || ($("#list_f_razon_lm")[0].value == '10' && $("#list_f_so_motivo")[0].value == '7')
        || ($("#list_ca_so_razon")[0].value == '10' && $("#list_ca_so_motivo")[0].value == '7')
        || ($("#list_fl_so_razon")[0].value == '10' && $("#list_fl_so_motivo")[0].value == '7')
        || ($("#list_u_so_razon")[0].value == '10' && $("#list_u_so_motivo")[0].value == '7')){

            if(($("#list_l_so_razon")[0].value == '10' && $("#list_l_so_motivo")[0].value == '7') && tipoProducto == '1'){
                cont_uni_p.carga_usuarios_resp_validacion2(tipoProducto);
                $('.l_so_raspval2_edit').show();
            }else if(tipoProducto == '1'){
                $('.l_so_raspval2_edit').hide();
            }

            if(($("#list_f_razon_lm")[0].value == '10' && $("#list_f_so_motivo")[0].value == '7') && tipoProducto == '4' ){
                cont_uni_p.carga_usuarios_resp_validacion2(tipoProducto);
                $('.f_so_raspval2_edit').show();
            }else if(tipoProducto == '4'){
                $('.f_so_raspval2_edit').hide();
            }

            if(($("#list_ca_so_razon")[0].value == '10' && $("#list_ca_so_motivo")[0].value == '7') && tipoProducto == '3'){
                cont_uni_p.carga_usuarios_resp_validacion2(tipoProducto);
                $('.ca_so_raspval2_edit').show();
            }else if(tipoProducto == '3'){
                $('.ca_so_raspval2_edit').hide();
            }

            if(($("#list_fl_so_razon")[0].value == '10' && $("#list_fl_so_motivo")[0].value == '7') && tipoProducto == '6'){
                cont_uni_p.carga_usuarios_resp_validacion2(tipoProducto);
                $('.fl_so_raspval2_edit').show();
            }else if(tipoProducto == '6'){
                $('.fl_so_raspval2_edit').hide();
            }
            if(($("#list_u_so_razon")[0].value == '10' && $("#list_u_so_motivo")[0].value == '7') && tipoProducto == '8' ){
                cont_uni_p.carga_usuarios_resp_validacion2(tipoProducto);
                $('.u_so_raspval2_edit').show();
            }else if(tipoProducto == '8'){
                $('.u_so_raspval2_edit').hide();
            }
        }else{
            cont_uni_p.carga_usuarios_resp_validacion_reload(tipoProducto);
            $('.l_so_raspval2_edit').hide();
            $('.f_so_raspval2_edit').hide();
            $('.ca_so_raspval2_edit').hide();
            $('.fl_so_raspval2_edit').hide();
            $('.u_so_raspval2_edit').hide();
        }
        }
    },

    carga_usuarios_resp_validacion_reload:function (tipoProducto){

        var a=0;
        var b=0;
        var c=0;
        var d=0;
        var e=0;

        switch (tipoProducto) {
            case "1": //Leasing
                document.getElementById("list_l_respval_1").options.length=0;
                document.getElementById("list_l_respval_2").options.length=0;

                document.getElementById("list_l_respval_1").innerHTML = "";
                document.getElementById("list_l_respval_1").selectedIndex = "-1"
                document.getElementById("list_l_respval_2").innerHTML = "";
                document.getElementById("list_l_respval_2").selectedIndex = "-1"

                document.getElementById("list_l_respval_1").value =""
                document.getElementById("list_l_respval_2").value =""
                break;
            case "4": //Factoraje
                document.getElementById("list_f_respval_1").options.length=0;
                document.getElementById("list_f_respval_2").options.length=0;

                document.getElementById("list_f_respval_1").innerHTML = "";
                document.getElementById("list_f_respval_1").selectedIndex = "-1"
                document.getElementById("list_f_respval_2").innerHTML = "";
                document.getElementById("list_f_respval_2").selectedIndex = "-1"

                document.getElementById("list_f_respval_1").value =""
                document.getElementById("list_f_respval_2").value =""
                break;
            case "3": //Credito-auto
                document.getElementById("list_ca_respval_1").options.length=0;
                document.getElementById("list_ca_respval_2").options.length=0;

                document.getElementById("list_ca_respval_1").innerHTML = "";
                document.getElementById("list_ca_respval_1").selectedIndex = "-1"
                document.getElementById("list_ca_respval_2").innerHTML = "";
                document.getElementById("list_ca_respval_2").selectedIndex = "-1"

                document.getElementById("list_ca_respval_1").value =""
                document.getElementById("list_ca_respval_2").value =""
                break;
            case "6": //Fleet
                document.getElementById("list_fl_respval_1").options.length=0;
                document.getElementById("list_fl_respval_2").options.length=0;

                document.getElementById("list_fl_respval_1").innerHTML = "";
                document.getElementById("list_fl_respval_1").selectedIndex = "-1"
                document.getElementById("list_fl_respval_2").innerHTML = "";
                document.getElementById("list_fl_respval_2").selectedIndex = "-1"

                document.getElementById("list_fl_respval_1").value =""
                document.getElementById("list_fl_respval_2").value =""
                break;
            case "8": //Uniclick
                document.getElementById("list_u_respval_1").options.length=0;
                document.getElementById("list_u_respval_2").options.length=0;

                document.getElementById("list_u_respval_1").innerHTML = "";
                document.getElementById("list_u_respval_1").selectedIndex = "-1"
                document.getElementById("list_u_respval_2").innerHTML = "";
                document.getElementById("list_u_respval_2").selectedIndex = "-1"

                document.getElementById("list_u_respval_1").value =""
                document.getElementById("list_u_respval_2").value =""
                break;
        }
        var j = 0;
        for(var i=0; i< cont_uni_p.directorEquipo.length ; i++) {
            if(tipoProducto == '1' && cont_uni_p.directorEquipo[i].tipodeproducto_c ==  tipoProducto ){
                document.getElementById("list_l_respval_1").options[j]=new Option(cont_uni_p.directorEquipo[i].nombre_completo_c , cont_uni_p.directorEquipo[i].id );
                document.getElementById("list_l_respval_2").options[j]=new Option(cont_uni_p.directorEquipo[i].nombre_completo_c , cont_uni_p.directorEquipo[i].id );
                j++;
            }
            if(tipoProducto == '4' && cont_uni_p.directorEquipo[i].tipodeproducto_c ==  tipoProducto ){
                document.getElementById("list_f_respval_1").options[j]=new Option(cont_uni_p.directorEquipo[i].nombre_completo_c , cont_uni_p.directorEquipo[i].id);
                document.getElementById("list_f_respval_2").options[j]=new Option(cont_uni_p.directorEquipo[i].nombre_completo_c , cont_uni_p.directorEquipo[i].id);
                j++;
            }
            if(tipoProducto == '3' && cont_uni_p.directorEquipo[i].tipodeproducto_c ==  tipoProducto){
                document.getElementById("list_ca_respval_1").options[j]=new Option(cont_uni_p.directorEquipo[i].nombre_completo_c , cont_uni_p.directorEquipo[i].id);
                document.getElementById("list_ca_respval_2").options[j]=new Option(cont_uni_p.directorEquipo[i].nombre_completo_c , cont_uni_p.directorEquipo[i].id);
                j++;
            }
            if(tipoProducto == '6' && cont_uni_p.directorEquipo[i].tipodeproducto_c ==  tipoProducto){
                document.getElementById("list_fl_respval_1").options[j]=new Option(cont_uni_p.directorEquipo[i].nombre_completo_c , cont_uni_p.directorEquipo[i].id);
                document.getElementById("list_fl_respval_2").options[j]=new Option(cont_uni_p.directorEquipo[i].nombre_completo_c , cont_uni_p.directorEquipo[i].id);
                j++;
            }
            if(tipoProducto == '8' && cont_uni_p.directorEquipo[i].tipodeproducto_c ==  tipoProducto){
                document.getElementById("list_u_respval_1").options[j]=new Option(cont_uni_p.directorEquipo[i].nombre_completo_c , cont_uni_p.directorEquipo[i].id);
                document.getElementById("list_u_respval_2").options[j]=new Option(cont_uni_p.directorEquipo[i].nombre_completo_c , cont_uni_p.directorEquipo[i].id);
                j++;
            }
        }

        switch (tipoProducto) {
            case "1": //Leasing
                document.getElementById("list_l_respval_1").options[j]=new Option('','');
                document.getElementById("list_l_respval_2").options[j]=new Option('','');
                document.getElementById("list_l_respval_1").value =""
                document.getElementById("list_l_respval_2").value =""
                break;
            case "4": //Factoraje
                document.getElementById("list_f_respval_1").options[j]=new Option('','');
                document.getElementById("list_f_respval_2").options[j]=new Option('','');
                document.getElementById("list_f_respval_1").value =""
                document.getElementById("list_f_respval_2").value =""
                break;
            case "3": //Credito-auto
                document.getElementById("list_ca_respval_1").options[j]=new Option('','');
                document.getElementById("list_ca_respval_2").options[j]=new Option('','');
                document.getElementById("list_ca_respval_1").value =""
                document.getElementById("list_ca_respval_2").value =""
                break;
            case "6": //Fleet
                document.getElementById("list_fl_respval_1").options[j]=new Option('','');
                document.getElementById("list_fl_respval_2").options[j]=new Option('','');
                document.getElementById("list_fl_respval_1").value =""
                document.getElementById("list_fl_respval_2").value =""
                break;
            case "8": //Uniclick
                document.getElementById("list_u_respval_1").options[j]=new Option('','');
                document.getElementById("list_u_respval_2").options[j]=new Option('','');
                document.getElementById("list_u_respval_1").value =""
                document.getElementById("list_u_respval_2").value =""
                break;
        }
    },

    carga_usuarios_resp_validacion2:function (tipoProducto){

        var a=0;
        var b=0;
        var c=0;
        var d=0;
        var e=0;

        switch (tipoProducto) {
            case "1": //Leasing
                document.getElementById("list_l_respval_1").options.length=0;
                document.getElementById("list_l_respval_2").options.length=0;
                document.getElementById("list_l_respval_1").value =""
                document.getElementById("list_l_respval_2").value =""
                break;
            case "4": //Factoraje
                document.getElementById("list_f_respval_1").options.length=0;
                document.getElementById("list_f_respval_2").options.length=0;
                document.getElementById("list_f_respval_1").value =""
                document.getElementById("list_f_respval_2").value =""
                break;
            case "3": //Credito-auto
                document.getElementById("list_ca_respval_1").options.length=0;
                document.getElementById("list_ca_respval_2").options.length=0;
                document.getElementById("list_ca_respval_1").value =""
                document.getElementById("list_ca_respval_2").value =""
                break;
            case "6": //Fleet
                document.getElementById("list_fl_respval_1").options.length=0;
                document.getElementById("list_fl_respval_2").options.length=0;
                document.getElementById("list_fl_respval_1").value =""
                document.getElementById("list_fl_respval_2").value =""
                break;
            case "8": //Uniclick
                document.getElementById("list_u_respval_1").options.length=0;
                document.getElementById("list_u_respval_2").options.length=0;
                document.getElementById("list_u_respval_1").value =""
                document.getElementById("list_u_respval_2").value =""
                break;
        }
        var j = 0;
        for(var i=0; i< cont_uni_p.directorRegion.length ; i++) {
            if(tipoProducto == '1' && cont_uni_p.directorRegion[i].tipodeproducto_c ==  tipoProducto){
                document.getElementById("list_l_respval_1").options[j]=new Option(cont_uni_p.directorRegion[i].nombre_completo_c , cont_uni_p.directorRegion[i].id );
                document.getElementById("list_l_respval_2").options[j]=new Option(cont_uni_p.directorRegion[i].nombre_completo_c , cont_uni_p.directorRegion[i].id );
                j++;
            }
            if(tipoProducto == '4' && cont_uni_p.directorRegion[i].tipodeproducto_c ==  tipoProducto){
                document.getElementById("list_f_respval_1").options[j]=new Option(cont_uni_p.directorRegion[i].nombre_completo_c , cont_uni_p.directorRegion[i].id);
                document.getElementById("list_f_respval_2").options[j]=new Option(cont_uni_p.directorRegion[i].nombre_completo_c , cont_uni_p.directorRegion[i].id);
                j++;
            }
            if(tipoProducto == '3' && cont_uni_p.directorRegion[i].tipodeproducto_c ==  tipoProducto){
                document.getElementById("list_ca_respval_1").options[j]=new Option(cont_uni_p.directorRegion[i].nombre_completo_c , cont_uni_p.directorRegion[i].id);
                document.getElementById("list_ca_respval_2").options[j]=new Option(cont_uni_p.directorRegion[i].nombre_completo_c , cont_uni_p.directorRegion[i].id);
                j++;
            }
            if(tipoProducto == '6' && cont_uni_p.directorRegion[i].tipodeproducto_c ==  tipoProducto){
                document.getElementById("list_fl_respval_1").options[j]=new Option(cont_uni_p.directorRegion[i].nombre_completo_c , cont_uni_p.directorRegion[i].id);
                document.getElementById("list_fl_respval_2").options[j]=new Option(cont_uni_p.directorRegion[i].nombre_completo_c , cont_uni_p.directorRegion[i].id);
                j++;
            }
            if(tipoProducto == '8' && cont_uni_p.directorRegion[i].tipodeproducto_c ==  tipoProducto){
                document.getElementById("list_u_respval_1").options[j]=new Option(cont_uni_p.directorRegion[i].nombre_completo_c , cont_uni_p.directorRegion[i].id);
                document.getElementById("list_u_respval_2").options[j]=new Option(cont_uni_p.directorRegion[i].nombre_completo_c , cont_uni_p.directorRegion[i].id);
                j++;
            }
        }
        //var j = 0;
        for(var i=0; i< cont_uni_p.cartera.length ; i++) {
            if(tipoProducto == '1'){
                document.getElementById("list_l_respval_1").options[j]=new Option(cont_uni_p.cartera[i].nombre , cont_uni_p.cartera[i].id );
                document.getElementById("list_l_respval_2").options[j]=new Option(cont_uni_p.cartera[i].nombre , cont_uni_p.cartera[i].id );
                j++;
            }
            if(tipoProducto == '4'){
                document.getElementById("list_f_respval_1").options[j]=new Option(cont_uni_p.cartera[i].nombre , cont_uni_p.cartera[i].id);
                document.getElementById("list_f_respval_2").options[j]=new Option(cont_uni_p.cartera[i].nombre , cont_uni_p.cartera[i].id);
                j++;
            }
            if(tipoProducto == '3'){
                document.getElementById("list_ca_respval_1").options[j]=new Option(cont_uni_p.cartera[i].nombre , cont_uni_p.cartera[i].id);
                document.getElementById("list_ca_respval_2").options[j]=new Option(cont_uni_p.cartera[i].nombre , cont_uni_p.cartera[i].id);
                j++;
            }
            if(tipoProducto == '6'){
                document.getElementById("list_fl_respval_1").options[j]=new Option(cont_uni_p.cartera[i].nombre , cont_uni_p.cartera[i].id);
                document.getElementById("list_fl_respval_2").options[j]=new Option(cont_uni_p.cartera[i].nombre , cont_uni_p.cartera[i].id);
                j++;
            }
            if(tipoProducto == '8'){
                document.getElementById("list_u_respval_1").options[j]=new Option(cont_uni_p.cartera[i].nombre , cont_uni_p.cartera[i].id);
                document.getElementById("list_u_respval_2").options[j]=new Option(cont_uni_p.cartera[i].nombre , cont_uni_p.cartera[i].id);
                j++;
            }
        }

        switch (tipoProducto) {
            case "1": //Leasing
                document.getElementById("list_l_respval_1").options[j]=new Option('','');
                document.getElementById("list_l_respval_2").options[j]=new Option('','');
                document.getElementById("list_l_respval_1").value =""
                document.getElementById("list_l_respval_2").value =""
                break;
            case "4": //Factoraje
                document.getElementById("list_f_respval_1").options[j]=new Option('','');
                document.getElementById("list_f_respval_2").options[j]=new Option('','');
                document.getElementById("list_f_respval_1").value =""
                document.getElementById("list_f_respval_2").value =""
                break;
            case "3": //Credito-auto
                document.getElementById("list_ca_respval_1").options[j]=new Option('','');
                document.getElementById("list_ca_respval_2").options[j]=new Option('','');
                document.getElementById("list_ca_respval_1").value =""
                document.getElementById("list_ca_respval_2").value =""
                break;
            case "6": //Fleet
                document.getElementById("list_fl_respval_1").options[j]=new Option('','');
                document.getElementById("list_fl_respval_2").options[j]=new Option('','');
                document.getElementById("list_fl_respval_1").value =""
                document.getElementById("list_fl_respval_2").value =""
                break;
            case "8": //Uniclick
                document.getElementById("list_u_respval_1").options[j]=new Option('','');
                document.getElementById("list_u_respval_2").options[j]=new Option('','');
                document.getElementById("list_u_respval_1").value =""
                document.getElementById("list_u_respval_2").value =""
                break;
        }
    },

    carga_usuarios_resp_validacion:function (){
        cont_uni_p.directoresLeasing1 = '';
        cont_uni_p.directoresFactoraje1 = '';
        cont_uni_p.directoresCredAuto1 = '';
        cont_uni_p.directoresFleet1 = '';
        cont_uni_p.directoresUniclick1 = '';

        cont_uni_p.directoresLeasing2 = '<option value="0" selected> </option>';
        cont_uni_p.directoresFactoraje2 = '<option value="0" > </option>';
        cont_uni_p.directoresCredAuto2 = '<option value="0" > </option>';
        cont_uni_p.directoresFleet2 = '<option value="0" > </option>';
        cont_uni_p.directoresUniclick2 = '<option value="0" > </option>';

        var filter_arguments =
        {
            max_num: -1,
            "fields": [
                "id_c",
                "nombre_completo_c",
                "puestousuario_c",
                "tipodeproducto_c",
                "posicion_operativa_c"
            ],
        };
        filter_arguments["filter"] = [
            {
                "posicion_operativa_c": {
                    "$contains": "1"
                },
                "equipos_c": {
                    "$contains": App.user.attributes.equipo_c
                },
                "status": "Active",
            }
        ];

        var a=0;
        var b=0;
        var c=0;
        var d=0;
        var e=0;
        
            app.api.call("read", app.api.buildURL("Users", null, null, filter_arguments), null, {
                success: _.bind(function (data) {
                    cont_uni_p.directorEquipo = data.records;
                    /*for(var i=0; i< data.records.length ; i++) {
                        if(data.records[i].tipodeproducto_c == '1'){
                            if(cont_uni_p.ResumenProductos.leasing.user_id1_c ==  data.records[i].id || a == 0){
                                cont_uni_p.directoresLeasing1 += '<option value="' + data.records[i].id + '" selected>' + data.records[i].nombre_completo_c + '</option>';
                                a++;
                            }else{
                                cont_uni_p.directoresLeasing1 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                                a++;
                            }
                            if(cont_uni_p.ResumenProductos.leasing.user_id2_c ==  data.records[i].id){
                                cont_uni_p.directoresLeasing2 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                            }else{
                                cont_uni_p.directoresLeasing2 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                            }
                        }
                        if(data.records[i].tipodeproducto_c == '4'){
                            if(cont_uni_p.ResumenProductos.factoring.user_id1_c ==  data.records[i].id || b == 0){
                                cont_uni_p.directoresFactoraje1 += '<option value="' + data.records[i].id + '" selected>' + data.records[i].nombre_completo_c + '</option>';
                                b++;
                            }else{
                                cont_uni_p.directoresFactoraje1 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                                b++;
                            }
                            if(cont_uni_p.ResumenProductos.factoring.user_id2_c ==  data.records[i].id){
                                cont_uni_p.directoresFactoraje2 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                            }else{
                                cont_uni_p.directoresFactoraje2 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                            }
                        }
                        if(data.records[i].tipodeproducto_c == '3'){
                            if(cont_uni_p.ResumenProductos.credito_auto.user_id1_c ==  data.records[i].id || c == 0){
                                cont_uni_p.directoresCredAuto1 += '<option value="' + data.records[i].id + '" selected>' + data.records[i].nombre_completo_c + '</option>';
                                c++;
                            }else{
                                cont_uni_p.directoresCredAuto1 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                                c++;
                            }
                            if(cont_uni_p.ResumenProductos.credito_auto.user_id2_c ==  data.records[i].id){
                                cont_uni_p.directoresCredAuto2 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                            }else{
                                cont_uni_p.directoresCredAuto2 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                            }
                        }
                        if(data.records[i].tipodeproducto_c == '6'){
                            if(cont_uni_p.ResumenProductos.fleet.user_id1_c ==  data.records[i].id || d == 0){
                                cont_uni_p.directoresFleet1 += '<option value="' + data.records[i].id + '" selected>' + data.records[i].nombre_completo_c + '</option>';
                                d++;
                            }else{
                                cont_uni_p.directoresFleet1 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                                d++;
                            }
                            if(cont_uni_p.ResumenProductos.fleet.user_id2_c ==  data.records[i].id){
                                cont_uni_p.directoresFleet2 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                            }else{
                                cont_uni_p.directoresFleet2 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                            }
                        }
                        if(data.records[i].tipodeproducto_c == '8'){
                            if(cont_uni_p.ResumenProductos.uniclick.user_id1_c ==  data.records[i].id || e == 0){
                                cont_uni_p.directoresUniclick1 += '<option value="' + data.records[i].id + '" selected>' + data.records[i].nombre_completo_c + '</option>';
                                e++;
                            }else{
                                cont_uni_p.directoresUniclick1 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                                e++;
                            }
                            if(cont_uni_p.ResumenProductos.uniclick.user_id2_c ==  data.records[i].id){
                                cont_uni_p.directoresUniclick2 += '<option value="' + data.records[i].id + '" selected>' + data.records[i].nombre_completo_c + '</option>';
                            }else{
                                cont_uni_p.directoresUniclick2 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                            }
                        }
                    }
                    */
                }, this)
            });
        
    },

    busca_bloquea:function (bestatus , brazon , bmotivo ){
        var salida=false;
        for(var i=0; i< cont_uni_p.datacondiciones.records.length ; i++) {

            if((cont_uni_p.datacondiciones.records[i].condicion == bestatus) && (cont_uni_p.datacondiciones.records[i].razon == brazon)
            && (cont_uni_p.datacondiciones.records[i].motivo == bmotivo) && (cont_uni_p.datacondiciones.records[i].bloquea =="1")){
                salida = true;
            }
        }
        return salida;
    },

    carga_usuarios_DirectorRegional:function (){
        cont_uni_p.directoresLeasing21 = '';
        cont_uni_p.directoresFactoraje21 = '';
        cont_uni_p.directoresCredAuto21 = '';
        cont_uni_p.directoresFleet21 = '';
        cont_uni_p.directoresUniclick21 = '';

        var filter_arguments =
        {
            max_num: -1,
            "fields": [
                "id_c",
                "nombre_completo_c",
                "puestousuario_c",
                "tipodeproducto_c",
                "posicion_operativa_c"
            ],
        };
        filter_arguments["filter"] = [
            {
                "posicion_operativa_c": {
                    "$contains": "2"
                },
                "equipos_c": {
                    "$contains": App.user.attributes.equipo_c
                },
                "status": "Active",
            }
        ];

        var a=0;
        var b=0;
        var c=0;
        var d=0;
        var e=0;

       
          app.api.call("read", app.api.buildURL("Users", null, null, filter_arguments), null, {
            success: _.bind(function (data) {
                cont_uni_p.directorRegion = data.records;
                /*for(var i=0; i< data.records.length ; i++) {
                    if(data.records[i].tipodeproducto_c == '1'){
                        if(cont_uni_p.ResumenProductos.leasing.user_id1_c ==  data.records[i].id || a == 0){
                            cont_uni_p.directoresLeasing21 += '<option value="' + data.records[i].id + '" selected>' + data.records[i].nombre_completo_c + '</option>';
                            a++;
                        }else{
                            cont_uni_p.directoresLeasing21 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                            a++;
                        }
                    }
                    if(data.records[i].tipodeproducto_c == '4'){
                        if(cont_uni_p.ResumenProductos.factoring.user_id1_c ==  data.records[i].id || b == 0){
                            cont_uni_p.directoresFactoraje21 += '<option value="' + data.records[i].id + '" selected>' + data.records[i].nombre_completo_c + '</option>';
                            b++;
                        }else{
                            cont_uni_p.directoresFactoraje21 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                            b++;
                        }
                    }
                    if(data.records[i].tipodeproducto_c == '3'){
                        if(cont_uni_p.ResumenProductos.credito_auto.user_id1_c ==  data.records[i].id || c == 0){
                            cont_uni_p.directoresCredAuto21 += '<option value="' + data.records[i].id + '" selected>' + data.records[i].nombre_completo_c + '</option>';
                            c++;
                        }else{
                            cont_uni_p.directoresCredAuto21 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                            c++;
                        }
                    }
                    if(data.records[i].tipodeproducto_c == '6'){
                        if(cont_uni_p.ResumenProductos.fleet.user_id1_c ==  data.records[i].id || d == 0){
                            cont_uni_p.directoresFleet21 += '<option value="' + data.records[i].id + '" selected>' + data.records[i].nombre_completo_c + '</option>';
                            d++;
                        }else{
                            cont_uni_p.directoresFleet21 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                            d++;
                        }
                    }
                    if(data.records[i].tipodeproducto_c == '8'){
                        if(cont_uni_p.ResumenProductos.uniclick.user_id1_c ==  data.records[i].id || e == 0){
                            cont_uni_p.directoresUniclick21 += '<option value="' + data.records[i].id + '" selected>' + data.records[i].nombre_completo_c + '</option>';
                            e++;
                        }else{
                            cont_uni_p.directoresUniclick21 += '<option value="' + data.records[i].id + '" >' + data.records[i].nombre_completo_c + '</option>';
                            e++;
                        }
                    }
                }
                */
            }, this)
         });
        
    },

    carga_usuarios_Cartera:function (){
        cont_uni_p.directoresCartera = '';
        var equipo = 'cartera';

        var a=0;
        app.api.call('GET', app.api.buildURL('GetUsuariosEquipo/'+ equipo), null, {
            success: function (data) {
                cont_uni_p.cartera = data.records;
                 /*for(var i=0; i< cont_uni_p.cartera.length ; i++) {
                   if( a == 0){
                        cont_uni_p.directoresCartera += '<option value="' + cont_uni_p.cartera[i].id + '" selected>' + cont_uni_p.cartera[i].nombre + '</option>';
                        a++;
                    }else{
                        cont_uni_p.directoresCartera += '<option value="' + cont_uni_p.cartera[i].id + '" >' + cont_uni_p.cartera[i].nombre + '</option>';
                        a++;
                    }
                }*/
            },
            error: function (e) {
                throw e;
            }
        });
    },

})