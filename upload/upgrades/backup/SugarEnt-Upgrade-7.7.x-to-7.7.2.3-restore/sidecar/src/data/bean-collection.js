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
 * Base bean collection class.
 *
 * **Filtering and searching**
 *
 * The collection's {@link Data.BeanCollection#fetch} method supports filter and seach options.
 * For example, to search favorite accounts that have `"Acme"` string in their name:
 * <pre><code>
 * (function(app) {
 *
 *     var accounts = app.data.createBeanCollection("Accounts");
 *     accounts.fetch({
 *         favorites: true,
 *         query: "Acme"
 *     });
 *
 * })(SUGAR.App);
 * </code></pre>
 *
 *
 * @class Data.BeanCollection
 * @alias SUGAR.App.BeanCollection
 * @extends Backbone.Collection
 */
(function(app) {

    app.augment('BeanCollection', Backbone.Collection.extend({

        /**
         * Prepare related bean collections and attach collection plugins.
         *
         * @inheritdoc
         * @constructor
         * @param {Array} models initial array of models
         * @param {Object} options
         */
        constructor: function(models, options) {
            app.plugins.attach(this, 'collection');
            if (options && options.link) {
                this.link = options.link;
                delete options.link;
            }
            Backbone.Collection.prototype.constructor.call(this, models, options);
        },

        /**
         * Saves a private copy of initial options for reset
         *
         * @constructor
         * @param {Array} models initial array of models
         * @param {Object} options
         */
        initialize: function(models, options) {
            /**
             * Initial fetch options.
             *
             * @deprecated 7.7 will be removed in 7.8. Please use {@link #setOption}
             *   if you want to set persistent options.
             *
             * @type {Object}
             * @private
             */
            if (!_.isEmpty(options)) {
                options = app.utils.deepCopy(options);
                this.setOption(options);
                app.logger.warn('You should not pass persistent fetch options in initialize ' +
                '(The options hash is supposed to be Backbone.js options hash, allowing you ' +
                'to pass Backbone options used when setting the models into the collection).' +
                ' Please use setOption() instead.');
            }
            this._initOptions = options;

            /**
             * The request object that is currently syncing against the server.
             *
             * This object is needed to determine if a fetch request should be
             * aborted for the collection (e.g. if a new fetch request returns a
             * response prior to a previous fetch request).
             *
             * @private
             * @member Data.BeanCollection
             * @property {SUGAR.Api.HttpRequest}
             */
            this._activeFetchRequest = null;

            this.on('data:sync:complete', function() {
                this._activeFetchRequest = null;
            }, this);

            this.on('remove', this._decrementTotal, this);

            Backbone.Collection.prototype.initialize.call(this, models, options);

            /**
             * Readonly property for the total records in server.
             *
             * Use {@link #fetchTotal} to get the current total.
             * @type {number}
             */
            this.total = null;
        },

        /**
         * Decrements the {@link #total collection total}.
         *
         * @protected
         */
        _decrementTotal: function() {
            if (this.total) {
                this.total--;
            }
        },

        /**
         * Disposes a collection.
         *
         */
        dispose: function() {
            app.plugins.detach(this, "collection");
        },

        /**
         * Prepare the model to be added to the collection
         *
         * @param {Data.Bean} model to be added.
         * @param {Object} [options] to be passed to
         *   {@link Backbone.Collection#_prepareModel} method.
         * @return {Data.Bean} prepared model.
         * @private
         */
        _prepareModel: function(model, options) {
            var searchInfo = model._search;
            delete model._search;

            model = Backbone.Collection.prototype._prepareModel.call(this, model, options);
            if (model && !model.link) model.link = this.link;
            if (searchInfo) {
                /**
                 * FTS search results.
                 * @member Data.Bean
                 * @property {Object}
                 *
                 * Example:
                 * <pre>
                 * {
                 *   highlighted: {
                 *      account_name: {
                 *        label: "LBL_ACCOUNT_NAME",
                 *        module: "Leads",
                 *        text: "Kings Royalty &lt;span class="highlight"&gt;Trust&lt;/span&gt;"
                 *      }
                 *    },
                 *    score: 1
                 * }
                 * </pre>
                 */
                model.searchInfo = searchInfo;
            }
            return model;
        },

        /**
         * Fetches beans. See {@link Data.BeanCollection#paginate} for details
         * about pagination options.
         *
         * Only one fetch request can be executed at a time - previous fetch
         * requests will be aborted.
         *
         * @param {Object} [options] Fetch options.
         * @param {bool} [options.relate] `true` if relationships should be
         *   fetched. `false` otherwise.
         * @param {bool} [options.myItems] `true` if only records assigned to
         *   the current user should be fetched. `false` otherwise.
         * @param {bool} [options.favorites] `true` if favorited records should
         *   be fetched. `false` otherwise.
         * @param {bool} [options.add] `true` if new records should be appended
         *   to the collection. `false` otherwise.
         * @param {string} [options.query] Search query string.
         * @param {Function} [options.success] The success callback to execute.
         * @param {Function} [options.error] The error callback to execute.
         */
        fetch: function(options) {
            options = _.extend({}, this.getOption(), options);

            this.abortFetchRequest();
            /**
             * Field names.
             *
             * A list of fields that are populated on collection members.
             * This property is used to build `fields` URL parameter when
             * fetching beans.
             *
             * @member Data.BeanCollection
             * @property {Array}
             */
            options.fields = this.fields = options.fields || this.fields || null;
            options.myItems = _.isUndefined(options.myItems) ? this.myItems : options.myItems;
            options.favorites = _.isUndefined(options.favorites) ? this.favorites : options.favorites;
            options.query = _.isUndefined(options.query) ? this.query : options.query;

            this._activeFetchRequest = Backbone.Collection.prototype.fetch.call(this, options);
            return this._activeFetchRequest;
        },

        /**
         * Getter for {@link #_activeFetchRequest}.
         *
         * @return {SUGAR.Api.HttpRequest} The active fetch request.
         */
        getFetchRequest: function() {
            return this._activeFetchRequest;
        },

        /**
         * Aborts the {@link #_activeFetchRequest current fetch request}.
         */
        abortFetchRequest: function() {
            var req = this.getFetchRequest();
            if (req) {
                app.api.abortRequest(req.uid);
            }
        },

        /**
         * Resets pagination properties on a collection to initial options,
         * otherwise defaults to first page
         */
        resetPagination:function(){
            var paginationDefaults = {offset: 0, next_offset: 0, page: 1};
            var optKeys = _.keys(paginationDefaults);
            this.resetOptions(optKeys);
            var options = this.getOption();
            _.each(optKeys, function(optKey) {
                this[optKey] = options[optKey] || paginationDefaults[optKey];
            }, this);
        },
        /**
         * Resets optionsList to original values from init, clears them if no optionsList specified
         *
         * @deprecated 7.7 will be removed in 7.8. Please use {@link #setOption}/{@link #unsetOption}
         *   if you want to set persistent options.
         *
         * @param {Array} optionsList(optional) array of option keys to reset
         */
        resetOptions: function (optionsList) {
            if (_.isEmpty(this._initOptions) && _.isEmpty(this.getOption())) {
                // clear options if none existed when we started
                this.unsetOption();
            } else {
                // reset specific options if specified
                _.each(optionsList, function (option) {
                    if (!_.isUndefined(this._initOptions[option])) {
                        this.setOption(option, this._initOptions[option]);
                    } else if (!_.isEmpty(this.options) && _.has(this.options, option)) {
                        this.unsetOption(option);
                    }
                }, this);
            }
        },

        /**
         * Paginates a collection.
         *
         * @param options(optional) fetch options
         *
         * - page: page index (integer) from the current page to paginate to.
         *
         * For other options see {@link Data.BeanCollection#fetch} method.
         */
        paginate: function(options) {
            options = options || {};
            var maxSize = options.limit || app.config.maxQueryResult;
            options.page = options.page || 1;

            // fix page number since our offset is already at the end of the collection subset
            options.page--;

            if (maxSize) {
                options.offset = this.offset + (options.page * maxSize);
            }

            if (options.add){
                options = _.extend({update:true, remove:false}, options);
            }

            this.fetch(options);
        },

        /**
         * Fetches the total amount of records on the bean collection, and sets
         * it on the {@link #total} property.
         *
         * Returns the total amount of filtered records if a `filterDef`
         * property is set on the collection.
         *
         * @param {Object} [options] Fetch total options.
         * @param {Function} [options.success] Success callback.
         * @param {Function} [options.complete] Complete callback.
         * @param {Function} [options.error] Error callback.
         * @return {SUGAR.HttpRequest} Result of {@link SUGAR.Api#call}.
         */
        fetchTotal: function(options) {
            options = options || {};

            if (!_.isNull(this.total) && _.isFunction(options.success)) {
                options.success.call(this, this.total);
                return;
            }

            options.success = _.wrap(options.success, _.bind(function(orig, data) {
                this.total = parseInt(data.record_count, 10);
                if (orig && _.isFunction(orig)) {
                    orig(this.total);
                }
            }, this));

            var module = this.module;
            var data = null;
            options.filter = options.filterDef || this.filterDef;

            if (this.link) {
                data = {
                    id: this.link.bean.id,
                    link: this.link.name
                };
                module = this.link.bean.module;
            }

            var callbacks = _.pick(options, 'success', 'complete', 'error');
            options = _.omit(options, 'success', 'complete', 'error');

            return app.api.count(module, data, callbacks, options);
        },

        /**
         * A convenience method that checks to see if there are at least the
         * amount of records passed in `amount`. Also passes to a provided
         * success callback the length of records up to `amount`, and if there
         * are more records to be fetched (`hasMore`).
         *
         * Fetches the partial amount of filtered records if a `filterDef`
         * property is set on the collection.
         *
         * @param {number} amount The number of records to check if there are a
         *   minimum of.
         * @param {Object} [options] Fetch partial total options.
         * @param {Object} [options.filterDef] Filter definition to be applied.
         * @param {Function} [options.success] Success callback.
         * @param {Function} [options.complete] Complete callback.
         * @param {Function} [options.error] Error callback.
         * @return {SUGAR.HttpRequest} Result of {@link SUGAR.Api#call}.
         */
        hasAtLeast: function(amount, options) {
            options = options || {};
            var method = 'read';
            options.fields = ['id'];
            delete options.view;
            options.silent = true;
            options.success = _.wrap(options.success, _.bind(function(orig, data) {
                var length = data.records.length;
                var hasAtLeastAmount = length >= amount;
                var properties = {
                    length: length,
                    hasMore: data.next_offset !== -1
                };

                if (_.isFunction(orig)) {
                    orig(hasAtLeastAmount, properties);
                }

                this.reset(null, {silent: true});
            }, this));

            var module = this.module;
            var data = null;
            var endpoint = 'records';
            options.filter = options.filterDef || this.filterDef;
            options.limit = options.limit || amount;

            if (this.link) {
                data = {
                    id: this.link.bean.id,
                    link: this.link.name
                };
                module = this.link.bean.module;
                endpoint = 'relationships';
            }

            var callbacks = _.pick(options, 'success', 'complete', 'error');
            options = _.omit(options, 'success', 'complete', 'error');
            options = app.data.parseOptionsForSync(method, this, options);

            return app.api[endpoint](method, module, data, options.params, callbacks, options.apiOptions);
        },

        /**
         * Gets the current page of collection being displayed depending on the offset.
         *
         * @param options(Optional) fetch options used when paginating
         *
         * - limit: When set, it is the size of each page otherwise we use app.config.maxQueryResult
         *
         * @return {Number} current page number.
         */
        getPageNumber: function(options) {
            var pageNumber = 1;
            var maxSize = app.config.maxQueryResult;
            if(options){
                maxSize = options.limit || maxSize;
            }
            if (this.offset && maxSize) {
                pageNumber = Math.ceil(this.offset / maxSize);
            }
            return pageNumber;
        },

        /**
         * Returns string representation useful for debugging:
         * <code>coll:[module-name]-[length]</code>  or
         * <code>coll:[related-module-name]/[id]/[module-name]-[length]</code> if it's a collection of related beans.
         * @return {String} string representation of this collection.
         */
        toString: function() {
            return "coll:" + (this.link ?
                (this.link.bean.module + "/" + this.link.bean.id + "/") : "") +
                this.module + "-" + this.length;
        },

        /**
         * Returns the next model in a collection, paginating if needed.
         * @param {Object} current Current model or id of a model.
         * @param {Object} callback Callback for success call.
         * @return {Object} Next model in collection or ``null``
         * if current model is last item in collection.
         */
        getNext: function(current, callback) {
            var ind = -1,
                result = null,
                self = this;
            if (this.hasNextModel(current)) {
                ind = this.getModelIndex(current);
                if (ind + 1 >= this.length) {
                    this.paginate({add: true, success: function(collection, response, options) {
                        callback.apply(self, [self.at(ind + 1), 'next']);
                    }});
                } else {
                    callback.apply(self, [self.at(ind + 1), 'next']);
                }
            }
        },

        /**
         * Returns the previous model in a collection.
         * @param {Object} current Current model or id of a model.
         * @param {Object} callback Callback for success call.
         * @return {Object} Previous model in collection or ``null``
         * if current model is first item in collection.
         */
        getPrev: function (current, callback) {
            var ind = -1,
                result = null,
                self = this;
            if (this.hasPreviousModel(current)) {
                ind = this.getModelIndex(current);
                result = this.at(ind - 1);
            }
            callback.apply(self, [result, 'prev']);
        },

        /**
         * Check whether is there next model in collection.
         * @param  {Object} current Current model or id of a model.
         * @return {Boolean} ``true`` if has next model, ``false`` otherwise.
         */
        hasNextModel: function(current) {
            var index = this.getModelIndex(current),
                offset = !_.isUndefined(this.next_offset) ? parseInt(this.next_offset, 10) : -1;
            return index >= 0 && ((this.length > index + 1 ) || offset !== -1);
        },

        /**
         * Check whether is there previous model in collection.
         * @param  {Object} current Current model or id of a model.
         * @return {Boolean} ``true`` if has previous model, ``false`` otherwise.
         */
        hasPreviousModel: function (current) {
            return this.getModelIndex(current) > 0;
        },

        /**
         * Return index of the model in collection.
         * @param  {Object} model Current model.
         * @return {Number}
         */
        getModelIndex: function (model) {
            return this.indexOf(this.get(model.id));
        },

        /**
         * Sets the default fetch options (one or many) on the model.
         *
         * @param {string|Object} key The name of the attribute, or an hash of
         * attributes.
         * @param {Mixed} [val] The default value for the `key` argument.
         *
         * @chainable
         */
        setOption: function(key, val) {
            var attrs;
            if (_.isObject(key)) {
                attrs = key;
            } else {
                (attrs = {})[key] = val;
            }

            /**
             * List of persistent fetch options.
             *
             * @type {Object}
             * @private
             */
            this._persistentOptions = _.extend({}, this._persistentOptions, attrs);
            return this;
        },

        /**
         * Unsets a default fetch option (or all).
         *
         * @param {string|Object} [key] The name of the option to unset, or
         * nothing to unset all options.
         *
         * @chainable
         */
        unsetOption: function(key) {
            if (key) {
                this.setOption(key, void 0);
            } else {
                this._persistentOptions = {};
            }
            return this;
        },

        /**
         * Gets one or all persistent fetch options.
         *
         * @param {string|Object} [key] The name of the option to retrieve, or
         * nothing to retrieve all options.
         * @return {Mixed} A specific option, or the list of options.
         */
        getOption: function(key) {
            if (key) {
                return this._persistentOptions[key];
            }
            return this._persistentOptions;
        },

        /**
         * @inheritdoc
         *
         * Clones the {@link #link} and all the persistent options of the
         * Collection.
         *
         * @return {Data.BeanCollection} The new collection with an identical
         * list of models as this one.
         */
        clone: function() {
            var newCol = Backbone.Collection.prototype.clone.call(this);
            newCol.link = _.clone(this.link);
            newCol.setOption(_.clone(this.getOption()));
            return newCol;
        }
    }), false);
}(SUGAR.App));
