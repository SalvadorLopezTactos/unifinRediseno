<?php
/**
 * @author: Tactos.AF 2019-09-09
 * Enpoint habilitado para guardar información de noticias generales para cuenta
 *
 */


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/utils.php');
class NoticiasCuentas extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POST_Noticias_Cuentas' => array(
                'reqType' => 'POST',
                'path' => array('guardaNoticia'),
                'pathVars' => array(''),
                'method' => 'guardaNoticiaMethod',
                'shortHelp' => 'Guarda noticia general para vista 360 en cuentas',
            ),

            'GET_Noticias_Cuentas' => array(
                'reqType' => 'GET',
                'path' => array('recuperaNoticia'),
                'pathVars' => array(''),
                'method' => 'recuperaNoticiaMethod',
                'shortHelp' => 'Recupera noticia general para vista 360 en cuentas',
            ),
           'POST_Noticias_PDF' => array(
                'reqType' => 'POST',
                'path' => array('guardaNoticiaPDF'),
                'pathVars' => array(''),
                'method' => 'guardaNoticiaPDFMethod',
                'shortHelp' => 'Guarda archvio pdf para vista 360 en cuentas',
            ),
        );
    }

    public function guardaNoticiaMethod ($api, $args){
        //Recupera variables

        global $db, $current_user, $app_list_strings;
        $noticia = $args['data']['noticiaGeneral'];
        $idUsuario = $args['data']['idUser'];
        $resultado = [];
        $resultado['estado']="";
        $resultado['descripcion']="";
        $GLOBALS['log']->fatal('Recupera variables');

        //Valida existencia de idReunion
        if(empty($noticia)|| $noticia == "" ){
            return false;
        }

        //Guarda contenido
        $filename = 'custom/pdf/noticiaGeneral.txt';
        //$somecontent = $noticia;
        file_put_contents($filename, $noticia);
        $GLOBALS['log']->fatal('Declara contenido del txt');


        // Verifica que el archivo puede ser escrito primero.
        if (is_writable($filename)) {

           //Valida para poder escribir en el archivo (si este está protegido contra escritura).
            if (!$handle = fopen($filename, 'a')) {
                 $resultado['descripcion'] ="Cannot open file ($filename)";
                 return $resultado;
            }

            // Escribe $somecontent en nuestro archivo abierto.
            if (fwrite($handle, $somecontent) === FALSE) {
                $resultado['descripcion']= "Cannot write to file ($filename)";
                return $resultado;
            }

            $resultado['descripcion']= "Success, wrote ($somecontent) to file ($filename)";
            fclose($handle);

        } else {
            $resultado['descripcion']= "The file $filename is not writable";
        }
        return $resultado;
    }


    public function recuperaNoticiaMethod ($api, $args){
        //Recupera variables
        $resultado['descripcion']="";
        global $db, $current_user, $app_list_strings;
        $noticia = $args['data']['noticiaGeneral'];
        $idUsuario = $args['data']['idUser'];
        $filename = 'custom/pdf/noticiaGeneral.txt';
        $resultado = [];
        $resultado['estado']="";

        //funcion fopen abre el archivo con la ruta del mismo y el mode r (read)
        $file = fopen( $filename,"r");
        //Controla accion del archivo ($resultado contiene la info del archivo abierto)
        while(!feof($file)) {
            $resultado['descripcion'] .= fgets($file);
        }
        //Cierra el archivo
        fclose($file);
        return $resultado;
    }


    public function guardaNoticiaPDFMethod ($api, $args)
    {

        global $db, $current_user, $app_list_strings;
        //Definir argumento (obtenido del js del archivo
        $archivopdf = $args['data']['documento'];
        // Nombre del archivo
        $name = "NoticiasUnifin.pdf";
        //Ruta del archivo
        $rute = "custom/pdf/" . $name;
        //Se elimina la cabecera de la data codificada (encode)
        $archivopdf = str_replace('data:application/pdf;base64,', '', $archivopdf);
        // decodificar a base64
        $decodeFile = base64_decode($archivopdf);
        // Copiar el contenido de la data al pdf
        file_put_contents($rute, $decodeFile);
    }
}
