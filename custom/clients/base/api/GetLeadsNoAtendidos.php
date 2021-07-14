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

                //SEMAFORO 1 = EN TIEMPO - SEMAFORO 0 = ATRASADO
                $query = "SELECT idLead, cuenta, fechaAsignacion, tipo, subtipo, estatus, max(semaforo) semaforo
                FROM (
                    SELECT DISTINCT l.id as idLead, lc.name_c as cuenta, lc.fecha_asignacion_c as fechaAsignacion, lc.tipo_registro_c as tipo, lc.subtipo_registro_c as subtipo, lc.status_management_c as estatus,
                    CASE WHEN la.date_created < DATE_SUB(now(), INTERVAL 10 DAY) THEN 0
                    WHEN la.date_created > DATE_SUB(now(), INTERVAL 10 DAY) THEN 1
                    END AS semaforo
                    FROM leads l
                    INNER JOIN leads_cstm lc ON lc.id_c = l.id AND l.deleted = 0
                    inner join leads_audit la on la.parent_id = l.id
                    where la.field_name='assigned_user_id'
                    and la.after_value_string = l.assigned_user_id
                    AND l.assigned_user_id = '{$id_user}'
                    AND  lc.subtipo_registro_c in (1,2,3)
                    AND (lc.status_management_c = '{$estatusProduct}' or lc.status_management_c is null)
                    AND (lc.contacto_asociado_c = 0 or lc.contacto_asociado_c is null)
                    UNION
                    SELECT DISTINCT l.id as idLead, lc.name_c as cuenta, lc.fecha_asignacion_c as fechaAsignacion, lc.tipo_registro_c as tipo, lc.subtipo_registro_c as subtipo, lc.status_management_c as estatus,
                    CASE WHEN c.date_end < DATE_SUB(now(), INTERVAL 10 DAY) THEN 0
                    WHEN c.date_end > DATE_SUB(now(), INTERVAL 10 DAY) THEN 1
                    END AS semaforo
                    FROM leads l
                    INNER JOIN leads_cstm lc ON lc.id_c = l.id AND l.deleted = 0
                    INNER JOIN calls_leads cl on cl.lead_id = lc.id_c
                    inner join calls c on c.id = cl.call_id AND c.deleted = 0
                    WHERE l.assigned_user_id = '{$id_user}'
                    AND lc.subtipo_registro_c in (1,2,3)
                    AND (lc.status_management_c = '{$estatusProduct}' or lc.status_management_c is null)
                    AND (lc.contacto_asociado_c = 0 or lc.contacto_asociado_c is null)
                    UNION
                    SELECT DISTINCT l.id as idLead, lc.name_c as cuenta, lc.fecha_asignacion_c as fechaAsignacion, lc.tipo_registro_c as tipo, lc.subtipo_registro_c as subtipo, lc.status_management_c as estatus,
                    CASE WHEN m.date_end < DATE_SUB(now(), INTERVAL 10 DAY) THEN 0
                    WHEN m.date_end > DATE_SUB(now(), INTERVAL 10 DAY) THEN 1
                    END AS semaforo
                    FROM leads l
                    INNER JOIN leads_cstm lc ON lc.id_c = l.id AND l.deleted = 0
                    inner join meetings_leads ml on ml.lead_id = lc.id_c
                    inner join meetings m on m.id = ml.meeting_id AND m.deleted = 0
                    WHERE l.assigned_user_id = '{$id_user}'
                    AND lc.subtipo_registro_c in (1,2,3)
                    AND (lc.status_management_c = '{$estatusProduct}' or lc.status_management_c is null)
                    AND (lc.contacto_asociado_c = 0 or lc.contacto_asociado_c is null)
                ) tablaLeads group by idLead, cuenta, fechaAsignacion, tipo, subtipo, estatus
                order by cuenta asc";

                $result = $GLOBALS['db']->query($query);

                while ($row = $GLOBALS['db']->fetchByAssoc($result)) {

                    $records_in['records'][] = array('idLead' => $row['idLead'], 'cuenta' => $row['cuenta'], 'fechaAsignacion' => $row['fechaAsignacion'], 
                    'tipo' => $row['tipo'], 'subtipo' => $row['subtipo'], 'estatus' => $row['estatus'], 'semaforo' => $row['semaforo']);
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
