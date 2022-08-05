<?php
// Copyright 2016 SugarCRM Inc.  Licensed by SugarCRM under the Apache 2.0 license.

$manifest = array(
    'acceptable_sugar_flavors' => array('PRO','ENT','ULT'),
    'acceptable_sugar_versions' => array(
        'exact_matches' => array(),
        'regex_matches' => array('10.*.*','11.*.*'),
    ),
    'author' => 'SugarCRM',
    'name' => 'cti-connector-sugar-ui',
    'description' => 'Loads cti-connector-sugar-ui Components and custom fields',
    'is_uninstallable' => true,
    'type' => 'module',
    'version' => '2.5.0',
	  'key' => 'cti-connector-sugar-ui',
);


$installdefs = array(
    'id' => 'SoftPhone_WDEConnector_UI',
	  'beans' => array(),
    'layoutdefs' => array(),
    'relationships' => array(),
    'copy' => array(
        array(
            'from' => '<basepath>/custom/Extension/modules/Calls/Ext/Language/add_iws.en_us.lang.php',
            'to' => 'custom/Extension/modules/Calls/Ext/Language/add_iws.en_us.lang.php',
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Calls/Ext/clients/base/views/record/add_iws_button.php',
            'to' => 'custom/Extension/modules/Calls/Ext/clients/base/views/record/add_iws_button.php',
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Language/add_iws.en_us.lang.php',
            'to' => 'custom/Extension/modules/Tasks/Ext/Language/add_iws.en_us.lang.php',
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/clients/base/views/record/add_iws_button.php',
            'to' => 'custom/Extension/modules/Tasks/Ext/clients/base/views/record/add_iws_button.php',
        ),
        
        array(
            'from' => '<basepath>/custom/modules/Calls/clients/base/views/record/record.js',
            'to' => 'custom/modules/Calls/clients/base/views/record/record.js',
        ),
        array(
            'from' => '<basepath>/custom/modules/Calls/clients/base/views/viewinteraction/viewinteraction.hbs',
            'to' => 'custom/modules/Calls/clients/base/views/viewinteraction/viewinteraction.hbs',
        ),
        array(
            'from' => '<basepath>/custom/modules/Calls/clients/base/views/viewinteraction/viewinteraction.js',
            'to' => 'custom/modules/Calls/clients/base/views/viewinteraction/viewinteraction.js',
        ),
        array(
            'from' => '<basepath>/custom/modules/Calls/clients/base/views/viewinteraction/viewinteraction.php',
            'to' => 'custom/modules/Calls/clients/base/views/viewinteraction/viewinteraction.php',
        ),
        array(
            'from' => '<basepath>/custom/modules/Tasks/clients/base/views/record/record.js',
            'to' => 'custom/modules/Tasks/clients/base/views/record/record.js',
        ),
        array(
            'from' => '<basepath>/custom/modules/Tasks/clients/base/views/viewinteraction/viewinteraction.hbs',
            'to' => 'custom/modules/Tasks/clients/base/views/viewinteraction/viewinteraction.hbs',
        ),
        array(
            'from' => '<basepath>/custom/modules/Tasks/clients/base/views/viewinteraction/viewinteraction.js',
            'to' => 'custom/modules/Tasks/clients/base/views/viewinteraction/viewinteraction.js',
        ),
        array(
            'from' => '<basepath>/custom/modules/Tasks/clients/base/views/viewinteraction/viewinteraction.php',
            'to' => 'custom/modules/Tasks/clients/base/views/viewinteraction/viewinteraction.php',
        ),
        array(
            'from' => '<basepath>/custom/themes/custom.less',
            'to' => 'custom/themes/custom.less',
        ),
    ),
    'post_execute' => array(
        '<basepath>/scripts/cleanup.php',
    ),
    'post_uninstall' => array(
        '<basepath>/scripts/cleanup.php',
    ),
	'custom_fields' => array(
        //Text
        array(
            'name' => 'iws_interactionid',
            'label' => 'IWS Interaction ID',
            'type' => 'varchar',
            'module' => 'Tasks',
            'help' => '',
            'comment' => '',
            'default_value' => '',
            'max_size' => 36,
            'required' => false, // true or false
            'reportable' => true, // true or false
            'audited' => false, // true or false
            'importable' => 'true', // 'true', 'false', 'required'
            'duplicate_merge' => false, // true or false
        ),
		array(
            'name' => 'iws_medianame',
            'label' => 'IWS Media Name',
            'type' => 'varchar',
            'module' => 'Tasks',
            'help' => '',
            'comment' => '',
            'default_value' => '',
            'max_size' => 15,
            'required' => false, // true or false
            'reportable' => true, // true or false
            'audited' => false, // true or false
            'importable' => 'true', // 'true', 'false', 'required'
            'duplicate_merge' => false, // true or false
        ),
		array(
            'name' => 'iws_interactionid',
            'label' => 'IWS Interaction ID',
            'type' => 'varchar',
            'module' => 'Calls',
            'help' => '',
            'comment' => '',
            'default_value' => '',
            'max_size' => 36,
            'required' => false, // true or false
            'reportable' => true, // true or false
            'audited' => false, // true or false
            'importable' => 'true', // 'true', 'false', 'required'
            'duplicate_merge' => false, // true or false
        ),
		array(
            'name' => 'iws_medianame',
            'label' => 'IWS Media Name',
            'type' => 'varchar',
            'module' => 'Calls',
            'help' => '',
            'comment' => '',
            'default_value' => '',
            'max_size' => 15,
            'required' => false, // true or false
            'reportable' => true, // true or false
            'audited' => false, // true or false
            'importable' => 'true', // 'true', 'false', 'required'
            'duplicate_merge' => false, // true or false
        ),
	),
);

?>
