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
    'triggerFields' => array('tipo_registro_cuenta_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'referenciador_c',
                'value' => 'and(equal($origendelprospecto_c,"Referenciador"),or(equal($tipo_registro_cuenta_c,"3"),equal($tipo_registro_cuenta_c,"2")))',
            ),
        ),
    ),
);

$dependencies['Accounts']['tct_status_atencion_ddw_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('tipo_registro_cuenta_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'tct_status_atencion_ddw_c',
                'value' => 'or(equal($tipo_registro_cuenta_c,"3"),equal($tipo_registro_cuenta_c,"2"),equal($tipo_registro_cuenta_c,"1"))',
            ),
        ),
    ),
);

$dependencies['Accounts']['tct_pais_expide_rfc_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('deudor_factor_c','tct_pais_expide_rfc_c','tipo_relacion_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'tct_pais_expide_rfc_c',
                'value' => 'or(equal($deudor_factor_c,"1"),equal($tipo_relacion_c,"Proveedor de Recursos L"),equal($tipo_relacion_c,"Proveedor de Recursos F"),equal($tipo_relacion_c,"Proveedor de Recursos CA"),equal($tipo_relacion_c,"Proveedor de Recursos CS"))',
            ),
        ),
    ),
);