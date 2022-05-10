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
        //Busca Cuenta
        $Cuentas = new SugarQuery();
        $Cuentas->select(array('id'));
        $Cuentas->from(BeanFactory::getBean('Accounts'), array('team_security' => false));
	      $Cuentas->where()->equals('id', $args['idCRM']);
        $result1 = $Cuentas->execute();
        if(empty($result1[0]['id'])) {
          //Busca Lead
    			$Leads = new SugarQuery();
    			$Leads->select(array('id','account_id','compania_c'));
    			$Leads->from(BeanFactory::getBean('Leads'), array('team_security' => false));
    			$Leads->where()->equals('id', $args['idCRM']);
    			$result2 = $Leads->execute();
    			if(empty($result2[0]['id'])) {
    				$respuesta = 'El valor del idCRM es incorrecto';
    			} else {
    				$tipo = 'Leads';
            $compania = $result2[0]['compania_c'];
            $cuentaPadre = $result2[0]['account_id'];
    			}
    		} else {
			    $tipo = 'Accounts';
        }
		if($args['tipo'] != 'Accounts' && $args['tipo'] != 'Leads') $respuesta = 'El valor del tipo es incorrecto';
		if(empty($respuesta)) {
			//Busca Llamada Planificada de hoy
			$Llamadas = new SugarQuery();
			$Llamadas->select(array('id', 'date_entered', 'parent_id', 'status', 'tct_union_c', 'assigned_user_id'));
			$Llamadas->from(BeanFactory::getBean('Calls'), array('team_security' => false));
			//$Llamadas->where()->dateBetween('date_entered', array(date("Y-m-d"),date("Y-m-d")));
      $Llamadas->where()->dateRange('date_entered','today');
      if($tipo == 'Accounts'){
          $Llamadas->where()->equals('parent_id', $args['idCRM']);
      }else{
          $Llamadas->where()->queryOr()->equals('parent_id',$args['idCRM'])->equals('parent_id',$cuentaPadre);
      }
			$Llamadas->where()->equals('status', 'Planned');
			$Llamadas->where()->equals('tct_union_c', 1);
			$resultado = $Llamadas->execute();
			if(empty($resultado[0]['id'])) {
				//Busca Agente Telefónico
				require_once("custom/clients/base/api/GetAgenteCP.php");
				$apiAgente = new GetAgenteCP();
        $params=[];
        $params['compania'] = $compania;
				$response = $apiAgente->getAgenteTelCP(null,$params);
				$agente = $response['idAsesor'];
				//Crea Llamada
				$bean_Call = BeanFactory::newBean('Calls');
				$bean_Call->name = 'Llamada automática – Intento de registro en UniOn';
				$bean_Call->date_start = date("d/m/Y h:i a", strtotime('+30 minutes'));
				if($args['origen']) $bean_Call->name = 'Llamada automática – Registro en UniOn';
				if($tipo == 'Accounts') $bean_Call->parent_type = 'Accounts';
				if($tipo == 'Leads') $bean_Call->parent_type = 'Leads';
				if(empty($result2[0]['account_id'])) {
					$bean_Call->parent_id = $args['idCRM'];
				}
				else {
					$bean_Call->parent_type = 'Accounts';
					$bean_Call->parent_id = $result2[0]['account_id'];
				}
				$bean_Call->assigned_user_id = $agente;
				$bean_Call->direction = 'Inbound';
				$bean_Call->duration_minutes = 30;
				$bean_Call->tct_union_c = 1;
				$bean_Call->save();
				if($tipo == 'Leads') {
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
		}
        return $respuesta;
    }
}
