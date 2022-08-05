<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 7/1/2015
 * Time: 9:59 PM
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class Ratificado extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'postRatificado' => array(
                'reqType' => 'POST',
                'path' => array('Opportunities', 'Ratificado'),
                'pathVars' => array('',''),
                'method' => 'ratificar',
                'shortHelp' => 'Crea una operacion ratificada',
            ),
        );
    }

    public function ratificar($api, $args)
    {

//        global $current_user;
//        $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : ARGS " . print_r($args,true));
//        $parentOpp = BeanFactory::getBean('Opportunities');
//        $parentOpp->retrieve($args['data']['parentId']);
//
//        $opp = BeanFactory::getBean('Opportunities');
//        $opp->name = "R/I para " . $parentOpp->name;
//        $opp->monto_c = $args['data']['monto'];
//        $opp->account_id = $args['data']['relatedAccount'];
//        $opp->tipo_de_operacion_c = 'RATIFICACION_INCREMENTO';
//        $opp->opportunities_opportunities_1opportunities_ida = $args['data']['parentId'];
//        $opp->assigned_user_id = $current_user->id;
//        $opp->id_linea_credito_c = $parentOpp->id_linea_credito_c;
//        $opp->id_activo_c = $parentOpp->id_activo_c;
//        $opp->index_activo_c = $parentOpp->index_activo_c;
//        $opp->plazo_c = $parentOpp->plazo_c;
//        $opp->activo_c = $parentOpp->activo_c;
//        $opp->sub_activo_c = $parentOpp->sub_activo_c;
//        $opp->sub_activo_2_c = $parentOpp->sub_activo_2_c;
//        $opp->sub_activo_3_c = $parentOpp->sub_activo_3_c;
//        $opp->date_closed = date("Y-m-t", strtotime(date("Y-m-d")));;
//
//        $opp->save();
//
//        $parentOpp->tipo_de_operacion_c = 'RATIFICACION_INCREMENTO';
//        $parentOpp->save();
//
//        return $opp->id;
    }

}

