<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 07/03/18
 * Time: 11:47
 */
$dependencies['Opportunities']['readOnly_person'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('id'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'account_name', //campo por afectar
                'value' => 'not(equal($id,""))',
            ),
        ),

    )

);
$dependencies['Opportunities']['readOnly_Monto_c'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('negocio_c','tipo_producto_c'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'monto_c', //campo por afectar
                'value' => 'equal($negocio_c,"2")',
            ),
        ),
    )

);