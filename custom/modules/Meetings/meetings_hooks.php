<?php
    /**
     * Created by CVV
     * User: carmen.velasco@unifin.com.mx
     * Date: 19/10/2016
     */

    require_once('modules/Emails/Email.php');

class Meetings_Hooks
{
    //Agregar Invitados
    function RelationAdd($bean = null, $event = null, $args = null)
    {
		global $db;
		if($args['related_module'] == 'Users' && $args['relationship'] == 'meetings_users' && $args['related_id'] != $bean->assigned_user_id && $bean->date_entered != $bean->date_modified && stristr($bean->description,"Cita registrada automaticamente por CRM ya que ha sido asignado como") == False)
		{   
/*			$query = <<<SQL
                SELECT a.id, b.parent_meeting_c
                FROM meetings a, meetings_cstm b
                WHERE b.parent_meeting_c = '{$bean->id}'
				        AND a.id = b.id_c
                AND a.deleted = 0
SQL;
            $conn = $db->getConnection();
            $queryResult = $conn->executeQuery($query);
            foreach($queryResult->fetchAll() as $row)
			{
				$acompanianteMeet = BeanFactory::getBean('Meetings',$row['id']);
				$acompanianteMeet->set_relationship('meetings_users', array('meeting_id' => $acompanianteMeet->id, 'user_id' => $args['related_id']));
				//Elimina Admin
				$levadmin = <<<SQL
					UPDATE meetings_users SET deleted = 1
					WHERE meeting_id = '{$acompanianteMeet->id}'
					AND user_id = 1
SQL;
				$levadmin1 = $db->query($levadmin);
			}*/
			// Crear Reuni�n

  			$exclude = array
			  (
  				'id',
  				'date_entered',
  				'date_modified',
			  	'assigned_user_id',
				  'parent_meeting_c',
  				'description'
      		);
      		$acompanianteMeet1 = BeanFactory::getBean('Meetings');
      		foreach($bean->field_defs as $def)
      		{
      			if(!(isset($def['source']) && $def['source'] == 'non-db') && !empty($def['name']) && !in_array($def['name'], $exclude))
      			{
      				$field = $def['name'];
      				$acompanianteMeet1->{$field} = $bean->{$field};
      			}
      		}
      		$acompanianteMeet1->parent_meeting_c = $bean->id;
			    $acompanianteMeet1->created_by = $bean->created_by;
			    $acompanianteMeet1->modified_user_id = $bean->modified_user_id;
      		$acompanianteMeet1->assigned_user_id = $args['related_id'];
      		$acompanianteMeet1->description = $bean->description." - Cita registrada automaticamente por CRM ya que ha sido asignado como invitado.";
      		$acompanianteMeet1->save();
/*      		//Agregar relaciones de invitados
      		$queryrel = <<<SQL
				SELECT id, user_id
      			FROM meetings_users
      			WHERE meeting_id = '{$bean->id}'
      			AND deleted = 0
SQL;
			$queryrel1 = $db->query($queryrel);
      		while($rowrel = $db->fetchByAssoc($queryrel1))
      		{
      			$acompanianteMeet1->set_relationship('meetings_users', array('meeting_id' => $acompanianteMeet1->id, 'user_id' => $rowrel['user_id']));
      		}*/
		}
		//Elimina Invitados
        if(stristr($bean->description,"Cita registrada automaticamente por CRM ya que ha sido asignado como") == True)
	    {
			$levadmin = <<<SQL
				UPDATE meetings_users SET deleted = 1
				WHERE meeting_id = '{$bean->id}'
				AND user_id <> '{$bean->assigned_user_id}'
SQL;
			$levadmin1 = $db->query($levadmin);
		}
		//Elimina Admin
		$levadmin = <<<SQL
			UPDATE meetings_users SET deleted = 1
			WHERE meeting_id = '{$bean->id}'
			AND user_id = '1'
SQL;
		$levadmin1 = $db->query($levadmin);
	}

