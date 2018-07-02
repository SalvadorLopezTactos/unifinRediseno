<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 *
 * @author Carlos Zaragoza
 * Date: 16/07/2015
 * Time: 03:39 PM
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class LegosoftAPI extends SugarApi
{

    public function registerApiRest()
    {
        return array(
          'LegosoftAPI' => array(
                                  'reqType' => 'GET'
                                  ,'path' => array('Legosoft', 'Autorizador','?')
                                  ,'pathVars' => array('', '', 'data')
                                  ,'method' => 'getAutorizador'
                                  ,'shortHelp' => 'Obtiene el autorizador del promotor metodo GET'
          ),
        );
    }

    /**
     * @param $api
     * @param $args
     * @return mixed
     */
    public function getAutorizador($api, $args)
    {
        $user = $args['data'];
        global $db, $current_user;
        $user_query = <<<SQL
SELECT id FROM users where user_name= '$user';
SQL;
        $user_queryResult = $db->query($user_query);
        $rowUsuario = $db->fetchByAssoc($user_queryResult);



        $user_reports_to = $rowUsuario['id'];
        do {
            $query = <<<SQL
SELECT u.id, u.user_name, uc.aut_caratulariesgo_c, u.reports_to_id, u.first_name, u.last_name FROM users u inner JOIN users_cstm uc on u.id=uc.id_c where u.id = '$user_reports_to';
SQL;
            $queryResult = $db->query($query);
            $row = $db->fetchByAssoc($queryResult);
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : FILA  " . print_r($row, 1));
            $user_reports_to = $row['reports_to_id'];
            if( $row['reports_to_id']==null) break;
            if($row['aut_caratulariesgo_c']=="1") break;
        } while ($row['aut_caratulariesgo_c'] == null || $row['aut_caratulariesgo_c'] == "0" );

        if($row['reports_to_id']==null && $row['aut_caratulariesgo_c'] == null){
            $row = array();
            $row['status']='No hay quien autorice';
        }
        return $row;

    }
}
