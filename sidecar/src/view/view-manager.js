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
 * View manager is used to create views, layouts, and fields based on optional
 * metadata inputs.
 *
 * The view manager's factory methods (`createView`, `createLayout`, and
 * `createField`) first check `views`, `layouts`, and `fields` hashes
 * respectively for custom class declaration before falling back the base class.
 *
 * Note the following is deprecated in favor of putting these controllers in the
 * `sugarcrm/clients/<platform>` directory, or using one of the appropriate
 * factory methods like `createView`, `createField`, or `createLayout`. Using
 * either of these idioms, your components will be internally namespaced by
 * platform for you. If you do choose to use the following idiom of defining
 * your controller directly on `app.view.<type>`, please be forewarned that you
 * will lose any automatic namespacing benefits and possibly encounter naming
 * collisions if your controller names are not unique. If you must define
 * directly, you may choose to prefix your controller name by your application
 * or platform e.g. `MyappMyCustom<Type>` where 'Myapp' is the platform prefix.
 *
 * Put declarations of your custom views, layouts, fields in the corresponding
 * hash (see note above; this is deprecated):
 * <pre><code>
 * app.view.views.MyappMyCustomView = app.view.View.extend({
 *  // Put your custom logic here
 * });
 *
 * app.view.layouts.MyappMyCustomLayout = app.view.Layout.extend({
 *  // Put your custom logic here
 * });
 *
 * app.view.fields.MyappMyCustomField = app.view.Field.extend({
 *  // Put your custom logic here
 * });
 *
 * </code></pre>
 *
 *
 * @class View.ViewManager
 * @alias SUGAR.App.view
 * @singleton
 */
