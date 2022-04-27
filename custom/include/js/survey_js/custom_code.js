/**
 * The file used to set js functions related to survey
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */

// close durvey popup
function close_survey_div() {
    $("#backgroundpopup").fadeOut(function () {
        $("#backgroundpopup").remove();
    });
    $("#indivisual_report_main_div").fadeOut(function () {
        $("#indivisual_report_main_div").remove();
    });
}

// get question report pagination for question wise report or from subpanel
function getReports(survey_id, page, module_id, isFromSubpanel, sub_id) {
    App.alert.show('loading_report_view', {level: 'process', title: 'Please wait while report is loading', autoclose: false});
    var customer_name = $('#customer_name').val();
    $('<input>').attr({
        type: 'hidden',
        id: 'selectedRecord',
        name: 'selectedRecord'
    }).appendTo('head');
    $("#selectedRecord").val(module_id);
    var url = App.api.buildURL("bc_survey", "getIndividualPersonReport", "", {survey_id: survey_id, module_id: module_id, page: page, isFromSubpanel: isFromSubpanel, customer_name: customer_name, submission_id: sub_id});
    App.api.call('GET', url, {}, {
        success: function (result) {

            $('body').append('<div id="backgroundpopup">&nbsp;</div>');
            if ($("#indivisual_report_main_div").length == 0) {
                $('body').append('<div id="indivisual_report_main_div"> </div>');
            }
            $('#backgroundpopup').fadeIn();
            $('#indivisual_report_main_div').fadeIn();
            var html = "<input type='hidden' id='individual_submission_id' value='" + sub_id + "' />";
            var queReoort_pageNumbers = result['queReoort_pageNumbers'];

            //get module_name
            if (result['row'][page]['customer_name'] != '' || result['row'][page]['customer_name'] != null) {
                if (isFromSubpanel == '1') {
                    html += "<div style='background-color:#e8e8e8; padding:3px; font-size:16px; height:25px; padding-top:10px;'>Response of " + result['row'][page]['survey_name'] + "</div>";
                } else {
                    html += "<div style='background-color:#e8e8e8; padding:3px; font-size:16px; height:25px; padding-top:10px;'>Individual Report for " + result['row'][page]['customer_name'] + "</div><input type='hidden' id='customer_name' value='" + result['row'][page]['customer_name'] + "' />";
                }

            }

            if (result['row'][page]['status'] == 'Pending' || result['row'][page]['status'] == null) {
                html = "<div id='individual'>There is no submission response for this Survey.</div>";
            }
            html += "<div class='middle-content'>";
            if (page == 1 && (result['row'][page]['status'] != 'Pending' || result['row'][page]['status'] != null)) {
                if (isFromSubpanel == '1') {
                    html += "<div style='background-color:#f6f6f6; font-size:14px; padding: 5px; '><div class='row'>";
                } else {
                    if (result['row'][page]['description'] == 'null' || result['row'][page]['description'] == null) {
                        result['row'][page]['description'] = '';
                    }
                    html += "<div style='background-color:#f6f6f6;  font-size:14px; padding: 5px; '><div class='send-date' style='margin:6px'><p style='font-size:14px;'><strong>Description : </strong></p>" + result['row'][page]['description'] + "</div><div class='row'>";
                }
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

                html += "<div class='row'>";
                html += "  <div class='span4'>";
                html += "    <div class='track-time' style='margin:6px'><p style='font-size:14px;'><strong>Time Spent on Survey : </strong></p> " + result['row'][page]['track_time_spent_on_survey'] + "</div>";
                html += "   </div>";
                html += "</div>";

                if (result['row'][page]['base_score'] != 0 && result['row'][page]['obtained_score'])
                {
                    html += "<div class='row' style='margin: 0px;'>";
                    html += "  <div class='span6'>";
                    html += "      <div class='score_weight' style='margin:6px'><p style='font-size:14px;'><strong>Survey Score : </strong></p><p style='font-size:14px;'>Obtained score <strong>" + result['row'][page]['obtained_score'] + "</strong> out of <strong>" + result['row'][page]['base_score'] + "</strong></p></div>";
                    html += "   </div>";
                    html += "</div>";
                }

                if (result['row'][page]['consent_accepted'] && result['row'][page]['consent_accepted'] != '') {
                    html += "<div class='row' style='margin-left:0px;'>";
                    html += "   <div class='span4'>";
                    html += "       <div class='receive-date' style='margin:6px'><p style='font-size:14px;'><strong>Consent Accepted? : </strong></p> " + result['row'][page]['consent_accepted'] + "</div>";
                    html += "   </div>";
                    html += "</div>";
                }
                html += "</div>";
            }
            var matrix_answer_array = new Object();
            var ques_id = '';
            $.each(result['detail_array'], function (page_id, page_data) {
                $.each(page_data, function (que_id, que_title) {

                    var question_report_html = '';

                    if (result['row'][page][que_id]['question_type'] == 'matrix') {


                        var rows = result['row'][page][que_id]['matrix_rows'];
                        var cols = result['row'][page][que_id]['matrix_cols'];
                        //count number of rows & columns
                        var row_count = Object.keys(rows).length + 1;
                        var col_count = Object.keys(cols).length;
                        // adjusting div width as per column
                        var width = Math.round(70 / (col_count + 1)) - 1;
                        question_report_html = '<span class="ans"><b>Answer</b><table style="margin-left: 5px;margin-top: 4px;" id="matrix_table_' + que_id + '">';
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
                                html += "<span data-action='answerHistory'><span class='btn btn-info pull-right answerHistory' data-que_id='" + que_id + "' onclick='getAnswerHistory(this)' style='margin-right: 3px;' title='Answer History'><i class='fa fa-history'></i></span></span><span style='float:right;font-weight:bold;background-color: #DDDDDD; border-radius: 4px; height: 18px; padding:5px;'>  " + answers['obtained_que_score'] + " / " + answers['base_que_score'] + " </span></p>";
                            } else {
                                html += "<span data-action='answerHistory'><span class='btn btn-info pull-right answerHistory' data-que_id='" + que_id + "' onclick='getAnswerHistory(this)' title='Answer History'><i class='fa fa-history'></i></span></span></p>";
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
            if (queReoort_pageNumbers != '' || queReoort_pageNumbers != 'null') {
                html += "<div class='numbers'> " + queReoort_pageNumbers + "</div>";
            }

            $('#indivisual_report_main_div').html('<div id="indivisual_report">'
                    + html +
                    ' <a  href="javascript:void(0);" class="close_link" onclick="close_survey_div(this)"></a>' +
                    '</div>');
            if (matrix_answer_array != null) {

                // var submitted_counts = result['matrix_answers_counts'];
                $.each(matrix_answer_array, function (qid, values) {

                    if (values) {
                        var qid = qid;
                        $.each(values, function (index, value) {
                            if (value) {
                                value = value.split('_');
                                $('#matrix_table_' + qid).find("#" + value[0] + "_" + value[1] + "").html("<input type='radio' checked disabled>");
                            }
                        });
                    }
                });
            }
            App.alert.dismiss('loading_report_view');
        },
    });
}

// validate survey form validation for each question
function surveySliderValidationOnNextPrevClick(type, que_id, is_required, min, max, maxsize, precision, advance_type, is_datetime, is_sort, scale_slot, limit_min, lang_detail) {

    var validate = true;
    var lengthValidationMsg = 0;
    if (typeof $('#require_msg_' + que_id) !== undefined) {
        lengthValidationMsg = $('#require_msg_' + que_id).length;
    }
    if (precision != null) {
        var str = '^\\d*\.?\\d{0,' + precision + '}$';
        var reg = new RegExp(str);
    }
    // If current question is not hidden
    if ($('#' + que_id + '_div').parent('div').css('display') !== 'none') {

        var req_msg = ' This question is mandatory, Please answer this question.';
        if (lang_detail && lang_detail['required_msg'])
        {
            req_msg = lang_detail['required_msg'];
        }
        var selection_limit = 'You must have to select alteast ' + limit_min + ' option(s).';
        if (lang_detail && lang_detail['sel_limit_msg'])
        {
            selection_limit = lang_detail['sel_limit_msg'];
            selection_limit = selection_limit.replace('$min', limit_min);
        }

        switch (type) {
            case 'multiselectlist':
                if (is_required == 1) {
                    if ($('.' + que_id).val() == null || $('.' + que_id).val() == '') {
                        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                            if (lengthValidationMsg == 0) {
                                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'> ' + req_msg + '</div>');
                            }
                        }
                        validate = false;
                    }
                }
                // check other option is null or not
                var value_selected = '';
                var sel_ans_ids = $('.' + que_id).val();
                var sel_ans_count = 0;
                if (sel_ans_ids)
                {
                    $.each(sel_ans_ids, function (key, id) {
                        sel_ans_count++;
                        value_selected += $('[value=' + id + ']').attr('class');

                    });
                }
                if (validate && limit_min && parseInt(limit_min) != 0 && sel_ans_count != 0 && sel_ans_count < parseInt(limit_min))
                {
                    $('#require_msg_' + que_id).remove();
                    if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {

                        $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>   ' + selection_limit + '</div>');

                    }
                    validate = false;
                }
                if (value_selected == 'is_other_option' && !$('.' + que_id + '_other').val())
                {
                    $('#require_msg_' + que_id).remove();
                    if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {

                        $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>  ' + req_msg + '</div>');

                    }
                    validate = false;
                } else if (validate) {
                    $('#require_msg_' + que_id).remove();
                }
                break;
            case 'check-box':
                var check = 0;
                var isOtherSelected = false;
                var sel_ans_count = 0
                $('.' + que_id).each(function () {
                    if ($(this).is(':checked') == true) {
                        sel_ans_count++;
                        if (this.className.includes('is_other_option'))
                        {
                            isOtherSelected = true;
                        }
                        check = 1;
                    }
                });
                if (is_required == 1) {
                    $('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').remove();

                    if (check != 1) {
                        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                            if (lengthValidationMsg == 0) {
                                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>   ' + req_msg + '</div>');
                            }
                        }
                        validate = false;
                    }
                }
                if (validate && limit_min && parseInt(limit_min) != 0 && sel_ans_count != 0 && sel_ans_count < parseInt(limit_min))
                {
                    $('#require_msg_' + que_id).remove();
                    if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {

                        $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>   ' + selection_limit + '</div>');
                    }
                    validate = false;
                }
                // check other option is null or not
                if (isOtherSelected && !$('.' + que_id + '_other').val())
                {
                    $('#require_msg_' + que_id).remove();
                    if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {

                        $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'> ' + req_msg + '</div>');

                    }
                    validate = false;
                } else if (validate) {
                    $('#require_msg_' + que_id).remove();
                }
                break;
            case 'radio-button':
                var check = 0;
                var isOtherSelected = false;
                $('.' + que_id).each(function () {
                    if ($(this).is(':checked') == true) {
                        if (this.className.includes('is_other_option'))
                        {
                            isOtherSelected = true;
                        }
                        check = 1;
                    }
                });
                if (is_required == 1) {
                    $('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').remove();

                    if (check != 1) {
                        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                            if (lengthValidationMsg == 0) {
                                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>   ' + req_msg + '</div>');
                            }
                        }
                        validate = false;
                    }
                }
                // check other option is null or not
                if (isOtherSelected && !$('.' + que_id + '_other').val())
                {
                    if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                        if (lengthValidationMsg == 0) {
                            $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>   ' + req_msg + '</div>');
                        }
                    }
                    validate = false;
                } else if (validate) {
                    $('#require_msg_' + que_id).remove();
                }
                break;
            case 'boolean':
            case 'emojis':

                var check = 0;
                $('.' + que_id).each(function () {
                    if ($(this).is(':checked') == true) {
                        check = 1;
                    }
                });
                if (is_required == 1) {
                    $('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').remove();

                    if (check != 1) {
                        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                            if (lengthValidationMsg == 0) {
                                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>   ' + req_msg + '</div>');
                            }
                        }
                        validate = false;
                    }
                }
                if (validate) {
                    $('#require_msg_' + que_id).remove();
                }
                break;
            case 'dropdownlist':
                if (is_required == 1) {
                    if ($('.' + que_id).val() == 0 || $('.' + que_id).val() == 'selection_default_value_dropdown') {
                        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                            if (lengthValidationMsg == 0) {
                                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'> ' + req_msg + '</div>');
                            }
                        }
                        validate = false;
                    }
                }
                // check other option is null or not
                if ($('.' + que_id).val())
                {
                    var value_selected = $('[value=' + $('.' + que_id).val() + ']').attr('class');
                }
                // check other option is null or not
                if ((value_selected == 'is_other_option' && !$('.' + que_id + '_other').val()))
                {
                    if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                        if (lengthValidationMsg == 0) {
                            $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>   ' + req_msg + '</div>');
                        }
                    }
                    validate = false;
                } else if (validate) {
                    $('#require_msg_' + que_id).remove();
                }
                break;
            case 'textbox':
                validate = textboxValiadation(que_id, is_required, min, max, maxsize, precision, advance_type, reg, lang_detail);
                break;
            case 'commentbox':
                validate = commentboxValidation(que_id, is_required, min, max, maxsize, precision, advance_type, lang_detail);
                break;
            case 'rating':
                validate = ratingValidation(que_id, is_required, lang_detail);
                break;
            case 'contact-information':
                validate = contactInformationValidation(que_id, is_required, advance_type, lang_detail);
                break;
            case 'date-time':
                validate = DateTimeValidation(que_id, is_required, min, max, is_datetime, lang_detail);
                break;
            case 'scale':
                validate = ScaleValidation(que_id, is_required, lang_detail);
                break;
            case 'netpromoterscore':
                validate = NPSValidation(que_id, is_required, lang_detail);
                break;
            case 'matrix':
                if ($('#' + que_id + '_div').parent('div').parent().css('display') !== 'none')
                {
                    validate = MatrixValidation(que_id, is_required, lang_detail);
                }
                break;
            case 'doc-attachment':
                if ($('#' + que_id + '_div').parent('div').parent().css('display') !== 'none')
                {
                    validate = AttachmentValidation(que_id, is_required, lang_detail);
                }
                break;
        }
    }
    if (validate == false) {
        if ($(document).find('.validation-tooltip').parent().parent().find('input')[1] != undefined) {
            $(document).find('.validation-tooltip').parent().parent().find('input')[1].focus();
        }
    }
    return validate;
}

