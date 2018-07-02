<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

require_once __DIR__ . '/ScannerMeta.php';

/**
 *
 * HealthCheck Scanner
 *
 */
class HealthCheckScanner
{
    const VERSION_FILE = 'version.json';

    // failure status
    const FAIL = 99;

    /**
     *
     * @var HealthCheckScannerMeta
     */
    protected $meta;

    /**
     *
     * @var string Directory of the instance to scan
     */
    protected $instance;

    /**
     *
     * DB connection to Sugar
     * @var DBManager
     */
    protected $db;

    /**
     *
     * @var string Log filename
     */
    protected $logfile = "healthcheck.log";

    /**
     *
     * @var integer Verbose log level (0, 1, 2)
     */
    protected $verbose = 0;

    /**
     *
     * @var integer Exit status (FIXME: do we need this here ?)
     */
    protected $exit_status = 0;

    /**
     *
     * @var string FIXME: input Zac
     */
    protected $ping_url = 'http://sortinghat-sugarcrm.rhcloud.com/feedback';

    /**
     *
     * FIXME: This needs to move to config file/class as this is OD specific
     * @var array List of packages with compatible versions to check.
     */
    protected $packages = array(
        'SugarSMS' => array(
            array('version' => '*'),
        ),
        'GoogleSalesMap' => array(
            array('version' => '3.0.2'),
        ),
        'Zendesk' => array(
            array('version' => '2.8'),
        ),
        'Act-On Integrated Marketing Automation for SugarCRM' => array(
            array('version' => '*'),
        ),
        'Pardot Marketing Automation for SugarCRM' => array(
            array('version' => '*'),
        ),
        'iNetMaps' => array(
            array('version' => '*'),
        ),
        'Sugar-Constant Contact Integration' => array(
            array('version' => '*'),
        ),
        'Adobe EchoSign e-Signatures for SugarCRM' => array(
            array('version' => '*'),
        ),
        'DocuSign for SugarCRM' => array(
            array('version' => '*'),
        ),
        'FBSG SugarCRM QuickBooks Integration' => array(
            array('version' => '*'),
        ),
        'JJWDesign_Google_Maps' => array(
            array('version' => '*'),
        ),
        'Dashboard Manager' => array(
            array('version' => '*'),
        ),
        'Fonality' => array(
            array('version' => '*'),
        ),
        'inetDOCS Box' => array(
            array('version' => '*'),
        ),
        'Forums, Threads, Posts Modules' => array(
            array('version' => '*'),
        ),
        'Accounting' => array(
            array('version' => '*', 'author' => 'CRM Online Australia Pty Ltd'),
        ),
        'Marketo Marketing Automation for SugarCRM' => array(
            array('version' => '3.0'),
        ),
        'SugarChimp' => array(
            array('version' => '7.0.1'),
        ),
        'Calendar 2.0 V1.2 003' => array(
            array('version' => '*'),
        ),
        'Sugar - MAS90 Integration' => array(
            array('version' => '*'),
        ),
        'MAS90Integrator' => array(
            array('version' => '*'),
        ),
        'ContactIndicators' => array(
            array('version' => '*'),
        ),
        'Integral Sales' => array(
            array('version' => '*'),
        ),
        'Teleseller' => array(
            array('version' => '*'),
        ),
        'Freshdesk' => array(
            array('version' => '*'),
        ),
        'Sugar-Sage Integration Modules' => array(
            array('version' => '2.7.0-8-g74f8c47'),
        ),
        'inetMAPS' => array(
            array('version' => '*', 'path' => 'modules/inetMAPS/classes/'),
        ),
        'tagMe' => array(
            array('version' => '*'),
        )
    );

    /**
     * @var array List of modules which excluded from table check.
     */
    protected $excludeModules = array(
        'Audit',
        'Connectors',
        'DynamicFields',
        'MergeRecords',
    );

    /**
     * @var array List of unsupported modules.
     */
    protected $unsupportedModules = array(
        'Feeds',
        'iFrames'
    );

    /**
     *
     * Instance status (bucket)
     * @var string
     */
    protected $status = HealthCheckScannerMeta::VANILLA;

    /**
     *
     * @var int
     */
    protected $flag = HealthCheckScannerMeta::FLAG_GREEN;

    /**
     *
     * @var array
     */
    protected $status_log = array();

    /**
     * @var resource
     */
    protected $fp;

    /**
     * metadata log
     *
     * @var array
     */
    protected $logMeta = array();

    /**
     * Health Check module properties
     *
     * @var array
     */
    protected $healthCheckModule = array(
        'bean' => 'HealthCheck',
        'file' => 'modules/HealthCheck/HealthCheck.php',
        'md5' => './modules/HealthCheck/HealthCheck.php'
    );


    /**
     * Ignored files
     *
     * @var array
     */
    protected $ignoredFiles = array(
        'custom/Extension/modules/Administration/Ext/Administration/upgrader2.php',
        'custom/Extension/modules/Administration/Ext/Administration/healthcheck.php'
    );

    /**
     * Array of files which will not be scanned for output
     * @var array
     */
    protected $ignoreOutputCheckFiles = array(
        'modules/Connectors/connectors/sources/ext/rest/insideview/InsideViewLogicHook.php',
        'modules/Connectors/connectors/sources/ext/rest/inbox25/InboxViewLogicHook.php',
    );

    /**
     * If Scanner founds some number of files and is going to report them, it's better to report them in bunches.
     * This field defines an appropriate bunch size.
     * @see CRYS-554
     *
     * @var int
     */
    protected $numberOfFilesToReport = 5;

    /**
     *
     * Ctor setup
     * @return void
     */
    public function __construct()
    {
        $this->meta = HealthCheckScannerMeta::getInstance();
        $this->logfile = "healthcheck-" . time() . ".log";
    }

    /**
     *
     * Log message
     * @param string $msg Log message
     * @param string $tag Log level
     * @return string formatted log message
     */
    protected function log($msg, $tag = 'INFO')
    {
        $fmsg = sprintf("[%s] %s %s\n", date('c'), $tag, $msg);

        if (empty($this->fp)) {
            $this->fp = @fopen($this->logfile, 'a+');
        }
        if (empty($this->fp)) {
            throw new RuntimeException("Cannot open logfile: $this->logfile");
        }

        fwrite($this->fp, $fmsg);

        return $fmsg;
    }

    /**
     *
     * Script failure
     * @param string $msg
     * @return false
     */
    public function fail($msg)
    {
        $this->exit_status = self::FAIL;
        $this->updateStatus('scriptFailure', $msg);
        $this->log($msg, 'ERROR');
        return false;
    }

    /**
     *
     * Add reason to stats log
     * @param integer $status Bucket code
     * @param integer $code Scan id
     * @param string $reason Reason log
     * @return void
     */
    protected function logReason($status, $code, $reason)
    {
        $this->status_log[$status][] = array(
            'code' => $code,
            'reason' => $reason
        );
    }

    /**
     *
     * If current status is lower that this, raise it
     * @param id|string $id Scan id or report id
     * @param mixed
     */
    public function updateStatus()
    {
        $params = func_get_args();

        $id = array_shift($params);

        $scanMeta = $this->meta->getMetaFromReportId($id, $params);

        // load default failure if no metadata can be found for given $id
        if ($scanMeta === false) {
            $scanMeta = $this->meta->getMetaFromReportId('unknownFailure');
        }

        $status = $scanMeta['bucket'];
        $code = $scanMeta['id'];
        $report = $scanMeta['report'];
        $this->logMeta[] = $scanMeta;
        $issueNo = count($this->logMeta);

        $reason = "[Issue $issueNo][$report][$code][" . vsprintf($scanMeta['log'], $params) . ']';

        $this->log($reason, 'CHECK-' . $status);
        $this->logReason($status, $code, $reason);


        if ($status > $this->status) {
            $this->log("===> Status changed to $status", 'STATUS');
            $this->status = $status;
        }

        /*
         * Every scan code can have a separate flag apart from the actual
         * bucket. This has only meaning for the health check module.
         *
         * @see HealthCheckScannerMeta::$defaultFlagMap
         */
        if ($scanMeta['flag'] > $this->flag) {
            $this->flag = $scanMeta['flag'];
        }
    }

    /**
     * @return array
     */
    public function getLogMeta()
    {
        return $this->logMeta;
    }

    /**
     *
     * Setter logfile
     * @param string $fileName
     */
    public function setLogFile($fileName)
    {
        $this->logfile = $fileName;
    }

    /**
     *
     * Getter logfile
     * @return string
     */
    public function getLogFile()
    {
        return $this->logfile;
    }

    /**
     *
     * Setter fp
     * @param $fp
     */
    public function setLogFilePointer($fp)
    {
        $this->fp = $fp;
    }

    /**
     *
     * Check if flag is green
     * @return boolean
     */
    public function isFlagGreen()
    {
        return $this->flag == HealthCheckScannerMeta::FLAG_GREEN;
    }

    /**
     *
     * Check if flag is yello
     * @return boolean
     */
    public function isFlagYellow()
    {
        return $this->flag == HealthCheckScannerMeta::FLAG_YELLOW;
    }

