<?php
 if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * The file used to manage detail for Automizer 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$module_name = 'bc_survey_automizer';
$viewdefs[$module_name]['mobile']['layout']['detail'] = array(
    'type' => 'detail',
    'components' =>
    array(
        0 =>
        array(
            'view' => 'detail',
        )
    ),
);