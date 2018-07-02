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
 * @class View.Fields.Base.EnumField
 * @alias SUGAR.App.view.fields.BaseEnumField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'EnumField',
    initialize: function(options) {
        this._super('initialize', [options]);
        if (this.def && this.def.options) {
            this.items = app.lang.get(this.def.options, 'Connectors');
        }

    }
})
