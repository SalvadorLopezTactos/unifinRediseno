<?php
$dependencies['Cases']['area_interna_c'] = array
(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('tipo_seguimiento_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'area_interna_c',
                'label' => 'LBL_AREA_INTERNA',
                'value' => 'equal($tipo_seguimiento_c, "1")',
            ),
        ),
    ),
    'notActions' => array(),
);

$dependencies['Cases']['team_name'] = array
(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('tipo_seguimiento_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'team_name',
                'label' => 'LBL_TEAM_NAME',
                'value' => 'equal($tipo_seguimiento_c, "1")',
            ),
        ),
    ),
    'notActions' => array(),
);

$dependencies['Cases']['follow_up_datetime'] = array
(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('tipo_seguimiento_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'follow_up_datetime',
                'label' => 'LBL_FOLLOW_UP_DATETIME',
                'value' => 'equal($tipo_seguimiento_c, "1")',
            ),
        ),
    ),
    'notActions' => array(),
);