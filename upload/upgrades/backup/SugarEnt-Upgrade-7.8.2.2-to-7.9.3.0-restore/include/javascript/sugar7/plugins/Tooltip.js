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
             *
             * @deprecated `Tooltip` plugin has been deprecated since 7.8.0
             *   and will be removed in 7.9.0.
             */
            onAttach: function() {
                app.logger.warn('Tooltip#onAttach: The `Tooltip` plugin has been' +
                    ' deprecated since 7.8.0 and will be removed in 7.9.0. Please remove this plugin from the ' +
                    'following component: ' + this.toString());
            },

            /**
             * Destroy tooltips on dispose.
             */
            onDetach: $.noop,

            /**
             * Create all tooltips in this component.
             *
             * @deprecated `Tooltip` plugin has been deprecated since 7.8.0
             *   and will be removed in 7.9.0.
             */
            initializeAllPluginTooltips: function() {
                app.logger.warn('Tooltip#initializeAllPluginTooltips: The `Tooltip` plugin has been' +
                    ' deprecated since 7.8.0 and will be removed in 7.9.0. Please remove this plugin from the ' +
                    'following component: ' + this.toString());

                this.removePluginTooltips();
                this.addPluginTooltips();
            },

            /**
             * Destroy all tooltips that have been created in this component.
             *
             * @deprecated `Tooltip` plugin has been deprecated since 7.8.0
             *   and will be removed in 7.9.0.
             */
            destroyAllPluginTooltips: function() {
                app.logger.warn('Tooltip#destroyAllPluginTooltips: The `Tooltip` plugin has been' +
                    ' deprecated since 7.8.0 and will be removed in 7.9.0. Please remove this plugin from the ' +
                    'following component: ' + this.toString());

                this.removePluginTooltips();
                this._$pluginTooltips = null;
            },

            /**
             * Create tooltips within a given element.
             *
             * @deprecated `Tooltip` plugin has been deprecated since 7.8.0
             *   and will be removed in 7.9.0.
             * @param {jQuery} $element (optional)
             */
            addPluginTooltips: function($element) {
                app.logger.warn('Tooltip#addPluginTooltips: The `Tooltip` plugin has been' +
                    ' deprecated since 7.8.0 and will be removed in 7.9.0. Please remove this plugin from the ' +
                    'following component: ' + this.toString());

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
             *
             * @deprecated `Tooltip` plugin has been deprecated since 7.8.0
             *   and will be removed in 7.9.0.
             * @param {jQuery} $element (optional)
             */
            removePluginTooltips: function($element) {
                app.logger.warn('Tooltip#removePluginTooltips: The `Tooltip` plugin has been' +
                    ' deprecated since 7.8.0 and will be removed in 7.9.0. Please remove this plugin from the ' +
                    'following component: ' + this.toString());

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
