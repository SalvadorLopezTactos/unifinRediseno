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
 * @class View.Views.Base.AdministrationCspSettingHeaderView
 * @alias SUGAR.App.view.views.BaseCspSettingHeaderView
 * @extends View.Views.Base.ConfigHeaderButtonsView
 */
({
    extendsFrom: 'ConfigHeaderButtonsView',

    /**
     * Disable the save button.
     *
     * @inheritdoc
     */
    render: function(options) {
        this._super('render', options);
        this.enableButton(true);
    },

    /**
     * Trigger save process.
     *
     * @inheritdoc
     */
    saveConfig: function() {
        this.context.trigger('save:cspdefaultsrc');
    },

    /**
     * Toggle the save button enabled/disabled state.
     *
     * @param {boolean} flag True for enabling the button.
     */
    enableButton: function(flag) {
        this.getField('save_button').setDisabled(!flag);
    }
});
