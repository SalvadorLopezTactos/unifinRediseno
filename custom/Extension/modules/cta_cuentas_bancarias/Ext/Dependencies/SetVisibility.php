<?php
/**
 * Created by Erick de jesus
 * Date: 24/08/2022
 */
$dependencies['cta_cuentas_bancarias']['validada_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','validada_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'validada_c',
                'value' => 'false',
            ),
        ),
    ),
);

