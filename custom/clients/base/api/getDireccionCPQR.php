<?php

/**
 * Created by Tactos.
 * User: JG
 * Date: 30/06/20
 * Time: 06:42 PM
 * config_override
 * $sugar_config['url_scan_qr'] = 'http://192.168.150.95:18090/scan';
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/clients/base/api/GetDireccionesCP.php');

class getDireccionCPQR extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'retrieve' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('DireccionesQR', '?', '?', '?', '?','?'),
                'pathVars' => array('module', 'cp', 'indice', 'colonia_rfc', 'ciudad_rfc','entidad_rfc'),
                'method' => 'getAddressByCPQR',
                'shortHelp' => 'Método GET para obtener información relacionada al Código Postal.',
                'longHelp' => 'y compara que la colonia y cuidad exista. En caso contrario la agrega como nueva',
            ),

        );

    }

    public function getAddressByCPQR($api, $args)
    {
        $colonia_QR = $args['colonia_rfc'];
        $cod_postal=$args['cp'];
        $ciudad_QR = $args['ciudad_rfc'];
        $estado_QR = $args['entidad_rfc'];
        $call_api = new GetDireccionesCP();
        //$GLOBALS['log']->fatal('args',$args);
        $resultado = $call_api->getAddressByCP($api, $args);
        //$GLOBALS['log']->fatal('resultado',$resultado);
        $arr_colonias = $resultado['colonias'];
        $pais_id = intval(substr($resultado['idCP'], 0, 3));
        $estado_id = intval(substr($resultado['idCP'], 3, 3));
        $municipio_id = intval(substr($resultado['idCP'], 6, 3));

        $arr_estado = $resultado['estados'];
        $arr_municipio = $resultado['municipios'];        
        
        $colonia_existe = false;
        $aux = null;
        $arrin=null;
        $auxindex = array_search($colonia_QR,$arr_colonias,false);


        if( $auxindex != '-1'){
            $arrin = array( $auxindex => $arr_colonias[$auxindex], );
            $aux = array( 'colonias'=> $arrin);
            $arr_colonias = $aux;
            $colonia_existe = true;
        }else{
            foreach ($arr_colonias as $colonia) {
                if ($colonia['nameColonia'] == $colonia_QR) {
                    $colonia_existe = true;
                }
            }  
        }        
        unset($resultado['colonias']); 
        $resultado = array_replace($resultado, $arr_colonias);        
        
        $auxindex = array_search($estado_QR,$arr_estado,false);
        if( $auxindex != '-1'){
            $arrin = array( $auxindex => $arr_estado[$auxindex], );
            $aux = array( 'estados'=> $arrin);
            $arr_estado = $aux;
            $estado_id = $auxindex;
        }
        unset($resultado['estados']); 
        $resultado = array_replace($resultado, $arr_estado);        
        //$GLOBALS['log']->fatal('resultado',$resultado);
        
        $auxindex = array_search($ciudad_QR,$arr_municipio,false);
        if( $auxindex != '-1'){
            $arrin = array( $auxindex => $arr_municipio[$auxindex], );
            $aux = array( 'municipios'=> $arrin);
            $arr_municipio = $aux;
            $municipio_id = $auxindex;
        }
        unset($resultado['municipios']); 
        $resultado = array_replace($resultado, $arr_municipio);        
        //$GLOBALS['log']->fatal('resultado',$resultado);
       
        if(!$colonia_existe)
        {
            $result=$this->insertColonia($pais_id,$estado_id,$municipio_id,$cod_postal,$colonia_QR);
            $resultado = $call_api->getAddressByCP($api, $args);
        }

        return $resultado;
    }

    public function insertColonia($pais,$estado,$municipio,$cp,$colonia)
    {
        global $sugar_config;
        $host = $sugar_config['url_uniclick_direcciones'];
        $url = $host . '/rest/uniclick/direccion/insertColonia';
        $timeout = 500;
        $error_report = FALSE;

        $headers = array(
            'Content-Type:application/json',
        );
        $data = json_encode(
            array(
                "idPais" => $pais,
                "idEstado" => $estado,
                "idMunicipio" => $municipio,
                "colonia" => $colonia,
                "cp" => $cp
            )
        );

        $GLOBALS['log']->fatal("jsonas " . $data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);

        try {
            $response = curl_exec($curl);
            $GLOBALS['log']->fatal("respuesta servicio colonia\n" . $response);
            curl_close($curl);
        } catch (Exception $ex) {
            $GLOBALS['log']->fatal("Error al ejecutar Insert de colonia" . $ex);

        }


        return $response;
    }

    public function insertCiudad()
    {
        $host = '';
        $url = $host . '/rest/uniclick/direccion/insertCiudad';
        $timeout = 500;
        $error_report = FALSE;

        $headers = array(
            'Content-Type:application/json',
        );
        $data = json_encode(
            array(
                "idPais" => 2,
                "idEstado" => 5,
                "ciudad" => "texto",
            )
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);

        try {
            $response = curl_exec($curl);
            $GLOBALS['log']->fatal("respuesta servicio colonia\n" . $response);
            curl_close($curl);
        } catch (Exception $ex) {
            $GLOBALS['log']->fatal("Error al ejecutar Insert de colonia" . $ex);
        }
    }


}