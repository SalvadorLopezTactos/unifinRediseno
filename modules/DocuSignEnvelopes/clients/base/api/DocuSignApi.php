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

include_once 'vendor/docusign/autoload.php';

use DocuSign\eSign as DocuSign;
use Sugarcrm\Sugarcrm\Util\Uuid;

class DocuSignApi extends SugarApi
{
    /**
     * {@inheritDoc}
     */
    public function registerApiRest()
    {
        return [
            'send' => [
                'reqType' => 'POST',
                'path' => ['DocuSign', 'send'],
                'pathVars' => ['module', 'action'],
                'method' => 'send',
                'shortHelp' => 'Send envelope',
                'longHelp' =>
                    'modules/DocuSignEnvelopes/clients/base/api/help/' .
                    'docusignenvelopes_send_post_help.html',
                'minVersion' => '11.16',
            ],
            'sendReturn' => [
                'reqType' => 'GET',
                'path' => ['DocuSign', 'sendReturn'],
                'pathVars' => ['', ''],
                'method' => 'sendReturn',
                'shortHelp' => 'This method will be called when DocuSign tab completes',
                'longHelp' =>
                    'modules/DocuSignEnvelopes/clients/base/api/help/' .
                    'docusignenvelopes_send_return_get_help.html',
                'noLoginRequired' => true,
                'rawReply' => true,
                'minVersion' => '11.16',
            ],
            'saveBean' => [
                'reqType' => 'POST',
                'path' => ['DocuSign', 'saveBean'],
                'pathVars' => ['', ''],
                'method' => 'docusignSaveBean',
                'shortHelp' => 'This method is used to update the envelope locally',
                'longHelp' =>
                    'modules/DocuSignEnvelopes/clients/base/api/help/' .
                    'docusignenvelopes_save_bean_post_help.html',
                'minVersion' => '11.16',
            ],
            'stats' => [
                'reqType' => 'POST',
                'path' => ['DocuSign', 'stats'],
                'pathVars' => ['module', ''],
                'method' => 'stats',
                'shortHelp' => 'Returns envelope count grouped by status',
                'longHelp' =>
                    'modules/DocuSignEnvelopes/clients/base/api/help/' .
                    'docusignenvelopes_stats_post_help.html',
                'minVersion' => '11.16',
            ],
            'getCompletedDocument' => [
                'reqType' => 'POST',
                'path' => ['DocuSign', 'getCompletedDocument'],
                'pathVars' => ['module', 'action'],
                'method' => 'getCompletedDocument',
                'shortHelp' => 'Download and add the completed document onto the record',
                'longHelp' =>
                    'modules/DocuSignEnvelopes/clients/base/api/help/' .
                    'docusignenvelopes_get_completed_document_post_help.html',
                'minVersion' => '11.16',
            ],
            'docusignLoadPage' => [
                'reqType' => 'GET',
                'path' => ['DocuSign', 'loadPage'],
                'pathVars' => ['', ''],
                'method' => 'docusignLoadPage',
                'shortHelp' => 'Page given until DocuSign is loaded',
                'longHelp' =>
                    'modules/DocuSignEnvelopes/clients/base/api/help/' .
                    'docusignenvelopes_docusign_load_page_get_help.html',
                'noLoginRequired' => true,
                'rawReply' => true,
                'minVersion' => '11.16',
            ],
            'downloadDocumentPost' => [
                'reqType' => 'POST',
                'path' => ['DocuSign', 'downloadDocument'],
                'pathVars' => ['', ''],
                'method' => 'downloadDocumentPost',
                'shortHelp' => 'Download combined documents from DocuSign',
                'longHelp' =>
                    'modules/DocuSignEnvelopes/clients/base/api/help/' .
                    'docusignenvelopes_download_document_post_help.html',
                'minVersion' => '11.16',
            ],
            'downloadDocumentGet' => [
                'reqType' => 'GET',
                'path' => ['DocuSign', 'downloadDocument'],
                'pathVars' => ['', ''],
                'method' => 'downloadDocumentGet',
                'shortHelp' => 'Download combined documents',
                'longHelp' =>
                    'modules/DocuSignEnvelopes/clients/base/api/help/' .
                    'docusignenvelopes_download_document_get_help.html',
                'rawReply' => true,
                'noLoginRequired' => true,
                'minVersion' => '11.16',
            ],
            'resendEnvelope' => [
                'reqType' => 'POST',
                'path' => ['DocuSign', 'resendEnvelope'],
                'pathVars' => ['', ''],
                'method' => 'resendEnvelope',
                'shortHelp' => 'Resend Envelope',
                'longHelp' =>
                    'modules/DocuSignEnvelopes/clients/base/api/help/' .
                    'docusignenvelopes_resend_envelope_post_help.html',
                'minVersion' => '11.16',
            ],
            'updateEnvelope' => [
                'reqType' => 'POST',
                'path' => ['DocuSign', 'updateEnvelope'],
                'pathVars' => ['', ''],
                'method' => 'updateEnvelope',
                'shortHelp' => 'Update Envelope in Sugar',
                'longHelp' =>
                    'modules/DocuSignEnvelopes/clients/base/api/help/' .
                    'docusignenvelopes_update_envelope_post_help.html',
                'minVersion' => '11.16',
            ],
            'removeEnvelope' => [
                'reqType' => 'POST',
                'path' => ['DocuSign', 'removeEnvelope'],
                'pathVars' => ['', ''],
                'method' => 'removeEnvelope',
                'shortHelp' => 'Deletes envelope record from Sugar',
                'longHelp' =>
                    'modules/DocuSignEnvelopes/clients/base/api/help/' .
                    'docusignenvelopes_remove_envelope_post_help.html',
                'minVersion' => '11.16',
            ],
            'checkEAPM' => [
                'reqType' => 'GET',
                'path' => ['DocuSign', 'checkEAPM'],
                'pathVars' => ['', ''],
                'method' => 'checkEAPM',
                'shortHelp' => 'Check if user has DocuSign EAPM bean',
                'longHelp' =>
                    'modules/DocuSignEnvelopes/clients/base/api/help/' .
                    'docusignenvelopes_checkeapm_get_help.html',
                'minVersion' => '11.16',
            ],
        ];
    }

