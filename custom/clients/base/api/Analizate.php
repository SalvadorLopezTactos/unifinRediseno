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

        $data=array();
        $data['Financiera']=array();
        $data['Financiera']['estado']="";
        $data['Financiera']['fecha']="";
        $data['Financiera']['documento']="";
        $data['Financiera']['fecha_documento']="";
        $data['Financiera']['url_documento']="";
        $data['Financiera']['url_portal']="";
        $idCuenta = $args['id'];

        $data['Credit']=array();
        $data['Credit']['estado']="";
        $data['Credit']['fecha']="";
        $data['Credit']['documento']="";
        $data['Credit']['fecha_documento']="";
        $data['Credit']['url_documento']="";
        $data['Credit']['url_portal']="";

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
                    if ($data['Financiera']['fecha']==""){
                        $data['Financiera']['fecha']=$estados->fecha_actualizacion;
                        $data['Financiera']['estado']=$estados->estado;
                        $data['Financiera']['url_portal']='&UUID='.$beanCuenta->id.'&RFC_CIEC='.$beanCuenta->rfc;
                    }
                    if($estados->fecha_actualizacion>$data['Financiera']['fecha']){
                        $data['Financiera']['fecha']=$estados->fecha_actualizacion;
                        $data['Financiera']['estado']=$estados->estado;
                        $data['Financiera']['url_portal']='&UUID='.$beanCuenta->id.'&RFC_CIEC='.$beanCuenta->rfc;
                    }

                }else{
                    //Recuperar registro mas reciente (Url del documento)
                    if ($data['Financiera']['fecha_documento']==""){
                        $data['Financiera']['documento']=$estados->documento;
                        $data['Financiera']['fecha_documento']=$estados->fecha_actualizacion;
                        $data['Financiera']['url_documento']=$estados->url_documento;
                    }
                    if($estados->fecha_actualizacion>$data['Financiera']['fecha_documento']){
                        $data['Financiera']['fecha_documento']=$estados->fecha_actualizacion;
                        $data['Financiera']['documento']=$estados->documento;
                        $data['Financiera']['url_documento']=$estados->url_documento;
                    }
                }
            }else{
                //Validacion de fechas para empresa 2 (Credit)
                if ($estados->tipo==1){
                    //En los siguientes 2 if, se valida que el valor de la fecha sea el mas reciente en cada iteracion
                    //Para así obtener el registro más reciente y asignarle los valores de fecha y estado
                    if ($data['Credit']['fecha']==""){
                        $data['Credit']['fecha']=$estados->fecha_actualizacion;
                        $data['Credit']['estado']=$estados->estado;
                        $data['Credit']['url_portal']='&UUID='.$beanCuenta->id.'&RFC_CIEC='.$beanCuenta->rfc;
                    }
                    if($estados->fecha_actualizacion>$data['Credit']['fecha']){
                        $data['Credit']['fecha']=$estados->fecha_actualizacion;
                        $data['Credit']['estado']=$estados->estado;
                        $data['Credit']['url_portal']='&UUID='.$beanCuenta->id.'&RFC_CIEC='.$beanCuenta->rfc;
                    }
                }else{
                    //Recuperar registro mas reciente (Url del documento)
                    if ($data['Credit']['fecha_documento']==""){
                        $data['Credit']['documento']=$estados->documento;
                        $data['Credit']['fecha_documento']=$estados->fecha_actualizacion;
                        $data['Credit']['url_documento']=$estados->url_documento;
                    }
                    if($estados->fecha_actualizacion>$data['Credit']['fecha_documento']){
                        $data['Credit']['fecha_documento']=$estados->fecha_actualizacion;
                        $data['Credit']['documento']=$estados->documento;
                        $data['Credit']['url_documento']=$estados->url_documento;
                    }
                }
            }
        }
        if ($data['Financiera']['fecha']!="") {
            //Variable para convertir la hora
            $fecha1 = new DateTime($data['Financiera']['fecha'], new DateTimeZone ('UTC'));
            $fecha1->setTimezone(new DateTimeZone('CST'));
            $data['Financiera']['fecha'] = $fecha1->format('Y-m-d H:i:s');
        }
        if ($data['Credit']['fecha']!="") {
            //Variable para convertir la hora
            $fecha1 = new DateTime($data['Credit']['fecha'], new DateTimeZone ('UTC'));
            $fecha1->setTimezone(new DateTimeZone('CST'));
            $data['Credit']['fecha'] = $fecha1->format('Y-m-d H:i:s');
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