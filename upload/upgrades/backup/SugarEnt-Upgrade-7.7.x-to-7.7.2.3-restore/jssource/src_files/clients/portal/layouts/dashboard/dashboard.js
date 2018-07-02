/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    initialize: function(options) {
        // the home module doesn't have a proper module on the context because it has a context
        // of mixed module types
        // set the current module to home to get the mega menu to highlight correctly
        app.controller.context.set('module', 'Home');
        // Figure out the modules that are available to the user. omit home because it doesn't exist
        this.module_list = _.without(app.metadata.getModuleNames({filter: 'display_tab', access: 'list'}), 'Home');

        options.meta.components = [];
        // Add components metadata as specified in the module list
        _.each(this.module_list, function(module) {
            options.meta.components.push({
                layout: 'dashboard-list',
                context: {limit: 5, module: module}
            });
        }, this);

        this._super('initialize', [options]);

        this.context.get('model').dataFetched = true;
        this.context.get('collection').dataFetched = true;
    }
})
