{*
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
*}

{$JAVASCRIPT}
<form class="search_form" id="search_form">
{sugar_csrf_form_token}
<div class="edit view search basic">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
    <td scope="row" width="1%" nowrap="nowrap"><slot>{$MOD.LBL_USER_NAME}</slot></td>
    <td width="1%"><slot><input type="text" size="10" name="user_name" value="{$USER_NAME}"></slot></td>
    <td style="padding-left: 10px ! important;">
        <input type="hidden" name="action" value="ViewOfflineClients"/>
        <input type="hidden" name="query" value="true"/>
        <input type="hidden" name="module" value="Administration" />
        <input title="{$APP.LBL_SEARCH_BUTTON_TITLE}" id="search_form_submit" class="button" type="submit" name="button" value="{$APP.LBL_SEARCH_BUTTON_LABEL}"/>
        <input title="{$APP.LBL_CLEAR_BUTTON_TITLE}" id="search_form_clear" onclick="clear_form(this.form);" class="button" type="button" name="clear" value=" {$APP.LBL_CLEAR_BUTTON_LABEL} "/>
    </td>
</tr>
</table>
</div>
</form>
