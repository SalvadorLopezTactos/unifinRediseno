({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        this._super("initialize", [options]);
        this.model.on('sync', this.hideFunction, this);
    },

    _render: function() {
        this._super("_render");
    },

    hideFunction: function() {
		var creditaria = 0;
		var roles = app.user.attributes.roles;
		for(var i=0;i<roles.length;i++)
		{
			if(roles[i] === "Seguros - Creditaria")
			{
				creditaria = 1;
			}
		}
		if(creditaria) {
			this.$('[data-name=int_coaseguro]').hide();
			this.$('[data-name=int_comision]').hide();
			this.$('[data-name=int_comision_documento]').hide();
			this.$('[data-name=int_comision_porcentaje]').hide();
			this.$('[data-name=int_honorarios_fee]').hide();
			this.$('[data-name=int_honorarios_fee_porcentaje]').hide();
			this.$('[data-name=int_porcentaje_comision_total]').hide();
			this.$('[data-name=int_porcentaje_sobrecomision]').hide();
			this.$('[data-name=int_udi]').hide();
		}
    }
})
