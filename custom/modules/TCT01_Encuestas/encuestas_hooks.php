<?php
    /**
     * Created by CVV
     * User: carmen.velasco@unifin.com.mx
     * Date: 19/10/2016
     */

    require_once('modules/Emails/Email.php');

class Encuestas_Hooks
{


    //@Jesus Carrillo
    //Funcion que envia encuesta de satisfaccion al crear un nuevo registro en el modulo de encuestas
    function Sendmails($bean = null, $event = null, $args = null)
    {
        $emails = [];
        $ids = [];
        $GLOBALS['log']->fatal('>>>>>>>Entro Encuestas_Hook: ');//------------------------------------


        if ($bean->tct_correo_txf != '' && $bean->description == '') {
            global $sugar_config;
            $GLOBALS['site_url'] = $sugar_config['site_url'];
        /*
            //Define mail
            ## START Send Email
            $mail = new SugarPHPMailer();
            //$mail->prepForOutbound();
            //$mail->setMailerForSystem();
            $mail->setMailer();
            //$mail->From = 'jesusmoca7@gmail.com';
            $mail->FromName = 'UNIFIN Financiera.';
            $mail->Sender = $mail->From;
            $mail->Subject = $bean->name;
            include 'custom/Levementum/CustomEntryPoints/encuesta_template.php';
            $mail->Body = $forma;
            $mail->IsHTML(true);
            $mail->AddAddress($bean->tct_correo_txf);
            //$mail->AddAddress('jesus.carrillo@tactos.com.mx');
            //$mail->AddAddress('adrauz@gmail.com');
            //$mail->AddAddress('axel.flores@tactos.com.mx');
            //$mail->AddAddress('wendy.reyes@unifin.com.mx');
            $mail->Send();
        */

//            include 'custom/Levementum/CustomEntryPoints/encuesta_template.php';

            $outboundEmail                    = new OutboundEmail();
            $outboundEmail->mail_sendtype     = 'smtp';
            //$outboundEmail->mail_smtpserver   = $_REQUEST['mail_smtpserver'];
            $outboundEmail->mail_smtpserver   = 'mail.unifin.com.mx';
            $outboundEmail->mail_smtpport     = '25';
            $outboundEmail->mail_smtpauth_req = 0;
            $outboundEmail->mail_smtpuser     = '';
            $outboundEmail->mail_smtppass     = null;
            $outboundEmail->mail_smtpssl      = '';

            global $current_user;

            $configurations = array();
            $configurations["from_email"] = 'unifin-notificaciones@unifin.com.mx';
            //$configurations["from_name"] = $_REQUEST['mail_from_name'];
            //$configurations["display_name"] = "{$_REQUEST['mail_from_name']} (unifin-notificaciones@unifin.com.mx)";
            $configurations["from_name"] = 'Unifin Financiera';
            $configurations["display_name"] = "Unifin Financiera (unifin-notificaciones@unifin.com.mx)";
            $configurations["personal"] = 0;

            $outboundEmailConfiguration = OutboundEmailConfigurationPeer::buildOutboundEmailConfiguration(
                $current_user,
                $configurations,
                $outboundEmail);


            $mailer = MailerFactory::getMailer($outboundEmailConfiguration);

            $mailer->setSubject($bean->name);
            $mailer->addRecipientsTo(new EmailIdentity($bean->tct_correo_txf));
            $bean_acc = BeanFactory::retrieveBean('Accounts', $bean->account_id_c);
            $linkv2='<html>
                <head>
                </head>
                <body>
                    <div align="center" style="width: 660px;">
                        <img src="https://fotos.subefotos.com/d83bd716402da605745bfa6158d0f376o.png">
                        <br><br><br><br> 
                        <h3><b>Hola '.$bean_acc->name.'<br><br>Para UNIFIN tu opinión es muy importante.<br>Por eso te invitamos a responder una sencilla encuesta.<br>Para iniciar, da clic <a href="'.$GLOBALS['site_url'].'/custom/Levementum/CustomEntryPoints/encuesta_template.php?id_encuesta='.$bean->id.'&url='.$GLOBALS['site_url'].'&name='. $bean_acc->name.'">aquí</a><br><br>Gracias por ayudarnos a mejorar para ti.</b></h3>
                        <br><br><br><br>
                        <img src="https://fotos.subefotos.com/21e0681a07a484fedf20d4fbc9817396o.png">
                    </div>
                </body>
            </html>
            ';
            //$mailer->setHtmlBody($body); //Si queremos que la encuesta vaya en el cuerpo del correo
            $mailer->setHtmlBody($linkv2);

            $mailer->send();


            $GLOBALS['log']->fatal("Se ha enviado encuesta---------------");//----------------------

        }
    }
}