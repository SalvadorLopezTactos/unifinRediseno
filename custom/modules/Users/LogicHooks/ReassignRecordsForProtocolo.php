<?php
/**
 * User: salvadorlopez
 * Date: 23/02/21
 */
class ReassignRecordsForProtocolo
{
    function reassignRecordsForUserInactive($bean = null, $event = null, $args = null){

        global $app_list_strings;
        global $current_user;
        global $db;

        $status=$bean->status;
        $status_anterior=isset($bean->fetched_row['status']) ? $bean->fetched_row['status'] : $status;
        $puesto_usuario=$bean->puestousuario_c;
        $lista_puestos=$app_list_strings['puestos_para_reasignacion_list'];

        $reasigna=false;
        if(array_key_exists($puesto_usuario, $lista_puestos)){
            $reasigna=true;
        }
        if($status != $status_anterior && $status=='Inactive' && $reasigna){
            $valor_doc_carga=$app_list_strings['nombre_archivo_protocolo_leads_list']['1'];

            //Obtiene información del usuario Inactivo
            $oficina=$bean->equipo_c;
            $id_usuario=$bean->id;

            //Obtiene todos los Leads del usuario Inactivo del tipo “Lead sin Contactar” y “Lead Contactado”
            $query = "SELECT l.id,lc.name_c FROM leads l INNER JOIN leads_cstm lc
            ON l.id=lc.id_c
            WHERE lc.tipo_registro_c='1' 
            AND lc.subtipo_registro_c IN ('1','2')
            AND l.assigned_user_id='{$id_usuario}'
            AND l.deleted='0'";
            
            $queryResult = $db->query($query);

            if($queryResult->num_rows > 0){
                $numero_leads=0;
                while ($row = $db->fetchByAssoc($queryResult)) {
                    $id_lead=$row['id'];
                    $beanLead = BeanFactory::getBean('Leads', $id_lead, array('disable_row_level_security' => true));
                    if(!empty($beanLead)){
                        //Todo: ¿A qué usuario se asigna provisionalmente?
                        try {
                            $beanLead->oficina_c=$oficina;
                            $beanLead->nombre_de_cargar_c=$valor_doc_carga;
                            $beanLead->subtipo_registro_c='1';
                            $beanLead->assigned_user_id="569246c7-da62-4664-ef2a-5628f649537e";//Usuario 9 - Sin Gestor
                            $beanLead->assigned_user_name="9 - Sin Gestor";//Usuario 9 - Sin Gestor
                            $beanLead->save();
                            $GLOBALS['log']->fatal("LEAD REGRESADO A LA BASE DE REASIGNACION AUTOMÁTICA: [".$beanLead->id."] Nombre: ".$beanLead->name_c);
                            $numero_leads+=1;
                        } catch (Exception $e) {
                            $GLOBALS['log']->fatal("Error, Alguna condición de Reasignación del lead detuvo el flujo para reasignarle el usuario 9 - Sin Gestor: " . $e->getMessage());
                        }
                    }                    
                }
                $GLOBALS['log']->fatal("NUMERO DE REGISTROS REGRESADOS A LA BASE DE REASIGNACIÓN AUTOMÁTICA PARA LEAD MANAGEMENT: ".$numero_leads);
            }
        }
    }

}
