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
 * Actionbar for the email compose view
 *
 * Def for this field includes an array called buttonSections
 * Each object in the array can have a type (corresponding to a field that extends from fieldset and includes an array of buttons)
 * Or if object contains no type, a button group is built by default using the buttons array in the section
 * Additional CSS can be added to the default button group using the css_class attribute
 *
 * @class View.Fields.Base.Emails.ComposeActionbarField
 * @alias SUGAR.App.view.fields.BaseEmailsComposeActionbarField
 * @extends View.Fields.Base.FieldsetField
 */
({
    extendsFrom: 'FieldsetField',
    fields: null,

    events: {
        'click a:not(.dropdown-toggle)': 'handleButtonClick'
    },

    /**
     * Loop over the button sections and build placeholders for each
     *
     * @return {Handlebars.SafeString}
     */
    getPlaceholder: function() {
        var placeholder = this._super("getPlaceholder");
        var $container = $(placeholder.toString());

        _.each(this.def.buttonSections, function(buttonSection) {
            var placeHolderString;
            if (!_.isUndefined(buttonSection.type)) {
                placeHolderString = this.buildTypedButtonSection(buttonSection);
            } else {
                placeHolderString = this.buildDefaultButtonSection(buttonSection);
            }
            $container.append(placeHolderString);
        }, this);

        return new Handlebars.SafeString($container.get(0).outerHTML);
    },

    /**
     * If a type was specified on the button section, use the def to build a field of that type
     *
     * @param def
     * @return {String}
     */
    buildTypedButtonSection: function(def) {
        var field = app.view.createField({
            def: def,
            view: this.view,
            viewName: this.options.viewName,
            model: this.model
        });
        this.fields.push(field);

        return field.getPlaceholder().toString();
    },

    /**
     * If button section has no type, build an actions btn-group
     *
     * @param def
     * @return {String}
     */
    buildDefaultButtonSection: function(def) {
        var $defaultSection = $('<div class="actions"></div>');

        if (def.css_class) {
            $defaultSection.addClass(def.css_class);
        }

        _.each(def.buttons, function(button) {
            var field = app.view.createField({
                def: button,
                view: this.view,
                viewName: this.options.viewName,
                model: this.model
            });
            this.fields.push(field);
            $defaultSection.append(field.getPlaceholder().toString());
        }, this);

        return $defaultSection.get(0).outerHTML;
    },

    /**
     * Fire an event when any of the buttons on the actionbar are clicked
     * Events could be set via the data-event attribute or an event is built using the button name
     *
     * @param evt
     */
    handleButtonClick: function(evt) {
        var triggerName, buttonName,
            $currentTarget = $(evt.currentTarget);
        if ($currentTarget.data('event')) {
            triggerName = $currentTarget.data('event');
        } else {
            buttonName = $currentTarget.attr('name') || 'button';
            triggerName = 'actionbar:' + buttonName + ':clicked';
        }
        this.view.context.trigger(triggerName);
    }
})
