<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19/05/20
 * Time: 03:17 PM
 */
array_push($job_strings, 'opp_mambu');


require_once("custom/Levementum/UnifinAPI.php");

function opp_mambu()
{
    global $sugar_config;
    //Inicia ejecución
    $GLOBALS['log']->fatal('Job para mandar Líneas de Crédito UNICLICK a Mambu: START');
    //Declaracion de variables para mandar al servicio de Mambu
    $url=$sugar_config['url_mambu_gral'].'creditarrangements';
    $user=$sugar_config['user_mambu'];
    $pwd=$sugar_config['pwd_mambu'];
    $auth_encode=base64_encode( $user.':'.$pwd );

    ##########################################
    ## 1.- Realiza consulta a db para obtener solicitudes tipo Cliente con Linea (3,12)
    ##########################################
    //Estructura consulta
    $sqlQueryOpp = "select
      distinct
      oc.id_c as IdOpp, op.date_entered as FechaCreacion, oc.vigencialinea_c as FechaExp, oc.monto_c as amount, op.name as notes,
      oc.id_linea_credito_c as id_linea_credito, op.amount as monto_autorizado, ac.encodedkey_mambu_c as EncodedKey,
      ac.id_c as id_cliente_CRM
      from accounts_cstm ac
      inner join accounts_opportunities ao on ao.account_id=ac.id_c
      inner join opportunities_cstm oc on oc.id_c = ao.opportunity_id
      inner join opportunities op on op.id=oc.id_c
      WHERE ac.tipo_registro_c='Cliente'
      and oc.tipo_producto_c='8' -- Producto Uniclcik
      and oc.estatus_c = 'N' -- Autorizada
      and ac.encodedkey_mambu_c is not null
      and oc.id_linea_credito_c is not null
      and oc.tct_id_mambu_c is null limit 10";
    //Ejecuta Consulta
    $resultOpp = $GLOBALS['db']->query($sqlQueryOpp);
    $contador = 0;
    while ($row = $GLOBALS['db']->fetchByAssoc($resultOpp)) {
        $GLOBALS['log']->fatal('Líneas de crédito a crear en Mambu: ' . count($resultOpp));
        //Transformacion campo date_entered (añade horas y -05:00)
        $timedate2 = new TimeDate();
        $datetime_startDate = $timedate2->fromDb($row['FechaCreacion']);
        $fecha_creacion = date("c", strtotime($datetime_startDate));
        //$GLOBALS['log']->fatal("Fecha de creacion " .$fecha_creacion);

        //Corta los ultimos 6 caracteres del date_entered para añadirlos a la vigencia de linea
        $timezoneExp = substr($fecha_creacion, -6);
        //Para dar formato a la fecha necesario, ejemplo 2022-12-31T00:00:00-06:00
        //Concatena vigencia y añade terminacion 05:00
        $fechaexp = $row['FechaExp'] . "T12:00:00" . $timezoneExp;
        //$GLOBALS['log']->fatal("Fecha linea de expiracion ".$fechaexp);

        $body = array(
            "amount" => $row['amount'],
            "notes" => $row['notes'],
            "holderKey" => $row['EncodedKey'],
            "exposureLimitType" => "APPROVED_AMOUNT",
            "expireDate" => $fechaexp,
            "holderType" => "GROUP",
            "startDate" => $fecha_creacion,
            "_datos_linea_credito" => array(
                "id_linea_credito" => $row['id_linea_credito'],
                "monto_autorizado" => $row['monto_autorizado']
            ),
            "_productos" => array(
                "39" => "TRUE"
            )
        );

        $GLOBALS['log']->fatal('Body: ' .json_encode($body));
        //Llama a UnifinAPI para que realice el consumo de servicio a Mambu
        $callApi = new UnifinAPI();
        $resultado = $callApi->postMambu($url, $body, $auth_encode);
        $GLOBALS['log']->fatal('Respuesta Mambu: ' .json_encode($resultado));

        if (!empty($resultado['encodedKey'])) {
            //Realiza update al campo tct_id_mambu_c con el valor del encodedKey
            $query = "UPDATE opportunities_cstm
                              SET tct_id_mambu_c ='" . $resultado['encodedKey'] . "'
                              WHERE id_c = '".$row['IdOpp']."'";
            $queryResult = $GLOBALS['db']->query($query);
            $GLOBALS['log']->fatal("Realiza actualizacion al campo id_mambu_c");

        }else if($resultado['errors']['errorSource']=='id_linea_credito'){
            $GLOBALS['log']->fatal("Error al procesar Línea de Crédito a Mambu");
        }
    }
    $GLOBALS['log']->fatal('Se han creado ' . $contador . ' líneas de crédito');
    $GLOBALS['log']->fatal('Job para mandar Líneas de Crédito UNICLICK a Mambu: END');

}
