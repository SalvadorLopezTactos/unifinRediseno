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
 * Layout for tabbing between filterable components.
 * Mostly to toggle between Activity Stream and list views
 *
 * @class View.Layouts.Base.TogglepanelLayout
 * @alias SUGAR.App.view.layouts.BaseTogglepanelLayout
 * @extends View.Layout
 */
({
    events: {
        "click .toggle-actions a.btn": "toggleView"
    },

    plugins: ['Tooltip'],

    /**
     * @override
     * @param {Object} opts
     */
    initialize: function (opts) {
        this.toggleComponents = [];
        this.componentsList = {};
        this.processToggles();
        this._super('initialize', [opts]);
    },

    /**
     * @inheritdoc
     */
    initComponents: function(components, context, module) {
        this._super('initComponents', [components, context, module]);

        _.each(this.componentsList, function(comp) {
            if (_.isFunction(comp.initComponents)) {
                comp.initComponents();
            }
        });
    },

    /**
     * @override
     * @private
     */
    _render: function() {
        this._super('_render');
        // get the last viewed layout
        this.toggleViewLastStateKey = app.user.lastState.key('toggle-view', this);
        var lastViewed = app.user.lastState.get(this.toggleViewLastStateKey);

        // show the first toggle if the last viewed state isn't set in the metadata
        if (_.isUndefined(lastViewed) || this.isToggleButtonDisabled(lastViewed)) {
            var enabledToggles = _.filter(this.toggles, function(toggle) {
                return !toggle.disabled;
            });
            if (enabledToggles.length > 0) {
                lastViewed = _.first(enabledToggles).toggle;
            }
        }

        this.showComponent(lastViewed, true);//SP-1766-don't double render!
        // Toggle the appropriate button and layout for initial render
        this.$('[data-view="' + lastViewed + '"]').button('toggle');
    },

    /**
     * Checks whether the toggle button is disabled
     * @param {string} name  The name of the button to check
     * @return {boolean}
     */
    isToggleButtonDisabled: function (name) {
        var disabled = false,
            toggleButton;

        toggleButton = _.find(this.toggles, function (toggle) {
            return toggle.toggle === name;
        });

        if (toggleButton) {
            disabled = toggleButton.disabled;
        }
        return disabled;
    },

    /**
     * Get components from the metadata and declare toggles
     */
    processToggles: function () {
        // Enable toggles
        this.toggles = [];
        var temp = {};

        //Go through components and figure out which toggles we should add
        _.each(this.options.meta.components, function (component) {
            var toggle;
            if (component.view) {
                toggle = component.view;
            } else if (component.layout) {
                toggle = (_.isString(component.layout)) ? component.layout : component.layout.name;
            }

            var availableToggle = _.find(this.options.meta.availableToggles, function (curr) {
                return curr.name === toggle;
            }, this);
            if (toggle && availableToggle) {
                var disabled = !!availableToggle.disabled;
                temp[toggle] = {toggle: toggle, title: availableToggle.label, 'class': availableToggle.icon, disabled: disabled};
            }
        }, this);

        if (this.options.meta.availableToggles) {
            // Sort the toggles by the order in the availableToggles list
            for (var i = 0; i < this.options.meta.availableToggles.length; i++) {
                var curr = this.options.meta.availableToggles[i];
                if (temp[curr.name]) {
                    this.toggles.push(temp[curr.name]);
                }
            }
        }

    },

    /**
     * @override
     * @private
     * @param {Component} component
     * @param {Object} def
     */
    _placeComponent: function (component, def) {
        if (def && def.targetEl) {
            if (def.position == 'prepend') {
                this.$(def.targetEl).prepend(component.el);
                return;
            } else {
                this.$(def.targetEl).append(component.el);
            }
        } else {
            // If we recognize the view, prevent it from rendering until it's
            // requested explicitly by the user.
            var toggleAvailable = _.isObject(_.find(this.options.meta.availableToggles, function (curr) {
                return curr.name === component.name;
            }));
            if (toggleAvailable) {
                this.toggleComponents.push(component);
                this.componentsList[component.name] = component;
                this._components.splice(this._components.indexOf(component), 1);
            } else {
                // Safety check, just in case we've got a view that the layout
                // doesn't recognize.
                component.render();
                this.$(".main-content").append(component.el);
            }
        }
    },

    /**
     * Show a toggle
     * @param {Event} e
     */
    toggleView: function (e) {
        var $el = this.$(e.currentTarget);
        // Hack: With a real <button> with attribute disabled="disabled", events won't fire on the button. However,
        // since we're using <a> anchor to allow tooltips even if btn disabled, we have to "fudge" disabled behavior
        // See SP-1055, http://jsfiddle.net/hMQYZ/17/, https://github.com/twitter/bootstrap/issues/2373
        if ($el.attr('disabled') === 'disabled') {
            e.preventDefault();
            e.stopPropagation();
            return;
        }
        // Only toggle if we click on an inactive button
        if (!$el.hasClass("active")) {
            var data = $el.data();
            app.user.lastState.set(this.toggleViewLastStateKey, data.view);
            this.showComponent(data.view);
            this.reloadData(data.view);
        }
    },

    /**
     * Show a component and triggers "filterpanel:change"
     * @param {String} name
     * @param {Boolean} silent
     */
    showComponent: function (name, silent) {
        if (!name) return;
        if (this.componentsList[name]) {
            this.componentsList[name].render();
            this._components.push(this.componentsList[name]);
            this.$(".main-content").append(this.componentsList[name].el);
        }

        _.each(this.toggleComponents, function (comp) {
            if (comp.name == name) {
                comp.show();
            } else {
                comp.hide();
            }
        }, this);
        //Need to respect silent param if true as it prevents double rendering:
        //SP-1766-Filter for sidecar modules causes two requests to list view
        this.trigger('filterpanel:change', name, silent);
    },

    /**
     * Reload the toggled component
     * @param name
     */
    reloadData: function(name) {
        var layout = this.componentsList[name];
        if (layout) {
            layout.context.resetLoadFlag(true);
            layout.loadData();
        }
    },

    /**
     * @override
     * @private
     */
    _dispose: function () {
        _.each(this.componentsList, function (component) {
            if (component) {
                component.dispose();
            }
        });
        this.componentsList = {};
        this.toggleComponents = null;
        app.view.Layout.prototype._dispose.call(this);
    }
})
