<?php
 /**
 * @author salvador.lopez@tactos.com.mx
 * @date   24/03/2020
 */
$hook_array['before_save'][] = Array(
    17,
    'Llena plantilla csv con clientes con linea vigente',//Just a quick comment about the logic of it
    'custom/modules/Accounts/Account_Hooks.php', //path to the logic hook
    'Account_Hooks', // name of the class
    'set_csv_linea_vigente' // name of the function.
);
