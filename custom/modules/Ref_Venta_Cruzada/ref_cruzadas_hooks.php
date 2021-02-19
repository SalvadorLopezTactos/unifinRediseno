<?php
/**
 * User: salvador.lopez@tactos.com.mx
 */
class Ref_Cruzadas_Hooks
{
    public function enviaNotificaciones($bean = null, $event = null, $args = null)
    {
        $status=$bean->estatus;
        $producto_ref = $bean->producto_referenciado;

        $urlSugar=$GLOBALS['sugar_config']['site_url'].'/#Ref_Venta_Cruzada/';
        $idReferencia=$bean->id;
        $linkReferencia=$urlSugar.$idReferencia;

        $idAsesorOrigen=$bean->assigned_user_id;
        $nombreAsesorOrigen=$bean->assigned_user_name;

        $necesidad=$bean->description;
        $explicacionRechazo=$bean->explicacion_rechazo;
        $correo_asesor_origen="";
        //Obteniendo correo de asesor Origen
        $beanAsesorOrigen = BeanFactory::retrieveBean('Users', $idAsesorOrigen);
        if(!empty($beanAsesorOrigen)){
            $correo_asesor_origen=$beanAsesorOrigen->email1;
            $nombreAsesorOrigen=$beanAsesorOrigen->full_name;
        }

        global $current_user;
        //$correo_current_user=$current_user->email1;
        //$nombre_current_user=$current_user->full_name;
        $id_current_user=$current_user->id;
        //$GLOBALS['log']->fatal('correo_current_user',$id_current_user);
        //Validando que el Asesor referenciado no sea un 9-
        //correos_cancelacion_vta_cruzada_list
        $array_vta_cruzada_mail = $GLOBALS['app_list_strings']['correos_cancelacion_vta_cruzada_list'];
        $GLOBALS['log']->fatal('correo_current_user',$array_vta_cruzada_mail);
        //$idCarloS='a951c644-c43b-11e9-9e17-00155d96730d';
        /*usuario_producto*/
        $idAsesorRef=$bean->user_id_c;
        $nombreAsesorRef=$bean->usuario_producto;
        $array = $GLOBALS['app_list_strings']['usuarios_ref_no_validos_list'];
        $asesor_9=in_array($idAsesorRef, $array);
        $correo_asesor_ref='';

        $mailU = [];
        $nombreU = [];

        if($idAsesorRef != "" && $idAsesorRef !=null){
            if($asesor_9){
                //Como el usuario Referenciado es uno de los 9-*, se asigna a carlos esquivel
                $beanAsesorRF = BeanFactory::retrieveBean('Users', $idCarloS);
                if(!empty($beanAsesorRF)){
                    $correo_asesor_ref=$beanAsesorRF->email1;
                    $nombreAsesorRef=$beanAsesorRF->full_name;
                }
            }else{

                $beanAsesorRF = BeanFactory::retrieveBean('Users', $idAsesorRef);
                if(!empty($beanAsesorRF)){
                    $correo_asesor_ref=$beanAsesorRF->email1;
                    $nombreAsesorRef=$beanAsesorRF->full_name;
                }

            }

        }

        $idAsesorRM=$bean->user_id1_c;/*Validar que no sea null*/
        $nombreAsesorRM=$bean->usuario_rm;
        $correo_asesor_rm="";
        if($idAsesorRM != "" && $idAsesorRM !=null){
            $beanAsesorRM = BeanFactory::retrieveBean('Users', $idAsesorRM);
            if(!empty($beanAsesorRM)){
                $correo_asesor_rm=$beanAsesorRM->email1;
                $nombreAsesorRM=$beanAsesorRM->full_name;
            }
        }

        $idCuenta=$bean->accounts_ref_venta_cruzada_1accounts_ida;
        $nombreCuenta="";
        //Obteniendo nombre de Cuenta
        if($idCuenta != "" && $idCuenta !=null){
            $beanCuenta = BeanFactory::retrieveBean('Accounts', $idCuenta);
            if(!empty($beanCuenta)){
                $nombreCuenta=$beanCuenta->name;
            }
        }

        //Envío de correos para uniclick
        if( $producto_ref == '8' || $producto_ref =='9' ){
            $query = "select id_c, valida_vta_cruzada_c , tct_cancelar_ref_cruzada_chk_c, deleted 
            from users_cstm inner join users on users.id = users_cstm.id_c
            where valida_vta_cruzada_c = 1 and deleted = 0";
			
            $results = $GLOBALS['db']->query($query);
			//$GLOBALS['log']->fatal('results_num',$results->num_rows);
			
			if($results->num_rows > 0){
                while($row = $GLOBALS['db']->fetchByAssoc($results) )
                {
                    //Use $row['id'] to grab the id fields value
                    $id = $row['id_c'];
                    $mailTo = [];
                    $beanU = BeanFactory::retrieveBean('Users', $id);
                    if(!empty($beanU)){
                        $id_user_uniclick = $beanU->id;
                        $correo_acpeta_uniclick=$beanU->email1;
                        $nombre_acepta_uniclick=$beanU->full_name;     
                        
                        // Referencia uniclick avizo para aprobación
                        if($status == '6'){
                            $GLOBALS['log']->fatal("ENVIANDO CORREO PARA APROBACION UNICLICK A ASESOR ORIGEN CON EMAIL ".$correo_acpeta_uniclick);
                            $cuerpoCorreo= $this->estableceCuerpoNotificacionUniclickAvizo($nombre_acepta_uniclick,$nombreCuenta,$necesidad,$linkReferencia);

                            //Enviando correo a asesor origen
                            $this->enviarNotificacionReferencia("Validación de referencia de venta cruzada Uniclick",$cuerpoCorreo,$correo_acpeta_uniclick,$nombre_acepta_uniclick);
                        }

                        //Referencia uniclick aviso de aprobado
                        if($status =='1'){  
                            if($id_current_user != $id_user_uniclick){
                                $GLOBALS['log']->fatal("ENVIANDO CORREO REFERENCIA VÁLIDA-APROBADA UNICLICK A ASESOR ORIGEN CON EMAIL ".$correo_acpeta_uniclick);
                                $cuerpoCorreo= $this->estableceCuerpoNotificacionUniclickRespondido($nombre_acepta_uniclick,$nombreCuenta,$linkReferencia,'Aceptada');
                            
                                //Enviando correo a asesor origen
                                $this->enviarNotificacionReferencia("Validación de referencia de venta cruzada Uniclick",$cuerpoCorreo,$correo_acpeta_uniclick,$nombre_acepta_uniclick);
                            }          
                            
                        }
                        //Referencia uniclick cancelada
                        if($status =='3'){
                            if($id_current_user != $id_user_uniclick){
                                $GLOBALS['log']->fatal("ENVIANDO CORREO REFERENCIA VÁLIDA-cancelada UNICLICK A ASESOR ORIGEN CON EMAIL ".$correo_acpeta_uniclick);
                                $cuerpoCorreo= $this->estableceCuerpoNotificacionUniclickRespondido($nombre_acepta_uniclick,$nombreCuenta,$linkReferencia,'Rechazada');

                                //Enviando correo a asesor origen
                                $this->enviarNotificacionReferencia("Nueva referencia válida",$cuerpoCorreo,$correo_asesor_origen,$nombreAsesorOrigen);
                            }                            
                        }
                    }
                }
           
			}else{
                //require_once 'include/api/SugarApiException.php';
			 	//throw new SugarApiExceptionInvalidParameter("No se tienen ");
                $GLOBALS['log']->fatal("No se tienen gerentes uniclick a quien enviar una notificación");
            }
        }

        if($status=='1'){//Referenca válida
            //Envio de notificacion a asesor origen
            if($correo_asesor_origen!=""){

                $cuerpoCorreo= $this->estableceCuerpoNotificacion($nombreAsesorOrigen,$nombreCuenta,$necesidad,$linkReferencia);

                $GLOBALS['log']->fatal("ENVIANDO CORREO (REFERENCIA VÁLIDA) A ASESOR ORIGEN CON EMAIL ".$correo_asesor_origen);

                //Enviando correo a asesor origen
                $this->enviarNotificacionReferencia("Nueva referencia válida",$cuerpoCorreo,$correo_asesor_origen,$nombreAsesorOrigen);

            }else{
                $GLOBALS['log']->fatal("ASESOR ORIGEN ".$nombreAsesorOrigen." NO TIENE EMAIL");
            }

            //Enviando correo a Asesor Producto Referenciado
            if($correo_asesor_ref!=""){

                $cuerpoCorreo= $this->estableceCuerpoNotificacion($nombreAsesorRef,$nombreCuenta,$necesidad,$linkReferencia);

                $GLOBALS['log']->fatal("ENVIANDO CORREO (REFERENCIA VÁLIDA) A ASESOR PRODUCTO REFERENCIADO CON EMAIL ".$correo_asesor_ref);

                //Enviando correo a asesor origen
                $this->enviarNotificacionReferencia("Nueva referencia válida",$cuerpoCorreo,$correo_asesor_ref,$nombreAsesorRef);

            }else{
                $GLOBALS['log']->fatal("ASESOR PRODUCTO REFERENCIADO ".$nombreAsesorRef." NO TIENE EMAIL");
            }


            if($correo_asesor_rm!=""){

                //Envio de notificacion a asesor RM
                $cuerpoCorreoRM= $this->estableceCuerpoNotificacion($nombreAsesorRM,$nombreCuenta,$necesidad,$linkReferencia);

                $GLOBALS['log']->fatal("ENVIANDO CORREO (REFERENCIA VÁLIDA) A ASESOR RM CON EMAIL ".$correo_asesor_origen);

                //Enviando correo a asesor origen
                $this->enviarNotificacionReferencia("Nueva referencia válida",$cuerpoCorreoRM,$correo_asesor_rm,$nombreAsesorRM);

            }else{
                $GLOBALS['log']->fatal("ASESOR RM ".$nombreAsesorRM." NO TIENE EMAIL");
            }

        }

        if($status=='3'){//Referenca cancelada
            //Envio de notificacion a asesor origen
            if($correo_asesor_origen!=""){

                $cuerpoCorreo= $this->estableceCuerpoNotificacionCancelada($nombreAsesorOrigen,$nombreCuenta,$explicacionRechazo,$linkReferencia);

                $GLOBALS['log']->fatal("ENVIANDO CORREO (REFERENCIA CANCELADA) A ASESOR ORIGEN CON EMAIL ".$correo_asesor_origen);

                //Enviando correo a asesor origen
                $this->enviarNotificacionReferencia("Referencia cancelada",$cuerpoCorreo,$correo_asesor_origen,$nombreAsesorOrigen);

            }else{
                $GLOBALS['log']->fatal("ASESOR ORIGEN ".$nombreAsesorOrigen." NO TIENE EMAIL");
            }

            if($correo_asesor_rm!=""){

                //Envio de notificacion a asesor RM
                $cuerpoCorreoRM= $this->estableceCuerpoNotificacionCancelada($nombreAsesorRM,$nombreCuenta,$explicacionRechazo,$linkReferencia);

                $GLOBALS['log']->fatal("ENVIANDO CORREO (REFERENCIA CANCELADA) A ASESOR ORIGEN CON EMAIL ".$correo_asesor_origen);

                //Enviando correo a asesor origen
                $this->enviarNotificacionReferencia("Referencia cancelada",$cuerpoCorreoRM,$correo_asesor_rm,$nombreAsesorRM);

            }else{
                $GLOBALS['log']->fatal("ASESOR RM ".$nombreAsesorRM." NO TIENE EMAIL");
            }

        }


    }