    //Eliminar Invitados
    function RelationDel($bean = null, $event = null, $args = null)
    {
		global $db;
		if($args['related_module'] == 'Users' && $args['relationship'] == 'meetings_users' && $bean->date_entered != $bean->date_modified && stristr($bean->description,"Cita registrada automaticamente por CRM ya que ha sido asignado como") == False)
		{
			$relid = $args['related_id'];
			$elimina = <<<SQL
						SELECT id, meeting_id, user_id
						FROM meetings_users
						WHERE meeting_id IN (SELECT a.id FROM meetings a, meetings_cstm b
							  WHERE a.id = b.id_c AND a.deleted = 0 AND b.parent_meeting_c = '{$bean->id}')
						AND user_id = '{$relid}'
						AND deleted = 0
SQL;
			$elimina1 = $db->query($elimina);
			while($del1 = $db->fetchByAssoc($elimina1))
			{
				$idel = $del1['id'];
				$querys = <<<SQL
					UPDATE meetings_users SET deleted = 1
					WHERE id = '{$idel}'
SQL;
				$actualiza = $db->query($querys);
				// Elimina Reuni�n
				$querydel = <<<SQL
						SELECT a.id, a.assigned_user_id, b.parent_meeting_c
						FROM meetings a, meetings_cstm b
						WHERE b.parent_meeting_c = '{$bean->id}'
						AND a.assigned_user_id = '{$relid}'
						AND a.id = b.id_c
						AND a.deleted = 0
SQL;
				$querydel1 = $db->query($querydel);
				while($rowdel = $db->fetchByAssoc($querydel1))
				{
					$acompanianteMeet2 = BeanFactory::getBean('Meetings',$rowdel['id']);
					$acompanianteMeet2->deleted = 1;
					$acompanianteMeet2->save();
				}
			}
		}
	}

    //Generar una copia del meeting para los acompa�antes de la cita en Brujula
    function MeetingAcompaniante($bean = null, $event = null, $args = null)
    {
        global $db;
        // Crear Reuni�n
        if(stristr($bean->description,"Cita registrada automaticamente por CRM ya que ha sido asignado como") == False && $bean->date_entered == $bean->date_modified && $bean->repeat_parent_id == "")
        {
          $query = <<<SQL
             SELECT id, user_id
             FROM meetings_users
             WHERE meeting_id = '{$bean->id}'
             AND deleted = 0
SQL;
			    $conn = $db->getConnection();
          $queryResult = $conn->executeQuery($query);
          foreach($queryResult->fetchAll() as $row)
	    	  {
      			if($row['user_id'] != $bean->assigned_user_id)
			      {
      				$exclude = array
      				(
      					'id',
      					'date_entered',
      					'date_modified',
      					'assigned_user_id',
      					'parent_meeting_c'
      				);
      				$acompanianteMeet = BeanFactory::getBean('Meetings');
      				foreach($bean->field_defs as $def)
      				{
      					if(!(isset($def['source']) && $def['source'] == 'non-db') && !empty($def['name']) && !in_array($def['name'], $exclude))
      					{
      						$field = $def['name'];
      						$acompanianteMeet->{$field} = $bean->{$field};
      					}
      				}
      				$acompanianteMeet->parent_meeting_c = $bean->id;
					    $acompanianteMeet->created_by = $bean->created_by;
				    	$acompanianteMeet->modified_user_id = $bean->modified_user_id;
      				$acompanianteMeet->assigned_user_id = $row['user_id'];
      				$acompanianteMeet->description = $bean->description." - Cita registrada automaticamente por CRM ya que ha sido asignado como invitado.";
      				$acompanianteMeet->save();
/*      				//Agregar relaciones de invitados
      				$query1 = $db->query($query);
      				while($row1 = $db->fetchByAssoc($query1))
      				{
      					$acompanianteMeet->set_relationship('meetings_users', array('meeting_id' => $acompanianteMeet->id, 'user_id' => $row1['user_id']));
      				}*/
      			}
      		}
/*      		$ultimo = <<<SQL
                    UPDATE meetings_cstm
                    SET nuevo_c = 0
                    WHERE id_c = '{$bean->id}'
SQL;
 		  	  $ultimo1 = $db->query($ultimo);*/
        }

		    // Editar Reuni�n
        if(stristr($bean->description,"Cita registrada automaticamente por CRM ya que ha sido asignado como") == False && $bean->date_entered != $bean->date_modified)
	      {
  		  	  $query = <<<SQL
                SELECT a.id, b.parent_meeting_c
                FROM meetings a, meetings_cstm b
                WHERE b.parent_meeting_c = '{$bean->id}'
				        AND a.id = b.id_c
                AND a.deleted = 0
SQL;
            $conn = $db->getConnection();
            $queryResult = $conn->executeQuery($query);
            foreach($queryResult->fetchAll() as $row)
      			{
			      	$exclude = array
      			  (
      				'id',
      				'date_entered',
      				'date_modified',
      				'assigned_user_id',
      				'parent_meeting_c',
      				'description',
				    	'status',
					    'objetivo_c',
					    'resultado_c',
    					'referenciada_c',
    					'check_in_address_c',
    					'check_in_latitude_c',
    					'check_in_longitude_c',
    					'check_in_time_c'
      			);
      			$acompanianteMeet = BeanFactory::getBean('Meetings',$row['id']);
      			foreach($bean->field_defs as $def)
      			{
      				if(!(isset($def['source']) && $def['source'] == 'non-db') && !empty($def['name']) && !in_array($def['name'], $exclude))
      				{
      					$field = $def['name'];
      					$acompanianteMeet->{$field} = $bean->{$field};
      				}
      			}
      			$acompanianteMeet->save();
      		}
/*      		$ultimo = <<<SQL
                    UPDATE meetings_cstm
                    SET actualizado_c = 0
                    WHERE id_c = '{$bean->id}'
SQL;
            $ultimo1 = $db->query($ultimo);*/
        }

		    //Elimina Invitados
        if(stristr($bean->description,"Cita registrada automaticamente por CRM ya que ha sido asignado como") == True)
        {
  			  $levadmin = <<<SQL
  				UPDATE meetings_users SET deleted = 1
  				WHERE meeting_id = '{$bean->id}'
  				AND user_id <> '{$bean->assigned_user_id}'
SQL;
    			$levadmin1 = $db->query($levadmin);
/*		    	//Cambia Admin
		    	$query = <<<SQL
  				SELECT created_by, modified_user_id
  				FROM meetings
  				WHERE id = '{$bean->parent_meeting_c}'
  				AND deleted = 0
SQL;
    			$conn = $db->getConnection();
    			$queryResult = $conn->executeQuery($query);
    			foreach($queryResult->fetchAll() as $row)
    			{
    				$creado = $row['created_by'];
    				$modificado = $row['modified_user_id'];
    				$levadmin = <<<SQL
    					UPDATE meetings SET created_by = '{$creado}', modified_user_id = '{$creado}'
    					WHERE id = '{$bean->id}'
SQL;
    				$levadmin1 = $db->query($levadmin);
		    	}*/
  		  }
		    //Elimina Admin
		    $levadmin = <<<SQL
            UPDATE meetings_users SET deleted = 1
            WHERE meeting_id = '{$bean->id}'
		    AND user_id = '1'
SQL;
		    $levadmin1 = $db->query($levadmin);
    }

