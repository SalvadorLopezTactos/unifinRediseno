<?php
declare(strict_types=1);
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

namespace Sugarcrm\Sugarcrm\Security\ModuleScanner;

use PhpParser\Node;
use Sugarcrm\Sugarcrm\Security\ModuleScanner\Issues\DynamicallyNamedClassUsed;
use Sugarcrm\Sugarcrm\Security\ModuleScanner\Issues\DynamicallyNamedClassInstantiated;
use Sugarcrm\Sugarcrm\Security\ModuleScanner\Issues\DynamicallyNamedFunctionCalled;
use Sugarcrm\Sugarcrm\Security\ModuleScanner\Issues\DynamicallyNamedMethodCalled;
use Sugarcrm\Sugarcrm\Security\ModuleScanner\Issues\DynamicallyNamedStaticMethodCalled;

class DynamicNameVisitor extends ForbiddenStatementVisitor
{
    public function leaveNode(Node $node)
    {
        if ($node instanceof Node\Expr\MethodCall) {
            if ($node->name instanceof Node\Expr\Variable) {
                $this->issues[] = new DynamicallyNamedMethodCalled($node->getLine());
            }
        } elseif ($node instanceof Node\Expr\FuncCall) {
            if ($node->name instanceof Node\Expr\Variable) {
                $this->issues[] = new DynamicallyNamedFunctionCalled($node->getLine());
            }
        } elseif ($node instanceof Node\Expr\StaticCall) {
            $class = $node->class;
            $method = $node->name;
            if ($class instanceof Node\Expr\Variable) {
                $this->issues[] = new DynamicallyNamedClassUsed($node->getLine());
            }
            if ($method instanceof Node\Expr\Variable) {
                $this->issues[] = new DynamicallyNamedStaticMethodCalled($node->getLine());
            }
        } elseif ($node instanceof Node\Expr\New_) {
            if ($node->class instanceof Node\Expr\Variable) {
                $this->issues[] = new DynamicallyNamedClassInstantiated($node->getLine());
            }
        }
    }
}
