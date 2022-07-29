<?php
/**
 * @author: Tactos.AF 2019-09-24
 * Enpoint habilitado para recuperar imagen de perfil de usuarios
 *
 */


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class CustomGetFile extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'Custom_Image_Profile' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('<module>', '?', 'file', '?','custom'),
                'pathVars' => array('module', 'record', '', 'field','custom'),
                'method' => 'getFile',
                'shortHelp' => 'Recupera imagen de perfil de usuario',
                'rawReply' => true,
                'allowDownloadCookie' => true,


            )
        );
    }

    /**
     * Gets a single file for rendering
     *
     * @param ServiceBase $api The service base
     * @param array $args Arguments array built by the service base
     * @throws SugarApiExceptionMissingParameter When field name is missing.
     * @throws SugarApiExceptionNotFound When file cannot be found.
     * @throws SugarApiExceptionNotAuthorized When there is no access to record in module.
     */
    public function getFile(ServiceBase $api, array $args)
    {
        // if exists link_name param then get archive
        if (!empty($args['link_name'])) {
            // @TODO Remove this code and use getArchive method via rest
            $this->getArchive($api, $args);
            return;
        }

        // Get the field
        if (empty($args['field'])) {
            // @TODO Localize this exception message
            throw new SugarApiExceptionMissingParameter('Field name is missing');
        }
        $field = $args['field'];

        // Get the bean
        $bean = $this->loadBean($api, $args);

        if(!$bean->ACLAccess('view')) {
          //  throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$args['module']);
        }

        if (empty($bean->{$field})) {
            // @TODO Localize this exception message
            throw new SugarApiExceptionNotFound("The requested file $args[module] :: $field could not be found.");
        }

        // Handle ACL
        $this->verifyFieldAccess($bean, $field);

        $def = $bean->field_defs[$field];
        //for the image type field, forceDownload set default as false in order to display on the image element.
        $forceDownload = ($def['type'] == 'image') ? false : true;

        if (isset($args['force_download'])) {
            $forceDownload = (bool) $args['force_download'];
        }

        $download = $this->getDownloadFileApi($api);
        try {
            $download->getFile($bean, $field, $forceDownload);
        } catch (Exception $e) {
            throw new SugarApiExceptionNotFound($e->getMessage(), null, null, 0, $e);
        }
    }

    /**
     * Gets the DownloadFile object for api.
     *
     * @param ServiceBase $api Api.
     * @return DownloadFileApi
     */
    protected function getDownloadFileApi(ServiceBase $api)
    {
        return new DownloadFileApi($api);
    }

}
