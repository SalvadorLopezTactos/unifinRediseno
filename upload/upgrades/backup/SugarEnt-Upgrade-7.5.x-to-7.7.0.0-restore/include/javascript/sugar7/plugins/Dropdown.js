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
        /**
         * Adds the ability to hide the dropdown menu
         * when the mouse is clicked on bwc elements.
         */
        app.plugins.register('Dropdown', ['layout', 'view'], {
            events: {
                'keydown': 'handleDropdownKeydown'
            },

            onAttach: function(component, plugin) {
                this.on('init', function() {
                    this.listenTo(app.bwc, 'clicked', this.closeDropdown);
                    app.routing.before('route', this.closeDropdown, this, true);
                });
            },

            /**
             * Returns `true` if the first `dropdown` found in this view/layout is `open`.
             *
             * @return {Boolean} `true` if dropdown menu is open, `false` otherwise.
             */
            isDropdownOpen: function() {
                return !!this.$('[data-toggle="dropdown"]').
                    parent().
                    hasClass('open');
            },

            /**
             * Override the default bootstrap dropdown up/down keyboard actions
             * which don't handle some of our use cases due to its requirement
             * that dropdown items all have anchor tags, and it does not
             * appropriately handle submenus.
             *
             * @param {Event} event The keydown event
             */
            handleDropdownKeydown: function(event) {
                var $items, $focusItem, keysCaptured;

                if (!this.isDropdownOpen()) {
                    return;
                }

                if (event.keyCode === $.ui.keyCode.ESCAPE ||
                    event.keyCode === $.ui.keyCode.TAB
                ) {
                    this.closeDropdown();
                } else {
                    $items = this._getDropdownItems();

                    // the currently focused item
                    $focusItem = $items.filter(':focus');

                    // change focus using the up or down arrow key
                    this._focusSubmenuItem(
                        event.keyCode,
                        $items.index($focusItem),
                        $items
                    );

                    // expand/collapse submenu using the right or left arrow key
                    if (event.keyCode === $.ui.keyCode.RIGHT ||
                        event.keyCode === $.ui.keyCode.LEFT
                    ) {
                        this._toggleSubmenu($focusItem);
                    }
                }

                keysCaptured = [
                    $.ui.keyCode.ESCAPE,
                    $.ui.keyCode.UP,
                    $.ui.keyCode.DOWN,
                    $.ui.keyCode.LEFT,
                    $.ui.keyCode.RIGHT
                ];
                if (_.contains(keysCaptured, event.keyCode)) {
                    // prevent bootstrap dropdown from duplicating work we've
                    // already done here
                    event.stopPropagation();

                    // Prevent browser from performing additional actions on dropdowns,
                    // for example, scrolling up and down.
                    event.preventDefault();
                }
            },

            /**
             * Get the dropdown items.
             * Uses `dropdownItemSelector` attribute on the component  which can be used to define
             * how dropdown items are structured.
             * Default selector exists if component has standard dropdown item HTML
             *
             * @return {jQuery}
             * @private
             */
            _getDropdownItems: function() {
                return this.$(this.dropdownItemSelector || '[role=menu] li:not(.divider) a:visible');
            },

            /**
             * Determines the index of the next item to focus, according to the
             * key that was pressed, and applies focus to that item.
             *
             * @param {String} key The key that was pressed.
             * @param {Integer} index The index of the presently focused item.
             * @param {jQuery} $items The items in the submenu.
             * @private
             */
            _focusSubmenuItem: function(key, index, $items) {
                var $menuItemToFocus;

                // move up
                if (key === $.ui.keyCode.UP && index > 0) {
                    index--;
                }

                // move down
                if (key === $.ui.keyCode.DOWN && index < $items.length - 1) {
                    index++;
                }

                // default to first item if none focused
                if (!~index) {
                    index = 0;
                }

                $menuItemToFocus = $items.eq(index).focus();
                this._scrollToMenuItem($menuItemToFocus);
            },

            /**
             * Scroll the dropdown to make the selected menu item visible.
             * @param {jQuery} $menuItem The menu item to scroll to.
             * @private
             */
            _scrollToMenuItem: function($menuItem) {
                var $dropdownMenu = this.$('.dropdown-menu'),
                    menuHeight,
                    menuItemHeight,
                    menuItemTopPosition;

                if ($dropdownMenu.hasClass('scroll')) {
                    menuHeight = $dropdownMenu.height();
                    menuItemHeight = $menuItem.height();
                    menuItemTopPosition = $menuItem.position().top;

                    if ((menuItemTopPosition + menuItemHeight) > menuHeight) {
                        $dropdownMenu.scrollTop($dropdownMenu.scrollTop() + menuHeight/2);
                    } else if (menuItemTopPosition < 0) {
                        $dropdownMenu.scrollTop($dropdownMenu.scrollTop() - menuHeight/2);
                    }
                }
            },

            /**
             * Toggles the dropdown's submenu open and closed.
             *
             * @param {jQuery} $dropdown The dropdown that contains the submenu.
             * @private
             */
            _toggleSubmenu: function($dropdown) {
                var $submenuButton = $dropdown.find('.dropdown-submenu');
                if ($submenuButton.length > 0) {
                    $submenuButton.click();
                }
            },

            /**
             * Close the dropdown menu.
             */
            closeDropdown: function() {
                this.$('.open .dropdown-menu').trigger('click.bs.dropdown');
            },

            /**
             * Detach the event handlers for closing dropdown menu.
             */
            unbindBeforeHandler: function() {
                app.routing.offBefore('route', this.closeDropdown, this);
            },

            /**
             * {@inheritDoc}
             * Unbind beforeHandlers.
             */
            onDetach: function() {
                app.events.off('app:view:change', null, this);
                app.routing.offBefore('route', this.closeDropdown, this);
                this.unbindBeforeHandler();
            }

        });
    });
})(SUGAR.App);
