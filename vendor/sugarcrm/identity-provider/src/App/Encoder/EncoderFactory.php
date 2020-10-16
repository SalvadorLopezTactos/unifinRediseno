<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
namespace Sugarcrm\IdentityProvider\App\Encoder;

use Sugarcrm\IdentityProvider\App\Application;

use Symfony\Component\Security\Core\Encoder\EncoderFactory as BaseFactory;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Supports legacy md5 passwords
 * @package Sugarcrm\IdentityProvider\App\Encoder
 */
class EncoderFactory extends BaseFactory implements EncoderFactoryInterface
{
    protected $app;

    public function __construct(array $encoders, Application $app)
    {
        parent::__construct($encoders);
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function getEncoder($user)
    {
        return parent::getEncoder($this->app['config']['local']['legacy_md5_support'] ? 'legacy_md5_support' : $user);
    }
}
