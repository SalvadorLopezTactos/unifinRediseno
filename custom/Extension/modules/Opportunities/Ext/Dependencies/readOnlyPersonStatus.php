<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 07/03/18
 * Time: 11:47
 */
$dependencies['Opportunities']['readOnly_person'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('id'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'account_name', //campo por afectar
                'value' => 'not(equal($id,""))',
            ),
        ),

    )

);
