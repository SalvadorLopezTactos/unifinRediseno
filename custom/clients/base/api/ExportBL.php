<?php
/**
 * Created by PhpStorm.
 * User: salvador.lopez@tactos.com.mx
 * Date: 07/03/19
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ExportBL extends SugarApi
{

    /**
     * Registro de todas las rutas para consumir los servicios del API
     *
     */
    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('ExportBL', '?'),
                //endpoint variables
                'pathVars' => array('method', 'name_file'),
                //method to call
                'method' => 'downloadFileBL',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Descarga de archivo CSV de registros de Backlog',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    /**
     *
     */
    public function downloadFileBL(ServiceBase $api, $args)
    {
        global $sugar_config;
        $name_file=$args['name_file'];

        $csvfile = $sugar_config['upload_dir'] . $name_file;

        $content=file_get_contents($csvfile);

        $api->setHeader("Pragma", "cache");
        $api->setHeader("Content-Type", "application/octet-stream; charset=" . $GLOBALS['locale']->getExportCharset());
        $api->setHeader("Content-Disposition", "attachment; filename="+$name_file);
        $api->setHeader("Content-transfer-encoding", "binary");
        $api->setHeader("Expires", "Mon, 26 Jul 1997 05:00:00 GMT");
        $api->setHeader("Last-Modified", TimeDate::httpTime());
        $api->setHeader("Cache-Control", "post-check=0, pre-check=0");
        /*
        return $GLOBALS['locale']->translateCharset(
            $content,
            'UTF-8',
            $GLOBALS['locale']->getExportCharset(),
            false,
            true
        );
        */
        return $content;

    }




}

?>
