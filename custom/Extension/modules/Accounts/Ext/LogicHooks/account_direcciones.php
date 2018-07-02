<?php
 /**
 * @file   account_direcciones.php
 * @author trobinson@levementum.com
 * @date   6/10/2015 1:57 PM
 * @brief  account_direcciones hook array
 */
$hook_array['after_save'][] = Array(
    3,
    'Manage Related Direcciones',//Just a quick comment about the logic of it
    'custom/modules/Accounts/Account_Hooks.php', //path to the logic hook
    'Account_Hooks', // name of the class
    'account_direcciones' // name of the function.
);