<?php
// ECB 17/08/2022 Re-enviar password para App de UnifinCard
class pass_TDC
{
    function pass_TDC($bean, $event, $arguments)
    {
		$anterior = $bean->fetched_row['email'];
		$anterior = $anterior[0]["email_address"];
		$nuevo = $bean->email;
		$nuevo = $nuevo[0]["email_address"];
		if($anterior != $nuevo) {
			//Consulta cuenta relacionada y relaciones activas
			global $db;
			$query = "select distinct a.id, b.relaciones_activas from accounts a, rel_relaciones b, rel_relaciones_cstm c where a.deleted = 0 
and b.deleted = 0 and b.id = c.id_c and b.relaciones_activas like '%Tarjetahabiente%' and c.account_id1_c = '{$bean->id}' 
and a.id in (select rel_relaciones_accounts_1accounts_ida from rel_relaciones_accounts_1_c where deleted = 0 
and rel_relaciones_accounts_1rel_relaciones_idb in (select b.id_c from rel_relaciones a, rel_relaciones_cstm b where a.id = b.id_c 
and a.relaciones_activas like '%Tarjetahabiente%' and a.deleted = 0 and b.account_id1_c = '{$bean->id}'))";
			$result = $db->query($query);
			while ($row = $db->fetchByAssoc($result)) {
				$relaciones = str_replace("^", "", $row['relaciones_activas']);
				$relaciones = explode(",", $relaciones);
				//Consume servicio de TDC UnifinCard
				$api_params = array(
					'idCuenta' => $row['id'],
					'idRelacion' => $bean->id,
					'relaciones' => $relaciones,
					'correo' => $nuevo
				);
				require_once("custom/clients/base/api/email_TDC.php");
				$email_TDC = new email_TDC();
				$response = $email_TDC->emailTDC(null,$api_params);
				$GLOBALS['log']->fatal("Respuesta TDC:");
				$GLOBALS['log']->fatal($response);
			}
		}
    }
}