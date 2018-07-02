<?php
/**
 *
 * author: Salvador Lopez
 * Date: 13/03/18
 * LH que establece nuevo registro Tel_Telefonos con misma información que phone_office
 */
$hook_array['after_save'][] = Array(
    9,
    'Establece nuevo registro de Teléfono',//Just a quick comment about the logic of it
    'custom/modules/Accounts/Account_Phones.php', //path to the logic hook
    'Account_Phones', // name of the class
    'setAccountPhones' // name of the function.
);