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
namespace Sugarcrm\Sugarcrm\Hint\Iss;

class Commands
{
    const ISS_ADD_ACCOUNT = 'addAccount';       // always within a single accountset
    const ISS_DELETE_ACCOUNT = 'deleteAccount'; // always within a single accountset
    const ISS_DELETE_ACCOUNT_ALL = 'deleteAccountAll';  // remove all references to the account; it was deleted
    const ISS_UPDATE_ACCOUNT_ALL = 'updateAccountAll';  // update all references to the account

    const ISS_ADD_TARGET = 'addTarget';         // define a new target
    const ISS_UPDATE_TARGET = 'updateTarget';   // changing the credentials
    // Not sure if we need this one or not
    // const ISS_DELETE_TARGET = 'deleteTarget';

    const ISS_ADD_TARGET_TO_ACCOUNTSET = 'addTargetToAccountset';
    const ISS_DELETE_TARGET_FROM_ACCOUNTSET = 'deleteTargetFromAccountset';

    const ISS_ADD_ACCOUNTSET = 'addAccountset';
    const ISS_DELETE_ACCOUNTSET = 'deleteAccountset';
    const ISS_UPDATE_ACCOUNTSET = 'updateAccountset';

    // "batch" operations
    const ISS_DELETE_ACCOUNTSETS = 'deleteAccountsets';
    const ISS_DELETE_TARGETS = 'deleteTargets';

    const ISS_RECORD_NEW_INSTANCE = 'recordNewInstance';
    const ISS_SYNCHRONIZE_INSTANCE = 'synchronizeInstance';
    const ISS_DELETE_INSTANCE = 'deleteInstance';
    const ISS_INIT_CLONE_INSTANCE = 'cloneInstance';

    const ISS_SYNCHRONIZE_INSTANCE_COMPLETED = 'synchronizeInstanceCompleted';
    const ISS_RECORD_NEW_INSTANCE_COMPLETED = 'recordNewInstanceCompleted';
    const ISS_INIT_CLONE_INSTANCE_COMPLETED = 'cloneInstanceCompleted';

    const ISS_DISABLE_NOTIFICATIONS = 'disableNotifications';
    const ISS_ENABLE_NOTIFICATIONS = 'enableNotifications';

    const ISS_UPDATE_LICENSE = 'updateLicense';
}
