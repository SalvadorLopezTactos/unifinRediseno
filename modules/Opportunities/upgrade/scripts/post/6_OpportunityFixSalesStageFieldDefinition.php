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

class SugarUpgradeOpportunityFixSalesStageFieldDefinition extends UpgradeScript
{
    public $order = 6500;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        if (!$this->toFlavor('ent') || !version_compare($this->from_version, '9.1.0', '<')) {
            return;
        }

        $settings = Opportunity::getSettings();
        if ($settings['opps_view_by'] !== 'RevenueLineItems') {
            $this->log('Not using Revenue Line Items; Skipping Upgrade Script');
            return;
        }

        $this->oppBean = BeanFactory::newBean('Opportunities');
        $this->standardField = new StandardField('Opportunities');
        $this->enumTemplateField = get_widget('enum');

        $this->fixSalesStageFieldDefinition();
    }

    protected function fixSalesStageFieldDefinition()
    {
        // get the get_widget helper and the StandardField Helper
        require_once('modules/DynamicFields/FieldCases.php');

        // the field set we need
        $fieldDef = $this->oppBean->getFieldDefinition('sales_stage');

        $this->enumTemplateField->populateFromRow($fieldDef);
        $this->enumTemplateField->calculated = true;
        $this->enumTemplateField->formula = 'opportunitySalesStage($revenuelineitems, "sales_stage")';
        $this->enumTemplateField->readonly = true;
        $this->enumTemplateField->enforced = true;
        $this->enumTemplateField->studio = true;

        // now lets save, since these are OOB field, we use StandardField
        $this->standardField->setup($this->oppBean);

        $this->enumTemplateField->module = $this->oppBean;
        $this->enumTemplateField->save($this->standardField);
    }
}
