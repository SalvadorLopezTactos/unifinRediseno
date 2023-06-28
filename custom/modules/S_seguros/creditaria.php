<?php
/*
 * Created by Tactos
 * Email: eduardo.carrasco@tactos.com.mx
 * Date: 21/06/2023
*/

class creditaria_clas
{
    public function creditaria_func($bean = null, $event = null, $args = null)
    {
		global $db;
        global $current_user;
		if($bean->fetched_row['id'] != $bean->id && in_array("Seguros - Creditaria", ACLRole::getUserRoleNames($current_user->id))) {
            $query1 = "select a.id from s_seguros a, s_seguros_cstm b where a.id = b.id_c and a.deleted = 0 and a.etapa <> 10 and a.tipo = {$bean->tipo} and b.inicio_vigencia_emitida_c <= CURDATE() and b.fin_vigencia_emitida_c >= CURDATE() and a.id in (select s_seguros_accountss_seguros_idb from s_seguros_accounts_c where deleted = 0 and s_seguros_accountsaccounts_ida = '{$bean->s_seguros_accountsaccounts_ida}')";
            $resultado1 = $db->query($query1);
            $encontrado1 = $db->fetchByAssoc($resultado1);
            $query2 = "select a.id from s_seguros a, s_seguros_cstm b where a.id = b.id_c and a.deleted = 0 and a.etapa <> 10 and a.tipo = {$bean->tipo} and a.id in (select s_seguros_accountss_seguros_idb from s_seguros_accounts_c where deleted = 0 and s_seguros_accountsaccounts_ida = '{$bean->s_seguros_accountsaccounts_ida}')";
            $resultado2 = $db->query($query2);
            $encontrado2 = $db->fetchByAssoc($resultado2);
            if($encontrado1 || $encontrado2) throw new SugarApiExceptionInvalidParameter("Esta oportunidad no se puede guardar debido a que ya existe una oportunidad en proceso con el mismo Tipo de Negocio");
        }
    }
}
