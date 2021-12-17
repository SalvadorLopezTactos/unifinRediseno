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

/**
 *
 * Pack standalone CLI HealthCheck Scanner for OnDemand. This is the same
 * as the previous SortingHat CLI script and can be executed as follows:
 *
 * php ScannerCli.php (for options see ScannerCli.php)
 *
 */

function packSortingHat($archive, $params, $installdefs = null, $internalPath = '')
{
    $defaults = array(
        'version' => '7.5.0.0',
        'build' => '998'
    );

    $params = array_merge($defaults, $params);

    file_put_contents(dirname(__FILE__) . '/Scanner/version.json', json_encode($params, true));

    $files = array(
        'Scanner/Scanner.php',
        'Scanner/ScannerCli.php',
        'Scanner/ScannerWeb.php',
        'Scanner/ScannerMeta.php',
        'Scanner/package-checklist.php',
        'Scanner/version.json',
        'language/en_us.lang.php',
    );

    foreach ($files as $file) {
        $archive->addFile(dirname(__FILE__) . '/' . $file, $internalPath . $file);
        if(is_array($installdefs)) {
            $installdefs['copy'][] = array("from" => "<basepath>/$internalPath$file", "to" => $internalPath . $file);
        }
    }

    return array($archive, $installdefs);
}

if (empty($argv[0]) || basename($argv[0]) != basename(__FILE__)) {
    return;
}

$sapi_type = php_sapi_name();
if (substr($sapi_type, 0, 3) != 'cli') {
    die("This is a command-line only script\n");
}

if (empty($argv[1])) {
    die("Use $argv[0] healthcheck.phar [sugarVersion [buildNumber]]\n");
}

$phar = new Phar($argv[1]);

$params = array();
if(isset($argv[2])) {
    $params['version'] = $argv[2];
}
if(isset($argv[3])) {
    $params['build'] = $argv[3];
}

packSortingHat($phar, $params);

$stub = <<<'STUB'
<?php
Phar::mapPhar();
set_include_path('phar://' . __FILE__ . PATH_SEPARATOR . get_include_path());
require_once "Scanner/ScannerCli.php"; HealthCheckScannerCli::start($argv); __HALT_COMPILER();
STUB;
$phar->setStub($stub);

if (file_exists(dirname(__FILE__) . '/Scanner/version.json')) {
    unlink(dirname(__FILE__) . '/Scanner/version.json');
}

exit(0);
