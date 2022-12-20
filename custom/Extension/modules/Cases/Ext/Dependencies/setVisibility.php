<?php
/**
 * Created by tactos.
 * User: erick.cruz
 */

global $current_user;
$cac = $current_user->cac_c;

$dependencies['Cases']['contacto_principal_c_Visibility'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','name'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'contacto_principal_c',
                'value' => 'false',
            ),
        ),
    ),
);

/* Se omite dependencia para que sea visible en todo momento
$dependencies['Cases']['vip_c_Visibility'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('priority'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'vip_c',
                'value' => 'or(equal($priority,"P2"),equal($priority,"P3"))',
            ),
        ),
    ),
);
*/

$dependencies['Cases']['area_interna_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','producto_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'area_interna_c',
                'value' => 'and(not(equal($producto_c,"B621")),not(equal($producto_c,"B601")),equal($case_hd_c,1))',
            ),
        ),
    ),
);

/*$dependencies['Cases']['equipo_soporte_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','producto_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'equipo_soporte_c',
                'value' => 'and(not(equal($producto_c,"B621")),not(equal($producto_c,"B601")))',
            ),
        ),
    ),
);*/

$dependencies['Cases']['responsable_interno_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','producto_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'responsable_interno_c',
                'value' => 'and(not(equal($producto_c,"B621")),not(equal($producto_c,"B601")))',
            ),
        ),
    ),
);

$dependencies['Cases']['source'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','name'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'source',
                'value' => 'equal('.$cac.',1)',
            ),
        ),
    ),
);

$dependencies['Cases']['account_name'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','name','type'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'account_name',
                'value' => 'not(equal($type,"12"))',
            ),
        ),
    ),
);

$dependencies['Cases']['case_cuenta_relacion'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','name','type'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'case_cuenta_relacion',
                'value' => 'not(equal($type,"12"))',
            ),
        ),
    ),
);

$dependencies['Cases']['leads_cases_1_name'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','name','type'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'leads_cases_1_name',
                'value' => 'equal($type,"12")',
            ),
        ),
    ),
);