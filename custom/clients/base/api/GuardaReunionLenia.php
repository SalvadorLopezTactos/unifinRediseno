<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GuardaReunionLenia extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GuardaReunionLenia' => array(
                'reqType' => 'POST',
                'noLoginRequired' => true,
                'path' => array('GuardaReunionLenia'),
                'pathVars' => array(''),
                'method' => 'ActualizaReunionLenia',
                'shortHelp' => 'Actualiza Reunión de Lenia',
            ),
        );
    }

    public function ActualizaReunionLenia($api, $args)
    {
	  try {
        // Busca Reunión
        $Reunion = new SugarQuery();
        $Reunion->select(array('id'));
        $Reunion->from(BeanFactory::getBean('Meetings'), array('team_security' => false));
	    $Reunion->where()->equals('id', $args['idReunion']);
        $result1 = $Reunion->execute();
        if(empty($result1[0]['id'])) {
			$respuesta['codigo'] = 400;
			$respuesta['mensaje'] = "Error con información enviada";
			$GLOBALS['log']->fatal("Error con información enviada");
			throw new SugarApiExceptionInvalidParameter("Error con información enviada");
        }
		else {
			// Actualiza Reunión
            $Meeting = BeanFactory::retrieveBean('Meetings', $args['idReunion'], array('disable_row_level_security' => true));
            $Meeting->link_lenia_c = $args['IdSala'];
			$Meeting->date_start = $args['horaInicio'];
			$Meeting->date_end = $args['horaFin'];
			$Meeting->duration_minutes = $args['duracion'];
			$Meeting->description = $Meeting->description. "\n\n----------------------\n Comentarios de la sesión realizada \n----------------------\n" .$args['comentarios'];
			$Meeting->resultado_c = $args['resultado'];
			$Meeting->status = "Held";
            $Meeting->save();
			// Crea Minuta
			global $app_list_strings;
			$Minuta = BeanFactory::newBean("minut_Minutas");
			$Minuta->account_id_c = $Meeting->parent_id;
			$Minuta->tct_relacionado_con_c = $Meeting->parent_name;
			$Minuta->objetivo_c = $Meeting->objetivo_c;
			$Minuta->minut_minutas_meetingsmeetings_idb = $Meeting->id;
			$Minuta->minut_minutas_meetings_name = $Meeting->name;
			$Minuta->name = "Minuta ".date_format(date_create($Meeting->date_end),"j/n/Y")." ".$app_list_strings['objetivo_list'][$Meeting->objetivo_c];
			$Minuta->assigned_user_id = $Meeting->assigned_user_id;
			$Minuta->assigned_user_name = $Meeting->assigned_user_name;
			$Minuta->resultado_c = $Meeting->resultado_c;
			$Minuta->save();
			// Actualiza Participantes
			$participantes = explode(",", $args['asistentes']);
			foreach ($participantes as $asistente) {
				if($asistente) {
					$Asistentes = BeanFactory::retrieveBean('minut_Participantes', $asistente, array('disable_row_level_security' => true));
					$Asistentes->minut_minutas_minut_participantesminut_minutas_ida = $Minuta->id;
					$Asistentes->tct_asistencia_c = 1;
					$Asistentes->save();
				}
			}
			// Crea Objetivo
			$beanObjetivo = BeanFactory::newBean('minut_Objetivos');
            $beanObjetivo->name = $app_list_strings['objetivo_list'][$Meeting->objetivo_c];
            $beanObjetivo->minut_minutas_minut_objetivosminut_minutas_ida = $Minuta->id;
            $beanObjetivo->tct_cumplimiento_chk = 1;
            $beanObjetivo->save();
			// Relaciona Objetivos
			$Meeting->load_relationship('meetings_minut_objetivos_1');
			$relatedObjetivos = $Meeting->meetings_minut_objetivos_1->getBeans();
			$totalObjetivos = count($relatedObjetivos);
			if($totalObjetivos > 0) {
				foreach($relatedObjetivos as $objetivo) {
					$Objetivos = BeanFactory::retrieveBean('minut_Objetivos', $objetivo->id, array('disable_row_level_security' => true));
					$Objetivos->minut_minutas_minut_objetivosminut_minutas_ida = $Minuta->id;
					$Objetivos->tct_cumplimiento_chk = 1;
					$Objetivos->save();
				}
			}
			$respuesta['codigo'] = 200;
			$respuesta['mensaje'] = "Registro actualizado correctamente";
		}
        return $respuesta;
      }
	  catch (Exception $e) {
		if($respuesta['codigo'] != 400) {
			$respuesta['codigo'] = 500;
			$respuesta['mensaje'] = "Error con servidor";
			$GLOBALS['log']->fatal("Error con servidor");
			throw new SugarApiExceptionInvalidParameter("Error con servidor");
		}
		return $respuesta;
	  }
    }
}
