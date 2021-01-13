<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetLeadsNoAtendidos extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETLeadNoAtendidoAPI' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('GetLeadsNoAtendidos', '?'),
                'pathVars' => array('module', 'estatusProducto'),
                'method' => 'getcstmLeadNoAtendido',
                'shortHelp' => 'Obtiene los Lead con subtipo No Atendido',
            ),
        );
    }
    public function getcstmLeadNoAtendido($api, $args)
    {

        try {

            global $current_user;
            $id_user = $current_user->id;
            $estatusProduct = $args['estatusProducto'];

            $records_in = [];

            if ($estatusProduct != 3) {

                $query = "SELECT DISTINCT l.id as idLead, l.assigned_user_id, lc.name_c as nombre, lc.subtipo_registro_c as subtipo, lc.status_management_c as estatus
                FROM leads l 
                INNER JOIN leads_cstm lc ON lc.id_c = l.id AND l.deleted = 0
                INNER JOIN calls_leads cl on cl.lead_id = lc.id_c
                inner join calls c on c.id = cl.call_id AND c.deleted = 0
                WHERE l.assigned_user_id = '{$id_user}' 
                AND (lc.subtipo_registro_c = 1 OR lc.subtipo_registro_c = 2)  
                AND lc.status_management_c = '{$estatusProduct}'
                AND c.date_end < DATE_SUB(now(), INTERVAL 10 DAY)
                UNION 
                SELECT DISTINCT l.id as idLead, l.assigned_user_id, lc.name_c as nombre, lc.subtipo_registro_c as subtipo, lc.status_management_c as estatus
                FROM leads l 
                INNER JOIN leads_cstm lc ON lc.id_c = l.id AND l.deleted = 0
                inner join meetings_leads ml on ml.lead_id = lc.id_c
                inner join meetings m on m.id = ml.meeting_id AND m.deleted = 0
                WHERE l.assigned_user_id = '{$id_user}' 
                AND (lc.subtipo_registro_c = 1 OR lc.subtipo_registro_c = 2)  
                AND lc.status_management_c = '{$estatusProduct}'
                AND m.date_end < DATE_SUB(now(), INTERVAL 10 DAY)";

                $result = $GLOBALS['db']->query($query);

                while ($row = $GLOBALS['db']->fetchByAssoc($result)) {

                    $records_in['records'][] = array('idLead' => $row['idLead'], 'nombre' => $row['nombre'], 'subtipo' => $row['subtipo'], 'estatus' => $row['estatus']);
                }

            } else {

                $records_in['status'] = '200';
                $records_in['message'] = 'Validar que el estatus del Producto sea Activo o Aplazado';
            }

            return $records_in;
            
        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }
}
