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
require_once 'modules/pmse_Inbox/engine/PMSELogger.php';
require_once 'modules/pmse_Inbox/engine/PMSEEngineUtils.php';

use Sugarcrm\Sugarcrm\ProcessManager;

class PMSERelatedModule
{
    /**
     * List of fields that need to set a property on the bean to prevent being
     * overridden on save
     * @var array
     */
    protected $automaticFields = array(
        'created_by' => array(
            'property' => 'set_created_by',
            'value' => false,
        ),
        'modified_user_id' => array(
            'property' => 'update_modified_by',
            'value' => false,
        ),
        'modified_by_name' => array(
            'property' => 'update_modified_by',
            'value' => false,
        ),
        'date_modified' => array(
            'property' => 'update_date_modified',
            'value' => false,
        ),
    );

    private $logger;

    private $relatedRecordApi;

    public function __construct()
    {
        $this->logger = PMSELogger::getInstance();
        $this->relatedRecordApi = new RelateRecordApi();
    }

    protected function getBean($module)
    {
        $bean = BeanFactory::getBean($module);
        if (empty($bean))
            throw ProcessManager\Factory::getException('InvalidData', "No bean for module $module");
        return $bean;
    }

    protected function newBean($module)
    {
        $bean = BeanFactory::newBean($module);
        if (empty($bean))
            throw ProcessManager\Factory::getException('InvalidData', "No bean for module $module");
        return $bean;
    }

    public function getRelatedModule($moduleBean, $linkField)
    {
        $fieldName = $linkField;
        if (empty($moduleBean->field_defs[$fieldName]))
            throw ProcessManager\Factory::getException('InvalidData', "Unable to find field {$fieldName}");

        if(!$moduleBean->load_relationship($fieldName))
            throw ProcessManager\Factory::getException('InvalidData', "Unable to load relationship $fieldName");

        $relatedBean = $moduleBean->$fieldName->getBeans(array('limit' => 1));

        if (!empty($relatedBean)) {
            return current($relatedBean);
        } else {
            return null;
        }
    }

    public function getRelatedModuleName($moduleBeanName, $linkField)
    {
        $moduleBean = $this->newBean($moduleBeanName);

        if (!$moduleBean->load_relationship($linkField))
            throw ProcessManager\Factory::getException('InvalidData', "Unable to load relationship $linkField");

        if (!empty($moduleBean->field_defs[$linkField])) {
            $moduleName = $moduleBean->$linkField->getRelatedModuleName();
        } else {
            $moduleName = $moduleBeanName;
        }
        return $moduleName;
    }

    public function getRelatedBeans($filter, $relationship = 'all')
    {
        global $beanList, $app_list_strings;
        if (isset($beanList[$filter])) {
            $newModuleFilter = $filter;
        } else {
            $newModuleFilter = array_search($filter, $beanList);
        }
        $output_11 = array(); // Logic container for one-to-one and many-to-one
        $output_1m = array(); // Logic container for one-to-many and many-to-many(not implemented yet)
        $output = array();
        $moduleBean = $this->getBean($newModuleFilter);

        foreach($moduleBean->get_linked_fields() as $link => $def) {
            if (!empty($def['type']) && $def['type'] == 'link' && $moduleBean->load_relationship($link)) {
                $relatedModule = $moduleBean->$link->getRelatedModuleName();
                if (!in_array($relatedModule, PMSEEngineUtils::getSupportedModules('related'))) {
                    continue;
                }
                if (in_array($link, PMSEEngineUtils::$relatedBlacklistedLinks)) {
                    continue;
                }
                if (!empty(PMSEEngineUtils::$relatedBlacklistedLinksByModule[$filter]) && in_array($link, PMSEEngineUtils::$relatedBlacklistedLinksByModule[$filter])) {
                    continue;
                }
                $relType = $moduleBean->$link->getType(); //returns 'one' or 'many' for the cardinality of the link
                $label = empty($def['vname']) ? $link : translate($def['vname'], $filter);
                $moduleLabel = translate("LBL_MODULE_NAME", $relatedModule);
                if ($moduleLabel == "LBL_MODULE_NAME") {
                    $moduleLabel = translate($relatedModule);
                }

                // Parentheses value
                $pval = "$moduleLabel (" . trim($label, ':') . ": $link)";
                $ret = array(
                    'value' => $link,
                    'text' => $pval,
                    'module' => $moduleLabel,
                    'module_label' => $moduleLabel, // Added so that module can be deprecated
                    'module_name' => $relatedModule, // Added so that we have access to the module name
                    'relationship' => $def['relationship'],
                );
                if ($relType == 'one') {
                    $output_11[] = $ret;
                } else {
                    $output_1m[] = $ret;
                }
            }
        }

        switch ($relationship) {
            case 'one-to-one':
            case 'one':
                $output = $output_11;
                break;
            case 'one-to-many':
            case 'many':
                $output = $output_1m;
                break;
            case 'all':
            default:
                $output = array_merge($output_11, $output_1m);
                break;
        }


        // Needed to multisort on the label
        $labels = array();
        foreach ($output as $k => $o) {
            $labels[$k] = $o['text'];
        }

        // Sort on the label
        array_multisort($labels, SORT_ASC, $output);

        // Send text with pluralized module name
        $filterText = isset($app_list_strings['moduleList'][$filter]) ? $app_list_strings['moduleList'][$filter] : $filter;
        $filterArray = array(
            'value' => $filter,
            'text' => '<' . $filterText . '>',
            'module' => $filter,
            'module_label' => $filterText, // Display value for Module Name
            'module_name' => $filter, // Actual Module Name Key
            'relationship' => $filter
        );

        array_unshift($output, $filterArray);

        $res['search'] = $filter;
        $res['success'] = true;
        $res['result'] = $output;

        return $res;
    }

