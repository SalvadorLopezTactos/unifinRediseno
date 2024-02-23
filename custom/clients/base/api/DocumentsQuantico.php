<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");

class DocumentsQuantico extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'retrieve' => array(
                'reqType' => 'GET',
                'path' => array('DownloadDocumentQuantico'),
                'pathVars' => array('method'),
                'method' => 'getDocumentQuantico',
                'shortHelp' => 'Descarga documento de Quantico',
            ),
        );
    }

    public function getDocumentQuantico($api, $args)
    {
        global $sugar_config;

        $idDoc = $args['idDoc'];
        $version = $args['version'];
        $user = $sugar_config['quantico_usr'];
        $pwd = $sugar_config['quantico_psw'];
        $auth_encode = base64_encode($user . ':' . $pwd);
        $host = $sugar_config['quantico_expediente_url'];

        $url = $host. "/CreditRequestIntegration/rest/ExpedientDocument/DowloadDocumentDyn";

        $callApi = new UnifinAPI();

        $body = array(
            "Field"=> $idDoc,
            "Version"=> $version
        );

        $response = $callApi->postQuantico($url, $body, $auth_encode);

        return $response;
    }
}
