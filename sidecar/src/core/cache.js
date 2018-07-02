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
 * Persistent cache manager.
 *
 * By default, cache manager uses store.js to manipulate items in `window.localStorage` object.
 * Use {@link Core.CacheManager#store} property to override the storage provider.
 * The value of the key which is passed as a parameter to `get/set/add` methods is prefixed with
 * `<env>:<appId>:` string to avoid clashes with other environments and applications running off the same domain name and port.
 * You can set environment and application ID in {@link Config} module.
 *
 * @class Core.CacheManager
 * @singleton
 * @alias SUGAR.App.cache
 */
(function(app) {

    let keyPrefix = '';

    let buildKey = (key) => keyPrefix + key;

    let sugarStore = _.extend({}, store, {
        // make store compatible with stash
        cut: store.remove,
        cutAll: store.clear,
    });

    /**
     * Helper method used by migrateOldKeys for removing quotes from previous localStorage library.
     *
     * @private
     */
    let unquote = (str) => (new Function('return ' + str))(); // jshint ignore:line

    /**
     * Attempts to migrate values from Stash to Store.
     *
     * `stash.js` used to set values with single quotes in the `localStorage`.
     * `store.js` uses double quotes (standard JSON encode/decode(. Hence, we
     * need to update current values in localStorage to be complaint with the
     * new store.
     *
     * @param {Object} cache Cache object to work on.
     * @private
     */
    let migrateStorage = function (cache) {

        if (cache.has('uniqueKey')) {
            return;
        }

        // We need to clone the local storage to not mess up with it during the
        // iterations.
        let store = {};
        for (let i = 0, len = localStorage.length; i < len; i++) {
            let key = localStorage.key(i);
            store[key] = localStorage[key];
        }

        _.each(store, function (value, key) {
            try {
                JSON.parse(value);
                value = cache.store.deserialize(value);
            } catch (e) {
                value = unquote(value);
            }

            if (value === null) {
                value = undefined;
            }

            cache.store.set(key, value);
        });

        cache.set('uniqueKey', app.config.uniqueKey);
    };

    let cache = {

        /**
         * Storage provider.
         *
         * Default: store.js
         *
         * @cfg {Object}
         */
        store: sugarStore,

        /**
         * Initializes cache manager.
         */
        init: function() {
            keyPrefix = `${app.config.env}:${app.config.appId}:`;

            migrateStorage(this);

            if (this.get('uniqueKey') !== app.config.uniqueKey) {
                // do not leak information to other instances
                this.cutAll(true);
                this.set('uniqueKey', app.config.uniqueKey);
            }

            app.events.register('cache:clean', this);
        },

        /**
         * Checks if the item exists in cache.
         * @param {String} key Item key.
         */
        has: function(key) {
            return this.store.has(buildKey(key));
        },

        /**
         * Gets an item from the cache.
         * @param {string} key Item key.
         * @return {number|boolean|string|Array|Object} Item with the given key.
         */
        get: function(key) {
            return this.store.get(buildKey(key));
        },

        /**
         * Puts an item into cache.
         * @param {string} key Item key.
         * @param {number|boolean|string|Array|Object} value Item to put.
         */
        set: function(key, value) {
            key = buildKey(key);

            try {
                this.store.set(key, value);
            } catch(e) {
                if (e.name.toLowerCase().indexOf('quota') > -1) {
                    //Localstorage is full, the app needs to handle this.
                    this.clean();
                    this.store.set(key, value);
                }
            }
        },

        /**
         * Remove non-critical values to free up space. Should be called whenever local storage quota is exceeded.
         * Listen for the clean event (passes callback as argument) in order to register keys to preserve after clean.
         *
         * Keys that are not vital should not be presvered during a cleanup.
         * Ex.
         * <pre><code>
         * ({
         *     initialize: function(options) {
         *         app.events.on('cache:clean', function(callback) {
         *             callback([
         *                 'my_important_cache_key',
         *                 'my_other_important_key',
         *             ])
         *         });
         *     },
         * });
         * </code></pre>
         */
        clean: function() {
            var preserveKeys = [],
                preservedValues = {};

            //First get a list of all keys to keep
            this.trigger('cache:clean', function(keys) {
                preserveKeys = _.union(keys, preserveKeys);
            });
            //Now get those values
            _.each(preserveKeys, function(key) {
                preservedValues[key] = this.get(key);
            }, this);
            //nuke all the keys we own
            this.cutAll();

            //restore any vital values
            _.each(preservedValues, function(value, key) {
                if (!_.isUndefined(value)){
                    this.set(key, value);
                }
            }, this);
        },

        /**
         * Deletes an item from cache.
         * @param {String} key Item key.
         */
        cut: function(key) {
            key = buildKey(key);
            if (this.store.has(key)) {
                this.store.cut(key);
            }
        },

        /**
         * Deletes all items from cache.
         *
         * By default, this method deletes all items for the current app and environment.
         * Pass `true` to this method to remove all items.
         * @param {Boolean} all(optional) Flag indicating if all items must be deleted from this cache.
         */
        cutAll: function(all) {
            if (all === true) {
                return this.store.cutAll();
            }

            var obj = this.store.getAll();
            _.each(obj, function (value, key) {
                if (key.indexOf(keyPrefix) === 0) {
                    this.store.cut(key);
                }
            }, this);
        }
    };

    //Use eventing for cache cleaning
    _.extend(cache, Backbone.Events);

    app.augment('cache', cache);


})(SUGAR.App);
