<?php
/**
 * * User: salvador.lopez@tactos.com.mx
 */
$viewdefs['Users']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterActiveUsers',
    'name' => 'LBL_ACTIVE_USER',
    'filter_definition' => array(
        array(
            'status' => array(
                '$in' => array(),
            ),
        ),
    ),
    'editable' => true,
    'is_template' => true,
);