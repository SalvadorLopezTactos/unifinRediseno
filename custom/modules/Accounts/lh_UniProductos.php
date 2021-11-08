<?php

require_once 'include/SugarPHPMailer.php';
require_once 'modules/Administration/Administration.php';

class clase_UniProducto
{
    public function func_UniProducto($bean = null, $event = null, $args = null)
    {
        $GLOBALS['log']->fatal("---- ACTUALIZA UNI PRODUCTOS CUSTOM ---- ");
        //Campo custom Uni Productos
        $actualizaLeasing = false;
        $actualizaFactoring = false;
        $actualizaCredAuto = false;
        $actualizaFleet = false;
        $actualizaUniclick = false;

        // $GLOBALS['log']->fatal("bean->",$bean->account_uni_productos);

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

                        // $GLOBALS['log']->fatal("bean->".$beanUP->rechaza_noviable);
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
                        $beanUP->estatus_atencion = $key['estatus_atencion'];
                        $beanUP->razon_c = $key['razon_c'];
                        $beanUP->motivo_c = $key['motivo_c'];
                        $beanUP->detalle_c = $key['detalle_c'];

                        $beanUP->aprueba1_c = $key['aprueba1_c'];
                        $beanUP->aprueba2_c = $key['aprueba2_c'];

                        $beanUP->notificacion_noviable_c = $key['notificacion_noviable_c']; 
                        $beanUP->user_id1_c = $key['user_id1_c'];
                        $beanUP->user_id2_c = $key['user_id2_c'];
                        $beanUP->user_id_c = $key['user_id_c'];
                        
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
                        $beanUP->notificacion_noviable_c = $key['notificacion_noviable_c']; 
                        $beanUP->estatus_atencion = $key['estatus_atencion'];

                        /*
                        $beanUP->status_management_c = $key['status_management_c'];
                        $beanUP->razon_c = $key['razon_c'];
                        $beanUP->motivo_c = $key['motivo_c'];
                        $beanUP->detalle_c = $key['detalle_c'];
                        $beanUP->user_id1_c = $key['user_id1_c'];
                        $beanUP->user_id2_c = $key['user_id2_c'];
                        $beanUP->user_id_c = $key['user_id_c'];
                        $beanUP->notificacion_noviable_c = $key['notificacion_noviable_c'];
                        */
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
            //$GLOBALS['log']->fatal('objetisporductos' . !empty($uniProducto).' - leas:'.$actualizaLeasing.' - fact:'.$actualizaFactoring.' - cred:'.$actualizaCredAuto.' - fleet:'.$actualizaFleet.' - uniclick:'.$actualizaUniclick );
            if( $key['aprueba1_c'] != 'true' && $key['aprueba2_c'] != 'true'){
            if (!empty($uniProducto)  && ( $actualizaLeasing ||  $actualizaFactoring || $actualizaCredAuto || $actualizaFleet || $actualizaUniclick )) {
                //$GLOBALS['log']->fatal("actualiza-notificacion--");
                foreach ($uniProducto as $key) {
                    if ($key['id'] != '') {
                        $beanUP = BeanFactory::retrieveBean('uni_Productos', $key['id'], array('disable_row_level_security' => true));
                        //$GLOBALS['log']->fatal("---notifi". $beanUP->tipo_producto);
                        if( $actualizaLeasing && $beanUP->tipo_producto == '1'){
                            $this->notificaDirector($beanUP , $beanUP->tipo_producto, $bean->name , $bean->id);
                        }
                        if($actualizaFactoring  && $beanUP->tipo_producto == '4'){
                            $this->notificaDirector($beanUP , $beanUP->tipo_producto, $bean->name, $bean->id);
                        }
                        if($actualizaCredAuto && $beanUP->tipo_producto == '3'){
                            $this->notificaDirector($beanUP , $beanUP->tipo_producto, $bean->name, $bean->id);
                        }
                        if( $actualizaFleet && $beanUP->tipo_producto == '6'){
                            $this->notificaDirector($beanUP , $beanUP->tipo_producto, $bean->name, $bean->id);
                        }
                        if($actualizaUniclick  && $beanUP->tipo_producto == '8'){
                            $this->notificaDirector($beanUP , $beanUP->tipo_producto, $bean->name, $bean->id);
                        }
                    }
                }
            }
            }
        }
    }

    public function notificaDirector($beanUp , $tipo,$NameCuenta,$idCuenta)
    { 
        $sql = "SELECT * FROM tct4_condiciones";
        $condiciones = $GLOBALS['db']->query($sql);
        //Obteniendo correo de director Leasing
        $dirId = [];
        $correos=array();
        $nombres=array();
        //$GLOBALS['log']->fatal('statusmanagement:'.$beanUp->status_management_c);
        if($beanUp->status_management_c == '4' || $beanUp->status_management_c == '5'){

            $beanAc = BeanFactory::retrieveBean('Users', $beanUp->user_id_c , array('disable_row_level_security' => true));
            $ResponsableIngesta = $beanAc->name;

            array_push($dirId, "'".$beanUp->user_id2_c."'");
            array_push($dirId,"'".$beanUp->user_id1_c."'");

            $mailTo = [];
		    $query1 = "SELECT A.id,A.first_name,A.last_name,B.nombre_completo_c, E.email_address
            FROM users A
            INNER JOIN users_cstm B ON B.id_c = A.id
            INNER JOIN email_addr_bean_rel rel ON rel.bean_id = B.id_c
                AND rel.bean_module = 'Users'
                AND rel.deleted = 0 
            INNER JOIN email_addresses E  ON E.id = rel.email_address_id
              AND E.deleted=0
            WHERE A.id in (".implode(",",$dirId). ")
                AND  A.employee_status = 'Active' AND A.deleted = 0
                AND (A.status IS NULL OR A.status = 'Active')";

            $results1 = $GLOBALS['db']->query($query1);
        	//$GLOBALS['log']->fatal('results1',$results1);
        	while ($row = $GLOBALS['db']->fetchByAssoc($results1)) {
        		$correo = $row['email_address'];
        		$nombre = $row['nombre_completo_c'];
        		if ($correo != "") {
        			$mailTo ["$correo"] = $nombre; 
                    array_push($correos,$correo);
			        array_push($nombres,$nombre);
        		}
        	}
            $GLOBALS['log']->fatal('correos',$correos);
            $GLOBALS['log']->fatal('nombres',$nombres);

            global $app_list_strings;
            while($row = $GLOBALS['db']->fetchByAssoc($condiciones) ){
                if(($row['condicion'] == $beanUp->status_management_c) && $row['razon'] == $beanUp->razon_c && $row['motivo'] == $beanUp->motivo_c && $row['notifica'] == 1 ){
                    include_once('modules/Teams/Team.php');
			        $team = new Team();
			        $team->retrieve($app_list_strings['cartera_list']['Cartera']);
			        $team_members = $team->get_team_members(true);
                    //$GLOBALS['log']->fatal('team_members',$team_members);
			        foreach($team_members as $user) {
                        //$GLOBALS['log']->fatal('correos',$correos);
			        	array_push($correos,$user->email1);
			        	array_push($nombres,$user->nombre_completo_c);
			        }
                }
            }
            $GLOBALS['log']->fatal('correos',$correos);
            $GLOBALS['log']->fatal('nombres',$nombres);            
        }

        $urlSugar=$GLOBALS['sugar_config']['site_url'].'/#Accounts/';
        $linkCuenta=$urlSugar.$idCuenta;
        $razon =  $app_list_strings['razon_list'][$beanUp->razon_c];
        $detalle = $beanUp->detalle_c;
        
        //$GLOBALS['log']->fatal("Director de la solicitud con nombre: ".$nombreDirector. 'y correo :' .$correo_director);
        $cuerpoCorreo= $this->estableceCuerpoNotificacion($NameCuenta,$ResponsableIngesta,$razon,$detalle,$linkCuenta);
        $GLOBALS['log']->fatal("ENVIANDO NOTIFICACION no viable: ".$cuerpoCorreo);
        //$GLOBALS['log']->fatal("ENVIANDO NOTIFICACION no viable".$correo_director);
        //Enviando correo a director de solicitud con copia  a director regional leasing
        $this->enviarNotificacionDirector("Solicitud de bloqueo de cuenta por  {$ResponsableIngesta}",$cuerpoCorreo,$nombres,$correos);
        
        $GLOBALS['log']->fatal("Termina proceso de notificacion_director");
    }

    public function enviarNotificacionDirector($asunto,$cuerpoCorreo,$nombres,$correos){
        //Enviando correo a asesor origen
        //$GLOBALS['log']->fatal("ENVIA A :".$correoDirector.', '.$nombreDirector);
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
            //$mailer->addRecipientsTo(new EmailIdentity($correoDirector, $nombreDirector));
            if(count($correos)>0){
                for ($i=0; $i < count($correos); $i++) {
					$mailer->addRecipientsTo(new EmailIdentity($correos[$i], $nombres[$i]));
				}
            }

            $result = $mailer->send();

            //$GLOBALS['log']->fatal('mailer',$mailer);

        } catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email ");
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

    public function estableceCuerpoNotificacion($nombreCuenta,$ResponsableIngesta,$razon,$detalle,$linkCuenta){

        $mailHTML = '<br>Se le informa que la cuenta <a id="linkCuenta" href="'. $linkCuenta.'"> '  .$nombreCuenta.' </a> ha sido bloqueada por ' .$ResponsableIngesta.'.
      <br><br>La razón de bloqueo es: '.$razon .' y el detalle: '.$detalle .'.
      <br><br>Se requiere de su aprobación para bloquear definitivamente la cuenta.
      <br><br>Atentamente Unifin</font></p>
	<br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>		
	<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
	Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
	Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
	No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
	Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/aviso-de-privacidad.php" target="_blank" rel="noopener"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a></span><u></u><u></u></p>';
							
        return $mailHTML;
    }
}
