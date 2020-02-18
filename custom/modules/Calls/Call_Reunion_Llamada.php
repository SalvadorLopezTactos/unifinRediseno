<?php

class Call_reunion_llamada{
	function SaveReunionLlamada($bean=null, $event=null, $args=null){
		$objRellam=$bean->calls_meeting_call;
		if ($objRellam != "") {
			if($objRellam['tipo_registro']=="reunion"){
			    if($objRellam['id']!=""){
			        //Actualizacion
	                $bean_reunion=BeanFactory::retrieveBean('Meetings', $objRellam['id']);
	            }else{
	                //Creación
	                $bean_reunion=BeanFactory::newBean('Meetings');
	            }

	            $bean_reunion->name=$objRellam['nombre']."";
	            $start=date("d/m/Y h:i a", strtotime($objRellam['date_start']."T".$objRellam['time_start']));
	            $bean_reunion->date_start=$start;
	            $end=date("d/m/Y h:i a", strtotime($objRellam['date_end']."T".$objRellam['time_end']));
	            $bean_reunion->duration_hours=$objRellam['duracion_hora'];
	            $bean_reunion->duration_minutes=$objRellam['duracion_minuto'];
	            $bean_reunion->parent_id=$objRellam['account_id_c'];
	            //$bean_reunion->parent_type='Accounts';
				$bean_reunion->parent_type=$bean->parent_type;
	            $bean_reunion->assigned_user_id=$objRellam['assigned_user_id'];
	            $bean_reunion->objetivo_c=$objRellam['objetivoG'];
	            $bean_reunion->reunion_objetivos=$objRellam['objetivoE'];
	            $bean_reunion->status='Planned';
	            $bean_reunion->tct_parent_call_id_txf_c=$bean->id;
	            $bean_reunion->save();
				
				/******************
				En caso de Lead se agrego la relación adicional por el tipo de relación mucho a muchos
				****************/
				
				if ($bean->parent_type == 'Leads'){
					$bean_reunion->load_relationship('leads');
					$bean_reunion->leads->add($bean->parent_id);
				}
			}

			if($objRellam['tipo_registro']=="llamada"){

			    if($objRellam['id']!=""){
	                //Actualización
	                $bean_llamada=BeanFactory::retrieveBean('Calls', $objRellam['id']);
	            }else{
	                //Creación
	                $bean_llamada=BeanFactory::newBean('Calls');
	            }

	            $bean_llamada->name=$objRellam['nombre']. "";
	            //$bean_llamada->minut_minutas_calls_1minut_minutas_ida=$bean->id;
	            $start=date("d/m/Y h:i a", strtotime($objRellam['date_start']."T".$objRellam['time_start']));
	            $bean_llamada->date_start=$start;
	            $end=date("d/m/Y h:i a", strtotime($objRellam['date_end']."T".$objRellam['time_end']));
	            $bean_llamada->duration_hours=$objRellam['duracion_hora'];
	            $bean_llamada->duration_minutes=$objRellam['duracion_minuto'];
	            $bean_llamada->parent_id=$objRellam['account_id_c'];
	            //$bean_llamada->parent_type='Accounts';
				$bean_llamada->parent_type=$bean->parent_type;
	            $bean_llamada->assigned_user_id=$objRellam['assigned_user_id'];
	            $bean_llamada->status='Planned';
	            $bean_llamada->tct_parent_call_id_txf_c=$bean->id;
	            $bean_llamada->save();

				/******************
				En caso de Lead se agrego la relación adicional por el tipo de relación mucho a muchos
				****************/
				if ($bean->parent_type == 'Leads'){
					$bean_llamada->load_relationship('leads');
					$bean_llamada->leads->add($bean->parent_id);
				}

			}

		}
	}
}
