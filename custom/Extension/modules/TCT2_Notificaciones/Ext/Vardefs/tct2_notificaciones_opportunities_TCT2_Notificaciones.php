<?php
// created: 2018-03-22 10:47:18
$dictionary["TCT2_Notificaciones"]["fields"]["tct2_notificaciones_opportunities"] = array (
  'name' => 'tct2_notificaciones_opportunities',
  'type' => 'link',
  'relationship' => 'tct2_notificaciones_opportunities',
  'source' => 'non-db',
  'module' => 'Opportunities',
  'bean_name' => 'Opportunity',
  'side' => 'right',
  'vname' => 'LBL_TCT2_NOTIFICACIONES_OPPORTUNITIES_FROM_TCT2_NOTIFICACIONES_TITLE',
  'id_name' => 'tct2_notificaciones_opportunitiesopportunities_ida',
  'link-type' => 'one',
);
$dictionary["TCT2_Notificaciones"]["fields"]["tct2_notificaciones_opportunities_name"] = array (
  'name' => 'tct2_notificaciones_opportunities_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TCT2_NOTIFICACIONES_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
  'save' => true,
  'id_name' => 'tct2_notificaciones_opportunitiesopportunities_ida',
  'link' => 'tct2_notificaciones_opportunities',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'name',
);
$dictionary["TCT2_Notificaciones"]["fields"]["tct2_notificaciones_opportunitiesopportunities_ida"] = array (
  'name' => 'tct2_notificaciones_opportunitiesopportunities_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_TCT2_NOTIFICACIONES_OPPORTUNITIES_FROM_TCT2_NOTIFICACIONES_TITLE_ID',
  'id_name' => 'tct2_notificaciones_opportunitiesopportunities_ida',
  'link' => 'tct2_notificaciones_opportunities',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