    /**
     *
     * Check if flag is red
     * @return boolean
     */
    public function isFlagRed()
    {
        return $this->flag == HealthCheckScannerMeta::FLAG_RED;
    }

    /**
     *
     * Setter verbose level
     * @param integer $level
     */
    public function setVerboseLevel($level)
    {
        $this->verbose = $level;
    }


    /**
     *
     * Setter instance directory
     * @param string $directory
     */
    public function setInstanceDir($directory)
    {
        $this->instance = $directory;
    }

    /**
     *
     * Getter status (verdict)
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Getter verbose (output)
     * @return int
     */
    public function getVerbose()
    {
        return $this->verbose;
    }

    /**
     *
     * Getter flag
     * @return integer
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     *
     * Getter status_log
     * @return array
     */
    public function getStatusLog()
    {
        return $this->status_log;
    }

    /**
     * Method detects current version and flavor of installed SugarCRM and returns them
     *
     * @return array (version, flavor)
     */
    public function getVersionAndFlavor()
    {
        $sugar_version = '9.9.9';
        $sugar_flavor = 'unknown';
        include "sugar_version.php";
        return array($sugar_version, $sugar_flavor);
    }

    /**
     * @return PackageManager
     */
    public function getPackageManager()
    {
        return new PackageManager();
    }

    /**
     *
     * Main
     * @return void|multitype:
     */
    public function scan()
    {
        set_error_handler(array($this, 'scriptErrorHandler'), E_ALL & ~E_STRICT & ~E_DEPRECATED);
        $this->log(vsprintf("HealthCheck v.%s (build %s) starting scanning $this->instance", $this->getVersion()));
        if (!$this->init()) {
            return $this->logMeta;
        }

        list($sugar_version, $sugar_flavor) = $this->getVersionAndFlavor();
        $this->log("Instance version: $sugar_version");
        $this->log("Instance flavor: $sugar_flavor");

        if (version_compare($sugar_version, '7.0', '>')) {
            $this->updateStatus("alreadyUpgraded");
            $this->log("Instance already upgraded to 7");
            return $this->logMeta;
        }

        if ($GLOBALS['sugar_config']['site_url']) {
            $this->ping(array("instance" => $GLOBALS['sugar_config']['site_url'], "version" => $sugar_version));
        }

        $this->listUpgrades();
        $this->checkPackages();
        $this->checkLanguageFiles();
        $this->checkVendorAndRemovedFiles();
        if (!empty($this->filesToFix)) {
            $files_to_fix = '';
            foreach ($this->filesToFix as $fileToFix) {
                $files_to_fix .= "{$fileToFix['file']} has the following vendor inclusions: " . PHP_EOL;
                foreach ($fileToFix['vendors'] as $vendor) {
                    $files_to_fix .= " '{$vendor['directory']}' found in line {$vendor['line']}" . PHP_EOL;
                }
            }
            $this->updateStatus("vendorFilesInclusion", $files_to_fix);
        }

        if (!empty($this->specificSugarFilesToFix)) {
            $specificFiles = '';
            foreach ($this->specificSugarFilesToFix as $fileToFix => $filesInfo) {
                $specificFiles .= "'$fileToFix' in: " . PHP_EOL;
                foreach ($filesInfo as $file => $info) {
                    $specificFiles .= " '$file' file in line {$info['line']}" . PHP_EOL;
                }
            }
            $this->updateStatus("sugarSpecificFilesInclusion", $specificFiles);
        }

        if (!empty($this->deletedFilesReferenced)) {
            $this->updateStatus("deletedFilesReferenced", $this->deletedFilesReferenced);
        }

        // check non-upgrade-safe customizations by verifying md5's
        /*
        $this->log("Comparing md5 sums");
        $skip_prefixes = "#^[.]/(custom/|cache/|tmp/|temp/|upload/|config|examples/|[.]htaccess|sugarcrm[.]log)#";
        $skip_files = array(
            './styleguide/less/bootstrap-mobile.less copy',
            './styleguide/less/bootstrap.less copy',
        );
        foreach ($this->md5_files as $file => $sum) {
            if (in_array($file, $skip_files)) {
                continue;
            }
            if (preg_match($skip_prefixes, $file)) {
                continue;
            }
            if (!file_exists($file)) {
                $this->updateStatus("missingFile", $file);
            }
            // TODO: uncomment when we decide to enable it once again in later releases (probably > 7.5.x). (See CRYS-455).
            /*
            if (md5_file($file) !== $sum) {
                $this->updateStatus("md5Mismatch", $file, $sum);
            }
            */
        /*
        }
        */

        foreach ($this->getModuleList() as $module) {
            $this->log("Checking module $module");
            $this->scanModule($module);
        }

        // Check global hooks
        $this->log("Checking global hooks");
        $hook_files = array();
        $this->extractHooks("custom/modules/logic_hooks.php", $hook_files, true);
        $this->extractHooks("custom/application/Ext/LogicHooks/logichooks.ext.php", $hook_files, true);
        foreach ($hook_files as $hookname => $hooks) {
            foreach ($hooks as $hook_data) {
                $this->log("Checking global hook $hookname:{$hook_data[1]}");
                $this->checkFileForOutput($hook_data[2], HealthCheckScannerMeta::CUSTOM);
            }
        }
        // TODO: custom dashlets
        $this->log("VERDICT: {$this->status}", 'STATUS');
        if ($GLOBALS['sugar_config']['site_url']) {
            $this->ping(array("instance" => $GLOBALS['sugar_config']['site_url'], "verdict" => $this->status));
        }

        ksort($this->status_log);
        foreach ($this->status_log as $status => $items) {
            $this->log("=> $status: " . count($items) . " total", 'BUCKET');
            foreach ($items as $item) {
                $this->log(sprintf("=> %s: %s", $status, $item['reason']), 'BUCKET');
            }
        }

        return $this->logMeta;
    }

    /**
     * Loads all language files with customizations and overrides
     *
     * @see CRYS-130
     */
    protected function checkLanguageFiles()
    {
        if (!empty($GLOBALS['sugar_config']['languages'])) {

            foreach ($GLOBALS['sugar_config']['languages'] as $key => $lang) {
                return_application_language($key);
            }
        }
    }

    /**
     * Checks for unsupported installed packages.
     */
    protected function checkPackages()
    {
        require_once 'ModuleInstall/PackageManager/PackageManager.php';

        $this->log("Checking packages");
        $pm = $this->getPackageManager();
        $packages = $pm->getinstalledPackages(array('module'));
        foreach ($packages as $pack) {
            if ($pack['enabled'] == 'DISABLED') {
                $this->log("Disabled package {$pack['name']} (version {$pack['version']}) detected");
                continue;
            }
            $this->log("Package {$pack['name']} (version {$pack['version']}) detected");
            if (array_key_exists($pack['name'], $this->packages)) {
                $incompatible = false;
                foreach ($this->packages[$pack['name']] as $req) {
                    if (empty($req['version'])) {
                        $incompatible = true;
                    } elseif ($req['version'] == '*' || version_compare($pack['version'], $req['version'], '<')) {
                        $incompatible = true;
                    }
                    if (!empty($req['author'])) {
                        $uh = new UpgradeHistory();
                        $uh->retrieve_by_string_fields(
                            array('name' => $pack['name'], 'version' => $pack['version']),
                            true,
                            false
                        );
                        $manifest = unserialize(base64_decode($uh->manifest));
                        $manifest = $manifest['manifest'];
                        $scp = strcasecmp($manifest['author'], $req['author']);
                        $incompatible = $incompatible && ($req['author'] == '*' || empty($scp));
                    }

                    if (!empty($req['path']) && is_dir($req['path']) &&
                        is_callable(array('SugarAutoLoader', 'addDirectory'))
                    ) {
                        SugarAutoLoader::addDirectory($req['path']);
                    }

                    if ($incompatible) {
                        break;
                    }
                }
                if ($incompatible) {
                    $this->updateStatus("incompatIntegration", $pack['name'], $pack['version']);
                }
            }
        }
    }

    /**
     * Check if $table_name property in bean match table parameter in module/vardefs.php
     * @param $module
     * @return bool
     */
    protected function checkTableName($module)
    {
        $object = $this->getObjectName($module);

        VardefManager::loadVardef($module, $object);
        if (empty($GLOBALS['dictionary'][$object]['table'])) {
            $this->log("Failed to load vardefs for $module:$object");
            return false;
        }

        $seed = BeanFactory::getBean($module);
        if (empty($seed)) {
            $this->log("Failed to instantiate bean for $module, not checking table");
            return false;
        }

        if ($GLOBALS['dictionary'][$object]['table'] !== $seed->getTableName()) {
            $this->updateStatus('badVardefsTableName', $module, $module);
        }
    }

    /**
     * Log upgrades registered for the instance
     */
    protected function listUpgrades()
    {
        $uh = new UpgradeHistory();
        $ulist = $uh->getList("SELECT * FROM {$uh->table_name} WHERE type='patch'");
        if (empty($ulist)) {
            return;
        }
        foreach ($ulist as $urecord) {
            $this->log("Detected patch: {$urecord->name} version {$urecord->version} status {$urecord->status}");
        }
    }

