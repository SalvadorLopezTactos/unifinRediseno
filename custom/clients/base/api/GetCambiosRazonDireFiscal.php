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
                'shortHelp' => 'Obtiene valores previos y actuales de la tabla audit para llenar tabla que se muestra para aprobación de área de crédito',
                'longHelp' => '',
            ),
            'deshaceCambiosRazon' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('revierteCambiosRazonSocialDireFiscal','?'),
                'pathVars' => array('metodo','id_registro'),
                'method' => 'rechazarCambios',
                'shortHelp' => 'Obtiene valores previos de dirección fiscal y razón social para reestablecerlos al registro pasado por parámetro',
                'longHelp' => '',
            ),
        );
    }

    public function getCambiosAudit($api, $args){

        $id_registro = $args['id_registro'];
        $resultado = [];
        $previos = [];
        $nuevos = [];
        $direccionIDAudit= '';
        $nombreIDAudit = '';

        $queryAudit = "(SELECT id,before_value_string, after_value_string, date_created, field_name
        FROM accounts_audit
        WHERE parent_id = '{$id_registro}'
        AND field_name = 'name'
        ORDER BY date_created DESC
        LIMIT 1)
        UNION
        (SELECT id,before_value_string, after_value_string, date_created, field_name
        FROM accounts_audit
        WHERE parent_id = '{$id_registro}'
        AND field_name = 'dire_Direccion'
        ORDER BY date_created DESC
        LIMIT 1);";

        $results = $GLOBALS['db']->query($queryAudit);
        
        while($row = $GLOBALS['db']->fetchByAssoc($results)) {

            $campo = $row['field_name'];
            $fecha = $row['date_created'];
            
            if( $campo == 'name' ){
                $nombreIDAudit = $row['id'];
                $previos['nombre'] = $row['before_value_string'];
                $nuevos['nombre'] = $row['after_value_string'];
                $previos['fecha'] = $row['date_created'];
            }
            
            if( $campo == 'dire_Direccion' ){
                $direccionIDAudit = $row['id'];
                $previos['direccion'] = $row['before_value_string'];
                $nuevos['direccion'] = $row['after_value_string'];
                $nuevos['fecha'] = $row['date_created'];
            }
            
        }

        $resultado['previos'] = $previos; 
        $resultado['nuevos'] = $nuevos;
        $resultado['idDireccionAudit'] = $direccionIDAudit;
        $resultado['idNombreAudit'] = $nombreIDAudit;

        return $resultado;

    }

    public function rechazarCambios($api, $args){
        $id_registro = $args['id_registro'];

        $beanCuenta = BeanFactory::getBean('Accounts', $id_registro , array('disable_row_level_security' => true));
        $campos_obtener = array();
        if( !empty($beanCuenta) ){
            $cambio_nombre = $beanCuenta->cambio_nombre_c;
            $cambio_dirFiscal = $beanCuenta->cambio_dirfiscal_c;
            $regimen_fiscal = $beanCuenta->tipodepersona_c;
            
            if( $cambio_nombre ){
                if( $regimen_fiscal !== 'Persona Moral' ){

                    array_push($campos_obtener, 'primernombre_c','apellidopaterno_c','apellidomaterno_c');

                }else{
                    //Es Persona Moral
                    array_push($campos_obtener,'razonsocial_c','nombre_comercial_c');
                }

                $querySelectAuditNombre = "SELECT 
                t1.*
            FROM
                accounts_audit t1
            WHERE
                t1.date_created = (SELECT 
                        MAX(t2.date_created)
                    FROM
                        accounts_audit t2
                    WHERE
                        t2.field_name = t1.field_name)
                        AND t1.parent_id='{$id_registro}';";

                $results = $GLOBALS['db']->query($querySelectAuditNombre);
                
                $stringUpdateAccountCstm = "UPDATE accounts_cstm SET ";
                $stringUpdateAccount = "UPDATE accounts SET ";
                //UPDATE accounts_cstm SET apellidopaterno_c = '',apellido_materno_c = '' WHERE id_c= 'id';
                while($row = $GLOBALS['db']->fetchByAssoc($results)){
                    $campo = $row['field_name'];

                    if( in_array($campo,$campos_obtener) ){
                        $stringUpdateAccountCstm .= $campo . "= '{$row['before_value_string']}' ,";
                    }else{
                        if( $campo == 'name' ){
                            $stringUpdateAccount .= $campo . "= '{$row['before_value_string']}' ";
                        }
                    }
                }
                $stringUpdateAccountCstm = substr($stringUpdateAccountCstm, 0, -1);
                $stringUpdateAccountCstm .= "where id_c =" ."'{$id_registro}'";

                $stringUpdateAccount .= "where id =" ."'{$id_registro}'";

                $GLOBALS['db']->query($stringUpdateAccount);
                $GLOBALS['db']->query($stringUpdateAccountCstm);

                //Reestablece banderas
                $GLOBALS['db']->query("UPDATE accounts_cstm SET valid_cambio_razon_social_c = '0', cambio_nombre_c = '0', cambio_dirfiscal_c = '0' WHERE id_c = '{$id_registro}'");
                
            }

            if( $cambio_dirFiscal ){
                //ToDo, obtener valores anteriores de dirección fiscal


            }

        }
        
        return array($stringUpdateAccount,$stringUpdateAccountCstm);
    }
}