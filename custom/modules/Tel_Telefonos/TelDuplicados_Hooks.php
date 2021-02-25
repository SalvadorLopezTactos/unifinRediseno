<?php
/**
 * Created by JG.
 * User: tactos
 * Date: 24/02/21
 * Time: 05:35 PM
 */

class TelDuplicados_Hooks
{
    public function validaTelDuplicados($bean = null, $event = null, $args = null)
    {
        global $db;

        if ($_REQUEST['module'] != 'Import' &&  $_SESSION['platform'] != 'base') {
           // $GLOBALS['log']->fatal('>>>>VALORES VIENE DE UN API ');
            $idCuenta = $bean->accounts_tel_telefonos_1accounts_ida;
            //$GLOBALS['log']->fatal('>>>>$args Cuenta ' . $idCuenta);
            //$GLOBALS['log']->fatal('>>>>VALORES INICIALES ' . $bean->telefono . " -- " . $bean->principal . " -- " . $bean->deleted);
            $espacioTel = str_replace(' ', '', $bean->telefono);
            $bean->name = str_replace(' ', '', $bean->name);

            // Recuperamos todos los telefonos asociados a la cuenta

            $QuerySelect = "SELECT telefono.id,telefono.telefono,telefono.principal,telefono.estatus,telefono.tipotelefono 
FROM accounts_tel_telefonos_1_c rel
INNER JOIN tel_telefonos telefono
ON telefono.id=rel.accounts_tel_telefonos_1tel_telefonos_idb
WHERE rel.accounts_tel_telefonos_1accounts_ida='{$idCuenta}'
AND rel.deleted=0
AND telefono.deleted=0";
            $resultQ = $db->query($QuerySelect);
            $existPrincipal = false;
            $existTel = false;
            while ($row = $db->fetchByAssoc($resultQ)) {
                if ($row['principal']) {
                    $existPrincipal = true;
                }
                if ($row['telefono'] == $espacioTel) {
                    $existTel = true;
                }
            }
            if (!$existTel) {
                if ($existPrincipal) {
                    $bean->principal = 0;
                }
            } /*else {
                $bean->deleted = 1;
            }*/
            //$GLOBALS['log']->fatal('>>>>VALORES FINALES ' . $bean->telefono . " -- " . $bean->principal . " -- " . $bean->deleted);
        }
    }
}