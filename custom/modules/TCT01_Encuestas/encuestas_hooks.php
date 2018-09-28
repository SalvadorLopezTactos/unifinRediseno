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
    //
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

            include 'custom/Levementum/CustomEntryPoints/encuesta_template.php';


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
            $configurations["display_name"] = "{'Unifin Financiera'} ({'unifin-notificaciones@unifin.com.mx'})";
            $configurations["personal"] = 0;

            $outboundEmailConfiguration = OutboundEmailConfigurationPeer::buildOutboundEmailConfiguration(
                $current_user,
                $configurations,
                $outboundEmail);

            $mailer = MailerFactory::getMailer($outboundEmailConfiguration);

            $mailer->setSubject($bean->name);
            $mailer->addRecipientsTo(new EmailIdentity($bean->tct_correo_txf));
            $mailer->setHtmlBody($forma);

            $mailer->send();


            $GLOBALS['log']->fatal("Se ha enviado encuesta---------------");//----------------------

        }
    }
}