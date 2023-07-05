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
		if($bean->inicio_vigencia_emitida_c <= $hoy && $bean->fin_vigencia_emitida_c >= $hoy) $update = "update uni_productos p inner join uni_productos_cstm pc on pc.id_c = p.id inner join accounts_uni_productos_1_c ap on ap.accounts_uni_productos_1uni_productos_idb = p.id set p.estatus_atencion = 1, pc.status_management_c = 1 where ap.accounts_uni_productos_1accounts_ida = '{$bean->parent_id}' and ap.deleted = 0 and p.tipo_producto = 10 and p.deleted = 0";
		else $update = "update uni_productos p inner join accounts_uni_productos_1_c ap on ap.accounts_uni_productos_1uni_productos_idb = p.id set p.estatus_atencion = 1 where ap.accounts_uni_productos_1accounts_ida = '{$bean->s_seguros_accountsaccounts_ida}' and ap.deleted = 0 and p.tipo_producto = 10 and p.deleted = 0";
		$result = $db->query($update);
    }
}
