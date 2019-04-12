<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 12/04/19
 * Time: 1:11 PM
 */

namespace Gen;

use PhpParser\PrettyPrinter;
use PhpParser\Builder\Namespace_;

class ClassTypeWriter
{

    /**
     * @var string
     */
    private $src;

    public function __construct(string $src)
    {
        $this->src = $src;
    }

    private function removeFirstNamespacePart($namespace)
    {
        $parts = explode('\\', $namespace);
        array_shift($parts);
        return implode('\\', $parts);
    }

    public function write(ClassTypeInterface $classType, Namespace_ $namespace) : string
    {
        // Write the contents to disk
        $stmts = array($namespace->getNode());
        $prettyPrinter = new PrettyPrinter\Standard();
        $fileContents = $prettyPrinter->prettyPrintFile($stmts);
        $destinationDir = sprintf(
            '%s/%s',
            $this->src,
            str_replace('\\', '/', $this->removeFirstNamespacePart($classType->getNamespace()))
        );
        $destinationFullFilepath = sprintf('%s/%s.php', $destinationDir, $classType->getClass());
        if (false === file_exists($destinationDir)) {
            mkdir($destinationDir, 0777, true);
        }
        file_put_contents($destinationFullFilepath, $fileContents);
        return $destinationFullFilepath;
    }
}