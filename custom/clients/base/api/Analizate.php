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
            'SolicitaCIACCliente' => array(
                'reqType' => 'POST',
                'path' => array('solicitaCIECCliente'),
                'pathVars' => array(''),
                'method' => 'solicitaCIECFunction',
                'shortHelp' => 'Solicita CIEC para Cliente',
            ),

        );
    }

    public function ObtieneFinanciera($api, $args){
        //Respuesta analizate proveedor financiera
        $data=array();
        $data['Financiera']=array();
        $data['Financiera']['estado']="";
        $data['Financiera']['fecha']="";
        $data['Financiera']['documento']="";
        $data['Financiera']['fecha_documento']="";
        $data['Financiera']['url_documento']="";
        $data['Financiera']['url_portal']="";
        $idCuenta = $args['id'];
        //Respuesta analizate proveedor credit
        $data['Credit']=array();
        $data['Credit']['estado']="";
        $data['Credit']['fecha']="";
        $data['Credit']['documento']="";
        $data['Credit']['fecha_documento']="";
        $data['Credit']['url_documento']="";
        $data['Credit']['url_portal']="";
        //Respuesta analizate cliente
        $data['AnalizateCliente']=array();
        $data['AnalizateCliente']['estado']="";
        $data['AnalizateCliente']['fecha']="";
        $data['AnalizateCliente']['documento']="";
        $data['AnalizateCliente']['fecha_documento']="";
        $data['AnalizateCliente']['url_documento']="";
        $data['AnalizateCliente']['url_portal']="";

        //Cargar toda la informacion del bean, en este caso de la cuenta
        $beanCuenta = BeanFactory::getBean("Accounts", $idCuenta);
        if (!isset($beanCuenta->id)){
            //Recuperar id LEAD
            $beanLead = BeanFactory::retrieveBean('Leads', $idCuenta,array('disable_row_level_security' => true));
            $beanCuenta=$beanLead;
            //Cargar lo relacionado de la cuenta, en este caso al name del vardef de anzlt_analizate
            $beanCuenta->load_relationship('leads_anlzt_analizate_1');
            //Trae todos los registros asociados entre el link de la account y Analizate
            $relatedBeans = $beanCuenta->leads_anlzt_analizate_1->getBeans($beanCuenta->id,array('disable_row_level_security' => true));
        }else{
            //Cargar lo relacionado de la cuenta, en este caso al name del vardef de anzlt_analizate
            $beanCuenta->load_relationship('anlzt_analizate_accounts');
            //Trae todos los registros asociados entre el link de la account y Analizate
            $relatedBeans = $beanCuenta->anlzt_analizate_accounts->getBeans($beanCuenta->id,array('disable_row_level_security' => true));
        }
        
        //Se iteran las n tandas de registros
        foreach ($relatedBeans as $estados) {
            if($estados->tipo_registro_cuenta_c == '2' || $estados->tipo_registro_cuenta_c == '3' || $estados->tipo_registro_cuenta_c == '4'){
                //Agrega información a sección cliente
                if ($estados->tipo==1){
                    //En los siguientes 2 if, se valida que el valor de la fecha sea el mas reciente en cada iteracion
                    //Para así obtener el registro más reciente y asignarle los valores de fecha y estado
                    if ($data['AnalizateCliente']['fecha']==""){
                        $data['AnalizateCliente']['fecha']=$estados->fecha_actualizacion;
                        $data['AnalizateCliente']['estado']=$estados->estado;
                        $data['AnalizateCliente']['url_portal']='&UUID='.base64_encode($beanCuenta->id).'&RFC_CIEC='.base64_encode($beanCuenta->rfc).'&MAIL='.base64_encode($beanCuenta->email1);
                    }
                    if($estados->fecha_actualizacion>$data['AnalizateCliente']['fecha']){
                        $data['AnalizateCliente']['fecha']=$estados->fecha_actualizacion;
                        $data['AnalizateCliente']['estado']=$estados->estado;
                        $data['AnalizateCliente']['url_portal']='&UUID='.base64_encode($beanCuenta->id).'&RFC_CIEC='.base64_encode($beanCuenta->rfc).'&MAIL='.base64_encode($beanCuenta->email1);
                    }

                }else{
                    //Recuperar registro mas reciente (Url del documento)
                    if ($data['AnalizateCliente']['fecha_documento']==""){
                        $data['AnalizateCliente']['documento']=$estados->documento;
                        $data['AnalizateCliente']['fecha_documento']=$estados->fecha_actualizacion;
                        $data['AnalizateCliente']['url_documento']=$estados->url_documento;
                    }
                    if($estados->fecha_actualizacion>$data['AnalizateCliente']['fecha_documento']){
                        $data['AnalizateCliente']['fecha_documento']=$estados->fecha_actualizacion;
                        $data['AnalizateCliente']['documento']=$estados->documento;
                        $data['AnalizateCliente']['url_documento']=$estados->url_documento;
                    }
                }
            }else {
                //Agrega información a sección proveedor
                if ($estados->empresa==1){
                    if ($estados->tipo==1){
                        //En los siguientes 2 if, se valida que el valor de la fecha sea el mas reciente en cada iteracion
                        //Para así obtener el registro más reciente y asignarle los valores de fecha y estado
                        if ($data['Financiera']['fecha']==""){
                            $data['Financiera']['fecha']=$estados->fecha_actualizacion;
                            $data['Financiera']['estado']=$estados->estado;
                            $data['Financiera']['url_portal']='&UUID='.base64_encode($beanCuenta->id).'&RFC_CIEC='.base64_encode($beanCuenta->rfc).'&MAIL='.base64_encode($beanCuenta->email1);
                        }
                        if($estados->fecha_actualizacion>$data['Financiera']['fecha']){
                            $data['Financiera']['fecha']=$estados->fecha_actualizacion;
                            $data['Financiera']['estado']=$estados->estado;
                            $data['Financiera']['url_portal']='&UUID='.base64_encode($beanCuenta->id).'&RFC_CIEC='.base64_encode($beanCuenta->rfc).'&MAIL='.base64_encode($beanCuenta->email1);
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
                            $data['Credit']['url_portal']='&UUID='.base64_encode($beanCuenta->id).'&RFC_CIEC='.base64_encode($beanCuenta->rfc).'&MAIL='.base64_encode($beanCuenta->email1);
                        }
                        if($estados->fecha_actualizacion>$data['Credit']['fecha']){
                            $data['Credit']['fecha']=$estados->fecha_actualizacion;
                            $data['Credit']['estado']=$estados->estado;
                            $data['Credit']['url_portal']='&UUID='.base64_encode($beanCuenta->id).'&RFC_CIEC='.base64_encode($beanCuenta->rfc).'&MAIL='.base64_encode($beanCuenta->email1);
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
        if ($data['AnalizateCliente']['fecha']!="") {
            //Variable para convertir la hora
            $fecha1 = new DateTime($data['AnalizateCliente']['fecha'], new DateTimeZone ('UTC'));
            $fecha1->setTimezone(new DateTimeZone('CST'));
            $data['AnalizateCliente']['fecha'] = $fecha1->format('Y-m-d H:i:s');
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
        return base64_encode($result);

    }
    public function  solicitaCIECFunction($api, $args){
        //Recupera variables
        $idCuenta = isset($args['idCuenta']) ? $args['idCuenta'] : '';
        $idUsuario = isset($args['idUsuario']) ? $args['idUsuario'] : '';
        $fechaActual = gmdate("Y-m-d H:i:s");
        $fechaActualString = strtotime($fechaActual);
        $fechaActualDate = date('Y-m-d',$fechaActualString);

        //Estructura de respuesta default
        $resultado = [];
        $resultado['status'] = '200';
        $resultado['message'] = 'Se ha enviado un nuevo correo a la cuenta.';

        //Aplica validación de usuario asignado
        $esUsuarioAsignado = false;
        $beanCuenta = BeanFactory::retrieveBean('Accounts', $idCuenta, array('disable_row_level_security' => true));
        $beanCuenta->load_relationship('accounts_uni_productos_1');
        $uniProdAsociados= $beanCuenta->accounts_uni_productos_1->getBeans();
        foreach ($uniProdAsociados as $uniProducto) {
            $esUsuarioAsignado = ($uniProducto->assigned_user_id == $idUsuario && $uniProducto->tipo_cuenta=="3") ? true : $esUsuarioAsignado;
        }
        $esUsuarioAsignado = true; //Quitar
        if($esUsuarioAsignado){
            //Aplica validación de Envíos generados
            $menorDosHoras = false;
            $enviosDia = 0;
            $beanCuenta->load_relationship('anlzt_analizate_accounts');
            $analizateAsociados = $beanCuenta->anlzt_analizate_accounts->getBeans($beanCuenta->id,array('disable_row_level_security' => true));
            //Itera registros analizate de cliente y estatus enviado
            foreach ($analizateAsociados as $analizate) {
                if(($analizate->tipo_registro_cuenta_c == '2' || $analizate->tipo_registro_cuenta_c == '3'|| $analizate->tipo_registro_cuenta_c == '4') && $analizate->estado == '1'){
                    $diferenciaHoras = round((strtotime($fechaActual) - strtotime($analizate->fecha_actualizacion))/3600, 1);
                    $fechaActualizacionString = strtotime($analizate->fecha_actualizacion);
                    $fechaActualizacionDate = date('Y-m-d',$fechaActualizacionString);
                    if($diferenciaHoras < 2){
                        $menorDosHoras =  true;
                    }
                    if($fechaActualizacionDate == $fechaActualDate){
                        $enviosDia ++ ;
                    }
                }
            }
            //Valida que no sea hayan enviado más de 2 notificaciones en el día
            if($enviosDia<2){
                //Valida última notificación mayor a 2 horas
                if(!$menorDosHoras){
                    try{
                        //Crea nuevo bean Analizate (registro) y la relacion con acccounts (registro creado).
                        $url_portalFinanciera = '&UUID=' . base64_encode($beanCuenta->id) . '&RFC_CIEC=' . base64_encode($beanCuenta->rfc_c). '&MAIL=' . base64_encode($beanCuenta->email1);
                        $relacion = BeanFactory::newBean('ANLZT_analizate');
                        $relacion->anlzt_analizate_accountsaccounts_ida = $beanCuenta->id;
                        $relacion->empresa = 1;
                        $relacion->estado = 1;
                        $relacion->tipo = 1;
                        $relacion->fecha_actualizacion = $fechaActual;
                        $relacion->url_portal = $url_portalFinanciera;
                        $relacion->assigned_user_id = $idUsuario;
                        $relacion->tipo_registro_cuenta_c = "3";
                        $relacion->load_relationship('anlzt_analizate_accounts');
                        $relacion->anlzt_analizate_accounts->add($beanCuenta->id);
                        $relacion->save();
                    } catch (Exception $e) {
                        //Error en proceso de petición
                        $resultado['status'] = '500';
                        $resultado['message'] = 'Error al generar la petición: '.$e->getMessage();
                    }
                }else{
                    //Error de no se pueden generar notificación al menos en 2 horas
                    $resultado['status'] = '300';
                    $resultado['message'] = 'Debe esperar 2 horas a partir de la última solicitud generada.';
                }
            }else{
                //Error de no se pueden generar más de dos envíos por día
                $resultado['status'] = '300';
                $resultado['message'] = 'Ya se han enviado 2 notificaciones en el día y no se puede detonar una nueva solicitud.';
            }
        }else{
            //Error de usuario no asignado a la cuenta
            $resultado['status'] = '300';
            $resultado['message'] = 'Para esta solicitud la cuenta debe ser cliente y estar asignada a ti.';
        }

        return $resultado;

    }


}
