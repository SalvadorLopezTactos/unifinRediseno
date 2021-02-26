<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ExistentesVentasCruzadas_class
{

    function BuscarExistentes($bean, $event, $arguments)
    {
		//$GLOBALS['log']->fatal('bean',$bean->estatus);
		if( !$arguments['isUpdate'] ){
		
			if ($bean->load_relationship('accounts_ref_venta_cruzada_1')) {
				//Fetch related beans
				$relatedBeans = $bean->accounts_ref_venta_cruzada_1->getBeans();
			
				$parentBean = false;
				if (!empty($relatedBeans)) {
					//order the results
					reset($relatedBeans);
			
					//first record in the list is the parent
					$parentBean = current($relatedBeans);
					$id_cuenta = $parentBean->id;
				}
			}
			
			//$parent_id=$bean->parent_id;
			$query = "select ref.name from Ref_Venta_Cruzada as ref
			join accounts_ref_venta_cruzada_1_c as aref on aref.accounts_ref_venta_cruzada_1ref_venta_cruzada_idb = ref.id
			where aref.accounts_ref_venta_cruzada_1accounts_ida = '".$id_cuenta."' 
			and ref.producto_referenciado = '".$bean->producto_referenciado."' and ref.deleted = 0 ";
			if($bean->producto_referenciado == '9' || $bean->producto_referenciado == '8'){
				$query = $query . "and (ref.estatus = '1' or ref.estatus = '6')";
			}else{
				$query = $query . "and ref.estatus = '1'";
			}
			//$GLOBALS['log']->fatal('query',$query);
			$results = $GLOBALS['db']->query($query);
			//$GLOBALS['log']->fatal('results',$results);
			//$GLOBALS['log']->fatal('results_num',$results->num_rows);
			
			if($results->num_rows > 0){
				require_once 'include/api/SugarApiException.php';
				throw new SugarApiExceptionInvalidParameter("El producto seleccionado, tiene una referencia activa");
			}else{
				$bean->estatus = '1';

					$bean->load_relationship('teams');
					$equipoPrincipal = '1';
					//Add the teams
					$bean->teams->add(
						array(
							$equipoPrincipal
						)
					);
			}
		}
		
	}
}

?>