<?php
/**
 * Created by CVV
 * User: carmen.velasco@unifin.com.mx
 * Date: 19/10/2016
 * Modified: AF. 2019/05/06
 */

require_once('modules/Emails/Email.php');
require_once('custom/clients/base/api/EncuestaMinuta.php');


class Meetings_Hooks
{
  /*
   * Agregar Invitados
   * Función que genera nuevas reuniones para usuarios invitados
   * */
  function RelationAdd($bean = null, $event = null, $args = null)
  {
    /*
    * Crea nueva reunión:
    * Genera copia de reunión original sólo si se cumplen las siguientes condiciones
    * 1.- Nueva relación meetings_users
    * 2.- Usuario agregado es diferente al usuario asignado
    * 3.- Tiene cuenta asociada
    * 4.- No es reunión de repetición
    */
	/*********************
	Se agrega la validación para accounts y leads
	***********************************/
    //&& empty($bean->repeat_parent_id)
    if ($args['relationship'] == 'meetings_users' && $bean->assigned_user_id != $args['related_id'] && !empty($bean->parent_id) && ($bean->parent_type == 'Accounts' || $bean->parent_type == 'Leads') )
    {
      $GLOBALS['log']->fatal('TCT - RelationAdd - :' .$args['related_module']);
      //Genera petición para crear reunión
      $idUsuario = $args['related_id'];
      $this->reunionInvitado($bean, $idUsuario);
    }

    //Actualiza reunión si ya tiene minuta
    if($args['related_module'] == 'minut_Minutas' && $args['link'] == 'minut_minutas_meetings'){
      $GLOBALS['log']->fatal("TCT - Cumple condición 2 y actualiza reunión Held");
      //$GLOBALS['log']->fatal(print_r($args,true));
      //Actualiza estado a Planeado
      global $db;
      $bean->status='Held';
      //$bean->minut_minutas_meetingsminut_minutas_ida=$args['related_id'];
      $meetUpdate="update meetings m
                    set m.status='Held'
                    where m.id='{$bean->id}'
      ";
      $updateResult=$db->query($meetUpdate);
    }

    //Genera reuniones para usuarios cuando la cuenta se agrega
    if($args['relationship'] == 'account_meetings' && $args['module'] == 'Meetings' && empty($bean->parent_meeting_c) && ($args['related_module'] == 'Accounts' || $args['related_module'] == 'Leads') )
    {
      //consulta usuarios asociados a reunión
      global $db;
      $query = "select user_id
                from meetings_users
                where
                	 meeting_id ='{$bean->id}'
                	 and user_id!='{$bean->assigned_user_id}'
                	 and deleted=0
      ";
      $queryResult = $db->query($query);

      //Itera registros recuperados
      while ($row = $db->fetchByAssoc($queryResult)) {
        //Genera petición para crear reunión
        $idUsuario = $row['user_id'];
        $this->reunionInvitado($bean, $idUsuario);
      }
    }
  }

