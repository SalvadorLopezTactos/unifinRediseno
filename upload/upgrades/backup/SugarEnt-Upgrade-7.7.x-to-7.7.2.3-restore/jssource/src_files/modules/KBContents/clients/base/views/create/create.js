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
    extendsFrom: 'CreateView',

    /**
     * @inheritdoc
     *
     * Add KBContent plugin for view.
     */
    initialize: function(options) {
        this.plugins = _.union(this.plugins || [], [
            'KBContent'
        ]);
        this._super('initialize', [options]);
    },

    /**
     * Using the model returned from the API call, build the success message.
     * @param {Data.Bean} model KBContents bean for record that was just created.
     * @return {string} The success message.
     */
    buildSuccessMessage: function(model) {
        var message = this._super('buildSuccessMessage', [model]);

        // If user has no access to view record - don't show record link for him
        if (!app.acl.hasAccessToModel('view', this.model)) {
            message = message.replace(/<\/?a[^>]+>/g, '');
        }

        return message;
    }
})
