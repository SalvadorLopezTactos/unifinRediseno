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
        $GLOBALS['log']->fatal('>>>>>>>Encuestas_Hook: ');//-------------------------------------


        if ($bean->tct_correo_txf != '' && $bean->description == '') {
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

            global $sugar_config;

            $GLOBALS['site_url'] = $sugar_config['site_url'];

            include 'custom/Levementum/CustomEntryPoints/encuesta_template.php';

            $mail->Body = $forma;


            $mail->IsHTML(true);


            $mail->AddAddress($bean->tct_correo_txf);

            //$mail->AddAddress('jesus.carrillo@tactos.com.mx');
            //$mail->AddAddress('adrauz@gmail.com');
            //$mail->AddAddress('axel.flores@tactos.com.mx');
            //$mail->AddAddress('jesusmoca7@hotmail.com');
            //$mail->AddAddress('wendy.reyes@unifin.com.mx');

            $mail->Send();

            $GLOBALS['log']->fatal("Se ha enviado encuesta---------------");//----------------------

        }
    }
}