<?php
/**
 * Created by PhpStorm.
 * User: Adrian Arauz
 * Date: 29/04/2019
 * Time: 1:53 PM
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class UsersBLCancelar extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'recuperaUsers' => array(
                'reqType' => 'GET',
                'path' => array('UsuariosBLcancelar'),
                'pathVars' => array(''),
                'method' => 'ConsultaUsuariosBL',
                'shortHelp' => 'Realiza consulta a nivel db para traer usuarios con DGA comercial diferente de 1',
                'longHelp' => '',
            ),
        );
    }
    public function ConsultaUsuariosBL($api, $args)
    {
        $arreglousuarios = [];
        $query = "select 
                concat(u.first_name, ' ', u.last_name) as nombre
                from acl_roles_users ru
                inner join acl_roles r on r.id = ru.role_id
                inner join users u on u.id = ru.user_id 
                inner join users_cstm uc on uc.id_c = u.id and uc.puestousuario_c != 1
                where r.name = 'Backlog-Cancelar'
                ;";
        $Respuesta = $GLOBALS['db']->query($query);
        while ($row = $GLOBALS['db']->fetchByAssoc($Respuesta)){
            $arreglousuarios[]=$row['nombre'];
        }
        return $arreglousuarios;
    }
}