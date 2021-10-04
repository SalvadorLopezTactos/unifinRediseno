<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class getSolicitudes extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'getSolicitudes' => array(
                'reqType' => 'POST',
                'noLoginRequired' => false,
                'path' => array('getSolicitudes'),
                'pathVars' => array(''),
                'method' => 'getSolicitud',
                'shortHelp' => 'Obtiene Solicitudes de la Cuenta',
            ),
        );
    }

    public function getSolicitud($api, $args)
    {
        try {
            $account_id = $args['account_id'];
            $beanQuery = BeanFactory::newBean('Opportunities');
            $sugarQueryOpp = new SugarQuery();
            $sugarQueryOpp->select(array('id'));
            $sugarQueryOpp->from($beanQuery);
            $sugarQueryOpp->where()->equals('account_id',$account_id);
            $sugarQueryOpp->where()->notEquals('tct_etapa_ddw_c','R');
			$sugarQueryOpp->where()->notEquals('estatus_c','R');
			$sugarQueryOpp->where()->notEquals('estatus_c','K');
			$sugarQueryOpp->where()->notEquals('estatus_c','CM');
            $result = $sugarQueryOpp->execute();
            $countOpp = count($result);
		}
		catch(Exception $e) {
			$GLOBALS['log']->fatal("ERROR AL CONSULTAR SOLICITUDES: ".$e->getMessage());
        }
        return $countOpp;
    }
}