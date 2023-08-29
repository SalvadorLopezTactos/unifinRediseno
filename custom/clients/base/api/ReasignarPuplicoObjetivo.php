<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 7/20/2015
 * Time: 4:00 PM
 */

require_once("custom/Levementum/DropdownValuesHelper.php");
require_once("custom/Levementum/UnifinAPI.php");
require_once('config_override.php');

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ReasignarPuplicoObjetivo extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POSTreasignarPO' => array(
                'reqType' => 'POST',
                'path' => array('reasignarPO'),
                'pathVars' => array(''),
                'method' => 'asignarNuevoPromotorPO',
                'shortHelp' => 'Reasigna registros de PO a nuevo usuario',
            ),
        );
    }

    public function asignarNuevoPromotorPO($api, $args)
    {
	  try {
            global $db, $current_user;
            $actualizados = array();
            $no_actualizados = array();
            $nuevoUsuarioAsignado = $args['data']['reasignado'];
            $prospects = $args['data']['prospects'];

            for ($i=0; $i < count($prospects); $i++) {

                $GLOBALS['log']->fatal("Reasignando prospecto: ". $prospects[$i] );

                $prospect = BeanFactory::retrieveBean('Prospects', $prospects[$i], array('disable_row_level_security' => true));
                $prospect->assigned_user_id = $nuevoUsuarioAsignado;
                $prospect->save();

                array_push( $actualizados, $prospect->id );

            }
        }catch (Exception $e) {
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Error al reasignar la cuenta ".$cuenta." ".$e->getMessage());
        }
          
        return $actualizados;

    }

}