function NPSValidation(que_id, is_required, lang_detail) {
    var validate = true;
    if (is_required == 1) {
        $('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').remove();
        if ($('#hidden_selected_values_id_' + que_id).val() == null || $('#hidden_selected_values_' + que_id).val() == null || $('#hidden_selected_values_id_' + que_id).val() == '' || $('#hidden_selected_values_' + que_id).val() == '') {
            if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
                    var req_msg = ' This question is mandatory, Please answer this question.';
                    if (lang_detail && lang_detail['required_msg'])
                    {
                        req_msg = lang_detail['required_msg'];
                    }
                    $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>' + req_msg + '</div>');
                }
            }
            validate = false;
        } else {
            $('#require_msg_' + que_id).remove();
        }
    }
    return validate;
}

// validate textbox of survey form
function textboxValiadation(que_id, is_required, min, max, maxsize, precision, datatype, reg, lang_detail) {
    var validate = true;
    // between limit message
    var limit_msg = 'Please enter Value between ' + min + '-' + max;
    if (lang_detail && lang_detail['limit_msg'])
    {
        limit_msg = lang_detail['limit_msg'];
        limit_msg = limit_msg.replace('$min', min);
        limit_msg = limit_msg.replace('$max', max);
    }
    // min limit msg
    var limit_min_msg = 'Value can not be less then ' + min;
    if (lang_detail && lang_detail['limit_min_msg'])
    {
        limit_min_msg = lang_detail['limit_min_msg'];
        limit_min_msg = limit_min_msg.replace('$min', min);
    }
    // max limit msg
    var limit_max_msg = 'Value can not be more then ' + min;
    if (lang_detail && lang_detail['limit_max_msg'])
    {
        limit_max_msg = lang_detail['limit_max_msg'];
        limit_max_msg = limit_max_msg.replace('$max', max);
    }
    // precision limit msg
    var limit_precision_msg = 'You can enter maximum ' + precision + ' precision point.';
    if (lang_detail && lang_detail['limit_precision_msg'])
    {
        limit_precision_msg = lang_detail['limit_precision_msg'];
        limit_precision_msg = limit_precision_msg.replace('$precision', precision);
    }
    // max_msg limit msg
    var max_msg = 'Maximum length ' + maxsize + ' character';
    if (lang_detail && lang_detail['max_msg'])
    {
        max_msg = lang_detail['max_msg'];
        max_msg = max_msg.replace('$maxsize', maxsize);
    }
    // email msg
    var invalid_email_msg = 'Please enter correct Email Address.';
    if (lang_detail && lang_detail['invalid_email_msg'])
    {
        invalid_email_msg = lang_detail['invalid_email_msg'];
    }

    var lengthValidationMsg = $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length;

    $('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').remove();

    var numchk = new RegExp("^[0-9]*$");
    var valueNum = $('.' + que_id).val();
    if (datatype === 'Integer' && $('.' + que_id).val() !== '' && $('.' + que_id).val() !== null && !numchk.test(valueNum)) {
        $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').remove();
        var req_msg = 'This question must have only numeric value.';
        if (lang_detail && lang_detail['required_msg'])
        {
            req_msg = lang_detail['required_msg'];
        }
        $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'> ' + req_msg + '</div>');
        validate = false;
    }

    var decimaCHK = new RegExp("^\\d+(\\.\\d+)?$");
    var valueDec = $('.' + que_id).val();
    if (datatype === 'Float' && $('.' + que_id).val() !== '' && $('.' + que_id).val() !== null && !decimaCHK.test(valueDec)) {
        $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').remove();
        var req_msg = 'This question must have only decimal value.';
        if (lang_detail && lang_detail['required_msg'])
        {
            req_msg = lang_detail['required_msg'];
        }
        $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'> ' + req_msg + '</div>');
        validate = false;
    }
    // not null validation 
    if (is_required == 1 && ($('.' + que_id).val() == null || $('.' + que_id).val() == '' || ($('.' + que_id).val() && $('.' + que_id).val().trim() == ''))) {
        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
            if (lengthValidationMsg == 0) {
                var req_msg = ' This question is mandatory, Please answer this question.';
                if (lang_detail && lang_detail['required_msg'])
                {
                    req_msg = lang_detail['required_msg'];
                }
                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'> ' + req_msg + '</div>');
            }
        }
        validate = false;
    }
    // if interger or Float then minimum & maximum value validation
    else if ((datatype == 'Integer') && $('.' + que_id).val() && min != '' && max != '' && parseInt($('.' + que_id).val()) < parseInt(min) && numchk.test(valueNum)) {
        lengthValidationMsg = 0;
        $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').remove();
        //$('#require_msg_' + que_id).html('');
        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
            if (lengthValidationMsg == 0) {
                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'> ' + limit_msg + '</div>');

            }
        }
        validate = false;
    } //only min is given
    else if ((datatype == 'Integer') && $('.' + que_id).val() && min != '' && max == '' && parseInt($('.' + que_id).val()) < parseInt(min) && numchk.test(valueNum)) {
        lengthValidationMsg = 0;
        $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').remove();
        //$('#require_msg_' + que_id).html('');
        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
            if (lengthValidationMsg == 0) {
                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>   ' + limit_min_msg + '</div>');

            }
        }
        validate = false;
    }
    // if interger or Float then minimum & maximum value validation
    else if ((datatype == 'Integer') && $('.' + que_id).val() && min != '' && max != '' && parseInt($('.' + que_id).val()) > parseInt(max) && numchk.test(valueNum)) {
        lengthValidationMsg = 0;
        $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').remove();
        //$('#require_msg_' + que_id).html('');
        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
            if (lengthValidationMsg == 0) {
                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>  ' + limit_msg + ' </div>');

            }
        }
        validate = false;
    }
    // only max is given
    else if ((datatype == 'Integer') && $('.' + que_id).val() && min == '' && max != '' && parseInt($('.' + que_id).val()) > parseInt(max) && numchk.test(valueNum)) {
        lengthValidationMsg = 0;
        $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').remove();
        //$('#require_msg_' + que_id).html('');
        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
            if (lengthValidationMsg == 0) {
                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>    ' + limit_max_msg + '</div>');

            }
        }
        validate = false;
    }// both min & max given
    else if ((datatype == 'Float') && $('.' + que_id).val() && min != '' && max != '' && (parseFloat($('.' + que_id).val()) < parseFloat(min) || parseFloat($('.' + que_id).val()) > parseFloat(max)) && decimaCHK.test(valueDec)) {
        lengthValidationMsg = 0;
        $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').remove();
        //$('#require_msg_' + que_id).html('');
        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
            if (lengthValidationMsg == 0) {
                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>  ' + limit_msg + '</div>');

            }
        }
        validate = false;
    } // only min given
    else if ((datatype == 'Float') && $('.' + que_id).val() && min != '' && max == '' && parseFloat($('.' + que_id).val()) < parseFloat(min) && decimaCHK.test(valueDec)) {
        lengthValidationMsg = 0;
        $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').remove();
        //$('#require_msg_' + que_id).html('');
        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
            if (lengthValidationMsg == 0) {
                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>    ' + limit_min_msg + '</div>');

            }
        }
        validate = false;
    }
    // only max is given
    else if ((datatype == 'Float') && $('.' + que_id).val() && min == '' && max != '' && parseFloat($('.' + que_id).val()) > parseFloat(max) && decimaCHK.test(valueDec)) {
        lengthValidationMsg = 0;
        $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').remove();
        //$('#require_msg_' + que_id).html('');
        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
            if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>    ' + limit_max_msg + '</div>');

            }
        }
        validate = false;
    } else if (datatype == 'Float' && $('.' + que_id).val() && precision != '' && decimaCHK.test(valueDec)) {
        lengthValidationMsg = 0;
        $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').remove();
        //$('#require_msg_' + que_id).html('');
        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
            if (reg.test(parseFloat($('.' + que_id).val())) == false && lengthValidationMsg == 0) {
                if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
                    $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>   ' + limit_precision_msg + '</div>');
                }
                validate = false;
            }
        }

    }
    //Email validation
    else if (datatype == 'Email' && $('.' + que_id).val()) {
        lengthValidationMsg = 0;

        // $('#require_msg_' + que_id).html('');
        $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').remove();

        var re = new RegExp('^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$');
        if (re.test($('.' + que_id).val()) == false && lengthValidationMsg == 0) {
            if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
                    $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '_email_reg\'>   ' + invalid_email_msg + '</div>');
                }
            }
            validate = false;

        }

    }
    //max size validation
    else if (maxsize != null && $('.' + que_id).val() && $('.' + que_id).val().length > parseInt(maxsize)) {
        lengthValidationMsg = 0;
        $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').remove();
        //$('#require_msg_' + que_id).html('');
        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
            if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>   ' + max_msg + '</div>');
            }
        }
        validate = false;
    }
    if (validate) {
        $('#require_msg_' + que_id).remove();
        $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').remove();
    }
    return validate;
}

