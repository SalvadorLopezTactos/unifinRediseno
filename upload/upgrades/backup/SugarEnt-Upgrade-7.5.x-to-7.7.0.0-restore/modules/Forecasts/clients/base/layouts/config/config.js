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
({
    /**
     * {@inheritdocs}
     */
    initialize: function(options) {
        var acls = app.user.getAcls().Forecasts,
            hasAccess = (!_.has(acls, 'access') || acls.access == 'yes'),
            isSysAdmin = (app.user.get('type') == 'admin'),
            isDev = (!_.has(acls, 'developer') || acls.developer == 'yes'),
            // check if Sales Stage Won/Lost are ok to continue
            loadConfigOK = app.utils.checkForecastConfig(),
            // if user has access AND is a System Admin OR has a Developer role
            loadConfigAccess = (hasAccess && (isSysAdmin || isDev));

        if(loadConfigOK && loadConfigAccess) {
            if(options && options.context && options.context.has('model')) {
                // make sure the model being passed to all config views has the latest metadata
                options.context.get('model').set(app.metadata.getModule('Forecasts', 'config'));
            }
            // initialize
            this._super('initialize', [options]);
            // load the data
            this._super('loadData');
        } else if(!loadConfigOK) {
            this.codeBlockForecasts('LBL_FORECASTS_MISSING_STAGE_TITLE', 'LBL_FORECASTS_MISSING_SALES_STAGE_VALUES');
        } else {
            this.codeBlockForecasts('LBL_FORECASTS_NO_ACCESS_TO_CFG_TITLE', 'LBL_FORECASTS_NO_ACCESS_TO_CFG_MSG');
        }
    },

    /**
     * Blocks forecasts from continuing to load
     */
    codeBlockForecasts: function(title, msg) {
        var alert = app.alert.show('no_access_to_forecasts', {
            level: 'error',
            title: app.lang.get(title, 'Forecasts') + ':',
            messages: [app.lang.get(msg, 'Forecasts')]
        });

        var $close = alert.getCloseSelector();
        $close.on('click', function() {
            $close.off();
            app.router.navigate('#Home', {trigger: true});
        });
        app.accessibility.run($close, 'click');
    },

    /**
     * Overrides loadData to defer it running until we call it in _onceInitSelectedUser
     *
     * @override
     */
    loadData: function() {
    }
})
