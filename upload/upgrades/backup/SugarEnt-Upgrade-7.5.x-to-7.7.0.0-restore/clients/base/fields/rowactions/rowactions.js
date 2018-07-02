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
 * @class View.Fields.Base.RowactionsField
 * @alias SUGAR.App.view.fields.BaseRowactionsField
 * @extends View.Fields.Base.ActiondropdownField
 */
({
    extendsFrom: 'ActiondropdownField',
    _loadTemplate: function() {
        app.view.Field.prototype._loadTemplate.call(this);

        //override its container if it has own template
        var template = app.template._getField(this.type, this.tplName, this.module, null, true)[1];

        if(template) {
            this.$el.attr('class', '');
            this.$el.html(template(this));
        }
        if(this.view.action === 'list' && this.action === 'edit') {
            this.$el.hide();
        } else {
            this.$el.show();
        }
    }
})
