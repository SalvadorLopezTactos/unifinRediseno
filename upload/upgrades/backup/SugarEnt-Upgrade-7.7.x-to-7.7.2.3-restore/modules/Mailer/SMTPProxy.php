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

class SMTPProxy
{
    /**
     * @var SMTP
     * An SMTP object from PHPMailer.
     */
    protected $smtp;

    /**
     * Creates an PHPMailer SMTP object to which this object proxies.
     */
    public function __construct()
    {
        $this->smtp = new SMTP();
    }

    /**
     * Calls the named method on the SMTP object and returns its return value.
     *
     * Handles any errors that are encountered.
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        $result = call_user_func_array(array($this->smtp, $method), $args);
        $this->handleError($this->smtp->getError());

        return $result;
    }

    /**
     * Logs the error if one exists.
     *
     * @param array
     */
    protected function handleError($error = array())
    {
        if (empty($error)) {
            return;
        }

        $message = array('SMTP ->');
        $level = 'warn';

        if (is_array($error)) {
            if (array_key_exists('error', $error)) {
                $message[] = "ERROR: {$error['error']}.";
            }

            $hasErrno = array_key_exists('errno', $error);
            $hasSmtpCode = array_key_exists('smtp_code', $error);

            if ($hasErrno || $hasSmtpCode) {
                // the presence of 'errno' or 'smtp_code' keys seems to indicate that a more serious error occurred
                // it was likely a failure when attempting to talk with an SMTP server
                $level = 'fatal';
            }

            if ($hasErrno) {
                $message[] = "Code: {$error['errno']}";
            } elseif ($hasSmtpCode) {
                $message[] = "Code: {$error['smtp_code']}";
            }

            if (array_key_exists('errstr', $error)) {
                $message[] = "Reply: {$error['errstr']}";
            } elseif (array_key_exists('detail', $error)) {
                $message[] = "Reply: {$error['detail']}";
            } elseif (array_key_exists('smtp_msg', $error)) {
                // kept around for legacy support
                // PHPMailer no longer uses 'smtp_msg'; 'detail' is used instead
                $message[] = "Reply: {$error['smtp_msg']}";
            }
        } else {
            $message[] = "ERROR: {$error}";
        }

        $GLOBALS['log']->$level(implode(' ', $message));
    }
}
