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
    extendsFrom: 'FilterRowsView',

    /**
     * @inheritdoc
     */
    getFilterableFields: function(moduleName) {
        var fields = this._super("getFilterableFields", [moduleName]);
        if (app.metadata.getModule("Forecasts", "config").is_setup != 1) {
            delete fields['commit_stage'];
        } else {
            _.each(fields, function(field, key, list) {
                if (key.indexOf('_case') != -1) {
                    var fld = 'show_worksheet_' + key.replace('_case', '');
                    if (app.metadata.getModule("Forecasts", "config")[fld] != 1) {
                        delete list[key];
                    }
                }
            });

        }

        return fields;
    }
})
