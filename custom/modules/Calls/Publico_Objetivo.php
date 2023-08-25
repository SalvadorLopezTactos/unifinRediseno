<?php

class Publico_Objetivo{

	//Establece Cancelado registro padre de Público Objetivo en caso de que el resultado Ilocalizable se haya establecido por 5ta ocasión
	function set_cancelado_po($bean=null, $event=null, $args=null){
		
		$resultado_actual = $bean->tct_resultado_llamada_ddw_c;
		//Ilocalizable
		if( $bean->parent_type == 'Prospects' ){

			$id_prospecto = $bean->parent_id;
			
			if( $resultado_actual == 'Ilocalizable' ){
				$numero_ilocalizable = 1;
				$beanPO = BeanFactory::retrieveBean('Prospects', $id_prospecto, array('disable_row_level_security' => true));

				//Obtener llamadas relacionadas
				if ($beanPO->load_relationship('calls')) {
					$relatedBeans = $beanPO->calls->getBeans();
		
					if (!empty($relatedBeans)) {
						
						foreach ($relatedBeans as $call) {

							if( $call->tct_resultado_llamada_ddw_c == 'Ilocalizable' ){
								$numero_ilocalizable += 1;
								$GLOBALS['log']->fatal("ILOCALIZABLE NUMERO". $numero_ilocalizable);
							}

						}
					}
				}

				$GLOBALS['log']->fatal("PROSPECTO ILOCALIZABLE POR ". $numero_ilocalizable. " ocasión");

				if( $numero_ilocalizable == 5 ){

					$GLOBALS['log']->fatal("El Público Objetivo ". $beanPO->id." se establece CANCELADO al ser ilocalizable por 5ta ocasión");
					$beanPO->estatus_po_c = '4';//Cancelado
					$beanPO->save();

				}
			}
			
	
		} 
		
	}
}
