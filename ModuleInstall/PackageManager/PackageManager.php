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

define("CREDENTIAL_CATEGORY", "ml");
define("CREDENTIAL_USERNAME", "username");
define("CREDENTIAL_PASSWORD", "password");

use Sugarcrm\Sugarcrm\Util\Files\FileLoader;

require_once('vendor/nusoap//nusoap.php');
require_once('include/utils/zip_utils.php');
SugarAutoLoader::requireWithCustom('ModuleInstall/ModuleInstaller.php');

class PackageManager{
    var $soap_client;

    /**
     * @var string
     */
    private $baseUpgradeDir;

    /**
     * @var string
     */
    private $baseTempUpgradeDir;

    /**
     * Constructor: In this method we will initialize the nusoap client to point to the hearbeat server
     */
    public function __construct()
    {
        $this->db = DBManagerFactory::getInstance();
        $this->upload_dir = empty($GLOBALS['sugar_config']['upload_dir']) ? 'upload' : rtrim($GLOBALS['sugar_config']['upload_dir'], '/\\');
        $this->baseUpgradeDir = $this->upload_dir . '/upgrades';
        $this->baseTempUpgradeDir = $this->upload_dir . '/temp';
    }

    function initializeComm(){

    }

    /**
     * Obtain a promotion from SugarDepot
     * @return string   the string from the promotion
     */
    public static function getPromotion()
    {
        $name_value_list = PackageManagerComm::getPromotion();
        if(!empty($name_value_list)){
            $name_value_list = PackageManager::fromNameValueList($name_value_list);
            return $name_value_list['description'];
        }else {
           return '';
        }
    }

    /**
     * Obtain a list of category/packages/releases for use within the module loader
     */
    public static function getModuleLoaderCategoryPackages($category_id = '')
    {
    	$filter = array('type' => "'module', 'theme', 'langpack'");
    	$filter = PackageManager::toNameValueList($filter);
    	return PackageManager::getCategoryPackages($category_id, $filter);
    }

    /**
     * Obtain the list of category_packages from SugarDepot
     * @return category_packages
     */
    public static function getCategoryPackages($category_id = '', $filter = array())
    {
         $results = PackageManagerComm::getCategoryPackages($category_id, $filter);
         PackageManagerComm::errorCheck();
         $nodes = array();

        $nodes[$category_id]['packages'] = array();
        if(!empty($results['categories'])){
	         foreach($results['categories'] as $category){
	            $mycat = PackageManager::fromNameValueList($category);
	            $nodes[$mycat['id']] = array('id' => $mycat['id'], 'label' => $mycat['name'], 'description' => $mycat['description'], 'type' => 'cat', 'parent' => $mycat['parent_id']);
	            $nodes[$mycat['id']]['packages'] = array();
	         }
        }
         if(!empty($results['packages'])){
	        $uh = new UpgradeHistory();
	         foreach($results['packages'] as $package){
	            $mypack = PackageManager::fromNameValueList($package);
	            $nodes[$mypack['category_id']]['packages'][$mypack['id']] = array('id' => $mypack['id'], 'label' => $mypack['name'], 'description' => $mypack['description'], 'category_id' => $mypack['category_id'], 'type' => 'package');
	            $releases = PackageManager::getReleases($category_id, $mypack['id'], $filter);
	            $arr_releases = array();
	            $nodes[$mypack['category_id']]['packages'][$mypack['id']]['releases'] = array();
	            if(!empty($releases['packages'])){
		            foreach($releases['packages'] as $release){
		                 $myrelease = PackageManager::fromNameValueList($release);
		                 //check to see if we already this one installed
		                 $result = $uh->determineIfUpgrade($myrelease['id_name'], $myrelease['version']);
		                 $enable = false;
		                 if($result == true || is_array($result))
		                	 $enable = true;
		                 $nodes[$mypack['category_id']]['packages'][$mypack['id']]['releases'][$myrelease['id']] = array('id' => $myrelease['id'], 'version' => $myrelease['version'], 'label' => $myrelease['description'], 'category_id' => $mypack['category_id'], 'package_id' => $mypack['id'], 'type' => 'release', 'enable' => $enable);
		           	}
	            }
	            //array_push($nodes[$mypack['category_id']]['packages'], $package_arr);
	         }
         }
         $GLOBALS['log']->debug("NODES". var_export($nodes, true));
        return $nodes;
    }

    /**
     * Get a list of categories from the SugarDepot
     * @param category_id   the category id of parent to obtain
     * @param filter        an array of filters to pass to limit the query
     * @return array        an array of categories for display on the client
     */
    public static function getCategories($category_id, $filter = array())
    {
        $nodes = array();
        $results = PackageManagerComm::getCategories($category_id, $filter);
        PackageManagerComm::errorCheck();
        if(!empty($results['categories'])){
	        foreach($results['categories'] as $category){
	            $mycat = PackageManager::fromNameValueList($category);
	            $nodes[] = array('id' => $mycat['id'], 'label' => $mycat['name'], 'description' => $mycat['description'], 'type' => 'cat', 'parent' => $mycat['parent_id']);
	        }
        }
        return $nodes;
    }

