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
 * Custom Subpanel Layout for Revenue Line Items.
 *
 * @class View.Views.Base.RevenueLineItems.SubpanelForOpportunitiesCreate
 * @alias SUGAR.App.view.views.BaseRevenueLineItemsSubpanelForOpportunitiesCreate
 * @extends View.Views.Base.SubpanelListCreateView
 */
({
    extendsFrom: 'SubpanelListCreateView',

    initialize: function(options) {
        // From SS-492: This allows the RLI subpanel on Opportunities/create to pick up the layout from the out-of-the-
        // box RLI subpanel in Studio. It swaps the metadata, and then initializes the RLI subpanel on
        // Opportunities/create with the new metadata. It will only use the RLI subpanel metadata if it exists;
        // otherwise it'll use the metadata found in this folder (in the associated php file). Since creating an
        // Opportunity does not make any requests to the server, this functionality needs to take place in the client.
        var subpanelLayouts = app.metadata.getModule('Opportunities').layouts.subpanels.meta.components;
        var rliSubpanelLayout = _.chain(subpanelLayouts)
            .filter(function(e) {
                return e.context.link === 'revenuelineitems';
            })
            .first()
            .value();
        var rliSubpanelViewName = _.property('override_subpanel_list_view')(rliSubpanelLayout);
        var rliModuleViews = app.metadata.getModule('RevenueLineItems').views;

        if (!_.isEmpty(rliSubpanelViewName)) {
            var customRliSubpanelViewDefs = _.property(rliSubpanelViewName)(rliModuleViews);

            if (!_.isEmpty(customRliSubpanelViewDefs)) {
                var subpanelFields = _.first(customRliSubpanelViewDefs.meta.panels).fields;
                _.first(options.meta.panels).fields = subpanelFields;
            }
        }

        this._super('initialize', [options]);
    },

    /**
     * Overriding to add the commit_stage field to the bean
     *
     * @inheritdoc
     */
    _addCustomFieldsToBean: function(bean, skipCurrency) {
        var dom;
        var attrs = {};
        var userCurrencyId;
        var userCurrency = app.user.getCurrency();
        var createInPreferred = userCurrency.currency_create_in_preferred;
        var currencyFields;
        var currencyFromRate;

        if (bean.has('sales_stage')) {
            dom = app.lang.getAppListStrings('sales_probability_dom');
            attrs.probability = dom[bean.get('sales_stage')];
        }

        if (skipCurrency && createInPreferred) {
            // force the line item to the user's preferred currency and rate
            attrs.currency_id = userCurrency.currency_id;
            attrs.base_rate = userCurrency.currency_rate;

            // get any currency fields on the model
            currencyFields = _.filter(this.model.fields, function(field) {
                return field.type === 'currency';
            });
            currencyFromRate = bean.get('base_rate');

            _.each(currencyFields, function(field) {
                // if the field exists on the bean, convert the value to the new rate
                // do not convert any base currency "_usdollar" fields
                if (bean.has(field.name) && field.name.indexOf('_usdollar') === -1) {
                    attrs[field.name] = app.currency.convertWithRate(
                        bean.get(field.name),
                        currencyFromRate,
                        userCurrency.currency_rate
                    );
                }
            }, this);
        } else if (!skipCurrency) {
            userCurrencyId = userCurrency.currency_id || app.currency.getBaseCurrencyId();
            attrs.currency_id = userCurrencyId;
            attrs.base_rate = app.metadata.getCurrency(userCurrencyId).conversion_rate;
        }
        attrs.catalog_service_duration_value = bean.get('service_duration_value');
        attrs.catalog_service_duration_unit = bean.get('service_duration_unit');

        var addOnToData = this.context.parent.get('addOnToData');
        if (addOnToData) {
            _.each(addOnToData, function(value, key) {
                attrs[key] = value;
            }, this);
        }

        if (!_.isEmpty(attrs)) {
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
        var catalog = this._super('parseFields');
        var forecastConfig = app.metadata.getModule('Forecasts', 'config');

        // if forecast is not setup, we need to make sure that we hide the commit_stage field
        _.each(catalog, function (group, i) {
            var filterMethod = _.isArray(group) ? 'filter' : 'pick';
            if (forecastConfig && forecastConfig.is_setup) {
                catalog[i] = _[filterMethod](group, function(fieldMeta) {
                    if (fieldMeta.name.indexOf('_case') != -1) {
                        var field = 'show_worksheet_' + fieldMeta.name.replace('_case', '');
                        return (forecastConfig[field] == 1);
                    }

                    return true;
                });
            } else {
                catalog[i] = _[filterMethod](group, function(fieldMeta) {
                    return (fieldMeta.name != 'commit_stage');
                });
            }
        });

        return catalog;
    }
})
