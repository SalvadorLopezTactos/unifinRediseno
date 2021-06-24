({
    extendsFrom: 'RecordView',   

    initialize: function (options) {
        self = this;
        contexto_cuenta = this;
        
		this._super("initialize", [options]);
        this.model.on('sync', this.hideShowCancelar, this);
		this.model.on('sync', this.hideShowUniclick, this);

		this.context.on('button:aceptar_vta_cruzada:click', this.aceptar_vta_cruzada, this);
		this.context.on('button:cancelar_vta_cruzada:click', this.rechazar_vta_cruzada, this);
		//Acción de botón para que únicamente Alejandro de la Vega pueda establecer como Válida
		this.context.on('button:establece_ref_valida:click', this.establece_ref_valida, this);

    },
	
	_renderHtml: function(){      
		var self = this;  
		self.noEditFields.push('estatus');
		self.noEditFields.push('producto_referenciado');
		self.noEditFields.push('producto_origen');
		self.noEditFields.push('numero_anexos');
		self.noEditFields.push('primer_fecha_anexo');
		self.noEditFields.push('ultima_fecha_anexo');
		self.noEditFields.push('usuario_rechazo');
		
		this.model.on("change:cancelado", _.bind(this.set_usuariorechazado, this));
		this.model.addValidationTask('check_Requeridos', _.bind(this.valida_requeridos, this));

		this._super('_renderHtml')
	},
    
	_dispose: function(){  
		this._super('_dispose');  
	},

	_render: function (options) {
        this._super("_render");
        $('span[data-fieldname="cancelado"]').find('input').attr('disabled','');
        $('[data-name="cancelado"]').attr('style',"pointer-events:none");
		
		$('span[data-fieldname="usuario_rechazo"]').find('input').attr('disabled','');
		$('[data-name="usuario_rechazo"]').attr('style',"pointer-events:none");
		
		//Ocultando campo de control que valida si Alejandro de la Vega ha Validado la referencia
		$('[data-name="ref_validada_av_c"]').hide();
    },

    hideShowCancelar:function(){
		var puedeCancelar=App.user.get('tct_cancelar_ref_cruzada_chk_c');
		var productoUsuario=App.user.get('tipodeproducto_c');
		var status=this.model.get('estatus');
		var productoRef=this.model.get('producto_referenciado');

		if(puedeCancelar && productoRef == productoUsuario && status=='1'){
            $('span[data-fieldname="cancelado"]').find('input').removeAttr('disabled');
            $('[data-name="cancelado"]').attr('style',"pointer-events:block")

		}

        this.setEtiquetasFechas(productoRef);

	},

    setEtiquetasFechas:function(idProducto){
        var etiqueta_original_inicio='Fecha primer anexo activado';
        var etiqueta_original_fin='Fecha último anexo activado';
        if(idProducto!= null && idProducto !=""){

            if(idProducto=='4'){
                $('.record-label[data-name="primer_fecha_anexo"]').html('Fecha de primera cesión liberada');
                $('.record-label[data-name="ultima_fecha_anexo"]').html('Fecha de última cesión liberada');
            }else {
                $('.record-label[data-name="primer_fecha_anexo"]').html(etiqueta_original_inicio);
                $('.record-label[data-name="ultima_fecha_anexo"]').html(etiqueta_original_fin);
            }
        }

    },
	set_usuariorechazado: function () {
		if(this.model.get('cancelado') == '1' ){
			this.model.set('user_id2_c', App.user.attributes.id);
			this.model.set('usuario_rechazo', App.user.attributes.full_name);
		}else{
			this.model.set('usuario_rechazo', '');
		}
	},
	
	valida_requeridos: function (fields, errors, callback) {
        var campos = "";   
      
        if ( this.model.get('cancelado') == '1' ) {
            if (this.model.get('avance_cliente') == '') {
				campos = campos + '<b>' + '¿Había un avance previo con el cliente?'+ '</b><br>';
				errors['avance_cliente'] = errors['avance_cliente'] || {};
				errors['avance_cliente'].required = true;
			}
			if (this.model.get('motivo_rechazo') == '') {
				campos = campos + '<b>' + 'Motivo de rechazo'+ '</b><br>';
				errors['motivo_rechazo'] = errors['motivo_rechazo'] || {};
				errors['motivo_rechazo'].required = true;
			}
			if (this.model.get('explicacion_rechazo') == '') {
				campos = campos + '<b>' + 'Explicación de rechazo'+ '</b><br>';
				errors['explicacion_rechazo'] = errors['explicacion_rechazo'] || {};
				errors['explicacion_rechazo'].required = true;
			}
        }
        
		
        if (campos) {

            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información para guardar una <b>Referencia Venta Cruzada: </b><br>" + campos,
                autoClose: false
            });
        }else{
			this.model.set('estatus',"3");
		}

        callback(null, fields, errors);
    },
	
	aceptar_vta_cruzada: function () {

		$('[name="aceptar_vta_cruzada"]').attr('style', 'pointer-events:none');
        $('[name="cancelar_vta_cruzada"]').attr('style', 'pointer-events:none');
        App.alert.show('autorizaSol', {
            level: 'process',
            title: 'Autorizando, por favor espere.',
        });

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

		this.model.set('estatus',"1");
		this.model.set('user_id3_c',App.user.id );
		this.model.set('fecha_validacion_c',today);
		this.model.set('accion_validacion_c',"1");
		this.model.save(null, {
            success: function (model, response) {
                App.alert.dismiss('autorizaSol');
                App.alert.show("autorizacion_director_ok", {
                    level: "success",
                    messages: "La solicitud de venta cruzada fue aprobada.",
                    autoClose: false
                });
				location.reload();
            }, error: function (model, response) {
                $('[name="aceptar_vta_cruzada"]').attr('style', 'pointer-events:block');
                $('[name="cancelar_vta_cruzada"]').attr('style', 'pointer-events:block');
            }
        });
	},

	rechazar_vta_cruzada: function () {

		$('[name="aceptar_vta_cruzada"]').attr('style', 'pointer-events:none');
        $('[name="cancelar_vta_cruzada"]').attr('style', 'pointer-events:none');
		var campos = "";  

		 /*************************************************/
		 if (Modernizr.touch) {
			app.$contentEl.addClass('content-overflow-visible');
		}
		/**check whether the view already exists in the layout.
		 * If not we will create a new view and will add to the components list of the record layout
		 * */

			//var quickCreateView = this.layout.getComponent('MotivoCancelModal');
		var quickCreateView = null;
		if (!quickCreateView) {
			/** Create a new view object */
			quickCreateView = app.view.createView({
				context: this.context,
				name: 'MotivoCancelModal',
				layout: this.layout,
				module: 'Ref_Venta_Cruzada'
			});
			/** add the new view to the components list of the record layout*/
			this.layout._components.push(quickCreateView);
			this.layout.$el.append(quickCreateView.$el);
		}
		/**triggers an event to show the pop up quick create view*/
		this.layout.trigger("app:view:MotivoCancelModal");
	},

	establece_ref_valida:function(){
		$('[name="set_ref_valida"]').attr('style', 'pointer-events:none');

		App.alert.show('validandoReferencia', {
            level: 'process',
            title: 'Estableciendo como Válida esta referencia, por favor espere.',
		});
		
		this.model.set('estatus',"1");
		this.model.set('ref_validada_av_c',1);
		this.model.save(null, {
            success: function (model, response) {
                App.alert.dismiss('validandoReferencia');
                App.alert.show("referencia_valida", {
                    level: "success",
                    messages: "Este registro de referencia se ha establecido como Válida",
                    autoClose: false
                });
				location.reload();
            }, error: function (model, response) {
                $('[name="set_ref_valida"]').attr('style', 'pointer-events:block');
            }
        });


	},

	hideShowUniclick:function(){

		var puedeCancelar = App.user.get('valida_vta_cruzada_c');
		var productoUsuario = App.user.get('tipodeproducto_c');
		var status=this.model.get('estatus');
		var productoRef=this.model.get('producto_referenciado');

		if( puedeCancelar && status=='6' && (productoRef == '8' || productoRef == '9')){
            $('[name="aceptar_vta_cruzada"]').removeClass('hidden');
            $('[name="cancelar_vta_cruzada"]').removeClass('hidden');
            $('[name="aceptar_vta_cruzada"]').show();
            $('[name="cancelar_vta_cruzada"]').show();

		}

		this.setEtiquetasFechas(productoRef);
		this.hideShowBotonValidarReferencia();

	},

	hideShowBotonValidarReferencia:function(){
		//Obtiene usuario logueado
		var idCurrentUser=App.user.attributes.id;
		var idUserAlejandro=App.lang.getAppListStrings("usuario_ref_no_valida_list")[0];
		var valorCampoControl=this.model.get('ref_validada_av_c');
		//Solo mostrar el botón cuando el usuario firmado sea el mismo que Alejandro
		if(idCurrentUser==idUserAlejandro && !valorCampoControl && this.model.get('estatus')=='2'){
			$('[name="set_ref_valida"]').removeClass('hidden');
		}

	}

	
})