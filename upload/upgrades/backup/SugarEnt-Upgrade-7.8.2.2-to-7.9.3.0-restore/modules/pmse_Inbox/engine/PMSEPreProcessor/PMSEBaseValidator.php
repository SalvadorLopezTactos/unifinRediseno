<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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

require_once 'modules/pmse_Inbox/engine/PMSELogger.php';

use Sugarcrm\Sugarcrm\ProcessManager;

/**
 * Description of PMSEBaseValidator
 *
 */
class PMSEBaseValidator
{
    /**
     *
     * @var PMSEEvaluator
     */
    protected $evaluator;

    /**
     *
     * @var Integer
     */
    protected $level;

    /**
     *
     * @var PMSELogger
     */
    protected $logger;

    /**
     *
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->logger = PMSELogger::getInstance();
        $this->evaluator = ProcessManager\Factory::getPMSEObject('PMSEEvaluator');
    }

    /**
     *
     * @return PMSEEvaluator
     * @codeCoverageIgnore
     */
    public function getEvaluator()
    {
        return $this->evaluator;
    }

    /**
     *
     * @return Integer
     * @codeCoverageIgnore
     */
    public function getLevel()
    {
        return $this->level;
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
     * @param PMSEEvaluator $evaluator
     * @codeCoverageIgnore
     */
    public function setEvaluator($evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     *
     * @param Integer $level
     * @codeCoverageIgnore
     */
    public function setLevel($level)
    {
        $this->level = $level;
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
}
