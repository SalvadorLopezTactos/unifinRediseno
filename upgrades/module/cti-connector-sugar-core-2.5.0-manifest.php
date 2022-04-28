<?php
// Copyright 2016 SugarCRM Inc.  Licensed by SugarCRM under the Apache 2.0 license.

$manifest = array(
    'acceptable_sugar_flavors' => array('PRO','ENT','ULT'),
    'acceptable_sugar_versions' => array(
        'exact_matches' => array(),
        'regex_matches' => array('10.*.*','11.*.*'),
    ),
    'author' => 'SugarCRM',
    'name' => 'cti-connector-sugar-core',
    'description' => 'Loads cti-connector-sugar-core components',
    'is_uninstallable' => true,
    'type' => 'module',
    'version' => '2.5.0',
	  'key' => 'cti-connector-sugar-core',
);


$installdefs = array(
    'id' => 'SoftPhone_WDEConnector_Core',
	'beans' => array(),
    'layoutdefs' => array(),
    'relationships' => array(),
    'copy' => array(
        array(
            'from' => '<basepath>/custom/Extension/application/Ext/JSGroupings/addScriptLoaderPlugin.php',
            'to' => 'custom/Extension/application/Ext/JSGroupings/addScriptLoaderPlugin.php',
        ),
        array(
            'from' => '<basepath>/custom/include/javascript/sugar7/softphone/iwsconfig.js',
            'to' => 'custom/include/javascript/sugar7/softphone/iwsconfig.js',
        ),
        array(
            'from' => '<basepath>/custom/include/javascript/sugar7/softphone/iwscript.js',
            'to' => 'custom/include/javascript/sugar7/softphone/iwscript.js',
        ),
        array(
            'from' => '<basepath>/custom/include/javascript/sugar7/softphone/iwsprescript.js',
            'to' => 'custom/include/javascript/sugar7/softphone/iwsprescript.js',
        ),
        array(
            'from' => '<basepath>/custom/include/javascript/sugar7/softphone/loading.js',
            'to' => 'custom/include/javascript/sugar7/softphone/loading.js',
        ),
        array(
            'from' => '<basepath>/custom/include/javascript/sugar7/softphone/pureClientSdkBundle.js',
            'to' => 'custom/include/javascript/sugar7/softphone/pureClientSdkBundle.js',
        ),
        array(
            'from' => '<basepath>/custom/include/javascript/sugar7/softphone/SDK.js',
            'to' => 'custom/include/javascript/sugar7/softphone/SDK.js',
        ),
        array(
            'from' => '<basepath>/custom/include/javascript/sugar7/softphone/softphone-connector-core.min.js',
            'to' => 'custom/include/javascript/sugar7/softphone/softphone-connector-core.min.js',
        ),
        array(
            'from' => '<basepath>/custom/include/javascript/sugar7/softphone/softphone-connector-smart-ui.min.js',
            'to' => 'custom/include/javascript/sugar7/softphone/softphone-connector-smart-ui.min.js',
        ),
        array(
            'from' => '<basepath>/custom/include/javascript/sugar7/softphone/util.js',
            'to' => 'custom/include/javascript/sugar7/softphone/util.js',
        ),
       
        array(
            'from' => '<basepath>/custom/include/ixnmgr.html',
            'to' => 'custom/include/ixnmgr.html',
        ),
    ),
    'post_execute' => array(
        '<basepath>/scripts/cleanup.php',
        '<basepath>/scripts/records.php',
    ),
    'post_uninstall' => array(
        '<basepath>/scripts/cleanup.php',
    ),
);

?>
