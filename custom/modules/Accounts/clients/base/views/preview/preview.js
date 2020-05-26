({

    extendsFrom:'PreviewView',

	_renderPreview: function(model, collection, fetch, previewId){
		var self = this;
		var CamposOcultos = [
			'pep_c',
			'lista_negra_c',
			'primernombre_c',
			'segundonombre_c',
			'apellidopaterno_c',
			'apellidomaterno_c',
			'razonsocial_c',
			'origen_cuenta_c',
			'motivo_c',
			'ifepasaporte_c',
			'tipo_relacion_c',
			'iva_c',
			'tipodemotivo_c',
			'seguimiento_futuro_c',
			'tiposeguimiento_c',
			'descripciondetarea_c',
			'oficial_comentario_c',
			'calidadmigratoria_c',
			'nacionalidad_c',
			'contactodiferentealprospecto_c',
			'riesgo_c',
			'tipodecliente_c',
			'inactivo_c',
			'comision_referenciador_c',
			'observaciones_c',
			'noseriefiel_c',
			'identificadordecliente_c',
			'zonageografica_c',
			'id_process_c',
			'canal_c',
			'ctpldpoliticamenteexpuesto_c',
			'ctpldrelacionadoarticulo_c',
			'ctpldnoseriefiel_c',
			'ctpldfuncionespublicas_c',
			'ctpldfuncionespublicascargo_c',
			'ctpldconyuge_c',
			'ctpldconyugecargo_c',
			'ctpldaccionistas_c', 
			'ctpldaccionistascargo_c',
			'ctpldaccionistasconyuge_c', 
			'ctpldaccionistasconyugecargo_c', 
			'pagoanticipado_c',
			'imcuenta_c', 
			'imcheque_c', 
			'imefectivo_c', 
			'imotro_c',
			'imotrodesc_c',
			'ctpldorigenrecursocliente_c', 
			'ctpldidproveedorrecursosson_c', 
			'ctpldidproveedorrecursosclie_c',
			'genero_c',
			'curp_c',
			'profesion_c',
			'estadocivil_c',
			'regimenpatrimonial_c',
			'generar_rfc_c',
			'generar_curp_c',
			'account_contacts'
		];

		// If there are drawers there could be multiple previews, make sure we are only rendering preview for active drawer
		if(app.drawer && !app.drawer.isActive(this.$el)){
			return;  //This preview isn't on the active layout
		}

		// Close preview if we are already displaying this model
		if(this.model && model && (this.model.get("id") == model.get("id") && previewId == this.previewId)) {
			// Remove the decoration of the highlighted row
			app.events.trigger("list:preview:decorate", false);
			// Close the preview panel
			app.events.trigger('preview:close');
			return;
		}

		if (app.metadata.getModule(model.module).isBwcEnabled) {
			// if module is in BWC mode, just return
			return;
		}

		if (model) {
			// Use preview view if available, otherwise fallback to record view
			var viewName = 'preview',
				previewMeta = app.metadata.getView(model.module, 'preview'),
				recordMeta = app.metadata.getView(model.module, 'record');
			if (_.isEmpty(previewMeta) || _.isEmpty(previewMeta.panels)) {
				viewName = 'record';
			}
			this.meta = this._previewifyMetadata(_.extend({}, recordMeta, previewMeta));

			if (fetch) {
				model.fetch({
					//Show alerts for this request
					showAlerts: true,
					success: function(model) {
						//Get the value form "Type" field, if set to 'Customer', remove 'website' field
						//var custType = model.get('account_type');
						//if (custType === 'Customer')
						//{
						var show = true;
                        _.each(self.meta.panels, function(panel){
                            panel.fields = _.filter(panel.fields, function(field){
                            	show = true;
                            	if($.inArray(field.name,CamposOcultos) > -1){
									show = false;
								}
                                return show; 
                            });
                        });
                      
						self.renderPreview(model, collection);
					},
					//The view parameter is used at the server end to construct field list
					view: viewName
				});
			} else {
				this.renderPreview(model, collection);
			}
		}

		this.previewId = previewId;
	},

    hideconfiinfo:function () {

        self=this;

        if(this.model.get('id')!="") {
            app.api.call('GET', app.api.buildURL('GetUsersBoss/' + this.model.get('id')), null, {
                success: _.bind(function (data) {
                    console.log(data);
                    if(data==false){
                        $('div[data-name=account_telefonos]').hide();
                        $('div[data-name=email]').hide();
                        $('div[data-name=account_direcciones]').hide();
                    }else{
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

	initialize:function(options){
        this._super("initialize", [options])
    	console.log('entrando a preview');
        this.model.on('sync', this.hideconfiinfo, this);
		//app.events.on("preview:render", this._showHideFields, this);
		//delete this.model.fields["rfc_c"];

	},

		/*	_showHideFields: function(model, collection, fetch, previewId){

				//Hiding Webcast related Field from preview panel 
				//$('div[name="rfc_c"]').parent().hide();
				this.$("div[name='rfc_c']").hide();
				console.log("** JSR ** Entr� a ocultar");
				//$('div[name="fieldname_1"]').parent().hide();

			}, */
})