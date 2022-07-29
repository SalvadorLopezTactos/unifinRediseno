<?php

/**
 * User: salvador.lopez@tactos.com.mx
 */
class Ref_Cruzadas_Hooks
{
    public function enviaNotificaciones($bean = null, $event = null, $args = null)
    {
        $status = $bean->estatus;
        $producto_ref = $bean->producto_referenciado;

        $urlSugar = $GLOBALS['sugar_config']['site_url'] . '/#Ref_Venta_Cruzada/';
        $idReferencia = $bean->id;
        $linkReferencia = $urlSugar . $idReferencia;

        $idAsesorOrigen = $bean->assigned_user_id;
        // $GLOBALS['log']->fatal('idAsesorOrigen', $idAsesorOrigen);
        $nombreAsesorOrigen = $bean->assigned_user_name;

        $necesidad = $bean->description;
        $explicacionRechazo = $bean->explicacion_rechazo;
        $correo_asesor_origen = "";
        //Obteniendo correo de asesor Origen
        $beanAsesorOrigen = BeanFactory::retrieveBean('Users', $idAsesorOrigen);
        if (!empty($beanAsesorOrigen)) {
            $correo_asesor_origen = $beanAsesorOrigen->email1;
            $nombreAsesorOrigen = $beanAsesorOrigen->full_name;
        }
        // $GLOBALS['log']->fatal('idAsesorOrigen', $correo_asesor_origen);
        global $current_user;
        //$correo_current_user=$current_user->email1;
        $nombre_current_user=$current_user->full_name;
        $id_current_user = $current_user->id;
        //$GLOBALS['log']->fatal('correo_current_user',$id_current_user);
        //Validando que el Asesor referenciado no sea un 9-
        //correos_cancelacion_vta_cruzada_list
        $array_vta_cruzada_mail = $GLOBALS['app_list_strings']['correos_cancelacion_vta_cruzada_list'];
        //$GLOBALS['log']->fatal('correo_current_user',$array_vta_cruzada_mail);
        $idCarloS = $array_vta_cruzada_mail['1'];
        // $GLOBALS['log']->fatal('idCarloS ',$idCarloS);
        //$idCarloS='a951c644-c43b-11e9-9e17-00155d96730d';
        /*usuario_producto*/
        $idAsesorRef = $bean->user_id_c;
        // $GLOBALS['log']->fatal('idAsesorRef', $idAsesorRef);
        $nombreAsesorRef = $bean->usuario_producto;
        // $GLOBALS['log']->fatal('nombreAsesorRef', $nombreAsesorRef);
        $array = $GLOBALS['app_list_strings']['usuarios_ref_no_validos_list'];
        $asesor_9 = in_array($idAsesorRef, $array);
        $correo_asesor_ref = '';

        $mailU = [];
        $nombreU = [];

        if ($idAsesorRef != "" && $idAsesorRef != null) {
            if ($asesor_9) {
                //Como el usuario Referenciado es uno de los 9-*, se asigna a carlos esquivel
                $beanAsesorRF = BeanFactory::retrieveBean('Users', $idCarloS);
                if (!empty($beanAsesorRF)) {
                    $correo_asesor_ref = $beanAsesorRF->email1;
                    $nombreAsesorRef = $beanAsesorRF->full_name;
                }
            } else {

                $beanAsesorRF = BeanFactory::retrieveBean('Users', $idAsesorRef);
                if (!empty($beanAsesorRF)) {
                    $correo_asesor_ref = $beanAsesorRF->email1;
                    $nombreAsesorRef = $beanAsesorRF->full_name;
                }
            }
        }
        //$GLOBALS['log']->fatal('correo_asesor_ref', $correo_asesor_ref);
        //$GLOBALS['log']->fatal('nombreAsesorRef', $nombreAsesorRef);

        $idAsesorRM = $bean->user_id1_c;/*Validar que no sea null*/
        $nombreAsesorRM = $bean->usuario_rm;
        $correo_asesor_rm = "";
        if ($idAsesorRM != "" && $idAsesorRM != null) {
            $beanAsesorRM = BeanFactory::retrieveBean('Users', $idAsesorRM);
            if (!empty($beanAsesorRM)) {
                $correo_asesor_rm = $beanAsesorRM->email1;
                $nombreAsesorRM = $beanAsesorRM->full_name;
            }
        }

        $idCuenta = $bean->accounts_ref_venta_cruzada_1accounts_ida;
        $nombreCuenta = "";
        //Obteniendo nombre de Cuenta
        if ($idCuenta != "" && $idCuenta != null) {
            $beanCuenta = BeanFactory::retrieveBean('Accounts', $idCuenta);
            if (!empty($beanCuenta)) {
                $nombreCuenta = $beanCuenta->name;
            }
        }

        //Envío de correos para uniclick
        if ($producto_ref == '8' || $producto_ref == '9') {
            $query = "select id_c, valida_vta_cruzada_c , tct_cancelar_ref_cruzada_chk_c, deleted 
            from users_cstm inner join users on users.id = users_cstm.id_c
            where valida_vta_cruzada_c = 1 and deleted = 0";

            $results = $GLOBALS['db']->query($query);
            //$GLOBALS['log']->fatal('results_num',$results->num_rows);

            if ($results->num_rows > 0) {
                while ($row = $GLOBALS['db']->fetchByAssoc($results)) {
                    //Use $row['id'] to grab the id fields value
                    $id = $row['id_c'];
                    $mailTo = [];
                    $beanU = BeanFactory::retrieveBean('Users', $id);
                    if (!empty($beanU)) {
                        $id_user_uniclick = $beanU->id;
                        $correo_acpeta_uniclick = $beanU->email1;
                        $nombre_acepta_uniclick = $beanU->full_name;
                        //$GLOBALS['log']->fatal("--".$nombre_acepta_uniclick." -- ".$correo_acpeta_uniclick);
                        // Referencia uniclick avizo para aprobación
                        if ($status == '6') {
                            $GLOBALS['log']->fatal("ENVIANDO CORREO PARA APROBACION UNICLICK A ASESOR ORIGEN CON EMAIL " . $correo_acpeta_uniclick);
                            $cuerpoCorreo = $this->estableceCuerpoNotificacionUniclickAvizo($nombre_acepta_uniclick, $nombreCuenta, $necesidad, $linkReferencia);

                            //Enviando correo a asesor origen
                            $this->enviarNotificacionReferencia("Validación de referencia de venta cruzada Uniclick", $cuerpoCorreo, $correo_acpeta_uniclick, $nombre_acepta_uniclick);
                        }

                        //Referencia uniclick aviso de aprobado
                        if ($status == '1') {
                            
                            if ($id_current_user != $id_user_uniclick) { 
                                $GLOBALS['log']->fatal("ENVIANDO CORREO REFERENCIA VÁLIDA-APROBADA UNICLICK A ASESOR ORIGEN CON EMAIL " . $correo_acpeta_uniclick);
                                $cuerpoCorreo = $this->estableceCuerpoNotificacionUniclickRespondido($nombre_acepta_uniclick, $nombre_current_user, $nombreCuenta, $linkReferencia, 'Aceptada', '');

                                //Enviando correo a asesor origen
                                $this->enviarNotificacionReferencia("Nueva referencia de venta cruzada", $cuerpoCorreo, $correo_acpeta_uniclick, $nombre_acepta_uniclick);
                            }
                        }
                        //Referencia uniclick cancelada
                        if ($status == '3') {
                            if ($id_current_user != $id_user_uniclick) {
                                $GLOBALS['log']->fatal("ENVIANDO CORREO REFERENCIA VÁLIDA-CANCELADA UNICLICK A ASESOR ORIGEN CON EMAIL " . $correo_acpeta_uniclick);
                                $cuerpoCorreo = $this->estableceCuerpoNotificacionUniclickRespondido($nombre_acepta_uniclick, $nombre_current_user, $nombreCuenta, $linkReferencia, 'Rechazada', $explicacionRechazo);

                                //Enviando correo a asesor origen
                                $this->enviarNotificacionReferencia("Referencia rechazada", $cuerpoCorreo, $correo_acpeta_uniclick, $nombre_acepta_uniclick);
                            }
                        }
                    }
                }
            } else {
                //require_once 'include/api/SugarApiException.php';
                //throw new SugarApiExceptionInvalidParameter("No se tienen ");
                $GLOBALS['log']->fatal("No se tienen gerentes uniclick a quien enviar una notificación");
            }
        }

        if ($status == '1') {
            //Referenca válida
            //Envio de notificacion a asesor origen
            if ($correo_asesor_origen != "") {

                $cuerpoCorreo = $this->estableceCuerpoNotificacion($nombreAsesorOrigen, $nombreCuenta, $necesidad, $linkReferencia);

                $GLOBALS['log']->fatal("ENVIANDO CORREO (REFERENCIA VÁLIDA) A ASESOR ORIGEN CON EMAIL " . $correo_asesor_origen);

                //Enviando correo a asesor origen
                $this->enviarNotificacionReferencia("Nueva referencia de venta cruzada", $cuerpoCorreo, $correo_asesor_origen, $nombreAsesorOrigen);
            } else {
                $GLOBALS['log']->fatal("ASESOR ORIGEN " . $nombreAsesorOrigen . " NO TIENE EMAIL");
            }

            //Enviando correo a Asesor Producto Referenciado
            if ($correo_asesor_ref != "") {

                $cuerpoCorreo = $this->estableceCuerpoNotificacion($nombreAsesorRef, $nombreCuenta, $necesidad, $linkReferencia);

                $GLOBALS['log']->fatal("ENVIANDO CORREO (REFERENCIA VÁLIDA) A ASESOR PRODUCTO REFERENCIADO CON EMAIL " . $correo_asesor_ref);

                //Enviando correo a asesor origen
                $this->enviarNotificacionReferencia("Nueva referencia de venta cruzada", $cuerpoCorreo, $correo_asesor_ref, $nombreAsesorRef);
            } else {
                $GLOBALS['log']->fatal("ASESOR PRODUCTO REFERENCIADO " . $nombreAsesorRef . " NO TIENE EMAIL");
            }


            if ($correo_asesor_rm != "") {

                //Envio de notificacion a asesor RM
                $cuerpoCorreoRM = $this->estableceCuerpoNotificacion($nombreAsesorRM, $nombreCuenta, $necesidad, $linkReferencia);

                $GLOBALS['log']->fatal("ENVIANDO CORREO (REFERENCIA VÁLIDA) A ASESOR RM CON EMAIL " . $correo_asesor_origen);

                //Enviando correo a asesor origen
                $this->enviarNotificacionReferencia("Nueva referencia de venta cruzada", $cuerpoCorreoRM, $correo_asesor_rm, $nombreAsesorRM);
            } else {
                $GLOBALS['log']->fatal("ASESOR RM " . $nombreAsesorRM . " NO TIENE EMAIL");
            }
        }

        if ($status == '3') { //Referenca cancelada
            //Envio de notificacion a asesor origen
            if ($correo_asesor_origen != "") {

                $cuerpoCorreo = $this->estableceCuerpoNotificacionCancelada($nombreAsesorOrigen, $nombreCuenta, $explicacionRechazo, $linkReferencia);

                $GLOBALS['log']->fatal("ENVIANDO CORREO (REFERENCIA CANCELADA) A ASESOR ORIGEN CON EMAIL " . $correo_asesor_origen);

                //Enviando correo a asesor origen
                $this->enviarNotificacionReferencia("Referencia de venta cruzada cancelada", $cuerpoCorreo, $correo_asesor_origen, $nombreAsesorOrigen);
            } else {
                $GLOBALS['log']->fatal("ASESOR ORIGEN " . $nombreAsesorOrigen . " NO TIENE EMAIL");
            }

            if ($correo_asesor_rm != "") {

                //Envio de notificacion a asesor RM
                $cuerpoCorreoRM = $this->estableceCuerpoNotificacionCancelada($nombreAsesorRM, $nombreCuenta, $explicacionRechazo, $linkReferencia);

                $GLOBALS['log']->fatal("ENVIANDO CORREO (REFERENCIA CANCELADA) A ASESOR ORIGEN CON EMAIL " . $correo_asesor_origen);

                //Enviando correo a asesor origen
                $this->enviarNotificacionReferencia("Referencia de venta cruzada cancelada", $cuerpoCorreoRM, $correo_asesor_rm, $nombreAsesorRM);
            } else {
                $GLOBALS['log']->fatal("ASESOR RM " . $nombreAsesorRM . " NO TIENE EMAIL");
            }
        }
    }

