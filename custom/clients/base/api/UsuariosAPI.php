<?php
/**
 * @author: Carlos Zaragoza
 * @date: 8/31/2015
 * @time: 11:58 AM
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");
class usuariosAPI extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'UsuariosAPI' => array(
                'reqType' => 'GET',
                'path' => array('usuariosAPI'),
                'pathVars' => array(''),
                'method' => 'getGuidToUser',
                'shortHelp' => 'Obtiene GUID del usuario',
            ),
        );
    }


    public function getGuidToUser($api, $args)
    {
        try
        {
            $userName = $args['user'];
            global $db, $sugar_config, $current_user;
            $response = array();
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : args " . print_r($args,1));
            $query = <<<SQL
			SELECT * FROM users where user_name = '$userName';
SQL;
            //Get User
            $queryResult = $db->query($query);
            $row = $db->fetchByAssoc($queryResult);
            $guid_user = array();
            $guid_user['user_name'] = $row['user_name'];
            $guid_user['id'] = $row['id'];
            return $guid_user;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }

    }

}

