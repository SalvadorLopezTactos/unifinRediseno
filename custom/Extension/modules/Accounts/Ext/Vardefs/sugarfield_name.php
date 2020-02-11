<?php
 // created: 2020-02-11 18:16:17
$dictionary['Account']['fields']['name']['len']='200';
$dictionary['Account']['fields']['name']['massupdate']=false;
$dictionary['Account']['fields']['name']['importable']='false';
$dictionary['Account']['fields']['name']['duplicate_merge']='disabled';
$dictionary['Account']['fields']['name']['duplicate_merge_dom_value']=0;
$dictionary['Account']['fields']['name']['merge_filter']='disabled';
$dictionary['Account']['fields']['name']['calculated']='1';
$dictionary['Account']['fields']['name']['formula']='ifElse(equal($tipodepersona_c,"Persona Moral"),$razonsocial_c,
concat($primernombre_c," ",$segundonombre_c,ifElse(equal($segundonombre_c,""),""," "),$apellidopaterno_c,ifElse(equal($apellidomaterno_c,""),""," "),$apellidomaterno_c))';
$dictionary['Account']['fields']['name']['enforced']=true;
$dictionary['Account']['fields']['name']['comments']='Name of the Company';
$dictionary['Account']['fields']['name']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1.91',
  'searchable' => true,
);

 ?>