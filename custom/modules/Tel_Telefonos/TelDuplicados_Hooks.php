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
            //-- Consulta conteo teléfonos duplicados por cuenta
            $QuerySelect = "select
                  	a.id,
                      a.name,
                      a.date_entered,
                      uac.user_name, -- a.created_by,
                      a.date_modified,
                      uam.user_name, -- a.modified_user_id,
                      t.id idTelefono,
                      t.date_entered,
                      utc.user_name, -- t.created_by,
                      t.date_modified,
                      utc.user_name, -- t.modified_user_id
                      t.telefono,
                      t.deleted,
                      t.tipotelefono,
                      t.estatus,
                      t.principal
                  from
                  	accounts a
                  	inner join accounts_tel_telefonos_1_c at on at.accounts_tel_telefonos_1accounts_ida=a.id
                  	inner join tel_telefonos t on t.id= at.accounts_tel_telefonos_1tel_telefonos_idb
                  	inner join tel_telefonos_cstm tc on tc.id_c = t.id
                      inner join users uac on uac.id = a.created_by
                      inner join users uam on uam.id = a.modified_user_id
                      inner join users utc on utc.id = t.created_by
                      inner join users utm on utm.id = t.modified_user_id
                  where
                  	a.id = '{$idCuenta}'
                      and trim(t.telefono) = '{$bean->telefono}'
                      and at.deleted = 0
                      and t.deleted = 0
                      and t.id!='{$bean->id}'
                      and t.estatus = 'Activo'
                  order by t.date_entered asc
                  limit 1;";
            //Ejecuta consulta
            $resultQ = $db->query($QuerySelect);
            $totalPrincipal = $resultQ->num_rows;
            //Valida teléfono duplicado
            if($totalPrincipal>0){
                $GLOBALS['log']->fatal('Teléfono duplicado: '.$bean->telefono . ' ,para cuenta: '.$bean->accounts_tel_telefonos_1accounts_ida);
                require_once 'include/api/SugarApiException.php';
                throw new SugarApiExceptionInvalidParameter("El teléfono: ". $bean->telefono." , ya está registrado en esta cuenta.");
            }
        }
    }
}
