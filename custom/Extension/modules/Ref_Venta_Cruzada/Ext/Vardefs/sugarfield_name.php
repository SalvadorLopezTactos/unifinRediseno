<?php
 // created: 2020-07-28 02:01:56
$dictionary['Ref_Venta_Cruzada']['fields']['name']['len']='255';
$dictionary['Ref_Venta_Cruzada']['fields']['name']['audited']=false;
$dictionary['Ref_Venta_Cruzada']['fields']['name']['massupdate']=false;
$dictionary['Ref_Venta_Cruzada']['fields']['name']['importable']='false';
$dictionary['Ref_Venta_Cruzada']['fields']['name']['duplicate_merge']='disabled';
$dictionary['Ref_Venta_Cruzada']['fields']['name']['duplicate_merge_dom_value']=0;
$dictionary['Ref_Venta_Cruzada']['fields']['name']['merge_filter']='disabled';
$dictionary['Ref_Venta_Cruzada']['fields']['name']['unified_search']=false;
$dictionary['Ref_Venta_Cruzada']['fields']['name']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1.55',
  'searchable' => true,
);
$dictionary['Ref_Venta_Cruzada']['fields']['name']['calculated']='1';
$dictionary['Ref_Venta_Cruzada']['fields']['name']['formula']='concat(related($accounts_ref_venta_cruzada_1,"name"),"-",getDropdownValue("tipo_producto_list",$producto_referenciado))';
$dictionary['Ref_Venta_Cruzada']['fields']['name']['enforced']=true;

$dictionary['Ref_Venta_Cruzada']['duplicate_check']['FilterDuplicateCheck']['filter_template'] = array(
    array(
        '$and' => array(
            // array('first_name' => array('$starts' => '$first_name')),
            // array('last_name' => array('$starts' => '$last_name')),
            array('id' => array('$equals' => '$id')),
        )
    ),
);
 ?>