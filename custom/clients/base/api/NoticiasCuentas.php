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
      /*
        global $db, $current_user, $app_list_strings;
        $noticia = $args['data']['noticia'];
        $idUsuario = $args['data']['idUser'];
        $resultado = [];
        $resultado['estado']="";
        $resultado['descripcion']="";

        //Valida existencia de idReunion
        if(empty($noticia)|| $noticia == "" ){
            return false;
        }

        //Guarda contenido
        $filename = 'custom/pdf/noticiaGeneral.txt';
        $somecontent = $noticia;

        // Let's make sure the file exists and is writable first.
        if (is_writable($filename)) {

            // In our example we're opening $filename in append mode.
            // The file pointer is at the bottom of the file hence
            // that's where $somecontent will go when we fwrite() it.
            if (!$handle = fopen($filename, 'a')) {
                 $resultado['descripcion'] "Cannot open file ($filename)";
                 return $resultado;
            }

            // Write $somecontent to our opened file.
            if (fwrite($handle, $somecontent) === FALSE) {
                $resultado['descripcion']= "Cannot write to file ($filename)";
                return $resultado;
            }

            $resultado['descripcion']= "Success, wrote ($somecontent) to file ($filename)";
            fclose($handle);

        } else {
            $resultado['descripcion']= "The file $filename is not writable";
        }
*/
        return $resultado;

    }

}
