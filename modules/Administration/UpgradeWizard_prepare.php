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

use Sugarcrm\Sugarcrm\Security\InputValidation\InputValidation;
use Sugarcrm\Sugarcrm\Security\Csrf\CsrfAuthenticator;
use Sugarcrm\Sugarcrm\PackageManager\Entity\PackageManifest;
use Sugarcrm\Sugarcrm\PackageManager\File\PackageZipFile;
use Sugarcrm\Sugarcrm\PackageManager\PackageManager;

require_once 'include/utils.php';

$historyId = InputValidation::getService()->getValidInputRequest('install_file');
if (empty($historyId)) {
    sugar_die(htmlspecialchars(translate('ERR_UW_NO_PACKAGE_FILE', 'Administration')));
}

$upgradeHistory = BeanFactory::retrieveBean('UpgradeHistory', $historyId);
if (empty($upgradeHistory->id)) {
    sugar_die(htmlspecialchars(translate('ERR_UW_NO_PACKAGE_FILE', 'Administration')));
}
$packageManager = new PackageManager();
try {
    $historyManifest = $upgradeHistory->getPackageManifest();
    $packageZipFile = new PackageZipFile($upgradeHistory->getFileName(), $packageManager->getBaseTempDir());
    $packageZipFile->extractPackage();
} catch (SugarException $e) {
    sugar_die($e->getMessage());
}

$mode = InputValidation::getService()->getValidInputRequest(
    'mode',
    array(
        'Assert\Choice' => array(
            'choices' => array(
                'Install',
                'Uninstall',
                'Disable',
                'Enable'
            )
        )
    ),
    ''
);
if (empty($mode)) {
    sugar_die(htmlspecialchars(translate('LBL_UPGRADE_WIZARD_NO_MODE_SPEC', 'Administration')));
}

$installType = $historyManifest->getPackageType();
$csrfFieldName = CsrfAuthenticator::FORM_TOKEN_FIELD;
$csrfToken = CsrfAuthenticator::getInstance()->getFormToken();

$license = $readme = '';
$licenseFile = $packageZipFile->getPackageDir() . DIRECTORY_SEPARATOR . 'LICENSE.txt';
$readmeFile = $packageZipFile->getPackageDir() . DIRECTORY_SEPARATOR . 'README.txt';
$isPackageTypeModule = $installType === PackageManifest::PACKAGE_TYPE_MODULE;
if ($isPackageTypeModule && ($mode === 'Install' || $mode === 'Enable') && file_exists($licenseFile)) {
    $licenseContent = htmlspecialchars(file_get_contents($licenseFile));
    $moduleLicenseLabel = htmlspecialchars(translate('LBL_LICENSE', 'Administration'));
    $moduleReadLicenseLabel = htmlspecialchars(translate('LBL_MODULE_LICENSE', 'Administration'));
    $moduleLicenseAcceptLabel = htmlspecialchars(translate('LBL_ACCEPT', 'Administration'));
    $moduleLicenseDenyLabel = htmlspecialchars(translate('LBL_DENY', 'Administration'));
    $moduleLicenseError = htmlspecialchars(translate('ERR_UW_ACCEPT_LICENSE', 'Administration'));
    if (!empty($licenseContent)) {
        $license = <<<HTML
<div id="uw-license-block" style="text-align:left; width: 50%; margin-top: 15px;">
    <h2>$moduleLicenseLabel</h2>
    <h3>$moduleReadLicenseLabel</h3>
    <p style="display: block; margin: 15px;">$licenseContent</p>
    <div id="module-license-error" style="display: none; color: red;">$moduleLicenseError</div>
    <div style="display: block">
        <div style="display: inline-block; width: 25%">
            <lable for="radio_license_agreement_accept">$moduleLicenseAcceptLabel</lable>
            <input type="radio" id="radio_license_agreement_accept" name="radio_license_agreement" value="accept">
        </div>
        <div style="display: inline-block; width: 25%">
            <lable for="radio_license_agreement_deny">$moduleLicenseDenyLabel</lable>
            <input type="radio" id="radio_license_agreement_deny" name="radio_license_agreement" value="reject" checked>
        </div>            
    </div>
</div>
HTML;
        $readmeContent = $historyManifest->getManifestValue('readme');
        if (empty($readmeContent) && file_exists($readmeFile)) {
            $readmeContent = file_get_contents($readmeFile);
        }
        if (!empty($readmeContent)) {
            $readmeContent = htmlspecialchars($readmeContent);
            $readmeLabel = htmlspecialchars(translate('LBL_README', 'Administration'));
            $showMoreLabel = htmlspecialchars(translate('LBL_SHOW_MORE'));
            $showLessLabel = htmlspecialchars(translate('LBL_SHOW_LESS'));
            $readme = <<<HTML
<div id="uw-readme-block" style="text-align:left; width: 50%; margin-top: 15px;">
    <div style="display: block">
        <div style="display: inline-block; width: 25%">
            <h2>$readmeLabel</h2>
        </div>
        <div style="display: inline-block; text-align: left; width: 15%">
            <a id="readme-toggle-link" href="#" data-toggle-text="$showLessLabel">$showMoreLabel</a>
        </div>
    </div>    
    <div id="readme-content-block" style="display: none;">
        <p style="margin: 15px;">$readmeContent</p>
    </div>
</div>
HTML;
        }

    }
}

