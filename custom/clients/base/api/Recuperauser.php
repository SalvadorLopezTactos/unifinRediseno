<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/08/20
 * Time: 04:43 PM
 */

class Recuperauser extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'eliminarLeads' => array(
                'reqType' => 'GET',
                'path' => array('Recuperauser','?'),
                'pathVars' => array('recuperaref','id_cuenta'),
                'method' => 'recuperaref',
                'shortHelp' => 'Recupera estatus del usuario seleccionado en Seguros',
            ),
        );
    }

    public function recuperaref($api, $args)
    {
        $idCuenta = $args['id_cuenta'];

        global $db;
            //Consulta a users
            $query = "SELECT * from users where id='{$idCuenta}'";
           $GLOBALS['log']->fatal($query);
           $respuesta="";
            $result = $db->query($query);
             while ($row = $GLOBALS['db']->fetchByAssoc($result)){
                $respuesta=$row['status'];
             }
        return $respuesta;
        $GLOBALS['log']->fatal($respuesta);
    }
}