<?php
 // created: 2020-01-02 00:16:23
$dictionary['Lead']['fields']['razonsocial_c']['labelValue']='Razón Social';
$dictionary['Lead']['fields']['razonsocial_c']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1',
  'searchable' => true,
);
$dictionary['Lead']['fields']['razonsocial_c']['enforced']='false';
$dictionary['Lead']['fields']['razonsocial_c']['dependency']='and(equal($regimen_fiscal_c,"Persona Moral"))';

 ?>