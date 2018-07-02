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

use Sugarcrm\Sugarcrm\Elasticsearch\Analysis\AnalysisBuilder;
use Sugarcrm\Sugarcrm\Elasticsearch\Adapter\Document;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Mapping;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Property\ObjectProperty;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Property\MultiFieldBaseProperty;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Property\MultiFieldProperty;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\SearchFields;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\GlobalSearch;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\AbstractHandler;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\AnalysisHandlerInterface;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\MappingHandlerInterface;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\SearchFieldsHandlerInterface;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\ProcessDocumentHandlerInterface;
use Sugarcrm\Sugarcrm\Elasticsearch\Query\QueryBuilder;

/**
 *
 * Email Address Handler
 *
 */
class EmailAddressHandler extends AbstractHandler implements
    AnalysisHandlerInterface,
    MappingHandlerInterface,
    SearchFieldsHandlerInterface,
    ProcessDocumentHandlerInterface
{
    /**
     * Multi field definitions
     * @var array
     */
    protected $multiFieldDefs = array(
        'gs_email' => array(
            'type' => 'string',
            'index' => 'analyzed',
            'index_analyzer' => 'gs_analyzer_email',
            'search_analyzer' => 'gs_analyzer_email',
            'store' => true,
        ),
        'gs_email_wildcard' => array(
            'type' => 'string',
            'index' => 'analyzed',
            'index_analyzer' => 'gs_analyzer_email_ngram',
            'search_analyzer' => 'gs_analyzer_email',
            'store' => true,
        ),
    );

    /**
     * Weighted boost definition
     * @var array
     */
    protected $weightedBoost = array(
        // we dont need to specify gs_email_primary
        'gs_email_wildcard_primary' => 0.45,
        'gs_email_secondary' => 0.75,
        'gs_email_wildcard_secondary' => 0.25,
    );

    /**
     * Highlighter field definitions
     * @var array
     */
    protected $highlighterFields = array(
        '*.gs_email' => array(
            'number_of_fragments' => 0,
        ),
        '*.gs_email_wildcard' => array(
            'number_of_fragments' => 0,
        ),
    );

    /**
     * Field name to use for email search
     * @var string
     */
    protected $searchField = 'email_search';

    /**
     * {@inheritdoc}
     */
    public function setProvider(GlobalSearch $provider)
    {
        parent::setProvider($provider);

        $provider->addSupportedTypes(array('email'));
        $provider->addHighlighterFields($this->highlighterFields);
        $provider->addWeightedBoosts($this->weightedBoost);

        // As we are searching against email_search field, we want to remap the
        // highlights from that field back to the original email field.
        $provider->addFieldRemap(array($this->searchField => 'email'));

        // enable adding tags in the response's highlight values
        $provider->setWrapValueWithTags(array('email' => true));

        // We don't want to add the email field to the queuemanager query
        // because we will populate the emails seperately.
        $provider->addSkipTypesFromQueue(array('email'));
    }

    /**
     * {@inheritdoc}
     */
    public function buildAnalysis(AnalysisBuilder $analysisBuilder)
    {
        $analysisBuilder
            ->addCustomAnalyzer(
                'gs_analyzer_email',
                'uax_url_email',
                array('lowercase')
            )
            ->addCustomAnalyzer(
                'gs_analyzer_email_ngram',
                'standard',
                array('lowercase', 'gs_filter_ngram_1_15')
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildMapping(Mapping $mapping, $field, array $defs)
    {
        // We only handle 'email' fields of 'email' type
        if ($defs['name'] !== 'email' || $defs['type'] !== 'email') {
            return;
        }

        // Use original field to store the raw json content
        $baseObject = new ObjectProperty();
        $baseObject->setEnabled(false);
        $mapping->addObjectProperty($field, $baseObject);

        // Prepare multifield
        $email = new MultiFieldBaseProperty();
        foreach ($this->multiFieldDefs as $multiField => $defs) {
            $multiFieldProp = new MultiFieldProperty();
            $multiFieldProp->setMapping($defs);
            $email->addField($multiField, $multiFieldProp);
        }

        // Additional field holding both primary/secondary addresses
        $searchField = new ObjectProperty();
        $searchField->addProperty('primary', $email);
        $searchField->addProperty('secondary', $email);

        $searchFieldName = $mapping->getModule() . QueryBuilder::PREFIX_SEP . $this->searchField;
        $mapping->addObjectProperty($searchFieldName, $searchField);
        $mapping->excludeFromSource($searchFieldName);
    }

    /**
     * {@inheritdoc}
     */
    public function buildSearchFields(SearchFields $sf, $module, $field, array $defs)
    {
        // We only handle 'email' fields of 'email' type
        if ($defs['name'] !== 'email' || $defs['type'] !== 'email') {
            return;
        }

        $emailFields = array('primary', 'secondary');
        $multiFields = array('gs_email', 'gs_email_wildcard');

        foreach ($emailFields as $emailField) {
            foreach ($multiFields as $multiField) {
                $searchFieldName = $module . QueryBuilder::PREFIX_SEP . $this->searchField;
                $path = array($searchFieldName, $emailField, $multiField);
                $weightId = $multiField . '_' . $emailField;
                $sf->addSearchField($module, $path, $defs, $weightId);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedTypes()
    {
        return array('email');
    }

    /**
     * {@inheritdoc}
     */
    public function processDocumentPreIndex(Document $document, \SugarBean $bean)
    {
        // skip if there is no email field
        if (!isset($bean->field_defs['email'])) {
            return;
        }

        // Load raw email addresses in email field to store in ES
        $emails = $this->getEmailAddressesForBean($bean);
        $document->setDataField('email', $emails);

        // Format data for email search fields
        $value = array(
            'primary' => '',
            'secondary' => array(),
        );

        foreach ($emails as $emailAddress) {
            if (!empty($emailAddress['primary_address'])) {
                $value['primary'] = $emailAddress['email_address'];
            } else {
                $value['secondary'][] = $emailAddress['email_address'];
            }
        }

        // Set formatted value in special email search field
        $searchField = $document->getType() . QueryBuilder::PREFIX_SEP . $this->searchField;
        $document->setDataField($searchField, $value);
    }

    /**
     * Get list of email address for given bean
     * @param \SugarBean $bean
     * @return array
     */
    protected function getEmailAddressesForBean(\SugarBean $bean)
    {
        /*
         * Beans extending Person or Company template should have this
         * set automatically. Beans using email addresses without extending
         * from those templates are not supported.
         */
        if (!isset($bean->emailAddress) || !$bean->emailAddress instanceof \SugarEmailAddress) {
            return array();
        }

        // Fetch email addresses from database if needed
        if (empty($bean->emailAddress->hasFetched)) {
            return $this->fetchEmailAddressesFromDatabase($bean);
        }

        return $bean->emailAddress->addresses;
    }

    /**
     * Fetch email addresses from database
     * @param \SugarBean $bean
     * @return array
     */
    protected function fetchEmailAddressesFromDatabase(\SugarBean $bean)
    {
        return \BeanFactory::getBean('EmailAddresses')->getAddressesByGUID($bean->id, $bean->module_name);
    }
}
