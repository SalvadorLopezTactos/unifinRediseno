<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * The file used to manage actions for Automizer actions
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
 
global $app_strings;

$dashletMeta['bc_automizer_actionsDashlet'] = array('module'		=> 'bc_automizer_actions',
										  'title'       => translate('LBL_HOMEPAGE_TITLE', 'bc_automizer_actions'), 
                                          'description' => 'A customizable view into bc_automizer_actions',
                                          'icon'        => 'icon_bc_automizer_actions_32.gif',
                                          'category'    => 'Module Views');