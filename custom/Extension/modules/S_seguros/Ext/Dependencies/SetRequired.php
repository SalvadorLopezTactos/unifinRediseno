<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27/08/20
 * Time: 11:11 AM
 */

$dependencies['S_seguros']['tipo_cambio_required'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('tipo_cambio_obj', 'monedas_c','prima_obj_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired', //Action type
            'params' => array(
                'target' => 'tipo_cambio_obj',
                'label' => 'tipo_cambio_obj_label',
                'value' => 'not(equal($monedas_c,1))', //Formula
            ),
        ),
    ),
);