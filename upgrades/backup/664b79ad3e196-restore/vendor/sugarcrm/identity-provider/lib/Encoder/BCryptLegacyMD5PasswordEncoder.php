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

namespace Sugarcrm\IdentityProvider\Encoder;

/**
 * Supports legacy SOAP integrations with MD5 passwords
 */
class BCryptLegacyMD5PasswordEncoder extends BCryptPasswordEncoder
{
    /**
     * {@inheritdoc}
     *
     * @param string $raw  The password to encode
     * @param string $salt The salt
     *
     * @return string The encoded password
     *
     * @throws BadCredentialsException when the given password is too long
     */
    public function encodePassword($raw, $salt)
    {
        return parent::encodePassword(md5($raw), $salt);
    }
}