    public function enviaNotificacionRefNoValida($bean = null, $event = null, $args = null){

        global $app_list_strings;
        global $db;
        
        $status = $bean->estatus;
        //Referencia No válida : 2
        //Producto Leasing : 1
        $id_usuario_ref=$app_list_strings['usuario_ref_no_valida_list'][0];
        $email_alejandro="";
        $nombreAlejandro="";

        $beanUsuarioAV = BeanFactory::retrieveBean('Users', $id_usuario_ref,array('disable_row_level_security' => true));
        if (!empty($beanUsuarioAV)) {
            $email_alejandro = $beanUsuarioAV->email1;
            $nombreAlejandro = $beanUsuarioAV->full_name;
        }
        //$email_alejandro="salvador.lopez@tactos.com.mx";
        //$nombreAlejandro="Alejandro de la Vega";
        $producto_referenciado=$bean->producto_referenciado;

        $urlSugar = $GLOBALS['sugar_config']['site_url'] . '/#Ref_Venta_Cruzada/';
        $idReferencia = $bean->id;
        $linkReferencia = $urlSugar . $idReferencia;

        $nombreAsesorOrigen = $bean->assigned_user_name;
        $nombreAsesorReferenciado = $bean->usuario_producto;

        $queryAsesorOrigen=<<<SQL
        SELECT CONCAT(first_name," ",last_name) as full_name FROM users WHERE id='{$bean->assigned_user_id}';
        SQL;
        $queryAsesorRef=<<<SQL
        SELECT CONCAT(first_name," ",last_name) as full_name FROM users WHERE id='{$bean->user_id_c}';
        SQL;

        $queryResultOrigen = $db->query($queryAsesorOrigen);
        while ($row = $db->fetchByAssoc($queryResultOrigen)) {
            $nombreAsesorOrigen=$row['full_name'];
        }

        $queryResultRef = $db->query($queryAsesorRef);
        while ($row = $db->fetchByAssoc($queryResultRef)) {
            $nombreAsesorReferenciado=$row['full_name'];
        }


        $GLOBALS['log']->fatal('ASESOR ORIGEN: '. $nombreAsesorOrigen);
        $GLOBALS['log']->fatal('ASESOR REFRENCIADO: '. $nombreAsesorReferenciado);

        $idCuenta = $bean->accounts_ref_venta_cruzada_1accounts_ida;
        $nombreCuenta = "";
        //Obteniendo nombre de Cuenta
        if ($idCuenta != "" && $idCuenta != null) {
            $beanCuenta = BeanFactory::retrieveBean('Accounts', $idCuenta,array('disable_row_level_security' => true));
            if (!empty($beanCuenta)) {
                $nombreCuenta = $beanCuenta->name;
            }
        }

        $array_cond_no_cumplidas=$this->estableceCondicionesNoCumplidas($bean);

        $GLOBALS['log']->fatal("CONDICIONES INCUMPLIDAS");
        $GLOBALS['log']->fatal(print_r($array_cond_no_cumplidas,true));

        //Si el producto referenciado es Leasing y además se establece como No Válida
        if($producto_referenciado=='1' && $status=='2' && $bean->correo_env_c != '1'){
            $cuerpoCorreo = $this->estableceCuerpoNotificacionNoValida($nombreAlejandro, $nombreAsesorOrigen, $nombreAsesorReferenciado,$nombreCuenta, $linkReferencia,$array_cond_no_cumplidas);

            $GLOBALS['log']->fatal("ENVIANDO CORREO (REFERENCIA NO VALIDA) A ALEJANDRO DE LA VEGA " . $email_alejandro);

            //Enviando correo a Alejandro de la Vega
            $this->enviarNotificacionReferencia("Intento de nueva referencia de venta cruzada", $cuerpoCorreo, $email_alejandro, $nombreAlejandro);

            //Se actualiza bandera para controlar que el correo solo se envie la primera vez
            $sqlUpdate="UPDATE ref_venta_cruzada_cstm SET correo_env_c = '1' WHERE id_c = '{$bean->id}'";
            $resultado = $GLOBALS['db']->query($sqlUpdate);

        }

    }

