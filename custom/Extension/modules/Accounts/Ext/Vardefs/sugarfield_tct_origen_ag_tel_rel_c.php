<?php
 // created: 2018-12-05 18:17:34
$dictionary['Account']['fields']['tct_origen_ag_tel_rel_c']['labelValue'] = 'Agente Telefónico';
$dictionary['Account']['fields']['tct_origen_ag_tel_rel_c']['dependency'] = 'or(
equal($tct_detalle_origen_ddw_c,"Centro de Prospeccion"),
equal($tct_detalle_origen_ddw_c,"Parques Industriales"),
equal($tct_detalle_origen_ddw_c,"Afiliaciones"),
equal($tct_detalle_origen_ddw_c,"Acciones Estrategicas"),
equal($tct_detalle_origen_ddw_c,"Campanas"),
equal($tct_detalle_origen_ddw_c,"Digital"),
equal($tct_detalle_origen_ddw_c,"Offline"),
equal($tct_detalle_origen_ddw_c,"Bases de datos"),
equal($tct_detalle_origen_ddw_c,"Cartera Promotores")
)';

