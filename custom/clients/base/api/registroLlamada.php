<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class registroLlamada extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'registroLlamada' => array(
                'reqType' => 'POST',
                'noLoginRequired' => false,
                'path' => array('registroLlamada'),
                'pathVars' => array(''),
                'method' => 'registroLlamadas',
                'shortHelp' => 'Genera llamada para Leads o Cuentas',
            ),
        );
    }

    public function registroLlamadas($api, $args)
    {
        //Busca Llamada Planificada de hoy
        $Llamadas = new SugarQuery();
        $Llamadas->select(array('id', 'date_entered', 'parent_id', 'status', 'tct_union_c', 'assigned_user_id'));
        $Llamadas->from(BeanFactory::getBean('Calls'), array('team_security' => false));
		$Llamadas->where()->dateBetween('date_entered', array(date("Y-m-d"),date("Y-m-d")));
		$Llamadas->where()->equals('parent_id', $args['idCRM']);
		$Llamadas->where()->equals('status', 'Planned');
        $Llamadas->where()->equals('tct_union_c', 1);
        $resultado = $Llamadas->execute();
        if(empty($resultado[0]['id'])) {
			//Busca Agente Telefónico
			require_once("custom/clients/base/api/GetAgenteCP.php");
			$apiAgente = new GetAgenteCP();
			$response = $apiAgente->getAgenteTelCP(null,null);
			$agente = $response['idAsesor'];
			//Crea Llamada
			$bean_Call = BeanFactory::newBean('Calls');
			$bean_Call->name = 'Llamada automática – Intento de Registro en UniOn';
			$bean_Call->date_start = date("d/m/Y h:i a", strtotime('+30 minutes'));
			if($args['tipo'] == 'Accounts') $bean_Call->parent_type = 'Accounts';
			if($args['tipo'] == 'Leads') $bean_Call->parent_type = 'Leads';
			$bean_Call->parent_id = $args['idCRM'];
			$bean_Call->assigned_user_id = $agente;
			$bean_Call->direction = 'Inbound';
			$bean_Call->duration_minutes = 30;
			$bean_Call->tct_union_c = 1;
			$bean_Call->save();
			if($args['tipo'] == 'Leads') {
			  $bean_Call->load_relationship('leads');
			  $bean_Call->leads->add($args['idCRM']);
			}
			$respuesta['idLlamada'] = $bean_Call->id;
			$respuesta['asunto'] = $bean_Call->name;
			$respuesta['hora_inicio'] = $bean_Call->date_start;
			$respuesta['usuario_asignado'] = $bean_Call->assigned_user_id;
			$respuesta['registroRelacionado'] = $bean_Call->parent_id;
		} else {
			$respuesta = 'No se puede generar la llamada debido a que ya existe una previa para el día de hoy';
		}
        return $respuesta;
    }
}