    /**
     * Send envelope
     *
     * @param ServiceBase $api
     * @param Array $args
     * @return Array
     */
    public function send(ServiceBase $api, array $args): array
    {
        global $current_user, $sugar_config, $log;

        $returnUrlParams = $args['returnUrlParams'];

        $res = [];

        $eapmExists = $this->checkEAPM($api, $args);
        if (!$eapmExists) {
            $errorMessage = translate('LBL_PLEASE_LOG_IN', 'DocuSignEnvelopes');
            $log->error($errorMessage);
            return [
                'status' => 'error',
                'message' => $errorMessage,
            ];
        }

        $extApi = new ExtAPIDocuSign();

        try {
            if (isset($args['draftEnvelopeId'])) {
                $envelopeId = $args['draftEnvelopeId'];

                // make sure the envelope is still a draft in DocuSign
                $envelopeInfo = $extApi->getEnvelope($args['draftEnvelopeId']);

                $dsEnvelopeStatus = $envelopeInfo['status'];
                if ($dsEnvelopeStatus === 'created') {
                    $createdEnvelopeId = $envelopeId;
                } else {
                    $sugarEnvelopeId = $this->getSugarEnvelopeIdByDsEnvelopeId($envelopeId);
                    if (!empty($sugarEnvelopeId)) {
                        $envelopeBean = BeanFactory::retrieveBean('DocuSignEnvelopes', $sugarEnvelopeId);
                        $envelopeBean->status = $dsEnvelopeStatus;
                        $envelopeBean->save();
                    }

                    throw new Exception(translate('LBL_ERROR_ENVELOPE_IS_NOW', 'DocuSignEnvelopes') . $dsEnvelopeStatus);
                }
            } else {
                $sugarEnvelopeId = Uuid::uuid4();
                $args['returnUrlParams'] = $returnUrlParams;
                $args['sugarEnvelopeId'] = $sugarEnvelopeId;
                $envelopeDetails = $extApi->createANewEnvelope($args);
                $createdEnvelopeId = $envelopeDetails['id'];
                $envelopeSubject = $envelopeDetails['subject'];

                $newEnvelopeBean = BeanFactory::newBean('DocuSignEnvelopes');
                $newEnvelopeBean->new_with_id = true;
                $newEnvelopeBean->id = $sugarEnvelopeId;
                $newEnvelopeBean->name = $envelopeSubject;
                $newEnvelopeBean->email_subject = $envelopeSubject;
                $newEnvelopeBean->created_by = $current_user->id;
                $newEnvelopeBean->assigned_user_id = $current_user->id;
                $newEnvelopeBean->envelope_id = $createdEnvelopeId;
                $newEnvelopeBean->status = 'created';
                $newEnvelopeBean->parent_type = $returnUrlParams['parentRecord'];
                $newEnvelopeBean->parent_id = $returnUrlParams['parentId'];
                $newEnvelopeBean->team_set_id = $current_user->team_set_id;
                $newEnvelopeBean->team_id = $current_user->team_id;
                $newEnvelopeBean->save();
            }
            $returnUrlParams = http_build_query($returnUrlParams);
            
            $moduleInstallerClass = SugarAutoLoader::customClass('ModuleInstaller');
            $sidecarConfig = $moduleInstallerClass::getBaseConfig();

            $restVersion = $sidecarConfig['serverUrl'];
            $returnUrl = rtrim($sugar_config['site_url'], '/') .
                '/' . $restVersion . '/DocuSign/sendReturn?' . $returnUrlParams;

            $return_url_request = new DocuSign\Model\ReturnUrlRequest();
            $return_url_request->setReturnUrl($returnUrl);
           
            $senderView = $extApi->createSenderView($createdEnvelopeId, $return_url_request);
            if (is_array($senderView) && isset($senderView['status']) && $senderView['status'] === 'error') {
                throw new Exception($senderView['message']);
            }
            $res = [
                'url' => $senderView->getUrl(),
            ];
        } catch (DocuSign\Client\ApiException $ex) {
            $responseBody = $ex->getResponseBody();
            $message = 'Exception: ' . $ex->getMessage() . var_export($responseBody, true);
            $log->error($message);
            
            if (is_object($responseBody) && $responseBody->errorCode  && !empty($responseBody->message)) {
                $message = $responseBody->message;
            }
            $res = [
                'status' => 'error',
                'message' => $message,
            ];
        } catch (Exception $ex) {
            $message = 'Exception: ' . $ex->getMessage();
            $res = [
                'status' => 'error',
                'message' => $message,
            ];
            //we send status to js in order to present the proper message to user (deleted envelope or status changed)
            if (isset($envelopeBean)) {
                $res['envelopeStatus'] = $envelopeBean->status;
                //envelopeId will be used to delete/update the envelope
                $res['envelopeId'] = $this->envelopeId;
            }

            $log->error($message);
        } catch (Error $e) {
            $message = 'Error: ' . $e->getMessage();
            $res = [
                'status' => 'error',
                'message' => $message,
            ];
            //we send status to js in order to present the proper message to user (deleted envelope or status changed)
            if (isset($envelopeBean)) {
                $res['envelopeStatus'] = $envelopeBean->status;
                //envelopeId will be used to delete/update the envelope
                $res['envelopeId'] = $this->envelopeId;
            }

            $log->error($message);
        }

        return $res;
    }

