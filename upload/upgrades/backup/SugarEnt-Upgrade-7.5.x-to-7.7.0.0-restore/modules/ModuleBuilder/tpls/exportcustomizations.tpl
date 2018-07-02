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

<form name="exportcustom" id="exportcustom">
<input type='hidden' name='module' value='ModuleBuilder'>
<input type='hidden' name='action' value='ExportCustom'>
<div align="left">
<input type="submit" class="button" name="exportCustomBtn" value="{$mod_strings.LBL_EC_EXPORTBTN}" onclick="return check_form('exportcustom');">
</div>
<br>
    <table class="mbTable">
    <tbody>
    <tr>
    	<td class="mbLBL">
    		<b><font color="#ff0000">*</font> {$mod_strings.LBL_EC_NAME} </b>
    	</td>
    	<td>
    		<input type="text" value="" size="50" name="name"/>
    	</td>
    </tr>
    <tr>
    	<td class="mbLBL">
    		<b>{$mod_strings.LBL_EC_AUTHOR} </b>
    	</td>
    	<td>
    		<input type="text" value="" size="50" name="author"/>
    	</td>
    </tr>
    <tr>
    	<td class="mbLBL">
    		<b>{$mod_strings.LBL_EC_DESCRIPTION} </b>
    	</td>
    	<td>
    		<textarea rows="3" cols="60" name="description"></textarea>
    	</td>
    </tr>
    <tr>
    	<td height="100%"/>
    	<td/>
    </tr>
    </tbody>
	</table>
	
    <table border="0" CELLSPACING="15" WIDTH="100%">
        <TR><input type="hidden" name="hiddenCount"></TR>
        {foreach from=$modules key=k item=i}
        
        <TR>
            <TD><h3 style='margin-bottom:20px;'>{if $i != ""}<INPUT onchange="updateCount(this);" type="checkbox" name="modules[]" value={$k}>{/if}{$moduleList[$k]}</h3></TD>
            <TD VALIGN="top">
            {foreach from=$i item=j}
            {$j}<br>
            {/foreach}
            </TD>
        </TR>
        
        {/foreach} 
    </table>
    <br> 
</form>

{literal}
<script type="text/javascript">
var boxChecked = 0;

function updateCount(box) {
   boxChecked = box.checked == true ? ++boxChecked : --boxChecked;
   document.exportcustom.hiddenCount.value = (boxChecked == 0 ? "" : "CHECKED");
}
{/literal}
ModuleBuilder.helpRegister('exportcustom');
ModuleBuilder.helpSetup('exportcustom','exportHelp');
addToValidate('exportcustom', 'hiddenCount', 'varchar', true, '{$mod_strings.LBL_EC_CHECKERROR}');
addToValidate('exportcustom', 'name', 'varchar', true, '{$mod_strings.LBL_PACKAGE_NAME}'{literal});
</script>
{/literal}
{include file='modules/ModuleBuilder/tpls/assistantJavascript.tpl'}