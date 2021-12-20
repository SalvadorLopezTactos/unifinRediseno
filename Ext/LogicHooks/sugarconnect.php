<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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

// Logic hooks to publish a bean to the Sugar Connect webhook.

$hook_array['after_save'][] = array(
    1,
    'sugarconnect',
    null,
    '\\Sugarcrm\\Sugarcrm\\SugarConnect\\LogicHooks\\Handler',
    'publish',
);

$hook_array['after_delete'][] = array(
    1,
    'sugarconnect',
    null,
    '\\Sugarcrm\\Sugarcrm\\SugarConnect\\LogicHooks\\Handler',
    'publish',
);

$hook_array['after_restore'][] = array(
    1,
    'sugarconnect',
    null,
    '\\Sugarcrm\\Sugarcrm\\SugarConnect\\LogicHooks\\Handler',
    'publish',
);

$hook_array['after_relationship_add'][] = array(
    1,
    'sugarconnect',
    null,
    '\\Sugarcrm\\Sugarcrm\\SugarConnect\\LogicHooks\\Handler',
    'publish',
);

$hook_array['after_relationship_delete'][] = array(
    1,
    'sugarconnect',
    null,
    '\\Sugarcrm\\Sugarcrm\\SugarConnect\\LogicHooks\\Handler',
    'publish',
);

$hook_array['after_relationship_update'][] = array(
    1,
    'sugarconnect',
    null,
    '\\Sugarcrm\\Sugarcrm\\SugarConnect\\LogicHooks\\Handler',
    'publish',
);
