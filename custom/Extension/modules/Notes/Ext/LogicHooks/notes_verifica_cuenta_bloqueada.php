<?php
/*
 * Created by Salvador Lopez.
 */

$hook_array['before_save'][] = Array(
   21,
   'Evita guardado de registro en caso de que se relacione una cuenta bloqueada',
   'custom/modules/Check_Bloqueo_Cuenta.php',
   'Check_Bloqueo_Cuenta',
   'verifica_cuenta_bloqueada'
);
