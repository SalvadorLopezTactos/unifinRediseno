<?php
/**
 * User: Adrian Arauz
 * Date: 3/05/2022
 * Time: 11:35 AM
 */

$dependencies['Prospects']['panel_3_visibility'] = array(
    'hooks' => array("edit","view"),
    'trigger' => 'true',
    'triggerFields' => array('panel_auxiliar'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'detailpanel_3',
                'value' => 'true',
            ),
        ),
    ),
);