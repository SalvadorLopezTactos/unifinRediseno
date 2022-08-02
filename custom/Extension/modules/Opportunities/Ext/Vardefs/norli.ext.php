<?php

	$dictionary['Opportunity']['fields']['amount']['readonly'] = false;
	$dictionary['Opportunity']['fields']['amount']['calculated'] = false;
	$dictionary['Opportunity']['fields']['best_case']['readonly'] = false;
	$dictionary['Opportunity']['fields']['best_case']['calculated'] = false;
	$dictionary['Opportunity']['fields']['worst_case']['readonly'] = false;
	$dictionary['Opportunity']['fields']['worst_case']['calculated'] = false;
	unset($dictionary['Opportunity']['fields']['date_closed']['readonly']);
	unset($dictionary['Opportunity']['fields']['date_closed']['calculated']);
	$dictionary['Opportunity']['fields']['date_closed']['audited'] = true;
	$dictionary['Opportunity']['fields']['date_closed']['required'] = true;
	unset($dictionary['Opportunity']['fields']['date_closed']['enforced']);
	unset($dictionary['Opportunity']['fields']['date_closed']['formula']);
	unset($dictionary['Opportunity']['fields']['date_closed']['massupdate']);
	$dictionary['Opportunity']['fields']['sales_status']['readonly'] = false;
	$dictionary['Opportunity']['fields']['sales_status']['calculated'] = false;
	$dictionary['Opportunity']['fields']['probability']['formula'] = 'getDropdownValue("sales_probability_dom",$sales_stage)';
	$dictionary['Opportunity']['fields']['probability']['audited'] = true;
	$dictionary['Opportunity']['fields']['probability']['calculated'] = true;
	unset($dictionary['Opportunity']['fields']['probability']['reportable']);
	unset($dictionary['Opportunity']['fields']['probability']['studio']);
	unset($dictionary['Opportunity']['fields']['probability']['massupdate']);
	$dictionary['Opportunity']['fields']['sales_stage']['readonly'] = false;
	$dictionary['Opportunity']['fields']['sales_stage']['calculated'] = false;
	unset($dictionary['Opportunity']['fields']['sales_stage']['studio']);
?>