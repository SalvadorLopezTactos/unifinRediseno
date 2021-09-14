<?php

require_once("custom/Levementum/UnifinAPI.php");

class oppUnionService
{
    function idResponseUnion($bean = null, $event = null, $args = null)
    {

        global $sugar_config, $db;
        $combinacionDirFiscal = array("2", "3", "6", "7", "10", "11", "14", "15", "18", "19", "22", "23", "26", "27", "30", "31");
        $beanCuenta = BeanFactory::retrieveBean('Accounts', $bean->account_id, array('disable_row_level_security' => true));

        if ($beanCuenta->load_relationship('accounts_dire_direccion_1')) {

            $beanDirecciones = $beanCuenta->accounts_dire_direccion_1->getBeans();

            if (!empty($beanDirecciones)) {

                foreach ($beanDirecciones as $direccionFiscal) {
                    //VALIDACION DE DIRECCION FISCAL Y SUS COMBINACIONES ACTIVAS
                    if (in_array($direccionFiscal->indicador, $combinacionDirFiscal) && $direccionFiscal->inactivo == false) {

                        $dirCalle = $direccionFiscal->calle;
                        $dirNumInt = $direccionFiscal->numint;
                        $dirNumExt = $direccionFiscal->numext;
                        $dirCP = $direccionFiscal->dire_direccion_dire_codigopostal_name;
                        $dirColonia = $direccionFiscal->dire_direccion_dire_colonia_name;
                        $dirMunicipio = $direccionFiscal->dire_direccion_dire_municipio_name;
                        $dirCiudad = $direccionFiscal->dire_direccion_dire_ciudad_name;
                        $dirEstado = $direccionFiscal->dire_direccion_dire_estado_name;
                    }
                }
            }
        }

        //Detalle de la Solicitud
        if ($args['isUpdate'] == 1) {
            //Condicion para realizar consumo de API para obtener el id de la respuesta del servicio
            if ($bean->id_response_union_c == "" && $bean->tipo_producto_c == "14" && $beanCuenta->tipodepersona_c != "Persona Fisica") {

                $GLOBALS['log']->fatal('*****Envia peticion al servicio de UNION*****');
                // $GLOBALS['log']->fatal('Solicitud Tarjeta de Crédito: ' . $bean->id);
                $url = $sugar_config['url_Union'];
                $tipoPersona = ($beanCuenta->tipodepersona_c == "Persona Fisica con Actividad Empresarial") ? 2 : 3;

                $body = array(
                    "id_crm" => $bean->id,
                    "tipo_producto_c" => $bean->tipo_producto_c,
                    "term" => 0,
                    "amount" => $bean->monto_c,
                    "client" => array(
                        "rfc" => $beanCuenta->rfc_c,
                        "legal_person_type_id" => $tipoPersona,
                        "business_name" => $beanCuenta->nombre_comercial_c,
                        "name" => $beanCuenta->primernombre_c,
                        "last_name" => $beanCuenta->apellidopaterno_c,
                        "mother_last_name" => $beanCuenta->apellidomaterno_c,
                        "curp" => $beanCuenta->curp_c,
                        "phone" => $beanCuenta->phone_office,
                        "email" => $beanCuenta->email1,
                        "id_crm" => $beanCuenta->id,
                        "id_cliente_corto" => $beanCuenta->idcliente_c,
                        "address" => array(
                            "street" => $dirCalle,
                            "numInt" => $dirNumInt,
                            "numExt" => $dirNumExt,
                            "postal_code" => $dirCP,
                            "suburb" => $dirColonia,
                            "town" => $dirMunicipio,
                            "city" => $dirCiudad,
                            "state" => $dirEstado
                        )
                    )
                );
                $GLOBALS['log']->fatal($body);
                $callApi = new UnifinAPI();
                $resultado = $callApi->postUNION($url, $body);
                $GLOBALS['log']->fatal('Resultado UNION: ' . json_encode($resultado));

                if ($resultado != "" && $resultado != null) {
                    
                    if ($resultado['id'] != "") {
                        
                        $bean->id_response_union_c = $resultado['id'];
                        $query = "UPDATE opportunities_cstm
                        SET id_response_union_c ='".$resultado['id']."'
                        WHERE id_c = '".$bean->id."';";
                        $result = $db->query($query);
                    }
                }

                $GLOBALS['log']->fatal('*****Termina respuesta UNION*****');
            }
        }
    }
}
