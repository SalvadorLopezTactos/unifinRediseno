<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/26/2015
 * Time: 8:07 PM
 */
class Task_Hooks{

    public function afterWorkflow($bean=null,$event=null,$args=null){

        if($bean->parent_type == 'Accounts' && $bean->estatus_c == 'No Interesado'){
            $account = BeanFactory::getBean('Accounts', $bean->parent_id);
            $bean->name = 'Prospecto No Interesado ' . $account->name . ' - ' . $account->tipodemotivo_c;
            $bean->description = $account->motivo_c;
            $bean->date_start = $bean->date_entered;
        }
        
    }

    function InfoTasks($bean = null, $event = null, $args = null)
          {
                if (!$args['isUpdate']) { 
                            global $db ,$current_user;
                            $GLOBALS['log']->fatal("InfoTasks: Inicio");
                            //Realiza consulta para obtener info del usuario asignado
                            $query="SELECT cstm.region_c,cstm.equipos_c,cstm.tipodeproducto_c,cstm.puestousuario_c from users as u
                                    INNER JOIN users_cstm as cstm
                                    ON u.id=cstm.id_c
                                    WHERE id='{$bean->assigned_user_id}'";
                                    $GLOBALS['log']->fatal("InfoTasks: consulta : ".$query);
                            $queryResult = $db->query($query);
                            $GLOBALS['log']->fatal("InfoTasks: Consulta para usuario asignado " .print_r($queryResult, true));
                            while ($row = $db->fetchByAssoc($queryResult)) {
                                    //Setea valores usuario ASIGNADO
                                   $bean->asignado_region_c=$row['region_c'];
                                   $bean->asignado_equipo_promocion_c=$row['equipos_c'];
                                   $bean->asignado_producto_c=$row['tipodeproducto_c'];
                                   $bean->asignado_puesto_c=$row['puestousuario_c'];
                                }
                                $GLOBALS['log']->fatal("InfoTasks: Setea valores usuario logueado");
                           //Setea valores usuario LOGUEADO/Creador del registro
                           $bean->creado_region_c= $current_user->region_c;
                           $bean->creado_equipo_promocion_c =$current_user->equipos_c;
                           $bean->creado_producto_c= $current_user->tipodeproducto_c;
                           $bean->creado_puesto_c=$current_user->puestousuario_c;
                           $GLOBALS['log']->fatal("InfoTasks: Finaliza");
                }
          }	
}