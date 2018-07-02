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
require_once 'modules/pmse_Inbox/engine/PMSEPreProcessor/PMSEValidationLevel.php';

use Sugarcrm\Sugarcrm\ProcessManager;

class PMSEValidator
{
    /**
     *
     * @var type
     */
    protected $type;

    /**
     *
     * @var type
     */
    protected $validators;

    /**
     *
     * @var PMSELogger
     */
    protected $logger;

    /**
     * List of known validator classes to be used in the retrieveValidator method
     * @var array
     */
    protected $validatorClasses = [
        'terminate' => 'PMSETerminateValidator',
        'concurrency' => 'PMSEConcurrencyValidator',
        'record' => 'PMSERecordValidator',
        'element' => 'PMSEElementValidator',
        'expression' => 'PMSEExpressionValidator'
    ];

    /**
     * Class constructor
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->logger = PMSELogger::getInstance();

        $this->validators = array(
            'direct' => array(
                'terminate' => PMSEValidationLevel::NoValidation,
                'concurrency' => PMSEValidationLevel::Simple,
                'record' => PMSEValidationLevel::NoValidation,
                'element' => PMSEValidationLevel::NoValidation,
                'expression' => PMSEValidationLevel::NoValidation
            ),
            'hook' => array(
                'terminate' => PMSEValidationLevel::Simple,
                'concurrency' => PMSEValidationLevel::NoValidation,
                'record' => PMSEValidationLevel::Simple,
                'element' => PMSEValidationLevel::Simple,
                'expression' => PMSEValidationLevel::Simple
            ),
            'engine' => array(
                'terminate' => PMSEValidationLevel::NoValidation,
                'concurrency' => PMSEValidationLevel::NoValidation,
                'record' => PMSEValidationLevel::NoValidation,
                'element' => PMSEValidationLevel::NoValidation,
                'expression' => PMSEValidationLevel::NoValidation
            ),
            'queue' => array(
                'terminate' => PMSEValidationLevel::NoValidation,
                'concurrency' => PMSEValidationLevel::Simple,
                'record' => PMSEValidationLevel::NoValidation,
                'element' => PMSEValidationLevel::NoValidation,
                'expression' => PMSEValidationLevel::NoValidation
            ),
        );
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getValidators()
    {
        return $this->validators;
    }

    /**
     *
     * @param type $validators
     */
    public function setValidators($validators)
    {
        $this->validators = $validators;
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
     *
     * @param type $type
     * @codeCoverageIgnore
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     *
     * @param type $name
     * @param type $level
     * @return boolean|PMSEBaseValidator
     * @codeCoverageIgnore
     */
    public function retrieveValidator($name, $level)
    {
        $this->logger->debug("Retrieving a " . $name . " validator");
        $validator = false;
        if (isset($this->validatorClasses[$name])) {
            $validator = ProcessManager\Factory::getPMSEObject($this->validatorClasses[$name]);
            if ($validator) {
                $validator->setLevel($level);
            }
        }
        return $validator;
    }

    /**
     *
     * @return \PMSERequest
     * @codeCoverageIgnore
     */
    public function generateNewRequest()
    {
        return ProcessManager\Factory::getPMSEObject('PMSERequest');
    }

    /**
     *
     * @param PMSERequest $request
     * @return type
     */
    public function validateRequest(PMSERequest $request)
    {
        $this->logger->info("Start validation process.");
        $this->logger->debug(array("Request Data to be validated: ", $request));
        // A default request is always valid, if fails to validate in any validator 
        // the status is set to invalid and no further validation is required
        if (!isset($this->validators[$request->getType()])) {
            $this->logger->info("Invalid Request");
            return false;
        }
        foreach ($this->validators[$request->getType()] as $validatorName => $validatorLevel) {
            if ($validatorLevel != PMSEValidationLevel::NoValidation) {
                $validator = $this->retrieveValidator($validatorName, $validatorLevel);
                $request = $validator->validateRequest($request);
                if (!$request->isValid()) {
                    $this->logger->info(get_class($validator) . " validator invalidated request.");
                    return $request;
                } else {
                    $this->logger->info(get_class($validator) . " validator validated request.");
                }
            }
        }
        $this->logger->info("Request validated successfully");
        $request->setStatus('PROCESSED');
        return $request;
    }

}
