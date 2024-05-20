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

use Google\Service\Drive\DriveFile;
use Google\Service\Drive\FileList;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Sugarcrm\Sugarcrm\CloudDrive\DriveFacade;
use Sugarcrm\Sugarcrm\CloudDrive\Model\DriveItem;
use Sugarcrm\Sugarcrm\Util\Uuid;

/**
 * Google Drive Api
 */
class CloudDriveApi extends SugarApi
{
    /**
     * @var \Sugarcrm\Sugarcrm\CloudDrive\DriveFacade|mixed
     */
    public $driveFacade;
    /**
     * @inheritdoc
     */
    public function registerApiRest()
    {
        return [
            'listFiles' => [
                'reqType' => 'POST',
                'path' => ['CloudDrive', 'list', 'files',],
                'pathVars' => ['CloudDrive', 'list', 'files',],
                'method' => 'listFiles',
                'shortHelp' => 'Lists files in a folder',
                'longHelp' => 'include/api/help/cloud_drive_list_files.html',
                'minVersion' => '11.16',
            ],
            'listFolders' => [
                'reqType' => 'POST',
                'path' => ['CloudDrive', 'list', 'folders',],
                'pathVars' => ['CloudDrive', 'list', 'folders',],
                'method' => 'listFolders',
                'shortHelp' => 'Lists folders in a drive',
                'longHelp' => 'include/api/help/cloud_drive_list_folders.html',
                'minVersion' => '11.16',
            ],
            'getFile' => [
                'reqType' => 'GET',
                'path' => ['CloudDrive', 'file', '?',],
                'pathVars' => ['CloudDrive', 'file', 'fileId',],
                'method' => 'getFile',
                'shortHelp' => 'Retrieves a file data',
                'longHelp' => 'include/api/help/cloud_drive_file.html',
                'minVersion' => '11.16',
            ],
            'getSharedLink' => [
                'reqType' => 'POST',
                'path' => ['CloudDrive', 'shared', 'link',],
                'pathVars' => ['CloudDrive', 'shared', 'link',],
                'method' => 'getSharedLink',
                'shortHelp' => 'Retrieves a file shared link',
                'longHelp' => 'include/api/help/cloud_drive_shared_link.html',
                'minVersion' => '11.16',
            ],
            'syncAllFiles' => [
                'reqType' => 'POST',
                'path' => ['CloudDrive', 'files', 'syncAll',],
                'pathVars' => ['CloudDrive', 'files', 'syncAll',],
                'method' => 'syncAllFiles',
                'shortHelp' => 'Syncs documents',
                'longHelp' => 'include/api/help/cloud_drive_sync_all.html',
                'minVersion' => '11.16',
            ],
            'syncFile' => [
                'reqType' => 'POST',
                'path' => ['CloudDrive', 'files', 'syncFile',],
                'pathVars' => ['CloudDrive', 'files', 'syncFile',],
                'method' => 'syncFile',
                'shortHelp' => 'Syncs document',
                'longHelp' => 'include/api/help/cloud_drive_sync_file.html',
                'minVersion' => '11.16',
            ],
            'download' => [
                'reqType' => 'POST',
                'path' => ['CloudDrive', 'download',],
                'pathVars' => ['CloudDrive', 'download',],
                'method' => 'downloadFile',
                'shortHelp' => 'downloads a file',
                'longHelp' => 'include/api/help/cloud_drive_download_file.html',
                'minVersion' => '11.16',
            ],
            'delete' => [
                'reqType' => 'POST',
                'path' => ['CloudDrive', 'delete',],
                'pathVars' => ['CloudDrive', 'delete',],
                'method' => 'deleteFile',
                'shortHelp' => 'deletes a file',
                'longHelp' => 'include/api/help/cloud_drive_delete_file.html',
                'minVersion' => '11.16',
            ],
            'createSugarDocument' => [
                'reqType' => 'POST',
                'path' => ['CloudDrive', 'createSugarDocument',],
                'pathVars' => ['CloudDrive', 'createSugarDocument',],
                'method' => 'createSugarDocument',
                'shortHelp' => 'creates a sugar document',
                'longHelp' => 'include/api/help/cloud_drive_create_document.html',
                'minVersion' => '11.16',
            ],
            'getDrivePaths' => [
                'reqType' => 'GET',
                'path' => ['CloudDrive', 'paths',],
                'pathVars' => ['CloudDrive', 'paths',],
                'method' => 'getDrivePaths',
                'shortHelp' => 'retrieves the drive paths',
                'longHelp' => 'include/api/help/cloud_drive_paths.html',
                'minVersion' => '11.16',
            ],
            'createDrivePath' => [
                'reqType' => 'POST',
                'path' => ['CloudDrive', 'path',],
                'pathVars' => ['CloudDrive', 'path',],
                'method' => 'createDrivePath',
                'shortHelp' => 'creates a drive path',
                'longHelp' => 'include/api/help/cloud_drive_path_create.html',
                'minVersion' => '11.16',
            ],
            'getDrivePath' => [
                'reqType' => 'GET',
                'path' => ['CloudDrive', 'path',],
                'pathVars' => ['CloudDrive', 'path',],
                'method' => 'getDrivePath',
                'shortHelp' => 'retrieves a drive path',
                'longHelp' => 'include/api/help/cloud_drive_get_path.html',
                'minVersion' => '11.16',
            ],
            'removeDrivePath' => [
                'reqType' => 'DELETE',
                'path' => ['CloudDrive', 'path',],
                'pathVars' => ['CloudDrive', 'path',],
                'method' => 'removeDrivePath',
                'shortHelp' => 'removes a drive path',
                'longHelp' => 'include/api/help/cloud_drive_remove_path.html',
                'minVersion' => '11.16',
            ],
            'createFolder' => [
                'reqType' => 'POST',
                'path' => ['CloudDrive', 'folder',],
                'pathVars' => ['CloudDrive', 'folder',],
                'method' => 'createFolder',
                'shortHelp' => 'creates a drive folder',
                'longHelp' => 'include/api/help/cloud_drive_create_folder.html',
                'minVersion' => '11.16',
            ],
            'uploadFile' => [
                'reqType' => 'POST',
                'path' => ['CloudDrive', 'file',],
                'pathVars' => ['CloudDrive', 'file',],
                'method' => 'uploadToDrive',
                'shortHelp' => 'creates a file on the drive',
                'longHelp' => 'include/api/help/cloud_drive_create_file.html',
                'minVersion' => '11.16',
            ],
            'uploadDocument' => [
                'reqType' => 'POST',
                'path' => ['CloudDrive', 'document',],
                'pathVars' => ['CloudDrive', 'document',],
                'method' => 'uploadDocumentToDrive',
                'shortHelp' => 'create a file on the drive',
                'longHelp' => 'include/api/help/cloud_drive_create_file_from_doc.html',
                'minVersion' => '11.18',
            ],
        ];
    }

