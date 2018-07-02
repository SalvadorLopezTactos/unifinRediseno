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
 * Handlebars helpers.
 *
 * These functions are to be used in handlebars templates.
 *
 * @class View.Handlebars.helpers
 */
(function(app) {

    /**
     * Creates a field widget.
     *
     * Example:
     * <pre><code>
     * {{field view model=mymodel template=edit parent=fieldset}}
     * </code></pre>
     *
     * @method field
     * @param {View.View} view Parent view
     * @param {Object} [options] Optional params to pass to the field.
     * @param {Backbone.Model} [options.model] The model associated with the field.
     * @param {check type } [options.template] The name of the template to be used.
     * @param {Field} [options.parent] The parent field of this field.
     * @return {Object} HTML placeholder for the widget as handlebars safe string.
     */
    Handlebars.registerHelper('field', function(view, options) {
        var field = app.view.createField({
            def: this,
            view: view,
            model: options.hash.model,
            viewName: options.hash.template
        });

        if (options.hash.parent && _.isArray(options.hash.parent.fields)) {
            options.hash.parent.fields.push(field);
        }

        return field.getPlaceholder();
    });

    /**
     * Creates a field widget.
     *
     * This helper is used for fields that don't have view definition.
     *
     * @method fieldOfType
     * @param {String} type Field type
     * @param {String} label Label key
     * @return {Object} HTML placeholder for the widget as handlebars safe string.
     */
    Handlebars.registerHelper('fieldOfType', function(type, label) {
        var def = {
            type: type,
            name: type,
            label: label
        };

        var field = app.view.createField({
            def: def,
            view: this
        });

        return field.getPlaceholder();
    });

    /**
     * Iterates through options specified by a key.
     *
     * The options collection is retrieved from the language helper.
     * @method eachOptions
     * @param {String} key Options key.
     * @param {Function} hbsOptions HBS options.
     * @return {String} HTML string.
     */
    Handlebars.registerHelper('eachOptions', function(key, hbsOptions) {
        var options,
            ret = "",
            iterator;

        // Retrieve app list strings
        options = _.isString(key) ? app.lang.getAppListStrings(key) : key;

        if (_.isArray(options)) {
            iterator = function(element, index) {
                ret = ret + hbsOptions.fn({key: index, value: element});
            };
        } else if (_.isObject(options)) { // Is object evaluates arrays to true, so put it second
            iterator = function(value, key) {
                ret = ret + hbsOptions.fn({key: key, value: value});
            };
        }
        else {
            options = null;
        }

        // Don't iterate if options is not iteratable
        if (options) _.each(options, iterator, this);

        return ret;
    });

    /**
     * @method buildRoute
     * Builds a route based on hashes sent on handlebars helper.
     *
     * Example:
     * <pre><code>
     * {{buildRoute context=this.context}}
     * {{buildRoute model=myModel action="create"}}
     * {{buildRoute module="Employees" action="edit"}}
     * </code></pre>
     *
     * If both `module` and `model` are sent, `module` will take precedence
     * over `model.module`.
     * Same applies for `id` (`id` will take precedence over `model.id`).
     *
     * @param {Object} options Handlebars options hash.
     * @param {Object} options.hash More parameters to be used by this helper.
     *   It needs at least one of `options.hash.module`, `options.hash.model`
     *   or `options.hash.context`.
     * @param {String} [options.hash.module=options.hash.model.module]
     *   The name of the module.
     * @param {Data.Bean} [options.hash.model=options.hash.context.get('model')]
     *   The model to extract the module and/or id.
     * @param {Core.Context} [options.hash.context]
     *   A context to extract the module from.
     * @param {String} [options.hash.id=options.hash.model.id]
     *   The id of the bean record.
     * @param {String} [options.hash.action]
     *   The action name.
     * @return {String}
     *   The built route.
     */
    Handlebars.registerHelper('buildRoute', function(options) {
        var ctx = options.hash.context,
            model = options.hash.model || ((ctx && ctx.get('model')) ? ctx.get('model') : {}),
            module = options.hash.module || model.module || ((ctx && ctx.get('module')) ? ctx.get('module') : null),
            id = options.hash.id || model.id,
            action = options.hash.action;

        return app.router.buildRoute(module, id, action);
    });

    /**
     * Extracts bean field value.
     * @method getFieldValue
     * @param {Data.Bean} bean Bean instance.
     * @param {String} field Field name.
     * @param {String} defaultValue(optional) Default value to return if field is not set on a bean.
     * @return {String} Field value of the given bean. If field is not set the default value or empty string.
     *
     * @deprecated since 7.2.0. Please use {@link #fieldValue} helper.
     */
    Handlebars.registerHelper('getFieldValue', function(bean, field, defaultValue) {
        app.logger.warn('getFieldValue handlebars helper is deprecated and will be removed in 7.8. ' +
            'Please use the fieldValue handlebars helper instead.');
        defaultValue = _.isObject(defaultValue) ? '' : defaultValue;
        return bean.get(field) || defaultValue || '';
    });

    /**
     * @method fieldValue
     *
     * Extracts bean field value.
     *
     * @param {Data.Bean} bean Bean instance.
     * @param {String} field Field name.
     * @param {String} [defaultValue=''] Default value to return if field
     *   is not set on a bean.
     *
     * @return {String} Field value of the given bean. If field is not set the
     *   default value or empty string.
     */
    Handlebars.registerHelper('fieldValue', function(bean, field, options) {
        return bean.get(field) || options.hash.defaultValue || '';
    });

    /**
     * Executes a given block if a given array has a value.
     * @method has
     * @param {String/Object} val value
     * @param {Object/Array} array or hash object
     * @return {String} Result of the `block` execution if the `array` contains `val` or the result of the inverse block.
     */
    Handlebars.registerHelper('has', function(val, array, options) {
        // Since we need to check both just val = val 2 and also if val is in an array, we cast
        // non arrays into arrays
        if (!_.isArray(array) && !_.isObject(array)) {
            array = [array];
        }

        return _.include(array, val) ? options.fn(this) : options.inverse(this);
    });

    /**
     * Executes a given block if a given array doesn't have a value.
     * @method notHas
     * @param {String/Object} val value
     * @param {Object/Array} array or hash object
     * @return {String} Result of the `block` execution if the `array` doesn't contain `val` or the result of the inverse block.
     */
    Handlebars.registerHelper('notHas', function(val, array, options) {
        var fn = options.fn, inverse = options.inverse;
        options.fn = inverse;
        options.inverse = fn;

        return Handlebars.helpers['has'].call(this, val, array, options);
    });

    /**
     * We require sortable to be the default if not defined in either field viewdef or vardefs. Otherwise,
     * we use whatever is provided in either field vardefs or field's viewdefs where the view def has more
     * specificity.
     * @method has
     * @param {String} module name
     * @param {Object} the field view defintion (e.g. looping through meta.panels.field it will be 'this')
     * @return {String} Result of the `block` execution if sortable, otherwise empty string.
     */
    Handlebars.registerHelper('isSortable', function(module, fieldViewdef, options) {
        if (app.utils.isSortable(module, fieldViewdef)) {
            return options.fn(this);
        } else {
            return '';
        }
    });

    /**
     * Executes a given block if a given values are equal.
     * @method eq
     * @param {String} val1 first value to compare
     * @param {String} val2 second value to compare.
     * @return {String} Result of the `block` execution if the given values are equal or the result of the inverse block.
     */
    Handlebars.registerHelper('eq', function(val1, val2, options) {
        return val1 == val2 ? options.fn(this) : options.inverse(this);
    });

    /**
     * Opposite of `eq` helper.
     * @method notEq
     * @param {String} val1 first value to compare
     * @param {String} val2 second value to compare.
     * @return {String} Result of the `block` execution if the given values are not equal or the result of the inverse block.
     */
    Handlebars.registerHelper('notEq', function(val1, val2, options) {
        return val1 != val2 ? options.fn(this) : options.inverse(this);
    });

    /**
     * Same as eq helper but second value is a {String} regex expression. Unfortunately, we have to do this because the
     * Handlebar's parser gets confused by regex literals like /foo/
     * @method match
     * @param {String} val1 first value to compare
     * @param {String} val2 A String representing a RegExp constructor argument. So if RegExp('foo.*') is the desired regex,
     * val2 would contain "foo.*". No support for modifiers.
     * @return {String} Result of the `block` execution if the given values are equal or the result of the inverse block.
     */
    Handlebars.registerHelper('match', function(val1, val2, options) {
        var re = new RegExp(val2);
        if (re.test(val1)) {
            return options.fn(this);
        } else {
            return options.inverse(this);
        }
    });

    /**
     * Same as notEq helper but second value is a {String} regex expression.
     * @method notMatch
     * @param {String} val1 first value to compare
     * @param {String} val2 A String representing a RegExp constructor argument. So if RegExp('foo.*') is the desired regex,
     * val2 would contain "foo.*". No support for modifiers.
     * @return {String} Result of the `block` execution if the given values are not equal or the result of the inverse block.
     */
    Handlebars.registerHelper('notMatch', function(val1, val2, options) {
        var re = new RegExp(val2);
        if (!re.test(val1)) {
            return options.fn(this);
        } else {
            return options.inverse(this);
        }
    });

    /**
     * Logs a value.
     * @method log
     * @param value
     */
    Handlebars.registerHelper("log", function(value) {
        app.logger.debug("*****HBS: Current Context*****");
        app.logger.debug(this);
        app.logger.debug("*****HBS: Current Value*****");
        app.logger.debug(value);
        console.log(value);
        app.logger.debug("***********************");
    });

    /**
     * Retrives a string by key.
     *
     * The helper queries {@link Core.Language} module to retrieve an i18n-ed string.
     * @method str
     * @param {String} key Key of the label.
     * @param {String} module(optional) Module name.
     * @param {String} content(optional) Template content.
     * @return {String} The string for the given label key.
     */
    Handlebars.registerHelper("str", function(key, module, content) {
        module = _.isString(module) ? module : null;
        return app.lang.get(key, module, content);
    });

    /**
     * Creates a relative time element to display the human readable related
     * time.
     *
     * To provide an automatic update of this relative time, use a plugin like
     * {@link sugar.liverelativetime.js}.
     *
     * @method relativeTime
     * @param {String} iso8601 The ISO-8601 date string to be used for a new
     *   date.
     * @param {Object} [options] Handlebars options hash.
     * @param {Object} [options.hash] More parameters to be used by this helper.
     * @param {String} [options.hash.title] The title attribute. Defaults to
     *   current user date/time preference format.
     * @param {boolean} [options.hash.dateOnly] Setting this to `true` will
     *   format the `title` attribute with the user-formatted date only.
     * @return {string} The relative time like `10 minutes ago`.
     */
    Handlebars.registerHelper('relativeTime', function(iso8601, options) {

        var date = app.date(iso8601),
            attrs, html;

        options.hash.title = options.hash.title || date.formatUser(options.hash.dateOnly);

        attrs = _.map(options.hash, function(attr, key) {
            return key + '="' + Handlebars.Utils.escapeExpression(attr) + '"';
        }).join(' ');

        // TODO we need to support dateOnly on formatNow().
        html = '<time datetime="' + date.format() + '" ' + attrs + '>' + date.fromNow() + '</time>';

        return new Handlebars.SafeString(html);
    });

    /**
     * Joins an arrays elements by a glue string
     * @method field
     * @param {Array} array Array of strings
     * @param {String} glue string glue
     * @return {String} String
     */
    Handlebars.registerHelper('arrayJoin', function(array, glue) {
        return array.join(glue);
    });

    /**
     * Converts `\r\n`, `\n\r`, `\r`, `\n` to `<br>`.
     * @method nl2br
     * @param {String} s Raw string to filter
     * @return {String} String
     */
    Handlebars.registerHelper('nl2br', function(s) {
        s = Handlebars.Utils.escapeExpression(s);
        var nl2br = s.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br>');
        return new Handlebars.SafeString(nl2br);
    });

    /**
     * Formats given currency to users preferences
     * @method formatCurrency
     * @param {Number} number      The number to format.
     * @param {String|Object} currencyId  The currency id.
     * @return {String} The formatted number.
     */
    Handlebars.registerHelper('formatCurrency', function(number, currencyId) {
        if (_.isObject(currencyId)) {
            currencyId = currencyId.hash.currencyId || undefined;
        }
        return app.currency.formatAmountLocale(number, currencyId);
    });

    /**
     * Formats a given string by returning the first n characters.
      */
    Handlebars.registerHelper('firstChars', function(text, n) {
        return text.substring(0, n);
    });

    /**
     * Formats given date to users preferences
     * @method formatDate
     * @param {Date|string} date The date to format.
     * @param {Object} [options] More attributes to be used on this element for
     *   reuse.
     * @param {Object} [options.hash] More parameters to be used by this helper.
     * @param {boolean} [options.hash.dateOnly] Flag to determine whether to
     *   return just date current user date/time preference format.
     * @return {string} The formatted date.
     */
    Handlebars.registerHelper('formatDate', function(date, options) {
        var date = app.date(date);

        return date.formatUser(options.hash.dateOnly);
    });

    /**
     * Gets the translated module name (plural or singular).
     *
     * For instance, to get the singular version of the module name (make sure
     * `LBL_MODULE_NAME_SINGULAR` is defined in the module language strings of
     * your module):
     *
     *     {{getModuleName 'Accounts'}}
     *
     * To get the plural version, set `plural` to true and make sure
     * `LBL_MODULE_NAME` is defined in the module language strings of your
     * module:
     *
     *     {{getModuleName 'Accounts' plural=true}}
     *
     * You can pass a default value that will be returned in case the module
     * language string of your module is not found. The following example will
     * return 'Module' (since `LBL_MODULE` is defined in the module strings or
     * the app strings):
     *
     *     {{getModuleName 'undefinedModule' defaultValue='LBL_MODULE'}}
     *
     * In the worst case scenario (the module language string is not found and
     * no default value is specified), the module key name is returned. The
     * following example will return 'undefinedModule':
     *
     *     {{getModuleName 'undefinedModule'}}
     *
     * @param {string} module The module defined in the language strings.
     * @param {Object} [options] Optional params to pass to the helper.
     * @param {Object} [options.hash] More parameters to be used by this helper.
     * @param {boolean} [options.hash.plural] Returns the plural form if `true`,
     *   singular otherwise.
     * @param {string} [options.hash.defaultValue] Value to be returned if the
     *   module language string is not found.
     * @return {string} The module name.
     */
    Handlebars.registerHelper('getModuleName', function(module, options) {
        var options = {
            plural: options.hash.plural,
            defaultValue: options.hash.defaultValue
        };
        return app.lang.getModuleName(module, options);
    });

    /**
     * @method partial
     * Helper for rendering a partial template. This helper can load a partial from the templateOptions
     * or from the same relative location as the current template.
     *
     *     {{partial 'partial-name' componentFrom defaultProperties dynamicProperty=value}}
     *
     * The data supplied to the partial with be an object with the list of
     * `dynamicProperty`s merged into `defaultProperties` object (defaults to
     * empty object if not explicitly passed).
     *
     *
     * For fields
     *
     *     {{partial 'edit' this properties fallbackTemplate='detail'}}
     *
     * For layouts
     *
     *     {{partial 'ActivityStream' this properties}}
     *
     * For views
     *
     *     {{partial 'record' this properties}}
     *
     * @param {string} name Name of the partial.
     * @param {view.View|view.Field|view.Layout} component The view component.
     * @param {Object} [properties] Data supplied to the partial. `options.hash`
     *   is merged into this before it is used for the template. This allows the
     *   partial to provide dynamic parameters on top of the default properties.
     *   The original component is kept as `templateComponent` in these
     *   properties.
     * @param {Object} [options] Optional params.
     * @param {Object} [options.hash] The hash of the optional params.
     * @param {Object} [options.hash.module=component.module] Module to use.
     * @param {Object} [options.hash.fallbackTemplate] Fallback template for
     *   field partials.
     * @return {string} The handlebars safestring for the partial template.
     */
    Handlebars.registerHelper('partial', function(name, component, properties, options) {
        var module, template, data;

        // `properties` is optional, so `options` is `properties` is no `properties` is passed.
        if (!options && properties.hash) {
            options = properties;
            properties = {};
        }

        // Data supplied to the partial
        data = _.extend({templateComponent: component}, properties, options.hash);

        module = options.hash.module || component.module;
        if (component && component.options.templateOptions && component.options.templateOptions.partials) {
            template = component.options.templateOptions.partials[name];
        }
        // TODO: need to do recursive walk up the tree if template is not found, until we find it. see _super in component.js for an example
        else if (component instanceof app.view.Field) {
            var fallbackTemplate = options.hash.fallbackTemplate;
            template = app.template.getField(
                component.type, // field type
                name || 'detail', // template name
                module,
                fallbackTemplate);
        }
        else if (component instanceof app.view.View) {
            var templateName = component.tplName;

            //FIXME SC-3363 use the real inheritance chain when loading partial templates
            //Try the current component first in case the template was overriden.
            template = app.template.getView(component.name + '.' + name, module) ||
                app.template.getView(component.name + '.' + name);

            if (!template && templateName) {
                template = app.template.getView(templateName + '.' + name, module) ||
                    app.template.getView(templateName + '.' + name);
            }
        }
        else if (component instanceof app.view.Layout) {
            template = app.template.getLayout(component.name + '.' + name, module) || app.template.getLayout(component.name + '.' + name);
        }
        return new Handlebars.SafeString(template ? template(data) : '');
    });
})(SUGAR.App);