    public static function getPackages($category_id, $filter = array())
    {
        $nodes = array();
        $results = PackageManagerComm::getPackages($category_id, $filter);
        PackageManagerComm::errorCheck();
        $packages = array();
        //$xml = '';
        //$xml .= '<packages>';
        if(!empty($results['packages'])){
	        foreach($results['packages'] as $package){
	            $mypack = PackageManager::fromNameValueList($package);
	            $packages[$mypack['id']] = array('package_id' => $mypack['id'], 'name' => $mypack['name'], 'description' => $mypack['description'], 'category_id' => $mypack['category_id']);
	            $releases = PackageManager::getReleases($category_id, $mypack['id']);
	            $arr_releases = array();
	            foreach($releases['packages'] as $release){
	                 $myrelease = PackageManager::fromNameValueList($release);
	                 $arr_releases[$myrelease['id']]  = array('release_id' => $myrelease['id'], 'version' => $myrelease['version'], 'description' => $myrelease['description'], 'category_id' => $mypack['category_id'], 'package_id' => $mypack['id']);
	            }
	            $packages[$mypack['id']]['releases'] = $arr_releases;
	        }
        }
        return $packages;
    }

    public static function getReleases($category_id, $package_id, $filter = array())
    {
        $releases = PackageManagerComm::getReleases($category_id, $package_id, $filter);
        PackageManagerComm::errorCheck();
        return $releases;
    }

    /**
     * Retrieve the package as specified by the $id from the heartbeat server
     *
     * @param category_id   the category_id to which the release belongs
     * @param package_id    the package_id to which the release belongs
     * @param release_id    the release_id to download
     * @return filename - the path to which the zip file was saved
     */
    public function download($category_id, $package_id, $release_id)
    {
        $GLOBALS['log']->debug('RELEASE _ID: '.$release_id);
        if(!empty($release_id)){
            $filename = PackageManagerComm::addDownload($category_id, $package_id, $release_id);
            if($filename){
	            $GLOBALS['log']->debug('RESULT: '.$filename);
	            PackageManagerComm::errorCheck();
	           	$filepath = PackageManagerComm::performDownload($filename);
	           	return $filepath;
            }
        }else{
            return null;
        }
    }

    /**
     * Given the Mambo username, password, and download key attempt to authenticate, if
     * successful then store these credentials
     *
     * @param username      Mambo username
     * @param password      Mambo password
     * @param systemname   the user's download key
     * @return              true if successful, false otherwise
     */
    public static function authenticate($username, $password, $systemname = '', $terms_checked = true)
    {
        PackageManager::setCredentials($username, $password, $systemname);
        PackageManagerComm::clearSession();
        $result = PackageManagerComm::login($terms_checked);
        if(is_array($result))
        	return $result;
       	else
        	return true;
    }

    public static function setCredentials($username, $password, $systemname)
    {
        $admin = Administration::getSettings();
         $admin->saveSetting(CREDENTIAL_CATEGORY, CREDENTIAL_USERNAME, $username);
         $admin->saveSetting(CREDENTIAL_CATEGORY, CREDENTIAL_PASSWORD, $password);
         if(!empty($systemname)){
         	$admin->saveSetting('system', 'name', $systemname);
         }
    }

    public static function getCredentials()
    {
        $admin = Administration::getSettings(CREDENTIAL_CATEGORY, true);
        $credentials = array();
        $credentials['username'] = '';
        $credentials['password'] = '';
		$credentials['system_name'] = '';
        if(!empty($admin->settings[CREDENTIAL_CATEGORY.'_'.CREDENTIAL_USERNAME])){
           $credentials['username'] = $admin->settings[CREDENTIAL_CATEGORY.'_'.CREDENTIAL_USERNAME];
        }
        if(!empty($admin->settings[CREDENTIAL_CATEGORY.'_'.CREDENTIAL_USERNAME])){
           $credentials['password'] = $admin->settings[CREDENTIAL_CATEGORY.'_'.CREDENTIAL_PASSWORD];
        }
        if(!empty($admin->settings['system_name'])){
           $credentials['system_name'] = $admin->settings['system_name'];
        }
        return $credentials;
    }

    public static function getTermsAndConditions()
    {
    	return PackageManagerComm::getTermsAndConditions();

    }

    /**
     * Retrieve documentation for the given release or package
     *
     * @param package_id	the specified package to retrieve documentation
     * @param release_id	the specified release to retrieve documentation
     *
     * @return documents
     */
    public static function getDocumentation($package_id, $release_id)
    {
    	 if(!empty($release_id) || !empty($package_id)){
            $documents = PackageManagerComm::getDocumentation($package_id, $release_id);
            return $documents;
        }else{
            return null;
        }
    }

    /**
     * Grab the list of installed modules and send that list to the depot.
     * The depot will then send back a list of modules that need to be updated
     */
    function checkForUpdates(){
    	$lists = $this->buildInstalledReleases(array('module'), true);
		$updates = array();
		if(!empty($lists)){
			$updates = PackageManagerComm::checkForUpdates($lists);
		}//fi
		return $updates;
    }

     ////////////////////////////////////////////////////////
     /////////// HELPER FUNCTIONS
    public static function toNameValueList($array)
    {
		$list = array();
		foreach($array as $name=>$value){
			$list[] = array('name'=>$name, 'value'=>$value);
		}
		return $list;
	}

