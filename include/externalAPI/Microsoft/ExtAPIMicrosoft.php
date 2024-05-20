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
class ExtAPIMicrosoft extends ExtAPIMicrosoftEmail
{
    public const SCOPES_AUTHORIZE = array(
        'offline_access',
        'https://graph.microsoft.com/User.Read',
        'https://graph.microsoft.com/Files.ReadWrite.All',
    );
    public const SCOPES_GRAPH_API = array(
        'offline_access',
        'https://graph.microsoft.com/User.Read',
        'https://graph.microsoft.com/Files.ReadWrite.All',
    );

    public const SCOPES_DRIVE_API = array(
        'offline_access',
        'https://graph.microsoft.com/Files.ReadWrite.All',
    );

    /**
     * Returns the authorization URL used by the frontend to initialize the user
     * authorization process
     *
     * @return string
     */
    public function getAuthURL() : string
    {
        $config = $this->getMicrosoftOauth2Config();
        $params = array(
            'client_id' => $config['properties']['oauth2_client_id'],
            'redirect_uri' => $config['redirect_uri'],
            'response_type' => 'code',
            'prompt' => 'select_account',
            'scope' => implode(' ', self::SCOPES_AUTHORIZE),
            'state' => 'drive',
        );

        return self::URL_AUTHORIZE . '?' . http_build_query($params);
    }

    /**
     * Authenticates a user's authorization code with Microsoft servers. On success,
     * returns the token information as well as the ID of the EAPM bean created
     * to store the token information
     *
     * @param string $code the authorization code to authenticate
     * @return array|bool the token and EAPM information if successful; false otherwise
     */
    public function authenticate($code)
    {
        // Authenticate the authorization code with Microsoft servers
        $token = $this->getAccessTokenFromServer('authorization_code', [
            'code' => $code,
            'scope' => implode(' ', self::SCOPES_DRIVE_API),
        ]);

        // If we are successful, save the new token data in the database
        $eapmId = null;
        $eapm = EAPM::getLoginInfo('Microsoft');
        if (!is_null($eapm->id)) {
            $eapmId = $eapm->id;
        }
        if (!empty($token)) {
            $eapmId = $this->saveToken(json_encode($token), $eapmId);
        }

        // Return the token and account information
        return array(
            'token' => $token,
            'eapmId' => $eapmId,
            'emailAddress' => $this->getEmailAddress($eapmId),
            'userName' => $this->getUserName($eapmId),
        );
    }
}
