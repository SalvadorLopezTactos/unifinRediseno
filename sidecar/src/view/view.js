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
(function(app) {

    /**
     * Base View class. Use {@link View.ViewManager} to create instances of views.
     *
     * @class View.View
     * @alias SUGAR.App.view.View
     * @extends View.Component
     */
    app.view.View = app.view.Component.extend({

        /**
         * TODO: add docs (describe options parameter, see Component class for an example).
         * @param options
         */
        initialize: function(options) {
            app.plugins.attach(this, "view");
            app.view.Component.prototype.initialize.call(this, options);

            /**
             * View type
             * @cfg {string}
             */
            this.type = options.type;

            /**
             * Name of the view.
             * @cfg {string}
             */
            this.name = options.name || this.type;

            /**
             * Name of the action (optional).
             *
             * Used in acl checks for user permissions. By default, set to the view name.
             * @cfg {String}
             */
            this.action = options.meta && options.meta.action ? options.meta.action : this.name;

            this._loadTemplate(options);

            /**
             * Dictionary of field widgets.
             *
             * - keys: field IDs (sfuuid)
             * - value: instances of `app.view.Field` class
             */
            this.fields = {};

            /**
             * A template to use for view fields if a field does not have a template defined for its parent view.
             * Defaults to `"default"`.
             *
             * For example, if you have a subview and don't want to define subview template for all field types,
             * you may choose to use existing templates like `detail` if your subview is in fact a detail view.
             *
             * @property {String}
             */
            this.fallbackFieldTemplate = this.fallbackFieldTemplate || "detail";

            /**
             * Reference to the parent layout instance.
             * @property {View.Layout}
             */
            this.layout = this.options.layout;

            /**
             * Flag indicating whether a view is primary or not.
             *
             * If the primary view is not rendered due to the access control,
             * a warning message will be displayed.
             *
             * @property {Boolean}
             */
            this.primary = options.primary;

            this._setLabels();

            /**
             * The view name that contains the list of fields to use when
             * fetching the model/collection from the server.
             *
             * List, record or detail views might have too many fields defined
             * in the metadata. This property avoids having to list all these
             * fields in the request params.
             *
             * @property {string} dataView
             */
            if (this.dataView) {
                this.context.set('dataView', this.dataView);
            } else {
                this.context.addFields(this.getFieldNames());
            }

            app.events.on('app:locale:change', function() {
                this._setLabels();
            }, this);
        },

        /**
         * Gets the template falling back using `loadModule` property when
         * specified.
         *
         * @param {string} name The template's name to get.
         * @param {string} [fallbackModule] The module to fallback to if the
         *   template does not exist in this view's module. If undefined, the
         *   template is grabbed in `base`.
         * @private
         */
        _getTemplate: function(name, fallbackModule) {
            return app.template.getView(name, this.module) || app.template.getView(name, fallbackModule);
        },

        /**
         * Sets the appropriate template for this view to {@link #template}.
         * Sets the name of the template to {@link #tplName}.
         *
         * @param {Object} [options] The options that may specify the template to
         *   load.
         * @param {Object} [options] A hash of options.
         * @param {Function} [options.template] The compiled template.
         * @param {string} [options.loadModule] The fallback module to get the
         *   template from.
         * @private
         */
        _loadTemplate: function(options) {
            var template, templateName;
            options = options || {};

            if (options.template) {
                template = options.template;
                templateName = null;
            } else if (this.meta && this.meta.template) {
                template = this._getTemplate(this.meta.template, options.loadModule);
                templateName = this.meta.template;
            } else {
                template = this._getTemplate(this.name, options.loadModule);
                templateName = this.name;
            }

            if (!template) {
                if (this.meta && this.meta.type) {
                    template = this._getTemplate(this.meta.type, options.loadModule);
                    templateName = this.meta.type;
                } else {
                    template = app.template.empty;
                    templateName = '';
                }
            }

            /**
             * The name of the template that is loaded.
             * This is a public read-only property. This property should not be
             * modified directly.
             *
             * @property {string|null} tplName
             * @member View.View
             */
            this.tplName = templateName;

            /**
             * The template for this view.
             *
             * @property {Function} template
             * @member View.View
             */
            this.template = template;
        },

        /**
         * Renders a view onto the page.
         *
         * This method uses `ctx` parameter as the context for the view's Handlebars {@link View.View#template}
         * and view's `options.templateOptions` property as template options.
         *
         * If no `ctx` parameter is specified, `this` is passed as the context for the template.
         * If no `options` parameter is specified, `this.options.templateOptions` is used.
         *
         * You can override this method if you have custom rendering logic and don't use Handlebars templating
         * or if you need to pass different context object for the template.
         *
         * Note the following use of app.view.View.extend is deprecated in favor of putting these controllers in the
         * sugarcrm/clients/<platform> directory. Using that idiom, the metadata manager will declare these components
         * and take care of namespacing by platform for you (so MyCustomView will be stored internally as MyappMyCustomView).
         * If you do choose to use the following idiom please be forwarned that you will lose any namespacing benefits and
         * possibly encounter naming collisions!
         *
         * Example:
         * <pre><code>
         * // Note that using the following technique of defining custom views directly on the app.view.views object
         * // can result in naming collisions unless you ensure your name is unique. See note above.
         * app.view.views.CustomView = app.view.View.extend({
         *    _renderHtml: function() {
         *       var ctx = {
         *         // Your custom context for this view template
         *       };
         *       app.view.View.prototype._renderHtml.call(this, ctx);
         *    }
         * });
         *
         * // Or totally different logic that doesn't use this.template
         * app.view.views.AnotherCustomView = app.view.View.extend({
         *    _renderHtml: function() {
         *       // Never do this :)
         *       return "&lt;div&gt;Hello, world!&lt;/div&gt;";
         *    }
         * });
         *
         *
         * </code></pre>
         *
         * This method uses this view's {@link View.View#template} property to render itself.
         * @param {Data.Context} [ctx] Template context.
         * @param {Object} [options] Template options.
         * <pre><code>
         * {
         *    helpers: helpers,
         *    partials: partials,
         *    data: data
         * }
         * </code></pre>
         * See Handlebars.js documentation for details.
         * @protected
         */
        _renderHtml: function(ctx, options) {
            if (this.template) {
                try {
                    this.$el.html(this.template(ctx || this, options || this.options.templateOptions));
                } catch (e) {
                    app.logger.error("Failed to render " + this + "\n" + e);
                    app.error.handleRenderError(this, '_renderHtml');
                }
            }
        },

        /**
         * Renders all the fields.
         *
         * @protected
         */
        _renderFields: function() {
            var self = this;

            // In terms of performance it is better to search the DOM once for
            // all the fields, than to search the DOM for each field. That's why
            // we cache placeholders locally and pass them to
            // {@link View.Field#_renderField}.
            var fieldElems = {};

            this.$('span[sfuuid]').each(function() {
                var $this = $(this),
                    sfId = $this.attr('sfuuid');
                fieldElems[sfId] = $this;
            });

            _.each(this.fields, function(field) {
                self._renderField(field, fieldElems[field.sfId]);
            });
        },

        /**
         * Sets field's view element and invokes render on the given field.
         *
         * @param {View.Field} field The field to render.
         * @param {jQuery} $fieldEl The field placeholder.
         * @protected
         */
        _renderField: function(field, $fieldEl) {
            field.setElement($fieldEl || this.$("span[sfuuid='" + field.sfId + "']"));
            try {
                field.render();
            } catch (e) {
                app.logger.error("Failed to render " + field + " on " + this + "\n" + e);
                app.error.handleRenderError(this, '_renderField', field);
            }
        },

        /**
         * Renders a view onto the page.
         *
         * The method first renders this view by calling {@link View.View#_renderHtml}
         * and then for each field invokes {@link View.View#_renderField}.
         *
         * NOTE: Do not override this method, otherwise you will loose ACL check.
         * Consider overriding {@link View.View#_renderHtml} instead.
         *
         * @return {View.View} The instance of this view.
         * @protected
         */
        _render: function() {
            if (app.acl.hasAccessToModel(this.action, this.model)) {
                this._disposeFields();
                this._renderHtml();
                this._renderFields();

            } else {

                app.logger.info("Current user does not have access to this module view. name: " + this.name + " module:"+this.module);
                // See Bug56941.
                // We suppress this warning from being presented to user in situations where we're trying
                // to display a view for a Linked module where the user does not have access.  If you clicked on
                // a Bug and you shouldn't get warnings about Notes, etc, if you didn't have access to those other modules.
                if(this.primary){
                    app.error.handleRenderError(this, 'view_render_denied');
                }
            }

            return this;
        },

        _setLabels: function() {
            /**
             * Pluralized i18n-ed module name.
             * @property {String}
             * @member View.View
             */
            this.modulePlural = app.lang.getAppListStrings("moduleList")[this.module] || this.module;

            /**
             * Singular i18n-ed module name.
             * @property {String}
             * @member View.View
             */
            this.moduleSingular = app.lang.getAppListStrings("moduleListSingular")[this.module] || this.modulePlural;
        },

        /**
         * Fetches data for view's model or collection.
         *
         * This method calls view's context {@link Core.Context#loadData} method.
         *
         * Override this method to provide custom fetch algorithm.
         * @param {Object} [options] Options that are passed to
         *   collection/model's fetch method.
         */
        loadData: function(options) {
            // FIXME This should be removed by 7.9.
            if (arguments.length === 2) {
                app.logger.warn('The `setFields` argument is no longer supported. Views and Layouts must ' +
                    'add the fields they need without affecting other Views and Layouts');
            }

            // See Bug56941.
            // Lets only load the data for views where user has read access.
            // Otherwise we generate REST API errors.
            if (app.acl.hasAccess("read", this.module)) {
                this.context.loadData(options);
            }
        },

        /**
         * Extracts the field names from the metadata for directly related views/panels.
         *
         * @param {string} [module] Module name. Defaults to the Context module.
         * @return {Array} List of fields used on this view
         */
        getFieldNames: function(module) {
            var fields = [];
            module = module || this.context.get('module');

            if (this.meta && this.meta.panels) {
                fields = _.reduce(_.map(this.meta.panels, function(panel) {
                    var nestedFields = _.flatten(_.compact(_.pluck(panel.fields, "fields")));
                    return _.pluck(panel.fields, 'name').concat(
                        _.pluck(nestedFields, 'name')).concat(
                        _.flatten(_.compact(_.pluck(panel.fields, 'related_fields'))));
                }), function(memo, field) {
                    return memo.concat(field);
                }, []);
            }

            fields = _.compact(_.uniq(fields));

            var fieldMetadata = app.metadata.getModule(module, 'fields');
            if (fieldMetadata) {
                // Filter out all fields that are not actual bean fields
                fields = _.reject(fields, function(name) {
                    return _.isUndefined(fieldMetadata[name]);
                });

                // we need to find the relates and add the actual id fields
                var relates = [];
                _.each(fields, function(name) {
                    if (fieldMetadata[name].type == 'relate') {
                        relates.push(fieldMetadata[name].id_name);
                    }
                    else if (fieldMetadata[name].type == 'parent') {
                        relates.push(fieldMetadata[name].id_name);
                        relates.push(fieldMetadata[name].type_name);
                    }
                    if (_.isArray(fieldMetadata[name].fields)) {
                        relates = relates.concat(fieldMetadata[name].fields);
                    }
                });

                fields = _.union(fields, relates);
            }

            return fields;
        },


        /**
         * Gets a hash of fields that are currently displayed on this view.
         *
         * The hash has field names as keys and field definitions as values.
         * @param {String} module(optional) Module name.
         * @param {Bean} model(optional) model to match fields against. Only fields the correspond with the given model will be returned.
         * @return {Object} The currently displayed fields.
         */
        getFields: function(module, model) {
            var fields = {};
            var fieldNames = this.getFieldNames(module);
            _.each(fieldNames, function(name) {
                var field = this.getField(name, model);
                if (field) {
                    fields[name] = field.def;
                }
            }, this);
            return fields;
        },

        /**
         * Returns a field by name.
         * @param {String} name Field name.
         * @param {Bean=} optional model to find the field for.
         * @return {View.Field} Instance of the field widget.
         */
        getField: function(name, model) {
            return _.find(this.fields, function(field) {
                return field.name == name && (!model || field.model == model);
            });
        },

        /**
         * @inheritdoc
         */
        closestComponent: function(name) {
            if (!this.layout) {
                return;
            }
            if (this.layout.name === name) {
                return this.layout;
            }
            return this.layout.closestComponent(name);
        },

        /**
         * @inheritdoc
         */
        _show: function() {
            app.view.Component.prototype._show.call(this);
            _.each(this.fields, function(component) {
                component.updateVisibleState(true);
            });
        },

        /**
         * @inheritdoc
         */
        _hide: function() {
            app.view.Component.prototype._hide.call(this);
            _.each(this.fields, function(component) {
                component.updateVisibleState(true);
            });
        },

        /**
         * Disposes a view.
         *
         * This method disposes view fields and calls
         * {@link View.Component#_dispose} method of the base class.
         * @protected
         */
        _dispose: function() {
            app.plugins.detach(this, "view");
            this._disposeFields();
            app.view.Component.prototype._dispose.call(this);
        },

        /**
         * Disposes all the fields.
         *
         * @protected
         */
        _disposeFields: function() {
            _.each(this.fields, function(field) {
                field.dispose();
            });
            this.fields = {};
        },

        /**
         * Gets a string representation of this view.
         * @return {String} String representation of this view.
         */
        toString: function() {
            return "view-" + this.name + "-" + app.view.Component.prototype.toString.call(this);
        },

        /**
         * Gets a field's metadata.
         * @param {String} name Field name.
         * @param {Boolean} includeChild optional flag indicating that we should check if this is a child field when true.
         * @return {Object} field metadata.
         */
        getFieldMeta : function(field, includeChild) {
            var fields = _.flatten(_.pluck(this.meta.panels, "fields")),
                ret = _.find(fields, function(def) {
                    return def.name === field;
                });

            if (!ret && includeChild) {
                ret = _.find(_.flatten(_.pluck(fields, "fields")), function(def) {
                    return def && def.name === field;
                });

                if (ret) {
                    ret._isChild = true;
                }
            }

            return ret;
        },

        /**
         * Sets a field's metadata.
         * @param {String} name Field name.
         * @param {Object} meta Field metadata
         */
        setFieldMeta : function(field, meta) {
            _.each(this.meta.panels, function(panel) {
                _.each(panel.fields, function(def, i) {
                    if (def.name === field) {
                        panel.fields[i] = _.extend(def, meta);
                    } else if (_.isArray(def.fields)) {
                        _.each(def.fields, function(childDef, j) {
                            if (childDef.name === field) {
                                def.fields[j] = _.extend(childDef, meta);
                            }
                        });
                    }
                });
            });
        }
    });
})(SUGAR.App);
