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

namespace Sugarcrm\Sugarcrm\Security\Validator;

use Sugarcrm\Sugarcrm\Security\Validator\ConstraintReturnValueInterface;
use Symfony\Component\Validator\Constraint;

/**
 *
 * Abstract constraint object supporting formatted return values which can be
 * used by contraint validators to set altered validated valutes.
 *
 * From ConstraintValidator set the formatted value when validation passess:
 *
 *      `$constraint->setFormattedReturnValue($value)`
 *
 */
abstract class ConstraintReturnValue extends Constraint implements ConstraintReturnValueInterface
{
    /**
     * @var mixed
     */
    protected $formattedReturnValue;

    /**
     * {@inheritdoc}
     */
    public function getFormattedReturnValue()
    {
        return $this->formattedReturnValue;
    }

    /**
     * {@inheritdoc}
     */
    public function setFormattedReturnValue($value)
    {
        $this->formattedReturnValue = $value;
    }
}
