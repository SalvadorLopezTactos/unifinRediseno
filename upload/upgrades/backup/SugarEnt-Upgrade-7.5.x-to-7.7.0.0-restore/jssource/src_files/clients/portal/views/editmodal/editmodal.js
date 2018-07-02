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
    extendsFrom: 'EditmodalView',

    /**
     * overload baseeditmodalview and remove the 'file' type fields to prevent an issue with portal users
     * being unable to upload notes
     * @param {object} model
     */
    processModel: function(model) {
        this._super('processModel', [model]);

        if (model) {
            model.set('portal_flag', true);

            // remove all fields with type 'file'
            _.each(model.fields, function(field) {
                if (field.type === 'file') {
                    model.unset(field.name);
                }
            });
        }
    }
})
