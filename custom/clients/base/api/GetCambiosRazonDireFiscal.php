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
        $array_json_audit = array();

        $queryAudit = "SELECT d.id idDireccion, dc.json_audit_c FROM accounts a
        INNER JOIN accounts_dire_direccion_1_c ad ON a.id = ad.accounts_dire_direccion_1accounts_ida
        INNER JOIN dire_direccion d ON ad.accounts_dire_direccion_1dire_direccion_idb = d.id
        INNER JOIN dire_direccion_cstm dc ON d.id = dc.id_c
        WHERE a.id= '{$id_registro}'
        AND d.indicador IN (2,3,6,7,10,11,14,15,18,19,22,23,26,27,30,31,34,35,38,39,42,43,46,47,50,51,54,55,58,59,62,63);";

        $results = $GLOBALS['db']->query($queryAudit);
        if( $results->num_rows > 0 ){
            while($row = $GLOBALS['db']->fetchByAssoc($results)) {

                $array_json_audit[] = $row['json_audit_c'];
                
            }
        }

        return $array_json_audit;
    }

    public function rechazarCambios($api, $args){
        $id_registro = $args['id_registro'];
        $resultado = array();
        $beanCuenta = BeanFactory::getBean('Accounts', $id_registro , array('disable_row_level_security' => true));
        $campos_obtener = array();
        if( !empty($beanCuenta) ){
            $cambio_nombre = $beanCuenta->cambio_nombre_c;
            $cambio_dirFiscal = $beanCuenta->cambio_dirfiscal_c;
            $regimen_fiscal = $beanCuenta->tipodepersona_c;
            
            if( $cambio_nombre ){
                if( $regimen_fiscal !== 'Persona Moral' ){

                    array_push($campos_obtener, 'primernombre_c','apellidopaterno_c','apellidomaterno_c','name');

                }else{
                    //Es Persona Moral
                    array_push($campos_obtener,'razonsocial_c','nombre_comercial_c','name');
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
                
                //$stringUpdateAccountCstm = "UPDATE accounts_cstm SET ";
                //$stringUpdateAccount = "UPDATE accounts SET ";
                while($row = $GLOBALS['db']->fetchByAssoc($results)){
                    $campo = $row['field_name'];
                    if( in_array($campo,$campos_obtener) ){
                        //$stringUpdateAccountCstm .= $campo . "= '{$row['before_value_string']}' ,";
                        $beanCuenta->{$campo} = $row['before_value_string'];
                    }
                }
                //$stringUpdateAccountCstm = substr($stringUpdateAccountCstm, 0, -1);
                //$stringUpdateAccountCstm .= "where id_c =" ."'{$id_registro}'";

                //$stringUpdateAccount .= "where id =" ."'{$id_registro}'";

                //$GLOBALS['db']->query($stringUpdateAccount);
                //$GLOBALS['db']->query($stringUpdateAccountCstm);

                $beanCuenta->valid_cambio_razon_social_c='0';
                $beanCuenta->cambio_nombre_c='0';
                $beanCuenta->cambio_dirfiscal_c='0';

                $id_return = $beanCuenta->save();

                if( !empty($id_return) ){
                    array_push($resultado, "Valores de Razón Social / Nombre se han reestablecido correctamente");
                }
                //Reestablece banderas
                //$GLOBALS['db']->query("UPDATE accounts_cstm SET valid_cambio_razon_social_c = '0', cambio_nombre_c = '0', cambio_dirfiscal_c = '0' WHERE id_c = '{$id_registro}'");
                
            }

            if( $cambio_dirFiscal ){
                //ToDo, obtener valores anteriores de dirección fiscal
                $querySelectAuditDireccion = "SELECT 
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
                            AND t1.parent_id='{$id_registro}'
                            AND t1.field_name='dire_Direccion'";

                $results = $GLOBALS['db']->query($querySelectAuditDireccion);
                                
                $id_direccion = '';
                while($row = $GLOBALS['db']->fetchByAssoc($results)){
                    $id_direccion = $row['event_id'];
                    $GLOBALS['log']->fatal("#####ID DIRECCION#####");
                    $GLOBALS['log']->fatal($id_direccion);
                }

                if( $id_direccion !== ''){
                    // Obtener valores de la tabla audit de direcciones, para establecer valores anteriores
                    $queryAuditDireccion = "SELECT 
                        t1.*
                    FROM
                        dire_direccion_audit t1
                    WHERE
                        t1.date_created = (SELECT 
                                MAX(t2.date_created)
                            FROM
                                dire_direccion_audit t2
                            WHERE
                                t2.field_name = t1.field_name)
                            AND t1.parent_id = '{$id_direccion}'";

                }



            }

        }
        
        return $resultado;
    }
}