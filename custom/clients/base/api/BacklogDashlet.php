<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 3/2/2016
 * Time: 4:00 PM
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
include_once('modules/ACLRoles/ACLRole.php');

require_once('include/export_utils.php');
require_once("custom/Levementum/UnifinAPI.php");
class BacklogDashlet extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POST_BacklogDashlet' => array(
                'reqType' => 'POST',
                'path' => array('BacklogDashlet'),
                'pathVars' => array(''),
                'method' => 'getBacklogInfo',
                'shortHelp' => 'Dashlet de Backlog',
            ),

            'POST_BacklogComentarios' => array(
                'reqType' => 'POST',
                'path' => array('BacklogComentarios'),
                'pathVars' => array(''),
                'method' => 'setBacklogComment',
                'shortHelp' => 'Agregar o editar comentarios de Backlog',
            ),

            'POST_BacklogCancelar' => array(
                'reqType' => 'POST',
                'path' => array('BacklogCancelar'),
                'pathVars' => array(''),
                'method' => 'cancelaBacklog',
                'shortHelp' => 'Cancela Backlog',
            ),

            'POST_RevivirBacklog' => array(
                'reqType' => 'POST',
                'path' => array('RevivirBacklog'),
                'pathVars' => array(''),
                'method' => 'RevivirBacklog',
                'shortHelp' => 'Crea un nuevo Backlog a partir de uno cancelado',
            ),

            'POST_MoverOperacion' => array(
                'reqType' => 'POST',
                'path' => array('MoverOperacion'),
                'pathVars' => array(''),
                'method' => 'moverOperacionBacklog',
                'shortHelp' => 'Mover Operacion en Backlog',
            ),

            'POST_OperacionLograda' => array(
                'reqType' => 'POST',
                'path' => array('OperacionLograda'),
                'pathVars' => array(''),
                'method' => 'operacionLogradaBacklog',
                'shortHelp' => 'operacion Lograda Backlog',
            ),

            'POST_CrearArchivoCSV' => array(
                'reqType' => 'POST',
                'path' => array('CrearArchivoCSV'),
                'pathVars' => array(''),
                'method' => 'crearArchivoCSVBacklog',
                'shortHelp' => 'Crear Archivo CSV para Backlog',
            ),

            'POST_MassUpdateCount' => array(
                'reqType' => 'POST',
                'path' => array('MassUpdateCount'),
                'pathVars' => array(''),
                'method' => 'contarRegistrosSeleccionados',
                'shortHelp' => 'contar Registros Seleccionados',
            ),

            'POST_MassComprometer' => array(
                'reqType' => 'POST',
                'path' => array('MassComprometer'),
                'pathVars' => array(''),
                'method' => 'comprometerBacklogMass',
                'shortHelp' => 'comprometer Backlog Massivamente',
            ),

            'POST_BacklogPromotores' => array(
                'reqType' => 'POST',
                'path' => array('BacklogPromotores'),
                'pathVars' => array(''),
                'method' => 'getPromotores',
                'shortHelp' => 'forma el filtro de promotores en el Backlog Dashlet',
            ),

            'POST_BacklogEquipos' => array(
                'reqType' => 'POST',
                'path' => array('BacklogEquipos'),
                'pathVars' => array(''),
                'method' => 'getEquipos',
                'shortHelp' => 'forma el filtro de equipos en el Backlog Dashlet',
            ),

            'POST_BacklogColumns' => array(
                'reqType' => 'POST',
                'path' => array('BacklogColumns'),
                'pathVars' => array(''),
                'method' => 'setColumns',
                'shortHelp' => 'guarda el set de columnas que el usuario quiere ver en su sesion',
            ),

            'POST_ObtenerBacklogColumnas' => array(
                'reqType' => 'POST',
                'path' => array('ObtenerBacklogColumnas'),
                'pathVars' => array(''),
                'method' => 'getColumnas',
                'shortHelp' => 'trae el set de columnas que el usurio quiere ver en su sesion',
            ),
            'POST_UpdateFechaBl' => array(
                'reqType' => 'POST',
                'path' => array('UpdateFechaBl'),
                'pathVars' => array(''),
                'method' => 'UpdateFechaBl',
                'shortHelp' => 'envia la nueva informacion a Uni2 de los BL que se estan moviendo',
            ),
        );
    }

    public function getBacklogInfo($api, $args)
    {
        global $current_user, $db;
        $EquiposVisibles = '';

        $mes_filtro = $args['data']['mes'];
        $anio_filtro = $args['data']['anio'];
        $region_filtro = $args['data']['region'];
        $tipo_de_operacion_filtro = $args['data']['tipo_operacion'];
        $etapa_filtro = $args['data']['etapa'];
        $estatus_filtro = $args['data']['estatus'];
        $equipo_filtro = $args['data']['equipo'];
        $promotor_filtro = $args['data']['promotor'];
        $progreso = $args['data']['progreso'];
        $sortBy = $args['data']['sortBy'];
        $sortByDireccion = $args['data']['sortByDireccion'];

        $query = <<<SQL
SELECT r.name FROM acl_roles r
INNER JOIN acl_roles_users ru ON ru.role_id = r.id AND ru.deleted = 0
WHERE ru.user_id = '{$current_user->id}' AND r.name = 'Backlog'
SQL;
        $rolResult = $db->getone($query);
        if(!empty($rolResult)){
            //Obtiene los equipos que puede ver en caso de ser BO
            $query = <<<SQL
            SELECT replace(replace(usr.equipos_c,'^',''),',',''',''') equipos
FROM acl_roles r
INNER JOIN acl_roles_users ru ON ru.role_id = r.id AND ru.deleted = 0
INNER JOIN users_cstm usr on usr.id_c = ru.user_id
WHERE r.name in ('Backlog-BO')
            and ru.user_id = '{$current_user->id}'
SQL;
            $EquiposVisibles = $db->getone($query);

            $response['backlogs']['MyBacklogs'] = $this->backlogsArray($current_user->id, $mes_filtro, $anio_filtro, $region_filtro, $tipo_de_operacion_filtro, $etapa_filtro, $estatus_filtro, $equipo_filtro, $rolResult, $promotor_filtro, $progreso, $EquiposVisibles, $sortBy, $sortByDireccion);
            $response['backlogs']['totales'] = $this->backlogTotalsArray($response['backlogs']);
            $response['backlogs']['RoleView'] = 'Full_Access';
        }else {
            $response['backlogs']['MyBacklogs'] = $this->backlogsArray($current_user->id, $mes_filtro, $anio_filtro, $region_filtro, $tipo_de_operacion_filtro, $etapa_filtro, $estatus_filtro, $equipo_filtro, "", $promotor_filtro, $progreso, $EquiposVisibles, $sortBy, $sortByDireccion);
            $response['backlogs']['totales'] = $this->backlogTotalsArray($response['backlogs']);
            $response['backlogs']['RoleView'] = 'hierarchy';

            if(empty($promotor_filtro) || $promotor_filtro == 'Todos') {
                //Get Subordinados
                foreach ($args['data']['subordinados'] as $index => $subordinado) {
                    $sub_backlog = $this->backlogsArray($subordinado['metadata']['id'], $mes_filtro, $anio_filtro, $region_filtro, $tipo_de_operacion_filtro, $etapa_filtro, $estatus_filtro, $equipo_filtro, "" , "", $progreso, $EquiposVisibles, $sortBy, $sortByDireccion);
                    if (!empty($sub_backlog)) {
                        $response['backlogs']['SubBacklogs'][] = $sub_backlog;
                        $response['backlogs']['totales'] = $this->backlogTotalsArray($response['backlogs']);
                    }
                    if (!empty($subordinado['children'])) {
                        $response['backlogs']['Children'][] = $this->getChildren($subordinado['children'], $mes_filtro, $anio_filtro, $region_filtro, $tipo_de_operacion_filtro, $etapa_filtro, $estatus_filtro, $equipo_filtro, "", "", $progreso, $EquiposVisibles, $sortBy, $sortByDireccion);
                        $response['backlogs']['totales'] = $this->backlogTotalsArray($response['backlogs']);
                    }
                }
            }
        }

        $query = <<<SQL
SELECT r.name FROM acl_roles r
INNER JOIN acl_roles_users ru ON ru.role_id = r.id AND ru.deleted = 0
WHERE ru.user_id = '{$current_user->id}' AND r.name = 'Backlog-DGA'
SQL;
        $rolResult = $db->getone($query);
        if(!empty($rolResult)){
            $response['backlogs']['RolAutorizacion'] = 'DGA';
        }else{
            $query = <<<SQL
SELECT r.name FROM acl_roles r
INNER JOIN acl_roles_users ru ON ru.role_id = r.id AND ru.deleted = 0
WHERE ru.user_id = '{$current_user->id}' AND r.name = 'Backlog-Direccion'
SQL;
            $rolResult = $db->getone($query);
            if(!empty($rolResult)){
                $response['backlogs']['RolAutorizacion'] = 'Direccion';
            }else{
                $response['backlogs']['RolAutorizacion'] = 'Promotor';
            }
        }
        return $response;
    }

    public function getChildren($children, $mes_filtro, $anio_filtro, $region_filtro, $tipo_de_operacion_filtro, $etapa_filtro, $estatus_filtro, $equipo_filtro, $role = null, $progreso = null, $EquiposVisibles = null, $sortBy, $sortByDireccion) //recursion
    {
        foreach ($children as $child) {
            $sub_backlog[] = $this->backlogsArray($child['metadata']['id'], $mes_filtro, $anio_filtro, $region_filtro, $tipo_de_operacion_filtro, $etapa_filtro, $estatus_filtro, $equipo_filtro, "", "", $progreso, $EquiposVisibles, $sortBy, $sortByDireccion);
            if(!empty($sub_backlog)){
                $response = $sub_backlog;
            }

            if (!empty($child['children'])) {
                $this->getChildren($child['children'], $mes_filtro, $anio_filtro, $region_filtro, $tipo_de_operacion_filtro, $etapa_filtro, $estatus_filtro, $equipo_filtro, "", "", $progreso, "", $sortBy, $sortByDireccion);
            }
        }
        return $response;
    }

    public function matchListLabel($db_val, $lista){
        global $app_list_strings;

        $list = array();
        if (isset($app_list_strings[$lista]))
        {
            $list = $app_list_strings[$lista];
        }

        foreach($list as $key=>$value){
            if($key == $db_val){
                $match_val = $value;
            }
        }
        if($match_val != ''){
            return $match_val;
        }else{
            return $db_val;
        }
    }

    public function backlogsArray($user_id, $mes, $anio, $region, $tipo_de_operacion, $etapa, $estatus, $equipo, $role = null, $promotor = null, $progreso = null, $EquiposVisibles = null, $sortBy = null, $sortByDireccion = null){

        global $db;
        /*if(empty($etapa)){
            $etapa = '';
        }else{
            $etapa = array_filter($etapa);
            if(!empty($etapa)){
                if(count($etapa) <= 1){
                    $etapa = implode("", $etapa);
                }else{
                    $etapa = implode(",", $etapa);
                }
            }
        }*/

        $query = <<<SQL
SELECT lb.*,IFNULL(blcs.monto_final_comprometido_c,0) AS monto_final_comprometido, IFNULL(blcs.ri_final_comprometida_c,0) AS ri_final_comprometida,
a.name AS account_name, CONCAT(u.first_name, " " , u.last_name) AS promotor, lb.equipo AS equipo_c, o.id AS oportunityId,
case when lb.description = '' then 'fa-comment-o' when lb.description is null then 'fa-comment-o' else 'fa-comment' end as comentado,
case when lb.estatus_de_la_operacion = 'Cancelada' then '#FF6666'  when lb.estatus_de_la_operacion = 'Comprometida' then '#E5FFCC' else '#FFFFFF' end as color,
case lb.equipo when '1' then 1 when '2' then 2 when '3' then 3 when '4' then 4 when '5' then 5 when '6' then 6 when '7' then 7 when '8' then 8 when '9' then 9
when 'MTY' then 10 when 'HER' then 11 when 'CHI' then 12 when 'GDL' then 13 when 'QRO' then 14 when 'LEO' then 15
when 'PUE' then 16 when 'VER' then 17  when 'CUN' then 18 when 'CAN' then 18 when 'MER' then 19 when 'TOL' then 20 when 'CASA' then 21 else 50 end AS ordenEquipo,
case lb.estatus_de_la_operacion when 'Comprometida' then 1 when 'Cancelada' then 2 when 'Activa' then 3
when 'Enviada a otro mes' then 4 when 'Enviada a otro mes - Autom�tico' then 5 when 'Cancelada por cliente' then 6 else 10 end as ordenEstatus,
uc.iniciales_c AS iniciales, IFNULL(blcs.monto_activado_anticipado_c,0) AS monto_anticipado, IFNULL(blcs.ri_activada_anticipada_c,0) AS ri_anticipada,
IFNULL(monto_disp_vencido_c,0) disp_vencido, acc.idcliente_c idcliente, monto_prospecto_c, monto_credito_c, monto_rechazado_c, monto_sin_solicitud_c, monto_con_solicitud_c,
ri_prospecto_c, ri_credito_c, ri_rechazada_c, ri_sin_solicitud_c, ri_con_solicitud_c,
CASE WHEN lb.estatus_de_la_operacion = 'Cancelada' THEN 0 ELSE
0 + /*CASE '{$etapa}' WHEN '' THEN */ monto_prospecto_c + monto_credito_c + monto_rechazado_c + monto_sin_solicitud_c + monto_con_solicitud_c /*ELSE
    CASE WHEN '{$etapa}' LIKE '%Prospecto%' THEN  monto_prospecto_c ELSE 0 END
  + CASE WHEN '{$etapa}' LIKE '%Credito%' THEN  monto_credito_c     ELSE 0 END
  + CASE WHEN '{$etapa}' LIKE '%Rechazada%' THEN  monto_rechazado_c ELSE 0 END
  + CASE WHEN '{$etapa}' LIKE '%AutorizadaSinSolicitud%'  THEN  monto_sin_solicitud_c ELSE 0 END
  + CASE WHEN '{$etapa}' LIKE '%AutorizadaConSolicitud%' THEN  monto_con_solicitud_c  ELSE 0 END  END*/  END AS bl_actual,
tasa_c, comision_c, dif_residuales_c, monto_pipeline_posterior_c
FROM lev_backlog lb
INNER JOIN lev_backlog_cstm blcs ON blcs.id_c = lb.id
INNER JOIN accounts a ON a.id = lb.account_id_c AND a.deleted = 0
INNER JOIN accounts_cstm acc ON a.id = acc.id_c
INNER JOIN users u ON u.id = lb.assigned_user_id AND u.deleted = 0 /*AND u.status = 'Active'*/
INNER JOIN users_cstm uc ON uc.id_c = lb.assigned_user_id
LEFT JOIN lev_backlog_opportunities_c lbo ON lbo.lev_backlog_opportunitieslev_backlog_idb = lb.id AND lbo.deleted = 0
LEFT JOIN opportunities o ON o.id = lbo.lev_backlog_opportunitiesopportunities_ida AND o.deleted = 0
WHERE lb.deleted = 0
SQL;

        if ($role != "Backlog") {
            if(!empty($promotor) && $promotor != 'Todos'){
                $query .= " AND lb.assigned_user_id = '{$promotor}' ";
            }else{
                $query .= " AND lb.assigned_user_id = '{$user_id}' ";
            }
        }else{
            if(!empty($EquiposVisibles) || $EquiposVisibles != ''){
                $query .= " AND lb.equipo in ('{$EquiposVisibles}') ";
            }

            if(!empty($promotor) && $promotor != 'Todos') {
                $query .= " AND lb.assigned_user_id = '{$promotor}' ";
            }
        }

        if(!empty($mes) && $mes != "Todos"){
            $query .= " AND lb.mes = {$mes}";
        }

        if(!empty($anio)){
            $query .= " AND lb.anio = {$anio}";
        }

        if(!empty($region)){
            $query .= " AND lb.region = '{$region}'";
        }

        if(!empty($tipo_de_operacion)){
            $query .= " AND lb.tipo_de_operacion = '{$tipo_de_operacion}'";
        }

        if(!empty($etapa)){
            $query .= " AND lb.etapa = '{$etapa}'";
        }

        $estatus = array_filter($estatus);
        if(!empty($estatus)){
            if(count($estatus) <= 1){
                $estatus = "'" . implode("", $estatus). "'";
            }else{
                $estatus = "'" . implode("','", $estatus). "'";
            }
            $query .= " AND lb.estatus_de_la_operacion IN ({$estatus})";
        }

        if(!empty($equipo) && $equipo != "Todos"){
            $query .= " AND lb.equipo = '{$equipo}'";
        }

        if(!empty($progreso)){
            $query .= " AND lb.progreso = '{$progreso}'";
        }

        if(!empty($sortBy)){
            $query .= " ORDER BY  {$sortBy} {$sortByDireccion}";
        }else{
            $query .= " ORDER BY  ordenEstatus, ordenEquipo, uc.iniciales_c, lb.monto_comprometido desc";
        }


        $queryResult = $db->query($query);
        while ($row = $db->fetchByAssoc($queryResult)) {
            $response['linea'][$row['id']]['estatus_de_la_operacion'] = $row['estatus_de_la_operacion'];
            $response['linea'][$row['id']]['mesanio'] = substr ($this->matchListLabel($row['mes'], "mes_list"),0,3)."-".substr ($row['anio'],2,2);
            $response['linea'][$row['id']]['mes'] = substr ($this->matchListLabel($row['mes'], "mes_list"),0,3);
            $response['linea'][$row['id']]['equipo'] = $row['equipo_c'];
            $response['linea'][$row['id']]['zona'] = $row['region'];
            $response['linea'][$row['id']]['iniciales'] = $row['iniciales'];
            $response['linea'][$row['id']]['promotor'] = $row['promotor'];
            $response['linea'][$row['id']]['idcliente'] = $row['idcliente'];
            $response['linea'][$row['id']]['cliente'] = $row['account_name'];
            $response['linea'][$row['id']]['numero_de_backlog'] = $row['numero_de_backlog'];

            $activos = str_replace("^", "", $row['activo']);
            $activos = explode(",", $activos);

            foreach ($activos as $key => $values){
                $response['linea'][$row['id']]['tipo_bien'] .= $this->matchListLabel($values, "idactivo_list") . " ";
            }
            if (empty($row['monto_original']) || $row['monto_original'] == 0 || $row['monto_original'] == null){
                $response['linea'][$row['id']]['monto_original'] = $row['disp_vencido'];
                $response['linea'][$row['id']]['colorDispLinea'] = '#999999';

            }else{
                $response['linea'][$row['id']]['monto_original'] = $row['monto_original'];
                $response['linea'][$row['id']]['colorDispLinea'] = '#99CCFF';
            }

            $response['linea'][$row['id']]['monto_comprometido'] = $row['monto_comprometido'];
            $response['linea'][$row['id']]['ri_comprometida'] = $row['renta_inicial_comprometida'];
            if(empty($row['monto_final_comprometido']) || $row['monto_final_comprometido'] == 0 || $row['monto_final_comprometido'] == null){
                $response['linea'][$row['id']]['monto_diferencia'] = 0;
            }else{
                $response['linea'][$row['id']]['monto_diferencia'] = $row['monto_final_comprometido'] - $row['monto_comprometido'];
            }

            $response['linea'][$row['id']]['monto_final_comprometido'] = $row['monto_final_comprometido'];
            $response['linea'][$row['id']]['ri_final_comprometida'] = $row['ri_final_comprometida'];
            $response['linea'][$row['id']]['bl_actual'] = $row['bl_actual'];

            $response['linea'][$row['id']]['monto_real'] = $row['monto_real_logrado'];
            /*if(empty($row['monto_real_logrado']) || $row['monto_real_logrado'] == 0 || $row['monto_real_logrado'] == null){
                $response['linea'][$row['id']]['monto_real'] = $row['monto_real_logrado'];
            }else{
                $response['linea'][$row['id']]['monto_real'] = $row['monto_real_logrado'] - $row['monto_anticipado'];
            }*/
            $response['linea'][$row['id']]['renta_real'] = $row['renta_inicial_real'];
            /*
            if(empty($row['renta_inicial_real']) || $row['renta_inicial_real'] == 0 || $row['renta_inicial_real'] == null){

            }else{
                $response['linea'][$row['id']]['renta_real'] = $row['renta_inicial_real'] - $row['ri_anticipada'];
            }*/

            $response['linea'][$row['id']]['monto_cancelado'] = $row['monto_comprometido_cancelado'];
            $response['linea'][$row['id']]['ri_cancelada'] = $row['renta_inicialcomp_can'];
            $response['linea'][$row['id']]['tipo_operacion'] = $row['tipo_de_operacion'];
            $response['linea'][$row['id']]['etapa_preliminar'] = $this->matchListLabel($row['etapa_preliminar'], "estatus_c_operacion_list");
            $response['linea'][$row['id']]['etapa'] = $this->matchListLabel($row['etapa'], "estatus_c_operacion_list");
            $response['linea'][$row['id']]['progreso'] = $this->matchListLabel($row['progreso'], "progreso_list");

            if($row['estatus_de_la_operacion'] == "Comprometida"){
                $response['linea'][$row['id']]['estatus_checked'] = "checked";
                $response['linea'][$row['id']]['mass_checked'] = "disabled";
            }

            if(empty($row['monto_comprometido']) || $row['monto_comprometido'] == 0 || $row['monto_comprometido'] == null){
                $response['linea'][$row['id']]['mass_checked'] = "disabled";
            }

            $response['linea'][$row['id']]['monto_prospecto'] = $row['monto_prospecto_c'];
            $response['linea'][$row['id']]['monto_credito'] = $row['monto_credito_c'];
            $response['linea'][$row['id']]['monto_rechazado'] = $row['monto_rechazado_c'];
            $response['linea'][$row['id']]['monto_sin_solicitud'] = $row['monto_sin_solicitud_c'];
            $response['linea'][$row['id']]['monto_con_solicitud'] = $row['monto_con_solicitud_c'];
            $response['linea'][$row['id']]['ri_prospecto'] = $row['ri_prospecto_c'];
            $response['linea'][$row['id']]['ri_credito'] = $row['ri_credito_c'];
            $response['linea'][$row['id']]['ri_rechazada'] = $row['ri_rechazada_c'];
            $response['linea'][$row['id']]['ri_sin_solicitud'] = $row['ri_sin_solicitud_c'];
            $response['linea'][$row['id']]['ri_con_solicitud_c'] = $row['ri_con_solicitud_c'];
            $response['linea'][$row['id']]['tasa'] = $row['tasa_c'];
            $response['linea'][$row['id']]['comision'] = $row['comision_c'];
            $response['linea'][$row['id']]['dif_residuales'] = $row['dif_residuales_c'];
            $response['linea'][$row['id']]['pipeline_posterior'] = $row['monto_pipeline_posterior_c'];

            $response['linea'][$row['id']]['name'] = $row['name'];
            $response['linea'][$row['id']]['clienteId'] = $row['account_id_c'];
            $response['linea'][$row['id']]['activo'] = $row['activo'];
            $response['linea'][$row['id']]['oppId'] = $row['oportunityId'];
            $response['linea'][$row['id']]['mes_int'] = $row['mes'];
            $response['linea'][$row['id']]['anio'] = substr ($row['anio'],2,2);
            $response['linea'][$row['id']]['comentarios'] = $row['description'];
            $response['linea'][$row['id']]['No_Solicitud'] = $row['numero_de_solicitud'];
            $response['linea'][$row['id']]['porciento_ri'] = $row['porciento_ri'];
            $response['linea'][$row['id']]['comentado'] = $row['comentado'];
            $response['linea'][$row['id']]['color'] = $row['color'];
        }

        return $response;
    }

    public function backlogTotalsArray($response){

        $total['total_amount'] = 0;
        //$total['renta_inicial'] = 0;

        if(!empty($response['MyBacklogs'])){
            foreach($response['MyBacklogs']['linea'] as $key => $value) {
                //Totales
                $total['total_monto_original'] += $value['monto_original'];
                $total['total_monto_comprometido'] += $value['monto_comprometido'];
                $total['total_monto_real'] += $value['monto_real'];
                $total['total_renta_inicial'] += $value['ri_comprometida'];
                $total['total_renta_real'] += $value['renta_real'];
                $total['total_monto_cancelado'] += $value['monto_cancelado'];
                $total['total_ri_cancelada'] += $value['ri_cancelada'];
                $total['total_monto_diferencia'] += $value['monto_diferencia'];
                $total['total_monto_final_comprometido'] += $value['monto_final_comprometido'];
                $total['total_renta_inicial_final'] += $value['ri_final_comprometida'];
                $total['total_bl_actual'] += $value['bl_actual'];
                $total['total_pipeline_posterior'] += $value['pipeline_posterior'];
            }
        }

        if(!empty($response['SubBacklogs'])){
            foreach($response['SubBacklogs'] as $key => $value) {
                foreach($value as $index => $linea){
                    foreach($linea as $field => $amount){
                        //Totales
                        $total['total_monto_original'] += $amount['monto_original'];
                        $total['total_monto_comprometido'] += $amount['monto_comprometido'];
                        $total['total_monto_real'] += $amount['monto_real'];
                        $total['total_renta_inicial'] += $amount['ri_comprometida'];
                        $total['total_renta_real'] += $amount['renta_real'];
                        $total['total_monto_cancelado'] += $amount['monto_cancelado'];
                        $total['total_ri_cancelada'] += $amount['ri_cancelada'];
                        $total['total_monto_diferencia'] += $amount['monto_diferencia'];
                        $total['total_monto_final_comprometido'] += $amount['monto_final_comprometido'];
                        $total['total_renta_inicial_final'] += $amount['ri_final_comprometida'];
                        $total['total_bl_actual'] += $amount['bl_actual'];
                        $total['total_pipeline_posterior'] += $amount['pipeline_posterior'];
                    }
                }
            }
        }

        if(!empty($response['Children'])){
            foreach($response['Children'] as $key => $value) {
                foreach($value as $index => $linea){
                    foreach($linea as $field => $amount){
                        foreach($amount as $children => $children_amount){
                            //Totales
                            $total['total_monto_original'] += $children_amount['monto_original'];
                            $total['total_monto_comprometido'] += $children_amount['monto_comprometido'];
                            $total['total_monto_real'] += $children_amount['monto_real'];
                            $total['total_renta_inicial'] += $children_amount['ri_comprometida'];
                            $total['total_renta_real'] += $children_amount['renta_real'];
                            $total['total_monto_cancelado'] += $children_amount['monto_cancelado'];
                            $total['total_ri_cancelada'] += $children_amount['ri_cancelada'];
                            $total['total_monto_diferencia'] += $children_amount['monto_diferencia'];
                            $total['total_monto_final_comprometido'] += $children_amount['monto_final_comprometido'];
                            $total['total_renta_inicial_final'] += $children_amount['ri_final_comprometida'];
                            $total['total_bl_actual'] += $children_amount['bl_actual'];
                            $total['total_pipeline_posterior'] += $children_amount['pipeline_posterior'];
                        }
                    }
                }
            }
        }

        //Redondeamos los totales
        $total['total_monto_original'] = round($total['total_monto_original'],0);
        $total['total_monto_comprometido'] = round($total['total_monto_comprometido'],0);
        $total['total_monto_real'] = round($total['total_monto_real'],0);
        $total['total_renta_inicial'] = round($total['total_renta_inicial'],0);
        $total['total_renta_real'] = round($total['total_renta_real'],0);
        $total['total_monto_cancelado'] = round($total['total_monto_cancelado'],0);
        $total['total_ri_cancelada'] = round($total['total_ri_cancelada'],0);
        $total['total_monto_diferencia'] = round($total['total_monto_diferencia'],0);
        $total['total_monto_final_comprometido'] = round($total['total_monto_final_comprometido'],0);
        $total['total_renta_inicial_final'] = round($total['total_renta_inicial_final'],0);
        $total['total_bl_actual'] = round($total['total_bl_actual'],0);
        $total['total_pipeline_posterior'] = round($total['total_pipeline_posterior'],0);

        return $total;
    }

    public function setBacklogComment($api, $args){

        global $current_user;

        $backlogId = $args['data']['backlogId'];
        $backlogDescription = $args['data']['description'];
        if($backlogDescription != ''){
            $todayDate = date("n/j/Y", strtotime("now"));
            $backlog = BeanFactory::retrieveBean('lev_Backlog', $backlogId);
            $backlog->description .= "\r\n" . $current_user->first_name . " " . $current_user->last_name . " - " . $todayDate . ": " . $backlogDescription;
            $backlog->save();
            return $backlog->description;
        }
    }

    public function cancelaBacklog($api, $args){

        global $current_user;
        $backlogId = $args['data']['backlogId'];
        $monto_cancelado = $args['data']['MontoReal'];
        $renta_cancelada = $args['data']['RentaReal'];
        $motivo_de_cancelacion = $args['data']['MotivoCancelacion'];
        $comentarios_de_cancelacion = $args['data']['Comentarios'];
        $mes = $args['data']['Mes'];
        $anio = $args['data']['Anio'];
        $todayDate = date("n/j/Y", strtotime("now"));

        $MesAnterior = $args['data']['MesAnterior'];
        $AnioAnterior = $args['data']['AnioAnterior'];
        $cam_competencia =$args['data']['Competencia'];
        $cam_producto =$args['data']['Producto'];


        $monto_cancelado = $this->cleanNumber($monto_cancelado);
        $renta_cancelada = $this->cleanNumber($renta_cancelada);

        $backlog = BeanFactory::retrieveBean('lev_Backlog', $backlogId);
        $backlog->description .= "\r\n" . $current_user->first_name . " " . $current_user->last_name . " - " . $todayDate . ": " . $comentarios_de_cancelacion;

        /* AF- 2018-10-24
         *  Se modifica condición 
        //if($motivo_de_cancelacion != "Cliente no interesado" && $motivo_de_cancelacion != "No viable"){
        */
        if($motivo_de_cancelacion == 'Mes posterior'){
            //Reevaluamos el tipo de operaci�n que tendra el nuevo BL
            $currentYear = date("Y");
            $currentDay = date("d");
            $BacklogElaboracion = date("m") + 1;

            //Obtiene el Backlog en revisi�n
            if($currentDay > 20){  //Si ya pasamos del dia 20 ya se esta planeando el BL de 2 meses naturales adelante
                $BacklogElaboracion += 1;
            }
            if ($BacklogElaboracion > 12){  //Si resulta mayor a diciembre
                $BacklogElaboracion = $BacklogElaboracion - 12;
            }

            if ($anio <= $currentYear){
                if ($mes == $BacklogElaboracion){
                    $this->copiarBacklog($backlog, $mes, $anio, 'Original',  'Comprometida', $backlog->numero_de_backlog);
                }else{
                    $this->copiarBacklog($backlog, $mes, $anio, 'Adicional', 'Comprometida', $backlog->numero_de_backlog);
                }
            }else{
                $this->copiarBacklog($backlog, $mes, $anio, 'Original',  'Comprometida', $backlog->numero_de_backlog);
            }

            //$this->copiarBacklog($backlog, $mes, $anio, $backlog->tipo_de_operacion, $backlog->estatus_de_la_operacion, $backlog->numero_de_backlog);

            // Actualiza las cotizaciones de UNICS al nuevo Backlog
            $host = 'http://'. $GLOBALS['unifin_url'] .'/Uni2WsUtilerias/WsRest/Uni2UtlServices.svc/Uni2/ActualizaMesBacklog';
            $fields = array(
                "backlogRequest" => array(
                    "noBacklog" => intval($backlog->numero_de_backlog),
                    "mesActual" => intval($MesAnterior),
                    "anioActual" => intval($AnioAnterior),
                    "mesNuevo" => intval($mes),
                    "anioNuevo" => intval($anio)
                )
            );

            $callApi = new UnifinAPI();
            $callApi->unifinPutCall($host,$fields);
        }

        //Obtiene el Backlog en revisi�n
        $currentDay = date("d");
        $BacklogElaboracion = date("m") + 1;

        if($currentDay > 20){  //Si ya pasamos del dia 20 ya se esta planeando el BL de 2 meses naturales adelante
            $BacklogElaboracion += 1;
        }

        //SI el Backlog que se esta cancelando es del Backlog que se esta elaborando, entonces se marca domo Deleted.
        if ($MesAnterior >= $BacklogElaboracion){
            $backlog->deleted = 1;
        }

        $backlog->estatus_de_la_operacion = "Cancelada";
        $backlog->monto_comprometido_cancelado = "-" . $monto_cancelado;
        $backlog->renta_inicialcomp_can = "-" . $renta_cancelada;
        $backlog->monto_real_logrado = 0;
        $backlog->renta_inicial_real = 0;
        $backlog->motivo_de_cancelacion = $motivo_de_cancelacion;
        $backlog->tct_competencia_quien_txf_c = $cam_competencia;
        $backlog->tct_que_producto_txf_c = $cam_producto;
        $backlog->save();
    }

    public function RevivirBacklog($api, $args){
        global $current_user;
        $backlogId = $args['data']['backlogId'];
        $monto = $args['data']['Monto'];
        $rentaInicial = $args['data']['RentaInicial'];
        $comentarios = $args['data']['Comentarios'];
        $mes = $args['data']['Mes'];
        $anio = $args['data']['Anio'];
        $MesAnterior = $args['data']['MesAnterior'];
        $AnioAnterior = $args['data']['AnioAnterior'];

        $todayDate = date("n/j/Y", strtotime("now"));

        if($mes == $MesAnterior){
            //SI se esta reviviendo al mismo mes, solo actualiza el estatus a comprometida
            $backlog = BeanFactory::retrieveBean('lev_Backlog', $backlogId);
            $backlog->estatus_de_la_operacion = "Comprometida";
            if ($comentarios != ""){
                $backlog->description .= "\r\n" . $current_user->first_name . " " . $current_user->last_name . " - " . $todayDate . ": " . $comentarios;
            }
            $backlog->save();
        }else{
            $backlog = BeanFactory::retrieveBean('lev_Backlog', $backlogId);
            $backlog->monto_comprometido_cancelado = 0;
            $backlog->renta_inicialcomp_can = 0;
            if ($comentarios != ""){
                $backlog->description .= $current_user->first_name . " " . $current_user->last_name . " - " . $todayDate . ": " . $comentarios;
            }

            //Evalua el tipo de operaci�n
            $currentYear = date("Y");
            $currentDay = date("d");
            $BacklogElaboracion = date("m") + 1;

            //Obtiene el Backlog en revisi�n
            if($currentDay > 20){  //Si ya pasamos del dia 20 ya se esta planeando el BL de 2 meses naturales adelante
                $BacklogElaboracion += 1;
            }
            if ($BacklogElaboracion > 12){  //Si resulta mayor a diciembre
                $BacklogElaboracion = $BacklogElaboracion - 12;
            }

            if ($anio <= $currentYear){
                if ($mes == $BacklogElaboracion){
                    $backlog->tipo_de_operacion = 'Original';
                }else{
                    $backlog->tipo_de_operacion = 'Adicional';
                }
            }else{
                $backlog->tipo_de_operacion = 'Original';
            }

            $this->copiarBacklog($backlog, $mes, $anio, $backlog->tipo_de_operacion, "Comprometida", $backlog->numero_de_backlog);
            // Actualiza las cotizaciones de UNICS al nuevo Backlog
            $host = 'http://'. $GLOBALS['unifin_url'] .'/Uni2WsUtilerias/WsRest/Uni2UtlServices.svc/Uni2/ActualizaMesBacklog';
            $fields = array(
                "backlogRequest" => array(
                    "noBacklog" => intval($backlog->numero_de_backlog),
                    "mesActual" => intval($MesAnterior),
                    "anioActual" => intval($AnioAnterior),
                    "mesNuevo" => intval($mes),
                    "anioNuevo" => intval($anio)
                )

            );

            $callApi = new UnifinAPI();
            $callApi->unifinPutCall($host,$fields);
        }
    }

    public function moverOperacionBacklog($api, $args){

        $backlogId = $args['data']['backlogId'];
        $mes = $args['data']['mes_popup'];
        $anio = $args['data']['anio_popup'];
        $tipo_operacion = $args['data']['tipo_operacion'];
        $periodo_revision = $args['data']['periodo_revision'];
        $access = $args['data']['access'];
        $rolAutorizacion = $args['data']['rolAutorizacion'];
        $MesAnterior = $args['data']['MesAnterior'];
        $AnioAnterior = $args['data']['AnioAnterior'];

        $backlog = BeanFactory::retrieveBean('lev_Backlog', $backlogId);

        if($backlog->anio <= $anio){
            if($backlog->mes > $mes){
                $backlog->mes = $mes;
                $backlog->anio = $anio;
                $backlog->tipo_de_operacion = $tipo_operacion;
            }

            if($backlog->mes < $mes){
                if($backlog->tipo_de_operacion == "Original" && $backlog->estatus_de_la_operacion != "Comprometida"){
                    $backlog->mes = $mes;
                    $backlog->anio = $anio;
                }

                $currentYear = date("Y");
                $currentDay = date("d");
                $currentMonth = date("m");
                $BacklogElaboracion = date("m") + 1;

                //Obtiene el Backlog en revisi�n
                if($currentDay > 20){  //Si ya pasamos del dia 20 ya se esta planeando el BL de 2 meses naturales adelante
                    $BacklogElaboracion += 1;
                }
                if ($BacklogElaboracion > 12){  //Si resulta mayor a diciembre
                    $BacklogElaboracion = $BacklogElaboracion - 12;
                }

                $GLOBALS['log']->fatal("Mes de Backlog en elaboraci�n: " . print_r($BacklogElaboracion,1));

                //En caso de ser Bl de Carga general, asignar el tipo de operaci�n que corresponde
                if($backlog->tipo_de_operacion == "Carga General"){
                    //Evalua el tipo de operaci�n
                    if ($anio <= $currentYear){
                        if ($mes >= $BacklogElaboracion){
                            $backlog->tipo_de_operacion = 'Original';
                        }else{
                            $backlog->tipo_de_operacion = 'Adicional';
                        }
                    }else{
                        $backlog->tipo_de_operacion = 'Original';
                    }
                }

                if($backlog->tipo_de_operacion == "Original" && $backlog->estatus_de_la_operacion == "Comprometida"){
                    if($periodo_revision == true && $backlog->mes == $currentMonth && $backlog->anio == $currentYear) {
                        if($access == "Full_Access" || $rolAutorizacion=="Direccion") {
                            $backlog->mes = $mes;
                            $backlog->anio = $anio;
                            //CVV se cambia a comprometida para ajustes de eliminar concepto de "Comprometer"
                            $backlog->estatus_de_la_operacion = "Comprometida"; //"Activa";
                        }else{
                            $response = "Esta Operacion ya esta comprometida y solo podra ser movida por un Director en periodo de revison";
                        }
                    }else{ // Si no se esta en periodo de revision
                        // Si se esta moviendo un BL del BL en elaboraci�n o posterior
                        //if ($backlog->mes >= $BacklogElaboracion){
                        if ($anio > $backlog->anio || ($anio==$backlog->anio && $mes >= $backlog->mes)){
                            $backlog->mes = $mes;
                            $backlog->anio = $anio;
                        }else{
                            //$response = "Esta Operacion ya esta comprometida y solo podra ser movida por un Director en periodo de revison";
                            $response = "Esta Operacion no puede moverse debido a que es de tipo Original, debe cancelar el backlog para mover a otro mes.";
                        }
                    }
                }

                if($backlog->tipo_de_operacion == "Adicional"){
                    //$this->copiarBacklog($backlog, $mes, $anio, "Original", "Activa");
                    //$backlog->estatus_de_la_operacion = "Enviada a otro mes";
                    $backlog->mes = $mes;
                    $backlog->anio = $anio;
                    //CVV se cambia a comprometida para ajustes de eliminar concepto de "Comprometer"
                    $backlog->estatus_de_la_operacion = "Comprometida"; //"Activa";
                }
            }
        }else{
            $backlog->mes = $mes;
            $backlog->anio = $anio;
        }

        $backlog->save();

        // Actualiza las cotizaciones de UNICS al nuevo Backlog
        $host = 'http://'. $GLOBALS['unifin_url'] .'/Uni2WsUtilerias/WsRest/Uni2UtlServices.svc/Uni2/ActualizaMesBacklog';
        $fields = array(
            "backlogRequest" => array(
                "noBacklog" => intval($backlog->numero_de_backlog),
                "mesActual" => intval($MesAnterior),
                "anioActual" => intval($AnioAnterior),
                "mesNuevo" => intval($mes),
                "anioNuevo" => intval($anio)
            )
        );

        $callApi = new UnifinAPI();
        $callApi->unifinPutCall($host,$fields);

        return $response;
    }

    public function operacionLogradaBacklog($api, $args){

        $backlogId = $args['data']['backlogId'];
        $monto_comprometido = $args['data']['monto_comprometido'];
        $renta_comprometida = $args['data']['renta_comprometida'];
        $Porcentaje_RI = $args['data']['RI'];
        $mes = $args['data']['mes'];
        $anio = $args['data']['anio'];
        $tipo_operacion = $args['data']['tipo_operacion'];

        $monto_comprometido = $this->cleanNumber($monto_comprometido);
        $renta_comprometida = $this->cleanNumber($renta_comprometida);

        $backlog = BeanFactory::retrieveBean('lev_Backlog', $backlogId);

        $backlog->monto_comprometido = $monto_comprometido;
        $backlog->renta_inicial_comprometida = $renta_comprometida;
        $backlog->porciento_ri = $Porcentaje_RI;

        $backlog->monto_final_comprometido_c = $monto_comprometido;
        $backlog->ri_final_comprometida_c = $renta_comprometida;

        /* CVV
        Si el cliente compromete mas de lo disponible, actualizar a etapa Prospecto
        Si el cliente compromete menos de lo disponible, actualizar a Autorizada
         * */
        /*
        if ($backlog->etapa != "Rechazada"){
            $MontoOperar = $backlog->monto_comprometido - $backlog->renta_inicial_comprometida;
            if ($MontoOperar <= $backlog->monto_original){
                $backlog->etapa = "Autorizada";
            }else{
                $backlog->etapa = "Prospecto";
            }
        }*/

        if($backlog->tipo_de_operacion == 'Carga General') {
            if ($monto_comprometido < $backlog->monto_original) {
                $this->copiarBacklog($backlog, $mes, $anio, $tipo_operacion, "Comprometida", "");
            }else{
                $backlog->mes = $mes;
                $backlog->anio = $anio;
                $backlog->tipo_de_operacion = $tipo_operacion;
                $backlog->estatus_de_la_operacion = "Comprometida";

                //CVV distribuye los montos en las etapas
                if($backlog->monto_original >= ($backlog->monto_final_comprometido_c - $backlog->ri_final_comprometida_c)){
                    $backlog->monto_prospecto_c = 0;
                    $backlog->ri_prospecto_c = 0;
                    $backlog->monto_sin_solicitud_c = $backlog->monto_final_comprometido_c ;
                    $backlog->ri_sin_solicitud_c = $backlog->ri_final_comprometida_c ;
                }else{
                    $backlog->monto_sin_solicitud_c = $backlog->monto_original;
                    $backlog->ri_sin_solicitud_c = $backlog->porciento_ri > 0 ? $backlog->monto_original * ($backlog->porciento_ri/100) : 0 ;
                    $backlog->monto_prospecto_c = $backlog->monto_final_comprometido_c;
                    $backlog->ri_prospecto_c = $backlog->ri_final_comprometida_c - $backlog->ri_sin_solicitud_c;
                }

                $backlog->save();
            }
        }else{
            $backlog->mes = $mes;
            $backlog->anio = $anio;
            $backlog->tipo_de_operacion = $tipo_operacion;
            $backlog->estatus_de_la_operacion = "Comprometida";

            //CVV distribuye los montos en las etapas
            if($backlog->monto_original >= ($backlog->monto_final_comprometido_c - $backlog->ri_final_comprometida_c)){
                $backlog->monto_prospecto_c = 0;
                $backlog->ri_prospecto_c = 0;
                $backlog->monto_sin_solicitud_c = $backlog->monto_final_comprometido_c ;
                $backlog->ri_sin_solicitud_c = $backlog->ri_final_comprometida_c ;
            }else{
                $backlog->monto_sin_solicitud_c = $backlog->monto_original;
                $backlog->ri_sin_solicitud_c = $backlog->porciento_ri > 0 ? $backlog->monto_original * ($backlog->porciento_ri/100) : 0 ;
                $backlog->monto_prospecto_c = $backlog->monto_final_comprometido_c;
                $backlog->ri_prospecto_c = $backlog->ri_final_comprometida_c - $backlog->ri_sin_solicitud_c;
            }

            $backlog->save();
        }
    }

    public function comprometerBacklogMass($api, $args){

        $mes = $args['data']['mes'];
        $anio = $args['data']['anio'];
        $tipo_operacion = $args['data']['tipo_operacion'];

        foreach ($args['data']['backlogs'] as $index => $id) {
            $backlog = BeanFactory::retrieveBean('lev_Backlog', $id);
            $backlog->estatus_de_la_operacion = "Comprometida";
            //$backlog->monto_comprometido = $monto_comprometido;
            //$backlog->renta_inicial_comprometida = $renta_comprometida;
            $backlog->mes = $mes;
            $backlog->anio = $anio;
            $backlog->tipo_de_operacion = $tipo_operacion;
            $backlog->save();
        }
    }

    public function copiarBacklog($original_backlog, $mes, $anio, $tipo_operacion, $estatus, $numero_de_backlog = null){
        $new_backlog = BeanFactory::getBean('lev_Backlog');

        $new_backlog->activo = $original_backlog->activo;
        $new_backlog->anio = $anio;
        $new_backlog->account_id_c = $original_backlog->account_id_c;
        $new_backlog->assigned_user_id = $original_backlog->assigned_user_id;
        $new_backlog->currency_id = $original_backlog->currency_id;
        $new_backlog->description = $original_backlog->description;
        $new_backlog->estatus_de_la_operacion = $estatus;
        $new_backlog->etapa = $original_backlog->etapa;
        $new_backlog->etapa_preliminar = $original_backlog->etapa_preliminar;
        $new_backlog->mes = $mes;
        $new_backlog->monto_comprometido = $original_backlog->monto_comprometido;
        $new_backlog->monto_original = $original_backlog->monto_original;
        $new_backlog->monto_real_logrado = $original_backlog->monto_real_logrado;
        $new_backlog->name = $original_backlog->name;
        $new_backlog->producto = $original_backlog->producto;
        $new_backlog->progreso = $original_backlog->progreso;
        $new_backlog->region = $original_backlog->region;
        $new_backlog->renta_inicial_comprometida = $original_backlog->renta_inicial_comprometida;
        $new_backlog->renta_inicial_real = $original_backlog->renta_inicial_real;
        $new_backlog->tipo = $original_backlog->tipo;
        $new_backlog->tipo_de_operacion = $tipo_operacion;
        $new_backlog->numero_de_backlog = $numero_de_backlog;
        $new_backlog->equipo = $original_backlog->equipo;
        $new_backlog->lev_backlog_opportunitiesopportunities_ida = $original_backlog->lev_backlog_opportunitiesopportunities_ida;
        $new_backlog->monto_final_comprometido_c = $original_backlog->monto_final_comprometido_c;
        $new_backlog->ri_final_comprometida_c = $original_backlog->ri_final_comprometida_c;

        $new_backlog->save();

    }

    public function crearArchivoCSVBacklog($api, $args){

        global $sugar_config;

        $backlog_doc_id = uniqid('', false);
        $backlog_doc_name = "Backlog" . $backlog_doc_id . ".csv";
        $csvfile = $sugar_config['upload_dir']  . $backlog_doc_name;

        $fp = fopen($csvfile, 'w');

        // output the column headings
        fputcsv($fp, array('ESTATUS', 'MES','EQUIPO', 'ZONA', 'PROMOTOR', 'ID CLIENTE','CLIENTE', 'NO. BACKLOG', 'BIEN',  'LINEA DISPONIBLE',
            'MONTO ORIGINAL', 'RI ORIGINAL', 'DIFERENCIA', 'BACKLOG', 'RENTA INICIAL', 'BACKLOG ACTUAL', 'COLOCACIÓN REAL', 'RI REAL', 'MONTO CANCELADO',
            'RI CANCELADA',  'TIPO DE OPERACIÓN','ETAPA INICIO MES', 'ETAPA', 'SOLICITUD',
            'PROSPECTO','CREDITO','RECHAZADA','SIN SOLICITUD','CON SOLICITUD','RI PROSPECTO','RI CREDITO','RI RECHAZADA','RI SIN SOLICITUD','RI CON SOLICITUD', 'TASA', 'COMISION', 'DIF RESIDUALES', 'COLOCACION PIPELINE'));

        foreach ($args['data']['backlogs'] as $key => $values) {
            foreach ($values as $index => $linea) {

                if ($index == "MyBacklogs") {
                    foreach ($linea as $backlogId => $backlogValues) {
                        foreach ($backlogValues as $colName => $colValues) {
                            $colValues['equipo'] = ($colValues['equipo'] == "Equipo 0") ? "0" : $colValues['equipo'];
                            $colValues['zona'] = ($colValues['zona'] == "Region 0") ? "0" : $colValues['zona'];
                            $colValues = $this->removeElement($colValues, "name");
                            $colValues = $this->removeElement($colValues, "clienteId");
                            $colValues = $this->removeElement($colValues, "activo");
                            $colValues = $this->removeElement($colValues, "oppId");
                            $colValues = $this->removeElement($colValues, "iniciales");
                            $colValues = $this->removeElement($colValues, "mes");
                            $colValues = $this->removeElement($colValues, "mes_int");
                            $colValues = $this->removeElement($colValues, "anio");
                            $colValues = $this->removeElement($colValues, "comentarios");
                            $colValues = $this->removeElement($colValues, "No_Solicitud");
                            $colValues = $this->removeElement($colValues, "estatus_checked");
                            $colValues = $this->removeElement($colValues, "mass_checked");
                            $colValues = $this->removeElement($colValues, "porciento_ri");
                            $colValues = $this->removeElement($colValues, "comentado");
                            $colValues = $this->removeElement($colValues, "color");
                            $colValues = $this->removeElement($colValues, "colorDispLinea");
                            $colValues = $this->removeSpecialCharacters($colValues);
                            fputcsv($fp, $colValues);
                        }
                    }
                }

                if ($index == "SubBacklogs") {
                    foreach ($linea as $backlogId => $backlogValues) {
                        foreach ($backlogValues as $colName => $colValues) {
                            foreach ($colValues as $subColName => $subColValues) {
                                $subColValues['equipo'] = ($subColValues['equipo'] == "Equipo 0") ? "0" : $subColValues['equipo'];
                                $subColValues['zona'] = ($subColValues['zona'] == "Region 0") ? "0" : $subColValues['zona'];
                                $subColValues = $this->removeElement($subColValues, "name");
                                $subColValues = $this->removeElement($subColValues, "clienteId");
                                $subColValues = $this->removeElement($subColValues, "activo");
                                $subColValues = $this->removeElement($subColValues, "oppId");
                                $subColValues = $this->removeElement($subColValues, "iniciales");
                                $subColValues = $this->removeElement($subColValues, "mes");
                                $subColValues = $this->removeElement($subColValues, "mes_int");
                                $subColValues = $this->removeElement($subColValues, "anio");
                                $subColValues = $this->removeElement($subColValues, "comentarios");
                                $subColValues = $this->removeElement($subColValues, "No_Solicitud");
                                $subColValues = $this->removeElement($subColValues, "estatus_checked");
                                $subColValues = $this->removeElement($subColValues, "mass_checked");
                                $subColValues = $this->removeElement($subColValues, "porciento_ri");
                                $subColValues = $this->removeElement($subColValues, "comentado");
                                $subColValues = $this->removeElement($subColValues, "color");
                                $subColValues = $this->removeElement($subColValues, "colorDispLinea");
                                $subColValues = $this->removeSpecialCharacters($subColValues);
                                fputcsv($fp, $subColValues);
                            }
                        }
                    }
                }

                if ($index == 'Children') {
                    foreach ($linea as $backlogId => $backlogValues) {
                        foreach ($backlogValues as $colName => $colValues) {
                            foreach ($colValues as $subColName => $subColValues) {
                                foreach ($subColValues as $childrenColName => $childrenColValues) {
                                    $childrenColValues['equipo'] = ($childrenColValues['equipo'] == "Equipo 0") ? "0" : $childrenColValues['equipo'];
                                    $childrenColValues['zona'] = ($childrenColValues['zona'] == "Region 0") ? "0" : $childrenColValues['zona'];
                                    $childrenColValues = $this->removeElement($childrenColValues, "name");
                                    $childrenColValues = $this->removeElement($childrenColValues, "clienteId");
                                    $childrenColValues = $this->removeElement($childrenColValues, "activo");
                                    $childrenColValues = $this->removeElement($childrenColValues, "oppId");
                                    $childrenColValues = $this->removeElement($childrenColValues, "iniciales");
                                    $childrenColValues = $this->removeElement($childrenColValues, "mes");
                                    $childrenColValues = $this->removeElement($childrenColValues, "mes_int");
                                    $childrenColValues = $this->removeElement($childrenColValues, "anio");
                                    $childrenColValues = $this->removeElement($childrenColValues, "comentarios");
                                    $childrenColValues = $this->removeElement($childrenColValues, "No_Solicitud");
                                    $childrenColValues = $this->removeElement($childrenColValues, "estatus_checked");
                                    $childrenColValues = $this->removeElement($childrenColValues, "mass_checked");
                                    $childrenColValues = $this->removeElement($childrenColValues, "porciento_ri");
                                    $childrenColValues = $this->removeElement($childrenColValues, "comentado");
                                    $childrenColValues = $this->removeElement($childrenColValues, "color");
                                    $childrenColValues = $this->removeElement($childrenColValues, "colorDispLinea");
                                    $childrenColValues = $this->removeSpecialCharacters($childrenColValues);
                                    fputcsv($fp, $childrenColValues);
                                }
                            }
                        }
                    }
                }
            }
        }

        fputcsv($fp,array('', '','', '', '', '', '', '', '', $args['data']['backlogs']['backlogs']['totales']['total_monto_original'],$args['data']['backlogs']['backlogs']['totales']['total_monto_comprometido'],
            $args['data']['backlogs']['backlogs']['totales']['total_renta_inicial'],0,$args['data']['backlogs']['backlogs']['totales']['total_monto_final_comprometido'],$args['data']['backlogs']['backlogs']['totales']['total_renta_inicial_final'],
            $args['data']['backlogs']['backlogs']['totales']['total_bl_actual'],$args['data']['backlogs']['backlogs']['totales']['total_monto_real'],$args['data']['backlogs']['backlogs']['totales']['total_renta_real'],
            $args['data']['backlogs']['backlogs']['totales']['total_monto_cancelado'],$args['data']['backlogs']['backlogs']['totales']['total_ri_cancelada'],'','','','','','','',''));

        fclose($fp);

        return $backlog_doc_name;
    }

    public function removeElement($fields, $index){
        if($fields[$index]){
            unset($fields[$index]);
        }
        return $fields;
    }

    public function removeSpecialCharacters($fields){
        foreach($fields as $key => $value) {
            //decode special characters
            $fields[$key] = utf8_decode($value);
        }
        return $fields;
    }

    public function contarRegistrosSeleccionados($api, $args){

        $backlogIds = '';
        foreach($args['data'] as $key => $values){
            foreach($values as $index => $id){
                $backlogIds [] = $id;
            }
        }

        if(count($backlogIds) <= 1){
            $backlogIds = "'" . implode("", $backlogIds). "'";
        }else{
            $backlogIds = "'" . implode("','", $backlogIds). "'";
        }

        global $db;
        $query = <<<SQL
SELECT COUNT(id) AS operaciones, SUM(monto_comprometido) AS monto_comprometido FROM lev_backlog
WHERE deleted = 0 AND id IN ({$backlogIds})
SQL;

        $queryResult = $db->query($query);
        while($row = $db->fetchByAssoc($queryResult))
        {
            $response['operaciones'] = $row['operaciones'];
            $response['monto_comprometido'] = $row['monto_comprometido'];
        }

        return $response;
    }

    public function cleanNumber($number){
        $number = str_replace(array(',','$'), '' , $number);
        $split_number = explode('.', $number);
        $last = sizeof($split_number);
        $last -= 1;
        if($last > 0) {
            for ($i = 0; $i <= $last; $i++) {

                if ($i < $last) {
                    $clean_number .= $split_number[$i];
                }

                if ($i == $last) {
                    $clean_number .= '.' . $split_number[$i];
                }
            }
            $number = $clean_number;
        }
        if($number == '') $number = 0;
        return $number;
    }

    public function getPromotores($api, $args){

        global $db, $current_user;
        $response = array();
        $access = $args['data']['Access'];
        $equipo = $args['data']['equipo'];
        $mes = $args['data']['mes'];
        if($mes == 'Todos'){
            $mes = '1,2,3,4,5,6,7,8,9,10,11,12';
        }

        $query = <<<SQL
SELECT distinct u.id, user_name, CONCAT(first_name, " ", last_name) AS full_name, equipo_c
FROM users u
INNER JOIN users_cstm uc ON uc.id_c = u.id  AND status = 'Active'
LEFT OUTER JOIN lev_Backlog bl on bl.assigned_user_id = u.id and bl.mes IN ({$mes})
WHERE u.deleted = 0
and (u.status = 'Active' or (u.status = 'Inactive' and bl.id is not null))
SQL;
        if($access != "Full_Access"){
            $query .= " AND reports_to_id = '{$current_user->id}' ";
            $response[$current_user->id] = $current_user->full_name;
        }else{
            //Si es BackOffice solo debe ver a los promotores de los equipos que tiene asignados su usuario
            $EquiposVisibles = '';
            $qry = <<<SQL
SELECT replace(replace(usr.equipos_c,'^',''),',',''',''') equipos
FROM acl_roles r
INNER JOIN acl_roles_users ru ON ru.role_id = r.id AND ru.deleted = 0
INNER JOIN users_cstm usr on usr.id_c = ru.user_id
WHERE r.name in ('Backlog-BO')
and ru.user_id = '{$current_user->id}'
SQL;
            $EquiposVisibles = $db->getone($qry);
            if(!empty($EquiposVisibles) || $EquiposVisibles != ''){
                $query .= " AND uc.equipo_c in ('{$EquiposVisibles}') ";
            }
        }

        if(!empty($equipo) && $equipo != 'Todos'){
            $query .= " AND uc.equipo_c = '{$equipo}' ";
        }

        $query .= " ORDER BY full_name ASC ";
        $queryResult = $db->query($query);

        while($row = $db->fetchByAssoc($queryResult))
        {
            $response[$row['id']] = $row['full_name'];

            if($access != "Full_Access") {
                $children = $this->getReportsTo($row['id']);

                foreach ($children as $key => $value) {
                    $response[$key] = $value;
                }
            }
        }

        asort($response);
        return $response;
    }

    public function getReportsTo($id)
    {
        global $db;
        $query = <<<SQL
SELECT id, CONCAT(first_name, " ", last_name) AS full_name FROM users u
INNER JOIN users_cstm uc ON uc.id_c = u.id 
WHERE u.deleted = 0
AND reports_to_id = '{$id}'
SQL;
        $queryResult = $db->query($query);

        while($row = $db->fetchByAssoc($queryResult))
        {
            $response[$row['id']] = $row['full_name'];
        }

        if($db->getRowCount($queryResult) > 0) {
            foreach ($response as $id => $name) {
                $children = $this->getReportsTo($id);

                foreach ($children as $key => $value) {
                    $response[$key] = $value;
                }
            }
        }
        return $response;
    }

    public function getEquipos($api, $args){

        global $db, $current_user;
        $response = array();
        $access = $args['data']['Access'];

        $query = <<<SQL
SELECT DISTINCT equipo_c, u.reports_to_id, u.id,
case equipo_c when '1' then 1 when '2' then 2 when '3' then 3 when '4' then 4 when '5' then 5 when '6' then 6 when '7' then 7 when '8' then 8 when '9' then 9
when 'MTY' then 10 when 'HER' then 11 when 'CHI' then 12 when 'GDL' then 13 when 'QRO' then 14 when 'QRO2' then 15  when 'LEO' then 16
when 'PUE' then 17 when 'VER' then 18 when 'CUN' then 19 when 'CAN' then 19 when 'MER' then 20 when 'TOL' then 21 when 'CASA' then 22 when '0' then 50 else equipo_c end AS ordenEquipo
FROM users_cstm uc
INNER JOIN users u ON u.id = uc.id_c 
WHERE u.deleted = 0
and equipo_c not in ('CA','CA1','CA2','CA3','CAS','F1','F2','F3','F4','F5')
SQL;

        if($access != "Full_Access"){
            $query .= " AND u.reports_to_id = '{$current_user->id}' ";
            $response[$current_user->equipo_c] = $current_user->equipo_c;
        }else{
            //Si es BackOffice solo debe ver los equipos que tiene asociados su usuario
            $EquiposVisibles = '';
            $qry = <<<SQL
SELECT replace(replace(usr.equipos_c,'^',''),',',''',''') equipos
FROM acl_roles r
INNER JOIN acl_roles_users ru ON ru.role_id = r.id AND ru.deleted = 0
INNER JOIN users_cstm usr on usr.id_c = ru.user_id
WHERE r.name in ('Backlog-BO')
and ru.user_id = '{$current_user->id}'
SQL;
            $EquiposVisibles = $db->getone($qry);
            if(!empty($EquiposVisibles) || $EquiposVisibles != ''){
                $query .= " AND equipo_c in ('{$EquiposVisibles}') ";
            }
        }
        $query .= "ORDER BY  ordenEquipo";

        $queryResult = $db->query($query);

        //$response[$current_user->equipo_c] = $current_user->equipo_c;
        while($row = $db->fetchByAssoc($queryResult))
        {
            //$response[$row['equipo_c']] = $row['equipo_c'];
            $response[$row['ordenEquipo']] = $row['equipo_c'];

            if($access != "Full_Access") {
                $children = $this->getEquiposChildren($row['id']);

                if(!empty($children)) {
                    foreach ($children as $key => $value) {
                        $response[$key] = $value;
                    }
                }
            }
        }
        //$GLOBALS['log']->fatal(" Listado de equipos para combo: ". print_r($response,1));
        $resp = array_unique($response);
        return $resp;
    }

    public function getEquiposChildren($id){
        global $db;
        $response = array();
        $users = array();

        $query = <<<SQL
SELECT DISTINCT equipo_c, u.reports_to_id, u.id,
case equipo_c when '1' then 1 when '2' then 2 when '3' then 3 when '4' then 4 when '5' then 5 when '6' then 6 when '7' then 7 when '8' then 8 when '9' then 9
when 'MTY' then 10 when 'HER' then 11 when 'CHI' then 12 when 'GDL' then 13 when 'QRO' then 14 when 'QRO2' then 15 when 'LEO' then 16
when 'PUE' then 17 when 'VER' then 18 when 'CUN' then 19 when 'CAN' then 19 when 'MER' then 20 when 'TOL' then 21 when 'CASA' then 22 when '0' then 50 else equipo_c end AS ordenEquipo
FROM users_cstm uc
INNER JOIN users u ON u.id = uc.id_c 
WHERE u.deleted = 0 AND u.reports_to_id = '{$id}'
and equipo_c not in ('CA','CA1','CA2','CA3','CAS','F1','F2','F3','F4','F5')
ORDER BY  ordenEquipo
SQL;

        $queryResult = $db->query($query);

        while($row = $db->fetchByAssoc($queryResult))
        {
            //$response[$row['equipo_c']] = $row['equipo_c'];
            $response[$row['ordenEquipo']] = $row['equipo_c'];
            $users[$row['id']] = $row['id'];
        }

        if($db->getRowCount($queryResult) > 0) {
            foreach ($users as $id => $name) {
                $children = $this->getEquiposChildren($id);

                foreach ($children as $key => $value) {
                    $response[$key] = $value;
                }
            }
        }

        return $response;
    }

    public function setColumns($api, $args){

        global $current_user;

        $columnas = $args['data']['values'];
        $columnas_seleccionadas = $args['data']['columnas'];

        $On_array = array();
        foreach($columnas as $i => $val){
            $On_array[$val] = 'OFF';
        }

        foreach ($On_array as $key => $index){
            foreach ($columnas_seleccionadas as $key_sel => $index_sel){
                if($key == $index_sel){
                    $On_array[$key] = 'ON';
                }
            }
        }

        foreach ($On_array as $k => $v){
            $current_user->setPreference($k,$v,'','Backlog');
        }
    }

    public function getColumnas($api, $args){

        global $current_user;

        $columnas = $args['data']['values'];
        $preferences = array();
        foreach($columnas as $i => $val){
            $preferences[$val] = $current_user->getPreference($val,'Backlog');
        }

        return $preferences;
    }

    public function UpdateFechaBl($api, $args)
    {
        //$GLOBALS['log']->fatal(">>>>>>>>>MoverMes: " . print_r($args,1));
        global $sugar_config;
        $GLOBALS['esb_url'] = $sugar_config['esb_url'];

        $url='http://'.$GLOBALS['esb_url'].'/uni2/rest/unics/actualizaFechasBacklog';
        $fields = array(
            "backlogRequest" => array(
                "bl" => $args['data']['bl'],
                "mesActual" => $args['data']['mesActual'],
                "anioActual" => $args['data']['anioActual'],
                "mesNuevo" => $args['data']['mesNuevo'],
                "anioNuevo" => $args['data']['anioNuevo']
            )
        );

        $callApi = new UnifinAPI();
        $callApi->unifinPostCall($url,$fields);

    }
}