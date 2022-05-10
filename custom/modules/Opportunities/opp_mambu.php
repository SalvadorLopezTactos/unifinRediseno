<?php
/**
 * Created by Adrian Arauz
 * User: root
 * Date: 23/04/2020
 *
 *
 * 1.-Validar que encodedkey_mambu_c de accounts no esté vacío
 * 2.-Validar que la solicitud recibida sea 8 (Uniclick), tenga estatus Autorizada y el tct_id_mambu_c este vacio
 * 3.-Crear body para peticion a UnifinApi (curl)
 * 4.-Hacer update al campo tct_id_mambu_c con el encodedKey recibido
 *
 */

class MambuLogic
{
    function create_LC($bean = null, $event = null, $args = null)
    {
        global $sugar_config,$db;
        global $app_list_strings;
        $available_financiero=array();
        $lista_productos = $app_list_strings['productos_integra_mambu_list'];
        //Recorriendo lista de de productos
        foreach ($lista_productos as $key => $value) {
            array_push($available_financiero,$key);
        }
        //traer el bean de la cuenta para obtener el encodedkey_mambu_c
        $beanCuenta = BeanFactory::retrieveBean('Accounts', $bean->account_id, array('disable_row_level_security' => true));
        if(in_array($bean->producto_financiero_c ,$available_financiero) && $bean->estatus_c=="N" && $beanCuenta->encodedkey_mambu_c!="" && $bean->tct_id_mambu_c=="") {
            $GLOBALS['log']->fatal("Inicia MambuLogic para creacion de Linea de credito Mambu");
            //Declara variables globales para la peticion del servicio Mambu
            //$url=$sugar_config['url_mambu_gral'].'creditarrangements';
            //$user=$sugar_config['user_mambu'];
            //$pwd=$sugar_config['pwd_mambu'];
            //$auth_encode=base64_encode( $user.':'.$pwd );

            $url=$sugar_config['url_mambu_uniclick'].'clientes/linea';
            $apiKey=$sugar_config['apikey_mambu_uniclick'];
            //Transformacion campo date_entered (añade horas y -05:00)
            $timedate2 = new TimeDate();
            $datetime_startDate = $timedate2->fromDb($bean->date_entered);
            $fecha_creacion = date("c", strtotime($datetime_startDate));
            //$GLOBALS['log']->fatal("Fecha de creacion " .$fecha_creacion);
            //Corta los ultimos 6 caracteres del date_entered para añadirlos a la vigencia de linea
            $timezoneExp=substr($fecha_creacion, -6);
            //Para dar formato a la fecha necesario, ejemplo 2022-12-31T00:00:00-06:00
            //Concatena vigencia y añade terminacion 05:00
            $fechaexp=$bean->vigencialinea_c."T12:00:00".$timezoneExp;
            //$GLOBALS['log']->fatal("Fecha linea de expiracion ".$fechaexp);
            $producto_financiero_c = $bean->producto_financiero_c;

            /*
            $body = array(
                    "amount"=> $bean->monto_c,
                    "notes"=> $bean->name,
                    "holderKey"=> $beanCuenta->encodedkey_mambu_c,
                    "exposureLimitType"=> "APPROVED_AMOUNT",
                    "expireDate"=> $fechaexp,
                    "holderType"=> "GROUP",
                    "startDate"=> $fecha_creacion,
                    "_datos_linea_credito"=>array (
                    "id_linea_credito"=> $bean->id_linea_credito_c,
                    "monto_autorizado"=> $bean->amount
                    ),
                    "_productos"=> array(
                     $producto_financiero_c=>"TRUE"
                    )
            );*/
            //Revolvente
            $revolvente = ($bean->revolvente_c) ? "TRUE" : "FALSE";

            $body = array(
                "amount"=> $bean->monto_c,
                "notes"=> $bean->name,
                "holderKey"=> $beanCuenta->encodedkey_mambu_c,
                "exposureLimitType"=> "APPROVED_AMOUNT",
                "expireDate"=> $bean->vigencialinea_c .' 12:00:00',
                "holderType"=> "GROUP",
                "startDate"=> $bean->date_entered,
                "_datos_linea_credito"=>array(
                    "id_linea_credito"=> $bean->id_linea_credito_c,
                    "monto_autorizado"=> $bean->amount,
                    "_revolvente"=> $revolvente
                ),
                "_productos"=> array(
                    $producto_financiero_c=>"TRUE"
                )
            );
            $GLOBALS['log']->fatal('Petición: Mambu interacion '. json_encode($body));
            //Llama a UnifinAPI para que realice el consumo de servicio a Mambu
            $callApi = new UnifinAPI();
            //$resultado = $callApi->postMambu($url,$body,$auth_encode);
            $resultado = $callApi->postMambuUniclick($url,$body,$apiKey);
            $GLOBALS['log']->fatal('Resultado: PEticion mambu integracion '. json_encode($resultado));
           if(!empty($resultado['encodedKey'])){
               $GLOBALS['log']->fatal('Ha realizado correctamente la linea de crédito a Mambu con la cuenta ' .$bean->name);
               $bean->tct_id_mambu_c=$resultado['encodedKey'];
               //Realiza update al campo tct_id_mambu_c con el valor del encodedKey
               $query = "UPDATE opportunities_cstm
                              SET tct_id_mambu_c ='".$resultado['encodedKey']."'
                              WHERE id_c = '".$bean->id."'";
               $queryResult = $db->query($query);
               //$GLOBALS['log']->fatal($query);
               //$GLOBALS['log']->fatal("Realiza actualizacion al campo id_mambu_c");
           }else{
               $GLOBALS['log']->fatal("Error al procesar la solicitud 'creditarrangements', verifique información");
               //Mandar notificación a emails de la lista de studio
               global $app_list_strings;
               $cuentas_email=array();
               $lista_correos = $app_list_strings['emails_error_mambu_list'];
               //Recorriendo lista de emails
               foreach ($lista_correos as $key => $value) {
                   array_push($cuentas_email,$lista_correos[$key]);
                }
               //$cuenta_email=$lista_correos['1'];
               $bodyEmail=$this->estableceCuerpoCorreoErrorMambu($body,$resultado);
               //Enviando correo
               $this->enviarNotificacionErrorMambu("Notificación: Petición hacia Mambú generada sin éxito (creditarrangements)",$bodyEmail,$cuentas_email,"Admin");
           }
        }
    }

