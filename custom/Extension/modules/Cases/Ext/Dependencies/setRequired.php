<?php
/**
 * Created by tactos.
 * User: salvador.lopez
 */

$dependencies['Cases']['area_interna_c_required'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('case_hd_c','name'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'area_interna_c',
                'value' => 'equal($case_hd_c,1)',
            ),
        ),
    ),
);