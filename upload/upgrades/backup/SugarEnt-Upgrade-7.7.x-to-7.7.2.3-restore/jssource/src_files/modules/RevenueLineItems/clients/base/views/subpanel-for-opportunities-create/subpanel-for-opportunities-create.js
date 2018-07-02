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
 * Custom Subpanel Layout for Revenue Line Items.
 *
 * @class View.Views.Base.RevenueLineItems.SubpanelForOpportunitiesCreate
 * @alias SUGAR.App.view.views.BaseRevenueLineItemsSubpanelForOpportunitiesCreate
 * @extends View.Views.Base.SubpanelListCreateView
 */
({
    extendsFrom: 'SubpanelListCreateView',

    /**
     * @inheritdoc
     *
     * Overriding to add the commit_stage field to the bean
     *
     * @override
     */
    _addCustomFieldsToBean: function(bean) {
        if (bean.has('sales_stage')) {
            var dom = app.lang.getAppListStrings('sales_probability_dom'),
                userCurrencyId = app.user.getPreference('currency_id') || app.currency.getBaseCurrencyId(),
                attrs = {
                    probability: dom[bean.get('sales_stage')],
                    currency_id: userCurrencyId,
                    base_rate: app.metadata.getCurrency(userCurrencyId).conversion_rate
                };
            // we need to set the defaults
            bean.setDefault(attrs);
            // just to make sure that any attributes that were already set, are set again.
            bean.set(attrs);
        }

        return bean;
    },

    /**
     * We have to overwrite this method completely, since there is currently no way to completely disable
     * a field from being displayed
     *
     * @returns {{default: Array, available: Array, visible: Array, options: Array}}
     */
    parseFields : function() {
        var catalog = this._super('parseFields'),
            config = app.metadata.getModule('Forecasts', 'config'),
            isForecastSetup = config.is_setup;

        // if forecast is not setup, we need to make sure that we hide the commit_stage field
        _.each(catalog, function (group, i) {
            if (isForecastSetup) {
                catalog[i] = _.filter(group, function(fieldMeta) {
                    if (fieldMeta.name.indexOf('_case') != -1) {
                        var field = 'show_worksheet_' + fieldMeta.name.replace('_case', '');
                        return (config[field] == 1);
                    }

                    return true;
                });
            } else {
                catalog[i] = _.filter(group, function (fieldMeta) {
                    return (fieldMeta.name != 'commit_stage');
                });
            }
        });

        return catalog;
    }
})
