<?php

array_push($job_strings, 'limpieza_cuenta_bancaria');
function limpieza_cuenta_bancaria()
{
    global $db;
    $error = false;

    //Inicia ejecución
    $GLOBALS['log']->fatal('Job limpieza_cuenta_bancaria: Inicia');

    $sql = "SELECT  ccb.id id_tarjeta, ccb.name, ccbc.idcorto_c, ccb.banco,
    ccb.cuenta, ccb.estado, ccb.clabe , ccbc.validada_c , DATE_FORMAT(ccbc.vigencia_c, '%Y-%m-%d') vigencia,
    DATE_FORMAT(date_add(NOW(), INTERVAL 1 DAY) , '%Y-%m-%d') tope
    from cta_cuentas_bancarias ccb
    inner join cta_cuentas_bancarias_cstm ccbc on ccb.id = ccbc.id_c
      WHERE DATE_FORMAT(ccbc.vigencia_c, '%Y-%m-%d') < DATE_FORMAT(date_add(NOW(), INTERVAL 1 DAY) , '%Y-%m-%d')
      AND ccbc.validada_c = 1 ; ";
    $result = $db->query($sql);
    // while ($row = $db->fetchByAssoc($result)) {
    //     $bean = null;
    //     //$GLOBALS['log']->fatal('Cuenta bancaria -atrasada: '. $row['id_tarjeta']);
    //     $bean = BeanFactory::retrieveBean('cta_cuentas_bancarias', $row['id_tarjeta'] ,array('disable_row_level_security' => true));
    //     $bean->validada_c = 0;
    //     $bean->save();
    // }
    $sqlU = "UPDATE cta_cuentas_bancarias ccb
      inner join cta_cuentas_bancarias_cstm ccbc on ccb.id = ccbc.id_c
      SET
       ccb.date_modified = utc_timestamp(),
       ccbc.validada_c = 0
      WHERE DATE_FORMAT(ccbc.vigencia_c, '%Y-%m-%d') < DATE_FORMAT(date_add(NOW(), INTERVAL 1 DAY) , '%Y-%m-%d')
      AND ccbc.validada_c = 1 ; ";
    $resultU = $db->query($sqlU);

    $GLOBALS['log']->fatal('Job limpieza_cuenta_bancaria: Fin');
    return true;
}
