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
 * Class ADAMImporterImport a record from a file encryption
 *
 * This class imports a record of an encrypted file to a table in the database
 * @package PMSE
 */
class PMSEImporter
{

    /**
     * @var $beanFactory
     * @access private
     */
    protected $beanFactory;
    /**
     * @var $bean
     * @access private
     */
    protected $bean;
    /**
     * @var $id
     * @access private
     */
    protected $id;
    /**
     * @var $name
     * @access private
     */
    protected $name;

    /**
     * @var $suffix
     * @access private
     */
    protected $suffix = '';

    /**
     * @var $extension
     * @access private
     */
    protected $extension;

    /**
     * @var $module
     * @access private
     */
    protected $module;

    /**
     * Get class Bean.
     * @codeCoverageIgnore
     * @return object
     */
    public function getBean()
    {
        return $this->bean;
    }

    /**
     * Set Bean.
     * @codeCoverageIgnore
     * @param object $bean
     * @return void
     */
    public function setBean($bean)
    {
        $this->bean = $bean;
    }

    /**
     * Get Name of a file.
     * @codeCoverageIgnore
     * @return object
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set extension of file to be imported.
     * @codeCoverageIgnore
     * @param string $extension
     * @return void
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * get extension of file to be imported.
     * @codeCoverageIgnore
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set name of file to be imported.
     * @codeCoverageIgnore
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Method to upload a file and read content for import in database
     * @param $file
     * @return bool
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiExceptionRequestMethodFailure
     * @codeCoverageIgnore
     */
    public function importProject($file)
    {
        $_data = $this->getDataFile($file);
        if ($this->isPAOldVersionFile($_data)) {
            LoggerManager::getLogger()->fatal('PA Unsupported file. The version of this file is not currently supported.');
            throw new SugarApiExceptionRequestMethodFailure('ERROR_PA_UNSUPPORTED_FILE');
        }
        $project = json_decode($_data, true);
        if (!empty($project) && isset($project['project'])) {
            if (in_array($project['project'][$this->module], PMSEEngineUtils::getSupportedModules())) {
                $result = $this->saveProjectData($project['project']);
            } else {
                throw new SugarApiExceptionNotAuthorized('EXCEPTION_NOT_AUTHORIZED');
            }
        } else {
            throw new SugarApiExceptionRequestMethodFailure('ERROR_UPLOAD_FAILED');
        }
        return $result;
    }


    /**
     * Detects if the string start as a serialize php file
     * @param $data
     * @return bool
     */
    protected function isPAOldVersionFile($data) {
        return (substr($data, 0, 4) == 'a:2:');
    }

    /**
     * Function to get a data for File uploaded
     * @param $file
     * @return mixed
     */
    public function getDataFile($file)
    {
        //return file_get_contents($file);
        require_once 'include/upload_file.php';

        $_file = new UploadFile();

        //get the file location
        $_file->temp_file_location = $file;

        $_data = $_file->get_file_contents();

        return $_data;
    }

    /**
     * Method to save record in database
     * @param $projectData
     * @return bool
     */
    public function saveProjectData($projectData)
    {
        global $current_user;
        $result = array('success' => false);
        //Unset common fields
        $projectData = PMSEEngineUtils::unsetCommonFields($projectData, array('name', 'description'));
        //unset($projectData['assigned_user_id']);
        if (!isset($projectData['assigned_user_id'])) {
            $projectData['assigned_user_id'] = $current_user->id;
        }
        //Check Name of project
        if (isset($projectData[$this->suffix . 'name']) && !empty($projectData[$this->suffix . 'name'])) {
            $name = $this->getNameWithSuffix($projectData[$this->suffix . 'name']);
        } else {
            $name = $this->getNameWithSuffix($projectData[$this->name]);
        }
        $projectData[$this->name] = $name;
        foreach ($projectData as $key => $field) {
            $this->bean->$key = $field;
        }
        //$this->bean->new_with_id = true;
        //$this->bean->validateUniqueUid();
        $new_id = $this->bean->save();
        if (!$this->bean->in_save) {
            $result['success'] = true;
            $result['id'] = $new_id;
        }
        return $result;
    }

    /**
     * Method to validate name of record, if name is same, add number to the end the name
     * @param $name
     * @return string
     */
    public function getNameWithSuffix($name)
    {
        $nums = array();
        $where = $this->bean->table_name . '.' . $this->name . " LIKE '" . $name . "%'";
        $rows = $this->bean->get_full_list($this->name, $where);
        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $names[] = $row->{$this->name};
                if (preg_match("/\([0-9]+\)$/i", $row->{$this->name}) && $row->{$this->name} != $name) {
                    $aux = substr($row->{$this->name}, strripos($row->{$this->name}, '(') + 1, -1);
                    $nums[] = $aux;
                }
            }
            if (!in_array($name, $names)) {
                $newName = $name;
            } else {
                $num = (count($nums) > 0) ? max($nums) + 1 : 1;
                $newName = $name . ' (' . $num . ')';
            }

        } else {
            $newName = $name;
        }
        return $newName;
    }

    public function unsetCommonFields($projectData, $except = array())
    {
        $special_fields = array(
            'id',
            'date_entered',
            'date_modified',
            'modified_user_id',
            'created_by',
            'deleted',
            'team_id',
            'team_set_id',
            'au_first_name',
            'au_last_name',
            'cbu_first_name',
            'cbu_last_name',
            'mbu_first_name',
            'mbu_last_name',
            'my_favorite',
            'dia_id',
            'prj_id',
            'pro_id'
        );
        //UNSET common fields
        foreach ($projectData as $key => $value) {
            if (in_array($key, $special_fields)) {
                unset($projectData[$key]);
            }
        }
        return $projectData;
    }
}