    /**
     * Dirs that are moved to vendor
     * @var array
     */
    protected $removed_directories = array(
        'include/HTMLPurifier',
        'include/HTTP_WebDAV_Server',
        'include/Pear',
        'include/Smarty',
        'XTemplate',
        'Zend',
        'include/lessphp',
        'log4php',
        'include/nusoap',
        'include/oauth2-php',
        'include/pclzip',
        'include/reCaptcha',
        'include/tcpdf',
        'include/ytree',
        'include/SugarSearchEngine/Elastic/Elastica',
    );
    /**
     * dirs or files that have been deleted
     * @var array
     */
    protected $removed_files = array(
        'include/Smarty/plugins/function.sugar_help.php',
    );

    /**
     * Specific files that should be excluded from SH include check
     * @var array
     */
    protected $specificSugarFiles = array(
        'include/Smarty/plugins/function.sugar_action_menu.php'
    );

    protected $excludedScanDirectories = array(
        'backup',
        'tmp',
        'temp',
    );
    protected $filesToFix = array();

    protected $specificSugarFilesToFix = array();

    /**
     * Dump Scanner issues to log and optional stdout
     */
    public function dumpMeta()
    {
        $this->log('*** START HEALTHCHECK ISSUES ***');
        foreach ($this->getLogMeta() as $key => $entry) {
            $issueNo = $key + 1;
            $this->log(
                " => {$entry['bucket']}: [Issue {$issueNo}][{$entry['flag_label']}][{$entry['report']}][{$entry['id']}][{$entry['title']}] {$entry['descr']}"
            );
        }
        $this->log('*** END HEALTHCHECK ISSUES ***');
    }

    protected $deletedFilesReferenced = array();

    /**
     * Searching line number of value
     * @param string $file File to search in
     * @param string $pattern Value to search
     * @param string optional $directory
     * @return array
     */
    protected function getLineNumberOfPattern($file, $pattern, $directory = '')
    {
        $foundInfo = array();

        $fileContentsLined = file($file);
        $pattern = "#$pattern#";
        $linesFound = preg_grep(preg_quote($pattern), $fileContentsLined);

        if (count($linesFound) > 0) {

            foreach ($linesFound as $linePosition => $lineContent) {
                $foundInfo['line'] = ((int)$linePosition + 1);
                $foundInfo['directory'] = $directory;
            }
        }
        return $foundInfo;
    }

    /**
     * This method checks for directories/files that have been moved/removed that are referenced
     * in custom code
     * @return bool
     */
    protected function checkVendorAndRemovedFiles()
    {
        $this->log("Checking for bad includes");
        $files = $this->getPhpFiles("custom/");
        foreach ($files as $name => $file) {
            // check for any occurrence of the directories and flag them
            $fileContents = file_get_contents($file);
            if (preg_match_all(
                "#(\b(include|require|require_once|include_once)\b[\s('\"]*(.*?);)#",
                $fileContents,
                $m
            )
            ) {
                $vendorFileFound = false;
                $includedVendors = array();
                foreach ($m[1] as $value) {
                    foreach ($this->removed_directories as $directory) {
                        if (preg_match(
                                "#(include|require|require_once|include_once)[\s('\"]*({$directory})#",
                                $value
                            ) > 0
                        ) {
                            foreach ($this->specificSugarFiles as $specificSugarFile) {
                                if (preg_match(
                                        "#(include|require|require_once|include_once)[\s('\"]*(\b{$specificSugarFile}\b)#",
                                        $value
                                    ) > 0
                                ) {
                                    if (empty($this->specificSugarFilesToFix[$specificSugarFile][$file])) {
                                        $fileInfo = $this->getLineNumberOfPattern($file, $value, $directory);
                                        if ($fileInfo) {
                                            $this->specificSugarFilesToFix[$specificSugarFile][$file] = $fileInfo;
                                        }
                                    }
                                    break 2;
                                }
                            }

                            $foundVendor = $this->getLineNumberOfPattern($file, $value, $directory);
                            if (!empty($foundVendor)) {
                                $vendorFileFound = true;
                                $includedVendors[] = $foundVendor;
                                break;
                            }
                        }
                    }
                }
                if ($vendorFileFound) {
                    $this->filesToFix[] = array(
                        'file' => $file,
                        'vendors' => $includedVendors
                    );
                }
            }
            foreach ($this->removed_files AS $deletedFile) {
                if (preg_match(
                        "#(include|require|require_once|include_once)[\s('\"]*({$deletedFile})#",
                        $fileContents
                    ) > 0
                ) {
                    $this->log("Found $deletedFile in $file");
                    $this->deletedFilesReferenced[] = $file;
                }
            }
        }
    }

    /**
     * Scan individual module
     * @param string $module
     * @return boolean Was it a real module?
     */
    protected function scanModule($module)
    {
        if (empty($this->beanList[$module])) {
            // absent from module list, not an actual module
            // TODO: we may still want to check for extensions here?
            // TODO: check for view defs for modules not in BeanList?
            $this->log("$module is not in Bean List, may be not a real module");
            return false;
        }

        if (in_array($module, $this->unsupportedModules)) {
            $this->updateStatus("incompatModule", $module);
            return;
        }
        // TODO: check if module table is OK
        if (!in_array($module, $this->excludeModules)) {
            $this->checkTableName($module);
        }

        if ($this->isNewModule($module)) {
            $this->updateStatus("notStockModule", $module);
            // not a stock module, check if it's working at least with BWC
            $this->checkMBModule($module);
        } else {
            $this->checkStockModule($module);
        }
    }

    /**
     * Get name of the object
     * @param string $module
     * @return string|null
     */
    protected function getObjectName($module)
    {
        if (!empty($this->objectList[$module])) {
            return $this->objectList[$module];
        }
        if (!empty($this->beanList[$module])) {
            return $this->beanList[$module];
        }
        return null;
    }

    /**
     * Do checks for ModuleBuilder modules
     * @param string $module
     */
    protected function checkMBModule($module)
    {
        if (!empty($this->newModules[$module])) {
            // we have a name clash
            $this->updateStatus("sameModuleName", $module);
        }

        // Check if ModuleBuilder module needs to be run as BWC
        // Checks from 6_ScanModules
        $bwc = false;
        if (!$this->isMBModule($module)) {
            $bwc = true;
            $this->updateStatus("toBeRunAsBWC", $module);
        } else {
            $this->log("$module is upgradeable MB module");
        }

        $objectName = $this->getObjectName($module);
        // check for subpanels since BWC subpanels can be used in non-BWC modules
        $defs = $this->getPhpFiles("modules/$module/metadata/subpanels");
        if (!empty($defs) && !empty($this->beanList[$module])) {
            foreach ($defs as $deffile) {
                $this->checkListFields($deffile, "subpanel_layout", 'list_fields', $module, $objectName);
            }
        }

        $defs = $this->getPhpFiles("custom/modules/$module/metadata/subpanels");
        if (!empty($defs) && !empty($this->beanList[$module])) {
            $this->log("$module has custom subpanels");
            foreach ($defs as $deffile) {
                $this->checkCustomCode($deffile, "subpanel_layout", "modules/$module/metadata/" . basename($deffile));
                $this->checkListFields($deffile, "subpanel_layout", 'list_fields', $module, $objectName);
            }
        }


        // check for output in logic hooks
        // if there is some, we'd need to put it to custom
        // since upgrader does not handle it, we have to manually BWC the module
        $this->checkHooks($module, HealthCheckScannerMeta::CUSTOM, $bwc);
    }

    /**
     * Check if stock module is a BWC module
     * @param string $module
     */
    protected function isStockBWCModule($module)
    {
        return isset($this->bwcModulesHash[$module]);
    }

    /**
     * Var names for various viewdefs
     * Isn't it fun that we use so many differen ones?
     * @var array
     */
    protected $vardefnames = array(
        'SearchFields.php' => 'searchFields',
        'dashletviewdefs.php' => 'dashletData',
        'listviewdefs.php' => 'listViewDefs',
        'popupdefs.php' => 'popupMeta',
        'searchdefs.php' => 'searchdefs',
        'subpaneldefs.php' => 'layout_defs',
        'wireless.subpaneldefs.php' => 'layout_defs',

    );

