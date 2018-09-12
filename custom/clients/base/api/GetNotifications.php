<?php
/**
 * Created by AF
 * Date: 2018-07-26
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetNotifications extends SugarApi
{

    /**
     * Registro de todas las rutas para consumir los servicios del API
     *
     */
    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('GetNotifications', '?','?'),
                //endpoint variables
                'pathVars' => array('module', 'id','limit'),
                //method to call
                'method' => 'GetNotificationsFB',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método GET para obtener notificaciones referente a Feedback',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),

        );

    }

    /**
     * Obtiene direcciones relacionadas a una persona
     *
     * Método que obtiene registros de direcciones relacionadas a una persona filtradas por indicador
     *
     * @param array $api
     * @param array $args Array con los par�metros enviados para su procesamiento
     * @return array Direcciones relacionadas
     * @throws SugarApiExceptionInvalidParameter
     */
    public function GetNotificationsFB($api, $args)
    {
        //Recupera variables
        $id = $args['id'];
        $limit = $args['limit'];
        $records_in = array('records' => array());

        //Valida límite de petición
        if ($limit == -1) {
            $limit = 100;
        }

        //Arma consulta a BD
        $query = "SELECT
          n.id,
          n.name,
          n.description,
          n.created_by,
          concat(u.first_name, ' ', u.last_name) as 'created_by_name',
          uc.equipo_c as 'equipo',
          n.assigned_user_id,
          concat(u2.first_name, ' ', u2.last_name) as 'assigned_user_name',
          date(n.date_entered) as 'date_entered'
          FROM notifications n
          left join users u on n.created_by = u.id
          left join users u2 on n.assigned_user_id = u2.id
          left join users_cstm uc on u2.id = uc.id_c
          where n.name like 'FeedBack%' ";
        if ($id != '1') {
            $query .= "and n.assigned_user_id='{$id}'";
        }
        $query .= "order by n.date_entered desc limit {$limit};";

        //Ejecuta petición de consulta
        $result = $GLOBALS['db']->query($query);

        //Arma respuesta
        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $records_in['records'][] = $row;
        }

        //Regresa resultado
        return $records_in;
    }

}

?>
