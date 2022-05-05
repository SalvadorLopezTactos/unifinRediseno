<?php
/**
 * User: Adrian Arauz
 * Date: 3/05/2022
 * Time: 11:35 AM
 */

$dependencies['Prospects']['LBL_RECORDVIEW_PANEL3'] = array(
    'hooks' => array("edit","view"),
    'trigger' => 'true',
    'triggerFields' => array('LBL_RECORDVIEW_PANEL3'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL3',
                'value' => 'true',
            ),
        ),
    ),
    //notActions is a list of actions to fire when the trigger is false
    'notActions' => array(
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL3',
                'value' => 'false',
            ),
        ),
    ),
);