<?php
class AgentesTelefonicos extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POST_AgentesTelefonicos' => array(
                'reqType' => 'POST',
                'path' => array('AgentesTelefonicos'),
                'pathVars' => array(''),
                'method' => 'AgentesTelefonicos1',
                'shortHelp' => 'Actualia Agentes Telefonicos',
            ),
        );
    }

    public function AgentesTelefonicos1($api, $args)
    {
        global $db;
        global $current_user;
        $user_id = $args['data']['user_id'];
        $reports_to_id = $args['data']['reports_to_id'];
        $equipo_c = $args['data']['equipo_c'];
        $date= TimeDate::getInstance()->nowDb();
        $id_u_audit=create_guid();

        //Validar que exista registro en users_audit, de lo contrario genera el registro
        //Traer el bean de users_audit
        $bean_Audit = BeanFactory::getBean('Users',$user_id);
        $audit_last=$bean_Audit->reports_to_id;
        //$GLOBALS['log']->fatal('>>>>Trae Bean de users_audit<<<<<<<');
        //Condicion para insertar registro, si el reports_to_id actual no es igual al del registro

        if ($reports_to_id != $audit_last){
            //$GLOBALS['log']->fatal('>>>>Genera Insert en users_audit<<<<<<<');
            $sqlInsert="insert into users_audit (id, parent_id, date_created, created_by, field_name, data_type, before_value_string, after_value_string, before_value_text, after_value_text, event_id, date_updated)
                  VALUES ('{$id_u_audit}', '{$user_id}', '{$date}', '{$current_user->id}', 'reports_to_id', 'id', '{$audit_last}', '{$reports_to_id}', '', '', '1', '{$date}')";
            $GLOBALS['db']->query($sqlInsert);

        }
        //Actualiza el registro en users y users_cstm
        $query = "update users a, users_cstm b set a.reports_to_id = '{$reports_to_id}', b.equipo_c = '{$equipo_c}' where a.id = b.id_c and a.id = '{$user_id}'";
        $result = $db->query($query);
		    return $result;
        //$GLOBALS['log']->fatal('Realiza Update en users_cstm');
    }
}
