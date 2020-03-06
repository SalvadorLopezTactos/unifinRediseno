<?php
/**
 * Created by PhpStorm.
 * User: Adrian Arauz>
 * Date: 20/02/2020
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Analizate extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'ObtieneFinanciera' => array(
                'reqType' => 'GET',
                'path' => array('ObtieneFinanciera', '?'),
                'pathVars' => array('', 'id'),
                'method' => 'ObtieneFinanciera',
                'shortHelp' => 'Obtener registros de la tabla anlzt_analizate para su presentación en Custom Field Analizate',
            ),
            'ObtieneURL' => array(
                'reqType' => 'GET',
                'path' => array('ObtieneDocumento', '?'),
                'pathVars' => array('', 'url_documento'),
                'method' => 'ObtieneDocumento',
                'shortHelp' => 'Obtiene la data del documento desde Alfresco para su conversion y descarga',
            ),
            'ObtieneCredit' => array(
                'reqType' => 'GET',
                'path' => array('ObtieneCredit','?'),
                'pathVars' => array('','id'),
                'method' => 'ObtieneCredit',
                'shortHelp' => 'Obtener registros de la tabla anlzt_analizate para su presentación en Custom Field Analizate',
            ),

        );
    }

    public function ObtieneFinanciera($api, $args){
        global $app_list_strings;
        $data=array();
        $data['estado']="";
        $data['fecha']="";
        $data['documento']="";
        $data['fecha_documento']="";
        $data['url_documento']="";
        $data['url_portal']="";
        $idCuenta = $args['id'];
        //Valor de la lista en posicion 1 corresponde a Financiera, 2 a Credit
        $urlFinanciera = $app_list_strings['analizate_url_list'][1];
        //Cargar toda la informacion del bean, en este caso de la cuenta
        $beanCuenta = BeanFactory::getBean("Accounts", $idCuenta);
        //Cargar lo relacionado de la cuenta, en este caso al name del vardef de anzlt_analizate
        $beanCuenta->load_relationship('anlzt_analizate_accounts');
        //Trae todos los registros asociados entre el link de la account y Analizate
        $relatedBeans = $beanCuenta->anlzt_analizate_accounts->getBeans($beanCuenta->id,array('disable_row_level_security' => true));
        //Se iteran las n tandas de registros
        foreach ($relatedBeans as $estados) {

            if ($estados->empresa==1){
                if ($estados->tipo==1){
                    //En los siguientes 2 if, se valida que el valor de la fecha sea el mas reciente en cada iteracion
                    //Para así obtener el registro más reciente y asignarle los valores de fecha y estado
                    if ($data['fecha']==""){
                        $data['fecha']=$estados->fecha_actualizacion;
                        $data['estado']=$estados->estado;
                        $data['url_portal']=$urlFinanciera.'&UUID='.$beanCuenta->id.'&RFC_CIEC='.$beanCuenta->rfc;
                    }
                    if($estados->fecha_actualizacion>$data['fecha']){
                        $data['fecha']=$estados->fecha_actualizacion;
                        $data['estado']=$estados->estado;
                        $data['url_portal']=$urlFinanciera.'&UUID='.$beanCuenta->id.'&RFC_CIEC='.$beanCuenta->rfc;
                    }

                }else{
                    //Recuperar registro mas reciente (Url del documento)
                    if ($data['fecha_documento']==""){
                        $data['documento']=$estados->documento;
                        $data['fecha_documento']=$estados->fecha_actualizacion;
                        $data['url_documento']=$estados->url_documento;
                    }
                    if($estados->fecha_actualizacion>$data['fecha_documento']){
                        $data['fecha_documento']=$estados->fecha_actualizacion;
                        $data['documento']=$estados->documento;
                        $data['url_documento']=$estados->url_documento;
                    }
                }
            }
        }
        if ($data['fecha']!="") {
            //Variable para convertir la hora
            $fecha1 = new DateTime($data['fecha'], new DateTimeZone ('UTC'));
            $fecha1->setTimezone(new DateTimeZone('CST'));
            $data['fecha'] = $fecha1->format('Y-m-d H:i:s');
        }

        //Termina iteracion
        return $data;

    }

    public function  ObtieneDocumento($api, $args){

        $Enlace = $args['url_documento'];
        //$GLOBALS['log']->fatal("Entra Endpoint ObtieneDocumento");
        //$GLOBALS['log']->fatal("Enlace: ". $Enlace);
        $Enlace = base64_decode($Enlace);
        //$GLOBALS['log']->fatal("Enlace: ". $Enlace);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $Enlace);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        //$GLOBALS['log']->fatal("Resultado: ". $result);
        return $result;

    }
}