    /**
     * Method called by DocuSign tab
     *
     * @param  ServiceBase $api
     * @param  Array $args
     * @return string
     */
    public function sendReturn(ServiceBase $api, $args)
    {
        global $sugar_config;
        $moduleInstallerClass = SugarAutoLoader::customClass('ModuleInstaller');
        $sidecarConfig = $moduleInstallerClass::getBaseConfig();

        $apiRoot = rtrim($sugar_config['site_url'], '/') . '/' . $sidecarConfig['serverUrl'];

        ob_start();
        require 'modules/DocuSignEnvelopes/clients/base/api/extras/dsSendReturn.php';
        $endpointHtml = ob_get_clean();

        $api->setHeader('Content-Type', 'text/html');

        return $endpointHtml;
    }

    /**
     * This method only handles important fields on the new DocuSignEnvelopes record
     *
     * @param ServiceBase $api
     * @param array $args
     * @return bool
     */
    public function docusignSaveBean(ServiceBase $api, array $args): bool
    {
        $sugarEnvId = $this->getSugarEnvelopeIdByDsEnvelopeId($args['envelopeId']);
        if (empty($sugarEnvId)) {
            $GLOBALS['log']->error('Could not save the envelope in Sugar. Empty sugar envelope id');
            return false;
        }

        $envelopeBean = BeanFactory::retrieveBean('DocuSignEnvelopes', $sugarEnvId);
        if (empty($envelopeBean)) {
            $GLOBALS['log']->error('Could not find the envelope in Sugar');
            return false;
        }
        $envelopeBean->status = $args['status'];

        $envelopeBean->save();

        $commentLog = BeanFactory::newBean('CommentLog');
        $commentLog->entry = translate('LBL_MODULE_NAME_SINGULAR', 'DocuSignEnvelopes') . ' ' .
            $envelopeBean->name . translate('LBL_DOCUMENT_IS_NOW', 'DocuSignEnvelopes') .
            $envelopeBean->status;
        $commentLog->save();
        $envelopeBean->load_relationship('commentlog_link');
        $envelopeBean->commentlog_link->add($commentLog);

        return true;
    }

