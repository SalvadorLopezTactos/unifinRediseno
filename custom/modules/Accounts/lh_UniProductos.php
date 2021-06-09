<?php

class clase_UniProducto
{
    public function func_UniProducto($bean = null, $event = null, $args = null)
    {
        $GLOBALS['log']->fatal("ACTUALIZA UNI PRODUCTOS CUSTOM ---- ");
        //$GLOBALS['log']->fatal("Args", $bean);
        //Campo custom Uni Productos
        $actualizaLeasing = false;
        $actualizaFactoring = false;
        $actualizaCredAuto = false;
        $actualizaFleet = false;
        $actualizaUniclick = false;

        if ($GLOBALS['service']->platform != 'mobile') {
            $uniProducto = $bean->account_uni_productos;

            if (!empty($uniProducto)) {
                foreach ($uniProducto as $key) {
                    if ($key['id'] != '') {
                        $beanUP = BeanFactory::retrieveBean('uni_Productos', $key['id'], array('disable_row_level_security' => true));
                        $beanUP->no_viable = $key['no_viable'];
                        $beanUP->no_viable_razon = $key['no_viable_razon'];
                        $beanUP->exclu_precalif_c=$key['exclu_precalif_c']== true ? 1 : 0;
                        $beanUP->no_viable_razon_fp = $key['no_viable_razon_fp'];
                        $beanUP->no_viable_quien = $key['no_viable_quien'];
                        $beanUP->no_viable_porque = $key['no_viable_porque'];
                        $beanUP->no_viable_producto = $key['no_viable_producto'];
                        $beanUP->no_viable_razon_cf = $key['no_viable_razon_cf'];
                        $beanUP->no_viable_razon_ni = $key['no_viable_razon_ni'];
                        $beanUP->no_viable_otro_c = $key['no_viable_otro_c'];
                        $beanUP->assigned_user_id = $key['assigned_user_id'];
                        $beanUP->canal_c = $key['canal_c'] != "" ? $key['canal_c'] : "";
                        $beanUP->multilinea_c = $key['multilinea_c'];

                        //$GLOBALS['log']->fatal("bean->".$beanUP->status_management_c." - key->".$key['status_management_c']);
                        if(($beanUP->status_management_c != $key['status_management_c']) && ($beanUP->tipo_producto == $key['tipo_producto']) && $beanUP->tipo_producto == '1'){
                            $actualizaLeasing = true;
                        }
                        if(($beanUP->status_management_c != $key['status_management_c']) && ($beanUP->tipo_producto == $key['tipo_producto']) && $beanUP->tipo_producto == '4'){
                            $actualizaFactoring = true;
                        }
                        if(($beanUP->status_management_c != $key['status_management_c']) && ($beanUP->tipo_producto == $key['tipo_producto']) && $beanUP->tipo_producto == '3'){
                            $actualizaCredAuto = true;
                        }
                        if(($beanUP->status_management_c != $key['status_management_c']) && ($beanUP->tipo_producto == $key['tipo_producto']) && $beanUP->tipo_producto == '6'){
                            $actualizaFleet = true;
                        }
                        if(($beanUP->status_management_c != $key['status_management_c']) && ($beanUP->tipo_producto == $key['tipo_producto']) && $beanUP->tipo_producto == '8'){
                            $actualizaUniclick = true;
                        }
                        
                        $beanUP->status_management_c = $key['status_management_c'];
                        $beanUP->razon_c = $key['razon_c'];
                        $beanUP->motivo_c = $key['motivo_c'];
                        $beanUP->detalle_c = $key['detalle_c'];
                        $beanUP->user_id1_c = $key['user_id1_c'];
                        $beanUP->user_id2_c = $key['user_id2_c'];
                        
                        if ($bean->load_relationship('accounts_uni_productos_1') && ($key['tipo_producto'] == 1 || $key['tipo_producto'] == 8)) {
                            $updateProductos = $bean->accounts_uni_productos_1->getBeans($bean->id, array('disable_row_level_security' => true));
                            foreach ($updateProductos as $udpate) {

                                switch ($udpate->tipo_producto) {
                                    case 7:
                                        if ($key['tipo_producto'] == '1') {
                                            $udpate->multilinea_c = $key['multilinea_c'] == true ? 1 : 0;
                                            $udpate->save();
                                        }
                                        break;
                                    case 9:
                                        if ($key['tipo_producto'] == '8') {
                                            $udpate->multilinea_c = $key['multilinea_c'] == true ? 1 : 0;
                                            $udpate->save();
                                        }
                                        break;
                                }
                            }
                        }
                        $beanUP->save();
                    }

                    if (!$args['isUpdate']) {

                        if ($bean->load_relationship('accounts_uni_productos_1')) {
                            $listProductos = $bean->accounts_uni_productos_1->getBeans($bean->id, array('disable_row_level_security' => true));
                            foreach ($listProductos as $beanProducto) {

                                switch ($beanProducto->tipo_producto) {
                                    case 1:
                                        if ($key['producto'] == '1') {
                                            $beanProducto->multilinea_c = $key['multilinea_c'] == true ? 1 : 0;
                                        }
                                        break;
                                    case 3:
                                        if ($key['producto'] == '3') {
                                            $beanProducto->multilinea_c = $key['multilinea_c'] == true ? 1 : 0;
                                        }
                                        break;
                                    case 4:
                                        if ($key['producto'] == '4') {
                                            $beanProducto->multilinea_c = $key['multilinea_c'] == true ? 1 : 0;
                                        }
                                        break;
                                    case 6:
                                        if ($key['producto'] == '6') {
                                            $beanProducto->multilinea_c = $key['multilinea_c'] == true ? 1 : 0;
                                        }
                                        break;
                                    case 8:
                                        if ($key['producto'] == '8') {
                                            $beanProducto->multilinea_c = $key['multilinea_c'] == true ? 1 : 0;
                                            $beanProducto->canal_c = $key['canal_c'] != "" ? $key['canal_c'] : "0";
                                        }
                                        break;
                                    case 7:
                                        if ($key['producto'] == '1') {
                                            $beanProducto->multilinea_c = $key['multilinea_c'] == true ? 1 : 0;
                                        }
                                        break;
                                    case 9:
                                        if ($key['producto'] == '8') {
                                            $beanProducto->multilinea_c = $key['multilinea_c'] == true ? 1 : 0;
                                        }
                                        break;
                                    case 2:
                                        if ($key['producto'] == '2') {
                                            $beanProducto->multilinea_c = $key['multilinea_c'] == true ? 1 : 0;
                                        }
                                        break;
                                    case 12:
                                        if ($key['producto'] == '12') {
                                            $beanProducto->multilinea_c = $key['multilinea_c'] == true ? 1 : 0;
                                        }
                                        break;
                                }
                                $beanProducto->save();
                            }
                        }
                    }
                }
            }
            
        } else {
            $uniProducto = $bean->no_viable;

            if (!empty($uniProducto)) {

                foreach ($uniProducto as $key) {
                    if ($key['id'] != '') {
                        $beanUP = BeanFactory::retrieveBean('uni_Productos', $key['id'], array('disable_row_level_security' => true));
                        $beanUP->no_viable = $key['no_viable'];
                        $beanUP->no_viable_razon = $key['no_viable_razon'];
                        $beanUP->no_viable_razon_fp = $key['no_viable_razon_fp'];
                        $beanUP->no_viable_quien = $key['no_viable_quien'];
                        $beanUP->no_viable_porque = $key['no_viable_porque'];
                        $beanUP->no_viable_producto = $key['no_viable_producto'];
                        $beanUP->no_viable_razon_cf = $key['no_viable_razon_cf'];
                        $beanUP->no_viable_razon_ni = $key['no_viable_razon_ni'];
                        $beanUP->no_viable_otro_c = $key['no_viable_otro_c'];
                        $beanUP->assigned_user_id = $key['assigned_user_id'];
                        $beanUP->canal_c = $key['canal_c'] != "" ? $key['canal_c'] : "";
                        $beanUP->multilinea_c = $key['multilinea_c'] != "" ? $key['multilinea_c'] : "";
                        $beanUP->save();
                    }

                    if (!$args['isUpdate'] && $key['producto'] == '8') {
                        if ($bean->load_relationship('accounts_uni_productos_1')) {
                            $listProductos = $bean->accounts_uni_productos_1->getBeans($bean->id, array('disable_row_level_security' => true));


                            foreach ($listProductos as $beanProducto) {
                                if ($beanProducto->tipo_producto == '8') {
                                    $beanProducto->canal_c = $key['canal_c'] != "" ? $key['canal_c'] : "0";
                                    $beanProducto->save();
                                }

                            }
                        }
                    }
                }

            }
        }
       
        if ($GLOBALS['service']->platform != 'mobile') {
            $uniProducto = $bean->account_uni_productos;

            if (!empty($uniProducto) && !$args['isUpdate'] && ( $actualizaLeasing ||  $actualizaFactoring || $actualizaCredAuto || $actualizaFleet || $actualizaUniclick )) {
                foreach ($uniProducto as $key) {
                    if ($key['id'] != '') {
                        $beanUP = BeanFactory::retrieveBean('uni_Productos', $key['id'], array('disable_row_level_security' => true));
                        if( $actualizaLeasing && $beanUP->tipo_producto == '1'){
                           
                        }
                        if($actualizaFactoring  && $beanUP->tipo_producto == '4'){
                            $actualizaFactoring = true;
                        }
                        if($actualizaCredAuto && $beanUP->tipo_producto == '3'){
                            $actualizaCredAuto = true;
                        }
                        if( $actualizaFleet && $beanUP->tipo_producto == '6'){
                            $actualizaFleet = true;
                        }
                        if($actualizaUniclick  && $beanUP->tipo_producto == '8'){
                            $actualizaUniclick = true;
                        }
                        $this->notificaDirector($beanUP);
                    }
                }
            }
        }
    }

