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
$viewdefs['Holidays']['EditView'] = [
    'templateMeta' => [
        'maxColumns' => '2',
        'widths' => [
            ['label' => '10', 'field' => '30'],
            ['label' => '10', 'field' => '30'],
        ],
        'form' => [
            'buttons' => [
                'SAVE',
                ['customCode' =>
                    '{if !empty($smarty.request.return_action) && $smarty.request.return_action == "DetailView" && (!empty($fields.id.value) || !empty($smarty.request.return_id)) }' .
                    '<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'DetailView\'; this.form.module.value=\'{$smarty.request.return_module}\'; this.form.record.value=\'{$smarty.request.return_id}\';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL{$place}"> ' .
                    '{else}' .
                    '<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'index\'; this.form.module.value=\'{$smarty.request.return_module}\'; this.form.record.value=\'{$smarty.request.return_id}\';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL{$place}"> ' .
                    '{/if}',
                ],
            ],
        ],
    ],
    'panels' => [
        'default' => [
            [
                [
                    'name' => 'holiday_date',
                ],
                '',
            ],
            [
                [
                    'name' => 'name',
                    'displayParams' => ['required' => false],
                ],
            ],
            [
                [
                    'name' => 'description',
                ],
            ],
            [
                [
                    'name' => 'resource_name',
                    'displayParams' => ['required' => true],
                    'customCode' => '{if $PROJECT}<select name="person_type" id="person_type" onChange="showResourceSelect();">' .
                        '<option value="">{$MOD.LBL_SELECT_RESOURCE_TYPE}</option>' .
                        '<option value="Users">{$MOD.LBL_USER}</option>' .
                        '<option value="Contacts">{$MOD.LBL_CONTACT}</option>' .
                        '</select>' .
                        '<span id="resourceSelector"></span>{/if}',
                ],
            ],
        ],
    ],
];
