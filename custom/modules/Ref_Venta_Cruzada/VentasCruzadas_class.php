<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class VentasCruzadas_class
{

    function validacionAlta($bean, $event, $arguments)
    {
		$no_valido = 0;
		$id_cuenta = '';
		//$GLOBALS['log']->fatal('datos -'.$bean->estatus.'-'.$bean->date_entered.'-'.$bean->producto_referenciado.'-'. $bean->producto_origen);

		if( $bean->producto_referenciado != 8 && $bean->producto_referenciado != 9 ){

        	if($bean->estatus == '1' && !$arguments['isUpdate']) {
				if( $bean->producto_referenciado == $bean->producto_origen ){
					$no_valido = 1;
				
				}else{
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
									//$GLOBALS['log']->fatal($bean->producto_referenciado.' producto_referenciado producto');
									foreach($beans as $prod){
										//$GLOBALS['log']->fatal($prod->tipo_producto.' tipo_producto');

										//Producto desatendido estatus =2
										if($bean->producto_referenciado == $prod->tipo_producto){
											$array = $GLOBALS['app_list_strings']['usuarios_ref_no_validos_list'];

											//usuario no este en 9, lista usuarios_no_ceder_list
											//id no es null || vacio
											//$GLOBALS['log']->fatal('producto no valido');
											if($prod->estatus_atencion == '1' && !in_array($prod->assigned_user_id, $array)){
												$GLOBALS['log']->fatal('producto no valido');
												$no_valido = 1;
											}
										}
									}
								}
							}					
						}
					}
					//$GLOBALS['log']->fatal($no_valido.'no_valido');

					if ($parentBean->load_relationship('opportunities')) {
						//Fetch related beans
						$relatedBeans = $parentBean->opportunities->getBeans();
						//$GLOBALS['log']->fatal('oportunidades');
						if (!empty($relatedBeans)) {
							$hoy = date("Y-m-d");  
							$GLOBALS['log']->fatal('hoy: '.$hoy);
							foreach($relatedBeans as $oppor){
								//Producto desatendido estatus =2     //mismo producto							
								if($bean->producto_referenciado == $oppor->tipo_producto_c){
									$auxdate = date($oppor->vigencialinea_c);
									$GLOBALS['log']->fatal($oppor->tipo_producto_c .'--'. $oppor->tct_opp_estatus_c.'-'.$oppor->tct_etapa_ddw_c.'-'.$oppor->estatus_c.'-'.$auxdate);
									if( $oppor->tct_opp_estatus_c=='1' && !($oppor->estatus_c =='K'||$oppor->estatus_c =='R'||$oppor->estatus_c =='CM')){
										$no_valido = 1;	
									} 

									if($oppor->tct_opp_estatus_c == 1 && $oppor->tct_etapa_ddw_c =='CL' && $oppor->estatus_c=='N' ){
										//$GLOBALS['log']->fatal('linea activa');
										if($auxdate < $hoy){
											$GLOBALS['log']->fatal('expirado');
											$no_valido = 0;	
										}
									}
								}
							}
						}
					}

					//$GLOBALS['log']->fatal($no_valido.'no_valido');
				
					$mesactual = date("n");
					$anioactual = date("Y");
					//$GLOBALS['log']->fatal('año - '.$mesactual.' , '.'mes - '.$anioactual);
					$query = 'SELECT bcl.id,bcl.anio, bcl.mes FROM accounts ac, lev_backlog bcl WHERE bcl.account_id_c = ac.id and ac.id = "'.$id_cuenta.'" and bcl.deleted=0';
					$results = $GLOBALS['db']->query($query);
					$GLOBALS['log']->fatal('results',$results);
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
					//$GLOBALS['log']->fatal($no_valido.'no_valido');
				}
			}
		}else if( !$arguments['isUpdate']){
			$bean->estatus = '6';
		}
		
		if($no_valido == 1){
			$bean->estatus = '2';
		}
		
		if($bean->cancelado == true){
			$bean->estatus = '3';
		}
	}

	function validaEquiposAsesores($bean, $event, $arguments){
		
		global $db;
		$asesor_origen=$bean->assigned_user_id;
		$asesor_referenciado=$bean->user_id_c;

		$producto_origen=$bean->producto_origen;
		$producto_referenciado=$bean->producto_referenciado;

		if($producto_origen ==$producto_referenciado){
			//Comprobando equipos de los asesores, se opta por query en lugar de bean, para evitar seguridad de equipos
			//y evitar doble consulta
			$query = "SELECT equipo_c FROM users_cstm WHERE id_c IN ('{$asesor_origen}','{$asesor_referenciado}')";
			$queryResult = $db->query($query);
			$array_equipos=array();
			while ($row = $db->fetchByAssoc($queryResult)) {
				array_push($array_equipos,$row['equipo_c']);
			}

			if(count($array_equipos)>0){
				$equipo_asesor1=$array_equipos[0];
				$equipo_asesor2=$array_equipos[1];
				$GLOBALS['log']->fatal(print_r($array_equipos,true));

				if($equipo_asesor1==$equipo_asesor2 && $bean->ref_validada_av_c==0){
					$GLOBALS['log']->fatal('EQUIPOS DE ASESORES SON IGUALES, SE PROCEDE A INVALIDAR REFERENCIA CRUZADA');
					//Estatus No válida => 2
					$bean->estatus='2';
				}

			}

		}




	}
}

?>