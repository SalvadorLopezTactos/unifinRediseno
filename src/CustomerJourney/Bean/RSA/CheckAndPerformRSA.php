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

namespace Sugarcrm\Sugarcrm\CustomerJourney\Bean\RSA;

use Sugarcrm\Sugarcrm\CustomerJourney\Bean\RSA\TargetResolver as TargetResolver;
use Sugarcrm\Sugarcrm\CustomerJourney\Exception as CJException;
use Sugarcrm\Sugarcrm\CustomerJourney\Bean\RSA\Email as CJFormsEmail;
use Sugarcrm\Sugarcrm\Util\Uuid;

class CheckAndPerformRSA
{

    /**
     * Automatically update or create a record based on the related sugar action
     *
     * @param SugarBean $stageOrJourney
     */
    public static function checkRelatedSugarAction($stageOrJourney)
    {
        $rsaBeans = self::getForms($stageOrJourney);

        foreach ($rsaBeans as $rsaBean) {
            self::performRelatedSugarAction($rsaBean, $stageOrJourney);
        }
    }

    /**
     * Get the forms against the stage or journey
     *
     * @param object $stageOrJourney
     * @return array
     */
    public static function getForms($stageOrJourney)
    {
        $filtered = [];
        $stageOrJourneyTemplate = $stageOrJourney->getTemplate();

        if ($stageOrJourneyTemplate->load_relationship('forms')) {
            $forms = $stageOrJourneyTemplate->forms->getBeans();
            if ($forms) {
                foreach ($forms as $form) {
                    if ($form->active && $form->parent_id === $stageOrJourneyTemplate->id) {
                        $filtered[] = $form;
                    }
                }
            }
        }

        return $filtered;
    }

    /**
     * It will handle the automatic create/update of the stage and journey records
     *
     * @param \SugarBean $RSABean
     * @param \SugarBean $stageOrJourney
     * @throws \SugarApiExceptionError
     * @throws \SugarApiExceptionInvalidParameter
     */
    private static function performRelatedSugarAction(\SugarBean $RSABean, \SugarBean $stageOrJourney)
    {
        if (!($RSABean->action_type === \CJ_Form::ACTION_TYPE_CREATE_RECORD || $RSABean->action_type === \CJ_Form::ACTION_TYPE_UPDATE_RECORD)) {
            return;
        }

        if (($RSABean->action_type === \CJ_Form::ACTION_TYPE_CREATE_RECORD && $RSABean->action_trigger_type !== \CJ_Form::ACTION_TRIGGER_AUTOMATIC_CREATE) ||
            ($RSABean->action_type === \CJ_Form::ACTION_TYPE_UPDATE_RECORD && $RSABean->action_trigger_type !== \CJ_Form::ACTION_TRIGGER_AUTOMATIC_UPDATE)
        ) {
            return;
        }

        if (($stageOrJourney->module_dir === "DRI_SubWorkflows" && ((($stageOrJourney->state === "completed") && $RSABean->trigger_event === \CJ_Form::TRIGGER_EVENT_COMPLETED) ||
                (($stageOrJourney->state === "in_progress") && $RSABean->trigger_event === \CJ_Form::TRIGGER_EVENT_IN_PROGRESS))) ||
                ($stageOrJourney->module_dir === "DRI_Workflows" && ($stageOrJourney->state === "completed") && $RSABean->trigger_event === \CJ_Form::TRIGGER_EVENT_COMPLETED)
        ) {
            try {
                $parent = $stageOrJourney->getParent();
            } catch (CJException\ParentNotFoundException $e) {
                return;
            }

            $finder = new TargetResolver($RSABean);

            try {
                $response = $finder->resolve($parent, $stageOrJourney);
            } catch (\SugarApiExceptionError $e) {
                if ($RSABean->ignore_errors) {
                    return;
                }
                throw new \SugarApiExceptionError($e->getMessage());
            }

            $parent = $response['parent'];
            $target = $response['target'];
            $linkName = $response['linkName'];
            $module = $response['module'];
            $allBeans = $response['allBeans'];

            if (empty($parent->id) || ($RSABean->action_type === \CJ_Form::ACTION_TYPE_UPDATE_RECORD && $RSABean->action_trigger_type === \CJ_Form::ACTION_TRIGGER_AUTOMATIC_UPDATE && empty($target->id))) {
                if (!$RSABean->ignore_errors) {
                    throw new \SugarApiExceptionInvalidParameter(translate('LBL_COULD_NOT_FIND_RELATED_RECORD', 'CJ_Forms'));
                }
                return;
            }

            $id = ($RSABean->action_trigger_type === \CJ_Form::ACTION_TRIGGER_AUTOMATIC_UPDATE) ? $target->id : null;
            $target2 = \BeanFactory::retrieveBean($module, $id, array ('use_cache' => false));

            if (!empty($target2->id)) { //Update all the related records
                foreach ($allBeans as $singleBean) {
                    $child = \BeanFactory::getBean($module, $singleBean->id);
                    \CJ_Form::setTargetValues($child, $RSABean);
                    $child->save();
                }
            } else { //create records
                \CJ_Form::setTargetValues($target2, $RSABean);

                if ($target2->module_dir === "DRI_SubWorkflows" && empty($target2->dri_subworkflow_template_id)) {
                    $target2->dri_subworkflow_template_id = "5deef3ac-fcc9-11e6-9550-5254009e5526";
                    $target2->dri_workflow_id = $target->dri_workflow_id;
                } elseif ($target2->module_dir == "DRI_Workflows" && empty($target2->dri_workflow_template_id)) {
                    $target2->dri_workflow_template_id = "ea1ecdea-f835-11e6-b8bd-5254009e5526";
                } elseif ($target2->module_dir === 'Emails' && !empty($RSABean->email_templates_id)) {
                    (new CJFormsEmail())->sendEmail($target2, $RSABean, $stageOrJourney);
                }
                $target2->save();
            }

            if ($parent->load_relationship($linkName)) {
                $parent->$linkName->add($target2->id);
            }
        }
    }
}
