<?php
 // created: 2020-05-26 10:30:08
$dictionary['Account']['fields']['tct_origen_busqueda_txf_c']['labelValue']='Base';
$dictionary['Account']['fields']['tct_origen_busqueda_txf_c']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1',
  'searchable' => true,
);
$dictionary['Account']['fields']['tct_origen_busqueda_txf_c']['enforced']='';
$dictionary['Account']['fields']['tct_origen_busqueda_txf_c']['dependency']='equal($detalle_origen_c,"1")';

 ?>