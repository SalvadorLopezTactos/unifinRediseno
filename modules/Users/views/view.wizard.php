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
/*********************************************************************************
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once 'modules/Users/Forms.php';

class ViewWizard extends SugarView
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->options['show_header'] = false;
        $this->options['show_javascript'] = false;
    }

    /**
     * @see SugarView::display()
     */
    public function display()
    {
        global $mod_strings, $current_user, $locale, $sugar_config, $app_list_strings, $sugar_version;

        $themeObject = SugarThemeRegistry::current();
        $css = $themeObject->getCSS();
        $this->ss->assign('SUGAR_CSS', $css);
        $favicon = $themeObject->getImageURL('sugar-favicon.png', false);
        $this->ss->assign('FAVICON_URL', getJSPath($favicon));
        $this->ss->assign('CSS', '<link rel="stylesheet" type="text/css" href="' . SugarThemeRegistry::current()->getCSSURL('wizard.css') . '" />');
        $this->ss->assign('JAVASCRIPT', user_get_validate_record_js() . user_get_chooser_js() . user_get_confsettings_js());
        $this->ss->assign('SKIP_WELCOME', isset($_REQUEST['skipwelcome']) && $_REQUEST['skipwelcome'] == 1);
        $this->ss->assign('ID', $current_user->id);
        $this->ss->assign('USER_NAME', $current_user->user_name);
        $this->ss->assign('FIRST_NAME', $current_user->first_name);
        $this->ss->assign('SUGAR_VERSION', $sugar_version);
        $this->ss->assign('LAST_NAME', $current_user->last_name);
        $this->ss->assign('TITLE', $current_user->title);
        $this->ss->assign('DEPARTMENT', $current_user->department);
        $this->ss->assign('REPORTS_TO_ID', $current_user->reports_to_id);
        $this->ss->assign('REPORTS_TO_NAME', $current_user->reports_to_name);
        $this->ss->assign('PHONE_HOME', $current_user->phone_home);
        $this->ss->assign('PHONE_MOBILE', $current_user->phone_mobile);
        $this->ss->assign('PHONE_WORK', $current_user->phone_work);
        $this->ss->assign('PHONE_OTHER', $current_user->phone_other);
        $this->ss->assign('PHONE_FAX', $current_user->phone_fax);
        $this->ss->assign('EMAIL1', $current_user->email1);
        $this->ss->assign('EMAIL2', $current_user->email2);
        $this->ss->assign('ADDRESS_STREET', $current_user->address_street);
        $this->ss->assign('ADDRESS_CITY', $current_user->address_city);
        $this->ss->assign('ADDRESS_STATE', $current_user->address_state);
        $this->ss->assign('ADDRESS_POSTALCODE', $current_user->address_postalcode);
        $this->ss->assign('ADDRESS_COUNTRY', $current_user->address_country);
        $configurator = new Configurator();
        if ($configurator->config['passwordsetting']['SystemGeneratedPasswordON']
            || $configurator->config['passwordsetting']['forgotpasswordON']) {
            $this->ss->assign('REQUIRED_EMAIL_ADDRESS', '1');
        } else {
            $this->ss->assign('REQUIRED_EMAIL_ADDRESS', '0');
        }

        // get javascript
        ob_start();
        $this->options['show_javascript'] = true;
        $this->renderJavascript();
        $this->options['show_javascript'] = false;
        $this->ss->assign('SUGAR_JS', ob_get_contents() . $themeObject->getJS());
        ob_end_clean();

        $messenger_type = '<select tabindex="5" name="messenger_type">';
        $messenger_type .= get_select_options_with_id($app_list_strings['messenger_type_dom'], $current_user->messenger_type);
        $messenger_type .= '</select>';
        $this->ss->assign('MESSENGER_TYPE_OPTIONS', $messenger_type);
        $this->ss->assign('MESSENGER_ID', $current_user->messenger_id);

        // set default settings
        $use_real_names = $current_user->getPreference('use_real_names');
        if (empty($use_real_names)) {
            $current_user->setPreference('use_real_names', 'on');
        }
        $current_user->setPreference('reminder_time', 1800);
        $current_user->setPreference('mailmerge_on', 'on');

        //// Timezone
        if (empty($current_user->id)) { // remove default timezone for new users(set later)
            $current_user->user_preferences['timezone'] = '';
        }

        $userTZ = $current_user->getPreference('timezone');
        if (empty($userTZ) && !$current_user->is_group && !$current_user->portal_only) {
            $userTZ = TimeDate::guessTimezone();
            $current_user->setPreference('timezone', $userTZ);
        }

        if (!$current_user->getPreference('ut')) {
            $this->ss->assign('PROMPTTZ', ' checked');
        }

        $this->ss->assign('TIMEZONE_CURRENT', $userTZ);
        $this->ss->assign('TIMEZONEOPTIONS', TimeDate::getTimezoneList());

        //// Numbers and Currency display
        $currency = new ListCurrency();

        // 10/13/2006 Collin - Changed to use Localization.getConfigPreference
        // This was the problem- Previously, the "-99" currency id always assumed
        // to be defaulted to US Dollars.  However, if someone set their install to use
        // Euro or other type of currency then this setting would not apply as the
        // default because it was being overridden by US Dollars.
        $cur_id = $locale->getPrecedentPreference('currency', $current_user);
        if ($cur_id) {
            $selectCurrency = $currency->getSelectOptions($cur_id);
            $this->ss->assign('CURRENCY', $selectCurrency);
        } else {
            $selectCurrency = $currency->getSelectOptions();
            $this->ss->assign('CURRENCY', $selectCurrency);
        }

        $currenciesArray = $locale->getCurrencies();
        $currenciesVars = $this->correctCurrenciesSymbolsSort($currenciesArray);

        $currencySymbolsJs = <<<eoq
var currencies = new Object;
{$currenciesVars}
function setSymbolValue(id) {
	document.getElementById('symbol').value = currencies[id];
}
eoq;
        $this->ss->assign('currencySymbolJs', $currencySymbolsJs);


        // fill significant digits dropdown
        $significantDigits = $locale->getPrecedentPreference('default_currency_significant_digits', $current_user);
        $sigDigits = '';
        for ($i = 0; $i <= 6; $i++) {
            if ($significantDigits == $i) {
                $sigDigits .= "<option value=\"$i\" selected=\"true\">$i</option>";
            } else {
                $sigDigits .= "<option value=\"$i\">{$i}</option>";
            }
        }

        $this->ss->assign('sigDigits', $sigDigits);

        $num_grp_sep = $current_user->getPreference('num_grp_sep');
        $dec_sep = $current_user->getPreference('dec_sep');
        $this->ss->assign('NUM_GRP_SEP', (empty($num_grp_sep) ? $sugar_config['default_number_grouping_seperator'] : $num_grp_sep));
        $this->ss->assign('DEC_SEP', (empty($dec_sep) ? $sugar_config['default_decimal_seperator'] : $dec_sep));
        $this->ss->assign('getNumberJs', $locale->getNumberJs());

        //// Name display format
        $this->ss->assign('default_locale_name_format', $locale->getLocaleFormatMacro($current_user));
        $this->ss->assign('getNameJs', $locale->getNameJs());

        $this->ss->assign('TIMEOPTIONS', get_select_options_with_id($sugar_config['time_formats'], $current_user->_userPreferenceFocus->getDefaultPreference('default_time_format')));
        $this->ss->assign('DATEOPTIONS', get_select_options_with_id($sugar_config['date_formats'], $current_user->_userPreferenceFocus->getDefaultPreference('default_date_format')));
        $this->ss->assign('MAIL_SENDTYPE', get_select_options_with_id($app_list_strings['notifymail_sendtype'], $current_user->getPreference('mail_sendtype')));
        $this->ss->assign('NEW_EMAIL', $current_user->emailAddress->getEmailAddressWidgetEditView($current_user->id, $current_user->module_dir));
        $this->ss->assign('EMAIL_LINK_TYPE', get_select_options_with_id($app_list_strings['dom_email_link_type'], $current_user->getPreference('email_link_type')));

        $selectedLocaleNameFormat = $current_user->_userPreferenceFocus->getDefaultPreference('default_locale_name_format');
        if (array_key_exists($selectedLocaleNameFormat, $sugar_config['name_formats'])) {
            $selectedLocaleNameFormat = $sugar_config['default_locale_name_format'];
        }
        $this->ss->assign('NAMEOPTIONS', get_select_options_with_id($locale->getUsableLocaleNameOptions($sugar_config['name_formats']), $selectedLocaleNameFormat));

        // email smtp
        $systemOutboundEmail = new OutboundEmail();
        $systemOutboundEmail = $systemOutboundEmail->getSystemMailerSettings();
        $mail_smtpserver = $systemOutboundEmail->mail_smtpserver;
        $mail_smtptype = $systemOutboundEmail->mail_smtptype;
        $mail_smtpport = $systemOutboundEmail->mail_smtpport;
        $mail_smtpssl = $systemOutboundEmail->mail_smtpssl;
        $mail_smtpdisplay = $systemOutboundEmail->mail_smtpdisplay;
        $mail_smtpuser = '';
        $mail_smtppass = '';
        $hide_if_can_use_default = true;
        $mail_smtpauth_req = true;
        if (!empty($mail_smtpserver) && !empty($mail_smtptype)) {
            if (!$systemOutboundEmail->isAllowUserAccessToSystemDefaultOutbound()) {
                $mail_smtpauth_req = $systemOutboundEmail->mail_smtpauth_req;
                $userOverrideOE = $systemOutboundEmail->getUsersMailerForSystemOverride($current_user->id);
                if ($userOverrideOE != null) {
                    $mail_smtpuser = $userOverrideOE->mail_smtpuser;
                    $mail_smtppass = $userOverrideOE->mail_smtppass;
                }
                if (!$mail_smtpauth_req &&
                    (empty($systemOutboundEmail->mail_smtpserver) || empty($systemOutboundEmail->mail_smtpuser)
                        || empty($systemOutboundEmail->mail_smtppass))) {
                    $hide_if_can_use_default = true;
                } else {
                    $hide_if_can_use_default = false;
                }
            }
        }

        $isAdmin = is_admin($current_user);
        $this->ss->assign('IS_ADMIN', $isAdmin);

        $this->ss->assign('mail_smtpdisplay', $mail_smtpdisplay);
        $this->ss->assign('mail_smtpuser', $mail_smtpuser);
        $this->ss->assign('mail_smtppass', $mail_smtppass);
        $this->ss->assign('mail_smtpserver', $mail_smtpserver);
        $this->ss->assign('mail_smtpauth_req', $mail_smtpauth_req);
        $this->ss->assign('MAIL_SMTPPORT', $mail_smtpport);
        $this->ss->assign('MAIL_SMTPSSL', $mail_smtpssl);

        $this->ss->assign('HIDE_IF_CAN_USE_DEFAULT_OUTBOUND', $hide_if_can_use_default);
        $this->ss->assign('langHeader', get_language_header());
        $this->ss->display($this->getCustomFilePathIfExists('modules/Users/tpls/wizard.tpl'));
    }

    /**
     * Function to sort currencies in array alphabetically, except for US Dollar which must remain as first element
     * in the array.
     *
     * @param array $currenciesArray Array of currencies to sort
     * @return array|string Array of sorted currencies with the US Dollar as the first
     */
    public function correctCurrenciesSymbolsSort($currenciesArray)
    {
        $baseCurrencyId = '-99';
        $newCurrenciesArray = [];

        $newCurrenciesArray[] = $currenciesArray[$baseCurrencyId]['symbol'];
        array_shift($currenciesArray);
        $currenciesArray = array_csort($currenciesArray);
        foreach ($currenciesArray as $value) {
            $newCurrenciesArray[] = $value['symbol'];
        }
        return $this->pushCurrencyArrayToString($newCurrenciesArray);
    }

    /**
     * Generates javascript array from a php array
     *
     * @param $array
     * @return array|string Javascript code snippet of currencies array
     * @see correctCurrenciesSymbolsSort
     */
    public function pushCurrencyArrayToString($array)
    {
        $return = '';
        foreach ($array as $key => $value) {
            $return .= "currencies[{$key}] = '{$value}';\n";
        }
        return $return;
    }
}
