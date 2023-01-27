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
namespace Sugarcrm\Sugarcrm\UserUtils\Constants;

/**
 * The CommandType class contains all the command types
 */
abstract class CommandType
{
    const CopyDashboards = 'CopyDashboards';
    const DeleteDashboards = 'DeleteDashboards';
    const CopyFilters = 'CopyFilters';
    const DeleteFilters = 'DeleteFilters';
    const CloneDashboards = 'CloneDashboards';
    const CloneFilters = 'CloneFilters';
    const CloneFavoriteReports = 'CloneFavoriteReports';
    const CloneSugarEmailClient = 'CloneSugarEmailClient';
    const CloneScheduledReporting = 'CloneScheduledReporting';
    const CloneNotifyOnAssignment = 'CloneNotifyOnAssignment';
    const CloneRemindersOptions = 'CloneRemindersOptions';
    const CloneDefaultTeams = 'CloneDefaultTeams';
    const CloneNavigationBar = 'CloneNavigationBar';
    const CloneUserSettings = 'CloneUserSettings';
    const BroadcastMessage = 'BroadcastMessage';
}
