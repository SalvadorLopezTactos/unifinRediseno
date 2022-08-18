<?php
 /**
 * @author ECB
 * @date   17/08/2022
 */
$hook_array['before_save'][] = Array(
    30,
    'Re-enviar password para App de UnifinCard',
    'custom/modules/Accounts/email_TDC.php',
    'pass_TDC',
    'pass_TDC'
);
