<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 17/01/22
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetBloqueoCuenta extends SugarApi
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
                'path' => array('GetBloqueoCuenta', '?'),
                //endpoint variables
                'pathVars' => array('method', 'id_cuenta'),
                //method to call
                'method' => 'getBloqueoCuentaPorTipo',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Indica si la cuenta pasada como parámatero se encuentra bloqueada y a través de que tipo: Crédito, cartera o Cumplimiento',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    public function getBloqueoCuentaPorTipo($api, $args)
    {
        $id_cuenta=$args['id_cuenta'];
        $GLOBALS['log']->fatal($id_cuenta);
        $response = array();

        //Obtiene cuenta
        $beanResumen = BeanFactory::getBean('tct02_Resumen', $id_cuenta);
        //$GLOBALS['log']->fatal(print_r($beanResumen,true));

        if($beanResumen->id!="" && $beanResumen->id!=null){

            //Validando cada uno de los campos de bloqueo
            $arr_bloqueo=array();
            $arr_tipo_bloqueos=array();

            if($beanResumen->bloqueo_cartera_c==1){
                array_push($arr_bloqueo,'1');
                array_push($arr_tipo_bloqueos,'Cartera');
                
            }
            if($beanResumen->bloqueo2_c==1){
                array_push($arr_bloqueo,'1');
                array_push($arr_tipo_bloqueos,'Crédito');
            }
            if($beanResumen->bloqueo3_c==1){
                array_push($arr_bloqueo,'1');
                array_push($arr_tipo_bloqueos,'Cumplimiento');
            }

            if(in_array('1',$arr_bloqueo)){
                $response['bloqueo']="SI";
                $response['tipo']=$arr_tipo_bloqueos;
            }else{
                $response['bloqueo']="NO";
                $response['tipo']=array();
            }

        }else{
            $response["respuesta"]="No encontrado";
            $response["mensaje"]="El cliente con el id {$id_cuenta} no existe, favor de verificar";
        }

        return $response;

    }


}

?>
