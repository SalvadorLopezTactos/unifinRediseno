<?php

/*
Created by: AF.Tactos
22/03/2018
Job para ejecutar funcionalidad de alertas Clientes no vigentes y sin operar(CNVSO)
*/

    array_push($job_strings, 'job_no_vigentes_sin_operar');

    function job_no_vigentes_sin_operar()
    {
    	//Inicia ejecución
    	$GLOBALS['log']->fatal('Job CNVSO: Inicia');

    /*
		1.- Alerta CNVSO
    */

    	##########################################
    	## 1.- Recupera operaciones-clentes no vigentes sin operar
    	##########################################
    	//Obtiene fecha actual
    	$today = date("Y-m-d");
    	$vencimiento = strtotime ( '+30 day' , strtotime ( $today ) ) ;
		$vencimiento = date ( 'Y-m-j' , $vencimiento );
		$GLOBALS['log']->fatal('Job CNVSO: Fecha de vigencia - '. $vencimiento);

    	//Estructura consulta operaciones-clienres
    	/*
    		Condiciones:
    			Fecha vencimiento = hoy -30 días
    			Tipo operación =  2
    			Tipo de operación = LINEA_NUEVA
    	*/
    	$sqlQuery = "select 
				op_c.id_c as idOperacion,
				op_c.fecha_estimada_cierre_c as fechaVencimiento,
			    op_c.tipo_operacion_c as tipoOperacion,
			    op_c.tipo_de_operacion_c as tipoDeOperacion,
			    op_c.producto_c as tipoProducto,
			    op.name as nombreOperacion,
			    ac_op.account_id as idPersona,
			    ac.name as nombrePersona,
			    ac_c.user_id_c as promotorLeasing,
			    ac_c.user_id1_c as promotorFactoraje,
			    ac_c.user_id2_c as promotorCA,
			    r.opero_leasing_c as operaLeasing,
			    r.opero_factoraje_c as operaFactoraje,
			    r.opero_ca_c as operaCA
			from opportunities_cstm op_c
			left join opportunities op on op_c.id_c=op.id
			left join accounts_opportunities ac_op on op_c.id_c = ac_op.opportunity_id
			left join accounts ac on ac_op.account_id = ac.id
			left join accounts_cstm ac_c on ac_op.account_id = ac_c.id_c
			left join tct02_resumen_cstm r on ac_op.account_id = r.id_c
			where
				op_c.fecha_estimada_cierre_c = '{$vencimiento}'
			    and op_c.tipo_operacion_c = 2
			    and op_c.tipo_de_operacion_c = 'LINEA_NUEVA'
			;";

		//Ejecuta consulta
		$GLOBALS['log']->fatal('Job CNVSO: Ejecuta consulta');
		$resultR = $GLOBALS['db']->query($sqlQuery);
		
		##########################################
    	## 2.- Genera alertas 
    	##########################################
    	//Procesa registros recuperados
    	$GLOBALS['log']->fatal('Job CNVSO:  Procesa registros');
    	$totalRegistros = 0;
		while ($row = $GLOBALS['db']->fetchByAssoc($resultR)) {

			//Identifica tipo de producto y valida que no tenga operación
			$GLOBALS['log']->fatal('Job CNVSO: Tipo de Producto '.$row['tipoProducto'] );
			//Tipos
			switch ($row['tipoProducto']) {
			    case "Leasing":
			    	if ($row['operaLeasing'] == 'NO') {
			    		//Genera Alerta 
			    		$beanN = BeanFactory::newBean('Notifications');
			    		$beanN->severity = 'alert';
						$beanN->name = 'Cliente sin Operar - Leasing';
			    		$beanN->description = 'ALERTA: La línea autorizada de '. $row['nombrePersona'] . ' vencerá dentro de 1 mes y no ha sido utilizada.';
			    		$beanN->parent_type = 'Accounts';
			    		$beanN->parent_id = $row['idPersona'];
			    		$beanN->assigned_user_id = $row['promotorLeasing'];
						$beanN->save();
			    	}
			        break;
			    case "Factoraje":
			        if ($row['operaFactoraje'] == 'NO') {
			    		//Genera Alerta 
			    		$beanN = BeanFactory::newBean('Notifications');
			    		$beanN->severity = 'alert';
						$beanN->name = 'Cliente sin Operar - Factoraje';
			    		$beanN->description = 'ALERTA: La línea autorizada de '. $row['nombrePersona'] . ' vencerá dentro de 1 mes y no ha sido utilizada.';
			    		$beanN->parent_type = 'Accounts';
			    		$beanN->parent_id = $row['idPersona'];
			    		$beanN->assigned_user_id = $row['promotorFactoraje'];
						$beanN->save();
			    	}
			        break;
			    case "Credito Automotriz":
			        if ($row['operaCA'] == 'NO') {
			    		//Genera Alerta 
			    		$beanN = BeanFactory::newBean('Notifications');
			    		$beanN->severity = 'alert';
						$beanN->name = 'Cliente sin Operar - CA';
			    		$beanN->description = 'ALERTA: La línea autorizada de '. $row['nombrePersona'] . ' vencerá dentro de 1 mes y no ha sido utilizada.';
			    		$beanN->parent_type = 'Accounts';
			    		$beanN->parent_id = $row['idPersona'];
			    		$beanN->assigned_user_id = $row['promotorCA'];
						$beanN->save();
			    	}
			        break;
			    default:
			        $GLOBALS['log']->fatal('Job CNVSO: Producto no identificado ');
			}

			//Guarda alertas
			$GLOBALS['log']->fatal('Job CNVSO: Genera alerta '.  $beanN->id);
			
			//Suma registro procesado
			$totalRegistros++;
		}

		$GLOBALS['log']->fatal('Job CNVSO: Registros procesados '. $totalRegistros);
	
		
		//Concluye ejecución
		$GLOBALS['log']->fatal('Job CNVSO: Termina');
        return true;
    }