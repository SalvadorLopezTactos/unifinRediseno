<?php

$dependencies['C5515_uni_chattigo']['readonly_fields'] = array
(
    'hooks' => array('edit','view'),
    'trigger' => 'true',
    'triggerFields' => array('name'),
    'onload' => true,
    'actions' => array
    (
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'accounts_c5515_uni_chattigo_1_name',
                'value' => 'ifElse(not(equal($accounts_c5515_uni_chattigo_1_name,"")),true,false)',
            ),
        ),
		
		array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'leads_c5515_uni_chattigo_1_name',
                'value' => 'ifElse(not(equal($leads_c5515_uni_chattigo_1_name,"")),true,false)',
            ),
        ),  		        
    ),
);