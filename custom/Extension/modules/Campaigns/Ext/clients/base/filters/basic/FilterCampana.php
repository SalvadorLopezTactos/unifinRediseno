<?php
	$viewdefs['Campaigns']['base']['filter']['basic']['filters'][] = array(
		'id' => 'FilterCampana',
		'name' => 'Activas',
		'filter_definition' => array(
					array(
					  'start_date' => array(
							'$lte' => '',
					  ),
          ),
					array(
					  'end_date' => array(
							'$gte' => '',
					  ),
				  ),
		),
		'editable' => true,
		'is_template' => true,
	);