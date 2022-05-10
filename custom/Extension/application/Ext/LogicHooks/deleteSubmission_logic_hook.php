<?php

/**
 * The file used to delete a survey submission of currently deleted record
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */

$hook_array['after_delete'][] = Array(
        //Processing index. For sorting the array.
        99, 

        //Label. A string value to identify the hook.
        'submission_after_delete', 

        //The PHP file where your class is located.
        'custom/biz/classes/deleteSubmission.php', 

        //The class the method is in.
        'deletedSubmission', 

        //The method to call.
        'deletedSubmission_method' 
    );