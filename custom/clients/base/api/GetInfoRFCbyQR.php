<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 01/06/2020
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetInfoRFCbyQR extends SugarApi
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
                'reqType' => 'POST',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('GetInfoRFCbyQR'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'getInfoByImageRFC',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que realiza petición a servicio externo que obtiene información de RFC a través de QR',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    /**
     * Obtiene información correspondiente a RFC a partir de imagen QR
     **
     * @param array $api
     * @param array $args Array con los parámetros enviados para su procesamiento
     * @return array $response Array información relacionada con el RFC pasado como QR
     */
    public function getInfoByImageRFC($api, $args){
        global $sugar_config;

        $base64_img=$args['file'];
        $url=$sugar_config['url_scan_qr'];

        $imagen_rfc=$this->generateImage($base64_img);

        $file_name_with_full_path=$imagen_rfc;

        $cFile=$this->prepareImageToParameter($file_name_with_full_path);

        $post = array('file'=> $cFile);

        $response=$this->callScanQR($url,$post);

        if ($response[0]['Código de error']!="" && $response[0]['Código de error']!=null){
            $this->deleteFile($file_name_with_full_path);
        }else{
            //Se agrega nuevo elemento a la respuesta para guardar ruta del QR creado
            $response[0]['path_img_qr']=$file_name_with_full_path;
        }

       // $this->deleteFile($file_name_with_full_path);

        return $response;

    }

    /*
     * Función que toma una imagen codificada en base64 y la convierte en una imagen real dentro de una ruta temporal
     * @param String $img, Imagen codificada en base64
     * @return String $file, Nombre de la imagen 'real' generada
     * */
    public function generateImage($img){

        $folderPath = "custom/qr/";

        $image_parts = explode(";base64,", $img);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $file = $folderPath .'QR_RFC_'. uniqid() . '.png';

        file_put_contents($file, $image_base64);

        return $file;

    }

    /*
     * Función que toma un archivo con su ruta y lo codifica en su respectivo formato para enviarlo como parámetro tipo 'File' a un servicio que espera un multipart/form-data
     * @param String $file_name_with_full_path, Ruta del archivo a procesar
     * @return String $cFile, Archivo codificado para enviar como parámetro a servicio
     * */
    public function prepareImageToParameter($file_name_with_full_path){

        if (function_exists('curl_file_create')) { // php 5.5+
            $cFile = curl_file_create($file_name_with_full_path);
        } else { //
            $cFile = '@' . realpath($file_name_with_full_path);
        }

        return $cFile;
    }

    /*
     * Función realiza petición a servicio que se expone para scanear un código QR a través de una imagen pasada como parámetro
     * @param String $url, Endpoint a consumir
     * @return array $body, Arreglo con la definición de los parámetros que recibe el endpoint
     * */
    public function callScanQR($url,$body){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        $result=curl_exec ($ch);

        curl_close ($ch);

        return json_decode($result, true);

    }

    /*
     * Elimina archivo de la ruta especificada
     * @param String $file_name, Nombre de archivo con su ruta completa
     * */
    public function deleteFile($file_name){
        unlink($file_name);

    }


}

?>
