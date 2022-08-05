<?php
 /**
 * @author ECB
 * @date   27/01/2022
 */
$hook_array['before_save'][] = Array(
    24,
    'Valida RFC en Cuentas y Leads',
    'custom/modules/Accounts/acct_valida_rfc.php',
    'acct_valida_rfc',
    'acct_valida_rfc'
);
