<?php
    //add the job key to the list of job strings
    array_push($job_strings, 'close_calls&meetings');

    function close_calls()
    {
    	// Busca las llamadas vencidas en status "planificada" y les cambia el estado a "no realizada"
        $GLOBALS['log']->fatal('>>>>>>COMIENZA JOB CLOSE_CALLS&MEETINGS:');//------------------------------------

        $queryc="select * from calls where status='Planned' and (date_end < CURDATE() and date_end > SUBDATE(CURDATE(), 1));";
        $querym="select * from meetings where status='Planned' and (date_end < CURDATE() and date_end > SUBDATE(CURDATE(), 1));";

        $resultc = $GLOBALS['db']->query($queryc);
        $resultm = $GLOBALS['db']->query($querym);

        $contadorc=0;
        $contadorm=0;

        while($row = $GLOBALS['db']->fetchByAssoc($resultc) )
        {
            $id = $row['id'];
            $bean_call = BeanFactory::retrieveBean('Calls', $id);
            $bean_call->status='Not Held';
            $bean_call->save();
            $contadorc++;
        }
        while($row = $GLOBALS['db']->fetchByAssoc($resultm) )
        {
            $id = $row['id'];
            $bean_call = BeanFactory::retrieveBean('Meetings', $id);
            $bean_call->status='Not Held';
            $bean_call->save();
            $contadorm++;
        }
        $GLOBALS['log']->fatal($contadorc.' llamadas modificadas');//------------------------------------
        $GLOBALS['log']->fatal($contadorm.' reuniones modificadas');//------------------------------------
        $GLOBALS['log']->fatal('>>>>>>TERMINA JOB CLOSE_CALLS&MEETINGS:');//------------------------------------
		return true;
    }
