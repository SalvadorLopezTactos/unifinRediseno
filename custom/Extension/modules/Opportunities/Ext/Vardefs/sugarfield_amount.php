<?php
 // created: 2021-12-02 20:53:10
$dictionary['Opportunity']['fields']['amount']['required']=false;
$dictionary['Opportunity']['fields']['amount']['audited']=false;
$dictionary['Opportunity']['fields']['amount']['massupdate']=false;
$dictionary['Opportunity']['fields']['amount']['type']='currency';
$dictionary['Opportunity']['fields']['amount']['dbType']='currency';
$dictionary['Opportunity']['fields']['amount']['comments']='Unconverted amount of the opportunity';
$dictionary['Opportunity']['fields']['amount']['duplicate_merge']='disabled';
$dictionary['Opportunity']['fields']['amount']['duplicate_merge_dom_value']='0';
$dictionary['Opportunity']['fields']['amount']['merge_filter']='disabled';
$dictionary['Opportunity']['fields']['amount']['calculated']=false;
$dictionary['Opportunity']['fields']['amount']['related_fields']=array (
  0 => 'currency_id',
  1 => 'base_rate',
);
$dictionary['Opportunity']['fields']['amount']['validation']=array (
  'type' => 'range',
  'min' => 0,
  'max' => 1.0E+18,
);
$dictionary['Opportunity']['fields']['amount']['hidemassupdate']=false;
$dictionary['Opportunity']['fields']['amount']['readonly']=false;
$dictionary['Opportunity']['fields']['amount']['default']='';
$dictionary['Opportunity']['fields']['amount']['importable']='false';
$dictionary['Opportunity']['fields']['amount']['enable_range_search']='1';

 ?>