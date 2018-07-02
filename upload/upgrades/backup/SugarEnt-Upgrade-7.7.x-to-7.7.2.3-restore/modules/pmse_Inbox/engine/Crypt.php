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

require_once 'modules/pmse_Inbox/engine/PMSE.php';

/**
 * Helps to encode and encrypt elements that corresponding to the license management module
 *
 * An instance of this class can recovery a cripted licence, can encode whit Blow
 * Fish encode algorithm, can generate a tuned licence and can decode too
 *
 * @package Processmaker
 * @property $validServerCode
 * @property $pmse
 * @property $modulePath
 * @property $moduleName
 */
class Crypt
{
    private $validServerCode = array('00', '21', '22', '23', '11', '12');
    protected $pmse;
    protected $moduleName;

    /**
     * Constructor here set modulePath, pmse, moduleName properties to init an instance of this class
     *
     * @return Crypt
     */


    public function Crypt()
    {
        require_once 'vendor/Pear/Crypt_Blowfish/Blowfish.php';
        $this->pmse = PMSE::getInstance();
        $this->moduleName = $this->pmse->getModuleName();
    }

    /**
     * Uses blowfish to encrypt data and base 64 encodes it. It stores the iv as part of the data
     * @param string key - key to base encoding off of
     * @param string data - string to be encrypted and encoded
     * @return string
     */
    public function blowfishEncode($key, $data, $bf = null)
    {
        if (!$bf) {
            // @codeCoverageIgnoreStart
            $bf = new Crypt_Blowfish($key);

        }// @codeCoverageIgnoreEnd
        $encrypted = $bf->encrypt($data);
        return base64_encode($encrypted);
    }

    /**
     * Uses blowfish to decode data assumes data has been base64 encoded with the iv stored as part of the data
     * @param string key - key to base decoding off of
     * @param string encoded base64 encoded blowfish encrypted data
     * @param object Crypt_Blowfish object
     * @return string
     */
    public function blowfishDecode($key, $encoded, $bf = null)
    {
        $data = base64_decode($encoded);
        if (!$bf) {
            // @codeCoverageIgnoreStart
            $bf = new Crypt_Blowfish($key);

        }// @codeCoverageIgnoreEnd
        return trim($bf->decrypt($data));
    }

    /**
     * Uses blowfish to encrypt data and base 64 encodes it. It stores the iv as part of the data
     * @param string key - key to base encoding off of
     * @param string data - string to be encrypted and encoded
     * @param object Crypt_Blowfish object
     * @return string
     */
    public function generateRequest($key, $data, $bf = null)
    {
        if (!$bf) {
            // @codeCoverageIgnoreStart
            $bf = new Crypt_Blowfish($key);

        }// @codeCoverageIgnoreEnd
        $encrypted = $bf->encrypt($data);
        $encrypted = base64_encode($encrypted);
        $output = "----- BEGIN LICENSE REQUEST -----\n";
        $i = 0;
        $len = strlen($encrypted);
        while ($i + 80 < $len) {
            $output .= substr($encrypted, $i, 80) . "\n";
            $i += 80;
        }
        $output .= substr($encrypted, $i) . "\n";
        $output .= "----- END LICENSE REQUEST -----\n";
        return $output;
    }

    /**
     * Uses blowfish to encrypt data and base 64 encodes it. It stores the iv as part of the data
     * @param string key - key to base encoding off of
     * @param string data - string to be encrypted and encoded
     * @param object Crypt_Blowfish object
     * @return string
     */
    public function openLicense($key, $data, $bf = null)
    {
        $plain = '';
        $encrypted = '';
        $i = 0;
        $part = 0;
        $licenseType = '';
        $data = $data . "\n";
        $len = strlen($data);
        $line = '';
        while ($i < $len) {
            if (substr($data, $i, 1) != "\n") {
                $line .= substr($data, $i, 1);
            } else {
                switch ($part) {
                    case 0:
                        $match = array();
                        if (preg_match("/----- BEGIN (.*) -----/", $line, $match)) {
                            $part = 1;
                            $licenseType = $match[1];
                        }
                        break;
                    case 1:
                        $match = array();
                        if (preg_match("/----- END $licenseType -----/", $line, $match)) {
                            $part = 2;
                        } else {
                            $encrypted .= trim($line);
                        }
                        break;
                    default:
                        # code...
                        break;
                }
                $line = '';
            }
            $i++;
        }

        if ($part != 2) {
            // @codeCoverageIgnoreStart
            throw new Exception(translate('LBL_PMSE_CRYPT_ERROR_LICENSENOTVALID', $this->moduleName));
            // @codeCoverageIgnoreEnd
        } else {
            $data = base64_decode($encrypted);
            if (!$bf) {
                // @codeCoverageIgnoreStart
                $bf = new Crypt_Blowfish($key);

            }// @codeCoverageIgnoreEnd
            return trim($bf->decrypt($data));
        }
    }

    /**
     * Decode the activation code for purposes of the module
     * @param string key - key to base encoding off of
     * @return string
     */
    public function decodeActivationCode($text)
    {
        $resp = new StdClass;
        try {
            $code = 'AXYWETINSHRCDU';

            $text = str_replace('-', '', $text);
            if (strlen($text) % 4 != 0 || strlen($text) > 28) {
                throw new Exception(translate('LBL_PMSE_CRYPT_ERROR_ACLENGTHINVALID', $this->moduleName));
            }

            $output = '';
            for ($i = 0; $i < strlen($text); $i++) {
                $car = substr($text, $i, 1);
                $pos = strpos($code, $car);
                if ($pos !== false) {
                    $ch = chr(ord('-') + $pos);
                } else {
                    // @codeCoverageIgnoreStart
                    $ch = '';
                    // @codeCoverageIgnoreEnd
                }
                $output .= $ch;
            }

            $parts = explode('-', $output);
            if (count($parts) != 3) {
                // @codeCoverageIgnoreStart
                throw new Exception(translate('LBL_PMSE_CRYPT_ERROR_ACLENGTHINVALID', $this->moduleName));
                // @codeCoverageIgnoreEnd
            }

            $serverCode = substr($parts[2], 0, 2);
            if (!in_array($serverCode, $this->validServerCode)) {
                // @codeCoverageIgnoreStart
                throw new Exception(sprintf(translate('LBL_PMSE_CRYPT_ERROR_ACSERVERINVALID', $this->moduleName),
                        $serverCode));
                // @codeCoverageIgnoreEnd
            }

            $resp->success = true;
            $resp->country = chr(substr($parts[0], 0, 2)) . chr(substr($parts[0], 2, 2));
            $resp->licId = $parts[1];
            $resp->server = $serverCode;
            $resp->plain = $resp->country . '-' . $resp->licId . '-' . $resp->server;
        } catch (Exception $e) {
            $resp->success = false;
            $resp->message = $e->getMessage();
        }
        return $resp;
    }
}
