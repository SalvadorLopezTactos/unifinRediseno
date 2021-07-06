<?php
class ActualizaGestionLM extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POST_ActualizaGestionLM' => array(
                'reqType' => 'POST',
                'path' => array('ActualizaGestionLM'),
                'pathVars' => array(''),
                'method' => 'actualizaGestionLMFunction',
                'shortHelp' => 'Actualia Agentes Telefonicos',
            ),
        );
    }

    public function actualizaGestionLMFunction($api, $args)
    {
        global $db, $current_user;
        $user_id = isset($args['data']['user_id']) ? $args['data']['user_id'] : '';
        $posicionOperativa = isset($args['data']['posicion_operativa_c']) ? $args['data']['posicion_operativa_c'] : '';
        $limite = isset($args['data']['limite_asignacion_lm_c']) ? $args['data']['limite_asignacion_lm_c'] : '';

        //Actualiza el registro  users_cstm
        $query = "UPDATE users_cstm u set u.posicion_operativa_c = '{$posicionOperativa}', u.limite_asignacion_lm_c = '{$limite}'
        WHERE u.id_c = '{$user_id}'";
        $result = $db->query($query);
        //$GLOBALS['log']->fatal('$query:'. $query);
        return $result;
    }
}
