<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 14/04/19
 * Time: 5:49 AM
 */

namespace Gen\Generate;


use Gen\Entity\Container;
use PhpParser\Builder\Method;
use PhpParser\BuilderFactory;
use PhpParser\Node;

class ContainerToArrayGenerator
{
    public function generateToArrayMethod(Container $container) : Method
    {
        $factory = new BuilderFactory;
        $ifAssignmentStatements = [];
        foreach ($container->getChildren() as $child) {
            $if = new Node\Stmt\If_(new Node\Expr\BinaryOp\NotIdentical(
                new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $child->getName()),
                new Node\Expr\ConstFetch(new Node\Name('null'))
            ), [
                'stmts' => [
                    new Node\Stmt\Expression(new Node\Expr\Assign(
                        new Node\Expr\ArrayDimFetch(
                            new Node\Expr\Variable('json'),
                            new Node\Scalar\String_($child->getName())
                        ),
                        new Node\Expr\PropertyFetch(
                            new Node\Expr\Variable('this'),
                            new Node\Identifier($child->getName())
                        )
                    ))
                ]
            ]);
            $ifAssignmentStatements[] = $if;
        }
        return $factory->method('toArray')
            ->makePublic()
            ->addStmt(new Node\Expr\Assign(
                new Node\Expr\Variable('json'),
                new Node\Expr\Array_()
            ))
            ->addStmts($ifAssignmentStatements)
            ->addStmt(
                new Node\Stmt\Return_(new Node\Expr\Variable('json'))
            )
            ;
    }
}