<?php

$viewdefs['Employees']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterAgenteTelefonicoTemplate',
    'name' => 'LBL_FILTER_USER_BY_PUESTO',
    'filter_definition' => array(
        array(
            'puestousuario_c' => array(
                '$in' => array(),
            ),
        ),
    ),
    'editable' => true,
    'is_template' => true,
);