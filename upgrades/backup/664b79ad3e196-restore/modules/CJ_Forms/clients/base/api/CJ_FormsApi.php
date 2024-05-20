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

use Sugarcrm\Sugarcrm\CustomerJourney\Bean\Activity\ActivityHandlerFactory;
use Sugarcrm\Sugarcrm\CustomerJourney\Bean\SelectToOption as SelectToOption;
use Sugarcrm\Sugarcrm\CustomerJourney\Bean\RSA\TargetResolver as TargetResolver;
use Sugarcrm\Sugarcrm\CustomerJourney\ConfigurationManager;

class CJ_FormsApi extends SugarApi
{
    /**
     * @inheritdoc
     */
    public function registerApiRest()
    {
        return [
            'target' => [
                'reqType' => 'GET',
                'path' => ['?', '?', 'target'],
                'pathVars' => ['module', 'record'],
                'method' => 'target',
                'shortHelp' => 'Resolves the target and return the response for the activity',
                'longHelp' => '/include/api/help/customer_journeyCJ_Formstarget.html',
                'minVersion' => '11.19',
            ],
            'stageTarget' => [
                'reqType' => 'GET',
                'path' => ['?', '?', 'stage-target'],
                'pathVars' => ['module', 'record'],
                'method' => 'stageTarget',
                'shortHelp' => 'Resolves the target and return the response for the stage',
                'longHelp' => '/include/api/help/customer_journeyCJ_FormsstageTarget.html',
                'minVersion' => '11.19',
            ],
            'journeyTarget' => [
                'reqType' => 'GET',
                'path' => ['?', '?', 'journey-target'],
                'pathVars' => ['module', 'record'],
                'method' => 'journeyTarget',
                'shortHelp' => 'Resolves the target and return the response for the Smart Guide',
                'longHelp' => '/include/api/help/customer_journeyCJ_FormsjourneyTarget.html',
                'minVersion' => '11.19',
            ],
            'getTemplateAvailableModules' => [
                'reqType' => 'GET',
                'path' => ['CJ_Forms', 'available-modules'],
                'pathVars' => ['module'],
                'method' => 'getTemplateAvailableModules',
                'shortHelp' => 'Get modules for which template is enabled',
                'longHelp' => '/include/api/help/customer_journeyCJ_FormsgetTemplateAvailableModules.html',
                'minVersion' => '11.19',
            ],
        ];
    }

    /**
     * Resolves the target and return the response for the activity
     *
     * @param ServiceBase $api
     * @param array       $args
     * @return array
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiExceptionNotFound
     * @throws Exception
     */
    public function target(ServiceBase $api, array $args)
    {
        // Ensure this end-point must be accessible to Sugar Automate Users
        ConfigurationManager::ensureAutomateUser();

        $this->requireArgs($args, ['module', 'record', 'activity_id']);

        /** @var CJ_Form $action */
        $action = $this->loadBean($api, $args);
        $form = BeanFactory::retrieveBean('CJ_Forms', $args['record']);
        $activity = BeanFactory::retrieveBean($action->activity_module, $args['activity_id']);

        if (!empty($form->id) && !empty($activity->id)) {
            $handler = ActivityHandlerFactory::factory($activity->module_dir);
            $stage = $handler->getStage($activity);

            $finder = new TargetResolver($action);
            $response = $finder->resolve($stage, $activity);

            return $this->getTargetResponse($api, $response, $form, $activity);
        }

        return $this->getNotFoundResponse('activity');
    }

    /**
     * Resolves the target and return the response for the stage
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiExceptionNotFound
     * @throws Exception
     */
    public function stageTarget(ServiceBase $api, array $args)
    {
        // Ensure this end-point must be accessible to Sugar Automate Users
        ConfigurationManager::ensureAutomateUser();

        $this->requireArgs($args, ['module', 'record', 'stage_id']);

        /** @var CJ_Form $action */
        $action = $this->loadBean($api, $args);
        $form = BeanFactory::retrieveBean('CJ_Forms', $args['record']);
        $stage = BeanFactory::retrieveBean('DRI_SubWorkflows', $args['stage_id']);

        if (!empty($form->id) && !empty($stage->id)) {
            $parent = $stage->getParent();

            $finder = new TargetResolver($action);
            $response = $finder->resolve($parent, $stage);

            return $this->getTargetResponse($api, $response, $form, $stage);
        }

        return $this->getNotFoundResponse('stage');
    }
    
