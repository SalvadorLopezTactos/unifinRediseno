/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Layouts.Home.RecordLayout
 * @alias SUGAR.App.view.Layouts.HomeRecordLayout
 * @extends View.Views.Base.RecordLayout
 */
({
    extendsFrom: 'RecordLayout',

    /**
     * @inheritdoc
     */
    initComponents: function(components, context, module) {
        this._super('initComponents', [components, context, module]);
        var sidebar = this.getComponent('sidebar');
        // close side-pance since there it has no content in Home module
        if (sidebar) {
            sidebar.toggleSidePane(false);
        }
    }
})

