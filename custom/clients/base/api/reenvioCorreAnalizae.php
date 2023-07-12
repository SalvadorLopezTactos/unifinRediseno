<?php
/**
 * Created by PhpStorm.
 * User: AF
 * Date: 2023/07/11
 */

class reenvioCorreAnalizae extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //Valida situación de login
            'reenvioCorreAnalizaeAPI' => array(
                //request type
                'reqType' => 'POST',
                //set authentication
                'noLoginRequired' => false,
                //endpoint path
                'path' => array('reenvioCorreAnalizae'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'reenvioCorreAnalizaeMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Detona envío de notificación para Analizate',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    public function reenvioCorreAnalizaeMethod($api, $args)
    {
        $result = array(
            "status"=>"200",
            "message"=>""
        );
        try{        
            //Recupera parámetros
            $idCuenta = isset($args['idCuenta']) ? $args['idCuenta'] : '';
            
            //Valida Id de cuenta
            if($idCuenta){
              
                //Recupera cuenta
                $beanCuenta = BeanFactory::getBean('Accounts', $idCuenta, array('disable_row_level_security' => true));
                if (!empty($beanCuenta->id)) {
                    
                    //prepara variabales
                    global $db, $current_user, $app_list_strings;
                    require_once("include/SugarPHPMailer.php");
  									require_once("modules/EmailTemplates/EmailTemplate.php");
  									require_once("modules/Administration/Administration.php");
  									
                    $fechaActual = gmdate("Y-m-d H:i:s");
                    $fechaActualString = strtotime($fechaActual);
                    $fechaActualDate = date('Y-m-d',$fechaActualString);
                                        
                    //Aplica validación de Envíos generados
                    $menorDosHoras = false;
                    $beanCuenta->load_relationship('anlzt_analizate_accounts');
                    $analizateAsociados = $beanCuenta->anlzt_analizate_accounts->getBeans($beanCuenta->id,array('disable_row_level_security' => true));
                    //Itera registros analizate de cliente y estatus enviado
                    foreach ($analizateAsociados as $analizate) {
                        if($analizate->estado == '1'){
                            $diferenciaHoras = round((strtotime($fechaActual) - strtotime($analizate->fecha_actualizacion))/3600, 1);
                            $fechaActualizacionString = strtotime($analizate->fecha_actualizacion);
                            $fechaActualizacionDate = date('Y-m-d',$fechaActualizacionString);
                            if($diferenciaHoras < 2){
                                $menorDosHoras =  true;
                            }
                        }
                    }

                    //Prepara envío de notificación
                    if(!$menorDosHoras){
                        //Registra analizate de envío
                        $relacion = BeanFactory::newBean('ANLZT_analizate');
                        $url_portalFinanciera = '&UUID=' . base64_encode($beanCuenta->id) . '&RFC_CIEC=' . base64_encode($beanCuenta->rfc_c). '&MAIL=' . base64_encode($beanCuenta->email1);
                        $relacion->anlzt_analizate_accountsaccounts_ida = $beanCuenta->id;
                        $relacion->load_relationship('anlzt_analizate_accounts');
                        $relacion->anlzt_analizate_accounts->add($beanCuenta->id);
                        $relacion->url_portal = $url_portalFinanciera;
                        $relacion->empresa = 1;
                        $relacion->tipo = 1;
                        $relacion->fecha_actualizacion = $fechaActual;                        
                        $relacion->assigned_user_id = $current_user->id;
                        $relacion->tipo_registro_cuenta_c = "3";
                        $relacion->save();
                        //Actualiza estado =1 para evitar envío de notificación default
                        $relacion->estado = 1;
                        $relacion->save();
                        
                        //Recupera template y parsea variables
                        $urlFinanciera = $app_list_strings['analizate_url_list'][$relacion->empresa];
                        $urlFinanciera.='&UUID='. base64_encode($beanCuenta->id). '&RFC_CIEC=' .base64_encode($beanCuenta->rfc_c). '&MAIL=' .base64_encode($beanCuenta->email1);
                        $emailtemplate = new EmailTemplate();
      									$emailtemplate->retrieve_by_string_fields(array('name'=>'Reenvio Analizate','type'=>'email'));
                        $asunto = $emailtemplate->subject;
                        $emailtemplate->subject = $asunto;
      									$body_html = $emailtemplate->body_html;
      									$body_html = str_replace('nombre_cliente', $beanCuenta->name, $body_html);
                        $body_html = str_replace('url', $urlFinanciera, $body_html);
                        $emailtemplate->body_html = $body_html;
                        $mailer = MailerFactory::getSystemDefaultMailer();
      									$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
      									$mailer->setSubject($emailtemplate->subject);
      									$body = trim($emailtemplate->body_html);
      									$mailer->setHtmlBody($body);
      									$mailer->clearRecipients();
      									$mailer->addRecipientsTo(new EmailIdentity($beanCuenta->email1, $beanCuenta->name));
      									// Crea auditoría de correos
      									$userid = $current_user->id;
      									$recordid = $beanCuenta->id;
      									$hoy = date("Y-m-d H:i:s");
      									$mail = 'Reenvio Analizate - API';
                        
                        //Detona envío de correo
      									try {
                            $resultMail = $mailer->send();
        										$insert = "INSERT INTO user_email_log (id, user_id, related_id, date_entered, name_email, subject, type, related_type, status, description)
        											VALUES (uuid(), '{$userid}', '{$recordid}', '{$hoy}', '{$mail}', '{$asunto}', 'TO', 'Accounts', 'OK', 'Correo exitosamente enviado')";
                            $GLOBALS['db']->query($insert);
                            //Actualzia resultado
                            $result['message']='Envio de correo generado de forma correcta';
      									} catch (Exception $e) {
      										  $insert = "INSERT INTO user_email_log (id, user_id, related_id, date_entered, name_email, subject, type, related_type, status, error_code, description)
      											           VALUES (uuid(), '{$userid}', '{$recordid}', '{$hoy}', '{$mail}', '{$asunto}', 'TO', 'Accounts', 'ERROR', '01', '{$e->getMessage()}')";
      										  $GLOBALS['db']->query($insert);
                            //Error en proceso interno
                            $result['status']='500';
                            $result['message']='Erro de sistema: '. $e->getMessage();
      									}
                        
                    }else{
                        //Se ha realizado envío previo en menos de 2 horas
                        $result['status']='400';
                        $result['message']='La cuenta con Id: '. $idCuenta .' ha recibido correos en las últimas 2 horas.';
                    }
                }else{
                    //No recupera cuenta con Id proporcionado
                    $result['status']='400';
                    $result['message']='Error de datos: La cuenta con Id: '. $idCuenta .' no existe en CRM';
                }
            }else{
                //Valor IdCuenta viene vacío
                $result['status']='400';
                $result['message']='Error de datos: Se requiere enviar Id de Cuenta';
            }            
        }catch(Exception $e) {
            //Error en proceso interno
            $result['status']='500';
            $result['message']='Erro de sistema: '. $e;
        }
        
        //Regresa respuesta de validación
        return $result;
    }
    
}

?>
