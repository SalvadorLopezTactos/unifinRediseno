<?php
/**
 * User: EJC
 * Date: 30/08/21
 * Time: 05:16 PM
 */

//require_once("modules/Accounts/clients/base/api/AccountsRelateApi.php");
class cstmRelateApi extends RelateApi
{
    public function filterRelated(ServiceBase $api, array $args)
    {
		global $current_user, $db;
		$relatedArray = parent::filterRelated($api, $args);
		$conteo = 0;
		//$GLOBALS['log']->fatal($args);
    $favorite = isset($args['favorite']) ? $args['favorite'] : false;
    $module = isset($args['module']) ? $args['module'] : '';
    $link_name = isset($args['link_name']) ? $args['link_name'] : '';
		if($favorite == 'true' && $module == 'Accounts' && $link_name == 'rel_relaciones_accounts_1')
		{
			$auxArray = $relatedArray['records'];
			foreach ($auxArray as $clave => $valor) {
				$axid = $valor['id'];
				$query = "SELECT * FROM sugarfavorites WHERE module = 'Rel_Relaciones' and  record_id = '{$axid}' and deleted = 0";
				$queryResult = $db->query($query);
				$row = $db->fetchByAssoc($queryResult);
				if(!empty($row)){
					$relatedArray['records'][$conteo]['favorito'] = true;
				}else{
					$relatedArray['records'][$conteo]['favorito'] = false;;
				}
				$conteo++;
			}
		}

		return $relatedArray;
    }

}
