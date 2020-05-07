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
		  if($bean->status == "Held" && $bean->parent_type == 'Accounts' && $bean->parent_id){
  		  $beanAccount = BeanFactory::getBean('Accounts', $bean->parent_id);
				if($beanAccount->user_id_c == $bean->assigned_user_id || $beanAccount->user_id1_c == $bean->assigned_user_id || $beanAccount->user_id2_c == $bean->assigned_user_id || $beanAccount->user_id6_c == $bean->assigned_user_id || $beanAccount->user_id7_c == $bean->assigned_user_id){
          $beanUser = BeanFactory::getBean('Users', $bean->assigned_user_id);
          $beanResumen = BeanFactory::getBean('tct02_Resumen', $bean->parent_id);
          if($beanAccount->user_id_c == $bean->assigned_user_id && $beanResumen->tct_tipo_l_txf_c == 'Lead'){
            $beanResumen->tct_tipo_l_txf_c = "Prospecto";
            $beanResumen->tct_subtipo_l_txf_c = "Contactado";
            $beanResumen->tct_tipo_cuenta_l_c = "PROSPECTO CONTACTADO";
          }
          if($beanAccount->user_id2_c == $bean->assigned_user_id && $beanResumen->tct_tipo_ca_txf_c == 'Lead'){
            $beanResumen->tct_tipo_ca_txf_c = "Prospecto";
            $beanResumen->tct_subtipo_ca_txf_c = "Contactado";
            $beanResumen->tct_tipo_cuenta_ca_c = "PROSPECTO CONTACTADO";
          }
          if($beanAccount->user_id1_c == $bean->assigned_user_id && $beanResumen->tct_tipo_f_txf_c == 'Lead'){
            $beanResumen->tct_tipo_f_txf_c = "Prospecto";
            $beanResumen->tct_subtipo_f_txf_c = "Contactado";
            $beanResumen->tct_tipo_cuenta_f_c = "PROSPECTO CONTACTADO";
          }
          if($beanAccount->user_id6_c == $bean->assigned_user_id && $beanResumen->tct_tipo_fl_txf_c == 'Lead'){
            $beanResumen->tct_tipo_fl_txf_c = "Prospecto";
            $beanResumen->tct_subtipo_fl_txf_c = "Contactado";
            $beanResumen->tct_tipo_cuenta_fl_c = "PROSPECTO CONTACTADO";
          }
          if($beanAccount->user_id7_c == $bean->assigned_user_id && $beanResumen->tct_tipo_uc_txf_c == 'Lead'){
            $beanResumen->tct_tipo_uc_txf_c = "Prospecto";
            $beanResumen->tct_subtipo_uc_txf_c = "Contactado";
            $beanResumen->tct_tipo_cuenta_uc_c = "PROSPECTO CONTACTADO";
          }
          $beanResumen->save();
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