  /*
   * Guargar y actualizar objetivos de reunión
   * Función que guarda y actualiza objetivos específicos relacionados a la reunión
   * */
  function saveObjetivos ($bean = null, $event = null, $args = null)
  {
        if($bean->reunion_objetivos != null || !empty($bean->reunion_objetivos)){
            //$GLOBALS['log']->fatal('TCT - saveObjetivos -');
            //Obtener objetivos relacionados a la reunión actual
            if ($bean->load_relationship('meetings_minut_objetivos_1')) {
                //Fetch related beans
                $relatedBeans = $bean->meetings_minut_objetivos_1->getBeans();
            }

            $lengthRelated=count($relatedBeans);
            $lengthObj=count($bean->reunion_objetivos['records']);
            //Arreglo para mantener identificadores de objetivos del campo reunion_objetivos
            $arr_ids_field_objetivos=array();
            //Arreglo para mantener identificadores de objetivos relacionados a la reunión (subpanel)
            $arr_ids_rel_objetivos=array();
            //Arreglo para mentener los identificadores de los objetivos que serán removidos
            $objetivos_a_borrar=array();

            foreach ($bean->reunion_objetivos['records'] as $record){
                if(isset($record['id'])) {
                    array_push($arr_ids_field_objetivos, $record['id']);
                }
            }


            if ($lengthRelated>0){

                foreach ($relatedBeans as $rel){
                    array_push($arr_ids_rel_objetivos,$rel->id);
                }

                //Los arreglos serán comparados únicamente cuando las longitudes sean diferentes
                //Es decir, los objetivos del campo custom no tiene la misma longitud,
                // ya que aún no están sincronizados los objetivos del campo custom con los objetivos del subpanel
                if($lengthRelated != $lengthObj){

                    for($i=0;$i<count($arr_ids_rel_objetivos);$i++){

                        if(!in_array($arr_ids_rel_objetivos[$i], $arr_ids_field_objetivos)){
                            array_push($objetivos_a_borrar,$arr_ids_rel_objetivos[$i]);

                        }

                    }
                }

                if(count($objetivos_a_borrar)>0){

                    //Recorrer arreglo que mantiene identificadores que se eliminarán
                    for($j=0;$j<count($objetivos_a_borrar);$j++){

                        //Recuperar bean de objetivos
                        $beanObjetivo = BeanFactory::retrieveBean('minut_Objetivos', $objetivos_a_borrar[$j]);

                        //Se establece como borrado
                        $beanObjetivo->mark_deleted($objetivos_a_borrar[$j]);

                        $beanObjetivo->save();

                    }

                }

            }


            foreach ($bean->reunion_objetivos['records'] as $objetivo) {
                if (isset($objetivo['id'])) {
                    //Actualiza
                    //$GLOBALS['log']->fatal('Actualiza Objetivos');
                    //$GLOBALS['log']->fatal($objetivo['name']);
                    $beanObjetivo = BeanFactory::retrieveBean('minut_Objetivos', $objetivo['id']);
                    if($beanObjetivo!=null){
                        $beanObjetivo->name = $objetivo['name'];
                        $beanObjetivo->description = $objetivo['description'];
                        $beanObjetivo->deleted = $objetivo['deleted'];
                        $beanObjetivo->save();
                    }
                }else{
                    //Crea
                    //$GLOBALS['log']->fatal('Inserta Objetivos');
                    //$GLOBALS['log']->fatal($objetivo['name']);
                    $beanObjetivo = BeanFactory::newBean('minut_Objetivos');
                    $beanObjetivo->name = $objetivo['name'];
                    $beanObjetivo->meetings_minut_objetivos_1meetings_ida = $bean->id;
                    $beanObjetivo->description = $objetivo['description'];
                    $beanObjetivo->save();
                }
            }
        }

        //Restablece check-in/out time en creación
        if ($GLOBALS['service']->platform!= 'opi') {
          if (!$args['isUpdate']) {
            global $db;
            $update = " update meetings_cstm set check_in_time_c = null, check_out_time_c = null where id_c='{$bean->id}'";
  			    $execute = $db->query($update);
            //$GLOBALS['log']->fatal('Actualiza check_in_time_c & check_out_time_c');
          }
        }
  }

