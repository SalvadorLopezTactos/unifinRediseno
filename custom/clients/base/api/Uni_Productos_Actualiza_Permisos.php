<?php
/**
 * User: tactos
 * Date: 22/06/21
 */


class Uni_Productos_Actualiza_Permisos extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'retrieve' => array(
                //request type
                'reqType' => 'POST',
                //set authentication
                'noLoginRequired' => false,
                //endpoint path
                'path' => array('actualizaProductosPermisos'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'actualiza_Productos',
                //short help string to be displayed in the help documentation
                'shortHelp' => ' Actualiza información de productos desde cualquier usuario ',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            )

        );
    }

    public function actualiza_Productos($api, $args)
    {
        $GLOBALS['log']->fatal("tipoupdate " .$args['tipoupdate']);
        $cont_cambios = 0;

        if( $args['tipoupdate'] == "1" ){
            $id_Account = $args['id_Account'];
            
            $GLOBALS['log']->fatal("id_Account " . $id_Account);
            $return_productos = "";
            
            $beanAccount = BeanFactory::retrieveBean('Accounts', $id_Account, array('disable_row_level_security' => true));
            
            $query = "SELECT PRODUCTOS.*, concat(uassign.first_name,' ',uassign.last_name) as full_name
            ,concat(u1.first_name,' ',u1.last_name) as fullname_ingesta_c
            ,concat(u2.first_name,' ',u2.last_name) as fullname_validacion1_c
            ,concat(u3.first_name,' ',u3.last_name) as fullname_validacion2_c
            FROM (SELECT
                case
                    when up.tipo_producto = 1 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.subtipo_cuenta = 1) then 1
                    when up.tipo_producto = 3 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.subtipo_cuenta = 1) then 1
                    when up.tipo_producto = 4 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.subtipo_cuenta = 1) then 1
                    when up.tipo_producto = 6 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.subtipo_cuenta = 1) then 1
                    when up.tipo_producto = 8 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.subtipo_cuenta = 1) then 1
                    else 0
                end 'visible_noviable', up.*, upc.*
                FROM accounts a
                inner join accounts_uni_productos_1_c ap on a.id = ap.accounts_uni_productos_1accounts_ida
                inner join uni_productos up on up.id = ap.accounts_uni_productos_1uni_productos_idb
                inner join uni_productos_cstm upc on upc.id_c = up.id
                and a.id = '{$id_Account}' and up.deleted = 0
             ) AS PRODUCTOS
                INNER JOIN users AS uassign ON PRODUCTOS.assigned_user_id = uassign.id
                LEFT JOIN users AS u1 ON PRODUCTOS.user_id_c = u1.id
                LEFT JOIN users AS u2 ON PRODUCTOS.user_id1_c = u2.id
                LEFT JOIN users AS u3 ON PRODUCTOS.user_id2_c = u3.id 
                ";

            $result = $GLOBALS['db']->query($query);
            $cont_cambios = 0;
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                //$records_in[] = $row; 
                $beanProduct = BeanFactory::retrieveBean('uni_Productos', $row['id'], array('disable_row_level_security' => true));
                $GLOBALS['log']->fatal("Id producto" . $row['id']);
                if (!empty($beanProduct) && $beanProduct != null) {
                    try {
                        $GLOBALS['log']->fatal("beanProduct tipo " . $beanProduct->tipo_producto);
                        $GLOBALS['log']->fatal("user id " . $args['user_id']);
                        /*$GLOBALS['log']->fatal("validador1 " . $beanProduct->user_id1_c);
                        $GLOBALS['log']->fatal("validador2 " . $beanProduct->user_id2_c);
                        $GLOBALS['log']->fatal("status_management_c " .  $beanProduct->status_management_c);
                        $GLOBALS['log']->fatal("aprueba1_c " .  $beanProduct->aprueba1_c);
                        $GLOBALS['log']->fatal("aprueba2_c " .  $beanProduct->aprueba2_c);
                        $GLOBALS['log']->fatal("tipoupdate " .   $args['tipoupdate']);
                        */
                        if((($beanProduct->user_id1_c == $args['user_id'] && !$beanProduct->aprueba1_c) || ($beanProduct->user_id2_c == $args['user_id'] && !$beanProduct->aprueba2_c))
                        && ($beanProduct->status_management_c == '4' || $beanProduct->status_management_c == '5')) {
                        
                            $GLOBALS['log']->fatal("Entro modificacion*********");
                            $return_productos = "";
                        
                            $beanProduct->razon_c = $args['razon_c']; //razon lm
                            $beanProduct->motivo_c = $args['motivo_c']; //motivo lm
                            $beanProduct->detalle_c = $args['detalle_c']; //detalle lm
                            $beanProduct->user_id1_c =  $args['user_id1_c'];  //user id1
                            $beanProduct->user_id2_c =  $args['user_id2_c'];  //user id2
                            $beanProduct->user_id_c = $args['user_id_c'];  //user id
                            $beanProduct->status_management_c = $args['status_management_c']; //status lm
                            $beanProduct->notificacion_noviable_c = $args['notificacion_noviable_c']; //notificaion noviable
                        
                            $cont_cambios++;
                            $beanProduct->save();
                        }
                    } catch (Exception $ex) {
                        $GLOBALS['log']->fatal("Exception " . $ex);
                    }
                }
            }
        }
        
        if($args['tipoupdate']=="2"){

            $id_Producto = $args['id_Producto'];
            $beanProduct = BeanFactory::retrieveBean('uni_Productos', $id_Producto, array('disable_row_level_security' => true));
            $GLOBALS['log']->fatal("Id producto" . $id_Producto);
            if (!empty($beanProduct) && $beanProduct != null) {
                try {                        
                    
                    $beanProduct->aprueba1_c = $args['aprueba1_c']; //
                    $beanProduct->aprueba2_c = $args['aprueba2_c']; //
                    
                    $beanProduct->save();
                    
                } catch (Exception $ex) {
                    $GLOBALS['log']->fatal("Exception " . $ex);
                }
            }
        }

        if( $args['tipoupdate'] == "3" ){
            $id_Account = $args['id_Account'];
            
            $GLOBALS['log']->fatal("id_Account " . $id_Account);
            $return_productos = "";
            
            $beanAccount = BeanFactory::retrieveBean('Accounts', $id_Account, array('disable_row_level_security' => true));
            
            $query = "SELECT PRODUCTOS.*, concat(uassign.first_name,' ',uassign.last_name) as full_name
            ,concat(u1.first_name,' ',u1.last_name) as fullname_ingesta_c
            ,concat(u2.first_name,' ',u2.last_name) as fullname_validacion1_c
            ,concat(u3.first_name,' ',u3.last_name) as fullname_validacion2_c
            FROM (SELECT
                case
                    when up.tipo_producto = 1 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.subtipo_cuenta = 1) then 1
                    when up.tipo_producto = 3 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.subtipo_cuenta = 1) then 1
                    when up.tipo_producto = 4 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.subtipo_cuenta = 1) then 1
                    when up.tipo_producto = 6 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.subtipo_cuenta = 1) then 1
                    when up.tipo_producto = 8 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.subtipo_cuenta = 1) then 1
                    else 0
                end 'visible_noviable', up.*, upc.*
                FROM accounts a
                inner join accounts_uni_productos_1_c ap on a.id = ap.accounts_uni_productos_1accounts_ida
                inner join uni_productos up on up.id = ap.accounts_uni_productos_1uni_productos_idb
                inner join uni_productos_cstm upc on upc.id_c = up.id
                and a.id = '{$id_Account}' and up.deleted = 0
             ) AS PRODUCTOS
                INNER JOIN users AS uassign ON PRODUCTOS.assigned_user_id = uassign.id
                LEFT JOIN users AS u1 ON PRODUCTOS.user_id_c = u1.id
                LEFT JOIN users AS u2 ON PRODUCTOS.user_id1_c = u2.id
                LEFT JOIN users AS u3 ON PRODUCTOS.user_id2_c = u3.id 
                ";

            $result = $GLOBALS['db']->query($query);
            $cont_cambios = 0;
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                //$records_in[] = $row; 
                $beanProduct = BeanFactory::retrieveBean('uni_Productos', $row['id'], array('disable_row_level_security' => true));
                $GLOBALS['log']->fatal("Id producto" . $row['id']);
                if (!empty($beanProduct) && $beanProduct != null) {
                    try {
                       $beanProduct->aprueba1_c = 0; //status lm
                       $beanProduct->aprueba2_c = 0; //notificaion noviable

                       $beanProduct->save();
                       $cont_cambios++;
                       $this->notificaDirector($beanProduct , $beanProduct->tipo_producto, $beanAccount->name , $beanAccount->id);
                    } catch (Exception $ex) {
                        $GLOBALS['log']->fatal("Exception " . $ex);
                    }
                }
            }
            
        }

        return $cont_cambios;
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
        $this->enviarNotificacionDirector("Solicitud de reapertura para la cuenta {$nombreCuenta} solicitada por {$ResponsableIngesta}",$cuerpoCorreo,$nombres,$correos);
        
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

        $mailHTML = '<br>Se le informa que el usuario <b>' .$ResponsableIngesta. '</b> ha solicitado la reactivación para la cuenta <a id="linkCuenta" href="'. $linkCuenta.'"> '  .$nombreCuenta.' </a>. 
      <br><br>Atentamente Unifin
      <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
      <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
       Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
       Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
       No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
       Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';

        return $mailHTML;
    }

}