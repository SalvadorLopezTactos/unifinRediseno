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
 * Emailaction is a button that when selected will launch the appropriate email
 * client. Email options for prepopulating fields on email compose or mailto
 * link are set based on field def settings.
 *
 * @class View.Fields.Base.EmailactionField
 * @alias SUGAR.App.view.fields.BaseEmailactionField
 * @extends View.Fields.Base.ButtonField
 */
({
    extendsFrom: 'ButtonField',
    plugins: ['EmailClientLaunch'],

    /**
     * @inheritdoc
     *
     * Set up email options to prepopulate fields on email compose (or set up
     * mailto link if not using Sugar Email Client)
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this._initEmailOptions();
    },

    /**
     * Set up email options, listening for parent model changes to update the
     * email options on change.
     *
     * @private
     */
    _initEmailOptions: function() {
        var context = this.context.parent || this.context,
            parentModel = context.get('model');

        if (parentModel instanceof Backbone.Model) {
            this._updateEmailOptions(parentModel);
            parentModel.on('change', function(model) {
                this._updateEmailOptions(model);
                this.render();
            }, this);
        }
    },

    /**
     * Update email options based on field def settings
     *
     * @param {Object} parentModel
     * @private
     */
    _updateEmailOptions: function(parentModel) {
        if (this.def.set_recipient_to_parent) {
            this.addEmailOptions({to_addresses: [{bean: parentModel}]});
        }

        if (this.def.set_related_to_parent) {
            this.addEmailOptions({related: parentModel});
        }
    }
})
