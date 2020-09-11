<?php
 // created: 2020-09-08 18:00:09
$dictionary['S_seguros']['fields']['motivos_revision_c']['labelValue']='Motivos de la Oportunidad';
$dictionary['S_seguros']['fields']['motivos_revision_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['S_seguros']['fields']['motivos_revision_c']['enforced']='';
$dictionary['S_seguros']['fields']['motivos_revision_c']['dependency']='or(equal($etapa,3),equal($etapa,5))';

 ?>