// validate comment textbox of survey form
function commentboxValidation(que_id, is_required, min, max, maxsize, precision, datatype, lang_detail) {
    var validate = true;
    // max_msg limit msg
    var max_msg = 'Maximum length ' + maxsize + ' character';
    if (lang_detail && lang_detail['max_msg'])
    {
        max_msg = lang_detail['max_msg'];
        max_msg = max_msg.replace('$maxsize', maxsize);
    }
    // not null validation
    $('#require_msg_' + que_id).remove();
    $('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').remove();
    if (is_required == 1 && ($('.' + que_id).val() == '' || ($('.' + que_id).val() && $('.' + que_id).val().trim() == ''))) {
        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
            if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
                var req_msg = ' This question is mandatory, Please answer this question.';
                if (lang_detail && lang_detail['required_msg'])
                {
                    req_msg = lang_detail['required_msg'];
                }
                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'> ' + req_msg + '</div>');
            }
        }
        validate = false;
    }
    // max allowed char validation
    else if (maxsize != null && $('.' + que_id).val().length > parseInt(maxsize)) {
        $('#require_msg_' + que_id).remove();
        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
            if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'> ' + max_msg + '</div>');
            }
        }
        validate = false;

    } else {
        $('#require_msg_' + que_id).remove();
    }
    return validate;
}

// validate rating of survey form
function ratingValidation(que_id, is_required, lang_detail) {
    var validate = true;
    if (is_required == 1) {
        $('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').remove();
        if ($('.' + que_id).val() == null || $('.' + que_id).val() == '') {
            if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
                    var req_msg = ' This question is mandatory, Please answer this question.';
                    if (lang_detail && lang_detail['required_msg'])
                    {
                        req_msg = lang_detail['required_msg'];
                    }
                    $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>' + req_msg + '</div>');
                }
            }
            validate = false;
        } else {
            $('#require_msg_' + que_id).remove();
        }
    }
    return validate;
}

// validate contact-information of survey form
function contactInformationValidation(que_id, is_required, requireFields, lang_detail) {

    var validate = true;
    var lengthValidationMsg = 0;
    // required msg
    var req_msg = 'This question is mandatory, Please answer this question.';
    if (lang_detail && lang_detail['required_msg'])
    {
        req_msg = lang_detail['required_msg'];
    }
    // valid phone no msg
    var invalid_phn_msg = 'Please enter proper Phone Number.';
    if (lang_detail && lang_detail['invalid_phn_msg'])
    {
        invalid_phn_msg = lang_detail['invalid_phn_msg'];
    }
    // email msg
    var invalid_email_msg = 'Please enter correct Email Address.';
    if (lang_detail && lang_detail['invalid_email_msg'])
    {
        invalid_email_msg = lang_detail['invalid_email_msg'];
    }

    if (is_required == 0 && (requireFields == null || requireFields == '')) {
        var flag = true;
        $('#require_msg_' + que_id + '_combine').remove();
        $('#require_msg_' + que_id + '_phone_reg').remove();
        $('#require_msg_' + que_id + '_email_reg').remove();
        /*if ($('.' + que_id + '_name').val() == '' || $('.' + que_id + '_phone').val() == '' || $('.' + que_id + '_email').val() == '') {
            if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
                    $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '_combine\'>' + req_msg + '</div>');
                }
            }
            flag = false;
        } else {
            $('#require_msg_' + que_id + '_combine').remove();
         }*/
        if ($('.' + que_id + '_phone').val() != '' || ($('.' + que_id + '_phone').val() && $('.' + que_id + '_phone').val().trim() != '')) {
            if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                var re = new RegExp('^[0-9-+]+$');
                if (re.test($('.' + que_id + '_phone').val()) == false) {
                    if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
                        $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '_phone_reg\'>' + invalid_phn_msg + '</div>');
                    }
                    flag = false;
                }
            }

        }
        if ($('.' + que_id + '_email').val() != '' || ($('.' + que_id + '_email').val() && $('.' + que_id + '_email').val().trim() != '')) {
            if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                var re = new RegExp('^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$');
                if (re.test($('.' + que_id + '_email').val()) == false) {
                    if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
                        $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '_email_reg\'> ' + invalid_email_msg + '</div>');
                    }
                    flag = false;
                }
            }
            
        }
        if (flag == false) {
            validate = false;
        }
    } else if (is_required == 1 && (requireFields != null || requireFields != '')) {
        requireFields = requireFields.split(' ');
        $.makeArray(requireFields);
        var flag = true;
        $('#require_msg_' + que_id + '_combine').remove();
        $('#require_msg_' + que_id + '_phone_reg').remove();
        $('#require_msg_' + que_id + '_email_reg').remove();
        //require validation for given fields
        $.each(requireFields, function (key, field) {
            if (field != null && field != '') {
                if ($('.' + que_id + '_' + field.toLowerCase()).val() == '' || $('.' + que_id + '_' + field.toLowerCase()).val() == null || ($('.' + que_id + '_' + field.toLowerCase()).val() && $('.' + que_id + '_' + field.toLowerCase()).val().trim() == '')) {
                    if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
                        $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '_combine\'>  ' + req_msg + '</div>');
                    }
                    flag = false;
                }
            }
        });

        var validationMsgForRequiredField = $('#require_msg_' + que_id + '_combine').length;
        if ($.inArray("Phone", requireFields) != -1 && $('.' + que_id + '_phone').val() != '') {
            if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                var re = new RegExp('^[0-9-+]+$');
                if (re.test($('.' + que_id + '_phone').val()) == false && validationMsgForRequiredField == 0) {
                    if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
                        $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '_phone_reg\'>  ' + invalid_phn_msg + '</div>');
                    }
                    flag = false;

                }
            }
        }
        if ($.inArray("Email", requireFields) != -1 && $('.' + que_id + '_email').val() != '') {
            if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                var re = new RegExp('^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$');
                if (re.test($('.' + que_id + '_email').val()) == false && validationMsgForRequiredField == 0) {
                    if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
                        $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '_email_reg\'>  ' + invalid_email_msg + '</div>');
                    }
                    flag = false;
                }
            }
        }
        if (flag == false) {
            validate = false;
        } else {
            $('#require_msg_' + que_id + '_combine').remove();
            $('#require_msg_' + que_id + '_phone_reg').remove();
            $('#require_msg_' + que_id + '_email_reg').remove();
        }
    }
    return validate;
}

// validate date-time of survey form
function DateTimeValidation(que_id, is_required, min, max, is_datetime, lang_detail) {

    //range msg   
    var range_msg = 'Date can be between  ' + min + ' to ' + max;
    if (lang_detail && lang_detail['range_msg'])
    {
        range_msg = lang_detail['range_msg'];
        range_msg = range_msg.replace('$min', min);
        range_msg = range_msg.replace('$max', max);
    }
    //after msg   
    var start_date_msg = 'Please enter date after ' + min;
    if (lang_detail && lang_detail['start_date_msg'])
    {
        start_date_msg = lang_detail['start_date_msg'];
        start_date_msg = range_msg.replace('$min', min);
    }
    //before msg
    var end_date_msg = 'Please enter date before ' + max;
    if (lang_detail && lang_detail['end_date_msg'])
    {
        end_date_msg = lang_detail['end_date_msg'];
        end_date_msg = end_date_msg.replace('$max', max);
    }

    // cretae unique format to check date
    var mindate = new Date(min);
    var maxdate = new Date(max);

    if (mindate.getDate() < 10 && (mindate.getMonth() + 1) < 10) {
//        var compare_min_date = ''+0 + (mindate.getDate()) + '/' + 0 + (mindate.getMonth() + 1) + '/' + mindate.getFullYear();
        var compare_min_date = mindate.getFullYear() + '/' + 0 + (mindate.getMonth() + 1) + '/' + 0 + (mindate.getDate());
    } else if (mindate.getDate() >= 10 && (mindate.getMonth() + 1) < 10) {
//        var compare_min_date = mindate.getDate() + '/' + 0 + (mindate.getMonth() + 1) + '/' + mindate.getFullYear();
        var compare_min_date = mindate.getFullYear() + '/' + 0 + (mindate.getMonth() + 1) + '/' + mindate.getDate();
    } else if (mindate.getDate() < 10 && (mindate.getMonth() + 1) >= 10) {
//        var compare_min_date = +0 + (mindate.getDate()) + '/' + (mindate.getMonth() + 1) + '/' + mindate.getFullYear();
        var compare_min_date = mindate.getFullYear() + '/' + (mindate.getMonth() + 1) + '/' + 0 + (mindate.getDate());
    } else {
//        var compare_min_date = mindate.getDate() + '/' + (mindate.getMonth() + 1) + '/' + mindate.getFullYear();
        var compare_min_date = mindate.getFullYear() + '/' + (mindate.getMonth() + 1) + '/' + mindate.getDate();
    }
////    var compare_min_date = mindate.getMonth()+1 + '/' + mindate.getDate() + '/' + mindate.getFullYear();
//    var compare_min_date = mindate.getDate() + '/' + (mindate.getMonth() + 1) + '/' + mindate.getFullYear();
////    var compare_max_date = maxdate.getMonth()+1 + '/' + maxdate.getDate() + '/' + maxdate.getFullYear();
//    var compare_max_date = maxdate.getDate() + '/' + (maxdate.getMonth() + 1) + '/' + maxdate.getFullYear();


    if (maxdate.getDate() < 10 && (maxdate.getMonth() + 1) < 10) {
//        var compare_max_date = ''+ 0+(maxdate.getDate()) + '/' + 0 +(maxdate.getMonth() + 1) + '/' + maxdate.getFullYear();
        var compare_max_date = maxdate.getFullYear() + '/' + 0 + (maxdate.getMonth() + 1) + '/' + 0 + (maxdate.getDate());
    } else if (maxdate.getDate() >= 10 && (maxdate.getMonth() + 1) < 10) {
//        var compare_max_date = maxdate.getDate() + '/' + 0 +(maxdate.getMonth() + 1) + '/' + maxdate.getFullYear();
        var compare_max_date = maxdate.getFullYear() + '/' + 0 + (maxdate.getMonth() + 1) + '/' + (maxdate.getDate());
    } else if (maxdate.getDate() < 10 && (maxdate.getMonth() + 1) >= 10) {
//        var compare_max_date = ''+0 +maxdate.getDate() + '/' + (maxdate.getMonth() + 1) + '/' + maxdate.getFullYear();
        var compare_max_date = maxdate.getFullYear() + '/' + (maxdate.getMonth() + 1) + '/' + 0 + (maxdate.getDate());
    } else {
//        var compare_max_date = maxdate.getDate() + '/' + (maxdate.getMonth() + 1) + '/' + maxdate.getFullYear();
        var compare_max_date = maxdate.getFullYear() + '/' + (maxdate.getMonth() + 1) + '/' + (maxdate.getDate());
    }

    var validate = true;
    $('#require_msg_' + que_id).remove();
    var current_date_value = new Date($('.' + que_id + '_datetime').val());
//    var current_date = current_date_value.getDate() + '/' + (current_date_value.getMonth() + 1) + '/' + current_date_value.getFullYear();

    if (current_date_value.getDate() < 10 && (current_date_value.getMonth() + 1) < 10) {
//        var current_date = ''+0+(current_date_value.getDate()) + '/' + 0+(current_date_value.getMonth() + 1) + '/' + current_date_value.getFullYear();
        var current_date = current_date_value.getFullYear() + '/' + 0 + (current_date_value.getMonth() + 1) + '/' + 0 + (current_date_value.getDate());
    } else if (current_date_value.getDate() >= 10 && (current_date_value.getMonth() + 1) < 10) {
//        var current_date = current_date_value.getDate() + '/' + 0+(current_date_value.getMonth() + 1) + '/' + current_date_value.getFullYear();
        var current_date = current_date_value.getFullYear() + '/' + 0 + (current_date_value.getMonth() + 1) + '/' + (current_date_value.getDate());
//    } else if (current_date_value.getDate() < 10 && (current_date_value.getMonth() + 1) > 10) {
    } else if (current_date_value.getDate() < 10 && (current_date_value.getMonth() + 1) >= 10) {
//        var current_date = ''+0+(current_date_value.getDate()) + '/' + (current_date_value.getMonth() + 1) + '/' + current_date_value.getFullYear();
        var current_date = current_date_value.getFullYear() + '/' + (current_date_value.getMonth() + 1) + '/' + 0 + (current_date_value.getDate());
    } else {
//        var current_date = current_date_value.getDate() + '/' + (current_date_value.getMonth() + 1) + '/' + current_date_value.getFullYear();
        var current_date = current_date_value.getFullYear() + '/' + (current_date_value.getMonth() + 1) + '/' + (current_date_value.getDate());
    }
    // var compare_min_date = new Date(min);
    // var compare_max_date = new Date(max);
    $('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').remove();
    //Is required validation


    if (is_required == 1 && $('.' + que_id + '_datetime').val() == '') {
        if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
            if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0) {
                var req_msg = ' This question is mandatory, Please answer this question.';
                if (lang_detail && lang_detail['required_msg'])
                {
                    req_msg = lang_detail['required_msg'];
                }
                $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>' + req_msg + '</div>');
            }
        }
        validate = false;
    }


    // Start date validation
    else if ($('.' + que_id + '_datetime').val() && min != '' && max != '' && (current_date < compare_min_date || current_date > compare_max_date)) {
        if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
            $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '_datemin\'>   ' + range_msg + '</div>');
        }
        validate = false;
    } else if ($('.' + que_id + '_datetime').val() && min != '' && max == '' && current_date < compare_min_date) {
        if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
            $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '_datemin\'>    ' + start_date_msg + '</div>');
        }
        validate = false;
    }
    // End date validation
    else if ($('.' + que_id + '_datetime').val() && max != '' && min != '' && (current_date < compare_min_date || current_date > compare_max_date)) {
        if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
            $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '_datemax\'>   ' + range_msg + '</div>');
        }
        validate = false;
    } else if ($('.' + que_id + '_datetime').val() && min == '' && max != '' && current_date > compare_max_date) {
        if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
            $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '_datemin\'>  ' + end_date_msg + '</div>');
        }
        validate = false;
    } else {
        $('#require_msg_' + que_id).remove();
        $('#require_msg_' + que_id + '_datemin').remove();
        $('#require_msg_' + que_id + '_datemax').remove();
    }

    if (validate)
    {
        $('#require_msg_' + que_id).remove();
        $('#require_msg_' + que_id + '_datemin').remove();
        $('#require_msg_' + que_id + '_datemax').remove();
    }
    return validate;
}

