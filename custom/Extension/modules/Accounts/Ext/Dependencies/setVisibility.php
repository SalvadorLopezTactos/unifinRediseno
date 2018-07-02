<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 5/4/2017
 * Time: 6:15 PM
 */

$dependencies['Accounts']['comision_referenciador_c_Visibility'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('referenciador_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'comision_referenciador_c',
                'value' => 'not(equal($referenciador_c,""))',
            ),
        ),
    ),
);

$dependencies['Accounts']['referenciador_c_Visibility'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('tipo_registro_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'referenciador_c',
                'value' => 'and(equal($origendelprospecto_c,"Referenciador"),or(equal($tipo_registro_c,"Cliente"),equal($tipo_registro_c,"Prospecto")))',
            ),
        ),
    ),
);