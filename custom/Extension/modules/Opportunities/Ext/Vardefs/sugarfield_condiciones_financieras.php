<?php
 // created: 2021-06-16 18:29:27
$dictionary['Opportunity']['fields']['condiciones_financieras']['audited']=false;
$dictionary['Opportunity']['fields']['condiciones_financieras']['massupdate']=false;
$dictionary['Opportunity']['fields']['condiciones_financieras']['duplicate_merge']='enabled';
$dictionary['Opportunity']['fields']['condiciones_financieras']['duplicate_merge_dom_value']='1';
$dictionary['Opportunity']['fields']['condiciones_financieras']['merge_filter']='disabled';
$dictionary['Opportunity']['fields']['condiciones_financieras']['calculated']=false;
$dictionary['Opportunity']['fields']['condiciones_financieras']['dependency']='and(not(or(equal($tipo_producto_c,"4"),equal($tipo_producto_c,"6"))),equal(getDropdownValue("switch_inicia_proceso_list","ejecuta"),"1"))';
$dictionary['Opportunity']['fields']['condiciones_financieras']['len']='255';

 ?>