// validate scale of survey form
function ScaleValidation(que_id, is_required, lang_detail) {
    var validate = true;
    var lengthValidationMsg = 0;
    if (is_required == 1) {
        $('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').remove();
        if (($('.' + que_id).find('.tooltip-score').length == 1 && ($('.' + que_id).find('.tooltip-score').text() == null || $('.' + que_id).find('.tooltip-score').text() == ''))) {
            if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                if (lengthValidationMsg == 0) {
                    var req_msg = ' This question is mandatory, Please answer this question.';
                    if (lang_detail && lang_detail['required_msg'])
                    {
                        req_msg = lang_detail['required_msg'];
                    }
                    $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>  ' + req_msg + '</div>');
                }
            }
            validate = false;
        } else {
            $('#require_msg_' + que_id).remove();
        }
        if (($('.' + que_id).find('.tooltip-score').length == 0 && $('.' + que_id).find('.tooltip').length == 1 && ($('.' + que_id).find('.tooltip').text() == null || $('.' + que_id).find('.tooltip').text() == ''))) {
            if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                if (lengthValidationMsg == 0) {
                    var req_msg = ' This question is mandatory, Please answer this question.';
                    if (lang_detail && lang_detail['required_msg'])
                    {
                        req_msg = lang_detail['required_msg'];
                    }
                    $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>  ' + req_msg + '</div>');
                }
            }
            validate = false;
        } else if (validate) {
            $('#require_msg_' + que_id).remove();
        }
    }
    return validate;
}

// validate matrix of survey form
function MatrixValidation(que_id, is_required, lang_detail) {
    // required msg
    var matrix_required_msg = ' This question require one answer per row.';
    if (lang_detail && lang_detail['matrix_required_msg'])
    {
        matrix_required_msg = lang_detail['matrix_required_msg'];
    }
    var validate = true;
    var lengthValidationMsg = 0;
    if (is_required == 1) {
        $('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').remove();
        $('.' + que_id + '_matrix').each(function (key, val) {

            var row = $(this).attr('value');
            if ($('.' + que_id + '_matrix').parent().find('[name="' + que_id + '[' + row + '][]"]:checked').length == 0) {
                if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                    if (lengthValidationMsg == 0) {
                        $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>   ' + matrix_required_msg + '</div>');
                    }
                }
                validate = false;
            } else {
                $('#require_msg_' + que_id).remove();
            }
        });
    }
    if (validate == false) {
        $('#' + que_id + '_div').parent('div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>   ' + matrix_required_msg + '</div>');
    }
    return validate;
}

// validate Attachment of survey form
function AttachmentValidation(que_id, is_required, lang_detail) {
    var validate = true;
    if (is_required == 1) {
        $('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').remove();
        if ($('#' + que_id + '_div').find('.file_uploaded').find('span').text() == "") {
            if ($('#' + que_id + '_div').parent('div').children('h3').children('span:nth-child(2)').html() == undefined) {
                if ($('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').length == 0 || $('#' + que_id + '_div').parent('div').children('h3').find('.validation-tooltip').css('display') == 'none') {
                    var req_msg = ' This question is mandatory, Please Upload File.';
                    if (lang_detail && lang_detail['required_msg'])
                    {
                        req_msg = lang_detail['required_msg'];
                    }
                    $('#' + que_id + '_div').parent('div').children('h3').append('<div class="validation-tooltip" style=\'color:red;display: inline-table;\' id=\'require_msg_' + que_id + '\'>' + req_msg + '</div>');
                }
            }
            validate = false;
        } else {
            $('#require_msg_' + que_id).remove();
        }
    }
    return validate;
}

// help tips layout for survey form
function openHelpTipsPopUpSurvey(el, helpCommentText) {
    var offset_Question = $(el).offset();
    $('.customClassForTooltip').fadeIn();
    $('#tooltipDiv').dialog({
        dialogClass: 'customClassForTooltip',
        draggable: false,
        resizable: false,
        width: 500,
    });
    $('#tooltipDiv').html(helpCommentText);
    $('#tooltipDiv').css('min-height', '');
    $('.customClassForTooltip').css('top', offset_Question.top - 10);
    $('.customClassForTooltip').css('left', offset_Question.left + 40);
    $('.customClassForTooltip').css('height', 'auto');
    $('.customClassForTooltip').css('float', 'right');
    $('.customClassForTooltip').css('width', 'auto');
    $('.customClassForTooltip').css('display', 'block');
    $('.customClassForTooltip').css('font-size', '12px');
    $('.customClassForTooltip').css('color', 'white');
    $('.customClassForTooltip').css('background', '#000');
    $('.customClassForTooltip').find('.ui-dialog-titlebar').remove();
}

function openFileUploadPopUpSurvey(el, target) {
    var offset_Question = $(el).offset();
    $('.customClassForTooltip').fadeIn();
    $('#tooltipDiv').dialog({
        dialogClass: 'customClassForTooltip',
        draggable: false,
        resizable: false,
        width: 500,
    });
    var helpCommentText = 'Please upload file from below given filetypes [' + target + ']';
    $('#tooltipDiv').html(helpCommentText);
    $('#tooltipDiv').css('min-height', '');
    $('.customClassForTooltip').css('top', offset_Question.top - 10);
    $('.customClassForTooltip').css('left', offset_Question.left + 40);
    $('.customClassForTooltip').css('height', 'auto');
    $('.customClassForTooltip').css('float', 'right');
    $('.customClassForTooltip').css('width', 'auto');
    $('.customClassForTooltip').css('display', 'block');
    $('.customClassForTooltip').css('font-size', '12px');
    $('.customClassForTooltip').css('color', 'white');
    $('.customClassForTooltip').css('background', '#000');
    $('.customClassForTooltip').find('.ui-dialog-titlebar').remove();
}

// hide helptips of mouse out
function removeHelpTipPopUpDiv() {
    $('.customClassForTooltip').fadeOut();
}

// select deselect reminder list record
function selectDeselectReminderChk() {
    $('.reminder_chk').each(function () {
        if ($('.reminder_chkAll').is(":checked")) {
            $(this).prop('checked', true);
        } else {
            $(this).prop('checked', false);
        }
    });
}

//validate email template body fields
function validateBody() {
    //check survey link is added to email body or not
    var _form = document.getElementById('EditView');
    _form.action.value = 'Save';
    if (check_form('EditView')) {

        var flag = false;
        var link_status = window.tinyMCE.get('body_text')['contentDocument'].getElementById('survey_link'); // survey link element
        var link_edit_status = window.tinyMCE.get('body_text')['contentDocument'].getElementById('sugar_text_survey_link'); // survey link element
        var survey = $('#survey_id').val();

        if (survey != '') {
            if (link_status == null || link_status == '') { //survey link not added to email body
                if (link_edit_status == null || link_edit_status == '') { // survey link not added to email body ( Edit mode)
                    $('#survey_insert_btn_msg').text('Survey link not added to email template. Please insert.').css({
                        'font-size': '12px',
                        'font-weight': 'normal',
                        'color': 'red'
                    }); // validation message
                    $('#survey_insert_btn_msg').show();
                    flag = false;
                } else {
                    flag = true;
                }
            } else {
                flag = true;
            }
        } else {
            flag = true;
        }
    }

    if (flag) { // if survey link added then submit form
        return SUGAR.ajaxUI.submitForm(_form);
    }
    return false;
}

