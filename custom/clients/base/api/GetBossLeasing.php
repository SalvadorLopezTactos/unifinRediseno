<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 07/08/18
 * Time: 10:07
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetBossLeasing extends SugarApi
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
                'path' => array('GetBossLeasing', '?'),
                //endpoint variables
                'pathVars' => array('method', 'id_user'),
                //method to call
                'method' => 'getBossLeasingMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que obtiene usuarios con jerarquia de Director con base a un id de usuario',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }


    public function getBossLeasingMethod($api, $args)
    {
        //id de usuario ejemplo cdf63b76-233b-11e8-a1ec-00155d967307 alvaro.alonso
        $id_usuario=$args['id_user'];

        $beanUsuario = BeanFactory::getBean('Users', $id_usuario,array('disable_row_level_security' => true));
        $array_users=array();
        $bandera=true;

        if(!empty($beanUsuario)){

            while ($bandera){
                $id_reporta=$beanUsuario->reports_to_id;
                if($id_reporta!=null && $id_reporta!=""){
                    //Obteniendo el Jefe Director Leasing
                    $beanUsuarioJefe = BeanFactory::getBean('Users', $id_reporta,array('disable_row_level_security' => true));
                    if (!empty($beanUsuarioJefe)){
                        if($beanUsuarioJefe->puestousuario_c=='2'){ //Puesto 2= Director Leasing
                            array_push($array_users,array('id'=>$beanUsuarioJefe->id,'name'=>$beanUsuarioJefe->full_name));

                            //Obteniendo jefe inmediato del Director Leasing
                            $jefeDirectorLeasing=$beanUsuarioJefe->reports_to_id;
                            if($jefeDirectorLeasing!=null && $jefeDirectorLeasing!=""){
                                $beanJefeDirector = BeanFactory::getBean('Users', $jefeDirectorLeasing,array('disable_row_level_security' => true));
                                array_push($array_users,array('id'=>$beanJefeDirector->id,'name'=>$beanJefeDirector->full_name));
                                $bandera=false;
                            }else{
                                $bandera=false;
                            }

                        }else{
                            $beanUsuario=$beanUsuarioJefe;

                        }
                    }else{
                        $bandera=false;
                    }
                }else{
                    $bandera=false;
                }

            }

        }

        //Obtener usuario Gabriel
        //$idGabriel="c57e811e-b81a-cde4-d6b4-5626c9961772";
        $idGabriel="d0bf3b56-ed54-11ea-b6ba-a0481cdf89eb";//Usuario Gabriel Martin del Campo
        $beanUsuarioGabriel = BeanFactory::getBean('Users', $idGabriel,array('disable_row_level_security' => true));
        array_push($array_users,array('id'=>$beanUsuarioGabriel->id,'name'=>$beanUsuarioGabriel->full_name));

        return $array_users;

    }


}

?>
