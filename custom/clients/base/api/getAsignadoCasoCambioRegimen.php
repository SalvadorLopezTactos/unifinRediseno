<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");

class getAsignadoCasoCambioRegimen extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETActivoAPI' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('getAsignadoCaso', '?'),
                'pathVars' => array('module', 'id'),
                'method' => 'recuperaAsignado',
                'shortHelp' => 'Obtiene asignado a caso por cambio de razon social',
            ),
        );
    }
    public function recuperaAsignado($api, $args)
    {
        global $db, $current_user, $app_list_strings;
        $idCuenta = $args['id'];
        $asignado = array('name'=>'','id'=>'');
                
        //Valida si es usuario CAC o normal
        if($current_user->cac_c){
            //Recupera usuarios por producto          
            $queryUsuarios = "select up.tipo_producto, u.status, u.id user_id, concat(u.first_name,' ' ,u.last_name) user_name , ur.id reports_id, concat(ur.first_name,' ' ,ur.last_name) reports_name
               from uni_productos up
               inner join uni_productos_cstm upc on upc.id_c = up.id
               inner join accounts_uni_productos_1_c ap on ap.accounts_uni_productos_1uni_productos_idb = up.id
               inner join users u on u.id = up.assigned_user_id
               left join users ur on ur.id = u.reports_to_id
               where 
               ap.accounts_uni_productos_1accounts_ida='".$idCuenta."'
               and up.tipo_producto in ('1','9','8')
               and u.is_group = false ;";
            $result_usr = $db->query($queryUsuarios);
            while ($row = $db->fetchByAssoc($result_usr)) {
                if($row['status'] == 'Active'){
                  $asignado['id'] = $row['user_id'];
                  $asignado['name'] = $row['user_name'];
                }else{
                  $asignado['id'] = $row['reports_id'];
                  $asignado['name'] = $row['reports_name'];
                }
            }
            if(empty($asignado['id'])){
                $asignado['id']  = $app_list_strings['asesor_leasing_id_list']['1'];
                $asignado['name'] = $app_list_strings['asesor_leasing_name_list']['1'];
              
            }
          
        }else{
            $asignado['id'] = $current_user->id;
            $asignado['name'] = $current_user->full_name;
        }
          
        return $asignado;
    }
}
