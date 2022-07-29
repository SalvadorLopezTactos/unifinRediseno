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

if(!is_admin($GLOBALS['current_user'])){
	sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
}

require_once 'ModuleInstall/ModuleScanner.php';
require_once 'include/SugarSmarty/plugins/function.sugar_csrf_form_token.php';

use Sugarcrm\Sugarcrm\PackageManager\Entity\PackageManifest;
use Sugarcrm\Sugarcrm\Security\InputValidation\InputValidation;
use Sugarcrm\Sugarcrm\PackageManager\PackageManager;
use UploadFile as BaseUploadFile;
use Sugarcrm\Sugarcrm\PackageManager\File\UploadFile;
use Sugarcrm\Sugarcrm\PackageManager\File\PackageZipFile;
use Sugarcrm\Sugarcrm\PackageManager\Exception\ModuleScannerException;

global $mod_strings;

$form_action = "index.php?module=Administration&view=module&action=UpgradeWizard";
$uploadLabel = htmlspecialchars(translate('LBL_UW_UPLOAD_MODULE', 'Administration'));
$descItemsQueued = $mod_strings['LBL_UW_DESC_MODULES_QUEUED'];
$descItemsInstalled = $mod_strings['LBL_UW_DESC_MODULES_INSTALLED'];


define('SUGARCRM_MIN_UPLOAD_MAX_FILESIZE_BYTES', 6 * 1024 * 1024);  // 6 Megabytes

$upload_max_filesize = ini_get('upload_max_filesize');
$upload_max_filesize_bytes = return_bytes($upload_max_filesize);
if($upload_max_filesize_bytes < constant('SUGARCRM_MIN_UPLOAD_MAX_FILESIZE_BYTES'))
{
	$GLOBALS['log']->debug("detected upload_max_filesize: $upload_max_filesize");
	print('<p class="error">' . $mod_strings['MSG_INCREASE_UPLOAD_MAX_FILESIZE'] . ' '
		. get_cfg_var('cfg_file_path') . "</p>\n");
}

//
// process "run" commands
//
$request = InputValidation::getService();
$run = $request->getValidInputRequest('run', null, "");
$reloadMetadata = $request->getValidInputRequest('reloadMetadata');

if ($run !== "" && empty($GLOBALS['sugar_config']['use_common_ml_dir'])) {
    if ($run == "upload") {
        try {
            $packageManager = new PackageManager();
            $uploadFile = new UploadFile(new BaseUploadFile('upgrade_zip'));
            $uploadFile->moveToUpload();
            $zipFile = new PackageZipFile($uploadFile->getPath(), $packageManager->getBaseTempDir());
            $packageManager->uploadPackageFromFile($zipFile, PackageManifest::PACKAGE_TYPE_MODULE);
        } catch (ModuleScannerException $e) {
            $e->getModuleScanner()->displayIssues();
            sugar_cleanup(true);
        } catch (\SugarException $e) {
            sugar_die($e->getMessage());
        }
    }
}


echo getClassicModuleTitle(
    htmlspecialchars(translate('LBL_MODULE_NAME', 'Administration')),
    [htmlspecialchars(translate('LBL_MODULE_LOADER_TITLE', 'Administration'))],
    false
);
$csrfToken = smarty_function_sugar_csrf_form_token(array(), $smarty);

// upload link
if (!empty($GLOBALS['sugar_config']['use_common_ml_dir'])) {
    $form = '<br>' . $mod_strings['LBL_MODULE_UPLOAD_DISABLE_HELP_TEXT'] . '</br>';
}else{
    $form =<<<eoq
<form name="the_form" enctype="multipart/form-data" action="{$form_action}" method="post"  >
{$csrfToken}
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
<tr><td>
<table width="450" border="0" cellspacing="0" cellpadding="0">
<tr><td style="white-space:nowrap; padding-right: 10px !important;">
{$uploadLabel}
<input type="file" name="upgrade_zip" size="40" />
</td>
<td>
<input type=button class="button" value="{$mod_strings['LBL_UW_BTN_UPLOAD']}" onClick="document.the_form.upgrade_zip_escaped.value = escape( document.the_form.upgrade_zip.value );document.the_form.submit();" />
<input type=hidden name="run" value="upload" />
<input type=hidden name="upgrade_zip_escaped" value="" />
</td>
</tr>
</table></td></tr></table>
</form>
eoq;
}

$hidden_fields = "<input type=hidden name=\"run\" value=\"upload\" />";
$hidden_fields .= "<input type=hidden name=\"mode\"/>";

$form2 = PackageManagerDisplay::buildPackageDisplay($form, $hidden_fields, $form_action, array('module'));
$form3 =<<<eoq3


eoq3;

echo $form2.$form3;

if (!empty($reloadMetadata)) {
    echo "
        <script>
            var app = window.parent.SUGAR.App;
            app.api.call('read', app.api.buildURL('ping'));
        </script>";
}

$GLOBALS['log']->info( "Upgrade Wizard view");
?>
</td>
</tr>
</table></td></tr></table>