    public function estableceCondicionesNoCumplidas($bean){
        global $db;
        //Condiciones no cumplidas, por las cuales se establece como no válida
        $array_cond_no_cumplidas=array();
        $id_cuenta = '';

        //Condición 1 - Mismo equipo de asesores y mismo producto origen y referenciado
        $asesor_origen=$bean->assigned_user_id;
		$asesor_referenciado=$bean->user_id_c;

		$producto_origen=$bean->producto_origen;
		$producto_referenciado=$bean->producto_referenciado;

		if($producto_origen == $producto_referenciado){
			//Comprobando equipos de los asesores, se opta por query en lugar de bean, para evitar seguridad de equipos
			//y evitar doble consulta
			$query = "SELECT equipo_c FROM users_cstm WHERE id_c IN ('{$asesor_origen}','{$asesor_referenciado}')";
			$queryResult = $db->query($query);
			$array_equipos=array();
			while ($row = $db->fetchByAssoc($queryResult)) {
				array_push($array_equipos,$row['equipo_c']);
			}

			if(count($array_equipos)>0){
				$equipo_asesor1=$array_equipos[0];

                $equipo_asesor2="";
                //Se agrega condicion para controlar los equipos obtenidos en caso de que asesor origen y referenciado sean el mismo
                //en este caso, como solo trae un resultado, el $array_equipos[1] no trae valor, ya que la consulta solo trae un resultado en lugar de 2
                if(count($array_equipos)==1){
                    $equipo_asesor2=$array_equipos[0];
                }else{
                    $equipo_asesor2=$array_equipos[1];
                }

                $GLOBALS['log']->fatal("EQUIPO USUARIO 1: ".$equipo_asesor1);
                $GLOBALS['log']->fatal("EQUIPO USUARIO 2: ".$equipo_asesor2);

				if($equipo_asesor1==$equipo_asesor2){
                    array_push($array_cond_no_cumplidas,"Producto origen es igual a producto referenciado y tanto Asesor Origen como Asesor referenciado pertenecen al mismo equipo");
                }
            }
        }

        //Condición 2 - Producto relacionado a la cuenta
        if ($bean->load_relationship('accounts_ref_venta_cruzada_1')) {
            $relatedBeans = $bean->accounts_ref_venta_cruzada_1->getBeans();
        
            $parentBean = false;
            if (!empty($relatedBeans)) {
                //order the results
                reset($relatedBeans);
            
                //first record in the list is the parent
                $parentBean = current($relatedBeans);
                $auxrel = 'accounts_uni_productos_1';

                $id_cuenta = $parentBean->id;
                if($parentBean->load_relationship('accounts_uni_productos_1')){
                    $beans = $parentBean->accounts_uni_productos_1->getBeans();
                    if (!empty($beans)) {
                        foreach($beans as $prod){

                            //Producto desatendido estatus =2
                            if($bean->producto_referenciado == $prod->tipo_producto){
                                $array = $GLOBALS['app_list_strings']['usuarios_ref_no_validos_list'];

                                //usuario no este en 9, lista usuarios_no_ceder_list
                                //id no es null || vacio
                                //$GLOBALS['log']->fatal('producto no valido');
                                if($prod->estatus_atencion == '1' && !in_array($prod->assigned_user_id, $array)){
                                    array_push($array_cond_no_cumplidas,"El producto relacionado a la Cuenta se encuentra Atendido y el usuario asignado es alguno de los usuarios 9");
                                }
                            }
                        }
                    }
                }					
            }
        }

        //Condición 3 - Solicitudes relacionadas a la Cuenta
        if ($parentBean->load_relationship('opportunities')) {
            //Fetch related beans
            $relatedBeans = $parentBean->opportunities->getBeans();
            //$GLOBALS['log']->fatal('oportunidades');
            if (!empty($relatedBeans)) {
                $hoy = date("Y-m-d");  
                foreach($relatedBeans as $oppor){
                    //Producto desatendido estatus =2     //mismo producto							
                    if($bean->producto_referenciado == $oppor->tipo_producto_c){
                        $auxdate = date($oppor->vigencialinea_c);
                        if( $oppor->tct_opp_estatus_c=='1' && !($oppor->estatus_c =='K'||$oppor->estatus_c =='R'||$oppor->estatus_c =='CM')){
                            array_push($array_cond_no_cumplidas,'La solicitud relacionada a la Cuenta perteneciente al mismo producto referenciado se encuentra Activa y además la subetapa no se encuentra en alguno de los estados:<br>
                            <ul>
                                <li type="circle">Cancelada</li>
                                <li type="circle">Rechazada Crédito</li>
                                <li type="circle">Rechazada Comité</li>
                            </ul>');
                        } 
                    }
                }
            }
        }

        //Condición 4 - 
        $mesactual = date("n");
        $anioactual = date("Y");
        $query = 'SELECT bcl.id,bcl.anio, bcl.mes FROM accounts ac, lev_backlog bcl WHERE bcl.account_id_c = ac.id and ac.id = "'.$id_cuenta.'" and bcl.deleted=0';
		$results = $GLOBALS['db']->query($query);
		while($row = $GLOBALS['db']->fetchByAssoc($results) ){
            if($row['anio'] > $anioactual ){
                array_push($array_cond_no_cumplidas,"El backlog relacionado a la Cuenta es de un año posterior al actual");
            }else if($row['anio'] == $anioactual && $row['mes'] > $mesactual){
                array_push($array_cond_no_cumplidas,"El backlog relacionado a la Cuenta es de un año posterior al actual y de un mes mayor al actual");
			}
        }
        
        return array_unique($array_cond_no_cumplidas);

    }

    public function estableceCuerpoNotificacion($nombreAsesor, $nombreCuenta, $necesidadCliente, $linkReferencia)
    {


        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $nombreAsesor . '</b>
      <br><br>Se le informa que se ha generado una referencia de venta cruzada para la cuenta: ' . $nombreCuenta . '
      <br>La necesidad del cliente es: ' . $necesidadCliente . '
      <br><br>Para ver el detalle de la referencia <a id="downloadErrors" href="' . $linkReferencia . '">Da Click Aquí</a>
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

    public function estableceCuerpoNotificacionNoValida($nombreAlejandro,$nombreAsesorOrigen,$nombreAsesorReferenciado,$nombreCuenta,$linkReferencia,$condicionesIncumplidas)
    {
        $strLista="";
        if(count($condicionesIncumplidas)>0){
            for ($i=0; $i < count($condicionesIncumplidas); $i++) { 
                $strLista.='<li type="circle">'.$condicionesIncumplidas[$i].'</li>';
            }

        }


        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>Estimado ' . $nombreAlejandro . '</b>
      <br><br>Se le informa que se ha generado un intento de nueva referencia de venta cruzada: <a id="linkReferencia" href="' . $linkReferencia . '">Da Click Aquí</a>.
      <br>El asesor <b>' . $nombreAsesorOrigen . '</b> generó el intento para la nueva referencia dirigida hacia el cliente '.$nombreCuenta.' estableciendo como asesor que lo atenderá a <b>'.$nombreAsesorReferenciado.'</b>.
      <br><br>Las condiciones que no se cumplieron y por lo cual se establece como <b>No válida</b>, son las siguientes:
      <br><br>
      <ul>'.$strLista.'
      </ul>
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

    public function estableceCuerpoNotificacionCancelada($nombreAsesor, $nombreCuenta, $explicacionRechazo, $linkReferencia)
    {


        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $nombreAsesor . '</b>
      <br><br>Se le informa que se ha cancelado la referencia de venta cruzada para la cuenta:' . $nombreCuenta . '
      <br>El motivo de rechazo es: ' . $explicacionRechazo . '
      <br><br>Para ver el detalle de la referencia <a id="downloadErrors" href="' . $linkReferencia . '">Da Click Aquí</a>
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

    public function estableceCuerpoNotificacionUniclickAvizo($nombre, $nombreCuenta, $necesidadCliente, $linkReferencia)
    {
        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $nombre . '</b>
        <br>Se le informa que se ha generado una referencia de venta cruzada para la cuenta:' . $nombreCuenta . '
        <br>La necesidad del cliente es: ' . $necesidadCliente . '
        <br><br>Para ver el detalle de la referencia y autorizar o rechazar la solicitud dar <a id="downloadErrors" href="' . $linkReferencia . '">Click Aquí</a>
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

    public function estableceCuerpoNotificacionUniclickRespondido($nombre, $nombreCont , $nombreCuenta, $linkReferencia, $tipo, $explicacionRechazo)
    {
        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $nombre . '</b>
          <br>Se le informa que la referencia de venta cruzada fue  <b>' . $tipo . '</b> por '. $nombreCont .' para la cuenta:' . $nombreCuenta . ' ';

        if ($tipo == 'Rechazada') {
            $mailHTML = $mailHTML . '<br>El motivo de rechazo es: ' . $explicacionRechazo . ' ';
        }
        $mailHTML = $mailHTML . '
          <br><br>Para ver el detalle de la referencia dar <a id="downloadErrors" href="' . $linkReferencia . '">Click Aquí</a>
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

    public function enviarNotificacionReferencia($asunto, $cuerpoCorreo, $correoAsesor, $nombreAsesor)
    {
        global $app_list_strings;
        //Se obtiene información de Alejandro de la Vega a través de lista de valores
        $id_usuario_ref=$app_list_strings['usuario_ref_no_valida_list'][0];
        $email_alejandro="";
        $nombreAlejandro="";

        $beanUsuarioAV = BeanFactory::retrieveBean('Users', $id_usuario_ref,array('disable_row_level_security' => true));
        if (!empty($beanUsuarioAV)) {
            $email_alejandro = $beanUsuarioAV->email1;
            $nombreAlejandro = $beanUsuarioAV->full_name;
        }
        $GLOBALS['log']->fatal('CORREO CON COPIA A ALEJANDRO: '.$email_alejandro." NOMBRE: ".$nombreAlejandro);
        //Enviando correo a asesor origen
        try {
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject($asunto);
            $body = trim($cuerpoCorreo);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            $mailer->addRecipientsTo(new EmailIdentity($correoAsesor, $nombreAsesor));
            $mailer->addRecipientsCc(new EmailIdentity($email_alejandro, $nombreAlejandro));
            $result = $mailer->send();
        } catch (Exception $e) {
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email " . $correoAsesor);
            $GLOBALS['log']->fatal("Exception " . $e);
        }
    }

}