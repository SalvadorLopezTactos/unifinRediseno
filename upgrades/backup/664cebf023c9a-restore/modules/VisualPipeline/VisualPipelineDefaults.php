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

class VisualPipelineDefaults
{
    /**
     * Sets up the default PipelineConfig settings
     * @return array The config settings
     */
    public static function setupPipelineSettings()
    {
        $admin = BeanFactory::newBean('Administration');
        // get current settings
        $adminConfig = $admin->getConfigForModule('VisualPipeline');
        $pipelineConfig = self::getDefaults();

        // if admin has already been set up
        if (!empty($adminConfig['is_setup'])) {
            foreach ($adminConfig as $key => $val) {
                $pipelineConfig[$key] = $val;
            }
        }

        foreach ($pipelineConfig as $name => $value) {
            $admin->saveSetting('VisualPipeline', $name, $value, 'base');
        }

        return $pipelineConfig;
    }

    /**
     * Updates the default PipelineConfig settings
     * @param array The new config settings to be updated
     */
    public static function addDefaults($settings)
    {
        $admin = BeanFactory::newBean('Administration');
        // get current settings
        $adminConfig = $admin->getConfigForModule('VisualPipeline');

        $settings = array_merge_recursive($settings, $adminConfig);

        foreach ($settings as $key => $value) {
            $admin->saveSetting('VisualPipeline', $key, $value, 'base');
        }
    }

    /**
     * Returns the default values for Tile View to use
     *
     * @param int $isSetup pass in if you want is_setup to be 1 or 0, 0 by default
     * @return array default config settings for Tile View to use
     */
    public static function getDefaults($isSetup = 0)
    {
        // If isSetup happens to get passed as a boolean false, change to 0 for the db
        if ($isSetup === false) {
            $isSetup = 0;
        }

        // default Tile View config setup
        return array(
            // this is used to indicate whether the admin wizard should be shown on first run (for admin only, otherwise a message telling a non-admin to tell their admin to set it up)
            'is_setup' => $isSetup,
            // which modules can use pipeline
            'enabled_modules' => array(
                'Cases',
                'Opportunities',
                'Tasks',
                'Leads',
            ),
            'table_header' => array(
                'Cases' => 'status',
                'Opportunities' => 'sales_stage',
                'Tasks' => 'status',
                'Leads' => 'status',
            ),
            'hidden_values' => array(
                'Cases' => array(),
                'Opportunities' => array(
                    'Closed Won',
                    'Closed Lost',
                ),
                'Tasks' => array(),
                'Leads' => array(),
            ),
            'tile_header' => array(
                'Cases' => 'name',
                'Opportunities' => 'name',
                'Tasks' => 'name',
                'Leads' => 'full_name',
            ),
            'tile_body_fields' => array(
                'Cases' => array(
                    'account_name',
                    'priority',
                ),
                'Opportunities' => array(
                    'account_name',
                    'date_closed',
                    'amount',
                ),
                'Tasks' => array(
                    'contact_name',
                    'parent_name',
                    'date_due',
                ),
                'Leads' => array(
                    'email',
                    'account_name',
                    'phone_work',
                ),
            ),
            'records_per_column' => array(
                'Cases' => '10',
                'Opportunities' => '10',
                'Tasks' => '10',
                'Leads' => '10',
            ),
            'available_columns' => array(
                'Cases' => array(
                    'status' => array(
                        'New' => 'New',
                        'Assigned' => 'Assigned',
                        'Closed' => 'Closed',
                        'Pending Input' => 'Pending Input',
                        'Rejected' => 'Rejected',
                        'Duplicate' => 'Duplicate',
                    ),
                ),
                'Opportunities' => array(
                    'sales_stage' => array(
                        'Prospecting' =>  'Prospecting',
                        'Qualification' => 'Qualification',
                        'Needs Analysis' => 'Needs Analysis',
                        'Value Proposition' => 'Value Proposition',
                        'Id. Decision Makers' => 'Id. Decision Makers',
                        'Perception Analysis' => 'Perception Analysis',
                        'Proposal/Price Quote' => 'Proposal/Price Quote',
                        'Negotiation/Review' => 'Negotiation/Review',
                    ),
                ),
                'Tasks' => array(
                    'status' => array(
                        'Not Started' => 'Not Started',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                        'Pending Input' => 'Pending Input',
                        'Deferred' => 'Deferred',
                    ),
                ),
                'Leads' => array(
                    'status' => array(
                        'New' => 'New',
                        'Assigned' => 'Assigned',
                        'In Process' => 'In Process',
                        'Converted' => 'Converted',
                        'Recycled' => 'Recycled',
                        'Dead' => 'Dead',
                    ),
                ),
            ),
        );
    }
}
