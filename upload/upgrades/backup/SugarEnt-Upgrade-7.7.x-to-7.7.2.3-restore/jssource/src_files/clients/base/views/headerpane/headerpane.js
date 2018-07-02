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
 * @class View.Views.Base.HeaderpaneView
 * @alias SUGAR.App.view.views.BaseHeaderpaneView
 * @extends View.View
 */
({
    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        this.meta = _.extend({}, app.metadata.getView(null, 'headerpane'), this.meta);

        /**
         * The label used for the title. This is the raw label.
         *
         * @deprecated 7.5 and will be removed in 7.7. We recommend to set the
         * title by defining a `fields` array, containing a field named `title`,
         * in the metadata. You should not define the title with `meta.title`.
         * Note that you can extend {@link #formatTitle} if the string used is a
         * template and you wish to pass a context.
         *
         * @type {string}
         * @private
         */
        this._title = this.meta.title;

        this.context.on('headerpane:title', function(title) {
            this._title = title;
            if (!this.disposed) this.render();
        }, this);

        //shortcut keys
        app.shortcuts.register('Headerpane:Cancel', ['esc', 'ctrl+alt+l'], function() {
            var $cancelButton = this.$('a[name=cancel_button]'),
                $closeButton = this.$('a[name=close]');

            if ($cancelButton.is(':visible') && !$cancelButton.hasClass('disabled')) {
                $cancelButton.click();
            } else if ($closeButton.is(':visible') && !$closeButton.hasClass('disabled')) {
                $closeButton.click();
            }
        }, this, true);
        app.shortcuts.register('Headerpane:Save', ['ctrl+s', 'ctrl+alt+a'], function() {
            var $saveButton = this.$('a[name=save_button]');
            if ($saveButton.is(':visible') && !$saveButton.hasClass('disabled')) {
                $saveButton.click();
            }
        }, this, true);
        $(window).on('resize.headerpane.' + this.cid, _.bind(this.adjustHeaderpane, this));
        this.layout.on('headerpane:adjust_fields', this.adjustTitle, this);
    },

    /**
     * Adjusts the title's ellipsis max-width to match the ancestor title cell.
     */
    adjustTitle: function() {
        var $titleCell = this.$el.find('[data-name=title]');
        if ($titleCell) {
            var $ellipsisDiv = $titleCell.find('.ellipsis_inline');
            var width = $titleCell.css('max-width');
            $ellipsisDiv.css({'max-width': width});
        }
    },

    /**
     * @inheritdoc
     */
    _renderHtml: function() {
        /**
         * The title being rendered in the headerpane. This is the formatted
         * label.
         *
         * @deprecated 7.5 and will be removed in 7.7. We recommend to set the
         * title by defining a `fields` array, containing a field named `title`,
         * in the metadata. You should not define the title with `meta.title`.
         * Note that you can extend {@link #_formatTitle} if the string used is a
         * template and you wish to pass a context.
         *
         * @type {string}
         */
        this.title = !_.isUndefined(this._title) ? this._formatTitle(this._title) : this.title;
        this.meta.fields = _.map(this.meta.fields, function(field) {
            if (field.name === 'title') {
                field['formatted_value'] = this.title || this._formatTitle(field['default_value']);
            }
            return field;
        }, this);
        this._super('_renderHtml');
    },

    /**
     * Formats the title before being rendered.
     *
     * @param {string} title The unformatted title.
     * @return {string} The formatted title.
     * @protected
     */
    _formatTitle: function(title) {
        if (!title) {
            return '';
        }
        return app.lang.get(title, this.module);
    },

    /**
     * Adjust headerpane such that certain fields can be shown with ellipsis.
     */
    adjustHeaderpane: function() {
        this.setContainerWidth();
        this.adjustHeaderpaneFields();
    },

    /**
     * Adjust headerpane fields such that the first field is ellipsified and the last field
     * is set to 100% on view.  On edit, the first field is set to 100%.
     */
    adjustHeaderpaneFields: function() {
        var $ellipsisCell,
            ellipsisCellWidth,
            $recordCells;

        if (this.disposed) {
            return;
        }

        $recordCells = this.$('.headerpane h1').children('.record-cell, .btn-toolbar');

        if (($recordCells.length > 0) && (this.getContainerWidth() > 0)) {
            $ellipsisCell = $(this._getCellToEllipsify($recordCells));

            if ($ellipsisCell.length > 0) {
                if ($ellipsisCell.hasClass('edit')) {
                    // make the ellipsis cell widen to 100% on edit
                    $ellipsisCell.css({'width': '100%'});
                } else {
                    ellipsisCellWidth = this._calculateEllipsifiedCellWidth($recordCells, $ellipsisCell);
                    this._setMaxWidthForEllipsifiedCell($ellipsisCell, ellipsisCellWidth);
                }
            }
        }
        if (this.layout) {
            this.layout.trigger('headerpane:adjust_fields');
        }
    },

    /**
     * Get the width of the layout container
     */
    getContainerWidth: function() {
        return this._containerWidth;
    },

    /**
     * Set the width of the layout container
     */
    setContainerWidth: function() {
        this._containerWidth = this._getParentLayoutWidth(this.layout);
    },

    /**
     * Get the width of the parent layout that contains `getPaneWidth()`
     * method.
     *
     * @param {View.Layout} layout The parent layout.
     * @return {number} The parent layout width.
     * @private
     */
    _getParentLayoutWidth: function(layout) {
        if (!layout) {
            return 0;
        } else if (_.isFunction(layout.getPaneWidth)) {
            return layout.getPaneWidth(this);
        }

        return this._getParentLayoutWidth(layout.layout);
    },

    /**
     * Get the first cell for the field that can be ellipsified.
     * @param {jQuery} $cells
     * @return {jQuery}
     * @private
     */
    _getCellToEllipsify: function($cells) {
        var fieldTypesToEllipsify = ['fullname', 'name', 'text', 'base', 'enum', 'url', 'dashboardtitle', 'label'];

        return _.find($cells, function(cell) {
            return (_.indexOf(fieldTypesToEllipsify, $(cell).data('type')) !== -1);
        });
    },

    /**
     * Calculate the width for the cell that needs to be ellipsified.
     * @param {jQuery} $cells
     * @param {jQuery} $ellipsisCell
     * @return {number}
     * @private
     */
    _calculateEllipsifiedCellWidth: function($cells, $ellipsisCell) {
        var width = this.getContainerWidth();

        _.each($cells, function(cell) {
            var $cell = $(cell);

            if ($cell.is($ellipsisCell)) {
                width -= (parseInt($ellipsisCell.css('padding-left'), 10) +
                parseInt($ellipsisCell.css('padding-right'), 10));
            } else if ($cell.is(':visible')) {
                $cell.css({'width': 'auto'});
                width -= $cell.outerWidth();
            }
            $cell.css({'width': ''});
        });

        return width;
    },

    /**
     * Set the max-width for the specified cell.
     * @param {jQuery} $ellipsisCell
     * @param {number} width
     * @private
     */
    _setMaxWidthForEllipsifiedCell: function($ellipsisCell, width) {
        var ellipsifiedCell,
            fieldType = $ellipsisCell.data('type');

        if (fieldType === 'fullname' || fieldType === 'dashboardtitle') {
            ellipsifiedCell = this.getField($ellipsisCell.data('name'));
            width -= ellipsifiedCell.getCellPadding();
            ellipsifiedCell.setMaxWidth(width);
        } else {
            $ellipsisCell.css({'max-width': width});
        }
    },

    /**
     * @inheritdoc
     */
    _renderFields: function() {
        this._super('_renderFields');
        this.adjustHeaderpane();
    },

    /**
     * @inheritdoc
     */
    unbind: function() {
        this._super('unbind');
        $(window).off('resize.headerpane.' + this.cid);
        this.layout.off('headerpane:adjust_fields', this.adjustTitle);
    }
})
