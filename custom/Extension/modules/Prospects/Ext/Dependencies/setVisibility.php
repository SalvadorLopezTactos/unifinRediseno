<?php
/**
 * User: Adrian Arauz
 * Date: 3/05/2022
 * Time: 11:35 AM
 */

$dependencies['Prospects']['panel_auxiliar'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('panel_auxiliar'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL3',
                'value' => 'true',
            ),
        ),
    ),
);