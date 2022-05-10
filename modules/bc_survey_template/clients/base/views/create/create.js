({
    /**
     * The file used to handle actions for create for survey template
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */
    extendsFrom: 'CreateView',
    SAVEACTIONS: {
        SAVE_AND_CREATE: 'saveAndCreate',
        SAVE_AND_VIEW: 'saveAndView'
    },
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
        switch (this.context.lastSaveAction) {
            default :
                this.saveAndClose();
        }
    },
    /**
     * Handle click on the cancel link
     */
    cancel: function () {
        //Clear unsaved changes on cancel.
        app.events.trigger('create:model:changed', false);
        this.$el.off();
        if (app.drawer.count()) {
            app.drawer.close(this.context);
            this._dismissAllAlerts();
        } else {
            app.router.navigate(this.module, {trigger: true});
        }
    },
    initialize: function (options) {

        // checking licence configuration ///////////////////////

        var url = App.api.buildURL("bc_survey", "checkingLicenseStatus", "", {});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data != 'success') {
                    location.assign('#bc_survey_template/layout/access-denied');
                }
            },
        });

        this._super('initialize', [options]);
        localStorage['restrictEdit'] = false; // Set save button restriction as false
        delete localStorage['survey_record_id'];
    },
    /**
     * Save and close drawer
     */
    initiateSave: function (callback) {
        var error_status = $(document).find($('.error-custom'));
        if (error_status.length == 0) {
            this.disableButtons();
        }
        async.waterfall([
            _.bind(this.validateSubpanelModelsWaterfall, this),
            _.bind(this.validateModelWaterfall, this),
            _.bind(this.createRecordWaterfall, this)
        ], _.bind(function (error) {
            this.enableButtons();
            if (error && error.status == 412 && !error.request.metadataRetry) {
                this.handleMetadataSyncError(error);
            } else if (!error && !this.disposed) {
                this.context.lastSaveAction = null;
                callback();
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
    /** save survey template fields and surveypages after successfull validation
     * 
     * @returns {undefined}
     */
    saveAndClose: function () {

        //save clicked then disable save button to avoid duplicate record save 
        this.disableButtons();
        var survey_data = new Object();

        var self = this;
        //getting survey pages
        var survey_pages = new Object();
        var page_seq = 0; //new**
        $('.thumbnail').each(function () {
            // set page id
            var page_id = this.id;
            var page_seq = page_id.substr(page_id.indexOf("_") + 1);
            var question_seq = 0;
            var data_page = $('#data-' + page_id);
            $(data_page).each(function () {

                var page_detail = new Object();
                var survey_questions = new Object();

                var question_class_id = this.id; //data-page_id
                $('#' + question_class_id).each(function () {

                    var que_class = $('#' + question_class_id).find('.question');
                    var que_sec_class = $('#' + question_class_id).find('.question-section');
                    // check question exists or not
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
                        var question_counter = 0;
                        $('#' + question_class_id).find($(que_class)).each(function () {
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
                                $(data_page).find($('#' + que_section)).each(function () {

                                    var survey_question_detail = new Object();
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
                                            if (typeof question != "undefined" && question.trim() != '') {
                                                $('[name="question_' + que_section + '"]').attr('style', ' max-width:80%;');
                                                $('[name="question_' + que_section + '"]').parent().removeClass('error-custom').find('span').attr('style', 'display:none;'); // error icon and red style to input
                                                $('[name="question_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                            }
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
                                    } else if ($('[name=uploadImageType_' + que_section + ']:checked').length != 0 && $('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && $('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("uploadsImage")) {
                                        survey_question_detail['question'] = "uploadImage";
                                    } else if ($('[name=uploadImageType_' + que_section + ']:checked').length != 0 && $('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && $('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("imageURL")) {
                                        survey_question_detail['question'] = "imageURL";
                                        $('[name="question_' + que_section + '"]').parent().removeClass('error-custom').find('span').attr('style', 'display:none;');
                                        $('[name="question_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                    } else if (typeof richTextContent != "undefined" && richTextContent.trim() == '' && survey_question_detail['que_type'] == 'richtextareabox') {
                                        $('[name="question_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                        $('[name="question_' + que_section + '"]').attr('style', 'display:none; max-width:80%; height:20%; padding:4px; border-radius:3px;border:1px solid red; color:red;');
                                        $('[name="question_' + que_section + '"]').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // error icon and red style to input
                                    } else if (survey_question_detail['que_type'] != 'richtextareabox') {
                                        $('[name="question_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                        $('[name="question_' + que_section + '"]').attr('style', ' max-width:80%; height:20%; padding:4px; border-radius:3px;border:1px solid red; color:red;');
                                        $('[name="question_' + que_section + '"]').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // error icon and red style to input
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
                                        }
                                    }

                                    //getting score enable or not
                                    var enable_scoring = $('#' + que_section).find('.enableScore').find('input:checked').length;
                                    survey_question_detail['enable_scoring'] = enable_scoring;

                                    //Is image option enabled ?
                                    var is_image_option = $('#' + que_section).find('.isImageOption').find('input:checked').length;
                                    survey_question_detail['is_image_option'] = is_image_option;


                                    var imageURL = $('[name="question_' + que_section + '"]').val();

                                    if (imageURL && imageURL.trim() != '') {
                                        $('[name="urlType_image_' + que_section + '"]').parent().removeClass('error-custom').find('span').attr('style', 'display:none;'); // error icon and red style to input
                                    }
                                    // setting helptips field
                                    var helptips = $('[name="helptips_' + que_section + '"]').val();
                                    if (helptips) {
                                        helptips = helptips.trim();
                                    }
                                    survey_question_detail['helptips'] = helptips;

                                    //setting is required field
                                    var is_required = $('[name="is_required_' + que_section + '"]').prop('checked');
                                    survey_question_detail['is_required'] = is_required;

                                    var is_question_seperator = self.$el.parents('.main-pane').find('[name="is_question_seperator_' + que_section + '"]').prop('checked');
                                    survey_question_detail['is_question_seperator'] = is_question_seperator;

                                    // Store File Size and File Extension
                                    var file_size = self.$el.parents('.main-pane').find('[name="file_size_' + que_section + '"]').val();
                                    survey_question_detail['file_size'] = file_size;
                                    var file_extension = self.$el.parents('.main-pane').find('[name="file_extension_' + que_section + '"]').val();
                                    survey_question_detail['file_extension'] = file_extension;

                                    // setting que type field
                                    var question_type = que_section.substr(0, que_section.indexOf('_'));
                                    survey_question_detail['que_type'] = question_type;

                                    // setting que-data type for textbox field
                                    var datatype = $('[name="datatype_' + que_section + '"]').val();
                                    if (question_type == 'textbox' && datatype != null && datatype != "0") {
                                        survey_question_detail['datatype'] = datatype;
                                    }

                                    // setting max size for textbox & commentbox field
                                    var size = $('[name="size_' + que_section + '"]').val();
                                    if ((question_type == 'textbox' || question_type == 'commentbox') && size) {
                                        survey_question_detail['maxsize'] = size;
                                    }

                                    // setting min value for textbox  field
                                    var min = $('[name="min_' + que_section + '"]').val();
                                    if ((question_type == 'textbox' && (datatype == 'Integer' || datatype == 'Float')) && min) {
                                        survey_question_detail['minvalue'] = min;
                                    }

                                    // setting max value for textbox  field
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

                                    // setting precision for textbox  field
                                    var precision = $('[name="precision_' + que_section + '"]').val();
                                    if ((question_type == 'textbox' && datatype == 'Float') && precision) {
                                        survey_question_detail['precision'] = precision;
                                    }

                                    // setting rows for commentbox field
                                    var rows = $('[name="rows_' + que_section + '"]').val();
                                    if (question_type == 'commentbox' && rows && rows.trim() != null) {
                                        survey_question_detail['rows'] = rows.trim();
                                    }

                                    // setting cols for commentbox field
                                    var cols = $('[name="cols_' + que_section + '"]').val();
                                    if (question_type == 'commentbox' && cols && cols.trim() != null) {
                                        survey_question_detail['cols'] = cols.trim();
                                    }

                                    //setting sorting for multichoice options
                                    var is_sort = $('[name="is_sort_' + que_section + '"]').prop('checked');
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
                                    var limit_min = $('[name="limit_min_' + que_section + '"]').val();
                                    if ((question_type == 'check-box' || question_type == 'multiselectlist') && typeof limit_min != 'undefined') {
                                        survey_question_detail['limit_min'] = limit_min;
                                    }

                                    //setting enable other option for multichoice options
                                    var enable_otherOption = $('[name="enable_otherOption_' + que_section + '"]').prop('checked');
                                    if ((question_type == 'check-box' || question_type == 'radio-button' || question_type == 'dropdownlist' || question_type == 'multiselectlist') && typeof enable_otherOption != 'undefined') {
                                        survey_question_detail['enable_otherOption'] = enable_otherOption;

                                        // Other option label
                                        var otherOptionLabel = $('[name="label_otherOption_' + que_section + '"]').val();
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
                                        var otherOptionScore = $('[name="option_score_' + que_section + '"]').val();
                                        if (otherOptionScore && otherOptionScore.trim() != null) {
                                            survey_question_detail['score_otherOption'] = otherOptionScore.trim();
                                        }

                                    }

                                    // setting display type for multichoice field
                                    var display = $('[name="display_' + que_section + '"]:checked').val();
                                    if ((question_type == 'check-box' || question_type == 'radio-button') && display) {
                                        survey_question_detail['display'] = display;
                                    }

                                    // setting star No for Rating field
                                    var star_no = $('[name="starNo_' + que_section + '"]').val();
                                    if (question_type == 'rating' && star_no) {
                                        survey_question_detail['star_no'] = star_no;
                                    }

                                    //setting required fields for contact information
                                    var requireFields = '';
                                    if (question_type == 'contact-information' && is_required == true) {
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
                                            survey_question_detail['requireFields'] = requireFields;
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

                                    // setting isDateTime for DateTime field
                                    var is_datetime = $('[name="is_datetime_' + que_section + '"]').prop('checked');
                                    if (question_type == 'date-time' && is_datetime) {
                                        survey_question_detail['is_datetime'] = is_datetime;
                                    }

                                    // setting start date for DateTime field
                                    var start_date = $('[name="startDate_' + que_section + '"]').val();
                                    if (question_type == 'date-time' && start_date) {
                                        survey_question_detail['start_date'] = start_date;
                                    }

                                    // setting end date for DateTime field
                                    var end_date = $('[name="endDate_' + que_section + '"]').val();

                                    //validate start & end date
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


                                    // setting image for Image field
                                    if (question_type == 'image') {
                                        if ($('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && $('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("uploadsImage")) {

                                            if (typeof self.image_content == "Object" && typeof self.image_content[count] != "undefined" && self.image_content[count] != '') {
                                                var image = self.image_content[count];
                                            } else {
                                                var image = '';
                                            }
                                            var uploadedImage = $('#' + que_section).find('.uploadedImage').attr('src');
                                            if (question_type == 'image' && ((image && image.trim()) || uploadedImage != '')) {
                                                if (uploadedImage) {
                                                    survey_question_detail['image'] = uploadedImage;
                                                    $('[name="uploadType_' + que_section + '"]').parent().removeClass('error-custom');
                                                    $('[name="uploadType_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                                    $('[name="uploadType_' + que_section + '"]').parent().find('span').attr('style', 'display:none;');
                                                } else if (image && image.trim()) {
                                                    survey_question_detail['image'] = image.trim();
                                                    $('[name="uploadType_' + que_section + '"]').parent().removeClass('error-custom');
                                                    $('[name="uploadType_' + que_section + '"]').parents('.question').find('.general').css('color', 'red');
                                                    $('[name="uploadType_' + que_section + '"]').parent().find('span').attr('style', 'display:none;');
                                                } else {
                                                    //Adding error msg class
                                                    $('[name="uploadType_' + que_section + '"]').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // error icon and red style to input 
                                                    $('[name="uploadType_' + que_section + '"]').parents('.question').find('.general').css('color', 'red');
                                                }
                                                // error icon and red style to input
                                            } else if (survey_question_detail['question'] == 'uploadImage' && !image && (!image.trim())) {
                                                //Adding error msg class
                                                $('[name="uploadType_' + que_section + '"]').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // error icon and red style to input
                                                $('[name="uploadType_' + que_section + '"]').parents('.question').find('.general').css('color', 'red');
                                            }
                                        } else if ($('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && $('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("imageURL")) {
                                            var image = $('[name="urlType_' + que_section + '"]').val();

                                            if (question_type == 'image' && image && (image.trim())) {

                                                survey_question_detail['image'] = image.trim();
                                                $('[name="urlType_' + que_section + '"]').attr('style', 'margin-left: 1px; max-width: 80%; display: inline-block;');
                                                $('[name="urlType_' + que_section + '"]').removeClass('error-custom'); // error icon and red style to input
                                                $('[name="urlType_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                            } else if (survey_question_detail['question'] == 'imageURL' && !image && (!image.trim())) {
                                                //Adding error msg class
                                                $('[name="urlType_' + que_section + '"]').attr('style', 'margin-left: 1px; max-width: 80%; display: inline-block;border:1px solid red;');
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
                                    if (question_type == 'video') {
                                        var video = $('[name="video-url_' + que_section + '"]').val();
                                        if (question_type == 'video' && video && video.trim() != '') {
                                            survey_question_detail['video'] = video.trim();
                                            $('[name="video-url_' + que_section + '"]').parents('.question').find('.general').css('color', '#747474');
                                            $('[name="video-url_' + que_section + '"]').attr('style', 'max-width:100%;margin-left:1px;');
                                            $('[name="video-url_' + que_section + '"]').removeClass('error-custom'); // error icon and red style to input
                                        } else if (question_type == 'video' && !video) {
                                            //Adding error msg class
                                            $('[name="video-url_' + que_section + '"]').parents('.question').find('.general').css('color', 'red');
                                            $('[name="video-url_' + que_section + '"]').attr('style', 'max-width:100%;margin-left:1px;border:1px solid red;');
                                            $('[name="video-url_' + que_section + '"]').addClass('error-custom'); // error icon and red style to input
                                        }


                                        var description = $('[name="description_' + que_section + '"]').val();
                                        if (question_type == 'video' && description && description.trim() != '') {
                                            survey_question_detail['description'] = description.trim();
                                        }
                                        // To add validation for Image Url for skip logic
                                        $('[name=helptips_' + que_section + ']').parents('.question').find('.advance').css('color', '#747474');
                                        $('[name=helptips_' + que_section + ']').removeClass('error-custom').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;');
                                        if ($('[name=helptips_' + que_section + ']').val() == '') {
                                            $('[name=helptips_' + que_section + ']').parents('.question').find('.advance').css('color', 'red');
                                            $('[name=helptips_' + que_section + ']').addClass('error-custom').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;border:1px solid red; color:red;'); // apply red color to input text and border;
                                        }
                                    }
                                    if (question_type == 'scale') {
                                        //setting display label for slider
                                        var left = $('[name="left_' + que_section + '"]').val();
                                        var middle = $('[name="middle_' + que_section + '"]').val();
                                        var right = $('[name="right_' + que_section + '"]').val();
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
                                        if (left && left.trim() != null && middle && middle.trim() != null && right && right.trim() != null) {
                                            survey_question_detail['label'] = left.trim() + '-' + middle.trim() + '-' + right.trim();
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
                                        if (start) {
                                            start = parseInt(start);
                                            end = parseInt(end);
                                            survey_question_detail['start'] = start;
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
                                            $('[name="end_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                            $('[name="end_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
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
                                            if ($('[name="step_' + que_section + '"]').parent().find('.error-step-msg').length == 0) {
                                                if (allowed_step_value == 1) {
                                                    $('[name="step_' + que_section + '"]').parent().append('<div class="error-step-msg" style="color:red;font-size:11px;">You may have to set step value 1.</div>');
                                                } else {
                                                    $('[name="step_' + que_section + '"]').parent().append('<div class="error-step-msg" style="color:red;font-size:11px;">You may have to set step value less than ' + allowed_step_value + '</div>');
                                                }
                                            }
                                        } else {
                                            if (allowed_step_value == 1) {
                                                $('[name="step_' + que_section + '"]').parent().find('.error-step-msg').html('You may have to set step value 1.');
                                            } else {
                                                $('[name="step_' + que_section + '"]').parent().find('.error-step-msg').html('You may have to set step value less than ' + allowed_step_value);
                                            }
                                        }

                                        if ((parseInt(step) > 0) === true) {
                                        } else {

                                            $('[name="step_' + que_section + '"]').addClass('error-custom').css('border', '1px solid red');
                                            $('[name="step_' + que_section + '"]').parents('.question').find('.advance').css('color', 'red');
                                            if ($('[name="step_' + que_section + '"]').parent().find('.error-step-msg').length == 0) {
                                                $('[name="step_' + que_section + '"]').parent().append('<div class="error-step-msg" style="color:red;font-size:11px;">Please enter only numeric values(1-9)</div>');
                                            } else {
                                                $('[name="step_' + que_section + '"]').parent().find('.error-step-msg').html('Please enter only numeric values(1-9)');
                                            }

                                        }
                                    }
                                    if (question_type == 'netpromoterscore') {

                                        var left = $('[name="left_' + que_section + '"]').val();
                                        var right = $('[name="right_' + que_section + '"]').val();
                                        if (left && left.trim() != null && right && right.trim() != null) {
                                            survey_question_detail['label_netpromoterscore'] = left.trim() + '-' + right.trim();
                                        }
                                    }

                                    if (question_type == 'matrix') {
                                        // setting display type for matrix
                                        var display_type = $('[name="display_type_' + que_section + '"]:checked').val();
                                        if (typeof display_type != 'undefined' && display_type.trim() != null) {
                                            survey_question_detail['display_type'] = display_type.trim();
                                        }
                                        // setting rows & columns for a matrix type
                                        answer_detail.rows = new Object();
                                        var row_error_flag = 0;
                                        var rows_div = $('#matrix_row_div_' + question_seq);
                                        rows_div.each(function () {
                                            var rowid = this.id;
                                            var row_count = 0;

                                            $('#' + rowid).find($('[name="row_matrix"]')).each(function () {
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
                                        var cols_div = $('#matrix_column_div_' + question_seq);
                                        cols_div.each(function () {
                                            var colid = this.id;
                                            var col_count = 0;

                                            $('#' + colid).find($('[name="column_matrix"]')).each(function () {
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

                                    var options_div = $('#' + survey_question_detail['que_type'] + '_options_div_' + count);
                                    var error_flag = 0;
                                    options_div.each(function () {

                                        var opid = this.id;

                                        var op_count = 0;

                                        var null_option_count = 0;
                                        $('#' + opid).find($('[name="option_' + survey_question_detail['que_type'] + '"]')).each(function () {
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
                                                        if (typeof self.radio_image_content == "object" && typeof self.radio_image_content[count] != "undefined" && self.radio_image_content[count] != '' && typeof self.radio_image_content[count][op_count] != "undefined" && self.radio_image_content[count][op_count] != '') {
                                                            var radio_image = self.radio_image_content[count][this.id];
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
                                                    $(this).attr('style', ' margin-top: 5px;max-width:50%;');
                                                    if (null_option_count == 0) {
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
                var page_title = $('#' + page_id).find('#txt_page_title').val();

                if (typeof page_title != "undefined" && page_title.trim() != "") {
                    page_detail['page_title'] = page_title.trim();
                    survey_pages[page_seq] = page_detail;
                    $('#' + page_id).find('#txt_page_title').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;');
                    $('#' + page_id).find('#txt_page_title').parent().removeClass('error-custom').find('span').attr('style', 'display:none;'); // hide error message icon on current input field

                } else if (typeof page_title != "undefined" && page_title.trim() == "") {
                    $('#' + page_id).find('#txt_page_title').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;border:1px solid red; color:red;'); // apply red color to input text and border
                    $('#' + page_id).find('#txt_page_title').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // show error message icon on current input field

                }
            });
        });
        survey_data['pages'] = survey_pages;
        var error_status = $(document).find($('.error-custom'));
        //if error then enable save & cancel button
        if (error_status.length != 0) {
            this.enableButtons();
        }

        this.initiateSave(_.bind(function () {
            if (error_status.length == 0) {
                var survey_id = this.model.id;
                survey_data['record_id'] = survey_id;

                // call api to save record via php
                var url = App.api.buildURL("bc_survey", "save_survey");
                App.api.call('create', url, {survey_data: JSON.stringify(survey_data), type: 'SurveyTemplate'}, {
                    success: function (data) {
                    }
                });

                if (app.drawer) {
                    app.drawer.close(this.context, this.model);
                }
            }

        }, this));
    },
    /** save model fields
     * 
     * @param {type} success
     * @param {type} error
     * @returns {undefined}
     */
    saveModel: function (success, error) {
        var error_status = $(document).find($('.error-custom'));
        if (error_status.length == 0) {
            var self = this,
                    options;
            options = {
                success: success,
                error: error,
                viewed: true,
                relate: (self.model.link) ? true : null,
                //Show alerts for this request
                showAlerts: {
                    'process': true,
                    'success': false,
                    'error': false //error callback implements its own error handler
                },
                lastSaveAction: this.context.lastSaveAction
            };
            this.applyAfterCreateOptions(options);

            // Check if this has subpanel create models
            if (this.hasSubpanelModels) {
                _.each(this.context.children, function (child) {
                    if (child.get('isCreateSubpanel')) {
                        // create the child collection JSON structure to save
                        var childCollection = {
                            create: []
                        };

                        // loop through the models in the collection and push each model's JSON
                        // data to the 'create' array
                        _.each(child.get('collection').models, function (model) {
                            childCollection.create.push(model.toJSON())
                        }, this)

                        // set the child JSON collection data to the model
                        this.model.set(child.get('link'), childCollection);
                    }
                }, this);
            }

            options = _.extend({}, options, self.getCustomSaveOptions(options));
            self.model.save(null, options);
        } else {
            error_status.find('input').filter(':first').focus();
            App.alert.show('error-msg', {
                level: 'error',
                messages: 'Please resolve SurveyPages errors before proceeding.',
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
