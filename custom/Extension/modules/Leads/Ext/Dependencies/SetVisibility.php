<?php
/**
 * Created by Adrián Arauz.
 * Date: 29/11/2021
 * Time: 11:15 AM
 */

$dependencies['Leads']['metodo_asignacion_lm_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','metodo_asignacion_lm_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'metodo_asignacion_lm_c',
                'value' => 'equal($metodo_asignacion_lm_c,"")',
            ),
        ),
    ),
);

$dependencies['Leads']['omite_match_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','omite_match_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'omite_match_c',
                'label'=>'LBL_OMITE_MATCH',
                'value' => 'true',
            ),
        ),
    ),
);


$dependencies['Leads']['homonimo_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','homonimo_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'homonimo_c',
                'label'=>'LBL_OMITE_MATCH',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Leads']['c_registro_reus_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','c_registro_reus_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'c_registro_reus_c',
                'value' => 'false',
            ),
        ),
    ),
);

$dependencies['Leads']['m_registro_reus_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','m_registro_reus_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'm_registro_reus_c',
                'value' => 'false',
            ),
        ),
    ),
);

$dependencies['Leads']['o_registro_reus_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','o_registro_reus_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'o_registro_reus_c',
                'value' => 'false',
            ),
        ),
    ),
);