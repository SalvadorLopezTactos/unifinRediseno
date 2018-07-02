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
 * @class View.Fields.Base.RevenueLineItems.ConvertToQuoteField
 * @alias SUGAR.App.view.fields.BaseRevenueLineItemsConvertToQuoteField
 * @extends View.Fields.Base.RowactionField
 */
({
    extendsFrom: 'RowactionField',

    /**
     * @inheritdoc
     *
     * @param {Object} options
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.type = 'rowaction';

        this.context.on('button:convert_to_quote:click', this.convertToQuote, this);
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this.model.on('sync', this._toggleDisable, this);
        this.model.on('change:quote_id', this._toggleDisable, this);
    },

    /**
     * convert RLI to quote
     * @param {Object} e
     */
    convertToQuote: function(e) {
        // if product template is empty, but category is not, this RLI can not be converted to a quote
        if (_.isEmpty(this.model.get('product_template_id')) && !_.isEmpty(this.model.get('category_id'))) {
            app.alert.show('invalid_items', {
                level: 'error',
                title: app.lang.get('LBL_ALERT_TITLE_ERROR', this.module) + ':',
                messages: [app.lang.get('LBL_CONVERT_INVALID_RLI_PRODUCT', this.module)]
            });
            return;
        }

        var alert = app.alert.show('info_quote', {
            level: 'info',
            autoClose: false,
            closeable: false,
            title: app.lang.get('LBL_CONVERT_TO_QUOTE_INFO', this.module) + ':',
            messages: [app.lang.get('LBL_CONVERT_TO_QUOTE_INFO_MESSAGE', this.module)]
        });

        var url = app.api.buildURL(this.model.module, 'quote', { id: this.model.id }),
            callbacks = {
                'success': _.bind(function(resp) {
                    app.alert.dismiss('info_quote');
                    app.router.navigate(app.bwc.buildRoute('Quotes', resp.id, 'EditView', {
                        return_module: this.model.module,
                        return_id: this.model.id
                    }), {trigger: true});
                }, this),
                'error': _.bind(function() {
                    app.alert.dismiss('info_quote');
                    app.alert.show('error_xhr', {
                        level: 'error',
                        title: app.lang.get('LBL_CONVERT_TO_QUOTE_ERROR', this.module) + ':',
                        messages: [app.lang.get('LBL_CONVERT_TO_QUOTE_ERROR_MESSAGE', this.module)]
                    });
                }, this)
            };
        app.api.call('create', url, null, callbacks);
    },

    /**
     * Reusable method for the event actions
     *
     * @private
     */
    _toggleDisable: function() {
        var quote_id = this.model.get('quote_id');
        this.setDisabled(!(_.isUndefined(quote_id) || _.isEmpty(quote_id)));
    }
})
