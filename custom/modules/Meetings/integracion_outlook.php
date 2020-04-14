<?php
/**
 * Created by Adrian Arauz.
 * User: root
 * Date: 31/03/20
 * Time: 11:55 AM

* Funcionalidad: Integración SugarCRM - OneDrive
* 1.- Crear reunion solo desde Mobile
* 2.- Hacer primera peticion para obtener el ID outlook del usuario
* 3.- Crear evento
* 4.- Actualizar evento
*/
class Integration_Mobile
{
    function envia_graph($bean=null, $event=null, $args=null)
    {
        global $db;

        $plataforma=$GLOBALS['service']->platform;
        $beanUser = BeanFactory::getBean('Users', $bean->assigned_user_id);
        $id_outlook="";
            //Valida que la plataforma sea movil y que el usuario tenga el producto Uniclick.
        if (($plataforma=='mobile' && $beanUser->tipodeproducto_c=='8')||($beanUser->tipodeproducto_c=='8' && $bean->outlook_id!="")) {
            $GLOBALS['log']->fatal('Inicia proceso Outlook');
            //Recupera información sobre configuración de Outlook
            $one_drive_settings = Integration_Mobile::get_one_drive_config();
            //Pregunta sobre Token existente
            if (empty($one_drive_settings['token']) || empty($one_drive_settings['expire_in'])) {
                //Genera nuevo Token
                $one_drive_settings = Integration_Mobile::get_token($one_drive_settings);
                $GLOBALS['log']->fatal('Obtuvo token :' .$one_drive_settings['token']);
            }elseif(!empty($one_drive_settings['expire_in'])){
                //Evalua fecha de vigencia
                $date_db = $one_drive_settings['expire_in'];
                $date_end = $date_db." - 5 minute";
                $date_expire_in=date_create($date_end);
                $now = new DateTime();
                if ($now >= $date_expire_in) {
                    //Genera nuevo Token
                    $one_drive_settings = Integration_Mobile::get_token($one_drive_settings);
                }
            }
            //Petición para obtener el id del usuario
            if (!empty($one_drive_settings['token'])) {
                 //Genera petición para obtener el id del usuario en outlook
                $id_user_graph = Integration_Mobile::user_graph($one_drive_settings,$bean);
                $id_outlook=$id_user_graph['id'];
                $GLOBALS['log']->fatal('El id Outlook del usuario es: '.$id_outlook);
            }
            if (!empty($id_outlook)){
                if ($bean->outlook_id=="") {
                    //Crea evento (invoca funcion create_event)
                    $create_event_graph = Integration_Mobile::create_event($one_drive_settings, $id_outlook, $bean);
                    if (!empty($create_event_graph['id'])){
                        //Guarda el id de la reunion en el campo outlook_id de meetings
                        $GLOBALS['log']->fatal('Realiza update para guardar id de outlook en meetings');
                        $Update = "update meetings set outlook_id = '{$create_event_graph['id']}' where id = '{$bean->id}'";
                        $Result = $db->query($Update);
                        $GLOBALS['log']->fatal('Evento Creado satisfactoriamente');
                    }
                }else{
                    //Actualiza evento a traves de tener un id outlook en meetings (outlook_id)
                    Integration_Mobile::update_event($bean, $id_outlook,$one_drive_settings);
                    $GLOBALS['log']->fatal('Realiza actualización del evento');
                }
            }
            //Termina proceso de integración oneDrive
            $GLOBALS['log']->fatal('Termina proceso de integración Outlook');
        }
    }
        //Funcion para obtener info de config->MGraph para generar token
    function get_one_drive_config()
    {
        //Define arreglo de configuración
        $one_drive_settings = array();
        $one_drive_settings['token']="";
        $one_drive_settings['expire_in']="";
        $one_drive_settings['tenant_id']="";
        $one_drive_settings['client_id']="";
        $one_drive_settings['client_secret']="";

        //Recupera información de instancia OneDrive
        global $db;
        $one_drive_query = "select * from config where category = 'MGraph';";
        $queryResult = $db->query($one_drive_query);
        while ($row = $db->fetchByAssoc($queryResult)) {
            switch ($row['name']) {
                case "token":
                    $one_drive_settings['token']=$row['value'];
                    break;
                case "expire_in":
                    $one_drive_settings['expire_in']=$row['value'];
                    break;
                case "tenant_id":
                    $one_drive_settings['tenant_id']=$row['value'];
                    break;
                case "client_id":
                    $one_drive_settings['client_id']=$row['value'];
                    break;
                case "client_secret":
                    $one_drive_settings['client_secret']=$row['value'];
                    break;
            }
        }
        //Regresa configuración
        return $one_drive_settings;
    }

