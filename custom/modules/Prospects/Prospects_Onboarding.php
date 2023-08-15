<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Prospects_Onboarding
{
    function setFlagReadOnly($bean, $event, $arguments){
        if( $GLOBALS['service']->platform != 'base' ){
            $GLOBALS['log']->fatal("Prospecto proviene de api");
            $bean->read_only_empresa_c = 1;
        }
    }
}