    //@Jesus Carrillo
    //
    function Getmails($bean = null, $event = null, $args = null)
    {
        $emails=[];
        $ids=[];
        $names=[];
        $GLOBALS['log']->fatal('>>>>>>>Entro Meeting Hook: ');//------------------------------------
        $GLOBALS['log']->fatal('>>>>>>>Status anterior: '.$bean->fetched_row['status']);//-------------------------------------
        $GLOBALS['log']->fatal('>>>>>>>Status posterior: '.$bean->status);//-------------------------------------
        $GLOBALS['log']->fatal('>>>>>>>Description: '.$bean->description);//-------------------------------------


        if($bean->fetched_row['status']!='Held' && $bean->status=='Held'){

            $contador=0;
            $parent_type=$bean->parent_type;
            $parent_id=$bean->parent_id;

            if($parent_type=='Accounts') {
                $bean_cuenta = BeanFactory::retrieveBean('Accounts', $parent_id);
                $bean_cuenta->load_relationship('rel_relaciones_accounts');
                $bean_relaciones = $bean_cuenta->rel_relaciones_accounts->getBeans();

                $GLOBALS['log']->fatal('Length de Relaciones: '.count($bean_relaciones));//-------------------------------------
                if(count($bean_relaciones)>0) {
                    foreach ($bean_relaciones as $relacion) {
                        if (strpos($relacion->relaciones_activas, 'Contacto') && $relacion->tipodecontacto == 'Promocion') {
                            $bean_cuenta_promocion = BeanFactory::retrieveBean('Accounts', $relacion->account_id1_c);
                            if($bean_cuenta_promocion->email[0]['email_address']!='') {
                                $emails[] = $bean_cuenta_promocion->email[0]['email_address'];
                                $ids[]=$bean_cuenta_promocion->id;
                                $names[]=$bean_cuenta_promocion->name;
                            }
                            $contador++;
                        }
                    }
                }
                if($contador==0){
                    if($bean_cuenta->email[0]['email_address']!='') {
                        $emails[] = $bean_cuenta->email[0]['email_address'];
                        $ids[]=$bean_cuenta->id;
                        $names[]=$bean_cuenta->name;
                    }
                }

                //$emails[]='jesus.carrillo@tactos.com.mx';
                //$emails[]='apena@appwhere.mx';
                //$emails[]='jslb_cafcb10@hotmail.com';
                //$emails[]='axel.flores@tactos.com.mx';


                $GLOBALS['log']->fatal('Length de Emails: '.count($emails));//-------------------------------------
                //$GLOBALS['log']->fatal(print_r($bean_cuenta,true));//----------------------
                $GLOBALS['log']->fatal('Se enviara correo a las siguientes personas:');//----------------------
                $GLOBALS['log']->fatal(print_r($emails,true));//----------------------
                $GLOBALS['log']->fatal(print_r($ids,true));//----------------------

            }

            if(count($emails)>0){
                for($i=0;$i<count($emails);$i++){

                        $bean_encuesta = BeanFactory::newBean('TCT01_Encuestas');
                        $GLOBALS['log']->fatal('Bean creado:');//----------------------
                        $bean_encuesta->name = 'Encuesta Satisfacción-' . $bean->name;
                        $GLOBALS['log']->fatal('Nombre asignado');//----------------------
                        $bean_encuesta->tct_correo_txf = $emails[$i];
                        $GLOBALS['log']->fatal('Correo asignado');//----------------------
                        $bean_encuesta->tct01_encuestas_meetingsmeetings_ida = $bean->id;
                        $GLOBALS['log']->fatal('Id  de encuesta asignado');//----------------------

                        //$bean_encuesta->tct_account_survey_rel_c = $names[i];

                        //$bean_encuesta->tct_account_survey_rel_c = $ids[$i];

                        $bean_encuesta->account_id_c=$ids[$i];
                        //$bean_encuesta->description = 'Pendiente Envio';

                        $GLOBALS['log']->fatal('Id del cliente:'.$ids[$i] );//----------------------

                        $bean_cuenta2 = BeanFactory::retrieveBean('Accounts', $ids[$i]);
                        //$GLOBALS['log']->fatal(print_r($bean_cuenta2,true));//----------------------



                        $bean_encuesta->save();

                        $GLOBALS['log']->fatal('Se ha creado una encuesta de: ' . $emails[$i]);//-------------------------------------
                    //$bean->load_relationship('rel_relaciones_accounts');
                }
            }
        }
    }

