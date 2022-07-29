<?php


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetUserData extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'UsuariosAPI' => array(
                'reqType' => 'GET',
                'path' => array('Infouser','?'),
                'pathVars' => array('', 'id'),
                'method' => 'GetUserInfo',
                'shortHelp' => 'Obtiene toda la información del usuario',
            ),
        );
    }


    public function GetUserInfo($api, $args)
    {
        try
        {
            $idUsuario = $args['id'];
            global $db, $current_user;
            $response = array();
            $GLOBALS['log']->fatal("Recupera información del usuario");

            $query="SELECT * FROM users,users_cstm where id=id_c and id = '".$idUsuario."';";
            $resultUser = $GLOBALS['db']->query($query);

            $row = $db->fetchByAssoc($resultUser);
            
            return $row;

        }catch (Exception $e){
            $GLOBALS['log']->fatal("No se ha encontrado el usuario :".$e->getMessage());
        }

    }

}