    /**
     * Check stock module for customizations not compatible with 7
     * @param string $module
     */
    protected function checkStockModule($module)
    {
        $bwc = $this->isStockBWCModule($module);

        $history = $this->getPhpFiles("custom/history/modules/$module");
        if (!empty($history)) {
            $this->updateStatus("hasStudioHistory", $module);
        }

        $objectName = $this->getObjectName($module);

        // check vardefs for HTML and bad names
        if (!$bwc && $objectName) {
            $this->checkVardefs($module, $objectName, true, HealthCheckScannerMeta::CUSTOM);
        }

        // Check for extension files
        $extfiles = $this->getPhpFiles("custom/Extension/modules/$module/Ext");
        if (!empty($extfiles)) {
            $this->updateStatus("hasExtensions", $module, $extfiles);
        }
        // skip check for output for bwc module
        if (!$bwc) {
            foreach ($extfiles as $phpfile) {
                $this->checkFileForOutput($phpfile, $bwc ? HealthCheckScannerMeta::CUSTOM : HealthCheckScannerMeta::MANUAL);
            }
        }

        // Check custom vardefs
        $defs = $this->getPhpFiles("custom/Extension/modules/$module/Ext/Vardefs");
        if (!empty($defs)) {
            $this->updateStatus("hasCustomVardefs", $module);
            foreach ($defs as $deffile) {
                $this->checkCustomCode($deffile, "dictionary", "modules/$module/vardefs.php");
            }
        }

        // check layout defs
        $defs = $this->getPhpFiles("custom/Extension/modules/$module/Ext/Layoutdefs");
        if (!empty($defs)) {
            $this->updateStatus("hasCustomLayoutdefs", $module);
            foreach ($defs as $deffile) {
                $this->checkCustomCode($deffile, "layout_defs", "modules/$module/metadata/subpaneldefs.php");
                $this->checkSubpanelLayoutDefs($module, $objectName, $deffile);
            }
        }

        // check custom viewdefs
        $defs = array_filter(
            $this->getPhpFiles("custom/modules/$module/metadata"),
            function ($def) {
                $filesToExclude = array(
                    'dashletviewdefs.php', // CRYS-424 - exclude dashletviewdefs.php
                    'quickcreatedefs.php', // CRYS-426 - exclude quickcreatedefs.php
                    'wireless.editviewdefs.php',
                    'wireless.detailviewdefs.php',
                    'wireless.listviewdefs.php',
                    'convertdefs.php',     // CRYS-536 - exclude */Leads/metadata/convertdefs.php
                );
                return !in_array(basename($def), $filesToExclude);
            }
        );

        if ($module == "Connectors") {
            $pos = array_search("custom/modules/Connectors/metadata/connectors.php", $defs);
            if ($pos !== false) {
                unset($defs[$pos]);
                // TODO: any checks for connectors.php?
            }
            $pos = array_search("custom/modules/Connectors/metadata/display_config.php", $defs);
            if ($pos !== false) {
                unset($defs[$pos]);
                // TODO: any checks for display_config.php?
            }
        }

        // check viewdefs
        if (!empty($defs)) {
            $this->updateStatus("hasCustomViewdefs", $module);
            foreach ($defs as $deffile) {
                if (strpos($deffile, "/subpanels/") !== false) {
                    // special case for subpanels, since subpanels are special
                    $base = basename(dirname($deffile)) . "/" . basename($deffile);
                    $defsname = 'subpanel_layout';
                } else {
                    $base = basename($deffile);
                    if (!empty($this->vardefnames[$base])) {
                        $defsname = $this->vardefnames[$base];
                    } else {
                        $defsname = "viewdefs";
                    }
                }
                if (!$bwc) {
                    $this->checkCustomCode($deffile, $defsname, "modules/$module/metadata/$base", $history);
                }
                // For stock modules, check subpanels and also list views for non-bwc modules
                if ($defsname == 'subpanel_layout') {
                    // checking also BWC since Sugar 7 module can have subpanel for BWC module
                    $this->checkListFields($deffile, $defsname, 'list_fields', $module, $objectName);
                }
            }
        }

        if (!$bwc) {
            // check for custom views
            $defs = array_filter(
                $this->getPhpFiles("custom/modules/$module/views"),
                function ($def) {
                    // ENGRD-248 - exclude view.sidequickcreate.php
                    return basename($def) != 'view.sidequickcreate.php';
                }
            );
            if (!empty($defs)) {
                $this->updateStatus("hasCustomViews", $module, $defs);
            }
            $md5 = $this->md5_files; // work around 5.3 missing $this in closures
            $defs = array_filter(
                $this->getPhpFiles("modules/$module/views"),
                function ($def) use ($md5) {
                    // ENGRD-248 - exclude view.sidequickcreate.php
                    return basename($def) != 'view.sidequickcreate.php' && !isset($md5["./" . $def]);
                }
            );
            if (!empty($defs)) {
                $this->updateStatus("hasCustomViewsModDir", $module, $defs);
            }
        }

        // Check custom extensions which aren't Studio
        $badExts = array(
            "ActionViewMap",
            "ActionFileMap",
            "ActionReMap",
            "EntryPointRegistry",
            "FileAccessControlMap",
            "WirelessModuleRegistry",
            "JSGroupings"
        );
        $badExts = array_flip($badExts);
        foreach ($this->glob("custom/modules/$module/Ext/*") as $extdir) {
            if (isset($badExts[basename($extdir)])) {
                $extfiles = glob("$extdir/*");
                foreach ($extfiles as $k => $file) {
                    if ($this->isEmptyFile($file)) {
                        unset($extfiles[$k]);
                    }
                }
                if (!empty($extfiles)) {
                    $this->updateStatus("extensionDir", $extdir);
                }
            }
        }

        // check logic hooks for module
        $this->checkHooks($module, $bwc ? HealthCheckScannerMeta::CUSTOM : HealthCheckScannerMeta::MANUAL, $bwc);
    }

    /**
     * Make sure glob always returns array
     *
     * @param $pattern
     * @return array
     */
    protected function glob($pattern)
    {
        $dirs = glob($pattern);
        return ($dirs ? $dirs : array());
    }

    /**
     * Types that are BLOBs in the DB
     * @var array
     */
    protected $blob_types = array('text', 'longtext', 'multienum', 'html', 'blob', 'longblob');

    /**
     * Check if any original vardef changed type
     * @param string $module
     * @param string $object
     */
    protected function checkVardefTypeChange($module, $object)
    {
        if (!file_exists("modules/$module/vardefs.php")) {
            // can't find original vardefs, don't mess with it
            return;
        }
        $full_vardefs = $GLOBALS['dictionary'][$object];
        unset($GLOBALS['dictionary'][$object]);
        global $dictionary;
        include "modules/$module/vardefs.php";
        // load only original vardefs
        if (!empty($GLOBALS['dictionary'][$object])) {
            $original_vardefs = $GLOBALS['dictionary'][$object];
        } else {
            return;
        }
        // return vardefs back to old state
        $GLOBALS['dictionary'][$object] = $full_vardefs;
        $original_vardefs['fields'] = (is_array($original_vardefs['fields'])) ? $original_vardefs['fields'] : array();
        foreach ($original_vardefs['fields'] as $name => $def) {
            if (empty($def['type']) || empty($def['name'])) {
                continue;
            }
            if (!empty($def['source']) && $def['source'] != 'db') {
                continue;
            }
            $real_type = $this->db->getFieldType($full_vardefs['fields'][$name]);
            $original_type = $this->db->getFieldType($def);
            if (empty($real_type)) {
                // If we can't find the type, this is some serious breakage
                $this->updateStatus("fieldTypeMissing", $module, $name);
                continue;
            }
            if (!in_array($real_type, $this->blob_types)) {
                // Per ENGRD-263, we are only interested in changes to blob type
                continue;
            }
            if (!in_array($original_type, $this->blob_types)) {
                // We have changed from non-blob type to blob type, not good
                $this->updateStatus("typeChange", $module, $name, $original_type, $real_type);
            }
        }
    }

    /**
     * Load definition of certain var from file
     * @param string $deffile
     * @param string $varname
     * @return array
     */
    protected function loadFromFile($deffile, $varname)
    {
        if (!file_exists($deffile)) {
            return array();
        }
        $l = new FileLoaderWrapper();
        $res = $l->loadFile($deffile, $varname);
        if (is_null($res)) {
            $this->log("Weird, loaded $deffile but no $varname there");
            return array();
        }
        if ($res === false) {
            $this->updateStatus("thisUsage", $deffile);
        }
        return $res;
    }

    /**
     * Look for custom code in array of defs
     * @param array $path path through the defs so far
     * @param array $defs Defs to be checked
     */
    protected function lookupCustomCode($path, $defs, $codes)
    {
        foreach ($defs as $key => $value) {
            if ($key === 'customCode' && !empty($value)) {
                $codes[$value][] = $path;
            } elseif (is_array($value)) {
                $codes = $this->lookupCustomCode($path . $key . ':', $value, $codes);
            }
        }
        return $codes;
    }

