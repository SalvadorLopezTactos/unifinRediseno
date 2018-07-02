<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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



require_once('data/SugarBeanApiHelper.php');

class QuotesApiHelper extends SugarBeanApiHelper
{
    /**
     * Formats the bean so it is ready to be handed back to the API's client. Certain fields will get extra processing
     * to make them easier to work with from the client end.
     *
     * @param $bean SugarBean|ForecastManagerWorksheet The bean you want formatted
     * @param $fieldList array Which fields do you want formatted and returned (leave blank for all fields)
     * @param $options array Currently no options are supported
     * @return array The bean in array format, ready for passing out the API to clients.
     */
    public function formatForApi(SugarBean $bean, array $fieldList = array(), array $options = array())
    {
        // call the legacy method here to load all the data that we need
        $bean->fill_in_additional_detail_fields();

        return parent::formatForApi($bean, $fieldList, $options);
    }

    /**
     * This function sets up shipping and billing address for new Quote.
     *
     * @param SugarBean $bean
     * @param array $submittedData
     * @param array $options
     * @return array
     */
    public function populateFromApi(SugarBean $bean, array $submittedData, array $options = array())
    {
        $data = parent::populateFromApi($bean, $submittedData, $options);

        // Bug #57888 : REST API: Create related quote must populate billing/shipping contact and account
        if ( isset($submittedData['module']) && $submittedData['module'] == 'Contacts' && isset($submittedData['record']) )
        {
            $contactBean = BeanFactory::getBean('Contacts', $submittedData['record']);
            $bean->shipping_contact_id = $submittedData['record'];
            $bean->billing_contact_id = $submittedData['record'];

            $bean->shipping_address_street      = $this->getAddressFormContact ($bean->shipping_address_street, $contactBean, 'address_street' );
            $bean->shipping_address_city        = $this->getAddressFormContact( $bean->shipping_address_city, $contactBean, 'address_city' );
            $bean->shipping_address_state       = $this->getAddressFormContact( $bean->shipping_address_state, $contactBean, 'address_state' );
            $bean->shipping_address_postalcode  = $this->getAddressFormContact( $bean->shipping_address_postalcode, $contactBean, 'address_street' );
            $bean->shipping_address_country     = $this->getAddressFormContact( $bean->shipping_address_country, $contactBean, 'address_street' );

            if ( !empty($contactBean->account_id) )
            {
                $bean->billing_account_id = $contactBean->account_id;
                $bean->billing_address_street      = $this->getAddressFormContact ($bean->billing_address_street, $contactBean, 'address_street' );
                $bean->billing_address_city        = $this->getAddressFormContact( $bean->billing_address_city, $contactBean, 'address_city' );
                $bean->billing_address_state       = $this->getAddressFormContact( $bean->billing_address_state, $contactBean, 'address_state' );
                $bean->billing_address_postalcode  = $this->getAddressFormContact( $bean->billing_address_postalcode, $contactBean, 'address_street' );
                $bean->billing_address_country     = $this->getAddressFormContact( $bean->billing_address_country, $contactBean, 'address_street' );
            }
        }

        return $data;
    }

    protected function getAddressFormContact($bean_property, $bean, $property)
    {
        $primary_property = 'primary_'.$property;
        $alt_property = 'alt_'.$property;
        return !empty($bean_property) ? $bean_property
            : ( isset($bean->$primary_property) ? $bean->$primary_property
                : ( isset($bean->$alt_property) ? $bean->$alt_property
                    : '' ) );
    }
}
