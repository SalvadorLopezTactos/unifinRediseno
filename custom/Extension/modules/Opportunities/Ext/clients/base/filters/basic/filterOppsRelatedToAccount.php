<?php

$viewdefs['Opportunities']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterOppsRelatedToAccount',
    'name' => 'LBL_FILTER_OPPS_RELATED_TO_ACCOUNT',
    'filter_definition' => array(
        array(
            'account_id' => ''
        ),
        array(
            'estatus_c' => array(
                '$not_in' => array(),
            ),
        )
    ),
    'editable' => true,
    'is_template' => true,
);
