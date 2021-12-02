<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetAgenteCP extends SugarApi
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
                'path' => array('GetAgenteCP'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'getAgenteTelCP',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que regresa el id del asesor disponible para asignar un registro en Centro de Prospección',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );
    }

    public function getAgenteTelCP($api, $args)
    {
        try {
            global $db;
            global $current_user;
            $equipoUNICS = $current_user->equipo_c;
            $fechaFin = date('Y-m-d',strtotime('6 weekdays'));  //OBTIENE LA FECHA DE 6 DÍAS HABILES A PARTIR DE LA FECHA ACTUAL
            // $new_assigned_user = "";
            $compania = isset($args['compania']) ? $args['compania'] : '';
            $assigned_list = ($compania=='2') ?  'last_assigned_user_uniclick' : 'last_assigned_user_unifin';
            $query = "SELECT value FROM config WHERE name = '".$assigned_list."'";
            $result = $db->query($query);
            $row = $db->fetchByAssoc($result);
            $last_indice = $row['value'];

            if ($equipoUNICS != "" && $equipoUNICS != "0" && $equipoUNICS!='NoAsignado') {
                $query_asesores = "SELECT id,date_entered from users u INNER JOIN users_cstm uc ON uc.id_c=u.id
                where equipos_c like '%^{$equipoUNICS}^%'
                AND puestousuario_c='27' AND subpuesto_c='3' AND u.status='Active' ORDER BY date_entered ASC ";

            } elseif ($compania == '2') {
                $query_asesores = "SELECT id,date_entered from users u INNER JOIN users_cstm uc ON uc.id_c=u.id
                where puestousuario_c='27' AND subpuesto_c='4' AND u.status='Active' ORDER BY date_entered ASC ";
            } else {
                $query_asesores = "SELECT id,date_entered from users u INNER JOIN users_cstm uc ON uc.id_c=u.id
                where puestousuario_c='27' AND subpuesto_c='3' AND u.status='Active' ORDER BY date_entered ASC ";
            }
            //$GLOBALS['log']->fatal("Consulta asesor: " . $query_asesores);
            //$GLOBALS['log']->fatal("indice asesor: " . $last_indice);
            $result_usr = $db->query($query_asesores);
            while ($row = $db->fetchByAssoc($result_usr)) {
                $users[] = $row['id'];
            }
            $new_indice = $last_indice >= count($users) - 1 ? 0 : $last_indice + 1;
            // $new_assigned_user = $users[$new_indice];
            //Actualiza indice
            $update = "update config set value='".$new_indice."' where name = '".$assigned_list."';";
            $resultU = $db->query($update);
            $new_assigned_user = ["idAsesor" => $users[$new_indice], "fechaFin" => $fechaFin];

            return $new_assigned_user;

        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }
}