    /**
     * List files in a folder
     *
     * @param ServiceBase $api
     * @param array $args
     * @return void
     */
    public function listFiles(ServiceBase $api, array $args)
    {
        $this->requireArgs($args, ['type',]);
        $this->driveFacade = $this->getDrive($args['type']);
        return $this->driveFacade->listFiles($args);
    }

    /**
     * List folders in a drive
     *
     * @param ServiceBase $api
     * @param array $args
     * @return FileList|bool
     */
    public function listFolders(ServiceBase $api, array $args)
    {
        $this->requireArgs($args, ['type',]);
        $driveFacade = $this->getDrive($args['type']);
        return $driveFacade->listFolders($args);
    }

    /**
     * Retrieves a file from google drive
     *
     * @param ServiceBase $api
     * @param array $args
     * @return false|array|DriveFile
     */
    public function getFile(ServiceBase $api, array $args)
    {
        $this->requireArgs($args, ['type',]);
        $driveFacade = $this->getDrive($args['type']);
        return $driveFacade->getFile($args);
    }

    /**
     * Retrieves a file from google drive
     *
     * @param ServiceBase $api
     * @param array $args
     * @return false|array
     */
    public function getSharedLink(ServiceBase $api, array $args)
    {
        $this->requireArgs($args, ['type',]);
        $driveFacade = $this->getDrive($args['type']);
        return $driveFacade->getSharedLink($args);
    }

