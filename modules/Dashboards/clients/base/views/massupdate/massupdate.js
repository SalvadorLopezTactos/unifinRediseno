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
 * @class View.Views.Base.Dashboards.MassupdateView
 * @alias SUGAR.App.view.views.BaseDashboardsMassupdateView
 * @extends View.Views.Base.MassupdateView
 */
({
    extendsFrom: 'MassupdateView',

    /**
     * Block focus drawer dashboards from being deleted
     */
    warnDelete: function() {
        var massUpdateModels = this.getMassUpdateModel(this.module).models;

        var views = _.map(massUpdateModels,  function(model) {
            return model.get('view');
        });
        if (_.contains(views, 'focus')) {
            app.alert.show('delete_confirmation', {
                level: 'warning',
                messages: app.lang.get('LBL_DELETE_FOCUS_DRAWER', this.module)
            });
            return;
        }

        this._super('warnDelete');
    },
})