    public function getFieldValue($newBean, $field)
    {
        global $timedate;
        $value= !empty($newBean->fetched_row[$field]) ? $newBean->fetched_row[$field] : $newBean->$field;
        $def = $newBean->field_defs[$field];
        switch ($def['type']){
            case 'datetime':
            case 'datetimecombo':
                $theDate = $value;
                $value = $timedate->fromDb($theDate);
                break;
            case 'bool':
                // Make sure to cover all possible boolean values
                $value = isTruthy($value);
                break;
            case 'multienum':
                $value = !empty($value) ? unencodeMultienum($value) : array();
                break;
          }
          return $value;
    }

    /**
     * Creates a new Related Record
     * @param $moduleBean
     * @param $linkField
     * @param $fields
     * @return null|SugarBean
     * @throws Exception
     */
    public function addRelatedRecord($moduleBean, $linkField, $fields)
    {
        $fieldName = $linkField;
        if (empty($moduleBean->field_defs[$fieldName]))
            throw ProcessManager\Factory::getException('InvalidData', "Unable to find field {$fieldName}");

        if(!$moduleBean->load_relationship($fieldName))
            throw ProcessManager\Factory::getException('InvalidData', "Unable to load relationship $fieldName");

        $rModule = $moduleBean->$fieldName->getRelatedModuleName();

        $relatedModuleBean = $this->newBean($rModule);

        foreach ($fields as $key => $value) {
            if (isset($relatedModuleBean->field_defs[$key])) {
                // check if is of type link
                if ((isset($relatedModuleBean->field_defs[$key]['type'])) &&
                    ($relatedModuleBean->field_defs[$key]['type'] == 'link') &&
                    !(empty($relatedModuleBean->field_defs[$key]['name']))) {

                    // if its a link then go through cases on basis of "name" here.
                    // Currently only supporting teams
                    switch ($relatedModuleBean->field_defs[$key]['name']) {
                        case 'teams':
                            PMSEEngineUtils::changeTeams($relatedModuleBean, $value);
                            break;
                    }
                } else {
                    // Certain fields require that a property on the bean be set
                    // in order for the change to take. This handles that.
                    if (isset($this->automaticFields[$key])) {
                        $set = $this->automaticFields[$key];
                        $relatedModuleBean->{$set['property']} = $set['value'];
                    }

                    $relatedModuleBean->$key = $value;
                }
            }
        }

        if (isset($relatedModuleBean->field_defs['parent_type'], $relatedModuleBean->field_defs['parent_id'])) {
            $relatedModuleBean->parent_type = $moduleBean->module_dir;
            $relatedModuleBean->parent_id = $moduleBean->id;
        }

        if ($moduleBean->module_name == $rModule) {
            $relatedModuleBean->pa_related_module_save = true;
        }

        // Save the new Related Record
        PMSEEngineUtils::saveAssociatedBean($relatedModuleBean);


        if (!$relatedModuleBean->in_save) {
            $rel_id = $relatedModuleBean->id;
            $moduleBean->$fieldName->add($rel_id);
            return $relatedModuleBean;
        } else {
            return null;
        }
    }
}
