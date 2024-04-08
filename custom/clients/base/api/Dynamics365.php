<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 19/08/18
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Dynamics365 extends SugarApi
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
                'path' => array('Dynamics365'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'setRequestDynamics',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Integración con Dynamics 365',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );
    }

    public function setRequestDynamics($api, $args)
    {
        global $sugar_config;
        global $db;
        //Obtiene parámetros, el id de cuenta
        $idCuenta = $args['accion'];
        $idCuentaBancaria = isset($args['idCuentaBancaria']) ? $args['idCuentaBancaria'] : '';
        $host = $sugar_config['dynamics_token_host'];
        $client_id = $sugar_config['dynamics_token_client_id'];
        $client_secret = $sugar_config['dynamics_token_client_secret'];
        $resource = $sugar_config['dynamics_token_resource'];

        //Comienza integración Cuentas por pagar
        $urlCPP = $sugar_config['dynamics_cuentas_por_pagar_host'];
        //$urlCPP=="http://172.26.1.84:9011/proveedores/EnvioCuentasPorPagar365";

        //Prepara token request
        $request = array(
            'grant_type' => 'client_credentials',
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'resource' => $resource
        );

        //Llamada a api para obtener token
        $response = $this->postDynamicsRequest($host, $request);
        $token = $response->access_token;
        //$GLOBALS['log']->fatal('Dynamics request: '. $request);
        //$GLOBALS['log']->fatal('Dynamics token: '. $token);
        $token_format = array("Authorization: Bearer " . $token);

        /*
         * Se obtienen datos de la Cuenta para armar cuerpo de la petición
         * */
        $beanCuenta = BeanFactory::getBean('Accounts', $idCuenta);

        $tipo_cuenta = $beanCuenta->tipo_registro_cuenta_c;
        $es_proveedor = $beanCuenta->esproveedor_c;
        $records_list = array();
        $url_endpoint = "";

        if ($tipo_cuenta == '3') { //tipo_registro_cuenta_c 3 = Cliente
            $url_endpoint = '/api/services/UNF_ClientServicesGrp/UNF_ClientServices/createClient';
            //Obtener régimen fiscal
            $regimen_fiscal = $beanCuenta->tipodepersona_c;

            $body_elements = array();
            $body_elements["DataAreaId"] = "UFIN";
            $body_elements["CUSTOMERACCOUNTNUMBER"] = $beanCuenta->idcliente_c;
            //$body_elements["COMPANYTYPE"]=($beanCuenta->pais_nacimiento_c=='2') ? "LegalPerson" : "ForeignCompany";
            $body_elements["CURRENCYCODE"] = "MXN";
            $body_elements["LANGUAGEID"] = "es-MX";

            if ($regimen_fiscal != 'Persona Moral') {
                //Se arma petición para enviar proveedor de Persona Física o PFAE
                $body_elements["CUSTOMERPARTYTYPE"] = "Person";
                $body_elements["COMPANYTYPE"] = ($beanCuenta->pais_nacimiento_c == '2') ? "LegalPerson" : "ForeignCompany";
                $body_elements["PERSONFIRSTNAME"] = $beanCuenta->primernombre_c;
                $body_elements["PERSONLASTNAME"] = $beanCuenta->apellidopaterno_c . " " . $beanCuenta->apellidomaterno_c;
                $body_elements["PERSONMIDDLENAME"] = "";
            } else {
                /*
                $body_elements["PERSONFIRSTNAME"]=$beanCuenta->razonsocial_c;
                $body_elements["PERSONLASTNAME"]="";
                $body_elements["PERSONMIDDLENAME"]="";
                */

                $body_elements["CUSTOMERPARTYTYPE"] = "Organization";
                $body_elements["COMPANYTYPE"] = ($beanCuenta->pais_nacimiento_c == '2') ? "LegalEntity" : "ForeignCompany";
                $body_elements["CUSTOMERORGANIZATIONNAME"] = $beanCuenta->razonsocial_c;
                $body_elements["CUSTOMERSEARCHNAME"] = $beanCuenta->razonsocial_c;
            }
            $body_elements["RFCFEDERALTAXNUMBER"] = $beanCuenta->rfc_c;
            $body_elements["CUSTOMERGROUPID"] = "CLIENTES";

            //Recupera dirección
            $beanCuenta->load_relationship('accounts_dire_direccion_1');
            foreach ($beanCuenta->accounts_dire_direccion_1->getBeans() as $a_direccion) {
                if (!empty($a_direccion->calle)) {
                    //Arma petición para enviar dirección
                    $body_elements["ADDRESSCITY"] = $a_direccion->dire_direccion_dire_ciudad_name;
                    $body_elements["ADDRESSCOUNTRYREGIONID"] = "MEX";
                    $body_elements["ADDRESSCOUNTYID"] = $a_direccion->dire_direccion_dire_colonia_name;
                    $body_elements["ADDRESSDESCRIPTION"] = "PRINCIPAL";
                    $body_elements["ADDRESSLOCATIONROLES"] = "Business";
                    $body_elements["ADDRESSSTATEID"] = "CDMX"; //CATÁLOGO DE ID DE ESTADOS
                    $body_elements["ADDRESSSTREET"] = $a_direccion->calle;
                    $body_elements["ADDRESSSTREETNUMBER"] = $a_direccion->numext;
                    $body_elements["ADDRESSZIPCODE"] = $a_direccion->dire_direccion_dire_codigopostal_name;
                }
            }

            $body_elements["PRIMARYEMAILADDRESS"] = $beanCuenta->email1;
            $body_elements["PRIMARYEMAILADDRESSDESCRIPTION"] = "PRINCIPAL";
            $body_elements["PRIMARYEMAILADDRESSPURPOSE"] = "Business";

            $body_elements["DEFAULTPAYMENTDAYNAME"] = "LUNES";
            $body_elements["DEFAULTPAYMENTTERMSNAME"] = "CONTADO";
            $body_elements["DEFAULTVENDORPAYMENTMETHODNAME"] = "TRANSFER";

            //Recupera cuentas bancarias
            if (empty($idCuentaBancaria)) {
                //Acción ejecutada para rpocesar todas las cuentas bancarias asociadas
                $beanCuenta->load_relationship('cta_cuentas_bancarias_accounts');
                $GLOBALS['log']->fatal('Recupera cuenta bancaria');
                foreach ($beanCuenta->cta_cuentas_bancarias_accounts->getBeans() as $ctaBancaria) {
                    //Valida Cuenta bancaria: Sólo procesa cuentas bancarias con clabe interbancaria
                    //$GLOBALS['log']->fatal('Itera cuenta bancaria');
                    if (strlen($ctaBancaria->clabe) >= 8) {
                        //$GLOBALS['log']->fatal('Entra cuenta bancaria: '. $ctaBancaria->name);
                        $divisa_id = $ctaBancaria->divisa_c;
                        $divisa_code = $this->getDivisaCode($divisa_id);
                        //Arma petición para enviar cuenta bancaria
                        global $app_list_strings;
                        $mapeoBancos = $app_list_strings['dynamics365_mapeo_bancos_list'];
                        $rutaBancaria = $app_list_strings['dynamics365_ruta_bancaria_list'];
                        $nombreBanco = $app_list_strings['banco_list'];
                        $idBancoDynamics = $mapeoBancos[$ctaBancaria->banco];
                        $body_elements["BANKGROUPID"] = $idBancoDynamics;
                        $body_elements["ROUTINGNUMBER"] = $rutaBancaria[$idBancoDynamics];

                        $valorBankAccountId = $this->getValorToVendorBankAccountId( $ctaBancaria->tipo_cuenta_c, $ctaBancaria );
                        $body_elements["VENDORBANKACCOUNTID"] = $this->getFormatCtaBancaria( $ctaBancaria->tipo_cuenta_c, $valorBankAccountId );
                        
                        $body_elements["BANKACCOUNTNUMBER"] = $ctaBancaria->clabe;
                        $body_elements["BANKACCOUNTNAME"] = $nombreBanco[$ctaBancaria->banco];
                        $body_elements["CURRENCYCODEACCOUNT"] = $divisa_code;
                        $records_list[] = $body_elements;
                    }
                }
            } else {
                // Acción ejecutada desde cuenta bancaria
                $ctaBancaria = BeanFactory::retrieveBean('cta_cuentas_bancarias', $idCuentaBancaria, array('disable_row_level_security' => true));
                if (strlen($ctaBancaria->clabe) >= 8) {
                    $divisa_id = $ctaBancaria->divisa_c;
                    $divisa_code = $this->getDivisaCode($divisa_id);
                    //Arma petición para enviar cuenta bancaria
                    global $app_list_strings;
                    $mapeoBancos = $app_list_strings['dynamics365_mapeo_bancos_list'];
                    $rutaBancaria = $app_list_strings['dynamics365_ruta_bancaria_list'];
                    $nombreBanco = $app_list_strings['banco_list'];
                    $idBancoDynamics = $mapeoBancos[$ctaBancaria->banco];
                    $body_elements["BANKGROUPID"] = $idBancoDynamics;
                    $body_elements["ROUTINGNUMBER"] = $rutaBancaria[$idBancoDynamics];

                    $valorBankAccountId = $this->getValorToVendorBankAccountId($ctaBancaria->tipo_cuenta_c, $ctaBancaria);
                    $body_elements["VENDORBANKACCOUNTID"] = $this->getFormatCtaBancaria($ctaBancaria->tipo_cuenta_c, $valorBankAccountId);

                    $body_elements["BANKACCOUNTNUMBER"] = $ctaBancaria->clabe;
                    $body_elements["BANKACCOUNTNAME"] = $nombreBanco[$ctaBancaria->banco];
                    $body_elements["CURRENCYCODEACCOUNT"] = $divisa_code;
                    $records_list[] = $body_elements;
                }
            }

            //Agrega registros en $records_list
            $itemVendor = array(
                'host' => $url_endpoint,
                'item' => $body_elements,
                'type' => 'Cliente'
            );
            $records_list[] = $itemVendor;
        }
        if ($tipo_cuenta == '5' || $es_proveedor) {
            $url_endpoint = '/api/services/TT_ProveedorServicesGrp/TT_ProveedorServices/createVendor';
            //Obtener régimen fiscal
            $regimen_fiscal = $beanCuenta->tipodepersona_c;
            //Genera estructura de petición para alta de proveedor

            $body_elements = array();
            $body_elements["DataAreaId"] = "UFIN";
            $body_elements["VENDORACCOUNTNUMBER"] = $beanCuenta->idcliente_c;
            $body_elements["CURRENCYCODE"] = "MXN";
            $body_elements["DIOTOPERATIONTYPE"] = "Other";
            $body_elements["DIOTVENDORTYPE"] = ($beanCuenta->pais_nacimiento_c == '2') ? "DomesticVendor" : "ForeignVendor";
            $body_elements["LANGUAGEID"] = "es-MX";
            if ($beanCuenta->pais_nacimiento_c == '2') {
                $body_elements["RFCFEDERALTAXNUMBER"] = $beanCuenta->rfc_c;
            } else {
                $body_elements["FOREIGNVENDORTAXREGISTRATIONID"] = "xexx000000000";
            }

            $body_elements["VENDORGROUPID"] = "PROV";
            $body_elements["PRIMARYEMAILADDRESS"] = $beanCuenta->email1;
            $body_elements["PRIMARYEMAILADDRESSDESCRIPTION"] = "PRINCIPAL";
            $body_elements["PRIMARYEMAILADDRESSPURPOSE"] = "Business";
            $body_elements["DEFAULTOFFSETACCOUNTTYPE"] = "Ledger";
            $body_elements["SALESTAXGROUPCODE"] = "IVA16%";
            $body_elements["DEFAULTVENDORPAYMENTMETHODNAME"] = "TRANSFER";
            //Persona Fisica y PFAE
            if ($regimen_fiscal != 'Persona Moral') {
                //Se arma petición para enviar proveedor de Persona Física o PFAE
                $body_elements["VENDORPARTYTYPE"] = "Person";
                $body_elements["COMPANYTYPE"] = ($beanCuenta->pais_nacimiento_c == '2') ? "LegalPerson" : "ForeignCompany";
                $body_elements["PERSONFIRSTNAME"] = $beanCuenta->primernombre_c;
                $body_elements["PERSONLASTNAME"] = $beanCuenta->apellidopaterno_c . " " . $beanCuenta->apellidomaterno_c;
                $body_elements["PERSONMIDDLENAME"] = "";
            } else {
                $body_elements["VENDORPARTYTYPE"] = "Organization";
                $body_elements["COMPANYTYPE"] = ($beanCuenta->pais_nacimiento_c == '2') ? "LegalEntity" : "ForeignCompany";
                $body_elements["VENDORORGANIZATIONNAME"] = $beanCuenta->razonsocial_c;
                $body_elements["VENDORSEARCHNAME"] = $beanCuenta->razonsocial_c;
            }

            //Recupera dirección
            $beanCuenta->load_relationship('accounts_dire_direccion_1');
            foreach ($beanCuenta->accounts_dire_direccion_1->getBeans() as $a_direccion) {
                if (!empty($a_direccion->calle)) {
                    //Arma petición para enviar dirección
                    $body_elements["ADDRESSDESCRIPTION"] = "PRINCIPAL";
                    $body_elements["ADDRESSLOCATIONROLES"] = "Business";
                    $body_elements["ADDRESSCOUNTRYREGIONID"] = "MEX";
                    $body_elements["ADDRESSZIPCODE"] = $a_direccion->dire_direccion_dire_codigopostal_name;
                    $body_elements["ADDRESSSTREET"] = $a_direccion->calle;
                    $body_elements["ADDRESSSTREETNUMBER"] = $a_direccion->numext;
                }
            }

            //Recupera cuentas bancarias
            if (empty($idCuentaBancaria)) {
                $beanCuenta->load_relationship('cta_cuentas_bancarias_accounts');
                //$GLOBALS['log']->fatal('Recupera cuenta bancaria');
                foreach ($beanCuenta->cta_cuentas_bancarias_accounts->getBeans() as $ctaBancaria) {
                    //Valida Cuenta bancaria
                    //$GLOBALS['log']->fatal('Itera cuenta bancaria');
                    if (strlen($ctaBancaria->clabe) >= 8) {
                        $GLOBALS['log']->fatal('Entra cuenta bancaria: ' . $ctaBancaria->name);
                        $divisa_id = $ctaBancaria->divisa_c;
                        $divisa_code = $this->getDivisaCode($divisa_id);
                        //Arma petición para enviar cuenta bancaria
                        global $app_list_strings;
                        $mapeoBancos = $app_list_strings['dynamics365_mapeo_bancos_list'];
                        $rutaBancaria = $app_list_strings['dynamics365_ruta_bancaria_list'];
                        $nombreBanco = $app_list_strings['banco_list'];
                        $idBancoDynamics = $mapeoBancos[$ctaBancaria->banco];
                        $body_elements["BANKGROUPID"] = $idBancoDynamics;
                        $body_elements["ROUTINGNUMBER"] = $rutaBancaria[$idBancoDynamics];

                        $valorBankAccountId = $this->getValorToVendorBankAccountId($ctaBancaria->tipo_cuenta_c, $ctaBancaria);
                        $body_elements["VENDORBANKACCOUNTID"] = $this->getFormatCtaBancaria($ctaBancaria->tipo_cuenta_c, $valorBankAccountId);
                        
                        $body_elements["BANKACCOUNTNUMBER"] = $ctaBancaria->clabe;
                        $body_elements["BANKACCOUNTNAME"] = $nombreBanco[$ctaBancaria->banco];
                        $body_elements["CURRENCYCODEACCOUNT"] = $divisa_code;
                        $records_list[] = $body_elements;
                    }
                }
            } else {
                // Acción ejecutada desde cuenta bancaria
                $ctaBancaria = BeanFactory::retrieveBean('cta_cuentas_bancarias', $idCuentaBancaria, array('disable_row_level_security' => true));
                if (strlen($ctaBancaria->clabe) >= 8) {
                    $divisa_id = $ctaBancaria->divisa_c;
                    $divisa_code = $this->getDivisaCode($divisa_id);
                    //Arma petición para enviar cuenta bancaria
                    global $app_list_strings;
                    $mapeoBancos = $app_list_strings['dynamics365_mapeo_bancos_list'];
                    $rutaBancaria = $app_list_strings['dynamics365_ruta_bancaria_list'];
                    $nombreBanco = $app_list_strings['banco_list'];
                    $idBancoDynamics = $mapeoBancos[$ctaBancaria->banco];
                    $body_elements["BANKGROUPID"] = $idBancoDynamics;
                    $body_elements["ROUTINGNUMBER"] = $rutaBancaria[$idBancoDynamics];

                    $valorBankAccountId = $this->getValorToVendorBankAccountId($ctaBancaria->tipo_cuenta_c, $ctaBancaria);
                    $body_elements["VENDORBANKACCOUNTID"] = $this->getFormatCtaBancaria($ctaBancaria->tipo_cuenta_c, $valorBankAccountId);
                    
                    $body_elements["BANKACCOUNTNUMBER"] = $ctaBancaria->clabe;
                    $body_elements["BANKACCOUNTNAME"] = $nombreBanco[$ctaBancaria->banco];
                    $body_elements["CURRENCYCODEACCOUNT"] = $divisa_code;
                    $records_list[] = $body_elements;
                }
            }

            //Valida si es proveedor Fleet
            /*if($beanCuenta->tipo_proveedor_c == '^7^' || $beanCuenta->tipo_proveedor_c == '7') {
                $body_elements["OnlyReplyCompany"]="AUTO";
            }else{
                $body_elements["OnlyReplyCompany"]="";
            }*/
            $body_elements["OnlyReplyCompany"] = "";
            //Agrega registros en $records_list
            $itemVendor = array(
                'host' => $url_endpoint,
                'item' => $body_elements,
                'type' => 'Proveedor'
            );
            $records_list[] = $itemVendor;
        }

        //Itera $records_list
        $responseDynamics = '';
        foreach ($records_list as $item) {
            $argsVendor = array(
                '_contract' => $item['item']
            );

            //Solo envía petición cuando _contract tiene información
            if( !empty($argsVendor["_contract"]) ){

                //$hostVendor=$resource."/api/services/TT_ProveedorServicesGrp/TT_ProveedorServices/createVendor";
                $hostVendor = $resource . $item['host'];
                $GLOBALS['log']->fatal('Request Dynamics: Alta Proveedor/Cliente, host: ' . $hostVendor);
                $GLOBALS['log']->fatal(json_encode($argsVendor));
                $responseCreate = $this->postDynamics($hostVendor, $token, $argsVendor);
    
                $GLOBALS['log']->fatal("Response Dynamics");
                $GLOBALS['log']->fatal(print_r($responseCreate,true));
    
                if( !$responseCreate->Success ){
                    $GLOBALS['log']->fatal("Enviando notificación para bitácora de errores Dynamics 365");
                    require_once("custom/clients/base/api/ErrorLogApi.php");
                    $apiErrorLog = new ErrorLogApi();
                    $args = array(
                        "integration"=> "Dynamics: Alta Proveedor/Cliente",
                        "system"=> "Dynamics365",
                        "parent_type"=> "Accounts",
                        "parent_id"=> $idCuenta,
                        "endpoint"=> $hostVendor,
                        "request"=> json_encode($argsVendor),
                        "response"=> json_encode($responseCreate)
                    );
                    $response = $apiErrorLog->setDataErrorLog(null, $args);
                }
                //$GLOBALS['log']->fatal('Response: '. $responseCreate);
                $responseDynamics .= ($responseCreate->Success) ?  ' | ' . $item['type'] . ' Success - ' . $responseCreate->Message :  ' | ' . $item['type'] . ' Warning - ' . $responseCreate->ExceptionType;
            }

        }

        $responseFull = array();
        array_push($responseFull, $responseDynamics);

        //Llamada a api para Cuentas por pagar, solo se ejecuta la primera vez
        //$GLOBALS['log']->fatal("VALOR DE BANDERA CPP: ".$beanCuenta->control_cpp_chk_c);
        if (!$beanCuenta->control_cpp_chk_c) {
            $GLOBALS['log']->fatal("Request cuentas por pagar: url: " . $urlCPP . " idProveedor: " . $beanCuenta->idcliente_c);
            //$responseCPP=$this->postCPP("http://172.26.1.84:9011/proveedores/EnvioCuentasPorPagar365",$beanCuenta->idcliente_c);
            $responseCPP = $this->postCPP($urlCPP, $beanCuenta->idcliente_c);
            $GLOBALS['log']->fatal("RESPONSE CUENTAS POR PAGAR");
            $GLOBALS['log']->fatal(print_r($responseCPP, true));

            if (property_exists($responseCPP, "resultCode")) { //Condición para saber si se realizó correctamente la petición
                $codigo = $responseCPP->resultCode;
                if ($codigo == 1) {
                    $GLOBALS['log']->fatal("Proveedor ya registrado");
                    array_push($responseFull, $responseCPP->errores[0]);

                    $queryUpdate = "UPDATE accounts_cstm SET control_cpp_chk_c = '1', id_cpp_365_chk_c='{$responseCPP->errores[0]}' WHERE id_c = '{$beanCuenta->id}'";
                    $queryResult = $db->query($queryUpdate);
                } else {
                    $GLOBALS['log']->fatal('Proveedor creado (Cuentas por pagar): ' . $responseCPP->data->idProveedor365);
                    array_push($responseFull, $responseCPP->data->idProveedor365);

                    $queryUpdate = "UPDATE accounts_cstm SET control_cpp_chk_c = '1', id_cpp_365_chk_c='{$responseCPP->data->idProveedor365}' WHERE id_c = '{$beanCuenta->id}'";
                    $queryResult = $db->query($queryUpdate);
                }
            } else {
                $GLOBALS['log']->fatal('Petición mal realizada (Cuentas por pagar): ' . $responseCPP->data->idProveedor365);
                array_push($responseFull, "");

                // $GLOBALS['log']->fatal("Enviando notificación para bitácora de errores Dynamics 365 (Cuentas por pagar)");
                // require_once("custom/clients/base/api/ErrorLogApi.php");
                // $apiErrorLog = new ErrorLogApi();
                // $args = array(
                //     "integration" => "Dynamics: Cuentas por pagar",
                //     "system" => "Dynamics365",
                //     "parent_type" => "Accounts",
                //     "parent_id" => $idCuenta,
                //     "endpoint" => $urlCPP,
                //     "request" => '{"idProveedor" : ' . $beanCuenta->idcliente_c . '}',
                //     "response" => json_encode($responseCPP)
                // );
                // $response = $apiErrorLog->setDataErrorLog(null, $args);
            }
        }

        $GLOBALS['log']->fatal("RESPONSE API DYNAMICS 365 Y CUENTAS POR PAGAR");
        $GLOBALS['log']->fatal(print_r($responseFull, true));

        return $responseFull;
    }

    public function getDivisaCode($idDivisa)
    {
        $divisa_code = "";
        switch ($idDivisa) {
            case '1':
                $divisa_code = 'MXN';
                break;
            case '2':
                $divisa_code = 'USD';
                break;
            case '3':
                $divisa_code = 'EUR';
                break;

            default:
                $divisa_code = 'MXN';
                break;
        }

        return $divisa_code;
    }

    public function getValorToVendorBankAccountId( $tipo, $ctaBancaria ){

        $valorReturn = "";
        
        switch ($tipo) {
            case 'Interbancario':
                $valorReturn = $ctaBancaria->clabe;
                break;
            case 'Terceros':
                $valorReturn =  $ctaBancaria->cuenta;
                break;
            case 'Extranjero':
                $valorReturn =  $ctaBancaria->cuenta;
                break;
            case 'Convenio':
                $valorReturn =  $ctaBancaria->convenio_c;
                break;

            default:
                $valorReturn = "";
                break;
        }

        return $valorReturn;

    }

    public function getFormatCtaBancaria( $tipo, $valorCuenta ){

        $ctaFormat = "";

        switch ($tipo) {
            case 'Interbancario':
                $ctaFormat = "I-" . substr($valorCuenta, -8);
                break;
            case 'Terceros':
                $ctaFormat = "T-" . substr($valorCuenta, -8);
                break;
            case 'Extranjero':
                $ctaFormat = "E-" . substr($valorCuenta, -8);
                break;
            case 'Convenio':
                $ctaFormat = "C-" . substr($valorCuenta, -8);
                break;
            
            default:
                $ctaFormat = "";
                break;
        }

        return $ctaFormat;

    }

    public function postDynamicsRequest($host, $fields)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $host,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $fields,
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function postCPP($host, $idProveedor)
    {
        $curl = curl_init();
        $fields_string = json_encode($fields);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $host,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{"idProveedor" : ' . $idProveedor . '}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return (!empty($response)) ? json_decode($response) : "";
    }



    public function postDynamics($host, $token, $fields)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $host);
        //curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));


        //$GLOBALS['log']->fatal('Manda dynamic proveedor: ' . $host);
        $response = curl_exec($ch);

        curl_close($ch);
        $GLOBALS['log']->fatal($response);
        return json_decode($response);
    }
}