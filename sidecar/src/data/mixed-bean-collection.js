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
 * Mixed collection class.
 *
 * Supports wrapping multiple related collections by link to allow aggregated interactions across
 * multiple relationships. Does not support direct fetch at this time except in search mode.
 *
 * **Filtering and searching**
 *
 * The collection's {@link Data.BeanCollection#fetch} method supports filter and search options.
 * For example, to search across accounts, opportunities, and contacts for favorite records
 * that have `"Acme"` string in their searchable fields:
 * <pre><code>
 * (function(app) {
 *
 *     var records = app.data.getMixedBeanCollection();
 *     records.fetch({
 *         favorites: true,
 *         query: "Acme",
 *         module_list: "Accounts,Opportunities,Contacts"
 *     });
 *
 * })(SUGAR.App);
 * </code></pre>
 *
 *
 * @class Data.MixedBeanCollection
 * @alias SUGAR.App.MixedBeanCollection
 * @extends Data.BeanCollection
 */
(function(app) {

    app.augment("MixedBeanCollection", app.BeanCollection.extend({

        /**
         * Creates collections for each one of the links passed in the options.
         * The mixed bean collection will keep those collection in sync with
         * the mixed bean collection.
         *
         * @param {Array} models The initial models of the mixed bean collection.
         * @param {Object} options A hash of options.
         * @param {Array} options.links The links related to the mixed bean
         *   collection. A link is a collection of a particular module. A mixed
         *   bean collection will handle synchronization between its records and
         *   the ones in its link collections.
         */
        initialize: function (models, options) {
            this._linkedCollections = {};

            options = options || {};
            if (options.links) {
                _.each(options.links, function(collection, link) {
                    //Check if collection is a module name rather than an existing collection
                    if (_.isString(collection)) {
                        this._linkedCollections[link] = app.data.createBeanCollection(collection);
                    } else {
                        this._linkedCollections[link] = collection;
                    }

                    this.listenTo(this._linkedCollections[link], 'add', this._onLinkAdd);
                    this.listenTo(this._linkedCollections[link], 'remove', this._onLinkRemove);
                    this.listenTo(this._linkedCollections[link], 'reset', this._onLinkReset);
                }, this);

                delete options.links;
            }

            app.BeanCollection.prototype.initialize.call(this, models, options);
        },

        /**
         * Sets the `model` class to match the given model.
         * @param {Data.Bean} model The bean to be added to the collection.
         * @param {Object} options A hash of options.
         * @return {Data.Bean} The prepared bean.
         */
        _prepareModel: function (model, options) {
            var module = model instanceof app.Bean ? model.module : model._module;
            this.model = app.data.getBeanClass(module);
            return app.BeanCollection.prototype._prepareModel.call(this, model, options);
        },

        /**
         * Callback to add a bean to the collection when it got added to a
         * linked collection.
         * @param {Data.Bean} model The bean to add.
         * @param {Data.BeanCollection} collection The collection where the
         * bean got added.
         * @param {Object} [options] A hash of options.
         */
        _onLinkAdd: function(model, collection, options) {
            if (this._updating) {
                return;
            }

            app.BeanCollection.prototype.add.call(this, model);
        },

        /**
         * Callback to remove a bean from the collection when it got removed
         * from a linked collection.
         *
         * @param {Data.Bean} model The bean to remove.
         * @param {Data.BeanCollection} collection The collection from which the
         * bean got removed.
         * @param {Object} [options] A hash of options.
         */
        _onLinkRemove: function (model, collection, options) {
            if (this._updating) {
                return;
            }

            app.BeanCollection.prototype.remove.call(this, model);
        },

        /**
         * Callback to update the collection when a linked collection got reset.
         *
         * @param {Data.BeanCollection} collection The linked collection that
         * got reset.
         */
        _onLinkReset: function (collection) {
            var groupedBeans = _.groupBy(this.models, function (model) {
                return model instanceof app.Bean ? model.get('_link') : model._link;
            });

            var linkName = _.findKey(this._linkedCollections, val => val === collection);

            app.BeanCollection.prototype.remove.call(this, groupedBeans[linkName]);
            app.BeanCollection.prototype.add.call(this, collection.models);
        },

        /**
         * Adds models to the matching linked collections.
         */
        add: function (models, options) {
            // We don't call the BeanCollection method because a mixed bean
            // collection does not need to track it's own deltas.
            models = Backbone.Collection.prototype.add.call(this, models, options);
            if (_.isEmpty(this._linkedCollections)) {
                return models;
            }

            this._updating = true;
            options = options || {};

            if (!_.isUndefined(models) && !_.isArray(models)) {
                models = [models];
            }

            _.each(models, function (model) {
                var link = model.get('_link');
                if (!link) {
                    return;
                }

                if (this._linkedCollections[link]) {
                    this._linkedCollections[link].add(model, options);
                }
            }, this);

            this._updating = false;

            return models;
        },

        /**
         * Removes models from the matching linked collections.
         */
        remove: function (models, options) {
            // We don't call the BeanCollection method because a mixed bean
            // collection does not need to track it's own deltas.
            models = Backbone.Collection.prototype.remove.call(this, models, options);
            if (_.isEmpty(this._linkedCollections)) {
                return models;
            }

            this._updating = true;
            options = options || {};

            if (!_.isUndefined(models) && !_.isArray(models)) {
                models = [models];
            }

            _.each(models, function (model) {
                var link = model.get('_link');
                if (!link) {
                    return;
                }

                if (this._linkedCollections[link]) {
                    this._linkedCollections[link].remove(model, options);
                }
            }, this);

            this._updating = false;

            return models;
        },

        /**
         * Resets linked collection
         */
        reset: function (models, options) {
            if (_.isEmpty(this._linkedCollections)) {
                // We don't call the BeanCollection method because a mixed bean
                // collection does not need to track it's own deltas.
                return Backbone.Collection.prototype.reset.call(this, models, options);
            }

            var sortedBeans = _.groupBy(models, function (model) {
                return model instanceof app.Bean ? model.get('_link') : model._link;
            });

            _.each(this._linkedCollections, function (collection, link) {
                collection.reset(sortedBeans[link], options);
            }, this);
        },

        /**
         * Gets changes made on the linked collections.
         *
         * @return {Object} The object representing the changes made on the
         * linked collections since the last sync.
         *
         * TODO: SC-6145 will add `add` and `delete` arrays.
         */
        getDelta: function() {
            var result = {};
            _.each(this._linkedCollections, (val, linkName) => {
                let delta = val.getDelta();
                if (_.isEmpty(delta)) {
                    return;
                }

                result[linkName] = delta;
            }, this);

            return result;
        },

        /**
         * Resets the delta object on each linked collection.
         */
        resetDelta: function() {
            _.each(this._linkedCollections, (val, linkName) => {
                val.resetDelta();
            });
        },

        /**
         * Fetches records.
         *
         * This method performs global search across multiple modules.
         * @param options(optional) Fetch options.
         *
         * - module_list: comma-delimited list of modules to search across. The default is a list of all displayable modules.
         *
         * See {@link Data.BeanCollection#fetch} method for details about the reset of the options.
         *
         */
        fetch: function(options) {
            options = options || {};
            // We set a list of all modules by default
            options.module_list = this.module_list = options.module_list || this.module_list || app.metadata.getModuleNames({filter: 'visible'});
            return app.BeanCollection.prototype.fetch.call(this, options);
        },

        /**
         * Groups models by module name.
         * @return {Object} Sets of models. Key is module name, value is array of models.
         */
        groupByModule: function() {
            return _.groupBy(this.models, function(model) {
                return model.module;
            });
        },

        /**
         * Returns string representation of this collection:
         * <code>mcoll:[length]</code>
         * @return {String} string representation of this collection.
         */
        toString: function() {
            return "mcoll:" + this.length;
        }

    }), false);

}(SUGAR.App));
