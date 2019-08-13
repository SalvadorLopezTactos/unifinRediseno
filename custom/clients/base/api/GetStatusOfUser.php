<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 13/08/19
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetStatusOfUser extends SugarApi
{

    /**
     * Registro de todas las rutas para consumir los servicios del API
     *
     */
    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('GetStatusOfUser','?'),
                //endpoint variables
                'pathVars' => array('method','id_users'),
                //method to call
                'method' => 'getEtapaEstatusOfUser',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que regresa regresa el estado (Activo o Inactivo) de una lista de id´s de usuarios',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    /**
     * Método que regresa lista de usuarios inactivos
     *
     * @param array $api
     * @param array $args Array con los parámetros enviados para su procesamiento
     * @return array $usuarios_inactivos Array con los usuarios inactivos
     */
    public function getEtapaEstatusOfUser($api, $args)
    {
        $id_usuarios=$args['id_users'];

        $id_usuarios=explode(',',$id_usuarios);
        //Quitar el último elemento vacío del arreglo
        array_pop($id_usuarios);

        $ids='';
        $total_ids=count($id_usuarios);
        //Ciclo para concatenar los valores de los id con sus respectivas comillas simples para un correcto query
        for($i=0;$i < $total_ids;$i++){

            if($i==$total_ids-1){
                $ids.="'".$id_usuarios[$i]."'";

            }else{
                $ids.="'".$id_usuarios[$i]."',";
            }

        }


        $usuarios_inactivos=array();

        $query="SELECT concat(first_name,' ',last_name) as full_name,user_name,status FROM users WHERE id IN ({$ids})";

        $result=$GLOBALS['db']->query($query);

        $num_rows = $result->num_rows;
        if($num_rows >0){

            while($row = $GLOBALS['db']->fetchByAssoc($result))
            {
                if($row['status']=='Inactive'){

                    $usuarios_inactivos[]=array('nombre_usuario'=>$row['full_name']);

                }

            }

        }
        return $usuarios_inactivos;


    }


}

?>
