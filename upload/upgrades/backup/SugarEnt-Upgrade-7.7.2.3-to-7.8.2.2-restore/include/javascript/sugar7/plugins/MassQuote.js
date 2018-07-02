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
(function(app) {
    app.events.on("app:init", function() {

        /**
         * This plugin enables mass-quoting for RevenueLineItems (for use in Opps and QLIs)
         */
        app.plugins.register('MassQuote', ["view"], {
            /**
             * Attach code for when the plugin is registered on a view
             *
             * @param component
             * @param plugin
             */
            onAttach: function(component, plugin) {
                this.once('init', function() {
                    this.layout.on("list:massquote:fire", this.massQuote, this);
                }, this);
            },

            /**
             * Logic to convert multiple Revenue Line Items into a Quote
             */
            massQuote: function() {
                this.hideAll();
                var massQuote = this.context.get("mass_collection"),
                    options = {},
                    callbacks = {},
                    errors = {
                        'LBL_CONVERT_INVALID_RLI_PRODUCT_PLURAL': [],
                        'LBL_CONVERT_INVALID_RLI_ALREADYQUOTED_PLURAL': []
                    };

                // find any blockers
                var invalidItems = massQuote.filter(function(model) {
                    // if product template is empty, but category is not, this RLI can not be converted to a quote
                    if (_.isEmpty(model.get('product_template_id')) && !_.isEmpty(model.get('category_id'))) {
                        errors['LBL_CONVERT_INVALID_RLI_PRODUCT_PLURAL'].push(model);
                        return true;
                    } else if (!_.isEmpty(model.get('quote_id'))) {
                        errors['LBL_CONVERT_INVALID_RLI_ALREADYQUOTED_PLURAL'].push(model);
                        return true;
                    }

                    // we don't want valid items in this array
                    return false;
                }, this);

                if (!_.isEmpty(invalidItems)) {
                    var messageTpl = app.template.getView('massupdate.invalid_link', this.module);

                    _.each(errors, function(val, key) {
                        if(val.length != 0) {
                            var messages = [];

                            messages.push(app.lang.get(key, this.module) + '<br>');

                            _.each(val, function(item) {
                                messages.push(messageTpl(item.attributes));
                            });

                            app.alert.show(('invalid_items_' + key), {
                                level: 'error',
                                title: app.lang.get('LBL_ALERT_TITLE_ERROR', this.module) + ':',
                                messages: messages,
                                onLinkClick: function() {
                                    app.alert.dismiss('invalid_items_' + key);
                                }
                            });
                        }
                    }, this);

                    return;
                }

                if (massQuote) {
                    var alert = app.alert.show('info_quote', {
                        level: 'info',
                        autoClose: false,
                        closeable: false,
                        title: app.lang.get("LBL_CONVERT_TO_QUOTE_INFO", this.module) + ":",
                        messages: [app.lang.get("LBL_CONVERT_TO_QUOTE_INFO_MESSAGE", this.module)]
                    });
                    alert.$('a.close').remove();

                    var url = app.api.buildURL(this.context.get('module'), 'multi-quote');

                    // custom success handler
                    options.success = _.bind(function(model, data, options) {
                        app.alert.dismiss('info_quote');
                        app.router.navigate(app.bwc.buildRoute('Quotes', data.id, 'EditView', {
                            return_module: this.context.parent.get('module'),
                            return_id: this.context.parent.get('model').get('id')
                        }), {trigger: true});
                    }, this);
                    options.error = _.bind(function() {
                        app.alert.dismiss('info_quote');
                        app.alert.show('error_xhr', {
                            level: 'error',
                            title: app.lang.get("LBL_CONVERT_TO_QUOTE_ERROR", this.context.module) + ":",
                            messages: [app.lang.get("LBL_CONVERT_TO_QUOTE_ERROR_MESSAGE", this.context.module)]
                        });
                    }, this);

                    var data = {
                        'records': massQuote.pluck('id'),
                        'opportunity_id': this.context.parent.get('model').get('id'),
                        'account_id': this.context.parent.get('model').get('account_id')
                    };

                    callbacks = app.data.getSyncCallbacks('create', massQuote, options);
                    app.api.call("create", url, data, callbacks);
                }
            }
        });
    });
})(SUGAR.App);