  /*
   * Actualiza estado de reunión
   * Función que valida estado de la reunión y actualiza de ser necesario
   * */
  function modificaReunion ($bean= null, $event=null, $args=null)
  {
      global $current_user;
      $producto_usuario=$current_user->tipodeproducto_c;
    //Agrega funcionalidad para actualizar estado = Planned
      //Solo usuarios Uniclick son capaces de cambiar el status a "Realizada" desde la app móvil
    if ($GLOBALS['service']->platform!= 'base' && $bean->parent_type=='Accounts' && !empty($bean->parent_id) && empty($bean->minut_minutas_meetingsminut_minutas_ida) && $bean->status=='Held' && $producto_usuario!='8')
    {
      global $db, $current_user;
      $GLOBALS['log']->fatal("TCT - Cumple condición y actualiza: Planned ");
      //Actualiza estado a Planeado
      $bean->status='Planned';
      $meetUpdate="update meetings m
                    set m.status='Planned'
                    where m.id='{$bean->id}'
      ";
      $updateResult=$db->query($meetUpdate);
    }
    if ($bean->parent_type=='Accounts' && !empty($bean->parent_id) && !empty($bean->minut_minutas_meetingsminut_minutas_ida) && $bean->status=='Planned')
    {
      global $db, $current_user;
      $GLOBALS['log']->fatal("TCT - Cumple condición y actualiza: Held ");
      //Actualiza estado a Realizado
      $bean->status='Held';
      $meetUpdate="update meetings m
                    set m.status='Held'
                    where m.id='{$bean->id}'
      ";
      $updateResult=$db->query($meetUpdate);
    }
  }

  /*
   * Función para tabla de auditoría de Meetings
   * Función que inserta valores a tabla de meetings_audit (creada directa desde la BD) para poder trackear los cambios realizados al campo de status
   * */
  function insertAuditFields ($bean, $event, $args)
  {
    //Valida cambio de estado
    if ($bean->fetched_row['status'] != 'Planned' && !empty($bean->fetched_row['status']) && $bean->fetched_row['status'] != "") {
      $bean->status = $bean->fetched_row['status'];
    }


    //Ingresa registro en auditoria
    //$GLOBALS['log']->fatal('TCT - insertAuditFields -');
    global $current_user;
    $date= TimeDate::getInstance()->nowDb();
    if($args['isUpdate']){
      $arr_fetched=array();
      //Llenando arreglo auxiliar de campos que pueden actualizarse
      foreach ($bean as $key => $value){
        foreach ($bean->fetched_row as $clave => $valor){
          if($key == $clave){
            array_push($arr_fetched,$clave);
          }
        }
      }

      foreach ($arr_fetched as $val){
        if($bean->fetched_row[$val] != $bean->{$val} && $val != "date_modified"){
          $id_m_audit=create_guid();
          $tipo=$this->getFieldType($bean,$val);
          $plataforma=$GLOBALS['service']->platform;
          $sqlInsert="insert into meetings_audit (id, parent_id, date_created, created_by, field_name, data_type, before_value_string, after_value_string, before_value_text, after_value_text, event_id, date_updated)
                  VALUES ('{$id_m_audit}', '{$bean->id}', '{$date}', '{$current_user->id}', '{$val}', '{$tipo}', '{$bean->fetched_row[$val]}', '{$bean->{$val}}', '', '{$plataforma}', '1', '{$date}')";
          $GLOBALS['db']->query($sqlInsert);
        }
      }

    }
  }

    function insertAuditUnlink ($bean, $event, $args)
    {
        global $current_user;
        $date= TimeDate::getInstance()->nowDb();
        $id_m_audit=create_guid();

        $plataforma=$GLOBALS['service']->platform;
        $sqlInsert="insert into meetings_audit (id, parent_id, date_created, created_by, field_name, data_type, before_value_string, after_value_string, before_value_text, after_value_text, event_id, date_updated)
                  VALUES ('{$id_m_audit}', '{$bean->id}', '{$date}', '{$current_user->id}', 'parent_id', 'id', '{$args['related_id']}', '', '', '{$plataforma}', '1', '{$date}')";
        $GLOBALS['db']->query($sqlInsert);

    }

  /*
   * Regresa el tipo de dato de un campo
   * @param $bean Object, objeto con la definición completa de la entidad de Meetings
   * @param $field string, cadena con el nombre del campo del que se quiere obtener el tipo de dato
   * return string, tipo de dato de un campo
   * */
  function getFieldType($bean,$field)
  {
    return $bean->field_defs[$field]['type'];
  }

