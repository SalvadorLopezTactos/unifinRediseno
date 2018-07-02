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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

//require_once 'clients/base/api/FileApi.php';
require_once 'clients/base/api/FileTempApi.php';
require_once 'modules/pmse_Inbox/engine/PMSEImageGenerator.php';

/**
 * API Class to handle temporary image (attachment) interactions with a field in
 * a bean that can be new, so no record id is associated yet.
 */
class PMSEImageGeneratorApi extends FileTempApi
{
    /**
     * Dictionary registration method, called when the API definition is built
     *
     * @return array
     */
    public function registerApiRest()
    {
        return array(
            'getFileContents' => array(
                'reqType' => 'GET',
                'path' => array('pmse_Inbox', '?', 'file', '?'),
                'pathVars' => array('module', 'record', '', 'field'),
                'method' => 'getFile',
                'rawReply' => true,
                'allowDownloadCookie' => true,
//                'shortHelp' => 'Returns the process status image file',
            ),
            'getTempImage' => array(
                'reqType' => 'GET',
                'path' => array('pmse_Inbox', 'temp', 'file', '?', '?'),
                'pathVars' => array('module', 'record', '', 'field', 'temp_id'),
                'method' => 'getTempImage',
                'rawReply' => true,
                'allowDownloadCookie' => true,
//                'shortHelp' => 'Returns the process status image file from tmp folder',
            ),
        );
    }

    /**
     * Gets a single file for rendering
     *
     * @param ServiceBase $api The service base
     * @param array $args Arguments array built by the service base
     * @return string
     * @throws SugarApiExceptionMissingParameter|SugarApiExceptionNotFound
     */
    public function getFile($api, $args)
    {
        $this->getProcessImage($api, $args);
        $args['temp_id'] = $args['record'];
        parent::getTempImage($api, $args);
    }

    /**
     * Gets a single temporary file for rendering and removes it from filesystem.
     *
     * @param ServiceBase $api The service base
     * @param array $args Arguments array built by the service base
     * @return array
     */
    public function getTempImage($api, $args)
    {
        parent::getTempImage($api, $args);
    }

    public function getProcessImage($api, $args)
    {
        $path = 'upload://tmp/';
        $image = new PMSEImageGenerator();
        $img = $image->get_image($args['record']);
        $file = new UploadStream();
        if (!$file->checkDir($path)) {
            $file->createDir($path);
        }
        $file_path = UploadFile::realpath($path) . '/' . $args['record'];
        imagepng($img, $file_path);
        imagedestroy($img);
    }
}