    public function enviarNotificacionErrorMambu($asunto,$cuerpoCorreo,$correos,$nombreUsuario){
        //Enviando correo a asesor origen
        $GLOBALS['log']->fatal("ENVIANDO CORREO DE ERROR MAMBU A :".$correo);
        $insert = '';
        $hoy = date("Y-m-d H:i:s");
        try{
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject($asunto);
            $body = trim($cuerpoCorreo);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            for ($i=0; $i < count($correos); $i++) {
                $GLOBALS['log']->fatal("AGREGANDO CORREOS DESTINATARIOS: ".$correos[$i]);
                $mailer->addRecipientsTo(new EmailIdentity($correos[$i], $nombreUsuario));
            }
            //$mailer->addRecipientsTo(new EmailIdentity($correo, $nombreUsuario));
            $result = $mailer->send();

        } catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email ".$nombreUsuario);
            $GLOBALS['log']->fatal("Exception ".$e);

        } catch (MailerException $me) {
            $message = $me->getMessage();
            switch ($me->getCode()) {
                case \MailerException::FailedToConnectToRemoteServer:
                    $GLOBALS["log"]->fatal("BeanUpdatesMailer :: error sending email, system smtp server is not set");
                    break;
                default:
                    $GLOBALS["log"]->fatal("BeanUpdatesMailer :: error sending e-mail (method: {$mailTransmissionProtocol}), (error: {$message})");
                    break;
            }
        }

    }

    public function estableceCuerpoCorreoErrorMambu($contenidoPeticion,$contenidoError){

        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>Estimado usuario</b><br>
        Se le informa que se ha producido un error en la petición hacia Mambú, el cual se detalla de la siguiente forma:<br><br>'.json_encode($contenidoError).'
      <br><br>En donde la petición enviada fue la siguiente:<br><br>'.json_encode($contenidoPeticion).'
      <br><br>Atentamente Unifin</font></p>
      <br><p class="imagen"><img border="0" width="350" height="107" style="width:3.6458in;height:1.1145in" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>

      <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
      <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
       Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
       Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
       No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
       Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';

        return $mailHTML;

    }
}
