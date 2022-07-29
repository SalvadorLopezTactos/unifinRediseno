<?php
/*
  * LH para generar alerta cuando una nota es creada por usuario CAC
*/

class alerta_cac_Class
{
  function alerta_cac_Method($bean, $event, $arguments)
  {
    
    //Identifica si nota fue creada por CAC y está asociada a una persona
    global $current_user;
    
    if($arguments['isUpdate'] != 1 && $current_user->cac_c == true && $bean->parent_type == 'Accounts' && $bean->parent_id != ""){


      $GLOBALS['log']->fatal('LH: Alerta CAC - Inicia ');
      //$GLOBALS['log']->fatal($arguments['isUpdate']);
      
      //Recupera información de cuenta
      $beanPersona = BeanFactory::getBean("Accounts", $bean->parent_id);
      $GLOBALS['log']->fatal('LH: Alerta CAC - IdPersona: '. $beanPersona->id);
      
      //Genera Alerta Promotor Leasing
      $beanN = BeanFactory::newBean('Notifications');
      $beanN->severity = 'alert';
      $beanN->name = 'Contacto/Incidencia al CAC';
      $beanN->description = $beanPersona->name . ' se comunicó al CAC, podrás ver la incidencia en el módulo de notas del cliente.';
      $beanN->parent_type = 'Accounts';
      $beanN->parent_id = $beanPersona->id;
      $beanN->assigned_user_id = $beanPersona->user_id_c;
      $beanN->save();

      //Genera Alerta Promotor Factoring
      $beanN2 = BeanFactory::newBean('Notifications');
      $beanN2->severity = 'alert';
      $beanN2->name = 'Contacto/Incidencia al CAC';
      $beanN2->description = $beanPersona->name . ' se comunicó al CAC, podrás ver la incidencia en el módulo de notas del cliente.';
      $beanN2->parent_type = 'Accounts';
      $beanN2->parent_id = $beanPersona->id;
      $beanN2->assigned_user_id = $beanPersona->user_id1_c;
      $beanN2->save();

      //Genera Alerta Promotor CA
      $beanN3 = BeanFactory::newBean('Notifications');
      $beanN3->severity = 'alert';
      $beanN3->name = 'Contacto/Incidencia al CAC';
      $beanN3->description = $beanPersona->name . ' se comunicó al CAC, podrás ver la incidencia en el módulo de notas del cliente.';
      $beanN3->parent_type = 'Accounts';
      $beanN3->parent_id = $beanPersona->id;
      $beanN3->assigned_user_id = $beanPersona->user_id2_c;
      $beanN3->save();
    
      //Guarda alertas
      $GLOBALS['log']->fatal('LH: Alerta CAC - Nota: '. $bean->id . ', Cliente: ' . $beanPersona->id);
      $GLOBALS['log']->fatal('LH: Alerta CAC - Notificaciones: ' . $beanN->id . ' | ' . $beanN2->id . ' | ' . $beanN3->id);
      $GLOBALS['log']->fatal('LH: Alerta CAC - Termina ');

    }
  }
}
?>