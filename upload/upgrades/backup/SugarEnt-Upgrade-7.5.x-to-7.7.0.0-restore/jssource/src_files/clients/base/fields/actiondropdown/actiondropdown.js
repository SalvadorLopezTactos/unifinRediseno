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
 * Create a dropdown button that contains multiple rowaction fields
 * array(
 *     'type' => 'actiondropdown',
 *     'primary' => true,
 *     'switch_on_click' => true,
 *     'no_default_action' => false,
 *     'icon' => 'icon-cog',
 *     'buttons' => array(
 *         ...
 *     )
 * )
 *     primary: @param {Boolean} true if the entire dropdown group shows as primary.
 *     icon: @param {String} css icon that places on dropdown caret.
 *     switch_on_click: @param {Boolean} true if the selected action needs
 *          to switch against the default action.
 *     no_default_action: @param {Boolean} true if the default action should be empty
 *          and all buttons place under the dropdown action.
 *     buttons: @params {Array} list of actions.
 *          First action goes to the default action (unless no_default_action set as true)
 *
 * @class View.Fields.Base.ActiondropdownField
 * @alias SUGAR.App.view.fields.BaseActiondropdownField
 * @extends View.Fields.Base.FieldsetField
 */
({
    extendsFrom: 'FieldsetField',
    fields: null,
    dropdownFields: null,

    /**
     * Dom element selector for dropdown action.
     * @property
     */
    actionDropDownTag: '[data-toggle=dropdown]',

    /**
     * Dom element selector for mobile dropdown selector.
     */
    selectDropdownTag: '[data-toggle=dropdownmenu]',

    events: {
        'click [data-toggle=dropdown]' : 'renderDropdown',
        //SC-1993: Dropdown is hidden in touch device by dropdownmenu element,
        // so ontouch dropdownmenu should follow the handler for onclick dropdown
        //SC-2007: on iOS7, touchstart won't trigger occasionally when select drawer is open.
        'mousedown [data-toggle=dropdownmenu]' : 'renderDropdown'
    },
    plugins: ['Tooltip'],

    /**
     * {@inheritDoc}
     *
     * This field doesn't support `showNoData`.
     */
    showNoData: false,

    initialize: function(options) {
        this._super('initialize', [options]);
        this.dropdownFields = [];

        //Throttle the setPlaceholder function per instance of this field.
        // TODO: Calling 'across controllers' considered harmful .. please consider using a plugin instead.
        var actiondropdownField = app.view._getController({type: 'field', name: 'actiondropdown'});
        this.setPlaceholder = _.throttle(actiondropdownField.prototype.setPlaceholder, 100);

        //shortcut keys
        app.shortcuts.register('Dropdown:More', 'm', function() {
            var $primaryDropdown = this.$('.btn-primary[data-toggle=dropdown]');
            if ($primaryDropdown.is(':visible') && !$primaryDropdown.hasClass('disabled')) {
                $primaryDropdown.click();
            }
        }, this);
    },
    renderDropdown: function() {
        if (_.isEmpty(this.dropdownFields) || this.isDisabled()) {
            return;
        }
        _.each(this.dropdownFields, function(field) {
            this.view.fields[field.sfId] = field;
            field.setElement(this.$('span[sfuuid="' + field.sfId + '"]'));
            if (this.def['switch_on_click'] && !this.def['no_default_action']) {
                field.$el.on('click.' + this.cid, _.bind(this.switchButton, this));
            }
            field.render();
        }, this);
        this.dropdownFields = null;

        if (!this.def['switch_on_click'] || this.def['no_default_action']) {
            return;
        }
        var firstField = _.first(this.fields);
        firstField.$el.on('click.' + this.cid, _.bind(this.switchButton, this));
        app.accessibility.run(firstField.$el, 'click');
    },
    switchButton: function(evt) {
        var sfId = parseInt(this.$(evt.currentTarget).attr('sfuuid'), 10),
            index = -1;
        _.some(this.fields, function(field, idx) {
            if (field.sfId === sfId) {
                index = idx;
                return true;
            }
            return false;
        }, this);
        if (index <= 0) {
            return;
        }
        //switch the selected button against the first button
        var firstField = this.fields.shift(),
            selectedField = this.fields.splice(index - 1, 1, firstField).pop();
        this.fields.splice(0, 0, selectedField);
        this.setPlaceholder();
    },
    getPlaceholder: function() {
        // Covers the use case where you have an actiondropdown field on listview right column,
        // and ListColumnEllipsis plugin is disabled.
        // Actiondropdown will be rendered empty if viewName equals to list-header.
        if (this.options.viewName === 'list-header') return app.view.Field.prototype.getPlaceholder.call(this);

        var caretCss = 'btn dropdown-toggle';
        if (this.def['no_default_action']) {
            caretCss += ' btn-invisible';
        } else if (this.def['primary']) {
            caretCss += ' btn-primary';
        }
        var cssClass = [],
            container = '',
            caretIcon = this.def['icon'] ? this.def['icon'] : 'icon-caret-down',
            caret = '<a track="click:actiondropdown" class="' + caretCss + '" data-toggle="dropdown" href="javascript:void(0);" data-placement="bottom" rel="tooltip" title="'+app.lang.get('LBL_LISTVIEW_ACTIONS')+'">' +
                '<span class="' + caretIcon + '"></span>' +
                '</a>',
            dropdown = '<ul data-menu="dropdown" class="dropdown-menu" role="menu">';

        //Since zero-index points to the default action placeholder,
        //assigning the beginning index to one will skip the default action placeholder
        var index = this.def['no_default_action'] ? 1 : 0;
        _.each(this.def.buttons, function(fieldDef) {
            var field = app.view.createField({
                def: fieldDef,
                view: this.view,
                viewName: this.options.viewName,
                model: this.model
            });
            this.fields.push(field);
            field.on('show hide', this.setPlaceholder, this);
            field.parent = this;
            if (fieldDef.type === 'divider') {
                return;
            }
            if (index == 0) {
                container += field.getPlaceholder();
            } else {
                //first time, unbind the dropdown button fields from the field's list
                //these fields are will be bound once the dropdown toggle is clicked
                delete this.view.fields[field.sfId];
                this.dropdownFields.push(field);

                if (index == 1) {
                    cssClass.push('actions', 'btn-group');
                    container += caret;
                    container += dropdown;
                }
                container += '<li>' + field.getPlaceholder() + '</li>';
            }
            index++;
        }, this);
        var cssName = cssClass.join(' '),
            placeholder = '<span sfuuid="' + this.sfId + '" class="' + cssName + '">' + container;
        placeholder += (_.size(this.def.buttons) > 0) ? '</ul></span>' : '</span>';
        return new Handlebars.SafeString(placeholder);

    },

    _render: function() {
        this._super('_render');
        this.setPlaceholder();
        this._updateCaret();
    },
    /**
     * Enable or disable caret depending on if there are any enabled actions in the dropdown list
     * @private
     */
    _updateCaret: function() {
        if (_.isEmpty(this.dropdownFields)) {
            return;
        }
        var caretEnabled = _.some(this.dropdownFields, function(field) {
            if (field.hasAccess()) {
                if (field.def.css_class.indexOf('disabled') > -1) { //If action disabled in metadata
                    return false;
                } else if (field.isDisabled()) { //Or disabled via field controller
                    return false;
                } else {
                    return true;
                }
            }
            return false;
        });
        if (!caretEnabled) {
            this.$('.icon-caret-down').closest('a').addClass('disabled');
        }
    },
    setPlaceholder: function() {
        if (this.disposed) {
            return;
        }
        //Since zero-index points to the default action placeholder,
        //assigning the beginning index to one will skip the default action placeholder
        var index = this.def['no_default_action'] ? 1 : 0,
            //Using document fragment to reduce calculating dom tree
            visibleEl = document.createDocumentFragment(),
            hiddenEl = document.createDocumentFragment();
        _.each(this.fields, function(field) {
            var cssClass = _.unique(field.def.css_class ? field.def.css_class.split(' ') : []),
                fieldPlaceholder = this.$('span[sfuuid="' + field.sfId + '"]');
            if (field.type === 'divider') {
                //Divider is only attached the below the first dropdown action.
                if (index <= 1) {
                    return;
                }
                var dividerEl = document.createElement('li');
                dividerEl.className = 'divider';
                visibleEl.appendChild(dividerEl);
                return;
            }
            if (field.isVisible() && field.hasAccess()) {
                cssClass = _.without(cssClass, 'hide');
                fieldPlaceholder.toggleClass('hide', false);
                if (index == 0) {
                    if (field.def.icon && field.closestComponent('subpanel')) {
                        field.setMode('small');
                    }
                    cssClass.push('btn');
                    field.getFieldElement().addClass('btn');
                    if (this.def.primary) {
                        cssClass.push('btn-primary');
                        field.getFieldElement().addClass('btn-primary');
                    }
                    //The first field needs to be out of the dropdown
                    this.$el.prepend(fieldPlaceholder);
                } else {
                    if (field._previousAction) {
                        field.setMode(field._previousAction);
                    }
                    cssClass = _.without(cssClass, 'btn', 'btn-primary');
                    field.getFieldElement().removeClass('btn btn-primary');
                    //Append field into the dropdown
                    var dropdownEl = document.createElement('li');
                    dropdownEl.appendChild(fieldPlaceholder.get(0));
                    visibleEl.appendChild(dropdownEl);
                }
                index++;
            } else {
                cssClass.push('hide');
                fieldPlaceholder.toggleClass('hide', true);
                //Drop hidden field out of the dropdown
                hiddenEl.appendChild(fieldPlaceholder.get(0));
            }
            cssClass = _.unique(cssClass);
            field.def.css_class = cssClass.join(' ');
        }, this);

        if (index <= 1) {
            this.$(this.actionDropDownTag).hide();
            this.$el.removeClass('btn-group');
        } else {
            this.$(this.actionDropDownTag).show();
            this.$el.addClass('btn-group');
        }
        //remove all previous built dropdown tree
        this.$('[data-menu=dropdown]').children('li').remove();
        //and then set the dropdown list with new button list set
        this.$('[data-menu=dropdown]').append(visibleEl);
        this.$el.append(hiddenEl);

        //if the first button is hidden due to the acl,
        //it will build all other dropdown button and set it use dropdown button set
        var firstButton = _.first(this.fields);
        if (firstButton && !firstButton.isVisible()) {
            this.renderDropdown();
        }
    },
    setDisabled: function(disable) {
        this._super('setDisabled', [disable]);
        disable = _.isUndefined(disable) ? true : disable;
        if (disable) {
            this.$(this.actionDropDownTag).addClass('disabled');
        } else {
            this.$(this.actionDropDownTag).removeClass('disabled');
        }
    },

    _dispose: function() {
        _.each(this.fields, function(field) {
            field.$el.off('click.' + this.cid);
            field.off('show hide', this.setPlaceholder, this);
        }, this);
        this.dropdownFields = null;
        this._super('_dispose');
    },

    /**
     *  Visibility Check
     */
    isVisible: function() {
        return !this.getFieldElement().is(':hidden');
    },

    /**
     * @override
     * @param {String} mode     What mode we are changing to
     */
    setMode: function(mode) {
        this._super('setMode', [mode]);
        _.each(this.fields, function(field, index) {
            // when we are on the first field, mode is changing to list, the field has an icon
            // and the field is in a subpanel, use the small template
            if (index === 0 && mode === 'list' && field.def.icon && field.closestComponent('subpanel')) {
                field.setMode('small');
            } else {
                field.setMode(mode);
            }
        }, this);
    }
})
