<?php
$viewdefs['Opportunities']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterSolicitudTemplate',
    'name' => 'LBL_FILTER_SOLICITUD_TEMPLATE',
    'filter_definition' => array(
        array(
            'account_id' => ''
        ),
		array(
			'tct_etapa_ddw_c' => array(
				'$not_in' => array(),
			),
		),
		array(
			'estatus_c' => array(
				'$not_in' => array(),
			),
		),
	),
    'editable' => true,
    'is_template' => true,
);