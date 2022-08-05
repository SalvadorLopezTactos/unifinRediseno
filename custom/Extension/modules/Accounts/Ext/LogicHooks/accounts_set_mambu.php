<?php
 /**
 * @author salvador.lopez@tactos.com.mx
 * @date   22/04/2020
 */
$hook_array['before_save'][] = Array(
    18,
    'Establece integración con mambú para creación de nuevo cliente',
    'custom/modules/Accounts/Account_Hooks.php', //path to the logic hook
    'Account_Hooks', // name of the class
    'set_account_mambu' // name of the function.
);