    /**
     *  Syncs all files to google drive
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function syncAllFiles(ServiceBase $api, array $args): array
    {
        $this->requireArgs($args, ['type', 'module', 'recordId',]);

        $largeFile = false;
        $module = $args['module'];
        $recordId = $args['recordId'];
        $pathId = $args['path'];
        $driveId = $args['driveId'];
        $folderPath = array_key_exists('folderPath', $args) ? $args['folderPath'] : [];

        $driveFacade = $this->getDrive($args['type']);

        $recordBean = \BeanFactory::retrieveBean($module, $recordId);

        /**
         * This will search first for 'documents' relationship
         * Otherwise it will return the first relationship it finds with Documents
         */
        $documentsRelatiosnhipName = $this->getDocumentsRelationshipName($recordBean);
        if ($recordBean->load_relationship($documentsRelatiosnhipName)) {
            $documentIds = $recordBean->documents->get();
        }

        foreach ($documentIds as $documentId) {
            $documentBean = \BeanFactory::retrieveBean('Documents', $documentId);

            $this->checkDocumentAttachedFile($documentBean);

            $filePath = $driveFacade->getDrive()->getFilePath($documentBean);
            $path = $folderPath;
            $path[] = [
                'name' => $documentBean->filename,
            ];
            $uploadOptions = [
                'documentBean' => $documentBean,
                'filePath' => $filePath,
                'pathId' => $pathId,
                'fileName' => $documentBean->filename,
                'driveId' => $driveId,
                'folderPath' => $path,
                'fileSize' => $documentBean->latest_revision_file_size,
            ];
            $uploadOptions = $this->checkForLargeFile($uploadOptions, $documentBean->latest_revision_file_size);

            if ($uploadOptions['largeFile']) {
                $largeFile = true;
            }

            try {
                $driveFacade->uploadFile($uploadOptions);
            } catch (Google_Exception $e) {
                $GLOBALS['log']->fatal($e);
                return [
                    'success' => false,
                ];
            }
        }

        if ($largeFile) {
            return [
                'success' => true,
                'message' => 'LBL_LARGE_FILE_UPLOAD',
            ];
        }

