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
							$GLOBALS['log']->fatal($bean->producto_referenciado.' producto_referenciado producto');
							foreach($beans as $prod){
								$GLOBALS['log']->fatal($prod->tipo_producto.' tipo_producto');
									
								//Producto desatendido estatus =2
								if($bean->producto_referenciado == $prod->tipo_producto){
									$array = $GLOBALS['app_list_strings']['usuarios_ref_no_validos_list'];
									$GLOBALS['log']->fatal(print_r($array,true));
									$GLOBALS['log']->fatal($prod->estatus_atencion.' estatus producto');
									$GLOBALS['log']->fatal($prod->assigned_user_id.' assigned_user_id');
									//usuario no este en 9, lista usuarios_no_ceder_list
									//id no es null || vacio
									
									if(!(in_array($prod->assigned_user_id, $array))){
                                       $no_valido=1;
									}else if($prod->estatus_atencion == '1'){
                                       $no_valido=1
									}
								}
							}
						}
					}					
				}
			}
			
			if ($parentBean->load_relationship('opportunities')) {
				//Fetch related beans
				$relatedBeans = $parentBean->opportunities->getBeans();
				$GLOBALS['log']->fatal('oportunidades');
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
			
			$GLOBALS['log']->fatal($no_valido.'no_valido');

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

			$GLOBALS['log']->fatal($no_valido.'no_valido');
		}
		
		if($no_valido == 1){
			$bean->estatus = 2;
			$bean->save();
		}

	}
}

?>