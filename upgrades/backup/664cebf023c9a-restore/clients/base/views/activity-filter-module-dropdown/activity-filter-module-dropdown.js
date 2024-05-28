/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Views.Base.ActivityFilterModuleDropdownView
 * @alias SUGAR.App.view.views.BaseActivityFilterModuleDropdownView
 * @extends View.Views.Base.FilterModuleDropdownView
 */
({
    extendsFrom: 'FilterModuleDropdownView',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        options.template = app.template.get('filter-module-dropdown');

        this._super('initialize', [options]);
    },

    /**
     * @inheritdoc
     * @return {Object}
     */
    getFilterList: function() {
        return this.context.get('filterList');
    },

    /**
     * @inheritdoc
     * @return boolean
     */
    shouldDisableFilter: function() {
        return false;
    },

    /**
     * Trigger event to reload the layout when the module changes.
     * @param {string} linkModuleName
     * @param {string} linkName
     * @param {boolean} silent
     */
    handleChange: function(linkModuleName, linkName, silent) {
        linkModuleName = linkModuleName || this.layout.name;

        var cacheKey = app.user.lastState.key(this.layout.name, this.layout);

        if (linkName) {
            app.user.lastState.set(cacheKey, linkName);
        } else {
            app.user.lastState.remove(cacheKey);
        }

        this._super('handleChange', [linkModuleName, linkName, silent]);
    },
})
