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
    app.events.on('app:init', function() {
        app.plugins.register('Tooltip', ['layout', 'view', 'field'], {
            _$pluginTooltips: null, //jQuery set of all initialized tooltips

            /**
             * CSS selector used to find tooltips.
             * To overwrite the css selector,
             * assign the custom selector on `pluginTooltipCssSelector`.
             * In order to assign multiple selector,
             * assign the selector by comma separator.
             * <pre>
             *     pluginTooltipCssSelector: 'select1, select2, selectN',
             * </pre>
             */
            _pluginTooltipCssSelector: '[rel=tooltip]',

            /**
             * Initialize tooltips on render and destroy tooltip before render for views and fields.
             * Initialize tooltips on initialize for layouts.
             */
            onAttach: function() {
                if (app.utils.isTouchDevice()) {
                    return;
                }
                if ((this instanceof app.view.View) || (this instanceof app.view.Field)) {
                    this.before('render', function() {
                        this.destroyAllPluginTooltips();
                    }, this);
                    this.on('render', function() {
                        this.initializeAllPluginTooltips();
                    }, this);
                    this.on('dismiss', this.removePluginTooltips, this);
                } else if (this instanceof app.view.Layout) {
                    this.on('init', function() {
                        this.initializeAllPluginTooltips();
                    }, this);
                }
            },

            /**
             * Destroy tooltips on dispose.
             */
            onDetach: function() {
                this.destroyAllPluginTooltips();
            },

            /**
             * Create all tooltips in this component.
             */
            initializeAllPluginTooltips: function() {
                this.removePluginTooltips();
                this.addPluginTooltips();
            },

            /**
             * Destroy all tooltips that have been created in this component.
             */
            destroyAllPluginTooltips: function() {
                this.removePluginTooltips();
                this._$pluginTooltips = null;
            },

            /**
             * Create tooltips within a given element.
             * @param {jQuery} $element (optional)
             */
            addPluginTooltips: function($element) {
                var $tooltips = this._getPluginTooltips($element);
                if ($tooltips.length > 0) {
                    this._$pluginTooltips = (this._$pluginTooltips || $()).add(app.utils.tooltip.initialize($tooltips));

                    //hide tooltip when clicked
                    $tooltips.on('click.tooltip', function() {
                        var element = this,
                            tooltip = app.utils.tooltip.get(element);

                        if (tooltip && tooltip.options && tooltip.options.trigger.indexOf('click') === -1) {
                            app.utils.tooltip.hide(element);
                        }
                    });
                    app.accessibility.run($tooltips, 'click');
                }
            },

            /**
             * Destroy tooltips within a given element.
             * @param {jQuery} $element (optional)
             */
            removePluginTooltips: function($element) {
                var $tooltips;
                if ($element) {
                    $tooltips = this._getPluginTooltips($element);
                } else {
                    $tooltips = this._$pluginTooltips;
                }

                if ($tooltips && $tooltips.length > 0) {
                    app.utils.tooltip.destroy($tooltips);
                }
            },

            /**
             * Within a given element, get all elements that have 'rel' attribute with 'tooltip' as its value.
             * @param {jQuery} $element
             * @returns {jQuery}
             * @private
             */
            _getPluginTooltips: function($element) {
                var selector = this.pluginTooltipCssSelector || this._pluginTooltipCssSelector;
                return $element ? $element.find(selector) : this.$(selector);
            }
        });
    });
})(SUGAR.App);

(function($) {
    $(function() {
        if (!Modernizr.touch) {
            return;
        }
        /**
         * @inheritdoc
         * Deactivate tooltip plugin on touch devices.
         */
        $.fn.tooltip = function() {
            return this;
        };
    });
})(jQuery);
