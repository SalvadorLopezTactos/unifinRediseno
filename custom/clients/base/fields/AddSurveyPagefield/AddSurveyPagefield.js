({
    /**
     * The file used to manage Page Component & its events to surveypages 
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */
    extendsFrom: 'RecordView',
    record_id: null, //current record id
    isValid: true,
    initialize: function (options) {
        this._super('initialize', [options]);
        this.context.on('button:edit_button:click', this.edit_button_clicked, this);
        this.context.on('button:save_button:click', this.save_button_clicked, this);
    },
    events: {
        'click .edit_page': 'edit_page_clicked', //individul page edit clicked
        'click .skip_logic,.change_type_skip_logic': 'show_skip_logic_option', // show skip logic layout onclicked.
        'click .advance': 'show_advance_option', // show advance option clicked for surveypages
        'click .general': 'show_general_option', // show general option clicked for surveypages
        'click .piping': 'show_piping_option', // show piping option clicked for surveypages
        'click .datatype-textbox': 'show_advance_input', // show advance option as per datatype change for textbox question type
        'click .page_toggle': 'collapsePage', // show or hide collapse of survey page
        'click i.fa-times': 'remove_icon_clicked', // remove icon of question or option clicked
        'click .remove_page': 'remove_page_clicked', // remove icon of page clicked
        'change .edit_que-type': 'edit_que_typeClicked', // edit question type clicked from question dropdown
        'click .add_page_above': 'add_page_aboveClicked', // add page above option clicked from page top section
        'click .add_page_below': 'add_page_belowClicked', // add page below option clicked from page top section
        'click #AddNewSurveyPage_icon': 'addNewPageButton', // add new page icon clicked from surveypages bottom section
        'click .is_required': 'showRequiredFields', // is_required checked for contact-information que type to show all fields to select as required
        'focus .show_datepicker': 'show_datepicker', //show datepicker for date question-type
        'click .uploadImageType': 'show_ImageUploadType', //show image upload input for image question-type
        'change .uploadSurveyImage': 'handleFileSelect', // handle image which is uploaded to store image content to global variable & also check for image or not
        'click .multiselectlist_add_option,.dropdownlist_add_option,.check-box_add_option,.radio-button_add_option': 'add_option_clicked', // add option to current question and adjust html of above option
        'click .multiselectlist_remove_option,.dropdownlist_remove_option,.check-box_remove_option,.radio-button_remove_option': 'remove_option_clicked', // remove option to current question and adjust html of above option
        'click .matrix_add_row, .matrix_add_column': 'add_option_clicked', // add rows or columns clicked for matrix question type
        'click .matrix_remove_row,.matrix_remove_column': 'remove_option_clicked', // remove rows or columns clicked for matrix question type
        'click .queTypeChange': 'showQueDropdown', // on click of questiontype edit icon change it to dropdoen list of question
        'click .changeImageUploaded': 'showUploadImageInput', // Change the uploaded image clicked to re-upload image for image question type
        'keypress .numericField': 'validateNumbericValue', // Validate numeric fields
        'keypress .decimalField': 'validateDecimalValue', // validate Float fields
        'change .logic_actions': 'applylogicTargetsOnchangeLogicActions', // Show skip logic targets based on selected conditions
        'click .clear_skip_logic,.clear_skip_logic_All': 'reset_SkipLogic', // clear logic apllied to multi select que
        'click .enableScore': 'enableScoring', // Enable scoringweight box to all options of current question
        'focusout .score_weight,.other_weight': 'setDefaultWeight', // Set default weight 0 is value is null
        'focusout .other_option_label': 'setDefaultOtherLabel', // Set default other option label  when value is null
        'change .redirect_to_page_options': 'redirect_to_pageSelected', // Warn user if selected previous page for redirect to page
        'click .enableOther': 'showOtherOptionRow', // Enable Other option
        'click .showQuestionSection': 'showQuestionSectionClicked', // Show Question Section Header
        'click .remove-section': 'removeSectionHeader', // Remove Question Section Header
        'click .disable_piping_question': 'disable_piping_question',
        'change .sync_field_selection': 'check_syn_field_type_convert_question_type',
        'click #survey_status_component': 'changeSurveystatus', // Survey Status :: LoadedTech Customization change survey status
        'click .isImageOption': 'showImageUploadInRadioQue', // On selection, allow image upload option for Radio button Question type
        'change .radioImageUpload': 'handleFileSelectRadioUpload', // Radio Upload selected then validate the uploaded file and store its content in variable
        'click .resetImageRadioUpload': 'resetImageRadioUpload', // Reset Image uploaded for Radio button
    },
    //  counter for survey pages
    page_counter: 1,
    que_counter: 1,
    option_counter: 0,
    counter: 0,
    remove_page_ids: new Array(), // set ids of page to be removed while edit mode
    remove_que_ids: new Array(), // set ids of question to be removed while edit mode
    remove_option_ids: new Array(), // set ids of option to be removed while edit mode
    individualEdit: false,
    /**
     * Called when rendering the field
     */
    _render: function () {
        this._super('_render');

        var self = this;
        var copiedFromModelId = null;
        var isCreateFromSendSurvey = null;
        self.record_id = this.model.id; // to set and get layout for page in detail view
        // add new page via icon clicked

        self.themeDetailView();

        // LOADEDTECH :: Copy survey from survey
        if (localStorage['copyFromSurvey'])
        {
            var SurveyBean = app.data.createBean('bc_survey', {id: self.model.get('id')});
            var prefill = app.data.createBean('bc_survey');
            var request = SurveyBean.fetch();
            request.xhr.done(function () {
                SurveyBean.attributes.description = SurveyBean.get('description');
                SurveyBean.attributes.name = SurveyBean.get('name');

                if (self.model.get('name') && typeof localStorage['copiedFromModelId'] != "undefined" && localStorage['copyImageId'] != "null" && localStorage['copyBGImageId'] != "null") {
                    // Copy logo while creting duplicate survey.
                    var copyModuleID = localStorage['copiedFromModelId'];
                    //  delete localStorage['copiedFromModelId'];
                    var copyImageId = localStorage['copyImageId'];
                    //  delete localStorage['copyImageId'];
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
                }

                // Show / Hide Sync fields
                if (SurveyBean.attributes.enable_data_piping)
                {
                    self.$el.parents('.main-pane').find('[data-name=sync_module]').find('div:first').show();
                    self.$el.parents('.main-pane').find('[data-fieldname="sync_module"]').show();

                    self.$el.parents('.main-pane').find('[data-name=sync_type]').find('div:first').show();
                    self.$el.parents('.main-pane').find('[data-fieldname="sync_type"]').show();
                } else {
                    self.$el.parents('.main-pane').find('[data-name=sync_module]').find('div:first').hide();
                    self.$el.parents('.main-pane').find('[data-fieldname="sync_module"]').hide();

                    self.$el.parents('.main-pane').find('[data-name=sync_type]').find('div:first').hide();
                    self.$el.parents('.main-pane').find('[data-fieldname="sync_type"]').hide();
                }

                //delete localStorage['copyFromSurvey']; // delete local variable to re use in another survey
            });

        }
        // LOADEDTECH :: Copy survey from survey END

        if (self.model && self.model.get('survey_type') == 'poll')
        {
            self.context.attributes.IsPOll = true;
            self.$el.parents('.main-pane').find('[data-name=enable_data_piping]').parents('.panel_body').hide();
            self.$el.parents('.main-pane').find('.label-bc_survey').attr('data-original-title', 'Poll').html('Po');
            self.$el.parents('.main-pane').find('[data-panelname=LBL_RECORDVIEW_PANEL1]').find('.pull-left').html('Poll Question');

            self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').hide(); // hide side-pane page-component
            self.$el.parents('.main-pane').find('[data-name=description]').css('display', 'none'); // hide description
            self.$el.parents('.main-pane').find('[data-panelname=LBL_RECORDVIEW_PANEL2]').hide(); // hide advance configuration PANEL
            self.$el.parents('.main-pane').find('[data-panelname=LBL_RECORDVIEW_PANEL3]').hide(); // hide Welcome Page PANEL
            self.$el.parents('.main-pane').find('[data-panelname=LBL_RECORDVIEW_PANEL4]').hide(); // hide Thanks Page PANEL

            self.$el.parents('.main-pane').next('.sidebar-content').find('.page_component').hide();
            self.$el.parents('.main-pane').next('.sidebar-content').find('.page_component_inner').hide();
            self.$el.parents('.main-pane').next('.sidebar-content').find('.custom_theme_inner').show();

            // make available panel mode as ACTIVE
            $.each(self.$el.parents('.main-pane').find('.record-panel-header'), function () {
                $(this).removeClass('panel-inactive');
                $(this).addClass('panel-active');
                $(this).parent().find('.record-panel-content').removeClass('hide');
            });
        }

        if (!this.$el.find('#txt_page_title').html()) { // by default one page should display
            var default_page_html = self.new_page_html();
            self.$el.parents('.main-pane').find('.SurveyPage').before(default_page_html);
        }
        //if copy survey from template then display in edit mode of selected survey temoplate page data
        if (self.context.attributes.copiedFromModelId)
        {
            copiedFromModelId = self.context.attributes.copiedFromModelId;
            // take backup of templateID for reuse if missed
            self.copiedFromModelId = copiedFromModelId;
        }
        // if templateID missed at first render then get it from the backup
        else if (self.copiedFromModelId)
        {
            copiedFromModelId = self.copiedFromModelId;
        }
        //create survey from send survey popup
        if (self.context.attributes.isCreateFromSendSurvey)
        {
            isCreateFromSendSurvey = self.context.attributes.isCreateFromSendSurvey;
            copiedFromModelId = self.context.attributes.copiedFromModelPopupId;
            // take backup of templateID for reuse if missed
            self.copiedFromModelId = copiedFromModelId;
            self.isCreateFromSendSurvey = isCreateFromSendSurvey;
        }
        // if templateID missed at first render then get it from the backup
        else if (self.isCreateFromSendSurvey && self.copiedFromModelId) {
            isCreateFromSendSurvey = self.isCreateFromSendSurvey;
            copiedFromModelId = self.copiedFromModelId;
        }

        var url = App.api.buildURL("bc_survey", "get_sync_module_fields", "", {});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data && data['field_labels'])
                {
                    self.sync_module_fields = data['field_labels'];
                    self.sync_module_fields_for_boolean = data['field_labels_boolean'];
                }
                if (data && data['field_types'])
                {
                    self.sync_module_fields_types = data['field_types'];
                }
            }
        });

        if (self.$el.parents('.main-pane').find('[name=sync_module]').parent().find('#recent_sync_module').length == 0)
        {
            self.$el.parents('.main-pane').find('[name=sync_module]').parent().append('<input type="hidden" value="' + this.model.get('sync_module') + '" id="recent_sync_module" >');
        } else {
            self.$el.parents('.main-pane').find('[name=sync_module]').parent().find('#recent_sync_module').val(this.model.get('sync_module'));
        }

        self.$el.parents('.main-pane').find('[data-fieldname=enable_data_piping]').find('[type=checkbox]').addClass('enable_data_piping_field');
        //detail view
        if (self.record_id != null) {
            self.survey_record_id = self.record_id;
            var url = App.api.buildURL("bc_survey", "isSurveySend", "", {record: self.record_id});
            App.api.call('GET', url, {}, {
                success: function (data) {
                    // Survey Status :: LoadedTech Customization
                    var editAction = self.view.currentState;
                    if ((editAction != "edit" || self.action != "edit")) {
                        self.$el.parents('.main-pane').find('[data-name="survey_status"]').show();
                        if (data && data['survey_status'] == "1") { // Survey Status
                            var survey_status_chk = '<label class="switch" id="survey_status_label" data-original-title="Active" rel="tooltip" data-placement="bottom"> <input type="checkbox" id="survey_status_chk" checked> <span class="slider round" id="survey_status_component"></span></label>';
                        } else {
                            var survey_status_chk = '<label class="switch" id="survey_status_label" data-original-title="Inactive" rel="tooltip" data-placement="bottom"> <input type="checkbox" id="survey_status_chk"> <span class="slider round" id="survey_status_component"></span></label>';
                        }
                        self.$el.parents('.main-pane').find('[data-name="survey_status"]').css('padding-top', '19px');
                        self.$el.parents('.main-pane').find('[data-fieldname="survey_status"]').replaceWith(survey_status_chk);

                        $('#survey_status_component').on('click', function () {
                            self.changeSurveystatus();
                        });
                    } else {
                        self.$el.parents('.main-pane').find('[data-name="survey_status"]').hide();
                    }
                    // Survey Status :: LoadedTech Customization END

                    self.$el.parents('.main-pane').find('[data-fieldname="survey_send_status"]').find('[title=Published]').css('background-color', 'green');
                    self.$el.parents('.main-pane').find('[data-fieldname="survey_send_status"]').find('[title=Published]').css('border', '1px solid transparent');
                    self.$el.parents('.main-pane').find('[data-fieldname="survey_send_status"]').find('[title=Unpublished]').css('background', '#e5a117');
                    self.$el.parents('.main-pane').find('[data-fieldname="survey_send_status"]').find('[title=Unpublished]').css('border', '1px solid transparent');

                    if (data && data['restrict_edit'] == "1") { // survey is send so disable all kind of edit of page
                        self.$el.parents('.main-pane').find('[name="edit_button"]').addClass('disabled');
                        self.restrictEdit = "true";
                    } else { // survey is not send so enable all kind of edit
                        self.restrictEdit = "false";
                    }
                    // check sugar 7.7.* or not
                    if (data && data['sugar_latest'] == "1")
                    {
                        self.sugar_latest = true;
                    } else {
                        self.sugar_latest = false;
                    }
                    var editAction = self.view.currentState;
                    if ((editAction == "edit" || self.action == "edit") && self.record_id != null && data && data['restrict_edit'] == "0") {
                        self.$el.parents('.main-pane').find('.get_share_link').hide();
                        self.$el.parents('.main-pane').find('.open_link').hide();
                        self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').show(); // show side-pane page-component
                        if ((self.model && self.model.get('survey_type') == 'poll') || (self.context && self.context.attributes.IsPOll))
                        {
                            self.$el.parents('.main-pane').next('.sidebar-content').find('.page_component').hide();
                            self.$el.parents('.main-pane').next('.sidebar-content').find('.page_component_inner').hide();
                            self.$el.parents('.main-pane').next('.sidebar-content').find('.custom_theme_inner').show();
                        }
                        self.detailView(1, self.record_id, "");
                        self.$el.parents('.main-pane').find('.data-page').attr('style', ''); // open all page collpase
                    } else {
                        self.$el.parents('.main-pane').find('.get_share_link').show();
                        self.$el.parents('.main-pane').find('.open_link').show();
                        self.detailView('', self.record_id, "");
                    }
                    //   self.$el.parents('.main-pane').next('.sidebar-content').find($('.create-survey')).hide(); // show side-pane page-component

                },
            });
            //set edit button id
            self.$el.parents('.main-pane').find('.fieldset.actions.detail.btn-group').parent().find(self.$el.parents('.main-pane').find('[name="edit_button"]')).attr({'style': '', 'id': 'edit_button'});
            $(document).on('click', '[name=cancel_button]', function () {

                if (self.counter == 0) {
                    self.counter++;
                    self.individualEdit = false;
                    self.$el.parents('.main-pane').find('.get_share_link').show();
                    self.$el.parents('.main-pane').find('.open_link').show();
                    if (self.model && self.model.get('survey_type') != 'poll' && (self.context && !self.context.attributes.IsPOll))
                    {
                        document.getElementById('new-page').ondragstart = function () {
                            return true;
                        };

                    }

                    if ($(this).attr('id') == 'cancel_edit')
                    {
                        self.$el.parents('.main-pane').find('#cancel_edit').attr('style', 'display:none;');
                        self.$el.parents('.main-pane').find('#save_edit').attr('style', 'display:none;');
                        self.$el.parents('.main-pane').find('.fieldset').removeClass('hide');
                        self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').hide(); // show side-pane page-component
                        self.detailView('', self.record_id, "");
                    }
                }
            });
        }
        // Survey Status :: LoadedTech Customization
        else {
            self.$el.parents('.main-pane').find('[data-name="survey_status"]').hide();
        }
        // Survey Status :: LoadedTech Customization END

        var $eventSelect = self.$el.parents('.main-pane').find("[name=sync_module]");
        $eventSelect.on("change", function (e) {

            self.reset_sync_field(e);
        });

        if (self.model.get('enable_data_piping'))
        {
            self.$el.parents('.main-pane').find('[data-name=sync_module]').find('div:first').show();
            self.$el.parents('.main-pane').find('[data-fieldname="sync_module"]').show();

            self.$el.parents('.main-pane').find('[data-name=sync_type]').find('div:first').show();
            self.$el.parents('.main-pane').find('[data-fieldname="sync_type"]').show();
        } else {
            self.$el.parents('.main-pane').find('[data-name=sync_module]').find('div:first').hide();
            self.$el.parents('.main-pane').find('[data-fieldname="sync_module"]').hide();

            self.$el.parents('.main-pane').find('[data-name=sync_type]').find('div:first').hide();
            self.$el.parents('.main-pane').find('[data-fieldname="sync_type"]').hide();
        }


        $(document).on('click', '.enable_data_piping_field', function (el) {

            var current_el = $(el.currentTarget);
            $(el.currentTarget).parents('.main-pane').find('[data-fieldname=enable_data_piping]').find('[type=checkbox]').addClass('enable_data_piping_field');
            if ($(el.currentTarget).parents('.main-pane').find('.enable_data_piping_field:checked').length != 0)
            {
                var $eventSelect = $(this).parents('.main-pane').find("[name=sync_module]");
                $eventSelect.on("change", function (e) {

                    self.reset_sync_field(e);
                });
                $(el.currentTarget).parents('.main-pane').find('[data-name=sync_module]').find('div:first').show();
                $(el.currentTarget).parents('.main-pane').find('[data-fieldname="sync_module"]').show();

                $(el.currentTarget).parents('.main-pane').find('[data-name=sync_type]').find('div:first').show();
                $(el.currentTarget).parents('.main-pane').find('[data-fieldname="sync_type"]').show();
            } else {
                app.alert.show('change_sync_module_confirmation', {
                    level: 'confirmation',
                    title: '',
                    messages: 'By disabling data piping existing question\'s sync field will be reset. Are you sure that you want to proceed ?',
                    onConfirm: function () {
                        current_el.parents('.main-pane').find('[data-name=sync_module]').find('div:first').hide();
                        current_el.parents('.main-pane').find('[data-fieldname="sync_module"]').hide();

                        current_el.parents('.main-pane').find('[data-name=sync_type]').find('div:first').hide();
                        current_el.parents('.main-pane').find('[data-fieldname="sync_type"]').hide();

                        $.each(current_el.parents('.main-pane').find('.question'), function () {

                            if ($(this).find('.sync_field_selection').val()) {
                                var current_que_detail = $(this).attr('id').split('_');
                                var muti_choice_que_type = current_que_detail[0];
                                var current_que_seq = current_que_detail[1];
                                if (muti_choice_que_type != 'boolean')
                                {
                                    var data = '';
                                    data += "               <div class='options' id='option_0'>";
                                    data += "                 <input type='text' name='option_" + muti_choice_que_type + "' placeholder='Option' class='inherit-width' style='max-width:50%;'>";
                                    data += "                 <input type='number' name='score_" + muti_choice_que_type + "'  value='1' class='inherit-width score_weight' style='max-width:7%; display:none;'>";
                                    data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_remove_option que_" + current_que_seq + "' id='0' style='display:none;margin-left:2px; margin-top:5px;'><i class='fa fa-times'></i></a>";
                                    data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_add_option que_" + current_que_seq + "' style='display:none;' id='0'><i class='fa fa-plus' ></i></a>";
                                    data += "               </div>";
                                    data += "               <div class='options' id='option_1'>";
                                    data += "                 <input type='text' name='option_" + muti_choice_que_type + "' placeholder='Option' class='inherit-width' style='max-width:50%;margin-top:5px;'>";
                                    data += "                 <input type='number' name='score_" + muti_choice_que_type + "' value='2' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;display:none;'>";
                                    data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_remove_option que_" + current_que_seq + "' id='1' style='display:none;margin-left:2px; margin-top:5px;'><i class='fa fa-times'></i></a>";
                                    data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_add_option que_" + current_que_seq + "' style='margin-left:2px; margin-top:5px;' id='1'><i class='fa fa-plus' ></i></a>";
                                    data += "               </div>";
                                    $(this).parents('.main-pane').find('#' + muti_choice_que_type + '_options_div_' + current_que_seq).html(data);
                                }
                                $(this).find('.sync_field_selection').val('Select Field');
                            }
                        });

                        $.each(current_el.parents('.main-pane').find('.question'), function () {
                            if ($(this).find('.piping').hasClass('active'))
                            {
                                $(this).find('.piping').removeClass('active');
                                $(this).find('.piping_options').hide();
                                $(this).find('.general').addClass('active');
                                $(this).find('.general_options').show();
                            }
                        });
                    },
                    onCancel: function () {
                        current_el.parents('.main-pane').find('[data-fieldname=enable_data_piping]').find('[type=checkbox]').attr('checked', true);
                        current_el.parents('.main-pane').find('[data-fieldname=enable_data_piping]').find('[type=checkbox]').addClass('enable_data_piping_field');

                        current_el.parents('.main-pane').find('[data-name=sync_module]').find('div:first').show();
                        current_el.parents('.main-pane').find('[data-fieldname="sync_module"]').show();

                        current_el.parents('.main-pane').find('[data-name=sync_type]').find('div:first').show();
                        current_el.parents('.main-pane').find('[data-fieldname="sync_type"]').show();
                    }
                });

            }
        });

        if ((self.model && self.model.get('survey_type') == 'poll') || (self.context && self.context.attributes.IsPOll))
        {
            self.$el.parents('.main-pane').find('.SurveyPage').hide();
            self.$el.parents('.main-pane').find('#placeholder').hide();

            self.$el.parents('.main-pane').find('[name="preview_survey"]').html('<i class="fa  fa-eye" tabindex="-1"></i>Preview Poll');
            self.$el.parents('.main-pane').find('[name="view_report"]').html('<i class="fa fa-bolt" tabindex="-1"></i>Analyse Poll');
            self.$el.parents('.main-pane').find('[name="translate_survey"]').html('<i class="fa fa-refresh" tabindex="-1"></i>Translate Poll');

            self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').show();
            self.$el.parents('.main-pane').next('.sidebar-content').find('.page_component').hide();
            self.$el.parents('.main-pane').next('.sidebar-content').find('#page_component_inner').hide();
            self.$el.parents('.main-pane').next('.sidebar-content').find('#custom_theme_inner').show();
            if (self.context.attributes.IsCreatePoll) {
                var create_poll_html = '';
                create_poll_html += '<div class="Survey_Pages ui-droppable ui-sortable" id="edit_view">';
                create_poll_html += '<div id="page_1" class="thumbnail thumbnail_page dashlet" style="margin-top:10px;margin-bottom:10px; min-height:0px;padding:0px;">';

                create_poll_html += '    <div data-dashlet="toolbar" >';
                create_poll_html += '        <div class="dashlet-header">';
                create_poll_html += '           <h4 data-toggle="dashlet" style="min-height:20px; background-color:#c5c5c5; color:#555; " class="dashlet-title"> ';
                create_poll_html += '               <div> Poll Question';
                create_poll_html += '               </div>';
                create_poll_html += '           </h4>';

                create_poll_html += '      </div>';

                create_poll_html += '    </div>';
                create_poll_html += '    <div id="data-page_1" class="data-page" data-dashlet="dashlet" style="">';
                create_poll_html += '       <div id="radio-button_1" class="que_1 question ">';

                create_poll_html += '        <div class="row">  <div class="span6">        </div>        </div>';
                create_poll_html += '       <div class="general_options">';
                create_poll_html += '         <div class="row">       ';
                // Type
                create_poll_html += '            <div class="span1">Type</div>';
                create_poll_html += '           <div class="span5 ">';
                create_poll_html += '             <input type="radio" name="question-type" value="radio-button" checked="">';
                create_poll_html += '             &nbsp; <i class="fa fa-dot-circle-o" style="font-size:13px;">&nbsp; Radio Button </i>&nbsp;';
                create_poll_html += '             <input type="radio" name="question-type" value="check-box" >';
                create_poll_html += '             &nbsp; <i class="fa fa-check-square-o" style="font-size:13px;">&nbsp; CheckBox </i>';
                create_poll_html += '           </div>';
                // Image options
                create_poll_html += '           <div class="span2">Show Image Option?</div>';
                create_poll_html += '           <div class="span1 isImageOption">';
                create_poll_html += '             <input type="checkbox" name="is_image_option_radio-button_1" class="inherit-width">';
                create_poll_html += '           </div>';
                create_poll_html += '           <div class="span2 showOptionText" style="display:none;">Show Option Text?</div>';
                create_poll_html += '           <div class="span1 showOptionText" style="display:none;">';
                create_poll_html += '             <input type="checkbox" name="show_option_text_radio-button_1" class="inherit-width">';
                create_poll_html += '           </div>';

                create_poll_html += '  </div>';
                create_poll_html += '  <div class="row">       ';
                create_poll_html += '      <div class="span1">Question</div>      ';
                create_poll_html += '     <div class="span11">        ';
                create_poll_html += '         <div class="">          ';
                create_poll_html += '            <input type="text" name="question_radio-button_1" placeholder="(Required) Question" style="max-width:80%; margin-left:1px;" class="inherit-width">          <span style="display:none;"><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>         ';
                create_poll_html += '       </div>      ';
                create_poll_html += '   </div>';
                create_poll_html += '</div>';
                create_poll_html += '<div class="row">       ';
                create_poll_html += ' <div class="span1">Options</div>';
                create_poll_html += ' <div class="span11" id="radio-button_options_div_1">';
                create_poll_html += '     <div id="option_0" class="options">       ';
                create_poll_html += "         <input type='file' name='radioImage_radio-button' id='radio_image_1'  class='inherit-width radioImageUpload' style='width: 175px;max-width:50%; margin-left:1px; margin-top:5px; display:none;'> <span style='margin-left: -13px; margin-top: 6px; position:relative; z-index:500; display:none; width:auto;' class='spanRadioUploadError'><a><i class='fa fa-exclamation-circle' title='Error. This field is required.' style='color:red;font-size:12px;'></i></a></span>";
                create_poll_html += '         <input type="text" name="option_radio-button"  placeholder="Option" class="inherit-width" style="margin-top:5px;max-width:50%;margin-left:1px;">   ';
                create_poll_html += '         <input type="number" name="score_radio-button" value="1" class="inherit-width score_weight" style="max-width:7%; margin-top:5px;display:none;margin-left:1px;">     ';
                create_poll_html += '         <a href="javascript:void(0);" class="btn  radio-button_remove_option que_1" id="0" style="margin-left: 2px; margin-top: 5px; display: none;">';
                create_poll_html += '             <i class="fa fa-times" id="remove_option_0"></i></a>       ';
                create_poll_html += '      <a href="javascript:void(0);" class="btn  radio-button_add_option que_1" style="display:none;margin-left:2px; margin-top:5px;" id="0">  <i class="fa fa-plus"></i>   </a></div><div id="option_1" class="options">       ';
                create_poll_html += "         <input type='file' name='radioImage_radio-button' id='radio_image_2'  class='inherit-width radioImageUpload' style='width: 175px;max-width:50%; margin-left:1px; margin-top:5px; display:none;'> <span style='margin-left: -13px; margin-top: 6px; position:relative; z-index:500; display:none; width:auto;' class='spanRadioUploadError'><a><i class='fa fa-exclamation-circle' title='Error. This field is required.' style='color:red;font-size:12px;'></i></a></span>";
                create_poll_html += '             <input type="text" name="option_radio-button"  placeholder="Option" class="inherit-width" style="margin-top:5px;max-width:50%;margin-left:1px;">   ';
                create_poll_html += '             <input type="number" name="score_radio-button" value="2" class="inherit-width score_weight" style="max-width:7%; margin-top:5px;display:none;margin-left:1px;">       ';
                create_poll_html += '            <a href="javascript:void(0);" class="btn  radio-button_remove_option que_1" id="1" style="margin-left: 2px; margin-top: 5px; display: none;">';
                create_poll_html += '                 <i class="fa fa-times" id="remove_option_1"></i></a>       ';
                create_poll_html += '             <a href="javascript:void(0);" class="btn  radio-button_add_option que_1" style="margin-left:2px; margin-top:5px;" id="1"> ';
                create_poll_html += '                 <i class="fa fa-plus"></i>   ';
                create_poll_html += '             </a>';
                create_poll_html += '         </div>';
                create_poll_html += '     </div>';
                create_poll_html += '   </div>';
                create_poll_html += '   </div>';
                create_poll_html += '   </div>';
                create_poll_html += ' </div>';
                create_poll_html += ' </div> ';
                create_poll_html += '</div>';
                self.$el.parents('.main-pane').find('.Survey_Pages').replaceWith(create_poll_html);
            }
        } else {
            //render draggable
            this.makeDraggable();
            //if copy from template is set then prefill survey pages
            if (copiedFromModelId || isCreateFromSendSurvey) {
                self.context.attributes.copiedFromModelId = '';
                self.detailView_copyFromTemplate(1, copiedFromModelId, self.context.attributes.prefill_type);
                self.$el.parents('.main-pane').find('.fieldset.actions.detail.btn-group').parent().find(self.$el.parents('.main-pane').find('[name="cancel_button"]')).removeClass('hide').attr({'style': '', 'id': 'cancel_edit'});
            }
        }

        if (self.model.get('name') && localStorage['copyFromSurvey'] && typeof localStorage['copiedFromModelId'] != "undefined" && localStorage['copyImageId'] != "null" && localStorage['copyBGImageId'] != "null")
        {
            // Copy logo while creting duplicate survey. By GSR.
            var copyModuleID = localStorage['copiedFromModelId'];

            var copyImageId = localStorage['copyImageId'];

            var copyFromModule = 'bc_survey';
            var copyImagField = 'survey_logo';
            if ((typeof copyModuleID != 'undefined' && copyModuleID != '') && (typeof copyImageId != 'undefined' && copyImageId != '')) {
                self.$el.parents('.main-pane').find('[data-name=survey_logo]').find('.image_preview').find('img').attr('src', App.api.serverUrl + '/' + copyFromModule + '/' + copyModuleID + '/file/' + copyImagField + '?format=sugar-html-json&platform=base&_hash=' + copyImageId);
                var lengthsurvey_logo_img_id = self.$el.parents('.main-pane').find('#survey_logo_img_id').length;
                if (lengthsurvey_logo_img_id == 0) {
                    self.$el.parents('.main-pane').find('[data-name=survey_logo]').find('.image_preview').append('<input type="hidden" id="survey_logo_img_id" value="' + copyImageId + '">');
                } else {
                    self.$el.parents('.main-pane').find('#survey_logo_img_id').val(copyImageId);
                }
            }

            // copy background Image while duplicating survey. By NM.
            var copyImageId = localStorage['copyBGImageId'];
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
            // End
        }
    },
    // Survey Status :: LoadedTech Customization
    changeSurveystatus: function () {

        // Survey status is marked as Active
        if (this.$el.parents('.main-pane').find('#survey_status_chk:checked').length == 0) {
            var survey_status = "1";
            this.$el.parents('.main-pane').find('#survey_status_label').attr('data-original-title', 'Active');
        }
        // Survey status is marked as Inctive
        else {
            var survey_status = "0";
            this.$el.parents('.main-pane').find('#survey_status_label').attr('data-original-title', 'Inactive');
        }
        // survey id
        if (this.model)
        {
            var record_id = this.model.id;
        }

        // call api to save survey status via php
        var url = App.api.buildURL("bc_survey", "change_survey_status", "", {record_id: record_id, survey_status: survey_status});
        App.api.call('GET', url, {}, {
            success: function (data) {
                app.alert.show('success_survey_sttaus', {
                    level: 'success',
                    messages: data,
                    autoClose: true
                });
            }
        });

    },
    // Survey Status :: LoadedTech Customization END
    /*
     * Theme on Detail view
     * 
     */
    themeDetailView: function (survey_theme) {
        var self = this;
        if (self.action == "edit") {
            self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').show();
            $('[data-name=survey_theme]').find('[data-fieldname=survey_theme]').find('span').html('');
            $('[data-name=survey_theme]').find('.record-label').hide();
            if (!self.record_id) {
                self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').find('.theme_selection').find('[value=theme0]').attr('checked', 'checked');
            }
        } else {
            $('[data-name=survey_theme]').find('.record-label').show();
            var theme_file = self.model.get('survey_theme');
            if (typeof survey_theme !== 'undefined') {
                theme_file = survey_theme
            }
            var themeLbl = app.lang.getAppListStrings('theme_list')[theme_file];
            if (theme_file == "theme0") {
                theme_file = "default-theme.jpg";
            } else if (theme_file == "theme1" || theme_file == "theme4" || theme_file == "theme5" || theme_file == "theme6" || theme_file == "theme7" || theme_file == "theme9" || theme_file == "theme10") {
                theme_file = theme_file.replace("theme", "theme-");
                theme_file = theme_file + "-hover.png";
            } else if (theme_file == "theme2" || theme_file == "theme3" || theme_file == "theme8") {
                theme_file = theme_file.replace("theme", "theme-");
                theme_file = theme_file + "-hover.jpg";
            }
            if ($('[data-fieldname=survey_theme]').find('span').find('img').length == 0) {
                $('[data-fieldname=survey_theme]').find('span').append('<img style="width: 40%;display: inherit;" src="custom/include/survey-img/' + theme_file + '" class="SurveyTheme" />');
            } else {
                $('[data-name=survey_theme]').find('[data-fieldname=survey_theme]').find('span').text(themeLbl);
                $('[data-fieldname=survey_theme]').find('span').find('img').attr('src', 'custom/include/survey-img/' + theme_file);
            }
        }
    },
    /**
     * Set detailview for surveypages
     * 
     * @editFlag if set to 1 then create elements in edit mode
     * @record_id retrieve record of given id
     * @is_loading editing record mode is mode so hide editing option till loading and after loading complate enable edit options
     */
    detailView: function (editFlag, record_id, is_loading) {
        // app.alert.show('loading_detail_view', {level: 'process', title: 'Loading', autoclose: false});
        if (this.model)
        {
            var record_id = this.model.id;
        }
        var self = this;
        var type = self.module;
        if (type == 'bc_survey_template') {
            type = "SurveyTemplate";
        } else {
            type = "";
        }
        // call api to save record via php
        var url = App.api.buildURL("bc_survey", "get_survey", "", {record_id: record_id, type: type});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data) {
                    var survey_details = $.parseJSON(data);
                    self.survey_details = JSON.stringify(survey_details);
                    if (editFlag == 1) {
                        self.editview_data('', '', '', JSON.stringify(survey_details));
                        self.themeDetailView();
                    } else {
                        self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').hide(); // show side-pane page-component
                        self.detailview_data('', JSON.stringify(survey_details), is_loading);
                    }
                }
            }
        });
    },
    /**
     * Set survey Pages if created from template
     * 
     * @CopyFromTemplate is set to 1 then prefill data with given details
     * @record_id prefill surveypages by retrieving data from this id
     */
    detailView_copyFromTemplate: function (CopyFromTemplate, record_id, prefill_type) {
        var self = this;
        var type = self.module;
        if (prefill_type && prefill_type == 'bc_survey')
        {
            type = "";
        } else if (type == 'bc_survey_template' || CopyFromTemplate == 1) {
            type = "SurveyTemplate";
        } else {
            type = "";
        }
        // call api to save record via php
        var url = App.api.buildURL("bc_survey", "get_survey", "", {record_id: record_id, type: type});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data) {
                    var survey_details = $.parseJSON(data);
                    self.survey_details = JSON.stringify(survey_details);
                    if (CopyFromTemplate) {
                        self.editview_data('', false, CopyFromTemplate, JSON.stringify(survey_details));
                    }
                    delete localStorage['isLoadingFromTemplate'];
                }
            }
        });
    },
    /**
     * edit page data on click of edit icon located on page header
     * 
     * @el current element
     */
    edit_page_clicked: function (el) {

        if (this.individualEdit)
        {
            app.alert.show('error', {
                level: 'error',
                messages: 'You must submit the currently opened page before editing other page.',
                autoClose: true
            });
        } else {
            document.getElementById('new-page').ondragstart = function () {
                return false;
            };
            this.model.editAllPages = false;
            this.individualEdit = true;
            var self = this;
            self.counter = 0;
            if (self.model && self.model.get('survey_type') == 'poll')
            {
                var sent_msg = 'This Poll Is Now Active and Cannot Be Edited, Please Create a New Poll.';
            } else {
                var sent_msg = 'This Survey Is Now Active and Cannot Be Edited, Please Create a New Survey.';
            }
            var url = App.api.buildURL("bc_survey", "isSurveySend", "", {record: self.record_id});
            App.api.call('GET', url, {}, {
                success: function (data) {
                    if (data && data['restrict_edit'] == "1") { // survey is send so disable all kind of edit of page
                        self.$el.parents('.main-pane').find('[name="edit_button"]').addClass('disabled');
                        self.restrictEdit = "true";
                    } else { // survey is not send so enable all kind of edit
                        self.restrictEdit = "false";
                    }

                    if (self.restrictEdit == "true") {
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
                        var id = el.currentTarget.id;
                        var edit_flag = 1;
                        self.editview_data(id, true, '', self.survey_details);
                        if ((self.model && self.model.get('survey_type') != 'poll') || (self.context && !self.context.attributes.IsPOll))
                        {
                            self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').show(); // show side-pane page-component
                        }
                        if ((self.model && self.model.get('survey_type') == 'poll') || (self.context && self.context.attributes.IsPOll))
                        {
                            self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').show(); // show side-pane page-component
                            self.$el.parents('.main-pane').next('.sidebar-content').find('.page_component').hide();
                            self.$el.parents('.main-pane').next('.sidebar-content').find('#page_component_inner').hide();
                            self.$el.parents('.main-pane').next('.sidebar-content').find('#custom_theme_inner').show();
                        }

                        self.show_save_button(); // show save / cancel button
                    }
                }
            });

        }
    },
    /**
     * remove icon of page clicked on confirmation remove the page
     * 
     * @el current element
     */
    remove_page_clicked: function (el) {

        var self = this;
        //fetch id of remove icon clicked 
        var val = el.currentTarget.id;
        //remove pages
        var current_page_count = self.$el.parents('.main-pane').find('.thumbnail_page').length; // current page count
        if (current_page_count > 1) {
            app.alert.show('remove_page', {
                level: 'confirmation',
                messages: "Are you sure want to remove this page ?",
                onConfirm: function () {
                    // Get Ids of pages which were deleted while edit mode

                    var id = 'page_' + val.split('_')[2];
                    var remove_page_id = self.$el.parents('.main-pane').find('#' + id).find('.page_id').val();
                    if (remove_page_id) {
                        self.remove_page_ids.push(remove_page_id);
                    }
                    //fetch id of page div to remove current page
                    var page_id = '#page_' + val.split('_')[2];
                    self.$el.parents('.main-pane').find(page_id).remove(); // remove page 
                },
                onCancel: function () {
                },
                autoClose: false
            });
        }
        // If only one page exists then do not remove it
        else {
            app.alert.show('remove_page', {
                level: 'error',
                messages: "You have to set atleast one page.",
                autoClose: true
            });
        }
    },
    /**
     *remove icon of question or option clicked on confirmation remove the question or option
     *
     *@el current element
     */
    remove_icon_clicked: function (el) {

        var self = this;
        //fetch id of remove icon clicked 
        var val = el.currentTarget.id;
        if (!val) {
            val = el.currentTarget.parentElement.id;
        }

        //remove questions
        if (val.search("remove_que_") >= 0) {
            //fetch id of question div to remove current question
            var que_id = '.que_' + val.split('_')[2];
            if (self.$el.parents('.main-pane').find(que_id).prev().hasClass('question-section') && (!self.$el.parents('.main-pane').find(que_id).next().hasClass('question') || self.$el.parents('.main-pane').find(que_id).next().hasClass('question-section')))
            {
                app.alert.show('remove_question', {
                    level: 'confirmation',
                    messages: "Removing this question will also remove its Section Header. Are you sure want to remove this question ?",
                    onConfirm: function () {
                        var id = 'que_' + val.split('_')[2];
                        var remove_que_id = self.$el.parents('.main-pane').find('.' + id).find('.que_id').val();
                        if (remove_que_id) {
                            self.remove_que_ids.push(remove_que_id);
                        }
                        self.$el.parents('.main-pane').find(que_id).prev().remove(); // remove above question section
                        self.$el.parents('.main-pane').find(que_id).remove(); // remove question
                    },
                    onCancel: function () {
                    },
                    autoClose: false
                });
            } else {
                app.alert.show('remove_question', {
                    level: 'confirmation',
                    messages: "Are you sure want to remove this question ?",
                    onConfirm: function () {
                        var id = 'que_' + val.split('_')[2];
                        var remove_que_id = self.$el.parents('.main-pane').find('.' + id).find('.que_id').val();
                        if (remove_que_id) {
                            self.remove_que_ids.push(remove_que_id);
                        }

                        self.$el.parents('.main-pane').find(que_id).remove(); // remove question
                    },
                    onCancel: function () {
                    },
                    autoClose: false
                });
            }
        }
        //remove options
        if (val.search("remove_option_") >= 0) {
            var id = 'option_' + val.split('_')[2];
            var remove_option_id = self.$el.parents('.main-pane').find('#' + id).find('input').attr('id');
            if (remove_option_id != '') {
                self.remove_option_ids.push(remove_option_id); // store id of option to be removed while edit record
            }
        }
    },
    /**
     *add new page via button clicked to add new page at bottom
     */
    addNewPageButton: function () {
        var self = this;
        if (self.individualEdit)
        {
            app.alert.show('error', {
                level: 'error',
                messages: 'You must submit the currently opened page before adding new page.',
                autoClose: true
            });
        } else {
            self.page_counter++;
            var new_page_html = self.new_page_html();
            self.$el.parents('.main-pane').find('.SurveyPage').before(new_page_html);
            // to make newly added page droppable 
            self.makePageDroppable();
        }
    },
    /**
     * Called when Drag and drop element from the right pane 
     */
    makeDraggable: function () {
        var self = this;
        //drag page and question 
        $('.new-page,.textbox,.commentbox,.multiselectlist,.check-box,.dropdownlist,.radio-button,.contact-information,.rating-survey,.date-time,.scale,.matrix,.survey-image,.survey-video,.doc-attachment,.boolean,.additional-text,.richtextareabox,.netpromoterscore,.emojis').draggable({
            helper: "clone",
            revert: "invalid",
        });
        self.makePageDroppable();
        $(".Survey_Pages").droppable({
            accept: '.new-page',
            hoverClass: "droppable-hover", /* highlight the current drop zone */
            drop: function (e, ui) {
                $(this).addClass(ui.draggable);
                self.page_counter++;
                var new_page_html = self.new_page_html();
                self.$el.parents('.main-pane').find('.SurveyPage').before(new_page_html);

                // to make newly added page droppable 
                self.makePageDroppable();
            },
        }).sortable({tolerance: "pointer", zIndex: 9999, opacity: 0.8, items: '> div:not(.SurveyPage)', stop: function (event, ui) {

                var isTwiceSection = false;
                var sectionCounter = 0;
                var lastElement = '';
                // check recursively for question section applied only once for the question
                $.each($(ui.item).parents('.data-page').find('.question'), function () {
                    if ($(this).hasClass('question-section')) {
                        sectionCounter++;
                        if (sectionCounter == 2)
                        {
                            isTwiceSection = true;
                        }
                        lastElement = 'question-section';
                    } else {
                        sectionCounter = 0;
                        lastElement = 'question';
                    }
                });
                // check last element must be a question not a  question section
                if (lastElement == 'question-section')
                {
                    isTwiceSection = true;
                }
                if (($(ui.item).hasClass('question-section') && ($(ui.item).prev().hasClass('question-section') || $(ui.item).next().hasClass('question-section') || $(ui.item).next().attr('id') == 'placeholder')) || isTwiceSection) {

                    $(this).sortable('cancel');
                    // Show an error...
                    app.alert.show('error_sorting', {
                        level: 'error',
                        messages: 'Section Header Block already exists or Section Header Block misplaced by this sorting. You can not drop section here.',
                        autoClose: false
                    });
                }
            }});
    },
    /**
     * make all pages as droppable to drop page component 
     */
    makePageDroppable: function () {
        var self = this;
        var muti_choice_que_type = ''; // store question type 
        var multi_choice_que = ''; // flag to define whether current que is multi choice type or not
        $(".data-page").droppable
                ({
                    accept: '.textbox,.commentbox,.multiselectlist,.check-box,.dropdownlist,.radio-button,.contact-information,.rating-survey,.date-time,.scale,.matrix,.survey-image,.survey-video,.doc-attachment,.boolean,.additional-text,.richtextareabox,.netpromoterscore,.emojis',
                    activeClass: "droppable-hover", /* highlight the current drop zone */
                    drop: function (e, ui) {
                        $(this).addClass(ui.draggable);
                        $(this).removeClass('error-custom');
                        var data = '';
                        $d = $(ui.draggable).clone();
                        var current_drop = $d.attr('class'); // class of current dropped element
                        if (current_drop.includes("textbox") == true) {
                            // tab for advance option & general option
                            data += self.general_option_textbox(self.que_counter);
                            //set other advanced option for textbox
                            var questions = {'que_type': 'textbox'};
                            data += self.editviewTextBox(self.que_counter, questions);
                            data += "</div>";
                            data += "</div>";
                        }

                        if (current_drop.includes("commentbox") == true) {
                            data += self.general_option_commentbox(self.que_counter);
                            //set other advanced option for commentbox
                            var questions = {'que_type': 'commentbox'};
                            data += self.editviewCommentBox(self.que_counter, questions);
                            data += "</div>";
                            data += "</div>";
                        }
                        if (current_drop.includes("richtextareabox") == true) {
                            data += self.general_option_richtextareabox(self.que_counter);
                            //set other advanced option for richtextareabox
                            var questions = {'que_type': 'richtextareabox'};
                            data += self.editviewRichTextBox(self.que_counter, questions);
                            data += "</div>";
                            data += "</div>";
                        }
                        // govind
                        if (current_drop.includes("boolean") == true) {
                            data += self.general_option_boolean(self.que_counter);
                            //set other advanced option for commentbox
                            var questions = {'que_type': 'boolean'};
                            data += self.editviewBoolean(self.que_counter, questions);
                            data += "</div>";
                            data += "</div>";
                        }

                        if (current_drop.includes("multiselectlist") == true) {
                            muti_choice_que_type = "multiselectlist";
                            multi_choice_que = true;
                        }

                        if (current_drop.includes("check-box") == true) {
                            muti_choice_que_type = "check-box";
                            multi_choice_que = true;
                        }

                        if (current_drop.includes("dropdownlist") == true) {
                            muti_choice_que_type = "dropdownlist";
                            multi_choice_que = true;
                        }

                        if (current_drop.includes("radio-button") == true) {
                            muti_choice_que_type = "radio-button";
                            multi_choice_que = true;
                        }

                        if (multi_choice_que == true) {
                            var display_data = self.general_option_multichoice(self.que_counter, muti_choice_que_type);
                            data += display_data['html'];
                            //set other advanced option for multi choice type of question
                            var questions = {'que_type': muti_choice_que_type};
                            data += self.editviewMultiChoice(self.que_counter, questions);
                            data += "</div>";
                            data += "</div>";
                            multi_choice_que = '';
                        }

                        if (current_drop.includes("contact-information") == true) {
                            data += self.general_option_contactInformation(self.que_counter);
                            //set other advanced option for contact-information
                            var questions = {'que_type': 'contact-information'};
                            data += self.editviewContactInformation(self.que_counter, questions);
                            data += "</div>";
                            data += "</div>";
                        }

                        if (current_drop.includes("rating-survey") == true) {
                            data += self.general_option_rating(self.que_counter);
                            //set other advanced option for rating
                            var questions = {'que_type': 'rating'};
                            data += self.editviewRating(self.que_counter, questions);
                            data += "</div>";
                            data += "</div>";
                        }

                        if (current_drop.includes("date-time") == true) {
                            data += self.general_option_datetime(self.que_counter);
                            //set other advanced option for date-time
                            var questions = {'que_type': 'date-time'};
                            data += self.editviewDatetime(self.que_counter, questions);
                            data += "</div>";
                            data += "</div>";
                        }

                        if (current_drop.includes("survey-video") == true) {
                            data += self.general_option_video(self.que_counter);
                            //set other advanced option for video
                            var questions = {'que_type': 'video'};
                            data += self.editviewVideo(self.que_counter, questions);
                            data += "</div>";
                            data += "</div>";
                        }

                        if (current_drop.includes("survey-image") == true) {
                            data += self.general_option_image(self.que_counter);
                            //set other advanced option for image
                            var questions = {'que_type': 'image'};
                            data += self.editviewImage(self.que_counter, questions);
                            data += "</div>";
                            data += "</div>";
                        }

                        if (current_drop.includes("scale") == true) {
                            data += self.general_option_scale(self.que_counter);
                            //set other advanced option for scale
                            var questions = {'que_type': 'scale'};
                            data += self.editviewScale(self.que_counter, questions);
                            data += "</div>";
                            data += "</div>";
                        }

                        // New Question Component; NPS
                        if (current_drop.includes("netpromoterscore") == true) {
                            data += self.general_option_netpromoterscore(self.que_counter);
                            //set other advanced option for richtextareabox
                            var questions = {'que_type': 'netpromoterscore'};
                            data += self.editviewNetPromoterScore(self.que_counter, questions);
                            data += "</div>";
                            data += "</div>";
                        }

                        // New Question Component; Emojis
                        if (current_drop.includes("emojis") == true) {
                            data += self.general_option_emojis(self.que_counter);
                            //set other advanced option for richtextareabox
                            var questions = {'que_type': 'emojis'};
                            data += self.editviewEmojis(self.que_counter, questions);
                            data += "</div>";
                            data += "</div>";
                        }

                        if (current_drop.includes("matrix") == true) {
                            data += self.general_option_matrix(self.que_counter);
                            //set other advanced option for textbox
                            var questions = {'que_type': 'matrix'};
                            data += self.editviewMatrix(self.que_counter, questions);
                            data += "</div>";
                            data += "</div>";
                            multi_choice_que = '';
                        }

                        if (current_drop.includes("doc-attachment") == true) {
                            data += self.general_option_docattachment(self.que_counter);
                            //set other advanced option for doc-attachment
                            var questions = {'que_type': 'doc-attachment'};
                            data += self.editviewDocAttachment(self.que_counter, questions);
                            data += "</div>";
                            data += "</div>";
                        }

                        if (current_drop.includes("additional-text") == true) {
                            data += self.general_option_additionalText(self.que_counter);

                            multi_choice_que = '';
                        }


                        $(this).find('#placeholder').before(data);
                        // Attachment Question Type: To convert dropdown into multiselect File Extension and decrease dropdown width for File size. By Govind. On 13-02-2019
                        self.$el.parents('.main-pane').find('#doc-attachment_' + self.que_counter).find('#file_extension_' + self.que_counter).select2({
                            width: '100%',
                            minimumResultsForSearch: 7,
                            closeOnSelect: false,
                            containerCssClass: 'select2-choices-pills-close'
                        });
                        self.$el.parents('.main-pane').find('#doc-attachment_' + self.que_counter).find('#file_size_' + self.que_counter).select2({
                            width: '100%',
                            minimumResultsForSearch: 7,
                            closeOnSelect: false,
                            containerCssClass: 'select2-choices-pills-close'
                        });
                        self.$el.parents('.main-pane').find('#doc-attachment_' + self.que_counter).find('#s2id_file_size_' + self.que_counter).css('width', '70%');
                        // End
                        $.each($('.no_data'), function () {
                            $(this).parents('.question').find('.disable_piping_question').attr('checked', 'checked');
                            $(this).parents('.question').find('.sync_field').hide();
                        });
                        // To create rich text area after drop Rich Text Box Component
                        if (current_drop.includes("richtextareabox") == true) {
                            self.convertIntoRichTextBox('question_richtextareabox_' + self.que_counter);
                        }
                        // End
                        //initially hide the advanced option for datatype
                        self.$el.parents('.main-pane').find('.que_' + self.que_counter).find('.advance_options').hide();
                        self.$el.parents('.main-pane').find('.que_' + self.que_counter).find('.piping_options').hide();
                        self.$el.parents('.main-pane').find('.que_' + self.que_counter).find('.minmax').hide();
                        self.$el.parents('.main-pane').find('.que_' + self.que_counter).find('.precision').hide();
                        self.$el.parents('.main-pane').find('.que_' + self.que_counter).find('.requiredFields').hide();
                        self.$el.parents('.main-pane').find('.que_' + self.que_counter).find('.SurveyImageurl').hide();
                        self.$el.parents('.main-pane').find('.que_' + self.que_counter).find('.uploadedImage').hide();
                        //initially select default required fields for contact-information
                        self.$el.parents('.main-pane').find('.que_' + self.que_counter).find("[name=Name_" + self.que_counter + "]").prop('checked', 'checked');
                        self.$el.parents('.main-pane').find('.que_' + self.que_counter).find("[name=Email_" + self.que_counter + "]").prop('checked', 'checked');
                        self.$el.parents('.main-pane').find('.que_' + self.que_counter).find("[name=Phone_" + self.que_counter + "]").prop('checked', 'checked');
                        //update question counter
                        self.que_counter++;
                    },
                }).sortable({tolerance: "pointer", zIndex: 9999, opacity: 0.8, items: '> div:not(#placeholder)', stop: function (event, ui) {

                // To resolve Richtext content loss issue while sorting. By GSR.
                var typeQueArr = ui.item.context.id.split("_");
                var typeQa = typeQueArr['0'];
                var qCount = typeQueArr['1'];
                if (typeQa == 'richtextareabox') {
                    self.convertIntoRichTextBox('question_richtextareabox_' + qCount);
                }
                // End
                var isTwiceSection = false;
                var sectionCounter = 0;
                var lastElement = '';
                $.each($(ui.item).parents('.data-page').find('.question'), function () {
                    if ($(this).hasClass('question-section')) {
                        sectionCounter++;
                        if (sectionCounter == 2)
                        {
                            isTwiceSection = true;
                        }
                        lastElement = 'question-section';
                    } else {
                        sectionCounter = 0;
                        lastElement = 'question';
                    }
                });
                if (lastElement == 'question-section')
                {
                    isTwiceSection = true;
                }
                if (($(ui.item).hasClass('question-section') && ($(ui.item).prev().hasClass('question-section') || $(ui.item).next().hasClass('question-section') || $(ui.item).next().attr('id') == 'placeholder')) || isTwiceSection) {

                    $(this).sortable('cancel');
                    // Show an error...
                    app.alert.show('error_sorting', {
                        level: 'error',
                        messages: 'Section Header Block already exists or Section Header Block misplaced by this sorting. You can not drop section here.',
                        autoClose: false
                    });
                }
            }});
    },
    /**
     * set piping option for question
     * 
     * @el current element
     */
    show_piping_option: function (el) {
        var self = this;
        //Check piping is enabled or not
        if (self.$el.parents('.main-pane').find('[data-fieldname=enable_data_piping]').find('[type=checkbox]:checked').length != 0)
        {
            var que_name = el.currentTarget.parentElement.parentElement.parentElement.parentElement.parentElement.classList[0];
            // check whether radio button type has Image option selected or not
            if (self.$el.parents('.main-pane').find('.' + que_name).find('.isImageOption').length != 0 && self.$el.parents('.main-pane').find('.' + que_name).find('.isImageOption').find('input[type=checkbox]:checked').length == 1) {
                self.$el.parents('.main-pane').find('.' + que_name).find('.piping_options').hide();
                self.$el.parents('.main-pane').find('.' + que_name).find('.piping_options').find('.disable_piping_question').prop('checked', true);
                self.$el.parents('.main-pane').find('.' + que_name).find('.piping_options').find('.sync_field').hide();

                self.$el.parents('.main-pane').find('.' + que_name).find('.piping').removeClass('active');
                app.alert.show('piping_not_enabled', {
                    level: 'info',
                    messages: "Data Piping is not allowed when Image Option feature is enabled.",
                    autoClose: true
                });
            } else {
                self.$el.parents('.main-pane').find('.' + que_name).find('.piping').addClass('active');
                self.$el.parents('.main-pane').find('.' + que_name).find('.advance').removeClass('active');
                self.$el.parents('.main-pane').find('.' + que_name).find('.general').removeClass('active');
                self.$el.parents('.main-pane').find('.' + que_name).find('.skip_logic').removeClass('active');
                self.$el.parents('.main-pane').find('.' + que_name).find('.change_type_skip_logic').removeClass('active');
                self.$el.parents('.main-pane').find('.' + que_name).find('.general_options').hide();
                self.$el.parents('.main-pane').find('.' + que_name).find('.advance_options').hide();
                self.$el.parents('.main-pane').find('.' + que_name).find('.skip_logic_options').hide();
                self.$el.parents('.main-pane').find('.' + que_name).find('.piping_options').fadeIn();
            }
        } else {
            self.$el.parents('.main-pane').find('.' + que_name).find('.piping_options').hide();
            self.$el.parents('.main-pane').find('.' + que_name).find('.piping').removeClass('active');
            app.alert.show('piping_not_enabled', {
                level: 'info',
                messages: "Data Piping is not enabled for this survey. Please check \"Enable Piping\" checkbox to enable data piping feature.",
                autoClose: true
            });
        }
    },
    /**
     *  set general option for question
     *  
     *  @el current element
     */
    show_general_option: function (el) {
        var self = this;
        var que_name = el.currentTarget.parentElement.parentElement.parentElement.parentElement.parentElement.classList[0];
        //show general options & hide advance options
        self.$el.parents('.main-pane').find('.' + que_name).find('.general').addClass('active');
        self.$el.parents('.main-pane').find('.' + que_name).find('.piping').removeClass('active');
        self.$el.parents('.main-pane').find('.' + que_name).find('.piping_options').hide();
        self.$el.parents('.main-pane').find('.' + que_name).find('.advance_options').hide();
        self.$el.parents('.main-pane').find('.' + que_name).find('.skip_logic_options').hide();
        self.$el.parents('.main-pane').find('.' + que_name).find('.general_options').fadeIn();
        self.$el.parents('.main-pane').find('.' + que_name).find('.advance').removeClass('active');
        self.$el.parents('.main-pane').find('.' + que_name).find('.skip_logic').removeClass('active');
        self.$el.parents('.main-pane').find('.' + que_name).find('.change_type_skip_logic').removeClass('active');
    },
    /**
     * set advance option for question
     * 
     * @el current element
     */
    show_advance_option: function (el) {
        var self = this;
        var que_name = el.currentTarget.parentElement.parentElement.parentElement.parentElement.parentElement.classList[0];
        self.$el.parents('.main-pane').find('.' + que_name).find('.advance').addClass('active');
        self.$el.parents('.main-pane').find('.' + que_name).find('.piping').removeClass('active');
        self.$el.parents('.main-pane').find('.' + que_name).find('.general').removeClass('active');
        self.$el.parents('.main-pane').find('.' + que_name).find('.skip_logic').removeClass('active');
        self.$el.parents('.main-pane').find('.' + que_name).find('.change_type_skip_logic').removeClass('active');
        self.$el.parents('.main-pane').find('.' + que_name).find('.general_options').hide();
        self.$el.parents('.main-pane').find('.' + que_name).find('.piping_options').hide();
        self.$el.parents('.main-pane').find('.' + que_name).find('.skip_logic_options').hide();
        self.$el.parents('.main-pane').find('.' + que_name).find('.advance_options').fadeIn();
    },
    /**
     *  show advance option as per datatype selected for textbox
     *  
     *  @el current element
     */
    show_advance_input: function (el) {
        var self = this;
        if (el && el.type && el.type == 'click')
        {
            var sel_datatype = el.currentTarget.value;
            var que_count = el.currentTarget.name.split('_')[2];
        } else {
            var sel_datatype = $(el).val();
            var que_count = $(el).attr('name').split('_')[2];
        }
        // show min max range selection if Integer datatype selected for textbox
        if (sel_datatype == 'Integer') {
            self.$el.parents('.main-pane').find('[name=min_textbox_' + que_count + ']').parents('.minmax').show();
            self.$el.parents('.main-pane').find('[name=min_textbox_' + que_count + ']').val('');
            self.$el.parents('.main-pane').find('[name=max_textbox_' + que_count + ']').val('');
            self.$el.parents('.main-pane').find('[name=precision_textbox_' + que_count + ']').parents('.precision').hide();
            self.$el.parents('.main-pane').find('[name=min_textbox_' + que_count + ']').parents('.question').find('.maxsize').hide();
            $.each(self.$el.parents('.main-pane').find('[name=min_textbox_' + que_count + ']').parents('.minmax').find('.decimalField'), function () {
                {
                    self.$el.parents('.main-pane').find('[name=min_textbox_' + que_count + ']').parents('.minmax').find('.decimalField').removeClass('decimalField').addClass('numericField');
                }
            });
        }
        // show precision input if float is selected
        else if (sel_datatype == 'Float')
        {
            self.$el.parents('.main-pane').find('[name=precision_textbox_' + que_count + ']').parents('.precision').show();
            self.$el.parents('.main-pane').find('[name=min_textbox_' + que_count + ']').parents('.minmax').show();
            self.$el.parents('.main-pane').find('[name=min_textbox_' + que_count + ']').val('');
            self.$el.parents('.main-pane').find('[name=max_textbox_' + que_count + ']').val('');
            $.each(self.$el.parents('.main-pane').find('[name=min_textbox_' + que_count + ']').parents('.minmax').find('.numericField'), function () {
                {
                    self.$el.parents('.main-pane').find('[name=min_textbox_' + que_count + ']').parents('.minmax').find('.numericField').removeClass('numericField').addClass('decimalField');
                }
            });
            self.$el.parents('.main-pane').find('[name=min_textbox_' + que_count + ']').parents('.question').find('.maxsize').hide();
        }
        // show precision input if float is selected
        else if (sel_datatype == 'Email')
        {
            self.$el.parents('.main-pane').find('[name=precision_textbox_' + que_count + ']').parents('.precision').hide();
            self.$el.parents('.main-pane').find('[name=min_textbox_' + que_count + ']').parents('.minmax').hide();
            self.$el.parents('.main-pane').find('[name=min_textbox_' + que_count + ']').parents('.question').find('.maxsize').hide();
        }
        // hide precision & min max input
        else {
            self.$el.parents('.main-pane').find('[name=min_textbox_' + que_count + ']').parents('.question').find('.maxsize').show();
            self.$el.parents('.main-pane').find('[name=min_textbox_' + que_count + ']').parents('.minmax').hide();
            self.$el.parents('.main-pane').find('[name=precision_textbox_' + que_count + ']').parents('.precision').hide();
        }
    },
    /**
     *  add new page html to survey page
     */
    new_page_html: function () {
        var self = this;
        var new_page_html = '';
        new_page_html += "<div id='page_" + self.page_counter + "' class='thumbnail thumbnail_page dashlet ui-draggable' data-type='dashlet' style='margin-top:10px;margin-bottom:10px;' data-action='droppable'>";
        new_page_html += "<div data-dashlet = 'toolbar' > <div class = 'dashlet-header'><div class = 'btn-toolbar pull-right'>";
        // page configuration action dropdown
        //remove option default show
        new_page_html += "<div class = 'btn-group' style='margin-top:5px;'><a class='btn remove_page' id='remove_page_" + self.page_counter + "'><i data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i>&nbsp; Remove </a>\n\
                          <a class='btn dropdown-toggle' data-toggle='dropdown'> <i class='fa fa-caret-down'></i></a>";
        new_page_html += '<ul class="dropdown-menu left setting-action" id="setting-action_' + self.page_counter + '">';
        new_page_html += '        <div>';
        //add page above the current page option
        new_page_html += '                        <li><span sfuuid="44" class="dashlet-toolbar add_page_above">';
        new_page_html += '<a href="javascript:void(0);" id="add_page_above_' + self.page_counter + '">';
        new_page_html += '    <i class="fa  fa-angle-double-up">&nbsp;Add Page Above</i></a>';
        new_page_html += '</span></li>';
        //add page below the current page option
        new_page_html += '                        <li><span sfuuid="45" class="dashlet-toolbar add_page_below">';
        new_page_html += '<a href="javascript:void(0);"  id="add_page_below_' + self.page_counter + '">';
        new_page_html += '    <i class="fa  fa-angle-double-down">&nbsp;Add Page Below</i></a>';
        new_page_html += '</span></li>';
        new_page_html += '        </div>';
        new_page_html += '    </ul>';
        new_page_html += "</div>";
        new_page_html += '<div class="btn-group" style="margin-top:5px;"><a id=' + self.page_counter + ' data-toggle="dropdown" rel="tooltip" title="" class="dropdown-toggle btn btn-invisible page_toggle" data-placement="bottom" data-original-title="Toggle Visibility"><i data-action="loading" class="fa fa-chevron-up" track="click:dashletToolbarCog"></i></a></div>';
        // Page Title
        new_page_html += "</div><h4 data-toggle = \"dashlet\" style='min-height:20px; background-color: #c5c5c5;' class = \"dashlet-title\" >";
        new_page_html += "      <div class=''> ";
        new_page_html += "          <input id='txt_page_title' name='txt_page_title' placeholder='(Required) Page Title' style='z-index:1; width:70%;height:20%; padding:4px; border-radius:3px;'/>";
        new_page_html += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        new_page_html += "      </div>";
        new_page_html += "    </h4></div></div>";
        // Page Droppable Area
        new_page_html += "<div id='data-page_" + self.page_counter + "' class='data-page' data-dashlet = 'dashlet' style='min-height:100px;'  ><div id='placeholder' style=' border: 1px dashed #c6c6c6;height: 80px;  color:#c6c6c6; padding: 0px;  margin:10px;'><p style='padding-top:25px;' align='center'>To add a question, simply drag it from the Page Component.</p></div></div></div>";
        return new_page_html;
    },
    showQuestionSectionClicked: function (el) {

        var self = this;
        if (!$(el.currentTarget).parents('a').hasClass('disabled') && !$(el.currentTarget).parents('.question').prev('div').hasClass('question-section'))
        {
            var survey_data = '';
            survey_data += '<div id="section_' + self.que_counter + '" class=" question question-section " style="min-height:20px !important; border-radius: 10px 10px 0px 0px;">';
            survey_data += '<div class="row">';
            survey_data += '                    <div class="span1">Section Title</div>';
            survey_data += '                    <div class="span10">';
            survey_data += '                        <input type="text" placeholder="(Required) Section Title" id="section_title" class="inherit-width" style="margin-top:0; width:95%;"/>';
            survey_data += '                         <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
            survey_data += '                    </div>';
            survey_data += '                    <div class="span1"><div class="btn" style="margin-bottom:2px;"><i class="fa fa-times remove-section" title="Remove Section Header"></i></div></div>';
            survey_data += '</div>';
            $(el.currentTarget).parents('.question').before(survey_data);
            //  $(el.currentTarget).parents('a').addClass('disabled');
            self.que_counter++;
        } else {
            app.alert.show('section_exists', {
                level: 'error',
                messages: "Section Header Block already exists for this question.",
                autoClose: true
            });
        }
    },
    removeSectionHeader: function (el) {
        app.alert.show('remove_options', {
            level: 'confirmation',
            messages: "Are you sure want to remove this section ?",
            onConfirm: function () {
                var sibling_question = $(el.currentTarget).parents('.question-section').next('.question');
                //  $(sibling_question).find('.add_section_header').find('a').removeClass('disabled');
                $(el.currentTarget).parents('.question-section').remove();
            },
        });
    },
    /**
     *  add page above option clicked from page top section
     *  
     *  @el current element
     */
    add_page_aboveClicked: function (el) {
        var self = this;
        if (this.individualEdit)
        {
            app.alert.show('error', {
                level: 'error',
                messages: 'You must submit currently opened page before adding new page.',
                autoClose: true
            });
        } else {
            var currentpage_id = el.currentTarget.childNodes[0].id;
            // update the page counter
            this.page_counter++;
            var html = this.new_page_html();
            self.$el.parents('.main-pane').find("#" + currentpage_id).parents('div .thumbnail').before(html); // add page above current page
            //make recently added page droppable
            this.makeDraggable();
        }
    },
    /**
     *  add page below option clicked from page top section
     *  
     *  @el current element
     */
    add_page_belowClicked: function (el) {
        var self = this;
        if (this.individualEdit)
        {
            app.alert.show('error', {
                level: 'error',
                messages: 'You must submit currently opened page before adding new page.',
                autoClose: true
            });
        } else {
            var currentpage_id = el.currentTarget.childNodes[0].id;
            // update the page counter
            this.page_counter++;
            var html = this.new_page_html();
            self.$el.parents('.main-pane').find("#" + currentpage_id).parents('div .thumbnail').after(html); // add page below current page
            //make recently added page droppable
            this.makeDraggable();
        }
    },
    /**
     *  add option clicked for multi choice type of question
     *  
     *  @el current element
     */
    add_option_clicked: function (el) {

        var self = this;
        var que_type = el.currentTarget.className.split(' ')[2];
        que_type = que_type.split('_')[0];
        var op_count = parseInt(el.currentTarget.id);
        var que_id = el.currentTarget.className.split('_')[3];
        self.option_counter = op_count + 1; // update option counter to manage add and delete
        var op_count = el.currentTarget.id;
        if (que_type == 'matrix') {
            var add_type = el.currentTarget.className.split(' ')[2].split('_')[2];
            self.add_matrixClicked(que_id, que_type, op_count, add_type);
        } else if (el.currentTarget.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.id == "edit_view") {
            self.addOption(que_id, que_type, op_count, 1);
        } else {
            self.addOption(que_id, que_type, op_count);
        }
        if (que_type == 'multiselectlist' || que_type == 'check-box')
        {

            // Update Minimim answer limit selection
            var limit_min_selection = $(el.currentTarget).parents('.question').find('.advance_options').find('[name=limit_min_' + que_type + '_' + que_id + ']').children();
            var option_count = 0;
            $.each(limit_min_selection, function () {
                option_count = $(this).val();
            });
            option_count++;
            $(el.currentTarget).parents('.question').find('.advance_options').find('[name=limit_min_' + que_type + '_' + que_id + ']').append('<option value=' + option_count + '>' + option_count + '</option>');
        }
    },
    /**
     * remove option clicked for multi choice type of question
     * 
     * @el current element
     */
    remove_option_clicked: function (el) {

        // remove option for multi choice as well matrix rows and columns
        var self = this;
        var remove_type = el.currentTarget.className.split(' ')[2].split('_')[2];
        app.alert.show('remove_options', {
            level: 'confirmation',
            messages: "Are you sure want to remove this " + remove_type + " ?",
            onConfirm: function () {

                var que_type = el.currentTarget.className.split(' ')[2];
                que_type = que_type.split('_')[0];
                var que_id = el.currentTarget.className.split('_')[3];
                var op_count = el.currentTarget.id;
                if (que_type == 'matrix') {
                    self.remove_matrixClicked(que_id, que_type, op_count, remove_type);
                } else if (el.currentTarget.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.id == "edit_view") {
                    self.removeOption(que_id, que_type, op_count, 1);
                } else {
                    self.removeOption(que_id, que_type, op_count);
                }
                if (que_type == 'multiselectlist' || que_type == 'check-box')
                {
                    // Update Minimim answer limit selection
                    self.$el.parents('.main-pane').find('[name=limit_min_' + que_type + '_' + que_id + ']').children(':last').remove();
                }
            },
            onCancel: function () {
            },
            autoClose: false
        });
    },
    /**
     * add rows & columns for matrix type of question
     * 
     * @que_id current question id
     * @que_type question type matrix
     * @op_count current option count
     * @add_type wnt to add row or column
     * @editmode if current dropping area is editview then append to that view
     */
    add_matrixClicked: function (que_id, que_type, op_count, add_type, editmode) {
        var self = this;
        //add more option to multi select list
        var option_html = '';
        //append remove button if only one option exists
        var remove_button_flag = self.$el.parents('.main-pane').find($('#' + que_type + '_' + add_type + '_div_' + que_id)).find($('.' + que_type + '_remove_' + add_type)).css("display");
        if (remove_button_flag == 'none') {
            self.$el.parents('.main-pane').find($('#' + que_type + '_' + add_type + '_div_' + que_id)).find($('.' + que_type + '_remove_' + add_type + '')).css("display", "");
            ;
        }
        //hide add option button of above option
        var hide_id = self.option_counter - 1;
        self.$el.parents('.main-pane').find($('#' + que_type + '_' + add_type + '_div_' + que_id)).find($('.' + que_type + '_add_' + add_type + '')).each(function () {
            if (op_count == hide_id) {
                self.$el.parents('.main-pane').find($('#' + que_type + '_' + add_type + '_div_' + que_id)).find($('.' + que_type + '_add_' + add_type + '')).css("display", "none");
            }
        });
        // option input and add remove buttons
        option_html += '<div id="' + add_type + '_' + self.option_counter + '" class="' + add_type + 's">';
        option_html += '<input type="text" name="' + add_type + '_' + que_type + '" placeholder="' + add_type + ' label" class="inherit-width" style="margin-top:5px;max-width:50%; margin-left:1px;">';
        option_html += '<a href="javascript:void(0);" class="btn  ' + que_type + '_remove_' + add_type + ' que_' + que_id + '" style = "margin-top:5px;margin-left:5px;" id="' + self.option_counter + '"><i class="fa fa-times"></i></a>';
        option_html += '<a href="javascript:void(0);" class="btn  ' + que_type + '_add_' + add_type + ' que_' + que_id + '" id="' + self.option_counter + '" style="margin-top:5px; margin-left:5px;"><i class="fa fa-plus"></i></a>';
        option_html += '</div>'
        if (editmode == 1) {
            self.$el.parents('.main-pane').find('#edit_view').find($('#' + que_type + '_' + add_type + '_div_' + que_id)).append(option_html);
        } else {
            self.$el.parents('.main-pane').find('#' + que_type + '_' + add_type + '_div_' + que_id).append(option_html);
        }
        self.add_button_clicked_flag++;
        self.option_counter++;
    },
    /**
     * removing rows and columns for matrix type of question
     *      
     * @que_id current question id
     * @que_type question type matrix
     * @op_count current option count
     * @add_type wnt to add row or column
     * @editmode if current dropping area is editview then remove to that view
     */
    remove_matrixClicked: function (que_id, que_type, op_count, remove_type, editmode) {
        var self = this;
        var current_options_count = self.$el.parents('.main-pane').find('#' + que_type + '_' + remove_type + '_div_' + que_id).children('div').length;
        var plus_count = self.$el.parents('.main-pane').find($('#' + que_type + '_' + remove_type + '_div_' + que_id + ' > .' + que_type + '_add_' + remove_type + '')).filter(function () {
            return $(this).css('display') !== 'none';
        }).length;
        if (current_options_count > 1) {
            if (self.$el.parents('.main-pane').find($('#' + que_type + '_' + remove_type + '_div_' + que_id + ' > #' + remove_type + '_' + op_count)).attr('style') != 'display:none;') {
                self.$el.parents('.main-pane').find($('#' + que_type + '_' + remove_type + '_div_' + que_id + ' > #' + remove_type + '_' + op_count)).remove();
                var btn_id = op_count - 1; //adjust css for button
                self.$el.parents('.main-pane').find($('#' + que_type + '_' + remove_type + '_div_' + que_id + ' > #' + remove_type + '_' + btn_id)).find($('.' + que_type + '_remove_' + remove_type + '')).css("display", "");
                //check add button exist or not after deleting current option
                var plus_count = self.$el.parents('.main-pane').find($('#' + que_type + '_' + remove_type + '_div_' + que_id + ' > .' + que_type + '_add_' + remove_type + '')).filter(function () {
                    return $(this).css('display') !== 'none';
                }).length;
                //if remove in-between options then dont show above add button due to add button already exists atlast
                if (plus_count != 1) { //if only one option remain then show add button
                    var show_id = op_count - 1;
                    self.$el.parents('.main-pane').find($('#' + que_type + '_' + remove_type + '_div_' + que_id)).find($('.' + que_type + '_add_' + remove_type + '')).last().css("display", "");
                    ;
                }
                current_options_count = $('#' + que_type + '_' + remove_type + '_div_' + que_id).children('div').length;
                if (current_options_count <= 2) {
                    self.$el.parents('.main-pane').find($('#' + que_type + '_' + remove_type + '_div_' + que_id)).find($('.' + que_type + '_remove_' + remove_type + '')).css("display", "none");
                }
            }
        }
        //hide remove option for option data if only one button is exists while remove button clicked
        if (self.$el.parents('.main-pane').find($('#' + que_type + '_' + remove_type + '_div_' + que_id)).find($('.' + que_type + '_remove_' + remove_type + '')).length == 1) {
            self.$el.parents('.main-pane').find($('#' + que_type + '_' + remove_type + '_' + que_id)).find($('.' + que_type + '_remove_' + remove_type + '')).hide();
        }
    },
    /*
     * Enable scoringweight box to all options of current question
     * 
     * el - current clicked element
     */
    enableScoring: function (el) {

        // get general option div of current clicked element
        var general_option_parent = $(el.currentTarget).parents('.question').find('.general_options');
        // if score is checked
        if ($(el.currentTarget).find('input:checked').length == 1)
        {
            $.each(general_option_parent.find('.options'), function () {
                var id = this.id.split('_')[1];
                $(this).find('.score_weight').show();
            });
            if ($(el.currentTarget).parents('.general_options').find('.enableOther').prop('checked'))
            {
                $(el.currentTarget).parents('.general_options').find('.other_weight').show();
            }
        }
        // if no score
        else {
            $.each(general_option_parent.find('.options'), function () {
                var id = this.id.split('_')[1];
                $(this).find('.score_weight').hide();
            });
            if ($(el.currentTarget).parents('.general_options').find('.enableOther').prop('checked'))
            {
                $(el.currentTarget).parents('.general_options').find('.other_weight').hide();
            }
        }
    },
    /*Show Image Upload inputs when Show Image Option? is checked for Radio Button Question Type
     * 
     * el - current clicked element
     */
    showImageUploadInRadioQue: function (el) {

        // get general option div of current clicked element
        var general_option_parent = $(el.currentTarget).parents('.question').find('.general_options');
        var advance_option_parent = $(el.currentTarget).parents('.question').find('.advance_options');
        // if IsImageOption is checked then show File Uploads
        if ($(el.currentTarget).find('input:checked').length == 1)
        {
            $.each(general_option_parent.find('.options'), function () {
                var id = this.id.split('_')[1];
                $(this).find('.radioImageUpload').show();
                $(this).find('.resetImageRadioUpload').prev('img').show();
                $(this).find('.resetImageRadioUpload').show();
            });

            // show/hide Other option inputs
            general_option_parent.find('.enableOther').parents('.row').hide();
            general_option_parent.find('.enableOther').prop('checked', false);
            general_option_parent.find('.otheroptionRow').hide();

            // show/hide elements from Advance Options
            $(advance_option_parent).find('.hoz_ele').prop('checked', true);
            $(advance_option_parent).find('.ver_ele').hide();
            $(advance_option_parent).find('.showOptionText').show();
            general_option_parent.find('.showOptionText').show();
        }
        // if IsImageOption is not checked then hide File Uploads
        else {
            $.each(general_option_parent.find('.options'), function () {
                var id = this.id.split('_')[1];
                $(this).find('.radioImageUpload').hide();
                $(this).find('.resetImageRadioUpload').prev('img').hide();
                $(this).find('.resetImageRadioUpload').hide();
                $(this).find('.spanRadioUploadError').hide();
            });

            // shode/hide Other option inputs
            general_option_parent.find('.enableOther').parents('.row').show();

            // show/hide elements from Advance Options
            $(advance_option_parent).find('.ver_ele').show();
            $(advance_option_parent).find('.showOptionText').hide();
            general_option_parent.find('.showOptionText').hide();
        }
    },
    /*
     * Reset the Image to select new Radio Image
     * 
     * @param {type} el - current clicked target
     */
    resetImageRadioUpload: function (el) {

        var que_type = $(el.currentTarget).parents('.question').attr('id').split('_')[0];
        // Remove from Normal Option
        $(el.currentTarget).parents('.options').find('img').remove(); // remove image
        var reset_ele = '<input type="file" name="radioImage_' + que_type + '" class="inherit-width radioImageUpload" style="width: 175px;margin-top:5px;max-width:50%; margin-left: 1px;"><span style="margin-left: -13px; margin-top: 6px; position: relative; z-index: 500; width: auto;" class="spanRadioUploadError"><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';

        $(el.currentTarget).replaceWith(reset_ele);
    },
    /**
     * add option clicked for adding more option to multi choice type of question
     *      
     * @que_id current question id
     * @que_type question type matrix
     * @op_count current option count
     * @editmode if current dropping area is editview then append to that view
     */
    addOption: function (que_id, que_type, op_count, editmode) {

        var self = this;
        //add more option to multi select list
        var option_html = '';
        //append remove button if only one option exists
        var remove_button_flag = self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id)).find($('.' + que_type + '_remove_option')).css("display");
        if (remove_button_flag == 'none') {
            self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id)).find($('.' + que_type + '_remove_option')).css("display", "");
            ;
        }
        //hide add option button of above option
        var hide_id = self.option_counter - 1;
        self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id)).find($('.' + que_type + '_add_option')).each(function () {
            if (op_count == hide_id) {
                self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id)).find($('.' + que_type + '_add_option')).css("display", "none");
            }
        });
        //find score enable or not
        var parent_que_div = self.$el.parents('.main-pane').find('#' + que_type + '_options_div_' + que_id).parents('.question').find('.enableScore');
        // weight
        var current_last_weight = self.$el.parents('.main-pane').find('#' + que_type + '_options_div_' + que_id).find('.score_weight:last').val();
        var new_weight = parseInt(current_last_weight) + 1;

        //is image option clicked?
        var is_image_option = self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id)).parents('.general_options').find('.isImageOption').find('input[type=checkbox]:checked').length;
        if (is_image_option == 1) {
            var showFileUpload = '';
        } else {
            var showFileUpload = 'display:none;';
        }

        // option input and add remove buttons
        option_html += '<div id="option_' + self.option_counter + '" class="options">';
        if (que_type == 'radio-button' || que_type == 'check-box') {
            option_html += '<input type="file" name="radioImage_' + que_type + '"  class="inherit-width radioImageUpload" style="width: 175px;margin-top:5px;max-width:50%; margin-left: 1px;' + showFileUpload + '"> <span style="margin-left: -13px; margin-top: 6px; position:relative; z-index:500; display:none; width: auto;" class="spanRadioUploadError"><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        }
        option_html += '<input type="text" name="option_' + que_type + '" placeholder="Option" class="inherit-width" style="margin-top:5px;max-width:50%; margin-left: 3px;">';
        if (parent_que_div.find('input:checked').length == 1)
        {
            option_html += "<input type='number' name='score_" + que_type + "' value='" + new_weight + "' class='inherit-width score_weight' style='max-width:7%; margin-left:4px; margin-top:5px;'>";
        } else {
            option_html += "<input type='number' name='score_" + que_type + "' value='" + new_weight + "' class='inherit-width score_weight' style='max-width:7%; margin-left:4px; margin-top:5px;display:none;'>";
        }
        option_html += '<a href="javascript:void(0);" class="btn  ' + que_type + '_remove_option que_' + que_id + '" style = "margin-top:5px;margin-left:5px;" id="' + self.option_counter + '"><i class="fa fa-times"></i></a>';
        option_html += '<a href="javascript:void(0);" class="btn  ' + que_type + '_add_option que_' + que_id + '" id="' + self.option_counter + '" style="margin-top:5px; margin-left:5px;"><i class="fa fa-plus"></i></a>';
        option_html += '</div>'
        if (editmode == 1) {
            self.$el.parents('.main-pane').find('#edit_view').find($('#' + que_type + '_options_div_' + que_id)).append(option_html);
        } else {
            self.$el.parents('.main-pane').find('#' + que_type + '_options_div_' + que_id).append(option_html);
        }
        self.add_button_clicked_flag++;
        self.option_counter++;
    },
    /**
     * remove option clicked for removing option from multi choice type of question
     *      
     * @que_id current question id
     * @que_type question type matrix
     * @op_count current option count
     * @editmode if current dropping area is editview then remove to that view
     */
    removeOption: function (que_id, que_type, op_count, editmode) {
        var self = this;
        var current_options_count = self.$el.parents('.main-pane').find('#' + que_type + '_options_div_' + que_id).children('div').length;
        var plus_count = self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id + ' > .' + que_type + '_add_option')).filter(function () {
            return $(this).css('display') !== 'none';
        }).length;
        if (current_options_count > 1) {
            // get option id to remove same option tr from logic layout
            var optionID = self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id + ' > #option_' + op_count)).find('input[name=option_' + que_type + ']').attr('id')
            if (optionID == '' || optionID == null) {
                optionID = self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id + ' > #option_' + op_count)).attr('id');
            }
            // End
            if (self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id + ' > #option_' + op_count)).attr('style') != 'display:none;') {
                self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id + ' > #option_' + op_count)).remove();
                // remove same option tr from logic layout
                self.$el.parents('.main-pane').find('#' + que_type + '_' + que_id).find('.skip_logic_options').find('#logicRow_' + optionID).remove();
                // End
                var btn_id = op_count - 1; //adjust css for button
                self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id + ' > #option_' + btn_id)).find($('.' + que_type + '_remove_option')).css("display", "");
                //check add button exist or not after deleting current option
                var plus_count = self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id + ' > .' + que_type + '_add_option')).filter(function () {
                    return $(this).css('display') !== 'none';
                }).length;
                //if remove in-between options then dont show above add button due to add button already exists atlast
                if (plus_count != 1) { //if only one option remain then show add button
                    var show_id = op_count - 1;
                    self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id)).find($('.' + que_type + '_add_option')).last().css("display", "");
                    ;
                }
                current_options_count = $('#' + que_type + '_options_div_' + que_id).children('div').length;
                if (current_options_count <= 2) {
                    self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id)).find($('.' + que_type + '_remove_option')).css("display", "none");
                }
            }
        }
        //hide remove option for option data if only one button is exists while remove button clicked
        if (self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id)).find($('.' + que_type + '_remove_option')).length == 1) {
            self.$el.parents('.main-pane').find($('#' + que_type + '_options_div_' + que_id)).find($('.' + que_type + '_remove_option')).hide();
        }
    },
    /**
     * edit question type icon clicked
     * 
     * @el current element
     */
    edit_que_typeClicked: function (el) {
        var self = this;
        var question_id = '';
        var current_el_id = el.currentTarget.id; // current element
        var current_que_type = current_el_id.split('_')[3]; // current question type
        var current_que_id = current_el_id.split('_')[4]; // current question id

        if (self.$el.parents('.main-pane').find('#' + current_que_type + '_' + current_que_id).find('.que_id').length != 0) {
            //in edit mode current question id of 36 char
            question_id = self.$el.parents('.main-pane').find('#' + current_que_type + '_' + current_que_id).find('.que_id').val();
        }
        var changed_type = self.$el.parents('.main-pane').find('#edit_que_type_' + current_que_type + '_' + current_que_id).val(); // changing question type
        var question = self.$el.parents('.main-pane').find('[name=question_' + current_que_type + '_' + current_que_id + ']').val(); // question title
        if (current_que_type == 'richtextareabox') {
            question = self.$el.parents('.main-pane').find('[name="question_richtextbox_' + current_que_id + '"]').val(); // question title
        }
        var is_required = self.$el.parents('.main-pane').find('[name=is_required_' + current_que_type + '_' + current_que_id + ']').attr('checked'); // is required or not
        var helptips = self.$el.parents('.main-pane').find('[name=helptips_' + current_que_type + '_' + current_que_id + ']').val(); // helptips
        var display_boolean_label = self.$el.parents('.main-pane').find('[name=display_label_' + current_que_type + '_' + current_que_id + ']').val(); // helptips
        if (typeof display_boolean_label != 'undefined' && display_boolean_label != '') {
            localStorage['display_boolean_label'] = display_boolean_label;
        }

        var sync_field = self.$el.parents('.main-pane').find('[name=sync_field_' + current_que_type + '_' + current_que_id + ']').val(); // helptips

        // Multi Choice type of question swap with each other then also save options
        var multichoiceque_array = ['check-box', 'radio-button', 'multiselectlist', 'dropdownlist'];
        // store current option data for the multichoice type of question change internally
        if ($.inArray(current_que_type, multichoiceque_array) != -1 && $.inArray(changed_type, multichoiceque_array) != -1)
        {
            var options_div = self.$el.parents('.main-pane').find('#' + current_que_type + '_' + current_que_id).find('#' + current_que_type + '_options_div_' + current_que_id);
            var answer_detail = new Object();
            var answer_detail_for_skipLogic = new Object();
            var skip_log_obj = {};
            options_div.each(function () {
                var opid = this.id;
                var op_count = 0;
                self.$el.parents('.main-pane').find('#' + opid).find($('[name="option_' + current_que_type + '"]')).each(function () {
                    op_count++;
                    if (this.value.trim() != '') {
                        self.$el.parents('.main-pane').find('#' + opid).find($('[name="option_' + current_que_type + '"]')).attr('style', ' margin-top: 5px;max-width:50%;');
                        if (this.id != "") {
                            answer_detail[this.id] = this.value.trim();
                            skip_log_obj[this.id] = this.value.trim();
                            answer_detail_for_skipLogic[op_count] = skip_log_obj;
                        } else {
                            answer_detail['option_' + op_count] = this.value.trim();
                            skip_log_obj['option_' + op_count] = this.value.trim();
                            answer_detail_for_skipLogic[op_count] = skip_log_obj;
                        }
                    }
                    skip_log_obj = {};
                });
            });
        }

        if (sync_field && sync_field != 'Select Field')
        {
            var answer_detail = new Object();
            var answer_detail_for_skipLogic = new Object();
            var conf_msg = 'Edit question type will override your current data and sync field will be reset. Are you sure that you want to proceed ?';
        } else {
            var conf_msg = 'Edit question type will override your current data. Are you sure that you want to proceed ?';
        }
        app.alert.show('editQue_confirmation', {
            level: 'confirmation',
            title: '',
            messages: conf_msg,
            onConfirm: _.bind(self.confirmEditQueType, self, current_que_type, current_que_id, changed_type, question, is_required, helptips, localStorage['display_boolean_label'], question_id, answer_detail, answer_detail_for_skipLogic),
            onCancel: function () {
                app.alert.dismiss('editQue_confirmation');
                self.removeQueDropdown(current_que_type, current_que_id);
            },
            autoClose: false
        });
    },
    /**
     * if cancel editing question type then reset the current qestion type label & remove question dropdown
     * 
     * @question_type current question type
     * @current_que_id current question id
     */
    removeQueDropdown: function (question_type, current_que_id) {
        var self = this;
        var survey_data = '';
        if (question_type == "textbox") {
            survey_data += '<i class="fa fa-file-text-o" style="font-size:13px;">&nbsp; TextBox </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "commentbox") {
            survey_data += '<i class="fa fa-comments-o" style="font-size:13px;">&nbsp; Comment TextBox</i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "richtextareabox") {
            survey_data += '<i class="fa fa-comment" style="font-size:13px;">&nbsp; Rich TextBox</i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "multiselectlist") {
            survey_data += '<i class="fa fa-list-ul" style="font-size:13px;">&nbsp; MultiSelect List </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "check-box") {
            survey_data += '<i class="fa  fa-check-square-o" style="font-size:13px;">&nbsp; CheckBox </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "boolean") {
            survey_data += '<i class="fa  fa-check" style="font-size:13px;">&nbsp; Boolean </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "dropdownlist") {
            survey_data += '<i class="fa fa-chevron-down" style="font-size:13px;">&nbsp; Dropdown List </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "radio-button") {
            survey_data += '<i class="fa fa-dot-circle-o" style="font-size:13px;">&nbsp; Radio Button </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "contact-information") {
            survey_data += '<i class="fa fa-list-alt" style="font-size:13px;">&nbsp; Contact Information </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "rating") {
            survey_data += '<i class="fa fa-star" style="font-size:13px;">&nbsp; Rating </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "date-time") {
            survey_data += '<i class="fa fa-calendar" style="font-size:13px;">&nbsp; DateTime </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "image") {
            survey_data += '<i class="fa fa-picture-o" style="font-size:13px;">&nbsp; Image </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "video") {
            survey_data += '<i class="fa fa-video-camera" style="font-size:13px;">&nbsp; Video </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "scale") {
            survey_data += '<i class="fa fa-arrows-h" style="font-size:13px;">&nbsp; Scale </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "matrix") {
            survey_data += '<i class="fa fa-th" style="font-size:13px;">&nbsp; Matrix </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "doc-attachment") {
            survey_data += '<i class="fa fa-paperclip" style="font-size:13px;">&nbsp; Attachment </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "netpromoterscore") {
            survey_data += '<i class="fa fa-dashboard" style="font-size:13px;">&nbsp; NPS </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        } else if (question_type == "emojis") {
            survey_data += '<i class="fa fa-meh-o" style="font-size:13px;">&nbsp; Emojis </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i>';
        }
        self.$el.parents('.main-pane').find('#edit_que_type_' + question_type + '_' + current_que_id).parent().html(survey_data);
    },
    /**
     * confirm edit question type OK clicked so change the question type
     * 
     * @current_que_type current question type
     * @current_que_id current question id
     * @changed_type changing question type
     * @question question title
     * @is_required is required or not(ckecked or not)
     * @helptips helptips of question
     * @question_id question id
     * @answer_detail answers (options) object for multichoice type of question
     */
    confirmEditQueType: function (current_que_type, current_que_id, changed_type, question, is_required, helptips, display_boolean_label, question_id, answer_detail, options_Arr, sync_module, sync_field) {
        var self = this;
        var new_que_html = '';
        if (changed_type == 'textbox') {
            new_que_html += self.general_option_textbox(current_que_id, question_id);
            //set other advanced option for textbox
            var questions = {'que_type': 'textbox', 'sync_field': sync_field};
            new_que_html += self.editviewTextBox(current_que_id, questions);
            new_que_html += "</div>";
            new_que_html += "</div>";
        }
        if (changed_type == 'commentbox') {
            new_que_html += self.general_option_commentbox(current_que_id, question_id);
            //set other advanced option for commentbox
            var questions = {'que_type': 'commentbox', 'sync_field': sync_field};
            new_que_html += self.editviewCommentBox(current_que_id, questions);
            new_que_html += "</div>";
            new_que_html += "</div>";
        }
        // code for Add richtext area. By GSR.
        if (changed_type == 'richtextareabox') {
            new_que_html += self.general_option_richtextareabox(current_que_id, question_id);
            //set other advanced option for commentbox
            var questions = {'que_type': 'richtextareabox', 'sync_field': sync_field};
            new_que_html += self.editviewRichTextBox(current_que_id, questions);
            new_que_html += "</div>";
            new_que_html += "</div>";
        }
        // End
        if (changed_type == 'boolean') {

            new_que_html += self.general_option_boolean(current_que_id, question_id, display_boolean_label);
            //set other advanced option for commentbox
            var questions = {'que_type': 'commentbox', 'sync_field': sync_field};
            new_que_html += self.editviewBoolean(current_que_id, questions);
            new_que_html += "</div>";
            new_que_html += "</div>";
        }
        if (changed_type == 'contact-information') {
            new_que_html += self.general_option_contactInformation(current_que_id, question_id);
            //set other advanced option for contact-information
            if (is_required == 'checked') {
                var req = 'Yes';
            }
            var questions = {'que_type': 'contact-information', 'is_required': req, };
            new_que_html += self.editviewContactInformation(current_que_id, questions);
            new_que_html += "</div>";
            new_que_html += "</div>";
        }
        if (changed_type == 'rating') {
            new_que_html += self.general_option_rating(current_que_id, question_id);
            //set other advanced option for rating
            var questions = {'que_type': 'rating'};
            new_que_html += self.editviewRating(current_que_id, questions);
            new_que_html += "</div>";
            new_que_html += "</div>";
        }
        if (changed_type == 'date-time') {
            new_que_html += self.general_option_datetime(current_que_id, question_id);
            //set other advanced option for date-time
            var questions = {'que_type': 'date-time', 'sync_field': sync_field};
            new_que_html += self.editviewDatetime(current_que_id, questions);
            new_que_html += "</div>";
            new_que_html += "</div>";
        }
        if (changed_type == 'scale') {
            new_que_html += self.general_option_scale(current_que_id, question_id);
            //set other advanced option for scale
            var questions = {'que_type': 'scale'};
            new_que_html += self.editviewScale(current_que_id, questions);
            new_que_html += "</div>";
            new_que_html += "</div>";
        }

        if (changed_type == 'netpromoterscore') {
            new_que_html += self.general_option_netpromoterscore(current_que_id, question_id);
            //set other advanced option for NPS
            var questions = {'que_type': 'netpromoterscore'};
            new_que_html += self.editviewNetPromoterScore(current_que_id, questions);
            new_que_html += "</div>";
            new_que_html += "</div>";
        }

        if (changed_type == 'emojis') {
            new_que_html += self.general_option_emojis(current_que_id, question_id);
            //set other advanced option for Emojis
            var questions = {'que_type': 'emojis'};
            new_que_html += self.editviewEmojis(current_que_id, questions);
            new_que_html += "</div>";
            new_que_html += "</div>";
        }
        if (changed_type == 'matrix') {
            new_que_html += self.general_option_matrix(current_que_id, question_id);
            //set other advanced option for matrix
            var questions = {'que_type': 'matrix'};
            new_que_html += self.editviewMatrix(current_que_id, questions);
            new_que_html += "</div>";
            new_que_html += "</div>";
        }
        if (changed_type == 'video') {
            new_que_html += self.general_option_video(current_que_id, question_id);
            //set other advanced option for video
            var questions = {'que_type': 'video'};
            new_que_html += self.editviewVideo(current_que_id, questions);
            new_que_html += "</div>";
            new_que_html += "</div>";
        }
        if (changed_type == 'image') {
            new_que_html += self.general_option_image(current_que_id, question_id);
            //set other advanced option for video
            var questions = {'que_type': 'image'};
            new_que_html += self.editviewImage(current_que_id, questions);
            new_que_html += "</div>";
            new_que_html += "</div>";
        }
        if (changed_type == 'doc-attachment') {
            new_que_html += self.general_option_docattachment(current_que_id, question_id);
            //set other advanced option for video
            var questions = {'que_type': 'doc-attachment'};
            new_que_html += self.editviewDocAttachment(current_que_id, questions);
            new_que_html += "</div>";
            new_que_html += "</div>";
        }
        if (changed_type == 'check-box' || changed_type == 'radio-button' || changed_type == 'multiselectlist' || changed_type == 'dropdownlist') {
            //set question icon for showing type
            var general_options = self.general_option_multichoice(current_que_id, changed_type, question_id, answer_detail);
            new_que_html += general_options['html'];
            //set other advanced option for multi choice type of question
            var questions = {'que_type': changed_type, answers: options_Arr, 'sync_field': sync_field};
            new_que_html += self.editviewMultiChoice(current_que_id, questions);
            new_que_html += "</div>";
            // Enable Skip Logic Feature For Survey Module And Edit Mode.
            if (this.module == 'bc_survey' && this.record_id != '' && this.record_id != null) {
                var curr_page_seq = self.$el.parents('.main-pane').find('.que_' + current_que_id).parents('.data-page').attr('id').replace('data-page_', '');
                if (typeof options_Arr == 'undefined') {
                    questions = {'answers': {}};
                } else {
                    questions = {'answers': options_Arr};
                }
                new_que_html += self.getSkipLogiclayout(questions, curr_page_seq);
                self.$el.parents('.main-pane').find('.que_' + current_que_id).find('.skip_logic_options').hide();
            }
            // End
            new_que_html += "</div>";
        }
        self.$el.parents('.main-pane').find('#' + current_que_type + '_' + current_que_id).replaceWith(new_que_html);
        if (changed_type == 'richtextareabox') {
            self.convertIntoRichTextBox('question_richtextareabox_' + current_que_id);
        }
        $.each(self.$el.parents('.main-pane').find('.no_data'), function () {
            $(this).parents('.question').find('.disable_piping_question').attr('checked', 'checked');
            $(this).parents('.question').find('.sync_field').hide();
        });
        //Set options for multi choice
        if (changed_type == 'check-box' || changed_type == 'radio-button' || changed_type == 'multiselectlist' || changed_type == 'dropdownlist') {
            var op_count = 0;
            if (typeof general_options['options'] == 'object' && Object.keys(general_options['options']).length != 0) {
                $.each(general_options['options'], function (k, value) {
                    if (typeof value != "undefined") {
                        op_count++;
                        self.$el.parents('.main-pane').find('#' + changed_type + "_options_div_" + current_que_id).find('input#' + k).val(value);
                    }
                });
                //enable last option add button to add more options
                if (op_count == 1) {
                    self.$el.parents('.main-pane').find('#' + changed_type + "_options_div_" + current_que_id).find('#option_1').find('.' + changed_type + '_add_option ').css('display', 'none');
                    self.$el.parents('.main-pane').find('#' + changed_type + "_options_div_" + current_que_id).find('#option_2').find('.' + changed_type + '_add_option ').css('display', '');
                } else {
                    self.$el.parents('.main-pane').find('#' + changed_type + "_options_div_" + current_que_id).find('#option_' + op_count).find('.' + changed_type + '_add_option ').css('display', '');
                }
            }
            if (op_count <= 2) {
                //hide remove option button if only two option exists
                self.$el.parents('.main-pane').find('#' + changed_type + "_options_div_" + current_que_id).find('.' + changed_type + '_remove_option').hide();
            }

            if ((changed_type == 'dropdownlist' || changed_type == 'multiselectlist') && sync_field)
            {
                self.$el.parents('.main-pane').find('.que_' + current_que_id).find('[name=option_' + changed_type + ']').attr('disabled', true);
                self.$el.parents('.main-pane').find('.que_' + current_que_id).find('.' + changed_type + '_add_option').hide();
                self.$el.parents('.main-pane').find('.que_' + current_que_id).find('.' + changed_type + '_remove_option').hide();
                self.$el.parents('.main-pane').find('.que_' + current_que_id).find('.enableOther').parent().hide();
                self.$el.parents('.main-pane').find('.que_' + current_que_id).find('.otheroptionRow').parent().hide();
                self.$el.parents('.main-pane').find('.que_' + current_que_id).find('[name=is_required_' + changed_type + '_' + current_que_id + ']').attr('disabled', true);
            }
        }
        if (sync_field && sync_field != 'Select Field')
        {
            self.$el.parents('.main-pane').find('.que_' + current_que_id).find('.previous_sync_field').val(sync_field);
        }
        //set values for question and helptips for allowing special character
        if (changed_type == 'richtextareabox') {
            self.$el.parents('.main-pane').find('[name="question_richtextbox_' + current_que_id + '"]').val(question);
        } else {
            self.$el.parents('.main-pane').find("[name='question_" + changed_type + "_" + current_que_id + "']").val(question);
        }
        if (changed_type != 'image' && changed_type != 'video') {
            self.$el.parents('.main-pane').find("[name='helptips_" + changed_type + "_" + current_que_id + "']").val(helptips);
        }
        if (changed_type == 'boolean') {
            self.$el.parents('.main-pane').find("[name='display_label_" + changed_type + "_" + current_que_id + "']").val(display_boolean_label);
        }
        if (is_required == 'checked') {
            self.$el.parents('.main-pane').find("[name='is_required_" + changed_type + "_" + current_que_id + "']").attr('checked', 'checked');
        }
        //initially hide the advanced option for datatype
        self.$el.parents('.main-pane').find('.que_' + current_que_id).find('.general_options').show();
        self.$el.parents('.main-pane').find('.que_' + current_que_id).find('.advance_options').hide();
        self.$el.parents('.main-pane').find('.que_' + current_que_id).find('.piping_options').hide();
        self.$el.parents('.main-pane').find('.que_' + current_que_id).find('.minmax').hide();
        self.$el.parents('.main-pane').find('.que_' + current_que_id).find('.precision').hide();
        if (is_required != 'checked') {
            self.$el.parents('.main-pane').find('.que_' + current_que_id).find('.requiredFields').hide();
        }
        self.$el.parents('.main-pane').find('.que_' + current_que_id).find('.SurveyImageurl').hide();
        self.$el.parents('.main-pane').find('.que_' + current_que_id).find('.uploadedImage').hide();

        //initially select default required fields for contact-information
        self.$el.parents('.main-pane').find('.que_' + current_que_id).find("[name=Name_" + current_que_id + "]").prop('checked', 'checked');
        self.$el.parents('.main-pane').find('.que_' + current_que_id).find("[name=Email_" + current_que_id + "]").prop('checked', 'checked');
        self.$el.parents('.main-pane').find('.que_' + current_que_id).find("[name=Phone_" + current_que_id + "]").prop('checked', 'checked');
        app.alert.show('info', {
            level: 'success',
            messages: 'Question type changed successfully.',
            autoClose: true
        });
    },
    /**
     * general option display for textbox question type
     * 
     * @que_counter current question counter
     * @question_id current question id
     */
    general_option_textbox: function (que_counter, question_id) {
        var data = '';
        data += "<div id='textbox_" + que_counter + "' class='que_" + que_counter + " question survey-body'>";
        data += '<input type="hidden" class="previous_sync_field">';
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span6">';
        data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
        data += '      <div class="dashlet-tabs-row">';
        data += '          <div class="dashlet-tab active general">General</div>';
        data += '          <div class="dashlet-tab advance">Advanced Option</div>';
        if (this.module == 'bc_survey') {
            data += '          <div class="dashlet-tab piping">Piping</div>'
        }
        data += '      </div>';
        data += '     </div>';
        data += '    </div>';
        data += '    <div class="span6 que-close">';
        data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
        data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + que_counter + '">';
        data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
        data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + que_counter + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
        data += "</div>";
        data += "</div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";
        data += "<div class='row'>";
        data += "       <div class='span1'>Type</div><div class='span5 '>";
        data += '         <i class="fa fa-file-text-o" style="font-size:13px;">&nbsp; TextBox </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i></div>';
        data += "</div>";
        //question type display
        data += "<div class='row'>";
        data += "       <div class='span1'>Question</div>";
        data += "      <div class='span11'>";
        data += "        <div class=''>";
        data += "          <input type='text' name='question_textbox_" + que_counter + "' placeholder='(Required) Question' style='max-width:80%; margin-left:1px;' class='inherit-width'>";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += "        </div>";
        data += "      </div>";
        data += "</div>";
        data += "</div>";
        //advanced tab html
        data += "<div class='advance_options'>";
        //help tip html
        data += "<div class='row' >";
        data += "      <div class='span1' style='margin-top:10px;'>Help Tip </div>";
        data += "      <div class='span11' style='margin-top:10px;'><input type='text' name='helptips_textbox_" + que_counter + "' placeholder='Enter help tip for question' class='inherit-width' style='max-width:80%;margin-left: 0px;'></div>";
        data += "</div>";
        return data;
    },
    /**
     * general option display for commentbox question type
     * 
     * @que_counter current question counter
     * @question_id current question id
     */
    general_option_commentbox: function (que_counter, question_id) {
        // copy textbox div to page
        var data = '';
        data += "<div id='commentbox_" + que_counter + "' class='que_" + que_counter + " question survey-body'>";
        data += '<input type="hidden" class="previous_sync_field">';
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span6">';
        data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
        data += '      <div class="dashlet-tabs-row">';
        data += '          <div class="dashlet-tab active general">General</div>';
        data += '          <div class="dashlet-tab advance">Advanced Option</div>';
        if (this.module == 'bc_survey') {
            data += '          <div class="dashlet-tab piping">Piping</div>'
        }
        data += '      </div>';
        data += '     </div>';
        data += '    </div>';
        data += '    <div class="span6 que-close">';
        data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
        data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + que_counter + '">';
        data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
        data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + que_counter + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
        data += "</div>";
        data += "</div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";
        data += "<div class='row'>";
        data += "       <div class='span1'>Type</div><div class='span5 '>";
        data += '         <i class="fa fa-comments-o" style="font-size:13px;">&nbsp; Comment TextBox</i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i></div>';
        data += "</div>";
        //question  display
        data += "<div class='row'>";
        data += "       <div class='span1'>Question</div>";
        data += "       <div class='span11'>";
        data += "        <div class=''>";
        data += "          <input type='text' name='question_commentbox_" + que_counter + "' placeholder='(Required) Question' style='max-width:80%; margin-left:1px;' class='inherit-width'>";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += "        </div>";
        data += "      </div>";
        data += "</div>";
        data += "</div>"; //general option complete
        //advanced tab html
        data += "<div class='advance_options'>";
        //help tip html
        data += "<div class='row' >";
        data += "      <div class='span1' style='margin-top:10px;'>Help Tip </div>";
        data += "      <div class='span11' style='margin-top:10px;'><input type='text' name='helptips_commentbox_" + que_counter + "' placeholder='Enter help tip for question' class='inherit-width' style='max-width:80%;margin-left: 1px;'></div>";
        data += "</div>";
        return data;
    },
    /**
     * general option display for richtext box question type
     * 
     * @que_counter current question counter
     * @question_id current question id
     */
    general_option_richtextareabox: function (que_counter, question_id) {
        // copy textbox div to page
        var data = '';
        data += "<div id='richtextareabox_" + que_counter + "' class='que_" + que_counter + " question survey-body'>";
        data += '<input type="hidden" class="previous_sync_field">';
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span6">';
        data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
        data += '      <div class="dashlet-tabs-row">';
        data += '          <div class="dashlet-tab active general">General</div>';
        data += '          <div class="dashlet-tab advance">Advanced Option</div>';

        data += '      </div>';
        data += '     </div>';
        data += '    </div>';
        data += '    <div class="span6 que-close">';
        data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
        data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + que_counter + '">';
        data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
        data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + que_counter + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
        data += "</div>";
        data += "</div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";
        data += "<div class='row'>";
        data += "       <div class='span1'>Type</div><div class='span5 '>";
        data += '         <i class="fa fa-comment" style="font-size:13px;">&nbsp; Rich TextBox</i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i></div>';
        data += "</div>";

        data += "<div class='row'>";
        data += "       <div class='span1'>Description</div>";
        data += "       <div class='span11'>";
        data += "        <div class=''>";
        data += "          <textarea  name='question_richtextareabox_" + que_counter + "'  class='inherit-width' rows='4' cols='10'></textarea>";
        // data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += "        </div>";
        data += "      </div>";
        data += "</div>";
        data += "</div>"; //general option complete
        //advanced tab html
        data += "<div class='advance_options'>";
        //help tip html
//        data += "<div class='row' >";
//        data += "      <div class='span1' style='margin-top:10px;'>Help Tip </div>";
//        data += "      <div class='span11' style='margin-top:10px;'><input type='text' name='helptips_richtextareabox_" + que_counter + "' placeholder='Enter help tip for question' class='inherit-width' style='max-width:80%;margin-left: 1px;'></div>";
//        data += "</div>";
        return data;
    },
    /**
     * general option display for boolean question type
     * 
     * @que_counter current question counter
     * @question_id current question id
     */
    general_option_boolean: function (que_counter, question_id, display_boolean_label) {
        // copy textbox div to page
        var data = '';
        data += "<div id='boolean_" + que_counter + "' class='que_" + que_counter + " question survey-body'>";
        data += '<input type="hidden" class="previous_sync_field">';
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span8">';
        data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
        data += '      <div class="dashlet-tabs-row">';
        data += '          <div class="dashlet-tab active general">General</div>';
        data += '          <div class="dashlet-tab advance">Advanced Option</div>';
        if (this.module == 'bc_survey') {
            data += '          <div class="dashlet-tab change_type_skip_logic"><i class="fa">&nbsp;</i>Logic</div>';
            data += '          <div class="dashlet-tab piping">Piping</div>'
        }
        data += '      </div>';
        data += '     </div>';
        data += '    </div>';
        data += '    <div class="span4 que-close">';
        data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
        data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + que_counter + '">';
        data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
        data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + que_counter + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
        data += "</div>";
        data += "</div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";
        data += "<div class='row'>";
        data += "       <div class='span1'>Type</div><div class='span5 '>";
        data += '         <i class="fa fa-check" style="font-size:13px;">&nbsp; Boolean</i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i></div>';
        //scoring
        data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Enable Scoring </div>";
        data += "      <div class='span4 enableScore'><input type='checkbox' name='enable_scoring_boolean_" + que_counter + "' class='inherit-width'/></div>";
        data += "</div>";


        //question  display
        data += "<div class='row'>";
        data += "       <div class='span1'>Question</div>";
        data += "       <div class='span11'>";
        data += "        <div class=''>";
        data += "          <input type='text' name='question_boolean_" + que_counter + "' placeholder='(Required) Question' style='max-width:80%; margin-left:1px;' class='inherit-width'>";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += "        </div>";
        data += "      </div>";
        data += "</div>";

        data += "<div class='row'>";
        data += "       <div class='span1'>Options</div>";
        data += "       <div class='span11' id='boolean_options_div_" + que_counter + "'>";
        var op_count = 0;
        var options = new Object();
        var muti_choice_que_type = 'boolean';
        if (typeof answer_detail == 'object' && Object.keys(answer_detail).length != 0) {
            $.each(answer_detail, function (k, value) {

                if (typeof value != "undefined")
                {
                    op_count++;
                    options[k] = value;
                    data += "               <div class='options' id='option_" + op_count + "'>";
                    data += "                 <input type='text' name='option_" + muti_choice_que_type + "' value='" + value + "' id='" + k + "' placeholder='Option' readonly class='inherit-width' style='max-width:50%; margin-left:1px; margin-top:5px;'>";
                    data += "                 <input type='number' name='score_" + muti_choice_que_type + "' value='" + op_count + "' id='score_" + k + "' class='inherit-width score_weight' style='max-width:7%; margin-left:1px; margin-top:5px;display:none;'>";
                    data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_remove_option que_" + que_counter + "' id='" + op_count + "' style='margin-left:2px; margin-top:5px;'><i class='fa fa-times'></i></a>";
                    data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_add_option que_" + que_counter + "' style='display:none;margin-left:2px; margin-top:5px;' id='" + op_count + "'><i class='fa fa-plus' ></i></a>";
                    data += "               </div>";
                }
            });
        } else {

            data += "<div class='options' id='option_0'>";
            data += "<input type='text' name='option_boolean' value='Yes' onfocus='this.blur()' class='inherit-width' style='max-width:50%;' readonly>&nbsp;&nbsp;";
            data += "<input type='number' name='score_boolean'  value='1' class='inherit-width score_weight' style='max-width:7%; display:none;'>";
            data += "</div>";
            data += "<div class='options' id='option_1'>";
            data += "<input type='text' name='option_boolean' value='No' onfocus='this.blur()' class='inherit-width' style='max-width:50%;margin-top:5px;' readonly>&nbsp;&nbsp;";
            data += "<input type='number' name='score_boolean' value='2' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;display:none;'>";
            data += "</div>";
        }
        data += "</div>";
        data += "</div>";

        data += "</div>"; //general option complete
        //advanced tab html
        data += "<div class='advance_options'>";
        //help tip html

        if (typeof display_boolean_label == 'undefined') {
            display_boolean_label = '';
        }
        data += "<div class='row' >";
        data += "      <div class='span1' style='margin-top:10px;'>Help Tip </div>";
        data += "      <div class='span11' style='margin-top:10px;'><input type='text' name='helptips_boolean_" + que_counter + "' placeholder='Enter help tip for question' class='inherit-width' style='max-width:80%;margin-left: 1px;'></div>";
        data += "</div>";
        data += "<div class='row' >";
        data += "      <div class='span1' style='margin-top:10px;'>Display Label </div>";
        data += "      <div class='span11' style='margin-top:10px;'><input type='text' value='" + display_boolean_label + "' name='display_label_boolean_" + que_counter + "' placeholder='' class='inherit-width' style='max-width:80%;margin-left: 1px;'></div>";
        data += "</div>";
        return data;
    },
    /**
     * general option display for contact-information question type
     * 
     * @que_counter current question counter
     * @question_id current question id
     */
    general_option_contactInformation: function (que_counter, question_id) {
        var data = '';
        // copy textbox div to page
        data += "<div id='contact-information_" + que_counter + "' class='que_" + que_counter + " question survey-body'>";
        data += '<input type="hidden" class="previous_sync_field">';
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span6">';
        data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
        data += '      <div class="dashlet-tabs-row">';
        data += '          <div class="dashlet-tab active general">General</div>';
        data += '          <div class="dashlet-tab advance">Advanced Option</div>';
        if (this.module == 'bc_survey') {
            data += '          <div class="dashlet-tab piping">Piping</div>'
        }
        data += '      </div>';
        data += '     </div>';
        data += '    </div>';
        data += '    <div class="span6 que-close">';
        data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
        data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + que_counter + '">';
        data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
        data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + que_counter + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
        data += "</div>";
        data += "</div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";
        data += "<div class='row'>";
        data += "       <div class='span1'>Type</div><div class='span5 '>";
        data += '         <i class="fa fa-list-alt" style="font-size:13px;">&nbsp; Contact Information </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i></div>';
        data += "</div>";
        //question  display
        data += "<div class='row'>";
        data += "       <div class='span1'>Question</div>";
        data += "       <div class='span11'>";
        data += "        <div class=''>";
        data += "          <input type='text' name='question_contact-information_" + que_counter + "' placeholder='(Required) Question' style='max-width:80%; margin-left:1px;' class='inherit-width'>";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += "        </div>";
        data += "      </div>";
        data += "</div>";
        data += "</div>"; //general option complete
        //advanced tab html
        data += "<div class='advance_options'>";
        data += "<div class='row'>";
        data += "      <div class='span1'>Help Tip </div>";
        data += "      <div class='span11'><input type='text' name='helptips_contact-information_" + que_counter + "' placeholder='Enter help tip for question' class='inherit-width' style='max-width:80%;margin-left: 1px;'></div>";
        data += "</div>";
        return data;
    },
    /**
     * general option display for rating question type
     * 
     * @que_counter current question counter
     * @question_id current question id
     */
    general_option_rating: function (que_counter, question_id) {
        var data = '';
        // copy textbox div to page
        data += "<div id='rating_" + que_counter + "' class='que_" + que_counter + " question survey-body'>";
        data += '<input type="hidden" class="previous_sync_field">';
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span6">';
        data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
        data += '      <div class="dashlet-tabs-row">';
        data += '          <div class="dashlet-tab active general">General</div>';
        data += '          <div class="dashlet-tab advance">Advanced Option</div>';
        if (this.module == 'bc_survey') {
            data += '          <div class="dashlet-tab piping">Piping</div>'
        }
        data += '      </div>';
        data += '     </div>';
        data += '    </div>';
        data += '    <div class="span6 que-close">';
        data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
        data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + que_counter + '">';
        data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
        data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + que_counter + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
        data += "</div>";
        data += "</div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";
        data += "<div class='row'>";
        data += "       <div class='span1'>Type</div><div class='span5 '>";
        data += '         <i class="fa fa-star" style="font-size:13px;">&nbsp; Rating </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i></div>';
        data += "</div>";
        //question  display
        data += "<div class='row'>";
        data += "       <div class='span1'>Question</div>";
        data += "       <div class='span11'>";
        data += "        <div class=''>";
        data += "          <input type='text' name='question_rating_" + que_counter + "' placeholder='(Required) Question' style='max-width:80%; margin-left:1px;' class='inherit-width'>";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += "        </div>";
        data += "      </div>";
        data += "</div>";
        data += "</div>"; //general option complete
        //advanced tab html
        data += "<div class='advance_options'>";
        //help tip html
        data += "<div class='row'>";
        data += "      <div class='span1'>Help Tip </div>";
        data += "      <div class='span11'><input type='text' name='helptips_rating_" + que_counter + "' placeholder='Enter help tip for question' class='inherit-width' style='max-width:80%; margin-left:1px;'></div>";
        data += "</div>";
        return data;
    },
    /**
     * general option display for scale question type
     * 
     * @que_counter current question counter
     * @question_id current question id
     */
    general_option_scale: function (que_counter, question_id) {
        var data = '';
        // copy textbox div to page
        data += "<div id='scale_" + que_counter + "' class='que_" + que_counter + " question survey-body'>";
        data += '<input type="hidden" class="previous_sync_field">';
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span6">';
        data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
        data += '      <div class="dashlet-tabs-row">';
        data += '          <div class="dashlet-tab active general">General</div>';
        data += '          <div class="dashlet-tab advance">Advanced Option</div>';
        if (this.module == 'bc_survey') {
            data += '          <div class="dashlet-tab piping">Piping</div>'
        }
        ;
        data += '      </div>';
        data += '     </div>';
        data += '    </div>';
        data += '    <div class="span6 que-close">';
        data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
        data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + que_counter + '">';
        data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
        data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + que_counter + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
        data += "</div>";
        data += "</div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";
        data += "<div class='row'>";
        data += "       <div class='span1'>Type</div><div class='span5 '>";
        data += '         <i class="fa fa-arrows-h" style="font-size:13px;">&nbsp; Scale </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i></div>';
        data += "</div>";
        //question  display
        data += "<div class='row'>";
        data += "       <div class='span1'>Question</div>";
        data += "       <div class='span11'>";
        data += "        <div class=''>";
        data += "          <input type='text' name='question_scale_" + que_counter + "' placeholder='(Required) Question' style='max-width:80%; margin-left:1px;' class='inherit-width'>";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += "        </div>";
        data += "      </div>";
        data += "</div>";
        data += "</div>"; //general option complete
        //advanced tab html
        data += "<div class='advance_options'>";
        data += "<div class='row'>";
        data += "      <div class='span1'>Help Tip </div>";
        data += "      <div class='span11'><input type='text' name='helptips_scale_" + que_counter + "' placeholder='Enter help tip for question' class='inherit-width' style='max-width:80%;margin-left: 1px;'></div>";
        data += "</div>";
        return data;
    },
    /**
     * general option display for NPS question type
     * 
     * @que_counter current question counter
     * @question_id current question id
     */
    general_option_netpromoterscore: function (que_counter, question_id) {
        var data = '';
        // copy textbox div to page
        data += "<div id='netpromoterscore_" + que_counter + "' class='que_" + que_counter + " question survey-body'>";
        data += '<input type="hidden" class="previous_sync_field">';
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span8">';
        data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
        data += '      <div class="dashlet-tabs-row">';
        data += '          <div class="dashlet-tab active general">General</div>';
        data += '          <div class="dashlet-tab advance">Advanced Option</div>';
        if (this.module == 'bc_survey') {
            data += '          <div class="dashlet-tab change_type_skip_logic"><i class="fa">&nbsp;</i>Logic</div>';
            data += '          <div class="dashlet-tab piping">Piping</div>';
        }
        data += '      </div>';
        data += '     </div>';
        data += '    </div>';
        data += '    <div class="span4 que-close">';
        data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
        data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + que_counter + '">';
        data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
        data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + que_counter + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
        data += "</div>";
        data += "</div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";
        data += "<div class='row'>";
        data += "       <div class='span1'>Type</div><div class='span5 '>";
        data += '         <i class="fa fa-dashboard" style="font-size:13px;">&nbsp; NPS </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i></div>';
        data += "</div>";
        //question  display
        data += "<div class='row'>";
        data += "       <div class='span1'>Question</div>";
        data += "       <div class='span11'>";
        data += "        <div class=''>";
        data += "          <input type='text' name='question_netpromoterscore_" + que_counter + "' placeholder='(Required) Question' style='max-width:80%; margin-left:1px;' class='inherit-width'>";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += "        </div>";
        data += "      </div>";

        data += "</div>";
        // options
        data += "<div class='row' style='display:none'>";
        data += "      <div class='span1'></div>";
        data += "      <div class='span11' id='netpromoterscore_options_div_" + que_counter + "'>";
        for (var nps_value = 0; nps_value <= 10; nps_value++) {
            data += "               <div class='options' id='option_'" + nps_value + ">";
            data += "                 <input type='hidden' name='option_netpromoterscore' placeholder='Option' class='inherit-width' style='max-width:50%;' value='" + nps_value + "'>";
            data += "               </div>";
        }
        data += "     </div>";
        data += "</div>";

        data += "</div>"; //general option complete
        //advanced tab html
        data += "<div class='advance_options'>";
        data += "<div class='row'>";
        data += "      <div class='span1'>Help Tip </div>";
        data += "      <div class='span11'><input type='text' name='helptips_netpromoterscore_" + que_counter + "' placeholder='Enter help tip for question' class='inherit-width' style='max-width:80%;margin-left: 1px;'></div>";
        data += "</div>";
        return data;
    },

    /**
     * general option display for Emojis question type
     * 
     * @que_counter current question counter
     * @question_id current question id
     */
    general_option_emojis: function (que_counter, question_id) {
        var data = '';
        // copy textbox div to page
        data += "<div id='emojis_" + que_counter + "' class='que_" + que_counter + " question survey-body'>";
        data += '<input type="hidden" class="previous_sync_field">';
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span6">';
        data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
        data += '      <div class="dashlet-tabs-row">';
        data += '          <div class="dashlet-tab active general">General</div>';
        data += '          <div class="dashlet-tab advance">Advanced Option</div>';
        if (this.module == 'bc_survey') {
            data += '          <div class="dashlet-tab change_type_skip_logic"><i class="fa">&nbsp;</i>Logic</div>';
        }
        data += '      </div>';
        data += '     </div>';
        data += '    </div>';
        data += '    <div class="span6 que-close">';
        data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
        data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + que_counter + '">';
        data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
        data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + que_counter + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
        data += "</div>";
        data += "</div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";
        data += "<div class='row'>";
        data += "       <div class='span1'>Type</div><div class='span5 '>";
        data += '         <i class="fa fa-meh-o" style="font-size:13px;">&nbsp; Emojis </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i></div>';
        data += "</div>";
        //question  display
        data += "<div class='row'>";
        data += "       <div class='span1'>Question</div>";
        data += "       <div class='span11'>";
        data += "        <div class=''>";
        data += "          <input type='text' name='question_emojis_" + que_counter + "' placeholder='(Required) Question' style='max-width:80%; margin-left:1px;' class='inherit-width'>";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += "        </div>";
        data += "      </div>";

        data += "</div>";

        // options
        data += "<div class='row'>";
        data += "      <div class='span1'></div>";
        data += "      <div class='span11' id='emojis_options_div_" + que_counter + "'>";
        data += "              <div style='width: 100%;display: inline-flex;'> <div  style='width:4%; margin-top: 2px;'><img src='custom/include/images/ext-unsatisfy.png' /></div><div class='options' id='option_0' style='margin-left: 10px;width: 100%;'>";
        data += "                 <input type='text' name='option_emojis' placeholder='Option' class='inherit-width' style='max-width:30%;' value='Extremely Unsatisfied'>";
        data += "                 <input type='number' name='score_emojis'  value='1' class='inherit-width score_weight' style='max-width:7%; display:none;'>";
        data += "               </div></div>";
        data += "               <div style='width: 100%;display: inline-flex;'><div  style='width:4%; margin-top: 2px;'><img src='custom/include/images/unsatisfy.png' /></div><div class='options' id='option_1' style='margin-left: 10px;width: 100%;'>";
        data += "                 <input type='text' name='option_emojis' placeholder='Option' class='inherit-width' style='max-width:30%;margin-top:5px;' value='Unsatisfied'>";
        data += "                 <input type='number' name='score_emojis' value='2' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;display:none;'>";
        data += "               </div></div>";
        data += "               <div style='width: 100%;display: inline-flex;'><div  style='width:4%; margin-top: 2px;'><img src='custom/include/images/nuteral.png' /></div><div class='options' id='option_2' style='margin-left: 10px;width: 100%;'>";
        data += "                 <input type='text' name='option_emojis' placeholder='Option' class='inherit-width' style='max-width:30%;margin-top:5px;' value='Neutral'>";
        data += "                 <input type='number' name='score_emojis' value='3' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;display:none;'>";
        data += "               </div></div>";
        data += "              <div style='width: 100%;display: inline-flex;'><div  style='width:4%; margin-top: 2px;'><img src='custom/include/images/satisfy.png'/> </div> <div class='options' id='option_3' style='margin-left: 10px;width: 100%;'>";
        data += "                 <input type='text' name='option_emojis' placeholder='Option' class='inherit-width' style='max-width:30%;margin-top:5px;' value='Satisfied'>";
        data += "                 <input type='number' name='score_emojis' value='4' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;display:none;'>";
        data += "               </div></div>";
        data += "               <div style='width: 100%;display: inline-flex;'><div  style='width:4%; margin-top: 2px;'><img src='custom/include/images/ext-satisfy.png'/></div><div class='options' id='option_4' style='margin-left: 10px;width: 100%;'>";
        data += "                 <input type='text' name='option_emojis' placeholder='Option' class='inherit-width' style='max-width:30%;margin-top:5px;' value='Extremely Satisfied'>";
        data += "                 <input type='number' name='score_emojis' value='5' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;display:none;'>";
        data += "               </div></div>";

        data += "     </div>";
        data += "</div>";

        data += "</div>"; //general option complete
        //advanced tab html
        data += "<div class='advance_options'>";
        data += "<div class='row'>";
        data += "      <div class='span1'>Help Tip </div>";
        data += "      <div class='span11'><input type='text' name='helptips_emojis_" + que_counter + "' placeholder='Enter help tip for question' class='inherit-width' style='max-width:80%;margin-left: 1px;'></div>";
        data += "</div>";
        return data;
    },
    /**
     * general option display for date-time question type
     * 
     * @que_counter current question counter
     * @question_id current question id
     */
    general_option_datetime: function (que_counter, question_id) {
        var data = '';
        // copy textbox div to page
        data += "<div id='date-time_" + que_counter + "' class='que_" + que_counter + " question survey-body'>";
        data += '<input type="hidden" class="previous_sync_field">';
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span6">';
        data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
        data += '      <div class="dashlet-tabs-row">';
        data += '          <div class="dashlet-tab active general">General</div>';
        data += '          <div class="dashlet-tab advance">Advanced Option</div>';
        if (this.module == 'bc_survey') {
            data += '          <div class="dashlet-tab piping">Piping</div>'
        }
        data += '      </div>';
        data += '     </div>';
        data += '    </div>';
        data += '    <div class="span6 que-close">';
        data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
        data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + que_counter + '">';
        data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
        data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + que_counter + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
        data += "</div>";
        data += "</div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";
        data += "<div class='row'>";
        data += "       <div class='span1'>Type</div><div class='span5 '>";
        data += '         <i class="fa fa-calendar" style="font-size:13px;">&nbsp; DateTime </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i></div>';
        data += "</div>";
        //question  display
        data += "<div class='row'>";
        data += "       <div class='span1'>Question</div>";
        data += "       <div class='span11'>";
        data += "        <div class=''>";
        data += "          <input type='text' name='question_date-time_" + que_counter + "' placeholder='(Required) Question' style='max-width:80%; margin-left:1px;' class='inherit-width'>";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += "        </div>";
        data += "      </div>";
        data += "</div>";
        data += "</div>"; //general option complete
        //advanced tab html
        data += "<div class='advance_options'>";
        data += "<div class='row'>";
        data += "      <div class='span1'>Help Tip </div>";
        data += "      <div class='span11'><input type='text' name='helptips_date-time_" + que_counter + "' placeholder='Enter help tip for question' class='inherit-width' style='max-width:80%;margin-left: 1px;'></div>";
        data += "</div>";
        return data;
    },
    /**
     * general option display for matrix question type
     * 
     * @que_counter current question counter
     * @question_id current question id
     */
    general_option_matrix: function (que_counter, question_id) {
        var data = '';
        // copy textbox div to page
        data += "<div id='matrix_" + que_counter + "' class='que_" + que_counter + " question survey-body'>";
        data += '<input type="hidden" class="previous_sync_field">';
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span6">';
        data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
        data += '      <div class="dashlet-tabs-row">';
        data += '          <div class="dashlet-tab active general">General</div>';
        data += '          <div class="dashlet-tab advance">Advanced Option</div>';
        if (this.module == 'bc_survey') {
            data += '          <div class="dashlet-tab piping">Piping</div>'
        }
        data += '      </div>';
        data += '     </div>';
        data += '    </div>';
        data += '    <div class="span6 que-close">';
        data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
        data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + que_counter + '">';
        data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
        data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + que_counter + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
        data += "</div>";
        data += "</div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";
        data += "<div class='row'>";
        data += "       <div class='span1'>Type</div><div class='span5 '><i class='fa fa-th' style='font-size:13px;'>&nbsp; Matrix </i>&nbsp;<i class='fa fa-pencil queTypeChange'></i></div>";
        data += "</div>";
        //question  display
        data += "<div class='row'>";
        data += "       <div class='span1'>Question</div>";
        data += "       <div class='span11'>";
        data += "        <div class=''>";
        data += "          <input type='text' name='question_matrix_" + que_counter + "' placeholder='(Required) Question' style='max-width:80%; margin-left:1px;' class='inherit-width'>";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += "        </div>";
        data += "      </div>";
        data += "</div>";
        // rows & cols
        data += "<div class='row'>";
        //rows
        data += "      <div class='span1'>Rows</div>";
        data += "      <div class='span5' id='matrix_row_div_" + que_counter + "'>";
        data += "               <div class='rows' id='row_0'>";
        data += "                 <input type='text' name='row_matrix' placeholder='row label' class='inherit-width' style='max-width:50%; margin-left:1px;'>";
        data += "                 <a href='javascript:void(0);' class='btn  matrix_remove_row que_" + que_counter + "' id='0' style='display:none;margin-left:2px; margin-top:5px;'><i class='fa fa-times'></i></a>";
        data += "                 <a href='javascript:void(0);' class='btn  matrix_add_row que_" + que_counter + "' style='display:none;' id='0'><i class='fa fa-plus' ></i></a>";
        data += "               </div>";
        data += "               <div class='rows' id='row_1'>";
        data += "                 <input type='text' name='row_matrix' placeholder='row label' class='inherit-width' style='max-width:50%;margin-top:5px; margin-left:1px;'>";
        data += "                 <a href='javascript:void(0);' class='btn  matrix_remove_row que_" + que_counter + "' id='1' style='display:none;margin-left:2px; margin-top:5px;'><i class='fa fa-times'></i></a>";
        data += "                 <a href='javascript:void(0);' class='btn  matrix_add_row que_" + que_counter + "' style='margin-left:2px; margin-top:5px;' id='1'><i class='fa fa-plus' ></i></a>";
        data += "               </div>";
        data += "     </div>";
        //columns
        data += "      <div class='span1'>Columns</div>";
        data += "      <div class='span5' id='matrix_column_div_" + que_counter + "'>";
        data += "               <div class='columns' id='column_0'>";
        data += "                 <input type='text' name='column_matrix' placeholder='column label' class='inherit-width' style='max-width:50%; margin-left:1px;'>";
        data += "                 <a href='javascript:void(0);' class='btn  matrix_remove_column que_" + que_counter + "' id='0' style='display:none;margin-left:2px; margin-top:5px;'><i class='fa fa-times'></i></a>";
        data += "                 <a href='javascript:void(0);' class='btn  matrix_add_column que_" + que_counter + "' style='display:none;' id='0'><i class='fa fa-plus' ></i></a>";
        data += "               </div>";
        data += "               <div class='columns' id='column_1'>";
        data += "                 <input type='text' name='column_matrix' placeholder='column label' class='inherit-width' style='max-width:50%;margin-top:5px; margin-left:1px;'>";
        data += "                 <a href='javascript:void(0);' class='btn  matrix_remove_column que_" + que_counter + "' id='1' style='display:none;margin-left:2px; margin-top:5px;'><i class='fa fa-times'></i></a>";
        data += "                 <a href='javascript:void(0);' class='btn  matrix_add_column que_" + que_counter + "' style='margin-left:2px; margin-top:5px;' id='1'><i class='fa fa-plus' ></i></a>";
        data += "               </div>";
        data += "     </div>";
        data += "</div>";
        data += "</div>"; //general option complete
        //advanced tab html
        data += "<div class='advance_options'>";
        //help tip html
        data += "<div class='row'>";
        data += "      <div class='span1'>Help Tip </div>";
        data += "      <div class='span11'><input type='text' name='helptips_matrix_" + que_counter + "' placeholder='Enter help tip for question' class='inherit-width' style='max-width:80%; margin-left: 1px;'></div>";
        data += "</div>";
        return data;
    },
    /**
     * general option display for multi choice question type
     * 
     * @que_counter current question counter
     * @muti_choice_que_type multi choice question type ie.check-box,radio-button,dropdownlist,muktiselectlist
     * @question_id current question id
     * @answer_detail options object
     */
    general_option_multichoice: function (que_counter, muti_choice_que_type, question_id, answer_detail) {

        var que_icon = '';
        if (muti_choice_que_type == "multiselectlist") {
            que_icon += '<i class="fa fa-list-ul" style="font-size:13px;">&nbsp; MultiSelect List </i>';
        }

        if (muti_choice_que_type == "check-box") {
            que_icon += '<i class="fa  fa-check-square-o" style="font-size:13px;">&nbsp; CheckBox </i>';
        }

        if (muti_choice_que_type == "dropdownlist") {
            que_icon += '<i class="fa fa-chevron-down" style="font-size:13px;">&nbsp; Dropdown List </i>';
        }

        if (muti_choice_que_type == "radio-button") {
            que_icon += '<i class="fa fa-dot-circle-o" style="font-size:13px;">&nbsp; Radio Button </i>';
        }
        var data = '';
        // copy textbox div to page
        var survey_body = 'survey-body';
        if (this.model && (this.model.get('survey_type') == 'poll' || (this.context && this.context.attributes.IsPOll))) {
            survey_body = '';
        }
        data += "<div id='" + muti_choice_que_type + "_" + que_counter + "' class='que_" + que_counter + " question " + survey_body + "'>";
        data += '<input type="hidden" class="previous_sync_field">';
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span8">';
        data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
        data += '      <div class="dashlet-tabs-row">';
        data += '          <div class="dashlet-tab active general">General</div>';
        data += '          <div class="dashlet-tab advance">Advanced Option</div>';
        // Show Logic Tab In Only Survey Module And Only Edit Mode.
        if (this.module == 'bc_survey') {
            data += '          <div class="dashlet-tab change_type_skip_logic"><i class="fa">&nbsp;</i>Logic</div>';
            data += '          <div class="dashlet-tab piping">Piping</div>';
        }

        // End
        data += '      </div>';
        data += '     </div>';
        data += '    </div>';
        data += '    <div class="span4 que-close">';
        data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
        data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + que_counter + '">';
        data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
        data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + que_counter + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
        data += "</div>";
        data += "</div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";

        if (muti_choice_que_type == "radio-button" || muti_choice_que_type == "check-box") {
            data += "<div class='row'>";
            data += "       <div class='span1'>Type</div><div class='span3'>";
            data += que_icon;
            data += "&nbsp;<i class='fa fa-pencil queTypeChange'></i></div>";
            //scoring
            data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Enable Scoring </div>";
            data += "      <div class='span2 enableScore'><input type='checkbox' name='enable_scoring_" + muti_choice_que_type + "_" + que_counter + "' class='inherit-width'/></div>";
            //Is image Option?
            data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Show Image Option? </div>";
            data += "      <div class='span2 isImageOption'><input type='checkbox' name='is_image_option_" + muti_choice_que_type + "_" + que_counter + "' class='inherit-width'/></div>";

        } else {
            data += "<div class='row'>";
            data += "       <div class='span1'>Type</div><div class='span5'>";
            data += que_icon;
            data += "&nbsp;<i class='fa fa-pencil queTypeChange'></i></div>";
            //scoring
            data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Enable Scoring </div>";
            data += "      <div class='span4 enableScore'><input type='checkbox' name='enable_scoring_" + muti_choice_que_type + "_" + que_counter + "' class='inherit-width'/></div>";
        }
        data += "</div>";
        //question  display
        data += "<div class='row'>";
        data += "       <div class='span1'>Question</div>";
        data += "       <div class='span11'>";
        data += "        <div class=''>";
        data += "          <input type='text' name='question_" + muti_choice_que_type + "_" + que_counter + "' placeholder='(Required) Question' style='max-width:80%; margin-left:1px;' class='inherit-width'>";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += "        </div>";
        data += "      </div>";
        data += "</div>";
        // options
        data += "<div class='row'>";
        data += "      <div class='span1'></div>";
        data += "      <div class='span11' id='" + muti_choice_que_type + "_options_div_" + que_counter + "'>";
        // If options already exists then show it
        if (typeof answer_detail == 'object' && Object.keys(answer_detail).length != 0) {

            var options = new Object();
            var op_count = 0;
            var ans_count = Object.keys(answer_detail).length;
            $.each(answer_detail, function (k, value) {

                if (typeof value != "undefined")
                {
                    op_count++;
                    options[k] = value;
                    data += "               <div class='options' id='option_" + op_count + "'>";
                    if (muti_choice_que_type == "radio-button" || muti_choice_que_type == "check-box") {
                        data += "                 <input type='file' name='radioImage_" + muti_choice_que_type + "' id='radio_image_" + k + "'  class='inherit-width radioImageUpload' style='width: 175px;max-width:50%; margin-left:1px; margin-top:5px; display:none;'> <span style='margin-left: -13px; margin-top: 6px; position:relative; z-index:500; display:none; width:auto;' class='spanRadioUploadError'><a><i class='fa fa-exclamation-circle' title='Error. This field is required.' style='color:red;font-size:12px;'></i></a></span>";
                    }
                    data += "                 <input type='text' name='option_" + muti_choice_que_type + "' id='" + k + "' placeholder='Option' class='inherit-width' style='max-width:50%; margin-left:1px; margin-top:5px;'>";
                    data += "                 <input type='number' name='score_" + muti_choice_que_type + "' value='" + op_count + "' id='score_" + k + "' class='inherit-width score_weight' style='max-width:7%; margin-left:1px; margin-top:5px;display:none;'>";
                    data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_remove_option que_" + que_counter + "' id='" + op_count + "' style='margin-left:2px; margin-top:5px;'><i class='fa fa-times'></i></a>";
                    data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_add_option que_" + que_counter + "' style='display:none;margin-left:2px; margin-top:5px;' id='" + op_count + "'><i class='fa fa-plus' ></i></a>";
                    data += "               </div>";
                }
            });
            // if cahnged from multiselect or dropdown to checkbox or radio button then manage option for null value
            if (op_count == 1) {
                data += "               <div class='options' id='option_2'>";
                if (muti_choice_que_type == "radio-button" || muti_choice_que_type == "check-box") {
                    data += "                 <input type='file' name='radioImage_" + muti_choice_que_type + "'  class='inherit-width radioImageUpload' style='width: 175px;max-width:50%; margin-left:1px; margin-top:5px; display:none;'> <span style='margin-left: -13px; margin-top: 6px; position:relative; z-index:500; display:none; width:auto;' class='spanRadioUploadError'><a><i class='fa fa-exclamation-circle' title='Error. This field is required.' style='color:red;font-size:12px;'></i></a></span>";
                }
                data += "                 <input type='text' name='option_" + muti_choice_que_type + "' placeholder='Option' class='inherit-width' style='max-width:50%;margin-top:5px;'>";
                data += "                 <input type='number' name='score_" + muti_choice_que_type + "'  value='2' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;display:none;'>";
                data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_remove_option que_" + que_counter + "' id='2' style='display:none;margin-left:2px; margin-top:5px;'><i class='fa fa-times'></i></a>";
                data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_add_option que_" + que_counter + "' style='margin-left:2px; margin-top:5px;' id='2'><i class='fa fa-plus' ></i></a>";
                data += "               </div>";
            }
        }
        //If no option then show default two option input
        else {
            data += "               <div class='options' id='option_0'>";
            if (muti_choice_que_type == "radio-button" || muti_choice_que_type == "check-box") {
                data += "                 <input type='file' name='radioImage_" + muti_choice_que_type + "'  class='inherit-width radioImageUpload' style='width: 175px;max-width:50%; margin-left:1px; margin-top:5px; display:none;'> <span style='margin-left: -13px; margin-top: 6px; position:relative; z-index:500; display:none; width:auto;' class='spanRadioUploadError'><a><i class='fa fa-exclamation-circle' title='Error. This field is required.' style='color:red;font-size:12px;'></i></a></span>";
            }
            data += "                 <input type='text' name='option_" + muti_choice_que_type + "' placeholder='Option' class='inherit-width' style='max-width:50%;'>";
            data += "                 <input type='number' name='score_" + muti_choice_que_type + "'  value='1' class='inherit-width score_weight' style='max-width:7%; display:none;'>";
            data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_remove_option que_" + que_counter + "' id='0' style='display:none;margin-left:2px; margin-top:5px;'><i class='fa fa-times'></i></a>";
            data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_add_option que_" + que_counter + "' style='display:none;' id='0'><i class='fa fa-plus' ></i></a>";
            data += "               </div>";
            data += "               <div class='options' id='option_1'>";
            if (muti_choice_que_type == "radio-button" || muti_choice_que_type == "check-box") {
                data += "                 <input type='file' name='radioImage_" + muti_choice_que_type + "'  class='inherit-width radioImageUpload' style='width: 175px;max-width:50%; margin-left:1px; margin-top:5px; display:none;'> <span style='margin-left: -13px; margin-top: 6px; position:relative; z-index:500; display:none; width:auto;' class='spanRadioUploadError'><a><i class='fa fa-exclamation-circle' title='Error. This field is required.' style='color:red;font-size:12px;'></i></a></span>";
            }
            data += "                 <input type='text' name='option_" + muti_choice_que_type + "' placeholder='Option' class='inherit-width' style='max-width:50%;margin-top:5px;'>";
            data += "                 <input type='number' name='score_" + muti_choice_que_type + "' value='2' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;display:none;'>";
            data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_remove_option que_" + que_counter + "' id='1' style='display:none;margin-left:2px; margin-top:5px;'><i class='fa fa-times'></i></a>";
            data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_add_option que_" + que_counter + "' style='margin-left:2px; margin-top:5px;' id='1'><i class='fa fa-plus' ></i></a>";
            data += "               </div>";
        }

        data += "     </div>";
        data += "</div>";
        //enable other option
        data += "<div class='row'>";
        data += '      <div class="span12" style="background-color:#E6E0E0; border-radius: 3px; padding:4px;"><input type="checkbox" name="enable_otherOption_' + muti_choice_que_type + '_' + que_counter + '"  class="inherit-width enableOther"/> Add other option textbox </div>';
        data += "</div>";
        data += "<div class='row otheroptionRow'  style='display:none;margin-top:5px;'>";
        if (muti_choice_que_type == "radio-button" || muti_choice_que_type == "check-box") {
            data += "       <div class='span1 otheroptiondiv'>Label </div><div class='span11 otheroptiondiv'> <input type='file' name='radioImage_" + muti_choice_que_type + "_other'  class='inherit-width radioImageUpload' style='width: 175px;max-width:50%; margin-left:1px; margin-top:5px; display:none;'> <span style='margin-left: -13px; margin-top: 6px; position:relative; z-index:500; display:none; width:auto;' class='spanRadioUploadError'><a><i class='fa fa-exclamation-circle' title='Error. This field is required.' style='color:red;font-size:12px;'></i></a></span><input id='option_" + (op_count + 1) + "' placeholder='Other Option Label' style='width:50%;' value='Other' type='text'  name='label_otherOption_" + muti_choice_que_type + "_" + que_counter + "' class='inherit-width other_option_label'/>";
        } else {
            data += "      <div class='span1 otheroptiondiv'>Label </div><div class='span11 otheroptiondiv'><input id='option_" + (op_count + 1) + "' placeholder='Other Option Label' style='width:50%;' value='Other' type='text'  name='label_otherOption_" + muti_choice_que_type + "_" + que_counter + "' class='inherit-width other_option_label'/>";
        }
        data += "      <input type='text' value='0' style='width:7%;display:none;' Placeholder='score' name='option_score_" + muti_choice_que_type + "_" + que_counter + "' class='inherit-width other_weight'/>";
        data += "      </div>";
        data += "</div>";
        data += "</div>"; //general option complete



        //advanced tab html
        data += "<div class='advance_options'>";
        //help tip html
        data += "<div class='row'>";
        data += "      <div class='span1'>Help Tip </div>";
        data += "      <div class='span11'><input type='text' name='helptips_" + muti_choice_que_type + "_" + que_counter + "' placeholder='Enter help tip for question' class='inherit-width' style='max-width:80%; margin-left: 1px;'></div>";
        data += "</div>";
        var result = new Array();
        result['html'] = data;
        result['options'] = options;
        return result;
    },
    /**
     * general option display for image question type
     * 
     * @que_counter current question counter
     * @question_id current question id
     */
    general_option_image: function (que_counter, question_id) {
        var data = '';
        // copy textbox div to page
        data += "<div id='image_" + que_counter + "' class='que_" + que_counter + " question survey-body'>";
        data += '<input type="hidden" class="previous_sync_field">';
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span6">';
        data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
        data += '      <div class="dashlet-tabs-row">';
        data += '          <div class="dashlet-tab active general">General</div>';
        data += '          <div class="dashlet-tab advance">Advanced Option</div>';
        if (this.module == 'bc_survey') {
            data += '          <div class="dashlet-tab piping">Piping</div>'
        }
        data += '      </div>';
        data += '     </div>';
        data += '    </div>';
        data += '    <div class="span6 que-close">';
        data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
        data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + que_counter + '">';
        data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
        data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + que_counter + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
        data += "</div>";
        data += "</div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";
        data += "<div class='row'>";
        data += "       <div class='span1'>Type</div><div class='span5'>";
        data += '         <i class="fa fa-picture-o" style="font-size:13px;">&nbsp; Image </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i></div>';
        data += "</div>";
        //question  display
        data += "<div class='row'>";
        data += "       <div class='span1'>Image</div>";
        data += "       <div class='span4'>";
        data += "        <div class=''>";
        data += "          <input type='radio' name='uploadImageType_image_" + que_counter + "' style=' margin-left:1px;  margin-top: 5px;' class='inherit-width uploadsImage uploadImageType' checked> Upload Image &nbsp;";
        data += "          <input type='radio' name='uploadImageType_image_" + que_counter + "' style=' margin-left:1px;  margin-top: 5px;' class='inherit-width imageURL uploadImageType'> Image URL";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += "        </div>";
        data += "      </div>";
        data += "</div>";
        data += "<div class='row'>";
        data += "       <div class='span1'></div>";
        data += "       <div class='span11'>";
        data += "        <div class=''>";
        data += " <img width='20%' height='20%' class='inherit-width uploadedImage' /> ";
        data += "          <input type='file' name='uploadType_image_" + que_counter + "'  style=' margin-left:1px;' class='inherit-width uploadSurveyImage'> ";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += "        </div>";
        data += "        <div class=''>";
        data += "          <input type='text' name='urlType_image_" + que_counter + "'  style=' margin-left:1px; max-width:80%;' placeholder='(Required) Image URL' class='inherit-width SurveyImageurl'>";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += '          <span class="SurveyImageurl" style="" ><a><i class="fa fa-info-circle" title="i.e. https://images.pexels.com/photos/34950/pexels-photo.jpg" ></i></a></span>';
        data += "        </div>";
        data += "      </div>";
        data += "</div>";
        data += "</div>"; //general option complete
        //advanced tab html
        data += "<div class='advance_options'>";
        data += "<div class='row'>";
        data += "      <div class='span1'>Title </div>";
        data += "      <div class='span11'><input type='text' name='helptips_image_" + que_counter + "' placeholder='(Required) Enter title for image' class='inherit-width' style='max-width:80%;margin-left: 1px;'>";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span></div>';
        data += "</div>";
        return data;
    },
    /**
     * general option display for video question type
     * 
     * @que_counter current question counter
     * @question_id current question id
     */
    general_option_video: function (que_counter, question_id) {
        var data = '';
        // copy textbox div to page
        data += "<div id='video_" + que_counter + "' class='que_" + que_counter + " question survey-body'>";
        data += '<input type="hidden" class="previous_sync_field">';
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span6">';
        data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
        data += '      <div class="dashlet-tabs-row">';
        data += '          <div class="dashlet-tab active general">General</div>';
        data += '          <div class="dashlet-tab advance">Advanced Option</div>';
        if (this.module == 'bc_survey') {
            data += '          <div class="dashlet-tab piping">Piping</div>'
        }
        data += '      </div>';
        data += '     </div>';
        data += '    </div>';
        data += '    <div class="span6 que-close">';
        data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
        data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + que_counter + '">';
        data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
        data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + que_counter + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
        data += "</div>";
        data += "</div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";
        data += "<div class='row'>";
        data += "       <div class='span1'>Type</div><div class='span5 '>";
        data += '         <i class="fa fa-video-camera" style="font-size:13px;">&nbsp; Video </i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i></div>';
        data += "</div>";
        //question  display

        //video URL
        data += "<div class='row'>";
        data += "       <div class='span1'>Video URL</div>";
        data += "       <div class='span8'>";
        data += "        <div class=''>";
        data += "          <input type='text' name='video-url_video_" + que_counter + "' placeholder='(Required) Video URL' style='max-width:100%; margin-left:1px;' class='inherit-width'>";
        data += "        </div>";
        data += "      </div>";
        data += '         <div class="span3"> <span style="" ><a><i class="fa fa-info-circle" title="i.e. https://www.youtube.com/embed/L3_gx6Fx_b0" ></i></a></span> </div>';
        data += "</div>";
        data += "</div>"; //general option complete
        //advanced tab html
        data += "<div class='advance_options'>";
        data += "<div class='row'>";
        data += "      <div class='span1'>Title </div>";
        data += "      <div class='span11'><input type='text' name='helptips_video_" + que_counter + "' placeholder='(Required) Enter title for the video' class='inherit-width' style='max-width:80%;margin-left: 1px;'>";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span></div>';
        data += "</div>";
        return data;
    },
    /**
     * general option display for commentbox question type
     * 
     * @que_counter current question counter
     * @question_id current question id
     */
    general_option_docattachment: function (que_counter, question_id) {
        // copy textbox div to page
        var data = '';
        data += "<div id='doc-attachment_" + que_counter + "' class='que_" + que_counter + " question survey-body'>";
        data += '<input type="hidden" class="previous_sync_field">';
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span6">';
        data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
        data += '      <div class="dashlet-tabs-row">';
        data += '          <div class="dashlet-tab active general">General</div>';
        data += '          <div class="dashlet-tab advance">Advanced Option</div>';
        data += '      </div>';
        data += '     </div>';
        data += '    </div>';
        data += '    <div class="span6 que-close">';
        data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
        data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + que_counter + '">';
        data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
        data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + que_counter + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
        data += "</div>";
        data += "</div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";
        data += "<div class='row'>";
        data += "       <div class='span1'>Type</div><div class='span5 '>";
        data += '         <i class="fa fa-paperclip" style="font-size:13px;">&nbsp; Attachment</i>&nbsp;<i class="fa fa-pencil queTypeChange" title="Change Question Type"></i></div>';
        data += "</div>";
        //question  display
        data += "<div class='row'>";
        data += "       <div class='span1'>Question</div>";
        data += "       <div class='span11'>";
        data += "        <div class=''>";
        data += "          <input type='text' name='question_doc-attachment_" + que_counter + "' placeholder='(Required) Question' style='max-width:80%; margin-left:1px;' class='inherit-width'>";
        data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        data += "        </div>";
        data += "      </div>";
        data += "</div>";
        data += "</div>"; //general option complete
        //advanced tab html
        data += "<div class='advance_options'>";
        //help tip html
        data += "<div class='row' >";
        data += "      <div class='span1' style='margin-top:10px;'>Help Tip </div>";
        data += "      <div class='span11' style='margin-top:10px;'><input type='text' name='helptips_doc-attachment_" + que_counter + "' placeholder='Enter help tip for question' class='inherit-width' style='max-width:80%;margin-left: 1px;'></div>";
        data += "</div>";
        return data;
    },
    /**
     * general option display for Additional Text question type
     * 
     * @que_counter current question counter
     * @question_id current question id
     */
    general_option_additionalText: function (que_counter, question_id) {
        var data = '';
        // copy textbox div to page
        data += "<div id='additional-text_" + que_counter + "' class='que_" + que_counter + " question'>";
        if (typeof question_id != "undefined" && question_id != "") {
            data += '<input type="hidden" class="que_id" value="' + question_id + '">';
        }
        data += '<div class="row">';
        data += '  <div class="span4">';

        data += '    </div>';
        data += "<div class='span8 que-close'><p align='right'><a id='que-remove'><i class='fa fa-times' id='remove_que_" + que_counter + "' title='Remove Question' style='font-size:14px;'></i></a></p></div>";
        data += "</div>";
        //general tab html
        data += "<div class='general_options'>";
        data += "<div class='row'>";
        data += "       <div class='span1'>Type</div><div class='span5 '>";
        data += '         <i class="fa fa-pencil-square-o" style="font-size:13px;">&nbsp; Additional Text </i></div>';
        data += "</div>";
        //question  display

        //Text
        data += "<div class='row'>";
        data += "       <div class='span1'>Text</div>";
        data += "       <div class='span8'>";
        data += "        <div class=''>";
        data += "          <textarea rows='3'  name='question_additional-text_" + que_counter + "' placeholder='(Required) Additional Text' style='max-width:100%; margin-left:1px;' class='inherit-width'></textarea>";
        data += "        </div>";
        data += "      </div>";
        data += "</div>";
        data += "</div>";//general option complete


        return data;
    },
    /**
     * display detail view of pages
     * 
     * @detail page detail
     * @page_sequence current page sequence
     */
    detailviewPage_data: function (detail, page_sequence) {
        var survey_data = '';
        var self = this;
        survey_data += "<div id='page_" + page_sequence + "'  class='thumbnail thumbnail_page dashlet'  style='margin-top:10px;margin-bottom:10px; min-height:0px;padding:0px;' >";
        survey_data += "<input type='hidden' class='page_id' value='" + detail['page_id'] + "'/>";
        survey_data += "<div data-dashlet = 'toolbar' > <div class = 'dashlet-header' style=''>";
        survey_data += '      <div class="btn-toolbar pull-right">';
        //Page Header
        if (self.restrictEdit == "false" || !self.restrictEdit || self.restrictEditloading == "loading") {
            if (!self.sugar_latest)
            {
                survey_data += '          <span sfuuid="137" class="dashlet-toolbar">';
                survey_data += '           <a id=' + page_sequence + ' href="javascript:void(0);" track="click:" data-dashletaction="toggleMinify" rel="tooltip" data-placement="bottom" title="" name="" class="dashlet-toggle btn btn-invisible minify edit_page" data-original-title="Open/Close">';
                survey_data += '            <i class="fa fa-pencil" tabindex="-1"></i></a>';
                survey_data += '          </span>';
            }
        }
        if ((self.model && self.model.get('survey_type') != 'poll') || (self.context && !self.context.attributes.IsPOll))
        {
            survey_data += '        <div class="btn-group">';
            survey_data += '            <a id=' + page_sequence + ' data-toggle="dropdown" rel="tooltip" title="" class="dropdown-toggle btn btn-invisible page_toggle" data-placement="bottom" data-original-title="Toggle Visibility"><i data-action="loading" class="fa fa-chevron-down" track="click:dashletToolbarCog"></i></a>';
            survey_data += '        </div>';
        }
        survey_data += '      </div>';
        survey_data += '<h4 data-toggle="dashlet" style="min-height:20px; background-color:#c5c5c5; color:#555; " class="dashlet-title">';
        // Page Title
        if ((self.model && self.model.get('survey_type') != 'poll') || (self.context && !self.context.attributes.IsPOll))
        {
            survey_data += '<b>Page Title :&nbsp</b> ' + detail['page_title'];
        } else {
            survey_data += '<b>Poll Question</b> ';
        }
        survey_data += '</h4></div>';
        self.$el.parents('.main-pane').find('.Survey_Pages').append(survey_data);
        //   self.$el.parents('.main-pane').find('.Survey_Pages').find('[data-dashlet="toolbar"]').hide()

        // header complete
    },
    /**
     * display detail view of questions
     * 
     * @questions question object with all detail
     * @page_sequence current page sequence
     * @question_sequence question sequence
     */
    detailviewQuestion_data: function (questions, page_sequence, question_sequence, enable_data_piping) {
        var self = this;
        var survey_data = '';
        if (questions['que_type'] == 'section-header')
        {
            survey_data += '<div class="question-section" style="padding-left:5px !important; max-height:32px !important; border-radius: 10px 10px 0px 0px;">';
            survey_data += '  <div class="row">';
            survey_data += '       <div class="span12"><b style="font-size: 14px;">Section Title : </b><span style="font-size:14px;">';
            survey_data += questions['que_title'];
            survey_data += '       </span><div>';
            survey_data += '  <div>';
            survey_data += '</div>';
        } else {
            survey_data += '<div id="' + questions['que_type'] + '_' + question_sequence + '" class="que_' + question_sequence + ' question">';
            survey_data += "<input type='hidden' class='que_id' value='" + questions['que_id'] + "'/>";
            survey_data += "<div class='row'>";
            survey_data += "       <div class='span1'>Type</div><div class='span5'>";
            var question_type = questions['que_type']; //Answer Type Display in detail view
            if (question_type == "textbox") {
                survey_data += '<i class="fa fa-file-text-o" style="font-size:13px;">&nbsp; TextBox </i>';
            } else if (question_type == "commentbox") {
                survey_data += '<i class="fa fa-comments-o" style="font-size:13px;">&nbsp; Comment TextBox</i>';
            } else if (question_type == "richtextareabox") {
                survey_data += '<i class="fa fa-comment" style="font-size:13px;">&nbsp; Rich TextBox</i>';
            } else if (question_type == "multiselectlist") {
                survey_data += '<i class="fa fa-list-ul" style="font-size:13px;">&nbsp; MultiSelect List </i>';
            } else if (question_type == "check-box") {
                survey_data += '<i class="fa  fa-check-square-o" style="font-size:13px;">&nbsp; CheckBox </i>';
            } else if (question_type == "boolean") {
                survey_data += '<i class="fa  fa-check" style="font-size:13px;">&nbsp; Boolean </i>';
            } else if (question_type == "dropdownlist") {
                survey_data += '<i class="fa fa-chevron-down" style="font-size:13px;">&nbsp; Dropdown List </i>';
            } else if (question_type == "radio-button") {
                survey_data += '<i class="fa fa-dot-circle-o" style="font-size:13px;">&nbsp; Radio Button </i>';
            } else if (question_type == "contact-information") {
                survey_data += '<i class="fa fa-list-alt" style="font-size:13px;">&nbsp; Contact Information </i>';
            } else if (question_type == "rating") {
                survey_data += '<i class="fa fa-star" style="font-size:13px;">&nbsp; Rating </i>';
            } else if (question_type == "date-time") {
                survey_data += '<i class="fa fa-calendar" style="font-size:13px;">&nbsp; DateTime </i>';
            } else if (question_type == "image") {
                survey_data += '<i class="fa fa-picture-o" style="font-size:13px;">&nbsp; Image </i>';
            } else if (question_type == "video") {
                survey_data += '<i class="fa fa-video-camera" style="font-size:13px;">&nbsp; Video </i>';
            } else if (question_type == "scale") {
                survey_data += '<i class="fa fa-arrows-h" style="font-size:13px;">&nbsp; Scale </i>';
            } else if (question_type == "matrix") {
                survey_data += '<i class="fa fa-th" style="font-size:13px;">&nbsp; Matrix </i>';
            } else if (question_type == "doc-attachment") {
                survey_data += '<i class="fa fa-paperclip" style="font-size:13px;">&nbsp; Attachment </i>';
            } else if (question_type == "additional-text") {
                survey_data += '<i class="fa fa-pencil-square-o" style="font-size:13px;">&nbsp; Additional Text </i>';
            } else if (question_type == "netpromoterscore") {
                survey_data += '<i class="fa fa-dashboard" style="font-size:13px;">&nbsp; NPS </i>';
            } else if (question_type == "emojis") {
                survey_data += '<i class="fa fa-meh-o" style="font-size:13px;">&nbsp; Emojis </i>';
            }
            survey_data += "        </div>";
            if (questions['question_help_comment'] != 'N/A') {
                var helptips = questions['question_help_comment'];
            } else {
                var helptips = '';
            }
            if (helptips != '' && question_type != 'image' && question_type != 'video') {
                survey_data += "<div class='span1'></div><div class='span5' style='text-align:right;'><a> <i class='fa fa-info-circle' style='font-size:14px;'  title='HelpTips : " + helptips + "'></i></a></div>";
            } else {
                survey_data += " <div class='span1'></div><div class='span5'></div>";
            }
            survey_data += "</div>";
            // Question and Answer Display
            var other_option_label = '';
            var other_option_image = '';
            if (question_type == "additional-text") {
                survey_data += "<div class='row'>";
                survey_data += "       <div class='span1'>Text</div>";
                survey_data += "      <div class='span11'>" + questions['que_title'];
                survey_data += "      </div>";
                survey_data += "</div>";
            } else if (question_type != 'image' && question_type != 'video' && question_type != 'richtextareabox') {
                survey_data += "<div class='row'>";
                survey_data += "       <div class='span1'>Question</div>";
                survey_data += "      <div class='span11'>" + questions['que_title'];
                if (questions['is_required'] != 'No') {
                    survey_data += "&nbsp;<i class='fa fa-asterisk' style='color:red; font-size:7px; vertical-align: top; ' title='Required'></i>";
                }
                survey_data += "</div>";
                survey_data += "</div>";
            }
            if (questions['que_type'] != 'netpromoterscore' && questions['que_type'] != 'scale' && questions['que_type'] != 'doc-attachment' && questions['que_type'] != 'boolean' && question_type != "additional-text") {
                survey_data += "<div class='row'>";
                survey_data += "       <div class='span1'></div><div class='span11' id='" + questions['que_type'] + "_options_div_" + question_sequence + "'>";
                if (questions['que_type'] == 'textbox') {
                    survey_data += '<a style="text-decoration:none; color:#333;">';
                    survey_data += '  <input type="text" class="inherit-width" style="width:50%" />';
                    survey_data += '</a>';
                } else if (questions['que_type'] == 'commentbox') {
                    survey_data += '<a style="text-decoration:none; color:#333;">';
                    survey_data += '  <textarea class="inherit-width" style="width:50%"></textarea>';
                    survey_data += '</a>';
                } else if (questions['que_type'] == 'multiselectlist') {
                    survey_data += '<a><select class="select2" data-placeholder="Select" multiple>';
                    $.each(questions['answers'], function (index, ans)
                    {
                        $.each(ans, function (key, answer)
                        {
                            survey_data += '  <option>' + answer['option'] + '</option>';
                        });
                    });
                    //enable other option
                    if (questions['other_option'])
                    {
                        $.each(questions['other_option'], function (aid, values) {
                            other_option_label = values['option'];
                        });
                        if (other_option_label)
                        {
                            survey_data += '  <option>' + other_option_label + '</option>';
                        }
                    }
                    survey_data += '</select></a>';
                } else if (questions['que_type'] == 'dropdownlist') {
                    survey_data += '<a><select class="select2" data-placeholder="Select">';
                    $.each(questions['answers'], function (index, ans)
                    {
                        $.each(ans, function (key, answer)
                        {
                            survey_data += '  <option>' + answer['option'] + '</option>';
                        });
                    });
                    //enable other option
                    if (questions['other_option'])
                    {
                        $.each(questions['other_option'], function (aid, values) {
                            other_option_label = values['option'];
                        });
                        if (other_option_label)
                        {
                            survey_data += '  <option>' + other_option_label + '</option>';
                        }
                    }
                    survey_data += '</select></a>';
                } else if (questions['que_type'] == 'radio-button') {
                    survey_data += '<a style="text-decoration:none; color:#333;">';
                    $.each(questions['answers'], function (index, ans)
                    {
                        $.each(ans, function (key, answer)
                        {

                            if (questions['is_image_option'] == 'Yes') {
                                survey_data += '<div class="image_display"><img src="' + answer['radio_image'] + '"/><div><input type="radio" name="radio_' + questions['que_id'] + '" />' + answer['option'] + '</div></div>';
                            } else {
                                survey_data += '<input type="radio" name="radio_' + questions['que_id'] + '"/>' + answer['option'] + '<br/>';
                            }
                        });
                    });
                    //enable other option
                    if (questions['other_option'])
                    {
                        $.each(questions['other_option'], function (aid, values) {
                            other_option_label = values['option'];
                            other_option_image = values['other_image'];
                        });
                        if (questions['is_image_option'] == 'Yes' && other_option_image && other_option_label) {
                            survey_data += '<div class="image_display"><img src="' + other_option_image + '"/><div><input type="radio" name="radio_' + questions['que_id'] + '" />' + other_option_label + '</div></div>';
                        } else if (other_option_label)
                        {
                            survey_data += '<input name="radio_' + questions['que_id'] + '" type="radio" />' + other_option_label + '<br/>';
                        }
                    }
                    survey_data += '</select></a>';
                } else if (questions['que_type'] == 'check-box') {
                    survey_data += '<a style="text-decoration:none; color:#333;">';
                    $.each(questions['answers'], function (index, ans)
                    {
                        $.each(ans, function (key, answer)
                        {

                            if (questions['is_image_option'] == 'Yes') {
                                survey_data += '<div class="image_display"><img src="' + answer['radio_image'] + '"/><div><input type="checkbox" />' + answer['option'] + '</div></div>';
                            } else {
                                survey_data += '<input type="checkbox" />' + answer['option'] + '<br/>';
                            }
                        });
                    });
                    //enable other option
                    if (questions['other_option'])
                    {
                        $.each(questions['other_option'], function (aid, values) {
                            other_option_label = values['option'];
                        });
                        if (other_option_label)
                        {
                            survey_data += '<input type="checkbox" />' + other_option_label + '<br/>';
                        }
                    }
                    survey_data += '</select></a>';
                } else if (questions['que_type'] == 'contact-information') {
                    survey_data += '<a style="text-decoration:none; color:#333;">';
                    survey_data += '<div class="row">';
                    survey_data += '    <div class="span6"><input placeholder="Name *" type="text"></div>';
                    survey_data += '    <div class="span6"><input placeholder="Email Address *"  type="text"></div>';
                    survey_data += '</div>';
                    survey_data += '<div class="row">';
                    survey_data += '    <div class="span6"><input placeholder="Company"  type="text"></div>';
                    survey_data += '    <div class="span6"><input placeholder="Phone Number *"  type="text"></div>';
                    survey_data += '</div>';
                    survey_data += '<div class="row">';
                    survey_data += '    <div class="span6"><input placeholder="Street1"   type="text"></div>';
                    survey_data += '    <div class="span6"><input placeholder="Street2"   type="text"></div>';
                    survey_data += '</div>';
                    survey_data += '<div class="row">';
                    survey_data += '    <div class="span6"><input placeholder="City/Town"   type="text"></div>';
                    survey_data += '    <div class="span6"><input placeholder="State/ Province"  type="text"></div>';
                    survey_data += '</div>';
                    survey_data += '<div class="row">';
                    survey_data += '    <div class="span6"><input placeholder="ZIP/ Postal Code"  type="text"></div>';
                    survey_data += '    <div class="span6"><input placeholder="Country"  type="text"></div>';
                    survey_data += '</div>';
                    survey_data += '</a>';
                } else if (questions['que_type'] == 'rating') {
                    survey_data += '<i class="fa fa-star fa-2x" style="font-size:18px;color:#F4B30A; margin-right:3px;"> </i>';
                    survey_data += '<i class="fa fa-star fa-2x" style="font-size:18px;color:#F4B30A; margin-right:3px;"> </i>';
                    survey_data += '<i class="fa fa-star fa-2x" style="font-size:18px;color:#F4B30A; margin-right:3px;"> </i>';
                    survey_data += '<i class="fa fa-star fa-2x" style="font-size:18px;color:#F4B30A; margin-right:3px;"> </i>';
                    survey_data += '<i class="fa fa-star fa-2x" style="font-size:18px; margin-right:3px;"> </i>';
                } else if (questions['que_type'] == 'date-time') {
                    survey_data += '<a style="text-decoration:none; color:#333;">';
                    survey_data += '  <input type="text" class="inherit-width" style="width:50%" />';
                    survey_data += '</a>';
                } else if (questions['que_type'] == 'image') {
                    if (helptips != '' && helptips != null) {
                        survey_data += '<p>' + helptips + '<p>';
                    }
                    if (questions['que_title'] == "uploadImage") {
                        survey_data += '  <img src="' + questions['matrix_row'] + '" class="inherit-width" width="30%" height="30%" />';
                    } else {
                        survey_data += '  <img src="' + questions['advance_type'] + '" class="inherit-width" width="30%" height="30%" />';
                    }
                }
                // To display rich text content in survey/survey template detailview. By GSR
                else if (questions['que_type'] == 'richtextareabox') {
                    survey_data += '<p>' + questions['richtextContent'] + '<p>';
                }
                // End 
                else if (questions['que_type'] == 'video') {
                    if (helptips != '' && helptips != null) {
                        survey_data += '<p>' + helptips + '<p>';
                    }
                    survey_data += ' <a>' + questions['advance_type'] + '</a>';
                } else if (questions['que_type'] == 'matrix') {
                    var rows = jQuery.parseJSON(questions['matrix_row']);
                    var cols = jQuery.parseJSON(questions['matrix_col']);
                    //count number of rows & columns
                    var row_count = Object.keys(rows).length + 1;
                    var col_count = Object.keys(cols).length;
                    // adjusting div width as per column
                    var width = Math.round(70 / (col_count + 1)) - 1;
                    survey_data += '<a style="text-decoration:none; color:#333;">';
                    if (questions['advance_type'] == 'checkbox') {
                        var display_type = 'checkbox';
                    } else {
                        var display_type = 'radio';
                    }
                    survey_data += '<div class="matrix-tbl-contner">';
                    survey_data += '<table class="survey_tmp_matrix" class="row">';
                    for (var i = 1; i <= row_count; i++) {

                        survey_data += '<tr class="row">';
                        for (var j = 1; j <= col_count + 1; j++) {

                            //First row & first column as blank
                            if (j == 1 && i == 1) {
                                survey_data += "<th class='matrix-span' style='width:" + width + "%;text-align:left;'>&nbsp;</th>";
                            }
                            // Rows Label
                            if (j == 1 && i != 1) {
                                survey_data += "<th class='matrix-span' style='font-weight:bold; width:" + width + "%;;text-align:left;'>" + rows[i - 1] + "</th>";
                            } else {
                                //Columns label
                                if (j <= col_count + 1 && cols[j - 1] != null && !(j == 1 && i == 1) && (i == 1 || j == 1))
                                {
                                    survey_data += "<th class='matrix-span' style='font-weight:bold; width:" + width + "%;'>" + cols[j - 1] + "</th>";
                                }
                                //Display answer input (RadioButton or Checkbox)
                                else if (j != 1 && i != 1 && cols[j - 1] != null) {
                                    var row = i - 1;
                                    var col = j - 1;
                                    survey_data += "<td class='matrix-span' style='width:" + width + "%; '><input type='" + display_type + "' id='[" + row + "][" + col + "]' name='matrix" + row + "'/></td>";
                                }
                                // If no value then display none
                                else {
                                    survey_data += "";
                                }
                            }
                        }
                        survey_data += "</td>";
                    }
                    survey_data += "</tr>";
                    survey_data += '</table></div>';
                    survey_data += '</a>';
                } else if (questions['que_type'] == 'emojis') {
                    var op_count = 0;
                    var emojisImges = {
                        0: "<img src='custom/include/images/ext-unsatisfy.png' />",
                        1: "<img src='custom/include/images/unsatisfy.png'  />",
                        2: "<img src='custom/include/images/nuteral.png' />",
                        3: "<img src='custom/include/images/satisfy.png' />",
                        4: "<img src='custom/include/images/ext-satisfy.png'/>",
                    };
                    $.each(questions['answers'], function (index, ans)
                    {
                        $.each(ans, function (key, answer)
                        {
                            survey_data += '<div style="margin-bottom: 2px;width: 100%;display: inline-flex;"><div style="width:3%;">' + emojisImges[op_count] + '</div><div id="option_' + op_count + '" class="options" style="margin-left: 10px;width: 100%;margin-top: 2px;">';
                            survey_data += '       <span style="margin-left:1px;">' + answer['option'] + '</span>';
                            survey_data += '</div></div>';
                            op_count++;
                        });
                    });
                }
            }
            if (questions['que_type'] != 'boolean')
            {
                survey_data += '</div>';
                survey_data += '</div>';
            }


            // sync field display
            var sync_field = questions['sync_field'];
            if (enable_data_piping == 'Yes' && questions['disable_piping'] != 'Yes' && sync_field)
            {
                survey_data += '<div class="row">';
                survey_data += '<div class="span1">Sync Field</div>';
                if (questions['que_type'] == 'boolean')
                {
                    survey_data += '<div class="span11">' + this.sync_module_fields_for_boolean[this.model.get('sync_module')][sync_field] + '</div>';
                } else {
                    survey_data += '<div class="span11">' + this.sync_module_fields[this.model.get('sync_module')][sync_field] + '</div>';
                }
                survey_data += '</div>';
            }

            survey_data += '</div>';
        }
        $(survey_data).appendTo($('#page_' + page_sequence).find('#data-page_' + page_sequence));
        self.$el.parents('.main-pane').find('#data-page').show();
    },
    /**
     * display detail view of all component
     * 
     * @page_id current page id
     * @survey_details all page & question detail
     * @is_loading if detailview is not fully loaded till that hide editing option
     */
    detailview_data: function (page_id, survey_details, is_loading) {
        if (survey_details != 'null') {
            var survey_data = '';
            if (this.$el != null) {
                this.$el.removeClass('edit');
                this.$el.addClass('detail');
            }
            var self = this;
            var detail_of_survey = jQuery.parseJSON(survey_details);
            var question_sequence = 1;
            var page_sequence = 1;
            var show_remove_button = new Object();
            var que = new Object();
            self.themeDetailView(detail_of_survey['survey_theme']);
            self.$el.parents('.main-pane').find('.Survey_Pages').html('');
            // for each question generate its element to display
            var enable_data_piping = detail_of_survey['enable_data_piping'];
            $.each(jQuery.parseJSON(survey_details), function (k, detail) {
                if (k != 'survey_theme' && k != 'enable_data_piping') {

                    self.detailviewPage_data(detail, page_sequence);
                    //if edit mode is on then display input fields
                    if (page_sequence == page_id) {
                        $('<div id="data-page_' + page_sequence + '" class="data-page" data-dashlet="dashlet">').appendTo('#page_' + page_sequence);
                    } else if ((self.model && self.model.get('survey_type') == 'poll') || (self.context && self.context.attributes.IsPOll)) {
                        $('<div id="data-page_' + page_sequence + '" class="data-page"  data-dashlet="dashlet">').appendTo('#page_' + page_sequence);
                    } else {// otherwise display in label
                        $('<div id="data-page_' + page_sequence + '" class="data-page" style="display:none;" data-dashlet="dashlet">').appendTo('#page_' + page_sequence);
                    }
                    if (detail['page_questions'] != null) // check whether page has questions or not
                    {
                        $.each(detail['page_questions'], function (i, questions)
                        {
                            self.detailviewQuestion_data(questions, page_sequence, question_sequence, enable_data_piping);
                            //update question counter
                            question_sequence++;
                        });
                    }
                    //update page counter
                    page_sequence++;
                }
            });
            if (is_loading == "true") {
                self.restrictEditloading = "";
                app.alert.dismiss('loading_detail_view');
                if (self.restrictEdit != 'true')
                {
                    self.$el.parents('.main-pane').find('[name=edit_button]').removeClass('disabled');
                }
            }
        }
    },
    /**
     * set id for save & cancel button to override it easily & show save button when edit clicked
     */
    show_save_button: function () {
        var self = this;
        if (self.$el.parents('.main-pane').find('.fieldset.actions.detail.btn-group')) {
            self.$el.parents('.main-pane').find('.fieldset.actions.detail.btn-group').addClass('hide');
            self.$el.parents('.main-pane').find('.fieldset.actions.detail.btn-group').parent().find($('[name="cancel_button"]')).removeClass('hide').attr({'style': '', 'id': 'cancel_edit'});
            self.$el.parents('.main-pane').find('.fieldset.actions.detail.btn-group').parent().find($('[name="save_button"]')).removeClass('hide').attr({'style': '', 'id': 'save_edit'});
        }
    },
    /**
     * save button clicked so save the record after validation complete
     * 
     * @page_id current page id
     * @survey_details all page & question detail
     * @is_loading if detailview is not fully loaded till that hide editing option
     */
    save_button_clicked: function () {

        var self = this;
        if (self.model && self.model.get('survey_type') == 'poll')
        {
            var sent_msg = 'This Poll Is Now Active and Cannot Be Edited, Please Create a New Poll.';
        } else {
            var sent_msg = 'This Survey Is Now Active and Cannot Be Edited, Please Create a New Survey.';
        }
        // if record id is not null
        if (this.record_id != null)
        {
            // if restrict Edit record not set to true means allow to edit & save record then save the record
            if (self.restrictEdit == "true") {
                app.alert.show('error', {
                    level: 'error',
                    messages: sent_msg,
                    autoClose: true
                });
            }
            // if detailview not fully loaded then restrict all actions
            else if (self.restrictEditloading == "loading") {
                app.alert.show('error', {
                    level: 'error',
                    messages: 'Please wait while detailview is loading.',
                    autoClose: true
                });
            }
            // allow to edit so save the edited record
            else {
                var self = this;
                //set current record id 
                if (self.model != null) {
                    self.record_id = self.model.id;
                }
                var survey_theme = self.$el.parents('.main-pane').next('.sidebar-content').find('[name=survey_theme]:checked').val();
                var edited_survey_details = new Object();
                var survey_data = new Object();
                var survey_pages = new Object();
                var new_page_id = 0;
                // retrieve all detail to single object as well - formated to object name survey_data 
                self.$el.parents('.main-pane').find('.thumbnail').each(function () {

                    var id = this.id;
                    var page_id = self.$el.parents('.main-pane').find('#' + id).find('.page_id').val();
                    var page_sequence = id.split('_')[1];
                    var data_page = self.$el.parents('.main-pane').find('#data-' + id);
                    $(data_page).each(function () {

                        var page_detail = new Object();
                        var survey_questions = new Object();
                        var question_class_id = this.id;
                        self.$el.parents('.main-pane').find('#' + question_class_id).each(function () {

                            var que_class = self.$el.parents('.main-pane').find('#' + question_class_id).find('.question');
                            var new_question_id = 0;
                            var question_counter = 0;
                            self.$el.parents('.main-pane').find('#' + question_class_id).find($(que_class)).each(function () {

                                var que_section = this.id;
                                // add question object
                                var question_id = que_section.split('_')[1];
                                // question id to edit existing record
                                var que_id = self.$el.parents('.main-pane').find('#' + que_section).find($('.que_id')).val();
                                var survey_question_detail_main = new Array();
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
                                        var answer_detail_main = new Object();
                                        var skip_logic_details = new Object();
                                        count = que_section.split('_')[1];
                                        // Stored Rich text area record. By GSR
                                        var questionTypeValue = que_section.split('_')[0];
                                        if (questionTypeValue == "richtextareabox") {
                                            var question = self.$el.parents('.main-pane').find('[name="question_richtextbox_' + count + '"]').val();
                                            var richTextContent = self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').val();
                                        } else {
                                            var question = self.$el.parents('.main-pane').find('[name="question_' + que_section + '"]').val();
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
                                        } else if (self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("uploadsImage")) {
                                            survey_question_detail['question'] = "uploadImage";
                                        } else if (self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("imageURL")) {
                                            survey_question_detail['question'] = "imageURL";
                                        }

                                        //Get Piping Sync value for sync field
                                        if (self.$el.parents('.main-pane').find('[data-fieldname=enable_data_piping]').find('[type=checkbox]:checked').length != 0)
                                        {
                                            // Sync Field value
                                            var sync_field = self.$el.parents('.main-pane').find('[name="sync_field_' + que_section + '"]').val();
                                            if (sync_field && sync_field != 'Select Field')
                                            {
                                                survey_question_detail['sync_field'] = sync_field;
                                            }
                                            // Disable Piping value
                                            var disable_piping = self.$el.parents('.main-pane').find('[name=disable_piping_' + que_section + ']').prop('checked');
                                            survey_question_detail['disable_piping'] = disable_piping;

                                        }

                                        //getting score enable or not
                                        var enable_scoring = self.$el.parents('.main-pane').find('#' + que_section).find('.enableScore').find('input:checked').length;
                                        survey_question_detail['enable_scoring'] = enable_scoring;

                                        //Is image option enabled ?
                                        var is_image_option = self.$el.parents('.main-pane').find('#' + que_section).find('.isImageOption').find('input:checked').length;
                                        survey_question_detail['is_image_option'] = is_image_option;

                                        var helptips = self.$el.parents('.main-pane').find('[name="helptips_' + que_section + '"]').val();
                                        if (typeof helptips != "undefined") {
                                            helptips = helptips.trim();
                                        }
                                        survey_question_detail['helptips'] = helptips;
                                        // Add Display Label For Boolean Type
                                        var display_boolean_label = self.$el.parents('.main-pane').find('[name="display_label_' + que_section + '"]').val();
                                        if (typeof display_boolean_label != "undefined") {
                                            display_boolean_label = display_boolean_label.trim();
                                        }
                                        survey_question_detail['display_boolean_label'] = display_boolean_label;
                                        // End
                                        var is_required = self.$el.parents('.main-pane').find('[name="is_required_' + que_section + '"]').prop('checked');
                                        survey_question_detail['is_required'] = is_required;
                                        // Store Question Seperator 
                                        var is_question_seperator = self.$el.parents('.main-pane').find('[name="is_question_seperator_' + que_section + '"]').prop('checked');
                                        survey_question_detail['is_question_seperator'] = is_question_seperator;
                                        // setting que type field

                                        // Store File Size and File Extension
                                        var file_size = self.$el.parents('.main-pane').find('[name="file_size_' + que_section + '"]').val();
                                        survey_question_detail['file_size'] = file_size;
                                        var file_extension = self.$el.parents('.main-pane').find('[name="file_extension_' + que_section + '"]').val();
                                        survey_question_detail['file_extension'] = file_extension;
                                        // setting que type field

                                        if (self.$el.parents('.main-pane').find('[name=question-type]').length != 0)
                                        {
                                            var question_type = self.$el.parents('.main-pane').find('[name=question-type]:checked').val()
                                        } else {
                                            var question_type = que_section.substr(0, que_section.indexOf('_'));
                                        }
                                        survey_question_detail['que_type'] = question_type;
                                        if (question_type == 'textbox')
                                        {
                                            // setting que-data type for textbox field
                                            var datatype = self.$el.parents('.main-pane').find('[name="datatype_' + que_section + '"]').val();
                                            if (question_type == 'textbox' && datatype != null && datatype != "0") {
                                                survey_question_detail['datatype'] = datatype;
                                            }

                                            // setting max size for textbox & commentbox field
                                            var size = self.$el.parents('.main-pane').find('[name="size_' + que_section + '"]').val();
                                            if ((question_type == 'textbox' || question_type == 'commentbox') && typeof size != 'undefined') {
                                                survey_question_detail['maxsize'] = size;
                                            }

                                            // setting min value for textbox  field
                                            var min = self.$el.parents('.main-pane').find('[name="min_' + que_section + '"]').val();
                                            if ((question_type == 'textbox' && (datatype == 'Integer' || datatype == 'Float')) && typeof min != 'undefined') {
                                                survey_question_detail['minvalue'] = min;
                                            }

                                            // setting max value for textbox  field
                                            var max = self.$el.parents('.main-pane').find('[name="max_' + que_section + '"]').val();
                                            if ((question_type == 'textbox' && (datatype == 'Integer' || datatype == 'Float')) && typeof max != 'undefined') {
                                                survey_question_detail['maxvalue'] = max;
                                            }

                                            // setting precision for textbox  field
                                            var precision = self.$el.parents('.main-pane').find('[name="precision_' + que_section + '"]').val();
                                            if ((question_type == 'textbox' && datatype == 'Float') && typeof precision != 'undefined') {
                                                survey_question_detail['precision'] = precision;
                                            }
                                        }
                                        if (question_type == 'commentbox')
                                        {
                                            // setting rows for commentbox field
                                            var rows = self.$el.parents('.main-pane').find('[name="rows_' + que_section + '"]').val();
                                            if (question_type == 'commentbox' && typeof rows != 'undefined' && rows.trim() != null) {
                                                survey_question_detail['rows'] = rows.trim();
                                            }

                                            // setting cols for commentbox field
                                            var cols = self.$el.parents('.main-pane').find('[name="cols_' + que_section + '"]').val();
                                            if (question_type == 'commentbox' && typeof cols != 'undefined' && cols.trim() != null) {
                                                survey_question_detail['cols'] = cols.trim();
                                            }
                                        }
                                        //setting sorting for multichoice options
                                        var is_sort = self.$el.parents('.main-pane').find('[name="is_sort_' + que_section + '"]').prop('checked');
                                        if ((question_type == 'check-box' || question_type == 'radio-button' || question_type == 'dropdownlist' || question_type == 'multiselectlist') && typeof is_sort != 'undefined') {
                                            survey_question_detail['is_sort'] = is_sort;
                                        }

                                        //setting limit answer for multichoice options
                                        var limit_min = self.$el.parents('.main-pane').find('[name="limit_min_' + que_section + '"]').val();
                                        if ((question_type == 'check-box' || question_type == 'multiselectlist') && typeof limit_min != 'undefined') {
                                            survey_question_detail['limit_min'] = limit_min;
                                        }

                                        //setting show option text for multichoice options
                                        if (question_type == 'radio-button' || question_type == 'check-box') {
                                            var show_option_text = self.$el.parents('.main-pane').find('[name="show_option_text_' + que_section + '"]').prop('checked');
                                            if (typeof show_option_text != 'undefined') {
                                                survey_question_detail['show_option_text'] = show_option_text;
                                            }
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

                                            if ((question_type == 'radio-button' || question_type == 'check-box') && is_image_option) {

                                                if (typeof self.radio_image_content == "object" && typeof self.radio_image_content[count] != "undefined" && self.radio_image_content[count] != '' && typeof self.radio_image_content[count]['other'] != "undefined" && self.radio_image_content[count]['other'] != '') {
                                                    var radio_image = self.radio_image_content[count]['other'];
                                                    survey_question_detail['image_otherOption'] = radio_image;

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
                                        }
                                        if (question_type == 'contact-information' && typeof requireFields != 'undefined') {
                                            survey_question_detail['requireFields'] = requireFields;
                                        }
                                        if (question_type == 'date-time') {
                                            // setting isDateTime for DateTime field
                                            var is_datetime = self.$el.parents('.main-pane').find('[name="is_datetime_' + que_section + '"]').prop('checked');
                                            if (question_type == 'date-time' && typeof is_datetime != 'undefined') {
                                                survey_question_detail['is_datetime'] = is_datetime;
                                            }

                                            // setting start date for DateTime field
                                            var start_date = self.$el.parents('.main-pane').find('[name="startDate_' + que_section + '"]').val();
                                            if (question_type == 'date-time' && typeof start_date != 'undefined' && start_date.trim() != null) {
                                                survey_question_detail['start_date'] = start_date;
                                            }

                                            // setting end date for DateTime field
                                            var end_date = self.$el.parents('.main-pane').find('[name="endDate_' + que_section + '"]').val();
                                            if (question_type == 'date-time' && typeof end_date != 'undefined' && end_date.trim() != null) {
                                                survey_question_detail['end_date'] = end_date;
                                            }

                                            // Store Question Seperator 
                                            var allow_future_dates = self.$el.parents('.main-pane').find('[name="allow_future_dates_' + que_section + '"]').prop('checked');
                                            survey_question_detail['allow_future_dates'] = allow_future_dates;
                                        }
                                        // setting image for Image field
                                        if (question_type == 'image' && self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("uploadsImage")) {
                                            var uploadedImage = self.$el.parents('.main-pane').find('#' + que_section).find('.uploadedImage').attr('src');
                                            if (typeof self.image_content == "object" && typeof self.image_content[count] != "undefined" && self.image_content[count] != '') {
                                                var image = self.image_content[count];
                                            } else if (uploadedImage) {
                                                var image = uploadedImage;
                                            } else {
                                                var image = '';
                                            }

                                            if (question_type == 'image' && typeof image != 'undefined' && image != null) {
                                                survey_question_detail['image'] = image;
                                            }
                                        } else if (question_type == 'image' && self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class') != null && self.$el.parents('.main-pane').find('[name=uploadImageType_' + que_section + ']:checked').prop('class').includes("imageURL")) {
                                            var image = self.$el.parents('.main-pane').find('[name="urlType_' + que_section + '"]').val();
                                            if (question_type == 'image' && typeof image != 'undefined' && image.trim() != null) {
                                                survey_question_detail['image'] = image.trim();
                                            }
                                        }

                                        var video = self.$el.parents('.main-pane').find('[name="video-url_' + que_section + '"]').val();
                                        if (question_type == 'video' && typeof video != 'undefined' && video.trim() != null) {
                                            survey_question_detail['video'] = video.trim();
                                        }

                                        var description = self.$el.parents('.main-pane').find('[name="description_' + que_section + '"]').val();
                                        if (question_type == 'video' && typeof description != 'undefined' && description.trim() != null) {
                                            survey_question_detail['description'] = description.trim();
                                        }

                                        if (question_type == 'scale') {
                                            //setting display label for slider
                                            var left = self.$el.parents('.main-pane').find('[name="left_' + que_section + '"]').val();
                                            var middle = self.$el.parents('.main-pane').find('[name="middle_' + que_section + '"]').val();
                                            var right = self.$el.parents('.main-pane').find('[name="right_' + que_section + '"]').val();
                                            if (typeof left != 'undefined' && left.trim() != null && typeof middle != 'undefined' && middle.trim() != null && typeof right != 'undefined' && right.trim() != null) {
                                                survey_question_detail['label'] = left.trim() + '-' + middle.trim() + '-' + right.trim();
                                            }
                                            //setting start end & step values for slider
                                            var start = self.$el.parents('.main-pane').find('[name="start_' + que_section + '"]').val();
                                            var end = self.$el.parents('.main-pane').find('[name="end_' + que_section + '"]').val();
                                            var step = self.$el.parents('.main-pane').find('[name="step_' + que_section + '"]').val();
                                            if (typeof start != 'undefined' && start.trim() != null) {
                                                survey_question_detail['start'] = start.trim();
                                            }
                                            if (typeof end != 'undefined' && end.trim() != null) {
                                                survey_question_detail['end'] = end.trim();
                                            }
                                            if (typeof step != 'undefined' && step.trim() != null) {
                                                survey_question_detail['scale_slot'] = step.trim();
                                            }
                                        }

                                        if (question_type == 'netpromoterscore') {
                                            //setting display label for slider
                                            var left = self.$el.parents('.main-pane').find('[name="left_' + que_section + '"]').val();
                                            var right = self.$el.parents('.main-pane').find('[name="right_' + que_section + '"]').val();
                                            if (typeof left != 'undefined' && left.trim() != null && typeof right != 'undefined' && right.trim() != null) {
                                                survey_question_detail['label_netpromoterscore'] = left.trim() + '-' + right.trim();
                                            }
                                        }

                                        survey_question_detail['question_sequence'] = question_id;
                                        if (question_type == 'matrix') {
                                            // setting display type for matrix
                                            var display_type = self.$el.parents('.main-pane').find('[name="display_type_' + que_section + '"]:checked').val();
                                            if (typeof display_type != 'undefined' && display_type.trim() != null) {
                                                survey_question_detail['display_type'] = display_type.trim();
                                            }
                                            // setting rows & columns for a matrix type
                                            var answer_detail = new Object();
                                            answer_detail.rows = new Object();
                                            var rows_div = self.$el.parents('.main-pane').find('#matrix_row_div_' + question_id);
                                            rows_div.each(function () {
                                                var rowid = this.id;
                                                var row_count = 0;
                                                var row_error_flag = 0;
                                                self.$el.parents('.main-pane').find('#' + rowid).find(self.$el.parents('.main-pane').find('[name="row_matrix"]')).each(function () {
                                                    row_count++;
                                                    if (this.value.trim()) {

                                                        answer_detail['rows'][row_count] = this.value.trim();
                                                    }

                                                });
                                                survey_question_detail['rows'] = answer_detail['rows'];
                                            });
                                            answer_detail.cols = new Object();
                                            var cols_div = self.$el.parents('.main-pane').find('#matrix_column_div_' + question_id);
                                            cols_div.each(function () {
                                                var colid = this.id;
                                                var col_count = 0;
                                                var col_error_flag = 0;
                                                self.$el.parents('.main-pane').find('#' + colid).find(self.$el.parents('.main-pane').find('[name="column_matrix"]')).each(function () {
                                                    col_count++;
                                                    if (this.value.trim() != '') {

                                                        answer_detail['cols'][col_count] = this.value.trim();
                                                    }

                                                });
                                                survey_question_detail['cols'] = answer_detail['cols'];
                                            });
                                        }

                                        var options_div = self.$el.parents('.main-pane').find('#' + survey_question_detail['que_type'] + '_options_div_' + count);

                                        if (options_div.length == 0 && (self.model.get('survye_type') == 'poll' || (self.context && self.context.attributes.IsPOll)))
                                        {
                                            var old_question_type = que_section.substr(0, que_section.indexOf('_'));
                                            var options_div = self.$el.parents('.main-pane').find('#' + old_question_type + '_options_div_' + count);
                                        }
                                        options_div.each(function () {

                                            var opid = this.id;
                                            var option_id = 0;
                                            var new_option_id = 0;
                                            var null_option_count = 0;
                                            if (old_question_type)
                                            {
                                                self.$el.parents('.main-pane').find('#' + opid).find(self.$el.parents('.main-pane').find('[name="option_' + old_question_type + '"]')).each(function () {

                                                    var answer_detail = new Object();

                                                    option_id = this.id;
                                                    if (option_id != '') // Existing option editing
                                                    { // check for radio button and checkbox dont allow null options
                                                        if (survey_question_detail['que_type'] == "radio-button" || survey_question_detail['que_type'] == "check-box") {
                                                            if (this.value.trim() != '') {
                                                                answer_detail[this.id] = new Object();
                                                                answer_detail[this.id]['option'] = this.value.trim();


                                                                if (is_image_option) {
                                                                    if (typeof self.radio_image_content == "object" && typeof self.radio_image_content[count] != "undefined" && self.radio_image_content[count] != '' && typeof self.radio_image_content[count][this.id] != "undefined" && self.radio_image_content[count][this.id] != '') {
                                                                        var radio_image = self.radio_image_content[count][this.id];
                                                                        answer_detail[this.id]['radio_image'] = radio_image;
                                                                    }
                                                                }
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
                                                                    if (typeof self.radio_image_content == "object" && typeof self.radio_image_content[count] != "undefined" && self.radio_image_content[count] != '' && typeof self.radio_image_content[count][new_option_id] != "undefined" && self.radio_image_content[count][new_option_id] != '') {
                                                                        var radio_image = self.radio_image_content[count][new_option_id];
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
                                                var npsLogic0_6;
                                                var npsLogic7_8;
                                                var npsLogic9_10;
                                                self.$el.parents('.main-pane').find('#' + opid).find(self.$el.parents('.main-pane').find('[name="option_' + survey_question_detail['que_type'] + '"]')).each(function () {

                                                    var answer_detail = new Object();
                                                    var skip_logic_detail = new Object();
                                                    if ($(this).parents('.options').find('.score_weight').val())
                                                    {
                                                        var weight = $(this).parents('.options').find('.score_weight').val();
                                                    } else {
                                                        var weight = '0';
                                                    }
                                                    option_id = this.id;
                                                    if (option_id != '') // Existing option editing
                                                    { // check for radio button and checkbox dont allow null options
                                                        if (survey_question_detail['que_type'] == "radio-button" || survey_question_detail['que_type'] == "check-box") {
                                                            if (this.value.trim() != '') {
                                                                answer_detail[this.id] = new Object();
                                                                answer_detail[this.id]['option'] = this.value.trim();


                                                                if (is_image_option) {
                                                                    if (typeof self.radio_image_content == "object" && typeof self.radio_image_content[count] != "undefined" && self.radio_image_content[count] != '' && typeof self.radio_image_content[count][this.id] != "undefined" && self.radio_image_content[count][this.id] != '') {
                                                                        var radio_image = self.radio_image_content[count][this.id];
                                                                        answer_detail[this.id]['radio_image'] = radio_image;
                                                                    }
                                                                }

                                                                answer_detail_main[this.id] = answer_detail[this.id];
                                                                if (enable_scoring == 1) {
                                                                    answer_detail[this.id]['weight'] = weight;
                                                                }
                                                            }
                                                        } else { // for other fields allow only one null option
                                                            if (this.value.trim() != '') {
                                                                answer_detail[this.id] = new Object();
                                                                answer_detail[this.id]['option'] = this.value.trim();


                                                                if (is_image_option) {
                                                                    if (typeof self.radio_image_content == "object" && typeof self.radio_image_content[count] != "undefined" && self.radio_image_content[count] != '' && typeof self.radio_image_content[count][this.id] != "undefined" && self.radio_image_content[count][this.id] != '') {
                                                                        var radio_image = self.radio_image_content[count][this.id];
                                                                        answer_detail[this.id]['radio_image'] = radio_image;
                                                                    }
                                                                }

                                                                answer_detail_main[this.id] = answer_detail[this.id];
                                                                if (enable_scoring == 1) {
                                                                    answer_detail[this.id]['weight'] = weight;
                                                                }
                                                            } else {
                                                                if (null_option_count == 0) {
                                                                    answer_detail[this.id] = new Object();
                                                                    answer_detail[this.id]['option'] = this.value.trim();


                                                                    if (is_image_option) {
                                                                        var op_seq = $(this).parents('.options').attr('id').split('option_')[1];
                                                                        if (typeof self.radio_image_content == "object" && typeof self.radio_image_content[count] != "undefined" && self.radio_image_content[count] != '' && typeof self.radio_image_content[count][op_seq] != "undefined" && self.radio_image_content[count][op_seq] != '') {
                                                                            var radio_image = self.radio_image_content[count][op_seq];
                                                                            answer_detail[this.id]['radio_image'] = radio_image;
                                                                        }
                                                                    }

                                                                    answer_detail_main[this.id] = answer_detail[this.id];
                                                                    if (enable_scoring == 1) {
                                                                        answer_detail[this.id]['weight'] = weight;
                                                                    }
                                                                }
                                                                null_option_count++;
                                                            }
                                                        }
                                                        // Save/Add skip logic option for exist options
                                                        var logic_target = '';
                                                        var logic_action = self.$el.parents('.main-pane').find('#' + survey_question_detail['que_type'] + '_' + count).find('.skip_logic_options').find('#logicRows_table').find('.logicRow').find('#logic_actions_' + option_id).val();
                                                        logic_target = self.saveLogicOptionsOnSave(logic_action, survey_question_detail, count, option_id);
                                                        //  if (logic_action != 'no_logic') {
                                                        skip_logic_detail = {'logic_action': logic_action, 'logic_target': logic_target};
                                                        skip_logic_details[option_id] = skip_logic_detail;
                                                        // Apply 0,7 and 9 logc conditions on other options: like
                                                        // 0 logic condition on 0-6 option
                                                        // 7 logic condition on 7-8 option
                                                        // 9 logic condition on 9-10 option
                                                        // By Govind on 19-09-18
                                                        if (question_type == 'netpromoterscore') {
                                                            if (this.value.trim() == 0) {
                                                                npsLogic0_6 = option_id;
                                                            } else if (this.value.trim() == 7) {
                                                                npsLogic7_8 = option_id;
                                                            } else if (this.value.trim() == 9) {
                                                                npsLogic9_10 = option_id;
                                                            }

                                                            if (this.value.trim() > 0 && this.value.trim() <= 6) {
                                                                skip_logic_details[option_id] = survey_question_detail['skip_logic'][npsLogic0_6];
                                                            }
                                                            if (this.value.trim() > 6 && this.value.trim() <= 8) {
                                                                skip_logic_details[option_id] = survey_question_detail['skip_logic'][npsLogic7_8];
                                                            }
                                                            if (this.value.trim() > 9 && this.value.trim() <= 10) {
                                                                skip_logic_details[option_id] = survey_question_detail['skip_logic'][npsLogic9_10];
                                                            }
                                                        }
                                                        //  }
                                                        // End

                                                    } else  //New option added while edit
                                                    { // check for radio button and checkbox dont allow null options
                                                        // Save/Add skip logic option for new created options
                                                        var logic_target = '';
                                                        var logic_action = self.$el.parents('.main-pane').find('#' + survey_question_detail['que_type'] + '_' + count).find('.skip_logic_options').find('#logicRows_table').find('.logicRow').find('#logic_actions_' + this.parentElement.id).val();
                                                        logic_target = self.saveLogicOptionsOnSave(logic_action, survey_question_detail, count, this.parentElement.id);
                                                        // if (logic_action != 'no_logic') {
                                                        skip_logic_detail = {'logic_action': logic_action, 'logic_target': logic_target};
                                                        skip_logic_details['option_' + new_option_id] = skip_logic_detail;
                                                        //  }
                                                        // End
                                                        if (survey_question_detail['que_type'] == "radio-button" || survey_question_detail['que_type'] == "check-box") {
                                                            if (this.value.trim() != '') {
                                                                answer_detail['option_' + new_option_id] = new Object();
                                                                answer_detail['option_' + new_option_id]['option'] = this.value.trim();


                                                                if (is_image_option) {
                                                                    var op_seq = $(this).parents('.options').attr('id').split('option_')[1];
                                                                    if (typeof self.radio_image_content == "object" && typeof self.radio_image_content[count] != "undefined" && self.radio_image_content[count] != '' && typeof self.radio_image_content[count][op_seq] != "undefined" && self.radio_image_content[count][op_seq] != '') {
                                                                        var radio_image = self.radio_image_content[count][op_seq];
                                                                        answer_detail['option_' + new_option_id]['radio_image'] = radio_image;
                                                                    }
                                                                }

                                                                answer_detail_main['option_' + new_option_id] = answer_detail['option_' + new_option_id];
                                                                if (enable_scoring == 1) {
                                                                    answer_detail['option_' + new_option_id]['weight'] = weight;
                                                                }
                                                                new_option_id++;
                                                            }
                                                        } else { // for other fields allow only one null option
                                                            if (this.value.trim() != '') {
                                                                answer_detail['option_' + new_option_id] = new Object();
                                                                answer_detail['option_' + new_option_id]['option'] = this.value.trim();

                                                                if (is_image_option) {
                                                                    var op_seq = $(this).parents('.options').attr('id').split('option_')[1];
                                                                    if (typeof self.radio_image_content == "object" && typeof self.radio_image_content[count] != "undefined" && self.radio_image_content[count] != '' && typeof self.radio_image_content[count][op_seq] != "undefined" && self.radio_image_content[count][op_seq] != '') {
                                                                        var radio_image = self.radio_image_content[count][new_option_id];
                                                                        answer_detail[this.id]['radio_image'] = radio_image;
                                                                    }
                                                                }

                                                                answer_detail_main['option_' + new_option_id] = answer_detail['option_' + new_option_id];
                                                                if (enable_scoring == 1) {
                                                                    answer_detail['option_' + new_option_id]['weight'] = weight;
                                                                }
                                                                new_option_id++;
                                                            } else {
                                                                if (null_option_count == 0) {
                                                                    answer_detail['option_' + new_option_id] = new Object();
                                                                    answer_detail['option_' + new_option_id]['option'] = this.value.trim();

                                                                    if (is_image_option) {
                                                                        var op_seq = $(this).parents('.options').attr('id').split('option_')[1];
                                                                        if (typeof self.radio_image_content == "object" && typeof self.radio_image_content[count] != "undefined" && self.radio_image_content[count] != '' && typeof self.radio_image_content[count][op_seq] != "undefined" && self.radio_image_content[count][op_seq] != '') {
                                                                            var radio_image = self.radio_image_content[count][op_seq];
                                                                            answer_detail[this.id]['radio_image'] = radio_image;
                                                                        }
                                                                    }

                                                                    answer_detail_main['option_' + new_option_id] = answer_detail['option_' + new_option_id];
                                                                    if (enable_scoring == 1) {
                                                                        answer_detail['option_' + new_option_id]['weight'] = weight;
                                                                    }
                                                                    new_option_id++;
                                                                }
                                                                null_option_count++;
                                                            }
                                                        }
                                                    }

                                                    // add other field
                                                    // Save/Add skip logic option for exist options
                                                    var logic_target = '';
                                                    var option_id = self.$el.parents('.main-pane').find('[name="label_otherOption_' + que_section + '"]').attr('id');
                                                    var logic_action = self.$el.parents('.main-pane').find('#' + survey_question_detail['que_type'] + '_' + count).find('.skip_logic_options').find('#logicRows_table').find('.logicRow').find('#logic_actions_' + option_id).val();
                                                    logic_target = self.saveLogicOptionsOnSave(logic_action, survey_question_detail, count, option_id);
                                                    //  if (logic_action != 'no_logic') {
                                                    skip_logic_detail = {'logic_action': logic_action, 'logic_target': logic_target};
                                                    skip_logic_details[option_id] = skip_logic_detail;
                                                    survey_question_detail['answers'] = answer_detail_main;
                                                    survey_question_detail['skip_logic'] = skip_logic_details;
                                                });
                                            }
                                        });

                                        survey_question_detail_main[question_counter] = survey_question_detail;
                                    });
                                }
                                if (typeof que_id != "undefined") {
                                    survey_questions[que_id] = survey_question_detail_main[question_counter];
                                } else {
                                    survey_questions['question_' + new_question_id] = survey_question_detail_main[question_counter];
                                    new_question_id++;
                                }
                                question_counter++;
                            });
                        });
                        page_detail['questions'] = survey_questions;
                        var page_title = self.$el.parents('.main-pane').find('#' + id).find('#txt_page_title').val();
                        if (typeof page_title != "undefined" && page_title.trim() != "")
                        {
                            page_detail['page_title'] = page_title.trim();
                        }
                        page_detail['page_sequence'] = page_sequence;
                        if ((typeof page_title != "undefined" && page_title.trim() != "") || (self.model.get('survey_type') == 'poll' || (self.context && self.context.attributes.IsPOll))) {
                            if (typeof page_id != "undefined") {
                                survey_pages[page_id] = page_detail;
                            } else {
                                survey_pages['page_' + new_page_id] = page_detail;
                                new_page_id++;
                            }
                        }
                    });
                });

                survey_data['pages'] = survey_pages;
                survey_data['survey_theme'] = survey_theme;
                edited_survey_details = survey_data;
                var type = self.module;
                if (type == 'bc_survey_template') {
                    type = "SurveyTemplate";
                } else {
                    type = "";
                }

                //validate default fileds
                var allFields = this.options.view.AlreadyfieldsToValidate;
                this.model.doValidate(allFields, _.bind(this.validationComplete, this));
                // call api to save edited record via php
                var error_status = self.$el.parents('.main-pane').find($('.error-custom'));
                //validation of survey pages is valid
                if (error_status.length == 0) {

                    self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').hide(); // show side-pane page-component
                    self.$el.parents('.main-pane').find('#cancel_edit').attr('style', 'display:none;');
                    self.$el.parents('.main-pane').find('#save_edit').attr('style', 'display:none;');
                    var url = App.api.buildURL("bc_survey", "save_edited_survey");
                    App.api.call('create', url, {edited_survey_data: JSON.stringify(edited_survey_details), survey_id: self.record_id, remove_page_ids: JSON.stringify(self.remove_page_ids), remove_que_ids: JSON.stringify(self.remove_que_ids), remove_option_ids: JSON.stringify(self.remove_option_ids), type: type, individual_edit: self.individualEdit}, {
                        success: function (data) {
                            //add loading alert to aware user about detail view still loading
                            if (self.$el.parents('.main-pane').find(self.$el.parents('.main-pane').find('.error')).length == 0)
                            {
                                app.alert.show('loading_detail_view', {level: 'process', title: 'Loading', autoclose: false});
                                self.individualEdit = false;
                                document.getElementById('new-page').ondragstart = function () {
                                    return true;
                                };
                                self.$el.parents('.main-pane').find('[name=edit_button]').addClass('disabled');
                                self.restrictEditloading = "loading";
                            }

                            if (self.model.isValid && error_status.length == 0 && self.model.editAllPages && self.isValid) {
                                self.detailView('', self.record_id, "true");
                            } else if (self.model.editAllPages == false || self.model.editAllPages == null) {
                                self.detailView('', self.record_id, "true");
                            }

                        }
                    });

                }
                // survey pages validation fail
                else {
                    error_status.find('input[type=text]').filter(':first').focus();
                    App.alert.show('error-msg', {
                        level: 'error',
                        messages: 'Please resolve Survey Pages errors before proceeding.',
                        autoClose: true
                    });
                }
                //If not a single question added to each page then display error message
                self.$el.parents('.main-pane').find('.data-page').each(function () {
                    if (this.className.includes('error-custom')) {
                        App.alert.show('error-msg', {
                            level: 'error',
                            messages: 'Please set atleaset one question to each page.',
                            autoClose: true
                        });
                    }
                });
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

        var self = this;
        var error_status = self.$el.parents('.main-pane').find(self.$el.parents('.main-pane').find('.error-custom'));
        if (this.model.isValid && error_status.length == 0 && this.model.editAllPages) {
            this.isValid = true;
            self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').hide(); // hide side-pane page-component
        } else if (this.model.editAllPages || this.individualEdit) {
            this.isValid = false;
            if (this.model && (this.model.get('survey_type') != 'poll' || (this.context && !this.context.attributes.IsPOll)))
            {
                self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').show(); // show side-pane page-component
            }
            if (this.model && (this.model.get('survey_type') == 'poll' || (this.context && this.context.attributes.IsPOll)))
            {
                self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').show(); // show side-pane page-component
                self.$el.parents('.main-pane').next('.sidebar-content').find('.page_component').hide();
                self.$el.parents('.main-pane').next('.sidebar-content').find('#page_component_inner').hide();
                self.$el.parents('.main-pane').next('.sidebar-content').find('#custom_theme_inner').show();
            }

        }
    },
    /**
     * Edit button is clicked so enable all component in edit mode
     */
    edit_button_clicked: function () {
        var self = this;
        self.counter = 0;
        var url = App.api.buildURL("bc_survey", "isSurveySend", "", {record: self.record_id});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data && data['restrict_edit'] == "1") { // survey is send so disable all kind of edit of page
                    self.$el.parents('.main-pane').find('[name="edit_button"]').addClass('disabled');
                    self.restrictEdit = "true";
                } else { // survey is not send so enable all kind of edit
                    self.restrictEdit = "false";
                }
                if (self.model && self.model.get('survey_type') == 'poll')
                {
                    var sent_msg = 'This Poll Is Now Active and Cannot Be Edited, Please Create a New Poll.';
                } else {
                    var sent_msg = 'This Survey Is Now Active and Cannot Be Edited, Please Create a New Survey.';
                }
                // edit is restricted
                if (self.restrictEdit == "true") {
                    app.alert.show('error', {
                        level: 'error',
                        messages: sent_msg,
                        autoClose: true
                    });
                }
                //detailview is still loading
                else if (self.restrictEditloading == "loading") {
                    app.alert.show('error', {
                        level: 'error',
                        messages: 'Please wait while detailview is loading.',
                        autoClose: true
                    });
                }
                // edit mode enabled
                else {
                    self.$el.parents('.main-pane').find('.get_share_link').hide();
                    self.$el.parents('.main-pane').find('.open_link').hide();
                    self.$el.parents('.main-pane').find('.fieldset.actions.detail.btn-group').parent().find(self.$el.parents('.main-pane').find('[name="cancel_button"]')).attr({'style': '', 'id': 'cancel_edit'});
                    self.$el.parents('.main-pane').find('.fieldset.actions.detail.btn-group').parent().find(self.$el.parents('.main-pane').find('[name="save_button"]')).attr({'style': '', 'id': 'save_edit'});
                    self.editview_data('', '', '', self.survey_details);
                    self.$el.parents('.main-pane').find('.data-page').attr('style', ''); // open all page collpase
                    if ((self.model && self.model.get('survey_type') != 'poll') || (self.context && !self.context.attributes.IsPOll))
                    {
                        self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').show(); // show side-pane page-component
                    }
                    if ((self.model && self.model.get('survey_type') == 'poll') || (self.context && self.context.attributes.IsPOll))
                    {
                        self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').show(); // show side-pane page-component
                        self.$el.parents('.main-pane').next('.sidebar-content').find('.page_component').hide();
                        self.$el.parents('.main-pane').next('.sidebar-content').find('#page_component_inner').hide();
                        self.$el.parents('.main-pane').next('.sidebar-content').find('#custom_theme_inner').show();
                    }
                }
            }
        });
    },
    /**
     * edit view is enabled so enable all component in edit mode
     * 
     * @page_id current page id
     * @isIndividualEdit set to 1 then make only given page in edit mode other in detail mode
     * @CopyFromTemplate set to 1 then page component prefill with given data
     * @survey_details prefill data with given object details
     */
    editview_data: function (page_id, isIndividualEdit, CopyFromTemplate, survey_details) {
        var self = this;
        if (this.model && (this.model.get('survey_type') != 'poll' || (this.context && !this.context.attributes.IsPOll)))
        {
            self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').show(); // if page component is hidden then show it.
        }
        if (this.model && (this.model.get('survey_type') == 'poll' || (this.context && this.context.attributes.IsPOll)))
        {
            self.$el.parents('.main-pane').next('.sidebar-content').find('.create-survey').show(); // show side-pane page-component
            self.$el.parents('.main-pane').next('.sidebar-content').find('.page_component').hide();
            self.$el.parents('.main-pane').next('.sidebar-content').find('#page_component_inner').hide();
            self.$el.parents('.main-pane').next('.sidebar-content').find('#custom_theme_inner').show();
        }
        var survey_data = '';
        //if edit mode then change survyepages class to edit
        if (this.$el != null) {
            this.$el.removeClass('detail');
            this.$el.addClass('edit');
        }
        var self = this;
        var question_sequence = 1;
        var page_sequence = 1;
        self.$el.parents('.main-pane').find('.Survey_Pages').html('');
        // for each question generate its element to display
        if (survey_details != 'null')
        {
            var detail_of_survey = jQuery.parseJSON(survey_details);
            var enable_data_piping = detail_of_survey['enable_data_piping'];
            $.each(jQuery.parseJSON(survey_details), function (k, detail) {
                if (k != 'survey_theme' && k != 'enable_data_piping') {

                    // add given page div to edit record while individual edit
                    if (page_id != null && detail['page_number'] == page_id && isIndividualEdit) {
                        self.editviewPage_data(detail, page_sequence);
                    }
                    // add all pages div to edit record
                    else if (isIndividualEdit) {  //When Individual Page edit then display other than selected page in detail mode
                        self.detailviewPage_data(detail, page_sequence);
                    } else { //All page edit or copy from template the display all page in edit mode
                        self.editviewPage_data(detail, page_sequence, CopyFromTemplate);
                    }
                    //When Individual Page edit then display selected page in edit mode
                    if (page_id != null && detail['page_number'] == page_id && isIndividualEdit) {
                        $('<div id="data-page_' + page_sequence + '" class="data-page" data-dashlet="dashlet"></div>').appendTo(self.$el.parents('.main-pane').find('#page_' + page_sequence).find('[data-dashlet = "toolbar"]'));
                        if (detail['page_questions'] != null) // check whether page has questions or not
                        {
                            $.each(detail['page_questions'], function (i, questions)
                            {
                                // add Question divs in edit mode
                                self.editviewQuestion_data(questions, page_sequence, question_sequence);
                                question_sequence++;
                            });
                        }
                    }
                    //When Individual Page edit then display other than selected page in detail mode
                    else if (isIndividualEdit) {
                        $('<div id="data-page_' + page_sequence + '" class="data-page" style="display:none;" data-dashlet="dashlet">').appendTo('#page_' + page_sequence);
                        if (detail['page_questions'] != null) // check whether page has questions or not
                        {
                            $.each(detail['page_questions'], function (i, questions)
                            {
                                self.detailviewQuestion_data(questions, page_sequence, question_sequence, enable_data_piping);
                                //update question counter
                                question_sequence++;
                            });
                        }
                    }
                    //All page edit or copy from template the display all page in edit mode
                    else {
                        if (CopyFromTemplate == 1) { // open all dashlet collapse if copy from template
                            $('<div id="data-page_' + page_sequence + '" class="data-page" data-dashlet="dashlet">').appendTo('#page_' + page_sequence);
                        } else {
                            $('<div id="data-page_' + page_sequence + '" class="data-page" data-dashlet="dashlet">').appendTo('#page_' + page_sequence);
                        }
                        if (detail['page_questions'] != null) // check whether page has questions or not
                        {
                            $.each(detail['page_questions'], function (i, questions)
                            {
                                self.editviewQuestion_data(questions, page_sequence, question_sequence, CopyFromTemplate);
                                //update question counter
                                question_sequence++;
                            });
                        }
                    }
                    if ((self.model && self.model.get('survey_type') != 'poll') || (self.context && !self.context.attributes.IsPOll))
                    {
                        //add new question add placeholder block
                        $('<div id="placeholder" style=" border: 1px dashed #c6c6c6;height: 80px;  color:#c6c6c6; padding: 0px;  margin:10px;"><p style="padding-top:25px;" align="center">To add a question, simply drag it from the Page Component.</p></div>').appendTo(self.$el.parents('.main-pane').find('#data-page_' + page_sequence));
                    }
                    self.page_counter = page_sequence;
                    page_sequence++;
                }
                // If survey theme then save the current theme
                else {
                    $.each(self.$el.parents('.main-pane').next('.sidebar-content').find('[name=survey_theme]'), function () {
                        if (this.value == detail) {
                            this.checked = 'checked';
                        }
                    });
                }
            });
            self.que_counter = question_sequence;
        }
        if ((self.model && self.model.get('survey_type') != 'poll') || (self.context && !self.context.attributes.IsPOll))
        {
            $('<div class="SurveyPage" tabindex="-1"><p align="center">Add a Survey Page</p><div class="add-survey-page"><p align="center"><a><i style="opacity:0.8" class="fa fa-plus fa-4x" id="AddNewSurveyPage_icon"></i></a></p></div></div>').appendTo('.Survey_Pages');
            self.makeDraggable(); // make all pages & question block as droppable to add more questions

            self.$el.parents('.main-pane').find('.page_toggle').children().each(function () {
                this.className = "fa fa-chevron-up";
            }); //toggle collapse icon
        }
        if (CopyFromTemplate == 1) {
            // set current record id
            self.record_id = self.model.id;
        }

    },
    /**
     * pages in edit mode
     * 
     * @detail detail of pages
     * @page_sequence sequence of page
     * @CopyFromTemplate set to 1 then page component prefill with given data
     */
    editviewPage_data: function (detail, page_sequence, CopyFromTemplate) {
        var self = this;
        // add main page div to edit record
        $('.Survey_Pages').append("<div id='page_" + page_sequence + "'  class='thumbnail thumbnail_page dashlet'  style='margin-top:10px;margin-bottom:10px; min-height:0px;padding:0px;' ></div> ");
        if (CopyFromTemplate != 1) { // if copy from template then does not need to store ids
            self.$el.parents('.main-pane').find('#page_' + page_sequence).append("<input type='hidden' class='page_id' value='" + detail['page_id'] + "'/>");
        }
        self.$el.parents('.main-pane').find('#page_' + page_sequence).append("<div data-dashlet = 'toolbar' ></div>");
        //dashlet header
        $("<div class = 'dashlet-header'><div class='btn-toolbar pull-right'><span sfuuid='137' class='dashlet-toolbar'></span></div></div>").appendTo(self.$el.parents('.main-pane').find('#page_' + page_sequence).find('[data-dashlet = "toolbar"]'));
        //dashlet toolbar
        //show remove page option default as button
        var survey_data = '';
        survey_data += "<div class = 'btn-group' style='margin-top:5px;'><a class='btn remove_page' id='remove_page_" + page_sequence + "'><i data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" > </i>&nbsp; Remove</a>\n\
                                    <a class='btn dropdown-toggle' data-toggle='dropdown'> <i class='fa fa-caret-down'></i></a>";
        survey_data += '<ul class="dropdown-menu left setting-action" id="setting-action_' + page_sequence + '">';
        survey_data += '        <div>';
        //add page above the current page option
        survey_data += '                        <li><span sfuuid="44" class="dashlet-toolbar add_page_above">';
        survey_data += '<a href="javascript:void(0);" id="add_page_above_' + page_sequence + '">';
        survey_data += '    <i class="fa fa-angle-double-up">&nbsp;Add Page Above</i></a>';
        survey_data += '</span></li>';
        //add page below the current page option
        survey_data += '                        <li><span sfuuid="45" class="dashlet-toolbar add_page_below">';
        survey_data += '<a href="javascript:void(0);"  id="add_page_below_' + page_sequence + '">';
        survey_data += '    <i class="fa fa-angle-double-down">&nbsp;Add Page Below</i></a>';
        survey_data += '</span></li>';
        survey_data += '        </div>';
        survey_data += '    </ul>';
        survey_data += ' </div>';
        $(survey_data).appendTo(self.$el.parents('.main-pane').find('#page_' + page_sequence).find('.dashlet-toolbar'));
        //  if (CopyFromTemplate != 1) { // if copy from template then do not show collapse icon
        $('<div class="btn-group" style="margin-top:5px;"><a id=' + page_sequence + ' data-toggle="dropdown" rel="tooltip" title="" class="dropdown-toggle btn btn-invisible page_toggle" data-placement="bottom" data-original-title="Toggle Visibility"><i data-action="loading" class="fa fa-chevron-down" track="click:dashletToolbarCog"></i></a></div>').appendTo(self.$el.parents('.main-pane').find('#page_' + page_sequence).find('.btn-toolbar'));
        //  }
        //page title
        $('<h4 data-toggle="dashlet" style="min-height:20px; background-color:#c5c5c5; color:#555; " class="dashlet-title"> <div class=""> <input id="txt_page_title" name="txt_page_title" placeholder="(Required) Page Title" style="z-index:1; width:70%;height:20%; padding:4px; border-radius:3px;"/> <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span> </div></h4>').appendTo(self.$el.parents('.main-pane').find('#page_' + page_sequence).find('.dashlet-header'));
        //set page title
        if (this.model && (this.model.get('survey_type') == 'poll' || (this.context && this.context.attributes.IsPOll)))
        {
            self.$el.parents('.main-pane').find('#page_' + page_sequence).find('.btn-toolbar');
            self.$el.parents('.main-pane').find('#page_' + page_sequence).find('#txt_page_title').replaceWith('Poll Question');
            //  self.$el.parents('.main-pane').find('#page_' + page_sequence).find('#txt_page_title').parents('[data-dashlet="toolbar"]').hide();
        } else {
            self.$el.parents('.main-pane').find('#page_' + page_sequence).find('#txt_page_title').val(detail['page_title']);
        }
    },
    /**
     * questions in edit mode
     * 
     * @questions detail of questions
     * @page_sequence sequence of page
     * @question_sequence sequence of question
     * @CopyFromTemplate set to 1 then page component prefill with given data
     */
    editviewQuestion_data: function (questions, page_sequence, question_sequence, CopyFromTemplate) {
        var self = this;
        var show_remove_button = new Object();
        var que = new Object();
        var survey_data = '';
        if (CopyFromTemplate != 1) {
            var que_id_html = '<input type="hidden" class="que_id" value="' + questions['que_id'] + '"/>';
        } else {
            var que_id_html = '';
        }
        // If question is section header
        if (questions['que_type'] == 'section-header')
        {
            survey_data += '<div id="section_' + question_sequence + '" class=" question question-section" style="min-height:20px !important; border-radius: 10px 10px 0px 0px;">';
            survey_data += '<div class="row">';
            survey_data += '                    <div class="span1">Section Title</div>';
            survey_data += '                    <div class="span10">';
            survey_data += que_id_html;
            survey_data += '                        <input type="text" value="' + questions['que_title'] + '" placeholder="(Required) Section Title" id="section_title" class="inherit-width" style="margin-top:0; width:95%;"/>';
            survey_data += '                         <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
            survey_data += '                    </div>';
            survey_data += '                    <div class="span1"><div class="btn" style="margin-bottom:2px;"><i class="fa fa-times remove-section"  title="Remove Section Header"></i></div></div>';
            survey_data += '</div>';
            $(survey_data).appendTo(self.$el.parents('.main-pane').find('#page_' + page_sequence).find('#data-page_' + page_sequence));
        }
        // if question
        else {
            var survey_body = 'survey-body';

            if (this.model && (this.model.get('survey_type') == 'poll' || (this.context && this.context.attributes.IsPOll)))
            {
                survey_body = '';
            }
            survey_data += '<div id="' + questions['que_type'] + '_' + question_sequence + '" class="que_' + question_sequence + ' question ' + survey_body + '">';
            survey_data += '                        <input type="hidden" value="' + questions['sync_field'] + '" class="previous_sync_field" />';
            survey_data += que_id_html;
            //Question first row for remove question action
            survey_data += '<div class="row">';
            if (questions['que_type'] == 'multiselectlist' || questions['que_type'] == 'dropdownlist' || questions['que_type'] == 'radio-button' || questions['que_type'] == 'check-box' || questions['que_type'] == 'boolean' || questions['que_type'] == 'netpromoterscore' || questions['que_type'] == 'emojis') {
                // Show Logic Tab In Only Survey Module And Only Edit Mode.
                if (this.module == 'bc_survey' && (this.record_id != '' && this.record_id != null)) {
                    survey_data += '  <div class="span8">';
                } else {
                    survey_data += '  <div class="span6">';
                }
            } else {
                survey_data += '  <div class="span6">';
            }
            if (questions['que_type'] != 'additional-text')
            {
                survey_data += '    <div class="dashlet-tabs tab3 tabbable nav nav-tabs">';
                survey_data += '      <div class="dashlet-tabs-row">';
                survey_data += '          <div class="dashlet-tab active general">General</div>';
                survey_data += '          <div class="dashlet-tab advance">Advanced Option</div>';
                // To Show Skip logic Tab On EditView Loading not create mode

                if (questions['que_type'] == 'multiselectlist' || questions['que_type'] == 'dropdownlist' || questions['que_type'] == 'radio-button' || questions['que_type'] == 'check-box' || questions['que_type'] == 'boolean' || questions['que_type'] == 'netpromoterscore' || questions['que_type'] == 'emojis') {
                    // Show Logic Tab In Only Survey Module And Only Edit Mode.
                    if (this.module == 'bc_survey' && (this.record_id != '' && this.record_id != null)) {
                        survey_data += '<div class="dashlet-tab skip_logic"><i class="fa">&nbsp;</i>Logic</div>';
                    }
                }
                if (self.$el.parents('.main-pane').find('[name="sync_module"]').val() && questions['que_type'] != 'doc-attachment' && questions['que_type'] != 'richtextareabox' && questions['que_type'] != 'emojis')
                {
                    survey_data += '          <div class="dashlet-tab piping">Piping</div>';
                }
                // End
                survey_data += '      </div>';
                survey_data += '     </div>';
            }
            survey_data += '    </div>';
            if (questions['que_type'] == 'multiselectlist' || questions['que_type'] == 'dropdownlist' || questions['que_type'] == 'radio-button' || questions['que_type'] == 'check-box' || questions['que_type'] == 'boolean' || questions['que_type'] == 'netpromoterscore' || questions['que_type'] == 'emojis') {
                // Show Logic Tab In Only Survey Module And Only Edit Mode.
                if (this.module == 'bc_survey' && (this.record_id != '' && this.record_id != null)) {
                    survey_data += '    <div class="span4 que-close">';
                } else {
                    survey_data += '    <div class="span6 que-close">';
                }
            } else {
                survey_data += '    <div class="span6 que-close">';
            }
            survey_data += "<div class = 'btn-group right-close-add-div add_section_header' style='margin-top:5px;float:right !important;'>";
            survey_data += ' <a class="btn" href="javascript:void(0);" title="Add Section Header" id="add_section_header_' + question_sequence + '">';
            survey_data += '    <i class="fa  fa-pause  fa-rotate-90  showQuestionSection" style="font-size:10px;">&nbsp;</i></a>';
            survey_data += "  <a class='btn remove_que' id='que-remove' title='Remove Question'><i  id='remove_que_" + question_sequence + "' data-action = \"loading\" class = \"fa fa-times\"  track = \"click:dashletToolbarCog\" ></i> </a> ";
            survey_data += "</div>";
            survey_data += "</div>";
            survey_data += '    </div>';
            $(survey_data).appendTo(self.$el.parents('.main-pane').find('#page_' + page_sequence).find('#data-page_' + page_sequence));
            survey_data = '';
            // General option div start
            survey_data += "<div class='general_options'>";
            // question type
            survey_data += "<div class='row'>";
            if ((self.model && self.model.get('survey_type') == 'poll') || (self.context && self.context.attributes.IsPOll)) {
                survey_data += "       <div class='span1'>Type</div><div class='span5 '>";
            } else if (questions['que_type'] == 'radio-button' || questions['que_type'] == 'check-box') {
                survey_data += "       <div class='span1'>Type</div><div class='span3 '>";
            } else {
                survey_data += "       <div class='span1'>Type</div><div class='span5 '>";
            }

            if ((self.model && self.model.get('survey_type') == 'poll') || (self.context && self.context.attributes.IsPOll))
            {
                var selected = '';
                if (questions['que_type'] == 'radio-button')
                {
                    selected = 'checked';
                }

                survey_data += "<input  type='radio' name='question-type' value='radio-button' " + selected + "/>&nbsp; <i class='fa fa-dot-circle-o' style='font-size:13px;'>&nbsp; Radio Button </i>";
                selected = '';
                if (questions['que_type'] == 'check-box')
                {
                    selected = 'checked';
                }
                survey_data += "&nbsp;<input  type='radio' name='question-type' value='check-box' " + selected + "/>&nbsp; <i class='fa fa-check-square-o' style='font-size:13px;'>&nbsp; CheckBox </i>";

            } else {
                if (questions['que_type'].split('_')[1] != null && questions['que_type'].split('_')[0] == 'textbox') {
                    var question_type = 'textbox'; //Answer Type Display in detail view
                    var question_datatype = questions['que_type'].split('_')[1]; //If textbox then display it as defined datatype
                } else {
                    var question_type = questions['que_type']; //Answer Type Display in detail view
                }
                if (question_type == "textbox") {
                    survey_data += '<i class="fa fa-file-text-o" style="font-size:13px;">&nbsp; TextBox </i>';
                } else if (question_type == "commentbox") {
                    survey_data += '<i class="fa fa-comments-o" style="font-size:13px;">&nbsp; Comment TextBox</i>';
                } else if (question_type == "richtextareabox") {
                    survey_data += '<i class="fa fa-comment" style="font-size:13px;">&nbsp; Rich TextBox</i>';
                } else if (question_type == "multiselectlist") {
                    survey_data += '<i class="fa fa-list-ul" style="font-size:13px;">&nbsp; MultiSelect List </i>';
                } else if (question_type == "check-box") {
                    survey_data += '<i class="fa  fa-check-square-o" style="font-size:13px;">&nbsp; CheckBox </i>';
                } else if (question_type == "dropdownlist") {
                    survey_data += '<i class="fa fa-chevron-down" style="font-size:13px;">&nbsp; Dropdown List </i>';
                } else if (question_type == "radio-button") {
                    survey_data += '<i class="fa fa-dot-circle-o" style="font-size:13px;">&nbsp; Radio Button </i>';
                } else if (question_type == "contact-information") {
                    survey_data += '<i class="fa fa-list-alt" style="font-size:13px;">&nbsp; Contact Information </i>';
                } else if (question_type == "rating") {
                    survey_data += '<i class="fa fa-star" style="font-size:13px;">&nbsp; Rating </i>';
                } else if (question_type == "date-time") {
                    survey_data += '<i class="fa fa-calendar" style="font-size:13px;">&nbsp; DateTime </i>';
                } else if (question_type == "image") {
                    survey_data += '<i class="fa fa-picture-o" style="font-size:13px;">&nbsp; Image </i>';
                } else if (question_type == "video") {
                    survey_data += '<i class="fa fa-video-camera" style="font-size:13px;">&nbsp; Video </i>';
                } else if (question_type == "scale") {
                    survey_data += '<i class="fa fa-arrows-h" style="font-size:13px;">&nbsp; Scale </i>';
                } else if (question_type == "matrix") {
                    survey_data += '<i class="fa fa-th" style="font-size:13px;">&nbsp; Matrix </i>';
                } else if (question_type == "doc-attachment") {
                    survey_data += '<i class="fa fa-paperclip" style="font-size:13px;">&nbsp; Attachment </i>';
                } else if (question_type == "boolean") {
                    survey_data += '<i class="fa  fa-check" style="font-size:13px;">&nbsp; Boolean </i>';
                } else if (question_type == "additional-text") {
                    survey_data += '<i class="fa fa-pencil-square-o" style="font-size:13px;">&nbsp; Additional Text </i>';
                } else if (question_type == "netpromoterscore") {
                    survey_data += '<i class="fa fa-dashboard" style="font-size:13px;">&nbsp; NPS </i>';
                } else if (question_type == "emojis") {
                    survey_data += '<i class="fa fa-meh-o" style="font-size:13px;">&nbsp; Emojis </i>';
                }
            }
            //edit que type dropdown
            // survey_data += self.dropDownEditQueType(questions, question_sequence);
            if (question_type != "additional-text" && (self.model && self.model.get('survey_type') != 'poll'))
            {
                survey_data += " &nbsp;<i class='fa fa-pencil queTypeChange'></i></div>"; //question type span complete
            } else {
                survey_data += "</div>";
                survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Show Image Option? </div>";
                if (questions['is_image_option'] == 'Yes')
                {
                    survey_data += "      <div class='span1 isImageOption'><input type='checkbox' name='is_image_option_" + question_type + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
                } else {
                    survey_data += "      <div class='span1 isImageOption'><input type='checkbox' name='is_image_option_" + question_type + "_" + question_sequence + "' class='inherit-width'/></div>";
                }
                survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Show Option Text? </div>";
                if (questions['show_option_text'] == 'Yes')
                {
                    survey_data += "      <div class='span1'><input type='checkbox' name='show_option_text_" + question_type + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
                } else {
                    survey_data += "      <div class='span1'><input type='checkbox' name='show_option_text_" + question_type + "_" + question_sequence + "' class='inherit-width'/></div>";
                }
            }

            if ((question_type == 'multiselectlist' || question_type == 'dropdownlist' || questions['que_type'] == 'boolean') && (this.model && (this.model.get('survey_type') != 'poll') || (this.context && !this.context.attributes.IsPOll)))
            {
                survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Enable Scoring </div>";
                if (questions['enable_scoring'] == 'Yes')
                {
                    survey_data += "      <div class='span2 enableScore'><input type='checkbox' name='enable_scoring_" + question_type + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
                } else {
                    survey_data += "      <div class='span2 enableScore'><input type='checkbox' name='enable_scoring_" + question_type + "_" + question_sequence + "' class='inherit-width'/></div>";
                }
            }

            if (question_type == 'radio-button' || question_type == 'check-box')
            {
                survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Enable Scoring </div>";
                if (questions['enable_scoring'] == 'Yes')
                {
                    survey_data += "      <div class='span2 enableScore'><input type='checkbox' name='enable_scoring_" + question_type + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
                } else {
                    survey_data += "      <div class='span2 enableScore'><input type='checkbox' name='enable_scoring_" + question_type + "_" + question_sequence + "' class='inherit-width'/></div>";
                }

                survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Show Image Option? </div>";
                if (questions['is_image_option'] == 'Yes')
                {
                    survey_data += "      <div class='span2 isImageOption'><input type='checkbox' name='is_image_option_" + question_type + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
                } else {
                    survey_data += "      <div class='span2 isImageOption'><input type='checkbox' name='is_image_option_" + question_type + "_" + question_sequence + "' class='inherit-width'/></div>";
                }
            }
            survey_data += "</div>"; //type row complete here

            // Question and Answer Display
            var question_title = '';
            if (questions['que_title'] != 'N/A' && questions['que_title'] != null) {
                question_title = questions['que_title'];
            } else {
                question_title = '';
            }
            if (questions['que_type'] == "image") {
                survey_data += "<div class='row'>";
                survey_data += "       <div class='span1'>Image</div>";
                survey_data += "       <div class='span4'>";
                survey_data += "        <div class=''>";
                if (questions['que_title'] == 'uploadImage') {
                    survey_data += "          <input type='radio' name='uploadImageType_image_" + question_sequence + "' style=' margin-left:1px;  margin-top: 5px;' class='inherit-width uploadsImage uploadImageType' checked> Upload Image &nbsp;";
                } else {
                    survey_data += "          <input type='radio' name='uploadImageType_image_" + question_sequence + "' style=' margin-left:1px;  margin-top: 5px;' class='inherit-width uploadsImage uploadImageType'> Upload Image &nbsp;";
                }
                if (questions['que_title'] == 'imageURL') {
                    survey_data += "          <input type='radio' name='uploadImageType_image_" + question_sequence + "' style=' margin-left:1px;  margin-top: 5px;' class='inherit-width imageURL uploadImageType' checked> Image URL";
                } else {
                    survey_data += "          <input type='radio' name='uploadImageType_image_" + question_sequence + "' style=' margin-left:1px;  margin-top: 5px;' class='inherit-width imageURL uploadImageType'> Image URL";
                }
                survey_data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
                survey_data += "        </div>";
                survey_data += "      </div>";
                survey_data += "</div>";
                survey_data += "<div class='row'>";
                survey_data += "       <div class='span1'></div>";
                survey_data += "       <div class='span11'>";
                survey_data += "        <div class=''>";
                if (questions['que_title'] == 'uploadImage' && questions['matrix_row'] != '') {
                    survey_data += " <img  src='" + questions['matrix_row'] + "' width='20%' height='20%' class='inherit-width uploadedImage' /> ";
                    survey_data += "<a class='changeImageUploaded'><i class='fa fa-pencil'></i></a>";
                }
                survey_data += "          <input type='file' name='uploadType_image_" + question_sequence + "'  style=' margin-left:1px;' class='inherit-width uploadSurveyImage'> ";
                survey_data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
                survey_data += "        </div>";
                survey_data += "        <div class=''>";
                survey_data += "          <input type='text' name='urlType_image_" + question_sequence + "'  style=' margin-left:1px; max-width:80%;' placeholder='Image URL' class='inherit-width SurveyImageurl'>";
                survey_data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
                survey_data += "        </div>";
                survey_data += "      </div>";
                survey_data += "</div>";
            } else if (questions['que_type'] == "video") {
                //video URL
                survey_data += "<div class='row'>";
                survey_data += "       <div class='span1'>Video URL</div>";
                survey_data += "       <div class='span8'>";
                survey_data += "        <div class=''>";
                survey_data += "          <input type='text' name='video-url_video_" + question_sequence + "' placeholder='(Required) Video URL' style='max-width:100%; margin-left:1px;' value='" + questions['advance_type'] + "' class='inherit-width'>";
                survey_data += "        </div>";
                survey_data += "        </div>";
                survey_data += '        <div class="span3"> <span ><a><i style="margin-top: 6px;" class="fa fa-info-circle" title="i.e. https://www.youtube.com/embed/L3_gx6Fx_b0" ></i></a></span> </div>';
                survey_data += "</div>";
            } // govind
            else if (questions['que_type'] == "richtextareabox") {

                survey_data += "<div class='row'>";
                survey_data += "       <div class='span1'>Description</div>";
                survey_data += "       <div class='span11'>";
                survey_data += "        <div class=''>";
                survey_data += "          <textarea name='question_richtextareabox_" + question_sequence + "'  class='inherit-width' rows='4' cols='10'></textarea>";
                survey_data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
                survey_data += "        </div>";
                survey_data += "      </div>";
                survey_data += "</div>";
            } else {
                survey_data += "<div class='row'>";
                if (questions['que_type'] == "additional-text") {
                    survey_data += "       <div class='span1'>Text</div>";
                } else {
                    survey_data += "       <div class='span1'>Question</div>";
                }
                survey_data += "      <div class='span11'>";
                survey_data += "        <div class=''>";
                if (questions['que_type'] == "additional-text") {
                    survey_data += "          <textarea rows='3' name='question_" + questions['que_type'] + "_" + question_sequence + "' placeholder='(Required) Additional Text' style='max-width:80%; margin-left:1px;' class='inherit-width'></textarea>";
                } else {
                    survey_data += "          <input type='text' name='question_" + questions['que_type'] + "_" + question_sequence + "' placeholder='(Required) Question' style='max-width:80%; margin-left:1px;' class='inherit-width'>";
                }
                survey_data += '          <span style="display:none;" ><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
                survey_data += "         </div>";
                survey_data += "      </div>";
                survey_data += "</div>";
            }
            //que ans end
            survey_data += "</div>";//general option div closed
            //advance option div start
            survey_data += "<div class='advance_options'>";
            //helptips disaply
            // Do not display Help Tip for RichText Area Question. Modified By Govind On 07-09-2018
            if (questions['que_type'] != 'richtextareabox') {
                survey_data += "<div class='row'>";
                if (questions['que_type'] == "image" || questions['que_type'] == "video") {
                    var title = 'Title';
                    var placeholder = '(Required) Enter title for the ' + questions['que_type'];
                } else {
                    var title = 'Help Tip';
                    var placeholder = 'Enter help tip for question';
                }
                survey_data += "      <div class='span1'>" + title + " </div>";
                var helptips = '';
                if (questions['question_help_comment'] != 'N/A' && questions['question_help_comment'] != null) {
                    helptips = questions['question_help_comment'];
                } else {
                    helptips = '';
                }
                survey_data += "      <div class='span11'><input type='text' name='helptips_" + questions['que_type'] + "_" + question_sequence + "'  placeholder='" + placeholder + "' style='max-width:80%; margin-left:1px;' class='inherit-width'/></div>";
                survey_data += "</div>"; //helptips complete row closed 
            }
            // End
            if (questions['que_type'] == 'boolean')
            {
                survey_data += "<div class='row'>";
                survey_data += "      <div class='span1'>Display Label </div>";
                var display_boolean_label = '';
                if (questions['display_boolean_label'] != 'N/A' && questions['display_boolean_label'] != null) {
                    display_boolean_label = questions['display_boolean_label'];
                }
                survey_data += "      <div class='span11'><input type='text' name='display_label_" + questions['que_type'] + "_" + question_sequence + "'  placeholder='' style='max-width:80%; margin-left:1px;' class='inherit-width'/></div>";
                survey_data += "</div>"; //Display Label complete row closed
            }

            //Question datatype for textbox
            if (questions['que_type'] == 'textbox')
            {
                survey_data += self.editviewTextBox(question_sequence, questions);
            }
            //Question datatype for commentbox
            else if (questions['que_type'] == 'commentbox')
            {
                survey_data += self.editviewCommentBox(question_sequence, questions);
            }
            //Question datatype for richtextareabox
            else if (questions['que_type'] == 'richtextareabox')
            {
                survey_data += self.editviewRichTextBox(question_sequence, questions);
            }
            //Question datatype for boolean
            else if (questions['que_type'] == 'boolean')
            {
                survey_data += self.editviewBoolean(question_sequence, questions);
            }
            //Question datatype for rating
            else if (questions['que_type'] == 'rating')
            {
                survey_data += self.editviewRating(question_sequence, questions);
            }
            //Question datatype for contact-information
            else if (questions['que_type'] == 'contact-information')
            {
                survey_data += self.editviewContactInformation(question_sequence, questions);
            }
            //Question datatype for multi choice
            else if (questions['que_type'] == 'multiselectlist' || questions['que_type'] == 'dropdownlist' || questions['que_type'] == 'radio-button' || questions['que_type'] == 'check-box')
            {
                survey_data += self.editviewMultiChoice(question_sequence, questions);
            }
            //Question datatype for date-time
            else if (questions['que_type'] == 'date-time')
            {
                survey_data += self.editviewDatetime(question_sequence, questions);
            }
            //Question datatype for video
            else if (questions['que_type'] == 'video')
            {
                survey_data += self.editviewVideo(question_sequence, questions);
            }
            //Question datatype for image
            else if (questions['que_type'] == 'image')
            {
                survey_data += self.editviewImage(question_sequence, questions);
            }
            //Question datatype for scale
            else if (questions['que_type'] == 'scale')
            {
                survey_data += self.editviewScale(question_sequence, questions);
            }
            //Question datatype for NPS
            else if (questions['que_type'] == 'netpromoterscore')
            {
                survey_data += self.editviewNetPromoterScore(question_sequence, questions);
            }
            //Question datatype for Emojis
            else if (questions['que_type'] == 'emojis')
            {
                survey_data += self.editviewEmojis(question_sequence, questions);
            }
            //Question datatype for matrix
            else if (questions['que_type'] == 'matrix')
            {
                survey_data += self.editviewMatrix(question_sequence, questions);
            }
            //Question datatype for doc-attachment
            else if (questions['que_type'] == 'doc-attachment')
            {
                survey_data += self.editviewDocAttachment(question_sequence, questions);
            }
            survey_data += "</div>"; //advance option div closed
            // To Add Skip logic Html On EditView Loading
            if (questions['que_type'] == 'multiselectlist' || questions['que_type'] == 'dropdownlist' || questions['que_type'] == 'radio-button' || questions['que_type'] == 'check-box' || questions['que_type'] == 'boolean' || questions['que_type'] == 'netpromoterscore' || questions['que_type'] == 'emojis')
            {
                // Show Logic Tab In Only Survey Module And Only Edit Mode.
                if (this.module == 'bc_survey' && (this.record_id != '' && this.record_id != null)) {
                    survey_data += self.getSkipLogiclayout(questions, page_sequence);
                }
            }

            // End
            self.$el.parents('.main-pane').find('#' + questions['que_type'] + '_' + question_sequence).append(survey_data);
            // Attachment Question Type: To convert dropdown into multiselect File Extension and decrease dropdown width for File size. By Govind. On 13-02-2019
            self.$el.parents('.main-pane').find('#' + questions['que_type'] + '_' + question_sequence).find('#file_extension_' + question_sequence).select2({
                width: '100%',
                minimumResultsForSearch: 7,
                closeOnSelect: false,
                containerCssClass: 'select2-choices-pills-close'
            });
            self.$el.parents('.main-pane').find('#' + questions['que_type'] + '_' + question_sequence).find('#file_size_' + question_sequence).select2({
                width: '100%',
                minimumResultsForSearch: 7,
                closeOnSelect: false,
                containerCssClass: 'select2-choices-pills-close'
            });
            self.$el.parents('.main-pane').find('#' + questions['que_type'] + '_' + question_sequence).find('#s2id_file_size_' + question_sequence).css('width', '70%');
            // End
            if (questions['que_type'] == 'richtextareabox') {
                self.convertIntoRichTextBox('question_richtextareabox_' + question_sequence);
            }
            $.each(self.$el.parents('.main-pane').find('.no_data'), function () {
                $(this).parents('.question').find('.disable_piping_question').attr('checked', 'checked');
                $(this).parents('.question').find('.sync_field').hide();
            });
            if (questions['que_type'] == 'boolean')
            {
                self.$el.parents('.main-pane').find('#' + questions['que_type'] + '_' + question_sequence).find('.logic_actions').eq(1).html('<option value="no_logic">No Logic</option>              <option value="redirect_to_page">Redirect To Page</option>              <option value="eop">End of Survey</option>              <option value="redirect_to_url">Redirect To URL</option>');
            }


            // if poll then hide extra info
            if (this.model.get('survey_type') == 'poll' || (this.context && this.context.attributes.IsPOll))
            {
                self.$el.parents('.main-pane').find('.question').find('.dashlet-tabs').remove(); // remove tabs
                self.$el.parents('.main-pane').find('.que-close').remove(); // remove close and add section btn
                self.$el.parents('.main-pane').find('.dashlet-header').find('.btn-toolbar ').remove(); // remove page 
            }
            if (questions['enable_scoring'] == 'Yes') {
                self.$el.parents('.main-pane').find('.enableScore').trigger('click');
            }
            //if image is already uploaded then hide upload input
            if (questions['que_title'] == 'uploadImage' && questions['matrix_row'] != '') {
                self.$el.parents('.main-pane').find("[name='uploadType_image_" + question_sequence + "']").hide();
            }

            if (questions['answers']) {
                self.editviewAnswer_data(questions, question_sequence, CopyFromTemplate);
            }

            if (questions['que_type'] == 'matrix' && questions['matrix_row'] && questions['matrix_col']) {
                self.editviewRowsCols_data(questions, question_sequence, CopyFromTemplate);
            }

            if (questions['que_type'] == 'richtextareabox') {
                // self.$el.parents('.main-pane').find('[name="question_richtextbox_' + question_sequence + '"]').val(question_title);
                var richtextContent = '';
                if (questions['richtextContent'] != 'N/A' && questions['richtextContent'] != null) {
                    richtextContent = questions['richtextContent'];
                }
                self.$el.parents('.main-pane').find("[name='question_" + questions['que_type'] + "_" + question_sequence + "']").text(richtextContent);
            } else if (question_title != '') {
                self.$el.parents('.main-pane').find("[name='question_" + questions['que_type'] + "_" + question_sequence + "']").val(question_title);
            }

            if (helptips != '') {
                self.$el.parents('.main-pane').find("[name='helptips_" + questions['que_type'] + "_" + question_sequence + "']").val(helptips);
            }

            if (display_boolean_label != '') {
                self.$el.parents('.main-pane').find("[name='display_label_" + questions['que_type'] + "_" + question_sequence + "']").val(display_boolean_label);
            }
            // if datatype of textbox is Integer or Float then set min max range value
            if ((questions['advance_type'] == 'Integer' || questions['advance_type'] == 'Float') && questions['min'] != '') {
                self.$el.parents('.main-pane').find("[name='min_" + questions['que_type'] + "_" + question_sequence + "']").val(questions['min']);
            }
            if ((questions['advance_type'] == 'Integer' || questions['advance_type'] == 'Float') && questions['max'] != '') {
                self.$el.parents('.main-pane').find("[name='max_" + questions['que_type'] + "_" + question_sequence + "']").val(questions['max']);
            }
            // if datatype of textbox is Float then set precision value
            if (questions['advance_type'] == 'Float' && questions['min'] != '') {
                self.$el.parents('.main-pane').find("[name='precision_" + questions['que_type'] + "_" + question_sequence + "']").val(questions['precision']);
            }
            if (questions['maxsize'] != '') {
                self.$el.parents('.main-pane').find("[name='size_" + questions['que_type'] + "_" + question_sequence + "']").val(questions['maxsize']);
            }
            // if Image type if ImageURL then set image url value
            if (questions['advance_type'] != '' && questions['que_type'] == 'image' && questions['que_title'] == 'imageURL') {
                self.$el.parents('.main-pane').find("#" + questions['que_type'] + "_" + question_sequence).find('.SurveyImageurl').val(questions['advance_type']);
            }

            // if datatype of commentbox then set rows & cols value
            if (questions['que_type'] == 'commentbox' && questions['min'] != '') {
                self.$el.parents('.main-pane').find("[name='rows_" + questions['que_type'] + "_" + question_sequence + "']").val(questions['min']);
            }
            if (questions['que_type'] == 'commentbox' && questions['max'] != '') {
                self.$el.parents('.main-pane').find("[name='cols_" + questions['que_type'] + "_" + question_sequence + "']").val(questions['max']);
            }
            // set value for star number for rating field
            if (questions['que_type'] == 'rating' && questions['maxsize'] != null)
            {
                self.$el.parents('.main-pane').find("[name='starNo_" + questions['que_type'] + "_" + question_sequence + "']").val(questions['maxsize']);
            }
            //set contact-information require fields as checked
            if (questions['que_type'] == 'rating' && questions['maxsize'] != null)
            {
                self.$el.parents('.main-pane').find("[name='starNo_" + questions['que_type'] + "_" + question_sequence + "']").val(questions['maxsize']);
            }

            //initially hide the advanced option for datatype
            self.$el.parents('.main-pane').find('.que_' + question_sequence).find('.advance_options').hide();
            self.$el.parents('.main-pane').find('.que_' + question_sequence).find('.piping_options').hide();
            // To initially hide Skip Logic Layout From Edit
            self.$el.parents('.main-pane').find('.que_' + question_sequence).find('.skip_logic_options').hide();
            // End
            if (questions['advance_type'] != 'Integer' && questions['advance_type'] != 'Float')
            {
                self.$el.parents('.main-pane').find('.que_' + question_sequence).find('.minmax').hide();
            }
            if (questions['advance_type'] != 'Float')
            {
                self.$el.parents('.main-pane').find('.que_' + question_sequence).find('.precision').hide();
            }
            if (questions['advance_type'] != 'Char' && questions['advance_type'] != '')
            {
                self.$el.parents('.main-pane').find('.que_' + question_sequence).find('.maxsize').hide();
            }
            // initially hide selected required fields for contact-information
            if (questions['que_type'] == 'contact-information' && !questions['advance_type'])
            {
                self.$el.parents('.main-pane').find('.que_' + question_sequence).find('.requiredFields').hide();
            }
            // initially hide selected required fields for contact-information
            if (questions['que_type'] == 'image' && questions['que_title'] == 'uploadImage')
            {
                self.$el.parents('.main-pane').find('.que_' + question_sequence).find('.SurveyImageurl').hide();
            } else if (questions['que_type'] == 'image' && questions['que_title'] == 'imageURL')
            {
                self.$el.parents('.main-pane').find('.que_' + question_sequence).find('.uploadSurveyImage').hide();
            }

            // disable datatype if sync field is textbox
            if (questions['que_type'] == 'textbox' && questions['sync_field'])
            {
                self.$el.parents('.main-pane').find('.que_' + question_sequence).find('.datatype-textbox').attr('disabled', true);
            }
        }
    },
    /* functions for Page/Questions Skip Feature
     * show_skip_logic_option = get and show Questions Options In Skip Logic Layout.
     * getSkipLogiclayout = To get skip feature layout/html in survey and survey template edit view.
     * addLogicOptionTr = To generate logic option tr on load and click on Logic tab
     * getDependendDDWithSelectedValForRedirectToPageAndShowHide = To generate dependent dropdown(redirect Page and Show hide DD) with selected value.
     * applylogicTargetsOnchangeLogicActions = To apply skip logic conditions on questions. based on select condition logic target will display.
     * reset_SkipLogic = To reset skip logic conditions and targets
     * saveLogicOptionsOnSave = To save logic option on save.
     * */
    show_skip_logic_option: function (el) {
        var self = this;
        var que_name = el.currentTarget.parentElement.parentElement.parentElement.parentElement.parentElement.classList[0];
        var page_divId = self.$el.parents('.main-pane').find('#' + el.target.offsetParent.id).find('.' + que_name).attr('id');
        var que_id = self.$el.parents('.main-pane').find('#' + page_divId).find('.que_id').val();
        if (que_id == '' || que_id == null || que_id == 'undefined') {
            app.alert.show('Alert when user click on logic tab while create new question.', {
                level: 'info',
                title: 'You must save this survey before using skip logic.',
                autoclose: false}
            );
        } else {
            var questions = {'que_id': que_id};
            var page_seq = self.$el.parents('.main-pane').find('#' + el.target.offsetParent.id).attr('id');
            var page_sequence = page_seq.replace('page_', '');
            var que_seq = que_name.replace('que_', '');
            var que_typeAr = page_divId.split('_' + que_seq);
            var que_type = que_typeAr['0'];
            // Get Only Yes Option For Skip Logic If Question Is Boolean
            var optionsArr = '';
            if (que_type == 'boolean') {
                optionsArr = self.$el.parents('.main-pane').find('#' + que_type + '_options_div_' + que_seq).find('.options').first();
            } else {
                optionsArr = self.$el.parents('.main-pane').find('#' + que_type + '_options_div_' + que_seq).find('.options');
            }
            var npsOptionsTrs = ['0', '7', '9'];
            $.each(optionsArr, function (item, val) {
                if ((que_type == 'netpromoterscore' && npsOptionsTrs.indexOf(val.firstElementChild.value) != '-1') || que_type != 'netpromoterscore') {
                    var logic_opt_rows = '';
                    var isNotSaved = false;
                    var optionId = $(val).find('input[type=text]').attr('id');
                    if (optionId == null || optionId == '') {
                        optionId = val.id;
                        isNotSaved = true;
                    }
                    var optionLable = $(val).find('input[type=text]').val();
                    var exist_logic_optionsTr = self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('tbody').find('#logicRow_' + optionId).attr('id');
                    if (exist_logic_optionsTr == '' || exist_logic_optionsTr == null) {
                        logic_opt_rows += self.addLogicOptionTr(questions, optionId, optionLable, page_sequence);
                        if (self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('tbody').find('.otherLogic').length != 0)
                        {
                            self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('tbody').find('.otherLogic').before(logic_opt_rows);
                        } else {
                            self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('tbody').append(logic_opt_rows);
                        }
                    } else {
                        self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('#is_logic_click_' + optionId).val('1');
                        var logic_action = self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('#logic_actions_db_' + optionId).val();
                        var logic_target = self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('#logic_targets_db_' + optionId).val();
                        logic_opt_rows += self.getDependendDDWithSelectedValForRedirectToPageAndShowHide(logic_action, page_sequence, questions, optionId);
                        if (logic_opt_rows != 'undefined') {
                            self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('#' + logic_action + '_dd_' + optionId).html(logic_opt_rows);
                        } else {
                            self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('#' + logic_action + '_dd_' + optionId).val(logic_target);
                        }
                        if (que_type == 'netpromoterscore') {
                            if (optionLable == 0) {
                                self.$el.parents('.main-pane').find('#ans_option_' + optionId).text('0-6');
                            } else if (optionLable == 7) {
                                self.$el.parents('.main-pane').find('#ans_option_' + optionId).text('7-8');
                            } else if (optionLable == 9) {
                                self.$el.parents('.main-pane').find('#ans_option_' + optionId).text('9-10');
                            }
                        } else {
                            self.$el.parents('.main-pane').find('#ans_option_' + optionId).text(optionLable);
                        }
                    }
                }
            });
            //*******************************************************************************************

            // If other option is added
            if (self.$el.parents('.main-pane').find('#' + que_type + '_options_div_' + que_seq).parents('.general_options').find('.enableOther').prop('checked')) {

                var logic_opt_rows = '';
                var val = self.$el.parents('.main-pane').find('#' + que_type + '_options_div_' + que_seq).parents('.general_options').find('.other_option_label');
                var optionId = val.attr('id');
                if (!optionId) {
                    optionId = 'other_option';
                }
                var optionLable = val.attr('value');
                var exist_logic_optionsTr = self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('tbody').find('#logicRow_' + optionId).attr('id');
                if (exist_logic_optionsTr == '' || exist_logic_optionsTr == null) {
                    logic_opt_rows += self.addLogicOptionTr(questions, optionId, optionLable, page_sequence, 1);
                    self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('tbody').append(logic_opt_rows);
                } else {
                    self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('#is_logic_click_' + optionId).val('1');
                    var logic_action = self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('#logic_actions_db_' + optionId).val();
                    var logic_target = self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('#logic_targets_db_' + optionId).val();
                    logic_opt_rows += self.getDependendDDWithSelectedValForRedirectToPageAndShowHide(logic_action, page_sequence, questions, optionId);
                    if (logic_opt_rows != 'undefined') {
                        self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('#' + logic_action + '_dd_' + optionId).html(logic_opt_rows);
                    } else {
                        self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('#' + logic_action + '_dd_' + optionId).val(logic_target);
                    }
                    self.$el.parents('.main-pane').find('#ans_option_' + optionId).text(optionLable);
                }

            } else {
                self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('tbody').find('.otherLogic').remove();
            }

            /* $.each(self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table').find('.show_hide_question'), function () {
             if (self.$el.parents('.main-pane').find(this).css('display') != 'none')
             {
             self.$el.parents('.main-pane').find(this).parent().find('.ms-parent').show();
             self.$el.parents('.main-pane').find(this).multipleSelect({filter: true});
             self.$el.parents('.main-pane').find(this).parent().parent().find('.ms-search').find('input').attr('placeholder', 'Search');
             }
             }); */ // commented due to error in Sugar 7.8
            // get Circular logic or not

            //check all options page selection for logic
            var isWarning = false;
            var selected_page_seq = 0;
            var current_page_seq = page_sequence;
            var parent = self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('#logicRows_table');
            $.each($(parent).find('.logicRow'), function () {
                var logic_action = $(this).find('.logic_actions').val();
                if (logic_action == 'redirect_to_page')
                {
                    var survey_details = JSON.parse(self.survey_details);
                    var selected_page_id = $(this).find('.redirect_to_page_options').val();
                    $.each(survey_details, function (k, page_data)
                    {
                        if (page_data['page_id'] == selected_page_id)
                        {
                            selected_page_seq = page_data['page_number'];
                        }
                    });
                    // check for page selection is circular or not
                    if (selected_page_id != 'none' && selected_page_seq < current_page_seq)
                    {
                        // display waring message
                        if (self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('.warn_msg').length == 0) {
                            self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').prepend('<div class="warn_msg" style="color: black;margin-top: 18px;margin-bottom: 13px;padding: 10px;background: #ffc04d;"><b>CIRCULAR LOGIC : </b>This logic will cause the page to redirect to previous page, which may cause the respondent to go in an infinite loop if they keep picking that choice.</div>');
                        } else {
                            self.$el.parents('.main-pane').find('#' + page_divId).find('.skip_logic_options').find('.warn_msg').css('display', '');
                        }

                    }
                }
            });
            self.$el.parents('.main-pane').find('.' + que_name).find('.skip_logic').addClass('active');
            self.$el.parents('.main-pane').find('.' + que_name).find('.change_type_skip_logic').addClass('active');
            self.$el.parents('.main-pane').find('.' + que_name).find('.advance').removeClass('active');
            self.$el.parents('.main-pane').find('.' + que_name).find('.general').removeClass('active');
            self.$el.parents('.main-pane').find('.' + que_name).find('.general_options').hide();
            self.$el.parents('.main-pane').find('.' + que_name).find('.advance_options').hide();
            self.$el.parents('.main-pane').find('.' + que_name).find('.piping_options').hide();
            self.$el.parents('.main-pane').find('.' + que_name).find('.skip_logic_options').fadeIn();
        }
    },
    getSkipLogiclayout: function (questions, page_sequence) {
        var data = '';
        var self = this;
        data += "<div class='skip_logic_options' style='display:none;'>";
        data += "<input type='hidden' id='page_sequence_count' value='" + page_sequence + "' >";
        data += "<div class='row'>";
        data += "<table id='logicRows_table' class='logic-data-table' cellspacing='5' cellpadding='5'>";
        data += "<thead>";
        data += "<tr><th>If answer is ...&nbsp;<i class='fa fa-info-circle' title='If selected answer is from below answer' style='font-size:14px;'></i></th><th>Then skip to ...&nbsp;<i class='fa fa-info-circle'  title='If answer is selected then perform logic as below' style='font-size:14px;'></i></th><th class='' style=''>&nbsp;</th><th><span style='cursor: pointer;' class='clear_skip_logic_All'><a>Clear All</a></span></th></tr>";
        data += "</thead>";
        data += "<tbody>";
        $.each(questions['answers'], function (index, ans)
        {

            $.each(ans, function (key, answer)
            {
                if ((questions['que_type'] == 'boolean' && answer['option'] == 'Yes') || questions['que_type'] != 'boolean') {
                    data += self.addLogicOptionTr(questions, key, answer, page_sequence);
                }
            });
        });
        // If other option is added
        if (questions['other_option'])
        {
            $.each(questions['other_option'], function (key, answer)
            {
                data += self.addLogicOptionTr(questions, key, answer, page_sequence, 1);
            });
        }
        data += " </tbody>";
        data += "</table>";
        data += "        </div>";
        return data;
    },
    addLogicOptionTr: function (questions, answer_Id, answer, page_sequence, isOther) {
        var self = this;
        var data = '';
        var npsOptionsTrs = ['0', '7', '9'];
        if ((questions['que_type'] == 'netpromoterscore' && npsOptionsTrs.indexOf(answer['option']) != '-1') || questions['que_type'] != 'netpromoterscore') {
            var redirect_to_page_selected = '';
            var eop_selected = '';
            var redirect_to_url_selected = '';
            var redirect_to_url_selectedVal = '';
            var show_hide_question_selected = '';
            var no_logic_selected = '';
            var red_to_pageDD = 'display: none;';
            var red_to_urlDD = 'display: none;';
            var showHide_DD = 'display: none;';
            var is_logic_click = 0;
            var logic_action;
            var logic_target;
            var page_dd_html = '';
            var que_dd_html = '';
            if (typeof questions['skip_logic'] == 'undefined') {
                logic_action = self.$el.parents('.main-pane').find('#logic_actions_db_' + answer_Id).val();
                logic_target = self.$el.parents('.main-pane').find('#logic_targets_db_' + answer_Id).val();
            } else {
                logic_action = questions['skip_logic'][answer_Id]['logic_action'];
                logic_target = questions['skip_logic'][answer_Id]['logic_target'];
            }
            switch (logic_action) {
                case "redirect_to_page":
                    red_to_pageDD = 'display: block;'
                    redirect_to_page_selected = 'selected';
                    page_dd_html = self.getDependendDDWithSelectedValForRedirectToPageAndShowHide('redirect_to_page', page_sequence, questions, answer_Id);
                    break;
                case "eop":
                    eop_selected = 'selected';
                    break;
                case "no_logic":
                    no_logic_selected = 'no_logic';
                    break;
                case "redirect_to_url":
                    red_to_urlDD = 'display: block;'
                    redirect_to_url_selected = 'selected';
                    redirect_to_url_selectedVal = logic_target;
                    break;
                case "show_hide_question":
                    showHide_DD = 'display: block;';
                    show_hide_question_selected = 'selected';
                    que_dd_html = self.getDependendDDWithSelectedValForRedirectToPageAndShowHide('show_hide_question', page_sequence, questions, answer_Id);
                    break;
                default:
                    break;
            }
            var className = '';
            if (isOther == 1)
            {
                className = 'otherLogic';
            }
            data += " <tr class='logicRow " + className + "' id='logicRow_" + answer_Id + "'>";
            data += "       <td class='option_value logic-table-first-column' id='ans_option_" + answer_Id + "'>" + answer + "</td>";
            data += "       <input type='hidden' class='is_logic_click' id='is_logic_click_" + answer_Id + "' value='" + is_logic_click + "' >";
            data += "       <input type='hidden' class='logic_actions_hidden_field' id='logic_actions_db_" + answer_Id + "' value='" + logic_action + "' >";
            data += "       <input type='hidden' class='logic_target_hidden_field' id='logic_targets_db_" + answer_Id + "' value='" + logic_target + "' >";
            data += "       <input type='hidden' id='curr_que_Id' value='" + questions['que_id'] + "' >";
            data += "       <td class='logic_actions_td'><select id='logic_actions_" + answer_Id + "' class='logic_actions' name='logic_actions' >";
            data += "              <option value='no_logic' " + no_logic_selected + ">No Logic</option>";
            data += "              <option value='redirect_to_page'" + redirect_to_page_selected + ">Redirect To Page</option>";
            data += "              <option value='eop' " + eop_selected + ">End of Survey</option>";
            data += "              <option value='redirect_to_url' " + redirect_to_url_selected + ">Redirect To URL</option>";
            data += "             <option value='show_hide_question' " + show_hide_question_selected + ">Show/Hide Questions</option>";
            data += "         </select></td>";
            data += "    <td class='logic_action_targtes'><select id='redirect_to_page_dd_" + answer_Id + "' class='redirect_to_page_options logic-page-select' name='redirect_to_page_options' style='" + red_to_pageDD + "'>";
            data += page_dd_html;
            data += "   </select><input type='text' id='redirect_to_url_" + answer_Id + "' name='redirect_to_url' class='redirect_to_url_options logic-url-box' style='margin-bottom:8px; " + red_to_urlDD + "' value='" + redirect_to_url_selectedVal + "'><select id='show_hide_question_dd_" + answer_Id + "' class='show_hide_question' name='show_hide_question' style='" + showHide_DD + "' multiple>";
            data += que_dd_html;
            data += "   </select></td>"
            data += "  <td class='clearTd'><span style='cursor: pointer;' class='clear_skip_logic'><a>Clear</a></span></td>"
            data += "  </tr>";
        }
        return data;
    },
    getDependendDDWithSelectedValForRedirectToPageAndShowHide: function (sel_action, page_sequence, questions, answer_Id) {

        var self = this;
        var totalPage = self.$el.parents('.main-pane').find('#edit_view').find('.page_id');
        var currentPage = page_sequence;
        var currentQue = questions['que_id'];
        var current_Page_Ques = self.$el.parents('.main-pane').find('#data-page_' + currentPage).find('.question');
        switch (sel_action) {
            case "redirect_to_page":
                var selectedVal = '';
                if (typeof questions['skip_logic'] == 'undefined') {
                    selectedVal = self.$el.parents('.main-pane').find('#redirect_to_page_dd_' + answer_Id).val();
                    if (selectedVal == null || selectedVal == '') {
                        selectedVal = self.$el.parents('.main-pane').find('#logic_targets_db_' + answer_Id).val()
                    }
                } else {
                    selectedVal = questions['skip_logic'][answer_Id]['logic_target'];
                }
                var page_dd_html = '';
                if ((typeof questions['skip_logic'] == 'undefined')) {
                    $.each(totalPage, function (item, val) {

                        var selected = '';
                        if (selectedVal == val.value) {
                            selected = 'selected';
                        }
                        var page_Id = val.value;
                        var page_Title = $(val.parentElement).find('#txt_page_title').val();
                        if (!page_Title)
                        {
                            var survey_details = JSON.parse(self.survey_details);
                            $.each(survey_details, function (k, page_data)
                            {
                                if (page_data['page_id'] == page_Id)
                                {
                                    page_Title = page_data['page_title'];
                                }
                            });
                        }
                        var current_page_Id = self.$el.parents('.main-pane').find('#page_' + page_sequence).find('.page_id').val();
                        if (page_Id != current_page_Id)
                        {
                            page_dd_html += "<option value='" + page_Id + "' " + selected + ">" + page_Title + "</option>";
                        }
                    });
                } else {
                    var page_Id = selectedVal;
                    page_dd_html += "<option value='" + page_Id + "' selected></option>";
                }
                return page_dd_html;
                break;
            case "show_hide_question":
                var que_dd_html = '';
                var selectedValArr = '';
                if (typeof questions['skip_logic'] == 'undefined') {
                    selectedValArr = self.$el.parents('.main-pane').find('#show_hide_question_dd_' + answer_Id).val();
                    if (selectedValArr == null || selectedValArr == '') {
                        selectedValArr = self.$el.parents('.main-pane').find('#logic_targets_db_' + answer_Id).val()
                    }
                } else {
                    selectedValArr = questions['skip_logic'][answer_Id]['logic_target'];
                }
                //  var selectedValArr = self.$el.parents('.main-pane').find('#show_hide_question_dd_' + answer_Id).val();
                if (selectedValArr instanceof Array) {
                    selectedValArr = selectedValArr;
                } else if (typeof selectedValArr == 'string') {
                    selectedValArr = selectedValArr.split(',');
                }
                if ((typeof questions['skip_logic'] == 'undefined')) {
                    var curr_flag = false;
                    $.each(current_Page_Ques, function (item, val) {

                        var questionlbl = '';
                        var questionID = $(val).find('.que_id').val();
                        var quetitle_inputId = val.id;
                        if (quetitle_inputId.indexOf('image_') !== -1 || quetitle_inputId.indexOf('video_') !== -1) {
                            questionlbl = $(val).find('input[name=helptips_' + quetitle_inputId + ']').val();
                            // To enable Rich Type Question for Show/Hide Logic. By GSR
                        } else if (quetitle_inputId.indexOf('richtextareabox_') !== -1) {
                            var qSeqArr = quetitle_inputId.split('_');
                            var qSeq = qSeqArr['1'];
                            questionlbl = $(val).find('input[name="question_richtextbox_' + qSeq + '"]').val();
                        } else {
                            questionlbl = $(val).find('input[name=question_' + quetitle_inputId + ']').val();
                        }
                        if (questionID != currentQue && curr_flag) {
                            var selected = '';
                            if (selectedValArr.indexOf(questionID) !== -1) {
                                selected = 'selected';
                            }
                            if (questionID && questionlbl)
                            {
                                que_dd_html += "<option value='" + questionID + "' " + selected + ">" + questionlbl + "</option>";
                            }
                        } else if (questionID == currentQue) {
                            curr_flag = true;
                        }
                    });
                } else {
                    $(selectedValArr).each(function (item, val) {

                        var questionID = val;
                        if (questionID)
                        {
                            que_dd_html += "<option value='" + questionID + "' selected></option>";
                        }
                    });
                }
                return que_dd_html;
                break;
            default:
                break;
        }
    },
    applylogicTargetsOnchangeLogicActions: function (el) {

        var self = this;
        var sel_action = el.currentTarget.value;
        var que_id = $(el.currentTarget).parents('.question').find('.que_id').val();
        var curr_optionId = el.currentTarget.id.replace('logic_actions_', '');
        var questions = {'que_id': que_id};
        var page_sequence = $(el.currentTarget).parents('.skip_logic_options').find('#page_sequence_count').val();
        var selectedVal = '';
        switch (sel_action) {
            case "redirect_to_page":
                var page_dd_html;
                // selectedVal = $(el.currentTarget).parents('.logicRow').find('.redirect_to_page_options').val();
                page_dd_html = self.getDependendDDWithSelectedValForRedirectToPageAndShowHide(sel_action, page_sequence, questions, curr_optionId);
                if (!page_dd_html)
                {
                    app.alert.show('info', {
                        level: 'info',
                        messages: 'No page exists to apply logic.',
                        autoClose: true
                    });
                    $(el.currentTarget).val('no_logic');
                    $(el.currentTarget.parentElement.parentElement).find('.show_hide_question').hide();
                    $(el.currentTarget.parentElement.parentElement).find('.ms-parent').hide();
                    $(el.currentTarget.parentElement.parentElement).find('.redirect_to_page_options').hide();
                    $(el.currentTarget.parentElement.parentElement).find('.redirect_to_url_options').hide();
                    $(el.currentTarget.parentElement.parentElement).find('.error_msg').remove();
                } else {
                    page_dd_html = '<option value="none">Select Page</option>' + page_dd_html;
                    $(el.currentTarget.parentElement.parentElement).find('.redirect_to_page_options').html(page_dd_html);
                    $(el.currentTarget.parentElement.parentElement).find('.redirect_to_page_options').show().css('border', '');
                    $(el.currentTarget.parentElement.parentElement).find('.redirect_to_url_options').hide();
                    $(el.currentTarget.parentElement.parentElement).find('.show_hide_question').hide();
                    $(el.currentTarget.parentElement.parentElement).find('.error_msg').remove();
                }
                // remove error class
                $(el.currentTarget.parentElement.parentElement).removeClass('error-custom');
                break;
            case "no_logic":
                $(el.currentTarget.parentElement.parentElement).find('.ms-parent').hide();
                // remove error class
                $(el.currentTarget.parentElement.parentElement).find('.redirect_to_page_options').removeClass('error-custom');
                $(el.currentTarget.parentElement.parentElement).removeClass('error-custom');
                $(el.currentTarget.parentElement.parentElement).find('.error_msg').remove();
            case "eop":
                $(el.currentTarget.parentElement.parentElement).find('.ms-parent').hide();
                $(el.currentTarget.parentElement.parentElement).find('.redirect_to_page_options').hide();
                $(el.currentTarget.parentElement.parentElement).find('.redirect_to_url_options').hide();
                $(el.currentTarget.parentElement.parentElement).find('.show_hide_question').hide();
                // remove error class
                $(el.currentTarget.parentElement.parentElement).find('.redirect_to_page_options').removeClass('error-custom');
                $(el.currentTarget.parentElement.parentElement).removeClass('error-custom');
                $(el.currentTarget.parentElement.parentElement).find('.error_msg').remove();
                break;
            case "redirect_to_url":
                $(el.currentTarget.parentElement.parentElement).find('.ms-parent').hide();
                $(el.currentTarget.parentElement.parentElement).find('.redirect_to_url_options').show().css('border', '');
                $(el.currentTarget.parentElement.parentElement).find('.redirect_to_page_options').hide();
                $(el.currentTarget.parentElement.parentElement).find('.show_hide_question').hide();
                // remove error class
                $(el.currentTarget.parentElement.parentElement).find('.redirect_to_page_options').removeClass('error-custom');
                $(el.currentTarget.parentElement.parentElement).removeClass('error-custom');
                $(el.currentTarget.parentElement.parentElement).find('.error_msg').remove();
                break;
            case "show_hide_question":
                var que_dd_html = '';
                // selectedVal = $(el.currentTarget).parents('.logicRow').find('.show_hide_question').val();
                que_dd_html = self.getDependendDDWithSelectedValForRedirectToPageAndShowHide(sel_action, page_sequence, questions, curr_optionId);
                if (!que_dd_html)
                {
                    app.alert.show('info', {
                        level: 'info',
                        messages: 'No question exists to apply logic.',
                        autoClose: true
                    });
                    $(el.currentTarget).val('no_logic');
                    $(el.currentTarget.parentElement.parentElement).find('.show_hide_question').hide();
                    $(el.currentTarget.parentElement.parentElement).find('.redirect_to_page_options').hide();
                    $(el.currentTarget.parentElement.parentElement).find('.redirect_to_url_options').hide();
                    $(el.currentTarget.parentElement.parentElement).find('.error_msg').remove();
                } else {
                    $(el.currentTarget.parentElement.parentElement).find('.show_hide_question').html(que_dd_html).show();
                    $(el.currentTarget.parentElement.parentElement).find('.redirect_to_page_options').hide();
                    $(el.currentTarget.parentElement.parentElement).find('.redirect_to_url_options').hide();
                    $(el.currentTarget.parentElement.parentElement).find('.ms-parent').show();
                    //  $(el.currentTarget.parentElement.parentElement).find('.show_hide_question').multipleSelect({filter: true});
                    $(el.currentTarget.parentElement.parentElement).find('.ms-search').find('input').attr('placeholder', 'Search');
                    $(el.currentTarget.parentElement.parentElement).find('.error_msg').remove();
                }
                // remove error class
                $(el.currentTarget.parentElement.parentElement).removeClass('error-custom');
                break;
            default:
                break;
        }
    },
    reset_SkipLogic: function (el) {

        var self = this;
        var doClear = true;
        if (el.currentTarget.className == 'clear_skip_logic' && $(el.currentTarget).parents('.logicRow').find('.logic_actions_td').find('.logic_actions').val() == 'no_logic') {
            doClear = false;
        } else if (el.currentTarget.className != 'clear_skip_logic') {
            doClear = false;
            $.each($(el.currentTarget).parents('#logicRows_table').find('.logic_actions_td'), function () {
                if ($(this).find('.logic_actions').val() != 'no_logic') {
                    doClear = true;
                }
            })
        }
        if (doClear) {
            app.alert.show('stop_confirmation', {
                level: 'confirmation',
                title: '',
                messages: 'Are you sure want to remove logic ?',
                onConfirm: function () {
                    if (el.currentTarget.className == 'clear_skip_logic') {
                        $(el.currentTarget).parents('.logicRow').find('.logic_actions_hidden_field').val('');
                        $(el.currentTarget).parents('.logicRow').find('.logic_target_hidden_field').val('');
                        $(el.currentTarget).parents('.logicRow').find('.logic_actions_td').find('.logic_actions').val('no_logic');
                        $(el.currentTarget).parents('.logicRow').find('.logic_action_targtes').find('.redirect_to_page_options').hide();
                        $(el.currentTarget).parents('.logicRow').find('.logic_action_targtes').find('.redirect_to_url_options').hide();
                        $(el.currentTarget).parents('.logicRow').find('.logic_action_targtes').find('.show_hide_question').hide();
                        $(el.currentTarget).parents('.logicRow').find('.ms-parent').hide();
                        $(el.currentTarget).parents('.logicRow').find('.error_msg').remove();
                        // check for page selection is circular or not
                        var current_page_seq = $(el.currentTarget).parents('.thumbnail').attr('id').split('_')[1]
                        var selected_page_id = $(el.currentTarget).parent().parent().find('.logic-page-select').val();
                        var selected_page_seq = 0;
                        var survey_details = JSON.parse(self.survey_details);
                        $.each(survey_details, function (k, page_data)
                        {
                            if (page_data['page_id'] == selected_page_id)
                            {
                                selected_page_seq = page_data['page_number'];
                            }
                        });
                        if (selected_page_id != 'none' && selected_page_seq < current_page_seq)
                        {
                            $(el.currentTarget).parents('.skip_logic_options').find('.warn_msg').remove();
                        }

                        $(el.currentTarget).parent().parent().find('.logic-page-select').val('');

                    } else {
                        $(el.currentTarget).parents('.logicRows_table').find('.logic_actions_hidden_field').val('');
                        $(el.currentTarget).parents('.logicRows_table').find('.logic_target_hidden_field').val('');
                        $(el.currentTarget).parent().parent().find('.logic-page-select').val('');
                        $(el.currentTarget).parents('#logicRows_table').find('.logic_actions_td').find('.logic_actions').val('no_logic');
                        $(el.currentTarget).parents('#logicRows_table').find('.logic_action_targtes').find('.redirect_to_page_options').hide();
                        $(el.currentTarget).parents('#logicRows_table').find('.logic_action_targtes').find('.redirect_to_url_options').hide();
                        $(el.currentTarget).parents('#logicRows_table').find('.logic_action_targtes').find('.show_hide_question').hide();
                        $(el.currentTarget).parents('#logicRows_table').find('.ms-parent').hide();
                        $(el.currentTarget).parents('#logicRows_table').find('.error_msg').remove();
                        $(el.currentTarget).parents('.skip_logic_options').find('.warn_msg').remove();

                    }
                },
                autoClose: false
            });
        }
    },
    saveLogicOptionsOnSave: function (logic_action, survey_question_detail, count, option_id) {
        var self = this;
        var logic_target;
        // Use: If Logic Tab Does Not Click then get value From Hidden Field.
        switch (logic_action) {
            case "redirect_to_page":
                logic_target = self.$el.parents('.main-pane').find('#' + survey_question_detail['que_type'] + '_' + count).find('.skip_logic_options').find('#logicRows_table').find('.logicRow').find('#redirect_to_page_dd_' + option_id).val();
                break;
            case "eop":
                logic_target = 'eop';
                break;
            case "no_logic":
                logic_target = 'no_logic';
                break;
            case "redirect_to_url":
                logic_target = self.$el.parents('.main-pane').find('#' + survey_question_detail['que_type'] + '_' + count).find('.skip_logic_options').find('#logicRows_table').find('.logicRow').find('#redirect_to_url_' + option_id).val();
                break;
            case "show_hide_question":
                logic_target = self.$el.parents('.main-pane').find('#' + survey_question_detail['que_type'] + '_' + count).find('.skip_logic_options').find('#logicRows_table').find('.logicRow').find('#show_hide_question_dd_' + option_id).val();
                break;
            default:
                break;
        }
        return logic_target;
    },
    /*
     *if selected prev page for logic then warn user for looping
     * @param {type} el - current target
     * 
     */
    redirect_to_pageSelected: function (el) {

        //find current page
        var self = this;
        var current_page_seq = $(el.currentTarget).parents('.data-page').attr('id').split('_')[1];
        var selected_page_id = $(el.currentTarget).val();
        var survey_details = JSON.parse(self.survey_details);
        var selected_page_seq = 0;
        var isWarning = false;
        // get selected page sequence
        $.each(survey_details, function (k, page_data)
        {
            if (page_data['page_id'] == selected_page_id)
            {
                selected_page_seq = page_data['page_number'];
            }
        });
        if (selected_page_id != 'none' && selected_page_seq < current_page_seq)
        {
            isWarning = true;
        } else {
            //check all options page selection for logic
            var parent = $(el.currentTarget).parents('#logicRows_table');
            $.each($(parent).find('.logicRow'), function () {
                var logic_action = $(this).find('.logic_actions').val();
                if (logic_action == 'redirect_to_page')
                {
                    selected_page_id = $(this).find('.redirect_to_page_options').val();
                    $.each(survey_details, function (k, page_data)
                    {
                        if (page_data['page_id'] == selected_page_id)
                        {
                            selected_page_seq = page_data['page_number'];
                        }
                    });
                }
                // check for page selection is circular or not
                if (selected_page_id != 'none' && selected_page_seq < current_page_seq)
                {
                    isWarning = true;
                }
            });
        }
        // display waring message
        if (isWarning) {
            if ($(el.currentTarget).parents('.skip_logic_options').find('.warn_msg').length == 0) {
                $(el.currentTarget).parents('.skip_logic_options').prepend('<div class="warn_msg" style="color: black;margin-top: 18px;margin-bottom: 13px;padding: 10px;background: #ffc04d;"><b>CIRCULAR LOGIC : </b>This logic will cause the page to redirect to previous page, which may cause the respondent to go in an infinite loop if they keep picking that choice.</div>');
            } else {
                $(el.currentTarget).parents('.skip_logic_options').find('.warn_msg').css('display', '');
            }
        }
        // hide warning message
        else {
            $(el.currentTarget).parents('.skip_logic_options').find('.warn_msg').css('display', 'none');
        }
    },
    // End
    /**
     * answers ( options ) in edit mode
     * 
     * @questions detail of questions
     * @question_sequence sequence of question
     * @CopyFromTemplate set to 1 then page component prefill with given data
     */
    editviewAnswer_data: function (questions, question_sequence, CopyFromTemplate) {
        var self = this;
        var survey_data = '';
        var show_remove_button = new Object();
        var que = new Object();
        var op_count = 0;
        var que_type = new Object();
        var styleNPS = "";
        var classEmojis = "";
        if (questions['que_type'] == 'netpromoterscore') {
            styleNPS = "display:none";
        }
        if (questions['que_type'] == 'emojis') {
            classEmojis = "emojis_class";
        }
        survey_data += "<div class='row' style='" + styleNPS + "'>";
        survey_data += "       <div class='span1'>Options</div><div class='span11' id='" + questions['que_type'] + "_options_div_" + question_sequence + "'>";
        survey_data += "</div>";
        survey_data += '</div>';
        var other_option_label = '';
        var other_option_weight = 0;
        var other_option_id = '';
        var other_option_image = '';

        var sync_field = questions['sync_field'];
        var sync_module = self.$el.parents('.main-pane').find('[name=sync_module]').val();

        $(survey_data).appendTo(self.$el.parents('.main-pane').find('#' + questions['que_type'] + '_' + question_sequence).find('.general_options'));
        if (questions['que_type'] == 'boolean')
        {
            var readonly = 'readonly onfocus="this.blur()"';
        } else {
            var readonly = '';
        }
        var inputType = 'text';
        var showInputFields = true;
        if (questions['que_type'] == 'netpromoterscore') {
            inputType = 'hidden';
            showInputFields = false;
        }
        if (questions['is_image_option'] == 'Yes') {
            var showFileUpload = '';
            var is_image_option = true;
            var hideOther = 'display:none';
        } else {
            var showFileUpload = 'display:none;';
            var is_image_option = false;
            var hideOther = '';
        }
        if (questions['que_type'] == 'emojis') {
            var emojisImges = {
                0: "<img src='custom/include/images/ext-unsatisfy.png' />",
                1: "<img src='custom/include/images/unsatisfy.png'  />",
                2: "<img src='custom/include/images/nuteral.png' />",
                3: "<img src='custom/include/images/satisfy.png' />",
                4: "<img src='custom/include/images/ext-satisfy.png'/>",
            };
            $.each(questions['answers'], function (index, ans)
            {

                var ans_count = Object.keys(questions['answers']).length - 1;
                $.each(ans, function (key, answer)
                {
                    survey_data = '';
                    survey_data += '<div style="width: 100%;display: inline-flex;"><div style="width:4%;margin-top: 2px;">' + emojisImges[op_count] + '</div><div id="option_' + op_count + '" class="options" style="margin-left: 10px;width: 100%;">';
                    if (CopyFromTemplate == 1) { // if copied from template then dont give option id
                        survey_data += '       <input type="' + inputType + '" ' + readonly + ' name="option_' + questions['que_type'] + '" placeholder="Option" class="inherit-width opt_' + key + '" style="margin-top:5px;max-width:30%;margin-left:1px;">';
                    } else {
                        survey_data += '       <input type="' + inputType + '" ' + readonly + ' name="option_' + questions['que_type'] + '" id="' + key + '" placeholder="Option" class="inherit-width" style="margin-top:5px;max-width:30%;margin-left:1px;">';
                    }
                    // set score weight
                    if (questions['enable_scoring'] == 'Yes' && typeof answer['weight'] != 'undefined')
                    {
                        var value = answer['weight'];
                    } else {
                        var value = op_count + 1;
                    }
                    // if scoring is enabled then show weight inputs with values
                    if (showInputFields) {
                        if (questions['enable_scoring'] == 'Yes')
                        {
                            survey_data += "   <input type='number' name='score_" + questions['que_type'] + "'  value='" + value + "' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;margin-left:1px;'>";
                        } else {
                            survey_data += "   <input type='number' name='score_" + questions['que_type'] + "'  value='" + value + "' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;display:none;margin-left:1px;'>";
                        }
                    }
                    survey_data += '</div></div>';
                    $(survey_data).appendTo('#' + questions['que_type'] + "_options_div_" + question_sequence);
                    //set option value
                    if (CopyFromTemplate == '1')
                    {
                        self.$el.parents('.main-pane').find('#' + questions['que_type'] + "_options_div_" + question_sequence).find('.opt_' + key).val(answer['option']);
                    } else {
                        self.$el.parents('.main-pane').find('#' + key).val(answer['option']);
                    }
                    op_count++;
                });
            });
        } else {
            $.each(questions['answers'], function (index, ans)
            {

                var ans_count = Object.keys(questions['answers']).length - 1;
                $.each(ans, function (key, answer)
                {

                    survey_data = '';
                    survey_data += '<div id="option_' + op_count + '" class="options">';
                    if (CopyFromTemplate == 1) { // if copied from template then dont give option id
                        if (questions['que_type'] == "radio-button" || questions['que_type'] == "check-box") {
                            if (answer['radio_image'] && is_image_option) {
                                survey_data += '<img src="' + answer['radio_image'] + '" height="30" width="30"/><a class="resetImageRadioUpload" style="padding-right: 56px;">&nbsp; Remove</a>';
                            } else {
                                survey_data += "                 <input type='file' name='radioImage_" + questions['que_type'] + "'  class='inherit-width radioImageUpload' style='width: 175px;max-width:50%; margin-left:1px; margin-top:5px;" + showFileUpload + "'> <span style='margin-left: -13px; margin-top: 6px; position:relative; z-index:500; display:none; width:auto;' class='spanRadioUploadError'><a><i class='fa fa-exclamation-circle' title='Error. This field is required.' style='color:red;font-size:12px;'></i></a></span>";
                            }
                        }
                        survey_data += '       <input type="text" ' + readonly + ' name="option_' + questions['que_type'] + '" placeholder="Option" class="inherit-width opt_' + key + '" style="margin-top:5px;max-width:50%;margin-left:1px;">';
                    } else {
                        if (questions['que_type'] == "radio-button" || questions['que_type'] == "check-box") {
                            if (answer['radio_image'] && is_image_option) {
                                survey_data += '<img src="' + answer['radio_image'] + '" height="30" width="30"/><a class="resetImageRadioUpload" style="padding-right: 56px;">&nbsp; Remove</a>';
                            } else {
                                survey_data += "                 <input type='file' name='radioImage_" + questions['que_type'] + "' id='radio_image_" + key + "'  class='inherit-width radioImageUpload' style='width: 175px;max-width:50%; margin-left:1px; margin-top:5px;" + showFileUpload + "'> <span style='margin-left: -13px; margin-top: 6px; position:relative; z-index:500; display:none; width:auto;' class='spanRadioUploadError'><a><i class='fa fa-exclamation-circle' title='Error. This field is required.' style='color:red;font-size:12px;'></i></a></span>";
                            }
                        }
                        survey_data += '       <input type="text" ' + readonly + ' name="option_' + questions['que_type'] + '" id="' + key + '" placeholder="Option" class="inherit-width" style="margin-top:5px;max-width:50%;margin-left:1px;">';
                    }
                    // set score weight
                    if (questions['enable_scoring'] == 'Yes' && typeof answer['weight'] != 'undefined')
                    {
                        var value = answer['weight'];
                    } else {
                        var value = op_count + 1;
                    }
                    // if scoring is enabled then show weight inputs with values
                    if (questions['enable_scoring'] == 'Yes')
                    {
                        survey_data += "   <input type='number' name='score_" + questions['que_type'] + "'  value='" + value + "' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;margin-left:1px;'>";
                    } else {
                        survey_data += "   <input type='number' name='score_" + questions['que_type'] + "'  value='" + value + "' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;display:none;margin-left:1px;'>";
                    }
                    //remove option button
                    survey_data += '       <a href="javascript:void(0);" class="btn  ' + questions['que_type'] + '_remove_option que_' + question_sequence + '" id="' + op_count + '" style="margin-left:2px; margin-top:5px;"><i class="fa fa-times" id="remove_option_' + op_count + '"></i></a>';
                    // add option button
                    if (op_count == ans_count && op_count >= 1) {
                        survey_data += '       <a href="javascript:void(0);" class="btn  ' + questions['que_type'] + '_add_option que_' + question_sequence + '" style="margin-left:2px; margin-top:5px;" id="' + op_count + '">  <i class="fa fa-plus"></i>   </a>';
                    } else {
                        survey_data += '       <a href="javascript:void(0);" class="btn  ' + questions['que_type'] + '_add_option que_' + question_sequence + '" style="display:none;margin-left:2px; margin-top:5px;" id="' + op_count + '">  <i class="fa fa-plus"></i>   </a>';
                    }
                    survey_data += '</div>';
                    $(survey_data).appendTo('#' + questions['que_type'] + "_options_div_" + question_sequence);
                    //set option value
                    if (CopyFromTemplate == '1')
                    {
                        self.$el.parents('.main-pane').find('#' + questions['que_type'] + "_options_div_" + question_sequence).find('.opt_' + key).val(answer['option']);
                    } else {
                        self.$el.parents('.main-pane').find('#' + key).val(answer['option']);
                    }
                    op_count++;
                });
            });
        }
        if ((questions['que_type'] == 'dropdownlist' || questions['que_type'] == 'multiselectlist') && sync_field)
        {
            self.$el.parents('.main-pane').find('.que_' + question_sequence).find('[name=option_' + questions['que_type'] + ']').attr('disabled', true);
            self.$el.parents('.main-pane').find('.que_' + question_sequence).find('.' + questions['que_type'] + '_add_option').hide();
            self.$el.parents('.main-pane').find('.que_' + question_sequence).find('.' + questions['que_type'] + '_remove_option').hide();
        }
        survey_data = '';
        //enable other option
        if (questions['que_type'] != 'boolean' && questions['que_type'] != 'emojis')
        {
            if (questions['other_option'])
            {
                $.each(questions['other_option'], function (aid, values) {
                    other_option_label = values['option'];
                    other_option_weight = values['weight'];
                    if (values['other_image']) {
                        other_option_image = values['other_image'];
                    }
                    other_option_id = aid;
                });
            }
            if (questions['enable_otherOption'] == 'Yes' && (this.model && (this.model.get('survey_type') != 'poll' || (this.context && !this.context.attributes.IsPOll)) && !questions['sync_field']) && showInputFields)
            {
                survey_data += "<div class='row' style='" + hideOther + "'>";
                survey_data += '      <div class="span12" style="background-color:#E6E0E0; border-radius: 3px; padding:4px;"><input type="checkbox" name="enable_otherOption_' + questions['que_type'] + '_' + question_sequence + '"  class="inherit-width enableOther" checked="checked"/> Add other option textbox </div>';
                survey_data += "</div>";
                survey_data += "<div class='row otheroptionRow'  style='margin-top:5px;" + hideOther + "'>";
                if ((questions['que_type'] == "radio-button" || questions['que_type'] == "check-box") && is_image_option) {
                    if (other_option_image) {
                        survey_data += " <div class='span1 otheroptiondiv' style=' border-radius: 3px; padding:4px;'>Label </div><div class='span11 otheroptiondiv'>  <img src='" + other_option_image + "' height='30' width='30'/><a class='resetImageRadioUpload' style='padding-right: 56px;'>&nbsp; Remove</a> <input id='" + other_option_id + "' placeholder='Other Option Label' style='width:50%;' value='" + other_option_label + "' type='text'  name='label_otherOption_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width other_option_label'/>";
                    } else {
                        survey_data += "      <div class='span1 otheroptiondiv' style=' border-radius: 3px; padding:4px;'>Label </div><div class='span11 otheroptiondiv'>   <input type='file' name='radioImage_" + questions['que_type'] + "_other'  class='inherit-width radioImageUpload' style='width: 175px;max-width:50%; margin-left:1px; margin-top:5px;" + showFileUpload + "'> <span style='margin-left: -13px; margin-top: 6px; position:relative; z-index:500; display:none; width:auto;' class='spanRadioUploadError'><a><i class='fa fa-exclamation-circle' title='Error. This field is required.' style='color:red;font-size:12px;'></i></a></span> <input id='" + other_option_id + "' placeholder='Other Option Label' style='width:50%;' value='" + other_option_label + "' type='text'  name='label_otherOption_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width other_option_label'/>";
                    }
                } else {
                    survey_data += "      <div class='span1 otheroptiondiv' style=' border-radius: 3px; padding:4px;'>Label </div><div class='span11 otheroptiondiv'>   <input type='file' name='radioImage_" + questions['que_type'] + "_other'  class='inherit-width radioImageUpload' style='width: 175px;max-width:50%; margin-left:1px; margin-top:5px;" + showFileUpload + "'> <span style='margin-left: -13px; margin-top: 6px; position:relative; z-index:500; display:none; width:auto;' class='spanRadioUploadError'><a><i class='fa fa-exclamation-circle' title='Error. This field is required.' style='color:red;font-size:12px;'></i></a></span><input id='" + other_option_id + "' placeholder='Other Option Label' style='width:50%;' value='" + other_option_label + "' type='text'  name='label_otherOption_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width other_option_label'/>";
                }
                if (questions['enable_scoring'] == 'Yes')
                {
                    survey_data += "      <input type='text' value='" + other_option_weight + "' style='width:7%;' Placeholder='score' name='option_score_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width other_weight'/>";
                } else {
                    survey_data += "      <input type='text' value='0' style='width:7%;display:none;' Placeholder='score' name='option_score_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width other_weight'/>";
                }
                survey_data += "</div>";
            } else if ((this.model.get('survey_type') != 'poll' || !this.context.attributes.IsPOll) && !questions['sync_field'] && showInputFields) {
                survey_data += "<div class='row'  style='" + hideOther + "'>";
                survey_data += '      <div class="span12" style="background-color:#E6E0E0; border-radius: 3px; padding:4px;"><input type="checkbox" name="enable_otherOption_' + questions['que_type'] + '_' + question_sequence + '"  class="inherit-width enableOther"/> Add other option textbox </div>';
                survey_data += "</div>";
                survey_data += "<div class='row otheroptionRow'  style='display:none;margin-top:5px;" + hideOther + "'>";
                if (questions['que_type'] == "radio-button" || questions['que_type'] == "check-box") {
                    survey_data += "      <div class='span1 otheroptiondiv' style=' border-radius: 3px; padding:4px;'>Label </div><div class='span11 otheroptiondiv'>   <input type='file' name='radioImage_" + questions['que_type'] + "_other'  class='inherit-width radioImageUpload' style='width: 175px;max-width:50%; margin-left:1px; margin-top:5px;" + showFileUpload + "'> <span style='margin-left: -13px; margin-top: 6px; position:relative; z-index:500; display:none;width:auto;' class='spanRadioUploadError'><a><i class='fa fa-exclamation-circle' title='Error. This field is required.' style='color:red;font-size:12px;'></i></a></span> <input id='" + other_option_id + "' placeholder='Other Option Label' style='width:50%;' value='" + other_option_label + "' type='text'  name='label_otherOption_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width other_option_label'/>";
                } else {
                    survey_data += "      <div class='span1 otheroptiondiv'>Label </div><div class='span11 otheroptiondiv'><input placeholder='Other Option Label' style='width:50%;' value='Other' type='text'  name='label_otherOption_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width other_option_label'/>";
                }
                if (questions['enable_scoring'] == 'Yes')
                {
                    survey_data += "      <input type='text' value='0' style='width:7%;' Placeholder='score' name='option_score_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width other_weight'/>";
                } else {
                    survey_data += "      <input type='text' value='0' style='width:7%;display:none;' Placeholder='score' name='option_score_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width other_weight'/>";
                }
                survey_data += "</div>";
            }
            survey_data += "</div>";
            $(survey_data).appendTo(self.$el.parents('.main-pane').find('#' + questions['que_type'] + "_" + question_sequence).find('.general_options'));
        } else {
            self.$el.parents('.main-pane').find('#' + questions['que_type'] + "_" + question_sequence).find('.general_options').find('.boolean_add_option').hide();
        }
        if (op_count <= 2) {
            //hide remove option button if only two option exists
            self.$el.parents('.main-pane').find('#' + questions['que_type'] + "_options_div_" + question_sequence).find('.' + questions['que_type'] + '_remove_option').hide();
        }
    },
    showOtherOptionRow: function (el) {

        if ($(el.currentTarget).prop('checked'))
        {
            if ($(el.currentTarget).parents('.general_options').find('.isImageOption').find('input[type=checkbox]:checked').length == 1) {
                $(el.currentTarget).parents('.general_options').find('.otheroptionRow').find('.radioImageUpload').show();
            } else {
                $(el.currentTarget).parents('.general_options').find('.otheroptionRow').find('.radioImageUpload').hide();
            }
            $(el.currentTarget).parents('.general_options').find('.otheroptionRow').show();
            if ($(el.currentTarget).parents('.general_options').find('.enableScore').find('input').prop('checked'))
            {
                $(el.currentTarget).parents('.general_options').find('.other_weight').show();
            }
            // Update Minimim answer limit selection
            var limit_min_selection = $(el.currentTarget).parents('.question').find('.advance_options').find('.selectionLimit').children();
            var option_count = 0;
            $.each(limit_min_selection, function () {
                option_count = $(this).val();
            });
            option_count++;
            $(el.currentTarget).parents('.question').find('.advance_options').find('.selectionLimit').append('<option value=' + option_count + '>' + option_count + '</option>');
        } else {
            $(el.currentTarget).parents('.general_options').find('.otheroptionRow').hide();
            // Update Minimim answer limit selection
            $(el.currentTarget).parents('.question').find('.advance_options').find('.selectionLimit').children(':last').remove();
        }

    },
    /**
     * Rows and Columns of matrix in edit mode
     * 
     * @questions detail of questions
     * @question_sequence sequence of question
     * @CopyFromTemplate set to 1 then page component prefill with given data
     */
    editviewRowsCols_data: function (questions, question_sequence, CopyFromTemplate) {
        var self = this;
        var survey_data = '';
        var row_count = 0;
        var col_count = 0;
        survey_data += "<div class='row'>";
        survey_data += "       <div class='span1'>Rows</div><div class='span5' id='matrix_row_div_" + question_sequence + "'>";
        survey_data += "</div>";
        survey_data += "       <div class='span1'>Columns</div><div class='span5' id='matrix_column_div_" + question_sequence + "'>";
        survey_data += "</div>";
        survey_data += '</div>';
        $(survey_data).appendTo(self.$el.parents('.main-pane').find('#matrix_' + question_sequence).find('.general_options'));
        //Row display
        $.each(jQuery.parseJSON(questions['matrix_row']), function (key, answer)
        {
            var ans_count = Object.keys(jQuery.parseJSON(questions['matrix_row'])).length - 1;
            survey_data = '';
            survey_data += '<div id="row_' + row_count + '" class="rows">';

            survey_data += '       <input type="text" name="row_matrix"  placeholder="Row label" class="inherit-width opt_' + key + '" style="margin-top:5px;max-width:50%;margin-left:1px;">';

            //remove option button
            survey_data += '       <a href="javascript:void(0);" class="btn  matrix_remove_row que_' + question_sequence + '" id="' + row_count + '" style="margin-left:2px; margin-top:5px;"><i class="fa fa-times" id="remove_row_' + row_count + '"></i></a>';
            // add option button
            if (row_count == ans_count && row_count >= 1) {
                survey_data += '       <a href="javascript:void(0);" class="btn  matrix_add_row que_' + question_sequence + '" style="margin-left:2px; margin-top:5px;" id="' + row_count + '">  <i class="fa fa-plus"></i>   </a>';
            } else {
                survey_data += '       <a href="javascript:void(0);" class="btn  matrix_add_row que_' + question_sequence + '" style="display:none;margin-left:2px; margin-top:5px;" id="' + row_count + '">  <i class="fa fa-plus"></i>   </a>';
            }
            survey_data += '</div>';
            $(survey_data).appendTo("#matrix_row_div_" + question_sequence);
            //set option value
            self.$el.parents('.main-pane').find("#matrix_row_div_" + question_sequence).find('.opt_' + key).val(answer);


            row_count++;
        });
        if (row_count <= 2) {
            //hide remove option button if only two option exists
            self.$el.parents('.main-pane').find("#matrix_row_div_" + question_sequence).find('.matrix_remove_row').hide();
        }

        //Columns
        $.each(jQuery.parseJSON(questions['matrix_col']), function (key, answer)
        {
            var ans_count = Object.keys(jQuery.parseJSON(questions['matrix_col'])).length - 1;
            survey_data = '';
            survey_data += '<div id="column_' + col_count + '" class="columns">';

            survey_data += '       <input type="text" name="column_matrix" placeholder="Column label" class="inherit-width opt_' + key + '" style="margin-top:5px;max-width:50%;margin-left:1px;">';

            //remove option button
            survey_data += '       <a href="javascript:void(0);" class="btn  matrix_remove_column que_' + question_sequence + '" id="' + col_count + '" style="margin-left:2px; margin-top:5px;"><i class="fa fa-times" id="remove_column_' + col_count + '"></i></a>';
            // add option button
            if (col_count == ans_count && col_count >= 1) {
                survey_data += '       <a href="javascript:void(0);" class="btn  matrix_add_column que_' + question_sequence + '" style="margin-left:2px; margin-top:5px;" id="' + col_count + '">  <i class="fa fa-plus"></i>   </a>';
            } else {
                survey_data += '       <a href="javascript:void(0);" class="btn  matrix_add_column que_' + question_sequence + '" style="display:none;margin-left:2px; margin-top:5px;" id="' + col_count + '">  <i class="fa fa-plus"></i>   </a>';
            }
            survey_data += '</div>';
            $(survey_data).appendTo("#matrix_column_div_" + question_sequence);

            //set option value
            self.$el.parents('.main-pane').find("#matrix_column_div_" + question_sequence).find('.opt_' + key).val(answer);

            col_count++;
        });
        if (col_count <= 2) {
            //hide remove option button if only two option exists
            self.$el.parents('.main-pane').find("#matrix_column_div_" + question_sequence).find('.matrix_remove_column').hide();
        }

    },
    /**
     * Textbox advance option in edit mode
     * 
     * @question_sequence sequence of question
     * @questions detail of questions
     */
    editviewTextBox: function (question_sequence, questions) {
        var self = this;
        var survey_data = '';
        //max allowed size & is required row start
        survey_data += '<div class="row">';
        survey_data += "      <div class='span1' style='margin-top: 5px;margin-bottom: 4px;'>Is Required </div>";
        if (questions['is_required'] == 'Yes') {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        // Add question seperator.
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Add Question Separator?</div>";
        if (questions['is_question_seperator'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        survey_data += "</div>"; //is_required & max size row closed
        var textbox_datatype = questions['advance_type'];
        survey_data += "<div class='row'>";
        survey_data += "       <div class='span1'>DataType</div>";
        survey_data += "       <div class='span5'>";
        survey_data += "        <div class=''>";
        survey_data += "          <a><select name='datatype_textbox_" + question_sequence + "' style='max-width:80%;' class='inherit-width datatype-textbox'>";
        survey_data += '          <option value="0">select</option>';
        if (textbox_datatype == 'Integer')
        {
            survey_data += '          <option value="Integer" selected>Number</option>';
        } else {
            survey_data += '          <option value="Integer">Number</option>';
        }
        if (textbox_datatype == 'Float')
        {
            survey_data += '          <option value="Float" selected>Decimal</option>';
        } else {
            survey_data += '          <option value="Float">Decimal</option>';
        }
        if (textbox_datatype == 'Char' || typeof textbox_datatype === 'undefined')
        {
            survey_data += '          <option value="Char" selected>Char</option>';
        } else {
            survey_data += '          <option value="Char" >Char</option>';
        }
        if (textbox_datatype == 'Email')
        {
            survey_data += '          <option value="Email" selected>Email</option>';
        } else {
            survey_data += '          <option value="Email">Email</option>';
        }
        survey_data += '          </select></a>';
        survey_data += "        </div>";
        survey_data += "        </div>"; // datatype span closed
        survey_data += "        </div>"; // datatype row closed

        survey_data += "<div class='row maxsize'>";
        survey_data += "       <div class='span1'>Max Size</div><div class='span5'>";
        survey_data += "          <input type='text' placeholder='Maximum acceptable char'  name='size_textbox_" + question_sequence + "'  class='inherit-width numericField' style='width:85%; margin-left:1px;'>";
        survey_data += "      </div>";
        survey_data += "</div>";
        // precision for Float datatype
        survey_data += "<div class='row precision'>";
        survey_data += "       <div class='span1'>Precision</div><div class='span5'>";
        survey_data += "           <input type='text' style='width:55%; margin-left: 1px;'  placeholder='Precision' name='precision_textbox_" + question_sequence + "'  class='inherit-width numericField' >";
        survey_data += "       </div>";
        survey_data += "</div>"; //question max and precision row closed
        // minimum and maximum value allowed for question
        survey_data += "<div class='row minmax'>";
        survey_data += "       <div class='span1'>Min Value</div><div class='span5'>";
        survey_data += "        <input type='text' style='width:55%; margin-left:1px;'  placeholder='Minimum value' name='min_textbox_" + question_sequence + "'  class='inherit-width numericField' ></div>";
        survey_data += "      <div class='span1'>Max Value</div>";
        survey_data += "      <div class='span5'><input type='text' style='width:55%; margin-left:1px;'  placeholder='Maximum value' name='max_textbox_" + question_sequence + "'  class='inherit-width numericField' ></div>";
        survey_data += "</div>";
        if (self.$el.parents('.main-pane').find('[name="sync_module"]').val())
        {
            survey_data += "</div>";

            // Piping tab contents
            var is_checked = '';
            var is_hidden = '';
            if (questions['disable_piping'] == 'Yes')
            {
                is_checked = 'checked';
                is_hidden = 'display:none'
            }
            survey_data += "<div class='piping_options'>";
            survey_data += '<div class="row">';
            survey_data += "      <div class='span3 '>Disable Piping &nbsp;";
            survey_data += "                         <input type='checkbox' style='margin-top:3px;' class='disable_piping_question' name='disable_piping_textbox_" + question_sequence + "' " + is_checked + " /> </div>";

            survey_data += "      <div class='span1 sync_field' style='" + is_hidden + "'>Sync Field </div>";
            survey_data += "      <div class='span8 sync_field' style='" + is_hidden + "'><select class='sync_field_selection' name='sync_field_textbox_" + question_sequence + "'>";
            survey_data += "            <option>Select Field</option>";
            $.each(this.sync_module_fields[self.$el.parents('.main-pane').find('[name="sync_module"]').val()], function (key, field) {
                // Piping tab contents
                var is_checked = '';
                if (questions['sync_field'] == key)
                {
                    is_checked = 'selected';
                }
                survey_data += "        <option value='" + key + "' " + is_checked + ">" + field + "</option>";
            });
            survey_data += "      </select>";
            survey_data += '<span style="display:none;" ><a>&nbsp;<i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span></div>';

            survey_data += "</div>";
        }

        return survey_data;
    },
    /**
     * Comment TexBox advance option in edit mode
     * 
     * @question_sequence sequence of question
     * @questions detail of questions
     */
    editviewCommentBox: function (question_sequence, questions) {
        var self = this;
        var survey_data = '';
        // rows & cols allowed for question
        survey_data += "<div class='row'>";
        survey_data += "       <div class='span1'>Rows</div><div class='span5'>";
        survey_data += "        <input type='text' style='width:55%; margin-left:1px;' placeholder='Rows' name='rows_commentbox_" + question_sequence + "'  class='inherit-width numericField' ></div>";
        survey_data += "      <div class='span1'>Columns</div>";
        survey_data += "      <div class='span5'><input type='text' style='width:55%; margin-left:1px;' placeholder='Columns' name='cols_commentbox_" + question_sequence + "'  class='inherit-width numericField' ></div>";
        survey_data += "</div>";
        survey_data += "<div class='row'>";
        //is_required
        survey_data += "      <div class='span1' style='margin-top: 5px;margin-bottom: 4px;'>Is Required </div>";
        if (questions['is_required'] == 'Yes') {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        // Add question seperator.
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Add Question Separator?</div>";
        if (questions['is_question_seperator'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        survey_data += "</div>";
        //max allowed size & is required row start
        survey_data += '<div class="row">';
        survey_data += "       <div class='span1'>Max Size</div><div class='span5'>";
        survey_data += "          <input type='text' placeholder='Maximum acceptable char' name='size_" + questions['que_type'] + "_" + question_sequence + "'  class='inherit-width numericField' style='width:85%; margin-left:1px;'></div>";

        survey_data += "</div>"; //max size row closed


        if (self.$el.parents('.main-pane').find('[name="sync_module"]').val())
        {
            survey_data += "</div>";

            // Piping tab contents
            var is_checked = '';
            var is_hidden = '';
            if (questions['disable_piping'] == 'Yes')
            {
                is_checked = 'checked';
                is_hidden = 'display:none'
            }
            survey_data += "<div class='piping_options'>";
            survey_data += '<div class="row">';
            survey_data += "      <div class='span3 '>Disable Piping &nbsp;";
            survey_data += "                         <input type='checkbox' style='margin-top:3px;' class='disable_piping_question' name='disable_piping_" + questions['que_type'] + "_" + question_sequence + "' " + is_checked + " /> </div>";

            survey_data += "      <div class='span1 sync_field' style='" + is_hidden + "'>Sync Field </div>";
            survey_data += "      <div class='span8 sync_field' style='" + is_hidden + "'><select class='sync_field_selection' name='sync_field_" + questions['que_type'] + "_" + question_sequence + "'>";
            survey_data += "            <option>Select Field</option>";
            $.each(this.sync_module_fields[self.$el.parents('.main-pane').find('[name="sync_module"]').val()], function (key, field) {
                // Piping tab contents
                var is_checked = '';
                if (questions['sync_field'] == key)
                {
                    is_checked = 'selected';
                }
                survey_data += "        <option value='" + key + "' " + is_checked + ">" + field + "</option>";
            });
            survey_data += "      </select>";
            survey_data += '<span style="display:none;" ><a>&nbsp;<i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span></div>';

            survey_data += "</div>";
        }

        return survey_data;
    },
    /**
     * Rich TexBox advance option in edit mode
     * 
     * @question_sequence sequence of question
     * @questions detail of questions
     */
    editviewRichTextBox: function (question_sequence, questions) {
        var self = this;
        var survey_data = '';
        survey_data += "<div class='row'>";
        // Add question seperator.
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Add Question Separator?</div>";
        if (questions['is_question_seperator'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        survey_data += "</div>";
        if (self.$el.parents('.main-pane').find('[name="sync_module"]').val())
        {
            survey_data += "</div>";

        }

        return survey_data;
    },
    /**
     * 
     * @field_id Id of field name which you want to make tynymce
     */
    convertIntoRichTextBox: function (field_id) {
        $('[name=' + field_id + ']').tinymce({
            script_url: "include/javascript/tinymce4/tinymce.min.js",
            browser_spellcheck: true,
            convert_urls: false,
            entity_encoding: "raw",
            height: "400px",
            menubar: false,
            plugins: "code,textcolor",
            relative_urls: false,
            resize: false,
            skin: "sugar",
            statusbar: false,
            theme: "modern",
            toolbar: "code | bold italic underline strikethrough | bullist numlist | alignleft aligncenter alignright alignjustify | forecolor backcolor | fontsizeselect",
            width: "100%",
            remove_script_host: false
        });
        if (tinymce && tinymce.editors && tinymce.editors.length > 0) {
            tinymce.execCommand('mceRemoveEditor', false, field_id);
            tinymce.execCommand('mceAddEditor', false, field_id);
        }
    },
    /**
     * Boolean advance option in edit mode
     * 
     * @question_sequence sequence of question
     * @questions detail of questions
     */
    editviewBoolean: function (question_sequence, questions) {
        var self = this;
        var survey_data = '';
        //max allowed size & is required row start
        survey_data += '<div class="row">';
        survey_data += "      <div class='span1' style='margin-top: 5px;margin-bottom: 4px;'>Is Required </div>";
        if (questions['is_required'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Add Question Separator?</div>";
        if (questions['is_question_seperator'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        survey_data += "</div>"; //Add Question Seperator

        if (self.$el.parents('.main-pane').find('[name="sync_module"]').val())
        {
            survey_data += "</div>";

            // Piping tab contents
            var is_checked = '';
            var is_hidden = '';
            if (questions['disable_piping'] == 'Yes')
            {
                is_checked = 'checked';
                is_hidden = 'display:none'
            }
            survey_data += "<div class='piping_options'>";
            survey_data += '<div class="row">';
            survey_data += "      <div class='span3 '>Disable Piping &nbsp;";
            survey_data += "                         <input type='checkbox' style='margin-top:3px;' class='disable_piping_question' name='disable_piping_" + questions['que_type'] + "_" + question_sequence + "' " + is_checked + " /> </div>";

            survey_data += "      <div class='span1 sync_field' style='" + is_hidden + "'>Sync Field </div>";
            survey_data += "      <div class='span8 sync_field' style='" + is_hidden + "'>";

            if (this.sync_module_fields_for_boolean && typeof this.sync_module_fields_for_boolean[self.$el.parents('.main-pane').find('[name="sync_module"]').val()] != "undefined")
            {
                survey_data += " <select class='sync_field_selection boolean_sync_field' name='sync_field_" + questions['que_type'] + "_" + question_sequence + "'>           <option>Select Field</option>";
                $.each(this.sync_module_fields_for_boolean[self.$el.parents('.main-pane').find('[name="sync_module"]').val()], function (key, field) {
                    // Piping tab contents
                    var is_checked = '';
                    if (questions['sync_field'] == key)
                    {
                        is_checked = 'selected';
                    }
                    survey_data += "        <option value='" + key + "' " + is_checked + ">" + field + "</option>";
                });
                survey_data += "      </select>";
            } else {
                survey_data += " <select class='sync_field_selection boolean_sync_field' style='display:none' name='sync_field_" + questions['que_type'] + "_" + question_sequence + "'>           <option>Select Field</option>";
                survey_data += " </select>";
                survey_data += ' <span class="no_data" style="color:red;"><i class="fa fa-exclamation-circle" style="color:red;"></i>&nbsp;There are no Fields to Sync with Boolean Data Type.</span>';
            }
            survey_data += '<span style="display:none;" ><a>&nbsp;<i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span></div>';

            survey_data += "</div>";
        }

        return survey_data;
    },
    /**
     * Rating advance option in edit mode
     * 
     * @question_sequence sequence of question
     * @questions detail of questions
     */
    editviewRating: function (question_sequence, questions) {
        var self = this;
        var survey_data = '';
        //max allowed size & is required row start
        survey_data += '<div class="row">';
        survey_data += "      <div class='span1' style='margin-top: 5px;margin-bottom: 4px;'>Is Required </div>";
        if (questions['is_required'] == 'Yes') {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        // Add question seperator.
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Add Question Separator?</div>";
        if (questions['is_question_seperator'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        survey_data += "</div>"; //is_required & max size row closed
        survey_data += '<div class="row">';
        survey_data += "       <div class='span1'>Star Numbers</div><div class='span5'>";
        survey_data += "          <select name='starNo_rating_" + question_sequence + "'  class='inherit-width' style='width:40%; margin-left:1px;'>";
        survey_data += "             <option value='0'>select</option>";
        survey_data += "             <option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option>";
        survey_data += "          </select>";
        survey_data += "      </div>";
        survey_data += "</div>";
        if (self.$el.parents('.main-pane').find('[name="sync_module"]').val())
        {
            survey_data += "</div>";

            // Piping tab contents
            var is_checked = '';
            var is_hidden = '';
            if (questions['disable_piping'] == 'Yes')
            {
                is_checked = 'checked';
                is_hidden = 'display:none'
            }
            survey_data += "<div class='piping_options'>";
            survey_data += '<div class="row">';
            survey_data += "      <div class='span3 '>Disable Piping &nbsp;";
            survey_data += "                         <input type='checkbox' style='margin-top:3px;' class='disable_piping_question' name='disable_piping_" + questions['que_type'] + "_" + question_sequence + "' " + is_checked + " /> </div>";

            survey_data += "      <div class='span1 sync_field' style='" + is_hidden + "'>Sync Field </div>";
            survey_data += "      <div class='span8 sync_field' style='" + is_hidden + "'><select class='sync_field_selection' name='sync_field_" + questions['que_type'] + "_" + question_sequence + "'>";
            survey_data += "            <option>Select Field</option>";
            $.each(this.sync_module_fields[self.$el.parents('.main-pane').find('[name="sync_module"]').val()], function (key, field) {
                // Piping tab contents
                var is_checked = '';
                if (questions['sync_field'] == key)
                {
                    is_checked = 'selected';
                }
                survey_data += "        <option value='" + key + "' " + is_checked + ">" + field + "</option>";
            });
            survey_data += "      </select>";
            survey_data += '<span style="display:none;" ><a>&nbsp;<i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span></div>';

            survey_data += "</div>";
        }

        return survey_data;
    },
    /**
     * Contact-information advance option in edit mode
     * 
     * @question_sequence sequence of question
     * @questions detail of questions
     */
    editviewContactInformation: function (question_sequence, questions) {
        var self = this;
        var survey_data = '';
        //is required or not
        survey_data += '<div class="row">';
        survey_data += "      <div class='span1' style='margin-top: 5px;margin-bottom: 4px;'>Is Required </div>";
        if (questions['is_required'] == 'Yes') {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width is_required'/></div>";
        } else {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width is_required'/></div>";
        }
        // Add question seperator.
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Add Question Separator?</div>";
        if (questions['is_question_seperator'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        survey_data += "</div>"; //is_require row closed
        if (questions['advance_type'] != null) {
            var requireFields = new Array();
            var requireFields = questions['advance_type'].split(' ');
            $.makeArray(requireFields);
        }
        if (questions['is_required'] == 'Yes' && typeof questions['advance_type'] == 'undefined') {
            var requireFields = ["Name", "Email", "Phone"];
        }
        survey_data += "<div class='requiredFields'>";
        survey_data += '  <div class="row">';
        survey_data += "       <div class='span1'>Required Fields</div><div class='span11'>";
        survey_data += "            <div class='row'>";
        survey_data += "                <div class='span2'>";
        if ($.inArray("Name", requireFields) != -1) {
            survey_data += "                    <input type='checkbox' name='Name_" + question_sequence + "' checked><span>Name</span>";
        } else {
            survey_data += "                    <input type='checkbox' name='Name_" + question_sequence + "'><span>Name</span>";
        }
        survey_data += "                </div>";
        survey_data += "                <div class='span2'>";
        if ($.inArray("Email", requireFields) != -1) {
            survey_data += "                    <input type='checkbox' name='Email_" + question_sequence + "' checked><span>Email Address</span>";
        } else {
            survey_data += "                    <input type='checkbox' name='Email_" + question_sequence + "'><span>Email Address</span>";
        }
        survey_data += "                </div>";
        survey_data += "                <div class='span2'>";
        if ($.inArray("Company", requireFields) != -1) {
            survey_data += "                    <input type='checkbox' name='Company_" + question_sequence + "' checked><span>Company</span>";
        } else {
            survey_data += "                    <input type='checkbox' name='Company_" + question_sequence + "'><span>Company</span>";
        }
        survey_data += "                </div>";
        survey_data += "                <div class='span2'>";
        if ($.inArray("Phone", requireFields) != -1) {
            survey_data += "                    <input type='checkbox' name='Phone_" + question_sequence + "' checked><span>Phone Number</span>";
        } else {
            survey_data += "                    <input type='checkbox' name='Phone_" + question_sequence + "'><span>Phone Number</span>";
        }
        survey_data += "                </div>";
        survey_data += "                <div class='span2'>";
        if ($.inArray("Address", requireFields) != -1) {
            survey_data += "                    <input type='checkbox' name='Address_" + question_sequence + "' checked><span>Street1</span>";
        } else {
            survey_data += "                    <input type='checkbox' name='Address_" + question_sequence + "'><span>Street1</span>";
        }
        survey_data += "                </div>";
        survey_data += "            </div>"; //row complete
        survey_data += "            <div class='row'>";
        survey_data += "                <div class='span2'>";
        if ($.inArray("Address2", requireFields) != -1) {
            survey_data += "                    <input type='checkbox' name='Address2_" + question_sequence + "' checked><span>Street2</span>";
        } else {
            survey_data += "                    <input type='checkbox' name='Address2_" + question_sequence + "'><span>Street2</span>";
        }
        survey_data += "                </div>";
        survey_data += "                <div class='span2'>";
        if ($.inArray("City", requireFields) != -1) {
            survey_data += "                    <input type='checkbox' name='City_" + question_sequence + "' checked><span>City/Town</span>";
        } else {
            survey_data += "                    <input type='checkbox' name='City_" + question_sequence + "'><span>City/Town</span>";
        }
        survey_data += "                </div>";
        survey_data += "                <div class='span2'>";
        if ($.inArray("State", requireFields) != -1) {
            survey_data += "                    <input type='checkbox' name='State_" + question_sequence + "' checked><span>State/ Province</span>";
        } else {
            survey_data += "                    <input type='checkbox' name='State_" + question_sequence + "'><span>State/ Province</span>";
        }
        survey_data += "                </div>";
        survey_data += "                <div class='span2'>";
        if ($.inArray("Zip", requireFields) != -1) {
            survey_data += "                    <input type='checkbox' name='Zip_" + question_sequence + "' checked><span>Zip/ Postal Code</span>";
        } else {
            survey_data += "                    <input type='checkbox' name='Zip_" + question_sequence + "'><span>Zip/ Postal Code</span>";
        }
        survey_data += "                </div>";
        survey_data += "                <div class='span2'>";
        if ($.inArray("Country", requireFields) != -1) {
            survey_data += "                    <input type='checkbox' name='Country_" + question_sequence + "' checked><span>Country</span>";
        } else {
            survey_data += "                    <input type='checkbox' name='Country_" + question_sequence + "'><span>Country</span>";
        }
        survey_data += "                </div>";
        survey_data += "            </div>"; //row complete
        survey_data += "  </div>"; // row complete
        survey_data += "</div>"; // required class complete
        survey_data += "</div>";
        if (self.$el.parents('.main-pane').find('[name="sync_module"]').val())
        {
            survey_data += "</div>";

            // Piping tab contents
            var is_checked = '';
            var is_hidden = '';
            if (questions['disable_piping'] == 'Yes')
            {
                is_checked = 'checked';
                is_hidden = 'display:none'
            }
            survey_data += "<div class='piping_options'>";
            survey_data += '<div class="row">';
            survey_data += "      <div class='span3 '>Disable Piping &nbsp;";
            survey_data += "                         <input type='checkbox' style='margin-top:3px;' class='disable_piping_question' name='disable_piping_" + questions['que_type'] + "_" + question_sequence + "' " + is_checked + " /> </div>";

            survey_data += "      <div class='span1 sync_field' style='" + is_hidden + "'>Sync Field </div>";
            survey_data += "      <div class='span8 sync_field' style='" + is_hidden + "'><select class='sync_field_selection' name='sync_field_" + questions['que_type'] + "_" + question_sequence + "'>";
            survey_data += "            <option>Select Field</option>";
            $.each(this.sync_module_fields[self.$el.parents('.main-pane').find('[name="sync_module"]').val()], function (key, field) {
                // Piping tab contents
                var is_checked = '';
                if (questions['sync_field'] == key)
                {
                    is_checked = 'selected';
                }
                survey_data += "        <option value='" + key + "' " + is_checked + ">" + field + "</option>";
            });
            survey_data += "      </select>";
            survey_data += '<span style="display:none;" ><a>&nbsp;<i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span></div>';

            survey_data += "</div>";
        }

        return survey_data;
    },
    /**
     * if required fields checked for contact information then show selection for required fields to choose
     * 
     * @el current element
     */
    showRequiredFields: function (el) {
        var self = this;
        var que_count = el.currentTarget.name.split('_')[3];
        if (el.currentTarget.checked) // show required field selection
        {
            self.$el.parents('.main-pane').find('.que_' + que_count).find('.requiredFields').show();
        } else { // hide required field selection
            self.$el.parents('.main-pane').find('.que_' + que_count).find('.requiredFields').hide();
        }
    },
    /**
     * Multi choice type of question advance option in edit mode
     * 
     * @question_sequence sequence of question
     * @questions detail of questions
     */
    editviewMultiChoice: function (question_sequence, questions) {
        var self = this;
        var survey_data = '';
        //is required or not
        survey_data += '<div class="row">';
        //is_required
        survey_data += "      <div class='span1' style='margin-top: 5px;margin-bottom: 4px;'>Is Required </div>";
        if (questions['is_required'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' style='margin:2px 7px 7px 7px' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' style='margin:2px 7px 7px 7px' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        //sorting
        survey_data += "      <div class='span1' style='margin-top: 5px;margin-bottom: 4px;'>Sortable </div>";
        if (questions['is_sort'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' style='margin:2px 7px 7px 7px' name='is_sort_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' style='margin:2px 7px 7px 7px' name='is_sort_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        //Add Question Seperator
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Add Question Separator?</div>";
        if (questions['is_question_seperator'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' style='margin:2px 7px 7px 7px' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' style='margin:2px 7px 7px 7px' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        survey_data += "</div>";
        //limit answer
        if (questions['que_type'] == 'multiselectlist' || questions['que_type'] == 'check-box')
        {
            var option_count = 0;
            if (questions['answers'])
            {
                $.each(questions['answers'], function (key, value)
                {
                    option_count++;
                });
            }
            if (option_count == 0)
            {
                option_count = 2;
            }
            if (questions['enable_otherOption'] == 'Yes' || self.$el.parents('.main-pane').find('[name=enable_otherOption_' + questions['que_type'] + '_' + question_sequence + ']:checked').length != 0)
            {
                option_count++;
            }
            survey_data += '<div class="row">';
            survey_data += "      <div class='span1'>Selection Limit </div>";
            survey_data += "<div class='span4'><select name='limit_min_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width selectionLimit' style='width:40%;'>";
            survey_data += "      <option value='0'>Select</option>";
            for (var limit_min = 1; limit_min <= option_count; limit_min++)
            {
                if (limit_min <= option_count)
                {
                    if (questions['limit_min'] == limit_min) {
                        survey_data += "      <option selected value='" + limit_min + "'>" + limit_min + "</option>";
                    } else {
                        survey_data += "      <option value='" + limit_min + "'>" + limit_min + "</option>";
                    }
                }
            }
            survey_data += "</select></div>";
            survey_data += "</div>";
        }

        // check whether Is Image Option is checked or not
        var showVertical = '';
        var showOptionText = 'display:none;';
        if (questions['is_image_option'] == 'Yes') {
            showVertical = 'display:none;';
            showOptionText = '';
        }

        //display
        if (questions['que_type'] == 'radio-button' || questions['que_type'] == 'check-box')
        {
            survey_data += "<div class='row'>";
            survey_data += "       <div class='span1'>Display</div><div class='span5'>";
            if (questions['advance_type'] == 'Vertical' || questions['advance_type'] == '' || questions['advance_type'] == null) {
                survey_data += "          <input type='radio' style='margin-right: 0px; " + showVertical + "' value='Vertical' name='display_" + questions['que_type'] + "_" + question_sequence + "'  class='inherit-width ver_ele' checked><a href='javascript:void(0);' class='btn ver_ele' style='margin-bottom-6px;margin-left-6px;" + showVertical + "'><i class='fa fa-ellipsis-v ver_ele' style='" + showVertical + "'></i>&nbsp;Vertical&nbsp;&nbsp;</a>";
            } else {
                survey_data += "          <input type='radio' style='margin-right: 0px; " + showVertical + "' value='Vertical' name='display_" + questions['que_type'] + "_" + question_sequence + "'  class='inherit-width ver_ele' ><a href='javascript:void(0);' class='btn ver_ele' style='margin-bottom-6px;margin-left-6px;" + showVertical + "'><i class='fa fa-ellipsis-v ver_ele' style='" + showVertical + "'></i>&nbsp;&nbsp;Vertical&nbsp;&nbsp;</a>";
            }
            if (questions['advance_type'] == 'Horizontal') {
                survey_data += "          <input type='radio' style='margin-right: 0px;' value='Horizontal' name='display_" + questions['que_type'] + "_" + question_sequence + "'  class='inherit-width hoz_ele' checked><a href='javascript:void(0);' class='btn hoz_ele' style='margin-bottom-6px;margin-left-6px;'><i class='fa fa-ellipsis-h hoz_ele'></i>&nbsp;Horizontal</a>";
            } else {
                survey_data += "          <input type='radio' style='margin-right: 0px;' value='Horizontal' name='display_" + questions['que_type'] + "_" + question_sequence + "'  class='inherit-width hoz_ele' ><a href='javascript:void(0);' class='btn hoz_ele' style='margin-bottom-6px;margin-left-6px;'><i class='fa fa-ellipsis-h hoz_ele'></i>&nbsp;Horizontal</a>";
            }
            survey_data += "       </div>";
            if (questions['que_type'] == 'radio-button' || questions['que_type'] == 'check-box') {
                survey_data += "       <div class='span2 showOptionText' style='" + showOptionText + "'>Show Option Text?</div><div class='span4 showOptionText' style='" + showOptionText + "'>";
                if (questions['show_option_text'] == 'Yes') {
                    survey_data += "      <input type='checkbox' style='margin:2px 7px 7px 7px' name='show_option_text_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/>";
                } else {
                    survey_data += "      <input type='checkbox' style='margin:2px 7px 7px 7px' name='show_option_text_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/>";
                }
                survey_data += "</div>";
            }

            survey_data += "</div>";
        }
        if (self.$el.parents('.main-pane').find('[name="sync_module"]').val())
        {
            survey_data += "</div>";

            // Piping tab contents
            var is_checked = '';
            var is_hidden = '';
            if (questions['disable_piping'] == 'Yes')
            {
                is_checked = 'checked';
                is_hidden = 'display:none'
            }
            survey_data += "<div class='piping_options'>";
            survey_data += '<div class="row">';
            survey_data += "      <div class='span3 '>Disable Piping &nbsp;";
            survey_data += "                         <input type='checkbox' style='margin-top:3px;' class='disable_piping_question' name='disable_piping_" + questions['que_type'] + "_" + question_sequence + "' " + is_checked + " /> </div>";

            survey_data += "      <div class='span1 sync_field' style='" + is_hidden + "'>Sync Field </div>";
            survey_data += "      <div class='span8 sync_field' style='" + is_hidden + "'><select class='sync_field_selection' name='sync_field_" + questions['que_type'] + "_" + question_sequence + "'>";
            survey_data += "            <option>Select Field</option>";

            $.each(this.sync_module_fields[self.$el.parents('.main-pane').find('[name="sync_module"]').val()], function (key, field) {
                // Piping tab contents
                var is_checked = '';
                if (questions['sync_field'] == key)
                {
                    is_checked = 'selected';
                }
                survey_data += "        <option value='" + key + "' " + is_checked + ">" + field + "</option>";
            });

            survey_data += "      </select>";
            survey_data += '<span style="display:none;" ><a>&nbsp;<i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span></div>';
        }
        survey_data += "</div>";

        return survey_data;
    },
    /**
     * Date-Time type of question advance option in edit mode
     * 
     * @question_sequence sequence of question
     * @questions detail of questions
     */
    editviewDatetime: function (question_sequence, questions) {
        var self = this;
        var survey_data = '';
        //is required or not
        survey_data += '<div class="row">';
        //is_required
        survey_data += "      <div class='span1' style='margin-top: 5px;margin-bottom: 4px;'>Is Required </div>";
        if (questions['is_required'] == 'Yes') {
            survey_data += "      <div class='span1'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span1'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        //sorting
        survey_data += "      <div class='span1' style='margin-top: 5px;margin-bottom: 4px;'>Is DateTime</div>";
        if (questions['sync_field'])
        {
            var disabled = 'disabled';
        } else {
            var disabled = '';
        }
        if (questions['is_datetime'] == 'Yes') {
            survey_data += "      <div class='span1'><input type='checkbox' " + disabled + " name='is_datetime_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span1'><input type='checkbox' " + disabled + "  name='is_datetime_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        // Add question seperator.
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Add Question Separator?</div>";
        if (questions['is_question_seperator'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        // Allow Future Dates
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Allow Future Dates ?</div>";
        if (questions['allow_future_dates'] == 'No') {
            survey_data += "      <div class='span2'><input type='checkbox' name='allow_future_dates_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='allow_future_dates_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        }
        survey_data += '</div>';
        survey_data += '<div class="row">';
        //start date
        survey_data += "       <div class='span3'>";
        survey_data += '        <span sfuuid = "335" class = "edit" >Start Date<br/>';
        survey_data += '        <div class = "input-append date datetime" style="position:relative" >';
        if (questions['min'])
        {
            survey_data += '        <input value = "' + questions['min'] + '" name="startDate_' + questions['que_type'] + '_' + question_sequence + '" style = "width:85%;margin-top:5px;margin-left:3px;" name = "show_startdatepicker" class = "show_datepicker datepicker" type = "text" data-type = "date" class = "ui-timepicker-input" placeholder = "Date" aria-label = "Start Date">';
        } else {
            survey_data += '        <input name="startDate_' + questions['que_type'] + '_' + question_sequence + '" style = "width:85%;margin-left:3px;margin-top:5px;" name = "show_startdatepicker" class = "show_datepicker datepicker" type = "text" data-type = "date" class = "ui-timepicker-input" placeholder = "Date" aria-label = "Start Date">';
        }
        survey_data += '        <span name = "date_error" class = "error-tooltip add-on " style = "display:none;" data-container = "body" rel = "tooltip"  title = "Error. The date of this field must be after current Date." > <i class = "fa fa-exclamation-circle" > </i></span >';
        survey_data += '        <span class = "add-on date" data-icon = "calendar" style="margin-top:5px;"> <i class = "fa fa-calendar" > </i></span >';
        survey_data += "       </div>";
        survey_data += "       </div>";
        //end date
        survey_data += "       <div class='span5'>";
        survey_data += '        <span sfuuid = "335" class = "edit" >End Date&nbsp;<br/>';
        survey_data += '        <div class = "input-append date datetime" style="position:relative">';
        if (questions['max']) {
            survey_data += '        <input value = "' + questions['max'] + '" name="endDate_' + questions['que_type'] + '_' + question_sequence + '" style = "width:55%;margin-top:5px;margin-left:3px;" name = "show_enddatepicker" class = "show_datepicker datepicker" type = "text" data-type = "date" class = "ui-timepicker-input" placeholder = "Date" aria-label = "Start Date">';
        } else {
            survey_data += '        <input name="endDate_' + questions['que_type'] + '_' + question_sequence + '" style = "width:55%;margin-left:3px;margin-top:5px;" name = "show_enddatepicker" class = "show_datepicker datepicker" type = "text" data-type = "date" class = "ui-timepicker-input" placeholder = "Date" aria-label = "Start Date">';
        }
        survey_data += '        <span name = "date_error" class = "error-tooltip add-on " style = "display:none;" data-container = "body" rel = "tooltip"  title = "Error. The date of this field must be after Start Date." > <i class = "fa fa-exclamation-circle" > </i></span >';
        survey_data += '        <span class = "add-on date" data-icon = "calendar" style="margin-top:5px;"> <i class = "fa fa-calendar" > </i></span >';
        survey_data += "       </div>";
        survey_data += "       </div>";
        survey_data += "</div>";
        survey_data += "</div>";
        if (self.$el.parents('.main-pane').find('[name="sync_module"]').val())
        {
            // Piping tab contents
            var is_checked = '';
            var is_hidden = '';
            if (questions['disable_piping'] == 'Yes')
            {
                is_checked = 'checked';
                is_hidden = 'display:none'
            }
            survey_data += "<div class='piping_options'>";
            survey_data += '<div class="row">';
            survey_data += "      <div class='span3 '>Disable Piping &nbsp;";
            survey_data += "                         <input type='checkbox' style='margin-top:3px;' class='disable_piping_question' name='disable_piping_" + questions['que_type'] + "_" + question_sequence + "' " + is_checked + " /> </div>";

            survey_data += "      <div class='span1 sync_field' style='" + is_hidden + "'>Sync Field </div>";
            survey_data += "      <div class='span8 sync_field' style='" + is_hidden + "'><select class='sync_field_selection' name='sync_field_" + questions['que_type'] + "_" + question_sequence + "'>";
            survey_data += "            <option>Select Field</option>";
            $.each(this.sync_module_fields[self.$el.parents('.main-pane').find('[name="sync_module"]').val()], function (key, field) {
                // Piping tab contents
                var is_checked = '';
                if (questions['sync_field'] == key)
                {
                    is_checked = 'selected';
                }
                survey_data += "        <option value='" + key + "' " + is_checked + ">" + field + "</option>";
            });
            survey_data += "      </select>";
            survey_data += '<span style="display:none;" ><a>&nbsp;<i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span></div>';
        }
        survey_data += "</div>";

        return survey_data;
    },
    /**
     * Video type of question advance option in edit mode
     * 
     * @question_sequence sequence of question
     * @questions detail of questions
     */
    editviewVideo: function (question_sequence, questions) {
        var self = this;
        var survey_data = '';
        // is required row start

        //video description
        survey_data += '<div class="row">';
        survey_data += "      <div class='span1'>Description </div>";
        if (questions['description'] != '' && questions['description'] != null) {
            var desc = questions['description'];
        } else {
            var desc = '';
        }
        survey_data += "      <div class='span11'><textarea name='description_" + questions['que_type'] + "_" + question_sequence + "' style='max-width:80%;margin-left: 1px;'  class='inherit-width'>" + desc + "</textarea></div>";
        survey_data += "</div>"; //is_required row closed
        survey_data += '<div class="row">';
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Add Question Separator?</div>";
        if (questions['is_question_seperator'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        survey_data += "</div>"; //Add Question Seperator
        if (self.$el.parents('.main-pane').find('[name="sync_module"]').val())
        {
            survey_data += "</div>";

            // Piping tab contents
            var is_checked = '';
            var is_hidden = '';
            if (questions['disable_piping'] == 'Yes')
            {
                is_checked = 'checked';
                is_hidden = 'display:none'
            }
            survey_data += "<div class='piping_options'>";
            survey_data += '<div class="row">';
            survey_data += "      <div class='span3 '>Disable Piping &nbsp;";
            survey_data += "                         <input type='checkbox' style='margin-top:3px;' class='disable_piping_question' name='disable_piping_" + questions['que_type'] + "_" + question_sequence + "' " + is_checked + " /> </div>";

            survey_data += "      <div class='span1 sync_field' style='" + is_hidden + "'>Sync Field </div>";
            survey_data += "      <div class='span8 sync_field' style='" + is_hidden + "'><select class='sync_field_selection' name='sync_field_" + questions['que_type'] + "_" + question_sequence + "'>";
            survey_data += "            <option>Select Field</option>";
            $.each(this.sync_module_fields[self.$el.parents('.main-pane').find('[name="sync_module"]').val()], function (key, field) {
                // Piping tab contents
                var is_checked = '';
                if (questions['sync_field'] == key)
                {
                    is_checked = 'selected';
                }
                survey_data += "        <option value='" + key + "' " + is_checked + ">" + field + "</option>";
            });
            survey_data += "      </select>";
            survey_data += '<span style="display:none;" ><a>&nbsp;<i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span></div>';

            survey_data += "</div>";
        }
        return survey_data;
    },
    /**
     * Image type of question advance option in edit mode
     * 
     * @question_sequence sequence of question
     * @questions detail of questions
     */
    editviewImage: function (question_sequence, questions) {
        var self = this;
        var survey_data = '';
        // Add question seperator.
        survey_data += '<div class="row">';
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Add Question Separator?</div>";
        if (questions['is_question_seperator'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        survey_data += "</div>";
        survey_data += "</div>";
        if (self.$el.parents('.main-pane').find('[name="sync_module"]').val())
        {
            // Piping tab contents
            var is_checked = '';
            var is_hidden = '';
            if (questions['disable_piping'] == 'Yes')
            {
                is_checked = 'checked';
                is_hidden = 'display:none'
            }
            survey_data += "<div class='piping_options'>";
            survey_data += '<div class="row">';
            survey_data += "      <div class='span3 '>Disable Piping &nbsp;";
            survey_data += "                         <input type='checkbox' style='margin-top:3px;' class='disable_piping_question' name='disable_piping_" + questions['que_type'] + "_" + question_sequence + "' " + is_checked + " /> </div>";

            survey_data += "      <div class='span1 sync_field' style='" + is_hidden + "'>Sync Field </div>";
            survey_data += "      <div class='span8 sync_field' style='" + is_hidden + "'><select class='sync_field_selection' name='sync_field_" + questions['que_type'] + "_" + question_sequence + "'>";
            survey_data += "            <option>Select Field</option>";
            $.each(this.sync_module_fields[self.$el.parents('.main-pane').find('[name="sync_module"]').val()], function (key, field) {
                // Piping tab contents
                var is_checked = '';
                if (questions['sync_field'] == key)
                {
                    is_checked = 'selected';
                }
                survey_data += "        <option value='" + key + "' " + is_checked + ">" + field + "</option>";
            });
            survey_data += "      </select>";
            survey_data += '<span style="display:none;" ><a>&nbsp;<i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span></div>';

            survey_data += "</div>";
        }
        return survey_data;
    },
    /**
     * Scaletype of question advance option in edit mode
     * 
     * @question_sequence sequence of question
     * @questions detail of questions
     */
    editviewScale: function (question_sequence, questions) {
        var self = this;
        var survey_data = '';
        //max allowed size & is required row start
        var labels = questions['advance_type'] != null ? questions['advance_type'].split('-') : '';
        var left = labels[0] != null ? labels[0] : '';
        var middle = labels[1] != null ? labels[1] : '';
        var right = labels[2] != null ? labels[2] : '';
        survey_data += '<div class="row">';
        survey_data += "       <div class='span1'>Display Label</div><div class='span5'>";
        survey_data += "          <input maxlength='20' type='text' placeholder='Left' name='left_" + questions['que_type'] + "_" + question_sequence + "'  class='inherit-width alphaField' value='" + left + "' style='width:25%; margin-left:1px;'>";
        survey_data += "          <input maxlength='20' type='text' placeholder='Middle' name='middle_" + questions['que_type'] + "_" + question_sequence + "'  class='inherit-width alphaField' value='" + middle + "' style='width:25%; margin-left:1px;'>";
        survey_data += "          <input maxlength='20' type='text' placeholder='Right' name='right_" + questions['que_type'] + "_" + question_sequence + "'  class='inherit-width alphaField' value='" + right + "' style='width:25%; margin-left:1px; '></div>";
        survey_data += "</div>";
        //is_required And Add Question Sep
        survey_data += '<div class="row">';
        survey_data += "      <div class='span1' style='margin-top: 5px;margin-bottom: 4px;'>Is Required </div>";
        if (questions['is_required'] == 'Yes') {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        // Add question seperator.
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Add Question Separator?</div>";
        if (questions['is_question_seperator'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        survey_data += "</div>";
        var start_value = questions['min'] != null ? questions['min'] : 0;
        var end_value = questions['max'] != null ? questions['max'] : 10;
        var scale_slot = questions['scale_slot'] != null ? questions['scale_slot'] : 1;
        // rows & cols allowed for question
        survey_data += "<div class='row'>";
        survey_data += "       <div class='span1'>Start & End Value </div><div class='span5'>";
        survey_data += "        <input type='text' style='width:25%; margin-left:1px;' placeholder='Start Value' name='start_" + questions['que_type'] + "_" + question_sequence + "' value='" + start_value + "'  class='inherit-width numericField'>&nbsp; -";
        survey_data += "        <input type='text' style='width:25%; margin-left:1px;' placeholder='End Value' name='end_" + questions['que_type'] + "_" + question_sequence + "'  value='" + end_value + "' class='inherit-width numericField' ></div>";
        survey_data += "      <div class='span1'>Step Value</div>";
        survey_data += "      <div class='span5'><input type='text' style='width:55%; margin-left:1px;' placeholder='Step Value' name='step_" + questions['que_type'] + "_" + question_sequence + "' value='" + scale_slot + "'  class='inherit-width numericField' ></div>";
        survey_data += "</div>";
        survey_data += "</div>";
        if (self.$el.parents('.main-pane').find('[name="sync_module"]').val())
        {
            // Piping tab contents
            var is_checked = '';
            var is_hidden = '';
            if (questions['disable_piping'] == 'Yes')
            {
                is_checked = 'checked';
                is_hidden = 'display:none'
            }
            survey_data += "<div class='piping_options'>";
            survey_data += '<div class="row">';
            survey_data += "      <div class='span3 '>Disable Piping &nbsp;";
            survey_data += "                         <input type='checkbox' style='margin-top:3px;' class='disable_piping_question' name='disable_piping_" + questions['que_type'] + "_" + question_sequence + "' " + is_checked + " /> </div>";

            survey_data += "      <div class='span1 sync_field' style='" + is_hidden + "'>Sync Field </div>";
            survey_data += "      <div class='span8 sync_field' style='" + is_hidden + "'><select class='sync_field_selection' name='sync_field_" + questions['que_type'] + "_" + question_sequence + "'>";
            survey_data += "            <option>Select Field</option>";
            $.each(this.sync_module_fields[self.$el.parents('.main-pane').find('[name="sync_module"]').val()], function (key, field) {
                // Piping tab contents
                var is_checked = '';
                if (questions['sync_field'] == key)
                {
                    is_checked = 'selected';
                }
                survey_data += "        <option value='" + key + "' " + is_checked + ">" + field + "</option>";
            });
            survey_data += "      </select>";
            survey_data += '<span style="display:none;" ><a>&nbsp;<i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span></div>';

            survey_data += "</div>";
        }
        return survey_data;
    },

    /**
     * NPS type of question advance option in edit mode
     * 
     * @question_sequence sequence of question
     * @questions detail of questions
     */
    editviewNetPromoterScore: function (question_sequence, questions) {
        var self = this;
        var survey_data = '';
        //max allowed size & is required row start
        var labels = questions['advance_type'] != null ? questions['advance_type'].split('-') : '';
        var left = labels[0] != null ? labels[0] : 'Very Unlikely';
        var right = labels[1] != null ? labels[1] : 'Very Likely';
        survey_data += '<div class="row">';
        survey_data += "       <div class='span1'>Display Label</div><div class='span5'>";
        survey_data += "          <input maxlength='20' type='text' placeholder='Left' name='left_" + questions['que_type'] + "_" + question_sequence + "'  class='inherit-width' value='" + left + "' style='width:25%; margin-left:1px;'>";
        survey_data += "          <input maxlength='20' type='text' placeholder='Right' name='right_" + questions['que_type'] + "_" + question_sequence + "'  class='inherit-width' value='" + right + "' style='width:25%; margin-left:1px; '></div>";
        survey_data += "</div>";
        //is_required And Add Question Sep
        survey_data += '<div class="row">';
        survey_data += "      <div class='span1' style='margin-top: 5px;margin-bottom: 4px;'>Is Required </div>";
        if (questions['is_required'] == 'Yes') {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        // Add question seperator.
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Add Question Separator?</div>";
        if (questions['is_question_seperator'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        survey_data += "</div>";
        survey_data += "</div>";
        if (self.$el.parents('.main-pane').find('[name="sync_module"]').val())
        {
            // Piping tab contents
            var is_checked = '';
            var is_hidden = '';
            if (questions['disable_piping'] == 'Yes')
            {
                is_checked = 'checked';
                is_hidden = 'display:none'
            }
            survey_data += "<div class='piping_options'>";
            survey_data += '<div class="row">';
            survey_data += "      <div class='span3 '>Disable Piping &nbsp;";
            survey_data += "                         <input type='checkbox' style='margin-top:3px;' class='disable_piping_question' name='disable_piping_" + questions['que_type'] + "_" + question_sequence + "' " + is_checked + " /> </div>";

            survey_data += "      <div class='span1 sync_field' style='" + is_hidden + "'>Sync Field </div>";
            survey_data += "      <div class='span8 sync_field' style='" + is_hidden + "'><select class='sync_field_selection' name='sync_field_" + questions['que_type'] + "_" + question_sequence + "'>";
            survey_data += "            <option>Select Field</option>";
            $.each(this.sync_module_fields[self.$el.parents('.main-pane').find('[name="sync_module"]').val()], function (key, field) {
                // Piping tab contents
                var is_checked = '';
                if (questions['sync_field'] == key)
                {
                    is_checked = 'selected';
                }
                survey_data += "        <option value='" + key + "' " + is_checked + ">" + field + "</option>";
            });
            survey_data += "      </select>";
            survey_data += '<span style="display:none;" ><a>&nbsp;<i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span></div>';

            survey_data += "</div>";
        }
        return survey_data;
    },
    /**
     * NPS type of question advance option in edit mode
     * 
     * @question_sequence sequence of question
     * @questions detail of questions
     */
    editviewEmojis: function (question_sequence, questions) {
        var self = this;
        var survey_data = '';
        //is_required And Add Question Sep
        survey_data += '<div class="row">';
        survey_data += "      <div class='span1' style='margin-top: 5px;margin-bottom: 4px;'>Is Required </div>";
        if (questions['is_required'] == 'Yes') {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        // Add question seperator.
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Add Question Separator?</div>";
        if (questions['is_question_seperator'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        survey_data += "</div>";
        survey_data += "</div>";
        return survey_data;
    },
    /**
     * Matrix type of question advance option in edit mode
     * 
     * @question_sequence sequence of question
     * @questions detail of questions
     */
    editviewMatrix: function (question_sequence, questions) {
        var self = this;
        var survey_data = '';
        //is required or not
        survey_data += '<div class="row">';
        //is_required
        survey_data += "      <div class='span1' style='margin-top: 5px;margin-bottom: 4px;'>Is Required </div>";
        if (questions['is_required'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        // Add question seperator.
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Add Question Separator?</div>";
        if (questions['is_question_seperator'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        survey_data += '</div>';
        //answer type display
        survey_data += '<div class="row">';
        survey_data += "      <div class='span1'>Display type </div>";
        survey_data += "      <div class='span8'>";
        if (questions['advance_type'] == 'radio') {
            survey_data += "      <input type='radio' style='margin-right: 0px;' value='radio' name='display_type_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/><a href='javascript:void(0);' class='btn' style='margin-bottom-6px;margin-left-6px;'> <i class='fa fa-dot-circle-o'></i>&nbsp; Radio</a></i>&nbsp;&nbsp;";
        } else if (questions['advance_type'] == 'checkbox') {
            survey_data += "      <input type='radio' style='margin-right: 0px;' value='radio' name='display_type_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/><a href='javascript:void(0);' class='btn' style='margin-bottom-6px;margin-left-6px;'> <i class='fa fa-dot-circle-o'></i>&nbsp; Radio</a></i>&nbsp;&nbsp;";
        } else {
            survey_data += "      <input type='radio' style='margin-right: 0px;' value='radio' name='display_type_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/><a href='javascript:void(0);' class='btn' style='margin-bottom-6px;'> <i class='fa fa-dot-circle-o'></i>&nbsp; Radio</a></i>&nbsp;&nbsp;";
        }

        if (questions['advance_type'] == 'checkbox') {
            survey_data += "      <input type='radio' style='margin-right: 0px;' value='checkbox' name='display_type_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/><a href='javascript:void(0);' class='btn' style='margin-bottom-6px;margin-left-6px;'> <i class='fa fa-check-square-o'></i>&nbsp; Checkbox";
        } else {
            survey_data += "      <input type='radio' style='margin-right: 0px;' value='checkbox' name='display_type_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/><a href='javascript:void(0);' class='btn' style='margin-bottom-6px;margin-left-6px;'> <i class='fa fa-check-square-o'></i>&nbsp; Checkbox";
        }
        survey_data += "                   </a>";
        survey_data += "</div>";
        survey_data += "</div>";
        survey_data += "</div>";
        if (self.$el.parents('.main-pane').find('[name="sync_module"]').val())
        {
            // Piping tab contents
            var is_checked = '';
            var is_hidden = '';
            if (questions['disable_piping'] == 'Yes')
            {
                is_checked = 'checked';
                is_hidden = 'display:none'
            }
            survey_data += "<div class='piping_options'>";
            survey_data += '<div class="row">';
            survey_data += "      <div class='span3 '>Disable Piping &nbsp;";
            survey_data += "                         <input type='checkbox' style='margin-top:3px;' class='disable_piping_question' name='disable_piping_" + questions['que_type'] + "_" + question_sequence + "' " + is_checked + " /> </div>";

            survey_data += "      <div class='span1 sync_field' style='" + is_hidden + "'>Sync Field </div>";
            survey_data += "      <div class='span8 sync_field' style='" + is_hidden + "'><select class='sync_field_selection' name='sync_field_" + questions['que_type'] + "_" + question_sequence + "'>";
            survey_data += "            <option>Select Field</option>";
            $.each(this.sync_module_fields[self.$el.parents('.main-pane').find('[name="sync_module"]').val()], function (key, field) {
                // Piping tab contents
                var is_checked = '';
                if (questions['sync_field'] == key)
                {
                    is_checked = 'selected';
                }
                survey_data += "        <option value='" + key + "' " + is_checked + ">" + field + "</option>";
            });
            survey_data += "      </select>";
            survey_data += '<span style="display:none;" ><a>&nbsp;<i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span></div>';

            survey_data += "</div>";
        }
        return survey_data;
    },
    /**
     * Document Attachment advance option in edit mode
     * 
     * @question_sequence sequence of question
     * @questions detail of questions
     */
    editviewDocAttachment: function (question_sequence, questions) {
        var self = this;
        var survey_data = '';
        //max allowed size & is required row start
        survey_data += '<div class="row">';
        survey_data += "      <div class='span1' style='margin-top: 5px;margin-bottom: 4px;'>Is Required </div>";
        if (questions['is_required'] == 'Yes') {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span5'><input type='checkbox' name='is_required_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        //Add Question Seperator
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>Add Question Separator?</div>";
        if (questions['is_question_seperator'] == 'Yes') {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' checked='checked' class='inherit-width'/></div>";
        } else {
            survey_data += "      <div class='span2'><input type='checkbox' name='is_question_seperator_" + questions['que_type'] + "_" + question_sequence + "' class='inherit-width'/></div>";
        }
        survey_data += "</div>";
        var file_sizeBytes = {'1000000': '1 MB', '2000000': '2 MB', '3000000': '3 MB', '4000000': '4 MB', '5000000': '5 MB'};
        var fileSize = '5000000'
        if (typeof questions['file_size'] == 'undefined' || questions['file_size'] == '') {
        } else {
            fileSize = questions['file_size'];
        }

        survey_data += '<div class="row">';
        survey_data += "      <div class='span1' style='margin-top: 5px;margin-bottom: 4px;'>File Size </div>";
        survey_data += "      <div class='span5'>";
        survey_data += "<select id='file_size_" + question_sequence + "' name='file_size_" + questions['que_type'] + "_" + question_sequence + "'>";
        $.each(file_sizeBytes, function (bytes, labelMB) {
            var sel = '';
            if (fileSize === bytes) {
                sel = 'selected';
            }
            survey_data += "<option value='" + bytes + "' " + sel + ">" + labelMB + "</option>";
        });
        survey_data += "</select>";
        survey_data += "</div>";
        var valid_fileext = ['CSV', 'DOC', 'DOCX', 'HTML', 'HTM', 'JPEG', 'JPG', 'ODS', 'ODT', 'PDF', 'PNG', 'PPT', 'PPS', 'RTF', 'SXW', 'TAB', 'TXT', 'TEXT', 'TSV', 'XLS', 'XLSX'];
        //Add Question Seperator
        survey_data += "      <div class='span2' style='margin-top: 5px;margin-bottom: 4px;'>File Extension </div>";
        survey_data += "      <div class='span3' style='position: relative;'>";
        survey_data += "<select id='file_extension_" + question_sequence + "' name='file_extension_" + questions['que_type'] + "_" + question_sequence + "' multiple='true'>";
        var selectedExts = valid_fileext;
        if (typeof questions['file_extension'] !== 'undefined' && questions['file_extension'] != '') {
            selectedExts = questions['file_extension'].split(',');
        }
        $.each(valid_fileext, function (k, v) {
            var sel = '';
            if (jQuery.inArray(v, selectedExts) !== -1) {
                sel = 'selected';
            }
            survey_data += "<option value='" + v + "' " + sel + ">" + v + "</option>";
        });
        survey_data += "</select>";
        survey_data += '          <span style="display:none;" class="requireSpanClass"><a><i class="fa fa-exclamation-circle" title="Error. This field is required." style="color:red;font-size:12px;"></i></a></span>';
        survey_data += "</div>";



        survey_data += "</div>";


        survey_data += "</div>"; //is_required row closed

        return survey_data;
    },
    disable_piping_question: function (el) {
        var self = this;
        var current_que_detail = $(el.currentTarget).parents('.question').attr('id').split('_');
        var current_que_type = current_que_detail[0];
        var current_que_seq = current_que_detail[1];
        var enable_scoring = $('[name=enable_scoring_' + current_que_type + '_' + current_que_seq + ']');
        if ($(el.currentTarget).attr('checked') == 'checked')
        {

            $(el.currentTarget).parents('.question').find('.sync_field').hide();
            if ($(el.currentTarget).parents('.question').find('.boolean_sync_field').length == 0)
            {
                self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('[name=option_' + current_que_seq + ']').removeAttr('disabled');
                self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('.' + current_que_type + '_add_option:last').show();
                self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('.' + current_que_type + '_remove_option').show();
                self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('.enableOther').parent().show();

                // reset options
                var survey_data = '';
                survey_data += '<div id="option_1" class="options">';
                survey_data += '       <input type="text" name="option_' + current_que_type + '" id="" placeholder="Option" class="inherit-width" style="margin-top:5px;max-width:50%;margin-left:1px;">';

                // set score weight
                // if scoring is enabled then show weight inputs with values
                if (enable_scoring == 'Yes')
                {
                    survey_data += "   <input type='number' name='score_" + current_que_type + "'  value='1' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;margin-left:1px;'>";
                } else {
                    survey_data += "   <input type='number' name='score_" + current_que_type + "'  value='1' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;display:none;margin-left:1px;'>";
                }
                //remove option button
                survey_data += '       <a href="javascript:void(0);" class="btn  ' + current_que_type + '_remove_option que_' + current_que_seq + '" id="1" style="margin-left:2px; margin-top:5px;"><i class="fa fa-times" id="remove_option_1"></i></a>';

                survey_data += '</div>';
                survey_data += '<div id="option_2" class="options">';
                survey_data += '       <input type="text" name="option_' + current_que_type + '" id="" placeholder="Option" class="inherit-width" style="margin-top:5px;max-width:50%;margin-left:1px;">';

                // set score weight
                // if scoring is enabled then show weight inputs with values
                if (enable_scoring == 'Yes')
                {
                    survey_data += "   <input type='number' name='score_" + current_que_type + "'  value='2' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;margin-left:1px;'>";
                } else {
                    survey_data += "   <input type='number' name='score_" + current_que_type + "'  value='2' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;display:none;margin-left:1px;'>";
                }
                //remove option button
                survey_data += '       <a href="javascript:void(0);" class="btn  ' + current_que_type + '_remove_option que_' + current_que_seq + '" id="2" style="margin-left:2px; margin-top:5px;"><i class="fa fa-times" id="remove_option_2"></i></a>';
                survey_data += '       <a href="javascript:void(0);" class="btn  ' + current_que_type + '_add_option que_' + current_que_seq + '" style="margin-left:2px; margin-top:5px;" id="2">  <i class="fa fa-plus"></i>   </a>';

                survey_data += '</div>';
                if ($(el.currentTarget).parents('.question').find('.sync_field_selection').val() != 'Select Field')
                {
                    self.$el.parents('.main-pane').find('#' + current_que_type + "_options_div_" + current_que_seq).html(survey_data);
                }

                // hide Other 
                $(el.currentTarget).parents('.question').find('.enableOther').hide();
                $(el.currentTarget).parents('.question').find('.otheroptiondiv').hide();
            }

            $(el.currentTarget).parents('.question').find('.datatype-textbox').val('0').removeAttr('disabled');
            $(el.currentTarget).parents('.question').find('.maxsize').show();
        } else {
            $(el.currentTarget).parents('.question').find('.sync_field').show();
            $(el.currentTarget).parents('.question').find('.sync_field_selection').val('Select Field');
            $(el.currentTarget).parents('.question').find('.enableOther').show();
        }
    },
    check_syn_field_type_convert_question_type: function (el) {
        var sync_field = $(el.currentTarget).val();
        var self = this;
        var duplicate_count = 0;
        $.each(self.$el.parents('.main-pane').find('.sync_field_selection'), function () {
            if ($(this).val() && $(this).val() != 'Select Field' && $(this).val() == sync_field)
            {
                duplicate_count++;
            }
        });
        if (duplicate_count > 1)
        {
            app.alert.show('error', {
                level: 'error',
                messages: 'Selected sync field already synced with another Survey Question.',
                autoClose: true
            });
            $(el.currentTarget).val('Select Field');
        } else {

            var question_id = '';

            var sync_module = self.$el.parents('.main-pane').find('[name=sync_module]').val();
            var current_que_detail = $(el.currentTarget).parents('.question').attr('id').split('_');
            var current_que_type = current_que_detail[0];
            var current_que_seq = current_que_detail[1];
            var question = self.$el.parents('.main-pane').find('[name=question_' + current_que_type + '_' + current_que_seq + ']').val(); // question title
            var is_required = self.$el.parents('.main-pane').find('[name=is_required_' + current_que_type + '_' + current_que_seq + ']').attr('checked'); // is required or not
            var helptips = self.$el.parents('.main-pane').find('[name=helptips_' + current_que_type + '_' + current_que_seq + ']').val(); // helptips
            var display_boolean_label = self.$el.parents('.main-pane').find('[name=display_label_' + current_que_type + '_' + current_que_seq + ']').val(); // helptips
            if (typeof display_boolean_label == 'undefined') {
                display_boolean_label = localStorage['display_boolean_label'];
            }
            if (self.$el.parents('.main-pane').find('#' + current_que_type + '_' + current_que_seq).find('.que_id').length != 0) {
                //in edit mode current question id of 36 char
                question_id = self.$el.parents('.main-pane').find('#' + current_que_type + '_' + current_que_seq).find('.que_id').val();
            }
            if (current_que_type != 'boolean')
            {

                if (current_que_type == 'textbox')
                {
                    var data_type = $(el.currentTarget).parents('.question').find('.datatype-textbox').val();
                }

                if (sync_field && sync_field != 'Select Field')
                {
                    var url = App.api.buildURL("bc_survey", "compare_survey_field_with_module_field", "", {sync_field: sync_field, sync_module: sync_module, current_que_type: current_que_type});
                    App.api.call('GET', url, {}, {
                        success: function (data) {

                            if (typeof data != "object") {
                                data = JSON.parse(data);
                            }

                            if (data['is_required'])
                            {
                                is_required = 'checked';
                            }

                            if (data) {
                                // If question type is coorect
                                if (data['correct_que_type'] == current_que_type)
                                {
                                    // question data type does not match
                                    if (data_type != data['correct_data_type'])
                                    {
                                        app.alert.show('change_data_type_confirmation', {
                                            level: 'confirmation',
                                            title: '',
                                            messages: 'By selecting this field question data type will be changed. Are you sure that you want to proceed ?',
                                            onConfirm: function () {
                                                $(el.currentTarget).parents('.question').find('.previous_sync_field').val(sync_field);

                                                // replace question data type
                                                $(el.currentTarget).parents('.question').find('.datatype-textbox').val(data['correct_data_type']).attr('disabled', true);
                                                self.show_advance_input($(el.currentTarget).parents('.question').find('.datatype-textbox'));
                                            },
                                            onCancel: function () {

                                                app.alert.dismiss('change_data_type_confirmation');
                                                // unset piping sync field
                                                if ($(el.currentTarget).parents('.question').find('.previous_sync_field').val())
                                                {
                                                    var prev_value = $(el.currentTarget).parents('.question').find('.previous_sync_field').val();
                                                } else {
                                                    var prev_value = 'Select Field';
                                                }
                                                $(el.currentTarget).val(prev_value);
                                            }
                                        });
                                    }
                                    // quesytion is multi cho9ice so need to replace options
                                    else if (data['correct_que_type'] == 'dropdownlist' || data['correct_que_type'] == 'multiselectlist' || data['correct_que_type'] == 'radio-button') {
                                        var answer_detail = {};
                                        if (data['options'])
                                        {
                                            var count = 0;
                                            $.each(data['options'], function (key, option) {
                                                if (option)
                                                {
                                                    count++;
                                                    answer_detail['option_' + count] = option;
                                                }
                                            });
                                        }

                                        app.alert.show('PipingeditQue_confirmation', {
                                            level: 'confirmation',
                                            title: '',
                                            messages: 'By selecting this field question\'s options will be reset. Are you sure that you want to proceed ?',
                                            onConfirm: function () {
                                                self.confirmEditQueType(current_que_type, current_que_seq, data['correct_que_type'], question, is_required, helptips, display_boolean_label, question_id, answer_detail, [], sync_module, sync_field);
                                                self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('.previous_sync_field').val(sync_field);
                                                if (data['correct_que_type'] == 'date-time')
                                                {
                                                    if (data['is_datetime'] == true)
                                                    {
                                                        self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('[name=is_datetime_date-time_' + current_que_seq + ']').attr('checked', 'checked');
                                                    } else {
                                                        self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('[name=is_datetime_date-time_' + current_que_seq + ']').removeAttr('checked');
                                                    }
                                                    self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('[name=is_datetime_date-time_' + current_que_seq + ']').attr('disabled', true);
                                                }
                                                // replace question data type
                                                self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('.datatype-textbox').val(data['correct_data_type']).attr('disabled', true);
                                                self.show_advance_input($(el.currentTarget).parents('.question').find('.datatype-textbox'));
                                            },
                                            onCancel: function () {
                                                if ($(el.currentTarget).parents('.question').find('.previous_sync_field').val())
                                                {
                                                    var prev_value = $(el.currentTarget).parents('.question').find('.previous_sync_field').val();
                                                } else {
                                                    var prev_value = 'Select Field';
                                                }
                                                $(el.currentTarget).val(prev_value);
                                                app.alert.dismiss('PipingeditQue_confirmation');
                                            },
                                            autoClose: false
                                        });
                                    } else {
                                        if (data['correct_que_type'] == 'date-time')
                                        {
                                            if (data['is_datetime'] == true)
                                            {
                                                self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('[name=is_datetime_date-time_' + current_que_seq + ']').attr('checked', 'checked');
                                            } else {
                                                self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('[name=is_datetime_date-time_' + current_que_seq + ']').removeAttr('checked');
                                            }
                                            self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('[name=is_datetime_date-time_' + current_que_seq + ']').attr('disabled', true);
                                        }
                                        $(el.currentTarget).parents('.question').find('.previous_sync_field').val(sync_field);
                                    }
                                }
                                // If Question type does not match
                                else {
                                    var answer_detail = {};
                                    if (data['options'])
                                    {
                                        var count = 0;
                                        $.each(data['options'], function (key, option) {
                                            if (option)
                                            {
                                                count++;
                                                answer_detail['option_' + count] = option;
                                            }
                                        });
                                    }

                                    app.alert.show('PipingeditQue_confirmation', {
                                        level: 'confirmation',
                                        title: '',
                                        messages: 'By selecting this field question type will be changed and advance options fields will be reset. Are you sure that you want to proceed ?',
                                        onConfirm: function () {
                                            self.confirmEditQueType(current_que_type, current_que_seq, data['correct_que_type'], question, is_required, helptips, display_boolean_label, question_id, answer_detail, [], sync_module, sync_field);
                                            self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('.previous_sync_field').val(sync_field);
                                            if (data['correct_que_type'] == 'date-time')
                                            {
                                                if (data['is_datetime'] == true)
                                                {
                                                    self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('[name=is_datetime_date-time_' + current_que_seq + ']').attr('checked', 'checked');
                                                } else {
                                                    self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('[name=is_datetime_date-time_' + current_que_seq + ']').removeAttr('checked');
                                                }
                                                self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('[name=is_datetime_date-time_' + current_que_seq + ']').attr('disabled', true);
                                            }
                                            // replace question data type
                                            self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('.datatype-textbox').val(data['correct_data_type']).attr('disabled', true);
                                            self.show_advance_input($(el.currentTarget).parents('.question').find('.datatype-textbox'));
                                        },
                                        onCancel: function () {
                                            if ($(el.currentTarget).parents('.question').find('.previous_sync_field').val())
                                            {
                                                var prev_value = $(el.currentTarget).parents('.question').find('.previous_sync_field').val();
                                            } else {
                                                var prev_value = 'Select Field';
                                            }
                                            $(el.currentTarget).val(prev_value);
                                            app.alert.dismiss('PipingeditQue_confirmation');
                                        },
                                        autoClose: false
                                    });
                                }
                            }

                        }
                    });
                } else {
                    self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('[name=option_' + current_que_seq + ']').attr('disabled', false);
                    self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('.' + current_que_seq + '_add_option').show();
                    self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('.' + current_que_seq + '_remove_option').show();
                    self.$el.parents('.main-pane').find('.que_' + current_que_seq).find('[name=is_datetime_date-time_' + current_que_seq + ']').attr('disabled', false);
                }
            }
        }
    },
    reset_sync_field: function (el) {

        var self = this;
        app.alert.show('change_sync_module_confirmation', {
            level: 'confirmation',
            title: '',
            messages: 'By selecting this Sync Module existing question\'s sync field will be reset. Are you sure that you want to proceed ?',
            onConfirm: function () {
                $.each($(el.currentTarget).parents('.main-pane').find('.question'), function () {

                    if ($(this).find('.sync_field_selection').val() && $(this).find('.sync_field_selection').val() != 'Select Field') {
                        var current_que_detail = $(this).attr('id').split('_');
                        var muti_choice_que_type = current_que_detail[0];
                        var current_que_seq = current_que_detail[1];
                        if (muti_choice_que_type != 'boolean')
                        {
                            var data = '';
                            data += "               <div class='options' id='option_0'>";
                            data += "                 <input type='text' name='option_" + muti_choice_que_type + "' placeholder='Option' class='inherit-width' style='max-width:50%;'>";
                            data += "                 <input type='number' name='score_" + muti_choice_que_type + "'  value='1' class='inherit-width score_weight' style='max-width:7%; display:none;'>";
                            data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_remove_option que_" + current_que_seq + "' id='0' style='display:none;margin-left:2px; margin-top:5px;'><i class='fa fa-times'></i></a>";
                            data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_add_option que_" + current_que_seq + "' style='display:none;' id='0'><i class='fa fa-plus' ></i></a>";
                            data += "               </div>";
                            data += "               <div class='options' id='option_1'>";
                            data += "                 <input type='text' name='option_" + muti_choice_que_type + "' placeholder='Option' class='inherit-width' style='max-width:50%;margin-top:5px;'>";
                            data += "                 <input type='number' name='score_" + muti_choice_que_type + "' value='2' class='inherit-width score_weight' style='max-width:7%; margin-top:5px;display:none;'>";
                            data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_remove_option que_" + current_que_seq + "' id='1' style='display:none;margin-left:2px; margin-top:5px;'><i class='fa fa-times'></i></a>";
                            data += "                 <a href='javascript:void(0);' class='btn  " + muti_choice_que_type + "_add_option que_" + current_que_seq + "' style='margin-left:2px; margin-top:5px;' id='1'><i class='fa fa-plus' ></i></a>";
                            data += "               </div>";
                            self.$el.parents('.main-pane').find('#' + muti_choice_que_type + '_options_div_' + current_que_seq).html(data);
                        }
                        $(this).find('.sync_field_selection').val('Select Field');
                    }
                });
                $(el.currentTarget).parents('.main-pane').find('[name=sync_module]').parent().find('#recent_sync_module').val(self.$el.parents('.main-pane').find('[name="sync_module"]').val());
                var sync_field_options = '<option>Select Field</option>';
                var sync_field_based_on_queType = self.sync_module_fields;

                $.each(sync_field_based_on_queType[self.$el.parents('.main-pane').find('[name="sync_module"]').val()], function (key, field) {
                    // Piping tab contents
                    sync_field_options += "        <option value='" + key + "' >" + field + "</option>";
                });
                $(el.currentTarget).parents('.main-pane').find('.sync_field_selection:not(.boolean_sync_field)').html(sync_field_options);
                var sync_field_options = '<option>Select Field</option>';

                var sync_field_based_on_queType = self.sync_module_fields_for_boolean;

                if (typeof sync_field_based_on_queType[self.$el.parents('.main-pane').find('[name="sync_module"]').val()] != "undefined")
                {
                    $.each(sync_field_based_on_queType[self.$el.parents('.main-pane').find('[name="sync_module"]').val()], function (key, field) {
                        // Piping tab contents
                        sync_field_options += "        <option value='" + key + "' >" + field + "</option>";
                    });
                    $(el.currentTarget).parents('.main-pane').find('.boolean_sync_field').html(sync_field_options).show();
                    $(el.currentTarget).parents('.main-pane').find('.boolean_sync_field').parent().find('.no_data').remove();
                } else {
                    if ($(el.currentTarget).parents('.main-pane').find('.boolean_sync_field').parent().find('.no_data').length == 0)
                    {
                        $(el.currentTarget).parents('.main-pane').find('.boolean_sync_field').parent().append('<span class="no_data" style="color:red;"><i class="fa fa-exclamation-circle" style="color:red;"></i>&nbsp;There are no Fields to Sync with Boolean Data Type.</span>');
                    } else {
                        $(el.currentTarget).parents('.main-pane').find('.boolean_sync_field').parent().find('.no_data').show();
                    }
                    $(el.currentTarget).parents('.main-pane').find('.boolean_sync_field').html(sync_field_options).hide();
                    $(el.currentTarget).parents('.main-pane').find('.boolean_sync_field').parents('.question').find('.disable_piping_question').attr('checked', 'checked');
                    $(el.currentTarget).parents('.main-pane').find('.boolean_sync_field').parents('.question').find('.sync_field').hide();
                }
            },
            onCancel: function () {
                app.alert.dismiss('change_sync_module_confirmation');
                // reset piping sync module
                $(el.currentTarget).parents('.main-pane').find('[name="sync_module"]').val(self.$el.parents('.main-pane').find('[name=sync_module]').parent().find('#recent_sync_module').val());
                $(el.currentTarget).parents('.main-pane').find('[data-name="sync_module"]').find('.select2-chosen').html(self.$el.parents('.main-pane').find('[name=sync_module]').parent().find('#recent_sync_module').val());
            },
            autoClose: false
        });
    },
    /**
     * show date picker when focus on date field
     * 
     * @el current element
     */
    show_datepicker: function (el) {
        var self = this;
        var options = {
            dateFormat: app.user.getPreference('datepref'),
            inline: true,
        };
        $(el.currentTarget).datepicker(options).datepicker("show");
        self.$el.parents('.main-pane').find('.main-pane, .flex-list-view-content').on('scroll.' + this.cid, _.bind(function () {
            // make sure the dom element exists before trying to place the datepicker
            if (this._getAppendToTarget()) {
                $(el.currentTarget).datepicker('place');
            }
        }, this));

        $('.main-pane').scroll(function () {
            // make sure the dom element exists before trying to place the datepicker
            if (self._getAppendToTarget()) {
                $('.datepicker').datepicker('place');
            }
        });
    },
    /**
     * Retrieve an element against which the date picker should be appended to.
     *
     * FIXME: find a proper way to do this and avoid scrolling issues SC-2739
     *
     * @return {jQuery/undefined} Element against which the date picker should
     *   be appended to, `undefined` if none.
     * @private
     */
    _getAppendToTarget: function () {
        var component = this.closestComponent('main-pane') ||
                this.closestComponent('drawer');
        if (component) {
            return component.$el;
        }

        return;
    },
    /**
     * show image upload inpit field
     * 
     * @el current element
     */
    show_ImageUploadType: function (el) {

        if (el.currentTarget.classList.contains("uploadsImage") == true)
        {
            $(el.currentTarget).parents('.general_options').find('.uploadSurveyImage').show();
            $(el.currentTarget).parents('.general_options').find('.SurveyImageurl').hide();
            if ($(el.currentTarget).parents('.general_options').find('.uploadedImage').attr('src'))
            {
                $(el.currentTarget).parents('.general_options').find('.uploadedImage').show();
            }
            $(el.currentTarget).parents('.general_options').find('.changeImageUploaded').show();
            $(el.currentTarget).parents('.general_options').find('.SurveyImageurl').parent().removeClass('error-custom').find('span').attr('style', 'display:none;');
        } else if (el.currentTarget.classList.contains("imageURL") == true) {
            $(el.currentTarget).parents('.general_options').find('.image-error-msg').remove();
            $(el.currentTarget).parents('.general_options').find('.SurveyImageurl').show();
            $(el.currentTarget).parents('.general_options').find('.uploadSurveyImage').hide();
            $(el.currentTarget).parents('.general_options').find('.uploadedImage').hide();
            $(el.currentTarget).parents('.general_options').find('.changeImageUploaded').hide();
            $(el.currentTarget).parents('.general_options').find('.uploadSurveyImage').parent().removeClass('error-custom').find('span').attr('style', 'display:none;');
        }
    },
    /**
     * show question dropdown list
     * 
     * @el current element
     */
    showQueDropdown: function (el) {

        var questions = new Array();
        var que_detail = $(el.currentTarget).parents('.question').attr('id').split('_');
        questions['que_type'] = que_detail[0];
        var question_sequence = que_detail[1];
        var data = this.dropDownEditQueType(questions, question_sequence);
        $(el.currentTarget).parent().html(data);
    },
    /**
     * dropdown selction list
     * 
     * @el current element
     */
    dropDownEditQueType: function (questions, question_sequence) {
        var survey_data = '';
        // set question type icons for each question dropdown to edit que type
        survey_data += '<select class="edit_que-type" id="edit_que_type_' + questions['que_type'] + '_' + question_sequence + '" style="font-family: \'FontAwesome\', Helvetica; ">';

        survey_data += '   <option value="check-box" ';
        if (questions['que_type'] == "check-box") {
            survey_data += 'selected';
        }
        survey_data += '>CheckBox</option>';

        survey_data += '   <option value="dropdownlist" ';
        if (questions['que_type'] == "dropdownlist") {
            survey_data += 'selected';
        }
        survey_data += '>Dropdown List</option>';

        survey_data += '   <option value="radio-button" ';
        if (questions['que_type'] == "radio-button") {
            survey_data += 'selected';
        }
        survey_data += '>Radio Button</option>';
        survey_data += '   <option value="multiselectlist" ';
        if (questions['que_type'] == "multiselectlist") {
            survey_data += 'selected';
        }
        survey_data += '>MultiSelect List</option>';
        survey_data += '   <option value="boolean" ';
        if (questions['que_type'] == "boolean") {
            survey_data += 'selected';
        }
        survey_data += '>Boolean</option>';
        survey_data += '   <option value="matrix" ';
        if (questions['que_type'] == "matrix") {
            survey_data += 'selected';
        }
        survey_data += '>Matrix </i></option>';

        survey_data += '   <option value="textbox" ';
        if (questions['que_type'] == "textbox") {
            survey_data += 'selected';
        }
        survey_data += '>TextBox</option>';
        survey_data += '   <option value="commentbox" ';
        if (questions['que_type'] == "commentbox") {
            survey_data += 'selected';
        }
        survey_data += '>Comment TextBox</option>';
        survey_data += '   <option value="richtextareabox" ';
        if (questions['que_type'] == "richtextareabox") {
            survey_data += 'selected';
        }
        survey_data += '>Rich TextBox</option>';
        survey_data += '   <option value="scale" ';
        if (questions['que_type'] == "scale") {
            survey_data += 'selected';
        }
        survey_data += '>Scale </i></option>';
        survey_data += '   <option value="rating" ';
        if (questions['que_type'] == "rating") {
            survey_data += 'selected';
        }
        survey_data += '>Rating </i></option>';
        survey_data += '   <option value="image" ';
        if (questions['que_type'] == "image") {
            survey_data += 'selected';
        }
        survey_data += '>Image </i></option>';
        survey_data += '   <option value="video" ';
        if (questions['que_type'] == "video") {
            survey_data += 'selected';
        }
        survey_data += '>Video </i></option>';
        survey_data += '   <option value="date-time" ';
        if (questions['que_type'] == "date-time") {
            survey_data += 'selected';
        }
        survey_data += '>DateTime </i></option>';
        survey_data += '   <option value="contact-information" ';
        if (questions['que_type'] == "contact-information") {
            survey_data += 'selected';
        }
        survey_data += '>Contact Information</option>';
        survey_data += '   <option value="doc-attachment" ';
        if (questions['que_type'] == "doc-attachment") {
            survey_data += 'selected';
        }
        survey_data += '>Attachment </i></option>';
        survey_data += '   <option value="netpromoterscore" ';
        if (questions['que_type'] == "netpromoterscore") {
            survey_data += 'selected';
        }
        survey_data += '>NPS </i></option>';
        survey_data += '   <option value="emojis" ';
        if (questions['que_type'] == "emojis") {
            survey_data += 'selected';
        }
        survey_data += '>Emojis </i></option>';
        survey_data += '</select>';
        return survey_data;
    },
    /**
     * collapse page
     * 
     * @el current element
     */
    collapsePage: function (el) {
        var id = el.currentTarget.id;
        this.$el.parents('.main-pane').find('#' + id + '.dropdown-toggle').parents('#page_' + id).find('#data-page_' + id).slideToggle();
        var childId = id - 1;
        var flag = 0;
        var icon_class_name = this.$el.parents('.main-pane').find('#' + id).parents('.thumbnail').find('.page_toggle').children()[0].className;
        if (icon_class_name == 'fa fa-chevron-down') {
            flag = 1;
        } else if (icon_class_name == 'fa fa-chevron-up') {
            flag = 0;
        }
        if (flag == 0) {
            this.$el.parents('.main-pane').find('#' + id + '.dropdown-toggle').parents('#page_' + id).find('.page_toggle').children()[0].className = "fa fa-chevron-down";
        } else {
            this.$el.parents('.main-pane').find('#' + id + '.dropdown-toggle').parents('#page_' + id).find('.page_toggle').children()[0].className = "fa fa-chevron-up";
        }
    },
    /**
     * validate numeric values
     * 
     * @e current element
     */
    validateNumbericValue: function (e) {

        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && e.which != 45 && (e.which < 48 || e.which > 57)) {
            //display error message
            app.alert.show('info', {
                level: 'info',
                messages: 'Please enter only numeric values(0-9)',
                autoClose: true
            });
            return false;
        }

    },
    /**
     * validate decimal values
     * 
     * @e current element
     */
    validateDecimalValue: function (e) {

        //if dot already not entered
        var dot_flag = $(e.currentTarget).val().includes('.');
        //if the letter is not digit then display error and don't type anything
        if ((e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) || (dot_flag && e.which == 46)) {
            //display error message
            app.alert.show('info', {
                level: 'info',
                messages: 'Please enter only numeric values(0-9) and only 1 dot(.)',
                autoClose: true
            });
            return false;
        }

    },
    /**
     * validate alphabetic values
     * 
     * @e current element
     */
    validateAlphabeticValue: function (e) {

        //if the letter is not digit then display error and don't type anything
        if (e.ctrlKey || e.altKey) {
            e.preventDefault();
        } else {
            var keyCode = e.which;
            if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32 && keyCode != 8)
            {
                return false;
            }
        }

    },
    /**
     * show upload image input
     * 
     * @el current element
     */
    showUploadImageInput: function (el) {
        $(el.currentTarget).parents('.question').find('.uploadSurveyImage').show();
        $(el.currentTarget).hide();
    },
    /**
     * handle uploaded image validation & retrieve content to global variable
     * 
     * @evt current element
     */
    handleFileSelect: function (evt) {

        var files = evt.target.files; // FileList object
        var self = this;
        var parent = $(evt.currentTarget).parents('.question');
        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; f = files[i]; i++) {

            // Only process image files.
            if (!f.type.match('image.*')) {
                self.image_content = '';
                parent.find('.uploadSurveyImage').addClass('error-custom');
                if (parent.find('.uploadSurveyImage').parent().find('.image-error-msg').length == 0)
                {
                    parent.find('.uploadSurveyImage').parent().append('<p class="image-error-msg" style="color:red; font-size:11px;">Error. Please upload only jpeg,png or gif image type.</p>');
                }
                continue;
            } else if (f.size > 500000) {
                self.image_content = '';
                parent.find('.uploadSurveyImage').addClass('error-custom');
                if (parent.find('.uploadSurveyImage').parent().find('.image-error-msg').length == 0)
                {
                    parent.find('.uploadSurveyImage').parent().append('<p class="image-error-msg" style="color:red; font-size:11px;">Error. Please upload file upto size 500 KB');
                }
                continue;
            } else {
                parent.find('.uploadSurveyImage').removeClass('error-custom');
                parent.find('.uploadSurveyImage').parent().find('.image-error-msg').remove();
            }

            var reader = new FileReader();
            // Closure to capture the file information.
            reader.onload = (function (theFile) {
                return function (e) {
                    // Render thumbnail.
                    var span = document.createElement('span');
                    span.innerHTML = ['<img class="thumb" src="', e.target.result,
                        '" title="', escape(theFile.name), '" height="30px" width="30px"/>'].join('');
                    parent.find('.uploadedImage').attr('src', e.target.result).show();
                    // set image content to global variable to get it later
                    var qid = $(parent).attr('id').split('_')[1];
                    var image_data = new Object();
                    image_data[qid] = e.target.result;
                    if (theFile.type == 'image/png' || theFile.type == 'image/jpeg' || theFile.type == 'image/gif')
                    {
                        self.image_content = image_data;
                    } else {
                        self.image_content = '';
                        //parent.find('.uploadSurveyImage').parent().append('<p style="color:red; font-size:11px;">Error. Please upload only jpeg,png or gif image type.</p>')
                    }
                };
            })(f);
            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
    },
    /**
     * Radio Upload selected then validate the uploaded file and store its content in variable
     * 
     * @evt current element
     */
    handleFileSelectRadioUpload: function (evt) {

        var files = evt.target.files; // FileList object
        var self = this;
        var parent = $(evt.currentTarget).parents('.question');
        var currentFileUpload = $(evt.currentTarget);
        var answer_id = $(evt.currentTarget).parents('.options').find('input[type=text]').attr('id') != '' ? $(evt.currentTarget).parents('.options').find('input[type=text]').attr('id') : '';
        var option_seq = $(evt.currentTarget).parents('.options').attr('id').split('option_')[1];

        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; f = files[i]; i++) {

            // Only process image files.
            if (!f.type.match('image.*')) {
                self.image_content = '';
                currentFileUpload.parent().find('.spanRadioUploadError').addClass('error-custom').show();

                currentFileUpload.parent().find('.spanRadioUploadError').find('i').attr('title', 'Error. Please upload only jpeg,png or gif image type.');

                continue;
            } else if (f.size > 500000) {
                self.image_content = '';
                currentFileUpload.parent().find('.spanRadioUploadError').addClass('error-custom').show();

                currentFileUpload.parent().find('.spanRadioUploadError').find('i').attr('title', 'Error. Please upload file upto size 500 KB.');

                continue;
            } else {
                currentFileUpload.parent().find('.spanRadioUploadError').removeClass('error-custom');
                currentFileUpload.parent().find('.spanRadioUploadError').hide();
            }

            var reader = new FileReader();
            // Closure to capture the file information.
            reader.onload = (function (theFile) {
                return function (e) {

                    // set image content to global variable to get it later

                    var qid = $(parent).attr('id').split('_')[1];
                    if (typeof answer_id != 'undefined' && answer_id != '') {
                        option_seq = answer_id;
                    }

                    var image_data = new Object();
                    if (typeof self.radio_image_content !== 'object') {
                        self.radio_image_content = new Object();
                    }
                    if (self.radio_image_content && !self.radio_image_content[qid]) {
                        image_data[qid] = new Object();
                        self.radio_image_content[qid] = new Object();
                    } else if (self.radio_image_content && self.radio_image_content[qid]) {
                        image_data[qid] = self.radio_image_content[qid];
                    } else {
                        image_data[qid] = new Object();
                    }
                    image_data[qid][option_seq] = e.target.result;
                    if (theFile.type == 'image/png' || theFile.type == 'image/jpeg' || theFile.type == 'image/gif')
                    {
                        self.radio_image_content[qid] = image_data[qid];
                    }
                    // store image in web for savinf purpose
                    if (currentFileUpload.parent().find('.spanRadioUploadError').find('.uploadedImage').length == 0) {
                        currentFileUpload.parent().find('.spanRadioUploadError').append('<input class="uploadedImage" type="hidden" src="' + e.target.result + '" /> ');
                    } else {
                        currentFileUpload.parent().find('.spanRadioUploadError').find('.uploadedImage').attr('src', e.target.result);
                    }
                };
            })(f);
            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
    },
    /*
     * set 0 weight if null
     * 
     */
    setDefaultWeight: function (el) {

        var weight = $(el.currentTarget).val();
        if (!weight)
        {
            $(el.currentTarget).val('0');
        }
    },
    /*
     * set Other option label if null
     * 
     */
    setDefaultOtherLabel: function (el) {

        var label = $(el.currentTarget).val();
        if (!label)
        {
            $(el.currentTarget).val('Other');
        }
    },
    /**
     * Called when formatting the value for display
     * @param value
     */
    format: function (value) {
        return this._super('format', [value]);
    },
    /**
     * Called when unformatting the value for storage
     * @param value
     */
    unformat: function (value) {
        return this._super('unformat', [value]);
    },
})
