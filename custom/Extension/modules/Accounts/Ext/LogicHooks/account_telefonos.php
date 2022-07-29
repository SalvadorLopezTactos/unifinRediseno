<?php
 /**
 * @file   account_telefonos.php
 * @author trobinson@levementum.com
 * @date   6/5/2015 2:11 PM
 * @brief  Account telefonos hook array
 */
$hook_array['after_save'][] = Array(
    4,

    'Manage Related Telefonos',//Just a quick comment about the logic of it

    'custom/modules/Accounts/Account_Hooks.php', //path to the logic hook

    'Account_Hooks', // name of the class

    'account_telefonos' // name of the function.

);
