({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        self = this;
        solicitud_cf = this;
        cont_RI = this;
        this._super("initialize", [options]);
        this.events['keydown input[name=vendedor_c]'] = 'checkvendedor';
        this.events['keydown input[name=monto_c]'] = 'checkmoney';
        this.events['keydown input[name=amount]'] = 'checkmoney';
        this.events['keydown input[name=ca_pago_mensual_c]'] = 'checkmoney';
        this.events['keydown input[name=ca_importe_enganche_c]'] = 'checkmoney';
        this.events['keydown input[name=tipo_tasa_ordinario_c]'] = 'limitanumero';
        this.events['keydown input[name=puntos_sobre_tasa_c]'] = 'limitanumero';
        this.events['keydown input[name=porcentaje_ca_c]'] = 'limitanumero';
        this.events['keydown input[name=f_aforo_c]'] = 'limitanumero';
        this.events['keydown input[name=tasa_fija_moratorio_c]'] = 'limitanumero';
        this.events['keydown input[name=puntos_tasa_moratorio_c]'] = 'limitanumero';
        this.events['keydown input[name=factor_moratorio_c]'] = 'limitanumero';
        this.events['click a[name=cancel_button]'] = 'cancelClicked';
        this.events['click a[name=monto_c]'] = 'formatcoin';
        this.events['click a[name=amount]'] = 'formatcoin';
        this.events['click a[name=ca_pago_mensual_c]'] = 'formatcoin';
        this.events['click a[name=ca_importe_enganche_c]'] = 'formatcoin';

        /*
        Contexto campos custom
        */
        //Condificiones financieras
        this.oFinanciera = [];
        this.oFinanciera.condicion = [];
        this.prev_oFinanciera = [];
        this.prev_oFinanciera.prev_condicion = [];
        /*

		 * @author Carlos Zaragoza Ortiz
		 * @version 1
		 * En operaciones de solicitud de crédito quitar opción de pipeline en lista de Forecast
		 * */
        // CVV - 28/03/2016 - Se oculto el campo de forecast
		/*
		var opciones_forecast = app.lang.getAppListStrings('forecast_list');
		var operacion = this.model.get('tipo_operacion_c');
		Object.keys(opciones_forecast).forEach(function(key){
			//console.log("CZ tipo forecast: " + key);
			if(key == "Pipeline"){
				if(operacion == 1){
					delete opciones_forecast[key];
				}
			}

		});
		this.model.fields['forecast_c'].options = opciones_forecast;
		*/
        this.model.addValidationTask('valida_direc_indicador', _.bind(this.valida_direc_indicador, this));
        this.model.addValidationTask('check_monto_c', _.bind(this._ValidateAmount, this));
        //this.model.addValidationTask('ratificacion_incremento_c', _.bind(this.validaTipoRatificacion, this));
        this.model.addValidationTask('ratificacion_incremento_c', _.bind(this.alertGpoEmpresarial, this));
        this.model.addValidationTask('check_condiciones_financieras', _.bind(this.validaCondicionesFinancerasRI, this));
        this.model.addValidationTask('check_condicionesFinancieras', _.bind(this.condicionesFinancierasCheck, this));
        this.model.addValidationTask('check_condicionesFinancierasIncremento', _.bind(this.condicionesFinancierasIncrementoCheck, this));
        this.model.addValidationTask('check_oportunidadperdida', _.bind(this.oportunidadperdidacheck, this));
        this.model.addValidationTask('check_condicionesFinancieras', _.bind(this.condicionesFinancierasCheck, this));
        this.model.addValidationTask('Valida_montos', _.bind(this.validamontossave, this));//Validación para comprobar montos no mayores a rentas y pagos mensuales. Adrian Arauz 16/08/2018
        this.model.addValidationTask('check_factoraje', _.bind(this.validaRequeridosFactoraje, this)); //Se añade funcionalidad para limitar a 99.00 en valores de factoraje. Adrian Arauz 23/08/2018
        this.model.addValidationTask('check_validaccionCuentaSubcuenta', _.bind(this.validacionCuentaSubcuentaCheck, this));/* @author victor.martinez 23-07-2018  Valida campos requeridos de prospecto e Integracion de expediente */
        this.model.addValidationTask('pagounico', _.bind(this.validapagounico, this));

        this.model.addValidationTask('valida_requeridos', _.bind(this.valida_requeridos, this));
        this.model.addValidationTask('valida_cuentas_pld', _.bind(this.valida_pld, this));
        this.model.addValidationTask('valida_no_vehiculos', _.bind(this._Validavehiculo, this));
        this.model.addValidationTask('valida_formato_campos_Cond_Financiera', _.bind(this.ConficionFinancieraFormat, this));
        this.model.addValidationTask('valida_formato_campos_Cond_FinancieraRI', _.bind(this.ConficionFinancieraRIFormat, this));
        /*
            AF. 12-02-2018
            Ajuste para actualizar valores en vista
        */
        this.model.on('sync', this.ocultynoedit, this);
        //this.model.on('sync', this.disable_panels_team, this);
        this.model.on('sync', this.getcfRI, this);
        this.model.on('sync', this.validaetiquetas, this);
        this.model.on('change:ca_pago_mensual_c', this.validamontos, this);
        this.model.on('change:amount', this.validamontos, this);
        this.model.on('change:porciento_ri_c', this.validamontos, this);
        this.model.on("change:porciento_ri_c", _.bind(this.calcularRI, this));
        this.model.on("change:ca_importe_enganche_c", _.bind(this.calcularPorcientoRI, this));
        this.model.on("change:anio_c", _.bind(this.getCurrentYearMonth, this));
        //this.model.on("change:tct_oportunidad_perdida_chk_c",this._HideSaveButton, this);
        //this.model.set('contacto_relacionado_c', "test");
        //this.model.on("click:rel_relaciones_id_c", _.bind(this.readOnly_contacto_relacionado, this));

        this.model.on('sync', this._HideSaveButton, this);  //Función ocultar botón guardar cuando Oportunidad perdida tiene un valor TRUE 18/07/18

        this.getCurrentYearMonth();

        /*@Jesus Carrillo
            Funcion que pinta de color los paneles relacionados
        */
        this.model.on('sync', this.fulminantcolor, this);

        //Recupera datos para custom fields
        this.getcf();

        //Se habilitan mensajes de informacion cuando la solicitud es de Credito SOS
        this.model.on('sync', this.mensajessos, this);
    },

    fulminantcolor: function () {
        $('#space').remove();
        $('.control-group').before('<div id="space" style="background-color:#000042"><br></div>');
        $('.control-group').css("background-color", "#e5e5e5");
        $('.a11y-wrapper').css("background-color", "#e5e5e5");
        //$('.a11y-wrapper').css("background-color", "#c6d9ff");
    },
    mensajessos: function () {
        //Funcion que valida los campos de operacion curso y operacion activa (campos que modificara UNICS)
        if (this.model.get('tipo_producto_c') == 7 && this.model.get('tipo_de_operacion_c') == 'RATIFICACION_INCREMENTO') {
            if (this.model.get('operacion_curso_chk_c') == true) {
                app.alert.show('Mensaje1_SOS', {
                    level: 'info',
                    autoClose: false,
                    messages: 'El cliente actualmente tiene una operación activa. Es necesario hacer CleanUp y dejar pasar 28 días.'
                });
            } else {
                //Se obtiene la fecha actual
                var hoy = new Date();
                var dd = hoy.getDate();
                if (dd < 10) {
                    dd = "0" + dd;
                }
                var mm = hoy.getMonth() + 1;
                var yyyy = hoy.getFullYear();
                var fecha_actual = yyyy + '-' + mm + '-' + dd;
                var operacion = this.model.get('ult_operacion_activa_c');
                var fecha1 = moment(fecha_actual);
                var fecha2 = moment(operacion);
                var diferencia = fecha1.diff(fecha2, 'days');

                if (this.model.get('operacion_curso_chk_c') == false && diferencia < 28) {
                    app.alert.show('Mensaje2_SOS', {
                        level: 'info',
                        autoClose: false,
                        messages: 'Es necesario esperar ' + (28 - diferencia) + ' días para poder disponer nuevamente.'
                    });
                }
                if (this.model.get('operacion_curso_chk_c') == false && diferencia == 28) {
                    app.alert.show('Mensaje3_SOS', {
                        level: 'info',
                        autoClose: false,
                        messages: 'Es necesario esperar a mañana para poder disponer nuevamente.'
                    });
                }
            }
        }
    },


    cancelClicked: function () {
        this._super('cancelClicked');
        window.contador = 0;
    },

    //No muestra en alert en algunos casos
    hasUnsavedChanges: function () {
        this._super('hasUnsavedChanges');

        if (this.action === 'detail') {
            return false;
        }
        else {
            if (_.isEmpty(this.collection.models[0].changed)) {
                return false;
            } else {
                return true;
            }
        }
    },

    ocultynoedit: function () {

        if (this.model.get('id_process_c') !== "" && this.model.get('id_process_c') != undefined) {
            var self = this;
            self.noEditFields.push('condiciones_financieras');
        }
        if (this.model.get('ratificacion_incremento_c') == true) {
            this.$('[data-name="ratificacion_incremento_c"]').attr('style', 'pointer-events:none');
            this.$('[data-name="condiciones_financieras_incremento_ratificacion"]').attr('style', 'pointer-events:none');
            this.$('[data-name="ri_usuario_bo_c"]').attr('style', 'pointer-events:none');
            this.$('[data-name="ri_anio_c"]').attr('style', 'pointer-events:none');
            this.$('[data-name="ri_mes_c"]').attr('style', 'pointer-events:none');
            this.$('[data-name="monto_ratificacion_increment_c"]').attr('style', 'pointer-events:none');
            this.noEditFields.push('ratificacion_incremento_c');
            this.noEditFields.push('condiciones_financieras_incremento_ratificacion');
            this.noEditFields.push('ri_usuario_bo_c');
            this.noEditFields.push('ri_anio_c');
            this.noEditFields.push('ri_mes_c');
            this.noEditFields.push('monto_ratificacion_increment_c');
        }
        if (this.model.get('tct_etapa_ddw_c') !== 'SI') {
            this.noEditFields.push('usuario_bo_c');
        }

        /* F. Javier G. Solar  16/08/2018
              Oculta los subpaneles dejando solo notas y reuniones
           */

        $('[data-subpanel-link="lev_backlog_opportunities"]').addClass('hide');
        $('[data-subpanel-link="opportunities_opportunities_1"]').addClass('hide');
        $('[data-subpanel-link="tct2_notificaciones_opportunities"]').addClass('hide');

        //Establece año
        var currentYear = (new Date).getFullYear();
        var opciones_year = app.lang.getAppListStrings('anio_list');
        Object.keys(opciones_year).forEach(function (key) {
            //Quita años previos
            if (key < currentYear) {
                delete opciones_year[key];
            }

        });
        //Establece valores para año
        this.model.fields['ri_anio_c'].options = opciones_year;

        if (this.model.get('ratificacion_incremento_c') != true) {
            this.$('div[data-name=ri_usuario_bo_c]').hide();
        } else {
            this.$('div[data-name=ri_usuario_bo_c]').show();

        }
    },

    _render: function () {
        this._super("_render");
        //Victor M.L 30-08-2018
        //Agrega validación para restringir edición de Gestión Comercial
        this.noEdita();
        this.blockRecordNoContactar();
        //Oculta campos nuevos para Credito SOS
        $('[data-name=ult_operacion_activa_c]').hide();
        $('[data-name=operacion_curso_chk_c]').hide();
        //Oculta campos de etapa y subetapa
        $('[data-name="pipeline_opp"]').attr('style', 'pointer-events:none');
        $('[data-name=tct_etapa_ddw_c]').hide();
        $('[data-name=estatus_c]').hide();
        //Oculta etiqueta del campo custom pipeline_opp
        $("div.record-label[data-name='pipeline_opp']").attr('style', 'display:none;');
        //Desabilita edicion campo pipeline
        this.noEditFields.push('pipeline_opp');

        //Victor M.L 19-07-2018
        //no Muestra el subpanel de Oportunidad perdida cuando se cumple la condición
        /*if(this.model.get('tct_etapa_ddw_c')=='SI' ||this.model.get('tct_etapa_ddw_c')=='P'){
            //no hace nada y muestra el panel
        }else{
            this.$('div[data-panelname=LBL_RECORDVIEW_PANEL1]').hide();
        }*/

        //AF: 22/06/2018
        //Ajuste para establecer usuario_bo_c(Equipo backOffice) como sólo lectura
        this.$("[data-name='usuario_bo_c']").prop("disabled", true);

        // @author Carlos Zaragoza
        // @brief Si el usuario esta ratificando una linea autorizada, se le quitan los permisos de edición sobre oportunidades.
        app.events.on("app:sync:complete", function () {
            var ac = SUGAR.App.user.getAcls();
            if ((this.model.get('tipo_operacion_c') == 2) && (this.model.get('tipo_de_operacion_c') == 'RATIFICACION_INCREMENTO')) {
                ac.Opportunities.edit = "no";
            } else {
                ac.Opportunities.edit = "yes";
            }
        });

        /*if(this.model.get('tipo_operacion_c')=='2'){
            this.$('div[data-name=plazo_ratificado_incremento_c]').show();
        }else{
            this.$('div[data-name=plazo_ratificado_incremento_c]').hide();
        }*/
        // CVV - 28/03/2016 - Se ocultan algunos campos que fueron reemplazados por el control de condiciones financieras
        this.model.on("change:ratificacion_incremento_c", _.bind(function () {
            //this.checkForRatificado();
            if (this.model.get('ratificacion_incremento_c') == false && this.model.get('tipo_operacion_c') == 2) {
                this.model.set('monto_ratificacion_increment_c', '0.00');
                this.$('div[data-name=plazo_ratificado_incremento_c]').hide();
                this.$('div[data-name=ri_usuario_bo_c]').hide();
                //this.model.set('ri_ca_tasa_c','0.000000');
                this.model.set('ri_porcentaje_ca_c', '0.000000');
                //this.model.set('ri_porcentaje_renta_inicial_c','0.000000');
                //this.model.set('ri_vrc_c','0.000000');
                //this.model.set('ri_vri_c','0.000000');
                //this.model.set('monto_ratificacion_increment_c','0.00');
                this.model.set('ri_usuario_bo_c', '');
                this.model.set('plazo_ratificado_incremento_c', '');
            } else {
                this.$('div[data-name=plazo_ratificado_incremento_c]').show();
                this.$('div[data-name=ri_usuario_bo_c]').show();
                this.obtieneCondicionesFinancieras();
            }
        }, this));

        this.model.on("change:monto_ratificacion_increment_c", _.bind(function () {
            Number.prototype.formatMoney = function (c, d, t) {
                var n = this,
                    c = isNaN(c = Math.abs(c)) ? 2 : c,
                    d = d == undefined ? "." : d,
                    t = t == undefined ? "," : t,
                    s = n < 0 ? "-" : "",
                    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
                    j = (j = i.length) > 3 ? j % 3 : 0;
                return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
            };
            if (this.model.get('ratificacion_incremento_c') == true && this.model.get("tipo_de_operacion_c") == "LINEA_NUEVA") {
                var tipo = "";
                var monto = 0;
                if (Number(this.model.get("monto_ratificacion_increment_c")) == 0) {
                    tipo = "Ratifiaci\u00F3n";
                    monto = Number(this.model.get("monto_c"));
                } else if (Number(this.model.get("monto_ratificacion_increment_c")) > 0) {
                    tipo = "Incremento";
                    monto = Number(this.model.get("monto_c")) + Number(this.model.get("monto_ratificacion_increment_c"));
                } else if (Number(this.model.get("monto_ratificacion_increment_c")) < 0) {
                    tipo = "Decremento";
                    monto = Number(this.model.get("monto_c")) + Number(this.model.get("monto_ratificacion_increment_c"));
                }
                app.alert.show("Moto Modificado", {
                    level: "info",
                    title: "El disponible de la l\u00EDnea despu\u00E9s de autorizar esta solicitud de " + tipo + " ser\u00E1 de " + monto.formatMoney(2, '.', ','),
                    autoClose: false
                });
            }
        }, this))

        this.model.on("change:monto_c", _.bind(function () {
            if (this.model.get('amount') == null || this.model.get('amount') == '') {
                this.model.set('amount', this.model.get('monto_c'));
            } else {
                //Si la oportunidad es de tipo Cotización/Contrato los montos deben ser iguales
                if ((this.model.get('tipo_operacion_c') == 3 || this.model.get('tipo_operacion_c') == 4) && parseFloat(this.model.get('amount')) != parseFloat(this.model.get('monto_c'))) {
                    app.alert.show("Moto de colocacion", {
                        level: "alert",
                        title: "El monto a operar se igualar\u00E1 al monto de la colocaci\u00F3n.",
                        autoClose: false
                    });
                    this.model.set('amount', this.model.get('monto_c'));
                } else {
                    if (parseFloat(this.model.get('amount')) > parseFloat(this.model.get('monto_c')) && this.model.get('tipo_operacion_c') == 1) {
                        /*app.alert.show("Moto a operar invalido", {
                            level: "error",
                            title: "El monto a operar no puede ser mayor al  monto solicitado.",
                            autoClose: false
                        });
                        this.model.set('amount',this.model.get('monto_c'));*/
                    }
                }
            }
        }, this));

        this.model.on("change:amount", _.bind(function () {
            if (this.model.get('monto_c') == null || this.model.get('monto_c') == '') {
                this.model.set('monto_c', this.model.get('amount'));
            } else {
                //Si la oportunidad es de tipo Cotización/Contrato los montos deben ser iguales
                if ((this.model.get('tipo_operacion_c') == 3 || this.model.get('tipo_operacion_c') == 4) && parseFloat(this.model.get('amount')) != parseFloat(this.model.get('monto_c'))) {
                    app.alert.show("Moto de colocacion", {
                        level: "alert",
                        title: "El monto de la colocaci\u00F3n se igualar\u00E1 al monto a operar",
                        autoClose: false
                    });
                    this.model.set('monto_c', this.model.get('amount'));
                } else {
                    if (parseFloat(this.model.get('amount')) > parseFloat(this.model.get('monto_c')) && this.model.get('tipo_operacion_c') == 1) {
                        /*app.alert.show("Moto a operar invalido", {
                            level: "error",
                            title: "El monto a operar no puede ser mayor al monto de la linea.",
                            autoClose: false
                        });
                        this.model.set('amount',this.model.get('monto_c'));*/
                    }
                }
            }
        }, this));

        /*
         * @author Carlos Zaragoza
         * @version 1
         * Validamos que se pueda usar el campo vacío en el forecast. Agregar opción "…" en forecast time para indicar que se cierra este mes (esta opción se selecciona en automático si la fecha de cierre está dentro del mes corriente) Si la fecha de cierre esta fuera del mes corriente calcular si es 30, 60, etc.
         * */
        // CVV - 28/03/2016 - El campo de fecha de cierre se elimino del layout
        /*this.model.on("change:date_closed", _.bind(function() {
            var fecha_cierre = this.model.get('date_closed');
            var fecha_actual = new Date();
            fecha_cierre  = new Date(fecha_cierre+"T12:00:00Z");
            var months;
            months = (fecha_cierre.getFullYear() - fecha_actual.getFullYear()) * 12;
            months -= fecha_actual.getMonth();
            months += fecha_cierre.getMonth();
            //console.log("Meses: " + months);

            if(months == 0 ){
                this.model.set('forecast_time_c',"");
            }
            if(months == 1){
                this.model.set('forecast_time_c',"30");
            }
            if(months == 2){
                this.model.set('forecast_time_c',"60");
            }
            if(months == 3){
                this.model.set('forecast_time_c',"90");
            }
            if(months >= 4){
                this.model.set('forecast_time_c',"90mas");
            }

        },this));  */
        /*if(this.model.get('tipo_operacion_c')!='3'){
            //* Quitamos los campos Vendedor y Comisión
            this.$('div[data-name=opportunities_ag_vendedores_1_name]').hide();
            this.$('div[data-name=comision_c]').hide();
        }*/
        //CVV - 28/03/2016 - Se ocultan los campos de activo para reemplazarlos por control de condiciones financieras

        /*if(this.model.get('tipo_producto_c') != '4'){
            //Muestra los campos los valores cuando es 4
            this.$('div[data-name=activo_c]').show();
            this.$('div[data-name=sub_activo_c]').show();
            this.$('div[data-name=sub_activo_2_c]').show();
            this.$('div[data-name=sub_activo_3_c]').show();
        }else{
            //Oculta los campos
            this.$('div[data-name=activo_c]').hide();
            this.$('div[data-name=sub_activo_c]').hide();
            this.$('div[data-name=sub_activo_2_c]').hide();
            this.$('div[data-name=sub_activo_3_c]').hide();
        }*/

        /*console.log(this.model.get('ratificacion_incremento_c'));
        if(this.model.get('ratificacion_incremento_c')==false){
            //Oculta campos para condiciones financieras
            this.$('div[data-name=plazo_ratificado_incremento_c]').hide();
            this.$('div[data-name=ri_usuario_bo_c]').hide();
        }else{
            //Prende los campos
            this.$('div[data-name=plazo_ratificado_incremento_c]').show();
            this.$('div[data-name=ri_usuario_bo_c]').show();
        }*/
        //llamamos a las condiciones financieras por default para ratificación.
        // this.obtieneCondicionesFinancieras();
        this.model.on("change:plazo_ratificado_incremento_c", _.bind(function () {
            //Si cambia el plazo disparamos las condiciones:
            this.obtieneCondicionesFinancieras();
        }, this));

        this.model.on("change:tipo_producto_c", _.bind(function () {
            this.obtieneCondicionesFinancieras();
            if (this.model.get('tipo_producto_c') == '3') {
                this.$("div.record-label[data-name='ri_porcentaje_renta_inicial_c']").text("Porcentaje de Enganche R/I");
                this.$("div.record-label[data-name='porcentaje_renta_inicial_c']").text("Porcentaje de Enganche");
            } else {
                this.$("div.record-label[data-name='ri_porcentaje_renta_inicial_c']").text("Porcentaje Renta Inicial R/I");
                this.$("div.record-label[data-name='porcentaje_renta_inicial_c']").text("Porcentaje Renta Inicial");
            }

            if (this.model.get('tipo_producto_c') == '6') {
                this.$("div.record-label[data-name='monto_c']").text("L\u00EDnea aproximada");
            } else {
                this.$("div.record-label[data-name='monto_c']").text("Monto de l\u00EDnea");
            }
        }, this));

        //oculta campo de monto grupo empresarial
        this.$('div[data-name=monto_gpo_emp_c]').hide();
    },

    validacionCuentaSubcuentaCheck: function (fields, errors, callback) {
        self = this;
        var obid = this.model.get('account_id');
        var caso = "2";
        var producto = this.model.get('tipo_producto_c');
        //En caso de ser una solicitud de Unilease, se deben de validar los mismos campos que Leasing id=1
        if (producto == '9') {
            producto = '1';
        }

        if ((obid != "" || obid != null) && this.model.get('tct_oportunidad_perdida_chk_c') != true && this.model.get('tct_etapa_ddw_c') == 'SI') {
            app.api.call('GET', app.api.buildURL('ObligatoriosCuentasSolicitud/' + this.model.get('account_id') + '/2/' + producto), null, {
                success: _.bind(function (data) {

                    if (data != "") {
                        var titulo = "Campos Requeridos en Cuentas";
                        var nivel = "error";
                        var mensaje = "Hace falta completar la siguiente informaci&oacuten en la <b>Cuenta<b>:<br> " + data + "</b></b>";

                        if (this.multiSearchOr(data, ["Propietario Real"]) == '1') {
                            var mensaje = mensaje + "<br><br>(Se debe agregar una relaci\u00F3n de tipo <b>Propietario real</b>).";
                        }
                        if (this.multiSearchOr(data, ["Proveedor de Recursos Leasing"]) == '1') {
                            var mensaje = mensaje + "<br><br>(Se debe agregar una relaci\u00F3n de tipo <b>Proveedor de Recursos Leasing</b>).";
                        }
                        if (this.multiSearchOr(data, ["Proveedor de Recursos Factoraje Financiero"]) == '1') {
                            var mensaje = mensaje + "<br><br>(Se debe agregar una relaci\u00F3n de tipo <b>Proveedor de Recursos Factoraje Financiero</b>).";
                        }
                        if (this.multiSearchOr(data, ["Proveedor de Recursos Crédito Automotriz"]) == '1') {
                            var mensaje = mensaje + "<br><br>(Se debe agregar una relaci\u00F3n de tipo <b>Proveedor de Recursos Crédito Automotriz</b>).";
                        }
                        if (this.multiSearchOr(data, ["Proveedor de Recursos Crédito Simple"]) == '1') {
                            var mensaje = mensaje + "<br><br>(Se debe agregar una relaci\u00F3n de tipo <b>Proveedor de Recursos Crédito Simple</b>).";
                        }

                        app.error.errorName2Keys['custom_message1'] = 'Falta tipo y subtipo de cuenta';
                        errors['account_name_1'] = errors['account_name_1'] || {};
                        errors['account_name_1'].custom_message1 = true;
                        errors['account_name_1'].required = true;
                        self.mensajes(titulo, mensaje, nivel);

                    }
                    callback(null, fields, errors);

                }, self),
            });
        }
        else {
            callback(null, fields, errors);
        }
    },

    valida_pld: function (fields, errors, callback) {
        //Valida que cuenta tenga registrado PLD por tipo de producto con base en usuario logeado
        //Recupera producto de usuario
        var tipoProdArr = [];
        tipoProdArr['1'] = 'AP';
        tipoProdArr['4'] = 'FF';
        tipoProdArr['3'] = 'CA';
        var usuarioProducto = tipoProdArr[App.user.attributes.tipodeproducto_c];
        var producto = "";

        if (usuarioProducto == "AP") {
            producto = "Arrendamiento Puro";
        }
        if (usuarioProducto == "FF") {
            producto = "Factoraje Financiero";
        }
        if (usuarioProducto == "CA") {
            producto = "Crédito Automotriz";
        }
        //Recupera cuenta asociada
        var cuentaId = this.model.get('account_id');
        var faltantes = "";
        if ((cuentaId != "" || cuentaId != null) && this.model.get('tct_oportunidad_perdida_chk_c') != true && this.model.get('tct_etapa_ddw_c') == 'SI' && this.model.get('tipo_producto_c') != "6" && this.model.get('tipo_producto_c') != "8" && this.model.get('tipo_producto_c') != "9") {

            app.api.call('GET', app.api.buildURL('Accounts/' + cuentaId), null, {
                success: _.bind(function (cuenta) {
                    var tipopersona = cuenta.tipodepersona_c;
                    faltaPld = "";

                    if (cuenta.tct_cpld_pregunta_u1_ddw_c == "" && tipopersona == 'Persona Moral') {
                        faltantes = faltantes + '<b>-¿La persona moral es: Sofom, Transmisor de Dinero, Centro Cambiario?<br>';
                    }
                    if (cuenta.tct_cpld_pregunta_u3_ddw_c == "" && tipopersona == 'Persona Moral') {
                        faltantes = faltantes + '<b>-¿Cotiza en Bolsa?<br>';
                    }
                    app.api.call('GET', app.api.buildURL('Accounts/' + cuentaId + '/link/accounts_tct_pld_1?filter[0][description][$equals]=' + usuarioProducto), null, {
                        success: _.bind(function (data) {
                            if (data != "") {
                                if (data.records.length > 0) {
                                    //Realizar validación de cammpos requeridos
                                    if (usuarioProducto == "AP") {
                                        if (tipopersona != 'Persona Moral') {
                                            //PF - PFAE
                                            faltaPld = (data.records[0].tct_pld_campo2_ddw == "" || data.records[0].tct_pld_campo4_ddw == "" || data.records[0].tct_pld_campo6_ddw == ""
                                                || data.records[0].tct_pld_campo16_ddw == "") ? " <b>- Producto " + producto + "</b><br>" : "";
                                        } else {
                                            //PM
                                            faltaPld = (data.records[0].tct_pld_campo4_ddw == "" || data.records[0].tct_pld_campo6_ddw == ""
                                                || data.records[0].tct_pld_campo16_ddw == "") ? " <b>- Producto " + producto + "</b><br>" : "";
                                        }
                                    }
                                    //Realizar validación de campos requeridos
                                    if (usuarioProducto == "FF") {
                                        if (tipopersona != 'Persona Moral') {
                                            //PF - PFAE
                                            faltaPld = (data.records[0].tct_pld_campo2_ddw == "" || data.records[0].tct_pld_campo4_ddw == "" || data.records[0].tct_pld_campo6_ddw == ""
                                                || data.records[0].tct_pld_campo16_ddw == "" || data.records[0].tct_pld_campo24_ddw == "" || data.records[0].tct_pld_campo21_ddw == "") ? " <b>- Producto " + producto + "</b><br>" : "";
                                        } else {
                                            //PM
                                            faltaPld = (data.records[0].tct_pld_campo4_ddw == "" || data.records[0].tct_pld_campo6_ddw == ""
                                                || data.records[0].tct_pld_campo16_ddw == "" || data.records[0].tct_pld_campo24_ddw == "" || data.records[0].tct_pld_campo21_ddw == "") ? " <b>- Producto " + producto + "</b><br>" : "";
                                        }
                                    }
                                    if (usuarioProducto == "CA") {
                                        if (tipopersona != 'Persona Moral') {
                                            //PF - PFAE
                                            faltaPld = (data.records[0].tct_pld_campo2_ddw == "" || data.records[0].tct_pld_campo4_ddw == "" || data.records[0].tct_pld_campo6_ddw == ""
                                                || data.records[0].tct_pld_campo16_ddw == "" || data.records[0].tct_pld_campo16_ddw == "") ? " <b>- Producto " + producto + "</b><br>" : "";
                                        } else {
                                            //PM
                                            faltaPld = (data.records[0].tct_pld_campo4_ddw == "" || data.records[0].tct_pld_campo6_ddw == ""
                                                || data.records[0].tct_pld_campo16_ddw == "" || data.records[0].tct_pld_campo16_ddw == "") ? " <b>- Producto " + producto + "</b><br>" : "";
                                        }
                                    }
                                } else {
                                    errors['accounts_pld'] = errors['accounts_pld'] || {};
                                    errors['accounts_pld'].required = true;
                                    self.mensajes("valida_pld", "Hace falta completar la siguiente información en la pestaña <b>PLD</b> de la <b>Cuenta:</b><br>" + faltaPld + faltantes, "error");
                                    callback(null, fields, errors);
                                }
                            } else {
                                errors['accounts_pld'] = errors['accounts_pld'] || {};
                                errors['accounts_pld'].required = true;
                                self.mensajes("valida_pld", "Hace falta completar la siguiente información en la pestaña <b>PLD</b> de la <b>Cuenta:</b><br>" + faltaPld + faltantes, "error");
                                callback(null, fields, errors);
                            }
                            if (faltaPld || faltantes != "") {
                                errors['accounts_pld'] = errors['accounts_pld'] || {};
                                errors['accounts_pld'].required = true;
                                self.mensajes("valida_pld", "Hace falta completar la siguiente información en la pestaña <b>PLD</b> de la <b>Cuenta:</b><br>" + faltaPld + faltantes, "error");
                            }
                            callback(null, fields, errors);
                        }, self),
                    });


                }, self),
            });
        }
        else {
            callback(null, fields, errors);
        }
    },

    //@Jesus Carrillo, metodo que busca las palabras dadas
    multiSearchOr: function (text, searchWords) {
        var regex = searchWords
            .map(word => "(?=.*\\b" + word + "\\b)")
            .join('');
        var searchExp = new RegExp(regex, "gi");
        return (searchExp.test(text)) ? "1" : "0";
    },

    delegateButtonEvents: function () {
        this._super("delegateButtonEvents");

        this.context.on('button:expediente_button:click', this.expedienteClicked, this);
        this.context.on('button:ratificado_button:click', this.ratificadoClicked, this);
        this.context.on('button:edit_button:click', this.checkForRatificado, this);
        this.context.on('button:edit_button:click', this._HideSaveButton, this);
        //this.model.on('change:monto_c', this._ValidateAmount, this);
        //this.events['blur input[name=monto_c]'] = '_ValidateAmount';
        this.context.on('button:sobregiro:click', this.sobregiroClicked, this);
        this.context.on('button:cancela_operacion_button:click', this.cancelaOperacion, this);
        this.context.on('button:expediente_credito_button:click', this.expedienteCredito, this);
        this.context.on('button:votacion_comite_button:click', this.votacionComite, this);
    },
	/*
  	 _ValidateAmount: function (){
  	 var monto = this.model.get("amount");
  	 if (monto <= 0)
  	 {
  	 app.alert.show("Valida Monto de Operación", {
  	 level: "error",
  	 title: "El monto debe ser mayor a cero.",
  	 autoClose: false
  	 });
  	 }
  	 },
  	 */
    expedienteClicked: function () {
        if (this.model.get('id_process_c') == '-1') {
            app.alert.show("Expediente no disponible", {
                level: "error",
                title: "Por el momento este expediente solo se encuentra disponible en UNICS",
                autoclose: false
            });
        } else {
            var Oppid = this.model.get('id');
            window.open("#bwc/index.php?entryPoint=ExpedienteVaadinOportunidad&Oppid=" + Oppid);
        }

    },
    /*Valida que solo algunos roles puedan editar la solicitud
    * Victor Martinez Lopez
    * */
    noEdita: function () {
        //Recuperar roles de usuarios
        var roles_usuario = app.user.attributes.roles;
        var roles_no_edicion = app.lang.getAppListStrings('promoaux_list');
        //var roles_no_edicion=["Gestion Comercial", "Promotor Leasing"];
        //Definir si puede o no editar
        var editar = true;
        //Comparar roles de usuario con roles no edición
        roles_usuario.forEach(function (element) {
            console.log(element);
            //Comparar contra roles no edición
            Object.keys(roles_no_edicion).forEach(function (key) {
                console.log(roles_no_edicion[key]);
                if (element == roles_no_edicion[key]) {
                    editar = false;
                }
            });
        });

        //Ocultar edición
        if (editar == false) {
            app.api.call('GET', app.api.buildURL('GetUsersTeams/' + this.model.get('id') + '/Opportunities'), null, {
                success: _.bind(function (data) {
                    if (data == false) {
                        $('[name="save_button"]').eq(0).hide();
                        $('[name="edit_button"]').eq(0).hide();
                        $(".noEdit").hide();
                    }
                    console.log(data);
                }, this),
                error: _.bind(function (error) {
                    console.log("No se obtuvo nada", error);
                }, this),
            });
        }
    },

    blockRecordNoContactar: function () {

        var id_cuenta = this.model.get('account_id');

        if (id_cuenta != '' && id_cuenta != undefined) {

            var account = app.data.createBean('Accounts', { id: this.model.get('account_id') });
            account.fetch({
                success: _.bind(function (model) {
                    if (model.get('tct_no_contactar_chk_c') == true) {

                        app.alert.show("cuentas_no_contactar", {
                            level: "error",
                            title: "Cuenta No Contactable<br>",
                            messages: "Cualquier duda o aclaraci\u00F3n, favor de contactar al \u00E1rea de <b>Administraci\u00F3n de cartera</b>",
                            autoClose: false
                        });

                        //Bloquear el registro completo y mostrar alerta
                        $('.record.tab-layout').attr('style', 'pointer-events:none');
                    }
                }, this)
            });

        }

    },

    expedienteCredito: function () {
        if (this.model.get('id_process_c') == '-1') {
            app.alert.show("Expediente no disponible", {
                level: "error",
                title: "El analisis de esta operación solo se encuentra disponible en UNICS",
                autoclose: false
            });
        } else {
            var Oppid = this.model.get('idsolicitud_c');
            window.open("#bwc/index.php?entryPoint=ExpedienteCredito&Oppid=" + Oppid);
        }
    },

    sobregiroClicked: function () {
        if (this.model.get('tipo_operacion_c') != "2") {
            app.alert.show("Linea incorrecta", {
                level: "error",
                title: "La solicitud de sobregiro solo puede realizarse a lineas de credito Autorizadas.",
                autoclose: false
            });
        } else {
            window.open("#bwc/index.php?entryPoint=AdmonLineasCredito&idPersona=" + this.model.get("account_id"));
        }

    },


    votacionComite: function () {
        if (this.model.get('id_process_c') > 0 && (this.model.get('estatus_c') == 'N' || this.model.get('estatus_c') == 'D') && (this.model.get('tipo_operacion_c') == "1" || this.model.get('tipo_operacion_c') == "2")) {
            var Oppid = this.model.get('idsolicitud_c');
            window.open("#bwc/index.php?entryPoint=Votacion&Oppid=" + Oppid);
        } else {
            app.alert.show("Votación no disponible", {
                level: "error",
                title: "Opcion no disponible",
                autoclose: false
            });
        }
    },

    ratificadoClicked: function () {
        if (this.model.get('tipo_operacion_c') == '1') {
            app.alert.show("Ratificación e incremento", {
                level: "error",
                title: "No puedes ratificar en una solicitud",
                autoClose: false
            });
        } else {
            if (this.model.get('tipo_operacion_c') == "2") {
                var newOppId = '';
                var OppParams = {
                    'monto': this.model.get("monto_c"),
                    'relatedAccount': this.model.get("account_id"),
                    'parentId': this.model.get("id"),
                };
                var dnbProfileUrl = app.api.buildURL("Opportunities/Ratificado", '', {}, {});
                app.api.call("create", dnbProfileUrl, { data: OppParams }, {
                    success: _.bind(function (data) {
                        if (data != null) {
                            newOppId = data;
                            window.location.assign("#Opportunities/" + newOppId);
                        }
                    }, this)
                });
            } else {
                app.alert.show("Ratificación e incremento", {
                    level: "error",
                    title: "Ratificaci&oacute;n / Incremento solamente con l&iacute;nea de cr&eacute;dito autorizada.",
                    autoClose: false
                });
            }
        }

    },

    checkForRatificado: function () {
        var OppParams = {
            'parentId': this.model.get("id"),
        };
        var dnbProfileUrl = app.api.buildURL("Opportunities/CheckForRatificados", '', {}, {});
        app.api.call("create", dnbProfileUrl, { data: OppParams }, {
            success: _.bind(function (data) {
                if (data != null) {
                    if (data == true || this.model.get("ratificacion_incremento_c")) {
                        app.alert.show("Operaciones Ratificadas", {
                            level: "error",
                            title: "Ratificaci\u00F3n o incremento en progreso, no se puede editar.",
                            autoClose: true
                        });
                        this.cancelClicked();
                        //this.render();
                    }
                }
            }, this)
        });
    },

    _dispose: function () {
        this._super('_dispose', []);
    },

    cancelaOperacion: function () {

    },


    _ValidateAmount: function (fields, errors, callback) {
        if (this.model.get('tct_oportunidad_perdida_chk_c') == false) {
            if (parseFloat(this.model.get('monto_c')) <= 0 && this.model.get('tipo_producto_c') != "7") {
                errors['monto_c'] = errors['monto_c'] || {};
                errors['monto_c'].required = true;
            }

            if (parseFloat(this.model.get('amount')) <= 0 && this.model.get('tipo_operacion_c') == '1' && this.model.get('tipo_producto_c') != "7") {
                errors['amount'] = errors['amount'] || {};
                errors['amount'].required = true;
            }

            if (parseFloat(this.model.get('ca_pago_mensual_c')) <= 0 && this.model.get('tipo_producto_c') != "6" && this.model.get('tipo_producto_c') != "7") {
                errors['ca_pago_mensual_c'] = errors['ca_pago_mensual_c'] || {};
                errors['ca_pago_mensual_c'].required = true;
            }

            if (this.model.get('tct_etapa_ddw_c') == 'SI') {
                if (parseFloat(this.model.get('ca_importe_enganche_c')) <= 0 && (this.model.get('tipo_producto_c') == "1" || this.model.get('tipo_producto_c') == "9")) {
                    errors['ca_importe_enganche_c'] = errors['ca_importe_enganche_c'] || {};
                    errors['ca_importe_enganche_c'].required = true;

                    app.alert.show("Pago_unico_requerido_monto", {
                        level: "error",
                        title: "Pago Único debe ser mayor a cero",
                        autoClose: false
                    });

                }

                if ((parseFloat(this.model.get('porciento_ri_c')) <= 0 || this.model.get('porciento_ri_c') == "") && (this.model.get('tipo_producto_c') == "1" || this.model.get('tipo_producto_c') == "9")) {
                    errors['porciento_ri_c'] = errors['porciento_ri_c'] || {};
                    errors['porciento_ri_c'].required = true;

                    app.alert.show("Pago_unico_requerido_porcent", {
                        level: "error",
                        title: "% Pago Único debe ser mayor a cero",
                        autoClose: false
                    });

                }
            }

        }
        callback(null, fields, errors);
    },
    validaTipoRatificacion: function (fields, errors, callback) {
        if (this.model.get('tct_oportunidad_perdida_chk_c') == false) {
            if (this.model.get('tipo_operacion_c') == '2') {
                if (this.model.get('ratificacion_incremento_c') == true) {

                    if (Number(this.model.get('monto_ratificacion_increment_c')) == 0) {
                        //errores
                        app.alert.show("Monto Ratificacion", {
                            level: "error",
                            title: "El monto de ratificacion debe ser mayor a 0.00",
                            autoClose: false
                        });
                        errors['monto_ratificacion_increment_c'] = errors['monto_ratificacion_increment_c'] || {};
                        errors['monto_ratificacion_increment_c'].required = true;

                    }

                    if (Number(this.model.get('ca_pago_mensual_c')) == 0) {
                        errors['ca_pago_mensual_c'] = errors['ca_pago_mensual_c'] || {};
                        errors['ca_pago_mensual_c'].required = true;

                    }
                }
            }
        }
        callback(null, fields, errors);
    },
    obtieneCondicionesFinancieras: function () {
        /*
         * Obtiene las condidionces financieras
         * */
		/*
		if(this.model.get('tipo_producto_c')=='4') {
			var OppParams = {
				'plazo_c': this.model.get('plazo_ratificado_incremento_c'),
				'tipo_producto_c': this.model.get('tipo_producto_c'),
			};
			//console.log(OppParams);
			var dnbProfileUrl = app.api.buildURL("Opportunities/CondicionesFinancieras", '', {}, {});
			app.api.call("create", dnbProfileUrl, {data: OppParams}, {
				success: _.bind(function (data) {
					if (data != null) {
						//CVV - 28/03/2016 - Se reemplaza por control de condiciones financieras

						 if(this.model.get('tipo_producto_c')=='1'){
						 this.model.set('ri_porcentaje_ca_c',data.porcentaje_ca_c);
						 this.model.set('ri_vrc_c',data.vrc_c);
						 this.model.set('ri_vri_c',data.vri_c);
						 this.model.set('ri_ca_tasa_c',data.ca_tasa_c);
						 this.model.set('ri_porcentaje_renta_inicial_c',data.porcentaje_renta_inicial_c);
						 }else if(this.model.get('tipo_producto_c')=='3'){
						 this.model.set('ri_ca_tasa_c',data.ca_tasa_c);
						 this.model.set('ri_porcentaje_ca_c',data.porcentaje_ca_c);
						 this.model.set('ri_porcentaje_renta_inicial_c',data.porcentaje_renta_inicial_c);
						 this.model.set('ri_vrc_c','0.0');
						 this.model.set('ri_vri_c','0.0');
						 }else
						if (this.model.get('tipo_producto_c') == '4') {
							//this.model.set('ri_ca_tasa_c',data.ca_tasa_c);
							this.model.set('puntos_sobre_tasa_c', data.ca_tasa_c);
							this.model.set('ri_porcentaje_ca_c', data.porcentaje_ca_c);
							//this.model.set('ri_porcentaje_renta_inicial_c','0.0');
							//this.model.set('ri_vrc_c','0.0');
							//this.model.set('ri_vri_c','0.0');
						}

					}
				}, this)
			});
		}*/
    },
    validaCondicionesFinancerasRI: function (fields, errors, callback) {
        if (this.model.get('tct_oportunidad_perdida_chk_c') == false) {
            if (this.model.get('ratificacion_incremento_c') == true && this.model.get('tipo_operacion_c') == '2') {
                if (this.model.get('tipo_producto_c') == '4') { //Factoraje
                    /*if (Number(this.model.get('ri_ca_tasa_c')) >= 100 || Number(this.model.get('ri_ca_tasa_c') < 0) || this.model.get('ri_ca_tasa_c') == '') {
                        errors['ri_ca_tasa_c'] = errors['ri_ca_tasa_c'] || {};
                        errors['ri_ca_tasa_c'].required = true;
                    }*/
                    if (Number(this.model.get('ri_porcentaje_ca_c')) >= 100 || Number(this.model.get('ri_porcentaje_ca_c') < 0) || this.model.get('ri_porcentaje_ca_c') == '') {
                        errors['ri_porcentaje_ca_c'] = errors['ri_porcentaje_ca_c'] || {};
                        errors['ri_porcentaje_ca_c'].required = true;
                    }
                    if (this.model.get('ri_tipo_tasa_ordinario_c') == undefined || this.model.get('ri_tipo_tasa_ordinario_c') == "") {
                        //error
                        errors['ri_tipo_tasa_ordinario_c'] = errors['ri_tipo_tasa_ordinario_c'] || {};
                        errors['ri_tipo_tasa_ordinario_c'].required = true;
                    }
                    if (this.model.get('ri_instrumento_c') == undefined || this.model.get('ri_instrumento_c') == "") {
                        //error
                        errors['ri_instrumento_c'] = errors['ri_instrumento_c'] || {};
                        errors['ri_instrumento_c'].required = true;
                    }
                    if (this.model.get('ri_puntos_sobre_tasa_c') == "" || this.model.get('ri_puntos_sobre_tasa_c') == undefined || (Number(this.model.get('ri_puntos_sobre_tasa_c')) < 0 || Number(this.model.get('ri_puntos_sobre_tasa_c')) > 99.999999)) {
                        //error
                        errors['ri_puntos_sobre_tasa_c'] = errors['ri_puntos_sobre_tasa_c'] || {};
                        errors['ri_puntos_sobre_tasa_c'].required = true;
                    }
                    if (this.model.get('ri_tipo_tasa_moratorio_c') == undefined || this.model.get('ri_tipo_tasa_moratorio_c') == "") {
                        //error
                        errors['ri_tipo_tasa_moratorio_c'] = errors['ri_tipo_tasa_moratorio_c'] || {};
                        errors['ri_tipo_tasa_moratorio_c'].required = true;
                    }
                    if (this.model.get('ri_instrumento_moratorio_c') == undefined || this.model.get('ri_instrumento_moratorio_c') == "") {
                        //error
                        errors['ri_instrumento_moratorio_c'] = errors['ri_instrumento_moratorio_c'] || {};
                        errors['ri_instrumento_moratorio_c'].required = true;
                    }
                    if (this.model.get('ri_puntos_tasa_moratorio_c') == "" || this.model.get('ri_puntos_tasa_moratorio_c') == undefined || (Number(this.model.get('ri_puntos_tasa_moratorio_c')) < 0 || Number(this.model.get('ri_puntos_tasa_moratorio_c')) > 99.999999)) {
                        //error
                        errors['ri_puntos_tasa_moratorio_c'] = errors['ri_puntos_tasa_moratorio_c'] || {};
                        errors['ri_puntos_tasa_moratorio_c'].required = true;
                    }
                    if (this.model.get('ri_factor_moratorio_c') == "" || this.model.get('ri_factor_moratorio_c') == undefined || (Number(this.model.get('ri_factor_moratorio_c')) < 0 || Number(this.model.get('ri_factor_moratorio_c')) > 99.999999)) {
                        //error
                        errors['ri_factor_moratorio_c'] = errors['ri_factor_moratorio_c'] || {};
                        errors['ri_factor_moratorio_c'].required = true;
                    }
                    if (this.model.get('ri_cartera_descontar_c') == "" || this.model.get('ri_cartera_descontar_c') == undefined) {
                        //error
                        errors['ri_cartera_descontar_c'] = errors['ri_cartera_descontar_c'] || {};
                        errors['ri_cartera_descontar_c'].required = true;
                    }
                }
            } else {
                //this.model.set('ri_ca_tasa_c','0.000000');
                this.model.set('ri_porcentaje_ca_c', '0.000000');
                //this.model.set('ri_porcentaje_renta_inicial_c','0.000000');
                //this.model.set('ri_vrc_c','0.000000');
                //this.model.set('ri_vri_c','0.000000');
                //this.model.set('monto_ratificacion_increment_c','0.00');
                this.model.set('ri_usuario_bo_c', '');
                this.model.set('plazo_ratificado_incremento_c', '');
            }
            /*
            if(errors.length==0){
                this.model.set('tipo_de_operacion_c', 'RATIFICACION_INCREMENTO');
            }else{
                this.model.set('tipo_de_operacion_c', 'LINEA_NUEVA')
            }*/
        }
        callback(null, fields, errors);
    },


    /*ratificado_button : function() {
        if(this.model.get('tipo_operacion_c') == '1') {
            this.hide_button('ratificado_button');
        }
    },*/
    /* hide_button: function(name) {
 console.log(name);
         var button_sel = '';
         var button_index = '';
         // find the buttons index for the share button
         _.find(this.meta.buttons, function(bn, idx) {
             console.log(bn);
             if(bn.name == 'main_dropdown') {
                 button_sel = idx;
                 _.find(bn.buttons, function(bbn, idx_bbn) {
                     if(bbn.name == name) {
                         button_index = idx_bbn;
                         return true;
                     }
                 });
                 return true;
             }
         });
         if(button_sel != '' && button_index != '')
         {
             console.log(button_sel);
             console.log(button_index);
             //remove the meta
             this.meta.buttons[button_sel].buttons.splice(button_index, 1);
         }
     },*/

    getCurrentYearMonth: function () {

        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();
        //currentMonth += 1;

        if (currentDay < 20) {
            currentMonth += 1;
        }
        if (currentDay >= 20) {
            currentMonth += 2;
        }
        var opciones_year = app.lang.getAppListStrings('anio_list');
        Object.keys(opciones_year).forEach(function (key) {
            if (key < currentYear) {
                delete opciones_year[key];
            }
        });
        this.model.fields['anio_c'].options = opciones_year;

        var opciones_mes = app.lang.getAppListStrings('mes_list');
        if (this.model.get("anio_c") <= currentYear) {
            Object.keys(opciones_mes).forEach(function (key) {
                if (key < currentMonth) {
                    delete opciones_mes[key];
                }
            });
        }

        this.model.fields['mes_c'].options = opciones_mes;
        //this.render();
    },

    condicionesFinancierasCheck: function (fields, errors, callback) {
        if (this.model.get('tct_oportunidad_perdida_chk_c') == false) {
            if (this.model.get("tipo_operacion_c") == 1 && this.model.get("tipo_producto_c") != 4 && this.model.get("tipo_producto_c") != 6 && this.model.get("tipo_producto_c") != 7) {
                if (solicitud_cf.oFinanciera.condicion.length == 0) {
                    errors[$(".addCondicionFinanciera")] = errors['condiciones_financieras'] || {};
                    errors[$(".addCondicionFinanciera")].required = true;

                    $('.condiciones_financieras').css('border-color', 'red');
                    app.alert.show("CondicionFinanciera requerida", {
                        level: "error",
                        title: "Al menos una Condición Financiera es requerida.",
                        autoClose: false
                    });
                } else if (solicitud_cf.oFinanciera.condicion.length >= 1) {
                    solicitud_cf.model.set('condiciones_financieras', solicitud_cf.oFinanciera.condicion);
                }
            }
        }
        callback(null, fields, errors);
    },

    condicionesFinancierasIncrementoCheck: function (fields, errors, callback) {
        if (this.model.get('tct_oportunidad_perdida_chk_c') == false) {
            if (this.model.get("ratificacion_incremento_c") == 1 && this.model.get("tipo_operacion_c") == 2 && this.model.get("tipo_producto_c") != 4 && this.model.get("tipo_producto_c") != 7) {
                if (contRI.oFinancieraRI.ratificacion.length == 0) {
                    errors[$(".add_incremento_CondicionFinanciera")] = errors['condiciones_financieras_incremento_ratificacion'] || {};
                    errors[$(".add_incremento_CondicionFinanciera")].required = true;

                    $('.condiciones_financieras_incremento_ratificacion').css('border-color', 'red');
                    app.alert.show("CondicionFinanciera requerida", {
                        level: "error",
                        title: "Al menos una Condición Financiera de Incremento/Ratificacion es requerida.",
                        autoClose: false
                    });
                } else if (contRI.oFinancieraRI.ratificacion.length >= 1) {
                    contRI.model.set('condiciones_financieras_incremento_ratificacion', contRI.oFinancieraRI.ratificacion);

                }
            }
        }
        callback(null, fields, errors);
    },

    oportunidadperdidacheck: function (fields, errors, callback) {
        var omitir = [];
        _.each(errors, function (value, key) {
            if ((key == 'amount' && this.model.get('amount') < 0) || (key == 'monto_c' && this.model.get('monto_c') < 0)) {
                omitir.push(key);
            }
        }, this);

        omitir.forEach(function (element) {
            delete errors[element];
        });

        if (Object.keys(errors).length == 0) {
            console.log(fields);
            console.log(errors);
            if (this.model.get('tct_oportunidad_perdida_chk_c') == true) {
                if (this.model.get('estatus_c') == 'K') {
                    app.alert.show("Cancela Operacion", {
                        level: "error",
                        title: "No puedes cancelar una operaci\u00F3n cancelada",
                        autoClose: false
                    });

                }
                else {
                    if (this.model.get('tct_razon_op_perdida_ddw_c') != "") {
                        if (this.model.get('tct_etapa_ddw_c') == "SI") {
                            this.model.set('estatus_c', 'K');

                            app.alert.show("CancelcacSol", {
                                level: "process",
                                title: "Se est\u00E1 cancelando la solicitud, por favor espera....",
                                autoClose: true
                            });
                        } else {
                            app.alert.show("EstatusCancelcacion", {
                                level: "process",
                                title: "Se est\u00E1 cancelando la solicitud, por favor espera....",
                                autoClose: false
                            });
                            // @author Carlos Zaragoza
                            // @task Cancelar la operacion solamente en Sugar si no tiene ID process.
                            console.log(typeof this.model.get("id_process_c"));
                            console.log(this.model.get("id_process_c"));
                            if (this.model.get("id_process_c") == "") {
                                var parametros = {
                                    'id_linea_padre': this.model.get('id_linea_credito_c'),
                                    'id': this.model.get('id'),
                                    'conProceso': 0,
                                    'tipo_de_operacion_c': this.model.get('tipo_de_operacion_c'),
                                    'tipo_operacion_c': this.model.get('tipo_operacion_c'),
                                };
                                var cancelarOperacionPadre = app.api.buildURL("CancelaRatificacion", '', {}, {});
                                app.api.call("create", cancelarOperacionPadre, { data: parametros }, {
                                    success: _.bind(function (data) {
                                        if (data != null) {
                                            console.log("Se cancelo padre1");
                                            this.model.set('estatus_c', 'K');
                                            this.model.save();
                                            self.render();
                                            app.alert.dismiss('EstatusCancelcacion');
                                        } else {
                                            console.log("No se cancela Padre");
                                        }
                                    }, self)
                                });
                                callback(null, fields, errors); //Pendiente
                            } else {
                                if (this.model.get('estatus_c') != 'K') {
                                    var Operacion = this;
                                    var OppParams = {
                                        'idSolicitud': this.model.get("idsolicitud_c"),
                                        'usuarioAutenticado': app.user.get('user_name'),
                                    };
                                    var cancelaOperacionUrl = app.api.buildURL("cancelaOperacionBPM", '', {}, {});
                                    app.api.call("create", cancelaOperacionUrl, { data: OppParams }, {
                                        success: _.bind(function (data) {
                                            if (data != null) {
                                                if (data['estatus'] == 'error') {
                                                    app.alert.show("Cancela Operacion", {
                                                        level: "error",
                                                        title: "Error: " + data['descripcion'],
                                                        autoClose: false
                                                    });
                                                    callback(null, fields, errors);
                                                } else {
                                                    app.alert.show("ExitoCancel", {
                                                        level: 'success',
                                                        title: 'Se ha cancelado la operaci\u00F3n',
                                                        autoClose: true
                                                    });
                                                    callback(null, fields, errors);
                                                }
                                            }
                                        }, self)
                                    });
                                    // mandamos llamar el servicio para cancelar localmente:
                                    var parametros = {
                                        'id_linea_padre': this.model.get('id_linea_credito_c'),
                                        'id': this.model.get('id'),
                                        'conProceso': 1,
                                        'tipo_de_operacion_c': this.model.get('tipo_de_operacion_c'),
                                        'tipo_operacion_c': this.model.get('tipo_operacion_c'),
                                    };
                                    console.log(parametros);
                                    var cancelarOperacionPadre = app.api.buildURL("CancelaRatificacion", '', {}, {});
                                    app.api.call("create", cancelarOperacionPadre, { data: parametros }, {
                                        success: _.bind(function (data) {
                                            if (data != null) {
                                                console.log("Se cancelo padre2");
                                                this.model.set('estatus_c', 'K');
                                                this.model.save();
                                                //window.location.reload()
                                                /*@Jesus Carrillo*/
                                                /*window.setTimeout(function () {
                                                    window.history.back();
                                                    app.alert.dismiss('EstatusCancelcacion');
                                                }, 25000);*/
                                                self.render();
                                                app.alert.dismiss('EstatusCancelcacion');
                                            } else {
                                                console.log("No se cancela Padre");
                                            }
                                        }, self)
                                    });
                                } else {
                                    app.alert.show("Operacion Cancelada", {
                                        level: "error",
                                        title: "Esta Operaci\u00F3n ya habia sido cancelada anteriormente",
                                        autoClose: false
                                    });
                                    callback(null, fields, errors);
                                }
                            }
                        }
                    }// fin if
                    else {
                        errors['tct_razon_op_perdida_ddw_c'] = 'Campo requerido para cancelar';
                        errors['tct_razon_op_perdida_ddw_c'].required = true;
                    }
                }
            }
        }
        callback(null, fields, errors);
    },

    calcularRI: function () {
        if (!_.isEmpty(this.model.get("amount")) && !_.isEmpty(this.model.get("porciento_ri_c")) && this.model.get("porciento_ri_c") != 0 && this.model.get("tipo_operacion_c") == 1) {
            var percent = (this.model.get("amount") * this.model.get("porciento_ri_c")) / 100;
            this.model.set("ca_importe_enganche_c", percent);
        }
    },

    calcularPorcientoRI: function () {

        if (!_.isEmpty(this.model.get("amount")) && !_.isEmpty(this.model.get("ca_importe_enganche_c")) && this.model.get("ca_importe_enganche_c") != 0 && this.model.get("tipo_operacion_c") == 1) {
            var percent = ((this.model.get("ca_importe_enganche_c") * 100) / this.model.get("amount")).toFixed(2);
            this.model.set("porciento_ri_c", percent);
        }
    },


    mensajes: function (descripcion, texto, nivel) {
        app.alert.show(descripcion, {
            level: nivel,
            messages: texto,
        });
    },
    //Funcion que evita el guardado de la oportunidad si esta tiene status Cancelada y el chk = TRUE
    _HideSaveButton: function () {
        if (this.model.get('tct_oportunidad_perdida_chk_c') && this.model.get('estatus_c') == 'K') {
            this.$(".record-edit-link-wrapper").attr('style', 'pointer-events:none');
            var editButton = self.getField('edit_button');
            editButton.setDisabled(true);
            $('[name="save_button"]').eq(0).hide();
        }
        //else {$('[name="save_button"]').eq(0).show();}
    },

    validamontos: function () {

        var montoop = parseFloat(this.model.get('amount'));
        var pagomensual = parseFloat(this.model.get('ca_pago_mensual_c'));
        var montolinea = parseFloat(this.model.get('monto_c'));
        var rentaini = parseFloat(this.model.get('ca_importe_enganche_c'));
        if (this.model.get('tct_etapa_ddw_c') == 'SI') {
            if (pagomensual > montoop) {
                app.alert.show('alerta_mayor_que1', {
                    level: 'warning',
                    messages: 'El Pago Mensual no puede ser mayor al Monto a Operar.',
                });
            }

            if (montoop > montolinea) {
                app.alert.show('alerta_mayor_que2', {
                    level: 'warning',
                    messages: 'El Monto a Operar no puede ser mayor al Monto de L\u00EDnea.',
                });
            }

            if (rentaini > montoop) {
                app.alert.show('alerta_mayor_que3', {
                    level: 'warning',
                    messages: 'El Pago Único no puede ser mayor al Monto a Operar.',
                });
            }
        }
    },

    validamontossave: function (fields, errors, callback) {

        var montoop = parseFloat(this.model.get('amount'));
        var pagomensual = parseFloat(this.model.get('ca_pago_mensual_c'));
        var montolinea = parseFloat(this.model.get('monto_c'));
        var rentaini = parseFloat(this.model.get('ca_importe_enganche_c'));
        if (this.model.get('tct_etapa_ddw_c') == 'SI') {
            if (pagomensual > montoop) {
                errors['ca_pago_mensual_c'] = 'El Pago Mensual no puede ser mayor al Monto a Operar.';
                errors['ca_pago_mensual_c'].required = true;
                app.alert.show('alerta_mayor_que1', {
                    level: 'error',
                    messages: 'El Pago Mensual no puede ser mayor al Monto a Operar.',
                });
            }

            if (montoop > montolinea) {
                errors['amount'] = 'El Monto a Operar no puede ser mayor al Monto de L\u00EDnea.';
                errors['amount'].required = true;
                app.alert.show('alerta_mayor_que2', {
                    level: 'error',
                    messages: 'El Monto a Operar no puede ser mayor al Monto de L\u00EDnea.',
                });
            }

            if (rentaini > montoop) {
                errors['ca_importe_enganche_c'] = 'pago_unico_mayor_monto_operar';
                errors['ca_importe_enganche_c'].required = true;
                app.alert.show('alerta_mayor_que3', {
                    level: 'error',
                    messages: 'El Pago Único no puede ser mayor al Monto a Operar.',
                });
            }
        }
        callback(null, fields, errors);
    },

    //@Jesus Carrillo
    //Funcion que valida que el campo vendedor no tenga caracteres especiales
    checkvendedor: function (evt) {
        if (!evt) return;
        var $input = this.$(evt.currentTarget);
        var expreg = /[a-zA-Z\u00F1\u00D1\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC\s]+/;
        //var expreg =/[A-Za-z]/;
        if ((expreg.test(evt.key)) == false) {
            app.alert.show('error_vendedor', {
                level: 'error',
                autoClose: true,
                messages: 'El campo \"Vendedor\" no acepta caracteres especiales. Favor de corregir'
            });
            return false;
        }
    },

    /*@Jesus Carrillo
  Metodos que limitan el tipo moneda a 15 entetos y 2 decimales
 */
    checkmoney: function (evt) {
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

    formatcoin: function (evt) {
        if (!evt) return;
        var $input = this.$(evt.currentTarget);
        while ($input.val().indexOf(',') != -1) {
            $input.val($input.val().replace(',', ''))
        }
    },

    //Funcion para delimitar porcentajes. Adrian Arauz 23/08/2018
    limitanumero: function (evt) {
        if (!evt) return;
        var $input = this.$(evt.currentTarget);
        if ($input.val().includes('.')) {
            var expreg = /[\d]+/;
        } else {
            var expreg = /[\d.]+/;
        }

        if ((expreg.test(evt.key)) == false && evt.key != "Backspace" && evt.key != "Tab") {
            app.alert.show('error_dinero', {
                level: 'error',
                autoClose: true,
                messages: 'El campo no acepta caracteres especiales.'
            });
            return false;
        } else {
            if ($input.val().includes('.')) {
                dec = $input.val().split('.');
                if (dec[1].length == 2 && evt.key != "Backspace" && evt.key != "Tab") {
                    return false;
                }
                return;
            } else {
                while ($input.val().indexOf(',') != -1) {
                    $input.val($input.val().replace(',', ''))
                }
                if ($input.val().length == 2 && evt.key != "Backspace" && evt.key != "Tab" && evt.key != ".") {
                    $input.val($input.val() + '.');
                    return;
                } else {
                    return;
                }
            }
        }
    },

    validaRequeridosFactoraje: function (fields, errors, callback) {
        if (this.model.get('tct_oportunidad_perdida_chk_c') == false) {
            //console.log(this.model.get('f_aforo_c'));
            //console.log(this.model.get('f_tipo_factoraje_c'));
            if (this.model.get('tipo_producto_c') == '4') {
                if (this.model.get('f_tipo_factoraje_c') == undefined || this.model.get('f_tipo_factoraje_c') == "") {
                    //error
                    errors['f_tipo_factoraje_c'] = errors['f_tipo_factoraje_c'] || {};
                    errors['f_tipo_factoraje_c'].required = true;
                }
                if (this.model.get('tipo_tasa_ordinario_c') == '1') {
                    if (this.model.get('tasa_fija_ordinario_c') == undefined || this.model.get('tasa_fija_ordinario_c') == "") {
                        //error
                        errors['tasa_fija_ordinario_c'] = errors['tasa_fija_ordinario_c'] || {};
                        errors['tasa_fija_ordinario_c'].required = true;
                    }
                }

                if (this.model.get('tipo_tasa_ordinario_c') == undefined || this.model.get('tipo_tasa_ordinario_c') == "") {
                    //error
                    errors['tipo_tasa_ordinario_c'] = errors['tipo_tasa_ordinario_c'] || {};
                    errors['tipo_tasa_ordinario_c'].required = true;
                }
                if (this.model.get('instrumento_c') == undefined || this.model.get('instrumento_c') == "") {
                    //error
                    errors['instrumento_c'] = errors['instrumento_c'] || {};
                    errors['instrumento_c'].required = true;
                }
                if (this.model.get('puntos_sobre_tasa_c') == "" || (Number(this.model.get('puntos_sobre_tasa_c')) < 0 || Number(this.model.get('puntos_sobre_tasa_c')) > 99.999999)) {
                    //error
                    errors['puntos_sobre_tasa_c'] = "Este campo solo permite valor m\u00E1ximo de 99.00.";
                    //errors['puntos_sobre_tasa_c'].required = true;
                }
                if (this.model.get('f_aforo_c') == "" || (Number(this.model.get('f_aforo_c')) < 0 || Number(this.model.get('f_aforo_c')) > 99.99)) {
                    //error
                    errors['f_aforo_c'] = "Este campo solo permite valor m\u00E1ximo de 99.00.";
                    errors['f_aforo_c'].required = true;

                }
                if (this.model.get('porcentaje_ca_c') == "" || (Number(this.model.get('porcentaje_ca_c')) < 0 || Number(this.model.get('porcentaje_ca_c')) > 99.99)) {
                    //error
                    errors['porcentaje_ca_c'] = "Este campo solo permite valor m\u00E1ximo de 99.00.";
                    // errors['porcentaje_ca_c'].required = true;

                }
                if (this.model.get('tipo_tasa_moratorio_c') == undefined || this.model.get('tipo_tasa_moratorio_c') == "") {
                    //error
                    errors['tipo_tasa_moratorio_c'] = errors['tipo_tasa_moratorio_c'] || {};
                    errors['tipo_tasa_moratorio_c'].required = true;
                }

                if (this.model.get('instrumento_moratorio_c') == undefined || this.model.get('instrumento_moratorio_c') == "") {
                    //error
                    errors['instrumento_moratorio_c'] = errors['instrumento_moratorio_c'] || {};
                    errors['instrumento_moratorio_c'].required = true;
                }
                if (this.model.get('puntos_tasa_moratorio_c') == "" || this.model.get('puntos_tasa_moratorio_c') == null || (Number(this.model.get('puntos_tasa_moratorio_c')) < 0 || Number(this.model.get('puntos_tasa_moratorio_c')) > 99.999999)) {
                    //error
                    errors['puntos_tasa_moratorio_c'] = "Este campo solo permite valor m\u00E1ximo de 99.00.";
                    errors['puntos_tasa_moratorio_c'].required = true;
                }
                if (this.model.get('factor_moratorio_c') == "" || this.model.get('factor_moratorio_c') == null || (Number(this.model.get('factor_moratorio_c')) < 0 || Number(this.model.get('factor_moratorio_c')) > 99.999999)) {
                    //error
                    errors['factor_moratorio_c'] = "Este campo solo permite valor m\u00E1ximo de 99.00.";
                    errors['factor_moratorio_c'].required = true;
                }

                if (this.model.get('tipo_tasa_moratorio_c') == '1') {
                    if (this.model.get('tasa_fija_moratorio_c') == null || this.model.get('tasa_fija_moratorio_c') == "" || (Number(this.model.get('tasa_fija_moratorio_c')) < 0 || Number(this.model.get('tasa_fija_moratorio_c')) > 99.999999)) {
                        //error
                        errors['tasa_fija_moratorio_c'] = "Este campo solo permite valor m\u00E1ximo de 99.00.";
                        //errors['tasa_fija_moratorio_c'].required = true;
                    }
                }
            }
        }
        callback(null, fields, errors);
    },

    /*@Jesus Carrillo
     Funcion que valida que la cuenta de la presolicitud tenga una direccion con indicador "correspondencia" y"fiscal"
     */
    valida_direc_indicador: function (fields, errors, callback) {
        if (this.model.get('tct_oportunidad_perdida_chk_c') == false) {

            self = this;
            var fiscal = 0;
            var correspondecia = 0;
            app.api.call('GET', app.api.buildURL('Accounts/' + this.model.get('account_id') + '/link/accounts_dire_direccion_1'), null, {
                success: _.bind(function (data) {

                    console.log(data);

                    for (var i = 0; i < data.records.length; i++) {

                        if (data.records[i].indicador != "" && data.records[i].inactivo == false) {

                            var array_indicador = this._getIndicador(data.records[i].indicador);

                            for (var j = 0; j < array_indicador.length; j++) {
                                if (array_indicador[j] == '1') {
                                    correspondecia++;
                                }
                                if (array_indicador[j] == '2') {
                                    fiscal++;
                                }
                            }
                        }
                    }
                    if (correspondecia == 0) {
                        app.alert.show('indicador_fail', {
                            level: 'error',
                            messages: 'La cuenta necesita tener al menos un tipo de direcci\u00F3n <b>Correspondencia</b> en direcciones',
                        });
                        errors['indicador_1'] = errors['indicador_1'] || {};
                        errors['indicador_1'].required = true;

                    }
                    if (fiscal == 0) {
                        app.alert.show('indicador_fail2', {
                            level: 'error',
                            messages: 'La cuenta necesita tener al menos un tipo de direcci\u00F3n <b>Fiscal</b> en direcciones',
                        });
                        errors['indicador_2'] = errors['indicador_2'] || {};
                        errors['indicador_2'].required = true;

                    }
                    callback(null, fields, errors);
                }, self),
            });

        }
        else {
            callback(null, fields, errors);
        }
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
            console.log('Resultado de idSelected:');
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
            console.log('Resultado de valueSelected:');
            console.log(result);
        }

        return result;
    },

    disable_panels_team: function () {

        self = this;

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
                        /*
                        if (data == false) {

                            $('.noEdit.fieldset.actions.detail.btn-group').hide();

                            $('i').removeClass('fa-pencil');

                            $('.record-cell').children().not('.normal.index').click(function (e) { //Habilita solo links
                                e.stopPropagation();
                                e.preventDefault();
                                e.stopImmediatePropagation();
                                return false;
                            });
                        }
                        */
                        return data;
                    }, self),
                });
                self.render();
            }
        }
    },

    valida_requeridos: function (fields, errors, callback) {
        var campos = "";
        var omitir = [];
        _.each(errors, function (value, key) {
            if ((key == 'amount' && this.model.get('amount') < 0) || (key == 'monto_c' && this.model.get('monto_c') < 0)) {
                omitir.push(key);
            }
            else {
                _.each(this.model.fields, function (field) {
                    if (_.isEqual(field.name, key)) {
                        if (field.vname) {
                            campos = campos + '<b>' + app.lang.get(field.vname, "Opportunities") + '</b><br>';
                        }
                    }
                }, this);
            }
        }, this);

        omitir.forEach(function (element) {
            delete errors[element];
        });

        if (campos) {
            //Remplaza etiquetas para producto Leasing: Renta incial
            if (this.model.get('tipo_producto_c') == '1') {
                campos = campos.replace(/Renta Inicial/gi, "Pago Único");
            }

            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información en la <b>Solicitud:</b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    validapagounico: function (fields, errors, callback) {
        if (this.model.get('porciento_ri_c') != "" && this.model.get('porciento_ri_c') != undefined && (Number(this.model.get('porciento_ri_c')) <= 0 || Number(this.model.get('porciento_ri_c')) > 100.00)) {

            if (parseFloat(this.model.get('porciento_ri_c')) <= 0.0000) {
                errors['porciento_ri_c'] = errors['porciento_ri_c'] || {};
                errors['porciento_ri_c'].required = true;

                app.alert.show("Unico_mayor_a_cero", {
                    level: "error",
                    messages: "El campo <b>% Pago Único</b> debe ser mayor a cero.",
                    autoClose: false
                });
            }
            // Valida valor mayor a 100
            if (parseFloat(this.model.get('porciento_ri_c')) > 100.00) {

                errors['porciento_ri_c'] = errors['porciento_ri_c'] || {};
                errors['porciento_ri_c'].required = true;

                app.alert.show("Iva_menor_a_cero", {
                    level: "error",
                    messages: "El campo <b>% Pago Único</b> debe ser menor o igual a cien.",
                    autoClose: false
                });
            }

        }
        callback(null, fields, errors);
    },

    _Validavehiculo: function (fields, errors, callback) {
        if (this.model.get('tct_numero_vehiculos_c') <= 0 && this.model.get('tipo_producto_c') == "6") {
            errors['tct_numero_vehiculos_c'] = errors['tct_numero_vehiculos_c'] || {};
            errors['tct_numero_vehiculos_c'].required = true;

            app.alert.show("Numero de Vehiculos", {
                level: "error",
                messages: "El Número de vehículos debe ser mayor a cero.",
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    getcf: function () {
        //Extiende This
        //Condificiones financieras
        this.oFinanciera = [];
        this.oFinanciera.condicion = [];
        this.prev_oFinanciera = [];
        this.prev_oFinanciera.prev_condicion = [];
        var api_params = {
            'max_num': 99,
            //'order_by': 'date_entered:desc',
            //Ajuste generado por Salvador Lopez <salvador.lopez@tactos.com.mx>
            'order_by': 'idactivo:ASC,plazo:ASC',
            'filter': [
                {
                    'lev_condicionesfinancieras_opportunitiesopportunities_ida': this.model.id,
                    'incremento_ratificacion': 0
                }
            ]
        };
        var pull_condicionFinanciera_url = app.api.buildURL('lev_CondicionesFinancieras',
            null, null, api_params);

        try {
            app.api.call('READ', pull_condicionFinanciera_url, {}, {
                success: function (data) {
                    for (var i = 0; i < data.records.length; i++) {
                        //Setea valores al objeto para su visualización en el edit.hbs
                        var valor1 = data.records[i].id;
                        var idActivo = data.records[i].idactivo;
                        var idplazo = data.records[i].plazo;
                        var tasa_minima = data.records[i].tasa_minima;
                        var tasa_maxima = data.records[i].tasa_maxima;
                        var vrc_minimo = data.records[i].vrc_minimo;
                        var vrc_maximo = data.records[i].vrc_maximo;
                        var vri_minimo = data.records[i].vri_minimo;
                        var vri_maximo = data.records[i].vri_maximo;
                        var comision_minima = data.records[i].comision_minima;
                        var comision_maxima = data.records[i].comision_maxima;
                        var renta_inicial_minima = data.records[i].renta_inicial_minima;
                        var renta_inicial_maxima = data.records[i].renta_inicial_maxima;
                        var deposito_en_garantia = data.records[i].deposito_en_garantia;
                        var uso_particular = data.records[i].uso_particular;
                        var uso_empresarial = data.records[i].uso_empresarial;
                        var activo_nuevo = data.records[i].activo_nuevo;

                        //Crea obj
                        var condfin = {
                            "id": valor1,
                            "idactivo": idActivo,
                            "plazo": idplazo,
                            "tasa_minima": tasa_minima,
                            "tasa_maxima": tasa_maxima,
                            "vrc_minimo": vrc_minimo,
                            "vrc_maximo": vrc_maximo,
                            "vri_minimo": vri_minimo,
                            "vri_maximo": vri_maximo,
                            "comision_minima": comision_minima,
                            "comision_maxima": comision_maxima,
                            "renta_inicial_minima": renta_inicial_minima,
                            "renta_inicial_maxima": renta_inicial_maxima,
                            "deposito_en_garantia": deposito_en_garantia,
                            "uso_particular": uso_particular,
                            "uso_empresarial": uso_empresarial,
                            "activo_nuevo": activo_nuevo
                        };
                        var prev_condfin = {
                            "id": valor1,
                            "idactivo": idActivo,
                            "plazo": idplazo,
                            "tasa_minima": tasa_minima,
                            "tasa_maxima": tasa_maxima,
                            "vrc_minimo": vrc_minimo,
                            "vrc_maximo": vrc_maximo,
                            "vri_minimo": vri_minimo,
                            "vri_maximo": vri_maximo,
                            "comision_minima": comision_minima,
                            "comision_maxima": comision_maxima,
                            "renta_inicial_minima": renta_inicial_minima,
                            "renta_inicial_maxima": renta_inicial_maxima,
                            "deposito_en_garantia": deposito_en_garantia,
                            "uso_particular": uso_particular,
                            "uso_empresarial": uso_empresarial,
                            "activo_nuevo": activo_nuevo
                        };
                        //Genera objeto con valores previos para control de cancelar
                        solicitud_cf.oFinanciera.condicion.push(condfin);
                        solicitud_cf.prev_oFinanciera.prev_condicion.push(prev_condfin);
                    }

                    //set model so tpl detail tpl can read data
                    //solicitud_cf.model.set('condiciones_financieras', data.records);

                    cont_cf.oFinanciera = solicitud_cf.oFinanciera;
                    cont_cf.render();
                }
            });
        }
        catch (err) {
            console.log(err);
        }
        //Obtener las condiciones iniciales
        var api_params_cond_iniciales = {
            'max_num': 500,
        };
        var pull_condiciones_iniciales_url = app.api.buildURL('UNI_condiciones_iniciales',
            null, null, api_params_cond_iniciales);

        app.api.call('READ', pull_condiciones_iniciales_url, {}, {
            success: function (data) {
                cont_cf.condiciones_iniciales = {};
                if (!_.isEmpty(data.records)) {
                    cont_cf.condiciones_iniciales = data.records;
                    var activos = App.lang.getAppListStrings('idactivo_list');
                    var plazos = App.lang.getAppListStrings('plazo_0');
                    //Se crea contexto vacío
                    cont_cf.activos = [];

                    //Se crea array que contendrá los valores de los campos de la CF
                    var condicionFinanciera = {
                        "tasa_minima": "",
                        "tasa_maxima": "",
                        "vrc_minimo": "",
                        "vrc_maximo": "",
                        "vri_minimo": "",
                        "vri_maximo": "",
                        "comision_minima": "",
                        "comision_maxima": "",
                        "renta_inicial_minima": "",
                        "renta_inicial_maxima": "",
                        "deposito_en_garantia": "",
                        "uso_particular": "",
                        "uso_empresarial": "",
                        "activo_nuevo": ""
                    };

                    //Se iteran las listas para generar los arrays y se guardan en el contexto creado cont_cf.activos
                    for (var i = 0; i < data.records.length; i++) {
                        cont_cf.activos[data.records[i].activo] = [];
                        for (index in plazos) {
                            cont_cf.activos[data.records[i].activo][index] = [];
                            cont_cf.activos[data.records[i].activo][index] = app.utils.deepCopy(condicionFinanciera);
                        }
                    }
                    for (id in activos) {
                        cont_cf.activos[id] = [];
                        for (index in plazos) {
                            cont_cf.activos[id][index] = [];
                            cont_cf.activos[id][index] = app.utils.deepCopy(condicionFinanciera);
                        }
                    }

                    //Se llena la estructura con los datos del data.records
                    for (var i = 0; i < data.records.length; i++) {
                        //Tasa minima
                        if (data.records[i].campo_destino_minimo == 'new_tasa_minima') {
                            cont_cf.activos[data.records[i].activo][data.records[i].plazo].tasa_minima = data.records[i].rango_minimo;
                            cont_cf.activos[data.records[i].activo][data.records[i].plazo].tasa_maxima = data.records[i].rango_maximo;
                        }
                        //VRC
                        if (data.records[i].campo_destino_minimo == 'new_vrc_minimo') {
                            cont_cf.activos[data.records[i].activo][data.records[i].plazo].vrc_minimo = data.records[i].rango_minimo;
                            cont_cf.activos[data.records[i].activo][data.records[i].plazo].vrc_maximo = data.records[i].rango_maximo;
                        }
                        //VRI
                        if (data.records[i].campo_destino_minimo == 'new_vri_minimo') {
                            cont_cf.activos[data.records[i].activo][data.records[i].plazo].vri_minimo = data.records[i].rango_minimo;
                            cont_cf.activos[data.records[i].activo][data.records[i].plazo].vri_maximo = data.records[i].rango_maximo;
                        }
                        //Comision
                        if (data.records[i].campo_destino_minimo == 'new_comision_minima') {
                            cont_cf.activos[data.records[i].activo][data.records[i].plazo].comision_minima = data.records[i].rango_minimo;
                            cont_cf.activos[data.records[i].activo][data.records[i].plazo].comision_maxima = data.records[i].rango_maximo;
                        }
                        //Pago Único
                        if (data.records[i].campo_destino_minimo == 'new_renta_inicial_minima') {
                            cont_cf.activos[data.records[i].activo][data.records[i].plazo].renta_inicial_minima = data.records[i].rango_minimo;
                            cont_cf.activos[data.records[i].activo][data.records[i].plazo].renta_inicial_maxima = data.records[i].rango_maximo;
                        }
                        //Deposito en Garantia
                        if (data.records[i].campo_destino_minimo == 'new_deposito_en_garantia') {
                            cont_cf.activos[data.records[i].activo][data.records[i].plazo].deposito_en_garantia = data.records[i].rango_minimo;
                        }
                    }
                    cont_cf.render();
                }
            }
        });
    },

    handleCancel: function () {
        this._super("handleCancel");
        //Condiciones_financieras
        var condiciones_financieras = app.utils.deepCopy(this.prev_oFinanciera.prev_condicion);
        this.model.set('condiciones_financieras', condiciones_financieras);
        this.oFinanciera.condicion = condiciones_financieras;
        cont_cf.render();

        //Condiciones_financieras Ratificacion e Incremento
        var condiciones_financierasRI = app.utils.deepCopy(this.prev_oFinancieraRI.prev_ratificacion);
        this.model.set('condiciones_financieras_incremento_ratificacion', condiciones_financierasRI);
        this.oFinancieraRI.ratificacion = condiciones_financierasRI;
        contRI.render();
    },

    getcfRI: function () {

        //Condificiones financieras RI
        this.oFinancieraRI = [];
        this.oFinancieraRI.ratificacion = [];
        this.prev_oFinancieraRI = [];
        this.prev_oFinancieraRI.prev_ratificacion = [];

        if (cont_RI.model.get('ratificacion_incremento_c') == true) {


            var api_params = {
                'max_num': 99,

                //Ajuste generado por Salvador Lopez <salvador.lopez@tactos.com.mx>
                //Cambio de orden
                'order_by': 'idactivo:ASC,plazo:ASC',
                'filter': [
                    {
                        'lev_condicionesfinancieras_opportunitiesopportunities_ida': this.model.id,
                        'incremento_ratificacion': 1
                    }
                ]
            };

            var pull_condicionFinanciera_url = app.api.buildURL('lev_CondicionesFinancieras',
                null, null, api_params);

            try {
                app.api.call('READ', pull_condicionFinanciera_url, {}, {
                    success: function (data) {

                        var activo_list = app.lang.getAppListStrings('idactivo_list');
                        for (var i = 0; i < data.records.length; i++) {
                            //Setea valores al objeto para su visualización en el edit.hbs
                            var valor1 = data.records[i].id;
                            var idActivo = data.records[i].idactivo;
                            var idplazo = data.records[i].plazo;
                            var tasa_minima = data.records[i].tasa_minima;
                            var tasa_maxima = data.records[i].tasa_maxima;
                            var vrc_minimo = data.records[i].vrc_minimo;
                            var vrc_maximo = data.records[i].vrc_maximo;
                            var vri_minimo = data.records[i].vri_minimo;
                            var vri_maximo = data.records[i].vri_maximo;
                            var comision_minima = data.records[i].comision_minima;
                            var comision_maxima = data.records[i].comision_maxima;
                            var renta_inicial_minima = data.records[i].renta_inicial_minima;
                            var renta_inicial_maxima = data.records[i].renta_inicial_maxima;
                            var deposito_en_garantia = data.records[i].deposito_en_garantia;
                            var uso_particular = data.records[i].uso_particular;
                            var uso_empresarial = data.records[i].uso_empresarial;
                            var activo_nuevo = data.records[i].activo_nuevo;

                            //Crea obj
                            var condfinRI = {
                                "id": valor1,
                                "idactivo": idActivo,
                                "plazo": idplazo,
                                "tasa_minima": tasa_minima,
                                "tasa_maxima": tasa_maxima,
                                "vrc_minimo": vrc_minimo,
                                "vrc_maximo": vrc_maximo,
                                "vri_minimo": vri_minimo,
                                "vri_maximo": vri_maximo,
                                "comision_minima": comision_minima,
                                "comision_maxima": comision_maxima,
                                "renta_inicial_minima": renta_inicial_minima,
                                "renta_inicial_maxima": renta_inicial_maxima,
                                "deposito_en_garantia": deposito_en_garantia,
                                "uso_particular": uso_particular,
                                "uso_empresarial": uso_empresarial,
                                "activo_nuevo": activo_nuevo
                            };
                            var prev_condfinRI = {
                                "id": valor1,
                                "idactivo": idActivo,
                                "plazo": idplazo,
                                "tasa_minima": tasa_minima,
                                "tasa_maxima": tasa_maxima,
                                "vrc_minimo": vrc_minimo,
                                "vrc_maximo": vrc_maximo,
                                "vri_minimo": vri_minimo,
                                "vri_maximo": vri_maximo,
                                "comision_minima": comision_minima,
                                "comision_maxima": comision_maxima,
                                "renta_inicial_minima": renta_inicial_minima,
                                "renta_inicial_maxima": renta_inicial_maxima,
                                "deposito_en_garantia": deposito_en_garantia,
                                "uso_particular": uso_particular,
                                "uso_empresarial": uso_empresarial,
                                "activo_nuevo": activo_nuevo
                            };
                            //Genera objeto con valores previos para control de cancelar
                            cont_RI.oFinancieraRI.ratificacion.push(condfinRI);
                            cont_RI.prev_oFinancieraRI.prev_ratificacion.push(prev_condfinRI);
                        }
                        contRI.oFinancieraRI = cont_RI.oFinancieraRI;
                        contRI.render();
                    }
                });
            }
            catch (err) {
                console.log(err);
                // self.model.set('condiciones_financieras_incremento_ratificacion', data.records);
                // self.model._previousAttributes.condiciones_financieras_incremento_ratificacion = data.records;
                // self.model._syncedAttributes.condiciones_financieras_incremento_ratificacion = data.records;
                // self._render();
            }

        }
    },

    validaetiquetas: function () {
        //Actualiza las etiquetas de acuerdo al tipo de operacion Solicitud/Cotizacion
        //Si la operacion es Cotización o Contrato cambiar etiqueta de "Monto de línea" a "Monto colocación"
        if (this.model.get('tipo_operacion_c') == '3' || this.model.get('tipo_operacion_c') == '4') {
            this.$("div.record-label[data-name='monto_c']").text("Monto colocaci\u00F3n");
            this.$("div.record-label[data-name='tipo_de_operacion_c']").text("Tipo de operaci\u00F3n");
        } else {
            this.$("div.record-label[data-name='monto_c']").text("Monto de l\u00EDnea");
            this.$("div.record-label[data-name='tipo_de_operacion_c']").text("Tipo de solicitud");
        }
        if (this.model.get('tipo_operacion_c') == '2') {
            this.$("div.record-label[data-name='amount']").text("Monto Disponible");
        }

        if ((this.model.get('tipo_operacion_c') == '1' || this.model.get('tipo_producto_c') == '9') && this.model.get('tipo_de_operacion_c') == 'RATIFICACION_INCREMENTO') {
            this.$("div.record-label[data-name='monto_c']").text("Monto del incremento");
        }
        if (this.model.get('tipo_producto_c') == '1' || this.model.get('tipo_producto_c') == '9') {
            this.$("div.record-label[data-name='ca_importe_enganche_c']").text("Pago Único");
            this.$("div.record-label[data-name='porciento_ri_c']").text("% Pago Único");
        } else {
            this.$("div.record-label[data-name='ca_importe_enganche_c']").text("Enganche");

        }
        if (this.model.get('tipo_producto_c') == '4') {
            this.$("div.record-label[data-name='ri_porcentaje_ca_c']").text("Comisi\u00F3n Incremento/Ratificaci\u00F3n");
            this.$("div.record-label[data-name='plazo_c']").text("Plazo m\u00E1ximo en d\u00EDas");
        } else {
            this.$("div.record-label[data-name='ri_porcentaje_ca_c']").text("Comisi\u00F3n por apertura Incremento/Ratificaci\u00F3n");
            this.$("div.record-label[data-name='plazo_c']").text("Plazo en meses");

        }
        if (this.model.get('tipo_producto_c') == '3') {
            this.$("div.record-label[data-name='ri_porcentaje_renta_inicial_c']").text("% Enganche Incremento/Ratificaci\u00F3n");
            this.$("div.record-label[data-name='porcentaje_renta_inicial_c']").text("Porcentaje de Enganche");
        } else {
            this.$("div.record-label[data-name='ri_porcentaje_renta_inicial_c']").text("% Renta Inicial Incremento/Ratificaci\u00F3n");
            this.$("div.record-label[data-name='porcentaje_renta_inicial_c']").text("Porcentaje Renta Inicial");
        }

        //Se agrega condición para ocultar campo que no pertenecen a Fleet
        if (this.model.get('tipo_producto_c') == '6' || this.model.get('tipo_producto_c') == '7') {

            //this.$("div.record-label[data-name='monto_c']").text("L\u00EDnea aproximada");
            //Se oculta Monto a Operar
            this.$('[data-name="amount"]').hide();
            //Pago mensual
            this.$('[data-name="ca_pago_mensual_c"]').hide();
            //% Renta inicial
            this.$('[data-name="porciento_ri_c"]').hide();

        }
        //Valida la solicitud que sea de tipo SOS y oculta campos
        if (this.model.get('tipo_producto_c') == '7') {
            this.$('div[data-name=condiciones_financieras]').hide();
            this.$('div[data-name=f_comentarios_generales_c]').hide();
            this.$('div[data-name="condiciones_financieras_incremento_ratificacion"]').hide();
            this.$("[data-name='monto_ratificacion_increment_c']").attr('style', 'pointer-events:none');
        }

        //Se habilitan acciones existentes en render
        //no Muestra el subpanel de Oportunidad perdida cuando se cumple la condición
        if (this.model.get('tct_etapa_ddw_c') == 'SI' || this.model.get('tct_etapa_ddw_c') == 'P') {
            //no hace nada y muestra el panel
        } else {
            this.$('div[data-panelname=LBL_RECORDVIEW_PANEL1]').hide();
        }

        if (this.model.get('tipo_operacion_c') == '2') {
            this.$('div[data-name=plazo_ratificado_incremento_c]').show();
        } else {
            this.$('div[data-name=plazo_ratificado_incremento_c]').hide();
        }

        if (this.model.get('tipo_operacion_c') != '3') {
            //* Quitamos los campos Vendedor y Comisión
            this.$('div[data-name=opportunities_ag_vendedores_1_name]').hide();
            this.$('div[data-name=comision_c]').hide();
        }

        if (this.model.get('ratificacion_incremento_c') == false) {
            //Oculta campos para condiciones financieras
            this.$('div[data-name=plazo_ratificado_incremento_c]').hide();
            this.$('div[data-name=ri_usuario_bo_c]').hide();
        } else {
            //Prende los campos
            this.$('div[data-name=plazo_ratificado_incremento_c]').show();
            this.$('div[data-name=ri_usuario_bo_c]').show();
        }
    },

    ConficionFinancieraFormat: function (fields, errors, callback) {
        if (solicitud_cf.oFinanciera != undefined) {
            if (solicitud_cf.oFinanciera.condicion.length > 0) {
                //Valida formato de los campos del objeto oFinanciera.condicion. Deben cumplir con la expreg
                var formato = 0;
                for (var i = 0; i < solicitud_cf.oFinanciera.condicion.length; i++) {
                    var exp = /(^100([.]0{1,2})?)$|(^\d{1,2}([.]\d{1,2})?)$|(^([.]\d{1,2})?)$/;

                    if (!exp.test(solicitud_cf.oFinanciera.condicion[i].tasa_minima)) {
                        formato++;
                    }
                    if (!exp.test(solicitud_cf.oFinanciera.condicion[i].tasa_maxima)) {
                        formato++;
                    }
                    if (!exp.test(solicitud_cf.oFinanciera.condicion[i].vrc_minimo)) {
                        formato++;
                    }
                    if (!exp.test(solicitud_cf.oFinanciera.condicion[i].vrc_maximo)) {
                        formato++;
                    }
                    if (!exp.test(solicitud_cf.oFinanciera.condicion[i].vri_minimo)) {
                        formato++;
                    }
                    if (!exp.test(solicitud_cf.oFinanciera.condicion[i].vri_maximo)) {
                        formato++;
                    }
                    if (!exp.test(solicitud_cf.oFinanciera.condicion[i].comision_minima)) {
                        formato++;
                    }
                    if (!exp.test(solicitud_cf.oFinanciera.condicion[i].comision_maxima)) {
                        formato++;
                    }
                    if (!exp.test(solicitud_cf.oFinanciera.condicion[i].renta_inicial_minima)) {
                        formato++;
                    }
                    if (!exp.test(solicitud_cf.oFinanciera.condicion[i].renta_inicial_maxima)) {
                        formato++;
                    }
                    if (formato > 0) {
                        app.alert.show("CondicionFinanciera_formato", {
                            level: "error",
                            title: "Alguno de los campos de la Condición Financiera no cumple con el formato.<br>Sólo números son permitidos.",
                            autoClose: false
                        });
                        errors['formato_CF'] = errors['formato_CF'] || {};
                        errors['formato_CF'].required = true;
                    }
                }
            }
        }
        callback(null, fields, errors);
    },

    ConficionFinancieraRIFormat: function (fields, errors, callback) {
        if (contRI.oFinancieraRI != undefined) {
            if (contRI.oFinancieraRI.ratificacion.length > 0) {
                //Valida formato de los campos del objeto oFinancieraRI.ratificacion. Deben cumplir con la expreg
                var formato = 0;
                for (var i = 0; i < contRI.oFinancieraRI.ratificacion.length; i++) {
                    var exp = /(^100([.]0{1,2})?)$|(^\d{1,2}([.]\d{1,2})?)$|(^([.]\d{1,2})?)$/;

                    if (!exp.test(contRI.oFinancieraRI.ratificacion[i].tasa_minima)) {
                        formato++;
                    }
                    if (!exp.test(contRI.oFinancieraRI.ratificacion[i].tasa_maxima)) {
                        formato++;
                    }
                    if (!exp.test(contRI.oFinancieraRI.ratificacion[i].vrc_minimo)) {
                        formato++;
                    }
                    if (!exp.test(contRI.oFinancieraRI.ratificacion[i].vrc_maximo)) {
                        formato++;
                    }
                    if (!exp.test(contRI.oFinancieraRI.ratificacion[i].vri_minimo)) {
                        formato++;
                    }
                    if (!exp.test(contRI.oFinancieraRI.ratificacion[i].vri_maximo)) {
                        formato++;
                    }
                    if (!exp.test(contRI.oFinancieraRI.ratificacion[i].comision_minima)) {
                        formato++;
                    }
                    if (!exp.test(contRI.oFinancieraRI.ratificacion[i].comision_maxima)) {
                        formato++;
                    }
                    if (!exp.test(contRI.oFinancieraRI.ratificacion[i].renta_inicial_minima)) {
                        formato++;
                    }
                    if (!exp.test(contRI.oFinancieraRI.ratificacion[i].renta_inicial_maxima)) {
                        formato++;
                    }
                    if (formato > 0) {
                        app.alert.show("CondicionFinanciera_formato", {
                            level: "error",
                            title: "Alguno de los campos de la Ratificación e Incremento no cumple con el formato.<br>Sólo números son permitidos.",
                            autoClose: false
                        });
                        errors['formato_RI'] = errors['formato_RI'] || {};
                        errors['formato_RI'].required = true;
                    }
                }
            }
        }
        callback(null, fields, errors);
    },

    alertGpoEmpresarial: function (fields, errors, callback) {

        var idCuenta = this.model.get('account_id');

        if (idCuenta != '' && idCuenta != undefined){

            // console.log("Id de la cuenta "+idCuenta);
            var checkRI = this.model.get('ratificacion_incremento_c');

            self = this;
            app.api.call('GET', app.api.buildURL('GetMontoGpoEmpApi/' + idCuenta), null, {
                success: function (data) {
                    montoTotalGpoEmp = data['montoTotalGpoEmp'];
                    numCuentasGpoEmp = data['numCuentasGpoEmp'];
                    
                    if (self.model.get('estatus_c') != 'N' && checkRI != true){

                        montoTotalGpoEmp = parseInt(montoTotalGpoEmp) + parseInt(self.model.get('monto_c'));

                    } else if (self.model.get('estatus_c') == 'N' && checkRI == true){

                        montoTotalGpoEmp = parseInt(montoTotalGpoEmp) + parseInt(self.model.get('monto_ratificacion_increment_c'));

                    }

                    if (montoTotalGpoEmp != '' && montoTotalGpoEmp != null && montoTotalGpoEmp != 0 && numCuentasGpoEmp > 1) {
                        //Setea el monto total de grupo empresarial en el campo monto_gpo_emp_c
                        console.log("montoTotalGpoEmp " + montoTotalGpoEmp);
                        self.model.set('monto_gpo_emp_c', montoTotalGpoEmp);
                        //Mensaje del monto total de grupo empresarial cuando el check R/I se Activa
                        if (checkRI == true) {

                            app.alert.dismiss('Moto Modificado');
                            app.alert.show('message-gpo-emp', {
                                level: 'info',
                                title: 'El disponible del grupo empresarial al que perteneces, después de autorizar esta solicitud de Incremento será de $' + montoTotalGpoEmp.formatMoney(2, '.', ','),
                                autoClose: false
                            });
                        }
                    } 

                    callback(null, fields, errors);
                },
                error: function (e) {
                    throw e;
                    callback(null, fields, errors);
                }
            });

        } else {
            callback(null, fields, errors);
        }
    },

})
