<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/16/2015
 * Time: 4:26 PM
 */
class Lead_Hooks{
    public function crearProspecto($bean = null, $event = null, $args = null){
        global $db, $current_user;
        try
        {
            if($bean->status == 'PasaraProspecto' && $bean->prospectocreado_c == false){

                $acct = BeanFactory::getBean('Accounts');
                $acct->tipo_registro_c = 'Prospecto';
                //mapear Primer, Segundo nombres y los dos apellidos
                $acct->primernombre_c = $bean->primernombre_c;
                $acct->segundonombre_c = $bean->segundonombre_c;
                $acct->apellidopaterno_c = $bean->apellidopaterno_c;
                $acct->apellidomaterno_c = $bean->apellidomaterno_c;
                $acct->save();
                //pasar el telefono
                $telefono = BeanFactory::getBean('Tel_Telefonos');
                $telefono->name = $bean->phone_work;
                $telefono->telefono = $bean->phone_work;
                $telefono->accounts_tel_telefonos_1accounts_ida = $acct->id;
                $telefono->save();

                 $query = <<<SQL
SELECT calls.id FROM calls
INNER JOIN calls_leads ON calls_leads.call_id = calls.id AND calls_leads.deleted = 0
INNER JOIN leads ON leads.id = calls_leads.lead_id AND leads.deleted = 0
WHERE leads.id = '{$bean->id}'
SQL;

                 $queryResult = $db->query($query);
                 while($row = $db->fetchByAssoc($queryResult))
                 {
                     $call = BeanFactory::getBean('Calls');
                     $call->retrieve($row['id']);
                     $call->parent_type = 'Accounts';
                     $call->parent_id = $acct->id;
                     $call->save();
                 }


                 $query = <<<SQL
SELECT meetings.id FROM meetings
INNER JOIN meetings_leads ON meetings_leads.meeting_id = meetings.id AND meetings_leads.deleted = 0
INNER JOIN leads ON leads.id = meetings_leads.lead_id AND leads.deleted = 0
WHERE leads.id = '{$bean->id}'
SQL;

                 $queryResult = $db->query($query);
                 while($row = $db->fetchByAssoc($queryResult))
                 {
                     $meeting = BeanFactory::getBean('Meetings');
                     $meeting->retrieve($row['id']);
                     $meeting->parent_type = 'Accounts';
                     $meeting->parent_id = $acct->id;
                     $meeting->save();;
                 }

                 $query = <<<SQL
SELECT id FROM tasks
WHERE parent_id = '{$bean->id}'
SQL;

                 $queryResult = $db->query($query);
                 while($row = $db->fetchByAssoc($queryResult))
                 {
                     $task = BeanFactory::getBean('Tasks');
                     $task->retrieve($row['id']);
                     $task->parent_type = 'Accounts';
                     $task->parent_id = $acct->id;
                     $task->save();
                 }

                $bean->prospectocreado_c = true;
                 $query = <<<SQL
update leads_cstm set prospectocreado_c = '{$bean->prospectocreado_c}' where id_c='{$bean->id}'
SQL;
                 $queryResult = $db->query($query);
            }

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }

    }

    public function cambiaPuesto($bean=null, $event= null, $args= null){
        //Cambia el puesto a Otro si viene vacio.
        if($bean->puesto_c == ''){
          $bean->puesto_c = '11';
        }
    }

    public function crearURLOriginacion($bean = null, $event = null, $args = null)
    {
        global $db, $sugar_config, $current_user;
        $id_assigned = $bean->assigned_user_id;
        $beanU = BeanFactory::retrieveBean('Users', $id_assigned, array('disable_row_level_security' => true));
        $correo_del_empleado = $beanU->email1;

        if ($beanU->puestousuario_c == 53 && empty($bean->url_originacion_c) && !empty($correo_del_empleado)) {
            $url = $sugar_config['site_UniOn'] . "/api/employee/?email={$correo_del_empleado}";
            //$url = $sugar_config['site_UniOn'] . "/api/employee/?email=jne@uniclick.mx";

            $token = $sugar_config['token_UniOn'];
            $GLOBALS['log']->fatal("correo " . $correo_del_empleado);
            $GLOBALS['log']->fatal("url " . $url, true);
            $GLOBALS['log']->fatal("token " . $token);
            try {
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array("Authorization: Token $token",
                        "Content-type: application/json"));
                $json_response = curl_exec($curl);
                curl_close($curl);
                $response = json_decode($json_response, true);
                $GLOBALS['log']->fatal("Respuesta Union " . print_r($response, true));
                if ($response) {
                    foreach ($response as $key => $value) {
                        $GLOBALS['log']->fatal("Key  " . $key);
                        $GLOBALS['log']->fatal("Value " . $value);
                        if ($key == "code" && $value != "") {
                            $url_originacion = "uniclick.com.mx/{$value}/?id_lead={$bean->id}";
                            $update = "UPDATE leads_cstm SET url_originacion_c='$url_originacion' WHERE id_c='{$bean->id}'";
                            $queryResult = $db->query($update);
                        } else {
                            $GLOBALS['log']->fatal("Error al solicitar código de originación  " . $value);
                        }
                    }
                }
            } catch (Exception $e) {
                error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> : Error: " . $e->getMessage());
                $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> : Error " . $e->getMessage());
            }
        }
    }
}