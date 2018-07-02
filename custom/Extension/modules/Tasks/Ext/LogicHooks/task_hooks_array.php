<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/26/2015
 * Time: 8:11 PM
 */
$hook_array['before_save'][] = Array(
    1,
    'after workflow, get task details from parent account',
    'custom/modules/Tasks/Task_Hooks.php',
    'Task_Hooks', // name of the class
    'afterWorkflow'
);