    /**
     * Check defs for customCode entries
     * @param string $deffile Filename for definitions file
     * @param string $varname Variable to get defs from
     * @param string $original Original defs file
     * @param array $history Studio history files
     */
    protected function checkCustomCode($deffile, $varname, $original, $history = array())
    {
        $this->log("Checking $deffile for custom code");
        $defs = $this->loadFromFile($deffile, $varname);
        if (empty($defs)) {
            return;
        }

        $origdefs = $this->loadFromFile($original, $varname);

        $defs_code = $this->lookupCustomCode('', $defs, array());
        $orig_code = $this->lookupCustomCode('', $origdefs, array());
        $foundCustomCode = array();
        foreach ($defs_code as $code => $places) {
            if (!isset($orig_code[$code])) {
                $foundCustomCode[$code] = $places;
            }
        }

        // We found something, do more precise check through all available history
        if (!empty($foundCustomCode) && !empty($history)) {

            $historyFiles = array_filter(
                $history,
                function ($fileName) use ($deffile) {
                    return (strpos(basename($fileName), basename($deffile, '.php')) !== false);
                }
            );

            $allHistoryCode = array();
            foreach ($historyFiles as $file) {
                //for history files check internal functions and replace them with random names CRYS-498
                $tmpName = tempnam(sys_get_temp_dir(), $file);
                if ($tmpName && is_writable($tmpName) && file_exists($file)) {
                    $tmpContents = file_get_contents($file);
                    $matches = array();
                    if (preg_match_all('/function\s+(\w+)\s*\(/', $tmpContents, $matches) && isset($matches[1])) {

                        $tmpContents = str_replace($matches[1], array_map(function ($value) use ($tmpName) {
                            return $value . md5($tmpName);
                        }, $matches[1]), $tmpContents);

                        if (file_put_contents($tmpName, $tmpContents)) {
                            $file = $tmpName;
                        }
                    }
                }

                $historyDefs = $this->loadFromFile($file, $varname);

                if ($tmpName) {
                    @unlink($tmpName);
                }

                $historyCode = $this->lookupCustomCode('', $historyDefs, array());
                $allHistoryCode = array_merge($allHistoryCode, $historyCode);
            }

            $foundCustomCode = array_diff_key($foundCustomCode, $allHistoryCode);
        }

        // finally output status, if there is any
        foreach ($foundCustomCode as $code => $places) {
            $this->updateStatus("foundCustomCode", $code, $places, $deffile);
        }
    }

    /**
     * Check if the link name is valid
     * @param string $module
     * @param string $object
     * @param string $link Link name
     * @return boolean
     */
    protected function isValidLink($module, $object, $link)
    {
        if (empty($GLOBALS['dictionary'][$object]['fields'])) {
            VardefManager::loadVardef($module, $object);
        }
        if (empty($GLOBALS['dictionary'][$object]['fields'])) {
            // weird, we could not load vardefs for this link
            $this->log("Failed to load vardefs for $module:$object");
            return false;
        }
        if (empty($GLOBALS['dictionary'][$object]['fields'][$link]) ||
            empty($GLOBALS['dictionary'][$object]['fields'][$link]['type']) ||
            $GLOBALS['dictionary'][$object]['fields'][$link]['type'] != 'link'
        ) {
            return false;
        }
        return true;
    }

    /**
     * Check subpanel defs
     * @param string $module Module for subpanel
     * @param string $deffile Filename for definitions file
     */
    protected function checkSubpanelLayoutDefs($module, $object, $deffile)
    {
        $layoutDefs = $this->loadFromFile($deffile, 'layout_defs');
        // get defs regardless of the module_name since it can be plural or singular, but we don't care here
        if (!$layoutDefs) {
            return;
        }
        $defs = $layoutDefs[key($layoutDefs)];
        if (empty($defs['subpanel_setup'])) {
            return;
        }
        $this->log("Checking subpanel file $deffile");
        // check 'get_subpanel_data' contains not applicable in Sidecar 'function:...' value
        foreach ($defs['subpanel_setup'] as $panel) {
            if (!empty($panel['module']) && ($panel['module'] == 'Activities' || $panel['module'] == 'History')
                && isset($panel['collection_list'])
            ) {
                // skip activities/history, upgrader will take care of them
                continue;
            }

            // check subpanel module. This param should refer to existing module
            if (!empty($panel['module']) && empty($this->beanList[$panel['module']])) {
                $this->updateStatus("subpanelLinkNonExistModule", $panel['module']);
            }

            if (!empty($panel['get_subpanel_data']) && strpos($panel['get_subpanel_data'], 'function:') !== false) {
                $this->updateStatus("subPanelWithFunction", $deffile);
            }
            if (!empty($panel['get_subpanel_data']) && !$this->isValidLink(
                    $module,
                    $object,
                    $panel['get_subpanel_data']
                )
            ) {
                $this->updateStatus("badSubpanelLink", $panel['get_subpanel_data'], $deffile);
            }
        }
    }

    protected $knownWidgetClasses = array(
        'SubPanelDetailViewLink',
        'SubPanelEmailLink',
        'SubPanelEditButton',
        'SubPanelRemoveButton',
        'SubPanelIcon',
        'SubPanelDeleteButton',
    );

    /**
     * Check list view type metadata for bad fields
     * @param string $deffile Filename for definitions file
     * @param string $varname Variable to get defs from
     * @param string $subvarname Section in defs where list fields are stored
     * @param string $module Module name
     * @param string $object Object name
     * @param string $status Status to set if something is wrong
     */
    protected function checkListFields($deffile, $varname, $subvarname, $module, $object)
    {
        if (!$object) {
            return true;
        }

        $this->log("Checking $deffile for bad list fields");

        if (empty($GLOBALS['dictionary'][$object])) {
            VardefManager::loadVardef($module, $object);
        }

        if (empty($GLOBALS['dictionary'][$object]['fields'])) {
            // weird module, no fields, skip
            return true;
        }
        $vardefs = $GLOBALS['dictionary'][$object]['fields'];

        $defs = $this->loadFromFile($deffile, $varname);
        if (empty($defs)) {
            return true;
        }
        if ($subvarname) {
            if (empty($defs[$subvarname])) {
                return true;
            }
            $defs = $defs[$subvarname];
        }
        foreach ($defs as $key => $data) {
            if (!empty($data['usage'])) {
                // it's a query field, skip it, converter will take care of them
                continue;
            }
            $key = strtolower($key);
            if (!empty($data['widget_class']) && !in_array($data['widget_class'], $this->knownWidgetClasses)) {
                if (!file_exists("include/generic/SugarWidgets/SugarWidget{$data['widget_class']}.php")) {
                    $this->updateStatus("unknownWidgetClass", $data['widget_class'], $key, $module, $deffile);
                }
            }
            // Unknown fields handled by CRYS-36, so no more checks here
        }
    }

    /**
     * Check logic hooks for module
     * @param string $module
     * @param string $status
     * @param bool $bwc
     */
    protected function checkHooks($module, $status = HealthCheckScannerMeta::MANUAL, $bwc = false)
    {
        $this->log("Checking hooks for $module");
        $hook_files = array();
        $this->extractHooks("custom/modules/$module/logic_hooks.php", $hook_files);
        $this->extractHooks("custom/modules/$module/Ext/LogicHooks/logichooks.ext.php", $hook_files);

        foreach ($hook_files as $hookname => $hooks) {
            foreach ($hooks as $hook_data) {
                $hookDescription = (!empty($hook_data[1])) ? $hook_data[1] : '';
                $this->log("Checking module hook $hookname: $hookDescription");
                if (empty($hook_data[2])) {
                    $this->updateStatus("badHookFile", $hookname, '');
                } elseif (!$bwc) {
                    $this->checkFileForOutput($hook_data[2], $status);
                }
            }
        }
    }

    /**
     * Get list of existing modules
     * @return array
     */
    protected function getModuleList()
    {
        $beanList = $beanFiles = $objectList = array();
        require 'include/modules.php';
        $this->beanList = $beanList;
        $this->beanFiles = $beanFiles;
        $this->objectList = $objectList;

        $this->setupHealthCheckModule();

        return array_map(
            function ($m) {
                return substr($m, 8); /* cut off modules/ */
            },
            glob("modules/*", GLOB_ONLYDIR)
        );
    }


    /**
     * Make scanner ignore health check module
     */
    public function setupHealthCheckModule()
    {
        $this->beanList['HealthCheck'] = $this->healthCheckModule['bean'];
        $this->beanFiles['HealthCheck'] = $this->healthCheckModule['file'];
        $this->md5_files[$this->healthCheckModule['md5']] = md5('HealthCheck');
    }

    /**
     * Initialize instance environment
     * @return bool False means this instance is messed up
     */
    protected function init()
    {
        $this->db = DBManagerFactory::getInstance();

        $md5_string = array();
        if (!file_exists('files.md5')) {
            return $this->fail("files.md5 not found");
        }

        require 'files.md5';
        $this->md5_files = $md5_string;
        $this->bwcModulesHash = array_flip($this->bwcModules);
        return true;
    }

    /**
     * Is $module a new module or standard Sugar module?
     * @param string $module
     * @return boolean $module is new?
     */
    protected function isNewModule($module)
    {
        $object = $this->beanList[$module];
        if (empty($this->beanFiles[$object])) {
            // no bean file - check directly
            foreach ($this->glob("modules/$module/*") as $file) {
                // if any file from this dir mentioned in md5 - not a new module
                if (!empty($this->md5_files["./$file"])) {
                    return false;
                }
            }
            return true;
        }

        if (empty($this->md5_files["./" . $this->beanFiles[$object]])) {
            // no mention of the bean in files.md5 - new module
            return true;
        }

        return false;
    }

