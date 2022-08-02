<?php
/**
 * Created by  Axel Flores
 * User: tactos
 * Date: 2022/11/05
 * Time: 9:04 AM
 */

/**
 * A) Funcionalidad: Genera a nivel Base de datos el Filtro de registros del Modulo de Cuentas
 *    Afectando tambien a quienes Reporta el usuario modificado.
 *    Existen dos listas principales.
 *     1.- filterAccounts_PuestoUsr_list: almacena los Puestos excluyentes de filtro, se toma el id de la lista original
 *         de puesto de usuario.
 *     2.- filterAccounts_RolesUsr_list: contiene el nombre de los Roles excluyentes de filtro, estos nombres deben ser igual
 *         que el listado de roles.
 *
 * B) Recupera al usuario a quien reportaba anteriormente y modifica sus filtros para que ya no puedan compartir registros
 *    afectando a los usuarios a quienes le reportaban.
 *    Despues toma al usuario al que le reportara actualmente y genera sus nuevos filtros afectando tambien a quienes
 *    le reportan.
 *
 * C) La varieble $GLOBALS['fetched_reports_to_id'] almacena el bean antes de ser modificado, este es ejecutado en el
 *    before_save
 */

global $app_list_strings;

$GLOBALS['fetched_reports_to_id'] = "";


class filterPO
{

    function AssignFilterAccounts_ByUsr($bean = null, $event = null, $args = null)
    {
        $GLOBALS['log']->fatal("Entra LH - Bean: ". $bean->id);
        // $GLOBALS['log']->fatal('reports_to_id: ' .$bean->reports_to_id);
        // $GLOBALS['log']->fatal('pre_reports_to_id: ' .$bean->pre_reports_to_id);
        global $app_list_strings;
        $GLOBALS['log']->fatal("Estado: Actualizando Filtros");
        $puesto = $bean->puestousuario_c;
        $puestosListUsr = $app_list_strings['filterAccounts_PuestoUsr_list'];
        $AplicaFiltro = "";
        $idUsuario = $bean->id;
        $campo = "";

       
        //Elimina filtros existentes
        if ($this->deleteAllFilterUsr($bean)) {
            $GLOBALS['log']->fatal("Estado: Filtro Eliminado");
            
            // Filtro Para Leads Agente Telefonico
            if ($puesto == 27 || $puesto==31) {
                $queryInsert = "insert IGNORE into filters(id, name, date_entered, date_modified, modified_user_id, created_by, description, deleted, team_id, team_set_id, assigned_user_id,filter_definition,filter_template,module_name, acl_team_set_id)
select u.id,
       'Mis Prospectos' as name,
       '2021-02-26 18:00:00' as date_entered,
       '2021-02-26 18:00:00' as date_modified,
       u.id as modified_user_id,
       u.id as created_by,
       null as description,
       0 as deleted,
       u.default_team as team_id,
       u.team_set_id as team_set_id,
       null assigned_user_id,  
       concat('[{\"excluye_campana_c\":{\"\$equals\"\:\"0\"}}]') as filter_definition,
       concat('[{\"excluye_campana_c\":{\"\$equals\"\:\"0\"}}]') as filter_template,
       'Prospects' as module_name,
       null as acl_team_set_id
from users u, users_cstm uc
where u.id= uc.id_c 
and u.status = 'Active'";
                $GLOBALS['db']->query($queryInsert);
                $GLOBALS['log']->fatal("Se aplica Filtro Mis Prospectos");
            }
            
        } 
    }


    function deleteAllFilterUsr($usuario)
    {
        $banderaDelete = true;
        $queryDelete = "DELETE FROM filters
            WHERE id = '{$usuario->id}' OR (created_by = '{$usuario->id}' AND name = 'Mis Prospectos')";
        try {
            $queryResultDelete = $GLOBALS['db']->query($queryDelete);
        } catch (Exception $e) {
            $GLOBALS['log']->fatal("Error al eliminar el Filtro del usuario" . $usuario->id . "Error: " . $e);
            $banderaDelete = false;
        }
        // $GLOBALS['log']->fatal("voy a eliminar dela tabla filtro al usuario " . $usuario->id);
        // $GLOBALS['log']->fatal("Query " . $queryDelete);
        return $banderaDelete;
    }

    
}
