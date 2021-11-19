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
	<tr class='pagination'  role='presentation'>
		<td colspan='{if $prerow}{$colCount+1}{else}{$colCount}{/if}'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>
						{$actionsLink}&nbsp;
						&nbsp;{$selectedObjectsSpan}
					</td>
					<td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>
						{capture assign="other_attributes"}align="absmiddle" border="0"{/capture}
                        {if $pageData.urls.startPage}
                            {assign var="alt_start" value=$navStrings.start}
							<button type='button' id='listViewStartButton' name='listViewStartButton' title='{$navStrings.start}' class='button' {if $prerow}onClick='save_kb_checks(0); SUGAR.kb.paginateList("{$pageData.urls.startPage}", "browse");'{else} onClick='SUGAR.kb.paginateList("{$pageData.urls.startPage}", document.getElementById("mode_b").value);' {/if}>
                                {sugar_getimage name="start" ext=".png" alt=$navStrings.start other_attributes=$other_attributes alt="$alt_start"}
							</button>
						{else}
							<button type='button' id='listViewStartButton' name='listViewStartButton' title='{$navStrings.start}' class='button' disabled='disabled'>
								{sugar_getimage name="start_off" ext=".png" alt=$navStrings.start other_attributes=$other_attributes}
							</button>
						{/if}
						{if $pageData.urls.prevPage}
                            {assign var="alt_prev" value=$navStrings.previous}
							<button type='button' id='listViewPrevButton' name='listViewPrevButton' title='{$navStrings.previous}' class='button' {if $prerow}onClick='save_kb_checks({$pageData.offsets.prev}); SUGAR.kb.paginateList("{$pageData.urls.prevPage}", "browse");' {else} onClick='SUGAR.kb.paginateList("{$pageData.urls.prevPage}", document.getElementById("mode_b").value);'{/if}>
								{sugar_getimage name="previous" ext=".png" alt=$navStrings.previous other_attributes=$other_attributes alt="$alt_prev"}
							</button>
						{else}
							<button type='button' id='listViewPrevButton' name='listViewPrevButton' class='button' title='{$navStrings.previous}' disabled='disabled'>
								{sugar_getimage name="previous_off" ext=".png" alt=$navStrings.previous other_attributes=$other_attributes}
							</button>
						{/if}
							<span class='pageNumbers'>({if $pageData.offsets.lastOffsetOnPage == 0}0{else}{$pageData.offsets.current+1}{/if} - {$pageData.offsets.lastOffsetOnPage} {$navStrings.of} {if $pageData.offsets.totalCounted}{$pageData.offsets.total}{else}{$pageData.offsets.total}{if $pageData.offsets.lastOffsetOnPage != $pageData.offsets.total}+{/if}{/if})</span>
						{if $pageData.urls.nextPage}
                            {assign var="alt_next" value=$navStrings.next}
							<button type='button' id='listViewNextButton' name='listViewNextButton' title='{$navStrings.next}' class='button' {if $prerow}onClick='save_kb_checks({$pageData.offsets.next}); SUGAR.kb.paginateList("{$pageData.urls.nextPage}", "browse");' {else} onClick='SUGAR.kb.paginateList("{$pageData.urls.nextPage}", document.getElementById("mode_b").value);'{/if}>
								{sugar_getimage name="next" ext=".png" alt=$navStrings.next other_attributes=$other_attributes alt="$alt_next"}
							</button>
						{else}
							<button type='button' id='listViewNextButton' name='listViewNextButton' class='button' title='{$navStrings.next}' disabled='disabled'>
								{sugar_getimage name="next_off" ext=".png" alt=$navStrings.next other_attributes=$other_attribtues}
							</button>
						{/if}
						{if $pageData.urls.endPage  && $pageData.offsets.total != $pageData.offsets.lastOffsetOnPage}
                            {assign var="alt_end" value=$navStrings.end}
							<button type='button' id='listViewEndButton' name='listViewEndButton' title='{$navStrings.end}' class='button' {if $prerow}onClick='save_kb_checks("end"); SUGAR.kb.paginateList("{$pageData.urls.endPage}", "browse");' {else} onClick='SUGAR.kb.paginateList("{$pageData.urls.endPage}", document.getElementById("mode_b").value);'{/if}>
								{sugar_getimage name="end" ext=".png" alt=$navStrings.end other_attributes=$other_attributes alt="$alt_end"}
							</button>
						{elseif !$pageData.offsets.totalCounted || $pageData.offsets.total == $pageData.offsets.lastOffsetOnPage}
							<button type='button' id='listViewEndButton' name='listViewEndButton' title='{$navStrings.end}' class='button' disabled='disabled'>
							 	{sugar_getimage name="end_off" ext=".png" alt=$navStrings.end other_attributes=$other_attributes}
							</button>
						{/if}
					</td>
				</tr>
			</table>
		</td>
	</tr>