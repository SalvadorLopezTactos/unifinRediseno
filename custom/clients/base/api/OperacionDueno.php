<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 *
 * @author Carlos Zaragoza
 * Date: 16/07/2015
 * Time: 03:39 PM
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class OperacionDueno extends SugarApi
{

    public function registerApiRest()
    {
        return array(
          'OperacionDueno' => array(
                                  'reqType' => 'GET'
                                  ,'path' => array('Legosoft', 'OperacionDueno','?')
                                  ,'pathVars' => array('', '', 'data')
                                  ,'method' => 'getDueno'
                                  ,'shortHelp' => 'Obtiene el dueño de la operación'
          ),
        );
    }

    /**
     * @param $api
     * @param $args
     * @return mixed
     */
    public function getDueno($api, $args)
    {
        $op = $args['data'];
        global $db, $current_user;
        $operacion = BeanFactory::getBean('Opportunities',$op);
        $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> Usuario: " .$operacion->assigned_user_id);
        $usuario = BeanFactory::getBean('Users',$operacion->assigned_user_id);
        $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> user name: " .$usuario->user_name);


        $resultado = array(
            'user_name' => $usuario->user_name,
            'name' => $usuario->name
        );
        return $resultado;

    }
}
