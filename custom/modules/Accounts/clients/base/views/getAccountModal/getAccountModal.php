<?php
/**
 * Created by PhpStorm.
 * User: tactos
 * Date: 13/03/20
 * Time: 09:48 AM
 */

$viewdefs['Accounts']['base']['view']['getAccountModal'] = array(
    'buttons' => array(
        array(
            'name' => 'cancel_button',
            'type' => 'button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'value' => 'cancel',
            'css_class' => 'btn-primary',
        ),
        array(
            'name' => 'update_account_button',
            'type' => 'button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'value' => 'save',
            'css_class' => 'btn-primary',
        ),
    ),
    'panels' => array(
        array(
            'fields' => array(

            )
        )
    )
);