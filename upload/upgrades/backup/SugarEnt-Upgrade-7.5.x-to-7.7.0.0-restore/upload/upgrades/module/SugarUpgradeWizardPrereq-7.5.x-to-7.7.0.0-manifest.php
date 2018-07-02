<?php
$manifest = array (
  'author' => 'SugarCRM, Inc.',
  'description' => 'SugarCRM Upgrader 7.7.0.0',
  'icon' => '',
  'is_uninstallable' => 'true',
  'name' => 'SugarCRM Upgrader 7.7.0.0',
  'published_date' => '2016-04-08 00:36:14',
  'type' => 'module',
  'version' => '7.7.0.0',
  'acceptable_sugar_versions' => 
  array (
    0 => '7.5.2.3',
    1 => '7.5.2.4',
    2 => '7.5.0.0',
    3 => '7.5.0.1',
    4 => '7.5.1.0',
    5 => '7.5.2.0',
    6 => '7.5.2.1',
    7 => '7.5.2.2',
  ),
);
$installdefs = array (
  'id' => 'upgrader1460075774',
  'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/UpgradeWizard.php',
      'to' => 'UpgradeWizard.php',
    ),
    1 => 
    array (
      'from' => '<basepath>/modules/UpgradeWizard/UpgradeDriver.php',
      'to' => 'modules/UpgradeWizard/UpgradeDriver.php',
    ),
    2 => 
    array (
      'from' => '<basepath>/modules/UpgradeWizard/WebUpgrader.php',
      'to' => 'modules/UpgradeWizard/WebUpgrader.php',
    ),
    3 => 
    array (
      'from' => '<basepath>/modules/UpgradeWizard/upgrade_screen.php',
      'to' => 'modules/UpgradeWizard/upgrade_screen.php',
    ),
    4 => 
    array (
      'from' => '<basepath>/modules/UpgradeWizard/version.json',
      'to' => 'modules/UpgradeWizard/version.json',
    ),
    5 => 
    array (
      'from' => '<basepath>/modules/UpgradeWizard/language/en_us.lang.php',
      'to' => 'custom/modules/UpgradeWizard/language/en_us.lang.php',
    ),
    6 => 
    array (
      'from' => '<basepath>/sidecar/lib/jquery/jquery.iframe.transport.js',
      'to' => 'sidecar/lib/jquery/jquery.iframe.transport.js',
    ),
    7 => 
    array (
      'from' => '<basepath>/styleguide/assets/css/upgrade.css',
      'to' => 'styleguide/assets/css/upgrade.css',
    ),
    8 => 
    array (
      'from' => '<basepath>/styleguide/assets/fonts/fontawesome-webfont.eot',
      'to' => 'styleguide/assets/fonts/fontawesome-webfont.eot',
    ),
    9 => 
    array (
      'from' => '<basepath>/styleguide/assets/fonts/fontawesome-webfont.svg',
      'to' => 'styleguide/assets/fonts/fontawesome-webfont.svg',
    ),
    10 => 
    array (
      'from' => '<basepath>/styleguide/assets/fonts/fontawesome-webfont.ttf',
      'to' => 'styleguide/assets/fonts/fontawesome-webfont.ttf',
    ),
    11 => 
    array (
      'from' => '<basepath>/styleguide/assets/fonts/fontawesome-webfont.woff',
      'to' => 'styleguide/assets/fonts/fontawesome-webfont.woff',
    ),
    12 => 
    array (
      'from' => '<basepath>/styleguide/assets/fonts/FontAwesome.otf',
      'to' => 'styleguide/assets/fonts/FontAwesome.otf',
    ),
    13 => 
    array (
      'from' => '<basepath>/include/SugarSystemInfo/SugarSystemInfo.php',
      'to' => 'include/SugarSystemInfo/SugarSystemInfo.php',
    ),
    14 => 
    array (
      'from' => '<basepath>/include/SugarHeartbeat/SugarHeartbeatClient.php',
      'to' => 'include/SugarHeartbeat/SugarHeartbeatClient.php',
    ),
    15 => 
    array (
      'from' => '<basepath>/include/SugarHttpClient.php',
      'to' => 'include/SugarHttpClient.php',
    ),
    16 => 
    array (
      'from' => '<basepath>/upgrader2.php',
      'to' => 'custom/Extension/modules/Administration/Ext/Administration/upgrader2.php',
    ),
  ),
);
