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
/*********************************************************************************
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/


global $app_strings;
//we don't want the parent module's string file, but rather the string file specifc to this subpanel
global $current_language;
$current_module_strings = return_module_language($current_language, 'EmailMarketing');

global $currentModule;

global $theme;
global $focus;
global $action;


// focus_list is the means of passing data to a SubPanelView.
global $focus_list;

$button = "<form action='index.php' method='post' name='MKForm' id='MKForm'>\n";
$button .= "<input type='hidden' name='module' value='EmailMarketing'>\n";
$button .= "<input type='hidden' name='campaign_id' value='$focus->id'>\n";
$button .= "<input type='hidden' name='return_module' value='" . $currentModule . "'>\n";
$button .= "<input type='hidden' name='return_action' value='DetailView'>\n";
$button .= "<input type='hidden' name='return_id' value='" . $focus->id . "'>\n";
$button .= "<input type='hidden' name='action'>\n";

$button .= "<input title='" . $app_strings['LBL_NEW_BUTTON_TITLE'] . "' accessyKey='" . $app_strings['LBL_NEW_BUTTON_KEY'] . "' class='button' onclick=\"this.form.action.value='EditView'\" type='submit' name='New' value='  " . $app_strings['LBL_NEW_BUTTON_LABEL'] . "  '>\n";

$button .= "</form>\n";

$ListView = new ListView();
$ListView->initNewXTemplate('modules/EmailMarketing/SubPanelView.html', $current_module_strings);

$ListView->xTemplateAssign('EDIT_INLINE_PNG', SugarThemeRegistry::current()->getImage('edit_inline', 'align="absmiddle" border="0"', null, null, '.gif', $app_strings['LNK_EDIT']));
$ListView->xTemplateAssign('REMOVE_INLINE_PNG', SugarThemeRegistry::current()->getImage('delete_inline', 'align="absmiddle" border="0"', null, null, '.gif', $app_strings['LNK_REMOVE']));

$ListView->xTemplateAssign('RETURN_URL', '&return_module=' . $currentModule . '&return_action=DetailView&return_id=' . $focus->id);
$ListView->setHeaderTitle($current_module_strings['LBL_MODULE_NAME']);
$ListView->setHeaderText($button);
$ListView->processListView($focus_list, 'main', 'EMAILMARKETING');