    /**
     * Get Sugar Envelope Id
     *
     * @param String $envelopeId
     * @return String|null
     */
    public function getSugarEnvelopeIdByDsEnvelopeId($envelopeId)
    {
        $envelopeBean = BeanFactory::newBean('DocuSignEnvelopes');
        $query = new SugarQuery();
        $query->from($envelopeBean);
        $query->select('id');
        $query->where()->equals('envelope_id', $envelopeId);

        $results = $query->execute();
        if (empty($results)) {
            return null;
        }
        return $results[0]['id'];
    }

    /**
     * Get counts
     *
     * @param ServiceBase $api
     * @param Array $args
     * @return Array
     */
    public function stats(ServiceBase $api, array $args)
    {
        $this->limit = -1;

        $result = [
            'created' => 0,
            'sent' => 0,
            'delivered' => 0,
            'completed' => 0,
            'declined' => 0,
            'voided' => 0,
            'signed' => 0,
            'all' => 0,
        ];

        $envelopeSeed = BeanFactory::newBean('DocuSignEnvelopes');

        $sq = new SugarQuery();
        $sq->select(['status'])->fieldRaw('count(id)', 'count');
        $sq->from($envelopeSeed);
        $sq->groupBy(['status']);

        if (isset($args['recordModule']) && $args['recordModule'] !== 'Home') {
            $where = $sq->where();
            $where->equals('parent_type', $args['recordModule']);

            if (isset($args['recordId'])) {
                $andWhere = $sq->where()->queryAnd();
                $andWhere->equals('parent_id', $args['recordId']);
            }
        }

        $dbRes = $sq->execute();
        foreach ($dbRes as $idx => $row) {
            $rowStatus = $row['status'];
            $result[$rowStatus] += $row['count'];
        }

        $counts = array_values($result);
        $result['all'] = array_sum($counts);

        return $result;
    }