// insert survey link to email body
function insertSurveyUrlLinkEmailTemplate() {

    var surveyUrlPart = document.getElementById('survey_url_link').value;
    var surveyID = document.getElementById('survey_id').value;
    var surveyUrl = '<a id="survey_link" href="' + surveyUrlPart + "SURVEY_PARAMS" + '">click here</a>';

    var link_status = window.tinyMCE.get('body_text')['contentDocument'].getElementById('survey_link'); // survey link element
    var link_edit_status = window.tinyMCE.get('body_text')['contentDocument'].getElementById('sugar_text_survey_link'); // survey link element

    if (surveyID == '') {
        $('#survey_insert_btn_msg').text('You must select survey for insert survey link.').css({
            'font-size': '12px',
            'font-weight': 'normal',
            'color': 'red'
        });
        $('#survey_insert_btn_msg').show();
    } else {
        $('#survey_insert_btn_msg').hide();
        var url = app.api.buildURL("bc_survey", "checkEmailTemplateForSurvey", "", {survey_ID: surveyID});
        app.api.call('GET', url, {}, {
            success: function (result) {
                var current_record = $('[name=record]').val();
                if ($(link_status).html() != "click here" && $(link_edit_status).html() != "click here" && (current_record == result || result == ''))
                {
                    var inst = tinyMCE.getInstanceById("body_text");
                    if (inst)
                        inst.getWin().focus();
                    inst.execCommand('mceInsertRawHTML', false, surveyUrl);
                } else if ($(link_status).html() != "click here" && $(link_edit_status).html() != "click here" && current_record != result && result != '')
                {
                    $('#survey_insert_btn_msg').text('Email template has already created for this survey.').css({
                        'font-size': '12px',
                        'font-weight': 'normal',
                        'color': 'red'
                    });
                    $('#survey_insert_btn_msg').show();
                } else if (result.trim() != '') {
                    $('#survey_insert_btn_msg').text('Email template has already created for this survey.').css({
                        'font-size': '12px',
                        'font-weight': 'normal',
                        'color': 'red'
                    });
                    $('#survey_insert_btn_msg').show();
                } else {
                    var inst = tinyMCE.getInstanceById("body_text");
                    if (inst)
                        inst.getWin().focus();
                    inst.execCommand('mceInsertRawHTML', false, surveyUrl);
                }
            }
        });
    }
}

// remove customer summary popup
function removeCustomerSummaryPopUp() {
    $('.dialog_style,#customerMailPopup').remove();
}

// on document ready perfoem action
$(document).ready(function () {
    // Check current module in email template or not and validation email template body
    if ($('[name="return_module"]').val() == 'EmailTemplates') {

        $("#SAVE").attr('onclick', "this.form.action.value='Save';addUploadFiles('EditView');addUploadDocs('EditView'); return validateBody();");

        if ($('#survey_module_type').val() == 'Leads' || $('#survey_module_type').val() == 'Contacts' || $('#survey_module_type').val() == 'Prospects') {
            $('[name="variable_module"]').val("Contacts").prop("selected", "selected");
            $('[name="variable_module"]').trigger('change');
        }

        //Automatic selection of variable module as per Survey Module changed
        $('#survey_module_type').change(function () {
            this.value;
            if (this.value != "Accounts") {
                $('[name="variable_module"]').val("Contacts").prop("selected", "selected");
                $('[name="variable_module"]').trigger('change');
            } else {
                $('[name="variable_module"]').val("Accounts").prop("selected", "selected");
                $('[name="variable_module"]').trigger('change');
            }
        });
    }
}
);

/*
 * Apply Global Filter on click of apply button :: Survey Report
 */
function ApplyGlogalFilter() {
    var active_report = 'question_wise';
    if ($('.individual_report_heading').hasClass('active')) {
        active_report = 'individual';
    } else if ($('.question_report_heading').hasClass('active')) {
        active_report = 'question_wise';
    }
    var exportfrom = 'combined';
    var reportType = $('#current_active_report_tab').val();
    if (typeof $('#' + reportType + '_report_data_section') !== 'undefined') {
        $('#' + reportType + '_report_data_section').find('.accordion-inner').each(function () {
            if ($(this).is(":hidden") === false) {
                var id_split = $(this).attr('id').split('_');
                exportfrom = id_split[3];
            }
        });
    }
    var GF_Filter_By = $('#question_report_data_' + exportfrom).find('[name=global_filter_selection]').val();
    var start_date = $('[name=global_start_date]').val();
    var end_date = $('[name=global_end_date]').val();
    if (!start_date && !end_date && GF_Filter_By == 'by_date') {
        App.alert.show('global_filter_error', {
            level: 'error',
            title: '',
            messages: 'Please provide atleast one of the dates to apply global filter',
            autoClose: true
        });
    }
    var date_validation = true;
    if (start_date && end_date && (App.date.compare(App.date(start_date), App.date(end_date)) >= 1)) {
        date_validation = false;
        App.alert.show('global_filter_error', {
            level: 'error',
            title: '',
            messages: 'The End Date must be after the Start Date',
            autoClose: true
        });
    }
    if (date_validation && GF_Filter_By == 'by_date') {
        if (start_date || end_date) {
            if (active_report == 'question_wise') {
                $("#globalFilterbackgroundpopup").fadeOut(function () {
                    $("#global_filter_main_div").hide();
                });
                $("#global_filter_main_div").fadeOut(function () {
                    $("#global_filter_main_div").hide();
                });
                var isApplyGlobalFilter = $('#content').find('[name=isApplyGlobalFilter]').length;
                if (isApplyGlobalFilter == 0) {
                    $('#content').append('<input type="hidden" name="isApplyGlobalFilter" value="1" />');
                } else {
                    $('#content').find('[name=isApplyGlobalFilter]').val('1');
                }
                $('.question_combined').trigger('click');
            }
            if (active_report == 'individual') {
                $("#globalFilterbackgroundpopup").fadeOut(function () {
                    $("#global_filter_main_div").hide();
                });
                $("#global_filter_main_div").fadeOut(function () {
                    $("#global_filter_main_div").hide();
                });
                var isApplyGlobalFilter = $('#content').find('[name=isApplyGlobalFilter]').length;
                if (isApplyGlobalFilter == 0) {
                    $('#content').append('<input type="hidden" name="isApplyGlobalFilter" value="1" />');
                } else {
                    $('#content').find('[name=isApplyGlobalFilter]').val('1');
                }
                $('.question_combined').trigger('click');
                $('.individual_report_heading').trigger('click');
            }
        }
    }
    if (date_validation && GF_Filter_By == 'by_question_logic') {
        var validated_logic = true;
        $.each($('.thumbnail_logic_section'), function () {
            // checkbox type
            var seqArr = $(this).attr('id').split('_');
            var seq = seqArr[3];
            if ($(this).find('#global_logic_que_' + seq).val() == 0) {
                validated_logic = false;
            }
            if ($(this).find('[name=logic_value_' + seq + ']').val() == '') {
                validated_logic = false;
            }
            if ($(this).find('[name=logic_operator_' + seq + ']').val() == 'between' || $(this).find('[name=logic_operator_' + seq + ']').val() == 'not_between') {
                validated_logic = true;
                if ($(this).find('[name=between_notbetween_start_logic_value_' + seq + ']').val() == '') {
                    validated_logic = false;
                }
                if ($(this).find('[name=between_notbetween_end_logic_value_' + seq + ']').val() == '') {
                    validated_logic = false;
                }
            }
            if ($(this).find('input[type=checkbox]').length != 0) {
                if ($(this).find('input[type=checkbox]:checked').length == 0) {
                    validated_logic = false;
                }
            }
            // input type text
            else if ($(this).find('input[type=text]').length == 1) {
                if ($(this).find('input').val() == '') {
                    validated_logic = false;
                }
            }
        });
        // validation required
        if (!validated_logic) {
            App.alert.show('global_filter_error', {
                level: 'error',
                title: '',
                messages: 'Please make sure you have selected a question and its corresponding logic. ',
                autoClose: true
            });
        } else {
            if (active_report == 'question_wise') {
                $("#globalFilterbackgroundpopup").fadeOut(function () {
                    $("#global_filter_main_div").hide();
                });
                $("#global_filter_main_div").fadeOut(function () {
                    $("#global_filter_main_div").hide();
                });
                var isApplyGlobalFilter = $('#content').find('[name=isApplyGlobalFilter]').length;
                if (isApplyGlobalFilter == 0) {
                    $('#content').append('<input type="hidden" name="isApplyGlobalFilter" value="1" />');
                } else {
                    $('#content').find('[name=isApplyGlobalFilter]').val('1');
                }
                $('.question_combined').trigger('click');
            }
            if (active_report == 'individual') {
                $("#globalFilterbackgroundpopup").fadeOut(function () {
                    $("#global_filter_main_div").hide();
                });
                $("#global_filter_main_div").fadeOut(function () {
                    $("#global_filter_main_div").hide();
                });
                var isApplyGlobalFilter = $('#content').find('[name=isApplyGlobalFilter]').length;
                if (isApplyGlobalFilter == 0) {
                    $('#content').append('<input type="hidden" name="isApplyGlobalFilter" value="1" />');
                } else {
                    $('#content').find('[name=isApplyGlobalFilter]').val('1');
                }
                $('.individual_report_heading').trigger('click');
            }
        }
    }
}
/*
 * On click of Question logic provide options based on que type
 */
function getLogicQueWise(el, format) {
    var que_id = $(el).val();
    var logic_seq = $(el).attr('id').split('global_logic_que_')[1];
    if (que_id) {
        // based on selected question show logic section
        var url = App.api.buildURL("bc_survey", "generateQueLogicSection", "", {que_id: que_id, logic_seq: logic_seq});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data && data['html']) {
                    $(el).parents('#global_logic_row_' + logic_seq).find('.logic_answer_section').replaceWith(data['html']);
                    var options = {
                        format: format
                    };
                    $('.show_datepicker').datepicker(options);

                    options = {
                        timeFormat: 'H:i',
                        step: 1,
                        disableTextInput: true
                    };
                    $('.show_timepicker').timepicker(options);
                    // Adjust Date picker on scroll
                    $('.middle-content').scroll(function () {
                        // make sure the dom element exists before trying to place the datepicker
                        $('.datepicker').datepicker('place');
                    });
                    // Hide time picker on scroll
                    $('.middle-content').scroll(function () {
                        // make sure the dom element exists before trying to place the datepicker
                        $('.ui-timepicker-wrapper').hide();
                    });
                    $('.logic_checkbox').on('click', function () {
                        if ($(this).parent().find('input[type=checkbox]:checked').length == 1) {
                            $(this).parent().find('input[type=checkbox]').prop('checked', false);
                        } else {
                            $(this).parent().find('input[type=checkbox]').prop('checked', true);
                        }
                    });
                } else {
                    // If no question selected then hide logic section
                    $(el).parents('#global_logic_row_' + logic_seq).find('.logic_answer_section').html('');
                    $(el).parents('.middle-content').find('#que_logic_answer_' + logic_seq).slideUp();
                    $(el).parents('.middle-content').find('#' + logic_seq + '.dropdown-toggle').parents('#global_logic_row_' + logic_seq).find('.page_toggle').children()[0].className = "fa fa-chevron-up";
                }
            }
        });
    } else {
        // If no question selected then hide logic section
        $(el).parents('#global_logic_row_' + logic_seq).find('.logic_answer_section').html('');
        $(el).parents('.middle-content').find('#que_logic_answer_' + logic_seq).slideUp();
        $(el).parents('.middle-content').find('#' + logic_seq + '.dropdown-toggle').parents('#global_logic_row_' + logic_seq).find('.page_toggle').children()[0].className = "fa fa-chevron-up";
    }
}
/**
 * collapse page
 * 
 * @el current element
 */
