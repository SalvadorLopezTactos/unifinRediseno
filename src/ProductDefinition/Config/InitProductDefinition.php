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

namespace Sugarcrm\Sugarcrm\ProductDefinition\Config;

use Sugarcrm\Sugarcrm\ProductDefinition\Config\Cache\DbCache;

/**
 * Write initial product definition in DB on install and upgrade
 */
class InitProductDefinition
{
    /**
     * write initial product definition in DB
     * @throws \Exception
     */
    public function setDefaultProductDefinition()
    {
        $cache = new DbCache();
        $cache->set($this->getDefaultProductDefinition());
    }

    /**
     * return default product definition
     */
    protected function getDefaultProductDefinition(): string
    {
        // This section of code is a portion of the code referred
        // to as Critical Control Software under the End User
        // License Agreement.  Neither the Company nor the Users
        // may modify any portion of the Critical Control Software.
        return <<<JSON
{
    "MODULES": {
        "Bugs":["CURRENT","SUGAR_SERVE"],
        "BusinessCenters":["SUGAR_SERVE","SUGAR_SELL"],
        "CampaignLog":["CURRENT","SUGAR_SELL"],
        "CampaignTrackers":["CURRENT","SUGAR_SELL"],
        "Campaigns":["CURRENT","SUGAR_SELL"],
        "Cases":["CURRENT","SUGAR_SERVE"],
        "ChangeTimers":["SUGAR_SERVE"],
        "ContractTypes":["CURRENT","SUGAR_SELL"],
        "Contracts":["CURRENT","SUGAR_SELL"],
        "EmailMarketing":["CURRENT","SUGAR_SELL"],
        "ForecastManagerWorksheets":["CURRENT","SUGAR_SELL"],
        "ForecastWorksheets":["CURRENT","SUGAR_SELL"],
        "Forecasts":["CURRENT","SUGAR_SELL"],
        "Leads":["CURRENT","SUGAR_SELL"],
        "Messages":["SUGAR_SERVE"],
        "MobileDevices":["SUGAR_SERVE","SUGAR_SELL"],
        "Opportunities":["CURRENT","SUGAR_SELL"],
        "ProductBundleNotes":["CURRENT","SUGAR_SELL"],
        "ProductBundles":["CURRENT","SUGAR_SELL"],
        "Products":["CURRENT","SUGAR_SELL"],
        "Project":["CURRENT"],
        "ProjectTask":["CURRENT"],
        "ProspectLists":["CURRENT","SUGAR_SELL"],
        "Prospects":["CURRENT","SUGAR_SELL"],
        "PurchasedLineItems":["SUGAR_SERVE","SUGAR_SELL"],
        "Purchases":["SUGAR_SERVE","SUGAR_SELL"],
        "PushNotifications":["SUGAR_SERVE","SUGAR_SELL"],
        "Quotas":["CURRENT","SUGAR_SELL"],
        "Quotes":["CURRENT","SUGAR_SELL"],
        "Releases":["CURRENT","SUGAR_SERVE"],
        "RevenueLineItems":["CURRENT","SUGAR_SELL"],
        "Shippers":["CURRENT","SUGAR_SELL"],
        "TaxRates":["CURRENT","SUGAR_SELL"],
        "WorkFlow":["CURRENT"],
        "WorkFlowActionShells":["CURRENT"],
        "WorkFlowActions":["CURRENT"],
        "WorkFlowAlertShells":["CURRENT"],
        "WorkFlowAlerts":["CURRENT"],
        "WorkFlowTriggerShells":["CURRENT"]
    },
    "DASHLETS": {
        "commentlog-dashlet":["CURRENT","SUGAR_SERVE","SUGAR_SELL"],
        "activity-timeline":["CURRENT","SUGAR_SERVE","SUGAR_SELL"],
        "dashablerecord":["CURRENT","SUGAR_SERVE","SUGAR_SELL"],
        "bubblechart":["CURRENT","SUGAR_SELL"],
        "casessummary":["CURRENT","SUGAR_SERVE"],
        "forecast-pareto":["CURRENT","SUGAR_SELL"],
        "forecast-pipeline":["CURRENT","SUGAR_SELL"],
        "forecastdetails":["CURRENT","SUGAR_SELL"],
        "forecastdetails-record":["CURRENT","SUGAR_SELL"],
        "forecasts-chart":["CURRENT","SUGAR_SELL"],
        "opportunity-metrics":["CURRENT","SUGAR_SELL"],
        "product-quick-picks":["CURRENT","SUGAR_SELL"],
        "product-quick-picks-dashlet":["CURRENT","SUGAR_SELL"],
        "product-catalog":["CURRENT","SUGAR_SELL"],
        "sales-pipeline":["CURRENT","SUGAR_SELL"],
        "twitter":["CURRENT"],
        "dashlet-searchable-kb-list":["SUGAR_SERVE","SUGAR_SELL"],        
        "active-subscriptions":["SUGAR_SERVE","SUGAR_SELL"],
        "request-closed-cases-dashlet":["SUGAR_SERVE"],
        "purchase-history":["SUGAR_SELL", "SUGAR_SERVE"]
    },
    "RECORDS": {
        "Dashboards": {
            "32bc5cd0-b1a0-11ea-ad16-f45c898a3ce7":["SUGAR_SERVE"],
            "c108bb4a-775a-11e9-b570-f218983a1c3e":["SUGAR_SERVE"],
            "da438c86-df5e-11e9-9801-3c15c2c53980":["SUGAR_SELL"],
            "5d670ec4-7b52-11e9-b9e0-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "5d671a22-7b52-11e9-b2bc-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "5d671d06-7b52-11e9-83cf-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "5d671fae-7b52-11e9-92e0-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "5d672260-7b52-11e9-93ba-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d6724f4-7b52-11e9-a725-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d672788-7b52-11e9-8440-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "5d672a1c-7b52-11e9-8ddb-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "5d672ca6-7b52-11e9-a6f5-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "5d672f44-7b52-11e9-8c60-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "5d6731c4-7b52-11e9-ab12-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "5d673462-7b52-11e9-8929-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "5d6736ec-7b52-11e9-a00e-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "5d67396c-7b52-11e9-8826-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "5d673c00-7b52-11e9-871e-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d673e80-7b52-11e9-833f-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d67410a-7b52-11e9-afc1-f218983a1c3e":["CURRENT","SUGAR_SELL"]
        },
        "Reports": {
            "61f5e80a-7b40-11e9-ad44-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "61f5f584-7b40-11e9-9acf-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "61f5f8fe-7b40-11e9-96c8-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc0ea32-7905-11e9-8941-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc0fedc-7905-11e9-a594-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc101c0-7905-11e9-8a2f-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc1045e-7905-11e9-ad68-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc106fc-7905-11e9-980e-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc10986-7905-11e9-9f44-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc10c10-7905-11e9-a54a-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc10e90-7905-11e9-89f5-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc11110-7905-11e9-a9d4-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc1139a-7905-11e9-b30a-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc11610-7905-11e9-917c-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc1189a-7905-11e9-921b-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc11b1a-7905-11e9-b8e6-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc11d90-7905-11e9-94c0-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc1201a-7905-11e9-a3e7-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc1229a-7905-11e9-93ed-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc12524-7905-11e9-a5b4-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc127a4-7905-11e9-854b-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc12a1a-7905-11e9-b4f0-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc12ca4-7905-11e9-bf44-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc12f24-7905-11e9-acbd-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc131ae-7905-11e9-a34c-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc13424-7905-11e9-b01a-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc136a4-7905-11e9-a8bc-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc13938-7905-11e9-9c43-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc13bb8-7905-11e9-b838-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc13e42-7905-11e9-baf0-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc140c2-7905-11e9-b3dd-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc1434c-7905-11e9-9e23-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc145d6-7905-11e9-a053-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc14856-7905-11e9-96f1-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc14ad6-7905-11e9-8c44-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc14d56-7905-11e9-8348-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc14fd6-7905-11e9-949f-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc15260-7905-11e9-82f9-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc154e0-7905-11e9-b436-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc15774-7905-11e9-8553-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc159f4-7905-11e9-bc5f-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc15c7e-7905-11e9-a206-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc15efe-7905-11e9-931e-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc1617e-7905-11e9-8280-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc16412-7905-11e9-8174-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc16688-7905-11e9-9a1e-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc16908-7905-11e9-9ff4-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc16ba6-7905-11e9-bcec-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc16e26-7905-11e9-b86f-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc170b0-7905-11e9-913d-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc17330-7905-11e9-b354-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc175b0-7905-11e9-8b2c-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc1783a-7905-11e9-96dd-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc17ab0-7905-11e9-8326-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc17d3a-7905-11e9-89ea-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc17fba-7905-11e9-9f45-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc1823a-7905-11e9-8981-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc184c4-7905-11e9-ae52-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc18744-7905-11e9-8eae-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc189ce-7905-11e9-8d92-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc18c58-7905-11e9-9bb2-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc18ed8-7905-11e9-950d-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc19162-7905-11e9-a98b-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "efc193e2-7905-11e9-9bfa-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "ff5d5d0e-7905-11e9-a6cc-f218983a1c3e":["CURRENT","SUGAR_SELL"],
            "5d674394-7b52-11e9-9740-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d674614-7b52-11e9-8f84-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d6748a8-7b52-11e9-9e9f-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d674b28-7b52-11e9-a18e-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d674db2-7b52-11e9-a8be-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d675032-7b52-11e9-990d-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d6752b2-7b52-11e9-acfc-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d67553c-7b52-11e9-bcf2-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d6757c6-7b52-11e9-9ead-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d675a50-7b52-11e9-83cb-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d675cda-7b52-11e9-9155-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d675f5a-7b52-11e9-9420-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d6761ee-7b52-11e9-aa07-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d676464-7b52-11e9-90b4-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d6766f8-7b52-11e9-8da8-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d676978-7b52-11e9-9ad3-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d676c02-7b52-11e9-901c-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d676e8c-7b52-11e9-b187-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "5d677116-7b52-11e9-b8c7-f218983a1c3e":["CURRENT","SUGAR_SERVE"],
            "c2908254-7606-11e9-a121-f218983a1c3e":["SUGAR_SERVE"],
            "c2908fc4-7606-11e9-a83a-f218983a1c3e":["SUGAR_SERVE"],
            "c290929e-7606-11e9-a555-f218983a1c3e":["SUGAR_SERVE"],
            "c290953c-7606-11e9-b083-f218983a1c3e":["SUGAR_SERVE"],
            "c29097d0-7606-11e9-ac35-f218983a1c3e":["SUGAR_SERVE"],
            "c2909a50-7606-11e9-914a-f218983a1c3e":["SUGAR_SERVE"],
            "c2909cd0-7606-11e9-9955-f218983a1c3e":["SUGAR_SERVE"],
            "c2909f50-7606-11e9-b00e-f218983a1c3e":["SUGAR_SERVE"],
            "c290a1da-7606-11e9-80e5-f218983a1c3e":["SUGAR_SERVE"],
            "c290a45a-7606-11e9-9663-f218983a1c3e":["SUGAR_SERVE"],
            "c290a6da-7606-11e9-a76d-f218983a1c3e":["SUGAR_SERVE"],
            "c290a950-7606-11e9-a526-f218983a1c3e":["SUGAR_SERVE"],
            "c290abda-7606-11e9-9f3e-f218983a1c3e":["SUGAR_SERVE"],
            "c290ae50-7606-11e9-9cb2-f218983a1c3e":["SUGAR_SERVE"],
            "c290b0da-7606-11e9-81f9-f218983a1c3e":["SUGAR_SERVE"],
            "0a76a768-fecb-11e9-8516-acde48001122":["SUGAR_SERVE"],
            "2b1af288-fecd-11e9-90aa-acde48001122":["SUGAR_SERVE"],
            "566f2434-ff3d-11e9-8a11-acde48001122":["SUGAR_SERVE"],
            "6bbdcf7c-fb4e-11e9-9fa0-acde48001122":["SUGAR_SERVE"],
            "79abd8bc-ff3c-11e9-a2f0-acde48001122":["SUGAR_SERVE"],
            "83d8370a-fecd-11e9-bb62-acde48001122":["SUGAR_SERVE"],
            "85cec03e-fecc-11e9-8dc3-acde48001122":["SUGAR_SERVE"],
            "8f78020a-feca-11e9-b721-acde48001122":["SUGAR_SERVE"],
            "9a51a2f2-fecb-11e9-9db0-acde48001122":["SUGAR_SERVE"],
            "ab01c4c6-ff3c-11e9-a88b-acde48001122":["SUGAR_SERVE"],
            "b376836e-fecc-11e9-b174-acde48001122":["SUGAR_SERVE"],
            "da47c51c-faa7-11e9-a6fc-acde48001122":["SUGAR_SERVE"],
            "6681c340-071c-11ea-acfb-acde48001122":["SUGAR_SERVE"],
            "79c210e4-073b-11ea-a8af-acde48001122":["SUGAR_SERVE"],
            "b037850a-0718-11ea-b44d-acde48001122":["SUGAR_SERVE"],
            "b9d1275a-0679-11ea-bf16-acde48001122":["SUGAR_SERVE"]
        },
        "pmse_Project" : {
            "645a5c70-7e4c-11e9-944d-82186cfedf39":["SUGAR_SERVE"],
            "4899c5ee-fa88-11e9-a733-c2e4554fbccf":["SUGAR_SERVE"],
            "42b657ca-7bec-11e9-a5ed-d694a7e8e45a":["SUGAR_SERVE"],
            "7b2f8038-7e4c-11e9-8eef-82186cfedf39":["SUGAR_SERVE"],
            "222e4668-fa8e-11e9-88d9-c2e4554fbccf":["SUGAR_SERVE"],
            "78975496-f4d9-11e9-8f14-0242ac120008":["SUGAR_SERVE"],
            "0b2619c6-d01f-11e9-af0f-020212dc7ae2":["SUGAR_SELL"],
            "1ee3ced8-ce9c-11e9-b443-020212dc7ae2":["SUGAR_SELL"],
            "1fca7c66-ce97-11e9-9945-020212dc7ae2":["SUGAR_SELL"],
            "2974cb4a-ce97-11e9-8382-020212dc7ae2":["SUGAR_SELL"],
            "73117be4-ce9d-11e9-9a22-020212dc7ae2":["SUGAR_SELL"],
            "88c61b38-d038-11e9-a28a-269099cc8e72":["SUGAR_SELL"],
            "d8b16456-cea1-11e9-9bd1-020212dc7ae2":["SUGAR_SELL"]
        },
        "pmse_Business_Rules" : {
            "644d41a2-7e4c-11e9-9f68-82186cfedf39":["SUGAR_SERVE"],
            "48958326-fa88-11e9-b836-c2e4554fbccf":["SUGAR_SERVE"],
            "85737962-d038-11e9-9fd9-269099cc8e72":["SUGAR_SELL"],
            "88c0e4ba-d038-11e9-8175-269099cc8e72":["SUGAR_SELL"]
        },
        "pmse_Emails_Templates": {
            "7b248aca-7e4c-11e9-8bb8-82186cfedf39":["SUGAR_SERVE"],
            "60ed5042-7e4c-11e9-8b80-82186cfedf39":["SUGAR_SERVE"],
            "6444b154-7e4c-11e9-9f3d-82186cfedf39":["SUGAR_SERVE"],
            "6447b4e4-7e4c-11e9-96e3-82186cfedf39":["SUGAR_SERVE"],
            "ea578d9e-fc27-11e9-9cef-6c400895ea84":["SUGAR_SERVE"],
            "9299e754-fc28-11e9-9b3b-6c400895ea84":["SUGAR_SERVE"],
            "39ec46be-fc29-11e9-b2c2-6c400895ea84":["SUGAR_SERVE"],
            "22266574-fa8e-11e9-af93-c2e4554fbccf":["SUGAR_SERVE"],
            "222b3158-fa8e-11e9-8e82-c2e4554fbccf":["SUGAR_SERVE"],
            "788519d4-f4d9-11e9-b625-0242ac120008":["SUGAR_SERVE"],
            "78915334-f4d9-11e9-9817-0242ac120008":["SUGAR_SERVE"],
            "0b1d30b8-d01f-11e9-b51b-020212dc7ae2":["SUGAR_SELL"],
            "72e43742-ce9d-11e9-a418-020212dc7ae2":["SUGAR_SELL"],
            "856ce0f2-d038-11e9-b51f-269099cc8e72":["SUGAR_SELL"],
            "d55cd632-cea1-11e9-8252-020212dc7ae2":["SUGAR_SELL"],
            "d8accedc-cea1-11e9-bbec-020212dc7ae2":["SUGAR_SELL"]
        }
    },
    "FIELDS": {
        "Accounts": {
            "business_center_id":["SUGAR_SERVE","SUGAR_SELL"],
            "business_center_name":["SUGAR_SERVE","SUGAR_SELL"]
        },
        "Bugs": {
            "hours_to_resolution":["SUGAR_SERVE"],
            "business_hours_to_resolution":["SUGAR_SERVE"]
        },
        "Calls": {
            "transcript":["SUGAR_SERVE"],
            "aws_contact_id":["SUGAR_SERVE"],
            "call_recording_url":["SUGAR_SERVE"],
            "call_recording":["SUGAR_SERVE"]
        },
        "Cases": {
            "business_center_id":["SUGAR_SERVE"],
            "business_center_name":["SUGAR_SERVE"],
            "first_response_target_datetime":["SUGAR_SERVE"],
            "first_response_actual_datetime":["SUGAR_SERVE"],
            "hours_to_first_response":["SUGAR_SERVE"],
            "business_hrs_to_first_response":["SUGAR_SERVE"],
            "first_response_var_from_target":["SUGAR_SERVE"],
            "first_response_sla_met":["SUGAR_SERVE"],
            "first_response_user_id":["SUGAR_SERVE"],
            "first_response_user_name":["SUGAR_SERVE"],
            "first_response_user_link":["SUGAR_SERVE"],
            "first_response_sent":["SUGAR_SERVE"],
            "hours_to_resolution":["SUGAR_SERVE"],
            "business_hours_to_resolution":["SUGAR_SERVE"],
            "request_close":["SUGAR_SERVE"],
            "request_close_date":["SUGAR_SERVE"]
        },
        "Contacts": {
            "business_center_id":["SUGAR_SERVE","SUGAR_SELL"],
            "business_center_name":["SUGAR_SERVE","SUGAR_SELL"]
        },
        "DataPrivacy": {
            "hours_to_resolution":["SUGAR_SERVE","SUGAR_SELL"],
            "business_hours_to_resolution":["SUGAR_SERVE","SUGAR_SELL"]
        },
        "KBContents": {
            "kbscase_name":["SUGAR_SERVE"]
        },
        "Leads": {
            "business_center_id":["SUGAR_SELL"],
            "business_center_name":["SUGAR_SELL"]
        },
        "PurchasedLineItems": {
            "renewal_opp_id": ["SUGAR_SELL"],
            "renewal_opp_name": ["SUGAR_SELL"]
        },
        "RevenueLineItems": {
            "purchasedlineitem":["SUGAR_SELL"],
            "purchasedlineitem_name":["SUGAR_SELL"],
            "purchasedlineitem_id":["SUGAR_SELL"],
            "generate_purchase":["SUGAR_SELL"],
            "add_on_to_id": ["SUGAR_SELL"],
            "add_on_to_name": ["SUGAR_SELL"]
        },
        "Products": {
            "add_on_to_id": ["SUGAR_SELL"],
            "add_on_to_name": ["SUGAR_SELL"]
        },
        "Users": {
            "business_center_id":["SUGAR_SERVE","SUGAR_SELL"],
            "business_center_name":["SUGAR_SERVE","SUGAR_SELL"]
        }
    }
}
JSON;
        //END REQUIRED CODE DO NOT MODIFY
    }
}
