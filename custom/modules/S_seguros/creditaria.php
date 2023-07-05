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
		$hoy = date("Y-m-d");
		if($bean->inicio_vigencia_emitida_c <= $hoy && $bean->fin_vigencia_emitida_c >= $hoy) $update = "update uni_productos a, uni_productos_cstm b set a.estatus_atencion = 1, b.status_management_c = 1 where a.id = b.id_c and b.id_c = (select accounts_uni_productos_1uni_productos_idb producto from accounts_uni_productos_1_c where deleted = 0 and accounts_uni_productos_1accounts_ida = '{$bean->s_seguros_accountsaccounts_ida}' and accounts_uni_productos_1uni_productos_idb in (select id from uni_productos where deleted = 0 and tipo_producto = 10))";
		else $update = "update uni_productos set estatus_atencion = 1 where id = (select accounts_uni_productos_1uni_productos_idb producto from accounts_uni_productos_1_c where deleted = 0 and accounts_uni_productos_1accounts_ida = '{$bean->s_seguros_accountsaccounts_ida}' and accounts_uni_productos_1uni_productos_idb in (select id from uni_productos where deleted = 0 and tipo_producto = 10))";
		$result = $db->query($update);
    }
}
