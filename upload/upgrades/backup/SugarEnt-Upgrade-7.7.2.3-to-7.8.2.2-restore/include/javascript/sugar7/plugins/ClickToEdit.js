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
         * We register two plug-ins here.
         *
         * CteTabbing
         * This is a view plugin that enable a view (specifcly recordlist) to listen for events from the
         * 'ClickToEdit' plugin to support moving the editable to the next editable field or the previous one
         * depending on if shift+tab is pressed
         *
         * ClickToEdit
         * This is a field plugin that allows the field to become editable on click.  Current types that are supported:
         *  - Int
         *  - Currency
         *  - Enum
         *  - Date
         * Others may work work but have not been tested or inline validation written for them.
         */
        app.plugins.register('CteTabbing', ['view'], {

            /**
             * current index in the CTE list
             */
            currentIndex: -1,

            /**
             * current CTE list (dom elements)
             */
            currentCTEList: [],

            /**
             * Attach code for when the plugin is registered on a view
             *
             * @param component
             * @param plugin
             */
            onAttach: function(component, plugin) {
                this.once('init', function() {
                    this.context.on('field:editable:click', this.handleClickIndex, this);
                    $(window).on('keydown.' + this.cid, _.bind(function(e){
                        if (this.layout.isVisible()) {
                            this.handleKeyDown(e);
                        }
                    }, this));
                    this.on('render', this.resetCTEList, this);
                }, this);
            },

            /**
             * Detach code for when the plugin is removed from a view
             *
             * @param component
             * @param plugin
             */
            onDetach: function(component, plugin) {
                this.context.off('field:editable:click');
                $(window).off('keydown.' + this.cid);
            },

            /**
             * handles custom window keydown events
             * @param e Event object
             */
            handleKeyDown: function(e){
                //onTab
                if (e.which == 9) {
                    e.preventDefault();
                    if(!e.shiftKey){
                        if (this.currentIndex + 1 < this.currentCTEList.length) {
                            this.currentIndex++;
                        } else {
                            this.currentIndex = 0;
                        }
                    } else {
                        if (this.currentIndex - 1 >= 0) {
                            this.currentIndex--;
                        } else {
                            this.currentIndex = this.currentCTEList.length - 1;
                        }
                    }
                    $(this.currentCTEList[this.currentIndex]).find("div.clickToEdit").click();
                }
            },

            /**
             * resets the CTE list of dom elements
             */
            resetCTEList: function() {
                var oldLength = this.currentCTEList.length
                this.currentCTEList = this.$el.find('.isEditable');

                /*
                 * If the length of the CTE list changes (less rows), then most likely the cell we were on initiated
                 * that change.  We need to reset the current tab index to trigger the same cell, becuase
                 * the original one is now gone.
                 *
                 * Note: if business rules change, this will have to be revisited.
                 */
                if (oldLength > this.currentCTEList.length) {
                    this.currentIndex--;
                }
            },

            /**
             * handle setting the current index from a click
             * @param field Field that is clicked
             */
            handleClickIndex: function(field) {
                _.find(this.currentCTEList, function(el, idx, list) {
                    var $el = $(el);
                    if (_.isEqual($el.find("div.clickToEdit").data('cid'), field.cid)) {
                        this.currentIndex = idx;
                        return true;
                    }
                }, this);
            }
        });

        app.plugins.register('ClickToEdit', ['field'], {

            /**
             * Custom Events for making the ClickToEdit work on a field
             */
            events: {
                'mouseenter div.clickToEdit': 'showClickToEdit',
                'mouseleave div.clickToEdit': 'hideClickToEdit',
                'click div.clickToEdit': 'handleFieldClick'
            },

            /**
             * Are we on IE 9 or 10?
             */
            isIe9Or10: $.browser.msie &&
                ($.browser.version === '9.0' ||
                    ($.browser.version === '10.0' && !!navigator.userAgent.match(/Trident\/6\./))),

            /**
             * Can the field be edited
             */
            _canEdit: false,

            /**
             * are we currently in edit mode
             */
            _isInEdit: false,

            /**
             * Error Message
             */
            errorMessage: '',

            /**
             * Is an error currently being displayed for a field
             */
            isErrorState: false,

            /**
             * Register the plugin on a field
             *
             * @param component
             * @param plugin
             */
            onAttach: function(component, plugin) {
                this.once('init', _.bind(function() {
                    if (this.checkIfCanEdit()) {
                        this.bindPluginEvents();
                    }
                }, this));
            },

            /**
             * unregister our bindings
             */
            onDetach: function() {
                $(document).off('mousedown.record' + this.cid);
                // remove any lingering tooltip
                app.utils.tooltip.destroy(this.$('[rel=tooltip]'));
            },

            /**
             * Bind plugin events
             */
            bindPluginEvents: function() {
                this.context.on('field:editable:open', function(cid) {
                    // another CTE field has been opened
                    if (this.isErrorState) {
                        // I am open with an error, send the message
                        this.context.trigger('field:editable:error', this.cid);
                    } else if (this._isInEdit == true && this.cid !== cid) {
                        if (this.type == 'enum') {
                            this.$("select").select2("close");
                        }

                        // for the date field, this is handled when the date field gets removed below
                        if (this.type != 'date') {
                            this.setMode('list');
                        }
                    }
                }, this);
                this.context.on('field:editable:error', function(cid) {
                    if (!_.isEqual(cid, this.cid) && this.options.viewName == 'edit') {
                        // some other field is open with an error, close this
                        this.setMode('list');
                    }
                }, this);
                this.on('render', function() {
                    var cteClass = 'clickToEdit';
                    if (this.action === 'edit') {
                        cteClass += ' active';
                        this.$el.addClass('active');
                    } else {
                        this.$el.removeClass('active');
                    }
                    // only add isEditable if the field is not disabled
                    if (!this.$el.hasClass('disabled')) {
                        this.$el.addClass('isEditable');
                        this.$el.wrapInner('<div class="' + cteClass + '" data-cid="' + this.cid + '" />');
                    }
                }, this);
                if (this.context.parent) {
                    // Clears errors when navigating from the manager's forecast worksheet to the manager's RLI so that
                    // the error tooltip is not displaying when forecast worksheet is hidden.
                    this.context.parent.on('change:selectedUser', function() {
                        if (this.isErrorState) {
                            this.clearErrorDecoration();
                        }
                    }, this);
                }
            },

            /**
             * Logic to make sure that we can actually edit the field
             *
             * @return {boolean}
             */
            checkIfCanEdit: function() {
                var isEnforce = (!_.isUndefined(this.def.enforced) && this.def.enforced === true),
                    isClickToEdit = (!_.isUndefined(this.def.click_to_edit) && this.def.click_to_edit === true);
                if (!isEnforce && isClickToEdit) {
                    // only worksheet owner can edit
                    // make sure we get the correct context, if we are in the forecast module
                    // its this.context.parent otherwise, its this.context
                    var ctx = this.context.parent || this.context;
                    var selectedUser = ctx.get('selectedUser') || app.user.toJSON();
                    this._canEdit = _.isEqual(app.user.get('id'), selectedUser.id);
                    // lets make sure we can actually write to the field
                    this._canEdit = (this._canEdit &&
                                        app.acl.hasAccess('write', this.module, app.user.get('id'), this.name));

                    // only they have write access to the field and if sales stage is won/lost can edit
                    if (this._canEdit && this.model.has('sales_stage')) {
                        var salesStage = this.model.get('sales_stage'),
                            disableIfSalesStageIs = _.union(
                                app.metadata.getModule('Forecasts', 'config').sales_stage_won,
                                app.metadata.getModule('Forecasts', 'config').sales_stage_lost
                            );
                        if (salesStage && _.indexOf(disableIfSalesStageIs, salesStage) != -1) {
                            this._canEdit = false;
                        }
                    }
                }

                return this._canEdit;
            },

            /**
             * Overwrite the default bindDomChange since we need to do inline validation
             */
            bindDomChange: function() {
                if (this.type === 'date') return;   // we need to ignore the date field here

                if (!(this.model instanceof Backbone.Model)) return;

                var self = this;
                var el = this.$el.find(this.fieldTag);
                el.on("change", function() {
                    var value = self.validateField(self, el.val());
                    if (value !== false) {
                        // field is valid, save it
                        if(self.isErrorState) {
                            self.clearErrorDecoration();
                        }
                        // save to model
                        self.model.set(self.name, self.unformat(value));
                    } else {
                        // invalid display error
                        var hb = Handlebars.compile("{{str key module context}}"),
                            args = {field_name: app.lang.get(self.def.label, self.module)};

                        self.errorMessage = hb({'key': 'LBL_EDITABLE_INVALID', 'module': self.module, 'context': args});

                        self.showErrors();
                        el.select();
                    }
                });
                // Focus doesn't always change when tabbing through inputs on IE9 & IE10 (Bug54717)
                // This prevents change events from being fired appropriately on IE9 & IE10
                if(this.isIe9Or10 && el.is("input")){
                    _.defer(function(el){
                        el.on("input", function() {
                            // Set focus on input element receiving user input
                            el.focus();
                        });
                    }, el);
                }
            },

            /**
             * Show an error message if not already display
             */
            showErrors: function() {
                var $errorTooltips;
                if (this.isErrorState === false) {
                    this.isErrorState = true;

                    var ctx = this.context.parent || this.context;
                    // trigger field error on context
                    ctx.trigger('field:error', this, true);

                    this.$el.addClass('error');
                    this.$('.error-tooltip').addClass('add-on local').removeClass('hide').css('display', 'inline-block');
                    this.$('input').addClass('local-error');
                    // we want to show the tooltip message, but hide the add-on (exclamation)
                    $errorTooltips = this.$('[rel=tooltip]');
                    app.utils.tooltip.initialize($errorTooltips, {
                        title: this.errorMessage,
                        trigger: 'manual'
                    });
                    $errorTooltips.each(function() {
                        app.utils.tooltip.show(this);
                    });
                    $errorTooltips.hide();
                }
            },

            /**
             * Clear the Error
             */
            clearErrorDecoration: function() {
                app.utils.tooltip.destroy(this.$('[rel=tooltip]'));
                this.isErrorState = false;

                var ctx = this.context.parent || this.context;
                // trigger field error on context
                ctx.trigger('field:error', this, false);
                this.errorMessage = '';
            },

            /**
             * Show the click to edit icon.
             *
             * @param event
             */
            showClickToEdit: function(event) {
                if (this._canEdit && !this._isInEdit) {
                    var target = $(event.currentTarget);
                    var icon = '<span class="edit-icon"><i class="fa fa-pencil fa-sm"></i></span>';

                    // use case for currency field that show transactional value + the converted to base currency
                    if (target.has('label.original').length == 1) {
                        target = target.find('label.original').next();
                    }

                    // use case for the ellipsis_inline div
                    if (target.has('div.ellipsis_inline').length == 1) {
                        target = target.find('div.ellipsis_inline');
                    }

                    target.prepend(icon);
                }
            },

            /**
             * Hide the click to edit icon.
             *
             * @param event
             */
            hideClickToEdit: function(event) {
                if (this._canEdit && !this._isInEdit) {
                    $(event.currentTarget).find('span.edit-icon').remove();
                }
            },

            /**
             * Handle when a click event is triggered
             *
             * @param event
             */
            handleFieldClick: function(event) {
                if (this._canEdit && !this._isInEdit) {
                    this.context.trigger("field:editable:click", this);
                    this.setMode('edit');
                    if (_.isFunction(this.focus)) {
                        this.focus();
                    } else {
                        var $el = this.$(this.fieldTag + ":first");
                        $el.focus().val($el.val()).select();
                    }

                    if (this.type !== 'image') {
                        if (_.isFunction(this.bindKeyDown)) {
                            this.bindKeyDown(_.bind(this.keyDowned, this));
                        } else {
                            this.$(this.fieldTag).on("keydown.record" + this.cid, {field: this}, _.bind(this.keyDowned, this));
                        }

                        $(document).on("mousedown.record" + this.cid, {field: this}, _.bind(this.mouseClicked, this));
                    }

                    if (this.type === "enum") {
                        this.model.once('change:' + this.name, function() {
                            _.defer(_.bind(function() {
                                this.setMode('list');
                            }, this));
                        }, this);
                    }

                    if (this.type === "date") {
                        this.$el.closest('td').addClass('td-inline-edit');
                    }
                }
            },

            /**
             * Key Down Handler
             * @param evt
             */
            keyDowned: function(evt) {
                this.handleKeyDown.call(this, evt, evt.data.field);
            },

            /**
             * Mouse Click Handler
             *
             */
            mouseClicked: _.debounce(function(evt) {
                this.fieldClose.call(this, evt, evt.data.field);
            }, 0),


            /**
             * Close out the field from a mouse click
             *
             * @param evt
             * @param field
             */
            fieldClose: function(evt, field) {
                var currFieldParent = field.$el,
                    targetPlaceHolder = this.$(evt.target).parents("span[sfuuid='" + field.sfId + "']"),
                    preventPlaceholder = this.$(evt.target).closest('.prevent-mousedown');

                // When mouse clicks the document, it should maintain the edit mode within the following cases
                // - Some fields (like email) may have buttons and the mousedown event will fire before the one
                //   attached to the button is fired. As a workaround we wrap the buttons with .prevent-mousedown
                // - If mouse is clicked within the same field placeholder area
                // - If cursor is focused among the field's input elements
                if (preventPlaceholder.length > 0
                    || targetPlaceHolder.length > 0
                    || currFieldParent.find(":focus").length > 0
                    || !_.isEmpty(app.drawer._components)) {
                    return;
                }

                if (this.isErrorState) {
                    this.$el.find(this.fieldTag).focus().select();
                    return;
                }

                this.setMode('list');
            },

            /**
             * Logic behind a key down event
             *
             * @param e
             * @param field
             */
            handleKeyDown: function(e, field) {
                // if the field is already disposed, just ignore this bit of code.
                if (field.disposed) {
                    return;
                }
                if (e.which == 27) { // If esc
                    this.setMode('list');
                } else if (e.which == 13) {
                    if (this.fieldValueChanged(field)) {
                        this.model.once('change:' + field.name, function() {
                            this.setMode('list');
                        }, this);
                    } else {
                        this.setMode('list');
                    }
                }
            },

            /**
             * Did the field value change?
             * @param field
             * @returns {boolean}
             */
            fieldValueChanged: function(field) {
                // get the field value
                var elVal = field.$el.find(field.fieldTag).val();

                if (field.type == 'currency' || field.type == 'int') {
                    elVal = this._parsePercentage(elVal, (field.type == 'currency') ? undefined : 0);
                }

                if (field.type == 'currency') {
                    // for currency we want to make sure the value didn't actually change so get the difference
                    // and multiple it by 100 (2 decimals out), if it's not equal to 0, then it changed.
                    var diff = Math.abs(this.unformat(elVal) - this.unformat(field.value));
                    return ((Math.round(diff * 100)) != 0)
                } else if(field.type == 'date') {
                    if(_.isUndefined(elVal)) {
                        elVal = field.$el.find('div').html();
                    }
                    return !_.isEqual(this.unformat(elVal), this.unformat(field.value));
                } else {
                    return !_.isEqual(this.unformat(elVal), this.unformat(field.value));
                }
            },

            /**
             * Change the mode of the field
             * @param name
             */
            setMode: function(name) {
                if (name === "list") {
                    // remove handlers
                    this.$(this.fieldTag).off("keydown.record" + this.cid);
                    $(document).off("mousedown.record" + this.cid);
                }
                if (this.isErrorState) {
                    this.clearErrorDecoration();
                }
                app.view.Field.prototype.setMode.call(this, name);
                this._isInEdit = (this.action === 'edit');

                if (this._isInEdit) {
                    // trigger the event
                    this.context.trigger('field:editable:open', this.cid);
                } else {
                    this.$el.removeClass('error');
                }

                if (this.action !== 'edit' && this.type == 'date') {
                    this.$el.closest('td').removeClass('td-inline-edit');
                }
            },

            /**
             * Main validate method.
             *
             * @param field
             * @param newValue
             * @returns {*}
             */
            validateField: function(field, newValue) {

                if (_.isUndefined(newValue) || _.isEmpty(newValue)) {
                    // try to get the value again
                    newValue = this.$el.find(this.fieldTag).val();
                }

                if (field.type === 'int') {
                    // check for percentages
                    newValue = this._parsePercentage(newValue, 0);
                    if (this._verifyIntValue(newValue)) {
                        return newValue;
                    }
                } else if (field.type === 'currency') {
                    newValue = this._parsePercentage(newValue);
                    if (this._verifyCurrencyValue(newValue)) {
                        return newValue;
                    }
                } else if (field.type === 'date') {
                    if (this._verifyDateString(newValue)) {
                        return newValue;
                    }
                } else {
                    return newValue;
                }

                return false;
            },

            /**
             * Verify a currency value
             *
             * @param value
             * @returns {boolean}
             * @private
             */
            _verifyCurrencyValue: function(value) {
                // trim off any whitespace
                value = value.toString().trim();

                // matches a valid positive decimal number
                var config = app.metadata.getConfig(),
                    d_separator = app.user.getPreference('decimal_separator') || config.defaultDecimalSeparator || '.',
                    ug_separator = app.user.getPreference('number_grouping_separator'),
                    g_separator = !_.isUndefined(ug_separator) ? ug_separator : config.defaultNumberGroupingSeparator || ',',
                    currency = app.user.getPreference('currency_id') || app.currency.getBaseCurrencyId(),
                    currency_symbol = app.currency.getCurrencySymbol(currency),
                    regex = new RegExp("^(" + this._escapeRegexCharacter(currency_symbol) + ")?(([\\d]{1,3}(?:" +  this._escapeRegexCharacter(g_separator) + "?[\\d]{3})*)?((?:" + this._escapeRegexCharacter(d_separator) + "[\\d]+)))"),
                    parts = value.match(regex);

                // always make sure that we have a string here, since match only works on strings
                // make sure that value has a length, that the patch parts are not null, that parts[0] is not empty
                // and that the parts[0] is equal to what was passed in. in some cases it wont match and we should not
                // allow that value to be used
                if (value.length == 0 || _.isNull(parts)  || _.isEmpty(parts[0]) || parts[0] != value) {
                    return false;
                }

                // the value passed all validation, return true
                return true;
            },

            /**
             * Utility Method to only escape the values that need to be escaped for a RegularExpression
             * @param {String} character
             * @returns {String}
             * @private
             */
            _escapeRegexCharacter: function(character) {
                var needs_escape = ['.', '\\', '+', '*', '?', '[', '^', ']', '$',
                    '(', ')', '{', '}', '=', '!', '<', '>', '|', ':', '-'];

                if(_.indexOf(needs_escape, character) != -1) {
                    character = '\\' + character;
                }

                return character;
            },

            /**
             * Verify an Int Value
             * @param value
             * @returns {*}
             * @private
             */
            _verifyIntValue: function(value) {
                var regex = new RegExp("^\\d+$"),
                    match = value.toString().match(regex);

                // always make sure that we have a string here, since match only works on strings
                if (_.isNull(match)) {
                    return false;
                }

                if (!_.isUndefined(this.def.validation) && this.def.validation.type == 'range') {
                    // we have digits, lets make sure it's int a valid range is one is specified
                    if (!_.isUndefined(this.def.validation.min) && !_.isUndefined(this.def.validation.max)) {
                        // we have a min and max value
                        if (value < this.def.validation.min || value > this.def.validation.max) {
                            return false
                        }
                    }
                }

                // the value passed all validation, return true
                return true;
            },

            /**
             * overridden from date.js -- Forecasts must validate date before setting the model
             * whereas the base date.js field sets the model, then does validation when you save
             *
             * @param value
             * @return {Boolean}
             * @private
             */
            _verifyDateString: function(value) {
                return _.isUndefined(app.validation.validators.datetime(this, value))
            },

            /**
             * Check the value to see if it's a percentage, if it is, then adjust the value
             *
             * @param {String} value        The value we are parsing.
             * @param {Integer} (decimals)        How far to round to.
             * @return {*}
             */
            _parsePercentage: function(value, decimals) {
                var orig = this.model.get(this.name),
                    config = app.metadata.getConfig(),
                    d_separator = app.user.getPreference('decimal_separator') || config.defaultDecimalSeparator || '.',
                    ug_separator = app.user.getPreference('number_grouping_separator'),
                    g_separator = (!_.isUndefined(ug_separator)) ? ug_separator : config.defaultNumberGroupingSeparator || ',',
                    regex = new RegExp("^([+-])(([\\d]{1,3}(?:" +  this._escapeRegexCharacter(g_separator) + "[\\d]{3})*|(?:[\\d]))*((?:" + this._escapeRegexCharacter(d_separator) + "[\\d]+))?)(\\%)?"),
                    parts = value.toString().match(regex),
                    is_percent = (parts && parts[5] == "%"),
                    do_addition = (parts && parts[1] == "+"),
                    do_subtraction = (parts && parts[1] == "-");

                // if we have parts and the addition is not zero (0), if it happens to be zero it's from an input
                // like this +0,5 when you have , as your grouping and . as your decimal
                // there is a test that covers this use case in the ForecastWorksheet/currency field test
                // we also want to make sure that parts[0] is equal to the value that was passed in,
                // if it's not the same, we need to ignore this as it didn't match the full string
                if (parts && parts[0] == value && parts[2] != "0") {
                    // use original number to apply calculations
                    var amount = this.unformat(parts[2]);
                    if (is_percent) {
                        // percentage calculation
                        value = app.math.mul(app.math.div(amount, 100), orig);
                    } else {
                        // add/sub calculation
                        value = amount;
                    }
                    if (do_addition) {
                        value = app.math.add(orig, value);
                    } else if (do_subtraction) {
                        value = app.math.sub(orig, value);
                    }
                    value = app.math.round(value, decimals);
                }
                return this.format(value.toString());
            },

            /**
             * overridden from date.js -- Forecasts must validate date before setting the model
             * whereas the base date.js field sets the model, then does validation when you save
             */
            handleHideDatePicker: function() {
                var $field = this.$(this.fieldTag),
                    value = $field.val();

                // if new value is empty, revert it back to the previous value
                // to be compliant with Forecasts requisites
                if (_.isEmpty(value)) {
                    $field.val(this.format());
                    return;
                }

                value = this.unformat(value);

                if (!_.isEmpty(value)) {
                    this.model.set(this.name, value);

                    // trigger the onBlur function to set the field back to list view and render
                    this.setMode('list');
                    return;
                }
            }
        });
    });
})(SUGAR.App);
