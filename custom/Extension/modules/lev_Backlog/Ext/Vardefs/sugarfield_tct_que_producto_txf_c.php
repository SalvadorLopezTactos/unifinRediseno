<?php
 // created: 2018-07-23 12:06:24
$dictionary['lev_Backlog']['fields']['tct_que_producto_txf_c']['labelValue']='¿Qué producto? ';
$dictionary['lev_Backlog']['fields']['tct_que_producto_txf_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['lev_Backlog']['fields']['tct_que_producto_txf_c']['enforced']='';
$dictionary['lev_Backlog']['fields']['tct_que_producto_txf_c']['dependency']='and(equal($motivo_de_cancelacion,"No tenemos el producto que requiere"))';

 ?>