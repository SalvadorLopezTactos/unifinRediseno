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
 * Plugin provide way for fields to handle events specified in metadata.
 * You can specify those events in metadata as:
 *
 */
(function(app) {
    app.events.on('app:init', function() {
        app.plugins.register('FocusDrawer', ['field'], {
            /**
             * Stores whether the field should currently provide access to the
             * focus drawer
             */
            focusEnabled: false,

            /**
             * Stores user license types needed for using the focus drawer
             */
            validFocusLicenses: ['SUGAR_SELL', 'SUGAR_SERVE'],

            /**
             * When attaching the plugin, listen for the render event and add the icon if the option is set.
             */
            onAttach: function(component) {
                component.on('render', function() {
                    this.focusEnabled = this.checkFocusAvailability();
                    if (this.focusEnabled) {
                        this.initFocusIcon();
                    }
                });
            },

            /**
             * Determines whether the focus drawer is currently available to use
             * in this field
             * @return {boolean} true if the focus drawer is available; false otherwise
             */
            checkFocusAvailability: function() {
                // Check that the focus drawer has not been globally disabled in config
                var focusDrawerIsEnabled = app.utils.isTruthy(app.config.enableLinkToDrawer);

                // Check that the user has a valid license for using the focus drawer
                var userHasValidFocusLicense = !_.isEmpty(
                    _.intersection(this.validFocusLicenses, app.user.get('licenses'))
                );

                // Check that this field type is set up for the Focus Drawer
                var fieldIsValid = _.isFunction(this.getFocusContextModule) &&
                    _.isFunction(this.getFocusContextModelId);

                // Check that the module is set up for the Focus Drawer
                var module =  app.metadata.getModule(this.getFocusContextModule());
                var moduleIsNotBwc = !(module && app.utils.isTruthy(module.isBwcEnabled));
                var moduleHasFocusDashboard = module && app.utils.isTruthy(module.hasFocusDashboard);
                var moduleIsValid = moduleIsNotBwc && moduleHasFocusDashboard;

                // Check that the focus drawer container is available
                var focusDrawerComponentExists = this.getFocusDrawer();

                // Check that Focus Drawer icons are allowed on the layout we are on
                var layoutIsValid = this._checkLayoutFocusDrawerAccess();

                return focusDrawerIsEnabled && userHasValidFocusLicense && fieldIsValid &&
                    moduleIsValid && focusDrawerComponentExists && layoutIsValid;
            },

            /**
             * Shows the focus icon and attaches a click listener to it to open
             * the focus drawer
             */
            initFocusIcon: function() {
                var relateFieldContainer = this.$el.find('.relate-field-container');
                var focusIconContainer = relateFieldContainer.find('.focus-icon-container');
                var isContainerHidden = focusIconContainer.hasClass('hide');

                if (isContainerHidden && this.value) {
                    focusIconContainer.toggleClass('hide');
                    var focusIcon = focusIconContainer.find('.focus-icon');
                    focusIcon.click(_.bind(this.handleFocusClick, this));
                }
            },

            /**
             * Handle the focus icon being clicked
             */
            handleFocusClick: function() {
                if (this.focusEnabled) {
                    this.openFocusDrawer(this.getFocusContext());
                }
            },

            /**
             * Builds the context object to pass in to the focus drawer. Fields
             * with this plugin can implement a getFocusContextModule function
             * to specify how the context's module should be obtained, and a
             * getFocusContextModelId to specify how a context's model ID should
             * be obtained
             *
             * @return {Object} the focus context object
             */
            getFocusContext: function() {
                return {
                    layout: 'row-model-data',
                    context: {
                        layout: 'focus',
                        module: _.isFunction(this.getFocusContextModule) ? this.getFocusContextModule() : '',
                        modelId: _.isFunction(this.getFocusContextModelId) ? this.getFocusContextModelId() : ''
                    }
                };
            },

            /**
             * Open the focus drawer with the given context
             *
             * @param def the context definition to open the focus drawer with
             */
            openFocusDrawer: function(context) {
                var focusDrawer = this.getFocusDrawer();
                if (focusDrawer) {
                    // If the drawer is already open to the same context, don't
                    // reload it unnecessarily
                    var drawerIsOpen = focusDrawer.isOpen();
                    var drawerContext = focusDrawer.currentContextDef;
                    if (drawerIsOpen && _.isEqual(context, drawerContext)) {
                        return;
                    }
                    focusDrawer.open(context);
                }
            },

            /**
             * Gets a Focus Drawer component found within the ancestor layouts
             *
             * @return {Object|null} The Focus Drawer component, or null if not found
             * @private
             */
            getFocusDrawer: function() {
                if (!this.focusDrawer) {
                    var currLayout = this.view.layout;
                    while (currLayout) {
                        this.focusDrawer = currLayout.getComponent('focus-drawer');
                        if (!_.isEmpty(this.focusDrawer)) {
                            break;
                        }
                        currLayout = currLayout.layout;
                    }
                }
                return this.focusDrawer;
            },

            /**
             * Checks whether access to the Focus Drawer is forbidden by an
             * ancestor layout
             *
             * @return {boolean} false if the Focus Drawer is disabled; true otherwise
             * @private
             */
            _checkLayoutFocusDrawerAccess: function() {
                var currLayout = this.view.layout;
                while (currLayout) {
                    if (currLayout.disableFocusDrawer) {
                        return false;
                    }
                    currLayout = currLayout.layout;
                }
                return true;
            }
        });
    });
})(SUGAR.App);
