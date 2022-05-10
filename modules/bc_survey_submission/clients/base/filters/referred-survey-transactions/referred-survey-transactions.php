<?php
/**
     * The file used to handle filter of survey submission record list component 
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */
$viewdefs['bc_survey_submission']['base']['filter']['referred-survey-transactions'] = array(
    'create' => true,
    'filters' => array(
        array(
            'id' => 'referred-survey-transactions',
            'name' => 'LBL_REFERRED_SURVEY_TRANSACTIONS',
            'filter_definition' => array(
                array(
                    'bc_survey_submission_bc_surveybc_survey_ida' => array(
                        '$in' => array(''),
                    ),
                ),
            ),
            'editable' => false,
        ),
    ),
);
