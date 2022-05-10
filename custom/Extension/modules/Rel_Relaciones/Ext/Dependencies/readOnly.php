<?php
global $current_user;
global $app_list_strings;
$admin=$current_user->is_admin;
$id = $app_list_strings['tct_persona_generica_list']['accid'];
$dependencies['Rel_Relaciones']['readOnly'] = array
(
            'hooks' => array("all"),
            'trigger' => 'true',
            'triggerFields' => array('id'),
            'onload' => true,
            'actions' => array
	    (
                array
		(
                    'name' => 'ReadOnly',
                    'params' => array
		    (
                        'target' => 'edit_button',
                        'label' => 'LBL_EDIT_BUTTON_LABEL',
                        'value' => 'and(equal($account_id1_c,"'.$id.'"),equal('.$admin.',0))',
                    ),
                ),
            ),
            'notActions' => array(),
);
