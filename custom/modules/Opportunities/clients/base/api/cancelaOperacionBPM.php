<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 8/26/2015
 * Time: 4:37 PM
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");
class cancelaOperacionBPM extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POST_cancelaOperacionBPM' => array(
                'reqType' => 'POST',
                'path' => array('cancelaOperacionBPM'),
                'pathVars' => array('',''),
                'method' => 'cancelaOperacion',
                'shortHelp' => 'Cancela Una Operacion en la BPM de Unifin',
            ),
        );
    }

    public function cancelaOperacion($api, $args)
    {
        global $current_user;
        try
        {
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : ARGS " . print_r($args,true));
            $idSolicitud = $args['data']['idSolicitud'];
            $usuarioAutenticado = $args['data']['usuarioAutenticado'];

            $callApi = new UnifinAPI();
            $cancelaOPP = $callApi->cancelaOppBpm($idSolicitud, $usuarioAutenticado);
            return $cancelaOPP;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }
    }
}