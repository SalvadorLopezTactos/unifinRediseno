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
    'triggerFields'=> array('tipo_registro_c, id'),
    'onload'=> true,
    'actions'=> array(
        array(
            'name'=>'SetValue',
            'params'=> array(
                'target'=>'esproveedor_c',
                'label'=>'LBL_ESPROVEEDOR',
                'value'=>'ifElse(equal($tipo_registro_c,"Proveedor"),true, $esproveedor_c)'
            ),
        ),
    ),
);

$dependencies['Accounts']['no_website_c']= array
(
    'hooks'=> array("all"),
    'trigger'=>'true',
    'triggerFields'=> array('no_website_c'),
    'onload'=> true,
    'actions'=> array(
        array(
            'name'=>'SetValue',
            'params'=> array(
                'target'=>'website',
                'label'=>'LBL_WEBSITE',
                'value'=>'ifElse($no_website_c,"",$website)'
            ),
        ),
    ),
);
?>