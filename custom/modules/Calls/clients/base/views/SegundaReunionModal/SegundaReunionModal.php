<?php

$viewdefs['Meetings']['base']['view']['SegundaReunionModal'] = array(
     'buttons' => array(
        array(
            'name' => 'cancel_button',
            'type' => 'button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'value' => 'cancel',
            'css_class' => 'btn-primary',
        ),
        array(
            'name' => 'update_call_button',
            'type' => 'button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'value' => 'save',
            'css_class' => 'btn-primary',
        ),
    ),
    'panels' => array(
		array(
		'fields' => array(
			0 =>
				array(
				'name' => 'name',
				'default' => true,
				'enabled' => true,
				'width' => 35,
				'required' => true //subject is required
							),
				1 =>
				array(
				'name' => 'description',
				'default' => true,
				'enabled' => true,
				'width' => 35,
				'required' => true, //description is required
				'rows' => 5,
               ),
            )
        )
    ),
);