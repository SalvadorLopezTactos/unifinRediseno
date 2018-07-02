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

namespace Sugarcrm\Sugarcrm\JobQueue\Serializer;

use Sugarcrm\Sugarcrm\JobQueue\Workload\WorkloadInterface;

/**
 * Class Serializer
 * @package JobQueue
 */
class Serializer implements SerializerInterface
{
    /**
     * Serializes data and encodes data to base64.
     * {@inheritdoc}
     */
    public function serialize(WorkloadInterface $data)
    {
        return base64_encode(serialize($data));
    }

    /**
     * Decodes data from base64 and unserializes it.
     * {@inheritdoc}
     */
    public function unserialize($data)
    {
        return unserialize(base64_decode($data));
    }
}
