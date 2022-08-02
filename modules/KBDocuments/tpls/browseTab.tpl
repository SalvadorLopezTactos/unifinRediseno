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

{$SITEURL}
<script type="text/javascript" language="Javascript" src="{sugar_getjspath file='modules/KBDocuments/kbdocuments.js'}"></script>
			<table width="100%" cellpadding="0" cellspacing="0" border="{$BORDER}" class="edit view search kb">
				<tr>
					<td width="{$TREE_WIDTH}" valign="top" >
						<div id="kb_browse_tags">
						
							{$TREEINSTANCE}
						</div>
					</td>
					<td valign="top"  id='selected_directory_children'>&nbsp;</td>
				</tr>
			</table>
