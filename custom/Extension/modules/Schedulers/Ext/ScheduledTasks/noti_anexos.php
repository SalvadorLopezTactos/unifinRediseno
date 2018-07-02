<?php
//add the job key to the list of job strings
array_push($job_strings, 'noti_anexos');

function noti_anexos()
{
  // Busca contratos próximos a vencer
  $next60days = date('Y-m-d', strtotime("+60 days"));
  $beanQuery = BeanFactory::newBean('tct02_Resumen');
  $sugarQueryOP = new SugarQuery();
  $sugarQueryOP->select(array('id', 'name', 'fecha_termino_cto_leasing_c', 'fecha_termino_cto_factor_c', 'fecha_termino_cto_ca_c','vencimiento_anexos_leasing_c', 'vencimiento_anexos_factoring_c', 'vencimiento_anexos_ca_c'));
  $sugarQueryOP->from($beanQuery);
  $sugarQueryOP->where()->queryOr()->equals('fecha_termino_cto_leasing_c',$next60days)->equals('fecha_termino_cto_factor_c',$next60days)->equals('fecha_termino_cto_ca_c',$next60days);
  $resultOP = $sugarQueryOP->execute();
  $countOP = count($resultOP);
  for($current=0; $current < $countOP; $current++)
  {
    //Obtiene valores del cliente
    $beanAcct = BeanFactory::retrieveBean('Accounts', $resultOP[$current]['id']);
    $persona = $beanAcct->name;

    //Notifica Leasing
    if($resultOP[$current]['fecha_termino_cto_leasing_c'] == $next60days)
    {
      //Recupera anexos por vencer
      $mensaje = '<br/>' . $resultOP[$current]['vencimiento_anexos_leasing_c'];
      $notification_bean = BeanFactory::getBean("Notifications");
      $notification_bean->name = 'Vencimiento de Anexo(s) '.$persona;
      $notification_bean->description = 'ALERTA: Los anexos de tu cliente '.$persona.' vencerán dentro de 2 meses.<br/>Leasing/Anexos son:<br/>' . $mensaje;
      $notification_bean->parent_id = $beanAcct->id;
      $notification_bean->parent_type = 'Accounts';
      $notification_bean->assigned_user_id = $beanAcct->user_id_c;
      $notification_bean->severity = "alert";
      $notification_bean->is_read = 0;
      $notification_bean->save();
    }

    //Nofifica Factoring
    if($resultOP[$current]['fecha_termino_cto_factor_c'] == $next60days)
    {
      //Recupera anexos por vencer
      $mensaje = '<br/>' . $resultOP[$current]['vencimiento_anexos_factoring_c'];

      $notification_bean = BeanFactory::getBean("Notifications");
      $notification_bean->name = 'Vencimiento de Anexo(s) '.$persona;
      $notification_bean->description = 'ALERTA: Los anexos de tu cliente '.$persona.' vencerán dentro de 2 meses.<br/>Factoraje/Cesiones son:<br/>' . $mensaje;
      $notification_bean->parent_id = $beanAcct->id;
      $notification_bean->parent_type = 'Accounts';
      $notification_bean->assigned_user_id = $beanAcct->user_id1_c;
      $notification_bean->severity = "alert";
      $notification_bean->is_read = 0;
      $notification_bean->save();
    }

    //Notifica CA
    if($resultOP[$current]['fecha_termino_cto_ca_c'] == $next60days)
    {
      //Recupera anexos por vencer
      $mensaje = '<br/>' . $resultOP[$current]['vencimiento_anexos_ca_c'];
      $notification_bean = BeanFactory::getBean("Notifications");
      $notification_bean->name = 'Vencimiento de Anexo(s) '.$persona;
      $notification_bean->description = 'ALERTA: Los anexos de tu cliente '.$persona.' vencerán dentro de 2 meses.<br/>CA/Contratos son:<br/>' . $mensaje;
      $notification_bean->parent_id = $beanAcct->id;
      $notification_bean->parent_type = 'Accounts';
      $notification_bean->assigned_user_id = $beanAcct->user_id2_c;
      $notification_bean->severity = "alert";
      $notification_bean->is_read = 0;
      $notification_bean->save();
    }
  }
  return true;
}
