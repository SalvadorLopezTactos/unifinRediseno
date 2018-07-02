<?php
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

namespace Sugarcrm\Sugarcrm\JobQueue\Exception;

/**
 * Class UnexpectedResolutionException.
 * @package JobQueue
 */
class UnexpectedResolutionException extends RuntimeException implements ExceptionInterface
{
    /**
     * @var string $resolution Job resolution.
     */
    protected $resolution;

    /**
     * {@inheritdoc}
     * @param string $resolution Caused the exception.
     */
    public function __construct($resolution, $message = "", $code = 0, \Exception $previous = null)
    {
        $this->resolution = $resolution;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getResolution()
    {
        return $this->resolution;
    }
}
