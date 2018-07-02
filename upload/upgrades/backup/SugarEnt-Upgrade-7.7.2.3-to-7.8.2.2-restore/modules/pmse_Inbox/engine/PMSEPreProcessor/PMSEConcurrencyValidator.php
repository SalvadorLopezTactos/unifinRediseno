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

require_once 'modules/pmse_Inbox/engine/PMSEPreProcessor/PMSEValidate.php';
require_once 'modules/pmse_Inbox/engine/PMSELogger.php';

use  Sugarcrm\Sugarcrm\Util\Arrays\ArrayFunctions\ArrayFunctions;

/**
 * Description of PMSEConcurrencyValidator
 * The concurrency validator class purpose is to filter duplicate requests
 * from the same event and process since it's possible to send twice the data
 * from a direct request.
 *
 */
class PMSEConcurrencyValidator implements PMSEValidate
{
    /**
     *
     * @var PMSELogger
     */
    protected $logger;

    /**
     * Class constructor.
     * Retrieving the logger instance from the singleton.
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->logger = PMSELogger::getInstance();
    }

    /**
     *
     * @return PMSELogger
     * @codeCoverageIgnore
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     *
     * @param PMSELogger $logger
     * @codeCoverageIgnore
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }


    /**
     * Validates that if a second request from the same event and bean record
     * is received, the second request should be invalidated and thus ignored.
     * @param PMSERequest $request
     * @return \PMSERequest
     */
    public function validateRequest(PMSERequest $request)
    {
        $this->logger->info("Validate Request " . get_class($this));
        $this->logger->debug(array("Request data:", $request));

        $args = $request->getArguments();
        $flowId = isset($args['idFlow']) ? $args['idFlow'] : (isset($args['flow_id']) ? $args['flow_id'] : '0');
        if (!isset($_SESSION['locked_flows']) || !ArrayFunctions::in_array_access($flowId, $_SESSION['locked_flows'])) {
            $request->validate();
        } else {
            $request->invalidate();
        }
        return $request;
    }
}
