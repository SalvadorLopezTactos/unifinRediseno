({
    extendsFrom: 'RecordView',
    initialize: function (options) {
        this._super('initialize', [options]);
        // checking licence configuration ///////////////////////

        var url = App.api.buildURL("bc_survey", "checkingLicenseStatus", "", {});

        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data != 'success') {
                    location.assign('#bc_survey_submission/layout/access-denied');
                }
            },
        });
    },
    _render: function () {

        if (app.acl.hasAccess('admin', 'Administration')) {
            this._super('_render');
        } else {
            location.assign('#bc_survey_submission/layout/access-denied');
        }
    },
    events: {
        'click .record-edit-link-wrapper': 'handleEdit',
        'click [data-action=scroll]': 'paginateRecord',
        'click .record-panel-header': 'togglePanel',
        'click #recordTab > .tab > a:not(.dropdown-toggle)': 'setActiveTab',
        'click .tab .dropdown-menu a': 'triggerNavTab'
    },
    paginateRecord: function (evt) {
        this._super('paginateRecord', [evt]);
    },
    togglePanel: function (e) {
        this._super('togglePanel', [e]);
    },
    setActiveTab: function (event) {
        this._super('setActiveTab', [event]);
    },
    triggerNavTab: function (e) {
        this._super('triggerNavTab', [e]);
    },
    /**
     * Handler for intent to edit. This handler is called both as a callback
     * from click events, and also triggered as part of tab focus event.
     *
     * @param {Event} e Event object (should be click event).
     * @param {jQuery} cell A jQuery node cell of the target node to edit.
     */
    handleEdit: function (e, cell) {

        var target,
                cellData,
                field;
        if (e) { // If result of click event, extract target and cell.
            target = this.$(e.target);
            cell = target.parents('.record-cell');
        }

        cellData = cell.data();
        field = this.getField(cellData.name);
        // check for target_module and execution_occurs and ignore for inline edit default functionality

        // Set Editing mode to on.
//            this.inlineEditMode = true;
//            this.setButtonStates(this.STATE.EDIT);
//            this.toggleField(field);


        if (cell.closest('.headerpane').length > 0) {
            this.toggleViewButtons(true);
            this.adjustHeaderpaneFields();
        }

    },
})


