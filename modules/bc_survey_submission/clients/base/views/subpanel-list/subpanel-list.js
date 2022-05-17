({
    /**
     * The file used to handle layout of subpanel view for survey submission
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */
    extendsFrom: 'SubpanelListView',
    initialize: function (options) {
        this._super('initialize', [options]);
        // open individual report on click of Show Report action button
        this.context.on('button:view_report:click', this.viewReport, this);
        this.context.on('button:attend_survey:click', this.attend_survey, this);
        this.context.on('button:resend_survey:click', this.resendSurvey, this);
    },
    render: function () {

        this._super('render');
        //conditionally hide attend survey button if already submitted
        $.each($('[name=attend_survey]'), function (i, v) {
            var aa = $(this).parents('tr').children()[5];
            var submission_status = $(aa.children).children().attr('data-original-title')
            if (submission_status == 'Submitted') {
                this.remove();
                $(this).parents('.fieldset').find('.dropdown-toggle').remove();
            }
        });
    },
    /**view report for survey submission into subpanel view report button 
     * 
     * @param {type} model
     * @returns {undefined}
     */
    viewReport: function (model) {
        var survey_id = model.get('bc_survey_submission_bc_surveybc_survey_ida');
        if (!model.attributes.target_parent_id) {
            var module_id = this.context.attributes.parentModel.id;
        } else {
            var module_id = model.attributes.target_parent_id;
        }
        var sub_id = model.get('id');
        var page = 1;
        $('<input>').attr({
            type: 'hidden',
            id: 'selectedRecord',
            name: 'selectedRecord'
        }).appendTo('head');
        $("#selectedRecord").val(module_id);
        var url = App.api.buildURL("bc_survey", "getIndividualPersonReport", "", {survey_id: survey_id, module_id: module_id, page: "1", isFromSubpanel: "1", submission_id: sub_id});
        App.api.call('GET', url, {}, {
            success: function (result) {
                $('body').append('<div id="backgroundpopup">&nbsp;</div>');
                if ($("#indivisual_report_main_div").length == 0) {
                    $('body').append('\
                    <link href="custom/include/css/survey_css/report.css" rel="stylesheet"/>\n\\n\
                    <link href="custom/include/css/survey_css/pagination.css" rel="stylesheet"/>\n\
                    <script type="text/javascript" src="custom/include/js/survey_js/custom_code.js"></script>\n\
                    <script type="text/javascript">function close_survey_div(el){ $("#backgroundpopup").fadeOut(function () {$("#backgroundpopup").remove();}); $("#indivisual_report_main_div").fadeOut(function () {$("#indivisual_report_main_div").remove();}); }</script>\n\
                         <div id="indivisual_report_main_div"> </div>');
                }
                $('#backgroundpopup').fadeIn();
                $('#indivisual_report_main_div').fadeIn();
                var html = '';
                var queReoort_pageNumbers = result['queReoort_pageNumbers'];
                var IsSubmission = true;

                //get module_name
                if (result['row'][page]['customer_name'] != '' || result['row'][page]['customer_name'] != null) {

                    html += "<div style='background-color:#e8e8e8; padding:3px; font-size:16px; height:25px; padding-top:10px;'>Response of " + result['row'][page]['survey_name'] + "</div>";
                    if (page == 1) {
                        html += "<div style='background-color:#f6f6f6; border-top:1px solid #ccc; border-bottom:1px solid #ccc; font-size:14px; '><div class='row'>";

                        if (result['row'][page]['send_date'] != '') {
                            html += "<div class='span4'>";
                            html += "<div class='send-date' style='margin:6px'><p style='font-size:14px;'><strong>Survey Send date : </strong></p> " + result['row'][page]['send_date'] + "</div>";
                            html += "</div>";
                        }
                        if (result['row'][page]['receive_date'] != '') {
                            html += "<div class='span4'>";
                            html += "<div class='receive-date' style='margin:6px'><p style='font-size:14px;'><strong>Survey Receive date : </strong></p> " + result['row'][page]['receive_date'] + "</div></div>";
                            html += "</div>";
                        }
                        if (result['row'][page]['base_score'] != 0 && result['row'][page]['obtained_score'])
                        {
                            html += "<div class='row' style='margin: 0px;'>";
                            html += "  <div class='span6'>";
                            html += "      <div class='score_weight' style='margin:6px'><p style='font-size:14px;'><strong>Survey Score : </strong></p><p style='font-size:14px;'>Obtained score <strong>" + result['row'][page]['obtained_score'] + "</strong> out of <strong>" + result['row'][page]['base_score'] + "</strong></p></div>";
                            html += "   </div>";
                            html += "</div>";
                        }
                        html += "</div>";
                    }
                }

                if (result['row'][page]['status'] == 'Pending') {

                    html = "<div id='individual'>There is no submission response for this Survey.</div>";
                    var IsSubmission = false;
                } else if (result['row'][page]['status'] == null) {
                    html = '';
                } else {
                    if (result['row'][page]['status'] == 'Submitted') {
                        if (result['row'][page]['question_type'] != '' && result['row'][page]['question_type'] == 'rating') {
                            var rating = "";
                            for (i = 0; i < 5; i++) {
                                if (i < result['row'][page]['name']) {
                                    var selected = "selected";
                                } else {
                                    var selected = "";
                                }
                                rating += "<li class='rating " + selected + "' style='display: inline;font-size: x-large'>&#9733;</li>";
                            }
                        }
                    }
                }
                html += "<div class='middle-content'>";
                var matrix_answer_array = new Object();
                var ques_id = '';
                $.each(result['detail_array'], function (page_id, page_data) {
                    $.each(page_data, function (que_id, que_title) {
                        ;
                        var question_report_html = '';

                        if (result['row'][page][que_id]['question_type'] == 'matrix') {

                            var rows = result['row'][page][que_id]['matrix_rows'];
                            var cols = result['row'][page][que_id]['matrix_cols'];
                            //count number of rows & columns
                            var row_count = Object.keys(rows).length + 1;
                            var col_count = Object.keys(cols).length;
                            // adjusting div width as per column
                            var width = Math.round(70 / (col_count + 1)) - 1;
                            question_report_html = '<span class="ans"><b>Answer</b><table style="margin-left: 70px;margin-top: -25px;" id="matrix_table_' + que_id + '">';
                            for (var i = 1; i <= row_count; i++) {
                                question_report_html += '<tr>';
                                for (var j = 1; j <= col_count + 1; j++) {

                                    //First row & first column as blank
                                    if (j == 1 && i == 1) {
                                        question_report_html += "<td class='matrix-span' style='width:" + width + "%;text-align:left;border: 1px solid #D4CECE; padding:10px; margin:0px;'>&nbsp;</td>";
                                    }
                                    // Rows Label
                                    if (j == 1 && i != 1) {
                                        question_report_html += "<td class='matrix-span' style='font-weight:bold; width:" + width + "%;;text-align:left;border: 1px solid #D4CECE;padding:10px; margin:0px;'>" + rows[i - 1] + "</td>";
                                    } else {
                                        //Columns label
                                        if (j <= col_count + 1 && cols[j - 1] != null && !(j == 1 && i == 1) && (i == 1 || j == 1))
                                        {
                                            question_report_html += "<td class='matrix-span' style='font-weight:bold; width:" + width + "%;border: 1px solid #D4CECE;padding:10px; margin:0px;'>" + cols[j - 1] + "</td>";

                                        }
                                        //Display answer input (RadioButton or Checkbox)
                                        else if (j != 1 && i != 1 && cols[j - 1] != null) {
                                            var row = i - 1;
                                            var col = j - 1;
                                            question_report_html += "<td class='matrix-span' style='width:" + width + "%;border: 1px solid #D4CECE;padding:10px; margin:0px; '  id='" + row + "_" + col + "' name='matrix" + row + "'><input type='radio' disabled></td>";
                                        }
                                        // If no value then display none
                                        else {
                                            question_report_html += "";
                                        }
                                    }

                                }
                                question_report_html += '</tr>';
                            }
                            question_report_html += "</table></span>";
                        }
                        matrix_answer_array[que_id] = new Object();
                        ques_id = que_id;

                        $.each(que_title, function (title, answers) {
                            if (title != "page_id") {
                                html += " <div class='que-rwo'>";
                                html += "    <p class='que'><b>Question</b>" + title;
                                if (answers['obtained_que_score'] && answers['base_que_score'] && answers['base_que_score'] != 0)
                                {
                                    html += "<span style='float:right;font-weight:bold;background-color: #DDDDDD; border-radius: 4px; height: 18px; padding:5px;'>  " + answers['obtained_que_score'] + " / " + answers['base_que_score'] + " </span></p>";
                                } else {
                                    html += "</p>";
                                }
                                $.each(answers, function (t, answer) {
                                    if (t == 'matrix_answer') {

                                        if (typeof answer != "undefined")
                                        {
                                            $.each(answer[0], function (i, ans) {
                                                matrix_answer_array[ques_id][i] = ans;
                                            });
                                        }
                                    } else if (t != 'page_id' && t != 'base_que_score' && t != 'obtained_que_score')
                                    {
                                        if (typeof answer == 'object' && answer != null) {
                                            if (t == 'all_answers')
                                            {
                                                html += "<div class='row'><span class='span1'><b>Answer</b></span> ";
                                                var html1 = '';
                                                html += "<span class='span6'>";
                                                var answer_submitted = false;
                                                $.each(answer, function (ans_label, ans) {
//
                                                    if (ans['selected'] == true) {

                                                        html1 += "<li>" + ans['ans'] + "" + "</li>";
                                                        answer_submitted = true;
                                                    }
                                                });

                                                if (!answer_submitted) {
                                                    html += '<span style="margin-left: -12px;">N/A</span>';
                                                } else {
                                                    html += "<ul style='margin-left:2px;'>" + html1 + "</ul>";
                                                }
                                                html += '</span>';

                                                html += "</div>";
                                            } else { // Contact Information

                                                html += "<div class='row'> <span class='ans span1'><b>Answer</b></span><div class='span6' style='margin-left:12px;'>";
                                                html += "<b>Company Name : </b>" + answer['Company'];
                                                html += "<br/><b>Name : </b>" + answer['Name'];
                                                html += "<br/><b>Street1 :</b> " + answer['Address'];
                                                html += "<br/><b>Street2 : </b>" + answer['Address2'];
                                                if (!answer['City/Town'])
                                                {
                                                    html += "<br/>" + answer['State/Province'] + "," + answer['Country'] + "," + answer['Zip/Postal Code'];
                                                } else if (!answer['State/Province'])
                                                {
                                                    html += "<br/>" + answer['City/Town'] + "," + answer['Country'] + "," + answer['Zip/Postal Code'];
                                                } else if (!answer['Country'])
                                                {
                                                    html += "<br/>" + answer['City/Town'] + "," + answer['State/Province'] + "," + answer['Zip/Postal Code'];
                                                } else if (!answer['Zip/Postal Code'])
                                                {
                                                    html += "<br/>" + answer['City/Town'] + "," + answer['State/Province'] + "," + answer['Country'];
                                                }
                                                if (answer['City/Town'] && answer['State/Province'] && answer['Country'] && answer['Zip/Postal Code'])
                                                {
                                                    html += "<br/>" + answer['City/Town'] + "," + answer['State/Province'] + "," + answer['Country'] + "," + answer['Zip/Postal Code'];
                                                }
                                                html += "<br/><b>Email : </b>" + answer['Email Address'];
                                                html += "<br/><b>Phone : </b>" + answer['Phone Number'];
                                                html += "</div></div>";
                                            }
                                        } else {
                                            if (answer) {
                                                var submitted_answer = answer;
                                            } else {
                                                var submitted_answer = 'N/A';
                                            }
                                            if (result['row'][page][que_id]['question_type'] == 'doc-attachment' && answer && answer != 'N/A')
                                            {
                                                var splitted_answer = answer.split('_documentID_');
                                                var doc_id = splitted_answer[0];
                                                var doc_name = splitted_answer[1];
                                                var submitted_answer = '<a onclick=\' window.open("#bwc/index.php?module=Documents&action=DetailView&record=' + doc_id + '")\'>' + doc_name + '</a>';
                                            }
                                            html += "<span class='ans'><b>Answer</b> <div style='display: inline-block;vertical-align: top'>" + submitted_answer + "</div></p>";
                                        }
                                    }
                                });
                                html += question_report_html;
                                html += "</div>";
                            }
                        });


                    });
                });
                html += "</div>";
                if (queReoort_pageNumbers != null && IsSubmission) {
                    html += "<div class='numbers'> " + queReoort_pageNumbers + "</div>";
                }

                $('#indivisual_report_main_div').html('<div id="indivisual_report">'
                        + html +
                        ' <a  href="javascript:void(0);" class="close_link" onclick="close_survey_div(this)"></a>' +
                        '</div>');
                //Check response submitted by user for matrix type question
                if (matrix_answer_array != null) {
                    $.each(matrix_answer_array, function (qid, values) {
                        ;
                        var qid = qid;
                        $.each(values, function (index, value) {
                            value = value.split('_');
                            $('#matrix_table_' + qid).find("#" + value[0] + "_" + value[1] + "").html("<input type='radio' checked disabled>");
                        });

                    });
                }
            },
        });

    },
    /**attend survey on behalf of customer
     * 
     * @param {type} model
     * @returns {undefined}
     */
    attend_survey: function (model) {

        var survey_id = model.get('bc_survey_submission_bc_surveybc_survey_ida');
        if (!model.attributes.target_parent_id) {
            var module_id = this.context.attributes.parentModel.id;
        } else {
            var module_id = model.attributes.target_parent_id;
        }
        var submission_id = model.get('id');
        if (!model.attributes.target_parent_type) {
            var module_type = this.context.attributes.parentModule;
        } else {
            var module_type = model.attributes.target_parent_type;
        }
        var self = this;
        //getting survey submission status
        var url = App.api.buildURL("bc_survey", "getResubmissionStatus", "", {survey_id: survey_id, submission_id: submission_id, module_id: module_id});
        App.api.call('GET', url, {}, {
            success: function (result) {
                // if result is true means allow to resubmit
                if (result == "true" || model.attributes.status == 'Pending') {
                    app.alert.show('send_confirm', {
                        level: 'confirmation',
                        title: 'Notice',
                        messages: "Are You Sure You Want to Submit This Survey On Behalf Of " + self.context.attributes.parentModel.attributes.name + " ?",
                        onConfirm: _.bind(self.getSurveyURL, self, survey_id, module_type, module_id, submission_id),
                    });
                } else if (model.attributes.status == 'Submitted') {
                    app.alert.show('info', {
                        level: 'info',
                        messages: 'You can\'t attend this survey due to survey is already submitted.',
                        autoClose: true
                    });
                }
            }
        });
    },
    resendSurvey: function (model) {

        console.log(model);
        var submission_id = model.id;
        var self = this;
        // check is Survey Submitted or not
        app.alert.show('send_confirm', {
            level: 'confirmation',
            title: 'Notice',
            messages: "Are you sure want to resend survey ?",
            onConfirm: function () {

                if (app.user.id == model.get('created_by') || app.user.attributes.type == "admin")
                {
                    // loading alert for resend processing
                    app.alert.show('loading_resend_survey', {level: 'process', title: 'Processing', autoclose: false});
                    if (self.context)
                    {
                        var survey_id = model.attributes.bc_survey_submission_bc_surveybc_survey_ida;
                        if (!model.attributes.target_parent_id) {
                            var module_id = self.context.attributes.parentModel.id;
                        } else {
                            var module_id = model.attributes.target_parent_id;
                        }
                        if (!model.attributes.target_parent_type) {
                            var module_type = self.context.attributes.parentModule;
                        } else {
                            var module_type = model.attributes.target_parent_type;
                        }
                    }
                    if (survey_id && module_id && module_type)
                    {
                        var url = App.api.buildURL("bc_survey", "approveRequest", "", {survey_id: survey_id, module_name: module_type, module_id: module_id, resendFromSubpanel: 1, isSurveyAlreadySend: model.attributes.survey_send, submission_id: model.get('id')});
                        App.api.call('GET', url, {}, {
                            success: function (result) {
                                var response = JSON.parse(result);
                                if (response['status'] == "sucess") {
                                    App.alert.show('email_success', {
                                        level: 'success',
                                        title: '',
                                        messages: 'Email for resubmission survey has sent successfully.',
                                        autoClose: true
                                    });
                                } else {
                                    App.alert.show('email_error', {
                                        level: 'error',
                                        title: '',
                                        messages: response['status'],
                                        autoClose: false
                                    });
                                }
                            },
                            complete: function () {
                                app.alert.dismiss('loading_resend_survey');
                            }
                        });
                    }
                } else {
                    var created_by_user = self.model.get('created_by_name');
                    if (created_by_user == "Administrator") {
                        var msg = 'You are unauthorized to resend this survey. Please contact  ' + created_by_user + ' to resend this survey';
                    } else if (created_by_user) {
                        var msg = 'You are unauthorized to resend this survey. Please contact Administrator or ' + created_by_user + ' to resend this survey';
                    } else {
                        var msg = 'You are unauthorized to resend this survey. Please contact Administrator to resend this survey';
                    }
                    App.alert.show('email_error', {
                        level: 'error',
                        title: '',
                        messages: msg,
                        autoClose: false
                    });

                }
            }
        });
    },
    /**get survey url for attending survey y admin
     * 
     * @param {type} survey_id
     * @param {type} module_type
     * @param {type} module_id
     * @returns {undefined}
     */
    getSurveyURL: function (survey_id, module_type, module_id, submission_id) {
        ;
        var url = App.api.buildURL("bc_survey", "getSurveyURL", "", {survey_id: survey_id, module_type: module_type, module_id: module_id, submission_id: submission_id});
        App.api.call('GET', url, {}, {
            success: function (result) {

                if (result != null) {
                    var newWin = window.open(result.trim(), "_blank");
                }
            }
        });
    }
})
