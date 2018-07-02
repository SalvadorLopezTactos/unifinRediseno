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
(function (app) {
    app.events.on("app:init", function () {
        /**
         * When ellipsis_inline class is added to an element, the CSS will ellipsify the text
         * and this plugin will show a tooltip when an ellipsis exists.
         */
        app.plugins.register('EllipsisInline', ['view', 'field'], {

            _$ellipsisTooltips: null, //array of all initialized tooltips

            /**
             * Initialize tooltips on render and destroy tooltip before render.
             *
             * @deprecated EllipsisInline plugin has been deprecated since 7.8.0
             *   and will be removed in 7.9.0.
             */
            onAttach: function() {
                app.logger.warn('EllipsisInline#onAttach: The `EllipsisInline` plugin has been' +
                    ' deprecated since 7.8.0 and will be removed in 7.9.0. Please remove this plugin from the ' +
                    'following component: ' + this.toString());
            },

            /**
             * Destroy all tooltips on dispose.
             */
            onDetach: $.noop,

            /**
             * Create tooltips for all elements that have `ellipsis_inline` class.
             *
             * @deprecated EllipsisInline plugin has been deprecated since 7.8.0
             *   and will be removed in 7.9.0.
             */
            initializeEllipsisTooltips: function() {
                app.logger.warn('EllipsisInline#initializeEllipsisTooltips: The `EllipsisInline` plugin has been' +
                    ' deprecated since 7.8.0 and will be removed in 7.9.0. Please remove this plugin from the ' +
                    'following component: ' + this.toString());

                var self = this;
                if (this._$ellipsisTooltips) {
                    app.utils.tooltip.destroy(this._$ellipsisTooltips);
                }

                _.defer(function($element, options, direction) {
                    self._$ellipsisTooltips = app.utils.tooltip.initialize($element, options, direction);
                }, this.$('.ellipsis_inline'), {trigger: 'manual'}, this.dir);
            },

            /**
             * Destroy all tooltips that have been created.
             *
             * @deprecated EllipsisInline plugin has been deprecated since 7.8.0
             *   and will be removed in 7.9.0.
             */
            destroyEllipsisTooltips: function() {
                app.logger.warn('EllipsisInline#destroyEllipsisTooltips: The `EllipsisInline` plugin has been' +
                    ' deprecated since 7.8.0 and will be removed in 7.9.0. Please remove this plugin from the ' +
                    'following component: ' + this.toString());

                if (this._$ellipsisTooltips) {
                    app.utils.tooltip.destroy(this._$ellipsisTooltips);
                }
                this._$ellipsisTooltips = null;
            },

            /**
             * Show tooltip.
             * @param {Event} event
             * @private
             */
            _showEllipsisTooltip: function(event) {
                var target = event.currentTarget;
                if (this._shouldShowEllipsisTooltip(target)) {
                    app.utils.tooltip.show(target);
                }
            },

            /**
             * Hide tooltip.
             * @param {Event} event
             * @private
             */
            _hideEllipsisTooltip: function(event) {
                var target = event.currentTarget;
                if (this._shouldHideEllipsisTooltip(target)) {
                    app.utils.tooltip.hide(target);
                }
            },

            /**
             * Show tooltip if it exists on the target and if the ellipsis is shown.
             * @param {DOM} target
             * @returns {boolean}
             * @private
             */
            _shouldShowEllipsisTooltip: function(target) {
                return app.utils.tooltip.has(target) && (target.offsetWidth < target.scrollWidth);
            },

            /**
             * Hide tooltip if it exists on the target and if it is currently displayed.
             * @param {DOM} target
             * @returns {boolean}
             * @private
             */
            _shouldHideEllipsisTooltip: function(target) {
                var plugin = app.utils.tooltip.get(target);
                return plugin && plugin.tip().hasClass('in');
            }

        });
    });
})(SUGAR.App);
