<?php

namespace Romano\Framework\Exception;

use Throwable;

class UnknownObjectException extends \Exception
{
    public function __construct(string $engine, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Cannot instantiate a unknown object of class %s', $engine),
            $code,
            $previous
        );
    }
}