  /*
   * Genera copias y elimina relación
   * Función con proceso para creación de reuniones y depuración de relación
   * */
  function reunionInvitado($bean, $idUsuario)
  {
    global $db, $current_user, $app_list_strings;
    //Valida que no exista reunión asociada al usuario
    $query = "select count(m.id) as total
              from meetings m, meetings_cstm mc
              where
                m.id=mc.id_c
                 and	mc.parent_meeting_c ='{$bean->id}'
                 and m.assigned_user_id='{$idUsuario}'
                 and deleted=0
    ";
    $queryResult = $db->getOne($query);
    //Valida que el usuario no sea del centro de prospección
    //Agente telefónico-27, Ejecutivo estrategia comercial-19
    $flag=false;
    $beanUser=BeanFactory::getBean('Users', $idUsuario);
    $puesto = $beanUser->puestousuario_c;
    $lista = $app_list_strings['prospeccion_c_list'];
    $listatext=array();
    foreach ($lista as $key => $newList){
      $listatext[]=$key;
      if($key == $puesto){
        $flag=true;
      }
    }
    if($puesto == 27 && strstr($bean->productos_c,'8')) $flag=false;
    //Evaluación de resultado para crear reunión
    if($queryResult==0 && !$flag) {
      $GLOBALS['log']->fatal('TCT - RelationAdd - Agrega nueva reunión para usuario: ' . $idUsuario);
      //Genera copia de reunión
      $reunionInvitado = BeanFactory::newBean('Meetings');
      //Campos excluidos por copiar
      $exclude = array
      (
        'id',
        'date_entered',
        'date_modified',
        'assigned_user_id',
        'parent_meeting_c',
        'description',
        'status',
        'resultado_c',
        'check_in_address_c',
        'check_in_latitude_c',
        'check_in_longitude_c',
        'check_in_time_c',
        'check_out_address_c',
        'check_out_latitude_c',
        'check_out_longitude_c',
        'check_out_time_c',
        'check_in_platform_c',
        'check_out_platform_c',
        'productos_c'
      );
      //Iteración de campos por copiar
      foreach($bean->field_defs as $def)
      {
        if(!(isset($def['source']) && $def['source'] == 'non-db') && !empty($def['name']) && !in_array($def['name'], $exclude))
        {
          $field = $def['name'];
          $reunionInvitado->{$field} = $bean->{$field};
        }
      }

      //Agrega valores y guarda reunión
	    $reunionInvitado->parent_meeting_c = $bean->id;
	    $reunionInvitado->created_by = $current_user->id;
      $reunionInvitado->modified_user_id = $current_user->id;
      $reunionInvitado->assigned_user_id = $idUsuario;
      $reunionInvitado->description = $bean->description." - Cita registrada automaticamente por CRM ya que ha sido asignado como invitado.";
      $reunionInvitado->reunion_objetivos = $bean->reunion_objetivos;
      $reunionInvitado->status = 'Planned';
      $reunionInvitado->save();

  	  /******************
  	  En caso de Lead se agrego la relación adicional por el tipo de relación mucho a muchos
  	  ****************/
  		if ($reunionInvitado->parent_type == 'Leads'){
  			$reunionInvitado->load_relationship('leads');
  			$reunionInvitado->leads->add($reunionInvitado->parent_id);
  		}

      //Agrega objetivos
      if($bean->load_relationship('meetings_minut_objetivos_1')) {
        $relatedBeans = $bean->meetings_minut_objetivos_1->getBeans();
        foreach($relatedBeans as $rel){
          $beanObjetivo = BeanFactory::newBean('minut_Objetivos');
          $beanObjetivo->name = $rel->name;
          $beanObjetivo->description = $rel->description;
          $beanObjetivo->meetings_minut_objetivos_1meetings_ida = $reunionInvitado->id;
          $beanObjetivo->save();
            $reunionInvitado->load_relationship('meetings_minut_objetivos_1');
            $reunionInvitado->meetings_minut_objetivos_1->add($beanObjetivo->id);
        }
      }
    }

    //Elimina usuario de reunión original
    $update = "update meetings_users SET deleted = 1
                where meeting_id = '{$bean->id}'
                and user_id = '{$idUsuario}'
    ";
    $updateResult = $db->query($update);

/*    $beanUser = BeanFactory::getBean('Users', $bean->assigned_user_id);
    if ($beanUser->puestousuario_c!='27') {
    $GLOBALS['log']->fatal("Actualiza valor campo Producto--");
    $actualizaproductos = "update meetings_cstm
                        inner join
                        (select
                        parent_meeting_c id,
                          group_concat( distinct productos_c) productos
                        from meetings_cstm
                        where productos_c is not null
                        and parent_meeting_c='{$bean->id}'
                        group by parent_meeting_c
                        ) parentM on parentM.id = meetings_cstm.id_c
                        set meetings_cstm.productos_c = parentM.productos
                        where parentM.productos !=''
                        ;";
    $updateResult = $db->query($actualizaproductos);
    $GLOBALS['log']->fatal("actualizaproductos".$actualizaproductos);
    }*/
  }