    function get_token($one_drive_settings)
    {
        //Arma petición para token
        global $db,$current_user;
        $uri = 'https://login.microsoftonline.com/'.$one_drive_settings['tenant_id'].'/oauth2/v2.0/token';
        $data = 'grant_type=client_credentials&client_id='.$one_drive_settings['client_id'].'&client_secret='.$one_drive_settings['client_secret'].'&scope=https%3A%2F%2Fgraph.microsoft.com%2F.default';
        //$GLOBALS['log']->fatal($uri);
        //$GLOBALS['log']->fatal($data);
        try{
            //Inicializa curl
            $ch = curl_init();
            //Set variables
            curl_setopt($ch, CURLOPT_URL,$uri);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //Ejecuta solicitud
            $result = curl_exec ($ch);
            //Cierra curl y regresa resultado
            curl_close ($ch);
            $result = json_decode($result, true);
            //$GLOBALS['log']->fatal($result);

            //Guarda resultado en config
            $now = new DateTime();
            $now = date_modify($now, "+1 hour");
            $one_drive_settings['token']=$result['access_token'];
            $one_drive_settings['expire_in']=$now->format('Y-m-d H:i:s');
            $update_toke = "update config set value='{$one_drive_settings['token']}' where category='MGraph' and name='token'";
            $update_expired = "update config set value='{$one_drive_settings['expire_in']}' where category='MGraph' and name='expire_in'";
            $update_by = "update config set value='{$current_user->user_name}' where category='MGraph' and name='generated_by'";
            $update_in = "update config set value='{$now->format('Y-m-d H:i:s')}' where category='MGraph' and name='generated_in'";
            $resultado_token = $db->query($update_toke);
            $resultado_expired = $db->query($update_expired);
            $resultado_by = $db->query($update_by);
            $resultado_in = $db->query($update_in);
        } catch
        (Exception $e) {
            //$GLOBALS['log']->fatal('LH: send_oneDrive - Error token: '. $e->getMessage());
        }
        //Regresa token
        return $one_drive_settings;
    }

