<?php
 if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

$mod_strings = array(
    'TPL_ACTIVITY_CREATE' => 'Oprettet {{{str "TPL_ACTIVITY_RECORD" "Aktiviteter" objekt}}}{{#if objekt.modul}} {{getModuleName object.module}}{{/hvis}}.',
    'TPL_ACTIVITY_POST' => '{{{value}}}{{{str "TPL_ACTIVITY_ON" "Activiteter" dette}}}',
    'TPL_ACTIVITY_UPDATE' => 'Opdateret {{#if updateStr}}{{{updateStr}}} på {{/if}}{{#if object.module}}{{{str "TPL_ACTIVITY_RECORD" "Aktiviteter" objekt}}}{{else}}{{object.name}}{{/if}}.',
    'TPL_ACTIVITY_UPDATE_FIELD' => '<a rel="tooltip" title="Changed: {{before}} To: {{after}}">{{field_label}}</a>',
    'TPL_ACTIVITY_LINK' => 'Linked {{{str "TPL_ACTIVITY_RECORD" "Aktiviteter" subjekt}}} til {{{str "TPL_ACTIVITY_RECORD" "Aktiviteter" objekt}}}.',
    'TPL_ACTIVITY_UNLINK' => 'Unlinked {{{str "TPL_ACTIVITY_RECORD" "Aktiviteter" subject}}} til {{{str "TPL_ACTIVITY_RECORD" "Aktiviteter" objekt}}}.',
    'TPL_ACTIVITY_ATTACH' => 'Tilføjet fil <a class="dragoff" target="sugar_attach" href="{{url}}" data-note-id="{{noteId}}">{{filename}}</a>{{{str "TPL_ACTIVITY_ON" "Aktiviteter" dette}}}',
    'TPL_ACTIVITY_DELETE' => 'Slettet {{{str "TPL_ACTIVITY_RECORD" "Aktiviteter" objekt}}} {{getModuleName object.module}}.',
    'TPL_ACTIVITY_UNDELETE' => 'Gendannet {{{str "TPL_ACTIVITY_RECORD" "Aktiviteter" objekt}}} {{getModuleName object.module}}.',
    'TPL_ACTIVITY_RECORD' => '{{#if module}}<a href="#{{buildRoute module=module id=id}}">{{name}}</a>{{else}}{{name}}{{/hvis}}',
    // We need the trailing space at the end of the next line so that the str
    // handlebars helper isn't confused by a template that returns no text.
    'TPL_ACTIVITY_ON' => '{{#if object}} on {{{str "TPL_ACTIVITY_RECORD" "Aktiviteter" objekt}}}.{{/if}}{{#if module}} på {{getModuleName module}}.{{else}} {{/hvis}}',
    'TPL_COMMENT' => '{{{value}}}',
    'TPL_MORE_COMMENT' => '{{this}} flere kommentarer&hellip;',
    'TPL_MORE_COMMENTS' => '{{this}} flere kommentarer&hellip;',
    'TPL_SHOW_MORE_MODULE' => 'Flere poster...',
);
