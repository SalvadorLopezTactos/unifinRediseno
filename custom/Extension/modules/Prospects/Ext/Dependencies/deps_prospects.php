<?php

$dependencies['Prospects']['read_only_compania']=array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('name','id','read_only_empresa_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'empresa_po_c',
                'value' => 'equal($read_only_empresa_c,1)',
            ),
        ),
    ),
    'notActions' => array(),
);

//La bandera que controla si el Nombre de La Empresa es "Solo Lectura" siempre está oculta
$dependencies['Prospects']['visibility_read_only_empresa_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('name','id','read_only_empresa_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'read_only_empresa_c',
                'value' => 'equal(0,1)',
            ),
        ),
    ),
);