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
        $idCuenta=$args['idCuenta'];

        //$host="https://login.windows.net/unifin.com.mx/oauth2/token";
        $host=$sugar_config['dynamics_token_host'];
        $client_id=$sugar_config['dynamics_token_client_id'];
        $client_secret=$sugar_config['dynamics_token_client_secret'];
        $resource=$sugar_config['dynamics_token_resource'];

        $request=array(
            'grant_type' => 'client_credentials',
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'resource' => $resource
        );

        //Llamada a api para obtener token
        $response=$this->postDynamics($host,"",$request);

        $token=$response->access_token;

        $token_format=array("Authorization: Bearer ".$token);

        /*
         * Se obtienen datos de la Cuenta para armar cuerpo de la petición
         * */
        $beanCuenta = BeanFactory::getBean('Accounts', $idCuenta);

        //Obtener régimen fiscal
        $regimen_fiscal=$beanCuenta->tipodepersona_c;
        $body_elements=array();

        if($regimen_fiscal!='Perona Moral'){
            //Se arma petición para enviar proveedor de Persona Física o PFAE
            $body_elements["DataAreaId"]="UFIN";
            $body_elements["VENDORACCOUNTNUMBER"]=$beanCuenta->idcliente_c;
            if($beanCuenta->pais_nacimiento_c=='2'){//País México = 2
                $body_elements["COMPANYTYPE"]='LegalPerson';
            }else{
                $body_elements["COMPANYTYPE"]='ForeignCompany';
            }
            $body_elements["DEFAULTLEDGERDIMENSIONDISPLAYVALUE"]="";
            $body_elements["CURRENCYCODE"]="MXN";
            //Sección con atributos que de los que no se tienen en CRM
            $body_elements["DEFAULTOFFSETACCOUNTTYPE"]="Ledger";
            /*
            $body_elements["DEFAULTPAYMENTDAYNAME"]="MXN";
            $body_elements["DEFAULTPAYMENTTERMSNAME"]="MXN";
            $body_elements["DEFAULTVENDORPAYMENTMETHODNAME"]="MXN";
            */
            $body_elements["DIOTOPERATIONTYPE"]="Other";
            if($beanCuenta->pais_nacimiento_c=='2'){//País México = 2
                $body_elements["DIOTVENDORTYPE"]="DomesticVendor";
            }else{
                $body_elements["DIOTVENDORTYPE"]="ForeignVendor";
            }

            $body_elements["PERSONFIRSTNAME"]=$beanCuenta->primernombre_c;
            $body_elements["PERSONLASTNAME"]=$beanCuenta->apellidopaterno_c;
            $body_elements["PERSONMIDDLENAME"]=$beanCuenta->segundonombre_c;
            $body_elements["LANGUAGEID"]="es-MX";
            $body_elements["RFCFEDERALTAXNUMBER"]=$beanCuenta->rfc_c;
            //$body_elements["FOREIGNVENDORTAXREGISTRATIONID"]="";
            //$body_elements["SALESTAXGROUPCODE"]="";
            $body_elements["VENDORGROUPID"]="PROV";
            $body_elements["VENDORPARTYTYPE"]="Person";
            $body_elements["PRIMARYEMAILADDRESS"]=$beanCuenta->email1;
            $body_elements["PRIMARYEMAILADDRESSDESCRIPTION"]="PRINCIPAL";
            $body_elements["PRIMARYEMAILADDRESSPURPOSE"]="Business";

            /*
             * Sección para obtener direcciones
             * */

        }




        $argsVendor=array(
            "_contract"=>array(
                    "DataAreaId"=>"UFIN",
                    "VENDORACCOUNTNUMBER"=>"23901",
                    "ADDRESSCITY"=>"CDMX",
                    "ADDRESSCOUNTRYREGIONID"=>"MEX",
                    "ADDRESSCOUNTYID"=>"POLANCO V",
                    "ADDRESSDESCRIPTION"=>"POLANCO V",
                    "ADDRESSLOCATIONROLES"=>"Business",
                    "ADDRESSSTATEID"=>"CDMX",
                    "ADDRESSSTREET"=>"Texcoco",
                    "ADDRESSSTREETNUMBER"=>"80",
                    "ADDRESSZIPCODE"=>"55240",
                    "COMPANYTYPE"=>"LegalEntity",
                    "CURRENCYCODE"=>"MXN",
                    "DEFAULTLEDGERDIMENSIONDISPLAYVALUE"=>"",
                    "DEFAULTOFFSETACCOUNTTYPE"=>"Ledger",
                    "DEFAULTPAYMENTDAYNAME"=>"LUNES",//NO MANDAR
                    "DEFAULTPAYMENTTERMSNAME"=>"CONTADO",
                    "DEFAULTVENDORPAYMENTMETHODNAME"=>"TRANSFER",
                "DIOTOPERATIONTYPE"=>"085",
                "DIOTVENDORTYPE"=>"DomesticVendor",
                "LANGUAGEID"=>"es-MX",
                "PERSONFIRSTNAME"=>"SALVADOR",
                "PERSONLASTNAME"=>"LOPEZ",
                "PERSONMIDDLENAME"=>"JOSE",
                "PRIMARYEMAILADDRESS"=>"CORREO@PRUEBA.COM",
                "PRIMARYEMAILADDRESSDESCRIPTION"=>"PRINCIPAL",
                "PRIMARYEMAILADDRESSPURPOSE"=>"Business",
                "RFCFEDERALTAXNUMBER"=>"ABR010822TE7",
                "SALESTAXGROUPCODE"=>"IVA16%",
                "VENDORGROUPID"=>"PROV",
                "VENDORORGANIZATIONNAME"=>"ENTERPRISES DANONE  S.A. de C.V.",
                "VENDORPARTYTYPE"=>"Organization",
                "VENDORSEARCHNAME"=>"ENTERPRISES DANONE  S.A. de C.V.",
                "FOREIGNVENDORTAXREGISTRATIONID"=>"",
                //"VENDORBANKACCOUNTID"=>"T-000000010",
                "BANKACCOUNTNUMBER"=>"014180655022843137",
                "BANKGROUPID"=>"014",
                "ROUTINGNUMBER"=>"123456789101"
            )
        );


        $argsVendor=array(
            "_contract"=>array(
                "DataAreaId"=>"UFIN",
                "VENDORACCOUNTNUMBER"=>"23901",
                "COMPANYTYPE"=>"LegalPerson",
                "CURRENCYCODE"=>"MXN",
                "DIOTOPERATIONTYPE"=>"Other",
                "DIOTVENDORTYPE"=>"DomesticVendor",
                "LANGUAGEID"=>"es-MX",
                "RFCFEDERALTAXNUMBER"=>"LOBS9204102W3",
                "VENDORGROUPID"=>"PROV",
                "VENDORPARTYTYPE"=>"Organization",
                "VENDORORGANIZATIONNAME"=>"ENTERPRISES DANONE  S.A. de C.V.",
                "VENDORSEARCHNAME"=>"ENTERPRISES DANONE  S.A. de C.V.",
            )
        );

        $hostVendor="https://unifindevaos.sandbox.ax.dynamics.com/api/services/TT_ProveedorServicesGrp/TT_ProveedorServices/createVendor/";
        $GLOBALS['log']->fatal('JSON');
        $GLOBALS['log']->fatal(json_encode($argsVendor));
        $responseCreate=$this->postDynamics($hostVendor,$token_format,$argsVendor);

        return $responseCreate;

    }

    public function postDynamics($host,$token, $fields)
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
        if($token!=""){
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json'
                )
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $token);
            curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($fields));
            //curl_setopt($curl,CURLOPT_POSTFIELDS,'{\n   \"_contract\": \"{\\\"DataAreaId\\\":\\\"UFIN\\\",\\\"VENDORACCOUNTNUMBER\\\":\\\"0000PRUEBA07\\\",\\\"ADDRESSCITY\\\":\\\"CDMX\\\",\\\"ADDRESSCOUNTRYREGIONID\\\":\\\"MEX\\\",\\\"ADDRESSCOUNTYID\\\":\\\"POLANCO V\\\",\\\"ADDRESSDESCRIPTION\\\":\\\"PRINCIPAL\\\",\\\"ADDRESSLOCATIONROLES\\\":\\\"Business\\\",\\\"ADDRESSSTATEID\\\":\\\"CDMX\\\",\\\"ADDRESSSTREET\\\":\\\"Texcoco\\\",\\\"ADDRESSSTREETNUMBER\\\":\\\"80\\\",\\\"ADDRESSZIPCODE\\\":\\\"55240\\\",\\\"COMPANYTYPE\\\":\\\"LegalEntity\\\",\\\"CURRENCYCODE\\\":\\\"MXN\\\",\\\"DEFAULTLEDGERDIMENSIONDISPLAYVALUE\\\":\\\"\\\",\\\"DEFAULTOFFSETACCOUNTTYPE\\\":\\\"Ledger\\\",\\\"DEFAULTPAYMENTDAYNAME\\\":\\\"LUNES\\\",\\\"DEFAULTPAYMENTTERMSNAME\\\":\\\"CONTADO\\\",\\\"DEFAULTVENDORPAYMENTMETHODNAME\\\":\\\"TRANSFER\\\",\\\"DIOTOPERATIONTYPE\\\":\\\"Other\\\",\\\"DIOTVENDORTYPE\\\":\\\"DomesticVendor\\\",\\\"LANGUAGEID\\\":\\\"es-MX\\\",\\\"PERSONFIRSTNAME\\\":\\\"NOMBRE\\\",\\\"PERSONLASTNAME\\\":\\\"APELLIDO\\\",\\\"PERSONMIDDLENAME\\\":\\\"SEGNOMBRE\\\",\\\"PRIMARYEMAILADDRESS\\\":\\\"CORREO@PRUEBA.COM\\\",\\\"PRIMARYEMAILADDRESSDESCRIPTION\\\":\\\"PRINCIPAL\\\",\\\"PRIMARYEMAILADDRESSPURPOSE\\\":\\\"Business\\\",\\\"RFCFEDERALTAXNUMBER\\\":\\\"ABR010822TE7\\\",\\\"SALESTAXGROUPCODE\\\":\\\"IVA16%\\\",\\\"VENDORGROUPID\\\":\\\"PROV\\\",\\\"VENDORORGANIZATIONNAME\\\":\\\"Administradora Cantillo  S.A. de C.V.\\\",\\\"VENDORPARTYTYPE\\\":\\\"Organization\\\",\\\"VENDORSEARCHNAME\\\":\\\"Prueba dos\\\",\\\"FOREIGNVENDORTAXREGISTRATIONID\\\":\\\"\\\",\\\"VENDORBANKACCOUNTID\\\":\\\"T-0000674321\\\",\\\"BANKACCOUNTNUMBER\\\":\\\"014180655022843137\\\",\\\"BANKGROUPID\\\":\\\"014\\\",\\\"ROUTINGNUMBER\\\":\\\"123456789101\\\"}\"\n}');
        }


        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

}

?>
