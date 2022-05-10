<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class depurar_leads extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'depurar_leads' => array(
                'reqType' => 'GET',
                'path' => array('depurar_leads','?'),
                'pathVars' => array('','id'),
                'method' => 'obtenerLeads',
                'shortHelp' => 'Obtener Leads sin llamadas ni reuniones',
            ),
        );
    }

    public function obtenerLeads($api, $args)
    {
        try
        {
            global $db;
            $lead = $args['lead'];
            $carga = $args['carga'];
            $agente = $args['id'];
            $total_rows = <<<SQL
SELECT IFNULL(leads.id,'') id,
IF(leads_cstm.tipo_registro_c=1,'Lead','') tipo_registro_c,
leads_cstm.name_c name_c,
l1_cstm.nombre_completo_c assigned_user_name
FROM leads
LEFT JOIN  users l1 ON leads.assigned_user_id=l1.id AND l1.deleted=0
LEFT JOIN  meetings_leads l2_1 ON leads.id=l2_1.lead_id AND l2_1.deleted=0
LEFT JOIN  meetings l2 ON l2.id=l2_1.meeting_id AND l2.deleted=0
LEFT JOIN  calls_leads l3_1 ON leads.id=l3_1.lead_id AND l3_1.deleted=0
LEFT JOIN  calls l3 ON l3.id=l3_1.call_id AND l3.deleted=0
LEFT JOIN leads_cstm leads_cstm ON leads.id = leads_cstm.id_c
LEFT JOIN users_cstm l1_cstm ON l1.id = l1_cstm.id_c
WHERE ((((coalesce(LENGTH(l2.id), 0) = 0)) AND ((coalesce(LENGTH(l3.id), 0) = 0))))
AND leads.deleted=0
SQL;
            if(!empty($lead)){
                $total_rows .= " AND leads_cstm.name_c LIKE '%{$lead}%'";
            }
            if(!empty($carga)){
                $total_rows .= " AND leads_cstm.nombre_de_cargar_c LIKE '%{$carga}%'";
            }
            if($agente != 'undefined'){
                $total_rows .= " AND leads.assigned_user_id = '{$agente}'";
            }
            $total_rows .= " ORDER BY leads_cstm.name_c ASC";
            $totalResult = $db->query($total_rows);
            $response['total'] = $totalResult->num_rows;
            while($row = $db->fetchByAssoc($totalResult))
            {
                $response['leads'][] = $row;
                $response['full_leads'][] = $row['id'];
            }
            return $response;
        }catch (Exception $e){
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> :  Error: ".$e->getMessage());
        }
    }
}