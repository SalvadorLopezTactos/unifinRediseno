({
    extendsFrom: 'CreateView',

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
    		self = this;
    		this.model.addValidationTask('check_Requeridos', _.bind(this.valida_requeridos, this));
        this.model.on("change:producto_referenciado", _.bind(this.setPromotorProductoReferenciado, this));
        this.on('render', this.recupera_usRM, this);
        this.noAsignado = App.lang.getAppListStrings("usuario_sin_gestor_list")[1];

    },

	_renderHtml: function(){

        var userprod = (app.user.attributes.tipodeproducto_c).replace(/\^/g, "");

		if(this.model.get('producto_origen') != null || this.model.get('producto_origen') != ""){
			this.model.set('producto_origen', userprod);
		}

		this._super('_renderHtml');

	},

	_dispose: function(){
		this._super('_dispose');
	},

	_render: function (options) {
      this._super("_render");
      $('[data-name="cancelado"]').hide();
      //Ocultando campo de control que valida si Alejandro de la Vega ha Validado la referencia
      $('[data-name="ref_validada_av_c"]').hide();
    },

	recupera_usRM:function(){

		var account = app.data.createBean('Accounts', this.model.get('accounts_ref_venta_cruzada_1'));
		//var idrm = account.attributes.id.promotorrm_c;
		//var idrm1 = account.attributes.id.user_id8_c;
		account.fetch({
      success: _.bind(function (modelo) {
        //Asignamos el promotor del producto para la operación
        var idrm = (modelo.get('promotorrm_c')!= undefined) ? modelo.get('promotorrm_c') : '';
				var idrm1 = (modelo.get('user_id8_c') != undefined) ? modelo.get('user_id8_c') : '' ;
				self.model.set('user_id1_c', idrm1);
        self.model.set('usuario_rm', idrm);
        if(idrm1 !='' && self.noAsignado != idrm1){
          self.$('[data-name="usuario_rm"]').attr('style',"pointer-events:none");
        }
      }, this)
    });
	},

	valida_requeridos: function (fields, errors, callback) {
        var campos = "";

        if ( this.model.get('description') == '' ) {
            campos = campos + '<b>' + 'Necesidad del cliente' + '</b><br>';
            errors['description'] = errors['description'] || {};
            errors['description'].required = true;
        }

		if (this.model.get('producto_referenciado') == '') {
			campos = campos + '<b>' + 'Producto referenciado'+ '</b><br>';
            errors['producto_referenciado'] = errors['producto_referenciado'] || {};
            errors['producto_referenciado'].required = true;
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

    setPromotorProductoReferenciado:function () {
        var idProducto=this.model.get('producto_referenciado');
        var idCuenta=this.model.get('accounts_ref_venta_cruzada_1accounts_ida');

        this.setEtiquetasFechas(idProducto);

        if(idCuenta!=null && idCuenta!=undefined && idCuenta!=""){
            var url=app.api.buildURL('Accounts/' + idCuenta + '/link/accounts_uni_productos_1');

            app.alert.show('getUserProducto', {
                level: 'process',
                title: 'Cargando...',
            });

            app.api.call('GET', url, null, {
                success: function (data) {
                    app.alert.dismiss('getUserProducto');
                    var getUser = false;
                    if(data.records.length>0){
                        for(var i=0;i<data.records.length;i++){
                            if(data.records[i].tipo_producto==self.model.get('producto_referenciado')){
                                //Obtener el asesor del producto
                                var idAsesorProducto=data.records[i].assigned_user_id;
                                var nombreAsesorProducto=data.records[i].assigned_user_name;
                                getUser = true;
                                self.model.set('user_id_c',idAsesorProducto);
                                self.model.set('usuario_producto',nombreAsesorProducto);
                                if (self.noAsignado != idAsesorProducto) {
                                    self.$('[data-name="usuario_producto"]').attr('style',"pointer-events:none");
                                }else {
                                    self.$('[data-name="usuario_producto"]').attr('style',"pointer-events:block");
                                }
                            }

                        }
                    }
                    if (!getUser) {
                        self.model.set('user_id_c','');
                        self.model.set('usuario_producto','');
                        self.$('[data-name="usuario_producto"]').attr('style',"pointer-events:block");
                    }
                }

            });

        }

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

    }

})
