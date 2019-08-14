<?php
    //add the job key to the list of job strings
    array_push($job_strings, 'close_calls_meetings');

    function close_calls_meetings()
    {
        // Busca las llamadas vencidas en status "planificada" y les cambia el estado a "no realizada"
        $GLOBALS['log']->fatal('>>>>>>COMIENZA JOB CLOSE_CALLS_MEETINGS:');//------------------------------------

        $queryc="select calls.id from calls,calls_cstm
                where calls.id=calls_cstm.id_c and calls.status='Planned'
                and calls.date_end < UTC_TIMESTAMP()
                and calls_cstm.tct_call_issabel_c=0
                and deleted=0;";
        $queryMNotSurvey ="select meetings.id id
                from meetings
                inner join users on users.id = meetings.created_by
                inner join users_cstm on users_cstm.id_c = users.id
                where meetings.status='Planned'
                and meetings.date_end  <UTC_TIMESTAMP()
                and meetings.created_by != meetings.assigned_user_id
                and (users_cstm.puestousuario_c = '27' or users_cstm.puestousuario_c = '31'  or users.id= 'eeae5860-bb05-4ae5-3579-56ddd8a85c31');";
        $querym="select id from meetings where status='Planned' and date_end < UTC_TIMESTAMP();";

        $resultc = $GLOBALS['db']->query($queryc);
        $resultMNotSurvey = $GLOBALS['db']->query($queryMNotSurvey);
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

        while($row = $GLOBALS['db']->fetchByAssoc($resultMNotSurvey) )
        {
            $beanMeeting = BeanFactory::getBean('Meetings', $row['id']);
            $beanMeeting->status = 'Not Held';
            $beanMeeting->modified_user_id = $beanMeeting->assigned_user_id;
            $beanMeeting->save();
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
