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
}

?>