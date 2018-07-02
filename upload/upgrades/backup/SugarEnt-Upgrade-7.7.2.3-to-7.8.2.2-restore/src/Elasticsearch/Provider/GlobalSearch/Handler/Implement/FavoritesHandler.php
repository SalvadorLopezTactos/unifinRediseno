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
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\MappingHandlerInterface;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\ProcessDocumentHandlerInterface;

/**
 *
 * Favorites handler
 *
 */
class FavoritesHandler extends AbstractHandler implements
    MappingHandlerInterface,
    ProcessDocumentHandlerInterface
{
    /**
     * Favorites field used in index
     */
    const FAVORITE_FIELD = 'user_favorites';

    /**
     * {@inheritdoc}
     */
    public function buildMapping(Mapping $mapping, $field, array $defs)
    {
        if ($defs['type'] !== 'favorites') {
            return;
        }

        // field for denormalized ids
        $mapping->addNotAnalyzedField(self::FAVORITE_FIELD);
    }

    /**
     * {@inheritdoc}
     */
    public function processDocumentPreIndex(Document $document, \SugarBean $bean)
    {
        if (isset($bean->my_favorite)) {
            $document->setDataField(self::FAVORITE_FIELD, $this->getFavorites($bean));
        }
    }

    /**
     *
     * @param \SugarBean $bean
     * @return array
     */
    protected function getFavorites(\SugarBean $bean)
    {
        return \SugarFavorites::getUserIdsForFavoriteRecordByModuleRecord($bean->module_dir, $bean->id);
    }
}
