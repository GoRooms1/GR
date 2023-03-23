<?php
declare(strict_types=1);

namespace Utils\PHPStan;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;

final class NoBusinessLogicInController implements \PHPStan\Rules\Rule
{
    public function __construct(
        private readonly ControllerDetermination $determination
    )
    {
    }

    public function getNodeType(): string
    {
        return Class_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $className = (string) $node->namespacedName;

        if (
            !$this->determination->isController($className)
        ) {
            return [];
        }

        $methods = $node->getMethods();

        foreach ($methods as $method) {
            $stmts = $method->getStmts();

            foreach ($stmts as $stmt) {
                if ($stmt instanceof Node\Stmt\If_
                    || $stmt instanceof Node\Stmt\While_
                    || $stmt instanceof Node\Stmt\For_
                    || $stmt instanceof Node\Stmt\Foreach_
                    || $stmt instanceof Node\Stmt\Switch_
                ) {
                    return [
                        RuleErrorBuilder::message(sprintf(
                            'Method %s in controller %s contains business logic. Move it to a dedicated service or repository.',
                            $method->name->toString(),
                            $className
                        ))->build()
                    ];
                }
            }
        }

        return [];
    }
}