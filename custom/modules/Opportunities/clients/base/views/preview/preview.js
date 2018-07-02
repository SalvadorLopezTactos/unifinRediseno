({

    extendsFrom:'PreviewView',

	_renderPreview: function(model, collection, fetch, previewId){
		var self = this;
		var CamposOcultos = [
			'enviar_por_correo_c',
			'canal_c'
		];
		var CamposOcultosFactoraje = [
			'f_tipo_factoraje_c',
			'f_comentarios_generales_c',
			'f_documento_descontar_c',
			'f_aforo_c'
		];
		var CamposOcultosLeasing = [
			'activo_c',
			'sub_activo_c',
			'sub_activo_2_c',
			'sub_activo_3_c',
			'activo_nombre_c',
			'usuario_bo_c'
		];

		var tipo_producto = model.get("tipo_producto_c");
		
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
								//Ocultar campos de Leasing o CA
								if (tipo_producto != 1 && tipo_producto != 3 && $.inArray(field.name,CamposOcultosLeasing) > -1 ){
									show = false;
								}
								//Ocultar campos de factoraje
								if (tipo_producto != 4 && $.inArray(field.name,CamposOcultosFactoraje) > -1 ){
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
	}
	
})