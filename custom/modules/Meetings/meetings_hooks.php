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
        if(stristr($bean->description,"Cita registrada automaticamente por CRM ya que ha sido asignado como") == False && $bean->nuevo_c == 1 && $bean->repeat_parent_id == "")
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
      		$ultimo = <<<SQL
                    UPDATE meetings_cstm
                    SET nuevo_c = 0
                    WHERE id_c = '{$bean->id}'
SQL;
 			$ultimo1 = $db->query($ultimo);
        }

		// Editar Reuni�n
        if(stristr($bean->description,"Cita registrada automaticamente por CRM ya que ha sido asignado como") == False && $bean->date_entered != $bean->date_modified && $bean->nuevo_c == 0 && $bean->actualizado_c == 1)
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
      		$ultimo = <<<SQL
                    UPDATE meetings_cstm
                    SET actualizado_c = 0
                    WHERE id_c = '{$bean->id}'
SQL;
            $ultimo1 = $db->query($ultimo);
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
			//Cambia Admin
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
			}
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

        foreach ($bean->reunion_objetivos['records'] as $objetivo) {
            if ($objetivo['id']) {
                //Actualiza
                $GLOBALS['log']->fatal('Actualiza Objetivos');
                $GLOBALS['log']->fatal($objetivo['name']);
                $beanObjetivo = BeanFactory::retrieveBean('minut_Objetivos', $objetivo->id);
                $beanObjetivo->name = $objetivo['name'];
                $beanObjetivo->save();
            }else{
                //Crea
                $GLOBALS['log']->fatal('Inserta Objetivos');
                $GLOBALS['log']->fatal($objetivo['name']);
                $beanObjetivo = BeanFactory::newBean('minut_Objetivos');
                $beanObjetivo->name = $objetivo['name'];
                $beanObjetivo->meetings_minut_objetivos_1meetings_ida = $bean->id;
                $beanObjetivo->save();
            }
        }
    }

}