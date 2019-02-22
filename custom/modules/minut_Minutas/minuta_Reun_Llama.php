<?php

class Minuta_reun_llam{
	function SaveReunllam($bean=null, $event=null, $args=null){
		$GLOBALS['log']->fatal('>>>>>>>Entro al Hook numero 10 de after_save');
		$objRellam=$bean->minuta_reuniones_llamadas;
		if($objRellam['tipo_registro']=="reunion"){
			//$GLOBALS['log']->fatal(print_r($objRellam,true));
			$bean_reunion=BeanFactory::newBean('Meetings');
			$bean_reunion->name=$objRellam['nombre'];
			$start=date("d/m/Y h:i a", strtotime($objRellam['date_start']."T".$objRellam['time_start']));
			$bean_reunion->date_start=$start;
			$end=date("d/m/Y h:i a", strtotime($objRellam['date_end']."T".$objRellam['time_end']));
			$bean_reunion->duration_hours=$objRellam['duracion_hora'];
			$bean_reunion->duration_minutes=$objRellam['duracion_minuto'];
			$bean_reunion->parent_id=$objRellam['account_id_c'];
			$bean_reunion->parent_type='Accounts';
			$bean_reunion->assigned_user_id=$objRellam['assigned_user_id'];
			$bean_reunion->objetivo_c=$objRellam['objetivoG'];
			$bean_reunion->reunion_objetivos=$objRellam['objetivoE'];
			$bean_reunion->save();
		}

		if($objRellam['tipo_registro']=="llamada"){
			//$GLOBALS['log']->fatal(print_r($objRellam,true));
			$bean_llamada=BeanFactory::newBean('Calls');
			$bean_llamada->name=$objRellam['nombre'];
			$start=date("d/m/Y h:i a", strtotime($objRellam['date_start']."T".$objRellam['time_start']));
			$bean_llamada->date_start=$start;
			$end=date("d/m/Y h:i a", strtotime($objRellam['date_end']."T".$objRellam['time_end']));
			$bean_llamada->duration_hours=$objRellam['duracion_hora'];
			$bean_llamada->duration_minutes=$objRellam['duracion_minuto'];
			$bean_llamada->parent_id=$objRellam['account_id_c'];
			$bean_llamada->parent_type='Accounts';
			$bean_llamada->assigned_user_id=$objRellam['assigned_user_id'];
			$bean_llamada->save();
		}
	}
}