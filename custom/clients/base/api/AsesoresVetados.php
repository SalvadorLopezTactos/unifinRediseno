<?php
class AsesoresVetados extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'AsesoresVetados' => array(
                'reqType' => 'POST',
                'path' => array('AsesoresVetados'),
                'pathVars' => array(''),
                'method' => 'AsesoresVetados1',
                'shortHelp' => 'Actualia Agentes Telefonicos',
            ),
        );
    }

    public function AsesoresVetados1($api, $args)
    {
        global $db;
        $user_id = $args['data']['user_id'];
        $vetados_chk_c = $args['data']['vetados_chk_c'];
        $query = "update users_cstm set vetados_chk_c = {$vetados_chk_c} where id_c = '{$user_id}'";
        $result = $db->query($query);
		    return $result;
    }
}
