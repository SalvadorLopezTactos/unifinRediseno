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
  				if($beanLead->subtipo_registro_c == '1'){
  					$beanLead->subtipo_registro_c = '2';
  					$beanLead->save();
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
                  $tipoProducto = $product->tipo_producto;
                  switch ($tipoProducto) {
                      case '1': //Leasing
                          if($beanAccount->user_id_c == $bean->assigned_user_id && ($tipoCuenta == '1' || $tipoCuenta == '')){
                              $product->tipo_cuenta = '2';
                              $product->subtipo_cuenta = '2';
                              $product->tipo_subtipo_cuenta = 'PROSPECTO CONTACTADO';
                              $product->save();
                          }
                          break;
                      case '3': //Credito-Automotriz
                          if($beanAccount->user_id2_c == $bean->assigned_user_id && ($tipoCuenta == '1' || $tipoCuenta == '')){
                              $product->tipo_cuenta = '2';
                              $product->subtipo_cuenta = '2';
                              $product->tipo_subtipo_cuenta = 'PROSPECTO CONTACTADO';
                              $product->save();
                          }
                          break;
                      case '4': //Factoraje
                          if($beanAccount->user_id1_c == $bean->assigned_user_id && ($tipoCuenta == '1' || $tipoCuenta == '')){
                              $product->tipo_cuenta = '2';
                              $product->subtipo_cuenta = '2';
                              $product->tipo_subtipo_cuenta = 'PROSPECTO CONTACTADO';
                              $product->save();
                          }
                          break;
                      case '6': //Fleet
                          if($beanAccount->user_id6_c == $bean->assigned_user_id && ($tipoCuenta == '1' || $tipoCuenta == '')){
                              $product->tipo_cuenta = '2';
                              $product->subtipo_cuenta = '2';
                              $product->tipo_subtipo_cuenta = 'PROSPECTO CONTACTADO';
                              $product->save();
                          }
                          break;
                      case '7': //Credito SOS
                          if($beanAccount->user_id_c == $bean->assigned_user_id && ($tipoCuenta == '1' || $tipoCuenta == '')){
                              $product->tipo_cuenta = '2';
                              $product->subtipo_cuenta = '2';
                              $product->tipo_subtipo_cuenta = 'PROSPECTO CONTACTADO';
                              $product->save();
                          }
                          break;
                      case '8': //Uniclick
                          if($beanAccount->user_id7_c == $bean->assigned_user_id && ($tipoCuenta == '1' || $tipoCuenta == '')){
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
          if($beanAccount->tipo_registro_cuenta_c == '1'){
    					$beanAccount->tipo_registro_cuenta_c = '2';
              $beanAccount->subtipo_registro_cuenta_c = '2';
              $beanAccount->tct_prospecto_contactado_chk_c = 1;
              $beanAccount->save();
          }
  			}
		  }
	  }
}
?>
