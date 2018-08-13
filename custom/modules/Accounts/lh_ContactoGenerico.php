<?php
class CG_Class
{
  function CG_Method($bean, $event, $arguments)
  {
    //Valida que personsa sea proveedor
    if($bean->tipo_registro_c == 'Proveedor' || ($bean->tipo_registro_c == 'Cliente' && $bean->esproveedor_c == true) ){
      //$GLOBALS['log']->fatal ('Proceso CG: Inicia - Edición Proveedor');

      //Recupera Id del CG
      global $app_list_strings;
      $idCG = $app_list_strings['tct_persona_generica_list']['accid'];
      //$GLOBALS['log']->fatal ('Proceso CG: IdCG = '. $idCG);

      //Carga relaciones
      if ($bean->load_relationship('rel_relaciones_accounts_1')) {
        //Si tiene relaciones
        //$GLOBALS['log']->fatal ('Si tiene relaciones:Itera');
        //$relatedBeans = $bean->rel_relaciones_accounts->getBeans();
        $relatedRelaciones = $bean->rel_relaciones_accounts_1->getBeans();
        $totalRelaciones = count($relatedRelaciones);
        //$GLOBALS['log']->fatal ($totalRelaciones);
        if ($totalRelaciones > 0) {
          //Valida Existencia de CG asociado
          foreach($relatedRelaciones as $relacion)
          {
            //Valida asociación con CG
            //$GLOBALS['log']->fatal ('Id: '. $relacion->account_id1_c);
            if($relacion->account_id1_c == $idCG and $totalRelaciones>1)
            {
              //Tiene más de una relación y cuenta con CG: Elimina relación de CG
              //$GLOBALS['log']->fatal ('Proceso CG: Coincide CG');
              $bean->rel_relaciones_accounts_1->delete($bean->id, $relacion->id);
              //$GLOBALS['log']->fatal (count($bean->rel_relaciones_accounts_1));

            }
          }
        }else{
          //Agrega relación
          //$GLOBALS['log']->fatal ('Sin relaciones:Agrega CG');
          $beanRelacion = BeanFactory::newBean('Rel_Relaciones');
          $beanRelacion->name='Contacto - CONTACTO GENERICO';
          $beanRelacion->account_id1_c=$idCG;
          $beanRelacion->rel_relaciones_accountsaccounts_ida=$bean->id;
          $beanRelacion->relaciones_activas='^Contacto^';
          $beanRelacion->save();
          $idRelacion = $beanRelacion->id;
          //$GLOBALS['log']->fatal ('Proceso CG: idRelacion: '. $idRelacion);
          $bean->load_relationship('rel_relaciones_accounts_1');
          $bean->rel_relaciones_accounts_1->add($idRelacion);
          //$GLOBALS['log']->fatal ('Sin relaciones:Agregada');
        }
      }

      //$GLOBALS['log']->fatal ('Proceso CG: Termina');
    }
  }

  function CG_Method_AfterAdd($bean, $event, $arguments)
  {
    if($arguments['related_module'] == 'Rel_Relaciones' && $arguments['relationship'] == 'rel_relaciones_accounts_1')
    {


      //$GLOBALS['log']->fatal ('After Add Relation - Relaciones:rel_relaciones_accounts_1');
      //$GLOBALS['log']->fatal ($arguments);
       global $app_list_strings;
      $idCG = $app_list_strings['tct_persona_generica_list']['accid'];
      //$GLOBALS['log']->fatal ('Id CG: '. $idCG);

      //Carga relaciones
      if ($bean->load_relationship('rel_relaciones_accounts_1')) {
        //Si tiene relaciones
        //$GLOBALS['log']->fatal ('Si tiene relaciones:Itera');
        //$relatedBeans = $bean->rel_relaciones_accounts->getBeans();
        $relatedRelaciones = $bean->rel_relaciones_accounts_1->getBeans();
        $totalRelaciones = count($relatedRelaciones);
        //$GLOBALS['log']->fatal ("Total relaciones: ".$totalRelaciones);
        if ($totalRelaciones >= 1) {
          //Valida Existencia de CG asociado
          foreach($relatedRelaciones as $relacion)
          {
            //Valida asociación con CG
            //$GLOBALS['log']->fatal ('Id: '. $relacion->account_id1_c);
            if($relacion->account_id1_c == $idCG && $relacion->id != $arguments['related_id'])
            {
              //Tiene más de una relación y cuenta con CG: Elimina relación de CG
              //$GLOBALS['log']->fatal ('Proceso CG: Coincide CG');
              //$GLOBALS['log']->fatal ('relacion->account_id1_c: '. $relacion->account_id1_c);
              //$GLOBALS['log']->fatal ('relacion->id: '. $relacion->id);
              //$GLOBALS['log']->fatal ('arguments[related_id]: '. $arguments['related_id']);
              //$bean->rel_relaciones_accounts_1->delete($bean->id, $relacion->id);
              $sql = "UPDATE rel_relaciones_accounts_c SET deleted=1 WHERE rel_relaciones_accountsaccounts_ida='{$arguments['id']}' and rel_relaciones_accountsrel_relaciones_idb='{$relacion->id}'";
              //$GLOBALS['log']->fatal ($sql);
              $result = $GLOBALS['db']->query($sql);

              $sql = "UPDATE rel_relaciones_accounts_1_c SET deleted=1 WHERE rel_relaciones_accounts_1accounts_ida='{$arguments['id']}' and rel_relaciones_accounts_1rel_relaciones_idb='{$relacion->id}'";
              //$GLOBALS['log']->fatal ($sql);
              $result = $GLOBALS['db']->query($sql);

              //$GLOBALS['log']->fatal ('Relación eliminada: '. $relacion->id);

            }
          }
        }
      }
    }

  }

  function CG_Method_BeforeDelete($bean, $event, $arguments)
  {
    $GLOBALS['log']->fatal ('Before Del Relation');
    //$GLOBALS['log']->fatal ($arguments);
    //$GLOBALS['log']->fatal ($event);
    $eliminar = true;
    if($arguments['related_module'] == 'Rel_Relaciones' && $arguments['relationship'] == 'rel_relaciones_accounts_1')
    {
      if ($bean->load_relationship('rel_relaciones_accounts_1')) {
        //Si tiene relaciones
        $GLOBALS['log']->fatal ('Si tiene relaciones:Itera');
        //$relatedBeans = $bean->rel_relaciones_accounts->getBeans();
        $relatedRelaciones = $bean->rel_relaciones_accounts_1->getBeans();
        $totalRelaciones = count($relatedRelaciones);
        $GLOBALS['log']->fatal ($totalRelaciones);

        //Valida Existencia de CG asociado
        if($totalRelaciones < 1 && ($bean->tipo_registro_c == 'Proveedor' || ($bean->tipo_registro_c == 'Cliente' && $bean->esproveedor_c == true)) ){
          //No tiene relaciones adicionales, detiene eliminación
          $eliminar = false;
          require_once 'include/api/SugarApiException.php';
          throw new SugarApiExceptionInvalidParameter("No puede eliminar relación. Se requiere al menos una relación para proveedor");
        }
      }
    }

    //Elimna relación
    if($eliminar == true){
      //$GLOBALS['log']->fatal ('Eliminar relación');
      $sql = "UPDATE rel_relaciones_accounts_c SET deleted=1 WHERE rel_relaciones_accountsaccounts_ida='{$arguments['id']}' and rel_relaciones_accountsrel_relaciones_idb='{$arguments['related_id']}'";
      //$GLOBALS['log']->fatal ($sql);
      $result = $GLOBALS['db']->query($sql);
    }
  }

}
?>