    function user_graph($one_drive_settings, $beanReunion)
    {
        //Arma petición para obtener el ID del usuario que está creando la reunión
        //Variable para obtener el correo del usuario
        $beanUser = BeanFactory::getBean('Users', $beanReunion->assigned_user_id);
        $id_user= $beanUser->email1;
        //Variable para guardar el token
        $usr_token= $one_drive_settings['token'];
        $uri = 'https://graph.microsoft.com/v1.0/users/'.$id_user;
        $GLOBALS['log']->fatal($uri);
        //$GLOBALS['log']->fatal('Integracion CRM-Outlook: Peticion para id user');
        //Inicializa curl
        $ch = curl_init();
        //Set variables
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_URL,$uri);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$usr_token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Ejecuta solicitud
        $result = curl_exec ($ch);
        //Cierra curl y regresa resultado
        curl_close ($ch);
        //$GLOBALS['log']->fatal($result);
        //$GLOBALS['log']->fatal('1-2.Sale funcion user_graph');
        return json_decode($result, true);

    }

    function create_event($one_drive_settings, $id_outlook,$beanReunion)
    {
        $GLOBALS['log']->fatal('ID reunion para crear evento: '.$beanReunion->id);
        if (!empty($beanReunion->id)) {

            //Arma petición para crear evento
            $uri = 'https://graph.microsoft.com/v1.0/users/' . $id_outlook . '/events';
            //$GLOBALS['log']->fatal('2.-Se crea URL para crear Evento: ' . $uri);
            //$GLOBALS['log']->fatal('2.-Inicia CURL');
            //Inicializa curl
            $ch = curl_init();

            //Condicion para calcular el recordatorio a la reunion
            if($beanReunion->reminder_time==-1){
                $beanReunion->reminder_time=-1;
            }else{
                $beanReunion->reminder_time= $beanReunion->reminder_time/ 60;
            }

            //Array con los valores de la reunion para el evento
            $info_meeting = array(
                'subject' => $beanReunion->name,
                'reminderMinutesBeforeStart' => $beanReunion->reminder_time,
                'body' => array(
                    'contentType' => 'HTML',
                    'content' => $beanReunion->description
                ),
                'start' => array(
                    'dateTime' => $beanReunion->date_start,
                    'timeZone' => 'America/Mexico_City'
                ),
                'end' => array(
                    'dateTime' => $beanReunion->date_end,
                    'timeZone' => 'America/Mexico_City'
                ),
                'location' => array(
                    'displayName' => $beanReunion->location
                ),
            );

            $payload = json_encode($info_meeting);
            //$GLOBALS['log']->fatal('Imprime Paylod: '.$payload);
            //Set variables
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_URL, $uri);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $one_drive_settings['token'], 'Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //Ejecuta solicitud
            $create_event_ok = curl_exec($ch);
            //Cierra curl y regresa resultado
            curl_close($ch);
            //$GLOBALS['log']->fatal($create_event_ok);
            return json_decode($create_event_ok, true);
        }
    }

    function update_event($beanReunion, $id_outlook,$one_drive_settings){
        //Se ejecuta para edición de registros existentes:
        global $db;
                $idevent=$beanReunion->outlook_id;
                //Arma petición para actualizar evento
                $uri = 'https://graph.microsoft.com/v1.0/users/' . $id_outlook . '/events/'.$idevent;
                //Inicializa curl
                $ch = curl_init();
                //$GLOBALS['log']->fatal('2.-Inicia CURL UPDATE');
                $GLOBALS['log']->fatal('URL para UPDATE: '.$uri);


                //Condicion para calcular el recordatorio a la reunion
                if($beanReunion->reminder_time==-1){
                    $beanReunion->reminder_time=-1;
                }else{
                    $beanReunion->reminder_time= $beanReunion->reminder_time/ 60;
                }

                //Array con los valores de la reunion para el evento
                $info_meeting = array(
                    'subject' => $beanReunion->name,
                    'reminderMinutesBeforeStart' => $beanReunion->reminder_time,
                    'body' => array(
                        'contentType' => 'HTML',
                        'content' => $beanReunion->description
                    ),
                    'start' => array(
                        'dateTime' => $beanReunion->date_start,
                        'timeZone' => 'America/Mexico_City'
                    ),
                    'end' => array(
                        'dateTime' => $beanReunion->date_end,
                        'timeZone' => 'America/Mexico_City'
                    ),
                    'location' => array(
                        'displayName' => $beanReunion->location
                    ),
                );

                $payload = json_encode($info_meeting);
                //$GLOBALS['log']->fatal('Imprime Paylod UPDATE: '.$payload);
                //Set variables
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
                curl_setopt($ch, CURLOPT_URL, $uri);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $one_drive_settings['token'], 'Content-Type:application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                //Ejecuta solicitud
                $update_event_ok = curl_exec($ch);
                $GLOBALS['log']->fatal('Ejecuta patch en evento Outlook');
                //Cierra curl y regresa resultado
                curl_close($ch);
                //$GLOBALS['log']->fatal($update_event_ok);
                return json_decode($update_event_ok, true);
    }

}
