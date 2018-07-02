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
/**
 * @class View.Fields.Base.Emails.EmailactionPaneltopField
 * @alias SUGAR.App.view.fields.BaseEmailsEmailactionPaneltopField
 * @extends View.Fields.Base.EmailactionField
 */
({
    extendsFrom: 'EmailactionField',
    plugins: ['EmailClientLaunch'],

    /**
     * @inheritdoc
     * Set type to emailaction to get the template
     */
    initialize: function(options) {
        this._super("initialize", [options]);
        this.type = 'emailaction';
        this.on('emailclient:close', this.handleEmailClientClose, this);
    },

    /**
     * When email compose is done, refresh the data in the Emails subpanel
     */
    handleEmailClientClose: function() {
        var context = this.context.parent || this.context;
        context.trigger('panel-top:refresh', 'emails');
        context.trigger('panel-top:refresh', 'archived_emails');
    },

    /**
     * No additional options are needed from the element in order to launch the
     * email client.
     *
     * @param {jQuery} [$link] The element from which to get options.
     * @return {Object}
     * @private
     */
    _retrieveEmailOptionsFromLink: function($link) {
        return {};
    }
})
