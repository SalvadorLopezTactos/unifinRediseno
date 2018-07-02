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

/**
 * SAML class for SLO requests
 */
class OneLogin_Saml_LogoutRequest extends OneLogin_Saml_AuthRequest
{
    /**
     * Get URL for logout request
     * @return string
     */
    public function getLogoutUrl()
    {
        $id = $this->_generateUniqueID();
        $issueInstant = $this->_getTimestamp();
        $nameIdValue = $this->_generateUniqueID();

        $logoutRequest = <<<LOGOUTREQUEST
        <samlp:LogoutRequest
            xmlns:samlp="urn:oasis:names:tc:SAML:2.0:protocol"
            xmlns:saml="urn:oasis:names:tc:SAML:2.0:assertion"
            ID="{$id}"
            Version="2.0"
            IssueInstant="{$issueInstant}"
            Destination="{$GLOBALS['sugar_config']['SAML_SLO']}">
            <saml:Issuer>{$GLOBALS['sugar_config']['site_url']}</saml:Issuer>
            <samlp:NameID Format="{$this->_settings->requestedNameIdFormat}" SPNameQualifier="{$GLOBALS['sugar_config']['site_url']}">
            $nameIdValue
            </samlp:NameID>
        </samlp:LogoutRequest>
LOGOUTREQUEST;
        $deflatedRequest = gzdeflate($logoutRequest);
        $base64Request = base64_encode($deflatedRequest);
        $encodedRequest = urlencode($base64Request);
        return $GLOBALS['sugar_config']['SAML_SLO'] . "?SAMLRequest=" . $encodedRequest;
    }
}
