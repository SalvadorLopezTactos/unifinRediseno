({
    extendsFrom: 'RecordView',   

    initialize: function (options) {
        self = this;
        contexto_cuenta = this;
        
		this._super("initialize", [options]);
        this.model.on('sync', this.hideShowCancelar, this);

    },
	
	_renderHtml: function(){      
		var self = this;  
		self.noEditFields.push('estatus');
		self.noEditFields.push('producto_referenciado');
		self.noEditFields.push('producto_origen');
		self.noEditFields.push('numero_anexos');
		self.noEditFields.push('primer_fecha_anexo');
		self.noEditFields.push('ultima_fecha_anexo');
		
		this.model.on("change:cancelado", _.bind(this.set_usuariorechazado, this));
		this.model.addValidationTask('check_Requeridos', _.bind(this.valida_requeridos, this));

		this._super('_renderHtml')
	},
    
	_dispose: function(){  
		this._super('_dispose');  
	},

	_render: function (options) {
        this._super("_render");
        $('[data-name="cancelado"]').hide();
    },

    hideShowCancelar:function(){
		var puedeCancelar=App.user.get('tct_cancelar_ref_cruzada_chk_c');
		var productoUsuario=App.user.get('tipodeproducto_c');
		var status=this.model.get('estatus');
		var productoRef=this.model.get('producto_referenciado');

		if(puedeCancelar && productoRef == productoUsuario && status=='1'){
            $('[data-name="cancelado"]').show();

		}
	},
	
	set_usuariorechazado: function () {
		if(this.model.get('cancelado') == '1' ){
			this.model.set('usuario_rechazo',App.user.attributes.full_name);
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
        }

        callback(null, fields, errors);
    },
	
})