<?php
/**
 * @author: CVV
 * @date: 25/07/2016
 * @comments: Rest API to display Municipios list
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class MunicipiosAPI extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'EstadosAPI' => array(
                'reqType' => 'GET',
                'path' => array('MunicipiosAPI','getMunicipios','?'),
                'pathVars' => array('', '', 'id'),
                'method' => 'getMunicipiosList',
                'shortHelp' => 'Obtiene la lista de Municipios de CRM',
            ),
        );
    }

    public function getMunicipiosList($api, $args)
    {
        global $db, $current_user;
        $idEstado = $args['id'];
        try
        {
            $query = <<<SQL
select id, name from dire_municipio where SUBSTRING(id,1,6) = '{$idEstado}'
SQL;

            $municipios = $db->query($query);

            while ($row = $db->fetchByAssoc($municipios)) {
                $municipios_list[] = $row;
            }

            return $municipios_list;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }

    }
}