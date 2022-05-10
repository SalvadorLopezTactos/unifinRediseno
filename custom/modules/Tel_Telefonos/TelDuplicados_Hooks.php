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
            $idCuenta = $bean->accounts_tel_telefonos_1accounts_ida;

            //Valida existencia de teléfono principal
            $QuerySelect = "SELECT telefono.id,telefono.telefono,telefono.principal,telefono.estatus,telefono.tipotelefono
              FROM accounts_tel_telefonos_1_c rel
              INNER JOIN tel_telefonos telefono
                ON telefono.id=rel.accounts_tel_telefonos_1tel_telefonos_idb
              WHERE rel.accounts_tel_telefonos_1accounts_ida='{$idCuenta}'
                AND rel.deleted=0
                AND telefono.deleted=0
                AND telefono.id!='{$bean->id}'
                AND telefono.principal = 1";
            $resultQ = $db->query($QuerySelect);
            $totalPrincipal = $resultQ->num_rows;
            if($totalPrincipal>0){
              $bean->principal = 0;
            }else{
              $bean->principal = 1;
            }
        }
    }
}
