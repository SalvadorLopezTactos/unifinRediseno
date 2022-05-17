({
    /**
     * The file used to handle translate survey view 
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */

    className: 'translate-survey-view',
    fieldSelector: '.htmleditable',
    _htmleditor: null,
    _isDirty: false,
    _saveOnSetContent: true,
    initialize: function (options) {
        //  
        this._super('initialize', [options]);
        // available languages
        var available_language = app.lang.getAppListStrings('available_language_dom');
        this.available_language = available_language;
        // survey language status list
        var availability_status_list = app.lang.getAppListStrings('availability_status_list');
        this.availability_status_list = availability_status_list;
        // survey language text direction list
        var text_direction_list = app.lang.getAppListStrings('text_direction_list');
        this.text_direction_list = text_direction_list;
        var self = this;
        // call api to save record via php
        var url = App.api.buildURL("bc_survey", "get_survey_language", "", {survey_id: this.model.get('id')});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data)
                {
                    self.survey_title = data['survey_title'];
                    self.survey_id = self.model.get('id');

                    self.survey_type = data['survey_type'];
                    self._render();
                }
            }
        });
    },
    /*
     * events performed by translate survey page
     */
    events: {
        'click .survey_language_tab': 'survey_language_tab_clicked',
        'click .add_language': 'add_language_clicked',
        'click .add-translation': 'translate_survey_lang_clicked',
        'click .remove-lang': 'remove_lang_clicked',
        'click #save_lang': 'save_lang_clicked',
        'click #save_translate': 'save_translate_clicked',
        'click #move_to_component,.survey_component_tab ': 'survey_component_tab_clicked',
        'click #move_to_msg,.survey_msg_tab ': 'survey_msg_tab_clicked',
        'click #move_to_advance,.survey_advance_content_tab': 'survey_advance_content_tab_clicked',
        'click .edit-language': 'edit_language_clicked',
        'click .load_default_survey_data': 'load_default_survey_data_clicked',
        'click .copy_welcome,.copy_thanks,.copy_review': 'copy_from_dafaultEditor'
    },
    /*
     * to render view
     * @param {type} options
     * @returns {undefined}
     */
    _render: function (options) {

        this._super('_render', [options]);

        $('#survey_welcome_page').tinymce({
            // Location of TinyMCE script
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
            width: "100%"
        });

        $('#survey_thanks_page').tinymce({
            // Location of TinyMCE script
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
            width: "100%"
        });

        $('#review_mail_content').tinymce({
            // Location of TinyMCE script
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
            width: "100%"
        });

        var self = this;
        var selected_lang = '';
        this.survey_id = self.model.get('id');
        // selected language from clicking button of trnaslate survey 
        if (self.selected_lang)
        {
            selected_lang = self.selected_lang;

        }
        // selected language by adding new language then redirect to translate page
        else if (self.recentAddedLanguage)
        {
            selected_lang = self.recentAddedLanguage;
        }
        // If selected language exists then create html for translation view in selected language
        if (selected_lang) {
            // Enable translate tab
            this.translate_survey_tab_clicked();

            // display selected language label
            $('#lang_id').val(self.lang_id);
            $('#trans_lang').html(self.available_language[selected_lang]);

            // Get Survey Details in selected language
            var url = App.api.buildURL("bc_survey", "get_survey_detail_to_translate_lang", "", {record_id: this.model.get('id'), selected_lang: selected_lang});
            App.api.call('GET', url, {}, {
                success: function (data) {
                    var list_survey_detail = '';
                    var survey_dataObj = $.parseJSON(data);
                    var survey_data = survey_dataObj['survey_detail'];
                    var survey_lang_data = survey_dataObj['survey_lang_detail'];
                    if (self.allow_copy == 1)
                    {
                        var allow_copy = true; // allow copy data from default survey
                    } else {
                        var allow_copy = false; // dont allow to copy from default survey
                    }
                    // Set survey title
                    if (survey_data['survey_title'])
                    {
                        var survey_title = '';
                        if (allow_copy) {
                            survey_title = survey_data['survey_title'];
                        } else if (survey_lang_data) {
                            survey_title = survey_lang_data[survey_data['survey_id'] + '_survey_title'];
                            if (!survey_title) {
                                survey_title = survey_data['survey_title'];
                            }
                        }
                        list_survey_detail += "        <tr class='survey_tr' save_id='" + survey_data['survey_id'] + "' survey_id='" + survey_data['survey_id'] + "'>";
                        list_survey_detail += "            <td class='highlidht_field'>Survey Title</td>";
                        list_survey_detail += "            <td>" + survey_data['survey_title'] + "</td>";
                        list_survey_detail += "            <td><input type='text' class='survey_title' value='" + survey_title + "'/></td>";
                        list_survey_detail += "        </tr>";

                    }
                    // Survey Description
                    if (survey_data['survey_description'])
                    {
                        var survey_desc = '';
                        if (allow_copy) {
                            survey_desc = survey_data['survey_description'];
                        } else if (survey_lang_data) {
                            survey_desc = survey_lang_data[survey_data['survey_id'] + '_survey_description'];
                            if (!survey_desc) {
                                survey_desc = survey_data['survey_description'];
                            }
                        }
                        list_survey_detail += "        <tr class='survey_tr' save_id='" + survey_data['survey_id'] + "' survey_id='" + survey_data['survey_id'] + "'>";
                        list_survey_detail += "            <td class='highlidht_field'>Survey Description</td>";
                        list_survey_detail += "            <td>" + survey_data['survey_description'] + "</td>";
                        list_survey_detail += "            <td><input type='text' class='survey_description' value='" + survey_desc + "'/></td>";
                        list_survey_detail += "        </tr>";

                    }
                    list_survey_detail += "        <tr class=''>";
                    list_survey_detail += "            <td colspan='4'></td>";
                    list_survey_detail += "        </tr>";

                    //Survye Pages
                    if (survey_data['pages'])
                    {
                        $.each(survey_data['pages'], function (page_key, page_detail) {
                            // Page Title
                            if (page_detail['page_title'])
                            {
                                var page_title = '';
                                if (allow_copy) {
                                    page_title = page_detail['page_title'];
                                } else if (survey_lang_data) {
                                    page_title = survey_lang_data[page_detail['page_id']];
                                    if (!page_title) {
                                        page_title = page_detail['page_title'];
                                    }
                                }
                                list_survey_detail += "        <tr class='page_title_tr' save_id='" + page_detail['page_id'] + "' page_id='" + page_detail['page_id'] + "'>";
                                list_survey_detail += "            <td class='highlidht_field'>Page Title</td>";
                                list_survey_detail += "            <td>" + page_detail['page_title'] + "</td>";
                                list_survey_detail += "            <td><input type='text' class='page_title' value='" + page_title + "'/></td>";
                                list_survey_detail += "        </tr>";

                            }
                            // Survey Questions
                            if (page_detail['page_questions'])
                            {
                                var que_seq = 0;
                                $.each(page_detail['page_questions'], function (question_key, question_detail) {
                                    // Check Question Section Header or Question
                                    if (question_detail['que_type'] != 'section-header')
                                    {
                                        // Question Title
                                        if (question_detail['que_title'] && question_detail['que_type'] != 'image' && question_detail['que_type'] != 'video')
                                        {
                                            var que_title = '';
                                            if (allow_copy) {
                                                que_title = question_detail['que_title'];
                                            } else if (survey_lang_data) {
                                                que_title = survey_lang_data[question_detail['que_id'] + '_que_title'];
                                                if (!que_title) {
                                                    que_title = question_detail['que_title'];
                                                }
                                            }
                                            que_seq++;
                                            list_survey_detail += "        <tr class='question_detail_tr' save_id='" + question_detail['que_id'] + "' que_id='" + question_detail['que_id'] + "'>";
                                            list_survey_detail += "            <td class='highlidht_field'>Question " + que_seq + " (" + question_detail['que_type'] + ")</td>";
                                            list_survey_detail += "            <td>" + question_detail['que_title'] + "</td>";
                                            list_survey_detail += "            <td><input type='text' class='que_title' value='" + que_title + "'/></td>";
                                            list_survey_detail += "        </tr>";

                                        }
                                        // Question Help Text
                                        if (question_detail['question_help_comment'])
                                        {
                                            var help_label = 'Help Text';
                                            var question_help_comment = '';
                                            if (allow_copy) {
                                                question_help_comment = question_detail['question_help_comment'];
                                            } else if (survey_lang_data) {
                                                question_help_comment = survey_lang_data[question_detail['que_id'] + '_question_help_comment'];
                                                if (!question_help_comment) {
                                                    question_help_comment = question_detail['question_help_comment'];
                                                }
                                            }
                                            if (question_detail['que_type'] == 'image' || question_detail['que_type'] == 'video')
                                            {
                                                help_label = 'Title';
                                                list_survey_detail += "        <tr class='question_detail_tr' save_id='" + question_detail['que_id'] + "' que_id='" + question_detail['que_id'] + "'>";
                                                list_survey_detail += "            <td colspan='3' class='highlidht_field'> (" + question_detail['que_type'] + ")</td>";
                                                list_survey_detail += "        </tr>";
                                            }
                                            list_survey_detail += "        <tr class='question_detail_tr' save_id='" + question_detail['que_id'] + "' que_id='" + question_detail['que_id'] + "'>";
                                            list_survey_detail += "            <td class='highlidht_field'>" + help_label + "</td>";
                                            list_survey_detail += "            <td>" + question_detail['question_help_comment'] + "</td>";
                                            list_survey_detail += "            <td><input type='text' class='question_help_comment' value='" + question_help_comment + "'/></td>";
                                            list_survey_detail += "        </tr>";

                                        }
                                        // Question Description
                                        if (question_detail['description'])
                                        {
                                            var description = '';
                                            if (allow_copy) {
                                                description = question_detail['description'];
                                            } else if (survey_lang_data) {
                                                description = survey_lang_data[question_detail['que_id'] + '_description'];
                                                if (!description) {
                                                    description = question_detail['description'];
                                                }
                                            }

                                            list_survey_detail += "        <tr class='question_detail_tr' save_id='" + question_detail['que_id'] + "' que_id='" + question_detail['que_id'] + "'>";
                                            list_survey_detail += "            <td class='highlidht_field'>Description</td>";
                                            list_survey_detail += "            <td>" + question_detail['description'] + "</td>";
                                            list_survey_detail += "            <td><input type='text' class='description' value='" + question_help_comment + "'/></td>";
                                            list_survey_detail += "        </tr>";

                                        }
                                        // Question Type scale - Display Labels
                                        if (question_detail['que_type'] == 'scale' && question_detail['advance_type'])
                                        {
                                            var labels_array = question_detail['advance_type'].split('-');
                                            var question_help_comment = '';
                                            if (survey_lang_data) {
                                                labels_array[0] = survey_lang_data[question_detail['que_id'] + '_display_label_left'];
                                                labels_array[1] = survey_lang_data[question_detail['que_id'] + '_display_label_middle'];
                                                labels_array[2] = survey_lang_data[question_detail['que_id'] + '_display_label_right'];
                                                if (!labels_array[0] || !labels_array[1] || !labels_array[2])
                                                {
                                                    var labels_array = question_detail['advance_type'].split('-');
                                                }
                                            } else if (!allow_copy) {
                                                labels_array[0] = '';
                                                labels_array[1] = '';
                                                labels_array[2] = '';
                                            }
                                            list_survey_detail += "        <tr class='question_detail_tr' save_id='" + question_detail['que_id'] + "' que_id='" + question_detail['que_id'] + "'>";
                                            list_survey_detail += "            <td class='highlidht_field'>Label</td>";
                                            list_survey_detail += "            <td>" + question_detail['advance_type'] + "</td>";
                                            list_survey_detail += "            <td><input type='text' class='display_label_left' style='width:10%;' value='" + labels_array[0] + "'/>&nbsp;-&nbsp;<input type='text' class='display_label_middle' style='width:10%;' value='" + labels_array[1] + "'/>&nbsp;-&nbsp;<input type='text' class='display_label_right' style='width:10%;' value='" + labels_array[2] + "'/></td>";
                                            list_survey_detail += "        </tr>";

                                        }
                                        // Question type Matrix - Matrix rows
                                        if (question_detail['que_type'] == 'matrix' && question_detail['matrix_row'])
                                        {
                                            var matrix_row_data = $.parseJSON(question_detail['matrix_row']);
                                            $.each(matrix_row_data, function (row_seq, row_data) {
                                                var row_data_value = '';
                                                if (allow_copy) {
                                                    row_data_value = row_data;
                                                } else if (survey_lang_data) {
                                                    row_data_value = survey_lang_data[question_detail['que_id'] + '_matrix_row' + row_seq];
                                                    if (!row_data_value) {
                                                        row_data_value = row_data;
                                                    }
                                                }
                                                list_survey_detail += "        <tr class='question_detail_tr' save_id='" + question_detail['que_id'] + "' que_id='" + question_detail['que_id'] + "'>";
                                                list_survey_detail += "            <td class='highlidht_field'>Row " + row_seq + "</td>";
                                                list_survey_detail += "            <td>" + row_data + "</td>";
                                                list_survey_detail += "            <td><input type='text' class='matrix_row" + row_seq + "'  value='" + row_data_value + "'/></td>";
                                                //       list_survey_detail += "            <td style='width:25%;text-align:center;'><a style='color:#555;'><i class='fa fa-pencil'>&nbsp;</i>Edit</a></td>";
                                                list_survey_detail += "        </tr>";
                                            });
                                        }
                                        // Question type Contact Information - placeholders
                                        if (question_detail['que_type'] == 'contact-information')
                                        {
                                            var placeholder_array = ['Name', 'Email Address', 'Company', 'Phone Number', 'Street1', 'Street2', 'City/Town', 'State/Province', 'ZIP/Postal Code', 'Country'];
                                            var placeholder_label = '';

                                            $.each(placeholder_array, function (key, value) {
                                                if (survey_lang_data) {
                                                    if (survey_lang_data[question_detail['que_id'] + '_placeholder_label_' + value])
                                                    {
                                                        placeholder_label = survey_lang_data[question_detail['que_id'] + '_placeholder_label_' + value];
                                                    } else {
                                                        placeholder_label = value;
                                                    }

                                                } else if (allow_copy) {
                                                    placeholder_label = value;
                                                }
                                                list_survey_detail += "        <tr class='question_detail_tr' save_id='" + question_detail['que_id'] + "' que_id='" + question_detail['que_id'] + "'>";
                                                list_survey_detail += "            <td class='highlidht_field'>Placeholder Label for " + value + "</td>";
                                                list_survey_detail += "            <td>" + value + "</td>";
                                                list_survey_detail += "            <td><input type='text' class='placeholder_label_" + value + "'  value='" + placeholder_label + "'/></td>";
                                                list_survey_detail += "        </tr>";
                                            });

                                        }
                                        // Question type Matrix - Matrix columns
                                        if (question_detail['que_type'] == 'matrix' && question_detail['matrix_col'])
                                        {
                                            var matrix_col_data = $.parseJSON(question_detail['matrix_col']);
                                            $.each(matrix_col_data, function (col_seq, col_data) {
                                                var col_data_value = '';
                                                if (allow_copy) {
                                                    col_data_value = col_data;
                                                } else if (survey_lang_data) {
                                                    col_data_value = survey_lang_data[question_detail['que_id'] + '_matrix_col' + col_seq];
                                                    if (!col_data_value) {
                                                        col_data_value = col_data;
                                                    }
                                                }
                                                list_survey_detail += "        <tr class='question_detail_tr' save_id='" + question_detail['que_id'] + "' que_id='" + question_detail['que_id'] + "'>";
                                                list_survey_detail += "            <td class='highlidht_field'>Column " + col_seq + "</td>";
                                                list_survey_detail += "            <td>" + col_data + "</td>";
                                                list_survey_detail += "            <td><input type='text' class='matrix_col" + col_seq + "'  value='" + col_data_value + "'/></td>";
                                                //       list_survey_detail += "            <td style='width:25%;text-align:center;'><a style='color:#555;'><i class='fa fa-pencil'>&nbsp;</i>Edit</a></td>";
                                                list_survey_detail += "        </tr>";
                                            });
                                        }
                                        // Options
                                        var option_seq = 0;
                                        if (question_detail['answers'])
                                        {
                                            $.each(question_detail['answers'], function (answer_seq, answer_detail_pre) {
                                                $.each(answer_detail_pre, function (answer_id, answer_detail) {
                                                    // option label
                                                    if (answer_detail['option'])
                                                    {
                                                        option_seq++;
                                                        var option = '';
                                                        if (allow_copy) {
                                                            option = answer_detail['option'];
                                                        } else if (survey_lang_data) {
                                                            option = survey_lang_data[answer_id];
                                                            if (!option) {
                                                                option = answer_detail['option'];
                                                            }
                                                        }
                                                        list_survey_detail += "        <tr class='answer_detail_tr' save_id='" + answer_id + "' ans_id='" + answer_id + "'>";
                                                        list_survey_detail += "            <td class='highlidht_field'>Option " + option_seq + "</td>";
                                                        list_survey_detail += "            <td>" + answer_detail['option'] + "</td>";
                                                        list_survey_detail += "            <td><input type='text' class='option' value='" + option + "'/></td>";
                                                        list_survey_detail += "        </tr>";

                                                    }
                                                    // other option label
                                                    if (answer_detail['answer_type'] == 'other')
                                                    {
                                                        var option = '';
                                                        if (allow_copy) {
                                                            option = 'Other';
                                                        } else if (survey_lang_data) {
                                                            option = survey_lang_data[answer_id + '_other_placeholder_label'];
                                                            if (!option) {
                                                                option = 'Other';
                                                            }
                                                        }
                                                        list_survey_detail += "        <tr class='question_detail_tr'  save_id='" + question_detail['que_id'] + "' >";
                                                        list_survey_detail += "            <td class='highlidht_field'>Placeholder Label for Other</td>";
                                                        list_survey_detail += "            <td>Other</td>";
                                                        list_survey_detail += "            <td><input type='text' class='other_placeholder_label' value='" + option + "'/></td>";
                                                        list_survey_detail += "        </tr>";
                                                    }
                                                });
                                            });
                                        }
                                    } else {
                                        // Question Section Header
                                        if (question_detail['que_title'])
                                        {
                                            var sec_title = '';
                                            if (allow_copy) {
                                                sec_title = question_detail['que_title'];
                                            } else if (survey_lang_data) {
                                                sec_title = survey_lang_data[question_detail['que_id']];
                                                if (!sec_title) {
                                                    sec_title = question_detail['que_title'];
                                                }
                                            }
                                            list_survey_detail += "        <tr class='section_detail_tr' save_id='" + question_detail['que_id'] + "' que_id='" + question_detail['que_id'] + "'>";
                                            list_survey_detail += "            <td class='highlidht_field'>Question Section Header</td>";
                                            list_survey_detail += "            <td>" + question_detail['que_title'] + "</td>";
                                            list_survey_detail += "            <td><input type='text' class='que_title' value='" + sec_title + "'/></td>";
                                            list_survey_detail += "        </tr>";

                                        }
                                    }

                                    list_survey_detail += "        <tr class=''>";
                                    list_survey_detail += "            <td colspan='4'></td>";
                                    list_survey_detail += "        </tr>";
                                });
                            }
                        });
                    }
                    $('.survey_component_list').html(list_survey_detail);

                    // If allow copy from default survey then prefill messages tab to translate survey
                    if (self.allow_copy) {
                        // button labels
                        $('.next_button').val('Next');
                        $('.prev_button').val('Prev');
                        $('.submit_button').val('Submit');
                        // validation messages
                        $('.required_msg').val('This question is mandatory, Please answer this question.');
                        $('.invalid_email_msg').val('Please enter correct Email Address.');
                        $('.invalid_phn_msg').val('Please enter proper Phone Number.');
                        $('.matrix_required_msg').val('This question require one answer per row.');
                        $('.sel_limit_msg').val('You must have to select atleast $min option(s).');
                        $('.limit_msg').val('Please enter Value between $min-$max.');
                        $('.limit_min_msg').val('Value can not be less then $min.');
                        $('.limit_max_msg').val('Value can not be more then $max.');
                        $('.limit_precision_msg').val('Please enter atleast $precision precision point.');
                        $('.max_msg').val('Maximum length $maxsize character.');
                        $('.range_msg').val('Date can be between $min to $max.');
                        $('.start_date_msg').val('Please enter date after $min.');
                        $('.end_date_msg').val('Please enter date before $max.');
                        // survey form messages
                        $('.success_submit_msg').val('Your ' + self.survey_type + '  has been submitted successfully and summary email send to your email address');
                        $('.email_success_submit_msg').val('Your ' + self.survey_type + '  has been submitted successfully');
                        $('.already_sub_msg').val('You have already submitted this Survey.');
                        $('.location_already_sub_msg').val('Response has been already submitted from the same location.');
                        $('.req_msg').val('For request to admin to resubmit your ' + self.survey_type + '  ');
                        $('.survey_notstart_msg').val('This ' + self.survey_type + '  has not started yet, Please try after $startDateTime');
                        $('.survey_exp_msg').val('Sorry... This ' + self.survey_type + '  expired on $endDateTime');
                        $('.survey_deleted_msg').val('Sorry! This ' + self.survey_type + '  has been deactivated by the owner. You can\'t attend it');
                        $('.rec_deleted_msg').val('Sorry! This recipient record is deleted by the owner. You can\'t attend it');
                        $('.resubmit_request_success_msg').val('Your request for re-submit ' + self.survey_type + '  response is submitted successfully. You will be sent a confirmation email once admin approves your request.Thanks.');
                        $('.resubmit_request_fail_msg').val('Your request for re-submit ' + self.survey_type + '  response is not submitted.');
                        $('.resubmit_request_already_sent_msg').val('You have already requested for re-submit ' + self.survey_type + '  response !');

                    }
                    // If already translated then prefill from language file
                    else if (survey_lang_data) {
                        // button labels
                        var next = (survey_lang_data['next_button']) ? survey_lang_data['next_button'] : 'Next';
                        $('.next_button').val(next);
                        var prev = (survey_lang_data['prev_button']) ? survey_lang_data['prev_button'] : 'Prev';
                        $('.prev_button').val(prev);
                        var submit = (survey_lang_data['submit_button']) ? survey_lang_data['submit_button'] : 'Submit';
                        $('.submit_button').val(submit);
                        // validation messages
                        var required_msg = (survey_lang_data['required_msg']) ? survey_lang_data['required_msg'] : 'This question is mandatory, Please answer this question.';
                        $('.required_msg').val(required_msg);
                        var invalid_email_msg = (survey_lang_data['invalid_email_msg']) ? survey_lang_data['invalid_email_msg'] : 'Please enter correct Email Address.';
                        $('.invalid_email_msg').val(invalid_email_msg);
                        var invalid_phn_msg = (survey_lang_data['invalid_phn_msg']) ? survey_lang_data['invalid_phn_msg'] : 'Please enter proper Phone Number.';
                        $('.invalid_phn_msg').val(invalid_phn_msg);
                        var matrix_required_msg = (survey_lang_data['matrix_required_msg']) ? survey_lang_data['matrix_required_msg'] : 'This question require one answer per row.';
                        $('.matrix_required_msg').val(matrix_required_msg);
                        var sel_limit_msg = (survey_lang_data['sel_limit_msg']) ? survey_lang_data['sel_limit_msg'] : 'You must have to select atleast $min option(s).';
                        $('.sel_limit_msg').val(sel_limit_msg);
                        var limit_msg = (survey_lang_data['limit_msg']) ? survey_lang_data['limit_msg'] : 'Please enter Value between $min-$max.';
                        $('.limit_msg').val(limit_msg);
                        var limit_min_msg = (survey_lang_data['limit_min_msg']) ? survey_lang_data['limit_min_msg'] : 'Value can not be less then $min.';
                        $('.limit_min_msg').val(limit_min_msg);
                        var limit_max_msg = (survey_lang_data['limit_max_msg']) ? survey_lang_data['limit_max_msg'] : 'Value can not be more then $max.';
                        $('.limit_max_msg').val(limit_max_msg);
                        var limit_precision_msg = (survey_lang_data['limit_precision_msg']) ? survey_lang_data['limit_precision_msg'] : 'Please enter atleast $precision precision point.';
                        $('.limit_precision_msg').val(limit_precision_msg);
                        var max_msg = (survey_lang_data['max_msg']) ? survey_lang_data['max_msg'] : 'Maximum length $maxsize character.';
                        $('.max_msg').val(max_msg);
                        var range_msg = (survey_lang_data['range_msg']) ? survey_lang_data['range_msg'] : 'Date can be between $min to $max.';
                        $('.range_msg').val(range_msg);
                        var start_date_msg = (survey_lang_data['start_date_msg']) ? survey_lang_data['start_date_msg'] : 'Please enter date after $min.';
                        $('.start_date_msg').val(start_date_msg);
                        var end_date_msg = (survey_lang_data['end_date_msg']) ? survey_lang_data['end_date_msg'] : 'Please enter date before $max.';
                        $('.end_date_msg').val(end_date_msg);
                        // survey form messages
                        var success_submit_msg = (survey_lang_data['success_submit_msg']) ? survey_lang_data['success_submit_msg'] : 'Your ' + self.survey_type + '  has been submitted successfully and summary email send to your email address';
                        $('.success_submit_msg').val(success_submit_msg);
                        var email_success_submit_msg = (survey_lang_data['email_success_submit_msg']) ? survey_lang_data['email_success_submit_msg'] : 'Your ' + self.survey_type + '  has been submitted successfully';
                        $('.email_success_submit_msg').val(email_success_submit_msg);
                        var already_sub_msg = (survey_lang_data['already_sub_msg']) ? survey_lang_data['already_sub_msg'] : 'You have already submitted this Survey. For request to admin to resubmit your ' + self.survey_type + ' ';
                        $('.already_sub_msg').val(already_sub_msg);
                        var location_already_sub_msg = (survey_lang_data['location_already_sub_msg']) ? survey_lang_data['location_already_sub_msg'] : 'Response has been already submitted from the same location.';
                        $('.location_already_sub_msg').val(location_already_sub_msg);
                        var req_msg = (survey_lang_data['req_msg']) ? survey_lang_data['req_msg'] : 'For request to admin to resubmit your ' + self.survey_type + ' ';
                        $('.req_msg').val(req_msg);
                        var survey_notstart_msg = (survey_lang_data['survey_notstart_msg']) ? survey_lang_data['survey_notstart_msg'] : 'This ' + self.survey_type + '  has not started yet, Please try after $startDateTime';
                        $('.survey_notstart_msg').val(survey_notstart_msg);
                        var survey_exp_msg = (survey_lang_data['survey_exp_msg']) ? survey_lang_data['survey_exp_msg'] : 'Sorry... This ' + self.survey_type + '  expired on $endDateTime';
                        $('.survey_exp_msg').val(survey_exp_msg);
                        var survey_deleted_msg = (survey_lang_data['survey_deleted_msg']) ? survey_lang_data['survey_deleted_msg'] : 'Sorry! This ' + self.survey_type + '  has been deactivated by the owner. You can\'t attend it.';
                        $('.survey_deleted_msg').val(survey_deleted_msg);
                        var rec_deleted_msg = (survey_lang_data['rec_deleted_msg']) ? survey_lang_data['rec_deleted_msg'] : 'Sorry! This recipient record is deleted by the owner. You can\'t attend it.';
                        $('.rec_deleted_msg').val(rec_deleted_msg);
                        var resubmit_request_success_msg = (survey_lang_data['resubmit_request_success_msg']) ? survey_lang_data['resubmit_request_success_msg'] : 'Your request for re-submit ' + self.survey_type + '  response is submitted successfully. You will be sent a confirmation email once admin approves your request.Thanks.';
                        $('.resubmit_request_success_msg').val(resubmit_request_success_msg);
                        var resubmit_request_fail_msg = (survey_lang_data['resubmit_request_fail_msg']) ? survey_lang_data['resubmit_request_fail_msg'] : 'Your request for re-submit ' + self.survey_type + '  response is not submitted.';
                        $('.resubmit_request_fail_msg').val(resubmit_request_fail_msg);
                        var resubmit_request_already_sent_msg = (survey_lang_data['resubmit_request_already_sent_msg']) ? survey_lang_data['resubmit_request_already_sent_msg'] : 'You have already requested for re-submit ' + self.survey_type + '  response !';
                        $('.resubmit_request_already_sent_msg').val(resubmit_request_already_sent_msg);
                    }

                    // Survey WELCOME Page
                    if (survey_lang_data && survey_lang_data['survey_welcome_page']) {
                        $('.welcome_default').html(survey_data['survey_welcome_page']).attr('style', 'max-height:440px; max-width:510px;  overflow-y:scroll;');
                        $('.welcome_editor').prepend('<div class="btn copy_welcome" style="margin-bottom: 3px;margin-left: 0px;">Copy from Default</div>');
                        $('.welcome_editor').show();
                        $('#survey_welcome_page').val(survey_lang_data['survey_welcome_page']);
                    }
                    else if (survey_data['survey_welcome_page'])
                    {
                        $('.welcome_default').html(survey_data['survey_welcome_page']).attr('style', 'max-height:440px;max-width:510px; overflow-y:scroll;');
                        $('.welcome_editor').prepend('<div class="btn copy_welcome" style="margin-bottom: 3px;margin-left: 0px;">Copy from Default</div>');
                        $('.welcome_editor').show();
                        if (self.allow_copy) {
                            $('#survey_welcome_page').val(survey_data['survey_welcome_page']);
                        }
                    } else {
                        $('.welcome_default').html('Not set');
                        $('.welcome_editor').html('-');
                    }

                    // Survey THANKS Page
                    if (survey_lang_data && survey_lang_data['survey_thanks_page']) {
                        $('.thanks_default').html(survey_data['survey_thanks_page']).attr('style', 'max-height:440px;max-width:510px; overflow-y:scroll;');
                        $('.thanks_editor').prepend('<div class="btn copy_thanks"  style="margin-bottom: 3px;margin-left: 0px;">Copy from Default</div>');
                        $('.thanks_editor').show();
                        $('#survey_thanks_page').val(survey_lang_data['survey_thanks_page']);
                    }
                    else if (survey_data['survey_thanks_page'])
                    {
                        $('.thanks_default').html(survey_data['survey_thanks_page']).attr('style', 'max-height:440px;max-width:510px; overflow-y:scroll;');
                        $('.thanks_editor').prepend('<div class="btn copy_thanks"  style="margin-bottom: 3px;margin-left: 0px;">Copy from Default</div>');
                        $('.thanks_editor').show();
                        if (self.allow_copy) {
                            $('#survey_thanks_page').val(survey_data['survey_thanks_page']);
                        }
                    } else {
                        $('.thanks_default').html('Not set');
                        $('.thanks_editor').html('-');
                    }

                    // Survey REVIEW MAIL CONTENT
                    if (survey_lang_data && survey_lang_data['review_mail_content']) {
                        $('.review_default').html(survey_data['review_mail_content']).attr('style', 'max-height:440px;max-width:510px; overflow-y:scroll;');
                        $('.review_editor').prepend('<div class="btn copy_review" style="margin-bottom: 3px;margin-left: 0px;">Copy from Default</div>');
                        $('.review_editor').show();
                        $('#review_mail_content').val(survey_lang_data['review_mail_content']);
                    }
                    else if (survey_data['review_mail_content'])
                    {
                        $('.review_default').html(survey_data['review_mail_content']).attr('style', 'max-height:440px; max-width:510px; overflow-y:scroll;');
                        $('.review_editor').prepend('<div class="btn copy_review" style="margin-bottom: 3px;margin-left: 0px;">Copy from Default</div>');
                        $('.review_editor').show();
                        if (self.allow_copy) {
                            $('#review_mail_content').val(survey_data['review_mail_content']);
                        }
                    } else {
                        $('.review_default').html('Not set');
                        $('.review_editor').html('-');
                    }

                    // Right To Left align of input text
                    if (self.text_direction == 'right_to_left')
                    {
                        $.each($('#translate_survey_inner').find('input[type=text]'), function () {
                            $(this).css('direction', 'RTL');
                        });
                    }

                }
            });
        }
        else {
            // hide translate tab
            $('.translate_survey_tab').hide();
            // call api to save record via php
            var url = App.api.buildURL("bc_survey", "get_survey_language", "", {survey_id: this.model.get('id')});
            App.api.call('GET', url, {}, {
                success: function (data) {
                    if (data)
                    {

                        // Default CRM Language
                        $('#default_crm_language').html(self.available_language[data['default_crm_language']]);

                        // Default Language
                        if (data['default_crm_language'] == data['default_survey_language'] || !data['default_survey_language'])
                        {
                            selected = 'selected';
                        }
                        var default_options = '<option value="' + data['default_crm_language'] + '" >' + self.available_language[data['default_crm_language']] + '</option>';
                        var selected = '';
                        var list_html = '<tr>';
                        list_html += "            <td id='default_crm_language'>" + self.available_language[data['default_crm_language']] + "</td>";
                        list_html += '            <td style="text-align:center;"><i class="fa fa-check" style="color:green; font-size:14px;" title="Enabled"></i></td>';
                        list_html += "            <td style='text-align:center;'>Left to Right</td>";
                        list_html += "            <td style='text-align:center;'><i class='fa fa-check' style='color:green; font-size:14px;' title='Yes'></i></td>";
                        list_html += "            <td style='width:25%;text-align:center;'></td>";
                        list_html += "        </tr>";
                        if (data['supported_survey_language'])
                        {
                            $.each(data['supported_survey_language'], function (key, value) {
                                selected = '';
                                if (value == data['default_survey_language'] || value == data['default_crm_language'])
                                {
                                    selected = 'selected';
                                }
                                if (value)
                                {
                                    var is_translated = '<i class="fa fa-times" style="color:red; font-size:14px;" title="No"></i>';
                                    if (data['lang_detail'][value] && data['lang_detail'][value]['translated'] == 1)
                                    {
                                        is_translated = '<i class="fa fa-check" style="color:green; font-size:14px;" title="Yes"></i>';
                                    }
                                    var status = '<i class="fa fa-ban" style="color:red;font-size:14px;" title="Disabled"></i>';
                                    if (data['lang_detail'][value] && data['lang_detail'][value]['status'] == 'enabled')
                                    {
                                        status = '<i class="fa fa-check" style="color:green; font-size:14px;" title="Enabled"></i>';
                                    }
                                    if (data['lang_detail'][value] && data['lang_detail'][value]['status'] == 'enabled' && data['lang_detail'][value]['translated'] == 1)
                                    {
                                        default_options += '<option value="' + value + '" ' + selected + '>' + self.available_language[value] + '</option>';
                                    }
                                    var lang_id = '';
                                    if (data['lang_detail'][value])
                                    {
                                        lang_id = data['lang_detail'][value]['id'];
                                    }
                                    var text_direction = '';
                                    if (data['lang_detail'][value])
                                    {
                                        text_direction = data['lang_detail'][value]['text_direction'];
                                    }
                                    list_html += '<tr>';
                                    list_html += '  <td><a class="edit-language" style="color:#555; text-decoration:none;" lang-id="' + lang_id + '" >' + self.available_language[value] + '&nbsp;<i class="fa fa-pencil">&nbsp;</i></a></td>';
                                    list_html += '    <td style="text-align:center;">' + status + '</td>';
                                    list_html += '    <td style="text-align:center;">' + self.text_direction_list[text_direction] + '</td>';
                                    list_html += '    <td style="text-align:center;">' + is_translated + '</td>';
                                    list_html += '    <td style="width:25%;text-align:center;"><div class="btn  add-translation" sel-lang="' + value + '" lang-id="' + lang_id + '" text-direction="' + text_direction + '" title="Add Translation"><i class="fa fa-refresh">&nbsp;</i>Translate ' + self.survey_type + '</div>&nbsp;';
                                    list_html += '       <div class="btn  remove-lang" sel-lang="' + value + '" lang-id="' + lang_id + '" title="Remove Language"><i class="fa fa-times"></i></div>';
                                    list_html += '   </td>';
                                    list_html += '</tr>';
                                }
                            });
                        }
                        $('.supported_lang_list').html(list_html);
                        $('[name=survey_default_language]').html(default_options);
                    }
                }
            });
        }
    },
    /*Copy text from dafault advance editor
     * 
     * @returns {undefined}
     */
    copy_from_dafaultEditor: function (el) {
        
        if ($(el.currentTarget).hasClass('copy_welcome')) {
            $('#survey_welcome_page').val($('.welcome_default').html());
        }
        else if ($(el.currentTarget).hasClass('copy_thanks')) {
            $('#survey_thanks_page').val($('.thanks_default').html());
        }
        else if ($(el.currentTarget).hasClass('copy_review')) {
            $('#review_mail_content').val($('.review_default').html());
        }
    },
    /*
     * copy data from existing survey
     * @returns {undefined}
     */
    load_default_survey_data_clicked: function () {
        var self = this;
        app.alert.show('copy_survey', {
            level: 'confirmation',
            messages: "Copy " + self.survey_type + "  details and standard messages for this language from an existing " + self.survey_type + "  ? This will override your existing data. Are you sure that you want to proceed ?",
            onConfirm: function () {
                self.allow_copy = 1;
                self._render();
            },
            onCancel: function () {
            },
            autoClose: false
        });
    },
    /**survey language tab clicked
     * 
     * @returns {undefined}
     */
    survey_language_tab_clicked: function () {
        // reset global variable
        this.allow_copy = '';
        this.selected_lang = '';
        this.text_direction = '';
        this.recentAddedLanguage = '';
        // hide translate tab
        $('.translate_survey_tab').hide();
        // data hide/show tab wise
        $('#survey_language_inner').show();
        $('#translate_survey_inner').hide();
        // save button show/hide
        $('.bottom-translate').hide();
        $('.bottom-language').show();
        $('.survey_language_tab').addClass('active');
        $('.translate_survey_tab').removeClass('active');
        // re render
        this._render();
    },
    /**translate survey tab clicked
     * 
     * @returns {undefined}
     */
    translate_survey_tab_clicked: function () {
        // show translate tab
        $('.translate_survey_tab').show();
        // data hide/show tab wise
        $('#survey_language_inner').hide();
        $('#translate_survey_inner').show();
        // save button show/hide
        $('.bottom-translate').show();
        $('.bottom-language').hide();
        $('.translate_survey_tab').addClass('active');
        $('.survey_language_tab').removeClass('active');
    },
    /*
     * Add Language clicked
     */
    add_language_clicked: function () {
        var self = this;
        if (Modernizr.touch) {
            app.$contentEl.addClass('content-overflow-visible');
        }

        var Add_Supported_language = this.layout.getComponent('Add_Supported_language');

        if (!Add_Supported_language) {
            /** Prepare the context object for the new quick create view*/
            var context = this.context.getChildContext({
                module: 'bc_survey',
                module_id: self.model.get('id'),
                mode: '',
                lang_id: ''
            });
            context.prepare();
            /** Create a new view object */
            Add_Supported_language = app.view.createView({
                context: context,
                name: 'Add_Supported_language',
                layout: this.layout
            });
            Add_Supported_language.mode = "";
            Add_Supported_language.module_id = self.model.get('id');
            Add_Supported_language.module = 'bc_survey';
            Add_Supported_language.lang_id = '';
            /** add the new view to the components list of the record layout*/
            this.layout._components.push(Add_Supported_language);
            this.layout.$el.append(Add_Supported_language.$el);
        }
        /**triggers an event to show the pop up quick create view*/
        this.layout.trigger("app:view:Add_Supported_language");
    },
    /*
     * Edit Language Clicked
     */
    edit_language_clicked: function (el) {
        var lang_id = $(el.currentTarget).attr('lang-id');
        var self = this;
        if (Modernizr.touch) {
            app.$contentEl.addClass('content-overflow-visible');
        }

        var Add_Supported_language = this.layout.getComponent('Add_Supported_language');

        if (!Add_Supported_language) {
            /** Prepare the context object for the new quick create view*/
            var context = this.context.getChildContext({
                module: 'bc_survey',
                module_id: self.model.get('id'),
                mode: 'edit',
                lang_id: lang_id
            });
            context.prepare();
            /** Create a new view object */
            Add_Supported_language = app.view.createView({
                context: context,
                name: 'Add_Supported_language',
                layout: this.layout,
                mode: 'edit',
                lang_id: lang_id
            });
            Add_Supported_language.mode = "edit";
            Add_Supported_language.module_id = self.model.get('id');
            Add_Supported_language.module = 'bc_survey';
            Add_Supported_language.lang_id = lang_id;
            /** add the new view to the components list of the record layout*/
            this.layout._components.push(Add_Supported_language);
            this.layout.$el.append(Add_Supported_language.$el);
        }

        /**triggers an event to show the pop up quick create view*/
        this.layout.trigger("app:view:Add_Supported_language");
    },
    /*
     * 
     */
    translate_survey_lang_clicked: function (el) {
        var text_direction = $(el.currentTarget).attr('text-direction');
        var sel_lang = $(el.currentTarget).attr('sel-lang');
        var lang_id = $(el.currentTarget).attr('lang-id');
        this.selected_lang = sel_lang;
        this.lang_id = lang_id;
        this.text_direction = text_direction;
        this.translate_survey_tab_clicked();
        this._render();
    },
    /**survey language tab clicked
     * 
     * @returns {undefined}
     */
    survey_component_tab_clicked: function (el) {

        // data hide/show tab wise
        $('.translate-survey-view').animate({scrollTop: 0}, 'slow', function () {
        });
        $('#survey_component_inner').show();
        $('#survey_msg_inner').hide();
        $('#survey_advance_content_inner').hide();

        $('.survey_component_tab').addClass('active');
        $('.survey_msg_tab').removeClass('active');
        $('.survey_advance_content_tab').removeClass('active');
        // re render
        if (!$(el.currentTarget).hasClass('prev'))
        {
            this._render();
        }
    },
    /**translate survey tab clicked
     * 
     * @returns {undefined}
     */
    survey_msg_tab_clicked: function () {
        var error = false;
        var self = this;
        var params = {};
        var lang_id = $('#lang_id').val();

        $.each($('#translate_survey_inner').find('tr').find('input[type=text]'), function () {
            if (!$(this).val() && $(this).parents('tr').attr('save_id'))
            {
                error = true;
            }
        });

        if (error)
        {
            app.alert.show('confirm_save_translation', {
                level: 'confirmation',
                messages: "Form contains empty input. Are you sure that you want to proceed with default language labels?",
                onConfirm: function () {

                    // data hide/show tab wise
                    $('.translate-survey-view').animate({scrollTop: 0}, 'slow', function () {
                    });
                    $('#survey_component_inner').hide();
                    $('#survey_msg_inner').show();
                    $('#survey_advance_content_inner').hide();

                    $('.survey_component_tab').removeClass('active');
                    $('.survey_msg_tab').addClass('active');
                    $('.survey_advance_content_tab').removeClass('active');


                },
                onCancel: function () {
                },
                autoClose: false
            });
        }
        else {

            // data hide/show tab wise
            $('.translate-survey-view').animate({scrollTop: 0}, 'slow', function () {
            });
            $('#survey_component_inner').hide();
            $('#survey_msg_inner').show();
            $('#survey_advance_content_inner').hide();

            $('.survey_component_tab').removeClass('active');
            $('.survey_msg_tab').addClass('active');
            $('.survey_advance_content_tab').removeClass('active');

        }
    },
    /**translate survey tab clicked
     * 
     * @returns {undefined}
     */
    survey_advance_content_tab_clicked: function () {

        var params = {};
        var error = false;
        $.each($('#translate_survey_inner').find('tr').find('input[type=text]'), function () {
            if (!$(this).val() && $(this).parents('tr').attr('save_id'))
            {
                error = true;
            }
        });

        error = this.checkMessageValidation(); // check validation msg are proper or not

        if (!error)
        {
            // data hide/show tab wise
            $('.translate-survey-view').animate({scrollTop: 0}, 'slow', function () {
            });
            $('#survey_msg_inner').hide();
            $('#survey_component_inner').hide();
            $('#survey_advance_content_inner').show();
            $('.survey_component_tab').removeClass('active');
            $('.survey_msg_tab').removeClass('active');
            $('.survey_advance_content_tab').addClass('active');

        }
    },
    checkMessageValidation: function () {
        var error = false;
        if ($('.sel_limit_msg').val() && !$('.sel_limit_msg').val().includes('$min'))
        {
            $('.sel_limit_msg').css('border', '1px solid red').addClass('error-custom');
            error = true;
        } else {
            $('.sel_limit_msg').css('border', '').removeClass('error-custom');
        }
        if ($('.limit_msg').val() && (!$('.limit_msg').val().includes('$min') || !$('.limit_msg').val().includes('$max')))
        {
            $('.limit_msg').css('border', '1px solid red').addClass('error-custom');
            error = true;
        } else {
            $('.limit_msg').css('border', '').removeClass('error-custom');
        }
        if ($('.limit_min_msg').val() && !$('.limit_min_msg').val().includes('$min'))
        {
            $('.limit_min_msg').css('border', '1px solid red').addClass('error-custom');
            error = true;
        } else {
            $('.limit_min_msg').css('border', '').removeClass('error-custom');
        }
        if ($('.limit_max_msg').val() && !$('.limit_max_msg').val().includes('$max'))
        {
            $('.limit_max_msg').css('border', '1px solid red').addClass('error-custom');
            error = true;
        } else {
            $('.limit_max_msg').css('border', '').removeClass('error-custom');
        }
        if ($('.limit_precision_msg').val() && !$('.limit_precision_msg').val().includes('$precision'))
        {
            $('.limit_precision_msg').css('border', '1px solid red').addClass('error-custom');
            error = true;
        } else {
            $('.limit_precision_msg').css('border', '').removeClass('error-custom');
        }
        if ($('.max_msg').val() && !$('.max_msg').val().includes('$max'))
        {
            $('.max_msg').css('border', '1px solid red').addClass('error-custom');
            error = true;
        } else {
            $('.max_msg').css('border', '').removeClass('error-custom');
        }
        if ($('.range_msg').val() && (!$('.range_msg').val().includes('$min') || !$('.range_msg').val().includes('$max')))
        {
            $('.range_msg').css('border', '1px solid red').addClass('error-custom');
            error = true;
        } else {
            $('.range_msg').css('border', '').removeClass('error-custom');
        }
        if ($('.start_date_msg').val() && !$('.start_date_msg').val().includes('$min'))
        {
            $('.start_date_msg').css('border', '1px solid red').addClass('error-custom');
            error = true;
        }
        if ($('.end_date_msg').val() && !$('.end_date_msg').val().includes('$max'))
        {
            $('.end_date_msg').css('border', '1px solid red').addClass('error-custom');
            error = true;
        } else {
            $('.end_date_msg').css('border', '').removeClass('error-custom');
        }
        if ($('.survey_notstart_msg').val() && !$('.survey_notstart_msg').val().includes('$startDateTime'))
        {
            $('.survey_notstart_msg').css('border', '1px solid red').addClass('error-custom');
            error = true;
        } else {
            $('.survey_notstart_msg').css('border', '').removeClass('error-custom');
        }
        if ($('.survey_exp_msg').val() && !$('.survey_exp_msg').val().includes('$endDateTime'))
        {
            $('.survey_exp_msg').css('border', '1px solid red').addClass('error-custom');
            error = true;
        } else {
            $('.survey_exp_msg').css('border', '').removeClass('error-custom');
        }

        // focus on first invalid input
        $('.error-custom:first').focus();
        return error;
    },
    remove_lang_clicked: function (el) {
        var sel_lang = $(el.currentTarget).attr('sel-lang');
        var lang_id = $(el.currentTarget).attr('lang-id');
        var self = this;
        app.alert.show('remove_lang', {
            level: 'confirmation',
            messages: "Are you sure want to remove this language ?",
            onConfirm: function () {
                // call api to save record via php
                var url = App.api.buildURL("bc_survey", "remove_language", "", {survey_id: self.model.get('id'), sel_lang: sel_lang, lang_id: lang_id});
                App.api.call('GET', url, {}, {
                    success: function (data) {
                        if (data)
                        {
                            $(el.currentTarget).parents('tr').remove();
                            app.alert.show('success_deleted_lang', {
                                level: 'success',
                                messages: 'Language deleted successfully.',
                                autoClose: true
                            });

                            self._render();
                        }
                    }
                });

            },
            onCancel: function () {
            },
            autoClose: false
        });
    },
    save_lang_clicked: function () {

        var sel_lang = $('[name=survey_default_language]').val();
        var self = this;
        // call api to save record via php         
        var url = App.api.buildURL("bc_survey", "save_default_language", "", {survey_id: self.model.get('id'), sel_lang: sel_lang});
        app.alert.show('loading_translate', {level: 'process', title: 'Saving', autoclose: false});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data)
                {
                    app.alert.show('success_deleted_lang', {
                        level: 'success',
                        messages: 'Default Language saved successfully.',
                        autoClose: true
                    });
                    self._render();
                }
            },
            complete: function () {
                app.alert.dismiss('loading_translate');
            },
        });

    },
    save_translate_clicked: function () {
       
        var lang_id = $('#lang_id').val();
        var self = this;
        var params = {};
        var error = false;
        $.each($('#translate_survey_inner').find('tr').find('input[type=text]'), function () {
            if (!$(this).val() && (!$(this).val() == true && !$(this).val().trim()))
            {
                error = true;
            }
            if ($(this).parents('tr').hasClass('survey_tr'))
            {
                var key = $(this).attr('class');
                if ($.isEmptyObject(params[$(this).parents('tr').attr('save_id')]))
                {
                    params[$(this).parents('tr').attr('save_id')] = {};
                }
                params[$(this).parents('tr').attr('save_id')][key] = $(this).val();
            }
            else if ($(this).parents('tr').hasClass('question_detail_tr'))
            {
                var key = $(this).attr('class');
                if ($.isEmptyObject(params[$(this).parents('tr').attr('save_id')]))
                {
                    params[$(this).parents('tr').attr('save_id')] = {};
                }
                params[$(this).parents('tr').attr('save_id')][key] = $(this).val();
            } else {
                params[$(this).parents('tr').attr('save_id')] = $(this).val();
            }
        });

        // store messages in parameters
        params['next_button'] = $('.next_button').val();
        params['prev_button'] = $('.prev_button').val();
        params['submit_button'] = $('.submit_button').val();

        params['required_msg'] = $('.required_msg').val();
        params['invalid_email_msg'] = $('.invalid_email_msg').val();
        params['invalid_phn_msg'] = $('.invalid_phn_msg').val();
        params['matrix_required_msg'] = $('.matrix_required_msg').val();
        params['sel_limit_msg'] = $('.sel_limit_msg').val();
        params['limit_msg'] = $('.limit_msg').val();
        params['limit_min_msg'] = $('.limit_min_msg').val();
        params['limit_max_msg'] = $('.limit_max_msg').val();
        params['limit_precision_msg'] = $('.limit_precision_msg').val();
        params['max_msg'] = $('.max_msg').val();
        params['range_msg'] = $('.range_msg').val();
        params['start_date_msg'] = $('.start_date_msg').val();
        params['end_date_msg'] = $('.end_date_msg').val();

        params['success_submit_msg'] = $('.success_submit_msg').val();
        params['email_success_submit_msg'] = $('.email_success_submit_msg').val();
        params['already_sub_msg'] = $('.already_sub_msg').val();
        params['location_already_sub_msg'] = $('.location_already_sub_msg').val();
        params['req_msg'] = $('.req_msg').val();
        params['survey_notstart_msg'] = $('.survey_notstart_msg').val();
        params['survey_exp_msg'] = $('.survey_exp_msg').val();
        params['survey_deleted_msg'] = $('.survey_deleted_msg').val();
        params['rec_deleted_msg'] = $('.rec_deleted_msg').val();
        params['resubmit_request_success_msg'] = $('.resubmit_request_success_msg').val();
        params['resubmit_request_fail_msg'] = $('.resubmit_request_fail_msg').val();
        params['resubmit_request_already_sent_msg'] = $('.resubmit_request_already_sent_msg').val();


        if ($('.welcome_editor').html() != '-')
        {
            var welcome = $('#survey_welcome_page').val();
            if (welcome) {
                params['survey_welcome_page'] = welcome;
            } else {
                error = true;
            }
        }
        if ($('.thanks_editor').html() != '-')
        {
            var thanks = $('#survey_thanks_page').val();
            if (thanks) {
                params['survey_thanks_page'] = thanks;
            } else {
                error = true;
            }
        }
        if ($('.review_editor').html() != '-')
        {
            var review = $('#review_mail_content').val();
            if (review) {
                params['review_mail_content'] = review;
            } else {
                error = true;
            }
        }

        if (error)
        {
            app.alert.show('confirm_save_translation', {
                level: 'confirmation',
                messages: "Form contains empty input. Are you sure that you want to proceed with default language labels?",
                onConfirm: function () {
                    // call api to save record via php         
                    var url = App.api.buildURL("bc_survey", "save_language_translation");
                    App.api.call('create', url, {survey_id: self.model.get('id'), lang_id: lang_id, params: JSON.stringify(params)}, {
                        success: function (data) {
                            if (data)
                            {
                                app.alert.show('success_saved_translation', {
                                    level: 'success',
                                    messages: 'Language Translation Advance Content saved successfully.',
                                    autoClose: true
                                });
                                self.survey_language_tab_clicked();
                            }
                        }
                    });
                },
                onCancel: function () {
                },
                autoClose: false
            });
        }
        if (!error)
        {
            app.alert.show('loading_translate', {level: 'process', title: 'Saving', autoclose: false});
            // call api to save record via php         
            var url = App.api.buildURL("bc_survey", "save_language_translation");
            App.api.call('create', url, {survey_id: self.model.get('id'), lang_id: lang_id, params: JSON.stringify(params)}, {
                success: function (data) {
                    if (data)
                    {
                        app.alert.show('success_saved_translation', {
                            level: 'success',
                            messages: 'Language Translation Advance Content saved successfully.',
                            autoClose: true
                        });
                        // self.survey_language_tab_clicked();
                        window.location.reload();
                    }
                },
                complete: function () {
                    app.alert.dismiss('loading_translate');
                },
            });
        }
    },
})