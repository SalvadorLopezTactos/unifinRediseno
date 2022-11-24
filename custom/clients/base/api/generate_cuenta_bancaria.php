<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class generate_cuenta_bancaria extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'generate_cuenta_bancaria' => array(
                'reqType' => 'POST',
                'noLoginRequired' => false,
                'path' => array('cuentaBancaria'),
                'pathVars' => array('module'),
                'method' => 'getCuentaBancaria',
                'shortHelp' => 'Obtener cuenta bancaria y validar si existe para actualizar o insertar',
            ),
        );
    }
    public function getCuentaBancaria($api, $args)
    {
        try {
            //Recupera parámetros
            $GLOBALS['log']->fatal('Petición para API:Genera/Actualiza cuenta bancaria');

            $id_cliente = isset($args['idCuenta']) ? $args['idCuenta'] : '';
            $cuenta = isset($args['numeroCuenta']) ? $args['numeroCuenta'] : '';
            $clabe = isset($args['cuentaClabe']) ? $args['cuentaClabe'] : '';
            $id_banco = isset($args['banco']) ? $args['banco'] : '';
            $estado_cuenta = isset($args['estado']) ? $args['estado'] : '';
            $valida = isset($args['valida']) ? $args['valida'] : '';
            $fecha_vigencia = isset($args['vigencia']) ? $args['vigencia'] : '';

            $exit = $this->consulta_cuenta($id_cliente , $cuenta , $clabe , $id_banco , $estado_cuenta , $valida , $fecha_vigencia);

            return $exit;
        } catch (Exception $e) {
            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
            return array( "status"=>'500', "messageDetail" => "Error en servidor: ".$e->getMessage());
        }
    }

    public function consulta_cuenta($id_cliente , $cuenta , $clabe , $id_banco , $estado_cuenta , $valida , $fecha_vigencia){

        global $current_user, $app_list_strings, $sugar_config, $db;

        $banco_list = $app_list_strings['banco_list'];
        //Transforma Id de banco Dynamics a CRM
        $banco_mapeo_list = $app_list_strings['dynamics365_mapeo_bancos_list'];
        $id_banco_tmp = $id_banco;
        foreach ($banco_mapeo_list as $idCRM => $idDynamics) {
            //$GLOBALS['log']->fatal("Value: ".$idDynamics . " - banco: ".$id_banco_tmp);
            if($idDynamics == $id_banco_tmp){
                $id_banco = $idCRM;
            }
        }
        //$GLOBALS['log']->fatal("Banco: ".$id_banco);

        $id_accounts = '';
        $id_tarjeta = '';
        $nuevo = false;

        $salida = [];

        try {
            $query1 = "SELECT ac.id_c id_accounts from accounts_cstm ac WHERE ac.idcliente_c = '{$id_cliente}' limit 1";
            $result = $db->query($query1);
            while ($row = $db->fetchByAssoc($result)) {
                $id_accounts = $row['id_accounts'];
            }
            $GLOBALS['log']->fatal("id_accounts: ".$id_accounts);
            if($id_accounts != ""){
                $query2 = "SELECT ac.id_c id_accounts, ac.idcliente_c , ac.nombre_comercial_c , ac.tct_tipo_subtipo_txf_c , ccb.id id_tarjeta,
                    ccbc.idcorto_c, ccb.banco, ccb.cuenta, ccb.estado, ccb.clabe , ccbc.validada_c , ccbc.vigencia_c
                    from accounts_cstm ac left join cta_cuentas_bancarias_accounts_c ccbca on ac.id_c = ccbca.cta_cuentas_bancarias_accountsaccounts_ida
                    left join cta_cuentas_bancarias ccb on ccbca.cta_cuentas_bancarias_accountscta_cuentas_bancarias_idb  =  ccb.id
                    inner join cta_cuentas_bancarias_cstm ccbc on ccb.id = ccbc.id_c
                    WHERE ac.idcliente_c = '{$id_cliente}' and ccb.deleted=0";

                if( $cuenta != "" && $clabe != "" ){
                    $query2 = $query2 . " and (ccb.cuenta = '{$cuenta}'  or ccb.clabe = '{$clabe}')";
                }else if($cuenta != "" && $clabe == ""){
                    $query2 = $query2 . " and ccb.cuenta = '{$cuenta}' ";
                }else if($cuenta == "" && $clabe != ""){
                    $query2 = $query2 . " and ccb.clabe = '{$clabe}' ";
                }
                $query2 = $query2 . ' limit 1';

                $result = $db->query($query2);
                while ($row = $db->fetchByAssoc($result)) {
                    $id_tarjeta = $row['id_tarjeta'];
                }

                if($id_tarjeta == ""){
                    $nuevo = true;
                }

                if($nuevo){
                    $id = create_guid();
                    $date = TimeDate::getInstance()->nowDb();

                    $val = $banco_list[intval($id_banco)];

                    $beanBank = BeanFactory::newBean('cta_cuentas_bancarias');
                   // $beanBank->name  = $val;
                    $beanBank->banco = $id_banco;
                    $beanBank->cuenta = $cuenta;
                    $beanBank->clabe = $clabe;
                    $beanBank->estado = $estado_cuenta;
                    $beanBank->validada_c = $valida;
                    $beanBank->vigencia_c = $fecha_vigencia;

                    $beanBank->save();

                    $bankid = $beanBank->id;

                    $account = BeanFactory::getBean('Accounts', $id_accounts, array('disable_row_level_security' => true));
                    $account->load_relationship('cta_cuentas_bancarias_accounts');
                    $account->cta_cuentas_bancarias_accounts->add($bankid);

                }else{
                    $beanBank = BeanFactory::getBean('cta_cuentas_bancarias', $id_tarjeta, array('disable_row_level_security' => true));
                   // $beanBank->name  = $val;
                    $beanBank->banco = $id_banco;
                    //$beanBank->cuenta = $cuenta;
                    $beanBank->clabe = $clabe;
                    $beanBank->estado = $estado_cuenta;
                    $beanBank->validada_c = $valida;
                    $beanBank->vigencia_c = $fecha_vigencia;
                    $beanBank->save();
                    
                    /*$update = "UPDATE cta_cuentas_bancarias ccb inner join cta_cuentas_bancarias_cstm ccbc on ccb.id = ccbc.id_c
                    set ccb.banco = '{$id_banco}' , ccb.estado = '{$estado_cuenta}' , ccbc.validada_c = $valida , ccbc.vigencia_c = '{$fecha_vigencia}'
                    where ccb.id = '{$id_tarjeta}'; ";
                    $db->query($update);*/
                }
                $salida = array( "status"=>'200', "messageDetail" => "Exitoso");
            }else{
                $salida = array( "status"=>'400', "messageDetail" => "Error en Datos");
            }

            return $salida;

        } catch (Exception $e) {
            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
            return array( "status"=>'500', "messageDetail" => "Error en servidor: ".$e->getMessage());
        }
    }

}
