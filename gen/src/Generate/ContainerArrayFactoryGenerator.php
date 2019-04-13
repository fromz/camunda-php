<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 14/04/19
 * Time: 5:49 AM
 */

namespace Gen\Generate;


use Gen\Entity\Container;
use PhpParser\Builder\Class_;
use PhpParser\Builder\Method;
use PhpParser\BuilderFactory;
use PhpParser\Node;

class ContainerArrayFactoryGenerator
{
    public function generateArrayFactory(Container $container) : Method
    {
        $factory = new BuilderFactory;
        $ifAssignmentStatements = [];
        foreach ($container->getChildren() as $child) {
            $if = new Node\Stmt\If_(new Node\Expr\FuncCall(
                new Node\Name('array_key_exists'),
                [
                    new Node\Scalar\String_($child->getName()),
                    new Node\Expr\Variable('values')
                ]
            ), [
                'stmts' => [
                    new Node\Stmt\Expression(new Node\Expr\MethodCall(
                        new Node\Expr\Variable('container'),
                        'set' . ucfirst($child->getName()),
                        [
                            new Node\Expr\ArrayDimFetch(
                                new Node\Expr\Variable('values'),
                                new Node\Scalar\String_($child->getName())
                            ),
                        ]
                    )),
                ]
            ]);
            $ifAssignmentStatements[] = $if;
        }
        return $factory->method('fromArray')
            ->makePublic()
            ->makeStatic()
            ->addStmt(new Node\Expr\Assign(
                new Node\Expr\Variable('container'),
                new Node\Expr\New_(new Node\Name($container->getClass()))
            ))
            ->addParam($factory->param('values')->setType('array'))
            ->setReturnType($container->getClass())
            ->addStmts($ifAssignmentStatements)
            ->addStmt(
                new Node\Stmt\Return_(new Node\Expr\Variable('container'))
            );
    }
}