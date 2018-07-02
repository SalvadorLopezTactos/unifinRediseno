({
	/* File: ./custom/clients/base/layouts/module-list/module-list.js */
	
	extendsFrom: 'ModuleListLayout',
	
	_addDefaultMenus: function() {
		var moduleList = app.metadata.getModuleNames({filter: 'display_tab', access: 'read'});
		
		moduleList.push('Cotizador');
        moduleList.push('Expediente');

        _.each(moduleList, function(module) {
            this._addMenu(module, true);
        }, this);
	},

    _addMenu: function(module, sticky) {
        var menu = {};
        var filter = 'favorites';
        var alias = false;
        
        switch(module) {
        	case 'Cotizador':
        		filter = 'all_records';
        		alias = true;
        		break;
            
            case 'Expediente':
                filter = 'all_records';
                alias = true;
                break;
        }

        var def = {
            view: {
            	filter: filter,
            	alias: alias,
                name: 'module-menu',
                sticky: sticky,
                short: false
            }
        };

        menu.long = this.createComponentFromDef(def, null, module);
        
        this.addComponent(menu.long, def);

        if (!sticky) {
            return menu;
        }

        def = {
            view: {
            	filter: filter,
            	alias: alias,
                name: 'module-menu',
                short: true
            }
        };
        menu.short = this.createComponentFromDef(def, null, module);
        this.addComponent(menu.short, def);

        return menu;
    },
})
