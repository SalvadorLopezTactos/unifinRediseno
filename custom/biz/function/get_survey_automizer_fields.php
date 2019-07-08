<?php

/**
 * The file used to get target modules for creating survey automizer
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
function target_module_list() {
    //target modules list
    $workflow_object = BeanFactory::getBean('WorkFlow');
    $base_module = $workflow_object->get_module_array();

    //exclude survey modules from the target module list
    $excluded_module_list = array(
        'bc_automizer_actions',
        'bc_automizer_condition',
        'bc_submission_data',
        'bc_survey',
        'bc_survey_answers',
        'bc_survey_automizer',
        'bc_survey_pages',
        'bc_survey_questions',
        'bc_survey_template',
        'bc_survey_submission',
        'KBDocuments',
        'ProjectTask',
        'Products',
        'Campaigns',
        'Emails',
        'Forecasts'
    );

    foreach ($base_module as $key => $module) {
        if (!in_array($key, $excluded_module_list)) {
            $target_module_list[$key] = $module;
        }
    }

    return $target_module_list;
}
