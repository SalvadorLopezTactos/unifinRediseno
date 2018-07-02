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
 * @class View.Fields.Base.OverdueBadgeField
 * @alias SUGAR.App.view.fields.BaseOverdueBadgeField
 * @extends View.Field
 */
({
    _render: function() {
        var now = new Date(),
            date = new Date(this.model.get(this.name));
        this.model.set('overdue', date < now);
        this._super('_render');
    }
})