    public function getResultCode()
    {
        if ($this->exit_status == self::FAIL) {
            return self::FAIL;
        }
        return ord($this->status) - ord(HealthCheckScannerMeta::VANILLA);
    }

    /**
     * Scan directory and build the list of PHP files it contains
     * @param string $path
     * @return array Files data
     */
    protected function getPhpFiles($path)
    {
        $data = array();
        if (!is_dir($path)) {
            return array();
        }
        $path = rtrim($path, "/") . "/";
        $iter = new DirectoryIterator("./" . $path);
        foreach ($iter as $item) {
            if ($item->isDot()) {
                continue;
            }

            $filename = $item->getFilename();
            if (strpos($filename, ".suback.php") !== false || strpos($filename, "_backup") !== false) {
                // we'll ignore .suback files, they are old upgrade backups
                continue;
            }

            $extension = $item->getExtension();
            if ($item->isDir() && in_array($filename, $this->excludedScanDirectories)) {
                continue;
            } elseif ($item->isDir()) {
                if (strtolower($filename) == 'disable' || strtolower($filename) == 'disabled') {
                    // skip disable dirs
                    continue;
                }
                $data = array_merge($data, $this->getPhpFiles($path . $filename . "/"));
            } elseif (!preg_match('/php(_\d+)?\b/', $extension)) {
                // we need only php and php Studio-history (.php_{timestamp} extension) files
                continue;
            } elseif (!in_array($path . $filename, $this->ignoredFiles)) {
                $data[] = $path . $filename;
            }
        }

        return $data;
    }

    /**
     * Extract hook filenames from logic hook file and put them into hook files list
     * @param string $hookfile
     * @param array &$hooks_array
     * @param bool $detectAfterUiHooks should we log after_ui_footer & after_ui_frame hooks if they are present in file
     */
    protected function extractHooks($hookfile, &$hooks_array, $detectAfterUiHooks = false)
    {
        $hook_array = array();
        if (!is_readable($hookfile)) {
            return;
        }
        ob_start();
        include $hookfile;
        ob_end_clean();
        if (empty($hook_array)) {
            return;
        }
        if ($detectAfterUiHooks && !empty($hook_array['after_ui_footer'])) {
            $this->updateStatus("logicHookAfterUIFooter", $hookfile);
        }
        if ($detectAfterUiHooks && !empty($hook_array['after_ui_frame'])) {
            $this->updateStatus("logicHookAfterUIFrame", $hookfile);
        }
        foreach ($hook_array as $hooks) {
            foreach ($hooks as $hook) {
                $hookFileLocation = (!empty($hook[2])) ? $hook[2] : '';
                if (!file_exists($hookFileLocation)) {
                    // putting it as custom since LogicHook checks file_exists
                    $this->updateStatus("badHookFile", $hookfile, $hookFileLocation);
                }
            }
        }
        $hooks_array = array_merge($hooks_array, $hook_array);
    }

    /**
     * Check PHP file for output constructs.
     * Set $status if it happens.
     * @param string $phpfile
     * @param string $status
     */
    protected function checkFileForOutput($phpfile, $status)
    {
        if (!file_exists($phpfile)) {
            $this->updateStatus("missingCustomFile", $phpfile);
            return;
        }
        $contents = file_get_contents($phpfile);
        if (!empty($this->md5_files["./" . $phpfile]) && $this->md5_files["./" . $phpfile] === md5($contents)) {
            // this is our file, no need to check
            return;
        }
        $processOutput = !in_array($phpfile, $this->ignoreOutputCheckFiles);

        // remove sugarEntry check
        $sePattern = <<<ENDP
if\s*\(\s*!\s*defined\s*\(\s*'sugarEntry'\s*\)\s*(\|\|\s*!\s*sugarEntry\s*)?\)\s*{?\s*die\s*\(\s*'Not A Valid Entry Point'\s*\)\s*;\s*}?
ENDP;
        $contents = preg_replace("#$sePattern#i", '', $contents);

        $tokens = token_get_all($contents);
        $tokens = array_filter($tokens, array($this, 'ignoreWhitespace'));
        $tokens = array_values($tokens);
        foreach ($tokens as $index => $token) {
            if (is_array($token)) {
                if ($token[0] == T_INLINE_HTML) {
                    $inlineHTMLStatus = (strlen(trim($token[1])) != 0) ? 'inlineHtml' : 'inlineHtmlSpacing';
                    $args = array($inlineHTMLStatus, $phpfile, $token[2]);
                } elseif ($processOutput && $token[0] == T_ECHO) {
                    $args = array('foundEcho', $phpfile, $token[2]);
                } elseif ($processOutput && $token[0] == T_PRINT) {
                    $args = array('foundPrint', $phpfile, $token[2]);
                } elseif ($token[0] == T_EXIT) {
                    $args = array('foundDieExit', $phpfile, $token[2]);
                } elseif ($processOutput && $token[0] == T_STRING && $token[1] == 'print_r' && $this->checkPrintR($index, $tokens)) {
                    $args = array('foundPrintR', $phpfile, $token[2]);
                } elseif ($processOutput && $token[0] == T_STRING && $token[1] == 'var_dump') {
                    $args = array('foundVarDump', $phpfile, $token[2]);
                } elseif ($token[0] == T_STRING && strpos($token[1], 'ob_') === 0) {
                    $args = array('inlineHtml', $token[1], $phpfile, $token[2]);
                } else {
                    continue;
                }
                call_user_func_array(array($this, 'updateStatus'), $args);
            }
        }
    }

    /**
     * Returns false if $item is T_WHITESPACE token.
     * @see \HealthCheckScanner::checkFileForOutput
     * @param $item
     * @return bool
     */
    protected function ignoreWhitespace($item)
    {
        return !(is_array($item) && $item[0] == T_WHITESPACE);
    }

    /**
     * Checking PHP file content and returning true if there was no code found.
     * 
     * @param string $file path to file
     * @return bool is file empty or not
     */
    protected function isEmptyFile($file)
    {
        $content = file_get_contents($file);
        if (empty($content)) {
            return true;
        }
        $tokens = token_get_all($content);
        foreach ($tokens as $token) {
            switch ($token[0]) {
                case T_CLOSE_TAG :
                case T_COMMENT :
                case T_DOC_COMMENT :
                case T_OPEN_TAG :
                case T_WHITESPACE :
                    break;
                default :
                    return false;
            }
        }
        return true;
    }

    /**
     * Checks if print_r has the second parameter as 'true', according to:
     * When this parameter is set to TRUE, print_r() will return the information rather than print it.
     * We cannot check if the second parameter is actually true
     * in cases when the second parameter is a variable i.e. print_r($foo, $bar).
     * We blindly assume that if second parameter is passed then it is true.
     * Continue to scan, if has.
     * @param $index int index to start traversing $tokens at
     * @param $tokens array of tokens from token_get_all
     * @return bool
     */
    protected function checkPrintR($index, $tokens)
    {
        $curlyBracketsCount = 0;
        $found = false;
        $count = count($tokens);
        for ($i = $index + 1; $i < $count; $i++) {
            if ($tokens[$i] === '(') {
                $curlyBracketsCount += 1;
            } else {
                if ($tokens[$i] === ')') {
                    if ($curlyBracketsCount === 1 && !$found) {
                        return true;
                    }
                    $curlyBracketsCount -= 1;
                } else {
                    if ($tokens[$i] === ',' && $curlyBracketsCount === 1) {
                        $next = $tokens[$i + 1];
                        return (is_array($next) && $next[1] === 'false');
                    }
                }
            }
        }
        return false;
    }


    /**
     * PHP error handler, to log PHP errors
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param string $errline
     * @param array $errcontext
     */
    public function scriptErrorHandler($errno, $errstr, $errfile, $errline, $errcontext)
    {
        // error was suppressed with the @-operator
        if (error_reporting() === 0) {
            return false;
        }
        switch ($errno) {
            case 1:     $e_type = 'E_ERROR'; break;
            case 2:     $e_type = 'E_WARNING'; break;
            case 4:     $e_type = 'E_PARSE'; break;
            case 8:     $e_type = 'E_NOTICE'; break;
            case 16:    $e_type = 'E_CORE_ERROR'; break;
            case 32:    $e_type = 'E_CORE_WARNING'; break;
            case 64:    $e_type = 'E_COMPILE_ERROR'; break;
            case 128:   $e_type = 'E_COMPILE_WARNING'; break;
            case 256:   $e_type = 'E_USER_ERROR'; break;
            case 512:   $e_type = 'E_USER_WARNING'; break;
            case 1024:  $e_type = 'E_USER_NOTICE'; break;
            case 2048:  $e_type = 'E_STRICT'; break;
            case 4096:  $e_type = 'E_RECOVERABLE_ERROR'; break;
            case 8192:  $e_type = 'E_DEPRECATED'; break;
            case 16384: $e_type = 'E_USER_DEPRECATED'; break;
            case 30719: $e_type = 'E_ALL'; break;
            default:    $e_type = 'E_UNKNOWN'; break;
        }
        $this->updateStatus("phpError", $e_type, $errstr, $errfile, $errline);
    }

