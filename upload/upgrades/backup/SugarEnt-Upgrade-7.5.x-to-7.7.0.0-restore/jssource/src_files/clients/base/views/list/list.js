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
 * View that displays a list of models pulled from the context's collection.
 *
 * @class View.Views.Base.ListView
 * @alias SUGAR.App.view.views.BaseListView
 * @extends View.View
 */
({
    className: 'list-view',

    plugins: ['Pagination'],

    events: {
        'click [class*="orderBy"]':'setOrderBy'
    },

    defaultLayoutEvents: {
        "list:search:fire": "fireSearch",
        "list:filter:toggled": "filterToggled",
        "list:alert:show": "showAlert",
        "list:alert:hide": "hideAlert",
        "list:sort:fire": "sort"
    },

    defaultContextEvents: {},

    // Model being previewed (if any)
    _previewed: null,
    //Store left column fields
    _leftActions: [],
    //Store right column fields
    _rowActions: [],
    //Store default and available(+visible) field names
    _fields: {},

    initialize: function(options) {
        //Grab the list of fields to display from the main list view (assuming initialize is being called from a subclass)
        var listViewMeta = app.metadata.getView(options.module, 'list') || {};
        //Extend from an empty object to prevent polution of the base metadata
        options.meta = _.extend({}, listViewMeta, options.meta || {});
        options.meta.type = options.meta.type || 'list';
        options.meta.action = 'list';
        options = this.parseFieldMetadata(options);

        app.view.View.prototype.initialize.call(this, options);

        this.attachEvents();
        this.orderByLastStateKey = app.user.lastState.key('order-by', this);
        this.orderBy = this._initOrderBy();
        if(this.collection) {
            this.collection.orderBy = this.orderBy;
        }
        // Dashboard layout injects shared context with limit: 5.
        // Otherwise, we don't set so fetches will use max query in config.
        this.limit = this.context.has('limit') ? this.context.get('limit') : null;
        this.metaFields = this.meta.panels ? _.first(this.meta.panels).fields : [];

        this.registerShortcuts();
    },

    /**
     * Initializes the {@link #orderBy} property.
     *
     * Retrieves the last state from the local storage and verifies the field
     * is still sortable.
     *
     * @return {Object}
     * @return {string} return.field The field name to sort by.
     * @return {string} return.direction The direction to sort by (either `asc`
     *   or `desc`).
     * @protected
     */
    _initOrderBy: function() {
        var lastStateOrderBy = app.user.lastState.get(this.orderByLastStateKey) || {},
            lastOrderedFieldMeta = this.getFieldMeta(lastStateOrderBy.field);

        if (_.isEmpty(lastOrderedFieldMeta) || !app.utils.isSortable(this.module, lastOrderedFieldMeta)) {
            lastStateOrderBy = {};
        }

        return _.extend({
                field : '',
                direction : 'desc'
            },
            this.meta.orderBy,
            lastStateOrderBy
        );
    },

    /**
     * @override
     * @private
     */
    _render: function () {
        app.view.View.prototype._render.call(this);
        //If user has no `list` access, render `noaccess.hbs` template
        if (!app.acl.hasAccessToModel(this.action, this.model)) {
            this._noAccessTemplate = this._noAccessTemplate || app.template.get("list.noaccess");
            this.$el.html(this._noAccessTemplate());
        }
    },

    /**
     * Parse the metadata to make sure that the follow attributes conform to specific standards
     *  - Align: valid options are left, center and right
     *  - Width: any percentage below 100 is valid
     *
     * @param options
     * @returns {*}
     */
    parseFieldMetadata: function(options) {
        // standardize the align and width param in the defs if they exist
        _.each(options.meta.panels, function(panel, panelIdx) {
            _.each(panel.fields, function(field, fieldIdx) {
                if (!_.isUndefined(field.align)) {
                    var alignClass = '';
                    if (_.contains(['left', 'center', 'right'], field.align)) {
                        alignClass = 't' + field.align;
                    }
                    options.meta.panels[panelIdx].fields[fieldIdx].align = alignClass;
                }

                if (!_.isUndefined(field.width)) {
                    // make sure it's a percentage
                    var parts = field.width.toString().match(/^(\d{0,3})\%$/);
                    var widthValue = '';
                    if(parts) {
                        if(parseInt(parts[1]) < 100) {
                            widthValue = parts[0];
                        }
                    }

                    options.meta.panels[panelIdx].fields[fieldIdx].width = widthValue;
                }
            }, this);
        }, this);

        return options;
    },

    /**
     * Takes the defaultListEventMap and listEventMap and binds the events. This is to allow views that
     * extend ListView to specify their own events.
     */
    attachEvents: function() {
        this.layoutEventsMap = _.extend(this.defaultLayoutEvents, this.layoutEvents); // If undefined nothing will be added.
        this.contextEventsMap = _.extend(this.defaultContextEvents, this.contextEvents);

        if (this.layout) {
            _.each(this.layoutEventsMap, function(callback, event) {
                this.layout.on(event, this[callback], this);
            }, this);
        }

        if (this.context) {
            _.each(this.contextEventsMap, function(callback, event) {
                this.context.on(event, this[callback], this);
            }, this);
        }
    },

    sort: function() {
        //When sorting the list view, we need to close the preview panel
        app.events.trigger("preview:close");
    },

    showAlert: function(message) {
        this.$("[data-target=alert]").html(message);
        this.$("[data-target=alert-container]").removeClass("hide");
    },

    hideAlert: function() {
        this.$("[data-target=alert-container]").addClass("hide");
        this.$("[data-target=alert]").empty();
    },
    filterToggled:function (isOpened) {
        this.filterOpened = isOpened;
    },
    fireSearch:function (term) {
        term = term || "";
        var options = {
            limit: this.limit || null,
            query: term
        };
        this.context.get("collection").resetPagination();
        this.context.resetLoadFlag(false);
        this.context.set('skipFetch', false);
        this.context.loadData(options);
    },

    /**
     * Sets order by on collection and view.
     *
     * The event is canceled if an element being dragged is found.
     *
     * @param {Event} event jQuery event object.
     */
    setOrderBy: function(event) {
        if ($(event.currentTarget).find('ui-draggable-dragging').length) {
            return;
        }
        var collection, options, eventTarget, orderBy;
        var self = this;

        collection = self.collection;
        eventTarget = self.$(event.currentTarget);

        // first check if alternate orderby is set for column
        orderBy = eventTarget.data('orderby');
        // if no alternate orderby, use the field name
        if (!orderBy) {
            orderBy = eventTarget.data('fieldname');
        }
        // if same field just flip
        if (orderBy === self.orderBy.field) {
            self.orderBy.direction = self.orderBy.direction === 'desc' ? 'asc' : 'desc';
        } else {
            self.orderBy.field = orderBy;
            self.orderBy.direction = 'desc';
        }

        collection.orderBy = self.orderBy;

        collection.resetPagination();

        options = self.getSortOptions(collection);

        if(this.triggerBefore('list:orderby', options)) {
            self._setOrderBy(options);
        }
    },

    /**
     * Run the order by on the collection
     *
     * @param {Object} options
     * @private
     */
    _setOrderBy: function(options) {
        if(this.orderByLastStateKey) {
            app.user.lastState.set(this.orderByLastStateKey, this.orderBy);
        }
        // refetch the collection
        this.context.resetLoadFlag(false);
        this.context.set('skipFetch', false);
        this.context.loadData(options);
    },
    /**
     * Gets options for fetch call for list sorting
     * @param collection
     * @returns {Object}
     */
    getSortOptions: function(collection) {
        var self = this, options = {};
        // Treat as a "sorted search" if the filter is toggled open
        options = self.filterOpened ? self.getSearchOptions() : {};

        //Show alerts for this request
        options.showAlerts = true;

        // If injected context with a limit (dashboard) then fetch only that
        // amount. Also, add true will make it append to already loaded records.
        options.limit = self.limit || null;
        options.success = function (collection, response, options) {
            self.layout.trigger("list:sort:fire", collection, self);
        };

        // if we have a bunch of models already fetch at least that many
        if (collection.offset) {
            options.limit = collection.offset;
            options.offset = 0;
        }

        return options;
    },
    getSearchOptions:function () {
        var collection, options, previousTerms, term = '';
        collection = this.context.get('collection');

        // If we've made a previous search for this module grab from cache
        if (app.cache.has('previousTerms')) {
            previousTerms = app.cache.get('previousTerms');
            if (previousTerms) {
                term = previousTerms[this.module];
            }
        }
        // build search-specific options and return
        options = {
            params:{},
            fields:collection.fields ? collection.fields : this.collection
        };
        if (term) {
            options.params.q = term;
        }
        if (this.context.get('link')) {
            options.relate = true;
        }
        return options;
    },
    bindDataChange:function () {
        if (this.collection) {
            this.collection.on("reset", this.render, this);
        }
    },

    _dispose: function() {
        this._fields = null;
        app.view.View.prototype._dispose.call(this);
    },

    /**
     * Select next or previous row.
     * @param {Boolean} down
     */
    selectRow: function(down) {
        var $rows = this.$('.dataTable tbody tr'),
            $selected,
            $next;

        if ($rows.hasClass('selected')) {
            $selected = $rows.filter('.selected');
            $next = down ? $selected.next() : $selected.prev();
            if($next.length > 0) {
                $selected.removeClass('selected');
                $next.addClass('selected');
                this.makeRowVisible($next);
            }
        } else {
            $rows.first().addClass('selected');
            this.makeRowVisible();
        }
    },

    /**
     * Scroll list view such that the selected row is visible.
     * @param {jQuery} $selected
     */
    makeRowVisible: function($selected) {
        var $mainpane = this.$el.closest('.main-pane'),
            mainpaneHeight,
            selectedHeight,
            selectedTopPosition,
            selectedOffsetParent;

        if (_.isUndefined($selected)) {
            $mainpane.scrollTop(0);
            return;
        }

        mainpaneHeight = $mainpane.height();
        selectedHeight = $selected.height();
        selectedOffsetParent = $selected.offsetParent();
        selectedTopPosition = $selected.position().top + selectedOffsetParent.position().top;

        if ((selectedTopPosition + selectedHeight) > mainpaneHeight) {
            $mainpane.scrollTop($mainpane.scrollTop() + mainpaneHeight/2);
        }

        if (selectedTopPosition < 0) {
            $mainpane.scrollTop($mainpane.scrollTop() - mainpaneHeight/2);
        }
    },

    /**
     * Scroll list view either right or left.
     * @param {Boolean} right
     */
    scrollHorizontally: function(right) {
        var $scrollableDiv = this.$('.flex-list-view-content'),
            scrollEnabled = this.$el.hasClass('scroll-width'),
            nextScrollPosition,
            increment = 60;

        if (scrollEnabled) {
            if (right) {
                nextScrollPosition = $scrollableDiv.scrollLeft() + increment;
            } else {
                nextScrollPosition = $scrollableDiv.scrollLeft() - increment;
            }

            $scrollableDiv.scrollLeft(nextScrollPosition);
        }
    },

    /**
     * Register shortcut keys.
     */
    registerShortcuts: function() {
        app.shortcuts.register('List:Select:Down', 'j', function() {
            this.selectRow(true);
        }, this);

        app.shortcuts.register('List:Select:Up', 'k', function() {
            this.selectRow(false);
        }, this);

        app.shortcuts.register('List:Scroll:Left', 'h', function() {
            this.scrollHorizontally(false);
        }, this);

        app.shortcuts.register('List:Scroll:Right', 'l', function() {
            this.scrollHorizontally(true);
        }, this);

        app.shortcuts.register('List:Select:Open', 'o', function() {
            if (this.$('.selected [data-type=name] a:visible').length > 0) {
                this.$('.selected [data-type=name] a:visible').get(0).click();
            } else if (this.$('.selected [data-type=fullname] a:visible').length > 0) {
                this.$('.selected [data-type=fullname] a:visible').get(0).click();
            }
        }, this);
    }
})
