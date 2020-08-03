<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 7/1/2015
 * Time: 11:03 PM
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class CheckForRatificados extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'postRatificado' => array(
                'reqType' => 'POST',
                'path' => array('Opportunities', 'CheckForRatificados'),
                'pathVars' => array('',''),
                'method' => 'getRelatedOpps',
                'shortHelp' => 'Verifica si la Operacion tiene Operaciones relacionadas',
            ),
        );
    }

    public function getRelatedOpps($api, $args)
    {
        $isParentId = false;
        $parentId = $args['data']['parentId'];
         global $db, $current_user;
         $query = <<<SQL
SELECT * FROM opportunities_opportunities_1_c oo inner join opportunities_cstm oppc on oppc.id_c = oo.opportunities_opportunities_1opportunities_ida
WHERE opportunities_opportunities_1opportunities_ida = '{$parentId}' AND deleted = 0 and tipo_de_operacion_c='RATIFICACION_INCREMENTO' and oppc.estatus_c IN('N','R','K','CM')
SQL;
        $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : query: " . $query);
         $queryResult = $db->getOne($query);
         if($queryResult != null){
             $isParentId = true;
         }
        return $isParentId;
    }

}