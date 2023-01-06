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
namespace Sugarcrm\Sugarcrm\Hint\Queue;

class EventTypes
{
    const MIXED = 'mixed';

    const INSTANCE_INIT = 'recordNewInstance';
    const INSTANCE_INIT_CLONE = 'cloneInstance';
    const INSTANCE_RESYNC = 'synchronizeInstance';
    const INSTANCE_DELETE = 'deleteInstance';

    const INSTANCE_INIT_COMPLETED = 'recordNewInstanceCompleted';
    const INSTANCE_INIT_CLONE_COMPLETED = 'cloneInstanceCompleted';
    const INSTANCE_RESYNC_COMPLETED = 'synchronizeInstanceCompleted';

    const INSTANCE_DISABLE_NOTIFICATIONS = 'disableNotifications';
    const INSTANCE_ENABLE_NOTIFICATIONS = 'enableNotifications';

    const FAVORITE_ADD = 'favoriteAdd'; // before 5.1
    const FAVORITE_DELETE = 'favoriteDelete'; // before 5.1

    const ACCOUNT_ADD_ONE = 'accountAdd';
    const ACCOUNT_DELETE = 'accountDelete'; // before 5.1
    const ACCOUNT_DELETE_ONE = 'accountDeleteOne';
    const ACCOUNT_DELETE_ALL = 'accountDeleteAll';
    const ACCOUNT_UPDATE = 'accountUpdate';

    const ACCOUNT_OWNER_ADD = 'accountOwnerAdd'; // before 5.1
    const ACCOUNT_OWNER_DELETE = 'accountOwnerDelete'; // before 5.1

    const ACCOUNT_TAG_ADD = 'accountTagAdd'; // before 5.1
    const ACCOUNT_TAG_DELETE = 'accountTagDelete'; // before 5.1

    const USER_DELETE = 'userDelete'; // before 5.1
    const USER_EMAIL_UPDATE = 'userEmailUpdate'; // before 5.1

    const UPDATE_LICENSE = 'updateLicense'; // 5.4.0

    const TARGET_ADD = 'targetAdd';
    const TARGET_DELETE = 'targetDelete'; // not used
    const TARGET_DELETE_ALL = 'targetDeleteAll'; // batch
    const TARGET_UPDATE = 'targetUpdate';

    const ACCOUNTSET_ADD = 'accountsetAdd'; // before 5.1
    const ACCOUNTSET_ADD_ONE = 'accountsetAddOne';
    const ACCOUNTSET_DELETE = 'accountsetDelete';
    const ACCOUNTSET_DELETE_ALL = 'accountsetDeleteAll'; // batch
    const ACCOUNTSET_UPDATE = 'accountsetUpdate';
    const ACCOUNTSET_TYPE_UPDATE = 'accountsetTypeUpdate'; // before 5.1

    const ACCOUNTSET_ADD_TARGET = 'accountsetAddTarget';
    const ACCOUNTSET_DELETE_TARGET = 'accountsetDeleteTarget';

    const ACCOUNTSET_ADD_TAG = 'accountsetAddTag'; // before 5.1
    const ACCOUNTSET_DELETE_TAG = 'accountsetDeleteTag'; // before 5.1
}
