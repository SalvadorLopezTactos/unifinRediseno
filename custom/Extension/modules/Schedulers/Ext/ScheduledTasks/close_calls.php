<?php
    //add the job key to the list of job strings
    array_push($job_strings, 'close_calls');

    function close_calls()
    {
		// Busca las llamadas vencidas en status "planificada" y les cambia el estado a "cancelada"
        $query="select calls.id, calls.date_entered, calls.description, calls.assigned_user_id from calls, calls_cstm where calls.id=calls_cstm.id_c and calls.status='Planned' and date_entered < UTC_TIMESTAMP() - interval 1 day and calls_cstm.tct_call_issabel_c=1 and deleted=0";
        $result = $GLOBALS['db']->query($query);
        while($row = $GLOBALS['db']->fetchByAssoc($result) )
        {
		    $id = $row['id'];
			$queryUpdate="update calls, calls_cstm set calls.status = 'Not Held', calls_cstm.tct_resultado_llamada_ddw_c = 'Ilocalizable', detalle_resultado_c = 13 where calls.id = calls_cstm.id_c and calls.id ='{$id}';";
			$resultUpdate = $GLOBALS['db']->query($queryUpdate);
		}
    	// Busca las llamadas vencidas en status "planificada" y les cambia el estado a "no realizada"
        $GLOBALS['log']->fatal('>>>>>>COMIENZA JOB CLOSE_CALLS_ISSABEL:');//------------------------------------
        $query="select calls.id, calls.description, calls.assigned_user_id from calls,calls_cstm where calls.id=calls_cstm.id_c and calls.status='Planned' and date_entered < UTC_TIMESTAMP() and calls_cstm.tct_call_issabel_c=1 and deleted=0;";
        $result = $GLOBALS['db']->query($query);
		$asesores = array();
        $contador=0;
		$conta=0;
        while($row = $GLOBALS['db']->fetchByAssoc($result) )
        {
			$borra = 0;
            $id = $row['id'];
			$description = $row['description'];
			$asesor = $row['assigned_user_id'];
			array_push($asesores, $asesor);
			if(in_array($asesor, $asesores) && strpos($description, '- Intento no exitoso') && $conta > 0) {
				$borra = 1;
				$conta++;
			}
			if(!strpos($description, '- Intento no exitoso')) $borra = 1;
			if($borra) {
				$queryUpdate="update calls
				  set deleted = 1
				  where id='{$id}';";
				$resultUpdate = $GLOBALS['db']->query($queryUpdate);
				$contador++;
			}
        }
        $GLOBALS['log']->fatal('>>>>>>TERMINA JOB CLOSE_CALLS_ISSABEL:'+$contador);//------------------------------------
		return true;
    }