    /**
     * Get completed document
     *
     * @param ServiceBase @api
     * @param Array $args
     * @return Array
     */
    public function getCompletedDocument(ServiceBase $api, array $args)
    {
        $envelopeBean = BeanFactory::retrieveBean('DocuSignEnvelopes', $args['id']);
        if ($envelopeBean->status !== 'completed') {
            return [
                'status' => 'error',
                'message' => translate('LBL_ERROR_ENVELOPE_NOT_COMPLETED', 'DocuSignEnvelopes'),
            ];
        }
        
        $eapmExists = $this->checkEAPM($api, $args);
        if (!$eapmExists) {
            $errorMessage = translate('LBL_PLEASE_LOG_IN', 'DocuSignEnvelopes');
            return [
                'status' => 'error',
                'message' => $errorMessage,
            ];
        }

        $extApi = new ExtAPIDocuSign();

        $options = [
            'envelopeId' => $envelopeBean->envelope_id,
        ];

        try {
            $documentInfo = $extApi->getCompletedDocumentInfo($options);
            if (isset($documentInfo['status']) && $documentInfo['status'] === 'error') {
                throw new Exception($documentInfo['message']);
            }

            $documentBean = $this->createDocumentInSugar(
                $documentInfo['documentName'] . ' - ' . translate('LBL_DOCUMENT_COMPLETED', 'DocuSignEnvelopes'),
                $documentInfo['body'],
                $documentInfo['completedDateTime']
            );
            if (is_array($documentBean)) {
                return [
                    'status' => 'error',
                    'message' => $documentBean['error'],
                ];
            }
            $envelopeBean->document_id = $documentBean->id;
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }

        $envelopeBean->save();

        $parentBean = BeanFactory::retrieveBean($envelopeBean->parent_type, $envelopeBean->parent_id);
        $this->addToRelationship($parentBean, 'Documents', $documentBean->id);

        return [
            'status' => 'success',
        ];
    }

    /**
     * Creates a Document record in Sugar
     *
     * @method createDocumentInSugar
     * @param string $docName
     * @param string $docPdfBytes
     * @param string $completedDateTime
     * @return Documents Document bean
     */
    public function createDocumentInSugar($docName, $docPdfBytes, $completedDateTime = '')
    {
        global $log, $current_user;
        try {
            $revisionId = Uuid::uuid4();

            $doc = new Document();
            $doc->document_name = $docName;
            $doc->doc_type = 'Sugar';
            $doc->team_id = $current_user->team_id;
            $doc->team_set_id = $current_user->team_set_id;
            $doc->assigned_user_id = $current_user->id;
            if (!empty($completedDateTime)) {
                global $timedate;
                $completedDateTimeObj = new DateTime($completedDateTime);
                $completedDate = $completedDateTimeObj->format($timedate->dbDayFormat);
                
                $doc->active_date = $completedDate;//publish date
            }
            $doc->document_revision_id = $revisionId;
            $doc->save();

            $uploadFile = new UploadFile('completed_doc_file');
            $uploadFile->file = $docPdfBytes;
            $uploadFile->use_soap = true;//needed to make the final move

            $docRevision = new DocumentRevision();
            $docRevision->id = $revisionId;
            $docRevision->new_with_id = true;
            $docRevision->filename = $docName . '.pdf';//all ds completed documents are PDFs
            $docRevision->file_mime_type = 'application/pdf';
            $docRevision->file_ext = 'pdf';
            $docRevision->doc_type = 'Sugar';
            $docRevision->revision = 1;
            $docRevision->document_id = $doc->id;
            $docRevision->save();
            
            $uploadFile->final_move($docRevision->id);
        } catch (Exception $ex) {
            $log->error('DocuSign Exception: ' . $ex->getMessage());
        }

        return $doc;
    }

    /**
     * Adds a record to a given relationship
     *
     * @param SugarBean $bean - The current record
     * @param string $relatedModule
     * @param string $relatedId
     */
    private function addToRelationship(SugarBean $bean, string $relatedModule, string $relatedId): void
    {
        foreach ($bean->field_defs as $fieldName => $def) {
            //if the field doesn't have a relationship def. It is not a rel/link field.
            if (!isset($def['relationship'])) {
                continue;
            }

            $relationship = $this->getRelationshipName($def, $relatedModule, $bean);
            if ($bean->load_relationship($relationship)) {
                $bean->{$relationship}->add($relatedId);
            }
        }
    }