    public $names = array(
        'Gryffindor',
        'Hufflepuff',
        'Ravenclaw',
        'Slytherin',
        'Death Eater',
        'Voldemort',
        'Dumbledore'
    );

    /* Copypaste from 6_ScanModules */

    /**
     * Is this a pure ModuleBuilder module?
     * @param string $module_dir
     * @return boolean
     */
    protected function isMBModule($module_name)
    {
        $module_dir = "modules/$module_name";
        if (empty($this->beanList[$module_name])) {
            // if this is not a deployed one, don't bother
            return false;
        }
        $bean = $this->beanList[$module_name];
        if (empty($this->beanFiles[$bean])) {
            return false;
        }

        // bad vardefs means no conversion to Sugar 7
        $this->checkVardefs($module_name, $bean, false, HealthCheckScannerMeta::STUDIO_MB_BWC);

        $mbFiles = array("Dashlets", "Menu.php", "language", "metadata", "vardefs.php", "clients", "workflow");
        $mbFiles[] = basename($this->beanFiles[$bean]);
        $mbFiles[] = pathinfo($this->beanFiles[$bean], PATHINFO_FILENAME) . "_sugar.php";

        // to make checks faster
        $mbFiles = array_flip($mbFiles);

        $hook_files = array();
        $this->extractHooks("custom/$module_dir/logic_hooks.php", $hook_files);
        $this->extractHooks("custom/$module_dir/Ext/LogicHooks/logichooks.ext.php", $hook_files);
        $hook_files_list = array();
        foreach ($hook_files as $hookname => $hooks) {
            foreach ($hooks as $hook_data) {
                if (empty($hook_data[2])) {
                    $this->updateStatus("badHookFile", $hookname, '');
                } else {
                    $hook_files_list[] = $hook_data[2];
                }
            }
        }
        $hook_files = array_unique($hook_files_list);

        $unknownMBModuleFiles = array();
        // For now, the check is just checking if we have any files
        // in the directory that we do not recognize. If we do, we
        // put the module in BC.
        foreach ($this->glob("$module_dir/*") as $file) {
            if (in_array($file, $hook_files)) {
                // logic hook files are OK
                continue;
            }
            if (basename($file) == "views") {
                // check views separately because of file template that has view.edit.php
                if (!$this->checkViewsDir("$module_dir/views")) {
                    $this->updateStatus("unknownFileViews", $module_name);
                    return false;
                } else {
                    continue;
                }
            }
            if (basename($file) == 'Forms.php') {
                if (filesize($file) > 0) {
                    $this->updateStatus("nonEmptyFormFile", $file, $module_name);
                    return false;
                }
                continue;
            }
            if (!isset($mbFiles[basename($file)])) {
                // unknown file, not MB module
                if (count($unknownMBModuleFiles) > $this->numberOfFilesToReport) {
                    break;
                }
                $unknownMBModuleFiles[] = $file;
            }
        }
        // files that are OK for custom:
        $mbFiles['Ext'] = true;
        $mbFiles['logic_hooks.php'] = true;

        // now check custom/ for unknown files
        foreach ($this->glob("custom/$module_dir/*") as $file) {
            if (in_array($file, $hook_files)) {
                // logic hook files are OK
                continue;
            }
            if (!isset($mbFiles[basename($file)])) {
                // unknown file, not MB module
                if (count($unknownMBModuleFiles) > $this->numberOfFilesToReport) {
                    break;
                }
                $unknownMBModuleFiles[] = $file;
            }
        }

        if (!empty($unknownMBModuleFiles)) {
            $filesToReport = array_slice($unknownMBModuleFiles, 0, $this->numberOfFilesToReport);
            $moreMessage = (count($unknownMBModuleFiles) > $this->numberOfFilesToReport) ? PHP_EOL . 'and there are more...' : '';
            $this->updateStatus("isNotMBModule", $filesToReport, $moreMessage, $module_name);
            return false;
        }

        $badExts = array(
            "ActionViewMap",
            "ActionFileMap",
            "ActionReMap",
            "EntryPointRegistry",
            "FileAccessControlMap",
            "WirelessModuleRegistry"
        );
        $badExts = array_flip($badExts);
        // Check Ext for any "dangerous" extensions
        $return = true;
        foreach ($this->glob("custom/$module_dir/Ext/*") as $extdir) {
            if (isset($badExts[basename($extdir)])) {
                $extfiles = glob("$extdir/*");
                foreach ($extfiles as $k => $file) {
                    if ($this->isEmptyFile($file)) {
                        unset($extfiles[$k]);
                    }
                }
                if (!empty($extfiles)) {
                    $this->updateStatus("extensionDirDetected", $extdir, $module_name);
                    $return = false;
                }
            }
        }

        return $return;
    }

    /**
     * Check if views dir was created by file template
     * @param string $view_dir
     * @param string $status Status to assign if check fails
     * @return boolean
     */
    protected function checkViewsDir($view_dir)
    {
        foreach ($this->glob("$view_dir/*") as $file) {
            // for now we allow only view.edit.php
            if (basename($file) != 'view.edit.php') {
                $this->updateStatus("unknownFile", $view_dir, $file);
                return false;
            }
            $data = file_get_contents($file);
            // start with first {
            $data = substr($data, strpos($data, '{'));
            // drop function names
            $data = preg_replace('/function\s[<>_\w]+/', '', $data);
            // drop whitespace
            $data = preg_replace('/\s+/', '', $data);
            /* File data is:
             * {(){parent::ViewEdit();}(){if(isset($this->bean->id)){$this->ss->assign("FILE_OR_HIDDEN","hidden");if(empty($_REQUEST['isDuplicate'])||$_REQUEST['isDuplicate']=='false'){$this->ss->assign("DISABLED","disabled");}}else{$this->ss->assign("FILE_OR_HIDDEN","file");}parent::display();}}?>
            * md5 is: c8251f6b50e3e814135c936f6b5292eb
            */
            if (md5($data) !== 'c8251f6b50e3e814135c936f6b5292eb') {
                $this->updateStatus("badMd5", $file);
                return false;
            }
        }
        return true;
    }

    /**
     * List of modules with messed-up vardefs
     * For our eternal shame, these vardefs are broken in existing installs
     * Only non-BWC modules here, since BWC ones aren't checked for vardefs
     * @var array
     */
    protected $bad_vardefs = array(
        'Forecasts' => array('closed_count'),
        'ForecastOpportunities' => array('description'),
        'Quotas' => array('assigned_user_id'),
        'ProductTemplates' => array('assigned_user_link'),
    );

    /**
     * Check that all fields in array exist
     * @param string $key Origin field
     * @param array $fields List of fields to check
     * @param array $fieldDefs Vardefs
     * @param array $status Status array to store errors
     * @param string $module Module name
     */
    protected function checkFields($key, $fields, $fieldDefs, $custom = '', $module)
    {
        foreach ($fields as $subField) {
            if (empty($fieldDefs[$subField])) {
                $this->updateStatus('badVardefsSubfields' . $custom, $key, $subField, $module);
            }
        }
    }

    /**
     * @var array List of fields that can use html function in vardefs.
     * These fields are allowed to use in stock and non-stock modules.
     */
    protected $templateFields = array(
        "email" => true,
        "email1" => true,
        "email2" => true,
        "currency_id" => true,
        "currency_name" => true,
        "currency_symbol" => true
    );

