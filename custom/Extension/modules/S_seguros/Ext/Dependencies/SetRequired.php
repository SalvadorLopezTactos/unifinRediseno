<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27/08/20
 * Time: 11:11 AM
 */

$dependencies['S_seguros']['tipo_cambio_obj'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('tipo_cambio_obj','monedas_c','prima_obj_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'tipo_cambio_obj',
                'label' => 'LBL_TIPO_CAMBIO_OBJ',
                'value' => 'not(equal($monedas_c,1))',
            ),
        ),
    ),
);

$dependencies['S_seguros']['tipo_cambio_n'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('monedas_c','info_actual','prima_neta_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'tipo_cambio_n',
                'label' => 'LBL_TIPO_CAMBIO_N',
                'value' => 'and(equal($info_actual,1),not(equal($monedas_c,1)))',
            ),
        ),
    ),
);

$dependencies['S_seguros']['tipo_cambio_ganada_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('monedas_c','etapa'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'tipo_cambio_ganada_c',
                'label' => 'LBL_TIPO_CAMBIO_GANADA',
                'value' => 'and(equal($etapa,9),not(equal($monedas_c,1)))',
            ),
        ),
    ),
);