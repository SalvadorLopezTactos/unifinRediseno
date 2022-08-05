<?php

/**
 * The file used to handle survey submission form 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
if (!defined('sugarEntry') || !sugarEntry)
    define('sugarEntry', true);

require_once('include/entryPoint.php');

if (isset($_REQUEST['survey_id'])) {
    $survey_id = $_REQUEST['survey_id'];
} else {
    $survey_id = '';
}

$survey = BeanFactory::getBean('bc_survey', $survey_id);
$name = $survey->name;

$survey->load_relationship('bc_survey_pages_bc_survey');

$questions = array();
$survey_details = array();

foreach ($survey->bc_survey_pages_bc_survey->getBeans() as $pages) {
    unset($questions);
    $survey_details[$pages->page_sequence]['page_title'] = (!empty($list_lang_detail[$pages->id])) ? $list_lang_detail[$pages->id] : $pages->name;
    $survey_details[$pages->page_sequence]['page_number'] = $pages->page_number;
    $survey_details[$pages->page_sequence]['page_id'] = $pages->id;
    $pages->load_relationship('bc_survey_pages_bc_survey_questions');
    foreach ($pages->bc_survey_pages_bc_survey_questions->getBeans() as $survey_questions) {
        $questions[$survey_questions->question_sequence]['que_id'] = $survey_questions->id;
        $questions[$survey_questions->question_sequence]['que_title'] = (!empty($list_lang_detail[$survey_questions->id . '_que_title'])) ? $list_lang_detail[$survey_questions->id . '_que_title'] : $survey_questions->name;
        $questions[$survey_questions->question_sequence]['richtextContent'] = $survey_questions->richtextContent;
                    
        $questions[$survey_questions->question_sequence]['que_type'] = $survey_questions->question_type;
        $questions[$survey_questions->question_sequence]['is_required'] = $survey_questions->is_required;
        $questions[$survey_questions->question_sequence]['is_question_seperator'] = $survey_questions->is_question_seperator;
        $questions[$survey_questions->question_sequence]['file_size'] = $survey_questions->file_size;
        $questions[$survey_questions->question_sequence]['file_extension'] = $survey_questions->file_extension;
        $questions[$survey_questions->question_sequence]['question_help_comment'] = (!empty($list_lang_detail[$survey_questions->id . '_question_help_comment'])) ? $list_lang_detail[$survey_questions->id . '_question_help_comment'] : $survey_questions->question_help_comment;
        $questions[$survey_questions->question_sequence]['display_boolean_label'] = (!empty($list_lang_detail[$survey_questions->id . '_display_boolean_label'])) ? $list_lang_detail[$survey_questions->id . '_display_boolean_label'] : $survey_questions->display_boolean_label;

        //advance options
        $questions[$survey_questions->question_sequence]['advance_type'] = (isset($survey_questions->advance_type)) ? $survey_questions->advance_type : '';
        $questions[$survey_questions->question_sequence]['maxsize'] = (isset($survey_questions->maxsize)) ? $survey_questions->maxsize : '';
        $questions[$survey_questions->question_sequence]['min'] = (isset($survey_questions->min)) ? $survey_questions->min : '';
        $questions[$survey_questions->question_sequence]['max'] = (isset($survey_questions->max)) ? $survey_questions->max : '';
        $questions[$survey_questions->question_sequence]['precision'] = (isset($survey_questions->precision_value)) ? $survey_questions->precision_value : '';
        $questions[$survey_questions->question_sequence]['is_datetime'] = (isset($survey_questions->is_datetime) ) ? $survey_questions->is_datetime : '';
        $questions[$survey_questions->question_sequence]['is_sort'] = (isset($survey_questions->is_sort) ) ? $survey_questions->is_sort : '';
        $questions[$survey_questions->question_sequence]['enable_otherOption'] = (isset($survey_questions->enable_otherOption) ) ? $survey_questions->enable_otherOption : '';
        $questions[$survey_questions->question_sequence]['matrix_row'] = (isset($survey_questions->matrix_row)) ? base64_decode($survey_questions->matrix_row) : '';
        $questions[$survey_questions->question_sequence]['matrix_col'] = (isset($survey_questions->matrix_col)) ? base64_decode($survey_questions->matrix_col) : '';
        $questions[$survey_questions->question_sequence]['description'] = (isset($survey_questions->description)) ? $survey_questions->description : '';


        $survey_questions->load_relationship('bc_survey_answers_bc_survey_questions');
        $questions[$survey_questions->question_sequence]['answers'] = array();
        foreach ($survey_questions->bc_survey_answers_bc_survey_questions->getBeans() as $survey_answers) {
            if ($questions[$survey_questions->question_sequence]['is_required'] && !isset($survey_answers->answer_name)) {
                continue;
            } else {
                $questions[$survey_questions->question_sequence]['answers'][$survey_answers->answer_sequence][$survey_answers->id] = (!empty($list_lang_detail[$survey_answers->id])) ? $list_lang_detail[$survey_answers->id] : $survey_answers->answer_name;
            }
        }
        ksort($questions[$survey_questions->question_sequence]['answers']);
    }
    ksort($questions);
    $survey_details[$pages->page_sequence]['page_questions'] = $questions;
    ksort($survey_details);
}

function getMultiselectHTML($question, $list_lang_detail) {
    $answers = $question['answers'];
    $type = $question['que_type'];
    $que_id = $question['que_id'];
    $maxsize = $question['maxsize'];
    $is_sort = $question['is_sort'];
    $advancetype = $question['advance_type'];
    $que_title = $question['que_title'];
    $matrix_row = $question['matrix_row'];
    $matrix_col  = $question['matrix_col'];
    $html = "";
    switch ($type) {
        case 'multiselectlist':
            $placeholder_label_other = '';
            if ($list_lang_detail[$que_id . '_other_placeholder_label']) {
                $placeholder_label_other = $list_lang_detail[$que_id . '_other_placeholder_label'];
            }
            $html = "<div class='option multiselect-list  two-col' id='{$que_id}_div'>";
            //if sorting
            if ($is_sort == 1) {
                foreach ($answers as $ans) {
                    foreach ($ans as $ans_id => $answer) {
                        $options[$ans_id] = $answer;
                    }
                }
                asort($options);
                foreach ($options as $ans_id => $answer) {
                    // check if answer is other type of or not
                    $is_other = '';
                    $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                    if ($oAnswer->answer_type == 'other') {
                        $is_other = 'is_other_option';
                    }
                    $html .= '<div style="display:inline;"><img src="custom/include/images/check1.png" height="11px" width="11px">'
                            . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                            . "</div><br/>";
                }
            }
            // not sorting
            else {
                foreach ($answers as $ans) {
                    foreach ($ans as $ans_id => $answer) {
                        // check if answer is other type of or not
                        $is_other = '';
                        $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                        if ($oAnswer->answer_type == 'other') {
                            $is_other = 'is_other_option';
                        }
                        $html .= '<div style="display:inline;"><img src="custom/include/images/check1.png" height="11px" width="11px">'
                                . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                . "</div><br/>";
                    }
                }
            }

            $html .= "</div>";
            return $html;
            break;
        case 'check-box':
            $placeholder_label_other = '';
            if ($list_lang_detail[$que_id . '_other_placeholder_label']) {
                $placeholder_label_other = $list_lang_detail[$que_id . '_other_placeholder_label'];
            }
            $html = "<div class='option checkbox-list' id='{$que_id}_div'>";

            //if sorting
            if ($is_sort == 1) {

                foreach ($answers as $ans) {
                    foreach ($ans as $ans_id => $answer) {
                        $options[$ans_id] = $answer;
                    }
                }
                asort($options);
                // if horizontal
                if ($advancetype == 'Horizontal') {
                    $op = 1;
                    foreach ($options as $ans_id => $answer) {
                        // check if answer is other type of or not
                        $is_other = '';
                        $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                        $matrix_row = $oAnswer->radio_image;
                        $image_data = explode(',', $matrix_row);
                        $ext = explode('data:image/', $image_data[0]);

                        $ext_arr = explode(';base64', $ext[1]);

                        if (!empty($ext_arr[0])) {
                            $final_ext = '.' . $ext_arr[0];

                            // check whether fiel exists or not on given path
                            $imgdata = 'upload/' . $ans_id . $final_ext;
                            if (SugarAutoLoader::fileExists($imgdata)) {
                                $imgPath = $imgdata;
                            } else {
                                $imgPath = '';
                            }
                        }
                        if ($oAnswer->answer_type == 'other') {
                            $is_other = 'is_other_option';
                        }
                        if (empty($imgPath)) {
                        $html .= '<div style="display:inline;"><img src="custom/include/images/check1.png" height="11px" width="11px">'
                                . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                . "</div><br/>";
                        } else {
                            $html .= '<div style="display:inline;"><img src="custom/include/images/check1.png" height="11px" width="11px">&nbsp;<img height="11px" width="11px" src="' . $imgPath . '">'
                                    . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                    . "</div><br/>";
                        }
                        $op++;
                    }
                }
                // if vertical
                else {
                    $op = 1;
                    foreach ($options as $ans_id => $answer) {
                        // check if answer is other type of or not
                        $is_other = '';
                        $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                        $matrix_row = $oAnswer->radio_image;
                        $image_data = explode(',', $matrix_row);
                        $ext = explode('data:image/', $image_data[0]);

                        $ext_arr = explode(';base64', $ext[1]);

                        if (!empty($ext_arr[0])) {
                            $final_ext = '.' . $ext_arr[0];

                            // check whether fiel exists or not on given path
                            $imgdata = 'upload/' . $ans_id . $final_ext;
                            if (SugarAutoLoader::fileExists($imgdata)) {
                                $imgPath = $imgdata;
                            } else {
                                $imgPath = '';
                            }
                        }
                        if ($oAnswer->answer_type == 'other') {
                            $is_other = 'is_other_option';
                        }
                        if (empty($imgPath)) {
                        $html .= '<div style="display:inline;"><img src="custom/include/images/check1.png" height="11px" width="11px">'
                                . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                . "</div><br/>";
                        } else {
                            $html .= '<div style="display:inline;"><img src="custom/include/images/check1.png" height="11px" width="11px">&nbsp;<img height="11px" width="11px" src="' . $imgPath . '">'
                                    . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                    . "</div><br/>";
                        }

                        $op++;
                    }
                }
            }
            // if not sorting
            else {
                //if horizontal
                if ($advancetype == 'Horizontal') {
                    $op = 1;
                    foreach ($answers as $ans) {
                        foreach ($ans as $ans_id => $answer) {
                            // check if answer is other type of or not
                            $is_other = '';
                            $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                            $matrix_row = $oAnswer->radio_image;
                            $image_data = explode(',', $matrix_row);
                            $ext = explode('data:image/', $image_data[0]);

                            $ext_arr = explode(';base64', $ext[1]);

                            if (!empty($ext_arr[0])) {
                                $final_ext = '.' . $ext_arr[0];

                                // check whether fiel exists or not on given path
                                $imgdata = 'upload/' . $ans_id . $final_ext;
                                if (SugarAutoLoader::fileExists($imgdata)) {
                                    $imgPath = $imgdata;
                                } else {
                                    $imgPath = '';
                                }
                            }
                            if ($oAnswer->answer_type == 'other') {
                                $is_other = 'is_other_option';
                            }
                            if (empty($imgPath)) {
                            $html .= '<div style="display:inline;"><img src="custom/include/images/check1.png" height="11px" width="11px">'
                                    . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                    . "</div><br/>";
                            } else {
                                $html .= '<div style="display:inline;"><img src="custom/include/images/check1.png" height="11px" width="11px">&nbsp;<img height="11px" width="11px" src="' . $imgPath . '">'
                                        . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                        . "</div><br/>";
                            }
                            $op++;
                        }
                    }
                }
                // if vertical
                else {
                    $op = 1;
                    foreach ($answers as $ans) {
                        foreach ($ans as $ans_id => $answer) {
                            // check if answer is other type of or not
                            $is_other = '';
                            $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                            $matrix_row = $oAnswer->radio_image;
                            $image_data = explode(',', $matrix_row);
                            $ext = explode('data:image/', $image_data[0]);

                            $ext_arr = explode(';base64', $ext[1]);

                            if (!empty($ext_arr[0])) {
                                $final_ext = '.' . $ext_arr[0];

                                // check whether fiel exists or not on given path
                                $imgdata = 'upload/' . $ans_id . $final_ext;
                                if (SugarAutoLoader::fileExists($imgdata)) {
                                    $imgPath = $imgdata;
                                } else {
                                    $imgPath = '';
                                }
                            }
                            if ($oAnswer->answer_type == 'other') {
                                $is_other = 'is_other_option';
                            }
                            if (empty($imgPath)) {
                            $html .= '<div style="display:inline;"><img src="custom/include/images/check1.png" height="11px" width="11px">'
                                    . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                    . "</div><br/>";
                            } else {
                                $html .= '<div style="display:inline;"><img src="custom/include/images/check1.png" height="11px" width="11px">&nbsp;<img height="11px" width="11px" src="' . $imgPath . '">'
                                        . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                        . "</div><br/>";
                            }
                            $op++;
                        }
                    }
                }
            }

            $html .= "</div>";
            return $html;
            break;
        case 'boolean':
            $html = "<div class='option boolean-list' id='{$que_id}_div'>";
            // check if answer is other type of or not
            $html .= '<div style="display:inline;"><img src="custom/include/images/check1.png" height="11px" width="11px">'
                    . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                    . "</div><br/>";
            $html .= "</div>";
            return $html;
            break;
        case 'radio-button':
            $placeholder_label_other = '';
            if ($list_lang_detail[$que_id . '_other_placeholder_label']) {
                $placeholder_label_other = $list_lang_detail[$que_id . '_other_placeholder_label'];
            }
            $html = "<div class='option radio-list' id='{$que_id}_div'>";
            if ($advancetype == 'Horizontal') {
                $html .= '<div>';
            } else {
                $html .= '<div style="display:inline-grid;">';
            }
            // if sorting
            if ($is_sort == 1) {
                foreach ($answers as $ans) {
                    foreach ($ans as $ans_id => $answer) {
                        $options[$ans_id] = $answer;
                    }
                }
                asort($options);
                // if horizontal
                if ($advancetype == 'Horizontal') {
                    $op = 1;

                    foreach ($options as $ans_id => $answer) {
                        // check if answer is other type of or not
                        $is_other = '';
                        $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                        $matrix_row = $oAnswer->radio_image;
                        $image_data = explode(',', $matrix_row);
                        $ext = explode('data:image/', $image_data[0]);

                        $ext_arr = explode(';base64', $ext[1]);

                        if (!empty($ext_arr[0])) {
                            $final_ext = '.' . $ext_arr[0];

                            // check whether fiel exists or not on given path
                            $imgdata = 'upload/' . $ans_id . $final_ext;
                            if (SugarAutoLoader::fileExists($imgdata)) {
                                $imgPath = $imgdata;
                            } else {
                                $imgPath = '';
                            }
                        }
                        if ($oAnswer->answer_type == 'other') {
                            $is_other = 'is_other_option';
                        }
                        if (empty($imgPath)) {
                            $html .= '<div style="display:inline;"><img src="custom/include/images/radio1.png" height="11px" width="11px">'
                                    . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                    . "</div><br/>";
                        } else {
                        $html .= '<div style="display:inline;"><img src="custom/include/images/radio1.png" height="11px" width="11px">&nbsp;<img height="11px" width="11px" src="' . $imgPath . '">'
                                . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                . "</div><br/>";
                        }
                        $op++;
                    }
                }
                // if vertical
                else {
                    $op = 1;
                    foreach ($options as $ans_id => $answer) {
                        // check if answer is other type of or not
                        $is_other = '';
                        $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                        $matrix_row = $oAnswer->radio_image;
                        $image_data = explode(',', $matrix_row);
                        $ext = explode('data:image/', $image_data[0]);

                        $ext_arr = explode(';base64', $ext[1]);

                        if (!empty($ext_arr[0])) {
                            $final_ext = '.' . $ext_arr[0];

                            // check whether fiel exists or not on given path
                            $imgdata = 'upload/' . $ans_id . $final_ext;
                            if (SugarAutoLoader::fileExists($imgdata)) {
                                $imgPath = $imgdata;
                            } else {
                                $imgPath = '';
                            }
                        }
                        if ($oAnswer->answer_type == 'other') {
                            $is_other = 'is_other_option';
                        }
                        if (empty($imgPath)) {
                            $html .= '<div style="display:inline;"><img src="custom/include/images/radio1.png" height="11px" width="11px">'
                                    . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                    . "</div><br/>";
                        } else {
                        $html .= '<div style="display:inline;"><img src="custom/include/images/radio1.png" height="11px" width="11px">&nbsp;<img height="11px" width="11px" src="' . $imgPath . '">'
                                . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                . "</div><br/>";
                        }
                        $op++;
                    }
                }
            }
            // if not sorting
            else {
                // if horizontal
                if ($advancetype == 'Horizontal') {
                    $op = 1;
                    foreach ($answers as $ans) {
                        foreach ($ans as $ans_id => $answer) {
                            // check if answer is other type of or not
                            $is_other = '';
                            $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                            $matrix_row = $oAnswer->radio_image;
                            $image_data = explode(',', $matrix_row);
                            $ext = explode('data:image/', $image_data[0]);

                            $ext_arr = explode(';base64', $ext[1]);

                            if (!empty($ext_arr[0])) {
                                $final_ext = '.' . $ext_arr[0];

                                // check whether fiel exists or not on given path
                                $imgdata = 'upload/' . $ans_id . $final_ext;
                                if (SugarAutoLoader::fileExists($imgdata)) {
                                    $imgPath = $imgdata;
                                } else {
                                    $imgPath = '';
                                }
                            }
                            if ($oAnswer->answer_type == 'other') {
                                $is_other = 'is_other_option';
                            }
                            if (empty($imgPath)) {
                                $html .= '<div style="display:inline;"><img src="custom/include/images/radio1.png" height="11px" width="11px">'
                                        . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                        . "</div><br/>";
                            } else {
                            $html .= '<div style="display:inline;"><img src="custom/include/images/radio1.png" height="11px" width="11px">&nbsp;<img height="11px" width="11px" src="' . $imgPath . '">'
                                    . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                    . "</div><br/>";
                        }
                        }
                        $op++;
                    }
                }
                // if vertical
                else {
                    $op = 1;
                    foreach ($answers as $ans) {

                        foreach ($ans as $ans_id => $answer) {
                            // check if answer is other type of or not
                            $is_other = '';
                            $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                            $matrix_row = $oAnswer->radio_image;
                            $image_data = explode(',', $matrix_row);
                            $ext = explode('data:image/', $image_data[0]);

                            $ext_arr = explode(';base64', $ext[1]);

                            if (!empty($ext_arr[0])) {
                                $final_ext = '.' . $ext_arr[0];

                                // check whether fiel exists or not on given path
                                $imgdata = 'upload/' . $ans_id . $final_ext;
                                if (SugarAutoLoader::fileExists($imgdata)) {
                                    $imgPath = $imgdata;
                                } else {
                                    $imgPath = '';
                                }
                            }
                            if ($oAnswer->answer_type == 'other') {
                                $is_other = 'is_other_option';
                            }
                            if (empty($imgPath)) {
                                $html .= '<div style="display:inline;"><img src="custom/include/images/radio1.png" height="11px" width="11px">'
                                        . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                        . "</div><br/>";
                            } else {
                            $html .= '<div style="display:inline;"><img src="custom/include/images/radio1.png" height="11px" width="11px">&nbsp;<img height="11px" width="11px" src="' . $imgPath . '">'
                                    . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                    . "</div><br/>";
                        }
                        }
                        $op++;
                    }
                }
            }

            $html .= "</div></div>";
            return $html;
            break;
        case 'dropdownlist':
            $placeholder_label_other = '';
            if ($list_lang_detail[$que_id . '_other_placeholder_label']) {
                $placeholder_label_other = $list_lang_detail[$que_id . '_other_placeholder_label'];
            }
            $html = "<div class='option select-list two-col' id='{$que_id}_div'>";
            // if sorting
            if ($is_sort == 1) {
                foreach ($answers as $ans) {
                    foreach ($ans as $ans_id => $answer) {
                        $options[$ans_id] = $answer;
                    }
                }
                asort($options);

                foreach ($options as $ans_id => $answer) {
                    // check if answer is other type of or not
                    $is_other = '';
                    $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                    if ($oAnswer->answer_type == 'other') {
                        $is_other = 'is_other_option';
                    }
                    $html .= '<div style="display:inline;"><img src="custom/include/images/radio1.png" height="11px" width="11px">'
                            . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                            . "</div><br/>";
                }
            }
            // if not sorting
            else {
                foreach ($answers as $ans) {
                    foreach ($ans as $ans_id => $answer) {
                        // check if answer is other type of or not
                        $is_other = '';
                        $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                        if ($oAnswer->answer_type == 'other') {
                            $is_other = 'is_other_option';
                        }
                        $html .= '<div style="display:inline;"><img src="custom/include/images/radio1.png" height="11px" width="11px">'
                                . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                                . "</div><br/>";
                    }
                }
            }

            $html .= "</div>";
            return $html;
            break;
        case 'textbox':
            $html = "<div class='option select-list two-col' id='{$que_id}_div'>";
            $html .= '<img src="custom/include/images/input1.png" height="30px" width="400px">';
            $html .= "</div><br/>";
            return $html;
            break;
        case 'commentbox':
            $html = "<div class='option select-list two-col' id='{$que_id}_div'>";
            // rows & columns value given for comment box
            $html .= '<img src="custom/include/images/comment1.png" width="500px">';
            $html .= "</div><br/>";
            return $html;
            break;
        case 'rating':
            $html = "<div class='option select-list' id='{$que_id}_div'>";
            // star count is given
            if (!empty($maxsize)) {
                $starCount = $maxsize;
            }
            //default 5 star
            else {
                $starCount = 5;
            }
            //generate star as per given star numbers
            for ($i = 1; $i <= $starCount; $i++) {
                $html .= '<img src="custom/include/images/star1.png" height="30px" width="30px">';
            }
            $html .= "</div>";
            return $html;
            break;
        case 'contact-information':

            $html = "<div class='option input-list two-col' id='{$que_id}_div'>";
            $html .= '<img src="custom/include/images/contactinfo1.png"  width="500px">';
            $html .= "</div>";
            return $html;
            break;
        case 'date-time':
            $html = "<div class='option select-list two-col' id='{$que_id}_div'>";
            $html .= '<img src="custom/include/images/input1.png" height="30px" width="250px">';
            $html .= "</div>";
            return $html;
            break;
        case 'scale':
        case 'netpromoterscore':
            //display scale input field
            $html = "<div id='{$que_id}_div' style='display:inline;'>";
            $html .= '<img src="custom/include/images/input-small.png" height="30px" width="100px">';
            $html .= "</div>";
            return $html;
            break;
        case 'matrix':
            $display_type = $advancetype == 'checkbox' ? 'checkbox' : 'radio'; // display selection type for matrix
            $rows = array();
            $rows = json_decode($matrix_row);
            $cols = json_decode($matrix_col);

            // Initialize counter - count number of rows & columns
            $row_count = 1;
            $col_count = 1;
            // Do the loop
            foreach ($rows as $result) {
                // increment row counter
                $row_count++;
            }
            foreach ($cols as $result) {
                // increment  column counter
                $col_count++;
            }
            // adjusting div width as per column
            $width = 100 / ($col_count + 1) . "%";
            $margin_block = $width + 20 . '%';

            $html = '<div class="matrix-tbl-contner">';
            $html .= "<table class='survey_tmp_matrix' id='{$que_id}_div'>";
            $op = 0;
            for ($i = 1; $i <= $row_count; $i++) {

                $html .= '<tr class="row">';

                for ($j = 1; $j <= $col_count + 1; $j++) {
                    $row = $i - 1;
                    $col = $j - 1;
                    //First row & first column as blank
                    if ($j == 1 && $i == 1) {
                        $html .= "<th class='matrix-span' style='width:" . $width . "'>&nbsp;</th>";
                    }
                    // Rows Label
                    else if ($j == 1 && $i != 1) {
                        if (!empty($list_lang_detail[$que_id . '_matrix_row' . $row])) {
                            $row_header = $list_lang_detail[$que_id . '_matrix_row' . $row];
                        } else {
                            $row_header = $rows->$row;
                        }
                        $html .= "<th class='matrix-span' style='font-weight:bold; width:" . $width . ";text-align:left; height: 50px;'>" . $row_header . "<br/></th>";
                    } else {
                        //Columns label
                        if ($j <= ($col_count + 1) && $cols->$col != null && !($j == 1 && $i == 1) && ($i == 1 || $j == 1)) {
                            if (!empty($list_lang_detail[$que_id . '_matrix_col' . $col])) {
                                $col_header = $list_lang_detail[$que_id . '_matrix_col' . $col];
                            } else {
                                $col_header = $cols->$col;
                            }
                            $html .= "<th class='matrix-span' style='font-weight:bold; width:" . $width . "'>" . $col_header . "</th>";
                        }
                        //Display answer input (RadioButton or Checkbox)
                        else if ($j != 1 && $i != 1 && $cols->$col != null) {
                            $html .= "<td class='matrix-span' style='width:" . $width . "; '>"
                                    . "<span class='md-" . $display_type . "' style='margin-left:" . $margin_block . "'>";
                            $html .= '<img src="custom/include/images/radio1.png" height="11px" width="11px"></img><br/>'
                                    . "</span>"
                                    . "</td>";
                        }
                        // If no value then display none
                        else {
                            $html .= "";
                        }
                    }
                    $op++;
                }
                $html .= "</tr>";
            }
            $html .= "</table></div><br/>";
            return $html;
            break;
        case 'image':
            //display scale input field
            $html = "<div id='{$que_id}_div' style='display:inline;'>";
            if ($que_title == 'uploadImage') {
                $image_data = explode(',', $matrix_row);
                $ext = explode('data:image/', $image_data[0]);

                $ext_arr = explode(';base64', $ext[1]);

                if (!empty($ext_arr[0])) {
                    $final_ext = '.' . $ext_arr[0];

                    // check whether fiel exists or not on given path
                    $imgdata = 'upload/' . $que_id . $final_ext;
                    if (SugarAutoLoader::fileExists($imgdata)) {
                        $html .= '<img src="upload/' . $que_id . $final_ext . '" height="350px" width="500px">';
                    }
                }
            } else {
                $html .= '<img src="' . $advancetype . '" height="350px" width="500px">';
            }
            $html .= "</div>";
            return $html;
            break;
        case 'emojis':
            $emojisImges = array(
                1 => "custom/include/images/ext-unsatisfy.png",
                2 => "custom/include/images/unsatisfy.png",
                3 => "custom/include/images/nuteral.png",
                4 => "custom/include/images/satisfy.png",
                5 => "custom/include/images/ext-satisfy.png",
            );
            $html = "<div class='option radio-list' id='{$que_id}_div'>";
            $html .= '<div style="display:inline-grid;">';
            $op = 1;

            foreach ($answers as $ans) {
                foreach ($ans as $ans_id => $answer) {
                    $html .= '<div style="display:inline;"><img src="custom/include/images/radio1.png" height="11px" width="11px">&nbsp;<img src="' . $emojisImges[$op] . '" height="11px" width="11px">'
                            . '&nbsp; <span style="height:15px;margin-top:5px;">' . htmlspecialchars_decode($answer) . '</span>'
                            . "</div><br/>";
                    $op++;
    }
}


            $html .= "</div></div>";
            return $html;
            break;
    }
}

require_once 'vendor/tcpdf/tcpdf.php';
require_once 'vendor/tcpdf/config/lang/eng.php';

// create new PDF document
$pdf = new TCPDF('p', 'mm', 'A4', true, 'UTF-8', false);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// set font
$pdf->SetFont('helvetica', '', 11);
$pdf->AddPage();

$html = '';
if (!empty($survey->survey_logo)) {

    $html_image = 'data:image/png;base64,' . base64_decode($decode_arr[1]);

    $image_type = getImgType('upload/' . $survey->survey_logo);

    if (!empty($image_type)) {

        $imgdata = "upload/" . $survey->survey_logo . '.' . $image_type;

        if (SugarAutoLoader::fileExists($imgdata)) {

            $pdf->Image($imgdata, 85, 16, 40, 20, $image_type);

            $pdf->setJPEGQuality(75);
        }
    }
}
$html .= '<br/><br/><form><h2 style="text-align:center;">' . $name . '</h2>';


foreach ($survey_details as $page_sequence => $detail) {
    $html .= '<div style="text-decoration:underline;width:600px;height:50px;"><h1>' . $detail['page_title'] . '</h1></div>';

    foreach ($detail['page_questions'] as $que_sequence => $question) {
        if ($question['que_type'] != 'doc-attachment' && $question['que_type'] != 'richtextareabox') {

            $html .='<h3 class="questions">';


            if ($question['que_type'] == 'image' || $question['que_type'] == 'video') {
                $html .= $question['question_help_comment'];
            } else if ($question['que_type'] == 'section-header') {
                $html .= '<div class="question-section">' . $question['que_title'] . '</div><br/>';
            } else if ($question['que_type'] == 'additional-text') {
                $html .= '<div class="question-section">' . $question['description'] . '</div><br/>';
            } else {
                $que_no++;
                $img_flag = false;
                $html .= $que_no . ' .&nbsp;';
                if ($question['que_type'] == 'scale') {
                    $html .= $question['que_title'] . '&nbsp;<span style="height:15px;margin-top:5px;">[' . $question['min'] . ' - ' . $question['max'] . ']</span>';
                } else if ($question['que_type'] == 'netpromoterscore') {
                    $html .= $question['que_title'] . '&nbsp;<span style="height:15px;margin-top:5px;">[0 - 10]</span>';
                } else {
                    $html .= $question['que_title'];
                }
                if ($question['is_required'] == 1) {
                    $html .= '  <span class="is_required" style="color:red;">*</span>';
                }
            }
            if ($question['que_type'] == 'image' || $question['que_type'] == 'video') {
                // do not display help comment on top-right side
            }
            $html .= '</h3>';

            $html .= getMultiselectHTML($question, $list_lang_detail);
        }
    }

    generate_pdf($pdf, $html, $page_sequence);
    $html = '';
}
//clear buffer first
ob_clean();
//Close and output document
if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'word') {
    $pdf->Output($name . '.doc', 'D');
} else {
    $pdf->Output($name . '.pdf', 'D');
}

/*
 * Write PDF data from survey HTML
 */

function generate_pdf($pdf, $survey_form_html, $page) {
    // Add new page in PDF
    if ($page != '1') {
        $pdf->AddPage();
    }
    // Write page data to PDF
    $pdf->writeHTML($survey_form_html, true, false, false, false, '');
}

/*
 * Find Image Type from given file path
 */

function getImgType($filepath) {
    if (exif_imagetype($filepath) == IMAGETYPE_JPEG) {
        return 'jpg';
    } elseif (exif_imagetype($filepath) == IMAGETYPE_PNG) {
        return 'png';
    } else {
        $types = explode('IMAGETYPE_', exif_imagetype($filepath));
        return strtolower($types[1]);
    }
}
