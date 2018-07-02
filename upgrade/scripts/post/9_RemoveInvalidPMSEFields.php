<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

require_once 'modules/pmse_Inbox/engine/PMSEEngineUtils.php';
/**
 * Script to remove blocked fields from Process Definitions while upgrading to 7.6.2 and above.
 * Currently this script deals with removal of blocked fields such as is_admin from pmse_bpm_activity_definition.
 * This script can be extended for removal of other blocked fields from other tables in the future.
 */
class SugarUpgradeRemoveInvalidPMSEFields extends UpgradeScript
{
    public $order = 9400;
    public $type = self::UPGRADE_CUSTOM;

    /**
     * List of validation types needed when checking fields
     * @var array
     */
    protected $validationTypes = array(
        'ADD_RELATED_RECORD' => 'AC',
        'CHANGE_FIELD' => 'CF',
        'BUSINESS_RULE' => 'BR',
    );

    /**
     * Returns the correct validation type code for a given key
     * @param string $key The key for the validation types array
     * @return string
     */
    protected function getValidationType($key)
    {
        return isset($this->validationTypes[$key]) ? $this->validationTypes[$key] : '';
    }

    public function run()
    {
        // The supported upgrade for this is to 7.6.2
        if ((version_compare($this->from_version, '7.6.2', '<')) &&
            (version_compare($this->to_version, '7.6.2', '>='))) {

            // Remove fields in act_fields that are invalid
            $db = $this->db;

            // Decorate our SQL so that each DB can parse this properly
            $afmNotEmptyString = $db->getNotEmptyStringSQL('ad.act_field_module');
            $afNotEmptyString = $db->getNotEmptyStringSQL('act_fields');

            // build the SQL now
            $sql = "SELECT
                        ad.id, ad.act_fields, ad.act_field_module,
                        pd.pro_module,
                        a.act_task_type, a.act_script_type
                    FROM
                        pmse_bpm_activity_definition ad
                        INNER JOIN
                            pmse_bpmn_activity a on ad.id = a.id
                        INNER JOIN
                            pmse_bpm_process_definition pd ON ad.pro_id = pd.id
                    WHERE 
                        $afmNotEmptyString
                        AND $afNotEmptyString
                        AND a.act_task_type = 'SCRIPTTASK'
                        AND pd.deleted = 0
                        AND ad.deleted = 0";
            $result = $db->query($sql);
            while ($row = $db->fetchByAssoc($result)) {
                // This is the content in the database, as JSON
                $act_fields = $row['act_fields'];
                if ($act_fields) {
                    // Certain tasks require special field validation, so this
                    // handles that
                    $validationType = $this->getValidationType($row['act_script_type']);

                    // This method expects a row of data as thought from an import
                    // and depends on act_fields and act_field_module
                    $new = PMSEEngineUtils::sanitizeImportActivityFields($row, $row['pro_module'], $validationType);

                    // Only update if there was an actual change
                    if ($new != $act_fields) {
                        // Build a log message for parsing and writing
                        $lMessage =  "Changes were found to PMSE activity fields:\n";
                        $lMessage .= "Before:\n%s\nAfter:\n%s\nScript Type: %s\nValidation Type: %s";

                        // Log this message now
                        $this->log(
                            sprintf(
                                $lMessage,
                                $act_fields,
                                $new,
                                $row['act_script_type'],
                                $validationType
                            )
                        );

                        $new = $db->quoted($new);
                        $id = $db->quoted($row['id']);

                        // Handle the update now
                        $sql = "UPDATE
                                    pmse_bpm_activity_definition
                                SET
                                    act_fields = $new 
                                WHERE id = $id";
                        $db->query($sql);
                    }
                }
            }
        }
    }
}