(function(app) {

    // Ever incrementing field ID
    var _sfId = 0;

    var _viewManager = {

        /**
         * Resets class declarations of custom components.
         */
        reset: function() {
            _.each(this.layouts, function(layout, name) {
                delete this.layouts[name];
            }, this);
            _.each(this.views, function(view, name) {
                delete this.views[name];
            }, this);
            _.each(this.fields, function(field, name) {
                delete this.fields[name];
            }, this);
        },

        /**
         * Gets ID of the last created field.
         * @return {number} ID of the last created field.
         */
        getFieldId: function() {
            return _sfId;
        },

        /**
         * Hash of view classes.
         */
        views: {},

        /**
         * Hash of layout classes.
         */
        layouts: {},

        /**
         * Hash of field classes.
         */
        fields: {},

        /**
         * Creates an instance of a component and binds data changes to it.
         *
         * @param {string} type Component type (`layout`, `view`, `field`).
         * @param {string} name Component name.
         * @param {Object} params Parameters to pass to the Component's class
         *   constructor.
         * @param {string} params.type The component type.
         * @param {string} params.module The component's module.
         * @param {string} [params.loadModule=params.module] The module to
         *   create the component from.
         * @return {View.Component} New instance of a component.
         * @private
         */
        _createComponent: function(type, name, params) {
            var Klass = this.declareComponent(type, params.type || name, params.loadModule || params.module,
                params.controller, false, this._getPlatform(params));
            var component = new Klass(params);
            component.trigger("init");
            component.bindDataChange();
            return component;
        },

        /**
         * Creates an instance of a view.
         *
         * Examples:
         *
         * Create a list view. The view manager will use metadata for the view
         * named 'list' defined in Contacts module.
         * The controller's current context will be set on the new view instance.
         *
         *     var listView = app.view.createView({
         *         type: 'list',
         *         module: 'Contacts'
         *     });
         *
         * Create a custom view class. Note the following is deprecated in favor
         * of putting these controllers in the `sugarcrm/clients/<platform>`
         * directory, or using one of the appropriate factory methods like
         * `createView`, `createField`, or `createLayout`. Using that idiom, the
         * metadata manager will declare these components and take care of
         * namespacing by platform for you. If you do choose to use the
         * following idiom please be forwarned that you will lose any
         * namespacing benefits and possibly encounter naming collisions!
         *
         *     // Declare your custom view class.
         *     // might cause collisions if another MyCustomView!
         *     app.view.views.MyCustomView = app.view.View.extend({
         *         // Put your custom logic here
         *     });
         *     // if you must define directly on app.view.views, you may instead
         *     // prefer to do:
         *     `app.view.views.<YOUR_PLATFORM>MyCustomView` = app.view.View.extend({
         *          // Put your custom logic here
         *     });
         *
         *     var myCustomView = app.view.createView({
         *         type: 'myCustom'
         *     });
         *
         * Create a view with custom metadata payload.
         *
         *     var view = app.view.createView({
         *         type: 'detail',
         *         meta: { ... your custom metadata ... }
         *     });
         *
         * Look at {@link View.View}, particularly
         * {@link View.View#_loadTemplate} for more information on how the
         * `meta.template` property can be used.
         *
         * @param {Object} params View parameters.
         * @param {string} params.type The view identifier (`default`, `base`,
         *   etc.). Matches the controller to be used.
         * @param {string} [params.name=params.type] View name that
         *   distinguishes between multiple instances of the same view type.This
         *   matches the metadata to read from {@link Core.MetadataManager} and
         *   it is the easier way to reuse view types with different
         *   configurations.
         * @param {Object} [params.context=app.controller.context] Context to
         * associate the newly created view with.
         * @param {string} [params.module] Module name.
         * @param {string} [params.loadModule] The module that should be
         *   considered the base.
         * @param {Object} [params.meta] Custom metadata.
         * @return {View.View} New instance of view.
         */
        createView: function(params) {
            // context is always defined on the controller
            params.context = params.context || app.controller.context;
            params.module = params.module || params.context.get('module');
            // name defines which metadata to load
            params.name = params.name || params.type;
            params.meta = params.meta || app.metadata.getView(params.module, params.name, params.loadModule);

            if (params.def && params.def.xmeta) {
                params.meta = _.extend({}, params.meta, params.def.xmeta);
            }

            // type defines which controller to use
            var meta = params.meta || {};
            params.type = params.type || meta.type || params.name;

            return this._createComponent('view', params.type, params);
        },

        /**
         * Creates an instance of a layout.
         *
         * Parameters define creation rules as well as layout properties.
         * The factory needs either layout name or type. Also, the layout type
         * must be specified. The layout type is retrieved either from the
         * `params` hash or layout metadata.
         *
         * Examples:
         *
         * Create a list layout. The view manager will use metadata for the
         * `list` layout defined in the Contacts module.
         * The controller's current context will be set on the new layout
         * instance.
         *
         *     var listLayout = app.view.createLayout({
         *         type: 'list',
         *         module: 'Contacts'
         *     });
         *
         *
         * Create a custom layout class. Note that following is deprecated in
         * favor of using the `createLayout` factory or placing controller in
         * `sugarcrm/clients/<platform>/layouts` in which case the metadata
         * manager will take care of namespacing your controller by platform
         * name for you (e.g. MyCustomLayout becomes
         * `app.view.layouts.MyappMyCustomLayout`).
         *
         *     // Declare your custom layout class.
         *     // might cause collisions if already a MyCustomLayout!
         *     app.view.layouts.MyCustomLayout = app.view.Layout.extend({
         *         // Put your custom logic here
         *     });
         *     // if you must define directly on app.view.layouts,
         *     // you may instead prefer to do:
         *     `app.view.layouts.<YOUR_PLATFORM>MyCustomLayout` = app.view.Layout.extend({
         *         // Put your custom logic here
         *     });
         *
         *     var myCustomLayout = app.view.createLayout({
         *         type: 'myCustom'
         *     });
         *
         * Create a layout with custom metadata payload.
         *
         *     var layout = app.view.createLayout({
         *         type: 'detail',
         *         meta: { ... your custom metadata ... }
         *     });
         *
         * @param {Object} params layout parameters.
         * @param {string} [params.type] Layout identifier (`default`, `base`,
         *   etc.).
         * @param {string} [params.name=params.type] Layout name that
         *   distinguishes between multiple instances of the same layout type.
         * @param {Object} [params.context=app.controller.context]
         *   Context to associate the newly created layout with.
         * @param {string} params.module Module name.
         * @param {string} [params.loadModule] The module to load the Layout
         *   from. Defaults to `params.module` or the context's module, in that
         *   order.
         * @param {Object} [params.meta] Custom metadata.
         * @return {View.Layout} New instance of the layout.
         */
        createLayout: function(params) {
            params.context = params.context || app.controller.context;
            params.module = params.module || params.context.get('module');
            // name defines which metadata to load
            params.name = params.name || params.type;
            params.meta = params.meta || app.metadata.getLayout(params.module, params.name, params.loadModule);

            if (params.def && params.def.xmeta) {
                params.meta = _.extend({}, params.meta, params.def.xmeta);
            }

            // type defines which controller to use
            var meta = params.meta || {};
            params.type = params.type || meta.type || params.name;

            return this._createComponent('layout', params.type, params);
        },

        /**
         * Creates an instance of a field and registers it with the parent view
         * (`params.view`).
         *
         * The parameters define creation rules as well as field properties.
         *
         * For example,
         *
         *     var params = {
         *         view: new Backbone.View,
         *         def: {
         *             type: 'text',
         *             name: 'first_name',
         *             label: 'LBL_FIRST_NAME'
         *         },
         *         context: optional context,
         *         model: optional model,
         *         meta: optional custom metadata,
         *         viewName: optional
         *     }
         *
         *
         * The view manager queries the metadata manager for field type specific
         * metadata (templates and JS controller) unless custom metadata is
         * passed in the `params` hash.
         *
         * Note the following is deprecated in favor of placing custom field
         * controllers in `sugarcrm/clients/<platform>/fields` or using the
         * `createField` factory.
         *
         * To create instances of custom fields, first declare its class in the
         * `app.view.fields` hash:
         *
         *     // might cause collision if MyCustomField already exists!
         *     app.view.fields.MyCustomField = app.view.Field.extend({
         *         // Put your custom logic here
         *     });
         *     // if you must define directly on app.view.fields
         *     // you may instead prefer to do:
         *     app.view.fields.<YOUR_PLATFORM>MyCustomField = app.view.Field.extend({ ...
         *
         *     var myCustomField = app.view.createField({
         *         view: someView,
         *         def: {
         *             type: 'myCustom',
         *             name: 'my_custom'
         *         }
         *     });
         *
         * @param {Object} params Field parameters.
         * @param {Backbone.View} params.view Backbone View object.
         * @param {Object} params.def Field definition.
         * @param {Object} [params.context=`SUGAR.App.controller.context`] The
         *   context.
         * @param {Object} [params.model] The model to use. If not specified,
         *   the model which is set on the context is used.
         * @param {Object} [params.meta] Custom metadata.
         * @param {string} [params.viewName=params.view.name] View name to
         *   determine the field template.
         * @return {View.Field} a new instance of field.
         */
        createField: function(params) {
            var type = params.viewDefs ? params.viewDefs.type : params.def.type;
            params.context = params.context || params.view.context || app.controller.context;
            params.model = params.model || params.context.get("model");
            params.module = params.module || (params.model && params.model.module ? params.model.module : params.context.get('module')) || "";
            if (params.meta) {
                app.logger.warn('`params.meta` is deprecated in `View.ViewManager#createField` since 7.8 and will be removed in 7.9.');
            }

            if (params.meta && params.meta.controller) params.controller = params.meta.controller;
            params.sfId = ++_sfId;

            var field = this._createComponent("field", type, params);
            // Register new field within its parent view.
            params.view.fields[field.sfId] = field;

            return field;
        },

        /**
         * Returns the platform from the given params, falling back to
         * `app.config.platform` or else 'base'.
         *
         * @param {Object} params Parameters.
         * @param [params.platform] The platform (`base`, `portal`, etc.).
         * @return {string} The platform.
         * @private
         */
        _getPlatform: function(params) {
            return params.platform || (app.config && app.config.platform ? app.config.platform : 'base');
        },

        /**
         * Gets a controller of type field, layout, or view.
         * @param {Object} params Parameters for the controller.
         * @param {string} params.type The controller type.
         * @param {string} params.name the filename of the controller
         *   (e.g. 'flex-list', 'record', etc.).
         * @param {string} [params.platform] The platform, e.g. 'portal'.
         *   Will first attempt to fall back to app.config.platform, then 'base'.
         * @param {string} [params.module] The module name.
         * @return {Object|null} The controller or `null` if not found.
         * @private
         */
        _getController: function(params) {
            var c = this._getBaseComponent(params.type, params.name, params.module, params.platform);
            //Check to see if we have the module specific class; if so return that
            if (c.cache[c.moduleBasedClassName]) {
                return c.cache[c.moduleBasedClassName];
            }
            return c.baseClass;
        },

        /**
         * This function is used to verify if a component has a certain plugin.
         *
         * @param {Object} params Set of parameters passed to function.
         * @param {string} params.type Type of component to check.
         * @param {string} params.name Name of component to check.
         * @param {string} params.plugin Name of plugin to check.
         * @param {string} [params.module=''] Name of module to check for custom
         *   components in.
         *
         * @return {boolean|null} `true` if the specified component exists and
         *   has that plugin, `false` if the component does not exist or lacks
         *   that plugin, and `null` if incorrect arguments were passed.
         */
        componentHasPlugin: function(params) {
            var controller;
            if (!params.type || !params.name || !params.plugin) {
                app.logger.error("componentHasPlugin requires type, name, and plugin parameters");
                return null;
            }
            controller = this._getController(params);
            return controller && controller.prototype &&
                _.contains(controller.prototype.plugins, params.plugin);
        },

        /**
         * Retrieves class declaration for a component or creates a new
         * component class.
         *
         * This method creates a subclass of the base class if controller
         * parameter is not null and such subclass hasn't been created yet.
         * Otherwise, the method tries to retrieve the most appropriate class by
         * searching in the following order:
         *
         * - Custom class name: `<module><component-name><component-type>`.
         * For example, for Contacts module one could have:
         * `ContactsDetailLayout`, `ContactsFluidLayout`, `ContactsListView`.
         *
         * - Class name: `<component-name><component-type>`.
         * For example: `ListLayout`, `ColumnsLayout`, `DetailView`, `IntField`.
         *
         * - Custom base class: `<capitalized-appId><component-type>`
         * For example, if `app.config.appId == 'portal'`, custom base classes
         * would be:
         * `PortalLayout`, `PortalView`, `PortalField`.
         *
         * Declarations of such classes must be in the `app.view` namespace.
         * There are use cases when an app has some common component code.
         * In such cases, using custom base classes is beneficial. For example,
         * any app may need to override validation error handling for fields:
         *
         *     // Assuming app.config.appId === 'portal':
         *     app.view.PortalField = app.view.Field.extend({
         *         initialize: function(options) {
         *             // Call super
         *             app.view.Field.prototype.initialize.call(this, options);
         *             // Custom initialization code...
         *         },
         *
         *        handleValidationError: function(errors) {
         *            // Custom validation logic
         *        }
         *     });
         *
         * The above declaration will make all field controllers extend
         * `app.view.PortalField` instead of `app.view.Field`.
         *
         * - Base class: `<component-type>` - `Layout`, `View`, `Field`.
         *
         * Note 1. Although the view manager supports module specific fields
         * like `ContactsIntField`, the server does not provide such
         * customization.
         *
         * Note 2. The layouts is a special case because their class name is
         * built both from layout name and layout type. One could have
         * `ListLayout` or `ColumnsLayout` including their module specific
         * counterparts like `ContactsListView` and `ContactsColumnsLayout`.
         * The "named" class name is checked first.
         *
         * @param {string} type Lower-cased component type: `layout`, `view`, or
         *   `field`.
         * @param {string} name Lower-cased component name. For example, 'list'
         *   (layout or view), or 'bool' (field).
         * @param {string} [module] Module name.
         * @param {string} [controller] Controller source code string.
         * @param {boolean} [overwrite] Will overwrite if duplicate
         *   custom class or layout is cached. Note that if no controller is
         *   passed, overwrite is ignored since we can't create a meaningful
         *   component without a controller.
         * @param {string} [platform] The platform e.g. 'base', 'portal', etc.
         * @return {Function} Component class.
         */
        declareComponent: function(type, name, module, controller, overwrite, platform) {
            var c = this._getBaseComponent(type, name, module, platform, overwrite && controller);
            if (overwrite && controller) {
                if (c.cache[c.moduleBasedClassName]) delete c.cache[c.moduleBasedClassName];
            }
            return  c.cache[c.moduleBasedClassName] ||
                app.utils.extendClass(c.cache, c.baseClass, c.moduleBasedClassName, controller, c.platformNamespace) ||
                c.baseClass;
        },

        /**
         * Internal helper function for getting a component (controller). Do not
         * call directly and instead use `declareComponent`, etc.
         * depending on your needs.
         * @param {string} type Lower-cased component type: `layout`, `view`, or
         *   `field`.
         * @param {string} name Lower-cased component name. For example, `list`
         *   (layout or view), or `bool` (field).
         * @param {string} [module] Module name.
         * @param {string} [platform] The platform e.g. 'base', 'portal', etc.
         * @param {boolean} [overwrite=true] When `true`, custom controller
         *   overrides will be ignored and only components that exactly match
         *   the name will be returned. The base class returned is `base`.
         * @return {Object} The base component information.
         * @return {Object} return.cache The collection of controllers of the
         *   given component type.
         * @return {string} return.platformNamespace The platform prefix.
         * @return {string} return.moduleBasedClassName The prefixed class name.
         * @return {Object} return.baseClass The class for the base component.
         * @private
         */
        _getBaseComponent: function(type, name, module, platform, overwrite) {
            platform = this._getPlatform({platform: platform});
            // The type e.g. View, Field, Layout
            var ucType = app.utils.capitalize(type),
            // The platform e.g. Base, Portal, etc.
                platformNamespace = app.utils.capitalize(platform),
            // The component name and type concatenated e.g. ListView
                className = app.utils.capitalizeHyphenated(name) + ucType,
            // The combination of platform, optional module, and className e.g. BaseAccountsListView
                moduleBasedClassName = platformNamespace + (module || "") + className,
                customModuleBasedClassName = platformNamespace + (module || "") + "Custom" + className,
                cache = app.view[type + "s"],
            // App id and type fallback
                customBaseClassName = app.utils.capitalize(app.config.appId) + ucType,
            // Components are now namespaced by <platform> so we must prefix className to find in cache
            // if we don't find platform-specific, than we next look in Base<className> and so on
                baseClass = cache[platformNamespace + "Custom" + className] ||
                    cache[platformNamespace + className] ||
                    cache["BaseCustom" + className] ||
                    cache["Base" + className] ||
                    // For backwards compatibility, if they define app.view.views.MyView we should still find
                    cache[className] ||
                    cache["BaseBase" + ucType] ||
                    app.view["Custom" + customBaseClassName] ||
                    app.view[customBaseClassName] ||
                    app.view[ucType];
            // Override to use the custom class instead of the standard one if it exists.
            if (cache[customModuleBasedClassName] && !overwrite) {
                moduleBasedClassName = customModuleBasedClassName;
            }
            return {
                cache: cache,
                platformNamespace: platformNamespace,
                moduleBasedClassName: moduleBasedClassName,
                baseClass: baseClass
            };
        }
    };

    app.augment("view", _viewManager, false);

})(SUGAR.App);
