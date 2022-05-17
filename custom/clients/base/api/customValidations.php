<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 8/24/2015
 * Time: 11:18 AM
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class customValidations extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POST_customValidations' => array(
                'reqType' => 'POST',
                'path' => array('customValidations'),
                'pathVars' => array(''),
                'method' => 'obtenerValidaciones',
                'shortHelp' => 'Obtener Validaciones de los modulos de validacion y validaciones',
            ),
        );
    }

    public function obtenerValidaciones($api, $args)
    {
        try
        {
            $modulo = $args['data']['modulo'];
            global $db;
            $query = <<<SQL
            SELECT
              id,
              campo_dependiente,
              deleted,
              visible,
              requerido,
              estatus,
              solo_lectura,
              modulo,
              campo_padre,
              criterio_validacion
            FROM
              val_validaciones
            WHERE deleted = 0
            AND estatus = 'Activo'
            AND modulo = '{$modulo}'
            AND id NOT IN (SELECT vv.val_validaciones_val_validacionesval_validaciones_idb FROM val_validaciones_val_validaciones_c vv WHERE deleted = 0)
SQL;
            $queryResult = $db->query($query);
            $response = array();
            while($row = $db->fetchByAssoc($queryResult))
            {
                $response[$row['campo_padre']][$row['criterio_validacion']][] = array('campo_dependiente'=> $row['campo_dependiente']
                ,'visible'=> $row['visible']
                ,'requerido'=> $row['requerido']
                ,'estatus'=> $row['estatus']
                ,'solo_lectura'=> $row['solo_lectura']);
                //Obtener Sub Validaciones
                 $sub_validacion_query = "SELECT
                          campo_dependiente,
                          v.deleted,
                          visible,
                          requerido,
                          estatus,
                          solo_lectura,
                          modulo,
                          campo_padre,
                          criterio_validacion
                        FROM
                          val_validaciones v
                          LEFT JOIN val_validaciones_val_validaciones_c vv
                            ON v.id = vv.val_validaciones_val_validacionesval_validaciones_ida
                            AND vv.deleted = 0
                        WHERE v.deleted = 0
                          AND estatus = 'Activo'
                          AND modulo = 'Accounts'
                              AND v.id IN (
                                SELECT vv.val_validaciones_val_validacionesval_validaciones_idb FROM val_validaciones_val_validaciones_c vv
                                RIGHT JOIN val_validaciones v ON v.id = vv.val_validaciones_val_validacionesval_validaciones_ida AND vv.deleted = 0
                                WHERE v.deleted = 0 AND estatus = 'Activo' AND modulo = '{$modulo}'
                                AND vv.val_validaciones_val_validacionesval_validaciones_ida = '{$row['id']}')";



                 $subValResult = $db->query($sub_validacion_query);
                 while($sub_val_row = $db->fetchByAssoc($subValResult))
                 {
                     $response[$row['campo_padre']][$row['criterio_validacion']]['SubValidaciones'][] = array('campo_dependiente'=> $sub_val_row['campo_dependiente']
                     ,'campo_padre'=> $sub_val_row['campo_padre']
                     ,'visible'=> $sub_val_row['visible']
                     ,'requerido'=> $sub_val_row['requerido']
                     ,'estatus'=> $sub_val_row['estatus']
                     ,'solo_lectura'=> $sub_val_row['solo_lectura']
                     ,'criterio_validacion'=> $sub_val_row['criterio_validacion']);
                 }
            }

            return $response;
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : response  " . print_r($response,true));
        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }
    }

}