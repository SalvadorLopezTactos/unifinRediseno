<?php

$dependencies['TCTBL_Backlog_Seguros']['name_readonly'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('editar'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'name',
                'label' => 'name_label',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['TCTBL_Backlog_Seguros']['etapa_readonly'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('editar'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'etapa',
                'label' => 'etapa_label',
                'value' => 'true',
            ),
        ),
    ),
);