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
 * @class View.Layouts.Base.SideDrawerLayout
 * @alias SUGAR.App.view.layouts.BaseSideDrawerLayout
 * @extends View.Layout
 */
({
    /**
     * @inheritdoc
     */
    className: 'side-drawer',

    /**
     * Function to be called once drawer is closed.
     * @property {Function}
     */
    onCloseCallback: null,

    /**
     * Current drawer state: 'opening', 'idle', 'closing', ''.
     * @property {string}
     */
    currentState: '',

    /**
     * Drawer configs.
     * @property {Object}
     */
    drawerConfigs: {
        // pixels between drawer's top and nav bar's bottom
        topPixels: 0,
        // pixels between drawer's bottom and footer's top
        bottomPixels: 0,
        // drawer's right in pixel or percentage
        right: 0,
        // drawer's left in pixel or percentage
        left: '25%',
    },

    /**
     * Main content of the App.
     * @property {Object}
     */
    $main: null,

    /**
     * @inheritdoc
     */
    events: {
        'click [data-action=close]': 'close'
    },

    /**
     * Shortcuts.
     * @property {Array}
     */
    shortcuts: ['SideDrawer:Close'],

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.$main = app.$contentEl.children().first();
        this.$main.on('drawer:add.sidedrawer', _.bind(this.toggle, this));
        this.$main.on('drawer:remove.sidedrawer', _.bind(this.toggle, this));
        $(window).on('resize.sidedrawer', _.bind(this._resizeDrawer, this));

        this.before('tabbed-dashboard:switch-tab', function(params) {
            var callback = _.bind(function() {
                this._close();
                if (params.callback && _.isFunction(params.callback)) {
                    params.callback.call(this);
                }
            }, this);

            if (this.hasUnsavedChanges(callback)) {
                return false;
            }
            this._close();
            return true;
        }, this);
    },

    /**
     * Config the drawer.
     * @param {Object} [configs={}] Drawer configs.
     */
    config: function(configs) {
        configs = configs || {};
        this.drawerConfigs = _.extend({}, this.drawerConfigs, configs);
        this.$el.css('top', $('#header .navbar').outerHeight() + this.drawerConfigs.topPixels);
        this.$el.css('height', this._determineDrawerHeight());
        this.$el.css('left', this.drawerConfigs.left);
        this.$el.css('right', this.drawerConfigs.right);
    },

    /**
     * Open the specified layout or view in this drawer.
     *
     * You can pass the current context if you want the context created to be a
     * child of that current context. If you don't pass a `scope`, it will
     * create a child of the main context (`app.controller.context`).
     *
     * @param {Object} def The component definition.
     * @param {Function} onClose Callback method when the drawer closes.
     */
    open: function(def, onClose) {
        // store the callback function to be called later
        this.onCloseCallback = onClose;

        // open the drawer if not yet
        if (!this.isOpen()) {
            // Save the previous session to prevent overwriting it
            app.shortcuts.saveSession();
            app.shortcuts.createSession(this.shortcuts, this);
            this.registerShortcuts();

            this.currentState = 'opening';
            this.config();
            this.$el.show('slide', {direction: 'right'}, 300, _.bind(this.showComponent, this, def));
            this.currentState = 'idle';
        } else {
            this.showComponent(def);
        }
    },

    /**
     * Set up shortcuts for the side drawer
     */
    registerShortcuts: function() {
        // register shortcuts to close drawer
        app.shortcuts.register({
            id: 'SideDrawer:Close',
            keys: ['esc', 'mod+alt+l'],
            component: this,
            description: 'LBL_SHORTCUT_CLOSE_DRAWER',
            callOnFocus: true,
            handler: function() {
                var $closeButton = this.$('button[data-action="close"]');
                if ($closeButton.is(':visible') && !$closeButton.hasClass('disabled')) {
                    $closeButton.click();
                }
            }
        });
    },

    /**
     * Show component in this drawer.
     *
     * @param {Object} def The component definition.
     */
    showComponent: function(def) {
        // remove old content
        if (this._components.length) {
            _.each(this._components, function(component) {
                component.dispose();
            }, this);
            this._components = [];
        }

        // initialize content definition components
        this._initializeComponentsFromDefinition(def);

        var component = _.last(this._components);
        if (component) {
            // load and render new content in drawer
            component.loadData();
            component.render();
        }
    },

    /**
     * Tell if the drawer is opened.
     * @return {boolean} True if open, false if not.
     */
    isOpen: function() {
        return this.currentState !== '';
    },

    /**
     * Show/hide the drawer.
     */
    toggle: function() {
        if (this.isOpen()) {
            this.$el.toggle();
        }
    },

    /**
     * Determines if there are any unsaved changes
     *
     * @param callback the callback
     * @return boolean true if has unsaved changes, false otherwise
     */
    hasUnsavedChanges: function(callback) {
        return !this.triggerBefore('side-drawer:close', {callback: callback});
    },

    /**
     * Check if it's okay to close the drawer before doing so.
     */
    close: function() {
        var _close = _.bind(this._close, this);
        if (this.hasUnsavedChanges(_close)) {
            return;
        }
        _close();
    },

    /**
     * Close the drawer.
     *
     * @private
     */
    _close: function() {
        this.currentState = 'closing';
        this.$el.hide('slide', {direction: 'right'}, 300);
        this.currentState = '';

        // remove drawer content
        _.each(this._components, function(component) {
            component.dispose();
        }, this);
        this._components = [];

        // execute callback
        var callbackArgs = Array.prototype.slice.call(arguments, 0);
        if (this.onCloseCallback) {
            this.onCloseCallback.apply(window, callbackArgs);
        }
        app.shortcuts.restoreSession();
    },

    /**
     * Force to create a new context and create components from the layout/view
     * definition. If the parent context is defined, make the new context as a
     * child of the parent context.
     *
     * NOTE: this function is copied from drawer.js to have consistent behavior
     *
     * @param {Object} def The layout or view definition.
     * @private
     */
    _initializeComponentsFromDefinition: function(def) {
        var parentContext;

        if (_.isUndefined(def.context)) {
            def.context = {};
        }

        if (_.isUndefined(def.context.forceNew)) {
            def.context.forceNew = true;
        }

        if (!(def.context instanceof app.Context) && def.context.parent instanceof app.Context) {
            parentContext = def.context.parent;
            // remove the `parent` property to not mess up with the context attributes.
            delete def.context.parent;
        }

        this.initComponents([def], parentContext);
    },

    /**
     * Calculate the height of the drawer
     * @return {number}
     * @private
     */
    _determineDrawerHeight: function() {
        var windowHeight = $(window).height();
        var headerHeight = $('#header .navbar').outerHeight() + this.drawerConfigs.topPixels;
        var footerHeight = $('footer').outerHeight() + this.drawerConfigs.bottomPixels;

        return windowHeight - headerHeight - footerHeight;
    },

    /**
     * Resize the height of the drawer.
     * @private
     */
    _resizeDrawer: _.throttle(function() {
        if (this.disposed) {
            return;
        }
        // resize the drawer if it is opened.
        if (this.currentState === 'idle') {
            var drawerHeight = this._determineDrawerHeight();
            this.$el.css('height', drawerHeight);
        }
    }, 300),

    /**
     * @override
     */
    _placeComponent: function(component) {
        if (this.disposed) {
            return;
        }
        this.$el.find('.drawer-content').append(component.el);
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        this.$main.off('drawer:add.sidedrawer');
        this.$main.off('drawer:remove.sidedrawer');
        $(window).off('resize.sidedrawer');
        this._super('_dispose');
    },
})
