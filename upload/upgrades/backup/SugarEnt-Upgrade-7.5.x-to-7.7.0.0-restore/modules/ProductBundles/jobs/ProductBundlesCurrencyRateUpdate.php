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

require_once('include/SugarCurrency/CurrencyRateUpdateAbstract.php');

/**
 * OpportunitiesCurrencyRateUpdate
 *
 * A class for updating currency rates on specified database table columns
 * when a currency conversion rate is updated by the administrator.
 *
 */
class ProductBundlesCurrencyRateUpdate extends CurrencyRateUpdateAbstract
{
    /**
     * constructor
     *
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        // set rate field definitions
        $this->addRateColumnDefinition('product_bundles', 'base_rate');
        // set usdollar field definitions
        $this->addUsDollarColumnDefinition('product_bundles', 'total', 'total_usdollar');
        $this->addUsDollarColumnDefinition('product_bundles', 'subtotal', 'subtotal_usdollar');
        $this->addUsDollarColumnDefinition('product_bundles', 'shipping', 'shipping_usdollar');
        $this->addUsDollarColumnDefinition('product_bundles', 'deal_tot', 'deal_tot_usdollar');
        $this->addUsDollarColumnDefinition('product_bundles', 'new_sub', 'new_sub_usdollar');
        $this->addUsDollarColumnDefinition('product_bundles', 'tax', 'tax_usdollar');
    }

}
