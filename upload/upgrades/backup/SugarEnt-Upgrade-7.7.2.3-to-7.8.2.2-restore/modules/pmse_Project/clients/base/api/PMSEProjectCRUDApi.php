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

require_once 'clients/base/api/ModuleApi.php';

require_once 'modules/pmse_Project/clients/base/api/wrappers/PMSEDynaForm.php';
require_once 'modules/pmse_Inbox/engine/PMSEEngineUtils.php';
require_once 'modules/pmse_Inbox/engine/PMSEProjectExporter.php';
require_once 'modules/pmse_Inbox/engine/PMSEProjectImporter.php';

class PMSEProjectCRUDApi extends ModuleApi
{
    public function registerApiRest() {
        return array(
            'create' => array(
                'reqType' => 'POST',
                'path' => array('pmse_Project'),
                'pathVars' => array('module'),
                'method' => 'createRecord',
//                'shortHelp' => 'This method create a new Process Definition record',
            ),
            'update' => array(
                'reqType' => 'PUT',
                'path' => array('pmse_Project','?'),
                'pathVars' => array('module','record'),
                'method' => 'updateRecord',
//                'shortHelp' => 'This method updates a Process Definition record',
            ),
            'delete' => array(
                'reqType' => 'DELETE',
                'path' => array('pmse_Project','?'),
                'pathVars' => array('module','record'),
                'method' => 'deleteRecord',
//                'shortHelp' => 'This method deletes a Process Definition record',
            ),
        );
    }

    public function deleteRecord($api, $args)
    {
        $this->requireArgs($args,array('module','record'));

        $projectBean = BeanFactory::getBean($args['module'], $args['record']);
        $projectBean->prj_status = 'INACTIVE';
        $projectBean->save();

        $diagramBean =  BeanFactory::getBean('pmse_BpmnDiagram')->retrieve_by_string_fields(array('prj_id'=>$args['record']));
        $diagramBean->deleted = 1;
        $diagramBean->save();

        $processBean = BeanFactory::getBean('pmse_BpmnProcess')->retrieve_by_string_fields(array('prj_id'=>$args['record']));
        $processBean->deleted = 1;
        $processBean->save();

        $processDefinitionBean = BeanFactory::getBean('pmse_BpmProcessDefinition')->retrieve_by_string_fields(array('prj_id'=>$args['record']));
        $processDefinitionBean->deleted = 1;
        $processDefinitionBean->save();

        while($relatedDepBean = BeanFactory::getBean('pmse_BpmRelatedDependency')->retrieve_by_string_fields(array('prj_id'=>$args['record'], 'deleted'=>0))) {
            $relatedDepBean->deleted = 1;
            $relatedDepBean->save();
        }


        $bean = $this->loadBean($api, $args, 'delete');
        $bean->mark_deleted($args['record']);

        return array('id'=>$bean->id);
    }

    protected function saveBean(SugarBean $bean, ServiceBase $api, array $args)
    {
        parent::saveBean($bean, $api, $args);

        $projectBean = $bean;
        $id = $projectBean->id;

        //Create a Diagram row
        $diagramBean =  BeanFactory::getBean('pmse_BpmnDiagram')->retrieve_by_string_fields(array('prj_id'=>$id));
        if (empty($diagramBean)) {
            $diagramBean = BeanFactory::newBean('pmse_BpmnDiagram');
            $diagramBean->dia_uid = PMSEEngineUtils::generateUniqueID();
        }
        $diagramBean->name = $projectBean->name;
        $diagramBean->description = $projectBean->description;
        $diagramBean->assigned_user_id = $projectBean->assigned_user_id;
        $diagramBean->prj_id = $id;
        $dia_id = $diagramBean->save();

        //Create a Process row
        $processBean = BeanFactory::getBean('pmse_BpmnProcess')->retrieve_by_string_fields(array('prj_id'=>$id));
        if (empty($processBean)) {
            $processBean = BeanFactory::newBean('pmse_BpmnProcess');
            $processBean->pro_uid = PMSEEngineUtils::generateUniqueID();
        }
        $processBean->name = $projectBean->name;
        $processBean->description = $projectBean->description;
        $processBean->assigned_user_id = $projectBean->assigned_user_id;
        $processBean->prj_id = $id;
        $processBean->dia_id = $dia_id;
        $pro_id = $processBean->save();

        //Create a ProcessDefinition row
        $processDefinitionBean = BeanFactory::getBean('pmse_BpmProcessDefinition')->retrieve_by_string_fields(array('prj_id'=>$id));
        if (empty($processDefinitionBean)) {
            $processDefinitionBean = BeanFactory::newBean('pmse_BpmProcessDefinition');
            $processDefinitionBean->id = $pro_id;
            $processDefinitionBean->new_with_id = true;
        }
        $processDefinitionBean->prj_id = $id;
        $processDefinitionBean->pro_module = $projectBean->prj_module;
        $processDefinitionBean->pro_status = $projectBean->prj_status;
        $processDefinitionBean->assigned_user_id = $projectBean->assigned_user_id;
        $processDefinitionBean->save();

        $relDepStatus = $projectBean->prj_status=='ACTIVE'?'INACTIVE':'ACTIVE';
        while(
            $relatedDepBean = BeanFactory::getBean('pmse_BpmRelatedDependency')
            ->retrieve_by_string_fields(array('pro_id'=>$pro_id, 'pro_status'=>$relDepStatus))
        ) {
            $relatedDepBean->pro_status = $projectBean->prj_status;
            $relatedDepBean->save();
        }

        $keysArray = array('prj_id' => $id, 'pro_id' => $pro_id);
        $dynaF = BeanFactory::getBean('pmse_BpmDynaForm')->retrieve_by_string_fields(array('prj_id'=>$id, 'pro_id'=>$pro_id, 'name'=>'Default'));
        if (empty($dynaF)) {
            $editDyna = false;
        } else {
            $editDyna = true;
        }
        $dynaForm = new PMSEDynaForm();
        $dynaForm->generateDefaultDynaform($processDefinitionBean->pro_module, $keysArray, $editDyna);

    }


    public function createRecord($api, $args) {
        if (!isset($args['picture_duplicateBeanId'])) {
            return parent::createRecord($api, $args);
        }

        $id = $args['picture_duplicateBeanId'];

        $exporter = new PMSEProjectExporter();
        $project = $exporter->getProject(array('id' => $id));

        $project['project']['name'] =  $args['name'];
        $project['project']['assigned_user_id'] =  $args['assigned_user_id'];
        $project['project']['description'] =  $args['description'];
        $project['project']['prj_status'] = $args['prj_status'];

        $importer = new PMSEProjectImporter();
        $project['_module']['project'] = 'pmse_Project';

        // The importation always changes the project status to INACTIVE except when the case is Copy from a Process Definition
        $savedProject = $importer->saveProjectData($project['project'], true);
        $project['project']['id'] = $savedProject['id'];
        $project['project']['warnings'] = array($savedProject['br_warning'], $savedProject['et_warning']);

        return $project['project'];
    }
}
