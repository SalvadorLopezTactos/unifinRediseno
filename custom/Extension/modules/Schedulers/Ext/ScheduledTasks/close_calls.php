<?php
    //add the job key to the list of job strings
    array_push($job_strings, 'close_calls');

    function close_calls()
    {
    	// Busca las llamadas vencidas en status "planificada" y les cambia el estado a "no realizada"
        $GLOBALS['log']->fatal('>>>>>>COMIENZA JOB CLOSE_CALLS_ISSABEL:');//------------------------------------

        $query="select calls.id from calls,calls_cstm where calls.id=calls_cstm.id_c and calls.status='Planned' and date_entered < curdate() and calls_cstm.tct_call_issabel_c=1 and deleted=0;";
        $result = $GLOBALS['db']->query($query);
        $contador=0;

        while($row = $GLOBALS['db']->fetchByAssoc($result) )
        {
            $id = $row['id'];
            $queryUpdate="update calls
              set deleted = 1
              where id='{$id}';";
            $resultUpdate = $GLOBALS['db']->query($queryUpdate);
            $contador++;
        }
        $GLOBALS['log']->fatal('>>>>>>TERMINA JOB CLOSE_CALLS_ISSABEL:'+$contador);//------------------------------------
		return true;
    }
