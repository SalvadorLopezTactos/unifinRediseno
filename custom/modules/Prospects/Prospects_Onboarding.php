<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("custom/Levementum/UnifinAPI.php");
class Prospects_Onboarding
{
    function setFlagReadOnly($bean, $event, $arguments){
        if( $GLOBALS['service']->platform != 'base' ){
            $GLOBALS['log']->fatal("Prospecto proviene de api");
            $bean->read_only_empresa_c = 1;
        }
    }

    public function updateApiOnboarding($bean = null, $event = null, $args = null){
        global $sugar_config;

        if( $args['isUpdate'] ){
            $callApi = new UnifinAPI();
            $hostOnboarding = $sugar_config['hostOnboarding'];
            $tokenOnboarding = $sugar_config['tokenOnboarding'];
            $idPO = $bean->id;

            $urlOnboarding = $hostOnboarding . $idPO."/"; 

            $body = array(
                "name" => $bean->nombre_c,
                "last_name" => $bean->apellido_paterno_c,
                "mother_last_name" => $bean->apellido_materno_c,
                "business_name" => $bean->empresa_po_c,
                "phone" => $bean->phone_mobile
            );
            
            $GLOBALS['log']->fatal("Request PO Onboarding");
            $GLOBALS['log']->fatal(print_r( $body,true ));

            $resp = $callApi->postOnboardingPO($urlOnboarding, $tokenOnboarding ,$body);

            $GLOBALS['log']->fatal("Response PO Onboarding");
            $GLOBALS['log']->fatal(print_r($resp, true));
            
        }
         

    }
}