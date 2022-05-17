<?php
/**
 * Created by JG.
 * User: tactos
 * Date: 9/02/21
 * Time: 09:00 PM
 */

class GetRelRelacionesAccounts extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'retrieve' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('GetRelRelaciones', '?'),
                'pathVars' => array('method', 'id_account'),
                'method' => 'getRelaciones',
                'shortHelp' => 'Método que obtiene las Relaciones activas en la cuenta si es Moral',
                'longHelp' => '',
            ),
        );

    }

    public function getRelaciones($api, $args)
    {
        global $db;
        $id_account = $args['id_account'];

        $query = "select t2.account_id1_c as cuenta, ac.name as nombre
FROM rel_relaciones_accounts_1_c rel
  INNER JOIN rel_relaciones t1
    ON t1.id=rel.rel_relaciones_accounts_1rel_relaciones_idb
  INNER JOIN rel_relaciones_cstm t2
    ON t2.id_c=t1.id
  INNER join accounts ac
 ON ac.id=t2.account_id1_c
WHERE rel.rel_relaciones_accounts_1accounts_ida='{$id_account}'";

        $result = $db->query($query);
        $data = [];
        while ($row = $db->fetchByAssoc($result)) {
            array_push($data, ["id" => $row['cuenta'], "name" => $row['nombre']]);
        }

        //$GLOBALS['log']->fatal("Del query " . json_encode($data,true));
        return $data;

    }

}