switch ($mode) {
    case 'Install':
        $actionLabel = htmlspecialchars(translate('LBL_UW_PATCH_READY', 'Administration'));
        if ($installType === PackageManifest::PACKAGE_TYPE_LANGPACK) {
            $actionLabel = htmlspecialchars(translate('LBL_UW_LANGPACK_READY', 'Administration'));
        }
        break;
    case 'Uninstall':
        $actionLabel = htmlspecialchars(translate('LBL_UW_UNINSTALL_READY', 'Administration'));
        if ($installType === PackageManifest::PACKAGE_TYPE_LANGPACK) {
            $actionLabel = htmlspecialchars(translate('LBL_UW_LANGPACK_READY', 'Administration'));
        } elseif ($installType !==  PackageManifest::PACKAGE_TYPE_MODULE) {
            $actionLabel = htmlspecialchars(translate('LBL_UW_FILES_REMOVED', 'Administration'));
        }
        break;
    case 'Disable':
        $actionLabel = htmlspecialchars(translate('LBL_UW_DISABLE_READY', 'Administration'));
        if ($installType === PackageManifest::PACKAGE_TYPE_LANGPACK) {
            $actionLabel = htmlspecialchars(translate('LBL_UW_LANGPACK_READY_DISABLE', 'Administration'));
        }
        break;
    case 'Enable':
        $actionLabel = htmlspecialchars(translate('LBL_UW_ENABLE_READY', 'Administration'));
        if ($installType === PackageManifest::PACKAGE_TYPE_LANGPACK) {
            $actionLabel = htmlspecialchars(translate('LBL_UW_LANGPACK_READY_ENABLE', 'Administration'));
        }
        break;
}

