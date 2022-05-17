<?php
$dependencies['Tasks']['detalle_motivo_potencial_c'] = array
(
	'hooks' => array('all'),
	'trigger' => 'true',
	'triggerFields' => array('potencial_negocio_c','motivo_potencial_c'),
	'onload' => true,
	'actions' => array(
		array(
			'name' => 'SetRequired',
			'params' => array
			(
				'target' => 'detalle_motivo_potencial_c',
				'label' => 'LBL_DETALLE_MOTIVO_POTENCIAL',
				'value'=>'and(equal($potencial_negocio_c,"2"),equal($motivo_potencial_c,"4"))',
			),
		),
	),
);