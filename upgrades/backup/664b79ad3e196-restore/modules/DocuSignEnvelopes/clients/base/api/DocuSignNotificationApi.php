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

require_once 'include/upload_file.php';

class DocuSignNotificationApi extends SugarApi
{
    public function registerApiRest()
    {
        return [
            'notification' => [
                'reqType' => 'POST',
                'path' => ['DocuSign', 'notification', '?'],
                'pathVars' => ['', '', 'authorization'],
                'method' => 'notification',
                'shortHelp' => 'This method is called by DocuSign for Events on Envelope',
                'longHelp' =>
                    'modules/DocuSignEnvelopes/clients/base/api/help/docusignenvelopes_notification_post_help.html',
                'noLoginRequired' => true,
                'rawPostContents' => true, //arguments of this entrypoint come as XML
                'minVersion' => '11.16',
            ],
        ];
    }

    /**
     * Docusign notification
     *
     * @param ServiceBase $api
     * @param Array $args
     */
    public function notification(ServiceBase $api, array $args)
    {
        global $log;

        $file = new UploadFile();
        $file->temp_file_location = 'php://input';
        $input = $file->get_file_contents();

        $log->debug('[DocuSign Notification Entry Point]: XML content:' . $input);

        $simpleXmlObj = new SimpleXmlElement($input);
        $envelopeStatusObj = $simpleXmlObj->EnvelopeStatus[0];

        $envelopeId = $envelopeStatusObj->EnvelopeID;
        if (!is_string($envelopeId)) {
            $envelopeId = (string) $envelopeId[0];
        }
        $newStatus = strtolower($envelopeStatusObj->Status);
        
        $sugarEnvelopeId = $args['authorization'];

        $systemUser = BeanFactory::newBean('Users');
        $systemUser->getSystemUser();
        $GLOBALS['current_user'] = $systemUser;
        $envelopeBean = BeanFactory::retrieveBean('DocuSignEnvelopes', $sugarEnvelopeId);
        
        if (!empty($envelopeBean)) {
            $GLOBALS['current_user'] = BeanFactory::getBean('Users', $envelopeBean->created_by);
            
            $envelopeBean->status = $newStatus;
            $envelopeBean->save();

            $commentLog = BeanFactory::newBean('CommentLog');
            $commentLog->entry = translate('LBL_MODULE_NAME_SINGULAR', 'DocuSignEnvelopes') . ' ' .
                $envelopeBean->name . translate('LBL_DOCUMENT_IS_NOW', 'DocuSignEnvelopes') . $newStatus;
            $commentLog->save();
            $envelopeBean->load_relationship('commentlog_link');
            $envelopeBean->commentlog_link->add($commentLog);
        }
    }
}