  /*
   * Función para enviar correo de encuesta: CITA NO REALIZADA
   * Criterios:
   *  1.- Creado != Asignado && Se tiene cuenta asociada
   *  2.- Reunión creada por algún usario de centro de prospección; Puesto: 27, 31 o id=eeae5860-bb05-4ae5-3579-56ddd8a85c31
   *  3a.- Reunión.Estado = No realizada
   *    ó
   *  3b.- Reunión.Resultado = "El cliente no estuvo presente, cita cancelada" ó "No se pudo contactar al Prospecto para confirmar cita"
   * */
  function surveyNotHeld ($bean, $event, $args)
  {
      //Criterio 1
      if ($bean->created_by != $bean->assigned_user_id && !empty($bean->parent_id) && $bean->parent_type == 'Accounts') {
          //Recupera bean Useario creado
          $beanUser = BeanFactory::getBean('Users', $bean->created_by);
          //Criterio 2
          if ($beanUser->puestousuario_c == '27' || $beanUser->puestousuario_c == '31' || $beanUser->id == 'eeae5860-bb05-4ae5-3579-56ddd8a85c31'){
              //Criterio 3a
              if ($bean->fetched_row['status'] == 'Planned' && $bean->status == 'Not Held'){
                //Envía encuesta
                Meetings_Hooks::sendEmailSurvey($bean);
              //Criterio 3b
            } elseif ($bean->fetched_row['status'] == 'Planned' && $bean->status !=  'Planned' && ($bean->resultado_c == '22' || $bean->resultado_c == '24' || $bean->resultado_c == '25') ) {
                //Envía encuesta
                Meetings_Hooks::sendEmailSurvey($bean);
              }
          }
      }
  }

