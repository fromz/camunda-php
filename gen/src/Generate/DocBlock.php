<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 12:05 PM
 */

namespace Gen\Generate;


class DocBlock
{
    private $comments = [];

    public function addComment(string $comment)
    {
        $this->comments[] = $comment;
    }

    public function generateDocBlock()
    {
        if (0 === count($this->comments)) {
            return null;
        }
        $db = '/**';
        foreach ($this->comments as $comment) {

            $db .= "\n * " . $comment;
        }
        $db .= "\n */";
        return $db;
    }
}