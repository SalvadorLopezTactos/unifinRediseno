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
(function(app) {
    app.events.on('app:init', function() {
        app.plugins.register('ReportsPanel', 'view', {
            _panelEventMapping: {
                'rows-columns': 'report:data:table:loaded',
                'summation': 'report:data:table:loaded',
                'summation-details': 'report:data:table:loaded',
                'matrix': 'report:data:table:loaded',
                'report-chart': 'report:data:chart:loaded',
                'report-filters': 'report:data:filters:loaded',
            },

            /**
             * Run when the ReportsPanel plugin is attached.
             */
            onAttach: function() {
                if (_.isFunction(this._beforeInit)) {
                    this._beforeInit();
                }

                this.listenTo(this, 'init', function() {
                    if (_.isFunction(this._initProperties)) {
                        this._initProperties();
                    }

                    const dataLoadedEvent = this._panelEventMapping[this.name];
                    const refreshEventName = 'report:refresh';

                    this.listenTo(this.context, dataLoadedEvent, this._showLoadingScreen, this);
                    this.listenTo(this.context, refreshEventName, this._loadReportPanelData, this);

                    if (_.isFunction(this._registerEvents)) {
                        this._registerEvents();
                    }

                    this._loadReportPanelData();
                }, this);

                this.listenTo(this, 'render', function() {
                    if (this.context.get('previewMode')) {
                        if (_.isFunction(this._setupPreviewReportPanel) && !this._previewModeLoaded) {
                            this._previewModeLoaded = true;
                            this._setupPreviewReportPanel();
                        }

                        this._showLoadingScreen(false);
                    }
                }, this);
            },

            /**
             * Load Reports Data and feed it to the table
             * If we are on preview mode we just feed the data
             */
            _loadReportPanelData: function() {
                if (this.context.get('previewMode')) {
                    return;
                }

                if (_.isFunction(this._loadReportData)) {
                    this._loadReportData();
                }
            },

            /**
             * Create custom filters
             *
             * @param {Object} customOptions
             * @param {string} stateKey
             *
             * @return {Object}
             */
            _getCustomFiltersMeta: function(customOptions, stateKey) {
                let filters = {};

                if (!customOptions) {
                    return filters;
                }

                if (_.has(customOptions, 'filtersDef') && customOptions.filtersDef) {
                    filters = customOptions.filtersDef;
                }

                if (!stateKey) {
                    return filters;
                }

                const lastState = app.user.lastState.get(stateKey);

                if (_.has(lastState, 'filtersDef')) {
                    filters = lastState.filtersDef;
                }

                return filters;
            },

            /**
             * Generate custom meta for report def
             *
             * @param {Object} customReportDef
             * @param {string} lastStateKey
             *
             * @return {Object}
             */
            _getCustomReportMeta: function(customReportDef, lastStateKey) {
                let customMeta = {};

                if (customReportDef) {
                    if (_.has(customReportDef, 'summaryColumns') && !_.isEmpty(customReportDef.summaryColumns)) {
                        customMeta.summaryColumns = customReportDef.summaryColumns;
                    }

                    if (_.has(customReportDef, 'displayColumns') && !_.isEmpty(customReportDef.displayColumns)) {
                        customMeta.displayColumns = customReportDef.displayColumns;
                    }

                    if (_.has(customReportDef, 'fullTableList') && !_.isEmpty(customReportDef.fullTableList)) {
                        customMeta.fullTableList = customReportDef.fullTableList;
                    }

                    if (_.has(customReportDef, 'groupDefs') && !_.isEmpty(customReportDef.groupDefs)) {
                        customMeta.groupDefs = customReportDef.groupDefs;
                    }
                }

                customMeta.filtersDef = this._getCustomFiltersMeta(customReportDef, lastStateKey);

                return customMeta;
            },

            /**
             * Adjust the loading screen width programatically based on the parent width
             *
             * @param {string} loadingElementType
             */
            _adjustLoadingWidgetSize: function(loadingElementType) {
                if (this.disposed) {
                    return;
                }

                const loadingWidget = this.$el
                                    .parentsUntil('.grid-stack-item')
                                    .find(`[data-widget=report-loading][data-type=${loadingElementType}]`);

                const loadingWidgetParent = loadingWidget.parent();
                const loadingWidetParentWidth = loadingWidgetParent.width();
                const loadingWidetParenHeight = loadingWidgetParent.height();

                if (loadingWidetParentWidth && loadingWidetParentWidth > 0 && loadingWidetParenHeight > 0) {
                    loadingWidget.width(loadingWidetParentWidth);
                    loadingWidget.height(loadingWidetParenHeight);
                }
            },

            /**
             * Show/Hide the loading screen
             *
             * @param {boolean} show
             * @param {string} type
             */
            _showLoadingScreen: function(show, type = false) {
                if (this.disposed) {
                    return;
                }

                let loadingEl;

                if (type) {
                    loadingEl = this.$el
                        .parentsUntil('.grid-stack-item')
                        .find(`[data-widget=report-loading][data-type=${type}]`);
                } else {
                    loadingEl = this.$el
                        .parentsUntil('.grid-stack-item')
                        .find('[data-widget=report-loading]');
                }

                if (show && _.isBoolean(show)) {
                    loadingEl.show();

                    if (_.isFunction(this._showAdditionalComponents)) {
                        this._showAdditionalComponents();
                    }
                } else {
                    loadingEl.hide();

                    if (_.isFunction(this._hideAdditionalComponents)) {
                        this._hideAdditionalComponents();
                    }
                }
            },
        });
    });
})(SUGAR.App);
