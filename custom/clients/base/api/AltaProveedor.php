<?php
/*/**
 * Created by Adrian Arauz
 * Date: 01/09/21
 * Time: 14:25 PM
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");

class AltaProveedor extends SugarApi
{

    public function registerApiRest()
    {
        return array(
                'GETAltaProveedor' => array(
                'reqType' => 'GET',
                'path' => array('AltaProveedor','?'),
                'pathVars' => array('', 'id'),
                'method' => 'usuarioProveedores',
                'shortHelp' => 'Consumo para dar de alta a Proveedor en CRM',
            ),
        );
    }

public function usuarioProveedores($api, $args){

        global $app_list_strings, $current_user,$sugar_config,$db;
        $idaccount = $args['id'];
        $response=array();
        $account = BeanFactory::retrieveBean('Accounts', $idaccount, array('disable_row_level_security' => true));
        $host1=$sugar_config['bpm_url'].'/uni2/rest/proveedor/crm/getUserProveedor?uuidProveedor='.$idaccount;
        //Ejecuta primer servicio para validar que exista usuario en Proveedores, si no existe ejecuta segundo servicio
        try {
            $GLOBALS['log']->fatal('Realiza consumo primer servicio para validar existencia de proveedor en portal');
            
            $url = $host1;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $result = curl_exec($ch);
            $curl_info = curl_getinfo($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $response1 = json_decode($result, true);
            $GLOBALS['log']->fatal($host1);
            $GLOBALS['log']->fatal("Respuesta primer servicio: " . print_r($response1, true));
        } catch (Exception $exception) {
        }
        if ($response1['usuarioPortalValido']==null){
            if ($account->tipo_registro_cuenta_c == '5' || $account->esproveedor_c == 1) {
                $host = $sugar_config['esb_url']. '/uni2/rest/creaUsuarioProveedor';
    
                $tipoProveedor = 'BIENES';
                $paisConstitucion = '';
                $estadoConstitucion = '';
    
                $list = $app_list_strings['tipo_proveedor_list'];
                if (isset($list)) {
                    $tipo_proveedor = str_replace('^', '', $account->tipo_proveedor_c);
                    $tipos = explode(',', $tipo_proveedor);
                    foreach ($tipos as $tipo) {
                        $tipoProveedor = ($list[$tipo] == '' ? 'BIENES' : $list[$tipo]);
                        if ($tipoProveedor == 'BIENES') {
                            break;
                        }
                    }
                }
    
                $list = $app_list_strings['paises_list'];
                if (isset($list)) {
                    $paisConstitucion = $list[$account->pais_nacimiento_c];
                }
    
                $list = $app_list_strings['estados_list'];
                if (isset($list)) {
                    $estadoConstitucion = $list[$account->estado_nacimiento_c];
                }
                if (($timestamp = strtotime($account->tipodepersona_c == 'Persona Moral' ? $account->fechaconstitutiva_c : $account->fechadenacimiento_c)) === false) {
                    $timestamp = strtotime("now");
                }
    
                $fields = array(
                    "rfcProveedor" => $account->rfc_c,
                    "guid" => $account->id,
                    "email" => $account->emailAddress->getPrimaryAddress($account),
                    "primerNombreRazonSocial" => $account->tipodepersona_c == 'Persona Moral' ? $account->razonsocial_c : $account->primernombre_c . ' ' . $account->apellidopaterno_c . ' ' . $account->apellidomaterno_c,
                    "anioNacimiento" => intval(date('Y', $timestamp)),
                    "mesNacimiento" => intval(date('n', $timestamp)),
                    "diaNacimiento" => intval(date('j', $timestamp)),
                    "tipoProveedor" => $tipoProveedor,
                    "tipoPersona" => $account->tipodepersona_c,
                    "paisConstitucion" => ucfirst(strtolower($paisConstitucion)),
                    "estadoConstitucion" => ucfirst(strtolower($estadoConstitucion))
                );
    
                $GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <CVV LOG> : Petición Alta Portal Proveedores: " . $host);
                $GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <CVV LOG> : JSON para usuarios de proveedores por boton" . print_r($fields, 1));
                try {
                    $callApi = new UnifinAPI();
                    $proveedor = $callApi->unifinpostCall($host, $fields);
                    $GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <CVV LOG> : Respuesta de servicio para usuarios de proveedores por boton" . print_r($proveedor, 1));
                    if ($proveedor['resultDescription']=='Succes' || $proveedor['resultDescription']=='Success') {
                        $response['status']='200';
                        $response['message']='Se creó el registro de proveedor de forma exitosa.';
                        //Update a campo nuevo
                        $query = " UPDATE accounts_cstm SET alta_portal_proveedor_chk_c = '1' WHERE id_c = '{$account->id}';";
                        $GLOBALS['log']->fatal($query);
                        $queryResult = $db->query($query);
                    }else {
                        $response['status']='400';
                        $response['message']='Error al procesar la petición. Intente nuevamente.';
                    }
                } catch (Exception $e) {
                    $GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> : Error " . $e->getMessage());
                    $response['status']='400';
                    $response['message']=$e->getMessage();
                }
            }else{
                $response['status']='400';
                $response['message']='La cuenta debe ser de tipo proveedor';
            }
        }else{
            $query = " UPDATE accounts_cstm SET alta_portal_proveedor_chk_c = '1' WHERE id_c = '{$account->id}';";
            $GLOBALS['log']->fatal($query);
            $queryResult = $db->query($query);
            $response['status']='300';
            $response['message']='Esta cuenta ya existe en el portal de Proveedores.';
        }
        return $response;
    }

}