function collapsePage(el) {
    var id = $(el).attr('id');
    var toogle = true;
    var qln = $(el).parents('#global_logic_row_' + id).find('[name=logic_operator_' + id + ']').length;
    if (qln == 0 || typeof qln == 'undefined') {
        toogle = false;
    }
    if (toogle === true) {
        $(el).parents('.middle-content').find('#que_logic_answer_' + id).slideToggle();
        var childId = id - 1;
        var flag = 0;
        var icon_class_name = $(el).parents('.middle-content').find('#' + id).parents('.thumbnail').find('.page_toggle').children()[0].className;
        if (icon_class_name == 'fa fa-chevron-down') {
            flag = 1;
        } else if (icon_class_name == 'fa fa-chevron-up') {
            flag = 0;
        }
        if (flag == 0) {
            $(el).parents('.middle-content').find('#' + id + '.dropdown-toggle').parents('#global_logic_row_' + id).find('.page_toggle').children()[0].className = "fa fa-chevron-down";
        } else {
            $(el).parents('.middle-content').find('#' + id + '.dropdown-toggle').parents('#global_logic_row_' + id).find('.page_toggle').children()[0].className = "fa fa-chevron-up";
        }
    }
}
/*
 * Add Question Logic Section 
 */
function add_question_logic(el, sid) {
    App.alert.show('loading_que_logic_view', {level: 'process', title: 'Loading', autoclose: false});
    var current_logic_id = $('.thumbnail:last').attr('id').split('global_logic_row_')[1];
    var next_logic_id = parseInt(current_logic_id) + 1;
    question_logic(el, sid, next_logic_id, true);
}
/*
 * Reset Question logic section
 */
function reset_question_logic(el, sid) {
    App.alert.show('loading_que_logic_view', {level: 'process', title: 'Loading', autoclose: false});
    var next_logic_id = 1;
    question_logic(el, sid, next_logic_id, false);
}

function question_logic(el, sid, next_logic_id, isShowClose) {
    var showClose = '';
    if (!isShowClose) {
        showClose = 'display:none;';
    }

    var html = '';
    // Retrieve all questions for Question Logic
    var url = App.api.buildURL("bc_survey", "getAllSurveyQuestions", "", {record_id: sid});
    App.api.call('GET', url, {}, {
        success: function (data) {
            if (data) {
                var length = $(el).parents('#global_filter_report').find('.global_logic_section').find('.thumbnail_logic_section').length;
                if (length === 1) {
                    var elID = parseInt(next_logic_id - 1);
                    $(el).parents('#global_filter_report').find('.global_logic_section').find('.thumbnail_logic_section').find('#' + elID + '_close').show();
                }
                // Survey Questions
                var options_que_list = '<option value="0">Select survey question</option>';
                $.each(data, function (k, que_data) {
                    options_que_list += '<option value="' + que_data['que_id'] + '">' + que_data['que_title'] + ' </option>';
                });
                // add new logic
                html += '<div id="global_logic_row_' + next_logic_id + '" class="thumbnail thumbnail_logic_section dashlet ui-draggable" data-type="dashlet" data-action="droppable">';
                html += '<div data-dashlet="toolbar"> ';
                html += '        <div class="dashlet-header">';
                html += '                <div class="btn-toolbar pull-right">';
                html += '                        <div class="btn-group" style="margin-top:5px;">';
                html += '                                <a id="' + next_logic_id + '" data-toggle="dropdown" rel="tooltip" title="" class="dropdown-toggle btn btn-invisible page_toggle" onclick="collapsePage(this);" data-placement="bottom" data-original-title="Toggle Visibility"><i data-action="loading" class="fa fa-chevron-up" track="click:dashletToolbarCog"></i></a>';
                html += '                                <a style="' + showClose + '" id="' + next_logic_id + '_close" data-toggle="dropdown" rel="tooltip" title="" class="remove-glb-filter-row dropdown-toggle btn btn-invisible page_toggle" onclick="removeCurrentFilterBox(this);" data-placement="bottom" data-original-title="Remove"><i data-action="loading" class="fa fa-times-circle"></i></a>';
                html += '                        </div>';
                html += '                </div>';
                html += '                <h4 data-toggle="dashlet" style="min-height:20px; background-color: #c5c5c5; padding: 7px 0px 0px 10px;" class="dashlet-title">      ';
                html += '                        <div class="">   <span style="font-size: 12px; vertical-align: text-top;">Question : </span>  ';
                html += "                                <select class='global_logic_que' id='global_logic_que_" + next_logic_id + "' onchange='getLogicQueWise(this)'>" + options_que_list + "</select> ";
                html += '                        </div> ';
                html += '                </h4>';
                html += '        </div>';
                html += '</div>';
                html += '<div id="que_logic_answer_' + next_logic_id + '" class="data-page ui-droppable ui-sortable logic_answer_section" data-dashlet="dashlet">';
                html += '</div>';
                if (next_logic_id == 1) {
                    $('.global_logic_section').html(html);
                } else {
                    $('.global_logic_section').append(html);
                }
                $(el).parents('.middle-content').find('#' + next_logic_id + '.dropdown-toggle').parents('#global_logic_row_' + next_logic_id).find('.page_toggle').children()[0].className = "fa fa-chevron-up";
                App.alert.dismiss('loading_que_logic_view');
            }
        },
    });
}

function remove_logic(el, sid) {
    var active_report = 'question_wise';
    if ($('.individual_report_heading').hasClass('active')) {
        active_report = 'individual';
    } else if ($('.question_report_heading').hasClass('active')) {
        active_report = 'question_wise';
    }

    // Reset Logic selections
    $.each($('[name=global_filter_selection]'), function () {
        $(this).val('by_date');
    });
    // reset dates 
    $('[name=global_start_date]').val('');
    $('[name=global_end_date]').val('');
    // reset logics
    $('.thumbnail_logic_section').remove();
    if (active_report == 'question_wise') {
        $('.question_combined').trigger('click');
    }
    if (active_report == 'individual') {
        $('.individual_report_heading').trigger('click');
    }
    App.alert.show('global_filter_reset', {
        level: 'success',
        title: '',
        messages: 'Global Filter has been reset successfully.',
        autoClose: true
    });
}

function removeCurrentFilterBox(el) {
    var length = $(el).parents('.global_logic_section').find('.thumbnail_logic_section').length;
    var currentelID = $(el).attr('id');
    if (length === 2) {
        $(el).parents('.global_logic_section').find('.thumbnail_logic_section').find('.remove-glb-filter-row').each(function () {
            if ($(this).attr('id') === currentelID) {
            } else {
                $(this).hide();
            }
        });
    }
    $(el).parents('.thumbnail_logic_section').remove();
}

function switchTextForLogicOperator(el, logic_seq) {
    var selVal = $(el).val();
    $('.between_notbetween_text').hide();
    $("[name=logic_value_" + logic_seq + "]").show();
    $("[name=logic_value2_" + logic_seq + "]").show();
    if (selVal == 'between' || selVal == 'not_between') {
        $('.between_notbetween_text').show();
        $("[name=logic_value_" + logic_seq + "]").hide();
        $("[name=logic_value2_" + logic_seq + "]").hide();
    }
}

function showImage(el) {
    var anserID = $(el).attr('id').split('_');
    var ansID = anserID[1];
    var currentImagePosition = $(el).offset();
    var currentImageTop = parseInt(currentImagePosition['top'] - 100);
    var currentImageLeft = parseInt(currentImagePosition['left'] + 40);
    $('#hover_' + ansID).show();
    $('#hover_' + ansID).css('position', 'fixed');
    $('#hover_' + ansID).css('top', currentImageTop + 'px');
    $('#hover_' + ansID).css('left', currentImageLeft + 'px');
}

function hideImage(el) {
    var anserID = $(el).attr('id').split('_');
    var ansID = anserID[1]
    $('#hover_' + ansID).hide();
}
function close_global_filter_div(el) {
    $("#globalFilterbackgroundpopup").fadeOut(function () {
        $("#global_filter_main_div").hide();
    });
    $("#global_filter_main_div").fadeOut(function () {
        $("#global_filter_main_div").hide();
    });
}
function close_export_report_div(el) {
    $("#exportreportbackgroundpopup").remove();
    $('#export_report_main_div').remove();
}


function executeExportReportData(el, survey_id) {
    $('#export_loader').show();
    var GF_saved_question_logic = $('#current_global_filter_logic').val();
    var globalfilterLogics = GF_saved_question_logic.split('&');
    var globalfilterlogicObj = {};
    $.each(globalfilterLogics, function (k, v) {
        if (v != '') {
            var pair = v.split('=');
            var key = pair[0];
            var value = pair[1];
            globalfilterlogicObj[key] = value;
        }
    });
    var JsonGfData = JSON.stringify(globalfilterlogicObj);
    var exportfrom = 'combined';
    var reportType = $('#current_active_report_tab').val();
    if (typeof $('#' + reportType + '_report_data_section') !== 'undefined') {
        $('#' + reportType + '_report_data_section').find('.accordion-inner').each(function () {
            if ($(this).is(":hidden") === false) {
                var id_split = $(this).attr('id').split('_');
                exportfrom = id_split[3];
            }
        });
    }
    var exportby = $(el).parents('#export_report_main_div').find('#export_by').val();
    var exportAs = $(el).parents('#export_report_main_div').find('#export_as').val();
    var exportReport = $(el).parents('#export_report_main_div').find("input[name='export_report']:checked").val();
    if (exportReport == 'trend') {
        exportby = $(el).parents('#export_report_main_div').find('#export_by_trend').val();
    }
    var selectedRange = {range: exportby};
    var statusPieImgData = '';
    var statusLnImgData = '';
    var questionPDFData = {};
    var selectedRangeVal = JSON.stringify(selectedRange);
    $('[name=JsonGfData]').val(JSON.stringify(JsonGfData));
    if (exportAs == 'pdf' && reportType == 'question') {
        var url = App.api.buildURL("bc_survey", "get_export_report");
        App.api.call('create', url, {survey_id: survey_id, status_type: exportfrom, JsonGfData: JsonGfData, exportReport: exportReport, selectedRangeVal: selectedRangeVal}, {
            success: function (qchartData) {
                generateChartsImg(exportby, qchartData, JsonGfData, exportfrom, reportType, selectedRangeVal, statusPieImgData, statusLnImgData, exportReport);
            }
        });
    } else {


        selectedRange = {range: exportby};
        var selectedRangeVal = JSON.stringify(selectedRange);
        if (exportAs == 'pdf' && reportType == 'status' && exportReport == 'normal') {
            statusPieImgData = $('#pdf_chart_img_piechart_3d_' + exportfrom).val();
            statusLnImgData = $('#pdf_chart_img_line_chart_' + exportfrom).val();
        }
        if (exportAs == 'pdf' && reportType == 'status' && exportReport == 'trend') {
            statusLnImgData = $('#pdf_chart_img_trend_line_' + exportby + '_' + exportfrom).val();
        }
        questionPDFData = $('#export_question_selection_details').val();
        $('#generatePDFData').find('input[name=JsonGfData]').val(JsonGfData);
        $('#generatePDFData').find('input[name=export_from]').val(exportfrom);
        $('#generatePDFData').find('input[name=report_type]').val(reportType);
        $('#generatePDFData').find('input[name=selectedRange]').val(selectedRangeVal);
        $('#generatePDFData').find('input[name=statusPieImgData]').val(statusPieImgData);
        $('#generatePDFData').find('input[name=statusLnImgData]').val(statusLnImgData);
        $('#generatePDFData').find('input[name=questionPDFData]').val(questionPDFData);
        $('#generatePDFData').submit();
        $('#export_loader').hide();
    }
}


