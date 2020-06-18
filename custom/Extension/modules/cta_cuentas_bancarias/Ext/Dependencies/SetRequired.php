<?php
/**
 * Created by PhpStorm.
 * User: Adrian Arauz
 * Date: 27/05/20
 * Time: 03:54 PM
 */

$dependencies['cta_cuentas_bancarias']['Cuenta_required'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('cuenta','clabe'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'cuenta',
                'label' => 'cuenta_label',
                'value' => 'and(equal($cuenta,""),equal($clabe,""))',
            ),
        ),
    ),
);

$dependencies['cta_cuentas_bancarias']['Clabe_required'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('clabe','cuenta'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'clabe',
                'label' => 'clabe_label',
                'value' => 'and(equal($cuenta,""),equal($clabe,""))',
            ),
        ),
    ),
);

$dependencies['cta_cuentas_bancarias']['readOnly_idcorto'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('id'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'idcorto_c', //campo por afectar
                'value' => 'true',
            ),
        ),

    ),
);