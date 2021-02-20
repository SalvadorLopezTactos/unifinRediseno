<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class callvicidial extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'callvicidial' => array(
                'reqType' => 'POST',
                'noLoginRequired' => true,
                'path' => array('callvicidial'),
                'pathVars' => array('method'),
                'method' => 'vicidial',
                'shortHelp' => 'Invoca URL de Vicidial',
            ),
        );
    }

    public function vicidial($api, $args){
        $url = $args['url'];
        $GLOBALS['log']->fatal("URL: ".$url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $GLOBALS['log']->fatal("Resultado: ". $result);
        return $result;
    }
}