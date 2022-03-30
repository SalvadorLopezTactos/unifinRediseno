<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class getPadres extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'retrieve' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('getPadres', '?','?','?'),
                'pathVars' => array('method', 'idHijo','parentModule','idUsuario'),
                'method' => 'getPadres1',
                'shortHelp' => 'Obtiene los padres de una cuenta o un lead',
                'longHelp' => '',
            ),
        );
    }

    public function getPadres1($api, $args)
    {
		global $db;
		$query = '';
		$modulo=$args['parentModule'];
		$usuario=$args['idUsuario'];
        $id=$args['idHijo'];
		if($modulo == 'Accounts') $query = "select distinct id cuenta, name nombre from accounts where deleted = 0 
and id in (select rel_relaciones_accounts_1accounts_ida from rel_relaciones_accounts_1_c where deleted = 0 
and rel_relaciones_accounts_1rel_relaciones_idb in (select id_c from rel_relaciones_cstm where account_id1_c = '{$id}'))";
		if($modulo == 'Leads') $query = "select a.id cuenta, b.name_c nombre from leads a, leads_cstm b where a.id = b.id_c and
assigned_user_id = '{$usuario}' and deleted = 0 and id in (select leads_leads_1leads_ida from leads_leads_1_c where deleted = 0 and
leads_leads_1leads_idb = '{$id}')";
        $result = $db->query($query);
        $data = [];
        while ($row = $db->fetchByAssoc($result)) {
            array_push($data, ["id" => $row['cuenta'], "name" => $row['nombre']]);
        }
        return $data;
    }
}
?>