    /**
     * Resolves the target and return the response for the Smart Guide
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiExceptionNotFound
     * @throws Exception
     */
    public function journeyTarget(ServiceBase $api, array $args)
    {
        // Ensure this end-point must be accessible to Sugar Automate Users
        ConfigurationManager::ensureAutomateUser();

        $this->requireArgs($args, ['module', 'record', 'journey_id']);

        /** @var CJ_Form $action */
        $action = $this->loadBean($api, $args);
        $form = BeanFactory::retrieveBean('CJ_Forms', $args['record']);
        $journey = BeanFactory::retrieveBean('DRI_Workflows', $args['journey_id']);

        if (!empty($form->id) && !empty($journey->id)) {
            $parent = $journey->getParent();

            $finder = new TargetResolver($action);
            $response = $finder->resolve($parent, $journey);

            return $this->getTargetResponse($api, $response, $form, $journey);
        }

        return $this->getNotFoundResponse('journey');
    }

    /**
     * Get the target response
     *
     * @param ServiceBase $api
     * @param array $response
     * @param \CJ_Form $form
     * @param \SugarBean $activityOrStageOrJourney
     * @return array
     */
    private function getTargetResponse($api, $response, $form, $activityOrStageOrJourney)
    {
        return [
            'parent' => $this->formatBean($api, [], $response['parent']),
            'target' => $response['target'] ? $this->formatBean($api, [], $response['target']) : null,
            'linkName' => $response['linkName'],
            'module' => $response['module'],
            'emailData' => $this->getDataForEmailCompose($form, $activityOrStageOrJourney),
        ];
    }

    /**
     * Provide response when Form / Stage Id is not found
     *
     * @param string $target
     * @return array
     */
    private function getNotFoundResponse($target)
    {
        return [
            'status' => 'Not Found',
            'message' => "Form / Stage Id was not found, so $target can not be resolved",
        ];
    }

    /**
     * If Form/RSA has email template then load
     * the email template, and recipients information
     *
     * @param array $form
     * @param \SugarBean $activityOrStageOrJourney
     * @return array
     */
    private function getDataForEmailCompose($form, $activityOrStageOrJourney)
    {
        if (empty($form) || empty($form->email_templates_id) || empty($activityOrStageOrJourney)) {
            return [];
        }

        if ((
                $form->action_type == \CJ_Form::ACTION_TYPE_CREATE_RECORD &&
                $form->action_trigger_type == \CJ_Form::ACTION_TRIGGER_AUTOMATIC_CREATE
            ) ||
            (
                $form->action_type == \CJ_Form::ACTION_TYPE_UPDATE_RECORD &&
                $form->action_trigger_type == \CJ_Form::ACTION_TRIGGER_AUTOMATIC_UPDATE
            )
        ) {
            return [];
        }

        $data = [];
        $template = \BeanFactory::retrieveBean(
            'EmailTemplates',
            $form->email_templates_id,
            ['disable_row_level_security' => true]
        );

        if (!empty($template->id)) {
            $data['id'] = $template->id;
            $data['subject'] = $template->subject;
            $data['body_html'] = $template->body_html;
            $recipientsInfo = SelectToOption::getRecipients(
                $form->select_to_email_address,
                SelectToOption::getParentRecord($activityOrStageOrJourney)
            );
            $data['recipientsInfo'] = $recipientsInfo;
            $data['recipientsWithTheirNames'] = SelectToOption::mapRecipientsWithTheirNames($recipientsInfo);
        }
        return $data;
    }

    /**
     * Return the Available Modules In RSA against the selected parent_id and parent_type
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiExceptionNotFound
     * @throws Exception
     */
    public function getTemplateAvailableModules(ServiceBase $api, array $args)
    {
        // Ensure this end-point must be accessible to Sugar Automate Users
        ConfigurationManager::ensureAutomateUser();

        $this->requireArgs($args, ['module', 'parent_type', 'parent_id']);

        if (empty($args['parent_type']) ||
            empty($args['parent_id']) ||
            !in_array($args['parent_type'], ['DRI_Workflow_Task_Templates', 'DRI_SubWorkflow_Templates'])
        ) {
            return [];
        }

        $query = new SugarQuery();
        $query->from(BeanFactory::newBean($args['parent_type']), ['team_security' => false]);
        $templateJoin = $query->join('dri_workflow_template_link')->joinName();

        $query->select(["$templateJoin.available_modules"]);
        $query->where()->equals('id', $args['parent_id']);

        $result = $query->getOne();

        return (!empty($result)) ? unencodeMultienum($result) : [];
    }
}
