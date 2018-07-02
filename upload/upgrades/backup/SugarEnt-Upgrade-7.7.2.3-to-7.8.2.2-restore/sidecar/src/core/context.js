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
     * The Context object is a state variable to hold the current application state. The context contains various
     * states of the current {@link View.View View} or {@link View.Layout Layout} -- this includes the current model and collection, as well as the current
     * module focused and also possibly the url hash that was matched.
     *
     * ###Creating a Context Object
     *
     * Use the getContext method to get a new instance of a context.
     * <pre><code>
     * var myContext = SUGAR.app.context.getContext({
     *     module: "Contacts",
     *     url: "contacts/id"
     * });
     * </code></pre>
     *
     * ###Retrieving Data from the Context
     *
     * <pre><code>
     * var module = myContext.get("module"); // module = "Contacts"
     * </pre></code>
     *
     * ###Global Context Object
     *
     * The Application has a global context that applies to top level layer. Contexts used within
     * nested {@link View.View Views} / {@link View.Layout Layouts} can be derived from the global context
     * object.
     *
     *
     * The global context object is stored in **`App.controller.context`**.
     *
     *
     * @class Core.Context
     * @extends Backbone.Model
     */
    app.Context = Backbone.Model.extend({

        initialize: function(attributes) {
            Backbone.Model.prototype.initialize.call(this, attributes);
            this.id = this.cid;
            this.parent = null;
            this.children = [];
            this._fetchCalled = false;
        },

        /**
         * Clears context's attributes and calls {@link Core.Context#resetLoadFlag} method.
         * @param options(optional) Standard Backbone.Model options and clearAllListeners {boolean}
         *        By default, it removes all events attached to models and collections in the context.
         */
        clear: function(options) {
            var collection = this.get('collection');

            collection && collection.abortFetchRequest();

            options = _.extend({clearAllListeners: true}, options || {});
            _.each(this.children, function(child) {
                child.clear(options);
            });

            this.children = [];
            this.parent = null;

            // Remove event listeners attached to models and collections in the context
            // before clearing them.
            _.each(this.attributes, function(value) {
                if (value && (value.off === Backbone.Events.off)) {
                    if (options.clearAllListeners) {
                        value.off(); //remove all
                        if(_.isFunction(value.dispose)) {
                            value.dispose();
                        }
                    } else {
                        value.off(null, null, this); //only remove events with context object as the context
                    }
                }
            }, this);
            delete options.clearAllListeners;

            this.off();
            Backbone.Model.prototype.clear.call(this, options);

            this.resetLoadFlag();
        },

        /**
         * Resets "load-data" state for this context and its child contexts.
         *
         * The {@link Core.Context#loadData} method sets an internal boolean flag
         * to prevent multiple identical requests to the server. This method resets this flag.
         * @param recusive Boolean if not false, child contexts will also be reset.
         */
        resetLoadFlag: function(recursive) {
            recursive = _.isUndefined(recursive) ? true : recursive;
            this._fetchCalled = false;

            if (this.get("model")) {
                this.get("model").dataFetched = false;
            }
            if (this.get("collection")) {
                this.get("collection").dataFetched = false;
            }

            if (recursive) {
                _.each(this.children, function(child) {
                    child.resetLoadFlag();
                });
            }
        },

        /**
         * Checks if a context is used for a create view.
         * @return {Boolean} `true` if this context has `create` flag set.
         */
        isCreate: function() {
            return this.get("create") === true;
        },

        /**
         * Gets a related context.
         * @param {Object} def Related context definition.
         * <pre>
         * {
         *    module: module name,
         *    link: link name
         * }
         * </pre>
         * @return {Core.Context} New instance of the child context.
         */
        getChildContext: function(def) {
            var context,
                force = def.forceNew || false;

            delete def.forceNew;

            // Re-use a child context if it already exists
            // We search by either link name or module name
            // Consider refactoring the way we store children: hash v.s. array
            var name = def.cid || def.name || def.link || def.module;
            if (name && !force) {
                context = _.find(this.children, function(child) {
                    return ((child.cid == name) || (child.get("link") == name) || (child.get("module") == name));
                });
            }

            if (!context) {
                context = app.context.getContext(def);
                this.children.push(context);
                context.parent = this;
            }

            if (def.link) {
                var parentModel = this.get("model");
                context.set({
                    parentModel: parentModel,
                    parentModule: parentModel ? parentModel.module : null
                });
            } else if(!def.module){
                context.set({module:this.get("module")});
            }

            this.trigger("context:child:add", context);

            return context;
        },

        /**
         * Prepares instances of model and collection.
         *
         * This method does nothing if this context already contains an instance of a model or a collection.
         * Pass `true` to re-create model and collection.
         *
         * @param {Boolean} force(optional) Flag indicating if data instances must be re-created.
         */
        prepare: function(force) {
            if (!force && (this.get("model") || this.get("collection"))) return;

            var modelId = this.get("modelId"),
                create = this.get("create"),
                link = this.get("link");

            this.set(link ?
                this._prepareRelated(link, modelId, create) :
                this._prepare(modelId, create)
            );

            return this;
        },

        /**
         * Prepares instances of model and collection.
         *
         * This method assumes that the module name (`module`) is set on the context.
         * If not, instances of standard Backbone.Model and Backbone.Collection are created.
         *
         * @param {String} modelId Bean ID.
         * @param {Boolean} create Create flag.
         * @return {Object} State to set on this context.
         * @private
         */
        _prepare: function(modelId, create) {
            var model, collection,
                module = this.get("module"),
                mixed = this.get("mixed"),
                models;

            if (modelId) {
                model = app.data.createBean(module, { id: modelId });
                models = [model];
            } else if (create === true) {
                model = app.data.createBean(module);
                models = [model];
            } else {
                model = app.data.createBean(module);
            }

            collection = mixed === true ?
                app.data.createMixedBeanCollection(models) :
                app.data.createBeanCollection(module, models);

            return {
                collection: collection,
                model: model
            };
        },

        /**
         * Prepares instances of related model and collection.
         *
         * This method assumes that either a parent model (`parentModel`) or
         * parent model ID (`parentModelId`) and parent model module name (`parentModule`) are set on this context.
         *
         * @param {String} link Relationship link name.
         * @param {String} modelId Related bean ID.
         * @param {Boolean} create Create flag.
         * @return {Object} State to set on this context.
         * @private
         */
        _prepareRelated: function(link, modelId, create) {
            var model, collection,
                parentModel = this.get("parentModel");

            parentModel = parentModel || app.data.createBean(this.get("parentModule"), { id: this.get("parentModelId") });
            if (modelId) {
                model = app.data.createRelatedBean(parentModel, modelId, link);
                collection = app.data.createRelatedCollection(parentModel, link, [model]);
            } else if (create === true) {
                model = app.data.createRelatedBean(parentModel, null, link);
                collection = app.data.createRelatedCollection(parentModel, link, [model]);
            } else {
                model = app.data.createRelatedBean(parentModel, null, link);
                collection = app.data.createRelatedCollection(parentModel, link);
            }

            if (!this.has("parentModule")) {
                this.set({ "parentModule": parentModel.module }, { silent: true });
            }

            if (!this.has("module")) {
                this.set({ "module": model.module }, { silent: true });
            }

            return {
                parentModel: parentModel,
                collection: collection,
                model: model
            };
        },


        /**
         * Loads data (calls fetch on either model or collection).
         *
         * This method sets an internal boolean flag to prevent consecutive fetch operations.
         * Call {@link Core.Context#resetLoadFlag} to reset the context's state.
         * @param options(optional) Options that are passed to collection/model's fetch method.
         */
        loadData: function(options) {
            if (this.isDataFetched() || this.get("create") === true) return;

            var objectToFetch,
                modelId = this.get("modelId"),
                module = this.get("module"),
                defaultOrdering = (app.config.orderByDefaults && module) ? app.config.orderByDefaults[module] : null;

            options = options || {};
            objectToFetch = modelId ? this.get("model") : this.get("collection");

            // If we have an orderByDefaults in the config, and this is a bean collection,
            // try to use ordering from there (only if orderBy is not already set.)
            if (defaultOrdering &&
                objectToFetch instanceof app.BeanCollection &&
                !objectToFetch.orderBy)
            {
                objectToFetch.orderBy = defaultOrdering;
            }

            // TODO: Figure out what to do when models are not
            // instances of Bean or BeanCollection. No way to fetch.
            if (objectToFetch && (objectToFetch instanceof app.Bean ||
                objectToFetch instanceof app.BeanCollection)) {

                if (this.get('dataView') && _.isString(this.get('dataView'))) {
                    objectToFetch.setOption('view', this.get('dataView'));
                }

                if (this.get('fields')) {
                    objectToFetch.setOption('fields', this.get('fields'));
                }

                if (this.get('limit')) {
                    objectToFetch.setOption('limit', this.get('limit'));
                }

                if (this.get('module_list')) {
                    objectToFetch.setOption('module_list', this.get('module_list'));
                }

                // Track models that user is actively viewing
                if(this.get('viewed')){
                    objectToFetch.setOption('viewed', this.get('viewed'));
                }

                options.context = this;

                if (this.get("skipFetch") !== true) {
                    objectToFetch.fetch(options);
                }

                this._fetchCalled = true;
            } else {
                app.logger.warn("Skipping fetch because model is not Bean, Bean Collection, or it is not defined, module: " + this.get("module"));
            }
        },

        /**
         * Refreshes the context's data and refetches the new data if
         * {@link #skipFetch} is `true`.
         *
         * @param {Object} [options] Options for {@link #loadData} and the
         *   `reload` event.
         * @param {Object} [options.recursive] if `true`, child contexts will
         *   also be reloaded.
         */
        reloadData: function(options) {
            options = options || {};

            this.resetLoadFlag(options.recursive);
            this.loadData(options);

            /**
             * @event reload
             * Triggered before and after the context is reloaded.
             * @param {Core.Context} this The context where the event was triggered.
             * @param {Object} [options] The options passed during
             *   {@link #reloadData} call.
             */
            this.trigger('reload', this, options);
        },

        /**
         * Indicator to know if data has been successfully loaded
         *
         * @return {boolean} `true` if data has been fetched, `false` otherwise.
         */
        isDataFetched: function() {
            var objectToFetch = this.get('modelId') ? this.get('model') : this.get('collection');
            return this._fetchCalled || (objectToFetch && !!objectToFetch.dataFetched);
        }
    });

    app.augment('context', {

        /**
         * Returns a new instance of the context object.
         * @param {Object} attributes Any parameters and state properties to attach to the context.
         * @return {Core.Context} New context instance.
         * @member Core.Context
         */
        getContext: function(attributes) {
            return new app.Context(attributes);
        }
    });

})(SUGAR.App);
