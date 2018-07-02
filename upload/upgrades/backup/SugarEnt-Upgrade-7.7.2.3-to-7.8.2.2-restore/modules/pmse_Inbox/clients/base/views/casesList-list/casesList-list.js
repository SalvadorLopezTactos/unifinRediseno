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
    extendsFrom: 'FlexListView',
    plugins: ['ListColumnEllipsis', 'Pagination', 'MassCollection'],

    /**
     * Removes the event listeners that were added to the mass collection.
     */
    unbindData: function() {
        var massCollection = this.context.get('mass_collection');
        if (massCollection) {
            massCollection.off(null, null, this);
        }
        this._super("unbindData");
    },
    /**
     * Override to inject field names into the request when fetching data for the list.
     *
     * @param module
     * @returns {Array}
     */
    getFieldNames: function(module) {
        // id and module always get returned, so name and email just need to be added
        return ['name', 'email'];
    },

    /**
     * @inheritdoc
     */
    _setOrderBy: function(options) {
        this.context.set('sortOptions', options);
        options.query = this.context.get('query');
        options.module_list = this.context.get('module_list');
        options.offset = 0;
        options.update = false;
        this._super('_setOrderBy', options);
    },

    /**
     * Override to hook in additional triggers as the mass collection is updated (rows are checked on/off in
     * the actionmenu field). Also attempts to pre-check any rows when the list is refreshed and selected recipients
     * are found within the new result set (this behavior occurs when the user searches the address book).
     *
     * @private
     */
    _render: function() {
        if (app.acl.hasAccessToAny('developer')) {
            this._super('_render');
        }
        else {
            app.controller.loadView({
                layout: 'access-denied'
            });
        }
    },
    /**
     * Override to force translation of the module names as columns are added to the list.
     *
     * @param field
     * @private
     */
    _renderField: function(field) {
            this._super("_renderField", [field]);
    },

    _dispose: function() {
        jQuery('.adam-modal').remove();
        this._super("_dispose", arguments);
    }
})
