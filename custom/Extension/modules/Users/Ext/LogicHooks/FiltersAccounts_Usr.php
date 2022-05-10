<?php
/**
 * Created F. Javier G. Solar
 * User: javier.garcia@tactos.com.mx
 * Date: 19/12/18
 * Time: 11:41 AM
 */

$hook_array['after_save'][] = Array(
    10,
    'Crea, Actualiza o Elimina el Filtro de las Cuentas por Usuario Firmado',
    'custom/modules/Users/AssignFilterAccountsUsr.php',
    'AssignFilterAccountsUsr',
    'AssignFilterAccounts_ByUsr'
);

$hook_array['before_save'][] = Array(
    11,
    'Actualiza a los usuario a quien les reporta',
    'custom/modules/Users/AssignFilterAccountsUsr.php',
    'AssignFilterAccountsUsr',
    'UpdateReportToUsr'
);


?>