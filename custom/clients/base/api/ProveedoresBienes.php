<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 *
 * @author Carlos Zaragoza
 * Date: 16/07/2015
 * Time: 03:39 PM
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ProveedoresBienes extends SugarApi
{

    public function registerApiRest()
    {
        return array(
          'ProveedoresBienes' => array(
                                  'reqType' => 'GET'
                                  ,'path' => array('Legosoft', 'ProveedoresBienes','?')
                                  ,'pathVars' => array('', '', 'data')
                                  ,'method' => 'getProveedores'
                                  ,'shortHelp' => 'Obtiene la lista de proveedores'
          ),
        );
    }

    /**
     * @param $api
     * @param $args
     * @return mixed
     */
    public function getProveedores($api, $args)
    {
        $tipo = $args['data'];
        global $db, $current_user;
        $query = <<<SQL
SELECT id, name FROM accounts a inner join accounts_cstm c on a.id=c.id_c where  c.tipo_registro_c='Proveedor' and c.tipo_proveedor_c like '%{$tipo}%'
SQL;
        $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> consulta: " .$query);

        $user_queryResult = $db->query($query);

        while ($row = $db->fetchByAssoc($user_queryResult)) {
            $resultado[] = $row;
        }



        return $resultado;

    }
}