function generateChartsImg(type, qchartData, JsonGfData, exportfrom, reportType, selectedRangeVal, statusPieImgData, statusLnImgData, exportReport, fromIndividualQuestion, qID) {
    var questionPDFData = {};
    var maxexelength = Object.keys(qchartData).length;
    var choiceQType = ['check-box', 'radio-button', 'dropdownlist', 'multiselectlist', 'boolean', 'netpromoterscore', 'emojis', 'scale', 'rating'];
    $.ajax({
        url: 'https://www.google.com/jsapi',
        cache: true,
        dataType: 'script',
        async: false,
        success: function () {

            google.load('visualization', '1', {packages: ['corechart'], 'callback': function ()
                {
                    var execution = 0;
                    if (exportReport == 'normal') {
                        $.each(qchartData, function (qID, rows) {
                            var qTYpe = rows['qType'];
                            delete rows['qType'];
                            delete rows['qSeq'];
                            delete rows['tableStrucutureDataArray'];
                            var matrixColors = rows['matrixColors'];
                            delete rows['matrixColors'];
                            if (Array.isArray(rows) === false) {
                                var rowArr = Array.from(Object.keys(rows), k => rows[k]);
                            } else {
                                rowArr = rows;
                            }
                            if (type == 'default') {
                                if (rowArr != null) {
                                    if (choiceQType.indexOf(qTYpe) !== -1) {
                                        var data = google.visualization.arrayToDataTable(rowArr);
                                        var options = {
                                            //  width: 500,
                                            height: 300,
                                            legend: {position: 'none'},
                                            chart: {title: '',
                                                subtitle: ''},
                                            bars: 'horizontal', // Required for Material Bar Charts.
                                            axes: {
                                                x: {
                                                    0: {side: 'top', label: 'Percentage'} // Top x-axis.
                                                },
                                                y: {
                                                    0: {label: 'Submitted Data'}
                                                }
                                            },
                                            bar: {groupWidth: 'auto'},
                                            vAxis: {title: 'Submitted Data'},
                                            hAxis: {format: "#\'%\'", viewWindowMode: "explicit", viewWindow: {min: 0, max: 100}, title: 'Percentage', ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100], slantedText: true}
                                        };
                                        $('body').append('<div id="' + qID + '_temChartDiv" style="width:100%;"></div>');
                                        if (document.getElementById(qID + '_temChartDiv') !== null) {
                                            var chart = new google.visualization.BarChart(document.getElementById(qID + '_temChartDiv'));
                                            chart.draw(data, options);
                                            var chartImg = chart.getImageURI();
                                            storeQuestionDefaultSettings(qID, chartImg, 'hide', false);
                                            $('#' + qID + '_temChartDiv').remove();
                                            execution = parseInt(execution) + 1;
                                        }
                                    } else if (qTYpe == 'matrix') {
                                        var data = google.visualization.arrayToDataTable(rowArr);
                                        var options = {
                                            isStacked: true,
                                            is3D: true,
                                            //  width: 800,
                                            height: 400,
                                            bars: 'horizontal', // Required for Material Bar Charts.
                                            legendTextStyle: {color: '#000'},
                                            titleTextStyle: {color: '#000'},
                                            //  colorAxis: {colors: ['#02c2da', '#f5b697']},
                                            vAxis: {viewWindowMode: "explicit", viewWindow: {min: 0}, title: 'Rows'},
                                            hAxis: {format: "#\'%\'", viewWindowMode: "explicit", viewWindow: {min: 0}, title: 'Percentage', ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100], slantedText: true},
                                            colors: matrixColors,
                                        };
                                        $('body').append('<div id="' + qID + '_temChartDiv"  style="width:100%;"></div>');
                                        if (document.getElementById(qID + '_temChartDiv') !== null) {
                                            var chart = new google.visualization.BarChart(document.getElementById(qID + '_temChartDiv'));
                                            chart.draw(data, options);
                                            var chartImg = chart.getImageURI();
                                            storeQuestionDefaultSettings(qID, chartImg, 'hide', false);
                                            $('#' + qID + '_temChartDiv').remove();
                                            execution = parseInt(execution) + 1;
                                        }
                                    } else {
                                        execution = parseInt(execution) + 1;
                                    }
                                }
                            } else {
                                questionPDFData = $('#export_question_selection_details').val();
                                if (typeof questionPDFData !== 'undefined' && questionPDFData !== '') {
                                    questionPDFData = JSON.parse(questionPDFData);
                                } else {
                                    questionPDFData = {};
                                }
                                if (qID in questionPDFData) {
                                    execution = parseInt(execution) + 1;
                                } else {
                                    if (rowArr != null) {
                                        if (choiceQType.indexOf(qTYpe) !== -1) {
                                            var data = google.visualization.arrayToDataTable(rowArr);
                                            var options = {
                                                //  width: 500,
                                                height: 300,
                                                legend: {position: 'none'},
                                                chart: {title: '',
                                                    subtitle: ''},
                                                bars: 'horizontal', // Required for Material Bar Charts.
                                                axes: {
                                                    x: {
                                                        0: {side: 'top', label: 'Percentage'} // Top x-axis.
                                                    },
                                                    y: {
                                                        0: {label: 'Submitted Data'}
                                                    }
                                                },
                                                bar: {groupWidth: 'auto'},
                                                vAxis: {title: 'Submitted Data'},
                                                hAxis: {format: "#\'%\'", viewWindowMode: "explicit", viewWindow: {min: 0, max: 100}, title: 'Percentage', ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100], slantedText: true}
                                            };
                                            $('body').append('<div id="' + qID + '_temChartDiv"  style="width:100%;"></div>');
                                            if (document.getElementById(qID + '_temChartDiv') !== null) {
                                                var chart = new google.visualization.BarChart(document.getElementById(qID + '_temChartDiv'));
                                                chart.draw(data, options);
                                                var chartImg = chart.getImageURI();
                                                storeQuestionDefaultSettings(qID, chartImg, 'hide', false);
                                                $('#' + qID + '_temChartDiv').remove();
                                                execution = parseInt(execution) + 1;
                                            }
                                        } else if (qTYpe == 'matrix') {
                                            var matrixColors = rowArr['matrixColors'];
                                            delete rowArr['matrixColors'];
                                            var data = google.visualization.arrayToDataTable(rowArr);
                                            var options = {
                                                isStacked: true,
                                                is3D: true,
                                                //  width: 800,
                                                height: 400,
                                                bars: 'horizontal', // Required for Material Bar Charts.
                                                legendTextStyle: {color: '#000'},
                                                titleTextStyle: {color: '#000'},
                                                //  colorAxis: {colors: ['#02c2da', '#f5b697']},
                                                vAxis: {viewWindowMode: "explicit", viewWindow: {min: 0}, title: 'Rows'},
                                                hAxis: {format: "#\'%\'", viewWindowMode: "explicit", viewWindow: {min: 0}, title: 'Percentage', ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100], slantedText: true},
                                                colors: matrixColors,
                                            };
                                            $('body').append('<div id="' + qID + '_temChartDiv"  style="width:100%;"></div>');
                                            if (document.getElementById(qID + '_temChartDiv') !== null) {
                                                var chart = new google.visualization.BarChart(document.getElementById(qID + '_temChartDiv'));
                                                chart.draw(data, options);
                                                var chartImg = chart.getImageURI();
                                                storeQuestionDefaultSettings(qID, chartImg, 'hide', false);
                                                $('#' + qID + '_temChartDiv').remove();
                                                execution = parseInt(execution) + 1;
                                            }
                                        } else {
                                            execution = parseInt(execution) + 1;
                                        }
                                    }
                                }
                            }
                        });
                        questionPDFData = $('#export_question_selection_details').val();
                    } else {
                        $.each(qchartData, function (qID, rows) {
                            var rowsData = rows['trendQuestionChartData'];
                            if (Array.isArray(rowsData) === false) {
                                var rowArr = Array.from(Object.keys(rowsData), k => rows[k]);
                            } else {
                                rowArr = rowsData;
                            }
                            var data = google.visualization.arrayToDataTable(rowArr);
                            var options = {
                                title: '',
                                pointSize: 7,
                                width: '1200',
                                height: 300,
                                legend: {position: 'top'},
                                hAxis: {viewWindowMode: "explicit", viewWindow: {}, slantedText: true, slantedTextAngle: 10},
                                vAxis: {format: '0', viewWindowMode: "explicit", viewWindow: {}},
                                is3D: true,
                            };
                            $('body').append('<div id="' + qID + '_temtrendChartDiv"  style="width:100%;"></div>');
                            if (document.getElementById(qID + '_temtrendChartDiv') !== null) {
                                var chart = new google.visualization.LineChart(document.getElementById(qID + '_temtrendChartDiv'));
                                chart.draw(data, options);
                                var chartImg = chart.getImageURI();
                                storeTrendQuestionDefaultSettings(qID, chartImg, false);
                                $('#' + qID + '_temtrendChartDiv').remove();
                                execution = parseInt(execution) + 1;
                            }
                        });
                        questionPDFData = $('#export_question_selection_details_trend').val();
                    }

                    if (execution == maxexelength) {
                        if (typeof fromIndividualQuestion !== 'undefined' && fromIndividualQuestion === true) {
                            $('#questionWiseImageExport').find('input[name=JsonGfData]').val(JsonGfData);
                            $('#questionWiseImageExport').find('input[name=export_from]').val(exportfrom);
                            $('#questionWiseImageExport').find('input[name=report_type]').val(reportType);
                            $('#questionWiseImageExport').find('input[name=selectedRange]').val(selectedRangeVal);
                            $('#questionWiseImageExport').find('input[name=statusPieImgData]').val(statusPieImgData);
                            $('#questionWiseImageExport').find('input[name=statusLnImgData]').val(statusLnImgData);
                            $('#questionWiseImageExport').find('input[name=questionPDFData]').val(questionPDFData);
                            $('#questionWiseImageExport').submit();
                        } else {
                            $('#generatePDFData').find('input[name=JsonGfData]').val(JsonGfData);
                            $('#generatePDFData').find('input[name=export_from]').val(exportfrom);
                            $('#generatePDFData').find('input[name=report_type]').val(reportType);
                            $('#generatePDFData').find('input[name=selectedRange]').val(selectedRangeVal);
                            $('#generatePDFData').find('input[name=statusPieImgData]').val(statusPieImgData);
                            $('#generatePDFData').find('input[name=statusLnImgData]').val(statusLnImgData);
                            $('#generatePDFData').find('input[name=questionPDFData]').val(questionPDFData);
                            $('#generatePDFData').submit();
                            $('#export_loader').hide();
                        }
                    }
                }
            });
        }
    });

}

