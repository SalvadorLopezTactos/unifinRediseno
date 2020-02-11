<?php
$viewdefs['Users']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterSubpuestoTemplate',
    'name' => 'Agentes Telefónicos',
    'filter_definition' => array(
        array(
            'subpuesto_c' => array(
                '$in' => array(),
            ),
        ),
    ),
    'editable' => true,
    'is_template' => true,
);