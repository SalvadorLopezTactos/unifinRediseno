<?php

class Seguros_LH{

    public function send_notification_ganada($bean = null, $event = null, $args = null){

        global $app_list_strings;

        $etapa = $bean->etapa;
        $emails_seguros_list = $app_list_strings['emails_seguros_list'];
        $send_email = false;
        $id_dynamics = $bean->int_id_dynamics_c;
        $text_cambios = '';
        if( $bean->fetched_row['etapa'] == $bean->etapa && $etapa == 9 ){
            $text_cambios .= '<ul>';
            if( $bean->fetched_row['tipo_sf_c'] !== $bean->tipo_sf_c ){
                $send_email = true;
                $text_cambios .= '<li><b>Tipo</b>, contenía el valor <b>'. $app_list_strings['tipo_sf_list'][$bean->fetched_row['tipo_sf_c']] .'</b> y se actualizó por <b>'.$app_list_strings['tipo_sf_list'][$bean->tipo_sf_c].'</b></li>';
            }
            
            if( $bean->fetched_row['tipo_referenciador'] !== $bean->tipo_referenciador ){
                $send_email = true;
                $text_cambios .= '<li><b>Tipo Referenciador</b>, contenía el valor <b>'.$app_list_strings['tipo_referenciador_list'][$bean->fetched_row['tipo_referenciador']] .'</b> y se actualizó por <b>'.$app_list_strings['tipo_referenciador_list'][$bean->tipo_referenciador].'</b></li>';
            }
            // user_id1_c - Asesor, user_id2_c - empleado
            $id_user_anterior = '';
            $id_user_actual = '';
            if( $bean->tipo_referenciador == '1' ){ //Asesor
                $id_user_anterior = $bean->fetched_row['user_id1_c'];
                $id_user_actual = $bean->user_id1_c;
            }
            if( $bean->tipo_referenciador == '2' ){ //Empleado
                $id_user_anterior = $bean->fetched_row['user_id2_c'];
                $id_user_actual = $bean->user_id2_c;
            }

            if( !empty($id_user_anterior) && !empty($id_user_actual) ){ //Condición entra solo cuando las variables contienen  valor
                if( $id_user_anterior !== $id_user_actual  ){
                    $send_email = true;
                    $nombre_anterior = $this->getNameReferenciador( $id_user_anterior );
                    $nombre_actual = $this->getNameReferenciador( $id_user_actual );
                    $text_cambios .= '<li><b>Referenciador</b>, contenía el valor <b>'. $nombre_anterior .'</b> y se actualizó por <b>'.$nombre_actual.'</b></li>';
                }
            }
            

            if( $bean->fetched_row['comision_c'] !== number_format((float)$bean->comision_c, 2, '.', '') ){
                $send_email = true;
                $comision_round= number_format((float)$bean->comision_c, 2, '.', '');
                $text_cambios .= '<li><b>Comisión</b>, contenía el valor <b>'. $bean->fetched_row['comision_c'] .'</b> y se actualizó por <b>'.$comision_round.'</b></li>';
            }
            $text_cambios .= '</ul>';

        }
        
        if( $send_email ){
            $body_correo = $this->buildBodyEmail( $id_dynamics, $text_cambios);
            $this->sendEmailNotification( $emails_seguros_list, $body_correo );
        }
        
    }

    public function getNameReferenciador( $idUsuario ){

        $beanUser = BeanFactory::getBean('Users', $idUsuario);

        return $beanUser->full_name;

    } 

    public function buildBodyEmail($id_dynamics,$text_cambios){

        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>Equipo Inter,</b><br>
            La oportunidad <b>'.$id_dynamics.'</b> ha sido actualizada desde el CRM de Unifin.<br>
            <br>Pedimos su apoyo con la actualización en el CRM de Inter de los siguientes cambios:<br>'.
            $text_cambios.'<br>
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

    public function sendEmailNotification($emails_address,$body_correo){

        try{
            global $app_list_strings;
            //$email_copia = 'irma.rodriguez@unifin.com.mx';
            $email_copia = $app_list_strings['email_cc_seguros_list']['1'];
            $name_email_copia = 'Irma Rodriguez';
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject('UNIFIN - Actualización Oportunidad de Seguros');
            $body = trim($body_correo);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            for ($i=0; $i < count($emails_address); $i++) {
                $GLOBALS['log']->fatal("AGREGANDO CORREOS DESTINATARIOS: ".$emails_address[$i]);
                $mailer->addRecipientsTo(new EmailIdentity($emails_address[$i], $emails_address[$i]));
            }
            $mailer->addRecipientsCc(new EmailIdentity($email_copia, $name_email_copia));
            $result = $mailer->send();

        } catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email ");
            $GLOBALS['log']->fatal(print_r($e,true));

        }

    }

    public function elimina_relacion_asociada_set_cierre_bl( $bean, $event, $arguments ){

        //Elimina relación "Activa" con Backlog en caso de que la oportunidad se establezca como Ganada o No Ganada
        if($bean->fetched_row['etapa'] != $bean->etapa && ($bean->etapa == "9" || $bean->etapa == "10")){
            // $GLOBALS['log']->fatal("ELIMINA RELACION ACTIVA YA QUE LA OPORTUNIDAD SE ESTABLECIÓ COMO GANADA O NO GANADA");

            // if ($bean->load_relationship('tctbl_backlog_seguros_s_seguros_1')) {

            //     $bean->tctbl_backlog_seguros_s_seguros_1->delete($bean->tctbl_backlog_seguros_s_segurostctbl_backlog_seguros_ida);

            // }

            //Establece fecha de cierre
            $GLOBALS['log']->fatal("OPORTUNIDAD DE SEGURO ". $bean->etapa. " SE ESTABLECE FECHA DE CIERRE");
            $bean->cierre_bl_c = $bean->fecha_cierre_c;
            
        }

    }

