<?php
class AgentesTelefonicos extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POST_AgentesTelefonicos' => array(
                'reqType' => 'POST',
                'path' => array('AgentesTelefonicos'),
                'pathVars' => array(''),
                'method' => 'AgentesTelefonicos1',
                'shortHelp' => 'Actualia Agentes Telefonicos',
            ),
        );
    }

    public function AgentesTelefonicos1($api, $args)
    {
        global $db;
        $user_id = $args['data']['user_id'];
        $reports_to_id = $args['data']['reports_to_id'];
        $equipo_c = $args['data']['equipo_c'];
        $query = "update users a, users_cstm b set a.reports_to_id = '{$reports_to_id}', b.equipo_c = '{$equipo_c}' where a.id = b.id_c and a.id = '{$user_id}'";
        $result = $db->query($query);
		    return $result;
    }
}
