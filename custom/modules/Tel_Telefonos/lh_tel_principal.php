<?php
class principal_class
{
  function principal_method($bean, $event, $arguments)
  {
      /**
        * Escenario 1: Valida existencia de teléfono principal
      */
      //Consulta teléfonos asociados a cuenta
      global $db;
      $idCuenta = $bean->accounts_tel_telefonos_1accounts_ida;
      $QuerySelect = "SELECT telefono.id,telefono.telefono,telefono.principal,telefono.estatus,telefono.tipotelefono
        FROM accounts_tel_telefonos_1_c rel
        INNER JOIN tel_telefonos telefono
          ON telefono.id=rel.accounts_tel_telefonos_1tel_telefonos_idb
        WHERE rel.accounts_tel_telefonos_1accounts_ida='{$idCuenta}'
          AND rel.deleted=0
          AND telefono.deleted=0
          AND telefono.id!='{$bean->id}'
          AND telefono.principal = 1";
      $resultQ = $db->query($QuerySelect);
      $totalPrincipal = $resultQ->num_rows;
      //Valida escenario por ejecutar
      if($totalPrincipal>0 && $bean->principal){
        //Desmarca principal existente
        $updatePrincipal = "update tel_telefonos telefono
          inner join accounts_tel_telefonos_1_c rel on rel.accounts_tel_telefonos_1tel_telefonos_idb = telefono.id
          set telefono.principal = 0
          where rel.accounts_tel_telefonos_1accounts_ida='{$idCuenta}'
          and telefono.deleted=0
          and telefono.id!='{$bean->id}'
          and telefono.principal = 1;";
        $resultUP = $db->query($updatePrincipal);
        //Deja nuevo principal
        $bean->principal = 1;
      }
      if($totalPrincipal==0 && $bean->principal == 0){
        $bean->principal = 1;
      }

      /**
        * Escenario 1: Identifica teléfono marcado como principal
        * Aplica para edición de teléfonos
      */
      //$GLOBALS['log']->fatal('Proceso: Actualiza teléfono - Inicia');
      //Identifica que principal esté seleccionado y exista relación con Persona
      if ($bean->principal == true && !empty($bean->accounts_tel_telefonos_1accounts_ida)) {

        //Actualiza teléfono principal de cuenta
        $query = "update accounts
        set phone_office = '{$bean->telefono}'
        where id='{$bean->accounts_tel_telefonos_1accounts_ida}';";

        //$GLOBALS['log']->fatal('Proceso: Actualiza teléfono - Update: ' .$query );
        $resultU = $db->query($query);

      }

  }

}
?>
