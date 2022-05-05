<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class callLead_class
{
    function LeadContactado($bean, $event, $arguments)
    {
		  if($bean->status == "Held"){
  			$parent_id = $bean->parent_id;  //ID DE LA CUENTA
  			$parentType = $bean->parent_type;  //Modulo
  			if ($parentType == 'Leads') {
  				$beanLead = BeanFactory::getBean('Leads', $parent_id);
  				//$GLOBALS['log']->fatal('Id_lead',$beanLead->id);
  				if($beanLead->subtipo_registro_c == '13' || $beanLead->subtipo_registro_c == '1'){
  					$beanLead->subtipo_registro_c = '2';
  					$beanLead->save();
  				}
  			}
        if ($parentType == 'Prospects') {
  				$beanPO = BeanFactory::getBean('Prospects', $parent_id);
  				if($beanPO->estatus_po_c == '1'){
            $beanPO->estatus_po_c = '2';
  					$beanPO->subestatus_po_c = '1';
  					$beanPO->save();
  				}
  			}
		  }
	  }

    function ProspectoContactado($bean, $event, $arguments)
    {
      //Valuda cuenta Asociada y estado de reunión realizada
		  if($bean->status == "Held" && $bean->parent_type == 'Accounts' && $bean->parent_id){
        //Recupera cuenta
  		  $beanAccount = BeanFactory::getBean('Accounts', $bean->parent_id);
        //Comprueba usuario asignado corresponda a asesor de cuenta
				if($beanAccount->user_id_c == $bean->assigned_user_id || $beanAccount->user_id1_c == $bean->assigned_user_id || $beanAccount->user_id2_c == $bean->assigned_user_id || $beanAccount->user_id6_c == $bean->assigned_user_id || $beanAccount->user_id7_c == $bean->assigned_user_id){
          //Recupera producto y actualiza Tipo y subtipo: Prospecto Contactado
          if ($beanAccount->load_relationship('accounts_uni_productos_1')) {
              //Recupera Productos
              $relateProducts = $beanAccount->accounts_uni_productos_1->getBeans($beanAccount->id,array('disable_row_level_security' => true));
              foreach ($relateProducts as $product) {
                  $tipoCuenta = $product->tipo_cuenta;
                  $subtipoCuenta = $product->subtipo_cuenta;
                  $tipoProducto = $product->tipo_producto;

                  switch ($tipoProducto) {
                      case '1': //Leasing
                          if($beanAccount->user_id_c == $bean->assigned_user_id && (($tipoCuenta == '2' && $subtipoCuenta == '1') || ($tipoCuenta == '1' && $subtipoCuenta == '5'))) {
                              $product->tipo_cuenta = '2';
                              $product->subtipo_cuenta = '2';
                              $product->tipo_subtipo_cuenta = 'PROSPECTO CONTACTADO';
                              $product->save();
                          }
                          break;
                      case '3': //Credito-Automotriz
                          if($beanAccount->user_id2_c == $bean->assigned_user_id && (($tipoCuenta == '2' && $subtipoCuenta == '1') || ($tipoCuenta == '1' && $subtipoCuenta == '5'))) {
                              $product->tipo_cuenta = '2';
                              $product->subtipo_cuenta = '2';
                              $product->tipo_subtipo_cuenta = 'PROSPECTO CONTACTADO';
                              $product->save();
                          }
                          break;
                      case '4': //Factoraje
                          if($beanAccount->user_id1_c == $bean->assigned_user_id && (($tipoCuenta == '2' && $subtipoCuenta == '1') || ($tipoCuenta == '1' && $subtipoCuenta == '5'))) {
                              $product->tipo_cuenta = '2';
                              $product->subtipo_cuenta = '2';
                              $product->tipo_subtipo_cuenta = 'PROSPECTO CONTACTADO';
                              $product->save();
                          }
                          break;
                      case '6': //Fleet
                          if($beanAccount->user_id6_c == $bean->assigned_user_id && (($tipoCuenta == '2' && $subtipoCuenta == '1') || ($tipoCuenta == '1' && $subtipoCuenta == '5'))) {
                              $product->tipo_cuenta = '2';
                              $product->subtipo_cuenta = '2';
                              $product->tipo_subtipo_cuenta = 'PROSPECTO CONTACTADO';
                              $product->save();
                          }
                          break;
                      case '7': //Credito SOS
                          if($beanAccount->user_id_c == $bean->assigned_user_id && (($tipoCuenta == '2' && $subtipoCuenta == '1') || ($tipoCuenta == '1' && $subtipoCuenta == '5'))) {
                              $product->tipo_cuenta = '2';
                              $product->subtipo_cuenta = '2';
                              $product->tipo_subtipo_cuenta = 'PROSPECTO CONTACTADO';
                              $product->save();
                          }
                          break;
                      case '8': //Uniclick
                          if($beanAccount->user_id7_c == $bean->assigned_user_id && (($tipoCuenta == '2' && $subtipoCuenta == '1') || ($tipoCuenta == '1' && $subtipoCuenta == '5'))) {
                              $product->tipo_cuenta = '2';
                              $product->subtipo_cuenta = '2';
                              $product->tipo_subtipo_cuenta = 'PROSPECTO CONTACTADO';
                              $product->save();
                          }
                          break;
                      case '9': //Unilease
                          if($beanAccount->user_id7_c == $bean->assigned_user_id && (($tipoCuenta == '2' && $subtipoCuenta == '1') || ($tipoCuenta == '1' && $subtipoCuenta == '5'))) {
                              $product->tipo_cuenta = '2';
                              $product->subtipo_cuenta = '2';
                              $product->tipo_subtipo_cuenta = 'PROSPECTO CONTACTADO';
                              $product->save();
                          }
                          break;
                      case '2': //Crédito Simple
                          if($beanAccount->user_id_c == $bean->assigned_user_id && (($tipoCuenta == '2' && $subtipoCuenta == '1') || ($tipoCuenta == '1' && $subtipoCuenta == '5'))) {
                              $product->tipo_cuenta = '2';
                              $product->subtipo_cuenta = '2';
                              $product->tipo_subtipo_cuenta = 'PROSPECTO CONTACTADO';
                              $product->save();
                          }
                          break;
                      case '12': //Crédito Revolvente
                          if($beanAccount->user_id7_c == $bean->assigned_user_id && (($tipoCuenta == '2' && $subtipoCuenta == '1') || ($tipoCuenta == '1' && $subtipoCuenta == '5'))) {
                              $product->tipo_cuenta = '2';
                              $product->subtipo_cuenta = '2';
                              $product->tipo_subtipo_cuenta = 'PROSPECTO CONTACTADO';
                              $product->save();
                          }
                          break;
                      default:
                          break;
                  }
              }
          }
          //Actualiza Tipo y subtipo General: Prospecto Contactado
          //Sólo actualiza si Tipo y Subtipo de registro general es: Prospecto Sin Contactar o Lead en Calificación
          if(($beanAccount->tipo_registro_cuenta_c == '2' && $beanAccount->subtipo_registro_cuenta_c == '1') || ($beanAccount->tipo_registro_cuenta_c == '1' && $beanAccount->subtipo_registro_cuenta_c == '5')){
    					$beanAccount->tipo_registro_cuenta_c = '2';
              $beanAccount->subtipo_registro_cuenta_c = '2';
              $beanAccount->tct_prospecto_contactado_chk_c = 1;
              $beanAccount->save();
          }
  			}
		  }
	  }

    function ConvierteLead($bean, $event, $arguments)
    {
 			$parent_id = $bean->parent_id;
 			$parentType = $bean->parent_type;
		  if($bean->status == "Held" && $bean->tct_call_issabel_c == 0 && $parentType == 'Leads') {
        require_once("custom/clients/base/api/check_duplicateAccounts.php");
        $filter_arguments = array("id" => $parent_id);
        $callApi = new check_duplicateAccounts();
        $convert = $callApi->validation_process(null,$filter_arguments);
        $beanLead = BeanFactory::getBean('Leads', $parent_id);
   			$beanLead->description = $convert["mensaje"];
  			$beanLead->save();
		  }
	  }

      function InfoCall($bean = null, $event = null, $args = null)
      {
        if (!$args['isUpdate']) {
          global $db ,$current_user;
          //$GLOBALS['log']->fatal("InfoCall: Inicio");
          //Realiza consulta para obtener info del usuario asignado
          $query="SELECT cstm.region_c,cstm.equipos_c,cstm.tipodeproducto_c,cstm.puestousuario_c from users as u
          INNER JOIN users_cstm as cstm
          ON u.id=cstm.id_c
          WHERE id='{$bean->assigned_user_id}'";
          //$GLOBALS['log']->fatal("InfoCall: consulta : ".$query);
          $queryResult = $db->query($query);
          //$GLOBALS['log']->fatal("InfoCall: Consulta para usuario asignado " .print_r($queryResult, true));
          while ($row = $db->fetchByAssoc($queryResult)) {
            //Setea valores usuario ASIGNADO
            $bean->asignado_region_c=$row['region_c'];
            $bean->asignado_equipo_promocion_c=$row['equipos_c'];
            $bean->asignado_producto_c=$row['tipodeproducto_c'];
            $bean->asignado_puesto_c=$row['puestousuario_c'];
          }
          //$GLOBALS['log']->fatal("InfoCall: Setea valores usuario logueado");
          //Setea valores usuario LOGUEADO/Creador del registro
          $bean->creado_region_c= $current_user->region_c;
          $bean->creado_equipo_promocion_c =$current_user->equipos_c;
          $bean->creado_producto_c= $current_user->tipodeproducto_c;
          $bean->creado_puesto_c=$current_user->puestousuario_c;
          //$GLOBALS['log']->fatal("InfoCall: Finaliza");
        }
      }
}
?>
