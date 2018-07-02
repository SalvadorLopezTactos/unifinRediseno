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
     * Holds the changing date value for the title
     */
    titleSelectedValues: '',

    /**
     * Holds the view's title name
     */
    titleViewNameTitle: '',

    /**
     * Holds the message part of the toggleTitle template
     */
    titleMessage: '',

    /**
     * Holds the collapsible toggle title template
     */
    toggleTitleTpl: {},

    /**
     * Local var for if Forecasts config has been set up or not
     */
    isForecastSetup: undefined,

    /**
     * Holds the moment.js date object
     * @type Moment
     */
    tpStartDate: undefined,

    /**
     * If the Fiscal Year field is displayed, this holds the reference to the field
     */
    fiscalYearField: undefined,

    /**
     * {@inheritdoc}
     */
    initialize: function(options) {
        /**
         * This is needed to make sure that this view is read only when forecasts module has been set up.
         */
        this.isForecastSetup = app.metadata.getModule('Forecasts', 'config').is_setup;
        if(!this.isForecastSetup) {
            _.each(_.first(options.meta.panels).fields, function(field) {
                if(field.name == 'timeperiod_start_date') {
                    field.click_to_edit = true;
                }
            }, this);
        }
        this._super('initialize', [options]);
        this.titleViewNameTitle = app.lang.get('LBL_FORECASTS_CONFIG_TITLE_TIMEPERIODS', 'Forecasts');
        this.titleMessage = app.lang.get('LBL_FORECASTS_CONFIG_TITLE_MESSAGE_TIMEPERIODS', 'Forecasts');
        this.toggleTitleTpl = app.template.getView('forecastsConfigHelpers.toggleTitle', 'Forecasts');
    },

    /**
     * Checks the timeperiod start date to see if it's 01/01 to know
     * if we need to display the Fiscal Year field or not
     */
    checkFiscalYearField: function() {
        // moment.js months are zero-based: 0 = January
        if (this.tpStartDate.month() !== 0 ||
            (this.tpStartDate.month() === 0 && this.tpStartDate.date() !== 1)) {
            // if the start date's month isn't Jan,
            // or it IS Jan but a date other than the 1st, add the field
            this.addFiscalYearField();
        } else if(this.fiscalYearField) {
            this.model.set({
                timeperiod_fiscal_year: null
            });
            this.removeFiscalYearField();
        }
    },

    /**
     * {@inheritdoc}
     */
    bindDataChange: function() {
        if(this.model) {
            this.model.once('change', function(model) {
                // on a fresh install with no demo data,
                // this.model has the values and the param model is undefined
                if(_.isUndefined(model)) {
                    model = this.model;
                }
            }, this);

            this.model.on('change:timeperiod_start_date', function(model) {
                this.tpStartDate = app.date(model.get('timeperiod_start_date'));
                this.checkFiscalYearField();
                this.titleSelectedValues = this.tpStartDate.formatUser(true);
                this.updateTitle();
            }, this);
        }
    },

    /**
     * Creates the fiscal-year field and adds it to the DOM
     */
    addFiscalYearField: function() {
        if(!this.fiscalYearField) {
            // set the value so the fiscal-year field chooses its first option
            // in the dropdown
            this.model.set({
                timeperiod_fiscal_year: 'current_year'
            });

            var $el = this.$('#timeperiod_start_date_subfield');
            if ($el) {
                var fiscalYearFieldMeta = _.find(this.options.meta.panels[0].fields, function(field) {
                    return field.name == 'timeperiod_fiscal_year';
                });

                fiscalYearFieldMeta = this.updateFieldMetadata(fiscalYearFieldMeta);

                var fieldSettings = {
                        view: this,
                        def: fiscalYearFieldMeta,
                        viewName: 'edit',
                        context: this.context,
                        module: this.module,
                        model: this.model,
                        meta: app.metadata.getField('enum')
                    };

                this.fiscalYearField = app.view.createField(fieldSettings);

                $el.html(this.fiscalYearField.el);
                this.fiscalYearField.render();
            }
        }
    },

    /**
     * Takes the default fiscal-year metadata and adds any dynamic values
     * Done in function form in case this field ever needs to be extended with
     * more than just 2 years
     *
     * @param {Object} fieldMeta The field's metadata
     * @returns {Object}
     */
    updateFieldMetadata: function(fieldMeta) {
        fieldMeta.startYear = this.tpStartDate.year();
        return fieldMeta;
    },

    /**
     * Disposes the fiscal-year field and removes it from the DOM
     */
    removeFiscalYearField: function() {
        this.model.set({
            timeperiod_fiscal_year: null
        });
        this.fiscalYearField.dispose();
        this.fiscalYearField = null;
        this.$('#timeperiod_start_date_subfield').html('')
    },

    /**
     * Updates the accordion toggle title
     */
    updateTitle: function() {
        var tplVars = {
            title: this.titleViewNameTitle,
            message: this.titleMessage,
            selectedValues: this.titleSelectedValues,
            viewName: 'forecastsConfigTimeperiods'
        };

        this.$('#' + this.name + 'Title').html(this.toggleTitleTpl(tplVars));
    },

    /**
     * {@inheritdocs}
     *
     * Sets up a binding to the start month dropdown to populate the day drop down on change
     *
     * @param {View.Field} field
     * @private
     */
    _renderField: function(field) {
        field = this._setUpTimeperiodConfigField(field);

        // check for all fields, if forecast is setup, set to detail/readonly mode
        if(this.isForecastSetup) {
            field.options.def.view = 'detail';
        } else if(field.name == 'timeperiod_start_date') {
            // if this is the timeperiod_start_date field and Forecasts is not setup
            field.options.def.click_to_edit = true;
        }

        this._super('_renderField', [field]);

        if (field.name == 'timeperiod_start_date') {
            if (this.isForecastSetup) {
                var year = this.model.get('timeperiod_start_date').substring(0, 4),
                    str,
                    $el;

                if (this.model.get('timeperiod_fiscal_year') === 'next_year') {
                    year++;
                }

                str = app.lang.get('LBL_FISCAL_YEAR', 'Forecasts') + ': ' + year;
                $el = this.$('#timeperiod_start_date_sublabel');
                if ($el) {
                    $el.html(str);
                }
            } else {
                this.tpStartDate = app.date(this.model.get('timeperiod_start_date'));
                this.checkFiscalYearField();
            }
        }
    },

    /**
     * {@inheritdoc}
     */
    _render: function() {
        this._super('_render');

        // add accordion-group class to wrapper $el div
        this.$el.addClass('accordion-group');
        this.updateTitle();
    },

    /**
     * Sets up the fields with the handlers needed to properly get and set their values for the timeperiods config view.
     *
     * @param {View.Field} field the field to be setup for this config view.
     * @return {*} field that has been properly setup and augmented to function for this config view.
     * @private
     */
    _setUpTimeperiodConfigField: function(field) {
        switch(field.name) {
            case "timeperiod_shown_forward":
            case "timeperiod_shown_backward":
                return this._setUpTimeperiodShowField(field);
            case "timeperiod_interval":
                return this._setUpTimeperiodIntervalBind(field);
            default:
                return field;
        }
    },

    /**
     * Sets up the timeperiod_shown_forward and timeperiod_shown_backward dropdowns to set the model and values properly
     *
     * @param {View.Field} field The field being set up.
     * @return {*} The configured field.
     * @private
     */
    _setUpTimeperiodShowField: function (field) {
        // ensure Date object gets an additional function
        field.events = _.extend({"change input":  "_updateSelection"}, field.events);
        field.bindDomChange = function() {};

        field._updateSelection = function(event) {
            var value =  $(event.currentTarget).val();
            this.def.value = value;
            this.model.set(this.name, value);
        };

        // force value to a string so hbs has helper will match the dropdown correctly
        this.model.set(field.name, this.model.get(field.name).toString(), {silent: true});

        field.def.value = this.model.get(field.name) || 1;
        return field;
    }

    ,
    /**
     * Sets up the change event on the timeperiod_interval drop down to maintain the interval selection
     * and push in the default selection for the leaf period
     *
     * @param {View.Field} field the dropdown interval field
     * @return {*}
     * @private
     */
    _setUpTimeperiodIntervalBind: function(field) {

        field.def.value = this.model.get(field.name);

        // ensure selected day functions like it should
        field.events = _.extend({"change input":  "_updateIntervals"}, field.events);
        field.bindDomChange = function() {};

        if(typeof(field.def.options) == 'string') {
            field.def.options = app.lang.getAppListStrings(field.def.options);
        }

        /**
         * function that updates the selected interval
         * @param event
         * @private
         */
        field._updateIntervals = function(event) {
            //get the timeperiod interval selector
            var selected_interval = $(event.currentTarget).val();
            this.def.value = selected_interval;
            this.model.set(this.name, selected_interval);
            this.model.set('timeperiod_leaf_interval', selected_interval == 'Annual' ? 'Quarter' : 'Month');
        }

        return field;
    }
})