    public static function toNameValueLists($arrays)
    {
		$lists = array();
		foreach($arrays as $array){
			$lists[] = PackageManager::toNameValueList($array);
		}
		return $lists;
	}

    public static function fromNameValueList($nvl)
    {
        $array = array();
        foreach($nvl as $list){
            $array[$list['name']] = $list['value'];
        }
        return $array;
    }

    function buildInstalledReleases($types = array('module')){
    	//1) get list of installed modules
		$installeds = $this->getInstalled($types);
		$releases = array();
		foreach($installeds as $installed){
			$releases[] = array('name' => $installed->name, 'id_name' => $installed->id_name, 'version' => $installed->version, 'filename' => $installed->filename, 'type' => $installed->type);
		}

		$lists = array();
		$name_value_list = array();
		if(!empty($releases)){
			$lists = $this->toNameValueLists($releases);
		}//fi
		return $lists;
    }

    function buildPackageXML($package, $releases = array()){
        $xml = '<package>';
        $xml .= '<package_id>'.$package['id'].'</package_id>';
        $xml .= '<name>'.$package['name'].'</name>';
        $xml .= '<description>'.$package['description'].'</description>';
        if(!empty($releases)){
             $xml .= '<releases>';
             foreach($releases['packages'] as $release){

                 $myrelease = PackageManager::fromNameValueList($release);
                 $xml .= '<release>';
                 $xml .= '<release_id>'.$myrelease['id'].'</release_id>';
                 $xml .= '<version>'.$myrelease['version'].'</version>';
                 $xml .= '<description>'.$myrelease['description'].'</description>';
                 $xml .= '<package_id>'.$package['id'].'</package_id>';
                 $xml .= '<category_id>'.$package['category_id'].'</category_id>';
                 $xml .= '</release>';
             }
             $xml .= '</releases>';
        }
        $xml .= '</package>';
        return $xml;
    }

    private $cleanUpDirs = array();

    private function addToCleanup($dir)
    {
        if(empty($this->cleanUpDirs)) {
            register_shutdown_function(array($this, "cleanUpTempDir"));
        }
        $this->cleanUpDirs[] = $dir;
    }

    public function cleanUpTempDir()
    {
        foreach($this->cleanUpDirs as $dir) {
            rmdir_recursive($dir);
        }
    }

    private function getMd5($fileName)
    {
        $realpath = UploadFile::realpath($fileName);

        $fileTimestamp = filemtime($realpath);
        $md5FileName = $realpath . '.md5';

        // if md5 file does not exist or diff time stamp,
        // generate md5 with same time as given file
        if (!file_exists($md5FileName)
            || $fileTimestamp !== filemtime($md5FileName)) {
            $md5 = md5_file($realpath);
            sugar_file_put_contents($md5FileName, $md5);
            sugar_touch($md5FileName, $fileTimestamp);
        } else {
            $md5 = sugar_file_get_contents($md5FileName);
        }

        return $md5;
    }

    /**
     * return base upload upgrade dir
     * @return string
     */
    public function getBaseUploadUpgradeDir(): string
    {
        return $this->baseUpgradeDir;
    }

