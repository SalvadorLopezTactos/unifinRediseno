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
     * Función que lee el archivo csv generado a través del API CrearArchivoCSV, guardado en el directorio upload
     * return $array, nombre del archivo csv generado y contenido a descargar
     */
    public function downloadFileBL(ServiceBase $api, $args)
    {
        global $sugar_config;
        $name_file=$args['name_file'];

        $csvfile = $sugar_config['upload_dir'] . $name_file;

        $content=file_get_contents($csvfile);

        //Convirtiendo contenido del archivo a codificación UTF8 para evitar conflictos con caracteres especiales como acentos
        $content_clean=mb_convert_encoding($content, 'UTF-8',
            mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));

        return array($content_clean,$name_file);
    }

}

?>
