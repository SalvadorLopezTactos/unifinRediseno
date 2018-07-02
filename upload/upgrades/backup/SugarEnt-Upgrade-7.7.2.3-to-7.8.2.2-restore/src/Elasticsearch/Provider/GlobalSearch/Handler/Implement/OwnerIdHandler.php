<?php
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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\Implement;

use Sugarcrm\Sugarcrm\Elasticsearch\Adapter\Document;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Mapping;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\AbstractHandler;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\ProcessDocumentHandlerInterface;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\MappingHandlerInterface;

/**
 *
 * Owner id field handler
 *
 */
class OwnerIdHandler extends AbstractHandler implements MappingHandlerInterface, ProcessDocumentHandlerInterface
{
    const OWNER_ID_FIELD = 'owner_id';

    /**
     * {@inheritdoc}
     */
    public function buildMapping(Mapping $mapping, $field, array $defs)
    {
        // add the field for the owner id
        $mapping->addNotAnalyzedField(self::OWNER_ID_FIELD);
    }

    /**
     * {@inheritdoc}
     */
    public function processDocumentPreIndex(Document $document, \SugarBean $bean)
    {
        // By default, it uses the value of 'created_by'
        if (!empty($bean->created_by)) {
            $ownerId = $bean->created_by;
        }

        // Override it if assigned_user_id has value
        if (isset($bean->field_defs['assigned_user_id'])) {
            if (!empty($bean->assigned_user_id)) {
                $ownerId = $bean->assigned_user_id;
            }
        }

        if (!empty($ownerId)) {
            $document->setDataField(self::OWNER_ID_FIELD, $ownerId);
        }
    }

}
