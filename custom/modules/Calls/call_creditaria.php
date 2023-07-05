<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class call_creditaria_clas
{
    function call_creditaria_func($bean, $event, $arguments)
    {
		if($bean->status == "Held" && $bean->parent_type == 'Accounts' && $bean->parent_id) {
			$beanAccount = BeanFactory::getBean('Accounts', $bean->parent_id);
			if($beanAccount->user_id_c == $bean->assigned_user_id) {
				global $db;
				$update = "update uni_productos p inner join accounts_uni_productos_1_c ap on ap.accounts_uni_productos_1uni_productos_idb = p.id set p.estatus_atencion = 1 where ap.accounts_uni_productos_1accounts_ida = '{$bean->parent_id}' and ap.deleted = 0 and p.tipo_producto = 10 and p.deleted = 0";
				$result = $db->query($update);
			}
		}
	}
}
?>
