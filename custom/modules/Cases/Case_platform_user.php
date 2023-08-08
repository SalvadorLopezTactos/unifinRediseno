<?php
class Case_platform_user
{
    public function set_audit_user_platform_case($bean = null, $event = null, $args = null){
        global $app_list_strings;
        global $db;
        //Obtiene la plataforma
        $plataforma=$GLOBALS['service']->platform;
        $lista_plataformas_audit=$app_list_strings['plataformas_habilitadas_auditoria_list'];
        $plataformas_array=array();


        foreach ($lista_plataformas_audit as $clave => $valor) {
           array_push($plataformas_array,$clave);
        }

        /*$GLOBALS['log']->fatal('*********NUEVO LH DE Opps***********');
        $GLOBALS['log']->fatal('PLATAFORMAS HABILITADAS');
        $GLOBALS['log']->fatal(print_r($plataformas_array,true));*/

        //Se establece tabla de auditoria solo para plataformas que existen en la lista plataformas habilitadas para auditoria
        if(in_array($plataforma,$plataformas_array)){

            //Obtiene el usuario relacionado a la plataforma
            $list_platform_user = $app_list_strings['plataforma_usuario_grupo_list'];

            //Obtiene el nombre de usuario dependiendo la plataforma
            $nombre_usuario_gpo=$list_platform_user[$plataforma];

            //Obtiene id del nombre de usuario
            $query_user_gpo="SELECT id FROM users WHERE user_name='{$nombre_usuario_gpo}'";
            $id_user="";
            $resultQueryUserGpo = $db->query($query_user_gpo);
            while ($row = $db->fetchByAssoc($resultQueryUserGpo)){
                $id_user = $row['id'];
            }

            /*$GLOBALS['log']->fatal("ID DE USUARIO DE GRUPO OBTENIDO");
            $GLOBALS['log']->fatal($id_user);*/

            if($id_user!=""){
                $id_u_audit=create_guid();
                $event_id=create_guid();
                $date= TimeDate::getInstance()->nowDb();
                //Establece nuevo registro en tabla de auditoria
                $sqlInsert="INSERT INTO `cases_audit` (`id`,`parent_id`,`date_created`,`created_by`,`field_name`,`data_type`,`before_value_string`,`after_value_string`,`before_value_text`,`after_value_text`,`event_id`,`date_updated`)
                VALUES ('{$id_u_audit}','{$bean->id}','{$date}','{$id_user}','plataforma','varchar','','{$id_user}',NULL,NULL,'{$event_id}',NULL)";

                $db->query($sqlInsert);
            }

        }

    }

}
