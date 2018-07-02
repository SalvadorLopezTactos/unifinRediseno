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
 * @class View.Fields.Base.Emails.SenderField
 * @alias SUGAR.App.view.fields.BaseEmailsSenderField
 * @extends View.Fields.Base.BaseField
 */
({
    fieldTag: 'input.select2',

    initialize: function(options) {
        _.bindAll(this);
        app.view.Field.prototype.initialize.call(this, options);
        this.endpoint = this.def.endpoint;
    },

    _render: function() {
        var result = app.view.Field.prototype._render.call(this);

        if (this.tplName === 'edit') {
            var action = (this.endpoint.action) ? this.endpoint.action : null,
                attributes = (this.endpoint.attributes) ? this.endpoint.attributes : null,
                params = (this.endpoint.params) ? this.endpoint.params : null,
                myURL = app.api.buildURL(this.endpoint.module, action, attributes, params);

            app.api.call('GET', myURL, null, {
                success: this.populateValues,
                error: function(error) {
                    // display error if not a metadata refresh
                    if (error.status !== 412) {
                        app.alert.show('server-error', {
                            level: 'error',
                            messages: 'ERR_GENERIC_SERVER_ERROR'
                        });
                    }
                    app.error.handleHttpError(error);
                }
            });
        }

        return result;
    },

    populateValues: function(results) {
        var self = this,
            defaultResult,
            defaultValue = {};

        if (this.disposed === true) {
            return; //if field is already disposed, bail out
        }

        if (!_.isEmpty(results)) {
            defaultResult = _.find(results, function(result) {
                return result.default;
            });

            defaultValue = (defaultResult) ? defaultResult : results[0];

            if (!this.model.has(this.name)) {
                this.model.set(this.name, defaultValue.id);
            }
        }

        var format = function(item) {
            return item.display;
        };

        this.$(this.fieldTag).select2({
            data:{ results: results, text: 'display' },
            formatSelection: format,
            formatResult: format,
            width: '100%',
            placeholder: app.lang.get('LBL_SELECT_FROM_SENDER', this.module),
            initSelection: function(el, callback) {
                if (!_.isEmpty(defaultValue)) {
                      callback(defaultValue);
                }
            }
        }).on("change", function(e) {
            if (self.model.get(self.name) !== e.val) {
                self.model.set(self.name, e.val, {silent: true});
            }
        });
    },

    /**
     * @inheritdoc
     *
     * We need this empty so it won't affect refresh the select2 plugin
     */
    bindDomChange: function() {
    }
})
