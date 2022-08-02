<?php
class detalle_faltante
{
    function detalle_faltante($bean, $event, $arguments)
    {
        //Llena el campo detalle_c
		if ($bean->parent_id) {
			$bean->detalle_c = "";
			if ($bean->parent_type == "Accounts") {
				$Cuenta = BeanFactory::getBean('Accounts', $bean->parent_id);
				if($bean->persona_relacion_c == '' && $Cuenta->tipodepersona_c == 'Persona Moral') $bean->detalle_c = 2;
			}
			global $db;
			global $current_user;
			$id = $bean->parent_id;
			$usuario = $current_user->id;
			if($bean->parent_type == "Accounts") $query = "select distinct id cuenta, name nombre from accounts where deleted = 0 
and id in (select rel_relaciones_accounts_1accounts_ida from rel_relaciones_accounts_1_c where deleted = 0 
and rel_relaciones_accounts_1rel_relaciones_idb in (select id_c from rel_relaciones_cstm where account_id1_c = '{$id}'))";
			if($bean->parent_type == "Leads") $query = "select a.id cuenta, b.name_c nombre from leads a, leads_cstm b where a.id = b.id_c and
assigned_user_id = '{$usuario}' and deleted = 0 and id in (select leads_leads_1leads_ida from leads_leads_1_c where deleted = 0 and
leads_leads_1leads_idb = '{$id}')";
			$result = $db->query($query);
			if($bean->padres_c == '' && $db->getRowCount($result) > 0) $bean->detalle_c = 1;
        }
    }
}
