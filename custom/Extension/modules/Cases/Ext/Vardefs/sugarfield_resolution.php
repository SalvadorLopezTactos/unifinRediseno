<?php
 // created: 2023-08-01 23:48:02
$dictionary['Case']['fields']['resolution']['audited']=true;
$dictionary['Case']['fields']['resolution']['massupdate']=false;
$dictionary['Case']['fields']['resolution']['hidemassupdate']=false;
$dictionary['Case']['fields']['resolution']['comments']='The resolution of the case';
$dictionary['Case']['fields']['resolution']['duplicate_merge']='enabled';
$dictionary['Case']['fields']['resolution']['duplicate_merge_dom_value']='1';
$dictionary['Case']['fields']['resolution']['merge_filter']='disabled';
$dictionary['Case']['fields']['resolution']['full_text_search']=array (
  'enabled' => true,
  'boost' => '0.65',
  'searchable' => true,
);
$dictionary['Case']['fields']['resolution']['calculated']=false;
$dictionary['Case']['fields']['resolution']['rows']='4';
$dictionary['Case']['fields']['resolution']['cols']='20';
$dictionary['Case']['fields']['resolution']['required']=true;
$dictionary['Case']['fields']['resolution']['required_formula']='equal($status,"3")';

 ?>