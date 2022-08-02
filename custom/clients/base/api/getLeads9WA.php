<?php
/**
 * Created by PhpStorm.
 * User: tactos
 * Date: 17/09/20
 * Time: 08:00 PM
 */


class getLeads9WA extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('GetLeads9WA'),
                //endpoint variables
                'pathVars' => array('module'),
                //method to call
                'method' => 'getLeads9WA_method',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método GET para obtener el listado de Leads con usuario asignado 9 -WhatsApp Chattigo para la reasignación. ',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),

            'POSTreAsignarLeads' => array(
                'reqType' => 'POST',
                'path' => array('reAsignarLeads'),
                'pathVars' => array(''),
                'method' => 're_assignedLeads',
                'shortHelp' => 'Reasigna Leads a usuario firmado',
            ),

        );

    }

    public function getLeads9WA_method($api, $args)
    {

        global $db;
        $offset = $args['offset'];
        $records_9Wa = array();
        $record_9Wa = array();
        $busqueda = $args['busqueda'];

        $select_9WA = "select id_c from users_cstm WHERE nombre_completo_c LIKE '%9 - WhatsApp Chattigo%'";
        $results = $db->query($select_9WA);
        $row = $db->fetchByAssoc($results);
        $usr_9WA = $row['id_c'];

        if (!empty($usr_9WA)) {

            /** Todos los registro existentes */
            $selectLeadsPage = "SELECT
  Lead.id,
  cstm.name_c,
  cstm.tipo_registro_c,
  Lead.assigned_user_id,
  cstm.subtipo_registro_c,
  cstm.tipo_subtipo_registro_c,  
  cstm.regimen_fiscal_c,
  Lead.date_modified,
  Users.nombre_completo_c
FROM leads Lead
  INNER JOIN leads_cstm cstm
    ON cstm.id_c = Lead.id
    INNER JOIN users_cstm Users
  ON Users.id_c=Lead.assigned_user_id
WHERE Lead.assigned_user_id = '{$usr_9WA}'";
            if (!empty($busqueda)) {
                $selectLeadsPage .= "AND cstm.name_c LIKE '%{$busqueda}%'";
            }

            $selectLeadsPage .= "AND cstm.subtipo_registro_c != 3
      AND Lead.deleted = 0
      AND cstm.name_c IS NOT NULL
ORDER BY Lead.date_modified DESC;";
            $resPage = $db->query($selectLeadsPage);
            $records_9Wa['Leads_all'] = $resPage->num_rows;


            /**Buscar registro de 20 */
            $selectLeads = "SELECT
  Lead.id,
  cstm.name_c,
  cstm.tipo_registro_c,
  Lead.assigned_user_id,
  cstm.subtipo_registro_c,
  cstm.tipo_subtipo_registro_c,  
  cstm.regimen_fiscal_c,
  Lead.date_modified,
  CONVERT_TZ(Lead.date_modified,'+00:00',@@global.time_zone) 'Fecha',
  Users.nombre_completo_c
FROM leads Lead
  INNER JOIN leads_cstm cstm
    ON cstm.id_c = Lead.id
    INNER JOIN users_cstm Users
  ON Users.id_c=Lead.assigned_user_id
WHERE Lead.assigned_user_id = '{$usr_9WA}'";

            if (!empty($busqueda)) {
                $selectLeads .= "AND cstm.name_c LIKE '%{$busqueda}%'";
            }
            $selectLeads .= "AND cstm.subtipo_registro_c != 3
        AND Lead.deleted = 0
         AND cstm.name_c IS NOT NULL
ORDER BY Lead.date_modified DESC LIMIT 20 OFFSET {$offset}";

            $resultseads = $db->query($selectLeads);
            $records_9Wa['total_leads'] = $resultseads->num_rows;

            while ($row = $db->fetchByAssoc($resultseads)) {
                $id_Lead = $row['id'];
                $name_Lead = $row['name_c'];
                $tipo_registro = $row['tipo_registro_c'];
                $user_assigned = $row['assigned_user_id'];
                $subtipo = $row['subtipo_registro_c'];
                $tiposubtipo_text = $row['tipo_subtipo_registro_c'];
                $reg_fiscal = $row['regimen_fiscal_c'];
                $nombre_user = $row['nombre_completo_c'];
                //$date_modif = $row['date_modified'];
                $d = strtotime($row['Fecha']);
                $date_modif = date("Y-m-d g:i a", $d);

                array_push($record_9Wa, array('id' => "{$id_Lead}", 'name' => "{$name_Lead}", 'type' => "{$tipo_registro}",
                    'user' => "{$nombre_user}", 'subtipo' => "{$subtipo}", 'reg_fiscal' => "{$reg_fiscal}", 'fecha' => "{$date_modif}"));
            }
        }
        else
        {
            $GLOBALS['log']->fatal("No se encontro el id del usuario Chatigo");
        }
        $records_9Wa['leads'] = $record_9Wa;
        $GLOBALS['log']->fatal("WA " . print_r($records_9Wa, true));


        return $records_9Wa;
    }

    public function re_assignedLeads($api, $args)
    {
        global $db, $current_user;
        $records = $args['data']['seleccionados'];

        $GLOBALS['log']->fatal("Leads " . print_r($args['data']['seleccionados'], true));
        $control = 0;
        foreach ($records as $key => $value) {
            $beanLead = BeanFactory::retrieveBean('Leads', $value, array('disable_row_level_security' => true));
            $beanLead->assigned_user_id = $current_user->id;
            try {
                $beanLead->save();

            } catch (Exception $exception) {
                $GLOBALS['log']->fatal("Log --> Error reasignar Leads " . $exception);

            }

            $control++;
        }

        return $exception;
    }

}