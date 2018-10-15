<?php
    //add the job key to the list of job strings
    array_push($job_strings, 'close_calls');

    function close_calls()
    {
    	// Busca las llamadas vencidas en status "planificada" y les cambia el estado a "no realizada"
        $GLOBALS['log']->fatal('>>>>>>COMIENZA JOB CLOSE_CALLS:');//------------------------------------

        $query="select * from calls where status='Planned' and date_end < curdate()";
        $result = $GLOBALS['db']->query($query);
        $contador=0;

        while($row = $GLOBALS['db']->fetchByAssoc($result) )
        {
            $id = $row['id'];
            $bean_call = BeanFactory::retrieveBean('Calls', $id);
            $bean_call->status='Not Held';
            $bean_call->save();
            $contador++;
        }
        $GLOBALS['log']->fatal('>>>>>>TERMINA JOB CLOSE_CALLS:'+$contador);//------------------------------------
		return true;
    }