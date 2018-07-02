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

/* Internal Module Imports */

require_once "modules/Mailer/SMTPProxy.php";

class PHPMailerProxy extends PHPMailer
{
    /**
     * {@inheritDoc}
     */
    public $AllowEmpty = true;

    /**
     * {@inheritDoc}
     *
     * Uses PHPMailer with exceptions.
     */
    public function __construct($exceptions = false)
    {
        parent::__construct(true);
    }

    /**
     * {@inheritDoc}
     *
     * @return SMTPProxy
     */
    public function getSMTPInstance()
    {
        if (!($this->smtp instanceof SMTPProxy)) {
            $this->smtp = new SMTPProxy();
        }

        return $this->smtp;
    }

    /**
     * {@inheritDoc}
     */
    protected function setError($msg)
    {
        parent::setError($msg);

        $class = get_class($this);
        $GLOBALS['log']->fatal("{$class} encountered an error: {$this->ErrorInfo}");
    }
}