  /*
   * Función para ejecutar envío de correo electrónico: Encuesta: Cita no realizada
  */
  function sendEmailSurvey($beanReunion)
  {
      //Genrea url - string b64
      $args = [];
      $args['data']=[];
      $args['data']['idMeeting'] = $beanReunion->id;
      $args['data']['idUser'] = $beanReunion->assigned_user_id;
      $args['data']['email'] = true;
      $args['data']['nameUser']= $beanReunion->assigned_user_name;
      //Recupera site_url
      global $sugar_config;
      $sugarHost = $sugar_config['site_url'] . '/survey_submission.php?q=';
      //Obtiene stringBase64
      $encuestaMinuta = new EncuestaMinuta();
      $stringBase64 = $encuestaMinuta->createSurveySubmission('',$args);
      //Genera url de encuesta
      $urlSurvey = $sugarHost . $stringBase64;
      // $GLOBALS["log"]->fatal($sugarHost);
      // $GLOBALS["log"]->fatal($stringBase64);
      // $GLOBALS["log"]->fatal($urlSurvey);
      //Establece parámetros de envío
      $timedate = new TimeDate();
      $datetime = $timedate->to_display_date_time($beanReunion->date_start);
      $beanUser = BeanFactory::getBean('Users', $beanReunion->assigned_user_id);
      $mailSubject = "DÉJANOS SABER POR QUE NO SE REALIZÓ LA CITA-CONFERENCIA";
      $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">HOLA! <b>'. $beanUser->first_name . ' ' . $beanUser->last_name .'</b>
      <br><br>Sabemos que la cita-conferencia que tenías programada con la empresa '. $beanReunion->parent_name .' el día '. $datetime .' no se llevó a cabo.
      <br><br>Para nosotros es muy importante escucharte, es por eso que te invitamos a contestar esta encuesta para entender cuales fueron los motivos.
      <br><br>RECUERDA QUE ESTA ENCUESTA SOLO PERMANECERÁ ACTIVA HASTA MAÑANA AL MEDIO DÍA.</font></p>
      <center><a href="'. $urlSurvey .'">Comenzar la encuesta</a><center>';
      $mailTo = array(
          0 => array(
              'name' => $beanUser->first_name . ' ' . $beanUser->last_name ,
              'email' => $beanUser->email1,
          )
      );

      //Prepara ejecución de correo
      try {
          $mailer = MailerFactory::getSystemDefaultMailer();
          $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
          $mailer->setSubject($mailSubject);
          $body = trim($mailHTML);
          $mailer->setHtmlBody($body);
          $mailer->clearRecipients();
          $mailer->addRecipientsTo(new EmailIdentity($beanUser->email1, $beanUser->first_name . ' ' . $beanUser->last_name));

          //Ejecuta
          $result = $mailer->send();
          if ($result) {
              //$GLOBALS["log"]->fatal("surveyNotHeld :: Se envío correctamente: " . $urlSurvey);
          } else {
              $GLOBALS["log"]->fatal("surveyNotHeld :: El correo no pudo realizarse de forma correcta");

          }
      } catch (MailerException $me) {
          $message = $me->getMessage();
          switch ($me->getCode()) {
              case \MailerException::FailedToConnectToRemoteServer:
                  $GLOBALS["log"]->fatal("surveyNotHeld :: error sending email, system smtp server is not set");
                  break;
              default:
                  $GLOBALS["log"]->fatal("surveyNotHeld :: error sending e-mail (method: {$mailTransmissionProtocol}), (error: {$message})");
                  break;
          }
      }
  }

  function guardaproductos ($bean, $event, $args){
        //Función para guardar el tipo de producto Principal de los invitados a la Reunión (padre)
        global $db;
        $beanUser = BeanFactory::getBean('Users', $bean->assigned_user_id);
        $bean->productos_c = '^'.$beanUser->tipodeproducto_c.'^';
//      if ($beanUser->puestousuario_c!='27'){
//        if(!strstr($bean->productos_c,$beanUser->tipodeproducto_c)) $bean->productos_c = $bean->productos_c.',^'.$beanUser->tipodeproducto_c.'^';
            if ($bean->parent_meeting_c) {
                $beanparentmeeting = BeanFactory::getBean('Meetings', $bean->parent_meeting_c);
//                $beanUserPadre=  BeanFactory:: getBean('Meetings', $beanparentmeeting->assigned_user_id);
//                if ($beanUserPadre->puestousuario_c!='27'){
                    $Update="update meetings_cstm set productos_c = '{$bean->productos_c}' where id_c = '{$bean->id}'";
                    $Result=$db->query($Update);
                    $saveproductos=array();
                    $valorinicial=$beanparentmeeting->productos_c;
                    //$GLOBALS['log']->fatal("Valor Inicial: '.$valorinicial.'");
                    if ($valorinicial==""){
                        $beanparentmeeting->productos_c=$bean->productos_c;
                        $valorinicial=$beanparentmeeting->productos_c;
                    }else{
                        $beanparentmeeting->productos_c = $beanparentmeeting->productos_c .','.$bean->productos_c;
                    }
                    $saveproductos=explode(",", $beanparentmeeting->productos_c);
                    $valoresunicos=array_unique($saveproductos);
                    $valorupdate=implode(",",$valoresunicos);
//                    $GLOBALS['log']->fatal("Setea valor con implode a productos_c de la cuenta Padre");
                    $beanparentmeeting->productos_c = empty($valorupdate) ? $valorinicial : $valorupdate;
                    $Update="update meetings_cstm set productos_c = '{$beanparentmeeting->productos_c}' where id_c = '{$beanparentmeeting->id}'";
                    $Result=$db->query($Update);
//                }
            }
//      }
  }

