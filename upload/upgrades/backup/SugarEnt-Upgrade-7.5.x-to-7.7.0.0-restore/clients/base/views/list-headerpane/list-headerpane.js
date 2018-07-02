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
 * @class View.Views.Base.ListHeaderpaneView
 * @alias SUGAR.App.view.views.BaseListHeaderpaneView
 * @extends View.Views.Base.HeaderpaneView
 */
({
    extendsFrom: 'HeaderpaneView',

    initialize: function(options) {
        this._super('initialize', [options]);

        //shortcut keys
        app.shortcuts.register('List:Headerpane:Create', 'a', function() {
            var $createButton = this.$('a[name=create_button]');
            if ($createButton.is(':visible') && !$createButton.hasClass('disabled')) {
                $createButton.get(0).click();
            }
        }, this);
    }
})
