({
    /**
     * The file used to customize create action of survey 
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */

    extendsFrom: 'CreateView',
    saveButtonName: 'save_button',
    cancelButtonName: 'cancel_button',
    /**
     * @inheritdoc
     *
     * Wires up the save buttons.
     */
    delegateButtonEvents: function () {
        this.context.on('button:' + this.saveButtonName + ':click', this.save, this);
        this.context.on('button:' + this.cancelButtonName + ':click', this.cancel, this);
    },
    /**
     * Determine appropriate save action and execute it
     * Default to saveAndClose
     */
    save: function () {
        this.saveAndClose();
    },
    /**
     * Handle click on the cancel link
     */
    cancel: function () {
        this._super('cancel');
        delete localStorage['copyFromSurvey']; // delete local variable to re use in another survey
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
        localStorage['restrictEdit'] = false; // Set save button restriction as false
        var copiedFromModelId = localStorage['copiedFromModelId'];
        if (localStorage['prefill']) {
            var prefill = jQuery.parseJSON(localStorage['prefill']);
        }
        if (localStorage['prefill_type']) {
            var prefill_type = localStorage['prefill_type'];
        }
        if (copiedFromModelId != null && prefill != null)
        {
            options.context.attributes.model.attributes.name = prefill.name;
            options.context.attributes.model.attributes.description = prefill.description;
            options.context.attributes.model.attributes.start_date = prefill.start_date;
            options.context.attributes.model.attributes.end_date = prefill.end_date;
            options.context.attributes.model.attributes.survey_welcome_page = prefill.survey_welcome_page;
            options.context.attributes.model.attributes.enable_data_piping = prefill.enable_data_piping;
            options.context.attributes.model.attributes.sync_module = prefill.sync_module;
            options.context.attributes.model.attributes.sync_type = prefill.sync_type;
            options.context.attributes.model.attributes.survey_thanks_page = prefill.survey_thanks_page;
            options.context.attributes.model.attributes.survey_logo = prefill.survey_logo;
            options.context.attributes.model.attributes.survey_background_image = prefill.survey_background_image;
            options.context.attributes.model.attributes.redirect_url = prefill.redirect_url;
            options.context.attributes.model.attributes.allowed_resubmit_count = prefill.allowed_resubmit_count;
            options.context.attributes.model.attributes.is_progress = prefill.is_progress;
            options.context.attributes.model.attributes.enable_review_mail = prefill.enable_review_mail;
            options.context.attributes.model.attributes.review_mail_content = prefill.review_mail_content;
            options.context.attributes.model.attributes.footer_content = prefill.footer_content;
            options.context.attributes.model.attributes.recursive_email = prefill.recursive_email;
            options.context.attributes.model.attributes.resend_count = prefill.resend_count;
            options.context.attributes.model.attributes.resend_interval = prefill.resend_interval;
            options.context.attributes.model.attributes.enable_agreement = prefill.enable_agreement;
            options.context.attributes.model.attributes.is_required_agreement = prefill.is_required_agreement;
            options.context.attributes.model.attributes.agreement_content = prefill.agreement_content;

            $.each(this.$el.parents('.main-pane').next('.sidebar-content').find('[name=survey_theme]'), function () {
                if (this.value == localStorage['survey_theme']) {
                    this.checked = 'checked';
                }
            });

            options.context.attributes.copiedFromModelId = copiedFromModelId;
            options.context.attributes.prefill_type = prefill_type;

            localStorage['copyImageId'] = prefill.survey_logo;
            localStorage['copyBGImageId'] = prefill.survey_background_image;


            delete localStorage['prefill'];
            delete localStorage['prefill_type'];
            delete localStorage['survey_theme'];
        }
        var copiedFromModelPopupId = options.context.attributes.copiedFromModelPopupId;
        if (copiedFromModelId == null && copiedFromModelPopupId == null) {
            delete localStorage['survey_record_id'];
        }
        this.model.addValidationTask('footer_content', _.bind(this._doValidateRequiredFooter_content, this));

        //validate start-date end-date field
        this.model.addValidationTask('start_date', _.bind(this._doValidateStartDate, this));
        this.model.addValidationTask('end_date', _.bind(this._doValidateEndDate, this));
        this.model.addValidationTask('redirect_url', _.bind(this._doValidateRedirectUrl, this));


        // create poll view
        if (localStorage['isCreatePoll'])
        {
            options.context.attributes.IsPOll = true;
            options.context.attributes.IsCreatePoll = true;
            delete localStorage['isCreatePoll'];
        }
    },
    _render: function () {

        this._super('_render');
        var self = this;
        if (this.context.attributes.IsPOll)
        {
            self.$el.parents('.main-pane').find('[data-name=enable_data_piping]').parents('.panel_body').hide();
            self.$el.parents('.main-pane').find('.label-bc_survey').attr('data-original-title', 'Poll').html('Po');
            self.$el.parents('.main-pane').find('[data-panelname=LBL_RECORDVIEW_PANEL1]').find('.pull-left').html('Poll Question');
            self.$el.parents('.main-pane').find('[data-name=description]').css('display', 'none');
            self.$el.parents('.main-pane').find('[data-panelname=LBL_RECORDVIEW_PANEL2]').hide();
            self.$el.parents('.main-pane').find('[data-panelname=LBL_RECORDVIEW_PANEL3]').hide();
            self.$el.parents('.main-pane').find('[data-panelname=LBL_RECORDVIEW_PANEL4]').hide();
            $.each(self.$el.parents('.main-pane').find('.record-panel-header'), function () {
                $(this).removeClass('panel-inactive');
                $(this).addClass('panel-active');
                $(this).parent().find('.record-panel-content').removeClass('hide');
            });

        } else {
            self.$el.parents('.main-pane').find('[data-name="allow_redundant_answers"]').hide();
        }

        self.$el.parents('.main-pane').find('[data-name="survey_type"]').hide();

        var url = App.api.buildURL("bc_survey", "retrieve_all_module_field_required_status", "", {});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data)
                {
                    self.sync_module_fields_is_required = data;

                    if (self.model.get('name') && localStorage['copyFromSurvey'] && localStorage['copyImageId'] != "null" && localStorage['copyBGImageId'] != "null")
                    {

                        // Copy logo while creting duplicate survey.
                        var copyModuleID = localStorage['copiedFromModelId'];
                        //delete localStorage['copiedFromModelId'];
                        var copyImageId = localStorage['copyImageId'];
                        //delete localStorage['copyImageId'];
                        var copyFromModule = 'bc_survey';

                        var copyImagField = 'survey_logo';
                        if ((typeof copyModuleID !== 'undefined' && copyModuleID !== '') && (typeof copyImageId !== 'undefined' && copyImageId !== '')) {
                            if (self.$el.parents('.main-pane').find('[data-name=survey_logo]').find('.image_preview').find('img').length == 0)
                            {
                                self.$el.parents('.main-pane').find('[data-name=survey_logo]').find('.image_preview').append('<img src="' + App.api.serverUrl + '/' + copyFromModule + '/' + copyModuleID + '/file/' + copyImagField + '?format=sugar-html-json&platform=base&_hash=' + copyImageId + '" style="width: 96px; height: 60px;" />')
                                self.$el.parents('.main-pane').find('[data-name=survey_logo]').find('.image_preview').find('.fa-plus').remove();
                            } else {
                                self.$el.parents('.main-pane').find('[data-name=survey_logo]').find('.image_preview').find('img').attr('src', App.api.serverUrl + '/' + copyFromModule + '/' + copyModuleID + '/file/' + copyImagField + '?format=sugar-html-json&platform=base&_hash=' + copyImageId)
                            }
                            var lengthsurvey_logo_img_id = self.$el.parents('.main-pane').find('#survey_logo_img_id').length;
                            if (lengthsurvey_logo_img_id == 0) {
                                self.$el.parents('.main-pane').find('[data-name=survey_logo]').find('.image_preview').append('<input type="hidden" id="survey_logo_img_id" value="' + copyImageId + '">');
                            } else {
                                self.$el.parents('.main-pane').find('#survey_logo_img_id').val(copyImageId);
                            }
                        }

                        // copy background Image while duplicating survey. By NM.
                        var copyImageId = localStorage['copyBGImageId'];
                        //delete localStorage['copyBGImageId'];
                        var copyBGImagField = 'survey_background_image';
                        if ((typeof copyModuleID != 'undefined' && copyModuleID != '') && (typeof copyImageId != 'undefined' && copyImageId != '')) {
                            self.$el.parents('.main-pane').find('[data-name=survey_background_image]').find('.image_preview').find('img').attr('src', App.api.serverUrl + '/' + copyFromModule + '/' + copyModuleID + '/file/' + copyBGImagField + '?format=sugar-html-json&platform=base&_hash=' + copyImageId);
                            var lengthsurvey_logo_img_id = self.$el.parents('.main-pane').find('#survey_background_image_img_id').length;
                            if (lengthsurvey_logo_img_id == 0) {
                                self.$el.parents('.main-pane').find('[data-name=survey_background_image]').find('.image_preview').append('<input type="hidden" id="survey_background_image_img_id" value="' + copyImageId + '">');
                            } else {
                                self.$el.parents('.main-pane').find('#survey_background_image_img_id').val(copyImageId);
                            }
                        }
                        // delete localStorage['copyFromSurvey']; // delete local variable to re use in another survey
                    }
                }
            }
        });
    },
    render: function () {

        this._super('render');
        var self = this;
        if (self.model.get('name') && localStorage['copyFromSurvey'] && localStorage['copyImageId'] != "null" && localStorage['copyBGImageId'] != "null")
        {

            // Copy logo while creting duplicate survey.
            var copyModuleID = localStorage['copiedFromModelId'];
            //delete localStorage['copiedFromModelId'];
            var copyImageId = localStorage['copyImageId'];
            //delete localStorage['copyImageId'];
            var copyFromModule = 'bc_survey';

            var copyImagField = 'survey_logo';
            if ((typeof copyModuleID !== 'undefined' && copyModuleID !== '') && (typeof copyImageId !== 'undefined' && copyImageId !== '')) {
                if (self.$el.parents('.main-pane').find('[data-name=survey_logo]').find('.image_preview').find('img').length == 0)
                {
                    self.$el.parents('.main-pane').find('[data-name=survey_logo]').find('.image_preview').append('<img src="' + App.api.serverUrl + '/' + copyFromModule + '/' + copyModuleID + '/file/' + copyImagField + '?format=sugar-html-json&platform=base&_hash=' + copyImageId + '" style="width: 96px; height: 60px;" />')
                    self.$el.parents('.main-pane').find('[data-name=survey_logo]').find('.image_preview').find('.fa-plus').remove();
                } else {
                    self.$el.parents('.main-pane').find('[data-name=survey_logo]').find('.image_preview').find('img').attr('src', App.api.serverUrl + '/' + copyFromModule + '/' + copyModuleID + '/file/' + copyImagField + '?format=sugar-html-json&platform=base&_hash=' + copyImageId)
                }
                var lengthsurvey_logo_img_id = self.$el.parents('.main-pane').find('#survey_logo_img_id').length;
                if (lengthsurvey_logo_img_id == 0) {
                    self.$el.parents('.main-pane').find('[data-name=survey_logo]').find('.image_preview').append('<input type="hidden" id="survey_logo_img_id" value="' + copyImageId + '">');
                } else {
                    self.$el.parents('.main-pane').find('#survey_logo_img_id').val(copyImageId);
                }
            }

            // copy background Image while duplicating survey. By NM.
            var copyImageId = localStorage['copyBGImageId'];
            //delete localStorage['copyBGImageId'];
            var copyBGImagField = 'survey_background_image';
            if ((typeof copyModuleID != 'undefined' && copyModuleID != '') && (typeof copyImageId != 'undefined' && copyImageId != '')) {
                self.$el.parents('.main-pane').find('[data-name=survey_background_image]').find('.image_preview').find('img').attr('src', App.api.serverUrl + '/' + copyFromModule + '/' + copyModuleID + '/file/' + copyBGImagField + '?format=sugar-html-json&platform=base&_hash=' + copyImageId);
                var lengthsurvey_logo_img_id = self.$el.parents('.main-pane').find('#survey_background_image_img_id').length;
                if (lengthsurvey_logo_img_id == 0) {
                    self.$el.parents('.main-pane').find('[data-name=survey_background_image]').find('.image_preview').append('<input type="hidden" id="survey_background_image_img_id" value="' + copyImageId + '">');
                } else {
                    self.$el.parents('.main-pane').find('#survey_background_image_img_id').val(copyImageId);
                }
            }
            // delete localStorage['copyFromSurvey']; // delete local variable to re use in another survey
        }
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
        var redirectUrl = this.$el.parents('.main-pane').find('[name=redirect_url]').val();
        app.error.errorName2Keys['redirect_url_invalid'] = 'REDIRECT_URL_INVALID';

        var re = /((((ht|f)tps?:\/\/)[^\/\s]+\.[^\/\s]+\.[^\/\s]+)[\/\S*]?)/gi;
        if (redirectUrl && !re.test(redirectUrl))
        {
            errors['redirect_url'] = errors['redirect_url'] || {};
            errors['redirect_url'].redirect_url_invalid = true;
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
    /**
     * Save and close drawer
     */
    initiateSave: function (callback) {
        var self = this;
        delete localStorage['copyFromSurvey']; // delete local variable to re use in another survey
        var error_status = this.$el.parents('.main-pane').find('.error-custom');
        var error = this.$el.parents('.main-pane').find($('.error'));
        if (error_status.length == 0 && error.length == 0) {
            this.disableButtons();
        }
        async.waterfall([
            _.bind(this.validateSubpanelModelsWaterfall, this),
            _.bind(this.validateModelWaterfall, this),
            _.bind(this.createRecordWaterfall, this),
        ], _.bind(function (error) {
            this.enableButtons();
            if (error && error.status == 412 && !error.request.metadataRetry) {
                this.handleMetadataSyncError(error);
            } else if (!error && !this.disposed) {

                if (error_status.length == 0) {

                    var survey_id = this.model.id;
                    var survey_logo_imgID = self.$el.parents('.main-pane').find('#survey_logo_img_id').val();
                    self.survey_data['record_id'] = survey_id;
                    self.survey_data['survey_logo_imgID'] = survey_logo_imgID;

                    var survey_bg_imgID = self.$el.parents('.main-pane').find('#survey_background_image_img_id').val();
                    self.survey_data['survey_bg_imgID'] = survey_bg_imgID;

                    self.$el.parents('.main-pane').find('[name=save_view_button]').addClass('disabled');
                    self.$el.parents('.main-pane').find('[name=cancel_button]').addClass('disabled');

                    app.alert.show('loading_detail_view', {level: 'process', title: 'Please wait while survey is saving', autoclose: false});
                    // call api to save record via php
                    var url = App.api.buildURL("bc_survey", "save_survey");
                    App.api.call('create', url, {survey_data: JSON.stringify(self.survey_data)}, {
                        success: function (data) {
                            self.context.lastSaveAction = null;
                            callback();
                        },
                        complete: function () {
                            app.alert.dismiss('loading_detail_view');
                        }
                    });

                }
            }
        }, this));
    },
    validateSubpanelModelsWaterfall: function (callback) {
        this._super('validateSubpanelModelsWaterfall', [callback]);
    },
    validateModelWaterfall: function (callback) {
        this._super('validateModelWaterfall', [callback]);
    },
    createRecordWaterfall: function (callback) {
        this._super('createRecordWaterfall', [callback]);
    },
    /**save survey pages & default survey fileds after successfull validating
     * 
     * @returns {undefined}
     */
    saveAndClose: function () {
        // To save default value of review mail content if value is empty
        if (!this.model.attributes.review_mail_content)
        {
            this.model.attributes.review_mail_content = 'Thank you for taking time to reviewing and submitting the survey with your valuable views and opinions.<br><br> We’ve taken into account your concerns submitted with this survey.<br><br> This will help us serve you better in future! <br><br>Thank you once again for your time and efforts!<br><br>';
        }
        // ENd
        //save clicked then disable save button to avoid duplicate record save 
        // this.disableButtons();
        var isCreateFromSendSurvey = this.context.attributes.isCreateFromSendSurvey;
        var isCreateFromSendSurveyNew = this.context.attributes.isCreateFromSendSurveyNew;
        var survey_data = new Object();
        var self = this;

        var survey_theme = self.$el.parents('.main-pane').next().find('[name=survey_theme]:checked').val();
        var error_on_sync_req_missing = false;
        var sync_module = self.$el.parents('.main-pane').find('[name=sync_module]').val();
        //getting survey pages
        var survey_pages = new Object();
        var sync_field_obj = new Array();
        var error_on_sync_duplication = false;
        var error_on_sync_req_missing = false;

        // get module required fields
        var module_required_fields = '';

        self.$el.parents('.main-pane').find('.thumbnail').each(function () {
            // set page id
            var page_id = this.id;
            var page_seq = page_id.substr(page_id.indexOf("_") + 1);
            var question_seq = 0;
            var data_page = self.$el.parents('.main-pane').find('#data-' + page_id);
            self.$el.parents('.main-pane').find(data_page).each(function () {

                var page_detail = new Object();
                var survey_questions = new Object();

                var question_class_id = this.id; //data-page_id
                self.$el.parents('.main-pane').find('#' + question_class_id).each(function () {

                    var que_class = self.$el.parents('.main-pane').find('#' + question_class_id).find('.question');
                    var que_sec_class = self.$el.parents('.main-pane').find('#' + question_class_id).find('.question-section');
                    // check question exists or not
                    if (typeof que_class == "object" && que_class.length == 0) {
                        self.$el.parents('.main-pane').find('#' + question_class_id).addClass('error-custom');
                    }
                    // check question section exists or not
                    else if (typeof que_class == "object" && typeof que_sec_class == "object" && que_class.length == que_sec_class.length)
                    {
                        self.$el.parents('.main-pane').find('#' + question_class_id).addClass('error-custom');

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
                        self.$el.parents('.main-pane').find('#' + question_class_id).removeClass('error-custom');
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
                        var question_counter = 0;
                        self.$el.parents('.main-pane').find('#' + question_class_id).find($(que_class)).each(function () {
                            var que_section = this.id; //question div id
                            // add question object
                            question_seq = que_section.split('_')[1]; //question id

                            var survey_question_detail_main = [];
                            var count = 0;
                            // Question Sections
                            if ($(this).hasClass('question-section')) {
                                var survey_question_detail = new Object();

                                // Section Title
                                var section_title = $(this).find('#section_title').val();
                                survey_question_detail['question'] = section_title;
                                survey_question_detail['question_sequence'] = question_counter;
                                survey_question_detail['que_type'] = 'section-header';
                                survey_question_detail_main[question_counter] = survey_question_detail;
                            }
                            // Questions
                            else {
                                self.$el.parents('.main-pane').find(data_page).find('#' + que_section).each(function () {

                                    var survey_question_detail = new Object();
                                    var answer_detail_main = new Object();
                                    var answer_detail = new Object();
                                    count = que_section.split('_')[1];

                                    // setting que type field

                                    if (self.$el.parents('.main-pane').find('[name=question-type]').length != 0)
                                    {
                                        var question_type = self.$el.parents('.main-pane').find('[name=question-type]:checked').val();
                                        survey_question_detail['survey_type'] = 'poll';
                                        survey_question_detail['is_required'] = 'true';

                                    } else {
                                        var question_type = que_section.substr(0, que_section.indexOf('_'));
                                    }
                                    survey_question_detail['que_type'] = question_type;


                                    // Stored Rich text area record. By GSR
                                    var questionTypeValue = que_section.split('_')[0];
                                    if (questionTypeValue == "richtextareabox") {
                                        var richTextContent = self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').val();
                                        if (richTextContent) {
                                            self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').attr('style', ' max-width:80%;');
                                            self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').parent().removeClass('error-custom').find('span').attr('style', 'display:none;'); // error icon and red style to input
                                            self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                        }
                                    } else {
                                        var question = self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').val();

                                        if (typeof question != "undefined" && question.trim() != '') {
                                            survey_question_detail['question'] = question.trim();
                                            self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').attr('style', ' max-width:80%;');
                                            self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').parent().removeClass('error-custom').find('span').attr('style', 'display:none;'); // error icon and red style to input
                                            self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                        }
                                    }
                                    if (typeof richTextContent != "undefined" && richTextContent.trim() != '') {

                                        // Stored Rich text area record. By GSR
                                        if (richTextContent) {
                                            survey_question_detail['richTextContent'] = richTextContent.trim();
                                        }
                                        // End
                                    }

                                    if (typeof question != "undefined" && question.trim() != '') {
                                        survey_question_detail['question'] = question.trim();
                                    } else if (self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').length != 0 && self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("uploadsImage")) {
                                        survey_question_detail['question'] = "uploadImage";
                                    } else if (self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').length != 0 && self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("imageURL")) {
                                        survey_question_detail['question'] = "imageURL";
                                        self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').parent().removeClass('error-custom').find('span').attr('style', 'display:none;');
                                        self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                    } else if (typeof richTextContent != "undefined" && richTextContent.trim() == '' && survey_question_detail['que_type'] == 'richtextareabox') {
                                        $('[name="question_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                        $('[name="question_' + que_section + '"]').attr('style', 'display:none; max-width:80%; height:20%; padding:4px; border-radius:3px;border:1px solid red; color:red;');
                                        $('[name="question_' + que_section + '"]').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // error icon and red style to input
                                    } else if (survey_question_detail['que_type'] != 'richtextareabox') {
                                        self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                        self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').attr('style', ' max-width:80%; height:20%; padding:4px; border-radius:3px;border:1px solid red; color:red;');
                                        self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // error icon and red style to input
                                    }
                                    if (survey_question_detail['que_type'] == 'doc-attachment') {
                                        var qSeq = count;
                                        var fileExtVal = self.$el.parents('.main-pane').find('[name="file_extension_' + que_section + '"]').val();
                                        self.$el.parents('.main-pane').find('[name="file_extension_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        self.$el.parents('.main-pane').find('[name="file_extension_' + que_section + '"]').parents('.question').find('#s2id_file_extension_' + qSeq).removeClass('error-custom');
                                        self.$el.parents('.main-pane').find('[name="file_extension_' + que_section + '"]').parents('.question').find('#s2id_file_extension_' + qSeq).css('border', '1px solid #ebedef');
                                        if (fileExtVal === '' || fileExtVal === null) {
                                            self.$el.parents('.main-pane').find('[name="file_extension_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                            self.$el.parents('.main-pane').find('[name="file_extension_' + que_section + '"]').parents('.question').find('#s2id_file_extension_' + qSeq).css('border', 'solid 1px red');
                                            self.$el.parents('.main-pane').find('[name="file_extension_' + que_section + '"]').parents('.question').find('#s2id_file_extension_' + qSeq).addClass('error-custom'); // error icon and red style to input
                                            self.$el.parents('.main-pane').find('[name="file_extension_' + que_section + '"]').parents('.question').find('span.requireSpanClass').attr('style', 'position: absolute;z-index:500;right: 7px;top: 5px;');
                                        }
                                    }


                                    //Get Piping Sync value for sync field
                                    if (self.$el.parents('.main-pane').find('[data-fieldname=enable_data_piping]').find('[type=checkbox]:checked').length != 0)
                                    {
                                        // Sync Field value
                                        var sync_field = self.$el.parents('.main-pane').find('[name="sync_field_' + que_section + '"]').val();
                                        // Disable Piping value
                                        var disable_piping = self.$el.parents('.main-pane').find('[name=disable_piping_' + que_section + ']').prop('checked');
                                        survey_question_detail['disable_piping'] = disable_piping;


                                        if (disable_piping != true && (!sync_field || sync_field == 'Select Field'))
                                        {
                                            self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').parents('.question').find('.piping').css('color', 'red');
                                            self.$el.parents('.main-pane').find('[name="sync_field_' + que_section + '"]').css('border', '1px solid red').addClass('error-custom');
                                            self.$el.parents('.main-pane').find('[name="sync_field_' + que_section + '"]').parent().find('span:not(.no_data)').show();
                                        } else {
                                            self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').parents('.question').find('.piping').css('color', '#747474');
                                            self.$el.parents('.main-pane').find('[name="sync_field_' + que_section + '"]').css('border', '').removeClass('error-custom');
                                            self.$el.parents('.main-pane').find('[name="sync_field_' + que_section + '"]').parent().find('span:not(.no_data)').hide();
                                            sync_field_obj[count] = sync_field;
                                            survey_question_detail['sync_field'] = sync_field;

                                        }
                                    } else {
                                        self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').parents('.question').find('.piping').css('color', '#747474');
                                        self.$el.parents('.main-pane').find('[name="sync_field_' + que_section + '"]').css('border', '').removeClass('error-custom');
                                        self.$el.parents('.main-pane').find('[name="sync_field_' + que_section + '"]').parent().find('span:not(.no_data)').hide();
                                    }

                                    //getting score enable or not
                                    var enable_scoring = self.$el.parents('.main-pane').find('#' + que_section).find('.enableScore').find('input:checked').length;
                                    survey_question_detail['enable_scoring'] = enable_scoring;

                                    //Is image option enabled ?
                                    var is_image_option = self.$el.parents('.main-pane').find('#' + que_section).find('.isImageOption').find('input:checked').length;
                                    survey_question_detail['is_image_option'] = is_image_option;

                                    var imageURL = self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').val();

                                    if (imageURL && imageURL.trim() != '') {
                                        self.$el.parents('.main-pane').find('[name="urlType_image_' + que_section + '"]').parent().removeClass('error-custom').find('span').attr('style', 'display:none;'); // error icon and red style to input
                                    }
                                    // setting helptips field
                                    var helptips = self.$el.parents('.main-pane').find('[name="helptips_' + que_section + '"]').val();
                                    if (helptips) {
                                        helptips = helptips.trim();
                                    }
                                    survey_question_detail['helptips'] = helptips;

                                    // Add Display Label For Boolean Type
                                    var display_boolean_label = self.$el.parents('.main-pane').find('[name="display_label_' + que_section + '"]').val();
                                    if (typeof display_boolean_label != "undefined") {
                                        display_boolean_label = display_boolean_label.trim();
                                    }
                                    survey_question_detail['display_boolean_label'] = display_boolean_label;

                                    //setting is required field
                                    var is_required = self.$el.parents('.main-pane').find('[name="is_required_' + que_section + '"]').prop('checked');
                                    survey_question_detail['is_required'] = is_required;

                                    var is_question_seperator = self.$el.parents('.main-pane').find('[name="is_question_seperator_' + que_section + '"]').prop('checked');
                                    survey_question_detail['is_question_seperator'] = is_question_seperator;
                                    // Store File Size and File Extension
                                    var file_size = self.$el.parents('.main-pane').find('[name="file_size_' + que_section + '"]').val();
                                    survey_question_detail['file_size'] = file_size;
                                    var file_extension = self.$el.parents('.main-pane').find('[name="file_extension_' + que_section + '"]').val();
                                    survey_question_detail['file_extension'] = file_extension;

                                    var sync_module = self.$el.parents('.main-pane').find('[name=sync_module]').val();

                                    if (self.$el.parents('.main-pane').find('[data-fieldname=enable_data_piping]').find('[type=checkbox]:checked').length != 0 && sync_field && sync_field != 'Select Field' && self.sync_module_fields_is_required[sync_module][sync_field]['is_required'] && !is_required)
                                    {
                                        error_on_sync_req_missing = true;
                                        self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                        self.$el.parents('.main-pane').find('[name="is_required_' + que_section + '"]').addClass('error-custom').addClass('error-custom-requird').attr('style', 'border:1px solid red;');
                                    } else if (self.$el.parents('.main-pane').find('[data-fieldname=enable_data_piping]').find('[type=checkbox]:checked').length != 0 && sync_field) {
                                        self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        self.$el.parents('.main-pane').find('[name="is_required_' + que_section + '"]').removeClass('error-custom').removeClass('error-custom-requird').attr('style', '');
                                    }



                                    // setting que-data type for textbox field
                                    var datatype = self.$el.parents('.main-pane').find('[name="datatype_' + que_section + '"]').val();
                                    if (question_type == 'textbox' && datatype != null && datatype != "0") {
                                        survey_question_detail['datatype'] = datatype;
                                    }

                                    // setting max size for textbox & commentbox field
                                    var size = self.$el.parents('.main-pane').find('[name="size_' + que_section + '"]').val();
                                    if ((question_type == 'textbox' || question_type == 'commentbox') && size) {
                                        survey_question_detail['maxsize'] = size;
                                    }

                                    // setting min value for textbox  field
                                    var min = self.$el.parents('.main-pane').find('[name="min_' + que_section + '"]').val();
                                    if ((question_type == 'textbox' && (datatype == 'Integer' || datatype == 'Float')) && min) {
                                        survey_question_detail['minvalue'] = min;
                                    }

                                    // setting max value for textbox  field
                                    var max = self.$el.parents('.main-pane').find('[name="max_' + que_section + '"]').val();
                                    if (datatype == 'Integer') {
                                        min = parseInt(min);
                                        max = parseInt(max);
                                    } else if (datatype == 'Float') {
                                        min = parseFloat(min);
                                        max = parseFloat(max);
                                    }
                                    if ((question_type == 'textbox' && (datatype == 'Integer' || datatype == 'Float')) && max != null && min != null && (min >= max)) {
                                        self.$el.parents('.main-pane').find('[name="max_' + que_section + '"]').addClass('error-custom');
                                        self.$el.parents('.main-pane').find('[name="max_' + que_section + '"]').css('border', '1px solid red');
                                        self.$el.parents('.main-pane').find('[name="max_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                        if (self.$el.parents('.main-pane').find('[name="max_' + que_section + '"]').parent().find('.error-minmax-msg').length == 0) {
                                            self.$el.parents('.main-pane').find('[name="max_' + que_section + '"]').parent().append('<div class="error-minmax-msg" style="color:red;font-size:11px;">You may have to set maximum value greater than minimum value</div>');
                                        }
                                    } else if ((question_type == 'textbox' && (datatype == 'Integer' || datatype == 'Float')) && max != null && min != null && (min < max)) {
                                        survey_question_detail['maxvalue'] = max;
                                        self.$el.parents('.main-pane').find('[name="max_' + que_section + '"]').removeClass('error-custom');
                                        self.$el.parents('.main-pane').find('[name="max_' + que_section + '"]').css('border', '');
                                        self.$el.parents('.main-pane').find('[name="max_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        if (self.$el.parents('.main-pane').find('[name="max_' + que_section + '"]').parent().find('.error-minmax-msg').length != 0) {
                                            self.$el.parents('.main-pane').find('[name="max_' + que_section + '"]').parent().find('.error-minmax-msg').remove();
                                        }
                                    }

                                    // setting precision for textbox  field
                                    var precision = self.$el.parents('.main-pane').find('[name="precision_' + que_section + '"]').val();
                                    if ((question_type == 'textbox' && datatype == 'Float') && precision) {
                                        survey_question_detail['precision'] = precision;
                                    }

                                    // setting rows for commentbox field
                                    var rows = self.$el.parents('.main-pane').find('[name="rows_' + que_section + '"]').val();
                                    if (question_type == 'commentbox' && rows && rows.trim() != null) {
                                        survey_question_detail['rows'] = rows.trim();
                                    }

                                    // setting cols for commentbox field
                                    var cols = self.$el.parents('.main-pane').find('[name="cols_' + que_section + '"]').val();
                                    if (question_type == 'commentbox' && cols && cols.trim() != null) {
                                        survey_question_detail['cols'] = cols.trim();
                                    }

                                    //setting sorting for multichoice options
                                    var is_sort = self.$el.parents('.main-pane').find('[name="is_sort_' + que_section + '"]').prop('checked');
                                    if ((question_type == 'check-box' || question_type == 'radio-button' || question_type == 'dropdownlist' || question_type == 'multiselectlist') && typeof is_sort != 'undefined') {
                                        survey_question_detail['is_sort'] = is_sort;
                                    }

                                    //setting show option text for multichoice options
                                    if (question_type == 'radio-button') {
                                        var show_option_text = self.$el.parents('.main-pane').find('[name="show_option_text_' + que_section + '"]').prop('checked');
                                        if ((question_type == 'radio-button') && typeof show_option_text != 'undefined') {
                                            survey_question_detail['show_option_text'] = show_option_text;
                                        }
                                    }

                                    //setting limit answer for multichoice options
                                    var limit_min = self.$el.parents('.main-pane').find('[name="limit_min_' + que_section + '"]').val();
                                    if ((question_type == 'check-box' || question_type == 'multiselectlist') && typeof limit_min != 'undefined') {
                                        survey_question_detail['limit_min'] = limit_min;
                                    }

                                    //setting enable other option for multichoice options
                                    var enable_otherOption = self.$el.parents('.main-pane').find('[name="enable_otherOption_' + que_section + '"]').prop('checked');
                                    if ((question_type == 'check-box' || question_type == 'radio-button' || question_type == 'dropdownlist' || question_type == 'multiselectlist') && typeof enable_otherOption != 'undefined') {
                                        survey_question_detail['enable_otherOption'] = enable_otherOption;

                                        // Other option label
                                        var otherOptionLabel = self.$el.parents('.main-pane').find('[name="label_otherOption_' + que_section + '"]').val();
                                        if (otherOptionLabel && otherOptionLabel.trim() != null) {
                                            survey_question_detail['label_otherOption'] = otherOptionLabel.trim();
                                        }

                                        // Image Other option
                                        if (question_type == 'radio-button' && is_image_option) {
                                            if (self.$el.parents('.main-pane').find('[name="label_otherOption_' + que_section + '"]').parent().find('.spanRadioUploadError').find('.uploadedImage').attr('src')) {
                                                var radio_image = self.$el.parents('.main-pane').find('[name="label_otherOption_' + que_section + '"]').parent().find('.spanRadioUploadError').find('.uploadedImage').attr('src');
                                                survey_question_detail['other_image'] = radio_image;
                                            }
                                        }

                                        // Other option score
                                        var otherOptionScore = self.$el.parents('.main-pane').find('[name="option_score_' + que_section + '"]').val();
                                        if (otherOptionScore && otherOptionScore.trim() != null) {
                                            survey_question_detail['score_otherOption'] = otherOptionScore.trim();
                                        }

                                    }

                                    // setting display type for multichoice field
                                    var display = self.$el.parents('.main-pane').find('[name="display_' + que_section + '"]:checked').val();
                                    if ((question_type == 'check-box' || question_type == 'radio-button') && display) {
                                        survey_question_detail['display'] = display;
                                    }

                                    // setting star No for Rating field
                                    var star_no = self.$el.parents('.main-pane').find('[name="starNo_' + que_section + '"]').val();
                                    if (question_type == 'rating' && star_no) {
                                        survey_question_detail['star_no'] = star_no;
                                    }

                                    //setting required fields for contact information
                                    var requireFields = '';
                                    if (question_type == 'contact-information' && is_required == true) {
                                        if (self.$el.parents('.main-pane').find('[name="Name_' + count + '"]').prop('checked')) {
                                            requireFields += 'Name ';
                                        }
                                        if (self.$el.parents('.main-pane').find('[name="Email_' + count + '"]').prop('checked')) {
                                            requireFields += 'Email ';
                                        }
                                        if (self.$el.parents('.main-pane').find('[name="Company_' + count + '"]').prop('checked')) {
                                            requireFields += 'Company ';
                                        }
                                        if (self.$el.parents('.main-pane').find('[name="Phone_' + count + '"]').prop('checked')) {
                                            requireFields += 'Phone ';
                                        }
                                        if (self.$el.parents('.main-pane').find('[name="Address_' + count + '"]').prop('checked')) {
                                            requireFields += 'Address ';
                                        }
                                        if (self.$el.parents('.main-pane').find('[name="Address2_' + count + '"]').prop('checked')) {
                                            requireFields += 'Address2 ';
                                        }
                                        if (self.$el.parents('.main-pane').find('[name="City_' + count + '"]').prop('checked')) {
                                            requireFields += 'City ';
                                        }
                                        if (self.$el.parents('.main-pane').find('[name="State_' + count + '"]').prop('checked')) {
                                            requireFields += 'State ';
                                        }
                                        if (self.$el.parents('.main-pane').find('[name="Zip_' + count + '"]').prop('checked')) {
                                            requireFields += 'Zip ';
                                        }
                                        if (self.$el.parents('.main-pane').find('[name="Country_' + count + '"]').prop('checked')) {
                                            requireFields += 'Country ';
                                        }

                                        if (question_type == 'contact-information' && requireFields) {
                                            survey_question_detail['requireFields'] = requireFields;
                                            self.$el.parents('.main-pane').find('[name="Name_' + count + '"]').parents('.requiredFields').removeClass('error-custom');
                                            self.$el.parents('.main-pane').find('[name="Name_' + count + '"]').parents('.question').find('.advance').css('color', '#747474');
                                            //remove validation msg
                                            if (self.$el.parents('.main-pane').find('[name="Name_' + count + '"]').parents('.requiredFields').find('.error-req-msg').length != 0) {
                                                self.$el.parents('.main-pane').find('[name="Name_' + count + '"]').parents('.requiredFields').find('.error-req-msg').remove();
                                            }
                                        } else if (question_type == 'contact-information' && !requireFields) {
                                            //set require validation message
                                            self.$el.parents('.main-pane').find('[name="Name_' + count + '"]').parents('.requiredFields').addClass('error-custom');
                                            self.$el.parents('.main-pane').find('[name="Name_' + count + '"]').parents('.question').find('.advance').css('color', 'red');
                                            if (self.$el.parents('.main-pane').find('[name="Name_' + count + '"]').parents('.requiredFields').find('.error-req-msg').length == 0) {
                                                self.$el.parents('.main-pane').find('[name="Name_' + count + '"]').parents('.requiredFields').find('.span11').append('<div class="error-req-msg" style="color:red;font-size:11px;">You may have to select atleast one field as required</div>');
                                            }
                                        }
                                    } else if (question_type == 'contact-information' && is_required == false) {
                                        self.$el.parents('.main-pane').find('[name="Name_' + count + '"]').parents('.requiredFields').removeClass('error-custom');
                                        self.$el.parents('.main-pane').find('[name="Name_' + count + '"]').parents('.question').find('.advance').css('color', '#747474');
                                    }

                                    // setting isDateTime for DateTime field
                                    var is_datetime = self.$el.parents('.main-pane').find('[name="is_datetime_' + que_section + '"]').prop('checked');
                                    if (question_type == 'date-time' && is_datetime) {
                                        survey_question_detail['is_datetime'] = is_datetime;
                                    }

                                    // setting start date for DateTime field
                                    var start_date = self.$el.parents('.main-pane').find('[name="startDate_' + que_section + '"]').val();
                                    if (question_type == 'date-time' && start_date) {
                                        survey_question_detail['start_date'] = start_date;
                                    }

                                    // setting end date for DateTime field
                                    var end_date = self.$el.parents('.main-pane').find('[name="endDate_' + que_section + '"]').val();

                                    //validate start & end date
                                    if (start_date && end_date && app.date.compare(app.date(start_date), app.date(end_date)) >= 0) {
                                        self.$el.parents('.main-pane').find('[name="endDate_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                        self.$el.parents('.main-pane').find('[name="endDate_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                        if (self.$el.parents('.main-pane').find('[name="endDate_' + que_section + '"]').parent().find('.error-date-msg').length == 0) {
                                            self.$el.parents('.main-pane').find('[name="endDate_' + que_section + '"]').parent().append('<div class="error-date-msg" style="color:red;font-size:11px;">The date of this field must be after the date of Start Date Field</div>');
                                        }
                                    } else if (end_date) {
                                        survey_question_detail['end_date'] = end_date;
                                        self.$el.parents('.main-pane').find('[name="endDate_' + que_section + '"]').removeClass('error-custom').css('border', '');
                                        self.$el.parents('.main-pane').find('[name="endDate_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        if (self.$el.parents('.main-pane').find('[name="endDate_' + que_section + '"]').parent().find('.error-date-msg').length != 0) {
                                            self.$el.parents('.main-pane').find('[name="endDate_' + que_section + '"]').parent().find('.error-date-msg').remove();
                                        }
                                    }

                                    // Store Question Seperator 
                                    var allow_future_dates = self.$el.parents('.main-pane').find('[name="allow_future_dates_' + que_section + '"]').prop('checked');
                                    survey_question_detail['allow_future_dates'] = allow_future_dates;


                                    // setting image for Image field
                                    if (question_type == 'image') {
                                        if (self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("uploadsImage")) {

                                            if (typeof self.image_content == "Object" && typeof self.image_content[count] != "undefined" && self.image_content[count] != '') {
                                                var image = self.image_content[count];
                                            } else {
                                                var image = '';
                                            }
                                            var uploadedImage = self.$el.parents('.main-pane').find('#' + que_section).find('.uploadedImage').attr('src');
                                            if (question_type == 'image' && ((image && image.trim()) || uploadedImage != '')) {
                                                if (uploadedImage) {
                                                    survey_question_detail['image'] = uploadedImage;
                                                    self.$el.parents('.main-pane').find('[name="uploadType_' + que_section + '"]').parent().removeClass('error-custom');
                                                    self.$el.parents('.main-pane').find('[name="uploadType_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                                    self.$el.parents('.main-pane').find('[name="uploadType_' + que_section + '"]').parent().find('span').attr('style', 'display:none;');
                                                } else if (image && image.trim()) {
                                                    survey_question_detail['image'] = image.trim();
                                                    self.$el.parents('.main-pane').find('[name="uploadType_' + que_section + '"]').parent().removeClass('error-custom');
                                                    self.$el.parents('.main-pane').find('[name="uploadType_' + que_section + '"]').parents('.question').find('.general').css('color', 'red');
                                                    self.$el.parents('.main-pane').find('[name="uploadType_' + que_section + '"]').parent().find('span').attr('style', 'display:none;');
                                                } else {
                                                    //Adding error msg class
                                                    self.$el.parents('.main-pane').find('[name="uploadType_' + que_section + '"]').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // error icon and red style to input 
                                                    self.$el.parents('.main-pane').find('[name="uploadType_' + que_section + '"]').parents('.question').find('.general').css('color', 'red');
                                                }
                                                // error icon and red style to input
                                            } else if (survey_question_detail['question'] == 'uploadImage' && !image && (!image.trim())) {
                                                //Adding error msg class
                                                self.$el.parents('.main-pane').find('[name="uploadType_' + que_section + '"]').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // error icon and red style to input
                                                self.$el.parents('.main-pane').find('[name="uploadType_' + que_section + '"]').parents('.question').find('.general').css('color', 'red');
                                            }
                                        } else if (self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("imageURL")) {
                                            var image = self.$el.parents('.main-pane').find('[name="urlType_' + que_section + '"]').val();

                                            if (question_type == 'image' && image && (image.trim())) {

                                                survey_question_detail['image'] = image.trim();
                                                self.$el.parents('.main-pane').find('[name="urlType_' + que_section + '"]').attr('style', 'margin-left: 1px; max-width: 80%; display: inline-block;');
                                                self.$el.parents('.main-pane').find('[name="urlType_' + que_section + '"]').removeClass('error-custom'); // error icon and red style to input
                                                self.$el.parents('.main-pane').find('[name="urlType_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                            } else if (survey_question_detail['question'] == 'imageURL' && !image && (!image.trim())) {
                                                //Adding error msg class
                                                self.$el.parents('.main-pane').find('[name="urlType_' + que_section + '"]').attr('style', 'margin-left: 1px; max-width: 80%; display: inline-block;border:1px solid red;');
                                                self.$el.parents('.main-pane').find('[name="urlType_' + que_section + '"]').addClass('error-custom'); // error icon and red style to input
                                                self.$el.parents('.main-pane').find('[name="urlType_' + que_section + '"]').parents('.question').find('.general').css('color', 'red');
                                            }
                                        }
                                        // To add validation for Image Url for skip logic
                                        self.$el.parents('.main-pane').find('[name=helptips_' + que_section + ']').parents('.question').find('.advance').css('color', '#747474');
                                        self.$el.parents('.main-pane').find('[name=helptips_' + que_section + ']').removeClass('error-custom').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;');
                                        ;
                                        if (self.$el.parents('.main-pane').find('[name=helptips_' + que_section + ']').val() == '') {
                                            self.$el.parents('.main-pane').find('[name=helptips_' + que_section + ']').parents('.question').find('.advance').css('color', 'red');
                                            self.$el.parents('.main-pane').find('[name=helptips_' + que_section + ']').addClass('error-custom').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;border:1px solid red; color:red;'); // apply red color to input text and border;
                                        }
                                    }
                                    if (question_type == 'video') {
                                        var video = self.$el.parents('.main-pane').find('[name="video-url_' + que_section + '"]').val();
                                        if (question_type == 'video' && video && video.trim() != '') {
                                            survey_question_detail['video'] = video.trim();
                                            self.$el.parents('.main-pane').find('[name="video-url_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                            self.$el.parents('.main-pane').find('[name="video-url_' + que_section + '"]').attr('style', 'max-width:100%;margin-left:1px;');
                                            self.$el.parents('.main-pane').find('[name="video-url_' + que_section + '"]').removeClass('error-custom'); // error icon and red style to input
                                        } else if (question_type == 'video' && !video) {
                                            //Adding error msg class
                                            self.$el.parents('.main-pane').find('[name="video-url_' + que_section + '"]').parents('.question').find('.general').css('color', 'red');
                                            self.$el.parents('.main-pane').find('[name="video-url_' + que_section + '"]').attr('style', 'max-width:100%;margin-left:1px;border:1px solid red;');
                                            self.$el.parents('.main-pane').find('[name="video-url_' + que_section + '"]').addClass('error-custom'); // error icon and red style to input
                                        }


                                        var description = self.$el.parents('.main-pane').find('[name="description_' + que_section + '"]').val();
                                        if (question_type == 'video' && description && description.trim() != '') {
                                            survey_question_detail['description'] = description.trim();
                                        }
                                        // To add validation for Image Url for skip logic
                                        self.$el.parents('.main-pane').find('[name=helptips_' + que_section + ']').parents('.question').find('.advance').css('color', '#747474');
                                        self.$el.parents('.main-pane').find('[name=helptips_' + que_section + ']').removeClass('error-custom').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;');
                                        if (self.$el.parents('.main-pane').find('[name=helptips_' + que_section + ']').val() == '') {
                                            self.$el.parents('.main-pane').find('[name=helptips_' + que_section + ']').parents('.question').find('.advance').css('color', 'red');
                                            self.$el.parents('.main-pane').find('[name=helptips_' + que_section + ']').addClass('error-custom').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;border:1px solid red; color:red;'); // apply red color to input text and border;
                                        }
                                    }
                                    if (question_type == 'scale') {
                                        //setting display label for slider
                                        var left = self.$el.parents('.main-pane').find('[name="left_' + que_section + '"]').val();
                                        var middle = self.$el.parents('.main-pane').find('[name="middle_' + que_section + '"]').val();
                                        var right = self.$el.parents('.main-pane').find('[name="right_' + que_section + '"]').val();
                                        if (!start) {
                                            self.$el.parents('.main-pane').find('[name="start_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                            self.$el.parents('.main-pane').find('[name="start_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                        } else {
                                            self.$el.parents('.main-pane').find('[name="start_' + que_section + '"]').removeClass('error-custom').css('border', '');
                                            self.$el.parents('.main-pane').find('[name="start_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        }
                                        if (!end) {
                                            self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                            self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                        } else {
                                            self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').removeClass('error-custom').css('border', '');
                                            self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        }
                                        if (!step) {
                                            self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                            self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                        } else {
                                            self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').removeClass('error-custom').css('border', '');
                                            self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        }
                                        if (left && left.trim() != null && middle && middle.trim() != null && right && right.trim() != null) {
                                            survey_question_detail['label'] = left.trim() + '-' + middle.trim() + '-' + right.trim();
                                        }
                                        //setting start end & step values for slider
                                        var start = self.$el.parents('.main-pane').find('[name="start_' + que_section + '"]').val();
                                        var end = self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').val();
                                        var step = self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').val();
                                        if (!start) {
                                            self.$el.parents('.main-pane').find('[name="start_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                            self.$el.parents('.main-pane').find('[name="start_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                        } else {
                                            self.$el.parents('.main-pane').find('[name="start_' + que_section + '"]').removeClass('error-custom').css('border', '');
                                            self.$el.parents('.main-pane').find('[name="start_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        }
                                        if (!end) {
                                            self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                            self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                        } else {
                                            self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').removeClass('error-custom').css('border', '');
                                            self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        }
                                        if (!step) {
                                            self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                            self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                        } else {
                                            self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').removeClass('error-custom').css('border', '');
                                            self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                        }
                                        if (start) {
                                            start = parseInt(start);
                                            end = parseInt(end);
                                            survey_question_detail['start'] = start;
                                        }
                                        if (start != null && end != null && end > start) {
                                            survey_question_detail['end'] = end;
                                            self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').removeClass('error-custom').css('border', '');
                                            self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                            if (self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').parent().find('.error-range-msg').length != 0) {
                                                self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').parent().find('.error-range-msg').remove();
                                            }
                                        }
                                        //validate start & end date value
                                        else if (start != null && end != null && end <= start) {
                                            self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                            self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                            if (self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').parent().find('.error-range-msg').length == 0) {
                                                self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').parent().append('<div class="error-range-msg" style="color:red;font-size:11px;">The End Value must be greate then Start Value</div>');
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
                                            self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').removeClass('error-custom').css('border', '');
                                            self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parents('.question').find('.advance').css('color', '#747474');
                                            if (self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parent().find('.error-step-msg').length != 0) {
                                                self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parent().find('.error-step-msg').remove();
                                            }
                                        } else if (start != null && end != null && step != null && step > allowed_step_value && parseInt(end) > parseInt(start)) {
                                            self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                            self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                            if (self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parent().find('.error-step-msg').length == 0) {
                                                if (allowed_step_value == 1) {
                                                    self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parent().append('<div class="error-step-msg" style="color:red;font-size:11px;">You may have to set step value 1.</div>');
                                                } else {
                                                    self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parent().append('<div class="error-step-msg" style="color:red;font-size:11px;">You may have to set step value less than ' + allowed_step_value + '</div>');
                                                }
                                            }
                                        } else {
                                            if (allowed_step_value == 1) {
                                                self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parent().find('.error-step-msg').html('You may have to set step value 1.');
                                            } else {
                                                self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parent().find('.error-step-msg').html('You may have to set step value less than ' + allowed_step_value);
                                            }
                                        }

                                        if ((parseInt(step) > 0) === true) {
                                        } else {

                                            self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                            self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                            if (self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parent().find('.error-step-msg').length == 0) {
                                                self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parent().append('<div class="error-step-msg" style="color:red;font-size:11px;">Please enter only numeric values(1-9)</div>');
                                            } else {
                                                self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').parent().find('.error-step-msg').html('Please enter only numeric values(1-9)');
                                            }

                                        }
                                    }
                                    if (question_type == 'netpromoterscore') {

                                        var left = self.$el.parents('.main-pane').find('[name="left_' + que_section + '"]').val();
                                        var right = self.$el.parents('.main-pane').find('[name="right_' + que_section + '"]').val();
                                        if (left && left.trim() != null && right && right.trim() != null) {
                                            survey_question_detail['label_netpromoterscore'] = left.trim() + '-' + right.trim();
                                        }
                                    }

                                    if (question_type == 'matrix') {
                                        // setting display type for matrix
                                        var display_type = self.$el.parents('.main-pane').find('[name="display_type_' + que_section + '"]:checked').val();
                                        if (typeof display_type != 'undefined' && display_type.trim() != null) {
                                            survey_question_detail['display_type'] = display_type.trim();
                                        }
                                        // setting rows & columns for a matrix type
                                        answer_detail.rows = new Object();
                                        var row_error_flag = 0;
                                        var rows_div = self.$el.parents('.main-pane').find('#matrix_row_div_' + question_seq);
                                        rows_div.each(function () {
                                            var rowid = this.id;
                                            var row_count = 0;

                                            self.$el.parents('.main-pane').find('#' + rowid).find($('[name="row_matrix"]')).each(function () {
                                                row_count++;
                                                if (this.value.trim() != '') {
                                                    $(this).parent().removeClass('error-custom');
                                                    $(this).parents('.question').find('.general').css('color', '#747474');
                                                    $(this).attr('style', ' margin-top: 5px;max-width:50%;');

                                                    answer_detail['rows'][row_count] = this.value.trim();
                                                } else {
                                                    $(this).parent().addClass('error-custom');
                                                    $(this).parents('.question').find('.general').css('color', 'red');
                                                    $(this).attr('style', 'border:1px solid red; margin-top: 5px;max-width:50%;');
                                                    row_error_flag = 1;
                                                }

                                            });
                                            survey_question_detail['rows'] = answer_detail['rows'];
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
                                        answer_detail.cols = new Object();
                                        var col_error_flag = 0;
                                        var cols_div = self.$el.parents('.main-pane').find('#matrix_column_div_' + question_seq);
                                        cols_div.each(function () {
                                            var colid = this.id;
                                            var col_count = 0;

                                            self.$el.parents('.main-pane').find('#' + colid).find($('[name="column_matrix"]')).each(function () {
                                                col_count++;
                                                if (this.value.trim() != '') {
                                                    $(this).parent().removeClass('error-custom');
                                                    $(this).parents('.question').find('.general').css('color', '#747474');
                                                    $(this).attr('style', 'margin-top: 5px;max-width:50%;');

                                                    answer_detail['cols'][col_count] = this.value.trim();
                                                } else {
                                                    $(this).parent().addClass('error-custom');
                                                    $(this).parents('.question').find('.general').css('color', 'red');
                                                    $(this).attr('style', 'border:1px solid red; margin-top: 5px;max-width:50%;');
                                                    col_error_flag = 1;
                                                }

                                            });
                                            survey_question_detail['cols'] = answer_detail['cols'];
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

                                    survey_question_detail['question_sequence'] = question_seq;
                                    var is_other_selected = $('[name=enable_otherOption_' + survey_question_detail['que_type'] + '_' + count + ']:checked').length;

                                    var options_div = self.$el.parents('.main-pane').find('#' + survey_question_detail['que_type'] + '_options_div_' + count);
                                    if (options_div.length == 0 && (self.model.get('survye_type') == 'poll' || self.context.attributes.IsPOll))
                                    {
                                        var old_question_type = que_section.substr(0, que_section.indexOf('_'));
                                        var options_div = self.$el.parents('.main-pane').find('#' + old_question_type + '_options_div_' + count);
                                    }
                                    var error_flag = 0;
                                    options_div.each(function () {

                                        var opid = this.id;
                                        var new_option_id = 0;

                                        var op_count = 0;
                                        var option_id = 0;

                                        var null_option_count = 0;
                                        if (old_question_type)
                                        {
                                            self.$el.parents('.main-pane').find('#' + opid).find($('[name="option_' + old_question_type + '"]')).each(function () {

                                                var answer_detail = new Object();

                                                option_id = this.id;
                                                if (option_id != '') // Existing option editing
                                                { // check for radio button and checkbox dont allow null options
                                                    if (survey_question_detail['que_type'] == "radio-button" || survey_question_detail['que_type'] == "check-box") {
                                                        if (this.value.trim() != '') {
                                                            answer_detail[this.id] = new Object();
                                                            answer_detail[this.id]['option'] = this.value.trim();
                                                            answer_detail_main[this.id] = answer_detail[this.id];

                                                        }
                                                    }
                                                } else  //New option added while edit
                                                { // check for radio button and checkbox dont allow null options

                                                    //  }
                                                    // End
                                                    if (survey_question_detail['que_type'] == "radio-button" || survey_question_detail['que_type'] == "check-box") {
                                                        if (this.value.trim() != '') {
                                                            answer_detail['option_' + new_option_id] = new Object();
                                                            answer_detail['option_' + new_option_id]['option'] = this.value.trim();


                                                            if (is_image_option) {
                                                                var op_seq = $(this).parents('.options').attr('id').split('option_')[1];
                                                                if ($(this).parent().find('.spanRadioUploadError').find('.uploadedImage').attr('src')) {
                                                                    var radio_image = $(this).parent().find('.spanRadioUploadError').find('.uploadedImage').attr('src');
                                                                    answer_detail['option_' + new_option_id]['radio_image'] = radio_image;
                                                                } else if ($(this).parent().find('.resetImageRadioUpload').prev('img').attr('src')) {
                                                                    var radio_image = $(this).parent().find('.resetImageRadioUpload').prev('img').attr('src');
                                                                    answer_detail['option_' + new_option_id]['radio_image'] = radio_image;
                                                                }
                                                            }
                                                            answer_detail_main['option_' + new_option_id] = answer_detail['option_' + new_option_id];

                                                            new_option_id++;
                                                        }
                                                    }
                                                }

                                                survey_question_detail['answers'] = answer_detail_main;
                                            });
                                        } else {
                                            self.$el.parents('.main-pane').find('#' + opid).find($('[name="option_' + survey_question_detail['que_type'] + '"]')).each(function () {
                                                op_count++;
                                                if ($(this).parents('.options').find('.score_weight').val())
                                                {
                                                    var weight = $(this).parents('.options').find('.score_weight').val();
                                                } else {
                                                    var weight = 0;
                                                }
                                                if (survey_question_detail['que_type'] == "radio-button" || survey_question_detail['que_type'] == "check-box") {
                                                    if (this.value.trim() != '') {
                                                        $(this).parent().removeClass('error-custom');
                                                        $(this).attr('style', ' margin-top: 5px;max-width:50%;');
                                                        answer_detail[op_count] = new Object();
                                                        answer_detail[op_count]['option'] = this.value.trim();


                                                        if (is_image_option) {
                                                            var op_seq = $(this).parents('.options').attr('id').split('option_')[1];
                                                            if ($(this).parent().find('.spanRadioUploadError').find('.uploadedImage').attr('src')) {
                                                                var radio_image = $(this).parent().find('.spanRadioUploadError').find('.uploadedImage').attr('src');
                                                                answer_detail[op_count]['radio_image'] = radio_image;
                                                            } else if ($(this).parent().find('.resetImageRadioUpload').prev('img').attr('src')) {
                                                                var radio_image = $(this).parent().find('.resetImageRadioUpload').prev('img').attr('src');
                                                                answer_detail[op_count]['radio_image'] = radio_image;
                                                            }
                                                        }

                                                        if (enable_scoring == 1) {
                                                            answer_detail[op_count]['weight'] = weight;
                                                        }

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
                                                    if (this.value.trim()) {
                                                        $(this).parent().removeClass('error-custom');
                                                        $(this).parents('.question').find('.general').css('color', '#747474');
                                                        $(this).attr('style', ' margin-top: 5px;max-width:50%;');
                                                        answer_detail[op_count] = new Object();
                                                        answer_detail[op_count]['option'] = this.value.trim();


                                                        if (is_image_option) {
                                                            var op_seq = $(this).parents('.options').attr('id').split('option_')[1];
                                                            if (typeof self.radio_image_content == "object" && typeof self.radio_image_content[count] != "undefined" && self.radio_image_content[count] != '' && typeof self.radio_image_content[count][op_seq] != "undefined" && self.radio_image_content[count][op_seq] != '') {
                                                                var radio_image = self.radio_image_content[count][op_seq];
                                                                answer_detail[op_count]['radio_image'] = radio_image;
                                                            } else if ($(this).parent().find('.resetImageRadioUpload').prev('img').attr('src')) {
                                                                var radio_image = $(this).parent().find('.resetImageRadioUpload').prev('img').attr('src');
                                                                answer_detail[op_count]['radio_image'] = radio_image;
                                                            }
                                                        }

                                                        if (enable_scoring == 1) {
                                                            answer_detail[op_count]['weight'] = weight;
                                                        }


                                                    } else {
                                                        $(this).attr('style', ' margin-top: 5px;max-width:50%;');
                                                        if (null_option_count == 0) {
                                                            answer_detail[op_count] = new Object();
                                                            answer_detail[op_count]['option'] = this.value.trim();


                                                            if (is_image_option) {
                                                                var op_seq = $(this).parents('.options').attr('id').split('option_')[1];
                                                                if (typeof self.radio_image_content == "object" && typeof self.radio_image_content[count] != "undefined" && self.radio_image_content[count] != '' && typeof self.radio_image_content[count][op_seq] != "undefined" && self.radio_image_content[count][op_seq] != '') {
                                                                    var radio_image = self.radio_image_content[count][op_seq];
                                                                    answer_detail[op_count]['radio_image'] = radio_image;
                                                                } else if ($(this).parent().find('.resetImageRadioUpload').prev('img').attr('src')) {
                                                                    var radio_image = $(this).parent().find('.resetImageRadioUpload').prev('img').attr('src');
                                                                    answer_detail[op_count]['radio_image'] = radio_image;
                                                                }
                                                            }
                                                            if (enable_scoring == 1) {
                                                                answer_detail[op_count]['weight'] = weight;
                                                            }

                                                        }
                                                        null_option_count++;
                                                    }
                                                    //check null value
                                                    if (null_option_count > 1) {
                                                        $(this).parent().addClass('error-custom');
                                                        error_flag = 2;
                                                        $(this).attr('style', 'border:1px solid red; margin-top: 5px;max-width:50%;');
                                                    }
                                                }


                                            });
                                            survey_question_detail['answers'] = answer_detail;
                                        }

                                    });
                                    if (error_flag == 1) {
                                        if (options_div.find('.error_msg').length == 0) {
                                            options_div.prepend('<span class="error_msg" style="color:red;font-size:11px;">You may have to fill all the options.</span> ');
                                        } else {
                                            options_div.find('.error_msg').attr('style', 'color:red;');
                                        }
                                        error_flag = 0;
                                    } else if (error_flag == 2) {
                                        if (options_div.find('.error_msg').length == 0) {
                                            options_div.prepend('<span class="error_msg" style="color:red;">You may remain only one option as blank. Please fill out other options.</span> ');
                                        } else {
                                            options_div.find('.error_msg').attr('style', 'color:red;');
                                        }
                                        error_flag = 0;
                                    } else {
                                        options_div.find('.error_msg').attr('style', 'display:none;');
                                    }
                                    survey_question_detail_main[question_counter] = survey_question_detail;
                                });
                            }
                            survey_questions[question_counter] = survey_question_detail_main[question_counter];
                            question_counter++;
                        });
                    }
                });
                page_detail['questions'] = survey_questions;
                var page_title = self.$el.parents('.main-pane').find('#' + page_id).find('#txt_page_title').val();

                if (typeof page_title != "undefined" && page_title.trim() != "") {
                    page_detail['page_title'] = page_title.trim();
                    survey_pages[page_seq] = page_detail;
                    self.$el.parents('.main-pane').find('#' + page_id).find('#txt_page_title').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;');
                    self.$el.parents('.main-pane').find('#' + page_id).find('#txt_page_title').parent().removeClass('error-custom').find('span').attr('style', 'display:none;'); // hide error message icon on current input field

                } else if (typeof page_title != "undefined" && page_title.trim() == "") {
                    self.$el.parents('.main-pane').find('#' + page_id).find('#txt_page_title').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;border:1px solid red; color:red;'); // apply red color to input text and border
                    self.$el.parents('.main-pane').find('#' + page_id).find('#txt_page_title').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // show error message icon on current input field

                } else if (self.context.attributes.IsPOll) {
                    survey_pages[page_seq] = page_detail;
                }
            });
        });
        survey_data['pages'] = survey_pages;
        survey_data['survey_theme'] = survey_theme;
        var error_status = self.$el.parents('.main-pane').find('.error-custom');
        var is_require_missing = false;

        if (self.$el.parents('.main-pane').find('[data-fieldname=enable_data_piping]').find('[type=checkbox]:checked').length != 0)
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
                self.$el.parents('.main-pane').find('div:first').removeClass('error-custom');
            }
        }
        if (!error_on_sync_req_missing)
        {
            self.$el.parents('.main-pane').find('div:first').removeClass('error-custom');
        }

        if (error_on_sync_req_missing)
        {
            //if error then enable save & cancel button
            if (error_status.length != 0) {
                this.enableButtons();
            }
            self.$el.parents('.main-pane').find('div:first').addClass('error-custom');
            app.alert.show('is_req_msg', {
                level: 'confirmation',
                title: '',
                messages: 'This is a required field, click "Confirm" to make these question(s) required',
                onConfirm: function () {
                    self.$el.parents('.main-pane').find('.error-custom-requird').attr('checked', true);
                    self.$el.parents('.main-pane').find('.advance').attr('style', 'color:#747474');
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
            //if error then enable save & cancel button
            if (error_status.length != 0) {
                this.enableButtons();
            }
            self.$el.parents('.main-pane').find('div:first').addClass('error-custom');
            App.alert.show('msg', {
                level: 'error',
                messages: 'Mandatory fields are not included in the survey. Please add madatory fields from the selected sync module. Missing Mandatory Fields are : ' + module_required_fields,
                autoClose: false
            });
        } else {
            //if error then enable save & cancel button
            if (error_status.length != 0) {
                this.enableButtons();
            }

            this.survey_data = survey_data;
            this.initiateSave(_.bind(function () {

                if (isCreateFromSendSurvey == true || isCreateFromSendSurveyNew == true) {

                    App.alert.show('msg', {
                        level: 'success',
                        messages: 'You can send newly created survey by selecting survey from existing survey.',
                        autoClose: true
                    });
                } else {
                    if (this.context.attributes.IsPOll)
                    {
                        localStorage['isListPoll'] = true;
                    }
                    if (this.closestComponent('drawer')) {
                        app.drawer.close(this.context, this.model);
                    } else {
                        app.navigate(this.context, this.model);
                    }

                }


            }, this));
        }

    },
    /**save model
     * 
     * @param {type} success
     * @param {type} error
     * @returns {undefined}
     */
    saveModel: function (success, error) {

        var error_status = this.$el.parents('.main-pane').find($('.error-custom'));
        if (error_status.length == 0) {
            this._super('saveModel', [success, error]);
        } else {
            error_status.find('input').filter(':first').focus();
            App.alert.show('error-msg', {
                level: 'error',
                messages: 'Please resolve Survey Pages errors before proceeding.',
                autoClose: true
            });
        }
    },
    /**
     * Disable buttons
     */
    disableButtons: function () {
        this._super('disableButtons');
    },
    /**
     * Enable buttons
     */
    enableButtons: function () {
        this._super('enableButtons');
    },
    _dispose: function () {
        //additional stuff before calling the core create _dispose goes here
        this._super('_dispose');
    }

})
