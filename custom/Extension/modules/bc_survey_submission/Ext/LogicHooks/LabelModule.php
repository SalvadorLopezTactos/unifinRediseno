<?php
/**
 * The file used to call logichook to handle listview related module labels 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */

    $hook_array['process_record'][] = Array(
        //Processing index. For sorting the array.
        99,
       
        //Label. A string value to identify the hook.
        'retrieve_module_label',
       
        //The PHP file where your class is located.
        'custom/modules/bc_survey_submission/retrieve_module_label_class.php',
       
        //The class the method is in.
        'retrieve_module_label_class',
       
        //The method to call.
        'retrieve_module_label'
    );

?>