({
	/* File: ./custom/clients/base/views/module-menu/module-menu.js */

	extendsFrom: 'ModuleMenuView',

    initialize: function(options) {
        this._super('initialize', [options]);

        this.customPopulateMenu();
    },
	
    handleRouteEvent: function(event) {
        var currentRoute,
            $currentTarget = this.$(event.currentTarget),
            route = $currentTarget.data('route');
		
        switch (route) {
        	case '#Cotizador':
        		route = '#bwc/index.php?entryPoint=OpportunidadVaadin';
        		//app.user.lastState.set('Leads:filter:last-Leads-records', this.meta.filter);
        		break;

            case '#Expediente':
                route = '#bwc/index.php?entryPoint=ExpedienteMod';
                //app.user.lastState.set('Leads:filter:last-Leads-records', this.meta.filter);
                break;

            case '#CotizadorProspectos':
                route = '#bwc/index.php?entryPoint=CotizadorProspectos';
                //app.user.lastState.set('Leads:filter:last-Leads-records', this.meta.filter);
                break;
        }

        event.preventDefault();
        if ((!_.isUndefined(event.button) && event.button !== 0) || event.ctrlKey || event.metaKey) {
            event.stopPropagation();
            window.open(route, '_blank');
            return false;
        }

        currentRoute = '#' + Backbone.history.getFragment();
        (currentRoute === route) ? app.router.refresh() : app.router.navigate(route, {trigger: true});
    },

    customPopulateMenu: function () {

	    if(this.module == "Accounts"){
            var meta = app.metadata.getModule(this.module) || {};
            if (_.isEmpty(_.omit(meta.fields, '_hash'))) {
                return;
            }

            app.api.call("read", app.api.buildURL("UserRoles", null, null, {
            }), null, {
                success: _.bind(function (data) {
                    var roleReasignacionPromotores = false;
                    _.each(data, function (key, value) {

                        if (key == "Reasignacion de Promotores") {
                            roleReasignacionPromotores = true;
                        }
                    });

                    if(roleReasignacionPromotores == false){
                        if(meta.menu.header.meta[5].label == "LNK_REASIGNACION_DE_PROMOTORES"){
                            delete meta.menu.header.meta[5];
                            this.render();
                        }
                    }

                }, this)
            });
        }
    },

})
