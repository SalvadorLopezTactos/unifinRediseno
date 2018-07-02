<?php

$manifest = array (
  'acceptable_sugar_versions' => 
  array (
    0 => '7',
  ),
  'acceptable_sugar_flavors' => 
  array (
    0 => 'CE',
    1 => 'PRO',
    2 => 'ENT',
    3 => 'ULT',
    4 => 'CORP',
  ),
  'readme' => '',
  'key' => '',
  'author' => 'Lev',
  'description' => '',
  'icon' => '',
  'is_uninstallable' => 'true',
  'name' => 'PDFManager',
  'published_date' => '2016-04-28 11:20:51',
  'type' => 'module',
  'version' => '1.0',
  'remove_tables' => 'prompt',
);
$installdefs = array (
  'id' => 'custom',
  'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/custom/modules/Opportunities/sugarpdf/sugarpdf.pdfmanager.php',
      'to' => 'custom/modules/Opportunities/sugarpdf/sugarpdf.pdfmanager.php',
    ),
  ),
);

?>