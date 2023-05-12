<?php
/**
 * Created by PhpStorm.
 * User: Salvador Lopez
 * Date: 18/04/2023
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetCambiosRazonDireFiscal extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'getCambiosRazon' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('cambiosRazonSocialDireFiscal','?'),
                'pathVars' => array('metodo','id_registro'),
                'method' => 'getCambiosAudit',
                'shortHelp' => 'Obtiene estructura del campo edit para obtener cambios en dirección fiscal de la cuenta relacionada',
                'longHelp' => '',
            ),
            'apruebaCambiosRazonSocial' => array(
                'reqType' => 'POST',
                'noLoginRequired' => true,
                'path' => array('AprobarCambiosRazonSocialDireFiscal'),
                'pathVars' => array('metodo'),
                'method' => 'aprobarCambios',
                'shortHelp' => 'Obtiene elementos en body de petición para establecer los nuevos valores aprobados tanto para el cliente como para la dirección fiscal',
                'longHelp' => '',
            ),
            'rechazaCambiosRazonSocial' => array(
                'reqType' => 'POST',
                'noLoginRequired' => true,
                'path' => array('RechazarCambiosRazonSocialDireFiscal'),
                'pathVars' => array('metodo'),
                'method' => 'rechazarCambios',
                'shortHelp' => 'Resetea Banderas de cuenta y direcciones inidicando que se rechazaron los cambios solicitados al actualizar nombre y/o dirección fiscal',
                'longHelp' => '',
            ),
        );
    }
    /*
    * Obtiene dirección fiscal de cuenta que tiene valor en campo json_audit_c
    */
    public function getCambiosAudit($api, $args){

        $id_registro = $args['id_registro'];
        $array_json_audit = array();

        $queryAudit = "SELECT d.id idDireccion, dc.json_audit_c FROM accounts a
        INNER JOIN accounts_dire_direccion_1_c ad ON a.id = ad.accounts_dire_direccion_1accounts_ida
        INNER JOIN dire_direccion d ON ad.accounts_dire_direccion_1dire_direccion_idb = d.id
        INNER JOIN dire_direccion_cstm dc ON d.id = dc.id_c
        WHERE a.id= '{$id_registro}'
        AND d.indicador IN (2,3,6,7,10,11,14,15,18,19,22,23,26,27,30,31,34,35,38,39,42,43,46,47,50,51,54,55,58,59,62,63)
        AND dc.json_audit_c is not null
        AND dc.json_audit_c != '' ";

        $results = $GLOBALS['db']->query($queryAudit);
        if( $results->num_rows > 0 ){
            while($row = $GLOBALS['db']->fetchByAssoc($results)) {
                
                $array_json_audit[] = $row['json_audit_c'];
                
            }
        }

        return $array_json_audit;
    }

    public function aprobarCambios($api, $args){
        global $current_user;
        $response = array();
        $date = TimeDate::getInstance()->nowDb();
        $id_cuenta = "";
        $beanCuenta = "";
        if( !empty($args['cuenta']) ){
            //Obtiene bean de cuenta para actualizar valores
            $id_cuenta = $args['cuenta']['id_cuenta'];
            $beanCuenta = BeanFactory::getBean('Accounts', $id_cuenta , array('disable_row_level_security' => true));

            if( !empty($beanCuenta) ){

                if( $args['cuenta']['tipo'] !== 'Persona Moral' ){
                    //Se establecen valores para Primer Nombre, Paterno y Materno
                    $beanCuenta->primernombre_c = $args['cuenta']['primer_nombre_por_actualizar'];
                    $beanCuenta->apellidopaterno_c = $args['cuenta']['paterno_por_actualizar'];
                    $beanCuenta->apellidomaterno_c = $args['cuenta']['materno_por_actualizar'];
                }else{//Al ser Moral, se establecen nuevos valores en Razón Social y Nombre Comercial
                    $beanCuenta->razonsocial_c = $args['cuenta']['razon_social_por_actualizar'];
                    $beanCuenta->nombre_comercial_c = $args['cuenta']['razon_social_por_actualizar'];
                }

                //$beanCuenta->save();

                array_push($response,"Cuenta actualizada correctamente");
            }
        }

        if( !empty($args['direccion']) ){
            $id_direccion = $args['direccion']['id_direccion'];
            if( $id_cuenta == "" ){
                $id_cuenta = $this->getIdCuenta($id_direccion);
            }

            //En caso de tener 5 caracteres en el string, quiere decir que es el CP y hay que obtener el id del Código Postal
            if( strlen($args['direccion']['cp_por_actualizar']) == 5 ){
                $id_codigo_postal = $this->getIdCodigoPostal( $args['direccion']['cp_por_actualizar'] );
            }else{
                $id_codigo_postal =  $args['direccion']['cp_por_actualizar'];
            }
           
            $beanDireccion = BeanFactory::getBean('dire_Direccion', $id_direccion , array('disable_row_level_security' => true));
            $beanDireccion->dire_direccion_dire_codigopostaldire_codigopostal_ida = $id_codigo_postal;
            $beanDireccion->dire_direccion_dire_paisdire_pais_ida = $args['direccion']['pais_por_actualizar'];
            $beanDireccion->dire_direccion_dire_estadodire_estado_ida = $args['direccion']['estado_por_actualizar'];
            $beanDireccion->dire_direccion_dire_municipiodire_municipio_ida = $args['direccion']['municipio_por_actualizar'];
            $beanDireccion->dire_direccion_dire_ciudaddire_ciudad_ida = $args['direccion']['ciudad_por_actualizar'];
            $beanDireccion->dire_direccion_dire_coloniadire_colonia_ida = $args['direccion']['colonia_por_actualizar'];
            $beanDireccion->calle =$args['direccion']['calle_por_actualizar'];
            $beanDireccion->numext =$args['direccion']['numext_por_actualizar'];
            $beanDireccion->numint =$args['direccion']['numint_por_actualizar'];
            $direccion_completa = $args['direccion']['calle_por_actualizar'] . " " . $args['direccion']['numext_por_actualizar'] . " " . ($args['direccion']['numint_por_actualizar'] != "" ? "Int: " . $args['direccion']['numint_por_actualizar'] : "") . ", Colonia " . $beanDireccion->dire_direccion_dire_colonia_name . ", Municipio " . $beanDireccion->dire_direccion_dire_municipio_name;

            $beanDireccion->name = $direccion_completa;
            $beanDireccion->cambio_direccion_c = 0;
            $beanDireccion->json_audit_c = '';
            $beanDireccion->valid_cambio_razon_social_c = 0;

            $beanDireccion->save();

            array_push($response,"Direccion " .$beanDireccion->id. " actualizada correctamente");

        }

        if( $beanCuenta == "" || empty($beanCuenta) ){
            $beanCuenta = BeanFactory::getBean('Accounts', $id_cuenta , array('disable_row_level_security' => true));
        }

        $beanCuenta->valid_cambio_razon_social_c = 0;
        $beanCuenta->cambio_nombre_c = 0;
        $beanCuenta->cambio_dirfiscal_c = 0;
        $beanCuenta->json_audit_c = '';
        $beanCuenta->enviar_mensaje_c = 0;

        //Establece valor sobre el campo del usuario que aprobo/rechazó el cambio
        $beanCuenta->user_id9_c = $current_user->id;
        $beanCuenta->usr_aprueba_rechaza_c = $current_user->full_name;
        $beanCuenta->fecha_aprueba_rechaza_c = $date;

        $beanCuenta->save();

        return $response;

    }

    public function rechazarCambios($api, $args){
        global $current_user;
        $response = array();
        $id_cuenta = "";
        $date = TimeDate::getInstance()->nowDb();

        if( !empty($args['cuenta']) ){
            $id_cuenta = $args['cuenta']['id_cuenta'];
            
            //Al ser rechazados los cambios, las banderas únicamente se actualizan desde bd para evitar pasar por todos los LH
            $this->reestableceBanderasCuenta($id_cuenta);

            array_push($response,"Cambios de Cuenta rechazados");
        }

        if( !empty($args['direccion']) ){
            $id_direccion = $args['direccion']['id_direccion'];
            if( $id_cuenta == "" ){
                $id_cuenta = $this->getIdCuenta($id_direccion);
                //Resetea banderas de Cuentas
                $this->reestableceBanderasCuenta($id_cuenta);
            }

            $this->reestableceBanderasDireccion($id_direccion);

            array_push($response,"Cambios de Dirección rechazados");

        }
        
        return $response;
    }

    public function getIdCodigoPostal($cp){

        $queryCP = "SELECT id FROM dire_codigopostal WHERE name = '{$cp}'";
        
        $resultCP = $GLOBALS['db']->query($queryCP);
        $id_cp = "";
        
        if( $resultCP->num_rows >0 ){
            while ($row = $GLOBALS['db']->fetchByAssoc($resultCP)) {
                $id_cp = $row['id'];
            }
        }

        return $id_cp;
    }

    public function getIdCuenta($id_direccion){
        $id_cuenta = "";
        //Si no se tiene id de cuenta, se obtiene el id de la cuenta relacionada a la dirección
        $queryGetCuenta ="SELECT accounts_dire_direccion_1accounts_ida FROM accounts_dire_direccion_1_c WHERE accounts_dire_direccion_1dire_direccion_idb='{$id_direccion}'";
        $resultCuenta = $GLOBALS['db']->query($queryGetCuenta);
        if( $resultCuenta->num_rows > 0){
            while ($row = $GLOBALS['db']->fetchByAssoc($resultCuenta)) {
                $id_cuenta = $row['accounts_dire_direccion_1accounts_ida'];
            }
        }

        return $id_cuenta;
    }

    public function reestableceBanderasCuenta($id_cuenta){
        global $current_user;
        $date = TimeDate::getInstance()->nowDb();
        
        $queryUpdateBanderasAccount = "UPDATE accounts_cstm SET valid_cambio_razon_social_c = '0', cambio_nombre_c = '0', cambio_dirfiscal_c = '0', json_audit_c = '', user_id9_c = '{$current_user->id}', fecha_aprueba_rechaza_c ='{$date}' WHERE id_c = '{$id_cuenta}'";
        $GLOBALS['log']->fatal("UPDATE BANDERAS DE CUENTA");
        $GLOBALS['log']->fatal($queryUpdateBanderasAccount);

        $GLOBALS['db']->query($queryUpdateBanderasAccount);
    }

    public function reestableceBanderasDireccion($id_direccion){

        $queryResetDireccion = "UPDATE dire_direccion_cstm SET json_audit_c = '', cambio_direccion_c = '0', valid_cambio_razon_social_c = '0' WHERE id_c = '{$id_direccion}'";
        $GLOBALS['log']->fatal("UPDATE BANDERAS DE DIRECCION");
        $GLOBALS['log']->fatal($queryResetDireccion);
        $GLOBALS['db']->query($queryResetDireccion);
    }

}