    /**
     * Upload package zip file and check package content. Return uploaded file path.
     * @param string $type what is package type? It will match with type from manifest
     * @return string
     * @throws SugarException
     */
    public function uploadPackage(string $type): string
    {
        if (empty($_FILES['upgrade_zip']['tmp_name'])) {
            throw $this->getSugarException('ERR_UW_NO_UPLOAD_FILE');
        }

        $uploadFile = new UploadFile('upgrade_zip');
        if (!$uploadFile->confirm_upload()) {
            throw $this->getSugarExceptionWithExtraData('ERR_UW_NO_UPLOAD_FILE', $uploadFile->getErrorMessage());
        }

        $storedFileName = $uploadFile->get_stored_file_name();
        $isFileMoved = $uploadFile->final_move($storedFileName);
        if (strtolower(pathinfo($storedFileName, PATHINFO_EXTENSION)) !== 'zip' || !$isFileMoved) {
            throw $this->getSugarExceptionWithExtraData(
                'LBL_UPGRADE_WIZARD_INVALID_PKG',
                $uploadFile->getErrorMessage()
            );
        }

        $tempPackageFile = $this->upload_dir . '/' . $storedFileName;

        $manifestFile = $this->extractManifest($tempPackageFile, '');
        if (!is_file($manifestFile)) {
            throw $this->getSugarExceptionWithExtraData(
                'LBL_UPGRADE_WIZARD_INVALID_PKG',
                $uploadFile->getErrorMessage()
            );
        }

        $moduleScanner = new ModuleScanner();
        $moduleScanner->lockConfig();
        $fileScanIssues = $moduleScanner->scanFile($manifestFile);
        if (!empty($fileScanIssues)) {
            throw $this->getSugarExceptionWithExtraData('ML_MANIFEST_ISSUE', $moduleScanner->getFormattedIssues());
        }

        list($manifest, ) = $this->requireManifestFile($manifestFile);
        $configCheckIssues = $moduleScanner->checkConfig($manifest);
        if (!empty($configCheckIssues)) {
            throw $this->getSugarExceptionWithExtraData('ML_MANIFEST_ISSUE', $moduleScanner->getFormattedIssues());
        }

        try {
            UpgradeWizardCommon::validate_manifest($manifest);
        } catch (Exception $e) {
            throw $this->getSugarExceptionWithExtraData('ML_MANIFEST_ISSUE', $e->getMessage());
        }

        /*
         * Exclude the bad permutations. Default is misleading here as'module' is the default.
         * 'default' maps to an upgrade path which may no longer be supported
         */
        $uploadedPackageType = $manifest['type'];
        if ($type === 'module' && !in_array($uploadedPackageType, ['module', 'theme', 'langpack'])) {
            throw $this->getSugarException('ERR_UW_NOT_ACCEPTIBLE_TYPE');
        } elseif ($type === 'default' && $uploadedPackageType === 'patch') {
            throw $this->getSugarException('ERR_UW_ONLY_PATCHES');
        }

        $baseFilename = pathinfo($tempPackageFile, PATHINFO_BASENAME);

        mkdir_recursive($this->baseUpgradeDir . '/' . $uploadedPackageType);
        $targetPath = sprintf('%s/%s/%s', $this->baseUpgradeDir, $uploadedPackageType, $baseFilename);
        $targetManifest = remove_file_extension($targetPath) . '-manifest.php';

        //Verify this isn't going to conflict with an existing package.
        if (file_exists($targetPath) && md5_file($targetPath) != md5_file($tempPackageFile)) {
            throw $this->getSugarExceptionWithExtraData(
                'LBL_UPGRADE_WIZARD_INVALID_PKG',
                'An existing package with the filename ' . $baseFilename . ' detected.'
            );
        }

        if (!empty($manifest['icon'])) {
            $iconLocation = $this->extractFile($tempPackageFile, $manifest['icon'], $this->baseTempUpgradeDir);
            $targetIconLocation = sprintf(
                '%s-icon.%s',
                remove_file_extension($targetPath),
                pathinfo($iconLocation, PATHINFO_EXTENSION)
            );
            copy($iconLocation, $targetIconLocation);
        }

        if (rename($tempPackageFile, $targetPath)) {
            copy($manifestFile, $targetManifest);
            $GLOBALS['ML_STATUS_MESSAGE'] = $baseFilename . translate('Administration', 'LBL_UW_UPLOAD_SUCCESS');
            return $targetPath;
        } else {
            $GLOBALS['ML_STATUS_MESSAGE'] = translate('Administration', 'ERR_UW_UPLOAD_ERROR');
            throw $this->getSugarException('ERR_UW_UPLOAD_ERROR');
        }
    }

    /**
     * Delete temp files. Return SugarException with extra data
     * @param string $errorLabel this label with translated and used as key
     * @return SugarException
     */
    private function getSugarException(string $errorLabel): SugarException
    {
        return new SugarException($errorLabel, null, 'Administration');
    }

    /**
     * Delete temp files. Return SugarException with extra data
     * @param string $errorLabel this label with translated and used as key
     * @param mixed $extraData additional data with error explanation
     * @return SugarException
     */
    private function getSugarExceptionWithExtraData(string $errorLabel, $extraData): SugarException
    {
        $exception = $this->getSugarException($errorLabel);
        $exception->setExtraData('error_description', $extraData);
        return $exception;
    }

    //////////////////////////////////////////////////////////////////////
    /////////// INSTALL SECTION

    /**
     * Unzip package in temporary directory and return directory patch
     * @param string $baseTmpUpgradeDir
     * @param string $file
     * @return string
     */
    public function unzipPackageFileInTempDir(string $baseTmpUpgradeDir, string $file): string
    {
        $tmpUnzipDir = $this->prepareTemporaryUnzipDir($baseTmpUpgradeDir);
        unzip($file, $tmpUnzipDir);
        return $tmpUnzipDir;
    }

    /**
     * Create temporary directory in $baseTmpUpgradeDir.
     * Unzip $fileInZip into temporary directory and return path to unzipped file.
     * @param string $zipFile
     * @param string $fileInZip
     * @param string $baseTmpUpgradeDir
     * @return string
     */
    public function extractFile(string $zipFile, string $fileInZip, string $baseTmpUpgradeDir): string
    {
        $tmpUnzipDir = $this->prepareTemporaryUnzipDir($baseTmpUpgradeDir);
        unzip_file($zipFile, $fileInZip, $tmpUnzipDir);
        return $tmpUnzipDir . '/' . $fileInZip;
    }

    /**
     * Create $base if it doesn't exist.
     * Create temporary directory in $base. Add temporary directory to auto clean up.
     * Return temporary directory path.
     * @param string $base path to base directory
     * @return string
     */
    private function prepareTemporaryUnzipDir(string $base): string
    {
        if (!file_exists($base)) {
            sugar_mkdir($base, null, true);
        }

        $unzipDir = mk_temp_dir($base);
        $this->addToCleanup($unzipDir);
        return $unzipDir;
    }

    function extractManifest( $zip_file,$base_tmp_upgrade_dir ) {
        global $sugar_config;
        $base_upgrade_dir       = $this->upload_dir."/upgrades";
        $base_tmp_upgrade_dir   = "$base_upgrade_dir/temp";
        return $this->extractFile( $zip_file, "manifest.php",$base_tmp_upgrade_dir );
    }