$removeTables = $historyManifest->getManifestValue('remove_tables');
$removeTablesContent = '';
if ($removeTables === 'prompt' && $mode === 'Uninstall') {
    $removeTablesLabel = htmlspecialchars(translate('ML_LBL_REMOVE_TABLES', 'Administration'));
    $doNotRemoveTablesLabel = htmlspecialchars(translate('ML_LBL_DO_NOT_REMOVE_TABLES', 'Administration'));

    $removeTablesContent = <<<HTML
<div style="width: 50%; display: block; margin-top: 15px;">
    <div style="display: block">
        <div style="display: inline-block; width: 25%">
            <lable for="remove_tables_true">$removeTablesLabel</lable>'
            <input type="radio" id="remove_tables_true" name="remove_tables" value="true" checked>
        </div>
        <div style="display: inline-block; width: 25%">
            <lable for="remove_tables_false">$doNotRemoveTablesLabel</lable>
            <input type="radio" id="remove_tables_false" name="remove_tables" value="false">
        </div>            
    </div>
</div>
HTML;
}
$overwriteFilesContent = '';
if ($mode === "Disable" || $mode === "Enable") {
    $copyFiles = $historyManifest->getInstallDefsValue('copy');
    if (!empty($copyFiles)) {
        $overwriteFilesLabel = htmlspecialchars(translate('LBL_OVERWRITE_FILES', 'Administration'));
        $doNotOverwriteFilesLabel = htmlspecialchars(translate('LBL_DO_OVERWRITE_FILES', 'Administration'));

        $overwriteFilesContent = <<<HTML
<div style="width: 50%; display: block; margin-top: 15px;">
    <div style="display: inline-block; width: 25%">
        <h3>$overwriteFilesLabel</h3>
    </div>
    <div style="display: block">
        <div style="display: inline-block; width: 25%">
            <lable for="radio_overwrite_files">$overwriteFilesLabel</lable>
            <input type='radio' id='radio_overwrite_files' name='radio_overwrite' value='overwrite'>
        </div>
        <div style="display: inline-block; width: 25%">
            <lable for="radio_do_not_overwrite_files">$doNotOverwriteFilesLabel</lable>
            <input type='radio' id='radio_do_not_overwrite_files' name='radio_overwrite' value='do_not_overwrite' checked>
        </div>            
    </div>
</div>
HTML;
    }
}

$commitButtonLabel = htmlspecialchars(translate('LBL_ML_COMMIT', 'Administration'));
$cancelButtonLabel = htmlspecialchars(translate('LBL_ML_CANCEL', 'Administration'));

echo <<<HTML
<div style="display:block; width: 100%;">
    <form action="index.php?module=Administration&view=module&action=UpgradeWizard_commit" method="post" id="uw-prepare-form">
        <input type="hidden" name="mode" value="$mode" />
        <input type="hidden" name="$csrfFieldName" value="$csrfToken" />
        <input type="hidden" name="package_id"  value="{$upgradeHistory->id}" />
        $license
        $readme
        <div style="width: 50%; display: block; margin-top: 15px;"><h2>$actionLabel</h2></div>
        $removeTablesContent
        $overwriteFilesContent
        <div style="width: 50%; display: block; margin-top: 15px;">
            <input disabled="disabled" type=submit value="$commitButtonLabel" class="button" id="uw-prepare-form-submit-button" />
            <input type=button value="$cancelButtonLabel" class="button" onClick="location.href='index.php?module=Administration&action=UpgradeWizard&view=module';"/>
        </div>
    </form>
</div>

<script>
    (function() {
        let form = document.getElementById('uw-prepare-form');
        let readmeDiv = document.getElementById('uw-readme-block');
            
        form.onsubmit = function() {
            let licenseDiv = document.getElementById('uw-license-block');
            if (typeof(licenseDiv) !== 'undefined' && licenseDiv !== null) {
                if (document.getElementById("radio_license_agreement_deny").checked) {
                    document.getElementById('module-license-error').style.display = 'block';
                    setTimeout(function() {
                        document.getElementById('module-license-error').style.display = 'none';
                    }, 5000);
                    return false;
                }
            }
            form.submit();
            return false;
        }
        
        if (typeof(readmeDiv) !== 'undefined' && readmeDiv !== null) {
            let showMoreLink = document.getElementById('readme-toggle-link');
            let readmeContent = document.getElementById('readme-content-block');
            
            showMoreLink.onclick = function() {
                let toggleText = showMoreLink.getAttribute('data-toggle-text');
                showMoreLink.setAttribute('data-toggle-text', showMoreLink.textContent);
                showMoreLink.textContent = toggleText;
                
                if (readmeContent.style.display == "none") {
                    readmeContent.style.display = 'block';
                } else {
                    readmeContent.style.display = 'none';
                }
            }
        }
        
        document.getElementById('uw-prepare-form-submit-button').disabled = false;
    })();
</script>
HTML;
