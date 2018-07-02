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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler;

use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\GlobalSearch;

/**
 *
 * Handler collection iterator
 *
 */
class HandlerCollection implements \IteratorAggregate
{
    /**
     * @var GlobalSearch
     */
    protected $provider;

    /**
     * @var HandlerInterface[]
     */
    protected $handlers;

    /**
     * Ctor
     * @param GlobalSearch $provider
     */
    public function __construct(GlobalSearch $provider)
    {
        $this->provider = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->handlers);
    }

    /**
     * Add handler
     * @param HandlerInterface $handler
     */
    public function addHandler(HandlerInterface $handler)
    {
        $handler->setProvider($this->provider);
        $this->handlers[] = $handler;
    }
}
