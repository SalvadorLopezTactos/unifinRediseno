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
 * Rowaction is a button that when selected will trigger a Backbone Event.
 *
 * @class View.Fields.Base.RowactionField
 * @alias SUGAR.App.view.fields.BaseRowactionField
 * @extends View.Fields.Base.ButtonField
 */
({
    extendsFrom: 'ButtonField',
    initialize: function(options) {
        this.options.def.events = _.extend({}, this.options.def.events, {
            'click .rowaction': 'rowActionSelect'
        });
        this._super("initialize", [options]);
    },
    /**
     * Triggers event provided at this.def.event on the view's context object by default.
     * Can be configured to trigger events on 'view' itself or the view's 'layout'.
     * @param evt
     */
    rowActionSelect: function(evt) {
        if(this.isDisabled()){
            return;
        }
        // make sure that we are not disabled first
        if(this.preventClick(evt) !== false) {
            var target = this.view.context;  // view's 'context' is target by default
            if (this.def.target === 'view') {
                target = this.view;
            } else if (this.def.target === 'layout') {
                target = this.view.layout;
            }
            if ($(evt.currentTarget).data('event')) {
                target.trigger($(evt.currentTarget).data('event'), this.model, this);
            }
        }
    }
})