    function validate_manifest( $manifest ){
    // takes a manifest.php manifest array and validates contents
    global $subdirs;
    global $sugar_version;
    global $sugar_flavor;
    global $mod_strings;

    if( !isset($manifest['type']) ){
        die($mod_strings['ERROR_MANIFEST_TYPE']);
    }
    $type = $manifest['type'];
    $GLOBALS['log']->debug("Getting InstallType");
    if( $this->getInstallType( "/$type/" ) == "" ){
        $GLOBALS['log']->debug("Error with InstallType".$type);
        die($mod_strings['ERROR_PACKAGE_TYPE']. ": '" . $type . "'." );
    }
    $GLOBALS['log']->debug("Passed with InstallType");
    if( isset($manifest['acceptable_sugar_versions']) ){
            $version_ok = false;
            $matches_empty = true;
            if( isset($manifest['acceptable_sugar_versions']['exact_matches']) ){
                $matches_empty = false;
                foreach( $manifest['acceptable_sugar_versions']['exact_matches'] as $match ){
                    if( $match == $sugar_version ){
                        $version_ok = true;
                    }
                }
            }
            if( !$version_ok && isset($manifest['acceptable_sugar_versions']['regex_matches']) ){
                $matches_empty = false;
                foreach( $manifest['acceptable_sugar_versions']['regex_matches'] as $match ){
                    if(!empty($match) && preg_match( "/$match/", $sugar_version ) ){
                        $version_ok = true;
                    }
                }
            }

            if( !$matches_empty && !$version_ok ){
                die( $mod_strings['ERROR_VERSION_INCOMPATIBLE'] . $sugar_version );
            }
        }

     if( isset($manifest['acceptable_sugar_flavors']) && sizeof($manifest['acceptable_sugar_flavors']) > 0 ){
            $flavor_ok = false;
            foreach( $manifest['acceptable_sugar_flavors'] as $match ){
                if( $match == $sugar_flavor ){
                    $flavor_ok = true;
                }
            }
            if( !$flavor_ok ){
                //die( $mod_strings['ERROR_FLAVOR_INCOMPATIBLE'] . $sugar_flavor );
            }
        }
    }

    function getInstallType( $type_string ){
        // detect file type
        global $subdirs;
        $subdirs = array('full', 'langpack', 'module', 'patch', 'theme', 'temp');


        foreach( $subdirs as $subdir ){
            if( preg_match( "#/$subdir/#", $type_string ) ){
                return( $subdir );
            }
        }
        // return empty if no match
        return( "" );
    }

    function performSetup($tempFile, $view = 'module', $display_messages = true){
        global $sugar_config,$mod_strings;
        $base_filename = urldecode($tempFile);
        $GLOBALS['log']->debug("BaseFileName: ".$base_filename);
        $base_upgrade_dir       = $this->upload_dir.'/upgrades';
        $base_tmp_upgrade_dir   = "$base_upgrade_dir/temp";
        $manifest_file = $this->extractManifest( $base_filename,$base_tmp_upgrade_dir);
         $GLOBALS['log']->debug("Manifest: ".$manifest_file);
        if($view == 'module')
            $license_file = $this->extractFile($base_filename, 'LICENSE', $base_tmp_upgrade_dir);
        if(is_file($manifest_file)){
            $GLOBALS['log']->debug("VALIDATING MANIFEST". $manifest_file);
            list($manifest, ) = $this->requireManifestFile($manifest_file);
            $this->validate_manifest($manifest );
            $upgrade_zip_type = $manifest['type'];
            $GLOBALS['log']->debug("VALIDATED MANIFEST");
            // exclude the bad permutations
            if( $view == "module" ){
                if ($upgrade_zip_type != "module" && $upgrade_zip_type != "theme" && $upgrade_zip_type != "langpack"){
                    $this->unlinkTempFiles();
                    if($display_messages)
                        die($mod_strings['ERR_UW_NOT_ACCEPTIBLE_TYPE']);
                }
            }elseif( $view == "default" ){
                if($upgrade_zip_type != "patch" ){
                    $this->unlinkTempFiles();
                    if($display_messages)
                        die($mod_strings['ERR_UW_ONLY_PATCHES']);
                }
            }

            $base_filename = preg_replace( "#\\\\#", "/", $base_filename );
            $base_filename = basename( $base_filename );
            mkdir_recursive( "$base_upgrade_dir/$upgrade_zip_type" );
            $target_path = "$base_upgrade_dir/$upgrade_zip_type/$base_filename";
            $target_manifest = remove_file_extension( $target_path ) . "-manifest.php";

            if( isset($manifest['icon']) && $manifest['icon'] != "" ){
                $icon_location = $this->extractFile( $tempFile ,$manifest['icon'], $base_tmp_upgrade_dir );
                $path_parts = pathinfo( $icon_location );
                copy( $icon_location, remove_file_extension( $target_path ) . "-icon." . $path_parts['extension'] );
            }

            if( copy( $tempFile , $target_path ) ){
                copy( $manifest_file, $target_manifest );
                if($display_messages)
                    $messages = '<script>ajaxStatus.flashStatus("' .$base_filename.$mod_strings['LBL_UW_UPLOAD_SUCCESS'] . ', 5000");</script>';
            }else{
                if($display_messages)
                	$messages = '<script>ajaxStatus.flashStatus("' .$mod_strings['ERR_UW_UPLOAD_ERROR'] . ', 5000");</script>';
            }
        }//fi
        else{
            $this->unlinkTempFiles();
            if($display_messages)
                die($mod_strings['ERR_UW_NO_MANIFEST']);
        }
        if(isset($messages))
            return $messages;
    }

