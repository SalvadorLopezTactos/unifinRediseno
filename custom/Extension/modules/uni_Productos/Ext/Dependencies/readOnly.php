<?php

$dependencies['uni_Productos']['readonly_fields'] = array(
    'hooks' => array('edit', 'view'),
    'trigger' => 'true',
    'triggerFields' => array('metodo_asignacion_lm_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'metodo_asignacion_lm_c',
                'value' => 'true',
            ),
        ),
    ),
);
