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
    /**
     * Controller manages the loading and unloading of layouts within the app.
     *
     * **Extending controller**
     *
     * Application may choose to extend the controller to provide custom implementation.
     * Your custom controller class name should be capiltalized {@link Config#appId} followed by `Controller` word.
     * <pre><code>
     * (function(app) {
     *
     *     app.PortalController = app.Controller.extend({
     *
     *         loadView: function(params) {
     *            // Custom implementation of loadView
     *
     *            // Should you need to call super method:
     *            app.Controller.prototype.loadView.call(this, params);
     *         }
     *
     *     });
     *
     * })(SUGAR.App);
     * </code></pre>
     *
     * @class Core.Controller
     * @alias SUGAR.App.controller
     * @singleton
     */
    var Controller = Backbone.View.extend({
        /**
         * Initializes this controller.
         * @private
         * @constructor
         * @ignore
         */
        initialize: function() {
            /**
             * The primary context of the app.
             * This context is associated with the root layout.
             * @property {Core.Context}
             */
            this.context = app.context.getContext();

            app.events.on("app:sync:complete", function() {
                app.api.setStateProperty("loadingAfterSync", true);
                _.each(app.additionalComponents, function(component) {
                    if (component && _.isFunction(component._setLabels)) {
                        component._setLabels();
                    }
                    component.render();
                });
                app.router.start();
                app.api.clearStateProperty("loadingAfterSync");
            });

            app.events.on("app:login:success", function() {
                app.sync();
            });
        },

        /**
         * Loads a view (layout).
         *
         * This method is called by the router when the route is changed.
         *
         * @param {Object} params Options that determine the current context and the view to load.

         * - id: ID of the record to load (optional)
         * - module: module name
         * - layout: Name of the layout to load
         */
        loadView: function(params) {

            var oldLayout = this.layout;

            //FIXME SC-5124 will remove 'app:view:load', to use 'app:view:change' instead.
            if (!app.triggerBefore('app:view:change') || !app.triggerBefore('app:view:load')) {
                return;
            }

            // Reset context and initialize it with new params
            this.context.clear({silent: true});
            this.context.set(params);

            // Prepare model and collection
            this.context.prepare();
            // Create an instance of the layout and bind it to the data instance
            this.layout = app.view.createLayout({
                name: params.layout,
                module: params.module,
                context: this.context
            });

            if (oldLayout) {
                // Take out the previous layout element from the content container,
                // and then keep it in the document fragment
                // in order to destroy jQuery plugin safe.
                var oldLayoutEl = document.createDocumentFragment();
                oldLayoutEl.appendChild(oldLayout.el);
            }

            // Render the layout to the main element
            // Since the previous element is already gone,
            // .append is better way because .html requires
            // additional cost for .empty().
            app.$contentEl.append(this.layout.$el);

            //initialize subcomponents in the layout
            this.layout.initComponents();

            // Fetch the data, the layout will be rendered when fetch completes
            if(!params || (params && !params.skipFetch)) {
                this.layout.loadData();
            }

            // Render the layout with empty data
            this.layout.render();

            if (oldLayout) {
                oldLayout.dispose();
            }

            app.trigger("app:view:change", params.layout, params);
        },

        /**
         * Creates, renders, and registers within the app additional components.
         */
        loadAdditionalComponents: function(components) {
            // Unload components that may be loaded previously
            _.each(app.additionalComponents, function(component) {
                if (component) {
                    component.remove();
                    component.dispose();
                }
            });
            app.additionalComponents = {};
            _.each(components, function(component, name) {
                if(component.target) {
                    var $el = this.$(component.target);
                    if(component.layout) {
                        if (!$el.get(0)) {
                            app.logger.error('Unable to place additional component "' + name + '": the target specified does not exist.');
                            return;
                        }
                        app.additionalComponents[name] = app.view.createLayout({
                            context: this.context,
                            name: component.layout,
                            el: $el
                        });
                        app.additionalComponents[name].initComponents();
                    } else {
                        app.additionalComponents[name] = app.view.createView({
                            name: component.view || name,
                            context: this.context,
                            el: $el
                        });
                    }
                    app.additionalComponents[name].render();
                } else {
                    app.logger.error('Unable to place additional component "' + name + '": no target specified.');
                }
            });
        }
    });

    app.augment("Controller", Controller, false);

    app.events.on("app:init", function(app) {
        app.controller.setElement(app.$rootEl);
    }, app.controller).on("app:start", function(app) {
        app.controller.loadAdditionalComponents(app.config.additionalComponents);
    });

})(SUGAR.App);