    /**
     * Require manifest.php in isolated function is required
     * because some manifest comes with logic inside and could rewrite local values.
     * Throw SugarException if file doesn't exist. Because callers don't expect no valid file manifest here.
     *
     * @param string $manifestFilePath
     * @return array
     *
     * @throws SugarException
     */
    private function requireManifestFile(string $manifestFilePath): array
    {
        $manifest = [];
        $installdefs = [];
        try {
            /**
             * replace upload://upgrades to upload/upgrades to support old package manager behavior(getStagedPackages)
             * @TODO must be delete when all package CRUD is moved to DB
             */
            $manifestFilePath = str_replace('upload://upgrades', $this->baseUpgradeDir, $manifestFilePath);
            $manifestFilePath = FileLoader::validateFilePath($manifestFilePath, true);
        } catch (\RuntimeException $e) {
            throw $this->getSugarException('ERR_UW_NO_MANIFEST');
        }
        require $manifestFilePath;
        return [$manifest, $installdefs];
    }

    /**
     * delete temp upload files
     */
    public function deleteTempUploadFiles(): void
    {
        self::unlinkTempFiles();
    }

    public static function unlinkTempFiles(): void
    {
        if (empty($_FILES['upgrade_zip'])) {
            return;
        }
        $tmpFileName = $_FILES['upgrade_zip']['tmp_name'];
        if (is_uploaded_file($tmpFileName) && file_exists($tmpFileName)) {
            unlink($tmpFileName);
        }
        $filePath = UploadStream::path('upload://' . $_FILES['upgrade_zip']['name']);
        if (null !== $filePath && file_exists($filePath)) {
            unlink($filePath);
        }
    }

    /**
     * Install package. Return UpgradeHistory of installed package.
     * @param string $file
     * @param bool $silent
     * @return UpgradeHistory|null
     */
    public function performInstall($file, $silent = true):? UpgradeHistory
    {
        global $sugar_config;
        global $mod_strings;
        global $current_language;
        $base_upgrade_dir       = $this->upload_dir.'/upgrades';
        $base_tmp_upgrade_dir   = "$base_upgrade_dir/temp";
        if(!file_exists($base_tmp_upgrade_dir)){
            mkdir_recursive($base_tmp_upgrade_dir, true);
        }

        $GLOBALS['log']->debug("INSTALLING: ".$file);
        $moduleInstallerClass = SugarAutoLoader::customClass('ModuleInstaller');
        $mi = new $moduleInstallerClass();
        $mi->silent = $silent;
        $mod_strings = return_module_language($current_language, "Administration");
             $GLOBALS['log']->debug("ABOUT TO INSTALL: ".$file);
        if(preg_match("#.*\.zip\$#", $file)) {
             $GLOBALS['log']->debug("1: ".$file);
            // handle manifest.php
            $target_manifest = remove_file_extension( $file ) . '-manifest.php';
            list($manifest, $installdefs) = $this->requireManifestFile($target_manifest);
            $GLOBALS['log']->debug("2: ".$file);
            $unzip_dir = mk_temp_dir( $base_tmp_upgrade_dir );
            $this->addToCleanup($unzip_dir);
            unzip($file, $unzip_dir );
            $GLOBALS['log']->debug("3: ".$unzip_dir);
            $id_name = $installdefs['id'];
			$version = $manifest['version'];
			$uh = new UpgradeHistory();
			$previous_install = array();
    		if(!empty($id_name) & !empty($version))
    			$previous_install = $uh->determineIfUpgrade($id_name, $version);
    		$previous_version = (empty($previous_install['version'])) ? '' : $previous_install['version'];
    		$previous_id = (empty($previous_install['id'])) ? '' : $previous_install['id'];

            if(!empty($previous_version)){
            	$mi->install($unzip_dir, true, $previous_version);
            }else{
            	$mi->install($unzip_dir);
            }
            $GLOBALS['log']->debug("INSTALLED: ".$file);
            $new_upgrade = new UpgradeHistory();
            $new_upgrade->filename      = $file;
            $new_upgrade->md5sum        = md5_file($file);
            $new_upgrade->type          = $manifest['type'];
            $new_upgrade->version       = $manifest['version'];
            $new_upgrade->status        = "installed";
            //$new_upgrade->author        = $manifest['author'];
            $new_upgrade->name          = $manifest['name'];
            $new_upgrade->description   = $manifest['description'];
            $new_upgrade->id_name		= $id_name;
			$serial_manifest = array();
			$serial_manifest['manifest'] = (isset($manifest) ? $manifest : '');
			$serial_manifest['installdefs'] = (isset($installdefs) ? $installdefs : '');
			$serial_manifest['upgrade_manifest'] = (isset($upgrade_manifest) ? $upgrade_manifest : '');
			$new_upgrade->manifest		= base64_encode(serialize($serial_manifest));
            //$new_upgrade->unique_key    = (isset($manifest['unique_key'])) ? $manifest['unique_key'] : '';
            $new_upgrade->save();
            return $new_upgrade;
                    //unlink($file);
        }//fi
        return null;
    }