    /**
     * Gets the name of the relationship given the defintion of a link field and a module
     *
     * @param array fieldDef
     * @param string relatedModule
     * @param Sugarbean bean
     *
     * @return string|null
     */
    private function getRelationshipName(array $linkDef, string $relatedModule, SugarBean $bean): ?string
    {
        $relationshipName = null;
        $rel = SugarRelationshipFactory::getInstance()->getRelationship($linkDef['relationship']);

        if ($rel) {
            $lhsModule = $rel->getLHSModule();
            $rhsModule = $rel->getRHSModule();

            if ($lhsModule === $relatedModule || $rhsModule === $relatedModule) {
                $bean->load_relationship($linkDef['relationship']) ?
                    $relationshipName = $linkDef['relatonship'] :
                    ($bean->load_relationship($linkDef['name']) ?
                        $relationshipName = $linkDef['name'] : $relationshipName = null);
            }
        }

        return $relationshipName;
    }

    /**
     * DocuSign Loading Page
     *
     * @param ServiceBase $api
     * @param Array $args
     * @return string
     */
    public function docusignLoadPage(ServiceBase $api, array $args)
    {
        $page = <<<HTML
<!DOCTYPE html>
<html>
    <body style='position: absolute; top: 45%; left: 45%;'>
        <img src='../../../styleguide/assets/img/loader.gif'/>
    </body>
</html>
HTML;
        return $page;
    }

    /**
     * Download document from DocuSign
     *
     * Download the document in this POST request. The user is logged in during this request
     *
     * @param ServiceBase $api
     * @param Array $args
     * @return Array
     * @throws SugarApiExceptionNotAuthorized
     */
    public function downloadDocumentPost(ServiceBase $api, array $args)
    {
        global $log;
        $envelopeBean = BeanFactory::retrieveBean('DocuSignEnvelopes', $args['sugarEnvelopeId']);

        $eapmExists = $this->checkEAPM($api, $args);
        if (!$eapmExists) {
            $errorMessage = translate('LBL_PLEASE_LOG_IN', 'DocuSignEnvelopes');
            $log->error($errorMessage);
            return [
                'status' => 'error',
                'message' => $errorMessage,
            ];
        }
        
        $extApi = new ExtAPIDocuSign();
        $options = [
            'envelopeId' => $envelopeBean->envelope_id,
            'certificate' => 'false',
        ];

        $envelopeDesc = $extApi->getEnvelopeDetails($envelopeBean);
        if (isset($envelopeDesc['status']) && $envelopeDesc['status'] === 'error') {
            throw new SugarApiExceptionNotAuthorized($envelopeDesc['message']);
        }

        try {
            $docStream = $extApi->downloadDocumentsStream($options);
        } catch (DocuSign\Client\ApiException $e) {
            $log->error($e->getResponseHeaders());
            $log->error(var_export($e->getResponseBody(), true));

            return [
                'status' => 'error',
                'message' => translate('LBL_ERROR_DOWNLOADING_DOCUMENT', 'DocuSignEnvelopes'),
            ];
        } catch (Exception $e) {
            $log->error($e->getMessage());

            return [
                'status' => 'error',
                'message' => translate('LBL_ERROR_DOWNLOADING_DOCUMENT', 'DocuSignEnvelopes'),
            ];
        }

        $fileUid = Uuid::uuid4();

        $file_path = $docStream->getPathname();
        $to = UploadStream::STREAM_NAME . '://tmp/' . $fileUid . '_guid';
        copy($file_path, $to);

        return [
            'fileUid' => $fileUid,
        ];
    }

