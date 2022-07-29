({
    /**
     * The file used to handle actions for record view layout for survey template
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
    delegateButtonEvents: function () {
        this.context.on('button:edit_button:click', this.editClicked, this);
        this.context.on('button:save_button:click', this.saveClicked, this);
        this.context.on('button:delete_button:click', this.deleteClicked, this);
        this.context.on('button:create_survey:click', this.create_surveyClicked, this);
    },
    deleteClicked: function () {
        this._super('deleteClicked');
    },
    /**create survey from template
     * 
     * @returns {undefined}
     */
    create_surveyClicked: function () {
        if (localStorage['isLoadingFromTemplate'])
        {
            app.alert.show('info_survey', {
                level: 'info',
                messages: 'Please wait while survey is loading.',
                autoClose: false
            });
        } else {
            localStorage['isLoadingFromTemplate'] = true;
            //Create duplicate record as a survey
            var self = this,
                    prefill = app.data.createBean('bc_survey');

            prefill.copy(this.model);
            //set prefill data to localStorage
            localStorage['prefill'] = JSON.stringify(prefill);
            localStorage['copiedFromModelId'] = this.model.get('id');
            //redirect to create survey drawer
            var newWin = window.open("#bc_survey/create", "_blank");
            if (typeof newWin == "undefined") {
                app.alert.show('info', {
                    level: 'info',
                    messages: 'Please allow your browser to show pop-ups.',
                    autoClose: true
                });
            }
        }
    },
    /**save model of survey template
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
        this._super('initialize', [options]);
        // checking licence configuration ///////////////////////

        var url = App.api.buildURL("bc_survey", "checkingLicenseStatus", "", {});

        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data != 'success') {
                    location.assign('#bc_survey_template/layout/access-denied');
                }
            },
        });
        /////////////////////////////////////////////////////////
    },
    _render: function (options) {
        this._super('_render', [options]);
        $(document).find($('.create-survey')).append('<input type="hidden" value="SurveyTemplate" id="type">');
        $(document).find($('.create-survey')).hide(); // hide side-pane page-component
    },
    /**
     * Handler for intent to edit. This handler is called both as a callback
     * from click events, and also triggered as part of tab focus event.
     *
     * @param {Event} e Event object (should be click event).
     * @param {jQuery} cell A jQuery node cell of the target node to edit.
     */
    handleEdit: function (e, cell) {

        if (typeof app.alert.get('loading_detail_view') != "undefined") {
            app.alert.show('error', {
                level: 'error',
                messages: 'Please wait while detailview is loading.',
                autoClose: true
            });
        } else {
            this.model.editAllPages = false;
            var target,
                    cellData,
                    field;
            if (e) { // If result of click event, extract target and cell.
                target = this.$(e.target);
                cell = target.parents('.record-cell');
            }

            cellData = cell.data();
            field = this.getField(cellData.name);
            // check for custom field surveypages and ignore for inline edit default functionality
            if (field.name != 'surveypages') {
                // Set Editing mode to on.
                this.inlineEditMode = true;
                this.setButtonStates(this.STATE.EDIT);
                this.toggleField(field);
            }

            if (cell.closest('.headerpane').length > 0) {
                this.toggleViewButtons(true);
                this.adjustHeaderpaneFields();
            }
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

        this.toggleButtons(true);
        if (isValid) {
            this.handleSave();
        }
        this.model.isValid = isValid;
    },
    handleSave: function () {
        this._super('handleSave');
    },
    toggleViewButtons: function () {
        this._super('toggleViewButtons');
    },
    adjustHeaderpaneFields: function () {
        this._super('adjustHeaderpaneFields');
    },
    // apply custom edit in detailview for SurveyPages
    editClicked: function () {
        this.model.editAllPages = true;
        this._super('editClicked');
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
//            if (field.name == 'surveypages') {
//                return;
//            }
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
    /**save module fields and survey pages detail after successful validation
     * 
     * @returns {undefined}
     */
    saveClicked: function () {
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

                                var survey_question_detail = new Object();
                                count = que_section.split('_')[1];

                                // setting max value for textbox  field
                                var question_type = que_section.substr(0, que_section.indexOf('_')); // type of question to find its element

                                if (question_type != 'richtextareabox') {
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
                                    }
                                }

                                // setting max value for textbox  field
                                var question_type = que_section.substr(0, que_section.indexOf('_')); // type of question to find its element
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
                                        $('[name="video-url_' + que_section + '"]').addClass('error-custom');// error icon and red style to input
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
                                                    } else if(is_other_selected && $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').find('i').attr('title') == 'Error. This field is required.') {
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').hide();
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').removeClass('error-custom');
                                                    }
                                                } else if (is_image_option && $(this).parent('.options').find('.radioImageUpload').next('.spanRadioUploadError').find('i').attr('title') == 'Error. This field is required.') {
                                                    $(this).parent('.options').find('.radioImageUpload').next('.spanRadioUploadError').hide();
                                                    $(this).parent('.options').find('.radioImageUpload').removeClass('error-custom');

                                                    if (is_other_selected && $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').val() == '') {
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').show().find('i').attr('title', 'Error. This field is required.');
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').addClass('error-custom');
                                                    } else if(is_other_selected && $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').find('i').attr('title') == 'Error. This field is required.') {
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').hide();
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').removeClass('error-custom');
                                                    }
                                                } else if (is_other_selected && is_image_option && $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').find('i').attr('title') == 'Error. This field is required.') {
                                                    if ($(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').val() == '') {
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').show().find('i').attr('title', 'Error. This field is required.');
                                                        $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').addClass('error-custom');
                                                    } else if(is_other_selected && $(this).parents('.general_options').find('.otheroptiondiv').find('.radioImageUpload').next('.spanRadioUploadError').find('i').attr('title') == 'Error. This field is required.') {
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
                if (typeof page_title != "undefined" && page_title.trim() != "") {
                    $('#' + id).find('#txt_page_title').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;');
                    $('#' + id).find('#txt_page_title').parent().removeClass('error-custom').find('span').attr('style', 'display:none;'); // hide error message icon on current input field

                } else if (typeof page_title != "undefined" && page_title.trim() == "") {
                    $('#' + id).find('#txt_page_title').attr('style', 'z-index:1;  width:70%;height:20%; padding:4px; border-radius:3px;border:1px solid red; color:red;'); // apply red color to input text and border
                    $('#' + id).find('#txt_page_title').parent().addClass('error-custom').find('span').attr('style', 'margin-left:-25px; position:relative; z-index:500'); // show error message icon on current input field
                }
            });
        });
        // Disable the action buttons.
        var error_status = $(document).find($('.error-custom'));

        if (error_status.length == 0) {
            app.alert.show('loading_detail_view', {level: 'process', title: 'Loading', autoclose: false});
            this.toggleButtons(false);
            this.AlreadyfieldsToValidate = this.getFields(this.module);
            this.model.doValidate(this.getFields(this.module), _.bind(this.validationComplete, this));
            $('[name=edit_button]').addClass('disabled');
            this.restrictEdit = 'loading';
        } else {
            app.alert.show('error', {
                level: 'error',
                messages: "Please resolve any errors before proceeding",
                autoClose: true
            });
        }
    },
    _dispose: function () {
        //additional stuff before calling the core create _dispose goes here
        this._super('_dispose');
    }
})
