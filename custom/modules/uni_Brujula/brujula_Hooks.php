<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 9/19/2016
 * Time: 9:36 AM
 */
require_once ("custom/Levementum/DropdownValuesHelper.php");
class brujula_Hooks{

    public function setName($bean, $event, $args)
    {
        global $db;
        $numero_de_folio = <<<SQL
SELECT numero_folio FROM uni_brujula WHERE id = '{$bean->id}'
SQL;
        $queryResult = $db->getOne($numero_de_folio);

        $user = BeanFactory::retrieveBean('Users', $bean->assigned_user_id);

        $name = $queryResult . " - " . $bean->fecha_reporte . " - " . $user->name;
        $query = <<<SQL
UPDATE uni_brujula SET name = '{$name}' WHERE id = '{$bean->id}'
SQL;
        $result = $db->query($query);
    }

    public function guardarCitas($bean, $event, $args){

        try
        {
            if(!empty($bean->citas_brujula)){

                $dropdownlistHelper = new DropdownValuesHelper();
                $timedate = TimeDate::getInstance();
                global $db, $current_user;
                foreach($bean->citas_brujula as $cita){

                    $referenciada = 0;
                    if($cita['nuevo_referenciada'] == "checked" || $cita['nuevo_referenciada'] == true){
                        $referenciada = 1;
                    }

                    $tiempo_cita = date('H:i:00', strtotime($cita['hora_cita']));
                    $date_time_reporte = $bean->fecha_reporte . ' ' . $tiempo_cita;
                    $usertimezone = $current_user->getPreference('timezone');
                    $tz = new DateTimeZone($usertimezone);
                    $start_date = new SugarDateTime($date_time_reporte, $tz);

                    $objetivo = $dropdownlistHelper->matchListLabel($cita['nuevo_objetivo'], "objetivo_list");
                    $meeting = BeanFactory::getBean('Meetings', $cita['id']);
                    if(empty($meeting->id)){
                        $meeting->name = $objetivo  . " " . $cita['parent_name'];
                        $meeting->date_start = $timedate->asUser($start_date, $GLOBALS['current_user']);
                        $meeting->parent_type = "Accounts";
                        $meeting->parent_id = $cita['parent_id'];

                        $hours = intval($cita['duration_minutes']/60);
                        $minutes = $cita['duration_minutes'] - ($hours * 60);

                        $meeting->duration_hours = $hours;
                        $meeting->duration_minutes = $minutes;

                        $meeting->reminder_checked = 0;
                        $meeting->description = "Cita registrada a través de Brújula: Objetivo - " . $objetivo . " - Cliente: " . $cita['parent_name'];
                        $meeting->assigned_user_id = $bean->assigned_user_id;
                        $meeting->referenciada_c = $referenciada;
                        $meeting->user_id_c = $cita['nuevo_acompanante_id'];
                        $meeting->objetivo_c = $cita['nuevo_objetivo'];
                        $meeting->resultado_c = $cita['nuevo_resultado'];

                        if($cita['nuevo_estatus'] == 1){
                            $meeting->status = "Held";
                        }else{
                            $meeting->status = "Not Held";
                        }
                    }else{
                        $meeting->referenciada_c = $referenciada;
                        $meeting->user_id_c = $cita['nuevo_acompanante_id'];
                        $meeting->objetivo_c = $cita['nuevo_objetivo'];
                        $meeting->resultado_c = $cita['nuevo_resultado'];
                        if($cita['nuevo_estatus'] == 1){
                            $meeting->status = "Held";
                        }else{
                            $meeting->status = "Not Held";
                        }

                        $hours = intval($cita['duration_minutes']/60);
                        $minutes = $cita['duration_minutes'] - ($hours * 60);

                        $meeting->duration_hours = $hours;
                        $meeting->duration_minutes = $minutes;
                    }
                    $meeting->save();

                    //Crea Cita asociada
                    $uni_Citas = BeanFactory::getBean('uni_Citas');
                    $uni_Citas->account_id_c = $cita['parent_id'];
                    $uni_Citas->user_id_c = $cita['nuevo_acompanante_id'];
                    $uni_Citas->acompanantes_c = $cita['nuevo_acompanante'];
                    $uni_Citas->assigned_user_id = $bean->assigned_user_id;
                    $uni_Citas->name= $objetivo  . " " . $cita['parent_name'];
                    $uni_Citas->duracion_cita = $cita['duration_minutes'];
                    $uni_Citas->duracion_traslado = $cita['nuevo_traslado'];
                    $uni_Citas->referenciada = $referenciada;
                    $uni_Citas->objetivo = $cita['nuevo_objetivo'];
                    $uni_Citas->estatus = $cita['nuevo_estatus'];
                    $uni_Citas->resultado = $cita['nuevo_resultado'];
                    $uni_Citas->meeting_id_c = $meeting->id;
                    $uni_Citas->account_id1_c = $cita['parent_id'];
                    $uni_Citas->user_id1_c = $cita['nuevo_acompanante_id'];
                    $uni_Citas->duracion_cita_controller = $cita['duration_minutes'];
                    $uni_Citas->duracion_traslado_controller = $cita['nuevo_traslado'];
                    $uni_Citas->referenciada_controller = $referenciada;
                    $uni_Citas->objetivo_controller = $cita['nuevo_objetivo'];
                    $uni_Citas->estatus_controller = $cita['nuevo_estatus'];
                    $uni_Citas->resultado_controller = $cita['nuevo_resultado'];

                    // Vallidar si es cliente nuevo o recurrente
                    /*
                        a. Obtener los productos del promotor
                        b. Validar que el cliente tenga al menos una linea para alguno de los productos asignados al promotor
                        c. En caso de que tenga linea, se marca como recurrente, de lo contrario es cliente nuevo
                    */
                    $query = <<<SQL
                select count(id_c)
                from opportunities_cstm  op
                INNER JOIN accounts_opportunities acc on acc.opportunity_id = op.id_c AND acc.deleted = 0
                where  tipo_operacion_c = 2
                AND (select REPLACE(productos_c,'^','') from users_cstm where id_c = '{$bean->assigned_user_id}') LIKE CONCAT('%',CAST(op.tipo_producto_c AS CHAR),'%')
                AND acc.account_id = '{$cita['parent_id']}'
SQL;
                    $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> :Query para obtener lineas " . print_r($query,1));
                    $queryResult = $db->query($query);
                    $lineas = $db->getOne($query);

                    $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> :El cliente tiene " . $lineas . " lineas.");
                    if($lineas > 0){
                        $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> :El cliente SIII tiene ");
                        $uni_Citas->cliente_con_linea_c = 1;
                    }else{
                        $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> :El cliente NO tiene ");
                        $uni_Citas->cliente_con_linea_c = 0;
                    }

                    $uni_Citas->save();

                    $bean->load_relationship('uni_citas_uni_brujula');
                    $bean->uni_citas_uni_brujula->add($uni_Citas->id);
                  

                    /*
                        AF - 2018/04/04
                        Comentar depuración de relaciones(invitados)

                    $meeting->load_relationship('users');
                    foreach ($meeting->users->getBeans() as $user) {
                        $meeting->users->delete($meeting->id, $user->id);
                    }

                    $meeting->set_relationship('meetings_users', array('meeting_id' => $meeting->id, 'user_id' =>$bean->assigned_user_id));

                    */

                    /*
                    if(!empty($cita['nuevo_acompanante_id'])){
                       $meeting->set_relationship('meetings_users', array('meeting_id' => $meeting->id, 'user_id' =>$cita['nuevo_acompanante_id']));
                    }
                    */
                }
            }

            if(!empty($bean->citas_brujula_removidas)){
                foreach($bean->citas_brujula_removidas as $cita){
                    $meeting = BeanFactory::retrieveBean('Meetings', $cita['id']);
                    if(!empty($meeting->id)){
                        $meeting->status = "Not Held";
                        $meeting->save();
                    }
                }
            }

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." Error ".$e->getMessage());
        }
    }
}
