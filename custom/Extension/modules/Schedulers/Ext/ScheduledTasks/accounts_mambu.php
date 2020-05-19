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

    $url = $sugar_config['url_mambu_clientes'];
    $user = $sugar_config['user_mambu'];
    $pwd = $sugar_config['pwd_mambu'];
    $auth_encode = base64_encode($user . ':' . $pwd);

##########################################
## 1.- Realiza consulta a db para obtener cuentas tipo Cliente con Linea (3,12)
##########################################
//Estructura consulta
    $sqlQueryAcc = "SELECT 
DISTINCT
CASE 
WHEN ac.tipodepersona_c='Persona Moral' THEN ac.razonsocial_c
ELSE concat(ac.primernombre_c,' ',ac.apellidopaterno_c,' ',ac.apellidomaterno_c)END as Nombre_del_Grupo,
ac.idcliente_c as IdClienteCorto, ac.id_c as id, r.institucion as Nombre_del_Banco, 
rc.numerocuenta_c as Numero_de_Cuenta, ac.referencia_bancaria_c as Referencia_Bancaria
from accounts_cstm ac
inner join refba_referencia_bancaria_accounts_c ra on ra.refba_referencia_bancaria_accountsaccounts_ida = ac.id_c
inner join refba_referencia_bancaria r on r.id = ra.refba_referencia_bancaria_accountsrefba_referencia_bancaria_idb
inner join refba_referencia_bancaria_cstm rc on rc.id_c = r.id
WHERE ac.tipo_registro_cuenta_c='3' and (ac.encodedkey_mambu_c='' or ac.encodedkey_mambu_c is null) and ac.referencia_bancaria_c is not null and rc.numerocuenta_c is not null and r.institucion is not null and ac.idcliente_c is not null limit 50";
//Ejecuta Consulta
    $resultAcc = $GLOBALS['db']->query($sqlQueryAcc);
    $GLOBALS['log']->fatal('Registros a crear en Mambu: ' .count($resultAcc));
    $contador = 0;
    while ($row = $GLOBALS['db']->fetchByAssoc($resultAcc)) {
        //variables para payload
        $id_crm = $row['id'];
        $nombreaccount = $row['Nombre_del_Grupo'];
        $id_cliente_corto = $row['IdClienteCorto'];
        $GLOBALS['log']->fatal('Datos de Cuenta: ');
        $GLOBALS['log']->fatal($nombreaccount);
        //Declara referencias bancarias
        $array_referencias = array();
        $ref_bancaria = $row['Numero_de_Cuenta'];
        $nombre_banco = $row['Nombre_del_Banco'];
        $new_referencia = array(
            "_nombre_banco_cliente" => $nombre_banco,
            "_numero_cuenta_cliente" => $ref_bancaria,
            "_domiciliacion" => "TRUE"
        );
        array_push($array_referencias, $new_referencia);

        $body = array(
            "groupName" => $nombreaccount,
            "_referencias_crm" => array(
                "_id_crm" => $id_crm,
                "_id_cliente_corto" => $id_cliente_corto,
                "_ref_bancaria" => $row['Referencia_Bancaria']
            ),
            "_cuentas_bancarias_clientes" => $array_referencias,

        );
        $GLOBALS['log']->fatal('Body: ' .json_encode($body));
        $callApi = new UnifinAPI();
        $resultado = $callApi->postMambu($url, $body, $auth_encode);

        $GLOBALS['log']->fatal('Respuesta: ' .json_encode($resultado));

        if (!empty($resultado['encodedKey'])) {
            //Generar update hacia el registro
            $updateencoded = "UPDATE accounts_cstm
                              SET encodedkey_mambu_c ='".$resultado['encodedKey']."'
                              WHERE id_c ='".$row['id']."'";
            $updateResult = $GLOBALS['db']->query($updateencoded);
            $contador++;
            $GLOBALS['log']->fatal("Realiza actualizacion al campo id_mambu_c");

        }else if($resultado['errors']['errorSource']=='_id_crm'){
            $GLOBALS['log']->fatal("Cuenta ya existente en Mambu");

        }
    }
    $GLOBALS['log']->fatal('Se han creado ' . $contador . ' cuentas');
    $GLOBALS['log']->fatal('Job para mandar cuentas CLIENTE a Mambu: END');
}