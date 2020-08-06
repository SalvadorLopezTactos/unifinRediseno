<?php
$dependencies['S_seguros']['panel_visibility']=array(
    'hooks' => array("edit","view"),
    'trigger' => 'true',
    'triggerFields' => array('info_actual'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL1',
                'value' => 'equal($info_actual,1)',
            ),
        ),
    ),
   	'notActions' => array(),
);