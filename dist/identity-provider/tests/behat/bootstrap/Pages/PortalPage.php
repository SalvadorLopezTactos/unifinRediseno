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

namespace Sugarcrm\IdentityProvider\IntegrationTests\Bootstrap\Pages;

class PortalPage extends LoginPage
{
    protected $path = '/portal/';
    protected $portalElementCss = "div#portal";
    protected $userMenuCss = "#userList";
    protected $logoutCss = "i.fa-sign-out";

    protected $acceptUseCookiesCheckBoxCss = 'div.consent-cookie input[type=checkbox]';
    protected $acceptUseCookiesBtnCss = 'a.btn-primary';

    /**
     * Is user on portal page
     * @return bool
     */
    public function isPortalPage()
    {
        $this->waitForElement($this->portalElementCss);
        $portalElements = $this->findAll('css', $this->portalElementCss);
        return count($portalElements) > 0;
    }

    /**
     * Logout from portal
     */
    public function logout()
    {
        $this->clickByCss($this->userMenuCss);
        $this->clickByCss($this->logoutCss);
        $this->waitLoadingDisappear();
        $this->waitAjaxComplete();
    }

    /**
     * Accept Use Cookies after firs login
     */
    public function acceptUseCookies()
    {
        $this->clickByCss($this->acceptUseCookiesCheckBoxCss);
        $this->clickByCss($this->acceptUseCookiesBtnCss);
        $this->waitAjaxComplete();
    }
}
