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
 * @class View.Fields.Base.DnbBalImportMenuLabelField
 * @alias SUGAR.App.view.fields.BaseDnbBalImportMenuLabelField
 * @extends View.Field.LabelField
 */
({
    extendsFrom: 'LabelField',

    /**
     * @inheritdoc
     */
    format: function(value) {
        // Establish our current connector name, in this case, dnb
        var connector = 'dnb';

        // And get the connectors config data if it exists
        var connectors = app.config.connectors || {};

        // If the connector is configured, set the label from the default value
        if (connectors[connector] && connectors[connector].configured) {
            value = app.lang.get(this.def.default_value, this.module);
        } else {
            // Otherwise, make it empty so the template loads nothing
            value = '';
        }

        return value;
    }
})
