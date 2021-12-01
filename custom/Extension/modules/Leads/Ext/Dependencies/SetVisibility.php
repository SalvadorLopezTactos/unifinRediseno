<?php
/**
 * Created by Adrián Arauz.
 * Date: 29/11/2021
 * Time: 11:15 AM
 */

$dependencies['Leads']['metodo_asignacion_lm_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('metodo_asignacion_lm_c'),
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
    'triggerFields' => array('omite_match_c'),
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

