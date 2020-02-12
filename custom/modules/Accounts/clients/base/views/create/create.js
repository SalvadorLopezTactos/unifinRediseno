/**
 * Created by Jorge on 6/16/2015.
 */
({
    extendsFrom: 'CreateView',
    /**
     * @author bdekoning@levementum.com
     * @date 6/9/15
     * @brief Override for handleCancel to ensure the account_telefonos attribute is properly reverted
     *
     * @override
     */

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
        };//funcion para posicionar cursor

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
                console.log('no se cumplen enteros')
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
                console.log('no se cumplen dec')
                return "false";
            } else {
                return "true";
            }
        }
    },

    _render: function (fields, errors, callback) {
        this._super("_render");

        $('div[data-name=accounts_tct_pld]').find('div.record-label').addClass('hide');
        $('[data-name=tct_nuevo_pld_c]').hide(); //Oculta campo tct_nuevo_pld_c
        //Oculta nombre de campo accounts_telefonosV2
        $("div.record-label[data-name='account_telefonos']").attr('style', 'display:none;');

       //Oculta campo Lead no viable en la creacion de cuentas
        $('[data-name="tct_noviable"]').hide();

        //campo Pais que expide el RFC nace oculto.
        // $('[data-name=tct_pais_expide_rfc_c]').hide();
        //Oculta panel del campo Tipo de Cuenta por Producto
        this.$("[data-panelname='LBL_RECORDVIEW_PANEL17']").hide();
        //Oculta nombre de campo Potencial_Autos
        $("div.record-label[data-name='potencial_autos']").attr('style', 'display:none;');
        /*
         * @author Salvador Lopez
         * Ocultar panel de fideicomiso y ocultar paneles de Peps para Persona Moral
         * (Se asume que valor por default para tipo de persona es "Persona F�sica")
         * */
        this.$("li.tab.LBL_RECORDVIEW_PANEL2").hide();

        //Oculta Peps de Persona Moral
        this.$("[data-panelname='LBL_RECORDVIEW_PANEL7']").hide();
        this.$("[data-panelname='LBL_RECORDVIEW_PANEL6']").hide();
        this.$("[data-panelname='LBL_RECORDVIEW_PANEL9']").hide();
        //Se oculta check de cuenta homonima
        $('div[data-name=tct_homonimo_chk_c]').hide();

        //Ocultar Div "Prospecto Contactado"
        $('div[data-name=tct_prospecto_contactado_chk_c]').hide();

        /* @author F. Javier Garcia S. 10/07/2018
         Agregar dependencia al panel NPS, para ser visible si "Tipo de Cuenta" es "Cliente".
         */
        this.$("[data-panelname='LBL_RECORDVIEW_PANEL10']").hide();


        /*
         AF: 11/01/18
         Merge create-create-actions.js
         */
        /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 8/26/2015 Description: When Pais or Profesion field is changed, Recalculate the Riesgo */
        this._doValidateProfesionRisk();
        /* END CUSTOMIZATION */

        /*
         * @author Carlos Zaragoza ortiz
         * Ocultar campo de estatus Activo/Inactivo en creaci�n de personas
         * */
        this.$('div[data-name=estatus_persona_c]').hide();

        if (this.model.dataFetched) {
            this.model.on("change:tipo_registro_c", _.bind(function () {
                // Carlos Zaragoza: Se elimina el campo por defaiult de tipo de proveedor del registro pero sies proveedor, se selecciona bienes por default
                // if(this.model.get('tipo_registro_c') == 'Proveedor'){
                //     this.model.set('tipo_proveedor_c', '1');
                // }
                app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("id") + "/link/rel_relaciones_accounts_1", null, null, {
                    fields: name,
                }), null, {
                    success: _.bind(function (data) {

                        if (data.records.length > 0) {
                            var ContacFlag = false;
                            $(data.records).each(function (index, value) {

                                if ($.inArray("Contacto", value.relaciones_activas) > -1) {
                                    //YES IS A CONTACT!!!!
                                    ContacFlag = true;
                                }
                            });
                            if (this.model._syncedAttributes.tipo_registro_c != 'Cliente') {
                                if (ContacFlag == false) {
                                    app.alert.show("Validar Relacion", {
                                        level: "error",
                                        title: "Debe capturar al menos un contacto.",
                                        autoClose: false
                                    });

                                    this.model.set('tipo_registro_c', 'Prospecto');
                                    errors['account_contacts'] = errors['account_contacts'] || {};
                                }
                            }
                        }
                        if (data.records.length <= 0) {
                            if (this.model._syncedAttributes.tipo_registro_c != 'Cliente') {

                                app.alert.show("Validar Relacion", {
                                    level: "error",
                                    title: "Debe capturar al menos un contacto.",
                                    autoClose: false
                                });
                                this.model.set('tipo_registro_c', 'Prospecto');
                                errors['account_contacts'] = errors['account_contacts'] || {};
                            }
                        }
                    }, this)
                });
            }, this));

            /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 6/12/2015 Description: Check for an existing RFC*/
            var fields = ["primernombre_c", "segundonombre_c", "apellidopaterno_c", "apellidomaterno_c", 'rfc_c'];
            this.model.on("change:rfc_c", _.bind(function () {
                var RFC = this.model.get('rfc_c');
                app.api.call("read", app.api.buildURL("Accounts/", null, null, {
                    fields: fields.join(','),
                    max_num: 5,
                    "filter": [
                        {
                            "rfc_c": RFC,
                            "id": {
                                $not_equals: this.model.id,
                            }
                        }
                    ]
                }), null, {
                    success: _.bind(function (data) {
                        if (data.records.length > 0) {

                            app.alert.show("DuplicateCheck", {
                                level: "error",
                                title: "El RFC ingresado ya Existe.",
                                autoClose: false
                            });

                            this.model.set("rfc_c", '');
                        }

                    }, this)
                });
            }, this));

            console.log($('.existingAddress').val());
        }

        //Hide Vista360
        this._hideVista360();
        //this.model.set("tipo_registro_c", 'Cliente');
        //this.model.set("tipo_registro_c", 'Prospecto');
        //callback(null, fields, errors);

        /* @author F. Javier Garcia S. 10/07/2018
         "El tipo de cuenta ""Proveedor"" s�lo podr� ser seleccionado por los roles
         de Compras y el BackOffice de CA"
         */
        if (App.user.attributes.tct_altaproveedor_chk_c) {

            this.model.set("tipo_registro_c", 'Proveedor');
        }
        if (App.user.attributes.tct_alta_clientes_chk_c) {

            this.model.set("tipo_registro_c", 'Cliente');
        }
		
        //VM 14/09/2018
        this.checkProveedor();

        this.mostrarpaneldirec();
		
		if (App.user.attributes.deudor_factoraje_c != true) {
			//Readonly check factoraje
			this.$('[data-name="deudor_factor_c"]').attr('style', 'pointer-events:none;');
        }

    },

    initialize: function (options) {
        self = this;
        contexto_cuenta = this;
        this._super("initialize", [options]);
        //Funcion que quita los años futuros y menores a -5 del año actual
        this.quitaanos();
        this.model.on("change:tct_ano_ventas_ddw_c", _.bind(this.quitaanos, this));
        /*
          Contexto campos custom
        */
        //Teléfonos
        this.oTelefonos = [];
        this.oTelefonos.telefono = [];
        this.prev_oTelefonos=[];
        this.prev_oTelefonos.prev_telefono=[];
        //Direcciones
        this.oDirecciones = [];
        this.oDirecciones.direccion = [];
        this.prev_oDirecciones=[];
        this.prev_oDirecciones.prev_direccion=[];
        //v360
        this.ResumenCliente = [];
        //PLD
        this.ProductosPLD = [];
        this.prev_ProductosPLD=[];
        //Potencial Autos
        this.Pautos=[];

        //Hide panels
        this.model.on('change:tct_fedeicomiso_chk_c', this._hideFideicomiso, this);
        this.model.on('change:tipodepersona_c', this._hidePeps, this);
        this.model.on("change:tipo_registro_c", this._hideGuardar, this);

        //add validation tasks
        this.model.addValidationTask('checkaccdatestatements', _.bind(this.checkaccdatestatements, this));
        this.model.addValidationTask('check_email_telefono', _.bind(this._doValidateEmailTelefono, this));
        //@Jesus Carrillo
        this.model.addValidationTask('check_telefonos', _.bind(this.validatelefonosexisting, this));
        this.model.addValidationTask('check_direcciones', _.bind(this.validadireccexisting, this));
        this.model.addValidationTask('check_rfc', _.bind(this._doValidateRFC, this));
        this.model.on('change:pais_nacimiento_c', this.validaExtranjerosRFC, this);
        //this.model.on('change:rfc_c',this.validaFechaNacimientoDesdeRFC, this);
        this.model.on('change:account_telefonos', this.setPhoneOffice, this);

        //Se mete expresion regular para limitar el funcionamiento del campo email .
        //Adrian Arauz 12-/09/2018
        this.model.addValidationTask('change:email', _.bind(this.expmail, this));

        //Valida que el campo Alta Cedente este check en el perfil del usuario. Adrian Arauz 20/09/2018
        this.model.addValidationTask('check_alta_cedente', _.bind(this.validacedente, this));

        //campo Pais que expide el RFC nace oculto.
        // $('[data-name=tct_pais_expide_rfc_c]').hide();
        /*
         AF: 11/01/18
         Merge create-create-actions.js
         */
        //add validation tasks
        this.model.addValidationTask('check_fecha_de_nacimiento', _.bind(this._doValidateMayoriadeEdad, this));
        this.model.addValidationTask('check_account_direcciones', _.bind(this._doValidateDireccion, this));
        //this.model.addValidationTask('check_Tiene_Contactos', _.bind(this._doValidateTieneContactos, this));
        this.model.addValidationTask('check_1900_year', _.bind(this.fechaMenor1900, this));
        this.model.addValidationTask('fechadenacimiento_c', _.bind(this.doValidateDateNac, this));
        this.model.addValidationTask('fechaconstitutiva_c', _.bind(this.doValidateDateCons, this));
        this.model.addValidationTask('check_info', _.bind(this.doValidateInfoReq, this));
        //this.model.addValidationTask('tipo_proveedor', _.bind(this.tipoProveedor_check,this));
        //this.model.addValidationTask('check_formato_curp_c', _.bind(this.ValidaFormatoCURP, this));
        this.model.addValidationTask('camposnumericosPLDFF',_.bind(this.validacantidades, this));


        /* F. Javier G. Solar
                OBS299 Validar que las Direcciones no se repitan 21/11/2018
             */

        this.model.addValidationTask('validate_Direccion_Duplicada', _.bind(this._direccionDuplicada, this));

        /**
         * @author Carlos Zaragoza Ortiz
         * @date 16-10-2015
         * UNIFIN TASK: Modificar el riesgo en caso de seleccionar "PEP" en cuestionario de PLD
         * */
        this.model.addValidationTask('verificaRiesgoPep', _.bind(this.cambiaRiesgodePersona, this));
        /**
         * @author Carlos Zaragoza Ortiz
         * @date 16-10-2015
         * UNIFIN TASK: Al ser proveedor debe solicitar como obligatorio el tipo de proveedor
         * */
        this.model.addValidationTask('tipo_proveedor_requerido', _.bind(this.validaProveedorRequerido, this));
        /* END */
        this.model.on('change:subtipo_cuenta_c', this.cambiaCliente, this);
        //this.model.on('change:tipo_registro_c', this._ShowDireccionesTipoRegistro, this);
        //this.model.on('change:estatus_c', this._ShowDireccionesTipoRegistro, this);
        this.model.on('change:tipodepersona_c', this._ActualizaEtiquetas, this);
        this.model.on('change:origendelprospecto_c', this.changeLabelMarketing, this);

        //this.model.on('change:fechadenacimiento_c', this._doGenera_RFC_CURP, this);
        //this.model.on('change:fechaconstitutiva_c', this._doGenera_RFC_CURP, this);
        //this.model.on('change:razonsocial_c', this._doGenera_RFC_CURP, this);
        //this.model.on('change:primernombre_c', this._doGenera_RFC_CURP, this);
        //this.model.on('change:apellidopaterno_c', this._doGenera_RFC_CURP, this);
        //this.model.on('change:apellidomaterno_c', this._doGenera_RFC_CURP, this);

        //this.model.on('change:genero_c', this._doGeneraCURP, this);
        //this.model.on('change:pais_nacimiento_c', this._doGeneraCURP, this);
        //this.model.on('change:estado_nacimiento_c', this._doGeneraCURP, this);
        this.model.addValidationTask('valida_potencial_campos_autos',_.bind(this.nodigitos, this));


        this.model.addValidationTask('valida_potencial',_.bind(this.validapotencial, this));

        this.model.addValidationTask('valida_requeridos',_.bind(this.valida_requeridos, this));


        /*Validacion de campos requeridos en el cuestionario PLD y sus productos
        * Adrian Arauz 23/01/2019
        * */
        //this.model.addValidationTask('RequeridosPLD', _.bind(this.validaRequeridosPLD, this));
        this.model.addValidationTask('guardaProductosPLD', _.bind(this.saveProdPLD, this));
        this.model.addValidationTask('validarequeridosProvRec',_.bind(this.RequeridosProveedorRecursos, this));
        /*Funcion para validar los campos ventas anuales y activo fijo al editar una cuenta de tipo
        * Integración de Expediente
        * Adrian Arauz 4/10/2018
        * */
        //Validacion para el formato de los campos nombre y apellidos.
        this.model.addValidationTask('validaformato3campos',_.bind(this.validaformato,this));
        this.model.addValidationTask('validacamposcurppass',_.bind(this.validapasscurp,this));
        this.model.addValidationTask('porcentajeIVA',_.bind(this.validaiva, this));

        this.model.on('change:profesion_c', this._doValidateProfesionRisk, this);
        this.model.on('change:pais_nacimiento_c', this._doValidateProfesionRisk, this);
        //this.model.on('change:pais_nacimiento_c',this.validaExtranjerosRFC, this);

        //this.model.on('change:rfc_c',this.validaFechaNacimientoDesdeRFC, this);

        /*
         AF - 26/12/17
         Ajuste: Ocultar campo dependiente de multiselect "�Instrumento monetario con el que espera realizar los pagos?"
         */
        this.model.on('change:tct_inst_monetario_c', this.changeInstMonetario, this);
        /*
       AA 24/06/2019 Se añade evento para desabilitar el boton genera RFC si la nacionalidad es diferente de Mexicano
     */
        this.model.on('change:tct_pais_expide_rfc_c',this.ocultaRFC, this);

        this.model.on('change:primernombre_c',this.checkTextOnly, this);
        this.model.on('change:apellidomaterno_c',this.checkTextOnly,this);
        this.model.on('change:apellidopaterno_c',this.checkTextOnly,this);

        this.events['keydown input[name=rfc_c]'] = 'checkTextAndNumRFC';
        this.model.on('change:ifepasaporte_c',this.checkTextAndNum,this);
        this.model.on('change:curp_c',this.checkTextAndNum,this);

        this.events['click a[name=generar_rfc_c]'] = '_doGenera_RFC_CURP';
        this.events['click a[name=generar_curp_c]'] = '_doGeneraCURP';
        this.events['keydown [name=ctpldnoseriefiel_c]'] = 'keyDownNewExtension';
        this.events['keydown [name=tct_cpld_pregunta_u2_txf_c]'] = 'keyDownNewExtension';
        this.events['keydown [name=tct_cpld_pregunta_u4_txf_c]'] = 'keyDownNewExtension';
        //this.events['keydown [name=ctpldnoseriefiel_c]'] = 'checkInVentas';
        this.events['keydown [name=tct_cpld_pregunta_u2_txf_c]'] = 'checkInVentas';
        this.events['keydown [name=tct_cpld_pregunta_u4_txf_c]'] = 'checkInVentas';
        //Funcion para validar que no hayan direcciones repetidas al momento de darle en el check
        this.promotores_default();


        /* hay que traer el campo del usaurio
         * PROMOTORES POR DEFAULT
         LEASING:
         9 - Sin Gestor
         SinGestor
         569246c7-da62-4664-ef2a-5628f649537e
         CREDIT:
         ADRIANA GAYOSSO CRUZ
         agayosso
         7a83c151-6fc3-dc2b-b3a0-562a60aa3b74
         FACTORAJE:
         //ANGEL TAMARIZ GALINDO
         //angel.tamariz
         //3f232cae-4ee1-c9b0-266d-562a600fa9d7
         Maria de Lourdes Campos Toca
         lcampos
         a04540fc-e608-56a7-ad47-562a6078519d
         */


        /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 7/14/2015 Description: Cuando estamos en el modulo de Personas, no queremos que se muestre la opcion Persona para el tipo de registro */
        var new_options = app.lang.getAppListStrings('tipo_registro_list');

        if (App.user.attributes.tct_alta_cd_chk_c != 1) {
            Object.keys(new_options).forEach(function (key) {
                if (key == "Persona") {
                    delete new_options[key];
                }
            });
        }


        //eliminar Lead
        /*
        var checkrol = 0;
        for (var i = 0; i < App.user.attributes.roles.length; i++) {
            if (App.user.attributes.roles[i] == "Planeacion y Estrategia Comercial") {
                checkrol++;
            }
        }
        Object.keys(new_options).forEach(function (key) {
            if (key == "Lead" && checkrol > 0) {
                delete new_options[key];
            }
        });
        */
        //fin

        /* @author: Salvador Lopez
        * Se establecen opciones dependiendo los valores de Alta Proveedor y Alta Cliente del usuario firmado
        *
        * */

        //Establecer únicamente las opciones de Cliente y Proveedor cuando el usuario tenga las dos casillas seleccionadas
        if (App.user.attributes.tct_alta_clientes_chk_c == 1 && App.user.attributes.tct_altaproveedor_chk_c == 1 ) {
            Object.keys(new_options).forEach(function (key) {
                if (key != "Cliente" && key != "Proveedor") {
                    delete new_options[key];
                }
            });
        }else if(App.user.attributes.tct_alta_clientes_chk_c == 1) {

            Object.keys(new_options).forEach(function (key) {
                if (key != "Cliente") {
                    delete new_options[key];
                }
            });
        }else if(App.user.attributes.tct_altaproveedor_chk_c==1) {
            Object.keys(new_options).forEach(function (key) {
                if (key != "Proveedor") {
                    delete new_options[key];
                }
            });
        }
        //En otro caso, solo mostrar Lead
        else{
            Object.keys(new_options).forEach(function (key) {
                if (key != "Lead") {
                    delete new_options[key];
                }
            });
        }
        if (App.user.attributes.tct_alta_cd_chk_c == true || App.user.attributes.deudor_factoraje_c == true){
            new_options["Persona"]="Persona";
        }
        //Itera el valor del campo nuevo y de ser asi solo deja la opcion de Cliente disponible.
        /*if(App.user.attributes.tct_alta_credito_simple_chk_c == 1) {
             Object.keys(new_options).forEach(function (key) {
                 if (key != "Cliente") {
                     delete new_options[key];
                 }
             });
            new_options["Cliente"]="Cliente";
        }*/

        this.model.fields['tipo_registro_c'].options = new_options;

        this.model.on('change:name', this.cleanName, this);
        /*
         //Ocultar Div "Prospecto Contactado"
         this.$('div[data-name=tct_prospecto_contactado_chk_c]').hide();
         */


        this.events['keydown [name=ventas_anuales_c]'] = 'checkInVentas';
        this.events['keydown [name=activo_fijo_c]'] = 'checkInVentas';
        this.events['keydown [name=tct_prom_cheques_cur_c]'] = 'checkInVentas';
        this.events['keydown [name=tct_depositos_promedio_c]'] = 'checkInVentas';
        //this.events['keydown [name=ctpldnoseriefiel_c]'] = 'checkInVentas';
        this.model.addValidationTask('set_custom_fields', _.bind(this.setCustomFields, this));
        this.model.addValidationTask('Guarda_campos_auto_potencial', _.bind(this.savepotauto, this));

    },

    /** BEGIN CUSTOMIZATION:
     * Salvador Lopez 19/01/2018
     * Descripci�n: Funci�n que oculta o muestra panel de fideicomiso dependiendo el valor de check �Es Fideicomisio? */

    _hideFideicomiso: function (fields, errors, callback) {
        if (this.model.get('tct_fedeicomiso_chk_c')) {
            //Muestra

            this.$("li.tab.LBL_RECORDVIEW_PANEL2").show();

        } else {
            //Oculta
            this.$("li.tab.LBL_RECORDVIEW_PANEL2").hide();
        }
    },


    /* F. Javier G. Solar
      OBS299 Validar que las Direcciones no se repitan 21/11/2018
   */
    _direccionDuplicada: function (fields, errors, callback) {

        /* SE VALIDA DIRECTAMENTE DE LOS ELEMENTOS DEL HTML POR LA COMPLEJIDAD DE
        OBETENER LAS DESDRIPCIONES DE LOS COMBOS*/

        var objDirecciones = $('.control-group.direccion')
        var concatDirecciones = [];
        var strDireccionTemp = "";
        for (var i = 0; i < objDirecciones.length-1; i++) {
            strDireccionTemp = objDirecciones.eq(i).find('.calleExisting').val() +
                objDirecciones.eq(i).find('.numExtExisting').val() +
                objDirecciones.eq(i).find('.numIntExisting').val() +
                objDirecciones.eq(i).find('select.coloniaExisting option:selected').text() +
                objDirecciones.eq(i).find('select.municipioExisting option:selected').text() +
                objDirecciones.eq(i).find('select.estadoExisting option:selected').text() +
                objDirecciones.eq(i).find('select.ciudadExisting option:selected').text() +
                objDirecciones.eq(i).find('.postalInputTempExisting').val();

            concatDirecciones.push(strDireccionTemp.replace(/\s/g, "").toUpperCase());

        }

        // validamos  el arreglo generado
        var existe = false;
        for (var j = 0; j < concatDirecciones.length; j++) {
            for (var k = j + 1; k < concatDirecciones.length; k++) {

                if (concatDirecciones[j] == concatDirecciones[k]) {
                    existe = true;
                }
            }

        }

        if(existe)
        {
            app.alert.show('Direcci\u00F3n', {
                level: 'error',
                autoClose: false,
                messages: 'Existe una o mas direcciones repetidas'
            });
            var messages1= 'Existe una o mas direcciones repetidas';
            errors['xd'] = errors['xd'] || {};
            // errors['xd'].messages1 = true;
            errors['xd'].required = true;
        }

        callback(null, fields, errors);
    },

    /** BEGIN CUSTOMIZATION:
     * Salvador Lopez 19/01/2018
     * Descripci�n: Funci�n que oculta o muestra paneles de Peps seg�n sea el valor de Tipo de Persona*/

    _hideVista360: function () {

        //TabNav
        $("#drawers li.tab").removeClass('active');
        $('#drawers li.tab.panel_body').addClass("active");
        $('#drawers li.tab.LBL_RECORDVIEW_PANEL8').hide();

        //Tabcontent
        $("#drawers div.tab-content").children()[0].classList.remove('active');
        $("#drawers div.tab-content").children()[1].classList.add('active');
        $("#drawers div.tab-content").children()[1].classList.remove('fade');

        //Oculta campo Muestra panel
        $("div[data-name='show_panel_c']").hide();
        // Se oculta el boton de mas opciones en las petañas de cuentas(record)
        $('.nav-tabs li a.dropdown-toggle').hide();
    },

    _hidePeps: function (fields, errors, callback) {

        if (this.model.get('tipodepersona_c') == "Persona Fisica" ||
            this.model.get('tipodepersona_c') == "Persona Fisica con Actividad Empresarial") {
            //Muestra Peps de Persona F�sica
            this.$("[data-panelname='LBL_RECORDVIEW_PANEL4']").show();
            this.$("[data-panelname='LBL_RECORDVIEW_PANEL5']").show();
            //Oculta Peps de Persona Moral
            this.$("[data-panelname='LBL_RECORDVIEW_PANEL7']").hide();
            this.$("[data-panelname='LBL_RECORDVIEW_PANEL6']").hide();
            //Oculta Propietario Real
            this.$("[data-panelname='LBL_RECORDVIEW_PANEL9']").hide();

        } else {
            //Oculta Peps de Persona F�sica
            this.$("[data-panelname='LBL_RECORDVIEW_PANEL4']").hide();
            this.$("[data-panelname='LBL_RECORDVIEW_PANEL5']").hide();
            //Muestra Peps de Persona Moral
            this.$("[data-panelname='LBL_RECORDVIEW_PANEL7']").show();
            this.$("[data-panelname='LBL_RECORDVIEW_PANEL6']").show();
            //Muestra Propietario Real
            if (this.model.get('tipo_registro_c') == "Cliente") {
                this.$("[data-panelname='LBL_RECORDVIEW_PANEL9']").show();
            }
        }
    },

    _hideGuardar: function (fields, errors, callback) {
        var tipo = this.model.get('tipo_registro_c');
        var puesto = app.user.get('puestousuario_c');
        if ((tipo == "Prospecto" || tipo == "Cliente" || tipo == "Lead") && (puesto == 6 || puesto == 12 || puesto == 17)) {
            this.$('[name="save_button"]').hide();
        }
        else {
            this.$('[name="save_button"]').show();
        }
    },

    _doValidateEmailTelefono: function (fields, errors, callback) {
        if (this.model.get('tipo_registro_c') !== 'Persona' || this.model.get('tipo_registro_c') !== 'Proveedor') {
            if (_.isEmpty(this.model.get('email')) && _.isEmpty(this.oTelefonos.telefono) ) {
                app.alert.show("Correo requerido", {
                    level: "error",
                    title: "Al menos un correo electr\u00F3nico o un tel\u00E9fono es requerido.",
                    autoClose: false
                });
                errors['email'] = errors['email'] || {};
                errors['email'].required = true;
                $('#tabletelefonos').css('border', '2px solid red');
                errors['account_telefonos1'] = errors['account_telefonos1'] || {};
                errors['account_telefonos1'].required = true;
            }
        }
        callback(null, fields, errors);
    },
    /*Victor Martinez Lopez 12-09-2018
    *La casilla proveedor se debe mantener activa al crear un proveedor
    * */
    checkProveedor:function(){
        if(this.model.get('tipo_registro_c')=='Proveedor'){
            this.$('[data-name="esproveedor_c"]').attr('style', 'pointer-events:none;');
        }
    },
    //funcion que muestra siempre el panel de direcciones a la hora de crear una cuenta. Adrian Arauz 28/09/2018.
    mostrarpaneldirec: function () {
        $('.record-panel[data-panelname="LBL_RECORDVIEW_PANEL15"]').children().eq(0).removeClass('panel-inactive');
        $('.record-panel[data-panelname="LBL_RECORDVIEW_PANEL15"]').children().eq(0).addClass('panel-active');
        $('.record-panel[data-panelname="LBL_RECORDVIEW_PANEL15"]').children().eq(1).addClass('panel-active').removeClass('hide');

    },

    //@Jesus Carrillo
    validatelefonosexisting: function (fields, errors, callback) {
        var msjError = "";
        var msjErrorT = "";
        var telefono=this.oTelefonos.telefono;
        for (iTelefono=0; iTelefono < telefono.length; iTelefono++) {
            //Valida valor
            valor4 = telefono[iTelefono].telefono.trim();
            if(valor4 == ""){
                msjError += '<br>-Teléfono vacío';
            }else{
                //Valida númerico
                var valNumerico = /^\d+$/;
                if (!valNumerico.test(valor4)) {
                    msjError += '<br>-Solo números son permitidos';
                }
                //Valida longitud
                if (valor4.length<8) {
                    msjError += '<br>-Debe contener 8 o más dígitos';
                }
                //Valida números repetidos
                if(valor4.length > 1){
                    var repetido = true;
                    for (var iValor4 = 0; iValor4 < valor4.length; iValor4++) {
                      repetido = (valor4[0] != valor4[iValor4]) ? false : repetido;
                    }
                    if (repetido) {
                        msjError += '<br>-Caracter repetido';
                    }
                }
            }
            // Agerga teléfono a mensaje de error
            if(msjError != ""){
                msjErrorT += '<br><b>'+ valor4+'</b> :'+msjError+'<br>';
                $('.Telefonot').eq(iTelefono).css('border-color', 'red');
            }
            msjError = "";
        }
        //Muestra errores
        if(msjErrorT!= ""){
            app.alert.show('phone_save_error', {
                level: 'error',
                autoClose: false,
                messages: 'Formato de teléfono(s) incorrecto:'+ msjErrorT
            });
            //Agrega errores
            errors['Tel_Telefonos_numero'] = errors['Tel_Telefonos_numero'] || {};
            errors['Tel_Telefonos_numero'].required = true;
        }

        //Valida duplicados
        if(telefono.length>0){
            var coincidencia = 0;
            var indices=[];
            for (var i = 0; i < telefono.length; i++) {
                for (var j = 0; j < telefono.length; j++) {
                    if (telefono[j].telefono == telefono[i].telefono && i!=j) {
                        coincidencia++;
                        indices.push(i);
                        indices.push(j);
                    }
                }
            }
            //indices=indices.unique();
            if (coincidencia > 0) {
                    app.alert.show('error_sametelefono3', {
                        level: 'error',
                        autoClose: false,
                        messages: 'Existen n\u00FAmeros telef\u00F3nicos iguales,favor de corregir.'
                    });
                    //$($input).focus();
                    if(indices.length>0) {
                        for (var i = 0; i < indices.length; i++) {
                            $('.Telefonot').eq(indices[i]).css('border-color', 'red');
                        }
                    }
                    errors['Tel_Telefonos_duplicado'] = errors['Tel_Telefonos_duplicado'] || {};
                    errors['Tel_Telefonos_duplicado'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    validadireccexisting: function (fields, errors, callback) {
      //Campos requeridos
      var cont=0;
      var direccion = this.oDirecciones.direccion;
      for (iDireccion = 0; iDireccion < direccion.length; iDireccion++) {
          //Tipo
          if(direccion[iDireccion].tipodedireccion == ""){
              cont++;
              this.$('.multi_tipo_existing ul.select2-choices').eq(iDireccion).css('border-color', 'red');
          }else{
              this.$('.multi_tipo_existing ul.select2-choices').eq(iDireccion).css('border-color', '');
          }
          //Indicador
          if(direccion[iDireccion].indicador == ""){
              cont++;
              this.$('.multi1_n_existing ul.select2-choices').eq(iDireccion).css('border-color', 'red');
          }else{
              this.$('.multi1_n_existing ul.select2-choices').eq(iDireccion).css('border-color', '');
          }
          //Código Postal
          if(direccion[iDireccion].valCodigoPostal == ""){
              cont++;
              this.$('.postalInputTempExisting').eq(iDireccion).css('border-color', 'red');
          }else{
              this.$('.postalInputTempExisting').eq(iDireccion).css('border-color', '');
          }
          //Calle
          if(direccion[iDireccion].calle.trim() == ""){
              cont++;
              this.$('.calleExisting').eq(iDireccion).css('border-color', 'red');
          }else{
              this.$('.calleExisting').eq(iDireccion).css('border-color', '');
          }
          //Número Exterior
          if(direccion[iDireccion].numext.trim() == ""){
              cont++;
              this.$('.numExtExisting').eq(iDireccion).css('border-color', 'red');
          }else{
              this.$('.numExtExisting').eq(iDireccion).css('border-color', '');
          }
      }
      //Muestra error en direcciones existentes
      if(cont>0){
          app.alert.show("empty_fields_dire", {
              level: "error",
              messages: "Favor de llenar los campos se\u00F1alados en <b> Direcciones </b> .",
              autoClose: false
          });
          errors['dire_direccion_req'] = errors['dire_direccion_req'] || {};
          errors['dire_direccion_req'].required = true;

      }

      //Valida direcciones duplicadas
      if(direccion.length>0){
          var coincidencia = 0;
          var indices=[];
          for (var i = 0; i < direccion.length; i++) {
              for (var j = 0; j < direccion.length; j++) {
                  if (i!=j && direccion[j].calle.toLowerCase() + direccion[j].ciudad + direccion[j].colonia + direccion[j].estado + direccion[j].municipio + direccion[j].numext.toLowerCase() + direccion[j].pais + direccion[j].postal == direccion[i].calle.toLowerCase() + direccion[i].ciudad + direccion[i].colonia + direccion[i].estado + direccion[i].municipio + direccion[i].numext.toLowerCase() + direccion[i].pais + direccion[i].postal) {
                      coincidencia++;
                      indices.push(i);
                      indices.push(j);
                  }
              }
          }
          //indices=indices.unique();
          if (coincidencia > 0) {
                  app.alert.show('error_direccion_duplicada', {
                      level: 'error',
                      autoClose: false,
                      messages: 'Existen direcciones iguales,favor de corregir.'
                  });
                  //$($input).focus();
                  if(indices.length>0) {
                      for (var i = 0; i < indices.length; i++) {
                          $('.calleExisting').eq(indices[i]).css('border-color', 'red');
                          $('.numExtExisting').eq(indices[i]).css('border-color', 'red');
                          $('.postalInputTempExisting').eq(indices[i]).css('border-color', 'red');
                      }
                  }
                  errors['dire_direccion_duplicada'] = errors['dire_direccion_duplicada'] || {};
                  errors['dire_direccion_duplicada'].required = true;
          }
      }

      callback(null, fields, errors);
    },

    _doValidateRFC: function (fields, errors, callback) {
        if (this.model.get('rfc_c') && (this.model.get('rfc_c')!='XXXX010101XXX' && this.model.get('rfc_c')!='XXX010101XXX' && this.model.get('tct_pais_expide_rfc_c')=="2")) {
            var fields = ["primernombre_c", "segundonombre_c", "apellidopaterno_c", "apellidomaterno_c", 'rfc_c'];
            var RFC = this.model.get('rfc_c');
            app.api.call("read", app.api.buildURL("Accounts/", null, null, {
                fields: fields.join(','),
                max_num: 5,
                "filter": [
                    {
                        "rfc_c": RFC,
                        "id": {
                            $not_equals: this.model.id,
                        }
                    }
                ]
            }), null, {
                success: _.bind(function (data) {
                    if (data.records.length > 0) {

                        app.alert.show("DuplicateCheck", {
                            level: "error",
                            title: "El RFC ingresado ya Existe.",
                            autoClose: false
                        });

                        this.model.set("rfc_c", '');

                        errors['rfc_c'] = errors['rfc_c'] || {};
                        errors['rfc_c'].required = true;

                    }
//                callback(null, fields, errors);
                }, this)
            });
        }

        RFC = this.model.get('rfc_c');
        if (RFC != '' && RFC != null && (RFC != 'XXX010101XXX' && RFC != 'XXXX010101XXX' && this.model.get('tct_pais_expide_rfc_c')=="2")) {
            //étodo que tiene la función de validar el rfc
            RFC = RFC.toUpperCase().trim();
            var expReg = "";
            if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                expReg =  /^([A-Z\u00D1&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
            } else {
                expReg =  /^([A-ZÑ\u00D1&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
            }
            if (!RFC.match(expReg)) {
                app.alert.show("RFC incorrecto", {
                    level: "error",
                    title: "El RFC no tiene un formato correcto.",
                    autoClose: false
                });
                errors['rfc_c'] = errors['rfc_c'] || {};
                errors['rfc_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    validaExtranjerosRFC: function () {
        if ((this.model.get('pais_nacimiento_c') != 2 && this.model.get('pais_nacimiento_c') != "") && (this.model.get('tipo_registro_c') != 'Prospecto' && this.model.get('tipo_registro_c') != 'Persona')) {
            this.model.set('rfc_c', 'XXX010101XXX');
        }
        if (this.model.get('tipo_registro_c') == 'Prospecto' && this.model.get('estatus_c') == 'Interesado' && this.model.get('pais_nacimiento_c') != 2) {
            this.model.set('rfc_c', 'XXX010101XXX');
        }

//        callback(null, fields, errors);
    },

    validaFechaNacimientoDesdeRFC: function () {
        //this._doValidateRFC();
        var RFC = this.model.get('rfc_c');
        if (RFC != '' && RFC != null && RFC != 'XXX010101XXX') {
            console.log(this.model.get('rfc_c'));
            var expReg = "";
            var tipoControl = "";
            var fecha = "";
            if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                tipoControl = 'fechadenacimiento_c';
                expReg = "[A-Z&]{4}[0-9]{6}[A-Z0-9]{3}";
                fecha = new Date(RFC.substring(6, 8) + "-" + RFC.substring(8, 10) + "-" + RFC.substring(4, 6));
            } else {
                tipoControl = 'fechaconstitutiva_c';
                expReg = "[A-Z&]{3}[0-9]{6}[A-Z0-9]{3}";
                fecha = new Date(RFC.substring(5, 7) + "-" + RFC.substring(7, 9) + "-" + RFC.substring(3, 5));
            }
            if (!RFC.match(expReg)) {
                app.alert.show("RFC incorrecto", {
                    level: "error",
                    title: "El RFC no tiene un formato correcto para ser evaluado",
                    autoClose: true
                });
            } else {
                var fechaFormateada = fecha.getFullYear() + "-" + (fecha.getMonth() < 10 ? "0" + (fecha.getMonth() + 1) : fecha.getMonth() + 1) + "-" + (fecha.getDate() < 10 ? "0" + fecha.getDate() : fecha.getDate());
                this.model.set(tipoControl, fechaFormateada);
            }


        }
//        callback(null, fields, errors);
    },

    setButtonStates: function (state) {
        this._super("setButtonStates", [state]);
        var $saveButtonEl = this.buttons[this.saveButtonName];
        if ($saveButtonEl) {
            switch (state) {
                case this.STATE.CREATE:
                case this.STATE.SELECT:
                    $saveButtonEl.getFieldElement().text(app.lang.get('LBL_SAVE_BUTTON_LABEL', this.module));
                    break;
                case this.STATE.DUPLICATE:
                    $saveButtonEl.getFieldElement().text(app.lang.get('LBL_IGNORE_DUPLICATE_AND_SAVE', this.module)).hide();
                    //OCULTANDO BOT�N CON JQUERY
                    $('[name="duplicate_button"]').hide();
                    $('[data-event="list:dupecheck-list-select-edit:fire"]').addClass("hidden");
                    break;
            }
        }
    },

    delegateButtonEvents: function () {
        this._super("delegateButtonEvents");
        this.context.on('button:cotizador_button:click', this.cotizadorClicked, this);
        this.context.on('button:expediente_button:click', this.expedienteClicked, this);
    },


    changeInstMonetario: function () {
        //console.log("Cambio de Inst monetario");
        var instMonetario = this.model.get('tct_inst_monetario_c');
        if (instMonetario.includes("Otro")) {
            this.model.set('imotro_c', true);
            //this.$('[data-name="imotrodesc_c"]').show();
        } else {
            this.model.set('imotro_c', false);
            //this.$('[data-name="imotrodesc_c"]').hide();
        }
    },

    _ActualizaEtiquetas: function () {
        if (this.model.get('tipodepersona_c') != 'Persona Moral' && $("div[data-name='pais_nacimiento_c']").length > 0) {
            this.$("div.record-label[data-name='pais_nacimiento_c']").text("Pa\u00EDs de nacimiento");
        } else {
            this.$("div.record-label[data-name='pais_nacimiento_c']").text("Pa\u00EDs de constituci\u00F3n");
        }

        if (this.model.get('tipodepersona_c') != 'Persona Moral' && $("div[data-name='estado_nacimiento_c']").length > 0) {
            this.$("div.record-label[data-name='estado_nacimiento_c']").text("Estado de nacimiento");
        } else {
            this.$("div.record-label[data-name='estado_nacimiento_c']").text("Estado de constituci\u00F3n");
        }
    },

    _doGeneraCURP: function () {
        if (this.model.get('tipodepersona_c') != 'Persona Moral') {
            //Valida que se tenga la informaci�n requerida para generar la CURP
            if (this.model.get('fechadenacimiento_c') != null && this.model.get('genero_c') != null && this.model.get('genero_c') != ''
                && this.model.get('primernombre_c') != null && this.model.get('apellidopaterno_c') != null && this.model.get('apellidomaterno_c') != null
                && this.model.get('pais_nacimiento_c') != null && this.model.get('estado_nacimiento_c') != null && this.model.get('estado_nacimiento_c') != "1") {
                var firmoParams = {
                    'fechadenacimiento': this.model.get('fechadenacimiento_c'),
                    'primernombre': this.model.get('primernombre_c'),
                    'apellidoP': this.model.get('apellidopaterno_c'),
                    'apellidoM': this.model.get('apellidomaterno_c'),
                    'genero': this.model.get('genero_c'),
                    'pais': this.model.get('pais_nacimiento_c'),
                    'estado': this.model.get('estado_nacimiento_c'),
                    'tipodepersona': this.model.get('tipodepersona_c')
                };
                var dnbProfileUrl = app.api.buildURL("Accounts/GenerarCURP", '', {}, {});
                if (this.model.get('pais_nacimiento_c') == 2) {
                    app.api.call("create", dnbProfileUrl, {curpdata: firmoParams}, {
                        success: _.bind(function (data) {
                            if (data['UNI2_UTL_002_CreaCurpPersonaResult']['resultado']) {
                                this.model.set('curp_c', data['UNI2_UTL_002_CreaCurpPersonaResult']['curp']);
                            }
                        }, this)
                    });
                } else {
                    this.model.set('curp_c', '');
                }
            } else {
                var necesarios = "";  //Se habilita variable para concatenar campos faltantes para generar el CURP
                //Adrian Arauz 10/09/2018
                if (this.model.get('fechadenacimiento_c') == "" || this.model.get('fechadenacimiento_c') == null) {
                    necesarios = necesarios + '<b>Fecha de Nacimiento<br></b>';
                }
                if (this.model.get('genero_c') == "" || this.model.get('genero_c') == null) {
                    necesarios = necesarios + '<b>G\u00E9nero</b><br>';
                }
                if (this.model.get('primernombre_c') == "" || this.model.get('primernombre_c') == null) {
                    necesarios = necesarios + '<b>Primer Nombre</b><br>';
                }
                if (this.model.get('apellidopaterno_c') == "" || this.model.get('apellidopaterno_c') == null) {
                    necesarios = necesarios + '<b>Apellido Paterno</b><br>';
                }
                if (this.model.get('apellidomaterno_c') == "" || this.model.get('apellidomaterno_c') == null) {
                    necesarios = necesarios + '<b>Apellido Materno</b><br>';
                }
                if (this.model.get('pais_nacimiento_c') == "" || this.model.get('pais_nacimiento_c') == null) {
                    necesarios = necesarios + '<b>Pa\u00EDs de Nacimiento</b><br>';
                }

                if (this.model.get('estado_nacimiento_c') == "" || this.model.get('estado_nacimiento_c') == null || this.model.get('estado_nacimiento_c') == "1") {
                    necesarios = necesarios + '<b>Estado de Nacimiento</b><br>';
                }

                else (necesarios != "")
                {
                    console.log("Confirma necesarios");
                    app.alert.show("Generar CURP", {
                        level: "error",
                        title: "Faltan los siguientes datos para poder generar el CURP: <br>" + necesarios,
                        autoClose: false
                    });
                }
            }
        }
    },

    _doValidateTieneContactos: function (fields, errors, callback) {
        if (this.model.get('tipodepersona_c') == 'Persona Moral' &&
            (/*this.model.get('tipo_registro_c') == "Cliente" || this.model.get('estatus_c') == "Interesado"
             || */this.model.get('tipo_registro_c') == "Prospecto" )) {
            if (_.isEmpty(this.model.get('account_contacts'))) {
                app.alert.show("Persona sin contactos registrados", {
                    level: "error",
                    title: "Debe registrar al menos un contacto.",
                    autoClose: false
                });
                errors['account_contacts'] = errors['account_contacts'] || {};
                errors['account_contacts'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    ValidaFormatoCURP: function (fields, errors, callback) {
        if (this.model.get('tipodepersona_c') != 'Persona Moral') {
            var CURP = this.model.get('curp_c');
            if (CURP != '' && CURP != null) {
                CURP = CURP.toUpperCase().trim();

                if (!CURP.match("[A-Z]{4}[0-9]{6}[A-Z]{6}[0-9]?[0-9]?")) {
                    app.alert.show("CURP incorrecto", {
                        level: "error",
                        title: "El CURP no tiene un formato correcto.",
                        autoClose: false
                    });
                    errors['curp_c'] = errors['curp_c'] || {};
                    errors['curp_c'].required = true;
                }
            }
        }
        callback(null, fields, errors);
    },

    /*_ShowDireccionesTipoRegistro: function(){
     if(this.model.get('tipo_registro_c') == "Cliente" || this.model.get('estatus_c') == "Interesado"){
     this.$("div[data-name='account_direcciones']").show();
     }else{
     this.$("div[data-name='account_direcciones']").hide();
     }
     // Carlos Zaragoza: Se elimina el campo por defaiult de tipo de proveedor del registro pero sies proveedor, se selecciona bienes por default
     if(this.model.get('tipo_registro_c') == 'Proveedor'){
     this.model.set('tipo_proveedor_c', '1');
     }
     },*/

    _doValidateDireccion: function (fields, errors, callback) {
        if (this.model.get('tipo_registro_c') == "Cliente" || this.model.get('tipo_registro_c') == "Proveedor" || this.model.get('tipo_registro_c') == "Prospecto" || this.model.get('esproveedor_c')==true) {
            if (_.isEmpty(this.oDirecciones.direccion)) {
                //errors[$(".addDireccion")] = errors['account_direcciones'] || {};
                //errors[$(".addDireccion")].required = true;
                errors['account_direcciones'] = errors['account_direcciones'] || {};
                errors['account_direcciones'].required = true;

                $('.direcciondashlet').css('border-color', 'red');
                app.alert.show("Direccion requerida", {
                    level: "error",
                    title: "Al menos una direcci\u00F3n es requerida.",
                    autoClose: false
                });
            } else {
                //Valdaci�n Nacional
                if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                    var nacional = 0;
                    console.log('Validacion Dir.Nacional');
                    console.log(direcciones);
                    var direcciones = this.oDirecciones.direccion;
                    for (i = 0; i < direcciones.length; i++) {
                        if (direcciones[i].pais == 2) {
                            nacional = 1;
                        }
                    }
                    //Valida variable nacional
                    if (nacional != 1) {
                        console.log('Dir. Nacional requerida');
                        errors[$(".addDireccion")] = errors['account_direcciones'] || {};
                        errors[$(".addDireccion")].required = true;

                        $('.direcciondashlet').css('border-color', 'red');
                        app.alert.show("Direccion nacional requerida", {
                            level: "error",
                            title: "Al menos una direcci\u00F3n nacional es requerida.",
                            autoClose: false
                        });
                    }
                }
            }
        }
        callback(null, fields, errors);
    },

    _doValidateMayoriadeEdad: function (fields, errors, callback) {
        if (this.model.get('tipodepersona_c') != 'Persona Moral' && this.model.get('fechadenacimiento_c') != "") {
            var nacimiento = new Date(this.model.get("fechadenacimiento_c"));
            var enteredAge = this.getAge(nacimiento);
            if (enteredAge < 18) {
                app.alert.show("fechaDeNacimientoCheck", {
                    level: "error",
                    title: "Persona debe de ser mayor de 18 a\u00F1os.",  //update
                    autoClose: false
                });
                errors['fechadenacimiento_c'] = errors['fechadenacimiento_c'] || {};
                errors['fechadenacimiento_c'].required = true;
            }
        }

        callback(null, fields, errors);
    },

    getAge: function (DOB) {
        var today = new Date();
        var birthDate = new Date(DOB);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    },

    _doValidateWSRFC: function () {
        var firmoParams = {
            'fechadenacimiento': this.model.get("fechadenacimiento_c"),
            'primernombre': this.model.get("primernombre_c"),
            'apellidoP': this.model.get("apellidopaterno_c"),
            'apellidoM': this.model.get("apellidomaterno_c"),
            'genero': this.model.get("genero_c"),
            'pais': this.model.get("pais_nacimiento_c"),
            'estado': this.model.get("estado_nacimiento_c"),
            'razonsocial': this.model.get("razonsocial_c"),
            'tipodepersona': this.model.get("tipodepersona_c"),
            'fechaconstitutiva': this.model.get("fechaconstitutiva_c")
        };

        var dnbProfileUrl = app.api.buildURL("Accounts/ValidarRFC", '', {}, {});
        app.api.call("create", dnbProfileUrl, {rfcdata: firmoParams}, {
            success: _.bind(function (data) {
                if (data != null) {
                    var rfc = this.model.get('rfc_c');
                    //Obtiene el resultado del WS dependiendo del regimen de la persona
                    if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                        var rfc_SinHomoclave = (data['UNI2_CTE_02_CreaRfcPersonaFisicaResult']['resultado'] ?
                            data['UNI2_CTE_02_CreaRfcPersonaFisicaResult']['rfcGenerado'] : "" );
                        var rfc_local = (data['UNI2_CTE_02_CreaRfcPersonaFisicaResult']['resultado'] ?
                            data['UNI2_CTE_02_CreaRfcPersonaFisicaResult']['rfcGenerado'] + data['UNI2_CTE_02_CreaRfcPersonaFisicaResult']['homoClaveDV'] : "" );
                    } else if (this.model.get("tipodepersona_c") == 'Persona Moral') {
                        var rfc_SinHomoclave = (data['UNI2_CTE_03_CreaRfcPersonaMoralResult']['resultado'] ?
                            data['UNI2_CTE_03_CreaRfcPersonaMoralResult']['rfcGenerado'] : "");
                        var rfc_local = (data['UNI2_CTE_03_CreaRfcPersonaMoralResult']['resultado'] ?
                            data['UNI2_CTE_03_CreaRfcPersonaMoralResult']['rfcGenerado'] + data['UNI2_CTE_03_CreaRfcPersonaMoralResult']['homoClaveDV'] : "");
                    }

                    if (rfc != "" && rfc != null) {
                        rfc = (this.model.get("tipodepersona_c") != 'Persona Moral' ? rfc.substring(0, 10) : rfc.substring(0, 9));
                        if (rfc != rfc_SinHomoclave) {
                            app.alert.show("Validar RFC", {
                                level: "confirmation",
                                messages: "El RFC calculado es diferente al escrito, �Desea reemplazarlo?",
                                autoClose: false,
                                onConfirm: function () {
                                    console.log("*** JSR *** el rfc se remplazo con �xito CONFIRMED");
                                    self.model.set("rfc_c", rfc_local);
                                },
                                onCancel: function () {
                                    console.log("*** JSR *** no se modific� el RFC");
                                    //alert("Cancelled!");
                                }
                            });
                        } else {
                            app.alert.show("RFC correcto", {
                                level: "error",
                                title: "El RFC capturado actualmente es correcto",
                                autoClose: true
                            });
                        }
                    } else {
                        console.log("*** JSR *** el rfc est� vacio");
                        this.model.set("rfc_c", rfc_local);
                    }
                }
            }, this)
        });
        //callback(null, fields, errors);
    },

    _doGenera_RFC_CURP: function () {
        if (this.model.get('pais_nacimiento_c') != 2 && this.model.get('pais_nacimiento_c') != '' && this.model.get('pais_nacimiento_c') != null
            && (this.model.get('tipo_registro_c') != 'Prospecto' || this.model.get('estatus_c') != 'Interesado')) {
            if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                this.model.set('rfc_c', 'XXXX010101XXX');
            } else {
                this.model.set('rfc_c', 'XXX010101XXX');
            }
        } else {
            if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                if (this.model.get('fechadenacimiento_c') != null && this.model.get('fechadenacimiento_c') != '' && this.model.get('primernombre_c') != null && this.model.get('primernombre_c') != ''
                    && this.model.get('apellidopaterno_c') != null  && this.model.get('apellidopaterno_c') != '' && this.model.get('apellidomaterno_c') != null && this.model.get('apellidomaterno_c') != '') {
                    this._doValidateWSRFC();
                } else {
                    var faltantes = "";
                    console.log('Valida campos para RFC');
                    if (this.model.get('fechadenacimiento_c') == "" || this.model.get('fechadenacimiento_c') == null) {
                        faltantes = faltantes + '<b>Fecha de Nacimiento<br></b>';
                    }
                    if (this.model.get('primernombre_c') == "" || this.model.get('primernombre_c') == null) {
                        faltantes = faltantes + '<b>Primer Nombre<br></b>';
                    }
                    if (this.model.get('apellidopaterno_c') == "" || this.model.get('apellidopaterno_c') == null) {
                        faltantes = faltantes + '<b>Apellido Paterno<br></b>';
                    }
                    if (this.model.get('apellidomaterno_c') == "" || this.model.get('apellidomaterno_c') == null) {
                        faltantes = faltantes + '<b>Apellido Materno<br></b>';
                    }

                        else (faltantes != "")
                        app.alert.show("Generar RFC", {
                            level: "error",
                            title: "Faltan los siguientes datos para poder generar el RFC: <br>" + faltantes,
                            autoClose: true
                        });
                    }
                  }
            else
                {
                    if ((this.model.get('razonsocial_c') != null && this.model.get('razonsocial_c')!="") && (this.model.get('fechaconstitutiva_c') != null && this.model.get('fechaconstitutiva_c') !="" )) {
                        this._doValidateWSRFC();
                    } else {
                        var falta = "";
                        console.log('Entra P Moral RFC');
                        if (this.model.get('fechaconstitutiva_c') == "" || this.model.get('fechaconstitutiva_c') == null) {
                            falta = falta + '<b>Fecha Constitutiva<br></b>';
                        }
                        /*if (this.model.get('nombre_comercial_c') == "" || this.model.get('nombre_comercial_c') == null) {
                            falta = falta + '<b>Nombre Comercial<br></b>';
                        }*/
                        if (this.model.get('razonsocial_c') == "" || this.model.get('razonsocial_c') == null) {
                            falta = falta + '<b>Raz\u00F3n Social<br></b>';
                        }
                        app.alert.show("Generar RFC", {
                            level: "error",
                            title: "Faltan los siguientes datos para poder generar el RFC: <br>" + falta,
                            autoClose: true
                        });
                    }
                }
            }

    },

    //Evento no acepta numeros, solo letras (a-z).
    checkTextOnly: function () {
        app.alert.dismiss('Error_validacion_Campos');
        var camponame= "";
        var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
        if (this.model.get('primernombre_c')!="" && this.model.get('primernombre_c')!=undefined){
            var nombre=this.model.get('primernombre_c');
            var comprueba = expresion.test(nombre);
            if(comprueba!= true){
                camponame= camponame + '<b>-Primer Nombre<br></b>'; ;
            }
        }
        if (this.model.get('apellidopaterno_c')!="" && this.model.get('apellidopaterno_c')!= undefined){
            var apaterno=this.model.get('apellidopaterno_c');
            var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
            var validaap = expresion.test(apaterno);
            if(validaap!= true){
                camponame= camponame + '<b>-Apellido Paterno<br></b>'; ;
            }
        }
        if (this.model.get('apellidomaterno_c')!="" && this.model.get('apellidomaterno_c')!= undefined){
            var amaterno=this.model.get('apellidomaterno_c');
            var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
            var validaam = expresion.test(amaterno);
            if(validaam!= true){
                camponame= camponame + '<b>-Apellido Materno<br></b>'; ;
            }
        }
        if (camponame){
            app.alert.show("Error_validacion_Campos", {
                level: "error",
                messages: 'Los siguientes campos no permiten caracteres especiales:<br>'+ camponame,
                autoClose: false
            });
        }
    },

    checkTextAndNum: function () {
        //Modificacion a validacion del campo, debe cumplir un formato.
        app.alert.dismiss('Error_validacion_Passport');
        var campoPass= "";
        var expresion = new RegExp(/^[0-9a-zA-Z]+$/g);
        if (this.model.get('ifepasaporte_c')!="" && this.model.get('ifepasaporte_c')!=undefined){
            var nombre=this.model.get('ifepasaporte_c');
            var comprueba = expresion.test(nombre);
            if(comprueba!= true){
                campoPass= campoPass + '<b>-IFE/Pasaporte<br></b>';
            }
        }
        if (this.model.get('curp_c')!="" && this.model.get('curp_c')!=undefined){
            var expresionC = new RegExp(/^[0-9a-zA-Z]+$/g);
            var curp=this.model.get('curp_c');
            var comprueba = expresionC.test(curp);
            if(comprueba!= true){
                campoPass= campoPass + '<b>-CURP<br></b>';
            }
        }
        if (campoPass){
            app.alert.show("Error_validacion_Passport", {
                level: "error",
                messages: 'Los siguientes campos no permiten el ingreso de caracteres especiales:<br>'+ campoPass,
                autoClose: false
            });
        }
    },

    //No aceptar caracteres especiales incluyendo puntos(.) y comas(,)
    checkTextAndNumRFC: function (evt) {
        if ($.inArray(evt.keyCode, [45, 33, 36, 46, 35, 34, 8, 9, 20, 16, 17, 37, 40, 39, 38, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 16, 32, 192, 186, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105]) < 0) {
            app.alert.show("Caracter Invalido", {
                level: "error",
                title: "Caracter Inv\u00E1lido.",
                autoClose: true
            });
            return false;
        }
    },

    /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 8/26/2015 Description: When Pais or Profesion field is changed, Recalculate the Riesgo */
    _doValidateProfesionRisk: function () {
        var riskCounter = 0;
        if (this.model.get("lista_negra_c") == "0" || this.model.get("pep_c") == "0") {
            if (!_.isEmpty(this.model.get("pais_nacimiento_c"))) {
                app.api.call("read", app.api.buildURL("dire_Pais/", null, null, {
                    fields: "altoriesgo",
                    "filter": [
                        {
                            "id": this.model.get("pais_nacimiento_c")
                        }
                    ]
                }), null, {
                    success: _.bind(function (data) {
                        if (data.records.length > 0) {
                            if (data.records[0].altoriesgo == true) {
                                riskCounter++;
                            }
                        }
                        if (!_.isEmpty(this.model.get("profesion_c"))) {
                            var profesionActual = this.model.get("profesion_c");
                            var profesiones_de_riesgo = app.lang.getAppListStrings('profesion_riesgo_list');
                            Object.keys(profesiones_de_riesgo).forEach(function (key) {
                                if (key == profesionActual) {
                                    riskCounter++;
                                }
                            });
                        }
                        if (riskCounter > 0) {
                            this.model.set("riesgo_c", "Alto");
                        } else {
                            this.model.set("riesgo_c", "Bajo");
                        }
                    }, this)
                });
            }
        }
    },

    fechaMenor1900: function (fields, errors, callback) {
        var nacimiento = new Date(this.model.get("fechadenacimiento_c"));
        var year = nacimiento.getFullYear();
        if (year <= 1900) {
            app.alert.show("fechaDeNacimientoCheck", {
                level: "error",
                title: "La fecha de nacimiento no puede ser menor a 1900",
                autoClose: false
            });
            errors['fechadenacimiento_c'] = errors['fechadenacimiento_c'] || {};
            errors['fechadenacimiento_c'].required = true;
        }


        callback(null, fields, errors);
    },

    doValidateDateNac: function (fields, errors, callback) {
        /* if  date not empty, then check with today date and return error */
        if (!_.isEmpty(this.model.get('fechadenacimiento_c')) && this.model.get('tipodepersona_c')!='Persona Moral') {

            var fecnac_date = this.model.get('fechadenacimiento_c');
            var today_date = new Date().toISOString().slice(0,10);

            if (fecnac_date >= today_date) {

                app.alert.show("fechaDeNacimientoValidate", {
                    level: "error",
                    title: "La fecha de nacimiento no puede ser mayor o igual al d\u00EDa de hoy",
                    autoClose: false
                });
                errors['fechadenacimiento_c'] = errors['fechadenacimiento_c'] || {};
                //errors['fechaapertura'] = 'La fecha de apertura no puede ser posterior al d�a de hoy' || {};
                errors['fechadenacimiento_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    doValidateDateCons: function (fields, errors, callback) {
        /* if  date not empty, then check with today date and return error */
        if (!_.isEmpty(this.model.get('fechaconstitutiva_c')) && this.model.get('tipodepersona_c')=='Persona Moral') {

            var feccons_date = this.model.get('fechaconstitutiva_c');
            var today_date = new Date().toISOString().slice(0,10);

            if (feccons_date > today_date) {

                app.alert.show("fechaDeConsValidate", {
                    level: "error",
                    title: "La fecha constitutiva no puede ser mayor al d\u00EDa de hoy",
                    autoClose: false
                });

                errors['fechaconstitutiva_c'] = errors['fechaconstitutiva_c'] || {};
                //errors['fechaapertura'] = 'La fecha de apertura no puede ser posterior al d�a de hoy' || {};
                errors['fechaconstitutiva_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    /**
     * @author Carlos Zaragoza Ortiz
     * @date 16-10-2015
     * Al ser proveedor debe solicitar como obligatorio el tipo de proveedor
     * @type function
     * */
    validaProveedorRequerido: function (fields, errors, callback) {
        if (this.model.get('tipo_registro_c') == 'Proveedor' || this.model.get('esproveedor_c')==true) {
            this.model.set("esproveedor_c", true);
            var tipoProveedor = new String(this.model.get('tipo_proveedor_c'));
            if (tipoProveedor.length == 0) {
                /*app.alert.show("Proveedor Requerido", {
                    level: "error",
                    title: "Debe seleccionar un tipo de proveedor al menos",
                    autoClose: false
                });*/
                errors['tipo_proveedor_c'] = errors['tipo_proveedor_c'] || {};
                errors['tipo_proveedor_c'].required = true;
            }
            if(this.model.get('tct_macro_sector_ddw_c')==''|| this.model.get('tct_macro_sector_ddw_c')==null){
                /*app.alert.show("Macro sector requerido", {
                    level: "error",
                    title: "El campo macro sector es requerido",
                    autoClose: false
                });*/
                errors['tct_macro_sector_ddw_c'] = errors['tct_macro_sector_ddw_c'] || {};
                errors['tct_macro_sector_ddw_c'].required = true;
            }
            if(this.model.get('rfc_c')==''|| this.model.get('rfc_c')==null){
                /*app.alert.show("RFC requerido", {
                    level: "error",
                    title: "El campo RFC es requerido",
                    autoClose: false
                });*/
                errors['rfc_c'] = errors['rfc_c'] || {};
                errors['rfc_c'].required = true;
            }
            if(this.model.get('tipodepersona_c')!='Persona Moral'){
                /*app.alert.show("Fecha de nacimiento requerida", {
                    level: "error",
                    title: "El campo fecha de nacimiento es requerido",
                    autoClose: false
                });*/
                if(this.model.get('fechadenacimiento_c')==''|| this.model.get('fechadenacimiento_c')==null){
                  errors['fechadenacimiento_c'] = errors['fechadenacimiento_c'] || {};
                  errors['fechadenacimiento_c'].required = true;
                }

                /*app.alert.show("Pais de nacimiento requerido", {
                    level: "error",
                    title: "El campo pa\u00EDs de nacimiento es requerido",
                    autoClose: false
                });*/
                if(this.model.get('pais_nacimiento_c')==''|| this.model.get('pais_nacimiento_c')==null){
                  errors['pais_nacimiento_c'] = errors['pais_nacimiento_c'] || {};
                  errors['pais_nacimiento_c'].required = true;
                }
                if(this.model.get('estado_nacimiento_c') == "" || this.model.get('estado_nacimiento_c') == null) {
                    errors['estado_nacimiento_c'] = errors['estado_nacimiento_c'] || {};
                    errors['estado_nacimiento_c'].required = true;
                }
                /*app.alert.show("Estado civil requerido", {
                    level: "error",
                    //title: "El campo estado civil es requerido",
                    autoClose: false
                });*/
                if(this.model.get('estadocivil_c')==''|| this.model.get('estadocivil_c')==null){
                  errors['estadocivil_c'] = errors['estadocivil_c'] || {};
                  errors['estadocivil_c'].required = true;
                }

                /*app.alert.show("Profesion requerido", {
                    level: "error",
                    title: "El campo profesi\u00F3n es requerido",
                    autoClose: false
                });*/
                if(this.model.get('profesion_c')==''|| this.model.get('profesion_c')==null){
                  errors['profesion_c'] = errors['profesion_c'] || {};
                  errors['profesion_c'].required = true;
                }
            }
            else{
                /*app.alert.show("Pais de constitucion", {
                    level: "error",
                    title: "El campo pa\u00EDs de constituci\u00F3n es requerido",
                    autoClose: false
                });*/
                if(this.model.get('pais_nacimiento_c')==''|| this.model.get('pais_nacimiento_c')==null){
                  errors['pais_nacimiento_c'] = errors['pais_nacimiento_c'] || {};
                  errors['pais_nacimiento_c'].required = true;
                }
                if(this.model.get('estado_nacimiento_c') == "" || this.model.get('estado_nacimiento_c') == null) {
                    errors['estado_nacimiento_c'] = errors['estado_nacimiento_c'] || {};
                    errors['estado_nacimiento_c'].required = true;
                }
                if(this.model.get('fechaconstitutiva_c')==''|| this.model.get('fechaconstitutiva_c')==null){
                    errors['fechaconstitutiva_c'] = errors['fechaconstitutiva_c'] || {};
                    errors['fechaconstitutiva_c'].required = true;
                }
            }
        }
        callback(null, fields, errors);
    },
    /* END */
    /*tipoProveedor_check: function(fields, errors, callback){
        if(this.model.get('esproveedor_c')==true){

            app.alert.show("Proveedor Requerido", {
                    level: "error",
                    title: "Debe seleccionar un un tipo de proveedor al menos",
                    autoClose: false
                });
             errors['tipo_proveedor_c'] = errors['tipo_proveedor_c'] || {};
                errors['tipo_proveedor_c'].required = true;
        }
        callback(null, fields,errors);
    },*/
    /**
     * @author Salvador Lopez Balleza
     * @date 13/03/2018
     * Establecer campo phone_office con la misma informaci�n que el campo personalizado account_telefonos
     * */
    setPhoneOffice: function () {

        if (!_.isEmpty(this.oTelefonos.telefono)) {
            var telefono = this.oTelefonos.telefono;
            for (var i = 0; i < telefono.length; i++) {
                if (telefono[i].principal) {
                   //if (telefono[i].pais!='52'){
                    //this.model.set('phone_office', "base" + telefono[i].pais + " " + telefono[i].telefono);
                      //      }else{
                    this.model.set('phone_office', "" + telefono[i].telefono);
                    //}

                }
            }
        }
    },
    /**
     * @author Carlos Zaragoza Ortiz
     * @date 16-10-2015
     * UNIFIN TASK: Modificar el riesgo en caso de seleccionar "PEP" en cuestionario de PLD
     * */
    cambiaRiesgodePersona: function (fields, errors, callback) {
        var riesgo = this.model.get('ctpldpoliticamenteexpuesto_c') == true ? 'Alto' : 'Bajo';
        this.model.set("riesgo_c", riesgo);
        console.log(this.model.get('ctpldpoliticamenteexpuesto_c'));
        console.log(this.model.get('riesgo_c'));
        callback(null, fields, errors);
    },

    cleanName: function () {
        //Recupera variables
        var original_name = this.model.get("name");
        var list_check = app.lang.getAppListStrings('validacion_duplicados_list');
        var simbolos = app.lang.getAppListStrings('validacion_simbolos_list');
        //Define arreglos para guardar nombre de cuenta
            var clean_name_split = [];
            var clean_name_split_full = [];
            clean_name_split = original_name.split(" ");
            //Elimina simbolos: Ej. . , -
            _.each(clean_name_split, function (value, key) {
                _.each(simbolos, function (simbolo, index) {
                    var clean_value = value.split(simbolo).join('');
                    if (clean_value != value) {
                        clean_name_split[key] = clean_value;
                    }
                });
            });
            clean_name_split_full = App.utils.deepCopy(clean_name_split);

        if (this.model.get('tipodepersona_c')=="Persona Moral") {
            //Elimina tipos de sociedad: Ej. SA, de , CV...
            var totalVacio = 0;
            _.each(clean_name_split, function (value, key) {
                _.each(list_check, function (index, nomenclatura) {
                    var upper_value = value.toUpperCase();
                    if (upper_value == nomenclatura) {
                        var clean_value = upper_value.replace(nomenclatura, "");
                        clean_name_split[key] = clean_value;
                    }
                });
            });
            //Genera clean_name con arreglo limpio
            var clean_name = "";
            _.each(clean_name_split, function (value, key) {
                clean_name += value;
                //Cuenta elementos vacíos
                if (value == "") {
                    totalVacio++;
                }
            });

            //Valida que exista más de un elemento, caso cotrarioe establece para clean_name valores con tipo de sociedad
            if ((clean_name_split.length - totalVacio) <= 1) {
                clean_name = "";
                _.each(clean_name_split_full, function (value, key) {
                    clean_name += value;
                });
            }
            clean_name = clean_name.toUpperCase();
            this.model.set("clean_name", clean_name);
        }else{
            original_name = original_name.replace(/\s+/gi,'');
            original_name= original_name.toUpperCase();
            this.model.set("clean_name", original_name);
        }
    },

    changeLabelMarketing: function () {
        console.log("Cambio de Origen");
        if (this.model.get('origendelprospecto_c') == 'Mercadotecnia') {
            console.log("Se eligio Mecadotecnia");
            this.$("div.record-label[data-name='evento_marketing_c']").text("Detalle marketing");
        }
        if (this.model.get('origendelprospecto_c') == 'Eventos Mercadotecnia') {
            console.log("Se eligio Eventos Mecadotecnia");
            this.$("div.record-label[data-name='evento_marketing_c']").text("Evento marketing");
        }
    },

    doValidateInfoReq: function (fields, errors, callback) {
        if (this.model.get('origendelprospecto_c') == 'Prospeccion propia') {
            var metodoProspeccion = new String(this.model.get('metodo_prospeccion_c'));
            if (metodoProspeccion.length == 0 || this.model.get('metodo_prospeccion_c') == null) {
                /*app.alert.show("Metodo de Prospeccion Requerido", {
                    level: "error",
                    title: "Debe indicar el metodo de prospecci\u00F3n",
                    autoClose: false
                });*/
                errors['metodo_prospeccion_c'] = errors['metodo_prospeccion_c'] || {};
                errors['metodo_prospeccion_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },
    //Funcion que valida el contenido ingresado en el campo del Email
    expmail: function (fields, errors, callback){
        if (this.model.get('email') != null && this.model.get('email') !="") {

            var input = (this.model.get('email'));
            var expresion = /^\S+@\S+\.\S+[$%&|<>#]?$/;
            var cumple = true;

            for (i=0; i< input.length; i++) {

                if (expresion.test(input[i].email_address)== false) {
                    cumple = false;

                }
            }

                if (cumple == false) {
                    app.alert.show('Error al validar email', {
                        level: 'error',
                        autoClose: true,
                        messages: '<b>Formato de email incorrecto.</b>'
                    })
                    errors['email'] = errors['email'] || {};
                    errors['email'].required = true;
                }
        }

        callback(null, fields, errors);
    },

    validacedente: function (fields, errors, callback) {

        if (this.model.get('cedente_factor_c') == true) {

            var value = this.oDirecciones.direccion;
            var totalindicadores = "";

            if (value != undefined) {
                for (i = 0; i < value.length; i++) {
                    console.log("Valida Cedente");
                    var valorecupera = this._getIndicador(value[i].indicador);
                    totalindicadores = totalindicadores + "," + valorecupera;
                }
            }

            var arregloindicadores = [];
            if (value == "" || value == null) {
                arregloindicadores = [0];

            } else {
                arregloindicadores = totalindicadores.split(",");
            }

            var direccionesfaltantes = "";

            if (arregloindicadores.indexOf("1") == -1) {
                direccionesfaltantes = direccionesfaltantes + 'Correspondencia<br>';
            }
            if (arregloindicadores.indexOf("2") == -1) {
                direccionesfaltantes = direccionesfaltantes + 'Fiscal<br>';
            }
            if (arregloindicadores.indexOf("4") == -1) {
                direccionesfaltantes = direccionesfaltantes + 'Entrega de Bienes<br>';
            }

            if (direccionesfaltantes != "") {
                $('.select2-choices').css('border-color', 'red');
                app.alert.show('Error al validar Direcciones', {
                    level: 'error',
                    autoClose: false,
                    messages: 'Debe tener las siguientes direcciones: <br><b>' + direccionesfaltantes + '</b>'
                })
                errors['account_direcciones_c'] = errors['account_direcciones_c'] || {};
                errors['account_direcciones_c'].required = true;
            }
            else {
                $('.select2-choices').css('border-color', '');
            }
            //Validar campos adionales
            if (this.model.get('tipo_registro_c') == 'Persona' || this.model.get('tipo_registro_c') == 'Prospecto') {

                if (this.model.get('rfc_c') == "" || this.model.get('rfc_c') == null) {
                    errors['rfc_c'] = errors['rfc_c'] || {};
                    errors['rfc_c'].required = true;
                }
                if (this.model.get('pais_nacimiento_c') == "" || this.model.get('pais_nacimiento_c') == null) {
                    errors['pais_nacimiento_c'] = errors['pais_nacimiento_c'] || {};
                    errors['pais_nacimiento_c'].required = true;
                }
                if (this.model.get('estado_nacimiento_c') == "" || this.model.get('estado_nacimiento_c') == null) {
                    errors['estado_nacimiento_c'] = errors['estado_nacimiento_c'] || {};
                    errors['estado_nacimiento_c'].required = true;
                }
                if (this.model.get('tipodepersona_c') == 'Persona Moral') {
                    if (this.model.get('tct_macro_sector_ddw_c') == "" || this.model.get('tct_macro_sector_ddw_c') == null) {
                        errors['tct_macro_sector_ddw_c'] = errors['tct_macro_sector_ddw_c'] || {};
                        errors['tct_macro_sector_ddw_c'].required = true;
                    }
                    if (this.model.get('fechaconstitutiva_c') == "" || this.model.get('fechaconstitutiva_c') == null) {
                        errors['fechaconstitutiva_c'] = errors['fechaconstitutiva_c'] || {};
                        errors['fechaconstitutiva_c'].required = true;
                    }
                } else {

                    if (this.model.get('curp_c') == "" || this.model.get('curp_c') == null) {
                        errors['curp_c'] = errors['curp_c'] || {};
                        errors['curp_c'].required = true;
                    }
                    if (this.model.get('apellidomaterno_c') == "" || this.model.get('apellidomaterno_c') == null) {
                        errors['apellidomaterno_c'] = errors['apellidomaterno_c'] || {};
                        errors['apellidomaterno_c'].required = true;
                    }
                    if (this.model.get('fechadenacimiento_c') == "" || this.model.get('fechadenacimiento_c') == null) {
                        errors['fechadenacimiento_c'] = errors['fechadenacimiento_c'] || {};
                        errors['fechadenacimiento_c'].required = true;
                    }
                    if (this.model.get('genero_c') == "" || this.model.get('genero_c') == null) {
                        errors['genero_c'] = errors['genero_c'] || {};
                        errors['genero_c'].required = true;
                    }

                    if (this.model.get('tct_macro_sector_ddw_c') == "" || this.model.get('tct_macro_sector_ddw_c') == null) {
                        errors['tct_macro_sector_ddw_c'] = errors['tct_macro_sector_ddw_c'] || {};
                        errors['tct_macro_sector_ddw_c'].required = true;
                    }
                }
            }
        }


        if (this.model.get('deudor_factor_c') == true) {

            /**********Campos requeridos para check Deudor Factor*******/
            var value = this.oDirecciones.direccion;
            var totalindicadores = "";

            if (value != undefined) {
                for (i = 0; i < value.length; i++) {
                    var valorecupera = this._getIndicador(value[i].indicador);
                    totalindicadores = totalindicadores + "," + valorecupera;
                }
            }

            var arregloindicadores = [];
            if (value == "" || value == null) {
                arregloindicadores = [0];

            } else {
                arregloindicadores = totalindicadores.split(",");
            }

            var direccionesfaltantes = "";
            if (arregloindicadores.indexOf("2") == -1) {
                direccionesfaltantes = direccionesfaltantes + 'Domicilio Fiscal<br>';
            }
            if (direccionesfaltantes != "") {
                $('.select2-choices').css('border-color', 'red');
                app.alert.show('Error al validar Direcciones', {
                    level: 'error',
                    autoClose: false,
                    messages: 'Debe tener las siguientes direcciones: <br><b>' + direccionesfaltantes + '</b>'
                })
                errors['account_direcciones_c'] = errors['account_direcciones_c'] || {};
                errors['account_direcciones_c'].required = true;
            }
            else {
                $('.select2-choices').css('border-color', '');
            }
            if (this.model.get('razonsocial_c') == "" || this.model.get('razonsocial_c') == null) {
                errors['razonsocial_c'] = errors['razonsocial_c'] || {};
                errors['razonsocial_c'].required = true;
            }
            if (this.model.get('actividadeconomica_c') == "" || this.model.get('actividadeconomica_c') == null) {
                errors['actividadeconomica_c'] = errors['actividadeconomica_c'] || {};
                errors['actividadeconomica_c'].required = true;
            }
            if (this.model.get('rfc_c') == "" || this.model.get('rfc_c') == null) {
                errors['rfc_c'] = errors['rfc_c'] || {};
                errors['rfc_c'].required = true;
            }
            if (this.model.get('tct_pais_expide_rfc_c') == "" || this.model.get('tct_pais_expide_rfc_c') == null) {
                errors['tct_pais_expide_rfc_c'] = errors['tct_pais_expide_rfc_c'] || {};
                errors['tct_pais_expide_rfc_c'].required = true;
            }

        }

        callback(null, fields, errors);

    },

    _getIndicador: function(idSelected, valuesSelected) {

        //variable con resultado
        var result = null;

        //Arma objeto de mapeo
        var dir_indicador_map_list = app.lang.getAppListStrings('dir_indicador_map_list');

        var element = {};
        var object = [];
        var values = [];

        for(var key in dir_indicador_map_list) {
            var element = {};
            element.id = key;
            values = dir_indicador_map_list[key].split(",");
            element.values = values;
            object.push(element);
        }

        //Recupera arreglo de valores por id
        if(idSelected){
            for(var i=0; i<object.length; i++) {
                if ((object[i].id) == idSelected) {
                    result = object[i].values;
                }
            }
            console.log(result);
        }

        //Recupera id por valores
        if(valuesSelected){
            result = [];
            for(var i=0; i<object.length; i++) {
                if (object[i].values.length == valuesSelected.length) {
                    //Ordena arreglos y compara
                    valuesSelected.sort();
                    object[i].values.sort();
                    var tempVal = true;
                    for(var j=0; j<valuesSelected.length; j++) {
                        if(valuesSelected[j] != object[i].values[j]){
                            tempVal = false;
                        }
                    }
                    if( tempVal == true){
                        result[0] = object[i].id;
                    }

                }
            }

            console.log(result);
        }

        return result;
    },

    validapotencial: function(fields, errors, callback) {

        if ((this.model.get('tipo_registro_c') == 'Prospecto' && this.model.get('subtipo_cuenta_c') == 'Integracion de Expediente') || this.model.get('tipo_registro_c') == 'Cliente'  ) {
            if (this.model.get('ventas_anuales_c') == undefined || this.model.get('ventas_anuales_c') == "" || (Number(this.model.get('ventas_anuales_c')) <= 0 ))  {
                errors['ventas_anuales_c'] = "Este campo debe tener un valor mayor a 0.";
                errors['ventas_anuales_c'].required = true;
            }
            if (this.model.get('tct_ano_ventas_ddw_c')== undefined || this.model.get('tct_ano_ventas_ddw_c')==""){
                errors['tct_ano_ventas_ddw_c'] = "Se debe seleccionar el año de ventas";
                errors['tct_ano_ventas_ddw_c'].required = true;
            }
            if (this.model.get('activo_fijo_c') == undefined || this.model.get('activo_fijo_c') == "" || (Number(this.model.get('activo_fijo_c')) <= 0 ))  {
                errors['activo_fijo_c'] = "Este campo debe tener un valor mayor a 0.";
                errors['activo_fijo_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    valida_requeridos: function(fields, errors, callback) {
        var campos = "";
        _.each(errors, function(value, key) {
            _.each(this.model.fields, function(field) {
                if(_.isEqual(field.name,key)) {
                    if(field.vname) {
                        if(field.vname == 'LBL_PAIS_NACIMIENTO_C' && this.model.get('tipodepersona_c') == 'Persona Moral')
                        {
                          campos = campos + '<b>País de constitución</b><br>';
                        }
                        else
                        {
                          if(field.vname == 'LBL_ESTADO_NACIMIENTO' && this.model.get('tipodepersona_c') == 'Persona Moral')
                          {
                            campos = campos + '<b>Estado de constitución</b><br>';
                          }
                          else
                          {
                            campos = campos + '<b>' + app.lang.get(field.vname, "Accounts") + '</b><br>';
                          }
                        }
                    }
          		  }
       	    }, this);
        }, this);
        //Remueve campos custom: Teléfonos, Direcciones, Correo
        campos = campos.replace("<b>Telefonos</b><br>","");
        campos = campos.replace("<b>Direcciones</b><br>","");
        campos = campos.replace("<b>Dirección de Correo Electrónico</b><br>","");
        if(campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información en la <b>Cuenta:</b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    checkaccdatestatements:function(fields, errors, callback){
        if(this.model.get('tct_dates_acc_statements_c') != ""){
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!
            var yyyy = today.getFullYear();
            if(dd<10) {
                dd = '0'+dd
            }
            if(mm<10) {
                mm = '0'+mm
            }
            today = yyyy+'-'+mm+'-'+dd;

            this.obj_dates = JSON.parse(this.model.get('tct_dates_acc_statements_c'));
            var c=0;
            for (let elem in this.obj_dates) {
                if(this.obj_dates[elem].trim()==""){
                    $('#'+elem).css('border-color', 'red');
                    c++;
                }
            }
            if(c>0){
                app.alert.show("empty_date", {
                    level: "error",
                    title: "Existen fechas de los estados de cuenta <b>vac\u00EDas</b>, favor de verificar",
                    autoClose: false
                });

                errors['empty_date'] = errors['empty_date'] || {};
                errors['empty_date'].required = true;
            }
        }
        callback(null,fields,errors);
    },

    validaRequeridosPLD: function (fields, errors, callback){
        var faltantesAP = "";
        var faltantesFF = "";
        var faltantesCA = "";
        var tipoCuenta = this.model.get('tipo_registro_c');
        if (tipoCuenta == 'Cliente') {
          //Valida campos para AP
          if (App.user.attributes.tipodeproducto_c == '1') {
              //Pregunta: campo2ddw-ap
             /* if($('.campo2ddw-ap').select2('val') == '' && this.model.get('tipodepersona_c') != 'Persona Moral'){
                  $('.campo2ddw-ap').find('.select2-choice').css('border-color','red');
                  faltantesAP = faltantesAP + '<b>- '+$('select.campo2ddw-ap')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo2ddw-ap').find('.select2-choice').css('border-color','');
              }*/
              //Pregunta: campo3rel-ap
              if($('.campo3rel-ap')[0]['innerText'] == '' && this.model.get('tipodepersona_c') != 'Persona Moral' && $('.campo2ddw-ap').select2('val')=='2'){
                  $('.campo3rel-ap').find('.select2-choice').css('border-color','red');
                  faltantesAP = faltantesAP + '<b>- '+$('.campo3rel-ap')[1].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo3rel-ap').find('.select2-choice').css('border-color','');
              }
              //Pregunta: campo4ddw-ap
             /* if($('.campo4ddw-ap').select2('val') == ''){
                  $('.campo4ddw-ap').find('.select2-choice').css('border-color','red');
                  faltantesAP = faltantesAP + '<b>- '+$('select.campo4ddw-ap')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo4ddw-ap').find('.select2-choice').css('border-color','');
              }*/
              //Pregunta: campo5rel-ap
              if($('.campo5rel-ap')[0]['innerText'] == '' && $('.campo4ddw-ap').select2('val')=='2'){
                  $('.campo5rel-ap').find('.select2-choice').css('border-color','red');
                  faltantesAP = faltantesAP + '<b>- '+$('.campo5rel-ap')[1].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo5rel-ap').find('.select2-choice').css('border-color','');
              }
              //Pregunta: campo7ddw-ap
             /* if($('.campo7ddw-ap').select2('val') == '' && this.model.get('tipodepersona_c') == 'Persona Moral'){
                  $('.campo7ddw-ap').find('.select2-choice').css('border-color','red');
                  faltantesAP = faltantesAP + '<b>- '+$('select.campo7ddw-ap')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo7ddw-ap').find('.select2-choice').css('border-color','');
              }
              //Pregunta: campo9ddw-ap
              if($('.campo9ddw-ap').select2('val') == '' && this.model.get('tipodepersona_c') == 'Persona Moral'){
                  $('.campo9ddw-ap').find('.select2-choice').css('border-color','red');
                  faltantesAP = faltantesAP + '<b>- '+$('select.campo9ddw-ap')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo9ddw-ap').find('.select2-choice').css('border-color','');
              }
              //Pregunta: campo6ddw-ap
              if($('.campo6ddw-ap').select2('val') == ''){
                  $('.campo6ddw-ap').find('.select2-choice').css('border-color','red');
                  faltantesAP = faltantesAP + '<b>- '+$('select.campo6ddw-ap')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo6ddw-ap').find('.select2-choice').css('border-color','');
              }*/
              //Pregunta: campo17txt-ap
              if($('.campo17txt-ap').val() == '' && $('.campo14chk-ap')[0].checked){
                  $('.campo17txt-ap').css('border-color','red');
                  faltantesAP = faltantesAP + '<b>- '+$('.campo17txt-ap')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo17txt-ap').css('border-color','');
              }
              //Pregunta: campo26txt-ap
              if($('.campo26txt-ap').val() == '' && $('.campo11ddw-ap').select2('val')=='No' ){
                  $('.campo26txt-ap').css('border-color','red');
                  faltantesAP = faltantesAP + '<b>- '+$('.campo26txt-ap')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo26txt-ap').css('border-color','');
              }
          }
          //Valida campos para FF
          if (App.user.attributes.tipodeproducto_c == '4') {
              //Pregunta: campo2ddw-ff
              /*if($('.campo2ddw-ff').select2('val') == '' && this.model.get('tipodepersona_c') != 'Persona Moral'){
                  $('.campo2ddw-ff').find('.select2-choice').css('border-color','red');
                  faltantesFF = faltantesFF + '<b>- '+$('select.campo2ddw-ff')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo2ddw-ff').find('.select2-choice').css('border-color','');
              }*/
              //Pregunta: campo3rel-ff
              if($('.campo3rel-ff')[0]['innerText'] == '' && this.model.get('tipodepersona_c') != 'Persona Moral' && $('.campo2ddw-ff').select2('val')=='2'){
                  $('.campo3rel-ff').find('.select2-choice').css('border-color','red');
                  faltantesFF = faltantesFF + '<b>- '+$('.campo3rel-ff')[1].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo3rel-ff').find('.select2-choice').css('border-color','');
              }
              //Pregunta: campo4ddw-ff
             /* if($('.campo4ddw-ff').select2('val') == ''){
                  $('.campo4ddw-ff').find('.select2-choice').css('border-color','red');
                  faltantesFF = faltantesFF + '<b>- '+$('select.campo4ddw-ff')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo4ddw-ff').find('.select2-choice').css('border-color','');
              }*/
              //Pregunta: campo5rel-ff
              if($('.campo5rel-ff')[0]['innerText'] == '' && $('.campo4ddw-ff').select2('val')=='2'){
                  $('.campo5rel-ff').find('.select2-choice').css('border-color','red');
                  faltantesFF = faltantesFF + '<b>- '+$('.campo5rel-ff')[1].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo5rel-ff').find('.select2-choice').css('border-color','');
              }
              //Pregunta: campo21ddw-ff
             /* if($('.campo21ddw-ff').select2('val') == ''){
                  $('.campo21ddw-ff').find('.select2-choice').css('border-color','red');
                  faltantesFF = faltantesFF + '<b>- '+$('select.campo21ddw-ff')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo21ddw-ff').find('.select2-choice').css('border-color','');
              }
              //Pregunta: campo24ddw-ff
              if($('.campo24ddw-ff').select2('val') == ''){
                  $('.campo24ddw-ff').find('.select2-choice').css('border-color','red');
                  faltantesFF = faltantesFF + '<b>- '+$('select.campo24ddw-ff')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo24ddw-ff').find('.select2-choice').css('border-color','');
              }
              //Pregunta: campo6ddw-ff
              if($('.campo6ddw-ff').select2('val') == ''){
                  $('.campo6ddw-ff').find('.select2-choice').css('border-color','red');
                  faltantesFF = faltantesFF + '<b>- '+$('select.campo6ddw-ff')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo6ddw-ff').find('.select2-choice').css('border-color','');
              }*/
              //Pregunta: campo17txt-ff
              if($('.campo17txt-ff').val() == '' && $('.campo14chk-ff')[0].checked){
                  $('.campo17txt-ff').css('border-color','red');
                  faltantesFF = faltantesFF + '<b>- '+$('.campo17txt-ff')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo17txt-ff').css('border-color','');
              }
          }
          //Valida campos para CA
          if (App.user.attributes.tipodeproducto_c == '3') {
              //Pregunta: campo2ddw-ca
             /* if($('.campo2ddw-ca').select2('val') == '' && this.model.get('tipodepersona_c') != 'Persona Moral'){
                  $('.campo2ddw-ca').find('.select2-choice').css('border-color','red');
                  faltantesCA = faltantesCA + '<b>- '+$('select.campo2ddw-ca')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo2ddw-ca').find('.select2-choice').css('border-color','');
              }*/
              //Pregunta: campo3rel-ca
              if($('.campo3rel-ca')[0]['innerText'] == '' && this.model.get('tipodepersona_c') != 'Persona Moral' && $('.campo2ddw-ca').select2('val')=='2'){
                  $('.campo3rel-ca').find('.select2-choice').css('border-color','red');
                  faltantesCA = faltantesCA + '<b>- '+$('.campo3rel-ca')[1].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo3rel-ca').find('.select2-choice').css('border-color','');
              }
              //Pregunta: campo4ddw-ca
             /* if($('.campo4ddw-ca').select2('val') == ''){
                  $('.campo4ddw-ca').find('.select2-choice').css('border-color','red');
                  faltantesCA = faltantesCA + '<b>- '+$('select.campo4ddw-ca')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo4ddw-ca').find('.select2-choice').css('border-color','');
              }*/
              //Pregunta: campo5rel-ca
              if($('.campo5rel-ca')[0]['innerText'] == '' && $('.campo4ddw-ca').select2('val')=='2'){
                  $('.campo5rel-ca').find('.select2-choice').css('border-color','red');
                  faltantesCA = faltantesCA + '<b>- '+$('.campo5rel-ca')[1].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo5rel-ca').find('.select2-choice').css('border-color','');
              }
              //Pregunta: campo6ddw-ca
             /* if($('.campo6ddw-ca').select2('val') == ''){
                  $('.campo6ddw-ca').find('.select2-choice').css('border-color','red');
                  faltantesCA = faltantesCA + '<b>- '+$('select.campo6ddw-ca')[0].getAttribute('data-name')+'<br></b>';
              }else{
                  $('.campo6ddw-ca').find('.select2-choice').css('border-color','');
              }*/
          }

          //Genera alertas
          if(faltantesAP != ""){
              errors['PreguntasAP'] = "";
              errors['PreguntasAP'].required = true;
              app.alert.show("faltantesAP", {
                  level: "error",
                  title: "PLD Arrendamiento puro - Faltan las siguientes preguntas por contestar: <br>" + faltantesAP
              });
          }

          if(faltantesFF != ""){
              errors['PreguntasFF'] = "";
              errors['PreguntasFF'].required = true;
              app.alert.show("faltantesFF", {
                  level: "error",
                  title: "PLD Factoraje financiero - Faltan las siguientes preguntas por contestar: <br>" + faltantesFF
              });
          }

          if(faltantesCA != ""){
              errors['PreguntasCA'] = "";
              errors['PreguntasCA'].required = true;
              app.alert.show("faltantesCA", {
                  level: "error",
                  title: "PLD Crédito automotriz - Faltan las siguientes preguntas por contestar: <br>" + faltantesCA
              });
          }
        }

        callback(null, fields, errors);
    },

    saveProdPLD:function (fields, errors, callback) {
        if (this.model.get('tipo_registro_c') != 'Persona') {
          // Actualizar modelo de pld.ProductosPLD
          var ProductosPLD = {
              'arrendamientoPuro' : {
              },
              'factorajeFinanciero' : {
              },
              'creditoAutomotriz' : {
              },
              'creditoSimple' : {
              }
          };
          // ProductosPLD.arrendamientoPuro.campo1 = $('.campo1txt-ap').val();
          ProductosPLD.arrendamientoPuro.campo2 = $('.campo2ddw-ap').select2('val');
          ProductosPLD.arrendamientoPuro.campo3 = $('.campo3rel-ap')[0]['innerText'];
          ProductosPLD.arrendamientoPuro.campo3_id = $('.campo3rel-ap').select2('val');
          ProductosPLD.arrendamientoPuro.campo4 = $('.campo4ddw-ap').select2('val');
        //ProductosPLD.arrendamientoPuro.campo5 = $('.campo5rel-ap')[0]['innerText'];
        //ProductosPLD.arrendamientoPuro.campo5_id = $('.campo5rel-ap').select2('val');
          ProductosPLD.arrendamientoPuro.campo6 = $('.campo6ddw-ap').select2('val');
          // ProductosPLD.arrendamientoPuro.campo7 = $('.campo7ddw-ap').select2('val');
          // ProductosPLD.arrendamientoPuro.campo8 = $('.campo8txt-ap').val();
          // ProductosPLD.arrendamientoPuro.campo9 = $('.campo9ddw-ap').select2('val');
          // ProductosPLD.arrendamientoPuro.campo10 = $('.campo10txt-ap').val();
          ProductosPLD.arrendamientoPuro.campo11 = $('.campo11ddw-ap').select2('val');
          //ProductosPLD.arrendamientoPuro.campo13 = $('.campo13chk-ap')[0].checked;
          ProductosPLD.arrendamientoPuro.campo14 = $('.campo14chk-ap')[0].checked;
          ProductosPLD.arrendamientoPuro.campo16 = $('.campo16ddw-ap').select2('val').toString();
          ProductosPLD.arrendamientoPuro.campo17 = $('.campo17txt-ap').val();
          ProductosPLD.arrendamientoPuro.campo25 = $('.campo25ddw-ap').select2('val');
          ProductosPLD.arrendamientoPuro.campo26 = $('.campo26txt-ap').val();
          // ProductosPLD.factorajeFinanciero.campo1 = $('.campo1txt-ff').val();
          ProductosPLD.factorajeFinanciero.campo2 = $('.campo2ddw-ff').select2('val');
          ProductosPLD.factorajeFinanciero.campo3 = $('.campo3rel-ff').val();
          ProductosPLD.factorajeFinanciero.campo3_id = $('.campo3rel-ff').select2('val');
          ProductosPLD.factorajeFinanciero.campo4 = $('.campo4ddw-ff').select2('val');
        //ProductosPLD.factorajeFinanciero.campo5 = $('.campo5rel-ff').val();
        //ProductosPLD.factorajeFinanciero.campo5_id = $('.campo5rel-ff').select2('val');
          ProductosPLD.factorajeFinanciero.campo21 = $('.campo21ddw-ff').select2('val');
          ProductosPLD.factorajeFinanciero.campo22 = $('.campo22int-ff').val();
          ProductosPLD.factorajeFinanciero.campo23 = $('.campo23dec-ff').val();
          ProductosPLD.factorajeFinanciero.campo16 = $('.campo16ddw-ff').select2('val').toString();
          ProductosPLD.factorajeFinanciero.campo17 = $('.campo17txt-ff').val();
          ProductosPLD.factorajeFinanciero.campo14 = $('.campo14chk-ff')[0].checked;
          ProductosPLD.factorajeFinanciero.campo24 = $('.campo24ddw-ff').select2('val');
          ProductosPLD.factorajeFinanciero.campo6 = $('.campo6ddw-ff').select2('val');
          //  ProductosPLD.creditoAutomotriz.campo1 = $('.campo1txt-ca').val();
          ProductosPLD.creditoAutomotriz.campo2 = $('.campo2ddw-ca').select2('val');
          ProductosPLD.creditoAutomotriz.campo3 = $('.campo3rel-ca').val();
          ProductosPLD.creditoAutomotriz.campo3_id = $('.campo3rel-ca').select2('val');
          ProductosPLD.creditoAutomotriz.campo4 = $('.campo4ddw-ca').select2('val');
        //ProductosPLD.creditoAutomotriz.campo5 = $('.campo5rel-ca').val();
        //ProductosPLD.creditoAutomotriz.campo5_id = $('.campo5rel-ca').select2('val');
          ProductosPLD.creditoAutomotriz.campo6 = $('.campo6ddw-ca').select2('val');
          // ProductosPLD.creditoSimple.campo1 = $('.campo1txt-cs').val();
          ProductosPLD.creditoSimple.campo2 = $('.campo2ddw-cs').select2('val');
          ProductosPLD.creditoSimple.campo3 = $('.campo3rel-cs').val();
          ProductosPLD.creditoSimple.campo3_id = $('.campo3rel-cs').select2('val');
          ProductosPLD.creditoSimple.campo4 = $('.campo4ddw-cs').select2('val');
        //ProductosPLD.creditoSimple.campo5 = $('.campo5rel-cs').val();
        //ProductosPLD.creditoSimple.campo5_id = $('.campo5rel-cs').select2('val');
          ProductosPLD.creditoSimple.campo18 = $('.campo18ddw-cs').select2('val').toString();
          ProductosPLD.creditoSimple.campo19 = $('.campo19txt-cs').val();
          ProductosPLD.creditoSimple.campo14 = $('.campo14chk-cs')[0].checked;
          ProductosPLD.creditoSimple.campo20 = $('.campo20ddw-cs').select2('val');
          ProductosPLD.creditoSimple.campo6 = $('.campo6ddw-cs').select2('val');

          if ($.isEmptyObject(errors))
          {
            contexto_cuenta.ProductosPLD = pld.formatDetailPLD(ProductosPLD);
            this.model.set('tct_nuevo_pld_c', JSON.stringify(ProductosPLD));
            this.ProductosPLD = ProductosPLD;
            pld.ProductosPLD = this.ProductosPLD;
            pld.render();
          }
        }
        callback(null,fields,errors);
    },

    keyDownNewExtension: function (evt) {
        if (!evt) return;
        if(!this.validanumeros(evt)){
            return false;
        }
    },
    validanumeros:function(evt){
        if($.inArray(evt.keyCode,[110,188,45,33,36,35,34,8,9,20,16,17,37,40,39,38,16,49,50,51,52,53,54,55,56,57,48,96,97,98,99,100,101,102,103,104,105]) < 0) {
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

    validacantidades: function (fields, errors, callback){
        if ($('.campo23dec-ff').val() != "" && $('.campo23dec-ff').val() != undefined &&  $('.campo23dec-ff').val() <= 0 ) {
                    app.alert.show("Valor Invalido", {
                        level: "error",
                        title: "Solo n\u00FAmeros son permitidos en este campo.",
                        autoClose: true
                    });
                errors['campo23dec-ff'] = "El campo Número de pagos no debe tener un valor mayor a 0.";
                errors['campo23dec-ff'].required = true;
            }
        if ($('.campo22int-ff').val() != "" && $('.campo22int-ff').val() != undefined &&  $('.campo22int-ff').val() <= 0 ) {
            app.alert.show("Valor Invalido", {
                level: "error",
                title: "Solo n\u00FAmeros son permitidos en este campo.",
                autoClose: true
            });
            errors['campo22int-ff'] = "El campo Monto total aproximado no debe tener un valor mayor a 0.";
            errors['campo22int-ff'].required = true;
        }

            callback(null,fields,errors);
    },

    ocultaRFC: function () {
        if (this.model.get('tct_pais_expide_rfc_c')!="2" ){
            this.$('[data-name="generar_rfc_c"]').attr('style', 'pointer-events:none;');
        }else{
            this.$('[data-name="generar_rfc_c"]').attr('style', 'pointer-events:block;');
        }

    },

    RequeridosProveedorRecursos: function (fields, errors, callback){
        var RequeridosProvRec = "";
        if (this.model.get('tipo_relacion_c').includes('Proveedor de Recursos L') || this.model.get('tipo_relacion_c').includes('Proveedor de Recursos F') || this.model.get('tipo_relacion_c').includes('Proveedor de Recursos CA')) {

            if (this.model.get('tipodepersona_c') == "Persona Fisica" || this.model.get('tipodepersona_c') == "Persona Fisica con Actividad Empresarial") {

                /*if (this.model.get('primernombre_c') == "") {
                    RequeridosProvRec = RequeridosProvRec + '<b>-Nombre<br></b>';
                }
                if (this.model.get('apellidopaterno_c') == "") {
                    RequeridosProvRec = RequeridosProvRec + '<b>-Apellido Paterno<br></b>';
                }*/
                if (this.model.get('apellidomaterno_c') == "" || this.model.get('apellidomaterno_c') == undefined) {
                    RequeridosProvRec = RequeridosProvRec + '<b>-Apellido Materno<br></b>';
                    $('[name=apellidomaterno_c]').css('border-color', 'red');
                }
                if (this.model.get('fechadenacimiento_c') == "" || this.model.get('fechadenacimiento_c') == undefined) {
                    RequeridosProvRec = RequeridosProvRec + '<b>-Fecha de Nacimiento<br></b>';
                    $('[name=fechadenacimiento_c]').css('border-color', 'red');
                }
                if (this.model.get('nacionalidad_c') == "0" || this.model.get('nacionalidad_c') == undefined) {
                    RequeridosProvRec = RequeridosProvRec + '<b>-Nacionalidad<br></b>';
                    $('[data-name=nacionalidad_c]').find('.select2-choice').css('border-color','red');
                }
                if (this.model.get('tct_macro_sector_ddw_c') == "" || this.model.get('tct_macro_sector_ddw_c')== null || this.model.get('tct_macro_sector_ddw_c')== undefined) {
                    RequeridosProvRec = RequeridosProvRec + '<b>-Macro Sector<br></b>';
                    $('[data-name=tct_macro_sector_ddw_c]').find('.select2-choice').css('border-color','red');
                }
                if (this.model.get('sectoreconomico_c') == "") {
                    RequeridosProvRec = RequeridosProvRec + '<b>-Sector Económico<br></b>';
                    $('[name=sectoreconomico_c]').css('border-color', 'red');
                }
                if (this.model.get('subsectoreconomico_c') == "") {
                    RequeridosProvRec = RequeridosProvRec + '<b>-Subsector Económico<br></b>';
                    $('[name=subsectoreconomico_c]').css('border-color', 'red');
                }
                if (this.model.get('actividadeconomica_c') == "") {
                    RequeridosProvRec = RequeridosProvRec + '<b>-Actividad Económica<br></b>';
                    $('[name=actividadeconomica_c]').css('border-color', 'red');
                }
                var direcciones= 0;
                var tipodireccion= this.oDirecciones.direccion;
                if (tipodireccion.length > 0) {
                    for(var i=0;i<tipodireccion.length;i++){
                        if(tipodireccion[i].tipodedireccion.includes("1") || tipodireccion[i].tipodedireccion.includes("3") || tipodireccion[i].tipodedireccion.includes("5") || tipodireccion[i].tipodedireccion.includes("7")){
                            direcciones++;
                        }
                    }
                }
                if (direcciones==0){
                    RequeridosProvRec = RequeridosProvRec + '<b>-Dirección Particular<br></b>';
                    $('.direcciondashlet').css('border-color', 'red');

                }
                if ((this.model.get('rfc_c') == undefined ||this.model.get('rfc_c') == "") && (this.model.get('curp_c') == "" || this.model.get('curp_c')== undefined) && (this.model.get('ctpldnoseriefiel_c') == "" || this.model.get('ctpldnoseriefiel_c') == undefined)) {
                    RequeridosProvRec = RequeridosProvRec + '<b><br>Al menos la captura de alguno de estos campos:<br><br>-RFC<br>-CURP<br>-Firma Electrónica Avanzada<br><br></b>';
                    $('[name=rfc_c]').css('border-color', 'red');
                    $('[name=curp_c]').css('border-color', 'red');
                    $('[name=ctpldnoseriefiel_c]').css('border-color', 'red');
                }

                if (RequeridosProvRec != "") {
                    app.alert.show("Campos faltantes en cuenta", {
                        level: "error",
                        messages: 'Hace falta completar la siguiente información en la cuenta para una relación tipo <b>Proveedor de Recursos</b>:<br> ' + RequeridosProvRec,
                        autoClose: false
                    });
                    errors['faltantescuenta'] = errors['faltantescuenta'] || {};
                    errors['faltantescuenta'].required = true;

                }
                callback(null, fields, errors);
            }

            if (this.model.get('tipodepersona_c') == "Persona Moral") {
                /*if (this.model.get('razonsocial_c') == "") {
                    RequeridosProvRec = RequeridosProvRec + '<b>-Denominación o Razón Social<br></b>';
                }*/
                if (this.model.get('nacionalidad_c') == "0" || this.model.get('nacionalidad_c') == undefined) {
                    RequeridosProvRec = RequeridosProvRec + '<b>-Nacionalidad<br></b>';
                    $('[data-name=nacionalidad_c]').find('.select2-choice').css('border-color','red');
                }
                if (this.model.get('rfc_c') == "" || this.model.get('rfc_c') == undefined) {
                    RequeridosProvRec = RequeridosProvRec + '<b>-RFC<br></b>';
                    $('[name=rfc_c]').css('border-color', 'red');
                }
                var direccionesm= 0;
                var tipodireccion= this.oDirecciones.direccion;
                if (tipodireccion.length > 0) {
                    direccionesm++;
                }
                if (direccionesm==0){
                    RequeridosProvRec = RequeridosProvRec + '<b>-Domicilio<br></b>';
                    $('.direcciondashlet').css('border-color', 'red');

                }

                if (RequeridosProvRec != "") {
                    app.alert.show("Campos faltantes en cuenta", {
                        level: "error",
                        messages: 'Hace falta completar la siguiente información en la cuenta para una relación tipo <b>Proveedor de Recursos</b>:<br> ' + RequeridosProvRec,
                        autoClose: false
                    });
                    errors['errorpersonamoral'] = errors['errorpersonamoral'] || {};
                    errors['errorpersonamoral'].required = true;

                }
                callback(null, fields, errors);
            }
        }else {
            callback(null, fields, errors);
        }

    },

    quitaanos: function(){
        var anoactual = ((new Date).getFullYear());
        var anoactual5= anoactual-5
        var lista= App.lang.getAppListStrings('ano_ventas_ddw_list');
        Object.keys(lista).forEach(function(key){
            //Quita años previos
            if(key < anoactual5){
                delete lista[key];
            }
            //Quita años futuros al actual
            if(key > anoactual){
                delete lista[key];
            }
        });
        this.model.fields['tct_ano_ventas_ddw_c'].options = lista;
    },

    setCustomFields:function (fields, errors, callback){
        //Teléfonos
        this.model.set('account_telefonos',this.oTelefonos.telefono);
        //Direcciones
        this.model.set('account_direcciones',this.oDirecciones.direccion);

        callback(null, fields, errors);
    },

    validaformato: function (fields, errors, callback) {
        //Validacion para pasar una expresion regular por los 3 campos y verificar dicho formato.
        var errorescampos="";
       if (this.model.get('primernombre_c')!="" || this.model.get('apellidopaterno_c')!="" || this.model.get('apellidomaterno_c')!="") {
           var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
           if (this.model.get('primernombre_c')!="" && this.model.get('primernombre_c')!= undefined){
               var nombre=this.model.get('primernombre_c');
               var res = expresion.test(nombre);
               if(res!= true){
                   errorescampos= errorescampos + '<b>-Primer Nombre<br></b>'; ;
                   errors['primernombre_c'] = errors['primernombre_c'] || {};
                   errors['primernombre_c'].required = true;
               }
           }
           if (this.model.get('apellidopaterno_c')!="" && this.model.get('apellidopaterno_c')!= undefined){
               var apaterno=this.model.get('apellidopaterno_c');
               var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
               var res = expresion.test(apaterno);
               if(res!= true){
                   errorescampos= errorescampos + '<b>-Apellido Paterno<br></b>'; ;
                   errors['apellidopaterno_c'] = errors['apellidopaterno_c'] || {};
                   errors['apellidopaterno_c'].required = true;
               }
           }
           if (this.model.get('apellidomaterno_c')!="" && this.model.get('apellidomaterno_c')!= undefined){
               var amaterno=this.model.get('apellidomaterno_c');
               var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
               var res = expresion.test(amaterno);
               if(res!= true){
                   errorescampos= errorescampos + '<b>-Apellido Materno<br></b>'; ;
                   errors['apellidomaterno_c'] = errors['apellidomaterno_c'] || {};
                   errors['apellidomaterno_c'].required = true;
               }
           }
           if (errorescampos){
               app.alert.show("Error_validacion_Campos", {
                   level: "error",
                   messages: 'Los siguientes campos no permiten caracteres especiales:<br>' + errorescampos,
                   autoClose: false
               });
           }
       }
        callback(null, fields, errors);
    },

    cambiaCliente: function (){
        //Funcion que habilita la opcion credito simple al cambiar el tipo de registro (en tipo Cliente).
        if (this.model.get('tipo_registro_c')=="Cliente" && App.user.attributes.tct_alta_credito_simple_chk_c == 1){
                this.model.fields['subtipo_cuenta_c'].options="Credito Simple";
                this.model.set("subtipo_cuenta_c", 'Credito Simple');
      }
    },

    validapasscurp: function (fields, errors, callback){
        if (this.model.get('ifepasaporte_c')!="" || this.model.get('curp_c')!="") {
            var campoPass = "";
            var expresion = new RegExp(/^[0-9a-zA-Z]+$/g);
            if (this.model.get('ifepasaporte_c') != "" && this.model.get('ifepasaporte_c') != undefined) {
                var nombre = this.model.get('ifepasaporte_c');
                var comprueba = expresion.test(nombre);
                if (comprueba != true) {
                    campoPass = campoPass + '<b>-IFE/Pasaporte<br></b>';
                    errors['ifepasaporte_c'] = errors['ifepasaporte_c'] || {};
                    errors['ifepasaporte_c'].required = true;
                }
            }
            if (this.model.get('curp_c') != "" && this.model.get('curp_c') != undefined) {
                var expresionC = new RegExp(/^[0-9a-zA-Z]+$/g);
                var curp = this.model.get('curp_c');
                var comprueba = expresionC.test(curp);
                if (comprueba != true) {
                    campoPass = campoPass + '<b>-CURP<br></b>';
                    errors['curp_c'] = errors['curp_c'] || {};
                    errors['curp_c'].required = true;
                }
            }
            if (campoPass) {
                app.alert.show("Error_validacion_Passport", {
                    level: "error",
                    messages: 'Los siguientes campos no permiten caracteres especiales:<br>' + campoPass,
                    autoClose: false
                });
            }
        }
        callback(null, fields, errors);
    },

    validaiva:function (fields, errors, callback){
        if (this.model.get('tipo_registro_c')=="Proveedor" || this.model.get('esproveedor_c')== true) {
            if (this.model.get('iva_c') !== "" && this.model.get('iva_c') != undefined && (Number(this.model.get('iva_c')) <= 0 || Number(this.model.get('iva_c')) > 100.00)) {
                if (parseFloat(this.model.get('iva_c')) <= 0.0000) {
                    errors['iva_c'] = errors['iva_c'] || {};
                    errors['iva_c'].required = true;

                    app.alert.show("Iva_mayor_a_cero", {
                        level: "error",
                        messages: "El campo <b>% de IVA</b> debe ser mayor a cero.",
                        autoClose: false
                    });
                }
                // Valida valor mayor a 100
                if (parseFloat(this.model.get('iva_c')) > 100.00) {

                    errors['iva_c'] = errors['iva_c'] || {};
                    errors['iva_c'].required = true;

                    app.alert.show("Iva_menor_a_cero", {
                        level: "error",
                        messages: "El campo <b>% de IVA</b> debe ser menor o igual a cien.",
                        autoClose: false
                    });
                }
            }
        }
        callback(null, fields, errors);
    },
    nodigitos: function (fields, errors, callback) {
        if($('.campo1pa').val() != "" || $('.campo2pa').val() != "" || $('.campo3pa').val() != "" || $('.campo4pa').val() != "") {
            if ($('.campo1pa').val() !== "") {
                var expreg = /^[0-9]{1,10}$/;
                var num1 = $('.campo1pa').val();
                if (!expreg.test(num1)) {
                    $('.campo1pa').css('border-color', 'red');
                    app.alert.show('error-numero-potencial1', {
                        level: 'error',
                        autoClose: false,
                        messages: "El campo <b>Número de Autos Utilitarios</b> no acepta caracteres especiales."
                    });
                    errors['campo1apPotencial'] = errors['campo1apPotencial'] || {};
                    errors['campo1apPotencial'].required = true;
                }
            }
            if ($('.campo2pa').val() !== "") {
                var expreg = /^[0-9]{1,10}$/;
                var num2 = $('.campo2pa').val();
                if (!expreg.test(num2)) {
                    $('.campo2pa').css('border-color', 'red');
                    app.alert.show('error-numero-potencial2', {
                        level: 'error',
                        autoClose: false,
                        messages: "El campo <b>Número de Autos Ejecutivos</b> no acepta caracteres especiales."
                    });
                    errors['campo2apPotencial'] = errors['campo2apPotencial'] || {};
                    errors['campo2apPotencial'].required = true;
                }
            }
            if ($('.campo3pa').val() !== "") {
                var expreg = /^[0-9]{1,10}$/;
                var num3 = $('.campo3pa').val();
                if (!expreg.test(num3)) {
                    $('.campo3pa').css('border-color', 'red');
                    app.alert.show('error-numero-potencial3', {
                        level: 'error',
                        autoClose: false,
                        messages: "El campo <b>Número de Motos</b> no acepta caracteres especiales."
                    });
                    errors['campo3apPotencial'] = errors['campo3apPotencial'] || {};
                    errors['campo3apPotencial'].required = true;
                }
            }
            if ($('.campo4pa').val() !== "") {
                var expreg = /^[0-9]{1,10}$/;
                var num4 = $('.campo4pa').val();
                if (!expreg.test(num4)) {
                    $('.campo4pa').css('border-color', 'red');
                    app.alert.show('error-numero-potencial4', {
                        level: 'error',
                        autoClose: false,
                        messages: "El campo <b>Número de Camiones</b> no acepta caracteres especiales."
                    });
                    errors['campo4apPotencial'] = errors['campo4apPotencial'] || {};
                    errors['campo4apPotencial'].required = true;
                }
            }
        }
        callback(null, fields, errors);
    },

    savepotauto: function (fields, errors, callback){
        var PotencialAutos = {};
        PotencialAutos.autos= {};
        PotencialAutos.autos.tct_no_autos_u_int_c = this.$('.campo1pa').val();
        PotencialAutos.autos.tct_no_autos_e_int_c = this.$('.campo2pa').val();
        PotencialAutos.autos.tct_no_motos_int_c = this.$('.campo3pa').val();
        PotencialAutos.autos.tct_no_camiones_int_c = this.$('.campo4pa').val();

        if ($.isEmptyObject(errors))  {
            this.model.set('potencial_autos', JSON.stringify(PotencialAutos));
            this.Pautos = PotencialAutos;
            Pautos.render();
        }
        callback(null,fields,errors);
    },

    /*Función para asignar los promotes por default a la cuenta, con base en los productos del usuario logueado.*/
    promotores_default: function (){
        
        var userprod= App.user.attributes.productos_c;
        var nombrecompleto= App.user.attributes.full_name;
        var idusrlog= App.user.attributes.id;

                if (userprod.includes('1')) {
                    this.model.set('promotorleasing_c', nombrecompleto);
                    this.model.set('user_id_c', idusrlog);
                } else {
                    this.model.set('promotorleasing_c', '9 - Sin Gestor');
                    this.model.set('user_id_c', '569246c7-da62-4664-ef2a-5628f649537e');
                }
                if (userprod.includes('4')) {
                    this.model.set('promotorfactoraje_c', nombrecompleto);
                    this.model.set('user_id1_c', idusrlog);
                } else {
                    this.model.set('promotorfactoraje_c', '9 - Sin Gestor');
                    this.model.set('user_id1_c', '569246c7-da62-4664-ef2a-5628f649537e');
                }
                if (userprod.includes('3')) {
                    this.model.set('promotorcredit_c', nombrecompleto);
                    this.model.set('user_id2_c', idusrlog);
                } else {
                    this.model.set('promotorcredit_c', '9 - Sin Gestor');
                    this.model.set('user_id2_c', '569246c7-da62-4664-ef2a-5628f649537e');
                }
                if (userprod.includes('6')) {
                    this.model.set('promotorfleet_c', nombrecompleto);
                    this.model.set('user_id6_c', idusrlog);
                } else {
                    this.model.set('promotorfleet_c', '9 - Sin Gestor');
                    this.model.set('user_id6_c', '569246c7-da62-4664-ef2a-5628f649537e');
                }
                if (userprod.includes('8')) {
                    this.model.set('promotoruniclick_c', nombrecompleto);
                    this.model.set('user_id7_c', idusrlog);
                } else {
                    this.model.set('promotoruniclick_c', '9 - Sin Gestor');
                    this.model.set('user_id7_c', '569246c7-da62-4664-ef2a-5628f649537e');
                }
    },
	
})
