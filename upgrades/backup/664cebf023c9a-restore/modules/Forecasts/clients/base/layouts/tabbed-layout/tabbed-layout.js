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
 * @class View.Layouts.Base.Forecasts.TabbedLayoutLayout
 * @alias SUGAR.App.view.layouts.BaseForecastsTabbedLayoutLayout
 * @extends View.Layouts.Base.TabbedLayoutLayout
 */
({
    /**
     * @inheritdoc
     */
    activeTab: 0,

    /**
     * Key name for the last state
     */
    lastStateKey: 'Forecasts:last-visited-tab',

    /**
     * Selector of the a container
     */
    parentContainer: '.forecasts-main',

    /**
     * Show if Opp tab was visited
     */
    oppFirstVisit: false,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        this._initTabs();
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        this._super('_render');
        this.$('a[data-toggle="tab"]').on('shown.bs.tab', _.bind(this.tabClickHandle, this));

        const resizeDebounce = _.debounce(_.bind(this._resize, this), 50);
        $(window).on('resize.' + this.cid, resizeDebounce);
        this.listenTo(app.events, 'app:view:change', resizeDebounce);
    },

    /**
     * Change css propperties of different Forecasts elements on resize event
     */
    _resize: function() {
        const windowWidth = $(window).width();

        const main = this.$el.closest(this.parentContainer);
        const headerpane = main.find('.headerpane');
        const headerpaneHeight = headerpane.outerHeight();

        main.css({
            top: headerpaneHeight,
            height: `calc(100% - ${headerpaneHeight}px)`,
        });

        const flextList = main.find('.paginated-flex-list');
        const metrics = main.find('.forecast-metrics');
        const metricsHeight = metrics.outerHeight();

        flextList.css({
            height: `calc(100% - ${metricsHeight}px - 2rem)`,
        });

        const sidebar = $('.sidebar-content');
        sidebar.css({
            top: (windowWidth <= 768) ? `${headerpaneHeight}px` : '',
        });

        headerpane.css({
            width: (windowWidth <= 768) ? `${main.width()}px` : '',
        });
    },

    /**
     * Handler for the tab clicking
     *
     * @param {Event} e
     */
    tabClickHandle: function(e) {
        const index = $(e.currentTarget).parent('li').attr('data-tab-index');

        if (index && this.lastStateKey) {
            this.activeTab = parseInt(index);
            app.user.lastState.set(this.lastStateKey, this.activeTab);
        }

        if (this.activeTab === 1 && this.oppFirstVisit) {
            this.oppFirstVisit = false;
            //re-render to fix columns size
            this.getComponent('filterpanel')
                .getComponent('list')
                .render();
        }
    },

    /**
     * Initialize tabs
     */
    _initTabs: function() {
        const lastVisitTab = app.user.lastState.get(this.lastStateKey);

        if (!_.isUndefined(lastVisitTab)) {
            this.activeTab = parseInt(lastVisitTab);

            if (this.activeTab !== 1) {
                this.oppFirstVisit = true;
            }
        }
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        $(window).off('resize.' + this.cid);
        this.stopListening();
        this._super('_dispose');
    },
})
