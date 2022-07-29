<?php

/**
 * The file used to customize layout by adding custom view to make all js changes upgrade safe 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$viewdefs['Prospects']['base']['layout']['record']['components'][] = array(
    'view' => 'sendsurveyfromrecord',
);