    function performUninstall($name){
    	$uh = new UpgradeHistory();
    	$uh->name = $name;
    	$uh->id_name = $name;
    	$found = $uh->checkForExisting($uh);
    	if($found != null){
    		global $sugar_config;
	        global $mod_strings;
	        global $current_language;
	        $base_upgrade_dir       = $this->upload_dir.'/upgrades';
	        $base_tmp_upgrade_dir   = "$base_upgrade_dir/temp";
            if(is_file($found->filename)){
                if(!isset($GLOBALS['mi_remove_tables']))$GLOBALS['mi_remove_tables'] = true;
                $unzip_dir = mk_temp_dir( $base_tmp_upgrade_dir );
                unzip($found->filename, $unzip_dir );
                $moduleInstallerClass = SugarAutoLoader::customClass('ModuleInstaller');
                $mi = new $moduleInstallerClass();
                $mi->silent = true;
                $mi->uninstall( "$unzip_dir");
                $found->delete();
                unlink(remove_file_extension( $found->filename ) . '-manifest.php');
                unlink($found->filename);
            }else{
                //file(s_ have been deleted or are not found in the directory, allow database delete to happen but no need to change filesystem
                $found->delete();
            }
    	}
    }

    function getUITextForType( $type ){
        if( $type == "full" ){
            return( "Full Upgrade" );
        }
        if( $type == "langpack" ){
            return( "Language Pack" );
        }
        if( $type == "module" ){
            return( "Module" );
        }
        if( $type == "patch" ){
            return( "Patch" );
        }
        if( $type == "theme" ){
            return( "Theme" );
        }
    }

    function getImageForType( $type ){

        $icon = "";
        switch( $type ){
            case "full":
                $icon = SugarThemeRegistry::current()->getImage("Upgrade", "" ,null,null,'.gif', "Upgrade");

                break;
            case "langpack":
                $icon = SugarThemeRegistry::current()->getImage("LanguagePacks", "",null,null,'.gif',"Language Packs" );

                break;
            case "module":
                $icon = SugarThemeRegistry::current()->getImage("ModuleLoader", "" ,null,null,'.gif', "Module Loader");

                break;
            case "patch":
                $icon = SugarThemeRegistry::current()->getImage("PatchUpgrades", "",null,null,'.gif', "Patch Upgrades" );

                break;
            case "theme":
                $icon = SugarThemeRegistry::current()->getImage("Themes", "",null,null,'.gif', "Themes" );

                break;
            default:
                break;
        }
        return( $icon );
    }

    function getPackagesInStaging($view = 'module'){
        global $sugar_config;
        global $current_language;
        $uh = new UpgradeHistory();
        $base_upgrade_dir       = "upload://upgrades";
        $uContent = findAllFiles($base_upgrade_dir, array(), false, 'zip', $base_upgrade_dir . '/backup');
        $upgrade_contents = array();
        $content_values = array_values($uContent);
        $alreadyProcessed = array();
        foreach($content_values as $val){
        	if(empty($alreadyProcessed[$val])){
        		$upgrade_contents[] = $val;
        		$alreadyProcessed[$val] = true;
        	}
        }

        $upgrades_available = 0;
        $packages = array();
        $mod_strings = return_module_language($current_language, "Administration");
        foreach($upgrade_contents as $upgrade_content) {
            if(!preg_match('#.*\.zip$#', strtolower($upgrade_content)) || preg_match("#.*./zips/.*#", strtolower($upgrade_content))) {
                continue;
            }

            $target_manifest = remove_file_extension($upgrade_content) . '-manifest.php';
            if (!file_exists($target_manifest)) {
                continue;
            }

            list($manifest, ) = $this->requireManifestFile($target_manifest);
            $manifest_type = $manifest['type'];
            if (($view == 'default' && $manifest_type != 'patch')
                 || ($view == 'module' && $manifest_type != 'module'
                    && $manifest_type != 'theme' && $manifest_type != 'langpack')
                ) {
                continue;
            }

            $the_base = basename($upgrade_content);
            $the_md5 = $this->getMd5($upgrade_content);
            $md5_matches = $uh->findByMd5($the_md5);
    		$file_install = $upgrade_content;
            if(empty($md5_matches))
            {
                    $name = empty($manifest['name']) ? $upgrade_content : $manifest['name'];
                    $version = empty($manifest['version']) ? '' : $manifest['version'];
                    $published_date = empty($manifest['published_date']) ? '' : $manifest['published_date'];
                    $icon = '';
                    $description = empty($manifest['description']) ? 'None' : $manifest['description'];
                    $uninstallable = empty($manifest['is_uninstallable']) ? 'No' : 'Yes';
                    $type = $this->getUITextForType($manifest['type']);
                    $dependencies = array();
                    if (isset($manifest['dependencies'])) {
                        $dependencies = $manifest['dependencies'];
                    }

                    //check dependencies first
                    if (!empty($dependencies)) {
                        $uh = new UpgradeHistory();
                        $not_found = $uh->checkDependencies($dependencies);
                        if (!empty($not_found) && count($not_found) > 0) {
                            $file_install =
                                'errors_' . $mod_strings['ERR_UW_NO_DEPENDENCY'] . "[" . implode(',', $not_found) . "]";
                        }
                    }

                    if (empty($manifest['icon'])) {
                        $icon = $this->getImageForType($manifest['type']);
                    } else {
                        $path_parts = pathinfo($manifest['icon']);
                        $icon = "<img src=\"" . remove_file_extension($upgrade_content) . "-icon." .
                            $path_parts['extension'] . "\">";
                    }

                    $upgrades_available++;

                    $packages[] = array(
                        'name' => $name,
                        'version' => $version,
                        'published_date' => $published_date,
                        'description' => $description,
                        'uninstallable' => $uninstallable,
                        'type' => $type,
                        'file' => fileToHash(urlencode($upgrade_content)),
                        'file_install' => fileToHash($upgrade_content),
                        'unFile' => fileToHash($upgrade_content)
                    );
            } //fi
        } //rof
        return $packages;
    }

