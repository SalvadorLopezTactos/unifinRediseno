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

use Sugarcrm\Sugarcrm\CustomerJourney\Bean as CJBean;
use Sugarcrm\Sugarcrm\CustomerJourney\Exception as CJException;

require_once 'modules/CJ_WebHooks/CJ_WebHook.php';
require_once 'modules/CJ_Forms/CJ_Form.php';

class DRI_Workflow_Template extends Basic
{
    public const ASSIGNEE_RULE_NONE = 'none';
    public const ASSIGNEE_RULE_CREATE = 'create';
    public const ASSIGNEE_RULE_STAGE_START = 'stage_start';
    public const TARGET_ASSIGNEE_PARENT = 'parent_assignee';

    public const TARGET_ASSIGNEE_CURRENT_USER = 'current_user';
    public const TARGET_ASSIGNEE_USER = 'user';
    public const TARGET_ASSIGNEE_TEAM = 'team';
    public const TARGET_ASSIGNEE_USER_TEAM = 'user_team';

    public $disable_row_level_security = false;
    public $new_schema = true;
    public $module_dir = 'DRI_Workflow_Templates';
    public $object_name = 'DRI_Workflow_Template';
    public $table_name = 'dri_workflow_templates';
    public $importable = true;

    public $team_id;
    public $team_set_id;
    public $team_count;
    public $team_name;
    public $team_link;
    public $team_count_link;
    public $teams;
    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $modified_by_name;
    public $created_by;
    public $created_by_name;
    public $description;
    public $deleted;
    public $created_by_link;
    public $modified_user_link;
    public $available_modules;
    public $assignee_rule;
    public $target_assignee;
    public $activities;
    public $following;
    public $following_link;
    public $favorite_link;
    public $tag;
    public $tag_link;
    public $points;
    public $related_activities;
    public $active;
    public $locked_fields;
    public $locked_fields_link;
    public $acl_team_set_id;
    public $acl_team_names;
    public $disabled_stage_actions;
    public $disabled_activity_actions;
    public $active_limit;
    public $type;

    /**
     * @var Link2
     */
    public $dri_workflows;

    /**
     * @var Link2
     */
    public $forms;

    /**
     * @var Link2
     */
    public $dri_subworkflow_templates;

    /**
     * @var string
     */
    public $copied_template_id;

    /**
     * @var string
     */
    public $copied_template_name;

    /**
     * @var Link2
     */
    public $copied_template_link;

    /**
     * @var Link2
     */
    public $copies;

    /**
     * @var Link2
     */
    public $web_hooks;

    /**
     * Retrieves a DRI_Workflow_Template with id $id and
     * returns an instance of the retrieved bean
     *
     * @param string $id: the id of the DRI_Workflow_Template that should be retrieved
     * @param bool $deleted: Set false if the bean is already deleted
     * @return DRI_Workflow_Template
     * @throws NotFoundException: if not found
     */
    public static function getById($id, $deleted = true)
    {
        return CJBean\Repository::getInstance()->getById('DRI_Workflow_Templates', $id, $deleted);
    }

    /**
     * Retrieves a DRI_Workflow_Template with name $name and
     * returns an instance of the retrieved bean
     *
     * @param string $name : the name of the DRI_Workflow_Template that should be retrieved
     * @param string $skipId
     * @return DRI_Workflow_Template
     * @throws NotFoundException
     */
    public static function getByName($name, $skipId = null)
    {
        return CJBean\Repository::getInstance()->getByName(
            [
                'table' => 'dri_workflow_templates',
                'module' => 'DRI_Workflow_Templates',
                'name' => $name,
                'skipId' => $skipId,
            ]
        );
    }

    /**
     * Get all the journey templates
     *
     * @return DRI_Workflow_Template[]
     * @throws SugarQueryException
     * @throws NotFoundException
     */
    public static function all()
    {
        $query = new SugarQuery();
        $query->from(new self());
        $query->select(['id']);
        $results = $query->execute();

        $templates = [];

        foreach ($results as $result) {
            $templates[] = self::getById($result['id']);
        }

        return $templates;
    }

