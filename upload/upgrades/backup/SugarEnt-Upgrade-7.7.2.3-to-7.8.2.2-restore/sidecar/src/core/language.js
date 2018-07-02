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
     * Language Helper.
     *
     * Provides interface to pull language strings out of a language label
     * cache.
     *
     * @class Core.Language
     * @alias SUGAR.App.lang
     * @singleton
     */
    app.augment('lang', {

        /**
         * The display direction for the current language.
         *
         * @property {string}
         */
        direction: 'ltr',

        /**
         * Retrieves a string for a given key.
         *
         * This function searches the module strings first and falls back to the
         * app strings.
         *
         * If the label is a template, it will be compiled and executed with the
         * given `context`.
         *
         * @param {string} key Key of the string to retrieve.
         * @param {string|Array} [module] Module the label belongs to. If an
         *   array is passed, it will look through each module by the given
         *   order, returning the first string whose key is found in the
         *   module's language strings.
         * @param {string|boolean|number|Array|Object} [context] The template context to pass to the
         *   string/template in case you want to populate some values.
         * @return {string} String for the given key or the `key` parameter if
         *   the key is not found in language pack.
         */
        get: function(key, module, context) {
            var str = this.getModString(key, module, context) ||
                this.getAppString(key, context) ||
                key;

            return str;
        },

        /**
         * Searches the module strings for a given key.
         *
         * @param {string} key Key of the string to retrieve.
         * @param {string|Array} [module] Module the label belongs to. If an
         *   array is passed, it will look through each module by the given
         *   order, returning the first string whose key is found in the
         *   module's language strings.
         * @param {string|boolean|number|Array|Object} [context] The template context to pass to the
         *   string/template in case you want to populate some values.
         * @return {string|undefined} String for the given key from the module
         *   language strings. `undefined` if not found.
         */
        getModString: function(key, module, context) {
            var moduleString;

            if (_.isArray(module)) {
                _.find(module, function(moduleName) {
                    moduleString = this._get('mod_strings', key, moduleName, context);
                    return !_.isEmpty(moduleString);
                }, this);
            } else {
                moduleString = this._get('mod_strings', key, module, context);
            }

            return moduleString;
        },

        /**
         * Retrieves an application string for a given key.
         *
         * @param {string} key Key of the string to retrieve.
         * @param {string|boolean|number|Array|Object} [context] The template
         *   context to pass to the string/template in case you want to
         *   populate some values.
         * @return {string|undefined} String for the given key from language
         *   strings. `undefined` if not found.
         */
        getAppString: function(key, context) {
            return this._get('app_strings', key, null, context);
        },

        /**
         * Retrieves an application list string or object.
         *
         * @param {string} key Key of the string to retrieve.
         * @return {string|Object} String or object for the given key. If key
         *   is not found, an empty object is returned.
         */
        getAppListStrings: function(key) {
            var list = app.metadata.getStrings('app_list_strings')[key] || {};
            if (_.isArray(list)) {
                var obj = {};
                _.each(list, function(tuple) {
                    if (_.isString(tuple)) {
                        obj[tuple] = tuple;
                    }
                    else if (_.isArray(tuple) && tuple.length === 2) {
                        obj[tuple[0]] = tuple[1];
                    }
                });
                list = obj;
            }
            return list;
        },

        /**
         * Gets the translated module name (by default, in singular form).
         *
         * Falls back to the plural form if the singular form is not found, and
         * eventually falls back to the `module` passed in.
         *
         * @param {string} module The module.
         * @param {Object} [options] Options object for `getModuleName`.
         * @param {boolean} [options.plural] Returns the plural form if `true`,
         *   singular otherwise.
         * @param {string} [options.defaultValue] Value to be returned if the
         *   module language string is not found.
         * @return {string} The module name.
         */
        getModuleName: function(module, options) {
            options = options || {};
            var name = !options.plural &&
                this.getModString('LBL_MODULE_NAME_SINGULAR', module) ||
                this.getModString('LBL_MODULE_NAME', module);

            if (!name && !_.isUndefined(options.defaultValue)) {
                name = this.get(options.defaultValue);
            }

            return name || module;
        },

        /**
         * Returns the correct ordered array of keys for a given list.
         * @param {string} key Key of the string to retrieve.
         * @return {Array}
         */
        getAppListKeys: function(key) {
            var keys = [],
                list = app.metadata.getStrings('app_list_strings')[key] || {};
            if (_.isArray(list)) {
                _.each(list, function(tuple) {
                    if (tuple.length === 2) {
                        keys.push(tuple[0]);
                    }
                });
            } else if (_.isObject(list)) {
                keys = _.keys[list];
            }
            return keys;
        },

        /**
         * Retrieves a string of a given type.
         *
         * If the label is a template, it will be compiled and executed with the given `context`.
         * @param {string} type Type of string pack: `app_strings`, `app_list_strings`, `mod_strings`.
         * @param {string} key Key of the string to retrieve.
         * @param {string} [module] Module the label belongs to.
         * @param {string|boolean|number|Array|Object} [context] Template context.
         * @return {string|undefined} String for the given key.
         * @private
         */
        _get: function(type, key, module, context) {
            var str,
                bundle = app.metadata.getStrings(type);

            bundle = module ? bundle[module] : bundle;
            if (!bundle || !_.isString(bundle[key])) {
                return;
            }

            str = this._sanitize(bundle[key]);

            if (!_.isUndefined(context) && (str.indexOf('{{') > -1)) {
                key = 'lang.' + (module ? key + '.' + module : key);
                var tpl = Handlebars.templates[key];
                str = tpl ? tpl(context) : app.template.compile(key, str)(context);
            }
            return str;
        },

        /**
         * Sanitizes a string.
         *
         * This function strips trailing colon.
         *
         * @param {string} str String to sanitize.
         * @return {string} Sanitized string or `str` parameter if it's not a
         *   string.
         * @private
         */
        _sanitize: function(str) {
            return (str.slice(-1) === ':') ? str.slice(0, -1) : str;
        },

        /**
         * Gets the Sugar language code for the current app language.
         *
         * @return {string} The current app language code as defined in Sugar.
         * (e.g. `en_us`, `pt_PT`)
         */
        getLanguage: function() {
            return this._currentLanguage;
        },

        /**
         * Sets app language code and syncs it with the server.
         * @param {string} language language code such as `en_us`.
         * @param {Function} [callback] Callback function to be called on
         *   language set completes.
         * @param {Object} [options] Extra options.
         * @param {boolean} [options.noSync]
         * - noSync: true if you don't need to fetch /metadata.
         * - noUserUpdate: true if you don't need to update /me.
         */
        setLanguage: function(language, callback, options) {
            var self = this;
            options = options || {};
            _.each(Handlebars.templates, function(value, key) {
                if (key.indexOf('lang.') === 0) {
                    delete Handlebars.templates[key];
                }
            });
            if (options.noSync === true) {
                this.updateLanguage(language);
                return;
            }

            app.sync({
                callback: function(err) {
                    var langHasChanged = false;
                    if (!err) {
                        self.updateLanguage(language);
                        langHasChanged = !app.api.isAuthenticated() && !options.noUserUpdate;
                        app.cache.set('langHasChanged', langHasChanged);//persist even after reloads
                    }
                    if (callback) callback(err);
                },
                getPublic: !app.api.isAuthenticated(),
                noUserUpdate: options.noUserUpdate || false,
                language: language,
                forceRefresh: true,  // Needed to make sure new labels are injected
                metadataTypes: ['labels']
            });
        },

        /**
         * Updates language code and the display direction.
         *
         * @param {string} language Language code as defined in Sugar.
         * (e.g. `en_us`, `pt_PT`)
         */
        updateLanguage: function(language) {
            app.cache.set('lang', language);
            app.user.setPreference('language', language);
            app.trigger('app:locale:change');
            this.setCurrentLanguage(language);
        },

        /**
         * Sets the app default language to the language specified.
         *
         * See {@link #_defaultLanguage} for more information
         *
         * @param {string} language The Sugar language code to set the default
         * language to. (e.g. `en_us`, `pt_PT`)
         */
        setDefaultLanguage: function(language) {
            /**
             * The default language of the app defined by
             * {@link #setDefaultLanguage}. Use {@link #getDefaultLanguage} to
             * retrieve this setting.
             *
             * @property {string}
             * @member Core.Language
             * @private
             */
            this._defaultLanguage = language;
        },

        /**
         * Gets the default language set in the system.
         *
         * @return {string} The Sugar language code of the default language.
         * (e.g. `en_us`, `pt_PT`)
         */
        getDefaultLanguage: function() {
            return this._defaultLanguage;
        },

        /**
         * Sets the current language to the language specified.
         * Calls {@link #setDirection} with the new language code.
         *
         * See {@link #_currentLanguage} for more information.
         *
         * @param {string} language The language to set the current language to.
         */
        setCurrentLanguage: function(language) {
            /**
             * The language that is loaded by the app and defined by
             * {@link #setCurrentLanguage}. Use {@link #getLanguage} to retrieve
             * this setting.
             *
             * @property {string}
             * @member Core.Language
             * @private
             */
            this._currentLanguage = language;
            this.setDirection(language);
        },

        /**
         * Sets the {@link #direction} to the desired direction according to
         * the language code specified.
         *
         * @fires `lang:direction:change` if the language direction has
         * changed.
         *
         * @param {string} lang Language code that the direction is based on.
         */
        setDirection: function(lang) {
            //FIXME: SC-3358 Should be getting the RTL languages from metadata.
            var rtlLanguages = ['he_IL', 'ar_SA'],
                isRTL = _.contains(rtlLanguages, lang),
                prevDirection = this.direction;

            this.direction = isRTL ? 'rtl' : 'ltr';

            if (this.direction !== prevDirection) {
                app.trigger('lang:direction:change');
            }
        }
    });
})(SUGAR.App);