    function saveObjetivos ($bean = null, $event = null, $args = null)
    {
        if($bean->reunion_objetivos != null || !empty($bean->reunion_objetivos)){

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
                    $GLOBALS['log']->fatal('Actualiza Objetivos');
                    $GLOBALS['log']->fatal($objetivo['name']);
                    $beanObjetivo = BeanFactory::retrieveBean('minut_Objetivos', $objetivo['id']);
                    if($beanObjetivo!=null){
                        $beanObjetivo->name = $objetivo['name'];
                        $beanObjetivo->description = $objetivo['description'];
                        $beanObjetivo->deleted = $objetivo['deleted'];
                        $beanObjetivo->save();
                    }
                }else{
                    //Crea
                    $GLOBALS['log']->fatal('Inserta Objetivos');
                    $GLOBALS['log']->fatal($objetivo['name']);
                    $beanObjetivo = BeanFactory::newBean('minut_Objetivos');
                    $beanObjetivo->name = $objetivo['name'];
                    $beanObjetivo->meetings_minut_objetivos_1meetings_ida = $bean->id;
                    $beanObjetivo->description = $objetivo['description'];
                    $beanObjetivo->save();
                }
            }
        }

        //Restablece check-in/out time en creación
        if (!$args[isUpdate]) {
          global $db;
          $update = " update meetings_cstm set check_in_time_c = null, check_out_time_c = null where id_c='{$bean->id}'";
			    $execute = $db->query($update);
          $GLOBALS['log']->fatal('Actualiza check_in_time_c & check_out_time_c');

        }
    }

    function cambiAdmin ($bean = null, $event = null, $args = null)
    {
      if($bean->modified_user_id == '1')
      {
        if($bean->fetched_row['modified_user_id'])
        {
          $bean->modified_user_id = $bean->fetched_row['modified_user_id'];
        }
      }
    }
    
    function cambiAdmin2 ($bean = null, $event = null, $args = null)
    {
      if($bean->modified_user_id == '1')
      {
          global $db;
		    	$query = <<<SQL
  				SELECT created_by, modified_user_id
  				FROM meetings
  				WHERE id = '{$bean->parent_meeting_c}'
  				AND deleted = 0
SQL;
    			$conn = $db->getConnection();
    			$queryResult = $conn->executeQuery($query);
    			foreach($queryResult->fetchAll() as $row)
    			{
    				$creado = $row['created_by'];
    				$modificado = $row['modified_user_id'];
    				$levadmin = <<<SQL
   					UPDATE meetings SET created_by = '{$creado}', modified_user_id = '{$modificado}'
    				WHERE id = '{$bean->id}'
SQL;
            $conn1 = $db->getConnection();
            $queryResult1 = $conn1->executeQuery($levadmin);
          }
      }
    }

    //Se elimina de la lista de invitados a los usuarios con puesto Agente telefonico y Centro de Prospección
    function modificaReunion ($bean= null, $event=null, $args=null)
    {
      global $current_user;
      global $app_list_strings;
      global $db;
      $puesto = $current_user->puestousuario_c;
      $lista = $app_list_strings['prospeccion_c_list'];
      $flag=false;
      $listatext=array();

      //Se hace la comparacion entre la lista y el puesto del usuario loggeado
      foreach ($lista as $key => $newList){
        $listatext[]=$key;
        if ($key == $puesto){
          $flag=true;
        }
      }
      //Si coincide el usuario loggeado con alguno de la lista
      if($flag==true){
        $usrmod=array();
        //Consulta del id de la reunion y el del usuario loggeado
        $meetingscount="
          select m.user_id
          from meetings_users m 
          inner join users u on u.id = m.user_id
          inner join users_cstm uc on uc.id_c = u.id
          where 
          m.meeting_id = '{$bean->id}'
          and uc.puestousuario_c not in ('".implode("','",$listatext)."')
          and m.deleted = 0";
        $totalcount=$db->query($meetingscount);
        //$GLOBALS['log']->fatal("El puesto de los usuarios es: ".$totalcount);
        //$GLOBALS['log']->fatal("El id de la reunión es: ".$bean->id);
        $conteo=0;
        //$GLOBALS['log']->fatal("El usuario loggeado es: ".$current_user->id);
        while($row=$db->fetchByAssoc($totalcount)){
          $conteo++;
          $totalme=$row['user_id'];
          //Comparacion del id de los invitados para excluir al usuario loggeado el puesto de la lista
          if($row['user_id']!=$current_user->id){
            array_push($usrmod, $row['user_id']);
          }
          //$GLOBALS['log']->fatal("El id de los usuarios: ".$totalme);
        }
        //$GLOBALS['log']->fatal("Los usuarios invitados son: ". print_r($usrmod,true));
        //Comparacion para modificar a la persona asignada, solo cuando haya invitados
        if(count($usrmod)>=1 && $bean->assigned_user_id==$current_user->id){
          //Se hace una consulta a base de datos para modificar el usuario asignado a cada reunión
          $assigned="
            UPDATE meetings
            SET assigned_user_id ='{$usrmod[0]}'
            WHERE id='{$bean->id}'";
          $assig=$db->query($assigned);
          $GLOBALS['log']->fatal("El update del usuarios: ".$usrmod[0]);
          //Modificación del deleted=1 para que elimine a un usuario si corresponde a algún puesto de la lista
          $bean->assigned_user_id=$usrmod[0];
          $deleusr="
            UPDATE meetings_users
            SET deleted = 1
            WHERE user_id= '{$current_user->id}' 
            AND meeting_id='{$bean->id}'";
          $deletusr=$db->query($deleusr);
        }
      }
      $puestoinv="
        update meetings_users m 
        inner join users u on u.id = m.user_id
        inner join users_cstm uc on uc.id_c = u.id
        set m.deleted = 1
        where 
        m.meeting_id = '{$bean->id}'
        and uc.puestousuario_c  in ('".implode("','",$listatext)."')
        and m.deleted = 0";
      $showpuesto=$db->query($puestoinv);
      //$GLOBALS['log']->fatal("El puesto de los usuarios es: ".$puestoinv);
    }

    function EliminaInvitados($bean=null, $event=null, $args=null){
      $GLOBALS['log']->fatal("Entro a LH 5:");
      $asignado=$bean->assigned_user_id;
      global $db;
      $invitados=array();
      $meetingscount="
        update meetings_users m
        set m.deleted=1
        where m.meeting_id='{$bean->id}'
        and m.user_id !='{$asignado}'";
      $totalcount=$db->query($meetingscount);
      $conteo=0;
      while($row=$db->fetchByAssoc($totalcount)){
        $conteo++;
        array_push($invitados, $row['user_id']);
      }
      //$GLOBALS['log']->fatal("Los inivtados finales son: ".$meetingscount);
    }
  }