    /**
     * Download document
     *
     * GET the document by attaching it to the response. The user is not logged in during this request
     *
     * @param ServiceBase $api
     * @param Array $args
     */
    public function downloadDocumentGet(ServiceBase $api, array $args)
    {
        $user = BeanFactory::newBean('Users');
        $user->getSystemUser();
        $GLOBALS['current_user'] = $user;

        $envelopeBean = BeanFactory::retrieveBean('DocuSignEnvelopes', $args['sugarEnvelopeId']);
        $file_path = UploadStream::STREAM_NAME . '://tmp/' . $args['fileUid'] . '_guid';

        $envelopeName = $envelopeBean->name;
        $dotPosition = strpos($envelopeName, '.');
        if ($dotPosition !== false) {
            $envelopeName = substr($envelopeName, 0, $dotPosition);
        }
        $envelopeName = htmlentities($envelopeName, ENT_QUOTES);
        header('Pragma: public');
        header('Cache-Control: max-age=1, post-check=0, pre-check=0');
        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment; filename={$envelopeName}.pdf");
        header('X-Content-Type-Options: nosniff');
        set_time_limit(0);
        ob_clean();
        flush();

        readfile($file_path);
    }

    /**
     * Resend an envelope
     *
     * @param ServiceBase $api
     * @param Array $args
     * @return Array|bool
     */
    public function resendEnvelope(ServiceBase $api, array $args)
    {
        global $log;
        $this->requireArgs($args, ['id']);

        $sugarEnvelopeId = $args['id'];
        $envelopeBean = BeanFactory::retrieveBean('DocuSignEnvelopes', $sugarEnvelopeId);

        if (empty($envelopeBean)) {
            $errorMessage = translate('LBL_ERROR_RESEND_FAILED', 'DocuSignEnvelopes');
            $log->error($errorMessage);
            return [
                'status' => 'error',
                'message' => $errorMessage,
            ];
        }

        $extApi = new ExtAPIDocuSign();

        $eapmExists = $this->checkEAPM($api, $args);
        if (!$eapmExists) {
            $errorMessage = translate('LBL_PLEASE_LOG_IN', 'DocuSignEnvelopes');
            $log->error($errorMessage);
            return [
                'status' => 'error',
                'message' => $errorMessage,
            ];
        }

        if ($envelopeBean->status !== 'sent') {
            $errorMessage = translate('LBL_ERROR_RESEND', 'DocuSignEnvelopes');
            $log->error($errorMessage);
            return [
                'status' => 'error',
                'message' => $errorMessage,
            ];
        }

        try {
            $extApi->resendEnvelope($envelopeBean);
        } catch (DocuSign\Client\ApiException $ex) {
            $exceptionMessage  = $ex->getMessage();
            $responseObject = $ex->getResponseObject();
            if ($responseObject instanceof DocuSign\Model\ErrorDetails) {
                $exceptionMessage = $responseObject->getMessage();
            }
            return [
                'status' => 'error',
                'message' => $exceptionMessage,
            ];
        } catch (Exception $ex) {
            $exceptionMessage = $ex->getMessage();
            $log->error("Resend was not made for envelope id {$envelopeBean->id}.
                Error received from Api: {$exceptionMessage}");
            return [
                'status' => 'error',
                'message' => translate('LBL_ERROR_RESEND_FAILED', 'DocuSignEnvelopes'),
            ];
        }

        return true;
    }

    /**
     * Update sugar envelope record
     *
     * @param ServiceBase $api
     * @param Array $args
     * @return Array|bool
     */
    public function updateEnvelope(ServiceBase $api, array $args)
    {
        global $current_user, $log;

        $this->requireArgs($args, ['id']);

        $sugarEnvelopeId = $args['id'];
        $envelopeBean = BeanFactory::retrieveBean('DocuSignEnvelopes', $sugarEnvelopeId);
        if (empty($envelopeBean)) {
            return [
                'status' => 'error',
                'message' => translate('LBL_UPDATE_FAILED', 'DocuSignEnvelopes'),
            ];
        }

        $extApi = new ExtAPIDocuSign();

        $eapmExists = $this->checkEAPM($api, $args);
        if (!$eapmExists) {
            $errorMessage = translate('LBL_PLEASE_LOG_IN', 'DocuSignEnvelopes');
            $log->error($errorMessage);
            return [
                'status' => 'error',
                'message' => $errorMessage,
            ];
        }

        if ($envelopeBean->created_by !== $current_user->id) {
            return [
                'status' => 'error',
                'message' => translate('LBL_UPDATE_NOT_ALLOWED', 'DocuSignEnvelopes'),
            ];
        }

        if (!empty($envelopeBean->last_audit)) {
            $lastAudit = strtotime($envelopeBean->last_audit);
            $now = strtotime('now');
            $difference = $now - $lastAudit;
            $minutes = floor($difference / 60);
            if ($minutes < 15) {
                return [
                    'status' => 'error',
                    'message' => translate('LBL_ERROR_FETCH_TIME', 'DocuSignEnvelopes'),
                ];
            }
        }

        try {
            $envelopeDetails = $extApi->getEnvelopeDetails($envelopeBean);
            if (isset($envelopeDetails['status']) && $envelopeDetails['status'] === 'error') {
                throw new Exception($envelopeDetails['message']);
            }
            foreach ($envelopeDetails as $fieldName => $value) {
                $envelopeBean->{$fieldName} = $value;
            }

            $envelopeBean->save();

            $commentLog = BeanFactory::newBean('CommentLog');
            $commentLog->entry = translate('LBL_MODULE_NAME_SINGULAR', 'DocuSignEnvelopes') . ' ' .
                $envelopeDetails['name'] . translate('LBL_DOCUMENT_IS_NOW', 'DocuSignEnvelopes') .
                $envelopeDetails['status'];
            $commentLog->save();
            $envelopeBean->load_relationship('commentlog_link');
            $envelopeBean->commentlog_link->add($commentLog);
        } catch (DocuSign\Client\ApiException $ex) {
            $exceptionMessage = $ex->getMessage();
            $exceptionResponseBody = $ex->getResponseBody();
            if (!empty($exceptionResponseBody) && !empty($exceptionResponseBody->message)) {
                $exceptionMessage = $exceptionResponseBody->message;
            }

            return [
                'status' => 'error',
                'message' => $exceptionMessage,
            ];
        } catch (Exception $ex) {
            $exceptionMessage = $ex->getMessage();
            if (empty($exceptionMessage)) {
                $exceptionMessage = translate('LBL_ERROR_UPDATING_ENVLOPE', 'DocuSignEnvelopes');
            }
            $log->error("Could not fetch envelope {$envelopeBean->id}. Error received from Api: {$exceptionMessage}");
            return [
                'status' => 'error',
                'message' => $exceptionMessage,
            ];
        }

        return true;
    }

    /**
     * Remove envelope from Sugar
     *
     * Needed when a draft was started in Sugar but then deleted in Docusign
     *
     * @param ServiceBase $api
     * @param Array $args
     * @return bool
     */
    public function removeEnvelope(ServiceBase $api, array $args)
    {
        global $current_user, $log;

        if (empty($args['envelopeId'])) {
            $log->error('Envelope id not found. Could not delete envelope from sugar.');
            return false;
        } else {
            $envelopeId = $args['envelopeId'];
            $sugarEnvelopeId = $this->getSugarEnvelopeIdByDsEnvelopeId($envelopeId);
            if (empty($sugarEnvelopeId)) {
                $log->error("We could not retrieve and save envelope with sugar id '{$sugarEnvelopeId}'.
                    Current user id is '{$current_user->id}'");
                return false;
            } else {
                $envelope = BeanFactory::retrieveBean('DocuSignEnvelopes', $sugarEnvelopeId);
                if (empty($envelope)) {
                    $log->error("We could not retrieve and save envelope with id '{$envelopeId}'.
                        Current user id is '{$current_user->id}'");
                    return false;
                } else {
                    $envelope->deleted = 1;
                    $envelope->save();
                    return true;
                }
            }
        }
    }

    /**
     * Check if user has EAPM bean
     *
     * @param ServiceBase $api
     * @param Array $args
     * @return bool
     */
    public function checkEAPM(ServiceBase $api, array $args)
    {
        $extApi = new ExtAPIDocuSign();
        $userEAPM = $extApi->getUserEAPM();

        return  $userEAPM instanceof EAPM;
    }
}
