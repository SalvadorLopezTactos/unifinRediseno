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

namespace Sugarcrm\Sugarcrm\JobQueue\Adapter;

use Sugarcrm\Sugarcrm\JobQueue\Exception\LogicException;

/**
 * Class AdapterRegistry
 * @package JobQueue
 */
class AdapterRegistry implements \IteratorAggregate
{
    /**
     * @var array $registry Of adapters ['name' => 'AdapterInterface', ...] in lower case.
     */
    protected $registry = array();

    /**
     * Register an adapter.
     * Currently only message queue interface is supported.
     *
     * @param string $name Adapter name.
     * @param string $class Full class name with namespace.
     * @throws LogicException
     */
    public function add($name, $class)
    {
        // Gearman is a real job server, register it without checking.
        if (strtolower($name) != 'gearman') {
            $interfaces = class_implements($class);
            if (!in_array('Sugarcrm\Sugarcrm\JobQueue\Adapter\MessageQueue\AdapterInterface', $interfaces)) {
                throw new LogicException('Adapter should implement AdapterInterface.');
            }
        }
        $this->registry[strtolower($name)] = $class;
    }

    /**
     * Get registered adapter. Search is case insensitive.
     *
     * @param string $name
     * @return string|null Adapter class.
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
