({
    extendsFrom: 'RecordView',
    /**
     * @author bdekoning@levementum.com
     * @date 6/9/15
     * @brief Override for handleCancel to ensure the account_telefonos attribute is properly reverted
     *
     * @override
     */
    oculta: 0,

    initialize: function (options) {
        self = this;
        contexto_cuenta = this;
        self.hasContratosActivos = false;
        this._super("initialize", [options]);

        this.context.on('button:cancel_button:click', this.handleCancel, this);


        this.totalllamadas = 0;
        this.totalreuniones = 0;
        this.flagheld = 0;

        //Funcion que quita los años futuros y menores a -5 del año actual
        this.quitaanos();
        this.model.on("change:tct_ano_ventas_ddw_c", _.bind(this.quitaanos, this));

        //add validation tasks
        this.model.addValidationTask('checkaccdatestatements', _.bind(this.checkaccdatestatements, this));
        this.model.addValidationTask('duplicate_check', _.bind(this.DuplicateCheck, this));
        this.model.addValidationTask('validaduplicadoRFC', _.bind(this.RFC_DuplicateCheck, this));
        this.model.addValidationTask('check_email_telefono', _.bind(this._doValidateEmailTelefono, this));
        this.model.addValidationTask('check_telefonos', _.bind(this.validatelefonos, this));
        this.model.addValidationTask('check_rfc', _.bind(this._doValidateRFC, this));
        this.model.addValidationTask('check_fecha_de_nacimiento', _.bind(this._doValidateMayoriadeEdad, this));
        this.model.addValidationTask('check_account_direcciones', _.bind(this._doValidateDireccion, this));
        //this.model.addValidationTask('check_account_direccionesCP', _.bind(this._doValidateDireccionCP, this));
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
        this.model.addValidationTask('valida_potencial_campos_autos', _.bind(this.nodigitos, this));

        this.model.addValidationTask('valida_potencial', _.bind(this.validapotencial, this));

        this.model.addValidationTask('valida_requeridos', _.bind(this.valida_requeridos, this));

        /*Validacion de campos requeridos en el cuestionario PLD y sus productos
         * Adrian Arauz 23/01/2019
         * */
        this.model.addValidationTask('RequeridosPLD', _.bind(this.validaRequeridosPLD, this));

        this.model.addValidationTask('camposnumericosPLDFF', _.bind(this.validacantidades, this));

        /* F. Javier G. Solar
         OBS299 Validar que las Direcciones no se repitan 21/11/2018
         */

        this.model.addValidationTask('validate_Direccion_Duplicada', _.bind(this._direccionDuplicada, this));

        /*
         Eduardo Carrasco
         revisa que la persona no tenga contratos existentes despues de cambiar el RFC. Si hay contratos existentes, no se podra cambiar el RFC
         */
        this.model.on("change:rfc_c", _.bind(function () {
            var rfc = this.getField('rfc_c');
            /*if (rfc.action === "edit") {
             if (App.user.id!=self.model.get('user_id_c') && App.user.id!= self.model.get('user_id1_c') && App.user.id!= self.model.get('user_id2_c') ) {
             App.alert.show("validar_rfc", {
             level: "error",
             title: "\u00DAnicamente los promotores asociados a la cuenta pueden cambiar el RFC.",
             autoClose: false
             });
             }
             }*/
            if (!_.isEmpty(this.model.get('idcliente_c')) && rfc.action === "edit") {
                app.api.call("read", app.api.buildURL("Accounts/AccountsCustomAPI/" + this.model.get('idcliente_c'), null, null, {}), null, {
                    success: _.bind(function (data) {
                        if (data.UNI2_CTE_029_VerificaClienteTieneContratoResult._tieneContratos == true) {
                            if (App.user.id != self.model.get('user_id_c') && App.user.id != self.model.get('user_id1_c') && App.user.id != self.model.get('user_id2_c') && App.user.id != self.model.get('user_id6_c') && App.user.id != self.model.get('user_id7_c')) {
                                app.alert.show("Validar Contratos", {
                                    level: "error",
                                    title: "\u00DAnicamente los promotores asociados a la cuenta pueden cambiar el RFC a Cliente con contratos existentes.",
                                    autoClose: false
                                });
                                this.cancelClicked();
                                this.$("input[name='rfc_c']").prop("readonly", true);
                            }
                        }
                    }, this)
                });
            }
        }, this));

        //Validacion para el formato de los campos nombre y apellidos.
        this.model.addValidationTask('validaformato3campos', _.bind(this.validaformato, this));
        this.model.addValidationTask('validacamposcurppass', _.bind(this.validapasscurp, this));
        this.model.addValidationTask('porcentajeIVA', _.bind(this.validaiva, this));

        /*
         Salvador Lopez
         Se añaden eventos change para mostrar teléfonos y direcciones al vincular o desvincular algún registro relacionado
         */
        //this.model.on('change:account_telefonos', this.refresca, this);
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
         AA 24/06/2019 Se añade evento para desabilitar el boton genera RFC si la nacionalidad es diferente de Mexicano
         */
        this.model.on('change:tct_pais_expide_rfc_c', this.ocultaRFC, this);

        /*
         Salvador Lopez
         Se añaden eventos change para mostrar u ocultar paneles
         */
        this.model.on('change:tct_fedeicomiso_chk_c', this._hideFideicomiso, this);
        this.model.on('change:tipodepersona_c', this._hidePeps, this);

        this.model.on('change:primernombre_c', this.checkTextOnly, this);
        this.model.on('change:apellidomaterno_c', this.checkTextOnly, this);
        this.model.on('change:apellidopaterno_c', this.checkTextOnly, this);
        this.events['keydown input[name=rfc_c]'] = 'checkTextAndNumRFC';
        this.model.on('change:ifepasaporte_c', this.checkTextAndNum, this);
        this.model.on('change:curp_c', this.checkTextAndNum, this);

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
        //Carga de funcion quitar años lista para ventas anuales
        this.model.on('sync', this.quitaanos, this);
        this.model.on('sync', this.blockRecordNoContactar, this);
        //this.model.on('sync', this._render, this);
        this.model.on('sync', this.hideconfiinfo, this);
        this.model.on('sync', this.disable_panels_rol, this); //@Jesus Carrilllo; metodo que deshabilita panels de acuerdo a rol;
        this.model.on('sync', this.disable_panels_team, this);
        this.model.on('sync', this.fulminantcolor, this); //*@Jesus Carrillo; Funcion que pinta de color los paneles relacionados
        this.model.on('sync', this.valida_centro_prospec, this);
        this.model.on('sync', this.valida_backoffice, this);
        //this.model.on('sync', this.checkTelNorepeat, this);

        /*
         @author Salvador Lopez
         Se llaman a la funciones para mostrar u ocultar paneles de Fideicomiso y Peps
         * */
        this.model.on('sync', this._hideFideicomiso, this);
        this.model.on('sync', this._hidePeps, this);
        // @author Salvador Lopez
        //Se manda a llamar función para omitir opción de Persona en ddw
        this.model.on('sync', this.deleteOptionPersona, this);
        this.model.on('sync', this._ActualizaEtiquetas, this);
        this.model.on('sync', this.muestracheks, this);
        /*Victor Martinez Lopez
         * Deshabilita el campo es proveedor 13-09-2018
         * */
        this.model.on('sync', this.checkProveedor, this);
        //Display or Hide Vista360
        this.model.on('sync', this._hideVista360, this);
        //Solo Lectura campos Origen
        this.model.on('sync', this.readOnlyOrigen, this);
        /* @author F. Javier Garcia S. 10/07/2018
         Agregar dependencia al panel NPS, para ser visible si "Tipo de Cuenta" es "Cliente".
         */
        this.model.on('sync', this._hideNPS, this);
        this.model.on('sync', this.hideButton_Conversion, this);

        //Validacion para mostrar chk para cuentas homonimas
        this.model.on('sync', this.homonimo, this);


        //this.model.on('sync', this.get_phones, this);
        //Recupera datos para custom fields
        this.get_phones();
        this.get_addresses();
        this.get_v360();
        this.get_Oproductos();
        this.get_pld();
        this.get_resumen();
        this.get_analizate();
        //this.get_noviable();
        this.get_uni_productos();


        //Funcion para eliminar duplicados de arrays
        Array.prototype.unique = function (a) {
            return function () {
                return this.filter(a)
            }
        }(function (a, b, c) {
            return c.indexOf(a, b + 1) < 0
        });

        // validación de los campos con formato númerico
        this.events['keydown [name=ventas_anuales_c]'] = 'checkInVentas';
        this.events['keydown [name=activo_fijo_c]'] = 'checkInVentas';
        this.events['keydown [name=tct_prom_cheques_cur_c]'] = 'checkInVentas';
        this.events['keydown [name=tct_depositos_promedio_c]'] = 'checkInVentas';
        this.events['keydown [name=ctpldnoseriefiel_c]'] = 'keyDownNewExtension';
        this.events['keydown [name=tct_cpld_pregunta_u2_txf_c]'] = 'keyDownNewExtension';
        this.events['keydown [name=tct_cpld_pregunta_u4_txf_c]'] = 'keyDownNewExtension';
        //this.events['keydown [name=ctpldnoseriefiel_c]'] = 'checkInVentas';
        this.events['keydown [name=tct_cpld_pregunta_u2_txf_c]'] = 'checkInVentas';
        this.events['keydown [name=tct_cpld_pregunta_u4_txf_c]'] = 'checkInVentas';


        this.model.addValidationTask('guardaProductosPLD', _.bind(this.saveProdPLD, this));
        this.model.addValidationTask('LeasingNV', _.bind(this.requeridosleasingnv, this));
        this.model.addValidationTask('FactorajeNV', _.bind(this.requeridosfacnv, this));
        this.model.addValidationTask('CreditAutoNV', _.bind(this.requeridoscanv, this));
        this.model.addValidationTask('proveedorDeRecursos', _.bind(this.proveedorRecursos, this));
        this.model.addValidationTask('valida_direcciones_de_relaciones_PR', _.bind(this.direccionesparticularPR, this));
        this.model.addValidationTask('set_custom_fields', _.bind(this.setCustomFields, this));
        this.model.addValidationTask('Guarda_campos_auto_potencial', _.bind(this.savepotauto, this));
        /** Logica para Asignación modal **/
        this.model.on('sync', this.hideButtonsModal_Account, this);
        this.context.on('button:get_account_asesor:click', this.get_Account, this);
        this.context.on('button:send_account_asesor:click', this.set_Account, this);

    },

    /** Asignacion modal */
    hideButtonsModal_Account: function () {
        var Boton1 = this.getField("get_account_asesor");
        var Boton2 = this.getField("send_accounts_asesor");
        var userprod = (app.user.attributes.productos_c).replace(/\^/g, "");
        var userpuesto = app.user.attributes.puestousuario_c;
        var puestosBtn1 = ['18', '3', '4', '5', '9', '10', '11', '15', '16', '36', '53'];
        var puestosBtn2 = ['18', '3', '4', '5', '9', '10', '11', '15', '16', '36', '53', '27'];

        if (Boton1) {
            Boton1.listenTo(Boton1, "render", function () {
                console.log(userpuesto);
                if (puestosBtn1.includes(userpuesto)) {
                    Boton1.show();
                } else {
                    Boton1.hide();
                }
            });
        }

        if (Boton2) {
            Boton2.listenTo(Boton2, "render", function () {
                if (puestosBtn2.includes(userpuesto)) {
                    Boton2.show();
                } else {
                    Boton2.hide();
                }
            });
        }
    },

    get_Account: function () {

        if (Modernizr.touch) {
            app.$contentEl.addClass('content-overflow-visible');
        }
        /**check whether the view already exists in the layout.
         * If not we will create a new view and will add to the components list of the record layout
         * */
        var quickCreateView = this.layout.getComponent('getAccountModal');
        if (!quickCreateView) {
            /** Create a new view object */
            quickCreateView = app.view.createView({
                context: this.context,
                name: 'getAccountModal',
                layout: this.layout,
                module: 'Accounts'
            });
            /** add the new view to the components list of the record layout*/
            this.layout._components.push(quickCreateView);
            this.layout.$el.append(quickCreateView.$el);
        }
        /**triggers an event to show the pop up quick create view*/
        this.layout.trigger("app:view:getAccountModal");
    },

    set_Account: function () {
        if (Modernizr.touch) {
            app.$contentEl.addClass('content-overflow-visible');
        }
        /**check whether the view already exists in the layout.
         * If not we will create a new view and will add to the components list of the record layout
         * */
        var quickCreateView = this.layout.getComponent('setAccountModal');
        if (!quickCreateView) {

            /** Create a new view object */
            quickCreateView = app.view.createView({
                context: this.context,
                name: 'setAccountModal',
                layout: this.layout,
                module: 'Accounts'
            });
            /** add the new view to the components list of the record layout*/
            this.layout._components.push(quickCreateView);
            this.layout.$el.append(quickCreateView.$el);
        }
        /**triggers an event to show the pop up quick create view*/
        this.layout.trigger("app:view:setAccountModal");
    },

    saveProdPLD: function (fields, errors, callback) {

        if (this.model.get('tipo_registro_c') != '') {
            // Actualizar modelo de this.ProductosPLD
            // this.ProductosPLD.arrendamientoPuro.campo1 = $('.campo1txt-ap').val();
            if (this.ProductosPLD != null && typeof (this.$('.campo4ddw-cs').select2('val')) == "string") {

                // this.ProductosPLD.arrendamientoPuro.campo1 = this.$('.campo1txt-ap').val();
                this.ProductosPLD.arrendamientoPuro.campo2 = this.$('.campo2ddw-ap').select2('val');
                this.ProductosPLD.arrendamientoPuro.campo3 = this.$('.campo3rel-ap')[0]['innerText'];
                this.ProductosPLD.arrendamientoPuro.campo3_id = this.$('.campo3rel-ap').select2('val');
                this.ProductosPLD.arrendamientoPuro.campo4 = this.$('.campo4ddw-ap').select2('val');
                //this.ProductosPLD.arrendamientoPuro.campo5 = this.$('.campo5rel-ap')[0]['innerText'];
                //this.ProductosPLD.arrendamientoPuro.campo5_id = this.$('.campo5rel-ap').select2('val');
                this.ProductosPLD.arrendamientoPuro.campo6 = this.$('.campo6ddw-ap').select2('val');
                // this.ProductosPLD.arrendamientoPuro.campo7 = this.$('.campo7ddw-ap').select2('val');
                // this.ProductosPLD.arrendamientoPuro.campo8 = this.$('.campo8txt-ap').val();
                // this.ProductosPLD.arrendamientoPuro.campo9 = this.$('.campo9ddw-ap').select2('val');
                // this.ProductosPLD.arrendamientoPuro.campo10 = this.$('.campo10txt-ap').val();
                this.ProductosPLD.arrendamientoPuro.campo11 = this.$('.campo11ddw-ap').select2('val');
                //this.ProductosPLD.arrendamientoPuro.campo13 = this.$('.campo13chk-ap')[0].checked;
                this.ProductosPLD.arrendamientoPuro.campo14 = this.$('.campo14chk-ap')[0].checked;
                this.ProductosPLD.arrendamientoPuro.campo16 = this.$('.campo16ddw-ap').select2('val').toString();
                this.ProductosPLD.arrendamientoPuro.campo17 = this.$('.campo17txt-ap').val();
                this.ProductosPLD.arrendamientoPuro.campo25 = this.$('.campo25ddw-ap').select2('val');
                this.ProductosPLD.arrendamientoPuro.campo26 = this.$('.campo26txt-ap').val();
                // this.ProductosPLD.factorajeFinanciero.campo1 = this.$('.campo1txt-ff').val();
                this.ProductosPLD.factorajeFinanciero.campo2 = this.$('.campo2ddw-ff').select2('val');
                this.ProductosPLD.factorajeFinanciero.campo3 = this.$('.campo3rel-ff').val();
                this.ProductosPLD.factorajeFinanciero.campo3_id = this.$('.campo3rel-ff').select2('val');
                this.ProductosPLD.factorajeFinanciero.campo4 = this.$('.campo4ddw-ff').select2('val');
                //this.ProductosPLD.factorajeFinanciero.campo5 = this.$('.campo5rel-ff').val();
                //this.ProductosPLD.factorajeFinanciero.campo5_id = this.$('.campo5rel-ff').select2('val');
                this.ProductosPLD.factorajeFinanciero.campo21 = this.$('.campo21ddw-ff').select2('val');
                this.ProductosPLD.factorajeFinanciero.campo22 = this.$('.campo22int-ff').val();
                this.ProductosPLD.factorajeFinanciero.campo23 = this.$('.campo23dec-ff').val().replace(/,/gi, "");
                this.ProductosPLD.factorajeFinanciero.campo16 = this.$('.campo16ddw-ff').select2('val').toString();
                this.ProductosPLD.factorajeFinanciero.campo17 = this.$('.campo17txt-ff').val();
                this.ProductosPLD.factorajeFinanciero.campo14 = this.$('.campo14chk-ff')[0].checked;
                this.ProductosPLD.factorajeFinanciero.campo24 = this.$('.campo24ddw-ff').select2('val');
                this.ProductosPLD.factorajeFinanciero.campo6 = this.$('.campo6ddw-ff').select2('val');
                //  this.ProductosPLD.creditoAutomotriz.campo1 = this.$('.campo1txt-ca').val();
                this.ProductosPLD.creditoAutomotriz.campo2 = this.$('.campo2ddw-ca').select2('val');
                this.ProductosPLD.creditoAutomotriz.campo3 = this.$('.campo3rel-ca').val();
                this.ProductosPLD.creditoAutomotriz.campo3_id = this.$('.campo3rel-ca').select2('val');
                this.ProductosPLD.creditoAutomotriz.campo4 = this.$('.campo4ddw-ca').select2('val');
                //this.ProductosPLD.creditoAutomotriz.campo5 = this.$('.campo5rel-ca').val();
                //this.ProductosPLD.creditoAutomotriz.campo5_id = this.$('.campo5rel-ca').select2('val');
                this.ProductosPLD.creditoAutomotriz.campo6 = this.$('.campo6ddw-ca').select2('val');
                // this.ProductosPLD.creditoSimple.campo1 = this.$('.campo1txt-cs').val();
                this.ProductosPLD.creditoSimple.campo2 = this.$('.campo2ddw-cs').select2('val');
                this.ProductosPLD.creditoSimple.campo3 = this.$('.campo3rel-cs').val();
                this.ProductosPLD.creditoSimple.campo3_id = this.$('.campo3rel-cs').select2('val');
                this.ProductosPLD.creditoSimple.campo4 = this.$('.campo4ddw-cs').select2('val');
                //this.ProductosPLD.creditoSimple.campo5 = this.$('.campo5rel-cs').val();
                //this.ProductosPLD.creditoSimple.campo5_id = this.$('.campo5rel-cs').select2('val');
                this.ProductosPLD.creditoSimple.campo18 = this.$('.campo18ddw-cs').select2('val').toString();
                this.ProductosPLD.creditoSimple.campo19 = this.$('.campo19txt-cs').val();
                this.ProductosPLD.creditoSimple.campo14 = this.$('.campo14chk-cs')[0].checked;
                this.ProductosPLD.creditoSimple.campo20 = this.$('.campo20ddw-cs').select2('val');
                this.ProductosPLD.creditoSimple.campo6 = this.$('.campo6ddw-cs').select2('val');
            }

            //Valida cambios
            if ($.isEmptyObject(errors) && (this.inlineEditMode == false || (this.inlineEditMode && typeof ($('.campo4ddw-cs').select2('val')) == "string"))) {
                //var obj_pld_old=JSON.stringify(this.model.get('accounts_tct_pld_1'));
                //var obj_pld_new=JSON.stringify(this.ProductosPLD);
                app.api.call('create', app.api.buildURL('SavePLD'), this.ProductosPLD, {
                    success: function (data) {
                        if (data != "") {
                            console.log("Actualiza pld");
                        }
                        contexto_cuenta.ProductosPLD = pld.formatDetailPLD(contexto_cuenta.ProductosPLD);
                        pld.ProductosPLD = contexto_cuenta.ProductosPLD;
                        contexto_cuenta.prev_ProductosPLD = app.utils.deepCopy(contexto_cuenta.ProductosPLD);
                        pld.render();
                        callback(null, fields, errors);
                    },
                    error: function (e) {
                        //throw e;
                        pld.render();
                        callback(null, fields, errors);
                    }
                });
            } else {
                // contexto_cuenta.ProductosPLD = pld.formatDetailPLD(contexto_cuenta.ProductosPLD);
                // pld.ProductosPLD = contexto_cuenta.ProductosPLD;
                // pld.render();
                callback(null, fields, errors);
            }
        } else {
            // contexto_cuenta.ProductosPLD = pld.formatDetailPLD(contexto_cuenta.ProductosPLD);
            // pld.ProductosPLD = contexto_cuenta.ProductosPLD;
            // pld.render();
            callback(null, fields, errors);
        }
    },

    /* F. Javier G. Solar
     OBS299 Validar que las Direcciones no se repitan 21/11/2018
     */
    _direccionDuplicada: function (fields, errors, callback) {

        /* SE VALIDA DIRECTAMENTE DE LOS ELEMENTOS DEL HTML POR LA COMPLEJIDAD DE
         OBETENER LAS DESCRIPCIONES DE LOS COMBOS*/

        //var objDirecciones = $('.control-group.direccion')
        var objDirecciones = $('.control-group.direccion')
        var concatDirecciones = [];
        var strDireccionTemp = "";
        for (var i = 0; i < objDirecciones.length - 1; i++) {
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

        if (existe) {
            app.alert.show('Direcci\u00F3n', {
                level: 'error',
                autoClose: false,
                messages: 'Existe una o mas direcciones repetidas'
            });
            var messages1 = 'Existe una o mas direcciones repetidas';
            errors['xd'] = errors['xd'] || {};
            // errors['xd'].messages1 = true;
            errors['xd'].required = true;
        }

        callback(null, fields, errors);
    },

    checkInVentas: function (evt) {
        var enteros = this.checkmoneyint(evt);
        var decimales = this.checkmoneydec(evt);
        $.fn.selectRange = function (start, end) {
            if (!end) end = start;
            return this.each(function () {
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
            $.fn.getCursorPosition = function () {
                var el = $(this).get(0);
                var pos = [];
                if ('selectionStart' in el) {
                    pos = [el.selectionStart, el.selectionEnd];
                } else if ('selection' in document) {
                    el.focus();
                    var Sel = document.selection.createRange();
                    var SelLength = document.selection.createRange().text.length;
                    Sel.moveStart('character', -el.value.length);
                    pos = Sel.text.length - SelLength;
                }
                return pos;
            }
        })(jQuery); //funcion para obtener cursor
        var cursor = $(evt.handleObj.selector).getCursorPosition();//setear cursor


        if (enteros == "false" && decimales == "false") {
            if (cursor[0] == cursor[1]) {
                return false;
            }
        } else if (typeof enteros == "number" && decimales == "false") {
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
        if ($input.val().includes('.')) {
            var justnum = /[\d]+/;
        } else {
            var justnum = /[\d.]+/;
        }
        var justint = /^[\d]{0,14}$/;

        if ((justnum.test(evt.key)) == false && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
            app.alert.show('error_dinero', {
                level: 'error',
                autoClose: true,
                messages: 'El campo no acepta caracteres especiales.'
            });
            return "false";
        }

        if (typeof digitos[0] != "undefined") {
            if (justint.test(digitos[0]) == false && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
                //console.log('no se cumplen enteros')
                if (!$input.val().includes('.')) {
                    $input.val($input.val() + '.')
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
        if ($input.val().includes('.')) {
            var justnum = /[\d]+/;
        } else {
            var justnum = /[\d.]+/;
        }
        var justdec = /^[\d]{0,1}$/;

        if ((justnum.test(evt.key)) == false && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
            app.alert.show('error_dinero', {
                level: 'error',
                autoClose: true,
                messages: 'El campo no acepta caracteres especiales.'
            });
            return "false";
        }
        if (typeof digitos[1] != "undefined") {
            if (justdec.test(digitos[1]) == false && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
                //console.log('no se cumplen dec')
                return "false";
            } else {
                return "true";
            }
        }
    },


    fulminantcolor: function () {
        $('#space').remove();
        $('.search-filter').find('.control-group').before('<div id="space" style="background-color:#000042"><br></div>');
        // $('.control-group').css("background-color", "#e5e5e5");
        // $('.a11y-wrapper').css("background-color", "#e5e5e5");
        //$('.a11y-wrapper').css("background-color", "#c6d9ff");
    },

    /*Victor Martinez Lopez 12-09-2018
     *La casilla proveedor se debe mantener activa al crear un proveedor
     * */
    checkProveedor: function () {
        if (this.model.get('tipo_registro_c') == 'Proveedor') {
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


    _hideFideicomiso: function () {
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

    _hidePeps: function () {

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
        //Recupera variables
        var origen = this.model.get('origendelprospecto_c');
        var puesto = App.user.attributes.puestousuario_c; //27=> Agente Tel, 31=> Coordinador CP,
        /*
         -- Bloquea campos si;
         1.- Origen es Marketing o Inteligencia de negocio
         2.- Puesto es diferente de Agente Tel. y Coordinador de centro de prospección
         */
        if ((origen == "Marketing" || origen == "Inteligencia de Negocio") && (puesto != '27' && puesto != '31')) {
            //Establece como no editables campos de origen
            this.noEditFields.push('origendelprospecto_c');
            this.noEditFields.push('tct_detalle_origen_ddw_c');
            this.noEditFields.push('tct_origen_base_ddw_c');
            this.noEditFields.push('tct_origen_busqueda_txf_c');
            this.noEditFields.push('medio_digital_c');
            this.noEditFields.push('tct_punto_contacto_ddw_c');
            this.noEditFields.push('evento_c');
            this.noEditFields.push('camara_c');
            this.noEditFields.push('tct_que_promotor_rel_c');
            this.noEditFields.push('como_se_entero_c');
            this.noEditFields.push('cual_c');
            //Deshabilita campos de Origen
            this.$("[data-name='origendelprospecto_c']").attr('style', 'pointer-events:none;');
            this.$("[data-name='tct_detalle_origen_ddw_c']").attr('style', 'pointer-events:none;');
            this.$("[data-name='tct_origen_base_ddw_c']").attr('style', 'pointer-events:none;');
            this.$("[data-name='tct_origen_busqueda_txf_c']").attr('style', 'pointer-events:none;');
            this.$("[data-name='medio_digital_c']").attr('style', 'pointer-events:none;');
            this.$("[data-name='tct_punto_contacto_ddw_c']").attr('style', 'pointer-events:none;');
            this.$("[data-name='evento_c']").attr('style', 'pointer-events:none;');
            this.$("[data-name='camara_c']").attr('style', 'pointer-events:none;');
            this.$("[data-name='tct_que_promotor_rel_c']").attr('style', 'pointer-events:none;');
            this.$("[data-name='como_se_entero_c']").attr('style', 'pointer-events:none;');
            this.$("[data-name='cual_c']").attr('style', 'pointer-events:none;');

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
            app.api.call('delete', app.api.buildURL('Tel_Telefonos/' + idtel), null, {
                success: _.bind(function (data) {
                    console.log('Esto es lo que devuelve la funcion borratel:');
                    console.log(data);
                    console.log(app.api.buildURL('Tel_Telefonos/' + idtel));
                }, this),
                error: _.bind(function (error) {
                    console.log("Este fue el error:", error)
                }, this),
            });
        }
    },

    handleCancel: function () {
        this._super("handleCancel");
        //Teléfonos
        var account_telefonos = app.utils.deepCopy(this.prev_oTelefonos.prev_telefono);
        this.model.set('account_telefonos', account_telefonos);
        this.oTelefonos.telefono = account_telefonos;
        cont_tel.render();

        //Direcciones
        var account_direcciones = app.utils.deepCopy(this.prev_oDirecciones.prev_direccion);
        this.model.set('account_direcciones', account_direcciones);
        this.oDirecciones.direccion = account_direcciones;
        cont_dir.nuevaDireccion = cont_dir.limpiaNuevaDireccion();
        cont_dir.render();

        //PLD
        var accounts_tct_pld_1 = app.utils.deepCopy(this.prev_ProductosPLD);
        this.model.set('accounts_tct_pld_1', accounts_tct_pld_1);
        this.ProductosPLD = accounts_tct_pld_1;
        pld.render();
        //Potencial Autos
        Pautos.autos = app.utils.deepCopy(Pautos.prev_autos);
        this.model.set('potencial_autos', Pautos);
        Pautos.render();
        // this.model._previousAttributes.account_telefonos = account_telefonos;
        // this.model._previousAttributes.account_direcciones = account_direcciones;

        this.$('[data-name="promotorleasing_c"]').attr('style', '');
        this.$('[data-name="promotorfactoraje_c"]').attr('style', '');
        this.$('[data-name="promotorcredit_c"]').attr('style', '');
        this.$('[data-name="promotorfleet_c"]').attr('style', '');

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
            self.noEditFields.push('promotorfleet_c');
            self.noEditFields.push('promotoruniclick_c');
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


        if (App.user.attributes.deudor_factoraje_c != true) {
            //Readonly check factoraje
            self.noEditFields.push('deudor_factor_c');
        }


        //Oculta menú lateral para relaciones
        $('[data-subpanel-link="rel_relaciones_accounts_1"]').find(".dropdown-toggle").hide();

        this._super('_renderHtml');
    },

    _render: function (options) {
        //Oculta menú lateral para relaciones
        $('[data-subpanel-link="rel_relaciones_accounts_1"]').find(".dropdown-toggle").hide();

        this._super("_render");

        //Ocultar campo "No Contactar" siempre. Se agregó a la vista para que esté disponible a través de this.model
        $('[data-name="tct_no_contactar_chk_c"]').hide();

        //campo Pais que expide el RFC nace oculto.
        // $('[data-name=tct_pais_expide_rfc_c]').hide();
        // $('div[data-name=accounts_tct_pld]').find('div.record-label').addClass('hide');
        //$('[data-name=tct_nuevo_pld_c]').hide(); //Oculta campo tct_nuevo_pld_c
        //Oculta la etiqueta del campo PLD
        this.$('div[data-name=accounts_tct_pld]').find('div.record-label').addClass('hide');
        //Oculta nombre de campo Potencial_Autos
        $("div.record-label[data-name='potencial_autos']").attr('style', 'display:none;');
        //Oculta etiqueta de Analizate
        this.$("div.record-label[data-name='accounts_analizate']").attr('style', 'display:none;');
        //Oculta etiqueta de uni_productos
        this.$("div.record-label[data-name='account_uni_productos']").attr('style', 'display:none;');

        //Se oculta check de cuenta homonima
        $('div[data-name=tct_homonimo_chk_c]').hide();
        //Oculta etiqueta del campo Tipo de Cuenta por Producto
        this.$('div[data-name=cuenta_productos]').find('div.record-label').addClass('hide');
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

        //Oculta correo, telefonos y direcciones
        if (this.oculta === 1) {
            $('div[data-name=account_telefonos]').hide();
            $('div[data-name=email]').hide();
            $('div[data-name=account_direcciones]').hide();
        }
        else {
            $('div[data-name=account_telefonos]').show();
            $('div[data-name=email]').show();
            $('div[data-name=account_direcciones]').show();
        }

        //Evento para validar acciones
        $('a.btn.dropdown-toggle.btn-primary').on('click', function (e) {
            contexto_cuenta.hideButton_Conversion_change();
        });
    },

    editClicked: function () {
        this._super("editClicked");

        this.$('[data-name="promotorleasing_c"]').attr('style', 'pointer-events:none');
        this.$('[data-name="promotorfactoraje_c"]').attr('style', 'pointer-events:none');
        this.$('[data-name="promotorcredit_c"]').attr('style', 'pointer-events:none');
        this.$('[data-name="promotorfleet_c"]').attr('style', 'pointer-events:none');
    },

    hideconfiinfo: function () {
        $('div[data-name=account_telefonos]').hide();
        $('div[data-name=email]').hide();
        $('div[data-name=account_direcciones]').hide();
        //self=this;
        if (this.model.get('id') != "") {
            app.api.call('GET', app.api.buildURL('GetUsersBoss/' + this.model.get('id')), null, {
                success: _.bind(function (data) {
                    if (data == false) {
                        this.oculta = 1;
                        $('div[data-name=account_telefonos]').hide();
                        $('div[data-name=email]').hide();
                        $('div[data-name=account_direcciones]').hide();
                    } else {
                        this.oculta = 0;
                        $('div[data-name=account_telefonos]').show();
                        $('div[data-name=email]').show();
                        $('div[data-name=account_direcciones]').show();
                    }
                    return data;
                }, this),
            });
            //self.render();
        }
        console.log("valor fuera " + this.model.get('id'));
    },

    disable_panels_rol: function () {
        if (this.model.get('id') != "") {
            var roles_limit = app.lang.getAppListStrings('edicion_cuentas_list');
            var roles_logged = app.user.attributes.roles;
            var coincide_rol = 0;
            for (var i = 0; i < roles_logged.length; i++) {
                for (var rol_limit in roles_limit) {
                    if (roles_logged[i] == roles_limit[rol_limit]) {
                        coincide_rol++;
                    }
                }
            }
            if (coincide_rol != 0) {
                app.api.call('GET', app.api.buildURL('GetUsersBoss/' + this.model.get('id')), null, {
                    success: _.bind(function (data) {
                        console.log(data);
                        if (data == false) {

                            if (this.model.get('tipo_registro_c') != "Persona") {

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
                    }, this),
                });
                //self.render();
            }
        }
    },

    disable_panels_team: function () {
        if (this.model.get('id') != "") {
            var roles_limit = app.lang.getAppListStrings('edicion_cuentas_list');
            var roles_logged = app.user.attributes.roles;
            var coincide_rol = 0;
            for (var i = 0; i < roles_logged.length; i++) {
                for (var rol_limit in roles_limit) {
                    if (roles_logged[i] == roles_limit[rol_limit]) {
                        coincide_rol++;
                    }
                }
            }
            if (coincide_rol != 0) {
                app.api.call('GET', app.api.buildURL('GetUsersTeams/' + this.model.get('id') + '/Accounts'), null, {
                    success: _.bind(function (data) {
                        console.log(data);
                        if (data == false) {

                            if (this.model.get('tipo_registro_c') != "Persona") {

                                $('.noEdit.fieldset.actions.detail.btn-group').hide();

                                $('i').removeClass('fa-pencil');

                                $('.record-cell').children().not('.normal.index').click(function (e) { //Habilita solo links
                                    e.stopPropagation();
                                    e.preventDefault();
                                    e.stopImmediatePropagation();
                                    return false;
                                });
                            }
                        } else {
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
                    }, this),
                });
                //self.render();
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
        var myField = this.getField("regresalead");
        var myField1 = this.getField("prospectocontactado");
        var myField2 = this.getField("conviertelead");
        var myField3 = this.getField("clienteuniclick");

        if (myField) {
            myField.listenTo(myField, "render", function () {
                var leasingprod = Oproductos.productos.tct_tipo_l_txf_c;
                var factprod = Oproductos.productos.tct_tipo_f_txf_c;
                var caprod = Oproductos.productos.tct_tipo_ca_txf_c;
                var fleetprod = Oproductos.productos.tct_tipo_fl_txf_c;
                var leasingsub = Oproductos.productos.tct_subtipo_l_txf_c;
                var factsub = Oproductos.productos.tct_subtipo_f_txf_c;
                var casub = Oproductos.productos.tct_subtipo_ca_txf_c;
                var fleetsub = Oproductos.productos.tct_subtipo_fl_txf_c;
                var userprod = App.user.attributes.productos_c;
                var logueado = App.user.id;
                var asesorL = this.model.get('user_id_c');
                var asesorF = this.model.get('user_id1_c');
                var asesorCA = this.model.get('user_id2_c');
                var asesorFL = this.model.get('user_id6_c');
                myField.hide();

                if ((leasingprod == "Prospecto" && leasingsub == "Contactado" && userprod.includes('1') && asesorL == logueado) || (factprod == "Prospecto" && factsub == "Contactado" && userprod.includes("4") && asesorF == logueado) || (caprod == "Prospecto" && casub == "Contactado" && userprod.includes("3") && asesorCA == logueado) ||
                    (fleetprod == "Prospecto" && fleetsub == "Contactado" && userprod.includes('6') && asesorFL == logueado)) {
                    myField.show();
                } else {
                    myField.hide();
                }

            });
        }

        if (myField1) {
            myField1.listenTo(myField1, "render", function () {
                myField1.hide();
                var leasingprod = Oproductos.productos.tct_tipo_l_txf_c;
                var factprod = Oproductos.productos.tct_tipo_f_txf_c;
                var caprod = Oproductos.productos.tct_tipo_ca_txf_c;
                var fleetprod = Oproductos.productos.tct_tipo_fl_txf_c;
                var leasingsub = Oproductos.productos.tct_subtipo_l_txf_c;
                var factsub = Oproductos.productos.tct_subtipo_f_txf_c;
                var casub = Oproductos.productos.tct_subtipo_ca_txf_c;
                var fleetsub = Oproductos.productos.tct_subtipo_fl_txf_c;
                var userprod = App.user.attributes.productos_c;
                var logueado = App.user.id;
                var asesorL = this.model.get('user_id_c');
                var asesorF = this.model.get('user_id1_c');
                var asesorCA = this.model.get('user_id2_c');
                var asesorFL = this.model.get('user_id6_c');
                //Para mostrar/ocultar el boton de convertir a Lead y Convertir a Prospecto Contactado. 22/08/2018
                if ((leasingprod == "Lead" && userprod.includes('1') && asesorL == logueado) || (factprod == "Lead" && userprod.includes("4") && asesorF == logueado) || (caprod == "Lead" && userprod.includes("3") && asesorCA == logueado) ||
                    (fleetprod == "Lead" && userprod.includes('6') && asesorFL == logueado)) {
                    myField1.show();
                } else {
                    myField1.hide();
                }
            });
        }
        if (myField2) {
            myField2.listenTo(myField2, "render", function () {
                var leasingprod = Oproductos.productos.tct_tipo_l_txf_c;
                var factprod = Oproductos.productos.tct_tipo_f_txf_c;
                var caprod = Oproductos.productos.tct_tipo_ca_txf_c;
                var fleetprod = Oproductos.productos.tct_tipo_fl_txf_c;
                var leasingsub = Oproductos.productos.tct_subtipo_l_txf_c;
                var factsub = Oproductos.productos.tct_subtipo_f_txf_c;
                var casub = Oproductos.productos.tct_subtipo_ca_txf_c;
                var fleetsub = Oproductos.productos.tct_subtipo_fl_txf_c;
                var userprod = App.user.attributes.productos_c;
                var logueado = App.user.id;
                var asesorL = this.model.get('user_id_c');
                var asesorF = this.model.get('user_id1_c');
                var asesorCA = this.model.get('user_id2_c');
                var asesorFL = this.model.get('user_id6_c');
                myField2.hide();

                if (((leasingprod == "Proveedor" || leasingprod == "Persona") && userprod.includes('1') && asesorL == logueado) || ((factprod == "Proveedor" || factprod == "Persona") && userprod.includes("4") && asesorF == logueado) || ((caprod == "Proveedor" || caprod == "Persona") && userprod.includes("3") && asesorCA == logueado) ||
                    ((fleetprod == "Proveedor" || fleetprod == "Persona") && userprod.includes('6') && asesorFL == logueado)) {
                    myField2.show();
                } else {
                    myField2.hide();
                }

            });
        }
        if (myField3) {
            myField3.listenTo(myField3, "render", function () {
                var conversioncUC = App.user.attributes.tct_alta_credito_simple_chk_c;
                var userprod = App.user.attributes.productos_c;
                var logueado = App.user.id;
                var uniclickval = Oproductos.productos.tct_tipo_uc_txf_c;
                var asesorUC = this.model.get('user_id7_c');
                myField3.hide();
                if ((uniclickval != "Cliente" && userprod.includes('8') && asesorUC == logueado && conversioncUC == 1)) {
                    myField3.show();
                } else {
                    myField3.hide();
                }

            });
        }
    },

    hideButton_Conversion_change: function () {

        var leasingprod = Oproductos.productos.tct_tipo_l_txf_c;
        var factprod = Oproductos.productos.tct_tipo_f_txf_c;
        var caprod = Oproductos.productos.tct_tipo_ca_txf_c;
        var tipofleet = Oproductos.productos.tct_tipo_fl_txf_c;
        var userprod = App.user.attributes.productos_c;
        var leasingsub = Oproductos.productos.tct_subtipo_l_txf_c;
        var factsub = Oproductos.productos.tct_subtipo_f_txf_c;
        var casub = Oproductos.productos.tct_subtipo_ca_txf_c;
        var subtipofleet = Oproductos.productos.tct_subtipo_fl_txf_c;
        var conversioncUC = App.user.attributes.tct_alta_credito_simple_chk_c;
        var uniclickval = Oproductos.productos.tct_tipo_uc_txf_c;

        var logueado = App.user.id;
        var asesorL = this.model.get('user_id_c');
        var asesorF = this.model.get('user_id1_c');
        var asesorCA = this.model.get('user_id2_c');
        var asesorFL = this.model.get('user_id6_c');
        var asesorUC = this.model.get('user_id7_c');
        //oculta botones
        $('[name="regresalead"]').hide();
        $('[name="prospectocontactado"]').hide();
        $('[name="conviertelead"]').hide();
        $('[name="clienteuniclick"]').hide();

        //Evaluación para mostrar botones
        /*
         * Regresar a lead:
         * tipo_registro_c = Prospecto
         * && subtipo_cuenta_c = Contactado
         */
        if ((leasingprod == "Prospecto" && leasingsub == "Contactado" && userprod.includes('1') && asesorL == logueado) || (factprod == "Prospecto" && factsub == "Contactado" && userprod.includes("4") && asesorF == logueado) || (caprod == "Prospecto" && casub == "Contactado" && userprod.includes("3") && asesorCA == logueado) ||
            (tipofleet == "Prospecto" && subtipofleet == "Contactado" && userprod.includes('6') && asesorFL == logueado)) {
            $('[name="regresalead"]').show();
            $('[name="prospectocontactado"]').hide();
            $('[name="conviertelead"]').hide();
            $('[name="conviertelead"]').hide();
        }

        //Evaluación para mostrar botones
        /*
         * Prospecto contactado:
         * tipo_registro_c = Lead
         */
        if ((leasingprod == "Lead" && userprod.includes('1') && asesorL == logueado) || (factprod == "Lead" && userprod.includes("4") && asesorF == logueado) || (caprod == "Lead" && userprod.includes("3") && asesorCA == logueado) || (tipofleet == "Lead" && userprod.includes('6') && asesorFL == logueado)) {
            $('[name="regresalead"]').hide();
            $('[name="prospectocontactado"]').show();
            $('[name="conviertelead"]').hide();
            $('[name="conviertelead"]').hide();
        }

        /*
         * Conviert a Lead:
         * tipo_registro_c = Persona
         * OR tipo_registro_c = Proveedor
         */
        if (((leasingprod == "Persona" || leasingprod == "Proveedor") && userprod.includes('1') && asesorL == logueado) || ((factprod == "Persona" || factprod == "Proveedor") && userprod.includes("4") && asesorF == logueado) || ((caprod == "Persona" || caprod == "Proveedor") && userprod.includes("3") && asesorCA == logueado) || ((tipofleet == "Persona" || tipofleet == "Proveedor") && userprod.includes('6') && asesorFL == logueado)) {
            $('[name="regresalead"]').hide();
            $('[name="prospectocontactado"]').hide();
            $('[name="conviertelead"]').show();
            $('[name="conviertelead"]').hide();
        }

        //Evaluación para mostrar botones
        /*
         * Convertir Cliente Uniclick
         * tipo_registro_c = Lead
         */
        if ((uniclickval != "Cliente" && userprod.includes('8') && asesorUC == logueado && conversioncUC == 1)) {
            $('[name="regresalead"]').hide();
            $('[name="clienteuniclick"]').show();
            $('[name="conviertelead"]').hide();
            $('[name="prospectocontactado"]').hide();
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

    //Evento no acepta numeros, solo letras (a-z).
    checkTextOnly: function () {
        app.alert.dismiss('Error_validacion_Campos');
        var camponame = "";
        var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
        if (this.model.get('primernombre_c') != "" && this.model.get('primernombre_c') != undefined) {
            var nombre = this.model.get('primernombre_c');
            var comprueba = expresion.test(nombre);
            if (comprueba != true) {
                camponame = camponame + '<b>-Primer Nombre<br></b>';
                ;
            }
        }
        if (this.model.get('apellidopaterno_c') != "" && this.model.get('apellidopaterno_c') != undefined) {
            var apaterno = this.model.get('apellidopaterno_c');
            var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
            var validaap = expresion.test(apaterno);
            if (validaap != true) {
                camponame = camponame + '<b>-Apellido Paterno<br></b>';
                ;
            }
        }
        if (this.model.get('apellidomaterno_c') != "" && this.model.get('apellidomaterno_c') != undefined) {
            var amaterno = this.model.get('apellidomaterno_c');
            var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
            var validaam = expresion.test(amaterno);
            if (validaam != true) {
                camponame = camponame + '<b>-Apellido Materno<br></b>';
                ;
            }
        }
        if (camponame) {
            app.alert.show("Error_validacion_Campos", {
                level: "error",
                messages: 'Los siguientes campos no permiten caracteres especiales:<br>' + camponame,
                autoClose: false
            });
        }
    },

    checkTextAndNum: function () {
        //Modificacion a validacion del campo, debe cumplir un formato.
        app.alert.dismiss('Error_validacion_Passport');
        var campoPass = "";
        var expresion = new RegExp(/^[0-9a-zA-Z]+$/g);
        if (this.model.get('ifepasaporte_c') != "" && this.model.get('ifepasaporte_c') != undefined) {
            var nombre = this.model.get('ifepasaporte_c');
            var comprueba = expresion.test(nombre);
            if (comprueba != true) {
                campoPass = campoPass + '<b>-IFE/Pasaporte<br></b>';
            }
        }
        if (this.model.get('curp_c') != "" && this.model.get('curp_c') != undefined) {
            var expresionC = new RegExp(/^[0-9a-zA-Z]+$/g);
            var curp = this.model.get('curp_c');
            var comprueba = expresionC.test(curp);
            if (comprueba != true) {
                campoPass = campoPass + '<b>-CURP<br></b>';
            }
        }
        if (campoPass) {
            app.alert.show("Error_validacion_Passport", {
                level: "error",
                messages: 'Los siguientes campos no permiten el ingreso de caracteres especiales:<br>' + campoPass,
                autoClose: false
            });
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
                if (this.model.get('fechadenacimiento_c') != null && this.model.get('fechadenacimiento_c') != '' && this.model.get('primernombre_c') != null && this.model.get('primernombre_c') != ''
                    && this.model.get('apellidopaterno_c') != null && this.model.get('apellidopaterno_c') != '' && this.model.get('apellidomaterno_c') != null && this.model.get('apellidomaterno_c') != '') {
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
            else {
                if ((this.model.get('razonsocial_c') != null && this.model.get('razonsocial_c') != "") && (this.model.get('fechaconstitutiva_c') != null && this.model.get('fechaconstitutiva_c') != "")) {
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
        var direcciones = this.model.get('account_direcciones_n');
        if (direcciones != undefined) {
            for (i = 0; i < direcciones.length; i++) {
                if (direcciones[i].codigo_postal == '' || direcciones[i].codigo_postal == null) {
                    errors[$(".account_direcciones")] = errors['account_direcciones'] || {};
                    errors[$(".account_direcciones")].required = true;
                    app.alert.show("Direccion requerida", {
                        level: "error",
                        title: "Favor de seleccionar C.P. en direcci\u00F3n: " + direcciones[i].calle + " " + direcciones[i].numext,
                        autoClose: false
                    });
                }

            }
        }
        //Return
        callback(null, fields, errors);
    },

    _doValidateDireccion: function (fields, errors, callback) {
        if (this.model.get('tipo_registro_c') == "Cliente" || this.model.get('tipo_registro_c') == "Proveedor"
            || this.model.get('tipo_registro_c') == "Prospecto" || this.model.get('esproveedor_c') == true) {

            if (_.isEmpty(this.oDirecciones.direccion)) {
                errors[$(".addDireccion")] = errors['account_direcciones'] || {};
                errors[$(".addDireccion")].required = true;

                $('.direcciondashlet').css('border-color', 'red');
                app.alert.show("Direccion requerida", {
                    level: "error",
                    title: "Al menos una direcci\u00F3n es requerida.",
                    autoClose: false
                });
            } else {
                //Valdación Nacional
                if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                    var nacional = 0;
                    console.log('Validacion Dir.Nacional');
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
        this.context.on('button:conversion_cliente_uniclick:click', this.clienteuniclickClicked, this);
        this.context.on('button:cancel_button:click', this.handleCancel, this);
        // this.context.on('button:save_button:click', this.borraTel, this);
        //this.context.on('button:prospecto_contactado:click',this.validaContactado, this);  //se añade validación para validar campos al convertir prospecto contactado.
        this.context.on('button:convierte_lead:click', this.validalead, this);
    },

    /*
     * @author F. Javier G. Solar
     * 18/07/2018
     * El botón tendrá como finalidad cambiar el Tipo y Subtipo de Cuenta.
     * */

    regresa_leadClicked: function () {
        App.alert.show('RegresaAlead', {
            level: 'process',
            title: 'Convirtiendo cuenta, por favor espere.',
        });
        var totalProspecto = 0;
        var totalProspectoG = 0;
        var productousuario = App.user.attributes.productos_c;
        var api_params = {};

        //Validacion para actualizar el producto del usuario logueado asi como el tipo de registro de la cuenta
        //Leasing
        if (Oproductos.productos.tct_tipo_l_txf_c == "Prospecto" && Oproductos.productos.tct_subtipo_l_txf_c == "Contactado") {
            totalProspectoG++;
            if (productousuario.includes('1') && App.user.id == this.model.get('user_id_c')) {
                api_params["tct_tipo_l_txf_c"] = "Lead";
                api_params["tct_subtipo_l_txf_c"] = "En Calificacion";
                api_params["tct_tipo_cuenta_l_c"] = "LEAD EN CALIFICACIÓN";
                totalProspecto++;
            }
        }
        //Factoraje
        if (Oproductos.productos.tct_tipo_f_txf_c == "Prospecto" && Oproductos.productos.tct_subtipo_f_txf_c == "Contactado") {
            totalProspectoG++;
            if (productousuario.includes('4') && App.user.id == this.model.get('user_id1_c')) {
                totalProspecto++;
                api_params["tct_tipo_f_txf_c"] = "Lead";
                api_params["tct_subtipo_f_txf_c"] = "En Calificación";
                api_params["tct_tipo_cuenta_f_c"] = "LEAD EN CALIFICACIÓN";
            }

        }
        //CA
        if (Oproductos.productos.tct_tipo_ca_txf_c == "Prospecto" && Oproductos.productos.tct_subtipo_ca_txf_c == "Contactado") {
            totalProspectoG++;
            if (productousuario.includes('3') && App.user.id == this.model.get('user_id2_c')) {
                totalProspecto++;
                api_params["tct_tipo_ca_txf_c"] = "Lead";
                api_params["tct_subtipo_ca_txf_c"] = "En Calificacion";
                api_params["tct_tipo_cuenta_ca_c"] = "LEAD EN CALIFICACIÓN";
            }
        }
        //Fleet
        if (Oproductos.productos.tct_tipo_fl_txf_c == "Prospecto" && Oproductos.productos.tct_subtipo_fl_txf_c == "Contactado") {
            totalProspectoG++;
            if (productousuario.includes('6') && App.user.id == this.model.get('user_id6_c')) {
                totalProspecto++;
                api_params["tct_tipo_fl_txf_c"] = "Lead";
                api_params["tct_subtipo_fl_txf_c"] = "En Calificación";
                api_params["tct_tipo_cuenta_fl_c"] = "LEAD EN CALIFICACIÓN";
            }
        }
        if (this.model.get("tipo_registro_c") == "Prospecto" && this.model.get("subtipo_cuenta_c") == "Contactado" && totalProspecto == totalProspectoG) {
            //Al entrar en esta condicion significa que solo hay un campo como Prospecto, lo cual puede cambiar de Prospecto a lead
            v360.ResumenCliente.general_cliente.tipo = "LEAD EN CALIFICACIÓN";
            this.model.set("tipo_registro_c", "Lead");
            this.model.set("subtipo_cuenta_c", "En Calificacion");
            this.model.set("tct_tipo_subtipo_txf_c", "LEAD EN CALIFICACIÓN");
            this.model.set("tct_prospecto_contactado_chk_c", false);
            //this.model.set("show_panel_c",0);
            this.model.save();
        }
        if (api_params != undefined) {

            var idC = this.model.get('id');
            var url = app.api.buildURL('tct02_Resumen/' + idC, null, null);
            app.api.call('update', url, api_params, {
                success: _.bind(function (data) {
                    //this._render();
                    app.alert.dismiss('RegresaAlead');
                    Oproductos.productos = data;
                    app.alert.show('alert_change_success', {
                        level: 'success',
                        messages: 'Cambio realizado',
                    });
                    //Actualiza modelo vista v360
                    v360.ResumenCliente.leasing.tipo_cuenta = data.tct_tipo_cuenta_l_c;
                    v360.ResumenCliente.factoring.tipo_cuenta = data.tct_tipo_cuenta_f_c;
                    v360.ResumenCliente.credito_auto.tipo_cuenta = data.tct_tipo_cuenta_ca_c;
                    v360.ResumenCliente.fleet.tipo_cuenta = data.tct_tipo_cuenta_fl_c;
                    Oproductos.render();
                    v360.render();
                })
            });
        }
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
    getllamadas: function (callback) {
        var cday = new Date();
        var llamadas = 0;
        self = this;
        App.api.call("read", app.api.buildURL("Accounts/" + this.model.get('id') + "/link/calls", null, null, {}), null, {
            success: _.bind(function (data) {
                this.datallamadas = data;
                if (data.records.length > 0) {
                    for (var i = 0; i < data.records.length; i++) {
                        var tempdate = Date.parse(data.records[i].date_start);
                        if (tempdate < cday) {
                            if (data.records[i].status == 'Held') { //Conversión de LEAD a Prospecto contactado, solo cuando esten como realizadas
                                llamadas++;
                            }
                        }
                    }
                }
                self.flagheld++;
                callback(llamadas, null, self);
                //This.totalllamadas=llamadas;
                //return llamadas;
            }, this)
        });
    },
    /* @Jesus Carrillo
     Metodo para verificar  las reuniones de la cuenta
     */
    getreuniones: function (callBackResult) {
        var cday = new Date();
        var reuniones = 0;
        self = this;
        App.api.call("read", app.api.buildURL("Accounts/" + this.model.get('id') + "/link/meetings", null, null, {}), null, {
            success: _.bind(function (data) {
                if (data.records.length > 0) {
                    for (var i = 0; i < data.records.length; i++) {
                        var tempdate = Date.parse(data.records[i].date_start);
                        if (tempdate < cday) {
                            if (data.records[i].status == 'Held') { //Conversión de LEAD a Prospecto Contactado, solo cuando esten como realizadas
                                reuniones++;
                            }
                        }
                    }
                }
                //this.totalreuniones=reuniones;
                //return reuniones;
                self.flagheld++;
                callBackResult(null, reuniones, self);
            }, this)
        });
    },
    /* @Jesus Carrillo
     Metodo para validar campos de telefonos y direcciones
     */
    validar_fields: function (valContacto, validar_fields) {
        App.alert.show('loadingConvertir', {
            level: 'process',
            title: 'Convirtiendo cuenta, por favor espere',
        });

        var datos_telefonos = this.oTelefonos.telefono;
        var tipolabel = [];
        var pais = [];
        var estatus = [];
        var datos_dirreciones = this.oDirecciones.direccion;
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
            tipolabel2.push(datos_dirreciones[i].tipodedireccion);
            cp.push(datos_dirreciones[i].postal);
            municipio.push(datos_dirreciones[i].municipio);
            calle.push(datos_dirreciones[i].calle);
            indicador.push(datos_dirreciones[i].indicador);
            ciudad.push(datos_dirreciones[i].ciudad);
            numext.push(datos_dirreciones[i].numext);
            numint.push(datos_dirreciones[i].numint);
            estado.push(datos_dirreciones[i].estado);
            colonia.push(datos_dirreciones[i].colonia);
        }
        var allfields = [tipolabel, pais, estatus, tipolabel2, cp, municipio, calle, indicador, ciudad, numext, numint, estado, colonia];
        var allfields2 = [];
        console.log(allfields);
        var indica_direc_admin = 0;
        for (var i = 0; i < allfields.length; i++) {
            var betext = 0;
            for (var j = 0; j < allfields[i].length; j++) {
                if (allfields[i][j] != null || allfields[i][j] != "") {
                    betext++;
                    if (i == 7) {//si estas apuntando al campo indicador
                        if (allfields[i][j] == '16' || allfields[i][j] == '17' || allfields[i][j] == '18' || allfields[i][j] == '19' || allfields[i][j] == '20' || allfields[i][j] == '21'
                            || allfields[i][j] == '22' || allfields[i][j] == '23' || allfields[i][j] == '24' || allfields[i][j] == '25' || allfields[i][j] == '26' || allfields[i][j] == '27'
                            || allfields[i][j] == '28' || allfields[i][j] == '29' || allfields[i][j] == '30' || allfields[i][j] == '31') {
                            indica_direc_admin++;
                        }
                    }
                }
            }
            if (betext == 0) {
                allfields2.push(false);
            } else {
                allfields2.push(true);
            }
        }
        console.log(allfields2);
        var fieldstelefono = allfields2.slice(0, 2);
        var fieldsdirec = allfields2.slice(3);
        var valMedios = 0;

        if (fieldstelefono.includes(false) == true) {
            App.alert.dismiss('loadingConvertir');
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

        if (valMedios == 0 && valContacto == 0 && validar_fields == 0) {
            if (this.model.get('tipo_registro_c') == "Lead") {
                this.model.set('tipo_registro_c', 'Prospecto');
                this.model.set('subtipo_registro_c', 'Contactado');
                this.model.set('tct_prospecto_contactado_chk_c', true);
                //this.model.set("show_panel_c",1);
                this.model.save();
            }
            var productousuario = App.user.attributes.productos_c;
            var api_params = {};

            if (productousuario.includes('1') && Oproductos.productos.tct_tipo_l_txf_c == "Lead") {
                if (App.user.id == this.model.get('user_id_c')) {
                    api_params["tct_tipo_l_txf_c"] = "Prospecto";
                    api_params["tct_subtipo_l_txf_c"] = "Contactado";
                    api_params["tct_tipo_cuenta_l_c"] = "PROSPECTO CONTACTADO";
                }
            }
            if (productousuario.includes('3') && Oproductos.productos.tct_tipo_ca_txf_c == "Lead") {
                if (App.user.id == this.model.get('user_id2_c')) {
                    api_params["tct_tipo_ca_txf_c"] = "Prospecto";
                    api_params["tct_subtipo_ca_txf_c"] = "Contactado";
                    api_params["tct_tipo_cuenta_ca_c"] = "PROSPECTO CONTACTADO";
                }
            }
            if (productousuario.includes('4') && Oproductos.productos.tct_tipo_f_txf_c == "Lead") {
                if (App.user.id == this.model.get('user_id1_c')) {
                    api_params["tct_tipo_f_txf_c"] = "Prospecto";
                    api_params["tct_subtipo_f_txf_c"] = "Contactado";
                    api_params["tct_tipo_cuenta_f_c"] = "PROSPECTO CONTACTADO";
                }
            }
            if (productousuario.includes('6') && Oproductos.productos.tct_tipo_fl_txf_c == "Lead") {
                if (App.user.id == this.model.get('user_id6_c')) {
                    api_params["tct_tipo_fl_txf_c"] = "Prospecto";
                    api_params["tct_subtipo_fl_txf_c"] = "Contactado";
                    api_params["tct_tipo_cuenta_fl_c"] = "PROSPECTO CONTACTADO";
                }
            }
            if (api_params != undefined) {

                var idC = this.model.get('id');
                var url = app.api.buildURL('tct02_Resumen/' + idC, null, null);
                app.api.call('update', url, api_params, {
                    success: _.bind(function (data) {
                        //this._render();
                        Oproductos.productos = data;
                        app.alert.dismiss('loadingConvertir');
                        app.alert.show('alert_change_success', {
                            level: 'success',
                            messages: 'Cambio realizado',
                        });
                        //Actualiza modelo vista v360
                        v360.ResumenCliente.general_cliente.tipo = "PROSPECTO CONTACTADO";
                        v360.ResumenCliente.leasing.tipo_cuenta = data.tct_tipo_cuenta_l_c;
                        v360.ResumenCliente.factoring.tipo_cuenta = data.tct_tipo_cuenta_f_c;
                        v360.ResumenCliente.credito_auto.tipo_cuenta = data.tct_tipo_cuenta_ca_c;
                        v360.ResumenCliente.fleet.tipo_cuenta = data.tct_tipo_cuenta_fl_c;
                        Oproductos.render();
                        v360.render();
                    })
                });
            }
        }
    },
    /* @Jesus Carrillo
     Metodo que convierte a prospecto contactado
     *Solo promotores y directorees pueden cambiar una cuenta de Lead a Prospecto contactado
     * 22-08-2018 Victor Martínez
     */
    prospectocontactadoClicked: function () {
        App.alert.show('convierteLead_a_Prospecto', {
            level: 'process',
            title: 'Convirtiendo cuenta, por favor espere',
        });
        if ((this.model.get('tipo_registro_c') == "Lead" && $('.campo1chk')[0].checked && $('.campo2chk')[0].checked && $('.campo3chk')[0].checked) &&
            (this.model.get('user_id_c') == "cc736f7a-4f5f-11e9-856a-a0481cdf89eb" && this.model.get('user_id1_c') == "cc736f7a-4f5f-11e9-856a-a0481cdf89eb" && this.model.get('user_id2_c') == "cc736f7a-4f5f-11e9-856a-a0481cdf89eb")) {
            app.alert.dismiss('convierteLead_a_Prospecto');
            app.alert.show("Cumple 3 checks", {
                level: "error",
                title: 'Esta cuenta no se puede convertir a prospecto ya que es un lead no viable en los tres productos.',
                autoClose: false
            });
            return;
        }
        /*var validacion =  this.validaContactado();
         if(validacion == 1){
         return;

         }*/

        self = this;
        self.flagheld = 0;
        if (this.model.get('id') != "") { //en lugar de self es this
            app.api.call('GET', app.api.buildURL('GetUsersBoss/' + this.model.get('id')), null, {
                success: _.bind(function (data) {
                    var usuario = App.user.attributes.puestousuario_c;
                    console.log(data);
                    if (data == false) {


                        if (usuario == "5" ||
                            usuario == "11" ||
                            usuario == "16" ||
                            //Gerentes
                            usuario == "15" ||
                            usuario == "4" ||
                            usuario == "10" ||
                            //subdirectores
                            usuario == "3" ||
                            usuario == "9" ||
                            usuario == "28" ||
                            //Directores
                            usuario == "1" ||
                            usuario == "2" ||
                            usuario == "8" ||
                            usuario == "14" ||
                            usuario == "21"
                            || usuario == "18" //Ajuste para poder trabajar con la cuenta de Wendy
                        ) {

                            //Valida llamadas y reuniones
                            var valRelacionados = 0;
                            //self.getllamadas();
                            //self.getreuniones();
                            app.alert.dismiss('convierteLead_a_Prospecto');
                            app.alert.show('loadcontactado', {
                                level: 'process',
                            });
                            self.getllamadas(this.resultCallback);
                            self.getreuniones(this.resultCallback);

                        }
                        else {
                            app.alert.dismiss('convierteLead_a_Prospecto');
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
                    else if (data == true) {

                        //Valida llamadas y reuniones
                        var valRelacionados = 0;
                        //self.getllamadas();
                        //self.getreuniones();
                        app.alert.dismiss('convierteLead_a_Prospecto');
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

    resultCallback: function (resultLlamadas, resultReuniones, context) {
        self = context;
        var valRelacionados = 0;
        if (resultLlamadas != null) {
            self.totalllamadas = resultLlamadas;

        }
        if (resultReuniones != null) {
            self.totalreuniones = resultReuniones;

        }

        // if (self.totalllamadas != undefined && self.totalreuniones != undefined) {
        if (self.flagheld >= 2) {
            if (self.totalllamadas == 0 && self.totalreuniones == 0) {
                app.alert.dismiss('loadingConvertir');
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
            app.alert.dismiss('loadingConvertir');

        }

    },


    //Validación para que los campos contengan informacion para poder convertir de LEAD a Prospecto/Contactado. Adrian Arauz 15/08/2018
    validaContactado: function () {
        var campos = "";

        if (this.model.get('origendelprospecto_c') == "" || this.model.get('origendelprospecto_c') == null) {
            campos = campos + '<b>Origen, </b>';
        }

        if (this.model.get('name') == "" || this.model.get('name') == null) {
            campos = campos + '<b>Nombre, </b>';
        }

        if ((this.model.get('apellidopaterno_c') == "" || this.model.get('apellidopaterno_c') == null) && this.model.get('tipodepersona_c') != 'Persona Moral') {
            campos = campos + '<b>Apellido Paterno, </b>';
        }

        if (this.model.get('email') == "" || this.model.get('email') == null) {
            campos = campos + '<b>E Mail, </b>';
        }

        if ((this.model.get('nombre_comercial_c') == "" || this.model.get('nombre_comercial_c') == null) && this.model.get('tipodepersona_c') == 'Persona Moral') {
            campos = campos + '<b>Nombre Comercial. </b> ';
        }

        if (campos != "") {
            app.alert.dismiss('loadingConvertir');
            console.log('Validacion Campos OK');
            app.alert.show('alert_calls2', {
                level: 'error',
                messages: 'Para convertir a Prospecto Contactado es necesario se llenen los campos requeridos: <br>' + campos,
            });

            return 1;
        } else {
            return 0;
        }
    },

    //Validaciòn para convertir el tipo de cuenta Persona a LEAD, Adrian Arauz 21/08/2018
    validalead: function () {
        App.alert.show('conviertePaL', {
            level: 'process',
            title: 'Convirtiendo cuenta, por favor espere',
        });
        var reqs = "";
        if (this.model.get('name') == "" || this.model.get('name') == null) {
            reqs = reqs + '<b>Nombre<br></b>';
        }
        if ((this.model.get('apellidopaterno_c') == "" || this.model.get('apellidopaterno_c') == null) && this.model.get('tipodepersona_c') != 'Persona Moral') {
            reqs = reqs + '<b>Apellido Paterno<br></b>';
        }
        if (this.model.get('email') == "" || this.model.get('email') == null) {
            reqs = reqs + '<b>Email<br></b>';
        }
        if ((this.model.get('nombre_comercial_c') == "" || this.model.get('nombre_comercial_c') == null) && this.model.get('tipodepersona_c') == 'Persona Moral') {
            reqs = reqs + '<b>Nombre Comercial<br></b>';
        }
        if (reqs != "") {
            app.alert.dismiss('conviertePaL');
            console.log('Validacion Campos LEAD');
            app.alert.show('alert_calls4', {
                level: 'error',
                messages: 'Para convertir a Lead es necesario que se llenen los siguientes campos requeridos: ' + reqs,
            });
        }
        else {
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
                    if (contains.call(modelo.get('productos_c'), "1") && this.model.get('user_id_c') == "") {
                        this.model.set('promotorleasing_c', modelo.get('name'));
                        this.model.set('user_id_c', modelo.get('id'));
                    } else if (this.model.get('user_id_c') == "") {
                        this.model.set('promotorleasing_c', '9 - Sin Gestor');
                        this.model.set('user_id_c', '569246c7-da62-4664-ef2a-5628f649537e');
                    }
                    if (contains.call(modelo.get('productos_c'), "4") && this.model.get('user_id_c') == "") {
                        this.model.set('promotorfactoraje_c', modelo.get('name'));
                        this.model.set('user_id1_c', modelo.get('id'));
                    } else if (this.model.get('user_id_c') == "") {
                        this.model.set('promotorfactoraje_c', '9 - Sin Gestor');
                        this.model.set('user_id1_c', '569246c7-da62-4664-ef2a-5628f649537e');
                    }
                    if (contains.call(modelo.get('productos_c'), "3") && this.model.get('user_id_c') == "") {
                        this.model.set('promotorcredit_c', modelo.get('name'));
                        this.model.set('user_id2_c', modelo.get('id'));
                    } else if (this.model.get('user_id_c') == "") {
                        this.model.set('promotorcredit_c', '9 - Sin Gestor');
                        this.model.set('user_id2_c', '569246c7-da62-4664-ef2a-5628f649537e');
                    }
                    if (contains.call(modelo.get('productos_c'), "6") && this.model.get('user_id_c') == "") {
                        this.model.set('promotorfleet_c', modelo.get('name'));
                        this.model.set('user_id6_c', modelo.get('id'));
                    } else if (this.model.get('user_id_c') == "") {
                        this.model.set('promotorfleet_c', '9 - Sin Gestor');
                        this.model.set('user_id6_c', '569246c7-da62-4664-ef2a-5628f649537e');
                    }
                    if (contains.call(modelo.get('productos_c'), "8") && this.model.get('user_id_c') == "") {
                        this.model.set('promotoruniclick_c', modelo.get('name'));
                        this.model.set('user_id7_c', modelo.get('id'));
                    } else if (this.model.get('user_id_c') == "") {
                        this.model.set('promotoruniclick_c', '9 - Sin Gestor');
                        this.model.set('user_id7_c', '569246c7-da62-4664-ef2a-5628f649537e');
                    }
                    if (contains.call(modelo.get('productos_c'), "1") == false && contains.call(modelo.get('productos_c'), "3") == false && contains.call(modelo.get('productos_c'), "4") == false && contains.call(modelo.get('productos_c'), "6") == false) {
                        this.model.set('promotorleasing_c', '9 - Sin Gestor');
                        this.model.set('user_id_c', '569246c7-da62-4664-ef2a-5628f649537e');
                        this.model.set('promotorfactoraje_c', '9 - Sin Gestor');
                        this.model.set('user_id1_c', '569246c7-da62-4664-ef2a-5628f649537e');
                        this.model.set('promotorcredit_c', '9 - Sin Gestor');
                        this.model.set('user_id2_c', '569246c7-da62-4664-ef2a-5628f649537e');
                        this.model.set('promotorfleet_c', '9 - Sin Gestor');
                        this.model.set('user_id6_c', '569246c7-da62-4664-ef2a-5628f649537e');
                        this.model.set('promotoruniclick_c', '9 - Sin Gestor');
                        this.model.set('user_id7_c', '569246c7-da62-4664-ef2a-5628f649537e');
                    }

                    if (this.model.get("tipo_registro_c") == "Persona" || this.model.get('tipo_registro_c') == "Proveedor") {
                        v360.ResumenCliente.general_cliente.tipo = "LEAD EN CALIFICACIÓN";
                        this.model.set("tipo_registro_c", "Lead");
                        this.model.set("subtipo_cuenta_list", "En Calificacion");
                        this.model.set("show_panel_c", 1);
                        this.model.save();
                    }
                }, this)
            });
            var productousuario = App.user.attributes.productos_c;
            var api_params = {};

            if ((Oproductos.productos.tct_tipo_l_txf_c == "Persona" || Oproductos.productos.tct_tipo_l_txf_c == "Proveedor") && productousuario.includes('1')) {
                if (App.user.id == this.model.get('user_id_c')) {
                    api_params["tct_tipo_l_txf_c"] = "Lead";
                    api_params["tct_subtipo_l_txf_c"] = "En Calificacion";
                    api_params["tct_tipo_cuenta_l_c"] = "LEAD EN CALIFICACIÓN";
                }

            }
            if ((Oproductos.productos.tct_tipo_ca_txf_c == "Persona" || Oproductos.productos.tct_tipo_ca_txf_c == "Proveedor") && productousuario.includes('3')) {
                if (App.user.id == this.model.get('user_id2_c')) {
                    api_params["tct_tipo_ca_txf_c"] = "Lead";
                    api_params["tct_subtipo_ca_txf_c"] = "En Calificación";
                    api_params["tct_tipo_cuenta_ca_c"] = "LEAD EN CALIFICACIÓN";
                }
            }
            if ((Oproductos.productos.tct_tipo_f_txf_c == "Persona" || Oproductos.productos.tct_tipo_f_txf_c == "Proveedor") && productousuario.includes('4')) {
                if (App.user.id == this.model.get('user_id1_c')) {
                    api_params["tct_tipo_f_txf_c"] = "Lead";
                    api_params["tct_subtipo_f_txf_c"] = "En Calificación";
                    api_params["tct_tipo_cuenta_f_c"] = "LEAD EN CALIFICACIÓN";
                }
            }
            if ((Oproductos.productos.tct_tipo_fl_txf_c == "Persona" || Oproductos.productos.tct_tipo_fl_txf_c == "Proveedor") && productousuario.includes('6')) {
                if (App.user.id == this.model.get('user_id6_c')) {
                    api_params["tct_tipo_fl_txf_c"] = "Lead";
                    api_params["tct_subtipo_fl_txf_c"] = "En Calificación";
                    api_params["tct_tipo_cuenta_fl_c"] = "LEAD EN CALIFICACIÓN";
                }
            }
            if (api_params != undefined) {

                var idC = this.model.get('id');
                var url = app.api.buildURL('tct02_Resumen/' + idC, null, null);
                app.api.call('update', url, api_params, {
                    success: _.bind(function (data) {
                        //this._render();
                        app.alert.dismiss('conviertePaL');
                        Oproductos.productos = data;
                        app.alert.show('alert_change_success', {
                            level: 'success',
                            messages: 'Cambio realizado',
                        });
                        //Actualiza modelo vista v360
                        v360.ResumenCliente.leasing.tipo_cuenta = data.tct_tipo_cuenta_l_c;
                        v360.ResumenCliente.factoring.tipo_cuenta = data.tct_tipo_cuenta_f_c;
                        v360.ResumenCliente.credito_auto.tipo_cuenta = data.tct_tipo_cuenta_ca_c;
                        v360.ResumenCliente.fleet.tipo_cuenta = data.tct_tipo_cuenta_fl_c;
                        Oproductos.render();
                        v360.render();
                        //Deja activa la pestaña de la vista360
                        $('li.tab.LBL_RECORDVIEW_PANEL8').removeAttr("style");
                        $("#recordTab>li.tab").removeClass('active');
                        $('li.tab.LBL_RECORDVIEW_PANEL8').addClass("active");
                    })
                });
            }


        }

    },


    /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 6/12/2015 Description: Persona Fisica and Persona Fisica con Actividad Empresarial must have an email or a Telefono RECORD*/
    _doValidateEmailTelefono: function (fields, errors, callback) {
        if (this.model.get('tipo_registro_c') !== 'Persona' || this.model.get('tipo_registro_c') !== 'Proveedor') {
            if (_.isEmpty(this.model.get('email')) && _.isEmpty(this.oTelefonos.telefono)) {
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

    DuplicateCheck: function (fields, errors, callback) {
        //Valida homonimo
        if (this.model.get('tct_homonimo_chk_c') != true) {
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
                        var usuarios = App.lang.getAppListStrings('usuarios_homonimo_name_list');
                        var etiquetas = "";
                        Object.keys(usuarios).forEach(function (key) {
                            if (key != '') {
                                etiquetas += usuarios[key] + '<br>';
                            }
                        });
                        app.alert.show("DuplicateCheck", {
                            level: "error",
                            messages: "Ya existe una persona registrada con el mismo nombre. Favor de comunicarse con alguno de los siguientes usuarios:<br><b>" + etiquetas + "</b>",
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

                    }
                    callback(null, fields, errors);
                }, this)
            });
        } else {
            callback(null, fields, errors);
        }
    },

    RFC_DuplicateCheck: function (fields, errors, callback) {
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
                        app.alert.show("DuplicateCheck", {
                            level: "error",
                            title: "Ya existe una persona registrada con el mismo RFC.",
                            autoClose: false
                        });

                        errors['rfc_c'] = errors['rfc_c'] || {};
                        errors['rfc_c'].required = true;
                    }
                    callback(null, fields, errors);
                }, this)
            });
        } else {
            callback(null, fields, errors);
        }
    },

    //revisa que no exista un nombre o RFC duplicado
    _doValidateRFC: function (fields, errors, callback) {
        var RFC = this.model.get('rfc_c');
        if (RFC != '' && RFC != null && (RFC != 'XXX010101XXX' && RFC != 'XXXX010101XXX' && this.model.get('tct_pais_expide_rfc_c') == "2")) {
            /*Método que tiene la función de validar el rfc*/
            RFC = RFC.toUpperCase().trim();
            var expReg = "";
            if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                expReg = /^([A-Z\u00D1&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
            } else {
                expReg = /^([A-Z\u00D1&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
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
        if (this.model.get('tipodepersona_c') != 'Persona Moral' && this.model.get('fechadenacimiento_c') != "") {
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
        if (!_.isEmpty(this.model.get('fechaconstitutiva_c')) && this.model.get('tipodepersona_c') == 'Persona Moral') {

            var feccons_date = this.model.get('fechaconstitutiva_c');
            var today_date = new Date().toISOString().slice(0, 10);

            if (feccons_date > today_date) {
                app.alert.show("fechaDeConsValidate", {
                    level: "error",
                    title: "La fecha constitutiva no puede ser mayor al d\u00EDa de hoy",
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
        if (!_.isEmpty(this.model.get('fechadenacimiento_c')) && this.model.get('tipodepersona_c') != 'Persona Moral') {

            var fecnac_date = this.model.get('fechadenacimiento_c');
            var today_date = new Date().toISOString().slice(0, 10);

            if (fecnac_date >= today_date) {
                app.alert.show("fechaDeNacimientoValidate", {
                    level: "error",
                    title: "La fecha de nacimiento no puede ser mayor o igual al d\u00EDa de hoy",
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
                /*app.alert.show("Proveedor Requerido", {
                 level: "error",
                 title: "Debe seleccionar un un tipo de proveedor al menos",
                 autoClose: false
                 });*/
                errors['tipo_proveedor_c'] = errors['tipo_proveedor_c'] || {};
                errors['tipo_proveedor_c'].required = true;
            }
            if (this.model.get('tct_macro_sector_ddw_c') == '' || this.model.get('tct_macro_sector_ddw_c') == null) {
                /*app.alert.show("Macro sector requerido", {
                 level: "error",
                 title: "El campo macro sector es requerido",
                 autoClose: false
                 });*/
                errors['tct_macro_sector_ddw_c'] = errors['tct_macro_sector_ddw_c'] || {};
                errors['tct_macro_sector_ddw_c'].required = true;
            }
            if (this.model.get('rfc_c') == '' || this.model.get('rfc_c') == null) {
                /*app.alert.show("RFC requerido", {
                 level: "error",
                 title: "El campo RFC es requerido",
                 autoClose: false
                 });*/
                errors['rfc_c'] = errors['rfc_c'] || {};
                errors['rfc_c'].required = true;
            }
            if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                /*app.alert.show("Fecha de nacimiento requerida", {
                 level: "error",
                 title: "El campo fecha de nacimiento es requerido",
                 autoClose: false
                 });*/
                if (this.model.get('fechadenacimiento_c') == '' || this.model.get('fechadenacimiento_c') == null) {
                    errors['fechadenacimiento_c'] = errors['fechadenacimiento_c'] || {};
                    errors['fechadenacimiento_c'].required = true;
                }
                /*app.alert.show("Pais de nacimiento requerido", {
                 level: "error",
                 title: "El campo pa\u00EDs de nacimiento es requerido",
                 autoClose: false
                 });*/
                if (this.model.get('pais_nacimiento_c') == '' || this.model.get('pais_nacimiento_c') == null) {
                    errors['pais_nacimiento_c'] = errors['pais_nacimiento_c'] || {};
                    errors['pais_nacimiento_c'].required = true;
                }
                if (this.model.get('estado_nacimiento_c') == "" || this.model.get('estado_nacimiento_c') == null) {
                    errors['estado_nacimiento_c'] = errors['estado_nacimiento_c'] || {};
                    errors['estado_nacimiento_c'].required = true;
                }
                /*app.alert.show("Estado civil requerido", {
                 level: "error",
                 //title: "El campo estado civil es requerido",
                 autoClose: false
                 });*/
                if (this.model.get('estadocivil_c') == '' || this.model.get('estadocivil_c') == null) {
                    errors['estadocivil_c'] = errors['estadocivil_c'] || {};
                    errors['estadocivil_c'].required = true;
                }

                /*app.alert.show("Profesion requerido", {
                 level: "error",
                 title: "El campo profesi\u00F3n es requerido",
                 autoClose: false
                 });*/
                if (this.model.get('profesion_c') == '' || this.model.get('profesion_c') == null) {
                    errors['profesion_c'] = errors['profesion_c'] || {};
                    errors['profesion_c'].required = true;
                }
            }
            else {
                /*app.alert.show("Pais de constitucion", {
                 level: "error",
                 title: "El campo pa\u00EDs de constituci\u00F3n es requerido",
                 autoClose: false
                 });*/
                if (this.model.get('pais_nacimiento_c') == '' || this.model.get('pais_nacimiento_c') == null) {
                    errors['pais_nacimiento_c'] = errors['pais_nacimiento_c'] || {};
                    errors['pais_nacimiento_c'].required = true;
                }
                if (this.model.get('estado_nacimiento_c') == "" || this.model.get('estado_nacimiento_c') == null) {
                    errors['estado_nacimiento_c'] = errors['estado_nacimiento_c'] || {};
                    errors['estado_nacimiento_c'].required = true;
                }
                if (this.model.get('fechaconstitutiva_c') == '' || this.model.get('fechaconstitutiva_c') == null) {
                    errors['fechaconstitutiva_c'] = errors['fechaconstitutiva_c'] || {};
                    errors['fechaconstitutiva_c'].required = true;
                }
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
        if (this.model.get('tipodepersona_c') == "Persona Moral") {
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
        } else {
            original_name = original_name.replace(/\s+/gi, '');
            original_name = original_name.toUpperCase();
            this.model.set("clean_name", original_name);
        }

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

        if (!_.isEmpty(this.oTelefonos.telefono)) {
            var telefono = this.oTelefonos.telefono;
            for (var i = 0; i < telefono.length; i++) {
                if (telefono[i].principal) {
                    //if (telefono[i].pais!='52'){
                    //this.model.set('phone_office', "base" + telefono[i].pais + " " + telefono[i].telefono);
                    //}else{
                    this.model.set('phone_office', "" + telefono[i].telefono);
                    //}
                }
            }
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

    macrosector: function (fields, errors, callback) {
        if (this.model.get('tct_macro_sector_ddw_c') == '' && (this.model.get('tipo_registro_c') == 'Cliente' || this.model.get('tipo_registro_c') == 'Proveedor'
            || this.model.get('esproveedor_c') == true || this.model.get('subtipo_cuenta_c') == 'Interesado' || this.model.get('subtipo_cuenta_c') == 'Integracion de Expediente' || this.model.get('subtipo_cuenta_c') == 'Credito')) {
            errors['tct_macro_sector_ddw_c'] = "Error: Favor de verificar los errores";
            errors['tct_macro_sector_ddw_c'].required = true;
        }
        callback(null, fields, errors);
    },

    sectoreconomico: function (fields, errors, callback) {
        if (this.model.get('tipodepersona_c') != 'Persona Fisica' && this.model.get('sectoreconomico_c') == '' && (this.model.get('tipo_registro_c') == 'Cliente' || this.model.get('tipo_registro_c') == 'Proveedor' || this.model.get('esproveedor_c') == true)) {
            errors['sectoreconomico_c'] = "Error: Favor de verificar los errores";
            errors['sectoreconomico_c'].required = true;
        }
        callback(null, fields, errors);
    },

    validadirecc: function (fields, errors, callback) {
        //Campos requeridos
        var cont = 0;
        var direccion = this.oDirecciones.direccion;
        for (iDireccion = 0; iDireccion < direccion.length; iDireccion++) {
            //Tipo
            if (direccion[iDireccion].tipodedireccion == "") {
                cont++;
                this.$('.multi_tipo_existing ul.select2-choices').eq(iDireccion).css('border-color', 'red');
            } else {
                this.$('.multi_tipo_existing ul.select2-choices').eq(iDireccion).css('border-color', '');
            }
            //Indicador
            if (direccion[iDireccion].indicador == "") {
                cont++;
                this.$('.multi1_n_existing ul.select2-choices').eq(iDireccion).css('border-color', 'red');
            } else {
                this.$('.multi1_n_existing ul.select2-choices').eq(iDireccion).css('border-color', '');
            }
            //Código Postal
            if (direccion[iDireccion].valCodigoPostal == "") {
                cont++;
                this.$('.postalInputTempExisting').eq(iDireccion).css('border-color', 'red');
            } else {
                this.$('.postalInputTempExisting').eq(iDireccion).css('border-color', '');
            }
            //Calle
            if (direccion[iDireccion].calle.trim() == "") {
                cont++;
                this.$('.calleExisting').eq(iDireccion).css('border-color', 'red');
            } else {
                this.$('.calleExisting').eq(iDireccion).css('border-color', '');
            }
            //Número Exterior
            if (direccion[iDireccion].numext.trim() == "") {
                cont++;
                this.$('.numExtExisting').eq(iDireccion).css('border-color', 'red');
            } else {
                this.$('.numExtExisting').eq(iDireccion).css('border-color', '');
            }
        }
        //Muestra error en direcciones existentes
        if (cont > 0) {
            app.alert.show("empty_fields_dire", {
                level: "error",
                messages: "Favor de llenar los campos se\u00F1alados en <b> Direcciones </b> .",
                autoClose: false
            });
            errors['dire_direccion_req'] = errors['dire_direccion_req'] || {};
            errors['dire_direccion_req'].required = true;

        }

        //Valida direcciones duplicadas
        if (direccion.length > 0) {
            var coincidencia = 0;
            var indices = [];
            for (var i = 0; i < direccion.length; i++) {
                for (var j = 0; j < direccion.length; j++) {
                    if (i != j && direccion[j].calle.trim().toLowerCase() + direccion[j].ciudad + direccion[j].colonia + direccion[j].estado + direccion[j].municipio + direccion[j].numext.trim().toLowerCase() + direccion[j].pais + direccion[j].postal == direccion[i].calle.trim().toLowerCase() + direccion[i].ciudad + direccion[i].colonia + direccion[i].estado + direccion[i].municipio + direccion[i].numext.trim().toLowerCase() + direccion[i].pais + direccion[i].postal) {
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
                if (indices.length > 0) {
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

    validatelefonos: function (fields, errors, callback) {
        var msjError = "";
        var msjErrorT = "";
        var telefono = this.oTelefonos.telefono;
        for (iTelefono = 0; iTelefono < telefono.length; iTelefono++) {
            //Valida valor
            valor4 = telefono[iTelefono].telefono.trim();
            if (valor4 == "") {
                msjError += '<br>-Teléfono vacío';
            } else {
                //Valida númerico
                var valNumerico = /^\d+$/;
                if (!valNumerico.test(valor4)) {
                    msjError += '<br>-Solo números son permitidos';
                }
                //Valida longitud
                if (valor4.length < 8) {
                    msjError += '<br>-Debe contener 8 o más dígitos';
                }
                //Valida números repetidos
                if (valor4.length > 1) {
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
            if (msjError != "") {
                msjErrorT += '<br><b>' + valor4 + '</b> :' + msjError + '<br>';
                $('.Telefonot').eq(iTelefono).css('border-color', 'red');
            }
            msjError = "";
        }
        //Muestra errores
        if (msjErrorT != "") {
            app.alert.show('phone_save_error', {
                level: 'error',
                autoClose: false,
                messages: 'Formato de teléfono(s) incorrecto:' + msjErrorT
            });
            //Agrega errores
            errors['Tel_Telefonos_numero'] = errors['Tel_Telefonos_numero'] || {};
            errors['Tel_Telefonos_numero'].required = true;
        }

        //Valida duplicados
        if (telefono.length > 0) {
            var coincidencia = 0;
            var indices = [];
            for (var i = 0; i < telefono.length; i++) {
                for (var j = 0; j < telefono.length; j++) {
                    if (telefono[j].telefono == telefono[i].telefono && i != j) {
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
                if (indices.length > 0) {
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


    valida_backoffice: function () {
        var roles_limit = app.lang.getAppListStrings('roles_limit_list');
        var roles_logged = app.user.attributes.roles;
        var coincide_rol = 0;
        for (var i = 0; i < roles_logged.length; i++) {
            for (var rol_limit in roles_limit) {
                if (roles_logged[i] == roles_limit[rol_limit]) {
                    coincide_rol++;
                }
            }
        }
        if (coincide_rol != 0) {
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
                }, this),
            });
        }
    },

    valida_centro_prospec: function () {
        var roles_limit = app.lang.getAppListStrings('roles_limit_list_2');
        var roles_logged = app.user.attributes.roles;
        var coincide_rol = 0;
        for (var i = 0; i < roles_logged.length; i++) {
            for (var rol_limit in roles_limit) {
                if (roles_logged[i] == roles_limit[rol_limit]) {
                    coincide_rol++;
                }
            }
        }
        if (coincide_rol != 0) {
            if (this.model.get('tipo_registro_c') != "Lead") {
                app.alert.show("No Rol2", {
                    level: "error",
                    title: "No puedes ver la cuenta ya que no tienes  el perfil adecuado.",
                    autoClose: false,
                    return: false,
                });
                app.router.navigate('#Accounts', {trigger: true});
            } else {
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
                    }, this),
                });
            }
        }
    },

    //Funcion que valida el contenido ingresado en el campo del Email
    expmail: function (fields, errors, callback) {
        if (this.model.get('email') != null && this.model.get('email') != "") {

            var input = (this.model.get('email'));
            var expresion = /^\S+@\S+\.\S+[$%&|<>#]?$/;
            var cumple = true;

            for (i = 0; i < input.length; i++) {

                if (expresion.test(input[i].email_address) == false) {
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
                direccionesfaltantes = direccionesfaltantes + 'Fiscal<br>';
            }
            if (direccionesfaltantes != "") {

                app.alert.show('Error al validar Direcciones', {
                    level: 'error',
                    autoClose: false,
                    messages: 'Debe tener las siguientes direcciones: <br><b>' + direccionesfaltantes + '</b>'
                })
                /****************Se agrega requerido campo Tipo de Dirección para Fiscal************/
                this.$('#s2id_multiIndicador .select2-choices').css('border-color', 'red');
            }
            else {
                this.$('#s2id_multiIndicador .select2-choices').css('border-color', '');
            }
            if (this.model.get('tipodepersona_c') == "Persona Moral" && (this.model.get('razonsocial_c') == "" || this.model.get('razonsocial_c') == null)) {
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

    _getIndicador: function (idSelected, valuesSelected) {

        //variable con resultado
        var result = null;

        //Arma objeto de mapeo
        var dir_indicador_map_list = app.lang.getAppListStrings('dir_indicador_map_list');

        var element = {};
        var object = [];
        var values = [];

        for (var key in dir_indicador_map_list) {
            var element = {};
            element.id = key;
            values = dir_indicador_map_list[key].split(",");
            element.values = values;
            object.push(element);
        }

        //Recupera arreglo de valores por id
        if (idSelected) {
            for (var i = 0; i < object.length; i++) {
                if ((object[i].id) == idSelected) {
                    result = object[i].values;
                }
            }
            console.log(result);
        }

        //Recupera id por valores
        if (valuesSelected) {
            result = [];
            for (var i = 0; i < object.length; i++) {
                if (object[i].values.length == valuesSelected.length) {
                    //Ordena arreglos y compara
                    valuesSelected.sort();
                    object[i].values.sort();
                    var tempVal = true;
                    for (var j = 0; j < valuesSelected.length; j++) {
                        if (valuesSelected[j] != object[i].values[j]) {
                            tempVal = false;
                        }
                    }
                    if (tempVal == true) {
                        result[0] = object[i].id;
                    }

                }
            }

            console.log(result);
        }

        return result;
    },

    validapotencial: function (fields, errors, callback) {

        if ((this.model.get('tipo_registro_c') == 'Prospecto' && this.model.get('subtipo_cuenta_c') == 'Integracion de Expediente') || this.model.get('tipo_registro_c') == 'Cliente') {
            if (this.model.get('ventas_anuales_c') == undefined || this.model.get('ventas_anuales_c') == "" || (Number(this.model.get('ventas_anuales_c')) <= 0)) {
                errors['ventas_anuales_c'] = "Este campo debe tener un valor mayor a 0.";
                errors['ventas_anuales_c'].required = true;
                app.alert.show('Error_ventas_anuales', {
                    level: 'error',
                    autoClose: false,
                    messages: 'El campo <b>ventas anuales</b> debe tener un valor mayor a 0.'
                });
            }
            if (this.model.get('tct_ano_ventas_ddw_c') == undefined || this.model.get('tct_ano_ventas_ddw_c') == "") {
                errors['tct_ano_ventas_ddw_c'] = "Se debe seleccionar el año de ventas";
                errors['tct_ano_ventas_ddw_c'].required = true;
            }
            if (this.model.get('activo_fijo_c') == undefined || this.model.get('activo_fijo_c') == "" || (Number(this.model.get('activo_fijo_c')) <= 0)) {
                errors['activo_fijo_c'] = "Este campo debe tener un valor mayor a 0.";
                errors['activo_fijo_c'].required = true;
                app.alert.show('Error_activof', {
                    level: 'error',
                    autoClose: false,
                    messages: 'El campo <b>activo fijo</b> debe tener un valor mayor a 0.'
                });
            }
        }
        callback(null, fields, errors);
    },

    valida_requeridos: function (fields, errors, callback) {
        var campos = "";
        _.each(errors, function (value, key) {
            _.each(this.model.fields, function (field) {
                if (_.isEqual(field.name, key)) {
                    if (field.vname) {
                        if (field.vname == 'LBL_PAIS_NACIMIENTO_C' && this.model.get('tipodepersona_c') == 'Persona Moral') {
                            campos = campos + '<b>País de constitución</b><br>';
                        }
                        else {
                            if (field.vname == 'LBL_ESTADO_NACIMIENTO' && this.model.get('tipodepersona_c') == 'Persona Moral') {
                                campos = campos + '<b>Estado de constitución</b><br>';
                            }
                            else {
                                campos = campos + '<b>' + app.lang.get(field.vname, "Accounts") + '</b><br>';
                            }
                        }
                    }
                }
            }, this);
        }, this);
        //Remueve campos custom: Teléfonos, Direcciones, Correo
        campos = campos.replace("<b>Telefonos</b><br>", "");
        campos = campos.replace("<b>Direcciones</b><br>", "");
        campos = campos.replace("<b>Dirección de Correo Electrónico</b><br>", "");

        if (campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información en la <b>Cuenta:</b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    validaRequeridosPLD: function (fields, errors, callback) {
        var faltantesAP = "";
        var faltantesFF = "";
        var faltantesCA = "";
        var faltantesCS = "";

        //Valida requeridos a partir de Prospecto Interesado
        var tipoCuenta = this.model.get('tipo_registro_c');
        var subtipoCuenta = this.model.get('subtipo_cuenta_c');
        if (tipoCuenta != '') {
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
                if ($('.campo3rel-ap')[0]['innerText'] == '' && this.model.get('tipodepersona_c') != 'Persona Moral' && $('.campo2ddw-ap').select2('val') == '2') {
                    $('.campo3rel-ap').find('.select2-choice').css('border-color', 'red');
                    faltantesAP = faltantesAP + '<b>- ' + $('.campo3rel-ap')[1].getAttribute('data-name') + '<br></b>';
                } else {
                    $('.campo3rel-ap').find('.select2-choice').css('border-color', '');
                }
                //Pregunta: campo4ddw-ap
                /*if($('.campo4ddw-ap').select2('val') == ''){
                 $('.campo4ddw-ap').find('.select2-choice').css('border-color','red');
                 faltantesAP = faltantesAP + '<b>- '+$('select.campo4ddw-ap')[0].getAttribute('data-name')+'<br></b>';
                 }else{
                 $('.campo4ddw-ap').find('.select2-choice').css('border-color','');
                 }*/
                //Pregunta: campo5rel-ap
                /*if($('.campo5rel-ap')[0]['innerText'] == '' && $('.campo4ddw-ap').select2('val')=='2'){
                 $('.campo5rel-ap').find('.select2-choice').css('border-color','red');
                 faltantesAP = faltantesAP + '<b>- '+$('.campo5rel-ap')[1].getAttribute('data-name')+'<br></b>';
                 }else{
                 $('.campo5rel-ap').find('.select2-choice').css('border-color','');
                 }*/
                /*//Pregunta: campo7ddw-ap
                 if($('.campo7ddw-ap').select2('val') == '' && this.model.get('tipodepersona_c') == 'Persona Moral'){
                 $('.campo7ddw-ap').find('.select2-choice').css('border-color','red');
                 faltantesAP = faltantesAP + '<b>- '+$('select.campo7ddw-ap')[0].getAttribute('data-name')+'<br></b>';
                 }
                 if ($('.campo8txt-ap').val() == '' && $('.campo7ddw-ap').select2('val')=='Si' && this.model.get('tipodepersona_c') == 'Persona Moral'){
                 $('.campo8txt-ap').css('border-color','red');
                 faltantesAP = faltantesAP + '<b>- '+$('.campo8txt-ap')[0].getAttribute('data-name')+'<br></b>';
                 }else{
                 $('.campo8txt-ap').find('.select2-choice').css('border-color','');
                 }
                 if ($('.campo10txt-ap').val() == '' && $('.campo9ddw-ap').select2('val')=='Si' && this.model.get('tipodepersona_c') == 'Persona Moral'){
                 $('.campo10txt-ap').css('border-color','red');
                 faltantesAP = faltantesAP + '<b>- '+$('.campo10txt-ap')[0].getAttribute('data-name')+'<br></b>';
                 }else{
                 $('.campo10txt-ap').find('.select2-choice').css('border-color','');
                 }*/
                /* //Pregunta: campo9ddw-ap
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
                if ($('.campo17txt-ap').val() == '' && $('.campo14chk-ap')[0].checked) {
                    $('.campo17txt-ap').css('border-color', 'red');
                    faltantesAP = faltantesAP + '<b>- ' + $('.campo17txt-ap')[0].getAttribute('data-name') + '<br></b>';
                } else {
                    $('.campo17txt-ap').css('border-color', '');
                }
                //Pregunta: campo26txt-ap

                /*if($('.campo26txt-ap').val() == '' && $('.campo11ddw-ap').select2('val')=='No' ){

                 $('.campo26txt-ap').css('border-color','red');
                 faltantesAP = faltantesAP + '<b>- '+$('.campo26txt-ap')[0].getAttribute('data-name')+'<br></b>';
                 }else{
                 $('.campo26txt-ap').css('border-color','');
                 }*/
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
                if ($('.campo3rel-ff')[0]['innerText'] == '' && this.model.get('tipodepersona_c') != 'Persona Moral' && $('.campo2ddw-ff').select2('val') == '2') {
                    $('.campo3rel-ff').find('.select2-choice').css('border-color', 'red');
                    faltantesFF = faltantesFF + '<b>- ' + $('.campo3rel-ff')[1].getAttribute('data-name') + '<br></b>';
                } else {
                    $('.campo3rel-ff').find('.select2-choice').css('border-color', '');
                }
                //Pregunta: campo4ddw-ff
                /* if($('.campo4ddw-ff').select2('val') == ''){
                 $('.campo4ddw-ff').find('.select2-choice').css('border-color','red');
                 faltantesFF = faltantesFF + '<b>- '+$('select.campo4ddw-ff')[0].getAttribute('data-name')+'<br></b>';
                 }else{
                 $('.campo4ddw-ff').find('.select2-choice').css('border-color','');
                 }*/
                //Pregunta: campo5rel-ff
                /*if($('.campo5rel-ff')[0]['innerText'] == '' && $('.campo4ddw-ff').select2('val')=='2'){
                 $('.campo5rel-ff').find('.select2-choice').css('border-color','red');
                 faltantesFF = faltantesFF + '<b>- '+$('.campo5rel-ff')[1].getAttribute('data-name')+'<br></b>';
                 }else{
                 $('.campo5rel-ff').find('.select2-choice').css('border-color','');
                 }*/
                //Pregunta: campo21ddw-ff
                /*  if($('.campo21ddw-ff').select2('val') == ''){
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
                if ($('.campo17txt-ff').val() == '' && $('.campo14chk-ff')[0].checked && $('.campo2ddw-ff').select2('val') == '2') {
                    $('.campo17txt-ff').css('border-color', 'red');
                    faltantesFF = faltantesFF + '<b>- ' + $('.campo17txt-ff')[0].getAttribute('data-name') + '<br></b>';
                } else {
                    $('.campo17txt-ff').css('border-color', '');
                }
            }
            //Valida campos para CA
            if (App.user.attributes.tipodeproducto_c == '3') {
                //Pregunta: campo2ddw-ca
                /*if($('.campo2ddw-ca').select2('val') == '' && this.model.get('tipodepersona_c') != 'Persona Moral'){
                 $('.campo2ddw-ca').find('.select2-choice').css('border-color','red');
                 faltantesCA = faltantesCA + '<b>- '+$('select.campo2ddw-ca')[0].getAttribute('data-name')+'<br></b>';
                 }else{
                 $('.campo2ddw-ca').find('.select2-choice').css('border-color','');
                 }*/
                //Pregunta: campo3rel-ca
                if ($('.campo3rel-ca')[0]['innerText'] == '' && this.model.get('tipodepersona_c') != 'Persona Moral' && $('.campo2ddw-ca').select2('val') == '2') {
                    $('.campo3rel-ca').find('.select2-choice').css('border-color', 'red');
                    faltantesCA = faltantesCA + '<b>- ' + $('.campo3rel-ca')[1].getAttribute('data-name') + '<br></b>';
                } else {
                    $('.campo3rel-ca').find('.select2-choice').css('border-color', '');
                }
                //Pregunta: campo4ddw-ca
                /*if($('.campo4ddw-ca').select2('val') == ''){
                 $('.campo4ddw-ca').find('.select2-choice').css('border-color','red');
                 faltantesCA = faltantesCA + '<b>- '+$('select.campo4ddw-ca')[0].getAttribute('data-name')+'<br></b>';
                 }else{
                 $('.campo4ddw-ca').find('.select2-choice').css('border-color','');
                 }*/
                //Pregunta: campo5rel-ca
                /* if($('.campo5rel-ca')[0]['innerText'] == '' && $('.campo4ddw-ca').select2('val')=='2'){
                 $('.campo5rel-ca').find('.select2-choice').css('border-color','red');
                 faltantesCA = faltantesCA + '<b>- '+$('.campo5rel-ca')[1].getAttribute('data-name')+'<br></b>';
                 }else{
                 $('.campo5rel-ca').find('.select2-choice').css('border-color','');
                 }*/
                //Pregunta: campo6ddw-ca
                /*  if($('.campo6ddw-ca').select2('val') == ''){
                 $('.campo6ddw-ca').find('.select2-choice').css('border-color','red');
                 faltantesCA = faltantesCA + '<b>- '+$('select.campo6ddw-ca')[0].getAttribute('data-name')+'<br></b>';
                 }else{
                 $('.campo6ddw-ca').find('.select2-choice').css('border-color','');
                 }*/
            }
            if ($('.campo2ddw-cs').select2('val') == "2" && $('.campo3rel-cs').select2('val') == "") {
                $('.campo3rel-cs').find('.select2-choice').css('border-color', 'red');
                faltantesCS = faltantesCS + '<b>- ' + $('.campo2ddw-cs')[1].getAttribute('data-name') + '<br></b>';
            }
            if (faltantesCS != "") {
                errors['error_CS'] = errors['error_CS'] || {};
                errors['error_CS'].required = true;
                app.alert.show("Faltante preguntas de Credito Simple", {
                    level: "error",
                    title: "PLD Crédito Simple - Faltan las siguientes preguntas por contestar: <br>" + faltantesCS,
                });

            }
            //Genera alertas
            if (faltantesAP != "") {
                errors['PreguntasAP'] = "";
                errors['PreguntasAP'].required = true;
                app.alert.show("faltantesAP", {
                    level: "error",
                    title: "PLD Arrendamiento puro - Faltan las siguientes preguntas por contestar: <br>" + faltantesAP
                });
            }

            if (faltantesFF != "") {
                errors['PreguntasFF'] = "";
                errors['PreguntasFF'].required = true;
                app.alert.show("faltantesFF", {
                    level: "error",
                    title: "PLD Factoraje financiero - Faltan las siguientes preguntas por contestar: <br>" + faltantesFF
                });
            }

            if (faltantesCA != "") {
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

    checkaccdatestatements: function (fields, errors, callback) {
        if (this.model.get('tct_dates_acc_statements_c') != "") {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }
            if (mm < 10) {
                mm = '0' + mm
            }
            today = yyyy + '-' + mm + '-' + dd;

            this.obj_dates = JSON.parse(this.model.get('tct_dates_acc_statements_c'));
            var c = 0;
            for (var elem in this.obj_dates) { // revisar con Axel antes subir venia let cambie por var
                if (this.obj_dates[elem].trim() == "") {
                    $('#' + elem).css('border-color', 'red');
                    c++;
                }
            }
            if (c > 0) {
                app.alert.show("empty_date", {
                    level: "error",
                    title: "Existen fechas de los estados de cuenta <b>vac\u00EDas</b>, favor de verificar",
                    autoClose: false
                });

                errors['empty_date'] = errors['empty_date'] || {};
                errors['empty_date'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    keyDownNewExtension: function (evt) {
        if (!evt) return;
        if (!this.validanumeros(evt)) {
            return false;
        }
    },
    validanumeros: function (evt) {
        if ($.inArray(evt.keyCode, [110, 188, 45, 33, 36, 35, 34, 8, 9, 20, 16, 17, 37, 40, 39, 38, 16, 49, 50, 51, 52, 53, 54, 55, 56, 57, 48, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105]) < 0) {
            app.alert.show("Caracter Invalido", {
                level: "error",
                title: "Solo n\u00FAmeros son permitidos en este campo.",
                autoClose: true
            });
            return false;

        } else {
            return true;
        }
    },

    validacantidades: function (fields, errors, callback) {
        if ($('.campo23dec-ff').val() != "" && $('.campo23dec-ff').val() != undefined && $('.campo23dec-ff').val() <= 0) {
            $('.campo23dec-ff').css('border-color', 'red');
            app.alert.show("Valor Invalido", {
                level: "error",
                title: "El campo Número de pagos no debe tener un valor menor a 0.",
                autoClose: true
            });
            errors['campo23dec-ff'] = "El campo Número de pagos no debe tener un valor menor a 0.";
            errors['campo23dec-ff'].required = true;
        }
        if ($('.campo22int-ff').val() != "" && $('.campo22int-ff').val() != undefined && $('.campo22int-ff').val() <= 0) {
            $('.campo22int-ff').css('border-color', 'red');
            app.alert.show("Valor Invalido2", {
                level: "error",
                title: "El campo Monto total aproximado no debe tener un valor menor a 0.",
                autoClose: true
            });
            errors['campo22int-ff'] = "El campo Monto total aproximado no debe tener un valor menor a 0.";
            errors['campo22int-ff'].required = true;
        }

        callback(null, fields, errors);
    },

    requeridosleasingnv: function (fields, errors, callback) {
        var faltantesleasnv = 0;
        if ($('.campo1chk')[0].checked && ($('.campo4nvl').select2('val') == "" || $('.campo4nvl').select2('val') == "0")) {
            $('.campo4nvl').find('.select2-choice').css('border-color', 'red');
            faltantesleasnv += 1;
        }
        if ($('.campo1chk')[0].checked == true && $('.campo4nvl').select2('val') == "1" && ($('.campo7nvl').select2('val') == "" || $('.campo7nvl').select2('val') == "0")) {
            $('.campo7nvl').find('.select2-choice').css('border-color', 'red');
            faltantesleasnv += 1;
        }
        if ($('.campo1chk')[0].checked == true && $('.campo4nvl').select2('val') == "2" && ($('.campo19nvl').select2('val') == "" || $('.campo19nvl').select2('val') == "0")) {
            $('.campo19nvl').find('.select2-choice').css('border-color', 'red');
            faltantesleasnv += 1;
        }
        if ($('.campo1chk')[0].checked == true && $('.campo4nvl').select2('val') == "7" && ($('.campo25nvl').select2('val') == "" || $('.campo25nvl').select2('val') == "0")) {
            $('.campo25nvl').find('.select2-choice').css('border-color', 'red');
            faltantesleasnv += 1;
        }
        if ($('.campo1chk')[0].checked == true && $('.campo4nvl').select2('val') == "3" && $('.campo10nvl').val().trim() == "" && $('.campo13nvl').val().trim() == "") {
            $('.campo10nvl').css('border-color', 'red');
            $('.campo13nvl').css('border-color', 'red');
            faltantesleasnv += 1;
        }
        if ($('.campo1chk')[0].checked == true && $('.campo4nvl').select2('val') == "3" && $('.campo10nvl').val().trim() == "" && $('.campo13nvl').val().trim() != "") {
            $('.campo10nvl').css('border-color', 'red');
            faltantesleasnv += 1;
        }
        if ($('.campo1chk')[0].checked == true && $('.campo4nvl').select2('val') == "3" && $('.campo10nvl').val().trim() != "" && $('.campo13nvl').val().trim() == "") {
            $('.campo13nvl').css('border-color', 'red');
            faltantesleasnv += 1;
        }
        if ($('.campo1chk')[0].checked == true && $('.campo4nvl').select2('val') == "4" && ($('.campo16nvl').select2('val') == "" || $('.campo16nvl').select2('val') == "0")) {
            $('.campo16nvl').find('.select2-choice').css('border-color', 'red');
            faltantesleasnv += 1;
        }
        if (($('.campo4nvl').select2('val') == "4" || $('.campo4nvl option:selected').text() == "4" || $('.campo4nvl')[0].innerText.trim() == "4") && ($('.campo16nvl').select2('val') == "4" || $('.campo16nvl option:selected').text() == "4" || $('.campo16nvl')[0].innerText.trim() == "4") && $('.campo1chk')[0].checked && $('.campo22nvl').val().trim() == "") {
            $('.campo22nvl').css('border-color', 'red');
            faltantesleasnv += 1;
        }
        if (faltantesleasnv > 0) {
            app.alert.show("Faltantes no viable Leasing", {
                level: "error",
                title: 'Hace falta seleccionar alguna de las razones del cat\u00E1logo <b>Raz\u00F3n lead no viable en Leasing.',
                autoClose: false
            });
            errors['error_leasing'] = errors['error_leasing'] || {};
            errors['error_leasing'].required = true;
        }
        if (faltantesleasnv == 0 && $('.campo1chk')[0].checked == true && lnv.leadNoViable.PromotorLeasing == "") {
            this.model.set('promotorleasing_c', '9 - No Viable');
            this.model.set('user_id_c', 'cc736f7a-4f5f-11e9-856a-a0481cdf89eb');
            lnv.leadNoViable.PromotorLeasing = App.user.attributes.id;
        }
        callback(null, fields, errors);

    },
    requeridosfacnv: function (fields, errors, callback) {
        var faltantesfactnv = 0;
        if ($('.campo2chk')[0].checked == true && ($('.campo5nvf').select2('val') == "" || $('.campo5nvf').select2('val') == "0")) {
            $('.campo5nvf').find('.select2-choice').css('border-color', 'red');
            faltantesfactnv += 1;
        }
        if ($('.campo2chk')[0].checked == true && $('.campo5nvf').select2('val') == "1" && ($('.campo8nvf').select2('val') == "" || $('.campo8nvf').select2('val') == "0")) {
            $('.campo8nvf').find('.select2-choice').css('border-color', 'red');
            faltantesfactnv += 1;
        }
        if ($('.campo2chk')[0].checked == true && $('.campo5nvf').select2('val') == "2" && ($('.campo20nvf').select2('val') == "" || $('.campo20nvf').select2('val') == "0")) {
            $('.campo20nvf').find('.select2-choice').css('border-color', 'red');
            faltantesfactnv += 1;
        }
        if ($('.campo2chk')[0].checked == true && $('.campo5nvf').select2('val') == "7" && ($('.campo26nvf').select2('val') == "" || $('.campo26nvf').select2('val') == "0")) {
            $('.campo26nvf').find('.select2-choice').css('border-color', 'red');
            faltantesfactnv += 1;
        }
        if ($('.campo2chk')[0].checked == true && $('.campo5nvf').select2('val') == "3" && $('.campo11nvf').val().trim() == "" && $('.campo14nvf').val().trim() == "") {
            $('.campo11nvf').css('border-color', 'red');
            $('.campo14nvf').css('border-color', 'red');
            faltantesfactnv += 1;
        }
        if ($('.campo2chk')[0].checked == true && $('.campo5nvf').select2('val') == "3" && $('.campo11nvf').val().trim() == "" && $('.campo14nvf').val().trim() != "") {
            $('.campo11nvf').css('border-color', 'red');
            faltantesfactnv += 1;
        }
        if ($('.campo2chk')[0].checked == true && $('.campo5nvf').select2('val') == "3" && $('.campo11nvf').val().trim() != "" && $('.campo14nvf').val().trim() == "") {
            $('.campo14nvf').css('border-color', 'red');
            faltantesfactnv += 1;
        }
        if ($('.campo2chk')[0].checked == true && $('.campo5nvf').select2('val') == "4" && ($('.campo17nvf').select2('val') == "" || $('.campo17nvf').select2('val') == "0")) {
            $('.campo17nvf').find('.select2-choice').css('border-color', 'red');
            faltantesfactnv += 1;
        }
        if (($('.campo5nvf').select2('val') == "4" || $('.campo5nvf option:selected').text() == "4" || $('.campo5nvf')[0].innerText.trim() == "4") && ($('.campo17nvf').select2('val') == "4" || $('.campo17nvf option:selected').text() == "4" || $('.campo17nvf')[0].innerText.trim() == "4") && $('.campo2chk')[0].checked && $('.campo23nvf').val().trim() == "") {
            $('.campo23nvf').css('border-color', 'red');
            faltantesfactnv += 1;
        }
        if (faltantesfactnv > 0) {
            app.alert.show("Faltantes no viable Factoraje", {
                level: "error",
                title: 'Hace falta seleccionar alguna de las razones del cat\u00E1logo <b>Raz\u00F3n lead no viable en Factoraje.',
                autoClose: false
            });
            errors['error_factoraje'] = errors['error_factoraje'] || {};
            errors['error_factoraje'].required = true;
        } else if (faltantesfactnv == 0 && $('.campo2chk')[0].checked == true && lnv.leadNoViable.PromotorFactoraje == "") {
            this.model.set('promotorfactoraje_c', '9 - No Viable');
            this.model.set('user_id1_c', 'cc736f7a-4f5f-11e9-856a-a0481cdf89eb');
            lnv.leadNoViable.PromotorFactoraje = App.user.attributes.id;
        }
        callback(null, fields, errors);
    },

    requeridoscanv: function (fields, errors, callback) {
        var faltantescanv = 0;
        if ($('.campo3chk')[0].checked == true && ($('.campo6nvca').select2('val') == "" || $('.campo6nvca').select2('val') == "0")) {
            $('.campo6nvca').find('.select2-choice').css('border-color', 'red');
            faltantescanv += 1;
        }
        if ($('.campo3chk')[0].checked == true && $('.campo6nvca').select2('val') == "1" && ($('.campo9nvca').select2('val') == "" || $('.campo9nvca').select2('val') == "0")) {
            $('.campo9nvca').find('.select2-choice').css('border-color', 'red');
            faltantescanv += 1;
        }
        if ($('.campo3chk')[0].checked == true && $('.campo6nvca').select2('val') == "2" && ($('.campo21nvca').select2('val') == "" || $('.campo21nvca').select2('val') == "0")) {
            $('.campo21nvca').find('.select2-choice').css('border-color', 'red');
            faltantescanv += 1;
        }
        if ($('.campo3chk')[0].checked == true && $('.campo6nvca').select2('val') == "7" && ($('.campo27nvca').select2('val') == "" || $('.campo27nvca').select2('val') == "0")) {
            $('.campo27nvca').find('.select2-choice').css('border-color', 'red');
            faltantescanv += 1;
        }
        if ($('.campo3chk')[0].checked == true && $('.campo6nvca').select2('val') == "3" && $('.campo12nvca').val().trim() == "" && $('.campo15nvca').val().trim() == "") {
            $('.campo12nvca').css('border-color', 'red');
            $('.campo15nvca').css('border-color', 'red');
            faltantescanv += 1;
        }
        if ($('.campo3chk')[0].checked == true && $('.campo6nvca').select2('val') == "3" && $('.campo12nvca').val().trim() == "" && $('.campo15nvca').val().trim() != "") {
            $('.campo12nvca').css('border-color', 'red');
            faltantescanv += 1;
        }
        if ($('.campo3chk')[0].checked == true && $('.campo6nvca').select2('val') == "3" && $('.campo12nvca').val().trim() != "" && $('.campo15nvca').val().trim() == "") {
            $('.campo15nvca').css('border-color', 'red');
            faltantescanv += 1;
        }
        if ($('.campo3chk')[0].checked == true && $('.campo6nvca').select2('val') == "4" && ($('.campo18nvca').select2('val') == "" || $('.campo18nvca').select2('val') == "0")) {
            $('.campo18nvca').find('.select2-choice').css('border-color', 'red');
            faltantescanv += 1;
        }
        if (($('.campo6nvca').select2('val') == "4" || $('.campo6nvca option:selected').text() == "4" || $('.campo6nvca')[0].innerText.trim() == "4") && ($('.campo18nvca').select2('val') == "4" || $('.campo18nvca option:selected').text() == "4" || $('.campo18nvca')[0].innerText.trim() == "4") && $('.campo3chk')[0].checked && $('.campo24nvca').val().trim() == "") {
            $('.campo24nvca').css('border-color', 'red');
            faltantescanv += 1;
        }
        if (faltantescanv > 0) {
            app.alert.show("Faltantes no viable Crédito Automotriz", {
                level: "error",
                title: 'Hace falta seleccionar alguna de las razones del cat\u00E1logo <b>Raz\u00F3n lead no viable en Credito Automotriz.',
                autoClose: false
            });
            errors['error_ca'] = errors['error_ca'] || {};
            errors['error_ca'].required = true;
        } else if (faltantescanv == 0 && $('.campo3chk')[0].checked == true && lnv.leadNoViable.PromotorCreditA == "") {
            this.model.set('promotorcredit_c', '9 - No Viable');
            this.model.set('user_id2_c', 'cc736f7a-4f5f-11e9-856a-a0481cdf89eb');
            lnv.leadNoViable.PromotorCreditA = App.user.attributes.id;
        }
        callback(null, fields, errors);

    },
    //Pregunta si la cuenta es LEAD para poder mostrar los checks de leads no viables:
    muestracheks: function () {
        if (Oproductos.productos != undefined) {
            if (Oproductos.productos.tct_tipo_ca_txf_c != 'Lead' && Oproductos.productos.tct_tipo_f_txf_c != 'Lead' && Oproductos.productos.tct_tipo_l_txf_c != 'Lead') {
                $('[data-name=tct_noviable]').hide();
            }
        }
    },

    ocultaRFC: function () {
        // if (this.model.get('tipo_relacion_c').includes('Proveedor de Recursos')) {
        //     $('[data-name=tct_pais_expide_rfc_c]').show();
        // }
        if (this.model.get('tct_pais_expide_rfc_c') != "2") {
            this.$('[data-name="generar_rfc_c"]').attr('style', 'pointer-events:none;');
        } else {
            this.$('[data-name="generar_rfc_c"]').attr('style', 'pointer-events:block;');
        }

    },
    proveedorRecursos: function (fields, errors, callback) {
        if ($('.campo4ddw-ap').select2('val') == "2" || $('.campo4ddw-ca').select2('val') == "2" || $('.campo4ddw-ff').select2('val') == "2" || $('.campo4ddw-cs').select2('val') == "2") {

            var apicall = app.api.buildURL('Rel_Relaciones?filter[0][rel_relaciones_accounts_1accounts_ida][$equals]=' + this.model.get("id"), null);
            app.api.call('GET', apicall, {}, {
                success: _.bind(function (data) {

                    var relacionl = 0;
                    var relacionca = 0;
                    var relacionff = 0;
                    var relacioncs = 0;
                    var productos = "";
                    if (data.records.length > 0) {
                        for (var l = 0; l < data.records.length; l++) {
                            //Producto Arrendamiento Puro
                            if (App.user.attributes.productos_c.includes(1) && $('.campo4ddw-ap').select2('val') == "2") {

                                if (data.records[l].relaciones_activas.includes('Proveedor de Recursos L')) {
                                    relacionl++;

                                }
                            }
                            //Producto Credito Automotriz
                            if (App.user.attributes.productos_c.includes(3) && $('.campo4ddw-ca').select2('val') == "2") {

                                if (data.records[l].relaciones_activas.includes('Proveedor de Recursos CA')) {
                                    relacionca++;
                                }
                            }
                            //Producto Factoraje Financiero
                            if (App.user.attributes.productos_c.includes(4) && $('.campo4ddw-ff').select2('val') == "2") {

                                if (data.records[l].relaciones_activas.includes('Proveedor de Recursos F')) {
                                    relacionff++;
                                }
                            }
                            //Producto Credito Simple
                            if ($('.campo4ddw-cs').select2('val') == "2") {

                                if (data.records[l].relaciones_activas.includes('Proveedor de Recursos CS')) {
                                    relacioncs++;
                                }
                            }
                        }
                    }

                    //Validacion Arrendamiento Puro
                    if (relacionl == 0 && $('.campo4ddw-ap').select2('val') == "2") {
                        $('.campo4ddw-ap').find('.select2-choice').css('border-color', 'red');
                        productos = productos + '<b>Arrendamiento Puro</b><br>';
                        errors['error_leasingPR'] = errors['error_leasingPR'] || {};
                        errors['error_leasingPR'].required = true;
                    } else {
                        $('.campo4ddw-ap').find('.select2-choice').css('border-color', '');
                    }
                    //Validacion Credito Automotriz
                    if (relacionca == 0 && $('.campo4ddw-ca').select2('val') == "2") {
                        $('.campo4ddw-ca').find('.select2-choice').css('border-color', 'red');
                        productos = productos + '<b>Crédito Automotriz</b><br>';
                        errors['error_CAPR'] = errors['error_CAPR'] || {};
                        errors['error_CAPR'].required = true;
                    } else {
                        $('.campo4ddw-ca').find('.select2-choice').css('border-color', '');
                    }
                    //Validacion Factoraje Financiero
                    if (relacionff == 0 && $('.campo4ddw-ff').select2('val') == "2") {
                        $('.campo4ddw-ff').find('.select2-choice').css('border-color', 'red');
                        productos = productos + '<b>Factoraje Financiero</b><br>';
                        errors['error_FPR'] = errors['error_FPR'] || {};
                        errors['error_FPR'].required = true;
                    } else {
                        $('.campo4ddw-ff').find('.select2-choice').css('border-color', '');
                    }

                    //Validacion Credito Simple
                    if (relacioncs == 0 && $('.campo4ddw-cs').select2('val') == "2") {
                        $('.campo4ddw-cs').find('.select2-choice').css('border-color', 'red');
                        productos = productos + '<b>Crédito Simple</b><br>';
                        errors['error_FPR'] = errors['error_FPR'] || {};
                        errors['error_FPR'].required = true;
                    } else {
                        $('.campo4ddw-cs').find('.select2-choice').css('border-color', '');
                    }
                    if (productos != "") {
                        app.alert.show("Faltante Relacion Proveedor de Recursos", {
                            level: "error",
                            messages: 'Hace falta completar la siguiente información en la <b>Cuenta:</b><br> (Se debe agregar una relación de tipo <b>Proveedor de Recursos</b> para el/los producto(s):<br>' + productos,
                            autoClose: false
                        });
                    }
                    callback(null, fields, errors);
                }, this)
            });
        } else {
            callback(null, fields, errors);
        }

    },

    direccionesparticularPR: function (fields, errors, callback) {
        //Valida direcciones en relaciones
        if ($('.campo4ddw-ap').select2('val') == "2" || $('.campo4ddw-ff').select2('val') == "2" || $('.campo4ddw-ca').select2('val') == "2" || $('.campo4ddw-cs').select2('val') == "2" && this.model.get('tipodepersona_c') != 'Persona Moral') {
            var apicalldir = app.api.buildURL('DireCuenta/' + this.model.get("id"), null);
            app.api.call('GET', apicalldir, {}, {
                success: _.bind(function (data) {
                    if (data != "") {
                        app.alert.show("Falta direccion Particular en cuenta", {
                            level: "error",
                            messages: 'Hace falta agregar una dirección para la(s) siguientes <b>Cuentas</b><br> (En una relación de tipo <b>Proveedor de Recursos</b>):<br>' + data + '<br><br><b>Nota:</b> Se require dirección <b>Particular</b> para persona Física y FCAE. En caso de persona moral al menos un tipo de dirección.',
                            autoClose: false
                        });
                        errors['errordireccionPR'] = errors['errordireccionPR'] || {};
                        errors['errordireccionPR'].required = true;
                    }
                    callback(null, fields, errors);
                }, this)
            });
        } else {
            callback(null, fields, errors);
        }

    },

    quitaanos: function () {
        var anoactual = ((new Date).getFullYear());
        var anoactual5 = anoactual - 5
        var anoselect = this.model.get('tct_ano_ventas_ddw_c');
        var lista = App.lang.getAppListStrings('ano_ventas_ddw_list');
        Object.keys(lista).forEach(function (key) {
            //Quita años previos
            if (key < anoactual5) {
                delete lista[key];
            }
            //Quita años futuros al actual
            if (key > anoactual) {
                delete lista[key];
            }
        });
        lista[anoselect] = anoselect;
        this.model.fields['tct_ano_ventas_ddw_c'].options = lista;
    },

    blockRecordNoContactar: function () {

        if (this.model.get('tct_no_contactar_chk_c') == true) {

            //Bloquear el registro completo y mostrar alerta
            $('.record.tab-layout').attr('style', 'pointer-events:none');

            app.alert.show("cuentas_no_contactar", {
                level: "error",
                title: "Cuenta No Contactable<br>",
                messages: "Cualquier duda o aclaraci\u00F3n, favor de contactar al \u00E1rea de <b>Administraci\u00F3n de cartera</b>",
                autoClose: false
            });

        }

    },
    get_phones: function () {
        //Extiende This
        this.oTelefonos = [];
        this.oTelefonos.telefono = [];
        this.prev_oTelefonos = [];
        this.prev_oTelefonos.prev_telefono = [];
        //contexto_cuenta = this;
        this.model.set('account_telefonos', this.oTelefonos.telefono);
        //Recupera información
        idCuenta = this.model.get('id');
        app.api.call('GET', app.api.buildURL('Accounts/' + idCuenta + '/link/accounts_tel_telefonos_1'), null, {
            success: function (data) {
                for (var i = 0; i < data.records.length; i++) {
                    //Asignando valores de los campos
                    var valor1 = data.records[i].tipotelefono;
                    var valor2 = data.records[i].pais;
                    var valor3 = data.records[i].estatus;
                    var valor4 = data.records[i].telefono;
                    var valor5 = data.records[i].extension;
                    var valor6 = (data.records[i].principal == true) ? 1 : 0;
                    var idtel = data.records[i].id;

                    var telefono = {
                        "name": valor4,
                        "tipotelefono": valor1,
                        "pais": valor2,
                        "estatus": valor3,
                        "extension": valor5,
                        "telefono": valor4,
                        "principal": valor6,
                        "id_cuenta": idCuenta,
                        "id": idtel
                    };

                    var prev_telefono = {
                        "name": valor4,
                        "tipotelefono": valor1,
                        "pais": valor2,
                        "estatus": valor3,
                        "extension": valor5,
                        "telefono": valor4,
                        "principal": valor6,
                        "id_cuenta": idCuenta,
                        "id": idtel
                    };
                    contexto_cuenta.oTelefonos.telefono.push(telefono);
                    contexto_cuenta.prev_oTelefonos.prev_telefono.push(prev_telefono);
                }

                cont_tel.oTelefonos = contexto_cuenta.oTelefonos;
                cont_tel.render();
                //Oculta campo Accounts_telefonosV2
                $("div.record-label[data-name='account_telefonos']").attr('style', 'display:none;');
            },
            error: function (e) {
                throw e;
            }
        });
    },

    get_addresses: function () {
        //Extiende This
        this.oDirecciones = [];
        this.oDirecciones.direccion = [];
        this.prev_oDirecciones = [];
        this.prev_oDirecciones.prev_direccion = [];

        //Define variables
        var listMapTipo = App.lang.getAppListStrings('tipo_dir_map_list');
        var listTipo = App.lang.getAppListStrings('dir_tipo_unique_list');
        var listMapIndicador = App.lang.getAppListStrings('dir_indicador_map_list');
        var listIndicador = App.lang.getAppListStrings('dir_indicador_unique_list');
        var idCuenta = this.model.get('id');

        //Recupera información
        if (!_.isEmpty(idCuenta) && idCuenta != "") {
            app.api.call('GET', app.api.buildURL('Accounts/' + idCuenta + '/link/accounts_dire_direccion_1'), null, {
                success: function (data) {
                    //Itera y agrega direcciones
                    for (var i = 0; i < data.records.length; i++) {
                        //Asignando valores de los campos
                        var tipo = data.records[i].tipodedireccion.toString();
                        var tipoSeleccionados = '^' + listMapIndicador[tipo].replace(/,/gi, "^,^") + '^';
                        var indicador = data.records[i].indicador;
                        var indicadorSeleccionados = '^' + listMapIndicador[indicador].replace(/,/gi, "^,^") + '^';
                        var valCodigoPostal = data.records[i].dire_direccion_dire_codigopostal_name;
                        var idCodigoPostal = data.records[i].dire_direccion_dire_codigopostaldire_codigopostal_ida;
                        var valPais = data.records[i].dire_direccion_dire_pais_name;
                        var idPais = data.records[i].dire_direccion_dire_paisdire_pais_ida;
                        var valEstado = data.records[i].dire_direccion_dire_estado_name;
                        var idEstado = data.records[i].dire_direccion_dire_estadodire_estado_ida;
                        var valMunicipio = data.records[i].dire_direccion_dire_municipio_name;
                        var idMunicipio = data.records[i].dire_direccion_dire_municipiodire_municipio_ida;
                        var valCiudad = data.records[i].dire_direccion_dire_ciudad_name;
                        var idCiudad = data.records[i].dire_direccion_dire_ciudaddire_ciudad_ida;
                        var valColonia = data.records[i].dire_direccion_dire_colonia_name;
                        var idColonia = data.records[i].dire_direccion_dire_coloniadire_colonia_ida;
                        var calle = data.records[i].calle;
                        var numExt = data.records[i].numext;
                        var numInt = data.records[i].numint;
                        var principal = (data.records[i].principal == true) ? 1 : 0;
                        var inactivo = (data.records[i].inactivo == true) ? 1 : 0;
                        var secuencia = data.records[i].secuencia;
                        var idDireccion = data.records[i].id;
                        var direccionCompleta = data.records[i].name;

                        //Parsea a objeto direccion
                        var direccion = {
                            "tipodedireccion": tipo,
                            "listTipo": listTipo,
                            "tipoSeleccionados": tipoSeleccionados,
                            "indicador": indicador,
                            "listIndicador": listIndicador,
                            "indicadorSeleccionados": indicadorSeleccionados,
                            "valCodigoPostal": valCodigoPostal,
                            "postal": idCodigoPostal,
                            "valPais": valPais,
                            "pais": idPais,
                            "listPais": {},
                            "listPaisFull": {},
                            "valEstado": valEstado,
                            "estado": idEstado,
                            "listEstado": {},
                            "listEstadoFull": {},
                            "valMunicipio": valMunicipio,
                            "municipio": idMunicipio,
                            "listMunicipio": {},
                            "listMunicipioFull": {},
                            "valCiudad": valCiudad,
                            "ciudad": idCiudad,
                            "listCiudad": {},
                            "listCiudadFull": {},
                            "valColonia": valColonia,
                            "colonia": idColonia,
                            "listColonia": {},
                            "listColoniaFull": {},
                            "calle": calle,
                            "numext": numExt,
                            "numint": numInt,
                            "principal": principal,
                            "inactivo": inactivo,
                            "secuencia": secuencia,
                            "id": idDireccion,
                            "direccionCompleta": direccionCompleta
                        };

                        //Agregar dirección
                        contexto_cuenta.oDirecciones.direccion.push(direccion);

                        //recupera información asociada a CP
                        var strUrl = 'DireccionesCP/' + valCodigoPostal + '/' + i;
                        app.api.call('GET', app.api.buildURL(strUrl), null, {
                            success: _.bind(function (data) {
                                //recupera info
                                var list_paises = data.paises;
                                var list_municipios = data.municipios;
                                var city_list = App.metadata.getCities();
                                var list_estados = data.estados;
                                var list_colonias = data.colonias;
                                //Poarsea valores para listas
                                //País
                                listPais = {};
                                for (var i = 0; i < list_paises.length; i++) {
                                    listPais[list_paises[i].idPais] = list_paises[i].namePais;
                                }
                                contexto_cuenta.oDirecciones.direccion[data.indice].listPais = listPais;
                                contexto_cuenta.oDirecciones.direccion[data.indice].listPaisFull = listPais;
                                //Municipio
                                listMunicipio = {};
                                for (var i = 0; i < list_municipios.length; i++) {
                                    listMunicipio[list_municipios[i].idMunicipio] = list_municipios[i].nameMunicipio;
                                }
                                contexto_cuenta.oDirecciones.direccion[data.indice].listMunicipio = listMunicipio;
                                contexto_cuenta.oDirecciones.direccion[data.indice].listMunicipioFull = listMunicipio;
                                //Estado
                                listEstado = {};
                                for (var i = 0; i < list_estados.length; i++) {
                                    listEstado[list_estados[i].idEstado] = list_estados[i].nameEstado;
                                }
                                contexto_cuenta.oDirecciones.direccion[data.indice].listEstado = listEstado;
                                contexto_cuenta.oDirecciones.direccion[data.indice].listEstadoFull = listEstado;
                                //Colonia
                                listColonia = {};
                                for (var i = 0; i < list_colonias.length; i++) {
                                    listColonia[list_colonias[i].idColonia] = list_colonias[i].nameColonia;
                                }
                                contexto_cuenta.oDirecciones.direccion[data.indice].listColonia = listColonia;
                                contexto_cuenta.oDirecciones.direccion[data.indice].listColoniaFull = listColonia;
                                //Ciudad
                                listCiudad = {}
                                ciudades = Object.values(city_list);
                                for (var [key, value] of Object.entries(contexto_cuenta.oDirecciones.direccion[data.indice].listEstado)) {
                                    for (var i = 0; i < ciudades.length; i++) {
                                        if (ciudades[i].estado_id == key) {
                                            listCiudad[ciudades[i].id] = ciudades[i].name;
                                        }
                                    }
                                }
                                contexto_cuenta.oDirecciones.direccion[data.indice].listCiudad = listCiudad;
                                contexto_cuenta.oDirecciones.direccion[data.indice].listCiudadFull = listCiudad;

                                //Genera objeto con valores previos para control de cancelar
                                contexto_cuenta.prev_oDirecciones.prev_direccion = app.utils.deepCopy(contexto_cuenta.oDirecciones.direccion);
                                cont_dir.oDirecciones = contexto_cuenta.oDirecciones;

                                //Aplica render a campo custom
                                cont_dir.render();

                            }, contexto_cuenta)
                        });
                    }
                },
                error: function (e) {
                    throw e;
                }
            });
        }
    },

    get_v360: function () {
        //Extiende This
        this.ResumenCliente = [];
        //contexto_cuenta = this;

        //Recupera id de cliente
        var id = this.model.id;

        //Forma Petición de datos
        if (id != '' && id != undefined && id != null) {
            //Ejecuta petición ResumenCliente
            var url = app.api.buildURL('ResumenCliente/' + id, null, null);
            app.api.call('GET', url, {}, {
                success: _.bind(function (data) {
                    v360.ResumenCliente = data;
                    //Oproductos=data;
                    //_.extend(this, v360.ResumenCliente);
                    v360.render();
                }, contexto_cuenta)
            });
        }
    },

    get_Oproductos: function () {
        //Extiende This
        this.productos = [];
        //contexto_cuenta = this;

        //Recupera id de cliente
        var id = this.model.id;

        //Forma Petición de datos
        if (id != '' && id != undefined && id != null) {
            //Ejecuta petición ResumenCliente
            var url = app.api.buildURL('tct02_Resumen/' + id, null, null);
            app.api.call('read', url, {}, {
                success: _.bind(function (data) {
                    Oproductos.productos = data;
                    //contexto_cuenta.hideButton_Conversion();
                    //_.extend(this, v360.ResumenCliente);
                    Oproductos.render();
                }, contexto_cuenta)
            });
        }
    },

    get_resumen: function () {
        //Extiende This
        this.autos = [];
        this.prev_autos = [];
        //Recupera id de cliente
        var id = this.model.id;
        //Forma Petición de datos
        if (id != '' && id != undefined && id != null) {
            //Ejecuta petición ResumenCliente
            var campos = ["tct_no_autos_u_int_c", "tct_no_autos_e_int_c", "tct_no_motos_int_c", "tct_no_camiones_int_c"];
            var url = app.api.buildURL('tct02_Resumen/' + id, null, null, {fields: campos.join(',')});
            app.api.call('read', url, {}, {
                success: _.bind(function (data) {
                    Pautos.autos = data;
                    Pautos.prev_autos = app.utils.deepCopy(Pautos.autos);
                    //contexto_cuenta.hideButton_Conversion();
                    //_.extend(this, v360.ResumenCliente);
                    Pautos.render();
                }, contexto_cuenta)
            });
        }
    },


    get_pld: function () {
        //Extiende This
        this.ProductosPLD = [];
        this.prev_ProductosPLD = [];
        //Recupera id Cuenta
        var idCuenta = this.model.get('id');
        //Recupera información de PLD
        if (idCuenta) {
            app.api.call('GET', app.api.buildURL('GetProductosPLD/' + idCuenta), null, {
                success: _.bind(function (data) {
                    //Recupera resultado
                    contexto_cuenta.ProductosPLD = pld.formatDetailPLD(data);
                    //Establece visibilidad por tipo de productos
                    //AP
                    if (App.user.attributes.tipodeproducto_c == '1') {
                        contexto_cuenta.ProductosPLD.arrendamientoPuro.visible = 'block';
                    }
                    //FF
                    if (App.user.attributes.tipodeproducto_c == '4') {
                        contexto_cuenta.ProductosPLD.factorajeFinanciero.visible = 'block';
                    }
                    //CA
                    if (App.user.attributes.tipodeproducto_c == '3') {
                        contexto_cuenta.ProductosPLD.creditoAutomotriz.visible = 'block';
                    }
                    //Genera objeto con valores previos para control de cancelar
                    contexto_cuenta.prev_ProductosPLD = app.utils.deepCopy(contexto_cuenta.ProductosPLD);
                    pld.ProductosPLD = contexto_cuenta.ProductosPLD;

                    //Aplica render a campo custom
                    pld.render();

                }, contexto_cuenta),
                error: function (e) {
                    throw e;
                }
            });
        }
    },

    setCustomFields: function (fields, errors, callback) {
        if ($.isEmptyObject(errors)) {
            //Teléfonos
            this.prev_oTelefonos.prev_telefono = app.utils.deepCopy(this.oTelefonos.telefono);
            this.model.set('account_telefonos', this.oTelefonos.telefono);

            //Direcciones
            this.prev_oDirecciones.prev_direccion = app.utils.deepCopy(this.oDirecciones.direccion);
            this.model.set('account_direcciones', this.oDirecciones.direccion);
        }
        //Callback a validation task
        callback(null, fields, errors);
    },

    //Sobre escribe función para recuperar info de registros relacionados
    _saveModel: function () {
        var options,
            successCallback = _.bind(function () {
                // Loop through the visible subpanels and have them sync. This is to update any related
                // fields to the record that may have been changed on the server on save.
                _.each(this.context.children, function (child) {
                    if (child.get('isSubpanel') && !child.get('hidden')) {
                        if (child.get('collapsed')) {
                            child.resetLoadFlag({recursive: false});
                        } else {
                            child.reloadData({recursive: false});
                        }
                    }
                });
                if (this.createMode) {
                    app.navigate(this.context, this.model);
                } else if (!this.disposed && !app.acl.hasAccessToModel('edit', this.model)) {
                    //re-render the view if the user does not have edit access after save.
                    this.render();
                }
                //Refresca cambios en teléfonos, direcciones y pld(Recupera ids de nuevos teléfonos)
                this.get_phones();
                this.get_addresses();
                this.get_pld();

            }, this);

        //Call editable to turn off key and mouse events before fields are disposed (SP-1873)
        this.turnOffEvents(this.fields);

        options = {
            showAlerts: true,
            success: successCallback,
            error: _.bind(function (model, error) {
                if (error.status === 412 && !error.request.metadataRetry) {
                    this.handleMetadataSyncError(error);
                } else if (error.status === 409) {
                    app.utils.resolve409Conflict(error, this.model, _.bind(function (model, isDatabaseData) {
                        if (model) {
                            if (isDatabaseData) {
                                successCallback();
                            } else {
                                this._saveModel();
                            }
                        }
                    }, this));
                } else if (error.status === 403 || error.status === 404) {
                    this.alerts.showNoAccessError.call(this);
                } else {
                    this.editClicked();
                }
            }, this),
            lastModified: this.model.get('date_modified'),
            viewed: true
        };

        // ensure view and field are sent as params so collection-type fields come back in the response to PUT requests
        // (they're not sent unless specifically requested)
        options.params = options.params || {};
        if (this.context.has('dataView') && _.isString(this.context.get('dataView'))) {
            options.params.view = this.context.get('dataView');
        }

        if (this.context.has('fields')) {
            options.params.fields = this.context.get('fields').join(',');
        }

        options = _.extend({}, options, this.getCustomSaveOptions(options));

        this.model.save({}, options);
    },

    validaformato: function (fields, errors, callback) {
        //Validacion para pasar una expresion regular por los 3 campos y verificar dicho formato.
        var errorescampos = "";
        if (this.model.get('primernombre_c') != "" || this.model.get('apellidopaterno_c') != "" || this.model.get('apellidomaterno_c') != "") {
            var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
            if (this.model.get('primernombre_c') != "" && this.model.get('primernombre_c') != undefined) {
                var nombre = this.model.get('primernombre_c');
                var res = expresion.test(nombre);
                if (res != true) {
                    errorescampos = errorescampos + '<b>-Primer Nombre<br></b>';
                    ;
                    errors['primernombre_c'] = errors['primernombre_c'] || {};
                    errors['primernombre_c'].required = true;
                }
            }
            if (this.model.get('apellidopaterno_c') != "" && this.model.get('apellidopaterno_c') != undefined) {
                var apaterno = this.model.get('apellidopaterno_c');
                var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
                var res = expresion.test(apaterno);
                if (res != true) {
                    errorescampos = errorescampos + '<b>-Apellido Paterno<br></b>';
                    ;
                    errors['apellidopaterno_c'] = errors['apellidopaterno_c'] || {};
                    errors['apellidopaterno_c'].required = true;
                }
            }
            if (this.model.get('apellidomaterno_c') != "" && this.model.get('apellidomaterno_c') != undefined) {
                var amaterno = this.model.get('apellidomaterno_c');
                var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
                var res = expresion.test(amaterno);
                if (res != true) {
                    errorescampos = errorescampos + '<b>-Apellido Materno<br></b>';
                    ;
                    errors['apellidomaterno_c'] = errors['apellidomaterno_c'] || {};
                    errors['apellidomaterno_c'].required = true;
                }
            }
            if (errorescampos) {
                app.alert.show("Error_validacion_Campos", {
                    level: "error",
                    messages: 'Los siguientes campos no permiten caracteres especiales:<br>' + errorescampos,
                    autoClose: false
                });
            }
        }
        callback(null, fields, errors);
    },
    validapasscurp: function (fields, errors, callback) {
        if (this.model.get('ifepasaporte_c') != "" || this.model.get('curp_c') != "") {
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
    validaiva: function (fields, errors, callback) {
        if (this.model.get('tipo_registro_c') == "Proveedor" || this.model.get('esproveedor_c') == true) {
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

    homonimo: function () {
        var listahom = App.lang.getAppListStrings('usuarios_permiso_homonimos_list');
        var usr1 = listahom[1];
        var usr2 = listahom[2]
        var userlogueado = App.user.attributes.id;
        if (usr1 == userlogueado || usr2 == userlogueado) {
            $('div[data-name=tct_homonimo_chk_c]').show();
        } else {
            $('div[data-name=tct_homonimo_chk_c]').hide();
        }
    },
    //Valida campos de Autos en Potencial
    nodigitos: function (fields, errors, callback) {
        if ($('.campo1pa').val() != "" || $('.campo2pa').val() != "" || $('.campo3pa').val() != "" || $('.campo4pa').val() != "") {
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

    savepotauto: function (fields, errors, callback) {
        if (Pautos.action == "edit") {
            var PotencialAutos = {};
            PotencialAutos.autos = {};
            PotencialAutos.autos.tct_no_autos_u_int_c = this.$('.campo1pa').val();
            PotencialAutos.autos.tct_no_autos_e_int_c = this.$('.campo2pa').val();
            PotencialAutos.autos.tct_no_motos_int_c = this.$('.campo3pa').val();
            PotencialAutos.autos.tct_no_camiones_int_c = this.$('.campo4pa').val();

            if ($.isEmptyObject(errors)) {
                this.model.set('potencial_autos', JSON.stringify(PotencialAutos));
                Pautos.autos = PotencialAutos.autos;
                //Guarda una copia previa en prev_autos
                Pautos.prev_autos = app.utils.deepCopy(Pautos.autos);
                Pautos.render();
            }
        }
        callback(null, fields, errors);
    },
    clienteuniclickClicked: function () {
        App.alert.show('convierte_Cliente_uniclick', {
            level: 'process',
            title: 'Convirtiendo cuenta, por favor espere',
        });
        var necesarios = "";

        if (this.model.get('origendelprospecto_c') == "" || this.model.get('origendelprospecto_c') == null) {
            necesarios = necesarios + '<b>Origen<br></b>';
        }
        if (this.model.get('rfc_c') == "" || this.model.get('rfc_c') == null) {
            necesarios = necesarios + '<b>RFC<br></b>';
        }
        if (this.model.get('tct_macro_sector_ddw_c') == "" || this.model.get('tct_macro_sector_ddw_c') == null) {
            necesarios = necesarios + '<b>Macro Sector<br></b>';
        }
        if (this.model.get('sectoreconomico_c') == "" || this.model.get('sectoreconomico_c') == null) {
            necesarios = necesarios + '<b>Sector Económico<br></b>';
        }
        if (this.model.get('ventas_anuales_c') == "" || this.model.get('ventas_anuales_c') == null) {
            necesarios = necesarios + '<b>Ventas Anuales<br></b>';
        }
        if (this.model.get('activo_fijo_c') == "" || this.model.get('activo_fijo_c') == null) {
            necesarios = necesarios + '<b>Activo Fijo<br></b>';
        }
        if (_.isEmpty(this.model.get('email')) && _.isEmpty(this.oTelefonos.telefono)) {
            necesarios = necesarios + '<b>Al menos un correo electr\u00F3nico o un tel\u00E9fono<br></b>';
        }
        if (_.isEmpty(this.oDirecciones.direccion)) {
            necesarios = necesarios + '<b>Dirección<br></b>';
        }
        if (this.model.get('tipodepersona_c') != "Persona Moral") {
            if (this.model.get('primernombre_c') == "" || this.model.get('primernombre_c') == null) {
                necesarios = necesarios + '<b>Primer Nombre</b><br>';
            }
            if (this.model.get('apellidopaterno_c') == "" || this.model.get('apellidopaterno_c') == null) {
                necesarios = necesarios + '<b>Apellido Paterno</b><br>';
            }
            if (this.model.get('apellidomaterno_c') == "" || this.model.get('apellidomaterno_c') == null) {
                necesarios = necesarios + '<b>Apellido Materno</b><br>';
            }
            if (this.model.get('fechadenacimiento_c') == "" || this.model.get('fechadenacimiento_c') == null) {
                necesarios = necesarios + '<b>Fecha de Nacimiento<br></b>';
            }
            if (this.model.get('genero_c') == "" || this.model.get('genero_c') == null) {
                necesarios = necesarios + '<b>G\u00E9nero</b><br>';
            }
            if (this.model.get('pais_nacimiento_c') == "" || this.model.get('pais_nacimiento_c') == null) {
                necesarios = necesarios + '<b>Pa\u00EDs de Nacimiento</b><br>';
            }
            if (this.model.get('ifepasaporte_c') == "" || this.model.get('ifepasaporte_c') == null) {
                necesarios = necesarios + '<b>IFE/Pasaporte<br></b>';
            }
            if (this.model.get('curp_c') == "" || this.model.get('curp_c') == null) {
                necesarios = necesarios + '<b>Curp<br></b>';
            }
            if (this.model.get('estadocivil_c') == "" || this.model.get('estadocivil_c') == null) {
                necesarios = necesarios + '<b>Estado Civil<br></b>';
            }
            if (this.model.get('profesion_c') == "" || this.model.get('profesion_c') == null) {
                necesarios = necesarios + '<b>Profesión<br></b>';
            }
        } else {
            if (this.model.get('razonsocial_c') == "" || this.model.get('razonsocial_c') == null) {
                necesarios = necesarios + '<b>Razón Social<br></b>';
            }
            if (this.model.get('nombre_comercial_c') == "" || this.model.get('nombre_comercial_c') == null) {
                necesarios = necesarios + '<b>Nombre Comercial<br></b>';
            }
            if (this.model.get('fechaconstitutiva_c') == "" || this.model.get('fechaconstitutiva_c') == null) {
                necesarios = necesarios + '<b>Fecha Constitutiva<br></b>';
            }
            if (this.model.get('pais_nacimiento_c') == "" || this.model.get('pais_nacimiento_c') == null) {
                necesarios = necesarios + '<b>Pa\u00EDs de Constitución</b><br>';
            }
        }
        if (necesarios != "") {
            app.alert.dismiss('convierte_Cliente_uniclick');
            app.alert.show("Campos Faltantes", {
                level: "error",
                title: "Faltan los siguientes campos para poder convertir la cuenta a Cliente: <br><br>" + necesarios,
                autoClose: false
            });
            return;
        } else {
            if (Oproductos.productos.tct_tipo_uc_txf_c != "Cliente") {
                var productousuario = App.user.attributes.productos_c;
                var api_params = {};

                if (Oproductos.productos.tct_tipo_uc_txf_c != "Cliente" && productousuario.includes('8')) {
                    if (App.user.id == this.model.get('user_id7_c')) {
                        api_params["tct_tipo_uc_txf_c"] = "Cliente";
                        api_params["tct_subtipo_uc_txf_c"] = "Con Linea Vigente";
                        api_params["tct_tipo_cuenta_uc_c"] = "CLIENTE CON LÍNEA VIGENTE";
                    }
                }
            }
            if (api_params != undefined) {
                self = this;
                var idC = this.model.get('id');
                var url = app.api.buildURL('tct02_Resumen/' + idC, null, null);
                app.api.call('update', url, api_params, {
                    success: _.bind(function (data) {
                        //this._render();
                        app.alert.dismiss('convierte_Cliente_uniclick');
                        Oproductos.productos = data;
                        if (self.model.get('tipo_registro_c') != "Cliente") {
                            self.model.set("tipo_registro_c", "Cliente");
                            self.model.set("subtipo_cuenta_c", "Con Linea Vigente");
                            self.model.set("tct_tipo_subtipo_txf_c", "CLIENTE CON LÍNEA VIGENTE");
                            self.model.save();
                            v360.ResumenCliente.general_cliente.tipo = "CLIENTE CON LÍNEA VIGENTE";
                            v360.render();
                        }
                        app.alert.show('errorAlert', {
                            level: 'success',
                            messages: "Se ha realizado la conversión correctamente.",
                            autoClose: true
                        });
                        Oproductos.render();
                    }),
                })
            }
        }
    },

    get_analizate: function () {
        //Extiende This
        this.Financiera = [];
        //this.Credit = [];
        var id = this.model.id;
        //Forma Petición de datos
        if (id != '' && id != undefined && id != null) {
            //Ejecuta petición ResumenCliente

            var url = app.api.buildURL('ObtieneFinanciera/' + id, null, null,);
            app.api.call('read', url, {}, {
                success: _.bind(function (data) {
                    cont_nlzt.Financiera = data;
                    cont_nlzt.render();
                }, contexto_cuenta)
            });
        }
    },

    get_uni_productos: function () {
        //Extiende This
        this.Productos = [];

        //Recupera información
        var idCuenta = this.model.get('id');
        app.api.call('GET', app.api.buildURL('Accounts/' + idCuenta + '/link/accounts_uni_productos_1'), null, {
            success: function (data) {

                cont_uni_p.Productos = data;
                cont_uni_p.render();

            },
            error: function (e) {
                throw e;
            }
        });
    },


})
