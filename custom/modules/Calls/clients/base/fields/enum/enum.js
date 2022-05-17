({
    extendsFrom: 'EnumField',

    initialize: function(options){
        this._super('initialize',[options]);
    },

    render: function() {
		if (this.name === 'padres_c') {
			window.padres = 0;
			var idHijo = this.model.get('parent_id');
			var parentModule = this.model.get('parent_type');
			var idUsuario = app.user.attributes.id;
			if(idHijo!=undefined && idHijo!="" && parentModule !=undefined && (parentModule == 'Accounts' || parentModule == 'Leads')){
				app.api.call('GET', app.api.buildURL('getPadres/' + idHijo + "/" + parentModule + "/" + idUsuario), null, {
					success: _.bind(function (data) {
						var arrayPadres = app.lang.getAppListStrings('padres_list');
						for (var i = 0; i < data.length; i++) {
							arrayPadres[data[i]['id']] = data[i]['name'];
							window.padres = window.padres + 1;
						}
						this.items = arrayPadres;
						if(data.length == 1) this.model.set('padres_c',data[0]['id']);
						this._super('render');
					}, this)
				});
			}
		}
		this._super('render');
    }
})