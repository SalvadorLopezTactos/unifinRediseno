<?php

require_once("custom/Levementum/UnifinAPI.php");

class oppUnionService
{
    function idResponseUnion($bean = null, $event = null, $args = null)
    {

        global $sugar_config, $db;
        $beanCuenta = BeanFactory::retrieveBean('Accounts', $bean->account_id, array('disable_row_level_security' => true));

        if ($beanCuenta->load_relationship('accounts_dire_direccion_1')) {

            $beanDirecciones = $beanCuenta->accounts_dire_direccion_1->getBeans();

            if (!empty($beanDirecciones)) {

                foreach ($beanDirecciones as $direccionFiscal) {

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

        //Condicion para realizar consumo de API para obtener el id de la respuesta del servicio
        if ($bean->id_response_union_c == "" && $bean->tipo_producto_c == "14" && $beanCuenta->tipodepersona_c != "Persona Fisica") {

            $GLOBALS['log']->fatal('*****Envia peticion al servicio de UNION*****');

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

            $callApi = new UnifinAPI();
            $resultado = $callApi->postUNION($url, $body);
            // $GLOBALS['log']->fatal('Resultado: ' . json_encode($resultado));

            if ($resultado != "" && $resultado != null) {

                if (!empty($resultado['id'])) {
                    // $bean->id_response_union_c = $resultado['id'];
                    $queryR = "UPDATE opportunities_cstm
                    SET id_response_union_c ='{$resultado['id']}'
                    WHERE id_c = '{$bean->id}'";
                    $db->query($queryR);
                    
                } else {
                    // $bean->id_response_union_c = $resultado['error'];
                    $queryE = "UPDATE opportunities_cstm
                    SET id_response_union_c ='{$resultado['error']}'
                    WHERE id_c = '{$bean->id}'";
                    $db->query($queryE);
                }
            }

            $GLOBALS['log']->fatal('*****Termina respuesta UNION*****');
        }
    }
}