    public function estableceCuerpoNotificacion($nombreAsesor,$nombreCuenta,$necesidadCliente,$linkReferencia){


        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $nombreAsesor . '</b>
      <br><br>Se le informa que se ha generado una referencia de venta cruzada para la cuenta: '. $nombreCuenta.'
      <br>La necesidad del cliente es: '. $necesidadCliente.'
      <br><br>Para ver el detalle de la referencia <a id="downloadErrors" href="'. $linkReferencia.'">Da Click Aquí</a>
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

    public function estableceCuerpoNotificacionCancelada($nombreAsesor,$nombreCuenta,$explicacionRechazo,$linkReferencia){


        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $nombreAsesor . '</b>
      <br><br>Se le informa que se ha cancelado la referencia de venta cruzada para la cuenta:'. $nombreCuenta.'
      <br>El motivo de rechazo es: '. $explicacionRechazo.'
      <br><br>Para ver el detalle de la referencia <a id="downloadErrors" href="'. $linkReferencia.'">Da Click Aquí</a>
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

    public function estableceCuerpoNotificacionUniclickAvizo($nombre,$nombreCuenta,$necesidadCliente,$linkReferencia){
      $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $nombre . '</b>
      <br>Se le informa que se ha generado una referencia de venta cruzada para la cuenta:'. $nombreCuenta.'
      <br>La necesidad del cliente es: '. $necesidadCliente.'
      <br><br>Para ver el detalle de la referencia y autorizar o rechazar la solicitud dé <a id="downloadErrors" href="'. $linkReferencia.'">Da Click Aquí</a>
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

    public function estableceCuerpoNotificacionUniclickRespondido($nombre,$nombreCuenta,$linkReferencia,$tipo){
        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $nombre . '</b>
        <br>Se le informa que la referencia de venta cruzada fue respondida <b>'. $tipo .'</b> para la cuenta:'. $nombreCuenta.'
        <br><br>Para ver el detalle de la referencia y autorizar o rechazar la solicitud dé <a id="downloadErrors" href="'. $linkReferencia.'">Da Click Aquí</a>
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

    public function enviarNotificacionReferencia($asunto,$cuerpoCorreo,$correoAsesor,$nombreAsesor){
        //Enviando correo a asesor origen
        try{
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject($asunto);
            $body = trim($cuerpoCorreo);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            $mailer->addRecipientsTo(new EmailIdentity($correoAsesor, $nombreAsesor));
            $result = $mailer->send();

        }catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email ".$correoAsesor);
            $GLOBALS['log']->fatal("Exception ".$e);
        }


    }

}