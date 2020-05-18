<?php
array_push($job_strings, 'accounts_mambu');
/**
 * Created by Adrian Arauz.
 * Date: 13/05/20
 * Time: 12:58 PM
 */

require_once("custom/Levementum/UnifinAPI.php");

function accounts_mambu()
{
    global $sugar_config;
    //Inicia ejecución
    $GLOBALS['log']->fatal('Job para mandar cuentas CLIENTE a Mambu: START');
    //Declaracion de variables para mandar al servicio de Mambu

    $url=$sugar_config['url_mambu_clientes'];
    $user=$sugar_config['user_mambu'];
    $pwd=$sugar_config['pwd_mambu'];
    $auth_encode=base64_encode( $user.':'.$pwd );

    ##########################################
    ## 1.- Realiza consulta a db para obtener cuentas tipo Cliente con Linea (3,12)
    ##########################################
    //Cuenta registros a actualizar
    $sqlQuerycount = "SELECT count(*) FROM accounts_cstm WHERE tipo_registro_cuenta_c='3' AND subtipo_registro_cuenta_c='12' AND encodedkey_mambu_c is NULL LIMIT 5";
    //Ejecuta Consulta
    $resultAcc = $GLOBALS['db']->query($sqlQuerycount);
    $GLOBALS['log']->fatal('Registros a crear en Mambu: '.$resultAcc);
    //Estructura consulta
    $sqlQueryAcc = "SELECT id_c FROM accounts_cstm WHERE tipo_registro_cuenta_c='3' AND subtipo_registro_cuenta_c='12' AND encodedkey_mambu_c is NULL LIMIT 5";
    //Ejecuta Consulta
    $resultAcc = $GLOBALS['db']->query($sqlQueryAcc);
    $contador=0;
    while ($row = $GLOBALS['db']->fetchByAssoc($resultAcc)) {
        $GLOBALS['log']->fatal('Recupera valores del id asociado para generar body');
        $bean_Cuenta = BeanFactory::retrieveBean('Accounts',$row['id_c']);
        //variables para payload
        $id_crm=$row['id_c'];
        $nombre='';
        $nombreaccount=$bean_Cuenta->primernombre_c .' '.$bean_Cuenta->apellidopaterno_c .' '.$bean_Cuenta->apellidomaterno_c;
        $razon_social=$bean_Cuenta->razonsocial_c;
        $id_cliente_corto=$bean_Cuenta->idcliente_c;
        $nombre = $bean_Cuenta->tipodepersona_c!='Persona Moral' ? $nombreaccount : $razon_social;

        //Obteniendo referencias bancarias
        $array_referencias=array();
        if ($bean_Cuenta->load_relationship('refba_referencia_bancaria_accounts')) {
            $GLOBALS['log']->fatal('Carga Referencias bancarias asociadas a la cuenta');

            $referencias=$bean_Cuenta->refba_referencia_bancaria_accounts->getBeans();

            if (!empty($referencias)) {
                foreach ($referencias as $ref) {
                    $ref_bancaria= $ref->numerocuenta_c;
                    $nombre_banco=$ref->institucion;
                    $new_referencia=array(
                        "Nombre_del_Banco_Clientes"=>$nombre_banco,
                        "_numero_cuenta_cliente"=>$ref_bancaria,
                        "_domiciliacion"=>"TRUE"
                    );
                    array_push($array_referencias,$new_referencia);

                }
            }
        }
        $body = array(
            "groupName" => $nombre,
            "_referencias_crm"=>array(
                "_id_crm"=> $id_crm,
                "_id_cliente_corto"=>$id_cliente_corto,
                "_ref_bancaria"=>$bean_Cuenta->referencia_bancaria_c
            ),
            "_Referencias_Bancarias_Clientes"=>$array_referencias,

        );
        $GLOBALS['log']->fatal('Body: '.$body);
        $callApi = new UnifinAPI();
        $resultado = $callApi->postMambu($url,$body,$auth_encode);

        $GLOBALS['log']->fatal('--------------CRM CUENTAS A MAMBU-----------------');
        $GLOBALS['log']->fatal($resultado);

        if(!empty($resultado['encodedKey'])){

            $bean_Cuenta->encodedkey_mambu_c=$resultado['encodedKey'];
            $contador++;
            $bean_Cuenta->save();

        }
    }
    $GLOBALS['log']->fatal('Se han creado ' .$contador .'cuentas');

}