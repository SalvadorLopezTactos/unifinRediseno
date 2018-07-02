<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

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

/* Third-Party Library Imports */

/**
 * Needs the PHPMailer library to set up the proxy.
 */
require_once "vendor/PHPMailer/class.phpmailer.php";

/* Internal Module Imports */

require_once "SMTPProxy.php";

class PHPMailerProxy extends PHPMailer
{
    public function __construct()
    {
        // use PHPMailer with exceptions
        parent::__construct(true);

        // allow an "empty" body to be sent
        $this->AllowEmpty = true;
    }

    public function SmtpConnect($options = array())
    {
        if (!($this->smtp instanceof SMTPProxy)) {
            $this->smtp = new SMTPProxy;
        }

        $result = parent::SmtpConnect($options);
        if ($result === false) {
            throw new phpmailerException($this->Lang('smtp_connect_failed'), self::STOP_CRITICAL);
        }
        return $result;
    }

    public function SetError($msg)
    {
        parent::SetError($msg);

        $class = get_class($this);
        $GLOBALS["log"]->error("{$class} encountered an error: {$this->ErrorInfo}");
    }
}
