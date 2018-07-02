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
/**
 * Update configuration for Process Author's Send Email Event to the new format.
 */
class SugarUpgradeFixPMSEPASendEmail extends UpgradeScript
{
    public $order = 9000;
    public $type = self::UPGRADE_CUSTOM;

    private $teamIDs = null;

    protected function getTeamIds() {
        if ($this->teamIDs === null) {
            $result = $GLOBALS['db']->query('SELECT id, name FROM teams');
            $this->teamIDs = array();

            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $this->teamIDs[] = $row;
            }
        }
        return $this->teamIDs;
    }

    protected function getTeamIdByName($name) {
        $teamsIDs = $this->getTeamIds();
        foreach ($teamsIDs as $team) {
            if ($team["name"] === $name) {
                return $team["id"];
            }
        }
        return null;
    }

    protected function toNewTeamFormat($oldJSON) {
        $newJSON = array();

        $newJSON['value'] = $this->getTeamIdByName($oldJSON["name"]);
        $newJSON['type'] = 'team';
        $newJSON['label'] = $oldJSON["name"];

        return $newJSON;
    }

    protected function toNewRawFormat($oldJSON) {
        $newJSON = array();

        $newJSON['value'] = $oldJSON["emailAddress"];
        $newJSON['type'] = 'email';
        $newJSON['label'] = $oldJSON["name"];

        return $newJSON;
    }

    protected function toNewVariableFormat($oldJSON, $module) {
        $newJSON = array();

        //adding '<' & '>' to keep consistency with target module
        $moduleLabel = '<'.$module.'>';

        switch($oldJSON["emailAddress"]) {
            case 'Supervisor':
                $newJSON["value"] = "is_assignee";
                $newJSON["user"] = "manager_of";
                $newJSON["label"] = str_replace("%MODULE%", $moduleLabel, translate('LBL_PMSE_EMAILPICKER_MANAGER_CREATED', 'pmse_Project'));
                break;
            case 'Record Owner':
            case 'Current User':
                $newJSON["value"] = "is_assignee";
                $newJSON["user"] = "who";
                $newJSON["label"] = str_replace("%MODULE%", $moduleLabel, translate('LBL_PMSE_EMAILPICKER_USER_IS_ASSIGNED', 'pmse_Project'));
                break;
            default:
                return $newJSON;
        }
        $newJSON["type"] = "user";
        $newJSON["module"] = $module;
        return $newJSON;
    }

    protected function parseToNewFormat($oldValue, $module = null) {
        switch($oldValue["emailAddress"]) {
            case "Team":
                return $this->toNewTeamFormat($oldValue);
            case 'Supervisor':
            case 'Record Owner':
            case 'Current User':
                return $this->toNewVariableFormat($oldValue, $module);
            default:
                return $this->toNewRawFormat($oldValue);
        }
    }

    public function run()
    {
        // The only supported upgrade for this is 7.6.0.0RC4 to 7.6.0.0
        if (version_compare($this->from_version, '7.6.0.0RC4', '==') && version_compare($this->to_version, '7.6.0.0', '==')) {

            $result = $GLOBALS['db']->query('SELECT p.pro_module as module, e1.id as event_id, e2.evn_params as params FROM '
                .'pmse_bpmn_event e1 inner join pmse_bpm_event_definition e2 '
                .'ON e1.id = e2.id left join pmse_bpm_process_definition p on e1.prj_id = p.prj_id '
                ."WHERE (e2.evn_type = 'INTERMEDIATE' OR e2.evn_type = 'END') "
                ."AND e1.evn_marker = 'MESSAGE' AND e1.evn_behavior = 'THROW'");

            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $oldJSON = json_decode(html_entity_decode($row['params']), true);
                if ($oldJSON !== null) {
                    $newJSON = array(
                        "to" => array(),
                        "cc" => array(),
                        "bcc" => array()
                    );
                    $indexHelper = array("to", "cc", "bcc");

                    foreach ($indexHelper as $index) {
                        foreach ($oldJSON[$index] as $value) {
                            $parsed = $this->parseToNewFormat($value, $row["module"]);
                            if (empty($parsed)) {
                                continue;
                            }
                            array_push($newJSON[$index], $parsed);
                        }
                    }

                    $newJSON = json_encode(array(
                        "to" => $newJSON["to"],
                        "cc" => $newJSON["cc"],
                        "bcc" => $newJSON["bcc"]
                    ));

                    $event_id = $row["event_id"];
                    $GLOBALS['db']->query("UPDATE pmse_bpm_event_definition SET evn_params = '$newJSON' WHERE id = '$event_id'");
                }
            }
        }
    }
}
