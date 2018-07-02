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
 * @class View.Fields.Base.Emails.QuickcreateField
 * @alias SUGAR.App.view.fields.BaseEmailsQuickcreateField
 * @extends View.Fields.Base.QuickcreateField
 */
({
    extendsFrom: 'QuickcreateField',
    plugins: ['EmailClientLaunch'],

    /**
     * Used by EmailClientLaunch as a hook point to retrieve email options that are specific to a view/field
     * In this case we are using it to retrieve the parent model to make this email compose launching
     * context aware - prepopulating the to address with the given model and the parent relate field
     *
     * @returns {Object}
     * @private
     */
    _retrieveEmailOptionsFromLink: function() {
        var context = this.context.parent || this.context,
            parentModel = context.get('model'),
            emailOptions = {};

        if (parentModel && parentModel.id) {
            // set parent model as option to be passed to compose for To address & relate
            // if parentModel does not have email, it will be ignored as a To recipient
            // if parentModel's module is not an available module to relate, it will also be ignored
            emailOptions = {
                to_addresses: [{bean: parentModel}],
                related: parentModel
            };
        }

        return emailOptions;
    }
})
