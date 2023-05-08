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
        AND dc.json_audit_c is not null";

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

        if( !empty($args['cuenta']) ){
            //Obtiene bean de cuenta para actualizar valores
            $id_cuenta = $args['cuenta']['id_cuenta'];
            $beanCuenta = BeanFactory::getBean('Accounts', $id_cuenta , array('disable_row_level_security' => true));

            if( !empty($beanCuenta) ){
                $beanCuenta->valid_cambio_razon_social_c = 0;
                $beanCuenta->cambio_nombre_c = 0;
                $beanCuenta->cambio_dirfiscal_c = 0;
                $beanCuenta->json_audit_c = '';
                $beanCuenta->enviar_mensaje_c = 0;

                //Establece valor sobre el campo del usuario que aprobo/rechazó el cambio
                $beanCuenta->user_id9_c = $current_user->id;
                $beanCuenta->usr_aprueba_rechaza_c = $current_user->full_name;
                $beanCuenta->fecha_aprueba_rechaza_c = $date;

                if( $args['cuenta']['tipo'] !== 'Persona Moral' ){
                    //Se establecen valores para Primer Nombre, Paterno y Materno
                    $beanCuenta->primernombre_c = $args['cuenta']['primer_nombre_por_actualizar'];
                    $beanCuenta->apellidopaterno_c = $args['cuenta']['paterno_por_actualizar'];
                    $beanCuenta->apellidomaterno_c = $args['cuenta']['materno_por_actualizar'];
                }else{//Al ser Moral, se establecen nuevos valores en Razón Social y Nombre Comercial
                    $beanCuenta->razonsocial_c = $args['cuenta']['razon_social_por_actualizar'];
                    $beanCuenta->nombre_comercial_c = $args['cuenta']['razon_social_por_actualizar'];
                }

                $beanCuenta->save();

                array_push($response,"Cuenta actualizada correctamente");
            }


        }

        if( !empty($args['direccion']) ){

        }

        return $response;

    }

    public function rechazarCambios($api, $args){
        global $current_user;
        $response = array();
        $date = TimeDate::getInstance()->nowDb();

        if( !empty($args['cuenta']) ){
            $id_cuenta = $args['cuenta']['id_cuenta'];
            
            //Al ser rechazados los cambios, las banderas únicamente se actualizan desde bd para evitar pasar por todos los LH
            $queryUpdateBanderasAccount = "UPDATE accounts_cstm SET valid_cambio_razon_social_c = '0', cambio_nombre_c = '0', cambio_dirfiscal_c = '0', json_audit_c = '', user_id9_c = '{$current_user->id}', fecha_aprueba_rechaza_c ='{$date}' WHERE id_c = '{$id_cuenta}'";
            $GLOBALS['log']->fatal("UPDATE BANDERAS DE CUENTA");
            $GLOBALS['log']->fatal($queryUpdateBanderasAccount);

            $GLOBALS['db']->query($queryUpdateBanderasAccount);

            array_push($response,"Cambios de Cuenta rechazados");
        }

        if( !empty($args['direccion']) ){

        }
        
        return $response;
    }

}