<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class meet_creditaria_clas
{
    function meet_creditaria_func($bean, $event, $arguments)
    {
		if($bean->status == "Held" && $bean->parent_type == 'Accounts' && $bean->parent_id) {
			$beanAccount = BeanFactory::getBean('Accounts', $bean->parent_id);
			if($beanAccount->user_id_c == $bean->assigned_user_id) {
				global $db;
				$update = "update uni_productos set estatus_atencion = 1 where id = (select accounts_uni_productos_1uni_productos_idb producto from accounts_uni_productos_1_c where deleted = 0 and accounts_uni_productos_1accounts_ida = '{$bean->parent_id}' and accounts_uni_productos_1uni_productos_idb in (select id from uni_productos where deleted = 0 and tipo_producto = 10))";
				$result = $db->query($update);
			}
		}
	}
}
?>
