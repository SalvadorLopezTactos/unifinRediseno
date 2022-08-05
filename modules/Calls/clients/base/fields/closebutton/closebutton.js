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
 * @class View.Fields.Base.Calls.ClosebuttonField
 * @alias SUGAR.App.view.fields.BaseCallsClosebuttonField
 * @extends View.Fields.Base.ClosebuttonField
 */
({
    extendsFrom: 'ClosebuttonField',

    /**
     * Status indicating that the call is closed or complete.
     *
     * @type {String}
     */
    closedStatus: 'Held',

    /**
     * @inheritDoc
     */
    showSuccessMessage: function() {
        var options = app.metadata.getModule(this.module).fields.status.options,
            strings = app.lang.getAppListStrings(options),
            status = strings[this.closedStatus].toLocaleLowerCase();

        app.alert.show('close_call_success', {
            level: 'success',
            autoClose: true,
            messages: app.lang.get('TPL_CALL_STATUS_CHANGED', this.module, {status: status})
        });
    }
})
