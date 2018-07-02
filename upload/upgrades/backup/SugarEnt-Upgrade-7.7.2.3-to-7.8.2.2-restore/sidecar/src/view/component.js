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
 * Represents base view class for layouts, views, and fields.
 *
 * This is an abstract class.
 *
 * @class View.Component
 * @alias SUGAR.app.view.Component
 * @extends Backbone.View
 */
(function(app) {

    app.view.Component = Backbone.View.extend({

        /**
         * Initializes a component.
         * @constructor
         * @param options
         *
         * - context
         * - meta
         * - module
         * - model
         * - collection
         *
         * `context` is the only required option.
         * @return {View.Component}
         */
        initialize: function(options) {

            /**
             * Reference to the context (required).
             * @property {Core.Context}
             */
            this.context = options.context || app.controller && app.controller.context || new Backbone.Model();

            /**
             * Component metadata (optional).
             * @property {Object}
             */
            this.meta = options.meta;

            /**
             * Module name (optional).
             * @property {String}
             */
            this.module = options.module || this.context.get("module");

            /**
             * Reference to the model this component is bound to.
             * @property {Data.Bean}
             */
            this.model = options.model || this.context.get("model");

            /**
             * Reference to the collection this component is bound to.
             * @property {Data.BeanCollection}
             */
            this.collection = options.collection || this.context.get("collection");

            // Adds classes to the component based on the metadata.
            if(this.meta && this.meta.css_class) {
                this.$el.addClass(this.meta.css_class);
            }

            this.updateVisibleState(true);

            // Register last state defaults
            app.user.lastState.register(this);
        },

        /**
         * Renders a component.
         *
         * Override this method to provide custom logic.
         * The default implementation does nothing.
         * See [Backbone.View](http://backbonejs.org/#View-render)
         * documentation for details.
         * The convention is for {@link #_render} to always return `this`.
         *
         * @return {View.Component} Instance of this component.
         *
         * @template
         * @protected
         */
        _render: function() {
            return this;
        },

        /**
         * Renders a component.
         *
         * IMPORTANT: Do not override this method.
         * Instead, override {@link View.Component#_render} to provide render logic.
         * @return {View.Component} Instance of this component.
         */
        render: function() {
            if (this.disposed === true) {
                app.logger.error("Unable to render component because it's disposed " + this + "\n");
                return false;
            }
            if(!this.triggerBefore("render"))
                return false;
            this._render();

            this.trigger("render");

            return this;
        },

        /**
         * Sets template option.
         *
         * If the given option already exists it is augmented by the value of the given `option` parameter.
         * See Handlebars.js documentation for details.
         * @param {String} key Option key.
         * @param {Object} option Option value.
         */
        setTemplateOption: function(key, option) {
            this.options = this.options || {};
            this.options.templateOptions = this.options.templateOptions || {};
            this.options.templateOptions[key] = _.extend({}, this.options.templateOptions[key], option);
        },

        /**
         * Binds data changes to this component.
         *
         * This method should be overridden by derived views.
         */
        bindDataChange: function() {
            // Override this method to wire up model/collection events
        },

        /**
         * Removes this component's event handlers from model and collection.
         *
         * Performs the opposite of what {@link View.Component#bindDataChange} method does.
         * Override this method to provide custom logic.
         */
        unbindData: function() {
            if (this.model) this.model.off(null, null, this);
            if (this.collection) this.collection.off(null, null, this);
        },

        /**
         * Removes all event callbacks registered within this component
         * and undelegates Backbone events.
         *
         * Override this method to provide custom logic.
         */
        unbind: function() {
            this.off();
            this.offBefore();
            this.undelegateEvents();
            app.events.off(null, null, this);
            app.events.unregister(this);
            if (this.context) this.context.off(null, null, this);
            if (this.layout) this.layout.off(null, null, this);
        },

        /**
         * Fetches data for layout's model or collection.
         *
         * The default implementation does nothing.
         * See {@link View.Layout#loadData} and {@link View.View#loadData} methods.
         */
        loadData: function() {
            // Do nothing (view and layout will override)
        },

        /**
         * Disposes a component.
         *
         * This method:
         *
         * - unbinds the component from model and collection.
         * - removes all event callbacks registered within this component.
         * - removes the component from the DOM.
         *
         * Override this method to provide custom logic:
         * <pre><code>
         * app.view.views.MyView = app.view.View.extend({
         *      _dispose: function() {
         *          // Perform custom clean-up. For example, clear timeout handlers, etc.
         *          ...
         *          // Call super
         *          app.view.View.prototype._dispose.call(this);
         *      }
         * });
         * </code></pre>
         * @protected
         */
        _dispose: function() {
            this.unbindData();
            this.unbind();
            this.remove();
            this.model = null;
            this.collection = null;
            this.context = null;
            this.$el = null;
            this.el = null;
        },

        /**
         * Disposes a component.
         *
         * Once the component gets disposed it can not be rendered.
         * Do not override this method. Instead override {@link View.Component#_dispose} method
         * if you need custom disposal logic.
         */
        dispose: function() {
            if (this.disposed === true) return;
            this._dispose();
            this.disposed = true;
        },

        /**
         * Gets a string representation of this component.
         * @return {String} String representation of this component.
         */
        toString: function() {
            return this.cid +
                "-" + (this.$el && this.$el.id ? this.$el.id : "<no-id>") +
                "/" + this.module +
                "/" + this.model +
                "/" + this.collection;
        },

        /**
         * Traverse upwards from the current component to find the first
         * component that matches the name.
         *
         * The default implementation does nothing.
         * See {@link View.Layout#closestComponent},
         * {@link View.View#closestComponent} and
         * {@link View.Field#closestComponent} methods.
         *
         * @param {String} name The name of the component to find.
         * @return {View.Component} The component or `undefined` if not found.
         */
        closestComponent: function(name) {
            // Do nothing (field, view and layout will override)
        },

        /**
         * Pass through function to jQuery's show to show view.
         */
        show: function() {
            if(!this.isVisible()) {
                if (!this.triggerBefore("show")) {
                    return false;
                }
                this._show();
                this.trigger('show');
            }
        },

        /**
         * Pass through function to jQuery's hide to hide view.
         */
        hide: function() {
            if(this.isVisible()) {
                if (!this.triggerBefore("hide")) {
                    return false;
                }
                this._hide();
                this.trigger('hide');
            }
        },

        /**
         * Checks if the component is visible on the page.
         */
        isVisible: function() {
            return this._isVisible;
        },

        /**
         * Updates the visible property.
         *
         * **Note:** This does not show/hide the component. Please use
         * {@link #show} and {@link #hide} for this use case.
         */
        updateVisibleState: function(visible) {
            /**
             * Flag to indicate the visible state of the component.
             *
             * @type {boolean}
             * @private
             */
            this._isVisible = !!visible;
        },

        /**
         * @protected
         */
        _show: function() {
            this.$el.removeClass('hide').show();
            this.updateVisibleState(true);
        },

        /**
         * @protected
         */
        _hide: function() {
            this.$el.addClass('hide').hide();
            this.updateVisibleState(false);
        },

        /**
         *  _super is used to retrieve and invoke parent prototype functions.
         *  Requires a method paramter to function. The method called should be named the same as the function
         *  being called from.
         *
         * Examples:
         *
         * * Good:
         * <pre><code>
         * ({
         *     initialize: function(options) {
         *         //extend the base meta with some custom meta
         *         options.meta = _.extend({}, myMeta, options.meta || {});
         *         //Only call parent initialize from initialize
         *         this._super('initialize', [options]);
         *         this.buildFoo(options);
         *     }
         * });
         * </code></pre>
         *
         * * Bad:
         * <pre><code>
         * ({
         *     initialize: function(options) {
         *         //extend the base meta with some custom meta
         *         options.meta = _.extend({}, myMeta, options.meta || {});
         *         //Calling a function like buildFoo from initialize is incorrect. Should call directly on this
         *         this._super('buildFoo',[options]);
         *     }
         * });
         * </code></pre>
         *
         * @param method {String} The name of the method to call e.g. 'initialize', '_renderHtml', etc. (required)
         * @param args {Array=} Arguments to pass to the parent method. Same syntax as .apply
         * @return {Mixed}
         * @protected
         */
        _super: function(method, args) {
            //Must be used to invoke parent methods
            if (!method || !_.isString(method)) {
                return app.logger.error("tried to call _super without specifying a parent method in " + this.name);
            }

            var parent, resetSuper = null, thisProto = Object.getPrototypeOf(this);
            args = args || [];

            //_lastSuperClass is used to walk the prototype chain
            this._superStack = this._superStack || {};
            this._superStack[method] = this._superStack[method] || [];
            if (this._superStack[method].length > 0) {
                parent = Object.getPrototypeOf(_.last(this._superStack[method]));
                if (_.contains(this._superStack[method], parent)) {
                    return app.logger.error("Loop detected calling " + method + " from " + this.name);
                }
            } else {
                parent = Object.getPrototypeOf(thisProto);
            }

            //First verify that the method exists on the current object
            if (!thisProto[method]) {
                return app.logger.error("Unable to find method " + method + " on class " + this.name);
            }

            //Walk up the chain until we find a parent that implements the method.
            while (!parent.hasOwnProperty(method) && parent !== app.view.Component.prototype) {
                parent = Object.getPrototypeOf(parent);
            }

            //Walk up the chain until we find a parent that overrode the method.
            while (thisProto[method] === parent[method] && parent !== app.view.Component.prototype) {
                thisProto = parent;
                parent = Object.getPrototypeOf(parent);
            }
            this._superStack[method].push(parent);

            //Verify that we found a valid parent that implements this method
            if (!parent) {
                return app.logger.error("Unable to find parent of component " + this.name);
            }
            if (!parent[method]) {
                return app.logger.error("Unable to find method " + method + " on parent class of " + this.name);
            }

            //Finally make the parent call
            var ret = parent[method].apply(this, args);

            //Reset the last parent to step down the prototype chain
            this._superStack[method].pop();
            //When we reach the end of the chain, also remove the method name requirement
            if (_.isEmpty(this._superStack[method])) {
                this._superStack[method] = null;
            }

            return ret;
        }
    });

    //Mix in the beforeEvents
    _.extend(app.view.Component.prototype, app.beforeEvent);

})(SUGAR.App);
