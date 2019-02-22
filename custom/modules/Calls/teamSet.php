<?php
/*
class teamSetClass
{
  function teamSetMethod($bean, $event, $arguments)
  {
    /*
      2019-01-17 - AF
        Ajuste para agregar equipo principal de usuario asignado al registro guardado
    */
    //Recupera información de usuario asignado
    /*
    $usuarioAsignado = BeanFactory::getBean('Users', $bean->assigned_user_id);
    $equipoPrincipal = $usuarioAsignado->equipo_c;

    //Agrega equipo a registro
    if ($equipoPrincipal != null && $equipoPrincipal!="") {
      //Recupera teams asociados
      $bean->load_relationship('teams');
      $equipoPrincipal = ($equipoPrincipal == '1') ? 'UNO' : $equipoPrincipal;
      $equipoPrincipal = ($equipoPrincipal == '0') ? 'CERO' : $equipoPrincipal;
      $equipoPrincipal = str_replace(" ","",$equipoPrincipal);
      //Agrega teams de BO
      $bean->teams->add(
          array(
              $equipoPrincipal
          )
      );
    }

  }
}
?>
