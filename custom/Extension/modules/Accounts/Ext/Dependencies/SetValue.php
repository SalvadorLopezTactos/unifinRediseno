<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 13/09/18
 * Time: 11:15 AM

 */
$dependencies['Accounts']['esproveedor_check']= array
(
    'hooks'=> array("all"),
    'trigger'=>'true',
    'triggerFields'=> array('tipo_registro_cuenta_c, id'),
    'onload'=> true,
    'actions'=> array(
        array(
            'name'=>'SetValue',
            'params'=> array(
                'target'=>'esproveedor_c',
                'label'=>'LBL_ESPROVEEDOR',
                'value'=>'ifElse(equal($tipo_registro_cuenta_c,"5"),true, $esproveedor_c)'
            ),
        ),
    ),
);