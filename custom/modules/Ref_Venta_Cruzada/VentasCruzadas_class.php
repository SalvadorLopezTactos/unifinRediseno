<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class VentasCruzadas_class
{

    function validacionAlta($bean, $event, $arguments)
    {
		$no_valido = 0;
		$id_cuenta = '';
		//$GLOBALS['log']->fatal($bean->producto_referenciado .'--'. $bean->producto_origen);
		if($bean->estatus != '2' && $bean->producto_referenciado == $bean->producto_origen){
			$no_valido = 1;
			
		}else if($bean->estatus != '2'){
			if ($bean->load_relationship('accounts_ref_venta_cruzada_1')) {
				//Fetch related beans
				$relatedBeans = $bean->accounts_ref_venta_cruzada_1->getBeans();
			
				$parentBean = false;
				if (!empty($relatedBeans)) {
					//order the results
					reset($relatedBeans);
			
					//first record in the list is the parent
					$parentBean = current($relatedBeans);
					$auxrel = 'accounts_uni_productos_1';
					
					$id_cuenta = $parentBean->id;
					if($parentBean->load_relationship('accounts_uni_productos_1')){
						//$parentBean->load_relationship($auxrel);
						$beans = $parentBean->accounts_uni_productos_1->getBeans();
						if (!empty($beans)) {
							foreach($beans as $prod){
								//Producto desatendido estatus =2
								//$GLOBALS['log']->fatal($prod->estatus_atencion.' estatus producto');
								//id no es null || vacio	
								if($bean->producto_referenciado == $prod->tipo_producto && $prod->estatus_atencion = '1' ){
									//$array = $GLOBALS['app_list_strings']['usuarios_no_ceder_list'];
									$no_valido = 1;
								}
							}
						}
					}					
				}
			}
			
			if ($parentBean->load_relationship('opportunities')) {
				//Fetch related beans
				$relatedBeans = $parentBean->opportunities->getBeans();
				//$GLOBALS['log']->fatal('oportunidades');
				if (!empty($relatedBeans)) {
					foreach($relatedBeans as $oppor){
						//Producto desatendido estatus =2     //mismo producto
						//$GLOBALS['log']->fatal($oppor->tipo_producto_c .'--'. $oppor->tct_opp_estatus_c.'-'.$oppor->estatus_c);
		       			if($bean->producto_referenciado == $oppor->tipo_producto_c && $oppor->tct_opp_estatus_c=='1' 
							&& !($oppor->estatus_c =='K'||$oppor->estatus_c =='R'||$oppor->estatus_c =='CM')){
							$no_valido = 1;							
						}
					}
				}
			}
			
			$mesactual = date("n");
			$anioactual = date("Y");
			//$GLOBALS['log']->fatal('año - '.$mesactual.' , '.'mes - '.$anioactual);
			$query = 'SELECT bcl.id,bcl.anio, bcl.mes FROM accounts ac, lev_backlog bcl WHERE bcl.account_id_c = ac.id and ac.id = "'.$id_cuenta.'"';
			$results = $GLOBALS['db']->query($query);
			//$GLOBALS['log']->fatal('results',$results);
			while($row = $GLOBALS['db']->fetchByAssoc($results) )
			{
				//Use $row['id'] to grab the id fields value
				//$id = $row['id'];
				//$beanbacklog = BeanFactory::getBean('lev_backlog', $id);	
				//$GLOBALS['log']->fatal('año - '.$row['anio'].' , '.'mes - '.$row['mes']);
				if($row['anio'] > $anioactual ){
					$no_valido = 1;	
				}else if($row['anio'] == $anioactual && $row['mes'] > $mesactual){
					$no_valido = 1;	
				}				
			}			
		}
		
		if($no_valido == 1){
			$bean->estatus = 2;
			$bean->save();
		}

	}
}

?>