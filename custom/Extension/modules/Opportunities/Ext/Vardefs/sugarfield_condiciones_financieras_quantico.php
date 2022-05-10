<?php
 // created: 2021-07-08 16:28:40
$dictionary['Opportunity']['fields']['condiciones_financieras_quantico']['len']='255';
$dictionary['Opportunity']['fields']['condiciones_financieras_quantico']['audited']=false;
$dictionary['Opportunity']['fields']['condiciones_financieras_quantico']['massupdate']=false;
$dictionary['Opportunity']['fields']['condiciones_financieras_quantico']['duplicate_merge']='enabled';
$dictionary['Opportunity']['fields']['condiciones_financieras_quantico']['duplicate_merge_dom_value']='1';
$dictionary['Opportunity']['fields']['condiciones_financieras_quantico']['merge_filter']='disabled';
$dictionary['Opportunity']['fields']['condiciones_financieras_quantico']['calculated']=false;
$dictionary['Opportunity']['fields']['condiciones_financieras_quantico']['dependency']='and(equal(getDropdownValue("switch_inicia_proceso_list","ejecuta"),"0"),not(equal($date_entered,"")))';

 ?>