    public function update_etapa_backlog($bean, $event, $arguments){


        $GLOBALS['log']->fatal('arguments del after_save');
        $GLOBALS['log']->fatal(print_r($arguments['dataChanges'], true));

        if($arguments['dataChanges']['etapa'] || $arguments['dataChanges']['tctbl_backlog_seguros_s_segurostctbl_backlog_seguros_ida'] ){

            $GLOBALS['log']->fatal("ENTRA LH, LA ETAPA CAMBIÓ, RECALCULA ETAPA PARA ESTABLCER AL BACKLOG");

            $id_bl = $bean->tctbl_backlog_seguros_s_segurostctbl_backlog_seguros_ida;
            $bean_bl = BeanFactory::getBean('TCTBL_Backlog_Seguros', $id_bl, array('disable_row_level_security' => true));

            if( $bean_bl->load_relationship('tctbl_backlog_seguros_s_seguros') ){

                $relatedSeguros = $bean_bl->tctbl_backlog_seguros_s_seguros->getBeans();

                $GLOBALS['log']->fatal("TIENE ". count($relatedSeguros). " Oportunidades activas" );
                $array_etapas = array();
                foreach ($relatedSeguros as $oppSeguro) {
                    
                    array_push($array_etapas, (int)$oppSeguro->etapa);

                }

                //Obtener la etapa de menor jerarquía de las oportunidades relacionadas y establecer en el backlog relacionado
                if( count($array_etapas) > 0 ){
                    $min_etapa = min($array_etapas);

                    $bean_bl->etapa = $min_etapa;
                    $bean_bl->save();
                    $GLOBALS['log']->fatal("GUARDA LA NUEVA ETAPA DEL BACKLOG");

                }

            }

        }

    }
        

    public function valida_mes_anio_bl( $bean, $event, $arguments ){
        //$GLOBALS['log']->fatal("BEFORE RELATIONSHIP ADD SEGUROS");
        //$GLOBALS['log']->fatal( print_r($arguments,true) );
        $related_module = $arguments['related_module'];
        $name_rel = $arguments['relationship'];
        
        if( $related_module == "TCTBL_Backlog_Seguros" && $name_rel == "tctbl_backlog_seguros_s_seguros" ){

            $bl_id = $arguments['related_id'];

            $bean_bl = BeanFactory::getBean('TCTBL_Backlog_Seguros', $bl_id, array('disable_row_level_security' => true));

            $mes_bl = $bean_bl->mes;
            $anio_bl = $bean_bl->anio;

            $GLOBALS['log']->fatal( "MES BL: ".$mes_bl );
            $GLOBALS['log']->fatal( "ANIO BL: " . $anio_bl);

            $mes_actual = date("n");
            $anio_actual = date("Y");

            $GLOBALS['log']->fatal("MES ACTUAL: " . $mes_actual);
            $GLOBALS['log']->fatal("ANIO ACTUAL: " . $anio_actual);

            if ($anio_bl < $anio_actual || ($anio_bl == $anio_actual && $mes_bl < $mes_actual)) {

                throw new SugarApiExceptionInvalidParameter("El backlog que intentas agregar cuenta con mes y año menor a la fecha actual");
            }

        }
        
    }

    public function genera_relacion_activa( $bean, $event, $arguments ){

        //UNa vez que se establece la relación con oportunidades de seguro asociadas, se establece una nueva relación con oportunidades de seguro activas
        $GLOBALS['log']->fatal("BEFORE RELATIONSHIP ADD SEGUROS");
        $GLOBALS['log']->fatal(print_r($arguments, true));
        $related_module = $arguments['related_module'];
        $name_rel = $arguments['relationship'];

        if ($related_module == "TCTBL_Backlog_Seguros" && $name_rel == "tctbl_backlog_seguros_s_seguros") {
            $GLOBALS['log']->fatal("ENTRA CONDIDICION PARA GENERAR RELACION ACTIVA");
            $bl_id = $arguments['related_id'];
            //Genera Bean de Oportunidad de seguro Activa
            $bean->load_relationship('tctbl_backlog_seguros_s_seguros_1');
            $bean->tctbl_backlog_seguros_s_seguros_1->add( $bl_id );
            //$bean->save();

        }

    }

    public function elimina_relacion_activa($bean, $event, $arguments)
    {
        $GLOBALS['log']->fatal("before_relationship_delete");
        $GLOBALS['log']->fatal(print_r($arguments, true));
        $related_module = $arguments['related_module'];
        $name_rel = $arguments['relationship'];
        $id_bl = $arguments['related_id'];

         //Elimina relación "Activa" en caso de que el backlog cambie
        if ($related_module == "TCTBL_Backlog_Seguros" && $name_rel == "tctbl_backlog_seguros_s_seguros") {
            $GLOBALS['log']->fatal("ELIMINA RELACION ACTIVA YA QUE EL BACKLOG CAMBIÓ");

            if ($bean->load_relationship('tctbl_backlog_seguros_s_seguros_1')) {

                $bean->tctbl_backlog_seguros_s_seguros_1->delete($id_bl);
            }
        }
        
        
    }

}