    public function dataCondiciones(){
        $sql = "SELECT * FROM tct4_condiciones";
        $result = $GLOBALS['db']->query($sql);
       return $result;
    }

    function notificaDirector($beanUp)
    { 
        $condiciones = $this->dataCondiciones();
        //Obteniendo correo de director Leasing
        $dirId = [];
        if($beanUp->status_management_c == '4' || $beanUp->status_management_c == '5'){
            array_push($dirId, $beanUp->user_id1_c);
            array_push($dirId, $beanUp->user_id2_c);
            array_push($dirId, $beanUp->user_id_c);
            while($row = $GLOBALS['db']->fetchByAssoc($result) ){
                if($row['razon'] == $beanUp->razon_c && $row['motivo'] == $beanUp->motivo_c ){

                }
            }
        }
        if($beanUp->status_management_c == '1'){
            array_push($dirId, $beanUp->user_id_c);
        }
        
        //$GLOBALS['log']->fatal("Director de la solicitud con nombre: ".$nombreDirector. 'y correo :' .$correo_director);
        $cuerpoCorreo= $this->estableceCuerpoNotificacion($nombreDirector,$nombreCuenta,$linkSolicitud,$descripcion,$nombre_rm,$idRM,$Valor);

        $GLOBALS['log']->fatal("ENVIANDO NOTIFICACION A DIRECTOR DE SOLICITUD ".$correo_director);
        //Enviando correo a director de solicitud con copia  a director regional leasing
        $this->enviarNotificacionDirector("Solicitud por validar {$bean->name}",$cuerpoCorreo,$correos_director,$nombresDirector,$current_user->id, $idSolicitud);
        
        $GLOBALS['log']->fatal("Termina proceso de notificacion_director");
    }

