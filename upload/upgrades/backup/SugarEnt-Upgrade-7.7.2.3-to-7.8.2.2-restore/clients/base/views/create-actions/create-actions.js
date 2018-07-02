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
 * @class View.Views.Base.CreateActionsView
 * @alias SUGAR.App.view.views.BaseCreateActionsView
 * @extends View.Views.Base.CreateView
 *
 * @deprecated 7.7.0 Will be removed in 7.8.0. Use
 *   {@link View.Views.Base.CreateView} instead.
 */
({
    extendsFrom: 'CreateView',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        options.meta = _.extend({}, app.metadata.getView(null, 'create-actions'), options.meta);
        this._super('initialize', [options]);
        app.logger.warn('Warning: View.Views.Base.CreateActionsView is deprecated since 7.7.0 and will be removed ' +
            'in 7.8.0. Use View.Views.Base.CreateView instead.');
    }
})
