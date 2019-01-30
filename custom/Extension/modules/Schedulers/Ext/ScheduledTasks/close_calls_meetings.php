<?php
    //add the job key to the list of job strings
    array_push($job_strings, 'close_calls_meetings');

    function close_calls_meetings()
    {
    	// Busca las llamadas vencidas en status "planificada" y les cambia el estado a "no realizada"
        $GLOBALS['log']->fatal('>>>>>>COMIENZA JOB CLOSE_CALLS_MEETINGS:');//------------------------------------

        $queryc="select calls.id from calls,calls_cstm
                where calls.id=calls_cstm.id_c and calls.status='Planned'
                and (calls.date_end < UTC_TIMESTAMP() and calls.date_end > SUBDATE(UTC_TIMESTAMP(), 1))
                and calls_cstm.tct_call_issabel_c=0 
                and deleted=0;";
        $querym="select id from meetings where status='Planned' and (date_end < UTC_TIMESTAMP() and date_end > SUBDATE(UTC_TIMESTAMP(), 1));";

        $resultc = $GLOBALS['db']->query($queryc);
        $resultm = $GLOBALS['db']->query($querym);

        $contadorc=0;
        $contadorm=0;

        while($row = $GLOBALS['db']->fetchByAssoc($resultc) )
        {
            $idc = $row['id'];
            $queryUpdatec="update calls
              set status = 'Not Held'
              where id='{$idc}';";
            $resultUpdatec = $GLOBALS['db']->query($queryUpdatec);
            $contadorc++;
        }
        while($row = $GLOBALS['db']->fetchByAssoc($resultm) )
        {
            $idm = $row['id'];
            $queryUpdatem="update meetings
              set status = 'Not Held'
              where id='{$idm}';";
            $resultUpdatem = $GLOBALS['db']->query($queryUpdatem);
            $contadorm++;
        }
        $GLOBALS['log']->fatal($contadorc.' llamadas modificadas');//------------------------------------
        $GLOBALS['log']->fatal($contadorm.' reuniones modificadas');//------------------------------------
        $GLOBALS['log']->fatal('>>>>>>TERMINA JOB CLOSE_CALLS_MEETINGS:');//------------------------------------
		return true;
    }
