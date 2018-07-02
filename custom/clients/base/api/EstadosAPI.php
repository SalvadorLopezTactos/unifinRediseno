<?php
/**
 * @author: CVV
 * @date: 25/07/2016
 * @comments: Rest API to display states list
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class EstadosAPI extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'EstadosAPI' => array(
                'reqType' => 'GET',
                'path' => array('EstadosAPI','getEstados','?'),
                'pathVars' => array('', '', 'id'),
                'method' => 'getEstadosList',
                'shortHelp' => 'Obtiene la lista de estados de CRM',
            ),
        );
    }

    public function getEstadosList($api, $args)
    {
        global $db, $current_user;
        $idPais = $args['id'];
        try
        {
            $query = <<<SQL
select id, name from dire_estado where SUBSTRING(id,1,3) = LPAD('{$idPais}',3,'0')
SQL;

            $Estados = $db->query($query);

            while ($row = $db->fetchByAssoc($Estados)) {
                $estados_list[] = $row;
            }

            return $estados_list;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }

    }
}