    function ProspectoContactado($bean, $event, $arguments)
    {
		  if($bean->status == "Held" && $bean->parent_type == 'Accounts' && $bean->parent_id){
  		  $beanAccount = BeanFactory::getBean('Accounts', $bean->parent_id);
				if($beanAccount->user_id_c == $bean->assigned_user_id || $beanAccount->user_id1_c == $bean->assigned_user_id || $beanAccount->user_id2_c == $bean->assigned_user_id || $beanAccount->user_id6_c == $bean->assigned_user_id || $beanAccount->user_id7_c == $bean->assigned_user_id){
          $beanUser = BeanFactory::getBean('Users', $bean->assigned_user_id);
          $beanResumen = BeanFactory::getBean('tct02_Resumen', $bean->parent_id);
          if($beanAccount->user_id_c == $bean->assigned_user_id && $beanResumen->tct_tipo_l_txf_c == 'Lead'){
            $beanResumen->tct_tipo_l_txf_c = "Prospecto";
            $beanResumen->tct_subtipo_l_txf_c = "Contactado";
            $beanResumen->tct_tipo_cuenta_l_c = "PROSPECTO CONTACTADO";
          }
          if($beanAccount->user_id2_c == $bean->assigned_user_id && $beanResumen->tct_tipo_ca_txf_c == 'Lead'){
            $beanResumen->tct_tipo_ca_txf_c = "Prospecto";
            $beanResumen->tct_subtipo_ca_txf_c = "Contactado";
            $beanResumen->tct_tipo_cuenta_ca_c = "PROSPECTO CONTACTADO";
          }
          if($beanAccount->user_id1_c == $bean->assigned_user_id && $beanResumen->tct_tipo_f_txf_c == 'Lead'){
            $beanResumen->tct_tipo_f_txf_c = "Prospecto";
            $beanResumen->tct_subtipo_f_txf_c = "Contactado";
            $beanResumen->tct_tipo_cuenta_f_c = "PROSPECTO CONTACTADO";
          }
          if($beanAccount->user_id6_c == $bean->assigned_user_id && $beanResumen->tct_tipo_fl_txf_c == 'Lead'){
            $beanResumen->tct_tipo_fl_txf_c = "Prospecto";
            $beanResumen->tct_subtipo_fl_txf_c = "Contactado";
            $beanResumen->tct_tipo_cuenta_fl_c = "PROSPECTO CONTACTADO";
          }
          if($beanAccount->user_id7_c == $bean->assigned_user_id && $beanResumen->tct_tipo_uc_txf_c == 'Lead'){
            $beanResumen->tct_tipo_uc_txf_c = "Prospecto";
            $beanResumen->tct_subtipo_uc_txf_c = "Contactado";
            $beanResumen->tct_tipo_cuenta_uc_c = "PROSPECTO CONTACTADO";
          }
          $beanResumen->save();
          if($beanAccount->tipo_registro_c == 'Lead'){
  					$beanAccount->tipo_registro_c = 'Prospecto';
            $beanAccount->subtipo_cuenta_c = 'Contactado';
            $beanAccount->tct_prospecto_contactado_chk_c = 1;
            $beanAccount->save();
          }
  			}
		  }
	  }
}
