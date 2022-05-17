({
    /**
     * The file used to handle action of create-survey component 
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */
    extendsFrom: 'RecordView',
    inlineEditMode: false,
    // current button states
    currentState: null,
    restrictEdit: 'false',
    events: {
        'click .record-edit-link-wrapper': 'handleEdit',
        'click a[name=cancel_button]': 'cancelClicked',
        'click [data-action=scroll]': 'paginateRecord',
        'click .record-panel-header': 'togglePanel',
        'click #recordTab > .tab > a:not(.dropdown-toggle)': 'setActiveTab',
        'click .tab .dropdown-menu a': 'triggerNavTab',
        'click .get_share_link': 'get_sharable_link',
        'click .copy_survey_link': 'copy_sharable_link',
        'click [data-original-title=Actions]': 'hideCopyButtonPoll'
    },
    delegateButtonEvents: function () {
        this.context.on('button:edit_button:click', this.editClicked, this);
        this.context.on('button:save_button:click', this.saveClicked, this);
        this.context.on('button:duplicate_button:click', this.duplicateClicked, this);
        this.context.on('button:delete_button:click', this.deleteClicked, this);
        this.context.on('button:view_report:click', this.view_reportClicked, this);
        this.context.on('button:preview_survey:click', this.preview_surveyClicked, this);
        this.context.on('button:translate_survey:click', this.translate_surveyClicked, this);
        this.context.on('button:manage_email_template:click', this.manage_email_templateClicked, this);
        this.context.on('button:export_button:click', this.export_buttonClicked, this);
        this.context.on('button:export_word_button:click', this.exportword_buttonClicked, this);
        this.context.on('button:view_survey_transactions:click', this.view_survey_transactions_buttonClicked, this);
    },
    /**
     * Handles click event on next/previous button of record.
     * @param {Event} evt
     */
    paginateRecord: function (evt) {
        this._super('paginateRecord', [evt]);
    },
    /**
     * Hide or show panel based on click to the panel header
     * @param {Event} e
     */
    togglePanel: function (e) {
        this._super('togglePanel', [e]);
    },
    /**
     * sets active tab in user last state
     * @param {Event} event
     */
    setActiveTab: function (event) {
        this._super('setActiveTab', [event]);
    },
    /**
     * Takes a tab dropdown link and triggers the corresponding tab
     * @param {Event} e
     */
    triggerNavTab: function (e) {
        this._super('triggerNavTab', [e]);
    },
    cancelClicked: function () {
        this._super('cancelClicked');
    },
    duplicateClicked: function () {

        var self = this,
                prefill = app.data.createBean(this.model.module);

        prefill.copy(this.model);
        //set prefill data to localStorage
        localStorage['prefill'] = JSON.stringify(prefill);
        localStorage['copiedFromModelId'] = this.model.get('id');
        localStorage['prefill_type'] = 'bc_survey';
        localStorage['survey_theme'] = self.$el.parents('.main-pane').next('.sidebar-content').find('[name=survey_theme]:checked').val();
        this._copyNestedCollections(this.model, prefill);
        self.model.trigger('duplicate:before', prefill);
        prefill.unset('id');
        localStorage['copyFromSurvey'] = true;
        //redirect to create survey drawer
        var newWin = window.open("#bc_survey/create", "_blank");
        if (typeof newWin == "undefined") {
            app.alert.show('info', {
                level: 'info',
                messages: 'Please allow your browser to show pop-ups.',
                autoClose: true
            });
        }

        prefill.trigger('duplicate:field', self.model);
    },
    hideCopyButtonPoll: function () {
        if (this.model.get('survey_type') == 'poll')
        {
            $('[name=duplicate_button]').hide();
        }
    },
    _copyNestedCollections: function (model, prefill) {
        this._super('_copyNestedCollections', [model, prefill]);
    },
    /**delete button is clicked so restrict action when loading detail view
     * 
     * @returns {undefined}
     */
    deleteClicked: function () {
        if (typeof app.alert.get('loading_detail_view') != "undefined") {
            app.alert.show('error', {
                level: 'error',
                messages: 'Please wait while detailview is loading.',
                autoClose: true
            });
        } else {
            this._super('deleteClicked');
        }
    },
    /**view report clicked for analysing survey
     * 
     * @returns {undefined}
     */
    view_reportClicked: function () {
        var record_id = this.model.id;
        javascript:parent.SUGAR.App.router.navigate("bc_survey/" + record_id + "/layout/report", {trigger: true});
    },
    /**view translate survey
     * 
     * @returns {undefined}
     */
    translate_surveyClicked: function () {
        var record_id = this.model.id;
        javascript:parent.SUGAR.App.router.navigate("bc_survey/" + record_id + "/layout/translate-survey", {trigger: true});
    },
    /**preview survey action
     * 
     * @returns {undefined}
     */
    preview_surveyClicked: function () {
        var record_id = this.model.id;
        $.ajax({
            url: "index.php?entryPoint=preview_survey",
            type: "POST",
            data: {method: 'preview_survey'},
            success: function (data)
            {
                var newWin = window.open(data + '/preview_survey.php?survey_id=' + record_id);
                if (typeof newWin == "undefined") {
                    app.alert.show('info', {
                        level: 'info',
                        messages: 'Please allow your browser to show pop-ups.',
                        autoClose: true
                    });
                }
            },
        });
    },
    manage_email_templateClicked: function () {

        var self = this;
        var survey_ID = this.model.id;
        var url = App.api.buildURL("bc_survey", "checkEmailTemplateForSurvey", "", {survey_ID: survey_ID});
        App.api.call('GET', url, {}, {
            success: function (data) {
                // email template exists then redirect to that record
                if (data && data.trim() != '') {
                    var newWin = window.open("#bwc/index.php?module=EmailTemplates&action=DetailView&record=" + data);
                    if (typeof newWin == "undefined") {
                        app.alert.show('info', {
                            level: 'info',
                            messages: 'Please allow your browser to show pop-ups.',
                            autoClose: true
                        });
                    }
                }
                // email template does not exists so redirect to create emailm template if confirm is OK
                else {
                    // Survey Status :: LoadedTech Customization
                    if (self.model.get('survey_status') == 'Active')
                    {
                        app.alert.show('stop_confirmation', {
                            level: 'confirmation',
                            title: '',
                            messages: 'Email template does not exist. Click Confirm to create email template for ' + self.model.get('name') + '.',
                            onConfirm: function () {
                                var newWin = window.open('#bwc/index.php?module=EmailTemplates&action=EditView&return_module=EmailTemplates&return_action=DetailView&survey_id=' + survey_ID);
                                if (typeof newWin == "undefined") {
                                    app.alert.show('info', {
                                        level: 'info',
                                        messages: 'Please allow your browser to show pop-ups.',
                                        autoClose: true
                                    });
                                }
                            },
                            onCancel: function () {
                                app.alert.dismiss('stop_confirmation');
                            },
                            autoClose: false
                        });
                    } else {
                        app.alert.show('error_inactive_survey', {
                            level: 'error',
                            messages: 'You can not create email template for Inactive Survey.',
                            autoClose: true
                        });
                    }
                    // Survey Status :: LoadedTech Customization END
                }
            }
        });
    },
    /*
     * Export survey / Poll as PDF
     * @returns {undefined}
     */
    export_buttonClicked: function () {
        var record_id = this.model.id;
        window.open('index.php?entryPoint=export_survey_form&survey_id=' + record_id, '_self');
    },
    /*
     * Export survey / Poll as WORD DOCUMENT
     * @returns {undefined}
     */
    exportword_buttonClicked: function () {
        var record_id = this.model.id;
        window.open('index.php?entryPoint=export_survey_form&type=word&survey_id=' + record_id, '_self');
    },
    /*
     * View current survey related survey transactions
     * @returns {undefined}
     */
    view_survey_transactions_buttonClicked:function(){
        localStorage['survey_id'] = this.model.id;
        window.open('#bc_survey_submission');
    },
    /** save edited model
     * 
     * @returns {undefined}
     */
    _saveModel: function () {
        var error_status = $(document).find($('.error-custom'));
        if (error_status.length == 0) {
            this._super('_saveModel');
        }
    },
    initialize: function (options) {

        // checking licence configuration ///////////////////////

        var url = App.api.buildURL("bc_survey", "checkingLicenseStatus", "", {});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data != 'success') {
                    location.assign('#bc_survey/layout/access-denied');
                }
            },
        });
        this._super('initialize', [options]);
        var self = this;
        //check restrict edit or not   //////////////////////////
        var url = App.api.buildURL("bc_survey", "isSurveySend", "", {record: self.model.get('id')});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data && data['restrict_edit'] == "1") {
                    self.restrictEdit = 'true';
                }
            },
        });
        this.model.addValidationTask('footer_content', _.bind(this._doValidateRequiredFooter_content, this));

        /////////////////////////////////////////////////////////
        //validate start-date end-date field
        // this.model.addValidationTask('start_date', _.bind(this._doValidateStartDate, this));
        this.model.addValidationTask('end_date', _.bind(this._doValidateEndDate, this));
        this.model.addValidationTask('redirect_url', _.bind(this._doValidateRedirectUrl, this));
        this.model.addValidationTask('review_mail_content', _.bind(this._doValidateReviewMailContent, this));
    },
    /**validate start date field
     * 
     * @param {type} fields
     * @param {type} errors
     * @param {type} callback
     * @returns {undefined}
     */
    _doValidateStartDate: function (fields, errors, callback) {
        //validate requirements
        var today = app.date();
        var startdate = app.date(this.model.get('start_date'));
        var t_date = today._d.getDate() + '-' + today._d.getMonth() + '-' + today._d.getYear();
        var s_date = startdate._d.getDate() + '-' + startdate._d.getMonth() + '-' + startdate._d.getYear();
        var today_string = today.get

        if (this.model.get('start_date') && !startdate.isAfter(today) && s_date != t_date) {
            errors['start_date'] = errors['start_date'] || {};
            errors['start_date'].isAfter = 'current date';
        }

        callback(null, fields, errors);
    },
    /**validate end date field
     * 
     * @param {type} fields
     * @param {type} errors
     * @param {type} callback
     * @returns {undefined}
     */
    _doValidateEndDate: function (fields, errors, callback) {
        //validate requirements
        var startdate = app.date(this.model.get('start_date'));
        var enddate = app.date(this.model.get('end_date'));
        if (this.model.get('end_date') && this.model.get('start_date') && !enddate.isAfter(startdate)) {
            errors['end_date'] = errors['end_date'] || {};
            errors['end_date'].isAfter = 'start date';
        }

        callback(null, fields, errors);
    },
    /*
     * 
     * @param {type} options
     * @returns {undefined}
     */
    _doValidateRedirectUrl: function (fields, errors, callback) {

        //validate requirements
        var redirectUrl = $('[name=redirect_url]').val();
        app.error.errorName2Keys['redirect_url_invalid'] = 'REDIRECT_URL_INVALID';
        var re = /((((ht|f)tps?:\/\/)[^\/\s]+\.[^\/\s]+\.[^\/\s]+)[\/\S*]?)/gi;
        if (redirectUrl && !re.test(redirectUrl))
        {
            errors['redirect_url'] = errors['redirect_url'] || {};
            errors['redirect_url'].redirect_url_invalid = true;
        }

        callback(null, fields, errors);
    },
    /**validate end date field
     * 
     * @param {type} fields
     * @param {type} errors
     * @param {type} callback
     * @returns {undefined}
     */
    _doValidateReviewMailContent: function (fields, errors, callback) {

        //validate requirements
        if (this.model.get('enable_review_mail'))
        {
            var review_mail_content = app.date(this.model.get('review_mail_content'));
            if (!this.model.get('review_mail_content')) {
                errors['review_mail_content'] = errors['review_mail_content'] || {};
                errors['review_mail_content'].required = true;
                $('[data-type=htmleditable_tinymce]').find('.edit').css('border', '1px solid red');
                if ($('[data-type=htmleditable_tinymce]').parent().find('.error-msg').length == 0)
                {
                    $('[data-type=htmleditable_tinymce]').prepend('<div class="error-msg"><i class="fa fa-exclamation-circle " style="color:red;">&nbsp;</i><span style="color:red;">Error. This field is required.</span></div>');
                }

            } else {

                $('[data-type=htmleditable_tinymce]').find('.edit').css('border', '');
                if ($('[data-type=htmleditable_tinymce]').parent().find('.error-msg').length != 0)
                {
                    $('[data-type=htmleditable_tinymce]').parent().find('.error-msg').remove();
                }

            }
        }

        callback(null, fields, errors);
    },
    _doValidateRequiredFooter_content: function (fields, errors, callback) {

        var footercontent = this.model.get('footer_content');
        if (footercontent && footercontent.length > 500) {
            errors['footer_content'] = errors['footer_content'] || {};
            errors['footer_content'].limited_length = true;
            // errors['footer_content'].required = true;

            app.alert.show('survey_footer_invalid', {
                level: 'error',
                messages: 'Footer content length must be less than 500 character.',
                autoClose: true
            });
        }
        callback(null, fields, errors);
    },
    _render: function () {

        var self = this;
        this._super('_render');
      //  $('[data-name="survey_type"]').hide(); // hide survey type field

        // add "Get Shareable Link" Button to record view
        $('[data-name="allow_redundant_answers"]').parents('.panel_body').append('<div class="btn btn-primary get_share_link" rel="tooltip" data-original-title="Get Survey Shareable Link">Get Shareable Link</div>');

        // if poll then hide some panel which are not necessary for POLL
        if (this.model.get('survey_type') == 'poll')
        {
            $('[name=duplicate_button]').hide();
            $('[data-name=enable_data_piping]').parents('.panel_body').hide();
            $('.label-bc_survey').attr('data-original-title', 'Poll').html('Po');
            $('[data-panelname=LBL_RECORDVIEW_PANEL1]').find('.pull-left').html('Poll Question');

            $(document).find($('.create-survey')).hide(); // hide side-pane page-component
            $('[data-name=description]').css('display', 'none'); // hide description
            $('[data-panelname=LBL_RECORDVIEW_PANEL2]').hide(); // hide advance configuration PANEL
            $('[data-panelname=LBL_RECORDVIEW_PANEL3]').hide(); // hide Welcome Page PANEL
            $('[data-panelname=LBL_RECORDVIEW_PANEL4]').hide(); // hide Thanks Page PANEL

            // make available panel mode as ACTIVE
            $.each($('.record-panel-header'), function () {
                $(this).removeClass('panel-inactive');
                $(this).addClass('panel-active');
                $(this).parent().find('.record-panel-content').removeClass('hide');
            });
        } else if (this.model.get('survey_type') == 'survey') {
            $('[data-name="allow_redundant_answers"]').hide();
        }
        //get shrable link   //////////////////////////
        this.get_sharable_link('', 'isRender');

        var url = App.api.buildURL("bc_survey", "retrieve_all_module_field_required_status", "", {});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data)
                {
                    self.sync_module_fields_is_required = data;
                }
            }
        });
    },
    get_sharable_link: function (el, status) {

        //get shrable link   //////////////////////////
        var self = this;
        var url = App.api.buildURL("bc_survey", "generate_unique_survey_submit_id", "", {survey_id: self.model.get('id'), status: status});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data) {
                    var survey_sharable_link = data;
                    if ($('.get_share_link').parents('.panel_body').find('.open_link').length == 0)
                    {
                        $('.get_share_link').parents('.panel_body').append('&nbsp;<input class="open_link" id="get_share_link" style="width: 50%;" type="text" value="' + survey_sharable_link + '" />&nbsp;  <button type="button" class="btn btn-primary copy_survey_link" rel="tooltip" data-original-title="Copy Survey Shareable Link">Copy Survey Link</button>');
                    } else {
                        $('.get_share_link').parents('.panel_body').find('.open_link').val(survey_sharable_link);
                    }
                }
            },
        });
    },
    copy_sharable_link: function () {

        /* Get the text field */
        var copyText = document.getElementById("get_share_link");

        /* Select the text field */
        copyText.select();

        /* Copy the text inside the text field */
        document.execCommand("Copy");

        app.alert.show('survey_link_copied', {
            level: 'success',
            messages: 'Survey Shareable Link copied to clipboard.',
            autoClose: true
        });
    },
    toggleEdit: function (isEdit) {

        this._super('toggleEdit', [isEdit]);
        _.each(this.fields, function (field) {
            if (field.name == 'survey_type')
                field.isHidden = true;
        });
    },
    /**
     * Handler for intent to edit. This handler is called both as a callback
     * from click events, and also triggered as part of tab focus event.
     *
     * @param {Event} e Event object (should be click event).
     * @param {jQuery} cell A jQuery node cell of the target node to edit.
     */
    handleEdit: function (e, cell) {
        var self = this;

        var url = App.api.buildURL("bc_survey", "isSurveySend", "", {record: self.model.get('id')});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data && data['restrict_edit'] == "1") { // survey is send so disable all kind of edit of page
                    $('[name="edit_button"]').addClass('disabled');
                    self.restrictEdit = "true";
                } else { // survey is not send so enable all kind of edit
                    self.restrictEdit = "false";
                }
                if (self.restrictEdit == 'true') {
                    if (self.model.get('survey_type') == 'poll')
                    {
                        var sent_msg = 'This Poll Is Now Active and Cannot Be Edited, Please Create a New Poll.';
                    } else {
                        var sent_msg = 'This Survey Is Now Active and Cannot Be Edited, Please Create a New Survey.';
                    }
                    app.alert.show('error', {
                        level: 'error',
                        messages: sent_msg,
                        autoClose: true
                    });
                } else if (typeof app.alert.get('loading_detail_view') != "undefined") {
                    app.alert.show('error', {
                        level: 'error',
                        messages: 'Please wait while detailview is loading.',
                        autoClose: true
                    });
                } else {
                    self.model.editAllPages = false;
                    var target,
                            cellData,
                            field;
                    if (e) { // If result of click event, extract target and cell.
                        target = self.$(e.target);
                        cell = target.parents('.record-cell');
                    }

                    cellData = cell.data();
                    field = self.getField(cellData.name);

                    // check for custom field surveypages and ignore for inline edit default functionality
                    if (field.name != 'surveypages' && field.name != 'enable_review_mail' && field.name != 'enable_data_piping' && field.name != 'sync_module' && field.name != 'sync_type' && field.name != 'survey_theme') {
                        // Set Editing mode to on.
                        self.inlineEditMode = true;
                        self.setButtonStates(self.STATE.EDIT);
                        self.toggleField(field);
                    }

                    if (cell.closest('.headerpane').length > 0) {
                        self.toggleViewButtons(true);
                        self.adjustHeaderpaneFields();
                    }
                }
            }
        });
    },
    toggleViewButtons: function () {
        this._super('toggleViewButtons');
    },
    adjustHeaderpaneFields: function () {
        this._super('adjustHeaderpaneFields');
    },
    // apply custom edit in detailview for SurveyPages
    editClicked: function () {
        var self = this;
        var url = App.api.buildURL("bc_survey", "isSurveySend", "", {record: self.model.get('id')});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data && data['restrict_edit'] == "1") { // survey is send so disable all kind of edit of page
                    $('[name="edit_button"]').addClass('disabled');
                    self.restrictEdit = "true";
                } else { // survey is not send so enable all kind of edit
                    self.restrictEdit = "false";
                }
                if (self.restrictEdit == 'true') {
                    if (this.model.get('survey_type') == 'poll')
                    {
                        var sent_msg = 'This Poll Is Now Active and Cannot Be Edited, Please Create a New Poll.';
                    } else {
                        var sent_msg = 'This Survey Is Now Active and Cannot Be Edited, Please Create a New Survey.';
                    }
                    app.alert.show('error', {
                        level: 'error',
                        messages: sent_msg,
                        autoClose: true
                    });
                } else if (typeof app.alert.get('loading_detail_view') != "undefined") {
                    app.alert.show('error', {
                        level: 'error',
                        messages: 'Please wait while detailview is loading.',
                        autoClose: true
                    });
                } else {
                    self.model.editAllPages = true;
                    self._super('editClicked');
                }
            }
        });
    },
    bindDataChange: function () {
        this._super('bindDataChange');
    },
    /**
     * Enables or disables the action buttons that are currently shown on the
     * page. Toggles the `.disabled` class by default.
     *
     * @param {boolean} [enable=false] Whether to enable or disable the action
     *   buttons. Defaults to `false`.
     */
    toggleButtons: function (enable) {

        var state = !_.isUndefined(enable) ? !enable : false;
        _.each(this.buttons, function (button) {
            var showOn = button.def.showOn;
            if (_.isUndefined(showOn) || this.currentState === showOn) {
                button.setDisabled(state);
            }
        }, this);
    },
    /**
     * Show/hide buttons depending on the state defined for each buttons in the
     * metadata.
     *
     * @param {String} state The {@link #STATE} of the current view.
     */
    setButtonStates: function (state) {
        this._super('setButtonStates', [state]);
    },
    setEditableFields: function () {

        delete this.editableFields;
        this.editableFields = [];
        var self = this;
        var previousField, firstField;
        _.each(this.fields, function (field) {

            var readonlyField = field.def.readonly ||
                    _.indexOf(this.noEditFields, field.def.name) >= 0 ||
                    field.parent || (field.name && this.buttons[field.name]);
            if (readonlyField) {
                // exclude read only fields
                return;
            }

            if (field.name == 'enable_data_piping' && field.name == 'sync_module' && field.name == 'sync_type' && field.name == 'enable_review_mail') {
                return;
            }
            if (previousField) {
                previousField.nextField = field;
                field.prevField = previousField;
            } else {
                firstField = field;
            }
            previousField = field;
            this.editableFields.push(field);
        }, this);
        if (previousField) {
            previousField.nextField = firstField;
            firstField.prevField = previousField;
        }

    },
    /**
     * Called each time a validation pass is completed on the model.
     *
     * Enables the action button and calls {@link #handleSave} if the model is
     * valid.
     *
     * @param {boolean} isValid TRUE if model is valid.
     */
    validationComplete: function (isValid) {

        var error_status = $(document).find($('.error-custom'));
        if (error_status.length == 0) {
            this.toggleButtons(true);
            if (isValid) {
                this.handleSave();
            }
            this.model.isValid = isValid;
        } else {
            this.toggleButtons(false);
        }
    },
    /** handle save of record
     * 
     * @returns {undefined}
     */
    handleSave: function () {
        this._super('handleSave');
    },
    /**save button clicked so save model & surveypages after validating it
     * 
     * @returns {undefined}
     */
    saveClicked: function () {
        // To save default value of review mail content if value is empty
        if (!this.model.attributes.review_mail_content)
        {
            this.model.attributes.review_mail_content = 'Thank you for taking time to reviewing and submitting the survey with your valuable views and opinions.<br><br> We’ve taken into account your concerns submitted with this survey.<br><br> This will help us serve you better in future! <br><br>Thank you once again for your time and efforts!<br><br>';
        }
        // ENDF
        var self = this;
        app.alert.dismiss('loading_detail_view');
        if (this.restrictEdit == 'true') {
            if (this.model.get('survey_type') == 'poll')
            {
                var sent_msg = 'This Poll Is Now Active and Cannot Be Edited, Please Create a New Poll.';
            } else {
                var sent_msg = 'This Survey Is Now Active and Cannot Be Edited, Please Create a New Survey.';
            }
            app.alert.show('error', {
                level: 'error',
                messages: sent_msg,
                autoClose: true
            });
        } else if (typeof app.alert.get('loading_detail_view') != "undefined") {
            app.alert.show('error', {
                level: 'error',
                messages: 'Please wait while detailview is loading.',
                autoClose: true
            });
        } else {
            var sync_module = $('[name=sync_module]').val();
            var error_on_sync_duplication = false;
            var error_on_sync_req_missing = false;
            var sync_field_obj = new Array();

            // get module required fields
            var module_required_fields = '';

            //validating page_title , question and options field
            $('.thumbnail').each(function () {
                var id = this.id;
                var page_id = $('#' + id).find('.page_id').val();
                var data_page = $('#data-' + id);
                $(data_page).each(function () {
                    var question_class_id = this.id;
                    $('#' + question_class_id).each(function () {
                        var que_class = $('#' + question_class_id).find('.question');
                        var que_sec_class = $('#' + question_class_id).find('.question-section');
                        if (typeof que_class == "object" && que_class.length == 0) {
                            $('#' + question_class_id).addClass('error-custom');
                        }
                        // check question section exists or not
                        else if (typeof que_class == "object" && typeof que_sec_class == "object" && que_class.length == que_sec_class.length)
                        {
                            $('#' + question_class_id).addClass('error-custom');
                            // validate section title
                            $.each(que_sec_class, function () {
                                if (!$(this).find('#section_title').val())
                                {
                                    $(this).find('#section_title').attr('style', 'border:1px solid red;margin-top:0; width:95%;');
                                    $(this).find('#section_title').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // show error message icon on current input field
                                } else {
                                    $(this).find('#section_title').css('border', 'margin-top:0; width:95%;');
                                    $(this).find('#section_title').parent().removeClass('error-custom').find('span').attr('style', 'display:none;'); // show error message icon on current input field
                                }
                            });
                        } else {
                            $('#' + question_class_id).removeClass('error-custom');
                            // validate section title
                            $.each(que_sec_class, function () {
                                if (!$(this).find('#section_title').val())
                                {
                                    $(this).find('#section_title').attr('style', 'border:1px solid red;margin-top:0; width:95%;');
                                    $(this).find('#section_title').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // show error message icon on current input field
                                } else {
                                    $(this).find('#section_title').css('border', 'margin-top:0; width:95%;');
                                    $(this).find('#section_title').parent().removeClass('error-custom').find('span').attr('style', 'display:none;'); // show error message icon on current input field
                                }
                            });
                            $('#' + question_class_id).find($(que_class)).each(function () {
                                var que_section = this.id;
                                // add question object
                                var question_id = que_section.split('_')[1];
                                var count = 0;
                                $(data_page).find($('#' + que_section)).each(function () {

                                    // setting max value for textbox  field
                                    var question_type = que_section.substr(0, que_section.indexOf('_')); // type of question to find its element


                                    var survey_question_detail = new Object();
                                    count = que_section.split('_')[1];
                                    if (survey_question_detail['que_type'] != 'richtextareabox') {
                                        var question = $('[name="question_' + que_section + '"]').val();
                                    }
                                    if (question && question.trim() != '') {
                                        $('[name="question_' + que_section + '"]').attr('style', ' max-width:80%;');
                                        $('[name="question_' + que_section + '"]').parent().removeClass('error-custom').find('span').attr('style', 'display:none;'); // error icon and red style to input
                                        $('[name="question_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                    } else if ($('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && $('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("uploadsImage")) {
                                        survey_question_detail['question'] = "uploadImage";
                                    } else if ($('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && $('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("imageURL")) {
                                        survey_question_detail['question'] = "imageURL";
                                        $('[name="question_' + que_section + '"]').parent().removeClass('error-custom').find('span').attr('style', 'display:none;');
                                        $('[name="question_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                    } else if (question_type == 'richtextareabox') {
                                        $('[name="question_' + que_section + '"]').attr('style', 'display:none; max-width:80%; height:20%; padding:4px; border-radius:3px;border:1px solid red; color:red;');
                                        $('[name="question_' + que_section + '"]').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // error icon and red style to input
                                        $('[name="question_' + que_section + '"]').parents('.question').find('.general').css('color', 'red');
                                    } else if (question_type != 'richtextareabox') {
                                        $('[name="question_' + que_section + '"]').attr('style', ' max-width:80%; height:20%; padding:4px; border-radius:3px;border:1px solid red; color:red;');
                                        $('[name="question_' + que_section + '"]').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // error icon and red style to input
                                        $('[name="question_' + que_section + '"]').parents('.question').find('.general').css('color', 'red');
                                    }
                                    if (question_type == 'doc-attachment') {
                                        var qSeq = count;
                                        var fileExtVal = $('[name="file_extension_' + que_section + '"]').val();
                                        $('[name="file_extension_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        $('[name="file_extension_' + que_section + '"]').parents('.question').find('#s2id_file_extension_' + qSeq).removeClass('error-custom');
                                        $('[name="file_extension_' + que_section + '"]').parents('.question').find('#s2id_file_extension_' + qSeq).css('border', '1px solid #ebedef');
                                        if (fileExtVal === '' || fileExtVal === null) {
                                            $('[name="file_extension_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                            $('[name="file_extension_' + que_section + '"]').parents('.question').find('#s2id_file_extension_' + qSeq).css('border', 'solid 1px red');
                                            $('[name="file_extension_' + que_section + '"]').parents('.question').find('#s2id_file_extension_' + qSeq).addClass('error-custom'); // error icon and red style to input
                                            $('[name="file_extension_' + que_section + '"]').parents('.question').find('span.requireSpanClass').attr('style', 'position: absolute;z-index:500;right: 7px;top: 5px;');
                                        }
                                    }

                                    //Get Piping Sync value for sync field
                                    if ($('[data-fieldname=enable_data_piping]').find('[type=checkbox]:checked').length != 0)
                                    {
                                        // Sync Field value
                                        var sync_field = $('[name="sync_field_' + que_section + '"]').val();

                                        // Disable Piping value
                                        var disable_piping = $('[name=disable_piping_' + que_section + ']').prop('checked');

                                        if (disable_piping != true && (!sync_field || sync_field == 'Select Field'))
                                        {
                                            $('[name="question_' + que_section + '"]').parents('.question').find('.piping').css('color', 'red');
                                            $('[name="sync_field_' + que_section + '"]').css('border', '1px solid red').addClass('error-custom');
                                            $('[name="sync_field_' + que_section + '"]').parent().find('span:not(.no_data)').show();
                                        } else {
                                            $('[name="question_' + que_section + '"]').parents('.question').find('.piping').css('color', '#747474');
                                            $('[name="sync_field_' + que_section + '"]').css('border', '').removeClass('error-custom');
                                            $('[name="sync_field_' + que_section + '"]').parent().find('span:not(.no_data)').hide();
                                            sync_field_obj[count] = sync_field;
                                        }
                                    } else {
                                        $('[name="question_' + que_section + '"]').parents('.question').find('.piping').css('color', '#747474');
                                        $('[name="sync_field_' + que_section + '"]').css('border', '').removeClass('error-custom');
                                        $('[name="sync_field_' + que_section + '"]').parent().find('span:not(.no_data)').hide();
                                    }

                                    //setting is required field
                                    var is_required = $('[name="is_required_' + que_section + '"]').prop('checked');

                                    if (sync_field && sync_field != 'Select Field' && self.sync_module_fields_is_required && self.sync_module_fields_is_required[sync_module] && self.sync_module_fields_is_required[sync_module][sync_field]['is_required'] && !is_required)
                                    {
                                        error_on_sync_req_missing = true;
                                        $('[name="question_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                        $('[name="is_required_' + que_section + '"]').addClass('error-custom').addClass('error-custom-requird').attr('style', 'border:1px solid red;');
                                    } else if (sync_field) {
                                        $('[name="question_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        $('[name="is_required_' + que_section + '"]').removeClass('error-custom').removeClass('error-custom-requird').attr('style', '');
                                    }

                                    // setting que-data type for textbox field
                                    var datatype = $('[name="datatype_' + que_section + '"]').val();
                                    var min = $('[name="min_' + que_section + '"]').val();
                                    var max = $('[name="max_' + que_section + '"]').val();
                                    if (datatype == 'Integer') {
                                        min = parseInt(min);
                                        max = parseInt(max);
                                    } else if (datatype == 'Float') {
                                        min = parseFloat(min);
                                        max = parseFloat(max);
                                    }
                                    if ((question_type == 'textbox' && (datatype == 'Integer' || datatype == 'Float')) && max != null && min != null && (min >= max)) {
                                        $('[name="max_' + que_section + '"]').addClass('error-custom');
                                        $('[name="max_' + que_section + '"]').css('border', '1px solid red');
                                        $('[name="max_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                        if ($('[name="max_' + que_section + '"]').parent().find('.error-minmax-msg').length == 0) {
                                            $('[name="max_' + que_section + '"]').parent().append('<div class="error-minmax-msg" style="color:red;font-size:11px;">You may have to set maximum value greater than minimum value</div>');
                                        }
                                    } else if ((question_type == 'textbox' && (datatype == 'Integer' || datatype == 'Float')) && max != null && min != null && (min < max)) {
                                        survey_question_detail['maxvalue'] = max;
                                        $('[name="max_' + que_section + '"]').removeClass('error-custom');
                                        $('[name="max_' + que_section + '"]').css('border', '');
                                        $('[name="max_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        if ($('[name="max_' + que_section + '"]').parent().find('.error-minmax-msg').length != 0) {
                                            $('[name="max_' + que_section + '"]').parent().find('.error-minmax-msg').remove();
                                        }
                                    }

                                    //validate start & end date
                                    var start_date = $('[name="startDate_' + que_section + '"]').val();
                                    var end_date = $('[name="endDate_' + que_section + '"]').val();
                                    if (start_date && end_date && app.date.compare(app.date(start_date), app.date(end_date)) >= 0) {
                                        $('[name="endDate_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                        $('[name="endDate_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                        if ($('[name="endDate_' + que_section + '"]').parent().find('.error-date-msg').length == 0) {
                                            $('[name="endDate_' + que_section + '"]').parent().append('<div class="error-date-msg" style="color:red;font-size:11px;">The date of this field must be after the date of Start Date Field</div>');
                                        }
                                    } else if (end_date) {
                                        survey_question_detail['end_date'] = end_date;
                                        $('[name="endDate_' + que_section + '"]').removeClass('error-custom').css('border', '');
                                        $('[name="endDate_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        if ($('[name="endDate_' + que_section + '"]').parent().find('.error-date-msg').length != 0) {
                                            $('[name="endDate_' + que_section + '"]').parent().find('.error-date-msg').remove();
                                        }
                                    }

                                    //setting start end & step values for slider
                                    var start = $('[name="start_' + que_section + '"]').val();
                                    var end = $('[name="end_' + que_section + '"]').val();
                                    var step = $('[name="step_' + que_section + '"]').val();
                                    if (!start) {
                                        $('[name="start_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                        $('[name="start_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                    } else {
                                        $('[name="start_' + que_section + '"]').removeClass('error-custom').css('border', '');
                                        $('[name="start_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                    }
                                    if (!end) {
                                        $('[name="end_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                        $('[name="end_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                    } else {
                                        $('[name="end_' + que_section + '"]').removeClass('error-custom').css('border', '');
                                        $('[name="end_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                    }
                                    if (!step) {
                                        $('[name="step_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                        $('[name="step_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                    } else {
                                        $('[name="step_' + que_section + '"]').removeClass('error-custom').css('border', '');
                                        $('[name="step_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                    }
                                    if (start && end) {
                                        start = parseInt(start);
                                        end = parseInt(end);
                                    }
                                    if (start != null && end != null && end > start) {
                                        survey_question_detail['end'] = end;
                                        $('[name="end_' + que_section + '"]').removeClass('error-custom').css('border', '');
                                        $('[name="end_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        if ($('[name="end_' + que_section + '"]').parent().find('.error-range-msg').length != 0) {
                                            $('[name="end_' + que_section + '"]').parent().find('.error-range-msg').remove();
                                        }
                                    }
                                    //validate start & end date value
                                    else if (start != null && end != null && end <= start) {
                                        $('[name="end_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                        $('[name="end_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                        if ($('[name="end_' + que_section + '"]').parent().find('.error-range-msg').length == 0) {
                                            $('[name="end_' + que_section + '"]').parent().append('<div class="error-range-msg" style="color:red;font-size:11px;">The End Value must be greate then Start Value</div>');
                                        }
                                    }
                                    //validate step value as per start & end value given
                                    if (start != null && end != null) {

                                        var allowed_step_value = end - start;
                                        allowed_step_value = parseInt(allowed_step_value);
                                        step = parseInt(step);
                                    }
                                    if (start != null && end != null && step != null && step <= allowed_step_value) {
                                        survey_question_detail['scale_slot'] = step;
                                        $('[name="step_' + que_section + '"]').removeClass('error-custom').css('border', '');
                                        $('[name="step_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        if ($('[name="step_' + que_section + '"]').parent().find('.error-step-msg').length != 0) {
                                            $('[name="step_' + que_section + '"]').parent().find('.error-step-msg').remove();
                                        }
                                    } else if (start != null && end != null && step != null && step > allowed_step_value && parseInt(end) > parseInt(start)) {
                                        $('[name="step_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                        $('[name="step_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                        $('[name="step_' + que_section + '"]').parent().find('.error-step-msg').remove();
                                        if ($('[name="step_' + que_section + '"]').parent().find('.error-step-msg').length == 0) {

                                            if (allowed_step_value == 1) {
                                                $('[name="step_' + que_section + '"]').parent().append('<div class="error-step-msg" style="color:red;font-size:11px;">You may have to set step value 1</div>');
                                            } else {
                                                $('[name="step_' + que_section + '"]').parent().append('<div class="error-step-msg" style="color:red;font-size:11px;">You may have to set step value less than ' + allowed_step_value + '</div>');
                                            }

                                        }
                                    }

                                    if ((parseInt(step) > 0) == true) {
                                    } else {

                                        $('[name="step_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                        $('[name="step_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                        if ($('[name="step_' + que_section + '"]').parent().find('.error-step-msg').length == 0) {
                                            $('[name="step_' + que_section + '"]').parent().append('<div class="error-step-msg" style="color:red;font-size:11px;">Please enter only numeric values(1-9)</div>');
                                        } else {
                                            $('[name="step_' + que_section + '"]').parent().find('.error-step-msg').html('Please enter only numeric values(1-9)');
                                        }

                                    }

                                    var question_type = que_section.substr(0, que_section.indexOf('_')); // type of question to find its element
                                    survey_question_detail['que_type'] = question_type;
                                    if (survey_question_detail['que_type'] == "image") {

                                        if ($('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && $('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("uploadsImage")) {
                                            var image = $('[name="uploadType_' + que_section + '"]').val();
                                            var uploadedImage = $('#' + que_section).find('.uploadedImage').attr('src');
                                            if (question_type == 'image' && image && image.trim()) {
                                                $('[name="uploadType_' + que_section + '"]').parent().removeClass('error-custom');
                                                $('[name="uploadType_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                                $('[name="uploadType_' + que_section + '"]').parent().find('span').attr('style', 'display:none;'); // error icon and red style to input
                                            } else if (!image && (!image && !uploadedImage)) {
                                                //Adding error msg class
                                                $('[name="uploadType_' + que_section + '"]').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // error icon and red style to input
                                                $('[name="uploadType_' + que_section + '"]').parents('.question').find('.general').css('color', 'red');
                                            }
                                        } else if ($('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && $('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("imageURL")) {
                                            var image = $('[name="urlType_' + que_section + '"]').val();
                                            if (question_type == 'image' && image && image.trim()) {
                                                $('[name="urlType_' + que_section + '"]').attr('style', 'margin-left: 1px; max-width: 80%; display: inline-block;');
                                                $('[name="urlType_' + que_section + '"]').removeClass('error-custom');
                                                $('[name="urlType_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                            } else if (!image && (!image.trim())) {
                                                //Adding error msg class
                                                $('[name="urlType_' + que_section + '"]').attr('style', 'margin-left: 1px; max-width: 80%; display: inline-block; border: 1px solid red;');
                                                $('[name="urlType_' + que_section + '"]').addClass('error-custom'); // error icon and red style to input
                                                $('[name="urlType_' + que_section + '"]').parents('.question').find('.general').css('color', 'red');
                                            }
                                        }
                                        // To add validation for Image Url for skip logic
                                        $('[name=helptips_' + que_section + ']').parents('.question').find('.advance').css('color', '#747474');
                                        $('[name=helptips_' + que_section + ']').removeClass('error-custom').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;');
                                        ;
                                        if ($('[name=helptips_' + que_section + ']').val() == '') {
                                            $('[name=helptips_' + que_section + ']').parents('.question').find('.advance').css('color', 'red');
                                            $('[name=helptips_' + que_section + ']').addClass('error-custom').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;border:1px solid red; color:red;'); // apply red color to input text and border;
                                        }
                                    }
                                    if (survey_question_detail['que_type'] == "video") {

                                        var video = $('[name="video-url_' + que_section + '"]').val();
                                        if (question_type == 'video' && video && video.trim() != '') {
                                            $('[name="video-url_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                            $('[name="video-url_' + que_section + '"]').attr('style', 'max-width:100%;margin-left:1px;')
                                            $('[name="video-url_' + que_section + '"]').removeClass('error-custom'); // error icon and red style to input remove
                                        } else if (question_type == 'video' && !video) {
                                            //Adding error msg class
                                            $('[name="video-url_' + que_section + '"]').parents('.question').find('.general').css('color', 'red');
                                            $('[name="video-url_' + que_section + '"]').attr('style', 'max-width:100%;margin-left:1px;border:1px solid red;')
                                            $('[name="video-url_' + que_section + '"]').addClass('error-custom'); // error icon and red style to input
                                        }
                                        // To add validation for Image Url for skip logic
                                        $('[name=helptips_' + que_section + ']').parents('.question').find('.advance').css('color', '#747474');
                                        $('[name=helptips_' + que_section + ']').removeClass('error-custom').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;');
                                        ;
                                        if ($('[name=helptips_' + que_section + ']').val() == '') {
                                            $('[name=helptips_' + que_section + ']').parents('.question').find('.advance').css('color', 'red');
                                            $('[name=helptips_' + que_section + ']').addClass('error-custom').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;border:1px solid red; color:red;'); // apply red color to input text and border;
                                        }
                                    }
                                    //setting is required field
                                    var is_required = $('[name="is_required_' + que_section + '"]').prop('checked');
                                    if (survey_question_detail['que_type'] == "contact-information" && is_required == true) {
                                        //setting required fields for contact information
                                        var requireFields = '';
                                        if ($('[name="Name_' + count + '"]').prop('checked')) {
                                            requireFields += 'Name ';
                                        }
                                        if ($('[name="Email_' + count + '"]').prop('checked')) {
                                            requireFields += 'Email ';
                                        }
                                        if ($('[name="Company_' + count + '"]').prop('checked')) {
                                            requireFields += 'Company ';
                                        }
                                        if ($('[name="Phone_' + count + '"]').prop('checked')) {
                                            requireFields += 'Phone ';
                                        }
                                        if ($('[name="Address_' + count + '"]').prop('checked')) {
                                            requireFields += 'Address ';
                                        }
                                        if ($('[name="Address2_' + count + '"]').prop('checked')) {
                                            requireFields += 'Address2 ';
                                        }
                                        if ($('[name="City_' + count + '"]').prop('checked')) {
                                            requireFields += 'City ';
                                        }
                                        if ($('[name="State_' + count + '"]').prop('checked')) {
                                            requireFields += 'State ';
                                        }
                                        if ($('[name="Zip_' + count + '"]').prop('checked')) {
                                            requireFields += 'Zip ';
                                        }
                                        if ($('[name="Country_' + count + '"]').prop('checked')) {
                                            requireFields += 'Country ';
                                        }

                                        if (question_type == 'contact-information' && requireFields) {

                                            $('[name="Name_' + count + '"]').parents('.requiredFields').removeClass('error-custom');
                                            $('[name="Name_' + count + '"]').parents('.question').find('.advance').css('color', '#747474');
                                            //remove validation msg
                                            if ($('[name="Name_' + count + '"]').parents('.requiredFields').find('.error-req-msg').length != 0) {
                                                $('[name="Name_' + count + '"]').parents('.requiredFields').find('.error-req-msg').remove();
                                            }
                                        } else if (question_type == 'contact-information' && !requireFields) {
                                            //set require validation message
                                            $('[name="Name_' + count + '"]').parents('.requiredFields').addClass('error-custom');
                                            $('[name="Name_' + count + '"]').parents('.question').find('.advance').css('color', 'red');
                                            if ($('[name="Name_' + count + '"]').parents('.requiredFields').find('.error-req-msg').length == 0) {
                                                $('[name="Name_' + count + '"]').parents('.requiredFields').find('.span11').append('<div class="error-req-msg" style="color:red;font-size:11px;">You may have to select atleast one field as required</div>');
                                            }
                                        }

                                    } else if (question_type == 'contact-information' && is_required == false) {
                                        $('[name="Name_' + count + '"]').parents('.requiredFields').removeClass('error-custom');
                                        $('[name="Name_' + count + '"]').parents('.question').find('.advance').css('color', '#747474');
                                    }
                                    if (question_type == 'matrix')
                                    {
                                        var rows_div = $('#matrix_row_div_' + question_id);
                                        var row_error_flag = 0;
                                        rows_div.each(function () {
                                            var rowid = this.id;
                                            var row_count = 0;
                                            $('#' + rowid).find($('[name="row_matrix"]')).each(function () {
                                                row_count++;
                                                if (this.value.trim() != '') {
                                                    $(this).parent().removeClass('error-custom');
                                                    $(this).parents('.question').find('.general').css('color', '#747474');
                                                    $(this).attr('style', ' margin-top: 5px;max-width:50%;');
                                                } else {
                                                    $(this).parent().addClass('error-custom');
                                                    $(this).parents('.question').find('.general').css('color', 'red');
                                                    $(this).attr('style', 'border:1px solid red; margin-top: 5px;max-width:50%;');
                                                    row_error_flag = 1;
                                                }

                                            });
                                        });
                                        //For Rows validation
                                        if (row_error_flag == 1) {
                                            if (rows_div.find('.error_msg').length == 0) {
                                                rows_div.prepend('<span class="error_msg" style="color:red;">You may have to fill all the rows.</span> ');
                                            } else {
                                                rows_div.find('.error_msg').attr('style', 'color:red;');
                                            }
                                            row_error_flag = 0;
                                        } else if (row_error_flag == 0) {
                                            if (rows_div.find('.error_msg').length != 0) {
                                                rows_div.find('.error_msg').remove();
                                            }
                                        }

                                        var col_error_flag = 0;
                                        var cols_div = $('#matrix_column_div_' + question_id);
                                        cols_div.each(function () {
                                            var colid = this.id;
                                            var col_count = 0;
                                            $('#' + colid).find($('[name="column_matrix"]')).each(function () {
                                                col_count++;
                                                if (this.value.trim() != '') {
                                                    $(this).parent().removeClass('error-custom');
                                                    $(this).parents('.question').find('.general').css('color', '#747474');
                                                    $(this).attr('style', ' margin-top: 5px;max-width:50%;');
                                                } else {
                                                    $(this).parent().addClass('error-custom');
                                                    $(this).parents('.question').find('.general').css('color', 'red');
                                                    $(this).attr('style', 'border:1px solid red; margin-top: 5px;max-width:50%;');
                                                    col_error_flag = 1;
                                                }

                                            });
                                        });
                                        //For Cols validation
                                        if (col_error_flag == 1) {
                                            if (cols_div.find('.error_msg').length == 0) {
                                                cols_div.prepend('<span class="error_msg" style="color:red;">You may have to fill all the columns.</span> ');
                                            } else {
                                                cols_div.find('.error_msg').attr('style', 'color:red;');
                                            }
                                            col_error_flag = 0;
                                        } else if (col_error_flag == 0) {
                                            if (cols_div.find('.error_msg').length != 0) {
                                                cols_div.find('.error_msg').remove();
                                            }
                                        }
                                    }
                                    var is_image_option = $('[name=is_image_option_' + survey_question_detail['que_type'] + '_' + count + ']:checked').length;
                                    var is_other_selected = $('[name=enable_otherOption_' + survey_question_detail['que_type'] + '_' + count + ']:checked').length;
                                    var options_div = $('#' + survey_question_detail['que_type'] + '_options_div_' + count);
                                    var error_flag = 0;
                                    options_div.each(function () {
                                        var opid = this.id;
                                        var op_count = 0;
                                        var null_option_count = 0;
                                        $('#' + opid).find($('[name="option_' + survey_question_detail['que_type'] + '"]')).each(function () {
                                            op_count++;
                                            if (survey_question_detail['que_type'] == "radio-button" || survey_question_detail['que_type'] == "check-box" || survey_question_detail['que_type'] == "emojis") {
                                                if (this.value.trim() != '') {
                                                    $(this).parent().removeClass('error-custom');
                                                    $(this).parents('.question').find('.general').css('color', '#747474');
                                                    $(this).attr('style', ' margin-top: 5px;max-width:50%;');
                                                } else {
                                                    $(this).parent().addClass('error-custom');
                                                    $(this).parents('.question').find('.general').css('color', 'red');
                                                    $(this).attr('style', 'border:1px solid red; margin-top: 5px;max-width:50%;');
                                                    error_flag = 1;
                                                }

                                                // Validate image
                                                if (is_image_option && $(this).parent('.options').find('.radioImageUpload').val() == '') {
                                                    $(this).parent('.options').find('.radioImageUpload').next('.spanRadioUploadError').show().find('i').attr('title', 'Error. This field is required.');
                                                    $(this).parent('.options').find('.radioImageUpload').addClass('error-custom');

                                                    if (is_other_selected && $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').val() == '') {
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').show().find('i').attr('title', 'Error. This field is required.');
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').addClass('error-custom');
                                                    } else if (is_other_selected && $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').find('i').attr('title') == 'Error. This field is required.') {
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').hide();
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').removeClass('error-custom');
                                                    }
                                                } else if (is_image_option && $(this).parent('.options').find('.radioImageUpload').next('.spanRadioUploadError').find('i').attr('title') == 'Error. This field is required.') {
                                                    $(this).parent('.options').find('.radioImageUpload').next('.spanRadioUploadError').hide();
                                                    $(this).parent('.options').find('.radioImageUpload').removeClass('error-custom');

                                                    if (is_other_selected && $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').val() == '') {
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').show().find('i').attr('title', 'Error. This field is required.');
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').addClass('error-custom');
                                                    } else if (is_other_selected && $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').find('i').attr('title') == 'Error. This field is required.') {
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').hide();
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').removeClass('error-custom');
                                                    }
                                                } else if (is_other_selected && is_image_option && $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').find('i').attr('title') == 'Error. This field is required.') {
                                                    if ($(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').val() == '') {
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').show().find('i').attr('title', 'Error. This field is required.');
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').addClass('error-custom');
                                                    } else if (is_other_selected && $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').find('i').attr('title') == 'Error. This field is required.') {
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').hide();
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').removeClass('error-custom');
                                                    }
                                                } else {
                                                    $(this).parent('.options').find('.radioImageUpload').removeClass('error-custom');
                                                    $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').removeClass('error-custom');
                                                }
                                            } else {
                                                if (this.value.trim() != '') {
                                                    $(this).parent().removeClass('error-custom');
                                                    $(this).parents('.question').find('.general').css('color', '#747474');
                                                    $(this).attr('style', ' margin-top: 5px;max-width:50%;');
                                                } else {
                                                    if (null_option_count == 0) {
                                                    }
                                                    null_option_count++;
                                                }
                                                //check null value
                                                if (null_option_count > 1) {
                                                    $(this).parent().addClass('error-custom');
                                                    $(this).attr('style', 'border:1px solid red; margin-top: 5px;max-width:50%;');
                                                    error_flag = 2;
                                                }
                                            }

                                        });
                                        // Save Skip Logic Options
                                        $('#' + opid).parents('.question').find('.skip_logic_options').find('.logicRow').each(function () {
                                            var sel_logic_act = $(this).find('.logic_actions').val();
                                            $(this).removeClass('error-custom');
                                            $(this).find('.error_msg').remove();
                                            switch (sel_logic_act) {
                                                case "redirect_to_page":
                                                    var val = $(this).find('.logic_action_targtes').find('.redirect_to_page_options').val();
                                                    if (!val || val == 'none') {
                                                        $(this).find('.logic_action_targtes').find('.redirect_to_page_options').addClass('error-custom');
                                                        $(this).find('.logic_action_targtes').find('.redirect_to_page_options').attr('style', 'border:1px solid red;');
                                                        $(this).find('.logic_action_targtes').parents('.question').find('.skip_logic').css('color', 'red');
                                                    } else {
                                                        $(this).find('.logic_action_targtes').find('.redirect_to_page_options').attr('style', '');
                                                        $(this).find('.logic_action_targtes').find('.redirect_to_page_options').removeClass('error-custom');
                                                        $(this).find('.logic_action_targtes').parents('.question').find('.skip_logic').css('color', '#747474');
                                                    }
                                                    break;
                                                case "redirect_to_url":
                                                    var val = $(this).find('.logic_action_targtes').find('.redirect_to_url_options').val();
                                                    if (val == '' || val == null) {
                                                        $(this).addClass('error-custom');
                                                        $(this).find('[name=redirect_to_url]').attr('style', 'border:1px solid red;margin-bottom:1px;');
                                                        $(this).find('[name=redirect_to_url]').parents('.question').find('.skip_logic').css('color', 'red');
                                                    } else {
                                                        $(this).find('[name=redirect_to_url]').attr('style', 'margin-bottom:1px;');
                                                        $(this).removeClass('error-custom');
                                                        $(this).find('[name=redirect_to_url]').parents('.question').find('.skip_logic').css('color', '#747474');
                                                    }
                                                    // validate URL Format
                                                    if (val)
                                                    {
                                                        var re = /((((ht|f)tps?:\/\/)[^\/\s]+\.[^\/\s]+\.[^\/\s]+)[\/\S*]?)/gi;
                                                        if (!re.test(val))
                                                        {
                                                            if ($(this).find('.error_msg').length == 0) {
                                                                $(this).find('.clearTd').append('<span class="error_msg" style="color:red; font-size:11px;">&nbsp; <i class="fa fa fa-exclamation-circle" style="color:red;">&nbsp;</i>Error. Invalid URL. <div class="btn btn-info"><i class="fa fa-info-circle" title="It should be in http://www.google.com format">&nbsp;</i></span> ');
                                                            }
                                                            $(this).addClass('error-custom');
                                                            $(this).find('[name=redirect_to_url]').attr('style', 'border:1px solid red;margin-bottom:1px;');
                                                            $(this).find('[name=redirect_to_url]').parents('.question').find('.skip_logic').css('color', 'red');
                                                        } else {
                                                            $(this).find('.clearTd').find('.error_msg').remove();
                                                            $(this).find('[name=redirect_to_url]').attr('style', 'margin-bottom:1px;');
                                                            $(this).removeClass('error-custom');
                                                            $(this).parent().removeClass('error').find('span').attr('style', 'display:none');
                                                            $(this).find('[name=redirect_to_url]').parents('.question').find('.skip_logic').css('color', '#747474');
                                                        }
                                                    }
                                                    break;
                                                case "show_hide_question":
                                                    var val = $(this).find('.logic_action_targtes').find('.show_hide_question').val();
                                                    if (val == '' || val == null) {
                                                        $(this).addClass('error-custom');
                                                        $(this).find('.logic_action_targtes').find('.ms-choice').attr('style', 'width: 300px;border:1px solid red;');
                                                        $(this).find('.logic_action_targtes').parents('.question').find('.skip_logic').css('color', 'red');
                                                    } else {
                                                        $(this).find('.logic_action_targtes').find('.ms-choice').attr('style', 'width: 300px;');
                                                        $(this).removeClass('error-custom');
                                                        $(this).find('.logic_action_targtes').parents('.question').find('.skip_logic').css('color', '#747474');
                                                    }
                                                    break;
                                            }
                                        });
                                        // End
                                    });
                                    //errors display
                                    if (error_flag == 1) {
                                        if (options_div.find('.error_msg').length == 0) {
                                            options_div.prepend('<span class="error_msg" style="color:red;font-size:11px;">You may have to fill all the options.</span> ');
                                        } else {
                                            options_div.find('.error_msg').attr('style', 'color:red;');
                                        }
                                        error_flag = 0;
                                    } else if (error_flag == 2) {
                                        if (options_div.find('.error_msg').length == 0) {
                                            options_div.prepend('<span class="error_msg" style="color:red; font-size:11px;">You may remain only one option as blank. Please fill out other options.</span> ');
                                        } else {
                                            options_div.find('.error_msg').attr('style', 'color:red;');
                                        }
                                        error_flag = 0;
                                    } else {
                                        options_div.find('.error_msg').attr('style', 'display:none;');
                                    }

                                });
                            });
                        }
                    });
                    var page_title = $('#' + id).find('#txt_page_title').val();
                    if (self.model.get('survey_type') != 'poll')
                    {
                        if (typeof page_title != "undefined" && page_title.trim() != "") {
                            $('#' + id).find('#txt_page_title').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;');
                            $('#' + id).find('#txt_page_title').parent().removeClass('error-custom').find('span').attr('style', 'display:none;'); // hide error message icon on current input field

                        } else if (typeof page_title != "undefined" && page_title.trim() == "") {
                            $('#' + id).find('#txt_page_title').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;border:1px solid red; color:red;'); // apply red color to input text and border
                            $('#' + id).find('#txt_page_title').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // show error message icon on current input field
                        }
                    }
                });
            });

            var is_require_missing = false;
            if ($('[data-fieldname=enable_data_piping]').find('[type=checkbox]:checked').length != 0 && self.sync_module_fields_is_required && self.sync_module_fields_is_required[sync_module])
            {
                $.each(self.sync_module_fields_is_required[sync_module], function (field, field_detail) {
                    if (field_detail['is_required'] == true)
                    {

                        if ($.inArray(field, sync_field_obj) == -1) {
                            is_require_missing = true;
                            if (module_required_fields) {
                                module_required_fields = module_required_fields + ', ' + field_detail['label'];
                            } else {
                                module_required_fields = field_detail['label'];
                            }
                        }

                    }
                });
                if (is_require_missing == false)
                {
                    $(document).find('div:first').removeClass('error-custom');
                }
            }
            if (!error_on_sync_req_missing)
            {
                $(document).find('div:first').removeClass('error-custom');
            }

            if (error_on_sync_req_missing)
            {
                $(document).find('div:first').addClass('error-custom');
                app.alert.show('is_req_msg', {
                    level: 'confirmation',
                    title: '',
                    messages: 'This is a required field, click "Confirm" to make these question(s) required',
                    onConfirm: function () {
                        $('.error-custom-requird').attr('checked', true);
                        $('.advance').attr('style', 'color:#747474');
                        App.alert.show('suc_req_msg', {
                            level: 'success',
                            messages: 'Question(s) changed as required successfully',
                            autoClose: true
                        });
                    },
                });

            }

            // check sync required fields are added to survey questions or not
            else if (is_require_missing)
            {
                $(document).find('div:first').addClass('error-custom');
                App.alert.show('msg', {
                    level: 'error',
                    messages: 'Mandatory fields are not included in the survey. Please add madatory fields from the selected module. Missing Mandatory Fields are : ' + module_required_fields,
                    autoClose: false
                });
            } else {
                // Disable the action buttons.
                var error_status = $(document).find($('.error-custom'));
                if (error_status.length == 0) {
                    if ($(document).find($('.error')).length == 0)
                    {
                        app.alert.dismiss('invalid-data');
                        app.alert.show('loading_detail_view', {level: 'process', title: 'Loading', autoclose: false});
                        this.restrictEdit = 'loading';
                        $('[name=edit_button]').addClass('disabled');
                    }
                    this.toggleButtons(false);
                    var allFields = this.getFields(this.module, this.model);
                    var fieldsToValidate = {};
                    for (var fieldKey in allFields) {
                        if (app.acl.hasAccessToModel('edit', this.model, fieldKey)) {
                            _.extend(fieldsToValidate, _.pick(allFields, fieldKey));
                        }
                    }
                    this.AlreadyfieldsToValidate = fieldsToValidate;
                    this.model.doValidate(fieldsToValidate, _.bind(this.validationComplete, this));
                } else {
                    $('.error-custom').find('input[type=text]').focus();
                }
            }
        }
    },
    _dispose: function () {
        //additional stuff before calling the core create _dispose goes here
        this._super('_dispose');
    }
})
