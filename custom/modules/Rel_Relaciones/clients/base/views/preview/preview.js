({
    extendsFrom: 'PreviewView',

	doRelationFields: function()
	{
		var sRelaciones = new String(this.model.get('relaciones_activas'));
		var arrRelaciones = sRelaciones.split(",");
		$("div[name='montodeparticipacion']").parent().hide();
		$("div[name='miembrodecomite']").parent().hide();
		$("div[name='porcentaje_participacion_c']").parent().hide();
		$("div[name='tipodecontacto']").parent().hide();
		$("div[name='limitedecredito']").parent().hide();
		$("div[name='plazoendias']").parent().hide();
		$("div[name='parentesco']").parent().hide();
		$("div[name='tiempodeconocerloano']").parent().hide();
		$("div[name='tiempodeconocerlomeses']").parent().hide();
		$("div[name='probabilidadincremento']").parent().hide();
		$("div[name='facturacionmensual']").parent().hide();
		$("div[name='opinion']").parent().hide();
		$("div[name='consumomensual']").parent().hide();
		$("div[name='linea']").parent().hide();
		$("div[name='saldo']").parent().hide();
		$("div[name='producto']").parent().hide();
		$("div[name='puesto']").parent().hide();
		$("div[name='puestodescription']").parent().hide();


		for(var x = 0; x < arrRelaciones.length; x++){
			switch (arrRelaciones[x]){
				case "Accionista":
					$("div[name='montodeparticipacion']").parent().show();
					$("div[name='miembrodecomite']").parent().show();
					$("div[name='porcentaje_participacion_c']").parent().show();
					break;
				case "Contacto":
					$("div[name='tipodecontacto']").parent().show();
					break;
				case "Referencia Personal":
					$("div[name='parentesco']").parent().show();
					$("div[name='tiempodeconocerloano']").parent().show();
					$("div[name='tiempodeconocerlomeses']").parent().show();

					break;
				case "Referencia Proveedor":
					$("div[name='limitedecredito']").parent().show();
					$("div[name='plazoendias']").parent().show();
					$("div[name='opinion']").parent().show();
					$("div[name='tiempodeconocerloano']").parent().show();
					$("div[name='tiempodeconocerlomeses']").parent().show();
					$("div[name='consumomensual']").parent().show();
					$("div[name='linea']").parent().show();
					$("div[name='saldo']").parent().show();
					$("div[name='producto']").parent().show();

					break;
				case "Referencia Cliente":
					$("div[name='limitedecredito']").parent().show();
					$("div[name='plazoendias']").parent().show();
					$("div[name='tiempodeconocerloano']").parent().show();
					$("div[name='tiempodeconocerlomeses']").parent().show();
					$("div[name='probabilidadincremento']").parent().show();
					$("div[name='facturacionmensual']").parent().show();
					$("div[name='opinion']").parent().show();
					break;
				case "Representante":
					$("div[name='puesto']").parent().show();
					$("div[name='puestodescription']").parent().show();
					break;
			}
		}
	},

	_render: function() {
		this._super("_render");
		this.doRelationFields();
	},
    
    _renderPreview: function (model, collection, fetch, previewId) {
        console.log(fetch);
        console.log(previewId);
        console.log("Preview Relaciones CZ");
        var self = this;

        // If there are drawers there could be multiple previews, make sure we are only rendering preview for active drawer
        if (app.drawer && !app.drawer.isActive(this.$el)) {
            return;  //This preview isn't on the active layout
        }

        // Close preview if we are already displaying this model
        if (this.model && model && (this.model.get("id") == model.get("id") && previewId == this.previewId)) {
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
                    success: function (model) {
                        //Get the value form "Type" field, if set to 'Customer', remove 'website' field
                        //var custType = model.get('account_type');
                        //if (custType === 'Customer')
                        //{
                        var show = true;
                        var CamposOcultos = [
                            'limitedecredito',
                            'plazoendias',
                            'tiempodeconocerloano',
                            'tiempodeconocerlomeses',
                            'opinion',
                            'probabilidadincremento',
                            'razonsocial_c',
                            'consumomensual',
                            'linea',
                            'saldo',
                            'producto',
                            'parentesco',
                            'facturacionmensual',
                            'puesto',
                            'puestodescription',
                            'miembrodecomite',
                            'porcentaje_participacion_c',
                            'montodeparticipacion',
                            'tipodecontacto'
                        ];
                        var atributos = model.attributes;
                        var sRelaciones = String(atributos.relaciones_activas);
                        var arrRelaciones = sRelaciones.split(",");
                        for (var x = 0; x < arrRelaciones.length; x++) {
                            switch (arrRelaciones[x]) {
                                case "Accionista":
                                    CamposOcultos.splice(CamposOcultos.indexOf('tipodecmontodeparticipacionontacto'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('miembrodecomite'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('porcentaje_participacion_c'), 1);
                                    break;
                                case "Contacto":
                                    CamposOcultos.splice(CamposOcultos.indexOf('tipodecontacto'), 1);
                                    break;
                                case "Referencia Personal":
                                    CamposOcultos.splice(CamposOcultos.indexOf('parentesco'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('tiempodeconocerloano'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('tiempodeconocerlomeses'), 1);
                                    break;
                                case "Referencia Proveedor":
                                    CamposOcultos.splice(CamposOcultos.indexOf('limitedecredito'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('plazoendias'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('opinion'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('tiempodeconocerloano'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('tiempodeconocerlomeses'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('consumomensual'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('linea'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('saldo'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('producto'), 1);
                                    break;
                                case "Referencia Cliente":
                                    CamposOcultos.splice(CamposOcultos.indexOf('opinion'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('limitedecredito'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('plazoendias'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('tiempodeconocerloano'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('tiempodeconocerlomeses'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('probabilidadincremento'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('facturacionmensual'), 1);
                                    break;
                                case "Representante":
                                    CamposOcultos.splice(CamposOcultos.indexOf('puesto'), 1);
                                    CamposOcultos.splice(CamposOcultos.indexOf('puestodescription'), 1);
                                    break;
                            }
                        }
                        _.each(self.meta.panels, function (panel) {
                            panel.fields = _.filter(panel.fields, function (field) {
                                show = $.inArray(field.name, CamposOcultos) <= -1;
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
});