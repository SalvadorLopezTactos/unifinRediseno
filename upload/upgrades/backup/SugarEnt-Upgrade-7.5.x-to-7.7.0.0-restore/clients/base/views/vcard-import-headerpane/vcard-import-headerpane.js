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
 * @class View.Views.Base.VcardImportHeaderpaneView
 * @alias SUGAR.App.view.views.BaseVcardImportHeaderpaneView
 * @extends View.Views.Base.HeaderpaneView
 */
({
    extendsFrom: 'HeaderpaneView',
    events:{
        'click [name=vcard_finish_button]': 'initiateFinish',
        'click [name=vcard_cancel_button]': 'initiateCancel'
    },

    initiateFinish: function() {
        this.context.trigger('vcard:import:finish');
    },

    initiateCancel : function() {
        app.drawer.close();
    }
})