function storeQuestionDefaultSettings(qID, ImgUrl, statsVal, isLoading) {
    if (!isLoading) {
        var getSelDetails = $('#export_question_selection_details').val();
        if (getSelDetails !== '') {
            getSelDetails = JSON.parse(getSelDetails);
        }
        if (typeof getSelDetails !== 'object') {
            getSelDetails = {};
        }
        if (typeof statsVal !== 'undefined' && statsVal !== '') {
        } else {
            statsVal = 'hide';
        }
        getSelDetails[qID] = {'stats': statsVal, 'chartImg': ImgUrl};
        var jsonStr = JSON.stringify(getSelDetails);
        $('#export_question_selection_details').val(jsonStr);
    }
}

function storeTrendQuestionDefaultSettings(qID, ImgUrl, isLoading) {
    if (!isLoading) {
        var getSelDetails = $('#export_question_selection_details_trend').val();
        if (getSelDetails !== '') {
            getSelDetails = JSON.parse(getSelDetails);
        }
        if (typeof getSelDetails !== 'object') {
            getSelDetails = {};
        }
        getSelDetails[qID] = {'chartImg': ImgUrl};
        var jsonStr = JSON.stringify(getSelDetails);
        $('#export_question_selection_details_trend').val(jsonStr);
    }
}

function open_export_report_popup(el, surveyID, userID) {
    var hasSubmissions = $('#hasSubmissions').val();
    if (hasSubmissions === 'false') {
        alert('There are no submissions available to export.');
    } else {
    var curentTab = $('#current_active_report_tab').val();
    var display = "";
        var displayOpt = "display:none";
    if (curentTab == 'status' || curentTab == 'question') {
        display = "display:none";
    }
        if (curentTab == 'question') {
            displayOpt = '';
        }
    var self = this;
    if ($("#export_report_main_div").length == 0) {
// close global filter function
        $('#content').append('<div id="export_report_main_div"> </div>');
    }
    $('#content').append('<div id="exportreportbackgroundpopup">&nbsp;</div>');
    var html = '<form method="post" id="generatePDFData" action="index.php?entryPoint=exportReportsData" >';
    html += "<input type='hidden' name='survey_id' value='" + surveyID + "'>";
    html += "<input type='hidden' name='report_type' value=''>";
    html += "<input type='hidden' name='questionPDFData' value=''>";
    html += "<input type='hidden' name='JsonGfData' value=''>";
    html += "<input type='hidden' name='export_from' value=''>";
    html += "<input type='hidden' name='selectedRange' value=''>";
    html += "<input type='hidden' name='userID' value='" + userID + "'>";
    html += "<input type='hidden' name='statusPieImgData' value=''>";
    html += "<input type='hidden' name='statusLnImgData' value=''>";
        html += "<div class='desc_div' style='background-color:#e8e8e8; padding:3px; font-size:16px; height:25px; padding-top:10px;'>&nbsp;<span class='fa fa-download'></span>&nbsp;Export Report</div>";
    html += "<div class='middle-content'>";
    // Start Date
    html += "   <div class='row' style='margin-top: 10px;margin-left: 1px !important;'>"
    html += "       <div class='span2'>";
    html += "           <span class='label-field'>Normal:</span>";
    html += "           <input onchange='showHideExportByDD(this,\"" + curentTab + "\");' name = 'export_report' class = 'export_report' id='normal_export_report' type = 'radio' value='normal' checked>";
    html += "       </div>";
    html += "       <div class='span2'>";
    html += "           <span class='label-field'>Trend:</span>";
    html += "           <input onchange='showHideExportByDD(this,\"" + curentTab + "\");' name = 'export_report' class = 'export_report' id='trend_export_report' type = 'radio' value='trend'>";
    html += "       </div>";
    html += "   </div>";
    html += "   <div class='row' style='margin-left: 1px !important'>"
    html += "       <div class='span2'>";
    html += "           <span class='label-field'>Export As:</span>";
        html += "           <select style='width: 110px;' id='export_as' name='export_as' onchange='showHideExportByDD(this,\"" + curentTab + "\");'><option value='pdf'>PDF</option><option value='csv'>CSV</option></select>";
    html += "       </div>";
        html += "       <div id='export_by_div' class='span2' style='" + displayOpt + "'>";
    html += "           <span class='label-field'>Export By:</span>";
    html += "           <select style='width: 100px;' id='export_by' name='export_by'><option value='default'>Default</option><option value='selected'>Selected</option></select>";
    html += "       </div>";
    html += "       <div id='export_by_div_trend' class='span2' style='" + display + "'>";
    html += "           <span class='label-field'>Export By:</span>";
    html += "           <select style='width: 100px;' id='export_by_trend' name='export_by_trend'>\n\
                                <option value='by_day'>By Day</option>\n\
                                <option value='by_week'>By Week</option>\n\
                                <option value='by_month'>By Month</option>\n\
                                <option value='by_year'>By Year</option>\n\
                        </select>";
    html += "       </div>";
    html += "   </div>";
    html += "   <div class='row' style='margin-left: 12px !important;margin-top: 5px;'>"
        html += "       <div class='btn btn-primary' style='float:left;' onclick='executeExportReportData(this,\"" + surveyID + "\")' id='export_report_btn'>Export</div>";
    html += "       <div style='float: right;padding: 6px 115px 8px 5px;display:none;' id='export_loader'>Please wait,we are processing your request.<img src='custom/include/images/ajax_loader.gif' height='20px' width='20px'></div>";
    html += "   </div>";
    html += '</div></form>';
    $('#export_report_main_div').html('<div id="export_report">'
            + html +
            ' <a  href="javascript:void(0);" class="close_export_report" onclick="close_export_report_div(this)"></a>' +
            '</div>');
}
}

function showHideExportByDD(el, reportView) {
    $('#export_by_div').hide();
    $('#export_by_div_trend').hide();
    var curentTab = $('#current_active_report_tab').val();
    var export_as = $('#export_as').val();
    var export_report = $('.export_report:checked').val();
    if (curentTab == 'question' && export_as == 'pdf' &&  export_report == 'normal') {
        $('#export_by_div').show();
        $('#export_by').val('default');
    }
    if (export_report == 'trend') {
        $('#export_by_div_trend').show();
    }
}

function getGlobalFilterURl(self) {
    //Global Filter :: Start
    var isApplyGlobalFilter = $('#content').find('[name=isApplyGlobalFilter]').length;
    if (isApplyGlobalFilter == 0) {
        isApplyGlobalFilter = 1;
    } else if (isApplyGlobalFilter == 1 && $('#content').find('[name=isApplyGlobalFilter]').val() == 1) {
        isApplyGlobalFilter = 1;
    } else if (isApplyGlobalFilter == 1 && $('#content').find('[name=isApplyGlobalFilter]').val() == 0) {
        isApplyGlobalFilter = 0;
    } else {
        isApplyGlobalFilter = 1;
    }
    var global_filter_by = '';
    if (self.GF_Filter_By == 'by_date') {
        if (isApplyGlobalFilter) {
            self.GF_Start_Date = $('[name=global_start_date]').val();
            self.GF_End_Date = $('[name=global_end_date]').val();
        }
        var gf_start_date = self.GF_Start_Date;
        var gf_end_date = self.GF_End_Date;
        global_filter_by = '&gf_filter_by=by_date&gf_start_date=' + gf_start_date + '&gf_end_date=' + gf_end_date;
    } else if (self.GF_Filter_By == 'by_question_logic') {
        if (isApplyGlobalFilter) {
            self.GF_Start_Date = $('[name=global_start_date]').val();
            self.GF_End_Date = $('[name=global_end_date]').val();
        }
        var gf_start_date = self.GF_Start_Date;
        var gf_end_date = self.GF_End_Date;
        global_filter_by = '&gf_filter_by=by_question_logic&gf_start_date=' + gf_start_date + '&gf_end_date=' + gf_end_date;
        // Question wise logic
        if (isApplyGlobalFilter) {
            var global_question_wise_logic = {};
            var gl_count = 0;
            $.each($('.thumbnail_logic_section'), function () {
                var logic_seq = $(this).attr('id').split('global_logic_row_')[1];
                var que_id = $('#global_logic_que_' + logic_seq).val();
                // logic operators
                var logic_operator = '';
                if ($('#que_logic_answer_' + logic_seq).find('[name=logic_operator_' + logic_seq + ']').length != 0) {
                    logic_operator = $('#que_logic_answer_' + logic_seq).find('[name=logic_operator_' + logic_seq + ']').val();
                }

                // logic values
                var logic_values = {};
                if (logic_operator == 'between' || logic_operator == 'not_between') {
                    if ($('#que_logic_answer_' + logic_seq).find('.between_notbetween_text').length != 0) {
                        var count = 0;
                        $.each($('#que_logic_answer_' + logic_seq).find('.between_notbetween_text'), function () {
                            logic_values[count] = $(this).val();
                            count++;
                        });
                    }
                    logic_values = JSON.stringify(logic_values);
                } else {
                    if ($('#que_logic_answer_' + logic_seq).find('[name=logic_value_' + logic_seq + ']').length != 0) {
                        var count = 0;
                        $.each($('#que_logic_answer_' + logic_seq).find('[name=logic_value_' + logic_seq + ']'), function () {
                            if ($(this).attr('type') == 'checkbox') {
                                if ($(this).prop('checked')) {
                                    logic_values[count] = $(this).val();
                                }
                            } else {
                                logic_values[count] = $(this).val();
                                if ($('#que_logic_answer_' + logic_seq).find('[name=logic_value2_' + logic_seq + ']').length != 0) {
                                    logic_values[count + 1] = $('#que_logic_answer_' + logic_seq).find('[name=logic_value2_' + logic_seq + ']').val();
                                }
                            }
                            count++;
                        });
                    }
                }
                // Global Logic Question Wise
                if (que_id != '0') {
                    global_question_wise_logic[gl_count] = {'que_id': que_id, 'logic_operator': logic_operator, 'logic_values': logic_values};
                }
                gl_count++;
            });
            self.GF_saved_question_logic = global_question_wise_logic;
            self.GF_match_case = $('[name=GF_match_case]:checked').val();
        }
        global_filter_by += '&GF_saved_question_logic=' + JSON.stringify(global_question_wise_logic) + '&GF_match_case=' + $('[name=GF_match_case]:checked').val();
    }
    $('#current_global_filter_logic').val(global_filter_by);
    return global_filter_by;
    // Global Filter :: End
}
function getAnswerHistory(el) {
    var queid = $(el).attr('data-que_id');
    var sub_id = $('#individual_submission_id').val();

    // Retrieve all questions for Question Logic
    var url = App.api.buildURL("bc_survey", "generateIndividualHistory", "", {sub_id: sub_id, que_id: queid});
    App.api.call('GET', url, {}, {
        success: function (data) {
            //  if (data) {
            // Hide current page of individual report in Popup
            $('.middle-content').hide();
            $('.numbers').hide();

            // Add back button to come back in report
            data += '<div class="answerHistoryDetailfooter" style="height: 33px; padding-top: 5px; background-color: #f0f0f0;"><div class="btn btn-primary" onclick="hideAnswerHistory()">Back</div></div>';
            $('#indivisual_report').append(data);
        }
    });

}
function hideAnswerHistory() {
    // Show current page of individual report in Popup
    $('.middle-content').show();
    $('.numbers').show();
    // Remove history div
    $('.answerHistoryDetail').remove();
    $('.answerHistoryDetailfooter').remove();
}
