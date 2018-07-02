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

namespace Sugarcrm\Sugarcrm\JobQueue\Handler;

use Sugarcrm\Sugarcrm\JobQueue\Dispatcher\DispatcherInterface;

/**
 * Class HandlerRegistry
 * @package JobQueue
 */
class HandlerRegistry implements \IteratorAggregate
{
    /**
     * @var array $registry Of handlers [['class', 'dispatcher', 'name'], ...] in lower case.
     */
    protected $registry = array();

    /**
     * Add a handler's data to registry.
     * Classes should implement 'Sugarcrm\Sugarcrm\JobQueue\Handler\RunnableInterface'
     *
     * @param string $name Handler name.
     * @param string $class Full class name with namespace.
     * @param DispatcherInterface $dispatcher
     */
    public function add($name, $class, $dispatcher)
    {
        $this->registry[strtolower($name)] = array(
            'class' => $class,
            'dispatcher' => $dispatcher,
            'name' => $name,
        );
    }

    /**
     * Get registered handler. Search is case insensitive.
     *
     * @param $name
     * @return array|null [['class', 'dispatcher', 'name'], ...]
     */
    public function get($name)
    {
        $name = strtolower($name);
        return isset($this->registry[$name]) ? $this->registry[$name] : null;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->registry);
    }
}
