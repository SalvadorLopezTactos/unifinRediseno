<?php
/*/**
 * Created by Adrian Arauz
 * Date: 01/09/21
 * Time: 14:25 PM
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");
global $sugar_config;
$GLOBALS['esb_url'] = $sugar_config['esb_url'];

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
        $idaccount = $args['id'];
        $account = BeanFactory::retrieveBean('Accounts', $idaccount);
        $response=array();
        $GLOBALS['log']->fatal("Entra usuarioProveedores");
        if ($account->tipo_registro_cuenta_c == '5' || $account->esproveedor_c == 0) {
            global $app_list_strings, $current_user;
            $host = 'http://' . $GLOBALS['esb_url'] . '/uni2/rest/creaUsuarioProveedor';

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

            $GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <CVV LOG> : JSON para usuarios de proveedores por boton" . print_r($fields, 1));

            try {
                $callApi = new UnifinAPI();
                $proveedor = $callApi->unifinpostCall($host, $fields);
                if (strpos($proveedor, 'exitosamente')) {
                    $GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <CVV LOG> : Respuesta de servicio para usuarios de proveedores por boton" . print_r($proveedor, 1));

                    $response['status']='200';
                    $response['message']='Se creó el registro de proveedor de forma correcta';
                }
            } catch (Exception $e) {
                error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> : Error: " . $e->getMessage());
                $GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> : Error " . $e->getMessage());
                $response['status']='400';
                $response['message']='Hubo un problema al crear el proveedor.';
            }
        }
        $GLOBALS['log']->fatal("Termina usuarioProveedores");

        return $response;
    }

}   