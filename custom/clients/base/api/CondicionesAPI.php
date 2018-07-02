<?php /**
 * @author: JSR
 * @date: 21/05/2016
 * @comments: Rest API to display Financial Conditions list
 */ if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); require_once("custom/Levementum/UnifinAPI.php"); class CondicionesAPI extends SugarApi {
    public function registerApiRest()
    {
        return array(
            'CondicionesAPI' => array(
                'reqType' => 'GET',
                'path' => array('CondicionesAPI'),
                'pathVars' => array(''),
                'method' => 'getCondicionesList',
                'shortHelp' => 'Obtiene la lista de Condiciones Financieras de CRM',
            ),
        );
    }
    public function getCondicionesList($api, $args)
    {
        try
        {
			$solicitud = $args['idsolicitud'];
			$query = new SugarQuery();
			$query->select(array('id','name','idsolicitud'));
			$query->from(BeanFactory::getBean('lev_CondicionesFinancieras'));
			$query->where()->equals('idsolicitud',$solicitud);
			$results = $query->execute();
			$GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : resultado " . print_r(sizeof($results), true));
			$GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : resultado " . print_r($results, true));
				
            return $results;
        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }
    }
}
