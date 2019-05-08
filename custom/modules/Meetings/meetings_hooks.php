<?php
/**
 * Created by CVV
 * User: carmen.velasco@unifin.com.mx
 * Date: 19/10/2016
 * Modified: AF. 2019/05/06
 */

require_once('modules/Emails/Email.php');

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
    //&& empty($bean->repeat_parent_id)
    if ($args['relationship'] == 'meetings_users' && $bean->assigned_user_id != $args['related_id'] && $bean->parent_type == 'Accounts' && !empty($bean->parent_id) )
    {
      $GLOBALS['log']->fatal('TCT - RelationAdd - :' .$args['related_module']);
      global $db, $current_user;

      //Valida que no exista reunión asociada al usuario
      $idUsuario = $args['related_id'];
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
      $puesto = $current_user->puestousuario_c;
      $lista = $app_list_strings['prospeccion_c_list'];
      $listatext=array();

      foreach ($lista as $key => $newList){
        $listatext[]=$key;
        if($key == $puesto){
          $flag=true;
        }
      }
      //Evaluación de resultado para crear reunión
      if ($queryResult==0 && $flag==false) {
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
          'check_out_platform_c'
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
        //Agrega objetivos
        if($bean->load_relationship('meetings_minut_objetivos_1')) {
          $relatedBeans = $bean->meetings_minut_objetivos_1->getBeans();
          foreach($relatedBeans as $rel){
            $beanObjetivo = BeanFactory::newBean('minut_Objetivos');
            $beanObjetivo->name = $rel->name;
            $beanObjetivo->meetings_minut_objetivos_1meetings_ida = $reunionInvitado->id;
            $beanObjetivo->description = $rel->description;
            $beanObjetivo->save();
          }
        }
      }

      //Elimina usuario de reunión original
      $update = "update meetings_users SET deleted = 1
                  where meeting_id = '{$bean->id}'
                  and user_id = '{$idUsuario}'
      ";
      $updateResult = $db->query($update);
    }

    //Actualiza reunión si ya tiene minuta
    if($args['related_module'] == 'minut_Minutas'){
      $GLOBALS['log']->fatal("TCT - Cumple condición 2 y actualiza reunión Held");
      // $GLOBALS['log']->fatal($args);
      // $GLOBALS['log']->fatal(print_r($args,true));
      //Actualiza estado a Planeado
      $bean->status='Held';
      //$bean->minut_minutas_meetingsminut_minutas_ida=$args['related_id'];
      $meetUpdate="update meetings m
                    set m.status='Held'
                    where m.id='{$bean->id}'
      ";
      $updateResult=$db->query($meetUpdate);
    }
	}

  /*
   * Guargar y actualizar objetivos de reunión
   * Función que guarda y actualiza objetivos específicos relacionados a la reunión
   * */
  function saveObjetivos ($bean = null, $event = null, $args = null)
  {
        if($bean->reunion_objetivos != null || !empty($bean->reunion_objetivos)){
            $GLOBALS['log']->fatal('TCT - saveObjetivos -');
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
        if (!$args[isUpdate]) {
          global $db;
          $update = " update meetings_cstm set check_in_time_c = null, check_out_time_c = null where id_c='{$bean->id}'";
			    $execute = $db->query($update);
          //$GLOBALS['log']->fatal('Actualiza check_in_time_c & check_out_time_c');
        }
  }

  /*
   * Actualiza estado de reunión
   * Función que valida estado de la reunión y actualiza de ser necesario
   * */
  function modificaReunion ($bean= null, $event=null, $args=null)
  {
    //Agrega funcionalidad para actualizar estado = Planned
    //$GLOBALS['log']->fatal("Parent: ".$bean->parent_type. "Parent_id: ".$bean->parent_id." Minuta: ".$bean->minut_minutas_meetingsminut_minutas_ida."Estado: ".$bean->status);
    if ($bean->parent_type=='Accounts' && !empty($bean->parent_id) && empty($bean->minut_minutas_meetingsminut_minutas_ida) && $bean->status=='Held') {
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
  }

  /*
   * Función para tabla de auditoría de Meetings
   * Función que inserta valores a tabla de meetings_audit (creada directa desde la BD) para poder trackear los cambios realizados al campo de status
   * */
  function insertAuditFields ($bean, $event, $args)
  {
    $GLOBALS['log']->fatal('TCT - insertAuditFields -');
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

}
