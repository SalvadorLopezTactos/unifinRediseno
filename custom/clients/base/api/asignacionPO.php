<?php
/**
 * @author: CVV
 * @date: 25/07/2016
 * @comments: Rest API to display states list
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class asignacionPO extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'asignacionPO_GET' => array(
                'reqType' => 'GET',
                'path' => array('getAsignacionPO'),
                'pathVars' => array(''),
                'method' => 'getAsignacionPOMethod',
                'shortHelp' => 'Obtiene la lista de asignación de PO unifin_asignacion_po',
            ),
            'asignacionPO_POST' => array(
                'reqType' => 'POST',
                'path' => array('upAsignacionPO'),
                'pathVars' => array(''),
                'method' => 'upAsignacionPOMethod',
                'shortHelp' => 'Obtiene la lista de asignación de PO unifin_asignacion_po',
            ),
        );
    }

    public function getAsignacionPOMethod($api, $args)
    {
        global $db, $current_user;
        try
        {
            $query = "select a.*, concat(u.first_name, ' ', u.last_name)uName
              from unifin_asignacion_po a
              inner join users u on u.id=a.modified_by
              limit 100;";
            $resultado = $db->query($query);
            $restultado_list = [];

            while ($row = $db->fetchByAssoc($resultado)) {
                $restultado_list[] = $row;
            }

            return $restultado_list;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }

    }
    
    public function upAsignacionPOMethod($api, $args)
    {
        global $db, $current_user;
        $zona_geografica = isset($args['zona_geografica']) ? $args['zona_geografica'] : '';
        $equipos = isset($args['equipos']) ? $args['equipos'] : '';
        $modified_by = $current_user->id;
        if($zona_geografica && $equipos){
          try{
              $query = "update unifin_asignacion_po a
                set a.equipos = '{$equipos}',
                modified_by = '{$modified_by}',
                date_modified = now()
                where a.zona_geografica='{$zona_geografica}';";
              $resultado = $db->query($query);
              
              return '200';

          }catch (Exception $e){
              error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
              $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
              return '500';
          }
        }else{
          return '400';
        }

    }
}
