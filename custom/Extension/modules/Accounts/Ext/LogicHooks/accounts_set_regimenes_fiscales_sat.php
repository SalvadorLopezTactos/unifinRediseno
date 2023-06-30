<?php

$hook_array['before_save'][] = Array(
    32,
    'Establece valor en campo regimen_fiscal_sat_c con la respuesta del servicio que lee Constancia de Situación Fiscal',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'estableceRegimenesFiscalesSAT'
);