    /**
     * Check vardefs for module
     * @param string $module
     * @param string $object
     * @param bool $stock Is this a stock module?
     * @return boolean|array true if vardefs OK, list of reasons if module needs to be BWCed
     */
    protected function checkVardefs($module, $object, $stock = false, $status = HealthCheckScannerMeta::STUDIO_MB_BWC)
    {
        $custom = '';
        if ($status == HealthCheckScannerMeta::CUSTOM) {
            $custom = 'Custom';
        }

        if ($module == 'DynamicFields') {
            // this one is an odd one
            return true;
        }
        $this->log("Checking vardefs for $module");
        VardefManager::loadVardef($module, $object);
        if (empty($GLOBALS['dictionary'][$object]['fields'])) {
            $this->log("Failed to load vardefs for $module:$object");
            return true;
        }
        $seed = BeanFactory::getBean($module);
        if (empty($seed)) {
            $this->log("Failed to instantiate bean for $module, not checking vardefs");
            return true;
        }

        $fieldDefs = $GLOBALS['dictionary'][$object]['fields'];

        // get names of 'stock' fields, that are defined in original vardefs.php
        $stockFields = $this->loadFromFile("modules/$module/vardefs.php", 'dictionary');
        $stockFields = (!empty($stockFields[$seed->object_name]) && is_array($stockFields[$seed->object_name]['fields'])) ?
            array_keys($stockFields[$seed->object_name]['fields']) : array();

        foreach ($fieldDefs as $key => $value) {
            if (!empty($this->bad_vardefs[$module]) && in_array($key, $this->bad_vardefs[$module])) {
                continue;
            }
            if (empty($value['name']) || $key != $value['name']) {
                $nameValue = (!empty($value['name'])) ? $value['name'] : '';
                $this->updateStatus("badVardefsKey", $key, $nameValue, $module);
                continue;
            }


            // Check "name" field type, @see CRYS-130
            if ($key == 'name' && $value['type'] != 'name') {

                // Assume those types are valid, cause they used in stock modules
                $validNameTypes = array('id', 'fullname', 'varchar');
                if (!in_array($value['type'], $validNameTypes)) {
                    $this->updateStatus('badVardefsName', $value['type'], $module);
                    continue;
                }
            }

            if ($key == 'team_name') {
                if (empty($value['module'])) {
                    $this->updateStatus("badVardefsRelate", $key, $module);
                }
                // this field is really weird, let's leave it alone for now
                continue;
            }

            if (!empty($value['function']['returns']) &&    // there is function in vardefs
                $value['function']['returns'] == 'html' &&  // that returns html
                !isset($this->templateFields[$key]) &&      // and field isn't in white-list
                (!$stock || !in_array(
                        $key,
                        $stockFields
                    ))  // and it is non-stock module or it is stock module but field is non-stock
            ) {
                $this->updateStatus("vardefHtmlFunctionName" . $custom, $value['function']['name'], $module, $key);
            }

            if (!empty($value['type'])) {
                switch ($value['type']) {
                    case 'date' :
                    case 'datetime' :
                    case 'time' :
                        if (!empty($value['display_default']) && preg_match('/^\-.+\-$/', $value['display_default'])) {
                            $this->updateStatus('vardefIncorrectDisplayDefault', $key, $module);
                        }
                        break;
                    case 'enum':
                    case 'multienum':
                        if (!empty($value['function']['returns']) && $value['function']['returns'] == 'html') {
                            // found html functional field
                            $this->updateStatus("vardefHtmlFunction" . $custom, $key);
                        }

                        // Check option-list multienum fields
                        if ($value['type'] == 'multienum'
                            && !empty($value['options'])
                            && !empty($GLOBALS['app_list_strings'][$value['options']])
                        ) {

                            $optionKeys = array_keys($GLOBALS['app_list_strings'][$value['options']]);
                            // Strip all valid characters in dropdown keys - a-zA-Z0-9. and spaces
                            $result = preg_replace('/[\w\d\s\.]/', '', $optionKeys);

                            // Get unique chars
                            $result = count_chars(implode('', $result), 3);

                            if ($result) {
                                $this->updateStatus("badVardefsMultienum", $value['name'], $value['options'], $result, $module);
                            }
                        }

                        break;
                    case 'link':
                        $seed->load_relationship($key);
                        if (empty($seed->$key)) {
                            $this->updateStatus("badVardefsLink", $key, $module);
                        }
                        break;
                    case 'relate':
                        if (!empty($value['link'])) {
                            $lname = $value['link'];
                            if (empty($fieldDefs[$lname])) {
                                ;
                                $this->updateStatus("badVardefsKey", $key, $lname, $module);
                                break;
                            }
                            $seed->load_relationship($lname);
                            if (empty($seed->$lname)) {
                                $this->updateStatus("badVardefsRelate", $key, $module);
                                break;
                            }
                            $relatedModuleName = $seed->$lname->getRelatedModuleName();
                            if (empty($relatedModuleName)) {
                                break;
                            }
                            $relatedBean = BeanFactory::newBean($relatedModuleName);
                            if (empty($relatedBean)) {
                                break;
                            }
                        }
                        if ((empty($value['link_type']) || $value['link_type'] != 'relationship_info') &&
                            empty($value['module'])) {
                            $this->updateStatus("badVardefsRelate", $key, $module);
                        }
                        break;
                }
            }

            if (empty($value['source']) || $value['source'] == 'db' || $value['source'] == 'custom_fields') {
                // check fields
                if (isset($value['fields'])) {
                    $this->checkFields($key, $value['fields'], $fieldDefs, $custom, $module);
                }
                // check db_concat_fields
                if (isset($value['db_concat_fields'])) {
                    $this->checkFields($key, $value['db_concat_fields'], $fieldDefs, $custom, $module);
                }
                // check sort_on
                if (!empty($value['sort_on'])) {
                    if (is_array($value['sort_on'])) {
                        $sort = $value['sort_on'];
                    } else {
                        $sort = array($value['sort_on']);
                    }
                    $this->checkFields($key, $sort, $fieldDefs, $custom, $module);
                }
            }
        }

        // check if we have any type changes for vardefs, BR-1427
        $this->checkVardefTypeChange($module, $object);
    }

    /* END of copypaste from 6_ScanModules */

    /**
     * Ping feedback url
     * @param array $data
     */
    protected function ping($data)
    {
        $url = $this->ping_url . "?" . http_build_query($data);
        @file_get_contents($url);
    }

    /**
     * List of standard BWC modules
     * @var array
     */
    protected $bwcModules = array(
        'ACLFields',
        'ACLRoles',
        'ACLActions',
        'Administration',
        'Audit',
        'Calendar',
        'Calls',
        'CampaignLog',
        'Campaigns',
        'CampaignTrackers',
        'Charts',
        'Configurator',
        'Contracts',
        'ContractTypes',
        'Connectors',
        'Currencies',
        'CustomQueries',
        'DataSets',
        'DocumentRevisions',
        'Documents',
        'EAPM',
        'EmailAddresses',
        'EmailMarketing',
        'EmailMan',
        'Emails',
        'EmailTemplates',
        'Employees',
        'Exports',
        'Expressions',
        'Groups',
        'History',
        'Holidays',
        'iCals',
        'Import',
        'InboundEmail',
        'KBContents',
        'KBDocuments',
        'KBDocumentRevisions',
        'KBTags',
        'KBDocumentKBTags',
        'KBContents',
        'Manufacturers',
        'Meetings',
        'MergeRecords',
        'ModuleBuilder',
        'MySettings',
        'OAuthKeys',
        'OptimisticLock',
        'OutboundEmailConfiguration',
        'PdfManager',
        'ProductBundleNotes',
        'ProductBundles',
        'ProductTypes',
        'Project',
        'ProjectResources',
        'ProjectTask',
        'Quotes',
        'QueryBuilder',
        'Relationships',
        'Releases',
        'ReportMaker',
        'Reports',
        'Roles',
        'SavedSearch',
        'Schedulers',
        'SchedulersJobs',
        'Shippers',
        'SNIP',
        'Studio',
        'SugarFavorites',
        'TaxRates',
        'Teams',
        'TeamMemberships',
        'TeamSets',
        'TeamSetModules',
        'TeamNotices',
        'TimePeriods',
        'Trackers',
        'TrackerSessions',
        'TrackerPerfs',
        'TrackerQueries',
        'UserPreferences',
        'UserSignatures',
        'Users',
        'vCals',
        'vCards',
        'Versions',
        'WorkFlow',
        'WorkFlowActions',
        'WorkFlowActionShells',
        'WorkFlowAlerts',
        'WorkFlowAlertShells',
        'WorkFlowTriggerShells',
        'HealthCheck',
    );

    /**
     * List of modules we have added in Sugar7
     * @var array
     */
    protected $newModules = array(
        'Comments' => 'Comments',
        'Filters' => 'Filters',
        'RevenueLineItems' => 'Revenue Line Items',
        'Styleguide' => 'Styleguide',
        'Subscriptions' => 'Subscriptions',
        'UserSignatures' => 'User Signatures',
        'WebLogicHooks' => 'Web Logic Hooks',
        'Words' => 'Words',
    );

    /**
     * Returns array that contains build and version
     */
    public function getVersion()
    {
        global $sugar_version, $sugar_build;
        $version = array(
            'version' => 'N/A',
            'build' => 'N/A'
        );
        if (file_exists(__DIR__ . '/' . self::VERSION_FILE)) {
            $json = file_get_contents(__DIR__ . '/' . self::VERSION_FILE);
            $data = json_decode($json, true);
            $version = array_merge($version, $data);
        } elseif ($sugar_version && $sugar_build) {
            $version = array_merge(
                $version,
                array(
                    'version' => $sugar_version,
                    'build' => $sugar_build
                )
            );
        }
        return array($version['version'], $version['build']);

    }
}

/**
 * Class that ignores everything, needs for loading
 * metadata with code
 */
class BlackHole
{
    protected $called;

    public function __get($v)
    {
        $this->called = true;
        return null;
    }

    public function __call($n, $a)
    {
        $this->called = true;
        return null;
    }
}

/**
 * Stub class for loading files
 * Needed because we can not override $this but some data files use $this
 * @param string $deffile Definitions file
 * @param string $varname Variable to load
 * @return null if no variable, false on error, otherwise value of $varname in file
 */
class FileLoaderWrapper extends BlackHole
{
    public function loadFile($deffile, $varname)
    {
        ob_start();
        @include $deffile;
        ob_end_clean();
        if ($this->called) {
            return false;
        }
        if (empty($$varname)) {
            return null;
        }
        return $$varname;
    }
}

