<?php
/**
 * The file used to set a before save logic hook of survey automizer condition checking and perform action according to that 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */

    $hook_array['before_save'][] = Array(
        99, 
        'Check Survey Automizer', 
        'custom/biz/classes/check_survey_automizer.php', 
        'check_survey_automizer_class', 
        'check_survey_automizer_method'
    );