    /**
     * {@inheritdoc}
     **/
    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }

        return false;
    }

    /**
     * Get the id and name of the module if available
     *
     * @param string $moduleOrBean
     * @return array
     * @throws SugarQueryException
     */
    public static function listEnumValuesByModule($moduleOrBean)
    {
        $module = $moduleOrBean;
        if ($moduleOrBean instanceof SugarBean) {
            $module = $moduleOrBean->module_dir;
        }
        $query = new SugarQuery();
        $query->from(new self());
        $query->select(['id', 'name']);
        $query->orderBy('name', 'ASC');
        $query->where()
            ->contains('available_modules', "^$module^")
            ->equals('active', true);

        $results = $query->execute();

        $values = ['' => ''];

        foreach ($results as $result) {
            $values[$result['id']] = $result['name'];
        }

        return $values;
    }

    /**
     * Send the webhooks
     *
     * @param string $trigger_event
     * @param array $request
     * @throws SugarApiException
     * @throws SugarQueryException
     */
    public function sendWebHooks($trigger_event, array $request)
    {
        \CJ_WebHook::send($this, $trigger_event, $request);
    }

    /**
     * Get the actions which are disabled for the stage
     *
     * @return array|null
     */
    public function getDisabledStageActions()
    {
        return !empty($this->disabled_stage_actions)
            ? unencodeMultienum($this->disabled_stage_actions)
            : [];
    }

    /**
     * Get the actions which are disabled for the activity
     *
     * @return array|null
     */
    public function getDisabledActivityActions()
    {
        return !empty($this->disabled_activity_actions)
            ? unencodeMultienum($this->disabled_activity_actions)
            : [];
    }

    /**
     * Get the stage templates linked with the journey template
     *
     * @return DRI_SubWorkflow_Template[]
     * @throws SugarQueryException
     */
    public function getStageTemplates()
    {
        $bean = \BeanFactory::newBean('DRI_SubWorkflow_Templates');

        $query = new \SugarQuery();
        $query->from($bean, ['team_security' => false]);
        $query->select('*');
        $query->orderBy('sort_order', 'ASC');
        $query->where()
            ->equals('dri_workflow_template_id', $this->id);

        return $bean->fetchFromQuery($query);
    }

    /**
     * Get the last stage template
     *
     * @return DRI_SubWorkflow_Template
     * @throws SugarApiExceptionNotFound
     * @throws SugarQueryException
     */
    public function getLastStage()
    {
        $stages = $this->getStageTemplates();

        if (count($stages) === 0) {
            throw new SugarApiExceptionNotFound();
        }

        return array_pop($stages);
    }

    /**
     * {@inheritdoc}
     */
    public function save($check_notify = false)
    {
        $this->validateUniqueName();

        $isNew = !$this->isUpdate();
        $nameChanged = isset($this->fetched_row['name']) && $this->fetched_row['name'] !== $this->name;

        $this->calculatePoints();
        $this->calculateRelatedActivities();

        $return = parent::save($check_notify);

        if ($isNew && !empty($this->copied_template_id)) {
            $this->copyFromTemplate();
        }

        if (!$isNew && $nameChanged) {
            $this->syncJourneyNames();
        }

        return $return;
    }

    /**
     * Copy stage, activity and child activities templates
     * Copy webhooks and forms as well for each
     *
     * @throws SugarQueryException
     * @throws SugarApiExceptionInvalidParameter
     * @throws NotFoundException
     */
    private function copyFromTemplate()
    {
        try {
            $template = self::getById($this->copied_template_id);

            $this->dri_subworkflow_templates = null;
            $this->load_relationship('dri_subworkflow_templates');
            $this->copyFromTemplatesHelper($template);
            CJ_WebHook::copyWebHooks($this, $template);
            CJ_Form::copyForms($this, $this, $template);
        } catch (CJException\NotFoundException $e) {
            if ($e->getModuleName() === 'DRI_Workflow_Templates' && !empty($this->copied_template_id)) {
                throw new CJException\NotFoundException(null, ['moduleName', 'DRI_Workflow_Templates', 'data' => $this->copied_template_id]);
            }
        }
    }

    private function copyFromTemplatesHelper($template)
    {
        foreach ($template->getStageTemplates() as $stageTemplateBase) {
            $stageTemplate = $this->cloneAndCopyTemplateValues($stageTemplateBase, [
                'dri_workflow_template_id' => $this->id,
                'dri_workflow_template_name' => $this->name,
            ]);

            $this->dri_subworkflow_templates->add($stageTemplate);

            $stageTemplate->dri_workflow_task_templates = null;
            $stageTemplate->load_relationship('dri_workflow_task_templates');
            foreach ($stageTemplateBase->getActivityTemplates() as $activityTemplateBase) {
                $activityTemplate = $this->cloneAndCopyTemplateValues($activityTemplateBase, [
                    'dri_subworkflow_template_id' => $stageTemplate->id,
                    'dri_subworkflow_template_name' => $stageTemplate->name,
                ]);
                $stageTemplate->dri_workflow_task_templates->add($activityTemplate);

                foreach ($activityTemplateBase->getChildren() as $childTemplateBase) {
                    $childTemplate = $this->cloneAndCopyTemplateValues($childTemplateBase, [
                        'parent_id' => $activityTemplate->id,
                        'dri_subworkflow_template_id' => $stageTemplate->id,
                        'dri_subworkflow_template_name' => $stageTemplate->name,
                        'parent_name' => $activityTemplate->name,
                    ]);
                    $this->copyAndRegisterBean($template, $childTemplate, $childTemplateBase);
                }
                $this->copyAndRegisterBean($template, $activityTemplate, $activityTemplateBase);
            }
            $this->copyAndRegisterBean($template, $stageTemplate, $stageTemplateBase);
        }
    }

    private function cloneAndCopyTemplateValues($templateBase, $copyFieldsArr)
    {
        $template = clone $templateBase;
        $template->id = \Sugarcrm\Sugarcrm\Util\Uuid::uuid1();
        $template->new_with_id = true;
        foreach ($copyFieldsArr as $fieldName => $value) {
            $template->$fieldName = $value;
        }
        $template->save();
        return $template;
    }

    private function copyAndRegisterBean($template, $cjTemplate, $templateBase)
    {
        CJ_WebHook::copyWebHooks($cjTemplate, $templateBase);
        CJ_Form::copyForms($template, $cjTemplate, $templateBase);
        BeanFactory::unregisterBean($cjTemplate);
    }

    /**
     * {@inheritdoc}
     */
    public function mark_deleted($id)
    {
        if ($this->id !== $id) {
            $this->retrieve($id);
        }

        $this->checkIfTemplateInUse($id);

        $subWorkflowTemplates = $this->getStageTemplates();
        CJ_WebHook::deleteWebHooks($this);

        parent::mark_deleted($id);

        foreach ($subWorkflowTemplates as $subWorkflowTemplate) {
            $subWorkflowTemplate->mark_deleted($subWorkflowTemplate->id);
        }
    }

    /**
     * Check if a journey template is in use so that it cannot be deleted
     *
     * @param string $id
     * @throws SugarApiExceptionInvalidParameter
     */
    private function checkIfTemplateInUse($id)
    {
        if (!empty($id)) {
            $query = new SugarQuery();
            $query->select()->setCountQuery();
            $query->from(BeanFactory::newBean('DRI_Workflows'));
            $query
                ->where()
                ->queryAnd()
                ->equals('dri_workflow_template_id', $id)
                ->equals('deleted', 0);
            $journeys = $query->execute();

            if ($journeys[0]['record_count'] > 0) {
                throw new SugarApiExceptionInvalidParameter(
                    sprintf('Template cannot be deleted, template is used in %u journeys', $journeys[0]['record_count'])
                );
            }
        }
    }

    /**
     * Chek if a journey template with the same name already exists
     *
     * @throws SugarApiExceptionInvalidParameter
     */
    private function validateUniqueName()
    {
        try {
            self::getByName($this->name, $this->id);
            throw new SugarApiExceptionInvalidParameter(sprintf('template with name %s does already exist', $this->name));
        } catch (CJException\CustomerJourneyException $e) {
        }
    }

    /**
     * Calculate the points from the linked stage templates
     */
    private function calculatePoints()
    {
        $this->points = $this->getSumCalculationQuery('points');
    }

    /**
     * Calculate the related activities from the linked stage templates
     */
    private function calculateRelatedActivities()
    {
        $this->related_activities = $this->getSumCalculationQuery('related_activities');
    }

    private function getSumCalculationQuery($sumFieldName)
    {
        $query = new \SugarQuery();
        $query->from(\BeanFactory::newBean('DRI_SubWorkflow_Templates'), ['team_security' => false]);
        $query->select()->fieldRaw("SUM($sumFieldName)");
        $query->where()->equals('deleted', 0);
        $query->where()->equals('dri_workflow_template_id', $this->id);
        return $query->getOne() ?: 0;
    }

    /**
     * Sync the names of the creaeted journeys with the journey template
     */
    private function syncJourneyNames()
    {
        $query = new SugarQuery();
        $query->select('id');
        $query->from(BeanFactory::newBean('DRI_Workflows'));
        $query->where()->equals('dri_workflow_template_id', $this->id);

        foreach ($query->execute() as $row) {
            $journey = BeanFactory::retrieveBean('DRI_Workflows', $row['id'], ['use_cache' => false]);

            if ($journey) {
                $journey->save();
            }
        }
    }

    /**
     * @return array
     */
    public static function listEnabledModulesEnumOptions()
    {
        global $sugar_config;
        $enabledModulesList = [];
        if (!empty($sugar_config['customer_journey']) &&
            !empty($sugar_config['customer_journey']['enabled_modules'])) {
            $enabledModules = $sugar_config['customer_journey']['enabled_modules'];
            $enabledModules = explode(',', $enabledModules);
            foreach ($enabledModules as $enabledModule) {
                $enabledModulesList[$enabledModule] = $enabledModule;
            }
            return $enabledModulesList;
        } else {
            return [];
        }
    }
}
