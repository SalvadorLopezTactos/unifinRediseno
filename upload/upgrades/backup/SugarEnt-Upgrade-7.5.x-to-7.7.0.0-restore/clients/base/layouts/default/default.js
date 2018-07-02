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
 * @class View.Layouts.Base.DefaultLayout
 * @alias SUGAR.App.view.layouts.BaseDefaultLayout
 * @extends View.Layout
 */
/**
 * Some events have been deprecated in 7.2 and removed.
 * List of changes:
 *
 * - `toggleSidebar` has been migrated to `sidebar:toggle`. It allows one param
 *    to indicate the state. {@link Layout.Default#toggleSidePane}
 *
 * - `openSidebar` has been removed. You can open the sidebar by triggering
 *    `sidebar:toggle` and passing `true`. Note that you can also close the
 *    sidebar by triggering `sidebar:toggle` and passing `false`.
 *
 * - `toggleSidebarArrows` has been removed. Trigger `sidebar:state:changed`
 *    with the value `open` or `close` instead.
 *
 * - `openSidebarArrows` has been removed. Trigger `sidebar:state:changed` with
 *    the value `open` instead.
 */
({
    className: 'row-fluid',

    /**
     * Name of the last state.
     *
     * @cfg {String}
     */
    HIDE_KEY: 'hide',

    /**
     * Key for storing the last state.
     *
     * @type {String}
     * @protected
     */
    _hideLastStateKey: null,

    /**
     * @inheritDoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        this.processDef();

        this.on('sidebar:toggle', this.toggleSidePane, this);

        this.meta.last_state = this.meta.last_state || { id: 'default' };

        this._hideLastStateKey = app.user.lastState.key(this.HIDE_KEY, this);

        //Update the panel to be open or closed depending on how user left it last
        this._toggleVisibility(this.isSidePaneVisible());
    },

    /**
     * Check wether the side pane is currently visible.
     *
     * @return {Boolean} `true` if visible, `false` otherwise.
     */
    isSidePaneVisible: function() {
        var hideLastState = app.user.lastState.get(this._hideLastStateKey);
        return _.isUndefined(hideLastState);
    },

    /**
     * Toggle sidebar and save the current state.
     *
     * Only the hidden state is stored. That means the side pane is `visible` by
     * default. In case it was hidden and we make it visible, the entry from the
     * cache is removed.
     *
     * @param {Boolean} [visible] Pass `true` to show the sidepane, `false` to
     *  hide it, otherwise will toggle the current state.
     */
    toggleSidePane: function(visible) {
        var isVisible = this.isSidePaneVisible();

        visible = _.isUndefined(visible) ? !isVisible : visible;

        if (isVisible === visible) {
            return;
        }

        if (visible) {
            app.user.lastState.remove(this._hideLastStateKey);
        } else {
            app.user.lastState.set(this._hideLastStateKey, 1);
        }

        this._toggleVisibility(visible);
    },

    /**
     * Toggle visibility of the side pane.
     *
     * Toggling visibility can affect the content width in the same way as a
     * window resize. Thus we will trigger window `resize` so that any content
     * listening for a window `resize` can readjust themselves.
     *
     * @param {Boolean} visible `true` to show the side pane, `false` otherwise.
     * @private
     */
    _toggleVisibility: function(visible) {
        this.$('.main-pane').toggleClass('span12', !visible).toggleClass('span8', visible);

        this.$('.side').toggleClass('side-collapsed', !visible);

        $(window).trigger('resize');

        this.trigger('sidebar:state:changed', visible ? 'open' : 'close');
    },

    /**
     * Read the metadata and set the size of each pane.
     */
    processDef: function() {
        this.$('.main-pane').addClass('span' + this.meta.components[0]['layout'].span);
        this.$('.side').addClass('span' + this.meta.components[1]['layout'].span);
    },

    /**
     * @inheritDoc
     */
    _placeComponent: function(component) {
        if (component.meta.name) {
            this.$('.' + component.meta.name).append(component.$el);
        }
    },

    /**
     * Get the width of either the main or side pane depending upon where the
     * component resides.
     *
     * @param {View.Component} component The component.
     * @return {Number} The component width.
     */
    getPaneWidth: function(component) {
        if (!this.$el) {
            return 0;
        }
        var paneSelectors = ['.main-pane', '.side'],
            pane = _.find(paneSelectors, function(selector) {
                return ($.contains(this.$(selector).get(0), component.el));
            }, this);

        return this.$(pane).width() || 0;
    }
})
