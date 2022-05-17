<?php
$dictionary['Opportunity']['fields']['revenuelineitems']['workflow'] = true;
$dictionary['Opportunity']['duplicate_check']['FilterDuplicateCheck']['filter_template'][0]['$and'][1] = array('account_id' => array('$equals' => '$account_id'));
$dictionary['Opportunity']['duplicate_check']['FilterDuplicateCheck']['filter_template'][0]['$and'][2] = array('tct_etapa_ddw_c' => array('$equals' => 'SI'));
$dictionary['Opportunity']['duplicate_check']['FilterDuplicateCheck']['filter_template'][0]['$and'][3] = array('estatus_c' => array('$not_equals' => 'K'));
$dictionary['Opportunity']['duplicate_check']['FilterDuplicateCheck']['filter_template'][0]['$and'][4] = array('monto_c' => array('$equals' => '$monto_c'));
$dictionary['Opportunity']['duplicate_check']['FilterDuplicateCheck']['filter_template'][0]['$and'][5] = array('tipo_producto_c' => array('$equals' => '$tipo_producto_c'));

