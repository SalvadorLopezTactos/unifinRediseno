<?php
 // created: 2020-01-13 19:18:03
$dictionary['Lead']['fields']['origen_ag_tel_c']['labelValue']='Agente Teléfonico';
$dictionary['Lead']['fields']['origen_ag_tel_c']['dependency']='or(
equal($detalle_origen_c,"Centro de Prospeccion"),
equal($detalle_origen_c,"Parques Industriales"),
equal($detalle_origen_c,"Afiliaciones"),
equal($detalle_origen_c,"Acciones Estrategicas"),
equal($detalle_origen_c,"Campanas"),
equal($detalle_origen_c,"Digital"),
equal($detalle_origen_c,"Offline"),
equal($detalle_origen_c,"Bases de datos"),
equal($detalle_origen_c,"Cartera Promotores")
)';

 ?>