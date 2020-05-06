<?php

class reasigna_class
{
    function reasigna_method($bean, $event, $arguments)
    {
      /**
        * Escenario 1: Llamada a partir de teléfono
        * Aplica para llamadas generadas desde un teléfono
      */
      //Identifica si tiene relación con teléfono y no con persona
      if ($bean->tel_telefonos_calls_1tel_telefonos_ida && empty($bean->parent_id)) {
        $GLOBALS['log']->fatal('Proceso: Asocia llamada - Inicia');

        //Recupera teléfono
        $beanTelefono = BeanFactory::getBean("Tel_Telefonos", $bean->tel_telefonos_calls_1tel_telefonos_ida);
        $GLOBALS['log']->fatal('Proceso: Asocia llamada - IdTel: '. $beanTelefono->id);

        //Si teléfono tiene persona asociada agrega a llamada
        if ($beanTelefono->accounts_tel_telefonos_1accounts_ida) {
          $GLOBALS['log']->fatal('Proceso: Asocia llamada - IdPer: '. $beanTelefono->accounts_tel_telefonos_1accounts_ida);
          //Asocia Persona a llamada
          $bean->parent_id = $beanTelefono->accounts_tel_telefonos_1accounts_ida;
          $bean->parent_type = 'Accounts';
        }
      }

      /**
        * Escenario 2: Llamada a partir de persona
        * Aplica para llamadas asociadas a personas && verifica existencia de nivel superior && Verifica que no sea asignación manual
      */
      //Identifica si tiene persona y valida que sea tipo Persona
      if (!empty($bean->parent_id) && $bean->parent_type == 'Accounts' && $bean->asigna_manual_c == false) {
        $GLOBALS['log']->fatal('Proceso: Asocia llamada - Inicia Persona');

        //Recupera persona
        $beanPersona = BeanFactory::getBean("Accounts", $bean->parent_id);
        $GLOBALS['log']->fatal('Proceso: Asocia llamada - IdPer: '. $beanPersona->id);

        //Si persona es tipo Persona recupera relación y registro padre
        if ($beanPersona->tipo_registro_cuenta_c == '4') {
          $GLOBALS['log']->fatal('Proceso: Asocia llamada - relación Persona');

          //Recupera relaciones existentes
          $query = "select rel.rel_relaciones_accounts_1accounts_ida from rel_relaciones_accounts_1_c rel
          where rel_relaciones_accounts_1rel_relaciones_idb in (
            select rc.id_c from rel_relaciones_cstm rc
            join rel_relaciones r on rc.id_c = r.id
            where rc.account_id1_c='{$beanPersona->id}'
            and r.deleted=0
          )
          and rel.deleted = 0
          order by rel.date_modified desc
          limit 1;";

          $resultQ = $GLOBALS['db']->query($query);
          while ($row = $GLOBALS['db']->fetchByAssoc($resultQ)) {
  					//Recupera Relacione y procesa
            $bean->parent_id = $row['rel_relaciones_accounts_1accounts_ida'];
            $bean->description = $bean->description . ' --- Llamada generada desde Persona: ' .  $beanPersona->name;

  				}
        }
      }
    }

    function cambiAdmin ($bean = null, $event = null, $args = null)
    {
      if($bean->modified_user_id == '1')
      {
        $bean->modified_user_id = $bean->fetched_row['modified_user_id'];
      }
    }
}
?>