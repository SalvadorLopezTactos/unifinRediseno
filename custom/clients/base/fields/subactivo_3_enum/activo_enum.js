/**
 * @file   custom/clients/base/fields/activo_enum/activo_enum.js
 * @author jescamilla@levementum.com
 * @date   7/13/2015 4:07 PM
 * @brief  js para el combo de activo
 */

/**
 * @class View.Fields.Base.EnumField
 * @alias SUGAR.App.view.fields.BaseEnumField
 * @extends View.Field
 */
({
    fieldTag: 'input.select2',

    plugins: ['EllipsisInline'],

    /**
     * HTML tag of the append value checkbox.
     *
     * @property {String}
     */
    appendValueTag: 'input[name=append_value]',

    /**
     * Whether the value of this enum should be defaulted to the first item when model attribute is undefined
     * Set to false to prevent this defaulting
     */
    defaultOnUndefined: true,

    //For multi select, we replace the empty key by a temporary key because Select2 doesn't handle empty values well
    BLANK_VALUE_ID: '___i_am_empty___',

    /**
     * Whether this field is in the midst of fetching options for its dropdown.
     *
     * @type {Boolean}
     */
    isFetchingOptions: false,


    /**
     * The dropdown elements.
     *
     *     @example The format of the object is:
     *     ```
     *     {
     *         "key1": "value1",
     *         "key2": "value2",
     *         "key3": "value3"
     *     }
     *     ```
     *
     * @type {Object}
     */
    items: null,

    /**
     * The keys of dropdown elements and their index in the related
     * `app_list_keys` array.
     *
     *     @example The format of the object is:
     *     ```
     *     {
     *         "key1": 1,
     *         "key2": 0,
     *         "key3": 2
     *     }
     *     ```
     *
     * If no `app_list_keys` entry, or if elements in the expected order, the
     * object will be empty.
     *
     * @type {Object}
     */
    _keysOrder: null,

    /**
     * Bind the additional keydown handler on select2
     * search element (affected by version 3.4.3).
     *
     * Invoked from {@link app.plugins.Editable}.
     * @param {Function} callback Callback function for keydown.
     */
    bindKeyDown: function(callback) {
        var $el = this.$(this.fieldTag);
        if ($el) {
            $el.on('keydown.record', {field: this}, callback);
            var plugin = $el.data('select2');
            if (plugin) {
                if (plugin.focusser) {
                    plugin.focusser.on('keydown.record', {field: this}, callback);
                }
                plugin.search.on('keydown.record', {field: this}, callback);
            }
        }
    },

    /**
     * Unbind the additional keydown handler.
     *
     * Invoked from {@link app.plugins.Editable}.
     * @param {Function} callback Callback function for keydown.
     */
    unbindKeyDown: function(callback) {
        if (this.$el) {
            var $el = this.$(this.fieldTag);
            if ($el) {
                $el.off('keydown.record', callback);
                var plugin = $el.data('select2');
                if (plugin) {
                    plugin.search.off('keydown.record', callback);
                }
            }
        }
    },

    /**
     * @returns {Field} this
     * @override
     * @private
     */
    _render: function() {
        var self = this;
        if (!this.items || _.isEmpty(this.items)) {
            this.loadEnumOptions(false, function() {
                self.isFetchingOptions = false;
                //Re-render widget since we have fresh options list
                if(!self.disposed){
                    self.render();
                }
            });
            if (this.isFetchingOptions){
                return this;
            }
        }
        //Use blank value label for blank values on multiselects
        if (this.def.isMultiSelect && !_.isUndefined(this.items['']) && this.items[''] === '') {
            var obj = {};
            _.each(this.items, function(value, key) {
                // Only work on key => value pairs that are not both blank
                if (key !== '' && value !== '') {
                    obj[key] = value;
                }
            }, this);
            this.items = obj;
        }
        var optionsKeys = _.isObject(this.items) ? _.keys(this.items) : [];
        //After rendering the dropdown, the selected value should be the value set in the model,
        //or the default value. The default value fallbacks to the first option if no other is selected.
        // if the user has write access to the model for the field we are currently on
        if (this.defaultOnUndefined && !this.def.isMultiSelect && _.isUndefined(this.model.get(this.name))
            && app.acl.hasAccessToModel('write', this.model, this.name)
        ) {
            var defaultValue = this._getDefaultOption(optionsKeys);
            if (defaultValue) {
                // call with {silent: true} on, so it won't re-render the field, since we haven't rendered the field yet
                this.model.set(this.name, defaultValue, {silent: true});
                //Forecasting uses backbone model (not bean) for custom enums so we have to check here
                if (_.isFunction(this.model.setDefault)) {
                    this.model.setDefault(this.name, defaultValue);
                }
            }
        }
        app.view.Field.prototype._render.call(this);
        // if displaying the noaccess template, just exit the method
        if (this.tplName == 'noaccess') {
            return this;
        }
        var select2Options = this.getSelect2Options(optionsKeys);
        var $el = this.$(this.fieldTag);
        if (!_.isEmpty(optionsKeys)) {
            //FIXME remove check for tplName SC-2608
            if (this.tplName === 'edit' || this.tplName === 'list-edit' || this.tplName === 'massupdate') {
                $el.select2(select2Options);
                var plugin = $el.data('select2');
                if (plugin && plugin.focusser) {
                    plugin.focusser.on('select2-focus', _.bind(_.debounce(this.handleFocus, 0), this));
                }
                $el.select2("container").addClass("tleft");
                $el.on('change', function(ev){
                    var value = ev.val;
                    if (_.isUndefined(value)) {
                        return;
                    }
                    if(self.model && !(self.name == 'currency_id' && _.isUndefined(value))) {
                        self.model.set(self.name, self.unformat(value));
                        //Forecasting uses backbone model (not bean) for custom enums so we have to check here
                        if (_.isFunction(self.model.removeDefault)) {
                            self.model.removeDefault(self.name)
                        }

                    }
                });
                if (this.def.ordered) {
                    $el.select2("container").find("ul.select2-choices").sortable({
                        containment: 'parent',
                        start: function() {
                            $el.select2("onSortStart");
                        },
                        update: function() {
                            $el.select2("onSortEnd");
                        }
                    });
                }
            } else if(this.tplName === 'disabled') {
                $el.select2(select2Options);
                $el.select2('disable');
            }
            //Setup selected value in Select2 widget
            if(!_.isUndefined(this.value)){
                // To make pills load properly when autoselecting a string val
                // from a list val needs to be an array
                if (!_.isArray(this.value)) {
                    this.value = [this.value];
                }
                $el.select2('val', this.value);
            }
        } else {
            // Set loading message in place of empty DIV while options are loaded via API
            this.$el.html(app.lang.get("LBL_LOADING"));
        }
        return this;
    },

    /**
     * Called when focus on inline editing
     */
    focus: function () {
        //We must prevent focus for multi select otherwise when inline editing the dropdown is opened and it is
        //impossible to click on a pill `x` icon in order to remove an item
        if(this.action !== 'disabled' && !this.def.isMultiSelect) {
            this.$(this.fieldTag).select2('open');
        }
    },

    /**
     * Load the options for this field and pass them to callback function.  May be asynchronous.
     * @param {Boolean} fetch (optional) Force use of Enum API to load options.
     * @param {Function} callback (optional) Called when enum options are available.
     */
    loadEnumOptions: function(fetch, callback) {
        var self = this,
            meta = app.metadata.getModule(this.module, 'fields'),
            fieldMeta = meta && meta[this.name] ? meta[this.name] : this.def;
        this.items = this.def.options || fieldMeta.options;
        fetch = fetch || false;

        if (fetch || !this.items) {
            this.isFetchingOptions = true;
            var _key = 'request:' + this.module + ':' + this.name;
            //if previous request is existed, ignore the duplicate request
            if (this.context.get(_key)) {
                var request = this.context.get(_key);
                request.xhr.done(_.bind(function (o) {
                    if (this.items !== o) {
                        this.items = o;
                        callback.call(this);
                    }
                }, this));
            } else {
                var activo_subactivo_url = app.api.buildURL('subActivoAPI?activo=' + this.model.get('sub_activo_2_c'),
                    null, null, null);
                app.api.call('READ', activo_subactivo_url, {}, {
                    success: function (data) {
                        self.items = data;
                        this.items = data;
                        callback.call(this);
                    }
                });


            }
        } else if (_.isString(this.items)) {
            this.items = app.lang.getAppListStrings(this.items);
        };
    },

    /**
     * Helper function for generating Select2 options for this enum
     * @param {Array} optionsKeys Set of option keys that will be loaded into Select2 widget
     * @returns {{}} Select2 options, refer to Select2 documentation for what each option means
     */
    getSelect2Options: function(optionsKeys){
        var select2Options = {};
        var emptyIdx = _.indexOf(optionsKeys, "");
        if (emptyIdx !== -1) {
            select2Options.allowClear = true;
            // if the blank option isn't at the top of the list we have to add it manually
            if (emptyIdx > 1) {
                this.hasBlank = true;
            }
        }

        /* From http://ivaynberg.github.com/select2/#documentation:
         * Initial value that is selected if no other selection is made
         */
        if(!this.def.isMultiSelect) {
            select2Options.placeholder = app.lang.get("LBL_SEARCH_SELECT");
        }
        // Options are being loaded via app.api.enum
        if(_.isEmpty(optionsKeys)){
            select2Options.placeholder = app.lang.get("LBL_LOADING");
        }

        /* From http://ivaynberg.github.com/select2/#documentation:
         * "Calculate the width of the container div to the source element"
         */
        select2Options.width = this.def.enum_width ? this.def.enum_width : '100%';

        /* Because the select2 dropdown is appended to <body>, we need to be able
         * to pass a classname to the constructor to allow for custom styling
         */
        select2Options.dropdownCssClass = this.def.dropdown_class ? this.def.dropdown_class : '';

        /* To get the Select2 multi-select pills to have our styling, we need to be able
         * to either pass a classname to the constructor to allow for custom styling
         * or set the 'select2-choices-pills-close' if the isMultiSelect option is set in def
         */
        select2Options.containerCssClass = this.def.container_class ? this.def.container_class : (this.def.isMultiSelect ? 'select2-choices-pills-close' : '');

        /* Because the select2 dropdown is calculated at render to be as wide as container
         * to make it differ the dropdownCss.width must be set (i.e.,100%,auto)
         */
        if (this.def.dropdown_width) {
            select2Options.dropdownCss = { width: this.def.dropdown_width };
        }

        /* All select2 dropdowns should only show the search bar for fields with 7 or more values,
         * this adds the ability to specify that threshold in metadata.
         */
        select2Options.minimumResultsForSearch = this.def.searchBarThreshold ? this.def.searchBarThreshold : 7;

        /* If is multi-select, set multiple option on Select2 widget.
         */
        if (this.def.isMultiSelect) {
            select2Options.multiple = true;
        }

        /* If we need to define a custom value separator
         */
        select2Options.separator = this.def.separator || ',';
        if (this.def.separator) {
            select2Options.tokenSeparators = [this.def.separator];
        }

        select2Options.initSelection = _.bind(this._initSelection, this);
        select2Options.query = _.bind(this._query, this);
        select2Options.sortResults = _.bind(this._sortResults, this);

        return select2Options;
    },

    /**
     * Set the option selection during select2 initialization.
     * Also used during drag/drop in multiselects.
     * @param {Selector} $ele Select2 element selector
     * @param {Function} callback Select2 data callback
     * @private
     */
    _initSelection: function($ele, callback){
        var data = [];
        var options = _.isString(this.items) ? app.lang.getAppListStrings(this.items) : this.items;
        var values = $ele.val();
        if (this.def.isMultiSelect) {
            values = values.split(this.def.separator || ',');
        }
        _.each(_.pick(options, values), function(value, key){
            data.push({id: key, text: value});
        }, this);
        if(data.length === 1){
            callback(data[0]);
        } else {
            callback(data);
        }
    },

    /**
     * Adapted from eachOptions helper in hbt-helpers.js
     * Select2 callback used for loading the Select2 widget option list
     * @param {Object} query Select2 query object
     * @private
     */
    _query: function(query){
        var options = _.isString(this.items) ? app.lang.getAppListStrings(this.items) : this.items;
        var data = {
            results: [],
            // only show one "page" of results
            more: false
        };
        if (_.isObject(options)) {
            _.each(options, function(element, index) {
                var text = "" + element;
                //additionally filter results based on query term
                if(query.matcher(query.term, text)){
                    data.results.push({id: index, text: text});
                }
            });
        } else {
            options = null;
        }
        query.callback(data);
    },

    /**
     * Sort the dropdown items.
     *
     * - If `def.sort_alpha` is `true`, return the dropdown items sorted
     * alphabetically.
     * - If {@link Core.Language#getAppListKeys} is defined for
     * `this.def.options`, return the items in this order.
     * - Otherwise, fall back to the default behavior and just return the
     * `results`.
     *
     * This method is the implementation of the select2 `sortResults` option.
     * See {@link http://ivaynberg.github.io/select2/ official documentation}.
     *
     * @param {Array} results The list of results `{id: *, text: *}.`
     * @param {jQuery} container jQuery wrapper of the node that should contain
     *  the representation of the result.
     * @param {Object} query The query object used to request this set of
     *  results.
     * @return {Array} The list of results {id: *, text: *} sorted.
     * @private
     */
    _sortResults: function(results, container, query) {
        var keys, sortedResults;

        if (this.def.sort_alpha) {
            sortedResults = _.sortBy(results, function(item) {
                return item.text;
            });
            return sortedResults;
        }

        if (!this._keysOrder) {
            this._keysOrder = {};
            keys = _.map(app.lang.getAppListKeys(this.def.options), function(key) {
                return key.toString();
            });
            if (!_.isEqual(keys, _.keys(this.items))) {
                _.each(keys, function(key, index) {
                    return this._keysOrder[key] = index;
                }, this);
            }
        }
        if (_.isEmpty(this._keysOrder)) {
            return results;
        }
        sortedResults = results;
        // if it is not a dependency field (visibility_grid is not defined), we show the order from drop down list
        if (!this.def.visibility_grid) {
            sortedResults = _.sortBy(results, function(item) {
                return this._keysOrder[item.id];
            }, this);
        }
        return sortedResults;
    },

    /**
     * Helper function for retrieving the default value for the selection
     * @param {Array} optionsKeys Set of option keys that will be loaded into Select2 widget
     * @returns {String} The default value
     */
    _getDefaultOption: function (optionsKeys) {
        return _.first(optionsKeys);
    },

    /**
     *  Convert select2 value into model appropriate value for sync
     *
     * @param value Value from select2 widget
     * @return {String|Array} Unformatted value as String or String Array
     */
    unformat: function(value){
        if (this.def.isMultiSelect && _.isArray(value) && _.indexOf(value, this.BLANK_VALUE_ID) > -1) {
            value = _.clone(value);

            // Delete empty values from the options array
            delete value[this.BLANK_VALUE_ID];
        }
        if(this.def.isMultiSelect && _.isNull(value)){
            return [];  // Returning value that is null equivalent to server.  Backbone.js won't sync attributes with null values.
        } else {
            return value;
        }
    },

    /**
     * Convert server value into one appropriate for display in widget
     *
     * @param value
     * @return {Array} Value for select2 widget as String Array
     */
    format: function(value){
        if (this.def.isMultiSelect && _.isArray(value) && _.indexOf(value, '') > -1) {
            value = _.clone(value);

            // Delete empty values from the select list
            delete value[''];
        }
        if(this.def.isMultiSelect && _.isString(value)){
            return this.convertMultiSelectDefaultString(value);
        } else {
            return value;
        }
    },

    /**
     * Converts multiselect default strings into array of option keys for template
     * @param {String} defaultString string of the format "^option1^,^option2^,^option3^"
     * @return {Array} of the format ["option1","option2","option3"]
     */
    convertMultiSelectDefaultString: function(defaultString) {
        var result = defaultString.split(",");
        _.each(result, function(value, key) {
            // Remove empty values in the selection
            if (value !== '^^') {
                result[key] = value.replace(/\^/g,"");
            }
        });
        return result;
    },

    /**
     * {@inheritDoc}
     * Avoid rendering process on select2 change in order to keep focus.
     */
    bindDataChange: function() {
        if (this.model) {
            this.model.on('change:' + this.name, function() {
                if (_.isEmpty(this.$(this.fieldTag).data('select2'))) {
                    this.render();
                } else {
                    this.$(this.fieldTag).select2('val', this.model.get(this.name));
                }
            }, this);
        }
    },

    /**
     * Override to remove default DOM change listener, we use Select2 events instead
     * Binds append value checkbox change for massupdate.
     *
     * @override
     */
    bindDomChange: function() {
        var $el = this.$(this.appendValueTag);
        if ($el.length) {
            $el.on('change', _.bind(function() {
                this.appendValue = $el.prop('checked');
                //FIXME: Should use true booleans (SC-2828)
                this.model.set(this.name + '_replace', this.appendValue ? '1' : '0');
            }, this));
        }
    },

    /**
     * @override
     */
    unbindDom: function() {
        this.$(this.appendValueTag).off();
        this.$(this.fieldTag).select2('destroy');
        this._super('unbindDom');
    },

    /**
     * @override
     */
    unbindData: function() {
        var _key = 'request:' + this.module + ':' + this.name;
        this.context.unset(_key);
        app.view.Field.prototype.unbindData.call(this);
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        this.unbindKeyDown();
        this._super('_dispose');
    }
})
