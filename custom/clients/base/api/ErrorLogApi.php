<?php

/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 21/03/24
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ErrorLogApi extends SugarApi
{

    /**
     * Registro de todas las rutas para consumir los servicios del API
     *
     */
    public function registerApiRest()
    {
        return array(
            //GET
            'apiErrorLog' => array(
                //request type
                'reqType' => 'POST',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('error_log'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'setDataErrorLog',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Genera insert en tabla con bitácora de errores',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );
    }

    public function setDataErrorLog($api, $args)
    {
        global $current_user;
        global $db;
        global $app_list_strings;

        $id = $id_u_audit = create_guid();
        $current_date = $date = TimeDate::getInstance()->nowDb();
        $id_user = $current_user->id;
       
        $integration = $args['integration'];
        $system = $args['system'];
        $parent_type = $args['parent_type'];
        $parent_id = $args['parent_id'];
        $endpoint = $args['endpoint'];
        $request = $args['request'];
        $response = $args['response'];
        //Obtiene parámetros, el id de cuenta

        $stringInsert = "INSERT INTO bitacora_errores (id, created_by, date_entered, integration, system, parent_type, parent_id, endpoint, request, response) VALUES ('{$id}', '{$id_user}', '{$current_date}', '{$integration}', '{$system}', '{$parent_type}', '{$parent_id}', '{$endpoint}', '{$request}', '{$response}')";
        $result = $db->query($stringInsert);

        //Una vez insertado, se envía notificación
        $lista_emails = $email_copia = $app_list_strings['emails_error_log_list'];
        $arr_emails = array();
        foreach ($lista_emails as $key => $email) {
            array_push($arr_emails,$email);
        }

        $bodyEmail = $this->buildBodyErrorLog($integration,$system,$endpoint,$request,$response);

        $GLOBALS['log']->fatal("Enviando correo con error en integración");
        $this->sendEmailError($arr_emails,$bodyEmail,$system);

        return $args;
    }

    public function buildBodyErrorLog($integration, $system, $endpoint, $request, $response)
    {

        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Se ha detectado un error para la integración:<br>
            Descripción: <b>'.$integration. '</b>, con el sistema: <b>'.$system. '</b><br><br>
            Datos de petición:<br>
            <b>Endpoint:</b> '.$endpoint. '<br>
            <b>Request:</b> '.$request. '<br>
            <b>Response:</b> '.$response. '<br>
            <br><br>Atentamente Unifin</font></p>
            <br><br><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png">
            <br><span style="font-size:8.5pt;color:#757b80">____________________________________________</span>
            <p class="MsoNormal" style="text-align: justify;">
              <span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
                Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
                Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
                No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
                Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro <a href="https://www.unifin.com.mx/aviso-de-privacidad" target="_blank">Aviso de Privacidad</a>  publicado en <a href="http://www.unifin.com.mx/" target="_blank">www.unifin.com.mx</a>
              </span>
            </p>';

        return $mailHTML;
    }

    public function sendEmailError($emails_address, $body_correo, $system)
    {

        try {
            
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject('UNIFIN CRM : Error integración - '.$system);
            $body = trim($body_correo);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            for ($i = 0; $i < count($emails_address); $i++) {
                $GLOBALS['log']->fatal("AGREGANDO CORREOS DESTINATARIOS: " . $emails_address[$i]);
                $mailer->addRecipientsTo(new EmailIdentity($emails_address[$i], $emails_address[$i]));
            }
            $result = $mailer->send();
        } catch (Exception $e) {
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email ");
            $GLOBALS['log']->fatal(print_r($e, true));
        }
    }
}
