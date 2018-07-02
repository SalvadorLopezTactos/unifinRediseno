<?php

/*
Created by: AF.Tactos
21/03/2018
Job para ejecutar funcionalidad de alertas IMPAGO
*/

array_push($job_strings, 'job_impago');

function job_impago()
{
  //Inicia ejecución
  $GLOBALS['log']->fatal('Job Impago: Inicia');

  /*
  1.- Alerta Impago Leasing
  */

  ##########################################
  ## 1.- Recupera clientes que requieren generación de alerta para Leasing
  ##########################################
  $GLOBALS['log']->fatal('Job Impago: Leasing - Inicia '. $today);
  //Obtiene fecha actual
  $today = date("Y-m-d");

  //Estructura consulta leasing
  $sqlQuery = "select
    acc_r.id_c as idCliente,
    acc_r.impago_leasing_fecha_c as impagoLeasingFecha,
    acc_r.impago_leasing_monto_c as impagoLeasingMonto,
    acc_r.impago_cauto_fecha_c as impagoCautoFecha,
    acc_r.impago_cauto_monto_c as impagoCautoMonto,
    acc_r.impago_factoring_fecha_c as impagoFactoringFecha,
    acc_r.impago_factoring_monto_c as impagoFactoringMonto,
    acc_r.impago_leasing_anexos_c as impagoLeasingAnexos,
    acc_r.impago_factoring_cesiones_c as impagoFactoringCesiones,
    acc_r.impago_cauto_contratos_c as impagoCautoContratos,
    acc.name as nombreCliente,
    acc_c.user_id_c as promotorLeasing,
    acc_c.user_id1_c as promotorFactoring,
    acc_c.user_id2_c as promotorCauto
    from tct02_resumen_cstm acc_r
    left join accounts acc on  acc_r.id_c = acc.id
    left join accounts_cstm acc_c on  acc_r.id_c = acc_c.id_c
    where
    acc_r.impago_leasing_fecha_c='{$today}'
  ;";

  //Ejecuta consulta
  $GLOBALS['log']->fatal('Job Impago: Leasing - Ejecuta consulta');
  $resultR = $GLOBALS['db']->query($sqlQuery);

  ##########################################
  ## 2.- Genera alertas Leasing
  ##########################################
  //Procesa registros recuperados
  $GLOBALS['log']->fatal('Job Impago: Leasing - Procesa registros');
  $totalRegistros = 0;
  while ($row = $GLOBALS['db']->fetchByAssoc($resultR)) {

    //Genera mensaje de alerta
    $mensaje = 'ALERTA: Tu cliente ' . $row['nombreCliente'] .' no ha realizado su pago.
    <br/> Detalle de Cartera Vencida:
    <br/> Leasing - $'. number_format($row['impagoLeasingMonto'],2);
    //Anexos
    if (!empty($row['impagoLeasingAnexos'])) {
      $mensaje = $mensaje . '<br/> Anexos: '.  $row['impagoLeasingAnexos'];
    }

    ##  Valida Factoraje
    //Monto
    if( floatval($row['impagoFactoringMonto']) > 0 && $row['impagoFactoringMonto'] != '' && !empty($row['impagoFactoringMonto'])){
      //$GLOBALS['log']->fatal('Job Impago: Leasing - Monto Factoring ' . $row['impagoFactoringMonto']);
      $mensaje = $mensaje . '<br/> Factoraje - $'.  number_format($row['impagoFactoringMonto'],2);
    }
    //Cesiones
    if (!empty($row['impagoFactoringCesiones'])) {
      $mensaje = $mensaje . '<br/> Cesiones: '.  $row['impagoFactoringCesiones'];
    }

    ##  Valida CA
    //Monto
    if(floatval($row['impagoCautoMonto']) > 0 && $row['impagoCautoMonto'] != '' && !empty($row['impagoCautoMonto'])){
      $GLOBALS['log']->fatal('Job Impago: Leasing - Monto CA ' . $row['impagoCautoMonto']);
      $mensaje = $mensaje . '<br/> CA - $'. number_format($row['impagoCautoMonto'],2);
    }
    //Controatos
    if (!empty($row['impagoCautoContratos'])) {
      $mensaje = $mensaje . '<br/> Contratos: '.  $row['impagoCautoContratos'];
    }

    //Genera Alerta Promotor Leasing
    $beanN = BeanFactory::newBean('Notifications');
    $beanN->severity = 'alert';
    $beanN->name = 'Impago de ' . $row['nombreCliente'] .' – (Leasing)';
    $beanN->description = $mensaje;
    $beanN->parent_type = 'Accounts';
    $beanN->parent_id = $row['idCliente'];
    $beanN->assigned_user_id = $row['promotorLeasing'];
    $beanN->save();

    //Genera Alerta Promotor Factoring
    $beanN2 = BeanFactory::newBean('Notifications');
    $beanN2->severity = 'alert';
    $beanN2->name = 'Impago de ' . $row['nombreCliente'] .' – (Leasing)';
    $beanN2->description = $mensaje;
    $beanN2->parent_type = 'Accounts';
    $beanN2->parent_id = $row['idCliente'];
    $beanN2->assigned_user_id = $row['promotorFactoring'];
    $beanN2->save();

    //Genera Alerta Promotor CA
    $beanN3 = BeanFactory::newBean('Notifications');
    $beanN3->severity = 'alert';
    $beanN3->name = 'Impago de ' . $row['nombreCliente'] .' – (Leasing)';
    $beanN3->description = $mensaje;
    $beanN3->parent_type = 'Accounts';
    $beanN3->parent_id = $row['idCliente'];
    $beanN3->assigned_user_id = $row['promotorCauto'];
    $beanN3->save();

    //Guarda alertas
    $GLOBALS['log']->fatal('Job Impago: Leasing - Cliente | '. $row['nombreCliente'] );
    $GLOBALS['log']->fatal('Job Impago: Leasing - Notificaciones ' . $beanN->id . ' | ' . $beanN2->id . ' | ' . $beanN3->id);

    //Suma registro procesado
    $totalRegistros++;
  }

  $GLOBALS['log']->fatal('Job Impago: Leasing - Registros procesados '. $totalRegistros);
  $GLOBALS['log']->fatal('Job Impago: Leasing - Termina ');

  /*
  2.- Alerta Impago Factoring
  */

  ##########################################
  ## 1.- Recupera clientes que requieren generación de alerta para Factoring
  ##########################################
  $GLOBALS['log']->fatal('Job Impago: Factoring - Inicia '. $today);
  //Obtiene fecha actual
  $today = date("Y-m-d");

  //Estructura consulta Factoring
  $sqlQuery = "select
    acc_r.id_c as idCliente,
    acc_r.impago_leasing_fecha_c as impagoLeasingFecha,
    acc_r.impago_leasing_monto_c as impagoLeasingMonto,
    acc_r.impago_cauto_fecha_c as impagoCautoFecha,
    acc_r.impago_cauto_monto_c as impagoCautoMonto,
    acc_r.impago_factoring_fecha_c as impagoFactoringFecha,
    acc_r.impago_factoring_monto_c as impagoFactoringMonto,
    acc_r.impago_leasing_anexos_c as impagoLeasingAnexos,
    acc_r.impago_factoring_cesiones_c as impagoFactoringCesiones,
    acc_r.impago_cauto_contratos_c as impagoCautoContratos,
    acc.name as nombreCliente,
    acc_c.user_id_c as promotorLeasing,
    acc_c.user_id1_c as promotorFactoring,
    acc_c.user_id2_c as promotorCauto
    from tct02_resumen_cstm acc_r
    left join accounts acc on  acc_r.id_c = acc.id
    left join accounts_cstm acc_c on  acc_r.id_c = acc_c.id_c
    where
    acc_r.impago_factoring_fecha_c='{$today}'
  ;";

  //Ejecuta consulta
  $GLOBALS['log']->fatal('Job Impago: Factoring - Ejecuta consulta');

  $resultR = $GLOBALS['db']->query($sqlQuery);

  ##########################################
  ## 2.- Genera alertas Factoring
  ##########################################
  //Procesa registros recuperados
  $GLOBALS['log']->fatal('Job Impago: Factoring - Procesa registros');
  $totalRegistros = 0;
  while ($row = $GLOBALS['db']->fetchByAssoc($resultR)) {

    //Genera mensaje de alerta
    $mensaje = 'ALERTA: Tu cliente ' . $row['nombreCliente'] .' no ha realizado su pago.
    <br/> Detalle de Cartera Vencida:
    <br/> Factoring - $'. number_format($row['impagoFactoringMonto'],2);
    //Cesiones
    if (!empty($row['impagoFactoringCesiones'])) {
      $mensaje = $mensaje . '<br/> Cesiones: '.  $row['impagoFactoringCesiones'];
    }

    ## Valida Leasing
    //Monto
    if(floatval($row['impagoLeasingMonto']) > 0 && $row['impagoLeasingMonto'] != '' && !empty($row['impagoLeasingMonto'])){
      //$GLOBALS['log']->fatal('Job Impago: Factoring - Monto Leasing ' . $row['impagoLeasingMonto']);
      $mensaje = $mensaje . '<br/> Leasing - $'.  number_format($row['impagoLeasingMonto'],2);
    }
    //Anexos
    if (!empty($row['impagoLeasingAnexos'])) {
      $mensaje = $mensaje . '<br/> Anexos: '.  $row['impagoLeasingAnexos'];
    }

    ##Valida CA
    //Monto
    if(floatval($row['impagoCautoMonto']) > 0 && $row['impagoCautoMonto'] != '' && !empty($row['impagoCautoMonto'])){
      //$GLOBALS['log']->fatal('Job Impago: Factoring - Monto CA ' . $row['impagoCautoMonto']);
      $mensaje = $mensaje . '<br/> CA - $'. number_format($row['impagoCautoMonto'],2);
    }
    //Controatos
    if (!empty($row['impagoCautoContratos'])) {
      $mensaje = $mensaje . '<br/> Contratos: '.  $row['impagoCautoContratos'];
    }

    //Genera Alerta Promotor Leasing
    $beanN = BeanFactory::newBean('Notifications');
    $beanN->severity = 'alert';
    $beanN->name = 'Impago de ' . $row['nombreCliente'] .' – (Factoring)';
    $beanN->description = $mensaje;
    $beanN->parent_type = 'Accounts';
    $beanN->parent_id = $row['idCliente'];
    $beanN->assigned_user_id = $row['promotorLeasing'];
    $beanN->save();

    //Genera Alerta Promotor Factoring
    $beanN2 = BeanFactory::newBean('Notifications');
    $beanN2->severity = 'alert';
    $beanN2->name = 'Impago de ' . $row['nombreCliente'] .' – (Factoring)';
    $beanN2->description = $mensaje;
    $beanN2->parent_type = 'Accounts';
    $beanN2->parent_id = $row['idCliente'];
    $beanN2->assigned_user_id = $row['promotorFactoring'];
    $beanN2->save();

    //Genera Alerta Promotor CA
    $beanN3 = BeanFactory::newBean('Notifications');
    $beanN3->severity = 'alert';
    $beanN3->name = 'Impago de ' . $row['nombreCliente'] .' – (Factoring)';
    $beanN3->description = $mensaje;
    $beanN3->parent_type = 'Accounts';
    $beanN3->parent_id = $row['idCliente'];
    $beanN3->assigned_user_id = $row['promotorCauto'];
    $beanN3->save();

    //Guarda alertas
    $GLOBALS['log']->fatal('Job Impago: Factoring - Cliente | '. $row['nombreCliente'] );
    $GLOBALS['log']->fatal('Job Impago: Factoring - Notificaciones ' . $beanN->id . ' | ' . $beanN2->id . ' | ' . $beanN3->id);

    //Suma registro procesado
    $totalRegistros++;
  }

  $GLOBALS['log']->fatal('Job Impago: Factoring - Registros procesados '. $totalRegistros);
  $GLOBALS['log']->fatal('Job Impago: Factoring - Termina ');


  /*
  3.- Alerta Impago CA
  */

  ##########################################
  ## 1.- Recupera clientes que requieren generación de alerta para CA
  ##########################################
  $GLOBALS['log']->fatal('Job Impago: CA - Inicia '. $today);
  //Obtiene fecha actual
  $today = date("Y-m-d");

  //Estructura consulta Factoring
  $sqlQuery = "select
    acc_r.id_c as idCliente,
    acc_r.impago_leasing_fecha_c as impagoLeasingFecha,
    acc_r.impago_leasing_monto_c as impagoLeasingMonto,
    acc_r.impago_cauto_fecha_c as impagoCautoFecha,
    acc_r.impago_cauto_monto_c as impagoCautoMonto,
    acc_r.impago_factoring_fecha_c as impagoFactoringFecha,
    acc_r.impago_factoring_monto_c as impagoFactoringMonto,
    acc_r.impago_leasing_anexos_c as impagoLeasingAnexos,
    acc_r.impago_factoring_cesiones_c as impagoFactoringCesiones,
    acc_r.impago_cauto_contratos_c as impagoCautoContratos,
    acc.name as nombreCliente,
    acc_c.user_id_c as promotorLeasing,
    acc_c.user_id1_c as promotorFactoring,
    acc_c.user_id2_c as promotorCauto
    from tct02_resumen_cstm acc_r
    left join accounts acc on  acc_r.id_c = acc.id
    left join accounts_cstm acc_c on  acc_r.id_c = acc_c.id_c
    where
    acc_r.impago_cauto_fecha_c='{$today}'
  ;";

  //Ejecuta consulta
  $GLOBALS['log']->fatal('Job Impago: CA - Ejecuta consulta');

  $resultR = $GLOBALS['db']->query($sqlQuery);

  ##########################################
  ## 2.- Genera alertas CA
  ##########################################
  //Procesa registros recuperados
  $GLOBALS['log']->fatal('Job Impago: CA - Procesa registros');
  $totalRegistros = 0;
  while ($row = $GLOBALS['db']->fetchByAssoc($resultR)) {

    //Genera mensaje de alerta
    //Monto
    $mensaje = 'ALERTA: Tu cliente ' . $row['nombreCliente'] .' no ha realizado su pago.
    <br/> Detalle de Cartera Vencida:
    <br/> CA - $'. number_format($row['impagoCautoMonto'],2);
    //Controatos
    if (!empty($row['impagoCautoContratos'])) {
      $mensaje = $mensaje . '<br/> Contratos: '.  $row['impagoCautoContratos'];
    }

    ##  Valida Leasing
    //Monto
    if(floatval($row['impagoLeasingMonto']) > 0 && $row['impagoLeasingMonto'] != '' && !empty($row['impagoLeasingMonto'])){
      //$GLOBALS['log']->fatal('Job Impago: CA - Monto Leasing ' . $row['impagoLeasingMonto']);
      $mensaje = $mensaje . '<br/> Leasing - $'.  number_format($row['impagoLeasingMonto'],2);
    }
    //Anexos
    if (!empty($row['impagoLeasingAnexos'])) {
      $mensaje = $mensaje . '<br/> Anexos: '.  $row['impagoLeasingAnexos'];
    }

    ##  Valida Factoring
    //Monto
    if(floatval($row['impagoFactoringMonto']) > 0 && $row['impagoFactoringMonto'] != '' && !empty($row['impagoFactoringMonto'])){
      $GLOBALS['log']->fatal('Job Impago: CA - Monto CA ' . $row['impagoFactoringMonto']);
      $mensaje = $mensaje . '<br/> Factoring - $'. number_format($row['impagoFactoringMonto'],2);
    }
    //Cesiones
    if (!empty($row['impagoFactoringCesiones'])) {
      $mensaje = $mensaje . '<br/> Cesiones: '.  $row['impagoFactoringCesiones'];
    }

    //Genera Alerta Promotor Leasing
    $beanN = BeanFactory::newBean('Notifications');
    $beanN->severity = 'alert';
    $beanN->name = 'Impago de ' . $row['nombreCliente'] .' – (CA)';
    $beanN->description = $mensaje;
    $beanN->parent_type = 'Accounts';
    $beanN->parent_id = $row['idCliente'];
    $beanN->assigned_user_id = $row['promotorLeasing'];
    $beanN->save();

    //Genera Alerta Promotor Factoring
    $beanN2 = BeanFactory::newBean('Notifications');
    $beanN2->severity = 'alert';
    $beanN2->name = 'Impago de ' . $row['nombreCliente'] .' – (CA)';
    $beanN2->description = $mensaje;
    $beanN2->parent_type = 'Accounts';
    $beanN2->parent_id = $row['idCliente'];
    $beanN2->assigned_user_id = $row['promotorFactoring'];
    $beanN2->save();

    //Genera Alerta Promotor CA
    $beanN3 = BeanFactory::newBean('Notifications');
    $beanN3->severity = 'alert';
    $beanN3->name = 'Impago de ' . $row['nombreCliente'] .' – (CA)';
    $beanN3->description = $mensaje;
    $beanN3->parent_type = 'Accounts';
    $beanN3->parent_id = $row['idCliente'];
    $beanN3->assigned_user_id = $row['promotorCauto'];
    $beanN3->save();

    //Guarda alertas
    $GLOBALS['log']->fatal('Job Impago: CA - Cliente | '. $row['nombreCliente'] );
    $GLOBALS['log']->fatal('Job Impago: CA - Notificaciones ' . $beanN->id . ' | ' . $beanN2->id . ' | ' . $beanN3->id);

    //Suma registro procesado
    $totalRegistros++;
  }

  $GLOBALS['log']->fatal('Job Impago: CA - Registros procesados '. $totalRegistros);
  $GLOBALS['log']->fatal('Job Impago: CA - Termina ');


  //Concluye ejecución
  $GLOBALS['log']->fatal('Job Impago: Termina');
  return true;
}
