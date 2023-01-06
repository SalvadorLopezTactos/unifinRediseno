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


namespace Sugarcrm\Sugarcrm\Maps;

class Constants
{
    const GEOCODE_MODULE = 'Geocode';
    const GEOCODE_SCHEDULER_MODULE = 'GeocodeJob';
    const GEOCODE_SCHEDULER_STATUS_QUEUED = 'QUEUED';
    const GEOCODE_SCHEDULER_STATUS_REQUEUE = 'REQUEUE';
    const GEOCODE_SCHEDULER_STATUS_FAILED = 'FAILED';
    const GEOCODE_SCHEDULER_STATUS_COMPLETED = 'COMPLETED';
    const GEOCODE_SCHEDULER_STATUS_NOT_FOUND = 'NOT_FOUND';
}
