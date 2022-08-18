({
    extendsFrom: 'SubpanelListView',

	initialize:function(options)
	{
		this._super('initialize',[options]);
	},

    contextEvents: {
		"list:emailbtn:fire": "emailbtn"
    },
    
    emailbtn: function(model) {
    	if(model.attributes.relaciones_activas.includes('Tarjetahabiente') && app.user.attributes.habilita_envio_tc_c)
		{
			app.alert.show('procesando', {
				level: 'process',
				title: 'Procesando...'
			});
			var api_params = {
				"idCuenta": this.context.parent.get('model').get("id"),
				"idRelacion": model.attributes.account_id1_c,
				"relaciones": model.attributes.relaciones_activas
			};
			var url = app.api.buildURL('email_TDC/', null, null);
			app.api.call('create', url, api_params, {
				success: function (data) {
					var result = 'success';
					if(data['status'] != 200) result = 'error'; 
					app.alert.dismiss('procesando');
					app.alert.show('Correo_reenviado', {
						level: result,
						messages: data['message'],
						autoClose: false
					});
				},
				error: function (e) {
					app.alert.dismiss('procesando');
					app.alert.show('Correo_no_reenviado', {
						level: 'error',
						messages: 'No se ha podido generar la contraseña. Intente nuevamente.',
						autoClose: false
					});
				}
			});
		}
		else
		{
			app.alert.show("Tarjetahabiente", {
                level: "error",
                title: "No tiene los permisos para ejecutar esta acción o el registro no tiene una relación activa de Tarjetahabiente",
                autoClose: false
            });
		}
    },
})