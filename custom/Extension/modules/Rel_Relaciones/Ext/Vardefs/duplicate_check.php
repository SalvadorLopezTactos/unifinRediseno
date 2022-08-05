<?php

$dictionary['Rel_Relaciones']['duplicate_check'] = array(
        'enabled' => true,
        'FilterDuplicateCheck' => array(
            'filter_template' => array(
				array(
					'$or' => array(
						array('name' => array('$equals' => '$name')),
						array('relaciones_activas' => array('$equals' => '$relaciones_activas')),
						//array('accounts.id' => array('$equals' => '$account_id')),
						//array('dnb_principal_id' => array('$starts' => '$dnb_principal_id')),
					)
				),
            ),
            'ranking_fields' => array(
            )
        )
	);