    public function enviarNotificacionDirector($asunto,$cuerpoCorreo,$correosDirector,$nombresDirector, $userid,$recordid){
        //Enviando correo a asesor origen
        $GLOBALS['log']->fatal("ENVIA A :".$correoDirector.', '.$nombreDirector);
        $insert = '';
        $hoy = date("Y-m-d H:i:s");
        $cc ='';
       
        try{
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject($asunto);
            $body = trim($cuerpoCorreo);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            $mailer->addRecipientsTo(new EmailIdentity($correoDirector, $nombreDirector));
            if(count($recipients)>0){
                for($i=0;$i<count($recipients);$i++){
                    $mailer->addRecipientsCc(new EmailIdentity($recipients[$i]['correo'], $recipients[$i]['nombre']));
                    $cc = $cc.$recipients[$i]['correo'].',';
                }

            }

            /*Se agregan como copia oculta Correos de Wendy Reyes y Cristian Carral*/
            $mailer->addRecipientsBcc(new EmailIdentity('ccarral@unifin.com.mx', 'Cristian Carral'));
            $mailcco = 'ccarral@unifin.com.mx';

            //Añadiendo múltiples adjuntos
            $GLOBALS['log']->fatal("ADJUNTOS TIENE: ".count($adjuntos)." ELEMENTOS");
            if(count($adjuntos)>0){
                for($i=0;$i<count($adjuntos);$i++){
                    $mailer->addAttachment(new \Attachment($adjuntos[$i]));
                    $GLOBALS['log']->fatal("SE ADJUNTA ARCHIVO: ".$adjuntos[$i]);
                }
            }
            $result = $mailer->send();

            //$GLOBALS['log']->fatal('mailer',$mailer);

        } catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email ".$nombreDirector);
            $GLOBALS['log']->fatal("Exception ".$e);

            $insert = "INSERT INTO user_email_log (id, user_id , related_id ,date_entered, name_email, subject,type,related_type,status,error_code,description)
            VALUES (uuid() , '{$userid}' , '{$recordid}','{$hoy}','".$correoDirector."-".$cc."-".$mailcco."' , '{$asunto}','to', 'Solicitudes','ERROR','01', '{$e->getMessage()}')";
            //$GLOBALS['log']->fatal($insert);
            $GLOBALS['db']->query($insert);
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
            $insert = "INSERT INTO user_email_log (id, user_id , related_id ,date_entered, name_email, subject,type,related_type,status,error_code,description)
            VALUES (uuid() , '{$userid}' , '{$recordid}','{$hoy}' ,'".$correoDirector."-".$cc."-".$mailcco."', '{$asunto}','to', 'Solicitudes','ERROR','02', '{$message}')";
            //$GLOBALS['log']->fatal($insert);
            $GLOBALS['db']->query($insert);
        }

    }

    public function NotificacionRM($nombre_rm,$oppName,$linkSolicitud,$nombreDirector){
        
        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $nombre_rm . '</b>
      <br><br>Se le informa que ha sido validada su participación en la solicitud: ' .$oppName .', por el director: '.$nombreDirector.'
      <br><br>Para ver el detalle de la solicitud dé <a id="linkSolicitud" href="'. $linkSolicitud.'">clic aquí</a>
      <br><br>Atentamente Unifin
      <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
      <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
       Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
       Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
       No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
       Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';

        $GLOBALS['log']->fatal("Inicia NotificacionRM envio de mensaje a AsesoRM ".$mailHTML);
        return $mailHTML;

    }
}