    function getLicenseFromFile($file){
        global $sugar_config;
        $base_upgrade_dir       = $this->upload_dir.'/upgrades';
        $base_tmp_upgrade_dir   = "$base_upgrade_dir/temp";
        $license_file = $this->extractFile($file, 'LICENSE', $base_tmp_upgrade_dir);
        if(is_file($license_file)){
            $contents = file_get_contents($license_file);
            return $contents;
        }else{
            return null;
        }
    }

    /**
     * Run the query to obtain the list of installed types as specified by the type param
     *
     * @param type	an array of types you would like to search for
     * 				type options include (theme, langpack, module, patch)
     *
     * @return an array of installed upgrade_history objects
     */
    function getInstalled($types = array('module')){
    	$uh = new UpgradeHistory();
    	$in = "";
    	for($i = 0; $i < count($types); $i++){
    		$in .= "'".$types[$i]."'";
    		if(($i+1) < count($types)){
    			$in .= ",";
    		}
    	}
    	$query = "SELECT * FROM ".$uh->table_name."	 WHERE type IN (".$in.")";
    	return $uh->getList($query);
    }

    function getinstalledPackages($types = array('module', 'langpack')){
    	global $sugar_config;
    	$installeds = $this->getInstalled($types);
    	$packages = array();
    	$upgrades_installed = 0;
    	$uh = new UpgradeHistory();
        $base_upgrade_dir       = $this->upload_dir.'/upgrades';
        $base_tmp_upgrade_dir   = "$base_upgrade_dir/temp";
    	foreach($installeds as $installed)
		{
			$populate = false;
			$filename = from_html($installed->filename);
			$date_entered = $installed->date_entered;
			$type = $installed->type;
			$version = $installed->version;
			$uninstallable = false;
			$link = "";
			$description = $installed->description;
			$name = $installed->name;
			$enabled = true;
			$enabled_string = 'ENABLED';
			//if the name is empty then we should try to pull from manifest and populate upgrade_history_table
			if(empty($name)){
				$populate = true;
			}
			$upgrades_installed++;
			switch($type)
			{
				case "theme":
				case "langpack":
				case "module":
				case "patch":
					if($populate){
						$manifest_file = $this->extractManifest($filename, $base_tmp_upgrade_dir);
                        list($manifest, $installdefs) = $this->requireManifestFile($manifest_file);
						$GLOBALS['log']->info("Filling in upgrade_history table");
						$populate = false;
						if( isset( $manifest['name'] ) ){
    						$name = $manifest['name'];
    						$installed->name = $name;
						}
						if( isset( $manifest['description'] ) ){
						    $description = $manifest['description'];
						    $installed->description = $description;
						}
						if(isset($installdefs) && isset( $installdefs['id'] ) ){
						    $id_name  = $installdefs['id'];
						    $installed->id_name = $id_name;
						}

						$serial_manifest = array();
						$serial_manifest['manifest'] = (isset($manifest) ? $manifest : '');
						$serial_manifest['installdefs'] = (isset($installdefs) ? $installdefs : '');
						$serial_manifest['upgrade_manifest'] = (isset($upgrade_manifest) ? $upgrade_manifest : '');
						$installed->manifest = base64_encode(serialize($serial_manifest));
						$installed->save();
					}else{
                        $serial_manifest = unserialize(
                            base64_decode($installed->manifest),
                            ['allowed_classes' => false]
                        );
						$manifest = $serial_manifest['manifest'];
					}
                    if (is_file($filename) && !empty($manifest['is_uninstallable'])
                       && ($upgrades_installed==0 || $uh->UninstallAvailable($installeds, $installed))) {
						$uninstallable = true;
					}
					$enabled = $installed->enabled;
					if(!$enabled)
						$enabled_string = 'DISABLED';
					$file_uninstall = $filename;
					if(!$uninstallable){
						$file_uninstall = 'UNINSTALLABLE';
						$enabled_string = 'UNINSTALLABLE';
					} else {
						$file_uninstall = fileToHash( $file_uninstall );
					}

				$packages[] = array(
				    'name' => $name,
				    'version' => $version,
				    'type' => $type,
				    'published_date' => $date_entered,
				    'description' => $description,
				    'uninstallable' =>$uninstallable,
				    'file_install' =>  $file_uninstall ,
				    'file' =>  fileToHash($filename),
                    'enabled' => $enabled_string,
                    'id' => $installed->id,
				);
				break;
				default:
				break;
			}

		}//rof
		return $packages;
    }
 }

