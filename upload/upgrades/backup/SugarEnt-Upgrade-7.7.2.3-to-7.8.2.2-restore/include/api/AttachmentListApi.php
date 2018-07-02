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

require_once('clients/base/api/ListApi.php');

class AttachmentListApi extends ListApi {
    public function registerApiRest() {
        return array(
            'listAttachments' => array(
                'reqType' => 'GET',
                'path' => array('<module>','?', 'link','attachments'),
                'pathVars' => array('module','record','', ''),
                'method' => 'listAttachments',
                'shortHelp' => 'List attachments related to this module',
                'longHelp' => 'include/api/html/module_attach_help.html',
            ),
        );
    }

    public function __construct() {
        $this->defaultLimit = $GLOBALS['sugar_config']['list_max_entries_per_subpanel'];
    }
    
    public function listAttachments($api, $args) {
        // Load up the bean
        $record = BeanFactory::getBean($args['module'], $args['record']);

        if ( empty($record) ) {
            throw new SugarApiExceptionNotFound('Could not find parent record '.$args['record'].' in module '.$args['module']);
        }
        if ( ! $record->ACLAccess('view') ) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$args['module']);
        }
        // Load up the relationship
        if ( ! $record->load_relationship('notes') ) {
            // The relationship did not load, I'm guessing it doesn't exist
            throw new SugarApiExceptionNotFound('Could not find a relationship name notes');
        }
        // Figure out what is on the other side of this relationship, check permissions
        $linkModuleName = $record->notes->getRelatedModuleName();
        $linkSeed = BeanFactory::newBean($linkModuleName);
        if ( ! $linkSeed->ACLAccess('view') ) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$linkModuleName);
        }

        $options = $this->parseArguments($api, $args, $linkSeed);

        $notes = $record->notes->query(array('where'=>array('lhs_field'=>'filename','operator'=>'<>','rhs_value'=>"''")));
        $rowCount = 1;

        $data['records'] = array();
        foreach ( $notes['rows'] as $noteId => $ignore ) {
            $rowCount++;
            $note = BeanFactory::getBean('Notes',$noteId);
            $data['records'][] = $this->formatBean($api,$args,$note);
            if ( $rowCount == $options['limit'] ) {
                // We have hit our limit.
                break;
            }
        }
        return $data['records'];
    }
}
