<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetCallMeetLeadAccountAPI extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //GET
            'getCallMeet' => array(
                //request type
                'reqType' => 'GET',
                //set authentication
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('getallcallmeetAccount'),
                //endpoint variables
                'pathVars' => array(),
                //method to call
                'method' => 'llamadasReuniones',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Encuentra las llamadas y reuniones hechas previamente por una cuenta desde lead a cuenta',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    /**
     * Method to be used for my customSurvey endpoint
     */
    public function llamadasReuniones($api, $args)
    {
        //$GLOBALS['log']->fatal('args',$args);
        $id_cliente=$args['id_Account'];
        //$GLOBALS['log']->fatal('id cliente: '. $id_cliente);
        $GLOBALS['log']->fatal('>>>>>>>Entro Encuentra llamadas reuniones Cuentas  y Lead'. $id_cliente);//------------------------------------
        //------------------------------------
        $query = "select call_account + meet_account as total from 
        (select count(parent_id) call_account from calls where status = 'Held' 
            and deleted = 0  and parent_id= '{$id_cliente}') as callac ,
        (select count(parent_id) meet_account from meetings where status = 'Held' and deleted = 0  
            and parent_id= '{$id_cliente}') as meeac";

        //$GLOBALS['log']->fatal('qUERY: ',$query);//----------------------
        $results = $GLOBALS['db']->query($query);
        while($row = $GLOBALS['db']->fetchByAssoc($results) ){
            //Use $row['id'] to grab the id fields value
            $total = $row['total'];
        }
        $GLOBALS['log']->fatal('Total accounts: ',$total);//----------------------

        $salida->total_account = $total;

        $query = "select call_account + call_lead + meet_account + meet_lead as total from 
        (select count(parent_id) call_account from calls where status = 'Held' 
            and deleted = 0  and parent_id= '{$id_cliente}') as callac ,
        (select count(parent_id) meet_account from meetings where status = 'Held' and deleted = 0  
            and parent_id= '{$id_cliente}') as meeac ,
        (select count(*) meet_lead from meetings me join meetings_leads mel 
        on me.id = mel.meeting_id where me.deleted = 0 and mel.deleted = 0 and me.status = 'Held' 
        and mel.lead_id = (select id from leads where account_id = '{$id_cliente}')
        ) as melead ,
        (select count(*) call_lead from calls ca join calls_leads cal 
        on ca.id = cal.call_id where ca.deleted = 0 and cal.deleted = 0 and ca.status = 'Held'
        and cal.lead_id = (select id from leads where account_id = '{$id_cliente}')
        ) as calead";

        //$GLOBALS['log']->fatal('qUERY: ',$query);//----------------------
        $results = $GLOBALS['db']->query($query);
        while($row = $GLOBALS['db']->fetchByAssoc($results) ){
            //Use $row['id'] to grab the id fields value
            $total = $row['total'];
        }
        $GLOBALS['log']->fatal('Total comunicación: ',$total);//----------------------

        $salida->total = $total;

        $myJSON = json_encode($salida);
        return $myJSON;
        //return $id_cliente;
    }
}
?>
