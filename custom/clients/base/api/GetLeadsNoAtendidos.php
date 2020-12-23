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

                $query = "SELECT l.id as idLead, l.assigned_user_id, lc.name_c as nombre, lc.fecha_asignacion_c, lc.subtipo_registro_c as subtipo, 
                lc.status_management_c as estatus, DATEDIFF(now(), fecha_asignacion_c) as días
                FROM leads l
                INNER JOIN leads_cstm lc ON lc.id_c = l.id
                WHERE assigned_user_id = '{$id_user}' AND subtipo_registro_c = 1 
                AND fecha_asignacion_c < DATE_SUB(now(), INTERVAL 10 DAY) 
                AND status_management_c = '{$estatusProduct}'
                AND l.deleted = 0";

                $result = $GLOBALS['db']->query($query);

                while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                    
                    $records_in['records'][] = array('idLead' => $row['idLead'], 'nombre' => $row['nombre'], 'subtipo' => $row['subtipo'], 'estatus' => $row['estatus']);
                }

            } else {

                $records_in['status']='200';
                $records_in['message']='Validar que el estatus del Producto sea Activo o Aplazado';
            }

            return $records_in;

        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }
}