        return [
            'success' => true,
        ];
    }

    /**
     *  Syncs a sugar document to the drive
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function syncFile(ServiceBase $api, array $args): array
    {
        $this->requireArgs($args, ['type', 'module', 'recordId',]);

        $module = $args['module'];
        $recordId = $args['recordId'];
        $pathId = $args['path'];
        $driveId = $args['driveId'];
        $folderPath = array_key_exists('folderPath', $args) ? $args['folderPath'] : [];
        $driveFacade = $this->getDrive($args['type']);

        $documentBean = \BeanFactory::retrieveBean($module, $recordId);

        $this->checkDocumentAttachedFile($documentBean);

        $filePath = $driveFacade->getDrive()->getFilePath($documentBean);
        $folderPath[] = [
            'name' => $documentBean->filename,
        ];

        $uploadOptions = [
            'documentBean' => $documentBean,
            'filePath' => $filePath,
            'pathId' => $pathId,
            'fileName' => $documentBean->filename,
            'driveId' => $driveId,
            'folderPath' => $folderPath,
            'fileSize' => $documentBean->latest_revision_file_size,
        ];
        $uploadOptions = $this->checkForLargeFile($uploadOptions, $documentBean->latest_revision_file_size);

        try {
            $response = $driveFacade->uploadFile($uploadOptions);
        } catch (Google_Exception $e) {
            $GLOBALS['log']->fatal($e);
            return false;
        }

        return $response;
    }

    /**
     * Checks for large file
     *
     * @param array $options
     * @param int $size
     *
     * @return array
     */
    public function checkForLargeFile($options, $size): array
    {
        $maxUploadSize = 4194304;

        if ($size > $maxUploadSize) {
            $options['largeFile'] = true;
        }

        return $options;
    }

    /**
     *  Downloads a file from the drive
     *
     * @param ServiceBase $api
     * @param array $args
     * @return bool|array
     */
    public function downloadFile(ServiceBase $api, array $args)
    {
        $this->requireArgs($args, ['type',]);
        $driveFacade = $this->getDrive($args['type']);
        return $driveFacade->downloadFile($args);
    }

    /**
     *  Deletes a file from the drive
     *
     * @param ServiceBase $api
     * @param array $args
     * @return bool|array
     */
    public function deleteFile(ServiceBase $api, array $args): ?array
    {
        $this->requireArgs($args, ['type',]);
        $driveFacade = $this->getDrive($args['type']);
        return $driveFacade->deleteFile($args);
    }

    /**
     *  Creates a sugar document
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     * @throws SugarApiExceptionNotAuthorized
     */
    public function createSugarDocument(ServiceBase $api, array $args): array
    {
        if (!SugarACL::checkAccess('Documents', 'create')) {
            throw new SugarApiExceptionNotAuthorized('No access to create records for module Documents');
        }
        $this->requireArgs($args, ['fileId', 'fileName', 'type',]);
        $fileId = $args['fileId'];
        $recordModule = $args['recordModule'];
        $recordId = $args['recordId'];
        $fileName = $args['fileName'];
        $documentId = Uuid::uuid4();
        $revisionId = Uuid::uuid4();

        try {
            $fileData = $this->downloadFile($api, $args);
        } catch (Google_Exception $e) {
            throw $e;
        }

        if (array_key_exists('success', $fileData) && !$fileData['success']) {
            return $fileData;
        }

        $fileContent = $fileData['content'];
        $args['mimeType'] = $fileData['mimeType'];

        //Adding extension for files like google docs/spreadsheets/presentations
        if (strrpos($fileName, '.') === false) {
            $fileName = $this->addFileExtension($args);
        }

        $this->createFile($revisionId, $fileContent);
        $this->createRevisionBean($fileName, $documentId, $revisionId);
        $this->createDocumentBean($fileName, $documentId, $fileId, $revisionId);

        if ($recordModule && $recordId) {
            $this->addDocumentRelationship($recordModule, $recordId, $documentId);
        }

        return [
            'success' => true,
            'documentId' => $documentId,
        ];
    }

    /**
     * Add file extension for files which don't have it set
     *
     * @param array $args
     * @return string
     */
    public function addFileExtension(array $args)
    {
        $fileName = $args['fileName'];
        $this->requireArgs($args, ['type',]);
        $driveFacade = $this->getDrive($args['type']);
        $extension = $driveFacade->getFileExtension($args);
        $fileName = $fileName.$extension;

        return $fileName;
    }

    /**
     * Get Drive facade
     *
     * @param string $type
     * @return DriveFacade
     */
    protected function getDrive(string $type)
    {
        return new DriveFacade($type);
    }

    /**
     * Creates a file in sugar
     *
     * @param string $fileId
     * @param string $fileContent
     * @return string
     */
    private function createFile(string $fileId, string $fileContent): string
    {
        $uploadFile = new UploadFile('filename_file');
        $uploadFile->set_for_soap($fileId, base64_decode($fileContent));

        return $uploadFile->final_move($fileId);
    }

    /**
     * Creates a document bean
     *
     * @param string $fileName
     * @param string $documentId
     * @param string $fileId
     * @param string $revisionId
     * @return void
     */
    private function createDocumentBean(string $fileName, string $documentId, string $fileId, string $revisionId): void
    {
        global $current_user;
        $uploadFolder = 'upload://';

        $document = new \Document();
        $document->name = $fileName;

        $document->filename = $fileName;
        $document->filename_file = $uploadFolder.$revisionId;
        $document->document_name = $fileName;
        $document->id = $documentId;
        $document->document_revision_id = $revisionId;
        $document->new_with_id = true;
        $document->created_by = $current_user->id;
        $document->assigned_user_id = $current_user->id;
        $document->team_id = $current_user->team_id;
        $document->modified_user_id = $current_user->id;
        $document->save();

        if ($document->load_relationship('revisions')) {
            $document->revisions->add($revisionId);
        }
    }

    /**
     * Creates a document revision bean
     *
     * @param string $fileName
     * @param string $fileId
     * @param string $revisionId
     * @return void
     */
    private function createRevisionBean(string $fileName, string $documentId, string $revisionId): void
    {
        global $current_user;

        $revision = new \DocumentRevision();
        $revision->id = $revisionId;
        $revision->document_id = $documentId;
        $revision->revision = '1';
        $revision->filename = $fileName;
        $revision->doc_url = 'upload://'.$revisionId;
        $revision->doc_type = 'Sugar';
        $revision->new_with_id = true;
        $revision->created_by = $current_user->id;
        $revision->assigned_user_id = $current_user->id;
        $revision->team_id = $current_user->team_id;
        $revision->modified_user_id = $current_user->id;
        $revision->save();
    }


    /**
     * Adds a document relationship
     *
     * @param string $recordModule
     * @param string $recordId
     * @param string $documentId
     * @return void
     */
    private function addDocumentRelationship(string $recordModule, string $recordId, string $documentId): void
    {
        $bean = BeanFactory::retrieveBean($recordModule, $recordId);
        $this->addToRelationship($bean, 'Documents', $documentId);
    }

    /**
     * Adds a record to a given relationship
     *
     * @param SugarBean $bean - The current record
     * @param string $relationshipModule
     * @param string $relationshipId
     */
    private function addToRelationship(\SugarBean $bean, string $relationshipModule, string $relationshipId): void
    {
        foreach ($bean->field_defs as $fieldName => $def) {
            //if the field doesn't have a relationship def. It is not a rel/link field.
            if (!isset($def['relationship'])) {
                continue;
            }

            $relationship = $this->getRelationshipName($def, $relationshipModule, $bean);
            if ($bean->load_relationship($relationship)) {
                $bean->{$relationship}->add($relationshipId);
            }
        }
    }

    /**
     * Gets the name of the relationship given the defintion of a link field and a module
     *
     * @param array fieldDef
     * @param string relationshipModule
     * @param Sugarbean bean
     *
     * @return string|null
     */
    private function getRelationshipName(array $linkDef, string $relationshipModule, \SugarBean $bean): ?string
    {
        $relationshipName = null;
        $rel = SugarRelationshipFactory::getInstance()->getRelationship($linkDef['relationship']);

        if ($rel) {
            $lhsModule = $rel->getLHSModule();
            $rhsModule = $rel->getRHSModule();

            if ($lhsModule === $relationshipModule || $rhsModule === $relationshipModule) {
                $bean->load_relationship($linkDef['relationship'])
                    ? $relationshipName = $linkDef['relationship'] :
                        ($bean->load_relationship($linkDef['name']) ? $relationshipName = $linkDef['name'] : $relationshipName = null);
            }
        }

        return $relationshipName;
    }

    /**
     * The documents relationship might not always be 'documents'
     * We seach on all relationships and find the one with the module Documents
     *
     * @param SugarBean $bean
     * @return string|null
     */
    private function getDocumentsRelationshipName(\SugarBean $bean): ?string
    {
        if ($bean->load_relationship('documents')) {
            return 'documents';
        }

        foreach ($bean->field_defs as $fieldName => $def) {
            //if the field doesn't have a relationship def. It is not a rel/link field.
            if (!isset($def['relationship'])) {
                continue;
            }

            $relationshipName = $this->getRelationshipName($def, 'Documents', $bean);
            if ($relationshipName) {
                return $relationshipName;
            }
        }

        return null;
    }

    /**
     * Gets the list of google record paths
     *
     * @param ServiceBase $api
     * @param array $args
     *
     * @return array
     */
    public function getDrivePaths(ServiceBase $api, array $args): array
    {
        $this->requireArgs($args, ['type',]);

        $sugarQuery = new SugarQuery();
        $sugarQuery->from(BeanFactory::newBean('CloudDrivePaths'), ['team_security' => false]);
        $sugarQuery->where()->equals('type', $args['type']);
        $sugarQuery->where()->equals('deleted', 0);

        if ($args['module']) {
            $sugarQuery->where()->equals('path_module', $args['module']);
        }
        if (isset($args['recordId']) && $args['recordId']) {
            $sugarQuery->where()->equals('record_id', $args['recordId']);
        }

        $result = $sugarQuery->execute();

        return $result;
    }

    /**
     * Creates a new drive path
     *
     * @param ServiceBase $api
     * @param array $args
     *
     * @return string
     */
    public function createDrivePath(ServiceBase $api, array $args): string
    {
        $this->requireArgs($args, ['type',]);

        $drivePath = null;

        if ($args['isRoot']) {
            $drivePath = $this->findRoot($args['type']);
        }

        if (!$drivePath) {
            $pathArgs = [
                'type' => $args['type'],
                'module' => $args['pathModule'],
                'recordId' => $args['recordId'],
                'driveId' => $args['driveId'],
            ];

            $paths = $this->getDrivePaths($api, $pathArgs);
            if (count($paths) > 0) {
                $path = $paths[0];
                $drivePath = BeanFactory::retrieveBean('CloudDrivePaths', $path['id']);
            }
        }

        if (!isset($drivePath)) {
            $drivePath = BeanFactory::newBean('CloudDrivePaths');
        }

        $drivePath->record_id = $args['recordId'];
        $drivePath->path_module = $args['pathModule'];
        $drivePath->type = $args['type'];
        $drivePath->folder_id = $args['folderId'];
        $drivePath->path = $args['drivePath'];
        $drivePath->is_root = $args['isRoot'];
        $drivePath->is_shared = $args['isShared'];
        $drivePath->drive_id = $args['driveId'];

        $drivePath->save();

        return $drivePath->id;
    }

    /**
     * Find folder root
     *
     * @param string $type
     * @return null|SugarBean
     * @throws SugarQueryException
     * @throws SugarApiExceptionNotFound
     */
    protected function findRoot(string $type): ?SugarBean
    {
        $sugarQuery = new SugarQuery();
        $sugarQuery->from(\BeanFactory::newBean('CloudDrivePaths'), ['team_security' => false]);
        $sugarQuery->where()->equals('type', $type);
        $sugarQuery->where()->equals('is_root', 1);
        $sugarQuery->where()->equals('deleted', 0);
        $result = $sugarQuery->execute();

        if (count($result) > 0) {
            $pathData = $result[0];
            $driveBean = BeanFactory::retrieveBean('CloudDrivePaths', $pathData['id']);

            return $driveBean;
        }
        return null;
    }

    /**
     * Retreives a folder_id given a path
     * @todo - refactor
     *
     * @param ServiceBase $api
     * @param array $args
     * @return null|array
     */
    public function getDrivePath(ServiceBase $api, array $args): ?array
    {
        $this->requireArgs($args, ['type',]);

        $client = $this->getClient($args);

        if (is_array($client) && !$client['success']) {
            return $client;
        }

        $paths = [];
        $record = $this->getRecord($args);
        $rootPath = $this->findRoot($args['type']);

        if ($args['layoutName'] === 'record') {
            $paths = $this->getPaths($api, $args);
        }

        try {
            if (count($paths) > 0) {
                $folder = $paths[0];
                $path = $folder['path'];
                $path = $this->parsePath($path, $record);

                if ($args['type'] === 'dropbox' && $folder['path']) {
                    $file = $this->getFile($api, [
                        'folderPath' => $path,
                        'type' => $args['type'],
                    ]);

                    if (is_array($file) && isset($file['message']) && !$file['success']) {
                        return $file;
                    }

                    return [
                        'root' => isset($file['files']) ? true : false,
                        'path' => $path,
                        'isShared' => $folder['is_shared'],
                        'pathCreateIndex' => count((array) $path) - 1,
                    ];
                }

                if ($folder['folder_id']) {
                    $file = $this->getFile($api, [
                        'fileId' => $folder['folder_id'],
                        'driveId' => $folder['drive_id'],
                        'type' => $args['type'],
                    ]);

                    if (is_array($file) && !$file['success']) {
                        return $file;
                    }

                    if (property_exists($file, 'parents')) {
                        return [
                            'root' => $folder['folder_id'],
                            'path' => $folder['path'],
                            'parentId' => $file->parents[0],
                            'isShared' => $folder['is_shared'],
                            'driveId' => $file->driveId,
                        ];
                    }
                }

                if ($path[0]['name'] === 'My files' || $path[0]['name'] === 'Shared') {
                    $path[0]['folderId'] = 'root';
                }

                if (count((array) $path) > 1) {
                    $approximatePath = $this->approximatePath($api, $path, $folder, $args['type']);

                    if (is_null($approximatePath)) {
                        $approximatePath = [
                            'root' => false,
                            'path' => $path,
                            'isShared' => $folder['is_shared'],
                            'driveId' => $folder['drive_id'],
                            'parentId' => 'root',
                            'pathCreateIndex' => 1,
                        ];
                    }
                    return $approximatePath;
                } else {
                    $root = $path[0]['folderId'] ?? false;
                    return [
                        'root' => $root,
                        'path' => $path,
                        'isShared' => $folder['is_shared'],
                        'driveId' => $folder['drive_id'],
                    ];
                }

                return [
                    'root' => false,
                    'path' => $path,
                    'isShared' => $folder->is_shared,
                ];
            }

            if ($rootPath && $rootPath->folder_id) {
                $file = $this->getFile($api, [
                    'fileId' => $rootPath->folder_id,
                    'type' => $args['type'],
                    'driveId' => $rootPath->drive_id,
                ]);

                return [
                    'root' => $rootPath->folder_id,
                    'driveId' => $file->driveId,
                    'path' => $rootPath->path,
                    'parentId' => is_array($file->parents) && count($file->parents) > 0 ? $file->parents[0] : '',
                    'isShared' => $rootPath->is_shared,
                ];
            }
        } catch (Exception $e) {
            throw $e;
        }

        return [
            'root' => 'root',
        ];
    }

    /**
     * Parse path and replace variables
     *
     * @param string $path
     * @param SugarBean $record
     * @return null|array
     */
    private function parsePath(string $path, SugarBean $record): ?array
    {
        /**
         * We handle 2 types of paths here:
         * 1. a json formatted path - it means we already know folder ids
         * 2. just a string - 'path1/path2/{$name}' - this was added manually by the user
         */
        $decodedPath = json_decode($path, true);

        if (is_null($decodedPath) && is_string($path)) {
            $path = trim($path, '/');
            $path = explode('/', $path);
            foreach ($path as $index => $pathSubName) {
                $pathItem = ['name' => $pathSubName];
                $path[$index] = $pathItem;
            }
            $decodedPath = $path;
        }

        foreach ($decodedPath as $index => $pathItem) {
            $pattern = '/\$\w+/';
            preg_match_all($pattern, $pathItem['name'], $matches);

            foreach ($matches[0] as $field) {
                $field = ltrim($field, $field[0]); //remove the dollar sign $fieldValue
                $fieldValue = $record->{$field};
                $field = '$'.$field;
                $pathItem['name'] = str_replace($field, $fieldValue, $pathItem['name']);
            }
            $decodedPath[$index] = $pathItem;
        }
        return $decodedPath;
    }

    /**
     * Initialize a record bean
     *
     * @param array $options
     * @return null|SugarBean
     */
    private function getRecord(array $options): ?SugarBean
    {
        $module = $options['module'];
        $recordId = $options['recordId'];

        if ($recordId) {
            $record = BeanFactory::getBean($module, $recordId);
        } else {
            $record = BeanFactory::newBean($module);
        }
        return $record;
    }

    /**
     * Retrieve paths for a module
     *
     * @param ServiceBase $api
     * @param array $options
     * @return array
     */
    private function getPaths(ServiceBase $api, array $options): array
    {
        //get paths for this module
        $recordPaths = $this->getDrivePaths($api, $options);
        $modulePaths = $this->getDrivePaths($api, [
            'type' => $options['type'],
            'module' => $options['module'],
        ]);
        $paths = count($recordPaths) > 0 ? $recordPaths : $modulePaths;

        return $paths;
    }

    /**
     * Try to find a path that matches our path
     *
     * @param ServiceBase $api
     * @param array $path
     * @param array $pathFolders
     * @param array $currentFolder
     * @param string $type
     * @return null|array
     */
    private function approximatePath(
        ServiceBase $api,
        array $path,
        array $currentFolder,
        string $type
    ): ?array {
        $count = count($path);

        for ($index = $count - 1; $index >= 0; $index--) {
            $folderParent = ($index === 1 && ($path[$index - 1]['name'] === 'My files' || $path[$index - 1]['name'] === 'Shared')) ?
                'root' : $path[$index - 1]['name'];
            $parentId = $path[$index - 1]['folderId'];
            $folderName = ($index === 0 && ($path[$index]['name'] === 'My files' || $path[$index]['name'] === 'Shared')) ? 'root' : $path[$index]['name'];

            $driveId = $currentFolder['is_shared'] ? $currentFolder['drive_id'] : null;
            $data = $this->listFolders($api, [
                'folderName' => $folderName,
                'folderParent' => $folderParent,
                'sharedWithMe' => $currentFolder['is_shared'],
                'parentId' => $parentId,
                'type' => $type,
                'driveId' => $driveId,
            ]);

            if ($data['success'] && !$data['success']) {
                return [
                    'success' => false,
                    'message' => $data['message'],
                ];
            }

            if (is_array($data['files']) && count($data['files']) > 0) {
                $driveItem = $data['files'][0];
                $root = false;
                $nextPageToken = false;
                $parentId = $driveItem->id;
                $driveId = $driveItem->driveId;

                if ($index === $count - 1) {
                    $root = $driveItem->id;
                    $parentId = $driveItem->parents[0];
                    $nextPageToken = $data['nextPageToken'];
                    $path[$index - 1]['driveId'] = $driveItem->driveId;
                    $path[$index - 1]['folderId'] = $parentId;
                }

                $path[$index]['driveId'] = $driveItem->driveId;
                $path[$index]['folderId'] = $driveItem->id;
                $path[$index]['sharedWithMe'] = $currentFolder['is_shared'];

                if ($path[0]['name'] === 'My files' || $path[0]['name'] === 'Shared') {
                    $path[0]['folderId'] = 'root';
                }

                return [
                    'root' => $root,
                    'path' => $path,
                    'pathCreateIndex' => $index + 1,
                    'nextPageToken' => $nextPageToken,
                    'parentId' => $parentId,
                    'isShared' => $currentFolder['is_shared'],
                    'driveId' => $driveId,
                ];
            }

            if ($data['parentId']) {
                // should go here on google
                $path[$index - 1]['folderId'] = $data['parentId'];
                return [
                    'root' => false,
                    'path' => $path,
                    'pathCreateIndex' => $index,
                    'nextPageToken' => null,
                    'parentId' => $data['parentId'],
                    'isShared' => $currentFolder['is_shared'],
                    'driveId' => null,
                ];
            }
        }
        return null;
    }

    /**
     * Remove a drive path
     *
     * @param ServiceBase $api
     * @param array $args
     * @return mixed
     * @throws SugarApiExceptionNotFound
     * @throws SugarQueryException
     * @throws Exception
     */
    public function removeDrivePath(ServiceBase $api, array $args)
    {
        $this->requireArgs($args, ['pathId',]);
        $pathId = $args['pathId'];

        $pathBean = BeanFactory::retrieveBean('CloudDrivePaths', $pathId);
        $pathBean->mark_deleted($pathId);
        $pathBean->save();

        return $pathId;
    }

    /**
     * Create a folder on the drive
     *
     * @param ServiceBase $api
     * @param array $args
     * @return null|array
     */
    public function createFolder(ServiceBase $api, array $args): ?array
    {
        $this->requireArgs($args, ['type',]);

        $driveFacade = $this->getDrive($args['type']);
        return $driveFacade->createFolder($args);
    }

    /**
     * Uploads a file to the drive
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function uploadToDrive(ServiceBase $api, array $args): array
    {
        $this->requireArgs($args, ['type',]);

        if (!empty($_FILES)) {
            $args['data'] = $_FILES['file'];
        }
        $maxUploadSize = 4194304;
        $file = $_FILES['file'];

        if ($file['size'] > $maxUploadSize) {
            $args['largeFile'] = true;
        }

        $driveFacade = $this->getDrive($args['type']);
        return $driveFacade->uploadFile($args);
    }

    /**
     * Upload a document to the drive
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function uploadDocumentToDrive(ServiceBase $api, array $args) : array
    {
        $this->requireArgs($args, ['documentId', 'cloud_service_type', 'path']);

        $cloudServiceName = $args['cloud_service_type'];
        $documentId = $args['documentId'];
        $path = $args['path'];

        $documentBean = \BeanFactory::getBean('Documents', $documentId);
        $drive = new DriveFacade($cloudServiceName);

        $documentRevisionID = $documentBean->document_revision_id;
        $revisionBean = \BeanFactory::retrieveBean('DocumentRevisions', $documentRevisionID);
        $fileName = $revisionBean->filename;

        $uploadOptions = [
            'documentBean' => $documentBean,
            'fileName' => $fileName,
        ];
        if ($cloudServiceName === 'dropbox') {
            $path = json_decode($path, true);
            $path[] = ['name' => $fileName];

            $uploadOptions['folderPath'] = $path;
            $uploadOptions['filePath'] = $path;
        } else {
            $uploadOptions['pathId'] = $path;
        }

        $res = $drive->uploadFile($uploadOptions);
        if (is_array($res) && isset($res['success'])) {
            if ($res['success'] === true) {
                return [
                    'status' => 'success',
                    'documentName' => $documentBean->name,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => $res['message'],
                ];
            }
        } else {
            return $res;
        }
    }

    /**
     * Gets the drive client
     *
     * @param array $args
     */
    public function getClient(array $args)
    {
        $this->requireArgs($args, ['type',]);

        $driveFacade = $this->getDrive($args['type']);
        return $driveFacade->getClient($args);
    }

    /**
     * Check if a document have a file attached
     *
     * @param SugarBean $documentBean
     */
    public function checkDocumentAttachedFile(\SugarBean $documentBean)
    {
        $filePath = 'upload://'.$documentBean->document_revision_id;

        if (!$documentBean->filename || !file_exists($filePath)) {
            throw new Exception('LBL_ERR_NO_FILE_ATTACHED');
        }
    }
}
