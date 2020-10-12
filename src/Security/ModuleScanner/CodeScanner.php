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

use PhpParser\Error;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserFactory;
use Sugarcrm\Sugarcrm\Security\ModuleScanner\Issues\Issue;
use Sugarcrm\Sugarcrm\Security\ModuleScanner\Issues\SyntaxError;

class CodeScanner
{

    private $classesBlackList;
    private $functionsBlackList;
    private $methodsBlackList;

    public function __construct(array $classesBlackList, array $functionsBlackList, array $methodsBlackList)
    {
        $this->classesBlackList = $classesBlackList;
        $this->functionsBlackList = $functionsBlackList;
        $this->methodsBlackList = $methodsBlackList;
    }

    /**
     * @throws Error
     * @return  Issue[]
     */
    public function scan(string $code): array
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $traverser = new NodeTraverser;
        $dynamicNameVisitor = new DynamicNameVisitor();
        $blacklistVisitor = new BlacklistVisitor($this->classesBlackList, $this->functionsBlackList, $this->methodsBlackList);
        $traverser->addVisitor(new NameResolver());
        $traverser->addVisitor($dynamicNameVisitor);
        $traverser->addVisitor($blacklistVisitor);
        try {
            $stmts = $parser->parse($code);
        } catch (Error $error) {
            return [new SyntaxError($error)];
        }
        $traverser->traverse($stmts);

        return array_merge($dynamicNameVisitor->getIssues(), $blacklistVisitor->getIssues());
    }
}
