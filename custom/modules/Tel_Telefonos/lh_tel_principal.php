<?php
class principal_class
{
  function principal_method($bean, $event, $arguments)
  {
      /**
        * Escenario 1: Identifica teléfono marcado como principal
        * Aplica para edición de teléfonos
      */
      $GLOBALS['log']->fatal('Proceso: Actualiza teléfono - Inicia');
      //Identifica que principal esté seleccionado y exista relación con Persona
      if ($bean->principal == true && !empty($bean->accounts_tel_telefonos_1accounts_ida)) {

        //Actualiza teléfono principal
        $GLOBALS['log']->fatal('Proceso: Actualiza teléfono - Procede');

        $query = "update accounts
        set phone_office = '{$bean->telefono}'
        where id='{$bean->accounts_tel_telefonos_1accounts_ida}';";

        $GLOBALS['log']->fatal('Proceso: Actualiza teléfono - Update: ' .$query );

        $resultQ = $GLOBALS['db']->query($query);

      }

  }

}
?>