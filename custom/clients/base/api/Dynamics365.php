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
        //Obtiene parámetros, el id de cuenta
        $idCuenta=$args['accion'];
        $host=$sugar_config['dynamics_token_host'];
        $client_id=$sugar_config['dynamics_token_client_id'];
        $client_secret=$sugar_config['dynamics_token_client_secret'];
        $resource=$sugar_config['dynamics_token_resource'];

        //Prepara token request
        $request=array(
            'grant_type' => 'client_credentials',
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'resource' => $resource
        );

        //Llamada a api para obtener token
        $response=$this->postDynamicsRequest($host,$request);
        $token=$response->access_token;
        // $GLOBALS['log']->fatal('Dynamics request: '. $request);
        // $GLOBALS['log']->fatal('Dynamics token: '. $token);
        $token_format=array("Authorization: Bearer ".$token);

        /*
         * Se obtienen datos de la Cuenta para armar cuerpo de la petición
         * */
        $beanCuenta = BeanFactory::getBean('Accounts', $idCuenta);
        //Obtener régimen fiscal
        $regimen_fiscal=$beanCuenta->tipodepersona_c;
        //Genera estructura de petición para alta de proveedor
        $records_list=array();
        $body_elements=array();
        $body_elements["DataAreaId"]="UFIN";
        $body_elements["VENDORACCOUNTNUMBER"]=$beanCuenta->idcliente_c;
        $body_elements["CURRENCYCODE"]="MXN";
        $body_elements["DIOTOPERATIONTYPE"]="Other";
        $body_elements["DIOTVENDORTYPE"]=($beanCuenta->pais_nacimiento_c=='2') ? "DomesticVendor" : "ForeignVendor";
        $body_elements["LANGUAGEID"]="es-MX";
        if($beanCuenta->pais_nacimiento_c=='2'){
            $body_elements["RFCFEDERALTAXNUMBER"]=$beanCuenta->rfc_c;
        }else{
            $body_elements["FOREIGNVENDORTAXREGISTRATIONID"]="xexx000000000";
        }
        
        $body_elements["VENDORGROUPID"]="PROV";
        $body_elements["PRIMARYEMAILADDRESS"]=$beanCuenta->email1;
        $body_elements["PRIMARYEMAILADDRESSDESCRIPTION"]="PRINCIPAL";
        $body_elements["PRIMARYEMAILADDRESSPURPOSE"]="Business";
        $body_elements["DEFAULTOFFSETACCOUNTTYPE"]="Ledger";
        $body_elements["SALESTAXGROUPCODE"]="IVA16%";
        $body_elements["DEFAULTVENDORPAYMENTMETHODNAME"]="TRANSFER";
        //Persona Fisica y PFAE
        if($regimen_fiscal!='Persona Moral'){
            //Se arma petición para enviar proveedor de Persona Física o PFAE
            $body_elements["VENDORPARTYTYPE"]="Person";
            $body_elements["COMPANYTYPE"]=($beanCuenta->pais_nacimiento_c=='2') ? "LegalPerson" : "ForeignCompany";
            $body_elements["PERSONFIRSTNAME"]=$beanCuenta->primernombre_c;
            $body_elements["PERSONLASTNAME"]=$beanCuenta->apellidopaterno_c." ".$beanCuenta->apellidomaterno_c;
            $body_elements["PERSONMIDDLENAME"]="";
        }else{
            $body_elements["VENDORPARTYTYPE"]="Organization";
            $body_elements["COMPANYTYPE"]=($beanCuenta->pais_nacimiento_c=='2') ? "LegalEntity" : "ForeignCompany";
            $body_elements["VENDORORGANIZATIONNAME"]=$beanCuenta->razonsocial_c;
            $body_elements["VENDORSEARCHNAME"]=$beanCuenta->razonsocial_c;
        }

        //Recupera dirección
        $beanCuenta->load_relationship('accounts_dire_direccion_1');
        foreach ($beanCuenta->accounts_dire_direccion_1->getBeans() as $a_direccion) {
            if (!empty($a_direccion->calle)) {
                //Arma petición para enviar dirección
                $body_elements["ADDRESSDESCRIPTION"]="PRINCIPAL";
                $body_elements["ADDRESSLOCATIONROLES"]="Business";
                $body_elements["ADDRESSCOUNTRYREGIONID"]="MEX";
                $body_elements["ADDRESSZIPCODE"]=$a_direccion->dire_direccion_dire_codigopostal_name;
                $body_elements["ADDRESSSTREET"]=$a_direccion->calle;
                $body_elements["ADDRESSSTREETNUMBER"]=$a_direccion->numext;
            }
        }

        //Recupera cuentas bancarias
        $beanCuenta->load_relationship('cta_cuentas_bancarias_accounts');
        $GLOBALS['log']->fatal('Recupera cuenta bancaria');
        foreach ($beanCuenta->cta_cuentas_bancarias_accounts->getBeans() as $ctaBancaria) {
            //Valida Cuenta bancaria
            $GLOBALS['log']->fatal('Itera cuenta bancaria');
            if (strlen($ctaBancaria->cuenta)>=8 || strlen($ctaBancaria->clabe)>=8 ) {
                $GLOBALS['log']->fatal('Entra cuenta bancaria: '. $ctaBancaria->name);
                //Arma petición para enviar cuenta bancaria
                global $app_list_strings;
                $mapeoBancos = $app_list_strings['dynamics365_mapeo_bancos_list'];
                $rutaBancaria = $app_list_strings['dynamics365_ruta_bancaria_list'];
                $idBancoDynamics = $mapeoBancos[$ctaBancaria->banco];
                $body_elements["BANKGROUPID"]=$idBancoDynamics;
                $body_elements["ROUTINGNUMBER"]=$rutaBancaria[$idBancoDynamics];
                //Valida Cuenta bancaria
                if (strlen($ctaBancaria->cuenta)>=8) {
                    $body_elements["VENDORBANKACCOUNTID"]="T-".substr($ctaBancaria->cuenta, -8);
                    $body_elements["BANKACCOUNTNUMBER"]=$ctaBancaria->cuenta;
                    $records_list[]=$body_elements;
                }
                //Valida CLABE
                if (strlen($ctaBancaria->clabe)>=8 ) {
                    $body_elements["VENDORBANKACCOUNTID"]="I-".substr($ctaBancaria->clabe, -8);
                    $body_elements["BANKACCOUNTNUMBER"]=$ctaBancaria->clabe;
                    $records_list[]=$body_elements;
                }
            }
        }

        //Valida total de registros en $records_list
        if (count($records_list)==0) {
            $records_list[]=$body_elements;
        }

        //Itera $records_list
        $responseDynamics = '';
        foreach ($records_list as $item) {
          $argsVendor = array(
              '_contract'=>$item
          );


          $hostVendor=$resource."/api/services/TT_ProveedorServicesGrp/TT_ProveedorServices/createVendor";
          $GLOBALS['log']->fatal('Request Dynamics: Alta proveedor');
          $GLOBALS['log']->fatal(json_encode($argsVendor));
          $responseCreate=$this->postDynamics($hostVendor,$token,$argsVendor);
          //$GLOBALS['log']->fatal('Response: '. $responseCreate);
          $responseDynamics = ($responseCreate->Success) ? $responseDynamics . ' - ' . $responseCreate->Message : $responseDynamics . ' - ' . $responseCreate->ExceptionType;
        }

        //Comienza integración Cuentas por pagar
        $urlCPP="http://172.26.1.84:9011/proveedores/EnvioCuentasPorPagar365";

        $bodyCPP=array(
            'idProveedor' => $beanCuenta->idcliente_c
        );

        //Llamada a api para obtener token
        $responseCPP=$this->postDynamicsRequest($urlCPP,$bodyCPP);
        $GLOBALS['log']->fatal("RESPONSE CUENTAS POR PAGAR");
        $GLOBALS['log']->fatal(json_encode($responseCPP));
        
        $data=$responseCPP->data;
        $responseFull=array();

        if(!empty($data)){

            $responseFull=array($responseDynamics,$data);

        }

        $GLOBALS['log']->fatal("RESPONSE API DYNAMICS 365");
        $GLOBALS['log']->fatal(json_encode($responseFull));

        return $responseFull;

    }

    public function postDynamicsRequest($host,$fields)
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

    public function postDynamics($host,$token, $fields)
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
                'Authorization: Bearer '.$token));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));


        //$GLOBALS['log']->fatal('Manda dynamic proveedor: ' . $host);
        $response = curl_exec($ch);

        curl_close($ch);
        $GLOBALS['log']->fatal($response);
        return json_decode($response);
    }

}

?>
