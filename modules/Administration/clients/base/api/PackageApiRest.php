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

require_once 'include/utils/layout_utils.php';

/**
 * Administration API PackageApiRest
 */
final class PackageApiRest extends FileApi
{
    /**
     * @var PackageController
     */
    private $packageController;

    /**
     * @var PackageManager
     */
    private $packageManager;

    /**
     * @var string
     */
    private $baseTempUpgradeDir;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->packageController = new PackageController();
        $this->packageManager = new PackageManager();

        $this->baseTempUpgradeDir = sugar_cached('upgrades/temp');
    }

    /**
     * Register endpoints
     * @return array
     */
    public function registerApiRest()
    {
        return [
            'uploadPackage' => [
                'reqType' => ['POST'],
                'path' => ['Administration', 'packages'],
                'pathVars' => ['', ''],
                'method' => 'uploadPackage',
                'rawPostContents' => true,
                'shortHelp' => 'Uploads a package to an instance. Does not install or enable the package',
                'longHelp' => 'include/api/help/administration_packages_upload_help.html',
                'exceptions' => [
                    'SugarApiExceptionNotAuthorized',
                    'SugarApiException',
                ],
            ],
            'installPackage' => [
                'reqType' => ['GET'],
                'path' => ['Administration', 'packages', '?', 'install'],
                'pathVars' => ['', '', 'hash', ''],
                'method' => 'installPackage',
                'shortHelp' => 'Install the given package',
                'longHelp' => 'include/api/help/administration_packages_install_help.html',
                'exceptions' => [
                    'SugarApiExceptionNotAuthorized',
                    'SugarApiExceptionMissingParameter',
                    'SugarApiExceptionNotFound',
                    'SugarApiException',
                ],
            ],
            'unInstallPackage' => [
                'reqType' => ['GET'],
                'path' => ['Administration', 'packages', '?', 'uninstall'],
                'pathVars' => ['', '', 'id', ''],
                'method' => 'unInstallPackage',
                'shortHelp' => 'Uninstall the given package',
                'longHelp' => 'include/api/help/administration_packages_uninstall_help.html',
                'exceptions' => [
                    'SugarApiExceptionNotAuthorized',
                    'SugarApiExceptionMissingParameter',
                    'SugarApiExceptionNotFound',
                    'SugarApiException',
                ],
            ],
            'enablePackage' => [
                'reqType' => ['GET'],
                'path' => ['Administration', 'packages', '?', 'enable'],
                'pathVars' => ['', '', 'id', ''],
                'method' => 'enablePackage',
                'shortHelp' => 'Enable the given package',
                'longHelp' => 'include/api/help/administration_packages_enable_help.html',
                'exceptions' => [
                    'SugarApiExceptionNotAuthorized',
                    'SugarApiExceptionMissingParameter',
                    'SugarApiExceptionNotFound',
                    'SugarApiException',
                ],
            ],
            'disablePackage' => [
                'reqType' => ['GET'],
                'path' => ['Administration', 'packages', '?', 'disable'],
                'pathVars' => ['', '', 'id', ''],
                'method' => 'disablePackage',
                'shortHelp' => 'Disable the given package',
                'longHelp' => 'include/api/help/administration_packages_disable_help.html',
                'exceptions' => [
                    'SugarApiExceptionNotAuthorized',
                    'SugarApiExceptionMissingParameter',
                    'SugarApiExceptionNotFound',
                    'SugarApiException',
                ],
            ],
            'deletePackage' => [
                'reqType' => ['DELETE'],
                'path' => ['Administration', 'packages', '?'],
                'pathVars' => ['', '', 'hash'],
                'method' => 'deletePackage',
                'shortHelp' => 'Delete the given package by file hash',
                'longHelp' => 'include/api/help/administration_packages_delete_help.html',
                'exceptions' => [
                    'SugarApiExceptionNotAuthorized',
                    'SugarApiExceptionMissingParameter',
                    'SugarApiException',
                ],
            ],
            'listPackages' => [
                'reqType' => 'GET',
                'path' => ['Administration', 'packages'],
                'pathVars' => [''],
                'method' => 'getPackages',
                'keepSession' => true,
                'shortHelp' => 'List uploaded but not installed packages ready to be installed',
                'longHelp' => 'include/api/help/administration_packages_list_all_packages_help.html',
                'exceptions' => [
                    'SugarApiExceptionNotAuthorized',
                ],
            ],
            'listStagedPackages' => [
                'reqType' => 'GET',
                'path' => ['Administration', 'packages', 'staged'],
                'pathVars' => [''],
                'method' => 'getStagedPackages',
                'keepSession' => true,
                'shortHelp' => 'List uploaded but not installed packages ready to be installed',
                'longHelp' => 'include/api/help/administration_packages_list_staged_packages_help.html',
                'exceptions' => [
                    'SugarApiExceptionNotAuthorized',
                ],
            ],
            'listInstalledPackages' => [
                'reqType' => 'GET',
                'path' => ['Administration', 'packages', 'installed'],
                'pathVars' => [''],
                'method' => 'getInstalledPackages',
                'keepSession' => true,
                'shortHelp' => 'List of installed packages',
                'longHelp' => 'include/api/help/administration_packages_list_installed_packages_help.html',
                'exceptions' => [
                    'SugarApiExceptionNotAuthorized',
                ],
            ],
        ];
    }

    /**
     * Upload package zip archive from $_FILES['upgrade_zip'].
     * Check this zip. Return status.
     * @param RestService $api
     * @param array $args
     *
     * @return array
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiException
     */
    public function uploadPackage(RestService $api, array $args): array
    {
        $this->ensureAdminUser();

        $_REQUEST['view'] = 'module';
        try {
            $file =  $this->packageManager->uploadPackage('module');
            /**
             * replace upload/upgrades to upload://upgrades to support old package manager behavior
             * Provide the file hash to install and delete package
             * The result must be compatible with old package manager staging result
             * @TODO must be delete when all package CRUD is moved to DB
             */
            $file = str_replace($this->packageManager->getBaseUploadUpgradeDir(), 'upload://upgrades', $file);
            $hash = fileToHash($file);
            return [
                'file_install' => $hash,
                'unFile' => $hash,
            ];
        } catch (SugarException $e) {
            throw $this->getSugarApiException($e, 'upload_package_error');
        } finally {
            $this->packageManager->deleteTempUploadFiles();
        }
    }

    /**
     * Delete package files. Return status.
     *
     * @param RestService $api
     * @param array $args
     *
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiException
     */
    public function deletePackage(RestService $api, array $args): void
    {
        $this->ensureAdminUser();
        $this->requireArgs($args, ['hash']);
        $file = hashToFile($args['hash']);
        if ($file === false) {
            // we have to get packages in staging to create file hash table
            $this->packageManager->getPackagesInStaging('module');
        }
        $file = (string) hashToFile($args['hash']);
        try {
            $this->packageController->removePackageFiles($file);
        } catch (SugarException $e) {
            throw $this->getSugarApiException($e, 'delete_package_error');
        }
    }

    /**
     * Uninstall package by id.
     * @param RestService $api
     * @param array $args
     *
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotFound
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiException
     */
    public function unInstallPackage(RestService $api, array $args): void
    {
        global $mi_remove_tables;
        $mi_remove_tables = true;

        $this->ensureAdminUser();
        $this->requireArgs($args, ['id']);

        /** @var UpgradeHistory $upgradeHistory */
        $upgradeHistory = $this->getUpgradeHistoryByIdOrFail($args['id']);

        $unzipDir = $this->packageManager->unzipPackageFileInTempDir(
            $this->baseTempUpgradeDir,
            $upgradeHistory->filename
        );

        $moduleInstaller = $this->getModuleInstaller();
        $moduleInstaller->setPatch($upgradeHistory->getPackagePatch());
        try {
            $moduleInstaller->uninstall($this->baseTempUpgradeDir . '/' . basename($unzipDir));
        } catch (Exception $e) {
            throw new SugarApiException($e->getMessage(), null, 'Administration', 0, 'uninstall_package_error');
        } finally {
            $this->packageManager->deleteTempUploadFiles();
        }
        $upgradeHistory->delete();
    }

    /**
     * Enable package by ID.
     * @param RestService $api
     * @param array $args
     *
     * @return array
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotFound
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiException
     */
    public function enablePackage(RestService $api, array $args): array
    {
        $this->ensureAdminUser();
        $this->requireArgs($args, ['id']);

        /** @var UpgradeHistory $upgradeHistory */
        $upgradeHistory = $this->getUpgradeHistoryByIdOrFail($args['id']);
        if ($upgradeHistory->isPackageEnabled()) {
            throw new SugarApiException(
                'ERR_UW_PACKAGE_ALREADY_ENABLED',
                null,
                'Administration',
                0,
                'enable_package_error'
            );
        }

        $callable = function (ModuleInstaller $moduleInstaller, string $tempPackageDir): void {
            $moduleInstaller->enable($tempPackageDir);
        };
        $this->processEnableDisablePackage($upgradeHistory, $callable);

        $upgradeHistory->enabled = 1;
        $upgradeHistory->save();

        return ['id' => $upgradeHistory->id];
    }

    /**
     * Disable package by ID.
     * @param RestService $api
     * @param array $args
     *
     * @return array
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotFound
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiException
     */
    public function disablePackage(RestService $api, array $args): array
    {
        $this->ensureAdminUser();
        $this->requireArgs($args, ['id']);

        /** @var UpgradeHistory $upgradeHistory */
        $upgradeHistory = $this->getUpgradeHistoryByIdOrFail($args['id']);
        if (!$upgradeHistory->isPackageEnabled()) {
            throw new SugarApiException(
                'ERR_UW_PACKAGE_ALREADY_DISABLED',
                null,
                'Administration',
                0,
                'disable_package_error'
            );
        }
        $callable = function (ModuleInstaller $moduleInstaller, string $tempPackageDir): void {
            $moduleInstaller->disable($tempPackageDir);
        };
        $this->processEnableDisablePackage($upgradeHistory, $callable);

        $upgradeHistory->enabled = 0;
        $upgradeHistory->save();

        return ['id' => $upgradeHistory->id];
    }

    /**
     * Enable or disable package.
     * Set package enable flag in DB.
     * @param UpgradeHistory $upgradeHistory
     * @param callable $callable
     * @param int $enableFieldValue
     *
     * @throws SugarApiException
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiExceptionNotFound
     */
    private function processEnableDisablePackage(UpgradeHistory $upgradeHistory, callable $callable): void
    {
        global $mi_overwrite_files;
        $mi_overwrite_files = true;

        $_REQUEST['view'] = 'module';
        $packageType = UpgradeWizardCommon::getInstallType($upgradeHistory->filename);
        if ($packageType !== 'module') {
            throw new SugarApiException('ERR_UW_WRONG_PACKAGE_TYPE', ['module'], 'Administration');
        }

        $unzipDir = $this->packageManager->unzipPackageFileInTempDir(
            $this->baseTempUpgradeDir,
            $upgradeHistory->filename
        );

        $moduleInstaller = $this->getModuleInstaller();
        $moduleInstaller->setPatch($upgradeHistory->getPackagePatch());
        try {
            $callable($moduleInstaller, $this->baseTempUpgradeDir . '/' . basename($unzipDir));
        } catch (Exception $e) {
            throw new SugarApiException($e->getMessage(), null, 'Administration');
        } finally {
            $this->packageManager->deleteTempUploadFiles();
        }
        MetaDataManager::clearAPICache();
    }

    /**
     * Install package and return newly installed package id
     * @param RestService $api
     * @param array $args
     *
     * @return array
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiExceptionNotFound
     * @throws SugarApiException
     */
    public function installPackage(RestService $api, array $args): array
    {
        $this->ensureAdminUser();
        $this->requireArgs($args, ['hash']);

        $hash = $args['hash'];
        $file = hashToFile($hash);
        if ($file === false) {
            // we have to get packages in staging to create file hash table
            $this->packageManager->getPackagesInStaging('module');
            $file = hashToFile($hash);
        }

        if (empty($file)) {
            throw new SugarApiExceptionNotFound('LBL_UPGRADE_WIZARD_FILE_NOT_SPEC', null, 'Administration');
        }

        $upgradeHistory = new UpgradeHistory();
        $matches = $upgradeHistory->findByMd5(md5_file($file));
        if (count($matches) > 0) {
            throw new SugarApiException(
                'ERR_UW_PACKAGE_ALREADY_INSTALLED',
                null,
                'Administration',
                0,
                'install_package_error'
            );
        }

        $upgradeHistory = $this->packageManager->performInstall($file);
        return ['id' => $upgradeHistory->id];
    }

    /**
     * Returns a list of packages in the 'staged' status
     *
     * @param RestService $api
     * @param array $args
     *
     * @return array
     * @throws SugarApiExceptionNotAuthorized
     */
    public function getStagedPackages(RestService $api, array $args): array
    {
        $this->ensureAdminUser();

        return ['packages' => $this->packageManager->getPackagesInStaging('module')];
    }

    /**
     * Returns a list of packages in the 'installed' status
     *
     * @param RestService $api
     * @param array $args
     *
     * @return array
     * @throws SugarApiExceptionNotAuthorized
     */
    public function getInstalledPackages(RestService $api, array $args): array
    {
        $this->ensureAdminUser();

        return ['packages' => $this->packageManager->getinstalledPackages(['module'])];
    }

    /**
     * Returns a list of all packages
     *
     * @param RestService $api
     * @param array $args
     *
     * @return array
     * @throws SugarApiExceptionNotAuthorized
     */
    public function getPackages(RestService $api, array $args): array
    {
        $this->ensureAdminUser();
        $installedPackages = array_map(
            function ($package) {
                $package['installed'] = true;
                return $package;
            },
            $this->packageManager->getinstalledPackages(['module'])
        );
        $stagedPackages = array_map(
            function ($package) {
                $package['installed'] = false;
                return $package;
            },
            $this->packageManager->getPackagesInStaging(['module'])
        );
        return ['packages' => array_merge($installedPackages, $stagedPackages)];
    }

    /**
     * return UpgradeHistory by ID or throw no found exception
     * @param string $id
     * @return UpgradeHistory
     * @throws SugarApiExceptionNotFound
     */
    private function getUpgradeHistoryByIdOrFail(string $id): UpgradeHistory
    {
        /** @var UpgradeHistory $upgradeHistory */
        $upgradeHistory = BeanFactory::retrieveBean('UpgradeHistory', $id);

        if (is_null($upgradeHistory)) {
            throw new SugarApiExceptionNotFound('ERR_UW_NO_PACKAGE', null, 'Administration');
        }

        return $upgradeHistory;
    }

    /**
     * Ensure current user has admin permissions
     * @throws SugarApiExceptionNotAuthorized
     */
    private function ensureAdminUser()
    {
        if (empty($GLOBALS['current_user']) || !$GLOBALS['current_user']->isAdmin()) {
            throw new SugarApiExceptionNotAuthorized(translate('EXCEPTION_NOT_AUTHORIZED'));
        }
    }

    /**
     * Provide module installer with check for customization
     * @return ModuleInstaller
     */
    private function getModuleInstaller()
    {
        SugarAutoLoader::requireWithCustom('ModuleInstall/ModuleInstaller.php');
        $moduleInstallerClass = SugarAutoLoader::customClass('ModuleInstaller');

        $moduleInstaller = new $moduleInstallerClass();
        $moduleInstaller->silent = true;

        return $moduleInstaller;
    }

    /**
     * convert SugarException into SugarApiException
     * @param SugarException $sugarException
     * @param string $errorLabel
     * @return SugarApiException
     */
    private function getSugarApiException(SugarException $sugarException, string $errorLabel): SugarApiException
    {
        $apiException = new SugarApiException($sugarException->getMessage(), null, 'Administration', 0, $errorLabel);
        $apiException->extraData = $sugarException->extraData;
        return $apiException;
    }
}
