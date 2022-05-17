<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

require_once 'pack_sortinghat.php';

function packHealthCheck(ZipArchive $zip, $manifest = array(), $installdefs = array(), $params = array())
{
    $defaults = array(
        'version' => '7.5.0.0',
        'build' => '998',
        'from' => '6.5.17'
    );

    $params = array_merge($defaults, $params);

    list($zip, $installdefs) = packSortingHat($zip, $params, $installdefs, 'modules/HealthCheck/');

    $files = array(
        // misc
        'include/SugarSystemInfo/SugarSystemInfo.php',
        'include/SugarHeartbeat/SugarHeartbeatClient.php',
        'include/SugarHttpClient.php',
        // healtcheck module
        'styleguide/assets/css/upgrade.css',
        'styleguide/assets/fonts/fontawesome-webfont.eot',
        'styleguide/assets/fonts/fontawesome-webfont.svg',
        'styleguide/assets/fonts/fontawesome-webfont.ttf',
        'styleguide/assets/fonts/fontawesome-webfont.woff',
        'styleguide/assets/fonts/FontAwesome.otf',
        'modules/HealthCheck/tpls/index.tpl',
        'modules/HealthCheck/views/view.index.php',
        'modules/HealthCheck/controller.php',
        'modules/HealthCheck/HealthCheck.php',
        'modules/HealthCheck/HealthCheckClient.php',
        'modules/HealthCheck/HealthCheckHelper.php',
        'modules/HealthCheck/vardefs.php',
    );

    $chdir = dirname(__FILE__) . "/../..";

    $manifest = array_merge(
        $manifest,
        array(
            'author' => 'SugarCRM, Inc.',
            'description' => 'Health Check is a tool that verifies if the instance can be upgraded to version 7.*',
            'icon' => '',
            'is_uninstallable' => 'true',
            'name' => 'Health Check',
            'published_date' => date("Y-m-d H:i:s"),
            'type' => 'module',
            'version' => $params['version'],
            'acceptable_sugar_versions' => (array)$params['from']
        )
    );

    foreach ($files as $file) {
        $zip->addFile($chdir . '/' . $file, $file);
        $installdefs['copy'][] = array("from" => "<basepath>/$file", "to" => $file);
    }

// register HealthCheck bean
    $installdefs['beans'] = array(
        array(
            'module' => 'HealthCheck',
            'class' => 'HealthCheck',
            'path' => 'modules/HealthCheck/HealthCheck.php',
            'tab' => false,
        ),
    );

// administration menu entry
    $installdefs['copy'][] = array(
        "from" => "<basepath>/healthcheck.php",
        "to" => "custom/Extension/modules/Administration/Ext/Administration/healthcheck.php"
    );
    $zip->addFromString(
        "healthcheck.php",
        "<?php\n\$admin_group_header[2][3]['Administration']['health_check']= array('Repair','LBL_HEALTH_CHECK_TITLE','LBL_HEALTH_CHECK','./index.php?module=HealthCheck');"
    );

    $installdefs['copy'][] = array(
        "from" => "<basepath>/en_us.HealthCheck.php",
        "to" => "custom/Extension/application/Ext/Language/en_us.HealthCheck.php"
    );
    $zip->addFromString(
        "en_us.HealthCheck.php",
        "<?php\n\$app_strings['LBL_HEALTH_CHECK_TITLE'] = 'Health Check';\$app_strings['LBL_HEALTH_CHECK'] = 'A tool that checks if the system is upgradable.';"
    );

    $cont = sprintf(
        "<?php\n\$manifest = %s;\n\$installdefs = %s;\n",
        var_export($manifest, true),
        var_export($installdefs, true)
    );
    $zip->addFromString("manifest.php", $cont);

    return array($zip, $manifest, $installdefs);
}


if (empty($argv[0]) || basename($argv[0]) != basename(__FILE__)) {
    return;
}

$sapi_type = php_sapi_name();
if (substr($sapi_type, 0, 3) != 'cli') {
    die("This is command-line only script");
}

if (empty($argv[1])) {
    die("Use $argv[0] name.zip [sugarVersion [buildNumber [from]]]");
}

$name = $argv[1];

$zip = new ZipArchive();
$zip->open($name, ZipArchive::CREATE);

$params = array();
if(isset($argv[2])) {
    $params['version'] = $argv[2];
}
if(isset($argv[3])) {
    $params['build'] = $argv[3];
}
if(isset($argv[4])) {
    $params['from'] = $argv[4];
}

packHealthCheck(
    $zip,
    array(),
    array("id" => "healthcheck" . time(), "copy" => array()),
    $params
);

$zip->close();

exit(0);
