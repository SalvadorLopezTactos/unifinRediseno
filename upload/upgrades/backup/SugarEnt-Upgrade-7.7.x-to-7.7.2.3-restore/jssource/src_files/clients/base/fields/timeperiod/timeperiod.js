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
 * @class View.Fields.Base.SelectionField
 * @alias SUGAR.App.view.fields.BaseTimeperiodField
 * @extends View.Fields.Base.EnumField
 */
({
    /**
     * Who we should extend
     */
    extendsFrom: 'EnumField',

    /**
     * Plugins
     */
    plugins: ['EllipsisInline', 'Tooltip'],

    /**
     * The template for the tooltip
     */
    tooltipTemplate: '',

    /**
     * Mapping of ID's with the start ane end dates formatted for use when the tooltip is displayed
     */
    tpTooltipMap: {},

    /**
     * The selector we use to find the dropdown since it's appended to the body and not the current element
     */
    cssClassSelector: '',

    /**
     * Flag to use if Select2 tries to format the tooltips before timeperiod data returns from the server
     */
    updateDefaultTooltip: false,

    /**
     * Tooltip placement direction for the template
     */
    tooltipDir: 'right',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        if (app.lang.direction === 'rtl') {
            this.tooltipDir = 'left';
        }


        var collectionParams = {
            limit: 100,
            params: {}
        };

        this._super('initialize', [options]);

        if (this.def.use_generic_timeperiods) {
            collectionParams.params.use_generic_timeperiods = true;
        }

        /**
         * Collection for fetching all the Timeperiods.
         *
         * @property {Data.BeanCollection}
         */
        this.tpCollection = app.data.createBeanCollection('TimePeriods');
        this.tpCollection.once('reset', this.formatTooltips, this);
        this.tpCollection.on('sync', this.render, this);
        this.tpCollection.fetch(collectionParams);

        // load the tooltip template
        this.tooltipTemplate = app.template.getField('timeperiod', 'tooltip', this.module);

        // if forecast is not setup, then we need to use the generic options
        var config = app.metadata.getModule('Forecasts', 'config');
        if (!config || config.is_setup === 0) {
            this.def.options = 'generic_timeperiod_options';
        }
    },

    /**
     * @inheritdoc
     *
     * Add a change event handler for initializing all the plugin tooltips again
     */
    bindDataChange: function() {
        this._super("bindDataChange");
        if (this.model) {
            // when the value changes on the model, we need to initialize the Tooltips again
            this.model.on('change:' + this.name, function() {
                this.initializeAllPluginTooltips();
            }, this);
        }
    },

    /**
     * Utility method to take the TimePeriod collection and parse our the start and end dates to be in the user
     * date preference and store them for when the enum is actually opened
     * @param data
     */
    formatTooltips: function(data) {
        var usersDatePrefs = app.user.getPreference('datepref');
        data.each(function(model) {
          this.tpTooltipMap[model.id] = {
              start :app.date.format(app.date.parse(model.get('start_date')), usersDatePrefs),
              end: app.date.format(app.date.parse(model.get('end_date')), usersDatePrefs)
          }
        }, this);
        // since we don't need it any more, destroy it
        this._destroyTplCollection();

        if(this.updateDefaultTooltip) {
            this.updateDefaultTooltip = false;
            // manually update the default selected item's tooltip
            var tooltipText = app.lang.get('LBL_DROPDOWN_TOOLTIP', 'TimePeriods', this.tpTooltipMap[this.value[0]]);
            this.$('[rel="tooltip"]').attr('data-original-title', tooltipText);
        }
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        this._super("_render");
        if (this.tplName == 'noaccess') {
            return this;
        }

        var $el = this.$(this.fieldTag);
        $el.on('select2-selected', _.bind(this.onSelectClear, this));
        $el.on('select2-open', _.bind(this.onSelectOpen, this));
        $el.on('select2-close', _.bind(this.onSelectClear, this));

        this.initializeAllPluginTooltips();

        return this;
    },

    /**
     * On select open, we need to bind the tool tips
     */
    onSelectOpen: function() {
        var $el = $('div.' + this.cssClassSelector);
        this.removePluginTooltips();
        this.addPluginTooltips($el);
    },

    /**
     * When an item is selected of or the select is closed, we need to clean up the tool tips
     */
    onSelectClear: function() {
        var $el = $('div.' + this.cssClassSelector);
        this.removePluginTooltips($el);
        this.addPluginTooltips();
    },

    /**
     * @inheritdoc
     */
    getSelect2Options: function(optionsKeys) {
        var options = this._super("getSelect2Options", [optionsKeys]);

        // this is to format the results
        options.formatResult = _.bind(this.formatOption, this);

        // this is to format the currently selected option
        options.formatSelection = _.bind(this.formatOption, this);

        if (_.isEmpty(options.dropdownCssClass)) {
            options.dropdownCssClass = 'select2-timeperiod-dropdown-' + this.cid;
        }

        this.cssClassSelector = options.dropdownCssClass;

        return options;
    },

    /**
     * Format Option for the results and the selected option to bind the tool tip data into the html
     * that gets output
     *
     * @param {Object} object
     * @return {string}
     */
    formatOption: function(object) {
        // check once if the tpTooltipMap has been built yet
        this.updateDefaultTooltip = _.isUndefined(this.tpTooltipMap[object.id]);
        return this.tooltipTemplate({
            tooltip: this.tpTooltipMap[object.id],
            value: object.text,
            tooltipDir: this.tooltipDir
        });
    },

    /**
     * Disposes the {@link #tplCollection} properly.
     *
     * @private
     */
    _destroyTplCollection: function() {
        if (this.tpCollection) {
            this.tpCollection.off(null, null, this);
            this.tplCollection = null;
        }
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        this._destroyTplCollection();
        this._super('_dispose');
    }
})
