<?php

class Publico_Objetivo_Meetings{

	//Establece Cancelado registro padre de Público Objetivo en caso de que el resultado Ilocalizable se haya establecido por 5ta ocasión
	function set_cancelado_po($bean=null, $event=null, $args=null){
		$resultado_actual = $bean->resultado_c;
		//Ilocalizable
		if( $bean->parent_type == 'Prospects' ){

			$id_prospecto = $bean->parent_id;
			$beanPO = BeanFactory::retrieveBean('Prospects', $id_prospecto, array('disable_row_level_security' => true));
			$numero_ilocalizable = 0;
			if( $resultado_actual == '27' ){
				
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
                
                //Obtener reuniones relacionadas
				if ($beanPO->load_relationship('meetings')) {
					$relatedMeetings = $beanPO->meetings->getBeans();
		
					if (!empty($relatedMeetings)) {
						
						foreach ($relatedMeetings as $meeting) {

							if( $meeting->resultado_c == '27' ){
								$numero_ilocalizable += 1;
								$GLOBALS['log']->fatal("ILOCALIZABLE NUMERO". $numero_ilocalizable);
							}

						}
					}
				}

				$GLOBALS['log']->fatal("PROSPECTO ILOCALIZABLE POR ". $numero_ilocalizable. " ocasión");

				if( $numero_ilocalizable >= 5 && $beanPO->estatus_po_c != '4'){

					$GLOBALS['log']->fatal("El Público Objetivo ". $beanPO->id." se establece CANCELADO al ser ilocalizable por 5ta ocasión");
					$beanPO->estatus_po_c = '4';//Cancelado
					$beanPO->save();

				}
			}
			
	
		} 
		
	}
}
