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
({
    /**
     * Who is my parent
     */
    extendsFrom: 'HeaderpaneView',
    plugins: ['FieldErrorCollection'],

    /**
     * Boolean if the Save button should be disabled or not
     */
    saveBtnDisabled: true,

    /**
     * Boolean if the Save button should be disabled or not
     */
    commitBtnDisabled: true,

    /**
     * Boolean if any fields in the view have errors or not
     */
    fieldHasErrorState: false,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super("initialize", [options]);

        this.on('render', function() {
            this.getField('save_draft_button').setDisabled();
            // this is a hacky way to add the class but it needs to be done for proper spacing
            this.getField('save_draft_button').$el.addClass('btn-group');
            this.getField('commit_button').setDisabled();
        }, this);
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this.context.on('change:selectedUser', function(model, changed) {
            this._title = changed.full_name;
            if (!this.disposed) {
                this.render();
            }
        }, this);

        this.context.on('plugin:fieldErrorCollection:hasFieldErrors', function(collection, hasErrors) {
            this.fieldHasErrorState = hasErrors;
            this.setButtonStates();
        }, this)

        this.context.on('button:print_button:click', function() {
            window.print();
        }, this);

        this.context.on('forecasts:worksheet:is_dirty', function(worksheet_type, is_dirty) {
            this.saveBtnDisabled = !is_dirty;
            this.commitBtnDisabled = !is_dirty;
            this.setButtonStates();
        }, this);

        this.context.on('button:commit_button:click button:save_draft_button:click', function() {
            this.saveBtnDisabled = true;
            this.commitBtnDisabled = true;
            this.setButtonStates();
        }, this);

        this.context.on('forecasts:worksheet:saved', function(totalSaved, worksheet_type, wasDraft){
            if(wasDraft === true) {
                this.commitBtnDisabled = false;
                this.setButtonStates();
            }
        }, this);

        this.context.on('forecasts:worksheet:needs_commit', function(worksheet_type) {
            this.commitBtnDisabled = false;
            this.setButtonStates();
        }, this);

        this._super("bindDataChange");
    },

    /**
     * Sets the Save Button and Commit Button to enabled or disabled
     */
    setButtonStates: function() {
        // fieldHasErrorState trumps the disabled flags, but when it's cleared
        // revert back to whatever states the buttons were in
        if (this.fieldHasErrorState) {
            this.getField('save_draft_button').setDisabled(true);
            this.getField('commit_button').setDisabled(true);
        } else {
            this.getField('save_draft_button').setDisabled(this.saveBtnDisabled);
            this.getField('commit_button').setDisabled(this.commitBtnDisabled);
        }
    },

    /**
     * @inheritdoc
     */
    _renderHtml: function() {
        var user = this.context.get('selectedUser') || app.user.toJSON();
        this._title = this._title || user.full_name;

        this._super("_renderHtml");
    }
})
