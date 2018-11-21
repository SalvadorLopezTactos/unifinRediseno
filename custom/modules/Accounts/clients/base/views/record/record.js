({
    extendsFrom: 'RecordView',

    /**
     * @author bdekoning@levementum.com
     * @date 6/9/15
     * @brief Override for handleCancel to ensure the account_telefonos attribute is properly reverted
     *
     * @override
     */

	oculta : 0,

    initialize: function (options) {
        self = this;
        self.hasContratosActivos = false;
        this._super("initialize", [options]);

        this.duplicadosName = 0;
        this.duplicadosRFC = 0;
        this.totalllamadas = 0;
        this.totalreuniones = 0;
        this.flagheld=0;

        //add validation tasks
        this.model.addValidationTask('duplicate_check', _.bind(this.DuplicateCheck, this));
        this.model.addValidationTask('check_email_telefono', _.bind(this._doValidateEmailTelefono, this));
        this.model.addValidationTask('check_telefonos', _.bind(this.validatelefonos, this));
        this.model.addValidationTask('check_rfc', _.bind(this._doValidateRFC, this));
        this.model.addValidationTask('check_fecha_de_nacimiento', _.bind(this._doValidateMayoriadeEdad, this));
        this.model.addValidationTask('check_account_direcciones', _.bind(this._doValidateDireccion, this));
        this.model.addValidationTask('check_account_direccionesCP', _.bind(this._doValidateDireccionCP, this));
        //this.model.addValidationTask('check_Tiene_Contactos', _.bind(this._doValidateTieneContactos, this));
        this.model.addValidationTask('check_1900_year', _.bind(this.fechaMenor1900, this));
        this.model.addValidationTask('fechadenacimiento_c', _.bind(this.doValidateDateNac, this));
        this.model.addValidationTask('fechaconstitutiva_c', _.bind(this.doValidateDateCons, this));
        this.model.addValidationTask('verificaRiesgoPep', _.bind(this.cambiaRiesgodePersona, this));
        this.model.addValidationTask('tipo_proveedor_requerido', _.bind(this.validaProveedorRequerido, this));
        this.model.addValidationTask('check_info', _.bind(this.doValidateInfoReq, this));
        this.model.addValidationTask('macrosector', _.bind(this.macrosector, this));
        this.model.addValidationTask('sectoreconomico', _.bind(this.sectoreconomico, this));
        this.model.addValidationTask('checkEmptyFieldsDire', _.bind(this.validadirecc, this));
        this.model.addValidationTask('change:email', _.bind(this.expmail, this));
        //Valida que el campo Alta Cedente este check en el perfil del usuario. Adrian Arauz 20/09/2018
        this.model.addValidationTask('check_alta_cedente', _.bind(this.validacedente, this));
        /*Funcion para validar los campos ventas anuales y activo fijo al editar una cuenta de tipo
        * Integración de Expediente
        * Adrian Arauz 4/10/2018
        * */
        this.model.addValidationTask('valida_potencial',_.bind(this.validapotencial, this));

        /*
         Eduardo Carrasco
         revisa que la persona no tenga contratos existentes despues de cambiar el RFC. Si hay contratos existentes, no se podra cambiar el RFC
        */
        this.model.on("change:rfc_c", _.bind(function () {
            var rfc = this.getField('rfc_c');
            if (!_.isEmpty(this.model.get('idcliente_c')) && rfc.action === "edit") {
                app.api.call("read", app.api.buildURL("Accounts/AccountsCustomAPI/" + this.model.get('idcliente_c'), null, null, {}), null, {
                    success: _.bind(function (data) {
                        if (data.UNI2_CTE_029_VerificaClienteTieneContratoResult._tieneContratos == true) {
                            app.alert.show("Validar Contratos", {
                                level: "error",
                                title: "No puede cambiar RFC a Cliente con contratos existentes.",
                                autoClose: false
                            });
                            this.cancelClicked();
                            this.$("input[name='rfc_c']").prop("readonly", true);
                        }
                    }, this)
                });
            }
            this.RFC_DuplicateCheck();
        }, this));

        /*
         Salvador Lopez
         Se añaden eventos change para mostrar teléfonos y direcciones al vincular o desvincular algún registro relacionado
         */
        this.model.on('change:account_telefonos', this.refresca, this);
        this.model.on('change:tipodepersona_c', this._ActualizaEtiquetas, this);
        this.model.on('change:profesion_c', this._doValidateProfesionRisk, this);
        this.model.on('change:pais_nacimiento_c', this._doValidateProfesionRisk, this);
        this.model.on('change:origendelprospecto_c', this.changeLabelMarketing, this);

        //Se añade función para establecer phone_office
        this.model.on('change:account_telefonos', this.setPhoneOffice, this);
        /*
         AF - 26/12/17
         Ajuste: Ocultar campo dependiente de multiselect "¿Instrumento monetario con el que espera realizar los pagos?"
         */
        //this.changeInstMonetario();
        this.model.on('change:tct_inst_monetario_c', this.changeInstMonetario, this);

        /*
         Salvador Lopez
         Se añaden eventos change para mostrar u ocultar paneles
         */
        this.model.on('change:tct_fedeicomiso_chk_c', this._hideFideicomiso, this);
        this.model.on('change:tipodepersona_c', this._hidePeps, this);

        this.events['keydown input[name=primernombre_c]'] = 'checkTextOnly';
        this.events['keydown input[name=segundonombre_c]'] = 'checkTextOnly';
        this.events['keydown input[name=apellidomaterno_c]'] = 'checkTextOnly';
        this.events['keydown input[name=apellidopaterno_c]'] = 'checkTextOnly';
        this.events['keydown input[name=ifepasaporte_c]'] = 'checkTextAndNum';
        this.events['keydown input[name=rfc_c]'] = 'checkTextAndNumRFC';

        this.events['click a[name=generar_rfc_c]'] = '_doGenera_RFC_CURP';
        this.events['click a[name=generar_curp_c]'] = '_doGeneraCURP';


        /* LEV INICIO */
        /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 7/14/2015 Description: Cuando estamos en el modulo de Personas, no queremos que se muestre la opcion Persona para el tipo de registro */

        /*
         self.model.on("change", function() {
         if (self.model.get('tipo_registro_c') != null){
         if(self.model.get('tipo_registro_c') != 'Persona') {
         var new_options = app.lang.getAppListStrings('tipo_registro_list');
         Object.keys(new_options).forEach(function (key) {
         if (key == "Persona") {
         delete new_options[key];
         }
         });

         self.model.fields['tipo_registro_c'].options = new_options;
         }

         }
         });
         */
        /* LEV FIN */

        this.model.on('change:name', this.cleanName, this);

        /*
         AF. 12-02-2018
         Ajuste para mostrar direcciones y teléfonos
         */
        this.model.on('sync', this._render, this);
        this.model.on('sync', this.hideconfiinfo, this);
        this.model.on('sync', this.disable_panels_rol, this); //@Jesus Carrilllo; metodo que deshabilita panels de acuerdo a rol;
        this.model.on('sync', this.disable_panels_team, this);
        this.model.on('sync', this.fulminantcolor, this); //*@Jesus Carrillo; Funcion que pinta de color los paneles relacionados
        this.model.on('sync', this.valida_centro_prospec, this);
        this.model.on('sync', this.valida_backoffice, this);
        //this.model.on('sync', this.checkTelNorepeat, this);

        //Funcion para eliminar duplicados de arrays
        Array.prototype.unique=function(a){
            return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
        });

        // validación de los campos con formato númerico
        this.events['keydown [name=ventas_anuales_c]'] = 'checkInVentas';
        this.events['keydown [name=activo_fijo_c]'] = 'checkInVentas';

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



    fulminantcolor: function () {
        $( '#space' ).remove();
        $('.control-group').before('<div id="space" style="background-color:#000042"><br></div>');
        $('.control-group').css("background-color", "#e5e5e5");
        $('.a11y-wrapper').css("background-color", "#e5e5e5");
        //$('.a11y-wrapper').css("background-color", "#c6d9ff");
    },

    /*Victor Martinez Lopez 12-09-2018
    *La casilla proveedor se debe mantener activa al crear un proveedor
    * */
    checkProveedor:function(){
        if(this.model.get('tipo_registro_c')=='Proveedor'){
            this.$('[data-name="esproveedor_c"]').attr('style', 'pointer-events:none;');
        }
    },
    /** BEGIN CUSTOMIZATION:
     * Salvador Lopez 19/01/2018
     * Descripción: Función que oculta o muestra panel de fideicomiso dependiendo el valor de check ¿Es Fideicomisio? */

    _hideVista360: function () {
        if (this.model.get('show_panel_c') == true) {
            //Muestra vista 360
            //TabNav
            $("#recordTab>li.tab").removeClass('active');
            $('li.tab.LBL_RECORDVIEW_PANEL8').addClass("active");

            //Tabcontent
            $("#tabContent>div.tab-pane").addClass('fade')
            $("#tabContent>div.tab-pane").removeClass('active')
            $('#tabContent').children()[0].classList.add('active');
            $('#tabContent').children()[0].classList.remove('fade');


        } else {
            //Oculta vista 360
            //TabNav
            $("#recordTab>li.tab").removeClass('active');
            $('li.tab.panel_body').addClass("active");
            $('li.tab.LBL_RECORDVIEW_PANEL8').hide();

            //Tabcontent
            $("#tabContent>div.tab-pane").addClass('fade')
            $("#tabContent>div.tab-pane").removeClass('active')
            $('#tabContent').children()[1].classList.add('active');
            $('#tabContent').children()[1].classList.remove('fade');

        }

        //Oculta campo
        $("div[data-name='show_panel_c']").hide();
        // Se oculta el boton de mas opciones en las petañas de cuentas(record)
        $('.nav-tabs li a.dropdown-toggle').hide();
    },


    _hideFideicomiso: function (fields, errors, callback) {
        if (this.model.get('tct_fedeicomiso_chk_c')) {
            //Muestra
            this.$("li.tab.LBL_RECORDVIEW_PANEL2").show();

        } else {
            //Oculta
            this.$("li.tab.LBL_RECORDVIEW_PANEL2").hide();
        }
    },

    /** BEGIN CUSTOMIZATION:
     * Salvador Lopez 19/01/2018
     * Descripción: Función que oculta o muestra paneles de Peps según sea el valor de Tipo de Persona*/

    _hidePeps: function (fields, errors, callback) {

        if (this.model.get('tipodepersona_c') == "Persona Fisica" ||
            this.model.get('tipodepersona_c') == "Persona Fisica con Actividad Empresarial") {
            //Muestra Peps de Persona Física
            this.$("[data-panelname='LBL_RECORDVIEW_PANEL4']").show();
            this.$("[data-panelname='LBL_RECORDVIEW_PANEL5']").show();
            //Oculta Peps de Persona Moral
            this.$("[data-panelname='LBL_RECORDVIEW_PANEL7']").hide();
            this.$("[data-panelname='LBL_RECORDVIEW_PANEL6']").hide();
            //Oculta Propietario Real
            this.$("[data-panelname='LBL_RECORDVIEW_PANEL9']").hide();
        } else {
            //Oculta Peps de Persona Física
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

    readOnlyOrigen: function () {
        var origen = this.model.get('origendelprospecto_c');
        if (origen == "Marketing" || origen == "Inteligencia de Negocio") {

            //Establecer como solo lectura campos de origen y campos dependientes
            this.$("[data-name='origendelprospecto_c']").prop("disabled", true);
            this.$("[data-name='tct_detalle_origen_ddw_c']").prop("disabled", true);
            this.$("[data-name='tct_origen_base_ddw_c']").prop("disabled", true);
            this.$("[data-name='tct_origen_ag_tel_rel_c']").prop("disabled", true);
            this.$("[data-name='tct_origen_busqueda_txf_c']").prop("disabled", true);
            this.$("[data-name='medio_digital_c']").prop("disabled", true);
            this.$("[data-name='tct_punto_contacto_ddw_c']").prop("disabled", true);
            this.$("[data-name='evento_c']").prop("disabled", true);
            this.$("[data-name='camara_c']").prop("disabled", true);
            this.$("[data-name='tct_que_promotor_rel_c']").prop("disabled", true);
        }
    },

    /* BEGIN CUSTOMIZATION:
     * Salvador Lopez 21/02/2018
     * Refresca pantalla para mostrar telefonos y direcciones */
    refresca: function () {
        var telefonos = this.getField('account_telefonos');
        if (telefonos.action !== "edit") {
            this.render();
        }
    },

    borraTel: function () {
        var delids = window.ids;
        for (i = 0; i < delids.length; i++) {
            var idtel = delids[i];
            app.api.call('delete', app.api.buildURL('Tel_Telefonos/'+idtel), null, {
                success: _.bind(function (data) {
                    console.log('Esto es lo que devuelve la funcion borratel:');
                    console.log(data);
                    console.log(app.api.buildURL('Tel_Telefonos/'+idtel));
                },this),
                error: _.bind(function(error) {
                    console.log("Este fue el error:", error)
                }, this),
            });
        }
    },

    handleCancel: function () {
        var account_telefonos = this.model._previousAttributes.account_telefonos;
        var account_direcciones = this.model._previousAttributes.account_direcciones;
        this._super("handleCancel");
        this.model.set('account_telefonos', account_telefonos);
        this.model.set('account_direcciones', account_direcciones);
        this.model._previousAttributes.account_telefonos = account_telefonos;
        this.model._previousAttributes.account_direcciones = account_direcciones;
        this.render();
    },

    bindDataChange: function () {
        this._super("bindDataChange");
        //Si el registro es Persona Fisica, ya no se podra cambiar a Persona Moral
        this.model.on("change:tipodepersona_c", _.bind(function () {

            if (this.model._previousAttributes.tipodepersona_c == 'Persona Fisica') {
                if (this.model.get('tipodepersona_c') == 'Persona Moral') {
                    this.model.set('tipodepersona_c', 'Persona Fisica');
                }
            }
            if (this.model._previousAttributes.tipodepersona_c == 'Persona Fisica con Actividad Empresarial') {
                if (this.model.get('tipodepersona_c') == 'Persona Moral') {
                    this.model.set('tipodepersona_c', 'Persona Fisica con Actividad Empresarial');
                }
            }
            //Si es Persona Moral, ya no se podra cambiar a Persona Fisica
            if (this.model._previousAttributes.tipodepersona_c == 'Persona Moral') {
                if (this.model.get('tipodepersona_c') == 'Persona Fisica' || this.model.get('tipodepersona_c') == 'Persona Fisica con Actividad Empresarial') {
                    this.model.set('tipodepersona_c', 'Persona Moral');
                }
            }
        }, this));
    },

    _doValidateTieneContactos: function (fields, errors, callback) {
        if (this.model.get('tipodepersona_c') == "Persona Moral" && (/*this.model.get('tipo_registro_c') == "Cliente" || this.model.get('estatus_c') == "Interesado" || */this.model.get('tipo_registro_c') == "Prospecto")) {
            app.api.call("read", app.api.buildURL("Accounts/" + this.model.get('id') + "/link/rel_relaciones_accounts_1", null, null, {
                fields: name,
            }), null, {
                success: _.bind(function (data) {
                    var ContacFlag = false;

                    if (data.records.length > 0) {
                        $(data.records).each(function (index, value) {
                            if ($.inArray("Contacto", value.relaciones_activas) > -1) {
                                //YES IS A CONTACT!!!!
                                ContacFlag = true;
                            }
                        });
                    }

                    if (ContacFlag == false && _.isEmpty(this.model.get('account_contacts'))) {
                        app.alert.show("Cliente sin contactos registrados", {
                            level: "error",
                            title: "Debe registrar al menos un contacto para el cliente.",
                            autoClose: false
                        });
                        errors['account_contacts'] = errors['account_contacts'] || {};
                        errors['account_contacts'].required = true;
                    }
                }, this)
            });
        }
        callback(null, fields, errors);
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

    /**
     * Función para habilitar campos a solo lectura evaluando condiciones específicas
     */
    _renderHtml: function ()
    //Establecer todos los campos como solo lectura cuando el registro actual es el contacto genérico
    {
        var id = app.lang.getAppListStrings('tct_persona_generica_list');
        if (this.model.get('id') === id['accid'] && app.user.get('type') !== 'admin') {
            var self = this;
            _.each(this.model.fields, function (field) {
                self.noEditFields.push(field.name);
            });
        }

        /*
          @author Victo Martinez - 01/08/2018
          Deshabilita campos: Tipo de cuenta y subtipo de cuenta
        */
        this.noEditFields.push('subtipo_cuenta_c');
        this.noEditFields.push('tipo_registro_c');

        /*
         *
         * Salvador Lopez <salvador.lopez@tactos.com.mx>
         */
        //Establecer campos de promotores como solo lectura cuando el id_cliente_c ya ha sido llenado
        if (this.model.get('id') !== "") {
            var self = this;
            self.noEditFields.push('promotorleasing_c');
            self.noEditFields.push('promotorfactoraje_c');
            self.noEditFields.push('promotorcredit_c');
        }

        var origen = this.model.get('origendelprospecto_c');
        if (origen == "Marketing" || origen == "Inteligencia de Negocio") {
            var self = this;
            self.noEditFields.push('origendelprospecto_c');
            self.noEditFields.push('tct_detalle_origen_ddw_c');
            self.noEditFields.push('tct_origen_base_ddw_c');
            self.noEditFields.push('tct_origen_ag_tel_rel_c');
            self.noEditFields.push('tct_origen_busqueda_txf_c');
            self.noEditFields.push('medio_digital_c');
            self.noEditFields.push('tct_punto_contacto_ddw_c');
            self.noEditFields.push('evento_c');
            self.noEditFields.push('camara_c');
            self.noEditFields.push('tct_que_promotor_rel_c');
        }

        //Oculta menú lateral para relaciones
        $('[data-subpanel-link="rel_relaciones_accounts_1"]').find(".dropdown-toggle").hide();

        this._super('_renderHtml');
    },

    _render: function (options) {
        //Oculta menú lateral para relaciones
        $('[data-subpanel-link="rel_relaciones_accounts_1"]').find(".dropdown-toggle").hide();

        this._super("_render");

        /*
         @author Salvador Lopez
         Se llaman a la funciones para mostrar u ocultar paneles de Fideicomiso y Peps
         * */
        this._hideFideicomiso();
        this._hidePeps();

        // @author Salvador Lopez
        //Se manda a llamar función para omitir opción de Persona en ddw
        this.deleteOptionPersona();

        this._ActualizaEtiquetas();

        //@Jesus Carrillo
        //Ocultar Div y boton "Prospecto Contactado"
        $('div[data-name=tct_prospecto_contactado_chk_c]').hide();

        // Validación para no poder inactivar clientes con contratos activos
        if (this.model.dataFetched) {
            this.model.on("change:estatus_persona_c", _.bind(function () {
                if (this.model.get('estatus_persona_c') == "I" && this.model.get('idcliente_c')) {
                    //Si el Cliente con valor inactivo, verificar que no tenga contratos activos:
                    //se requiere el número de cliente
                    app.api.call("read", app.api.buildURL("Accounts/AccountsCustomAPI/" + this.model.get('idcliente_c'), null, null, {}), null, {
                        success: _.bind(function (data) {
                            if (data.UNI2_CTE_029_VerificaClienteTieneContratoResult._tieneContratos == true) {
                                app.alert.show("Validar Contratos", {
                                    level: "error",
                                    title: "No puedes inactivar clientes con contratos activos",
                                    autoClose: false
                                });
                                this.cancelClicked();
                            }
                        }, this)
                    });
                }
            }, this));
        }

        if (!_.isEmpty(this.model.get('idcliente_c'))) {
            app.api.call("read", app.api.buildURL("Accounts/AccountsCustomAPI/" + this.model.get('idcliente_c'), null, null, {}), null, {
                success: _.bind(function (data) {
                    /*
                     * @author Carlos Zaragoza
                     * Validar campos editables de persona cuando se trata de cliente con contratos activos (falta definición UNIFIN - Deben bloquearse RFC, Razón social /nombres y dirección fiscal)
                     * */
                    if (data.UNI2_CTE_029_VerificaClienteTieneContratoResult._tieneContratos == true) {
                        self.hasContratosActivos = true;
                        $('.record-edit-link-wrapper[data-name="rfc_c"]').remove();
                        $('.record-edit-link-wrapper[data-name="razonsocial_c"]').remove();
                        $('.record-edit-link-wrapper[data-name="primernombre_c"]').remove();
                        $('.record-edit-link-wrapper[data-name="segundonombre_c"]').remove();
                        $('.record-edit-link-wrapper[data-name="apellidopaterno_c"]').remove();
                        $('.record-edit-link-wrapper[data-name="apellidomaterno_c"]').remove();

                    }
                }, this)
            });
        }
        /*Victor Martinez Lopez
        * Deshabilita el campo es proveedor 13-09-2018
        * */
        this.checkProveedor();

        //Display or Hide Vista360
        this._hideVista360();

        //Solo Lectura campos Origen
        this.readOnlyOrigen();

        /* @author F. Javier Garcia S. 10/07/2018
            Agregar dependencia al panel NPS, para ser visible si "Tipo de Cuenta" es "Cliente".
         */
        this._hideNPS();

        this.hideButton_Conversion();

        this.hideButtonLeadNoViable();

        //this.getreuniones();
        //this.getllamadas();

		//Oculta correo, telefonos y direcciones
		if(this.oculta === 1)
		{
			$('div[data-name=account_telefonos]').hide();
			$('div[data-name=email]').hide();
			$('div[data-name=account_direcciones]').hide();
		}
		else
		{
			$('div[data-name=account_telefonos]').show();
			$('div[data-name=email]').show();
			$('div[data-name=account_direcciones]').show();
		}
    },

    /*
    * author: Salvador Lopez 29/08/2018
    * Función para mostrar u ocultar el botón de Lead No viable
    * */
    hideButtonLeadNoViable:function(){

        var leadNoViableField = this.getField("leadNoViable");

        //Para mostrar/ocultar el boton de convertir a Lead y Convertir a Prospecto Contactado. 22/08/2018
        if (this.model.get('tipo_registro_c') != "Lead") {
            leadNoViableField.listenTo(leadNoViableField, "render", function () {
                leadNoViableField.hide();
            });
        }

    },

    hideconfiinfo:function () {
        $('div[data-name=account_telefonos]').hide();
        $('div[data-name=email]').hide();
        $('div[data-name=account_direcciones]').hide();
		self=this;
        if(this.model.get('id')!="") {
            app.api.call('GET', app.api.buildURL('GetUsersBoss/' + this.model.get('id')), null, {
                success: _.bind(function (data) {
                    if(data==false){
						this.oculta = 1;
                        $('div[data-name=account_telefonos]').hide();
                        $('div[data-name=email]').hide();
                        $('div[data-name=account_direcciones]').hide();
                    }else{
						this.oculta = 0;
                        $('div[data-name=account_telefonos]').show();
                        $('div[data-name=email]').show();
                        $('div[data-name=account_direcciones]').show();
                    }
                    return data;
                }, self),
            });
            self.render();
        }
        console.log("valor fuera " + this.model.get('id'));
    },

    disable_panels_rol:function () {

        self=this;

        if(this.model.get('id')!="") {
            var roles_limit = app.lang.getAppListStrings('edicion_cuentas_list');
            var roles_logged = app.user.attributes.roles;
            var coincide_rol=0;
            for(var i=0; i<roles_logged.length; i++) {
                for (var rol_limit in roles_limit) {
                    if (roles_logged[i] == roles_limit[rol_limit]) {
                        coincide_rol++;
                    }
                }
            }
            if(coincide_rol!=0) {
                app.api.call('GET', app.api.buildURL('GetUsersBoss/' + this.model.get('id')), null, {
                    success: _.bind(function (data) {
                        console.log(data);
                        if (data == false) {

                            if(this.model.get('tipo_registro_c')!="Persona"){

                                $('.noEdit.fieldset.actions.detail.btn-group').hide();

                                $('i').removeClass('fa-pencil');

                                $('.record-cell').children().not('.normal.index').click(function (e) { //Habilita solo links
                                    e.stopPropagation();
                                    e.preventDefault();
                                    e.stopImmediatePropagation();
                                    return false;
                                });
                            }
                        }
                        return data;
                    }, self),
                });
                self.render();
            }
        }
    },

    disable_panels_team:function () {

        self=this;

        if(this.model.get('id')!="") {
            var roles_limit = app.lang.getAppListStrings('edicion_cuentas_list');
            var roles_logged = app.user.attributes.roles;
            var coincide_rol=0;
            for(var i=0; i<roles_logged.length; i++) {
                for (var rol_limit in roles_limit) {
                    if (roles_logged[i] == roles_limit[rol_limit]) {
                        coincide_rol++;
                    }
                }
            }
            if(coincide_rol!=0) {
                app.api.call('GET', app.api.buildURL('GetUsersTeams/' + this.model.get('id') + '/Accounts'), null, {
                    success: _.bind(function (data) {
                        console.log(data);
                        if (data == false) {

                            if(this.model.get('tipo_registro_c')!="Persona"){

                                $('.noEdit.fieldset.actions.detail.btn-group').hide();

                                $('i').removeClass('fa-pencil');

                                $('.record-cell').children().not('.normal.index').click(function (e) { //Habilita solo links
                                    e.stopPropagation();
                                    e.preventDefault();
                                    e.stopImmediatePropagation();
                                    return false;
                                });
                            }
                        }else {
                            /*$('.noEdit.fieldset.actions.detail.btn-group').hide();
                            $('i').removeClass('fa-pencil');

                            var panels_hide = app.lang.getAppListStrings('panels_hide_list');
                            var fields_hide = app.lang.getAppListStrings('fields_hide_list');

                            for (var panel in panels_hide) {
                                if(panel=='LBL_RECORDVIEW_PANEL9' || panel=='LBL_RECORDVIEW_PANEL13'){
                                    $('.record-cell').children().not('.normal.index').click(function (e) { //Habilita solo links
                                        e.stopPropagation();
                                        e.preventDefault();
                                        e.stopImmediatePropagation();
                                        return false;
                                    });
                                }else {
                                    $('.row-fluid.panel_body.' + panel).click(function (e) {
                                        e.stopPropagation();
                                        e.preventDefault();
                                        e.stopImmediatePropagation();
                                        return false;
                                    });
                                }
                            }

                            for (var field in fields_hide) {
                                $('div[data-name='+field+']').click(function (e) {
                                    e.stopPropagation();
                                    e.preventDefault();
                                    e.stopImmediatePropagation();
                                    return false;
                                });
                            }*/

                        }
                        return data;
                    }, self),
                });
                self.render();
            }
        }
    },




    /*
      * @author F. Javier G. Solar
      * 18/07/2018
      * Se debe ocultar los botones de Regresa a Lead y Prospecto contactado si cumple
      * con las condiciones de visibilidad .
      * */
    hideButton_Conversion: function () {

        // var hideButton1 = this.getField('regresalead');
        // var hideButton2 = this.getField('prospectocontactado');

        var myField = this.getField("regresalead");
        var myField1 = this.getField("prospectocontactado");
        var myField2 = this.getField("conviertelead");

        if (this.model.get('tct_prospecto_contactado_chk_c') == true &&
            this.model.get('tipo_registro_c') == "Prospecto" &&
            this.model.get('subtipo_cuenta_c') == "Contactado") {
            //$('.btn-regresa-alead').show();

        }
        else{

            if (myField) {
                myField.listenTo(myField, "render", function () {
                    myField.hide();

                    console.log("field being rendered as: " + myField.tplName);
                });
            }
        }


        if (this.model.get('tct_prospecto_contactado_chk_c') == false) {
        }
        else {
            if (myField1) {
                myField1.listenTo(myField1, "render", function () {
                    myField1.hide();

                    console.log("field being rendered as: " + myField1.tplName);
                });
            }
        }
        //Para mostrar/ocultar el boton de convertir a Lead y Convertir a Prospecto Contactado. 22/08/2018
        if (this.model.get('tipo_registro_c') == "Persona") {
            myField1.listenTo(myField1, "render", function () {
                myField1.hide();
            });
        }
        else {
            if (myField2) {
                myField2.listenTo(myField2, "render", function () {
                    myField2.hide();
                });
            }
        }

        if(this.model.get('tipo_registro_c')=="Proveedor"){
             myField2.listenTo(myField2, "render", function () {
                myField2.show();
            });
             myField1.listenTo(myField1, "render", function () {
                myField1.hide();
            });
        }

    },


    /* @author F. Javier Garcia S. 10/07/2018
                Funcion para  ser visible panel NPS si "Tipo de Cuenta" es "Cliente".
             */
    _hideNPS: function () {
        if (this.model.get('tipo_registro_c') != "Cliente") {
            this.$("[data-panelname='LBL_RECORDVIEW_PANEL10']").hide();
        }
    },


    /*
     @author Salvador Lopez
     Se omite la opción de "Persona" dentro del campo tipo_registro_c
     * */
    deleteOptionPersona: function () {
        if (this.model.get('tipo_registro_c') != null) {
            if (this.model.get('tipo_registro_c') != 'Persona') {
                var new_options = app.lang.getAppListStrings('tipo_registro_list');
                Object.keys(new_options).forEach(function (key) {
                    if (key == "Persona") {
                        delete new_options[key];
                    }
                });

                this.model.fields['tipo_registro_c'].options = new_options;
            }

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

    //No aceptar numeros, solo letras (a-z), puntos(.) y comas(,)
    checkTextOnly: function (evt) {
        if ($.inArray(evt.keyCode, [9, 16, 17, 110, 188, 190, 45, 33, 36, 46, 35, 34, 8, 9, 20, 16, 17, 37, 40, 39, 38, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 16, 32, 192]) < 0) {
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

    checkTextAndNum: function (evt) {
        //console.log(evt.keyCode);
        if ($.inArray(evt.keyCode, [110, 188, 190, 45, 33, 36, 46, 35, 34, 8, 9, 20, 16, 17, 37, 40, 39, 38, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 16, 32, 192, 186, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105]) < 0) {
            app.alert.show("Caracter Invalido", {
                level: "error",
                title: "Caracter Invalido.",
                autoClose: true
            });
            return false;
        }
    },

    //No aceptar caracteres especiales incluyendo puntos(.) y comas(,)
    checkTextAndNumRFC: function (evt) {
        if ($.inArray(evt.keyCode, [45, 33, 36, 46, 35, 34, 8, 9, 20, 16, 17, 37, 40, 39, 38, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 16, 32, 192, 186, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105]) < 0) {
            app.alert.show("Caracter Invalido", {
                level: "error",
                title: "Caracter Invalido.",
                autoClose: true
            });
            return false;
        }
    },

    _doGeneraCURP: function () {
        if (this.model.get('tipodepersona_c') != 'Persona Moral') {
            //Valida que se tenga la informaci�n requerida para generar la CURP
            if (this.model.get('fechadenacimiento_c') != '' && this.model.get('genero_c') != '' && this.model.get('primernombre_c') != '' && this.model.get('apellidopaterno_c') != '' && this.model.get('apellidomaterno_c') != '' && this.model.get('pais_nacimiento_c') != '' && this.model.get('estado_nacimiento_c') != '' && this.model.get('estado_nacimiento_c') != "1") {
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
                if (this.model.get('fechadenacimiento_c') != null && this.model.get('fechadenacimiento_c') != '' && this.model.get('primernombre_c') != null
                    && this.model.get('apellidopaterno_c') != null && this.model.get('apellidomaterno_c') != null) {
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
     if(this.model.get('tipo_registro_c') == "Cliente" || this.model.get('estatus_c') == "Interesado")
     {
     this.$("div[data-name='account_direcciones']").show();
     }
     else
     {
     this.$("div[data-name='account_direcciones']").hide();
     }
     // Carlos Zaragoza: Se elimina el campo por defaiult de tipo de proveedor del registro pero sies proveedor, se selecciona bienes por default
     if(this.model.get('tipo_registro_c') == 'Proveedor'){
     this.model.set('tipo_proveedor_c', '1');
     }
     },*/

    _doValidateDireccionCP: function (fields, errors, callback) {
        //Valida CP
        console.log('Validación CP');
        var direcciones = this.model.get('account_direcciones');
        for (i = 0; i < direcciones.length; i++) {
            if (direcciones[i].codigopostal == 'xkcd' && isNaN($('input#existingPostalInput.select2').eq(i).val())==false){
                direcciones[i].codigopostal = $('input#existingPostalInput.select2').eq(i).val();
            }
            if (direcciones[i].codigopostal == 'xkcd' || direcciones[i].codigopostal == null || direcciones[i].codigopostal == '') {
                errors[$(".account_direcciones")] = errors['account_direcciones'] || {};
                errors[$(".account_direcciones")].required = true;
                app.alert.show("Direccion requerida", {
                    level: "error",
                    title: "Favor de selccionar C.P. en direcci\u00F3n: " + direcciones[i].calle + " " + direcciones[i].numext,
                    autoClose: false
                });
            }

        }

        //Valida Ciudad
        console.log('Validación Ciudad');
        var direcciones = this.model.get('account_direcciones');
        for (i = 0; i < direcciones.length; i++) {
            if (direcciones[i].ciudad == 'xkcd' || direcciones[i].ciudad == null || direcciones[i].ciudad == '') {
                errors[$(".account_direcciones")] = errors['account_direcciones'] || {};
                errors[$(".account_direcciones")].required = true;
                app.alert.show("Direccion requerida", {
                    level: "error",
                    title: "Favor de selccionar Ciudad en direcci\u00F3n: " + direcciones[i].calle + " " + direcciones[i].numext,
                    autoClose: false
                });
            }
        }

        //Valida Colonia
        console.log('Validación Colonia');
        var direcciones = this.model.get('account_direcciones');
        for (i = 0; i < direcciones.length; i++) {
            if (direcciones[i].colonia == 'xkcd' || direcciones[i].colonia == null || direcciones[i].colonia == '') {
                errors[$(".account_direcciones")] = errors['account_direcciones'] || {};
                errors[$(".account_direcciones")].required = true;
                app.alert.show("Direccion requerida", {
                    level: "error",
                    title: "Favor de selccionar Colonia en direcci\u00F3n: " + direcciones[i].calle + " " + direcciones[i].numext,
                    autoClose: false
                });
            }
        }

        //Return
        callback(null, fields, errors);
    },
    _doValidateDireccion: function (fields, errors, callback) {
        if(this.model.get('tipo_registro_c') == "Cliente" || this.model.get('tipo_registro_c') == "Proveedor"
            || this.model.get('tipo_registro_c') == "Prospecto" || this.model.get('esproveedor_c')==true) {

            if (_.isEmpty(this.model.get('account_direcciones'))) {
                errors[$(".addDireccion")] = errors['account_direcciones'] || {};
                errors[$(".addDireccion")].required = true;

                $('.direcciondashlet').css('border-color', 'red');
                app.alert.show("Direccion requerida", {
                    level: "error",
                    title: "Al menos una direccion es requerida.",
                    autoClose: false
                });
            } else {
                //Valdación Nacional
                if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                    var nacional = 0;
                    console.log('Validacion Dir.Nacional');
                    var direcciones = this.model.get('account_direcciones');
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
                            title: "Al menos una direccion nacional es requerida.",
                            autoClose: false
                        });
                    }
                }
            }
        }
        callback(null, fields, errors);
    },

    delegateButtonEvents: function () {
        this._super("delegateButtonEvents");
        this.context.on('button:cotizador_button:click', this.cotizadorClicked, this);
        this.context.on('button:expediente_button:click', this.expedienteClicked, this);
        this.context.on('button:negociacion:click', this.negociacionClicked, this);
        this.context.on('button:Historial_cotizaciones_button:click', this.historialCotizacionesClicked, this);
        this.context.on('button:regresa_lead:click', this.regresa_leadClicked, this);
        this.context.on('button:prospecto_contactado:click', this.prospectocontactadoClicked, this);
        this.context.on('button:cancel_button:click', this.handleCancel, this);
        this.context.on('button:save_button:click', this.borraTel, this);
        this.context.on('button:prospecto_contactado:click',this.validaContactado, this);  //se añade validación para validar campos al convertir prospecto contactado.
        this.context.on('button:convierte_lead:click', this.validalead, this);
        this.context.on('button:lead_no_viable:click', this.leadNoViable, this);
    },

    /*
    * @author F. Javier G. Solar
    * 18/07/2018
    * El botón tendrá como finalidad cambiar el Tipo y Subtipo de Cuenta.
    * */

    regresa_leadClicked: function () {
        //alert("boton precionado");
        this.model.set("tipo_registro_c", "Lead");
        this.model.set("subtipo_cuenta_c", "En Calificacion");
        this.model.set("tct_tipo_subtipo_txf_c","Lead En Calificacion");
        this.model.set("tct_prospecto_contactado_chk_c", false);
		    //this.model.set("show_panel_c",0);
        this.model.save();
        this._render();

    },

    cotizadorClicked: function () {
        var Accountid = this.model.get('id');
        var Clientid = this.model.get('idcliente_c');
        if (Clientid == '') {
            Clientid = 0;
        }
        window.open("#bwc/index.php?entryPoint=OpportunidadVaadin&Accountid=" + Accountid + "&clientId=" + Clientid);
    },

    expedienteClicked: function () {
        var Accountid = this.model.get('id');
        window.open("#bwc/index.php?entryPoint=ExpedienteVaadin&Accountid=" + Accountid);
    },

    negociacionClicked: function () {
        var Accountid = this.model.get('id');
        window.open("#bwc/index.php?entryPoint=ArranqueNegociador&Accountid=" + Accountid);
    },

    historialCotizacionesClicked: function () {
        var Accountid = this.model.get('id');
        var name = this.model.get('name');
        window.open("#bwc/index.php?entryPoint=HistorialCotizaciones&Accountid=" + Accountid + "&name=" + name);
    },

    /* @Jesus Carrillo
        Metodo para verificar  las llamadas de la cuenta
     */

    //CAMBIOS EFECTUADOS
    getllamadas:function (callback) {
        var cday = new Date();
        var llamadas=0;
        self=this;
        App.api.call("read", app.api.buildURL("Accounts/" + this.model.get('id')+"/link/calls", null, null, {}), null, {
            success: _.bind(function (data) {
                this.datallamadas=data;
                if(data.records.length>0) {
                    for (var i = 0; i < data.records.length; i++) {
                        var tempdate = Date.parse(data.records[i].date_start);
                        if (tempdate < cday) {
                            if(data.records[i].status=='Held'){ //Conversión de LEAD a Prospecto contactado, solo cuando esten como realizadas
                                llamadas++;
                            }
                        }
                    }
                }
                self.flagheld++;
                callback(llamadas,null,self);
                //This.totalllamadas=llamadas;
                //return llamadas;
            },this)
        });
    },
    /* @Jesus Carrillo
        Metodo para verificar  las reuniones de la cuenta
     */
    getreuniones:function (callBackResult) {
        var cday = new Date();
        var reuniones=0;
        self=this;
        App.api.call("read", app.api.buildURL("Accounts/" + this.model.get('id')+"/link/meetings", null, null, {}), null, {
            success: _.bind(function (data) {
                if(data.records.length>0) {
                    for (var i = 0; i < data.records.length; i++) {
                        var tempdate = Date.parse(data.records[i].date_start);
                        if (tempdate < cday) {
                            if(data.records[i].status=='Held'){ //Conversión de LEAD a Prospecto Contactado, solo cuando esten como realizadas
                                reuniones++;
                            }
                        }
                    }
                }
                //this.totalreuniones=reuniones;
                //return reuniones;
                self.flagheld++;
                callBackResult(null,reuniones,self);
            },this)
        });
    },
    /* @Jesus Carrillo
        Metodo para validar campos de telefonos y direcciones
     */
    validar_fields:function(valContacto, validar_fields) {
        var datos_telefonos = this.model.get('account_telefonos');
        var tipolabel = [];
        var pais = [];
        var estatus = [];
        var datos_dirreciones = this.model.get('account_direcciones');
        var tipolabel2 = [];
        var cp = [];
        var municipio = [];
        var calle = [];
        var indicador = [];
        var ciudad = [];
        var numext = [];
        var numint = [];
        var estado = [];
        var colonia = [];
        for (var i = 0; i < datos_telefonos.length; i++) {
            tipolabel.push(datos_telefonos[i].tipo_label);
            pais.push(datos_telefonos[i].pais);
            estatus.push(datos_telefonos[i].estatus);
        }
        for (var i = 0; i < datos_dirreciones.length; i++) {
            tipolabel2.push(datos_dirreciones[i].tipo_label);
            cp.push(datos_dirreciones[i].codigopostal);
            municipio.push(datos_dirreciones[i].municipio);
            calle.push(datos_dirreciones[i].calle);
            indicador.push(datos_dirreciones[i].indicador);
            ciudad.push(datos_dirreciones[i].ciudad);
            numext.push(datos_dirreciones[i].numext);
            numint.push(datos_dirreciones[i].numint);
            estado.push(datos_dirreciones[i].estado);
            colonia.push(datos_dirreciones[i].colonia);
        }
        var allfields=[tipolabel,pais,estatus,tipolabel2,cp,municipio,calle,indicador,ciudad,numext,numint,estado,colonia];
        var allfields2=[];
        console.log(allfields);
        var indica_direc_admin=0;
        for(var i=0;i<allfields.length;i++){
            var betext=0;
            for(var j=0;j<allfields[i].length;j++)
            {
                if(allfields[i][j]!=null || allfields[i][j]!="") {
                    betext++;
                    if(i==7) {//si estas apuntando al campo indicador
                        if (allfields[i][j] == '16' || allfields[i][j] == '17' || allfields[i][j] == '18' || allfields[i][j] == '19' || allfields[i][j] == '20' || allfields[i][j] == '21'
                            || allfields[i][j] == '22' || allfields[i][j] == '23' || allfields[i][j] == '24' || allfields[i][j] == '25' || allfields[i][j] == '26' || allfields[i][j] == '27'
                            || allfields[i][j] == '28' || allfields[i][j] == '29' || allfields[i][j] == '30' || allfields[i][j] == '31') {
                            indica_direc_admin++;
                        }
                    }
                }
            }
            if(betext==0){
                allfields2.push(false);
            }else{
                allfields2.push(true);
            }
        }
        console.log(allfields2);
        var fieldstelefono=allfields2.slice(0,2);
        var fieldsdirec=allfields2.slice(3);
        var valMedios = 0;

        if(fieldstelefono.includes(false)==true){
            app.alert.show('alert_fields_empty1', {
                level: 'error',
                messages: 'Para convertir a Prospecto Contactado es necesario que tenga al menos un <b>Tel\u00E9fono</b>',
            });
            valMedios = 1;
        }
        /*
        if(fieldsdirec.includes(false)==true){
            app.alert.show('alert_fields_empty2', {
                level: 'error',
                messages: 'Para convertir a Prospecto Contactado es necesario que tenga al menos una <b>Direcci\u00F3n</b>',
            });
            valMedios = 1;
        }
        */

        /*    if(indica_direc_admin==0){
                app.alert.show('alert_fields_empty3', {
                    level: 'error',
                    messages: 'Para convertir a Prospecto Contactado es necesario que tenga al menos una <b>Direcci\u00F3n</b> con Indicador <b>Administraci\u00F3n</b>',
                });
                valMedios = 1;
            } */

        if(valMedios==0 && valContacto==0 && validar_fields==0) {
            this.model.set('tipo_registro_c','Prospecto');
            this.model.set('subtipo_registro_c','Contactado');
            this.model.set('tct_prospecto_contactado_chk_c',true);
			      //this.model.set("show_panel_c",1);
            this.model.save();
            this._render();
            app.alert.show('alert_change_success', {
                level: 'success',
                messages: 'Cambio realizado',
            });
        }
    },
    /* @Jesus Carrillo
        Metodo que convierte a prospecto contactado
       *Solo promotores y directorees pueden cambiar una cuenta de Lead a Prospecto contactado
       * 22-08-2018 Victor Martínez
        */
    prospectocontactadoClicked:function(){
        self=this;
        self.flagheld=0;
        if(this.model.get('id')!="") { //en lugar de self es this
            app.api.call('GET', app.api.buildURL('GetUsersBoss/' + this.model.get('id')), null, {
                success: _.bind(function (data) {
                    var  usuario=App.user.attributes.puestousuario_c;
                    console.log(data);
                    if(data==false){


                        if (usuario=="5"||
                            usuario=="11"||
                            usuario=="16"||
                            //Gerentes
                            usuario=="15"||
                            usuario=="4"||
                            usuario=="10"||
                            //subdirectores
                            usuario=="3"||
                            usuario=="9"||
                            usuario=="28"||
                            //Directores
                            usuario=="1"||
                            usuario=="2"||
                            usuario=="8"||
                            usuario=="14"||
                            usuario=="21"
                            || usuario=="18" //Ajuste para poder trabajar con la cuenta de Wendy
                        ) {

                            //Valida llamadas y reuniones
                            var valRelacionados = 0;
                            //self.getllamadas();
                            //self.getreuniones();

                            app.alert.show('loadcontactado', {
                                level: 'process',
                            });
                            self.getllamadas(this.resultCallback);
                            self.getreuniones(this.resultCallback);

                        }
                            else
                            {

                                app.alert.show("No acceso", {
                                    level: "error",
                                    title: "Usted no tiene el permiso para llevar a cabo esta acci\u00F3n",
                                    autoClose: true
                                });
                            }

                            /*

                             if(this.totalllamadas==0 && self.totalreuniones==0){
                                 app.alert.show('alert_calls', {
                                     level: 'error',
                                     messages: 'El proceso de conversi\u00F3n requiere que la cuenta contenga una <b>llamada</b> o <b>reuni\u00F3n</b> con estado <b>Realizada</b> y con fecha al d\u00EDa de hoy o anterior.',
                                 });
                                 valRelacionados = 1;
                             }

                             //Valida datos de cuenta
                             var valContacto = self.validaContactado();
                             self.validar_fields(valContacto, valRelacionados);
                             */

                        }
                        else if(data==true){

                            //Valida llamadas y reuniones
                            var valRelacionados = 0;
                        //self.getllamadas();
                        //self.getreuniones();

                        app.alert.show('loadcontactado', {
                            level: 'process',
                        });
                        self.getllamadas(this.resultCallback);
                        self.getreuniones(this.resultCallback);


                        }


                }, self)
            });
            //self.render();
        }

        console.log("valor fuera " + this.model.get('id'));
    },

    resultCallback:function(resultLlamadas,resultReuniones,context) {
        self=context;
        var valRelacionados = 0;
        if (resultLlamadas != null) {
            self.totalllamadas = resultLlamadas;

        }
        if (resultReuniones != null) {
            self.totalreuniones = resultReuniones;

        }

        // if (self.totalllamadas != undefined && self.totalreuniones != undefined) {
        if (self.flagheld>=2) {
            if (self.totalllamadas == 0 && self.totalreuniones == 0) {
                app.alert.show('alert_calls', {
                    level: 'error',
                    messages: 'El proceso de conversi\u00F3n requiere que la cuenta contenga una <b>llamada</b> o <b>reuni\u00F3n</b> con estado <b>Realizada</b> y con fecha al d\u00EDa de hoy o anterior.',
                });
                valRelacionados = 1;
            }

            //Valida datos de cuenta
            var valContacto = self.validaContactado();
            self.validar_fields(valContacto, valRelacionados);
            app.alert.dismiss('loadcontactado');

        }

    },


    //Validación para que los campos contengan informacion para poder convertir de LEAD a Prospecto/Contactado. Adrian Arauz 15/08/2018
    validaContactado: function () {
        var campos= "";

        if (this.model.get('origendelprospecto_c') =="" || this.model.get('origendelprospecto_c')==null){
            campos= campos + '<b>Origen, </b>';
        }

        if (this.model.get('name') =="" || this.model.get('name')==null){
            campos= campos + '<b>Nombre, </b>';
        }

        if ( (this.model.get('apellidopaterno_c') =="" || this.model.get('apellidopaterno_c')==null)  && this.model.get('tipodepersona_c') != 'Persona Moral'){
            campos= campos + '<b>Apellido Paterno, </b>';
        }

        if (this.model.get('email') =="" || this.model.get('email')==null){
            campos= campos + '<b>E Mail, </b>';
        }

        if ( (this.model.get('nombre_comercial_c') =="" || this.model.get('nombre_comercial_c')==null) && this.model.get('tipodepersona_c')== 'Persona Moral'){

            campos= campos + '<b>Nombre Comercial. </b> ';
        }


        if(campos!=""){
            console.log ('Validacion Campos OK');
            app.alert.show('alert_calls2', {
                level: 'error',
                messages: 'Para convertir a Prospecto Contactado es necesario se llenen los campos requeridos: <br>' +campos ,
            });

            return 1;
        }else {
            return 0;
        }
    },

    //Validaciòn para convertir el tipo de cuenta Persona a LEAD, Adrian Arauz 21/08/2018
    validalead: function () {
        var reqs= "";

        /*if (this.model.get('origendelprospecto_c') =="" || this.model.get('origendelprospecto_c')==null){
            reqs= reqs + '<b><br>Origen<br></b>';
        }*/

        if (this.model.get('name') =="" || this.model.get('name')==null){
            reqs= reqs + '<b>Nombre<br></b>';
        }

        if ( (this.model.get('apellidopaterno_c') =="" || this.model.get('apellidopaterno_c')==null)  && this.model.get('tipodepersona_c') != 'Persona Moral'){
            reqs= reqs + '<b>Apellido Paterno<br></b>';
        }

        if (this.model.get('email') =="" || this.model.get('email')==null){
            reqs= reqs + '<b>Email<br></b>';
        }

        if ( (this.model.get('nombre_comercial_c') =="" || this.model.get('nombre_comercial_c')==null) && this.model.get('tipodepersona_c')== 'Persona Moral'){

            reqs= reqs + '<b>Nombre Comercial<br></b>';
        }

        if(reqs!="") {
            console.log('Validacion Campos LEAD');
            app.alert.show('alert_calls4', {
                level: 'error',
                messages: 'Para convertir a Lead es necesario que se llenen los siguientes campos requeridos: ' + reqs,
            });
        }
        else {
            /* hay que traer el campo del usaurio
                   * PREOMOTORES POR DEFAULT
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

            var usuario = app.data.createBean('Users', {id: app.user.id});
            usuario.fetch({
                success: _.bind(function (modelo) {
                    var contains = function (needle) {
                        // Per spec, the way to identify NaN is that it is not equal to itself
                        var findNaN = needle !== needle;
                        var indexOf;

                        if (!findNaN && typeof Array.prototype.indexOf === 'function') {
                            indexOf = Array.prototype.indexOf;
                        } else {
                            indexOf = function (needle) {
                                var i = -1, index = -1;

                                for (i = 0; i < this.length; i++) {
                                    var item = this[i];

                                    if ((findNaN && item !== item) || item === needle) {
                                        index = i;
                                        break;
                                    }
                                }

                                return index;
                            };
                        }

                        return indexOf.call(this, needle) > -1;
                    };
                    /** Modificaci�n a Multiproducto para promotores por default
                     * Carlos Zaragoza
                     * Enero 25, 2016 10:15 AM
                     * */
                    if (contains.call(modelo.get('productos_c'), "1")) {
                        this.model.set('promotorleasing_c', modelo.get('name'));
                        this.model.set('user_id_c', modelo.get('id'));
                    } else {
                        this.model.set('promotorleasing_c', '9 - Sin Gestor');
                        this.model.set('user_id_c', '569246c7-da62-4664-ef2a-5628f649537e');
                    }
                    if (contains.call(modelo.get('productos_c'), "4")) {
                        this.model.set('promotorfactoraje_c', modelo.get('name'));
                        this.model.set('user_id1_c', modelo.get('id'));
                    } else {
                        this.model.set('promotorfactoraje_c', 'Maria de Lourdes Campos Toca');
                        this.model.set('user_id1_c', 'a04540fc-e608-56a7-ad47-562a6078519d');
                    }
                    if (contains.call(modelo.get('productos_c'), "3")) {
                        this.model.set('promotorcredit_c', modelo.get('name'));
                        this.model.set('user_id2_c', modelo.get('id'));
                    } else {
                        this.model.set('promotorcredit_c', '9 - Sin Gestor');
                        this.model.set('user_id2_c', '569246c7-da62-4664-ef2a-5628f649537e');
                    }
                    if (contains.call(modelo.get('productos_c'), "1") == false && contains.call(modelo.get('productos_c'), "3") == false && contains.call(modelo.get('productos_c'), "4") == false) {
                        this.model.set('promotorleasing_c', '9 - Sin Gestor');
                        this.model.set('user_id_c', '569246c7-da62-4664-ef2a-5628f649537e');
                        this.model.set('promotorfactoraje_c', 'Maria de Lourdes Campos Toca');
                        this.model.set('user_id1_c', 'a04540fc-e608-56a7-ad47-562a6078519d');
                        this.model.set('promotorcredit_c', '9 - Sin Gestor');
                        this.model.set('user_id2_c', '569246c7-da62-4664-ef2a-5628f649537e');
                    }

                    this.model.set("tipo_registro_c", "Lead");
                    this.model.set("subtipo_cuenta_list", "En Calificacion");
					          //this.model.set("show_panel_c",0);
                    this.model.save();
                    console.log ('Guarda a Lead');
                    app.alert.show('success', {
                        level: 'success',
                        messages: 'Proceso Finalizado.',

                    });
                    this.render();

                }, this)
            });


        }

    },

    leadNoViable: function(){

        //var self=this;
        var urlDelete=app.api.buildURL('DeleteBeanById/Accounts/'+this.model.get('id'))

        app.alert.show('confirm_lead_no_viable', {
            level: 'confirmation',
            messages: '\u00BFEst\u00E1 seguro de establecer a <b>'+this.model.get('name')+'</b> como Lead No Viable\u003F',
            autoClose: false,
            onConfirm: function(){

                app.alert.show('delete_lead_no_viable', {
                    level: 'process',
                });

                // self.model.set('subtipo_cuenta_c',"No Viable");
                //self.model.save();


                app.api.call('GET',urlDelete , null, {
                    success: _.bind(function (data) {
                        if(data){
                            app.alert.dismiss('delete_lead_no_viable');
                            app.router.navigate('#Accounts', {trigger: true});
                        }


                    },self),
                    error: _.bind(function(error) {
                        console.log("Este fue el error:", error)
                    }, self),
                });


            },
            onCancel: function(){
                //alert("OPERACION CANCELADA!");
            }
        });

    },

    /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 6/12/2015 Description: Persona Fisica and Persona Fisica con Actividad Empresarial must have an email or a Telefono*/
    _doValidateEmailTelefono: function (fields, errors, callback) {
        if (this.model.get('tipo_registro_c') !== 'Persona' || this.model.get('tipo_registro_c') !== 'Proveedor') {
            if (_.isEmpty(this.model.get('email')) && _.isEmpty(this.model.get('account_telefonos')) ) {
                app.alert.show("Correo requerido", {
                    level: "error",
                    title: "Al menos un correo electr\u00F3nico o un tel\u00E9fono es requerido.",
                    autoClose: false
                });
                errors['email'] = errors['email'] || {};
                errors['email'].required = true;
                errors['account_telefonos'] = errors['account_telefonos'] || {};
                errors['account_telefonos'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    DuplicateCheck: function (fields, errors, callback) {
        if (this.duplicadosName > 0) {
            app.alert.show("DuplicateCheck", {
                level: "error",
                title: "Ya existe una persona registrada con el mismo nombre.",
                autoClose: false
            });

            if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                errors['primernombre_c'] = errors['primernombre_c'] || {};
                errors['primernombre_c'].required = true;
                errors['apellidopaterno_c'] = errors['apellidopaterno_c'] || {};
                errors['apellidopaterno_c'].required = true;
                errors['apellidomaterno_c'] = errors['apellidomaterno_c'] || {};
                errors['apellidomaterno_c'].required = true;
            } else {
                errors['razonsocial_c'] = errors['razonsocial_c'] || {};
                errors['razonsocial_c'].required = true;
            }
        } else {
            if (this.duplicadosRFC > 0) {
                app.alert.show("DuplicateCheck", {
                    level: "error",
                    title: "Ya existe una persona registrada con el mismo RFC.",
                    autoClose: false
                });

                errors['rfc_c'] = errors['rfc_c'] || {};
                errors['rfc_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    DuplicateCheck_Name: function () {
        var clean_name = this.model.get('clean_name');
        app.api.call("read", app.api.buildURL("Accounts/", null, null, {
            fields: "clean_name",
            max_num: 5,
            "filter": [
                {
                    "clean_name": clean_name,
                    "id": {
                        $not_equals: this.model.id,
                    }
                }
            ]
        }), null, {
            success: _.bind(function (data) {
                if (data.records.length > 0) {
                    this.duplicadosName = 1;
                    console.log('this.duplicadosName SI');
                    /*app.alert.show("DuplicateCheck", {
                     level: "error",
                     title: "Ya existe una persona registrada con el mismo nombre.",
                     autoClose: false
                     });

                     if (this.model.get('tipodepersona_c') != 'Persona Moral'){
                     errors['primernombre_c'] = errors['primernombre_c'] || {};
                     errors['primernombre_c'].required = true;
                     errors['apellidopaterno_c'] = errors['apellidopaterno_c'] || {};
                     errors['apellidopaterno_c'].required = true;
                     errors['apellidomaterno_c'] = errors['apellidomaterno_c'] || {};
                     errors['apellidomaterno_c'].required = true;
                     }else{
                     errors['razonsocial_c'] = errors['razonsocial_c'] || {};
                     errors['razonsocial_c'].required = true;
                     }*/
                } else {
                    this.duplicadosName = 0;
                    console.log('this.duplicadosName NO');
                }
            }, this)
        });

        //callback(null, fields, errors);
    },

    //RFC_DuplicateCheck: function(fields, errors, callback){
    RFC_DuplicateCheck: function () {
        var RFC = this.model.get('rfc_c');
        if (RFC != '' && RFC != null && (RFC != 'XXX010101XXX' && RFC != 'XXXX010101XXX' && RFC != 'XXX010101000')) {
            app.api.call("read", app.api.buildURL("Accounts/", null, null, {
                fields: "rfc_c",
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
                        this.duplicadosRFC = 1;
                        console.log('duplicadosRFC SI');
                        /*app.alert.show("DuplicateCheck", {
                         level: "error",
                         title: "Ya existe una persona registrada con el mismo RFC.",
                         autoClose: false
                         });

                         errors['rfc_c'] = errors['rfc_c'] || {};
                         errors['rfc_c'].required = true;*/
                    } else {
                        this.duplicadosRFC = 0;
                        console.log('duplicadosRFC NO');
                    }
                }, this)
            });
        }

        //callback(null, fields, errors);
    },

    //revisa que no exista un nombre o RFC duplicado
    _doValidateRFC: function (fields, errors, callback) {
        var RFC = this.model.get('rfc_c');
        if (RFC != '' && RFC != null && (RFC != 'XXX010101XXX' && RFC != 'XXXX010101XXX')) {
            /*Método que tiene la función de validar el rfc*/
            RFC = RFC.toUpperCase().trim();
            var expReg = "";
            if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                expReg =  /^([A-Z\u00D1&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
            } else {
                expReg =  /^([A-Z\u00D1&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
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

    //validar fecha de nacimiento. Persona debe ser mayor de 18 años
    _doValidateMayoriadeEdad: function (fields, errors, callback) {
        if (this.model.get('tipodepersona_c') != 'Persona Moral' && this.model.get('tipo_registro_c') != 'Persona') {
            var nacimiento = new Date(this.model.get('fechadenacimiento_c'));
            var enteredAge = this.getAge(nacimiento);
            if (enteredAge < 18) {
                app.alert.show("fechaDeNacimientoCheck", {
                    level: "error",
                    title: "Persona debe de ser mayor de 18 años.",
                    autoClose: false
                });
                errors['fechadenacimiento_c'] = errors['fechadenacimiento_c'] || {};
                errors['fechadenacimiento_c'].required = true;
            }
        }

        callback(null, fields, errors);
    },

    //metodo para validar fecha de nacimiento
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

    //metodo para llamar web service que regresa un RFC valido el cual comparamos con el que el usuario introdujo y decidimos si es valido o no
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
                            data['UNI2_CTE_02_CreaRfcPersonaFisicaResult']['rfcGenerado'] : "");
                        var rfc_local = (data['UNI2_CTE_02_CreaRfcPersonaFisicaResult']['resultado'] ?
                            data['UNI2_CTE_02_CreaRfcPersonaFisicaResult']['rfcGenerado'] + data['UNI2_CTE_02_CreaRfcPersonaFisicaResult']['homoClaveDV'] : "");
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
                                messages: "El RFC calculado es diferente al escrito, ¿Desea reemplazarlo?",
                                autoClose: false,

                                onConfirm: function () {
                                    self.model.set("rfc_c", rfc_local);
                                },
                                onCancel: function () {
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
                        this.model.set("rfc_c", rfc_local);
                    }
                }
            }, this)
        });
        //callback(null, fields, errors);
    },

    /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 8/26/2015 Description: On Inline edit disable the TAB Key in order to prevent the field from going to detail mode.*/
    handleKeyDown: function (e, field) {
        if (e.which === 9) {
            if (field.name != this.model.fields.account_contacts.name && field.name != this.model.fields.account_direcciones.name && field.name != this.model.fields.account_telefonos.name) {
                e.preventDefault();
                this.nextField(field, e.shiftKey ? 'prevField' : 'nextField');
                this.adjustHeaderpane();
            }
        }
    },
    /* END CUSTOMIZATION */

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

    doValidateDateCons: function (fields, errors, callback) {
        /* if  date not empty, then check with today date and return error */
        if (!_.isEmpty(this.model.get('fechaconstitutiva_c'))) {

            var feccons_date = new Date(this.model.get('fechaconstitutiva_c'));
            var today_date = new Date();

            if (feccons_date > today_date) {
                app.alert.show("fechaDeConsValidate", {
                    level: "error",
                    title: "La fecha constitutiva no puede ser mayor al día de hoy",
                    autoClose: false
                });

                errors['fechaconstitutiva_c'] = errors['fechaconstitutiva_c'] || {};
                //errors['fechaapertura'] = 'La fecha de apertura no puede ser posterior al día de hoy' || {};
                errors['fechaconstitutiva_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    doValidateDateNac: function (fields, errors, callback) {
        /* if  date not empty, then check with today date and return error */
        if (!_.isEmpty(this.model.get('fechadenacimiento_c'))) {

            var fecnac_date = new Date(this.model.get('fechadenacimiento_c'));
            var today_date = new Date();

            if (fecnac_date > today_date) {
                app.alert.show("fechaDeNacimientoValidate", {
                    level: "error",
                    title: "La fecha de nacimiento no puede ser mayor al día de hoy",
                    autoClose: false
                });
                errors['fechadenacimiento_c'] = errors['fechadenacimiento_c'] || {};
                //errors['fechaapertura'] = 'La fecha de apertura no puede ser posterior al día de hoy' || {};
                errors['fechadenacimiento_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    /*
     validaExtranjerosRFC: function (){
     if((this.model.get('pais_nacimiento_c')!=2) && (this.model.get('tipo_registro_c') != 'Prospecto' && this.model.get('tipo_registro_c') != 'Persona')){
     this.model.set('rfc_c','XXX010101XXX');
     }
     if(this.model.get('tipo_registro_c') == 'Prospecto' && this.model.get('estatus_c') == 'Interesado' && this.model.get('pais_nacimiento_c')!=2){
     this.model.set('rfc_c','XXX010101XXX');
     }
     },
     */

    validaFechaNacimientoDesdeRFC: function () {
        //this._doValidateRFC();
        var RFC = this.model.get('rfc_c');
        if (RFC != '' && RFC != null && RFC != 'XXX010101XXX') {
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
    },

    validaProveedorRequerido: function (fields, errors, callback) {
        if (this.model.get('tipo_registro_c') == 'Proveedor' || this.model.get('esproveedor_c') == true) { //duda
            this.model.set("esproveedor_c", true);
            var tipoProveedor = new String(this.model.get('tipo_proveedor_c'));
            if (tipoProveedor.length == 0) {
                app.alert.show("Proveedor Requerido", {
                    level: "error",
                    title: "Debe seleccionar un un tipo de proveedor al menos",
                    autoClose: false
                });
                errors['tipo_proveedor_c'] = errors['tipo_proveedor_c'] || {};
                errors['tipo_proveedor_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    cambiaRiesgodePersona: function (fields, errors, callback) {
        var riesgo = this.model.get('ctpldpoliticamenteexpuesto_c') == true ? 'Alto' : 'Bajo';
        this.model.set("riesgo_c", riesgo);
        callback(null, fields, errors);
    },

    cleanName: function () {
        var original_name = this.model.get("name");
        var list_check = app.lang.getAppListStrings('validacion_duplicados_list');
        var simbolos = app.lang.getAppListStrings('validacion_simbolos_list');

        var clean_name_split = [];
        clean_name_split = original_name.split(" ");
        _.each(clean_name_split, function (value, key) {
            _.each(simbolos, function (simbolo, index) {
                var clean_value = value.split(simbolo).join('');
                if (clean_value != value) {
                    clean_name_split[key] = clean_value;
                }
            });
        });

        _.each(clean_name_split, function (value, key) {
            _.each(list_check, function (index, nomenclatura) {
                var upper_value = value.toUpperCase();
                if (upper_value == nomenclatura) {
                    var clean_value = upper_value.replace(nomenclatura, "");
                    clean_name_split[key] = clean_value;
                }
            });
        });

        var clean_name = "";
        _.each(clean_name_split, function (value, key) {
            clean_name += value;
        });

        clean_name = clean_name.toUpperCase();
        this.model.set("clean_name", clean_name);

        this.DuplicateCheck_Name();
    },

    /*
     AF - 26/12/17
     Ajuste: Ocultar campo dependiente de multiselect "¿Instrumento monetario con el que espera realizar los pagos?"
     */
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

    /**
     * @author Salvador Lopez Balleza
     * @date 13/03/2018
     * Establecer campo phone_office con la misma informaci�n que el campo personalizado account_telefonos
     * */
    setPhoneOffice: function () {

        if (!_.isEmpty(this.model.get('account_telefonos'))) {
            var telefono = this.model.get('account_telefonos');
            for (var i = 0; i < telefono.length; i++) {
                if (telefono[i].principal) {
                    if (telefono[i].pais!='52'){
                    this.model.set('phone_office', "base" + telefono[i].pais + " " + telefono[i].telefono);
                            }else{
                                this.model.set('phone_office', "" + telefono[i].telefono);
                    }
                }
            }
        }
    },

    doValidateInfoReq: function (fields, errors, callback) {
        if (this.model.get('origendelprospecto_c') == 'Prospeccion propia') {
            var metodoProspeccion = new String(this.model.get('metodo_prospeccion_c'));
            if (metodoProspeccion.length == 0 || this.model.get('metodo_prospeccion_c') == null) {
                app.alert.show("Metodo de Prospeccion Requerido", {
                    level: "error",
                    title: "Debe indicar el metodo de prospecci\u00F3n",
                    autoClose: false
                });
                errors['metodo_prospeccion_c'] = errors['metodo_prospeccion_c'] || {};
                errors['metodo_prospeccion_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    macrosector: function (fields, errors, callback) {
        if (this.model.get('tct_macro_sector_ddw_c') == '' && (this.model.get('tipo_registro_c') == 'Cliente' || this.model.get('tipo_registro_c') == 'Proveedor'
            || this.model.get('esproveedor_c')==true || this.model.get('subtipo_cuenta_c') == 'Interesado' || this.model.get('subtipo_cuenta_c') == 'Integracion de Expediente' || this.model.get('subtipo_cuenta_c') == 'Credito')) {
            errors['tct_macro_sector_ddw_c'] = "Error: Favor de verificar los errores";
            errors['tct_macro_sector_ddw_c'].required = true;
        }
        callback(null, fields, errors);
    },

    sectoreconomico: function (fields, errors, callback) {
        if (this.model.get('tipodepersona_c') != 'Persona Fisica' && this.model.get('sectoreconomico_c') == '' && (this.model.get('tipo_registro_c') == 'Cliente' || this.model.get('tipo_registro_c') == 'Proveedor' || this.model.get('esproveedor_c')==true)) {
            errors['sectoreconomico_c'] = "Error: Favor de verificar los errores";
            errors['sectoreconomico_c'].required = true;
        }
        callback(null, fields, errors);
    },

    validadirecc: function (fields, errors, callback) {
        var cont=0;

        $('.existingIndicador').each(function (index) {
            if($(this).val()==''){
                cont++;
                $('#s2id_existingMulti1 ul.select2-choices').eq(index).css('border-color', 'red');
            }else{
                $('#s2id_existingMulti1 ul.select2-choices').eq(index).css('border-color', '');
            }
        });
        $('.existingPostal').each(function (index) {
            if($(this).val()==''){
                cont++;
                //$(this).css('border-color', 'red');
                $('.existingPostal').eq(index).css('border-color', 'red');
            }else{
                //$(this).css('border-color', '');
                $('.existingPostal').eq(index).css('border-color', '');
            }
        });

        $('.existingColoniaTemp').each(function () {
            if($(this).val()=='1'){
                cont++;
                $(this).css('border-color', 'red');
            }else{
                $(this).css('border-color', '');
            }
        });

        $('.existingCalle').each(function (index) {
            if($(this).val().trim()==''){
                cont++;
                //$(this).css('border-color', 'red');
                //$(this).eq(index).css('border-color', 'red');
                $('.existingCalle').eq(index).css('border-color', 'red');
            }else{
                $('.existingCalle').eq(index).css('border-color', '');
            }
        });
        $('.existingNumExt').each(function (index) {
            if($(this).val().trim()==''){
                cont++;
                //$(this).css('border-color', 'red');
                $('.existingNumExt').eq(index).css('border-color', 'red');
            }else{
                //$(this).css('border-color', '');
                $('.existingNumExt').eq(index).css('border-color', '');
            }
        });

        if(cont>0){
            app.alert.show("empty_fields_dire", {
                level: "error",
                title: "Favor de llenar los campos se\u00F1alados.",
                autoClose: false
            });
            errors['dire_direccion'] = errors['dire_direccion'] || {};
            errors['dire_direccion'].required = true;

        }
        callback(null, fields, errors);
    },

    validatelefonos: function (fields, errors, callback) {
        var expreg =/^[0-9]{8,10}$/;
        var cont=0;
        var phones=this.model.get('account_telefonos');

        $('.existingTelephono').each(function () {
            if(!expreg.test($(this).val())){
                cont++;
                $(this).css('border-color', 'red');

            }else{
                //funcion
                var conta=0;
                for (var i =0; i < $(this).val().length; i++) {
                    if($(this).val().charAt(0)==$(this).val().charAt(i)){
                        conta++;
                    }
                }
                if(conta==$(this).val().length){
                        app.alert.show('numero_repetido1', {
                        level: 'error',
                        autoClose: true,
                        messages: 'Tel\u00E9fono Invalido caracter repetido'
                        });
                    errors['rep'] = errors['Tel\u00E9fono Invalido,un mismo n\u00FA ha sido repetido varias veces'] || {};
                    errors['rep'].required = true;
                    $(this).css('border-color', 'red');
                } else {
                    $(this).css('border-color', '');
                }
            }
        });
        $('div[data-name=account_telefonos]').find('.existingPais').each(function () {
            if($(this).val()==''){
                cont++;
                $(this).css('border-color', 'red');
            }else{
                $(this).css('border-color', '');
            }
        });

        $('.existingTipotelefono').each(function () {
            if($(this).val()==''){
                cont++;
                $(this).css('border-color', 'red');
            }else{
                $(this).css('border-color', '');
            }
        });
        $('.existingEstatus').each(function () {
            if($(this).val()==''){
                cont++;
                $(this).css('border-color', 'red');
            }else{
                $(this).css('border-color', '');
            }
        });

        if(cont>0){
            app.alert.show('error_modultel', {
                level: 'error',
                autoClose: true,
                messages: 'Favor de llenar o corregir los campos se\u00F1alados.'
            });
            errors['xd'] = errors['xd'] || {};
            errors['xd'].required = true;
        }else {
            var coincidencia = 0;
            var indices=[];
            for (var i = 0; i < phones.length; i++) {
                for (var j = 0; j < phones.length; j++) {
                    if (phones[j].telefono == phones[i].telefono && i!=j) {
                        coincidencia++;
                        indices.push(i);
                        indices.push(j);
                    }
                }
            }
            indices=indices.unique();
            if (coincidencia > 0) {
                    app.alert.show('error_sametelefono3', {
                        level: 'error',
                        autoClose: true,
                        messages: 'Los n\u00FAmeros telef\u00F3nicos que estas intentando guardar son iguales,favor de corregir.'
                    });
                    //$($input).focus();
                    if(indices.length>0) {
                        for (var i = 0; i < indices.length; i++) {
                            $('.existingTelephono').eq(indices[i]).css('border-color', 'red');
                        }
                    }
                    errors['xd'] = errors['xd'] || {};
                    errors['xd'].required = true;
            }
        }
        callback(null, fields, errors);
    },


    valida_backoffice: function() {
        self=this;
        var roles_limit = app.lang.getAppListStrings('roles_limit_list');
        var roles_logged = app.user.attributes.roles;
        var coincide_rol=0;
        for(var i=0; i<roles_logged.length; i++) {
            for (var rol_limit in roles_limit) {
                if (roles_logged[i] == roles_limit[rol_limit]) {
                    coincide_rol++;
                }
            }
        }
        if(coincide_rol!=0) {
            app.api.call('GET', app.api.buildURL('GetUsersTeams/' + this.model.get('id') + '/Accounts'), null, {
                success: _.bind(function (pertenece_a_equipo) {
                    if (pertenece_a_equipo == false) {
                        console.log('Funcion Valida_backoffice:' + pertenece_a_equipo);
                        app.alert.show("No Rol", {
                            level: "error",
                            title: "No puedes ver la cuenta ya no formas parte de ningun equipo.",
                            autoClose: false,
                            return: false,
                        });
                        app.router.navigate('#Accounts', {trigger: true});
                    }
                }, self),
            });
        }
    },

    valida_centro_prospec: function() {
        self=this;
        var roles_limit = app.lang.getAppListStrings('roles_limit_list_2');
        var roles_logged = app.user.attributes.roles;
        var coincide_rol=0;
        for(var i=0; i<roles_logged.length; i++) {
            for (var rol_limit in roles_limit) {
                if (roles_logged[i] == roles_limit[rol_limit]) {
                    coincide_rol ++;
                }
            }
        }
        if(coincide_rol!=0) {
            if (this.model.get('tipo_registro_c') != "Lead") {
                app.alert.show("No Rol2", {
                    level: "error",
                    title: "No puedes ver la cuenta ya que no tienes  el perfil adecuado.",
                    autoClose: false,
                    return: false,
                });
                app.router.navigate('#Accounts', {trigger: true});
            }else {
                app.api.call('GET', app.api.buildURL('GetUsersBoss/' + this.model.get('id')), null, {
                    success: _.bind(function (es_promotor) {
                        if (es_promotor == false) {
                            console.log('Funcion valida_centro_prospec:' + es_promotor);
                            app.alert.show("No Rol3", {
                                level: "error",
                                title: "No puedes ver la cuenta ya que no tienes  el perfil adecuado.",
                                autoClose: false,
                                return: false,
                            });
                            app.router.navigate('#Accounts', {trigger: true});
                        }
                    }, self),
                });
            }
        }
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


    validacedente: function (fields, errors, callback){

        if (this.model.get('cedente_factor_c') == true || this.model.get('deudor_factor_c') == true  ) {


            var value = this.model.get('account_direcciones');
            var totalindicadores = "";


            for (i=0; i < value.length; i++) {
                console.log("Valida Cedente");
                var valorecupera = this._getIndicador(value[i].indicador);
                totalindicadores = totalindicadores + "," + valorecupera;

            }

            var arregloindicadores = [];
            if(value== "" || value == null){
                arregloindicadores = [0];

            }else{
                arregloindicadores =  totalindicadores.split (",");

            }

            var direccionesfaltantes = "";

            if (arregloindicadores.indexOf("1") == -1){
                direccionesfaltantes = direccionesfaltantes + 'Correspondencia<br>';
            }
            if (arregloindicadores.indexOf("2") == -1){
                direccionesfaltantes = direccionesfaltantes + 'Fiscal<br>';
            }
            if (arregloindicadores.indexOf("4") == -1){
                direccionesfaltantes = direccionesfaltantes + 'Entrega de Bienes<br>';
            }

            if ( direccionesfaltantes != "") {
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
            if (this.model.get('tipo_registro_c') == 'Persona') {
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

                }
                if (this.model.get('tipodepersona_c') == 'Persona Fisica con Actividad Empresarial') {
                    if (this.model.get('tct_macro_sector_ddw_c') == "" || this.model.get('tct_macro_sector_ddw_c') == null) {
                        errors['tct_macro_sector_ddw_c'] = errors['tct_macro_sector_ddw_c'] || {};
                        errors['tct_macro_sector_ddw_c'].required = true;
                    }
                }

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
                app.alert.show('Error_ventas_anuales', {
                    level: 'error',
                    autoClose: false,
                    messages: 'el campo <b>ventas anuales</b> debe tener un valor mayor a 0.'
                });
            }
            if (this.model.get('activo_fijo_c') == undefined || this.model.get('activo_fijo_c') == "" || (Number(this.model.get('activo_fijo_c')) <= 0 ))  {
                errors['activo_fijo_c'] = "Este campo debe tener un valor mayor a 0.";
                errors['activo_fijo_c'].required = true;
                app.alert.show('Error_activof', {
                    level: 'error',
                    autoClose: false,
                    messages: 'el campo <b>activo fijo</b> debe tener un valor mayor a 0.'
                });
            }
        }
        callback(null, fields, errors);
    },


})
