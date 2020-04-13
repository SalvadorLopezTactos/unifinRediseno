<?php
/** Metdata for the add note custom popup view
 * The buttons array contains the buttons to be shown in the popu
 * The fields array can be modified accordingly to display more number of fields if required
 * */
$viewdefs['C5515_uni_chattigo']['base']['view']['getConversationModal'] = array(
	'buttons' => array(
		array(
			'name' => 'cancel_button',
			'type' => 'button',
			'label' => 'LBL_CANCEL_BUTTON_LABEL',
			'value' => 'cancel',
			'css_class' => 'btn-invisible btn-link',
        ),
    ),
	'panels' => array(
		array(
			'fields' => array(
			)
		)
	)
);