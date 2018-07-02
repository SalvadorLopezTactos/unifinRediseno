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
 * @class View.Views.Base.DashletselectHeaderpaneView
 * @alias SUGAR.App.view.views.BaseDashletselectHeaderpaneView
 * @extends View.Views.Base.HeaderpaneView
 */
({
    extendsFrom: 'HeaderpaneView',

    events: {
        "click a[name=cancel_button]": "close"
    },

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        //shortcut keys
        app.shortcuts.register('Dashlet:Select:Cancel', ['esc','ctrl+alt+l'], function() {
            var $cancelButton = this.$('a[name=cancel_button]');
            if ($cancelButton.is(':visible') && !$cancelButton.hasClass('disabled')) {
                $cancelButton.click();
            }
        }, this, true);
    },

    /**
     * Closes the drawer.
     */
    close: function() {
        app.drawer.close();
    }
})
