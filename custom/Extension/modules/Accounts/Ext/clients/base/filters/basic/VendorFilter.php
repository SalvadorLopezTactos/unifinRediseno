<?php
	$viewdefs['Accounts']['base']['filter']['basic']['filters'][] = array(
		'id' => 'VendorFilter',
		'name' => 'LBL_VENDOR_FILTER',
		'filter_definition' => array(
					array(
						'tipo_proveedor_compras_c'  => array(
						'$in' => array(
                            '6',
                        ),
					),
				),
			),
		'editable' => false,
		'is_template' => true,
	);